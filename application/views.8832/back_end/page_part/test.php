<?php $user_type = 'admin';
$this->common_model->checkLogin();
$user_daat = $this->common_model->get_session_data();
if(isset($user_daat['user_type']) && $user_daat['user_type'] !='')
{
	$user_type = $user_daat['user_type'];
}
$class_name = $this->router->fetch_class();
?>
<!DOCTYPE html>
<html class=no-js>
<head>
	<meta charset="utf-8" />
	<title><?php if(isset($page_title) && $page_title !=''){ echo $page_title;} ?></title>
	<meta name="description" content="" />
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
	<meta name="viewport" content="width=device-width" />
	<?php if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){ ?>
		<link rel="shortcut icon" href="<?php echo $base_url.'assets/logo/'.$config_data['upload_favicon']; ?>" />
	<?php } ?>
	<link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/styles/app.min.df5e9cc9.css?ver=1" />
	<?php if(isset($page_title) && $page_title =='Dashboard'){ ?>
	<link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/styles/climacons-font.249593b4.css" />
	<link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/vendor/rickshaw/rickshaw.min.css" />

	<?php }?>
	    <link rel="stylesheet" href="<?php echo $base_url; ?>assets/back_end/styles/style.css" />
	<?php if(isset($this->common_model->extra_css) && $this->common_model->extra_css !='' && count($this->common_model->extra_css) > 0)
	{
		$extra_css = $this->common_model->extra_css;
		$extra_css = array_unique($extra_css);
		foreach($extra_css as $extra_css_val)
		{
	?>
	    <link rel="stylesheet" href="<?php echo $base_url.'assets/back_end/'.$extra_css_val; ?>" />
	<?php
		}
	}
	if(strtolower(trim($class_name)) =='approval')
	{
	?>
    <!--<link rel="stylesheet" href="<?php //echo $base_url.'assets/front_end/css/canvasCrop.css'; ?>" />-->
    <?php
	}

	$username_dip = 'Admin';
	$user_login_url = 'login';
	if(isset($user_daat['username']) && $user_daat['username'] !='')
	{
		$username_dip = $user_daat['username'];
	}
	else if(isset($user_daat['name']) && $user_daat['name'] !='')
	{
		$username_dip = $user_daat['name'];
	}
	if(isset($user_daat['user_type']) && $user_daat['user_type'] !='' && $user_daat['user_type'] !='admin')
	{
		$user_login_url = $user_daat['user_type'];
	}
?>
</head>
<style>
.margin-top-20px-t{
	margin-top:20px;
}
.select2-container{ width: 100% !important; }
</style>
<body>
	<div class="app layout-fixed-header">
		<div class="sidebar-panel offscreen-left">
	    	<div class="brand">
	      		<div class="brand-logo">
      				<a href="<?php echo $base_url.$admin_path.'/dashboard'; ?>">
      				<?php if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !=''){ ?>
          			<img alt="Admin Panel" style="width:125px; height:33px;" src="<?php echo $base_url.'assets/logo/'.$config_data['upload_logo']; ?>" />
			        <?php
			        	}
			        	else
			          	{
              				echo $config_data['web_frienly_name'];
          				}
				    ?>
			        </a>
			    </div>
      			<a href="javascript:;" onclick="small_layout();" class="toggle-sidebar hidden-xs hamburger-icon v3" data-toggle="layout-small-menu"> 	
                	<span></span> 
                    <span></span> 
                    <span></span> 
                    <span></span> 
                </a> 
            </div>
    		<nav role="navigation">
      			<ul class="nav">
                	<li class="visible-xs">
                    	<a href="javascript:;"> <i class="fa fa-user"></i> <span><?php echo $username_dip; ?></span> </a>
          				<ul class="sub-menu">
                        	<?php
							if($user_type == 'admin')
							{
							?>
							<li> <a href="<?php echo $base_url.$admin_path.'/site-setting/basic-setting';?>">Settings</a> </li>
							<?php
							}
							?>
                        	<li> <a href="<?php echo $base_url.$admin_path.'/site-setting/change-password';?>">Change Password</a> </li>
                            <li> <a href="<?php echo $base_url;?>" target="_blank">Front End</a> </li>
                            <li> <a href="<?php echo $base_url.$admin_path.'/'.$user_login_url;?>/log_out">Logout</a> </li>
			          	</ul>
			        </li>
        			<li id="dashboard" <?php if(isset($page_title) && $page_title =='Dashboard'){ echo 'class="active"';} ?>>
                    	<a href="<?php echo $base_url.$admin_path.'/dashboard';?>"> <i class="fa fa-tachometer"></i> <span>Dashboard</span> </a> 
                    </li>
        			<?php
					if($user_type == 'admin')
					{
					?>
                    <li id="site_setting">
                    	<a href=javascript:;> <i class="fa fa-cogs"></i> <span>Site Settings</span> </a>
      					<ul class=sub-menu>
						  	<li id="basic_setting"> <a href="<?php echo $base_url.$admin_path.'/site-setting/basic-setting';?>"> <span>Basic Site Settings</span> </a> </li>
                            <li id="logo_favicon"> <a href="<?php echo $base_url.$admin_path.'/site-setting/logo-favicon';?>"> <span>Logo &amp; Favicon</span> </a> </li>
							<li id="update_email"> <a href="<?php echo $base_url.$admin_path.'/site-setting/update-email';?>"> <span>Email</span> </a> </li>
                            <li id="matri_prefix"> <a href="<?php echo $base_url.$admin_path.'/site-setting/matri-prefix';?>"> <span>Matri Prefix</span> </a> </li>
							<li id="social_site_setting"> <a href="<?php echo $base_url.$admin_path.'/site-setting/social-site-setting';?>"> <span>Social Media Link</span> </a> </li>
							<li id="analytics_code_setting"> <a href="<?php echo $base_url.$admin_path.'/site-setting/analytics-code-setting';?>"> <span>Google Analytics Code</span> </a> </li>
							<li id="app_link"> <a href="<?php echo $base_url.$admin_path.'/site-setting/app-link';?>"> <span>App Link</span> </a> </li>
							<li id="change_password"> <a href="<?php echo $base_url.$admin_path.'/site-setting/change-password';?>"> <span>Change Password</span> </a> </li>



                            
                            <li class="site_setting_add view_detail" id="seo_pages"><a href="<?php echo $base_url.$admin_path.'/site-setting/seo-pages/ALL/1/yes';?>"> <span>Seo Page Data</span> </a></li>
                            <!-- <li id="social_app_man"> <a href="<?php //echo $base_url.$admin_path.'/site-setting/social-app-man/ALL/1/yes';?>"> <span>Social App</span> </a> </li> -->
                            <li id="currency_man"> <a href="<?php echo $base_url.$admin_path.'/site-setting/currency-man/ALL/1/yes';?>"> <span>Currency Management</span> </a> </li>
                            
                           
                           
						   <li id="homepage_text"> <a href="<?php echo $base_url.$admin_path.'/site-setting/homepage-text';?>"> <span>Homepage Text</span> </a> </li>
						   <li id="other_banner">
                            	<a href="<?php echo $base_url.$admin_path.'/site-setting/other_banner';?>"> <span>Homepage Banner & Text</span> </a> 
                            </li>
                            <li id="banner_quick_info">
                            	<a href="<?php echo $base_url.$admin_path.'/site-setting/banner_quick_info/ALL/1/yes';?>"> <span>Banner Quick Info</span> </a> 
                            </li>
							<li id="reason_why_choose">
                            	<a href="<?php echo $base_url.$admin_path.'/site-setting/reason_why_choose/ALL/1/yes';?>"> <span>Reason Why Choose</span> </a> 
                            </li>
                           <li id="generate_sitemap"> <a href="javascript:void(0);" onClick="return generate_sitemap();"> <span>Generate Sitemap</span> </a> </li>
                        </ul>
			        </li>
                    <li id="new_listing">
                    	<a href=javascript:;> <i class="fa fa-plus"></i> <span>Add New Details</span> </a>
          				<ul class=sub-menu>
                        	<li class="new_listing_add" id="religion_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/religion-man/ALL/1/yes';?>"> <span>Religion</span> </a>
                            </li>
                            <li class="new_listing_add" id="caste_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/caste-man/ALL/1/yes';?>"> <span>Caste</span> </a>
                            </li>
                            <li class="new_listing_add" id="country_list">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/country-list/ALL/1/yes';?>"> <span>Country</span> </a> 
                            </li>
                            <li class="new_listing_add" id="state_list">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/state-list/ALL/1/yes';?>"> <span>State</span> </a> 
                            </li>
            				<li class="new_listing_add" id="city_list">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/city-list/ALL/1/yes';?>"> <span>City</span> </a> 
                            </li>
                            <li class="new_listing_add" id="occupation_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/occupation-man/ALL/1/yes';?>"> <span>Occupation</span> </a>
                            </li>
                            <li class="new_listing_add" id="education_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/education-man/ALL/1/yes';?>"> <span>Education</span> </a>
                            </li>
                            <li class="new_listing_add" id="mothertongue_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/mothertongue-man/ALL/1/yes';?>"> <span>Mother Tongue</span> </a> 
                            </li>
                            <li class="new_listing_add" id="designation_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/designation-man/ALL/1/yes';?>"> <span>Designation</span> </a> 
                            </li>
                             <li class="new_listing_add" id="star_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/star_man/ALL/1/yes';?>"> <span>Star</span> </a> 
                            </li>
                             <li class="new_listing_add" id="moonsign_man">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/moonsign_man/ALL/1/yes';?>"> <span>Moonsign</span> </a> 
                            </li>
                            <li class="new_listing_add" id="faq_list">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/faq-list/ALL/1/yes';?>"> <span>FAQs</span> </a> 
                            </li>
                            <li class="new_listing_add" id="banner">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/banner/ALL/1/yes';?>"> <span>Home Page Banner</span> </a> 
                            </li>
							<li class="new_listing_add" id="mobile_matri_bannner">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/mobile_matri_bannner/ALL/1/yes';?>"> <span>Mobile Matri Banner</span> </a> 
                            </li>
							
							<li class="new_listing_add" id="add_matrimoni_data">
                            	<a href="<?php echo $base_url.$admin_path.'/new-listing/add_matrimoni_data/ALL/1/yes';?>"> <span>Matrimony Data</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <?php
					}
					$view_member_perm = $this->common_model->check_permission('view_member');
					if($view_member_perm !='No')
					{
					?>
                    <li id="member">
                    	<a href=javascript:;> <i class="fa fa-user"></i> <span>Member</span> </a>
          				<ul class="sub-menu">
            				<li class="member_add member_detail" id="member_list">
                            	<a href="<?php echo $base_url.$admin_path.'/member/member-list/ALL/1/yes';?>"> <span>All Member</span> </a> 
                            </li>
                            <?php
							$filter_profile_perm = $this->common_model->check_permission('advanced_search');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="advanced_search_result advanced_search" id="advanced_search">
                            	<a href="<?php echo $base_url.$admin_path.'/member/advanced-search';?>"> <span>Advanced Search</span> </a> 
                            </li>
                            <?php
							}
							$filter_profile_perm = $this->common_model->check_permission('approve_to_paid_member');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="member_detail" id="active_member_list">
                            	<a href="<?php echo $base_url.$admin_path.'/member/active-member-list/ALL/1/yes';?>"> <span>Active to Paid</span> </a>
                            </li>
                            <?php
							}
							if($user_type == 'admin')
							{
								?>
								<li class="member_detail" id="featured_member_list">
									<a href="<?php echo $base_url.$admin_path.'/member/featured-member-list/ALL/1/yes';?>"> <span>Paid To Spotlight</span> </a> 
								</li>
								<?php
							}
							$filter_profile_perm = $this->common_model->check_permission('edit_plan');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="member_add member_detail" id="upgrade_member_list">
                            	<a href="<?php echo $base_url.$admin_path.'/member/upgrade-member-list/ALL/1/yes';?>"> <span>Edit Plan </span> </a>
                            </li>
                            <?php
							}
							?>
                            <!--<li class="member_add member_detail" id="paid_member_list">
                            	<a href="<?php //echo $base_url.$admin_path.'/member/paid-member-list/ALL/1/yes';?>"> <span>Paid Member</span> </a> 
                            </li>-->
                            <?php
							$filter_profile_perm = $this->common_model->check_permission('renew_plan');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="member_add member_detail" id="expired_member_list">
                            	<a href="<?php echo $base_url.$admin_path.'/member/expired-member-list/ALL/1/yes';?>"> <span>Expired Member</span> </a> 
                            </li>
                            <?php
							}
							if($user_type == 'admin')
							{
							?>
                            <li class="member_add member_detail" id="delete_request_list">
                            	<a href="<?php echo $base_url.$admin_path.'/member/delete-request-list/ALL/1/yes';?>"> <span>Delete Request</span> </a> 
                            </li>
                            <?php }?>
			          	</ul>
			        </li>
                    <?php
					}
					$filter_profile_perm = $this->common_model->check_permission('match_making');
					if($filter_profile_perm !='No')
					{
					?>
                    <li id="match_making">
                    	<a href=javascript:;> <i class="fa fa-ruble"></i> <span>Match Making</span> </a>
          				<ul class="sub-menu">
            				<li class="member_add member_detail match" id="match_making_list">
                            	<a href="<?php echo $base_url.$admin_path.'/match-making/match-making-list/ALL/1/yes';?>"> <span>Manual Profile Match Making</span> </a> 
                            </li>
                            <?php if($user_type == 'admin'){?>
                                <li id="auto_matchs_list">
                                    <a href="<?php echo $base_url.$admin_path.'/match-making/auto-matchs-list';?>"> <span>Auto Profile Match</span> </a> 
                                </li>
                            <?php }?>
			          	</ul>
			        </li>
                    <?php
					}
					
					$view_member_perm = $this->common_model->check_permission('view_lead_generation');
					if($view_member_perm !='No')
					{
					?>
                    <li id="lead_generation">
                    	<a href=javascript:;> <i class="fa fa-user"></i> <span>Lead Generation</span> </a>
          				<ul class="sub-menu">
            				<li id="lead_generation_list">
                            	<a href="<?php echo $base_url.$admin_path.'/lead-generation/lead-generation-list/ALL/1/yes';?>"> <span>Lead Generation</span> </a>
                            </li>
                            <li id="lead_generation_report">
                            	<a href="<?php echo $base_url.$admin_path.'/lead-generation/lead-generation-report/ALL/1/yes';?>"> <span>Leads Followup Date Report</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <?php 
					} 
					if($user_type == 'admin')
					{
					?>
                    <li id="staff_assignment_reports">
                    	<a href=javascript:;> <i class="fa fa-stack-exchange"></i> <span>Staff Assignment Report</span> </a>
          				<ul class="sub-menu">
                            <li id="staff_assign_history">
                                <a href="<?php echo $base_url.$admin_path.'/staff-assignment-reports/staff-assign-history/ALL/1/yes';?>"> <span>Assigned Members</span> </a>
                            </li>
                            <li id="staff_unassign_history">
                                <a href="<?php echo $base_url.$admin_path.'/staff-assignment-reports/staff-unassign-history/ALL/1/yes';?>"> <span>Unassigned Members</span> </a>
                            </li>
                            <li id="staff_lead_assign_history">
                                <a href="<?php echo $base_url.$admin_path.'/staff-assignment-reports/staff-lead-assign-history/ALL/1/yes';?>"> <span>Assigned Lead Generation</span> </a>
                            </li>
                            <li id="staff_lead_unassign_history">
                                <a href="<?php echo $base_url.$admin_path.'/staff-assignment-reports/staff-lead-unassign-history/ALL/1/yes';?>"> <span>Unassigned Lead Generation</span> </a>
                            </li>
                        </ul>
                    </li>
                    <li id="franchise_assignment_reports">
                    	<a href=javascript:;> <i class="fa fa-stack-exchange"></i> <span>Franchise Assignment Report</span> </a>
          				<ul class="sub-menu">
                            <li id="franchise_assign_history">
                                <a href="<?php echo $base_url.$admin_path.'/franchise-assignment-reports/franchise-assign-history/ALL/1/yes';?>"> <span>Assigned Members</span> </a>
                            </li>
                            <li id="franchise_unassign_history">
                                <a href="<?php echo $base_url.$admin_path.'/franchise-assignment-reports/franchise-unassign-history/ALL/1/yes';?>"> <span>Unassigned Members</span> </a>
                            </li>
                             <li id="franchise_lead_assign_history">
                                <a href="<?php echo $base_url.$admin_path.'/franchise-assignment-reports/franchise-lead-assign-history/ALL/1/yes';?>"> <span>Assigned Lead Generation</span> </a>
                            </li>
                            <li id="franchise_lead_unassign_history">
                                <a href="<?php echo $base_url.$admin_path.'/franchise-assignment-reports/franchise-lead-unassign-history/ALL/1/yes';?>"> <span>Unassigned Lead Generation</span> </a>
                            </li>
                        </ul>
                    </li>
                    <?php
					}
                    if($user_type != 'admin')
					{
					?>
                        <li id="assignment_reports">
                            <a href=javascript:;> <i class="fa fa-stack-exchange"></i> <span>Assignment Report</span> </a>
                            <ul class="sub-menu">
                            	<li id="member_assigned_to_me">
                                    <a href="<?php echo $base_url.$admin_path.'/assignment-reports/member_assigned_to_me/ALL/1/yes';?>"> <span>Member Assigned To Me</span> </a>
                                </li>
                                <li id="lead_generation_assigned_to_me">
                                    <a href="<?php echo $base_url.$admin_path.'/assignment-reports/lead_generation_assigned_to_me/ALL/1/yes';?>"> <span>Lead Generation Assigned To Me</span> </a>
                                </li>
                            </ul>
                        </li>
                    <?php 
					}
					if($user_type != 'franchise')
					{
					?>
                        <li id="followup_system">
                            <a href=javascript:;> <i class="fa fa-stack-exchange"></i> <span>Followed Up System</span> </a>
                            <ul class="sub-menu">
                                 <li class="follow_up_report follow_up_report_add" id="follow_up_report">
                                    <a href="<?php echo $base_url.$admin_path.'/followup-system/follow-up-report/Next/1/yes';?>"> <span>Member Report</span> </a>
                                </li>
                                <li class="lead_generation_follow_up_report lead_generation_follow_up_report_add" id="lead_generation_follow_up_report">
                                    <a href="<?php echo $base_url.$admin_path.'/followup-system/lead-generation-follow-up-report/Next/1/yes';?>"> <span>Lead Generation Report</span> </a>
                                </li>
                            </ul>
                        </li>
                    <?php 
					}
					if($user_type == 'admin')
					{
					?>
                    <li id="member_plan">
                    	<a href=javascript:;> <i class="fa fa-money"></i> <span>Membership Plan</span> </a>
          				<ul class="sub-menu">
            				<li class="member_plan plan" id="plan">
                            	<a href="<?php echo $base_url.$admin_path.'/member-plan/plan/ALL/1/yes';?>"> <span>Plan</span> </a> 
                            </li>
                           <!-- <li class="member_plan add_on" id="add_on">
                            	<a href="<?php //echo $base_url.$admin_path.'/member-plan/add-on/ALL/1/yes';?>"> <span>Add On</span></a> 
                            </li>-->
			          	</ul>
			        </li>
                    <li id="staff">
                    	<a href=javascript:;> <i class="fa fa-user"></i> <span>Staff</span> </a>
          				<ul class="sub-menu">
            				<li class="staff staff_add" id="staff_list">
                            	<a href="<?php echo $base_url.$admin_path.'/staff/staff-list/ALL/1/yes';?>"> <span>Staff</span> </a>
                            </li>
                            <li class="staff staff_role_add" id="staff_role">
                            	<a href="<?php echo $base_url.$admin_path.'/staff/staff-role/ALL/1/yes';?>"> <span>Staff Roles</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <li id="franchise">
                    	<a href=javascript:;> <i class="fa fa-user"></i> <span>Franchise</span> </a>
          				<ul class="sub-menu">
            				<li class="franchise franchise_add" id="franchise_list">
                            	<a href="<?php echo $base_url.$admin_path.'/franchise/franchise-list/ALL/1/yes';?>"> <span>Franchise</span> </a>
                            </li>
                            <li class="" id="franchise_member">
                            	<a href="<?php echo $base_url.$admin_path.'/franchise/franchise-member/ALL/1/yes';?>"> <span>Franchise Member</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <?php
					}
					
					if($user_type == 'admin'){
					?>
					<li id="manage_coupan">
                    	<a href=javascript:;> <i class="fa fa-money"></i> <span>Coupon Code</span> </a>
          				<ul class="sub-menu">
            				<li class="manage_coupan coupan_code_add" id="coupan_code_list">
                            	<a href="<?php echo $base_url.$admin_path.'/manage-coupan/coupan-code-list/ALL/1/yes';?>"> <span>Coupon Code</span> </a>
                            </li>
			          	</ul>
			        </li>
					<?php
					}
					?>
                    <li id="approval">
                    	<a href=javascript:;> <i class="fa fa-thumbs-up"></i> <span>Approval</span> </a>
          				<ul class="sub-menu">
							<?php
							if($user_type == 'admin')
							{
							?>
								<li class="approval" id="wedding_vendors_review">
									<a href="<?php echo $base_url.$admin_path.'/approval/wedding-vendors-review/ALL/1/yes';?>"> 
										<span>Wedding Vendors Review</span>
									</a> 
								</li>
                            <?php
							}
							if($user_type == 'admin')
							{
							?>
	                        <li class="success_story success_story_add" id="success_story">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/success-story/ALL/1/yes';?>"> <span>Success Story</span> </a> 
                            </li>
                            <?php
							}
							$filter_profile_perm = $this->common_model->check_permission('video_approval');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="approval" id="video">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/video/ALL/1/yes';?>"> <span>Video</span> </a> 
                            </li>
                            <?php
							}
							$filter_profile_perm = $this->common_model->check_permission('cover_photo_approval');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="approval" id="cover_photo">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/cover-photo/ALL/1/yes';?>"> <span>Cover Photo</span> </a> 
                            </li>
                            <?php
							}
							$filter_profile_perm = $this->common_model->check_permission('id_proof_approval');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="approval" id="id_proof">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/id-proof/ALL/1/yes';?>"> <span>ID Proof</span> </a> 
                            </li>
                            <?php
							}
							$filter_profile_perm = $this->common_model->check_permission('horoscope_approval');
							if($filter_profile_perm !='No')
							{
							?>
                            <li class="approval" id="horoscope">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/horoscope/ALL/1/yes';?>"> <span>Horoscope</span> </a> 
                            </li>
                        <?php
						}
						if(isset($this->common_model->photo_upload_count) && $this->common_model->photo_upload_count !='')
						{
							$photo_upload_count = $this->common_model->photo_upload_count;
						}
						else
						{
							$photo_upload_count = 8;
						}
						if($photo_upload_count > 8){$photo_upload_count = 8;}
						$filter_profile_perm = $this->common_model->check_permission('photo_approval');
						for($iphoto = 1;$iphoto<= $photo_upload_count;$iphoto++)
						{
							if($filter_profile_perm !='No')
							{
						?>
            				<li class="approval" id="member_photo<?php echo $iphoto; ?>">
                            	<a href="<?php echo $base_url.$admin_path.'/approval/member-photo'.$iphoto.'/ALL/1/yes';?>"> <span>Photo <?php echo $iphoto; ?></span> </a> 
                            </li>
                        <?php
							}
						}
						?>
						</ul>
			        </li>
                    <?php
					if($user_type == 'admin')
					{
					?>
                    <li id="user_activity"> 
                    	<a href=javascript:;> <i class="fa fa-book"></i> <span>User Activity</span> </a>
          				<ul class=sub-menu>
            				<li class="user_activity_add" id="express_interest">
                            	<a href="<?php echo $base_url.$admin_path.'/user-activity/express-interest/ALL/1/yes';?>"> <span>Express Interest</span> </a> 
                            </li>
                            <li class="user_activity_add" id="message">
                            	<a href="<?php echo $base_url.$admin_path.'/user-activity/message/ALL/1/yes';?>"> <span>Message</span> </a> 
                            </li>
							<li class="user_activity_add" id="user_login_history">
                            	<a href="<?php echo $base_url.$admin_path.'/user-activity/user_login_history/ALL/1/yes';?>"> <span>User Login History</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <li id="payment_option"> 
                    	<a href=javascript:;> <i class="fa fa-bar-chart"></i> <span>Payment Option</span> </a>
          				<ul class=sub-menu>
            				<li class="payment_option_add" id="payment_list">
                            	<a href="<?php echo $base_url.$admin_path.'/payment-option/payment-list/ALL/1/yes';?>"> <span>Payment Method</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <?php
					}
					if($user_type == 'admin' || $user_type == 'franchise')
					{
					?>
                    <li id="sales_report"> 
                    	<a href=javascript:;> <i class="fa fa-bar-chart"></i> <span>Sales Report</span> </a>
          				<ul class=sub-menu>
            				<li class="sales_report all_list view_invoice" id="all_list">
                            	<a href="<?php echo $base_url.$admin_path.'/sales-report/all-list/ALL/1/yes';?>"> <span>Sales Report</span> </a> 
                            </li>
                            <?php
								if($user_type == 'admin')
								{
							?>
                            <li class="franchise_sales_report" id="">
                            	<a href="<?php echo $base_url.$admin_path.'/sales-report/franchise-sales-report/ALL/1/yes';?>"> <span>Franchise Sales Report</span> </a>
                            </li>
                            <?php
								}
							?>
			          	</ul>
			        </li>
                    <?php
					}
					if($user_type == 'admin')
					{
					?>
                    <li id="event_management"> 
                    	<a href=javascript:;> <i class="fa fa-book"></i> <span>Event Management</span> </a>
          				<ul class=sub-menu>
            				<li id="event_list" class="view_event">
                            	<a href="<?php echo $base_url.$admin_path.'/event-management/event-list/ALL/1/yes';?>"> <span>Event List</span> </a>
                            </li>
                            <li class="event_management_add">
                            	<a href="<?php echo $base_url.$admin_path.'/event-management/event-list/add-data';?>"> <span>Add Event</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <li id="wedding_vendors"> 
                    	<a href=javascript:;> <i class="fa fa-book"></i> <span>Wedding Vendors</span> </a>
          				<ul class=sub-menu>
            				<li id="vendors_list" class="view_detail">
                            	<a href="<?php echo $base_url.$admin_path.'/wedding-vendors/vendors-list/ALL/1/yes';?>"> <span>Vendors List</span> </a> 
                            </li>
                            <li class="wedding_vendors_add">
                            	<a href="<?php echo $base_url.$admin_path.'/wedding-vendors/vendors-list/add-data';?>"> <span>Add Vendors</span> </a>
                            </li>
                            <li class="vendors_category_add" id="vendors_category">
                            	<a href="<?php echo $base_url.$admin_path.'/wedding-vendors/vendors-category/ALL/1/yes';?>"> <span>Vendors Category</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <li id="content_management"> 
                    	<a href=javascript:;> <i class="fa fa-book"></i> <span>Content Management</span> </a>
          				<ul class=sub-menu>
            				<li class="content_management_add" id="cms_pages">
                            	<a href="<?php echo $base_url.$admin_path.'/content-management/cms-pages/ALL/1/yes';?>"> <span>Cms Pages</span> </a> 
                            </li>
			          	</ul>
			        </li>
					<li id="ticket_management"> 
                    	<a href=javascript:;> <i class="fa fa-bar-chart"></i> <span>Developer Tools</span> </a>
          				<ul class=sub-menu>
            				<li class="ticket_management_add" id="ticket_list">
                            	<a href="<?php echo $base_url.$admin_path.'/ticket-management/ticket-list/ALL/1/yes';?>"> <span>Ticket Management</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <li id="blog_management"> 
                    	<a href=javascript:;> <i class="fa fa-bar-chart"></i> <span>Blog Management</span> </a>
          				<ul class=sub-menu>
            				<li class="blog_management_add" id="blog_list">
                            	<a href="<?php echo $base_url.$admin_path.'/blog-management/blog-list/ALL/1/yes';?>"> <span>Blog Management</span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <li id="email_templates">
                    	<a href=javascript:;> <i class="fa fa-envelope"></i> <span>Email Templates</span> </a>
          				<ul class=sub-menu>
            				<li id="email_templates">
                            	<a href="<?php echo $base_url.$admin_path.'/email-templates/email-templates/ALL/1/yes';?>"> <span>Email Templates</span> </a>
                            </li>
                            <li class="email_templates_add" id="add_email_templates">
                            	<a href="<?php echo $base_url.$admin_path.'/email-templates/email-templates/add-data';?>"> <span>Add Email Templates</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <li id="sms_templates">
                    	<a href=javascript:;> <i class="fa fa-mobile"></i> <span>SMS Templates</span> </a>
          				<ul class=sub-menu>
            				<li id="sms_configuration"> <a href="<?php echo $base_url.$admin_path.'/sms-templates/sms-configuration';?>"> <span>SMS Configuration</span> </a> </li>
                            <li id="sms_templates">
                            	<a href="<?php echo $base_url.$admin_path.'/sms-templates/sms-templates/ALL/1/yes';?>"> <span>SMS Templates</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <?php
					}
					$temp_add_disable = '';
					if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
					{
						$temp_add_disable = '(Disable in demo)';
					}
					$filter_profile_perm = $this->common_model->check_permission('send_bulk_email_and_sms');
					//echo $filter_profile_perm;
					if($filter_profile_perm !='No')
					{
					?>
                    <li id="bulk_email_sms">
                    	<a href=javascript:;> <i class="fa fa-envelope-o"></i> <span>Send Bulk Email and SMS</span> </a>
          				<ul class=sub-menu>
                            <li id="send_email"> <a href="<?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo '#';} else { echo $base_url.$admin_path.'/bulk-email-sms/send-email';} ?>"> <span>Send Bulk Email <?php echo $temp_add_disable; ?></span> </a> 
                            </li>
                            <li id="send_sms"> <a href="<?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo '#';} else { echo $base_url.$admin_path.'/bulk-email-sms/send-sms';} ?>"> <span>Send Bulk SMS <?php echo $temp_add_disable; ?></span> </a> 
                            </li>
			          	</ul>
			        </li>
                    <?php /*?><!--<li id="email_sms">
                    	<a href=javascript:;> <i class="fa fa-envelope-o"></i> <span>Send Email and SMS</span> </a>
          				<ul class=sub-menu>
                            <li id="send_email" class="send_email"> <a href="<?php //if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo '#';} else { echo $base_url.$admin_path.'/email-sms/send-email/add-data';} ?>"> <span>Send Email <?php //echo $temp_add_disable; ?></span> </a> 
                            </li>
                            <li id="send_sms" class="send_sms"> <a href="<?php //if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo '#';} else { echo $base_url.$admin_path.'/email-sms/send-sms/add-data';}?>"> <span>Send SMS <?php //echo $temp_add_disable; ?></span> </a> 
                            </li>
			          	</ul>
			        </li>--><?php */?>
                    <?php
					}
					if($user_type == 'admin')
					{
					?>
                    <li id="advertisement_management"> 
                    	<a href=javascript:;> <i class="fa fa-file-o"></i> <span>Advertisement</span> </a>
          				<ul class=sub-menu>
            				<li class="advertisement_management_add" id="adv_list">
                            	<a href="<?php echo $base_url.$admin_path.'/advertisement-management/adv-list/ALL/1/yes';?>"> <span>Advertisement</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <li id="user_analysis"> 
                    	<a href=javascript:;> <i class="fa fa-user-md"></i> <span>User Analysis</span> </a>
          				<ul class=sub-menu>
            				<li class="user_analysis_add" id="index">
                            	<a href="<?php echo $base_url.$admin_path.'/user-analysis/user-analysis-list/ALL/1/yes';?>"> <span>All User Analysis</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <li id="database_backup"> 
                    	<a href=javascript:;> <i class="fa fa-download"></i> <span>Database Backup</span> </a>
          				<ul class=sub-menu>
            				<li class="Database_backup_add" id="backup">
                            	<a href="<?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 0){ echo $base_url.$admin_path.'/database-backup/backup';} ?>"> <span>Database Backup <?php echo $temp_add_disable; ?></span> </a>
                            </li>
                            <li class="Database_backup_add" id="backup">
                            	<a href="<?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 0){ echo $base_url.$admin_path.'/database-backup/download-csv'; } ?>"> <span>Download Member CSV File <?php echo $temp_add_disable; ?></span> </a>
                            </li>
                          
			          	</ul>
			        </li>
                    <?php
						if($base_url =='http://192.168.1.111/mega_matrimony/original_script/v2.0/')
						{
					?>
                    <li id="webservice_man">
                    	<a href=javascript:;> <i class="fa fa-tint"></i> <span>Web service</span> </a>
          				<ul class=sub-menu>
            				<li class="webservice_man_add" id="adv_list">
                            	<a href="<?php echo $base_url.$admin_path.'/webservice-man/service-list/ALL/1/yes';?>"> <span>Web Service</span> </a>
                            </li>
			          	</ul>
			        </li>
                    <?php
						}
					}
					?>
		      	</ul>
    		</nav>
  		</div>
  		<div class="main-panel">
    		<header class="header navbar">
      			<div class="brand visible-xs">
        			<div class=toggle-offscreen> <a href=# class="hamburger-icon visible-xs" data-toggle=offscreen data-move=ltr> <span></span> <span></span> <span></span> </a> 
                    </div>
        			<div class=brand-logo> <?php if(isset($config_data['web_logo_path']) && $config_data['web_logo_path'] !=''){ ?>
          				<img style="width:134px;" src="<?php echo $base_url.'assets/logo/'.$config_data['web_logo_path']; ?>"/> 
			          <?php
					  }
					  else
					  {
						  echo $config_data['web_frienly_name'];
					  }
				  	?> 
                  	</div>
        			<div class=toggle-chat> <a href=javascript:; class="hamburger-icon v2 visible-xs" data-toggle=layout-chat-open> <span></span> <span></span> <span></span> </a> 
                    </div>
      			</div>
      			<ul class="nav navbar-nav">
                	<li>
                  		<p class="navbar-text bold"> <?php if(isset($page_title)){ echo $page_title;} ?> </p>
                	</li>
              	</ul>               
      			<ul class="nav navbar-nav navbar-right hidden-xs">
        			<?php /*?><!--<li>
                        <a href=javascript:; data-toggle=dropdown> <i class="fa fa-bell-o"></i>
                            <div class="status bg-danger border-danger animated bounce"></div>
                        </a>
                  		<ul class="dropdown-menu notifications">
                        	<li class=notifications-header>
                          		<p class="text-muted small">You have 3 new messages</p>
                        	</li>
                            <li>
                              <ul class=notifications-list>
                                <li> <a href=javascript:;> <span class="pull-left mt2 mr15"> <img src="<?php //echo $base_url.'assets/back_end/';?>images/avatar.21d1cc35.jpg" class="avatar avatar-xs img-circle" alt=""> </span>
                                  <div class=overflow-hidden> <span>Sean launched a new application</span> <span class=time>2 seconds ago</span> </div>
                                  </a> </li>
                                <li> <a href=javascript:;>
                                  <div class="pull-left mt2 mr15">
                                    <div class="circle-icon bg-danger"> <i class="fa fa-chain-broken"></i> </div>
                                  </div>
                                  <div class=overflow-hidden> <span>Removed chrome from app list</span> <span class=time>4 Hours ago</span> </div>
                                  </a> </li>
                                <li> <a href=javascript:;> <span class="pull-left mt2 mr15"> <img src="<?php //echo $base_url.'assets/back_end/';?>images/face3.0306ffff.jpg" class="avatar avatar-xs img-circle" alt=""> </span>
                                  <div class=overflow-hidden> <span class=text-muted>Jack Hunt has registered</span> <span class=time>9 hours ago</span> </div>
                                  </a> </li>
                              </ul>
                            </li>
                    		<li class=notifications-footer> <a href=javascript:;>See all messages</a> </li>
                  		</ul>
                	</li>--><?php */?>
        			<li> <a href="javascript:;" data-toggle="dropdown"> <!--<img src="<?php //echo $base_url; ?>assets/back_end/images/profile.png" class="header-avatar img-circle ml10" alt=user title=user>--> <i style="font-size:24px" class="fa fa-user fa-6x "></i>&nbsp;&nbsp; <span class=pull-left><?php echo $username_dip; ?>&nbsp;&nbsp;&nbsp;</span> </a>
          <ul class=dropdown-menu>
          	<?php
			if($user_type == 'admin')
			{
			?>
            <li> <a href="<?php echo $base_url.$admin_path.'/site-setting/basic-setting';?>">Settings</a> </li>
            <!--<li> <a href=javascript:;> <span class="label bg-danger pull-right">34</span> <span>Notifications</span> </a> </li>-->
			<?php
			}
			?>
            <li> <a href="<?php echo $base_url.$admin_path.'/site-setting/change-password';?>">Change Password</a> </li>
            <li> <a href="<?php echo $base_url;?>" target="_blank">Front End</a> </li>
            <li> <a href="<?php echo $base_url.$admin_path.'/'.$user_login_url;?>/log_out">Logout</a> </li>
          </ul>
        </li>
      			</ul>
	</header>
	<div class="margin-top-20px-t hidden-lg hidden-md"></div>
<div class="main-content" id="main_content_ajax">