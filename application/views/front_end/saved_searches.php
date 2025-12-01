<div class="container-fluid new-width width-95 mt-40-pro">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        	<div class="col-md-9 col-sm-12 col-xs-12">
            	<?php include_once('my_dashboard_info.php');?>
            	<div class="dshbrd_side_section mt-3">
					<div class="dshbrd_overlay">
						<div class="dshbrd_color_overlay new-saved-search">
							<div class="row">
								<div class="col-md-12 col-xs-12">
									<span class="saved-search-i Poppins-Medium"> <i class="fas fa-save"></i> Saved Searches</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!------- for search result ----->
            	<div id="main_content_ajax">
					<?php include_once('saved_searches_member_profile.php'); ?>
				</div>
           	   	<!------ for search result ------> 
			</div>
		</div>
	</div>
</div>
<?php $this->common_model->js_extra_code_fr.="load_pagination_code_front_end();";?>		