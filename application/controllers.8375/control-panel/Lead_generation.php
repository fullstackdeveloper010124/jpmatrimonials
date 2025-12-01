<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lead_generation extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->admin_path = $this->common_model->getconfingValue('admin_path');
		$this->data['admin_path'] = $this->admin_path;
		$this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->load->model('back_end/Lead_generation_model','lead_generation_model');
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');
	}
	public function lead_generation_list($status ='ALL', $page =1,$clear_search='no')
	{
		$this->common_model->assing_to_member = 'yes';
		$this->common_model->change_interest = 'yes';
		$this->common_model->status_arr = array();
		$this->common_model->status_arr_change = array();
		$this->common_model->staffassign_arr_change = array('Assign_Staff'=>'Assign Staff','Unassign_Staff'=>'Unassign Staff');
		$this->common_model->franchiseassign_arr_change = array('Assign_Franchise'=>'Assign Franchise','Unassign_Franchise'=>'Unassign Franchise');
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$this->common_model->member_or_lead = 'lead_generation';
		$personal_where = array();
        $u_id = $this->common_model->get_session_data('id');
		$user_type = $this->common_model->get_session_user_type();
		$access_perm = $this->common_model->check_permission('view_lead_generation','redirect');
		
		if($user_type=='staff'){
			$user_type = 'Staff';

		 if($access_perm=='Own Members')	
		 {
		 	
		 	$personal_where['where_per'] = " (staff_assign_id = '".$u_id."' || adminrole_id='".$u_id."') ";
		 	
		 }
		 else if($access_perm=='All Members'){
		 
		 	$personal_where['where_per']='';
		 }
		 else{
		 	$personal_where['where_per']='';
		 }

		}
		if($user_type == 'franchise'){
			$user_type = 'Franchise';
		}
	
		$this->lead_generation_model->lead_gen_list($status,$page,$personal_where);
	}
	public function lead_generation_report($status ='ALL', $page =1, $clear_filter='no'){
		$u_id = $this->common_model->get_session_data('id');
		$user_type = $this->common_model->get_session_user_type();
		if($user_type=='staff'){
			$user_type = 'Staff';
		}
		if($user_type == 'franchise'){
			$user_type = 'Franchise';
		}
		$this->common_model->labelArr =  array('email'=>'Lead Email','next_followup_date'=>'Followup Date','assign_to_staff'=>'Staff Name','assign_to_franchise'=>'Franchise Name');
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'asc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'statusChangeAllow'=>'no',
			
			

			//'personal_where'=>" lead_generation_id!='' and action = 'Assign' and user_type = '".$user_type."' and assign_to = '".$u_id."'",
		);
	
		if($clear_filter == 'yes'){
			$this->clear_filter('no');
		}
		$this->common_model->is_delete_fild = '';
		$this->common_model->created_on_fild = 'next_followup_date';
		$this->common_model->display_selected_field = array('interest','email','assign_to_staff','staff_email_id','assign_to_franchise','franchise_email_id','next_followup_date');
		$u_id = $this->common_model->get_session_data('id');
		$user_type = $this->common_model->get_session_user_type();
		$access_perm = $this->common_model->check_permission('view_lead_generation','redirect');

		if($user_type=='staff'){
			$user_type = 'Staff';

			if($access_perm=='Own Members')	
			{
				$other_config['personal_where'] = " staff_assign_id = '".$u_id."'";
			}
		}

		$this->common_model->common_rander('lead_generation_followup_system_view', $status, $page, 'Assigned Lead Generation To '.$user_type,'','next_followup_date',0,$other_config,'');
		
	}
	
	public function search_model()
	{
		$this->lead_generation_model->save_session_search();
	}
	public function clear_filter($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	public function save_lead()
	{
		$id = $this->lead_generation_model->save_new_update();
		if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='edit')
		{
			if(isset($_REQUEST['id']) && $_REQUEST['id'] !='')
			{
				$id = $this->common_model->xss_clean($_REQUEST['id']);
			}
		}
		if($id !='')
		{
			redirect($this->common_model->base_url_admin.'lead-generation/lead-generation-list/edit-data/'.$id);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'lead-generation/lead-generation-list/add-data');
		}
	}
	
	public function view_comment($page=1)
	{
		$data['page_number'] = $page;
		$data['limit_per_page'] = '10';
		$data['user_id'] = $this->input->post('user_id');
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/lead_generation_view_comment',$data);
	}
	public function add_comment()
	{
		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/lead_generation_add_comment',$data);
	}
	public function save_comment()
	{
		$this->lead_generation_model->save_comment();
		$data['data'] = $this->common_model->getjson_response();
		$this->load->view('common_file_echo',$data);
	}
	public function lead_generation_follow_up_report($status ='ALL', $page =1, $clear_filter='no')
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
			$this->clear_filter_follow_up('no');
		}
		$this->common_model->member_or_lead = 'lead_generation';
		$this->assignment_reports_model->lead_follow_up_report($status,$page,$personal_where);
	}
	public function clear_filter_follow_up($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
}?>