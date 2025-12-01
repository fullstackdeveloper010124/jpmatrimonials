<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Modify_photo extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->checkLogin();
		$this->load->model("front_end/modify_photo_model");
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{
		$base_url = $this->data['base_url'];
		$this->common_model->display_top_menu_perm = 'No';
		$this->data['register_data'] = $this->modify_photo_model->get_member_photo();
		//'css/owl.carousel.css',
		
		$this->common_model->extra_css_fr= array('css/chosen.css','css/canvasCrop.css','css/select2.css');
		$this->common_model->extra_js_fr= array('js/chosen.jquery.js','js/jquery.validate.min.js','js/jquery.canvasCrop.js','js/select2.min.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/modify_photo',$this->data);
		$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function upload_photo()
	{
		$response = $this->modify_photo_model->upload_photo_crope();
		$this->load->view('common_file_echo',$response);
	}
	public function upload_photo_new()
	{
		$response = $this->modify_photo_model->upload_photo_file();
		$this->load->view('common_file_echo',$response);
	}
	public function delete_photo()
	{
		$response = $this->modify_photo_model->delete_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function update_photo_view_status()
	{
		$response = $this->modify_photo_model->update_photo_view_status();
		$this->load->view('common_file_echo',$response);
	}
	public function set_profile_pic()
	{
		$response = $this->modify_photo_model->set_profile_pic();
		$this->load->view('common_file_echo',$response);
	}
}