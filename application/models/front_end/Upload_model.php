<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Upload_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}
	public function upload_horoscope()
	{
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);  
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'horoscope_photo');
			
			if(isset($_POST['horoscope_photo']) && $_POST['horoscope_photo']!='')
			{
				$horoscope_photo_name = 'horoscope_photo';
				$upload_horoscope_photo_name = time().'-hp-'.$member_id.'.jpg';
				$this->common_model->base_64_photo($horoscope_photo_name,'path_horoscope',$upload_horoscope_photo_name);
				$_REQUEST['horoscope_photo'] = $upload_horoscope_photo_name;
				$_REQUEST['horoscope_photo_approve'] = 'UNAPPROVED';
				$_REQUEST['horoscope_photo_uploaded_on'] = $this->common_model->getCurrentDate();
			
				$this->common_model->set_table_name('register');
				$_REQUEST['mode'] ='edit';
				$member_id = $this->common_front_model->get_user_id();
				$_REQUEST['id'] = $member_id;
				$response = $this->common_model->save_update_data(1,1);
				$data1 = json_decode($response, true);
				
				$delete_horoscope_photo_file = $this->common_model->path_horoscope.$row_data['horoscope_photo'];
				
				if(isset($data1['status']) && $data1['status'] =='success')
				{
					if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
					{
						if(isset($delete_horoscope_photo_file) && $delete_horoscope_photo_file!='')
						{
							$this->common_front_model->delete_file($delete_horoscope_photo_file);
						}
						$data1['errmessage'] =  "Your horoscope photo has been updated successfully."; // for app return message 
					}
					else
					{
						$data1['errmessage'] = strip_tags($data1['response']);
					}
				}
				if(isset($data1['response']))
				{
					unset($data1['response']);
				}
			}
			else
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] = "Please select horoscope image for update.";
			}
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		
		$data['data'] = json_encode($data1);
		return $data;
	}
	
	public function upload_id_proof()
	{
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);  
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id_proof');
			
			if(isset($_POST['id_proof']) && $_POST['id_proof']!='')
			{
				$id_proof_photo_name = 'id_proof';
				$upload_id_proof_photo_name = time().'-hp-'.$member_id.'.jpg';
				$this->common_model->base_64_photo($id_proof_photo_name,'path_id_proof',$upload_id_proof_photo_name);
				$_REQUEST['id_proof'] = $upload_id_proof_photo_name;
				$_REQUEST['id_proof_approve'] = 'UNAPPROVED';
				$_REQUEST['id_proof_uploaded_on'] = $this->common_model->getCurrentDate();
			
				$this->common_model->set_table_name('register');
				$_REQUEST['mode'] ='edit';
				$member_id = $this->common_front_model->get_user_id();
				$_REQUEST['id'] = $member_id;
				$response = $this->common_model->save_update_data(1,1);
				$data1 = json_decode($response, true);
				
				$delete_id_proof_photo_file = $this->common_model->path_id_proof.$row_data['id_proof'];
				
				if(isset($data1['status']) && $data1['status'] =='success')
				{
					if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
					{
						if(isset($delete_id_proof_photo_file) && $delete_id_proof_photo_file!='')
						{
							$this->common_front_model->delete_file($delete_id_proof_photo_file);
						}
						$data1['errmessage'] =  "Your id proof photo has been updated successfully."; //for app return message
					}
					else
					{
						$data1['errmessage'] = strip_tags($data1['response']);
					}
				}
				if(isset($data1['response']))
				{
					unset($data1['response']);
				}
			}
			else
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] = "Please select id proof image for update.";
			}
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		$data['data'] = json_encode($data1);
		return $data;
	}
	
	public function add_video()
	{
		$user_agent = $this->input->post("user_agent");
		if($user_agent=='NI-AAPP')
		{
			$member_id = $this->input->post("member_id");
		}
		else
		{
			$member_id = $this->common_front_model->get_user_id();
		}
		if($member_id !='')
		{
			if($this->input->post("videoUrl")!='')
			{
				$y_link = $this->input->post('videoUrl');
				$this->common_model->update_insert_data_common('register',array('video_url' =>$y_link,'video_approval' => 'UNAPPROVED'),array('id'=>$member_id));
				
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				$data1['errmessage'] = "Link saved successfully.";
								
				
				
			}
			else
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] = "Please enter valid url..!!!";
			}
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		$data['data'] = json_encode($data1);
		return $data;
	}

	public function delete_video()
	{
		$user_agent = $this->input->post("user_agent");
		if($user_agent=='NI-AAPP')
		{
			$member_id = $this->input->post("member_id");
		}
		else
		{
			$member_id = $this->common_front_model->get_user_id();
		}
		if($member_id !='')
		{
				$y_link = $this->input->post('videoUrl');
				$this->common_model->update_insert_data_common('register',array('video_url' =>'','video_approval' => 'UNAPPROVED'),array('id'=>$member_id));
				
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				$data1['errmessage'] = "Link deleted successfully.";
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		$data['data'] = json_encode($data1);
		return $data;
	}
	
	function get_video_data()
	{
		$data = '';
		$member_id = $this->common_front_model->get_session_data('id');
		if($member_id !='')
		{
			$data = $this->common_front_model->get_user_data('register_view',$member_id);
		}
		return $data;
	}	
}
?>