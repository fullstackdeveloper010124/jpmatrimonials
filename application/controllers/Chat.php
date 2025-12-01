<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Chat extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
		$this->email_templ_data = '';
		$this->sms_templ_data = '';
	}
	public function index(){
	}
	public function get_member_list()
	{
		$this->load->library('form_validation');
		$response["status"] = "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		$response["total_count"] = 0;
		$response["continue_request"] = false;
		$response["data"] = array();
		$this->form_validation->set_rules('member_id','Matri id','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('member_id');			
			$limit = 10;
			if(isset($_REQUEST["page_number"]) && $_REQUEST["page_number"]!='')
			{
				$page = $_REQUEST["page_number"];
			}
			$search = $this->input->post('q');
			$member_id = $this->input->post('member_id');
			$gender = $this->input->post('gender');
			
			if($member_id !='' && $gender!='')
			{
				$where_arra = array(" online_users.index_id != '".$member_id."' and online_users.gender != '".$gender."' and register.gender != '".$gender."' ");
				if($search!=''){
					$where_arra[] = " (online_users.username like '%$search%') ";
				}
				## For Deleted Member Check : Date : 05-08-2021
				$where_arra[] = " ( register.is_deleted = 'No' and register.status='APPROVED' ) ";
				$this->db->join('register','register.id = online_users.index_id','INNER');
				$data = $this->common_front_model->get_count_data_manual('online_users',$where_arra,2,'online_users.username,online_users.gender,online_users.index_id','',$page,'','','','','');
				//echo $this->db->last_query();
			}
			if(isset($data) && $data!='' && is_array($data) && count($data)>0)
			{
				## For Deleted Member Check : Date : 05-08-2021
				$this->db->join('register','register.id = online_users.index_id','INNER');
				$response["total_count"] = $this->common_front_model->get_count_data_manual('online_users',$where_arra,0,'online_users.username,online_users.index_id','','','','','','','');
				$opt_array['results'] = array();
				foreach($data as $data_arr_val)
				{
					$datt = $this->common_front_model->get_count_data_manual('register',array('id'=>$data_arr_val['index_id'],'status'=>'APPROVED'),1,'matri_id,gender, photo1, photo1_approve, photo_view_status, photo_protect, photo_password','',$page,'','','','','');
					$forpushingarray = array("id"=>$data_arr_val['index_id'],"text"=>$data_arr_val['username'],"gender"=>$data_arr_val['gender'],"username"=>$data_arr_val['username'],'matri_id'=>$datt['matri_id']);
					$forpushingarray['photo_url'] = $this->common_model->member_photo_disp($datt);
					array_push($opt_array['results'],$forpushingarray);
				}
				$response["data"] = $opt_array;
				
				$response["statuscode"] = 200;
				$response["status"] = "success";
				$response["message"] = 'All Member list';
				$response["errmessage"] = 'All Member list';
				$response["continue_request"] = true;
			}
			else
			{
				$response["message"] = 'No member list availabel';
				$response["errmessage"] = 'No member list availabel';
			}			
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));
	}

	public function get_member_list_new()
	{
		$opt_array['results'] = array();
		$search = $this->input->post('q');
		$member_id = $this->input->post('member_id');
		$gender = $this->input->post('gender');
		
		if($member_id !='' && $gender!='')
		{
			$where_arra = array(" index_id != '".$member_id."' and gender != '".$gender."' ");
			$data_arr = $this->common_front_model->get_count_data_manual('online_users',$where_arra,2,'username,index_id','','1',25,"");
			
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				foreach($data_arr as $data_arr_val)
				{
					$forpushingarray = array("id"=>$data_arr_val['index_id'],"text"=>$data_arr_val['username']);
					array_push($opt_array['results'],$forpushingarray);
				}
			}
			$opt_array['more'] = "false";
		}
		return $opt_array;
	}

	public function update_status()
	{
		if($this->input->post('status') !='')
		{
			$this->data['update_status'] = $this->update_message_read();
		}
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] != 'NI-WEB')
		{
			$data['data'] = json_encode($this->data['update_status']);
			$this->load->view('common_file_echo',$data);
		}
	}
	function update_message_read()
	{
		$mode_exp='';
		$status = 'error';
		$user_agent = $this->input->post('user_agent');
		$matri_id = $this->input->post('member_id');
		
		$selected_val = '';
		if($this->input->post('selected_val') !=''){
			$selected_val = $this->input->post('selected_val');
		}
		$status = '';
		if($this->input->post('status') !=''){
			$status = $this->input->post('status');
		}
		if($this->input->post('mode') !=''){
			$mode_exp = $this->input->post('mode');
		}
		if($mode_exp ==''){
			$mode_exp = 'inbox';
		}
		
		if($status !='' && $selected_val !='')
		{
			$data_array = '';
			if($status =='read' || $status =='unread'){
				if($status =='read'){
					$status_up ='Yes';
				}
				else{
					$status_up ='No';
				}
				$data_array = array('read_status'=>$status_up);
				$error_message = 'Message status updated successfully.';
			}
			if($data_array !='' && count($data_array) > 0)
			{
				if($selected_val !='' && !is_array($selected_val))
				{
					$selected_val = explode(',',$selected_val);
				}
				
				$this->db->where_in('id', $selected_val);
				
				$this->common_model->update_insert_data_common('frei_chat',$data_array,'',1,0);
				
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
	public function send_message_new()
	{
		$data = $this->send_msg();
		$this->load->view("common_file_echo",$data);
	}

	function send_msg()
	{
		$status = 'error';
		$error_message = "";
		$user_id = $this->input->post('member_id');
		if($user_id !='')
		{
			$message = '';
			$receiver_id = '';
			$msg_status ='';
			$message_id = '';

			if($this->input->post('message'))
			{
				$message = $this->input->post('message');
			}
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
					$data = $this->common_front_model->get_user_data('register',$user_id,'plan_status,plan_expired_on,username,matri_id','id');
					
					$count_msg = $this->common_front_model->get_plan_detail($data['matri_id'],'chat','Yes');
					$current_data = $this->common_model->getCurrentDate('Y-m-d');
					if($count_msg=='No' && (isset($data['plan_status']) && $data['plan_status']=='Not-Paid'))
					{
						$msg_status = 'draft';
						$error_message = "You are not a paid member, please make payment to  chat with other members.";
					}
					else if($count_msg=='No' && (isset($data['plan_status']) && $data['plan_status']=='Paid'))
					{
						$msg_status = 'draft';
						$error_message = "Your current membership does not allow to initialize the chat. Upgrade to membership to chat with this member.";
					}
				}
				$retuen_resp_succ = true;
				if($message_id !='')
				{
					$this->common_model->data_delete_common('frei_chat',array('id'=>$message_id),1,'Yes');
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
						if($msg_status=='sent'){
							$msg_succ_sent_arr[] = $receiver_id_val;
							$data_to = $this->common_front_model->get_user_data('register',$receiver_id_val,'username','id');
							$data_array_custom = array(
								'from'=>$user_id,
								'to'=>$receiver_id_val,
								'from_name'=>$data['username'],
								'to_name'=>$data_to['username'],
								'message'=>$message,
								'recd'=>'1',
								'time'=>time(),
								'GMT_time'=>time(),
								'message_type'=>'0',
								'sent'=>$sent_on
							);
							$retuen_resp = $this->common_front_model->save_update_data('frei_chat',$data_array_custom);
								$last_message_id = $this->db->insert_id();
							
							if($retuen_resp && $msg_status == 'sent')
							{
								$this->send_message_mail($data_array_custom);
							}
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
										$data_array_custom['photo_url'] = $this->common_model->member_photo_disp($opposite_user_data);
									}
								}
							}
							$Message_data = $this->common_front_model->get_user_data('register',$receiver_id_val,'id,ios_device_id,android_device_id','id');
							$sender_user_id = $this->common_front_model->get_user_id('id','id');
							if(isset($sender_user_id) && $sender_user_id==''){
							    $ss_data = $this->common_front_model->get_user_data('register',$user_id,'id','id');
							    $sender_user_id = $ss_data['id'];
							}
							if(isset($Message_data) && $Message_data!='' && count($Message_data)>0){
								foreach ($Message_data as $key => $value) {
									if(isset($value) && $value!='' && isset($key) && $key!=''){
										$M_message = $data['matri_id'].' : '.$message;
										if($key=='ios_device_id' || $key=='android_device_id'){
											//app push notification
											if($key == 'ios_device_id'){
												$app_type = 'IOS';
	 										}
	 										else{
	 											$app_type = 'Android';
	 										}
											$sender_receiver = array('sender'=>$sender_user_id,'receiver'=>$Message_data['id'],'app_type'=>$app_type);
											## New Code After Changes In App Side: Date : 06-08-2021
											$value_arr = array('device_id' => $value,'device_type' => $key);
											$this->common_model->new_send_notification_android($value_arr,$M_message,'Chat','chat',$user_id,$sender_receiver,'',$data_array_custom);
											// $this->common_model->new_send_notification_android($value,$M_message,'Chat','chat',$user_id,$sender_receiver,'',$data_array_custom);
										}
									}
								}
							}
						}
						
						if(isset($msg_block_sent_arr) && count($msg_block_sent_arr) > 0){
							$imp_block_mat = implode(', ',$msg_block_sent_arr);
							$error_message = $error_message." Message not Sent to Matri ID $imp_block_mat because of this member has blocked you.";
						}
					}
					else{
						$error_message = "Message Saved Successfully in draft";
					}
					if(isset($msg_succ_sent_arr) && count($msg_succ_sent_arr) > 0){
						$status ='success';
					}
					else{
						$status ='error';
					}
				}
				else{
					if($error_message ==''){
						$error_message = "Message Not Sent, Please try again";
					}
				}
			}
			else{
				$error_message = "Please enter message and provide Receiver ID";
			}
		}
		else{
			$error_message = "Your session time out, Please Login First";
		}
		$data = $this->common_front_model->return_jsone_response($status,'',$error_message,'error_message');
		return $data;
	}
	function massages_list_api($page = 1)
	{
		$this->load->library('form_validation');
		$response["status"] = "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		$response["total_count"] = 0;
		$response["continue_request"] = false;
		$response["data"] = array();
		$this->form_validation->set_rules('member_id','Matri id','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('member_id');			
			$limit = 10;
			if(isset($_REQUEST["page_number"]) && $_REQUEST["page_number"]!='')
			{
				$page = $_REQUEST["page_number"];
			}
			$where_arr = " ((`to`='".$matri_id."' ) or ( `from`='".$matri_id."')) and `to` != '' and from != '' and message_type='0'";
			
			$this->db->group_by('otherID');
			$message_cnt 	= $this->common_model->get_count_data_manual("frei_chat",$where_arr,0,"id, IF(`to`=".$matri_id.", `from`,`to`) AS `otherID`,  `sent` ",'id DESC','','','','');
			//echo $this->db->last_query();exit;
			$this->db->group_by('otherID');
			$data = $this->common_model->get_count_data_manual("frei_chat",$where_arr,2,"id, IF(`to`=".$matri_id.", `from`,`to`) AS `otherID`,`message`, `sent` ",'id DESC',$page,$limit,'','','','');
			
			if(isset($message_cnt) && $message_cnt!='')
			{
				$response["total_count"] = $message_cnt;
			}
			$j=$i=0;
			
			if(isset($data) && $data!='' && is_array($data) && count($data)>0)
			{
				$data_current = array();
				$parampass = array('photo1' =>'assets/photos/');
				
				foreach($data as $data_list)
				{
					$where_user_is_valid = array('id'=>$data[$i]['otherID']);
					$data_is_deleted = $this->common_model->get_count_data_manual("register",$where_user_is_valid,0);

					$i++;
					$j++;
					if($data_is_deleted<=0) 
					{
						$j--;
						continue;
					}

					$otherID = $data_list['otherID'];
					$data_list['unread_count'] = 0;
					if($otherID !='')
					{
						// for unread count
						$where_arr_temp = " (( `from`='".$otherID."' and `to`='".$matri_id."') or (`to`='".$otherID."' and `from`='".$matri_id."')) and message_type = '0' ";
						$last_message_content = $this->common_model->get_count_data_manual("frei_chat",$where_arr_temp,1,'message,sent,id','id DESC','','','','','');
						
						if(isset($last_message_content['message']) && $last_message_content['message'] !='')
						{
							$data_list['content'] = $last_message_content['message'];
						}
						
						//ADD THIS 14-03-2019 (START)
						if(isset($last_message_content['sent']) && $last_message_content['sent'] !='')
						{
							$data_list['sent'] = $last_message_content['sent'];
						}
						if(isset($last_message_content['id']) && $last_message_content['id'] !='')
						{
							$data_list['id'] = $last_message_content['id'];
						}
						//END

						$where_arr_msg_count = " (( `to` =".$matri_id." ) or ( `from`=".$otherID.") and `read_status` = 'No' ) and `message_type` = '0'";
						$data_list['unread_count'] = count($this->common_model->get_count_data_manual("frei_chat",$where_arr_msg_count,2,'','','','',''));
						$data_list['photo_url'] = '';
						$data_list['birthdate'] = '';
						$data_list['height'] = '';
						// for photo and user detail
						$where_photoarr_1 = array('id'=>$otherID);
						$opposite_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, username, gender, birthdate, height ");
						if(isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0)
						{
							$data_list['photo_url'] = $this->common_model->member_photo_disp($opposite_user_data);
							$data_list['matri_id'] = $opposite_user_data['matri_id'];
							$data_list['username'] = $opposite_user_data['username'];
						}
					}
					
				
					$data_current[] = $data_list;
				}
				
				$response["total_count"]=$j;
				$data = $data_current;

				//for sorting array by id
				//add on 14-03-2019 start 
				foreach ($data as $key => $row)
				{
					$vc_array_name[$key] = $row['id'];
				}
				array_multisort($vc_array_name, SORT_DESC, $data);
				//end
				$response["data"] = $data;
				
				$response["statuscode"] = 200;
				$response["status"] = "success";
				$response["message"] = 'All conversation list';
				$response["errmessage"] = 'All conversation list';

				$response["continue_request"] = true;
			}
			else
			{
				$response["message"] = 'No conversation list availabel';
				$response["errmessage"] = 'No conversation list availabel';
			}			
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));

	}
	
	function conversation_list_api($page = 1)
	{
		$this->load->library('form_validation');
		$response["status"] 	= "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		$response["total_count"] = 0;

		//$response["continue_request"] = false;
		$response["current_user_data"] = array();
		$response["opposite_user_data"] = array();
		
		$response["data"] 		= $data = array();
		$this->form_validation->set_rules('member_id','Member ID','required');
		$this->form_validation->set_rules('other_id','Other User ID','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('member_id');
			$other_id=$this->input->post('other_id');
			$where_arr=(" ((`to`='".$matri_id."' and `from`='".$other_id."') or ( `to`='".$other_id."' and `from`='".$matri_id."')) and message_type = '0' ");
			
			
			$data = $this->common_model->get_count_data_manual("frei_chat",$where_arr,2,"*","id asc",'','','','','','');
			$message_cnt = $this->common_model->get_count_data_manual("frei_chat",$where_arr,0,"*","id asc",'','','','','','');
			
			if(isset($message_cnt) && $message_cnt > 0)
			{
				$response["total_count"] = $message_cnt;
			}
			
			//current user data
			$current_user_photo = '';
			$opposite_user_photo = '';
			
			$where_photoarr_1 = array('id'=>$matri_id);
			$current_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender, logged_in  ");
			if(isset($current_user_data) && $current_user_data !='' && is_array($current_user_data) && count($current_user_data) > 0)
			{				
				if(isset($current_user_data['photo1']) && $current_user_data['photo1'] !='' && file_exists($this->common_model->path_photos.$current_user_data['photo1']))
				{
					$current_user_photo = base_url().$this->common_model->path_photos.$current_user_data['photo1'];
				}
				else
				{
					if(isset($current_user_data['gender']) && $current_user_data['gender'] =='Male')
					{
						$current_user_photo = base_url().'assets/front_end/images/icon/border-male.gif';
					}
					else
					{
						$current_user_photo = base_url().'assets/front_end/images/icon/border-female.gif';
					}
				}
				$current_user_data['photo_url'] = $current_user_photo;
				$response["current_user_data"] = $current_user_data;
			}
			
			$where_photoarr_1 = array('id'=>$other_id);
			$opposite_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender, logged_in ");
			if(isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0)
			{
				$opposite_user_photo = $this->common_model->member_photo_disp($opposite_user_data);
				$opposite_user_data['photo_url'] = $opposite_user_photo;
				$response["opposite_user_data"] = $opposite_user_data;
			}
			else
			{
				$response["opposite_user_data"] =(object)[];
			}
			if((isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0) && (isset($current_user_data) && $current_user_data !='' && is_array($current_user_data) && count($current_user_data) > 0))
			{
				$response["status"] = "success";
				$response["statuscode"] = 200;
			}
			if(isset($data) && $data!='' && is_array($data) && count($data) > 0 )
			{
				$data_current = array();
				foreach($data as $data_val)
				{
					if($matri_id == $data_val['from'])
					{
						$data_val['is_sent_receive'] = 'sent';
						$data_val['photo_url'] = $current_user_photo;
					}
					else
					{							
						$data_val['is_sent_receive'] = 'receive';
						$data_val['photo_url'] = $opposite_user_photo;
					}
					$data_current[] = $data_val;
				}
				$data = $data_current;
				//print_r($data);exit;
				$response["data"] = $data;
				$response["statuscode"] = 200;
				$response["status"] = "success";
				$response["message"] = 'All conversation list';
				$response["errmessage"] = 'All conversation list';
				//$response['continue_request'] = true;
				
				$where_arr_msg_count = " ( `to`='".$matri_id."' and `from`='".$other_id."' and read_status = 'No' ) and message_type = '0' ";
				$data_array2 = array('read_status' => 'Yes');
				$this->common_model->update_insert_data_common('frei_chat', $data_array2,$where_arr_msg_count,1);
			}			
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));
	}
	
	function delete_user_message_list_api()
	{
		$this->load->library('form_validation');
		$response["status"] 	= "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		
		$this->form_validation->set_rules('matri_id','Matri ID','required');
		$this->form_validation->set_rules('other_id','Other User Matri ID','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('matri_id');
			$other_id=$this->input->post('other_id');
			
			// for set status for receive message
			
			$where_arr_msg_count = " ( receiver='".$matri_id."' and sender='".$other_id."' and trash_receiver ='No' ) and status = 'sent' ";
			$data_array2 = array('trash_receiver' => 'Yes');
			$this->common_model->update_insert_data_common('app_chat', $data_array2,$where_arr_msg_count,1);
			
			$where_arr_msg_count = " ( sender='".$matri_id."' and receiver='".$other_id."' and trash_sender ='No' ) and status = 'sent' ";
			$data_array2 = array('trash_sender' => 'Yes');
			$this->common_model->update_insert_data_common('app_chat', $data_array2,$where_arr_msg_count,1);
				
			
			$response["status"] = "success";
			$response["statuscode"] = 200;
			$response["message"] = 'Message deleted successfully.';
			$response["errmessage"] = 'Message deleted successfully.';
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));
	}

	public function send_message_mail($data_array_custom='')
	{ 
		if($data_array_custom !='' && count($data_array_custom) > 0)
		{
			if(isset($data_array_custom['sender']) && $data_array_custom['sender'] !='')
			{
				$sender = $data_array_custom['sender'];
				$receiver = $data_array_custom['receiver'];
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
					$rec_detail = $this->common_model->get_count_data_manual('register',array('matri_id'=>$receiver),1,'email, username, mobile');
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
					}
				}
			}
		}
	}
}