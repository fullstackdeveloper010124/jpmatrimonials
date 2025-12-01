<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_analysis_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->common_model->session_search_name = 'ip_search_session';
	}
	
	function save_session_search()
	{
		$where_search = array();
		
		if($this->input->post('from_date') && $this->input->post('from_date') !=''){
			$from_date = $this->input->post('from_date');
		}
		if($this->input->post('to_date') && $this->input->post('to_date') !=''){
			$to_date = $this->input->post('to_date');
		}
		if((isset($from_date) && $from_date!='') && (isset($to_date) && $to_date!='')){
			if($from_date == $to_date){
				$from_date = date('Y-m-d', strtotime( $to_date . ' -1 day' ) );
			}
			$where_search[] = "DATE_FORMAT(visit_time, '%Y-%m-%d') BETWEEN '".$from_date."' AND '".$to_date."' ";
			$this->session->set_userdata('visit_link_date_wise_search','yes');
		}
		$where_search_str = '';
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
		}
		if($this->common_model->session_search_name !='')
		{
			$this->session->set_userdata($this->common_model->session_search_name,$where_search_str);
		}
		$this->common_model->return_tocken_clear();
	}
	
	function ip_search_form_array()
	{
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
		";
		$reg_date_rang = '
			<div class="col-sm-5 col-lg-5 pl0 paddin-mobile">
				<input type="text" required name="from_date" id="from_date" class="form-control datepicker" placeholder="Select Start Date">
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0 paddin-mobile">
				<input type="text" required name="to_date" id="to_date" class="form-control datepicker" placeholder="Select End Date">
			</div>';
			
		$this->common_model->js_extra_code.= "
		$('#from_date').datepicker({}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
				$('#to_date').datepicker('setStartDate', startDate);
			}).on('clearDate', function (selected) {
				$('#to_date').datepicker('setStartDate', null);
			});
			$('#to_date').datepicker({}).on('changeDate', function (selected) {
				var endDate = new Date(selected.date.valueOf());
				$('#from_date').datepicker('setEndDate', endDate);
			}).on('clearDate', function (selected) {
				$('#from_date').datepicker('setEndDate', null);
			}); ";
		$ele_array = array(
			'reg_range'=>array('display_in'=>'2','type'=>'manual','code'=>'
			<div class="form-group">
				<div class="col-sm-12 alert alert-danger margin-top-10"><div class="pull-left"><i class="fa fa-info"></i> Note: Select two same date show select date and 1 day before data is shown</div></div>
				<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Visted Between <span class="sub_title_mem">*</span></label>
				<div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
					'.$reg_date_rang.'
				</div>
			</div>'),
		);
		return $ele_array;
	}
	function get_ip_search_form_array($type=0)
	{	
		$return_value=array();
		$advanced_search_array = $this->ip_search_form_array();
		foreach($advanced_search_array as $advanced_search_key=>$advanced_search_val)
		{
			$display_in= $advanced_search_val['display_in'];
			if($display_in==$type || $display_in=='2')
			{
				$return_value[$advanced_search_key] = $advanced_search_val;
			}
		}
		return $return_value;
	}
	function display_search_form()
	{	
		$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;
		$ele_array = $this->get_ip_search_form_array();
		$other_config = array('mode'=>'add','id'=>'','action'=>'user_analysis/search','form_id'=>'form_model_ip_search');
		$this->common_model->set_table_name('user_analysis');
		$data = $this->common_model->generate_form_main($ele_array,$other_config);
		$this->common_model->data['model_title_fil_search'] = 'Filter Data';
		$this->common_model->data['model_body_fil_search'] = $data;
	}
}?>