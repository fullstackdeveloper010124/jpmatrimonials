<div id="myModal_photoprotect" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_photoprotect" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content" id="a1">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Send Photos <span class="mega-n4 f-s">Request</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            	<?php $is_login = $this->common_front_model->checkLogin('return');
				if($is_login){?>
                    <div id="Photo_message"></div>                     
                    <form action="<?php echo $base_url; ?>search/check-photo-request" method="post" id="password_form" name="password_form" onSubmit="return check_request_accept()">
                        <div id="ei_message"></div>
                        <div id="ei_alt">
                            <ul id="ul_li" class="list-unstyled" style="list-style: none;">                              
                                <li class="margin-right-5">
                                    <label>
                                        <input name="interest_message" id="interest_message" class="radio-inline" type="radio" value="We found your profile to be a good match. Please accept Photo request to proceed further." checked> We found your profile to be a good match. Please accept Photo request to proceed further.
                                    </label>
                                </li>
                                <li class="margin-right-5">
                                    <label>
                                        <input name="interest_message" id="interest_message" class="radio-inline" type="radio" value="I am interested in your profile. I would like to view photo now, accept photo request."> I am interested in your profile. I would like to view photo now, accept photo request.
                                    </label>
                                </li>
                            </ul>                                                  
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 col-sm-3 col-xs-12">
                                <div class="pull-right float-none">
                                    <input type="hidden" name="requester_id" value="" id="requester_id" />
                                    <input type="hidden" name="receiver_id" value="" id="receiver_id" />
                                    <button type="button" class="photo-request-btn add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onclick="send_password_request()">Send</button>
                                    <a onClick="return remove(1);" class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18 already-photo-btn" title="Already have password"> Click here for check your photo request status</a>
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                                </div>
                            </div>
                        </div>
                    </form>
                <?php }else{?>
					<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">
                        <strong>&nbsp;&nbsp;Please Login to access this feature.</strong>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <div class="pull-right float-none">
                                <div class="add-w-btn">
                                    <a href="<?php echo base_url();?>login" class="new-msg-btn left-zero-msg Poppins-Medium color-f f-18"><b>Log In</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php }?>
            </div>            
        </div>
        
        <div class="modal-content" id="a2" style="display:none;">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">View Protected <span class="mega-n4 f-s">Photo</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <form name="ei_form" id="ei_form" method="post">	
                    <p>The Photo has been protected by the owner of this profile. Members are given the feature to protect their Photo from viewing by anyone. If you send Photo request, then you need to check your request status to view it.</p>
                    <?php if($this->session->flashdata('error_message_arr')){?>
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('error_message_arr');?>
                        </div>
                    <?php } ?>
                    <div class="alert alert-danger" id="message_err" style="display:none"></div>
                    <div class="alert alert-success" id="message_succ" style="display:none"></div>								
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <div class="pull-right float-none">
                                <a href="javascript:void(0)" class="check-req-btn add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onclick="send_password_request()">Check rquest is accepted or not</a>
                                <input type="hidden" name="is_post" id="is_post" value="1" />
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                <input type="hidden" name="user_id" id="user_id" value="" />
                                <input type="hidden" name="my_id" id="my_id" value="" />
                            </div>
                    	</div>
               		</div>
	        	</form>
        	</div>       
		</div>
        
        <div class="modal-content" id="a3" style="display:none;">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Photos of <span class="mega-n4 f-s"><span id="phtos_of_id"></span></span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div id="photo1_id" style="display:block;">
                    <div id="content"></div>
                </div>
            </div>
        </div> 
    </div>
</div>
<div id="myModal_new" class="modal_new modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModal_new" aria-hidden="true">
    <span class="close cursor padding-right-10" onclick="closeModal()" style="position:relative;color:#fff !important;opacity:2 !important;">&times;</span>
    <div class="modal-content_new margin-bottom-20px">
	    <div id="1to6photo_slider"></div>
	</div>
	<div class="clearfix"></div>
	<center style="margin: 25px 0px !important;">
		<span class="prev_p" onclick="plusSlides(-1)">&#10094;</span>
		<span class="next_n" onclick="plusSlides(1)">&#10095;</span>
	</center>
</div>