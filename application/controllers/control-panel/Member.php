<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		$this->load->model('back_end/Member_model','member_model');
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');	
		$this->load->model('back_end/sales_report_model','sales_report_model');
		$this->user_type = $this->common_model->get_session_data('user_type');
	}
	public function index()
	{
		$this->member_list();
	}
	public function add_edit_member($mode='add',$id='')
	{
		$this->data['mode'] = $mode;
		$add_label = '';
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		if($mode =='add-data' || $mode =='add')
		{
			$add_label = 'Add Member';
			$access_perm = $this->common_model->check_permission('add_member','redirect');
			$id= '';
		}
		else
		{
			$add_label = 'Edit Member';
			$access_perm = $this->common_model->check_permission('edit_member','redirect');
		}
		$this->data['id'] = $id;
		$this->common_model->__load_header($add_label);
		$this->load->view('back_end/member_registration',$this->data);
		$this->common_model->__load_footer();
	}
	public function member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Paid'=>'Paid','Suspended'=>'Suspended');
		$this->common_model->status_arr_change = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Suspended'=>'Suspended');
		$this->common_model->staffassign_arr_change = array('Assign_Staff'=>'Assign Staff','Unassign_Staff'=>'Unassign Staff');
		$this->common_model->franchiseassign_arr_change = array('Assign_Franchise'=>'Assign Franchise','Unassign_Franchise'=>'Unassign Franchise');
		
		if($status =='add-data' || $status =='edit-data')
		{
			$this->add_edit_member($status,$page);
		}
		else
		{
			$access_perm = $this->common_model->check_permission('view_member','redirect');
			if($clear_search =='yes')
			{
				$this->clear_filter('no');
			}
			$personal_where = array();
			$personal_where['where_per'] = "";
			$other_config = $this->common_model->add_own_where('',$access_perm);
			if(isset($other_config['personal_where']) && $other_config['personal_where'] !='')
			{
				$personal_where['where_per'] = $other_config['personal_where'];
			}
			if(isset($status) && $status==='Paid'){
				$this->common_model->status_field='plan_status';
			}
			$personal_where['access_perm'] = $access_perm;
			$this->member_model->member_list_model($status,$page,$personal_where);
		}
	}
	public function advanced_search_result($status ='ALL', $page =1)
	{
		$access_perm = $this->common_model->check_permission('advanced_search','redirect');
		$access_perm = $this->common_model->check_permission('view_member','redirect');
		$personal_where = array();
		$_REQUEST['manage_display']='no';
		$this->common_model->status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Paid'=>'Paid','Suspended'=>'Suspended','Featured'=>'Featured','Unfeatured'=>'Unfeatured');
		$this->common_model->status_arr_change = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED','Suspended'=>'Suspended');
		
		if(isset($status) && $status==='Paid'){
			$this->common_model->status_field='plan_status';
		}
		if(isset($status) && ($status=='Featured' || $status=='Unfeatured')){
			$this->common_model->status_field='fstatus';
		}
		
		$personal_where['label_disp'] = "Member Advanced Search Result";
		$other_config = $this->common_model->add_own_where('',$access_perm);
		if(isset($other_config['personal_where']) && $other_config['personal_where'] !='')
		{
			$personal_where['where_per'] = $other_config['personal_where'];
		}
		
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	public function advanced_search()
	{
		$access_perm = $this->common_model->check_permission('advanced_search','redirect');
		$this->label_page = 'Member Advanced Search';
		$ele_array = $this->member_model->get_filter_form_array(1);
		$other_config = array('mode'=>'add','id'=>'','action'=>'member/search');
		$this->common_model->set_table_name('register');
		$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);
		$this->label_page = 'Member Advanced Search';
		$this->common_model->__load_header($this->label_page);
		$this->load->view('common_file_echo',$this->data);
		$this->common_model->__load_footer();
	}
	public function active_member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('approve_to_paid_member','redirect');
		$access_perm = $this->common_model->check_permission('view_member','redirect');
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$this->common_model->button_array[] = array('onClick'=>"return display_payment(#id#)",'class'=>'success','label'=>'Approve as Paid');
		
		$personal_where = array();
		$personal_where['personal_where'] = " status = 'APPROVED' and plan_status = 'Not Paid'";
		$personal_where['label_disp'] = "Active Member";
		$personal_where = $this->common_model->add_own_where($personal_where,$access_perm);
		if(isset($personal_where['personal_where']) && $personal_where['personal_where'] !='')
		{
			$personal_where['where_per'] = $personal_where['personal_where'];
		}
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	public function paid_member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('edit_plan','redirect');
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$personal_where = array();
		$personal_where['personal_where'] = " status ='APPROVED' and plan_status='Paid' ";
		$personal_where['label_disp'] = "Paid Member";
		$personal_where = $this->common_model->add_own_where($personal_where,$access_perm);
		if(isset($personal_where['personal_where']) && $personal_where['personal_where'] !='')
		{
			$personal_where['where_per'] = $personal_where['personal_where'];
		}
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	
	public function featured_member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('approve_to_paid_member','redirect');
		$access_perm = $this->common_model->check_permission('view_member','redirect');
		$this->common_model->status_arr = array('Featured'=>'Featured','Unfeatured'=>'Unfeatured');
		$this->common_model->status_arr_change = array('Featured'=>'Featured','Unfeatured'=>'Remove Featured');
		if($clear_search =='yes'){
			$this->clear_filter('no');
		}
		$this->common_model->status_field = 'fstatus';
		$this->common_model->status_column= 'fstatus';
		$personal_where = array();
		$personal_where['personal_where'] = " status ='APPROVED' and plan_status='Paid' ";
		$personal_where['label_disp'] = "Paid Member";
		$personal_where = $this->common_model->add_own_where($personal_where,$access_perm);
		if(isset($personal_where['personal_where']) && $personal_where['personal_where'] !='')
		{
			$personal_where['where_per'] = $personal_where['personal_where'];
		}
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	
	public function expired_member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('renew_plan','redirect');
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$this->common_model->button_array[] = array('onClick'=>"return display_payment(#id#)",'class'=>'success','label'=>'Renew Plan');
		$personal_where = array();
		$cure_date = $this->common_model->getCurrentDate('Y-m-d');
		$personal_where['personal_where'] = " ( status = 'APPROVED' or status = 'Expired' ) and plan_status='Expired' and plan_expired_on < '$cure_date' ";
		$personal_where['label_disp'] = "Expired Member";
		$personal_where = $this->common_model->add_own_where($personal_where,$access_perm);
		if(isset($personal_where['personal_where']) && $personal_where['personal_where'] !='')
		{
			$personal_where['where_per'] = $personal_where['personal_where'];
		}
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	
	public function delete_request_list($status='ALL', $page=1, $clear_search='no')
	{
		// delete request process
		if($clear_search =='yes'){
			$this->clear_filter('no');
		}
		if(isset($_REQUEST['status_update']) && $_REQUEST['status_update'] =='DELETEPROFILE' && isset($_REQUEST['selected_val']) && count($_REQUEST['selected_val']) > 0)
		{			
			$delete_profile = $this->input->post('selected_val');
			
			$id_arr = array();
			foreach($delete_profile as $delete_id)
			{
				if($delete_id !='')
				{
					$id_arr[] = $delete_id;
				}
			}
			if($id_arr !='' && count($id_arr) >  0)
			{
				$id_arr_str = implode(',',$id_arr);
				$where_arr = array('is_deleted'=>'No');
				$where_arr[]= " id in ( $id_arr_str )";
				$member_data = $this->common_model->get_count_data_manual('delete_profile_request',$where_arr,2,'sender','','','','');
				
				if(isset($member_data) && $member_data !='' && count($member_data) > 0 )
				{
					$member_data_arr = array_column($member_data,'sender');
					$member_data_arr_str = implode("','",$member_data_arr);
					$where_arra_delete = array("matri_id in ('$member_data_arr_str') ");
					$data_array = array("is_deleted"=>'Yes');
					$this->common_model->update_insert_data_common('delete_profile_request',$data_array,$where_arr);
					$this->common_model->update_insert_data_common('register',$data_array,$where_arra_delete);
					/*deleted message table sender id*/
					$where_arra_delete = array("sender in ('$member_data_arr_str') ");
					$data_array = array("sender_delete"=>'Yes');
					$this->common_model->update_insert_data_common('message',$data_array,$where_arra_delete,1,'');
					/*delete message table receiver id*/
					$where_arra_delete = array("receiver in ('$member_data_arr_str') ");
					$data_array = array("receiver_delete"=>'Yes');
					$this->common_model->update_insert_data_common('message',$data_array,$where_arra_delete,1,'');
					//$this->common_model->send_mail_to_member('DELETE',$member_data_arr,'matri_id');
					$_REQUEST['is_allow_update'] = '0';
				}
			}
		}
		
		$ele_array = array(
			'status'=>array('type'=>'radio')
		);
		$this->common_model->status_arr = array('DELETE'=>'IGNORE REQUEST','DELETEPROFILE'=>'DELETE PROFILE');
		$other_confing = array('deleteAllow'=>'no','addAllow'=>'no','editAllow'=>'no','display_status'=>'no','default_order'=>'desc');		
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted');
		$this->common_model->labelArr= array('sender'=>'Matri Id','reason' =>'Reason For Deleting');
		$this->common_model->common_rander('delete_profile_request', $status, $page ,'Delete Profile Request',$ele_array,'sent_on',1,$other_confing);
	}
	
	public function upgrade_member_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('edit_plan','redirect');
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$this->common_model->button_array[] = array('onClick'=>"return display_payment(#id#)",'class'=>'success','label'=>'Edit Plan');
		
		$personal_where = array();
		$cure_date = $this->common_model->getCurrentDate('Y-m-d');
		$personal_where['personal_where'] = " status = 'APPROVED' and plan_status='Paid' ";
		$personal_where['label_disp'] = "Edit Member Plan";
		$personal_where = $this->common_model->add_own_where($personal_where,$access_perm);
		if(isset($personal_where['personal_where']) && $personal_where['personal_where'] !='')
		{
			$personal_where['where_per'] = $personal_where['personal_where'];
		}
		$personal_where['access_perm'] = $access_perm;
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	public function member_detail($id = '',$mode='view')
	{
		
		$access_perm = $this->common_model->check_permission('view_profile','redirect');
		if($id !='')
		{
			$this->member_model->display_column_arr($id);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'member/member-list');
		}
	}
	public function save_member()
	{
		$id = $this->member_model->save_new_update();
		if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='edit')
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] !='')
			{
				$id = $this->common_model->xss_clean($_REQUEST['id']);
			}
		}
		if($id !='')
		{
			redirect($this->common_model->base_url_admin.'member/member_list/edit-data/'.$id);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'member/member_list/add-data');
		}
	}
	public function view_comment($page=1)
	{
		$data['page_number'] = $page;
		$data['limit_per_page'] = '10';
		$data['user_id']=$this->input->post('user_id');
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/view_comment',$data);
	}
	public function add_comment()
	{
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/add_comment',$data);
	}
	public function save_comment()
	{
		$this->member_model->save_comment();
		$data['data'] = $this->common_model->getjson_response();
		$this->load->view('common_file_echo',$data);
	}
	public function plan_list()
	{
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/payment_display',$data);
	}
	public function plan_update()
	{
		$this->session->set_userdata('admin_payment','admin_payment');
		$data_return = $this->common_model->update_plan_member_call();
		$data['data'] =  json_encode($data_return);
		$this->load->view('common_file_echo',$data);
	}
	
	public function search_model()
	{
		$this->member_model->save_session_search();
	}
	public function search()
	{
		$this->member_model->save_session_search();
		redirect($this->common_model->base_url_admin.'member/advanced-search-result');
	}
	public function clear_filter($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	public function resend_confirm_mail()
	{
		$this->member_model->sent_confirm_mail_user();
	}
	public function follow_up_report($status ='ALL', $page =1, $clear_filter='no')
	{
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->staffassign_arr_change = array('Assign_Staff'=>'Assign Staff','Unassign_Staff'=>'Unassign Staff');
		$this->common_model->franchiseassign_arr_change = array('Assign_Franchise'=>'Assign Franchise','Unassign_Franchise'=>'Unassign Franchise');
		$personal_where = array();
		$personal_where['where_per'] = "";

		$access_perm = $this->common_model->check_permission('view_member','redirect');

		
		$other_config = $this->common_model->add_own_where('',$access_perm);

		if(isset($other_config['personal_where']) && $other_config['personal_where'] !='')
		{
			$personal_where['where_per'] = $other_config['personal_where'];
		}

		if($clear_filter == 'yes')
		{
			$this->clear_filter('no');
		}
		$this->assignment_reports_model->follow_up_report($status,$page,$personal_where);
	}
	public function all_list($status ='ALL', $page =1,$clear_search='no')
	{
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$personal_where = array();
		if($this->user_type =='franchise')
		{
			$id = $this->common_model->get_session_data('id');
			$personal_where['where_per'] = " (franchise_id !='' and franchise_id ='$id') ";
		}
		$this->sales_report_model->list_model($status,$page,$personal_where);
	}
	public function married_brother_list_new()
	{
		$this->load->view('front_end/no_married_brother');
	}
	//for redeem coupon code in admin 07-08-2023
	function check_coupan_admin()
	{ 
		$user_agent = 'NI-WEB';
		if($this->input->post('user_agent'))
		{
			$user_agent = $this->input->post('user_agent');
		}
		$plan_id = '';
		$couponcode ='';
		if($this->input->post('plan_id'))
		{
			$plan_id = $this->input->post('plan_id');
		}
		if($this->input->post('coupan_code_admin'))
		{
			$couponcode = $this->input->post('coupan_code_admin');
		}
	
		$data_return = array();
		$data_return['status']   = 'error';
		$data_return['tocken'] = $this->security->get_csrf_hash();

		// site setting data get
		$this->data['config_data'] = $this->common_model->get_site_config();
		// current payment method get
		$this->data['payment_method'] = $this->common_model->get_count_data_manual('payment_method',array('status'=>'approved'),1,'*','','','',"");

        $user_data = $_SESSION['mega_user_data'];

			/* current user plan assign #start*/
			if(isset($couponcode) && $couponcode != ''){
				$where_arra=array('id'=>$user_data['id']);
			}

			$this->data['member_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			/* current user plan assign #end*/
			// print_r($couponcode);exit;
			if($plan_id !='' &&  $couponcode !='')
			{
				
				$return = $this->member_model->check_coupan_admin($plan_id,$couponcode);
		
				if($return['status'] == 'success')
				{
					$data_return['status'] = 'success';
					$this->data['plan_id'] = $plan_id;
					$this->data['base_url'] = $this->base_url;
					$where_membership_plan = " (id ='".$plan_id."')";
				
					$membership_plan_arr = $this->common_model->get_count_data_manual('membership_plan',$where_membership_plan,1,'*','','','',"");
					$this->data['plan_data']= $membership_plan_arr;
					if($user_agent == 'NI-WEB')
					{
						$data_return['message'] = 'Coupon Code applied successfully.';
						$data_return['errmessage'] = 'Coupon Code applied successfully.';
						$data_return['discount_amount'] = $return['coupan_data'];
					}else{
						$data_return['message'] = 'Coupon Code applied successfully.';
						$data_return['errmessage'] = 'Coupon Code applied successfully.';
					    $data_return['discount_amount'] = $return['coupan_data'];
					}
				}else{
					$data_return['message'] = $return['error'];
					$data_return['errmessage'] = $return['error'];
				}
			}else{
				if($plan_id ==''){
					$data_return['message'] = 'Please select Plan';
				     $data_return['errmessage'] = 'Please select Plan';
				}else{
					$data_return['message'] = 'Please enter Coupan Code';
					$data_return['errmessage'] = 'Please enter Coupan Code';
				}
		
			}
		
		$data['data'] = json_encode($data_return);
		$this->load->view('common_file_echo',$data);
	}

}