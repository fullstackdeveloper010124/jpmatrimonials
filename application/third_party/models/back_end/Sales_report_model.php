<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sales_report_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->session_search_name = 'sales_report_search_session';
		$this->common_model->session_search_name = $this->session_search_name;
	}
	function list_model($status ='ALL', $page =1,$personal_where='')
	{
		$ele_array = array(
			'status'=>array('type'=>'radio')
		);
		$btn_arr = array(
			array('url'=>'sales-report/view-invoice/#id#','class'=>'info','label'=>'Invoice','target'=>'_blank'),
		);
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'deleteAllow'=>'no',
			'display_status'=>'no',
			'statusChangeAllow'=>'no',
			'default_order'=>'desc',
			'data_tab_btn'=>$btn_arr
		);
		$btn_arr = array(
			array('url'=>'sales-report/view-invoice/#id#','class'=>'info','label'=>'View Invoice','target'=>'_blank'),
		);
		$data_table = array(
			'title_disp'=>'name',
			'post_title_disp'=>'matri_id',
			'disp_status'=>'no',
			'disp_column_array'=> array('plan_name','email','payment_mode','plan_activated','plan_expired','plan_duration','plan_amount','grand_total','current_plan')
		);
		if(isset($personal_where['disp_column_array']) && $personal_where['disp_column_array'] !='' && count($personal_where['disp_column_array']) > 0)
		{
			$data_table['disp_column_array'] = $personal_where['disp_column_array'];
		}
		$user_type = $this->common_model->get_session_user_type();
		if($user_type =='franchise')
		{
			$data_table['disp_column_array'][] = 'franchise_comm_per';
			$data_table['disp_column_array'][] ='franchise_comm_amt';
		}
		$table_Name = 'payments';
		$label_disp = 'Sales Report';
		if(isset($personal_where['table_Name']) && $personal_where['table_Name'] !='')
		{
			$table_Name = $personal_where['table_Name'];
		}
		if(isset($personal_where['label_disp']) && $personal_where['label_disp'] !='')
		{
			$label_disp = $personal_where['label_disp'];
		}
		$other_config = array('hide_display_image'=>'No','load_member'=>'yes','data_table_mem'=>$data_table,'data_tab_btn'=>$btn_arr,'default_order'=>'DESC','field_duplicate'=>array('plan_name'),'addAllow'=>'no', 'editAllow'=>'no','deleteAllow'=>'no', 'display_status'=>'no', 'statusChangeAllow'=>'no','display_filter'=>'Yes');
		if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
		{
			$other_config['personal_where'] = $personal_where['where_per'];
		}
		$this->display_filter_form($personal_where);
		
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col =7;
		$this->common_model->addPopup = 0;
		$this->common_model->common_rander($table_Name, $status, $page , $label_disp,$ele_array,'plan_activated',0,$other_config);
	}
	function display_filter_form($personal_where='')
	{	
		$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;
		
		$this->common_model->extra_css[] = 'vendor/chosen_v1.4.0/chosen.min.css';
		$this->common_model->extra_js[] = 'vendor/chosen_v1.4.0/chosen.jquery.min.js';
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->js_extra_code.= " var config = {
			'.chosen-select': {},
			'.chosen-select-deselect': { allow_single_deselect: true },
			'.chosen-select-no-single': { disable_search_threshold: 10 },
			'.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
			'.chosen-select-width': { width: '100%' }			
			};
			$('#list_franchise').chosen({placeholder_text_multiple:'Select Franchise'});
			
			$('#plan_name').chosen({placeholder_text_multiple:'Select Plan Name'});
			$('#payment_method').chosen({placeholder_text_multiple:'Select Payment Method'});
		";
		$reg_date_rang = '
			<div class="col-sm-5 col-lg-5 pl0">
			<input type="text" name="from_reg_date" id="from_reg_date" class="form-control datepicker">
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0">
			<input type="text" name="to_reg_date" id="to_reg_date" class="form-control datepicker">
			</div>';
			
		$this->common_model->js_extra_code.= " $('#from_reg_date').datepicker({}).on('changeDate', function (selected) {
				var startDate = new Date(selected.date.valueOf());
				$('#to_reg_date').datepicker('setStartDate', startDate);
			}).on('clearDate', function (selected) {
				$('#to_reg_date').datepicker('setStartDate', null);
			});
			$('#to_reg_date').datepicker({
			}).on('changeDate', function (selected) {
			var endDate = new Date(selected.date.valueOf());
			$('#from_reg_date').datepicker('setEndDate', endDate);
			}).on('clearDate', function (selected) {
			$('#from_reg_date').datepicker('setEndDate', null);
			}); ";	
		
		$ele_array = array(
			'keyword'=>array('placeholder'=>'Search with Member Name, Member Email, Matri ID'),			
			'reg_range'=>array('type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Plan Activated</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$reg_date_rang.'
			  </div>
			</div>'),
			'plan_name'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'membership_plan','key_val'=>'plan_name','key_disp'=>'plan_name'),'is_multiple'=>'yes','label'=>'Plan Name','display_placeholder'=>'No','class'=>'chosen-select'),
			'payment_method'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('payment_method'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
		);
		$user_type = $this->common_model->get_session_user_type();
		if(isset($personal_where) && $personal_where !='' && $user_type =='admin')
		{
			$ele_array['list_franchise'] = array('type'=>'dropdown','relation'=>array('rel_table'=>'franchise','key_val'=>'id','key_disp'=>'email'),'is_multiple'=>'yes','label'=>'Franchise','display_placeholder'=>'No','class'=>'chosen-select');
		}

		$other_config = array('mode'=>'add','id'=>'','action'=>'sales_report/search_model','form_id'=>'form_model_search');
		$this->common_model->set_table_name('payments');
		$data = $this->common_model->generate_form_main($ele_array,$other_config);
		$this->common_model->data['model_title_fil'] = 'Filter Data';
		$this->common_model->data['model_body_fil'] = $data;
	}
	function save_session_search()
	{		
		$where_search = array();
		
		if($this->input->post('keyword') && $this->input->post('keyword') !='')
		{
			$keyword = trim($this->input->post('keyword'));
			$where_search[]= " ( matri_id like '%$keyword%' or name like '%$keyword%' or email like '%$keyword%' ) ";
		}
		if($this->input->post('from_reg_date') && $this->input->post('from_reg_date') !='')
		{
			$from_reg_date = $this->input->post('from_reg_date');
			$where_search[]= " ( DATE_FORMAT(plan_activated, '%Y-%m-%d') >='$from_reg_date') ";
		}
		if($this->input->post('to_reg_date') && $this->input->post('to_reg_date') !='')
		{
			$to_reg_date = $this->input->post('to_reg_date');
			$where_search[]= " ( DATE_FORMAT(plan_activated, '%Y-%m-%d') <='$to_reg_date') ";
		}
		if($this->input->post('list_franchise') && $this->input->post('list_franchise') !='')
		{
			$list_franchise = $this->input->post('list_franchise');
			$list_franchise = $this->common_model->trim_array_remove($list_franchise);
			if(isset($list_franchise) && count($list_franchise) > 0)
			{
				$list_franchise_str = implode("','",$list_franchise);
				$where_search[]= " ( franchise_id in ( '$list_franchise_str') ) ";
			}
		}
		if($this->input->post('plan_name') && $this->input->post('plan_name') !='')
		{
			$plan_name = $this->input->post('plan_name');
			$plan_name = $this->common_model->trim_array_remove($plan_name);
			if(isset($plan_name) && count($plan_name) > 0)
			{
				$plan_name_str = implode("','",$plan_name);
				$where_search[]= " ( plan_name in ( '$plan_name_str') ) ";
			}
		}
		if($this->input->post('payment_method') && $this->input->post('payment_method') !='')
		{
			$payment_method = $this->input->post('payment_method');
			$payment_method = $this->common_model->trim_array_remove($payment_method);
			if(isset($payment_method) && count($payment_method) > 0)
			{
				$payment_method_str = implode("','",$payment_method);
				$where_search[]= " ( payment_mode in ('$payment_method_str') ) ";
			}
		}
		$where_search_str = '';
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
		}
		if($this->common_model->session_search_name !='')
		{
			$this->session->set_userdata($this->session_search_name,$where_search_str);
		}
		$this->common_model->return_tocken_clear();
	}
}