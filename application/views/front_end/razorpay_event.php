<?php 
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
	$total_new = ($total*100);
	$amount = $total;

	$_POST['surl'] = $base_url.'event/payment-status/RazorPay';
	$_POST['furl'] = $base_url.'event/payment-status/fail';

$posted = array();
$txnid = '';
if($this->input->post('razorpay_payment_id')!=''){
	$txnid = $this->input->post('razorpay_payment_id');
}
$return_url = $base_url.'event/payment-status/RazorPay';
?>
<form name="razorpayform" id="razorpayform" action="<?php echo $return_url; ?>" method="POST">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" value="<?php echo $txnid;?>" />
    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?php echo $order_id; ?>"/>
    <input type="hidden" name="merchant_trans_id" id="merchant_trans_id" value="<?php echo $txnid; ?>"/>
    <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="<?php echo $_POST['productinfo']; ?>"/>
    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $_POST['surl']; ?>"/>
    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $_POST['furl']; ?>"/>
    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $_POST['firstname']; ?>"/>
    <input type="hidden" name="merchant_total" id="merchant_total" value="<?php echo $total_new; ?>"/>
    <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $amount; ?>"/>
</form>
<script language='javascript'>document.razorpayform.submit();</script>
