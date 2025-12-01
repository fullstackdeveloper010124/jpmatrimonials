<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Event_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}

	public function save_event($status)
	{		
		$plan_details = $this->session->userdata('event_data_session');
		if(isset($plan_details) && $plan_details!= '')
		{
			$confirm_email = $plan_details['confirm_email'];
			$user_how_hear = $plan_details['user_how_hear'];
			$country_code = $plan_details['country_code'];
			$confirm_mobile = $plan_details['confirm_mobile'];
			if(isset($country_code) && $country_code!=''){
				$confirm_mobile = $country_code.'-'.$plan_details['confirm_mobile'];
			}
			$event_name = $plan_details['title'];
			$event_location = $plan_details['location'];
			$tickets_opted_for = $plan_details['no_of_ticket'];
			$event_currency = $plan_details['ticket_currency'];
			if(!isset($plan_details['total_amount'])){
				$total_amount = 0;
			}else{
				$total_amount = $plan_details['total_amount'];
			}
			$payment_made = 'No';
			if(isset($status) && $status == 'success'){
				$payment_made = 'Yes';
			}
			$CurrentDate = $this->common_model->getCurrentDate();
			
			$get_event_date = $this->common_model->get_count_data_manual('events',array('id'=>$plan_details['event_id']),1,'*');
			$event_date = $get_event_date['event_date'];
			
			$data_array = array(
				'confirm_email'=>$confirm_email,
				'confirm_mobile'=>$confirm_mobile,
				'user_how_hear'=>$user_how_hear,
				'event_date'=>$event_date,
				'event_name'=>$event_name,
				'event_location'=>$event_location,
				'tickets_opted_for'=>$tickets_opted_for,
				'event_currency'=>$event_currency,
				'total_amount'=>$total_amount,
				'payment_made'=>$payment_made,
				'register_on'=>$CurrentDate,
			);
			
			$response = $this->common_front_model->save_update_data('event_registered_people',$data_array);
			
			if(isset($response) && $response =='success')
			{
				$this->session->set_flashdata('success_message','Your Event Registration Successfully Done.');
			}
			else
			{
				$this->session->set_flashdata('error_message', $data['response']);
			}
		}else{
			$this->session->set_flashdata('error_message', 'Some error occured,Please try again');
		}
	}
	
	public function send_mail()
	{		
		$config_arra = $this->common_model->get_site_config();
		$web_name = $config_arra['web_name'];
		$webfriendlyname = $config_arra['web_frienly_name'];
		$facebook_link = $config_arra['facebook_link'];
		$twitter_link = $config_arra['twitter_link'];
		$google_link = $config_arra['google_link'];
		$linkedin_link = $config_arra['linkedin_link'];
		$footer_text = $config_arra['footer_text'];
		$contact_no = $config_arra['contact_no'];
		$from_email = $config_arra['from_email'];
		$android_app_link = $config_arra['android_app_link'];
		$template_image_url = $web_name.'assets/email_template';
		$login = $web_name.'login';
		$contact_us = $web_name.'contact';
		
		$email_temp_data = $this->common_front_model->getemailtemplate('Event Registration');
		
		$email_content = $email_temp_data['email_content'];
		$email_subject = $email_temp_data['email_subject'];
		
		$event_data_array = $this->session->userdata('event_data_session');
		
		$username = $event_data_array['confirm_email'];
		
		$data_array = array('username'=>$username,'webfriendlyname'=>$webfriendlyname,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"linkedin_link"=>$linkedin_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"contact_no"=>$contact_no,"from_email"=>$from_email,"contact_us"=>$contact_us,"android_app_link"=>$android_app_link,"login"=>$login);
		
		$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);
		
		$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
		
		$email = $event_data_array['confirm_email'];
		if(isset($email) && $email!= ''){
			$this->common_model->common_send_email($email,$email_subject,$email_content);
		}
		
		if(isset($event_data_array['confirm_mobile']) && $event_data_array['confirm_mobile'] != '' && isset($event_data_array['country_code']) && $event_data_array['country_code']!='')
		{
			$mobile = $event_data_array['country_code'].'-'.$event_data_array['confirm_mobile'];
			$get_sms_temp = $this->common_front_model->get_sms_template('Event Registration');
			$template_id =$get_sms_temp['template_id'];
			if(isset($get_sms_temp) && $get_sms_temp!='')
			{
				$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
				$trans = array("web_frienly_name"=>$webfriendlyname);
				
				$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
			
				
				$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
			}
		}
	}
}
?>