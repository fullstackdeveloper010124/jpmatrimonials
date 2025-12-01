<?php
if(!isset($shortlist_data_count) || $shortlist_data_count =='')
{
	$shortlist_data_count = 0; 
}
$curre_gender = $this->common_front_model->get_session_data('gender');
if (isset($curre_gender) && $curre_gender == 'Male') {
    $photopassword_image = $base_url . 'assets/images/photopassword_female.png';
} else {
    $photopassword_image = $base_url . 'assets/images/photopassword_male.png';
}
if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Total Result:
            <span class="color-d"><?php echo $shortlist_data_count; ?> Found</span></p>
    </div>
</div>
<?php }?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-sm-12 col-md-12 col-xs-12">
        <div class="alert alert-success" id="unblock_success" style="display:none"></div>
        <div class="alert alert-success" id="delete_success" style="display:none"></div>
    </div>
</div>
<?php 
/*Get Plan Badges*/
$badge = $this->common_front_model->getbadges($shortlist_data);
if(isset($shortlist_data) && $shortlist_data !='' && is_array($shortlist_data) && count($shortlist_data) > 0){
    $shortlistData = $this->common_front_model->process_data_activity($shortlist_data);
	foreach($shortlistData as $shortlist_profile){

        $badgebackStyle = $badgeUrl = $badgeImg = $color = '';
        if (isset($shortlist_profile['plan_id']) && $shortlist_profile['plan_id']>0 && isset($shortlist_profile['plan_status']) && $shortlist_profile['plan_status']=='Paid') {
            $badgePath = $this->common_model->path_payment_logo;
            if (isset($badge['badge'][$shortlist_profile['plan_id']]) && $badge['badge'][$shortlist_profile['plan_id']]!='' && file_exists($badgePath.$badge['badge'][$shortlist_profile['plan_id']])) {
                $badgeUrl = $base_url.$badgePath.$badge['badge'][$shortlist_profile['plan_id']];
                $badgeImg = "<img src = '".$badgeUrl."' style='position: absolute;right: -10px;top: -20px;z-index: 99;height: 90px;width: 90px;'/>";
            }
            
            if (isset($badge['color'][$shortlist_profile['plan_id']]) && $badge['color'][$shortlist_profile['plan_id']]!='') {
                $color = $badge['color'][$shortlist_profile['plan_id']];
            }
        }
        if($color == ''){
            $color = $this->common_model->data['config_data']['profile_border_color'];
        }
        $badgebackStyle = "box-shadow: 0px 2px 8px -1px ".$color."!important;border-radius: 6px;border-top: 4px solid ".$color.";position: relative;";

		$deleted = $shortlist_profile['deleted'];
   		if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){?>
			<div class="p_b1_in">
		<?php }
		if(isset($page_name) && $page_name != 'Privacy setting Block Listed Profile'){?>
		<div class="row mt-4">
			<div class="col-md-12 col-xs-12 col-sm-12 padding-zero">
            	<div class="design-process-content-like das-content-2 padding-0">
				<?php }?>
                    <div class="box-view-profile" style="<?php echo $badgebackStyle;?>">
                        <?php echo $badgeImg;?>
                        <div class="row">
                            <div class="col-md-1 col-xs-12 col-sm-1 <?php if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){ echo 'padding-0';}?>">
                                <?php
                                $member_id=$this->common_front_model->get_session_data('matri_id');
                                $photo_view_count = $this->common_front_model->photo_protect_count($member_id,$shortlist_profile['matri_id']);
                                if(isset($shortlist_profile['photo1']) && $shortlist_profile['photo1'] !='' && $shortlist_profile['photo1_approve'] =='APPROVED' && $shortlist_profile['photo_view_status'] == 0 && $photo_view_count == 0){?>
                                    <a href="<?php echo $base_url; ?>search/view-profile/<?php echo $shortlist_profile['matri_id'];?>" target="_blank"><img src="<?php echo $photopassword_image; ?>" class="like-img" title="<?php echo $shortlist_profile['username'];?>" alt=""/></a>
                                <?php }
                                else{?>
                                    <a href="<?php echo $base_url; ?>search/view-profile/<?php echo $shortlist_profile['matri_id'];?>" target="_blank"><img src="<?php echo $this->common_model->member_photo_disp($shortlist_profile,$photo_view_count);?>" class="like-img" title="<?php echo $shortlist_profile['username'];?>" alt=""/></a>
                                <?php }?>
                            </div>
                            <div class="col-md-11 col-xs-12 col-sm-11 like-p-l-0">
                                <p class="p-search like-margin-b">
                                    <?php echo $shortlist_profile['matri_id'];?> / 
                                    <span class="  Poppins-Regular f-14 like-color color-65"><?php if(isset($file_name) && ($file_name == 'who_contacted_profile' || $file_name == 'i_contacted_profile')){  echo $this->common_model->displayDate($shortlist_profile['date'],'D, jS, F - Y'); }else{ echo $this->common_model->displayDate($shortlist_profile['created_on'],'D, jS, F - Y');}?>
                                        <span class="Poppins-Regular f-15">
                                            <?php if(isset($page_name) && ($page_name == 'Short Listed Profile' || $page_name == 'I Viewed Profile' || $page_name == 'Who Viewed My Profile')){?>
                                                <a class="btn-delete" data-toggle="modal" onClick="delete_particulare('<?php echo $shortlist_profile['matri_id'];?>','<?php echo $page_name;?>');" data-target="#myModal_delete" title="Delete"><i class="fas fa-trash-alt color-d m-left-s"></i></a>
                                            <?php }?>
                                        </span>
                            		</span>
                				</p>
                				<hr class="like-hr">
                                <p class="f-15 color-65 pt-2">
                                    <?php echo $shortlist_profile['profile_description'];?>
                                </p>
                                
								<?php if($deleted=='Yes'){?>
                                    <p><div style="color:#e35120;"><strong>This member does not exists.</strong></div></p>
                                <?php }?>
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 col-sm-12">
                                        <span class="pull-right float-none">
                                        <?php if(isset($page_name) && ($page_name == 'Privacy setting Block Listed Profile' || $page_name == 'Block Listed Profile')){
                                            if($deleted == 'Yes'){?>
                                                <a data-toggle="modal" data-target="#myModal_deleted" title="Block/Unblock" class="mega-n-btn1 like-btn post-s-d Poppins-Regular color-f f-14">Unblock</a> 
                                            <?php 
                                            }
                                            else{?>
                                                <a onClick="unblock_particulare('<?php echo $shortlist_profile['id'];?>','<?php echo $shortlist_profile['matri_id'];?>')" data-toggle="modal" data-target="#myModal_unblock" title="Block/Unblock" class="mega-n-btn1 like-btn post-s-d Poppins-Regular color-f f-14">Unblock</a>  
                                        <?php 
                                            }
                                        }
                                        else if(isset($page_name) && ($page_name == 'Short Listed Profile' || $page_name == 'Like Profile' || $page_name == 'Unlike Profile' || $page_name == 'I Viewed Profile' || $page_name == 'Who Viewed My Profile' || $page_name == 'Viewed My Contact' || $page_name == 'I Viewed Contact')){?>
                                            <a href="<?php echo $base_url; ?>search/view-profile/<?php echo $shortlist_profile['matri_id'];?>" target="_blank" class="mega-n-btn1 like-btn post-s-d Poppins-Regular color-f f-14">
                                                View Profile
                                            </a>    
                                        <?php }
                                        if(isset($page_name) && $page_name == 'Like Profile'){ ?>
                                            <a href="javascript:;" onclick="member_like('No','<?php echo $shortlist_profile['matri_id']; ?>','<?php echo $deleted;?>');" class="mega-n-btn1 like-btn  post-s-d Poppins-Regular color-f f-14" title="No">Unlike
                                            </a>
                                        <?php }
                                        else if(isset($page_name) && $page_name == 'Unlike Profile'){ ?>
                                            <a href="javascript:;" onclick="member_like('Yes','<?php echo $shortlist_profile['matri_id'];?>','<?php echo $deleted;?>');" class="mega-n-btn1 like-btn  post-s-d Poppins-Regular color-f f-14" title="Yes">Like
                                            </a>
                                        <?php }?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    				<?php if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){ echo '</div>';}
					if(isset($page_name) && $page_name != 'Privacy setting Block Listed Profile'){ echo '</div></div></div>';}
				}
				if(isset($shortlist_data_count) && $shortlist_data_count !='' && $shortlist_data_count > 0){
					if(isset($page_name) && $page_name=='Privacy setting Block Listed Profile'){ 
						$url = 'privacy-setting/block-listed/';
					}
					if(isset($page_name) && $page_name =='Short Listed Profile'){ 
						$url = 'my-profile/short-listed/';
					}
					else if(isset($page_name) && $page_name =='Block Listed Profile'){
						$url = 'my-profile/block-listed/';
					}
					else if(isset($page_name) && $page_name =='I Viewed Profile'){
						$url = 'my-profile/i-viewed/';
					}
					else if(isset($page_name) && $page_name =='Who Viewed My Profile'){
						$url = 'my-profile/who-viewed/';
					}
					else if(isset($page_name) && $page_name =='Saved Searches'){
						$url = 'my-profile/saved/';
					}
					else if(isset($page_name) && $page_name =='Like Profile'){
						$url = 'my-profile/like-profile/';
					}
					else if(isset($page_name) && $page_name =='Unlike Profile'){
						$url = 'my-profile/unlike-profile/';
					}?>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="pagination-wrap <?php if(isset($page_name) && $page_name!='Privacy setting Block Listed Profile'){ echo 'mt-0';}?>">
                            <?php echo $this->common_model->rander_pagination_front($url,$shortlist_data_count,10);?>
                        </div>
                    </div>
                <?php }
			}else{
				if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){?>
                    <div class="p_b1_in">
                <?php }?>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="no-data-f">
                               <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                               <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                            </div>
                        </div>
                    </div>
                	<?php if(isset($page_name) && $page_name == 'Privacy setting Block Listed Profile'){?></div>
				<?php }
			}

$is_login = $this->common_front_model->checkLogin('return');?>

<div id="myModal_unblock" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_shortlist" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Profile Currently <span class="mega-n4 f-s">Blocked</span></p>
                <input type="hidden" id="matri_id" name="matri_id" value="" />
                <input type="hidden" id="unblock_id" name="unblock_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            <?php if(isset($is_login) && $is_login!=0){?>
                <div id="shortlist_profile_message"> </div>
                <div id="shortlist_profile_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-ban2.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>This Profile Currently Blocked</strong><br />
                        <span class="small">This Profile has been Blocked Permanently.</span>
                    </div>
                </div>
                <div class="text-center">
                    <img src="<?php echo $base_url;?>assets/front_end/images/icon/download.png" alt="" class="text-center">
                </div>
                
                <div class="alert alert-success margin-top-10" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url;?>assets/front_end/images/icon/user-unblock.png" alt="" class="margin-right-10">
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong class="text-black">Do you want to Unblock this Profile</strong><br>
                        <span class="small text-black">This Profile will be Unblock<em>(Show)</em> Permanently.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <div id="shortlist_button">
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" onClick="unblock_profile('unblock','','')">Unblock</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                            </div>
                            <div id="shortlist_button_close" style="display:none;">
                                <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </div>
                        </span>
                    </div>
                </div>
                <?php }else{?>
                    <div class="col-md-12 col-sm-12 col-xs-12 alert alert-danger">
                        <strong>&nbsp;&nbsp;Please Login to access this feature.</strong>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <div class="pull-right float-none">
                                <div class="add-w-btn">
                                    <a href="<?php echo base_url();?>login" class="new-msg-btn left-zero-msg Poppins-Medium color-f f-18"><b>Log In</b></a>
                                </div>
                            </div>
                        </div>
                    </div>
				<?php }?>
            </div>
        </div>
    </div>
</div>

<div id="myModal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Delete This Saved <span class="mega-n4 f-s">Profile</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
	            <div id="delete_photo_message"></div>
				<div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure you want to Remove this Profile?</strong><br />
						<span class="small">This Profile will be remove Permanently from your saved Records.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <button onClick="common_delete_list_all_profile()" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                            <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
<input type="hidden" name="page_name" value="<?php echo $page_name; ?>" id="page_name" />
<input type="hidden" name="delete_matri_id" value="" id="delete_matri_id" />
<?php
	
$this->common_model->js_extra_code_fr.="
	function unblock_particulare(id,matri_id){
		$('#unblock_id').val(id);
		$('#matri_id').val(matri_id);
	}
	
	function delete_particulare(delete_matri_id,page_name)
	{
		$('#page_name').val(page_name);
		$('#delete_matri_id').val(delete_matri_id);
	}
	
	function member_like(like_status='',other_id='',deleted){
		if(like_status == ''){
			alert('Please try again..!!!');
			return false;
		}
		if(other_id == ''){
			alert('Please try again..!!!');
			return false;
		}
		if(deleted == 'Yes'){
			alert('This member not exists!');
			return false;
		}
		var hash_tocken_id = $('#hash_tocken_id').val();
		var base_url = $('#base_url').val();
		var url = base_url+'search/member-like';
		show_comm_mask();
			$.ajax({
			  	url: url,
				type: 'POST',
				data: {'csrf_new_matrimonial':hash_tocken_id,'like_status':like_status,'other_id':other_id},
				dataType:'json',
				success: function(data)
				{
					if(data.status == 'success'){
						window.location.reload(true);
					}else{
						alert(data.errmessage);
					}
					update_tocken(data.tocken);
					hide_comm_mask();
			  	}
			});
		return false;
	}	
	";
?>