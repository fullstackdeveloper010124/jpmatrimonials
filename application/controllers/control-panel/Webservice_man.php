<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Webservice_man extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index($status ='ALL', $page =1)
	{
		$this->service_list($status, $page);
	}
	public function service_list($status ='ALL', $page =1)
	{
		$ele_array = array(
			'service_name'=>array('is_required'=>'required'),
			'service_url'=>array('is_required'=>'required'),
			'service_name'=>array('is_required'=>'required'),
			'method'=>array('type'=>'radio','value_arr'=>array('POST'=>'POST','GET'=>'GET'),'value'=>'POST'),
			'description'=>array('type'=>'textarea'),
			'perameter'=>array('type'=>'textarea'),
			'success_response'=>array('type'=>'textarea'),
			'error_response'=>array('type'=>'textarea')
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->data_tabel_filedIgnore = array('description','perameter','success_response','error_response');
		$btn_arr = array(
			array('url'=>'webservice-man/view-detail/#id#','class'=>'info','label'=>'View Detail'),
		);
		$this->common_model->js_extra_code = " if($('#description').length > 0) { $('.page_content_edit').removeClass(' col-lg-7 ');
			$('.page_content_edit').addClass(' col-lg-10 ');
				CKEDITOR.replace( 'description' ); 
				CKEDITOR.replace( 'perameter' );
				CKEDITOR.replace( 'success_response' );
				CKEDITOR.replace( 'error_response' );
			}";
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('blog_image'),'data_tab_btn'=>$btn_arr);
		$this->common_model->common_rander('web_service', $status, $page , 'Web Service List',$ele_array,'service_name',0,$other_config);
	}
	public function view_detail($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			
			$field_main_array = array(				
				array(
					'title_from_arr'=>'service_name',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'service_url'=>''
					),
				),
				array(
					'title'=>'Method',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'method'=>''
					),
				),
				array(
					'title'=>'Description',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'description'=>''
					),
				),
				array(
					'title'=>'Perameter',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'perameter'=>''
					),
				),
				array(
					'title'=>'Success Response',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'success_response'=>''
					),
				),
				array(
					'title'=>'Error Response',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'error_response'=>''
					),
				),
			);
			$data['field_list'] = $field_main_array;			
			$this->common_model->table_name = 'web_service'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('Web service Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'webservice-man/service-list');
		}
	}
}