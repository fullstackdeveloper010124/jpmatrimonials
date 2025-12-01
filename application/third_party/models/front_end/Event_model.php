<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Event_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}

	public function save_event()
	{		
			$this->data['event_payment_data'] = $this->session->userdata('event_payment_session');
			$event_payment_data = $this->data['event_payment_data'];
			/*echo"<pre>";
			print_r($event_payment_data);
			echo"</pre>";*/
			
			$confirm_email = $this->input->post('confirm_email');
			$user_how_hear = $this->input->post('user_how_hear');
			$confirm_mobile = $this->input->post('confirm_mobile');
			$CurrentDate = $this->common_model->getCurrentDate();
			$this->common_model->created_on_fild = 'created_on';
			
			/*$this->common_model->set_table_name('event_registered_people');
			$response = $this->common_model->save_update_data(1,1);
			$data = json_decode($response, true);		
			if(isset($data['status']) && $data['status'] =='success')
			{	
				$this->session->set_flashdata('success_message','Your Event Payment Submit successfully');
			}
			else
			{
				$this->session->set_flashdata('error_message', $data['response']);
			}*/
		//redirect(base_url().'event/details');
	
	}
}
?>