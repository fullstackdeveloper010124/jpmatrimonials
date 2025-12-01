
<?php
	
	$comm_model = $this->common_model;
	
    $login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
	$current_login_user = $this->common_front_model->get_session_data(); ?>
	
		
		 
	
		
		<div class="container-fluid new-width width-95 mt-40-pro">
			<div class="row-cstm">
				<!--for Mobile start--> 
				
				<?php include('my_profile_sidebar.php');?>
			</div>
            
			<div class="col-md-9 col-sm-12 col-xs-12 padding-zero">
			<?php include('my_dashboard_info.php');?>
				<div class="dshbrd_overlay mt-2">
					<div class="dshbrd_color_overlay new-saved-search">
						<div class="row">
							<div class="col-md-12 col-xs-12">
								<span class="saved-search-i Poppins-Medium"> <i class="far fa-credit-card"></i> Current Plan
								</span>
							</div>
						</div>
					</div>
				</div>
				<?php 
if(isset($plan_data_all) && $plan_data_all !='' && is_array($plan_data_all) && count($plan_data_all)>0)
{
	foreach($plan_data_all as $plan_data)
	{?>
				<div class="row mt-3">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<div class="design-process-content padding-0">
							<div class="box-view-profile">
								<p class="Poppins-Bold mega-n3 f-16"><span class="mega-n4 f-16"><?php echo $plan_data['plan_name'];?></span></p>
							</div>
							<hr class="hr-view">
							<div class="box-view-profile" style="padding:9px 12px;">
								<div class="row">
									<div class="col-md-8  col-xs-12 col-sm-12">
										<div class="col-md-4 col-xs-6 col-sm-4">
											<h5 class="color-profile Poppins-Semi-Bold f-13">Plan Duration</h5>
											<span class="Poppins-Semi-Bold f-15"><?php echo $plan_data['plan_duration'].' Days'; ?></span>
										</div>
										<div class="col-md-4 col-xs-6 col-sm-4">
											<h5 class="color-profile Poppins-Semi-Bold f-13">Plan Activated On</h5>
											<span class="Poppins-Semi-Bold f-15"><?php echo $this->common_model->displayDate($plan_data['plan_activated'],'F j, Y'); ?></span>
										</div>
										<div class="col-md-4 col-xs-6 col-sm-3 current-plan-brd">
											<h5 class="color-profile Poppins-Semi-Bold f-13">Plan Expired On</h5>
											<span class="Poppins-Semi-Bold f-15 color-d"><?php echo $this->common_model->displayDate($plan_data['plan_expired'],'F j, Y'); ?></span>
										</div>
										
										<div class="">
											<div class="col-md-4 col-xs-6 col-sm-4 mt-4 mr-0">
												<h5 class="color-profile Poppins-Semi-Bold f-13">Allowed Chat</h5>
												<span class="Poppins-Semi-Bold f-15"><?php echo $plan_data['chat']; ?></span>
											</div>
											<div class="col-md-8 col-xs-6 col-sm-8 mt-4 mr-0">
												<h5 class="color-profile Poppins-Semi-Bold f-13">Allowed Message ( Remaining )</h5>
												<span class="Poppins-Semi-Bold f-15"><span class="color-d Poppins-Semi-Bold f-15"><?php echo ($plan_data['message'] - $plan_data['message_used'])?></span><?php echo ' out of '.$plan_data['message']; ?></span>
											</div>
										</div>
										
										
									</div>
									
									<div class="col-md-4 col-xs-12 col-sm-12">
										<!--<h5 class="color-profile Poppins-Semi-Bold f-13">Marital Status</h5>
										<span class="Poppins-Semi-Bold f-15">N/A</span>-->
										<div class="row mr-top-mb mr-0">
											<div class="col-md-7 col-xs-7 col-sm-7">
												<h5 class="color-profile Poppins-Regular f-13">Plan Amount</h5>
											</div>
											<div class="col-md-5 col-xs-5 col-sm-5">
												<h5 class="color-profile Poppins-Semi-Bold f-14 color-3c"><?php echo $plan_data['currency'].' '.$plan_data['plan_amount']; ?></h5>
											</div>
										</div>
										<?php if(isset($plan_data['offer_per']) && $plan_data['offer_per'] > 0){?>
										<div class="row mr-0">
											<div class="col-md-7 col-xs-7 col-sm-7">
												<h5 class="color-profile Poppins-Regular f-13"><?php echo 'Offer('.$plan_data['offer_per'].'% Off)';?></h5>
											</div>
											<div class="col-md-5 col-xs-5 col-sm-5">
												<h5 class="color-profile Poppins-Semi-Bold f-14 color-3c">
													<?php echo $plan_data['currency'].' '.($plan_data['plan_amount']*$plan_data['offer_per'])/100;?></h5>
											</div>
										</div>
										<?php } if(isset($plan_data['discount_amount']) && $plan_data['discount_amount'] > 0){?>
										<div class="row mr-0">
											<div class="col-md-7 col-xs-7 col-sm-7">
												<h5 class="color-profile Poppins-Regular f-13">Discount</h5>
											</div>
											<div class="col-md-5 col-xs-5 col-sm-5">
												<h5 class="color-profile Poppins-Semi-Bold f-14 color-3c"><?php
													if($plan_data['discount_amount'] !='' && $plan_data['discount_detail'] !='')
													{
														echo $plan_data['currency'].' '.$plan_data['discount_amount']; 
														if(isset($plan_data['discount_detail']) && $plan_data['discount_detail'] !='')
														{
															echo ' ('.$plan_data['discount_detail'].')';
														}
													}
													else
													{
														echo 'N/A';
													}
												?></h5>
											</div>
										</div>
										<?php } ?>
										<div class="row mr-0">
											<div class="col-md-7 col-xs-7 col-sm-7">
												<h5 class="color-profile Poppins-Regular f-13"><?php if($plan_data['tax_name'] !=''){ echo $plan_data['tax_name']; } else{ echo 'Tax';}
				?> (<?php echo $plan_data['tax_percentage'];?>%)</h5>
											</div>
											<div class="col-md-5 col-xs-5 col-sm-5">
											<h5 class="color-profile Poppins-Semi-Bold f-14 color-3c"><?php echo $plan_data['currency'].' '.number_format($plan_data['tax_amount'],2); ?></h5>
											</div>
										</div>
										
										<div class="row mr-0">
											<div class="col-md-7 col-xs-7 col-sm-7">
												<h5 class="color-profile Poppins-Regular f-13">Total Amount</h5>
											</div>
											<div class="col-md-5 col-xs-5 col-sm-5">
											<h5 class="color-profile Poppins-Semi-Bold f-14 color-3c"><?php echo $plan_data['currency'].' '.number_format($plan_data['grand_total'],2); ?></h5>
											</div>
										</div>
									</div> 
									
									<div class="col-md-12" style="margin-bottom:5px;">
										<div class="col-md-3 col-xs-12 col-sm-3 mt-4">
											<h5 class="color-profile Poppins-Semi-Bold f-13">View Profile ( Remaining )</h5>
											<span class="Poppins-Semi-Bold f-15"><span class="color-d Poppins-Semi-Bold f-15"><?php echo ($plan_data['profile'] - $plan_data['profile_used'])?></span><?php echo ' out of '.$plan_data['profile']; ?></span>
										</div>
										
										<!-- for designing  allow_contact 25/11/2021 start-->
										<div class="col-md-4 col-xs-12 col-sm-3 mt-4 allow_contact">
                                        <!-- for designing 25/11/2021 end-->
											<h5 class="color-profile Poppins-Semi-Bold f-13">Allowed Contacts ( Remaining )</h5>
											<span class="Poppins-Semi-Bold f-15"><span class="color-d Poppins-Semi-Bold f-15"><?php echo ($plan_data['contacts'] - $plan_data['contacts_used'])?></span><?php echo ' out of '.$plan_data['contacts']; ?></span>
										</div>
										<div class="col-md-5 col-xs-12 col-sm-3 mt-4">
											<span class="pull-right float-none"> 
												<?php if(isset($plan_data['current_plan']) && $plan_data['current_plan'] =='Yes')
		{?>
												<button onclick="window.location.href='<?php echo $base_url.'premium-member';?>'" class="mega-n-btn1 current-plan-btn  post-s-d Poppins-Regular color-f f-16">
													Upgrade Now
												</button>
		<?php }?>
												<button onclick="window.location.href='<?php echo $base_url.'premium-member/view-invoice/'.$plan_data['id'] ?>'" class="mega-n-btn1 current-plan-btn  post-s-d Poppins-Regular color-f f-16">
													View Invoice
												</button></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
	<?php }
}?>

			</div>
		</div>
	
<?php 
 $might_be='1';
include('my_dashboard_slider.php');?>


