<?php
	if($this->router->fetch_method() == 'payment_option')
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		$current_login_user = $this->common_front_model->get_session_data();

		$selected_plan = $plan_data['plan_data_array'];

		if(isset($selected_plan) && $selected_plan != '' && is_array($selected_plan) && count($selected_plan) > 0)
		{
			$plan = $selected_plan['id'];
			$plan_name = $selected_plan['plan_name'];
			$plan_amount = $selected_plan['plan_amount'];
			$plan_amount_type = $selected_plan['plan_amount_type'];
			$plan_duration = $selected_plan['plan_duration'];
			$plan_contacts = $selected_plan['plan_contacts'];
			$profile = $selected_plan['profile'];
			$plan_msg = $selected_plan['plan_msg'];
		}

		$matri_id = $username = $address = $mobile = $email = '';
		$where_arra='';
		if(isset($insert_id) && $insert_id != ''){
			$where_arra=array('id'=>$insert_id);
		}
		if(isset($current_login_user['id']) && $current_login_user['id'] != ''){
			$where_arra=array('id'=>$current_login_user['id']);
		}

		if(isset($where_arra) && $where_arra!=''){
			$member_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
			if(isset($member_data) && $member_data != ''){
				$matri_id = $member_data['matri_id'];
				$email = $member_data['email'];
				$username = $member_data['username'];
				$address = $member_data['address'];
				$mobile = '';
				if($member_data['mobile'] !='')
				{
					$mo_arr = explode('-',$member_data['mobile']);
					if(isset($mo_arr) && $mo_arr!='' && is_array($mo_arr) && count($mo_arr)>1)
					{
						$mobile = $mo_arr[1];
					}
					else
					{
						$mobile = $member_data['mobile'];
					}
				}
			}
		}
		$ccavenue = $this->common_model->get_count_data_manual('payment_method'," name = 'CCAvenue' ",1,'*','','','',"");
		$paypal = $this->common_model->get_count_data_manual('payment_method'," name = 'Paypal' ",1,'*','','','',"");
		$payumoney = $this->common_model->get_count_data_manual('payment_method'," name = 'PayUmoney' ",1,'*','','','',"");
		$payubizz = $this->common_model->get_count_data_manual('payment_method'," name = 'Paybizz' ",1,'*','','','',"");
		$BankDetails = $this->common_model->get_count_data_manual('payment_method'," name = 'BankDetails' ",1,'*','','','',"");
		$instamojo = $this->common_model->get_count_data_manual('payment_method'," name = 'Instamojo' ",1,'*','','','',"");
		$RazorPay = $this->common_model->get_count_data_manual('payment_method'," name = 'RazorPay' ",1,'*','','','',"");

		$cancel_return = $base_url.'premium-member/payment-status/fail';
	}
?>
<div id='main_div'>
<?php
if($this->router->fetch_method() == 'buy_now' || $this->router->fetch_method() == 'check_coupan')
{

	$plan_id = $plan_data['id'];
	$display_detail ='No';
	$plan_data_count = count($plan_data);
	$config_data = $this->common_model->get_site_config();

	if(isset($plan_data) && $plan_data !='' && $plan_data_count > 0)
	{
		$display_detail ='Yes';
	}
	if(isset($plan_data['id']))
	{
		$plan_id = $plan_data['id'];
	}
	if(isset($plan_data['plan_name']))
	{
		$plan_name = $plan_data['plan_name'];
	}
	if(isset($plan_data['plan_amount_type']))
	{
		$plan_amount_type = $plan_data['plan_amount_type'];
	}
	if(isset($plan_data['plan_amount']))
	{
		$plan_amount = $plan_data['plan_amount'];
	}

	if(isset($display_detail) && $display_detail =='Yes')
		{
			$discount_amt = 0;
			$discount_display = 'No';
			$coupan_code = '';
			$coupan_data = $this->session->userdata('coupan_data_reddem');
			if(isset($coupan_data) && $coupan_data !='' && count($coupan_data) > 0)
			{
				$discount_display = 'Yes';
				if(isset($coupan_data['discount_amount']) && $coupan_data['discount_amount'] !='')
				{
					$discount_amt = $coupan_data['discount_amount'];
				}
				if(isset($coupan_data['coupan_code']) && $coupan_data['coupan_code'] !='')
				{
					$coupan_code = $coupan_data['coupan_code'];
				}
			}

			$service_tax = 0;
			$service_tax_amt = 0;
			$service_tax_per = '';
			$tax_name = '';

			if(isset($config_data['tax_applicable']) && $config_data['tax_applicable']== 'Yes')
			{
				$service_tax_per = $config_data['service_tax'];
				$tax_name = $config_data['tax_name'];

				if(isset($config_data['service_tax']) && $config_data['service_tax'] !='')
				{
					$service_tax =  $config_data['service_tax'];
				}
				if($plan_amount !='' && $plan_amount > 0 && $service_tax !='' && $service_tax > 0 )
				{
					$service_tax_amt = (($plan_amount - $discount_amt) * $service_tax) / 100;
				}
			}

			$total_pay = ($plan_amount - $discount_amt) + $service_tax_amt;

			$data_array = array('discount_amount'=>$discount_amt,'coupan_code'=>$coupan_code,'plan_id'=>$plan_id,'service_tax'=>$service_tax_amt,'plan_amount'=>$plan_amount,'total_pay'=>$total_pay,'plan_data_array'=>$plan_data);
			/*echo "<pre>";
			print_r($data_array);
			echo "</pre>";*/
			$this->session->set_userdata('plan_data_session',$data_array);
		}
	}
?>

		<div class="menu-bg-new">
			<div class="container-fluid new-width">
				<div class="row mr-top-26  mt-50">
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
						<div class="box-main-s">
							<p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span>
							<span class="color-68">Payment Option</span></p>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-lg hidden-md">
						<div class="box-main-s member-ship">
							<p class="Poppins-Semi-Bold mega-n3 f-s mb-0 mb-20-m pull-right float-left-n text-center-m">Plan Details And Payment<span class="mega-n4 f-s">Overview</span></p>

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
							<p class="Poppins-Semi-Bold mega-n3 f-2-p mb-0 mb-10-m">Plan Details And Payment<span class="mega-n4 f-2-p"> Overview</span></p>

						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
						<!--<div class="box-main-s member-ship">
							<p class="Poppins-Semi-Bold mega-n3 f-s mb-0 pull-right float-left-n text-center-m">Payment<span class="mega-n4 f-s">Option</span></p>

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
						</ul>-->
					</div>
				</div>
			</div>
		</div>
		<?php if($this->router->fetch_method() == 'payment_option'){
			$col="12";
			$design ="<div class='e-detail-box prld-zero'>
			<h3 class='text-center Poppins-Semi-Bold font-size-20' style='padding: 18px 0px 6px;'>";
		}
		else{
			$col="8";
			$design = '<div class="mega-box-new prld-zero">
			<h3 class="text-center Poppins-Semi-Bold font-size-20">';
		}?>
		<div class="container new-width">
			<div class="row mt-3">
				<div class="col-md-<?php echo $col;?> col-sm-12 col-xs-12">
					 <?php echo $design;?>SELECTED PLAN - <?php echo $plan_name;?></h3>
						<hr class="hr-plan"/>
						<div class="box-center">
							<div class="row">
								<?php if($this->router->fetch_method() == 'payment_option'){?>
								<?php
                        $i=1;
						$path_payment_logo = $this->common_model->path_payment_logo;
						if(isset($payment_methods) && $payment_methods!='' && is_array($payment_methods) && count($payment_methods)>0){
							foreach($payment_methods as $row_method){
								if(isset($row_method['logo']) && $row_method['logo'] !='' && file_exists($path_payment_logo.$row_method['logo'])){
									$payment_logo = $base_url.$path_payment_logo.$row_method['logo'];
								}
								else{
									$payment_logo = '';
								}
								if($i == 1){
									$active = 'active';
								}else{
									$active = '';
								}
								$half = ceil(count($payment_methods)/2);
								if($i == 1 && count($payment_methods) == 3){
									echo '<div class="col-md-4 col-xs-12 col-sm-12"><div class="box-new">';
								}
								else{
									if($i == 1){
										echo '<div class="col-md-4 col-xs-12 col-sm-12"><div class="box-new">';
									}
									else if($i%3 == 1){
										echo '</div></div><div class="col-md-4 col-xs-12 col-sm-12"><div class="box-new">';
									}
								}
								$payment_array[] = $row_method['name'];
								?>
								<div class="row">
									<div class="box-new-padding">
										<div class="col-md-3 col-xs-2 col-sm-2">
											<div class="radio-item Poppins-Medium f-16 mr-zero">
												<input type="radio" id="<?php echo $row_method['name'];?>" name="ritem" value="ropt1" <?php if($active!=''){echo 'checked';}?> >
												<label for="<?php echo $row_method['name'];?>" class="<?php echo $active;?> color-d fr-12"></label>
											</div>
										</div>
										<div class="col-md-9 col-xs-10 col-sm-10">
											<label for="<?php echo $row_method['name'];?>" class="<?php echo $active;?> color-d fr-12">
											<?php
											if(isset($payment_logo) && $payment_logo!= ''){?>
												<img src="<?php echo $payment_logo;?>" alt="payment logo">
											<?php
												}else{
													echo $row_method['name'];
												}
											?></label>
										</div>
									</div>
								</div>
								<hr class="hr-p" style="margin-bottom:0px;">
								<?php if($i == count($payment_methods)){
										echo '</div></div>';
									}
									$i++;
								}
							}
						}
						if($this->router->fetch_method() == 'buy_now' || $this->router->fetch_method() == 'check_coupan'){?>
							<div class="col-md-12 col-xs-12 col-sm-12">
								<form id="payment-form" method="POST" action="javascript:void(0);">
									<div class="box-new new-width-plan">
										<div class="box-new-padding-2">
											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color">Plan Amount</p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold"><?php echo $plan_amount_type.' '.$plan_amount;?></p>
												</div>
											</div>
											<?php if(isset($discount_display) && $discount_display !='' && $discount_display =='Yes'){?>
											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color">Discount Amount</p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold" style="word-break: break-all;"><?php echo $plan_amount_type.' '.$discount_amt. ' ('.$coupan_code.')'; ?></p>
												</div>
											</div>
											<?php
												}
												if($service_tax_amt !='' && $service_tax_amt > 0){
											?>
											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color"><?php echo $tax_name;?>(<?php echo $service_tax_per;?>%)</p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold"><?php echo $plan_amount_type.' '.$service_tax_amt;?></p>
												</div>

											</div>
											<?php
												}
											   ?>

											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color">Total Payable Amount</p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold" style="color:#1ece10;"><?php echo $plan_amount_type.' '.$total_pay; ?></p>
												</div>

											</div>

										</div>
										<hr class="hr-2-p"/>

										<div class="box-new-padding-2">
										<?php
						if(isset($discount_display) && $discount_display !='' && $discount_display =='No' && $total_pay > 0)
						{
				?>
											<div class="row">
												<div class="col-md-8 col-sm-7 col-xs-6">
													<input type="text" class="form-control" placeholder="Coupon Code" name="couponcode" id="couponcode" value="">
													<span id="err_couponcode" class="text-danger"></span>
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<div class="add-w-btn-new-r">
													<a href="javascript:;" onclick="return check_coupan_code()" class="Poppins-Medium color-f f-16">Redeem</a>
													</div>
												</div>

											</div>
											<?php } ?>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">

														<div class="">
															<button onClick="process_checkout()" class="mega-n-btn1 pay-now-2 subscribe Poppins-Medium color-f f-16" type="button">Pay Now</button>
														</div>

												</div>
											</div>
											<div class="row" style="display:none;">
												<div class="col-md-12 col-sm-12 col-xs-12">
													<p class="payment-errors"></p>
												</div>
											</div>
										</div>
                                	</div>
                                </form>
                            </div>
						<?php }
						else {
							if(isset($payment_methods) && $payment_methods!='' && is_array($payment_methods) && count($payment_methods)>0){
							?>
						<div class="col-md-6 col-xs-12 col-sm-12">
									<div class="box-new new-width-plan">
										<div class="box-new-padding-2">
											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color">Plan </p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold"><?php echo $plan_name;?></p>
												</div>

											</div>
											<div class="row">
												<div class="col-md-6 col-sm-7 col-xs-6">
													<p class="Poppins-Medium plan-color">Plan Amount</p>
												</div>
												<div class="col-md-1 col-sm-1 col-xs-1 hidden-sm hidden-xs">
													:
												</div>
												<div class="col-md-4 col-sm-4 col-xs-6 text-right">
													<p class="Poppins-Semi-Bold" style="color:#1ece10;"><?php echo $plan_amount_type.' '.$plan_data['total_pay'];?></p>
												</div>

											</div>

										</div>
										<hr class="hr-2-p">
										<?php if(isset($payment_array) && $payment_array!='' && is_array($payment_array) && count($payment_array)>0){?>
										<div class="box-new-padding-2">
											<?php
											if(isset($plan_amount_type) && $plan_amount_type=='INR')
											{
											 $for_paypal_inr_to_usd = ($plan_data['total_pay']/73);
											}
											else
											{
												$for_paypal_inr_to_usd = $plan_data['total_pay'];
											}
											 ?>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">

													<div style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='Paypal'){ echo 'block';}else{echo 'none';}?>" id='Paypal_form'>
														<form action="https://www.paypal.com/cgi-bin/webscr" name="frmPayPal1" id="frmPayPal1" method="post" class="" onSubmit="return payment_paypal();">
															<input type="hidden" name="business" value="<?php echo $paypal['email_merchant_id']; ?>">
															<input type="hidden" name="cmd" value="_xclick">
															<input type="hidden" name="item_name" value="Membership Plan <?php echo $for_paypal_inr_to_usd;?> Purchase">
															<input type="hidden" name="item_number" value="1">
															<input type="hidden" name="credits" value="510">
															<input type="hidden" name="userid" value="1">
															<input type="hidden" name="amount" value="<?php echo $for_paypal_inr_to_usd;?>">
															<input type="hidden" name="no_shipping" value="1">
															<input type="hidden" name="currency_code" value="USD">
															<input type="hidden" name="handling" value="0">
															<input  type="hidden" name="notify_url" value="SUCCESS_URL" />
 															<input type="hidden" name="rm" value="2">
															<input type="hidden" name="cancel_return" class="cancel_URL" value="<?php echo $cancel_return;?>" />
															<input type="hidden" name="return" class="success_URL" value="<?php echo $base_url.'premium-member/payment-status/Paypal';?>" />
															<button type="submit" name="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16" title="PayPal - The safer, easier way to pay online!">Pay Now
															</button>
															<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
														</form>
													</div>

													<div style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='Paybizz'){ echo 'block';}else{echo 'none';}?>" id='Paybizz_form'>
														<form action="<?php echo $base_url;?>premium-member/payubizz" method="post" name="frmPayUbizz" id="frmPayUbizz" onSubmit="return payment_payubizz();">
														<input type="hidden" name="business" value="<?php echo $payubizz['email_merchant_id'];?>">
														<input type="hidden" name="cmd" value="_xclick">
														<input type="hidden" name="item_name" value="Membership Plan <?php echo $plan_name;?> Purchase">
														<input type="hidden" name="item_number" value="1">
														<input type="hidden" name="credits" value="510">
														<input type="hidden" name="userid" value="1">
														<input type="hidden" name="amount" value="<?php echo $plan_data['total_pay'];?>">
														<input type="hidden" name="no_shipping" value="1">
														<input type="hidden" name="currency_code" value="INR">
														<input type="hidden" name="handling" value="0">

														<button type="submit" name="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16" title="Paybizz - The safer, easier way to pay online!">Pay Now
														</button>

														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
														</form>
													</div>
													<div style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='PayUmoney'){ echo 'block';}else{echo 'none';}?>" id='PayUmoney_form'>
														<form action="<?php echo $base_url;?>premium-member/payumoney" method="post" name="frmPayPal1">

														<input type="hidden" name="plan_name" value="<?php echo $plan_name;?>">
														<input type="hidden" name="plan_amount" value="<?php echo $plan_data['total_pay'];?>">
														<input type="hidden" name="plan_id" value="<?php echo $plan;?>">
														<input type="hidden" name="plan_amount_type" value="INR">
														<input type="hidden" name="service_provider" value="payu_paisa" size="64" >
														<input type="hidden" name="productinfo" value="<?php echo $plan_name;?>">

														<button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16" name="submit" title="PayUmoney - The safer, easier way to pay online!">Pay Now</button>

													</button>
														<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
														</form>
													</div>

													<div style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='CCAvenue'){ echo 'block';}else{echo 'none';}?>" id="CCAvenue_form">
														<form method="post" name="customerData1" id="customerData1" action="<?php echo $base_url;?>premium-member/ccav-request-handler" enctype="multipart/form-data" onSubmit="return payment_ccavenue();">
															<input type="hidden" name="merchant_id" value="<?php echo $ccavenue['email_merchant_id']; ?>"/>
															<input type="hidden" name="order_id" value="<?php echo $matri_id.'-'.$plan;?>"/>
															<input type="hidden" name="currency" value="INR"/>
															<input type="hidden" name="redirect_url" value="<?php echo $base_url.'premium-member/payment-status/CCAvenue';?>"/>
															<input type="hidden" name="cancel_url" value="<?php echo $cancel_return;?>"/>
															<input type="hidden" name="language" value="EN"/>
															<input type="hidden" name="billing_name" value="<?php echo $username;?>"/>
															<input type="hidden" name="billing_address" value="<?php echo $address;?>"/>
															<input type="hidden" name="billing_state" value="<?php echo '';?>"/>
															<input type="hidden" name="billing_zip" value="<?php echo '';?>"/>
															<input type="hidden" name="billing_country" value="<?php echo '';?>"/>
															<input type="hidden" name="billing_tel" value="<?php echo $mobile;?>"/>
															<input type="hidden" name="billing_email" value="<?php echo $email;?>"/>
															<input type="hidden" name="udf1" value="<?php echo $plan_name;?>"/>
															<input type="hidden" name="udf2" value="<?php echo $plan;?>"/>
															<button type="submit" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16" title="CCAvenue - The safer, easier way to pay online!">Pay Now</button>

															<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
														</form>
													</div>
                                                    <div style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='RazorPay'){ echo 'block';}else{echo 'none';}?>" id="RazorPay_form">
                                                    	<button onClick="process_checkout_razorpay()" class="mega-n-btn1 pay-now-2 Poppins-Medium color-f f-16" title="Razorpay - The safer, easier way to pay online!">Pay Now</button>
													</div>
													<a href="<?php echo $base_url.'premium-member/instamojo';?>" style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='Instamojo'){ echo 'block';}else{echo 'none';}?>" id="Instamojo_form">
														<div class="mega-n-btn1 pay-now-2">
															<div class="Poppins-Medium color-f f-16 ">Pay Now</div>
														</div>
													</a>
													<div id='BankDetails_form' style="display:<?php if(isset($payment_array) && $payment_array!='' && $payment_array[0]=='BankDetails'){ echo 'block';}else{echo 'none';}?>">
														<div class="basic_details"><?php echo nl2br($BankDetails['description']);?> </div>
													</div>
												</div>
											</div>
										</div>
										<?php }?>
									</div>
								</div>
						<?php }else{?>
							<div class="box-center-event">
								<div class="alert alert-danger text-center">Not Available Any Payment Option</div>
							</div>
						<?php }}?>

							</div>
						</div>
					</div>
				</div>
				<?php if($this->router->fetch_method() == 'buy_now' || $this->router->fetch_method() == 'check_coupan'){?>
				<div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
					<div class="mega-box-new bg-new-post">
					<h3 class="text-center h2-pb">Plan Benefits</h3>
					<hr class="p-b">
					<div class="line-dot">
                        <ul class="checkout-sidebar">
						<!-- <i class="fas fa-times"></i> -->
						<?php
							$check_yes = '<i class="fas fa-check"></i>';
							$check_no = '<i class="fas fa-times"></i>';
							$displ_yes_no_mess = '';
							$displ_yes_no_contact = '';
							$displ_yes_no_profile = '';
							if(isset($plan_data['plan_msg']) && $plan_data['plan_msg'] !='' && $plan_data['plan_msg'] > 0)
							{
								$displ_yes_no_mess = $check_yes;
							}
							else
							{
								$displ_yes_no_mess = $check_no;
							}
							if(isset($plan_data['plan_contacts']) && $plan_data['plan_contacts'] !='' && $plan_data['plan_contacts'] > 0)
							{
								$displ_yes_no_contact = $check_yes;
							}
							else
							{
								$displ_yes_no_contact = $check_no;
							}
							if(isset($plan_data['profile']) && $plan_data['profile'] !='' && $plan_data['profile'] > 0)
							{
								$displ_yes_no_profile = $check_yes;
							}
							else
							{
								$displ_yes_no_profile = $check_no;
							}
							if(isset($plan_data['chat']) && $plan_data['chat'] =='Yes')
							{
								$displ_yes_no_chat = $check_yes;
							}
							else
							{
								$displ_yes_no_chat = $check_no;
							}
							if(isset($plan_data['plan_duration']) && $plan_data['plan_duration'] !='' && $plan_data['plan_duration'] > 0)
							{
								$displ_yes_no_duration = $check_yes;
							}
							else{
								$displ_yes_no_duration = $check_no;
							}
							/*if(isset($plan_data['video']) && $plan_data['video'] =='Yes')
							{
								$displ_yes_no_video = $check_yes;
							}
							else
							{
								$displ_yes_no_video = $check_no;
							}*/
						?>
                            <li class="Poppins-Medium f-18 color-f">

                                <a href="#" style="padding-left: 0px;">
								<?php echo $displ_yes_no_mess.'&nbsp;&nbsp;&nbsp; Allowed Message - '.$plan_data['plan_msg']; ?>
                                </a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="#" style="padding-left: 0px;">
								<?php echo $displ_yes_no_contact.'&nbsp;&nbsp;&nbsp; Allowed Contacts - '.$plan_data['plan_contacts']; ?>
                                </a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="#" style="padding-left: 0px;">
								<?php echo $displ_yes_no_profile.'&nbsp;&nbsp;&nbsp; Allowed View Profiles - '.$plan_data['profile']; ?>
                                </a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="#" style="padding-left: 0px;"><?php echo $displ_yes_no_chat.'&nbsp;&nbsp;&nbsp;&nbsp; Live Chat '; ?>
                                </a>
                            </li>
                            <li class="Poppins-Medium f-18 color-f check-shape mt-2">
                                <a href="#" style="padding-left: 0px;"><?php echo $displ_yes_no_duration.' ';?>&nbsp;&nbsp;&nbsp;Plan Duration - <?php if(isset($plan_data['plan_duration'])){echo $plan_data['plan_duration'];}?> Days</a></li>
                            </ul>
                        </div>
					</div>
				</div>
			<?php }?>
        </div>
    </div>
</div>
<?php
if($this->router->fetch_method() == 'buy_now' || $this->router->fetch_method() == 'check_coupan')
{?>
		<form action="<?php echo $base_url.'premium-member/payment-option';?>" method="post" id="plan_submit" name="plan_submit">
	<input type="hidden" name="plan_id" id="plan_id" value="<?php echo $plan_id; ?>" />
     <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
       <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
       <input type="hidden" name="is_post" id="is_post" value="1" />
</form>
<?php } ?>
<style>
.razorpay-payment-button{
	display:none !important;
}
</style>
<form action="<?php echo $base_url.'premium-member/razorpay';?>" method="post" id="razorpay_submit" name="razorpay_submit">
    <input type="hidden" name="plan_id" id="plan_id" value="<?php if(isset($plan) && $plan!=''){echo $plan;}else if(isset($plan_id) && $plan_id!=''){echo $plan_id;}?>" >
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" >
    <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="<?php if(isset($RazorPay['key']) && $RazorPay['key']!=''){echo $RazorPay['key'];}?>" data-amount="<?php echo $plan_amount * 100;?>" data-name="muhoorthammatrimony" data-image='<?php echo $base_url;?>assets/logo/5ddc56d275ddbdf0a3baffd892abe5c1.png'; data-theme.color="#ff7e00"></script>
</form>

<?php
$this->common_model->js_extra_code_fr .="
	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:'100%'}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	}
	$('.button-wrap').on('click', function(){
		$(this).toggleClass('button-active');
	});
	function process_checkout_razorpay()
	{
		$('#razorpay_submit').submit();
	}
	function process_checkout()
	{
		$('#plan_submit').submit();
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
						$('#main_div').html(data.message);
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
	$('.button-wrap').on('click', function(){
		$(this).toggleClass('button-active');
	});

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

$('input[name = ritem]').change(function(){
	$('input[name = ritem]').each(function(i) {
		var id = $(this).attr('id');
		document.getElementById(id+'_form').style.display = 'none';
	});
	if( $(this).is(':checked') ){
		var id = $(this).attr('id');
		document.getElementById(id+'_form').style.display = 'block';
	}
});
";
?>
