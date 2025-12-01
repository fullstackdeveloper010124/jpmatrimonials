<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member_plan extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		$this->plan();
	}
		
	public function plan($status ='ALL', $page =1)
	{
		$ele_array = array(
			'plan_name'=>array('is_required'=>'required'),
			'offer_per'=>array('is_required'=>'required','input_type'=>'number','label'=>'Plan Discount'),
			'category_type'=>array('is_required'=>'required','type'=>'dropdown','label'=>'Category Type','relation'=>array('rel_table'=>'membership_plan_category','key_val'=>'id','key_disp'=>'category_name')),
			'plan_type'=>array('type'=>'radio','value_arr'=>array('PAID'=>'PAID','FREE'=>'FREE'),'value'=>'PAID'),
			'plan_amount_type'=>array('is_required'=>'required','type'=>'dropdown','label'=>'Plan Currency','relation'=>array('rel_table'=>'currency_master','key_val'=>'currency_code','key_disp'=>'currency_name')),
			'plan_amount'=>array('is_required'=>'required','input_type'=>'number'),
			'plan_duration'=>array('is_required'=>'required','input_type'=>'number','placeholder'=>'Plan Duration In Days'),
			'plan_msg'=>array('is_required'=>'required','input_type'=>'number','label'=>'Plan Message','placeholder'=>''),
			'plan_contacts'=>array('is_required'=>'required','input_type'=>'number','placeholder'=>''),
			'profile'=>array('is_required'=>'required','input_type'=>'number','placeholder'=>''),
			/*'video'=>array('type'=>'radio','is_required'=>'required','value_arr'=>array('Yes'=>'Yes','No'=>'No'),'value'=>'No'),*/
			'chat'=>array('type'=>'radio','is_required'=>'required','value_arr'=>array('Yes'=>'Yes','No'=>'No'),'value'=>'No'),
			'plan_offers'=>array('type'=>'textarea'),
			'badge'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->path_payment_logo,'display_note'=>'File size must be 144px * 144px'),
			'color'=>array('is_required'=>'required','input_type'=>'color'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->js_extra_code .= '';
		$btn_arr = array(
			array('url'=>'member-plan/plan/edit-data/#id#','class'=>'info','label'=>'Edit Plan'),
		);
		$data_table = array(
			'title_disp'=>'plan_name',
			'disp_column_array'=> array('plan_amount_type','category_name','plan_duration','plan_amount','plan_contacts','profile','plan_msg','chat','created_on','plan_offers')
		);
		$join_tab_array = array();
		$join_tab_array[] = array( 'rel_table'=>'membership_plan_category', 'rel_filed'=>'id', 'rel_filed_disp'=>'category_name','rel_filed_org'=>'category_type');
		$other_config = array('load_member'=>'yes','data_table_mem'=>$data_table,'data_tab_btn'=>$btn_arr,'default_order'=>'DESC','field_duplicate'=>array('plan_name'),'enctype'=>'enctype="multipart/form-data"','display_image'=>'badge','badge'=>$this->common_model->path_payment_logo);
		$this->common_model->common_rander('membership_plan', $status, $page , 'Membership Plan',$ele_array,'created_on',0,$other_config,$join_tab_array);
	}

	public function plan_category($status ='ALL', $page =1)
	{
		$ele_array = array(
			'icon'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>array('fas fa-gem'=>'fas fa-gem','fas fa-ring'=>'fas fa-ring','fas fa-heart'=>'fas fa-heart')),
			'category_name'=>array('is_required'=>'required'),
			'extra_text'=>array('is_required'=>'required'),
			'offer_text'=>array('is_required'=>'required'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->js_extra_code.= '';
		$other_config = array('searchAllow'=>'no');
		$this->common_model->common_rander('membership_plan_category', $status, $page , 'Membership Plan Category',$ele_array,'id',0,$other_config);
	}
	
	public function add_on($status ='ALL', $page =1)
	{
		$ele_array = array(
			'name'=>array('is_required'=>'required'),
			'type'=>array('is_required'=>'required','type'=>'dropdown','label'=>'Add On Type','value_arr'=>array('Message'=>'Message','Contact'=>'Contact','Profile'=>'Profile','Expiry Extend'=>'Expiry Extend')),
			'advantage'=>array('is_required'=>'required','input_type'=>'number','placeholder'=>'Enter Number to Add on package value'),
			'currency'=>array('is_required'=>'required','type'=>'dropdown','label'=>'Plan Currency','relation'=>array('rel_table'=>'currency_master','key_val'=>'currency_code','key_disp'=>'currency_name')),
			'price'=>array('is_required'=>'required','input_type'=>'number'),
			'description'=>array('type'=>'textarea'),
			'status'=>array('type'=>'radio')
		);
		$other_config = array('default_order'=>'DESC','field_duplicate'=>array('name'));
		$this->common_model->data_tabel_filedIgnore[] = 'currency';
		$this->common_model->common_rander('add_on_management', $status, $page , 'name',$ele_array,'created_on',1,$other_config);
	}
}