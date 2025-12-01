<?php $dna = $this->common_model->data_not_availabel;
$base_url = base_url();
?>
<style type="text/css">
	@media print
{
    .noprint {display:none;}
	h2{
		margin-top:0px !important;
		padding-top:0px !important;
	}
}
</style>

<div class="pad margin no-print">
  <div class="alert alert-info" style="margin-bottom: 0!important;">												
    <h4><i class="fa fa-info"></i> Note:</h4>
    This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
  </div>
</div>
<section class="invoice">
	<div class="row">
    	<div class="col-xs-12">
      		<h2 class="page-header">
        		<i class="fa fa-globe"></i>&nbsp;<strong><?php echo $config_data['web_frienly_name'];?></strong>
	      	</h2>
    	</div>
  	</div>
  	<div class="row invoice-info">
    	<div class="col-md-4 col-xs-4 invoice-col">
	  		From
      		<address>
     			<strong><?php echo $config_data['web_frienly_name'];?></strong><br>
     			<div class="row">
     				<div class="col-xs-12">Contact No : <?php echo $config_data['contact_no'];?></div>
     				<div class="col-xs-12">Email : <?php echo $config_data['from_email'];?></div>
      			</div>
       		</address>
    	</div>
	    <div class="col-md-4 col-xs-4 invoice-col">
    		&nbsp;&nbsp;&nbsp; To
     		<address>
    			<div class="col-xs-12"><strong><?php echo $payment_data['name'];?></strong></div> 
    			<div class="col-xs-12">Address : <?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $payment_data['address']; } ?></div>
    			<div class="col-xs-12">Mobile : <?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $payment_data['mobile']; } ?></div>
     			<div class="col-xs-12">Email : <?php if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $payment_data['email']; } ?></div>
      		</address>
    	</div>
    	<div class="col-md-4 col-xs-4 invoice-col">
            <div class="col-xs-12"><strong>Invoice : </strong>INV001<?php echo $payment_data['id'];?></div>
            <div class="col-xs-12"><strong>Customer Id : </strong><?php echo $payment_data['matri_id'];?></div>
            <div class="col-xs-12"><strong>Payment Mode : </strong><?php echo $payment_data['payment_mode'];?></div>
    	</div>
	</div>
  	<div class="row">
    <br/>
  	<div class="col-xs-12 table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Qty</th>
            <th>Product</th>           
            <th>Activated On</th>
            <th>Expired On</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
    		<td><?php echo $payment_data['plan_name'];?> Membership for <?php echo $payment_data['plan_duration'];?> Days</td>
            <td><?php echo $payment_data['plan_activated'];?></td>
            <td><?php echo $payment_data['plan_expired'];?></td>
            <td><?php echo $payment_data['currency'].' '.number_format($payment_data['plan_amount'],2);?></td>
         </tr>
         
         <?php 
			if($payment_data['discount_detail'] !='' && $payment_data['discount_amount'] !='' && $payment_data['discount_amount'] > 0)
            {
         ?>
          <tr>
            <td colspan="3"><b>&nbsp;</b></td>
            <td><b>Coupan Code (<?php echo $payment_data['discount_detail'];?>)</b></td>
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
            <td colspan="3"><b>&nbsp;</b></td>
            <td><b><?php echo $payment_data['tax_name'];?> (<?php echo $payment_data['tax_percentage'];?>%)</b></td>
            <td ><?php echo $payment_data['currency'].' '.number_format($payment_data['tax_amount'],2);?></td>
          </tr>
         <?php 
            }
         ?>
         <tr>
            <td colspan="3"><b>&nbsp;</b></td>
            <td><b>Grand Total</b></td>
            <td><?php echo $payment_data['currency'].' '.number_format($payment_data['grand_total'],2);?></td>
          </tr>
       	</tbody>
      </table>
      <hr>
     <p class="text-center">This is a computer generated invoice</p>
    	</div>
	</div>	
	<div class="row no-print">
    <div class="col-xs-12">
       	<div align="left">
			<img src="<?php echo $base_url; ?>assets/back_end/images/print.png" onClick="window.print()" style=" text-align:center; cursor:pointer;" ></br>
			<span><strong>Print Invoice</strong></span>
        </div>
    </div>
    </div>
</section>