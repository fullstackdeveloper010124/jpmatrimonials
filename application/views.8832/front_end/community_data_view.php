<input type="hidden" id="matri_id_for_action" name="matri_id_for_action" value="" />
<?php 
$member_id = $this->common_front_model->get_session_data('matri_id');
$comm_model = $this->common_model;

if(isset($gender) && $gender == 'Male'){
	$photopassword_image = $base_url.'assets/images/photopassword_female.png';
}else{
	$photopassword_image = $base_url.'assets/images/photopassword_male.png';
}
if(isset($member_data) && $member_data !='' && is_array($member_data) && count($member_data) > 0){
	$full_profile_url = $base_url.'search/view-profile/';
	foreach($member_data as $member_data_val){ 
		if($member_data_val =='' || count($member_data_val)==0){
			continue;
		}
		$full_profile_url_finale = $full_profile_url.$member_data_val['matri_id'];
		$result_member_matri_id = $member_data_val['matri_id'];
		?>
        <div class="row-cstm mt-5">
            <div class="m-b hidden-sm hidden-xs">
                <div class="row">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                       <?php $path_photos = $this->common_model->path_photos;			
                    if(isset($member_data_val['photo1']) && $member_data_val['photo1'] !='' && isset($member_data_val['photo1_approve']) && $member_data_val['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$member_data_val['photo1']) && isset($member_data_val['photo_view_status']) && $member_data_val['photo_view_status'] == 0){?>
                        <a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data_val['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="" class="img-responsive placeholder-img"></a>
                    <?php }else{?>
                        <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>">
                            <img src="<?php echo $comm_model->member_photo_disp($member_data_val);?>" class="img-responsive <?php if($comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/male.png' || $comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/female.png'){ echo 'placeholder-img';}else{ echo 's-img-1';}?>" title="<?php echo $comm_model->display_data_na($member_data_val['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data_val['matri_id']);?>">
                        </a>
                    <?php }?>
                        <div class="profile-card-btn">
                            <a href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id'];?>" class="s-card-1 OpenSans-Light">View Full Profile</a>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <p class="p-search OpenSans-Bold">
                                    <?php echo $comm_model->display_data_na($member_data_val['matri_id']);?> |
                                    <span class="p-search2">Profile Created By <?php echo $comm_model->display_data_na($member_data_val['profileby']);?></span>
                                </p>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <p class="p-search3 OpenSans-Regular pull-right">
                                    <!--Online Now-->
                                </p>
                            </div>
                        </div>
                        <hr class="search-r-hr">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12 margin-top-10 right-hr new-p2">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Age / Height:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->birthdate_disp($member_data_val['birthdate'],0);?>, <?php echo $comm_model->display_height($member_data_val['height']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Religion:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['religion_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Caste:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['caste_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Mother Tongue:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['mtongue_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Education:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php $edu = $comm_model->valueFromId('education_detail',$member_data_val['education_detail'],'education_name');
                                        if($edu==''){echo 'N/A';}else{echo $edu;}?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Location:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['city_name']).', '.$comm_model->display_data_na($member_data_val['country_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Occupation:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['occupation_name']);?>
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr1 Roboto-Bold Roboto-Bold">
                                        Annual Income:
                                    </p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php echo $comm_model->display_data_na($member_data_val['income']);?>
                                    </p>
                                </div>
                            </div>
                            <?php include('page_part/like_dislike.php');?>
                        </div>
                        <?php if(isset($member_id) && $member_id!='' && isset($member_data_val) && $member_data_val !=''  && is_array($member_data_val)){?>
                        <hr class="search-r-hr">
                        <div class="row mt-3">
                            <div id="more_details_btns_<?php echo $member_data_val['id'];?>" style="display: none;">
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <button data-toggle="modal" data-target="#myModal_sms" class="dshbrd_17 Poppins-Regular f-14" title="Send Message" onClick="return get_member_matri_id('<?php echo $member_data_val['matri_id'];?>')">
                                        Send Message
                                    </button>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                    <button class="dshbrd_17 Poppins-Regular f-14" data-toggle="modal" data-target="#myModal_sendinterest" onClick="return express_interest('<?php echo $member_data_val['matri_id'];?>')" title="Send Interest">
                                    Send Interest</button>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-12">
                                <?php $where_arra=array('block_to'=>$result_member_matri_id,'block_by'=>$member_id);
                                    $data = $this->common_model->get_count_data_manual('block_profile',$where_arra,1,'id');
                                    $is_block_list = 0;
                                    if(isset($data) && $data > 0){
                                        $is_block_list = 1;
                                    }?>
                                    <input type="hidden" id="is_member_block_<?php echo $member_data_val['matri_id'];?>" name="is_member_block_<?php echo $member_data_val['matri_id'];?>" value="<?php if($is_block_list != 0){ echo 'is_member_block_'.$member_data_val['matri_id']; } ?>" >
                                    <div id="add_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';} ?>">
                                        <button data-toggle="modal" data-target="#myModal_block" title="Add to Blocklist" onClick="return add_block_list_matri_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 Poppins-Regular f-14">Blocklist</button>
                                    </div>
                                    <div id="remove_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';} ?>;">
                                        <button data-toggle="modal" data-target="#myModal_unblock" title="Remove to Blocklist" onClick="return remove_block_list_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 Poppins-Regular f-14"> Blocklisted</button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    </div>
                </div>
            </div>
            <div class="m-b mt-4 hidden-lg hidden-md">
                <div class="row">
                    <div class="col-xs-12">
                        <p class="p-search OpenSans-Bold">
                            <?php echo $comm_model->display_data_na($member_data_val['matri_id']);?> |
                            <span class="p-search2">Profile Created By <?php echo $comm_model->display_data_na($member_data_val['profileby']);?></span>
                        </p>
                    </div>
                    <hr class="s-hr">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <?php $path_photos = $this->common_model->path_photos;			
						if(isset($member_data_val['photo1']) && $member_data_val['photo1'] !='' && isset($member_data_val['photo1_approve']) && $member_data_val['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$member_data_val['photo1']) && isset($member_data_val['photo_view_status']) && $member_data_val['photo_view_status'] == 0){?>
							<a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data_val['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="" class="img-responsive placeholder-img"></a>
						<?php }else{?>
							<a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>">
								<img src="<?php echo $comm_model->member_photo_disp($member_data_val);?>" class="img-responsive <?php if($comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/male.png' || $comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/female.png'){ echo 'placeholder-img';}else{ echo 's-img-1';}?>" title="<?php echo $comm_model->display_data_na($member_data_val['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data_val['matri_id']);?>">
							</a>
						<?php }?>
                        <div class="profile-card-btn">
                            <a href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id'];?>" class="s-card-1 OpenSans-Light">View Full Profile</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <hr class="s-hr">
                </div>
                <div class="row">
                    <div class="col-sm-12 col-xs-12">
                        <div class="dshbrd_more_details_btn w-100">
                            <p class="sr4 OpenSans-Light text-center mt-0">
                                <?php echo $comm_model->birthdate_disp($member_data_val['birthdate'],0);?>, <?php echo $comm_model->display_height($member_data_val['height']);?>, <?php echo $comm_model->display_data_na($member_data_val['religion_name']);?>, <?php echo $comm_model->display_data_na($member_data_val['mtongue_name']);?>
                            </p>
                            <?php include('page_part/mob_like_dislike.php');?>
                        </div>
                        <?php if(isset($member_id) && $member_id!='' && isset($member_data_val) && $member_data_val !=''  && is_array($member_data_val)){?>
                            <div class="row">
                                <div id="mob_more_details_btns_<?php echo $member_data_val['id'];?>" style="display: none;">
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                        <button data-toggle="modal" data-target="#myModal_sms" class="dshbrd_17 w-100  Poppins-Regular f-14" title="Send Message" onClick="return get_member_matri_id('<?php echo $member_data_val['matri_id'];?>')">
                                            Send Message
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 mt-2">
                                        <button class="dshbrd_17 w-100  Poppins-Regular f-14" data-toggle="modal" data-target="#myModal_sendinterest" onClick="return express_interest('<?php echo $member_data_val['matri_id'];?>')" title="Send Interest">
                                        Send Interest</button>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12 mt-2">
                                    <?php $where_arra=array('block_to'=>$result_member_matri_id,'block_by'=>$member_id);
                                        $data = $this->common_model->get_count_data_manual('block_profile',$where_arra,1,'id');
                                        $is_block_list = 0;
                                        if(isset($data) && $data > 0){
                                            $is_block_list = 1;
                                        }?>
                                        <input type="hidden" id="is_member_block_<?php echo $member_data_val['matri_id'];?>" name="is_member_block_<?php echo $member_data_val['matri_id'];?>" value="<?php if($is_block_list != 0){ echo 'is_member_block_'.$member_data_val['matri_id']; } ?>" >
                                        <div id="add_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';} ?>">
                                            <button data-toggle="modal" data-target="#myModal_block" title="Add to Blocklist" onClick="return add_block_list_matri_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 w-100  Poppins-Regular f-14">Blocklist</button>
                                        </div>
                                        <div id="remove_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';} ?>;">
                                            <button data-toggle="modal" data-target="#myModal_unblock" title="Remove to Blocklist" onClick="return remove_block_list_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 w-100  Poppins-Regular f-14"> Blocklisted</button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
            </div>
		</div>
	<?php }
}else{?>
    <div class="row-cstm mt-5">
        <div class="alert alert-danger">
            No Data found to display.
        </div>
    </div>
	<div class="clearfix"></div>
<?php }

$this->common_model->js_extra_code_fr.='
function more_details(id){
	$("#more_details_btns_"+id).fadeToggle();
}
function mob_more_details(id){
	$("#mob_more_details_btns_"+id).fadeToggle();
};';
?>