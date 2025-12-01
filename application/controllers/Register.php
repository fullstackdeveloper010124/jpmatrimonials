<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/register_model');
		$this->common_model->is_demo_mode = 0;
		
	}
	public function index()
	{
		$this->common_front_model->already_login_redirect();
		//$insert_id = $this->session->unset_userdata('recent_reg_id');
		if(isset($insert_id) && $insert_id != '' )
		{
			redirect($this->base_url.'register/step2');
		}
		$base_url = $this->data['base_url'];
		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$this->common_model->extra_css_fr= array('css/select2.min.css');
		$this->common_model->css_extra_code_fr.='
		@media only screen and (max-device-width: 480px) and (min-device-width: 320px){
			.select2-container {
				margin-top:0px!important;
			}
			.mtc-10 {
				margin-top: 0px;
			}
		}
		.md-radio label {
			height: 4px;
		}
		.select2-container--default .select2-selection--single {
			margin-bottom: 2px;
			height: 44px;
			border: 1px solid #e3e3e3;
			-webkit-appearance: none;
			color: #9d9d9d;
			border-radius: 4px
		}
		.select2-container .select2-selection--single .select2-selection__rendered {
			text-align: left;
			padding: 5px 5px 5px 27px;
		}';
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Register Now'),1,'*','','');
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
		$cms_pages_data = $this->common_model->get_count_data_manual('cms_pages',array('page_url'=>'terms-condition','status'=>'APPROVED'),1);
		$this->data['cms_pages']= $cms_pages_data;
		$where_fb = array("status"=>'APPROVED',"is_deleted"=>'No','id'=>'1');
		$get_fb_details = $this->common_front_model->get_count_data_manual('social_login_master',$where_fb,'1','social_name,client_key,client_secret');
		$this->data['fb_detail'] = "";
		if($get_fb_details!='' && count($get_fb_details) > 0 )
		{ 
		   $this->data['fb_detail'] = $get_fb_details;
		}
		$this->load->view('front_end/register',$this->data);
	}
	
	public function check_duplicate()
	{
		$this->common_front_model->set_orgin();		
		$response = $this->register_model->check_duplicate();
		$this->load->view('common_file_echo',$response);
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
	
	public function save_register()
	{
		$is_post = 0;
		$this->common_front_model->set_orgin();
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$response = $this->register_model->save_register($is_post);
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$response);
		}
		else
		{
			if($response =='success'){
				$method = 'index';
			}
			else{
				$method = 'step2';
			}
			redirect($this->base_url.'register/'.$method);
		}
	}
	public function step2()
	{
		$this->common_front_model->already_login_redirect();
		
			//$this->session->set_userdata('recent_reg_id',1);
		$insert_id = $this->session->userdata('recent_reg_id');
		if(!isset($insert_id) || $insert_id == '' )
		{
			redirect($this->base_url.'register/index');
		}
		$base_url = $this->data['base_url'];
		//$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/canvasCrop.css','css/chosen.css','css/select2.css');
		$this->common_model->extra_js_fr= array('js/jquery.canvasCrop.js','js/chosen.jquery.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/register_next');
	}
	public function save_register_step($step='step1')
	{	
		$is_post = 0;
		$this->common_front_model->set_orgin();
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$response = $this->register_model->save_register_step($is_post,$step);
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$response);
		}
		else
		{		
			redirect($this->base_url.'register/step2/'.$step);
		}
	}
	
	public function successful()
	{
		$this->common_front_model->already_login_redirect();
		$insert_id = $this->session->userdata('recent_reg_id');
		if(isset($insert_id) && $insert_id != '' )
		{
			//$this->register_model->sent_confirm_mail_message_user();
			//$this->register_model->set_login_register_user();
		}
		if($this->session->userdata('member_fb_data'))
		{
			$this->session->unset_userdata('member_fb_data');
		}
		//$this->common_front_model->checkLogin();
		$base_url = $this->data['base_url'];
		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->is_body1_class = 'Yes';
		//$this->common_model->extra_css_fr[] = 'css/bootstrap-touch-slider.css';
		$this->common_model->front_load_header();
		$this->load->view('front_end/registration_successful');
	}
	
	public function confirm_mail($cpassword='',$email=''){
		if($cpassword != '' && $email != ''){
			$this->register_model->confirm_mail_id($cpassword,$email);
		}
	}
	
	public function partner_preference()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		if(isset($insert_id) && $insert_id != '' )
		{
			$base_url = $this->data['base_url'];
			$this->common_model->display_top_menu_perm = 'No';
			$this->common_model->extra_css_fr= array('css/chosen.css','css/select2.css');
			$this->common_model->front_load_header();
			$this->load->view('front_end/register_partner_preferance',$this->data);
		}else{
			redirect($this->base_url.'register');
		}
	}
	
	public function save_profile($step ='basic-detail')
	{
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$response = $this->register_model->save_profile($is_post,$step);
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$response);
		}
		else
		{		
			redirect($this->base_url.'premium-member');
		}
	}
	
	public function fb_signup()
	{
		$where = array("status"=>'APPROVED',"is_deleted"=>'No','id'=>'1');
		$get_fb_details = $this->common_front_model->get_count_data_manual('social_login_master',$where,'1','social_name,client_key,client_secret');
		$this->data['fb_detail'] = "";
		if($get_fb_details!='' && count($get_fb_details) > 0 )
		{ 
		   $this->data['fb_detail'] = $get_fb_details;
		}
		$this->load->view('front_end/fg_config',$this->data);
	}
	public function married_brother_list_new()
	{
		$this->load->view('front_end/no_married_brother');
	}

	public function send_mail_member(){ 
		$this->register_model->send_mail_member();
		$data1['status'] = 'success';
		$data1['errmessage'] =  'Email sent.';
		$data1['data'] =  array();
		echo json_encode($data1);
	}

	public function refreshCaptcha(){
        $responseArr['status'] = 'error';
        $responseArr['errmessage'] = 'Something went wrong!';
		$responseArr['token'] = $this->security->get_csrf_hash();
        $responseArr['data'] = $this->common_model->generateCaptcha('loginCode');
        if(!empty($responseArr['data'])){
            $responseArr['status'] = 'success';
            $responseArr['errmessage'] = 'New Captcha created.';
        }
        echo json_encode($responseArr);
    }
}