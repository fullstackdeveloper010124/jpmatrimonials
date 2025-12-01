<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->common_model->front_load_header();
	}
	public function i2()
	{
		$this->data = $this->common_model->data;
		$this->load->view('front_end/page_part/header',$this->data);
	}
	public function i3()
	{
		$this->data = $this->common_model->data;
		$this->load->view('front_end/page_part/header_after_login',$this->data);
	}
	public function i4()
	{
		$this->data = $this->common_model->data;
		$this->load->view('front_end/page_part/header_home',$this->data);
	}
	
	
}
