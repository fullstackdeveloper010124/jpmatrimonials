<?php 
$current_login_user = $this->common_front_model->get_session_data(); 
$login_user_matri_id = $current_login_user['matri_id'];
$login_user_gender = $current_login_user['gender'];
$login_user_id = $current_login_user['id'];
$curre_id = $this->common_front_model->get_session_data('id');

if($login_user_gender == 'Male')
{
	$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
}
else
{
	$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
}
	
$member_data_mobile = '';
if(isset($curre_id) && $curre_id!='')
{
	$where_array = array('id'=>$curre_id, 'is_deleted'=>'No');
	$member_data_mobile = $this->common_model->get_count_data_manual('register',$where_array,1,'id,matri_id,username,email,mobile,mobile_verify_status,email,cpass_status,id_proof,id_proof_approve,plan_name,plan_status');
}

$mobile_num = '';
$mobile_num_status = '';
$email = '';
$email_status = '';
$id_proof = '';
$plan_name = '';
$plan_status = '';
$id_proof_approve = '';

if(isset($member_data_mobile) && $member_data_mobile != "")
{
	if(isset($member_data_mobile['mobile']) && $member_data_mobile['mobile']!='') 
	{
		$mobile_num = $member_data_mobile['mobile'];
	}
	if(isset($member_data_mobile['mobile_verify_status']) && $member_data_mobile['mobile_verify_status'] != '')
	{
		$mobile_num_status = $member_data_mobile['mobile_verify_status'];
	}
	
	if(isset($member_data_mobile['email']) && $member_data_mobile['email']!='') 
	{
		$email = $member_data_mobile['email'];
	}
	if(isset($member_data_mobile['cpass_status']) && $member_data_mobile['cpass_status'] != '')
	{
		$email_status = $member_data_mobile['cpass_status'];
	}
	
	if(isset($member_data_mobile['id_proof']) && $member_data_mobile['id_proof'] != '')
	{
		$id_proof = $member_data_mobile['id_proof'];
	}
	if(isset($member_data_mobile['id_proof_approve']) && $member_data_mobile['id_proof_approve']!='')
	{
		$id_proof_approve = $member_data_mobile['id_proof_approve'];
	}
	
	if(isset($member_data_mobile['plan_name']) && $member_data_mobile['plan_name'] != '')
	{
		$plan_name = $member_data_mobile['plan_name'];
	}
	if(isset($member_data_mobile['plan_status']) && $member_data_mobile['plan_status'] != '')
	{
		$plan_status = $member_data_mobile['plan_status'];
	}
}
$matri_id=$member_data_mobile['matri_id'];
if(isset($matri_id) && $matri_id!='')
{
	$where_arr = array('matri_id'=>$matri_id, 'is_deleted'=>'No');
	$member_plan = $this->common_model->get_count_data_manual('payments',$where_arr,1,'id,matri_id,plan_expired','id desc');
}

if(isset($member_plan) && $member_plan != "")
{
	if(isset($member_plan['plan_expired']) && $member_plan['plan_expired']!='') 
	{
		$plan_expired = $member_plan['plan_expired'];
	}
}
$today=date('Y-m-d');
?>
<div class="row">
    <!--<div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 compltele-profile margin-bottom-15px hidden-xs" style="padding-top:0px;padding-bottom:0px;">-->
    <div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 compltele-profile margin-bottom-15px" style="padding-top:0px;padding-bottom:0px;">
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-white hidden-sm hidden-xs" style="box-shadow: none;">
    <div class="row">  
        <div class="xxl-16 xl-16 m-16 l-16 s-16 xs-16">
            <div class="row">
                <div class="ne_font_dark_grey" style="padding:4px;">
                    <div class="row upgrade-heading" style="white-space: nowrap; overflow: hidden;text-overflow: ellipsis;">
                        <span class="">
                            <i class="glyphicon glyphicon-user ne_mrg_ri8_10 ne_font_14"></i>
                            <span class="profile-name">Hello, <span class="text-white"> <?php if(isset($current_login_user['username']) && $current_login_user['username'] !=''){ echo ucwords($current_login_user['username']);} ?></span></span>
                        </span>
                    </div>
                </div>
                <div class="xxl-16 xs-16 s-16 m-8 l-16 xl-16 ne_font_dark_grey margin-bottom-20px">
                    <div class="row">
                        <span class="ne_font_14" style="color:#999;">
                            <span class="ne_mrg_ri8_10 xs-margin-left-2 s-margin-left-1 m-margin-left-1 xxl-margin-left-2 xl-margin-left-2">
                                (Matri id :
                            </span>
                            <span>
                                <?php if(isset($current_login_user['matri_id']) && $current_login_user['matri_id'] !=''){ echo $current_login_user['matri_id'];} ?>)
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="xxl-5 xl-5 xs-5 s-4 m-3 l-6">
            <div class="row">
				<?php
					$path_photos = $this->common_model->path_photos;
					$photo1 = $this->common_model->get_count_data_manual('register_view',array('matri_id'=>$current_login_user['matri_id']),1,'photo1');
					$profile_photo = explode('/',$photo1['photo1']);
					$count = count($profile_photo);
					$cm = $count - 1;
					
					if(isset($photo1['photo1']) && $photo1['photo1'] !='' && file_exists($path_photos.$profile_photo[$cm])){ 
						$profile_pic = $photo1['photo1'];
					}else{
						$profile_pic = $defult_photo;
					}
				?>
				<img src="<?php echo $base_url.$path_photos.$profile_pic; ?>" class="img-thumbnail" alt="" style="height:78.52px;width:78.52px">
			</div>
        </div>                                     
        <div class="xxl-11 xl-11 xs-11 s-12 m-6 l-10 ne_lft_detail_home">
            <div class="row">
                <div class="xxl-16 xs-16 ne_font_dark_grey ne_home_detail">
                    <div class="xxl-16 m-16 l-16 s-16 ne_font_14">
                        <div class="row">
                            <a href="<?php echo $base_url.'my-profile/edit-profile'; ?>">
                                <i class="glyphicon glyphicon-pencil ne_mrg_ri8_10"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
                <div class="xxl-16 xs-16 ne_font_dark_grey margin-top-5 ne_home_detail">
                    <div class="xxl-16 m-16 l-16 s-16 ne_font_14">
                        <div class="row">
                            <a href="<?php echo $base_url.'my-profile'; ?>">
                                <i class="glyphicon glyphicon-eye-open ne_mrg_ri8_10"></i>View Preview
                            </a>
                        </div>
                    </div>
                </div>
                <div class="xxl-16 xs-16 ne_font_dark_grey margin-top-5 ne_home_detail">
                    <div class="xxl-16 m-16 l-16 s-16 ne_font_14">
                        <div class="row">
                            <a href="<?php echo $base_url.'modify-photo'; ?>">
                                <i class="glyphicon glyphicon-cloud-upload ne_mrg_ri8_10"></i>Upload Photo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="xxl-16 xl-16 xs-16 l-16 m-7 margin-top-15px">
            <div class="row">
                <div class="xxl-16 xl-16 xs-16 l-16 ne_font_dark_grey">
                    <div class="row">
                    <?php $percentage_stored = $this->common_front_model->getprofile_completeness($login_user_id);?>
						Your profile completed is:
                        <div class="progress xxl-16 xl-16 xs-16 l-16 margin-top-3px" style="margin-bottom:5px;">
                            <div class="row">
                            	
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage_stored;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_stored;?>%;">
                                    <?php echo $percentage_stored;?>%
                                </div>
                            </div>
                        </div>
                        <div class="xxl-16 xs-16 l-16 xl-16 ne_font_14 left-text margin-top-5px">
                            <div class="row text-center">
	                            <?php
								if ($mobile_num != '' && $mobile_num_status == 'No')
								{
								?> 
                                	<span data-toggle="modal" data-target="#myModal_verify_mobile" id="myModal_verify_mobile_btn" class="profile-secure5" style="cursor:pointer" title="Mobile Number Not Verified"></span>
                                    
								<?php }else if ($mobile_num != '' && $mobile_num_status == 'Yes'){?>
                                
	                                <span class="profile-secure1" title="Mobile Number Verified"></span>
                                
								<?php } 
								else
								{
								?>
                                	<span class="profile-secure5" title="Please provide your mobile number to verify"></span>
                                <?php
								}
								
								if($email!='' && $email_status == 'Not-Verify'){?>
                                
                                	<span data-toggle="modal" data-target="#myModal_verify_email" id="myModal_verify_email_btn" class="profile-secure6" style="cursor:pointer" title="Email Address Not Verified"></span>
                                
								<?php }else if($email!='' && $email_status == 'Verify'){?>
                                
									<span class="profile-secure2" title="Email Address Verified"></span>
                                
								<?php } 
								else
								{
								?>
                                	<span class="profile-secure6" title="Please provide your email address to verify"></span>
                                <?php
								}
								
								if($id_proof==''){?>
                                
                                	<a href="<?php echo $base_url; ?>upload/id_proof"><span class="profile-secure7" title="ID Proof Not Uploaded"></span></a>
								
								<?php }else if($id_proof_approve=='UNAPPROVED')
								{
									?>
									<span class="profile-secure7" title="ID Proof Unapproved"></span>
									<?php
								}else{ ?>
                                	
                                    <span class="profile-secure3" title="ID Proof Approved"></span>
								
								<?php } if($plan_name=='' && $plan_status=='Not Paid'){?>
								
                                	<a href="<?php echo $base_url; ?>premium-member"><span class="profile-secure8" title="Not Paid Member"></span></a>
                                    
								<?php }else if($plan_expired<$today){?>
								
                                	<a href="<?php echo $base_url; ?>premium-member"><span class="profile-secure8" title="Membership Plan Expired"></span></a>
                                    
								<?php }else{?>
								
                                	<span class="profile-secure4" title="Paid Member"></span>
                                    
								<?php }?>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="clearfix"></div>
    <div class="row hidden-sm hidden-xs" style="padding:4px;">
    <div class="upgrade-membership margin-top-10">
        <a href="<?php echo $base_url;?>premium-member" class="text-white">
            <img src="<?php echo $base_url; ?>assets/front_end/images/icon/myhome-king.png" class="margin-right-5" alt="myhome-king" /> Upgrade Membership
        </a>
    </div>
    </div>
    </div>
   <div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 bg-white compltele-profile margin-bottom-15px" style="padding-top:0px;">
    
	<div class="margin-bottom-10 row"  data-toggle="collapse" href="#ne_Messages-mobile" aria-expanded="false" aria-controls="ne_Messages" style="padding:4px;">
		<a href="javascript:;" onclick="change_img('Messages')">
			<h3 class="upgrade-heading" style="margin:0px;">
				<i class="fa fa-envelope"></i> Messages
				<span class="collapse-minus" id="img_Messages"></span>
			</h3>
		</a>
    </div>
	
	<div class="collapse  xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-white" style="box-shadow: none;" id="ne_Messages-mobile" >
    <div class="row">
        <?php
			$message_model = $this->common_front_model->load_message_model();
			$message_count = $message_model->get_message_count();
		?>
		
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active ne_font_13">
                <a href="<?php echo $base_url.'message/inbox/inbox'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-10 text_slider">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="fa fa-inbox ne_mrg_ri8_10 ne_font_16"></i> Inbox
                    </span>
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php if(isset($message_count['inbox']) && $message_count['inbox'] !=''){ echo $message_count['inbox'];} else{ echo 0;} ?></span>
                        </span>
                    </span>
                </a>
                
                <a href="<?php echo $base_url.'message/inbox/sent'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="fa fa-paper-plane ne_mrg_ri8_10 ne_font_16"></i>Sent
                    </span>
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php if(isset($message_count['sent']) && $message_count['sent'] !=''){ echo $message_count['sent'];} else{ echo 0;} ?></span>
                        </span>
                    </span>
                </a>
                <a href="<?php echo $base_url.'message/inbox/draft'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="fa fa-envelope ne_mrg_ri8_10 ne_font_16"></i>Draft
                    </span>
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php if(isset($message_count['draft']) && $message_count['draft'] !=''){ echo $message_count['draft'];} else{ echo 0;} ?></span>
                        </span>
                    </span>
                </a>
                
                <a href="<?php echo $base_url.'my-profile/photo-pass-request-received'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-13 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-chevron-left ne_mrg_ri8_10 ne_font_12"></i>&nbsp;Photo Request Received
                    </span>
					<!---for counting data---->
                    <?php
						$where_arra=array('photoprotect_request.ph_receiver_id'=>$login_user_matri_id,'rec_delete' => 'No');
						$received_data = $this->common_model->get_count_data_manual('photoprotect_request',$where_arra,0,'','','','','','');
					?>
                    <!---stop counting data---->
                    <span class="xxl-3 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $received_data; ?></span>
                        </span>
                    </span>
                </a>
                <a href="<?php echo $base_url.'my-profile/photo-pass-request-sent'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-13 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-chevron-right ne_mrg_ri8_10 ne_font_12"></i>&nbsp;Photo Request Sent
                    </span>
					<!---for counting data---->
                    <?php 
						$where_arra=array('photoprotect_request.ph_requester_id'=>$login_user_matri_id,'sen_delete'=>'No');
						$send_data = $this->common_model->get_count_data_manual('photoprotect_request',$where_arra,0,'','','','','','');
					?>
                    <!---stop counting data---->
                    <span class="xxl-3 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $send_data; ?></span>
                        </span>
                    </span>
                </a>
				
				<!------------------ Like Unlike Menu -------------------------->
				<a href="<?php echo $base_url.'my-profile/like-profile'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-13 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="fa fa-thumbs-up"></i>&nbsp;Like Profile
                    </span>
					<!---for counting data---->
                    <?php 
						$where_arra=array('my_id'=>$login_user_matri_id,'like_status'=>'Yes');
						$Like_data = $this->common_model->get_count_data_manual('member_likes',$where_arra,0,'','','','','','');
					?>
                    <!---stop counting data---->
                    <span class="xxl-3 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $Like_data; ?></span>
                        </span>
                    </span>
                </a>
				<a href="<?php echo $base_url.'my-profile/unlike-profile'; ?>" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero margin-top-15 text_slider">
                    <span class="xxl-13 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="fa fa-thumbs-down"></i>&nbsp;Unlike Profile
                    </span>
					<!---for counting data---->
                    <?php 
						$where_arra=array('my_id'=>$login_user_matri_id,'like_status'=>'No');
						$Unlike_data = $this->common_model->get_count_data_manual('member_likes',$where_arra,0,'','','','','','');
					?>
                    <!---stop counting data---->
                    <span class="xxl-3 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $Unlike_data; ?></span>
                        </span>
                    </span>
                </a>
				<!------------------ Like Unlike Menu End -------------------------->
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
    </div>
    <div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 bg-white compltele-profile margin-bottom-15px " style="padding-top:0px;">
    <div class="row" data-toggle="collapse" href="#ne_lft_pan_list-mobile" aria-expanded="false" aria-controls="ne_lft_pan_list" style="padding:4px;">
    <a href="#" onclick="change_img('profiles')">
        <h3 class="upgrade-heading" style="margin:0px;">
            <i class="glyphicon glyphicon-list ne_mrg_ri8_10 ne_font_12"></i>
            <span class="ne_mrg_ri8_10">List of Profile</span>
            <span class="collapse-minus" id="img_profiles"></span>
        </h3>
    </a>
    </div>
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-white" style="box-shadow: none;">
    <div class="row">
        <div class="collapse  ne_left_msg_opt xxl-16 xl-16 s-16 m-16 l-16 xs-16" id="ne_lft_pan_list-mobile">
            <div class="row">
                <a href="<?php echo $base_url;?>my-profile/short-listed" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-sort-by-attributes-alt ne_mrg_ri8_10 ne_font_12"></i>Short Listed Profile
                    </span>
                    <!---for counting data---->
                    	<?php 
						$where_arra=array('shortlist.is_deleted'=>'No','shortlist.from_id'=>$login_user_matri_id);
                        $data = $this->common_model->get_count_data_manual('shortlist',$where_arra,0,'');
						?>
                    <!---stop counting data---->
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $data;?></span>
                        </span>
                    </span>
                </a>
                
                <a href="<?php echo $base_url;?>my-profile/block-listed" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-ban-circle ne_mrg_ri8_10 ne_font_12"></i>Blocked Profiles
                    </span>
                    <!---for counting data---->
                    	<?php 
						$where_arra=array('block_profile.is_deleted'=>'No','block_profile.block_by'=>$login_user_matri_id);
                        $data = $this->common_model->get_count_data_manual('block_profile',$where_arra,0,'');
						?>
                    <!---stop counting data---->
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $data;?></span>
                        </span>
                    </span>
                </a>
                
                <a href="<?php echo $base_url;?>my-profile/i-viewed" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-sort-by-attributes-alt ne_mrg_ri8_10 ne_font_12"></i>Profile I Viewed
                    </span>
                   <!---for counting data---->
                    	<?php 
						$this->common_model->is_delete_fild = '';
						$where_arra=array('who_viewed_my_profile.my_id'=>$login_user_matri_id);
						$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
						?>
                    <!---stop counting data---->
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $data;?></span>
                        </span>
                    </span>
                </a>
                
                <a href="<?php echo $base_url;?>my-profile/who-viewed" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-sort-by-attributes-alt ne_mrg_ri8_10 ne_font_12"></i>Viewed My profile
                    </span>
                     <!---for counting data---->
                    	<?php 
						$this->common_model->is_delete_fild = '';
						$where_arra=array('who_viewed_my_profile.viewed_member_id'=>$login_user_matri_id);
						$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
						?>
                    <!---stop counting data---->
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span><?php echo $data;?></span>
                        </span>
                    </span>
                </a>
                
                 <a href="<?php echo $base_url;?>express-interest" class="xxl-16 xxl-margin-left-0 xl-16 xl-margin-left-0 m-16 m-margin-left-0 s-15 s-margin-left-1 l-15 l-margin-left-1 xs-16 padding-lr-zero">
                    <span class="xxl-11 xs-12 s-10 m-10 l-10 xl-11">
                        <i class="glyphicon glyphicon-sort-by-attributes-alt ne_mrg_ri8_10 ne_font_12"></i>My Express Interest </span>
                    <span class="xxl-5 xs-4 s-6 m-6 l-6 xl-5">
                        <span class="ne_left_msg_badge">
                            <span>0</span>
                        </span>
                    </span>
                </a>                
            </div>
        </div>
    </div>
    </div>
    </div>                            
    <div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 compltele-profile margin-bottom-15px " style="padding-top:0px;padding-bottom:0px;">
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-white" style="box-shadow: none;">
    <div class="row" style="padding:4px;">
		
		<a href="javascript:;" onclick="change_img('quick_search')">
			<div class="row upgrade-heading"  data-toggle="collapse" href="#ne_quick_search-mobile" aria-expanded="false" aria-controls="ne_quick_search" style="padding:4px;">
				<img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-search.png" class="ne_mrg_ri8_10 ne_font_12" alt="" /> 
				Quick search
				<span class="collapse-minus" id="img_quick_search"></span>
			</div>
		</a>
		
        <div class="collapse  xxl-16 xl-16 m-16 s-16 l-16xs-16 ne_myhome_save_search"  id="ne_quick_search-mobile" >
            <div class="row">
                <form class="xxl-16 xl-16 m-16 xs-16 l-16 s-16 ne_font_14" method="post" action="<?php echo $base_url; ?>search/search_now">
                    <div class="row">
                        <div class="xxl-16 xl-16 m-16 xs-16 s-16 l-16 padding-lr-zero">
                            <div class="xxl-16 xl-16 m-4 s-16 l-4 xs-16 padding-top-10px">
                                <div class="row">
                                    Age:
                                </div>
                            </div>
                            <div class="xxl-16 xl-16 m-12 s-16 l-12 xs-16 ne_font_12">
                                <div class="row">
                                    <div class="xxl-7 xl-7 s-7 m-7 l-7 xs-7">
                                        <div class="row">
                                            <select class="form-control" name="from_age" id="from_age">
                                                <option value="">From</option>
                                                <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),18);?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="xxl-2 xs-2 s-2 xl-2 l-2 m-2 ne_pad_tp_5px padding-lr-zero center-text">
                                        To
                                        </div>
                                    <div class="xxl-7 xl-7 s-7 m-7 l-7 xs-7">
                                        <div class="row">
                                            <select class="form-control" name="to_age" id="to_age">
                                                <option value="">To</option>
                                                <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),30);?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="xxl-16 xl-16 m-16 xs-16 s-16 l-16 padding-lr-zero">
                            <div class="xxl-16 xl-16 m-4 s-16 l-4 xs-16 padding-top-10px">
                                <div class="row">
                                    Height:
                                </div>
                            </div>
                            
                            <div class="xxl-16 xl-16 m-12 s-16 l-12 xs-16 ne_font_12">
                                <div class="row">
                                    <div class="xxl-7 xl-7 s-7 m-7 l-7 xs-7">
                                        <div class="row">
                                            <select class="form-control" name="from_height">
                                                <option value="">From</option>
                                            	<?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="xxl-2 xs-2 s-2 xl-2 l-2 m-2 ne_pad_tp_5px padding-lr-zero center-text">
                                        To
                                    </div>
                                    <div class="xxl-7 xl-7 s-7 m-7 l-7 xs-7">
                                        <div class="row">
                                            <select class="form-control " name="to_height">
                                                <option value="">To</option>
                                                <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        
                        <div class="xxl-16 xl-16 m-16 xs-16 s-16 l-16 padding-lr-zero">
                            <div class="xxl-16 xl-16 m-4 s-16 l-4 xs-16 padding-top-10px">
                                <div class="row">
                                    Religion:
                                </div>
                            </div>
                            
                            <div class="xxl-16 xl-16 m-12 s-16 l-12 xs-16 ne_font_12">
                                <div class="row">
                                    <select data-placeholder="Select Religion" id="search_religion" name="religion[]" class="chosen-select form-control" multiple >
									 <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('religion'));?>
                                </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="margin-top-10 ne_font_13">
                                <input id="360" type="checkbox" value="photo_search" name="photo_search">
								<label for="360" class="radio-clr font-13-normal">&nbsp;&nbsp;Only Profiles with photos</label>
                            </div>                            
                            <div class="xxl-16 xl-16 m-16 xs-16 s-16 l-16 padding-lr-zero margin-top-10px">
                                <div  class="xxl-16 xl-16 m-6 m-margin-left-5 s-16 l-6 l-margin-left-5 xs-16 ne_font_12">
                                    <div class="row">
                                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                         <button type="submit" class="btn xxl-16 xl-16 xs-16 m-16 l-16"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </div>  
                            <div class="clearfix"></div>
                        </div> 
                    </div>
                </form>
            </div>
        </div>
                                        
        <div class="clearfix"></div>
        <div class="row">
            <div class="upgrade-heading"> 
                <a href="<?php echo $base_url.'search/advance'; ?>" class="view_all underline text_slider">Advance Search <img src="<?php echo $base_url; ?>assets/front_end/images/icon/right-gray-arrow.png" alt="" /></a>
            </div>
        </div>
    </div>
    </div>
    </div>                          
    <?php $this->load->view('front_end/member_feature_slider_in_sidebar'); ?>
    <div class="clearfix"></div>
    <!----for advertisement------>
    <div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 compltele-profile margin-bottom-15px " style="padding:4px;">
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 bg-white padding-lr-zero-999" style="box-shadow: none;">
    <div class="row">
       	 <?php $this->load->view('front_end/sidebar_advertisement'); ?>
    </div>
    </div>
    </div>
</div>


 <?php
            if ($mobile_num != '' && $mobile_num_status == 'No') {
                ?>    
                <div id="myModal_verify_mobile" class="modal fade" role="dialog" >
                    <div class="modal-dialog" style="max-width:350px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><img src="<?php echo $base_url; ?>assets/front_end/images/icon/message.png" class="margin-right-5" alt=""/>Verify Your Mobile</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" style="display:none" id="error_message_mv"></div>
                                <div class="alert alert-success" style="display:none" id="success_message_mv"></div>
                                <div id="displ_mobile_generate">
                                    <label>Your Mobile Number</label>
                                    <input style="padding-left:10px;" readonly value="<?php echo $mobile_num; ?>" type="text" placeholder="Your Mobile Number" class="form-control input-border-modal" />
                                    <div>
                                        <a onClick="return generate_otp_verify()" class="btn btn-sm"><i class="fa fa-send" ></i> Generate OTP</a>
                                        <a class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
                                    </div>
                                </div>
                                <div id="verify_mobile_cont" style="display:none">
                                    <form class="form-group">
                                        <label>Verification Code</label>
                                        <input style="padding-left:10px;" id="otp_mobile" value="" type="text" placeholder="Enter OTP Received on Your Mobile" class="form-control input-border-modal" />
                                            <!--<span id="resend_link" style="display:none">-->
                                        <span>
                                            <a href="javascript:;" onClick="return generate_otp_verify()">Resend OTP</a>
                                        </span>
                                        <div>
                                            <a class="btn btn-sm" href="javascript:;" onClick="return varify_mobile_check()"><i class="fa fa-send"></i> Verify OTP</a>
                                            <a class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
                                        </div>
                                    </form>
                                </div>                                
                            </div>
                            <div class="modal-footer" id="close_buttonn_div" style="display:none">
                                <a class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }if($email!='' && $email_status == 'Not-Verify'){
            ?> 
           		<div id="myModal_verify_email" class="modal fade" role="dialog" >
                    <div class="modal-dialog" style="max-width:350px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"><img src="<?php echo $base_url; ?>assets/front_end/images/icon/message.png" class="margin-right-5" alt=""/>Confirm Your Email</h4>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" style="display:none" id="error_message_ev"></div>
                                <div class="alert alert-success" style="display:none" id="success_message_ev"></div>
                                <div id="displ_email_generate">
                                <input type="hidden" id="base_url" value="<?php echo $base_url;?>">
                                	<p>Click button to send email for confirm your email address..!</p>
                                    <div>
                                        <a class="btn btn-sm" onClick="return resend_confirm_mail('<?php echo $curre_id;?>')"><i class="fa fa-send"></i> Confirm Email</a>
                                        <a class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
                                    </div>
                                </div>                            
                            </div>
                            <div class="modal-footer" id="close_buttonn_div" style="display:none">
                                <a class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
                            </div>
                        </div>
                    </div>
                </div>
				<?php }?>
				
                
<?php 

$this->common_model->js_extra_code_fr .= "
function resend_confirm_mail(user_id)
	{
		var base_url = $('#base_url').val();
		var action = base_url +'my_dashboard/resend_confirm_mail';
		var hash_tocken_id = $('#hash_tocken_id').val();
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: 'post',
		   dataType:'json',
		   data: {'csrf_new_matrimonial':hash_tocken_id,'user_id':user_id},
		   success:function(data)
		   {
			   update_tocken(data.tocken);
				if(data.status == 'success')
				{
					$('#error_message_ev').hide();
					$('#success_message_ev').html(data.success_message);
					$('#success_message_ev').show();
					
					setTimeout(function(){ 
						$('#success_message_ev').fadeOut('fast');
					},10000);
				}
				else
				{
					$('#success_message_ev').hide();
					$('#error_message_ev').html(data.error_message);
					$('#error_message_ev').show();
					setTimeout(function(){ 
						$('#error_message_ev').fadeOut('fast');
					},10000);
				}
				hide_comm_mask();
		   }
		});
		return false;
	}
";
?>