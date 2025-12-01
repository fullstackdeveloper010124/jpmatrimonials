<?php
$matrimony=explode("-matrimony",$this->uri->segment(2));
$matrimony_name=$matrimony[0];
$comm_model = $this->common_model;
$is_login = $this->common_front_model->checkLogin("return");
$matri_id = $this->common_model->get_user_id("matri_id");
$email_id = $this->common_model->get_user_id("email");
$user_id = $this->common_model->get_user_id("id");
$get_user_data = $this->common_model->get_count_data_manual("register_view",array("id"=>$user_id),1);
?>

<div class="container-fluid new-width width-95">
	<?php include('register_search_sidebar.php');?>
	<!-- ===================== Desk top View End ======================== -->
	<!-- ===================== Desk top View Start ======================== -->
		
		<div class="col-md-9 col-sm-9 col-xs-12 padding-zero">
			<?php
			if(isset($matrimony_cnt) && $matrimony_cnt!='' && $matrimony_cnt > 0 && isset($matrimony_data) && is_array($matrimony_data) && count($matrimony_data) > 0){
				foreach($matrimony_data as $matrimony_data_last) {
					$matriidgroom=explode(",",$matrimony_data_last['matri_id_groom']);
					$matriidbride=explode(",",$matrimony_data_last['matri_id_bride']);
				?>
                    <div class="dshbrd_overlay mt-2 imp-matri">
                        <div class="dshbrd_color_overlay new-saved-search">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                     <h2 style=" font-size: 14px; margin: 0px;"> 
                                    <span class="saved-search-i Poppins-Medium"> <a href="<?php echo base_url();?>" class="saved-search-i"> <i class="fas fa-home text-white"></i></a>
                                        <span> <?php if(isset($matrimony_data_last['matrimony_name']) && $matrimony_data_last['matrimony_name']!=''){echo $matrimony_data_last['pagename'];	}?> </span>
                                    </span></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $path = base_url()."assets/community/banner/".$matrimony_data_last['banner'];
					if(isset($matrimony_data_last['banner']) && $matrimony_data_last['banner']!='' && @getimagesize($path)){?>
						<img src="<?php echo base_url();?>assets/community/banner/<?php if(isset($matrimony_data_last['banner']) && $matrimony_data_last['banner']!=''){echo $matrimony_data_last['banner'];}?>" alt="<?php if(isset($matrimony_data_last['matrimony_name']) && $matrimony_data_last['matrimony_name']!=''){echo $matrimony_data_last['pagename']; }?>" alt="" class="img-responsive new-matry-img">
					<?php }else{?>
						<img src="<?php echo base_url();?>assets/cover_photo/cover_photo.png" alt="" class="img-responsive new-matry-img">
					<?php }?>
                    <div class="dshbrd_overlay mt-2">
                        <div class="dshbrd_color_overlay new-saved-search">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h2 class="saved-search-i Poppins-Medium">
                                    	<?php if(isset($matrimony_data_last['title']) && $matrimony_data_last['title']!=''){ echo $matrimony_data_last['title'];}else{ echo "Matrimony";}?>
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
               
                    <div class="hidden-sm hidden-xs">
                        <h1 class="Poppins-Regular font-30-m color-38 dashbrd_3">
                             <?php if(isset($matrimony_data_last['pagename']) && $matrimony_data_last['pagename']!=''){ echo $matrimony_data_last['pagename'];//str_replace("-"," ",$matrimony_data_last['matrimony_name']).' Matrimony';
							}?> 
                        </h1>
                        <hr style="margin-bottom:15px;">
                    </div>
			 
					<?php include('register_search_sidebar_mob.php');?>
                    <div class="hidden-lg hidden-md">
                        <h1 class="Poppins-Regular font-30-m color-38 dashbrd_3">
                            <?php if(isset($matrimony_data_last['pagename']) && $matrimony_data_last['pagename']!=''){echo $matrimony_data_last['pagename'];//str_replace("-"," ",$matrimony_data_last['matrimony_name']).' Matrimony';
							}?> 
                        </h1>
                        <hr style="margin-bottom:15px;">
                    </div>
                    <p style="line-height: 24px;text-align: justify;"><?php if(isset($matrimony_data_last['matrimony_description']) && $matrimony_data_last['matrimony_description']!=''){echo $matrimony_data_last['matrimony_description'];}?></p>
                
			<div class="design-process-content-like das-content-2  padding-0">
				<div class="tab contact-tab-m contact-tab-vendor" role="tabpanel">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs new-matrimony-tab contact-tab-nav" role="tablist">
						<?php
                        //when user login with Male gender then this condition apply	
                        if(isset($gender_check) && $gender_check=="Male"){
                        ?>
                            <li role="presentation" class="active f-16">
                                <a href="#Female-user" aria-controls="Female-user" role="tab" data-toggle="tab">
                                Female</a>
                            </li>
                        <?php
                        }elseif(isset($gender_check) && $gender_check=="Female"){
                            //when user login with Female gender then this condition apply	
                        ?>
                            <li role="presentation" class="active f-16">
                                <h3>
                                <a href="#Male-user" aria-controls="Male-user" role="tab" data-toggle="tab">
                                Male</a>
                            </li>
                        <?php
                        }else{
                            //when user not login then this condition apply 
                        ?>
                            <li role="presentation" class="active f-16">
                                <a href="#Female-user" aria-controls="Female-user" role="tab" data-toggle="tab">Female</a>
                            </li>
                            <li role="presentation" class="f-16">
                                <a href="#Male-user" aria-controls="Male-user" role="tab" data-toggle="tab">Male</a>
                            </li>
                        <?php } ?>
					</ul>
					<!-- Tab panes -->
				</div>
				<hr class="hr-marimony">
				
                <div class="tab-content tabs">
                <?php 
				//when user login with Male gender then this condition apply			    
				if(isset($gender_check) && $gender_check=="Female"){?>
					<div role="tabpanel" class="tab-pane fade in active" id="Male-user">
                    <?php 
						if(isset($data_row_matri_groom) && is_array($data_row_matri_groom) && count($data_row_matri_groom)>0){
							$member_data = $data_row_matri_groom;
							$path_photos = $this->common_model->path_photos;
							$gender = 'Female';
							include('community_data_view.php');
							?>
							<div class="pagination-wrap mt-0">
								<?php if(isset($data_row_matri_groom_count) && $data_row_matri_groom_count !='' && $data_row_matri_groom_count > 5){
                                    echo $this->common_model->rander_pagination_front_Male("matrimony/".$matrimony_name,$data_row_matri_groom_count);
                                }?>
							</div>
							<?php 
						}else {?>
                            <div class="row-cstm mt-5">
                                <div class="alert alert-danger">
                                    No Data found to display.
                                </div>
                            </div>
						<?php }?>
					</div>
                <?php }elseif(isset($gender_check) && $gender_check=="Male"){?>
					<div role="tabpanel" class="tab-pane fade in active" id="Female-user">
                    <?php
						if(isset($data_row_matri_bride) && is_array($data_row_matri_bride) && is_array($data_row_matri_bride) && count($data_row_matri_bride)>0){
							$member_data = $data_row_matri_bride;
							$path_photos = $this->common_model->path_photos;
							//foreach ($member_result as $member_data_val) {
							$gender = 'Male';
							include('community_data_view.php');
							?>
							<div class="pagination-wrap mt-0">
								<?php if(isset($data_row_matri_bride_count) && $data_row_matri_bride_count !='' && $data_row_matri_bride_count > 5){
									echo $this->common_model->rander_pagination_front("matrimony/".$matrimony_name,$data_row_matri_bride_count);
								}?>
							</div>
						<?php }else{?>
                        	<div class="row-cstm mt-5">
                                <div class="alert alert-danger">
                                	No Data found to display.
                                </div>
                        	</div>
                        <?php }?>
					</div>
                <?php }else{?>
                    <div role="tabpanel" class="tab-pane fade in active" id="Female-user">
						<?php if(isset($data_row_matri_bride) && is_array($data_row_matri_bride) && is_array($data_row_matri_bride) && count($data_row_matri_bride)>0){
                            $member_data = $data_row_matri_bride;
                            
                            $path_photos = $this->common_model->path_photos;
                            $gender = 'Male';
                            include('community_data_view.php');
							?>
							<div class="pagination-wrap mt-0">
								<?php if(isset($data_row_matri_bride_count) && $data_row_matri_bride_count !='' && $data_row_matri_bride_count > 5){
									echo $this->common_model->rander_pagination_front("matrimony/".$matrimony_name,$data_row_matri_bride_count);
								}?>
							</div>
						<?php
                        }else{?>
                            <div class="row-cstm mt-5">
                                <div class="alert alert-danger">
                                	No Data found to display.
                                </div>
                        	</div>
                        <?php }?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Male-user">
                        <?php if(isset($data_row_matri_groom) && is_array($data_row_matri_groom) && count($data_row_matri_groom)>0){
							$member_data = $data_row_matri_groom;
							$path_photos = $this->common_model->path_photos;
							$gender = 'Female';
							include('community_data_view.php');
							?>
							<div class="pagination-wrap mt-0">
								<?php if(isset($data_row_matri_groom_count) && $data_row_matri_groom_count !='' && $data_row_matri_groom_count > 5){
									echo $this->common_model->rander_pagination_front_Male("matrimony/".$matrimony_name,$data_row_matri_groom_count);
								}?>
							</div>
						<?php
						}else{?>
							<div class="row-cstm mt-5">
								<div class="alert alert-danger">
									No Data found to display.
								</div>
							</div>
                    	<?php }?>
                    </div>
                <?php }?>
            </div>
        </div>
        <?php }
		}else{?>
            <div>
                <div class="no-data-f">
                    <img src="<?php echo base_url();?>assets/front_end_new/images/no-data.png" class="img-responsive no-data">
                    <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                </div>
            </div>
        <?php }?>
        <div class="hidden-lg hidden-md">
			<?php include('community_sidebar.php');?>
        </div>
    </div>
    <!-- ===================== Desk top View End ======================== -->
</div>
<?php include('page_part/front_button_popup.php');
include_once('photo_protect.php');
$this->common_model->js_extra_code_fr .= "
	var win = null;
	function newWindow(mypage,myname,w,h,features) {
		var winl = (screen.width-w)/2;
		var wint = (screen.height-h)/2;
		if (winl < 0) winl = 0;
		if (wint < 0) wint = 0;
		var settings = 'height=' + h + ',';
		settings += 'width=' + w + ',';
		settings += 'top=' + wint + ',';
		settings += 'left=' + winl + ',';
		settings += features;
		
		win = window.open(mypage,myname,settings);
		win.window.focus();
	}
	load_pagination_code_community();
";?>