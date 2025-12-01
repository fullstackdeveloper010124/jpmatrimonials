<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Error_page extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
	}
	public function index()
	{	
		$this->output->set_status_header('404');
		$base_url = $this->data['base_url'];
		$this->common_model->extra_css_fr= array('css/fontello.css');
		$this->common_model->front_load_header();
		$this->load->view('front_end/404_error');
		$this->common_model->front_load_footer();
	}
}