<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Message_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'message';
	}
	function get_message_list($post=0,$page='')
	{
		$mode_exp = '';
		if($this->input->post('mode') !='')
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
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No','message.status'=>'sent');
			//$this->db->join('search_register_view','message.receiver = search_register_view.matri_id ','left');
		}
		else if($mode_exp =='draft')
		{
			$where_arra=array('message.sender'=>$member_id,'message.trash_sender'=>'No','message.status'=>'draft');
			//$this->db->join('search_register_view','message.receiver = search_register_view.matri_id ','left');
		}

		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,0,'');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual($this->table_name,$where_arra,2,'message.*','message.id desc',$page);
		}
		return $data;
	}
	function send_message()
	{
		$status = 'error';
		$message = 'errmessage';
		$user_id = $this->common_front_model->get_user_id('matri_id');
		if($user_id !='')
		{
			$message = '';
			$receiver_id = '';
			if($this->input->post('message'))
			{
				$message = $this->input->post('message');
			}
			if($this->input->post('receiver_id'))
			{
				$receiver_id = $this->input->post('receiver_id');
			}
			if($message !='' && $receiver_id !='')
			{
				$draft_id = '';
				if($this->input->post('draft_id'))
				{
					$draft_id = $this->input->post('draft_id');
				}
				$sent_on = $this->common_model->getCurrentDate();
				$data_array_custom = array(
					'sender'=>$user_id,
					'receiver'=>$receiver_id,
					'content'=>$message,
					'status'=>'sent',
					'sent_on'=>$sent_on
				);
				if($draft_id !='')
				{
					$retuen_resp = $this->common_front_model->save_update_data('message',$data_array_custom,'id','edit',$draft_id);
				}
				else
				{
					$retuen_resp = $this->common_front_model->save_update_data('message',$data_array_custom);
				}
				if($retuen_resp)
				{
					$error_message = "Message Sent Successfully";
					$status ='success';
				}
				else
				{
					$error_message = "Message Not Sent, Please try again";
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
	function msg_for_android()
	{
		$message_type = 'inbox';
		$search_message = '';
		$page_number = 1;
		$limit_page = 10;
		$message_data = '';
		if($this->input->post('message_type'))
		{
			$message_type = $this->input->post('message_type');
		}
		if($this->input->post('page_number'))
		{
			$page_number = $this->input->post('page_number');
		}
		if($this->input->post('search_message'))
		{
			$search_message = $this->input->post('search_message');
		}
		if($message_type == 'inbox')
		{
			$message_data = $this->message_model->getInbox(2,1,$page_number,$limit_page);
		}
		else if($message_type == 'sent')
		{
			$message_data = $this->message_model->getSent(2,'sent','1',$page_number,$limit_page);
		}
		else if($message_type == 'draft')
		{
			$message_data = $this->message_model->getSent(2,'draft','1',$page_number,$limit_page);
		}
		return $message_data;
	}
	public function getSent($data_type ='0',$status='sent',$search=0,$page_num = '',$limit_p ='')
	{
		$message ='';
		if($this->user_type !='' && $this->user_id !='')
		{
			if($this->user_type =='employer')
			{
				$this->db->join('jobseeker as u','u.id = m.receiver', 'left');
			}
			else
			{
				$this->db->join('employer_master as u','u.id = m.receiver', 'left');
			}
			$search_where = array('m.trash_sender'=>'No',"m.sender_type"=>$this->user_type,'m.sender'=>$this->user_id,'m.status'=>$status);
			if($search ==1)
			{
				if($this->input->post('search_message'))
				{
					$search_message = $this->input->post('search_message');
					if($search_message !='')
					{
						$search_where[] = " ( u.fullname like '%$search_message%' or u.email like '%$search_message%'  or m.subject like '%$search_message%'  or m.content like '%$search_message%' )";
					}
				}
				
			}
			$message = $this->common_front_model->get_count_data_manual('message as m',$search_where,$data_type,' m.*, u.fullname, u.email,u.id as user_id ',' sent_on desc ',$page_num,$limit_p,0);
			//echo $this->common_front_model->last_query();
		}
		return $message;
	}
	public function getInbox($data_type ='0',$search=0,$page_num = '',$limit_p ='')
	{
		$message ='';
		if($this->user_type !='' && $this->user_id !='')
		{
			if($this->user_type =='employer')
			{
				$this->db->join('jobseeker as u','u.id = m.sender', ' inner join ');
			}
			else
			{
				$this->db->join('employer_master as u','u.id = m.sender', ' inner join ');
			}
			$search_where = array('m.trash_receiver'=>'No',"m.sender_type != '$this->user_type'",'m.receiver'=>$this->user_id,'m.status'=>'sent');
			if($search ==1)
			{
				if($this->input->post('search_message'))
				{
					$search_message = $this->input->post('search_message');
					if($search_message !='')
					{
						$search_where[] = " ( u.fullname like '%$search_message%' or u.email like '%$search_message%'  or m.subject like '%$search_message%'  or m.content like '%$search_message%' )";
					}
				}
				
			}
			$message = $this->common_front_model->get_count_data_manual('message as m',$search_where,$data_type,' m.*, u.fullname, u.email,u.id as user_id ',' sent_on desc ',$page_num,$limit_p,0);
			//echo $this->common_front_model->last_query();
		}
		return $message;
	}
	public function job_send_message()
	{
		$sender = $this->user_id;
		$receiver = '';
		if($this->input->post('to_message'))
		{
			$receiver = $this->input->post('to_message');
		}
		$message_action = $this->input->post('message_action');
		$draft_id = $this->input->post('draft_id');
		$sent_on = $this->common_front_model->getCurrentDate();
		$status_sent = 'sent';
		$plan_status_msg = 'No';
		if($message_action == 'draft')
		{
			$status_sent = 'draft';
			$plan_status_msg = 'Yes';
		}
		else
		{
			$return_data_plan = $this->common_front_model->get_plan_detail($sender,$this->user_type,'message');
			if($return_data_plan =='Yes' || $return_data_plan =='No')
			{
				$plan_status_msg = $return_data_plan;
			}
		}
		$data_array_custom = array('sender'=>$sender,'receiver'=>$receiver,'sent_on'=>$sent_on,'status'=>$status_sent,'sender_type'=>$this->user_type);
		
		if($plan_status_msg == 'Yes')
		{
			if($draft_id !='')
			{
				$retuen_resp = $this->common_front_model->save_update_data('message',$data_array_custom,'id','edit',$draft_id);
			}
			else
			{
				$retuen_resp = $this->common_front_model->save_update_data('message',$data_array_custom);
			}
			if($retuen_resp !='success')
			{
				return 'Sorry, Some error occured please try again.';
			}
			else if($message_action != 'draft')
			{
				$this->common_front_model->update_plan_detail($sender,$this->user_type,'message');
				//echo $this->common_model->last_query();
				if($this->user_type =='job_seeker')
				{
					$get_email = $this->common_front_model->getemailtemplate('Send message to employer');
					$login_user_details = $this->common_front_model->get_login_user_data($sender,'fullname');
					$get_emp_email = $this->common_front_model->get_user_data('employer_master',$receiver,'email');
				}
				else
				{
					$get_email = $this->common_front_model->getemailtemplate('Send message to jobseeker');
					$login_user_details = $this->common_front_model->get_user_data('employer_master',$sender,'fullname');
					$get_emp_email = $this->common_front_model->get_user_data('jobseeker',$receiver,'email');
				}
				if(isset($get_emp_email['email']) && $get_emp_email['email'] !='')
				{
					$email = $get_emp_email['email']; // Employer email (for sending mail)
				}
				if($get_email!='' && count($get_email) > 0 )
				{
				   $config_data = $this->common_front_model->data['config_data'];
				   $webfriendlyname = $config_data['web_frienly_name'];
				   $subject = $get_email['email_subject']; 
				   $email_content= $get_email['email_content'];
				   $email_template = htmlspecialchars_decode($email_content,ENT_QUOTES); 
				   $trans = array("websitename" =>$webfriendlyname,"sender_name"=>$login_user_details['fullname']);
				   $email_template = $this->common_front_model->getstringreplaced($email_template, $trans);	
				   $this->common_front_model->common_send_email($email,$subject,$email_template);
				}
			}
			return 'success';
		}
		else
		{
			return 'Sorry, You have no credit balance or your plan hase been expired to send message.';
		}
	}
	function get_userdata($get_id,$depend_on)
	{
		$where = array('id'=>$get_id);
		if($depend_on=='Job')
		{
			$get_emp_email = $this->common_front_model->get_count_data_manual("job_posting",$where,1,'email','','',1);
		}
		else
		{
			$get_emp_email = $this->common_front_model->get_count_data_manual("employer_master",$where,1,'email','','',1);
		}
		return $get_emp_email;
	}
	function delete_message($message_id ='')
	{
		if($message_id =='')
		{
			$message_id = $this->input->post('message_id');
		}
		if(isset($message_id) && $message_id !='' && count($message_id) > 0)
		{
			$delete_column = 'trash_sender';
			$message_type = 'inbox';
			$where_arra = array('sender_type'=>$this->user_type);
			if($this->input->post('message_type'))
			{
				$message_type = $this->input->post('message_type');
			}
			if($message_type =='inbox')
			{
				$delete_column = 'trash_receiver';
				$where_arra = array("sender_type != $this->user_type");
			}
			
			$data_array = array($delete_column=>'Yes');
			$this->db->where_in('id',$message_id);
			$this->common_front_model->update_insert_data_common('message',$data_array,$where_arra,1,0);
			$this->session->set_userdata('delete_message', 'Message deleted successfully.');
		}
	}
	function message_readstatus()
	{
		$message_id = $this->input->post('message_id');
		if($message_id !='')
		{
			$where_arra = array('id'=>$message_id);
			$data_array = array('read_status'=>'Read');
			$this->common_front_model->update_insert_data_common('message',$data_array,$where_arra,1,1);
		}
	}
	public function get_jobseeker_list()
	{
		$where_arra = array('status'=>'APPROVED','is_deleted'=>'No');
		if($this->input->post('q'))
		{
			$search = $this->input->post('q');
			if($search !='')
			{
				$where_arra[] = " (email like '%$search%' or fullname like '%$search%') ";
			}
		}
		$data_arr = $this->common_front_model->get_count_data_manual('jobseeker',$where_arra,2,'fullname,id,email','','','',"");
		$opt_array = array();
		if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
		{
			foreach($data_arr as $data_arr_val)
			{
				$forpushingarray = array("id"=>$data_arr_val['id'],"text"=>$data_arr_val['fullname'].'('.$data_arr_val['email'].')');
				$opt_array[] = $forpushingarray;
				//array_push($opt_array['results'],$forpushingarray);
			}
		}
		return $opt_array;
	}
	public function get_employer_list()
	{
		$search = $this->input->post('q');
		$where_arra = array('status'=>'APPROVED','is_deleted'=>'No'," (email like '%$search%' or fullname like '%$search%' or company_name like '%$search%') ");
		$data_arr = $this->common_front_model->get_count_data_manual('employer_master',$where_arra,2,'fullname,id,company_name','','','',"");
		$opt_array = array();
		if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
		{
			foreach($data_arr as $data_arr_val)
			{
				$forpushingarray = array("id"=>$data_arr_val['id'],"text"=>$data_arr_val['fullname'].'('.$data_arr_val['company_name'].')');
				array_push($opt_array,$forpushingarray);
			}
		}
		//$opt_array['more'] = "false";
		return $opt_array;
	}
}
?>