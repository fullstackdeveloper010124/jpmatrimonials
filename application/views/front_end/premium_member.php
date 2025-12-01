<div class="mt-4"></div>
<div class="container">
		<!-- left side -->
		
		<div class="col-md-8 col-sm-12 col-xs-12">
			<div class="membership-plan">
				<div class="tabbable-panel">
					<div class="tabbable-line">
						<ul class="nav nav-tabs">
							<?php if (!empty($plan_category)) {
								$classArr = array('royal-tab','luxury-tab','ultimate-tab');
								$i=0;
								foreach ($plan_category as $key => $value) {
									$categoryid = strtolower(str_replace(' ','',trim($value["category_name"])));
									$category_name = $value["category_name"];
									$extra_text = $value["extra_text"];
									$active = '';
									if ($key == 0) {
										$active = 'active';
									}
									echo '<li class="'.$classArr[$i].' '.$active.'">
										<a href="#'.$categoryid.'" data-toggle="tab">
											'.$category_name.'
											<h4>'.$extra_text.'</h4>
										</a>
									</li>';
									$i++;
									if ($i==3) {
										$i=0;
									}
								 }
							}?>
						</ul>
						<div class="tab-content">
							<?php if (!empty($plan_category)) {
								$classArr = array('royal-plan','luxury-plan','ultimate-plan');
								$i=0;
								foreach ($plan_category as $key => $value) {
									
									$categoryid = strtolower(str_replace(' ','',trim($value["category_name"])));	
									$offer_text = $value["offer_text"];
									$active = '';
									if ($key == 0) {
										$active = 'active';
									}
								?>
							<div class="tab-pane <?php echo $active;?>" id="<?php echo $categoryid;?>">
								<div class="extra-days-free-box">
									<h4><span class="blink-text"><?php echo $offer_text;?></span></h4>
								</div>
								<?php 
								if (!empty($plan_category[$key]['plan_data'])) {
									
									foreach ($plan_category[$key]['plan_data'] as $planVal) {
										$plan_amount = $planVal['plan_amount'];	
										$discount_amount = $plan_amount - (($plan_amount*$planVal['offer_per'])/100);
										$perDayAmount = number_format($discount_amount/$planVal['plan_duration'],2);
										$slash = ($planVal['offer_per']==0)?0:1;
										?>
										<div class="mem-plan-main ">
											<div class="plan-selected planid_<?php echo $planVal['id'];?>">
												<p class="blink-text">You've been selected!</p>
											</div>
											<?php 
											$is_login = $this->common_front_model->checkLogin('return');
											if($is_login) {
											?>
											<div data-id="<?php echo $planVal['id'];?>" class="mem-plan-box <?php echo $classArr[$i];?> margin-top-20 <?php echo $categoryid.'_'.$planVal['id'];?> show-btn"
												onclick="pay_now_parameter('<?php echo $planVal['id'];?>','<?php echo $categoryid.'_'.$planVal['id'];?>')">
											<?php } else{ ?>
												<div class="mem-plan-box <?php echo $classArr[$i];?> margin-top-20 show-btn"
												onclick="window.location.replace('<?php echo $base_url.'login';?>');">
											<?php } ?>
												<div class="row">
													<div class="col-md-6 col-sm-12 col-xs-12">
														<div class="col-md-3 col-sm-3 col-xs-3 mem-plan-br">
															<i class="<?php echo $value['icon'];?>"></i>
														</div>
														<div class="col-md-4 col-sm-5 col-xs-5">
															<div class="mem-plan-title">
																<h3><?php echo $planVal['plan_name'];?></h3>
																<h6><?php echo $planVal['plan_duration'];?> Days</h6>
															</div>
														</div>
														<div class="col-md-5 col-sm-4 col-xs-4">
															<div class="mem-plan-offer">
																<h6><?php echo $planVal['offer_per'];?>% <span>off</span></h6>
															</div>
														</div>
													</div>
													<div class="col-md-6 col-sm-12 col-xs-12">
														<div class="row">
															<div class="col-md-7 col-sm-7 col-xs-7 text-center">
																<div class="plan-old-price">
																	<div class="price-wrapper">
																		<?php if($slash){ ?><div class="price-slash"></div><?php }?>
																		<h4><?php echo $planVal['plan_amount_type'];?> <span><?php echo $planVal['plan_amount'];?></span> </h4>
																	</div>
																	<img src="<?php echo $base_url;?>assets/images/plan-line.png" alt="plan line icon">
																	<h5><span> <?php echo $planVal['plan_amount_type'];?> <span><?php echo $perDayAmount;?></span> </span> per day</h5>
																</div>
															</div>
															<div class="col-md-5 col-sm-5 col-xs-5 text-right">
																<div class="plan-new-price">
																	<h3><?php echo $planVal['plan_amount_type'];?> <span><?php echo $discount_amount;?></span> </h3>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
								<?php 
									}
								}?>			
							</div>
							<?php 
									$i++;
									if ($i==3) {
										$i=0;
									}
								}
							}?>
						</div>
					</div>
				</div>
			</div>
			<!-- ----------payment options-------- -->
			<div class="upi-payment-bg hidden-sm hidden-xs margin-bottom-20" style="height:auto">
				<h3><i style="margin-right: 5px;" class="fas fa-qrcode"></i> Scan & Pay </h3>
				<hr>
				<div class="row">
				<?php 
					if (!empty($scan_pay)) {
						$i=0;
						foreach ($scan_pay as $key => $value) {
							if (isset($value["logo"]) && $value["logo"]!='' && file_exists($this->common_model->path_payment_logo.$value["logo"])) {
								$value["logo"] = $base_url.$this->common_model->path_payment_logo.$value["logo"];
							}
							if (isset($value["qr_code"]) && $value["qr_code"]!='' && file_exists($this->common_model->path_payment_logo.$value["qr_code"])) {
								$value["qr_code"] = $base_url.$this->common_model->path_payment_logo.$value["qr_code"];
							}
							echo '<div class="col-md-3 col-sm-12 col-xs-12 text-center">
									<div class="upi-pymnt-info upi-pymnt-info-bg">
										<img src="'.$value["logo"].'" alt="'.$value["upi_id"].'">
									</div>
									<div class="upi-code-scan-bg">
										<img src="'.$value["qr_code"].'" alt="'.$value["upi_id"].'">
									</div>
								</div>';
								$i++;
								if ($i==4) {
									$i=0;
									echo '</div><div class="row margin-top-20">';
								}
						}
					}
				?>
				</div>
			</div>
			<!-- ----------payment options end-------- -->
		</div>
		<!-- ------right side---- -->
		<div class="col-md-4 col-sm-12 col-xs-12 box222" id="planChange">
		</div>
		<div class="col-md-4 col-sm-12 col-xs-12">
			<!-- Offline Payment -->
			<div class="offline-payment">
				<h3><i style="margin-right: 3px;" class="fas fa-university"></i> Offline Payment </h3>
				<div class="row">
					<?php 
					if (!empty($offline_payment)) {
						foreach ($offline_payment as $key => $value) {
							if (isset($value["logo"]) && $value["logo"]!='' && file_exists($this->common_model->path_payment_logo.$value["logo"])) {
								$value["logo"] = $base_url.$this->common_model->path_payment_logo.$value["logo"];
							}
							?>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="bank-logo">
									<img src="<?php echo $value['logo'];?>">
								</div>
								<div class="bank-data-box">
									<p>
										<span>Account No.</span>
										<span>:</span>
										<span class="bank-r"><?php echo $value['account_no'];?></span>
									</p>
									<p>
										<span>Account Name</span>
										<span>:</span>
										<span class="bank-r"><?php echo $value['account_name'];?></span>
									</p>
									<p>
										<span>Account Type</span>
										<span>:</span>
										<span class="bank-r"><?php echo $value['account_type'];?></span>
									</p>
									<p>
										<span>IFSC Code</span>
										<span>:</span>
										<span class="bank-r"><?php echo $value['ifsc_code'];?></span>
									</p>
								</div>
							</div>
						<?php }
					}?>
					
				</div>
			</div>
			<!-- Offline Payment -->
		</div>
	</div>

	<?php 
	$this->common_model->js_extra_code_fr .= "
		function pay_now_parameter(id,class_id) {
			
			if($('.active-plan').data('id')!=id){
				$('.mem-plan-box').removeClass('active-plan');
				$('.' + class_id).addClass('active-plan');
				selected_paln(id);
			}
		}

		function process_checkout_razorpay()
		{
			$('#razorpay_submit').submit();
		}
		function process_checkout()
		{
			$('#plan_submit').submit();
		}

		function payment_option(method_name){
			$('.card').removeClass('active');
			$(this).addClass('active');
		}
		
		function payment_payubizz(){
			$('#frmPayUbizz').submit();
		}
		function payment_paypal(){
			$('#frmPayPal1').submit();
		}
		function payment_ccavenue(){
			$('#customerData1').submit();
		}

		function check_coupan_code()
		{
			$('#err_couponcode').html('');
			var couponcode = $('#couponcode').val();

			if(couponcode =='')
			{
				$('#err_couponcode').html('Please enter Coupon Code');
				$('#err_couponcode').slideDown();
			}
			else
			{
				var form_data = '';
				var hash_tocken_id = $('#hash_tocken_id').val();
				var plan_id = $('#plan_id').val();

				show_comm_mask();
				$.ajax({
				url: '".$base_url."premium-member/check-coupan',
				type: 'post',
				data: {'".$this->security->get_csrf_token_name()."':hash_tocken_id, 'plan_id':plan_id,'couponcode':couponcode},
				dataType:'json',
				success:function(data)
				{
					if(data.status =='success')
					{
							$('#planChange').html(data.message);
					}
					else
					{
							$('#err_couponcode').html(data.message);
							$('#err_couponcode').slideDown();
					}
					hide_comm_mask();
				}
				});
			}
			return false;
		}

		function selected_paln(plan_id)
		{
			
			$('#err_couponcode').html('');
			if(plan_id =='')
			{
				// $('.plan-selected').hide().css('opacity', 0);
				// $('.planid_'+plan_id).show().css('opacity', 1).css('background','#F3151C');
				// $('.planid_'+plan_id+' .blink-text').html('Something went wrong');
			}
			else
			{
				$('#planChange').hide();
				var hash_tocken_id = $('#hash_tocken_id').val();
				show_comm_mask();
				$.ajax({
				url: '".$base_url."premium-member/plan-details',
				type: 'post',
				data: {'".$this->security->get_csrf_token_name()."':hash_tocken_id, 'plan_id':plan_id},
				dataType:'json',
				success:function(data)
				{
					if(data.status =='success')
					{
						//$('.plan-selected').hide().css('opacity', 0);
						$('#planChange').html(data.html).slideDown();
						//$('.planid_'+plan_id).show().css('opacity', 1);
						//$('.planid_'+plan_id+' .blink-text').html(data.message);
					}
					else
					{
						// $('.plan-selected').hide().css('opacity', 0);
						// $('.planid_'+plan_id).show().css('opacity', 1).css('background','#F3151C');
						// $('.planid_'+plan_id+' .blink-text').html(data.message);
						if(data.redirectUrl!='' && data.redirectUrl!=undefined){
							window.location.replace(data.redirectUrl);
						}
					}
					hide_comm_mask();
				}
				});
			}
			return false;
		}
	";
	?>