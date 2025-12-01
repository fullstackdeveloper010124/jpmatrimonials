<style>
.new-width-plan-event {
    width: 100%;
}
.razorpay-payment-button{
        display :none;
}
</style>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mr-top-26  mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Vendor Payment Option</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-lg hidden-md">
                <div class="box-main-s member-ship">
                    <p class="Poppins-Semi-Bold mega-n3 f-s mb-0 mb-20-m pull-right float-left-n text-center-m">Payment<span class="mega-n4 f-s">Option</span></p>
                </div>
                <ul class="social-icons">
                    <li><a href="javascript:void(0);" class="social-icon social-icons-f"> 
                    	<i class="fas fa-check check-color"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="social-icon social-icons-insta"> <i class="fas fa-cart-plus add-cart"></i></a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="social-icon social-icons-g"> <i class="fab fa-cc-visa visa-color"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center hidden-sm hidden-xs">
                <div class="box-main-s member-ship">
                    <p class="Poppins-Semi-Bold mega-n3 f-2-p mb-0 mb-10-m">Payment<span class="mega-n4 f-2-p"> Option</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
            </div>
        </div>
    </div>
</div>

<?php 
$email = '';
$mobile = '';
$username = '';
//Razorpay extra code
$upload_logo = $config_data['upload_logo'];
$colour_name = $config_data['colour_name'];
//Razorpay extra code end

if(isset($vendor_data) && $vendor_data != ''){
	// $event = $event_data['event_id'];
	$businessName = $vendor_data['title'];
	// $event_amount = $event_data['total_amount'];
	// $event_amount_type = $event_data['ticket_currency'];
	// $username = $event_data['confirm_email'];
	// $email = $event_data['confirm_email'];
	// $mobile = $event_data['confirm_mobile'];
}
if(isset($plan_details) && $plan_details != ''){
	$currency = $plan_details['currency'];
	$currency_code = $plan_details['currency_code'];
	$plan_ammount = $plan_details['plan_ammount'];
}

$this->session->set_userdata('wedding_planner',$vendor_data['id']);

$data_array = array('currency'=>$currency,'currency_code'=>$currency_code,'plan_ammount'=>$plan_ammount,'business_name'=>$businessName);		
$this->session->set_userdata('plan_data_session',$data_array);


$ccavenue = $this->common_model->get_count_data_manual('payment_method'," name = 'CCAvenue' ",1,'*','','','',"");
$paypal = $this->common_model->get_count_data_manual('payment_method'," name = 'Paypal' ",1,'*','','','',"");
$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','',"");
$payubizz = $this->common_model->get_count_data_manual('payment_method'," name = 'Paybizz' ",1,'*','','','',"");
$BankDetails = $this->common_model->get_count_data_manual('payment_method'," name = 'BankDetails' ",1,'*','','','',"");
$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");
$RazorPay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");
$stripe = $this->common_model->get_count_data_manual('payment_method'," name = 'Stripe' ",1,'*','','','',"");
$cancel_return = $base_url.'event/payment-status/fail';

?>

<div class="container new-width">
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="e-detail-box prld-zero">
                <h3 class="text-center Poppins-Semi-Bold font-size-20" style="padding: 18px 0px 6px;">  <?php echo $businessName;?></h3>
                <hr class="hr-plan"/>
                <div class="box-center-event">
                <?php if(isset($payment_methods) && $payment_methods!='' && is_array($payment_methods) && count($payment_methods)>0){?>
                    <div class="row">
						<?php 
                        $i=1;
                        $path_payment_logo = $this->common_model->path_payment_logo;
                        foreach($payment_methods as $row_method){
                            if(isset($row_method['logo']) && $row_method['logo'] !='' && file_exists($path_payment_logo.$row_method['logo'])){
                                $payment_logo = $base_url.$path_payment_logo.$row_method['logo'];
                            }
                            else{
                                $payment_logo = '';
                            }
                            if($i == 1){
                                $active = 'active';
                            }else{
                                $active = '';
                            }
							$half = ceil(count($payment_methods)/2);
                            if($i == 1 && count($payment_methods) == 3){
                                echo '<div class="col-md-3 col-xs-12 col-sm-12"><div class="box-new">';
                            }
                            else{
								if($i == 1){
									echo '<div class="col-md-3 col-xs-12 col-sm-12"><div class="box-new">';
								}
								else if($i%3 == 1){
									echo '</div></div><div class="col-md-3 col-xs-12 col-sm-12"><div class="box-new">';
								}
							}
                            ?>
                            <div class="row">
                                <div class="box-new-padding">
                                    <div class="col-md-3 col-xs-2 col-sm-2">
                                        <div class="radio-item Poppins-Medium f-16 mr-zero">
                                            <input type="radio" id="<?php echo $row_method['name'];?>" name="ritem" value="ropt1" <?php if($active!=''){echo 'checked';}?> >
                                            <label for="<?php echo $row_method['name'];?>" class="<?php echo $active;?> color-d fr-12"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-9 col-xs-10 col-sm-10">
                                        <label for="<?php echo $row_method['name'];?>" class="<?php echo $active;?> color-d fr-12">
                                        <?php 
                                        if(isset($payment_logo) && $payment_logo!= ''){?>
                                            <img src="<?php echo $payment_logo;?>" alt="">
                                        <?php
                                            }else{ 
                                                echo $row_method['name'];
                                            }
                                        ?></label>
                                    </div>
                                </div>
                            </div>
                            <hr class="hr-p" style="margin-bottom:0px;">
                            <?php if($i == count($payment_methods)){
                                    echo '</div></div>';
                                }
								$i++;
                            }?>  
                            
                        <div class="col-md-5 col-xs-12 col-sm-12">
                            <div class="box-new new-width-plan-event">
                                <div class="box-new-padding-2">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-7 col-xs-6">
                                            <p class="Poppins-Medium plan-color">Business Name</p>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                                            :
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                                            <p class="Poppins-Semi-Bold"><?php echo $businessName;?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-7 col-xs-6">
                                            <p class="Poppins-Medium plan-color">Amount</p>
                                        </div>
                                        <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                                            :
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                                            <p class="Poppins-Semi-Bold color-plan"><?php echo $currency_code.' '.$plan_ammount;?></p>
                                        </div>
                                    </div>
                                </div>                                
                                <hr class="hr-2-p"/>
                                <div class="box-new-padding-2">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div style="display:<?php if(isset($paypal['status']) && $paypal['status']=='APPROVED'){echo 'block';}else{echo 'none';}?>" id="Paypal_form">
                                                <form action="https://www.paypal.com/cgi-bin/webscr" name="frmPayPal1" id="frmPayPal1" method="post" class="" onSubmit="return payment_paypal();">
                                                    <input type="hidden" name="business" value="<?php echo $paypal['email_merchant_id']; ?>">
                                                    <input type="hidden" name="cmd" value="_xclick">
                                                    <input type="hidden" name="item_name" value="Membership Plan <?php echo $event_amount;?> Purchase">
                                                    <input type="hidden" name="item_number" value="1">
                                                    <input type="hidden" name="credits" value="510">
                                                    <input type="hidden" name="userid" value="1">
                                                    <input type="hidden" name="amount" value="<?php echo $event_amount;?>">
                                                    <input type="hidden" name="no_shipping" value="1">
                                                    <input type="hidden" name="currency_code" value="USD">
                                                    <input type="hidden" name="handling" value="0">
                                                    <input type="hidden" name="cancel_return" class="cancel_URL" value="<?php echo $cancel_return;?>" />
                                                    <input type="hidden" name="return" class="success_URL" value="<?php echo $base_url.'event/payment-status/Paypal';?>" />
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                                </form>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="Paybizz_form">
                                                <form action="<?php echo $base_url;?>event/payubizz" method="post" name="frmPayUbizz" id="frmPayUbizz" onSubmit="return payment_payubizz();">
                                                    <input type="hidden" name="business" value="<?php echo $payubizz['email_merchant_id'];?>">
                                                    <input type="hidden" name="cmd" value="_xclick">
                                                    <input type="hidden" name="item_name" value="Membership Plan <?php echo $event_name;?> Purchase">
                                                    <input type="hidden" name="item_number" value="1">
                                                    <input type="hidden" name="credits" value="510">
                                                    <input type="hidden" name="userid" value="1">
                                                    <input type="hidden" name="amount" value="<?php echo $event_amount;?>">
                                                    <input type="hidden" name="no_shipping" value="1">
                                                    <input type="hidden" name="currency_code" value="INR">
                                                    <input type="hidden" name="handling" value="0">
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                                </form>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='UNAPPROVED') && (isset($payumoney['status']) && $payumoney['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="PayUmoney_form">
                                            	<form action="<?php echo $base_url;?>event/payumoney" method="post" name="frmPayPal1">
                                                    <input type="hidden" name="plan_name" value="<?php echo $event_name;?>">
                                                    <input type="hidden" name="plan_amount" value="<?php echo $event_amount;?>">
                                                    <input type="hidden" name="plan_id" value="<?php echo $event;?>">
                                                    <input type="hidden" name="plan_amount_type" value="INR">
                                                    <input type="hidden" name="service_provider" value="payu_paisa" size="64" >
                                                    <input type="hidden" name="productinfo" value="<?php echo $event_name;?>">
                                                    
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                                </form>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($RazorPay['status']) && $RazorPay['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="RazorPay_form">
                                                <form name="razorpayform" id="razorpayform" action="<?php echo $base_url;?>event/RazorPay" method="POST">
                                                    <input type="hidden" name="merchant_product_info_id" id="merchant_product_info_id" value="Membership Plan <?php echo $event_name;?> Purchase"/>
                                                    <input type="hidden" name="merchant_surl_id" id="merchant_surl_id" value="<?php echo $base_url.'event/payment-status/RazorPay'; ?>"/>
                                                    <input type="hidden" name="merchant_furl_id" id="merchant_furl_id" value="<?php echo $cancel_return; ?>"/>
                                                    <input type="hidden" name="card_holder_name_id" id="card_holder_name_id" value="<?php echo $_POST['confirm_email']; ?>"/>
                                                    <input type="hidden" name="merchant_amount" id="merchant_amount" value="<?php echo $event_amount; ?>"/>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" >
                                                    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php if(isset($RazorPay['key']) && $RazorPay['key']!=''){echo $RazorPay['key'];}?>" data-amount="<?php echo $event_amount*100; ?>"  data-name="<?php echo $web_frienly_name;?>" data-image="<?php echo $base_url;?>assets/logo/<?php echo $upload_logo;?>"   data-theme.color="<?php echo $colour_name!=''?$colour_name:'#ff7e00';?>" ></script>
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                </form>
                                            </div>   
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='UNAPPROVED') && (isset($payumoney['status']) && $payumoney['status']=='UNAPPROVED') && (isset($ccavenue['status']) && $ccavenue['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="CCAvenue_form">
                                            	<form method="post" name="customerData1" id="customerData1" action="<?php echo $base_url;?>event/ccav-request-handler" enctype="multipart/form-data" onSubmit="return payment_ccavenue();">
                                                    <input type="hidden" name="merchant_id" value="<?php echo $ccavenue['email_merchant_id']; ?>"/>
                                                    <input type="hidden" name="order_id" value="<?php echo $event;?>"/>
                                                    <input type="hidden" name="currency" value="INR"/>
                                                    <input type="hidden" name="redirect_url" value="<?php echo $base_url.'event/payment-status/CCAvenue';?>"/>
                                                    <input type="hidden" name="cancel_url" value="<?php echo $cancel_return;?>"/>                                                  <input type="hidden" name="language" value="EN"/>
                                                    <input type="hidden" name="billing_name" value="<?php echo $username;?>"/>
                                                    <input type="hidden" name="billing_address" value=""/>
                                                    <input type="hidden" name="billing_state" value="<?php echo '';?>"/>
                                                    <input type="hidden" name="billing_zip" value="<?php echo '';?>"/>
                                                    <input type="hidden" name="billing_country" value="<?php echo '';?>"/>
                                                    <input type="hidden" name="billing_tel" value="<?php echo $mobile;?>"/>
                                                    <input type="hidden" name="billing_email" value="<?php echo $email;?>"/>
                                                    <input type="hidden" name="udf1" value="<?php echo $event_name;?>"/>
                                                    <input type="hidden" name="udf2" value="<?php echo $event;?>"/>
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                                </form>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='UNAPPROVED') && (isset($payumoney['status']) && $payumoney['status']=='UNAPPROVED') && (isset($ccavenue['status']) && $ccavenue['status']=='UNAPPROVED') && (isset($stripe['status']) && $stripe['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="stripe_form">
                                            	<form method="post" name="stripeForm" id="stripeForm" action="<?= base_url('vendor-stripe-pay') ?>" enctype="multipart/form-data">
                                                    <input type="hidden" name="price" value="<?php echo $plan_ammount ?>">
                                                    <input type="hidden" name="currency" value="<?php echo $currency; ?>">                                                    
                                                    <button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16 ">Pay Now</button>
                                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                                </form>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='UNAPPROVED') && (isset($payumoney['status']) && $payumoney['status']=='UNAPPROVED') && (isset($ccavenue['status']) && $ccavenue['status']=='UNAPPROVED') && (isset($stripe['status']) && $stripe['status']=='UNAPPROVED') && (isset($instamojo['status']) && $instamojo['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="Instamojo_form">
                                                <a href="<?php echo $base_url.'event/instamojo';?>">
                                                    <div class="mega-n-btn1 pay-now-2">
                                                        <div class="Poppins-Medium color-f f-16 ">Pay Now</div>
                                                    </div>
                                                </a>
                                            </div>
                                            <div style="display:<?php if((isset($paypal['status']) && $paypal['status']=='UNAPPROVED') && (isset($payubizz['status']) && $payubizz['status']=='UNAPPROVED') && (isset($payumoney['status']) && $payumoney['status']=='UNAPPROVED') && (isset($ccavenue['status']) && $ccavenue['status']=='UNAPPROVED') && (isset($stripe['status']) && $stripe['status']=='UNAPPROVED') && (isset($instamojo['status']) && $instamojo['status']=='UNAPPROVED') && (isset($BankDetails['status']) && $BankDetails['status']=='APPROVED')){echo 'block';}else{echo 'none';}?>" id="BankDetails_form">
                                            	<div class="basic_details">
													<?php echo nl2br($BankDetails['description']);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }else{?>
                        <div class="alert alert-danger text-center">Not Available Any Payment Option</div>
				<?php }?>
                </div>
            </div>
        </div>
	</div>
</div>

<?php
$this->common_model->js_extra_code_fr .= "
$('input[name = ritem]').change(function(){
	$('input[name = ritem]').each(function(i) {
		var id = $(this).attr('id');
		document.getElementById(id+'_form').style.display = 'none';
	});
	if( $(this).is(':checked') ){
		var id = $(this).attr('id');
		document.getElementById(id+'_form').style.display = 'block';
	}
});
";?>