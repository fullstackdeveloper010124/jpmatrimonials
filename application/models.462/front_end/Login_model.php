<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
	public $table_name;
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'register';
	}
	public function check_login()
	{
		$fb_flag = false;
		$plan_id = $this->session->userdata('plan_id');
		if(isset($plan_id) && $plan_id != ''){
			$plan_id = $plan_id;
		}else{
			$plan_id = '';
		}
		$this->session->unset_userdata('plan_id');
		
		if($this->input->post('fb_id') && $this->input->post('fb_id')!=''){
			$fb_id = trim($this->input->post('fb_id'));
			$where_arra = array('fb_id'=>$fb_id);
		}else{
			$username = trim($this->input->post('username'));
			$password = trim($this->input->post('password'));
			$mobileNumber = $this->input->post('mobile_country_code').'-'.$this->input->post('mobileNumber');
			
			$password_md5 = md5($password);
			$where_arra = array(
				'password'=>$password_md5,
				'is_deleted'=>'No',
			);
			$where_arra[] = " (email = '$username' or matri_id = '$username' or mobile = '$mobileNumber') ";
		}
		## New Code For Login with otp : Date : 11-10-2021
		$mobile_verify_status = 'No';
		$is_mobile_login = 0;
		if($this->input->post('is_mobile_login') && $this->input->post('is_mobile_login') == 'Yes' && $this->input->post('country_code') && $this->input->post('mobile')){
			$mobile_verify_status = 'Yes';
			$is_mobile_login = 1;
			$mobile = $this->input->post('country_code').'-'.$this->input->post('mobile');
			$where_arra = array(
				'mobile'=>$mobile,
				'is_deleted'=>'No',
			);
		}
		$row_data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,1,'id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender,  password, mobile, mobile_verify_status, logged_in');
		
		$return_message = "";
		$status = 'error';
		if(isset($row_data) && $row_data !='' && count($row_data) > 0)
		{
			$login_succ = 1;
			if(isset($row_data['status']) && $row_data['status'] !='' && ($row_data['status'] == 'Suspended'))
			{
				$return_message = "Your account is suspended by admin, please contact to admin.";
				$login_succ = 0;
				$status = 'suspend';
			}	
			if(isset($row_data['status']) && $row_data['status'] !='' && $row_data['status'] == 'UNAPPROVED')
			{
				$return_message = "Your account is under review, please contact to admin.";
				$login_succ = 0;
				if($this->input->post('fb_id') && $this->input->post('fb_id')!='')
				{
					$status = 'unapprove';
				}
			}
			if($this->input->post('fb_id'))
			{
				$fb_flag = true;
			}
			
			if($is_mobile_login || $fb_flag || (strtolower($row_data['email']) == strtolower($username) || strtolower($row_data['matri_id']) == strtolower($username) || strtolower($row_data['mobile']) == strtolower($mobileNumber)) && $row_data['password'] == $password_md5)
			{
				if($login_succ == 1)
				{
					$login_dt = $this->common_model->getCurrentDate();
					$login_status = '1';
					$status  = 'success';
					$return_message = "Login Successfully Done";
					$this->db->set('last_login', $login_dt);
					$where_arra = array(
						'id'=>$row_data['id']
					);
					$notify_id = $row_data['matri_id'];

					$notify_array = array('matri_id'=>$notify_id);
					$data_array=array('last_login'=>$login_dt,'logged_in'=>$login_status);
					if($this->input->post('ios_device_id') && $this->input->post('ios_device_id')!='')
					{
						$ios = trim($this->input->post('ios_device_id'));
						$ios_data = $this->common_model->get_count_data_manual('register',$notify_array,1,'ios_device_id','id desc','',1);
						if(isset($ios_data) && $ios_data!='' && count($ios_data)>0)
						{
							if(isset($ios_data['ios_device_id']) && $ios_data['ios_device_id']!=$ios)
							{
								//for session expired in app
								$old_ios_device_id = $ios_data['ios_device_id'];
								$iosnotify_message = 'Your '.$notify_id.' session has been expired';
								$this->common_model->new_send_notification_android($old_ios_device_id,$iosnotify_message,'Session Expired','session_expire','session_expire');	
							}
						}
						$data_array = array('last_login'=>$login_dt,'logged_in'=>$login_status,'ios_device_id'=>$ios);
					}
					elseif($this->input->post('android_device_id') && $this->input->post('android_device_id')!='')
					{
						$android = trim($this->input->post('android_device_id'));
						$android_data = $this->common_model->get_count_data_manual('register',$notify_array,1,'android_device_id','id desc','',1);
						if(isset($android_data) && $android_data!='' && count($android_data)>0)
						{
							if(isset($android_data['android_device_id']) && $android_data['android_device_id']!=$android)
							{
								//for session expired in app
								$old_android_device_id = $android_data['android_device_id'];
								$andnotify_message = 'Your '.$notify_id.' session has been expired';
								$this->common_model->new_send_notification_android($old_android_device_id,$andnotify_message,'Session Expired','session_expire','session_expire');	
							}
						}
						$data_array = array('last_login'=>$login_dt,'logged_in'=>$login_status,'android_device_id'=>$android);
					}
					## Start For Firebase Web Notification
					elseif($this->input->post('web_device_id') && $this->input->post('web_device_id')!=''){
						$web_device_id = trim($this->input->post('web_device_id'));
						$data_array = array('last_login'=>$login_dt,'logged_in'=>$login_status,'web_device_id'=>$web_device_id);
					}
					## New Code : Date : 11-10-2021
					if($this->input->post('latitude') && $this->input->post('longitude')){
						$latitude = $this->input->post('latitude');
						$longitude = $this->input->post('longitude');
						$data_array['latitude'] = $latitude;
						$data_array['longitude'] = $longitude;
					}
					if($this->input->post('is_mobile_login') && $this->input->post('is_mobile_login') == 'Yes' && $this->input->post('country_code') && $this->input->post('mobile')){
						$data_array['mobile_verify_status'] = $mobile_verify_status;
						$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
					}else{
						$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
					}
			
					//insert member_id into member_activity table for check user last activity
					$index_id = $row_data['id'];
					$data_array2 = array('index_id'=>$index_id,'date_time'=>$login_dt);
					$where_login = "index_id = '$index_id'" ;
					$check_login = $this->common_front_model->get_count_data_manual('member_activity',$where_login,0,'*','','',1);
					if(isset($check_login) && $check_login==0)
					{
						$this->common_model->update_insert_data_common('member_activity', $data_array2,'',0);
					}

					$ip_address = $_SERVER['REMOTE_ADDR'];
					$data_array123 = array(
								'matri_id'=>$row_data['matri_id'],
								'email'=>$row_data['email'],
								'login_at'=>$login_dt,
								'ip_address'=>$ip_address);
					$response1 = $this->common_front_model->save_update_data('user_login_history',$data_array123);
					
					$where_online_users = array('index_id'=>$row_data['id']);
					$row_data_online_users = $this->common_model->get_count_data_manual('online_users',$where_online_users,0,'','','','',0);
					if($row_data_online_users == 0 && $row_data_online_users == ''){
						$ip = $_SERVER['REMOTE_ADDR'];
						$dt = $this->common_model->getCurrentDate();
						$data_array1 = array('ip'=>$ip,'username'=>$row_data['username'],'gender'=>$row_data['gender'],'index_id'=>$row_data['id'],'dt'=>$dt);
						$row_data1 = $this->common_model->update_insert_data_common('online_users', $data_array1, '',0);
					}
					
					if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1']))
					{
						$row_data['photo1'] = base_url().$this->common_model->path_photos.$row_data['photo1'];
					}
					else
					{
						if(isset($row_data['gender']) && $row_data['gender'] =='Male')
						{
							$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-male.gif';
						}
						else
						{
							$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-female.gif';
						}
					}
					// get plan detail and add chat status
					if(isset($row_data['plan_status']) && $row_data['plan_status'] =='Paid')
					{
						$row_data['plan_chat'] = $this->common_front_model->get_plan_detail($row_data['matri_id'],'chat','Yes');
					}
					$row_data['logged_in'] = 1;
					// added by mustakim for chat issue	
					setcookie("freichat_user", "", time()-3600, "/");
					setcookie("PHPSESSID", "", time()-3600, "/");
					// added by mustakim for chat issue
					$this->session->set_userdata('mega_user_data', $row_data);
				}
			}
			else{
				$return_message = "Your username and password is wrong. Please try again...";
				$login_succ = 0;
			}	
		}
		else
		{
			$return_message = "Your username and password is wrong. Please try again...";
			## Date : 13-10-2021
			if($is_mobile_login == 1){
				$return_message = "This number is not register with us, Please register first.";
			}
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash(),'user_data'=>$row_data,'plan_id'=>$plan_id);
		return $return_arr;
	}
	public function check_reset_forgot_password()
	{
		$username = trim($this->input->post('username'));
		$username_where = " ( email ='$username') and (status != 'UNAPPROVED' and status != 'Suspended' ) ";
		$this->db->select('*');
		$this->db->where($username_where);
		$this->db->where('is_deleted','No');
		$this->db->limit(1);
		$query = $this->db->get($this->table_name);
		$return_message = "";
		$status = 'error';
		if($query->num_rows() == 1)
		{
			$row_data = $query->row_array();
			if(strtolower($row_data['email']) == strtolower($username))
			{ 
				$this->load->helper('string');
				$password = random_string('alnum', 8);
				$password_md5 = md5($password);
				$this->db->set('cpassword', $password_md5);
				$this->db->where('id', $row_data['id']);
				$this->db->update($this->table_name);
				$status = 'success';
				
				$data_email = array(
					'email'=>$row_data['email'],
					'username'=>$row_data['username'],
					'c_password'=>$password_md5,
				);
				$this->forgot_email_send($data_email);
				$return_message = 'New Password link has been sent to your email id, Please check your Email and reset your password.';
			}
			else
			{
				$return_message = "Your have enter Wrong Email Address. Please enter valid email address and Try again.";
			}
		}
		else
		{
			$return_message = "Your have enter Wrong Email Address. Please enter valid email address and Try again.";
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return json_encode($return_arr);
	}
	public function forgot_email_send($data_email)
	{
		$config_arra = $this->common_model->get_site_config();
		$web_name = $config_arra['web_name'];
		$webfriendlyname = $config_arra['web_frienly_name'];
		$facebook_link = $config_arra['facebook_link'];
		$twitter_link = $config_arra['twitter_link'];
		$google_link = $config_arra['google_link'];
		$footer_text = $config_arra['footer_text'];
		$android_app_link = $config_arra['android_app_link'];
		$template_image_url = $web_name.'assets/email_template';
		$login_url = $web_name.'login';
		$from_email = $config_arra['from_email'];
		
		$username = $data_email['username'];
		$c_password = $data_email['c_password'];
		$email = $data_email['email'];
		$forgot_password_link = $web_name."login/reset-password/$c_password/".base64_encode($email);
		$forgot_password_link = '<a target="_blank" href="'.$forgot_password_link.'">'.$forgot_password_link.'</a>';
		
		$get_email_template = $this->common_front_model->getemailtemplate('Reset Password');
		
		$subject = $get_email_template['email_subject']; 
		$message= $get_email_template['email_content'];
		
		$array_repla = array('webfriendlyname'=>$webfriendlyname,'forgot_password_link'=>$forgot_password_link,"name"=>$username,"email_id"=>$email,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"login_url"=>$login_url,"android_app_link"=>$android_app_link,"from_email"=>$from_email);
		
		$message_email = $this->common_model->getstringreplaced($message,$array_repla);
		
		$to_email = $email;
		//$subject  = 'Password reset for your account on webfriendlyname';
		$subject = $this->common_model->getstringreplaced($subject,$array_repla);
		
		if($to_email !="" && $message !="")
		{
			$msg = $this->common_model->common_send_email($to_email,$subject,$message_email);
		}
	}
	public function check_reset_link($password,$email)
	{
		$password = trim($password);
		$email = trim($email);
		$username_where = " ( cpassword ='$password' and email ='$email') ";
		$this->db->select('*');
		$this->db->where($username_where);
		$this->db->where('is_deleted','No');
		$this->db->limit(1);
		$query = $this->db->get($this->table_name);
		$return_message = "";
		$status = 'error';
		if($query->num_rows() == 1)
		{
			$row_data = $query->row_array();
			$status = 'success';
			$this->session->set_userdata('email_reset', $row_data['email']);
			$status = 'success';
		}
		else
		{
			$status = 'error';
		}
		return $status;
	}
	public function reset_update_pass()
	{
		$email_reset = $this->session->userdata('email_reset');
		$return ='error';
		$return_message = "Some please try again.";
		if($email_reset !='')
		{
			$password = trim($this->input->post('password'));
			$password_md5 = md5($password);
			$where_arra = array(
				'email'=>$email_reset,
				'is_deleted'=>'No'
			);
			$data_array = array('password'=>$password_md5,'cpassword'=>'');
			$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
			if($row_data1)
			{
				$return ='success';
				$return_message = "Your password has been successfully reset, please login with new password.";
			}
			if(isset($return) && $return=='success')
			{
				$config_arra = $this->common_model->get_site_config();
				$web_name = $config_arra['web_name'];
				$webfriendlyname = $config_arra['web_frienly_name'];
				$facebook_link = $config_arra['facebook_link'];
				$twitter_link = $config_arra['twitter_link'];
				$google_link = $config_arra['google_link'];
				$footer_text = $config_arra['footer_text'];
				$android_app_link = $config_arra['android_app_link'];
				$template_image_url = $web_name.'assets/email_template';
				$login_url = $web_name.'login';
				$from_email = $config_arra['from_email'];
				
				$username = $email_reset;
				$email = $email_reset;
				
				$get_email_template = $this->common_front_model->getemailtemplate('Change Password');
				
				$subject = $get_email_template['email_subject']; 
				$message= $get_email_template['email_content'];
				
				$array_repla = array('webfriendlyname'=>$webfriendlyname,'new_password'=>$password,"name"=>$username,"email_id"=>$email,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"login_url"=>$login_url,"android_app_link"=>$android_app_link,"from_email"=>$from_email);
				
				$message_email = $this->common_model->getstringreplaced($message,$array_repla);
				
				$to_email = $email;
				//$subject  = 'Password reset for your account on webfriendlyname';
				$subject = $this->common_model->getstringreplaced($subject,$array_repla);
				
				if($to_email !="" && $message !="")
				{
					$msg = $this->common_model->common_send_email($to_email,$subject,$message_email);
				}
			}
		}
		else
		{
			$return_message = "Your have already reset your password, please login with new password.";
		}
		$return_arr = array('status'=>$return,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return $return_arr;
	}

	public function facebook_login()
	{
		if($this->input->post('username')){
			$username = trim($this->input->post('username'));
		}
		if($this->input->post('fb_id')!='')
		{
			$fb_id = $this->input->post('fb_id');
		}
		if($this->input->post('device_id')){
			$device_id = $this->input->post('device_id');
		}
		$get_fb_id = $this->common_model->get_count_data_manual($this->table_name,array('email'=>$username,'fb_id'=>$fb_id),1,'cust_id, fb_id, email');
		if(isset($get_fb_id['fb_id']) && $get_fb_id['fb_id']!='' && ($get_fb_id['fb_id']==$fb_id))
		{
			$where_arra = array('admin_view'=>'YES');
			$where_arra[] = " (email = '$username' && fb_id = '$fb_id' ) ";
			$row_data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,1,'cust_id, fb_id, status, email, full_name,  avatar, pass, mobile, is_varifired');
			$return_message = "";
			
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				if(isset($row_data['status']) && $row_data['status'] !='' && $row_data['status'] == 'UNAPPROVED')
				{
					$return_message = "Your account is under review, please contact to admin.";
				}
				else if((strtolower($row_data['email']) == strtolower($username) || strtolower($row_data['mobile']) == strtolower($username)) && $row_data['fb_id'] == $fb_id)
				{
					if((isset($row_data['country']) && ($row_data['country']!='')) && (isset($row_data['state']) && ($row_data['state']!='')) && isset($row_data['city']) && ($row_data['city']!='') && isset($row_data['street_add']) && ($row_data['street_add']!='') && isset($row_data['timezone']) && ($row_data['timezone']!='')){
						$login_dt = $this->common_model->getCurrentDate();
						$status  = 'success';
						$return_message = "Login Successfully Done";
						$where_arra = array(
							'cust_id'=>$row_data['cust_id']
						);
						$data_array = array('last_online'=>$login_dt,'device_id'=>$device_id);
						$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
						if(isset($row_data['avatar']) && $row_data['avatar'] !='' && file_exists($this->common_model->path_photos.$row_data['avatar']))
						{
							$row_data['avatar'] = base_url().$this->common_model->path_photos.$row_data['avatar'];
						}
						else
						{
							$row_data['avatar'] = base_url().'../images/avatar.png';
						}
					}else{
						$this->session->set_userdata('recent_reg_id', $row_data['cust_id']);
						$return_message = "Please add profile first before login.";
						$status = 'redirect';
					}
				}
				else
				{
					$return_message = "Your username is wrong. Please try again...";
					$status = 'error';
				}
			}
			else
			{
				$return_message = "Your username is wrong. Please try again...";
				$status = 'error';
			}
		}
		else
		{
			$return_message = "Your facebook id is not available";
			$status = 'error';
			$row_data='';
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash(),'user_data'=>$row_data);
		return $return_arr;
	}
}