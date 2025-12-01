<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Privacy_model extends CI_Model {
	public function __construct()
	{
		
		
		parent::__construct();
	}
	public function block_profile()
	{
		$member_id = $this->common_front_model->get_session_data('matri_id');
		$block_by= $member_id;
		$block_date = date('Y-m-d H:i:s');
		$gender = $this->common_front_model->get_session_data('gender');
		$return_message = "";
		$status = 'error';
		if(isset($_POST['blockuserid']) && $_POST['blockuserid']!='' && $member_id!='')
		{
			$block_to = strtoupper($this->input->post('blockuserid'));
			$where_arra=array('status'=>'APPROVED','matri_id'=>$block_to,"gender !='$gender'");
			$data =$this->common_model->get_count_data_manual('register',$where_arra,0);
			if($data==0)
			{
				$return_message = "Please Enter Valid Matri Id.";
			}
			else
			{
				$where_arra=array('block_to'=>$block_to,'block_by'=>$block_by);
				$data =$this->common_model->get_count_data_manual('block_profile',$where_arra,0);
				if($data> 0)
				{
					$return_message = "You are already blocked this member.";
				}
				else
				{		
					 $data_array = array(
									'block_by'=>$block_by,
									'block_to'=>$block_to,
									'created_on'=>$block_date);
					   $response = $this->common_front_model->save_update_data('block_profile',$data_array);
					   $return_message = "Your request for member blocking is successfully done.";
					   $status = "success";
				}
			}
			$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
			return ($return_arr);
		}
	}
	public function photo_visibility()
	{
		$member_id = $this->common_front_model->get_session_data('matri_id');
		$where_arra = array('matri_id'=>$member_id);
		if(isset($_POST['photo_password']) && $_POST['photo_password']!='')
		{
			$password = trim($_POST['photo_password']);
			$data_array = array('photo_password'=>$password,'photo_protect'=>'Yes');
			$return = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
			$success_message = "Your photo protect password set successfully.";
		}
		else if(isset($_POST['photo_view_status']) && $_POST['photo_view_status']!='')
		{
			$photo_view_status = trim($_POST['photo_view_status']);
			$data_array = array('photo_view_status'=>$photo_view_status);
			$return = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
			$success_message = "Your photo view preference is edited Successfully.";
		}
		else 
		{
			$data_array = array('photo_password'=>'','photo_protect'=>'No');
			$return = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
			$success_message = "Your photo protect password successfully removed.";
		}	
		if($return == true)
		{
			if(isset($success_message) && $success_message !='')
			{
				$this->session->set_flashdata('success_message',$success_message);
			}
		}
		$data1['status'] = 'success';
		$data1['token'] = $this->security->get_csrf_hash();
		$login_member_id = $this->common_front_model->get_session_data('matri_id');
	  	$where_arra=array('matri_id'=>$login_member_id);
	  	$this_photo['user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'*');
		$this_photo['base_url'] = base_url();
		$data1['photo_setting_load'] = $this->load->view('front_end/photo_setting',$this_photo,true); 
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function contact_privacy_setting()
	{
		$member_id = $this->common_front_model->get_session_data('matri_id');
		$where_arra = array('matri_id'=>$member_id);
		if(isset($_POST['contact_view_security']) && $_POST['contact_view_security']!='')
		{
			$contact_view_security = trim($_POST['contact_view_security']);
			$data_array = array('contact_view_security'=>$contact_view_security);
			$return = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
			$success_message = "Your contact setting is edited Successfully.";
		
			if($return == true)
			{
				if(isset($success_message) && $success_message !='')
				{
					$this->session->set_flashdata('success_message_contact',$success_message);
				}
			}
			else
			{
					$this->session->set_userdata('error_message_contact','Sorry Some error occurred, Please try again');
			}
		
		$data1['status'] = 'success';
		$data1['token'] = $this->security->get_csrf_hash();
		$login_member_id = $this->common_front_model->get_session_data('matri_id');
	  	$where_arra=array('matri_id'=>$login_member_id);
	  	$this_contact['user_data'] = $this->common_model->get_count_data_manual('register',$where_arra,1,'*');
		$this_contact['base_url'] = base_url();
		$data1['contact_setting_load'] = $this->load->view('front_end/contact_privacy_setting',$this_contact,true); 
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
		}
	}
	public function change_password()
	{
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'*');
			
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				$member_pass = $row_data['password'];
				$member_id = $row_data['id'];
				$old_pass = trim(md5($_POST['old_pass']));
				$new_pass = trim(md5($_POST['new_pass']));
				$cnfm_pass = trim(md5($_POST['cnfm_pass']));
				$return_message = "";
				$status = 'error';
				
				if($member_pass==$old_pass)
				{
					if($old_pass!=$new_pass)
					{
						if($new_pass==$cnfm_pass)
						{	
							$where_arra=array('id'=>$member_id,'password'=>$member_pass);
							$data_array = array('password'=>$new_pass);
							$response = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
							$return_message = "Congratulations ! Your password for this account has been updated successfully.";							$status = 'success';
						}
						else
						{
							 $return_message = "The Confirm Password field does not match the New Password field.";
						}
					}
					else
					{
					   $return_message = "Old password and new password are match.Please try another new password.";
					}
				}
				else
				{
				   $return_message = "Old password Provided is not correct.";
				}
				$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
				return ($return_arr);
			}
	 	}
		else
		{
			$return_message = "Your session hase been time out, please login again.";
			$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
			return ($return_arr);
		}
				
	}
}