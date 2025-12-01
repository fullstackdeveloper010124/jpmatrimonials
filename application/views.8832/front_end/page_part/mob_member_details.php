<?php 
$badgebackStyle = $badgeUrl = $badgeImg = $color = '';
if (isset($member_data_val['plan_id']) && $member_data_val['plan_id']>0 && isset($member_data_val['plan_status']) && $member_data_val['plan_status']=='Paid') {
    $badgePath = $this->common_model->path_payment_logo;
    if (isset($badge['badge'][$member_data_val['plan_id']]) && $badge['badge'][$member_data_val['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$member_data_val['plan_id']])) {
        $badgeUrl = $base_url.$badgePath.$badge['badge'][$member_data_val['plan_id']];
        $badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -10px;top: -20px;z-index: 99;height: 144px;width: 144px;'/>";
    }
    if (isset($badge['color'][$member_data_val['plan_id']]) && $badge['color'][$member_data_val['plan_id']]!='') {
        $color = $badge['color'][$member_data_val['plan_id']];
    }
}
if($color == ''){
    $color = $this->common_model->data['config_data']['profile_border_color'];
}
$badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";position: relative;";
if($this->router->fetch_class()=='my_dashboard'){?>
    <div class="m-b mt-4 hidden-lg hidden-md" style="<?php echo $badgebackStyle;?>">
    <?php echo $badgeImg;?>
    <?php }
else{?>
    <div class="m-b mt-4" style="<?php echo $badgebackStyle;?>">
    <?php echo $badgeImg;?>
<?php }
    ?>
            <div class="row">
                <div class="col-xs-12">
                    <p class="p-search OpenSans-Bold">
                        <?php echo $comm_model->display_data_na($member_data_val['matri_id']);?> |
                        <span class="p-search2">Profile Created By <?php echo $comm_model->display_data_na($member_data_val['profileby']);?></span>
                        <!--<span class="p-search3 OpenSans-Regular pull-right">Online Now</span>-->
                    </p>
                </div>
                <hr class="s-hr">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php if(isset($member_data_val['gender']) && $member_data_val['gender']=='Female'){
						$photopassword_image = $base_url.'assets/images/photopassword_female.png';
					}elseif(isset($member_data_val['gender']) && $member_data_val['gender']=='Male'){
						$photopassword_image = $base_url.'assets/images/photopassword_male.png';
					}else{
						$photopassword_image = $photopassword_image;
					}
					$path_photos = $this->common_model->path_photos;
                    $photo_view_count = $this->common_front_model->photo_protect_count($member_id,$member_data_val['matri_id']);
                    if(isset($member_data_val['photo1']) && $member_data_val['photo1'] !='' && isset($member_data_val['photo1_approve']) && $member_data_val['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data_val['photo1']) && isset($member_data_val['photo_view_status']) && $member_data_val['photo_view_status'] == 0 && $photo_view_count == 0){?>
                        <a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data_val['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="" class="img-responsive s-img-1"></a>
                    <?php }else{?>
                        <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>">
                            <img src="<?php echo $comm_model->member_photo_disp($member_data_val,$photo_view_count);?>" class="img-responsive s-img-2" title="<?php echo $comm_model->display_data_na($member_data_val['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data_val['matri_id']);?>">
                        </a>
                    <?php }?>
                    <div class="profile-card-btn">
                        <a href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id'];?>" class="s-card-1 OpenSans-Light">View Full Profile</a>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 margin-top-10 right-hr new-p">
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
                        </div>
                    </div>
                    <?php include('mob_like_dislike.php');?>
                </div>
            </div>
            <?php if(isset($member_id) && $member_id!='' && isset($member_data_val) && $member_data_val !=''  && is_array($member_data_val)){?>
                <div class="row">
                    <div id="mob_more_details_btns_<?php echo $member_data_val['id'];?>" style="display: none;">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <button data-toggle="modal" data-target="#myModal_sms" class="dshbrd_17 w-100  Poppins-Regular f-14" title="Send Message" onClick="get_member_matri_id('<?php echo $member_data_val['matri_id'];?>')">
                                Send Message
                            </button>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 mt-2">
                            <button class="dshbrd_17 w-100  Poppins-Regular f-14" data-toggle="modal" data-target="#myModal_sendinterest" onClick="express_interest('<?php echo $member_data_val['matri_id'];?>')" title="Send Interest">
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
                            <!--<button type="button" class="dshbrd_17 Poppins-Regular f-14">Blocklist </button>-->
                            <div id="add_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';} ?>">
                                <button data-toggle="modal" data-target="#myModal_block" title="Add to Blocklist" onClick="add_block_list_matri_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 w-100  Poppins-Regular f-14">Blocklist</button>
                            </div>
                            <div id="remove_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';} ?>;">
                                <button data-toggle="modal" data-target="#myModal_unblock" title="Remove to Blocklist" onClick="remove_block_list_id('<?php echo $member_data_val['matri_id'];?>')" class="dshbrd_17 w-100  Poppins-Regular f-14"> Blocklisted</button>
                          </div>
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>