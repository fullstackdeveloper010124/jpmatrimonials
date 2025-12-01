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
if($this->router->fetch_class()=='my_dashboard'){?>
    <div class="dshbrd_w-box" style="position: relative;">
    <?php echo $badgeImg;?>
                <div class="row-cstm mt-6">
                    <div class="m-b" style="<?php echo $badgebackStyle;?>">
                        <div class="row">
                            <div class="col-md-3 col-sm-3 col-xs-12">
<?php }else{?>
<div class="m-b <?php echo $mt;?>" style="<?php echo $badgebackStyle;?>position: relative;">
    <?php echo $badgeImg;?>
    <div class="row">
        <div class="col-md-3 col-sm-3 col-xs-12">
<?php }?>

			<?php if(isset($member_data_val['gender']) && $member_data_val['gender']=='Female'){
                $photopassword_image = $base_url.'assets/images/photopassword_female.png';
            }elseif(isset($member_data_val['gender']) && $member_data_val['gender']=='Male'){
                $photopassword_image = $base_url.'assets/images/photopassword_male.png';
            }else{
                $photopassword_image = $photopassword_image;
            }
            $path_photos = $this->common_model->path_photos;
            $photo_view_count = $this->common_front_model->photo_protect_count($member_id,$member_data_val['matri_id']);
			if(isset($member_data_val['photo1']) && $member_data_val['photo1'] !='' && isset($member_data_val['photo1_approve']) && $member_data_val['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$member_data_val['photo1']) && isset($member_data_val['photo_view_status']) && $member_data_val['photo_view_status'] == 0 && $photo_view_count == 0){?>
                <a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data_val['matri_id']; ?>')"><img src="<?php echo $photopassword_image; ?>" alt="" class="img-responsive placeholder-img"></a>
            <?php }else{?>
                <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>">
                    <img src="<?php echo $comm_model->member_photo_disp($member_data_val,$photo_view_count);?>" class="img-responsive <?php if($comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/male.png' || $comm_model->member_photo_disp($member_data_val) == $base_url.'assets/front_end/img/default-photo/female.png'){ echo 'placeholder-img';}else{ echo 's-img-1';}?>" title="<?php echo $comm_model->display_data_na($member_data_val['username']);?>" alt="<?php echo $comm_model->display_data_na($member_data_val['matri_id']);?>">
                </a>
            <?php }?>
            
        </div>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="p-search OpenSans-Bold">
                        <a target="_blank" href="<?php echo base_url()."search/view-profile/".$member_data_val['matri_id']; ?>"><?php echo $comm_model->display_data_na($member_data_val['matri_id']);?></a> |
                        <span class="p-search2">Profile Created By <?php echo $comm_model->display_data_na($member_data_val['profileby']);?></span>
                    </p>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6">
                    <p class="p-search3 OpenSans-Regular pull-right">
                        <!--Online Now-->
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 right-hr-animation new-p-animation">
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
                            if($edu==''){echo 'N/A';} else if(isset($edu) && $edu!='' && strlen($edu)>25){echo substr($edu,0,25).'...';} else{
                                echo $edu;
                            }?>
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
                            <?php echo $comm_model->display_data_na($member_data_val['income_name']);?>
                        </p>
                    </div>
                </div>
                <?php include('like_dislike.php');?>
            </div>
            
            <?php if($this->router->fetch_class()=='my_dashboard'){?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
else{?>
        </div>
    </div>
</div>
<?php }
    ?>
       