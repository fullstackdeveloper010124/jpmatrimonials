<?php $user_logged_type = $this->common_model->get_session_data('user_type');
$access_perm_mem = $this->common_model->check_permission('view_member');
$user_id_check_filed = 'franchised_by';
if($user_logged_type =='staff')
{
	$user_id_check_filed = 'adminrole_id';
}
if($access_perm_mem !='No')
{
	$where_mem_ber_perm = '';
	$user_logged_id = $this->common_model->get_session_data('id');
	if($access_perm_mem =='Own Members' && $user_logged_id !='')
	{
		$where_mem_ber_perm = " and $user_id_check_filed ='$user_logged_id' ";
	}

	$where_arra = array('is_deleted'=>'No');
	$today_date = $this->common_model->getCurrentDate('Y-m-d');
	
	$reg_date_wh = " registered_on like '$today_date%' $where_mem_ber_perm ";
	$today_date_mon = $this->common_model->getCurrentDate('Y-m');
	
	$reg_month_ld = date('Y-m-d', strtotime('-1 month'));
	$reg_date_mon = " registered_on < '$today_date 00:00:00' and registered_on>= '$reg_month_ld 00:00:00' $where_mem_ber_perm ";
	
	$reg_week_ld = date('Y-m-d', strtotime('-1 week'));
	$reg_date_wheek = " registered_on < '$today_date 00:00:00' and registered_on>= '$reg_week_ld 00:00:00' $where_mem_ber_perm ";
	$today_reg_whr = array($reg_date_wh);
	
	$today_reg = $this->common_model->get_count_data_manual('register',$today_reg_whr,0,'');	
	
	$week_reg = $this->common_model->get_count_data_manual('register',$reg_date_wheek,0,'');
	$month_reg = $this->common_model->get_count_data_manual('register',$reg_date_mon,0,'');
	
	$where_mem_ber_perm1 = str_replace('and','',$where_mem_ber_perm);
	$total_count = $this->common_model->get_count_data_manual('register',$where_mem_ber_perm1,0,'');
	
	$male_member = $this->common_model->get_count_data_manual('register',"gender ='Male' $where_mem_ber_perm ",0,'');
	$female_member = $this->common_model->get_count_data_manual('register',"gender ='Female' $where_mem_ber_perm ",0,'');
	
	$active_member = $this->common_model->get_count_data_manual('register',"status ='APPROVED' $where_mem_ber_perm ",0,'');
	$paid_member = $this->common_model->get_count_data_manual('register',"status ='APPROVED' and plan_status = 'Paid' $where_mem_ber_perm ",0,'');
	
	if($user_logged_type =='admin')
	{
		$payment_count = $this->common_model->get_count_data_manual('payments','',1,'sum(grand_total) as total_paid');
		$total_payment = $payment_count['total_paid'];
		
		$total_adv = $this->common_model->get_count_data_manual('advertisement_master',"",0,'');
		$vendors_count = $this->common_model->get_count_data_manual('wedding_planner',"",0,'');
		$success_count = $this->common_model->get_count_data_manual('success_story',"",0,'');
		$plan_counts = $this->common_model->get_count_data_manual('membership_plan',"",0,'');
	}
	
?>
      <div class="row">
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-users"> </div>
              <div class=overflow-hidden> <a href="javascript:;" onclick="get_filter_data_date('<?php echo $today_date;?>','<?php echo $today_date;?>');"><span class=widget-title><?php echo $today_reg; ?></span> <span class=widget-subtitle>Today Member(s)</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
          	<div class="widget bg-white">
			<?php $today_date1 = date('Y-m-d', strtotime('-1 day'));?>
              <div class="widget-icon bg-danger pull-left fa fa-users"> </div>
              <div class=overflow-hidden> <a href="javascript:;" onclick="get_filter_data_date('<?php echo $reg_week_ld;?>','<?php echo $today_date1;?>');"><span class="widget-title"><?php echo $week_reg; ?></span> <span class=widget-subtitle>Last Week Member(s)</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
          	<div class="widget bg-white">
			<?php $today_date1 = date('Y-m-d', strtotime('-1 day'));?>
              <div class="widget-icon bg-success pull-left fa fa-users"> </div>
              <div class=overflow-hidden> <a href="javascript:;" onclick="get_filter_data_date('<?php echo $reg_month_ld;?>','<?php echo $today_date1;?>');"><span class=widget-title><?php echo $month_reg; ?></span> <span class=widget-subtitle>Last Month Member(s)</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
          	<div class="widget bg-white">
              <div class="widget-icon bg-success pull-left fa fa-users"> </div>
              <div class=overflow-hidden> <a href="<?php echo $this->base_url.$this->admin_path;?>/member/member_list/"><span class=widget-title><?php echo $total_count; ?></span> <span class=widget-subtitle>Total Member(s)</span></a> </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-male"> </div>
              <div class=overflow-hidden> <a href="javascript:;" onclick="get_filter_data_gender('Male');"><span class=widget-title><?php echo $male_member; ?></span> <span class=widget-subtitle>Male Member(s)</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-female"> </div>
              <div class=overflow-hidden> <a href="javascript:;" onclick="get_filter_data_gender('Female');"><span class=widget-title><?php echo $female_member; ?></span> <span class=widget-subtitle>Female Member(s)</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-user"> </div>
              <div class=overflow-hidden> <a href="<?php echo $this->base_url.$this->admin_path;?>/member/member_list/APPROVED"><span class=widget-title><?php echo $active_member; ?></span> <span class=widget-subtitle>Active Member</span></a> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-money"> </div>
              <div class=overflow-hidden> <a href="<?php echo $this->base_url.$this->admin_path;?>/member/member_list/Paid"><span class=widget-title><?php echo $paid_member; ?></span> <span class=widget-subtitle>Paid Member</span></a> </div>
            </div>
          </div>
        </div>
      </div>
	<?php
      	if($user_logged_type =='admin'){
	?>
      <div class="row">
        <div class="col-md-6">
          <div class="widget bg-white">
            <div class="widget-details widget-list">
              <div class="">
                <h4 class="no-margin text-uppercase">Total Payment
                <span style="float:right" class="label label-info pull-right"><?php echo number_format($total_payment,2); ?></span>
                </h4>
                <small class="text-uppercase"></small> 
              </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-bars"> </div>
              <div class=overflow-hidden> <span class=widget-title><?php echo $vendors_count; ?></span> <span class=widget-subtitle>Total Vendors</span> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-bars"> </div>
              <div class=overflow-hidden> <span class=widget-title><?php echo $success_count; ?></span> <span class=widget-subtitle>Success Story</span> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-bars"> </div>
              <div class=overflow-hidden> <span class=widget-title><?php echo $plan_counts; ?></span> <span class=widget-subtitle>Membership Plans</span> </div>
            </div>
          </div>
        </div>
        <div class=col-md-3>
          <div>
            <div class="widget bg-white">
              <div class="widget-icon bg-blue pull-left fa fa-bars"> </div>
              <div class=overflow-hidden> <span class=widget-title><?php echo $total_adv; ?></span> <span class=widget-subtitle>Advertisement</span> </div>
            </div>
          </div>
        </div>
      </div>      
	<?php
		}
		if($user_logged_type=='franchise'){?>
            <div class="row">
                <div class="col-md-12">
                    <div class="widget bg-white">
	                    <div class="col-md-12 mb10">
                            <h4 class="no-margin text-uppercase mb10"><i class="fa fa-user-plus"></i>&nbsp;Your Referral Link</h4>
                            <p>Share your referral link to your recommended members!</p>
                        </div>
                        <div class="col-md-8 mb10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="referral_link_id" readonly value="<?php echo $this->common_model->get_session_data('referral_link');?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-copy">Copy</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php }
		$where_mem_ber_perm = str_replace('and','',$where_mem_ber_perm);
		$member_data = $this->common_model->get_count_data_manual('register_view',$where_mem_ber_perm,2,'matri_id,username,email,gender,marital_status,religion_name,country_name,city_name,caste_name,registered_on',' registered_on desc ',1,12);
	
	$na = $this->common_model->data_not_availabel;
	if(isset($member_data) && $member_data !='' && is_array($member_data) && count($member_data)> 0)
	{
?>      
      <div class="row">
        <div class="col-md-12">
          <div class="widget bg-white">
            <div class="widget-details widget-list">
              <div class="col-md-8 mb10">
                <h4 class="no-margin text-uppercase">Latest Registered Member</h4>
              </div>
              <div class="col-md-4 mb10">
              	<a style="float:right" href="<?php echo $this->common_model->base_url.$this->common_model->admin_path.'/member/member-list/ALL/1/yes'; ?>">View All Member</a>
              </div>
              <div>
              	<table class="table">
                	<thead>
                    	<th>Matri Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender </th>
                        <th>Marital Status</th>
                        <th>Location</th>
                        <th>Registered On</th>
                    </thead>
                    <tbody>
                    <?php
					$ij= 1;
					foreach($member_data as $member_data_val)
					{
					?>
                    	<tr>
                        	<td><?php if(isset($member_data_val['matri_id']) && $member_data_val['matri_id'] !=''){echo $member_data_val['matri_id'];}else{ echo $na;} ?></td>
                        	<td><?php if(isset($member_data_val['username']) && $member_data_val['username'] !=''){echo $member_data_val['username'];}else{ echo $na;} ?></td>
                            <td><?php if(isset($member_data_val['email']) && $member_data_val['email'] !='')
							{
								if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
								{
									echo $this->common_model->disable_in_demo_text;
								}
								else
								{
									echo $member_data_val['email'];
								}
							}
							else
							{
								echo $na;
							}?></td>
                            <td><?php if(isset($member_data_val['gender']) && $member_data_val['gender'] !=''){echo $member_data_val['gender'];}else{ echo $na;} ?></td>
                            <td><?php if(isset($member_data_val['marital_status']) && $member_data_val['marital_status'] !=''){echo $member_data_val['marital_status'];}else{ echo $na;} ?></td>
                            <td><?php if(isset($member_data_val['city_name']) && $member_data_val['city_name'] !='')
							{
								if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
								{
									
								}
								else
								{
									echo $member_data_val['city_name'].'<br/>'; 
								}
							} 
							if(isset($member_data_val['country_name']) && $member_data_val['country_name'] !=''){echo $member_data_val['country_name']; } ?></td>
                            <td><?php echo $this->common_model->displayDate($member_data_val['registered_on']); ?></td>
                        </tr>
						<?php
                        }
                        ?>
                        </tbody>
                    </table>
            		</div>
            	</div>
        	</div>
    	</div>
	</div>
	<?php
	}
}
else
{
?>
<div class="alert alert-info">Wele come to Dashboard</div>
<?php
}
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.10/clipboard.min.js"></script>
<?php
$this->common_model->js_extra_code.="	
	function get_filter_data_date(from_reg_date,to_reg_date)
	{
		if(from_reg_date!='' && to_reg_date!='')
		{
			var hash_tocken_id = $('#hash_tocken_id').val();
			var base_url = $('#base_url').val();
			var url = base_url+'control-panel/member/search_model';
			show_comm_mask();
			
			$.ajax({
				url: url,
				type: 'POST',
				data: {'csrf_new_matrimonial':hash_tocken_id,'from_reg_date':from_reg_date,'to_reg_date':to_reg_date},
				dataType:'json',
				success: function(data)
				{ 	
					window.location.href = base_url+'control-panel/member/member-list/';
					
					update_tocken(data.tocken);
					hide_comm_mask();
				}
			});
		}
		return false;
	}
	
	function get_filter_data_gender(gender)
	{
		if(gender!= '')
		{
			var hash_tocken_id = $('#hash_tocken_id').val();
			var base_url = $('#base_url').val();
			var url = base_url+'control-panel/member/search_model';
			show_comm_mask();
			
			$.ajax({
				url: url,
				type: 'POST',
				data: {'csrf_new_matrimonial':hash_tocken_id,'gender':gender},
				dataType:'json',
				success: function(data)
				{ 	
					window.location.href = base_url+'control-panel/member/member-list/';
						
					update_tocken(data.tocken);
					hide_comm_mask();
				}
			});
		}
		return false;
	}
	var clipboard = new Clipboard('.btn-copy', {
		text: function() {
			return $('#referral_link_id').val();
		}
	});
	clipboard.on('success', function(e) {
		alert('Link Copied!');
		e.clearSelection();
	});
	$('#input-url').val(location.href);
	//safari
	if (navigator.vendor.indexOf('Apple')==0 && /\sSafari\//.test(navigator.userAgent)) {
		$('.btn-copy').on('click', function() {
			var msg = window.prompt('Copy this link', location.href);
		});
	}";?>