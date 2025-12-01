<?php $ver_cont = '1.999999';?>
<!doctype html>
<html lang="en">
   <head>
   		<?php
	if($this->router->fetch_class()=='home')
	{
		$url_class = '';
	}
	else if($this->router->fetch_class()=='cms')
	{
		$url_class = '';
	}
	else
	{
		$url_class = str_ireplace("_","-",$this->router->fetch_class());
	}

	if($this->router->fetch_method()=='index')
	{
		$url_method = '';
	}
	else
	{
		$url_method = '/'.str_ireplace("_","-",$this->router->fetch_method());
	}

	if($this->router->fetch_class()=='success_story' && $this->router->fetch_method()=='details')
	{
		$page_name = '/'.$this->uri->segment(3);
	}
	else if($this->router->fetch_class()=='event' && $this->router->fetch_method()=='details')
	{
		$page_name = '/'.$this->uri->segment(3);
	}
	else if($this->router->fetch_class()=='search' && ($this->router->fetch_method()=='quick' || $this->router->fetch_method()=='advance' || $this->router->fetch_method()=='keyword' || $this->router->fetch_method()=='id'))
	{
		$page_name = '/'.$this->uri->segment(3);
	}
	else
	{
		$page_name = '';
	}
	if($url_class=='')
	{
		$base_uri1 = base_url();
		$base_uri = substr_replace($base_uri1 ,"",-1);
	}
	else
	{
		$base_uri = base_url();
	}
	if($this->uri->segment(1)=='cms' || $this->uri->segment(1)=='home' || $this->uri->segment(2)=='index')
	{
		$base_uri = '';
	}
	if($base_uri!='')
	{?><link rel="canonical" href="<?php echo $base_uri.$url_class.$url_method.$page_name;?>" /><?php	}?>

   
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
    <title><?php  if(isset($seo_title) && $seo_title !=''){ echo $seo_title; }else{ if(isset($page_title) && $page_title !=''){echo $page_title;} else { if(isset($config_data['website_title']) && $config_data['website_title'] !=''){ echo $config_data['website_title'];} } }?></title>
	<meta name="description" content="<?php  if(isset($seo_description) && $seo_description !=''){ echo $seo_description;}else{ if(isset($config_data['website_description']) && $config_data['website_description'] !=''){ echo $config_data['website_description'];} } ?>" />
	<meta name="keyword" content="<?php if(isset($seo_keywords) && $seo_keywords !=''){ echo $seo_keywords;}else{ if(isset($config_data['website_keywords']) && $config_data['website_keywords'] !=''){ echo $config_data['website_keywords'];} } ?>" />
	<meta property="og:title" content="<?php if(isset($og_title) && $og_title !='')
	{ echo $og_title; 
	}else
	{ 
if(isset($page_title) && $page_title !='')
{
	echo $page_title;}
	else {
		if(isset($config_data['website_title']) && $config_data['website_title'] !='')
	{ 
echo $config_data['website_title'];} } }?>">
	<meta property="og:description" content="<?php if(isset($og_description) && $og_description !=''){ echo $og_description;}else{ if(isset($config_data['website_description']) && $config_data['website_description'] !=''){ echo $config_data['website_description'];} } ?>">
	<meta property="og:image" content="<?php if(isset($og_image) && $og_image !=''){ echo $base_url.'assets/ogimg/'.$og_image;}else{ echo $base_url.'logo/'.$config_data['upload_logo'];}?>">
	
	<?php if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){ ?>
		<link type="image/x-icon" rel="shortcut icon" href="<?php echo $base_url.'assets/logo/'.$config_data['upload_favicon']; ?>" />
	<?php } ?>
	<link href="<?php echo $base_url;?>assets/front_end_new/css/mega.css?ver=<?php echo filemtime('assets/front_end_new/css/mega.css') ?>" rel="stylesheet">
    <link href="<?php echo $base_url;?>assets/front_end_new/css/bootstrap.css?ver=<?php echo filemtime('assets/front_end_new/css/bootstrap.css') ?>" rel="stylesheet">
    <link href="<?php echo $base_url;?>assets/front_end_new/css/style.css?ver=<?php echo filemtime('assets/front_end_new/css/style.css') ?>" rel="stylesheet">
    <link href="<?php echo $base_url;?>assets/front_end_new/css/responsive.css?ver=<?php echo filemtime('assets/front_end_new/css/responsive.css') ?>" rel="stylesheet">
	<link href="<?php echo $base_url;?>assets/front_end_new/css/mohammad.css?ver=<?php echo filemtime('assets/front_end_new/css/mohammad.css') ?>" rel="stylesheet">
	<link href="<?php echo $base_url;?>assets/front_end_new/css/notification_popup.css?ver=<?php echo filemtime('assets/front_end_new/css/notification_popup.css') ?>" rel="stylesheet">
	<?php if($this->router->fetch_class()=='my_dashboard' || $this->router->fetch_class()=='my_profile' || $this->router->fetch_class()=='upload' || $this->router->fetch_class()=='modify_photo' || $this->router->fetch_class()=='matches' || $this->router->fetch_method()=='admin' || $this->router->fetch_method()=='current_plan'){?>
	<link href="<?php echo $base_url;?>assets/front_end_new/css/owl.carousel.css?ver=<?php echo filemtime('assets/front_end_new/css/owl.carousel.css') ?>" rel="stylesheet">
	<?php }?>
	<style type="text/css">
 	  nav #navbar2{position:inherit};
	</style>
    <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <!--<link href="https://use.fontawesome.com/releases/v5.0.1/css/all.css" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" rel="stylesheet">-->
    <?php 
		$is_login = $this->common_front_model->checkLogin('return');
		if(isset($this->common_model->extra_css_fr) && $this->common_model->extra_css_fr !='' && count($this->common_model->extra_css_fr) > 0)
		{
			$extra_css_fr = $this->common_model->extra_css_fr;
			foreach($extra_css_fr as $extra_css_fr_val)
			{
			?>
			<link rel="stylesheet" href="<?php echo $base_url.'assets/front_end_new/'.$extra_css_fr_val; ?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_css_fr_val);?>" />
			<?php
			}
		}
		$body_class = 'overflow-x-h';
		$back_img = "background: url('".$base_url."assets/front_end_new/images/site-back-img.png');background-color: whitesmoke;";
		if(isset($this->common_model->is_body_class) && $this->common_model->is_body_class !='' && $this->common_model->is_body_class =='Yes')
		{
			$body_class = 'login-reg-main overflow-x-h';
			$back_img = '';
		}
		if(isset($this->common_model->is_body1_class) && $this->common_model->is_body1_class !='' && $this->common_model->is_body1_class =='Yes')
		{
			$body_class = 'body-banner1';
			$back_img = '';
		}
		$is_home_page = '';
		if(isset($this->common_model->is_home_page) && $this->common_model->is_home_page !='' && $this->common_model->is_home_page =='Yes')
		{
			$is_home_page = 'Yes';
			$back_img = '';
		}
		$logo_url = 'front_end/images/logo/logo-3.png';
		if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !='')
		{
			$logo_url = 'logo/'.$config_data['upload_logo'];
		}
		$website_title = 'Welcome to Matrimony';
		if(isset($config_data['website_title']) && $config_data['website_title'] !='')
		{
			$website_title = substr($config_data['website_title'],0,53);
		}
		if($is_login)
		{
			?>
			
			<?php
			$before_login_top_menu = '
		
			<li><a href="'.$base_url.'about-us" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-info-circle mi-icon"></i> About us</a></li>
			<li><a href="'.$base_url.'wedding-vendor" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-users mi-icon"></i> Vendor</a></li>
			<li><a href="'.$base_url.'event" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fas fa-calendar mi-icon"></i> Events</a></li>';
			//$data = $this->common_front_model->get_session_data();
			//print_r($data);
			
			$user_name = $this->common_front_model->get_session_data('username');
			$firstname = $this->common_front_model->get_session_data('firstname');
			$photo1 = $this->common_front_model->get_session_data('photo1');
			$matri_id = $this->common_front_model->get_session_data('matri_id');
			$curre_id = $this->common_front_model->get_session_data('id');
			$percentage_stored = $this->common_front_model->getprofile_completeness($curre_id);
			if(strlen($user_name) > 10)
			{
				$user_name = substr($user_name,0,10).'..';
			}
			$my_home = $my_match = $my_profile = $my_search = $change_password = $my_dashboard = $premium_member = $event = $contact = $profile_right = '';
			
			$class_name_curr = $this->common_model->class_name;
			
			if($class_name_curr == 'my_dashboard'){
				$my_dashboard = 'active';
				}elseif($class_name_curr == 'matches'){
				$my_match = 'active';
				}elseif($class_name_curr == 'my_profile' || $class_name_curr == 'message' || $class_name_curr == 'express_interest' || $class_name_curr == 'upload' || $class_name_curr == 'modify_photo' || $class_name_curr == 'express_interest'){
				$my_profile = 'active';
				}elseif($class_name_curr == 'search'){
				$my_search = 'active';
				}elseif($class_name_curr == 'change_password'){
				$change_password = 'active';
				}elseif($class_name_curr == 'premium_member'){
				$premium_member = 'active';
				}elseif($class_name_curr == 'event'){
				$event = 'active';
				}elseif($class_name_curr == 'contact'){
				$contact = 'active';
				}elseif($class_name_curr == 'privacy_setting'){
					$profile_right = 'active';
				}
			$status='';
			$plan_status = $this->common_front_model->get_session_data('plan_status');
			if(isset($plan_status) && $plan_status!='Not Paid'){
				$status = '<li><a href="'.$base_url.'premium-member/current-plan">Current Plan</a></li>';
			}
			$main_menu_str = '
			<li class="'.$my_dashboard.' color-f Poppins-Medium f-15 mega-category"><a class="color-f text-uppercase" href="'.$base_url.'my-dashboard">Home</a></li>
			<li class="'.$my_profile.' dropdown color-f Poppins-Medium f-15 mega-nd mega-category">
			<a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Profile&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'my-profile">My Profile</a></li>
			
			<li><a href="'.$base_url.'message">My Messages</a></li>
			<li><a href="'.$base_url.'express-interest">My Express Interest</a></li>
			<li><a href="'.$base_url.'upload/video">Upload Video</a></li>
			<li><a href="'.$base_url.'modify-photo">Upload Photo</a></li>
			<li><a href="'.$base_url.'upload/horoscope">Upload Horoscope</a></li>
			<li><a href="'.$base_url.'upload/id_proof">Upload ID Proof</a></li>
			</ul>
			</li>
			<li class="'.$my_match.' dropdown color-f Poppins-Medium f-15 mega-category"><a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Matches&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'matches">Matches</a></li>
			<li><a href="'.$base_url.'matches/received-match-from-admin">Recommended Match</a></li>
			</ul>
			</li>
			<li class="'.$my_search.' dropdown color-f Poppins-Medium f-15 mega-nd mega-category"><a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Search&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'search/quick-search"> Quick Search</a></li>
					<li><a href="'.$base_url.'search/advance-search"> Advance Search</a></li>
					<li><a href="'.$base_url.'search/keyword-search"> Keyword Search</a></li>
					<li><a href="'.$base_url.'search/id-search"> Id Search</a></li>
					<li><a href="'.$base_url.'search/saved"> My Saved Searches</a></li>
			</ul>
			</li>
			<li class="dropdown color-f Poppins-Medium f-15 mega-nd mega-category '.$premium_member.'"><a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Membership&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'premium-member">Payment Options</a></li>
			'.$status.'
			</ul>
			</li>
			<li class="color-f Poppins-Medium f-15 mega-category '.$event.'"><a href="'.$base_url.'event" class="color-f text-uppercase">Event</a></li>

			<li class="dropdown color-f Poppins-Medium f-15 mega-nd mega-category '.$contact.'"><a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Help?&nbsp;<span class="caret"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'contact">Contact Us</a></li>
			<li><a href="'.$base_url.'contact/admin">Contact To Admin</a></li>
			</ul>
			</li>
			<li class="dropdown color-f Poppins-Medium f-15 mega-nd mega-category '.$profile_right.'"><a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fas fa-user-circle f-22"></i><span class="caret" style="position:relative;top: -5px;"></span></a>
			<ul class="dropdown-menu mega-n-dropdown">
			<li><a href="'.$base_url.'my-profile"> Edit My Profile</a></li>
			<li class="">
			<a href="'.$base_url.'privacy-setting">
			My Privacy Setting
			</a>
			</li>
			<li class="">
			<a href="'.$base_url.'privacy-setting/index/change-password">
			Change Password
			</a>
			</li>
			<li>
			<a href="'.$base_url.'my-profile/delete_request_to_admin">
			Delete Profile
			</a>
			</li>
			<li class="">
			<a href="javascript:updateLocalStorage()">
			Logout
			</a>
			</li>
			</ul>
			</li>
			';
			$member_id = $this->common_front_model->get_user_id('matri_id','matri_id');
			$my_pro = $base_url.'my-profile';
			$url = "window.location.href='".$my_pro."'";
			$mobile_menu='
			
                  <!--profile detail-->
                <!--onclick="edit_profile()"-->
                <div class="col-xs-12 col-sm-12  margin-top-20">
					<div class="text-center">
						<img src="'.$photo1.'" class="image-box" alt="">
					</div>
					<!-- <img src="images/camera-icon-2.png" class="image-box-2" alt=""/> -->
					<div class="text-center">
						<button type="button" onclick="'.$url.'" class="btn btn-join Poppins-Medium f-16 color-f"> My Profile</button>
					</div>
					<div class="progressbar-title red">
						<div class="progress">
							<div class="progress-bar" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="'.$percentage_stored.'" style="width: '.$percentage_stored.'%;"></div>
						</div>
						<span class="progressbar-value Poppins-Regular f-13 color-f dshbrd_progree_lable dshbrd_per1"> <span class="Poppins-Semi-Bold f-14 dshbrd_per2">'.$percentage_stored.'</span> % Completed Profile</span>
					</div>
					<p class="text-center Poppins-Regular f-14 color-31 pro_text_m">Update full profile to best matches</p>
					<p class="text-center color-d Poppins-Medium pt-3"> '.$firstname.'<span class="color-31 Poppins-Regular ml4">('.$matri_id.')</span></p>
            	</div>
				<hr class="pro_m_hr">
			
				
                <!--end profile detail-->
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a href="'.$base_url.'my-dashboard">Home</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
							Profile
						</a>
					</h4>
				</div>
				<div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<ul class="nav">
						<li><a href="'.$base_url.'my-profile">View Profile</a></li>
						<li><a href="'.$base_url.'my-profile">Edit Profile</a></li>
						<li><a href="'.$base_url.'message">My Messages</a></li>
						<li><a href="'.$base_url.'express-interest">My Express Interest</a></li>
						<li><a href="'.$base_url.'upload/video">Upload Video</a></li>
						<li><a href="'.$base_url.'modify-photo">Upload Photo</a></li>
						<li><a href="'.$base_url.'upload/horoscope">Upload Horoscope</a></li>
						<li><a href="'.$base_url.'upload/id_proof">Upload ID Proof</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingOne">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse121" aria-expanded="false" aria-controls="collapse121">
							Activity
						</a>
					</h4>
				</div>
				<div id="collapse121" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					<ul class="nav">
						<li><a href="'.$base_url.'express-interest">My Express Interest</a></li>
						<li><a href="'.$base_url.'message">My Messages</a></li>
						<li><a href="'.$base_url.'my-profile/i-viewed">I Viewed Profile</a></li>
						<li><a href="'.$base_url.'my-profile/who-viewed">Viewed My Profile</a></li>
						<li><a href="'.$base_url.'my-profile/i-contacted">I Viewed Contact</a></li>
						<li><a href="'.$base_url.'my-profile/who-contacted">Viewed My Contact</a></li>
						<li><a href="'.$base_url.'my-profile/short-listed">Short Listed Profile</a></li>
						<li><a href="'.$base_url.'my-profile/block-listed">Blocked Profile</a></li>
						<li><a href="'.$base_url.'my-profile/photo-pass-request-received">Photo Request Received</a></li>
						<li><a href="'.$base_url.'my-profile/photo-pass-request-sent">Photo Request Sent</a></li>
						<li><a href="'.$base_url.'my-profile/like-profile">Like Profile</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingtwo">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapsem" aria-expanded="false" aria-controls="collapse2">
						Matches
						</a>
					</h4>
				</div>
				<div id="collapsem" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwo">
					<ul class="nav">
						<li><a href="'.$base_url.'matches">Matches</a></li>
						<li><a href="'.$base_url.'matches/received-match-from-admin">Recommended Match</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingthree">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
							Search
						</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingthree">
					<ul class="nav">
						<li><a href="'.$base_url.'search/quick-search"> Quick Search</a></li>
					<li><a href="'.$base_url.'search/advance-search"> Advance Search</a></li>
					<li><a href="'.$base_url.'search/keyword-search"> Keyword Search</a></li>
					<li><a href="'.$base_url.'search/id-search"> Id Search</a></li>
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingfour">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
							Membership
						</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfour">
					<ul class="nav">
						<li><a href="'.$base_url.'premium-member">Payment Options</a></li>
						'.$status.'
					</ul>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingfive">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
							Help? 
						</a>
					</h4>
				</div>
				<div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingfive">
					<ul class="nav">
						<li><a href="'.$base_url.'contact">Contact Us</a></li>
						<li><a href="'.$base_url.'contact/admin">Contact To Admin</a></li>
					</ul>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingTwo">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne-2" aria-expanded="false" aria-controls="collapseOne-2">
							User 
						</a>
					</h4>
				</div>
				<div id="collapseOne-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
					<ul class="nav">
						<!--<li>
							<a href="'.$base_url.'my-profile"> Edit My Profile</a>
						</li>-->
						<li>
							<a href="'.$base_url.'privacy-setting">My Privacy Setting</a>
						</li>
						<li>
							<a href="'.$base_url.'privacy-setting/index/change-password">Change Password</a>
						</li>
						<li>
							<a href="'.$base_url.'my-profile/delete_request_to_admin">Delete Profile</a>
						</li>
						<li>
							<a href="javascript:updateLocalStorage()">Logout</a>
						</li>
					</ul>
				</div>
			</div>';
		}
		else
		{
			
			$home = $cms = $my_search = $register = $premium_member = $contact =  $success_story = '';
			
			$class_name_curr = $this->common_model->class_name;
			
			if($class_name_curr == 'home'){
				$home = 'active';
				}elseif($class_name_curr == 'cms'){
				$cms = 'active';
				}elseif($class_name_curr == 'search'){
				$my_search = 'active';
				}elseif($class_name_curr == 'register'){
				$register = 'active';
				}elseif($class_name_curr == 'premium_member'){
				$premium_member = 'active';
				}elseif($class_name_curr == 'contact'){
				$contact = 'active';
				}elseif($class_name_curr == 'success_story'){
				$success_story = 'active';
			}
			
			// <li><a href="'.$base_url.'cms/faq" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-question-circle mi-icon"></i> FAQ </a></li>
			$before_login_top_menu = '
			
			<li><a href="'.$base_url.'about-us" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-info-circle mi-icon"></i> About us</a></li>
			<li><a href="'.$base_url.'wedding-vendor" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-users mi-icon"></i> Vendor</a></li>
			<li><a href="'.$base_url.'event" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fas fa-calendar mi-icon"></i> Events</a></li>
			<li><a href="'.$base_url.'login" class="color-f Poppins-Semi-Bold f-12 top-menu-a"><i class="fa fa-sign-in mi-icon"></i> Log in</a></li>';
			
			$main_menu_str = '
			<li class="color-f Poppins-Medium f-15 mega-category '.$home.'"><a href="'.$base_url.'" class="color-f text-uppercase"> Home</a></li>
			<li class="color-f Poppins-Medium f-15 mega-category '.$register.'"><a href="'.$base_url.'register" class="color-f text-uppercase">Register Now</a></li>
			<li class="dropdown color-f Poppins-Medium f-15 mega-nd mega-category '.$my_search.'">
				<a href="javascript:;" class="dropdown-toggle color-f text-uppercase" data-toggle="dropdown" role="button" aria-expanded="false">Search&nbsp;<span class="caret"></span></a>
				<ul class="dropdown-menu mega-n-dropdown" role="menu">
					<li><a href="'.$base_url.'search/quick-search"> Quick Search</a></li>
					<li><a href="'.$base_url.'search/advance-search"> Advance Search</a></li>
					<li><a href="'.$base_url.'search/keyword-search"> Keyword Search</a></li>
					<li><a href="'.$base_url.'search/id-search"> Id Search</a></li>
					
				</ul>
			</li>
			
			<li class="color-f Poppins-Medium f-15 mega-category '.$premium_member.'"><a href="'.$base_url.'premium-member" class="color-f text-uppercase">MEMBERSHIP</a></li>

			<li class="color-f Poppins-Medium f-15 mega-category '.$success_story.'"><a href="'.$base_url.'success-story" class="color-f text-uppercase">Success Story</a></li>
			<li class="color-f Poppins-Medium f-15 mega-category '.$contact.'"><a href="'.$base_url.'contact" class="color-f text-uppercase">Contact Us</a></li>
			';
			$mobile_menu='
			<div class="panel panel-default active">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a href="'.$base_url.'">Home</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a href="'.$base_url.'register">Register Now</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingsix">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordionMenu" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							Search
						</a>
					</h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingsix">
					<ul class="nav">
						<li><a href="'.$base_url.'search/quick-search">Quick Search</a></li>
						<li><a href="'.$base_url.'search/advance-search">Advance Search</a></li>
						<li><a href="'.$base_url.'search/keyword-search">Keyword Search</a></li>
						<li><a href="'.$base_url.'search/id-search">Id Search</a></li>
					</ul>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a rel="nofollow" href="'.$base_url.'premium-member">Membership</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a rel="nofollow" href="'.$base_url.'success-story">Success Stories</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a rel="nofollow" href="'.$base_url.'contact">Contact Us</a>
					</h4>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" >
					<h4 class="panel-title">
						<a href="'.$base_url.'login">Login</a>
					</h4>
				</div>
			</div>';
		}
		
		$top_menu_str = '<div class="container">
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="row">
						<div class="col-md-4 col-sm-4 hidden-xs">
						<p class="Poppins-Medium f-12 color-f topbar-c1">'.$website_title.'</p>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="topbar-menu">
								<ul>
								'.$before_login_top_menu.'
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>';			
		$top_secound_menu_str = '
				<div class="navbar-header">
					<a class="navbar-brand mega-brand-logo hidden-xs" href="'.$base_url.'"><img src="'.$base_url.'assets/'.$logo_url.'" alt="'.$website_title.'" class="mega-n-img cstm-logo img-responsive">
					</a>
					<a class="navbar-brand mega-r  hidden-lg hidden-md hidden-sm hidden-xs" href="'.$base_url.'"><img src="'.$base_url.'assets/'.$logo_url.'" alt="'.$website_title.'" class="mega-r-logo img-responsive">
					</a>
				</div>
				
				<div id="navbar2" class="navbar-collapse collapse mega-n-bg">
					<ul class="nav navbar-nav navbar-right mega-n-ul">'.$main_menu_str.'</ul>
				</div>
		';
		$display_top_menu_perm = 1;
		if(isset($this->common_model->display_top_menu_perm) && $this->common_model->display_top_menu_perm !='' && $this->common_model->display_top_menu_perm =='No')
		{
			$display_top_menu_perm = 0;
		}		
		
		if(isset($this->common_model->class_name) && $this->common_model->class_name=='home')
		{
			//for home page banner
			$home_banner = $this->common_model->get_count_data_manual('homepage_banner',array('status'=>'APPROVED'),2,'banner','rand()',1,1);
			if(isset($home_banner) && $home_banner !='' && is_array($home_banner) && count($home_banner) > 0)
			{
				$path_banner = $this->common_model->path_banner;
				foreach($home_banner as $home_banner_val)
				{
					if(isset($home_banner_val['banner']) && $home_banner_val['banner'] !='' && file_exists($path_banner.$home_banner_val['banner']))
					{
						$banner_url = $base_url.$path_banner.$home_banner_val['banner'];
					}
					else
					{
						continue;
					}
			?>
			<style>.home-header {background-image: url(<?php echo $banner_url; ?>);}</style>
			
			<?php
				}
			}
			else
			{
			?>
			<div class="item slider-shade"><img src="<?php echo $base_url; ?>assets/front_end/images/slider/slider-15.jpg" class="lazyload banner-home-1" alt="Wedding"></div>
			<?php
			}
			
			$home_back_img='home-header';
			$home_text='<div class="col-md-12 col-sm-12 hidden-xs">
				<div class="row">
					<div class="mega-n-text text-center">
						<h1 class="mega-n1 calibri-Bold-font color-f">'.$config_data["homepage_banner_text"].'</h1>
						<p class="mega-n2 f-20 color-f calibri-regular-font">'.$config_data['homepage_banner_description'].'</p>
					</div>
				</div>
			</div>';
			$st = "";
		}
		else if($this->router->fetch_class()=='register' || $this->router->fetch_class()=='login')
		{
			$home_back_img='';
			$home_text='';
			$st = 'style="background:none;height:auto;"';
		}
		else
		{
			$home_back_img='';
			$home_text='';
			$st = 'style="background:#FFF;height:66px;"';
		}
	?>
	<style>
	<?php
	if(isset($this->common_model->css_extra_code_fr) && $this->common_model->css_extra_code_fr !='')
	{
		echo $this->common_model->css_extra_code_fr;
	}
	
?>
</style>
   </head>
   <body class="bg-grey-color <?php echo $body_class; ?>"  style="<?php echo $back_img;?>">
      <div id="wrapper-id">
        <!--Header Start-->
        <div class="header-top bevelBox hidden-xs">
			<?php echo $top_menu_str;?>
		</div>
	
		<div id="wrapper">
			<div class="mega-n-header <?php echo $home_back_img;?>" <?php echo $st;?>>
				<div>
					<div class="col-md-12 col-sm-12 col-xs-12 hidden-sm hidden-xs"> <!--d-none-tab -->
						<div class="example2">
							<nav class="navbar navbar-default mega-n-nav">
								<?php echo $top_secound_menu_str;?>
							</nav>
						</div>
					</div>
					<!--DeskTop Menu End -->
					<!--Mobile Site Menu Starts-->
					<nav class="navbar navbar-default navbar-fixed-top hidden-lg hidden-md" >
                        <a href="#menu-toggle" class="btn btn-primary pull-left new-togel" id="menu-toggle"><i class="fa fa-navicon"></i></a>
                        <a class="navbar-brand navbar-brand-logo" href="<?php echo $base_url;?>" style="padding-top:15px">
                            <img src="<?php echo $base_url.'assets/'.$logo_url;?>" alt="<?php echo $website_title;?>" class="img-responsive">
                            
                        </a>
					</nav>
					<div id="sidebar-wrapper">
						<div class="sidebar-nav">
							<div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
								<div class="panel panel-default">
									<?php echo $mobile_menu;?>
								</div>
							</div>
							
						</div>
					</div>
					<!--Mobile Site Menu Ends -->
				</div>
				<?php echo $home_text;?>
			</div>
		</div>
        