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
		$this->common_model->extra_css_fr= array('css/fontello.css');
		
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Upgrade'),1,'*','','');
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
		$this->common_model->front_load_header('Premium Member','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		
		$where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
		$membership_plan_data_count = $this->common_model->get_count_data_manual('membership_plan',$where_arra,0,'id');
		$membership_plan_data = $this->common_model->get_count_data_manual('membership_plan',$where_arra,2,'*','id asc');
		$membership_plans['membership_plan_data_count']= $membership_plan_data_count;
		$membership_plans['membership_plans']= $membership_plan_data;
		
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
		if($this->input->post('user_agent')=='NI-IOS')
		{
			$where_arra=array('is_deleted'=>'No','status'=>'APPROVED',"in_app_product_id!=''");
		}
		else
		{
			$where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
		}
		$membership_plan_data = $this->common_model->get_count_data_manual('membership_plan',$where_arra,2,'*','id asc');
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		if(isset($membership_plan_data) && $membership_plan_data !='' && count($membership_plan_data) > 0)
		{
			$data1['status'] = 'success';
			$data1['plan_data'] = $membership_plan_data;
		}
		else
		{
			$data1['status'] = 'error';
			$data1['plan_data'] = "Sorry, Currently no any plan available";
		}
		$this->output->set_content_type('application/json');
		$data['data'] = $this->output->set_output(json_encode($data1));
	}
	public function buy_now($id='')
	{	
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();
		
		if((isset($current_login_user) && $current_login_user!='' && $current_login_user > 0) || (isset($insert_id) && $insert_id != '' && $insert_id > 0))
		{
			if($id !='')
			{
				$this->common_model->extra_css_fr= array('css/fontello.css');
				$this->common_model->extra_js_fr= array('js/chosen.jquery.js');
				$this->common_model->css_extra_code_fr.='.box-center {width: 37%;}
				
					.line-dot ul li {background-image: url()!important;}
					';
				$this->common_model->front_load_header('Buy Now');
				$where_membership_plan = " (id ='".$id."')";
				$membership_plan_arr = $this->common_model->get_count_data_manual('membership_plan',$where_membership_plan,1,'*','','','',"");
				
				if(isset($membership_plan_arr['plan_amount']) && $membership_plan_arr['plan_amount'] > 0){
					if(isset($membership_plan_arr) && $membership_plan_arr!='' && $membership_plan_arr > 0)
					{
						$plan_data['plan_data']= $membership_plan_arr;
						$this->load->view('front_end/buy_now',$plan_data);
						$this->common_model->front_load_footer();
					}
					else
					{
						redirect($this->common_model->base_url.'premium_member');
					}
				}else{
					$this->session->set_flashdata('message_for_user', 'Please contact to admin for free plans...!!!!!');
					redirect($this->common_model->base_url.'contact/admin');
				}	
			}
			else
			{
				redirect($this->common_model->base_url.'premium_member');
			}
		}
		else
		{
			$this->session->set_userdata('plan_id',$id);
			redirect($this->common_model->base_url.'login');
		}
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
					$data_return['message'] = $this->load->view('front_end/buy_now',$this->data,true);
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
		$data['data'] = json_encode($data_return);
		$this->load->view('common_file_echo',$data);
	}
	public function payment_option()
	{	
		if($this->session->userdata('plan_data_session'))
		{
			$this->common_model->extra_css_fr= array('css/fontello.css');
			$this->common_model->extra_js_fr= array('js/chosen.jquery.js');
			$this->data['base_url'] = $this->base_url;
			$this->data['plan_data'] = $this->session->userdata('plan_data_session');
			$this->common_model->css_extra_code_fr.='
		.box-center {
			width: 69%;
			margin: 0 auto;
			display: table;
		}
		@media only screen and (max-device-width: 480px) and (min-device-width: 320px){
		.box-center {
			width: 79% !important;
			margin: 0 30px;
		}
		}
		.cstm-logo{
			padding: 0px 0px !important;
			position: relative!important;
			top: -6px!important;
			}
		';
			$where_payment_methods = " (status ='APPROVED')";
			$this->data['payment_methods'] = $this->common_model->get_count_data_manual('payment_method',$where_payment_methods,2,'*','','','',"");
			$this->common_model->front_load_header('Payment Option');
			$this->load->view('front_end/buy_now',$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			redirect($this->base_url.'premium_member');
			exit;
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
				left:0px;
				top:160px !important;
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
				}";
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
				$item_number = isset($_REQUEST['item_number']) ? $_REQUEST['item_number'] :''; 
				$txn_id = isset($_REQUEST['tx']) ? $_REQUEST['tx'] :'';
				$payment_gross =  isset($_REQUEST['amt']) ? $_REQUEST['amt'] :'';
				$currency_code = isset($_REQUEST['cc']) ? $_REQUEST['cc'] :'';
				$payment_status = isset($_REQUEST['st']) ? $_REQUEST['st'] :'';
				
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
					//$status = 'fail';
				}
				else
				{
					$status = 'fail';
				}
			}
			
			if(isset($status) && $status == 'success')
			{
				$_REQUEST['payment_method'] = $pay_gateway;
				if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0){
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
			$this->data['get_user_data']='';
			if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
			{
				$where_arra=array('id'=>$insert_id);
				$this->data['get_user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			}
			
			if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
			{
				$this->data['get_user_data'] = $current_login_user;
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
              $plan_data = $this->common_model->get_count_data_manual('membership_plan',$where_96,1,'plan_name','','','',"");

              $plan_name = $plan_data['plan_name'];
             // echo $plan_name; exit;
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
				$this->data['user_agent'] = 'NI-AAP';
				$this->data['user_id'] = $user_id;
				
				$this->load->view('front_end/payubizz',$this->data);
				
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
				
			}elseif(isset($payment_method) && $payment_method == 'CCAvenue'){
				
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
				$redirect_url=$this->base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
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
	public function payment_success_mobile_app_redirect()
	{
		echo "Payment Done.!!!";
	}
	public function payment_success_mobile_app($user_id='',$plan_id='') 
	{
		$pay_gateway = $this->session->userdata('payment_method');
		if(isset($user_id) && $user_id!='' && isset($plan_id) && $plan_id != '' && isset($pay_gateway) && $pay_gateway != '')
		{
			$status = "fail";
			if(isset($pay_gateway) && $pay_gateway == 'Paypal')
			{
				$item_number = isset($_REQUEST['item_number']) ? $_REQUEST['item_number'] :''; 
				$txn_id = isset($_REQUEST['tx']) ? $_REQUEST['tx'] :'';
				$payment_gross =  isset($_REQUEST['amt']) ? $_REQUEST['amt'] :'';
				$currency_code = isset($_REQUEST['cc']) ? $_REQUEST['cc'] :'';
				$payment_status = isset($_REQUEST['st']) ? $_REQUEST['st'] :'';
				
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
					//$status = 'fail';
				}
				else
				{
					$status = 'fail';
				}
			}
			
			if(isset($status) && $status == 'success')
			{
				$_REQUEST['payment_method'] = $pay_gateway;
				
				$this->data['base_url'] = $this->base_url;
				$this->data['status'] = $status;
				
				
				$_REQUEST['payment_method'] = $pay_gateway;
				$data_return = $this->common_model->update_plan_member($user_id,$plan_id);
				
				$this->session->unset_userdata('payment_method');
				redirect($this->base_url.'premium-member/payment_success_mobile_app_redirect');
			}
			else
			{
				redirect($this->base_url.'premium-member/payment_fail_mobile_app_redirect');
			}
		}
		else{
			redirect($this->base_url.'premium-member');
			exit;
		}
		
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
			//$status = 'fail';
		}
		else
		{
			$this->payment_fail_mobile_app();
		}
	}
	
	
	
	
}