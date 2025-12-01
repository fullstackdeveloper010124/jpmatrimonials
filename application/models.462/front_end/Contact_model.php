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
		$user_agent = 'NI-WEB';
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
			if($this->input->post('user_agent')=='NI-AAPP')
			{
				$data1['errmessage'] =  strip_tags(validation_errors());
			}
			else{
				$data1['errmessage'] =  validation_errors();
			}
			$data1['status'] = 'error';
		}
		else
		{
			$this->contact_email_send();
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
		$contact_email = $config_arra['contact_email'];

		$name 	= $this->input->post('name');
		$email 	= $this->input->post('email');
		$phone 	= $this->input->post('phone');
		$subject = $this->input->post('subject');
		$phone = $this->input->post('phone');
		$country_code = $this->input->post('country_code');
		$description = $this->input->post('description');
		$phone = $country_code.'-'.$phone;
		$message = "<html>
					<head>
					</head>
					<body>
						<p>Dear admin,</p>
						<p>This mail is to inform you that someone has tried to contact you from your website $webfriendlyname.</p>
						
						<p>Following are the details that has been provided by him/her.</p>
						
						<p><strong>
						Name : $name<br />
						Email : $email<br />
						Contact No : $phone<br />
						Subject  : $subject<br />
						Suggestion / Feedback : $description<br />
						</p>
						<br /><br />
						<p>Regards ,<br />
						   $webfriendlyname,<br />
						   $web_name
					    </p>
					</body>
					</html>";
		$subject  = "$name has submitted contact us form on your website - $webfriendlyname ($web_name)";
		if($contact_email !="" && $message !="")
		{
			$this->common_model->common_send_email($contact_email,$subject,$message);
		}
	}
	public function send_msg_admin()
	{	
		$user_agent = 'NI-WEB';
		if($this->input->post('user_agent'))
		{
			$user_agent = $this->input->post('user_agent');
		}
		if($user_agent == 'NI-AAPP'){
			$subject="Report Missue";
			$from =  $this->input->post('matri_id');
		}else{
			$subject="Hello Admin";
			$from = $this->common_front_model->get_session_data('matri_id');
		}
		
		//$config_arra = $this->common_model->get_site_config();
		//$contact_email = $config_arra['contact_email'];
		
		
		$message = $this->input->post('message');
		$to="Admin";
		$status='sent';
		$msg_date = $this->common_model->getCurrentDate();//date('Y-m-d H:i:s');
		$data_array = array(
				'receiver'=>$to,
				'sender'=>$from,
				'subject'=>$subject,
				'content'=>$message,
				'sent_on'=>$msg_date,
				'status'=>$status
				);
		   $response = $this->common_front_model->save_update_data('message',$data_array);
		
			$where_arr= " (matri_id ='".$from."')";
			$member_data = $this->common_model->get_count_data_manual('register',$where_arr,1,'email','','','',"");
			
			$email =$member_data['email'];
			
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
			$webfriendlyname = $config_arra['web_frienly_name'];
			$admin_mail = $config_arra['contact_email'];
			
			$message = "<html>
						<head>
						</head>
						<body>
							<p>Dear $to,</p>
							<p><strong>User Query Message </strong><br /></p>
							<p>$message</p>
							
							<br />
							<p>Regards ,<br />
							   $webfriendlyname,<br />
							   $web_name
							</p>
						</body>
						</html>";
			$email_subject = "$from has sent you a query on - $webfriendlyname ($web_name)";
			
			if($admin_mail !="" && $message !="")
			{
				$this->common_model->common_send_email($admin_mail,$email_subject,$message);
			}
			
		if($user_agent == 'NI-AAPP')
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			if($response=="success"){
				$data1["status"] = "success";
				$data1["msg"] = "Your Message Sent Successfully";
				$data1["errmessage"] = "Your Message Sent Successfully";
			}else{
				$data1["status"] = "error";
				$data1["msg"] = "Please try again";
				$data1["errmessage"] = "Please try again";
			}
			$data["data"] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}else{
			
			$data = json_encode($response);
			$this->session->set_flashdata('success_message','Your Message Sent Successfully');
			redirect($this->base_url.'contact/admin');
		}
	}
	
	public function validate_form_vendor($id='')
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('phone', 'Contact No', 'required');
		$this->form_validation->set_rules('weddingdate', 'Wedding Date', 'required');
		$this->form_validation->set_rules('guest', 'Guest', 'required');
		$this->form_validation->set_rules('description', 'Description', 'required');
		$user_agent = 'NI-WEB';
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
			$this->vender_enquiry($id);
			$data1['errmessage'] =  "Vendor Enquiry form submitted successfully.";
			$data1['status'] = 'success';
		}
		return $data1;
	}
	public function vender_enquiry($id='')
	{
		// Working for send contact us email to admin
		$where_wedding_planner= " (id ='".$id."')";
		$wedding_planner_arr = $this->common_model->get_count_data_manual('wedding_planner',$where_wedding_planner,1,'email,planner_name','','','',"");
		$planner_name = '';
		$email ='';
		if(isset($wedding_planner_arr['email']) && $wedding_planner_arr['email'] && isset($wedding_planner_arr['planner_name']) && $wedding_planner_arr['planner_name'])
		{
			$planner_name = $wedding_planner_arr['planner_name'];
			$plan_email =$wedding_planner_arr['email'];
			
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
			$webfriendlyname = $config_arra['web_frienly_name'];
			$admin_main = $config_arra['contact_email'];
	
			$name 	= $this->input->post('name');
			$email 	= $this->input->post('email');
			$country_code = $this->input->post('country_code');
			$phone 	= $this->input->post('phone');
			$weddingdate = $this->input->post('weddingdate');
			$guest = $this->input->post('guest');
			$description = $this->input->post('description');
			
			$send_inq_info = $this->input->post('send_inq_info');
			if(isset($send_inq_info) && $send_inq_info !='' && count($send_inq_info) > 0)
			{
				$send_inq_info = implode(', ',$send_inq_info);
			}
			else
			{
				$send_inq_info = '';
			}
			$message = "<html>
						<head>
						</head>
						<body>
							<p>Dear $planner_name,</p>
							<p>This mail is to inform you that $name has tried to Send Enquiry from website $webfriendlyname( $web_name ).</p>
							
							<p>Following are the details that has been provided by him/her.</p>
							
							<p><strong>
							Name : $name<br />
							Email : $email<br />
							Phone No : $country_code-$phone<br />
							Wedding Date  : $weddingdate<br />
							Guest : $guest<br />
							Send me info via: $send_inq_info<br />
							Description : $description<br />
							</p>
							<br /><br />
							<p>Regards ,<br />
							   $webfriendlyname,<br />
							   $web_name
							</p>
						</body>
						</html>";
			$subject  = "$name has submitted Vendor Enquiry form on - $webfriendlyname ($web_name)";
			if($plan_email !="" && $message !="")
			{
				$this->common_model->common_send_email($plan_email,$subject,$message,$admin_main);
			}
		}
	}
	
	public function send_review($id='')
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('r_name', 'Name', 'required');
		$this->form_validation->set_rules('r_email', 'Email', 'required');
		$this->form_validation->set_rules('r_title', 'Review Title', 'required');
		$this->form_validation->set_rules('r_message', 'Review Message', 'required');
		$user_agent = 'NI-WEB';
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
			$r_name = $this->input->post('r_name');
			$r_email = $this->input->post('r_email');
			$r_title = $this->input->post('r_title');
			$r_message = $this->input->post('r_message');
			$r_star = $this->input->post('r_star');
			$r_date = $this->common_model->getCurrentDate();//date('Y-m-d H:i:s');
			
			$this->common_model->update_insert_data_common('vendor_reviews',array('vendor_id' => $id,'r_name' => $r_name,'r_email' => $r_email,'r_title' => $r_title,'r_message' => $r_message,'r_star' => $r_star,'r_date' => $r_date,'status' => 'UNAPPROVED'),'',0);
			
			$data1['errmessage'] =  "Review form submitted successfully.";
			$data1['status'] = 'success';
		}
		return $data1;
	}
	
	
	
}