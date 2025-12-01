<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Add_with_us extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/advertisement_model');
		//for upadate user after login activity
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{
		// generate captcha
		$code = rand(100000,999999);
		$this->session->set_userdata('captcha_ad_us',$code);
		// generate captcha
		//$this->common_model->display_top_menu_perm ='No';
		$this->common_model->extra_css_fr= array('css/select2.min.css');
		$this->common_model->extra_js_fr= array('js/jquery.validate.min.js','js/additional-methods.min.js');
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Add With Us'),1,'*','','');
		$seo_title='';
		$seo_description ='';
		$seo_keywords='';
		$og_title = '';
		$og_description = '';
		$og_image = '';
		if(isset($seo_data['seo_title']) && $seo_data['seo_title'] !='')
		{
			$seo_title = $seo_data['seo_title'];
		}
		if(isset($seo_data['seo_description']) && $seo_data['seo_description'] !='')
		{
			$seo_description = $seo_data['seo_description'];
		}
		if(isset($seo_data['seo_keywords']) && $seo_data['seo_keywords'] !='')
		{
			$seo_keywords = $seo_data['seo_keywords'];
		}
		if(isset($seo_data['og_title']) && $seo_data['og_title'] !='')
		{
			$og_title = $seo_data['og_title'];
		}
		if(isset($seo_data['og_description']) && $seo_data['og_description'] !='')
		{
			$og_description = $seo_data['og_description'];
		}
		if(isset($seo_data['og_image']) && $seo_data['og_image'] !='')
		{
			$og_image = $seo_data['og_image'];
		}
		$this->common_model->front_load_header('','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/add_with_us');
		$this->common_model->front_load_footer();
	}
	public function validate_captcha()
	{	
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_ad_us'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}
	public function advertisement_submit()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('addname', 'Advertisement Name', 'required');
		$this->form_validation->set_rules('link', 'Advertisement Link', 'required');
		$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
		$this->form_validation->set_rules('country_code', 'Country code','required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'required|callback_validate_captcha');
		//$this->form_validation->set_rules('file', 'Image', 'required');
		
		if($this->form_validation->run() == FALSE)
		{
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$return_arr = $this->advertisement_model->validate_form();
			$data['data'] = json_encode($return_arr);
		}
		$this->load->view('common_file_echo',$data);
	}
}