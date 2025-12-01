<?php 
	/*echo "<pre>";
	print_r($payumoney);
	print_r($plan_data);exit;*/
	
	if(isset($plan_data) && $plan_data!='' && is_array($plan_data) && count($plan_data) > 0)
	{
		$order_id = 'Event Name - '.$plan_data['title'];
		$total = $plan_data['total_amount'];
		$p_plan = $plan_data['event_id'];
		$cust_name = $plan_data['confirm_email'];
		$cust_email = $plan_data['confirm_email'];
		$cust_number = $plan_data['confirm_mobile'];
	}else{
		redirect($this->base_url.'event');
		exit;
	}
	
	$_POST['amount'] = $total;
	$_POST['firstname'] = $cust_name;
	$_POST['email'] = $cust_email;
	$_POST['phone'] = $cust_number;
	$_POST['productinfo'] = $order_id;
	$_POST['surl'] = $base_url.'event/payment-status/PayUMoney';
	$_POST['furl'] = $base_url.'event/payment-status/fail';
	
$MERCHANT_KEY = $payumoney['key'];	// update key and salt here for live
$SALT = $payumoney['salt_access_code'];

if(base_url() == 'http://192.168.1.111/mega_matrimony/original_script/v2.0/')
{
	$PAYU_BASE_URL = 'https://sandboxsecure.payu.in';
	//$PAYU_BASE_URL = 'https://secure.payu.in';
}
else
{	
	$PAYU_BASE_URL = 'https://secure.payu.in';
	//$PAYU_BASE_URL = 'https://sandboxsecure.payu.in';
}
$payu_marchent_id = $payumoney['email_merchant_id'];
$action = '';
$posted = array();

$firstSplitArr = array("name"=>"splitID1", "value"=>"6", "merchantId"=>$payu_marchent_id, "description"=>"test description", "commission"=>"2");
$paymentPartsArr = array($firstSplitArr);
$finalInputArr = array("paymentParts" => $paymentPartsArr);
$Prod_info = json_encode($finalInputArr);

$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$_POST['txnid'] = $txnid;
$_POST['key'] = $MERCHANT_KEY;
$_POST['service_provider'] = 'payu_paisa';

if(!empty($_POST))
{
	//print_r($_POST);
  	foreach($_POST as $key => $value)
	{
    	$posted[$key] = $value;
  	}
}
$formError = 0;

$hash = '';
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
if(empty($posted['hash']) && sizeof($posted) > 0)
{
	if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<form action="<?php echo $action;?>" method="post" name="frmpayumoney1" id="frmpayumoney1">
    <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY; ?>" />
    <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
    <input type="hidden" name="productinfo" value="<?php echo $order_id; ?>" />
    <input type="hidden" name="amount" value="<?php echo $_POST['amount'];?>">
    <input type="hidden" name="firstname" value="<?php echo $_POST['firstname'];?>">
    <input type="hidden" name="phone" value="<?php echo $_POST['phone']; ?>" />
    <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>" />
    <input type="hidden" name="service_provider" value="payu_paisa" size="64"/>
    
    <input type="hidden" name="surl" value="<?php echo $_POST['surl'];?>"/>
    
    <input type="hidden" name="furl" value="<?php echo $_POST['furl'];?>"/>
    
</form>
<script language='javascript'>document.frmpayumoney1.submit();</script>
