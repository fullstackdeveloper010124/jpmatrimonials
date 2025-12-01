<?php if(isset($first_load) && $first_load !='' && $first_load == true){?>
<div id="main_id_display">
<?php }else{?>
<div>
<?php }
	
if(!isset($page_number) || $page_number  =='' ){
    $page_number = 1;
}
if($this->input->post('page_number') !=''){
    $page_number = $this->input->post('page_number');
}
	
$data_message = $this->message_model->get_message_list(1,$page_number,$message_type);
$total_count = $this->message_model->get_message_list(0,$page_number,$message_type);

$message_search = '';
if($this->input->post('message_search') !=''){
    $message_search = $this->input->post('message_search');
}

if(!isset($message_type) || $message_type =='' ){
    $message_type = 'inbox';
}
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !=''){
    $message_type = $_REQUEST['mode'];
}
$matri_id = $this->common_front_model->get_user_id('matri_id');
?>
    <div class="container-fluid new-width width-95 mt-40-pro">
        <div class="row-cstm">
            <input type="hidden" id="page_type" value="inbox_message" />
            <?php include_once('message_sidebar.php'); ?>     
            <div class="col-md-9 col-sm-12 col-xs-12 padding-zero">
                <div id="response_update_status">
                    <?php
                        $class_alt = 'alert';
                        if(isset($update_status['status']) && $update_status['status'] =='success'){
                            $class_alt = 'alert alert-success';
                        }
                        else if(isset($update_status['status']) && $update_status['status'] =='error'){
                            $class_alt = 'alert alert-danger';
                        }
                        if(isset($update_status['error_meessage']) && $update_status['error_meessage'] !=''){?>
                        <div class="<?php echo $class_alt; ?> alert-dismissible"><?php echo $update_status['error_meessage'];?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></div>
                    <?php }?>
                </div>
                <div class="dshbrd_side_section">
                    <div class="dshbrd_overlay">
                        <div class="dshbrd_color_overlay new-saved-search">
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <span class="saved-search-i Poppins-Medium"> <i class="fas fa-inbox"></i>  Inbox
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="design-process-content das-content-2 padding-0">
                            <div class="mail-option ">
                            <div class="col-md-5 col-xs-12 col-sm-5">
                                <div class="chk-all bg-transparent-box-showdow border-zero">
                                    <span class="checkbox-m">
                                        <input onClick="check_all()" type="checkbox" name="checkbox" id="all">
                                        <label for="all" class="lbl1"></label>
                                    </span>
                                    <?php if($message_type !='sent' && $message_type !='draft' && $message_type !='trash'){?>
                                        <div class="btn-group">
                                            <a data-toggle="dropdown" href="#" class="btn mini all" aria-expanded="false">
                                                <i class="fa fa-angle-down"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="javascript:void(0);" onClick="update_msg_status('read')"> Read</a></li>
                                                <li><a href="javascript:void(0);" onClick="update_msg_status('unread')"> Unread</a></li>
                                            </ul>
                                        </div>
                                    <?php }?>
                                </div>
                               
                                <div class="btn-group">
                                    <a data-original-title="Refresh" data-toggle="modal" data-target="#myModal_delete" title="Trash" onClick="delete_message()" class="btn mini tooltips">
                                        <i class="fas fa-trash-alt delete-color"></i>
                                    </a>
                                </div>
                                <?php if($message_type !='sent' && $message_type !='draft' && $message_type !='trash'){?>
                                    <div class="btn-group">
                                        <a onClick="update_msg_status('imported')" data-toggle="tooltip" data-placement="top" href="javascript:void(0);" class="btn mini tooltips" title="Important">
                                            <i class="fa fa-star star-icon"></i>
                                        </a>
                                    </div>
                                <?php }?>
                                <div class="btn-group">
                                    <a data-toggle="tooltip" data-placement="top" title="Refresh" onClick="message_system('<?php echo $message_type ?>',1)" class="btn mini tooltips">
                                        <i class=" fa fa-refresh ref-icon"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a onClick="replay_forward('reply')" data-toggle="tooltip" data-placement="top" title="" data-original-title="Reply" class="btn mini tooltips">
                                        <i class="fa fa-reply"></i>
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <a onClick="replay_forward('forward')" data-toggle="tooltip" data-placement="top" title="Forward" class="btn mini tooltips">
                                        <i class="fa fa-share"></i>
                                    </a>
                                </div>
                                </div>
                                <div class="col-md-4 col-xs-12 col-sm-4 hidden-xs hidden-sm pull-right">
									<?php
                                    $limit_per_page = $this->common_model->limit_per_page;
                                    $start = 1;
                                    if(isset($this->common_model->start) && $this->common_model->start !='')
                                    {
                                        $start = $this->common_model->start;
                                        $start++;
                                    }
                                    $total_disp = $start + $limit_per_page -1;
                                    if($total_count < $total_disp)
                                    {
                                        $total_disp = $total_count;
                                    }?>                                
									<?php if($total_count !='' && $total_count > $limit_per_page){
                                        echo $this->common_model->rander_pagination_front_message("message/inbox/$message_type",$total_count,$limit_per_page);
                                    }else{
										?><ul class="unstyled inbox-pagination"></ul><?php
									}?>
                                    <span class="pull-right" style="margin-top: 13px; position: relative;"><?php echo $start.' - '.$total_disp.' of '.$total_count;?></span>
                                </div>
                                <div class="col-md-3 col-xs-12 col-sm-3">
                                    <div class="inner-addon right-addon">
                                        <i class="fa fa-search"></i>
                                        <form action="" method="post" onSubmit="return message_system()">
                                            <input type="text" class="form-control" id="message_search" name="message_search" placeholder="Search" value="<?php if(isset($message_search) && $message_search !=''){ echo $message_search;}?>" />
                                        </form>
                                    </div>
                                </div>
                                <!-- ====== Mobile View Pagination ==== -->
                                <span class="hidden-lg hidden-md">
									<?php if($total_count !='' && $total_count > $limit_per_page){
										echo $this->common_model->rander_pagination_front_message("message/inbox/$message_type",$total_count,$limit_per_page);
									}else{
										?><ul class="unstyled inbox-pagination"></ul><?php
									}?>
									<span class="pull-right" style="margin-top: 7px; position: relative; left: 31px;"><?php echo $start.' - '.$total_disp.' of '.$total_count;?></span>
                                </span>
                                <!-- ====== Mobile View Pagination ==== -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="design-process-content das-content-2 padding-0">
                            <div class="mail-option">
                                <form method="post" id="msg_data_form">
									<?php if(isset($data_message) && $data_message !='' && is_array($data_message) && count($data_message) > 0){
                                    $matri_id_clm = 'sender';
                                    $col_sub = 4;
                                    if($message_type =='sent' || $message_type =='draft'){
                                        $matri_id_clm = 'receiver';
                                        $col_sub = 5;
                                    }
                                    $view_link = 'view_message';
                                    if($message_type == 'draft'){
                                        $view_link = 'compose';	
                                    }
                                    foreach($data_message as $data_message_val){
                                        $read_status_msg = '';
                                        if($message_type =='inbox' && $data_message_val['read_status'] =='No' ){
                                            $read_status_msg = 'text-bold';
                                        }
                                        $enc_msg_id = $this->common_model->encrypt_id($data_message_val['id']);
                                        
                                        if($message_type =='trash'){
                                            if(isset($matri_id) && $matri_id == $data_message_val['sender']){
                                                $matri_id_clm = 'receiver';
                                                $col_sub = 4;
                                            }elseif(isset($matri_id) && $matri_id == $data_message_val['receiver']){
                                                $matri_id_clm = 'sender';
                                                $col_sub = 4;
                                            }
                                        }?>
                                        <div class="bg-read">
                                            <div class="row">
                                                <div class="col-md-2 col-xs-4 col-sm-3">
                                                    <div class="chk-all bg-transparent-box-showdow border-zero">
                                                        <span class="checkbox-m">
                                                            <input type="checkbox" name="checkbox_val[]" id="checkbox-<?php echo $data_message_val['id']; ?>" value="<?php echo $data_message_val['id']; ?>" class="checkbox_val" onclick="check_uncheck(this.id)"/>
                                                            <label for="checkbox-<?php echo $data_message_val['id']; ?>" class="control-label"></label>
                                                            <input type="hidden" id="msg_enc_id_<?php echo $data_message_val['id']; ?>" value="<?php echo $enc_msg_id; ?>" />
                                                        </span>
                                                        <?php if($message_type !='sent' && $message_type !='draft' && $message_type !='trash'){
															$imp_star = 'star-icon';
															$important_status = $data_message_val['important_status'];
															if($important_status == 'No'){
																$imp_star = 'unstar-icon';
															}?>
                                                                <div class="btn-group">
                                                                    <a href="javascript:void(0);" onclick="importantfun('<?php echo $data_message_val['id']; ?>');" class="btn mini all">
                                                                        <i id="msg_imp_<?php echo $data_message_val['id'];?>" class="fa fa-star <?php echo $imp_star;?> ne_inbox_msg_imp_active"></i>
                                                                    </a>
                                                                </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col-xs-2 col-sm-2 mt-3 padding-0">
                                                	<span><?php echo ucfirst($this->common_model->display_data_na($data_message_val[$matri_id_clm])); ?></span>
                                                </div>
                                                <div class="col-md-5 col-xs-6 col-sm-6">
                                                    
													<?php $string = $this->common_model->display_data_na($data_message_val['content']);
													if($message_type == 'draft'){?>
														<p class="text-center message-t" style="cursor:pointer" onclick="compose('<?php echo $enc_msg_id;?>','draft')">
															<?php $string1 = strip_tags($string);
															echo substr($string1, 0, 50);
															if(strlen($string1)>50){echo '...';}?>
                                                        </p>
													<?php }else{?>
                                                        <p class="text-center message-t" style="cursor:pointer" onClick="window.location='<?php echo $base_url.'message/'.$view_link.'/'.$enc_msg_id.'/'.$message_type; ?>'">
                                                            <?php $string1 = strip_tags($string);
															echo substr($string1, 0, 50);
															if(strlen($string1)>50){echo '...';}?>
                                                        </p>
                                                    <?php }?>
                                                </div>
                                                <div class="col-md-4 col-xs-12 col-sm-4">
                                                    <ul class="unstyled inbox-pagination ">
                                                        <li style="cursor:pointer">
                                                            <a class="np-btn new-time">	<i class="fa fa-clock-o ne_mrg_ri8_5"></i><?php echo $this->common_model->displayDate($data_message_val['sent_on']); ?></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="message-hr">
                                    <?php }
                                    }else{?>
                                    	<div class="alert alert-danger">No Data available</div>
									<?php }?>
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
                    				<input type="hidden" name="mode" id="mode" value="<?php echo $message_type; ?>" />
                                </form>
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
                            <img src="<?php echo $base_url;?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                        </div>
                        <div class="col-md-10 col-sm-6 col-xs-12 delete_conf">
                            <strong>Are you sure want to <?php if($message_type=='Trash'){ echo 'Delete ';}else{ echo 'Trash ';}?>Message?</strong><br />
                            <span class="small">This Records will be <?php if(isset($message_type) && $message_type=='trash'){echo 'Deleted Permanently';}else{ echo 'Trashed';}?> from your Entire Records.</span>
                        </div>
                        <div class="col-md-10 col-sm-6 col-xs-12 delete_alt" style="display:none">
                            <strong>Please select at least one message to delete</strong>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <div class="delete_conf">
                                    <div id="draft_delete_id"></div>
                                    <button onClick="update_msg_status('delete')" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                                    <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                                </div>
                                <div class="delete_alt" style="display:none;">
                                    <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">Close</button>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('compose_msg.php');?>

<?php
	$this->common_model->js_extra_code_fr.="
	$(document).ready(function() {
		tooltip_fun();
	});
	//load_choosen_code();
	function check_uncheck(id){		
		var singlechecked= 'input[name=".'"'."'+$('#'+id).attr('name')+'".'"'."]';
		var checkall= 'input[name=".'"'."'+$('#all').attr('name')+'".'"'."]';
		
		var len = $('[name=".'"'."'+$('#'+id).attr('name')+'".'"'."]:checked').length;
		var single_len = $('[name=".'"'."'+$('#'+id).attr('name')+'".'"'."].checkbox_val').length;
		
		$(singlechecked).change(function(){
			if($(singlechecked).is(':checked')){
				var checked = $(checkall).is(':checked');	
					
				if(checked == true && len!=single_len){
					$(checkall).prop('checked',false);
				}
				if(checked == false && len==single_len){
					$(checkall).prop('checked',true);
				}
			}
			else if($(singlechecked).is(':checked') == false && len!=single_len){
				$(checkall).prop('checked',false);
			}
		});
	}";
?>