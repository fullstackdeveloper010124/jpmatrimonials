<?php
$user_url = 'login';
$user_name_place = '';
$password_place = '';

?>
<!DOCTYPE html>
<html class=no-js>
<head>
<meta charset=utf-8>
<title><?php if(isset($config_data['web_frienly_name']) && $config_data['web_frienly_name'] !=''){ echo $config_data['web_frienly_name']; } ?> - Login</title>
<meta name=viewport content="width=device-width">
<?php if(isset($config_data['favicon']) && $config_data['favicon'] !=''){
?>
<link rel="shortcut icon" href="<?php echo $base_url.'assets/logo/'.$config_data['favicon']; ?>">
<?php } 
$data_session = $this->session->userdata('matrimonial_user_data');
?>
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/styles/app.min.df5e9cc9.css">
<link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/vendor/select2/select2.min.css">
 <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
.box-tab .nav-tabs li.active a, .box-tab .nav-tabs li.active a:hover { color: #fff; font-weight: bold; background:#3b77b5!important; border-top-left-radius: 10px; border-top-right-radius: 10px;}
.select2{width:100% !important}
.select2-container--default .select2-selection--multiple {background-color: white;border: 1px solid #e4e4e4;border-radius: 4px;cursor: text;}
.select2-container--default.select2-container--focus .select2-selection--multiple {border: solid #0ac2ff 1px;outline: 0;}
.select2-container--default .select2-selection--single{background-color: #fff;border: 1px solid #e4e4e4;border-radius: 4px;}
.select2-container .select2-selection--single .select2-selection__rendered {display: block;padding-left: 12px;padding-right: 20px;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 3px;}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {box-sizing: border-box;list-style: none;margin: 0;padding: 0 12px;width: 100%;}
.select2-container .select2-selection--single{box-sizing: border-box;cursor: pointer;display: block;height: 46px;user-select: none;-webkit-user-select: none;}
.float-left{float:left!important;}
.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height: 46px;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 1px;
    right: 10px;
    bottom: 0;
    margin: auto;
}
.btnbtn-sm-back
{
    margin-top: 20px;
    border: 1px solid gray;
    border-radius: 10px;
    /* justify-content: center; */
    /* align-content: center; */
    padding: 5px 30px;
    clear: both;

}
#btnbtn-sm-back
{
    display:none;
}
.btnbtn-sm-verify
{
    height: 40px;
    width: 100%;
    background: #ef462e;
    color: white !important;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: auto;
    position: relative;
    top: 17px;
    border-radius: 8px;
    border: none;
}
.btnbtn-sm-verify .green{
    background-color:green;
}
.back_login-flex{
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 0px 83px;
    gap: 15px;
}
.hed
{
    border: 1px solid #cfc5c5;
    height: 32px;
    width: 40px;
    text-align: center;
}
.verify_mobile_cont{
  padding-top: 10px;
  height: 140px;
  border: 1px solid #d1cccc;
}
@media only screen and (max-device-width: 570px) {
    .back_login-flex{
    padding: 0px 30px;
}
   .mobile_padding-00,
   .border-box{
       padding-left: 0px !important;
       padding-right: 0px !important;
   }
}

.border-box
{
    border: 1px #cfc5c5 solid;
    height: 139px;
    padding: 10px;
}
.btn-verify
{
    background-color:#2ecc71;
}

#country_code.select2-container .select2-selection {
  height: 40px;  /* Adjust to your desired height */
  padding: 5px 10px;  /* Optional: Adjust padding inside the select */
  font-size: 16px;  /* Optional: Change font size */
}

 #country_code.select2-container .select2-results__options {
      max-height: 300px; /* Adjust the max height of the dropdown */
      overflow-y: auto;  /* Add scroll if the options exceed the height */
    }
    
    
</style>
<body>
<div class="app layout-fixed-header bg-white usersession">
  <div class=full-height>
    <div class=center-wrapper>
      <div class=center-content>
        <div class="row no-margin">
          <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
              
              
                		 

              
            <form id="login_form" method="post" role="form" action="<?php echo $base_url.$admin_path.'/'.$user_url.'/check_login';?>" class="form-layout" ><!--onSubmit="return check_validation()"-->
            	<input type="hidden" name="is_post" id="is_post" value="1" />
              <div class="text-center mb15"> 
              <?php 
			  if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !=''){ ?>
              <img src="<?php echo $base_url.'assets/logo/'.$config_data['upload_logo']; ?>" class="img-responsive" style="margin: 0 auto;" /> 
              <?php
			  }
			  else
			  {
				  echo $config_data['web_frienly_name'];
			  }
			  ?>
              </div>
              <p class="text-center mb30"><b>Enter mobile number to create admin login</b></p>
             	<?php
					if($this->session->flashdata('user_log_err'))
					{
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


<!-- Nasir FirebaseOtp Input Hidden Start -->
                <div class="alert alert-danger" id="error_msg_f" style="display:none" > </div>
                <div class="alert alert-success" id="success_msg_f" style="display:none" ></div>
                <div class="alert alert-danger" role="alert" style="display:none;" id="error_message_mv"></div>
                <div class="alert alert-success" role="alert" style="display:none" id="success_message_mv"></div>
                <div id="recaptcha-container"></div>
                <div id="forgot_pass_form_mob" >	

<!-- Nasir FirebaseOtp Input Hidden End -->

             <div class=form-inputs>
             
             
             <?php 
                $where_country_code= " ( is_deleted ='No' ) GROUP BY country_code";
				$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'id,country_code,country_name','','','',"");
		?>
      			
             
             	 <div class="col-md-6 col-sm-6 col-xs-12 pl0">
                	<select name="country_code" id="country_code" required class="form-control select2 input-lg" >
                   
                    <optgroup label="---------Top Countries--------">
                    
                    <option value="+1">+1- United States/Canada</option>
               		<option value="+44">+44 - United Kingdom</option>
                    <option value="+971">+971- United Arab Emirate</option>
               	 	<option value="+61">+61- Australia</option>
               	 	<option value="+64">+64 - New Zealand</option>
                	<option value="+91" selected>+91- India</option>
               
                 
                 <optgroup label="---------All Countries--------">
                 
                    <?php
                    foreach($country_code_arr as $country_code_arr)
                    {	
						if (!in_array($country_code_arr['id'], array(2,12,91,36,44,95,156,215)))
						{
							?>
							<option value="<?php echo $country_code_arr['country_code'];?>"><?php echo $country_code_arr['country_code'].' - '.$country_code_arr['country_name'];?></option>
							<?php
						}
                    }
					?>
                    </select>
                  </div>  
              
              <div class="col-md-6 col-sm-6 col-xs-12 pr0 paddin-mobile">
                <input required type="text" name="mobile" id="mobile" class="form-control input-lg" placeholder="Your Mobile Number" value="<?php if(isset($user_name_place) && $user_name_place !='') { echo $user_name_place; } ?>" />
              </div> 
               
               
                <div class="col-md-4 col-sm-6 col-xs-12 pl0">
                	<img src="<?php echo $base_url; ?>captcha.php?captch_code=<?php echo $this->session->userdata['captcha_code']; ?>" />
                </div>
                
                
                <div class="col-md-8 col-sm-6 col-xs-12 pr0 paddin-mobile">
                <input required type="text" name="code_captcha" id="code_captcha" class="form-control input-lg" placeholder="Enter Captcha Code" value="" />
                </div>
                <!-- Nasir FirebaseOtp Button Start -->
                <?php
                     $config_data = $this->common_model->data['config_data'];
                        if(isset($config_data["is_firebase_otp"]) && $config_data["is_firebase_otp"] == 'Yes'){ ?>
                           <input id="mobile_btn" name="forgot_password" class="Poppins-Medium f-17 color-f e-3_m btn btn-success btn-block btn-lg mb15" value="Generate OTP" type="button" onclick="return sentOtpToMobile()" >
                        <?php }else{ ?>
                           <input id="mobile_btn" name="forgot_password" class="Poppins-Medium f-17 color-f e-3_m btn btn-success btn-block btn-lg mb15" value="Generate OTP" type="button" onclick="return sentOtpToMobile()" >
                      <?php } ?>
                  <!-- Nasir FirebaseOtp Button End -->
              
             </div>
             <p class="text-danger"><b> If you have any problem for login, please feel free to contact us on : +91-9662802018/+91-9978423453 or info@narjisinfotech.com</b></p>
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
             <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url.$admin_path; ?>/" />
            </form>
            
            </div>
            
            
            
            	<!-- verify mobile start -->
                  <div id="verify_mobile_cont" class="border-box" style="display: none; ">	
                  <form  id="forgot_pass_form" class="ver_otp" novalidate="verify_mob1">
                     <div class="reg-box pb-5">
                        <div class="row-cstm margin-top-70 text-center">
                           <div class="reg-input">
                            <?php
                                if(isset($config_data["is_firebase_otp"]) && $config_data["is_firebase_otp"] == 'Yes'){ ?>
                                    <label style="color:#736d6d;" >Enter Your Six Digit OTP</label>
                            <?php
                                }else{ ?>
                                    <label style="color:#736d6d;" >Enter Your Four Digit OTP</label>         
                            <?php } ?>
						   
                              <div class="col-md-12 col-sm-12 col-xs-12">
								<section class="container-fluid text-center mobile_padding-00 my-4">
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
							  <button  id="res_btn" style="background-color:#5eb832 !important; display:none;" type="button"class="Poppins-Medium f-17 color-f e-3_m" onclick="return generate_otp_verify_home('yes')">Resend Otp</button>
							  <input type="hidden" name="latitude" id="latitude">
							  <input type="hidden" name="longitude" id="longitude">
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                              <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                              <input type="hidden" name="is_post" id="is_post" value="1" />
                              <input type="hidden" name="tocken" id="tocken" value="" />
                           </div>
                           
                            <div class="back_login-flex">
                                <button type="button" class="btnbtn-sm-verify btn-verify" onclick="varify_mobile_check_home();"> Verify And Login</button>
                            </div>
                           
                               
                        </div>
                     </div>
              
                     
                  </form>
				</div> 

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row-cstm text-center">
                <div class="col-md-12 col-sm-12 col-xs-12">
                     <span style="display: none;" id ="is_timer" >Time left : <span id="timer" style="color: red"></span></span>
                </div>
            </div>
          </div>

        <div class="col-md-12 col-sm-12 col-xs-12" id="btnbtn-sm-back">
            <div class="row-cstm text-center">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;">
                     <a href="<?php echo $base_url; ?>control-panel/login" class="btnbtn-sm-back" > Back</a>
                </div>
            </div>
          </div>

				<!-- verify mobile end -->
            
            
            
            
            
        </div>
      </div>
    </div>
  </div>
</div>
<div id="lightbox-panel-mask"></div>
<div id="lightbox-panel-loader" style="text-align:center"><img alt="Please wait.." title="Please wait.." src='<?php echo $base_url; ?>assets/back_end/images/loading.gif' /></div>
<script src="<?php echo $base_url; ?>assets/back_end/scripts/app.min.4fc8dd6e.js"></script>
<script src="<?php echo $base_url; ?>assets/back_end/scripts/common.js?ver=<?php echo filemtime('assets/back_end/scripts/common.js');?>"></script>
<script src="<?php echo $base_url; ?>assets/back_end/vendor/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="<?php echo $base_url; ?>assets/back_end/vendor/select2/select2.min.js"></script>

<script type="text/javascript">
//$( "#country_code" ).select2();


$("#login_form").validate({
  submitHandler: function(form) 
  {
	//form.submit();
	check_validation();
  }
});

function firebase_OTP(){


}



function check_validation()
{
  var country_code = $("#country_code").val();
  var mobile = $("#mobile").val();
	var code_captcha = $("#code_captcha").val();
    show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
    var base_url = $("#base_url").val();
    var url = base_url+"<?php echo $user_url; ?>/generate_otp_request";
	$("#log_out_succ").hide();
    $.ajax({
       url: url,
       type: "post",
       data: {'country_code':country_code,'mobile':mobile,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id,'is_post':0,'code_captcha':code_captcha},
       dataType:"json",
       success:function(data)
       {  
        
            
            if(data.status == 'success')
            {
                alert(data.errmessage);
                window.location.href = base_url+"login/login-form";
                return false;
               // window.location.href = base_url+"dashboard";
              //  return false;
            }
            else
            {
                $("#login_message").html(data.errmessage);
                $("#login_message").slideDown();
                $("#hash_tocken_id").val(data.token);
            }
            hide_comm_mask();
       }
    });
    return false;
}
</script>









<!-- Nasir FirebaseOtp Start JS -->






                

<?php
$config_data = $this->common_model->data['config_data'];
?>


 <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
    <script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>

    <script>
		<?php 
		echo $config_data["notification_script"];
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		if($this->router->fetch_class()=='login'){?>
			var is_firebase_otp = '<?php echo $config_data["is_firebase_otp"]; ?>';
			// Start OTP Login
			if(is_firebase_otp == 'Yes'){
				firebase.app(); // if already initialized, use that one
				// Onload get mobile number and sent otp 

				var verifyotp=document.getElementById("verifyotp");
				var inputOtp=document.getElementById("inputOtp");
				var resendOtp=document.getElementById("resendOtp");
				// resendOtp.onclick=function(){
				// 	resentOtpToMobile();   //call sent OTP function
				// }
				function resentOtpToMobile(){
					var country_code = $('#country_code').val(); // get hidden mobile number 
   					var mobile = $('#mobile').val(); // get Country Code
					phoneinput = country_code+mobile;
					
					var cverify=window.recaptchaVerifier;

					firebase.auth().signInWithPhoneNumber(phoneinput,cverify).then(function(response){
						window.confirmationResult=response;
						$("#error_message_mv").hide();
						$("#success_message_mv").html('OTP Sent on your mobile.');
						$("#success_message_mv").show();
						return false;
					}).catch(function(error){
				// 		console.log(error);
					})
				}
				
				function sentOtpToMobile(){
					var hash_tocken_id = $("#hash_tocken_id").val();
   
					var country_code = $("#country_code").val();
				
					var mobile_number = $("#mobile").val();
					
					var base_url = $("#base_url").val();
					
					var code_captcha = $("#code_captcha").val();
					
			
					var url_req = base_url+'mobile_verification/check_number_exist';
					phoneinput = country_code+mobile_number;
          // alert(phoneinput);
					show_comm_mask();
					$.ajax({
						url : url_req,
						type: 'post',
						data: {'csrf_new_matrimonial':hash_tocken_id,'country_code':country_code,'mobile_number':mobile_number,'code_captcha':code_captcha},
						dataType:"json",
						success: function(data)
						{
							update_tocken(data.tocken);
							if(data.status == 'success')
							{
								window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
									'size': 'invisible',
									'callback': function(response) {
										// reCAPTCHA solved, allow signInWithPhoneNumber.
										// ...
									},
									'expired-callback': function() {
										// Response expired. Ask user to solve reCAPTCHA again.
										// ...
									}
								});

								var cverify=window.recaptchaVerifier;
								firebase.auth().signInWithPhoneNumber(phoneinput,cverify).then(function(response){
								// 	console.log(response);
									window.confirmationResult=response;
									$("#error_message_mv").hide();
									$("#success_message_mv").html('OTP has been sent.');
									$("#success_message_mv").show();
									$("#verify_mobile_cont").show();
									$("#btnbtn-sm-back").show();
   									$("#forgot_pass_form_mob").hide();
								}).catch(function(error){
								// 	console.log(error);
									$("#success_message_mv").hide();
									$("#error_message_mv").html('OTP Not sent.');
									$("#error_message_mv").show();
								})
							}
							else
							{   
                                $('.gen_otp').trigger("reset");
								$("#success_message_mv").hide();
								$("#error_message_mv").html(data.error_meessage);
								$("#error_message_mv").show();
							}
							setTimeout(function(){
								$('#error_message_mv').hide();
								$('#success_message_mv').hide();
                                hide_comm_mask();
							}, 5000);
						}
					});
				}
				// On verify click send 
				function getCodeBoxElement(index) {
					return document.getElementById("codeBox" + index);
					}
					function onKeyUpEvent(index, event) {
					const eventCode = event.which || event.keyCode;
					if (getCodeBoxElement(index).value.length === 1) {
						if (index !== 6) {
							getCodeBoxElement(index+ 1).focus();
						} else {
							getCodeBoxElement(index).blur();
				// 			varify_mobile_check_home();
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
				
				function varify_mobile_check_home(){
					var otp_mobile = '';
					if(otp_mobile ==''){
						var codeBox1 = $("#codeBox1").val();
						var codeBox2 = $("#codeBox2").val();
						var codeBox3 = $("#codeBox3").val();
						var codeBox4 = $("#codeBox4").val();
						var codeBox5 = $("#codeBox5").val();
						var codeBox6 = $("#codeBox6").val();
				
						$("#otp_mobile").val(codeBox1+codeBox2+codeBox3+codeBox4+codeBox5+codeBox6);
						var otp_mobile = $("#otp_mobile").val();
					}
                    show_comm_mask();
					if(otp_mobile == ''){
						$("#error_message_mv").hide();
						$("#success_message_mv").html('Please enter OTP Sent on your mobile.');
						$("#success_message_mv").show();
						return false;
					}
					confirmationResult.confirm(otp_mobile).then(function(response){
						var userobj=response.user;
						//	console.log(userobj);
						var token=userobj.xa;
						// var provider="phone";
						// var email=phoneinput.value;
						if(token!=null && token!=undefined && token!=""){
							sendOtpData(token);
						}else{
							var token = '';
							sendOtpData(token);
						}
					})
					.catch(function(error){
				// 		console.log(error);
						var token = '';
						// sendOtpData(token);
                        $("#error_message_mv").html(error.message);
                        $("#error_message_mv").show();
                        $("#success_message_mv").hide();
                        hide_comm_mask();
					})
				}

				function sendOtpData(token){
					var hash_tocken_id = $("#hash_tocken_id").val();
					var base_url = $("#base_url").val();
					var latitude = $("#latitude").val();
	   				var longitude = $("#longitude").val();   
					var otp_mobile = $("#otp_mobile").val();
					var country_code = $("#country_code").val();
					var mobile_number = $("#mobile").val();
					mobile_number = country_code+'-'+mobile_number;
				// 	alert(otp_mobile);
					var url_req = base_url+"mobile_verification/login_with_mobile_otp";
					$("#log_out_succ").hide();
   					$("#login_message").hide();
					if(token =='')
					{
						$("#error_message_mv").html("Please enter Valid OTP sent on your mobile number.");
						$("#error_message_mv").show();
						$("#success_message_mv").hide();
						return false;
					}
					
					$("#error_message_mv").hide();
					var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile+'&latitude='+latitude+'&longitude='+longitude+'&mobile_number='+mobile_number;
					$.ajax({
                        url : url_req,
                        type: 'post',
                        data: datastring,
                        dataType:"json",
                        success: function(data)
                        {
                          //  console.log(data);
                            if(data.status == 'al_ready_login')
                            {				
                              window.location.href = base_url+"my-dashboard";
                              return false;
                            }
                            if(data.status == 'success')
                            {
                              window.location.href = base_url+"dashboard";              
                              return false;
                            }
                            else
                            {
                              $("#error_message_mv").html(data.errmessage);
                              $("#error_message_mv").show();
                              $("#success_message_mv").hide();
                              $("#hash_tocken_id").val(data.token);
                            }
                            hide_comm_mask();
                        }
					});
				}
			}
			// End OTP Login
// 			function initializeFireBaseMessaging(){
// 	            messaging
// 	            .requestPermission()
// 	            .then(function () {
// 	                console.log('Notification Permission Granted.'); 
// 	                return messaging.getToken();
// 	            })
// 	            .then(function (tocken){
// 	                document.getElementById('tocken').value=tocken;
// 	            })
// 	            .catch(function (reason){
// 	                console.log(reason);
// 	            });
// 	        }
// 	        initializeFireBaseMessaging();
		<?php } ?>
	<?php
	## For Verify Mobile Firebase : Date : 10-06-2022
	if($this->router->fetch_class()=='my_dashboard' || $this->router->fetch_class()=='my_profile'){ ?>
		var is_firebase_otp = '<?php echo $config_data["is_firebase_otp"]; ?>';
		// Start OTP Login
		if(is_firebase_otp == 'Yes'){
				firebase.app();
				function resentOtpToMobile(){
					var country_code = $('#country_code').val(); // get hidden mobile number 
   					var mobile = $('#mobile_number_verify').val(); // get Country Code
					phoneinput = country_code+mobile;
					
					var cverify=window.recaptchaVerifier;

					firebase.auth().signInWithPhoneNumber(phoneinput,cverify).then(function(response){
						window.confirmationResult=response;
						$("#error_message_mv").hide();
						$("#success_message_mv").html('OTP Sent on your mobile.');
						$("#success_message_mv").show();
						return false;
					}).catch(function(error){
						//console.log(error);
					})
				}
				
				function sentOtpToMobile(){
					var hash_tocken_id = $("#hash_tocken_id").val();
   
					var country_code = $("#country_code").val();
				
					var mobile_number = $("#mobile_number_verify").val();
					
					var base_url = $("#base_url").val();
					
					var code_captcha = $("#code_captcha").val();
				
					var url_req = base_url+'my_dashboard/generate_otp';
					phoneinput = country_code+mobile_number;
					show_comm_mask();
					$.ajax({
						url : url_req,
						type: 'post',
						data: {'csrf_new_matrimonial':hash_tocken_id,'country_code':country_code,'mobile':mobile_number,'code_captcha':code_captcha},
						dataType:"json",
						success: function(data)
						{
							update_tocken(data.tocken);
							if(data.status == 'success')
							{
								window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
									'size': 'invisible',
									'callback': function(response) {
										// reCAPTCHA solved, allow signInWithPhoneNumber.
										// ...
									},
									'expired-callback': function() {
										// Response expired. Ask user to solve reCAPTCHA again.
										// ...
									}
								});

								var cverify=window.recaptchaVerifier;

								firebase.auth().signInWithPhoneNumber(phoneinput,cverify).then(function(response){
									// console.log(response);
									window.confirmationResult=response;
									$("#error_message_mv").hide();
									$("#success_message_mv").html('OTP has been sent.');
									$("#success_message_mv").show();
									$("#resend_link").hide();
									setTimeout(function() { $("#resend_link").show(); }, 20000);
									$("#verify_mobile_cont").show();
									$("#btnbtn-sm-back").show();
									$("#displ_mobile_generate").hide();
								}).catch(function(error){
								// 	console.log(error);
									$("#success_message_mv").hide();
									$("#error_message_mv").html('OTP Not sent.');
									$("#error_message_mv").show();
								})
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
				
				function varify_mobile_check_dashboard(){
					var otp_mobile = '';
					if(otp_mobile ==''){
						var otp_mobile = $("#otp_mobile").val();
					}
					if(otp_mobile == ''){
						$("#error_message_mv").hide();
						$("#success_message_mv").html('Please enter OTP Sent on your mobile.');
						$("#success_message_mv").show();
						return false;
					}
					confirmationResult.confirm(otp_mobile).then(function(response){

							var userobj=response.user;
							//console.log(userobj);
							var token=userobj.xa;
							// var provider="phone";
							// var email=phoneinput.value;
							if(token!=null && token!=undefined && token!=""){
								sendOtpDataDashboard(token);
							}else{
								var token = '';
								sendOtpDataDashboard(token);
							}
					})
					.catch(function(error){
				// 		console.log(error);
						var token = '';
						// sendOtpDataDashboard(token);

					})
				}

				function sendOtpDataDashboard(token){
					var hash_tocken_id = $("#hash_tocken_id").val();
					var base_url = $("#base_url").val();
					var otp_mobile = $("#otp_mobile").val();
					var country_code = $("#country_code").val();
					var mobile_number = $("#mobile").val();
					mobile_number = country_code+'-'+mobile_number;
					var url_req = base_url+"my_dashboard/varify_mobile_check_otp";
					$("#log_out_succ").hide();
   					$("#login_message").hide();
					if(token =='')
					{
						$("#error_message_mv").html("Please enter Valid OTP sent on your mobile number.");
						$("#error_message_mv").show();
						$("#success_message_mv").hide();
						return false;
					}
					show_comm_mask();
					$("#error_message_mv").hide();
					var datastring = 'csrf_new_matrimonial='+hash_tocken_id;
					$.ajax({
						url : url_req,
						type: 'post',
						data: datastring,
						dataType:"json",
						success: function(data)
						{
						hide_comm_mask();
						update_tocken(data.tocken);
						if(data.status == 'success')
						{
							$("#verify_mobile_cont").hide();
							$("#btnbtn-sm-back").hide();
							$("#error_message_mv").hide();
							$("#success_message_mv").html(data.error_meessage);
							$("#success_message_mv").show();
							$("#close_buttonn_div").show();
							return false;
						}
						else
						{
							$("#success_message_mv").hide();
							$("#error_message_mv").html(data.error_meessage);
							$("#error_message_mv").show();
						}
						hide_comm_mask();
						}
					});
				}
			}
	<?php } ?>
	
	$("#code_captcha").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#mobile_btn").click();
        }
    });
    
    $("#mobile").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#code_captcha").focus();
        }
    });
    
    $(document).ready(function() {
      $('#country_code').select2();
    });
    
	</script>
<!-- Nasir FirebaseOtp End Js -->