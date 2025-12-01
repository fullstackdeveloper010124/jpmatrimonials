<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Followup_system extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->check_admin_only_access();
		$this->common_model->checkLogin();
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');
	}
	public function index()
	{
		$this->follow_up_report();
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
			$this->clear_filter('no');
		}
		$this->common_model->member_or_lead = 'lead_generation';
		$this->assignment_reports_model->lead_follow_up_report($status,$page,$personal_where);
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
	public function clear_filter($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
	public function add_comment()
	{

		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/add_comment',$data);
	}
}?>