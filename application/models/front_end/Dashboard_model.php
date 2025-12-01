<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function update_percentage_slider_field()
	{
		if(isset($_POST['field']) && $_POST['field']!='' && isset($_POST['val']) && $_POST['val']!='')
		{
			$member_id = $this->common_front_model->get_user_id();
			$field = $_POST['field'];
			$val = $_POST['val'];
			/*echo $val;
			echo $field ;
			exit();*/
			
			if(!isset($member_id) || $member_id == '' )
			{
				$data1['status'] = 'error';
				$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
				$data['data'] = json_encode($data1);
				return $data;
			}
			else
			{
				$where_arra=array('id'=>$member_id);
				$data_array = array($field =>$val);
				$return =  $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
				$success_message = "Your profile has been updated successfully.";
				$curre_id = $this->common_front_model->get_session_data('id');
				$progress = $this->common_front_model->getprofile_completeness($curre_id);
				if($return == true)
				{
					if(isset($success_message) && $success_message !='')
					{
						$this->session->set_flashdata('success_message',$success_message);
					}
				}
				$data1['progress']= "<div style='width: 105px; height: 105px; margin: 0px auto;'><div class='ab' style='position: relative; text-align: center; width: 105px; height: 105px; border-radius: 100%; background-color: rgb(241, 241, 242); background-image: linear-gradient(334deg, transparent 50%, rgb(0, 188, 213) 50%), linear-gradient(90deg, rgb(0, 188, 213) 50%, transparent 50%);'><div class='cir' style='position: relative; top: 7px; left: 7px; text-align: center; width: 91px; height: 91px; border-radius: 100%; background-color: rgb(255, 255, 255);'><span class='perc' style='display: block; width: 105px; height: 105px; line-height: 105px; vertical-align: middle; font-size: 28px; font-weight: 700; color: rgb(0, 188, 213);'>$progress%</span></div></div></div>";
				$data1['status'] = 'success';
				$data1['token'] = $this->security->get_csrf_hash();
				$this_contact['base_url'] = base_url();
				$data1['my_dashboard_data'] = $this->load->view('front_end/my_dashboard_slider',$this_contact,true); 
				$data['data'] = json_encode($data1);
				$this->load->view('common_file_echo',$data);
			}
		}
	}
	public function generate_otp()
	{
		$response = 'error';
		$otp = $this->session->userdata('otp_varify');
		if($otp =='')
		{
			$otp = rand(1000,9999);
		}
		$user_id = $this->common_front_model->get_user_id();
		if($user_id !='')
		{
			## Mobile Number Update : Date : 11-10-2021
			if($this->input->post('mobile') && $this->input->post('country_code')){
				// $mobile = '+'.$this->input->post('country_code').'-'.$this->input->post('mobile');
				$mobile = $this->input->post('country_code').'-'.$this->input->post('mobile');

				$mobile = str_replace(" ","",$mobile);				;
				$this->common_front_model->update_insert_data_common('register',array('mobile' => trim($mobile)),array('id'=>$user_id),1,1);
			}
			$user_data = $this->common_front_model->get_user_data('register',$user_id,'mobile,mobile_verify_status',$id_f ='id');
			if(isset($user_data['mobile_verify_status']) && $user_data['mobile_verify_status'] =='No' && isset($user_data['mobile']) && $user_data['mobile'] !='')
			{
				$this->session->set_userdata('otp_varify',$otp);
				// $sms = "Your OTP $otp for verify your mobile, Please verify your mobile number on ".base_url();
				// $this->common_model->common_sms_send($user_data['mobile'],$sms);
				$response = 'error';
				$get_sms_temp = $this->common_front_model->get_sms_template('Mobile Verification');
				$template_id =$get_sms_temp['template_id'];
				if(isset($get_sms_temp) && $get_sms_temp!='')
				{
					$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
					$trans = array("yoursite.com"=>base_url(),"XXXXX"=>$otp);
					$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
					$this->common_model->common_sms_send($user_data['mobile'],$sms_template,$template_id);
					$response = 'success';
				}
			}
		}
		if($response == 'success')
		{
			$returnvar['status'] = 'success';
			$returnvar['error_meessage'] = 'Your OTP sent on your mobile('.$user_data['mobile'].')';
			$returnvar['errmessage'] = 'Your OTP sent on your mobile('.$user_data['mobile'].')';
		}
		else
		{
			$returnvar['status'] = 'error';
			$returnvar['error_meessage'] = 'Some error Occured, please try again.';
			$returnvar['errmessage'] = 'Some error Occured, please try again.';
		}
		$returnvar['tocken'] = $this->security->get_csrf_hash();
		return $returnvar;
	}	
	function varify_mobile_otp()
	{
		$response = 'Please try again.';
		$otp_varify = $this->session->userdata('otp_varify');
		$otp_mobile = ($this->input->post('otp_mobile')) ? $this->input->post('otp_mobile') : "";
		if($otp_mobile =='')
		{
			$response = 'Please enter OTP sent on your mobile number';
		}
		else if($otp_mobile !='' && $otp_mobile != $otp_varify)
		{
			$response = 'Please enter Valid OTP sent on your mobile number';
		}
		else
		{
			$data_array_custom = array('mobile_verify_status'=>'Yes');
			$user_id = $this->common_front_model->get_user_id();
			if($user_id !='')
			{
				$this->common_front_model->update_insert_data_common('register',$data_array_custom,array('id'=>$user_id));
				$response = 'success';
				$current_data = $this->common_front_model->get_session_data();
				$current_data['mobile_verify_status'] ='Yes';
				$this->session->set_userdata('mega_user_data', $current_data);
				$this->session->unset_userdata('otp_varify');
			}
		}
		return $response;
	}
	
	public function generate_email_otp()
	{
		$response = 'error';
		$otp = $this->session->userdata('otp_varify');
		if($otp =='')
		{
			$otp = rand(1000,9999);
		}
		$user_id = $this->common_front_model->get_user_id();
		if($user_id !='')
		{
			$user_data = $this->common_front_model->get_user_data('register',$user_id,'email,cpass_status',$id_f ='id');
			if(isset($user_data['cpass_status']) && $user_data['cpass_status'] =='Not-Verify' && isset($user_data['email']) && $user_data['email'] !='')
			{
				$this->session->set_userdata('otp_varify',$otp);
				$subject = "Your OTP for verify your email";
				$message = "Your OTP $otp for verify your email, Please verify your email address on ".base_url();
				$this->common_model->common_send_email($user_data['email'],$subject,$message);
				$response = 'success';
			}
		}
		if($response == 'success')
		{
			$returnvar['status'] = 'success';
			$returnvar['error_meessage'] = 'Your OTP sent on your email('.$user_data['email'].')';
			$returnvar['errmessage'] = 'Your OTP sent on your email('.$user_data['email'].')';
		}
		else
		{
			$returnvar['status'] = 'error';
			$returnvar['error_meessage'] = 'Some error Occured, please try again.';
			$returnvar['errmessage'] = 'Some error Occured, please try again.';
		}
		$returnvar['tocken'] = $this->security->get_csrf_hash();
		return $returnvar;
	}	
	
	function varify_email_otp()
	{
		$response = 'Please try again.';
		$otp_varify = $this->session->userdata('otp_varify');
		$otp_email = ($this->input->post('otp_email')) ? $this->input->post('otp_email') : "";
		if($otp_email =='')
		{
			$response = 'Please enter OTP sent on your email';
		}
		else if($otp_email !='' && $otp_email != $otp_varify)
		{
			$response = 'Please enter Valid OTP sent on your email';
		}
		else
		{
			$data_array_custom = array('cpass_status'=>'Verify');
			$user_id = $this->common_front_model->get_user_id();
			if($user_id !='')
			{
				$this->common_front_model->update_insert_data_common('register',$data_array_custom,array('id'=>$user_id));
				$response = 'success';
				$current_data = $this->common_front_model->get_session_data();
				$current_data['cpass_status'] ='Verify';
				$this->session->set_userdata('mega_user_data', $current_data);
				$this->session->unset_userdata('otp_varify');
			}
		}
		return $response;
	}
	
	function sent_confirm_mail_user()
	{	
		$insert_id = $this->input->post('user_id');
		
		if($insert_id != '')
		{
			$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id),1,'id, matri_id, status, email, username, firstname, lastname, mobile');
		
			$cpassword = md5($row_data['email']);
			$email = $row_data['email'];
			$encypted_email = base64_encode($row_data['email']);
			
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
			$confirm_link = $config_arra['web_name'].'register/confirm-mail/'.$cpassword.'/'.$encypted_email;
			$webfriendlyname = $config_arra['web_frienly_name'];
			$facebook_link = $config_arra['facebook_link'];
			$twitter_link = $config_arra['twitter_link'];
			$google_link = $config_arra['google_link'];
			$footer_text = $config_arra['footer_text'];
			$from_email = $config_arra['from_email'];
			
			$base_url = base_url();
			$template_image_url = $web_name.'assets/email_template';
			$contact_us = $web_name.'contact';
			$premium_member = $web_name.'premium-member';
			
			$get_email_template = $this->common_front_model->getemailtemplate('Confirmation');
			$subject = $get_email_template['email_subject']; 
			$email_content= $get_email_template['email_content'];
			
			$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES); 
			$trans = array("webfriendlyname" =>$webfriendlyname,"name"=>$row_data['username'],"matriid"=>$row_data['matri_id'],"email_id"=>$row_data['email'],"site_domain_name"=>$web_name,"confirm_link"=>$confirm_link,"contact_us"=>$contact_us,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"premium_member"=>$premium_member,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"from_email"=>$from_email);
			
			$email_template = $this->common_front_model->getstringreplaced($email_template, $trans);	
			
			$this->common_model->common_send_email($email,$subject,$email_template);
			
			$cpassword_expire = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). " + 1 days"));
			$where_arra = array('id'=>$insert_id);
			$data_array = array('cpassword'=>$cpassword,'cpassword_expire'=>$cpassword_expire,'cpass_status'=>'Not-Verify');
			$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);
			
			$data['status'] = 'success';
			$data['success_message'] = 'Confirmation email link send.';
		}else{
			$data['status'] = 'error';
			$data['error_message'] = 'Confirmation email link not send.';
		}
		$data['tocken'] =  $this->security->get_csrf_hash();
		$data1['data'] =  json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
}