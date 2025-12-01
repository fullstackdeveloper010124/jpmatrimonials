<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Change_password extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{	
		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$this->common_model->front_load_header();
		$this->load->view('front_end/change_password');
	}
}