<?php
    $postData = $this->input->post();
    $current_member_id =  $this->common_front_model->get_session_data('id');
    $current_member_matri_id =  $this->common_front_model->get_session_data('matri_id');
    $plan_status =  $this->common_front_model->get_session_data('plan_status');

    $get_current_plan_chat = array();
    $alert_message = "Please upgrade your membership plan to chat.";
    if($plan_status == 'Paid'){
        $get_current_plan_chat = $this->common_model->get_count_data_manual('payments',array('matri_id' => $current_member_matri_id,'current_plan' => 'Yes','chat' => 'Yes'),1,'id,chat','','','');
        if($get_current_plan_chat !='' && !empty($get_current_plan_chat)){
            $alert_message = '';
        }
    }
    
    if(!empty($online_member_list)){
        foreach ($online_member_list as $key => $value) {
            $member_data = $this->common_model->get_count_data_manual('register',array('id' => $value['member_id']),1,'id,gender,photo1,photo1_approve,photo_view_status','','','');
            if(!empty($member_data) && $member_data != ''){
                if(isset($member_data['gender']) && $member_data['gender']=='Female'){
                    $photopassword_image = base_url().'assets/images/photopassword_female.png';
                }elseif(isset($member_data['gender']) && $member_data['gender']=='Male'){
                    $photopassword_image = base_url().'assets/images/photopassword_male.png';
                }
                $member_photo_url = $this->common_model->member_photo_disp($member_data);
                if($member_data['photo_view_status'] == 0){
                    $member_photo_url = $photopassword_image;
                }
                ## Get Conversation : 
                $member_id = $value['member_id'];
                $matri_id = $value['matri_id'];
                $where_check_conversation = array();
                $where_check_conversation[] = " (member1_id = $current_member_id AND member1_matri_id = '$current_member_matri_id' AND member2_id = $member_id AND member2_matri_id = '$matri_id') OR ( member1_id = $member_id AND member1_matri_id = '$matri_id' AND member2_id = $current_member_id AND member2_matri_id = '$current_member_matri_id' )";
                $is_exist_conversation = $this->custom_chat_model->get_conversation(1,$where_check_conversation,'id');
                $conversation_id = '';
                if($is_exist_conversation !='' && !empty($is_exist_conversation)){
                    $conversation_id = $is_exist_conversation['id'];
                }

                ## Get Conversation Message Data :
                $unread_message_count = 0;
                $unread_message_class = '';
                $last_message_display = '';
                $last_message_date = '';
                if($conversation_id != ''){
                    $last_message_data = $this->custom_chat_model->get_conversation_message(1,array('conversation_id' => $conversation_id),'*','1','1');
                    if($last_message_data != '' && !empty($last_message_data)){
                        $last_message_display = $last_message_data['message'];
                        $last_message_date = date('jS M',strtotime($last_message_data['send_on']));
                        ## Get Unread Message Count : 
                        $unread_message_count = $this->custom_chat_model->get_conversation_message(0,array('conversation_id' => $conversation_id,'receiver_member_id' => $current_member_id,'is_read' => 'No'),'id');;
                        if($unread_message_count > 0){
                            $unread_message_class = 'unread-msg-show';
                        }
                    }
                }

                ## Check Member Block Us : 
                $check_block_us = $this->common_model->get_count_data_manual('block_profile',array('block_by' => $matri_id,'block_to' => $current_member_matri_id),0,'id','','','');
                if($check_block_us > 0){
                    $alert_message = 'This member is blocked you.';
                }
                ## If Any Alert Message : 
                $alert_message_text = '';
                if($alert_message != ""){
                    $alert_message_text = 'onclick="return alert('."'".$alert_message."'".');"';
                }
                ?>
                <div <?php echo $alert_message_text; ?> class="sidebar-name createConversation pointer" id="online-user-list-<?php echo $value['member_id']; ?>" data-conversation_id="<?php echo $conversation_id; ?>" data-current_member_id="<?php echo $current_member_id; ?>" data-current_member_matri_id="<?php echo $current_member_matri_id; ?>" data-member_id="<?php echo $value['member_id'] ?>" data-matri_id="<?php echo $value['matri_id'] ?>" data-is_chat="<?php echo ($alert_message_text !="") ? 'No' : 'Yes' ?>">
                    <!-- Pass username and display name to register popup -->
                    <a href="javascript:void(0)">
                        <img src="<?php echo $member_photo_url; ?>" alt="<?php echo $value['matri_id'] ?>">
                        <?php
                            if(isset($value['is_online']) && $value['is_online'] == 'No'){
                                echo '<div class="d-active-c"></div>';
                            }else{
                                echo '<div class="active-c"></div>';      
                            }
                        ?>
                    </a>
                    <div class="user-name-chat">
                        <h4><?php echo $value['matri_id'] ?></h4>
                        <p class="last-message-tag <?php echo $unread_message_class; ?>" title="<?php echo $last_message_display; ?>">
                            <?php
                                ## Last Message : 
                                if($last_message_display != ''){
                                    if(strlen($last_message_display) > 30){
                                        echo substr($last_message_display, 0, 30).'..';
                                    }else{
                                        echo $last_message_display;
                                    }
                                }else{
                                    echo "Click to chat with ".$matri_id;
                                }
                            ?>
                        </p>
                    </div>
                    <?php
                        if($unread_message_count > 0){ ?>
                        <div class="new-msg">
                            <?php echo $unread_message_count; ?>
                        </div>
                    <?php } ?>
                    <div class="time-chat">
                        <p><?php echo ($last_message_date != '') ? $last_message_date : '-'; ?></p>
                    </div>
                </div>
        <?php } ?>
    <?php }
    }else{
        if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != '' ){
            $searchKeyword = $postData['searchKeyword'];
            echo "No Any users online for $searchKeyword .";
        }else{
            echo "No Any users online.";
        }
    }
?>
    