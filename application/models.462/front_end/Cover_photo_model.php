<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Modify_photo_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}
	public function get_member_photo()
	{
		$register_data = '';
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id,'is_deleted'=>'No');
			$register_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'matri_id,gender,photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,photo1_approve,photo2_approve,photo3_approve,photo4_approve,photo5_approve,photo6_approve,photo7_approve,photo8_approve,cover_photo,photo_view_status,cover_photo,cover_photo');
		}
		return $register_data;
	}
	public function set_profile_pic()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['photo_number']) && $_REQUEST['photo_number'] !='' && isset($_REQUEST['set_profile']) && $_REQUEST['set_profile'] =='set_profile')
		{
			$photo_number = $_REQUEST['photo_number'];
			$member_id = $this->common_front_model->get_user_id();
			if($member_id !='')
			{
				$where_arra = array('id'=>$member_id);
				$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,cover_photo,photo1_approve,photo2_approve,photo3_approve, photo4_approve, photo5_approve,photo6_approve,photo7_approve,photo8_approve, photo1_uploaded_on, photo2_uploaded_on, photo3_uploaded_on, photo4_uploaded_on,photo5_uploaded_on,photo6_uploaded_on,photo7_uploaded_on,photo8_uploaded_on');
				$data_array = array(
					'photo1'=>$row_data['photo'.$photo_number],
					'photo1_approve'=>$row_data['photo'.$photo_number.'_approve'],
					'photo1_uploaded_on'=>$row_data['photo'.$photo_number.'_uploaded_on'],
					'photo'.$photo_number=>$row_data['photo1'],
					'photo'.$photo_number.'_approve'=>$row_data['photo1_approve'],
					'photo'.$photo_number.'_uploaded_on'=>$row_data['photo1_uploaded_on'],
				);
				$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
				if($response)
				{
					$data1['status'] = 'success';
					$data1['errmessage'] = "Your Profile Pic Set Successfully.";
				}
			}
			else
			{
				$data1['errmessage'] = "Your session has been time out, please login again.";
			}
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function update_photo_view_status()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['photo_status']) && $_REQUEST['photo_status'] !='')
		{
			$photo_status = $_REQUEST['photo_status'];
			$member_id = $this->common_front_model->get_user_id();
			if($member_id !='' && $photo_status !='')
			{
				$where_arra = array('id'=>$member_id);
				$data_array = array('photo_view_status'=>$photo_status);
				$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
				if($response)
				{
					$data1['status'] = 'success';
					$data1['errmessage'] = "Your Photo status Updated Successfully.";
				}
			}
			else
			{
				$data1['errmessage'] = "Your session has been time out, please login again.";
			}
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function delete_photo()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['photo_number']) && $_REQUEST['photo_number'] !='' && isset($_REQUEST['delete_photo']) && $_REQUEST['delete_photo'] =='delete')
		{
			$photo_number = $_REQUEST['photo_number'];
			$member_id = $this->common_front_model->get_user_id();
			if($member_id !='')
			{
				$number = 'photo'.$photo_number;
				$where_arra = array('id'=>$member_id);
				$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,cover_photo');
				$delete_photos_file = $this->common_model->path_photos.$row_data[''.$number.''];
				$delete_photos_big_file = $this->common_model->path_photos_big.$row_data[''.$number.''];
				$data_array = array($number=>'');
				$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
				if($response)
				{
					if($delete_photos_file !='')
					{
						$this->common_front_model->delete_file($delete_photos_file);
					}
					if($delete_photos_big_file !='')
					{
						$this->common_front_model->delete_file($delete_photos_big_file);
					}
					$data1['status'] = 'success';
					$data1['errmessage'] = "Your Photo Deleted Successfully.";
				}
			}
			else
			{
				$data1['errmessage'] = "Your session has been time out, please login again.";
			}
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function upload_photo_crope()
	{
		$photo_number = 1;
		if(isset($_REQUEST['photo_number']) && $_REQUEST['photo_number'] !='')
		{
			$photo_number = $_REQUEST['photo_number'];
		}
		if(isset($_REQUEST['profile_photo_crop']) && $_REQUEST['profile_photo_crop'] !='')
		{			
			$_REQUEST['profile_photo'.$photo_number.'_crop'] = $_REQUEST['profile_photo_crop'];
		}
		if(isset($_REQUEST['profile_photo_org']) && $_REQUEST['profile_photo_org'] !='')
		{			
			$_REQUEST['profile_photo'.$photo_number.'_org'] = $_REQUEST['profile_photo_org'];
		}
		$photo_upload_count = $this->common_model->photo_upload_count;
		if($photo_upload_count ==0 || $photo_upload_count == '' || $photo_upload_count <0 || $photo_upload_count > 8)
		{
			$photo_upload_count = 8;
		}
		$member_id = $this->common_front_model->get_user_id();
		$number='';
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);  
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,cover_photo');
			
			for($ij=1;$ij<=$photo_upload_count;$ij++)
			{	
				$photo_name = 'profile_photo'.$ij.'_crop';
				$photo_name_big = 'profile_photo'.$ij.'_org';
				
				if(isset($_REQUEST[$photo_name]) && $_REQUEST[$photo_name] !='')
				{
					$upload_photo_name = time().'-'.$member_id.'-'.$ij.'.jpg';
					$this->common_model->base_64_photo($photo_name,'path_photos',$upload_photo_name);
					if(isset($_REQUEST[$photo_name_big]) && $_REQUEST[$photo_name_big] !='')
					{
						$this->common_model->base_64_photo($photo_name_big,'path_photos_big', $upload_photo_name);
					}
					$_REQUEST['photo'.$ij] = $upload_photo_name;
					$_REQUEST['photo'.$ij.'_approve'] = 'UNAPPROVED';
					$_REQUEST['photo'.$ij.'_uploaded_on'] = $this->common_model->getCurrentDate();
					$number = 'photo'.$ij;
				}
			}
			$cover_photo_name = 'cover_photo';
			if(isset($_REQUEST[$cover_photo_name]) && $_REQUEST[$cover_photo_name]!='')
			{
				$number = 'cover_photo';
				$upload_cover_photo_name = time().'-'.$member_id.'.jpg';
				$this->common_model->base_64_photo($cover_photo_name,'path_cover_photo',$upload_cover_photo_name);
				$_REQUEST['cover_photo'] = $upload_cover_photo_name;
				$_REQUEST['cover_photo_approve'] = 'UNAPPROVED';
				$_REQUEST['cover_photo_uploaded_on'] = $this->common_model->getCurrentDate();
			}

			if(isset($number) && $number!='')
			{
				$this->common_model->set_table_name('register');
				$_REQUEST['mode'] ='edit';
				$member_id = $this->common_front_model->get_user_id();
				$_REQUEST['id'] = $member_id;
				$response = $this->common_model->save_update_data(1,1);
				$data1 = json_decode($response, true);
				
				if($number=='cover_photo')
				{
					$delete_cover_photo_file = $this->common_model->path_cover_photo.$row_data[''.$number.''];
				}
				else
				{
					$delete_photos_file = $this->common_model->path_photos.$row_data[''.$number.''];
					$delete_photos_big_file = $this->common_model->path_photos_big.$row_data[''.$number.''];
				}
				
				if(isset($data1['status']) && $data1['status'] =='success')
				{
					if(isset($delete_photos_file) && $delete_photos_file!='')
					{
						$this->common_front_model->delete_file($delete_photos_file);
					}
					if(isset($delete_photos_big_file) && $delete_photos_big_file!='')
					{
						$this->common_front_model->delete_file($delete_photos_big_file);
					}
					if(isset($delete_cover_photo_file) && $delete_cover_photo_file!='')
					{
						$this->common_front_model->delete_file($delete_cover_photo_file);
					}
					$data1['errmessage'] =  "Your profile photo has been updated successfully."; // for app return message 
				}
				if(isset($data1['response']))
				{
					unset($data1['response']);
				}
			}
			/*else
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] = "Please select image for update.";
			}*/
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
}
?>