<input type="hidden" id="matri_id_for_action" name="matri_id_for_action" value="" />
<?php $is_login = $this->common_front_model->checkLogin('return');?>
<div id="myModal123" class="modal fade in">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Horoscope <span class="mega-n4 f-s">Photo</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body" style="padding: 0px 10px 10px 10px !important;">
                <img src="<?php if(isset($horoscope)) { echo $horoscope; } ?>" style="width: 100%; height:auto; max-height:600px;">
            </div>
        </div>
    </div>
</div>
<div id='myModal_ViewContactDetails' class='modal fade' role='dialog'></div>
<div id='myModal_ViewVideo' class='modal fade' role='dialog'></div>
<div id="myModal_shortlist" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_shortlist" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Do you want to <span class="mega-n4 f-s">Shortlist</span> This Profile</p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){?>
                <div id="shortlist_profile_message"> </div>
                <div id="shortlist_profile_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-ban2.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Do you want to Shortlist This Profile</strong><br />
                        <span class="small">This Profile will be Shortlisted Permanently.</span>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <div id="shortlist_button">
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="add_shortlist()">Shortlist</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                            </div>
                            <div id="shortlist_button_close" style="display:none;">
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </div>
                        </span>
                    </div>
                </div>
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
    </div>
</div>

<div id="myModal_shortlisted" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_shortlisted" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Profile Currently <span class="mega-n4 f-s">Shortlisted</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){?>
                <div id="shortlisted_profile_message"> </div>
                <div id="shortlisted_profile_alt">
                    <div class="alert alert-danger" style="overflow:hidden;">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-block.png" alt="" class="margin-right-10" />
                        </div>
                        <div class="col-md-10 col-sm-6 col-xs-12">
                            <strong>This Profile Currently Shortlisted</strong><br />
                            <span class="small">This Profile will be Shortlisted Permanently.</span>
                        </div>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo $base_url;?>assets/front_end/images/icon/download.png" alt="" class="text-center">
                    </div>
                    
                    <div class="alert alert-success margin-top-10" style="overflow:hidden;">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <img src="<?php echo $base_url;?>assets/front_end/images/icon/user-unblock.png" alt="" class="margin-right-10">
                        </div>
                        <div class="col-md-10 col-sm-6 col-xs-12">
                            <strong class="text-black">Do you want to shortlist this Profile</strong><br>
                            <span class="small text-black">This Profile will be shortlist<em>(Show)</em> Permanently.</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <div class="pull-right float-none">
                            <div id="shortlisted_button">
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="remove_shortlist()">UnShortlist</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                            </div>
                            <div id="shortlisted_button_close" style="display:none;">
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
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
    </div>
</div>

<div id="myModal_video" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_video" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">WATCH <span class="mega-n4 f-s">VIDEO</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){ ?>
                    <div class="clearfix"></div>
                    <?php 
						if(isset($member_data['video_url']) && $member_data['video_url']!='' && $member_data['video_approval'] == 'APPROVED')
						{
							preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $member_data['video_url'], $match);
							$youtube_id = $match[1];
					?>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div id="setvideo">
							<object  class="video-object" data="https://www.youtube.com/v/<?php echo $youtube_id;?>"></object>
							</div>
						</div>
					<?php }else{ ?>
							<div  >
							<img src="<?php echo base_url('assets/front_end_new/images/video-not-found.jpg')?>" width="650" height="400">                
							</div>
					<?php } ?>
                    <div class="row mt-3">
					<!-- <iframe id="ytiframe" class="" width="740" height="400"  style="box-shadow:3px 3px 0 0 #ccc;" src=""  allowfullscreen></iframe> -->
                    </div>
				<?php  }?>
            </div>
        </div>
    </div>
</div>

<div id="myModal_sms" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_sms" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Send <span class="mega-n4 f-s">SMS</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){?>
                <div id="respond_message"> </div>
                <form name="send_message_form" id="send_message_form" action="" method="post" >
                    <textarea style="padding:5px" placeholder="Message" class="form-control input-border-modal" rows="6" name="message" id="message"></textarea>
                    <div class="clearfix"></div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <button type="button" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18"  onClick="send_message('sent')">Send</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" id="send_message_cancel" data-dismiss="modal">Cancel</button>
                            </span>
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
    </div>
</div>

<div id="myModal_sendinterest" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_sendinterest" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Send <span class="mega-n4 f-s">Interest</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
			<?php
            $member_id = $this->common_front_model->get_session_data('matri_id');
            $where_arra=array('current_plan'=>'Yes','matri_id'=>$member_id);
            $plan_expire = $this->common_model->get_count_data_manual('payments',$where_arra,1,'plan_expired');
            $today_date =  $this->common_model->getCurrentDate('Y-m-d');
            if($plan_expire > $today_date){?>
                <div class="modal-body">
                	<?php if(isset($is_login) && $is_login!=0){?>
                    <div id="is_block_member_exp" style="display:none;">
                		<h4><span>This member has blocked by you. You can't express your interest.</span></h4>                    </div>
                    <div id="ei_message"></div>    
                                     
                    	<form name="ei_form" id="ei_form" action="" method="post">		
                        <div id="form_express_intrest">
                            <div id="ei_alt">
                                <ul id="ul_li" class="list-unstyled" style="list-style: none;">                              
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="I am interested in your profile. Please Accept if you are interested." checked> I am interested in your profile. Please Accept if you are interested.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="You are the kind of person we have been looking for. Please respond to proceed further."> You are the kind of person we have been looking for. Please respond to proceed further.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value=" We liked your profile and interested to take it forward. Please reply at the earliest."> We liked your profile and interested to take it forward. Please reply at the earliest.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="You seem to be the kind of person who suits our family. We would like to contact your parents to proceed further."> You seem to be the kind of person who suits our family. We would like to contact your parents to proceed further.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="You profile matches my sister's/brother's profile. Please 'Accept' if you are interested."> You profile matches my sister's/brother's profile. Please 'Accept' if you are interested.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="Our children's profile seems to match. Please reply to proceed further."> Our children's profile seems to match. Please reply to proceed further.</label></li>
                                    
                                    <li class="margin-right-5"><label><input name="exp_interest" id="exp_interest" class="radio-inline" type="radio" value="We find a good life partner in you for our friend. Please reply to proceed further."> We find a good life partner in you for our friend. Please reply to proceed further.</label></li>
                                </ul>                                                  
                            </div>								
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 col-sm-3 col-xs-12">
                                <div class="pull-right float-none">
                                	<div id="ei_button">
                                        <button type="button" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="express_interest_sent()">Send</button>
                                        <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                                    </div>
                                    <div id="ei_button_close" style="display:none;">
                                        <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                                    </div>
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
			<?php 
            }
            else
            {
                $button_text = "Login";
                $button_url = "login";
                $strong_text = "Please login to access this feature.";
                if(isset($member_id) && $member_id !== '')
                {
                    $button_text = 'Select membership plan';
                    $button_url = 'premium-member';
                    $strong_text = "Please buy membership to access this feature.";
                }
            ?>
                <div class="modal-body">
                	<div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">
                        <strong>&nbsp;&nbsp;<?php echo $strong_text; ?></strong>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <div class="pull-right float-none">
                                <a href="<?php echo base_url().$button_url;?>" class="selct-memb-btn add-w-btn left-zero-msg Poppins-Medium color-f f-18"><?php echo $button_text; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
</div>
<div id="myModal_block" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_block" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Do you want to <span class="mega-n4 f-s">Block</span> This Profile</p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){?>
            	<div id="block_profile_message"> </div>
                <div id="block_profile_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-ban2.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Do you want to Block This Profile</strong><br />
                        <span class="small">This Profile will be Blocked Permanently.</span>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <div id="block_button">
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="add_blocklist()">Block</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                            </div>
                            <div id="block_button_close" style="display:none;">
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </div>
                        </span>
                    </div>
                </div>
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
    </div>
</div>
<div id="myModal_unblock" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_unblock" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Profile Currently <span class="mega-n4 f-s">Blocked</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            	<?php if(isset($is_login) && $is_login!=0){?>
                    <div id="unblock_profile_message"> </div>
                    <div id="unblock_profile_alt">
                        <div class="alert alert-danger" style="overflow:hidden;">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-ban2.png" alt="" class="margin-right-10" />
                            </div>
                            <div class="col-md-10 col-sm-6 col-xs-12">
                                <strong>This Profile Currently Blocked</strong><br>
                                <span class="small">This Profile has been Blocked Permanently.</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <img src="<?php echo $base_url; ?>assets/front_end/images/icon/download.png" alt="" class="text-center">
                        </div>
                        <div class="alert alert-success margin-top-10" style="overflow:hidden;">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <img src="<?php echo $base_url;?>assets/front_end/images/icon/user-unblock.png" alt="" class="margin-right-10">
                            </div>
                            <div class="col-md-10 col-sm-6 col-xs-12">
                                <strong class="text-black">Do you want to Unblock this Profile</strong><br>
                                <span class="small text-black">This Profile will be Unblock<em>(Show)</em> Permanently.</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <div class="pull-right float-none">
                                <div id="unblock_button">
                                    <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="remove_blocklist()">Unblock</button>
                                    <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                                </div>
                                <div id="unblock_button_close" style="display:none;">
                                    <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </div>
</div>

<?php 
$this->common_model->js_extra_code_fr.="


function add_shortlist_matri_id(matri_id)
{
	$('#shortlist_profile_alt').show();
	$('#shortlist_profile_header').show();
	$('#shortlist_profile_message').hide();
	$('#shortlist_profile_message').html('');
	$('#shortlist_button').show();
	$('#shortlist_button_close').hide();
	$('#matri_id_for_action').val(matri_id);
}
function add_shortlist()
{
	var shortlist_id = $('#matri_id_for_action').val();
	$('#shortlist_profile_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#shortlist_profile_message').html('');
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/add-shortlist';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'shortlistuserid':shortlist_id},
		dataType:'json',
		success: function(data)
		{ 
			$('#shortlist_profile_message').html(data.errmessage);
			$('#shortlist_profile_message').slideDown();
			if(data.status == 'success')
			{
				$('#shortlist_profile_message').addClass('alert alert-success');
				$('#shortlist_profile_alt').hide();
				$('#shortlist_button_close').show();
				$('#shortlist_button').hide();
				$('#add_shortlist_'+shortlist_id).hide();
				$('#remove_shortlist_'+shortlist_id).show();
				$('#add_shortlist_mobile_'+shortlist_id).hide();
				$('#remove_shortlist_mobile_'+shortlist_id).show();
				$('#add_shortlist_grid_'+shortlist_id).hide();
				$('#remove_shortlist_grid_'+shortlist_id).show();
				$('#matri_id_for_action').val('');
				$('#shorted_or_not_'+shortlist_id).html('');
				$('#shorted_or_not_'+shortlist_id).html('Shortlisted');
				$('#shorted_'+shortlist_id).html('');
				$('#shorted_'+shortlist_id).html('Shortlisted');
				
				$('#mob_shorted_or_not_'+shortlist_id).html('');
				$('#mob_shorted_or_not_'+shortlist_id).html('Shortlisted');
				$('#mob_shorted_'+shortlist_id).html('');
				$('#mob_shorted_'+shortlist_id).html('Shortlisted');
			}
			else
			{
				$('#shortlist_profile_message').addClass('alert alert-danger');
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
function remove_shortlist_matri_id(matri_id)
{
	$('#shortlisted_profile_alt').show();
	$('#shortlisted_profile_header').show();
	$('#shortlisted_profile_message').hide();
	$('#shortlisted_profile_message').html('');
	$('#shortlisted_button').show();
	$('#shortlisted_button_close').hide();
	$('#matri_id_for_action').val(matri_id);
}
function remove_shortlist()
{
	var shortlisted_id = $('#matri_id_for_action').val();
	$('#shortlisted_profile_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#shortlisted_profile_message').html('');
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/remove-shortlist';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'shortlisteduserid':shortlisted_id},
		dataType:'json',
		success: function(data)
		{ 	
			$('#shortlisted_profile_message').html(data.errmessage);
			$('#shortlisted_profile_message').slideDown();
			if(data.status == 'success')
			{
				$('#shortlisted_profile_message').addClass('alert alert-success');
				$('#shortlisted_profile_alt').hide();
				$('#shortlisted_button_close').show();
				$('#shortlisted_button').hide();
				$('#remove_shortlist_'+shortlisted_id).hide();
				$('#add_shortlist_'+shortlisted_id).show();
				$('#remove_shortlist_mobile_'+shortlisted_id).hide();
				$('#add_shortlist_mobile_'+shortlisted_id).show();
				$('#remove_shortlist_grid_'+shortlisted_id).hide();
				$('#add_shortlist_grid_'+shortlisted_id).show();
				$('#matri_id_for_action').val('');
				$('#shorted_or_not_'+shortlisted_id).html('');
				$('#shorted_or_not_'+shortlisted_id).html('Shortlisted');
				$('#shorted_'+shortlisted_id).html('');
				$('#shorted_'+shortlisted_id).html('Shortlist');
				
				$('#mob_shorted_or_not_'+shortlisted_id).html('');
				$('#mob_shorted_or_not_'+shortlisted_id).html('Shortlisted');
				$('#mob_shorted_'+shortlisted_id).html('');
				$('#mob_shorted_'+shortlisted_id).html('Shortlist');
			}
			else
			{
				$('#shortlisted_profile_message').addClass('alert alert-danger');
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
function add_block_list_matri_id(matri_id)
{
	$('#block_profile_alt').show();
	$('#block_profile_message').hide();
	$('#block_profile_message').html('');
	$('#block_button').show();
	$('#block_button_close').hide();
	$('#matri_id_for_action').val(matri_id);
	return false;
}	
function add_blocklist()
{
	var block_id = $('#matri_id_for_action').val();
	$('#block_profile_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#block_profile_message').html('');
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/add-blocklist';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'blockuserid':block_id},
		dataType:'json',
		success: function(data)
		{ 
			$('#block_profile_message').html(data.errmessage);
			$('#block_profile_message').slideDown();
			if(data.status == 'success')
			{
				$('#block_profile_message').addClass('alert alert-success');
				$('#block_profile_alt').hide();
				$('#block_button_close').show();
				$('#block_button').hide();
				
				$('#add_blocklist_'+block_id).hide();
				$('#remove_blocklist_'+block_id).show();
				$('#add_blocklist_mobile_'+block_id).hide();
				$('#remove_blocklist_mobile_'+block_id).show();
				
				$('#matri_id_for_action').val('');
				$('#is_member_block_'+block_id).val(1);
			}
			else
			{
				$('#block_profile_message').addClass('alert alert-danger');
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
function remove_block_list_id(matri_id)
{
	$('#unblock_profile_alt').show();
	$('#unblock_profile_message').hide();
	$('#unblock_profile_message').html('');
	$('#unblock_button').show();
	$('#unblock_button_close').hide();
	$('#matri_id_for_action').val(matri_id);
	return false;
}	
function remove_blocklist()
{
	var unblock_id = $('#matri_id_for_action').val();
	$('#unblock_profile_message').removeClass('alert alert-success alert-danger alert-warning');
	$('#unblock_profile_message').html('');
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	//alert(hash_tocken_id);
	var base_url = $('#base_url').val();
	var url = base_url+'search/remove-blocklist';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'unblockuserid':unblock_id},
		dataType:'json',
		success: function(data)
		{ 	
			$('#unblock_profile_message').html(data.errmessage);
			$('#unblock_profile_message').slideDown();
			if(data.status == 'success')
			{
				$('#unblock_profile_message').addClass('alert alert-success');
				$('#unblock_profile_alt').hide();
				$('#unblock_button_close').show();
				$('#unblock_button').hide();
				
				
				$('#remove_blocklist_'+unblock_id).hide();
				$('#add_blocklist_'+unblock_id).show();
				$('#remove_blocklist_mobile_'+unblock_id).hide();
				$('#add_blocklist_mobile_'+unblock_id).show();
				$('#matri_id_for_action').val('');
				$('#is_member_block_'+unblock_id).val('');
			}
			else
			{
				$('#unblock_profile_message').addClass('alert alert-danger');
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
function express_interest(matri_id)
{
	$('#matri_id_for_action').val(matri_id);
	var block_member_id = $('#matri_id_for_action').val();
	if($('#is_member_block_'+block_member_id).val() != '')
	{
		$('#is_block_member_exp').show();
		$('#form_express_intrest').hide();
		$('#myModal_sendinterest #ei_button_close').show();
		$('#myModal_sendinterest #ei_button').hide();
	}
	else
	{
		$('#is_block_member_exp').hide();
		$('#form_express_intrest').show();
		$('#myModal_sendinterest #ei_button_close').hide();
		$('#myModal_sendinterest #ei_button').show();
	}
	$('#ei_alt').show();
	$('#ei_message').hide();
	$('#ei_message').html('');
	//$('#ei_button').show();
	//$('#ei_button_close').hide();
	return false;
}
function express_interest_sent()
{
	var receiver = $('#matri_id_for_action').val();
	var exp_interest =  $('#exp_interest:checked').val();
	
	var dataString =$('#ei_form').serialize();
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/express-interest-sent';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'receiver':receiver,'message':exp_interest},
		dataType:'json',
		success: function(data)
		{ 	
			$('#myModal_sendinterest #ei_message').html(data.errmessage);
			$('#myModal_sendinterest #ei_message').slideDown();
			if(data.status == 'success')
			{
				$('#myModal_sendinterest #ei_message').removeClass('alert alert-danger');
				$('#myModal_sendinterest #ei_message').addClass('alert alert-success');
				$('#myModal_sendinterest #ei_alt').hide();
				$('#myModal_sendinterest #ei_button_close').show();
				$('#myModal_sendinterest #ei_button').hide();
				$('#matri_id_for_action').val('');

				if($('#is_interest').next('p').text() == 'Interest'){
					$('#is_interest').next('p').text('Interested');
					$('#is_interest i').attr('class','fas fa-heart'); 
					$('#is_interest').parent().addClass('animate');
				}else{
					$('#main_content_ajax').find('#express_insterest_id_'+receiver).find('.ch-info-back.heart').addClass('fill');
					$('#main_content_ajax').find('#express_insterest_id_'+receiver).find('i').attr('title','Sent Interest');
				}
			}
			else
			{
				$('#myModal_sendinterest #ei_message').removeClass('alert alert-success');
				$('#myModal_sendinterest #ei_message').addClass('alert alert-danger');
				window.setTimeout(function() {
					$('#myModal_sendinterest #ei_message').html('');
					$('#myModal_sendinterest #ei_message').hide();
				}, 10000);
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}

function get_member_matri_id(matri_id)
{
	$('#myModal_sms #send_message_form #message').val('');
	$('#matri_id_for_action').val(matri_id);
	return false;
}

function get_matri_id(matri_id)
{
	$('#myModal_video').val('');
	$('#matri_id_for_action').val(matri_id);
	return false;
}

function send_message(status)
{
	var receiver_id = $('#matri_id_for_action').val();
	var message = $('#message').val();
	if(status =='')
	{
		alert('Please try again');
		return false;
	}
	if(receiver_id =='')
	{
		alert('Please try again');
		return false;
	}	
	if(message =='')
	{
		alert('Please enter message to send');
		return false;
	}
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'message/send-message';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'msg_status':status,'receiver_id':receiver_id,'message':message},
		dataType:'json',
		success: function(data)
		{ 	
			$('#respond_message').html(data.error_message);
			$('#respond_message').slideDown();
			if(data.status == 'success')
			{
				$('#respond_message').addClass('alert alert-success');
				
				$('#message').val('');
				window.setTimeout(function() {
					$('#respond_message').html('');
					$('#respond_message').hide();
				}, 3000);
			}
			else
			{
				$('#respond_message').addClass('alert alert-danger');
				window.setTimeout(function() {
					$('#respond_message').html('');
					$('#respond_message').hide();
				}, 10000);
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
$('#send_message_cancel').click(function()
{
	$('#send_message_form')[0].reset(); 
});

function get_member_matri_id_for_email(matri_id)
{
	$('#matri_id_for_action').val(matri_id);
}

function send_mail(status='')
{
	var receiver_email = $('#matri_id_for_action').val();
	var email_subject = $('#email_subject').val();
	var email_message = $('#email_message').val();
	
	if(status ==''){
		alert('Please try again');
		return false;
	}
	if(receiver_email ==''){
		alert('Please try again');
		return false;
	}	
	if(email_subject ==''){
		alert('Please enter subject to send');
		$('#email_subject').focus();
		return false;
	}
	if(email_message ==''){
		alert('Please enter message to send');
		return false;
	}
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/send-email';
	show_comm_mask();
		$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'email_status':status,'receiver_email':receiver_email,'email_subject':email_subject,'email_message':email_message},
			dataType:'json',
			success: function(data)
			{ 	
				$('#respond_email_message').html(data.response);
				$('#respond_email_message').slideDown();
				if(data.status == 'success'){
					$('#respond_email_message').addClass('alert alert-success');
					$('#email_subject').val('');
					$('div.Editor-editor').html('');
					//$('#matri_id_for_action').val('');
					window.setTimeout(function() {
						$('#respond_email_message').html('');
						$('#respond_email_message').hide();
					}, 3000);
				}else{
					$('#myModal_email').addClass('alert alert-danger');
				}
				update_tocken(data.tocken);
				hide_comm_mask();
			}
		});
	return false;
}
";
?>