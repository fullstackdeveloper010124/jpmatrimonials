<?php $subject = '';
	$message = '';
	$message_id = '';
	$receiver_id ='';
	$sent_on = '';
	if(!isset($mode)){
		$mode = 'inbox';
	}
	if(isset($msg_id) && $msg_id !=''){
		$msg_id = $this->common_model->descrypt_id($msg_id);
		$matri_id = $this->common_front_model->get_user_id('matri_id');
		
		if(isset($mode) && $mode =='sent'){
			$where_arra = array('id'=>$msg_id,'sender'=>$matri_id,'sender_delete'=>'No','trash_sender'=>'No');
			$where_arra[] = " status != 'draft' ";
		}
		else if(isset($mode) && $mode =='trash'){
			$where_arra[] = " id = '$msg_id' and (( sender = '$matri_id' and trash_sender != 'No' and sender_delete = 'No') or ( receiver = '$matri_id' and trash_receiver != 'No' and receiver_delete = 'No' ))  ";
		}
		else{
			$where_arra = array('id'=>$msg_id,'receiver'=>$matri_id,'status'=>'sent','receiver_delete'=>'No','trash_receiver'=>'No');
		}
		$data_arr_message = $this->common_front_model->get_count_data_manual('message',$where_arra,1);
		
		if(isset($data_arr_message) && $data_arr_message !='' && is_array($data_arr_message) && count($data_arr_message) > 0){
			$gender = $this->common_front_model->get_user_id('gender');
			$subject = $data_arr_message['subject'];
			$message = $data_arr_message['content'];
			$message_id = $data_arr_message['id'];
			$sent_on = $data_arr_message['sent_on'];
			
			if($data_arr_message['receiver'] != $matri_id){
				$receiver_id =$data_arr_message['receiver'];
			}else{
				$receiver_id = $data_arr_message['sender'];
			}
			if($mode == 'inbox' && $data_arr_message['read_status'] =='No'){
				$this->common_model->update_insert_data_common('message',array('read_status'=>'Yes'),array('id'=>$message_id));
			}
		}
	}
	if($message_id =='')
	{?>
	<script type="text/javascript">window.location ='<?php echo $base_url.'message/index' ?>'</script>
<?php }?>

<div class="container-fluid new-width width-95 mt-40-pro mt-4">
        <div class="row-cstm">
            <input type="hidden" value="compose_message" id="page_type" />
			<input type="hidden" value="<?php echo $mode; ?>" id="mode" />
            <?php 
				$message_type = $mode;
				include_once('message_sidebar.php');
			?>    
            <div class="col-md-9 col-sm-12 col-xs-12 padding-zero">
                <div id="response_update_status"></div>
                <div class="dshbrd_side_section">
                    <div class="dshbrd_overlay">
                        <div class="dshbrd_color_overlay new-saved-search">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <span class="saved-search-i Poppins-Medium"> <i class="fas fa-plus"></i>  View Message
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="design-process-content das-content-2" style="padding: 0px 12px;">
                            <div class="mail-option msg-option">
	                            <span class="pull-left"><a href="<?php echo $base_url.'message/inbox/'.$mode;?>" class="mega-n-btn1 back-msg-btn post-s-d Poppins-Regular color-f f-16" title="No">Back</a></span>
                                <span class="pull-right">
									<?php
                                    if($mode =='inbox'){
                                        $imp_star = 'star-icon';
                                        if(isset($data_arr_message['important_status']) && $data_arr_message['important_status'] == 'No'){
                                            $imp_star = 'unstar-icon';
                                        }
                                    ?>
                                    <div class="btn-group">
                                        <a title="Imported" data-toggle="tooltip" href="javascript:void(0);" onclick="importantfun('<?php echo $message_id;?>');" class="btn mini all">
                                            <i id="msg_imp_<?php echo $message_id;?>" class="fa fa-star <?php echo $imp_star;?> ne_inbox_msg_imp_active"></i>
                                        </a>
                                    </div>
                                    <?php
                                    }
                                    $enc_msg_id = $this->common_model->encrypt_id($message_id);
                                    ?>
                                    <div class="btn-group">
                                        <a data-original-title="Refresh" data-toggle="modal" data-target="#myModal_delete" title="Trash" onClick="delete_message()" class="btn mini tooltips">
                                            <i class="fas fa-trash-alt delete-color"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a onclick="compose('<?php echo $enc_msg_id;?>','reply')" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply" class="btn mini tooltips">
                                            <i class="fa fa-reply"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group">
                                        <a onclick="compose('<?php echo $enc_msg_id;?>','forward')" href="javascript:void(0);"  data-toggle="tooltip" data-placement="top" title="Forward" class="btn mini tooltips">
                                            <i class="fa fa-share"></i>
                                        </a>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="design-process-content das-content-2 margin-bottom-15">
                            <div class="mail-option">
                                <p class="p-search like-margin-b">
                                    <?php if(isset($data_arr_message['receiver']) && $data_arr_message['receiver'] == $matri_id){
										echo '<i class="fas fa-user"></i>  From: ';
                                    }else{
                                        echo '<i class="fas fa-user"></i> To: ';
                                    }
                                    echo $this->common_model->display_data_na(ucfirst($receiver_id));
                                ?> 
                                    <span class="pull-right  Poppins-Regular f-14 like-color"><?php echo $this->common_model->displayDate($sent_on); ?>
                            		</span>
                				</p>
                                <hr class="like-hr">
                                </div>
                                <div style="padding:0px 15px;word-break: break-word;" class="f-15">
									<?php echo $this->common_model->display_data_na($message); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="myModal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-vendor">
            <div class="modal-content">
                <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                    <p class="Poppins-Bold mega-n3 new-event text-center">Delete <span class="mega-n4 f-s">Message</span></p>
                    <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
                </div>
                <div class="modal-body">
                    <div id="delete_photo_message"></div>
                    <div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                        </div>
                        <div class="col-md-10 col-sm-6 col-xs-12">
                            <strong>Are you sure want to <?php if($message_type=='trash'){ echo 'Delete ';}else{ echo 'Trash ';}?>Message?</strong><br />
                            <span class="small">This Records will be <?php if(isset($message_type) && $message_type=='trash'){echo 'Deleted Permanently';}else{ echo 'Trashed';}?> from your Entire Records.</span>
                            <input style="display:none" type="checkbox" name="checkbox_val[]" value="<?php echo $message_id;?>" checked />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <button onClick="update_msg_status('delete')" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php include('compose_msg.php');?>