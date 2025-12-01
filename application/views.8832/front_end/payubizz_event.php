<?php 
	include('payu.php');
	
	$payubizz = $this->common_model->get_count_data_manual('payment_method'," name = 'Paybizz' ",1,'*','','','',"");
		
	if(isset($plan_data) && $plan_data!='' && is_array($plan_data) && count($plan_data) > 0)
	{
		$pname =  $plan_data['confirm_email'];
		$pemail =  $plan_data['confirm_email'];
		$mobile =  $plan_data['confirm_mobile'];
		$payubiz_amount = $plan_data['total_amount'];
		$p_plan = $plan_data['event_id'];
	}
	
	// testing code set
	//$working_key='Dybxor';//Shared by CCAVENUES
	//$access_code='9CU8pRnB';//Shared by CCAVENUES
	
	$working_key=$payubizz['key'];//Shared by CCAVENUES
	$access_code=$payubizz['salt_access_code'];//Shared by CCAVENUES
	
	$payment_success = $base_url.'event/payment-status/PayUbizz';
	$payment_fail = $base_url.'event/payment-status/fail';
	
	pay_page( array ('key' =>$working_key, 'txnid' => uniqid($pname), 'amount' => $payubiz_amount, 'firstname' => $pname, 'email' => $pemail, 'phone' => $mobile,'productinfo' => $p_plan, 'udf1' => $pname, 'surl' => $payment_success, 'furl' => $payment_fail ), $access_code);
?>
        
		