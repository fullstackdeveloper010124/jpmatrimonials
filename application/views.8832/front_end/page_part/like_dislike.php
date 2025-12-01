<?php 
	$result_member_matri_id = $member_data_val['matri_id'];
	$where_arra=array('to_id'=>$result_member_matri_id,'from_id'=>$member_id);
	$data = $this->common_model->get_count_data_manual('shortlist',$where_arra,1,'id');
	$is_short_list = 0;
	if(isset($data) && $data !='' && $data > 0)
	{
		$is_short_list = 1;
	}
	$member_likes_count = 0;
	$member_likes_data = array();
	$member_id_like = $this->common_front_model->get_session_data('matri_id');
	if(isset($member_id_like) && $member_id_like !='' && isset($member_data_val) && $member_data_val !='' )
	{
		$where_array = array('my_id'=>$member_id_like,'other_id'=>$member_data_val['matri_id']);
		$member_likes_data = $this->common_model->get_count_data_manual('member_likes',$where_array,1,'');
		$member_likes_count = $this->common_model->get_count_data_manual('member_likes',$where_array,0,'');
	}
	$yes_style = 'display:inline-block;';
	$no_style = 'display:inline-block;';
	$image_yes_style = 'display:none';
	$image_no_style = 'display:none;';
	$like_unlike = "YN";
	if(isset($member_likes_data) && $member_likes_data != '' && isset($member_likes_count) && $member_likes_count > 0){
		if($member_likes_data['like_status']=='Yes'){
			$like_unlike = "N";
			$yes_style = 'display:none;';
			$image_yes_style = 'display:inline-block;';
		}elseif($member_likes_data['like_status']=='No'){
			$like_unlike = "Y";
			$no_style = 'display:none;';
			$image_no_style = 'display:inline-block;';
		}
	}
	$mem_login = '';
	$more_details = 'No';
	$txt_left = '';
	if(isset($member_id) && $member_id!='' && isset($member_data_val) && $member_data_val !=''  && is_array($member_data_val)){
		$mem_login = 'f-left w-100';
		$more_details = 'Yes';
		//$txt_left = 't-left';
	}?>
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="">
			<div class="row">
				<div class="main-short-animation">
					<div class="col-md-4 col-xs-4 col-sm-4">
						<div id="add_shortlist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_short_list != 0){ echo 'none';}else{echo 'block';} ?>">
							<a data-toggle="modal" data-target="#myModal_shortlist" title="Add to Shortlist" onClick="add_shortlist_matri_id('<?php echo $member_data_val['matri_id'];?>')">
								<div class="ch-item ch-img-1">				
									<div class="ch-info-wrap">
										<div class="ch-info">
											<div class="ch-info-front ch-img-1"><i class="fa fa-star sr-i1 sr-icon" title="Shortlist"></i></div>
											<div class="ch-info-back star">
											<i class="fa fa-star" title="Shortlist"></i>
											</div>	
										</div>
									</div>
								</div>
							</a>
						</div>
						<div id="remove_shortlist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_short_list == 0){ echo 'none';}else{echo 'block';} ?>;">
						<a data-toggle="modal" data-target="#myModal_shortlisted" title="Remove to Shortlist" onClick="remove_shortlist_matri_id('<?php echo $member_data_val['matri_id'];?>')">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1"><i class="fas fa-star sr-i1 sr-icon" title="Shortlist"></i></div>
										<div class="ch-info-back star fill">
										<i class="fas fa-star" title="Shortlist"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
						</div>
					</div>
					<div class="col-md-4 col-xs-4 col-sm-4">
						<a id="Yes_id_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $yes_style;?>" href="javascript:;" onclick="member_like('Yes','<?php echo $member_data_val['matri_id'];?>');" >
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fas fa-check sr-i2 sr-icon" title="Like"></i>
										</div>
										<div class="ch-info-back check">
											<i class="fas fa-check" title="Like"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
						<a id="Image_Yes_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $image_yes_style;?>">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fas fa-check sr-i2 sr-icon" title="Liked"></i>
										</div>
										<div class="ch-info-back check fill">
											<i class="fas fa-check" title="Liked"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-4 col-xs-4 col-sm-4">
						<a id="No_id_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $no_style;?>" href="javascript:;" onclick="member_like('No','<?php echo $member_data_val['matri_id']; ?>');">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fas fa-times sr-i3 sr-icon" title="Unlike"></i>
										</div>
										<div class="ch-info-back times">
											<i class="fas fa-times" title="Unlike"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
						<a id="Image_No_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $image_no_style;?>">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fas fa-times sr-i3 sr-icon" title="Unliked"></i>
										</div>
										<div class="ch-info-back times fill">
											<i class="fas fa-times" title="Unliked"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="row"><div class="main-short-2 "></div></div>
		</div>
		<div class="">
			<div class="row margin-top-40 ">
				<div class="main-short-animation">
					<div class="col-md-4 col-xs-4 col-sm-4">
						<a data-toggle="modal" data-target="#myModal_sms" title="Send Message" onClick="get_member_matri_id('<?php echo $member_data_val['matri_id'];?>')">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fa fa-comments sr-i4 sr-icon" title="Send Message" style=""></i>
										</div>
										<div class="ch-info-back comments">
											<i class="fa fa-comments" title="Send Message" style=""></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
					</div>
					<?php  
					$where_arra=array('receiver'=>$result_member_matri_id,'sender'=>$member_id);
					$data = $this->common_model->get_count_data_manual('expressinterest',$where_arra,1,'id');
					$is_interest = 0;
					if(isset($data) && $data > 0){
						$is_interest = 1;
					}?>
					<div class="col-md-4 col-xs-4 col-sm-4">
						<a id="express_insterest_id_<?php echo $member_data_val['matri_id'];?>" data-toggle="modal" data-target="#myModal_sendinterest" onClick="express_interest('<?php echo $member_data_val['matri_id'];?>')" title="Send Interest">
							<div class="ch-item ch-img-1">				
								<div class="ch-info-wrap">
									<div class="ch-info">
										<div class="ch-info-front ch-img-1">
											<i class="fas fa-heart sr-i5 sr-icon" title="Send Interest"></i>
										</div>
										<div class="ch-info-back heart <?php if($is_interest){ echo 'fill';}?>">
											<i class="fas fa-heart" title="Send Interest"></i>
										</div>	
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="col-md-4 col-xs-4 col-sm-4">
						<?php 
						$where_arra=array('block_to'=>$result_member_matri_id,'block_by'=>$member_id);
						$data = $this->common_model->get_count_data_manual('block_profile',$where_arra,1,'id');
						$is_block_list = 0;
						if(isset($data) && $data > 0){
							$is_block_list = 1;
						}?>
						<input type="hidden" id="is_member_block_<?php echo $member_data_val['matri_id'];?>" name="is_member_block_<?php echo $member_data_val['matri_id'];?>" value="<?php if($is_block_list != 0){ echo 'is_member_block_'.$member_data_val['matri_id']; } ?>" >
						<div id="add_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list != 0){ echo 'none';}else{ echo 'block';} ?>;">
							<a data-toggle="modal" data-target="#myModal_block" title="Add to Blocklist" onClick="add_block_list_matri_id('<?php echo $member_data_val['matri_id'];?>')">
								<div class="ch-item ch-img-1">				
									<div class="ch-info-wrap">
										<div class="ch-info">
											<div class="ch-info-front ch-img-1">
												<i class="fas fa-ban sr-i6 sr-icon" title="Block" style="padding: 10px;"></i>
											</div>
											<div class="ch-info-back ban">
												<i class="fas fa-ban" title="Block" style="padding: 10px;"></i>
											</div>	
										</div>
									</div>
								</div>
							</a>
						</div>
						<div id="remove_blocklist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_block_list == 0){ echo 'none';}else{ echo 'block';} ?>;">
							<a data-toggle="modal" data-target="#myModal_unblock" title="Remove to Blocklist" onClick="remove_block_list_id('<?php echo $member_data_val['matri_id'];?>')"> 
								<div class="ch-item ch-img-1">				
									<div class="ch-info-wrap">
										<div class="ch-info">
											<div class="ch-info-front ch-img-1">
												<i class="fas fa-ban sr-i6 sr-icon" title="Blocked" style="padding: 10px;"></i>
											</div>
											<div class="ch-info-back ban fill">
												<i class="fas fa-ban" title="Blocked" style="padding: 10px;"></i>
											</div>	
										</div>
									</div>
								</div>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row"><div class="main-short-2 "></div></div>
		</div>
		<div class="profile-card-btn" style="margin-top: 67px;">
			<a href="<?php echo $base_url;?>search/view-profile/<?php echo $member_data_val['matri_id'];?>" class="s-card-1-web OpenSans-Light">View Full Profile</a>
		</div>
	</div>