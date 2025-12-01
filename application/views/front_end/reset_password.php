
    </div>
    <div class="login-reg-main">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <div class="reg-login-box">
                        <p class="calibri-Bold-font f-22 color-31">Reset <span class="color-d"> Password</span></p>
                        <form action="<?php echo $base_url; ?>login/reset-update" method="post" id="login_form" name="login_form">
                        <div class="reg-box pb-5">
                            <div class="alert alert-danger" id="login_message" style="display:none"></div>
				            <div class="alert alert-success" id="login_message_succ" style="display:none"></div>
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
                            <div class="row-cstm">
                                <div class="reg-input">
                                    <input type="password" class="form-control reg_input" required name="password" id="password" minlength="6" placeholder="Enter New Password">
                                </div>
                            </div>
                            <div class="row-cstm">
                                <div class="reg-input">

                                    <input type="password" class="form-control reg_input" required name="cpassword" id="cpassword" minlength="6"  placeholder="Enter Confirm New Password">
                                </div>
                            </div>
                            
                            <div class="row-cstm pt-4">
                                <div class="e-t2">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                    <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                    <input type="hidden" name="is_post" id="is_post" value="1" />
                                    <input type="submit" class="Poppins-Medium f-17 color-f e-3_m" value="Reset My Password" >
                                    <!-- <a href="information.php">
                                        <div class="Poppins-Medium f-17 color-f e-3_m">
                                            Reset My Password
                                        </div>
                                    </a> -->
                                </div>
                            </div>
                        </div>
                        </form>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="row-cstm">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="Poppins-Regular color-83 f-13 reg-footer">Already change password?
									<a href="<?php echo $base_url; ?>login"><span class="color-d Poppins-Medium">Login</span></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="lightbox-panel-mask"></div>
<div id="lightbox-panel-loader" style="text-align:center"><img alt="Please wait.." title="Please wait.." src='<?php echo $base_url; ?>assets/front_end/images/loading.gif' /></div>

<!------------------<div class="container">----End------------------------------------>
<script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.min.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/bootstrap.min.js?ver=1.0"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.sticky.js?ver=1.4"></script>
    <script type="text/javascript">
    	$("#login_form").validate({
		rules: {
			password: "required",
			cpassword: {
			  equalTo: "#password"
			}
		  },
	  submitHandler: function(form) 
	  {
		//form.submit();
		check_validation();
	  }
	});
	function check_validation()
	{
		var password = $("#password").val();
		var cpassword = $("#cpassword").val();
		show_comm_mask();
		var hash_tocken_id = $("#hash_tocken_id").val();
		var base_url = $("#base_url").val();
		var url = base_url+"login/reset-update";
		$("#login_message_succ").hide();
		$("#login_message").hide();
		$.ajax({
		   url: url,
		   type: "post",
		   data: {'password':password,'cpassword':cpassword,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id,'is_post':0},
		   dataType:"json",
		   success:function(data)
		   {
				if(data.status == 'success')
				{
					$("#login_message_succ").html(data.errmessage);
					$("#login_message_succ").slideDown();
					$("#password").val('');
					$("#cpassword").val('');
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
    <?php include_once("page_part/log_reg_menu_script.php");?>
</body>
</html>