<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mobile_matri extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/mobile_matri_model');
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{	
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('captcha_code',$code);
		// generate captcha
		//$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/owl.carousel.css');
		$this->common_model->extra_js_fr= array ('js/owl.carousel.min.js','js/slider.js','js/jquery.validate.min.js','js/additional-methods.min.js');
		$base_url = $this->data['base_url'];
		
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Mobile Matrimony'),1,'*','','');
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
		
		$this->load->view('front_end/mobile_matri',$this->data);
		$this->common_model->front_load_footer();
	}
	public function validate_captcha()
	{
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}
	public function send_app_sms()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
			}
		}
		else
		{
			$return_arr = $this->mobile_matri_model->send_sms();
			$data['data'] = json_encode($return_arr);
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if(isset($return_arr['status']) && $return_arr['status'] == 'success')
			{
				if($this->session->userdata('captcha_code'))
				{
					$this->session->unset_userdata('captcha_code');
				}
				redirect($this->base_url.'mobile-matri');
			}
			else 
			{
				if(isset($return_arr['errmessage']) && $return_arr['errmessage'] !='')
				{
					$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				}
				redirect($this->base_url.'mobile-matri');
			}
		}	
	
	}
	
}