<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Message_api_model extends CI_Model {

	public $tableName;
	public $email_templ_data;
	public $sms_templ_data;
	public function __construct()
	{
		parent::__construct();
		$this->tableName = 'message';
		$this->email_templ_data = '';
		$this->sms_templ_data = '';
	}

    ##Date 01/05/2025
    public function get_message_list($post=0,$page='',$mode_exp='',$filter='Yes')
	{
		$where_arra = array();
        $postData = $this->input->post();
        $mode_exp = $mode_exp ?: ($postData['mode'] ?? '');
        $page = (!empty($postData['page_number']) && $postData['page_number'] > 0) ? $postData['page_number'] : $page;
        $searchKeyword = ($filter === 'Yes' && !empty($postData['searchKeyword'])) ? $postData['searchKeyword'] : '';
        $limit = 10;

		if($mode_exp == '' )
		{
			$mode_exp = 'inbox';
		}
        
		$member_id = $this->common_front_model->get_user_id('matri_id','matri_id');
		// $this->common_model->set_tableName($this->tableName);
		if($mode_exp =='inbox')
		{
			$where_arra=array('message.receiver'=>$member_id,'message.trash_receiver'=>'No','message.status'=>'sent');
		}
		else if($mode_exp =='sent')
		{
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No');
			$where_arra[] = " message.status != 'draft' ";
		}
		else if($mode_exp =='draft')
		{
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No','message.status'=>'draft');
		}
		else if($mode_exp =='trash')
		{
			$where_arra[] = " (( sender = '$member_id' and trash_sender != 'No'  and sender_delete = 'No') or (receiver = '$member_id' and trash_receiver != 'No' and receiver_delete = 'No')) ";
		}
		if($searchKeyword !='')
		{
			$where_arra[] = " ( sender like '%$searchKeyword%' or receiver like '%$searchKeyword%' or content like '%$searchKeyword%' ) ";
		}
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual($this->tableName,$where_arra,0,'');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual($this->tableName,$where_arra,2,'message.*','message.id desc',$page,$limit);
			if(!empty($data))
			{
				foreach($data as $key=>$val)
				{
					$where_arras=$where_arra='';
					$photo_data = array();
					$data[$key]['member_photo']='';
					if(isset($val['status']) && $val['status']=='sent')
					{
						if(isset($member_id) && isset($val['sender']) && $member_id==$val['sender'])
						{
							$where_arra=array('matri_id'=>$val['receiver'],'is_deleted'=>'No');
						}
						else
						{
							$where_arra=array('matri_id'=>$val['sender'],'is_deleted'=>'No');
						}	
					}
					else if(isset($val['status']) && $val['status'] =='draft')
					{
						if(isset($val['receiver']) && $val['receiver'] !='')
						{
							$where_arra=array('matri_id'=>$val['receiver'],'is_deleted'=>'No');
						}
					}
					else if(isset($val['status']) && $val['status'] =='trash')
					{
						if(isset($member_id) && isset($val['sender']) && $member_id==$val['sender'])
						{
							$where_arra=array('matri_id'=>$val['receiver'],'is_deleted'=>'No');
						}
						else
						{
							$where_arra=array('matri_id'=>$val['sender'],'is_deleted'=>'No');
						}	
					}
					$where_arras = array('photo_view_status','photo1_approve','photo1');
					$photo_data = $this->common_model->get_count_data_manual('register',$where_arra,2,$where_arras,'','');
					$photo_path = $this->common_model->path_photos;
					$path = $this->common_front_model->base_url;
					if(isset($photo_data[0]['photo1']) && $photo_data[0]['photo1']!='')
					{	
						$photo_data[0]['photo1'] = $path.$photo_path.$photo_data[0]['photo1'];
						$data[$key]['member_photo']=$photo_data;
					}
					else 
					{
						$data[$key]['member_photo']=array();
					}					
				}
			}
		}
		return $data;
	}

    ##Date 01/05/2025
    public function update_message_status()
    {
        $postData = $this->input->post();
    
        $status     = $postData['status'] ?? '';
        $matri_id   = $postData['matri_id'] ?? '';
        $selected   = isset($postData['selected_val']) ? explode(',', $postData['selected_val']) : [];
        $mode       = $postData['mode'] ?? 'inbox';
    
        if (empty($status) || empty($selected)) {
            return ['status' => 'error', 'message' => 'Invalid data provided'];
        }
    
        $data_array = [];
        $success_message = '';
    
        switch ($status) {
            case 'delete':
                $success_message = 'Message moved to trash successfully.';
                break;
            case 'read':
                $data_array['read_status'] = 'Yes';
                $success_message = 'Message marked as read.';
                break;
            case 'unread':
                $data_array['read_status'] = 'No';
                $success_message = 'Message marked as unread.';
                break;
            case 'imported':
                $data_array['important_status'] = 'Yes';
                $success_message = 'Message marked as important.';
                break;
            case 'unimported':
                $data_array['important_status'] = 'No';
                $success_message = 'Message marked as not important.';
                break;
            default:
                return ['status' => 'error', 'message' => 'Invalid status action'];
        }
    
        if ($status === 'delete') {
            $messages = $this->common_model->get_count_data_manual($this->tableName, '', 2, '*', 'id DESC');
            foreach ($messages as $msg) {
                if (!in_array($msg['id'], $selected)) continue;
    
                if ($mode === 'trash') {
                    $data_array = ($msg['sender'] == $matri_id) ? ['sender_delete' => 'Yes'] : ['receiver_delete' => 'Yes'];
                } elseif ($mode === 'sent') {
                    $data_array = ['trash_sender' => 'Yes'];
                } else {
                    $data_array = ($msg['sender'] == $matri_id)
                        ? ['trash_sender' => 'Yes', 'status' => 'trash']
                        : ['trash_receiver' => 'Yes', 'status' => 'trash'];
                }
    
                $this->common_model->update_insert_data_common($this->tableName, $data_array, ['id' => $msg['id']], 1, 0);
            }
        } else {
            $this->db->where_in('id', $selected);
            $this->common_model->update_insert_data_common($this->tableName, $data_array, '', 1, 0);
        }
    
        return ['status' => 'success', 'message' => $success_message];
    }

    ##Date 01/05/2025
    public function get_member_list()
    {
        $response = ['results' => [], 'more' => false];
        $postData = $this->input->post();
        $matri_id       = $postData['matri_id'] ?? '';
        $gender         = $postData['gender'] ?? '';
        $searchKeyword  = $postData['searchKeyword'] ?? '';

        if (!empty($matri_id) && !empty($gender)) {
            $whereArr = "matri_id != '$matri_id' 
                            AND gender != '$gender' 
                            AND status NOT IN ('Suspended', 'Inactive') 
                            AND is_deleted = 'No'";

            if (!empty($searchKeyword)) {
                $searchKeyword = $this->db->escape_like_str($searchKeyword);
                $whereArr .= " AND matri_id LIKE '%$searchKeyword%'";
            }
            $members  = $this->common_front_model->get_count_data_manual('register', $whereArr, 2, 'matri_id,username', '', '1', 25, "");
            if (!empty($members)) {
                foreach ($members as $member) {
                    $response['results'][] = [
                        'id'   => $member['matri_id'],
                        'name' => $member['username']
                    ];
                }
            }
        }
        return $response;
    }

     ##Date 01/05/2025
    public function send_message()
	{
        $status = 'error';
        $error_message = '';
        $user_id = $this->common_front_model->get_user_id('matri_id', 'matri_id');
        if (empty($user_id)) {
            return $this->common_front_model->return_jsone_response($status, '', "Your session timed out, please login again", 'error_message');
        }
        $message     = $this->input->post('message');
        $receiver_id = $this->input->post('receiver_id');
        $msg_status  = $this->input->post('msg_status');
        $message_id  = $this->input->post('message_id');
    
        if (empty($message) || empty($receiver_id)) {
            return $this->common_front_model->return_jsone_response($status, '', "Please enter message and provide Receiver ID", 'error_message');
        }

        $sent_on = $this->common_model->getCurrentDate();
        $receiver_ids = is_array($receiver_id) ? $receiver_id : explode(",", $receiver_id);
    
        if ($msg_status === 'sent') {
            $allowed_msg_count = $this->common_front_model->get_plan_detail($user_id, 'message', 'Yes');
            $receiver_count = count($receiver_ids);
            if (($allowed_msg_count !== 'No' && $receiver_count > $allowed_msg_count) || $allowed_msg_count === '0') {
                $msg_status = 'draft';
                $error_message = "You don't have enough message credits. Please upgrade your membership.";
            } elseif ($allowed_msg_count === 'No') {
                $msg_status = 'draft';
                $error_message = "You are not a paid member. Please upgrade your membership.";
            }
        }

        if (!empty($message_id)) {
            $this->common_model->data_delete_common($this->tableName, ['id' => $message_id], 1, 'Yes');
        }

        $msg_sent = [];
        $msg_blocked = [];
        $last_message_id = null;

        foreach ($receiver_ids as $rid) {
            $is_blocked = $this->common_model->get_count_data_manual('block_profile', [
                'block_to' => $user_id,
                'block_by' => $rid,
                'is_deleted' => 'No'
            ], 0, 'id');
    
            if ($is_blocked && $msg_status === 'sent') {
                $msg_blocked[] = $rid;
                continue;
            }
    
            $msg_sent[] = $rid;
    
            $data_array = [
                'sender'   => $user_id,
                'receiver' => $rid,
                'content'  => $message,
                'status'   => $msg_status,
                'sent_on'  => $sent_on
            ];
    
            $this->common_front_model->save_update_data($this->tableName, $data_array);
            $last_message_id = $this->db->insert_id();
    
            // Send email notification only for sent messages
            if ($msg_status === 'sent') {
                $this->send_message_mail($data_array);
            }
            // Add photo URL for push notifications
            $user_info = $this->common_model->get_count_data_manual("register", ['matri_id' => $user_id], 1, "id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender , birthdate, height");
            if (!empty($user_info)) {
                $data_array['photo_url'] = $this->common_model->member_photo_disp($user_info);
            }
    
            // Push notification
            $receiver_info = $this->common_front_model->get_user_data('register', $rid, 'id, ios_device_id, android_device_id, web_device_id', 'matri_id');
            if (!empty($receiver_info)) {
                $notif_msg = $user_id . ' : ' . $message;
                foreach ($receiver_info as $key => $val) {
                    if (empty($val)) continue;

                    if ($key === 'web_device_id') {
                        $this->common_model->new_send_notification_web([
                            'device_id'        => $val,
                            'sender_id'        => $receiver_info['id'],
                            'receiver_id'      => $receiver_info['id'],
                            'notification_type'=> 'message',
                            'title'            => 'New Message',
                            'message'          => $notif_msg,
                            'click_action'     => base_url('message'),
                        ]);
                    } elseif (in_array($key, ['ios_device_id', 'android_device_id'])) {
                        $app_type = $key === 'ios_device_id' ? 'IOS' : 'Android';
                        $this->common_model->new_send_notification_android($val, $notif_msg, 'Message', 'message', $receiver_info['id'], '', $data_array, [
                            'sender'   => $receiver_info['id'],
                            'receiver' => $receiver_info['id'],
                            'app_type' => $app_type,
                        ]);
                    }
                }
            }
        }
        if (!empty($msg_sent)) {
            $status = 'success';
            $success_msg = "Message Sent Successfully to Matri ID(s): " . implode(', ', $msg_sent);
            if (!empty($msg_blocked)) {
                $success_msg .= ". Message not sent to blocked ID(s): " . implode(', ', $msg_blocked);
            }
            $error_message = $msg_status === 'draft' ? "Message saved as draft." : $success_msg;
        } elseif (!empty($msg_blocked)) {
            $error_message = "Message not sent to Matri ID(s): " . implode(', ', $msg_blocked) . " (blocked you).";
        } else {
            $error_message = "Message not sent. Please try again.";
        }
        return $this->common_front_model->return_jsone_response($status, '', $error_message, 'error_message');
	}

    public function send_message_mail($data_array_custom='')
	{ 
		if($data_array_custom !='' && count($data_array_custom) > 0)
		{
			if(isset($data_array_custom['sender']) && $data_array_custom['sender'] !='')
			{
				$sender = $data_array_custom['sender'];
				$receiver = $data_array_custom['receiver'];
				$this->common_front_model->update_plan_detail($sender,'message');
				if($this->email_templ_data == '')
				{
					$this->email_templ_data = $this->common_front_model->getemailtemplate('New Message');
				}
				if($this->sms_templ_data == '')
				{
					$this->sms_templ_data = $this->common_front_model->get_sms_template('Message Received');
				}
				$email_temp_data = $this->email_templ_data;
				$sms_templ_data = $this->sms_templ_data;
				if($receiver !='')
				{
					$rec_detail = $this->common_model->get_count_data_manual('register',array('matri_id'=>$receiver),1,'email, username,mobile');
					if(isset($rec_detail) && $rec_detail !='' && count($rec_detail) > 0)
					{
						$username = $rec_detail['username'];
						
						$data_array = array('sender'=>$sender,'username'=>$username,'member'=>$username);
						
						if(isset($rec_detail['email']) && $rec_detail['email'] !='' && $email_temp_data !='' && count($email_temp_data) > 0)
						{
							$rec_eamil = $rec_detail['email'];
							$email_content = $email_temp_data['email_content'];
							$email_subject = $email_temp_data['email_subject'];
							$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);
							$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
						
							$this->common_model->common_send_email($rec_eamil,$email_subject,$email_content);
						}
						if(isset($rec_detail['mobile']) && $rec_detail['mobile'] !='' && $sms_templ_data !='' && count($sms_templ_data) > 0)
						{
							$mobile = $rec_detail['mobile'];
							$sms_content = $sms_templ_data['sms_content'];
							$template_id =$sms_templ_data['template_id'];
							$sms_content = $this->common_front_model->getstringreplaced($sms_content,$data_array);
							$this->common_model->common_sms_send($mobile,$sms_content,$template_id);
						}
					}
					
				}
			}
			
		}
	}

    public function view_message()
    {
        $status = 'error';
        $error_message = '';
        $postData  = $this->input->post();    
        $msgId     = $postData['msg_id'] ?? '';
        $matri_id  = $postData['matri_id'] ?? '';
        $mode      = $postData['mode'] ?? 'inbox';
    
        if (empty($matri_id)) {
            return $this->common_front_model->return_jsone_response($status, '', "Your session timed out, please login again", 'error_message');
        }
        if (empty($msgId)) {
            return $this->common_front_model->return_jsone_response($status, '', "Please provide a valid Message ID", 'error_message');
        }
        $where = [];
        switch ($mode) {
            case 'sent':
                $where = [
                    'id' => $msgId,
                    'sender' => $matri_id,
                    'sender_delete' => 'No',
                    'trash_sender' => 'No'
                ];
                $where[] = "status != 'draft'";
                break;
    
            case 'trash':
                $where[] = "id = '$msgId' AND (
                    (sender = '$matri_id' AND trash_sender != 'No' AND sender_delete = 'No') OR
                    (receiver = '$matri_id' AND trash_receiver != 'No' AND receiver_delete = 'No')
                )";
                break;
    
            case 'inbox':
            default:
                $where = [
                    'id' => $msgId,
                    'receiver' => $matri_id,
                    'status' => 'sent',
                    'receiver_delete' => 'No',
                    'trash_receiver' => 'No'
                ];
                break;
        }
        $messageData = $this->common_front_model->get_count_data_manual('message', $where, 1);
        if (empty($messageData)) {
            $error_message = "Message not found or you do not have permission to view this message.";
            return $this->common_front_model->return_jsone_response($status, '', $error_message, 'error_message');
        }
        return $this->common_front_model->return_jsone_response('success', $messageData, '', '');
    }
    

}
?>