<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_chat extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
        $this->viewDir = 'front_end/custom_chat/';
        $this->load->model('front_end/custom_chat_model');
        $this->load->model('front_end/matches_model');
	}

    ## Get Online Members : Date : 15-11-2021
    public function get_online_users(){
        $responseArr['status'] = 'error';
        $responseArr['msg'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['html'] = '';
        $responseArr['matchHtml'] = '';
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
			$is_login = $this->common_front_model->checkLogin('return');
            $member_id = $this->common_front_model->get_session_data('id');
            if($is_login){
                ## Get Online Member List : 
                $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
                if(!empty($current_member_data)){
                    $responseArr['data']['online_member_count'] = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id !=' => $current_member_data['id'],'gender !=' => $current_member_data['gender'],"created_at BETWEEN '".date('Y-m-d')." 00:00:00' and  '".date('Y-m-d')." 23:59:59'"),0,'id','created_at DESC','','',0);
                    if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
                        $this->db->like('matri_id',$postData['searchKeyword']);
                        $this->db->or_like('username',$postData['searchKeyword']);
                    }
                    $this->data['online_member_list'] = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id !=' => $current_member_data['id'],'gender !=' => $current_member_data['gender'],"created_at BETWEEN '".date('Y-m-d')." 00:00:00' and  '".date('Y-m-d')." 23:59:59'"),2,'*','created_at DESC','','',0);
                    // print_r($this->db->last_query());
                    // exit;
                    ## Get Recent Chat : Date : 01-07-2022
                    $onlineMemberId = array();
                    if(!empty($this->data['online_member_list'])){
                        foreach($this->data['online_member_list'] as $value){
                            $onlineMemberId[] = $value['member_id'];
                        }
                    }
                    $onlineMemberId = $this->common_model->trim_strin_remove($onlineMemberId);
                    if($onlineMemberId == ''){
                        $onlineMemberId = "''";
                    }
                    $likeRecent = "";
                    $whereRecent = "(
                                        member1_id = '$member_id' AND member2_id NOT IN($onlineMemberId)
                                    ) OR(
                                        member2_id = '$member_id' AND member1_id NOT IN($onlineMemberId)
                                    ) ";

                    $whereRecent .=  "AND created_at BETWEEN '".date('Y-m-d')." 00:00:00' and  '".date('Y-m-d')." 23:59:59'";
                    if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
                        $searchKeyword = $postData['searchKeyword'];
                        $likeRecent = " AND (register.matri_id LIKE '%$searchKeyword%' OR register.username LIKE '%$searchKeyword%')";
                        $whereRecent = "($whereRecent) $likeRecent ";
                    }
                    $sql="SELECT register.id,
                                CASE WHEN  member1_id = $member_id THEN member2_id WHEN member2_id = $member_id THEN member1_id END AS member_id,register.matri_id,register.username,register.gender,register.registered_on as created_at
                            FROM
                                custom_chat_conversation
                                
                                INNER JOIN register ON  (CASE WHEN  member1_id = $member_id THEN member2_id WHEN  member2_id = $member_id THEN member1_id END = register.id)
                                
                            WHERE
                            $whereRecent GROUP BY register.id,member_id,register.matri_id,register.username,register.gender,created_at";
                    
                    $query=$this->db->query($sql);
                    $this->data['recent_member_list'] = $query->result_array();
                    if(empty($this->data['online_member_list'])){
                        $this->data['online_member_list'] = array();
                    }
                    if(!empty($this->data['recent_member_list'])){
                        foreach ($this->data['recent_member_list'] as $value) {
                            $value['is_online'] = 'No';
                            $this->data['online_member_list'][] = array();
                        }
                    }
                    ## Get Match : 
	                // $this->data['match_member_list'] = $this->custom_chat_model->get_match_member();
                    $responseArr['status'] = 'success';
                    $responseArr['msg'] = 'Online member list get successfully.';
                    $responseArr['html'] = $this->load->view($this->viewDir.'online_users_ajax',$this->data,true);
                    // $responseArr['matchHtml'] = $this->load->view($this->viewDir.'match_users_ajax',$this->data,true);
                }else{
                    $responseArr['msg'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }

    ## Create Coversation : Date : 16-11-2021
    public function create_conversation(){
        $responseArr['status'] = 'error';
        $responseArr['msg'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['html'] = '';
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
			$is_login = $this->common_front_model->checkLogin('return');
            $member_id = $this->common_front_model->get_session_data('id');
            if($is_login){
                ## Get Online Member List : 
                $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
                if(!empty($current_member_data)){
                    ## Get Conversation Id : 
                    $member1Id = $postData['member1_id'];
                    $member2Id = $postData['member2_id'];
                    // $whereConversationArr[] = " ((member1_id = $member1Id AND member2_id = $member2Id) OR (member1_id = $member2Id AND member2_id = $member1Id)) OR (blocked_member_id != $member1Id)";
                    $whereConversationArr[] = " ((member1_id = $member1Id AND member2_id = $member2Id) OR (member1_id = $member2Id AND member2_id = $member1Id))";
                    // print_r($whereConversationArr);exit;
                    $conversationData = $this->common_model->get_count_data_manual('custom_chat_conversation',$whereConversationArr,1,'id,','','','');
                    // echo $this->db->last_query();exit;
                    ## Create Conversation If not Create : 
                    if(empty($conversationData)){
                        ## Insert : 
                        $insert_arr['member1_id'] = $postData['member1_id'];
                        $insert_arr['member1_matri_id'] = $postData['member1_matri_id'];
                        $insert_arr['member2_id'] = $postData['member2_id'];
                        $insert_arr['member2_matri_id'] = $postData['member2_matri_id'];
                        $insert_arr['created_at'] = date('Y-m-d H:i:s');
                        $this->db->insert('custom_chat_conversation',$insert_arr);
                        $conversation_id = $this->db->insert_id();
                    }else{
                        ## Update Read Status : 
                        $this->db->where('conversation_id',$conversationData['id']);
                        $this->db->where('receiver_member_id',$member_id);
                        $this->db->update('custom_chat_conversation_message',array('is_read' => 'Yes'));
                        $conversation_id = $conversationData['id'];
                    }
                    if($conversation_id != ''){
                        $this->data['conversation_data'] = $this->custom_chat_model->get_conversation(1,array('id' => $conversation_id));
                        $responseArr['status'] = 'success';
                        $responseArr['msg'] = 'Chat created successfully.';
                        $responseArr['data'] = $this->data['conversation_data'];
                        $responseArr['html'] = $this->load->view($this->viewDir.'conversation_chat_box',$this->data,true);
                    }else{
                        $responseArr['msg'] = 'Chat not created. Please try again!';
                    }
                }else{
                    $responseArr['msg'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }

    ## Send Message : Date : 16-11-2021
    public function send_message(){
        $responseArr['status'] = 'error';
        $responseArr['msg'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['html'] = '';
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
			$is_login = $this->common_front_model->checkLogin('return');
            $member_id = $this->common_front_model->get_session_data('id');
            if($is_login){
                ## Get Online Member List : 
                $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
                if(!empty($current_member_data)){
                    ## Check Member Block Us : 
                    $check_block_us = $this->common_model->get_count_data_manual('block_profile',array('block_by' => $postData['receiver_member_matri_id'],'block_to' => $postData['sender_member_matri_id']),0,'id','','','');
                    if($check_block_us == 0){
                        ## Create Conversation If not Create : 
                        if(isset($postData['conversation_id']) && $postData['conversation_id'] != ''){
                            ## If Other User Block Us Then Add Id : 
                            $conversationData = $this->custom_chat_model->get_conversation(1,array('id' => $postData['conversation_id']));
                            $member2Id = $conversationData['member2_id'];
                            $checkblockColumnBlock = 'member2_block';
                            $blockMemberIdColumn = 'member2_id';
                            if($member_id == $member2Id){
                                $checkblockColumnBlock = 'member1_block';
                                $blockMemberIdColumn = 'member1_id';
                            }
                            ## Check If Block  : 
                            $blocked_member_id = 0;
                            if($conversationData[$checkblockColumnBlock] == 1){
                                $blocked_member_id = $conversationData[$blockMemberIdColumn];
                            }
                            ## Insert Message : 
                            $sender_member_photo_url = $postData['sender_member_photo_url'];
                            $message = $postData['message'];
                            unset($postData['isPost']);
                            unset($postData['sender_member_photo_url']);
                            $insert_arr = $postData;
                            $insert_arr['is_read'] = 'No';
                            $insert_arr['send_on'] = date('Y-m-d H:i:s');
                            $insert_arr['blocked_member_id'] = $blocked_member_id;
                            $this->db->insert('custom_chat_conversation_message',$insert_arr);

                            ## Send Notification : 
                            if($blocked_member_id == 0){
                                $receiver_member_data = $this->common_model->get_count_data_manual('register',array('id' => $postData['receiver_member_id']),1,'id,web_device_id,android_device_id,ios_device_id','','','');
                                if(isset($receiver_member_data['web_device_id']) && $receiver_member_data['web_device_id'] != ''){
                                    $data_array = array(
                                        'device_id'=>$receiver_member_data['web_device_id'],
                                        'sender_id' => $member_id,
                                        'receiver_id' => $postData['receiver_member_id'],
                                        'notification_type' => 'custom_chat_message_received',
                                        'title' => 'Received New message from ('.$postData['sender_member_matri_id'].')',
                                        'message' => $postData['message'],
                                        'sender_member_photo_url' => $sender_member_photo_url,
                                        'click_action'=>base_url().'search/view-profile/'.$postData['sender_member_matri_id'],
                                    );
                                    $this->custom_chat_model->new_send_notification_web($data_array);
                                }
                                unset($receiver_member_data['web_device_id']);
                                foreach ($receiver_member_data as $key => $value) {
                                    if(isset($value) && $value!='' && isset($key) && $key!='')
                                    {
                                        $title = 'Received New message from ('.$postData['sender_member_matri_id'].')';
                                        $message = $postData['message'];
                                        $this->common_model->new_send_notification_android($value,$message,$title,'custom_chat_message_received',$member_id,'',array('chat_message' => $postData['message'],'chat_date' => $insert_arr['sent_on'],'conversation_id' => $postData['conversation_id']));
                                    }
                                }
                            }
                            $responseArr['status'] = 'success';
                            $responseArr['msg'] = 'Message Sent.';
                            $responseArr['data'] = $postData;
                            $responseArr['html'] = "<div class='message-box-holder'>
                                                        <div class='message-box'>
                                                            $message
                                                        </div>
                                                        <img class='chat-m-pic' src='$sender_member_photo_url' alt=''>
                                                    </div>";
                        }
                    }else{
                        $responseArr['msg'] = 'This member is blocked you.';
                    }
                }else{
                    $responseArr['msg'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }

    ## Get More Conversation Message : Date : 18-11-2021
    public function getConversationMessage(){
        $responseArr['status'] = 'error';
        $responseArr['msg'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['html'] = '';
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
			$is_login = $this->common_front_model->checkLogin('return');
            $member_id = $this->common_front_model->get_session_data('id');
            if($is_login){
                ## Get Online Member List : 
                $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
                if(!empty($current_member_data)){
                    ## Create Conversation If not Create : 
                    if(isset($postData['conversation_id']) && $postData['conversation_id'] != ''){
                        $this->data['conversation_data'] = $this->custom_chat_model->get_conversation(1,array('id' => $postData['conversation_id']));
                        $conversationId = $postData['conversation_id'];
                        $whereConversationArr[] = "conversation_id = $conversationId AND blocked_member_id != $member_id ";
                        // $get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,array('conversation_id' => $postData['conversation_id']),'*',$postData['page'],'20','id DESC');
                        $get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,$whereConversationArr,'*',$postData['page'],'20','id DESC');
                        if($get_conversation_message_list =='' || empty($get_conversation_message_list)){
                            $get_conversation_message_list = array();
                        }
                        if(!empty($get_conversation_message_list)){
                            $get_conversation_message_list = array_reverse($get_conversation_message_list);
                            $this->data['postData'] = $postData;
                            $this->data['get_conversation_message_list'] = $get_conversation_message_list;
                            $responseArr['status'] = 'success';
                            $responseArr['msg'] = 'Get Messages successfully.';
                            $responseArr['html'] = $this->load->view($this->viewDir.'conversation_chat_more_message',$this->data,true);
                        }else{
                            $responseArr['status'] = 'no_message';
                            $responseArr['msg'] = 'No more message.';
                        }
                    }
                }else{
                    $responseArr['msg'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }

    ## Block Member Chat : Date : 30-06-2022
    public function blockChatMember(){
        $responseArr['status'] = 'error';
        $responseArr['msg'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['html'] = '';
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
			$is_login = $this->common_front_model->checkLogin('return');
            $member_id = $this->common_front_model->get_session_data('id');
            if($is_login){
                ## Get Online Member List : 
                $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
                if(!empty($current_member_data)){
                    ## Create Conversation If not Create : 
                    if(isset($postData['conversation_id']) && $postData['conversation_id'] != ''){
                        $conversationData = $this->custom_chat_model->get_conversation(1,array('id' => $postData['conversation_id']));
                        if(!empty($conversationData)){
                            $member2Id = $conversationData['member2_id'];
                            $updateBlockArr = array('member1_block' => $postData['action']);
                            if($member_id == $member2Id){
                                $updateBlockArr = array('member2_block' => $postData['action']);
                            }
                            
                            ## Update Block Status to conversation : 
                            $this->db->where('id',$conversationData['id']);
                            $this->db->update('custom_chat_conversation',$updateBlockArr);
                            
                            $responseArr['status'] = 'success';
                            $responseArr['msg'] = 'Blocked member.'; 
                            $responseArr['data'] = $postData;
                            if($postData['action'] == 0){
                                $responseArr['msg'] = 'Unblocked member.'; 
                            }
                        }else{
                            $responseArr['msg'] = 'Please refresh page and try again!';        
                        }
                    }
                }else{
                    $responseArr['msg'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }
    public function manageTopicSubscription($type){
        $dataPost = json_decode(file_get_contents('php://input'), true);
        $deviceTokens = $dataPost['token'];
        $topic = $dataPost['topic'];
        if($type == "add"){
            $url = "https://iid.googleapis.com/iid/v1:batchAdd";
        }else{
            $url = "https://iid.googleapis.com/iid/v1:batchRemove";
        }
        $config_data = $this->common_model->get_site_config();
        $accessToken = $this->common_model->getAccessToken($config_data);
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
            'access_token_auth: true'
        ];
    
        $data = [
            'to' => "/topics/".$topic,
            'registration_tokens' => [$deviceTokens]
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
        // return $result;
    }
}