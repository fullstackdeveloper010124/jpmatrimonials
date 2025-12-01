<?php
$user_url = 'match_results';
$user_name_place = '';
$password_place = '';
if(isset($is_staff) && $is_staff !='' && $is_staff =='yes')
{
	$user_url = 'staff';
	$user_name_place = '';
	$password_place = '';
}
else if(isset($is_franchise) && $is_franchise !='' && $is_franchise =='yes')
{
	$user_url = 'franchise';
	$user_name_place = '';
	$password_place = '';
}
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
<body>
<?php if($check_results == 'Yes'){ 
  $user_url_n = 'check_results'; ?>
  <form id="login_form" method="post" role="form" action="<?php echo $base_url.$admin_path.'/'.$user_url_n.'/process_data';?>" class="form-layout" >
    <div class=form-inputs>
       <input type="textarea" name="sql" id="sql" class="form-control input-lg" placeholder="Enter Text" />
       <button class="btn btn-success btn-block btn-lg mb15" type="submit"> Submit </button>
    </div>
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
  </form>

<?php die; } ?>


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
              <p class="text-center mb30">
              Welcome to <?php if(isset($config_data['web_frienly_name']) && $config_data['web_frienly_name'] !=''){ echo $config_data['web_frienly_name']; } ?>. Please sign in to your account</p>
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
             <div class=form-inputs>
                <input required type="email" name="username" id="username" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($user_name_place) && $user_name_place !='') { echo $user_name_place; } ?>" />
                <input required type="password" name="password" id="password" class="form-control input-lg" placeholder="Enter Received Code" value="<?php if(isset($password_place) && $password_place !='') { echo $password_place; } ?>" />
                <div class="col-md-4 col-sm-6 col-xs-8 pl0">
                	<div id="captch_login">
                	<img src="<?php echo $base_url; ?>captcha.php?captch_code=<?php echo $this->session->userdata['captcha_code']; ?>" />
                    </div>
                </div>
                <div class="col-md-2 col-sm-4  col-xs-4 pr0" align="center">
                	<a title="Change Captcha Code" href="javascript:;" onClick="change_captcha_code('captch_login','captcha_code')"><i title="Change Captcha Code" class="fa fa-refresh fa-1 " style="font-size: 3em;margin-top:4px"></i></a>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 pr0 paddin-mobile">
                <input required type="text" name="code_captcha" id="code_captcha" class="form-control input-lg margin-login-a" placeholder="Enter Captcha Code" value="" />
                </div>
              	<button class="btn btn-success btn-block btn-lg mb15" type="submit"> Sign in </button>
             </div>
             <p> <a href="<?php echo $base_url.$admin_path.'/'.$user_url.'/forgot-password';?>">Forgot your password?</a> </p>
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
             <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url.$admin_path; ?>/" />
             <input type="hidden" id="base_url_main" value="<?php echo $base_url; ?>/" />
            </form>
          </div>
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
<script type="text/javascript">
$("#login_form").validate({
  submitHandler: function(form) 
  {
	//form.submit();
	check_validation();
  }
});
function check_validation()
{
    var username = $("#username").val();
    var password = $("#password").val();
	var code_captcha = $("#code_captcha").val();
    show_comm_mask();
    var hash_tocken_id = $("#hash_tocken_id").val();
    var base_url = $("#base_url").val();
    var url = base_url+"<?php echo $user_url; ?>/check_login";
	$("#log_out_succ").hide();
    $.ajax({
       url: url,
       type: "post",
       data: {'username':username,'password':password,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id,'is_post':0,'code_captcha':code_captcha},
       dataType:"json",
       success:function(data)
       {
            if(data.status == 'success')
            {
              window.location.href = base_url+"dashboard";
              return false;
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
$(document).ready(function(){
		setTimeout(function() {
			$('#log_out_succ').fadeOut('fast');
			}, 5000);
		});
</script>