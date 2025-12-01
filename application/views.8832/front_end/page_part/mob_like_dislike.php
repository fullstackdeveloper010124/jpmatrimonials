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
	$more_details = 'No';
	if(isset($member_id) && $member_id!='' && isset($member_data_val) && $member_data_val !=''  && is_array($member_data_val)){
		$more_details = 'Yes';
	}?>
    
    <div class="col-md-6 col-sm-6 col-xs-12">
		<p class="sr4 f-14 OpenSans-Light text-center mt-0">
			<span id="mob_shorted_or_not_<?php echo $member_data_val['matri_id'];?>"><?php if($is_short_list==1){echo 'Shortlisted';}else{echo 'Shortlist';}?></span> or <span id="mob_like_unlike_<?php echo $member_data_val['matri_id'];?>">
			<?php if(isset($like_unlike) && $like_unlike=='YN'){ echo 'Like/Unlike';}
				else if(isset($like_unlike) && $like_unlike=='Y'){ echo 'Like';}
				else if(isset($like_unlike) && $like_unlike=='N'){ echo 'Unlike';}?>
			</span> profile
		</p>
        <div class="row">
            <div class="main-short text-center w-100">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <div id="add_shortlist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_short_list != 0){ echo 'none';}else{echo 'block';} ?>">
                        <a data-toggle="modal" data-target="#myModal_shortlist" title="Add to Shortlist" onClick="add_shortlist_matri_id('<?php echo $member_data_val['matri_id'];?>')"><i class="fa fa-star-o sr-i1 sr-icon" title="Shortlist"></i></a>
                    </div>
                    <div id="remove_shortlist_<?php echo $member_data_val['matri_id'];?>" style="display:<?php if($is_short_list == 0){ echo 'none';}else{echo 'block';} ?>;">
                    <a data-toggle="modal" data-target="#myModal_shortlisted" title="Remove to Shortlist" onClick="remove_shortlist_matri_id('<?php echo $member_data_val['matri_id'];?>')"><i class="fas fa-star sr-i1 sr-icon" title="Shortlist"></i></a>
                    </div>
                </div>
                
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <a id="mob_Yes_id_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $yes_style;?>" href="javascript:;" onclick="mob_member_like('Yes','<?php echo $member_data_val['matri_id'];?>');" >
                        <i class="fas fa-check sr-i2 sr-icon" title="Like"></i>
                    </a>
                    <a id="mob_Image_Yes_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $image_yes_style;?>">
                        <i class="fas fa-check sr-i2 sr-icon" title="Liked"></i>
                    </a>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <a id="mob_No_id_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $no_style;?>" href="javascript:;" onclick="mob_member_like('No','<?php echo $member_data_val['matri_id']; ?>');">
                        <i class="fas fa-times sr-i3 sr-icon" title="Unlike"></i>
                    </a>
                    <a id="mob_Image_No_<?php echo $member_data_val['matri_id'];?>" style="<?php echo $image_no_style;?>">
                        <i class="fas fa-times sr-i3 sr-icon" title="Unliked"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="main-short-2 text-center w-100">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <p class="Poppins-Bold-font text-center" id="mob_shorted_<?php echo $member_data_val['matri_id'];?>"><?php if($is_short_list==1){echo 'Shortlisted';}else{echo 'Shortlist';}?></p>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <p class="Poppins-Bold-font text-center" id="mob_like_<?php echo $member_data_val['matri_id'];?>"><?php if(isset($member_likes_data['like_status']) && $member_likes_data['like_status']=='Yes'){ echo 'Liked';}else{echo 'Like';}?></p>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <p class="Poppins-Bold-font text-center" id="mob_unlike_<?php echo $member_data_val['matri_id'];?>"><?php if(isset($member_likes_data['like_status']) && $member_likes_data['like_status']=='No'){ echo 'Unliked';}else{echo 'Unlike';}?></p>
                </div>
            </div>
        </div>
        
        <?php if(isset($more_details) && $more_details=='Yes'){?>
        <div class="row">
            <div class="main-short-2 f-left w-100">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <button type="button" id="show_edit_btn" onClick="mob_more_details('<?php echo $member_data_val['id'];?>')" class="dshbrd_16 w-100 Poppins-Bold f-14">More Details <i class="fas fa-plus"></i></button>
                </div>
            </div>
        </div>
        <?php }?>
	</div>