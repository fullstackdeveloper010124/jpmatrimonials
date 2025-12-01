<style type="text/css">
	h1{
		margin-top: 0px !important;
	}
	h2{
		margin-top: 0px !important;
	}
</style>
		
	
		<div class="menu-bg-new">
			<div class="container-fluid new-width">
				<div class="row mt-50">
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
						<div class="box-main-s">
							<p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Membership Plan</span></p>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-lg hidden-md">
						<div class="box-main-s member-ship">
							<p class="Poppins-Semi-Bold mega-n3 f-s mb-0 mb-20-m pull-right float-left-n text-center-m">Payment<span class="mega-n4 f-s">Option</span></p>
							
						</div>
						<ul class="social-icons">
							<li><a href="#" class="social-icon social-icons-f"> 
							<i class="fas fa-check check-color"></i></a>
							</li>
							<li>
								<a href="#" class="social-icon social-icons-insta"> <i class="fas fa-cart-plus add-cart"></i></a>
							</li>
							<li>
								<a href="#" class="social-icon social-icons-g"> <i class="fab fa-cc-visa visa-color"></i></a>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 text-center">
						<div class="box-main-s member-ship">
							<h1 class="Poppins-Semi-Bold mega-n3 f-s mb-0 mb-10-m">Upgrade Membership<span class="mega-n4 f-s"> Plan</span></h1>
							<p class="hidden-sm hidden-xs">Select One Of the Packages below and pay using the payment
							method of your choice.</p>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
						<div class="box-main-s member-ship"><h2>
							<p class="Poppins-Semi-Bold mega-n3 f-s mb-0 pull-right float-left-n text-center-m">Payment<span class="mega-n4 f-s">Option</span></p></h2>
							
						</div>
						<ul class="social-icons">
							<li><a href="#" class="social-icon social-icons-f"> 
							<i class="fas fa-check check-color"></i></a>
							</li>
							<li>
								<a href="#" class="social-icon social-icons-insta"> <i class="fas fa-cart-plus add-cart"></i></a>
							</li>
							<li>
								<a href="#" class="social-icon social-icons-g"> <i class="fab fa-cc-visa visa-color"></i></a>
							</li>
						</ul>
					</div>
					
				</div>
			</div>
		</div>
		<div class="demo mt-5 pb-3">
			<div class="container-fulid new-width">
				<?php 
				$datetime_bg_arr = array(
					'','blue','green','purple'
				);
				$plan_sr = 0;
                $i=0;
                if(isset($membership_plans) && $membership_plans !='' && is_array($membership_plans) && $membership_plan_data_count > 0){
                    foreach($membership_plans as $membership_plan_item){  
						$displ_class = '';
						if(isset($datetime_bg_arr[$plan_sr]) && $datetime_bg_arr[$plan_sr] !=''){
							$displ_class = $datetime_bg_arr[$plan_sr];
						}
						$plan_sr++;
                        $data = '';
                        if($i==4){ 
                            $data='mt-5';
                        }
                        
						if($i==0){
							echo '<div class="row margin-zero pt-3">';
						}
						else if($i%4==0){
							echo '</div><div class="clearfix"></div><div class="row margin-zero mt-5">';
						}
						if($i=='3' || $i=='6'){
							$plan_sr = 0;
						}
                        ?>
					<div class="col-md-3 col-sm-6">
						<div class="pricingTable <?php if($displ_class !=''){ echo $displ_class;} ?>">
							<div class="pricingTable-header">
								<div class="price-value">
									<span class="amount"><?php if(isset($membership_plan_item['plan_amount_type'])){echo $membership_plan_item['plan_amount_type'];}?> <?php if(isset($membership_plan_item['plan_amount'])){echo $membership_plan_item['plan_amount'];}?></span>
									<span class="month"><?php if(isset($membership_plan_item['plan_name'])){echo $membership_plan_item['plan_name'];}?></span>
								</div>
							</div>
							<div class="icon">
							<?php if(isset($membership_plan_item['plan_amount_type']) && $membership_plan_item['plan_amount_type']!='' && ($membership_plan_item['plan_amount_type'] == 'USD' || $membership_plan_item['plan_amount_type'] == 'CAD' || $membership_plan_item['plan_amount_type'] == 'D')){ 
									echo '<i class="fas fa-dollar-sign"></i>';
								}
								elseif(isset($membership_plan_item['plan_amount_type']) && $membership_plan_item['plan_amount_type']!='' && $membership_plan_item['plan_amount_type'] == 'JPY'){
									echo '<i class="fas fa-yen-sign"></i>';
								}
								elseif(isset($membership_plan_item['plan_amount_type']) && $membership_plan_item['plan_amount_type']!='' && $membership_plan_item['plan_amount_type'] == 'GBP'){
									echo '<i class="fas fa-pound-sign"></i>';
								}
								else{
									echo '<i class="fas fa-rupee-sign"></i>';
								}?>								
							</div>
							<div class="pricing-content">
								<!--<h3 class="title">Standard</h3>-->
								<ul>
									<li> Duration / <?php if(isset($membership_plan_item['plan_duration'])){echo $membership_plan_item['plan_duration'];}?>
									</li>
									<li>Contact / <?php if(isset($membership_plan_item['plan_contacts'])){echo $membership_plan_item['plan_contacts'];}?></li>
									<li>View Profile / <?php if(isset($membership_plan_item['profile'])){echo $membership_plan_item['profile'];}?></li>
									<li> Live Chat / <?php if(isset($membership_plan_item['chat'])){echo $membership_plan_item['chat'];}?></li>
									<li>Personal Message / <?php if(isset($membership_plan_item['plan_msg'])){echo $membership_plan_item['plan_msg'];}?></li>
								</ul>
								<?php
							if(isset($membership_plan_item['plan_amount']) &&$membership_plan_item['plan_amount'] > 0){
						?>
								<a href="<?php echo $base_url; ?>premium-member/buy-now/<?php if(isset($membership_plan_item['id'])){echo $membership_plan_item['id'];}?>" class="pricingTable-signup"> Buy Plan</a>
						<?php }else{?>
							<a href="<?php echo $base_url; ?>contact/admin" class="pricingTable-signup"> Contact To Admin</a>
						<?php }?>
							</div>
						</div>
					</div>
				<?php if($i==count($membership_plans)-1){
					echo '</div>';
				}
				$i++;
			}
		}else { ?>	
            <div class="no-data-f">
                <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
            </div>
		<?php }?>
	</div>
</div>
			
<?php
	$this->common_model->js_extra_code_fr.="
$('.button-wrap').on('click', function(){
		$(this).toggleClass('button-active');
	});
	var markup ='<style>.cstm-logo{padding: 0px 0px !important;position: relative!important;}</style>';
		$('head').append(markup);
	";
?>
		
		