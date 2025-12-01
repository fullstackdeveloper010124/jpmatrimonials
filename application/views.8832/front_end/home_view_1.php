
			
			<div class="find pb-5">
			<div class="find-section">
			<div class="find-section">
					<!-- Find search section-->
					<div class="col-md-12 col-sm-12 col-xs-12 finder-block">
						<div class="finder-form-transparent">
                  			<form method="post" name="search_form" id="search_form"><!-- === action="" ==== -->
								<div class="row">
									<div class="search-section">
                              <div class="form-group col-md-3 col-sm-3 col-xs-12 no-padding land-lookingfor">
                                 <div class="left">
                                    <div class="custom-select-wrapper">
                                       <select name="gender" id="Looking" class="custom-select sources" style="display: none;">
                                          <?php //echo $this->common_model->array_optionstr_search('gender');?>
                                          <option value="Female" title="Bride" selected="">Bride</option>
                                          <option value="Male" title="Groom">Groom</option>
                                       </select>
                                    </div>
                                 </div>
                              </div>
										
										<div class="form-group col-md-2 col-sm-2 col-xs-6 no-padding land-agefrom agefromto_mob-w">
											<div class="left">
												<div class="custom-select-wrapper">
													<select name="from_age" id="agefrom" class="custom-select sources" style="display: none;">
                                        <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),18);?>
													</select>
												</div>
											</div>
										</div>
										<div class="col-xs-2 agetolabel">
											<p class="left">to</p>
										</div>
										<div class="form-group col-md-2 col-sm-2 col-xs-6 no-padding land-ageto agefromto_mob-w">
											<div class="left">
												<div class="custom-select-wrapper">
													<select name="to_age" id="ageto" class="custom-select sources" style="display: none;">
                                          <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),30);?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group col-md-3 col-sm-3 col-xs-12 no-padding land-religion">
											<div class="left">
												<div class="custom-select-wrapper">
													<select name="religion[]" id="Religion" class="custom-select sources" style="display: none;">
														<option class="list" value="" selected="" title="Select Religion">Doesn't matter</option>
                                          <?php echo $this->common_model->array_optionstr_search($this->common_model->dropdown_array_table('religion'));?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group col-md-2 col-sm-2 col-xs-12 no-padding land-search">
											<div class="left pb-3">
                                    <button type="button" class="searchnow Poppins-Regular f-16 color-f" id="submit-btn" onClick="find_match()">Search</button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					</div>
				</div>
			</div>
			<!--find section End-->
			<!--Header END-->     
			<!--hover box-->
			<div class="container hidden-xs hidden-sm">
				<div class="row">
					<div class="col-md-12 col-sm-12 text-center mt-7">
						<div class="row">
							<h2 class="calibri-Bold-font mega-n3"><?php if(isset($config_data['middle_text1'])) { echo strtoupper(substr($config_data['middle_text1'],0,18)); } ?><span class="mega-n4"><?php if(isset($config_data['middle_text1'])) { echo strtoupper(substr($config_data['middle_text1'],18));}?></span></h2>
							<p class="calibri-regular-font mega-n5 f-15"><?php if(isset($config_data['middle_text1_description'])) { echo strtoupper($config_data['middle_text1_description']); } ?></p>
							<div class="mega-n-border text-center">
								<img src="<?php echo $base_url;?>assets/front_end_new/images/mega-n-border.png" alt="" class="img-responsive">
							</div>
						</div>
						<div class="row">
							<div class="col-md-4 col-xs-12 col-sm-4 text-center">
								<div class="box-step">
									<div class="step-number">
										<p class="text-center number-count Poppins-Semi-Bold">1</p>
									</div>
									<i class="fas fa-sign-in-alt fa-new"></i>
									<p class="Poppins-Medium f-19">Sign up</p>
								</div>
								<p class="p-sign-up Poppins-Regular f-15">
									<?php if(isset($config_data['sign_up_text'])) { echo $config_data['sign_up_text']; } ?>
								</p>
							</div>
							<div class="col-md-4 col-xs-12 col-sm-4 text-center">
								<div class="box-step">
									<div class="step-number">
										<p class="text-center number-count Poppins-Semi-Bold">2</p>
									</div>
									<i class="fas fa-users fa-new"></i>
									<p class="Poppins-Medium f-19">Contact</p>
								</div>
								<p class="p-sign-up Poppins-Regular f-15">
									<?php if(isset($config_data['contact_text'])) { echo $config_data['contact_text'];}?>
								</p>
							</div>
							<div class="col-md-4 col-xs-12 col-sm-4 text-center">
								<div class="box-step">
									<div class="step-number">
										<p class="text-center number-count Poppins-Semi-Bold">3</p>
									</div>
									<i class="fas fa-comments fa-new"></i>
									<p class="Poppins-Medium f-19">Interact</p>
								</div>
								<p class="p-sign-up Poppins-Regular f-15">
									<?php if(isset($config_data['interact_text'])) { echo $config_data['interact_text'];}?>
								</p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-12 mt-10">
								<div class="mega-n-btn1">
									<a href="<?php echo $base_url; ?>register" class="Poppins-Medium color-f f-16">Get Started</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END hover box-->
			<?php
      $logo_url = 'front_end/images/logo/logo-3.png';
		if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !='')
		{
			$logo_url = 'logo/'.$config_data['upload_logo'];
		}
		$other_banner1_url = '';
		$other_banner1_logo_url = $base_url.'assets/latest_home/images/bottom-img.png';
		$other_banner = $this->common_model->get_count_data_manual('other_banner',array('status'=>'APPROVED'),1,'','id desc');
		
		if($other_banner != '')
		{
			$path_other_banner = $this->common_model->other_banner;
			$no_image = $this->common_model->no_image_found;
			if(isset($other_banner['other_banner1']) && $other_banner['other_banner1'] !='' && file_exists($path_other_banner.$other_banner['other_banner1']))
			{
				$other_banner1_url = $base_url.$path_other_banner.$other_banner['other_banner1'];
			}else{
				$other_banner1_url = $base_url.$no_image;
			}
			
			if(isset($other_banner['other_banner1_logo']) && $other_banner['other_banner1_logo'] !='' && file_exists($path_other_banner.$other_banner['other_banner1_logo']))
			{
				$other_banner1_logo_url = $base_url.$path_other_banner.$other_banner['other_banner1_logo'];
			}
		}
		else
		{
			$other_banner1_url='';
		}
	?>
			<!--wedding bendor section start-->
			<div class="weding-vendor mt-6 hidden-xs hidden-sm">
				<div class="container">
					<div class="row">
						<div class="col-md-12 col-sm-12">
							<div class="col-md-6 col-sm-6">
								<div class="border-img">
									<img src="<?php echo $base_url;?>assets/front_end_new/images/2.png" alt="" class="img-responsive c1-img">
									<div class="border-in-img">
										<img src="<?php echo $other_banner1_url;?>" alt="wedding-vendor" class="img-responsive border-inner-img">
										
									</div>
									<img src="<?php echo $base_url;?>assets/front_end_new/images/1.png" alt="wedding-vendor" class="img-responsive c2-img">
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="mena-n9">
									<p class="calibri-Bold-font color-f mega-n7"><?php echo $other_banner['other_banner1_title'];?>
									</p>
									<p class="Poppins-Medium mega-n8">
										<?php echo $other_banner['other_banner1_description'];?>
									</p>
									<img src="<?php echo $base_url;?>assets/front_end_new/images/logo-2-n.png" alt="wedding-vendor" class="img-responsive logo-2n">
									<div class="mega-n-btn2">
										<a href="<?php echo $base_url;?>wedding-vendor" class="mega-n11 Poppins-Medium">Start Planning Today</a>
									</div>
									<img src="<?php echo $base_url;?>assets/front_end_new/images/bottom-img.png" alt="wedding-vendor" class="img-responsive img-bottom">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--wedding bendor section End-->
			<!--happy couple-->
			<?php
		$success_story = $this->common_model->get_count_data_manual('success_story',array('status'=>'APPROVED'),2,'*','id desc',1,3);
		if(isset($success_story) && $success_story !='' && is_array($success_story) && count($success_story) > 0)
		{
	    ?>
			<div class="container hidden-xs hidden-sm">
				<div class="row">
					<div class="row mt-5">
						<div class="col-md-12 col-sm-12 text-center">
							<h2 class="calibri-Bold-font mega-n3 f-47">JUST GET MARRIED HAPPY <span class="mega-n4">COUPLE</span></h2>
							<p class="calibri-regular-font mega-n5 f-15">SIMPLE WEDDING PLANNING TOOLS TO HELP YOU STAY ON TRACK.</p>
							<div class="mega-n-border text-center">
								<img src="<?php echo $base_url;?>assets/front_end_new/images/mega-n-border.png" alt="" class="img-responsive">
							</div>
						</div>
					</div>
					<div class="row mt-6 pb-7">
					<?php
						$no_image = $this->common_model->no_image_found;
                        $path_success = $this->common_model->path_success;
                        foreach($success_story as $success_story_val)
                        {
							if(isset($success_story_val['weddingphoto']) && $success_story_val['weddingphoto'] !='' && file_exists($path_success.$success_story_val['weddingphoto']))
							{
								$weddingphoto = $base_url.$path_success.$success_story_val['weddingphoto'];
							}
							else
							{
								$weddingphoto = $base_url.$no_image;
							}
							$groomname = $success_story_val['groomname'];
							$bridename = $success_story_val['bridename'];
					        $mid = $this->common_model->encrypt_id($success_story_val['id']);
					        $groomname = str_replace(' ','-',$groomname);
					        $bridename = str_replace(' ','-',$bridename); 
					        $url = 'success-story'.'/'.$mid.'/'.$groomname.'-'.$bridename;
					?>
						<div class="col-md-4">
							<div class="vendor-main">
								<div class="vendor">
									<a href="<?php echo $base_url.$url ?>"><img src="<?php echo $weddingphoto; ?>" alt="" class="img-responsive mega-c1"></a>
									<div class="c1-name">
										<p class="Poppins-Semi-Bold f-18 c1-n1"><?php echo $success_story_val['groomname'];?> & <?php echo $success_story_val['bridename'];?></p>
									</div>
								</div>
								<div class="c1-t1">
									<p class="Poppins-Regular f-15 c1-t2"><?php 
									$successmessage = strip_tags($success_story_val['successmessage']);
									$strlenth = strlen($successmessage);
									echo $successmessage = substr($successmessage,0,274);
									if(isset($strlenth) && $strlenth!='' && $strlenth>=250){
										echo '....';
									?><a href="<?php echo $base_url.$url; ?>" class="mega-rm Poppins-Medium">Read More</a><?php } ?>
									</p>
								</div>
							</div>
						</div>
						<?php
						}
					?>
					</div>
				</div>
			</div>
			<?php
						}
					?>
			<!--happy couple-->
			<!--mobile app section start-->
			<div class="app-develop margin-top-50 hidden-sm hidden-xs pb-5">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xs-12 col-sm-12">
							<p class="just-app calibri-Bold-font">Happiness is just an app away!</p>
							<p class="just-app-p Poppins-Medium f-16"><?php if(isset($other_banner['mobile_matrimony_description']) && $other_banner['mobile_matrimony_description']!=''){echo $other_banner['mobile_matrimony_description'];}?>
							</p>
							<p class="app-b color-31 Poppins-Medium f-16 mt-5"> Simple  &nbsp; |  &nbsp; Fast  &nbsp; | &nbsp; Convenient  &nbsp;|  &nbsp;Safe &amp; Secure</p>
							<div class="line-dot mt-6">
								<ul>
									<li class="margin-top-10"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Easy registration &amp; login</a></li>
									<li class="mt-2"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Quick matches &amp; search criteria</a></li>
									<li class="mt-2"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Find your perfect better half</a></li>
								</ul>
							</div>
							<div class="text-left app-av-img">
								<div class="row">
									<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){?>
									<div class="col-md-5 col-sm-4">
									
										<a target='_blank' href="<?php echo $config_data['android_app_link']; ?>">
											<img src="<?php echo $base_url;?>assets/front_end_new/images/app-store.png" class="img-responsive mega-n-app1" alt="Android App">
										</a>
									
									</div>
									<?php }
									 if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !=''){
									?>
									<div class="col-md-5 col-sm-4">   
									
										<a target='_blank' href="<?php echo $config_data['ios_app_link']; ?>">
											<img src="<?php echo $base_url;?>assets/front_end_new/images/app-store2.png" class="img-responsive <?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){ echo 'mega-n-app2';}else{ echo 'mega-n-app1';}?>" alt="iOS App">
										</a>
									
									</div>
									<?php }?>
								</div>
							</div>
						</div>
						<?php $other_banner2_url = $base_url.'assets/front_end_new/images/app-ss.png';
					if($other_banner != ''){
						$path_other_banner = $this->common_model->other_banner;
						if(isset($other_banner['other_banner2']) && $other_banner['other_banner2'] !='' && file_exists($path_other_banner.$other_banner['other_banner2'])){
							$other_banner2_url = $base_url.$path_other_banner.$other_banner['other_banner2'];
						}
					}?>
						<div class="col-md-6 col-xs-12 col-sm-12">
							 <img src="<?php echo $other_banner2_url;?>" class="img-lap-top img-responsive" alt=""> 
							
						</div>
					</div>
				</div>
			</div>
			<!--for mobile device-->
			<div class="app-develop-for-mobile hidden-lg hidden-md hidden-sm">
				<div class="container">
					<div class="row hidden-lg hidden-md hidden-sm">
						<div class="col-xs-12 text-center">
							<p class="just-app calibri-Bold-font f-38">Happiness is just an app <span class="color-d">away!</span></p>
							<img src="<?php echo $base_url;?>assets/front_end_new/images/mega-n-border.png" alt="" class="img-responsive">
							<div class="line-dot mt-5">
								<ul>
									<li class="margin-top-10"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Easy registration &amp; login</a></li>
									<li class="mt-2"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Quick matches &amp; search criteria</a></li>
									<li class="mt-2"><a href="javascript:void(0);" class="Poppins-Semi-Bold f-18 color-31">Find your perfect better half</a></li>
								</ul>
							</div>
						</div>
						<div class="col-xs-12">
							<img src="<?php echo $other_banner2_url;?>" class="img-lap-top img-responsive" alt="">
						</div>
						<div class="row row-cstm">
							<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {?>
								<div class="col-xs-6">
								<a target='_blank' href="<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {echo $config_data['android_app_link'];}?>">
								<img src="<?php echo $base_url;?>assets/front_end_new/images/app-store.png" class="img-responsive mega-n-app1" alt="">
								</a>
							</div>
							<?php }?>
							<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {?>
							<div class="col-xs-6">
								<a target='_blank' href="<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {echo $config_data['ios_app_link'];}?>">
								<img src="<?php echo $base_url;?>assets/front_end_new/images/app-store2.png" class="img-responsive <?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){ echo 'mega-n-app2';}else{ echo 'mega-n-app1';}?>" alt="">
								</a>
							</div>								
							<?php }?>
						</div>
						<div class="col-xs-12">
							<p class="just-app-p Poppins-Medium f-16 text-center mt-5"><?php if(isset($other_banner['mobile_matrimony_description']) && $other_banner['mobile_matrimony_description']!=''){echo $other_banner['mobile_matrimony_description'];}?>
							</p>
						</div>
						<div class="col-xs-12">
							<p class="app-b color-31 Poppins-Medium f-16 mt-5 text-center"> Simple  &nbsp; |  &nbsp; Fast  &nbsp; | &nbsp; Convenient  &nbsp;|  &nbsp;Safe &amp; Secure</p>
						</div>
					</div>
				</div>
			</div>
			<!--END-->
			<!--mobile app section end-->
            <!--WEDDING PLANNING TOOLS section start-->
			
			<div class="weding-vendor-wedding mt-6">
				<div class="container">
					<div class="row mt-2 row-cstm">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<h2 class="calibri-Bold-font mega-n3 f-40" style="color:#fff!important;"><?php echo $config_data['middle_text2'];?></h2>
							<p class="calibri-regular-font mega-n5 color-f f-15 new-wedding-t"><?php echo $config_data['middle_text2_description'];?></p>
							<div class="mega-n-border text-center">
								<img src="<?php echo $base_url;?>assets/front_end_new/images/wedding-white.png" alt="" class="img-responsive">
							</div>
						</div>
					</div>
					
					<div class="row mt-6" style="margin-bottom:30px;">
					<?php
					$reason_why_choose = $this->common_model->get_count_data_manual('reason_why_choose',array('status'=>'APPROVED'),2,'','id asc',1,3);
					$path_reason_why_choose = 'assets/reason_why_to_choose/';
					if(isset($reason_why_choose) && $reason_why_choose != '' && is_array($reason_why_choose) && count($reason_why_choose) > 0){
						foreach($reason_why_choose as $row){
							$path_reason_why_choose_url = '';
							if(isset($row['icon']) && $row['icon']!='' && file_exists($path_reason_why_choose.$row['icon'])){
								$path_reason_why_choose_url = $base_url.$path_reason_why_choose.$row['icon'];
							}?>
                		<div class="col-md-4 col-xs-12 col-sm-4">
							<div class="vendor-main-wedding">
								<div class="vendor-wedding">
									<img src="<?php echo $path_reason_why_choose_url; ?>" alt="<?php echo strip_tags($row['title']); ?>" class="img-responsive img-center-wedding"/>
									<div class="c1-name-wedding">
										<p class="f-14 c1-n1-wedding"><?php
											echo $row['title'];
										?></span>
										</p>
									</div>
								</div>
								<div class="c1-t1-wedding">
									<p class="Poppins-Regular f-15 c1-t2-wedding"><?php
										$description = strip_tags($row['description']);
										if (strlen($description) > 120) {
											echo $description = substr($description, 0, 120).'...';
										}else{
											echo $description;
										}?>
									</p>
								</div>
							</div>
						</div>
						<?php } 
					}?>
					</div>
				</div>
			</div>
			<!--WEDDING PLANNING TOOLS section End-->
			<!--why us section start-->
            <div class="chosen_section">
			<div class="container">
				<div class="row">
					<div class="choose-us-section">
						<div class="row mt-5 row-cstm">
							<div class="col-md-12 col-sm-12 col-xs-12 text-center">
								<h2 class="calibri-Bold-font mega-font-new f-47">MORE REASONS WHY TO <span class="mega-font-mobile">CHOOSE US</span></h2>
								<p class="calibri-regular-font mega-n5 f-15 hidden-xs">SIMPLE WEDDING PLANNING TOOLS TO HELP YOU STAY ON TRACK.</p>
								<div class="mega-n-border text-center">
									<img src="<?php echo $base_url;?>assets/front_end_new/images/mega-n-border.png" alt="" class="img-responsive">
								</div>
							</div>
						</div>
						<div class="row row-cstm">
							<div class="col-md-12 col-sm-12 col-xs-12 mt-5 pb-5">
								<p class="Poppins-Regular f-17 color-31 w-p1">
                           <?php echo $config_data['reason_why_choose_text']; ?>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
          </div>  
			<!--end why us section-->
         <!-- ===== <div class="container"> =======End ======= -->		
<?php 
	$this->common_model->js_extra_code_fr.='
	$(window).scroll(function() {
		if($(".header-v2").length > 0)
		{
			if ($(".header-v2").offset().top > 50) {
				$(".navbar-fixed-top").addClass("top-nav-collapse");
				} else {
				$(".navbar-fixed-top").removeClass("top-nav-collapse");
			}
		}
	});
	$(window).scroll(function() {
		$(".slideanim").each(function(){
			var pos = $(this).offset().top;
			var winTop = $(window).scrollTop();
			if (pos < winTop + 600) {
				$(this).addClass("slide");
			}
		});
	});
	$(document).ready(function(){
	
		var other_bannerUrl = $("#other_banner1").val();
		if(other_bannerUrl != ""){
			$(".module").css("background-image", "url(" + other_bannerUrl + ")");
		}
		
		$('."'".'[data-toggle="tooltip"]'."'".').tooltip();
		$('."'".'[rel="tooltip"]'."'".').tooltip();
	});
	function rotateCard(btn){
		var $card = $(btn).closest(".card-container");
		console.log($card);
		if($card.hasClass("hover")){
			$card.removeClass("hover");
			} else {
			$card.addClass("hover");
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
	
	';
	
?>
			