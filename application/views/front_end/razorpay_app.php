<?php // Merchant key here as provided by Payu
$config_data = $this->common_model->data['config_data'];
$RazorPay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");
$plan_name = $plan_data['plan_name'];
$order_id = 'Membership Plan - '.$plan_name;
$total = $plan_data['total_pay'];
$plan_id = $plan_data['plan_id'];
$user_id = $user_id;

$total_new = ($total*100);
$amount = $total;
//$return_url = $base_url.'premium-member/payment-status/RazorPay';
$_POST['surl'] = $base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
$_POST['furl'] = $base_url.'premium-member/payment-fail-mobile-app';
$return_url = $base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
?>
<style>
.razorpay-payment-button{
	display:none !important;
}
</style>
<form action="<?php echo $return_url; ?>" method="post" id="razorpay_submit" name="razorpay_submit">
    <input type="hidden" name="user_id" id="user_id" value="<?php if(isset($user_id) && $user_id!=''){echo $user_id;}?>" >
    <input type="hidden" name="plan_id" id="plan_id" value="<?php if(isset($plan_id) && $plan_id!=''){echo $plan_id;}?>" >
    <input type="hidden" name="total_pay" id="total_pay" value="<?php if(isset($total_pay) && $total_pay!=''){echo $total_pay;}?>" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" >
    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $_POST['surl']; ?>"/>
    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $_POST['furl']; ?>"/>
    <script language='javascript' src="https://checkout.razorpay.com/v1/checkout.js"  data-redirect="true" data-key="<?php if(isset($RazorPay['key']) && $RazorPay['key']!=''){echo $RazorPay['key'];}?>" data-amount="<?php echo intval($total_new); ?>" data-name="<?php echo $config_data['web_frienly_name']; ?>" data-image='<?php echo $base_url.'assets/logo/'.$config_data['upload_logo'];?>'; data-theme.color="#ff7e00">
    </script>
</form>
<script src="<?php echo $base_url;?>assets/front_end_new/js/jquery-3.2.1.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery-3.2.1.min.js');?>"></script>
<script>
$(".razorpay-payment-button").trigger('click');
</script>