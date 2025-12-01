<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_report extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		//$this->common_model->check_admin_only_access();
		$this->load->model('back_end/Member_model','member_model');
		$this->load->model('back_end/sales_report_model','sales_report_model');
		$this->user_type = $this->common_model->get_session_user_type();
		if($this->user_type =='staff')
		{
			redirect($this->common_model->base_url_admin.'dashboard');
		}
	}
	public function index()
	{
		$this->all_list();
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
	public function view_invoice($pay_id ='')
	{
		if($pay_id !='')
		{
			$this->data = $this->common_model->data;
			$this->db->join('register','payments.matri_id = register.matri_id','left');
			$payment_data = $this->common_model->get_count_data_manual('payments',array('payments.id'=>$pay_id),1,'payments.*,register.mobile,register.phone');

			if($payment_data !='' && count($payment_data) > 0)
			{
				$this->data['payment_data'] = $payment_data;
				$this->common_model->__load_header('View Invoice');
				$this->data['data'] = 'test';
				$this->load->view('back_end/member_invoice',$this->data);
				$this->common_model->__load_footer();
			}
			else
			{
				redirect($this->common_model->base_url_admin.'sales-report/all-list');
			}
		}
	}
	public function franchise_sales_report($status ='ALL', $page =1,$clear_search='no')
	{
		$this->common_model->check_admin_only_access();
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$personal_where = array();
		$personal_where['where_per'] = " (franchise_id !='' and franchise_id !='0') ";
		$personal_where['label_disp'] = "Franchise Sales Report";
		$personal_where['table_Name'] = "payments_view";
		$personal_where['disp_column_array'] = array('plan_name','email','category_type','payment_mode','plan_activated','plan_expired','plan_duration','plan_amount','grand_total','franchise_comm_per','franchise_comm_amt','franchise_name','franchise_email','current_plan');
		
		$this->sales_report_model->list_model($status,$page,$personal_where);
	}
	public function search_model()
	{
		$this->sales_report_model->save_session_search();
	}
	public function clear_filter($return='yes')
	{
		if($this->sales_report_model->session_search_name !='')
		{
			$session_search_name = $this->sales_report_model->session_search_name;
			$this->common_model->return_tocken_clear($session_search_name,$return);
		}
	}
}