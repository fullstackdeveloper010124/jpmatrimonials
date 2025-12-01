<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Upload extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->checkLogin();
		$this->load->model("front_end/upload_model");
		$this->load->model("front_end/modify_photo_model");
		$this->common_front_model->last_member_activity();
		//ini_set ('gd.jpeg_ignore_warning', 1);
		error_reporting(0);
	}
	public function index()
	{
		$this->video();
	}
	public function video()
	{
		$this->common_model->display_top_menu_perm ='No';		
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/jquery.validate.min.js','js/select2.min.js');
		$data['video_data'] = $this->upload_model->get_video_data();
		$this->common_model->front_load_header();
		$this->load->view('front_end/upload_video',$data);
		//$this->load->view('front_end/photo_protect',$data);
		$this->common_model->front_load_footer();
	}
	public function cover_photo()
	{	
		$this->common_model->display_top_menu_perm ='No';
		$this->data['register_data'] = $this->modify_photo_model->get_member_photo();
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/jquery.validate.min.js','js/select2.min.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/upload_cover_photo',$this->data);
		//$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function upload_cover_photo()
	{
		$response = $this->modify_photo_model->upload_photo_crope();
		$this->load->view('common_file_echo',$response);
	}
	public function delete_cover_photo()
	{
		$response = $this->modify_photo_model->delete_cover_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function horoscope()
	{	
		$this->common_model->display_top_menu_perm ='No';
		$this->data['register_data'] = $this->modify_photo_model->get_member_photo();
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/jquery.validate.min.js','js/select2.min.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/upload_horoscope',$this->data);
		//$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function upload_horoscope_photo()
	{
		$response = $this->modify_photo_model->upload_horoscope_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function delete_horoscope_photo()
	{
		$response = $this->modify_photo_model->delete_horoscope_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function upload_horoscope()
	{
		$data = $this->upload_model->upload_horoscope();
		$this->load->view('common_file_echo',$data);
	}
	
	public function id_proof()
	{	
		$this->common_model->display_top_menu_perm ='No';
		$this->data['register_data'] = $this->modify_photo_model->get_member_photo();
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/jquery.validate.min.js','js/select2.min.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/upload_id_proof',$this->data);
		//$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function upload_id_proof_photo()
	{
		$response = $this->modify_photo_model->upload_id_proof_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function delete_id_proof_photo()
	{
		$response = $this->modify_photo_model->delete_id_proof_photo();
		$this->load->view('common_file_echo',$response);
	}
	public function upload_id_proof()
	{
		$data = $this->upload_model->upload_id_proof();
		$this->load->view('common_file_echo',$data);
	}
	
	public function add_video()
	{
		$data = $this->upload_model->add_video();
		$this->load->view('common_file_echo',$data);
	}
	public function delete_video()
	{
		$data = $this->upload_model->delete_video();
		$this->load->view('common_file_echo',$data);
	}
	
	public function horoscope_action()
	{
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
		{
			$delete_horoscope_photo = $this->input->post('delete_horoscope_photo');
			if(isset($delete_horoscope_photo) && $delete_horoscope_photo == 'delete'){
				$response = $this->modify_photo_model->delete_horoscope_photo();
				$this->load->view('common_file_echo',$response);
			}else{
				$data = $this->upload_model->upload_horoscope();
				$this->load->view('common_file_echo',$data);
			}
		}
	}	
}