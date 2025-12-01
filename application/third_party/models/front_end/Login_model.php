<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'register';
	}
	public function check_login()
	{
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		$password_md5 = md5($password);
		$where_arra = array(
			'password'=>$password_md5,
			'is_deleted'=>'No',
		);
		$where_arra[] = " (email = '$username' or matri_id = '$username' ) ";
		$row_data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,1,'id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender,  password ');
		$return_message = "";
		$status = 'error';
		if(isset($row_data) && $row_data !='' && count($row_data) > 0)
		{
			$login_succ = 1;
			if(isset($row_data['status']) && $row_data['status'] !='' && ($row_data['status'] == 'Suspended'))
			{
				$return_message = "Your account is Suspended, please contact to admin.";
				$login_succ = 0;
			}			
			if((strtolower($row_data['email']) == strtolower($username) || strtolower($row_data['matri_id']) == strtolower($username)) && $row_data['password'] == $password_md5)
			{
				if($login_succ == 1)
				{
					$login_dt = $this->common_model->getCurrentDate();
					$status  = 'success';
					$return_message = "Login Successfully Done";
					$this->db->set('last_login', $login_dt);
					$where_arra = array(
						'id'=>$row_data['id']
					);
					$data_array = array('last_login'=>$login_dt);
					$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
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
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash(),'user_data'=>$row_data);
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
		$forgot_password_link = $web_name."login/reset-password/$c_password/$email";
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
				'email'=>$email_reset
			);
			$data_array = array('password'=>$password_md5,'cpassword'=>'');
			$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
			if($row_data1)
			{
				$return ='success';
				$return_message = "Your password has been successfully reset, please login with new password.";
			}
		}
		else
		{
			$return_message = "Your have already reset your password, please login with new password.";
		}
		$return_arr = array('status'=>$return,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return $return_arr;
	}
}