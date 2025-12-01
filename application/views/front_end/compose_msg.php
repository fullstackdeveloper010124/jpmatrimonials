<!-- ==== Compose New Message ==== -->
<?php
$message = '';
$message_id = '';
$receiver_id ='';
if(isset($msg_id) && $msg_id !=''){
	$msg_id = $this->common_model->descrypt_id($msg_id);
	$matri_id = $this->common_front_model->get_user_id('matri_id');
	$where_arra = array('id'=>$msg_id,'is_deleted'=>'No');
	$data_arr_message = $this->common_front_model->get_count_data_manual('message',$where_arra,1);
	if(isset($data_arr_message) && $data_arr_message !='' && is_array($data_arr_message) && count($data_arr_message) > 0){
		$gender = $this->common_front_model->get_user_id('gender');
		
		if(isset($mode) && (($mode=='draft' && $data_arr_message['sender'] == $matri_id && $data_arr_message['status'] =='draft') || $mode=='forward')){
			$message = $data_arr_message['content'];
		}
		if(isset($mode) && ($mode=='draft' || $mode=='reply')){
			if(isset($data_arr_message['receiver']) && $matri_id != $data_arr_message['receiver']){
				$receiver_id = $data_arr_message['receiver'];
			}
			else if(isset($data_arr_message['sender']) && $matri_id != $data_arr_message['sender']){
				$receiver_id = $data_arr_message['sender'];
			}
			
			if($mode =='draft'){
				$message_id = $data_arr_message['id'];
			}
			$where_arra = array('is_deleted'=>'No',"status !='Suspended' and status!='Inactive' and matri_id = '".$receiver_id."' and gender!='".$gender."' ");
			$rec_count = $this->common_front_model->get_count_data_manual('register',$where_arra,0,'matri_id');
			if($rec_count == 0){
				$receiver_id = '';
			}
		}
	}
}
?>
<div id="compose-new-msg" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor" id="sc_div_message">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Compose <span class="mega-n4 f-s">Message</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
            	<div id="response_update"></div>
                <form id="mes_content_form" method="post" action="<?php echo $base_url.'message/send_message'; ?>">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">To:</p>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select data-placeholder="Choose Receiver Matri ID" class="select2 form-control new-chosen-height" multiple name="to_message[]" data-validetta="required" id="to_message">
                            <?php if(isset($receiver_id) && $receiver_id !=''){?>
                                <option selected value="<?php echo $receiver_id; ?>"><?php echo $receiver_id; ?></option>
                            <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Message:</p>
                        </div>
                        <div class="col-md-9 col-sm-9 col-xs-12 new-msg-text-area ne-editor">
                            <div id="txtEditor" style="border: 1px solid #e3e3e3;"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <textarea style="display:none" id="msg_content" name="msg_content"><?php if(isset($message) && $message !='') { echo $message; }?></textarea>
                                <input type="hidden" id="msg_staus" name="msg_status" value="">
                                <input type="hidden" id="msg_id" name="msg_id" value="<?php if(isset($message_id) && $message_id !='') { echo $message_id; }?>"><?php if((isset($mode) && $mode == 'draft') && $message_id !=''){?>
                                    <button onClick="return save_draft_send_message('draft')" data-toggle="modal" data-target="#myModal_delete" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">
                                        Delete
                                    </button>
                                <?php }?>
                                <button onClick="return save_draft_send_message('draft')" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">
                                    Save as Draft
                                </button>
                                <button onClick="return save_draft_send_message('sent')" class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18">
                                    Send
                                </button>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>