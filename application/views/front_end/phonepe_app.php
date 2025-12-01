<?php // Merchant key here as provided by Payu
$config_data = $this->common_model->data['config_data'];
$plan_name = $plan_data['plan_name'];
$order_id = 'Membership Plan - '.$plan_name;
$total = $plan_data['total_pay'];
$plan_id = $plan_data['plan_id'];
$user_id = $user_id;

$total_new = ($total*100);
$amount = $total;
// echo $amount;exit;
//$return_url = $base_url.'premium-member/payment-status/RazorPay';
$_POST['surl'] = $base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
$_POST['furl'] = $base_url.'premium-member/payment-fail-mobile-app';
$return_url = $base_url.'premium-member/payment-success-mobile-app/'.$user_id.'/'.$plan_id;
?>


<form action="<?php echo $base_url;?>premium-member/phonePeMobile" method="post" name="frmphonepe">
        <input type="hidden" name="amount" value="<?php echo $amount;?>">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <input type="hidden" name="plan_id" value="<?php echo $plan_id; ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
        <button type="submit" name="submit" id="submitBtn" title="Phonepe - The safer, easier way to pay online!">Pay Now</button>                 
    </form>
    
  
  <script>
        // Automatically click the submit button with a slight delay
        window.onload = function() {
            setTimeout(function() {
                document.getElementById('submitBtn').click();
            }, 100); // Delay in milliseconds (100ms here)
        };
    </script>