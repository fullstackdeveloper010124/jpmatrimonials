<?php defined('BASEPATH') OR exit('No direct script access allowed');
class User_profile extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{	
		$this->common_model->display_top_menu_perm ='No';
		$this->common_model->extra_css_fr= array('css/hover-img.css','css/mdb.min.css','css/bootstrap-touch-slider.css');
		$this->common_model->extra_js_fr= array('js/BootSideMenu.js');
		$this->common_model->front_load_header();
		$this->load->view('front_end/user_profile');
		$this->common_model->front_load_footer();
	}
	
}