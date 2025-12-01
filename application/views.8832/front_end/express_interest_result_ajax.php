<?php 
$path_photos = $this->common_model->path_photos;
$member_id=$this->common_front_model->get_session_data('matri_id');
if(!isset($all_interest_sent_count) || $all_interest_sent_count =='')
{
	$all_interest_sent_count = 0;
}
$mode_exp = $this->express_interest_model->mode_exp;
$mode_exp_status = 'sent';
$rec_status_arr = array('all_receive','accept_receive','reject_receive','pending_receive');
if($mode_exp !='' && in_array($mode_exp,$rec_status_arr))
{
	$mode_exp_status = 'receive'; 
}
$comm_model = $this->common_model;
$curre_gender = $this->common_front_model->get_session_data('gender');

$where_arra = array('is_deleted' => 'No', "status !='UNAPPROVED' and status !='Suspended'");
if (isset($curre_gender) && $curre_gender != '') {
    $where_arra[] = " gender != '$curre_gender' ";
}

if (isset($curre_gender) && $curre_gender == 'Male') {
    $photopassword_image = $base_url . 'assets/images/photopassword_female.png';
} else {
    $photopassword_image = $base_url . 'assets/images/photopassword_male.png';
}?>

<?php if($this->session->flashdata('success_message')){
	$success_message = $this->session->flashdata('success_message');
	if($success_message !=''){
		echo '<div id="remove_message1" class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$success_message.'</div>';
	}
}
if($this->session->flashdata('error_message')){
	$error_message = $this->session->flashdata('error_message');
	if($error_message !=''){
		echo '<div id="remove_message2" class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$error_message.'</div>';
	}
}?>

<?php if(isset($all_interest_sent) && $all_interest_sent !='' && is_array($all_interest_sent) && count($all_interest_sent) > 0){
        /*Get Plan Badges*/
        $badge = $this->common_front_model->getbadges($all_interest_sent);
    ?>
	<div class="row margin-0 pt-2 pb-3">
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="radio-custm">
                <input type="checkbox" class="<?php echo $mode_exp.'_all';?>" id="<?php echo $mode_exp;?>_chk" onClick="check_all_exp('<?php echo $mode_exp.'_all'; ?>','<?php echo $mode_exp; ?>')">
                <label for="<?php echo $mode_exp; ?>_chk" class="lbl1">Select  All</label>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <button type="button" class="Poppins-Bold f-12 color-f exp_int_delete_btn pull-right" onClick="change_status('delete','')">Delete All</button>
            
            <?php if($mode_exp !='' && in_array($mode_exp,array('accept_receive','pending_receive'))){?>
                <button type="button" class="Poppins-Bold f-12 color-f exp_int_delete_btn pull-right" onClick="change_status('reject')" title="Accept All">Reject All</button>
            <?php }?>
			
			<?php if($mode_exp !='' && in_array($mode_exp,array('reject_receive','pending_receive'))){?>
                <button type="button" class="Poppins-Bold f-12 color-f exp_int_delete_btn pull-right" onClick="change_status('accept')" title="Accept All">Accept All</button>
            <?php }?>
        </div>
    </div>
	<?php
	$i=1;
	foreach($all_interest_sent as $all_sent_ei){

        $badgebackStyle = $badgeUrl = $badgeImg = '';
        if (isset($all_sent_ei['plan_id']) && $all_sent_ei['plan_id']>0 && isset($all_sent_ei['plan_status']) && $all_sent_ei['plan_status']=='Paid') {
            $badgePath = $this->common_model->path_payment_logo;
            if (isset($badge['badge'][$all_sent_ei['plan_id']]) && $badge['badge'][$all_sent_ei['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$all_sent_ei['plan_id']])) {
                $badgeUrl = $base_url.$badgePath.$badge['badge'][$all_sent_ei['plan_id']];
                $badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -10px;top: -20px;z-index: 99;height: 144px;width: 144px;'/>";
            }
            $color = '#ffffff';
            if (isset($badge['color'][$all_sent_ei['plan_id']]) && $badge['color'][$all_sent_ei['plan_id']]!='') {
                $color = $badge['color'][$all_sent_ei['plan_id']];
            }
        }
        if($color == ''){
            $color = $this->common_model->data['config_data']['profile_border_color'];
        }
        $badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";position: relative;";

		$deleted = $all_sent_ei['deleted'];
		$id = $all_sent_ei['id'];
		?>
        <div class="m-b <?php if($i!=1){echo 'mt-4';}?>" style="<?php echo $badgebackStyle;?>">
            <?php echo $badgeImg; ?>
            <div class="row margin-lr-0">
                <div class="col-md-3 col-sm-3 col-xs-12">
                <?php 
                $photo_view_count = $this->common_front_model->photo_protect_count($member_id,$all_sent_ei['matri_id']);
                $photo1_disp = $this->common_model->member_photo_disp($all_sent_ei,$photo_view_count);
				$path_photos = $this->common_model->path_photos;
                
				if(isset($all_sent_ei['photo1']) && $all_sent_ei['photo1'] !='' && isset($all_sent_ei['photo1_approve']) && $all_sent_ei['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$all_sent_ei['photo1']) && isset($all_sent_ei['photo_view_status']) && $all_sent_ei['photo_view_status'] == 0 && $photo_view_count == 0){?>
					<a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $all_sent_ei['matri_id']; ?>')">
						<img src="<?php echo $photopassword_image; ?>"class="img-responsive exp_int_img" title="<?php echo $comm_model->display_data_na($all_sent_ei['username']); ?>" alt="<?php echo $comm_model->display_data_na($all_sent_ei['matri_id']); ?>">
					</a>
				<?php }else{?>
					<a target="_blank" href="<?php echo $base_url;?>search/view-profile/<?php echo $all_sent_ei['matri_id'];?>" class="ne_exp_sended"><img src="<?php echo $photo1_disp;?>" class="img-responsive exp_int_img" title="<?php echo $all_sent_ei['username'];?>" alt=""></a>
				<?php }?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-10">
                            <p class="p-search OpenSans-Bold radio-custm">
                                <input type="hidden" id="deleted" name="deleted" value="<?php echo $deleted; ?>">
                                <input type="checkbox" id="matri_id_<?php echo $id;?>" name="exp_id[]" value="<?php echo $id;?>" class="<?php echo $mode_exp; ?>">
                               <label for="matri_id_<?php echo $id;?>" class="lbl1"></label>
                               <a href="javascript:void();" onclick="search_now('<?php echo $this->common_model->display_data_na($all_sent_ei['matri_id']);  ?>')"><?php echo $this->common_model->display_data_na($all_sent_ei['matri_id']);?></a>
                                
                                <?php $class_status  = 'bg-color-e4';
								if($all_sent_ei['receiver_response'] =='Accepted'){
									$class_status = 'bg-color-e5';
								}
								else if($all_sent_ei['receiver_response'] =='Rejected'){
									$class_status = 'bg-color-e6';
								}?>
								
                                <span class="badge <?php echo $class_status;?> color-f f-12 Poppins-Regular badge_pending"><?php echo ucfirst($all_sent_ei['receiver_response']);?></span>
                                <?php if($mode_exp !='' && in_array($mode_exp,$rec_status_arr) && $all_sent_ei['reminder_status'] =='Yes'){?>
									<span class="badge bg-color-e4 color-f f-12 Poppins-Regular badge_pending"> Reminder</span>
								<?php }?>
                            </p>
                            <p class="Poppins-Regular f-12 color-6d exp_int_time_date">
                                Last Online: <?php echo $this->common_model->displayDate($all_sent_ei['last_login'],' M d - Y');?> |
                                <span class="Poppins-Bold f-12 color-31">Sent Date: <?php echo $this->common_model->displayDate($all_sent_ei['sent_date'],' M d, Y - h:i A');?></span>
                            </p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-2 padding-0 padding-mlr">
                            <div class="trash_exp_int pull-right">
                                <a class="btn-delete" data-toggle="modal" onClick="delete_particulare('<?php echo $id;?>')" data-target="#myModal_delete" title="Delete"><i class="fas fa-trash-alt f-14 color-f trash_icon_exp"></i></a>
                            </div>
                        </div>
                        <hr class="search-r-hr hr_width">
                        <div class="row">
                            <div class="col-md-8 col-sm-8 col-xs-12 margin-top-10 right-hr exp-p">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php $birthdate = $this->common_model->birthdate_disp($all_sent_ei['birthdate'],0);
											echo $this->common_model->display_data_na($birthdate);?>, 
										<?php	
											$height = $this->common_model->display_height($all_sent_ei['height']);
											echo $this->common_model->display_data_na($height);
										?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php $education = $this->common_model->valueFromId('education_detail',$all_sent_ei['education_detail'],'education_name'); 
										echo $this->common_model->display_data_na($education);
										?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php echo $this->common_model->display_data_na($all_sent_ei['religion_name']);?>, <?php echo $this->common_model->display_data_na($all_sent_ei['caste_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php echo $this->common_model->display_data_na($all_sent_ei['mtongue_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php echo $this->common_model->display_data_na($all_sent_ei['occupation_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php echo $this->common_model->display_data_na($all_sent_ei['country_name']);?>, <?php echo $this->common_model->display_data_na($all_sent_ei['city_name'])?>
                                    </p>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                    <p class="Poppins-Regular f-15 color-6d exp_int_pro_detail">
                                        <?php echo $all_sent_ei['message'];?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="exp_int_col4">
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-4">
                                        <p class="Poppins-Regular f-14 color-6d exp_int_pro_detail2">
                                            <!--Like this profile-->
                                            <?php if($deleted=='Yes'){?>
												<span style="color:#e35120;">This member does not exist.</span>
											<?php }?>
                                        </p>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 <?php if($deleted=='Yes'){ echo 'mt-3';}else{echo 'mt-5';}?>">
										<?php if($deleted=='Yes'){?>
                                            <button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" data-toggle="modal" data-target="#myModal_deleted" title="Send Message">
                                        <?php }else{?>
                                            <button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" onClick="message_particulare('<?php echo $all_sent_ei['matri_id']; ?>')" data-toggle="modal" data-target="#myModal_sms" title="Send Message">
                                        <?php }?> Send Message</button>
                                    </div>
                                    
                                    <?php
									if($mode_exp !='' && in_array($mode_exp,array('all_receive','accept_receive','pending_receive')) && $all_sent_ei['receiver_response'] !='Rejected'){
									?><div class="col-md-12 col-sm-12 col-xs-12 mt-5"><?php
										if($deleted=='Yes'){
											?><button type="button" data-toggle="modal" data-target="#myModal_deleted" class="exp_int_send_btn Poppins-Regular f-15 color-f">Reject</button>
											<?php 
										}else{?>
											<button type="button" onClick="change_status('reject','<?php echo $id; ?>')" class="exp_int_send_btn Poppins-Regular f-15 color-f" title="Reject">Reject</button>
									<?php }?>
                                    </div>
									<?php }
									
									if($mode_exp !='' && in_array($mode_exp,array('all_receive','reject_receive','pending_receive')) && $all_sent_ei['receiver_response'] !='Accepted'){
										?><div class="col-md-12 col-sm-12 col-xs-12 mt-5"><?php
										if($deleted=='Yes'){
											?><button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" data-toggle="modal" data-target="#myModal_deleted"> Accept</button>
											<?php 
										}
										else{?>	
											<button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" onClick="change_status('accept','<?php echo $id; ?>')" title="Accept"> Accept</button>
									<?php }?>
                                    </div>
									<?php }
									if(($mode_exp !='' && in_array($mode_exp,array('pending_sent'))) || ($all_sent_ei['receiver_response'] =='Pending' && $all_sent_ei['reminder_status'] =='No' && $mode_exp =='all_sent')){?>
                                        <div class="col-md-12 col-sm-12 col-xs-12 mt-5"><?php
											if($deleted=='Yes'){
												?><button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" data-toggle="modal" data-target="#myModal_deleted"> Accept</button>
												<?php 
											}else{?>
												<button type="button" class="exp_int_send_btn Poppins-Regular f-15 color-f" onClick="change_status('reminder','<?php echo $id; ?>')" title="Send Reminder"> Send Reminder</button>
											<?php }?>
										</div>
									<?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php $i++;
    }
	if(isset($all_interest_sent_count) && $all_interest_sent_count !='' && $all_interest_sent_count > 0){
		echo $this->common_model->rander_pagination_front('express_interest/index',$all_interest_sent_count,10);
	}
}else{?>
	<div class="no-data-f">
		<img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
		<h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
	</div>
<?php }?>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />

<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function () {
	setTimeout(function(){
		$('#remove_message1').hide();
		$('#remove_message2').hide();
	}, 5000);
});
";
?>
<script>

    function search_now(id)
   {
        var txt_id_search = id;
        var hash_tocken_id = $("#hash_tocken_id").val();
        var base_url = $("#base_url").val();
        var url = base_url+"search/search_exp";
        $.ajax({
        url: url,
        type: "post",
        data: {'txt_id_search':txt_id_search,'<?php echo $this->security->get_csrf_token_name(); ?>':hash_tocken_id},
        dataType:"json",
        success:function(data)
        {
            if(data.status == 'success')
            {
            window.location.href = base_url+"search/result";   
            return false;
            }
        }
        });
   }
</script>