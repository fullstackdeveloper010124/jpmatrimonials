
    <style>
        .cstm-logo{
        			padding: 0px 0px !important;
        			position: relative!important;
        			top: -6px!important;
        			}
                     h1{
        margin-top: 0px !important;
    }
    h2{
        margin-top: 0px !important;
    }
    </style>
    <?php $is_login = $this->common_front_model->checkLogin('return');?>
    <div class="menu-bg-new">
        <div class="container-fluid new-width">
            <div class="row mt-5">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="box-main-s">
                        <h2 class="bread-crumb Poppins-Medium" style="margin-top: -14px !important;"><a href="<?php echo $base_url.((isset($is_login) && $is_login!='')?'my-dashboard':'');?>">Home</a><span class="color-68"> / </span><span class="color-68">Advertise With Us</span></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="mega-box-new add-box-cstm">
                    <div class="m-add-box" id="advertisement_form_div">
                        <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center ab-t1">All fields are
                        <span class="color-d">mandatory</span></p>
                        <div class="alert alert-success" id="email_success_message" style="display:none"></div>
                        <div class="alert alert-danger" id="email_error_message" style="display:none"></div>
                        <form class="margin-top-5" method="post" id="advertisement_form" name="advertisement_form">		
                            <div class="add-box-2">
                                <div class="row add-b-cstm">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Advertise Name <span class="color-d f-16 select2-lbl-span">* </span>:</p>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="add-input">
                                            <input type="text" class="form-control ni-input" id="addname" name="addname" required placeholder="Enter Advertisement Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Advertise Link <span class="color-d f-16 select2-lbl-span">* </span>:</p>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="add-input">
                                            <input type="url" name="link" id="link" class="form-control ni-input" placeholder="Enter Link like https://www.google.com or http://www.google.com" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Phone <span class="color-d f-16 select2-lbl-span">* </span>:</p>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <select name="country_code" id="country_code" class="mdb-select md-form md-outline colorful-select dropdown-primary ni-input2 lk_404">
                                            <?php echo $this->common_model->country_code_opt($val);?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="add-input">
                                            <input type="text" name="phone" id="phone" placeholder="Enter Your Contact Number" class="form-control ni-input" required minlength="7" maxlength="13" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 ad-name">Contact Person <span class="color-d f-16 select2-lbl-span">* </span>:</p>
                                    </div>
                                    <div class="col-md-8 col-sm-8 col-xs-12">
                                        <div class="add-input">
                                            <input type="text" name="contact_person" id="contact_person" class="form-control ni-input" placeholder="Enter Contact Person Name" required >
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-4">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="m-captcha-code">
                                        <img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_ad_us']; ?>" alt="" style="margin-top:-10px;"/>
                                            <!-- <p class="color-f Poppins-Medium f-18">115528</p> -->
                                        </div> 
                                        
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="add-input">
                                            <input  type="number" name="code_captcha" id="code_captcha" class="form-control ni-input" placeholder="Enter Captcha Code" value="" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row add-b-cstm mt-5">
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="add-ad-btn">
                                            <button class="Poppins-Medium color-f f-18 add-w-btn">Submit</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 padding-0 padding-lr cstm-ptn">
                                        <div class="add-w-btn2">
                                            <a href="javascript:;" class="Poppins-Medium color-f f-18"  onClick="return cancel();">Reset <span class=""></span></a>	
                                                
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <input type="hidden" name="is_post" id="is_post" value="1" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
	$this->common_model->js_extra_code_fr.="
	
	if($('#advertisement_form').length > 0)
	{
		$('#advertisement_form').validate({
			rules: {
				contact_person: {
				  required: true,
				  lettersonly: true
				},
				phone: {
				  required: true,
				  number: true
				}
			 },
			submitHandler: function(form)
			{
				submit_advertisement_form();
			}
		});
	}
	function submit_advertisement_form()
	{
		var addname = $('#addname').val();
		var link = $('#link').val();
		var contact_person = $('#contact_person').val();
		var country_code = $('#country_code').val();
		var phone = $('#phone').val();
		//var file = $('#file').val();
		show_comm_mask();
		var hash_tocken_id = $('#hash_tocken_id').val();
		var code_captcha = $('#code_captcha').val();
		var base_url = $('#base_url').val();
		var url = base_url+'add_with_us/advertisement_submit';
		$('#email_success_message').hide();
		$('#email_error_message').hide();
		$.ajax({
		   url: url,
		   type:'post',
		   data: {'csrf_new_matrimonial':hash_tocken_id,'addname':addname,'link':link,'contact_person':contact_person,'country_code':country_code, 'phone':phone,'code_captcha':code_captcha},
		   dataType:'json',
		   success:function(data)
		   {
				if(data.status == 'success')
				{
					$('#email_success_message').html(data.errmessage);
					$('#email_success_message').slideDown();
					form_reset('advertisement_form');
					setTimeout(function() {
						$('#email_success_message').fadeOut('fast');
					}, 10000);
				}
				else
				{
					$('#email_error_message').html(data.errmessage);
					$('#email_error_message').slideDown();
				}
				scroll_to_div('advertisement_form_div');
				$('#hash_tocken_id').val(data.token);
			   hide_comm_mask();	
		   }
		});
		return false;
	}
	function cancel()
	{
		form_reset('advertisement_form');	
	}";
?>
    