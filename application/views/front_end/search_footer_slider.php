<?php
$base_url = base_url();
$member_id = $this->common_front_model->get_session_data('matri_id');
$curre_gender = $this->common_front_model->get_session_data('gender');
$where_arra=array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'");
if(isset($curre_gender) && $curre_gender !='')
{
	$where_arra[] = " gender != '$curre_gender' " ;
}
$registerData = $this->common_model->get_count_data_manual('register_view',$where_arra,2,'*','id desc',1,6);


if(isset($curre_gender) && $curre_gender == 'Male'){
	$photopassword_image = $base_url.'assets/images/photopassword_female.png';
}else{
	$photopassword_image = $base_url.'assets/images/photopassword_male.png';
}
/*Get Plan Badges*/
$badge = $this->common_front_model->getbadges($registerData);
if(isset($registerData) && $registerData !='' && is_array($registerData) && count($registerData) > 0 )
{	
	$register_data = $this->common_front_model->process_data_search_slider_current_plan($registerData);
	//print_r($register_data);
	$path_photos = $this->common_model->path_photos;?>
    <div class="col-md-8 col-sm-12 col-xs-12 padding-left-zero-search">
        <div id="testimonial-slider" class="owl-carousel">
			<?php foreach($register_data as $member_data){
				$badgebackStyle = $badgeUrl = $badgeImg = $color = '';
				if (isset($member_data['plan_id']) && $member_data['plan_id']>0 && isset($member_data['plan_status']) && $member_data['plan_status']=='Paid') {
					$badgePath = $this->common_model->path_payment_logo;
					if (isset($badge['badge'][$member_data['plan_id']]) && $badge['badge'][$member_data['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$member_data['plan_id']])) {
						$badgeUrl = $base_url.$badgePath.$badge['badge'][$member_data['plan_id']];
						$badgeImg = "<img src = '".$badgeUrl."' style='right: 0px;top: -10px;z-index: 99;height: 90px;width: 90px;position: absolute;'/>";
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
                    <div class="pic" style="<?php echo $badgebackStyle;?>">
						<?php echo $badgeImg;?>
                    	<?php 
						$photo_view_count = $this->common_front_model->photo_protect_count($member_id,$member_data['matri_id']);
						if(isset($member_data['photo1']) && $member_data['photo1'] !='' && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && $member_data['photo_view_status']==0 && $photo_view_count==0){?>
                       		<a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="<?php echo $this->common_model->display_data_na($member_data['username']);?>" /></a>
                        <?php }else{?>
							<a href="<?php echo $base_url; ?>search/view-profile/<?php echo $member_data['matri_id'];?>" target="_blank" ><img src="<?php echo $this->common_model->member_photo_disp($member_data,$photo_view_count);?>" alt="<?php echo $this->common_model->display_data_na($member_data['username']);?>" /></a>
						<?php }?>
                    </div>
                    <div class="pic-2 pic_3">
                        <!-- <a href="<?php //echo $base_url; ?>search/view-profile/<?php //echo $member_data['matri_id'];?>"><p class="text-center matri-id-s"><?php //echo $this->common_model->display_data_na($member_data['username']);?></p></a> -->
						<!-- For issue start 29/11/2021  -->
						<a href="<?php echo $base_url; ?>search/view-profile/<?php echo $member_data['matri_id'];?>"><p class="text-center matri-id-s"><?php echo $this->common_model->display_data_na($member_data['matri_id']);?></p></a>
						<!-- For issue end 29/11/2021  -->
                        <p class="text-center matri-id-s-2 matri-zero">
							<?php echo $member_data['profile_description'];?>
                       </p>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
<?php }?>