<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php include_once('my_dashboard_info.php');?>
			<div class="row mt-4">
                <div class="col-md-12 col-xs-12 col-sm-12 padding-zero">
                    <div class="design-process-content-photo das-content-2 padding-0"> 
                        <div class="box-view-profile">
                            <p class="Poppins-Semi-Bold mega-n3 f-20 text-center">DELETE PROFILE<span class="mega-n4 f-20"> REQUEST TO ADMIN </span></p>
                        </div>
                        <hr class="hr-view">
                        
                        <div class="box-view-profile">
							<?php if($this->session->flashdata('success_message')){?>
                                <div class="alert alert-success" id="request_to_admin"><?php
                                    echo $this->session->flashdata('success_message'); ?>
                                </div>
                            <?php }else if($this->session->flashdata('error_message')){?>
                                <div class="alert alert-danger" id="request_to_admin"><?php
                                    echo $this->session->flashdata('error_message'); ?>
                                </div>
                            <?php }
							if($this->session->flashdata('message_for_user')){?>
                                <div class="alert alert-danger"><?php
                                    echo $this->session->flashdata('message_for_user');?>
                                </div>
							<?php }?>
                            <form action="<?php echo $base_url; ?>my-profile/send_delete_reason_admin" method="post" name="del_request" id="del_request" enctype="multipart/form-data">
                            <div class="row" style="margin-bottom:10px;">
                                <div class="col-md-12 col-xs-12 col-sm-4">
                                    <p class="Poppins-Medium f-16 text-center">Enter Your Reason For Deleting Your Profile : <span class="color-d">*</span>
                                    </p> 
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="text-area-center">
                                        <textarea class="form-control ni-input" rows="8" placeholder="Enter Your Reason Here" name="reason" id="reason" required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-bottom:10px;">
                                <div class="col-md-4 col-xs-12 col-sm-12">
                                    <div class="add-ad-btn">
                                        <button type="submit" class="conatct-to-admin w-100 Poppins-Medium color-f f-18">
                                             Request For Delete Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>