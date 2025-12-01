<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_analysis extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->check_admin_only_access();
		$this->load->model('back_end/User_analysis_model','user_analysis_model');
	}
	public function index()
	{
		$this->user_analysis_list();
	}	
	public function user_analysis_list($status ='ALL', $page =1, $clear_ip_filter='no')
	{
		$today = $this->common_model->getCurrentDate();
		$curr_date_time = date('Y-m-d H:i:s',strtotime('-30 days',strtotime($today)));
		$btn_arr = array(
			array('url'=>'user_analysis/visit_links/#ip#/1/yes','class'=>'info','label'=>'Visit Link','target'=>'_blank'),
		);
		$this->common_model->status_field = 'blocked';
		$this->common_model->status_column= 'blocked';
		$this->common_model->status_arr_change = array('Block'=>'Block','Unblocked'=>'Unblocked');
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'deleteAllow'=>'no',
			'data_tab_btn'=>$btn_arr,
			'display_search_ip'=>'Yes',
			'personal_where'=>" visit_time > '$curr_date_time'"
		);
		if($clear_ip_filter == 'yes'){
			$this->clear_ip_filter('no');
		}
		$this->common_model->is_delete_fild = '';
		$this->common_model->primary_key ='ip';
		$this->common_model->created_on_fild = 'visit_time';
		//$this->common_model->data_tabel_filedIgnore = array('address','country','id','latitude','longitude','postal','broadband_name','api_info');
		//$this->common_model->data_tabel_filed = array('ip','country','total_count');
		$this->user_analysis_model->display_search_form();
		$this->common_model->common_rander('user_analytics_summary', $status, $page , 'User Analysis Report','','visit_time',0,$other_config,'');
		//echo $this->db->last_query();
	}
	public function visit_links($ip='', $page =1,$clear_ip_filter='no'){
		$today = $this->common_model->getCurrentDate();
		$curr_date_time = date('Y-m-d H:i:s',strtotime('-1 days',strtotime($today)));
		$other_config = array(
			'AllAllow'=>'no',
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no',
			'deleteAllow'=>'no',
			'display_search_ip'=>'Yes',
			//'personal_where'=>" md5(ip)='$ip'",
			//'personal_where'=>" visit_time > '$curr_date_time'"
		);
		if($this->session->userdata('visit_link_date_wise_search')=='yes'){
		}
		else{
			$b = array('personal_where'=>" visit_time > '$curr_date_time'");
			$other_config = array_merge($other_config,$b);
		}
		if($clear_ip_filter == 'yes'){
			$this->clear_ip_filter('no');
		}
		
		$this->common_model->status_field = 'md5(ip)';
		$this->common_model->status_column= 'md5(ip)';
		$this->common_model->created_on_fild = 'visit_time';
		$this->common_model->data_tabel_filedIgnore = array('id','api_info');
		$this->user_analysis_model->display_search_form();
		$this->common_model->is_delete_fild = '';
		$this->common_model->common_rander('user_analysis', $ip, $page, 'User Analysis Report (Last 24 Hours)','','visit_time',0,$other_config);
	}
	function search(){
		$this->user_analysis_model->save_session_search();
	}
	public function clear_ip_filter($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
}?>