<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		 header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/login_model');
		$this->load->model('front_end/custom_chat_model');
	}
	public function index()
	{	
		if($this->session->userdata('member_fb_data'))
		{
			$this->session->unset_userdata('member_fb_data');
		}
		$this->common_front_model->already_login_redirect();
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('captcha_code',$code);
		// generate captcha
	    $this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Login'),1,'*','','');
		$this->common_model->extra_css_fr= array('css/select2.min.css');
		$this->common_model->css_extra_code_fr.='';
		$seo_title='';
		$seo_description ='';
		$seo_keywords='';
		$og_title = '';
		$og_description = '';
		$og_image = '';
		if(isset($seo_data['seo_title']) && $seo_data['seo_title'] !='')
		{
			$seo_title = $seo_data['seo_title'];
		}
		if(isset($seo_data['seo_description']) && $seo_data['seo_description'] !='')
		{
			$seo_description = $seo_data['seo_description'];
		}
		if(isset($seo_data['seo_keywords']) && $seo_data['seo_keywords'] !='')
		{
			$seo_keywords = $seo_data['seo_keywords'];
		}
		if(isset($seo_data['og_title']) && $seo_data['og_title'] !='')
		{
			$og_title = $seo_data['og_title'];
		}
		if(isset($seo_data['og_description']) && $seo_data['og_description'] !='')
		{
			$og_description = $seo_data['og_description'];
		}
		if(isset($seo_data['og_image']) && $seo_data['og_image'] !='')
		{
			$og_image = $seo_data['og_image'];
		}
		$this->common_model->front_load_header('Login','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$where_fb = array("status"=>'APPROVED',"is_deleted"=>'No','id'=>'1');
		$get_fb_details = $this->common_front_model->get_count_data_manual('social_login_master',$where_fb,'1','social_name,client_key,client_secret');
		$this->data['fb_detail'] = "";
		if($get_fb_details!='' && count($get_fb_details) > 0 )
		{ 
		   $this->data['fb_detail'] = $get_fb_details;
		}
		$this->load->view('front_end/login',$this->data);
	}
	public function validate_captcha()
	{
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	
	}
	public function change_captcha()
	{
		if(isset($_REQUEST['captcha_session']) && $_REQUEST['captcha_session'] !='')
		{	
			$captcha_session = $_REQUEST['captcha_session'];
			$code = rand(100000,999999);
			$this->session->set_userdata($captcha_session,$code);
			$data['captcha_session'] = $captcha_session;
			$data['base_url'] = base_url();
			$this->load->view('front_end/captcha_reload_view',$data);
		}
	}
	public function check_login()
	{
		$is_post = 0;
		if($this->input->post('is_post')){
			$is_post = trim($this->input->post('is_post'));
		}
		$is_home = 'No';
		if($this->input->post('is_home')){
			$is_home = trim($this->input->post('is_home'));
		}
		
		$already_login = $this->common_front_model->already_login_redirect($is_post);
		
		if (isset($already_login['status']) && $already_login['status']=='al_ready_login') 
		{
			$return_arr = array('status'=>$already_login['status']);
			echo json_encode($return_arr);
			exit();
		}
		$this->load->library('form_validation');
		// $this->form_validation->set_rules('username', 'Email ID or Matri ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if(isset($is_home) && $is_home=='No'){
			$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha');
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
			$return_arr = $this->login_model->check_login();
			if($return_arr['status'] == 'success' && isset($return_arr['user_data']) && !empty($return_arr['user_data'])){
				$loggedin_member_data = $return_arr['user_data'];
				$isExist_login = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id' => $loggedin_member_data['id']),1,'id','','','',0);
				if(empty($isExist_login)){
					## Insert : 
					$insert_arr['member_id'] = (int)$loggedin_member_data['id'];
					$insert_arr['matri_id'] = $loggedin_member_data['matri_id'];
					$insert_arr['username'] = $loggedin_member_data['username'];
					$insert_arr['gender'] = $loggedin_member_data['gender'];
					$insert_arr['created_at'] = date('Y-m-d H:i:s');
					$this->db->insert('custom_chat_online_member',$insert_arr);
				}else{
					## Update : 
					$update_arr['member_id'] = (int)$loggedin_member_data['id'];
					$update_arr['matri_id'] = $loggedin_member_data['matri_id'];
					$update_arr['username'] = $loggedin_member_data['username'];
					$update_arr['gender'] = $loggedin_member_data['gender'];
					$update_arr['created_at'] = date('Y-m-d H:i:s');
					$this->db->where('id',$isExist_login['id']);
					$this->db->update('custom_chat_online_member',$update_arr);
				}
				## Send Topic Notification For Online Offline : 
				$this->custom_chat_model->topic_send_notification_web();
				$this->common_model->new_send_notification_android_topic_to_all('Chat User Refresh',"Chat Refresh","chat_topic_android");

				## Subscribe Chat Topic For Web :
                $user_data1 = $this->common_front_model->get_user_data("register_view",$loggedin_member_data['id']);
                if ($user_data1['web_device_id'] != '') {
                    $this->common_model->subscribeToTopicWeb([$user_data1['web_device_id']], 'chat_topic_web');
                }
			}
			$data['data'] = json_encode($return_arr);
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if(isset($return_arr['status']) && $return_arr['status'] == 'success')
			{
				if($this->session->userdata('captcha_code'))
				{
					$this->session->unset_userdata('captcha_code');
				}
				redirect($this->base_url.'my-profile');
			}
			else 
			{
				if(isset($return_arr['errmessage']) && $return_arr['errmessage'] !='')
				{
					$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				}
				else if(isset($data1['errmessage']) && $data1['errmessage'] !='')
				{
					$this->session->set_flashdata('user_log_err', $data1['errmessage']);
				}
				if(isset($is_home) && $is_home=='No'){
					redirect($this->base_url.'login');
				}
				else{
					redirect($this->base_url);	
				}
			}
		}	
	}
	public function check_login_service()
	{
		$this->common_front_model->set_orgin();
		$return_arr = $this->login_model->check_login();
		if($return_arr['status'] == 'success' && isset($return_arr['user_data']) && !empty($return_arr['user_data'])){
			$loggedin_member_data = $return_arr['user_data'];
			$isExist_login = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id' => $loggedin_member_data['id']),1,'id','','','',0);
			if(empty($isExist_login)){
				## Insert : 
				$insert_arr['member_id'] = (int)$loggedin_member_data['id'];
				$insert_arr['matri_id'] = $loggedin_member_data['matri_id'];
				$insert_arr['username'] = $loggedin_member_data['username'];
				$insert_arr['gender'] = $loggedin_member_data['gender'];
				$insert_arr['created_at'] = date('Y-m-d H:i:s');
				$this->db->insert('custom_chat_online_member',$insert_arr);
			}else{
				## Update : 
				$update_arr['member_id'] = (int)$loggedin_member_data['id'];
				$update_arr['matri_id'] = $loggedin_member_data['matri_id'];
				$update_arr['username'] = $loggedin_member_data['username'];
				$update_arr['gender'] = $loggedin_member_data['gender'];
				$update_arr['created_at'] = date('Y-m-d H:i:s');
				$this->db->where('id',$isExist_login['id']);
				$this->db->update('custom_chat_online_member',$update_arr);
			}
			## Send Topic Notification For Online Offline : 
			$this->custom_chat_model->topic_send_notification_web();
			$this->common_model->new_send_notification_android_topic_to_all('Chat User Refresh',"Chat Refresh","chat_topic_android");
		}
		$data['data'] = json_encode($return_arr);
		$this->load->view('common_file_echo',$data);
	}
	// changes for shakil 18-12-2020
	public function forgot_password()
	{	
		$this->common_front_model->already_login_redirect();
		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$code = rand(100000,999999);
		$this->session->set_userdata('for_captcha_code',$code);
		//$this->common_model->extra_css_fr= array('css/hover-img.css');

		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Forgot Password'),1,'*','','');
		$this->common_model->extra_css_fr= array('css/select2.min.css');
		$this->common_model->css_extra_code_fr.='';
		$seo_title='';
		$seo_description ='';
		$seo_keywords='';
		$og_title = '';
		$og_description = '';
		$og_image = '';
		if(isset($seo_data['seo_title']) && $seo_data['seo_title'] !='')
		{
			$seo_title = $seo_data['seo_title'];
		}
		if(isset($seo_data['seo_description']) && $seo_data['seo_description'] !='')
		{
			$seo_description = $seo_data['seo_description'];
		}
		if(isset($seo_data['seo_keywords']) && $seo_data['seo_keywords'] !='')
		{
			$seo_keywords = $seo_data['seo_keywords'];
		}
		if(isset($seo_data['og_title']) && $seo_data['og_title'] !='')
		{
			$og_title = $seo_data['og_title'];
		}
		if(isset($seo_data['og_description']) && $seo_data['og_description'] !='')
		{
			$og_description = $seo_data['og_description'];
		}
		if(isset($seo_data['og_image']) && $seo_data['og_image'] !='')
		{
			$og_image = $seo_data['og_image'];
		}
		//$this->common_model->front_load_header('Forgot Password','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);

		$this->common_model->css_extra_code_fr.='.cstm-logo{
			padding: 0px 0px !important;
			position: relative!important;
			top: -6px!important;}';
		$this->common_model->front_load_header('Forgot Password','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/forgot_password');
	}
	// public function forgot_password()
	// {	
	// 	$this->common_front_model->already_login_redirect();
	// 	$this->common_model->is_body_class = 'Yes';
	// 	$this->common_model->is_home_page = 'Yes';
	// 	$code = rand(100000,999999);
	// 	$this->session->set_userdata('for_captcha_code',$code);
	// 	//$this->common_model->extra_css_fr= array('css/hover-img.css');
	// 	$this->common_model->css_extra_code_fr.='.cstm-logo{
	// 		padding: 0px 0px !important;
	// 		position: relative!important;
	// 		top: -6px!important;}';
	// 	$this->common_model->front_load_header('Forgot Password');
	// 	$this->load->view('front_end/forgot_password');
	// }
	public function validate_captcha_for()
	{
		if($this->input->post('code_captcha') != $this->session->userdata['for_captcha_code'])
		{
			$this->form_validation->set_message('validate_captcha_for', 'Wrong captcha code, Please enter valid captcha code or reload captcha');
			return false;
		}else{
			return true;
		}
	
	}
	public function check_email_forgot()
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		
		if($user_agent!='NI-WEB')
		{
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Email ID', 'required|valid_email');
		}// for web API
		else
		{
			$this->common_front_model->already_login_redirect();
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Email ID', 'required|valid_email');
			$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha_for');
		}
		
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
			$data1 = json_decode($data['data'], true);
		}
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{

			if(isset($data1['errmessage']) && $data1['errmessage'] !='')
			{
				$this->session->set_flashdata('user_log_err', $data1['errmessage']);
			}
			redirect($this->base_url.'login/forgot-password');
		}
	}
	public function reset_password($password='',$email='')
	{
		$this->common_front_model->already_login_redirect();
		if($password !='' && $email !='')
		{
			$response = $this->login_model->check_reset_link($password,base64_decode($email));
			if($response =='success')
			{
				$this->common_model->is_body_class = 'Yes';
				$this->common_model->is_home_page = 'Yes';
				//$this->common_model->extra_css_fr= array('css/hover-img.css');
				$this->common_model->front_load_header();
				$this->load->view('front_end/reset_password');
			}
			else
			{
				redirect($this->base_url.'login');
			}
		}
		else
		{
			redirect($this->base_url.'login');
		}
	}
	public function reset_update()
	{
		$this->common_front_model->already_login_redirect();
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
				redirect($this->base_url.'login');
			}
			else 
			{
				$this->session->set_flashdata('user_log_err', $return_arr['errmessage']);
				redirect($this->base_url.'login');
			}
		}
	}
	public function cron_job_logout()
	{
		// for update register for is_logged in
		$newTime = strtotime('-20 minutes');
		$login_dt = date('Y-m-d H:i', $newTime);
		$this->common_model->is_delete_fild="";
		$need_to_update_reg = $this->common_model->get_count_data_manual('member_activity'," date_time > '$login_dt' ",0);
		if($need_to_update_reg > 0)
		{
			$sql_update_data = " update register set logged_in ='1' where id in (SELECT index_id FROM member_activity WHERE date_time > '$login_dt') and logged_in ='0' ";
			$this->db->query($sql_update_data);
		}

		$need_to_update_reg_on = $this->common_model->get_count_data_manual('member_activity'," date_time < '$login_dt' ",0);
		
		if($need_to_update_reg_on > 0)
		{
			$sql_update = " update register set logged_in ='0' where id in (SELECT index_id FROM member_activity WHERE date_time < '$login_dt') and logged_in ='1' ";
			$this->db->query($sql_update);
			$sql_delete = " delete from member_activity WHERE date_time < '$login_dt' ";
			$this->db->query($sql_delete);
			
		}
	}
	//for app logout function
	public function logout($id='')
	{
	    $logged_in_user_id = $this->input->post('member_id');
	    if(isset($logged_in_user_id) && $logged_in_user_id != ''){
	    	$member_id = $logged_in_user_id;
	    }else{
	        $member_id = $id;
	    }
		$data1 = '';
		if(isset($member_id) && $member_id !='')
		{
			$where_logout = array('index_id'=>$member_id);
			$check_login = $this->common_front_model->get_count_data_manual('member_activity',$where_logout,0,'*','','',1);
			if(isset($check_login) && $check_login>0)
			{
				$row_data = $this->common_model->data_delete_common('member_activity', $where_logout,'','Yes');
			}
			
			$whereArr = array('index_id'=>$member_id);
			$check_onilne_user = $this->common_front_model->get_count_data_manual('online_users',$whereArr,0,'*','','',1);
			if(isset($check_onilne_user) && $check_onilne_user>0)
			{
				$row_data = $this->common_model->data_delete_common('online_users', $whereArr,'','Yes');
			}
			
			$login_status = '0';
			$where_arra = array('id'=>$member_id);
			$data_array = array('logged_in'=>$login_status,'web_device_id' => '');
			$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);
			## Delete From Online Users Table :
			$this->db->where('member_id',$member_id);
			$this->db->delete('custom_chat_online_member');
			## Send Topic Notification For Online Offline : 
			$this->custom_chat_model->topic_send_notification_web();
			$this->common_model->new_send_notification_android_topic_to_all('Chat User Refresh',"Chat Refresh","chat_topic_android");

			$data['status'] = 'success';
			$data['errmessage'] = 'Logout Successfully Done';
			//$data['tocken'] = $this->security->get_csrf_hash();
		}
		else
		{
			$data['status'] = 'error';
			$data['errmessage'] = 'Please try again.';
		}
		$data1 = json_encode($data);
	    $user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent=='NI-AAPP')
		{
			echo  $data1;
		}
		else{
			return $data1;
		}
		//echo $data1;
	}
	public function log_out()
	{
		$data = $this->session->userdata('mega_user_data');
		if(isset($data['id']) && $data['id'] !='')
		{
			## UnSubscribe Chat Topic For Web :
    	    $user_data1 = $this->common_front_model->get_user_data("register_view",$data['id']);
    	    if ($user_data1['web_device_id'] != '') {
    	        $this->common_model->subscribeToTopicWeb([$user_data1['web_device_id']], 'chat_topic_web', 'remove');
    	    }
			
			$where_arra = array('index_id'=>$data['id']);
			$row_data = $this->common_model->data_delete_common('online_users', $where_arra,'','Yes');
			
		// remove user from online freichat	
			$where_arra = array('session_id'=>$data['id']);
			$row_data = $this->common_model->data_delete_common('frei_session', $where_arra,'','Yes');
			$this->logout($data['id']);
		// remove user from online freichat
		}
		//
		if($this->session->userdata('mega_user_data'))
		{
			$this->session->unset_userdata('mega_user_data');
		}
		$this->session->unset_userdata('time_zone');
		
		$this->session->set_flashdata('user_log_out', 'You have successfully logged out');
		// added by mustakim for chat issue
			setcookie("freichat_user", "", time()-3600, "/");
			setcookie("PHPSESSID", "", time()-3600, "/");
			//session_start();
			//session_destroy();
		// added by mustakim for chat issue
		
		redirect($this->base_url.'login');
	}

	public function facebook_login()
	{
		$this->common_front_model->set_orgin();
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		
		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] = strip_tags(validation_errors());
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$data1 = $this->login_model->facebook_login();
			$data['data'] = json_encode($data1);
		}
		$this->load->view('common_file_echo',$data);
	}
	public function online_offline_app()
	{
		$online_offline = $this->input->post('online_offline');
		$id = $this->input->post('member_id');
		if(isset($id) && $id !='')
		{
			if($online_offline=='Online'){
				$where_online_users = array('index_id'=>$id);
				$row_data_online_users = $this->common_model->get_count_data_manual('online_users',$where_online_users,0,'','','','',0);
				if($row_data_online_users == 0 && $row_data_online_users == ''){
					$ip = $_SERVER['REMOTE_ADDR'];
					$dt = $this->common_model->getCurrentDate();
					$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$id),1,'id, username, gender');
					$data_array1 = array('ip'=>$ip,'username'=>$row_data['username'],'gender'=>$row_data['gender'],'index_id'=>$row_data['id'],'dt'=>$dt);
					$row_data1 = $this->common_model->update_insert_data_common('online_users', $data_array1, '',0);
				}
				$data1['errmessage'] = 'You have successfully logged in';
			}
			else if($online_offline=='Offline'){
				$where_arra = array('index_id'=>$id);
				$row_data = $this->common_model->data_delete_common('online_users', $where_arra,'','Yes');
				$data1['errmessage'] = 'You have successfully logged out';
			}
			$data1['status'] = 'success';
		}
		else{
			$data1['errmessage'] = '';
			$data1['status'] = 'error';
		}
		$data1['token'] = $this->security->get_csrf_hash();
		
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
}