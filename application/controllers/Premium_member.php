<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Premium_member extends CI_Controller {
	public $data = array();
	public $user_data = array();

	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model("front_end/my_plan_model");
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{
		if($this->session->userdata('coupan_data_reddem'))
		{
			$this->session->unset_userdata('coupan_data_reddem');
		}
		$this->common_model->extra_css_fr= array('css/fontello.css','css/payment-style.css','css/payment-responsive.css');

		$seoWhere = array('status'=>'APPROVED','page_title'=>'Upgrade');
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',$seoWhere,1,'seo_title,seo_description,seo_keywords,og_title,og_description,og_image','','');
		$seo_title = $seo_description = $seo_keywords = $og_title = $og_description = $og_image = '';
		$seokeyArr = array('seo_title','seo_description','seo_keywords','og_title','og_description','og_image');
		if (!empty($seo_data)) {
			foreach ($seo_data as $key => $value) {
				if (isset($seo_data[$key]) && $seo_data[$key]!='' && in_array($key,$seokeyArr)) {
					$$key = $value;
				}
			}
		}

		$plan_category = $this->common_model->get_count_data_manual('membership_plan_category',array('status'=>'APPROVED'),2,'*','id asc');
		if (!empty($plan_category)) {
			foreach ($plan_category as $key => $value) {
				$plan_category[$key]['plan_data'] = $this->common_model->get_count_data_manual('membership_plan',array('status'=>'APPROVED','category_type'=>$value['id']),2,'*','id asc');
			}
		}
		$membership_plans['plan_category'] = $plan_category;
		$membership_plans['scan_pay'] = $this->common_model->get_count_data_manual('scan_pay',array('status'=>'APPROVED'),2,'*','id asc');
		$membership_plans['offline_payment'] = $this->common_model->get_count_data_manual('offline_bank_payment',array('status'=>'APPROVED'),2,'*','id asc');

		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($current_login_user) && $current_login_user!=''){
			$names = array('plan_expired','payment_received');
			$this->db->where_in('notification_type',$names);
			$this->common_model->update_insert_data_common('web_notification_history',array('status' => 'read'),array('receiver_id'=>$current_login_user['id']));
		}

		$this->common_model->front_load_header('Premium Member','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/premium_member',$membership_plans);
		$this->common_model->front_load_footer();
	}
	public function get_payment_method()
	{
		$where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
		$select_num = 'name,logo,description';
		$payment_method = $this->common_model->get_count_data_manual('payment_method',$where_arra,2,$select_num,'id asc');
		$data1['tocken'] = $this->security->get_csrf_hash();
		if(isset($payment_method) && $payment_method !='' && count($payment_method) > 0)
		{
			$path = $this->common_model->path_payment_logo;
			$main_url = $this->common_model->base_url;
			foreach ($payment_method as $key => $value)
			{
				if(isset($value['logo']) && ($value['logo']!='' || $value['logo']!=null))
				{
					$payment_method[$key]['logo'] = $main_url.$path.$value['logo'];
				}
				if($value['logo']==null)
				{
					$payment_method[$key]['logo'] = '';
				}
				if($value['description']==null)
				{
					$payment_method[$key]['description'] = '';
				}
				if($value['name']==null)
				{
					$payment_method[$key]['name'] = '';
				}
			}
			$data1['status'] = 'success';
			$data1['plan_data'] = $payment_method;
		}
		else
		{
			$data1['status'] = 'error';
			$data1['plan_data'] = "Sorry, Currently no any Payment Method available";
		}
		$this->output->set_content_type('application/json');
		$data['data'] = $this->output->set_output(json_encode($data1));
	}
	public function get_plan_data()
	{
		//$where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
		if($this->input->post('user_agent')=='NI-IAPP')
		{
			$where_arra=array('status'=>'APPROVED','is_deleted'=>'No',"in_app_product_id!=''");
		}
		else
		{
			$where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
		}
		$plan_category = $this->common_model->get_count_data_manual('membership_plan_category',array('status'=>'APPROVED'),2,'*','id asc');
		if (!empty($plan_category)) {
			$categoryColor = array('#832644','#0093d8','#ff2121');
			$i = 0;
			foreach ($plan_category as $key => $value) {
				$plan_category[$key]['color'] = $categoryColor[$i];
				$where_arra['category_type'] = $value['id'];
				$planData = $this->common_model->get_count_data_manual('membership_plan',$where_arra,2,'*','id asc');
				$plan_category[$key]['plan_data'] = $planData!=''?$planData:array();
				$i++;
				if($i==3){
					$i=0;
				}
			}
		}
		
		$data1['scan_pay'] = $this->common_model->get_count_data_manual('scan_pay',array('status'=>'APPROVED'),2,'*','id asc');
		$data1['offline_payment'] = $this->common_model->get_count_data_manual('offline_bank_payment',array('status'=>'APPROVED'),2,'*','id asc');

		if(empty($data1['offline_payment'])){
			$data1['offline_payment'] =[];
		}
		if(empty($data1['scan_pay'])){
			$data1['scan_pay'] =[];
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		if(isset($plan_category) && $plan_category !='' && is_array($plan_category) && count($plan_category) > 0)
		{
			$data1['status'] = 'success';
			$data1['plan_data'] = $plan_category;
		}
		else
		{
			$data1['status'] = 'error';
			$data1['plan_data'] = "Sorry, Currently no any plan available";
		}
		$this->output->set_content_type('application/json');
		$data['data'] = $this->output->set_output(json_encode($data1));
	}
	public function plan_details()
	{
		if($this->session->userdata('coupan_data_reddem')){
			$this->session->unset_userdata('coupan_data_reddem');
		}
		if($this->session->userdata('plan_data_session')){
			$this->session->unset_userdata('plan_data_session');
		}

		$data1['status'] = 'error';
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['message'] = "Sorry, Currently no any plan available";
		// site setting data get
		$this->data['config_data'] = $this->common_model->get_site_config();
		// current payment method get
		$this->data['payment_method'] = $this->common_model->get_count_data_manual('payment_method',array('status'=>'approved'),1,'*','','','',"");
		
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();

		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0)){
			
			/* current login user data get #start*/
			if(isset($current_login_user['id']) && $current_login_user['id'] != ''){
				$where_arra=array('id'=>$current_login_user['id']);
			}else if(isset($insert_id) && $insert_id != ''){
				$where_arra=array('id'=>$insert_id);
			}
			$this->data['member_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			/* current login user data get #end*/

			if ($this->input->post('plan_id')!='') {
				$planId = $this->input->post('plan_id');
			}else{
				return;
			}
			$where_arra=array('is_deleted'=>'No','status'=>'APPROVED','id'=>$planId);
			$this->data['plan_data'] = $this->common_model->get_count_data_manual('membership_plan',$where_arra,1,'*','id asc');
			$data1['html'] = '';
			if (!empty($this->data['plan_data'])) {
				$data1['html'] = $this->load->view('front_end/plan_details',$this->data,true);
				$data1['message'] = "You've selected";
				$data1['status'] = 'success';
			}
		}else{
			$data1['message'] = "Please login to pay now";
			$data1['redirectUrl'] = $this->base_url."login";
		}
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($data1));
	}

	function check_coupan()
	{
		$user_agent = 'NI-WEB';
		if($this->input->post('user_agent'))
		{
			$user_agent = $this->input->post('user_agent');
		}
		$plan_id = '';
		$couponcode ='';
		if($this->input->post('plan_id'))
		{
			$plan_id = $this->input->post('plan_id');
		}
		if($this->input->post('couponcode'))
		{
			$couponcode = $this->input->post('couponcode');
		}
		$data_return = array();
		$data_return['status']   = 'error';
		$data_return['tocken'] = $this->security->get_csrf_hash();

		// site setting data get
		$this->data['config_data'] = $this->common_model->get_site_config();
		// current payment method get
		$this->data['payment_method'] = $this->common_model->get_count_data_manual('payment_method',array('status'=>'approved'),1,'*','','','',"");


		if($user_agent == "NI-AAPP")
        {
            $insert_id = $this->input->post('user_id');
    		$current_login_user = $this->input->post('user_id');
        }
        else
        {
    		$insert_id = $this->session->userdata('recent_reg_id');
    		$current_login_user = $this->common_front_model->get_session_data();
    	}

		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0)){
			
			/* current login user data get #start*/
			if(isset($current_login_user['id']) && $current_login_user['id'] != ''){
				$where_arra=array('id'=>$current_login_user['id']);
			}else if(isset($insert_id) && $insert_id != ''){
				$where_arra=array('id'=>$insert_id);
			}
			$this->data['member_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			/* current login user data get #end*/

			if($plan_id !='' &&  $couponcode !='')
			{
				$return = $this->my_plan_model->check_copan($plan_id,$couponcode);
				if($return == 'success')
				{
					$data_return['status'] = 'success';
					$this->data['plan_id'] = $plan_id;
					$this->data['base_url'] = $this->base_url;
					$where_membership_plan = " (id ='".$plan_id."')";
					$membership_plan_arr = $this->common_model->get_count_data_manual('membership_plan',$where_membership_plan,1,'*','','','',"");

					$this->data['plan_data']= $membership_plan_arr;
					if($user_agent == 'NI-WEB')
					{
						$data_return['message'] = $this->load->view('front_end/plan_details',$this->data,true);
					}
					else
					{
						$data_return['message'] = 'Coupan Code applied successfully.';
						$data_return['errmessage'] = 'Coupan Code applied successfully.';
						$data_return['discount_amount'] = $this->my_plan_model->discount_amount_temp;
					}
				}
				else
				{
					$data_return['message'] = $return;
					$data_return['errmessage'] = $return;
				}
			}
			else
			{
				$data_return['message'] = 'Please enter Coupan Code';
				$data_return['errmessage'] = 'Please enter Coupan Code';
			}
		}
		else
		{
			$data_return['message'] = 'Please login to apply coupan';
			$data_return['errmessage'] = 'Please login to apply coupan';
		}
		$data['data'] = json_encode($data_return);
		$this->load->view('common_file_echo',$data);
	}

	public function payment_success_in_app_purchase($user_id='')
	{
		$user_id = $in_app_purchase = '';
		if($this->input->post('user_id')){
			$user_id = $this->input->post('user_id');
		}
		if($this->input->post('in_app_product_id')){
			$in_app_purchase = $this->input->post('in_app_product_id');
		}
		if(isset($user_id) && $user_id!='' && isset($in_app_purchase) && $in_app_purchase!='')
		{
			$user_agent=$this->input->post('user_agent');
			$plan_id='';
			if(isset($user_agent) && $user_agent!='NI-WEB')
			{

				if(isset($in_app_purchase) && $in_app_purchase!='')
				{
					//$plan_name = explode(".",$in_app_purchase);
					$data = $this->common_model->get_count_data_manual('membership_plan',array('in_app_product_id'=>$in_app_purchase),1,'id');
					if(isset($in_app_purchase) && $in_app_purchase!='')
					{
						$plan_id = $data['id'];
					}
				}

			}
			else
			{
				$pay_gateway = $this->session->userdata('payment_method');
			}

			if($plan_id !='' && $user_id !='')
			{
				//$_REQUEST['payment_method'] = $pay_gateway;
				$data_return = $this->common_model->update_plan_member($user_id,$plan_id);

				$this->session->unset_userdata('payment_method');
				$data['status'] = 'success';
				$data['error_message'] = 'Payment Done.!!!';
			}
			else
			{
				$data['status'] = 'error';
				$data['error_message'] = 'please try again';
			}
			echo json_encode($data);
		}else{
			//redirect($this->base_url.'premium-member');
			//exit;
			$data['status'] = 'error';
			$data['error_message'] = 'please try again';
			echo json_encode($data);
		}
	}
	
	public function current_plan()
	{
		$user_agent = 'NI-WEB';
		if($this->input->post('user_agent'))
		{
			$user_agent = $this->input->post('user_agent');
		}

		if($user_agent == 'NI-WEB')
		{
			$this->common_front_model->checkLogin();
			$this->common_model->extra_css_fr= array('css/fontello.css','css/select2.css');
			$this->common_model->extra_js_fr= array('js/chosen.jquery.js','js/select2.min.js');
			$this->common_model->css_extra_code_fr.=".cstm-logo{
				padding: 0px 0px !important;
				position: relative!important;
				top: -6px!important;
				}
				.testimonial .pic {
				width: 185px;
				height: 240px;
				}
				.testimonial .pic img {
				width: 185px;
				height: 240px;
				}
				.pic-2{
				left:0px !important;
				top:175px !important;
				}
				.pic-2:before {
				content: '';
				position: absolute;
				left: 0px;
				right: 5px;
				top: 0px;
				bottom: 13px;
				background-image: linear-gradient(to bottom, rgba(255, 0, 0, 0), rgba(0, 0, 0, 0.94));
				}
				.matri-zero{
				opacity: 10;
				position: relative;
		z-index: 9999;
				}
				.testimonial .pic{
					position: relative!important;
					width: 185px;
    				height: 227px;
					top:0px;
				}
				.pic-2{
					position: absolute!important;
					left: 2px !important;
					top: 187px !important;
					border-radius: 12px !important;
				}
				.testimonial .pic img {
					width: 189px;
					height: 225px;
				}
				.dshbrd_20{
					margin: 27px auto;
				}
				";
			$this->common_model->front_load_header('Membership Current Plan');
			$this->data['plan_data_all'] = $this->my_plan_model->current_plan_detail();
			$this->load->view('front_end/current_plan',$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			$data_return = array();
			$data_return['status']   = 'error';
			$cplan_data = $this->my_plan_model->current_plan_detail('single');
			if($cplan_data !='' && count($cplan_data) > 0)
			{
				$data_return['is_show'] = true;
				$data_return['status'] = 'success';
				$data_return['data']   = $cplan_data;
			}
			else
			{
				$data_return['is_show'] = false;
				$data_return['errorMessage']   = 'Data Not Found';
				$data_return['errmessage']   = 'Data Not Found';
			}
			$data_return['token'] = $this->security->get_csrf_hash();
			$data['data'] = json_encode($data_return);
			$this->load->view('common_file_echo',$data);
		}
	}

	public function view_invoice($id = '')
	{
		if($id !='')
		{
			$this->common_front_model->checkLogin();
			$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
			$where_arra=array('matri_id'=>$login_user_matri_id,'id'=>$id);
			$payment_details = $this->common_model->get_count_data_manual('payments',$where_arra,1,'id');
			if(isset($payment_details['id']) && $payment_details['id'] !='')
			{
				$pay_id = $payment_details['id'];

				$this->db->join('register','payments.matri_id = register.matri_id','left');
				$payment_data = $this->common_model->get_count_data_manual('payments',array('payments.id'=>$pay_id),1,'payments.*,register.mobile,register.phone');

				if($payment_data !='' && count($payment_data) > 0)
				{
					$this->data['payment_data'] = $payment_data;
					$this->common_model->front_load_header('View Invoice');
					$this->load->view('front_end/member_invoice',$this->data);
					$this->common_model->front_load_footer();
				}
				else
				{
					redirect($this->base_url.'premium-member/current-plan');
					exit;
				}
			}
			else
			{
				redirect($this->base_url.'premium-member/current-plan');
				exit;
			}
		}
		else
		{
			redirect($this->base_url.'premium-member/current-plan');
		}
	}

	public function payment_status($pay_gateway)
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		$plan_data = $this->session->userdata('plan_data_session');

		if(((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0)) && isset($plan_data) && $plan_data!='')
		{
			$status = "fail";
			if(isset($pay_gateway) && $pay_gateway == 'Paypal')
			{
				$txn_id = isset($_REQUEST['txn_id']) ? $_REQUEST['txn_id'] :'';
				$payment_gross =  isset($_REQUEST['payment_gross']) ? $_REQUEST['payment_gross'] :'';
				$currency_code = isset($_REQUEST['mc_currency']) ? $_REQUEST['mc_currency'] :'';
				$payment_status = isset($_REQUEST['payment_status']) ? $_REQUEST['payment_status'] :'';

				if($txn_id!='' && $payment_status!='')
				{
					$status = "success";
				}else{
					$status = "fail";
				}
			}

			if(isset($pay_gateway) && $pay_gateway == 'CCAvenue')
			{
				include('Crypto.php');
				$ccavenue = $this->common_model->get_count_data_manual('payment_method'," name = 'CCAvenue' ",1,'*','','','',"");
				$encResp=$_REQUEST['encResp'];
                $working_key=$ccavenue['key'];
                $decryptValues=explode('&',decrypt($encResp,$working_key));
                $dataSize=sizeof($decryptValues);

				for($i = 0; $i < $dataSize; $i++)
				{
					$information=explode('=',$decryptValues[$i]);
					if($information[0] == 'order_status')
					{
					   $order_status = $information[1];
					}
				}

				if($order_status == 'Success')
				{
					$status = "success";
				}else{
					$status = "fail";
				}
			}

			if(isset($pay_gateway) && $pay_gateway == 'PayUbizz')
			{
				$mihpayid = $this->input->post('mihpayid');
				$txnid = $this->input->post('txnid');
				$PayUbizz_status = $this->input->post('status');
				if(isset($txnid) && $txnid != '' && isset($PayUbizz_status) && $PayUbizz_status == 'success'){
					$status = "success";
				}else{
					$status = "fail";
				}
			}

			if(isset($pay_gateway) && $pay_gateway == 'PayUMoney')
			{
				$PayUMoney_status= $this->input->post('status');
				if($PayUMoney_status == 'success')
				{
					$txnid = $this->input->post('txnid');
					$amount = $this->input->post('amount');
					$productinfo = $this->input->post('productinfo');
					$firstname = $this->input->post('firstname');
					$hash = $this->input->post('hash');
					$email = $this->input->post('email');
					$key = $this->input->post('key');

					$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','','');

					$SALT =$payumoney['salt_access_code'];

					$add = $this->input->post('additionalCharges');
					if(isset($add)) {
						$additionalCharges = $this->input->post('additionalCharges');
						$retHashSeq = $additionalCharges . '|' . $SALT . '|' . $PayUMoney_status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
					} else {
						$retHashSeq = $SALT . '|' . $PayUMoney_status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
					}

					$rethash = hash("sha512", $retHashSeq);

					if($rethash === $hash)
					{
						$status = "success";
					}else{
						$status = "fail";
					}
				}
			}
			// if(isset($pay_gateway) && $pay_gateway == 'PayUMoney')
			// 	{
			// 	$PayUMoney_status= $this->input->post('status');
			// 	if($PayUMoney_status == 'success')
			// 	{
			// 	$txnid = $this->input->post('txnid');
			// 	$amount = $this->input->post('amount');
			// 	$productinfo = $this->input->post('productinfo');
			// 	$firstname = $this->input->post('firstname');
			// 	$hash = $this->input->post('hash');
			// 	$email = $this->input->post('email');
			// 	$key = $this->input->post('key');

			// 	$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','','');

			// 	$SALT =$payumoney['salt_access_code'];

			// 	if(isset($_POST["additionalCharges"]))
			// 	{
			// 	$additionalCharges=$_POST["additionalCharges"];
			// 	$retHashSeq = $additionalCharges.'|'.$SALT . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
			// 	}else{
			// 	$retHashSeq = $SALT . '|' . $status . '||||||||||||||||'. $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
			// 	}

			// 	$rethash = hash("sha512", $retHashSeq);

			// 	if($rethash === $hash)
			// 	{
			// 	$status = "success";
			// 	}else{
			// 	$status = "fail";
			// 	}
			// 	}
			// 	}
			if(isset($pay_gateway) && $pay_gateway == 'RazorPay'){
				$firstname   = $this->input->post('firstname');
				$amount      = $this->input->post('merchant_total');
				$txnid       = $this->input->post('txnid');
				$posted_hash = $this->input->post('hash');
				$productinfo = $this->input->post('productinfo');
				$email       = $this->input->post('email');
				$status = "success";

			}

			if(isset($pay_gateway) && $pay_gateway == 'Instamojo')
			{
				if(isset($_REQUEST['payment_request_id']) && $_REQUEST['payment_request_id'] !='' && isset($_REQUEST['payment_id']) && $_REQUEST['payment_id'] !='')
				{
					$payment_request_id = $_REQUEST['payment_request_id'];
					$payment_id = $_REQUEST['payment_id'];
					include_once('instamojo/Instamojo.php');

					$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");

					$API_KEY = $instamojo['key'];
					$AUTH_TOKEN = $instamojo['salt_access_code'];

					$api = new instamojo\Instamojo($API_KEY, $AUTH_TOKEN);

					try
					{
						$response = $api->paymentRequestStatus($payment_request_id);
						if(isset($response) && $response !='' && count($response) > 0)
						{
							$status = $response['payments'][0]['status'];
							$amount = $response['payments'][0]['amount'];

							if($status == 'Credit')
							{
								$status = 'success';
							}
							else
							{
								$status = 'fail';
							}
						}
					}
					catch (Exception $e)
					{
						$status = 'fail';
					}
				}
				else
				{
					$status = 'fail';
				}
			}

			 ##Phonepe check status start 05/09/2023
			 if(isset($pay_gateway) && $pay_gateway == 'PhonePe')
			 {
					 $payment_status = isset($_REQUEST['code']) ? $_REQUEST['code'] :'';
					 if($payment_status !='' &&  $payment_status == 'PAYMENT_SUCCESS')
					 {
						 $status = "success";
					 }else{
						 $status = "fail";
					 }
			 }
			  ##Phonepe check status End 

			## stripe Payemnt Getway start 18/07/2025 
			if(isset($pay_gateway) && $pay_gateway == 'Stripe')
			{
				$status = 'fail';
				$paystatus = $this->session->flashdata('payment_status');
				if ($paystatus === 'success') {
					$status = 'success';
				} else{
					$status = 'fail';
				}
			}

			if(isset($status) && $status == 'success')
			{
				$_REQUEST['payment_method'] = $pay_gateway;
				if(isset($current_login_user['id']) && $current_login_user['id'] != '' && $current_login_user['id'] > 0){
					$user_id = $current_login_user['id'];
				}
				if(isset($insert_id) && $insert_id != '' && $insert_id > 0){
					$this->load->model("front_end/register_model");
					$this->register_model->set_login_register_user();
					$user_id = $insert_id;
				}

				$plan_details = $this->session->userdata('plan_data_session')['plan_data_array'];
				$plan_id = $plan_details['id'];

				if(isset($plan_id) && $plan_id != '' && isset($user_id) && $user_id!='')
				{
					$data_return = $this->common_model->update_plan_member($user_id,$plan_id);
					if($data_return == 'success')
					{

					// update plan status after payment done
						$row_data_cu = $this->session->userdata('mega_user_data');
						$row_data_cu['plan_status'] = 'Paid';
						$row_data_cu['plan_chat'] = $this->common_front_model->get_plan_detail($row_data_cu['matri_id'],'chat','Yes');
						$this->session->set_userdata('mega_user_data', $row_data_cu);
						// update plan status after payment done

						$this->session->unset_userdata('plan_data_session');
					}
				}
				$this->data['base_url'] = $this->base_url;
				$this->data['status'] = $status;

				$this->common_model->front_load_header('Payment Success');
				$this->load->view('front_end/payment_success',$this->data);
				$this->common_model->front_load_footer();
			}
			else
			{
				$this->data['base_url'] = $this->base_url;
				$this->data['status'] = $status;

				$this->common_model->front_load_header('Payment Fail');
				$this->load->view('front_end/payment_fail',$this->data);
				$this->common_model->front_load_footer();
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}
	/*private function get_curl_handle($payment_id, $amount)  {
        $url = 'https://api.razorpay.com/v1/payments/'.$payment_id.'/capture';
		$RazorPay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");
        $key_id = $RazorPay['key'];
        $key_secret = $RazorPay['salt_access_code'];
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id.':'.$key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
       // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__).'/ca-bundle.crt');
        return $ch;
    }*/

	public function ccav_request_handler()
	{
		$this->data['plan_data'] = $this->session->userdata('plan_data_session');
		$this->load->view('front_end/ccavRequestHandler',$this->data);
	}

	public function payubizz()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$this->data['get_user_data'] = '';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,firstname,address,mobile,email');
			}

			if(isset($this->data['get_user_data']) && $this->data['get_user_data']==''){
				if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0){
					$this->data['get_user_data'] = $current_login_user;
				}
			}

			$this->data['plan_data'] = $this->session->userdata('plan_data_session');
			$this->load->view('front_end/payubizz',$this->data);
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}

	public function payumoney()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();

		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$get_user_data='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$get_user_data = $current_login_user;
			}
			$plan_data = $this->session->userdata('plan_data_session');
			$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','',"");

			if(isset($payumoney) && $payumoney!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){

				$this->data['get_user_data']=$get_user_data;
				$this->data['payumoney']=$payumoney;
				$this->data['plan_data']=$plan_data;
				$this->load->view('front_end/payumoney',$this->data);

			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}

	public function razorpay()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$get_user_data='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$get_user_data = $current_login_user;
			}
			$plan_data = $this->session->userdata('plan_data_session');
			$razorpay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");

			if(isset($razorpay) && $razorpay!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){
				$this->data['get_user_data'] = $get_user_data;
				$this->data['razorpay'] = $razorpay;
				$this->data['plan_data'] = $plan_data;
				$this->load->view('front_end/razorpay',$this->data);

			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}

	public function razorpay_app()
	{
		$current_login_user = '';
		if($this->input->post('user_id')!=''){
			$current_login_user = $this->input->post('user_id');
		}

		$plan_id = '';
		if($this->input->post('plan_id')!=''){
			$plan_id = $this->input->post('plan_id');
		}

		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0)
		{
			$get_user_data='';

			$where_arra=array('id'=>$current_login_user);

			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0){
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			$plan_data = $this->common_model->get_count_data_manual('membership_plan',array('id'=>$plan_id),1,'*');
			$razorpay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");

			if(isset($razorpay) && $razorpay!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){
				$this->data['user_agent'] = 'NI-AAPP';
				$plan_data['total_pay'] = $this->input->post('total_pay');
				$this->data['get_user_data'] = $get_user_data;
				$this->data['razorpay'] = $razorpay;
				$this->data['plan_data'] = $plan_data;

				$this->load->view('front_end/razorpay',$this->data);

			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}

	public function instamojo()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$get_user_data='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$get_user_data = $current_login_user;
			}
			$plan_data = $this->session->userdata('plan_data_session');
			$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");
			
			if(isset($plan_data) && $plan_data!= '' && isset($instamojo) && $instamojo!= '' && isset($get_user_data) && $get_user_data!= '' ){

				$this->data['get_user_data']=$get_user_data;
				$this->data['plan_data']=$plan_data;
				$this->data['instamojo']=$instamojo;
				$this->load->view('front_end/instamojo',$this->data);

			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}

	public function payment_process_mobile_app($user_id='',$payment_method='',$plan_id='',$total_pay='')
	{
		if(isset($user_id) && $user_id!='' && isset($payment_method) && $payment_method!='' && isset($plan_id) && $plan_id!='' && isset($total_pay) && $total_pay!='')
		{
			echo '<center><strong>Please wait while redirecting to payment gateway...</strong></center>';
			$where_96 = array('id'=>$plan_id);
            $plan_data = $this->common_model->get_count_data_manual('membership_plan',$where_96,1,'plan_name,plan_amount_type','','','','',"");
			$plan_name = $plan_data['plan_name'];
			$plan_amount_type = $plan_data['plan_amount_type'];
			

			if(isset($payment_method) && $payment_method == 'Paypal')
			{
				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','Paypal');

				$where_arra = array('name'=>'Paypal');
				$payment_method_data = $this->common_model->get_count_data_manual('payment_method',$where_arra,1,'*','','','',"");

				$this->data['payment_method'] = $payment_method;

				$this->data['action'] = "https://www.paypal.com/cgi-bin/webscr";
				if(base_url() =='http://192.168.1.111/mega_matrimony/original_script/')
				{
					$this->data['action'] = "https://www.sandbox.paypal.com/cgi-bin/webscr";
				}
				if($plan_amount_type=='INR')
				{
				$total_pay=$total_pay/73;
				}

				$business = $payment_method_data['email_merchant_id'];
				$cmd="_xclick";
				$item_name="Membership Plan ".$total_pay." Purchase";
				$item_number=1;
				$credits=510;
				$userid=1;
				$amount=$total_pay;
				$no_shipping=1;
				$currency_code="USD";
				$handling=0;
				$return=$this->base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
				$cancel_return=$this->base_url.'premium-member/payment-fail-mobile-app';

				$_POST['business'] = $business;
				$_POST['cmd'] = $cmd;
				$_POST['item_name'] = $item_name;
				$_POST['item_number'] = $item_number;
				$_POST['credits'] = $credits;
				$_POST['userid'] = $userid;
				$_POST['amount'] = $amount;
				$_POST['no_shipping'] = $no_shipping;
				$_POST['currency_code'] = $currency_code;
				$_POST['handling'] = $handling;
				$_POST['return'] = $return;
				$_POST['cancel_return'] = $cancel_return;

				$this->load->view('front_end/payment_mobile_app',$this->data);

			}elseif(isset($payment_method) && $payment_method == 'Paybizz'){

				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','PayUbizz');

				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');

				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAPP';
				$this->data['user_id'] = $user_id;

				$this->load->view('front_end/payubizz',$this->data);
			}elseif(isset($payment_method) && $payment_method == 'RazorPay'){
				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','RazorPay');

				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');

				$this->data['razorpay'] = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','','');

				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;

				$this->load->view('front_end/razorpay_app',$this->data);
			}elseif(isset($payment_method) && $payment_method == 'PayUmoney'){

				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','PayUmoney');

				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');

				$this->data['payumoney'] = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','','');

				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;

				$this->load->view('front_end/payumoney',$this->data);

			}
			elseif(isset($payment_method) && $payment_method == 'CCAvenue'){

				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','CCAvenue');

				$where_arra = array('name'=>'CCAvenue');
				$payment_method_data = $this->common_model->get_count_data_manual('payment_method',$where_arra,1,'*','','','',"");

				$where_arra=array('id'=>$user_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');

				$cust_number='';
				if($get_user_data['mobile'] !='')
				{
					$mo_arr = explode('-',$get_user_data['mobile']);
					$cust_number = $mo_arr[1];
				}

				$merchant_id = $payment_method_data['email_merchant_id'];
				$order_id = $user_id.'-'.$plan_id;
				$currency = "INR";
				$language = "EN";
				$billing_name = $get_user_data['username'];
				$billing_address = $get_user_data['address'];
				$billing_state = "";
				$billing_zip = "";
				$billing_country = "";
				$billing_tel = $cust_number;
				$billing_email = $get_user_data['email'];
				$udf1 = $plan_name;
				$udf2 = $plan_id;
				$redirect_url=$this->base_url.'premium-member/payment-success-ccavenue-mobile_app/'.$user_id.'/'.$plan_id;
				$cancel_url=$this->base_url.'premium-member/payment-fail-mobile-app';

				$_POST['merchant_id'] = $merchant_id;
				$_POST['order_id'] = $order_id;
				$_POST['currency'] = $currency;
				$_POST['language'] = $language;
				$_POST['billing_name'] = $billing_name;
				$_POST['billing_address'] = $billing_address;
				$_POST['billing_state'] = $billing_state;
				$_POST['billing_zip'] = $billing_zip;
				$_POST['billing_country'] = $billing_country;
				$_POST['billing_tel'] = $billing_tel;
				$_POST['billing_email'] = $billing_email;
				$_POST['udf1'] = $udf1;
				$_POST['udf2'] = $udf2;
				$_POST['redirect_url'] = $redirect_url;
				$_POST['cancel_url'] = $cancel_url;

				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';

				$this->load->view('front_end/ccavRequestHandler',$this->data);

			}elseif(isset($payment_method) && $payment_method == 'Instamojo'){

				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','Instamojo');

				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');

				$this->data['instamojo'] = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','','');

				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;

				$this->load->view('front_end/instamojo',$this->data);

			}elseif(isset($payment_method) && $payment_method == 'PhonePe'){

			
				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','PhonePe');
				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
				$this->data['phonepe'] = $this->common_model->get_count_data_manual('payment_method'," name = 'PhonePe' ",1,'*','','','','');
				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay);
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;
				$this->load->view('front_end/phonepe',$this->data);

			}
			elseif(isset($payment_method) && $payment_method == 'Stripe'){
				$this->session->unset_userdata('payment_method');
				$this->session->set_userdata('payment_method','Stripe');
				$where_arra=array('id'=>$user_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
				$this->data['stripe'] = $this->common_model->get_count_data_manual('payment_method'," name = 'Stripe' ",1,'*','','','','');
				$plan_array = array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay,'plan_amount_type'=>$plan_amount_type);
				// print_r($plan_array);exit;
				$this->data['plan_data'] = $plan_array;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;
				$this->load->view('front_end/stripe_checkout',$this->data);
			}else{
				redirect($this->base_url.'premium-member/payment-fail-mobile-app');
				exit;
			}
		}
		else
		{
			redirect($this->base_url.'premium-member/payment-fail-mobile-app');
			exit;
		}
	}
	public function payment_success_mobile_app_redirect()
	{
		echo "Payment Done.!!!";
	}
	public function payment_success_mobile_app($user_id='',$plan_id='')
	{		
		ob_start();	
		if(isset($user_id) && $user_id!='' && isset($plan_id) && $plan_id!='')
		{
			$pay_gateway = $this->session->userdata('payment_method');
			$_REQUEST['payment_method'] = $pay_gateway;
			$data_return = $this->common_model->update_plan_member($user_id,$plan_id);

			$this->session->unset_userdata('payment_method');
			redirect($this->base_url.'premium-member/payment_success_mobile_app_redirect');
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
		ob_end_flush();
	}
	public function payment_fail_mobile_app_redirect()
	{
		echo "Payment Failed.!!!";
	}
	public function payment_fail_mobile_app()
	{
		redirect($this->base_url.'premium-member/payment_fail_mobile_app_redirect');
	}
	public function payment_success_instamojo_mobile_app($user_id='',$plan_id='')
	{
		if(isset($_REQUEST['payment_request_id']) && $_REQUEST['payment_request_id'] !='' && isset($_REQUEST['payment_id']) && $_REQUEST['payment_id'] !='')
		{
			$payment_request_id = $_REQUEST['payment_request_id'];
			$payment_id = $_REQUEST['payment_id'];
			include_once('instamojo/Instamojo.php');

			$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");
			$API_KEY = $instamojo['key'];
			$AUTH_TOKEN = $instamojo['salt_access_code'];

			$api = new instamojo\Instamojo($API_KEY, $AUTH_TOKEN);

			try
			{
				$response = $api->paymentRequestStatus($payment_request_id);
				if(isset($response) && $response !='' && count($response) > 0)
				{
					$status = $response['payments'][0]['status'];
					$amount = $response['payments'][0]['amount'];

					if($status == 'Credit')
					{
						$this->payment_success_mobile_app($user_id,$plan_id);
					}
					else
					{
						$this->payment_fail_mobile_app();
					}
				}
			}
			catch (Exception $e)
			{
				$this->payment_fail_mobile_app();
			}
		}
		else
		{
			$this->payment_fail_mobile_app();
		}
	}

	public function payment_success_ccavenue_mobile_app($user_id='',$plan_id='')
	{
		ob_start();
		include('Crypto.php');
		$ccavenue = $this->common_model->get_count_data_manual('payment_method'," name = 'CCAvenue' ",1,'*','','','',"");
		$encResp=$_REQUEST['encResp'];
		$working_key=$ccavenue['key'];
		$decryptValues=explode('&',decrypt($encResp,$working_key));
		$dataSize=sizeof($decryptValues);

		for($i = 0; $i < $dataSize; $i++)
		{
			$information=explode('=',$decryptValues[$i]);
			if($information[0] == 'order_status')
			{
			$order_status = $information[1];
			}
		}
		if($order_status == 'Success')
		{
			redirect(base_url('premium-member/payment_success_mobile_app/'.$user_id.'/'.$plan_id));
		}else{
			redirect('premium-member/payment_fail_mobile_app');
		}
		ob_end_flush();

	}
	## Phonepe Payemnt Getway start 05/09/2023 
    public function phonePe(){

		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$get_user_data='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$get_user_data = $current_login_user;
			}
			$plan_data = $this->session->userdata('plan_data_session');
			$phonepe = $this->common_model->get_count_data_manual('payment_method'," name = 'PhonePe' ",1,'*','','','',"");

			if(isset($phonepe) && $phonepe!='' && isset($plan_data) && $plan_data!= ''){
				$this->data['get_user_data']=$get_user_data;
				$this->data['phonepe']=$phonepe;
				$this->data['plan_data']=$plan_data;
				$this->load->view('front_end/phonepe',$this->data);
			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}
	
	public function phonePeMobile(){
        
		$insert_id = $_POST['user_id'];
		$plan_id = $_POST['plan_id'];
		$total_pay = $_POST['amount'];
		$where_arra=array('id'=>$insert_id);
		$current_login_user = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
// 		$current_login_user = $this->common_front_model->get_session_data();
	
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			$get_user_data='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$get_user_data = $current_login_user;
			}
			$where_arra=array('id'=>$plan_id);
			$plan_data = $this->common_model->get_count_data_manual('membership_plan',$where_arra,1,'*');
				$plan_data = array_merge($plan_data,array('plan_id'=>$plan_id,'plan_name'=>$plan_name,'total_pay'=>$total_pay));
// 			$plan_data = $this->session->userdata('plan_data_session');
			
				// print_r($plan_data);exit;
			$phonepe = $this->common_model->get_count_data_manual('payment_method'," name = 'PhonePe' ",1,'*','','','',"");

			if(isset($phonepe) && $phonepe!='' && isset($plan_data) && $plan_data!= ''){
				$this->data['get_user_data'] = $get_user_data;
				$this->data['phonepe'] = $phonepe;
				$this->data['plan_data'] = $plan_data;
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $insert_id;
				// echo $this->data['user_id'];exit;
				$this->load->view('front_end/phonepe',$this->data);
			}else{
				redirect($this->base_url.'premium-member');
				exit;
			}
		}else{
			redirect($this->base_url.'premium-member');
			exit;
		}
	}
	public function payment_success_phonepe_app($user_id='',$plan_id='')
	{
		$payment_status = isset($_REQUEST['code']) ? $_REQUEST['code'] :'';
		if($payment_status !='' &&  $payment_status == 'PAYMENT_SUCCESS')
		{
				if(isset($user_id) && $user_id!='' && isset($plan_id) && $plan_id!='')
				{
					$pay_gateway = $this->session->userdata('payment_method');
					$_REQUEST['payment_method'] = $pay_gateway;
					$data_return = $this->common_model->update_plan_member($user_id,$plan_id);

					$this->session->unset_userdata('payment_method');
					redirect($this->base_url.'premium-member/payment_success_mobile_app_redirect');
				}else{
					redirect($this->base_url.'premium-member');
					exit;
				}
		}else{
			redirect($this->base_url.'premium-member/payment_fail_mobile_app_redirect');
		}
	}
	 ##Phonepe Payemnt Getway End
	 
	public function success_mobile_app()
	{
		$user_id=$this->input->post('user_id');
		$plan_id=$this->input->post('plan_id');
		$offer_id=$this->input->post('offer_id');
		$offer_used=$this->input->post('offer_used');
		if($offer_id==''){
			$offer_id = '0';
		}
		if($offer_used==''){
			$offer_used = 'No';
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		if(isset($user_id) && $user_id!='' && isset($plan_id) && $plan_id!=''){
			$data_return = $this->common_model->update_plan_member($user_id,$plan_id,$offer_id,$offer_used);
			$data1['status'] = 'success';
			$data1['errormessage'] = 'Payment Done.';
		}else{
			$data1['status'] = 'error';
			$data1['errormessage'] = 'Payment Failed.';
		}
		$this->output->set_content_type('application/json');
		$data['data'] = $this->output->set_output(json_encode($data1));
	}
	 
	
	public function payment_success_stripe_mobile_appss($user_id='',$plan_id='')
	{
		if(isset($user_id) && $user_id != '' && isset($plan_id) && $plan_id != '')
			{
				$charge_stripe = $this->session->userdata('stripe_response');
				$this->session->unset_userdata('stripe_response');
				if($charge_stripe == 'stripe_success'){ 
				    $this->payment_success_mobile_app($user_id,$plan_id);
				}else{
				    $this->payment_fail_mobile_app();
				}
			}
		else
		{
			$this->payment_fail_mobile_app();
		}
	}

	## stripe Payemnt Getway start 18/07/2025 
	public function payment_success_stripe_app($user_id = '', $plan_id = '')
	{
		$payment_status = $this->session->flashdata('payment_status');

		if ($payment_status != '' &&  $payment_status == 'success') {
			if (isset($user_id) && $user_id != '' && isset($plan_id) && $plan_id != '') {
				$pay_gateway = $this->session->userdata('payment_method');
				$_REQUEST['payment_method'] = $pay_gateway;
				$data_return = $this->common_model->update_plan_member($user_id, $plan_id);

				$this->session->unset_userdata('payment_method');
				redirect($this->base_url . 'premium-member/payment_success_mobile_app_redirect');
			} else {
				redirect($this->base_url . 'premium-member');
				exit;
			}
		} else {
			redirect($this->base_url . 'premium-member/payment_fail_mobile_app_redirect');
		}
	}
	## stripe Payemnt Getway start 18/07/2025 
	public function stripe()
	{

		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		if ((isset($current_login_user) && $current_login_user != '' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0)) {
			$get_user_data = '';
			if (isset($insert_id) && $insert_id != '' && $insert_id > 0) {
				$where_arra = array('id' => $insert_id);
				$get_user_data = $this->common_model->get_count_data_manual('register', $where_arra, 1, 'id,matri_id,username,address,mobile,email');
			}
			if (isset($current_login_user) && $current_login_user != '' && $current_login_user > 0) {
				$get_user_data = $current_login_user;
			}
			$plan_data = $this->session->userdata('plan_data_session');
			$stripe = $this->common_model->get_count_data_manual('payment_method', " name = 'Stripe' ", 1, '*', '', '', '', "");
			if (isset($stripe) && $stripe != '' && isset($plan_data) && $plan_data != '') {
				$this->data['get_user_data'] = $get_user_data;
				$this->data['stripe'] = $stripe;
				$this->data['plan_data'] = $plan_data;
				$this->load->view('front_end/stripe_checkout', $this->data);
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
	public function stripe_response($user_id = '', $plan_id = '', $user_agent = '')
	{
		$session_id = $this->input->get('session_id');
		if (isset($user_agent) && $user_agent != '' && $user_agent == 'NI-AAPP') {
			$redirect_url = $this->base_url . 'premium-member/payment-success-stripe-app/' . $user_id . '/' . $plan_id;
		} else {
			$redirect_url = $this->base_url . 'premium-member/payment-status/Stripe';
		}

		if (!$session_id) {
			redirect($redirect_url);
			exit;
		}
		if ($this->session->userdata('stripe_handled_' . $session_id)) {
			redirect($redirect_url);
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
		redirect($redirect_url);
		exit;
	}

	## stripe Payemnt Getway start 18/07/2025 
	public function payment_cancel_stripe()
	{
		redirect($this->base_url . 'premium-member');
		exit;
	}
  
}