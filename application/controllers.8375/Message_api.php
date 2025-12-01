<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Message_api extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/message_api_model');
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
	}

  	##Date 01/05/2025
	public function get_message_list($page=1)
	{
		$message_list_count = $this->message_api_model->get_message_list(0);
		$message_list = $this->message_api_model->get_message_list(1,$page);
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $message_list_count;
		if(isset($message_list_count) && $message_list_count!='' && $message_list_count > 0 && isset($message_list) && $message_list!='')
		{
			$data1['errormessage'] = 'Total Result found('.$message_list_count.')';
			$data1['errmessage'] = 'Total Result found('.$message_list_count.')';	
			$data1['data'] = $message_list;
		}
		else
		{
			$data1['data'] = '';
			$data1['errormessage'] = 'No data available';
			$data1['errmessage'] = 'No data available';
			$data1['continue_request'] = FALSE;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}

	##Date 01/05/2025
	public function update_status()
	{
		$result = $this->message_api_model->update_message_status();
		$response = [
			'tocken' => $this->security->get_csrf_hash(),
			'status' => $result['status'],
			'errmessage' => $result['message'],
		];
		$data['data'] = json_encode($response);
		$this->load->view('common_file_echo', $data);
	}

	##Date 01/05/2025
	public function get_member_list()
	{
		$str_ddr = array();
		$str_ddr = $this->message_api_model->get_member_list();

		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['dataStr'] = $str_ddr;
		$data['data'] = json_encode($data1);

		$this->load->view('common_file_echo',$data);
	}

	##Date 01/05/2025
	public function send_message()
	{
		$data = $this->message_api_model->send_message();
		$this->load->view("common_file_echo",$data);
	}

	##Date 01/05/2025
	public function view_message()
	{	
		$data = $this->message_api_model->view_message();
		$this->load->view("common_file_echo",$data);
	}


}