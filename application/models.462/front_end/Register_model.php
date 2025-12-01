<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}

	public function check_duplicate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$data1['status'] = 'error';
		$data1['tocken'] = $this->security->get_csrf_hash();
		if ($this->form_validation->run() == FALSE)
        {
			$data1['errmessage'] =  strip_tags(validation_errors());
		}
		else
		{
			if($this->input->post('email')!='')
			{
				$email = trim($this->input->post('email'));
				$_REQUEST['mobile'] = $this->input->post('country_code').'-'.$this->input->post('mobile_number');
				$count_email = $this->common_model->get_count_data_manual('register',array('email'=>$email,'is_deleted'=>'No'),0,'id');
				$count_mobile = $this->common_model->get_count_data_manual('register',array('mobile'=>$_REQUEST['mobile'],'is_deleted'=>'No'),0,'id');
				$data1['mobile'] = $count_mobile;
				if($count_email == 0 && $count_mobile == 0)
				{
					$data1['status'] = 'success';
				}
				else
				{
					if($count_email > 0 && $count_mobile > 0)
					{
						$data1['errmessage'] =  "Duplicate Email address and mobile number found, please enter another one";
					}
					else if($count_email > 0)
					{
						$data1['errmessage'] =  "Duplicate Email address found, please enter another one";
					}
					else
					{
						$data1['errmessage'] =  "Duplicate Mobile Number found, please enter another one";
					}
				}
			}
		}
		$data['data'] = json_encode($data1);
		return $data;
	}

	public function save_register($is_post=0)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric|min_length[8]|max_length[20]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha|max_length[30]');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha|max_length[30]');

		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';

		if($this->input->post('user_agent')!='NI-AAPP'){
			$this->form_validation->set_rules('religion', 'Religion', 'required');
			$this->form_validation->set_rules('caste', 'Caste', 'required');
			$this->form_validation->set_rules('terms', 'Terms & Condition', 'required');
		}elseif($user_agent =='NI-WEB'){
			$this->form_validation->set_rules('captcha_code', 'Captcha Code', 'required|callback_validate_captcha');
		}else{
			$this->form_validation->set_rules('app_security_key', 'Security Key','required');
		}


		## Capcha Validation :
		$captchaCode = trim($this->input->post('captcha_code'));
		$validCaptcha = $this->session->userdata('captcha_code_session');
		$captchaVerify = 1;
		if($user_agent =='NI-WEB'){
			if($captchaCode == $validCaptcha){
                $captchaVerify = 0;
            }
		}
		## Check Spamming :
		$isSpamming = 0;
        if ($user_agent=='NI-AAPP' || $user_agent=='NI-IOS') { // Check Spamming :
	        $isSpamming = 1;
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false) {
	            $isSpamming = 0;
	        }
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'iOS') !== false) {
	            $isSpamming = 0;
	        }
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'okhttp') !== false) {
	            $isSpamming = 0;
	        }
	        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Dart') !== false) {
	            $isSpamming = 0;
	        }
	    }

		if ($this->form_validation->run() == FALSE){
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  strip_tags(validation_errors());
			$data1['status'] = 'error';
		}
		else if($user_agent=='NI-WEB' && $captchaVerify == 1) {
		    $data1['tocken'] = $this->security->get_csrf_hash();
            $data1['errmessage'] = 'Invalid capcha code found';
            $data1['status'] = 'error';
		} else if ($isSpamming == 1) { // Check Spamming :
	        $data1['tocken'] = $this->security->get_csrf_hash();
            $data1['errmessage'] = 'Google reCAPTACHA is not verified';
            $data1['status'] = 'error';
		}elseif($this->input->post('middle_name') != ''){
			## Form Spamming Registration:
			$data1['tocken'] = $this->security->get_csrf_hash();
            $data1['errmessage'] = 'Google reCAPTACHA is not verified';
            $data1['status'] = 'error';
		}
		else
		{
			if($this->input->post('email')!='')
			{
				$app_security_key = '';
				if($this->input->post('user_agent')=='NI-AAPP'){
					$app_security_key = trim($this->input->post('app_security_key'));
					if ($app_security_key != APP_SECURITY_KEY)
					{
						$data1['errmessage'] =  "Unauthorize request!";
						$data1['status'] = 'error';
						$data1['tocken'] = $this->security->get_csrf_hash();
						$data['data'] = json_encode($data1);
						return $data;
					}
				}
				$email = trim($this->input->post('email'));
				$_REQUEST['mobile'] = $this->input->post('country_code').'-'.$this->input->post('mobile_number');

				$count_mobile=$count_email= 0;
				if(trim($this->input->post('id'))!='')
				{
					$member_id = trim($this->input->post('id'));
					$email_data = $this->common_model->get_count_data_manual('register',array('email'=>$email,'is_deleted'=>'No'),2,'id');
					$mobile_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$_REQUEST['mobile'],'is_deleted'=>'No'),2,'id');
					if(isset($mobile_data) && $mobile_data!='' && is_array($mobile_data) && count($mobile_data)>0)
					{
						$count_mobile = 1;
						foreach($mobile_data as $m_row){
							if($m_row["id"]==$member_id){
								$count_mobile = 0;
							}
						}
					}
					if(isset($email_data) && $email_data!='' && is_array($email_data) && count($email_data)>0)
					{
						$count_email = 1;
						foreach($email_data as $m_row){
							if($m_row["id"]==$member_id){
								$count_email = 0;
							}
						}
					}
				}
				else
				{
					$count_email = $this->common_model->get_count_data_manual('register',array('email'=>$email,'is_deleted'=>'No'),0,'id');
					$count_mobile = $this->common_model->get_count_data_manual('register',array('mobile'=>$_REQUEST['mobile'],'is_deleted'=>'No'),0,'id');
				}
				$data1['mobile'] = $count_mobile;
				if($count_email == 0 && $count_mobile == 0)
				{
					## Unset Captcha When Success : Date : 29-11-2024
					if($this->session->userdata('captcha_code_session')){
						$this->session->unset_userdata('captcha_code_session');
					}

					$_REQUEST['terms'] = (isset($_REQUEST['terms']) && $_REQUEST['terms']!='')?$_REQUEST['terms']:'';
					if(isset($_REQUEST['birth_year']) && $_REQUEST['birth_month'] && $_REQUEST['birth_date'])
					{
						$_REQUEST['birthdate'] = $_REQUEST['birth_year'].'-'.$_REQUEST['birth_month'].'-'.$_REQUEST['birth_date'];
					}
					$_REQUEST['username'] = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
					$_REQUEST['password'] = md5($_REQUEST['password']);
					$this->common_model->created_on_fild = 'registered_on';
					$this->common_model->set_table_name('register');
					if(trim($this->input->post('id'))!='')
					{
						$_REQUEST['mode'] ='edit';
						$_REQUEST['id'] = trim($this->input->post('id'));
					}
					$response = $this->common_model->save_update_data(1,1);
					if(trim($this->input->post('id'))!='')
					{
						$insert_id =trim($this->input->post('id'));
					}
					else
					{
						$insert_id = $this->common_model->last_insert_id;
					}
					$this->session->set_userdata('recent_reg_id',$insert_id);
					$data1['id'] = $insert_id;
					$data1['tocken'] = $this->security->get_csrf_hash();
					$data = json_decode($response, true);
					if(isset($data['status']) && $data['status'] =='success')
					{
						$config_data = $this->common_model->data['config_data'];
						$matri_prefix = $config_data['matri_prefix'];
						$matri_id = $matri_prefix.$insert_id;
						$data_update_arr['matri_id'] = $matri_id;
						$this->common_model->update_insert_data_common('register',$data_update_arr,array('id'=>$insert_id));

						$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id),1,'id, matri_id, status, email, username, firstname, lastname, mobile');

						$email = $row_data['email'];

						$config_arra = $this->common_model->get_site_config();
						$web_name = $config_arra['web_name'];
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

						$get_email_template = $this->common_front_model->getemailtemplate('Registration');
						$subject = $get_email_template['email_subject'];
						$email_content= $get_email_template['email_content'];

						$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES);
						$trans = array("webfriendlyname" =>$webfriendlyname,"name"=>$row_data['username'],"matriid"=>$row_data['matri_id'],"email_id"=>$row_data['email'],"site_domain_name"=>$web_name,"contact_us"=>$contact_us,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"premium_member"=>$premium_member,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"from_email"=>$from_email);

						$email_template = $this->common_front_model->getstringreplaced($email_template, $trans);

						$subject = $this->common_front_model->getstringreplaced($subject, $trans);

						$this->common_model->common_send_email($email,$subject,$email_template);

						if(isset($row_data['mobile']) && $row_data['mobile'] != '')
						{
							$mobile = $row_data['mobile'];
							$get_sms_temp = $this->common_front_model->get_sms_template('Registration');
							$template_id =$get_sms_temp['template_id'];
							if(isset($get_sms_temp) && $get_sms_temp!='')
							{
								$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
								$trans = array("web_frienly_name"=>$webfriendlyname);

								$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
								$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
							}
						}

						$this->sent_confirm_mail_message_user();
						if(trim($this->input->post('id'))!='')
						{
							$data1['errmessage'] =  "Your profile has been updated, please go through next step to complete your profile, please wait while we are redirecting to next step";
							$data1['status'] = 'success';
						}
						else
						{
							$data1['errmessage'] =  "Your profile has been created, please go through next step to complete your profile, please wait while we are redirecting to next step";
							$data1['status'] = 'success';
						}
					}
					else
					{
						$data1['errmessage'] =  $data['response'];
						$data1['status'] = 'error';
					}
				}
				else
				{
					if($count_email > 0 && $count_mobile > 0)
					{
						$data1['errmessage'] =  "Duplicate Email address and mobile number found, please enter another one";
					}
					else if($count_email > 0)
					{
						$data1['errmessage'] =  "Duplicate Email address found, please enter another one";
					}
					else
					{
						$data1['errmessage'] =  "Duplicate Mobile Number found, please enter another one";
					}
					$data1['tocken'] = $this->security->get_csrf_hash();
					$data1['status'] = 'error';
				}
			}
		}
		if($is_post == 0)
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			if(isset($data1['status']) && $data1['status'] == 'success')
			{
				$this->session->set_flashdata('success_message', "<div class='alert alert-success'>Your profile has been created, please complete next step to complete your profile, please wait while we are redirecting to next step</div>");
				return 'success';
			}
			else
			{
				if(isset($data1['errmessage']) && $data1['errmessage'] !='')
				{
					$this->session->set_flashdata('error_message', "<div class='alert alert-danger'>".$data1['errmessage']."</div>");
				}
				return 'error';
			}
		}
	}
	public function save_register_step($is_post = 0,$step='step1')
	{
		$insert_id = '';
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='NI-WEB' && isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$insert_id = $_REQUEST['id'];
		}
		else
		{
			$insert_id = $this->session->userdata('recent_reg_id');
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';
		$temp_file_name = '';
		$path_photos_big = $this->common_model->path_photos_big;
		if(isset($_FILES['profil_photo_org']['name']) && $_FILES['profil_photo_org']['name'] !='')
		{
			$temp_data_array = array('file_name'=>'profil_photo_org','upload_path'=>$path_photos_big);
			$upload_data = $this->common_model->upload_file($temp_data_array);
			if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['status']) && $upload_data['status'] =='success')
			{
				if(isset($upload_data['file_data']))
				{
					$file_data = $upload_data['file_data'];
					if(isset($file_data['file_name']))
					{
						$temp_file_name = $file_data['file_name'];
					}
				}
			}
		}
		if(isset($_FILES['profil_photo']) && $_FILES['profil_photo'] !='')
		{
			$_FILES['photo1'] = $_FILES['profil_photo'];
			$_REQUEST['photo1_path'] = $this->common_model->path_photos;
			if(isset($_FILES['photo1']['name']) && $_FILES['photo1']['name'] !='')
			{
				$data_mem_array = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id,'is_deleted'=>'No'),1,'photo1');
				if(isset($data_mem_array['photo1']) && $data_mem_array['photo1'] !='')
				{
					$_REQUEST['photo1_val'] = $data_mem_array['photo1'];
				}
			}
			unset($_FILES['profil_photo']);
		}
		if(isset($_REQUEST['profile_photo_crop']) && $_REQUEST['profile_photo_crop'] !='')
		{
		    $upload_photo_name = time().'-'.$insert_id.'.jpg';
		    $this->common_model->base_64_photo('profile_photo_crop','path_photos',$upload_photo_name);
		    if(isset($_REQUEST['profile_photo_org']) && $_REQUEST['profile_photo_org'] !='') {
                $this->common_model->base_64_photo('profile_photo_org', 'path_photos_big', $upload_photo_name);
		    }
		    $_REQUEST['photo1'] = $upload_photo_name;
		    $_REQUEST['photo1_approve'] = 'UNAPPROVED';
		    $_REQUEST['photo1_uploaded_on'] = $this->common_model->getCurrentDate();
		}

		if(!isset($insert_id) || $insert_id == '' )
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			$this->common_model->set_table_name('register');
			$_REQUEST['mode'] ='edit';
			$_REQUEST['id'] =$insert_id;
			if(isset($_REQUEST['total_children']) && ($_REQUEST['total_children']=='0' || $_REQUEST['total_children']=='')){
				$_REQUEST['status_children'] = '';
			}
			$response = $this->common_model->save_update_data(1,1);
			$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='NI-WEB')
				{
					if(isset($temp_file_name) && $temp_file_name !='')
					{
						$data_mem_array = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id,'is_deleted'=>'No'),1,'photo1');
						if(isset($data_mem_array['photo1']) && $data_mem_array['photo1'] !='')
						{
							$_REQUEST['photo1_val'] = $data_mem_array['photo1'];
							if($data_mem_array['photo1'] !='' && file_exists($path_photos_big.$data_mem_array['photo1']))
							{
								unlink($path_photos_big.$data_mem_array['photo1']);
							}
							rename($path_photos_big.$temp_file_name,$path_photos_big.$data_mem_array['photo1']);
							$temp_file_name = '';
						}
					}
					$data1['errmessage'] =  "Your profile has been added successfully."; // for app return message
				}
				else
				{
					$data1['errmessage'] =  "<i class='fa fa-check text-success'></i> Your profile has been added successfully.";	 // for website return message
				}
				$data1['status'] = 'success';
			}
			else
			{
				//$data1['old_photo_url'] = base_url().$this->common_model->path_photos.$_REQUEST['photo1_val'];
				if(isset($data1['response']) && $data1['response']!='')
				{
					$data1['errmessage'] = strip_tags($data1['response']);
				}
			}
			if($temp_file_name !='' && $path_photos_big.$temp_file_name !='' && file_exists($path_photos_big.$temp_file_name))
			{
				unlink($path_photos_big.$temp_file_name);
			}

			unset($data1['response']);
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
				return $data;
			}
			else
			{
				if(isset($data1['status']) && $data1['status'] == 'success')
				{
					$this->session->set_flashdata('success_message', "<div class='alert alert-success'><i class='fa fa-check text-success'></i> Your profile has been updated successfully.</div>");
					return 'success';
				}
				else
				{
					if(isset($data1['errmessage']) && $data1['errmessage'] !='')
					{
						$this->session->set_flashdata('error_message', "<div class='alert alert-danger'>".$data1['errmessage']."</div>");
					}
					return 'error';
				}
			}
		}
	}
	public function set_login_register_user()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		if(isset($insert_id) && $insert_id !='')
		{
			$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id),1,'id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender ');
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				$login_dt = $this->common_model->getCurrentDate();
				$status  = 'success';
				$this->db->set('last_login', $login_dt);
				$where_arra = array(
					'id'=>$row_data['id']
				);
				$data_array = array('last_login'=>$login_dt);
				$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);
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
				$this->session->set_userdata('mega_user_data', $row_data);
			}
			$this->session->unset_userdata('recent_reg_id');
		}
	}

	public function sent_confirm_mail_message_user()
	{
		$insert_id = $this->session->userdata('recent_reg_id');

		$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id),1,'id, matri_id, status, email, username, firstname, lastname, mobile');

		$cpassword = md5($row_data['email']);
		$encypted_email = base64_encode($row_data['email']);
		$email = $row_data['email'];

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
		if(isset($get_email_template) && $get_email_template!=''){
			$subject = $get_email_template['email_subject'];
			$email_content= $get_email_template['email_content'];

			$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES);
			$trans = array("webfriendlyname" =>$webfriendlyname,"name"=>$row_data['username'],"matriid"=>$row_data['matri_id'],"email_id"=>$row_data['email'],"site_domain_name"=>$web_name,"confirm_link"=>$confirm_link,"contact_us"=>$contact_us,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"premium_member"=>$premium_member,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"from_email"=>$from_email);

			$email_template = $this->common_front_model->getstringreplaced($email_template, $trans);

			$this->common_model->common_send_email($email,$subject,$email_template);
		}

		$cpassword_expire = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). " + 1 days"));

		$where_arra = array('id'=>$insert_id);
		$data_array = array('cpassword'=>$cpassword,'cpassword_expire'=>$cpassword_expire,'cpass_status'=>'Not-Verify');
		$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);

		if(isset($row_data['mobile']) && $row_data['mobile'] != '')
		{
			$mobile = $row_data['mobile'];
			$get_sms_temp = $this->common_front_model->get_sms_template('Registration');
			$template_id =$get_sms_temp['template_id'];
			if(isset($get_sms_temp) && $get_sms_temp!='')
			{
				$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
				$trans = array("web_frienly_name"=>$webfriendlyname);

				$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
				// $this->common_model->common_sms_send($mobile,$sms_template);
				// $this->common_model->common_sms_send($mobile,$sms_template,$template_id);
			}
		}
	}

	public function confirm_mail_id($cpassword='',$email='')
	{
		if($cpassword != '' && $email != ''){
			$today_date = $this->common_model->getCurrentDate();
			$email_decode = base64_decode($email);
			$val = $this->db->escape_str($email_decode);
			//'email'=>trim($email_decode),
			$where_arra = array("email = ( _latin1 '".$val."') ",'cpassword'=>$cpassword,'cpass_status'=>'Not-Verify','is_deleted'=>'No');
			$where_arra[] = " cpassword_expire > '$today_date' ";
			$count_varify = $this->common_model->get_count_data_manual('register',$where_arra,0,'id','id desc',1,1);
			$already_count_varify = $this->common_model->get_count_data_manual('register',array("email = ( _latin1 '".$val."') ",'cpassword'=>$cpassword,'cpass_status'=>'Verify','is_deleted'=>'No'),0,'id','id desc',1,1);

			$expired = $this->common_model->get_count_data_manual('register',array("email = ( _latin1 '".$val."') ",'cpassword'=>$cpassword,'cpass_status'=>'Not-Verify'),1,'cpassword_expire','id desc','','');

			if(isset($count_varify) && $count_varify!='')
			{
				$data_array = array('cpass_status'=>'Verify','status'=>'APPROVED');
				$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);

				if(isset($row_data1) && $row_data1!='')
				{
					//app push notification
					$notify_array = array("email = ( _latin1 '".$val."') ","cpassword_expire > '$today_date'");
					$active_data = $this->common_model->get_count_data_manual('register',$notify_array,1,'ios_device_id,android_device_id,matri_id,mobile,email','id desc','',1);

					if(isset($active_data) && $active_data!='' && count($active_data)>0)
					{
						foreach ($active_data as $key => $value) {


							if(isset($value) && $value!='' && isset($key) && $key!='matri_id')
							{
							        $config_arra = $this->common_model->get_site_config();
                        			$web_name = $config_arra['web_name'];
                        			$webfriendlyname = $config_arra['web_frienly_name'];
							    	$get_sms_temp = $this->common_front_model->get_sms_template('Active Profile');
							    	$matri_id = $active_data['matri_id'];
									$template_id =$get_sms_temp['template_id'];

								if(isset($get_sms_temp) && $get_sms_temp!='')
								{
									$login_id = $active_data['matri_id'].' or '.$active_data['email'];
									$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
									$trans = array("web_frienly_name"=>$webfriendlyname,"XXXnameXXX"=>$login_id);
									$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
									$this->common_model->common_sms_send($active_data['mobile'],$sms_template,$template_id);

								}

								$matri_id = $active_data['matri_id'];
								$active_message = 'Your '.$matri_id.' profile will be activted';
								$this->common_model->new_send_notification_android($value,$active_message,'Account Activated','active_act','active_act');
							}
						}
					}
					?><script type="text/javascript">
						alert('Your account has been activated.');
						window.location.href = '<?php echo $this->base_url;?>';
					</script>"<?php
				}
			}
			else if($already_count_varify>0){
				?><script type="text/javascript">
				alert('Already Verified Your Account.');
				window.location.href = '<?php echo $this->base_url."login";?>';
				</script>"<?php
			}
			else if(isset($expired['cpassword_expire']) && $expired['cpassword_expire'] < $today_date)
			{
				?><script type="text/javascript">
				alert('Activation date is expired. Please Contact to Administrator.');
				window.location.href = '<?php echo $this->base_url."contact";?>';
				</script>"<?php
			}
			else
			{
				?><script type="text/javascript">
				alert('Error in activation. Please Contact to Administrator.');
				window.location.href = '<?php echo $this->base_url."contact";?>';
				</script>"<?php
			}
		}else{
			?><script type="text/javascript">
			alert('Error in activation. Please Contact to Administrator.');
			window.location.href = '<?php echo $this->base_url."contact";?>';
			</script>"<?php
		}
	}

	public function save_profile($is_post = 0,$step='step1')
	{
		//$member_id = $this->common_front_model->get_user_id();
		$member_id = $this->session->userdata('recent_reg_id');

		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';
		if(!isset($member_id) || $member_id == '' )
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out. Please contact to admin.";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			$this->common_model->set_table_name('register');
			$_REQUEST['mode'] ='edit';
			$_REQUEST['id'] =$member_id;
			$response = $this->common_model->save_update_data(1,1);
			$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				$data1['errmessage'] =  "<i class='fa fa-check text-success'></i> Your partner preferences has been added successfully.";
				$data1['status'] = 'success';
			}
			else
			{
				$data1['errmessage'] = strip_tags($data1['response']);
				unset($data1['response']);
			}
			if($is_post == 0)
			{
				if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='NI-WEB')
				{
					if(isset($data1['response']))
					{
						unset($data1['response']);
					}
					$data1['errmessage'] = strip_tags($data1['errmessage']);
				}
				$data['data'] = json_encode($data1);
				return $data;
			}
			else
			{
				if(isset($data1['status']) && $data1['status'] == 'success')
				{
					$this->session->set_flashdata('success_message', "<div class='alert alert-success'><i class='fa fa-check text-success'></i> Your profile has been saved successfully.</div>");
					return 'success';
				}
				else
				{
					if(isset($data1['errmessage']) && $data1['errmessage'] !='')
					{
						$this->session->set_flashdata('error_message', "<div class='alert alert-danger'>".$data1['errmessage']."</div>");
					}
					return 'error';
				}
			}
		}
	}

	public function send_mail_member(){
		$config_data = $this->common_model->data['config_data'];
		if(!isset($_POST['user_agent']) || $_POST['user_agent'] != 'NI-AAPP'){
			$_POST['member_id'] = $this->session->userdata('recent_reg_id');
		}
		if($this->input->post('member_id')){
			$member_id = $this->input->post('member_id');

			$this->session->set_userdata('recent_reg_id', $member_id);

			$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id),1,'id, matri_id, status, email, username, firstname, lastname, mobile');
			$email = $row_data['email'];
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
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

			$get_email_template = $this->common_front_model->getemailtemplate('Registration');
			$subject = $get_email_template['email_subject'];
			$email_content= $get_email_template['email_content'];

			$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES);
			$trans = array("webfriendlyname" =>$webfriendlyname,"name"=>$row_data['username'],"matriid"=>$row_data['matri_id'],"email_id"=>$row_data['email'],"site_domain_name"=>$web_name,"contact_us"=>$contact_us,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"premium_member"=>$premium_member,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"from_email"=>$from_email);

			$email_template = $this->common_front_model->getstringreplaced($email_template, $trans);

			$subject = $this->common_front_model->getstringreplaced($subject, $trans);

			$this->common_model->common_send_email($email,$subject,$email_template);

			if(isset($row_data['mobile']) && $row_data['mobile'] != '')
			{
				$mobile = $row_data['mobile'];
				$get_sms_temp = $this->common_front_model->get_sms_template('Registration');
				$template_id =$get_sms_temp['template_id'];
				if(isset($get_sms_temp) && $get_sms_temp!='')
				{
					$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
					$trans = array("web_frienly_name"=>$webfriendlyname);

					$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
					$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
				}
			}
			$this->sent_confirm_mail_message_user();
		}
	}


}
?>