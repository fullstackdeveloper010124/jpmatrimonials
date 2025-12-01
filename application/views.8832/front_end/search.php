<?php $current_login_user = $this->common_front_model->get_session_data();
$is_login = $this->common_front_model->checkLogin('return');
$login_li = '';
if($is_login){
	$login_li = 'after-login-li';
}
?>
<style>
	.contact-tab-nav2 li{
		margin: unset!important;
	}
	.quick-search-tab .nav-tabs li a {
    margin-right: unset !important;
}
.contact-tab-m .nav-tabs {
    border: none;
    display: flex;
    align-items: center;
    justify-content: space-between;
	margin-bottom:10px;
}
.new-width {
    width: 100%;
}
.add-box-2 {
    border: none;
}
.contact-tab-m .nav-tabs li a {
    padding: 10px;
	padding-top: 0px;
}
.f-16{
	font-size:14px!important;
}
.new-id-s {
	padding: 10px 15px;
}
</style>
		<div class="container new-width" style="width:93%;">
			<div class="row">
				<div class="tab-content tabs tab-content-margin-top">
					<div role="tabpanel" class="tab-pane fade in <?php if($this->uri->segment(2)=='quick-search'){echo 'active';}?>" id="quick-search-tab">
						<div class="row mt-4 margin-lr-0">
							<?php include_once('quick_search.php');?>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<?php 
								include('id_search_rightsidebar.php');
								echo $this->common_model->display_advertise('Level 2','hidden-sm hidden-xs');
								$class1 = 'Prf_sidebar-new-mac';
								include('featured_rightsidebar.php');
								?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in <?php if($this->uri->segment(2)=='advance-search'){echo 'active';}?>" id="advance-search-tab">
						<div class="row mt-4 margin-lr-0">
							<?php include_once('advance_search.php');?>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<?php include('id_search_rightsidebar.php');
                                echo $this->common_model->display_advertise('Level 2');
								include('featured_rightsidebar.php');
								?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in <?php if($this->uri->segment(2)=='keyword-search'){echo 'active';}?>" id="keyword-search-tab">
						<div class="row mt-4 margin-lr-0">
							<?php include_once('keyword_search.php');?>
							<div class="col-md-4 col-sm-12 col-xs-12">
								<?php 
									include('id_search_rightsidebar.php');
							    	include('featured_rightsidebar.php');
								?>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in <?php if($this->uri->segment(2)=='id-search'){echo 'active';}?>" id="id-search-tab">
						<div class="row mt-4 margin-lr-0">
							<?php include_once('id_search.php');?>
							<div class="col-md-4 col-sm-12 col-xs-12">
							     <?php include('id_search_rightsidebar.php');
								 $limit=3;
								 include('featured_rightsidebar.php');?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container new-width hidden-sm hidden-xs" style="width:93%;display:inherit;">
			<div class="row">
            	<?php include_once('search_footer_slider.php');?>
				<div class="col-md-4 col-sm-12 col-xs-12 padding-right-zero-search">
					<?php echo $this->common_model->display_advertise('Level 1','cstm_border_new');?>
				</div>
			</div>
		</div>
        