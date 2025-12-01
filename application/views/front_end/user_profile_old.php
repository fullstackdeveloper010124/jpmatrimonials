<?php
	$member_id = $this->common_front_model->get_session_data('matri_id');
	$plan_status = $this->common_front_model->get_session_data('plan_status');
	$result_member_matri_id = $user_data['matri_id'];
	
	$no_remark= '';
	$yes_remark= '<i class="fas fa-check-circle color-d"></i>';
	
	$gender = $this->common_front_model->get_session_data('gender');
	if(isset($gender) && $gender == 'Male'){
		$photopassword_image = $base_url.'assets/images/photopassword_female.png';
		}else{
		$photopassword_image = $base_url.'assets/images/photopassword_male.png';
	}
 ?>
		<style>
			
			.breakword{
				word-break: break-word;
			}
		</style>
		<div class="container-fluid width-95">
			<div class="row-cstm">
				<!-- ====== Mobile View List Of Profile ========= -->
				<div class="m-b mt-4 hidden-lg hidden-md">
					<div class="row">
						<div class="col-xs-12">
							<p class="p-search OpenSans-Bold text-center">
							<?php 
							$path_photos = $this->common_model->path_photos;
							if(isset($user_data['matri_id']) && $user_data['matri_id'] !=''){ echo $user_data['matri_id'];}?> |
								<span class="p-search2 text-center">Profile Created By <?php if(isset($user_data['profileby']) && $user_data['profileby'] !=''){ echo ' by '.$user_data['profileby'];}?></span><br>
								<span class="p-search3 OpenSans-Regular text-center"><i class="fa fa-lock"></i> Last Login: <?php if(isset($user_data['last_login']) && $user_data['last_login'] !=''){ echo $this->common_model->displayDate($user_data['last_login']);}else{echo "Never";}?></span>
							</p>
						</div>
						<hr class="s-hr">
						<div class="col-md-3 col-sm-12 col-xs-12 text-center">
						<?php
							if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) &&  $user_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count == 0){
							?><a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $user_data['matri_id']; ?>')">
							<img src="<?php echo $photopassword_image; ?>" class="cursor img-responsive dshbrd-m-img-1">
						</a>
						<?php 
							}else{
							if(isset($user_data['gender']) && $user_data['gender'] == 'Male'){
								$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
								}else{
								$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
							}
							if(isset($user_data['photo1']) && $user_data['photo1'] !='' && $user_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$user_data['photo1']) && ($user_data['photo_view_status'] == 1 || ($user_data['photo_view_status'] == 2 && $plan_status == 'Paid') || (isset($user_data['photo_view_status']) &&  $user_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count > 0)))
							{ ?>
							<a href="javascript:;" data-toggle="modal" data-target="#myModal_new" onclick="currentSlide(1)"><img src="<?php echo $base_url; ?><?php echo $path_photos;?><?php echo $user_data['photo1'];?>"  class="cursor img-responsive dshbrd-m-img-1" alt="team-pic2"></a>
							
							<a href="javascript:;" class="text-center underline f-16 cursor2" data-toggle="modal" data-target="#myModal_new" onclick="currentSlide(1)">View Full Photo</a>
							<?php }
							else
							{ ?>
							<a href="javascript:;"><img src="<?php echo $defult_photo;?>" class="cursor img-responsive dshbrd-m-img-1" alt="team-pic2"></a>
							<?php   } 
						}	?>
							

							
						</div>
						
					</div>
					
					<div class="row">
						<hr class="s-hr">
					</div>
					
					<div class="row">
						<div class="col-sm-12 col-xs-12">
							<div class="dshbrd_more_details_btn w-100">
								<p class="sr4 OpenSans-Light text-center mt-0">
								<?php if(isset($user_data['birthdate']) && $user_data['birthdate'] !='')
															{
																$birthdate = $user_data['birthdate'];
																echo $this->common_model->birthdate_disp($birthdate,0).', ';
															}?><?php	if(isset($user_data['height']) && $user_data['height'] !='')
																{
																	$height = $user_data['height'];
																	echo $this->common_model->display_height($height).', ';
																}
																else
																{
																	echo $this->common_model->display_data_na('');
																}?><?php if(isset($user_data['religion_name']) && $user_data['religion_name'] !=''){ echo $user_data['religion_name'];}?> <?php 
																if(isset($user_data['languages_known']) && $user_data['languages_known'] !='')
																{ 
																	echo $this->common_model->valueFromId(' mothertongue',$user_data['languages_known'],'mtongue_name');	
																}
																?>
								</p>
								<?php 
	$result_member_matri_id = $user_data['matri_id'];
	$where_arra=array('to_id'=>$result_member_matri_id,'from_id'=>$member_id);
	$data = $this->common_model->get_count_data_manual('shortlist',$where_arra,1,'id');
	$is_short_list = 0;
	if(isset($data) && $data !='' && $data > 0)
	{
		$is_short_list = 1;
	}
	
	$member_likes_count = 0;
	$member_likes_data = array();
	$member_id_like = $this->common_front_model->get_session_data('matri_id');
	if(isset($member_id_like) && $member_id_like !='' && isset($user_data) && $user_data !='' )
	{
		$where_array = array('my_id'=>$member_id_like,'other_id'=>$user_data['matri_id']);
		$member_likes_data = $this->common_model->get_count_data_manual('member_likes',$where_array,1,'');
		$member_likes_count = $this->common_model->get_count_data_manual('member_likes',$where_array,0,'');
	}
	$yes_style = 'display:inline-block;';
	$no_style = 'display:inline-block;';
	$image_yes_style = 'display:none';
	$image_no_style = 'display:none;';
	$like_unlike = "YN";
	if(isset($member_likes_data) && $member_likes_data != '' && isset($member_likes_count) && $member_likes_count > 0){
		if($member_likes_data['like_status']=='Yes'){
			$like_unlike = "N";
			$yes_style = 'display:none;';
			$image_yes_style = 'display:inline-block;';
		}elseif($member_likes_data['like_status']=='No'){
			$like_unlike = "Y";
			$no_style = 'display:none;';
			$image_no_style = 'display:inline-block;';
		}
	}
	$more_details = 'No';
	if(isset($member_id) && $member_id!='' && isset($user_data) && $user_data !=''  && is_array($user_data)){
		$more_details = 'Yes';
	}?>
								<p class="sr4 f-14 OpenSans-Light text-center mt-0">
								<span id="mob_shorted_or_not_<?php echo $user_data['matri_id'];?>"><?php if($is_short_list==1){echo 'Shortlisted';}else{echo 'Shortlist';}?></span> or <span id="mob_like_unlike_<?php echo $user_data['matri_id'];?>">
								<?php if(isset($like_unlike) && $like_unlike=='YN'){ echo 'Like/Unlike';}
									else if(isset($like_unlike) && $like_unlike=='Y'){ echo 'Like';}
									else if(isset($like_unlike) && $like_unlike=='N'){ echo 'Unlike';}?>
								</span> profile
								</p>
								<div class="row">
									<div class="main-short text-center w-100">
										<div class="col-md-4 col-xs-4 col-sm-4">
											<div id="add_shortlist_mobile_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_short_list != 0){ echo 'none';}else{echo 'block';} ?>">
												<a data-toggle="modal" data-target="#myModal_shortlist" title="Add to Shortlist" onClick="add_shortlist_matri_id('<?php echo $user_data['matri_id'];?>')"><i class="fa fa-star-o sr-i1 sr-icon" title="Shortlist"></i></a>
											</div>
											<div id="remove_shortlist_mobile_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_short_list == 0){ echo 'none';}else{echo 'block';} ?>;">
												<a data-toggle="modal" data-target="#myModal_shortlisted" title="Remove to Shortlist" onClick="remove_shortlist_matri_id('<?php echo $user_data['matri_id'];?>')"><i class="fas fa-star sr-i1 sr-icon" title="Shortlist"></i></a>
											</div>
										</div>
										<div class="col-md-4 col-xs-4 col-sm-4">
											<a id="mob_Yes_id_<?php echo $user_data['matri_id'];?>" style="<?php echo $yes_style;?>" href="javascript:;" onclick="mob_member_like('Yes','<?php echo $user_data['matri_id'];?>');" >
												<i class="fas fa-check sr-i2 sr-icon" title="Like"></i>
											</a>
											<a id="mob_Image_Yes_<?php echo $user_data['matri_id'];?>" style="<?php echo $image_yes_style;?>">
												<i class="fas fa-check sr-i2 sr-icon" title="Liked"></i>
											</a>
										</div>
										<div class="col-md-4 col-xs-4 col-sm-4">
											<a id="mob_No_id_<?php echo $user_data['matri_id'];?>" style="<?php echo $no_style;?>" href="javascript:;" onclick="mob_member_like('No','<?php echo $user_data['matri_id']; ?>');">
												<i class="fas fa-times sr-i3 sr-icon" title="Unlike"></i>
											</a>
											<a id="mob_Image_No_<?php echo $user_data['matri_id'];?>" style="<?php echo $image_no_style;?>">
												<i class="fas fa-times sr-i3 sr-icon" title="Unliked"></i>
											</a>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="main-short-2 f-left w-100">
										<div class="col-md-4 col-xs-4 col-sm-4">
											<p class="Poppins-Bold-font text-center" id="mob_shorted_<?php echo $user_data['matri_id'];?>"><?php if($is_short_list==1){echo 'Shortlisted';}else{echo 'Shortlist';}?></p>
										</div>
										<div class="col-md-4 col-xs-4 col-sm-4">
											<p class="Poppins-Bold-font text-center" id="mob_like_<?php echo $user_data['matri_id'];?>"><?php if(isset($member_likes_data['like_status']) && $member_likes_data['like_status']=='Yes'){ echo 'Liked';}else{echo 'Like';}?></p>
										</div>
										<div class="col-md-4 col-xs-4 col-sm-4">
											<p class="Poppins-Bold-font text-center" id="mob_unlike_<?php echo $user_data['matri_id'];?>"><?php if(isset($member_likes_data['like_status']) && $member_likes_data['like_status']=='No'){ echo 'Unliked';}else{echo 'Unlike';}?></p>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div id="dshbrd_edit_btn_cstm-mobile">
										<div class="col-md-4 col-sm-4 col-xs-12">
											<button type="button" data-toggle="modal" data-target="#myModal_ViewContactDetails" onClick="get_ViewContactDetails('<?php echo $user_data['matri_id'];?>')" title="View Contact Detail" class="dshbrd_17 w-100  Poppins-Regular f-14">View Contact Detail</button>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
											<button type="button" data-toggle="modal" data-target="#myModal_sms" onclick="get_member_matri_id('<?php echo $user_data['matri_id'];?>')" title="Send Message" class="dshbrd_17 w-100  Poppins-Regular f-14">Send Message </button>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
											<button type="button" data-toggle="modal" data-target="#myModal_sendinterest" onclick="express_interest('<?php echo $user_data['matri_id'];?>')" title="Send Interest" class="dshbrd_17 w-100  Poppins-Regular f-14">Send Interest </button>
										</div>
										<div class="col-md-4 col-sm-4 col-xs-12 mt-2">
										<?php 
												$where_arra2=array('block_to'=>$result_member_matri_id,'block_by'=>$member_id);
												$data = $this->common_model->get_count_data_manual('block_profile',$where_arra2,1,'id');
												$is_block_list = 0;
												if($data > 0)
												{
													$is_block_list = 1;
												}
											?>
											
											<button data-toggle="modal" data-target="#myModal_block" class="dshbrd_17 w-100  Poppins-Regular f-14" title="Add to Blocklist" onclick="add_block_list_matri_id('<?php echo $user_data['matri_id'];?>')" id="add_blocklist_mobile_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';} ?>;">Block</button>
											<button data-toggle="modal" data-target="#myModal_unblock" class="dshbrd_17 w-100  Poppins-Regular f-14" title="Add to Unblocklist" onclick="remove_block_list_id('<?php echo $user_data['matri_id'];?>')" id="remove_blocklist_mobile_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';} ?>;">UnBlock</button>
											
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 hidden-lg hidden-md " style="padding:0px;">	
					<div class="row mt-3">
						<div class="col-md-12 col-xs-12">
							<div class="add-input new-accordion" style="right:0;width: 100%;">
								<div><!-- class="panel-group" id="accordion" -->
									<div class="panel-group" id="accordion">
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 data-toggle="collapse" data-parent="#accordion" data-target="#basic_collapse1" class="panel-title ">
													<i class="fa fa-plus pull-right"></i>
													<a href="javascript:void(0)" class="hover-l">Basic Details</a>
												</h4>
											</div>
											<div id="basic_collapse1" class="panel-collapse collapse">
												<div class="design-process-content bg-transparent-box-showdow">
												
													<div class="row">
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Name</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['username']) && $user_data['username'] !=''){ echo ucwords($user_data['username']);}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Weight</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php	if(isset($user_data['weight']) && $user_data['weight'] !='')
																	{
																		$weight = $user_data['weight'].' Kg';
																		echo $weight;
																	}
																	else
																	{
																		echo $this->common_model->display_data_na('');
																	}?></span>
														</div>
													
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Height</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
														<?php	if(isset($user_data['height']) && $user_data['height'] !='')
																{
																	$height = $user_data['height'];
																	echo $this->common_model->display_height($height);
																}
																else
																{
																	echo $this->common_model->display_data_na('');
																}?></span>
														</div>
													
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Marital Status</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['marital_status']) && $user_data['marital_status'] !='')
															{ 
																echo $user_data['marital_status'];
															}
															else
															{
																echo $this->common_model->display_data_na($user_data['marital_status']);
															}  ?>
															</span>
														</div>
														<?php 
														if(isset($user_data['marital_status']) && $user_data['marital_status'] !='')
														{
															if(isset($user_data['status_children']) && $user_data['status_children'] !='')
															{
																	if($user_data['marital_status']!='Unmarried')
																	{ ?>
																		<div class="col-md-4 col-sx-12 col-sm-4">
																			<h5 class="color-profile Poppins-Regular">Status Children</h5>
																			<span class="Poppins-Semi-Bold f-15 breakword breakword">
																			<?php echo $user_data['status_children'];?>
																			</span>
																		</div>
															<?php } 
															}?>
															<?php if(isset($user_data['total_children']) && $user_data['total_children'] !='' && $user_data['total_children'] > '0')
															{
																if($user_data['marital_status']!='Unmarried'){?>
															<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Total Children</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
																<?php echo $user_data['total_children'];?>
															</span>
															</div>
															<div class="clearfix"></div>
															<?php } 
															}
														}?>
													
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Mother Tongue</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
																if(isset($user_data['mother_tongue']) && $user_data['mother_tongue'] !='')
																{ 
																	echo $this->common_model->valueFromId(' mothertongue',$user_data['mother_tongue'],'mtongue_name');	
																}
																else
																{
																	echo $this->common_model->display_data_na('');
																}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Languages Known</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php 
																if(isset($user_data['languages_known']) && $user_data['languages_known'] !='')
																{ 
																	echo $this->common_model->valueFromId(' mothertongue',$user_data['languages_known'],'mtongue_name');	
																}
																else
																{
																	echo $this->common_model->display_data_na('');
																}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Birthdate</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php if(isset($user_data['birthdate']) && $user_data['birthdate'] !='')
																{
																$birthdate = $user_data['birthdate'];
																echo $newDate = date("d/m/Y", strtotime($birthdate));
																}
																else
																{
																echo $this->common_model->display_data_na('');
																}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Country</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php if(isset($user_data['country_name']) && $user_data['country_name'] !='')
																{
																	echo $country_name = $user_data['country_name'];
																}
																else
																{
																	echo $this->common_model->display_data_na('');
																}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">State</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php if(isset($user_data['state_name']) && $user_data['state_name'] !='')
																{
																	echo $state_name = $user_data['state_name'];
																}
																else
																{
																echo $this->common_model->display_data_na('');
																}?></span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">City</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php if(isset($user_data['city_name']) && $user_data['city_name'] !='')
																{
																	echo $city_name = $user_data['city_name'];
																}
																else
																{
																echo $this->common_model->display_data_na('');
																}?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 data-toggle="collapse" data-parent="#accordion" data-target="#about_collapse2" class="panel-title ">
													<i class="fa fa-plus pull-right"></i>
													<a href="javascript:void(0)" class="hover-l">About Me</a>
												</h4>
											</div>
											<div id="about_collapse2" class="panel-collapse collapse">
												<div class="design-process-content bg-transparent-box-showdow">
													<div class="row">
														<div class="col-md-12 col-sx-12 col-sm-12">
															<h5 class="color-profile Poppins-Regular">About Us</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['profile_text']) && $user_data['profile_text'] !=''){ 
																echo $profile_text = strip_tags($user_data['profile_text']);	
															}
															else{
																echo $this->common_model->display_data_na('');
															}?></span>
														</div>
													</div>
													<div class="row mt-3">
														<div class="col-md-12 col-sx-12 col-sm-12">
															<h5 class="color-profile Poppins-Regular">Hobby</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['hobby']) && $user_data['hobby'] !=''){ 
																echo $hobby = strip_tags($user_data['hobby']);	
															}
															else{
																echo $this->common_model->display_data_na('');
															}?></span>
														</div>
													</div>
                                                    <div class="row mt-3">
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Birth Place</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['birthplace']) && $user_data['birthplace'] !=''){ 
																echo $birthplace = strip_tags($user_data['birthplace']);	
															}
															else{
																echo $this->common_model->display_data_na('');
															}?></span>
														</div>
													</div>
                                                    <div class="row mt-3">
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Birth Time</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['birthtime']) && $user_data['birthtime'] !=''){ 
																$birthtime = strip_tags($user_data['birthtime']);	
																echo $this->common_model->displayDate($birthtime,'h:i A');
															}
															else{
																echo $this->common_model->display_data_na('');
															}?></span>
														</div>
													</div>
                                                    <div class="row mt-3">
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Created By</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">
															<?php 
															if(isset($user_data['profileby']) && $user_data['profileby'] !=''){ 
																echo $profileby = strip_tags($user_data['profileby']);	
															}
															else{
																echo $this->common_model->display_data_na('');
															}?></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="panel panel-default">
											<div class="panel-heading">
												<h4 data-toggle="collapse" data-parent="#accordion" data-target="#horoscope_collapse3" class="panel-title ">
													<i class="fa fa-plus pull-right"></i>
													<a href="javascript:void(0)" class="hover-l">Religious Details</a>
												</h4>
											</div>
											<div id="horoscope_collapse3" class="panel-collapse collapse">
												<div class="design-process-content bg-transparent-box-showdow">
													<div class="row">
													<?php 
													$path_horoscope = $this->common_model->path_horoscope;
													
													if(isset($user_data['horoscope_photo']) && $user_data['horoscope_photo'] !='' && $user_data['horoscope_photo_approve'] == 'APPROVED' && file_exists($path_horoscope.$user_data['horoscope_photo'])){
														$horoscope = $base_url.$path_horoscope.$user_data['horoscope_photo'];?>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Horoscope</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><a data-toggle="modal" href="#myModal123" class=" ">Click & View</a>
															</span>
														</div>
														<?php } else{?>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Horoscope</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword">N/A</span>
														</div>
														<?php }?>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Religion</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['religion_name']) && $user_data['religion_name'] !=''){ echo $user_data['religion_name'];}else{echo $this->common_model->display_data_na($user_data['religion_name']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Caste</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['caste_name']) && $user_data['caste_name'] !=''){ echo $user_data['caste_name'];}else{echo $this->common_model->display_data_na($user_data['caste_name']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Sub Caste</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['subcaste']) && $user_data['subcaste'] !=''){ echo $user_data['subcaste'];}else{echo $this->common_model->display_data_na($user_data['subcaste']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Manglik</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['manglik']) && $user_data['manglik'] !=''){ echo $user_data['manglik'];}else{echo $this->common_model->display_data_na($user_data['manglik']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Star</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['star']) && $user_data['star'] !=''){ echo $this->common_model->valueFromId('star',$user_data['star'],'star_name');}else{echo $this->common_model->display_data_na($user_data['star']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Gothra</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['gothra']) && $user_data['gothra'] !=''){ echo $user_data['gothra'];}else{echo $this->common_model->display_data_na($user_data['gothra']);}?>
															</span>
														</div>
														<div class="col-md-4 col-sx-12 col-sm-4">
															<h5 class="color-profile Poppins-Regular">Moonsign</h5>
															<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['moonsign']) && $user_data['moonsign'] !=''){ echo $this->common_model->valueFromId('moonsign',$user_data['moonsign'],'moonsign_name');}else{echo $this->common_model->display_data_na($user_data['moonsign']);}?>
															</span>
														</div>
													
													</div>
												</div>
											</div>
										</div>
									
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 data-toggle="collapse" data-parent="#accordion" data-target="#collapse6" class="panel-title ">
												<i class="fa fa-plus pull-right"></i>
												<a href="javascript:void(0)" class="hover-l">Education 
												& Profession</a>
											</h4>
										</div>
										<div id="collapse6" class="panel-collapse collapse">
											<div class="design-process-content bg-transparent-box-showdow">
												<div class="row mt-3">
													<div class="col-md-4 col-sx-12 col-sm-4">
														<h5 class="color-profile Poppins-Regular">Education</h5>
														<span class="Poppins-Semi-Bold f-15 breakword breakword">
														<?php 
															if(isset($user_data['education_detail']) && $user_data['education_detail'] !='')
															{ 
																echo $this->common_model->valueFromId('education_detail',$user_data['education_detail'],'education_name');	
															}
															else
															{
																echo $this->common_model->display_data_na('');
															}?>
														</span>
													</div>
													<div class="col-md-4 col-sx-12 col-sm-4">
														<h5 class="color-profile Poppins-Regular">Designation</h5>
														<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['designation_name']) && $user_data['designation_name'] !=''){ echo $user_data['designation_name'];}else{echo $this->common_model->display_data_na($user_data['designation_name']);}?></span>
													</div>
													<div class="col-md-4 col-sx-12 col-sm-4">
														<h5 class="color-profile Poppins-Regular">Employed in </h5>
														<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['employee_in']) && $user_data['employee_in'] !=''){ echo $user_data['employee_in'];}else{echo $this->common_model->display_data_na($user_data['employee_in']);}?></span>
													</div>
													
													<div class="col-md-4 col-sx-12 col-sm-4">
														<h5 class="color-profile Poppins-Regular">Occupation</h5>
														<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['occupation_name']) && $user_data['occupation_name'] !=''){ echo $user_data['occupation_name'];}else{echo $this->common_model->display_data_na($user_data['occupation_name']);}?></span>
													</div>
													<div class="col-md-4 col-sx-12 col-sm-4">
														<h5 class="color-profile Poppins-Regular">Annual Income</h5>
														<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['income']) && $user_data['income'] !=''){ echo $user_data['income'];}else{echo $this->common_model->display_data_na($user_data['income']);}?></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 data-toggle="collapse" data-parent="#accordion" data-target="#life-2" class="panel-title ">
											<i class="fa fa-plus pull-right"></i>
											<a href="javascript:void(0)" class="hover-l">Life Style</a>
										</h4>
									</div>
									<div id="life-2" class="panel-collapse collapse">
										<div class="design-process-content bg-transparent-box-showdow">
											<div class="row mt-3">
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Veg / Non</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php 
													if(isset($user_data['diet']) && $user_data['diet'] !='')
													{
														echo $user_data['diet'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}
												?>
												</span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Drink</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['drink']) && $user_data['drink'] !='')
													{ 
														echo $user_data['drink'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Smoking</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['smoke']) && $user_data['smoke'] !='')
													{ 
														echo $user_data['smoke'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Body Type</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['bodytype']) && $user_data['bodytype'] !='')
													{ 
														echo $user_data['bodytype'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Skin Tone</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['complexion']) && $user_data['complexion'] !='')
													{ 
														echo $user_data['complexion'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
                                            <div class="col-md-4 col-sx-12 col-sm-4">
                                                <h5 class="color-profile Poppins-Regular">Blood Group</h5>
                                                <span class="Poppins-Semi-Bold f-15 breakword breakword">
                                                <?php 
												if(isset($user_data['blood_group']) && $user_data['blood_group'] !=''){ 
													echo $blood_group = strip_tags($user_data['blood_group']);	
												}
												else{
													echo $this->common_model->display_data_na('');
												}?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
							
							
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 data-toggle="collapse" data-parent="#accordion" data-target="#family3" class="panel-title ">
										<i class="fa fa-plus pull-right"></i>
										<a href="javascript:void(0)" class="hover-l">Family Details</a>
									</h4>
								</div>
								<div id="family3" class="panel-collapse collapse">
									<div class="design-process-content bg-transparent-box-showdow">
										
										<div class="row mt-3">
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Family Type</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php 
													if(isset($user_data['family_type']) && $user_data['family_type'] !='')
													{
														echo $user_data['family_type'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}
												?>
												</span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Family Status</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['family_status']) && $user_data['family_status'] !='')
													{ 
														echo $user_data['family_status'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Father Name</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['father_name']) && $user_data['father_name'] !='')
													{ 
														echo $user_data['father_name'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Mother Name</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['mother_name']) && $user_data['mother_name'] !='')
													{ 
														echo $user_data['mother_name'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											
											
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Father Occupation</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['father_occupation']) && $user_data['father_occupation'] !='')
													{ 
														echo $user_data['father_occupation'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Mother Occupation</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['mother_occupation']) && $user_data['mother_occupation'] !='')
													{ 
														echo $user_data['mother_occupation'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">No of Brother</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['no_of_brothers']) && $user_data['no_of_brothers'] !='')
													{ 
														echo $user_data['no_of_brothers'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">No of Sister</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['no_of_sisters']) && $user_data['no_of_sisters'] !='')
													{ 
														echo $user_data['no_of_sisters'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">No of Married Brother</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['no_of_married_brother']) && $user_data['no_of_married_brother'] !='')
													{ 
														echo $user_data['no_of_married_brother'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">No of Married Sister</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['no_of_married_sister']) && $user_data['no_of_married_sister'] !='')
													{ 
														echo $user_data['no_of_married_sister'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											
											<div class="col-md-4 col-sx-12 col-sm-4">
												<h5 class="color-profile Poppins-Regular">Family Details</h5>
												<span class="Poppins-Semi-Bold f-15 breakword breakword">
												<?php if(isset($user_data['family_details']) && $user_data['family_details'] !='')
													{ 
														echo $user_data['family_details'];
													}
													else
													{
														echo $this->common_model->display_data_na('');
													}	?></span>
											</div>
											</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 data-toggle="collapse" data-parent="#accordion" data-target="#PREFERENCES" class="panel-title ">
										<i class="fa fa-plus pull-right"></i>
										<a href="javascript:void(0)" class="hover-l">
										PARTNER PREFERENCES<br>
                        				<span class="Poppins-Regular f-14 matches_number">You match <?php $match_count=0;?><span id="match_count_result1"></span>/9 of her Preference</span></a>
									</h4>
								</div>
								<div id="PREFERENCES" class="panel-collapse collapse">
									<div class="design-process-content bg-transparent-box-showdow">
									<div class="row">
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Age
											<?php
											if(isset($user_data['part_frm_age']) && $user_data['part_frm_age'] !='' && isset($user_data['part_to_age']) && $user_data['part_to_age'] !='')
											{
												$part_frm_age = $user_data['part_frm_age'];
												$part_to_age = $user_data['part_to_age'];
												$login_user_age = $this->common_model->birthdate_disp($member_data['birthdate'],0);
												$age_between = range($part_frm_age,$part_to_age);
												//if($part_frm_age >= $login_user_age && $login_user_age <=$part_to_age )
												if(in_array($login_user_age,$age_between))
												{
													echo $yes_remark;
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['part_frm_age']) && $user_data['part_frm_age'] !='')
													{
														echo $user_data['part_frm_age'];
													}
													else
													{
														echo $this->common_model->display_data_na($user_data['part_frm_age']);
													}?> to 
											<?php if(isset($user_data['part_to_age']) && $user_data['part_to_age'] !='')
												{ 
													echo $user_data['part_to_age'];
												}
												else
												{	
													echo $this->common_model->display_data_na($user_data['part_to_age']);
												}?></span>
										</div>
										
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Height
											<?php 
											if(isset($user_data['part_height']) && $user_data['part_height'] !='')
											{
												$height_from = $user_data['part_height'];
												$height_to = $user_data['part_height_to'];
												$login_user_height = $member_data['height'];
												$height_between = range($height_from,$height_to);
												
												if(in_array($login_user_height,$height_between))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['part_height']) && $user_data['part_height'] !='' && isset($user_data['part_height_to']) && $user_data['part_height_to'] !='')
												{
													$height = $user_data['part_height'];
													echo $this->common_model->display_height($height);
												}
												else
												{
													echo $this->common_model->display_data_na('');
												}?> to <?php if(isset($user_data['part_height_to']) && $user_data['part_height_to'] !='')
												{
													$height = $user_data['part_height_to'];
													echo $this->common_model->display_height($height);
												}
												else
												{
													echo $this->common_model->display_data_na('');
												}?></span>
										</div>
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Marital Status
											<?php 
											if(isset($user_data['looking_for']) && $user_data['looking_for'] !='')
											{
												$user_data_value = $user_data['looking_for'];
												$member_data_value = $member_data['marital_status'];
												$user_data_value_arr =explode(',',$user_data_value);
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?></h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['looking_for']) && $user_data['looking_for'] !='')
												{
													echo $user_data['looking_for'];
												}else{
													echo $this->common_model->display_data_na('');
												}
												?></span>
										</div>
									</div>
									
									
									<div class="row mt-3">
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Religion / Community
											<?php  
											if(isset($user_data['part_religion']) && $user_data['part_religion'] !='')
											{
												$user_data_value = $user_data['part_religion'];
												$member_data_value = $member_data['religion'];
												$user_data_value_arr =explode(',',$user_data_value);
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['part_religion']) && $user_data['part_religion'] !='')
													{ 
														echo $religion = $this->common_model->valueFromId('religion',$user_data['part_religion'],'religion_name');
													}else{
														echo  $this->common_model->display_data_na('');
													}
												?> 
											</span>
										</div>
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Mother Tongue
											<?php  
											if(isset($user_data['part_mother_tongue']) && $user_data['part_mother_tongue'] !='')
											{ 
												$user_data_value = $user_data['part_mother_tongue'];
												$member_data_value = $member_data['mother_tongue'];
												$user_data_value_arr =explode(',',$user_data_value);
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php 
											if(isset($user_data['part_mother_tongue']) && $user_data['part_mother_tongue'] !='')
											{ 
												echo $mothertongue = $this->common_model->valueFromId('mothertongue',$user_data['part_mother_tongue'],'mtongue_name');	
												
											}else{
												echo  $this->common_model->display_data_na('');
											}?>
											</span>
										</div>
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Country Living in
											<?php 
											if(isset($user_data['part_country_living']) && $user_data['part_country_living'] !='')
											{ 
												$user_data_value = $user_data['part_country_living'];
												
												$member_data_value = $member_data['country_id'];
												$user_data_value_arr =explode(',',$user_data_value);
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php 
												if(isset($user_data['part_country_living']) && $user_data['part_country_living'] !='')
												{ 
													echo $country = $this->common_model->valueFromId('country_master',$user_data['part_country_living'],'country_name');	
													
												}else{
													echo  $this->common_model->display_data_na('');
												}
												?>
											</span>
										</div>
									</div>
									
									<div class="row mt-3">
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Education
											<?php  
											if(isset($user_data['part_education']) && $user_data['part_education'] !='')
											{ 	
												$education = $this->common_model->valueFromId('education_detail',$user_data['part_education'],'education_name');	
												$user_data_value = $education;
												$member_data_value = $this->common_model->valueFromId('education_detail',$member_data['education_detail'],'education_name');
												//echo $member_data_value;
												$user_data_value_arr =explode(',',$user_data_value);
												$member_data_value_arr =explode(',',$member_data_value);
												$result_arr = array_intersect($member_data_value_arr, $user_data_value_arr);		
												$result_arr_count = count($result_arr);
												if(isset($result_arr) && $result_arr!='' && $result_arr_count>0)
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['part_education']) && $user_data['part_education'] !='')
												{ 
													echo $education = $this->common_model->valueFromId('education_detail',$user_data['part_education'],'education_name');
												}else{
													echo  $this->common_model->display_data_na('');
												}?>
											</span>
										</div>
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Profession Area
											<?php  
											if(isset($user_data['part_occupation']) && $user_data['part_occupation'] !='')
											{ 
												$occupation = $this->common_model->valueFromId('occupation',$user_data['part_occupation'],'occupation_name');
												$user_data_value = $occupation;
												$member_data_value = $this->common_model->valueFromId('occupation',$member_data['occupation'],'occupation_name');	
												$user_data_value_arr =explode(',',$user_data_value);
												
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">		
											<?php if(isset($user_data['part_occupation']) && $user_data['part_occupation'] !='')
												{ 
													echo $occupation = $this->common_model->valueFromId('occupation',$user_data['part_occupation'],'occupation_name');
												}else{
													echo  $this->common_model->display_data_na('');
												}?>
											</span>
										</div>
										<div class="col-md-4 col-sx-12 col-sm-4">
											<h5 class="color-profile Poppins-Regular">Working As
											<?php
											if(isset($user_data['part_designation']) && $user_data['part_designation'] !='')
											{  
												$designation = $this->common_model->valueFromId('designation',$user_data['part_designation'],'designation_name');
												$user_data_value = $designation;
												$member_data_value = $this->common_model->valueFromId('designation',$member_data['designation'],'designation_name');
												$user_data_value_arr =explode(',',$user_data_value);
												if(in_array($member_data_value,$user_data_value_arr))
												{
													echo $yes_remark;
													
												}
												else
												{
													echo $no_remark;
												}
											}?>
											</h5>
											<span class="Poppins-Semi-Bold f-15 breakword breakword">
											<?php if(isset($user_data['part_designation']) && $user_data['part_designation'] !='')
												{ 
													echo $designation = $this->common_model->valueFromId('designation',$user_data['part_designation'],'designation_name');
												}else{
													echo  $this->common_model->display_data_na('');
												}?>
											</span>
										</div>
									</div>
								</div>
							</div>
							
                        </div>
						<?php
							if(isset($user_data['video_url']) && $user_data['video_approval'] =='APPROVED')
							{?>
						<div class="panel panel-default">
							<div class="panel-heading">
								<h4 data-toggle="collapse" data-parent="#accordion" data-target="#video" class="panel-title ">
									<i class="fa fa-plus pull-right"></i>
									<a href="javascript:void(0)" class="hover-l">
									Uploaded Video<br>
								</h4>
							</div>
							<div id="video" class="panel-collapse collapse">
								<div class="design-process-content bg-transparent-box-showdow">
									<div class="row">
										<div class="col-md-4 col-sx-12 col-sm-4">
										<?php
										
											
											preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$user_data['video_url'],$matches);
											
										?>
										
											<object data="http://www.youtube.com/v/<?php echo $matches[1];?>" style="width:100%; height:300px;"></object>								
										
										  
										</div>
									</div>
								</div>
							</div>	
						</div>
						<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ====== Mobile View List Of Profile ========= -->

<!-- ===================== Desk top View Start ======================== -->
<?php include_once('my_profile_sidebar.php');?>
</div>
<!-- ===================== Desk top View End ======================== -->

<!-- ===================== Desk top View Start ======================== -->


<div class="col-md-9 col-sm-9 col-xs-12 hidden-sm hidden-xs">
	<div class="dshbrd_side_section">
		<div class="dshbrd_overlay">
		<?php 
					$photos = array();
					$photo_upload_count = $this->common_model->photo_upload_count;
					if($photo_upload_count =='' || $photo_upload_count > 0  || $photo_upload_count < 8)
					{
						$photo_upload_count = 8;
					}
					for($i_photo = 1;$i_photo<=$photo_upload_count;$i_photo++)
					{
						$photos[] = array('photo'=>$user_data['photo'.$i_photo],'status'=>$user_data['photo'.$i_photo.'_approve']);
					}
					$path_photos = $this->common_model->path_photos;
					$path_cover_photo = $this->common_model->path_cover_photo;
					if(isset($user_data['cover_photo']) && $user_data['cover_photo']!='' && $user_data['cover_photo_approve']=='APPROVED' && file_exists($path_cover_photo.$user_data['cover_photo']))
					{
						$cover_photo_final = $base_url.$path_cover_photo.$user_data['cover_photo'];
						}else{ 
						//$cover_photo_final = $base_url.$path_cover_photo."cover_photo.png";
						$cover_photo_final = $base_url.$this->common_model->default_cover_photo;
					}
				if(isset($user_data['cover_photo']) && $user_data['cover_photo'] !='' && file_exists($user_data['cover_photo'])){?>
						<style>.dshbrd_color_overlay {
					background-image: url(<?php echo $cover_photo_final;?>);}</style>
				<?php }else{?>
					<style>.dshbrd_color_overlay {
					background-image: url(<?php echo $cover_photo_final;?>);}</style>
				<?php }?>
			<div class="dshbrd_color_overlay">
				<div class="side_panel_dshbrd">
					<div class="row margin-0">  
						<div class="col-md-2 col-sm-2 col-xs-12 text-center">
						<?php
							if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) &&  $user_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count == 0){
							?><a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $user_data['matri_id']; ?>')">
							<img src="<?php echo $photopassword_image; ?>" class="cursor img-responsive dshbrd_pro">
						</a>
						<?php 
							}else{
							if(isset($user_data['gender']) && $user_data['gender'] == 'Male'){
								$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
								}else{
								$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
							}
							if(isset($user_data['photo1']) && $user_data['photo1'] !='' && $user_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$user_data['photo1']) && ($user_data['photo_view_status'] == 1 || ($user_data['photo_view_status'] == 2 && $plan_status == 'Paid') || (isset($user_data['photo_view_status']) &&  $user_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count > 0)))
							{ ?>
							<a href="javascript:;"><img src="<?php echo $base_url; ?><?php echo $path_photos;?><?php echo $user_data['photo1'];?>" data-toggle="modal" data-target="#myModal_new"  onclick="currentSlide(1)" class="cursor img-responsive dshbrd_pro" alt="team-pic2"></a>
							
							<a href="javascript:;" class="text-center underline font-12 cursor1" data-toggle="modal" data-target="#myModal_new"  onclick="currentSlide(1)">View Full Photo</a>
							<?php }
							else
							{ ?>
							<a href="javascript:;"><img src="<?php echo $defult_photo;?>" class="cursor img-responsive dshbrd_pro" alt="team-pic2"></a>
							<?php   } 
						}	?>
							<!-- <img src="" alt="" class="img-responsive dshbrd_pro"> -->
							<?php 
						$photos = array();
						$photo_upload_count = $this->common_model->photo_upload_count;
						if($photo_upload_count =='' || $photo_upload_count > 0  || $photo_upload_count < 8)
						{
							$photo_upload_count = 8;
						}
						for($i_photo = 1;$i_photo<=$photo_upload_count;$i_photo++)
						{
							$photos[] = array('photo'=>$user_data['photo'.$i_photo],'status'=>$user_data['photo'.$i_photo.'_approve']);
						}
						$path_photos = $this->common_model->path_photos;
						?>
					
					
					<div class="clearfix"></div>
						</div>
						
						
						<div class="col-md-7 col-sm-7 col-xs-12">
							<div class="l-height-19">
								<div class="row-cstm">
									<div class="col-md-12 col-sm-4 col-xs-12 padding-0">
										<p class="Poppins-Semi-Bold f-20 color-f dshbrd_pro_nme"><?php if(isset($user_data['username']) && $user_data['username'] !=''){ echo ucwords(substr($user_data['username'],0,11));}?> (<?php if(isset($user_data['matri_id']) && $user_data['matri_id'] !=''){ echo $user_data['matri_id'];}?>)</p>
									</div>
									
									
									
								</div>
								
								<div class="row-cstm">
									<div class="col-md-12 col-sm-12 col-xs-12 padding-0">
										<p class="Poppins-Regular f-14 color-f  dshbrd_pro_nme"><?php if(isset($user_data['occupation_name']) && $user_data['occupation_name'] !=''){ echo $user_data['occupation_name'];}?></p>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="row-cstm mt-3">
									<div class="col-md-4 col-sm-4 col-xs-4 padding-0">
										<p class="Poppins-Regular f-14 color-f dshbrd_pro_nme">Date of Birth</p>
									</div>
									
									<div class="col-md-4 col-sm-4 col-xs-4 padding-0">
										<p class="Poppins-Medium f-14 color-f dshbrd_pro_nme">
										<?php if(isset($user_data['birthdate']) && $user_data['birthdate'] !='')
											  {
												echo $this->common_model->birthdate_disp($user_data['birthdate']);
												//echo $newDate = date("d/m/Y", strtotime($birthdate));
											  }
											  else
											  {
												echo $this->common_model->display_data_na('');
											  }?></p>
									</div>
									
									<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
									</div>
								</div>
								<div class="clearfix"></div>
								
								<div class="row-cstm">
									<div class="col-md-4 col-sm-4 col-xs-4 padding-0">
										<p class="Poppins-Regular f-14 color-f dshbrd_pro_nme">Last Login</p>
									</div>
									
									<div class="col-md-4 col-sm-4 col-xs-4 padding-0">
										<p class="Poppins-Medium f-14 color-f dshbrd_pro_nme"><?php if(isset($user_data['last_login']) && $user_data['last_login'] !=''){ echo $this->common_model->displayDate($user_data['last_login']);}else{echo "Never";}?></p>
									</div>
									
									<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
									</div>
								</div>
								<div class="clearfix"></div>
								
								<div class="row-cstm">
									<div class="col-md-8 col-sm-8 col-xs-8 padding-0">
										<p class="Poppins-Regular f-14 color-f dshbrd_pro_nme">Profile Created <?php if(isset($user_data['profileby']) && $user_data['profileby'] !=''){ echo ' by '.$user_data['profileby'];}?></p>
									</div>
									
									<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
									</div>
								</div>
								<div class="clearfix"></div>
								<?php 
											$where_array = array('my_id'=>$member_id,'other_id'=>$user_data['matri_id']);
											$member_likes_data = $this->common_model->get_count_data_manual('member_likes',$where_array,1,'');
											$member_likes__count = $this->common_model->get_count_data_manual('member_likes',$where_array,0,'');
											$yes_style = 'display:inline-block;';
											$no_style = 'display:inline-block;';
											$image_yes_style = 'display:none';
											$image_no_style = 'display:none;';
											//$may_be_style = 'display:inline-block;';
											//$image_may_be_style = 'display:none;';
											
											if($member_likes__count > 0 && $member_likes_data != ''){
												if($member_likes_data['like_status']=='Yes'){
													$yes_style = 'display:none;';
													$image_yes_style = 'display:inline-block;';
												}
												elseif($member_likes_data['like_status']=='No'){
													$no_style = 'display:none;';
													$image_no_style = 'display:inline-block;';
												}
												/*
													elseif($member_likes_data['like_status']=='May be'){
													$may_be_style = 'display:none;';
													$image_may_be_style = 'display:inline-block;';
												}*/
											}
										?>
							</div>
							
							<div class="row">
								<div class="col-md-12 col-sm-12 col-xs-12 pr-0">
									<ul class="list-inline new-view-p">
										<li><a href="javascript:;" data-toggle="modal" data-target="#myModal_ViewContactDetails" onClick="get_ViewContactDetails('<?php echo $user_data['matri_id'];?>')">View Contact Detail</a></li>
										<li><a href="javascript:;" data-toggle="modal" data-target="#myModal_sms" title="Send Message" onclick="get_member_matri_id('<?php echo $user_data['matri_id'];?>')">Send Message</a></li>

										<li><a href="javascript:;" data-toggle="modal" data-target="#myModal_sendinterest" onclick="express_interest('<?php echo $user_data['matri_id'];?>')" title="Send Interest">Send Interest</a></li>

										<li>
										<?php 
												$where_arra=array('to_id'=>$result_member_matri_id,'from_id'=>$member_id);
												$data = $this->common_model->get_count_data_manual('shortlist',$where_arra,1,'id');
												$is_short_list = 0;
												if($data > 0)
												{
													$is_short_list = 1;
												}
											?>
										<a href="javascript:;" data-toggle="modal" data-target="#myModal_shortlist" title="Add to Shortlist" onclick="add_shortlist_matri_id('<?php echo $user_data['matri_id'];?>')" id="add_shortlist_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_short_list != 0){ echo 'none';} ?>;">Shortlist</a>
										<a href="javascript:;" data-toggle="modal" data-target="#myModal_shortlisted" title="Add to Shortlist" onclick="remove_shortlist_matri_id('<?php echo $user_data['matri_id'];?>')" id="remove_shortlist_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_short_list == 0){ echo 'none';} ?>;">Shortlisted</a></li>

										<li>
										<?php 
												$where_arra=array('block_to'=>$result_member_matri_id,'block_by'=>$member_id);
												$data = $this->common_model->get_count_data_manual('block_profile',$where_arra,1,'id');
												$is_block_list = 0;
												if($data > 0)
												{
													$is_block_list = 1;
												}
											?>
										<a href="javascript:;" data-toggle="modal" data-target="#myModal_block" title="Add to Blocklist" onclick="add_block_list_matri_id('<?php echo $user_data['matri_id'];?>')" id="add_blocklist_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';} ?>;">Block</a>
										<a href="javascript:;" data-toggle="modal" data-target="#myModal_unblock" title="Add to Unblocklist" onclick="remove_block_list_id('<?php echo $user_data['matri_id'];?>')" id="remove_blocklist_<?php echo $user_data['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';} ?>;">UnBlock</a>
										<input type="hidden" id="is_member_block_<?php echo $user_data['matri_id'];?>" name="is_member_block_<?php echo $user_data['matri_id'];?>" value="<?php if($is_block_list != 0){ echo 'is_member_block_'.$user_data['matri_id']; } ?>" />
										</li>
									</ul> 
								</div>
								
							</div>
						</div>
						<div class="col-md-3 col-sm-3 col-xs-12 padding-0">
							<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
								<div class="dshbrd_edit_btns dshbrd_right_1">
								<button id="Yes_id_mobile" style="<?php echo $yes_style;?>" onclick="member_like('Yes','<?php echo $user_data['matri_id'];?>','mobile');" type="button" class="dshbrd_11 Poppins-Medium f-14"> <i class="fa fa-thumbs-up"></i> Like</button>
									<!-- <a id="Yes_id_mobile" style="<?php //echo $yes_style;?>" href="javascript:;" onclick="member_like('Yes','<?php //echo $user_data['matri_id'];?>','mobile');" class="btn-sm btn no-shadow m-7 s-7 xs-7" title="Yes"><i class="fa fa-thumbs-up ne_mrg_ri8_10"></i>Like</a> -->
									
									<!-- <a id="Image_Yes_mobile" style="<?php //echo $image_yes_style;?>">
										<img style="background:gray;" alt="You have like this member." title="You have like this member." src='<?php //echo $base_url; ?>assets/images/like.png' />
									</a> -->
									
								</div>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-12 padding-0">
								<div class="dshbrd_edit_btns dshbrd_right">
									<button id="No_id_mobile" style="<?php echo $no_style;?>" onclick="member_like('No','<?php echo $user_data['matri_id']; ?>','mobile');" type="button" class="dshbrd_12 Poppins-Medium f-14"><i class="fa fa-thumbs-down"></i> Unlike</button>
									<!-- <a  id="No_id_mobile" style="<?php echo $no_style;?>" href="javascript:;" onclick="member_like('No','<?php //echo $user_data['matri_id']; ?>','mobile');" class="btn-sm btn no-shadow m-7 s-7 xs-7" title="No"><i class="fa fa-thumbs-down ne_mrg_ri8_10"></i>Unlike</a> -->
									<!-- <a id="Image_No_mobile" style="<?php //echo $image_no_style;?>">
										<img style="background:gray;" alt="You didn't like this member." title="You didn't like this member." src='<?php //echo $base_url; ?>assets/images/dislike.png' />
									</a> -->
									
								</div>
							</div>
						</div>
					</div>
					
				</div> 
				
			</div>
		</div>
	</div>
	<div class='curved-border sample1'>
	</div>
	<div class="">
		<div class="row">
			<div class="col-xs-12"> 
				<!-- design process steps--> 
				<!-- Nav tabs -->
				<ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
					<li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab"><i class="fas fa-address-card basic-info-icon" aria-hidden="true"></i>
						<p class="basic-info-text">Basic Details</p>
					</a></li>
					<li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fas fa-info-circle about-icon"></i>
						<p class="about-text">About Me</p>
					</a></li>
					<li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-star h-d-icon" aria-hidden="true"></i>
						<p class="h-d-text">Religious Details</p>
						
					</a></li>
					<li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab"><i class="fas fa-school ed-icon"></i>
						<p class="ed-text">Education 
						& Profession</p>
					</a></li>
					<li role="presentation"><a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fas fa-heartbeat l-s-icon"></i>
						<p class="l-s-text">Life Style</p>
					</a></li>
					
					<li role="presentation"><a href="#family" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fas fa-star f-d-icon-2"></i>
						<p class="f-d-text">Family
						Details</p>
					</a></li>
				</ul>
				<!-- end design process steps--> 
				<!-- Tab panes -->
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="discover">
						<div class="design-process-content">
							<div class="row">
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Name</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword"><?php if(isset($user_data['username']) && $user_data['username'] !=''){ echo ucwords($user_data['username']);}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Weight</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php	if(isset($user_data['weight']) && $user_data['weight'] !='')
											{
												$weight = $user_data['weight'].' Kg';
												echo $weight;
											}
											else
											{
												echo $this->common_model->display_data_na('');
											}?></span>
								</div>
							
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Height</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php	if(isset($user_data['height']) && $user_data['height'] !='')
										{
											$height = $user_data['height'];
											echo $this->common_model->display_height($height);
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
							
							
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Marital Status</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php 
									if(isset($user_data['marital_status']) && $user_data['marital_status'] !='')
									{ 
										echo $user_data['marital_status'];
									}
									else
									{
										echo $this->common_model->display_data_na($user_data['marital_status']);
									}  ?>
									</span>
								</div>
								<?php 
								if(isset($user_data['marital_status']) && $user_data['marital_status'] !='')
								{
									if(isset($user_data['status_children']) && $user_data['status_children'] !='')
									{
											if($user_data['marital_status']!='Unmarried')
											{ ?>
												<div class="col-md-4 col-sx-12 col-sm-4">
													<h5 class="color-profile Poppins-Regular">Status Children</h5>
													<span class="Poppins-Semi-Bold f-15 breakword breakword">
													<?php echo $user_data['status_children'];?>
													</span>
												</div>
									<?php } 
									}?>
									<?php if(isset($user_data['total_children']) && $user_data['total_children'] !='' && $user_data['total_children'] > '0')
									{
										if($user_data['marital_status']!='Unmarried'){?>
									<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Total Children</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
										<?php echo $user_data['total_children'];?>
									</span>
									</div>
									<div class="clearfix"></div>
									<?php } 
									}
								}?>
						
								
							
							<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Mother Tongue</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php 
										if(isset($user_data['mother_tongue']) && $user_data['mother_tongue'] !='')
										{ 
											echo $this->common_model->valueFromId(' mothertongue',$user_data['mother_tongue'],'mtongue_name');	
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Languages Known</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php 
										if(isset($user_data['languages_known']) && $user_data['languages_known'] !='')
										{ 
											echo $this->common_model->valueFromId(' mothertongue',$user_data['languages_known'],'mtongue_name');	
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Birthdate</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php if(isset($user_data['birthdate']) && $user_data['birthdate'] !='')
										{
										$birthdate = $user_data['birthdate'];
										echo $newDate = date("d/m/Y", strtotime($birthdate));
										}
										else
										{
										echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Country</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['country_name']) && $user_data['country_name'] !='')
										{
											echo $country_name = $user_data['country_name'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">State</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['state_name']) && $user_data['state_name'] !='')
										{
											echo $state_name = $user_data['state_name'];
										}
										else
										{
										echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">City</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['city_name']) && $user_data['city_name'] !='')
										{
											echo $city_name = $user_data['city_name'];
										}
										else
										{
										echo $this->common_model->display_data_na('');
										}?></span>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="strategy">
						<div class="design-process-content">
						<div class="row">
							<div class="col-md-12 col-sx-12 col-sm-12">
								<h5 class="color-profile Poppins-Regular">About Us</h5>
								<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php 
									if(isset($user_data['profile_text']) && $user_data['profile_text'] !='')
									{ 
										echo $profile_text = strip_tags($user_data['profile_text']);	
									}
									else
									{
										echo $this->common_model->display_data_na('');
									}?>
                            	</span>
							</div>
							<div class="col-md-12 col-sx-12 col-sm-12">
								<h5 class="color-profile Poppins-Regular">Hobby</h5>
								<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php 
									if(isset($user_data['hobby']) && $user_data['hobby'] !='')
									{ 
										echo $hobby = strip_tags($user_data['hobby']);	
									}
									else
									{
										echo $this->common_model->display_data_na('');
									}?></span>
							</div>
                        </div>
                        <div class="row">
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Birth Place</h5>
								<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php 
								if(isset($user_data['birthplace']) && $user_data['birthplace'] !=''){ 
									echo $birthplace = strip_tags($user_data['birthplace']);	
								}
								else{
									echo $this->common_model->display_data_na('');
								}?></span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Birth Time</h5>
								<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php 
								if(isset($user_data['birthtime']) && $user_data['birthtime'] !=''){ 
									$birthtime = strip_tags($user_data['birthtime']);	
									echo $this->common_model->displayDate($birthtime,'h:i A');	
								}
								else{
									echo $this->common_model->display_data_na('');
								}?></span>
							</div>
                            <div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Created By</h5>
								<span class="Poppins-Semi-Bold f-15 breakword breakword">
								<?php 
								if(isset($user_data['profileby']) && $user_data['profileby'] !=''){ 
									echo $profile_by = strip_tags($user_data['profileby']);	
								}
								else{
									echo $this->common_model->display_data_na('');
								}?></span>
							</div>
						</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="optimization">
						<div class="design-process-content">
							<div class="row">
							<?php 
								$path_horoscope = $this->common_model->path_horoscope;
								
								if(isset($user_data['horoscope_photo']) && $user_data['horoscope_photo'] !='' && $user_data['horoscope_photo_approve'] == 'APPROVED' && file_exists($path_horoscope.$user_data['horoscope_photo']))
								{
									$horoscope = $base_url.$path_horoscope.$user_data['horoscope_photo'];
								
								?>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Horoscope</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><a data-toggle="modal" href="#myModal123" class=" ">Click & View</a></span>
								</div>
								<?php } else{?>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Horoscope</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">N/A</span>
								</div>
								<?php }?>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Religion</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['religion_name']) && $user_data['religion_name'] !=''){ echo $user_data['religion_name'];}else{echo $this->common_model->display_data_na($user_data['religion_name']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Caste</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['caste_name']) && $user_data['caste_name'] !=''){ echo $user_data['caste_name'];}else{echo $this->common_model->display_data_na($user_data['caste_name']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Sub Caste</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['subcaste']) && $user_data['subcaste'] !=''){ echo $user_data['subcaste'];}else{echo $this->common_model->display_data_na($user_data['subcaste']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Manglik</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['manglik']) && $user_data['manglik'] !=''){ echo $user_data['manglik'];}else{echo $this->common_model->display_data_na($user_data['manglik']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Star</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['star']) && $user_data['star'] !=''){ echo $this->common_model->valueFromId('star',$user_data['star'],'star_name');}else{echo $this->common_model->display_data_na($user_data['star']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Gothra</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['gothra']) && $user_data['gothra'] !=''){ echo $user_data['gothra'];}else{echo $this->common_model->display_data_na($user_data['gothra']);}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Moonsign</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['moonsign']) && $user_data['moonsign'] !=''){ echo $this->common_model->valueFromId('moonsign',$user_data['moonsign'],'moonsign_name');}else{echo $this->common_model->display_data_na($user_data['moonsign']);}?>
									</span>
								</div>
							</div>
							
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="education">
						<div class="design-process-content">
							<div class="row mt-3">
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Education</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php 
										if(isset($user_data['education_detail']) && $user_data['education_detail'] !='')
										{ 
											echo $this->common_model->valueFromId('education_detail',$user_data['education_detail'],'education_name');	
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Designation</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['designation_name']) && $user_data['designation_name'] !=''){ echo $user_data['designation_name'];}else{echo $this->common_model->display_data_na($user_data['designation_name']);}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Employed in </h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['employee_in']) && $user_data['employee_in'] !=''){ echo $user_data['employee_in'];}else{echo $this->common_model->display_data_na($user_data['employee_in']);}?></span>
								</div>
								
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Occupation</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['occupation_name']) && $user_data['occupation_name'] !=''){ echo $user_data['occupation_name'];}else{echo $this->common_model->display_data_na($user_data['occupation_name']);}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Annual Income</h5>
									<span class="Poppins-Semi-Bold f-15 breakword"><?php if(isset($user_data['income']) && $user_data['income'] !=''){ echo $user_data['income'];}else{echo $this->common_model->display_data_na($user_data['income']);}?></span>
								</div>
								
							</div>  
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="reporting">
						<div class="design-process-content">
							<div class="row">
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Veg / Non</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php 
										if(isset($user_data['diet']) && $user_data['diet'] !='')
										{
											echo $user_data['diet'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}
									?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Drink</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php if(isset($user_data['drink']) && $user_data['drink'] !='')
										{ 
											echo $user_data['drink'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Smoking</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php if(isset($user_data['smoke']) && $user_data['smoke'] !='')
										{ 
											echo $user_data['smoke'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Body Type</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php if(isset($user_data['bodytype']) && $user_data['bodytype'] !='')
										{ 
											echo $user_data['bodytype'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Skin Tone</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">
									<?php if(isset($user_data['complexion']) && $user_data['complexion'] !=''){ 
										echo $user_data['complexion'];
									}
									else{
										echo $this->common_model->display_data_na('');
									}?></span>
								</div>
                                <div class="col-md-4 col-sx-12 col-sm-4">
                                    <h5 class="color-profile Poppins-Regular">Blood Group</h5>
                                    <span class="Poppins-Semi-Bold f-15 breakword breakword">
                                    <?php 
                                    if(isset($user_data['blood_group']) && $user_data['blood_group'] !=''){ 
                                        echo $blood_group = strip_tags($user_data['blood_group']);	
                                    }
                                    else{
                                        echo $this->common_model->display_data_na('');
                                    }?></span>
                                </div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="family">
						<div class="design-process-content">
							<div class="row mt-3">
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Family Type</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php 
										if(isset($user_data['family_type']) && $user_data['family_type'] !='')
										{
											echo $user_data['family_type'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}
									?>
									</span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Family Status</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['family_status']) && $user_data['family_status'] !='')
										{ 
											echo $user_data['family_status'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Father Name</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['father_name']) && $user_data['father_name'] !='')
										{ 
											echo $user_data['father_name'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Mother Name</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['mother_name']) && $user_data['mother_name'] !='')
										{ 
											echo $user_data['mother_name'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								
								
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Father Occupation</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['father_occupation']) && $user_data['father_occupation'] !='')
										{ 
											echo $user_data['father_occupation'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">Mother Occupation</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['mother_occupation']) && $user_data['mother_occupation'] !='')
										{ 
											echo $user_data['mother_occupation'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">No of Brother</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['no_of_brothers']) && $user_data['no_of_brothers'] !='')
										{ 
											echo $user_data['no_of_brothers'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">No of Sister</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['no_of_sisters']) && $user_data['no_of_sisters'] !='')
										{ 
											echo $user_data['no_of_sisters'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">No of Married Brother</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['no_of_married_brother']) && $user_data['no_of_married_brother'] !='')
										{ 
											echo $user_data['no_of_married_brother'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
								<div class="col-md-4 col-sx-12 col-sm-4">
									<h5 class="color-profile Poppins-Regular">No of Married Sister</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['no_of_married_sister']) && $user_data['no_of_married_sister'] !='')
										{ 
											echo $user_data['no_of_married_sister'];
										}
										else
										{
											echo $this->common_model->display_data_na('');
										}	?></span>
								</div>
                            </div>
                            <div class="row">
								<div class="col-md-12 col-sx-12 col-sm-12">
									<h5 class="color-profile Poppins-Regular">Family Details</h5>
									<span class="Poppins-Semi-Bold f-15 breakword breakword">
									<?php if(isset($user_data['family_details']) && $user_data['family_details'] !=''){ 
										echo $user_data['family_details'];
									}
									else{
										echo $this->common_model->display_data_na('');
									}?>
                                    </span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-3">
			<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="design-process-content padding-0">
					<div class="box-view-profile">
						<span class="Poppins-Semi-Bold mega-n3 f-16">PARTNER <span class="mega-n4 f-16">PREFERENCES</span></span>
                        <span class="Poppins-Regular color-7c f-14 pull-right matches_number">You match <?php $match_count=0;?><span id="match_count_result"></span>/9 of her Preference</span>
						
					</div>
					<hr class="hr-view">
					<div class="box-view-profile" style="padding:9px 12px;">
						<div class="row">
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Age
								<?php
								if(isset($user_data['part_frm_age']) && $user_data['part_frm_age'] !='' && isset($user_data['part_to_age']) && $user_data['part_to_age'] !='')
								{
									$part_frm_age = $user_data['part_frm_age'];
									$part_to_age = $user_data['part_to_age'];
									$login_user_age = $this->common_model->birthdate_disp($member_data['birthdate'],0);
									$age_between = range($part_frm_age,$part_to_age);
									//if($part_frm_age >= $login_user_age && $login_user_age <=$part_to_age )
									if(in_array($login_user_age,$age_between))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['part_frm_age']) && $user_data['part_frm_age'] !='')
										{
											echo $user_data['part_frm_age'];
										}
										else
										{
											echo $this->common_model->display_data_na($user_data['part_frm_age']);
										}?> to 
								<?php if(isset($user_data['part_to_age']) && $user_data['part_to_age'] !='')
									{ 
										echo $user_data['part_to_age'];
									}
									else
									{	
										echo $this->common_model->display_data_na($user_data['part_to_age']);
									}?></span>
							</div>
							
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Height
								<?php 
								if(isset($user_data['part_height']) && $user_data['part_height'] !='')
								{
									$height_from = $user_data['part_height'];
									$height_to = $user_data['part_height_to'];
									$login_user_height = $member_data['height'];
									$height_between = range($height_from,$height_to);
									
									if(in_array($login_user_height,$height_between))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['part_height']) && $user_data['part_height'] !='' && isset($user_data['part_height_to']) && $user_data['part_height_to'] !='')
									{
										$height = $user_data['part_height'];
										echo $this->common_model->display_height($height);
									}
									else
									{
										echo $this->common_model->display_data_na('');
									}?> to <?php if(isset($user_data['part_height_to']) && $user_data['part_height_to'] !='')
									{
										$height = $user_data['part_height_to'];
										echo $this->common_model->display_height($height);
									}
									else
									{
										echo $this->common_model->display_data_na('');
									}?></span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Marital Status
								<?php 
								if(isset($user_data['looking_for']) && $user_data['looking_for'] !='')
								{
									$user_data_value = $user_data['looking_for'];
									$member_data_value = $member_data['marital_status'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?></h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['looking_for']) && $user_data['looking_for'] !='')
									{
										echo $user_data['looking_for'];
									}else{
										echo $this->common_model->display_data_na('');
									}
									?></span>
							</div>
						</div>
						
						
						<div class="row mt-3">
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Religion / Community
								<?php  
								if(isset($user_data['part_religion']) && $user_data['part_religion'] !='')
								{
									$user_data_value = $user_data['part_religion'];
									$member_data_value = $member_data['religion'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['part_religion']) && $user_data['part_religion'] !='')
										{ 
											echo $religion = $this->common_model->valueFromId('religion',$user_data['part_religion'],'religion_name');
										}else{
											echo  $this->common_model->display_data_na('');
										}
									?> 
								</span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Mother Tongue
								<?php  
								if(isset($user_data['part_mother_tongue']) && $user_data['part_mother_tongue'] !='')
								{ 
									$user_data_value = $user_data['part_mother_tongue'];
									$member_data_value = $member_data['mother_tongue'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php 
								if(isset($user_data['part_mother_tongue']) && $user_data['part_mother_tongue'] !='')
								{ 
									echo $mothertongue = $this->common_model->valueFromId('mothertongue',$user_data['part_mother_tongue'],'mtongue_name');	
									
								}else{
									echo  $this->common_model->display_data_na('');
								}?>
								</span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Country Living in
								<?php 
								if(isset($user_data['part_country_living']) && $user_data['part_country_living'] !='')
								{ 
									$user_data_value = $user_data['part_country_living'];
									
									$member_data_value = $member_data['country_id'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php 
									if(isset($user_data['part_country_living']) && $user_data['part_country_living'] !='')
									{ 
										echo $country = $this->common_model->valueFromId('country_master',$user_data['part_country_living'],'country_name');	
										
									}else{
										echo  $this->common_model->display_data_na('');
									}
									?>
								</span>
							</div>
						</div>
						
						<div class="row mt-3">
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Education
								<?php  
								if(isset($user_data['part_education']) && $user_data['part_education'] !='')
								{ 		
									$education = $this->common_model->valueFromId('education_detail',$user_data['part_education'],'education_name');
									$user_data_value = $education;
									$member_data_value = $this->common_model->valueFromId('education_detail',$member_data['education_detail'],'education_name');
									//echo $member_data_value;
									$user_data_value_arr =explode(',',$user_data_value);
									$member_data_value_arr =explode(',',$member_data_value);
									$result_arr = array_intersect($member_data_value_arr, $user_data_value_arr);		
									$result_arr_count = count($result_arr);
									if(isset($result_arr) && $result_arr!='' && $result_arr_count>0)
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['part_education']) && $user_data['part_education'] !='')
									{ 
										echo $education = $this->common_model->valueFromId('education_detail',$user_data['part_education'],'education_name');
									}else{
										echo  $this->common_model->display_data_na('');
									}?>
								</span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Profession Area
								<?php  
								if(isset($user_data['part_occupation']) && $user_data['part_occupation'] !='')
								{ 
									$occupation = $this->common_model->valueFromId('occupation',$user_data['part_occupation'],'occupation_name');
									$user_data_value = $occupation;
									$member_data_value = $this->common_model->valueFromId('occupation',$member_data['occupation'],'occupation_name');	
									$user_data_value_arr =explode(',',$user_data_value);
									
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo $yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">		
								<?php if(isset($user_data['part_occupation']) && $user_data['part_occupation'] !='')
									{ 
										echo $occupation = $this->common_model->valueFromId('occupation',$user_data['part_occupation'],'occupation_name');
									}else{
										echo  $this->common_model->display_data_na('');
									}?>
								</span>
							</div>
							<div class="col-md-4 col-sx-12 col-sm-4">
								<h5 class="color-profile Poppins-Regular">Working As
								<?php
								if(isset($user_data['part_designation']) && $user_data['part_designation'] !='')
								{  
									$designation = $this->common_model->valueFromId('designation',$user_data['part_designation'],'designation_name');
									$user_data_value = $designation;
									$member_data_value = $this->common_model->valueFromId('designation',$member_data['designation'],'designation_name');
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										echo$yes_remark;
										$match_count++;
									}
									else
									{
										echo $no_remark;
									}
								}?>
								</h5>
								<span class="Poppins-Semi-Bold f-15 breakword">
								<?php if(isset($user_data['part_designation']) && $user_data['part_designation'] !='')
									{ 
										echo $designation = $this->common_model->valueFromId('designation',$user_data['part_designation'],'designation_name');
									}else{
										echo  $this->common_model->display_data_na('');
									}?>
								</span>
							</div>
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
		<?php
			if(isset($user_data['video_url']) && $user_data['video_approval'] =='APPROVED')
			{?>
		<div class="row mt-3">
			<div class="col-md-12 col-xs-12 col-sm-12">
				<div class="design-process-content padding-0">
					<div class="box-view-profile">
						<span class="Poppins-Semi-Bold mega-n3 f-16">Uploaded <span class="mega-n4 f-16">Video</span></span>
					</div>
					<hr class="hr-view">
					<div class="box-view-profile" style="padding:9px 12px;">
						<div class="row">
							<div class="col-md-12 col-sx-12 col-sm-12">
							<?php preg_match('/[\\?\\&]v=([^\\?\\&]+)/',$user_data['video_url'],$matches);?>
								<object data="http://www.youtube.com/v/<?php echo $matches[1];?>" style="width:100%; height:300px;"></object>					
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }?>  
	</div>
</div>
<div id="myModal_new" class="modal_new" >
	<span class="close cursor padding-right-10" data-dismiss="modal" style="position:relative;color:#fff !important;opacity:2 !important;">&times;</span>
	<div class="modal-content_new margin-bottom-20px">
		<?php $path_photos_big = $this->common_model->path_photos_big;
		if(isset($photos) && $photos!='' && is_array($photos) && $photos!='')
		{
			$i=0;$j=0;
			foreach($photos as $photo_val) 
			{
				if(isset($photo_val['photo']) && $photo_val['photo'] !='' && file_exists($path_photos.$photo_val['photo']) && $photo_val['status'] =='APPROVED'){
					$i++;
				}
			}
			foreach($photos as $photo_val) 
			{	
				if(isset($photo_val['photo']) && $photo_val['photo'] !='' && file_exists($path_photos.$photo_val['photo']) && $photo_val['status'] =='APPROVED')
				{ 
					$j++;
					?>
				<div class="mySlides">
					<div class="numbertext margin-bottom-15"><span class="numbertext-border"><?php echo $j.' / '.$i;?></span></div>
					<img src="<?php echo $base_url; ?><?php echo $path_photos_big;?><?php echo $photo_val['photo'];?>" class="slide-img img-responsive padding-top-10" alt="" style="padding: 0px;width: 600px !important;height: 500px !important;max-height:500px !important;object-fit: contain;" />
				</div>
				<?php }
			} 
		}?>
			<div id="slider"></div>
	</div>
	<div class="clearfix"></div>
	<center style="margin: 25px 0px !important;">
		<span class="prev_p" onclick="plusSlides(-1)">&#10094;</span>
		<span class="next_n" onclick="plusSlides(1)">&#10095;</span>
	</center>
</div>
<?php include_once('page_part/front_button_popup.php');?>
<input type="hidden" name='match_count' id='match_count' value='<?php echo $match_count;?>'>
<!-- ===================== Desk top View End ======================== -->
</div>
</div>
<?php
	$this->common_model->js_extra_code_fr.="
	load_choosen_code();
	$(document).ready(function(){
	var matchcount = $('#match_count').val();
	if(matchcount != ''){
		$('#match_count_result1').html(matchcount);
		}else{
		var matchcount = '0';
		$('#match_count_result1').html(matchcount);
		}
	if(matchcount != ''){
	$('#match_count_result').html(matchcount);
	}else{
	var matchcount = '0';
	$('#match_count_result').html(matchcount);
	}
	$(".'"'."[data-toggle='tooltip']".'"'.").tooltip(); 
	$(".'"'."[data-toggle='popover']".'"'.").popover();   
	});
		
	$('.myModal_note').click(function(){
	alert('ok');
	}); 
	
	function member_like(like_status='',other_id='',mobile='')
	{
		if(like_status == ''){
			alert('Please try again..!!!');
			return false;
		}
		if(other_id == ''){
			alert('Please try again..!!!');
			return false;
		}
	
		var hash_tocken_id = $('#hash_tocken_id').val();
		var base_url = $('#base_url').val();
		var url = base_url+'search/member-like';
		show_comm_mask();
		$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'like_status':like_status,'other_id':other_id},
			dataType:'json',
			success: function(data)
			{
				if(data.status == 'success'){
	
				var url2 = base_url+'search/total_likes_unlikes';
				$.ajax({
					url: url2,
					type: 'POST',
					data: {'csrf_new_matrimonial':hash_tocken_id,'other_id':other_id},
					dataType:'json',
					success: function(data1)
					{
						if(data1.status == 'success'){
							if(mobile != ''){
								$('#total_likes_mobile').html( data1.total_likes);
								$('#total_unlikes_mobile').html( data1.total_unlikes);
							}else{
								$('#total_likes').html(data1.total_likes);
								$('#total_unlikes').html( data1.total_unlikes);
							}
						}
					}
				});
				if(mobile != ''){
					if(data.image_name == 'Yes'){
						$('#Yes_id_mobile').hide();
						$('#No_id_mobile').show();
						$('#Image_Yes_mobile').show();
						$('#Image_No_mobile').hide();
					}
					if(data.image_name == 'No'){
						$('#No_id_mobile').hide();
						$('#Yes_id_mobile').show();
						$('#Image_No_mobile').show();
						$('#Image_Yes_mobile').hide();
					}
				}else{
					if(data.image_name == 'Yes'){
						$('#Yes_id').hide();
						$('#No_id').show();
						$('#Image_Yes').show();
						$('#Image_No').hide();
					}
				
					if(data.image_name == 'No'){
						$('#No_id').hide();
						$('#Yes_id').show();
						
						$('#Image_No').show();
						$('#Image_Yes').hide();
					}
				}
			}else{
				alert(data.errmessage);
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}	
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
	
	function centerModal() 
	{
	$(this).css('display', 'block');
	var dialog = $(this).find('.modal-dialog');
	var offset = ($(window).height() - dialog.height()) / 2;
	// Center modal vertically in window
	dialog.css('margin-top', offset);
	}
	$('.modal').on('show.bs.modal', centerModal);
	$(window).on('resize', function () {
	$('.modal:visible').each(centerModal);
	});
	
	
	var selectIds = $('#basic_collapse1,#about_collapse2,#horoscope_collapse3,#collapse6,#life-2,#family3,#PREFERENCES,#video');
	$(function ($) {
		selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
			$(this).prev().find('.fa').toggleClass('fa-plus fa-minus');
		})
	});
";
?>