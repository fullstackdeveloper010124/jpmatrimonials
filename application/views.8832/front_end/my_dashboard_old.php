<?php	
	$comm_model = $this->common_model;
	$curre_gender = $this->common_front_model->get_session_data('gender');
	$matri_id = $this->common_front_model->get_session_data('matri_id');
    $curre_id = $this->common_front_model->get_session_data('id');
    $member_id = $this->common_front_model->get_session_data('matri_id');
	$curre_data = $this->common_front_model->get_session_data();
	
	$member_data_mobile = '';
	if(isset($curre_id) && $curre_id!=''){
		$where_array = array('id'=>$curre_id, 'is_deleted'=>'No');
		$member_data_mobile = $this->common_model->get_count_data_manual('register_view',$where_array,1,'id,matri_id,photo1,username,email,mobile,occupation_name,mobile_verify_status,email,cpass_status,id_proof');
	}
	
	$mobile_num = '';
	$mobile_num_status = '';
	if(isset($member_data_mobile) && $member_data_mobile != "")
	{
		if(isset($member_data_mobile['mobile']) && $member_data_mobile['mobile']!='') 
		{
			$mobile_num = $member_data_mobile['mobile'];
		}
		if(isset($member_data_mobile['mobile_verify_status']) && $member_data_mobile['mobile_verify_status'] != '')
		{
			$mobile_num_status = $member_data_mobile['mobile_verify_status'];
		}
    }
    if(isset($member_data_mobile) && $member_data_mobile != "")
	{
		if(isset($member_data_mobile['mobile']) && $member_data_mobile['mobile']!='') 
		{
			$email = $member_data_mobile['email'];
		}
		if(isset($member_data_mobile['cpass_status']) && $member_data_mobile['cpass_status'] != '')
		{
			$email_status = $member_data_mobile['cpass_status'];
		}
	}
	//$this->common_model->extra_js_fr[] = 'js/editor.js';
	//$percentage_stored = $this->common_front_model->getprofile_completeness($curre_id);
	$where_arra_recent = array('is_deleted' => 'No', "status !='UNAPPROVED' and status !='Suspended'");
	if (isset($curre_gender) && $curre_gender != '') {
        $where_arra_recent[] = " gender != '$curre_gender' ";
	}
	
	if (isset($curre_gender) && $curre_gender == 'Male') {
		$photopassword_image = $base_url . 'assets/images/photopassword_female.png';
		} else {
		$photopassword_image = $base_url . 'assets/images/photopassword_male.png';
	}
$current_login_user = $this->common_front_model->get_session_data(); ?>
   
   <style>
       
		.testimonial .pic {
    	width: 185px;
    	height: 240px;
		}
		.testimonial .pic img {
   		 width: 185px;
    	height: 240px;
}
.pic-2{
	left:0px;
	top:175px;
}
.pic-2:before {
       content: '';
    position: absolute;
    left: 0px;
    right: 5px;
    top: 0px;
    bottom: 13px;
    background-image: linear-gradient(to bottom, rgba(255, 0, 0, 0), rgba(0, 0, 0, 0.94));
    /* opacity: 0.2; */
}

.matri-zero{
	opacity: 10;
    position: relative;
    z-index: 9999;
}
    </style> 
    
    </div>
    <div class="container-fluid width-95 mt-40-pro mt-4">
        <div class="row-cstm">
            <?php include_once('my_profile_sidebar.php');?>
        <div class="col-md-9 col-sm-9 col-xs-12 hidden-sm hidden-xs">
            <?php include_once('my_dashboard_info.php');?>
            <div class="row-cstm">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <p class="Poppins-Regular f-18 color-31 dshbrd_13">Recently Joined Members</p>
                </div>
            </div>
            <?php
                $div='i';
                $recent_profile = $this->common_model->get_count_data_manual('search_register_view', $where_arra_recent, 2, '*', 'id desc', 1, 4);
                if (isset($recent_profile) && $recent_profile != '' && count($recent_profile) > 0) {
                    /*Get Plan Badges*/
                    $badge = $this->common_front_model->getbadges($recent_profile);

                    $path_photos = $this->common_model->path_photos;
                    foreach ($recent_profile as $member_data_val) {
                        include('page_part/web_member_details.php');
             }
            }else{?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="no-data-f">
                                    <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data">
                                    <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                                </div>
                            </div>
                <?php }?>                     
            </div>
        </div>
        
        
        
        
    <div class="dshbrd_mobile_box hidden-lg hidden-md">
        <?php  //$recent_profiles = $this->common_model->get_count_data_manual('search_register_view', $where_arra_recent, 2, '*', 'id desc', 1, 4);
                    if (isset($recent_profile) && $recent_profile != '' && count($recent_profile) > 0) {?>
        <div class="row">
            <div class="col-sm-12 col-xs-12 text-center">
                <p class="Poppins-Bold f-18 color-31 dshbrd_13">Recently Joined Members</p>
            </div>
        </div>
        
        <?php
                   
                        $path_photos = $this->common_model->path_photos;
                        foreach ($recent_profile as $member_data_val) {
                            include('page_part/mob_member_details.php');
                        }
                        } ?>        
    
    
        <?php 
        $limit=4;
        $class3='p-8 pro-hidden';
        include('featured_rightsidebar.php');
        ?>
        <!--for mobile End-->
        
        
        
    </div>
    </div>
    </div>
    <?php 

    /* upload photo popup with member photo and id proof #START */
    include('my_dashboard_slider.php');
    $gender = $this->common_front_model->get_session_data('gender');
    $photo_upload_count = $this->common_model->photo_upload_count;
    if ($gender!='Male') {
        $imgPath = $base_url.'assets/front_end/img/default-photo/female.png';
    }else{
        $imgPath = $base_url.'assets/front_end/img/default-photo/male.png';
    }
    $photoNo = 0;
    $path_photos = $this->common_model->path_photos;
    for ($i=1; $i <= $photo_upload_count; $i++) { 
        $photo_clm = 'photo'.$i;
        if((isset($register_data[$photo_clm]) || !isset($register_data[$photo_clm])) && ($register_data[$photo_clm] == '' || !file_exists($path_photos.$register_data[$photo_clm]))){
            $photoNo = $i;
            break;
        }
    }
    $idProof = 0;
    $idProof_path = $this->common_model->path_id_proof;
    if(isset($register_data['id_proof']) && $register_data['id_proof'] != '' && file_exists($idProof_path.$register_data['id_proof'])){
        $idProof = 1;
    }

    if($photoNo>0 || $idProof==0){ ?>
    <div id="myModal_photo_approve" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_quick" aria-hidden="true">
        <div class="modal-dialog modal-dialog-vendor" style="width: 50%;">
            <div class="modal-content">
                <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                    <p class="Poppins-Bold mega-n3 new-event text-center">Upload <span class="mega-n4 f-s">Photos</span></p>
                    <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
                </div>
                <div class="modal-body">
                    <div class="row mt-3">
                        <?php if($photoNo>0){?>
                        <div class="col-md-<?php echo ($idProof==0?6:12); ?> col-sm-12 col-xs-12">
                            <img src="<?php echo $imgPath;?>" style="height: auto;width: 100%;">
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center hidden-lg hidden-md">
                            <button onclick="set_photo_number('1');popup_hide()" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Upload Photo <?php echo $photoNo;?></button>
                            <p class="mt-2 f-12 text-center"><b>Note:-</b>Photo must be in .JPG, .GIF or .PNG format, not larger than 3MB.</p>
                        </div>
                        <?php } if($idProof==0){?>
                        <div class="col-md-<?php echo ($photoNo>0?6:12); ?> col-sm-12 col-xs-12">
                            <img id="blah" src="<?php echo $base_url;?>assets/images/verify-image.jpg" style="height: auto;width: 100%;">
                        </div>
                        <?php }?>
                    </div>
                    <div class="row mt-3">
                        <?php if($photoNo>0){?>
                        <div class="col-md-<?php echo ($idProof==0?6:12); ?> col-sm-12 col-xs-12 text-center hidden-sm hidden-xs">
                            <button onclick="set_photo_number('<?php echo $photoNo;?>');popup_hide()" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Upload Photo <?php echo $photoNo;?></button>
                            <p class="mt-2 f-12 text-center"><b>Note:-</b>Photo must be in .JPG, .GIF or .PNG format, not larger than 3MB.</p>
                        </div>
                        <?php } if($idProof==0){?>
                        <div class="col-md-<?php echo ($photoNo>0?6:12); ?> col-sm-12 col-xs-12 text-center">
                            <form method="post" name="id_proof_photo_form" id="id_proof_photo_form" enctype="multipart/form-data" action="<?php echo $base_url; ?>upload/upload-id-proof-photo" >
                                <div class="reponse_photo"></div>
                                <label class="add-w-btn new-id-s-photo btn-file upload-horoscope Poppins-Regular f-14 color-f" style="width: 60%;padding: 8px 9px;font-size:18px;">
                                <span style="font-size: 18px;font-weight: 500;"> Upload Id Proof </span>
                                    <input type="file" id="id_proof" name="id_proof" style="display: none;">
                                </label>
                                <p class="mt-2 f-12 text-center"><b>Note:-</b>Photo must be in .JPG, .GIF or .PNG format, not larger than 3MB.</p>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            </form>
                            <!-- <button onclick="set_photo_number('1')" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Upload Id Proof</button> -->
                        </div>
                        <?php }?>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <span class="pull-right float-none">
                                <button class="add-w-btn new-msg-btn Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    include_once('page_part/modify_photo_popup.php');
    /* upload photo popup with member photo and id proof #END */

    ?>
				<?php
								if ($mobile_num != '' && $mobile_num_status == 'No')
								{
								?> 
                                	<span data-toggle="modal" data-target="#myModal_verify_mobile" id="myModal_verify_mobile_btn" class="profile-secure5" style="cursor:pointer" title="Mobile Number Not Verified" style="display:none;"></span>                                	
								<?php } else if($photoNo>0 || $idProof==0){ ?>
                                    <span data-toggle="modal" data-target="#myModal_photo_approve" id="myModal_photo_approve_btn" class="profile-secure5" style="cursor:pointer" title="Photo & Id Proof Upload" style="display:none;"></span>  
								<?php }?>
                
                <?php
	if ($mobile_num != '' && $mobile_num_status == 'No')
	{
		$this->common_model->js_extra_code_fr .= " $('#myModal_verify_mobile_btn').trigger('click');";
    }else if($photoNo>0 || $idProof==0){
        $this->common_model->js_extra_code_fr .= " $('#myModal_photo_approve_btn').trigger('click');";
    }
    include('page_part/front_button_popup.php');
$this->common_model->js_extra_code_fr .= "

function popup_hide(){
    $('#myModal_photo_approve').modal('hide');
    $('#myModal_pic').modal('show');
    setTimeout(function(){ $('body').addClass('modal-open'); }, 1000);
}
$('#myModal_verify_mobile button[data-dismiss=\"modal\"]').on('click',function(){
    setTimeout(function(){ $('#myModal_photo_approve').modal('show'); }, 1000);
});
$('#myModal_pic button[data-dismiss=\"modal\"]').on('click',function(){
    setTimeout(function(){ $('body').removeClass('modal-open'); }, 1000);
});
/*for action hide show start*/
function more_details(id){
	$('#more_details_btns_'+id).fadeToggle();
	//scroll_to_div('more_details_btns_'+id);
}

function mob_more_details(id){
	$('#mob_more_details_btns_'+id).fadeToggle();
	//scroll_to_div('mob_more_details_btns_'+id);
};
/*for action hide show end*/

load_choosen_code();
$('.button-wrap').on('click', function(){
    $(this).toggleClass('button-active');
});

function fields(field)
{
    var value = $('#'+field).val();
    if(value=='')
    {
        alert('Please Add/Select Value');
    }
    else
    {
        var val = value;
        show_comm_mask();
    }
    var hash_tocken_id = $('#hash_tocken_id').val();
    var base_url = $('#base_url').val();
    var url = base_url+'my-dashboard/update-percentage-slider-field';
    $.ajax({
        url: url,
        type: 'POST',
        data:{'csrf_new_matrimonial':hash_tocken_id,'val':val,'field':field},
        dataType:'json',
        success: function(data) 
        { 	
            if(data.status == 'success')
            {
                $('#my_dashboard_slider_ajax').html(data.my_dashboard_data);
                update_tocken($('#hash_tocken_id_temp').val());
                setTimeout(function() {
                $('#update_field_success').fadeOut('fast');
                }, 5000);
                $('#progress_bar').html(data.progress);
                $('#hash_tocken_id_temp').remove();
            }
            $('#hash_tocken_id').val(data.token);
            hide_comm_mask();
        }
    });
    return false;
}

var win = null;
function newWindow(mypage,myname,w,h,features) {
    var winl = (screen.width-w)/2;
    var wint = (screen.height-h)/2;
    if (winl < 0) winl = 0;
    if (wint < 0) wint = 0;
    var settings = 'height=' + h + ',';
    settings += 'width=' + w + ',';
    settings += 'top=' + wint + ',';
    settings += 'left=' + winl + ',';
    settings += features;

    win = window.open(mypage,myname,settings);
    win.window.focus();
}

var markup ='';
	$('head').append(markup);
";
?>