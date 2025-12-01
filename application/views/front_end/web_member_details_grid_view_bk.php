<?php 
$badgebackStyle = $badgeUrl = $badgeImg = $color = '';
if (isset($member_data_val['plan_id']) && $member_data_val['plan_id']>0 && isset($member_data_val['plan_status']) && $member_data_val['plan_status']=='Paid') {
    $badgePath = $this->common_model->path_payment_logo;
    if (isset($badge['badge'][$member_data_val['plan_id']]) && $badge['badge'][$member_data_val['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$member_data_val['plan_id']])) {
        $badgeUrl = $base_url.$badgePath.$badge['badge'][$member_data_val['plan_id']];
        $badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -10px;top: -20px;z-index: 99;height: 100px;width: 100px;'/>";
    }
    if (isset($badge['color'][$member_data_val['plan_id']]) && $badge['color'][$member_data_val['plan_id']]!='') {
        $color = $badge['color'][$member_data_val['plan_id']];
    }
}
if($color == ''){
    $color = $this->common_model->data['config_data']['profile_border_color'];
}
$badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";";
?>
<!-- -------------------------------------grid view----------------------------------- -->

<div class="col-md-3 col-sm-9 col-xs-12 hidden-sm hidden-xs">
   <div class="row">
      <div class="col-md-4 col-sm-4 col-xs-12">
         <div class="row">
         </div>
      </div>
      <div class="col-md-8 col-sm-8 col-xs-12 hidden-sm hidden-xs">
         <div class="demo-search pull-right">
            <div class="mt-4"></div>
         </div>
      </div>
   </div>
   <div class="clearfix"></div>
   <div class="m-b " style="<?php echo $badgebackStyle;?>position: relative;">
        <?php echo $badgeImg;?>
        <div class="row">
         <div class="col-md-12 col-sm-3 col-xs-12" style=" text-align: center;">
         <?php if(isset($member_data_val['gender']) && $member_data_val['gender']=='Female'){
                $photopassword_image = $base_url.'assets/images/photopassword_female.png';
            }elseif(isset($member_data_val['gender']) && $member_data_val['gender']=='Male'){
                $photopassword_image = $base_url.'assets/images/photopassword_male.png';
            }else{
                $photopassword_image = $photopassword_image;
            }
            $path_photos = $this->common_model->path_photos;
            if(isset($member_data_val['photo1']) && $member_data_val['photo1'] !='' && isset($member_data_val['photo1_approve']) && $member_data_val['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$member_data_val['photo1']) && isset($member_data_val['photo_view_status']) && $member_data_val['photo_view_status'] == 0){?>
                <a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data_val['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="" class="img-responsive placeholder-img"></a>
            <?php }else{?>
                <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>">
                    <img src="<?php echo $comm_model->member_photo_disp($member_data_val);?>" class="img-responsive <?php if($comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/male.png' || $comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/female.png'){ echo 'placeholder-img';}else{ echo 's-img-1';}?>" title="<?php echo $comm_model->display_data_na($member_data_val['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data_val['matri_id']);?>">
                </a>
            <?php }?>              
            <div class="profile-card-btn">
                <a style="font-size: 13px;" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id'];?>" class="s-card-1 OpenSans-Light">View Full Profile</a>
            </div>
         </div>
         <div class="col-md-12 col-sm-9 col-xs-12">
            <div class="row">
               <div class="col-md-12 col-sm-6 col-xs-6" style="
                  text-align: center;
                  margin-top: 10px;
                  ">                 
                    <p style="font-size: 12px;" class="p-search OpenSans-Bold">
                        <?php echo $comm_model->display_data_na($member_data_val['matri_id']);?> |
                        <span style="font-size: 12px;" class="p-search2">Profile Created By <?php echo $comm_model->display_data_na($member_data_val['profileby']);?></span>
                    </p>
                    <p  style="font-size: 12px;margin-bottom: -5px;"><?php echo $comm_model->birthdate_disp($member_data_val['birthdate'],0);?>, <?php echo $comm_model->display_height($member_data_val['height']);?>, <?php echo $comm_model->display_data_na($member_data_val['religion_name']);?>, <?php echo $comm_model->display_data_na($member_data_val['caste_name']);?></p>
                    
               </div>
            </div>
            <?php //include('like_dislike.php');?>
            <div class="row">
               <div class="col-md-12 col-sm-6 col-xs-12">
                  <div style="width: 100%;" class="dshbrd_more_details_btn">
                     <div class="row">
                        
                     </div>
                     <div class="row">
                     </div>
                  </div>
                  <div class="dshbrd_15">
                  </div>
               </div>
            </div>
            
         </div>
      </div>
   </div>
</div>
