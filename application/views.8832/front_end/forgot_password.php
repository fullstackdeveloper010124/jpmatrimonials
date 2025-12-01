</div>
    <div class="login-reg-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="reg-login-box">
                        <p class="calibri-Bold-font f-22 color-31">Forgot <span class="color-d"> Password</span></p>
                        <form action="<?php echo $base_url; ?>login/check-email-forgot" method="post" id="login_form" name="login_form">
                        <div class="reg-box pb-5">
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
                            <div class="alert alert-success" id="login_message_succ" style="display:none"></div>
                            
                            <div class="row-cstm">
                            
                                <div class="reg-input">
                                    
                                    <input type="email" class="form-control reg_input" required name="username" id="username" autofocus placeholder="Enter Your Email-ID">
                                </div>
                            </div>

                            <div class="row">
                                <div class="reg-input">
                                    <div class="col-md-3 col-sm-3 col-xs-6" id="captcha_login">
                                        <img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo (isset($this->session->userdata['for_captcha_code'])? $this->session->userdata['for_captcha_code']:''); ?>" style="border-radius: 6px;" alt="" />
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <a title="Change Captcha Code" href="javascript:;" onClick="change_captcha_code('captcha_login','for_captcha_code')"><i title="Change Captcha Code" class="fa fa-refresh fa-1 curser_icon"></i></a>
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-12">
                                        <input required type="number" name="code_captcha" id="code_captcha" class="form-control reg_input" placeholder="Enter Captcha" value="" /> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row-cstm pt-4">
                                <div class="e-t2">
                                        <input type="submit" class="Poppins-Medium f-17 color-f e-3_m" value="Reset Password" >
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        <input type="hidden" name="is_post" id="is_post" value="1" />
                                </div>
                            </div>
                            
                            <div class="row pull-right">
                                <div class="reg-input">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p class="Poppins-Regular color-83 f-13">
                                        <a href="<?php echo $base_url; ?>login"><span class="color-d Poppins-Medium">Login ?</span></a></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
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
}?>
<!-- ===== <div class="container">===== -->
	<script src="<?php echo $base_url; ?>assets/front_end/js/jquery.min.js?ver=1.0"></script>		
    <script src="<?php echo $base_url; ?>assets/front_end/js/bootstrap.min.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end/js/jquery.sticky.js?ver=1.4"></script>

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
$("#login_form").validate({
  submitHandler: function(form) 
  {
	check_validation();
  }
});
function check_validation()
{
    var username = $("#username").val();
	var code_captcha = $("#code_captcha").val();
    show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
    var base_url = $("#base_url").val();
    var url = base_url+"login/check_email_forgot";
	$("#log_out_succ").hide();
	$("#login_message_succ").hide();
	$("#login_message").hide();
    $.ajax({
       url: url,
       type: "post",
       data: {'username':username,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id,'is_post':0,'code_captcha':code_captcha},
       dataType:"json",
       success:function(data)
       {
            //alert(data.status);
            if(data.status == 'success')
            {
				$("#login_message_succ").html(data.errmessage);
                $("#login_message_succ").slideDown();
                ///window.location.href = base_url+"dashboard";
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
</script>
<?php include_once("page_part/log_reg_menu_script.php");?>
</body>
</html>