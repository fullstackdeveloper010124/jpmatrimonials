<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Staff extends CI_Controller {
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
		
	//	$this->common_model->check_admin_only_access();
		//$this->common_model->checkLogin();
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');
	}
	public function index()
	{
		$is_login = $this->common_model->checkLogin('return');
		$user_type = $this->common_model->get_session_user_type();
		if($is_login)
		{
			if($user_type =='admin')
			{
				$this->staff_list();
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
			$row_data = $this->common_model->get_count_data_manual('staff',$where_arra,1);
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
				$row_data1 = $this->common_model->update_insert_data_common('staff', $data_array, $where_arra);
				$user_type ='staff';
				$row_data['user_type'] = $user_type;
				$this->session->set_userdata('matrimonial_user_data', $row_data);
				redirect($this->base_url_admin.'dashboard');
				exit;
			}
		}
		redirect($this->base_url_admin.'staff/staff_list');
	}
// for admin  use only	
	public function staff_list($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access();
		$this->common_model->checkLogin(); // here check for login or not
		$ele_array = array(
			'username'=>array('is_required'=>'required'),
			'email'=>array('is_required'=>'required','input_type'=>'email'),
			'password'=>array('is_required'=>'required','type'=>'password'),
			'mobile'=>array('is_required'=>'required','type'=>'mobile'),
			'role'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'staff_role','key_val'=>'id','key_disp'=>'role_name')),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','c_password','ip_address');
		if(isset($_REQUEST['password']) && $_REQUEST['password'] =='' && isset($_REQUEST['mode']) && $_REQUEST['mode'] =='edit')
		{
			unset($_REQUEST['password']);
		}
		$btn_arr = array(
			//array('url'=>'staff/access/#id#','class'=>'info','onClick'=>"return confirm_staff_access()",'label'=>'Access'),
			array('url'=>'staff/login/1','class'=>'info','label'=>'Access','target'=>'_blank'),
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$join_tab_array = array();
		$join_tab_array[] = array( 'rel_table'=>'staff_role', 'rel_filed'=>'id', 'rel_filed_disp'=>'role_name','rel_filed_org'=>'role');
		
		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('image'),'default_order'=>'desc','field_duplicate'=>array('email','mobile'),'data_tab_btn'=>$btn_arr);
		if(isset($_REQUEST['email']) && $_REQUEST['email'] !='')
		{
			
		}
		else
		{
			unset($other_config['field_duplicate']);
		}
		$this->common_model->common_rander('staff', $status, $page , 'Staff',$ele_array,'created_on',0,$other_config,$join_tab_array);
	}
	public function staff_role($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access(); // here check for login or not
		$this->common_model->labelArr['send_mail'] = 'Send Email and SMS';
		$this->common_model->labelArr['id_proof_approval'] = 'ID Proof Approval';
		$yes_no_arr = array('Yes'=>'Yes','No'=>'No');
		$all_per_no = array('Yes'=>'Yes','No'=>'No','Never'=>'No');
		$all_own_no_arr = array('All Members'=>'All Members','Own Members'=>'Own Members','No'=>'No');
		$class_pref = 'radio_view_member';
		$ele_array = array(
			'role_name'=>array('is_required'=>'required'),
			'status'=>array('type'=>'radio'),
			'add_member'=>array('type'=>'radio','value_arr'=>$yes_no_arr,'value'=>'Yes'),
			'view_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','onclick'=>"show_hide_option_rad('view_member')"),
			'edit_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'delete_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'view_profile'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'unapprove_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'approve_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			//'unapprove_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'approve_to_paid_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'suspend_member'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'add_comment'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref,'label'=>'Add Comment To Member'),
			'view_comment'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref,'label'=>'View Comment To Member'),
			
			'add_lead_generation'=>array('type'=>'radio','value_arr'=>$yes_no_arr,'value'=>'Yes'),
			'view_lead_generation'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','onclick'=>"show_hide_option_rad('view_lead_generation')"),
			'lead_generation_add_comment'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref,'label'=>'Add Comment To Lead Generation'),
			'lead_generation_view_comment'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref,'label'=>'View Comment To Lead Generation'),
			
			'edit_plan'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			'renew_plan'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>$class_pref),
			
			'match_making'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members'),
			//'send_mail'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','label'=>'Send Mail and SMS'),
			'send_bulk_email_and_sms'=>array('type'=>'radio','value_arr'=>$yes_no_arr,'label'=>'Send Bulk Email and SMS','value'=>'Yes'),
			'advanced_search'=>array('type'=>'radio','value_arr'=>$yes_no_arr,'value'=>'Yes'),
			'photo_approval'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','label'=>'Photo(s) Approval','onclick'=>"show_hide_option_rad('photo_approval')"),
			'photo_delete'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','label'=>'Photo(s) Delete','class_con_val'=>'radio_photo_approval'),
			'horoscope_approval'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','onclick'=>"show_hide_option_rad('horoscope_approval')"),
			'horoscope_delete'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>'radio_horoscope_approval'),
			'id_proof_approval'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','onclick'=>"show_hide_option_rad('id_proof_approval')"),
			'id_proof_delete'=>array('type'=>'radio','value_arr'=>$all_own_no_arr,'value'=>'All Members','class_con_val'=>'radio_id_proof_approval'),
		);
		
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$btn_arr = array(
			array('url'=>'staff/staff-role/edit-data/#id#','class'=>'info','label'=>'Edit Staff Role'),
		);
		$this->common_model->labelArr = array('add_comment'=>'Add Comment To Member','view_comment'=>'View Comment To Member','lead_generation_add_comment'=>'Add Comment To Lead Generation','lead_generation_view_comment'=>'View Comment To Lead Generation');
		$data_table = array(
			'title_disp'=>'role_name',
			'disp_column_array'=> array('view_member','add_member','edit_member','delete_member','view_profile','unapprove_member','approve_member','approve_to_paid_member','suspend_member','add_comment','view_comment','view_lead_generation','add_lead_generation','lead_generation_add_comment','lead_generation_view_comment','edit_plan','renew_plan','match_making','advanced_search','send_bulk_email_and_sms','photo_approval','photo_delete','horoscope_approval','horoscope_delete','id_proof_approval','id_proof_delete')
		);
		$data_table['disp_column_array'][] = 'created_on';
		$data_table['disp_column_array'][] = 'assign_mplan_to_listing';
		$other_config = array('hide_display_image'=>'No','load_member'=>'yes','data_table_mem'=>$data_table,'data_tab_btn'=>$btn_arr,'default_order'=>'DESC','field_duplicate'=>array('role_name'));
		$this->common_model->common_rander('staff_role', $status, $page , 'Staff Role',$ele_array,'created_on',0,$other_config);
	}
// for admin use only

//for satff login and forget password
	public function login($flag = 0)
	{
		$this->login_model->table_name = 'staff';
		if($flag == 0)
		{
			if($this->session->userdata('matrimonial_user_data') && $this->session->userdata('matrimonial_user_data') !="" && count($this->session->userdata('matrimonial_user_data')) >0 )
			{
				redirect($this->base_url_admin.'dashboard');
			}
		}
		$this->data['page_title'] = '';
		$this->data['is_staff'] = 'yes';
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
		$this->login_model->table_name = 'staff';
		
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
		$this->login_model->table_name = 'staff';
		
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
				redirect($this->base_url_admin.'staff/login');
			}
		}
	}
	public function log_out($per='')
	{
		$this->login_model->table_name = 'staff';
		
		if($this->session->userdata('matrimonial_user_data'))
		{
			$this->session->unset_userdata('matrimonial_user_data');
		}
		$this->session->unset_userdata('time_zone');
		$this->session->set_flashdata('user_log_out', 'You have successfully logged out');
		redirect($this->base_url_admin.'staff/login');
	}
	public function forgot_password()
	{
		$this->login_model->table_name = 'staff';
		
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
		$this->data['is_staff'] = 'yes';
		$this->load->view('back_end/forgot_password',$this->data);
	}
	public function validate_captcha_for()
	{
		$this->login_model->table_name = 'staff';
		
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
		$this->login_model->table_name = 'staff';
		
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
		$this->login_model->table_name = 'staff';
		
		if($password !='' && $email !='')
		{
			$response = $this->login_model->check_reset_link($password,$email);
			if($response =='success')
			{
				$this->data['page_title'] = '';
				$this->data['is_staff'] = 'yes';
				$this->data['config_data'] = $this->common_model->get_site_config();
				$this->load->view('back_end/reset_password',$this->data);
			}
			else
			{
				redirect($this->base_url_admin.'staff/login');
			}
		}
		else
		{
			redirect($this->base_url_admin.'staff/login');
		}
	}
	public function reset_update()
	{
		$this->login_model->table_name = 'staff';
		
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
				redirect($this->base_url_admin.'staff/login');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url_admin.'staff/login');
			}
		}
	}








	public function staff_assign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'statusChangeAllow'=>'no',
			'personal_where'=>" member_id!='' and action = 'Assign' and user_type = 'Staff' ",
		);
		if($clear_filter == 'yes'){
			$this->clear_filter_staff_assign('no');
		}
		$this->common_model->primary_key = 'assign_id';
		$this->common_model->created_on_fild = 'assign_date';
		$this->common_model->labelArr =  array('assign_to_name'=>'Assign To');
		
		$this->common_model->display_selected_field = array('matri_id','username','email','assign_to_name','assign_date');
		$this->common_model->common_rander('member_assign_history_view', $status, $page, 'Assigned Members To Staff','','assign_date',0,$other_config,'');
	}
	public function staff_unassign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->staffassign_arr_change = array('Assign_Staff'=>'Assign Staff');
		$this->common_model->franchiseassign_arr_change = array();
		if($clear_filter == 'yes')
		{
			$this->clear_filter_staff_assign('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " member_id!='' and user_type = 'Staff' and action='Unassigned' ";
		$this->assignment_reports_model->unassigned_member_list($status,$page,$personal_where,'staff');
	}
    public function staff_lead_assign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'statusChangeAllow'=>'no',
			'personal_where'=>" lead_generation_id!='' and action = 'Assign' and user_type = 'Staff' ",
		);
		if($clear_filter == 'yes'){
			$this->clear_filter_staff_assign('no');
		}
		$this->common_model->primary_key = 'assign_id';
		$this->common_model->created_on_fild = 'assign_date';
		$this->common_model->labelArr =  array('assign_to_name'=>'Assign To');
		
		$this->common_model->display_selected_field = array('id','username','email','assign_to_name','assign_date');
		$this->common_model->common_rander('lead_generation_assign_history_view', $status, $page, 'Assigned Lead Generation To Staff','','assign_date',0,$other_config,'');
	}
    public function staff_lead_unassign_history($status ='ALL', $page =1, $clear_filter='no')
	{
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->staffassign_arr_change = array('Assign_Staff'=>'Assign Staff');
		$this->common_model->franchiseassign_arr_change = array();
		if($clear_filter == 'yes')
		{
			$this->clear_filter_staff_assign('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " lead_generation_id!='' and user_type = 'Staff' and action='Unassigned' ";
		$this->common_model->member_or_lead = 'lead_generation';
		$this->assignment_reports_model->unassigned_lead_generation_list($status,$page,$personal_where,'staff');
	}
	public function search_model()
	{
		$this->assignment_reports_model->save_session_search();
	}
	public function search()
	{
		$this->assignment_reports_model->save_session_search();
		redirect($this->common_model->base_url_admin.'member/advanced-search-result');
	}
	public function clear_filter_staff_assign($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	
//for staff login and forget password
}