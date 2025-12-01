<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Seo_page_data extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{	
		//redirect($this->common_model->data['base_url_admin'].'seo-page-data/seo_pages');
		$this->seo_pages();
	}
	public function seo_pages($status ='ALL', $page =1)
	{
		$ele_array = array(
			'page_title'=>array('is_required'=>'required','class'=>' not_reset ','type'=>'dropdown','value_arr'=>array('Home'=>'Home','Register Now'=>'Register Now','Login'=>'Login','Quick Search'=>'Quick Search','Advance Search'=>'Advance Search','Keyword Search'=>'Keyword Search','Id Search'=>'Id Search','Upgrade'=>'Upgrade','Success Story'=>'Success Story','Wedding Vendor'=>'Wedding Vendor','Event'=>'Event','Add With Us'=>'Add With Us','Blog'=>'Blog','Member Demographics'=>'Member Demographics','Mobile Matrimony'=>'Mobile Matrimony')),
			'genrate_url'=>array('type'=>'manual','code'=>'<input type="hidden" value="page_title" name="genrate_url" />'), 
			// for generate url from page title title 
			'seo_title'=>array('is_required'=>'required'),
			'seo_description'=>array('is_required'=>'required','type'=>'textarea'),
			'seo_keywords'=>array('is_required'=>'required','type'=>'textarea'),
			'og_title'=>array('is_required'=>'required'),
			'og_image'=>array('is_required'=>'required','type'=>'file','path_value'=>'assets/ogimg/'),
			'og_description'=>array('is_required'=>'required','type'=>'textarea'),
			'status'=>array('is_required'=>'required','type'=>'radio')
		);
		$btn_arr = array(
			array('url'=>'seo-page-data/view-detail/#id#','class'=>'info','label'=>'View Detail'),
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->js_extra_code = " if($('#page_content').length > 0) {  $('.page_content_edit').removeClass(' col-lg-7 ');
		$('.page_content_edit').addClass(' col-lg-10 ');
		CKEDITOR.replace( 'page_content' ); } ";
		$other_con = array('data_tab_btn'=>$btn_arr,'display_image'=>array('og_image'),'enctype'=>'enctype="multipart/form-data"','field_duplicate'=>array('page_title'));
		
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted');
		$this->common_model->common_rander('seo_page_data', $status, $page , 'Seo Page Data',$ele_array,'page_title',0,$other_con);
	}
	public function view_detail($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			
			$field_main_array = array(				
				array(
					'title'=>'Page Title',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'Yes',
					'field_array'=>array(
						'page_title'=>'page_title',
					),
				),
				array(
					'title'=>'Seo Data',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'no',
					'field_array'=>array(
						'seo_title'=>'seo_title',
						'seo_description'=>'seo_description',
						'seo_keywords'=>'seo_keywords',
					),
				),
				array(
					'title'=>'Og Data',
					'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
					'is_single'=>'no',
					'field_array'=>array(
						'og_title'=>'og_title',
						'og_image'=>'og_image',
						'og_description'=>'og_description'
					),
				),
			);
			$data['back_detail_url'] = 'seo-pages';
			$data['field_list'] = $field_main_array;
			$this->common_model->table_name = 'seo_page_data'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('SEO Page Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'seo-page-data/seo-pages');
		}
	}
}