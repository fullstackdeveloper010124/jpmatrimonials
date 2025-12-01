<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Homepage_management extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		//$this->common_model->check_admin_only_access();
		$this->load->model('back_end/SiteSetting_model','SiteSetting_model');
		$this->table_name = 'site_config'; 	// *need to set here tabel name //
		$this->common_model->set_table_name($this->table_name);
		
		$method_name = $this->common_model->method_name;
		if($method_name !='change_password' && $method_name !='save_change_password')
		{
			$this->common_model->check_admin_only_access();
		}
		$this->web_name = '';
	}
	public function index()
	{
		$this->basic_setting();
	}

	public function banner($status ='ALL', $page =1)
	{
		$ele_array = array(
			'banner'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->path_banner),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('banner'),'searchAllow'=>'no');
		$this->common_model->common_rander('homepage_banner', $status, $page , 'Home Page Banner',$ele_array,'id',0,$other_config);
	}

	public function logo_favicon($status ='')
	{
		$this->label_page = 'Update Logo & Favicon';
		if(isset($status) && $status == 'save-data')
		{
			if(isset($_FILES['upload_watermark']) && $_FILES['upload_watermark']['name'] !='')
			{
				$temp_data_array = array('file_name'=>'upload_watermark','upload_path'=>'assets/','allowed_types' =>'gif|jpg|png|jpeg|bmp');
				$data = $this->common_model->upload_file($temp_data_array);
				$file_path = 'assets/';
				if(isset($data['file_data']['file_name']) && $data['file_data']['file_name'] !='')
				{
					if(file_exists($file_path.'old_watermark.png'))
					{
						unlink($file_path.'old_watermark.png');
					}
					if(file_exists($file_path.'watermark.png'))
					{
						rename($file_path.'watermark.png',$file_path.'old_watermark.png');
					}
					if(!rename($file_path.$data['file_data']['file_name'],$file_path.'watermark.png'))
					{						
						rename($file_path.'old_watermark.png',$file_path.'watermark.png');
					}
					$this->session->set_flashdata('success_message', '<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>Data updated successfully.</div>');
				}
			}
			
			// for create or update htaccess for file path
					$photo_htacc = 'assets/photos/.htaccess';
					//error_reporting(E_ALL);
					$file = fopen($photo_htacc,"w+");
					$photo1_ht_content = "RewriteEngine on
RewriteRule ^(.*\.(gif|jp?g|png))$ ".base_url()."assets/photos/watermark.php?image=$1 [NC] ";
					fwrite($file,$photo1_ht_content);
					fclose($file);
					
					$photo_htacc = 'assets/photos_big/.htaccess';
					$file = fopen($photo_htacc,"w+");
					$photo1_ht_content = "RewriteEngine on
RewriteRule ^(.*\.(gif|jp?g|png))$ ".base_url()."assets/photos_big/watermark.php?image=$1 [NC] ";
					fwrite($file,$photo1_ht_content);
					fclose($file);
			// for create or update htaccess for file path
			//redirect($this->common_model->data['base_url_admin'].'site-setting/logo-favicon');
			
			$this->common_model->save_update_data(1,'','Yes');
		}
		else
		{
			$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
			$ele_array = array(
				'upload_logo'=>array('type'=>'file','path_value'=>'assets/logo/','display_note'=>'File size must be 300px * 40px'),
				'upload_footer_logo'=>array('type'=>'file','path_value'=>'assets/logo/','display_note'=>'File size must be 300px * 40px'),
				'upload_favicon'=>array('type'=>'file','path_value'=>'assets/logo/','display_note'=>'File size must be 75px * 75px'),
				'upload_watermark'=>array('type'=>'file','path_value'=>'assets/','value'=>'watermark.png','display_note'=>'File size must be 20px * 200px'),
			);
			$other_config = array('mode'=>'edit','id'=>'1','enctype'=>'enctype="multipart/form-data"');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function matri_prefix($status ='')
	{
		$this->label_page = 'Update Matri Prefix';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data(1,'','Yes');
		}
		else
		{
			$ele_array = array(
				'matri_prefix'=>array('is_required'=>'required')
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function color_change($status ='')
	{
		$this->label_page = 'Update Site Color';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data(1,'','Yes');
		}
		else
		{
			$ele_array = array(
				'colour_name'=>array('is_required'=>'required','input_type'=>'color'),
				'font_color'=>array('is_required'=>'required','input_type'=>'color')
			);
			$other_config = array('mode'=>'edit','id'=>'1','action'=>'site-setting/update_color');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function update_color()
	{
		$this->SiteSetting_model->update_color();
		$this->common_model->save_update_data();
		redirect($this->common_model->base_url_admin.'site-setting/color_change');
	}
	
	public function update_email($status ='')
	{
		$this->label_page = 'Update Email';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'from_email'=>array('is_required'=>'required','input_type'=>'email'),
				/*'to_email'=>array('is_required'=>'required','input_type'=>'eimal'),
				'feedback_email'=>array('is_required'=>'required','input_type'=>'email'),*/
				'contact_email'=>array('is_required'=>'required','input_type'=>'email','label'=>'To Email')
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function change_password($status ='')
	{
		$this->label_page = 'Change Password';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$extra_js = $this->common_model->extra_js;
			$extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
			$this->common_model->extra_js = $extra_js;
			$this->common_model->js_validation_extra = " rules: 
			  {
				confirm_password:
				{
					equalTo:'#new_password'
				},
			  },";
			$ele_array = array(
				'password'=>array('is_required'=>'required','other'=>'minlength="3" ','input_type'=>'password','label'=>'Current Password'),
				'new_password'=>array('is_required'=>'required','other'=>'minlength="3" ','input_type'=>'password'),
				'confirm_password'=>array('is_required'=>'required','other'=>'minlength="3" ','input_type'=>'password')
			);
			
			$other_config = array('mode'=>'edit','id'=>'1','action'=>'site-setting/save-change-password');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function save_change_password()
	{
		$this->SiteSetting_model->save_change_password();		
		redirect($this->common_model->base_url_admin.'site-setting/change-password');
	}
	
	public function basic_setting($status ='')
	{
		$this->label_page = 'Update Basic Site Settings';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data(1,'','Yes');
		}
		else
		{
			$ele_array = array(
				'web_name'=>array('is_required'=>'required','input_type'=>'url'),
				'web_frienly_name'=>array('is_required'=>'required','label'=>'Web Friendly Name'),
				'website_title'=>array('is_required'=>'required'),
				'website_description'=>array('type'=>'textarea','is_required'=>'required'),
				
				'footer_text'=>array('is_required'=>'required'),
				'success_story_text'=>array('type'=>'textarea','is_required'=>'required'),
				'contact_no'=>array('is_required'=>'required','input_type'=>'number'),
				'website_keywords'=>array('type'=>'textarea','is_required'=>'required'),
				'full_address'=>array('type'=>'textarea','is_required'=>'required'),
				'map_address'=>array('type'=>'textarea','is_required'=>'required'),
				'map_tooltip'=>array('is_required'=>'required'),
				'default_currency'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'currency_master','key_val'=>'currency_code','key_disp'=>'currency_name')),	// for relation dropdown
				'tax_applicable'=>array('type'=>'radio','value_arr'=>array('Yes'=>'Yes','No'=>'No')),
				'tax_name'=>array('is_required'=>'required'),
				'service_tax'=>array('is_required'=>'required','label'=>'Service Tax (%)','other'=>"min='0' max='100'"),
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function social_site_setting($status ='')
	{
		$this->label_page = 'Update Social Site Link';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'facebook_link'=>array('input_type'=>'url'),
				'twitter_link'=>array('input_type'=>'url'),
				'linkedin_link'=>array('input_type'=>'url'),
				'google_link'=>array('input_type'=>'url','label'=>'Instagram'),
				'skype_id'=>array(),
			);
			$other_config = array('mode'=>'edit','id'=>'1','addAllow'=>'no','deleteAllow'=>'no');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);
				
			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function analytics_code_setting($status ='')
	{
		$this->label_page = 'Update Google Analytics Code';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'google_analytics_code'=>array('type'=>'textarea')
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	public function social_app_man($status ='ALL', $page =1)
	{
		$ele_array = array(
			'social_name'=>array('is_required'=>'required'),
			'client_key'=>'',
			'client_secret'=>'',
			'status'=>array('type'=>'radio')
		);
		$this->common_model->common_rander('social_login_master', $status, $page , 'Social Application',$ele_array,'social_name',1);
	}
	
	public function currency_man($status ='ALL', $page =1)
	{
		$ele_array = array(
			'currency_name'=>array('is_required'=>'required'),
			'currency_code'=>array('is_required'=>'required'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->js_validation_extra.= '
			rules: {
				currency_name: {
				  required: true,
				  lettersonly: true
				},
				currency_code: {
				  required: true,
				  lettersonly: true
				}
			 },
		';
		$other_config = array('field_duplicate'=>array('currency_name'));
		$this->common_model->common_rander('currency_master', $status, $page , 'Currency',$ele_array,'currency_name',1,$other_config);
	}
	
	public function app_link($status ='')
	{
		$this->label_page = 'Update App Link';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'android_app_link'=>array('input_type'=>'url'),
				'ios_app_link'=>array('input_type'=>'url')
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function homepage_text($status ='')
	{
		$this->label_page = 'Update Homepage Text';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'homepage_banner_text'=>array('label'=>'Homepage Banner Title','is_required'=>'required'),
				'homepage_banner_description'=>array('label'=>'Homepage Banner Subtitle','type'=>'textarea'),
				'middle_text1'=>array('label'=>'First Section Title','is_required'=>'required'),
				'middle_text1_description'=>array('label'=>'First Section Subtitle','type'=>'textarea'),
				'sign_up_text'=>array('is_required'=>'required','type'=>'textarea'),
				'browse_profile_text'=>array('is_required'=>'required','type'=>'textarea'),
				'contact_text'=>array('is_required'=>'required','type'=>'textarea'),
				'interact_text'=>array('is_required'=>'required','type'=>'textarea'),
				'middle_text2'=>array('label'=>'Fifth Section Title','is_required'=>'required'),
				'middle_text2_description'=>array('label'=>'Fifth Section Subtitle','type'=>'textarea'),
				'reason_why_choose_text'=>array('label'=>'Six Section Description','type'=>'textarea'),
				
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	public function other_banner($status ='')
	{
		$this->label_page = 'Update Home Banner & Text';
		$this->table_name = 'other_banner';// *need to set here tabel name //
		$this->common_model->set_table_name($this->table_name);
		
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
			redirect($this->common_model->data['base_url_admin'].'new-listing/other_banner');
		}
		else
		{
			$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
			$ele_array = array(
				'other_banner1'=>array('label'=>'Wedding Wendor Banner','is_required'=>'required','type'=>'file','path_value'=>$this->common_model->other_banner),
				//'other_banner1_logo'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->other_banner),
				'other_banner1_title'=>array('label'=>'Wedding Wendor Title','is_required'=>'required'),
				'other_banner1_description'=>array('label'=>'Wedding Wendor Subtitle','is_required'=>'required','type'=>'textarea'),
				'other_banner2'=>array('label'=>'Mobile Matrimony Banner','is_required'=>'required','type'=>'file','path_value'=>$this->common_model->other_banner),
				'mobile_matrimony_description'=>array('is_required'=>'required','type'=>'textarea'),
				//'horizontal_banner'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->other_banner,'inline_style'=>'background:rgba(49,33,248,0.95);'),
				//'status'=>array('type'=>'radio')
			);
			
			$other_config = array('mode'=>'edit','id'=>'1','enctype'=>'enctype="multipart/form-data"');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}	
	}
	
	public function reason_why_choose($status ='ALL', $page =1)
	{
		$ele_array = array(
			'title'=>array('is_required'=>'required'),
			'description'=>array('is_required'=>'required','type'=>'textarea'),
			'icon'=>array('is_required'=>'required','type'=>'file','path_value'=>'assets/reason_why_to_choose/'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('icon'),'searchAllow'=>'no');
		$this->common_model->common_rander('reason_why_choose', $status, $page , 'Reason Why Choose',$ele_array,'id',0,$other_config);
	}
	public function generate_sitemap(){
		$config_arra = $this->common_model->get_site_config();
		$this->web_name = $config_arra['web_name'];
		$myFile = "sitemap.xml";
		$rss_txt='';
		$fh = fopen($myFile, 'w+') or die("can't open file");
$rss_txt .= '<?xml version="1.0" encoding="utf-8"?>
<urlset
	xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
	http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';
						
		$site_array = array("register","login","cms/faq","about-us","search/quick","search/advance","search/keyword","search/id","premium-member","success-story","contact","faq","mobile-matri","demograph","privacy-policy","refund-policy","report-misuse","terms-condition","login/forgot-password","success-story/add-story","blog","event","wedding-vendor","contact","add-with-us");
		
	$rss_txt .= '
	<url>
		<loc>'.$this->web_name.'</loc>
		<priority>1.00</priority>
	</url>';
		foreach($site_array as $site_array_val){
	$rss_txt .= '
	<url>
		<loc>'.$this->web_name.$site_array_val.'</loc>
		<priority>0.80</priority>
	</url>';
		}
		$rss_txt .= $this->get_table_data("blog_master", "blog/", "0.64");
		$rss_txt .= $this->get_table_data("success_story", "success_story/details/", "0.51");
		$rss_txt .= $this->get_table_data("events", "event/details/", "0.41");
		$rss_txt .= $this->get_table_data("wedding_planner", "wedding-vendor/details/", "0.80");
		$rss_txt .= $this->get_table_data("country_master", "matrimony/", "0.80",'rand()','1','8');
		$rss_txt .= $this->get_table_data("religion", "matrimony/", "0.80",'rand()','1','8');
		$rss_txt .= $this->get_table_data("city_master", "matrimony/", "0.80",'rand()','1','8');
		$rss_txt .= $this->get_table_data("caste", "matrimony/", "0.80",'rand()','1','8');
		$rss_txt .= $this->get_table_data("mothertongue", "matrimony/", "0.80",'rand()','1','8');
		$rss_txt .= '
</urlset>';
		
		fwrite($fh, $rss_txt);
		fclose($fh);
		echo 'success';
	}
	function get_table_data($table_name='',$site_url='',$priority='',$order_by = '',$page = '',$limit = '')
	{
		$data = $this->common_model->get_count_data_manual($table_name,array("status"=>"APPROVED","is_deleted"=>"No"),2,"*",$order_by,$page,$limit);
		$data_new = "";
		if(isset($data) && $data!='' && is_array($data) && count($data)>0){
			foreach($data as $data_val){
				$id = $data_val['id'];
				if($table_name == 'blog_master'){
					$id = $data_val['alias'];
				}
				if($table_name == 'country_master'){
					$country = str_ireplace(" ","-",$data_val['country_name']);
					$id = $country.'-matrimony';
				}
				if($table_name == 'religion'){
					$religion = str_ireplace(" ","-",$data_val['religion_name']);
					$id = $religion.'-matrimony';
				}
				if($table_name == 'city_master'){
					$city = str_ireplace(" ","-",$data_val['city_name']);
					$id = $city.'-matrimony';
				}
				if($table_name == 'caste'){
					$caste = str_ireplace(" ","-",$data_val['caste_name']);
					$id = $caste.'-matrimony';
				}
				if($table_name == 'mothertongue'){
					$mothertongue = str_ireplace(" ","-",$data_val['mtongue_name']);
					$id = $mothertongue.'-matrimony';
				}
	$data_new .= '
	<url>
		<loc>'.$this->web_name.$site_url.$id.'</loc>
		<priority>'.$priority.'</priority>
	</url>';
			}
		}
		return $data_new;
	}
	// changes for shakil 22-12-2020
	public function seo_pages($status ='ALL', $page =1)
	{
		$ele_array = array(
			'page_title'=>array('is_required'=>'required','class'=>' not_reset ','type'=>'dropdown','value_arr'=>array('Home'=>'Home','Register Now'=>'Register Now','Login'=>'Login',
				'Forgot Password'=>'Forgot Password','Quick Search'=>'Quick Search','Advance Search'=>'Advance Search','Keyword Search'=>'Keyword Search','Id Search'=>'Id Search','Upgrade'=>'Upgrade','Success Story'=>'Success Story','Add Story'=>'Add Story','Wedding Vendor'=>'Wedding Vendor','Event'=>'Event','Add With Us'=>'Add With Us','Blog'=>'Blog','Member Demographics'=>'Member Demographics','Mobile Matrimony'=>'Mobile Matrimony','religion'=>'Religion','Caste'=>'Caste','country'=>'Country','state'=>'State','city'=>'City','Mother-Tongue'=>'Mother Tongue')),
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
			array('url'=>'site-setting/view-detail/#id#','class'=>'info','label'=>'View Detail'),
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
			$this->common_model->common_view_detail('SEO Page Data',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'site-setting/seo-pages');
		}
	}
	public function banner_quick_info($status ='ALL', $page =1)
	{
		$ele_array = array(
			'description'=>array('is_required'=>'required','type'=>'textarea'),
			'icon'=>array('is_required'=>'required','type'=>'file','path_value'=>'assets/banner_quick_info/'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('icon'),'searchAllow'=>'no');
		$this->common_model->common_rander('banner_quickinfo', $status, $page , 'Banner Quick Info',$ele_array,'id',0,$other_config);
	}
}