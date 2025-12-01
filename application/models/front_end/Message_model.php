<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Message_model extends CI_Model {
	public $table_name;
	public $email_templ_data;
	public $sms_templ_data;
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'message';
		//$this->common_model->limit_per_page = 5;
		$this->email_templ_data = '';
		$this->sms_templ_data = '';
	}
	function update_message_read()
	{
		$mode_exp='';
		$status = 'error';
		$user_agent = $this->input->post('user_agent');
		if(isset($user_agent) && ($user_agent =='NI-AAPP' || $user_agent =='NI-IAPP'))
		{
			$matri_id = $this->input->post('matri_id');
		}else{
			$matri_id = $this->common_front_model->get_user_id('matri_id');
		}
		
		$selected_val = '';
		if($this->input->post('selected_val') !='')
		{
			$selected_val = $this->input->post('selected_val');
		}
		$status = '';
		if($this->input->post('status') !='')
		{
			$status = $this->input->post('status');
		}
		if($this->input->post('mode') !='')
		{
			$mode_exp = $this->input->post('mode');
		}
		if($mode_exp =='')
		{
			$mode_exp = 'inbox';
		}
		
		if($status !='' && $selected_val !='')
		{
			$data_array = '';
			if($status == 'delete')
			{
				/*if($mode_exp =='inbox')
				{
					$data_array = array('status'=>'trash');
					$error_message = 'Message Trashed successfully.';
				}
				else if($mode_exp =='trash')
				{
					$data_array = array('trash_receiver'=>'Yes');
					//$data_array = array('trash_sender'=>'Yes');
					$error_message = 'Message deleted successfully.';
				}
				else
				{*/
					$data_array = array('status'=>'trash');
					$error_message = 'Message Trashed successfully.';
					//$data_array = array('trash_sender'=>'Yes');
					//$error_message = 'Message deleted successfully.';
				//}
			}
			else if($status =='read' || $status =='unread')
			{
				if($status =='read')
				{
					$status_up ='Yes';
				}
				else
				{
					$status_up ='No';
				}
				$data_array = array('read_status'=>$status_up);
				$error_message = 'Message status updated successfully.';
			}
			else if($status =='imported' || $status =='unimported')
			{
				if($status =='imported')
				{
					$status_up ='Yes';
				}
				else
				{
					$status_up ='No';
				}
				$data_array = array('important_status'=>$status_up);
				$error_message = 'Message status updated successfully.';
			}
			if($data_array !='' && count($data_array) > 0)
			{
				if($selected_val !='' && !is_array($selected_val))
				{
					$selected_val = explode(',',$selected_val);
				}
				
				$this->db->where_in('id', $selected_val);
				if($status == 'delete')
				{
					if($mode_exp =='trash')
					{
						$error_message = 'Message deleted successfully.';
					}	
					$message_data = $this->common_model->get_count_data_manual($this->table_name,'',2,'message.*','message.id desc','','');
					
					if(isset($message_data) && $message_data!= '')
					{
						foreach($message_data as $delete_trash)
						{
							if(isset($matri_id))
							{
								if($mode_exp =='sent')
								{
									$data_array = array('trash_sender'=>'Yes');
								}
								elseif($mode_exp =='trash')
								{
									if($delete_trash['sender'] == $matri_id)
									{
										$data_array = array('sender_delete'=>'Yes');
									}
									elseif($delete_trash['receiver'] == $matri_id)
									{
										$data_array = array('receiver_delete'=>'Yes');
									}
								}
								else
								{
									if($delete_trash['sender'] == $matri_id)
									{
										$data_array = array('trash_sender'=>'Yes','status'=>'trash');
									}
									elseif($delete_trash['receiver'] == $matri_id)
									{
										$data_array = array('trash_receiver'=>'Yes','status'=>'trash');
									}
								}
								
								$where_array = array('id'=>$delete_trash['id']);
								$this->common_model->update_insert_data_common($this->table_name,$data_array,$where_array,1,0);
							}						
						}
					}
				}
				else
				{
					$this->common_model->update_insert_data_common($this->table_name,$data_array,'',1,0);
				}
				$status = 'success';
			}
			else
			{
				$status = 'error';
				$error_message = 'Sorry some error ocurred, please try again.';
			}
		}
		else
		{
			$error_message = 'Please select atleast one recourd, try again';
		}
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = $status;
		$data1['error_meessage'] = $error_message;
		$data1['errmessage'] = $error_message;
		return $data1;
	}
	function get_message_count()
	{
		$matri_id = $this->common_front_model->get_user_id('matri_id');
		$inbox = 0;
		$sent = 0;
		$draft = 0;
		$trash = 0;
		
		$inbox = $this->get_message_list(0,'','inbox','No');
		$sent = $this->get_message_list(0,'','sent','No');
		$draft = $this->get_message_list(0,'','draft','No');
		$trash = $this->get_message_list(0,'','trash','No');
		$data = array(
			'inbox'=>$inbox,
			'sent'=>$sent,
			'draft'=>$draft,
			'trash'=>$trash,
		);
		return $data;
	}
	function get_message_list($post=0,$page='',$mode_exp='',$filter='Yes')
	{
		$where_arra = array();
		if($this->input->post('mode') !='' && $mode_exp =='')
		{
			$mode_exp = $this->input->post('mode');
		}
		if($this->input->post('page_number') !='')
		{
			$page_number = $this->input->post('page_number');
			if($page_number !='' && $page_number > 0)
			{
				$page = $page_number;
			}
		}
		$message_search = '';
		if(isset($filter) && $filter == 'Yes')
		{
			if($this->input->post('message_search') !='')
			{
				$message_search = $this->input->post('message_search');
			}
		}
		if($mode_exp == '' )
		{
			$mode_exp = 'inbox';
		}
		$member_id = $this->common_front_model->get_user_id('matri_id','matri_id');
		$this->common_model->set_table_name($this->table_name);
		if($mode_exp =='inbox')
		{
			$where_arra=array('message.receiver'=>$member_id,'message.trash_receiver'=>'No','message.status'=>'sent');
			//$this->db->join('search_register_view','message.sender = search_register_view.matri_id ','left');
		}
		else if($mode_exp =='sent')
		{
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No');
			$where_arra[] = " message.status != 'draft' ";
			//$this->db->join('search_register_view','message.receiver = search_register_view.matri_id ','left');
		}
		else if($mode_exp =='draft')
		{
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No','message.status'=>'draft');
			//$this->db->join('search_register_view','message.receiver = search_register_view.matri_id ','left');
		}
		else if($mode_exp =='trash')
		{
			//$where_arra=array('message.receiver'=>$member_id,'message.trash_receiver'=>'No','message.status'=>'trash');
			$where_arra[] = " (( sender = '$member_id' and trash_sender != 'No'  and sender_delete = 'No') or (receiver = '$member_id' and trash_receiver != 'No' and receiver_delete = 'No')) ";
		}
		if($message_search !='')
		{
			$where_arra[] = " ( sender like '%$message_search%' or receiver like '%$message_search%' or content like '%$message_search%' ) ";
		}
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,0,'');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,2,'message.*','message.id desc',$page,10);

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
						//$photo_data[0]['photo1'] = '';
						$data[$key]['member_photo']=array();
					}
					
				}
			}
		}
		return $data;
	}
	function send_message()
	{
		$status = 'error';
		$error_message = "";
		$user_id = $this->common_front_model->get_user_id('matri_id','matri_id');
		if($user_id !='')
		{
			$message = '';
			$receiver_id = '';
			$msg_status ='';
			//$subject ='';
			$message_id = '';

			if($this->input->post('message'))
			{
				$message = $this->input->post('message');
			}
			// if($this->input->post('subject'))
			// {
			// 	$subject = $this->input->post('subject');
			// }
			if($this->input->post('msg_status'))
			{
				$msg_status = $this->input->post('msg_status');
			}
			if($this->input->post('receiver_id'))
			{
				$receiver_id = $this->input->post('receiver_id');
			}
			if($this->input->post('message_id'))
			{
				$message_id = $this->input->post('message_id');
			}
			
			if($message !='' && $receiver_id !='')
			{
				$sent_on = $this->common_model->getCurrentDate();
				$receiver_id_arr = $receiver_id;
				if(!is_array($receiver_id))
				{
					$receiver_id_arr = explode(",",$receiver_id);
				}
				$count_rec = count($receiver_id_arr);
				if($msg_status == 'sent')
				{
					$count_msg = $this->common_front_model->get_plan_detail($user_id,'message','Yes');					
					if(($count_rec > $count_msg && $count_msg > 0) || ($count_msg == '0'))
					{
						$msg_status = 'draft';
						$error_message = "You are not enough message limit, Please upgrade your membership to send message.";
					}
					else if($count_msg=='No')
					{
						$msg_status = 'draft';
						$error_message = "You are not a paid member, Please upgrade your membership to send message.";
					}
				}
				$retuen_resp_succ = true;
				if($message_id !='')
				{
					$this->common_model->data_delete_common($this->table_name,array('id'=>$message_id),1,'Yes');
				}
				$msg_succ_sent_arr = array();
				$msg_block_sent_arr = array();
				foreach($receiver_id_arr as $receiver_id_val)
				{
					$block_count = $this->common_model->get_count_data_manual('block_profile',array('block_to'=>$user_id,'block_by'=>$receiver_id_val,'is_deleted'=>'No'),0,'id');
					if($block_count == 1 && $msg_status == 'sent')
					{
						$msg_block_sent_arr[] = $receiver_id_val;
					}
					else
					{
						$msg_succ_sent_arr[] = $receiver_id_val;
					
						$data_array_custom = array(
							'sender'=>$user_id,
							'receiver'=>$receiver_id_val,
							//'subject'=>$subject,
							'content'=>$message,
							'status'=>$msg_status,
							'sent_on'=>$sent_on
						);
						
						/*if($message_id !='')
						{
							$retuen_resp = $this->common_front_model->save_update_data('message',$data_array_custom,'id','edit',$message_id);
						}
						else
						{*/
							$retuen_resp = $this->common_front_model->save_update_data($this->table_name,$data_array_custom);
							$last_message_id = $this->db->insert_id();
						/*}*/
						if($retuen_resp && $msg_status == 'sent')
						{
							$this->send_message_mail($data_array_custom);
						}
					}
				}
				if($retuen_resp_succ && $error_message =='')
				{
					if($msg_status == 'sent')
					{
						$imp_succ_mat = '';
						$imp_block_mat = '';
						if(isset($msg_succ_sent_arr) && count($msg_succ_sent_arr) > 0)
						{
							$imp_succ_mat = implode(', ',$msg_succ_sent_arr);
							$error_message = "Message Sent Successfully to Matri ID $imp_succ_mat.";

							//for include last message id
							if(isset($data_array_custom) && $data_array_custom!='' && count($data_array_custom)>0)
							{
								foreach ($data_array_custom as $key => $value) {
									$data_array_custom['id'] = $last_message_id;

									$where_photoarr_1 = array('matri_id'=>$user_id);
									$opposite_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender , birthdate, height ");
									if(isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0)
									{
										//$opposite_user_photo = $this->common_model->member_photo_disp_opp($opposite_user_data);
										$data_array_custom['photo_url'] = $this->common_model->member_photo_disp($opposite_user_data);
									}
								}
							}
							//app push notification
$Message_data = $this->common_front_model->get_user_data('register',$receiver_id_val,'id,ios_device_id,android_device_id,web_device_id','matri_id');
							if(isset($Message_data) && $Message_data!='' && count($Message_data)>0)
{
	foreach ($Message_data as $key => $value) {
		if(isset($value) && $value!='' && isset($key) && $key!=''){
			$M_message = $user_id.' : '.$message;
			if($key == 'web_device_id'){
				if(isset($Message_data['web_device_id']) && $Message_data['web_device_id']!=''){
					$data_array = array(
						'device_id'=>$value,
						'sender_id' => $Message_data['id'],
						'receiver_id' => $Message_data['id'],
						'notification_type' => 'message',
						'title' => 'New Message',
						'message' => $M_message,
						'click_action'=>base_url().'message',
					);
					$this->common_model->new_send_notification_web($data_array);
				}
			}else if($key=='ios_device_id' || $key=='android_device_id'){
				if($key == 'ios_device_id'){
					$app_type = 'IOS';
				}
				else{
					$app_type = 'Android';
				}
				$sender_receiver = array('sender'=>$Message_data['id'],'receiver'=>$Message_data['id'],'app_type'=>$app_type);
				$this->common_model->new_send_notification_android($value,$M_message,'Message','message',$Message_data['id'],'',$data_array_custom,$sender_receiver);
			}
		}
	}	
}
						}
						
						if(isset($msg_block_sent_arr) && count($msg_block_sent_arr) > 0)
						{
							$imp_block_mat = implode(', ',$msg_block_sent_arr);
							$error_message = $error_message." Message not Sent to Matri ID $imp_block_mat because of this member has blocked you.";
						}
					}
					else
					{
						$error_message = "Message Saved Successfully in draft";
					}
					if(isset($msg_succ_sent_arr) && count($msg_succ_sent_arr) > 0)
					{
						$status ='success';
					}
					else
					{
						$status ='error';
					}
				}
				else
				{
					if($error_message =='')
					{
						$error_message = "Message Not Sent, Please try again";
					}
				}
			}
			else
			{
				$error_message = "Please enter message and provide Receiver ID";
			}
		}
		else
		{
			$error_message = "Your session time out, Please Login First";
		}
		$data = $this->common_front_model->return_jsone_response($status,'',$error_message,'error_message');
		
		return $data;
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
	public function get_member_list()
	{
		
		$opt_array['results'] = array();
		$search = $this->input->post('q');
		
		if(isset($_REQUEST['user_agent']) && ($_REQUEST['user_agent'] =='NI-AAPP' || $_REQUEST['user_agent'] =='NI-IAPP'))
		{
			$matri_id = $this->input->post('matri_id');
			$gender = $this->input->post('gender');
		}else{
			$matri_id = $this->common_front_model->get_user_id('matri_id');
			$gender = $this->common_front_model->get_user_id('gender');
		}
		
		if($matri_id !='' && $gender !='')
		{
			$where_arra = array('is_deleted'=>'No'," (matri_id like '%$search%') and status !='Suspended' and status!='Inactive' and matri_id != '".$matri_id."' and gender!='".$gender."' ");
			$data_arr = $this->common_front_model->get_count_data_manual('register',$where_arra,2,'matri_id','','1',25,"");
			
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				foreach($data_arr as $data_arr_val)
				{
					$forpushingarray = array("id"=>$data_arr_val['matri_id'],"text"=>$data_arr_val['matri_id']);
					array_push($opt_array['results'],$forpushingarray);
				}
			}
			$opt_array['more'] = "false";
		}
		return $opt_array;
	}
	function compose_msg($msg_id='',$mode=''){
		$message = '';
		$message_id = '';
		$receiver_id ='';
		if(isset($msg_id) && $msg_id !=''){
			$msg_id_new = $this->common_model->descrypt_id($msg_id);
			$matri_id = $this->common_front_model->get_user_id('matri_id');
			$where_arra = array('id'=>$msg_id_new,'is_deleted'=>'No');
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
		
		$options = '';
		$delete = '';
		if(isset($receiver_id) && $receiver_id !=''){
			$options = '<option selected value="'.$receiver_id.'">'.$receiver_id.'</option>';
		}
		if((isset($mode) && $mode == 'draft') && $message_id !=''){
			$delete = '<button onClick="return draft_delete('."'".$message_id."'".')" data-toggle="modal" data-target="#myModal_delete" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Delete</button>';
		}
		if(isset($message_type) && $message_type=="trash"){$trash = "Deleted Permanently";}else{ $trash = "Trashed";}
		
		$html = '<div class="modal-dialog  modal-dialog-vendor" id="sc_div_message">
			<div class="modal-content">
				<div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
					<p class="Poppins-Bold mega-n3 new-event text-center">Compose <span class="mega-n4 f-s">Message</span></p>
					<button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
				</div>
				<div class="modal-body">
					<div id="response_update"></div>
					<form id="mes_content_form" method="post" action="'.base_url().'message/send_message">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<p class="Poppins-Medium f-16 color-31 ad-name">To:</p>
							</div>
							<div class="col-md-9 col-sm-9 col-xs-12">
								<select data-placeholder="Choose Receiver Matri ID" class="select2 form-control new-chosen-height" multiple name="to_message[]" data-validetta="required" id="to_message">
								'.$options.'
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
									<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" id="hash_tocken_id" class="hash_tocken_id" />
									<input type="hidden" id="base_url" value="'.base_url().'" /> 
									<textarea style="display:none" id="msg_content" name="msg_content">'.$message.'</textarea>
									<input type="hidden" id="msg_staus" name="msg_status" value="'.$mode.'">
									<input type="hidden" id="msg_id" name="msg_id" value="'.$message_id.'">
									'.$delete.'
									<button type="submit" onClick="return save_draft_send_message('."'draft'".');" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">
										Save as Draft
									</button>
									<button type="submit" onClick="return save_draft_send_message('."'sent'".');" class="add-w-btn left-zero-msg new-msg-btn Poppins-Medium color-f f-18">
										Send
									</button>
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>';
		return $html;
	}
}
?>