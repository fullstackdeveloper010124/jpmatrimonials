<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
	}

    public function index($page=1)
	{	

    }

    public function validate_captcha()
	{	
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_vendor'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}

    public function vendor_register() 
	{
		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$this->common_model->extra_css_fr = array('css/select2.min.css');	
		$this->common_model->css_extra_code_fr.='
		@media only screen and (max-device-width: 480px) and (min-device-width: 320px){
			.select2-container {
				margin-top:0px!important;
			}
			.mtc-10 {
				margin-top: 0px;
			}
		}
		.md-radio label {
			height: 4px;
		}
		.select2-container--default .select2-selection--single {
			margin-bottom: 2px;
			height: 44px;
			border: 1px solid #e3e3e3;
			-webkit-appearance: none;
			color: #9d9d9d;
			border-radius: 4px
		}
		.select2-container .select2-selection--single .select2-selection__rendered {
			text-align: left;
			padding: 5px 5px 5px 27px;
		}';

		$this->common_model->front_load_header('Vendor Register');
		$this->load->view('front_end/vendor_register');		
	}

    public function vendor_login() 
	{
		$this->common_front_model->vendor_already_login_redirect();
		
		// generate captcha
			$code = rand(100000,999999);
			$this->session->set_userdata('captcha_vendor',$code);
		// generate captcha

		$this->common_model->is_body_class = 'Yes';
		$this->common_model->is_home_page = 'Yes';
		$this->common_model->extra_css_fr= array('css/select2.min.css');
		$this->common_model->css_extra_code_fr.='
		@media only screen and (max-device-width: 480px) and (min-device-width: 320px){
			.select2-container {
				margin-top:0px!important;
			}
			.mtc-10 {
				margin-top: 0px;
			}
		}
		.md-radio label {
			height: 4px;
		}
		.select2-container--default .select2-selection--single {
			margin-bottom: 2px;
			height: 44px;
			border: 1px solid #e3e3e3;
			-webkit-appearance: none;
			color: #9d9d9d;
			border-radius: 4px
		}
		.select2-container .select2-selection--single .select2-selection__rendered {
			text-align: left;
			padding: 5px 5px 5px 27px;
		}';

		$this->common_model->front_load_header('Vendor Login');
		$this->load->view('front_end/vendor_login');
	}

	public function save_register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('title', 'Name of the business', 'required');
		$this->form_validation->set_rules('category_id', 'Services provided', 'required');
		$this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('country_code', 'Country Code', 'required');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|numeric|min_length[8]|max_length[20]');

		if ($this->form_validation->run() == FALSE){
			$response['tocken'] = $this->security->get_csrf_hash();
			$response['errmessage'] =  strip_tags(validation_errors());
			$response['status'] = 'error';
		}

		if($this->input->post('email')!='')
		{
			$email = trim($this->input->post('email'));
			$_REQUEST['mobile'] = $this->input->post('country_code').'-'.$this->input->post('mobile_number');
			$count_mobile=$count_email= 0;
			$count_email = $this->common_model->get_count_data_manual('wedding_planner',array('email'=>$email,'is_deleted'=>'No'),0,'id');
			$count_mobile = $this->common_model->get_count_data_manual('wedding_planner',array('mobile'=>$_REQUEST['mobile'],'is_deleted'=>'No'),0,'id');
			$response['mobile'] = $count_mobile;
			if($count_email == 0 && $count_mobile == 0)
			{
				$_REQUEST['password'] = md5($_REQUEST['password']);
				$this->common_model->set_table_name('wedding_planner');
				$response1 = $this->common_model->save_update_data(1,1);
				$lastInsertId = $this->common_model->last_insert_id;
				$data['tocken'] = $this->security->get_csrf_hash();
				$data = json_decode($response1, true);
				if(isset($data['status']) && $data['status'] =='success')
				{
					$response['errmessage'] =  "Your Business profile has been created";
					$response['status'] = 'success';
					$this->sendEmail($lastInsertId);
				}else{
					$response['errmessage'] =  $data['response'];
					$response['status'] = 'error';
				}
			}	
			else
			{
				if($count_email > 0 && $count_mobile > 0)
				{
					$response['errmessage'] =  "Duplicate Email address and mobile number found, please enter another one";
				}
				else if($count_email > 0)
				{
					$response['errmessage'] =  "Duplicate Email address found, please enter another one";
				}
				else
				{
					$response['errmessage'] =  "Duplicate Mobile Number found, please enter another one";
				}
				$response['tocken'] = $this->security->get_csrf_hash();
				$response['status'] = 'error';
			}
		}
		$response['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($response);
		$this->load->view('common_file_echo',$data);
	}

	public function sendEmail($id='')
	{
		if(!empty($id)){
			$config_data = $this->common_model->data['config_data'];

			$row_data = $this->common_model->get_count_data_manual('wedding_planner',array('id'=>$id),1,'*');
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

			$get_email_template = $this->common_front_model->getemailtemplate('Vendor Registration');
			$subject = $get_email_template['email_subject'];
			$email_content= $get_email_template['email_content'];

			$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES);
			$trans = array("webfriendlyname" =>$webfriendlyname,"username"=>$row_data['planner_name'],"email_id"=>$row_data['email'],"site_domain_name"=>$web_name,"contact_us"=>$contact_us,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"premium_member"=>$premium_member,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"from_email"=>$from_email);

			$email_template = $this->common_front_model->getstringreplaced($email_template, $trans);

			$subject = $this->common_front_model->getstringreplaced($subject, $trans);
			$this->common_model->common_send_email($email,$subject,$email_template);
			if(isset($config_data['contact_email']) && $config_data['contact_email'] != ''){
				$adminEmail = $config_data['contact_email'];
				$this->common_model->common_send_email($adminEmail,$subject,$email_template);
			}
		}
	}
	
	public function check_login()
	{
		$is_post = 0;
		if($this->input->post('is_post')){
			$is_post = trim($this->input->post('is_post'));
		}
		$already_login = $this->common_front_model->vendor_already_login_redirect($is_post);
		if(isset($already_login['status']) && $already_login['status']=='al_ready_login') 
		{
			$return_arr = array('status'=>$already_login['status']);
			echo json_encode($return_arr);
			exit();
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Email ID', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'required|callback_validate_captcha');

		if ($this->form_validation->run() == FALSE){
			$response['tocken'] = $this->security->get_csrf_hash();
			$response['errmessage'] =  strip_tags(validation_errors());
			$response['status'] = 'error';

			echo json_encode($response);
			exit();
		}
	
		$username = trim($this->input->post('username'));
		$password = trim($this->input->post('password'));

		$password_md5 = md5($password);
		$where_arra = array(
			'email'=>$username,
			'password'=>$password_md5,
			'is_deleted'=>'No',
		);			
		
		$row_data = $this->common_model->get_count_data_manual('wedding_planner',$where_arra,1,'id,email,status,password');
		
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
					$status = 'unapprove';
			}
			if((strtolower($row_data['email']) == strtolower($username)) && $row_data['password'] == $password_md5)
			{
				if($login_succ == 1)
				{
					$login_status = '1';
					$status  = 'success';
					$return_message = "Login Successfully Done";
					$row_data['user_type'] = 'vendor';
					$this->session->set_userdata('vendor_user_data', $row_data);
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
		}
		$response['tocken'] = $this->security->get_csrf_hash();
		$response['errmessage'] =  $return_message;
		$response['status'] = $status;

		$data['data'] = json_encode($response);
		$this->load->view('common_file_echo',$data);
	}

	public function log_out()
	{
		if($this->session->userdata('vendor_user_data'))
		{
			$this->session->unset_userdata('vendor_user_data');
		}
		$this->session->set_flashdata('user_log_out', 'You have successfully logged out');
		
		redirect($this->base_url.'vendor-login');
	}

    public function vendor_dashboard() 
	{
		$this->common_front_model->already_login_redirect();

        $this->common_model->extra_css_fr= array('css/select2.min.css');
        $this->common_model->extra_js_fr = array('js/select2.js','js/jquery.validate.min.js','js/vendor/dashboard.js');
		$this->common_model->css_extra_code_fr.='
		@media only screen and (max-device-width: 480px) and (min-device-width: 320px){
			.select2-container {
				margin-top:0px!important;
			}
			.mtc-10 {
				margin-top: 0px;
			}
		}
		.md-radio label {
			height: 4px;
		}
		.select2-container{
			width: 534px !important;
		}
		.select2-container--default .select2-selection--single {
			margin-bottom: 2px;
			height: 44px;
			border: 1px solid #e3e3e3;
			-webkit-appearance: none;
			color: #9d9d9d;
			border-radius: 4px
		}
		.select2-container .select2-selection--single .select2-selection__rendered {
			text-align: left;
			padding: 5px 5px 5px 27px;
		}
			';
		$this->common_model->front_load_header();
		$this->load->view('front_end/vendor_dashboard',$this->data);
		$this->common_model->front_load_footer();
	}

    public function payment_option()
    {
        $this->common_front_model->already_login_redirect();

        $base_url = $this->data['base_url'];
        $vendor_user_data = $this->session->userdata('vendor_user_data');
	    if(isset($vendor_user_data) && $vendor_user_data!='' && $vendor_user_data > 0)
		{
            $vendorId = $vendor_user_data['id'];
            $where_payment_methods = " (status ='APPROVED')";
            $this->data['payment_methods'] = $this->common_model->get_count_data_manual('payment_method',$where_payment_methods,2,'*','','','',"");
            $this->data['vendor_data'] = $this->common_model->get_count_data_manual('wedding_planner',['id'=>$vendorId],1,'*','','','',"");

			$config_arra = $this->common_model->get_site_config();
			$planAmount = 21;
			$currency_code = 'USD';
			if(!empty($config_arra['vendor_plan_amount'])){
				$planAmount = $config_arra['vendor_plan_amount'];
				$currency_code = $config_arra['vendor_plan_currency'];
			}
            $this->data['plan_details'] = ['currency'=>'$','currency_code'=>$currency_code,'plan_ammount'=>$planAmount];

            $this->common_model->front_load_header('Vendor Payment Option');
            $this->load->view('front_end/payment_option_vendor',$this->data);
            $this->common_model->front_load_footer();
        }else{
			redirect($this->base_url.'vendor-dashboard');
			exit;
		}
    }

    public function current_plan()
    {
        $this->common_front_model->already_login_redirect();

        $base_url = $this->data['base_url'];
        $vendor_user_data = $this->session->userdata('vendor_user_data');
	    if(isset($vendor_user_data) && $vendor_user_data!='' && $vendor_user_data > 0)
		{
            $vendorId = $vendor_user_data['id'];

            $this->data['payment_data'] =  $paymentData = $this->common_model->get_count_data_manual('vendor_payments',['vendor_id'=>$vendorId],1,'*','','','',"");
            $this->data['vendor_data'] = $this->common_model->get_count_data_manual('wedding_planner',['id'=>$vendorId],1,'*','','','',"");

            $this->common_model->front_load_header('Vendor Current Plan');
            $this->load->view('front_end/vendor_current_plan',$this->data);
            $this->common_model->front_load_footer();
        }else{
			redirect($this->base_url.'vendor-dashboard');
			exit;
		}
    }

	public function save_register_step($step='step1')
	{	
		$is_post = 0;
		$this->common_front_model->set_orgin();
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';

		$vendorId = $this->common_front_model->get_vendor_session_data('id');
		if(!isset($vendorId) || $vendorId == '' )
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			$this->common_model->set_table_name('wedding_planner');
			$_REQUEST['mode'] ='edit';
			$_REQUEST['id'] =$vendorId;
			$response = $this->common_model->save_update_data(1,1);
			$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				$data1['errmessage'] =  "Your profile has been updated successfully.";
				$data1['status'] = 'success';
			}
			else
			{
				if(isset($data1['response']) && $data1['response']!='')
				{
					$data1['errmessage'] = strip_tags($data1['response']);
				}
			}
			unset($data1['response']);
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}

	public function upload_photosBK()  
	{
		$upload_path = $this->common_model->path_wedding; 
		$files = $_FILES;
		$count = count($_FILES['photos']['name']);
		$column_keys = ['image', 'image_2', 'image_3', 'image_4'];
		$uploaded_files = [];

		for ($i = 0; $i < count($column_keys); $i++) {
			 if (!empty($files['photos']['name'][$i])) {

				$_FILES['single_file']['name']     = $files['photos']['name'][$i];
				$_FILES['single_file']['type']     = $files['photos']['type'][$i];
				$_FILES['single_file']['tmp_name'] = $files['photos']['tmp_name'][$i];
				$_FILES['single_file']['error']    = $files['photos']['error'][$i];
				$_FILES['single_file']['size']     = $files['photos']['size'][$i];

				$upload_data = [
					'upload_path' => $upload_path,
					'file_name'   => 'single_file', 
					'encrypt_name' => true,
					'allowed_types' => 'jpg|jpeg|png|gif|webp'
				];
				$result = $this->common_model->upload_file($upload_data); 
				    if ($result['status'] === 'success') {
						$db_data[$column_keys[$i]] = $result['file_data']['file_name'];
					} else {
						log_message('error', 'Upload error: ' . $result['error_message']);
						$db_data[$column_keys[$i]] = ''; 
					}
			} else {
					$db_data[$column_keys[$i]] = '';
			}
		}
		echo "<pre>"; print_r($db_data); echo "</pre>";exit;
		
	}

	public function upload_photos()
	{
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';

		$vendorId = $this->common_front_model->get_vendor_session_data('id');
		if ($this->input->post('vendor_id')) {
			$vendorId = $this->input->post('vendor_id');
		}

		if (!isset($vendorId) || $vendorId == '') {
			$data1['errmessage'] = "Sorry, your session has timed out. Please login again.";
			$data['data'] = json_encode($data1);
			return $data;
		}

		$imageKeys = ['image', 'image_2', 'image_3', 'image_4'];
		$uploadedImages = [];
		$newKey = [];
		$path_wedding = $this->common_model->path_wedding;

		$hasFile = false;
		foreach ($imageKeys as $key) {
			if (isset($_FILES[$key]['name']) && $_FILES[$key]['name'] != '') {
				$hasFile = true;
				break;
			}
		}
		if (!$hasFile) {
			$data1['errmessage'] = "Please select a photo to upload.";
			$data['data'] = json_encode($data1);
			return $data;
		}
			foreach ($imageKeys as $key) {
				$temp_file_name = '';
				if (isset($_FILES[$key]['name']) && $_FILES[$key]['name'] != '') {
					$temp_data_array = array(
						'file_name'   => $key,
						'upload_path' => $path_wedding
					);
					$upload_data = $this->common_model->upload_file($temp_data_array);
					if (
						isset($upload_data['status']) && $upload_data['status'] == 'success' &&
						isset($upload_data['file_data']['file_name'])
					) {
						$temp_file_name = $upload_data['file_data']['file_name'];
						$uploadedImages[$key] = $temp_file_name;
					} else {
						$errorMessage = isset($upload_data['error_message']) ? strip_tags($upload_data['error_message']) : "Unknown error.";
						$uploadErrors[] = $errorMessage;
					}
				}
			}

			$keyName = '';
			if ($this->input->post('key_name')) {
				$keyName = $this->input->post('key_name');
			}
			$photosArr = $this->common_model->get_count_data_manual('wedding_planner',['id'=>$vendorId],1,$imageKeys,'','','',"");
			$uploadedFile = $uploadedImages[$keyName];
			$imageSlots = ['image', 'image_2', 'image_3', 'image_4'];
			foreach ($imageSlots as $slot) {
				if (empty($photosArr[$slot])) {
					$newKey[$slot] = $uploadedFile;
					break; 
				}
			}

			if (!empty($uploadErrors)) {
				$data1['status'] = 'error';
				$data1['errmessage'] = $uploadErrors[0]; 
				echo json_encode($data1);
				exit;
			}

			$_REQUEST = $newKey;
			unset($_REQUEST['vendor_id']);
			unset($_FILES);

			$this->common_model->set_table_name('wedding_planner');
			$_REQUEST['mode'] = 'edit';
			$_REQUEST['id'] = $vendorId;

			$response = $this->common_model->save_update_data(1, 1);
			$data1 = json_decode($response, true);

			if (isset($data1['status']) && $data1['status'] == 'success') {
				$data1['errmessage'] = "Image uploaded successfully.";
				$data1['status'] = 'success';
			} else {
				if (isset($data1['response']) && $data1['response'] != '') {
					$data1['errmessage'] = strip_tags($data1['response']);
				}
			}
			unset($data1['response']);

			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo', $data);
	}

	public function delete_photos()  
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
	    $postData = $this->input->post();
		 if (!empty($postData) && isset($postData['file_name']) && $postData['file_name'] != '' && isset($postData['key_name']) && $postData['key_name'] != '') {
				$vendorId = $postData['vendor_id'];
				$file_name = $postData['file_name'];
				$keyName = $postData['key_name'];
			
				$where_arra = ['id'=>$vendorId,$keyName=>$file_name];
				$updateArr = [$keyName => ''];
				$response = $this->common_model->update_insert_data_common('wedding_planner',$updateArr,$where_arra,1,0);
				if($response)
				{				
					$filePath = $this->common_model->path_wedding.$file_name;
					if(isset($filePath) && $filePath !='')
					{
						$this->common_front_model->delete_file($filePath);
					}
					$data1['status'] = 'success';
					$data1['errmessage'] = "Image Deleted Successfully.";
				}
		 }
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo', $data);
	}

	public function stripe() 
	{
		$vendorId = $this->common_front_model->get_vendor_session_data('id');
		if (isset($vendorId) && $vendorId != '' && $vendorId > 0) {
			$get_user_data = '';
			$get_user_data = $this->common_model->get_count_data_manual('wedding_planner',['id'=>$vendorId],1,'*','','','',"");
			$plan_data = $this->session->userdata('plan_data_session');
			$stripe = $this->common_model->get_count_data_manual('payment_method', " name = 'Stripe' ", 1, '*', '', '', '', "");
			if (isset($stripe) && $stripe != '' && isset($plan_data) && $plan_data != '') {
				$this->data['get_user_data'] = $get_user_data;
				$this->data['stripe'] = $stripe;
				$this->data['plan_data'] = $plan_data;
				$this->load->view('front_end/stripe_checkout_vendor', $this->data);
			} else {
				redirect($this->base_url . 'premium-member');
				exit;
			}
		} else {
			redirect($this->base_url . 'premium-member');
			exit;
		}
	}

	## stripe Payemnt Getway start 18/07/2025 
	public function stripe_response()
	{
		$session_id = $this->input->get('session_id');
		if (!$session_id) {
			redirect($this->base_url .'vendor-payment-option');
			exit;
		}
		if ($this->session->userdata('stripe_handled_' . $session_id)) {
			redirect($this->base_url .'vendor-payment-option');
			exit;
		}
		$stripeSecretKey = '';
		$stripe = $this->common_model->get_count_data_manual('payment_method', " name = 'Stripe' ", 1, '*', '', '', '', "");
		if (!empty($stripe)) {
			$stripeSecretKey = 	$stripe['key'];
		}
		$ch = curl_init("https://api.stripe.com/v1/checkout/sessions/{$session_id}");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $stripeSecretKey . ':');
		$response = curl_exec($ch);
		curl_close($ch);
		$session = json_decode($response, true);

		if (isset($session['payment_status']) && $session['payment_status'] === 'paid') {

			$this->session->set_userdata('stripe_handled_' . $session_id, true);
			$this->session->set_flashdata('payment_status', 'success');
		} else {
			$this->session->set_flashdata('payment_status', 'failed');
		}
		redirect($this->base_url .'vendor-payment-status');
		exit;
	}

	public function payment_status()
	{
		$status = 'fail';
		$paystatus = $this->session->flashdata('payment_status');
		if ($paystatus === 'success') {
			$status = 'success';
		} else{
			$status = 'fail';
		}
		if($status == 'success'){
			$vendorId = $this->common_front_model->get_vendor_session_data('id');
			if(isset($vendorId) && $vendorId != '')
			{
				// update old plan to current plan no
				$data_array = array('current_plan'=>'No');
				$where_arra = array('vendor_id'=>$vendorId,'current_plan'=>'Yes');
				$this->common_model->update_insert_data_common('vendor_payments',$data_array,$where_arra,1,0);

				$where_arra = array('id'=>$vendorId);
				$this->common_model->update_insert_data_common('wedding_planner',['plan_status'=>'Paid'],$where_arra,1,0);

				$today_date = $this->common_model->getCurrentDate('Y-m-d');
				$plan_data = $this->session->userdata('plan_data_session');
				$expired_date = date('Y-m-d', strtotime("+1 month", strtotime($today_date)));
				$start = new DateTime($today_date);
				$end = new DateTime($expired_date);
				$duration = $start->diff($end)->days;

				$pland_data_arr = [
					'vendor_id'=> $vendorId,
					'currency'=> $plan_data['currency_code'],
					'plan_amount'=> $plan_data['plan_ammount'],
					'plan_activated'=> $today_date,
					'plan_expired'=> $expired_date,
					'plan_duration'=> $duration,
					'current_plan'=>'Yes',
				];
				$this->common_model->update_insert_data_common('vendor_payments',$pland_data_arr,'',0,0);

				// update plan status after payment done
				$row_data_cu = $this->session->userdata('vendor_user_data');
				$row_data_cu['plan_status'] = 'Paid';
				$this->session->set_userdata('vendor_user_data', $row_data_cu);
				
				$this->session->unset_userdata('plan_data_session');

				$this->data['base_url'] = $this->base_url;
				$this->data['status'] = $status;

				$this->common_model->front_load_header('Payment Success');
				$this->load->view('front_end/payment_success',$this->data);
				$this->common_model->front_load_footer();
			}
		}
		else
		{
			$this->data['base_url'] = $this->base_url;
			$this->data['status'] = $status;

			$this->common_model->front_load_header('Payment Fail');
			$this->load->view('front_end/payment_fail',$this->data);
			$this->common_model->front_load_footer();
		}
	}

	## stripe Payemnt Getway start 18/07/2025 
	public function payment_cancel_stripe()
	{
		redirect($this->base_url . 'vendor-payment-option');
		exit;
	}

}