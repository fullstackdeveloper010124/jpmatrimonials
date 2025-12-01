

<?php
echo"<pre>";
	print_r($event_payment_data);
	echo"</pre>";
	//echo $no_of_ticket;
?><!------------------<div class="container">----Start------------------------------------>
	<div class="container margin-top-20 padding-lr-zero-xs">
		<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-xs">
			<div class="">
				<img src="<?php echo $base_url; ?>assets/front_end/images/icon/adv-upgrade.jpg" class="full-width img-thumbnail" alt=""/> 
			</div>
		</div>
	<div class="xxl-16 xl-16 m-16 l-16 xs-16 s-16 margin-top-10 padding-lr-zero-xs">
		<div class="">      
			<div class="xxl-12 xl-12 l-16 s-16 m-16 xs-16 margin-top-10px bg-border" style="padding:4px;">
				<h3 class="upgrade-heading margin-top-0px font-18 text-white  text-center" style="padding:5px;">
					<img src="<?php echo $base_url; ?>assets/front_end/images/icon/yes-remark.png" alt="" class="margin-right-5" />
					<span class="ne_mrg_ri8_10 ">Pay Now</span>
				</h3>
				<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 font-size-14 margin-top-5px">	
					<h3 class="text-left"> Event - Payment (Continue..)  </h3>		
					<h4 class="text-grey font-13">Once you make the payment, your ticket will be confirmed</h4>
					<table>
						<td class="bg-white padding-0-5-xs">
							<fieldset>
								<legend class="text-darkgrey">Payment Methods<br></legend>
								<table>
									<thead>
										<tr style="border:2px solid #ddd;" class="upgrade-heading">
											<th class="font-14 bold text-white" style="border:2px solid #ddd;">Description</th>
											<th class="font-14 bold text-white">Amount</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td class="col-md-9 text-left">Payment for August 2016</td>
											<td class="col-md-3 text-right"><i class="fa fa-inr"></i> 15,000/-</td>
										</tr>
										<tr>
											<td class="col-md-9 text-left">Payment for June 2016</td>
											<td class="col-md-3 text-right"><i class="fa fa-inr"></i> 6,00/-</td>
										</tr>
										<tr>
											<td class="col-md-9 text-left">Payment for May 2016</td>
											<td class="col-md-3 text-right"><i class="fa fa-inr"></i> 35,00/-</td>
										</tr>
										<tr style="bg-light-grey">
											<td class="text-right">
												<h4 class="text-red">
													<strong>Total Payment : </strong>
												</h4>
											</td>
											<td >
												<h4 class="text-red">
													<strong ><i class="fa fa-inr"></i> 65,500/-</strong>
												</h4>
											</td>
										</tr>
									</tbody>
								</table>
							</fieldset>
							<a href="#" class="btn btn-success btn-lg" role="button"><i class="fa fa-check"></i> Pay Now</a>
						</td>	
					</table>		
				</div>
			</div>
			
			<div class="xxl-4 xl-4 xs-16 m-16 s-16 l-5 margin-bottom-15px hidden-xs hidden-sm" style="padding:4px;">
				<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 margin-left-10" style="box-shadow: none;">
					<div class="row">
					<img src="<?php echo $base_url; ?>assets/front_end/images/icon/bg-blue.gif" class="text-center img-responsive" style="position:absolute;border:1px solid #ddd;border-radius:3px;padding:4px;background:#fff;" alt=""/>
						<ul class="upgrade_benfits margin-top-30" style="position:relative;padding:5px;">
							<li>Send Emails directly</li>
							<li>Connect instantly via Shaadi Chat</li>
							<li>Initiate Calls / Send SMS</li>
							<li>Access detailed Profiles</li>
							<li>Get Noticed by more Members</li>
							<li>Send Emails directly</li>
							<li>Connect instantly via Shaadi Chat</li>
							<li>Initiate Calls / Send SMS</li>
							<li>Access detailed Profiles</li>
							<li>Get Noticed by more Members</li>
						</ul>
					</div>
				</div>
			</div>
			
			<div class="xxl-4 xl-4 xs-16 m-16 s-16 l-5 margin-bottom-15px margin-top-30px margin-top-10-xs" style="padding:4px;">
				<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999 margin-top-20px margin-top-10-xs" style="box-shadow: none;">
					<!--<div class="row" style="padding:0px;">
						<a href="#" target="_blank">
							<img src="<?php //echo $base_url; ?>assets/front_end/images/icon/app-promo.jpg" class="bg-border text-center hidden-sm hidden-xs img-responsive" alt=""/>
						</a>
					</div>-->
				</div>
			</div>
		</div>
	</div>
</div>
	
	<div class="clearfix"></div>
<!------------------<div class="container">----End------------------------------------>
	<div class="margin-top-30"></div>
<?php
	$this->common_model->js_extra_code_fr.="
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
	}); ";
?>