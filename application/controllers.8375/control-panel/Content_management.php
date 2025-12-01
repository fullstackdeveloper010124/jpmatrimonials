<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Content_management extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{	
		redirect($this->common_model->data['base_url_admin'].'content-management/cms_pages');
		//$this->cms_pages();
	}
	public function cms_pages($status ='ALL', $page =1)
	{
		$ele_array = array(
			'page_title'=>array('is_required'=>'required'),
			'page_content'=>array('type'=>'textarea','is_required'=>'required'),
			//'page_content'=>array('type'=>'manual','code'=>'<textarea rows="4" name="page_content" id="page_content"  data-validation="required" class="form-control  " placeholder="Page Content" aria-required="true" style="visibility: hidden; display: none;"></textarea>'),
			'page_url'=>array('input_type'=>'hidden'),
			'genrate_url'=>array('type'=>'manual','code'=>'<input type="hidden" value="page_title-|-page_url" name="genrate_url" />'), // for generate url from page title title 
			'seo_title'=>array('is_required'=>'required'),
			'seo_description'=>array('type'=>'textarea','is_required'=>'required'),
			'seo_keywords'=>array('type'=>'textarea','is_required'=>'required'),
			'og_title'=>array('is_required'=>'required'),
			'og_image'=>array('type'=>'file','is_required'=>'required','path_value'=>'assets/ogimg/'),
			'og_description'=>array('type'=>'textarea','is_required'=>'required'),
			'status'=>array('type'=>'radio')
		);
		$btn_arr = array(
			array('url'=>'content-management/view-detail/#id#','class'=>'info','label'=>'View Detail'),
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
			$this->common_model->js_extra_code = " if($('#page_content').length > 0) {  $('.page_content_edit').removeClass(' col-lg-7 ');
			$('.page_content_edit').addClass(' col-lg-10 ');
			CKEDITOR.replace( 'page_content' ); } 
			
			";
		$other_con = array('data_tab_btn'=>$btn_arr,'display_image'=>array('og_image'));
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','page_content');
		$this->common_model->common_rander('cms_pages', $status, $page , 'CMS Page',$ele_array,'page_title',0,$other_con);
	}
	public function view_detail($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			
			$field_main_array = array(				
				array(
					'title_from_arr'=>'page_title',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'yes',
					'field_array'=>array(
						'page_content'=>''
					),
				),
			);
			$data['field_list'] = $field_main_array;			
			$this->common_model->table_name = 'cms_pages'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('CMS Page Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'content-management/cms-pages');
		}
	}
	public function faq_list($status ='ALL', $page =1)
	{
		$ele_array = array(
			'question'=>array('is_required'=>'required'),
			'answer'=>array('type'=>'textarea'),
			'status'=>array('type'=>'radio')
		);
		
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
			$this->common_model->js_extra_code = " if($('#answer').length > 0) {  $('.answer_edit').removeClass(' col-lg-7 ');
			$('.answer_edit').addClass(' col-lg-10 ');
			CKEDITOR.replace( 'answer' ); } ";
		
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted');
		$this->common_model->common_rander('faq_master', $status, $page , 'Faqs',$ele_array,'question',0,'');
		
	}
}