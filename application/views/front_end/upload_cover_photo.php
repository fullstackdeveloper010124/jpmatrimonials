<?php
$gender = $this->common_front_model->get_session_data('gender');
$path_cover_photo = $this->common_model->path_cover_photo;
if(isset($register_data['cover_photo']) && $register_data['cover_photo'] !='')
{
    $cover_photo = $register_data['cover_photo'];
}
$cover_defult_photo = $base_url.$path_cover_photo."cover_photo1.png";
?>
<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php include_once('my_dashboard_info.php');?>
            <div class="row mt-4">
					<div class="col-md-12 col-xs-12 col-sm-12 padding-zero">
						<div class="design-process-content-photo das-content-2  padding-0">
							<div class="box-view-profile">
								<p class="Poppins-Semi-Bold mega-n3 f-20 text-center"> UPLOAD <span class="mega-n4 f-20"> COVER PHOTO </span></p>
							</div>
							<hr class="hr-view">
							<div class="box-view-profile">
								<div class="row mt-3">
									<div class="col-md-12 col-xs-12 col-sm-4">
										<form method="post" name="cover_photo_form" id="cover_photo_form" enctype="multipart/form-data" action="<?php echo $base_url; ?>upload/upload-cover-photo" >
											<div class="reponse_photo"></div>
											<label class="add-w-btn new-id-s-photo btn-file upload-horoscope Poppins-Regular f-14 color-f">
												<i class="fas fa-upload"></i> Upload Cover Photo 
                                                <input type="file" style="display: none;" id="cover_photo" name="cover_photo">
											</label>
											<p class="mt-2 f-12 text-center"><b>Note:-</b>Photo must be in .JPG, .GIF or .PNG format, not larger than 3MB.)<br>The optimal size for cover photo is 1,110 x 370 pixels.</p>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
											
											<input type="hidden" name="is_post" value="1" />
											<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        </form>
									</div>
								</div>
							</div>
							<hr class="hr-view">
							<div class="box-view-profile">
								<div class="row mt-3" style="margin-bottom:10px;">
									<div class="col-md-12 col-xs-12 col-sm-4">
										<input type="hidden" id="defult_photo_url" name="defult_photo_url" value="<?php echo $cover_defult_photo; ?>" />
                                        <?php if(isset($cover_photo) &&  $cover_photo!=''){}else{?>
	                                        <div class="text-center" id="no_cover_msg">
                                            	<h4 class="text-darkgrey">No Cover Image available</h4>
                                            </div>
                                        <?php }?>
                                        <div class="card">
                                            <div class="card-body">
                                                <?php if(isset($cover_photo) &&  $cover_photo!=''){?>
                                                    <img id="blah" src="<?php echo $base_url.$path_cover_photo.$cover_photo;?>" class="blah border img-responsive" class="img-responsive brd-raduis-img" alt=""/>
                                                <?php }else{?>
                                                    <img id="blah" src="<?php echo $cover_defult_photo;?>" class="blah border img-responsive" class="img-responsive brd-raduis-img" alt=""/>
                                                <?php }?>
                                            </div>
                                        </div>
									</div>
								</div>
                                <?php
                                $display_del = 'none';
                                if(isset($cover_photo) &&  $cover_photo!=''){
                                    $display_del='';
                                }?>
								<div class="row mt-" style="margin-bottom:10px;">
									<p onClick="set_cover_photo_del()" id="photo_delete_btn" style="display:<?php echo $display_del; ?>;" class="text-center Poppins-Semi-Bold f-16"> <a href="#" data-target="#deleet_cover_photo" data-toggle="modal" class="color-d"> <i class="fas fa-trash-alt color-d"></i> Delete Cover Photo</a> </p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
<!-- ==== Cover Photo Modal ========= -->
	
<div id="deleet_cover_photo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal color-modal">
                <p class="Poppins-Semi-Bold mega-n3 horoscope-modal text-center color-f"> Delete This Saved Cover Photo</p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style=" margin-top: -37px !important;color:#fff;">×</button>
            </div>
            <div class="modal-body">
	            <div id="delete_photo_message"></div>
				<div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure you want to Remove this cover Photo?</strong><br />
                        <span class="small">This Cover Photo will be Deleted Permanently.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <div id="delete_button">
                                <button onClick="delete_cover_photo()" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                            </div>
                            <div id="delete_button_close" style="display:none;">
                            	<button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->common_model->js_extra_code_fr.="
    
$('#cover_photo').on('change', function(e)
{
    var reader = new FileReader();
    var size = this.files[0].size;
    var name = this.files[0].name;
    var size_mb = size/(1024*1024);
    if(size_mb > 3.1)
    {
        alert('Please Upload max file upload upto 3MB');
        $('#cover_photo').val('');
        return false;
    }
    else
    {
        var ext = $('#cover_photo').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg','bmp']) == -1)
        {
            alert( 'Please upload valid image file like png, jpg ,jpeg ,bmp and gif.');
            $('#cover_photo').val('');
            return false;
        }
        else
        {
            var after_upload_url = window.URL.createObjectURL(this.files[0]);
            var form_data = new FormData(document.getElementById('cover_photo_form'));
            var action = $('#cover_photo_form').attr('action');
            show_comm_mask();
            $.ajax({
                url: action,
                type: 'POST',
                data: form_data,
                cache: false,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data)
                { 	
                    $('.reponse_photo').removeClass('alert alert-success alert-danger alert-warning');
                    $('.reponse_photo').html(data.errmessage);
                    $('.reponse_photo').slideDown();

                    if(data.status == 'success')
                    {
                        $('.reponse_photo').addClass('alert alert-success');
                        setTimeout(function() {
                        $('.reponse_photo').fadeOut('fast');
                        }, 4000);
                        $('#hash_tocken_id_temp').remove();
                        $('#photo_delete_btn').show();
                        $('#no_cover_msg').hide();
                        document.getElementById('blah').src = after_upload_url;
                    }
                    else
                    {
                        $('.reponse_photo').addClass('alert alert-danger');
                    }
                    update_tocken(data.tocken);
                    hide_comm_mask();
                    $('#cover_photo').val('');
                }
            });
        }
    }
})
function set_cover_photo_del()
{
    $('#delete_photo_alt').show();
    $('#delete_photo_message').hide();
    $('#delete_photo_message').html('');
    $('#delete_button').show();
    $('#delete_button_close').hide();
    $('#no_cover_msg').hide();
}
function delete_cover_photo()
{
    $('#delete_photo_message').removeClass('alert alert-success alert-danger alert-warning');
    $('#delete_photo_message').html('');

    var base_url = $('#base_url').val();
    var hash_tocken_id = $('#hash_tocken_id').val();
    var url_load = base_url+ 'upload/delete-cover-photo';
    show_comm_mask();
    $.ajax({
        url: url_load,
        type: 'post',
        dataType:'json',
        data: {'csrf_new_matrimonial':hash_tocken_id,'delete_cover_photo':'delete'},
        success:function(data)
        {
            $('#delete_photo_message').html(data.errmessage);
            $('#delete_photo_message').slideDown();
            if(data.status =='success')
            {
                $('#delete_photo_message').addClass('alert alert-success');
                $('#blah').attr('src',$('#defult_photo_url').val());
                $('#delete_photo_alt').hide();
                $('#delete_button_close').show();
                $('#delete_button').hide();
                $('#photo_delete_btn').hide();
                $('#no_cover_msg').show();
            }
            else
            {
                $('#delete_photo_message').addClass('alert alert-danger');
            }
            update_tocken(data.tocken);
            hide_comm_mask();
        }
	});
}
";
?>