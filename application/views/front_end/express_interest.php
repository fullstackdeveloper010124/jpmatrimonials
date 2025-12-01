<?php
$current_login_user = $this->common_front_model->get_session_data(); 
$paid_member_id = $current_login_user['id']; 
$where = array('id'=>$paid_member_id);
$pdata = $this->common_model->get_count_data_manual("register",$where,1,'plan_status','','',1);
$paid_status = $pdata['plan_status'];

$login_id = $current_login_user['matri_id'];
?>
	<div class="container-fluid new-width width-95 mt-60-pro" id="scroll_to_main">
    	<div class="row-cstm pad-lr15" id="refresh_div">
            <div class="col-md-3 col-sm-3 col-xs-12 pr-0 hidden-sm hidden-xs">
                <input type="hidden" name="exp_status" id="exp_status" value="all_sent" />
				<?php 
				$all = $this->common_model->get_count_data_manual('expressinterest',array("sender"=>$login_id,'is_deleted'=>'No'),0,'');
				//echo $this->db->last_query();
				$sent_accepted = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Accepted","sender"=>$login_id,'is_deleted'=>'No'),0,'','','');
				$sent_rejected = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Rejected","sender"=>$login_id,'is_deleted'=>'No'),0,'','','');
				$sent_pending = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Pending","sender"=>$login_id,'is_deleted'=>'No','is_deleted'=>'No'),0,'','','');
				
				$all_rec = $this->common_model->get_count_data_manual('expressinterest',array("receiver"=>$login_id,'is_deleted'=>'No'),0,'','','');
				$rec_accepted = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Accepted","receiver"=>$login_id,'is_deleted'=>'No'),0,'','','');
				$rec_rejected = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Rejected","receiver"=>$login_id,'is_deleted'=>'No'),0,'','','');
				$rec_pending = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Pending","receiver"=>$login_id,'is_deleted'=>'No'),0,'','','');
                ?>
                <div class="col-3-main hidden-sm hidden-xs">
                    <div class="list-group">
                        <a class="list-group-item visitor" href="javascript:void(0);" id="all_sent" onClick="get_express_intrest('all_sent')">
                            <p class="Poppins-Bold f-16 color-d dashbrd_3">
                                All Interest Sent
                            </p>
                            <span class="Poppins-Bold f-16 color-d dashbrd_4 all_sent"><?php echo sprintf("%02d", $all);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="accept_sent" onClick="get_express_intrest('accept_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Accepted
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 accept_sent"><?php echo sprintf("%02d", $sent_accepted);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="reject_sent" onClick="get_express_intrest('reject_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Rejected
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 reject_sent"><?php echo sprintf("%02d", $sent_rejected);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="pending_sent" onClick="get_express_intrest('pending_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Pending
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pending_sent"><?php echo sprintf("%02d", $sent_pending);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="all_receive" onClick="get_express_intrest('all_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                All Interest Received
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 all_receive"><?php echo sprintf("%02d", $all_rec);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="accept_receive" onClick="get_express_intrest('accept_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Accepted
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 accept_receive"><?php echo sprintf("%02d", $rec_accepted);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="reject_receive" onClick="get_express_intrest('reject_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Rejected
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 reject_receive"><?php echo sprintf("%02d", $rec_rejected);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="pending_receive" onClick="get_express_intrest('pending_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Pending
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pending_receive"><?php echo sprintf("%02d", $rec_pending);?></span>
                        </a>
                    </div>
                </div>
            </div>
            <!--mobile collapse-->
            <div class="col-sm-12 col-xs-12 hidden-lg hidden-md mt-4 padding-0">
                <button class="btn btn-lg btn-primary-k b-m-mobile" data-toggle="collapse" data-target="#dshbrd_mobile22"> <i class="fa fa-paper-plane f-20 pt-1 pull-left"></i> Express Interest <i class="fas fa-chevron-down pt-1 pull-right"></i></button>
                <div id="dshbrd_mobile22" class="collapse">
                    <div class="list-group">
                        <a class="list-group-item visitor" href="javascript:void(0);" id="all_sent" onClick="get_express_intrest('all_sent')">
                            <p class="Poppins-Bold f-16 color-d dashbrd_3">
                                All Interest Sent
                            </p>
                            <span class="Poppins-Bold f-16 color-d dashbrd_4 all_sent">
                            <?php echo sprintf("%02d", $all);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);"  id="accept_sent" onClick="get_express_intrest('accept_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Accepted
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 accept_sent"><?php echo sprintf("%02d", $sent_accepted);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="reject_sent" onClick="get_express_intrest('reject_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Rejected
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 reject_sent"><?php echo sprintf("%02d", $sent_rejected);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="pending_sent" onClick="get_express_intrest('pending_sent')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Sent Pending
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pending_sent"><?php echo sprintf("%02d", $sent_pending);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="all_receive" onClick="get_express_intrest('all_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                All Interest Received
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 all_receive"><?php echo sprintf("%02d", $all_rec);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="accept_receive" onClick="get_express_intrest('accept_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Accepted
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 accept_receive"><?php echo sprintf("%02d", $rec_accepted);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="reject_receive" onClick="get_express_intrest('reject_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Rejected
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 reject_receive"><?php echo sprintf("%02d", $rec_rejected);?></span>
                        </a>
                        <a class="list-group-item visitor" href="javascript:void(0);" id="pending_receive" onClick="get_express_intrest('pending_receive')">
                            <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Interest Received Pending
                            </p>
                            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pending_receive"><?php echo sprintf("%02d", $rec_pending);?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--End mobile collapse-->
        <div class="col-md-9 col-sm-12 col-xs-12 n-padding">
        <div id="express_ineterest_response"><?php include_once('express_interest_result_ajax.php');?></div>
        </div>
    </div>
</div>

<div id="myModal_sms" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_sms" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
        <?php if(isset($paid_status) && $paid_status =='Paid'){?>
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Send <span class="mega-n4 f-s">SMS</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div id="response_message"></div>
                <form class="form-group">
                    <input type="hidden" id="message_id" name="message_id" value="" />
                    <input type="hidden" id="subject" name="subject" value="Express Interest" />
                    <textarea style="padding:5px" placeholder="Message" class="form-control input-border-modal" rows="6" name="message" id="message"></textarea>
                </form>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <button type="button" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18"  onClick="send_message('sent')">Send</button>
                            <button class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18" id="send_message_cancel" data-dismiss="modal">Cancel</button>
                        </span>
                    </div>
                </div>
            </div>
		<?php }else{?>
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Upgrade Your <span class="mega-n4 f-s">Membership</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                	Please get the send message balance by upgrading your membership.
                </div>
        
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <a type="button" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" href="<?php echo $base_url.'premium-member'; ?>"><i class="fa fa-send"></i> Upgrade Now</a>
                        </span>
                    </div>
                </div>
            </div>
			<?php }?>
        </div>
    </div>
</div>

<div id="myModal_deleted" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center"> Member <span class="mega-n4 f-s">Not Exists</span></p>
                <input type="hidden" id="delete_ex_id" name="delete_ex_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>This member does not exists.</strong><br />
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>
<div id="myModal_reject" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center"> Delete This Saved Profile</p>
                <input type="hidden" id="delete_ex_id" name="delete_ex_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure want to Reject this Records?</strong><br />
                        <span class="small">This Records will be Rejected Permanently from your Entire Records.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <button class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                            <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                        </span>
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>
                
           
<div id="myModal_accept" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center"> Accept <span class="mega-n4 f-s">Request</span></p>
                <input type="hidden" id="delete_ex_id" name="delete_ex_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-big.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Do you want to Accept This Request?</strong><br />
                        <span class="small">This Profile will be Visible you Permanently.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <button class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Accept</button>
                            <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                        </span>
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>
            
<div id="myModal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center"> Delete <span class="mega-n4 f-s">Express Interest</span></p>
                <input type="hidden" id="delete_ex_id" name="delete_ex_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div id="delete_photo_message"></div>
                <div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure want to Delete this Express Interest?</strong><br />
                        <span class="small">This Records will be Deleted Permanently from your Entire Records.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                            <button onClick="change_status('delete')" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                            <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url;?>" />
<input type="hidden" name="csrf_new_matrimonial" id="hash_tocken_id" value="<?php echo $this->security->get_csrf_hash();?>" />

<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function () {
    setTimeout(function(){
        $('#remove_message1').hide();
        $('#remove_message2').hide();
        
    }, 5000);
});
load_pagination_code_front_end();
function delete_particulare(id){
    $('#delete_ex_id').val(id);
}
function message_particulare(id){
    $('#response_message').slideUp();
    $('#response_message').html('');
    $('#myModal_sms #message').val('');
    $('#response_message').removeClass('alert alert-danger alert-success');
    $('#message_id').val(id);
}";?>