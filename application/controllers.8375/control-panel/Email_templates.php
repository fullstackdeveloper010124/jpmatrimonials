<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Email_templates extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->data['config_data'] = $this->common_model->get_site_config();
		
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{		
		redirect($this->common_model->data['base_url_admin'].'email-templates/email-templates');
		//$this->email_templates();
	}
	public function email_templates($status ='ALL', $page =1)
	{
		$ele_array = array(
			'template_name'=>array('is_required'=>'required'),
			'email_subject'=>array('is_required'=>'required'),
			'email_content'=>array('type'=>'textarea'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		
		$btn_arr = array(
			array('url'=>'email-templates/view-detail/#id#','class'=>'info','label'=>'View Detail'),
		);
		$other_con = array('data_tab_btn'=>$btn_arr);
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','email_content','pre_condition');
		$this->common_model->js_extra_code = " if($('#email_content').length > 0) {  $('.email_content_edit').removeClass(' col-lg-7 ');
			$('.email_content_edit').addClass(' col-lg-10 ');
			CKEDITOR.replace( 'email_content' , {
			disableNativeSpellChecker : false,
			allowedContent : true,
			});} ";
		$this->common_model->common_rander('email_templates', $status, $page , 'Email Templates',$ele_array,'template_name',0,$other_con);
	}
	public function view_detail($id='')
	{
		$config_data = $this->data['config_data'];
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			$email_data_arr =  $this->common_model->get_count_data_manual('email_templates',array($this->common_model->primary_key=>$id),1,' * ','',0,'',0);
			if(isset($email_data_arr) && $email_data_arr !='' && is_array($email_data_arr) && count($email_data_arr) > 0)
			{
				$email_data_arr['email_content'] = $this->common_model->getstringreplaced($email_data_arr['email_content'],array('template_image_url/logo22.png'=>base_url().'assets/logo/'.$config_data['upload_logo']));
				$data['data_array'] = $email_data_arr; 
			}
			$field_main_array = array(				
				array(
					'title_from_arr'=>'template_name',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'email_content'=>''
					),
				),
			);
			$data['field_list'] = $field_main_array;			
			$this->common_model->table_name = 'email_templates'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('Email Templates Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'content-management/cms-pages');
		}
	}
}