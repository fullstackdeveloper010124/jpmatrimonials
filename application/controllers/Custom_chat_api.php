<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_chat_api extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
        $this->viewDir = 'front_end/custom_chat/';
        $this->load->model('front_end/custom_chat_model');
        $this->load->model('front_end/matches_model');
	}

    ## Online / Offline Members : Date : 20-11-2021
    public function online_offline_user(){
        $responseArr['tocken'] = $this->security->get_csrf_hash();
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            $member_id = $postData['logged_in_user_id'];
            if(isset($postData['status']) && $postData['status'] == 'online'){
                $loggedin_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,matri_id,username,gender','','','');
                $isExist_online = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id' => $member_id),1,'id','','','',0);
                if(empty($isExist_online)){
                    ## Insert : 
                    $insert_arr['member_id'] = (int)$loggedin_member_data['id'];
                    $insert_arr['matri_id'] = $loggedin_member_data['matri_id'];
                    $insert_arr['username'] = $loggedin_member_data['username'];
                    $insert_arr['gender'] = $loggedin_member_data['gender'];
                    $insert_arr['created_at'] = date('Y-m-d H:i:s');
                    $this->db->insert('custom_chat_online_member',$insert_arr);
                }else{
                    ## Update : 
                    $update_arr['member_id'] = (int)$loggedin_member_data['id'];
                    $update_arr['matri_id'] = $loggedin_member_data['matri_id'];
                    $update_arr['username'] = $loggedin_member_data['username'];
                    $update_arr['gender'] = $loggedin_member_data['gender'];
                    $update_arr['created_at'] = date('Y-m-d H:i:s');
                    $this->db->where('id',$isExist_online['id']);
                    $this->db->update('custom_chat_online_member',$update_arr);
                }
                ## Remove Device ID : 
                if($this->input->post('remove_device_id') == 'Yes'){
                    $update_arr_mem['android_device_id'] = "";
                    $this->db->where('id',$member_id);
                    $this->db->update('register',$update_arr_mem);
                }
                $responseArr['status'] = 'success';
                $responseArr['errormessage'] = 'Member online successfully.';
                $responseArr['errmessage'] = 'Member online successfully.';
            }else{
                $this->db->where('member_id',$member_id);
                $this->db->delete('custom_chat_online_member');
                $responseArr['status'] = 'success';
                $responseArr['errormessage'] = 'Member offline successfully.';
                $responseArr['errmessage'] = 'Member offline successfully.';
            }
            ## Send Topic Notification For Online Offline : 
            $this->custom_chat_model->topic_send_notification_web();
            $this->common_model->new_send_notification_android_topic_to_all('Chat User Refresh',"Chat Refresh","chat_topic_android");
		}
		$data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Get Online Members : Date : 20-11-2021
    public function get_online_users($page=1){
        $responseArr['tocken'] = $this->security->get_csrf_hash();
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            $member_id = $postData['logged_in_user_id'];
            $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender,matri_id','','','');
            if(!empty($current_member_data)){
                $current_member_id =  $current_member_data['id'];
                $current_member_matri_id =  $current_member_data['matri_id'];
                $gender =  $current_member_data['gender'];
                if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
                    $this->db->like('matri_id',$postData['searchKeyword']);
                    $this->db->or_like('username',$postData['searchKeyword']);
                }
                $responseArr['continue_request'] = TRUE;
                $responseArr['total_count'] = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id !=' => $current_member_data['id'],'gender !=' => $current_member_data['gender']),0,'id','created_at DESC','','',0);
                // $online_member = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id !=' => $current_member_data['id'],'gender !=' => $current_member_data['gender']),2,'*','created_at DESC',$page,20,0);
                $online_member = $this->common_model->get_count_data_manual('custom_chat_online_member',array('member_id !=' => $current_member_data['id'],'gender !=' => $current_member_data['gender']),2,'*','created_at DESC','','',0);
                 ## Get Recent Chat : Date : 01-07-2022
                 $onlineMemberId = array();
                if(!empty($online_member)){
                    foreach($online_member as $value){
                        $onlineMemberId[] = $value['member_id'];
                    }
                }
                $onlineMemberId = $this->common_model->trim_strin_remove($onlineMemberId);
                if($onlineMemberId == ''){
                    $onlineMemberId = "''";
                }
                $likeRecent = "";
                $whereRecent = "((
                                    member1_id = '$member_id' AND member2_id NOT IN($onlineMemberId)
                                ) OR(
                                    member2_id = '$member_id' AND member1_id NOT IN($onlineMemberId)
                                )) AND register.gender != '$gender'";
                if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
                    $searchKeyword = $postData['searchKeyword'];
                    $likeRecent = " AND (register.matri_id LIKE '%$searchKeyword%' OR register.username LIKE '%$searchKeyword%')";
                    $whereRecent = "((
                                        member1_id = '$member_id' AND member2_id NOT IN($onlineMemberId)
                                    ) OR(
                                        member2_id = '$member_id' AND member1_id NOT IN($onlineMemberId)
                                    )) AND register.gender != '$gender' $likeRecent ";
                }
                $sql="SELECT register.id,
                            CASE WHEN  member1_id = $member_id THEN member2_id WHEN member2_id = $member_id THEN member1_id END AS member_id,register.matri_id,register.username,register.gender,register.registered_on as created_at
                        FROM
                            custom_chat_conversation
                            
                            INNER JOIN register ON  (CASE WHEN  member1_id = $member_id THEN member2_id WHEN  member2_id = $member_id THEN member1_id END = register.id)
                            
                        WHERE
                        $whereRecent GROUP BY register.id,member_id,register.matri_id,register.username,register.gender,created_at";

                $query=$this->db->query($sql);
                $recent_member = $query->result_array();
                if(empty($online_member)){
                    $online_member = array();
                }
                if(!empty($recent_member)){
                    foreach ($recent_member as $value) {
                        $value['is_online'] = 0;
                        $online_member[] = $value;
                    }
                }
                
                $online_member_list = array();
                if(!empty($online_member)){
                    foreach ($online_member as $key => $value) {
                        $online_member_data = array();
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
                            $last_message_display = 'Click to chat.';
                            $last_message_date = '-';
                            $is_block_us = 0;
                            $is_read = "Yes";
                            if($conversation_id != ''){
                                $last_message_data = $this->custom_chat_model->get_conversation_message(1,array('conversation_id' => $conversation_id),'*','1','1');
                                if($last_message_data != '' && !empty($last_message_data)){
                                    $last_message_display = $last_message_data['message'];
                                    $last_message_date = date('jS M Y',strtotime($last_message_data['send_on']));
                                    $is_read = $last_message_data['is_read'];
                                    ## Get Unread Message Count : 
                                    $unread_message_count = $this->custom_chat_model->get_conversation_message(0,array('conversation_id' => $conversation_id,'receiver_member_id' => $current_member_id,'is_read' => 'No'),'id');;
                                }
                            }
                            ## Check Member Block Us : 
                            $check_block_us = $this->common_model->get_count_data_manual('block_profile',array('block_by' => $matri_id,'block_to' => $current_member_matri_id),0,'id','','','');
                            
                            if($check_block_us > 0){
                                $is_block_us = 1;
                            }
                            if($is_block_us == 0){
                                $online_member_data['member_id'] = $member_id;
                                $online_member_data['matri_id'] = $matri_id;
                                $online_member_data['conversation_id'] = $conversation_id;
                                $online_member_data['member_photo_url'] = $member_photo_url;
                                $online_member_data['last_message'] = $last_message_display;
                                $online_member_data['last_message_date'] = $last_message_date;
                                $online_member_data['unread_message_count'] = $unread_message_count;
                                $online_member_data['is_block_us'] = $is_block_us;
                                $online_member_data['is_online'] = (isset($value['is_online'])) ? $value['is_online'] : 1;
                                $online_member_data['is_read'] = $is_read;
    
                                $online_member_list[] = $online_member_data;
                            }
                        }
                    }
                }else{
                    $responseArr['continue_request'] = FALSE;
                }
                $responseArr['status'] = 'success';
                $responseArr['errormessage'] = 'Online member list get successfully.';
                $responseArr['errmessage'] = 'Online member list get successfully.';
                $responseArr['data'] = $online_member_list;
            }else{
                $responseArr['errormessage'] = 'Unauthorized request!';
                $responseArr['errmessage'] = 'Unauthorized request!';
            }
		}
		$data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Get Match Members : Date : 20-11-2021
    public function get_match_users($page=1){
        $responseArr['tocken'] = $this->security->get_csrf_hash();
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $return_result = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            $member_id = $postData['logged_in_user_id'];
            $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender,matri_id','','','');
            if(!empty($current_member_data)){
                $current_member_id =  $current_member_data['id'];
                $current_member_matri_id =  $current_member_data['matri_id'];
                
                ## Get Match : 
                $match_member = $this->custom_chat_model->get_match_member('*',$page);
                $match_member_list = array();
                $responseArr['continue_request'] = TRUE;
                $responseArr['total_count'] = $this->custom_chat_model->get_match_member_count();
                if(!empty($match_member)){
                    foreach ($match_member as $key => $value) {
                        $match_member_data = array();
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
                            $is_exist_conversation = $this->custom_chat_model->get_conversation(1,$where_check_conversation,'*');
                            $conversation_id = '';
                            if($is_exist_conversation !='' && !empty($is_exist_conversation)){
                                $conversation_id = $is_exist_conversation['id'];
                            }
                            ## Get Conversation Message Data :
                            $unread_message_count = 0;
                            $last_message_display = 'Click to chat.';
                            $last_message_date = '-';
                            $is_read = "Yes";
                            $is_block_us = 0;
                            if($conversation_id != ''){
                                $last_message_data = $this->custom_chat_model->get_conversation_message(1,array('conversation_id' => $conversation_id),'*','1','1');
                                if($last_message_data != '' && !empty($last_message_data)){
                                    $last_message_display = $last_message_data['message'];
                                    $last_message_date = date('jS M Y',strtotime($last_message_data['send_on']));
                                    $is_read = $last_message_data['is_read'];
                                    ## Get Unread Message Count : 
                                    $unread_message_count = $this->custom_chat_model->get_conversation_message(0,array('conversation_id' => $conversation_id,'receiver_member_id' => $current_member_id,'is_read' => 'No'),'id');;
                                }
                            }
                            ## Check Member Block Us : 
                            $check_block_us = $this->common_model->get_count_data_manual('block_profile',array('block_by' => $matri_id,'block_to' => $current_member_matri_id),0,'id','','','');
                            if($check_block_us > 0){
                                $is_block_us = 1;
                            }
                            if($is_block_us == 0){
                                $match_member_data['member_id'] = $member_id;
                                $match_member_data['matri_id'] = $matri_id;
                                $match_member_data['conversation_id'] = $conversation_id;
                                $match_member_data['member_photo_url'] = $member_photo_url;
                                $match_member_data['last_message'] = $last_message_display;
                                $match_member_data['last_message_date'] = $last_message_date;
                                $match_member_data['unread_message_count'] = $unread_message_count;
                                $match_member_data['is_block_us'] = $is_block_us;
                                $match_member_data['is_online'] = ($value['custom_chat_id'] !='') ? 1 : 0;
                                $match_member_data['is_read'] = $is_read;
                                $match_member_list[] = $match_member_data;
                            }
                        }
                    }
                }else{
                    $responseArr['continue_request'] = FALSE;
                }
                $responseArr['status'] = 'success';
                $responseArr['errormessage'] = 'Match member list get successfully.';
                $responseArr['errmessage'] = 'Match member list get successfully.';
                $responseArr['data'] = $match_member_list;
            }else{
                $responseArr['msg'] = 'Unauthorized request!';
            }
		}
		$data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Create Coversation : Date : 16-11-2021
    public function create_conversation(){
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            $member_id = $this->input->post('member_id');
            ## Get Online Member List : 
            $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,matri_id,gender,photo1','','','');
            if(!empty($current_member_data)){
                ## Get Conversation Id : 
                $member1Id = $postData['member1_id'];
                $member2Id = $postData['member2_id'];
                $whereConversationArr[] = " ((member1_id = $member1Id AND member2_id = $member2Id) OR (member1_id = $member2Id AND member2_id = $member1Id))";
                $conversationData = $this->common_model->get_count_data_manual('custom_chat_conversation',$whereConversationArr,1,'id,','','','');
                ## Create Conversation If not Create : 
                // if(!isset($postData['conversation_id']) || $postData['conversation_id'] == ''){
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
                    $conversation_data = $this->custom_chat_model->get_conversation(1,array('id' => $conversation_id));
                    ## Set Sender and Receiver Member Id : 
                    $sender_member_id = $current_member_data['id'];
                    $sender_member_matri_id = $current_member_data['matri_id'];
                    
                    if($sender_member_id == $conversation_data['member1_id']){
                        $receiver_member_id = $conversation_data['member2_id'];
                        $receiver_member_matri_id = $conversation_data['member2_matri_id'];
                        $sender_block_column_check = 'member1_block';
                        $receiver_block_column_check = 'member2_block';
                    }
                    if($sender_member_id == $conversation_data['member2_id']){
                        $receiver_member_id = $conversation_data['member1_id'];
                        $receiver_member_matri_id = $conversation_data['member1_matri_id'];
                        $sender_block_column_check = 'member2_block';
                        $receiver_block_column_check = 'member1_block';
                    }
                    if(isset($current_member_data['gender']) && $current_member_data['gender']=='Female'){
                        $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/female.png';
                    }elseif(isset($current_member_data['gender']) && $current_member_data['gender']=='Male'){
                        $sender_member_photo_url = base_url().'assets/front_end/img/default-photo/male.png';
                    }
                    if($current_member_data['photo1'] != ''){
                        $sender_member_photo_url = base_url().$this->common_model->path_photos.$current_member_data['photo1'];
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
                    ## Get Conversation Message : 
                    $conversationId = $conversation_data['id'];
                    $whereConversationArr = array();
                    $whereConversationArr[] = "conversation_id = $conversationId AND blocked_member_id != $sender_member_id ";
                    // $get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,array('conversation_id' => $conversation_data['id']),'*','1','20','id DESC');
                    $get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,$whereConversationArr,'*','1','20','id DESC');
                    if($get_conversation_message_list =='' || empty($get_conversation_message_list)){
                        $get_conversation_message_list = array();
                    }
                    // $get_conversation_message_list = array_reverse($get_conversation_message_list);
                    ## Check Condition For Sender and Receiver : 
                    foreach ($get_conversation_message_list as $key => $value) {
                        if($value['sender_member_id'] == $member_id){
                            $get_conversation_message_list[$key]['is_sender'] = true;
                            $get_conversation_message_list[$key]['is_receiver'] = false;
                        }else{
                            $get_conversation_message_list[$key]['is_sender'] = false;
                            $get_conversation_message_list[$key]['is_receiver'] = true;
                        }
                    }
                    $return_data['conversation_id'] = $conversation_data['id'];
                    $return_data['sender_member_id'] = $sender_member_id;
                    $return_data['sender_member_matri_id'] = $sender_member_matri_id;
                    $return_data['sender_member_photo_url'] = $sender_member_photo_url;
                    $return_data['receiver_member_id'] = $receiver_member_id;
                    $return_data['receiver_member_matri_id'] = $receiver_member_matri_id;
                    $return_data['receiver_member_photo_url'] = $receiver_member_photo_url;
                    $return_data['sender_block'] = $conversation_data[$sender_block_column_check];
                    $return_data['receiver_block'] = $conversation_data[$receiver_block_column_check];
                    $return_data['message_list'] = $get_conversation_message_list;
                    
                    $responseArr['status'] = 'success';
                    $responseArr['errormessage'] = 'Chat created successfully.';
                    $responseArr['errmessage'] = 'Chat created successfully.';
                    $responseArr['data'] = $return_data;
                }else{
                    $responseArr['errormessage'] = 'Chat not created. Please try again!';
                    $responseArr['errmessage'] = 'Chat not created. Please try again!';
                }
            }else{
                $responseArr['errormessage'] = 'Unauthorized request!';
                $responseArr['errmessage'] = 'Unauthorized request!';
            }
		}
		$data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Get More Message List : 
    public function get_more_message($page=1){
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
        if($this->input->post()){
			$postData = $this->input->post();
            $member_id = $this->input->post('member_id');
            ## Get Online Member List : 
            $current_member_data = $this->common_model->get_count_data_manual('register',array('id' => $member_id),1,'id,gender','','','');
            if(!empty($current_member_data)){
                ## Create Conversation If not Create : 
                if(isset($postData['conversation_id']) && $postData['conversation_id'] != ''){
                    ## Get Conversation Message : 
                    $conversationId = $postData['conversation_id'];
                    $whereConversationArr[] = "conversation_id = $conversationId AND blocked_member_id != $member_id ";
                    $get_conversation_message_list = $this->custom_chat_model->get_conversation_message(2,$whereConversationArr,'*',$page,'20','id DESC');
                    if($get_conversation_message_list =='' || empty($get_conversation_message_list)){
                        $get_conversation_message_list = array();
                    }
                    // $get_conversation_message_list = array_reverse($get_conversation_message_list);
                    ## Check Condition For Sender and Receiver : 
                    foreach ($get_conversation_message_list as $key => $value) {
                        if($value['sender_member_id'] == $member_id){
                            $get_conversation_message_list[$key]['is_sender'] = true;
                            $get_conversation_message_list[$key]['is_receiver'] = false;
                        }else{
                            $get_conversation_message_list[$key]['is_sender'] = false;
                            $get_conversation_message_list[$key]['is_receiver'] = true;
                        }
                    }
                    $responseArr['status'] = 'success';
                    if(!empty($get_conversation_message_list)){
                        $responseArr['errormessage'] = 'Get Messages successfully.';
                        $responseArr['errmessage'] = 'Get Messages successfully.';
                        $responseArr['data'] = $get_conversation_message_list;
                        $responseArr['continue_request'] = TRUE;
                    }else{
                        $responseArr['errormessage'] = 'No new messages found.';
                        $responseArr['errmessage'] = 'No new messages found.';
                        $responseArr['continue_request'] = FALSE;
                    }
                    if(count($get_conversation_message_list) < 20){
                        $responseArr['continue_request'] = FALSE;
                    }
                }
            }else{
                $responseArr['errormessage'] = 'Unauthorized request!';
                $responseArr['errmessage'] = 'Unauthorized request!';
            }
		}
        $data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Send Message : Date : 16-11-2021
    public function send_message(){
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['errmessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
            $member_id = $this->input->post('member_id');
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
                        unset($postData['member_id']);
                        unset($postData['sender_member_photo_url']);
                        unset($postData['user_agent']);
                        unset($postData['logged_in_user_id']);
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
                        $responseArr['errormessage'] = 'Message Sent.';
                        $responseArr['errmessage'] = 'Message Sent.';
                    }
                }else{
                    $responseArr['errormessage'] = 'This member is blocked you.';
                    $responseArr['errmessage'] = 'This member is blocked you.';
                }
            }else{
                $responseArr['errormessage'] = 'Unauthorized request!';
                $responseArr['errmessage'] = 'Unauthorized request!';
            }
		}
		$data['data'] = json_encode($responseArr);
        $this->load->view('common_file_echo',$data);
    }

    ## Block Member Chat : Date : 30-06-2022
    public function blockChatMember(){
        $responseArr['status'] = 'error';
        $responseArr['errormessage'] = 'Something went wrong!';
        $responseArr['data'] = array();
        $responseArr['tocken'] = $this->security->get_csrf_hash();
		if($this->input->post()){
			$postData = $this->input->post();
            ## Check Login :
            $member_id = $this->input->post('member_id');
            if($member_id){
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
                            $responseArr['errormessage'] = 'Blocked member.';
                            if($postData['action'] == 0){
                                $responseArr['errormessage'] = 'Unblocked member.'; 
                            }
                        }else{
                            $responseArr['errormessage'] = 'Please refresh page and try again!';        
                        }
                    }
                }else{
                    $responseArr['errormessage'] = 'Unauthorized request!';
                }
            }else{
                $responseArr['errormessage'] = 'Unauthorized request!';
            }
		}
		echo json_encode($responseArr);
    }
}