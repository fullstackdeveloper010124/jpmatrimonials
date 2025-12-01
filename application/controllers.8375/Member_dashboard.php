<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member_dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/bootstrap-touch-slider.css','css/mdb.min.css','css/hover-img.css','css/BootSideMenu.css');
		$this->common_model->extra_js_fr= array('js/BootSideMenu.js');
		
		$base_url = $this->data['base_url'];
		$this->common_model->front_load_header();
		$this->load->view('front_end/member_dashboard',$this->data);
		$this->common_model->front_load_footer();
	}
	
}