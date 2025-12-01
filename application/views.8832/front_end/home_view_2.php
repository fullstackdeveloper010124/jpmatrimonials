<?php
$other_banner1_url = $base_url.'assets/home_2/images/planning-tools.png';
$other_banner1_logo_url = $base_url.'assets/latest_home/images/bottom-img.png';
$other_banner = $this->common_model->get_count_data_manual('other_banner',array('status'=>'APPROVED'),1,'','id desc');

if($other_banner != ''){
	$path_other_banner = $this->common_model->other_banner;
	$no_image = $this->common_model->no_image_found;
	if(isset($other_banner['other_banner1']) && $other_banner['other_banner1'] !='' && file_exists($path_other_banner.$other_banner['other_banner1'])){
		$other_banner1_url = $base_url.$path_other_banner.$other_banner['other_banner1'];
	}else{
		$other_banner1_url = $base_url.$no_image;
	}
	if(isset($other_banner['other_banner1_logo']) && $other_banner['other_banner1_logo'] !='' && file_exists($path_other_banner.$other_banner['other_banner1_logo'])){
		$other_banner1_logo_url = $base_url.$path_other_banner.$other_banner['other_banner1_logo'];
	}
}
$birth_date='';
?>
<style>
	.alert-success {
		color: #3c763d !important;
		background-color: #dff0d8 !important;
		border-color: #d6e9c6 !important;
	}
	#captchaImg img {
		width: 120px !important;
		height: 42px !important;
	}
</style>
<!-- ====== Banner Section Start ====== -->
		<div class="banner-new">
			<div id="testimonial-slider" class="owl-carousel">
				<?php 
				$home_banner = $this->common_model->get_count_data_manual('homepage_banner',array('status'=>'APPROVED'),2,'banner','rand()');
				if(isset($home_banner) && $home_banner !='' && is_array($home_banner) && count($home_banner) > 0){
					$path_banner = $this->common_model->path_banner;
					foreach($home_banner as $home_banner_val){
						if(isset($home_banner_val['banner']) && $home_banner_val['banner'] !='' && file_exists($path_banner.$home_banner_val['banner'])){
							$banner_url = $base_url.$path_banner.$home_banner_val['banner'];
							echo '<div class="testimonial_xx"><img src="'.$banner_url.'" title="" alt=""/></div>';
						}
					}
				}?>
			</div>
			<div class="container-fluid cust_padding">
				<div class="row">
					<div class="col-md-1 col-sm-12 col-xs-12"></div>
					<div class="col-md-5 col-sm-12 col-xs-12">
						<div class="indian-matri">
							<h1><?php echo $config_data["homepage_banner_text"];?></h1>
							<p style="font-size: 20px;"><?php echo $config_data["homepage_banner_description"];?></p>
						</div>
					</div>
				</div>
			</div>
			
			<div class="container-fluid cust_padding">
				<div class="row">

					<!-- <div class="col-md-2 col-sm-12 col-xs-12"></div> -->

	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="search_new_ind">					
		<div class="row">
			<div class="col-md-7 col-sm-12 col-xs-12">
			<div class="register_box">
				<h2>Free Register</h2>
				<hr>
				<div class="tabbable-panel">
					<div class="tabbable-line">
						<!-- <ul class="nav nav-tabs ">
							<li class="active">
								<a href="#tab_default_1" data-toggle="tab">
								Register</a>
							</li>
							<li>
								<a id="tab2primaryli" href="#tab_default_2" data-toggle="tab">
								Login </a>
							</li>
						</ul> -->
						
						<!-- <div class="tab-content"> -->
							
							<div class="tab-pane active" id="tab_default_1">
								<form method="post" id="register_step1" name="register_step1" action="<?php echo $base_url;?>register/save-register">
	                            <div id="reponse_message_step1" class="snackbar-register" style="margin-bottom: 0px;"></div>
	                            <div class="clearfix"></div>
								<?php if($this->session->flashdata('error_message')){?>
			                        <div class="alert alert-danger">
			                         	<?php echo $this->session->flashdata('error_message'); ?>
									</div>
								<?php }?>
								<div class="row margin-top-0">
									<div class="col-md-2 col-xs-2 col-sm-2"></div>
									<div class="col-md-10 col-xs-10 col-sm-10 text-center">
										<div class="">
											<div class="md-radio" onClick="add_gender_class('male')">
												<input id="1" type="radio" name="g" checked>
												<label for="1" class=" Poppins-Medium default-color color-d" id="male_id">Male</label>
											</div>
											<div class="md-radio" onClick="add_gender_class('female')">
												<input id="2" type="radio" name="g">
												<label for="2" class="default-color" id="female_id">Female</label>
											</div>
											<input type="hidden" name="gender" id="gender" value="Male">
										</div>
									</div>
								</div>
								<div class="row margin-top-30">
									<div class="col-md-6 col-xs-12 col-sm-6 reg-pad-r-10">
										<div class="register-input-palce">
											<input type="text" id="firstname" name="firstname"  onkeydown="return /[a-z ]/i.test(event.key)" required placeholder="First Name" class="cstm-form">
										</div>
									</div>
									<div class="col-md-6 col-xs-12 col-sm-6 reg-pad-l-10">
										<div class="register-input-palce">
											<input type="text" id="lastname" name="lastname" required placeholder="Last Name"  onkeydown="return /[a-z ]/i.test(event.key)"  class="cstm-form">	
											<input type="text" name="middle_name" id="middle_name" class="form-control" style="display: none;">
										</div>
									</div>
								</div>
								<div class="row margin-top-0">
									<div class="col-md-3 col-xs-12 col-sm-3 register-input-palce reg-pad-r-0">
										<select class="form-control cstm-form appearance " name="country_code" id="country_code">
											<?php echo $this->common_model->country_code_opt();?>
										</select>
									</div>
									<div class="col-md-9 col-xs-12 col-sm-9">
										<div class="register-input-palce">
											<!-- mujib changes for validation  -->
											<input type="text" required name="mobile_number" id="mobile_number" placeholder="Enter Your Mobile No 10 Digit" class="cstm-form" minlength="7" maxlength="10" title="Wrong Number with 7-9 and remaing digit with 0-9">
											<!-- <input type="number" required name="mobile_number" id="mobile_number" minlength="7" maxlength="13" placeholder="Enter Mobile No." class="cstm-form">	 -->
										</div>
									</div>
								</div>
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="register-input-palce">
											<input type="email" required name="email" placeholder="E-Mail ID" class="cstm-form">
											<input type="hidden" name="email_varifired" id="email_varifired" value="0" />
                                        	<input type="hidden" name="is_post" id="is_post" value="1" />
										</div>
									</div>
								</div>
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="register-input-palce ">
											<input id="password" minlength="8" style="position:relative;"  type="password" required name="password" placeholder="Password" class="myPsw cstm-form">
    										<span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password toggle-password-home"></span>
										</div>
									</div>
								</div>
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="">
											<?php echo $this->common_model->birth_date_picker($birth_date);?>
										</div>
									</div>
								</div>
								<div class="row margin-top-20">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="">
											<select class="cstm-form select2 select-cust" required name="religion" id="religion" onChange="dropdownChange('religion','caste','caste_list')" style="width:100%;">
												<option value="">Select Religion</option>
												<?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('religion'));?>
											</select>
										</div>
									</div>
								</div>
								<div class="row margin-top-20">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="">
											<select class="cstm-form select2 select-cust" required name="caste" id="caste" style="width:100%;">
												<option value="">Select Your Religion First</option>
											</select>
										</div>
									</div>
								</div>

								<?php
								$captcha = $this->common_model->generateCaptcha('loginCode');
								
								?>
								<div class="row">
									<div class="reg-input">
										<div class="col-md-4 col-sm-4 col-xs-6 " id="captchaImg">
											<?php echo $captcha['image']; ?>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-6">
											<i class="fa fa-refresh fa-1 curser_icon" id="refreshCaptcha" role="button" aria-hidden="true"></i>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<input maxlength="6" id="captcha_code" name="captcha_code" type="number" class="cstm-form" required>
										</div>
									</div>
								</div>
								<div class="row margin-top-20">
									<div class="col-md-12 col-xs-12 col-sm-12 register-input-palce reg-pad-r-0">
										<input type="checkbox" id="terms" name="terms" value="Yes"><label for="terms" class="reg-cb-text">I agree to the<a href="#myModal505" data-toggle="modal" class="color-d"> Terms And Conditions</a></label>
									</div>
									
								</div>
								<div class="row margin-top-0">

									<div class="col-md-7 col-sm-12 col-xs-12 reg-pad-r-0 reg-cb">
										<input type="hidden" name="status_front_page" id="status_front_page" value="Yes">
										<input type="hidden" name="id"  value="" />
										<input type="hidden" name="mode"  value="add" />
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id1"  class="hash_tocken_id" />
										<!-- <input type="checkbox" id="term" name="term" value="term"> for="term"  -->
										<label class="reg-cb-text">Already a member ? <a href="<?php echo base_url('login') ?>" onclick="login_tab()">Login</a></label>
									</div>
									<input type="hidden" name="is_post" id="is_post1" value="1" />
									<input type="hidden" name="is_home" id="is_home" value="yes" />
									<input type="hidden" name="check_duplicate" id="check_duplicate" value="No">
									<div class="col-md-5 col-xs-12 col-sm-12 text-center">
										<button class="btn reg-btn">Register</button>
									</div>
								</div>
								</form>
							</div>
							<?php
							/* Comment On Date : 12-10-2021
							<div class="tab-pane" id="tab_default_2">
								<form action="<?php echo $base_url; ?>login/check_login" method="post" id="login_form" name="login_form">
									<?php if($this->session->flashdata('user_log_err')){?>
									<div class="alert alert-danger"><?php
										echo $this->session->flashdata('user_log_err'); ?>
									</div>
									<?php }?>
									<div class="alert alert-danger" id="login_message" style="display:none"></div>
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="register-input-palce">
											<input type="text" class="cstm-form" required name="username" id="username" placeholder="Enter your Email ID or Matri ID">
										</div>
									</div>
								</div>
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<div class="register-input-palce">
    										<input id="password-field-1" type="password" required name="password" placeholder="Password" class="myPsw cstm-form">
    										<span toggle="#password-field-1" class="fa fa-fw fa-eye field-icon toggle-password" ></span>
										</div>
									</div>
								</div>searchnow
								<div class="row margin-top-0">
									<div class="col-md-12 col-xs-12 col-sm-12 text-center">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id2" class="hash_tocken_id" />
	                                    <input type="hidden" name="is_post" id="is_post1" value="1" />
	                                    <input type="hidden" name="is_home" id="is_home" value="yes" />
	                                    <input type="hidden" name="check_duplicate" id="check_duplicate" value="No">
	                                    <input type="submit" class="btn reg-btn" value="Login"  >
										<!-- <button class="btn reg-btn">Login</button> -->
									</div>
								</div>
								</form>
							</div>
							*/
							?>
						<!-- </div> -->
					</div>
				</div>
			</div>
		</div>
		<?php
		$hq = $this->common_model->get_count_data_manual('banner_quickinfo',array('status'=>'APPROVED'),2,'*','id desc',1,4);
		if(isset($hq) && $hq !='' && is_array($hq) && count($hq) > 0){?>
		<div class="col-md-5 col-sm-12 col-xs-12">
			<div class="reg-fect-box text-center">
				<div id="testimonial-slider-2" class="owl-carousel">
					<?php
					$i=1;
					$path_banner_quick_info = 'assets/banner_quick_info/';
					foreach($hq as $hq_val){
						$path_hq = '';
						if(isset($hq_val['icon']) && $hq_val['icon']!='' && file_exists($path_banner_quick_info.$hq_val['icon'])){
							$path_hq = $base_url.$path_banner_quick_info.$hq_val['icon'];
						}?>
						<div class="testimonial testimonial-reg-fect">
							<img src="<?php echo $path_hq;?>" alt="Secure Shield">
							<p><?php echo $hq_val['description'];?></p>
						</div>
					<?php $i++;
					}?>
				</div>
			</div>
		</div>
		<?php }?>
	</div>
</div>
</div>
		</div>
	</div>


			<!-- banner contact -->

			<div class="container-fluid cust_padding hidden-sm hidden-xs">
				<div class="banner-contact">
					<?php if(isset($config_data['contact_no']) && $config_data['contact_no']!='') {?>
					<div class="banner-contact-1">
						<h4><img src="<?php echo $base_url;?>assets/home_2/images/banner-contact-1.png" alt="Contact Number"><?php echo $config_data['contact_no'];?></h4>
					</div>
					<?php }
					if(isset($config_data['skype_id']) && $config_data['skype_id']!='') {?>
						<div class="banner-contact-2">						
							<h4><a target='_blank' href="<?php echo $config_data['skype_id']; ?>"><img src="<?php echo $base_url;?>assets/home_2/images/banner-contact-2.png" alt="Skype Id"><?php echo $config_data['skype_id'];?> </a> </h4>
						</div>
					<?php }?>
				</div>
			</div>
			<!-- banner contact -->
		</div>
		<!-- ====== Banner Section Ends ====== -->
		
		
		<div class="search_for">
			<div class="container">
				<div class="row margin-top-10">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<div class="search-box">
							<div class="row">
								<div class="col-md-12 col-sm-10 col-xs-12">
									<form method="post" name="search_form" id="search_form">
									<div class="search-section">
										<div class="form-group col-md-3 col-sm-4 col-xs-12 no-padding land-lookingfor">
											<div class="left">
												<select name="gender" id="Looking" class="custom-select sources" style="display: none;">
	                                          		<option value="Female" title="Bride" selected="">Bride</option>
	                                          		<option value="Male" title="Groom">Groom</option>
	                                       		</select>
											</div>
										</div>
										<div class="form-group col-md-2 col-sm-2 col-xs-6 no-padding land-agefrom agefromto_mob-w">
											<div class="left">
												<select name="from_age" id="agefrom" class="custom-select sources" style="display: none;">
                                        			<?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),18);?>
												</select>
											</div>
										</div>
										
										<div class="col-xs-2 agetolabel">
											<p class="left">to</p>
										</div>

										<div class="form-group col-md-2 col-sm-2 col-xs-6 no-padding land-ageto agefromto_mob-w">
											<div class="left">
												<select name="to_age" id="ageto" class="custom-select sources" style="display: none;">
                                          <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),30);?>
													</select>
											</div>
										</div>
									<div class="form-group col-md-3 col-sm-6 col-xs-12 no-padding land-religion">
										<div class="left">
											<select name="religion[]" id="Religion" class="custom-select sources" style="display: none;">
												<option class="list" value="" selected="" title="Select Religion">Doesn't matter</option>
                                    			<?php echo $this->common_model->array_optionstr_search($this->common_model->dropdown_array_table('religion'));?>
												</select>
											</div>
										</div>
										<div class="form-group col-md-2 col-sm-12 col-xs-12 no-padding land-search pad-r-0" style="box-shadow:none;">
											<div class="left">
												<button type="button" class="searchnow" id="submit-btn" onClick="find_match()">Search</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 

		<div class="container">

			<div class="how-does-it-work">

				<div class="row">

					<div class="col-md-12 col-xs-12 col-sm-12 text-center">

						<div class="indian-matri-title">

							<p><?php if(isset($config_data['middle_text1'])) { echo $config_data['middle_text1'];}?></p>

						</div>

					</div>

				</div>

				<div class="row how-does-it-work-main">	

					<div class="col-md-3 col-sm-12 col-xs-12 text-center">

						<div class="how-does-it-work-data">
							<div class="how-does-it-work-new">
								<img src="<?php echo $base_url;?>assets/home_2/images/hw-1.png" alt="Create Account" />
							</div>

							<h3>Create Account</h3>

							<p><?php if(isset($config_data['sign_up_text'])) { echo $config_data['sign_up_text']; } ?></p>

						</div>

					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 text-center">
						<div class="how-does-it-work-data">
							<div class="how-does-it-work-new">
								<img src="<?php echo $base_url;?>assets/home_2/images/hw-2.png" alt="Browse Profiles" />
							</div>
							<h3>Browse Profiles</h3>
							<p><?php if(isset($config_data['browse_profile_text'])) { echo $config_data['browse_profile_text']; } ?></p>
						</div>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12 text-center">
						<div class="how-does-it-work-data">
							<div class="how-does-it-work-new">
							<img src="<?php echo $base_url;?>assets/home_2/images/hw-3.png" alt="Connect" />
						</div>
							<h3>Connect</h3>

							<p><?php if(isset($config_data['contact_text'])) { echo $config_data['contact_text'];}?></p>
							
						</div>

					</div>

					<div class="col-md-3 col-sm-12 col-xs-12 text-center">

						<div class="how-does-it-work-data">
							<div class="how-does-it-work-new">
								<img src="<?php echo $base_url;?>assets/home_2/images/hw-4.png" alt="Interact" />
							</div>
							<h3>Interact</h3>

							<p><?php if(isset($config_data['interact_text'])) { echo $config_data['interact_text'];}?></p>
							
						</div>

					</div>

				</div>

			</div>

		</div>

		<!-- how does it work -->



		
		
		<?php
		$success_story = $this->common_model->get_count_data_manual('success_story',array('status'=>'APPROVED'),2,'*','id desc',1,4);
		if(isset($success_story) && $success_story !='' && is_array($success_story) && count($success_story) > 0)
		{
	    ?>
		<!-- Millions of Happy Stories -->
	
	<div class="millions-of-happy-stories-box">	
		<div class="more-success-stories hidden-xs hidden-sm">
			<a href="<?php echo $base_url;?>success-story"><h5>More Success Stories</h5></a>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 text-center">
					<div class="indian-matri-title">
						<p><?php if(isset($config_data['middle_text2'])) { echo $config_data['middle_text2'];}?></p>
					</div>
				</div>
			</div>

			<div class="row margin-top-50">
				<div class="col-md-12 col-xs-12 col-sm-12">
					<div id="testimonial-slider-3" class="owl-carousel">
						<?php
						$no_image = $this->common_model->no_image_found;
                        $path_success = $this->common_model->path_success;
                        foreach($success_story as $success_story_val)
                        {
							if(isset($success_story_val['weddingphoto']) && $success_story_val['weddingphoto'] !='' && file_exists($path_success.$success_story_val['weddingphoto'])){
								$weddingphoto = $base_url.$path_success.$success_story_val['weddingphoto'];
							}
							else{
								$weddingphoto = $base_url.$no_image;
							}
							$groomname = $success_story_val['groomname'];
							$bridename = $success_story_val['bridename'];
					        $mid = $this->common_model->encrypt_id($success_story_val['id']);
					        $groomname = str_replace(' ','-',$groomname);
					        $bridename = str_replace(' ','-',$bridename); 
					        $url = 'success-story'.'/'.$mid.'/'.$groomname.'-'.$bridename;?>
						<div class="testimonial testimonial-stories">
							<div class="row">
								<div class="col-md-6 col-xs-12 col-sm-6 padding-right-zero">
									<div class="service-box-new-img">
										<a href="<?php echo $base_url.$url;?>"><img src="<?php echo $weddingphoto;?>" alt="Happy Stories"/></a>
									</div>								
								</div>
								<div class="col-md-6 col-xs-12 col-sm-6 padding-left-zero padding-right-zero padding-15-m-2">
									<div class="service-box-new">
										<h3><?php echo $success_story_val['groomname'];?> & <?php echo $success_story_val['bridename'];?></h3>
										<p><?php 
										$successmessage = strip_tags($success_story_val['successmessage']);
										$strlenth = strlen($successmessage);
										echo $successmessage = substr($successmessage,0,250);
										if(isset($strlenth) && $strlenth!='' && $strlenth>=250){
											echo '...';}?></p>
										<?php
										if(isset($strlenth) && $strlenth!='' && $strlenth>=250){
										?><a href="<?php echo $base_url.$url; ?>" class="btn read-more-btn">Read More</a><?php } ?>
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
	<!-- Millions of Happy Stories -->
	<?php }?>

	<?php
	$where_arra=array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'");
	$profile_data = $this->common_model->get_count_data_manual('register_view',$where_arra,2,'*','id desc',1,'4');
	if(isset($profile_data) && $profile_data !='' && is_array($profile_data) && count($profile_data) > 0 ){ ?>
	<!-- Last Added Profiles -->

	 <div class="last-added-profiles">
		<div class="container">
			<div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12 text-center">
					<div class="indian-matri-title">
						<p>Last <span>Added</span> Profiles</p>
					</div>
				</div>
			</div>
			<div class="row margin-top-20">

				<?php 
				$path_photos = $this->common_model->path_photos;
				$i = 1;
				$profileData = $this->common_front_model->process_data_dashboard($profile_data);

				foreach($profileData as $recent_data){
					$badgeImg = '';
					if(isset($recent_data['badge']) && $recent_data['badge'] !=''){
						$badgeImg = "<img src='".$recent_data['badgeUrl'].$recent_data['badge']."' style='position: absolute;right: 15px;top: 0px;z-index: 99;height: 90px;width: 90px;'>";
					}
					$badgebackStyle = "border: 3px solid ".$recent_data['color'].";box-shadow: 0px 1px 10px 0px rgb(4 4 4 / 29%);";
				$path_photos = $this->common_model->path_photos;
					if(isset($recent_data['photo1']) && $recent_data['photo1'] !='' && $recent_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$recent_data['photo1']) && $recent_data['photo_password'] !='' && $recent_data['photo_protect'] !='No' && $recent_data['photo_view_status'] == 0){
						$recent_image = '<a data-toggle="modal" data-target="#myModal_photoprotect" onClick="addstyle('.$login_user_matri_id.','.$recent_data['matri_id'].')"><img src="'.$photopassword_image.'" title="'.$recent_data['username'].'" alt="'.$recent_data['matri_id'].'" class="last-img" style="'.$badgebackStyle.'"></a>';
						$rec_img = '<img src="'.$photopassword_image.'" title="'.$recent_data['username'].'" alt="'.$recent_data['matri_id'].'" style="border-radius: 20px;">';
						$rec_style = 'style="background: url('.$photopassword_image.');background-repeat: no-repeat;"';
					}else{
						$recent_image = '<a href="'.$base_url.'search/view-profile/'.$recent_data['matri_id'].'"><img src="'.$this->common_model->member_photo_disp($recent_data).'" title="'.$recent_data['username'].'" alt="'.$recent_data['matri_id'].'" class="last-img" style="'.$badgebackStyle.'"></a>';
						$rec_img = '<img src="'.$this->common_model->member_photo_disp($recent_data).'" alt="'.$recent_data['matri_id'].'" style="border-radius: 20px;">';
						$rec_style = 'style="background: url('.$this->common_model->member_photo_disp($recent_data).');background-repeat: no-repeat;"';
					}
				?>
					<div class="col-md-3 col-sm-12 col-xs-12">
						<?php echo $badgeImg;?>
						<div class="option-3-data margin-top-10">
							<?php echo $recent_image;?>
							<div class="option-3-data-pad margin-top-10">
    							<h4><?php echo $recent_data['username'];?></h4>
    							<p><?php echo $recent_data['profile_description'];?></p>
							</div>
						</div>
					</div>
					<?php $i++;}?>
				</div>
			</div>
		</div>
		
	<?php }?> 
		
		<!-- Are you trying our planning tools -->

		<div class="planning-tools">

			<div class="container">

				<div class="row m-center">

					<div class="col-md-7 col-sm-12 col-xs-12">

						<h3><?php echo $other_banner['other_banner1_title'];?></h3>

						<p><?php echo $other_banner['other_banner1_description'];?></p>

						<a href="<?php echo $base_url;?>wedding-vendor" class="btn get-started-btn">Get Started</a>
					</div>
					<div class="col-md-1 col-sm-12 col-xs-12"></div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<img src="<?php echo $other_banner1_url;?>" alt="Planning Tools">
					</div>
				</div>
			</div>
		</div>

		<!-- Are you trying our planning tools -->



		<!-- features -->

		<div class="features">

			<div class="container">

				<div class="row text-center">

					<div class="col-md-3 col-sm-12 col-xs-12">

						<h4><?php echo $this->common_model->get_count_data_manual('mothertongue',array('status'=>'APPROVED'),0,'*','');?>+ Languages</h4>

						<h5>Offering Multilingual Choices</h5>
					
					</div>

					<div class="col-md-3 col-sm-12 col-xs-12">

						<h4><?php echo $this->common_model->get_count_data_manual('caste',array('status'=>'APPROVED'),0,'*','');?>+ Castes</h4>

						<h5>Within India & Abroad</h5>
					
					</div>

					<div class="col-md-3 col-sm-12 col-xs-12">

						<h4><?php $cities_c = $this->common_model->get_count_data_manual('city_master',array('status'=>'APPROVED'),0,'*','');
						if(isset($cities_c) && $cities_c>3200){
							echo "3200+";
						}
						else{ 
							echo $cities_c;
						}?> Cities</h4>
						<h5>Across 4 countries of operation</h5>
					</div>
					<div class="col-md-3 col-sm-12 col-xs-12">
						<h4><?php echo $this->common_model->get_count_data_manual('country_master',array('status'=>'APPROVED'),0,'*','');?> Countries</h4>
						<h5>Connecting beyond borders</h5>
					</div>
				</div>
			</div>
		</div>

		<!-- features -->


		<!-- ========= Stay connected with our app Start ========== -->

		<div class="stay-connected">
			<svg xmlns="http://www.w3.org/2000/svg" width="671.887" height="508.029" viewBox="0 0 671.887 508.029" style="&#10;    position: absolute;&#10;    right: 0;&#10;"><defs></defs><path class="a" d="M-207.887,508.029,464,0V508H0Z" transform="translate(207.887)"/></svg>
			<div class="container">

				<div class="row margin-top-0">

					<div class="col-md-6 col-xs-12 col-sm-6">

						<div class="stay-connected-title">

							<p><span>Mobile</span> App</p>

						</div>

						<div class="stay-connected-title-dec">

							<p class=""><?php if(isset($other_banner['mobile_matrimony_description']) && $other_banner['mobile_matrimony_description']!=''){echo $other_banner['mobile_matrimony_description'];}?></p>

						</div>

						<ul class="mobile-app-feact margin-top-25">
							<li>
								<div class="mobile-app-feact-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/hw-1.png" alt="Create Account" data-toggle="tooltip" data-placement="top" title="Create Account">
								</div>
							</li>
							<li>
								<div class="mobile-app-feact-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/hw-2.png" alt="Browse Profiles" data-toggle="tooltip" data-placement="top" title="Browse Profiles">
								</div>
							</li>
							<li>
								<div class="mobile-app-feact-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/hw-3.png" alt="Connect" data-toggle="tooltip" data-placement="top" title="Connect">
								</div>
							</li>
							<li>
								<div class="mobile-app-feact-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/hw-4.png" alt="Interact" data-toggle="tooltip" data-placement="top" title="Interact">
								</div>
							</li>
						</ul>

						<ul class="mobile-app-feact-1 margin-top-20">
							<li>
								<img src="<?php echo $base_url;?>assets/home_2/images/check.png" alt="Check Icon"> Search by location, community, profession & more.
							</li>
							<li>
								<img src="<?php echo $base_url;?>assets/home_2/images/check.png" alt="Check Icon"> Verified stamp added to profile.
							</li>
							<li>
								<img src="<?php echo $base_url;?>assets/home_2/images/check.png" alt="Check Icon"> Profile and pictures with advanced privacy settings.
							</li>
						</ul>
						<?php $other_banner2_url = $base_url.'assets/home_2/images/mobile-app.png';
						if($other_banner != ''){
							$path_other_banner = $this->common_model->other_banner;
							if(isset($other_banner['other_banner2']) && $other_banner['other_banner2'] !='' && file_exists($path_other_banner.$other_banner['other_banner2'])){
								$other_banner2_url = $base_url.$path_other_banner.$other_banner['other_banner2'];
							}
						}?>
						<img src="<?php echo $other_banner2_url;?>" class="img-responsive hidden-lg hidden-md" alt="Mobile App">

						<!-- <hr class="hidden-lg hidden-md hr-mobile-new"> -->

						<!-- mobile app icon for desktop -->

						<div class="row margin-top-20 hidden-sm hidden-xs">

							<div class="col-md-4 col-sm-12 col-xs-12 text-center">

								<div class="mobile-app-box">

									<div class="row">
									<?php 
									if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !=''){?>
										<div class="col-md-6 col-sm-6 col-xs-6 mobile-app-right-border">
											<a target='_blank' href="<?php echo $config_data['ios_app_link']; ?>"><img src="<?php echo $base_url;?>assets/home_2/images/app-store.png" alt="App Store" data-toggle="tooltip" data-placement="bottom" title="App Store"></a>
										</div>
									<?php }if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){?>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<a target='_blank' href="<?php echo $config_data['android_app_link']; ?>"><img src="<?php echo $base_url;?>assets/home_2/images/google-play-store.png" alt="Google Play Store" data-toggle="tooltip" data-placement="bottom" title="Google Play Store"></a>
										</div>
									<?php }?>
									</div>

								</div>

							</div>

						</div>

						<!-- mobile app icon for desktop -->


						<!-- mobile app icon for mobile -->

						<div class="row margin-top-20  hidden-lg hidden-md">

							<div class="col-md-3 col-sm-3 col-xs-3"></div>

							<div class="col-md-6 col-sm-6 col-xs-6">

								<div class="mobile-app-box">

									<div class="row">
										<?php 
									if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !=''){?>
										<div class="col-md-6 col-sm-6 col-xs-6 mobile-app-right-border">
											<a target='_blank' href="<?php echo $config_data['ios_app_link']; ?>"><img src="<?php echo $base_url;?>assets/home_2/images/app-store.png" alt="App Store"></a>
										</div>
									<?php }if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){?>
										<div class="col-md-6 col-sm-6 col-xs-6">
											<a target='_blank' href="<?php echo $config_data['android_app_link']; ?>"><img src="<?php echo $base_url;?>assets/home_2/images/google-play-store.png" alt="Google Play Store"></a>
										</div>
									<?php }?>
									</div>
								</div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3"></div>
						</div>
						<!-- mobile app icon for mobile -->
					</div>
					
					<div class="col-md-1 col-xs-12 col-sm-12"></div>
					<div class="col-md-5 col-xs-12 col-sm-6">
						<div class="mobile-app-img">
							<img src="<?php echo $other_banner2_url;?>" class="img-responsive hidden-sm hidden-xs" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- ========== Stay connected with our app End =========== -->
		

		<!-- Why Choose us -->

		<div class="why-choose-us">
			<div class="container">
				<div class="row">
					<div class="col-md-12 col-xs-12 col-sm-12 m-center">
						<div class="indian-matri-title1">
							<p>Why <span>Choose</span>  us</p>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="why-choose-us-data">
							<p><?php echo $config_data['reason_why_choose_text']; ?></p>
						</div>
					</div>
				</div>
				<?php
				$rwc = $this->common_model->get_count_data_manual('reason_why_choose',array('status'=>'APPROVED'),2,'*','id desc',1,4);
				if(isset($rwc) && $rwc !='' && is_array($rwc) && count($rwc) > 0){?>
					<div class="row">
						<div class="why-choose-us-data">
							<div class="col-md-6 col-sm-12 col-xs-12 why-choose-us-right-border">
							<?php
							$i=1;
							foreach($rwc as $rwc_val){
								if($i==3){
									echo '</div><div class="col-md-6 col-sm-12 col-xs-12">';
								}
								if($i==2 || $i==4){
									echo '<div class="margin-top-20">';
								}?>
						
							<h3><?php echo $rwc_val['title'];?></h3>
							<p><?php echo $rwc_val['description'];?></p>
							<?php 
								if($i==2 || $i==4){
									echo '</div>';
								}
								$i++;}
							?>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
		<!-- Why Choose us -->
		
		
		<!-- =========== Browse Matrimony Start =========== -->
		
		<div class="browse-matri">

			<div class="container">
				
				<div class="row">

					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">

						<div class="browse-matri-data">

							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-1.png" alt="Religion">
								</div>
							</div>

							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">
								<h3>Religion</h3>
								<ul class="browse-matri-list">
									<li>
										<?php $where_religion = array('is_deleted'=>'No',"search_type"=>"Religion");
							$religion_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_religion,2,'id,slug,matrimony_name','rand()',1,8);
							$r = 0;
							if(isset($religion_arr) && $religion_arr !='' && is_array($religion_arr) && count($religion_arr) > 0){
								$r_c = count($religion_arr);
								foreach($religion_arr as $religion_arr){
									$religion = str_ireplace(" ","-",$religion_arr['slug']);
									?>
									<a href="<?php echo $base_url.'matrimony/'.$religion;?>" target="_blank"><?php echo $religion_arr['matrimony_name'];?></a>

								<?php if($r<=$r_c){?>
									<div class="bm-vl"></div>
								<?php }
								$r++;
								}
							}?>
							<a href="<?php echo $base_url;?>more-details/religion" target="_blank">More Details </a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">
						<div class="browse-matri-data">
							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-4.png" alt="Caste">
								</div>
							</div>
							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">
								<h3>Caste</h3>
								<ul class="browse-matri-list">
									<li><?php $where_caste= array('is_deleted'=>'No',"search_type"=>"Caste");
							$caste_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_caste,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($caste_arr) && $caste_arr !='' && is_array($caste_arr) && count($caste_arr) > 0){
								$cas = 1;
								foreach($caste_arr as $caste_arr){
								$caste = str_ireplace(" ","-",$caste_arr['slug']);
									?>
									<a href="<?php echo $base_url.'matrimony/'.$caste;?>" target="_blank"><?php echo $caste_arr['matrimony_name'];?></a>
									<?php
									if($cas<=count($caste_arr)){
										echo '<div class="bm-vl"></div>';
									}
								$cas++;}
							}?>
							<a href="<?php echo $base_url;?>matrimony/Caste" target="_blank">More Details </a>
									</li>
								</ul>
							</div>

						</div>

					</div>
					
				</div>
				

				<div class="row ">

					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">

						<div class="browse-matri-data">

							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-2.png" alt="Mother Tongue">
								</div>
							</div>

							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">

								<h3>Mother Tongue</h3>

								<ul class="browse-matri-list">
									  

									<li><?php 
							$where_mother_tongue= array('is_deleted'=>'No',"search_type"=>"Mother-Tongue");
							$mother_tongue_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_mother_tongue,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($mother_tongue_arr) && $mother_tongue_arr !='' && is_array($mother_tongue_arr) && count($mother_tongue_arr) > 0){
								$m = 0;
								foreach($mother_tongue_arr as $mother_tongue_arr){
									$mother_tongue = str_ireplace(" ","-",$mother_tongue_arr['slug']);?>
									<a href="<?php echo $base_url.'matrimony/'.$mother_tongue;?>" target="_blank"><?php echo $mother_tongue_arr['matrimony_name'];?> </a>
									<?php if($m<=count($mother_tongue_arr)){?>
									<div class="bm-vl"></div>
								<?php }
								$m++;}
							}?>
						<a href="<?php echo $base_url;?>more-details/Mother-Tongue" target="_blank">More Details </a></li>
								</ul>
							</div>
						</div>

					</div>

					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">

						<div class="browse-matri-data">

							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-5.png" alt="Country">
								</div>
							</div>

							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">
								<h3>Country</h3>
								<ul class="browse-matri-list">
									<li>
										<?php
							$where_country_code = array('is_deleted'=>'No',"search_type"=>"Country");
                            $country_code_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_country_code,2,'slug,matrimony_name','rand()',1,10);
                            if(isset($country_code_arr) && $country_code_arr !='' && is_array($country_code_arr) && count($country_code_arr) > 0){
                            	$c=1;
								foreach($country_code_arr as $country_code_arr){
									$slug_url_name = str_ireplace(" ","-",$country_code_arr['slug']);
									?>
									<a href="<?php echo $base_url.'matrimony/'.$slug_url_name;?>" target="_blank"><?php echo $country_code_arr['matrimony_name'];?></a>
									<?php if($c<=count($country_code_arr)){
										echo '<div class="bm-vl"></div>';
										}
									$c++;}
								} ?>
										<a href="<?php echo $base_url;?>more-details/country" target="_blank">More Details </a>
										
									</li>

								</ul>

							</div>

						</div>

					</div>
					
				</div>


				<div class="row ">

					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">

						<div class="browse-matri-data">

							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-3.png" alt="State">
								</div>
							</div>
							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">
								<h3>State</h3>
								<ul class="browse-matri-list">
									<li>
										<?php
							$where_state_code = array('is_deleted'=>'No',"search_type"=>"State");
                            $state_code_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_state_code,2,'slug,matrimony_name','rand()',1,8);
                            if(isset($state_code_arr) && $state_code_arr !='' && is_array($state_code_arr) && count($state_code_arr) > 0){
                            	$st = 0;
                            	$st_c = count($state_code_arr);
								foreach($state_code_arr as $state_code_arr){
									$slug_url_name = str_ireplace(" ","-",$state_code_arr['slug']);
									?>
									<a href="<?php echo $base_url.'matrimony/'.$slug_url_name;?>" target="_blank"><?php echo $state_code_arr['matrimony_name'];?></a>
								<?php 
								if($st<=$st_c){
									echo '<div class="bm-vl"></div>';
									}
								$st++;}
								} ?>
										<a href="<?php echo $base_url;?>more-details/state" target="_blank">More Details </a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-sm-12 col-xs-12 margin-top-20">

						<div class="browse-matri-data">

							<div class="col-md-2 col-sm-3 col-xs-3 bm-pad-l">
								<div class="browse-matri-data-new">
									<img src="<?php echo $base_url;?>assets/home_2/images/bm-6.png" alt="Cities">
								</div>
							</div>

							<div class="col-md-10 col-sm-9 col-xs-9 bm-pad-l">

								<h3>Cities</h3>

								<ul class="browse-matri-list">
									  

									<li>
							<?php $where_city= array('is_deleted'=>'No',"search_type"=>"City");
							$city_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_city,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($city_arr) && $city_arr !='' && is_array($city_arr) && count($city_arr) > 0){
								$ci = 0;
								$ci_c = count($city_arr);
								foreach($city_arr as $city_arr){
								$city = str_ireplace(" ","-",$city_arr['slug']);
									?>
									<a href="<?php echo $base_url.'matrimony/'.$city;?>" class="font-12" target="_blank"><?php echo $city_arr['matrimony_name'];?></a>
								<?php 
								if($ci<=$ci_c){
									echo '<div class="bm-vl"></div>';
								}
								$ci++;}
							}?>
										<a href="<?php echo $base_url;?>more-details/city" target="_blank">More Details </a>
										
									</li>

								</ul>

							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
		<!-- =========== Browse Matrimony End =========== -->
		<!--write something modal start-->
		<div id="myModal505" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-vendor">
			

				<div class="modal-content">
					<div class="modal-header new-header-modal">
						<p class="Poppins-Bold mega-n3 new-event text-center">Terms and <span class="mega-n4 f-s">Conditions </span></p>
						<button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
					</div>
					<div class="modal-body">
						
						<div class="row">
							
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<?php if(isset($cms_pages['page_content']) && $cms_pages['page_content'] !='')
									{	
										echo $cms_pages['page_content'];
									}
									else
									{	?>
									<div class="no-data-f">
										<img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" style="margin: auto;"/>
										<h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
									</div>
								<?php }?> 
							</div>
						</div>
						
					</div>
				</div>
			
			</div>
		</div>
		<!--write something modal End-->

<?php 
if($this->session->flashdata('user_log_err')){
	$this->common_model->js_extra_code_fr.='
		login_tab();
	';
}
$this->common_model->js_extra_code_fr.='
$("#religion,#caste,#birth_date,#birth_month,#birth_year").select2();
function login_tab(){
	$("#tab2primaryli").attr("#tab_default_2")
    $("#tab2primaryli").trigger("click");
}
//slider code
$(document).ready(function(){
	$("#testimonial-slider").owlCarousel({
		items:1,
		itemsDesktop:[1000,1],
		itemsDesktopSmall:[979,1],
		itemsTablet:[768,1],
		itemsMobile:[650,1],
		pagination:false,
		navigation:false,
		slideSpeed:1000,
		autoPlay:true,
	});
});

$(document).ready(function(){
	$("#testimonial-slider-2").owlCarousel({
		items:1,
		itemsDesktop:[1000,1],
		itemsDesktopSmall:[979,1],
		itemsTablet:[768,1],
		pagination:true,
		navigation:false,
		navigationText:["",""],
		autoPlay :3000,
		stopOnHover :true,
	});
});
$(document).ready(function(){
	$("#testimonial-slider-3").owlCarousel({
		items:2,
		dots:false,
		itemsDesktop:[1000,1],
		itemsDesktopSmall:[979,1],
		itemsTablet:[768,1],
		pagination:true,
		navigation:false,
		nav: true,
		navigationText:false,
		autoPlay:true,
		autoplayTimeout: 1520,
		smartSpeed: 1500,
		animateIn: "linear",
		animateOut: "linear"
	});
});
//slider code End
function add_gender_class(id){
	if(id=="male"){
		$("#male_id").addClass("color-d");
		$("#male_id").addClass(" Poppins-Medium");
		$("#female_id").removeClass("color-d");
		$("#female_id").removeClass(" Poppins-Medium");
		$("#gender").val("Male");
	}
	else{
		$("#male_id").removeClass("color-d");
		$("#male_id").removeClass(" Poppins-Medium");
		$("#female_id").addClass("color-d");
		$("#female_id").addClass(" Poppins-Medium");
		$("#gender").val("Female");
	}
}
function find_match()
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url = base_url+"search/home_search";
	var form_data = $("#search_form").serialize();
	form_data = form_data+ "&csrf_new_matrimonial="+hash_tocken_id;	
	
	show_comm_mask();
		$.ajax({
		  	url: url,
			type: "POST",
			data: form_data,
			dataType:"json",
			success: function(data)
			{ 	
				window.location.href = base_url+"search/result";
				update_tocken(data.tocken);
				hide_comm_mask();
		  	}
		});
	return false;
}
	
	/* Search box   */
	 $(".custom-select").each(function(event) {
        var classes = $(this).attr("class"),
		id = $(this).attr("id"),
		name = $(this).attr("name");
        var placeholder = $(this).attr("placeholder");
        if ($(this).find(":selected").attr("title")) {
            placeholder = $(this).find(":selected").attr("title");
		}
        if (placeholder == "Bride") {
            placeholder = "Looking For a "+placeholder;
		}
		var template =  "<div class=\"" + classes + "\">";
		template += "<span class=\"custom-select-trigger\" id=\""+id+"_change\">"+placeholder+"</span>";
		template += "<div class=\"custom-options\">";
        $(this).find("option").each(function(event) {
			template += "<span class=\"custom-option\" + $(this).attr(\"class\") + \"\" data-value=\""+$(this).attr("value")+"\">"+$(this).html()+"</span>";
            
		});
        template += "</div></div>";
		
		$(this).wrap("<div class=\"custom-select-wrapper\"></div>");
        $(this).hide();
        $(this).after(template);
	});
    $(".custom-option:first-of-type").hover(function(event) {
        $(this).parents(".custom-options").addClass("option-hover");
		}, function() {
        $(this).parents(".custom-options").removeClass("option-hover");
	});
    $(".custom-select-trigger").on("click", function(event) {
        $("html").one("click", function(event) {
            $(".custom-select").removeClass("opened");
            $(".custom-select-trigger").removeClass("open");
		});
        if ($(".open").attr("class")) {
            $(".custom-select").removeClass("opened");
            $(".custom-select-trigger").removeClass("open");
			} else {
            $(this).parents(".custom-select").toggleClass("opened");
            $(".custom-select-trigger").addClass("open");
		}
        event.stopPropagation();
	});
    $(".custom-option").on("click", function(event) {
		
        $(this).parents(".custom-select-wrapper").find("select").val($(this).data("value"));
        $(this).parents(".custom-options").find(".custom-option").removeClass("selection");
        $(this).addClass("selection");
        $(this).parents(".custom-select").removeClass("opened");
        $(this).parents(".custom-select").find(".custom-select-trigger").text($(this).text());
        if ($(this).data("value") == "Male") {
            $("#agefrom").val("24");
            $("#ageto").val("35");
            $("#agefrom_change").text("24 Year");
            $("#ageto_change").text("35 Year");
            $("#Looking_change").text("Looking For a Groom");
			} else if ($(this).data("value") == "Female") {
            $("#agefrom").val("20");
            $("#ageto").val("30");
            $("#agefrom_change").text("20 Year");
            $("#ageto_change").text("30 Year");
            $("#Looking_change").text("Looking For a Bride");
		} else {}
	});
	/* Search box */
	
	$(document).ready(function(){
    	// $("#register_step1").on("submit", function(){
		// 	var form_data = $("#register_step1").serialize();
		// 	form_data = form_data+ "&is_post=0";
		// 	var cd = $("#check_duplicate").val();
		// 	if(cd=="No"){
		// 		var action = "'.$base_url.'register/check_duplicate";
		// 		show_comm_mask();
		// 		$.ajax({
		// 			url: action,
		// 			type: "post",
		// 			dataType:"json",
		// 			data: form_data,
		// 			success:function(data){
		// 				update_tocken(data.tocken);
		// 				hide_comm_mask();
		// 				if(data.status == "success"){
		// 			  		$("#check_duplicate").val("Yes");
		// 			  		$("#register_step1").submit();
		// 				}
		// 				else{
		// 					$("#check_duplicate").val("No");
		// 					$("#reponse_message_step1").addClass("show");
		// 					$("#reponse_message_step1").html(data.errmessage);
		// 					$("#reponse_message_step1").slideDown();
		// 				}
		// 				setTimeout(function(){
		// 			        $("#reponse_message_step1").removeClass("show");
		// 			    }, 3000);
		// 		   	}
		// 		});
		// 		return false;
		// 	}
		// });
		$("#register_step1").submit(function(e) {
			e.preventDefault();
				var form_data = $("#register_step1").serialize();
				form_data = form_data+ "&is_post=0";
				var action = $("#register_step1").attr("action");
				show_comm_mask();
				$.ajax({
					url: action,
					type: "post",
					dataType:"json",
					data: form_data,
					success:function(data)
					{
						update_tocken(data.tocken);
						hide_comm_mask();
						if(data.status == "success")
						{
							send_mail_memmber();
							$("#reponse_message_step1").css("background-color","#73d39d");
							is_reload_page = 1;
							$("#reponse_message_step1").addClass("alert alert-success");
							$("#reponse_message_step1").html(data.errmessage);
							document.getElementById("register_step1").reset();
							var red_url = "";
							is_submit = 0;
							setTimeout(function(){
								window.location.href = $("#base_url").val()+"register/step2";
							},2000);
						}
						else
						{
							$("#reponse_message_step1").addClass("show");
							$("#reponse_message_step1").html(data.errmessage);
							$("#reponse_message_step1").slideDown();
							$("#reponse_message_step1").addClass("alert alert-danger");
						}
						setTimeout(function(){
							$("#reponse_message_step1").removeClass("show");
							$("#reponse_message_step1").css("background-color","#ff6465");
						}, 2000);
					}
					});
				
				return false;
	
		});
	});

	// Send Mail Member : Date : 08-02-2023
	function send_mail_memmber(){
		//return true;
		var form_data = "is_post=0";
		var action = $("#base_url").val()+"register/send_mail_member";
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: form_data,
			success:function(data)
			{
				$("#reponse_message_step1").removeClass("alert alert-success alert-danger");
				$("#reponse_message_step1").html(data.errmessage);
				$("#reponse_message_step1").slideDown();
				update_tocken(data.tocken);
				hide_comm_mask();
				if(data.status == "success")
				{
					window.location.href = $("#base_url").val()+"register/step2";
				}
			}
		});
		return false;
	}

	$("#refreshCaptcha").click(function(){
		var action = $("#base_url").val()+"register/refreshCaptcha";
		var hash_tocken_id = $("#hash_tocken_id").val();
		$.ajax({
			url: action,
			type: "post",
			dataType : "json",
			data: {"csrf_new_matrimonial": hash_tocken_id},
			success:function(data)
			{
				update_tocken(data.token);
				hide_comm_mask();
				if(data.status == "success"){
					$("#captchaImg").html(data.data.image);
					$("#captcha_code").val("");
				}else{
					$("#reponse_message_step1").removeClass("alert alert-success alert-danger");
					$("#reponse_message_step1").html(data.errmessage);
					$("#reponse_message_step1").slideDown();
					$("#reponse_message_step1").addClass("alert alert-danger");
				}
			}
		});
	});

	$("#captcha_code").on("input", function() {
        let value = $(this).val();
        value = value.replace(/\D/g, "");
        if (value.length > 6) {
            value = value.substring(0, 6);
        }
        $(this).val(value);
    });


'


;