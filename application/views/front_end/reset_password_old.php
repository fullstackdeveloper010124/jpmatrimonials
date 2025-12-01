<!------------------<div class="container">----Start---------------------------------->
    <div class="container margin-top-30" id="first_div">
        <div>
            <div class="signup-screen col-sm-4 col-sm-offset-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="bg-blue text-center form-header-title">
                            <h3 class="text-white"><i class="fa fa-lock font-18"></i> Reset Password</h3>
                        </div>
                        <form action="<?php echo $base_url; ?>login/reset-update" method="post" id="login_form" name="login_form">
                        <div class="card">
                        	<div class="alert alert-danger" id="login_message" style="display:none"></div>
				            <div class="alert alert-success" id="login_message_succ" style="display:none"></div>
                            <div class="">
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
                                <div class="col-md-12 margin-top-20">
                                    <div class="md-form font-15 margin-top-10 text-darkgrey">
                                        <label>New Password: </label>
                                        <input type="password" class="form-control" required name="password" id="password" minlength="6" />
                                    </div>
                
                                    <div class="font-16 margin-top-20 text-darkgrey">
                                        <label>Confirm New Password: <span class="tooltip_stay"><span class="text-left help-img-normal"></span> <span class="tooltiptext">Create Strong Password, user symbol like (',' & / + - *  @ # $ !)</span></span></label>
                                        <input type="password" class="font-weight-normal text-grey form-control" required name="cpassword" id="cpassword" minlength="6" />
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="margin-top-30 text-center">
                                    	<input type="submit" class="btn btn-block text-white btn-deep-purple font-13" value="Reset My Password" />
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        <input type="hidden" name="is_post" id="is_post" value="1" />
                                        <h4 class="text-center font-13"><a href="<?php echo $base_url; ?>login" class="text_slider">Login </a></h4>
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
	</body>
</html>