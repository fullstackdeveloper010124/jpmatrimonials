<?php
	//echo "<pre>";
	//print_r($instamojo);
	//print_r($get_user_data);
	//print_r($plan_data);
	//print_r($plan_data['plan_data_array']);exit;

	
	$mobile = '';
	if($get_user_data['mobile'] !='')
	{
		$mo_arr = explode('-',$get_user_data['mobile']);
		$mobile = $mo_arr[1];
	}
	$mobile = '';//currently mobile no pass null value
	
	$email  = $get_user_data['email'];
	$name  = $get_user_data['username'];
	$amt  = $plan_data['total_pay'];

	if(isset($user_agent) && $user_agent == 'NI-AAP'){
		$plan_name = "Membership ".$plan_data['plan_name'].' Plan';
		$plan_name	= substr($plan_name,0,30);
	}else{
		$selected_plan = $plan_data['plan_data_array'];
		if(isset($selected_plan) && $selected_plan != ''){
			$plan_name = "Membership ".$selected_plan['plan_name'].' Plan';
			$plan_name	= substr($plan_name,0,30);
		}else{
			$plan_name = "Membership Plan For Mega Matrimony";
			$plan_name	= substr($plan_name,0,30);
		}
	}

	include_once('instamojo/Instamojo.php');

	$API_KEY = $instamojo['key'];
	$AUTH_TOKEN = $instamojo['salt_access_code']; 
	
	$api = new instamojo\Instamojo($API_KEY, $AUTH_TOKEN);
	
	
	
	if(isset($user_agent) && $user_agent == 'NI-AAP'){
		$matri_id='';
		$p_plan	= $plan_data['plan_id'];
		
		if(isset($user_id) && $user_id != ''){
			$matri_id = $user_id;
		}
		$redirect_url = $base_url.'premium-member/payment-success-instamojo-mobile-app/'.$matri_id.'/'.$p_plan;
		$fail_url = $base_url.'premium-member/payment-fail-mobile-app';
	}else{
		$redirect_url = $base_url.'premium-member/payment-status/Instamojo';
		$fail_url = $base_url.'premium-member/payment-status/fail';
	}
	
	try
	{
		
	
		$response = $api->paymentRequestCreate(array(
			"purpose" => $plan_name,
			"buyer_name"=>$name,
			"amount" => $amt,
			"send_email" => false,
			"email" => $email,
			"phone"=>$mobile,
			"send_sms"=>false,
			"redirect_url" => $redirect_url
			));
			
		if(isset($response['longurl']) && $response['longurl'] !='')
		{
			redirect($response['longurl']);
			exit;
		}
		else
		{
			redirect($fail_url);
			exit;
		}
	}
	catch (Exception $e) 
	{
		print('Error: ' . $e->getMessage());
		redirect($fail_url);
		exit;
	}	
?>