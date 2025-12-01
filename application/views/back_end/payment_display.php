<?php $dna = $this->common_model->data_not_availabel; 
$hidd_user_id = '';
if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !='')
{
	$hidd_user_id = $_REQUEST['user_id'];
}
$user_data = array();
$path_img = $this->common_model->path_photos;
$plan_table_name = 'membership_plan';
if($hidd_user_id !='')
{
	$user_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$hidd_user_id),1,' username, email, mobile, photo1 ','',0,'',0);
}
$config_data = $this->common_model->get_site_config();
if (!empty($config_data)) {
    $taxApllicable = $config_data['tax_applicable'];
    $taxName = $config_data['tax_name'];
    $serviceTax = $config_data['service_tax'];
}
?>
<div id="plan_detail">
	<div class="alert alert-danger" id="model_body_common_err" style="display:none"></div>
	<div class="row">
    	<div class="col-lg-5 col-xs-12 col-sm-12 col-md-5 imgPaddingRightZero" align="center">
        	<?php
				$avatar = $this->common_model->photo_avtar;
				if(isset($user_data['photo1']) && $user_data['photo1'] !='')
				{
					$temp_img = $user_data['photo1'];
					if(file_exists($path_img.$temp_img))
					{
						$avatar = $path_img.$temp_img;
					}
				}
			?>
            <img data-src="<?php echo $base_url.$avatar; ?>" title="<?php echo $user_data['username']; ?>" alt="<?php echo $user_data['username']; ?>" class=" img-responsive lazyload">
        </div>
        <div class="col-lg-5 col-xs-12 col-sm-12 col-md-5">
        	<p class="text-bold"><span class="fa fa-user"></span>&nbsp;&nbsp;<?php 
			if(isset($user_data['username']) && $user_data['username'] !=''){echo $user_data['username'];} else{ echo $dna;} ?></p>
            <p><span class="fa fa-envelope"></span>&nbsp;&nbsp;<?php if(isset($user_data['email']) && $user_data['email'] !=''){if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $user_data['email'];}} else{ echo $dna;}  ?></p>
            <p><span class="fa fa-phone"></span>&nbsp;&nbsp;
			<?php if(isset($user_data['mobile']) && $user_data['mobile'] !=''){if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){ echo $this->common_model->disable_in_demo_text; } else{ echo $user_data['mobile'];}} else{ echo $dna;} ?>
            </p>
        </div>
    </div>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        	<div class="form-group ">
              <label class="col-sm-1 col-lg-1"></label>
              <label class="col-sm-2 col-lg-2 control-label text-bold">Plan</label>
              <div class="col-sm-6 col-lg-6">
                <select required name="plan_id" id="plan_id" class="form-control" onChange="display_plan()">
                	<option selected="" value="">Select Plan</option>
                    <?php
                    $where_arra = array('status'=>'APPROVED','is_deleted'=>'No');

					$plan_data = $this->common_model->get_count_data_manual($plan_table_name,$where_arra,2,' * ','',0,'',0);
					if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
					{
						foreach($plan_data as $plan_data_val)
						{
					?>
                    	<option value="<?php echo $plan_data_val['id']; ?>"><?php echo $plan_data_val['plan_name'].' ('.$plan_data_val['plan_amount_type'].' '.$plan_data_val['plan_amount'].' )'; ?></option>
                    <?php
						}
					}
					?>
                </select>
              </div>
              <label class="col-sm-1 col-lg-1"></label>
            </div>
            <!-- for dicount -->
            <div class="form-group ">
        <label class="col-sm-1 col-lg-1"></label>
        <label class="col-sm-2 col-lg-2 control-label text-bold pr0">Coupon Code&nbsp;</label>
        <div class="col-sm-3 col-lg-6">
            <input type=text class="form-control" name="coupan_code_admin" id="coupan_code_admin" placeholder="Enter Coupon Code" onblur="clearcoupan()">
            <input type="hidden" id="is_redeem" name="is_redeem" value="No"/>
            <span id="err_couponcode" class="text-danger"></span>
            <div id="planChange" style="color: green;">
            </div>
        </div>
            <div class="col-md-2 col-sm-2 col-xs-12">
                <div class="redeem-btn">
                    <a href="javascript:;" onclick="check_coupan_code_admin()"
                        class="Poppins-Medium color-f f-16" id="Redeem">Redeem</a>
                </div>
            </div>
        </div>
    <!-- for dicount end -->
            <div class="form-group ">
              <label class="col-sm-1 col-lg-1"></label>
              <label class="col-sm-2 col-lg-2 control-label text-bold pr0">Payment&nbsp;Mode</label>
              <div class="col-sm-6 col-lg-6">
                <select required name="payment_mode" id="payment_mode" class="form-control">
                	<option selected="" value="">Select Payment Mode</option>
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                    <option value="Other">Other</option>
                </select>
              </div>
              <label class="col-sm-1 col-lg-1"></label>
            </div>
        </div>
    </div>
    <?php
		//$plan_data = $this->common_model->get_count_data_manual($plan_table_name,array('status'=>'APPROVED'),2,' * ','',0,'',0);
		if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
		{
			foreach($plan_data as $plan_data_val)
			{
                $plan_amount = $plan_data_val['plan_amount']; ;
                $planAmount = $plan_amount - (($plan_amount*$plan_data_val['offer_per'])/100);
                $total_amount = $planAmount;
                if ($taxApllicable == 'Yes' && $serviceTax > 0) {
                    $gst_amount = ($planAmount * $serviceTax) / 100;
                    $total_amount = $planAmount + $gst_amount;
                    $total_gst_amount = $plan_data_val['plan_amount_type'].' '.number_format($gst_amount,2);
                } 
	?>
        <div class="plan_detail" style="display:none;margin:0px;padding:10px 8px;border: 1px solid #E0E0E0;" id="plan_detail_<?php echo $plan_data_val['id']; ?>">
                <div class="row">
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-md-2 col-lg-2 col-xs-4 col-sm-4 pr0">
                        Plan Name
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 ml20 text-bold pr0">:&nbsp;
                        <?php echo $plan_data_val['plan_name']; ?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Profile
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['profile']; ?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Plan Amount
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['plan_amount_type'].' '.$plan_amount; ?>
                    </div>
                </div> 
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Message
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['plan_msg']; ?>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Plan Discount
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['offer_per']; ?>%
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Plan Duration
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['plan_duration']; ?> Days
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Coupan Amount 
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0 cpamount">:&nbsp;
                        
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                            Contacts
                        </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['plan_contacts']; ?>
                    </div>
                </div>
                <?php if ($gst_amount>0 && $taxApllicable == 'Yes' && $serviceTax > 0) {?>
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        <?php echo $taxName.'('.$serviceTax.'%)';?>
                    </div>
                    <!-- <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        + <?php //echo $plan_data['plan_amount_type'].' '.number_format($gst_amount,2);?>
                    </div> -->
                    <input type="hidden" value="<?php echo number_format($gst_amount,2); ?> " id="gst_amount<?php echo $plan_data_val['id'];?>" />
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0 gst_amount">:&nbsp;
                        
                    </div>
                </div>
                <?php }else{  ?> 
                    <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                        <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0" style="font-weight:bold; color:green;">
                            Grand Total
                            </div>
                            <input type="hidden" value="<?php echo $total_amount; ?> " id="gt_<?php echo $plan_data_val['id'];?>" />
                            <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0 netcpamount" style="font-weight:bold; color:green;">:&nbsp;
                                
                            </div>
                    </div>
                <?php } ?>   
                
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0">
                        Chat
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0">:&nbsp;
                        <?php echo $plan_data_val['chat']; ?>
                    </div>
            </div>
            <?php if ($gst_amount>0 && $taxApllicable == 'Yes' && $serviceTax > 0) {?>  
                <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12 neAdminResultDetail">
                    <div class="col-lg-5 col-md-5 col-xs-4 col-sm-4 pr0" style="font-weight:bold; color:green;">
                        Grand Total
                        </div>
                        <input type="hidden" value="<?php echo $total_amount; ?> " id="gt_<?php echo $plan_data_val['id'];?>" />
                        <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 m-l-left pr0 netcpamount" style="font-weight:bold; color:green;">:&nbsp;
                            
                        </div>
                </div>
            <?php } ?>   
            <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12 neAdminResultDetail">
                <div class="col-lg-2 col-md-2 col-xs-4 col-sm-4 pr0">
                        Plan Offer
                    </div>
                    <div class="col-md-7 col-lg-7 col-xs-7 col-sm-7 ml20 pr0">:&nbsp;
                        <?php 
                            if(isset($plan_data_val['plan_offers']) && $plan_data_val['plan_offers'] !='')
                            {
                                echo $plan_data_val['plan_offers'];
                            }
                            else
                            {
                                echo $dna;
                            }
                        ?>
                    </div>
            </div>
            </div>
            </div>
    <?php
			}
		}
	?>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
        	<div class="form-group ">
              <label class="col-sm-1 col-lg-1"></label>
              <label class="col-sm-2 col-lg-2 control-label text-bold">Payment&nbsp;Note</label>
              <div class="col-sm-6 col-lg-6">
                <textarea rows="5" class="form-control" name="payment_note" id="payment_note" placeholder="Enter Payment Note"></textarea>
              </div>
              <label class="col-sm-1 col-lg-1"></label>
            </div>
        </div>
    </div>
    <div class="clearfix"><br/></div>
    <div class="row form-horizontal">
    	<div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 text-center">
    		<button type="button" class="btn btn-primary mr10" onclick="update_payment_member()">Submit</button>
            <button type="button" onclick="close_payment_pop()" class="btn btn-default" data-dismiss="myModal_common">Close</button>
        </div>
    </div>    
</div>
<input type="hidden" id="hash_tocken_id_temp" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
<input type="hidden" id="hidd_user_id" name="hidd_user_id" value="<?php echo $hidd_user_id;?>" />

<script type="text/javascript">
	function display_plan()
	{
		var plan_id = $("#plan_id").val();
		$(".plan_detail").slideUp();
		if(plan_id !='')
		{
			$("#plan_detail_"+plan_id).slideDown();
		}
	}
</script>
<script>
    function check_coupan_code_admin()
    {
      
        $('#planChange').html('');
        var couponcode = $('#coupan_code_admin').val();
        var is_redeem = $("#is_redeem").val('Yes');
        if(couponcode == '')
        {
             $('#planChange').html("<span style='color:red;'></span>");
              $('.cpamount').html('0');
            $('#planChange').slideDown();

            $("#err_couponcode").html("Please enter Coupon Code").show();
               setTimeout(function() { $("#err_couponcode").hide(); }, 3000);
        }
        else
        {
            var form_data = '';
            var hash_tocken_id = $('#hash_tocken_id').val();
            var plan_id = $('#plan_id').val();
            var base_url_admin = $("#base_url_admin").val();
            var action = base_url_admin +'/check-coupan-admin';
            show_comm_mask();
            $.ajax({
            url:  action,
            type: "post",
            data: {"csrf_new_matrimonial":hash_tocken_id, 'plan_id':plan_id,'coupan_code_admin':couponcode},
            dataType:'json',
            success:function(data)
            {
               // console.log(data);
                if(data.status =='success')
                {
                    $('#planChange').html(data.message);
                    $('.cpamount').html(": "+data.discount_amount.plan_amount_type+" "+data.discount_amount.discount_amount+"");
                    $('.netcpamount').html(": "+data.discount_amount.plan_amount_type+" "+data.discount_amount.net_amount+""); 
                    $('.gst_amount').html(": "+data.discount_amount.gst_amount+""); 
                    $('#planChange').slideDown();
                }
                else
                {
                    $('#planChange').html("<span style='color:red;'>"+data.message+"</span>");
                    $('.cpamount').html(": 0");
                    $('.netcpamount').html(": 0");
                    $('#planChange').slideDown();
                    var gtamount = $("#gt_"+plan_id).val();
                    $('.netcpamount').html(gtamount);
                    var gtamount = $("#gt_"+plan_id).val();
                    $('.gst_amount').html(gtamount);
                }
                hide_comm_mask();
            }
            });
        }
        return false;
    }
    
    function clearcoupan() {
        var plan_id = $('#plan_id').find(":selected").val();
       
        var gtamount = $("#gt_"+plan_id).val();
        $('.netcpamount').html(gtamount);
        var gtamount = $("#gt_"+plan_id).val();
        $('.gst_amount').html(gst_amount);
        $('.cpamount').html(": 0");
        $('#planChange').html('');
    };

</script>