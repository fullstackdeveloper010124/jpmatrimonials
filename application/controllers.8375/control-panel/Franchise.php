<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Franchise extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->admin_path = $this->common_model->getconfingValue('admin_path');
		$this->data['admin_path'] = $this->admin_path;
		$this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->load->model('back_end/login_model');
		//$this->common_model->check_admin_only_access();
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');
		$this->load->model('back_end/sales_report_model','sales_report_model');
		$this->load->model('back_end/Member_model','member_model');
	}

	public function index()
	{
		$is_login = $this->common_model->checkLogin('return');
		$user_type = $this->common_model->get_session_user_type();
		if($is_login)
		{
			if($user_type =='admin')
			{
				$this->franchise_list();
			}
			else
			{
				redirect($this->base_url_admin.'dashboard');
			}
		}
		else
		{
			$this->login();
		}
	}
	public function access($id ='')
	{
		$this->common_model->check_admin_only_access();
		if($id !='')
		{
			$where_arra = array('id'=>$id,'is_deleted'=>'No');
			$row_data = $this->common_model->get_count_data_manual('franchise',$where_arra,1);
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				$login_dt = $this->common_model->getCurrentDate();
				$status  = 'success';
				$this->db->set('last_login', $login_dt);
				$ip = $this->input->ip_address();
				$where_arra = array(
					'id'=>$row_data['id']
				);
				$data_array = array('last_login'=>$login_dt,'ip_address'=>$ip);
				$row_data1 = $this->common_model->update_insert_data_common('franchise', $data_array, $where_arra);
				$user_type ='franchise';
				$row_data['user_type'] = $user_type;
				$this->session->set_userdata('matrimonial_user_data', $row_data);
				redirect($this->base_url_admin.'dashboard');
				exit;
			}
		}
		redirect($this->base_url_admin.'franchise/franchise-list');
	}
// for admin  use only		
	public function franchise_list($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access();
		$this->clear_filter('no');
		$ele_array = array(
			'username'=>array('is_required'=>'required'),
			'email'=>array('is_required'=>'required','input_type'=>'email','check_duplicate'=>'Yes'),
			'password'=>array('is_required'=>'required','type'=>'password'),
			'mobile'=>array('is_required'=>'required','type'=>'mobile'),
			//'mobile'=>array('is_required'=>'required','input_type'=>'number','other'=>"minlength='8' maxlength='12'"),
			'commission'=>array('is_required'=>'required','input_type'=>'number','other'=>"min='0' max='100'"),
			'status'=>array('type'=>'radio')
		);
		
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','c_password','ip_address');
		$btn_arr = array(
			array('url'=>'franchise/show-franchise-member/#id#','class'=>'info','label'=>'View Member'),
			/*array('url'=>'franchise/access/#id#','class'=>'info','label'=>'Access','onClick'=>"return confirm('Access this franchise your session will timeout.');"),*/
			array('url'=>'franchise/login/1','class'=>'info','label'=>'Access','target'=>'_blank'),
			
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		if(isset($_REQUEST['password']) && $_REQUEST['password'] =='' && isset($_REQUEST['mode']) && $_REQUEST['mode'] =='edit')
		{
			unset($_REQUEST['password']);
		}
		$other_config = array('default_order'=>'desc','field_duplicate'=>array('email'),'data_tab_btn'=>$btn_arr);
		if(isset($_REQUEST['email']) && $_REQUEST['email'] !='')
		{
			if(isset($_REQUEST['mode']) && $_REQUEST['mode']!='edit'){
				$email_temp_data = $this->common_front_model->getemailtemplate('Referral Link');
				$email_content = $email_temp_data['email_content'];
				$email_subject = $email_temp_data['email_subject'];
				$config_arra = $this->common_model->get_site_config();
				$web_name = $config_arra['web_name'];
				$webfriendlyname = $config_arra['web_frienly_name'];
				$ref_code = substr(uniqid(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ")), -10);
				$ref_link = $this->base_url."register/franchise/".$ref_code;
				$data_array = array('webfriendlyname'=>$webfriendlyname,'REF_LINK'=>$ref_link);
				$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);
				$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
				$email = $_REQUEST['email'];
				if(isset($email) && $email!=''){
					$this->common_model->common_send_email($email,$email_subject,$email_content);
				}
				$_REQUEST['referral_link']=$ref_link;
			}
		}
		else
		{
			unset($other_config['field_duplicate']);
		}
		$this->common_model->common_rander('franchise', $status, $page , 'Franchise',$ele_array,'created_on',0,$other_config);
	}
	public function show_franchise_member($id ='')
	{
		$this->common_model->check_admin_only_access();
		$this->load->model('back_end/Member_model','member_model');
		$_SERVER["REQUEST_METHOD"] = "POST";
		$_POST['list_franchise'] = array($id);
		$this->session->set_userdata('franchise_member_id',$id);
		$p = $this->input->post('list_franchise');
		$this->member_model->save_session_search();
		redirect($this->common_model->base_url_admin.'franchise/franchise-member');
	}
	public function franchise_member($status='ALL', $page=1, $clear_search='no')
	{
		$this->common_model->check_admin_only_access();
		$this->load->model('back_end/Member_model','member_model');
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
			$this->session->unset_userdata('franchise_member_id');
		}
		$this->common_model->status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Paid'=>'Paid','Suspended'=>'Suspended');
		$this->common_model->status_arr_change = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Suspended'=>'Suspended');
		$this->member_model->is_franchise = 'yes';
		$personal_where = array();
		$frnch_id = $this->session->userdata('franchise_member_id');
		$where_id = '';
		if(isset($frnch_id) && $frnch_id!=''){
			$where_id = 'franchised_by="'.$frnch_id.'" and ';
		}
		
		$personal_where['where_per'] = "$where_id (franchised_by !='' and franchised_by !='0') ";
		if(isset($status) && $status === 'Paid'){
			$this->common_model->status_field = 'plan_status';
		}
		$personal_where['label_disp'] = "Franchise Member";
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	public function search_model()
	{
		$this->load->model('back_end/Member_model','member_model');
		$this->member_model->save_session_search();
	}
	public function clear_filter($return='yes')
	{
		$this->load->model('back_end/Member_model','member_model');
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	
	//for franchise login and forget password
	public function login($flag = 0)
	{
		$this->login_model->table_name = 'franchise';
		if($flag == 0)
		{
			if($this->session->userdata('matrimonial_user_data') && $this->session->userdata('matrimonial_user_data') !="" && count($this->session->userdata('matrimonial_user_data')) >0 )
			{
				redirect($this->base_url_admin.'dashboard');
			}
		}
		$this->data['page_title'] = '';
		$this->data['is_franchise'] = 'yes';
		$this->data['config_data'] = $this->common_model->get_site_config();
		
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('captcha_code',$code);
		// generate captcha
		
		//$this->load->view('admin/page_part/header',$this->data);
		$this->load->view('back_end/login_view',$this->data);
	}
	public function validate_captcha()
	{
		$this->login_model->table_name = 'franchise';
		
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}
	public function check_login()
	{
		$this->login_model->table_name = 'franchise';
	  	$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email ID or Matri ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha');

		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
			}
		}
		else
		{
			$return_arr = $this->login_model->check_login();
			$data['data'] = json_encode($return_arr);
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if($return_arr['status'] == 'success')
			{
				if($this->session->userdata('captcha_code'))
				{
					$this->session->unset_userdata('captcha_code');
				}
				redirect($this->base_url_admin.'dashboard');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url_admin.'franchise/login');
			}
		}
	}
	public function log_out($per='')
	{
		$this->login_model->table_name = 'franchise';
		
		if($this->session->userdata('matrimonial_user_data'))
		{
			$this->session->unset_userdata('matrimonial_user_data');
		}
		$this->session->unset_userdata('time_zone');
		$this->session->set_flashdata('user_log_out', 'You have successfully logged out');
		redirect($this->base_url_admin.'franchise/login');
	}
	public function forgot_password()
	{
		$this->login_model->table_name = 'franchise';
		
		if($this->session->userdata('matrimonial_user_data') && $this->session->userdata('matrimonial_user_data') !="" && count($this->session->userdata('matrimonial_user_data')) >0 )
		{
			redirect($this->base_url.'search');
		}
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('for_captcha_code',$code);
		// generate captcha
		$this->data['page_title'] = '';
		$this->data['config_data'] = $this->common_model->get_site_config();
		$this->data['is_franchise'] = 'yes';
		$this->load->view('back_end/forgot_password',$this->data);
	}
	public function validate_captcha_for()
	{
		$this->login_model->table_name = 'franchise';
		
		if($this->input->post('code_captcha') != $this->session->userdata['for_captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha_for', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	
	}
	public function check_email_forgot()
	{
		$this->login_model->table_name = 'franchise';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha_for');
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$data['data'] = $this->login_model->check_reset_forgot_password();
		}
		$this->load->view('common_file_echo',$data);
	}
	public function reset_password($password='',$email='')
	{
		$this->login_model->table_name = 'franchise';
		
		if($password !='' && $email !='')
		{
			$response = $this->login_model->check_reset_link($password,$email);
			if($response =='success')
			{
				$this->data['page_title'] = '';
				$this->data['is_franchise'] = 'yes';
				$this->data['config_data'] = $this->common_model->get_site_config();
				$this->load->view('back_end/reset_password',$this->data);
			}
			else
			{
				redirect($this->base_url_admin.'franchise/login');
			}
		}
		else
		{
			redirect($this->base_url_admin.'franchise/login');
		}
	}
	public function reset_update()
	{
		$this->login_model->table_name = 'franchise';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'New Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
			}
		}
		else
		{
			$return_arr = $this->login_model->reset_update_pass();
			if($return_arr['status'] == 'success')
			{
				$this->session->unset_userdata('email_reset');
			}
			$data['data'] = json_encode($return_arr);
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if($return_arr['status'] == 'success')
			{
				$this->session->set_flashdata('user_log_out', $return_arr['errmessage']);
				redirect($this->base_url_admin.'franchise/login');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url_admin.'franchise/login');
			}
		}
	}

	





	public function franchise_assign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'statusChangeAllow'=>'no',
			'personal_where'=>" member_id!='' and action = 'Assign' and user_type ='Franchise' ",
		);
		if($clear_filter == 'yes'){
			$this->clear_filter_franchise_report('no');
		}
		$this->common_model->primary_key = 'assign_id';
		$this->common_model->created_on_fild = 'assign_date';
		$this->common_model->labelArr =  array('assign_to_name'=>'Assign To');
		//'assign_by','assign_by_email',
		$this->common_model->display_selected_field = array('matri_id','username','email','assign_to_name','assign_date');
		$this->common_model->common_rander('member_assign_history_view', $status, $page, 'Assigned Members To Franchise','','assign_date',0,$other_config,'');
	}
	public function franchise_unassign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$this->common_model->primary_key ='member_id';
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->staffassign_arr_change = array();
		$this->common_model->franchiseassign_arr_change = array('Assign_Franchise'=>'Assign Franchise');
		if($clear_filter == 'yes')
		{
			$this->clear_filter_franchise_report('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " member_id!='' and user_type = 'Franchise' and action='Unassigned' ";
		
		$this->assignment_reports_model->unassigned_member_list($status,$page,$personal_where,'franchise');
	}
	
	public function franchise_lead_assign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'statusChangeAllow'=>'no',
			'personal_where'=>" lead_generation_id!='' and action = 'Assign' and user_type ='Franchise' ",
		);
		if($clear_filter == 'yes'){
			$this->clear_filter_franchise_report('no');
		}
		$this->common_model->primary_key = 'assign_id';
		$this->common_model->created_on_fild = 'assign_date';
		$this->common_model->labelArr =  array('assign_to_name'=>'Assign To');
		//'assign_by','assign_by_email',
		$this->common_model->display_selected_field = array('id','username','email','assign_to_name','assign_date');
		$this->common_model->common_rander('lead_generation_assign_history_view', $status, $page, 'Assigned Lead Generation To Franchise','','assign_date',0,$other_config,'');
	}
	
	public function franchise_lead_unassign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$this->common_model->primary_key ='lead_generation_id';
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->staffassign_arr_change = array();
		$this->common_model->franchiseassign_arr_change = array('Assign_Franchise'=>'Assign Franchise');
		if($clear_filter == 'yes')
		{
			$this->clear_filter_franchise_report('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " lead_generation_id!='' and user_type = 'Franchise' and action='Unassigned' ";
		$this->common_model->member_or_lead = 'lead_generation';
		$this->assignment_reports_model->unassigned_lead_generation_list($status,$page,$personal_where,'franchise');
	}
	public function search_model_franchise()
	{
		$this->assignment_reports_model->save_session_search();
	}
	public function search()
	{
		$this->assignment_reports_model->save_session_search();
		redirect($this->common_model->base_url_admin.'member/advanced-search-result');
	}
	public function clear_filter_franchise_report($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	public function franchise_sales_report($status ='ALL', $page =1,$clear_search='no')
	{
		$this->common_model->check_admin_only_access();
		if($clear_search =='yes')
		{
			$this->clear_filter_franchise_sales_report('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " (franchise_id !='' and franchise_id !='0') ";
		$personal_where['label_disp'] = "Franchise Sales Report";
		$personal_where['table_Name'] = "payments_view";
		$personal_where['disp_column_array'] = array('plan_name','email','payment_mode','plan_activated','plan_expired','plan_duration','plan_amount','grand_total','franchise_comm_per','franchise_comm_amt','franchise_name','franchise_email','current_plan');
		
		$this->sales_report_model->list_model($status,$page,$personal_where);
	}
	public function clear_filter_franchise_sales_report($return='yes')
	{
		if($this->sales_report_model->session_search_name !='')
		{
			$session_search_name = $this->sales_report_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	
//for franchise login and forget password
}