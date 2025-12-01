    <div class="container new-width hidden-sm hidden-xs pro-t-hidden" style="width:93%;display:inherit;">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-12 padding-right-zero-search">
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 padding-left-zero-search">
                <div class="row-cstm mt-5 mb-5">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <?php if(isset($might_be) && $might_be!=''){?>
                            <p class="Poppins-Regular f-18 color-31 mb-30 dshbrd_13">You might also be interested in these new matching profiles</p>
                        <?php }else{?>
                        <p class="Poppins-Regular f-18 color-31 mb-30 dshbrd_13">Recently Logged in Members</p>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 padding-right-zero-search">
            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 padding-left-zero-search">
               <?php
                $member_id = $this->common_front_model->get_session_data('matri_id');
                if (isset($curre_gender) && $curre_gender == 'Male') {
                    $photopassword_image = $base_url . 'assets/images/photopassword_female.png';
                    } else {
                    $photopassword_image = $base_url . 'assets/images/photopassword_male.png';
                }
                $curre_gender = $this->common_front_model->get_session_data('gender');
                    $where_arra_login = array('is_deleted' => 'No', "status !='UNAPPROVED' and status !='Suspended'" ,'gender!=' => $curre_gender);
                    if(isset($might_be) && $might_be!=''){
                        $lastUpdatedProfile = $this->common_model->get_count_data_manual('register_view',$where_arra_login,2,'*','id desc',1,8);
                    
                    }else{
                        $lastUpdatedProfile = $this->common_model->get_count_data_manual('search_register_view', $where_arra_login, 2, '*', 'last_login desc', 1, 8);
                    }
                    //echo $this->db->last_query();
                    if (isset($lastUpdatedProfile) && $lastUpdatedProfile != '' && count($lastUpdatedProfile) > 0) {
                        /*Get Plan Badges*/
                        $badge = $this->common_front_model->getbadges($lastUpdatedProfile);
                        $last_updated_profile = $this->common_front_model->process_data_search_slider_current_plan($lastUpdatedProfile);
                       
					?>
                         <div id="testimonial-slider" class="owl-carousel">
                        <?php 
                        $i = 0;
                        foreach ($last_updated_profile as $member_data) {
                            $badgebackStyle = $badgeUrl = $badgeImg = $color = '';
                            if (isset($member_data['plan_id']) && $member_data['plan_id']>0 && isset($member_data['plan_status']) && $member_data['plan_status']=='Paid') {
                                $badgePath = $this->common_model->path_payment_logo;
                                if (isset($badge['badge'][$member_data['plan_id']]) && $badge['badge'][$member_data['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$member_data['plan_id']])) {
                                    $badgeUrl = $base_url.$badgePath.$badge['badge'][$member_data['plan_id']];
                                    $badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -6px;top: -10px;z-index: 99;height: 90px;width: 90px;'/>";
                                }
                                if (isset($badge['color'][$member_data['plan_id']]) && $badge['color'][$member_data['plan_id']]!='') {
                                    $color = $badge['color'][$member_data['plan_id']];
                                }
                            }
                            if($color == ''){
                                $color = $this->common_model->data['config_data']['profile_border_color'];
                            }
                            $badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";position: relative;";
                            ?>
                        <div class="testimonial">
                            <div class="pic <?php if(isset($i) && $i!=0){ echo 'pic-2_dshbrd';}?>" style="<?php echo $badgebackStyle;?>">
                            <?php 
                            echo $badgeImg;
                            $path_photos = $this->common_model->path_photos;
                            $photo_view_count = $this->common_front_model->photo_protect_count($member_id,$member_data['matri_id']);
                            if(isset($member_data['photo1']) && $member_data['photo1'] !='' && isset($member_data['photo1_approve']) && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && isset($member_data['photo_view_status']) && $member_data['photo_view_status'] == 0 && $photo_view_count == 0){?>
                                <a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt=""></a>
                            <?php }else{?>
                                <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data['matri_id']; ?>">
                                    <img src="<?php echo $comm_model->member_photo_disp($member_data,$photo_view_count);?>" title="<?php echo $comm_model->display_data_na($member_data['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data['matri_id']);?>">
                                </a>
                            <?php }?>
                            </div>
                            <div class="pic-2 pic-2_dshbrd">
                                <p class="text-center matri-id-s"><?php echo $comm_model->display_data_na($member_data['matri_id']);?> </p>
                                <p class="text-center matri-id-s-2 matri-zero color-f" style="color:#fff !important;"><?php echo $member_data['profile_description']; ?></p>
                            </div>
                            <button type="button" onclick="openInNewTab('<?php echo base_url().'search/view-profile/'.$member_data['matri_id']; ?>')" class="dshbrd_20 Poppins-Regular f-14">View Profile</button>
                        </div>
                        <?php 
                            $i++;    
                        }
						?>
                        </div> 
                        <?php 
                    }else{?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="no-data-f">
                                <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data">
                                <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                            </div>
                        </div>
                    <?php }
					?>
            </div>
        </div>
    </div>
    <?php $this->common_model->js_extra_code_fr .= "
    $(document).ready(function(){
        $('#testimonial-slider').owlCarousel({
            items:4,
            itemsDesktop:[1000,1],
            itemsDesktopSmall:[979,1],
            itemsTablet:[768,1],
            pagination:false,
            navigation:false,
            navigationText:['',''],
            autoPlay :3000,
            stopOnHover :true,
            dots:false
        });
    });
	function openInNewTab(url) {
		var win = window.open(url, '_blank');
		win.focus();
	}
    ";
    ?>