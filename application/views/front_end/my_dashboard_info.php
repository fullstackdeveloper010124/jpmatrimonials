<?php $curre_id = $this->common_front_model->get_session_data('id');
$percentage_stored = $this->common_front_model->getprofile_completeness($curre_id);
$photoNo = 0;
$photo_upload_count = $this->common_model->photo_upload_count;
$path_photos = $this->common_model->path_photos;
for ($i=1; $i <= $photo_upload_count; $i++) { 
    $photo_clm = 'photo'.$i;
    // if((isset($member_data_mobile[$photo_clm]) || !isset($member_data_mobile[$photo_clm])) && ($member_data_mobile[$photo_clm] == '' || !file_exists($path_photos.$member_data_mobile[$photo_clm]))){
    //     $photoNo = $i;
    //     break;
    // }
    if(isset($member_data_mobile[$photo_clm]) && $member_data_mobile[$photo_clm] != ''  && file_exists($path_photos.$member_data_mobile[$photo_clm])){
        $photoNo =$photoNo +1;
    }
}
if ($photoNo>1) {
    //$photoNo = $photoNo - 1;
}
?>
    <div class="profile-main-bg-1">
        <div class="col-md-3 col-sm-12 col-xs-12 pl-0 pr-0 ">
            <div class="profile-pic-main">
                <?php if(isset($member_data_mobile['photo1']) && $member_data_mobile['photo1']!=''){?>
                    <a href="<?php echo $base_url; ?>my-profile"><img src="<?php echo $base_url.$this->common_model->path_photos.$member_data_mobile['photo1'];?>" alt="<?php if(isset($current_login_user['username']) && $current_login_user['username'] !=''){ echo ucwords($current_login_user['username']);} ?>"></a>
                <?php }else{?>
                    <a href="<?php echo $base_url; ?>my-profile"><img src="<?php echo $defult_photo;?>" alt="<?php if(isset($current_login_user['username']) && $current_login_user['username'] !=''){ echo ucwords($current_login_user['username']);} ?>"></a>
                <?php }?>
                <a href="<?php echo $base_url.'modify-photo';?>">
                    <div class="edit-bg-s">
                        <i class="fas fa-pen"></i>
                    </div>
                </a>
                <div class="view-pro-c" onclick="window.location.href='<?php echo $base_url.'my-profile/who-viewed';?>'">
                    <i class="fas fa-eye"></i> <span> <?php echo sprintf("%02d", $view_my_data);?></span>
                </div>
                <div class="photo-pro-c" onclick="window.location.href='<?php echo $base_url.'modify-photo';?>'">
                    <i class="fas fa-plus"></i> <span>0<?php echo $photoNo?></span>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">
            <div class="row">
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="profile-user-name">
                        <a href="<?php echo $base_url; ?>my-profile"><h3><?php if(isset($current_login_user['username']) && $current_login_user['username'] !=''){ echo ucwords($current_login_user['username']);} ?></h3></a>
                        <p><?php if(isset($member_data_mobile['occupation_name']) && $member_data_mobile['occupation_name'] !=''){ echo $member_data_mobile['occupation_name'];} ?></p>
                    </div>
                </div>
                <div class="col-md-7 col-sm-12 col-xs-12 hidden-sm hidden-xs">
                    <div class="progress-pro">
                        <div class="col-md-4 pr-0 pl-0">
                            <a href="<?php echo $base_url; ?>my-profile" titles="View Profile"><button style="width: 80%;font-size: 10px;">View Profile</button></a>
                        </div>
                        <div class="col-md-2 pr-0 pl-0">
                            <a href="<?php echo $base_url; ?>upload/horoscope" class="tooltip-my-dashborad" titles="Horoscope Upload"><button><i class="fas fa-star f-14"></i></button></a>
                        </div>
                        <div class="col-md-2 pr-0 pl-0">
                            <a href="<?php echo $base_url; ?>upload/video" class="tooltip-my-dashborad" titles="Video Upload"><button><i class="fas fa-play-circle f-14"></i></button></a>
                        </div>
                        <div class="col-md-2 pr-0 pl-0">
                            <a href="<?php echo $base_url; ?>modify-photo" class="tooltip-my-dashborad" titles="Photo Upload"><button><i class="fas fa-image f-14"></i></button></a>
                        </div>
                        <div class="col-md-2 pr-0 pl-0">
                            <a href="<?php echo $base_url; ?>upload/id_proof" class="tooltip-my-dashborad" titles="Id Proof Upload"><button><i class="fas fa-id-card f-14"></i></button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row margin-top-15 hidden-sm hidden-xs">
                <div class="for-detail-gray">
                    <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                        <h4>Matri ID</h4>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                        <h5><?php if(isset($current_login_user['matri_id']) && $current_login_user['matri_id'] !=''){ echo $current_login_user['matri_id'];} ?></h5>
                    </div>
                </div>
                <div class="for-detail-white">
                    <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                        <h4>Date of birth</h4>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                        <h5><?php if(isset($member_data_mobile['birthdate']) && $member_data_mobile['birthdate'] !=''){echo date("d-m-Y", strtotime($member_data_mobile['birthdate']));} ?></h5>
                    </div>
                </div>
                <div class="for-detail-gray">
                    <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                        <h4>Work Phone</h4>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                        <h5><?php if(isset($member_data_mobile['mobile']) && $member_data_mobile['mobile'] !=''){ echo $member_data_mobile['mobile'];} ?></h5>
                    </div>
                </div>
                <div class="for-detail-white">
                    <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                        <h4>Email</h4>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12 ">
                        <h5><?php if(isset($member_data_mobile['email']) && $member_data_mobile['email'] !=''){ echo $member_data_mobile['email'];} ?></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12 pl-0 pr-0 hidden-xs hidden-sm">
            <div class="partner-pre-bg">
                <div class="bg-ic-patner hidden-sm hidden-xs">
                    <img src="<?php echo $base_url; ?>assets/images/partber-p.png" alt="">
                    <div style="margin-top:0px;" class="progress-pro">
                        <div class="col-md-2 pr-0 pl-0">
                            <button><a href="<?php echo $base_url; ?>my-profile"><i class="fas fa-pen"></i></a></button>
                        </div>
                        <span class="progressbar-value Poppins-Regular  dshbrd_progree_lable vel-for"> <span style="margin-top:5px ;" class="vel-for"><?php echo $percentage_stored; ?></span><span class="vel-for">% Completed Profile</span></span>
                        <div class="progressbar-title red">
                            <div style="width: 143px; margin:auto;" class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $percentage_stored; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percentage_stored; ?>%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mail-ver-1 hidden-sm hidden-xs">
                    <?php if (isset($mobile_num) && $mobile_num!='' && isset($mobile_num_status) && $mobile_num_status == 'Yes') { ?>
                        <a href="javascript:void(0);">
                            <button>
                                <span>
                                    <img src="<?php echo $base_url.'assets/images/verified-mobile.png';?>" alt="">
                                </span> Mobile Verified
                            </button>
                        </a>    
                    <?php }else{?>
                        <a href="#myModal_verify_mobile" data-toggle="modal" id="myModal_verify_mobile_btn"><button> <span><img src="<?php echo $base_url; ?>assets/images/ver-mobile.png" alt=""></span> Mobile Verify</button></a>    
                    <?php }?>
                </div>
                <div class="mail-ver-1 hidden-sm hidden-xs">
                    <?php if (isset($email) && $email!='' && isset($email_status) && $email_status == 'Verify') {?>
                        <a href="javascript:void(0);">
                            <button>
                                <span>
                                    <img src="<?php echo $base_url; ?>assets/images/verified-email.png" alt="">
                                </span> Email Verified
                            </button>
                        </a>
                    <?php }else{?>
                        <a href="#myModal_verify_email" data-toggle="modal" id="myModal_verify_email_btn"><button> <span><img src="<?php echo $base_url; ?>assets/images/ver-email.png" alt=""></span> Email Verify</button></a>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
    <?php 
    if ($mobile_num != '' && $mobile_num_status == 'No') { ?>  
        <div class="modal modal-sm fade varify_mobile_no in" id="myModal_verify_mobile" role="dialog" style="width: 100%;">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content varify_mobile_content" style="width: 60%;border-radius: 6px;margin: auto;height: auto;">
                    <div class="modal-header header_t1">
                        <button type="button" class="close close_modal" data-dismiss="modal">×</button>
                        <p class="modal-title title_v1 Poppins-Semi-Bold color-f f-20">Verify Your Mobile</p>
                    </div>
                    <div class="alert alert-danger" style="display:none" id="error_message_mv"></div>
                    <div class="alert alert-success" style="display:none" id="success_message_mv"></div>
                    <div id="displ_mobile_generate">
                        <div class="modal-body">
                            <label>Your Mobile Number</label>
                            <div style="display:flex; align-item:center; justify-content:space-between;">
                            <select name="country_code" id="country_code" required style="height:40px;margin-top: 6px;width: 21%;padding:6px;" class="form-control valid" disabled>
                                <?php 
                                    $mobile_num_arr = explode('-',$mobile_num);
                                    $country_code = $mobile_num_arr[0];
                                    $mobile = $mobile_num_arr[1];
                                ?>
                                <option value="">Select Country Code</option>
                                <?php echo $this->common_model->country_code_opt($country_code);?>
                            </select>
                            <input readonly value="<?php echo $mobile; ?>" type="text" placeholder="Your Mobile Number" class="form-control mt-2" id="mobile_number_verify" style="padding: 20px; width:60%;" />
                            <button id="editMobileVerify" data-toggle="tooltip" data-placement="top" title="Click To Edit"style="border: none;
    width: 10%;
    background: #333333;
    color: white;
    border-radius: 6px;
    height: 42px;
    display: flex;
    align-items: center;
    margin-top: 5px;
    width: 42px;
    justify-content: center;"><i class="fas fa-pen" ></i></button>
                            </div>
                        </div>
                        <div class="modal-footer footer_t1" style="display:flex;justify-content:center;">
                            <div class="footer_btn2">
                                <button type="button" onclick="return generate_otp_verify()" class="generate_otp_btn_m"><i class="fa fa-send send_icon"></i>Generate OTP</button>
                                <button type="button" class="generate_otp_btn_m ml-16" data-dismiss="modal"><i class="fas fa-times send_icon"></i>Close</button>
                            </div>
                        </div>
                    </div>
                    <div id="verify_mobile_cont" style="display:none">
                        <form class="form-group">
                            <div class="modal-body">        
                                <label>Verification Code</label>
                                <input id="otp_mobile" value="" type="text" placeholder="Enter OTP Received on Your Mobile" class="form-control mt-2" />
                                <span>
                                     <!-- For resend timer start 25/11/2021 -->
                                     <a href="javascript:;"  id="res_btn" onClick="return generate_otp_verify('yes')">Resend OTP</a>
                                            <span style="display: none;" id ="is_timer" >Time left : <span id="timer" style="color: red"></span></span>
                                     <!-- For resend timer end 25/11/2021 -->
                                </span>
                            </div> 
                            <div class="modal-footer footer_t1">
                                <div class="footer_btn2">
                                    <button type="button" onClick="return varify_mobile_check()" class="generate_otp_btn_m"><i class="fa fa-send send_icon"></i>Verify OTP</button>
                                    <button type="button" class="generate_otp_btn_m ml-16" data-dismiss="modal"><i class="fas fa-times send_icon"></i>Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php }

    if($email!='' && $email_status == 'Not-Verify'){ ?> 

        <div class="modal modal-sm fade varify_mobile_no" id="myModal_verify_email" role="dialog">
            <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content varify_mobile_content">
                <div class="modal-header header_t1">
                    <button type="button" class="close close_modal" data-dismiss="modal">&times;</button>
                    <p class="modal-title title_v1 Poppins-Semi-Bold color-f f-16"><img src="<?php echo $base_url; ?>assets/front_end_new/images/varify_icon.png" class="img-varify" alt="">Confirm Your Email</p>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display:none" id="error_message_ev"></div>
                    <div class="alert alert-success" style="display:none" id="success_message_ev"></div>
                    <div id="displ_email_generate">
                        <input type="hidden" id="base_url" value="<?php echo $base_url;?>">
                        <label>Click button to send email for confirm your email address..!</label>
                    </div>
                </div>
                <div class="modal-footer footer_t1">
                    <div class="footer_btn2">
                        <button type="button" onClick="return resend_confirm_mail('<?php echo $curre_id;?>')" class="generate_otp_btn_m"><i class="fa fa-send send_icon"></i>Confirm Email</button>
                        <button type="button" class="generate_otp_btn_m ml-16" data-dismiss="modal"><i class="fas fa-times send_icon"></i>Close</button>
                    </div>
                </div>
            </div>

            </div>
        </div>
    <?php } 
    
    $this->common_model->js_extra_code_fr .= "
    function resend_confirm_mail(user_id)
    {
        // For resend timer start 25/11/2021 
        $(document ).ready(function() {
            $('#is_timer').hide();
        });
        // For resend timer end 25/11/2021 
        var base_url = $('#base_url').val();
        var action = base_url +'my_dashboard/resend_confirm_mail';
        var hash_tocken_id = $('#hash_tocken_id').val();
        show_comm_mask();
        $.ajax({
            url: action,
            type: 'post',
            dataType:'json',
            data: {'csrf_new_matrimonial':hash_tocken_id,'user_id':user_id},
            success:function(data)
            {
                update_tocken(data.tocken);
                if(data.status == 'success')
                {
                    $('#error_message_ev').hide();
                    $('#success_message_ev').html(data.success_message);
                    $('#success_message_ev').show();
                    
                    setTimeout(function(){ 
                        $('#success_message_ev').fadeOut('fast');
                    },10000);
                }
                else
                {
                    $('#success_message_ev').hide();
                    $('#error_message_ev').html(data.error_message);
                    $('#error_message_ev').show();
                    setTimeout(function(){ 
                        $('#error_message_ev').fadeOut('fast');
                    },10000);
                }
                hide_comm_mask();
            }
        });
        return false;
    }";    
    ?>
         