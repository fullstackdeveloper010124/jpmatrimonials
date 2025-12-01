<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_activity extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
		$this->load->model('back_end/User_analysis_model','user_analysis_model');
		
	}
	public function index()
	{
		$this->express_interest();
	}
	public function express_interest($status ='ALL', $page =1)
	{		
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no'
		);
		$this->common_model->created_on_fild = 'sent_date';
		$this->common_model->data_tabel_filedIgnore = array('id','status','trash_receiver','trash_sender','is_deleted');
		$this->common_model->common_rander('expressinterest', $status, $page , 'Express Interest','','sent_date',0,$other_config);
	}
	public function message($status ='ALL', $page =1)
	{		
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no'
		);
		$this->common_model->created_on_fild = 'sent_on';
		$this->common_model->data_tabel_filedIgnore = array('id','status','read_status','important_status','trash_sender','trash_receiver','sender_delete','receiver_delete','is_deleted');
		$this->common_model->common_rander('message', $status, $page , 'Message','','sent_on',0,$other_config);
	}
	public function chat($status ='ALL', $page =1)
	{	
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no'
		);
		$this->common_model->created_on_fild = 'id';
		$this->common_model->data_tabel_filedIgnore = array('conversation_id','sender_member_id','receiver_member_id','is_read','blocked_member_id','is_deleted');
		$this->common_model->common_rander('custom_chat_conversation_message', $status, $page , 'message','','id',0,$other_config);
	}
	public function chat_bk($status ='ALL', $page =1)
	{		
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no'
		);
		$this->common_model->created_on_fild = 'sent';
		$this->common_model->data_tabel_filedIgnore = array('id','from','to','recd','time','GMT_time','message_type','room_id','is_deleted');
		$this->common_model->common_rander('frei_chat', $status, $page , 'Chat','','sent',0,$other_config);
		
	}
	
	public function user_login_history($status ='ALL', $page =1)
	{	
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'display_status'=>'no',
			'statusChangeAllow'=>'no'
		);
		$this->common_model->created_on_fild = 'login_at';
		//$this->common_model->data_tabel_filedIgnore = array('is_deleted');
		$this->common_model->common_rander('user_login_history', $status, $page , 'User Login History','','login_at',0,$other_config);
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
	public function clear_ip_filter($return='yes')
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
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
}