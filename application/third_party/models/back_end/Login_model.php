<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'admin_user'; // set here tabel name for admin user and staff user and franchise for same code
	}
	public function check_login()
	{
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));
		
		if($this->table_name == 'admin_user')
		{
			$password_md5 = md5($password);
		}
		else
		{
			$password_md5 = $password;
		}
		$where_arra = array(
			'email'=>$username,
			'password'=>$password_md5,
			'is_deleted'=>'No',
		);
		$row_data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,1);
		$return_message = "";
		$status = 'error';
		
		if(isset($row_data) && $row_data !='' && count($row_data) > 0)
		{
			$login_succ = 1;
			if($this->table_name == 'admin_user')
			{
				$user_type ='admin';
			}
			else
			{
				$user_type =$this->table_name;
				
				if(isset($row_data['status']) && $row_data['status'] !='' && $row_data['status'] =='UNAPPROVED')
				{
					$return_message = "Your account is deactivated, please contact to admin.";
					$login_succ = 0;
				}
			}
			if($login_succ == 1)
			{
				$login_dt = $this->common_model->getCurrentDate();
				$status  = 'success';
				$this->db->set('last_login', $login_dt);
				$ip = $this->input->ip_address();
				$where_arra = array(
					'id'=>$row_data['id']
				);
				$data_array = array('last_login'=>$login_dt,'ip_address'=>$ip);
				$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
				
				$row_data['user_type'] = $user_type;
				$this->session->set_userdata('matrimonial_user_data', $row_data);
			}
		}
		else
		{
			$return_message = "Your username and password is wrong. Please try again...";
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return $return_arr;
	}
	public function check_reset_forgot_password()
	{
		$username = trim($this->input->post('username'));
		$username_where = " ( email ='$username') ";
		$this->db->select('*');
		$this->db->where($username_where);
		$this->db->where('is_deleted','No');
		$this->db->limit(1);
		$query = $this->db->get($this->table_name);
		$return_message = "";
		$status = 'error';
		if($query->num_rows() == 1)
		{
			$this->load->helper('string');
			$password = random_string('alnum', 8);
			$row_data = $query->row_array();
			if($this->table_name == 'admin_user')
			{
				$password_md5 = md5($password);
			}
			else
			{
				$password_md5 = $password;
			}

			$this->db->set('c_password', $password_md5);
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
		if($this->table_name == 'admin_user')
		{
			$forgot_password_link = $web_name.$this->admin_path."login/reset-password/$c_password/$email";
		}
		else
		{
			$forgot_password_link = $web_name.$this->admin_path."/".$this->table_name."/reset-password/$c_password/$email";
		}
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
		$username_where = " ( c_password ='$password' and email ='$email') ";
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
			if($this->table_name == 'admin_user')
			{
				$password_md5 = md5($password);
			}
			else
			{
				$password_md5 = $password;
			}
			$where_arra = array(
				'email'=>$email_reset
			);
			$data_array = array('password'=>$password_md5,'c_password'=>'');
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