<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <?php include_once('my_profile_sidebar.php');?>
        <div class="col-md-9 col-sm-9 col-xs-12">
            <?php include_once('my_dashboard_info.php');
            $curre_id = $this->common_front_model->get_session_data('id');
            if(isset($curre_id) && $curre_id!=''){
                $where_array = array('id'=>$curre_id, 'is_deleted'=>'No');
                $register_data = $this->common_model->get_count_data_manual('register_view',$where_array,1,'id,matri_id,photo1,photo2,photo3,photo4,photo5,photo6,username,email,mobile,occupation_name,mobile_verify_status,email,cpass_status,id_proof');
            }
            $path_photos = $this->common_model->path_photos;
            $member_id = $this->common_front_model->get_session_data('matri_id');
            
            if (isset($recommendedMember) && !empty($recommendedMember)) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="photo-request">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h2>Recommended Matches</h2>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                                    <h3><a href="#"></a></h3>
                                </div>
                            </div>
                            <hr class="profile-hr">
                            <div class="row margin-top-15">
                            <?php 
                            foreach ($recommendedMember as $value) { 
                                if(isset($value['gender']) && $value['gender']=='Female'){
                                    $photopassword_image = $base_url.'assets/images/photopassword_female.png';
                                }elseif(isset($value['gender']) && $value['gender']=='Male'){
                                    $photopassword_image = $base_url.'assets/images/photopassword_male.png';
                                }
                                if(isset($value['photo1']) && $value['photo1'] !='' && isset($value['photo1_approve']) && $value['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$value['photo1']) && isset($value['photo_view_status']) && $value['photo_view_status'] == 0 && $value['photo_view_count'] == 0){
                                    $photoPath = $photopassword_image;
                                    $memMatrid = '';
                                    $memMatridPhoto = "'".$member_id."'";
                                    $memMatrid = "'".$value['matri_id']."'";
                                    $photoPasswordModal = 'data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('.$memMatridPhoto.','.$memMatrid.')"';
                                }else{
                                    $photoPath = $this->common_model->member_photo_disp($value,$value['photo_view_count']);
                                    $photoPasswordModal = "href='".base_url().'search/view-profile/'.$value['matri_id']."' target='_blank'";
                                }
                                $badgeImg = '';
                                if(isset($value['badge']) && $value['badge'] !=''){
                                    $badgeImg = "<img src='".$value['badgeUrl'].$value['badge']."' style='position: absolute;top: 0px;z-index: 99;height: 90px;width: 90px;'>";
                                }
                                $badgebackStyle = "border: 3px solid ".$value['color'].";box-shadow: 0px 1px 10px 0px rgb(4 4 4 / 29%);";

                                ?>
                                <div class="col-md-3 col-sm-12 col-xs-12 text-center">
                                    <div class="pink-stamp my-profile-border">
                                        <?php echo $badgeImg;?>
                                        <div class="photo-req-box">    
                                            <a <?php echo $photoPasswordModal;?>>
                                            <img src="<?php echo $photoPath;?>" style="<?php echo $badgebackStyle;?>" title="" alt=""></a>
                                            <div class="rec-mem-title">
                                                <!-- For issue solved start 30/11/2021  -->
                                                   <h2><?php echo $value['matri_id'];?></h2>
                                                 <!-- For issue solved end 30/11/2021  -->
                                            </div>
                                            <p><?php echo $value['profile_description'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } if (isset($recentLogin) && !empty($recentLogin)) { ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="photo-request">   
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h2>Recently Login Members</h2>
                                </div>
                            </div>
                            <hr class="profile-hr">
                            <div class="row">
                                <?php 
                                foreach ($recentLogin as $value) { 
                                    if(isset($value['gender']) && $value['gender']=='Female'){
                                        $photopassword_image = $base_url.'assets/images/photopassword_female.png';
                                    }elseif(isset($value['gender']) && $value['gender']=='Male'){
                                        $photopassword_image = $base_url.'assets/images/photopassword_male.png';
                                    }
                                    if(isset($value['photo1']) && $value['photo1'] !='' && isset($value['photo1_approve']) && $value['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$value['photo1']) && isset($value['photo_view_status']) && $value['photo_view_status'] == 0 && $value['photo_view_count'] == 0){
                                        $photoPath = $photopassword_image;
                                        $memMatrid = '';
                                        $memMatridPhoto = "'".$member_id."'";
                                        $memMatrid = "'".$value['matri_id']."'";
                                        $photoPasswordModal = 'data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('.$memMatridPhoto.','.$memMatrid.')"';
                                    }else{
                                        $photoPath = $this->common_model->member_photo_disp($value,$value['photo_view_count']);
                                        $photoPasswordModal = "href='".base_url().'search/view-profile/'.$value['matri_id']."' target='_blank'";
                                    }
                                    $badgeImg = '';
                                    if(isset($value['badge']) && $value['badge'] !=''){
                                        $badgeImg = "<img src='".$value['badgeUrl'].$value['badge']."' style='position: absolute;top: -3px;z-index: 99;height: 90px;width: 90px;'>";
                                    }
                                    $badgebackStyle = "border: 3px solid ".$value['color'].";box-shadow: 1px 2px 6px #0000007d;";

                                    ?>
                                <div class="col-md-3 col-sm-12 col-xs-12 text-center">
                                    <div class="normal-stamp my-profile-border">
                                        <?php echo $badgeImg;?>
                                        <div class="rec-mem-box">    
                                            <a <?php echo $photoPasswordModal;?>>
                                                <div class="_recent-login-img" style="background-image: url('<?php echo $photoPath;?>');<?php echo $badgebackStyle;?>"></div>
                                            </a>
                                            <div class="rec-mem-title">
                                                <!-- <h2 style="color:white;"><?php //echo $value['matri_id'];?></h2> -->
                                                <!-- For issue start 29/11/2021  -->
                                                <h2 style="color:white;"><?php echo $value['matri_id'];?></h2>
                                                <!-- For issue end 29/11/2021  -->
                                            </div>
                                            <p><?php echo $value['profile_description'];?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } if (isset($recentJoin) && !empty($recentJoin)) {?>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 margin-bottom-20">
                        <div class="photo-request">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <h2>Recently Join Members</h2>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12 text-right">
                                    <h3><a href="#"></a></h3>
                                </div>
                            </div>
                            <hr class="profile-hr">
                            <div class="row margin-top-15">
                            <?php 
                                foreach ($recentJoin as $value) { 
                                    if(isset($value['gender']) && $value['gender']=='Female'){
                                        $photopassword_image = $base_url.'assets/images/photopassword_female.png';
                                    }elseif(isset($value['gender']) && $value['gender']=='Male'){
                                        $photopassword_image = $base_url.'assets/images/photopassword_male.png';
                                    }
                                    if(isset($value['photo1']) && $value['photo1'] !='' && isset($value['photo1_approve']) && $value['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$value['photo1']) && isset($value['photo_view_status']) && $value['photo_view_status'] == 0 && $value['photo_view_count'] == 0){
                                        $photoPath = $photopassword_image;
                                        $memMatrid = '';
                                        $memMatridPhoto = "'".$member_id."'";
                                        $memMatrid = "'".$value['matri_id']."'";
                                        $photoPasswordModal = 'data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('.$memMatridPhoto.','.$memMatrid.')"';
                                    }else{
                                        $photoPath = $this->common_model->member_photo_disp($value,$value['photo_view_count']);
                                        $photoPasswordModal = "href='".base_url().'search/view-profile/'.$value['matri_id']."' target='_blank'";
                                    }
                                    $badgeImg = '';
                                    if(isset($value['badge']) && $value['badge'] !=''){
                                        $badgeImg = "<img src='".$value['badgeUrl'].$value['badge']."' style='position: absolute;top: 0px;z-index: 99;height: 90px;width: 90px;'>";
                                    }
                                    $badgebackStyle = "border: 3px solid ".$value['color'].";box-shadow: 0px 1px 10px 0px rgb(4 4 4 / 29%);";

                                    ?>
                                    <div class="col-md-3 col-sm-12 col-xs-12 text-center">
                                        <div class="pink-stamp my-profile-border">
                                            <?php echo $badgeImg;?>
                                            <div class="photo-req-box">    
                                                <a <?php echo $photoPasswordModal;?>>
                                                <img src="<?php echo $photoPath;?>" style="<?php echo $badgebackStyle;?>" title="" alt=""></a>
                                                <div class="rec-mem-title">
                                                    <!-- <h2><?php //echo $value['matri_id'];?></h2> -->
                                                     <!-- For issue start 29/11/2021  -->
                                                     <h2><?php echo $value['matri_id'];?></h2>
                                                    <!-- For issue end 29/11/2021  -->
                                                </div>
                                                <p><?php echo $value['profile_description'];?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } if (empty($recentJoin) && empty($recentLogin) && empty($recommendedMember)){?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="no-data-f">
                        <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data">
                        <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
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
        <?php if($photoNo>0 && $idProof==0){ ?>
        <div class="modal-dialog modal-dialog-vendor" style="width: 50%;">
        <?php }else if($photoNo>0){ ?>
            <div class="modal-dialog modal-dialog-vendor" style="width: 30%;">
        <?php }else if($idProof==0){ ?>
        <div class="modal-dialog modal-dialog-vendor" style="width: 30%;">
        <?php } ?>
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
                            <button onclick="set_photo_number('<?php echo $photoNo;?>');popup_hide()" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Upload Photo <?php echo $photoNo;?></button>
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

$('#id_proof').on('change', function(e)
    {
        var reader = new FileReader();
        var size = this.files[0].size;
        var name = this.files[0].name;
        var size_mb = size/(1024*1024);
        if(size_mb > 3.1)
        {
            alert('Please Upload max file upload upto 3MB');
            $('#id_proof').val('');
            return false;
        }
        else
        {
        var ext = $('#id_proof').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg','bmp']) == -1)
        {
            alert( 'Please upload valid image file like png, jpg ,jpeg ,bmp and gif.');
            $('#id_proof').val('');
            return false;
        }
        else
        {
            var after_upload_url = window.URL.createObjectURL(this.files[0]);
            var form_data = new FormData(document.getElementById('id_proof_photo_form'));
            var action = $('#id_proof_photo_form').attr('action');
            show_comm_mask();
            $.ajax({
                    url: action,
                    type: 'POST',
                    data: form_data,
                    cache: false,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(data)
                    { 	
                        $('.reponse_photo').removeClass('alert alert-success alert-danger alert-warning');
                        $('.reponse_photo').html(data.errmessage);
                        $('.reponse_photo').slideDown();
    
                        if(data.status == 'success')
                        {
                            $('.reponse_photo').addClass('alert alert-success');
                            setTimeout(function() {
                                $('.reponse_photo').fadeOut('fast');
                            }, 10000);
                            $('#hash_tocken_id_temp').remove();
                            $('#photo_delete_btn').show();
                            $('#no_id_proof_msg').hide();
                            document.getElementById('blah').src = after_upload_url;
                        }
                        else
                        {
                            $('.reponse_photo').addClass('alert alert-danger');
                        }
                        update_tocken(data.tocken);
                        hide_comm_mask();
                        $('#id_proof').val('');
                    }
                });
            }
        }
    })  

"
?>
