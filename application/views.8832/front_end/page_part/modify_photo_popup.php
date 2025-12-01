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
                        <span class="show_btn color-f f-16" id="rotateLeft"><i class="fa fa-undo" aria-hidden="true"></i>
 Rotate Left</span>
                        <span class="show_btn color-f f-16" id="rotateRight"><i class="fa fa-repeat" aria-hidden="true"></i>
 Rotate Right</span>
                        <span class="show_btn color-f f-16" id="zoomOut"><i class="fas fa-search-plus"></i> zoom In</span>
                        <span class="show_btn color-f f-16" id="zoomIn"><i class="fas fa-search-minus"></i> zoom Out</span>
                        
                        <!-- <span class="show_btn" id="crop" style="background-color: rgb(7, 90, 133); display: inline;"><i class="fas fa-crop"></i> Crop</span> -->
                        <input type="hidden" id="croped_base64" name="croped_base64" value="" />
                        <input type="hidden" id="orig_base64" name="orig_base64" value="" />
                        <input type="hidden" id="photo_number" name="photo_number" value="" />
                    </div>
                    <span class="show_btn">Drag image and select proper image</span>
                    <div class="tools clearfix"></div>
                </div>
                <div class="row">
                    <div class="col-md-12 padding-zero text-center crop_img_11" style="padding: 0px 36.4%;display: flex;justify-content: center;">
                        <div id="croped_img"></div>
                    </div>
                </div>
            
           		<div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <!-- <button onClick="update_photo()" id="upload_btn" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Upload</button> -->
                            <button id="crop" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18" style="width: 140px;">Crop & Upload</button>
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
}";