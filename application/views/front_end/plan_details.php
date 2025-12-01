<div class="box-for-plan-details">
    <h3>Selected Plan - <span><?php echo $plan_data['plan_name']?></span></h3>
    <hr>
    <ul>
        <li><span><i class="fas fa-check-circle"></i></span> Allowed Message - <?php echo $plan_data['plan_msg']?></li>
        <li><span><i class="fas fa-check-circle"></i></span> Allowed Contacts - <?php echo $plan_data['plan_contacts']?></li>
        <li><span><i class="fas fa-check-circle"></i></span> Allowed View Profiles - <?php echo $plan_data['profile']?></li>
        <li><span><i class="<?php echo $plan_data['chat']=='Yes'?'fas fa-check-circle':'fas fa-times-circle text-danger'; ?>"></i></span> Live Chat</li>
        <li><span><i class="fas fa-check-circle"></i></span> Plan Duration - <?php echo $plan_data['plan_duration']?> Days</li>
    </ul>
</div>
<?php 
    $offer_amount = $gst_amount = $discount_amount = $serviceTax = 0;
    $coupan_code = $taxApllicable = $taxName = $colour_name = $web_frienly_name = $upload_logo = '';
    $plan_amount = $plan_data['plan_amount'];
    $total_amount = $plan_data['plan_amount'];
    $offer_per = $plan_data['offer_per'];
    $plan_amount_type = $plan_data['plan_amount_type'];
    
    if (!empty($config_data)) {
        $taxApllicable = $config_data['tax_applicable'];
        $taxName = $config_data['tax_name'];
        $serviceTax = $config_data['service_tax'];
        $colour_name = $config_data['colour_name'];
        $web_frienly_name = $config_data['web_frienly_name'];
        $upload_logo = $config_data['upload_logo'];
    }
    if ($offer_per>0) {
        $offer_amount = ($plan_amount * $offer_per) / 100;
        $total_amount = $total_amount - $offer_amount;
    }
    if($this->session->userdata('coupan_data_reddem')){
        $coupan_data = $this->session->userdata('coupan_data_reddem');
        if($total_amount > $coupan_data['discount_amount']){
            $discount_amount = $coupan_data['discount_amount'];
            $total_amount = $total_amount - $discount_amount;
        }
        if(isset($coupan_data['coupan_code']) && $coupan_data['coupan_code'] !='')
        {
            $coupan_code = $coupan_data['coupan_code'];
        }
    }
    if ($plan_amount>0) {
        if ($taxApllicable == 'Yes' && $serviceTax > 0) {
            $gst_amount = ($total_amount * $serviceTax) / 100;
            $total_amount = $total_amount + $gst_amount;
        }
    }
    $data_array = array('discount_amount'=>$discount_amount,'coupan_code'=>$coupan_code,'plan_id'=>$plan_data['id'],'service_tax'=>$gst_amount,'plan_amount'=>$plan_amount,'total_pay'=>$total_amount,'plan_data_array'=>$plan_data);		
	$this->session->set_userdata('plan_data_session',$data_array);
?>
<div class="invoice-bg-short">
    <div class="pay-now-btn">
        <div class="box-new-invoice">
            <div class="row amount-bg">
                <div class="col-md-6 col-sm-7 col-xs-6">
                    <p class="Poppins-Medium">Plan Amount</p>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                    :
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                    <p class="Poppins-Semi-Bold"><?php echo $plan_data['plan_amount_type'].' '.$plan_data['plan_amount'];?></p>
                </div>
            </div>
            <?php if ($offer_amount>0) {?>
            <div class="row gst-bg">
                <div class="col-md-6 col-sm-7 col-xs-6">
                    <p class="Poppins-Medium plan-color">Offer Amount</p>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                    :
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                    <p class="Poppins-Semi-Bold" style="color:#F3151C;">- <?php echo $plan_data['plan_amount_type'].' '.number_format($offer_amount,2);?></p>
                </div>
            </div>
            <?php } if ($discount_amount>0) {?>
            <div class="row total-amount-bg">
                <div class="col-md-6 col-sm-7 col-xs-6">
                    <p class="Poppins-Medium plan-color">Discount Amount</p>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                    :
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                    <p class="Poppins-Semi-Bold" style="color:#F3151C;">- <?php echo $plan_data['plan_amount_type'].' '.number_format($discount_amount,2);?></p>
                </div>
            </div>
            <?php } if ($gst_amount>0 && $taxApllicable == 'Yes' && $serviceTax > 0) {?>
            <div class="row gst-bg">
                <div class="col-md-6 col-sm-7 col-xs-6">
                    <p class="Poppins-Medium plan-color"><?php echo $taxName.'('.$serviceTax.'%)';?></p>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                    :
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                    <p class="Poppins-Semi-Bold" style="color:#069106;">+ <?php echo $plan_data['plan_amount_type'].' '.number_format($gst_amount,2);?></p>
                </div>
            </div>
            <?php }?>
            <div class="row total-amount-bg">
                <div class="col-md-6 col-sm-7 col-xs-6">
                    <p class="Poppins-Medium plan-color">Total Amount</p>
                </div>
                <div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
                    :
                </div>
                <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                    <p class="Poppins-Semi-Bold" style="color:#069106;"><?php echo $plan_data['plan_amount_type'].' '.number_format($total_amount,2);?></p>
                </div>
            </div>
            <?php if ($total_amount>0) {?>
                <div class="row reed-in-btn">
                    <div class="col-md-8 col-sm-7 col-xs-6">
                        <input type="text" class="form-control" placeholder="Coupon Code" name="couponcode"
                            id="couponcode" value="">
                        <span id="err_couponcode" class="text-danger"></span>
                        <input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_data['id']?>">
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6 text-right">
                        <div class="_redeem-btn">
                            <a href="javascript:;" onclick="return check_coupan_code()"
                                class="Poppins-Medium color-f f-16">Redeem</a>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
        <?php 
        $planSessionData = $this->session->userdata('plan_data_session');
        $cancel_return = $base_url.'premium-member/payment-status/fail';
        if(isset($plan_amount_type) && $plan_amount_type=='INR')
        {
            $for_paypal_inr_to_usd = ($planSessionData['total_pay']/73);
        }
        else
        {
            $for_paypal_inr_to_usd = $planSessionData['total_pay'];
        }
        if(isset($member_data) && !empty($member_data)){
            $matri_id = $member_data['matri_id'];
            $email = $member_data['email'];
            $username = $member_data['username'];
            $address = $member_data['address'];
            $mobile = '';
            if($member_data['mobile'] !='')
            {
                $mo_arr = explode('-',$member_data['mobile']);
                if(isset($mo_arr) && $mo_arr!='' && is_array($mo_arr) && count($mo_arr)>1)
                {
                    $mobile = $mo_arr[1];
                }
                else
                {
                    $mobile = $member_data['mobile'];
                }
            }
        }

        $selected_plan = $planSessionData['plan_data_array'];

		if(isset($selected_plan) && $selected_plan != '' && is_array($selected_plan) && count($selected_plan) > 0)
		{
			$plan = $selected_plan['id'];
			$planName = $selected_plan['plan_name'];
			$planAmount = $selected_plan['plan_amount'];
			$planAmountType = $selected_plan['plan_amount_type'];
			$planDuration = $selected_plan['plan_duration'];
			$planContacts = $selected_plan['plan_contacts'];
			$profile = $selected_plan['profile'];
			$planMsg = $selected_plan['plan_msg'];
		}
        $method_name = $email_merchant_id = '';
        if($planSessionData['total_pay']>0){
            if(isset($payment_method['name']) && $payment_method['name']!=''){
                $method_name = $payment_method['name'];
            }
            if(isset($payment_method['email_merchant_id']) && $payment_method['email_merchant_id']!=''){
                $email_merchant_id = $payment_method['email_merchant_id'];
            }
        }else{?>
        <a href="<?php echo $base_url.'contact';?>">
            <button type="button">Contact Us</button>
        </a>
        <?php } if($method_name=='Paypal'){?>
        <div id='Paypal_form'>
            <form action="https://www.paypal.com/cgi-bin/webscr" name="frmPayPal1" id="frmPayPal1" method="post" class="" onSubmit="return payment_paypal();">
                <input type="hidden" name="business" value="<?php echo $email_merchant_id; ?>">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="item_name" value="Membership Plan <?php echo $for_paypal_inr_to_usd;?> Purchase">
                <input type="hidden" name="item_number" value="1">
                <input type="hidden" name="credits" value="510">
                <input type="hidden" name="userid" value="1">
                <input type="hidden" name="amount" value="<?php echo $for_paypal_inr_to_usd;?>">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="handling" value="0">
                <input  type="hidden" name="notify_url" value="SUCCESS_URL" />
                <input type="hidden" name="rm" value="2">
                <input type="hidden" name="cancel_return" class="cancel_URL" value="<?php echo $cancel_return;?>" />
                <input type="hidden" name="return" class="success_URL" value="<?php echo $base_url.'premium-member/payment-status/Paypal';?>" />
                <button type="submit" name="submit" title="PayPal - The safer, easier way to pay online!">Pay Now
                </button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
            </form>
        </div>
        <?php } if($method_name=='Stripe'){?>
        <div id='Paypal_form'>
            <form action="<?= base_url('premium-member/stripe') ?>" method="POST">
                <input type="hidden" name="price" value="<?php echo $planSessionData['total_pay'] ?>">
                <input type="hidden" name="currency" value="<?php echo $planAmountType; ?>">
                <input type="hidden" name="name" value="<?php echo $planName; ?>">
                <button type="submit" name="submit" title="PayPal - The safer, easier way to pay online!">Pay Now </button>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />           
            </form>
        </div>
        <?php } if($method_name=='Paybizz'){?>
        <div id='Paybizz_form'>
            <form action="<?php echo $base_url;?>premium-member/payubizz" method="post" name="frmPayUbizz" id="frmPayUbizz" onSubmit="return payment_payubizz();">
            <input type="hidden" name="business" value="<?php echo $email_merchant_id;?>">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="item_name" value="Membership Plan <?php echo $planName;?> Purchase">
            <input type="hidden" name="item_number" value="1">
            <input type="hidden" name="credits" value="510">
            <input type="hidden" name="userid" value="1">
            <input type="hidden" name="amount" value="<?php echo $planSessionData['total_pay'];?>">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="currency_code" value="INR">
            <input type="hidden" name="handling" value="0">

            <button type="submit" name="submit" title="Paybizz - The safer, easier way to pay online!">Pay Now
            </button>

            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
            </form>
        </div>
        <?php }else if($method_name=='PayUmoney'){?>
        <div id='PayUmoney_form'>
            <form action="<?php echo $base_url;?>premium-member/payumoney" method="post" name="frmPayPal1">

            <input type="hidden" name="plan_name" value="<?php echo $planName;?>">
            <input type="hidden" name="plan_amount" value="<?php echo $planSessionData['total_pay'];?>">
            <input type="hidden" name="plan_id" value="<?php echo $plan;?>">
            <input type="hidden" name="plan_amount_type" value="INR">
            <input type="hidden" name="service_provider" value="payu_paisa" size="64" >
            <input type="hidden" name="productinfo" value="<?php echo $planName;?>">

            <button type="submit" name="submit" title="PayUmoney - The safer, easier way to pay online!">Pay Now</button>

        </button>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
            </form>
        </div>
        <?php }else if($method_name=='CCAvenue'){?>
        <div id="CCAvenue_form">
            <form method="post" name="customerData1" id="customerData1" action="<?php echo $base_url;?>premium-member/ccav-request-handler" enctype="multipart/form-data" onSubmit="return payment_ccavenue();">
                <input type="hidden" name="merchant_id" value="<?php echo $email_merchant_id; ?>"/>
                <input type="hidden" name="order_id" value="<?php echo $matri_id.'-'.$plan;?>"/>
                <input type="hidden" name="currency" value="INR"/>
                <input type="hidden" name="redirect_url" value="<?php echo $base_url.'premium-member/payment-status/CCAvenue';?>"/>
                <input type="hidden" name="cancel_url" value="<?php echo $cancel_return;?>"/>
                <input type="hidden" name="language" value="EN"/>
                <input type="hidden" name="billing_name" value="<?php echo $username;?>"/>
                <input type="hidden" name="billing_address" value="<?php echo $address;?>"/>
                <input type="hidden" name="billing_state" value="<?php echo '';?>"/>
                <input type="hidden" name="billing_zip" value="<?php echo '';?>"/>
                <input type="hidden" name="billing_country" value="<?php echo '';?>"/>
                <input type="hidden" name="billing_tel" value="<?php echo $mobile;?>"/>
                <input type="hidden" name="billing_email" value="<?php echo $email;?>"/>
                <input type="hidden" name="udf1" value="<?php echo $planName;?>"/>
                <input type="hidden" name="udf2" value="<?php echo $plan;?>"/>
                <button type="submit" title="CCAvenue - The safer, easier way to pay online!">Pay Now</button>

                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
            </form>
        </div>
        <?php }else if($method_name=='RazorPay'){?>
        <div id="RazorPay_form">
            <button type="button" onClick="process_checkout_razorpay()" title="Razorpay - The safer, easier way to pay online!">Pay Now</button>
        </div>
        <form action="<?php echo $base_url.'premium-member/razorpay';?>" method="post" id="razorpay_submit" name="razorpay_submit">
            <input type="hidden" name="plan_id" id="plan_id" value="<?php if(isset($plan) && $plan!=''){echo $plan;}else if(isset($plan_id) && $plan_id!=''){echo $plan_id;}?>" >
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" >
            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php if(isset($RazorPay['key']) && $RazorPay['key']!=''){echo $RazorPay['key'];}?>" data-amount="<?php echo $planSessionData['total_pay'] * 100;?>" data-name="<?php echo $web_frienly_name;?>" data-image='<?php echo $base_url;?>assets/logo/<?php echo $upload_logo;?>'; data-theme.color="<?php echo ($colour_name!='')?$colour_name:'#ff7e00';?>"></script>
        </form>
        <?php }else if($method_name=='Instamojo'){?>
        <a href="<?php echo $base_url.'premium-member/instamojo';?>">
            <button type="button" id="Instamojo_form">Pay Now</button>
        </a>
        <!--phone pe start 28-11-2023-->
        <?php }else if($method_name=='PhonePe'){?>
            <div id='phonePe_form'>
                <form action="<?php echo $base_url;?>premium-member/phonepe" method="post" name="frmphonepe">
                    <input type="hidden" name="amount" value="<?php echo $planSessionData['total_pay'];?>">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                    <button type="submit" name="submit" title="Phonepe - The safer, easier way to pay online!">Pay Now</button>                 
                </form>
            </div>
        <?php } ?>
    <!--phone pe End -->
    </div>
</div>