<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Match_results extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->admin_path = $this->common_model->getconfingValue('admin_path');
		$this->data['admin_path'] = $this->admin_path;
		$this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->load->model('back_end/login_model');
	}
	
	public function index()
	{
		if($this->session->userdata('matrimonial_user_data') && $this->session->userdata('matrimonial_user_data') !="" && count($this->session->userdata('matrimonial_user_data')) >0 )
		{
			redirect($this->base_url_admin.'dashboard');
		}
		$this->data['page_title'] = '';
		$this->data['check_results'] = 'No';
		$this->data['config_data'] = $this->common_model->get_site_config();
		
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('captcha_code',$code);
		// generate captcha
		
		//$this->load->view('admin/page_part/header',$this->data);
		$this->load->view('back_end/match_results_view',$this->data);
	}
	public function validate_captcha()
	{
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code or reload captcha');
			return false;
		}else{
			return true;
		}
	
	}
	public function check_login()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha');

		
		$is_post = 0;

		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if ($this->form_validation->run() == FALSE)
        {
        	$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
			}
		}
		else
		{
			$table_name = 'admin_user';
			$password = trim($this->input->post('password'));
			$where_arra = array(
				'web_appkey'=>$password,
			);
			$row_data = $this->common_model->get_count_data_manual('site_config',$where_arra,1);
			//echo $this->db->last_query();die;
			$return_message = "";
			$status = 'error';
			
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				$login_succ = 1;
				if($table_name == 'admin_user')
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
					$row_data1 = $this->common_model->update_insert_data_common($table_name, $data_array, $where_arra);
					
					$row_data['user_type'] = $user_type;
					$this->session->set_userdata('matrimonial_user_data', $row_data);
				}
			}
			else
			{
				$return_message = "Your username and password is wrong. Please try again...";
			}
			$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
			$data['data'] = json_encode($return_arr);

		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if($return_arr['status'] == 'success')
			{
				if($this->session->userdata('captcha_code'))
				{
					$this->session->unset_userdata('captcha_code');
				}
				redirect($this->base_url_admin.'dashboard');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url_admin.'login');
			}
		}
	}
	public function log_out($per='')
	{
		if($this->session->userdata('matrimonial_user_data'))
		{
			$this->session->unset_userdata('matrimonial_user_data');
		}
		$this->session->unset_userdata('time_zone');
		$this->session->set_flashdata('user_log_out', 'You have successfully logged out');
		redirect($this->base_url_admin.'login');
	}
	public function forgot_password()
	{
		if($this->session->userdata('matrimonial_user_data') && $this->session->userdata('matrimonial_user_data') !="" && count($this->session->userdata('matrimonial_user_data')) >0 )
		{
			redirect($this->base_url.'search');
		}
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('for_captcha_code',$code);
		// generate captcha
		$this->data['page_title'] = '';
		$this->data['config_data'] = $this->common_model->get_site_config();

		$this->load->view('back_end/forgot_password',$this->data);
	}
	public function validate_captcha_for()
	{
		if($this->input->post('code_captcha') != $this->session->userdata['for_captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha_for', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	
	}
	public function check_email_forgot()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha_for');
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$data['data'] = $this->login_model->check_reset_forgot_password();
		}
		$this->load->view('common_file_echo',$data);
	}
	public function reset_password($password='',$email='')
	{
		if($password !='' && $email !='')
		{
			$response = $this->login_model->check_reset_link($password,$email);
			if($response =='success')
			{
				$this->data['page_title'] = '';
				$this->data['config_data'] = $this->common_model->get_site_config();
				$this->load->view('back_end/reset_password',$this->data);
			}
			else
			{
				redirect($this->base_url_admin.'login');
			}
		}
		else
		{
			redirect($this->base_url_admin.'login');
		}
	}
	public function reset_update()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'New Password', 'required');
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
			}
		}
		else
		{
			$return_arr = $this->login_model->reset_update_pass();
			if($return_arr['status'] == 'success')
			{
				$this->session->unset_userdata('email_reset');
			}
			$data['data'] = json_encode($return_arr);
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if($return_arr['status'] == 'success')
			{
				$this->session->set_flashdata('user_log_out', $return_arr['errmessage']);
				redirect($this->base_url_admin.'login');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url_admin.'login');
			}
		}
	}
}