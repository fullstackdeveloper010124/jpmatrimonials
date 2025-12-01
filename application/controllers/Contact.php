<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Contact extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/contact_model');
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{	
			// generate captcha
	// generate captcha
		$code = rand(100000,999999);
		$this->session->set_userdata('captcha_contact',$code);
		// generate captcha

		$where_array = "(page_title ='Contact Us' and status='APPROVED' and is_deleted ='No')";
		$cms_page_data = $this->common_model->get_count_data_manual('cms_pages',$where_array,1);
		$contact_data['contact_data']= $cms_page_data;

		$seo_title='';
		$seo_description ='';
		$seo_keywords='';
		$og_title = '';
		$og_description = '';
		$og_image = '';
		if(isset($cms_page_data['seo_title']) && $cms_page_data['seo_title'] !='')
		{
			$seo_title = $cms_page_data['seo_title'];
		}
		if(isset($cms_page_data['seo_description']) && $cms_page_data['seo_description'] !='')
		{
			$seo_description = $cms_page_data['seo_description'];
		}
		if(isset($cms_page_data['seo_keywords']) && $cms_page_data['seo_keywords'] !='')
		{
			$seo_keywords = $cms_page_data['seo_keywords'];
		}
		if(isset($cms_page_data['og_title']) && $cms_page_data['og_title'] !='')
		{
			$og_title = $cms_page_data['og_title'];
		}
		if(isset($cms_page_data['og_description']) && $cms_page_data['og_description'] !='')
		{
			$og_description = $cms_page_data['og_description'];
		}
		if(isset($cms_page_data['og_image']) && $cms_page_data['og_image'] !='')
		{
			$og_image = $cms_page_data['og_image'];
		}
		//$this->common_model->extra_css_fr= array('css/fontello.css');
		$this->common_model->extra_js_fr= array('js/jquery.sticky.js','js/jquery.gmaps.min.js','js/jquery.validate.min.js','js/additional-methods.min.js');
	    $this->common_model->front_load_header('','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/contact',$contact_data);
		$this->common_model->front_load_footer();
	}
	public function validate_captcha()
	{	
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_contact'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}
	public function submit_contact()
	{	
		$this->session->userdata('captcha_contact');
		$this->load->model('front_end/contact_model');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$data = $this->contact_model->validate_form();
		if($is_post ==0)
		{
			$data1['data'] = json_encode($data);
			$this->load->view('common_file_echo',$data1);
		}
		else
		{
			if($data['status'] =='success')
			{
				$this->session->set_flashdata('email_success_message',$data['errmessage']);
			}
			else
			{
				$this->session->set_flashdata('email_error_message', $data['errmessage']);
			}
			redirect(base_url().'contact');
		}					
	}
	public function admin()
	{
		$this->common_front_model->checkLogin();
		$base_url = $this->data['base_url'];
		//$this->common_model->extra_css_fr= array('css/bootstrap-touch-slider.css','css/mdb.min.css','css/hover-img.css','css/BootSideMenu.css','css/responsive.css');
		//$this->common_model->extra_js_fr= array('js/BootSideMenu.js');
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/select2.min.js');
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->front_load_header();
		$this->load->view('front_end/contact_admin',$this->data);
		$this->common_model->front_load_footer();
	}
	public function send_msg_admin()
	{
		$this->contact_model->send_msg_admin();
	}
}