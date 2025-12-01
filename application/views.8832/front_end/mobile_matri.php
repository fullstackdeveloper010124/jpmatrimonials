<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php if(isset($base_url) && $base_url !=''){echo $base_url;}?>">Home</a><span class="color-68"> / </span><span class="color-68">Mobile Matrimony</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
	$mobile_matri_bannner = $this->common_model->get_count_data_manual('mobile_matri_bannner',array('status'=>'APPROVED','is_deleted'=>'No'),2,'banner','id desc');
?>
<div class="container">
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-12 col-sm-12 col-xs-12 bg-new-post new-box-matri"><!--mega-box-new-->
                <div style="margin:0 auto;">
                    <div class="col-md-3 col-xs-12 col-sm-12">
                        <div id="slider" class="margin-top-10-xs slider-new">
                            <?php 
                            if(isset($mobile_matri_bannner) && $mobile_matri_bannner !='' && is_array($mobile_matri_bannner) && count($mobile_matri_bannner) > 0) {
                                $path_mobile_matri_banner = $this->common_model->path_mobile_matri_banner;
                                foreach($mobile_matri_bannner as $mobile_matri_bannner_val)
                                {
                                    if(isset($mobile_matri_bannner_val['banner']) && $mobile_matri_bannner_val['banner'] !='' && file_exists($path_mobile_matri_banner.$mobile_matri_bannner_val['banner']))
                                    {
                                        $banner_url = $base_url.$path_mobile_matri_banner.$mobile_matri_bannner_val['banner'];
										?>
										<div class="item">
											<img src="<?php echo $base_url.$path_mobile_matri_banner.$mobile_matri_bannner_val['banner']; ?>" class="img-responsive mobile-matri" alt="">
										</div>
                            		<?php
									}
								}
							}else{
                            
                            }?>
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12 col-sm-12">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <h1 class="text-white text-shadow-black text-center">Download App for lots of choices</h1>
                                <h2 class="text-white text-shadow-black text-center">Get Matrimony Apps on Mobile!</h2>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 col-xs-12 col-sm-12 main-box-mobile">
                                <h4 class="text-center" style="color:#8e7a77;"><strong>Get a link to download the Mobile app</strong>
                                </h4>
                                <h5 class="text-center" style="color:#9e9c97;"><strong><em>Search Smarter, Match Faster</em></strong></h5>
                                <hr class="colorgraph"/>
                                <form method="post" name="mobile_app_sms_form" id="mobile_app_sms_form" enctype="multipart/form-data">
								<?php
                                if($this->session->flashdata('user_log_err')){?>
                                    <div class="alert alert-danger"><?php
                                        echo $this->session->flashdata('user_log_err'); ?>
                                    </div>
                                <?php }?>
                                <div class="alert alert-danger" id="login_message" style="display:none"></div>
                                <div class="alert alert-success" id="send_sms_success" style="display:none"></div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select class="form-control" style="height:44px;" name="country_code" id="country_code" required>
                                        	<option value="">Select Country Code</option>
                                            <?php echo $this->common_model->country_code_opt('+91');?>
                                        </select>
                                    </div>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <div class="add-input-mobile">
                                            <input type="text" class="form-control ni-input" name="mobile_number" id="mobile_number" minlength="7" maxlength="13" required placeholder="Enter Your Contact Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_code']; ?>" alt="captcha code" class="dev-captcha-img" style="border-radius: 5px;" />
                                    </div>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <div class="add-input-mobile">
                                            <input type="text" class="form-control ni-input" name="code_captcha" id="code_captcha" placeholder="Enter Captcha Code" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-12 col-sm-3 col-xs-12">
                                        <div class="add-ad-btn">
                                        	<input type="submit" class="add-w-btn new-add-m Poppins-Medium color-f f-18" value="Get it Now" >
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="is_post" id="is_post" value="1" />
                                </form>
                                <div class="row row-center mt-3">
                                <div class="col-md-12 col-sm-4">
                                <img src="<?php echo $base_url;?>assets/front_end_new/images/or-icon.png" alt="" />
                                </div>
                                </div>
                                <div class="row row-center mt-3">
                                    <div class="col-md-6 col-sm-4">
                                        <?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {?>
                                        <a href="<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {echo $config_data['android_app_link'];} ?>" target="_blank">
                                            <img src="<?php echo $base_url;?>assets/front_end_new/images/app-store.png" class="img-responsive w-60-mobile" alt="">
                                        </a>
                                        <?php }?>
                                    </div>
                                    <div class="col-md-6 col-sm-8">   
                                        <?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {?><a href="<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {echo $config_data['ios_app_link'];} ?>" target="_blank">
                                            <img src="<?php echo $base_url;?>assets/front_end_new/images/app-store2.png" class="img-responsive w-60-mobile" alt="">
                                        </a>
                                        <?php }?>
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

<?php $this->common_model->js_extra_code_fr .= 'if($("#mobile_app_sms_form").length > 0)
		{
			$("#mobile_app_sms_form").validate({
				rules: {
					mobile_number: {
					  required: true,
					  number: true
					},
					code_captcha: {
					  required: true,
					  number: true
					}
				 },	
				submitHandler: function(form)
				{
					//return true;
					check_validation();
				}
			});
		}
		function check_validation()
		{
			//debugger;
			var mobile_number = $("#mobile_number").val();
			var country_code = $("#country_code").val();
			var code_captcha = $("#code_captcha").val();
			show_comm_mask();
			var hash_tocken_id = $("#hash_tocken_id").val();
			var base_url = $("#base_url").val();
			var url = base_url+"mobile-matri/send-app-sms";
			$("#send_sms_success").hide();
			$("#login_message").hide();
			$.ajax({
			   url: url,
			   type: "post",
			   data: {"country_code":country_code,"mobile_number":mobile_number,"'.$this->security->get_csrf_token_name().'":hash_tocken_id,"is_post":0,"code_captcha":code_captcha},
			   dataType:"json",
			   success:function(data)
			   {
					if(data.status == "success")
					{
						$("#send_sms_success").html(data.errmessage);
						$("#send_sms_success").slideDown();
						setTimeout(function() {
								$("#send_sms_success").fadeOut("fast");
							}, 13000);
						document.getElementById("mobile_app_sms_form").reset();
					}
					else
					{
						$("#login_message").html(data.errmessage);
						$("#login_message").slideDown();
						
					}
					$("#hash_tocken_id").val(data.token);
					hide_comm_mask();
			   }
			});
			return false;
		}
				
		
	jQuery.extend(jQuery.validator.messages, {
		maxlength: jQuery.validator.format("Please enter at least {0} numeric value."),
		minlength: jQuery.validator.format("Please enter at least {0} numeric value."),
	});';
    ?>