<?php
$gender = $this->common_front_model->get_session_data('gender');
$path_photos = $this->common_model->path_photos;
if($gender == 'Male'){
	$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
}
else{
	$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
}
if(isset($this->common_model->photo_upload_count)){
	$photo_upload_count = $this->common_model->photo_upload_count;
}
if($photo_upload_count =='' || $photo_upload_count ==0 || $photo_upload_count > 8){
	$photo_upload_count = 8;
}
$photo_view_status = 1;
if(isset($register_data['photo_view_status']) && $register_data['photo_view_status'] !=''){
	$photo_view_status = $register_data['photo_view_status'];
}
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
                    <div class="design-process-content das-content-2  padding-0">
                        <div class="box-view-profile">
                            <p class="Poppins-Semi-Bold mega-n3 f-20 text-center">UPLOAD <span class="mega-n4 f-20">PHOTO</span></p>
						</div>
						<hr class="hr-view">
                        <div class="box-view-profile">
                            <div class="row mt-3">
                                <div class="col-md-6 col-xs-12 col-sm-8">
                                    <select class="form-control select-cust-photo" style="height:44px;" id="view_photo" name="view_photo" onChange="update_photo_status()">
                                        <option <?php if(isset($photo_view_status) && $photo_view_status == 1){ echo 'selected';} ?> value="1" selected>View To All</option>
                                        <option <?php if(isset($photo_view_status) && $photo_view_status == 0){ echo 'selected';} ?> value="0" >Hide For All</option>
                                        <option <?php if(isset($photo_view_status) && $photo_view_status == 2){ echo 'selected';} ?> value="2" >Only For Upgrade Members</option>
                                    </select>
                                    <p class="mt-2 f-12"><b>Note: </b> Photo must be in .JPG, .GIF or .PNG format, not larger than 3 MB.</p>
                                </div>
                                <div class="col-md-6 col-xs-12 col-sm-4">
                                    <div class="pull-right float-none" data-toggle="modal" data-target="#myModal_pic" onClick="set_photo_number(1)">
                                        <label class="add-w-btn new-id-s-photo btn-file  Poppins-Regular f-14 color-f">
                                            <i class="fas fa-upload"></i> Upload Photo 
                                        </label>
                                        <p class="f-12">Upload Your Profile Picture Here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
				
            <div class="row mt-4">
                <div class="col-md-12 col-xs-12 col-sm-12 padding-zero">
                    <div class="design-process-content-photo das-content-2  padding-0">
                        <div class="box-view-profile">
                            <div class="row mt-3">
                                <input type="hidden" id="defult_photo_url" value="<?php echo $defult_photo; ?>" />
                                <?php
								for($ij=1;$ij<=$photo_upload_count;$ij++){
                                    $photo_clm = 'photo'.$ij;?>
									<div class="col-md-3 col-xs-6 col-sm-3">
										<div class="box-uplad-photo">
										<?php if(isset($register_data[$photo_clm]) && $register_data[$photo_clm] !='' && file_exists($path_photos.$register_data[$photo_clm])){?>
                                        <img id="member_photo_<?php echo $ij; ?>" src="<?php echo $base_url.$path_photos.$register_data[$photo_clm];?>" class="img-responsive" />
										<?php }
										else{ ?>
                                        	<img id="member_photo_<?php echo $ij; ?>" src="<?php echo $defult_photo;?>" class="img-responsive" />
										<?php } ?>
                                        <button class="add-w-btn new-photo-edit color-f f-16 Poppins-Medium" data-toggle="dropdown" onClick="return show_btn()" aria-expanded="false"><i class="fas fa-cog"></i>  Action </button>
                                            
                                        <ul class="dropdown-menu dropdown-menu-photo">
                                            
										<?php
										$display_del = 'none';
										if(isset($register_data[$photo_clm]) && $register_data[$photo_clm] !='' && file_exists($path_photos.$register_data[$photo_clm])){
											$display_del='';
										}
                                        ?>
                                        <li onClick="set_photo_number('<?php echo $ij; ?>')" data-toggle="modal" data-target="#myModal_pic" ><a href="#"> Edit</a></li>
                                        <li id="photo_delete_btn_<?php echo $ij; ?>" style="display:<?php echo $display_del; ?>" onClick="set_photo_number_del('<?php echo $ij; ?>')"><a href="javascript:;" data-toggle="modal" data-target="#myModal_delete"> Delete</a></li>
                                        <li id="photo_profile_btn_<?php echo $ij; ?>" style="display:<?php echo $display_del; ?>" onClick="set_profile_pic('<?php echo $ij; ?>')" ><a href="javascript:;">Set As Profile Pic</a></li>
                                       </ul>
                                    </div>
                                </div>
                                <?php if($ij%4 == 0){?>
                                </div>
                                <div class="row mt-3">
                                <?php }
                            }?>
                        	</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="myModal_pic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_pic" aria-hidden="true">
    <div class="modal-dialog modal-dialog-photo-crop">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Upload <span class="mega-n4 f-s">Image</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="container_photo">
                    <div class="row">
                        <div class="col-md-12" style="padding:10px;">
                            <div id="response_message"></div>
                        </div>
                    </div>
                    <div class="imageBox" style="display:none">
                        <div class="mask"></div>
                        <div class="thumbBox"></div>
                        <div class="spinner" style="display: none">Loading...</div>
                    </div>
                    <div class="tools clearfix">
                        <div class="upload-wapper color-f f-16 ">
                            <i class="fas fa-images"></i> Browse 
                            <input type="file" id="upload_file" value="Upload" />
                        </div>
                        <span class="show_btn color-f f-16" id="rotateLeft"><i class="fa fa-undo" aria-hidden="true"></i>Rotate Left</span>
                        <span class="show_btn color-f f-16" id="rotateRight"><i class="fa fa-repeat" aria-hidden="true"></i>Rotate Right</span>
                        <span class="show_btn color-f f-16" id="zoomOut"><i class="fas fa-search-plus"></i> zoom In</span>
                        <span class="show_btn color-f f-16" id="zoomIn"><i class="fas fa-search-minus"></i> zoom Out</span>
                        
                        <span class="show_btn cropmobileset" id="crop" style="background-color: rgb(7, 90, 133); display: inline;"><i class="fas fa-crop"></i> Crop & Upload</span>
                        <input type="hidden" id="croped_base64" name="croped_base64" value="" />
                        <input type="hidden" id="orig_base64" name="orig_base64" value="" />
                        <input type="hidden" id="photo_number" name="photo_number" value="" />
                    </div>
                    <span class="show_btn">Drag image and select proper image</span>
                    <div class="tools clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-12 padding-zero text-center crop_img_11" style="padding: 0px 36.4%">
                        <div id="croped_img"></div>
                    </div>
                </div>
            
           		<div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <!-- <button onClick="update_photo()" id="upload_btn" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Upload</button> -->
                            <!-- <button id="crop" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18" style="width: 140px;">Crop & Upload</button> -->
                            <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                        </span>
                    </div>
                </div>
        	</div>
        </div>
    </div>
</div>

<div id="myModal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Delete This Saved <span class="mega-n4 f-s">Profile Picture</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
	            <div id="delete_photo_message"></div>
				<div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure you want to Remove this Profile Picture?</strong><br />
                        <span class="small">This Profile Picture will be Deleted Permanently from your saved Profile Picture.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <div id="delete_button">
                                <button onClick="delete_photo()" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
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
function show_btn(){
	$('#upload_btn').hide();
}
var config = {
	'.chosen-select' : {},
	'.chosen-select-deselect' : {allow_single_deselect:true},
	'.chosen-select-no-single' : {disable_search_threshold:10},
	'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
	'.chosen-select-width' : {width:'100%'}
}
for (var selector in config) {
	$(selector).chosen(config[selector]);
}
";
?>