<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Blocked extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
	}
	public function index()
	{
		$this->common_model->front_load_header('Blocked - Mega Matrimony');
		$this->load->view('front_end/blocked_view');
		//$this->Common_model->front_load_footer();
	}
	/*public function blocked()
	{
		$this->common_model->front_load_header('Blocked - Mega Matrimony');
		$this->load->view('front_end/blocked_view');
		//$this->Common_model->front_load_footer();
	}*/
}