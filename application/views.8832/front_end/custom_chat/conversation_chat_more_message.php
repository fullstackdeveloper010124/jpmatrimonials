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
$sender_member_data = $this->common_model->get_count_data_manual('register',array('id' => $sender_member_id),1,'id,gender,photo1','','','');
if(isset($sender_member_data['gender']) && $sender_member_data['gender']=='Female'){
    $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/female.png';
}elseif(isset($sender_member_data['gender']) && $sender_member_data['gender']=='Male'){
    $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/male.png';
}
if($sender_member_data['photo1'] != ''){
    $sender_member_photo_url = base_url().$this->common_model->path_photos.$sender_member_data['photo1'];
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

    ## Get More Conversation Message :
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