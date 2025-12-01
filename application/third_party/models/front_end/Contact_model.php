<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Contact_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function validate_form()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('phone', 'Contact No', 'required');
		$this->form_validation->set_rules('subject', 'Subject', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('description', 'Suggestion / Feedback', 'required');
		if($this->input->post('user_agent'))
		{
			$user_agent = $this->input->post('user_agent');
		}
		if($user_agent == 'NI-WEB')
		{
			$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'required|callback_validate_captcha');
		}
		$data1['token'] = $this->security->get_csrf_hash();
		if ($this->form_validation->run() == FALSE)
        {
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
		}
		else
		{
			//$this->contact_email_send();
			$data1['errmessage'] =  "Contact us form submitted successfully.";
			$data1['status'] = 'success';
		}
		return $data1;
	}
	public function contact_email_send()
	{
		// Working for send contact us email to admin
		$config_arra = $this->common_model->get_site_config();
		$web_name = $config_arra['web_name'];
		$webfriendlyname = $config_arra['web_frienly_name'];
		$username = $data_email['username'];
		$c_password = $data_email['c_password'];
		$email = $data_email['email'];
		$forgot_password_link = $web_name."login/reset-password/$c_password/$email";
		$forgot_password_link = '<a target="_blank" href="'.$forgot_password_link.'">'.$forgot_password_link.'</a>';
		$message = "<html>
					<head>
					<title><h1>Your new password</h1></title>
					</head>
					<body>
						<h6>Dear user,</h6>
						<p><strong>This is the mail regarding the password change request for your account, please update your password via below link.</strong></p>
						<p><br />
						<strong>Please click the below link and set the new password for your account at&nbsp;webfriendlyname.<br />
						Password reset Link :&nbsp;forgot_password_link</strong></p>
						<p>Regards ,</p>
						<p>webfriendlyname</p>
					</body>
					</html>";
		$array_repla = array('webfriendlyname'=>$webfriendlyname,'forgot_password_link'=>$forgot_password_link);					
		$message_email = $this->common_model->getstringreplaced($message,$array_repla);
		$to_email = $email;
		$subject  = 'Password reset for your account on webfriendlyname';
		$subject = $this->common_model->getstringreplaced($subject,$array_repla);
		
		if($to_email !="" && $message !="")
		{
			$msg = $this->common_model->common_send_email($to_email,$subject,$message_email);
		}
	}
	public function send_msg_admin()
	{	
		$from = $this->common_front_model->get_session_data('matri_id');	
		$subject="Hello Admin";
		$message = $_POST['message'];
		$to="admin";
		$status='sent';
		$msg_date = date('Y-m-d H:i:s');
		$data_array = array(
				'receiver'=>$to,
				'sender'=>$from,
				'subject'=>$subject,
				'content'=>$message,
				'sent_on'=>$msg_date,
				'status'=>$status
				);
		$response = $this->common_front_model->save_update_data('message',$data_array);
		$data = json_encode($response);
		$this->session->set_flashdata('success_message','Your Message Sent Successfully');
		redirect($this->base_url.'contact/admin');
	}
	
}