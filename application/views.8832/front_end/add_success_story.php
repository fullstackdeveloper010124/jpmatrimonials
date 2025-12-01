<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Tell Us Your Story</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="box-main-s">
                    <!-- <p class="Poppins-Semi-Bold mega-n3 f-s">Tell Us Your <span class="mega-n4 f-s">Story</span></p> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container new-width">
    <div class="row mt-3">
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div class="mega-box-new">
                <div class="m-add-box">
                    <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center ab-t1">Give us details of you & your
                    <span class="color-d">partner</span></p>
                    <div class="add-box-2">
                    <form action="<?php echo $base_url;?>success-story/save-story" method="post" name="success_story_form" id="success_story_form" enctype="multipart/form-data">

                        <div id="add_success"></div> 
                        <div class="row add-b-cstm mt-4">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">Bride's Name <span class="color-d f-16 select2-lbl-span">*</span> :</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <input type="text" name="bridename" id="bridename" required class="form-control ni-input"  placeholder="Bride's Name">
                                </div>
                            </div>
                        </div>
                        <div class="row add-b-cstm mt-4">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">Groom's Name <span class="color-d f-16 select2-lbl-span">*</span> :</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <input type="text" class="form-control ni-input" name="groomname" id="groomname" placeholder="Groom's Name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row add-b-cstm mt-4">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">Marriage Date <span class="color-d f-16 select2-lbl-span">*</span> :</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <input type="text" name="marriagedate" class="form-control ni-input" id="marriagedate" placeholder="Marriage Date" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row add-b-cstm mt-4">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">How You Meet <span class="color-d f-16 select2-lbl-span">*</span> :</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <textarea class="form-control" name="successmessage" rows="8" placeholder="Tell us how you meet each other on <?php if(isset($config_data['website_title'])) {echo $config_data['website_title'];}?>." required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row add-b-cstm mt-4">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">Wedding Photo <span class="color-d f-16 select2-lbl-span">*</span> :</p>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <input type="file" extension="jpg|png|jpeg|gif|bmp" value="Upload Photo" name="weddingphoto" id="weddingphoto" class="form-control new-chose" required />
                                    <label class="jpg-formate">&nbsp;&nbsp;Allowed File type jpg | png | jpeg | gif | bmp.&nbsp;&nbsp;</label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-b-cstm mt-3">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <div class="add-input">
                                    <div class="checkboxes">
                                        <label class="checkbox">
                                            <input type="checkbox" value="yes" name="terms_condition" id="terms_condition" checked >
                                            <span class="indicator"></span>
                                            I accept licence <a target="_blank" href="<?php echo $base_url;?>terms-condition" class="text-decoration-none">Terms And Conditions</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row add-b-cstm mt-5">
                            <div class="col-md-3 col-sm-3 col-xs-12">
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="add-ad-btn">
                                	<input type="submit" class="add-w-btn Poppins-Medium color-f f-18" value="Submit">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                    </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
            <?php echo $this->common_model->display_advertise('Level 2');?>
            <div class="mega-box-new bg-new-post">
                <h1 class="text-center advert-text advert-shade-regular  advert-shade-regular-2">Thank you for sharing 
                your Story with us!</h1>
            </div>
        </div>
    </div>
</div>
<?php 
$year=date("Y");
$day_mnth=date("d-m");
$this->common_model->js_extra_code_fr .="
$( document ).ready(function() {
    setTimeout(function(){
        $('#flash-messages1').hide();
        $('#flash-messages2').hide();
        $('#flash-messages3').hide();
        $('#flash-messages4').hide();
    }, 5000);
	
	$('#marriagedate').Zebra_DatePicker({
		format: 'd-m-Y',
		direction: [false, '".$day_mnth."-".$year."'],
	});
});
if($('#success_story_form').length > 0)
{
    $('#success_story_form').validate({
        rules: {
            groomname: {
              required: true,
              lettersonly: true
            },
            bridename: {
              required: true,
              lettersonly: true
            }
        },
        submitHandler: function(form)
        {
			if($('#terms_condition').prop('checked')==false){
				alert('Please Accept Terms and Condition');
				$('#terms_condition').focus();
				return false;
			}
			var form_data = new FormData(document.getElementById('success_story_form'));
			var action = $('#success_story_form').attr('action');
			show_comm_mask();
			$.ajax({
			    url: action,
                type: 'POST',
                data: form_data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
			    success:function(data)
				{
					$('#add_success').removeClass('alert alert-success alert-danger');
					$('#add_success').html(data.errmessage);
					$('#add_success').slideDown();
					update_tocken(data.tocken);
					hide_comm_mask();
					if(data.status == 'success')
					{
						$('#add_success').addClass('alert alert-success');
						document.getElementById('success_story_form').reset();
					}
					else
					{
						$('#add_success').addClass('alert alert-danger');
					}
				}
			});
			return false;
        }
    });
}
function check_bride_groom(matri_id,type)
{	
    var hash_tocken_id = $('#hash_tocken_id').val();
    $.ajax({
        url: '".$base_url.'success-story/check_bride_groom'."',
        type: 'post',
        data: {'csrf_new_matrimonial':hash_tocken_id,'type':type,'matri_id':matri_id},
        dataType:'json',
        success: function(data)
        { 	
            if(data.status == 'success')
            {	
                if(type == 'Female')
                {	
                     $(ferror).hide();
                     $('#bridename').val(data.username);
                }
                else if(type == 'Male')
                {
                    $(merror).hide();
                    $('#groomname').val(data.username);
                }
                return false;
            }
            if(data.status == 'error')
            {	
                if(type == 'Female')
                {	
                    $(ferror).show();
                    $('#bridename').val('');
                }
                else if(type == 'Male')
                {	
                    $(merror).show();
                    $('#groomname').val('');
                }
                return false;
            }
        }
    }); 
    return false;
}";?>