<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Event_management extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		$this->event_list();
	}
	public function event_list($status ='ALL', $page =1)
	{
		$ele_array = array(
			'title'=>array('is_required'=>'required'),
			'description'=>array('type'=>'textarea'),
			'event_date'=>array('input_type'=>'date','is_required'=>'required'),
			'event_time'=>array('input_type'=>'time','is_required'=>'required'),
			'venue'=>array('type'=>'textarea','is_required'=>'required'),
			'external_link'=>array('input_type'=>'url'),
			'limited'=>array('is_required'=>'required','input_type'=>'number','other'=>"min='0'"),
			'currency'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'currency_master','key_val'=>'currency_code','key_disp'=>'currency_name')),
			'ticket'=>array('is_required'=>'required','input_type'=>'number','other'=>"min='0'"),
			'event_facebook_link'=>array('input_type'=>'url'),
			'event_twitter_link'=>array('input_type'=>'url'),
			'event_google_link'=>array('input_type'=>'url'),
			'map_address'=>array('type'=>'textarea'),
			'map_tooltip'=>array('type'=>'textarea'),
			'image'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->path_events,'inline_style'=>'height:100px;width:150px;'),
			'image_2'=>array('type'=>'file','path_value'=>$this->common_model->path_events,'inline_style'=>'height:100px;width:150px;'),
			'image_3'=>array('type'=>'file','path_value'=>$this->common_model->path_events,'inline_style'=>'height:100px;width:150px;'),
			'image_4'=>array('type'=>'file','path_value'=>$this->common_model->path_events,'inline_style'=>'height:100px;width:150px;'),
			'status'=>array('type'=>'radio')
		);
		//$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		//$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->extra_css[] = 'styles/zebra_datepicker.min.css';
		$this->common_model->extra_js[] = 'scripts/zebra_datepicker.min.js';
		
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		
		$this->common_model->js_extra_code = " if($('#description').length > 0) { $('.page_description_edit').removeClass(' col-lg-7 ');
			$('.page_description_edit').addClass('col-lg-10');
			CKEDITOR.replace('description'); }
		
			//$('#event_date').datepicker();
			$('#event_date').Zebra_DatePicker({
			default_position:'below',
			direction: 1
			});
		";
		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$data_table = array(
			'title_disp'=>'title',
			'disp_column_array'=> array('event_date','event_time','ticket','limited','venue','created_on')
		);
		$btn_arr = array(
			array('url'=>'event-management/event-list/edit-data/#id#','class'=>'info','label'=>'Edit Event'),
			array('url'=>'event-management/view-event/#id#','class'=>'info','label'=>'View Detail'),
		);
		$other_config = array('load_member'=>'yes','data_table_mem'=>$data_table,'data_tab_btn'=>$btn_arr,'default_order'=>'DESC','enctype'=>'enctype="multipart/form-data"','display_image'=>'image','image'=>$this->common_model->path_events,'field_duplicate'=>array('title'));
		//$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('image'));
		$this->common_model->common_rander('events', $status, $page , 'Events',$ele_array,'created_on',0,$other_config);
	}
	public function view_event($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			
			// $data['data_array'] = $this->common_model->get_count_data_manual('events',array('id'=>$id),1,' * ','',0,'',0); // pass data_array perameter for custom row 
			$image_arra = array(
			array(
				'filed_arr' => array('image','image_2','image_3','image_4'),
				'path_value'=>$this->common_model->path_events,
				'title'=>'Event Gallary',
				'class_width'=>' col-lg-3 col-md-4 col-sm-6  col-xs-12 ',
				'img_class'=>'img-responsive img-thumbnail',
				'inline_style'=>''
			));
			$field_main_array = array(				
				array(
					'title'=>'Event Detail',
					'title_from_arr'=>'title',
					'class_width'=>' col-lg-4 col-md-4 col-sm-6  col-xs-12 ',
					'field_array'=>array(
						'event_date'=>array('label'=>'Event Date','class'=>'alert alert-success','type'=>'date','inline_style'=>"font-weight:bold"),
						'event_time'=>array('inline_style'=>"color:red"),
						'limited'=>'',
						'ticket'=>array('pre_filed'=>'currency'),
						'map_address'=>'',
						'map_tooltip'=>'',
						'created_on'=>array('type'=>'date'),
						'venue'=>array(),
						'external_link'=>array('type'=>'link'),
						// 'limited'=>array('type'=>'relation','table_name'=>'country_master','prim_id'=>'id','disp_column_name'=>'country_name'), // for relation data display
					),
				),
				array(
					'title'=>'Description',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'description'=>'description'
					),
				),
			);
			$data['img_list_arr'] = $image_arra;
			$data['img_position'] = 'bottom';
			$data['field_list'] = $field_main_array;
			
			$this->common_model->table_name = 'events'; // set table name for get data from wich table 
			
			$this->common_model->common_view_detail('Event Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'event-management/event-list');
		}
	}
}