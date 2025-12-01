<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        	<div class="col-md-9 col-sm-12 col-xs-12">
            	<?php include_once('my_dashboard_info.php');?>
            	<div class="dshbrd_overlay mt-2">
					<div class="dshbrd_color_overlay new-saved-search">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<span class="saved-search-i Poppins-Medium"> <i class="fas fa-heart"></i>  Match Of The Day
								</span>
							</div>
						</div>
					</div>
				</div>
                <div id="main_content_ajax">
                    <?php include('match_result_member_profile.php'); ?>
                </div>
            </div>            
		</div>
	</div>
</div>
