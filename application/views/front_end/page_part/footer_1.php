<?php

$this->common_model->user_ip_block();
if(base_url()=='http://192.168.1.111/mega_matrimony/original_script/'){
	$uri_segment_check_red = $this->uri->segment(1);
	if(isset($uri_segment_check_red) && $uri_segment_check_red!=''){
		$uri_segment_check_red = $this->uri->segment(1);
	}
	else{
		$uri_segment_check_red = basename($_SERVER['PHP_SELF']);
	}
	if(isset($uri_segment_check_red) && $uri_segment_check_red!='' && $uri_segment_check_red!="blocked"){
		$details = $this->common_model->add_user_analysis();
	}
}
//$ver_cont = '1.64512';
$logo_url_footer = 'front_end/images/logo/logo-3.png';
if(isset($config_data['upload_footer_logo']) && $config_data['upload_footer_logo'] !=''){
	$logo_url_footer = $base_url.'assets/logo/'.$config_data['upload_footer_logo'];
}
$is_login = $this->common_front_model->checkLogin('return');


   $website_title = 'Welcome to Matrimony';
   if(isset($config_data['website_title']) && $config_data['website_title'] !='')
   {
      $website_title = $config_data['website_title'];
   }

?>
<!--footer-->
			<div class="bg-footer hidden-xs hidden-sm">
				<div class="container-fluid">
                <?php
        $is_home_page = 'no';
        if(isset($this->common_model->class_name) && $this->common_model->class_name =='home'){
            $is_home_page = 'yes';
        }
        if($is_home_page == 'yes'){
        ?>
					<div class="row hidden-xs">
						<div class="col-md-12 col-xs-12 col-sm-12 mt-5 text-center">
							<h4 class="text-center find-section-new calibri-Bold-font color-31 f-31">Browse Matrimonial <span class="color-d">Profiles</span> By</h4>
						</div>
					</div>
					<div class="row mt-5 pb-5 hidden-xs ">
					<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p3">
							<h5 class="f-c">Religion</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
                            <?php $where_religion = array('is_deleted'=>'No',"search_type"=>"Religion");
							$religion_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_religion,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($religion_arr) && $religion_arr !='' && is_array($religion_arr) && count($religion_arr) > 0){
								foreach($religion_arr as $religion_arr){
									$religion = str_ireplace(" ","-",$religion_arr['slug']);
									?>
									<li><a href="<?php echo $base_url.'matrimony/'.$religion;?>" target="_blank"><?php echo $religion_arr['matrimony_name'];?></a></li>

									<?php
								}
							}
								?>
							</ul>
						</div>
						<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p5">
							<h5 class="f-c">Caste</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
                            <?php $where_caste= array('is_deleted'=>'No',"search_type"=>"Caste");
							$caste_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_caste,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($caste_arr) && $caste_arr !='' && is_array($caste_arr) && count($caste_arr) > 0){
								foreach($caste_arr as $caste_arr){
								$caste = str_ireplace(" ","-",$caste_arr['slug']);
									?>
									<li><a href="<?php echo $base_url.'matrimony/'.$caste;?>" target="_blank"><?php echo $caste_arr['matrimony_name'];?></a></li>
									<?php
								}
							}?>
							</ul>
						</div>
						<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p4">
							<h5 class="f-c">Mother Tongue</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
                            <?php $where_mother_tongue= array('is_deleted'=>'No',"search_type"=>"Mother-Tongue");
							$mother_tongue_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_mother_tongue,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($mother_tongue_arr) && $mother_tongue_arr !='' && is_array($mother_tongue_arr) && count($mother_tongue_arr) > 0){
								foreach($mother_tongue_arr as $mother_tongue_arr){
									$mother_tongue = str_ireplace(" ","-",$mother_tongue_arr['slug']);?>

									<li><a href="<?php echo $base_url.'matrimony/'.$mother_tongue;?>" target="_blank"><?php echo $mother_tongue_arr['matrimony_name'];?></a></li>

									<?php
								}
							} ?>

							</ul>
						</div>
						<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p1">
							<h5 class="f-c">Country</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
                            <?php

							$where_country_code = array('is_deleted'=>'No',"search_type"=>"Country");
                            $country_code_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_country_code,2,'slug,matrimony_name','rand()',1,8);
                            if(isset($country_code_arr) && $country_code_arr !='' && is_array($country_code_arr) && count($country_code_arr) > 0){
								foreach($country_code_arr as $country_code_arr){
									$slug_url_name = str_ireplace(" ","-",$country_code_arr['slug']);
									?>
									<li><a href="<?php echo $base_url.'matrimony/'.$slug_url_name;?>" target="_blank"><?php echo $country_code_arr['matrimony_name'];?></a></li>
								<?php }
								} ?>
							</ul>
						</div>
						<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p1">
							<h5 class="f-c">State</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
                            <?php

							$where_state_code = array('is_deleted'=>'No',"search_type"=>"State");
                            $state_code_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_state_code,2,'slug,matrimony_name','rand()',1,8);
                            if(isset($state_code_arr) && $state_code_arr !='' && is_array($state_code_arr) && count($state_code_arr) > 0){
								foreach($state_code_arr as $state_code_arr){
									$slug_url_name = str_ireplace(" ","-",$state_code_arr['slug']);
									?>
									<li><a href="<?php echo $base_url.'matrimony/'.$slug_url_name;?>" target="_blank"><?php echo $state_code_arr['matrimony_name'];?></a></li>
								<?php }
								} ?>
							</ul>
						</div>
						<div class="col-xs-12 col-md-2 col-sm-6 col-x" id="p2">
							<h5 class="f-c">Cities</h5>
							<ul class="list-unstyled quick-links Poppins-Regular f-14">
							<?php $where_city= array('is_deleted'=>'No',"search_type"=>"City");
							$city_arr = $this->common_model->get_count_data_manual('matrimony_data',$where_city,2,'id,slug,matrimony_name','rand()',1,8);
							if(isset($city_arr) && $city_arr !='' && is_array($city_arr) && count($city_arr) > 0){
								foreach($city_arr as $city_arr){
								$city = str_ireplace(" ","-",$city_arr['slug']);
									?>
									<li><a href="<?php echo $base_url.'matrimony/'.$city;?>" class="font-12" target="_blank"><?php echo $city_arr['matrimony_name'];?></a></li>

								<?php }
							}?>
							</ul>
						</div>
					</div>
                    <?php }?>
					<div class="row">
						<div class="footer-b pb-3">
							<div class="container-fluid">
								<div class="row mt-6">
									<div class="col-xs-12 col-md-4 col-sm-6 col-half-offset col-xf">
										<div class="f2-box">
                                            <a href="<?php echo $base_url;?>">
                                                <img src="<?php echo $logo_url_footer;?>" alt="<?php echo $website_title;?>" class="img-responsive footer-logo" style="max-width: 70%!important;">
                                            </a>
											<p class="f2-text color-f Poppins-Regular f-15 mt-5">
                                                <?php if(isset($config_data['website_description']) && $config_data['website_description'] !=''){ echo $config_data['website_description'];}?>
                                            </p>
											<div class="mt-5">
												<p class="folow-us color-f Poppins-Bold">Follow Us</p>
												<div class="s-icon">
                                                    <a href="<?php if(isset($config_data['facebook_link']) && $config_data['facebook_link'] !=''){ echo $config_data['facebook_link'];} ?>" target="_blank"><i id="social-fb" class="fa fa-facebook-square fa-3x font-weight-2  color-f"></i></a>
                                                    <a href="<?php if(isset($config_data['twitter_link']) && $config_data['twitter_link'] !=''){ echo $config_data['twitter_link'];} ?>" target="_blank"><i class="fa fa-twitter-square fa-3x font-weight-2  color-f"></i></a>
                                                    <a href="<?php if(isset($config_data['google_link']) && $config_data['google_link'] !=''){ echo $config_data['google_link'];} ?>" target="_blank"><i id="social-gp" class="fa fa-instagram color-f  square-cstm"></i></a> 
                                                    <a href="<?php if(isset($config_data['linkedin_link']) && $config_data['linkedin_link'] !=''){ echo $config_data['linkedin_link'];} ?>" target="_blank"><i id="social-em" class="fa fa-linkedin-square font-weight-2 fa-3x  color-f"></i></a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-2 col-half-offset col-x-2" id="mg-1">
										<h5 class="f-c2 color-f Poppins Medium">Help &amp; Support</h5>
										<ul class="list-unstyled quick-links footer-b-a">
                                            <li><a href="<?php echo $base_url; ?>contact"><i class="fas fa-angle-right f"></i>Contact us</a></li>
                                            <li><a href="<?php echo $base_url; ?>faq"><i class="fas fa-angle-right f"></i>FAQs</a></li>
                                            <li><a href="<?php echo $base_url;?>success-story"><i class="fas fa-angle-right f"></i>Success Stories</a></li>
                                            <li><a href="<?php echo $base_url;?>mobile-matri"><i class="fas fa-angle-right f"></i>Mobile Matrimony</a></li>
                                            <li><a href="<?php echo $base_url;?>premium-member"><i class="fas fa-angle-right f"></i>Payment Option</a></li>
                                            <li><a href="<?php echo $base_url;?>demograph"><i class="fas fa-angle-right f"></i>Member Demograph</a></li>
										</ul>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-2 col-half-offset col-x-2" id="mg-2">
										<h5 class="f-c2 color-f Poppins Medium">Information</h5>
										<ul class="list-unstyled quick-links footer-b-a">
                                        <?php
                                    $cms_pages_arr = $this->common_model->get_count_data_manual('cms_pages',array('is_deleted'=>'No','status'=>'APPROVED'),2,'page_title,page_url','page_title asc');
                                    if(isset($cms_pages_arr) && $cms_pages_arr !='' && is_array($cms_pages_arr) && count($cms_pages_arr) > 0)
                                    {
                                       $cms_url_arr = array('about-us','refund-policy','report-misuse','privacy-policy','terms-condition');
                                       foreach($cms_pages_arr as $cms_pages_arr_val)
                                       {
                                          if(in_array($cms_pages_arr_val['page_url'],array('faq-page','contact-us')))
                                          {
                                             continue;
                                          }
                                          $cms_page_url = 'cms/index/'.$cms_pages_arr_val['page_url'];
                                          if(in_array($cms_pages_arr_val['page_url'],$cms_url_arr))
                                          {
                                             $cms_page_url = $cms_pages_arr_val['page_url'];
                                          }
                                 ?>
                                    <li>
                                       <a href="<?php echo $base_url.$cms_page_url; ?>"><i class="fas fa-angle-right f"></i><?php echo $cms_pages_arr_val['page_title']; ?></a>
                                    </li>
                                       <?php
                                       }
                                    }
                                 ?>
											<li><a href="<?php echo $base_url.'blog'; ?>"><i class="fas fa-angle-right f"></i>Blog</a></li>
										</ul>
									</div>
									<div class="col-xs-12 col-sm-6 col-md-2 col-half-offset col-x-2" id="mg-3">
										<h5 class="f-c2 color-f Poppins Medium">Others</h5>
										<ul class="list-unstyled quick-links footer-b-a">
                                        <?php if(!$is_login){?>
                                            <li><a href="<?php echo $base_url;?>register"><i class="fas fa-angle-right f"></i>Register</a></li>
                                            <li><a href="<?php echo $base_url;?>login"><i class="fas fa-angle-right f"></i>Log In</a></li>
                                    <?php } ?>
                                            <li><a href="<?php echo $base_url;?>event"><i class="fas fa-angle-right f"></i>Events</a></li>
                                            <li><a href="<?php echo $base_url;?>wedding-vendor"><i class="fas fa-angle-right f"></i>Vendor</a></li>
                                            <li><a href="<?php echo $base_url;?>add-with-us"><i class="fas fa-angle-right f"></i>Advertise With us</a></li>
										</ul>
									</div>
								</div>
							</div>
						</div>
						<section class="nb-copyright">
							<div class="container">
								<div class="row">
									<div class="col-sm-12 col-md-12 col-xs-12 copyrt xs-center text-center">
										<h6 class="Poppins-Medium color-f f-15">
											<a href="<?php echo $base_url;?>terms-condition">Terms &amp; Conditions</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="line-2"> |  </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<a href="<?php echo $base_url;?>privacy-policy">Privacy Policy</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="line-2"> |  </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!-- <a href="#">Sitemap</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="line-2"> |  </span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  -->
											<a href="<?php echo $base_url;?>contact">Contact Us</a>
										</h6>
										<h6 class="Poppins-Medium color-f f-15">&#x000A9; <?php if(isset($config_data['footer_text']) && $config_data['footer_text'] !=''){ echo $config_data['footer_text'];} ?></h6>
										<!-- © All Rights Reserved.-->
									</div>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
			<!--End footer-->
			<!--footer for mobile-->
			<div class="footer-for-mobile pt-5 pb-5 hidden-lg hidden-md col-sm-12">
				<div class="container">
					<div class="row">
                        <div class="col-xs-6">
                        <h5 class="f-c2 color-31 color-f Poppins Medium">Follow Us:</h5>
                        <div class="s-icon">
                                <a href="<?php if(isset($config_data['facebook_link']) && $config_data['facebook_link'] !=''){ echo $config_data['facebook_link'];} ?>" target="_blank"><i id="social-fb2" class="fa fa-facebook-square fa-3x font-weight-2"></i></a>
                                <a href="<?php if(isset($config_data['twitter_link']) && $config_data['twitter_link'] !=''){ echo $config_data['twitter_link'];} ?>" target="_blank"><i class="fa fa-twitter-square fa-3x font-weight-2"></i></a>
                                <a href="<?php if(isset($config_data['google_link']) && $config_data['google_link'] !=''){ echo $config_data['google_link'];} ?>" target="_blank"><i id="social-gp2" class="fa fa-instagram  square-cstm"></i></a> 
                                <a href="<?php if(isset($config_data['linkedin_link']) && $config_data['linkedin_link'] !=''){ echo $config_data['linkedin_link'];} ?>" target="_blank"><i id="social-em2" class="fa fa-linkedin-square font-weight-2 fa-3x"></i></a>
							</div>
                        </div>

                        <div class="col-xs-6">
                        <?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){?>
							<a target="_blank" href="<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !=''){ echo $config_data['android_app_link'];} ?>">
							<div class="android_icon">
							<i class="fab fa-android and_icon f-20"></i>
							</div>
							</a>
						<?php }?>

						<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !=''){?>
							<a target="_blank" href="<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !=''){ echo $config_data['ios_app_link'];} ?>">
							<div class="android_icon">
							<i class="fab fa-apple apple_icon f-20"></i>
							</div>
							</a>
						<?php }?>

                        </div>
					</div>
				</div>
			</div>
			<div class="copyright-mn1 hidden-lg hidden-md">
				<div class="col-xs-12 col-sm-12">
					<h6 class="Poppins-Medium color-f f-15 mt-4 f-bar">&#x000A9; <?php if(isset($config_data['footer_text']) && $config_data['footer_text'] !=''){ echo $config_data['footer_text'];} ?></h6>
				</div>
			</div>
			<!--END footer for mobile-->
			<!--back top top-->
			<div class="progress-wrap">
				<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
					<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
				</svg>
			</div>
			<!--back to top-->

		</div>
        <div class="clearfix"></div>
<div id="lightbox-panel-mask"></div>
<div id="lightbox-panel-loader" style="text-align:center;">
	<img alt="Please wait.." title="Please wait.." src="<?php echo $base_url; ?>assets/front_end/images/loading.gif" />
</div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />

<script src="<?php echo $base_url;?>assets/front_end_new/js/jquery-3.2.1.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery-3.2.1.min.js');?>"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/bootstrap.js?ver=<?php echo filemtime('assets/front_end_new/js/bootstrap.js');?>"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>

<?php if($this->router->fetch_class()=='my_dashboard' || $this->router->fetch_class()=='my_profile' || $this->router->fetch_class()=='upload' || $this->router->fetch_class()=='modify_photo' || $this->router->fetch_class()=='matches' || $this->router->fetch_method()=='admin' || $this->router->fetch_method()=='current_plan'){?>
<script src="<?php echo $base_url;?>assets/front_end_new/js/owl.carousel.min.js?ver=<?php echo filemtime('assets/front_end_new/js/owl.carousel.min.js');?>"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/slider.js?ver=<?php echo filemtime('assets/front_end_new/js/slider.js');?>"></script>
<?php }?>
<?php
if(isset($this->common_model->extra_js_fr) && $this->common_model->extra_js_fr!='' && count($this->common_model->extra_js_fr) > 0){
	$extra_js_fr = $this->common_model->extra_js_fr;
	foreach($extra_js_fr as $extra_js_val){?>
	<script src="<?php echo $base_url.'assets/front_end_new/'.$extra_js_val; ?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_js_val);?>"></script>
	<?php }
}
if (isset($this->extra_js_script) && $this->extra_js_script!='') {
	echo $this->extra_js_script;
}?>

<!-- cookie popup code end -->

<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<!-- cookie popup start -->
<script type="text/javascript">
function cookiesPolicyPrompt(){
  if (Cookies.get('acceptedCookiesPolicy') !== "yes"){
    //console.log('accepted policy', chk);
    $("#alertCookiePolicy").show(); 
  }
  $('#btnAcceptCookiePolicy').on('click',function(){
    //console.log('btn: accept');
    Cookies.set('acceptedCookiesPolicy', 'yes', { expires: 30 });
  });
  $('#btnDeclineCookiePolicy').on('click',function(){
    //console.log('btn: decline');
    // document.location.href = "javascript:void(0)";
    cookieAlert.fadeOut('slow');
  });
}

$( document ).ready(function() {
  cookiesPolicyPrompt();
  
  //-- following not for production ------
  $('#btnResetCookiePolicy').on('click',function(){
    console.log('btn: reset');
    Cookies.remove('acceptedCookiesPolicy');
    $("#alertCookiePolicy").show();
  });
  // ---------------------------
});
</script>

<!-- cookie popup end -->




<script>
/*$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});*/
	//Scroll back to top
	(function($) { "use strict";
		$(document).ready(function(){"use strict";
			var progressPath = document.querySelector('.progress-wrap path');
			var pathLength = progressPath.getTotalLength();
			progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
			progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
			progressPath.style.strokeDashoffset = pathLength;
			progressPath.getBoundingClientRect();
			progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
			var updateProgress = function () {
				var scroll = $(window).scrollTop();
				var height = $(document).height() - $(window).height();
				var progress = pathLength - (scroll * pathLength / height);
				progressPath.style.strokeDashoffset = progress;
			}
			updateProgress();
			$(window).scroll(updateProgress);
			var offset = 50;
			var duration = 550;
			jQuery(window).on('scroll', function() {
				if (jQuery(this).scrollTop() > offset) {
					jQuery('.progress-wrap').addClass('active-progress');
					} else {
					jQuery('.progress-wrap').removeClass('active-progress');
				}
			});
			jQuery('.progress-wrap').on('click', function(event) {
				event.preventDefault();
				jQuery('html, body').animate({scrollTop: 0}, duration);
				return false;
			})
		});
	})(jQuery);

	$("#menu-toggle").click(function(e) {
		e.preventDefault();
		$("#wrapper").toggleClass("toggled");
		$(this).find('i').toggleClass('fa-navicon fa-times')
	});
    $('.leftMenuCall').on('click', function(){
        document.getElementById("mySidenav").style.width = "100%";
        document.getElementById("rightSideNav").style.width = "0";
	});
    $('.closeLeftMenuBtn').on('click', function(){
        document.getElementById("mySidenav").style.width = "0";
	});
    $('.rightMenuCall').on('click', function(){
        document.getElementById("rightSideNav").style.width = "100%";
        document.getElementById("mySidenav").style.width = "0";
	});
    $('.closeRightMenuBtn').on('click', function(){
        document.getElementById("rightSideNav").style.width = "0";
	});

	$(".contact-tab-nav").click(function(){
		$(this).tab('show');
	});

	$(".contact-tab-nav2").click(function(){
		$(this).tab('show');
	});
	$(function() {
		$(".expand").on( "click", function() {
			// $(this).next().slideToggle(200);
			$expand = $(this).find(">:first-child");
			if($expand.text() == "+") {
				$expand.text("-");
				} else {
				$expand.text("+");
			}
		});
	});
	function hr_hide_show(id){
		$("#l2").removeClass("active-class-grey");
		$("#l2").addClass("active-class-red");
		$(".l2").addClass("active");
	}
	<?php
	if($this->common_front_model->checkLogin('return')){
	?>
		document.addEventListener('DOMContentLoaded', function() {
			StartTimers();
		}, false);

	<?php }
	if(isset($this->common_model->js_extra_code_fr) && $this->common_model->js_extra_code_fr !=''){
		echo $this->common_model->js_extra_code_fr;
	}
?>
function open_profile_chat(id)
{
	window.open('<?php echo $base_url.'search/view-profile/' ?>'+id);
}
</script>

<!--===========================FreiChat START=========================-->
<!--	For uninstalling ME , first remove/comment all FreiChat related code i.e below code Then remove FreiChat tables frei_session & frei_chat if necessary The best/recommended way is using the module for installation -->
<?php

$user_data = $this->common_front_model->get_session_data();
//print_r($user_data);
$plan_status = '';
if(isset($user_data['id']) && $user_data['id'] !='')
{
	$user_id = $user_data['id'];
}
if(isset($user_data['plan_status']) && $user_data['plan_status'] !='')
{
	$plan_status = $user_data['plan_status'];
}
if($plan_status =='Paid' && isset($user_data['plan_chat']) && $user_data['plan_chat'] =='No')
{
	$plan_status ='Paid_NOCHAT';
}

if(isset($user_id) && $user_id !='')
{
	$ses = $user_id;
	setcookie("freichat_user", "LOGGED_IN", time()+3600, "/");
	if(!function_exists("freichatx_get_hash"))
	{
		function freichatx_get_hash($ses)
		{
			if(is_file("freichat/hardcode.php"))
			{
				require "freichat/hardcode.php";
				$temp_id =  $ses . $uid;
				return md5($temp_id);
		   }
		   else
		   {
				echo "<script>alert('module freichatx says: hardcode.php file not found!');</script>";
		   }
		   return 0;
		}
	}?>
	<script src="<?php echo $base_url;?>/freichat/client/main.php?id=<?php echo $ses;?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
	<link rel="stylesheet" href="<?php echo $base_url;?>/freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
<?php }?>
    <input type="hidden" id="hidd_plan_status" value="<?php if(isset($plan_status) && $plan_status !=''){echo $plan_status;}?>" />
    <!--===========================FreiChatX END=========================-->
    <span style="display:none;">
    <?php
        $config_data1 = $this->common_model->get_site_config();
        echo $config_data1['google_analytics_code'];
    ?>
    </span>
    <div id="timeout" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header"><h4 class="text-danger"><i class="fa fa-warning"></i> Session About To Timeout </h4></div>
                <div class="modal-body">No activity for too long. You will be automatically logged out in <b>1 minute</b>.</div>
                <div class="modal-footer">
                    <a href="javascript:ResetTimers()" class="btn btn-success btn-block">Keep Me Logged In</a>
                </div>
            </div>
        </div>
    </div>

    <!-- cookie popup code start -->

<div class="container">
	<div class="row">
	    <div class="col-md-12 col-xs-12 col-sm-12">
	      
	<!-- === START ====== -->
	<div id="alertCookiePolicy" class="alert-cookie-policy">
	  <div class="alert alert-secondary mb-0 d-flex text-center" role="alert">
	    <span class="mr-auto">This site uses cookies. By continuing to browse the site you are agreeing to our cookie policy. </span>
	    <button id="btnDeclineCookiePolicy" class="btn btn-light mr-3 decline-btn" data-dismiss="alert" type="button" aria-label="Close">Decline</button>
	    <button id="btnAcceptCookiePolicy" class="btn btn-primary accept-btn" data-dismiss="alert" type="button" aria-label="Close">Accept</button>
	  </div>  
	</div>
</div>
<!-- === END ====== -->
      
      
    </div>
  </div>
<!-- cookie popup code end -->
<?php include_once("log_reg_menu_script.php");?>
	</body>
</html>