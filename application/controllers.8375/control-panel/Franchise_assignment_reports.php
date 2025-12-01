<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Franchise_assignment_reports extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->check_admin_only_access();
		$this->common_model->checkLogin();
		$this->load->model('back_end/Assignment_reports_model','assignment_reports_model');
		$this->load->model('back_end/sales_report_model','sales_report_model');
		$this->load->model('back_end/Member_model','member_model');
	}
	public function index()
	{
		$this->franchise_assign_history();
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
			$this->clear_filter('no');
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
			$this->clear_filter('no');
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
			$this->clear_filter('no');
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
			$this->clear_filter('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " lead_generation_id!='' and user_type = 'Franchise' and action='Unassigned' ";
		$this->common_model->member_or_lead = 'lead_generation';
		$this->assignment_reports_model->unassigned_lead_generation_list($status,$page,$personal_where,'franchise');
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
	

}?>