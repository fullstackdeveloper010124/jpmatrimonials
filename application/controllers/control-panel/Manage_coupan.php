<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_coupan extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		$this->coupan_code_list();
	}
		
	public function coupan_code_list($status ='ALL', $page =1)
	{
		$ele_array = array(
			'coupan_code'=>array('is_required'=>'required'),
			'discount_amount'=>array('is_required'=>'required','input_type'=>'number'),
			'active_from'=>array('is_required'=>'required','placeholder'=>'Coupan Code Actived On','input_type'=>'date'),
			'expired_on'=>array('is_required'=>'required','placeholder'=>'Coupan Code Expired On','input_type'=>'date'),
			'status'=>array('type'=>'radio'),
		);
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		
		$this->common_model->js_extra_code.= " $('#active_from').datepicker({}).on('changeDate', function (selected) {
		    var startDate = new Date(selected.date.valueOf());
		    $('#expired_on').datepicker('setStartDate', startDate);
		}).on('clearDate', function (selected) {
		    $('#expired_on').datepicker('setStartDate', null);
		});
		$('#expired_on').datepicker({
		}).on('changeDate', function (selected) {
		var endDate = new Date(selected.date.valueOf());
    	$('#active_from').datepicker('setEndDate', endDate);
		}).on('clearDate', function (selected) {
		$('#active_from').datepicker('setEndDate', null);
		}); ";
		
		$other_config = array('default_order'=>'DESC','field_duplicate'=>array('coupan_code'));
		//$this->common_model->display_selected_field = array('id','profile_pic_approval','profile_pic','fullname','email');
		$this->common_model->common_rander('coupan_code', $status, $page , 'Coupon Code',$ele_array,'created_on',1,$other_config);
	}
}