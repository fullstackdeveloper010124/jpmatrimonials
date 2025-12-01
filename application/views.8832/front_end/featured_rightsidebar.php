<?php 
$current_login_user = $this->common_front_model->get_session_data(); 
$login_user_matri_id ='';
$login_user_gender = '';
if(isset($current_login_user['matri_id']) && $current_login_user['matri_id']!=''){
	$login_user_matri_id = $current_login_user['matri_id'];
}
if(isset($current_login_user['gender']) && $current_login_user['gender']!=''){
	$login_user_gender = $current_login_user['gender'];
}

$gender = $this->common_front_model->get_session_data('gender');
if(isset($gender) && $gender == 'Male'){
	$photopassword_image = $base_url.'assets/images/photopassword_female.png';
}else{
	$photopassword_image = $base_url.'assets/images/photopassword_male.png';
}

$where_arra=array('is_deleted'=>'No','fstatus'=>'Featured',"status !='UNAPPROVED' and status !='Suspended' and plan_status='Paid'");
if($login_user_gender=='Male')
{
    $where_arra['gender'] = 'Female';
}
else if($login_user_gender=='Female')
{
    $where_arra['gender'] = 'Male';
}
$limit_count = ((isset($limit) && $limit!='')? $limit : 2 );
$class = ((isset($class) && $class!='')? $class:'');
$class1 = ((isset($class1) && $class1!='')? $class1 : '');
$class3 = ((isset($class3) && $class3!='')? $class3 : 'hidden-sm hidden-xs' );

$featured_profile_data = $this->common_model->get_count_data_manual('register_view',$where_arra,2,'*','id desc',1,$limit_count);
if(isset($featured_profile_data) && $featured_profile_data !='' && is_array($featured_profile_data) && count($featured_profile_data) > 0 ){
	/*Get Plan Badges*/
    $badge = $this->common_front_model->getbadges($featured_profile_data);	
?>
<div class="mega-box-new <?php echo $class3.' '.$class;?>">
    <?php 
		$path_photos = $this->common_model->path_photos;
		$i = 1;
		foreach($featured_profile_data as $featured_data){

			$badgePath = $this->common_model->path_payment_logo;
			if (isset($badge['badge'][$featured_data['plan_id']]) && $badge['badge'][$featured_data['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$featured_data['plan_id']])) {
				$badgeUrl = $base_url.$badgePath.$badge['badge'][$featured_data['plan_id']];
				$badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -6px;top: -10px;z-index: 99;height: 60px;width: 60px;'/>";
			}
			$color = '#ffffff';
			if (isset($badge['color'][$featured_data['plan_id']]) && $badge['color'][$featured_data['plan_id']]!='') {
				$color = $badge['color'][$featured_data['plan_id']];
			}
			$badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";position: relative;";
			
			$path_photos = $this->common_model->path_photos;
				if(isset($featured_data['photo1']) && $featured_data['photo1'] !='' && $featured_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$featured_data['photo1']) && $featured_data['photo_password'] !='' && $featured_data['photo_protect'] !='No' && $featured_data['photo_view_status'] == 0){
					$featured_image = '<a data-toggle="modal" data-target="#myModal_photoprotect" onClick="addstyle('.$login_user_matri_id.','.$featured_data['matri_id'].')"><img src="'.$photopassword_image.'" title="'.$featured_data['username'].'" alt="'.$featured_data['matri_id'].'" class="profile-s brd-raduis"></a>';
				}else{
					$featured_image = '<a href=""><img src="'.$this->common_model->member_photo_disp($featured_data).'" title="'.$featured_data['username'].'" alt="'.$featured_data['matri_id'].'" class="profile-s brd-raduis"></a>';
				}
			?>
            <div class="row" style="<?php echo $badgebackStyle;?>height: auto;padding: 10px 0px;">
				<?php echo $badgeImg;?>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <?php echo $featured_image;?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-9 p-2k-0">
					<div class="Prf_sidebar <?php echo $class1;?>">
                    <p class="Poppins-Semi-Bold f-15 mb-0"><?php echo $featured_data['username'];?></p>
                    <p class="Poppins-Regular f-12 mb-0">
					<?php if(isset($featured_data['birthdate']) && $featured_data['birthdate'] !='')
					{
						 $birthdate = $featured_data['birthdate'];
						 echo $this->common_model->birthdate_disp($birthdate,0);
					}
					else
					{
						echo $this->common_model->display_data_na('');
					}?>, <?php if(isset($featured_data['height']) && $featured_data['height'] !='')
					{
						$height = $featured_data['height'];
						echo $this->common_model->display_height($height);
					}
					else
					{
						echo $this->common_model->display_data_na('');
					}?>,
					<?php if(isset($featured_data['city_name']) && $featured_data['city_name'] !=''){
						echo $featured_data['city_name'];
					}
					else{
						echo $this->common_model->display_data_na($featured_data['country_name']);
					}?>,
                    <?php if(isset($featured_data['country_name']) && $featured_data['country_name'] !=''){
						echo $featured_data['country_name'];}
					else{
						echo $this->common_model->display_data_na($featured_data['country_name']);
					}?></p>
                    <div class="mega-n-btn1 post-s-d">
                        <a href="<?php echo $base_url."search/view-profile/".$featured_data['matri_id']; ?>" class="Poppins-Medium color-f f-14">View Profile</a>
                    </div>
					</div>
                </div>
            </div>
            <?php
			if($i != count($featured_profile_data)){?>
         	   <hr class="success-hr"/>
            <?php }
			$i++;
		}?>
	</div>
<?php }?>