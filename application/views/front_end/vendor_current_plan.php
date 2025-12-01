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
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Current Plan</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
            </div>
        </div>
    </div>
</div>

<?php 
$email = '';
$plan_status = '';
$plan_activated = $plan_expired = $current_plan = $plan_duration =  $plan_amount = $currency = '';
if(isset($vendor_data) && $vendor_data != ''){
	$plan_status = $vendor_data['plan_status'];
}
if(isset($payment_data) && $payment_data != ''){
	$plan_activated = $payment_data['plan_activated'];
	$plan_expired = $payment_data['plan_expired'];
	$plan_duration = $payment_data['plan_duration'];
	$current_plan = $payment_data['current_plan'];
	$plan_amount = $payment_data['plan_amount'];
	$currency = $payment_data['currency'];
}
 $today_date = $this->common_model->getCurrentDate('Y-m-d');
?>

<div class="container new-width">
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="e-detail-box prld-zero">
                <h3 class="text-center Poppins-Semi-Bold font-size-20" style="padding: 18px 0px 6px;"> Boosted Plan</h3>
                <hr class="hr-plan"/>
                <div class="box-center-event">    
                 <div class="row">
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        
                    </div>
                   <div class="col-md-5 col-xs-12 col-sm-12">
                        <div class="box-new new-width-plan-event">
                            <div class="box-new-padding-2">                                 
                                <h4>Your Current Plan</h4>                                
                                <div class="current-plan-box" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #f9f9f9;">
                                    <p><strong>Plan :</strong> Boosted Plan – <?php echo $currency.' '.$plan_amount; ?>/month</p>
                                    <p><strong>Status :</strong> 
                                    <?php 
                                        if($current_plan == 'Yes' && $plan_expired >= $today_date && $plan_status == 'Paid'){
                                    ?>
                                        <span style="color: #29be29ff; font-weight: bold;">Active</span>
                                    <?php }else{ ?>
                                        <span style="color: #85451bff; font-weight: bold;">Expired</span>
                                    <?php } ?>
                                    </p>
                                    <p><strong>Plan Duration :</strong> <?php echo $this->common_model->display_data_na($plan_duration).' Days'; ?></p>
                                    <p><strong>Plan Activated On :</strong> <?php echo $this->common_model->displayDate($plan_activated,'F j, Y'); ?></p>
                                    <p><strong>Plan Expired On :</strong> <?php echo $this->common_model->displayDate($plan_expired,'F j, Y'); ?></p>                                                                        
                                    <p><strong>Visibility:</strong> Your business is currently boosted and getting extra exposure.</p>   

                                    <?php 
                                        if($plan_status == 'Expired'){
                                    ?>
                                        <a href="<?php echo base_url() ?>vendor-payment-option" class="btn btn-danger btn-sm" style="margin-top: 10px;">Update Membership</a>                                        
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                </div>
            </div>
        </div>
	</div>
</div>
