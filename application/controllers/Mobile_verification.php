<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mobile_verification extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/register_model');
		$this->common_model->is_demo_mode = 0;
		
	}
	public function index()
	{
		$this->generate_otp_home();
	}

	// For Generate Otp Start 05/10/2021
	public function generate_otp_home()
	{

		$response = $this->generate_otp_home_1();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
		//$this->load->view('common_file_echo',$response);
	}
	public function generate_otp_home_1()
	{
		if($this->input->post('user_agent')){
			$user_agent = $this->input->post('user_agent');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
		if ($this->form_validation->run() == FALSE)
        {		
			$returnvar['error_meessage'] = strip_tags(validation_errors());
			// $returnvar['mob_errmessage'] =  strip_tags(validation_errors());
		}
		else
		{
			$response = 'error';
			$otp_seession = $this->session->userdata('otp_varify');
			if(isset($otp_seession) && $otp_seession !='')
			{
				$this->session->unset_userdata('otp_varify');
			}
			
			
			if( $this->session->userdata('mobile_exp') !='')
			{
				$mobile_number = $this->session->userdata('mobile_exp');
			}else{
				$mobile_number = $this->session->userdata('mobile_number');
			}
		
				$otp = rand(1000,9999);
		
			$mobile = $this->input->post('mobile_number');
			$country_code = $this->input->post('country_code');
			$mobile_number = $country_code.'-'.$mobile;
		
			if($mobile_number !='')
			{
				$row_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$mobile_number),0,'*');
				if($row_data >0)
				{
					$this->session->set_userdata('otp_varify',$otp);
					$this->session->set_userdata('mobile_number',$mobile_number);
					$response = 'error';
					$get_sms_temp = $this->common_front_model->get_sms_template('Mobile Verification');
					$template_id =$get_sms_temp['template_id'];
					if(isset($get_sms_temp) && $get_sms_temp!='')
					{
						$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
						$trans = array("yoursite.com"=>base_url(),"XXXXX"=>$otp);
						$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
						$this->common_model->common_sms_send($mobile_number,$sms_template,$template_id);
						$response = 'success';
					}
					if($response == 'success')
					{
						if($user_agent == 'NI-AAPP'){
							$returnvar['otp_varify'] = $otp;
						}
						$returnvar['status'] = 'success';
						$returnvar['error_meessage'] = 'OTP Sent to ('.$mobile_number.')';
						$returnvar['errmessage'] = 'OTP Sent to ('.$mobile_number.')';
					}
					else
					{
						$returnvar['status'] = 'error';
						$returnvar['error_meessage'] = 'Some error Occured, please try again.';
						$returnvar['errmessage'] = 'Some error Occured, please try again.';
					}
		
		   		}	
				else
				{
					$returnvar['status'] = 'error';
					$response = 'error';
					$returnvar['error_meessage'] = 'Mobile number does not exists';
				}   
		
			}
		}	
		
		$returnvar['tocken'] = $this->security->get_csrf_hash();
		return $returnvar;
	}

	## Check Number Exist or Not : Date : 26-11-2021
	public function check_number_exist()
	{
		if($this->input->post('user_agent')){
			$user_agent = $this->input->post('user_agent');
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|regex_match[/^[0-9]{10}$/]');
		if ($this->form_validation->run() == FALSE)
        {		
			$returnvar['error_meessage'] = strip_tags(validation_errors());
			// $returnvar['mob_errmessage'] =  strip_tags(validation_errors());
		}
		else
		{
			$response = 'error';
			$mobile = $this->input->post('mobile_number');
			$country_code = $this->input->post('country_code');
			$mobile_number = $country_code.'-'.$mobile;
		
			if($mobile_number !='')
			{
				$row_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$mobile_number),0,'*');
				if($row_data >0)
				{
					$returnvar['status'] = 'success';
					$returnvar['error_meessage'] = 'OTP Sent to ('.$mobile_number.')';
					$returnvar['errmessage'] = 'OTP Sent to ('.$mobile_number.')';
		   		}
				else
				{
					$returnvar['status'] = 'error';
					$response = 'error';
					$returnvar['error_meessage'] = 'Mobile number does not exists';
				}   
			}
		}	
		
		$returnvar['tocken'] = $this->security->get_csrf_hash();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($returnvar));
	}

	## Login With OTP : Date : 26-11-2021
	function login_with_mobile_otp()
	{
		$user_agent ='NI-WEB';
		if($this->input->post('user_agent')){
			$user_agent = $this->input->post('user_agent');
		}
		if($user_agent !='NI-WEB')
		{
			$otp_varify = $this->input->post('otp_varify');
		}else{
			$otp_varify = $this->session->userdata('otp_varify');
		}
		
		if($otp_varify==''){
			$otp_varify = $this->input->post('otp_varify');
		}
		$mobile_number = $this->session->userdata('mobile_number');
		if($mobile_number==''){
			$mobile_number = "+".$this->input->post('mobile_number');
			$mobile_number = str_replace(" ","",$mobile_number);
		}
		if($user_agent !='NI-WEB')
		{
			$mobile_number = $this->input->post('mobile_number');
			// // $country_code = $this->input->post('country_code');
			// $mobile_number = $country_code.'-'.$mobile;
		}
		
			
		if($mobile_number !='' ){
			$row_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$mobile_number),1,'mobile');
			if (isset($row_data) && !empty($row_data)) 
			{
				$mobile_num = $row_data['mobile'];
			}
			if (isset($mobile_num) && $mobile_num == $mobile_number) {
				$update = array('mobile_verify_status' => 'Yes','latitude' => $this->input->post('latitude'),'longitude' => $this->input->post('longitude'));
				$where_a = array("mobile"=>$mobile_num,'is_deleted'=>'No');
				$this->common_model->update_insert_data_common("register",$update,$where_a,1,1);
				$this->check_login($mobile_num);
				// $this->db->last_query();die;
				$this->session->unset_userdata('otp_varify');
				$this->session->unset_userdata('mobile_exp');
				$this->session->unset_userdata('mobile_number');
				$response['status'] = 'success';
				$response['error_meessage'] = 'Verify mobile successfully';
				$response['errmessage'] = 'Verify mobile successfully';

				$android_data = $this->common_model->get_count_data_manual('register_view',$where_a,1,'*','id desc','',1);
				$response['user_data'] = $android_data;
			}
			else
			{
				$this->session->unset_userdata('otp_varify');
				$this->session->unset_userdata('mobile_exp');
				$this->session->unset_userdata('mobile_number');
				$returnvar['status'] = 'error';
				$response['error_meessage'] = 'Something went wrong';
				$response['errmessage'] = 'Something went wrong';
				
			}	
		}
		$response['tocken'] = $this->security->get_csrf_hash();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	 function varify_mobile_check_otp_home()
	{
		$response = $this->varify_mobile_otp_home_1();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
	}

	function varify_mobile_otp_home_1()
	{
		$user_agent ='NI-WEB';
		if($this->input->post('user_agent')){
			$user_agent = $this->input->post('user_agent');
		}
		if($user_agent !='NI-WEB')
		{
			$otp_varify = $this->input->post('otp_varify');
		}else{
			$otp_varify = $this->session->userdata('otp_varify');
		}
		
		if($otp_varify==''){
			$otp_varify = $this->input->post('otp_varify');
		}
		$mobile_number = $this->session->userdata('mobile_number');
		if($mobile_number==''){
			$mobile_number = $this->input->post('mobile_number');
		}
		if($user_agent !='NI-WEB')
		{
			$mobile_number = $this->input->post('mobile_number');
			// // $country_code = $this->input->post('country_code');
			// $mobile_number = $country_code.'-'.$mobile;
		}
		
		$otp_mobile = ($this->input->post('otp_mobile')) ? $this->input->post('otp_mobile') : "";
		// echo $otp_mobile.' '.$otp_varify;
		if($otp_mobile ==''){
			// $response = 'Please enter OTP sent on your mobile number';
			$response['errmessage'] = 'Please enter OTP sent on your mobile number';
			$response['error_meessage'] = 'Please enter OTP sent on your mobile number';
			$response['status'] = 'error';
		}
		else if($otp_mobile !='' && $otp_mobile != $otp_varify){
			$response['errmessage'] = 'Please enter Valid OTP';
			$response['error_meessage'] = 'Please enter Valid OTP';
			$response['status'] = 'error';
		}
		else{
			
				if(isset($otp_mobile) && $otp_mobile !='' && $mobile_number !='' ){
				$row_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$mobile_number),1,'mobile');
				
				if (isset($row_data) && !empty($row_data)) 
				{
					$mobile_num = $row_data['mobile'];
				}
				if (isset($mobile_num) && $mobile_num == $mobile_number) {
					$update = array('mobile_verify_status' => 'Yes','latitude' => $this->input->post('latitude'),'longitude' => $this->input->post('longitude'));
					$where_a = array("mobile"=>$mobile_num,'is_deleted'=>'No');
					$this->common_model->update_insert_data_common("register",$update,$where_a,1,1);
					$this->check_login($mobile_num);
					// $this->db->last_query();die;
					$this->session->unset_userdata('otp_varify');
					$this->session->unset_userdata('mobile_exp');
					$this->session->unset_userdata('mobile_number');
					$response['status'] = 'success';
					$response['error_meessage'] = 'Verify mobile successfully';
					$response['errmessage'] = 'Verify mobile successfully';

					$android_data = $this->common_model->get_count_data_manual('register_view',$where_a,1,'*','id desc','',1);
					$response['user_data'] = $android_data;
				}
				else
				{
					$this->session->unset_userdata('otp_varify');
					$this->session->unset_userdata('mobile_exp');
					$this->session->unset_userdata('mobile_number');
					$returnvar['status'] = 'error';
					$response['error_meessage'] = 'Something went wrong';
					$response['errmessage'] = 'Something went wrong';
					
				}	
			}
		}
		$response['tocken'] = $this->security->get_csrf_hash();
		return $response;
	}
	
	// For Generate Otp Start 05/10/2021

	public function check_login($mobile_num="")
	{
		if($mobile_num !='')
		{
			$plan_id = $this->session->userdata('plan_id');
			if(isset($plan_id) && $plan_id != ''){
				$plan_id = $plan_id;
			}else{
				$plan_id = '';
			}	
			$where_arra[] = " (mobile = '$mobile_num') ";
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender,  password, mobile, mobile_verify_status, logged_in');
			// echo $this->db->last_query();die;
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
					if($row_data['mobile'] == $mobile_num)
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
							## End For Firebase Web Notification
							else
							{
								$data_array = array('last_login'=>$login_dt,'logged_in'=>$login_status);
							}

							if($this->table_name == '' )
                            {
                              $this->table_name = "register";
                            }	

							$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
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
				else
				{
					$return_message = "Your username and password is wrong. Please try again...";
					$login_succ = 0;
				}	
			}
			else
			{
				$return_message = "Your username and password is wrong. Please try again...";
			}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash(),'user_data'=>$row_data,'plan_id'=>$plan_id);
		
	 }
	 else
	 {	
		$return_arr = array('status'=>'error','errmessage'=>'Something went wrong','token'=>$this->security->get_csrf_hash());
		$return_message = "Something went wrong";
	 }
	 return $return_arr;
	}	
	
}