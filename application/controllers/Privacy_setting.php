<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Privacy_setting extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->checkLogin();
		$this->load->model('front_end/my_profile_model');
		$this->load->model('front_end/privacy_model');
		$this->common_front_model->last_member_activity();
	}
	public function index($page=1)
	{	
		$this->data['tab_active'] = 'block';
		if($page=='change-password')
		{
			$this->data['tab_active'] = 'change_password';
			$page =1;
		}
		$this->data['page_name'] = 'Privacy setting Block Listed Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->block_list_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->block_list_profile(1,$page);
		$this->common_model->display_top_menu_perm ='No';
		$this->common_model->extra_css_fr= array('css/chosen.css');
		$this->common_model->extra_js_fr= array('js/BootSideMenu.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/privacy_setting',$this->data);
		$this->common_model->front_load_footer();
	}
	public function block_profile()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('blockuserid', 'Matri ID', 'required');
		
		if($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] = validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			if($user_agent!='NI-WEB')
			{
				$this->load->model('front_end/search_model');
				$response = $this->search_model->add_blocklist();
				$data['data'] = json_encode($response);
				$this->load->view('common_file_echo',$data);
			
			}else{
				$return_arr =$this->privacy_model->block_profile();
				$this->data['page_name'] = 'Privacy setting Block Listed Profile';
				$this->data['base_url'] = base_url();
				$this->data['shortlist_data_count'] = $this->my_profile_model->block_list_profile(0);
				$this->data['shortlist_data'] = $this->my_profile_model->block_list_profile(1,1);
				$return_arr['block_profile_code'] = $this->load->view('front_end/short_listed_member_profile',$this->data,true);
				$data['data'] = json_encode($return_arr);
				$this->load->view('common_file_echo',$data);
			}	
		}
	}
	public function photo_visibility()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('photo_password', 'password', 'required');
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			$this->privacy_model->photo_visibility();
		}
	}
	public function remove_photo_visibility()
	{
		$this->privacy_model->photo_visibility();
	}
	public function photo_view_status()
	{
		$this->privacy_model->photo_visibility();
	}
	public function contact_privacy_setting()
	{
		$this->privacy_model->contact_privacy_setting();
	}
	public function change_password()
	{	
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('old_pass', 'Old password', 'required');
		$this->form_validation->set_rules('new_pass', 'New password', 'required');
		$this->form_validation->set_rules('cnfm_pass', 'Confirm password', 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			$return_arr =$this->privacy_model->change_password();
			$data['data'] = json_encode($return_arr);
			$this->load->view('common_file_echo',$data);
		}
	}
	
	public function photo_visibility_for_mobile_app()
	{
		$action = $this->input->post('action');
		
		if(isset($action) && $action != ''){
			$this->privacy_model->photo_visibility();
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = 'Please try Again.';
			$data1['token'] = $this->security->get_csrf_hash();
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
	}
	public function block_listed($page=1)
	{	
		$this->data['page_name'] = 'Privacy setting Block Listed Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->block_list_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->block_list_profile(1,$page);
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !=''){
			$is_ajax = $this->input->post('is_ajax');
		}
		$data['base_url']=$this->data['base_url'];		
		$this->common_model->extra_css_fr= array('css/select2.css','css/chosen.css','css/popup_user.css');
		$this->common_model->extra_js_fr= array('js/select2.min.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/photo_protect_js.js');
		if($is_ajax == 0)
		{	
			$this->common_model->display_top_menu_perm ='No';
			$this->common_model->front_load_header();
			$this->load->view('front_end/'.$file_name,$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			$this->load->view('front_end/short_listed_member_profile',$this->data);
		}
	}
}