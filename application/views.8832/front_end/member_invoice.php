<?php $dna = $this->common_model->data_not_availabel;
$base_url = base_url();
?>
		<style>
			.cstm-logo	{
			padding: 0px 0px !important;
			position: relative!important;
			top: -6px!important;
			}
			.Zebra_DatePicker_Icon {
			left: 174px !important;
			}
			.new-accordion {
			right: 0;
			width: 100%;
			}
			.row-new {
			display: -ms-flexbox;
			display: flex;
			-ms-flex-wrap: wrap;
			flex-wrap: wrap;
			/* margin-right: -15px;
			margin-left: -15px; */
			}
			.col {
			-ms-flex-preferred-size: 0;
			flex-basis: 0;
			-ms-flex-positive: 1;
			flex-grow: 1;
			max-width: 100%;
			}
		</style>
	<?php $logo_url = 'assets/front_end/images/logo/logo-3.png';
		if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !='')
		{
			$logo_url = 'assets/logo/'.$config_data['upload_logo'];
		}?>
		<div class="container-fluid new-width width-95 mt-60-pro">
			<div class="row-cstm">
				<div class="col-md-12 col-xs-12 col-sm-12 invoice-p-0">
					<div id="invoice">
						
						<div class="invoice overflow-auto">
							<div class="invoice-w">
								<header>
									<div class="row-new">
                                    	<!--<div class="col hidden-xs hidden-sm">-->
										<div class="mobile-invoice-logo">
											<a target="_blank" href="#">
												<img src="<?php echo $base_url.$logo_url;?>" alt="" class="" style="width: 60%;">
											</a>
										</div>
										<div class="col company-details">
											<h2 class="name hidden-xs">
												<a target="_blank" href="#">
												<?php echo $config_data['web_frienly_name'];?>
													
												</a>
											</h2>
											<div>Contact No : <?php echo $config_data['contact_no'];?></div>
											<div>Email : <?php echo $config_data['from_email'];?></div>
											
										</div>
									</div>
								</header>
								<main>
									<div class="row-new contacts">
										<div class="col invoice-to">
											<div class="text-gray-light">INVOICE TO:</div>
											<h2 class="to"><?php echo $payment_data['name'];?></h2>
											<div class="address"><?php echo $payment_data['address'];?></div>
											<div class="address">Mobile : <?php echo $payment_data['mobile'];?></div>
											<div class="email">Email : <a href="#"><?php echo $payment_data['email'];?></a></div>
										</div>
										<div class="col invoice-details">
											<div class="text-gray-light"><strong>Invoice</strong> : INV001<?php echo $payment_data['id'];?></div>
											<div class="date"><strong> Customer Id </strong>: <?php echo $payment_data['matri_id'];?></div>
											<div class="date"><strong>Payment Mode</strong> : <?php echo $payment_data['payment_mode'];?>
											</div>
										</div>
									</div>
									<div class="table-responsive">
									<table border="0" cellspacing="0" cellpadding="0">
										<thead>
											<tr>
											<th>Qty</th>
											<th class="text-left">Product</th>
											<th class="text-right">Activated On	</th>
											<th class="text-right">Expired On	</th>
											<th class="text-right">TOTAL</th>
										</tr>
										</thead>
										<tbody>
											<tr>
												<td class="no">01</td>
												<td class="text-left"><h3>
												<?php echo $payment_data['plan_name'];?> Membership for <?php echo $payment_data['plan_duration'];?> Days	
												</h3>
												
												</td>
												<td class="unit"><?php echo $this->common_model->displayDate($payment_data['plan_activated']);?></td>
												<td class="qty"><?php echo $this->common_model->displayDate($payment_data['plan_expired']);?></td>
												<td class="total"><?php echo $payment_data['currency'].' '.number_format($payment_data['plan_amount'],2);?></td>
											</tr>
										</tbody>
										<tfoot>
										<?php 
											if($payment_data['discount_detail'] !='' && $payment_data['discount_amount'] !='' && $payment_data['discount_amount'] > 0)
											{
										?>
										<tr>
											<td colspan="2"><b>&nbsp;</b></td>
											<td colspan="2"><b>Coupan Code (<?php echo $payment_data['discount_detail'];?>)</b></td>
											<td >-<?php echo $payment_data['currency'].' '.number_format($payment_data['discount_amount'],2);?></td>
										</tr>
										<?php 
											}
											if($payment_data['offer_per'] > 0){
												if(isset($payment_data['offer_per']) && $payment_data['offer_per'] != ''){
													$discounted_amount = ($payment_data['plan_amount'] * $payment_data['offer_per']) / 100;
														$plan_amount = $payment_data['plan_amount'] - $discounted_amount;
												?>
												<tr>
													<td colspan="3"><b>&nbsp;</b></td>
													<td><b>Discount </b></td>
													<td><?php echo $payment_data['currency']?> -<?php echo number_format($discounted_amount,2);?>(<?php echo $payment_data['offer_per'];?>%)</td>
												</tr>
												<?php }
												}
											$e = 0;
											if($payment_data['tax_name'] !='' && $payment_data['tax_amount'] !='' && $payment_data['tax_percentage'] !='')
											{
										?>
										<tr>
											<td colspan="2"><b>&nbsp;</b></td>
											<td colspan="2"><?php echo $payment_data['tax_name'];?> (<?php echo $payment_data['tax_percentage'];?>%)</td>
											<td><?php echo $payment_data['currency'].' '.number_format($payment_data['tax_amount'],2);?></td>
										</tr>
										<?php 
											}
										?>
											
											<tr>
												<td colspan="2"></td>
												<td colspan="2">GRAND TOTAL</td>
												<td><?php echo $payment_data['currency'].' '.number_format($payment_data['grand_total'],2);?></td>
											</tr>
										</tfoot>
									</table>
									</div>
									<div class="thanks">Thank you!</div>
									<!-- <div class="notices">
										<div>NOTICE:</div>
										<div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
									</div> -->
								</main>
								<footer>
									Invoice was created on a computer and is valid without the signature and seal.
								</footer>
							</div>


							<!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
							<div></div>
						</div>
					</div>
					<div class="row no-print" style="margin-top:-8%;">
	<div class="col-xs-12">
		<div align="center">
			<img src="<?php echo $base_url; ?>assets/front_end/img/print.png" onClick="printDiv('invoice')" style=" text-align:center; cursor:pointer;" ></br>
			<span><strong>Print Invoice</strong></span>
		</div>
	</div>
</div>

<?php
	$this->common_model->js_extra_code_fr.="
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;
				
		printContents = printContents.replace(/col-xs-12 invoice-col/gi, 'col-xs-4 invoice-col');	
		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
	}
	";
?>
				</div> 
			</div>
		</div>
		
		