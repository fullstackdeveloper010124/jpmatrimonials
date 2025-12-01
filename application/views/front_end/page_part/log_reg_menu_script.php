<script src="<?php echo $base_url;?>assets/home_2/js/jquery.mCustomScrollbar.concat.min.js?v=<?php echo filemtime('assets/home_2/js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
<?php
$config_data = $this->common_model->data['config_data'];
if(isset($config_data["home_page"]) && $config_data["home_page"]!='0'){
	$home_page = $config_data["home_page"];	
}else{
	$home_page = 1;
}?>

<?php if($home_page==1){?>
	<script>
		$("#menu-toggle").click(function(e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
			$(this).find('i').toggleClass('fa-navicon fa-times')
		});
	</script>
<?php }else if($home_page==2){?>
	
	<script>
		// mobile menu start
		$(document).ready(function() {
			$("#sidebar").mCustomScrollbar({
				theme: "minimal"
			});
			
			$('#dismiss, .overlay').on('click', function() {
				$('#sidebar').removeClass('active');
				$('.overlay').removeClass('active');
			});
			
			$('#sidebarCollapse').on('click', function() {
				$('#sidebar').addClass('active');
				$('.overlay').addClass('active');
				$('.collapse.in').toggleClass('in');
				$('a[aria-expanded=true]').attr('aria-expanded', 'false');
			});
		});
		// mobile menu ends
	</script>
<?php }?>
<div class="modal fade bd-example-modal-md" id="register_model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<?php include_once("register_modal.php");?>
			</div>
		</div>
	</div>
</div>
<?php 
?>
	<!-- ===  For Firebase Web Notification Start === -->
	<!-- <script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/7.14.6/firebase-messaging.js"></script> -->
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
	<!-- FIrebase Js -->
    <script defer src="https://www.gstatic.com/firebasejs/7.19.0/firebase-auth.js"></script>
    <!-- FIrebase Js -->
	<script>
		<?php echo $config_data["notification_script"];
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
						//console.log(error);
					})
				}
				
				function sentOtpToMobile(){
					var hash_tocken_id = $("#hash_tocken_id").val();
   
					var country_code = $("#mobile_c_code").val();
				
					var mobile_number = $("#mobile").val();
					
					var base_url = $("#base_url").val();
				
					var url_req = base_url+'mobile_verification/check_number_exist';
					phoneinput = country_code+mobile_number;
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
									console.log(response);
									window.confirmationResult=response;
									$("#error_message_mv").hide();
									$("#success_message_mv").html('OTP has been sent.');
									$("#success_message_mv").show();
									$("#verify_mobile_cont").show();
   									$("#forgot_pass_form_mob").hide();
								}).catch(function(error){
									console.log(error);
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
					if(otp_mobile == ''){
						$("#error_message_mv").hide();
						$("#success_message_mv").html('Please enter OTP Sent on your mobile.');
						$("#success_message_mv").show();
						return false;
					}
					confirmationResult.confirm(otp_mobile).then(function(response){
							var userobj=response.user;
							console.log(userobj);
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
						console.log(error);
						var token = '';
						// sendOtpData(token);

					})
				}

				function sendOtpData(token){
					var hash_tocken_id = $("#hash_tocken_id").val();
					var base_url = $("#base_url").val();
					var latitude = $("#latitude").val();
	   				var longitude = $("#longitude").val();   
					var otp_mobile = $("#otp_mobile").val();
					var country_code = $("#mobile_c_code").val();
					var mobile_number = $("#mobile").val();
					mobile_number = country_code+'-'+mobile_number;
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
					show_comm_mask();
					$("#error_message_mv").hide();
					var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile+'&latitude='+latitude+'&longitude='+longitude+'&mobile_number='+mobile_number;
					$.ajax({
						url : url_req,
						type: 'post',
						data: datastring,
						dataType:"json",
						success: function(data)
						{
						if(data.status == 'al_ready_login')
						{				
							window.location.href = base_url+"my-dashboard";
							return false;
						}
						if(data.status == 'success')
						{
							$("#success_message_mv").html(data.errmessage);
							$("#success_message_mv").show();
							$("#error_message_mv").hide();
							$("#hash_tocken_id").val(data.token);
							if(data.plan_id != '' && typeof data.plan_id !== 'undefined'){
							window.location.href = base_url+"premium-member/buy-now/"+data.plan_id;
							}else{
							window.location.href = base_url+"my-profile";
							}
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
			function initializeFireBaseMessaging(){
	            messaging
	            .requestPermission()
	            .then(function () {
	                console.log('Notification Permission Granted.'); 
	                return messaging.getToken();
	            })
	            .then(function (tocken){
	                document.getElementById('tocken').value=tocken;
	            })
	            .catch(function (reason){
	                console.log(reason);
	            });
	        }
	        initializeFireBaseMessaging();
		<?php }else{
			$is_login = $this->common_front_model->checkLogin('return');
			if($is_login){
				if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !=''){
					$fav = $base_url.'assets/logo/'.$config_data['upload_logo'];
				}?>
				function initializeFireBaseMessaging(){
					messaging
					.requestPermission()
					.then(function () {
						console.log('Notification Permission Granted.'); 
						return messaging.getToken();
					})
					.then(function (tocken){
						console.log('token:'+tocken);
					})
					.catch(function (reason){
						console.log(reason);
					});
				}
				messaging.onMessage(function (payload){
					// console.log(payload);
					var notification_data = payload.data;
					if(notification_data.notification_type != 'topic_notification'){
						const notificationOption= {
							body:payload.notification.body,
							image:'<?php echo $fav;?>'
						}
					}

					if(Notification.permission=="granted" && notification_data.notification_type != 'topic_notification' && notification_data.notification_type != 'custom_chat_message_received'){
						var notification=new Notification(payload.notification.title,notificationOption);
						notification.onclick= function (ev){
							ev.preventDefault();
							if(payload.notification.click_action !=''){
								window.open(payload.notification.click_action,'_blank');
							}
							notification.close();
						}
					}
					// If Custom Chat Foreground Notification : 
					if(notification_data.notification_type == 'custom_chat_message_received'){
                        appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
                    }

					// If Topic Foreground Notification : 
					if(notification_data.notification_type == 'topic_notification'){
						getOnlineUsers(); // Make Sure This function is include in custom_chat.js
					}
			});
			var topic = "chat_topic_web";
			var fcm_server_key = "<?php echo $API_ACCESS_KEY; ?>";
			function initializeFireBaseMessaging(){
				messaging
					.requestPermission()
					.then(function () {
						console.log('Notification Permission Granted.'); 
						return messaging.getToken();
					})
					.then(function (tocken){
						// console.log('token:'+tocken);
						// Suscribe Topic : 
						// subscribeTokenToTopic(tocken,topic);
						if($('#tocken').length > 0){
							document.getElementById('tocken').value=tocken;
						}
					})
					.catch(function (reason){
						console.log(reason);
					});
			}
			messaging.onTokenRefresh(function (){
				messaging.getToken()
				.then(function (newTocken) {
					console.log('New token:'+newTocken);
				})
				.catch(function (reason){
					console.log(reason);
				})
			})
			const channel = new BroadcastChannel('sw-messages');
			channel.addEventListener('message', event => {
				var notification_data = event.data;
				// console.log('Back Ground STart');
				// console.log(notification_data);
				// console.log('Back Ground End');
				// If Custom Chat Background Notification : 
				if(notification_data.notification_type == 'custom_chat_message_received'){
					appendNewMessageReceiver(notification_data); // Make Sure This function is include in custom_chat.js
				}
				// If Topic Foreground Notification : 
				if(notification_data.notification_type == 'topic_notification'){
					getOnlineUsers(); // Make Sure This function is include in custom_chat.js
				}
			});
			//initializeFireBaseMessaging();
			// Suscribe Topic : 
			function subscribeTokenToTopic(user_tocken, topic) {
				fetch('https://iid.googleapis.com/iid/v1/'+user_tocken+'/rel/topics/'+topic, {
					method: 'POST',
					headers: new Headers({
					'Authorization': 'key='+fcm_server_key
					})
				}).then(response => {
					// console.log(response);
					if (response.status < 200 || response.status >= 400) {
					throw 'Error subscribing to topic: '+response.status + ' - ' + response.text();
					}
					// console.log('Subscribed to "'+topic+'"');
				}).catch(error => {
					// console.error(error);
				})
			}
		<?php }
	}?>
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
				
					var url_req = base_url+'my_dashboard/generate_otp';
					phoneinput = country_code+mobile_number;
					show_comm_mask();
					$.ajax({
						url : url_req,
						type: 'post',
						data: {'csrf_new_matrimonial':hash_tocken_id,'country_code':country_code,'mobile':mobile_number},
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
									$("#displ_mobile_generate").hide();
								}).catch(function(error){
									console.log(error);
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
							console.log(userobj);
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
						console.log(error);
						var token = '';
						// sendOtpDataDashboard(token);

					})
				}

				function sendOtpDataDashboard(token){
					var hash_tocken_id = $("#hash_tocken_id").val();
					var base_url = $("#base_url").val();
					var otp_mobile = $("#otp_mobile").val();
					var country_code = $("#mobile_c_code").val();
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
	</script>
	<!-- === For Firebase Web Notification End === -->

<!--===========================FreiChat START=========================-->
<!--	For uninstalling ME , first remove/comment all FreiChat related code i.e below code Then remove FreiChat tables frei_session & frei_chat if necessary The best/recommended way is using the module for installation -->
<?php
$user_data = $this->common_front_model->get_session_data();
$plan_status = '';
if(isset($user_data['id']) && $user_data['id'] !=''){
	$user_id = $user_data['id'];
}
if(isset($user_data['plan_status']) && $user_data['plan_status'] !=''){
	$plan_status = $user_data['plan_status'];
}
if($plan_status =='Paid' && isset($user_data['plan_chat']) && $user_data['plan_chat'] =='No'){
	$plan_status ='Paid_NOCHAT';
}

if(isset($user_id) && $user_id !=''){
	$ses = $user_id;
	setcookie("freichat_user", "LOGGED_IN", time()+3600, "/");
	if(!function_exists("freichatx_get_hash")){
		function freichatx_get_hash($ses){
			if(is_file("freichat/hardcode.php")){
				require "freichat/hardcode.php";
				$temp_id =  $ses . $uid;
				return md5($temp_id);
			}else{
				echo "<script>alert('module freichatx says: hardcode.php file not found!');</script>";
		   	}
		   	return 0;
		}
	}
	/* Comment Frei chat : Date : 15-11-2021
	?>
	<script src="<?php echo $base_url;?>/freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="<?php echo $base_url;?>/freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
	*/
	include_once(__DIR__.'/../custom_chat/include_css.php');
	include_once(__DIR__.'/../custom_chat/online_users.php');
	include_once(__DIR__.'/../custom_chat/firebase_js.php');
	include_once(__DIR__.'/../custom_chat/include_js.php');
?>
<?php }?>
    <input type="hidden" id="hidd_plan_status" value="<?php if(isset($plan_status) && $plan_status !=''){echo $plan_status;}?>" />
    <!--=======================FreiChatX END=====================-->
    <?php
if($is_login){
## Get Notification List 
	$member_id = $this->common_front_model->get_user_id();
	$notification_list = $this->common_front_model->get_count_data_manual('web_notification_history',array('receiver_id' => $member_id),2,'*','id DESC','');
	?>	
	<div class="notification-box hidden">
		<div class="notification-header">
			<div class="notifi-left">
				<h5>Notification</h5>
			</div>
			<div class="notifi-right">
				<span class="min_max_notification">  
					<i class="far fa-square"></i>
				</span>
			</div>
		</div>
		<div class="notifi-data hidden">
			<?php
			
				if(!empty($notification_list) && $notification_list !=''){
					foreach ($notification_list as $key => $notification) {
						$user_data = $this->common_front_model->get_count_data_manual('register',array('id' => $notification['sender_id']),1,'matri_id,photo1,photo1_approve,photo_view_status,gender','id DESC','');
						
						if($notification['sender_id']=='Admin'){
							$matri_label = "Admin";
						}else if($notification['sender_id']=='User'){
							$matri_label = "You";
						}
						else{
							$matri_label = $user_data['matri_id'];
						}
						$read_class = '';
						if($notification['status'] == 'read'){
							$read_class = 'read-notifi';
						}else{
							$read_class = 'unread-notifi';
						}
						if(isset($user_data['gender']) && $user_data['gender']=='Female'){
							$photopassword_image = $base_url.'assets/images/photopassword_female.png';
						}elseif(isset($user_data['gender']) && $user_data['gender']=='Male'){
							$photopassword_image = $base_url.'assets/images/photopassword_male.png';
						}else{
							$photopassword_image = $photopassword_image;
						}
						$path_photos = $this->common_model->path_photos;
						if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) && $user_data['photo_view_status'] == 0){
							$image = $photopassword_image;
						}else{
							$image = $this->common_model->member_photo_disp($user_data);
						}
						if($matri_label=='Admin'){
							$config_data = $this->common_model->get_site_config();
							if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
								$image = base_url().'assets/logo/'.$config_data['upload_favicon'];
							} 
						}?>
							<div class="notifi-chat <?php echo $read_class; ?>" onclick="readNotification(<?php echo $notification['id'] ?>,this,'<?php echo $notification['click_action'];?>')">
								<div class="chat-first-left">
									<img src="<?php echo $image;?>" class="img-responsive">
								</div>
								<div class="chat-left">
									<?php if($matri_label=='Admin' || $matri_label=='You'){
										?><h4><?php echo $matri_label;?></h4>
								<?php }else{
									?><a target="_blank" href="<?php echo base_url('search/view-profile/'.$user_data['matri_id']); ?>"><h4><?php echo $matri_label;?></h4></a><?php
								}?>
								</div>	
								<div class="chat-right">			
									<h6><?php echo $this->common_model->some_time_ago($notification['created_on']); ?></h6>
								</div>
								<div class="chat-left-right">
									<h5><?php echo $notification['title'] ?></h5>
								</div>
								<div class="chat-bottom">
									<p><?php echo $notification['message'] ?></p>
								</div>
							</div>
							<hr class="notifi-hr">
					<?php
					}
				}else{
					echo "No Notification.";
				}
			?>
	</div>
</div>	

	<div id="chatTabs" class="hidden">
		<ul class='bottomTabs nav nav-tabs' role='tablist'>
			<li id='chatList' class='nav-item'>
				<a class='nav-link active' data-toggle='tab' href='#ChatList' role='tab' aria-expanded='true'>
					<i class='fas fa-comments'></i> Chat
				</a>
			</li>
			<li id='notificatioList' class='nav-item active'>
				<a class='nav-link' data-toggle='tab' href='#NotificatioList' role='tab' aria-expanded='false'>
					<i class='fas fa-bell'></i> Notification
				</a>
			</li>
		</ul>
	</div>
	<!-- new -->
	<script>
		function loadChatNotification(){
			// FreiChat.min_max_freichat();
			$('#freichathead').addClass('hidden');
			$('#frei_super_minimize').next('div').addClass('hidden');
			$('#frei_super_minimize').next('div').after($('#chatTabs').html());
			$('.notificationList').html($('.notification-box').html());
		}
		function timeOutChatNotification(){
			setTimeout(() => {
				if($('#frei_user_brand').length > 0){
					loadChatNotification();
				}else{
					timeOutChatNotification();
				}
			}, 100);
		}
		$(document).ready(function(){
			setTimeout(() => {
				if($('#frei_user_brand').length > 0){
					loadChatNotification();
				}else{
					timeOutChatNotification();
				}
			}, 100);
		});
		$(document).on("click", "#chatList", function() {
			if($('.chatUserList').hasClass('hidden')){
				FreiChat.min_max_freichat();
				$('.notificationList').toggleClass('hidden');
				$('.chatUserList').toggleClass('hidden');
				$('#freichathead').removeClass('hidden');
			}
		});
		$(document).on("click", "#notificatioList", function() {
			if($('.notificationList').hasClass('hidden')){
				$('.notificationList').toggleClass('hidden');
				$('.chatUserList').toggleClass('hidden');
				$('#freichathead').addClass('hidden');
			}
		});

		$(document).on("click", ".notification-header", function() {
			$('.notifi-data').toggleClass('hidden');
			if($('.notifi-data').hasClass('hidden')){
				// <i class="far fa-square"></i>
				// <i class="far fa-window-minimize"></i>
				$('.min_max_notification').find('i').removeClass('fa-window-minimize');
				$('.min_max_notification').find('i').addClass('fa-square');
			}else{
				$('.min_max_notification').find('i').removeClass('fa-square');
				$('.min_max_notification').find('i').addClass('fa-window-minimize');
			}
		});

		// Update Notification Read Status :
		function readNotification(id,_this,url) {
			var base_url = '<?php echo base_url() ?>search/read_notification';
			var hash_tocken_id = $("#hash_tocken_id").val();
			
			if(!$(_this).hasClass('read-notifi')){
				show_comm_mask();
				$.ajax({
					url: base_url,
					type: "post",
					data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'id':id},
					success:function(data){
						var response = JSON.parse(data);
						hide_comm_mask();
						$(_this).removeClass('unread-notifi');
						$(_this).addClass('read-notifi');
						if(url!=''){
							window.open(url,'_blank');
						}
						$('#hash_tocken_id').val(response.tocken);
					}
				});
			}
		}
		function open_profile_chat(id){
			window.open('<?php echo $base_url.'search/view-profile/' ?>'+id);
		}
	</script>
<?php } ?>