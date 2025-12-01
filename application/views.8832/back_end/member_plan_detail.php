<?php $dna = $this->common_model->data_not_availabel;
$base_url = base_url();
error_reporting(0);
if(isset($data_array) && $data_array !='' && count($data_array) > 0)
{
$matri_id = $data_array['matri_id'];
$plan_data_arr = $this->common_model->get_count_data_manual('payments',array('matri_id'=>$matri_id),2,' * ',' current_plan asc',0,'',0);
	if(isset($plan_data_arr) && $plan_data_arr !='' && count($plan_data_arr)>0)
	{
?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<div class="pull-left  text-bold">Membership Plan Details</div>
		<div class="panel-controls">
			<a href="#" class="panel-collapse" data-toggle="panel-collapse"> <i class="panel-icon-chevron"></i> </a>
		</div>
	</div>
	<div class="panel-body form-horizontal">
		<?php
			foreach($plan_data_arr as $plan_data)
			{
		?>
        <div>
			<?php
				if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
				{
					//print_r($plan_data);
					$check_yes = '<span class="fa fa-check text-success"></span> (Yes)';
					$check_no = '<span class="fa fa-times text-danger"></span> (No)';
			?>
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
					
                    <div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Plan Name</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php if(isset($plan_data['plan_name']) && $plan_data['plan_name'] !='')
						{
							echo $plan_data['plan_name'];
						}
						else 
						{
							echo $dna;
						}
						?>
					</label>
					</div>                    
                    <div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Plan Amount</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php if(isset($plan_data['plan_amount']) && $plan_data['plan_amount'] !='')
						{
							echo $plan_data['currency'].' '.$plan_data['plan_amount'];
						}
						else 
						{
							echo $dna;
						}
						?>
					</label>
					</div>
                    <?php if(isset($plan_data['discount_amount']) && $plan_data['discount_detail'] !='' && $plan_data['discount_amount'] !='')
						{
					?>
                    <div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Discount</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php
							echo $plan_data['currency'].' '.$plan_data['discount_amount']; 
							if(isset($plan_data['discount_detail']) && $plan_data['discount_detail'] !='')
							{
								echo ' ('.$plan_data['discount_detail'].')';
							}
						?>
					</label>
					</div>
					<?php 
					}
					if($plan_data['tax_amount'] > 0 && $plan_data['tax_name'] !='')
					{
					?>
                    <div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label"><?php echo $plan_data['tax_name'].'('.$plan_data['tax_percentage'].'%)'; ?></label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo $plan_data['currency'].' '.$plan_data['tax_amount']; ?>
					</label>
					</div>
                    <?php
					}
					?>
					<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Total Amount</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo $plan_data['currency'].' '.$plan_data['grand_total']; ?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Payment Mode</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo $plan_data['payment_mode']; ?>
					</label>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
                	<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Currently Active</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php if(isset($plan_data['current_plan']) && $plan_data['current_plan'] !='')
						{
							if($plan_data['current_plan'] == 'Yes')
							{
						?>
                        	<span class="text-bold text-success">Yes</span>
                        <?php
							}
							else
							{
						?>
                        	<span class="text-bold text-danger">No</span>
                        <?php		
							}
						}
						else 
						{
							echo $dna;
						}
						?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Plan Duration</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo $plan_data['plan_duration'].' Days'; ?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Plan Activated On</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo $this->common_model->displayDate($plan_data['plan_activated'],'F j, Y'); ?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-5 col-xs-6 control-label">Plan Expired On</label>
					<label class="col-sm-7 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<span class="text-danger text-bold"><?php echo $this->common_model->displayDate($plan_data['plan_expired'],'F j, Y'); ?></span>
					</label>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-6 col-xs-6">
					<div class="form-group mb0">
					<label class="col-sm-6 col-xs-6 control-label">Message (Remaining)</label>
					<label class="col-sm-6 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo ($plan_data['message'] - $plan_data['message_used']).' out of '.$plan_data['message']; ?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-6 col-xs-6 control-label">Contacts (Remaining)</label>
					<label class="col-sm-6 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo ($plan_data['contacts'] - $plan_data['contacts_used']).' out of '.$plan_data['contacts']; ?>
					</label>
					</div>
                    <div class="form-group mb0">
					<label class="col-sm-6 col-xs-6 control-label">View Profile (Remaining)</label>
					<label class="col-sm-6 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php echo ($plan_data['profile'] - $plan_data['profile_used']).' out of '.$plan_data['profile']; ?>
					</label>
					</div>
					<div class="form-group mb0">
					<label class="col-sm-6 col-xs-6 control-label">Chat</label>
					<label class="col-sm-6 col-xs-6 control-label-val">
						<strong>:</strong>&nbsp;
						<?php if(isset($plan_data['chat']) && $plan_data['chat'] =='Yes') {	echo $check_yes; } else { echo $check_no; } ?>
					</label>
					</div>
				</div>
			</div>
            <hr/>
			<?php
				}
			?>
		</div>
        <?php
			}
		?>
	</div>
</div>
<?php
	}
}
?>