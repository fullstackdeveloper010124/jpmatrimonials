<style>
	/* #freicontain0{
		left: 868px !important;
	} */
</style>
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
$logo_url_footer = 'front_end/images/logo/logo-3.png';
if(isset($config_data['upload_footer_logo']) && $config_data['upload_footer_logo'] !=''){
	$logo_url_footer = $base_url.'assets/logo/'.$config_data['upload_footer_logo'];
}
$is_login = $this->common_front_model->checkLogin('return');
$website_title = 'Welcome to Matrimony';
if(isset($config_data['website_title']) && $config_data['website_title'] !=''){
	$website_title = $config_data['website_title'];
}
?>
<!-- =========== Footer Start  =========== -->
		<footer class="footer-bg">
			<div class="container">
				<div class="row margin-top-20">
					<div class="col-md-6 col-xs-12 col-sm-12">
						<div class="footer-title">
							<p class="">About us</p>
							<span></span>
						</div>
						<div class="about-us">
							<p><?php if(isset($config_data['website_description']) && $config_data['website_description']!=''){ echo $config_data['website_description'];}?></p>
						</div>
					</div>
					<div class="col-md-6 col-xs-12 col-sm-12">
						<div class="row">
							
							<div class="col-md-4 col-xs-12 col-sm-4">
								<div class="footer-title">
									<p class="">Help & Support</p>
									<span></span>
								</div>
								<ul class="list-unstyled cms-ul margin-top-15">
									<li>
										<a href="<?php echo $base_url; ?>contact">Contact us </a>
									</li>
									<li>
										<a href="<?php echo $base_url; ?>faq">FAQs </a>
									</li>
									<?php /*
									<li>
										<a href="<?php echo $base_url;?>success-story">Success Stories </a>
									</li>
									
									<li>
										<a href="<?php echo $base_url;?>mobile-matri">Mobile Matrimony </a>
									</li>
									*/ ?>
									<li>
										<a href="<?php echo $base_url;?>premium-member">Payment Option</a>
									</li>
									<li>
										<a href="<?php echo $base_url;?>demograph">Member Demograph</a>
									</li>
								</ul>	
							</div>

							<div class="col-md-4 col-xs-12 col-sm-4">
								<div class="footer-title">
									<p class="">Information</p>
									<span></span>
								</div>
								<ul class="list-unstyled cms-ul margin-top-15">
									<?php
                                    $cms_pages_arr = $this->common_model->get_count_data_manual('cms_pages',array('is_deleted'=>'No','status'=>'APPROVED'),2,'page_title,page_url','page_title asc');
                                    if(isset($cms_pages_arr) && $cms_pages_arr !='' && is_array($cms_pages_arr) && count($cms_pages_arr) > 0)
                                    {
                                       $cms_url_arr = array('about-us','refund-policy','report-misuse','privacy-policy','terms-condition');
                                       foreach($cms_pages_arr as $cms_pages_arr_val){
                                          if(in_array($cms_pages_arr_val['page_url'],array('faq-page','contact-us'))){
                                             continue;
                                          }
                                          $cms_page_url = 'cms/index/'.$cms_pages_arr_val['page_url'];
                                          if(in_array($cms_pages_arr_val['page_url'],$cms_url_arr)){
                                             $cms_page_url = $cms_pages_arr_val['page_url'];
                                          }?>
									<li>
										<a href="<?php echo $base_url.$cms_page_url;?>"><?php echo $cms_pages_arr_val['page_title']; ?></a>
									</li>
									<?php
                                       }
                                    }?>
									<li>
										<a href="<?php echo $base_url.'blog'; ?>">Blog</a>
									</li>
								</ul>	
							</div>

							<div class="col-md-4 col-xs-12 col-sm-4">
								<div class="footer-title">
									<p class="">Others </p>
									<span></span>    
								</div>
								<ul class="list-unstyled cms-ul margin-top-15">
									<?php if(!$is_login){?>
										<li>
											<a href="<?php echo $base_url;?>register">Register </a>
										</li>
										<li>
											<a href="<?php echo $base_url;?>login">Log In </a>
										</li>
									<?php } ?>
									<li>
										<a href="<?php echo $base_url;?>event">Events </a>
									</li>
									<li>
										<a href="<?php echo $base_url;?>wedding-vendor">Vendor </a>
									</li>
									<li>
										<a href="<?php echo $base_url;?>add-with-us">Advertise With us</a>
									</li>
								</ul>	
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row margin-top-20">				
					<div class="col-md-3 col-sm-12 col-xs-12 m-center">
						<div class="social-icon-footer margin-top-15">
							<?php if(isset($config_data['facebook_link']) && $config_data['facebook_link'] !=''){?><p>
								<a href="<?php if(isset($config_data['facebook_link']) && $config_data['facebook_link'] !=''){ echo $config_data['facebook_link'];} ?>" class="fb">
									<i class="fa fa-facebook" data-toggle="tooltip" data-placement="top" title="Facebook"></i>
								</a>
							</p>
							<?php }if(isset($config_data['twitter_link']) && $config_data['twitter_link'] !=''){?><p>
								<a href="<?php if(isset($config_data['twitter_link']) && $config_data['twitter_link'] !=''){ echo $config_data['twitter_link'];} ?>" class="tw">
									<i class="fab fa-twitter" data-toggle="tooltip" data-placement="top" title="Twitter"></i>
								</a>
							</p>
							<?php }if(isset($config_data['linkedin_link']) && $config_data['linkedin_link'] !=''){?><p>
								<a href="<?php if(isset($config_data['linkedin_link']) && $config_data['linkedin_link'] !=''){ echo $config_data['linkedin_link'];} ?>" class="li"> 
									<i class="fab fa-linkedin" data-toggle="tooltip" data-placement="top" title="LinkedIn"></i>
								</a>
							</p>
							<?php }if(isset($config_data['google_link']) && $config_data['google_link'] !=''){?>
							<p>
								<a href="<?php if(isset($config_data['google_link']) && $config_data['google_link'] !=''){ echo $config_data['google_link'];} ?>" class="tel"> 
									<i class="fab fa-instagram" data-toggle="tooltip" data-placement="top" title="Instagram"></i>
								</a>
							</p>
							<?php }?>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 margin-top-10">
						<div class="row">
							<div class="f-app-icon">
								<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {?>
									<div class="col-md-6 col-sm-6 col-xs-6">
									<a target='_blank' href="<?php if(isset($config_data['android_app_link']) && $config_data['android_app_link'] !='') {echo $config_data['android_app_link'];}?>"><img src="<?php echo $base_url;?>assets/home_2/images/Google-Play-Button.png" alt="Google Play Store"></a>
								</div>
								<?php }?>
							<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {?>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<a target='_blank' href="<?php if(isset($config_data['ios_app_link']) && $config_data['ios_app_link'] !='') {echo $config_data['ios_app_link'];}?>"><img src="<?php echo $base_url;?>assets/home_2/images/App-Store-Button.png" alt="App Store"></a>
								</div>
								<?php }?>
							</div>
						</div>
					</div>			
					<div class="col-md-5 col-sm-12 col-xs-12 text-center margin-top-5">
						<div class="copy-rights">
							<h6>© <?php if(isset($config_data['footer_text']) && $config_data['footer_text'] !=''){ echo $config_data['footer_text'];} ?></h6>
						</div>
					</div>
				
				</div>
			</div>
		</footer>
		
		<!-- =========== Footer End  =========== -->
		
		<div class="progress-wrap">
			<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
			</svg>
		</div>

		<div class="clearfix"></div>
		<!-- loader -->
		<div id="lightbox-panel-mask"></div>
		<div id="lightbox-panel-loader" style="text-align:center;">
			<img alt="Please wait.." title="Please wait.." src="<?php echo $base_url; ?>assets/front_end/images/loading.gif" />
		</div>
		<!-- loader -->
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
		<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />

		<!-- ======= Jquery ======= -->
		<script src="<?php echo $base_url;?>assets/home_2/js/jquery.js?v=<?php echo filemtime('assets/home_2/js/jquery.js') ?>"></script>
		
		<!-- ======= Bootstrap Js ======= -->
		<script src="<?php echo $base_url;?>assets/home_2/js/bootstrap.js?v=<?php echo filemtime('assets/home_2/js/bootstrap.js') ?>"></script>
		<script  src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
		<script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>
		<?php
		if(isset($this->common_model->extra_js_fr) && $this->common_model->extra_js_fr !='' && count($this->common_model->extra_js_fr) > 0){
			$extra_js_fr = $this->common_model->extra_js_fr;
			foreach($extra_js_fr as $extra_js_val){?>
			<script src="<?php echo $base_url.'assets/front_end_new/'.$extra_js_val; ?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_js_val);?>"></script>
			<?php }
		}if (isset($this->extra_js_script) && $this->extra_js_script!='') {
			echo $this->extra_js_script;
		}?>
		<?php include_once("log_reg_menu_script.php");?>
		<script>
			//Mobile Site Animation Disable
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
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
			
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});

		  $(".toggle-password").click(function() {

		  $(this).toggleClass("fa-eye fa-eye-slash");
		  var input = $($(this).attr("toggle"));
		  if (input.attr("type") == "password") {
		    input.attr("type", "text");
		  } else {
		    input.attr("type", "password");
		  }
		});
		</script>

		<script>
		function myFunction() {
		  document.getElementByclass("myPsw").placeholder = "Type your password";
		}
		</script>


		<!--header sticky-->
			<script>
				window.onscroll = function() {myFunction()};
				var header = document.getElementById("StickyHeader");
				var sticky = header.offsetTop;
				function myFunction() {
				  if (window.pageYOffset > sticky) {
				    header.classList.add("sticky");
				  } else {
				    header.classList.remove("sticky");
				  }
				}
			</script>
		<!--header sticky-->
		<!-- Tooltips -->
		<script>
			$(document).ready(function(){
			  $('[data-toggle="tooltip"]').tooltip();   
			});
		</script>
		<!-- Tooltips -->
		<script>
			<?php if(isset($this->common_model->js_extra_code_fr) && $this->common_model->js_extra_code_fr !=''){
				echo $this->common_model->js_extra_code_fr;
			}?>
		</script>
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
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

<!-- cookie popup start -->
<script type="text/javascript">
function cookiesPolicyPrompt(){
  if (Cookies.get('acceptedCookiesPolicy')== "yes"){
    //console.log('accepted policy', chk);
    $("#alertCookiePolicy").hide(); 
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
	</body>
</html>