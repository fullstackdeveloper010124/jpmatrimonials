<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Event extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/event_model');
		$this->common_front_model->last_member_activity();
	}
	public function index($page=1)
	{	
		$data['base_url']=$this->data['base_url'];
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		$this->common_model->limit_per_page = '8';
		$today = $this->common_model->getCurrentDate('Y-m-d');
		$where_arra=array('event_date>='=>$today,'is_deleted'=>'No','status'=>'APPROVED');
		$this->data['events_data_count'] = $this->common_model->get_count_data_manual('events',$where_arra,0,'id');
		$this->data['events'] = $this->common_model->get_count_data_manual('events',$where_arra,2,'*','id desc',$page,'','');
		if($is_ajax == 0)
		{	
			$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Event'),1,'*','','');
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
			$this->common_model->front_load_header('Events','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
			$this->load->view('front_end/event',$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{	
			$this->load->view('front_end/event_list_ajax',$this->data);
		}
	}
	
	public function details($id='')
	{	
		if($id !='')
		{
			$base_url = $this->data['base_url'];
			$this->common_model->extra_css_fr= array('css/owl.carousel.css');
			$this->common_model->extra_js_fr= array ('js/owl.carousel.min.js','js/slider.js','js/jquery.gmaps.min.js');
			$this->common_model->js_extra_code_fr .= "
				$(document).ready(function(){
					$('#testimonial-slider12').owlCarousel({
						items:1,
						itemsDesktop:[1000,1],
						itemsDesktopSmall:[979,1],
						itemsTablet:[768,1],
						pagination:false,
						navigation:false,
						navigationText:['',''],
						autoPlay :3000,
						stopOnHover :true,
						dots:false
					});
				});
				";
			$where_event = " (id ='".$id."')";
			$event_arr = $this->common_model->get_count_data_manual('events',$where_event,1,'*','','','',"");
			if(isset($event_arr) && $event_arr!='' && $event_arr > 0)
			{
				$event_data['event_item']= $event_arr;
				$this->common_model->front_load_header('Event Details');
				$this->load->view('front_end/event_details',$event_data);
				$this->common_model->front_load_footer();
			}
			else
			{
				redirect($this->common_model->base_url.'event');
			}
		}
		else
		{
			redirect($this->common_model->base_url.'event');
		}
	}
	public function checkout()
	{	
		if($this->session->userdata('event_data_session'))
		{	
			$event_array = array();
			$base_url = $this->data['base_url'];
			$event_array = $this->session->userdata('event_data_session');
			if($this->input->post('no_of_ticket'))
			{
				$no_of_ticket = $this->input->post('no_of_ticket');
				$event_array['no_of_ticket']=$no_of_ticket;
				$this->data['no_of_ticket'] = $no_of_ticket;
			}else{
				$this->data['no_of_ticket'] = 1;
			}
			
			$this->session->set_userdata('event_data_session',$event_array);
			$this->data['event_data'] = $event_array;
			
			$this->common_model->display_top_menu_perm = 'No';
			$this->common_model->extra_js_fr= array ('js/jquery.validate.min.js','js/additional-methods.min.js');
			$this->common_model->front_load_header('Event Checkout');
			$this->load->view('front_end/event_checkout',$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			redirect($this->base_url.'event');
			exit;
		}
	}
	
	public function pay_now()
	{		
		if($this->session->userdata('event_data_session'))
		{	
			$base_url = $this->data['base_url'];
			$where_payment_methods = " (status ='APPROVED')";
			$this->data['payment_methods'] = $this->common_model->get_count_data_manual('payment_method',$where_payment_methods,2,'*','','','',"");
			$event_array = array();
			$event_array = $this->session->userdata('event_data_session');
			foreach($this->input->post() as $key => $row){
				$event_array[$key] = $row;
			}
			$this->session->set_userdata('event_data_session',$event_array);
			$this->data['event_data'] = $event_array;
			
			$this->common_model->display_top_menu_perm = 'No';

			if(!isset($event_array['total_amount']))
			{
				$response = $this->event_model->save_event($status='');
				$this->event_model->send_mail();
				
				$this->data['base_url'] = $this->base_url;
				$this->data['success'] = $this->session->flashdata('success_message');
				
				$this->common_model->front_load_header('Event Registration Success');
				$this->load->view('front_end/payment_success_event',$this->data);
				$this->common_model->front_load_footer();
				
				$this->session->unset_userdata('event_data_session');
			}
			else
			{
				$this->common_model->front_load_header('Payment Option');
				$this->load->view('front_end/payment_option_event',$this->data);
				$this->common_model->front_load_footer();
			}
		}
		else
		{
			redirect($this->base_url.'event');
			exit;
		}
	}
	
	public function ccav_request_handler()
	{	
		$this->data['plan_data'] = $this->session->userdata('event_data_session');
		$this->load->view('front_end/ccavRequestHandler_event',$this->data);
	}
	
	public function payubizz()
	{	
		$plan_data = $this->session->userdata('event_data_session');
		if(isset($plan_data) && $plan_data!='' && $plan_data > 0)
		{
			$this->data['plan_data'] = $this->session->userdata('event_data_session');
			$this->load->view('front_end/payubizz_event',$this->data);
		}else{
			redirect($this->base_url.'event');
			exit;
		}	
	}
	
	public function payumoney()
	{	
		$plan_data = $this->session->userdata('event_data_session');
		if(isset($plan_data) && $plan_data!='' && $plan_data > 0)
		{
			$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','',"");
			
			$this->data['payumoney']=$payumoney;
			$this->data['plan_data']=$plan_data;
			$this->load->view('front_end/payumoney_event',$this->data);
		}else{
			redirect($this->base_url.'event');
			exit;
		}
	}
	
	public function instamojo()
	{	
		$plan_data = $this->session->userdata('event_data_session');
		$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");
			
		if(isset($plan_data) && $plan_data!= '' && isset($instamojo) && $instamojo!= '')
		{
			$this->data['plan_data']=$plan_data;
			$this->data['instamojo']=$instamojo;
			$this->load->view('front_end/instamojo_event',$this->data);
		}else{
			redirect($this->base_url.'event');
			exit;
		}
	}
	
	public function payment_status($pay_gateway)
	{	
		$plan_data = $this->session->userdata('event_data_session');
		if(isset($plan_data) && $plan_data!='')
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
				$response = $this->event_model->save_event($status);
			
				$this->data['base_url'] = $this->base_url;
				$this->data['success'] = $this->session->flashdata('success_message');
				
				$this->event_model->send_mail();
				
				$this->common_model->front_load_header('Event Registration Success');
				$this->load->view('front_end/payment_success_event',$this->data);
				$this->common_model->front_load_footer();
				
				$this->session->unset_userdata('event_data_session');
			}
			else
			{
				$this->data['base_url'] = $this->base_url;
				$this->data['error'] = 'Event Registration Fail.';
				
				$this->common_model->front_load_header('Event Registration Fail');
				$this->load->view('front_end/payment_success_event',$this->data);
				$this->common_model->front_load_footer();
			}
		}else{
			redirect($this->base_url.'event');
			exit;
		}
	}
	
	
}