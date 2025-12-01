<!DOCTYPE html>
<html lang="en">
	<head>
	<?php
	if($this->router->fetch_class()=='home'){
		$url_class = '';
	}else if($this->router->fetch_class()=='cms'){
		$url_class = '';
	}else{
		$url_class = str_ireplace("_","-",$this->router->fetch_class());
	}

	if($this->router->fetch_method()=='index'){
		$url_method = '';
	}else{
		$url_method = '/'.str_ireplace("_","-",$this->router->fetch_method());
	}

	if($this->router->fetch_class()=='success_story' && $this->router->fetch_method()=='details'){
		$page_name = '/'.$this->uri->segment(3);
	}
	else if($this->router->fetch_class()=='event' && $this->router->fetch_method()=='details'){
		$page_name = '/'.$this->uri->segment(3);
	}
	else if($this->router->fetch_class()=='search' && ($this->router->fetch_method()=='quick' || $this->router->fetch_method()=='advance' || $this->router->fetch_method()=='keyword' || $this->router->fetch_method()=='id')){
		$page_name = '/'.$this->uri->segment(3);
	}
	else{
		$page_name = '';
	}
	if($url_class==''){
		$base_uri1 = base_url();
		$base_uri = substr_replace($base_uri1 ,"",-1);
	}
	else{
		$base_uri = base_url();
	}
	if($this->uri->segment(1)=='cms' || $this->uri->segment(1)=='home' || $this->uri->segment(2)=='index'){
		$base_uri = '';
	}
	if($base_uri!=''){?>
		<link rel="canonical" href="<?php echo $base_uri.$url_class.$url_method.$page_name;?>" />
	<?php }?>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="robots" content="index, follow">
		<title><?php  if(isset($seo_title) && $seo_title !=''){ echo $seo_title; }else{ if(isset($page_title) && $page_title !=''){echo $page_title;} else { if(isset($config_data['website_title']) && $config_data['website_title'] !=''){ echo $config_data['website_title'];} } }?></title>
		<meta name="description" content="<?php  if(isset($seo_description) && $seo_description !=''){ echo $seo_description;}else{ if(isset($config_data['website_description']) && $config_data['website_description'] !=''){ echo $config_data['website_description'];} } ?>" />
	<meta name="keyword" content="<?php if(isset($seo_keywords) && $seo_keywords !=''){ echo $seo_keywords;}else{ if(isset($config_data['website_keywords']) && $config_data['website_keywords'] !=''){ echo $config_data['website_keywords'];}}?>" />
	<meta property="og:title" content="<?php if(isset($og_title) && $og_title !=''){ echo $og_title;}else{ if(isset($page_title) && $page_title !=''){ echo $page_title;}else{ if(isset($config_data['website_title']) && $config_data['website_title']!=''){ echo $config_data['website_title'];}}}?>">
	<meta property="og:description" content="<?php if(isset($og_description) && $og_description !=''){ echo $og_description;}else{ if(isset($config_data['website_description']) && $config_data['website_description'] !=''){ echo $config_data['website_description'];} } ?>">
	<meta property="og:image" content="<?php if(isset($og_image) && $og_image !=''){ echo $base_url.'assets/ogimg/'.$og_image;}else{ echo $base_url.'logo/'.$config_data['upload_logo'];}?>">
	
	<?php if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){ ?>
		<link type="image/x-icon" rel="shortcut icon" href="<?php echo $base_url.'assets/logo/'.$config_data['upload_favicon']; ?>" />
	<?php } ?>
		<!-- ====== Bootstrap css ====== -->
		<link rel="stylesheet" href="<?php echo $base_url;?>assets/home_2/css/bootstrap.css?v=<?php echo filemtime('assets/home_2/css/bootstrap.css') ?>">
		<?php if($this->router->fetch_class()!='home'){?>
		    <link href="<?php echo $base_url;?>assets/front_end_new/css/bootstrap.css?ver=<?php echo filemtime('assets/front_end_new/css/bootstrap.css') ?>" rel="stylesheet">
		<?php }?>
		<!-- ====== fontAwsome ====== -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css"
		integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<!-- ====== Main StyleSheet ====== -->
		<link rel="stylesheet" href="<?php echo $base_url;?>assets/home_2/css/style.css?v=<?php echo filemtime('assets/home_2/css/style.css') ?>">
		<!-- ====== Responsiv StyleSheet ====== -->
		<link rel="stylesheet" href="<?php echo $base_url;?>assets/home_2/css/responsive.css?v=<?php echo filemtime('assets/home_2/css/responsive.css') ?>">
		<link rel="stylesheet" href="<?php echo $base_url;?>assets/home_2/css/jquery.mCustomScrollbar.min.css?v=<?php echo filemtime('assets/home_2/css/jquery.mCustomScrollbar.min.css') ?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
		<link href="<?php echo $base_url;?>assets/front_end_new/css/notification_popup.css?ver=<?php echo filemtime('assets/front_end_new/css/notification_popup.css') ?>" rel="stylesheet">
		<?php if($this->router->fetch_class()=='home'){?>
			<link href="<?php echo $base_url;?>assets/home_2/css/mega2.css?ver=<?php echo filemtime('assets/home_2/css/mega2.css');?>" rel="stylesheet">
		<?php }else{?>
			<link href="<?php echo $base_url;?>assets/front_end_new/css/mega.css?ver=<?php echo filemtime('assets/front_end_new/css/mega.css') ?>" rel="stylesheet">
		<?php }?>

		<?php if($this->router->fetch_class()!='home'){?>
		    <!--<link href="<?php echo $base_url;?>assets/front_end_new/css/bootstrap.css?ver=<?php echo filemtime('assets/front_end_new/css/bootstrap.css') ?>" rel="stylesheet">-->
		    <link href="<?php echo $base_url;?>assets/front_end_new/css/style.css?ver=<?php echo filemtime('assets/front_end_new/css/style.css') ?>" rel="stylesheet">
		    <link href="<?php echo $base_url;?>assets/front_end_new/css/responsive.css?ver=<?php echo filemtime('assets/front_end_new/css/responsive.css') ?>" rel="stylesheet">
			<link href="<?php echo $base_url;?>assets/front_end_new/css/mohammad.css?ver=<?php echo filemtime('assets/front_end_new/css/mohammad.css') ?>" rel="stylesheet">
			<?php if($this->router->fetch_class()=='my_dashboard' || $this->router->fetch_class()=='my_profile' || $this->router->fetch_class()=='upload' || $this->router->fetch_class()=='modify_photo' || $this->router->fetch_class()=='matches' || $this->router->fetch_method()=='admin' || $this->router->fetch_method()=='current_plan'){?>
				<link href="<?php echo $base_url;?>assets/front_end_new/css/owl.carousel.css?v=<?php echo filemtime('assets/front_end_new/css/owl.carousel.css')?>" rel="stylesheet">
			<?php }
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
		$is_login = $this->common_front_model->checkLogin('return');
		if(isset($this->common_model->extra_css_fr) && $this->common_model->extra_css_fr !='' && count($this->common_model->extra_css_fr) > 0)
		{
			$extra_css_fr = $this->common_model->extra_css_fr;
			foreach($extra_css_fr as $extra_css_fr_val)
			{
			?>
			<link rel="stylesheet" href="<?php echo $base_url.'assets/front_end_new/'.$extra_css_fr_val; ?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_css_fr_val);?>" />
			<?php }
		}
		$logo_url = $base_url.'assets/home_2/images/logo.png';
		if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !=''){
			$logo_url = $base_url.'assets/logo/'.$config_data['upload_logo'];
		}
		$website_title = 'Welcome to Matrimony';
		if(isset($config_data['website_title']) && $config_data['website_title'] !=''){
			$website_title = substr($config_data['website_title'],0,53);
		}
		if($is_login){
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
				$my_dashboard = 'menu-active cool-link';
			}elseif($class_name_curr == 'matches'){
				$my_match = 'menu-active cool-link';
			}elseif($class_name_curr == 'my_profile' || $class_name_curr == 'message' || $class_name_curr == 'express_interest' || $class_name_curr == 'upload' || $class_name_curr == 'modify_photo' || $class_name_curr == 'express_interest'){
				$my_profile = 'menu-active cool-link';
			}elseif($class_name_curr == 'search'){
				$my_search = 'menu-active cool-link';
			}elseif($class_name_curr == 'change_password'){
				$change_password = 'menu-active cool-link';
			}elseif($class_name_curr == 'premium_member'){
				$premium_member = 'menu-active cool-link';
			}elseif($class_name_curr == 'event'){
				$event = 'menu-active cool-link';
			}elseif($class_name_curr == 'contact'){
				$contact = 'menu-active cool-link';
			}elseif($class_name_curr == 'privacy_setting'){
				$profile_right = 'menu-active cool-link';
			}

			$status='';
			$plan_status = $this->common_front_model->get_session_data('plan_status');
			if(isset($plan_status) && $plan_status!='Not Paid'){
				$status = '<a class="dropdown-item" href="'.$base_url.'premium-member/current-plan">Current Plan</a>';
			}
			$main_menu_str = '
			<ul class="clearfix after-login">
			<li class="'.$my_dashboard.'"><a href="'.$base_url.'">Home</a></li>
			<li class="nav-item dropdown '.$my_profile.'">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Profile <span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="'.$base_url.'my-profile">My Profile</a>
					<a class="dropdown-item" href="'.$base_url.'message">My Messages</a>
					<a class="dropdown-item" href="'.$base_url.'express-interest">My Express Interest</a>
					<a class="dropdown-item" href="'.$base_url.'upload/video">Upload Video</a>
					<a class="dropdown-item" href="'.$base_url.'modify-photo">Upload Photo</a>
					<a class="dropdown-item" href="'.$base_url.'upload/horoscope">Upload Horoscope</a>
					<a class="dropdown-item" href="'.$base_url.'upload/id_proof">Upload ID Proof</a>
				</div>
			</li>
			<li class="'.$my_match.' nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Matches
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown1">
					<a class="dropdown-item" href="'.$base_url.'matches">Recommended Matches</a>
					<a class="dropdown-item" href="'.$base_url.'matches/premium-match">Premium Matches</a>
					<a class="dropdown-item" href="'.$base_url.'matches/near-by-me">Near By Me</a>
					<a class="dropdown-item" href="'.$base_url.'matches/received-match-from-admin">Match of the day</a>
				</div>
			</li>
			<li class="nav-item dropdown '.$my_search.'">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Search
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown2">
					<a class="dropdown-item" href="'.$base_url.'search/quick-search"> Quick Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/advance-search"> Advance Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/keyword-search"> Keyword Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/id-search"> Id Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/saved"> My Saved Searches</a>
				</div>
			</li>
			<li class="'.$premium_member.' nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Membership
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown3">
					<a class="dropdown-item" href="'.$base_url.'premium-member">Payment Options</a>
					'.$status.'
				</div>
			</li>
			<li class="'.$contact.' nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Help?
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown4">
					<a class="dropdown-item" href="'.$base_url.'contact">Contact Us</a>
					<a class="dropdown-item" href="'.$base_url.'contact/admin">Contact To Admin</a>
				</div>
			</li>
			<li class="'.$profile_right.' nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown5" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i style="font-size:21px;" class="fas fa-user-circle"></i>
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown5">
					<a class="dropdown-item" href="'.$base_url.'my-profile"> Edit My Profile</a>
					<a class="dropdown-item" href="'.$base_url.'privacy-setting">My Privacy Setting</a>
					<a class="dropdown-item" href="'.$base_url.'privacy-setting/index/change-password">Change Password</a>
					<a class="dropdown-item" href="'.$base_url.'my-profile/delete_request_to_admin">Delete Profile</a>
					<a class="dropdown-item" href="javascript:updateLocalStorage()">Logout</a>
				</div>
			</li>
			</ul>';

			$member_id = $this->common_front_model->get_user_id('matri_id','matri_id');
			$where_arra=array('message.receiver'=>$member_id,'message.trash_receiver'=>'No','message.status'=>'sent');
			$message_count = $this->common_model->get_count_data_manual('message',$where_arra,0,'');
			$Like_data = $this->common_model->get_count_data_manual('member_likes',array('my_id'=>$member_id,'like_status'=>'Yes'),0,'','','','','','');
			$this->common_model->is_delete_fild = '';
			$view_my_data = $this->common_model->get_count_data_manual('who_viewed_my_profile',array('viewed_member_id'=>$member_id),0,'','',0);
			$my_pro = $base_url.'my-profile';
			$url = "window.location.href='".$my_pro."'";
			$mobile_menu='<!--profile detail-->
               <div class="col-xs-12 col-sm-12  margin-top-20">
					<div class="text-center">
						<img src="'.$photo1.'" class="image-box" alt="">
					</div>
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
				<ul class="list-unstyled components">
					<li><a href="'.$base_url.'my-dashboard">Home</a></li>
					<li class="clearfix"> <a href="#homeSubmenu" data-toggle="collapse"
						aria-expanded="false">Profile<i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="homeSubmenu">
							<li><a href="'.$base_url.'my-profile">View Profile</a></li>
							<li><a href="'.$base_url.'my-profile">Edit Profile</a></li>
							<li><a href="'.$base_url.'message">My Messages</a></li>
							<li><a href="'.$base_url.'express-interest">My Express Interest</a></li>
							<li><a href="'.$base_url.'upload/video">Upload Video</a></li>
							<li><a href="'.$base_url.'modify-photo">Upload Photo</a></li>
							<li><a href="'.$base_url.'upload/horoscope">Upload Horoscope</a></li>
							<li><a href="'.$base_url.'upload/id_proof">Upload ID Proof</a></li>
						</ul>
					</li>
					<li class="clearfix"> <a href="#homeSubmenu121" data-toggle="collapse"
						aria-expanded="false">Activity<i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="homeSubmenu121">
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
					</li>
					<li class="clearfix"> <a href="#homeSubmenu1" data-toggle="collapse"
						aria-expanded="false">Matches<i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="homeSubmenu1">
							<li><a href="'.$base_url.'matches">Recommended Matches</a></li>
							<li><a href="'.$base_url.'matches/premium-match">Premium Matches</a></li>
							<li><a href="'.$base_url.'matches/near-by-me">Near By Me</a></li>
							<li><a href="'.$base_url.'matches/received-match-from-admin">Match of the day</a></li>
						</ul>
					</li>
					<li class="clearfix"> <a href="#homeSubmenu2" data-toggle="collapse"
						aria-expanded="false">Search<i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="homeSubmenu2">
							<li><a href="'.$base_url.'search/quick-search"> Quick Search</a></li>
							<li><a href="'.$base_url.'search/advance-search"> Advance Search</a></li>
							<li><a href="'.$base_url.'search/keyword-search"> Keyword Search</a></li>
							<li><a href="'.$base_url.'search/id-search"> Id Search</a></li>
							<li><a href="'.$base_url.'search/saved"> My Saved Searches</a></li>
						</ul>
					</li>
					<li class="clearfix"> <a href="#up-garde" data-toggle="collapse"
						aria-expanded="false"> Membership <i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="up-garde">
							<li><a href="'.$base_url.'premium-member">Payment Options</a></li>
							'.$status.'
						</ul>
					</li>
					<li class="clearfix"> <a href="#Help" data-toggle="collapse"
						aria-expanded="false"> Help? <i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="Help">
							<li><a href="'.$base_url.'contact">Contact Us</a></li>
							<li><a href="'.$base_url.'contact/admin">Contact To Admin</a></li>
						</ul>
					</li>
					<li class="clearfix"> <a href="#user" data-toggle="collapse"
						aria-expanded="false"> User <i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="user">
							<li><a href="'.$base_url.'privacy-setting">My Privacy Setting</a></li>
							<li><a href="'.$base_url.'privacy-setting/index/change-password">Change Password</a></li>
							<li><a href="'.$base_url.'my-profile/delete_request_to_admin">Delete Profile</a></li>
							<li><a href="javascript:updateLocalStorage()">Logout</a></li>
						</ul>
					</li>
				</ul>
			';
		}else{
			$home = $cms = $my_search = $register = $premium_member = $contact =  $success_story = '';
			$class_name_curr = $this->common_model->class_name;
			if($class_name_curr == 'home'){
				$home = 'menu-active cool-link';
			}elseif($class_name_curr == 'cms'){
				$cms = 'menu-active cool-link';
			}elseif($class_name_curr == 'search'){
				$my_search = 'menu-active cool-link';
			}elseif($class_name_curr == 'register'){
				$register = 'menu-active cool-link';
			}elseif($class_name_curr == 'premium_member'){
				$premium_member = 'menu-active cool-link';
			}elseif($class_name_curr == 'contact'){
				$contact = 'menu-active cool-link';
			}elseif($class_name_curr == 'success_story'){
				$success_story = 'menu-active cool-link';
			}
			$main_menu_str = '
			<ul class="clearfix">
			<li class="'.$home.'"><a href="'.$base_url.'">Home</a></li>
			<li class="nav-item dropdown '.$my_search.'">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown6" role="button"
				data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Search
					<span class="caret"></span>
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown6">
					<a class="dropdown-item" href="'.$base_url.'search/quick-search"> Quick Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/advance-search"> Advance Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/keyword-search"> Keyword Search</a>
					<a class="dropdown-item" href="'.$base_url.'search/id-search"> Id Search</a>
				</div>
			</li>
			<li class="'.$premium_member.'"><a href="'.$base_url.'premium-member"> Membership</a></li>
			<li class="'.$success_story.'"><a href="'.$base_url.'success-story"> Success Stories</a></li>
			<li class="'.$contact.'"><a href="'.$base_url.'contact"> Contact Us</a></li>
			<li><a href="'.$base_url.'register" class="last-child-menu"> Register</a></li>
			<li><a href="'.$base_url.'login" class="last-child-menu"> <i class="fas fa-sign-in-alt"></i> Log In</a></li>
			</ul>
			';

			$mobile_menu='
				<ul class="list-unstyled components">
					<li><a href="'.$base_url.'home">Home</a></li>
					<li><a href="'.$base_url.'register">Register Now</a></li>
					<li class="clearfix"> <a href="#homeSubmenu" data-toggle="collapse"
						aria-expanded="false">Search<i class="fas fa-angle-down"></i></a>
						<ul class="collapse list-unstyled ul-li-bg" id="homeSubmenu">
							<li><a href="'.$base_url.'search/quick-search"> Quick Search</a></li>
							<li><a href="'.$base_url.'search/advance-search"> Advance Search</a></li>
							<li><a href="'.$base_url.'search/keyword-search"> Keyword Search</a></li>
							<li><a href="'.$base_url.'search/id-search"> Id Search</a></li>
						</ul>
					</li>
					<li><a href="'.$base_url.'premium-member">Membership</a></li>
					<li><a href="'.$base_url.'contact">Contact Us</a></li>
					<li><a href="'.$base_url.'login">Log In</a></li>
				</ul>
			';
		}?>
		<style>
			<?php if(isset($this->common_model->css_extra_code_fr) && $this->common_model->css_extra_code_fr !=''){
				echo $this->common_model->css_extra_code_fr;
			}?>
		</style>
	</head>
	<body class="<?php echo $body_class; ?>" style="<?php echo $back_img;?>">
		<div class="_banner">
			<!-- ====== Nav Bar ====== -->
			<div class="menu-position">
				<!-- ======- Desktop Menu bar ====== -->
			
				<div class="_navBarMani hidden-sm hidden-xs <?php if($this->router->fetch_class()=='home'){if(isset($config_data["full_width_banner"]) && $config_data["full_width_banner"]=='Yes'){ echo 'transparent-menu';}}?>" id="StickyHeader">   <!-- add "transparent-menu" class for tarnsparent header -->

					<div class="container-fluid cust_padding">
						<nav class="clearfix">
							<div class="_logo">
								<a href="<?php echo $base_url;?>">
									<img src="<?php echo $logo_url;?>" alt="Logo">
								</a>
							</div>
							<div class="_hamburge">
								<?php echo $main_menu_str;?>
							</div>
						</nav>
					</div>
				</div>

				<!-- ======- Desktop Menu bar Ends ====== -->
				
				<!-- ====== Mobile Menu bar Start ====== -->
				<div class="MobileMenu hidden-lg  hidden-md clearfix ps-Sticky">
					<div class="_MobileMenuLogo">
						<a href="<?php echo $base_url;?>">
							<img src="<?php echo $logo_url;?>" alt="mobileLogo">
						</a>
					</div>
					<div class="_menuOpenMobile">
						<nav id="sidebar">
							<div id="dismiss">
								<i class="fas fa-times"></i>
							</div>
							<?php echo $mobile_menu;?>
						</nav>
						<button type="button" id="sidebarCollapse" class="newHamburge">
						<i class="fas fa-bars"></i></button>
					</div>
				</div>
			</div>
		</div>
		