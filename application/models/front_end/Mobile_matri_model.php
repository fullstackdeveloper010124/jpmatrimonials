<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mobile_matri_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'register';
	}
	public function send_sms()
	{
		$return_message = "";
		$status = 'error';
		$mobile = trim($this->input->post('mobile_number'));
		$country_code = trim($this->input->post('country_code'));
		$mobile_number = $country_code.'-'.$mobile;
		
		if(isset($mobile_number) && $mobile_number!='')
		{
			$config_data = $this->common_front_model->data['config_data'];
			$webfriendlyname = $config_data['web_frienly_name'];
			$android_app_link = $config_data['android_app_link'];
			$get_sms_temp = $this->common_front_model->get_sms_template('Send Mobile App Link');
			$template_id =$get_sms_temp['template_id'];
			if(isset($get_sms_temp) && $get_sms_temp!='')
			{
				$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
				$trans = array("android_app_link"=>$android_app_link);
				$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
				$this->common_model->common_sms_send($mobile_number,$sms_template,$template_id);
				$status  = 'success';
				$return_message = "The link to download the '".$webfriendlyname."' mobile app has been sent to '".$mobile."'.";
			}
			else
			{
				$return_message = "Some error Occured, please try again.";
			}
		}
		
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return $return_arr;
	}
}