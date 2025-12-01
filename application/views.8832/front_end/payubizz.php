<?php 
	include('payu.php');
	
	$payubizz = $this->common_model->get_count_data_manual('payment_method'," name = 'Paybizz' ",1,'*','','','',"");
		
	if(isset($get_user_data) && $get_user_data!='' && is_array($get_user_data) && count($get_user_data) > 0)
	{
		$pmatri_id =  $get_user_data['matri_id'];
		$pname =  $get_user_data['username'];
		$pemail =  $get_user_data['email'];
		$mobile =  $get_user_data['mobile'];
	}else{
		redirect($this->base_url.'premium-member');
		exit;
	}
		
	$payubiz_amount = $plan_data['total_pay'];
	$p_plan = $plan_data['plan_id'];
		
	// testing code set
	//$working_key='Dybxor';//Shared by CCAVENUES
	//$access_code='9CU8pRnB';//Shared by CCAVENUES
		
	$working_key=$payubizz['key'];//Shared by CCAVENUES
	$access_code=$payubizz['salt_access_code'];//Shared by CCAVENUES
		
	if(isset($user_agent) && $user_agent == 'NI-AAP'){
		$matri_id='';
		if(isset($user_id) && $user_id != ''){
			$matri_id = $user_id;
		}
		$payment_success = $base_url.'premium-member/payment-success-mobile-app/'.$matri_id.'/'.$p_plan;
		$payment_fail = $base_url.'premium-member/payment-fail-mobile-app';
	}else{
		$payment_success = $base_url.'premium-member/payment-status/PayUbizz';
		$payment_fail = $base_url.'premium-member/payment-status/fail';
	}
	
	pay_page( array ('key' =>$working_key, 'txnid' => uniqid($pmatri_id), 'amount' => $payubiz_amount, 'firstname' => $pname, 'email' => $pemail, 'phone' => $mobile,'productinfo' => $p_plan, 'udf1' => $pmatri_id, 'surl' => $payment_success, 'furl' => $payment_fail ), $access_code);
?>
        
		