<?php
	/*echo "<pre>";
	print_r($instamojo);
	print_r($plan_data);
	exit;*/
	
	if(isset($plan_data) && $plan_data != '' && is_array($plan_data) && count($plan_data) > 0)
	{
		$plan_name = 'Event Name - '.$plan_data['title'];
		$plan_name	= substr($plan_name,0,30);
		$email  = $plan_data['confirm_email'];
		$name  = $plan_data['confirm_email'];
		$amt  = $plan_data['total_amount'];
		$mobile  = $plan_data['confirm_mobile'];
		$mobile = '';
		
		include_once('instamojo/Instamojo.php');

		$API_KEY = $instamojo['key'];
		$AUTH_TOKEN = $instamojo['salt_access_code']; 

		$api = new instamojo\Instamojo($API_KEY, $AUTH_TOKEN);
		
		$redirect_url = $base_url.'event/payment-status/Instamojo';
		$fail_url = $base_url.'event/payment-status/fail';
		
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
	}else{
		redirect($this->base_url.'event');
		exit;
	}
	
	
?>