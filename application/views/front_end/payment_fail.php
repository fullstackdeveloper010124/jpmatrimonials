<div class="container container-fluid new-width" id="prt_pref_default">
    <div class="row mt-3">
        <div class="col-md-8 col-xs-12 col-sm-12">
            <div class="part-pref-box">
                <div class="payment_success_mail mt-5">
                    <img src="<?php echo $base_url;?>assets/front_end_new/images/payment_failed.png" alt="" class="img-responsive payment_icon">
                    <p class="Poppins-Regular f-18 payment_text color-40 text-center">Payment Failed!</p>
                    <p class="Poppins-Regular f-14 payment_text2 color-68 text-center">
                        Your payment was failed. Please try after sometime.
                    </p>
                    <a href="<?php echo $base_url; ?>premium-member" class="payment_s_btn upgrade_fail_btn Poppins-Medium f-16 color-f">Upgrade Your Membership</a>
                </div> 
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs">
            <?php $limit = 3;
			$class1 = 'Prf_sidebar-new-mac';
            include_once('featured_rightsidebar.php');?>
        </div>
    </div>
</div>