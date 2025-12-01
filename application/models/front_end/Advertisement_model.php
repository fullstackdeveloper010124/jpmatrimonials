<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Advertisement_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function validate_form()
	{
		$addname_post = $this->input->post('addname');
		$link_post = $this->input->post('link');
		$contact_person_post = $this->input->post('contact_person');
		$country_code = $this->input->post('country_code');
		$phone_post = $this->input->post('phone');
		$this->advertisement_email_send();
		
		$status = 'success';
		$return_message = "Your details have been sent, We will contact you soon.";
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return ($return_arr);
	}
	public function advertisement_email_send()
	{
		$config_arra = $this->common_model->get_site_config();
		$web_name = $config_arra['web_name'];
		$webfriendlyname = $config_arra['web_frienly_name'];
		$contact_email = $config_arra['contact_email'];

		$addname_post = $this->input->post('addname');
		$link_post = $this->input->post('link');
		$contact_person_post = $this->input->post('contact_person');
		$country_code = $this->input->post('country_code');
		$phone_post = $this->input->post('phone');

		$message = "<html>
					<head>
					</head>
					<body>
						<p>Dear admin,</p>
						<p>This mail is to inform you that someone has fill up 'Advertise With us' from your website $webfriendlyname.</p>
						
						<p>Following are the details that has been provided by him/her.</p>
						
						<p><strong>
						Advertise Name : $addname_post<br />
						Advertise Link : $link_post<br />
						Contact No : $country_code-$phone_post<br />
						Contact Person : $contact_person_post<br />
						</p>
						<br /><br />
						<p>Regards,<br />
						   $webfriendlyname,<br />
						   $web_name
						</p>
					</body>
					</html>";
		$subject  = "$contact_person_post has submitted Advertise With us form on your website - $webfriendlyname ($web_name)";
		if($contact_email !="" && $message !="")
		{
			$this->common_model->common_send_email($contact_email,$subject,$message);
		}
	}
}