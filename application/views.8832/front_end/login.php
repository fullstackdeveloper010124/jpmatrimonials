</div>
<div class="login-reg-main">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12 mt-8 ">
            <div class="row">
            <div class="col-md-1 col-sm-12 col-xs-12"></div>
            <div class="col-md-5 col-sm-12 col-xs-12">
               <div class="reg-login-box">
                  <h1>
                     <p class="Poppins-Semi-Bold f-22 color-31 text-center">LOG<span class="color-d">IN</span></p>
                  </h1>
                  <form action="<?php echo $base_url; ?>login/check_login" method="post" id="login_form" name="login_form">
                     <div class="reg-box pb-3">
                        <?php
                           if($this->session->flashdata('user_log_err')){
                           	?>
                        <div class="alert alert-danger"><?php
                           echo $this->session->flashdata('user_log_err'); ?>
                        </div>
                        <?php
                           }
                           ?>
                        <div class="alert alert-danger" id="login_message" style="display:none"></div>
                        <?php
                           if($this->session->flashdata('user_log_out'))
                           {
                           ?>
                        <div class="alert alert-success" id="log_out_succ">
                           <?php echo $this->session->flashdata('user_log_out'); ?>
                        </div>
                        <?php
                           }
                           ?>
                        <div class="row-cstm">
                           <div class="reg-input">
                              <input type="text" class="form-control reg_input"  name="username" id="username" placeholder="Enter your Email ID or Matri ID">
                           </div>
                        </div>
                        <span style="margin-left: 150px;">OR</span>
                        <div class="row-cstm">
                           <div class="reg-input">
                              <div class="row">
                                 <div class="col-md-4 col-sm-5 col-xs-4">
                                    <select name="mobile_country_code" id="mobile_country_code" required  class="form-control valid" style="height:45px;">
                                       <option value="+91">+91</option>
                                       <?php echo $this->common_model->country_code_opt($val);?>
                                    </select>
                                 </div>
                                 <div class="col-md-8 col-sm-7 col-xs-8 pl-0">	
                                    <input type="text" class="form-control reg_input" name="mobileNumber" id="mobileNumber" value=""  placeholder="Enter your Mobile" >
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row-cstm">
                           <div class="reg-input reg-input-eye-password">
                              <input type="password" class="form-control reg_input" required name="password" id="password" placeholder="Enter Password">
                              <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                           </div>
                        </div>
                        <div class="row">
                           <div class="reg-input">
                           <!-- captcha_11 -->
                              <div class="col-md-3 col-sm-3 col-xs-6 " id="captcha_login">
                                 <img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_code']; ?>" style="border-radius: 6px;" alt="" />
                              </div>
                              <div class="col-md-2 col-sm-2 col-xs-6">
                                 <a title="Change Captcha Code" class="cls_change_captcha_code"  href="javascript:;" onClick="change_captcha_code('captcha_login','captcha_code')"><i title="Change Captcha Code" class="fa fa-refresh fa-1 curser_icon"></i></a>
                              </div>
                              <div class="col-md-7 col-sm-7 col-xs-12">
                                 <input required type="number" name="code_captcha" id="code_captcha" class="form-control reg_input" placeholder="Enter Captcha" value="" /> 
                              </div>
                           </div>
                        </div>
                        <div class="row pull-right">
                           <div class="reg-input">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <p class="Poppins-Regular color-83 f-13">
                                    <a href="<?php echo $base_url; ?>login/forgot-password"><span class="color-d Poppins-Medium">Forgot Password ?</span></a>
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="row-cstm pt-4">
                           <div class="e-t2 text-center">
                              <input type="submit" class="Poppins-Medium f-17 color-f e-3_m" value="Login" >
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                              <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                              <input type="hidden" name="is_post" id="is_post" value="1" />
                              <input type="hidden" name="tocken" id="tocken" value="" />
                              <input type="hidden" name="latitude" id="latitude">
							          <input type="hidden" name="longitude" id="longitude">
                           </div>
                        </div>
                     </div>
                  </form>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="row-cstm text-center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <p class="Poppins-Regular color-83 f-13 reg-footer_r">New Member?
                              <a href="<?php echo $base_url; ?>register"><span class="color-d Poppins-Medium">Register Free</span></a>
                           </p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Mobile verification start 08/10/2021 -->
            <div class="col-md-5 col-sm-12 col-xs-12">
               <div class="reg-login-box">
                  <h1>
                     <p class="Poppins-Semi-Bold f-22 color-31 text-center">LOG<span class="color-d">IN WITH OTP</span></p>
                  </h1>
				<div class="alert alert-danger" id="error_msg_f" style="display:none" > </div>
				<div class="alert alert-success" id="success_msg_f" style="display:none" ></div>
				<div class="alert alert-danger" role="alert" style="display:none;" id="error_message_mv"></div>
				<div class="alert alert-success" role="alert" style="display:none" id="success_message_mv"></div>
            <div id="recaptcha-container"></div>
				<div id="forgot_pass_form_mob" >	
				
				<form  id="forgot_pass_form" class="gen_otp"  novalidate="novalidate">
					<div class="reg-box pb-5">
						<div class="row-cstm">
						<div class="reg-input margin-top-70">
							<div class="row">
                  <div class="col-md-4 col-sm-5 col-xs-4">
								<select name="mobile_c_code" id="mobile_c_code" required  class="form-control valid" style="height:45px;">
									<option value="+91">+91</option>
									<?php echo $this->common_model->country_code_opt($val);?>
								</select>
							</div>
                     <div class="col-md-8 col-sm-7 col-xs-8 pl-0">	
								<input type="text" class="form-control reg_input" name="mobile" id="mobile" value="" required placeholder="Enter your Mobile" >
							</div>
                     </div>
						</div>
						</div>
						<div class="row-cstm pt-4">
						<div class="e-t2 text-center">
                     <?php
                     $config_data = $this->common_model->data['config_data'];
                        if(isset($config_data["is_firebase_otp"]) && $config_data["is_firebase_otp"] == 'Yes'){ ?>
                           <input id="mobile_btn" name="forgot_password" class="Poppins-Medium f-17 color-f e-3_m" value="Generate OTP" type="button" onclick="return sentOtpToMobile()" >
                        <?php }else{ ?>
                           <input id="mobile_btn" name="forgot_password" class="Poppins-Medium f-17 color-f e-3_m" value="Generate OTP" type="button" onclick="return generate_otp_verify_home()" >
                      <?php } ?>
							
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
							<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
							<input type="hidden" name="is_post" id="is_post" value="1" />
							<input type="hidden" name="tocken" id="tocken" value="" />
						</div>
						</div>
					</div>
				</form>
            <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="row-cstm text-center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <p class="Poppins-Regular color-83 f-13 reg-footer_r">New Member?
                              <a href="<?php echo $base_url; ?>register"><span class="color-d Poppins-Medium">Register Free</span></a>
                           </p>
                        </div>
                     </div>
                  </div>
				</div> 
				
				<!-- verify mobile start -->
				<div id="verify_mobile_cont" style="display: none;">	
                  <form  id="forgot_pass_form" class="ver_otp" novalidate="verify_mob1">
                     <div class="reg-box pb-5">
                        <div class="row-cstm margin-top-70 text-center">
                           <div class="reg-input">
                            <?php
                                if(isset($config_data["is_firebase_otp"]) && $config_data["is_firebase_otp"] == 'Yes'){ ?>
                                    <label style="color:red;" >Enter Your Six Digit OTP</label>
                            <?php
                                }else{ ?>
                                    <label style="color:red;" >Enter Your Four Digit OTP</label>         
                            <?php } ?>
						   
                              <div class="col-md-12 col-sm-12 col-xs-12">
								<section class="container-fluid text-center my-4">
									<div class="passcode-wrapper">
										<input class="hed" id="codeBox1" name="codeBox1" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)">
										<input class="hed"  id="codeBox2" name="codeBox2" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)">
										<input class="hed" id="codeBox3" name="codeBox3" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)">
										<input class="hed" id="codeBox4" name="codeBox4" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)">
                              <?php
                                 if(isset($config_data["is_firebase_otp"]) && $config_data["is_firebase_otp"] == 'Yes'){ ?>
                                    <input class="hed" id="codeBox5" name="codeBox5" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)">
                                    <input class="hed" id="codeBox6" name="codeBox6" type="text" size="1" minlength="1" maxlength="1" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)">
                              <?php } ?>
									</div>
								</section>
								<input id="otp_mobile" name="otp_mobile" type="hidden" placeholder="Enter OTP" class="form-control mt-2" />
                              </div>
                           </div>
                        </div>
                        <div class="row-cstm pt-4">
                           <div class="e-t2 text-center mt-3">
							  <button  id="res_btn" style="background-color:#5eb832 !important;" type="button"class="Poppins-Medium f-17 color-f e-3_m" onclick="return generate_otp_verify_home('yes')">Resend Otp</button>
							  <input type="hidden" name="latitude" id="latitude">
							  <input type="hidden" name="longitude" id="longitude">
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                              <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                              <input type="hidden" name="is_post" id="is_post" value="1" />
                              <input type="hidden" name="tocken" id="tocken" value="" />
                           </div>
                        </div>
                     </div>
                  </form>
				</div> 
				<!-- verify mobile end -->		   
                  <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="row-cstm text-center">
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<span style="display: none;" id ="is_timer" >Time left : <span id="timer" style="color: red"></span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            </div>
            <!-- Mobile verification end 08/10/2021 -->
         </div>
      </div>
   </div>
</div>
<div id="lightbox-panel-mask"></div>
<div id="lightbox-panel-loader" style="text-align:center;display:none"><img alt="Please wait.." title="Please wait.." src='<?php echo $base_url; ?>assets/front_end/images/loading.gif' /></div>
<?php
   $this->common_model->user_ip_block();
   if(base_url()!='http://192.168.1.111/mega_matrimony/original_script/'){
   	$uri_segment_check_red = $this->uri->segment(1);
   	if(isset($uri_segment_check_red) && $uri_segment_check_red!=''){
   		$uri_segment_check_red = $this->uri->segment(1);
   	}
   	else{
   		$uri_segment_check_red = basename($_SERVER['PHP_SELF']);
   	}
   	if(isset($uri_segment_check_red) && $uri_segment_check_red!='' && $uri_segment_check_red!="blocked"){
   		$details = $this->common_model->add_user_analysis();
   	}
   } 
   $client_key = "";
   if(isset($fb_detail['client_key']) && $fb_detail['client_key']!=''){
   	$client_key = $fb_detail['client_key']; 
   }
   ?>
<!-- ======== <div class="container"> End ======== -->
<script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.min.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end_new/js/bootstrap.min.js?ver=1.0"></script>
<!-- <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.sticky.js?ver=1.4"></script> -->
<script src="<?php echo $base_url; ?>assets/front_end_new/js/select2.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.validate.min.js?ver=1.0"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>
<script>
	$(document).ready(function(){
		// Get Current Lat / Long :
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showPosition);
	   }
	});
// Get Lat / Long Response : 
function showPosition(position) {
   console.log(position);
	$('#latitude').val(position.coords.latitude);
	$('#longitude').val(position.coords.longitude);
  }
</script>
<script>
   function change_captcha_code(captcha_div_id,captcha_session)
   {
   var base_url = $("#base_url").val();
   var action = base_url+'login/change_captcha';
   var hash_tocken_id = $("#hash_tocken_id").val();
   show_comm_mask();
   $.ajax({
   url: action,
   type: "post",
   data: {"csrf_new_matrimonial":hash_tocken_id,'captcha_session':captcha_session},
   success:function(data)
   {
   $("#"+captcha_div_id).html(data);
   $("#code_captcha").val('');
   hide_comm_mask();
   }
   });
   }
   if($("#login_form").length > 0)
   {
   $("#login_form").validate({
   submitHandler: function(form)
   {
   //return true;
   check_validation();
   }
   });
   }
   function check_validation()
   {
   var latitude = $("#latitude").val();
   var longitude = $("#longitude").val();   
   var username = $("#username").val();
   var mobile_country_code = $("#mobile_country_code").val();
   var mobileNumber = $("#mobileNumber").val();
   var password = $("#password").val();
   var code_captcha = $("#code_captcha").val();
   show_comm_mask();
   var hash_tocken_id = $("#hash_tocken_id").val();
   var tocken = $("#tocken").val();
   var base_url = $("#base_url").val();
   var url = base_url+"login/check-login";
   $("#log_out_succ").hide();
   $("#login_message").hide();
   $.ajax({
   url: url,
   type: "post",
   data: {'username':username,'password':password,'mobileNumber':mobileNumber,'mobile_country_code':mobile_country_code,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id,'is_post':0,'code_captcha':code_captcha,'web_device_id':tocken,'latitude':latitude,'longitude':longitude},
   dataType:"json",
   success:function(data)
   {
   if(data.status == 'al_ready_login')
   {				
   window.location.href = base_url+"my-dashboard";
   return false;
   }
   if(data.status == 'success')
   {
   $("#login_message").removeClass('alert alert-danger');
   $("#login_message").addClass('alert alert-success');
   $("#login_message").html(data.errmessage);
   $("#login_message").slideDown();
   if(data.plan_id != ''){
   window.location.href = base_url+"premium-member/buy-now/"+data.plan_id;
   }else{
   window.location.href = base_url+"my-profile";
   }
   return false;
   }
   else
   {
   $("#login_message").html(data.errmessage);
   $("#login_message").slideDown();
   $("#hash_tocken_id").val(data.token);
   $(".cls_change_captcha_code").click();
   }
   hide_comm_mask();
   }
   });
   return false;
   }
   $(document).ready(function(){
   setTimeout(function() {
   $('#log_out_succ').fadeOut('fast');
   }, 10000);
   });
   $("#menu-toggle").click(function(e) {
   e.preventDefault();
   $("#wrapper").toggleClass("toggled");
   $(this).find('i').toggleClass('fa-navicon fa-times')
   });
   $(document).ready(function() {
   $('.js-example-basic-single').select2();
   });
</script>

<!-- Mobile verification start 08/10/2021-->
<script>
   $(document ).ready(function() {
       $("#is_timer").hide();
   });	
   function timer_on_otp()
   {
   	let timerOn = true;
   		
   function timer(remaining) {
     var m = Math.floor(remaining / 60);
   
     var s = remaining % 60;
     
     m = m < 10 ? '0' + m : m;
     s = s < 10 ? '0' + s : s;
     document.getElementById('timer').innerHTML = m + ':' + s;
     remaining -= 1;
     
     if(remaining >= 0 && timerOn) {
       setTimeout(function() {
           timer(remaining);
       }, 1000);
       return;
     }
   
     if(!timerOn) {
       // Do validate stuff here
       return;
     }
     
     // Do timeout stuff here
   //   alert('Timeout for otp');
   $("#res_btn").show();
   $("#is_timer").hide();
   }
   
   timer(30);
   }	
   
   
</script>
<!-- Generate otp -->
<?php
if(!isset($config_data["is_firebase_otp"]) || $config_data["is_firebase_otp"] != 'Yes'){ ?>

<script>
  
   function generate_otp_verify_home(is_resend='')
   {
      
      if(is_resend == 'yes')
      {
      $("#is_timer").show();
      $("#res_btn").hide();
      timer_on_otp();
      }
   	var hash_tocken_id = $("#hash_tocken_id").val();
   
   	var country_code = $("#mobile_c_code").val();
   
   	var mobile_number = $("#mobile").val();
    
   	var base_url = $("#base_url").val();
   
   	var url_req = base_url+'mobile_verification/generate_otp_home';

   	show_comm_mask();
   	$.ajax({
   		url : url_req,
   		type: 'post',
   		data: {'csrf_new_matrimonial':hash_tocken_id,'country_code':country_code,'mobile_number':mobile_number},
   		dataType:"json",
   		success: function(data)
   		{
   			update_tocken(data.tocken);
   			if(data.status == 'success')
   			{
   				$("#error_message_mv").hide();
   				$("#success_message_mv").html(data.error_meessage);
   				$("#success_message_mv").show();
   				$("#resend_link").hide();
   				setTimeout(function(){ $("#resend_link").show();},20000);
   				$("#verify_mobile_cont").show();
   				$("#forgot_pass_form_mob").hide();
   			}
   			else
   			{
               $('.gen_otp').trigger("reset");
   				$("#success_message_mv").hide();
   				$("#error_message_mv").html(data.error_meessage);
   				$("#error_message_mv").show();
   			}
   			hide_comm_mask();
   			setTimeout(function(){
   		        $('#error_message_mv').hide();
   		        $('#success_message_mv').hide();
   		    }, 5000);
   		}
   	});
   }
   
   function varify_mobile_check_home()
   {
   	var hash_tocken_id = $("#hash_tocken_id").val();
   	var base_url = $("#base_url").val();
	   var latitude = $("#latitude").val();
	   var longitude = $("#longitude").val();   
   	var url_req = base_url+'mobile_verification/varify_mobile_check_otp_home';
   	// var otp_mobile = $("#otp_mobile").val();
      var otp_mobile = '';
     
   	if(otp_mobile ==''){
   		var codeBox1 = $("#codeBox1").val();
   		var codeBox2 = $("#codeBox2").val();
   		var codeBox3 = $("#codeBox3").val();
   		var codeBox4 = $("#codeBox4").val();
   
   		$("#otp_mobile").val(codeBox1+codeBox2+codeBox3+codeBox4);
   		var otp_mobile = $("#otp_mobile").val();
   	}
   	if(otp_mobile =='')
   	{
   		$("#error_message_mv").html("Please enter OTP Sent on your mobile.");
   		$("#error_message_mv").show();
   		$("#success_message_mv").hide();
   		return false;
   	}
   	show_comm_mask();
   	$("#error_message_mv").hide();
   	var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile+'&latitude='+latitude+'&longitude='+longitude;
   	$.ajax({
   		url : url_req,
   		type: 'post',
   		data: datastring,
   		dataType:"json",
   		success: function(data)
   		{
   
   			update_tocken(data.tocken);
   			if(data.status== 'success')
   			{
               var email = data.email;
               var cpass = data.cpass;
               $('.ver_otp').trigger("reset");
   				$("#verify_mobile_cont").hide();
   				$("#error_message_mv").hide();
   				$("#success_message_mv").html(data.error_meessage);
   				$("#success_message_mv").show();
                setTimeout(function(){ $("#success_message_mv").hide();},20000);
  
                window.location.href = base_url+"my-dashboard";
   			}
   
   			else
   			{
				
   				$('.ver_otp').trigger("reset");
   				$("#success_message_f").hide();
   				$("#error_message_mv").html(data.error_meessage);
   				$("#error_message_mv").show();
   			
   			}
   			hide_comm_mask();
   		}
   	});
   }
   function getCodeBoxElement(index) {
   return document.getElementById("codeBox" + index);
   }
   function onKeyUpEvent(index, event) {
   const eventCode = event.which || event.keyCode;
   if (getCodeBoxElement(index).value.length === 1) {
      if (index !== 4) {
         getCodeBoxElement(index+ 1).focus();
      } else {
         getCodeBoxElement(index).blur();
         varify_mobile_check_home();
      }
   }
   if (eventCode === 8 && index !== 1) {
      getCodeBoxElement(index - 1).focus();
   }
   }
   function onFocusEvent(index) {
   for (item = 1; item < index; item++) {
      const currentElement = getCodeBoxElement(item);
      if (!currentElement.value) {
           currentElement.focus();
           break;
      }
   }
   }
</script>
<?php } ?>


<script>
   
    function update_tocken(tocken)
    {
        $(".hash_tocken_id").each(function()
        {
        $(this).val(tocken);
        })
    }
</script>
<!-- For generate Otp End -->

<!-- Mobile verification end 08/10/2021-->

<?php include_once("page_part/log_reg_menu_script.php");?>
</body>
</html>