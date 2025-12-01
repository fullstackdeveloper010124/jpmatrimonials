<?php
## Set Sender and Receiver Member Id : 
$sender_member_id = $this->common_front_model->get_session_data('id');
$sender_member_matri_id = $this->common_front_model->get_session_data('matri_id');
if($sender_member_id == $conversation_data['member1_id']){
    $receiver_member_id = $conversation_data['member2_id'];
    $receiver_member_matri_id = $conversation_data['member2_matri_id'];
}
if($sender_member_id == $conversation_data['member2_id']){
    $receiver_member_id = $conversation_data['member1_id'];
    $receiver_member_matri_id = $conversation_data['member1_matri_id'];
}
## Sender Data : 
$sender_member_data = $this->common_model->get_count_data_manual('register',array('id' => $sender_member_id),1,'id,gender,photo1,photo1_approve,status','','','');    
if($sender_member_data['photo1'] != '' && $sender_member_data['photo1_approve'] == 'APPROVED'){
    $sender_member_photo_url = base_url().$this->common_model->path_photos.$sender_member_data['photo1'];
}elseif(isset($sender_member_data['gender']) && $sender_member_data['gender']=='Female'){
    $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/female.png';
}elseif(isset($sender_member_data['gender']) && $sender_member_data['gender']=='Male'){
    $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/male.png';
}

## Receiver Data : 
$receiver_member_data = $this->common_model->get_count_data_manual('register',array('id' => $receiver_member_id),1,'id,gender,photo1,photo1_approve,photo_view_status','','','');
if(isset($receiver_member_data['gender']) && $receiver_member_data['gender']=='Female'){
    $receiver_photopassword_image = base_url().'assets/images/photopassword_female.png';
}elseif(isset($receiver_member_data['gender']) && $receiver_member_data['gender']=='Male'){
    $receiver_photopassword_image = base_url().'assets/images/photopassword_male.png';
}
$receiver_member_photo_url = $this->common_model->member_photo_disp($receiver_member_data);
if($receiver_member_data['photo_view_status'] == 0){
    $receiver_member_photo_url = $receiver_photopassword_image;
}

## Get Message List : Date : 17-11-2021
$conversationId = $conversation_data['id'];
$whereConversationArr[] = "conversation_id = $conversationId AND blocked_member_id != $sender_member_id ";
$get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,$whereConversationArr,'*','1','20','id DESC');
if($get_conversation_message_list =='' || empty($get_conversation_message_list)){
    $get_conversation_message_list = array();
}
$get_conversation_message_list = array_reverse($get_conversation_message_list);
## Get Message Count : 
$get_conversation_message_count = $this->custom_chat_model->get_conversation_message(0,$whereConversationArr,'id');
?>
<div class="chatbox hidden-xs hidden-sm" id="conversation-chatbox-<?php echo $conversation_data['id'] ?>">
    <div class="chatbox-top">
        <div class="chatbox-icons removeChatBox" data-id="<?php echo $conversation_data['id'] ?>">
            <a href="javascript:void(0);"><i class="fa fa-times" aria-hidden="true"></i></a>
        </div>
        <a class="chat-group-name" href="<?php echo base_url('search/view-profile/'.$receiver_member_matri_id) ?>" target="_blank">
            <?php echo $receiver_member_matri_id; ?>
        </a>
        <div class="chatbox-icons dropdown">
            <button for="chkSettings123" style="background: none; border: 0;" class="dropdown-toggle" id="dropdownMenuButton<?php echo $conversation_data['id'] ?>" data-toggle="dropdown" aria-haspopup="true"><i class="fa fa-cog" aria-hidden="true"></i></button>
            <div class="dropdown-menu settings-popup" aria-labelledby="dropdownMenuButton<?php echo $conversation_data['id'] ?>">
                <ul>
                    <li class="dropdown-item"><a href="<?php echo base_url('search/view-profile/'.$receiver_member_matri_id) ?>" target="_blank">View Profile</a></li>
                    <?php
                        ## For Block Chat Member : 
                        $block_action = 1;
                        $is_block = 0;
                        $checkblockColumnBlock = 'member1_block';
                        if($sender_member_id == $conversation_data['member2_id']){
                            $checkblockColumnBlock = 'member2_block';
                        }
                        if($conversation_data[$checkblockColumnBlock] == 1){
                            $block_action = 0;
                            $is_block = 1;
                        }
                    ?>
                    <input type="hidden" id="chat-member-block<?php echo $conversation_data['id']; ?>" value="<?php echo $is_block; ?>">
                    <li class="dropdown-item"><a href="javascript:void(0)" class="blockChatMember" data-conversation_id="<?php echo $conversation_data['id']; ?>" data-action="<?php echo $block_action; ?>"><?php echo ($is_block == 1) ? "Unblock" : "Block"; ?></a></li>
                </ul>
            </div>
            <a href="javascript:void(0);"><i class="fa fa-minus" aria-hidden="true"></i></a>
        </div>
    </div>
    
    <div class="chat-messages" data-conversation_id="<?php echo $conversation_data['id'] ?>" data-page="2" data-is-more="<?php echo ($get_conversation_message_count > 20) ? "1" : "0" ?>">
        <?php
            foreach ($get_conversation_message_list as $messageKey => $messageVal) {
                if($messageVal['sender_member_id'] == $sender_member_id){ // Sender ?>
                    <div class="message-box-holder sender">
                        <div class="message-box">
                            <?php echo $messageVal['message']; ?>
                        </div>
                        <img class="chat-m-pic" src="<?php echo $sender_member_photo_url; ?>" alt="">
                    </div>
                <?php }else{ // Receiver ?>
                    <div class="message-box-holder receiver">
                        <div class="message-sender">
                            <a target="_blank" href="<?php echo base_url('search/view-profile/'.$receiver_member_matri_id) ?>"><img src="<?php echo $receiver_member_photo_url; ?>" alt=""></a>
                        </div>
                        <div class="message-box message-partner">
                            <?php echo $messageVal['message']; ?>
                        </div>
                    </div>
            <?php }
            }
        ?>
    </div>
    <div class="chat-input-holder">
        <form class="send-message-form" id="sendMessageFrom<?php echo $conversation_data['id'] ?>" name="sendMessageFrom<?php echo $conversation_data['id'] ?>" method="post" action="<?php echo base_url('custom_chat/send_message') ?>">
            <input type="hidden" id="conversation_id<?php echo $conversation_data['id']; ?>" name="conversation_id" value="<?php echo $conversation_data['id']; ?>">
            <input type="hidden" id="sender_member_id<?php echo $conversation_data['id']; ?>" name="sender_member_id" value="<?php echo $sender_member_id; ?>">
            <input type="hidden" id="sender_member_matri_id<?php echo $conversation_data['id']; ?>" name="sender_member_matri_id" value="<?php echo $sender_member_matri_id; ?>">
            <input type="hidden" id="receiver_member_id<?php echo $conversation_data['id']; ?>" name="receiver_member_id" value="<?php echo $receiver_member_id; ?>">
            <input type="hidden" id="receiver_member_matri_id<?php echo $conversation_data['id']; ?>" name="receiver_member_matri_id" value="<?php echo $receiver_member_matri_id; ?>">
            <input type="hidden" id="sender_member_photo_url<?php echo $conversation_data['id']; ?>" name="sender_member_photo_url" value="<?php echo $sender_member_photo_url; ?>">
            <textarea class="chat-input" placeholder="Write a new message" id="conversation-message<?php echo $conversation_data['id']; ?>" name="message"></textarea>
            <button class="message-send" type="button" data-conversation_id="<?php echo $conversation_data['id']; ?>"> <i class="fal fa-long-arrow-right" aria-hidden="true"></i></button>
        </form>
    </div>
</div>
<script>
    // On scroll chat get more message : Date : 18-11-2021
    $('#conversation_chat_box').find('.chat-messages').on('scroll',function(){
        if($(this).scrollTop() == $(this).height() - $(this).height()) {
            if($(this).attr('data-is-more') == 1){
                var formData = new FormData();
                formData.append('conversation_id',$(this).attr('data-conversation_id'));
                formData.append('page',$(this).attr('data-page'));
                formData.append('csrf_new_matrimonial',$("#hash_tocken_id").val());
                var url = get_conversation_message;
                ajaxRequest($(this),formData,url,'getMoreMessageResponse');
            }
        }
    });
</script>