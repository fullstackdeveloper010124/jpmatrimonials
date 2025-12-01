<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Email_sms extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		$access_perm = $this->common_model->check_permission('send_mail','redirect');
	}
	public function index()
	{
		$this->send_email('add-data');
	}
	public function send_email($status ='ALL', $page =1)
	{
		$status = 'add-data';
		$ele_array = array(
			'member_list_email'=>array('is_required'=>'required','label'=>'Select Member','placeholder'=>'Search Member by Matri Id, Name, Email, Mobile Number','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'no'),
			'email_subject'=>array('is_required'=>'required'),
			'email_content'=>array('type'=>'textarea'),
		);
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->js_extra_code.= "
			if($('#email_content').length > 0) {  $('.email_content_edit').removeClass(' col-lg-7 ');
			$('.email_content_edit').addClass(' col-lg-10 ');
			CKEDITOR.replace( 'email_content' ); }
			$(document).ready(function(){

			get_suggestion_list('member_list_email','Select Member') });

			";
		$other_conf = array('action'=>'email-sms/send-email-save');
		$this->common_model->common_rander('sms_templates', $status, $page , 'Send Email To Member',$ele_array,'template_name',0,$other_conf);
	}
	public function send_email_save()
	{
		$_REQUEST['is_ajax'] = 1;
		//$this->common_model->set_table_name('sms_history');
		if(isset($_REQUEST['member_list_email']) && $_REQUEST['member_list_email'] !='')
		{
			$email_list = $_REQUEST['member_list_email'];
			$email_subject = $_REQUEST['email_subject'];
			$email_content = $_REQUEST['email_content'];
			$config_arra = $this->common_model->get_site_config();
			$to_email = $config_arra['contact_email'];
			if(isset($email_list) && $email_list !='' && count($email_list) > 0)
			{
				$this->common_model->common_send_email($to_email,$email_subject,$email_content,'',$email_list);
				/*foreach($email_list as $email_list_val)
				{
					if($email_list_val !='')
					{
						//$_REQUEST['mobile'] = $mobile_list_val;
						//$data = $this->common_model->save_update_data(0,1);
						//$this->common_model->common_send_email($to_array,$subject,$message,$cc_array= '');
					}
				}*/
				$this->session->set_userdata('success_message','Email Sent Successfully.');
			}
		}
		redirect($this->common_model->base_url_admin.'email-sms/send-email/add-data');
	}

	public function send_sms($status ='ALL', $page =1)
	{
		$ele_array = array(
			'member_list_sms'=>array('is_required'=>'required','label'=>'Select Member','placeholder'=>'Search Member by Matri Id, Name, Mobile Number','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'no'),
			'sms_content'=>array('type'=>'textarea','is_required'=>'required','label'=>'Message','placeholder'=>'Type your message here'),
		);
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';

		$this->common_model->js_extra_code.= "
			$(document).ready(function(){ get_suggestion_list('member_list_sms','Select Member') });

			";
		$other_conf = array('action'=>'email-sms/send-sms-save');
		$this->common_model->common_rander('sms_templates', $status, $page , 'Send SMS To Member',$ele_array,'template_name',0,$other_conf);
	}
	public function send_sms_save()
	{
		$_REQUEST['is_ajax'] = 1;
		$this->common_model->set_table_name('sms_history');
		if(isset($_REQUEST['member_list_sms']) && $_REQUEST['member_list_sms'] !='')
		{
			$mobile_list = $_REQUEST['member_list_sms'];
			if(isset($mobile_list) && $mobile_list !='' && count($mobile_list) > 0)
			{
				foreach($mobile_list as $mobile_list_val)
				{
					if($mobile_list_val !='')
					{
						$_REQUEST['mobile'] = $mobile_list_val;
						$data = $this->common_model->save_update_data(0,1);
						$this->common_model->common_sms_send($_REQUEST['mobile'],$_REQUEST['sms_content']);
					}
				}
				$this->session->set_userdata('success_message','SMS Sent Successfully.');
			}
		}
		redirect($this->common_model->base_url_admin.'email-sms/send-sms/add-data');
	}
}