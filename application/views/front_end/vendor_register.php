<?php
$gender_male_checked = "";
$gender_female_checked = "";
// $_REQUEST['gender'] == "Female" ? $gender_female_checked = "checked" : $gender_male_checked = "checked" ;
$gender_female_checked = (isset($_REQUEST['gender']) && $_REQUEST['gender'] == "Female") ? "checked" : ""; $gender_male_checked = !isset($_REQUEST['gender']) || $_REQUEST['gender'] != "Female" ? "checked" : "";
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http").'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$franchise_by = $this->common_model->get_count_data_manual('franchise',array('referral_link'=>$url,'status'=>'APPROVED','is_deleted'=>'No'),1,'*','','');
$birth_date = '';
?>
    <div class="">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center margin-bottom-35">
                    <div style="width: 450px;" class="reg-login-box"  id=""><h1>
                        <p class="calibri-Bold-font f-22 color-31">VENDOR <span class="color-d"> REGISTER</span></p></h1>

                        <form method="post" id="vendor_register" name="vendor_register" action="<?php echo $base_url; ?>vendor-saveregister">
                        <div style="width: 411px; padding-top:12px;" class="reg-box pb-2">
                            <div class="clearfix"></div>
                            <div id="reponse_message_step1" style="margin-bottom: 0px;"></div>
                            <div class="clearfix"></div>
                            <?php
                            if($this->session->flashdata('error_message'))
                            {
                            ?>
                            <div class="alert alert-danger"><?php
                                echo $this->session->flashdata('error_message'); ?>
                            </div>
                            <?php
                                }
                            ?>
							<div class="row-cstm">
                                <div class="reg-input">
                                    <input type="text" class="form-control reg_input" required name="planner_name" id="planner_name" value="" placeholder="Vendor Name">                                                                            
                                </div>
                            </div>
							<div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-5">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 pl-0 pr-0">
                                        <div class="reg-input">
                                            <input type="text" class="form-control reg_input" onkeydown="return /[a-z ]/i.test(event.key)" required name="title" id="title" value="" placeholder="Enter name of the business">                                
                                            <input type="hidden" name="is_post" value="1" />
                                        </div>
                                    </div>                               
                                </div>
                            </div>						
                            <div class="row-cstm ">
                                <div class="reg-input">
                                    <select class="form-control select-cust select2" required name="category_id" id="category_id">
										<option value="">Select services provided</option>
										<?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('vendor_category'));?>
                                    </select>
                                </div>
                            </div>	
                            <div class="row-cstm">
                                <div class="reg-input">
                                    <input type="email" class="form-control reg_input" required name="email" id="email" value="" placeholder="Enter your Email ID">                                                                            
                                </div>
                            </div>
                            <div class="row">
								<div class="reg-input">
									<div class="col-md-4 col-sm-4 col-xs-4" id="country_codes">
											<select style="width:100%;" name="country_code" id="country_code" required style="height:44px;" class="form-control valid">
												<?php if(isset($_REQUEST['country_code']) && $_REQUEST['country_code'] !=''){  $val=$_REQUEST['country_code'];}else{  $val='';}?>
												<option value="">Select Country Code</option>
												<?php echo $this->common_model->country_code_opt($val);?>
											</select>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-8">
											<input type="number" class="form-control reg_input mtc-10" required name="mobile_number" id="mobile_number" placeholder="Enter Your Mobile No" minlength="7" maxlength="13" value="<?php if(isset($_REQUEST['mobile_number']) && $_REQUEST['mobile_number']!=''){ echo $_REQUEST['mobile_number'];}?>"/>
									</div>
								</div>
                            </div>
							<div class="row-cstm">
								<div class="reg-input reg-input-eye-password" >
                                    <input type="password" class="form-control reg_input"  required name="password" id="password" minlength="8" value="" placeholder="Create a Password"/>
									<span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                </div>
                            </div>
						    <div class="row-cstm">
                                <div class="reg-input">
                                    <select class="form-control select-cust select2" required name="country_id" id="country_id" onChange="dropdownChange('country_id','state_id','state_list')" style="width:100%;">
										<option value="">Select Country</option>
										<?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('country_master'));?>
                                    </select>
                                </div>
                            </div>
                            <div class="row-cstm">
                                <div class="reg-input">
                                    <select class="form-control select-cust select2" required name="state_id" id="state_id" style="width:100%;" onChange="dropdownChange('state_id','city_id','city_list')">
                                        <option value="">Select State/Province</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row-cstm">
                                <div class="reg-input">
                                    <select class="form-control select-cust select2" required name="city_id" id="city_id" style="width:100%;">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="row-cstm">
                                <div class="reg-input">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea id="address" class="p-textarea cstm-textarea" cols="25" rows="6" placeholder="Address" name="address" required aria-required="true" aria-invalid="false"></textarea>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row-cstm">
                                <div class="reg-input">
                                    <input type="search" class="form-control reg_input" required name="website" id="website" value="" placeholder="Enter your website">                                                                            
                                </div>
                            </div>
							<?php
								$captcha = $this->common_model->generateCaptcha('loginCode');
							?>
							<!-- <div class="row">
								<div class="reg-input">
									<div class="col-md-4 col-sm-4 col-xs-6 " id="captchaImg">
										<?php echo $captcha['image']; ?>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-6">
										<i class="fa fa-refresh fa-1 curser_icon" id="refreshCaptcha" role="button" aria-hidden="true"></i>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input maxlength="6" id="captcha_code" name="captcha_code" type="number" class="form-control reg_input" required>
									</div>
								</div>
							</div> -->
                            <div class="row-cstm"><h2>
                                <div class="e-t2">
                                <button style="margin-top:0px;" class="Poppins-Medium f-17 color-f e-3_m" id="data">Register</button>              
                                </div></h2>
                            </div>
                        </div>
							<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />                           
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        </form>       
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="clearfix"></div>

	<!-- ========= <div class="container"> End =========-->
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.min.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/bootstrap.min.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.sticky.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/select2.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/common.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/additional-methods.min.js?ver=1.0"></script>
	<script>

		$(document).ready(function() {
			$('select').select2();
			$('.js-example-basic-single').select2();
		});
		// mujib jquery 13 digit mobile number for validation
		$("#mobile_number").on("keypress", function(e) {
			var $this = $(this);
			var regex = new RegExp("^[0-9\b]+$");
			var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
			// for 10 digit number only
			if ($this.val().length > 12) {
				e.preventDefault();
				return false;
			}
			if (e.charCode < 10 && e.charCode > 47) {
				if ($this.val().length == 0) {
					e.preventDefault();
					return false;
				} else {
					return true;
				}

			}
			if (regex.test(str)) {
				return true;
			}
			e.preventDefault();
			return false;
		});

	if($("#vendor_register").length > 0)
	{
		$("#vendor_register").validate({
			rules: {
				firstname: {
				  required: true,
				  lettersonly: true
				},
				lastname: {
				  required: true,
				  lettersonly: true
				},
			 },
			submitHandler: function(form)
			{
				//return true;
				var form_data = $('#vendor_register').serialize();
				form_data = form_data+ "&is_post=0";
				var action = $('#vendor_register').attr('action');
				show_comm_mask();
				$.ajax({
				   url: action,
				   type: "post",
				   dataType:"json",
				   data: form_data,
				   success:function(data)
				   {
					   $("#reponse_message_step1").removeClass('alert alert-success alert-danger');
						$("#reponse_message_step1").html(data.errmessage);
						$("#reponse_message_step1").slideDown();
						update_tocken(data.tocken);
						hide_comm_mask();
						if(data.status == 'success')
						{
							is_reload_page = 1;
							$("#reponse_message_step1").addClass('alert alert-success');
							document.getElementById('vendor_register').reset();
							var red_url = '';
						}
						else
						{
							$("#reponse_message_step1").addClass('alert alert-danger');
							$('#refreshCaptcha').click();
						}
				   }
				});
				return false;
			}
		});
	}

	$('#refreshCaptcha').click(function(){
		var action = $('#base_url').val()+'register/refreshCaptcha';
		var hash_tocken_id = $("#hash_tocken_id").val();
		$.ajax({
			url: action,
			type: "post",
			dataType : "json",
			data: {'csrf_new_matrimonial': hash_tocken_id},
			success:function(data)
			{
				update_tocken(data.token);
				hide_comm_mask();
				if(data.status == 'success'){
					$('#captchaImg').html(data.data.image);
					$('#captcha_code').val('');
				}else{
					$("#reponse_message_step1").removeClass('alert alert-success alert-danger');
					$("#reponse_message_step1").html(data.errmessage);
					$("#reponse_message_step1").slideDown();
					$("#reponse_message_step1").addClass('alert alert-danger');
				}
			}
		});
	});

	$('#captcha_code').on('input', function() {
        let value = $(this).val();
        value = value.replace(/\D/g, '');
        if (value.length > 6) {
            value = value.substring(0, 6);
        }
        $(this).val(value);
    });
	</script>

	<div class="clearfix"></div>
	<div id="lightbox-panel-loader" style="text-align:center;display:none;">
		<img alt="Please wait.." title="Please wait.." src="<?php echo $base_url; ?>assets/front_end/images/loading.gif" />
	</div>
	</body>
</html>
