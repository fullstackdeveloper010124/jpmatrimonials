<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Modify_photo_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->data['base_url'] = $this->base_url;
	}
	public function get_member_photo()
	{
		$register_data = '';
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id,'is_deleted'=>'No');
			$register_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'matri_id,gender,photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,photo1_approve,photo2_approve,photo3_approve,photo4_approve,photo5_approve,photo6_approve,photo7_approve,photo8_approve,cover_photo,horoscope_photo,photo_view_status,id_proof,id_proof_approve');
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
					if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='NI-WEB')
					{
						
					}
					else
					{
						$refresh_session_data = $_SESSION['mega_user_data'];
						foreach ($refresh_session_data as $key => $value) {
							if(isset($row_data['photo'.$photo_number]) && $row_data['photo'.$photo_number] !='' && file_exists($this->common_model->path_photos.$row_data['photo'.$photo_number]))
							{
								$refresh_session_data['photo1'] = base_url().$this->common_model->path_photos.$row_data['photo'.$photo_number];
							}
							else
							{
								if(isset($refresh_session_data['gender']) && $refresh_session_data['gender'] =='Male')
								{
									$refresh_session_data['photo1'] = base_url().'assets/front_end/images/icon/border-male.gif';
								}
								else
								{
									$refresh_session_data['photo1'] = base_url().'assets/front_end/images/icon/border-female.gif';
								}
							}
						}
						$_SESSION['mega_user_data'] = $refresh_session_data;
					}
					
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
	public function delete_cover_photo()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['delete_cover_photo']) && $_REQUEST['delete_cover_photo'] =='delete')
		{
			if(isset($_REQUEST["user_agent"]) && $_REQUEST["user_agent"]!='' && $_REQUEST["user_agent"]=="NI-AAPP"){
				$member_id = isset($_REQUEST["user_id"])?$_REQUEST["user_id"]:'';
			}else{
				$member_id = $this->common_front_model->get_user_id();
			}
			if($member_id !='')
			{
				$number = 'cover_photo';
				$where_arra = array('id'=>$member_id);
				$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'cover_photo');
				if(isset($row_data) && is_array($row_data) && count($row_data)>0){
					$delete_photos_file = $this->common_model->path_cover_photo.$row_data['cover_photo'];
					$data_array = array($number=>'');
					$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
					if($response)
					{
						if(isset($delete_photos_file) && $delete_photos_file !='')
						{
							$this->common_front_model->delete_file($delete_photos_file);
						}
						$data1['status'] = 'success';
						$data1['errmessage'] = "Your Cover Photo Deleted Successfully.";
					}
				}else{
					$data1['status'] = 'error';
					$data1['errmessage'] = "Your provided user id is invalide";
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
	public function upload_photo_file()
	{
		//print_r($_FILES);
		//print_r($_REQUEST);
		$member_id = $this->common_front_model->get_user_id();
		$status = 'error';
		$errmessage = "Please try again";
		if($member_id !='')
		{
			$number='';
			
			$photo_upload_count = $this->common_model->photo_upload_count;
			if($photo_upload_count ==0 || $photo_upload_count == '' || $photo_upload_count <0 || $photo_upload_count > 8)
			{
				$photo_upload_count = 8;
			}
			$file_list_array = array('photo1','photo2','photo3','photo4','photo5','photo6','photo7','photo8','cover_photo');
			$file_list_array_str = implode(', ',$file_list_array);
			
			$where_arra = array('id'=>$member_id);
			$path_photos = $this->common_model->path_photos;
			$path_cover_photo = $this->common_model->path_cover_photo;
			$path_photos_big = $this->common_model->path_photos_big;
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,$file_list_array_str);
			$file_number = '';
			$file_delete_array = array();
			$file_name_update = '';
			for($ij = 1; $ij<=$photo_upload_count; $ij++)
			{
				if(isset($_FILES['profile_photo'.$ij.'_crop']) && $_FILES['profile_photo'.$ij.'_crop']['name'] !='')
				{
					$file_number = $ij;
					$temp_data_array = array('file_name'=>'profile_photo'.$ij.'_crop','upload_path'=>$path_photos);
					$response = $this->common_front_model->file_upload_new($temp_data_array);
					if(isset($response['status']) && $response['status'] == 'success')
					{
						$file_name_update = $response['file_name'];
						$status = 'success';
						if(isset($file_number) && $file_number == '1')
						{
							$photo1update = base_url().$path_photos.$file_name_update;
							$mega_user_data = $this->session->userdata('mega_user_data');
							$mega_user_data['photo1'] = $photo1update;
							$this->session->set_userdata('mega_user_data', $mega_user_data);
							//print_r($this->session->userdata('mega_user_data'));exit;
						}
					}
					else
					{
						if(isset($response['error_message']) && $response['error_message'] !='')
						{
							$errmessage = strip_tags($response['error_message']);
						}
						else
						{
							$errmessage = "File upload error";
						}
						$status = 'error';
					}
				}

				if($file_name_update !='' && isset($_FILES['profile_photo'.$ij.'_org']) && $_FILES['profile_photo'.$ij.'_org']['name'] !='')
				{
					$temp_data_array = array('file_name'=>'profile_photo'.$ij.'_org','upload_path'=>$path_photos_big,'file_name_upload'=>$file_name_update);
					$response = $this->common_front_model->file_upload_new($temp_data_array);
					if(isset($response['status']) && $response['status'] == 'success')
					{
						$file_name_update = $response['file_name'];
						$status = 'success';
					}
					else
					{
						if(isset($response['error_message']) && $response['error_message'] !='')
						{
							$errmessage = strip_tags($response['error_message']);
						}
						else
						{
							$errmessage = "File upload error";
						}
						$status = 'error';
					}
				}
				if($file_number !='')
				{
					break;
				}
			}
			if($file_number=='')
			{
				if(isset($_FILES['cover_photo']) && $_FILES['cover_photo']['name'] !='')
				{
					$file_number = 'cover_photo';
					$temp_data_array = array('file_name'=>'cover_photo','upload_path'=>$path_cover_photo);
					$response = $this->common_front_model->file_upload_new($temp_data_array);
					if(isset($response['status']) && $response['status'] == 'success')
					{
						$file_name_update = $response['file_name'];
						$status = 'success';
					}
					else
					{
						if(isset($response['error_message']) && $response['error_message'] !='')
						{
							$errmessage = strip_tags($response['error_message']);
						}
						else
						{
							$errmessage = "File upload error";
						}
						$status = 'error';
					}
				}
			}
			if($status == 'success' && $file_name_update !='' && $file_number !='')
			{
				$old_file_name = '';
				if($file_number == 'cover_photo')
				{
					if(isset($row_data['cover_photo']) && $row_data['cover_photo'] !='')
					{
						$old_file_name = $row_data['cover_photo'];
					}
					$_REQUEST['cover_photo'] = $file_name_update;
					$_REQUEST['cover_photo_approve'] = 'UNAPPROVED';
					$_REQUEST['cover_photo_uploaded_on'] = $this->common_model->getCurrentDate();
				}
				else
				{
					if(isset($row_data['photo'.$file_number]) && $row_data['photo'.$file_number] !='')
					{
						$old_file_name = $row_data['photo'.$file_number];
					}
					$_REQUEST['photo'.$file_number] = $file_name_update;
					$_REQUEST['photo'.$file_number.'_approve'] = 'UNAPPROVED';
					$_REQUEST['photo'.$file_number.'_uploaded_on'] = $this->common_model->getCurrentDate();
				}

				$this->common_model->set_table_name('register');
				$_REQUEST['mode'] ='edit';
				$member_id = $this->common_front_model->get_user_id();
				$_REQUEST['id'] = $member_id;
				if(isset($_FILES['cover_photo']))
				{
					unset($_FILES['cover_photo']);
				}
				$response = $this->common_model->save_update_data(1,1);
				$data1 = json_decode($response, true);
				if(isset($data1['status']) && $data1['status'] =='success')
				{
					$status = 'success';
					if($file_number == 'cover_photo')
					{
						$file_delete_array[] = $path_cover_photo.'/'.$old_file_name;
						$errmessage =  "Your profile cover photo has been updated successfully.";
					}
					else
					{
						$errmessage =  "Your profile photo has been updated successfully.";
						$file_delete_array[] = $path_photos.'/'.$old_file_name;
						$file_delete_array[] = $path_photos_big.'/'.$old_file_name;
					}					
				}
				else
				{
					if(isset($data1['response']) && $data1['response'] !='')
					{
						$errmessage = $data1['response'];
					}
					else
					{
						$errmessage = "Please provide atleast one file to upload";
					}
				}
			}
			else
			{
				if($file_name_update !='')
				{
					if($file_number == 'cover_photo')
					{
						$file_delete_array[] = $path_cover_photo.'/'.$file_name_update;
					}
					else
					{
						$file_delete_array[] = $path_photos.'/'.$file_name_update;
						$file_delete_array[] = $path_photos_big.'/'.$file_name_update;
					}
				}
			}
			if(isset($file_delete_array) && $file_delete_array !='' && count($file_delete_array) > 0)
			{
				$this->common_model->delete_file($file_delete_array);
			}
			if(isset($data1['response']))
			{
				unset($data1['response']);
			}
		}
		$data1['status'] = $status;
		$data1['errmessage'] = $errmessage;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		
		return $data;
	}
	public function upload_photo_crope()
	{
		$photo_number = 1;
		
		if(isset($_REQUEST['photo_number']) && $_REQUEST['photo_number'] == '1')
		{
			unset($_SESSION['mega_user_data']['photo1']);
			//$this->session->unset_userdata['mega_user_data']['photo1'];
		}
		
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
			
			
			if(isset($_REQUEST['photo_number']) && $_REQUEST['photo_number'] == '1')
			{
				$photo1update = base_url().$this->common_model->path_photos.$upload_photo_name;
				$photo1_session = array('photo1' => $photo1update);
				$photo1_session2 = $this->session->userdata('mega_user_data');
				$result_array = array_merge($photo1_session, $photo1_session2);
				
				$this->session->set_userdata('mega_user_data', $result_array);
				//print_r($this->session->userdata('mega_user_data'));exit;
			}
			
			
			if(isset($_FILES['cover_photo']) && $_FILES['cover_photo'] !='')
			{
				//$_FILES['cover_photo'];
				$_REQUEST['cover_photo_path'] = $this->common_model->path_cover_photo;
				$number = 'cover_photo';
				$_REQUEST['cover_photo_approve'] = 'UNAPPROVED';
			}
		
			$cover_photo_name = 'cover_photo';
			
			if(isset($_REQUEST[$cover_photo_name]) && $_REQUEST[$cover_photo_name]!='')
			{
				$number = 'cover_photo';
				$upload_cover_photo_name = time().'-'.$member_id.'.jpg';
				$this->common_model->base_64_photo($cover_photo_name,'path_cover_photo',$upload_cover_photo_name);
				$this->common_model->resize_image($this->common_model->path_cover_photo,$upload_cover_photo_name);
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
					$this->common_model->resize_image($this->common_model->path_photos_big,$upload_photo_name);
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
					$data1['errmessage'] = "Your profile photo has been updated successfully."; // for app return message 
					if($number=='cover_photo')
					{
						if(isset($delete_cover_photo_file) && $delete_cover_photo_file!='')
						{
							$this->common_front_model->delete_file($delete_cover_photo_file);
						}
						$data1['errmessage'] = "Your Cover photo has been updated successfully.";
					}
				}
				else
				{
					$data1['errmessage'] = $data1['response'];
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
		$data1['errmessage'] = strip_tags($data1['errmessage']);
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function upload_horoscope_photo()
	{
		$member_id = $this->common_front_model->get_user_id();
		$number='';
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);  
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'horoscope_photo');
			
			if(isset($_FILES['horoscope_photo']) && $_FILES['horoscope_photo'] !='')
			{
				//$_FILES['cover_photo'];
				$_REQUEST['horoscope_photo_path'] = $this->common_model->path_horoscope;
				$number = 'horoscope_photo';
			}
		
			$horoscope_photo_name = 'horoscope_photo';
			if(isset($_REQUEST[$horoscope_photo_name]) && $_REQUEST[$horoscope_photo_name]!='')
			{
				$number = 'horoscope_photo';
				$upload_horoscope_photo_name = time().'-'.$member_id.'.jpg';
				$this->common_model->base_64_photo($horoscope_photo_name,'path_horoscope',$upload_horoscope_photo_name);
				$this->common_model->resize_image($this->common_model->path_horoscope,$upload_horoscope_photo_name);
				$_REQUEST['horoscope_photo'] = $upload_horoscope_photo_name;
				$_REQUEST['horoscope_photo_approve'] = 'UNAPPROVED';
				$_REQUEST['horoscope_photo_uploaded_on'] = $this->common_model->getCurrentDate();
			}
			if(isset($number) && $number!='')
			{
				$this->common_model->set_table_name('register');
				$_REQUEST['mode'] ='edit';
				$member_id = $this->common_front_model->get_user_id();
				$_REQUEST['id'] = $member_id;
				$response = $this->common_model->save_update_data(1,1);
				$data1 = json_decode($response, true);
				
				if($number=='horoscope_photo')
				{
					$delete_horoscope_photo_file = $this->common_model->path_horoscope.$row_data[''.$number.''];
				}
				
				if(isset($data1['status']) && $data1['status'] =='success')
				{
					if($number=='horoscope_photo')
					{
						if(isset($delete_horoscope_photo_file) && $delete_horoscope_photo_file!='')
						{
							$this->common_front_model->delete_file($delete_horoscope_photo_file);
						}
						$data1['errmessage'] =  "Your Horoscope photo has been updated successfully.";
					}
				}
				else
				{
					$data1['errmessage'] = $data1['response'];
				}
				if(isset($data1['response']))
				{
					unset($data1['response']);
				}
			}
		}
		else
		{
			
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		if(!isset($data1['status']))
		{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please upload horoscope file";
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['errmessage'] = strip_tags($data1['errmessage']);
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function delete_horoscope_photo()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['delete_horoscope_photo']) && $_REQUEST['delete_horoscope_photo'] =='delete')
		{
			if(isset($_REQUEST["user_agent"]) && $_REQUEST["user_agent"]!='') {
				$member_id = $_REQUEST["user_id"];
			}else{
				$member_id = $this->common_front_model->get_user_id();
			}
			if($member_id !='')
			{
				$number = 'horoscope_photo';
				$where_arra = array('id'=>$member_id);
				$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'horoscope_photo');
				if(isset($row_data) && is_array($row_data) && count($row_data)>0){
					$delete_horoscope_photo_file = $this->common_model->path_horoscope.$row_data['horoscope_photo'];
					$data_array = array($number=>'');
					$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
					if($response)
					{
						if(isset($delete_horoscope_photo_file) && $delete_horoscope_photo_file !='')
						{
							$this->common_front_model->delete_file($delete_horoscope_photo_file);
						}
						$data1['status'] = 'success';
						$data1['errmessage'] = "Your Horoscope Photo Deleted Successfully.";
					}
				}else{
					$data1['status'] = 'error';
					$data1['errmessage'] = "Your provided user id is invalide.";
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
	
	public function upload_id_proof_photo()
	{
		$user_agent = $this->input->post("user_agent");
		if($user_agent=='NI-AAPP'){
			$member_id = $this->input->post("member_id");
		}else{
			$member_id = $this->common_front_model->get_user_id();
		}
		$number='';
		if($member_id !='')
		{
			$where_arra = array('id'=>$member_id);  
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id_proof');
			if(isset($row_data) && $row_data!='' &&  count($row_data)>0)
			{
				if(isset($_FILES['id_proof']) && $_FILES['id_proof'] !='')
				{
					//$_FILES['cover_photo'];
					$_REQUEST['id_proof_path'] = $this->common_model->path_id_proof;
					$number = 'id_proof';
				}
				$id_proof_photo_name = 'id_proof';
				if(isset($_REQUEST[$id_proof_photo_name]) && $_REQUEST[$id_proof_photo_name]!='')
				{
					$number = 'id_proof';
					$upload_id_proof_photo_name = time().'-'.$member_id.'.jpg';
					
					$this->common_model->base_64_photo($id_proof_photo_name,'path_id_proof',$upload_id_proof_photo_name);
					$this->common_model->resize_image($this->common_model->path_id_proof,$upload_id_proof_photo_name);
					$_REQUEST['id_proof'] = $upload_id_proof_photo_name;
					$_REQUEST['id_proof_approve'] = 'UNAPPROVED';
					$_REQUEST['id_proof_uploaded_on'] = $this->common_model->getCurrentDate();
				}
				if(isset($number) && $number!='')
				{
					$this->common_model->set_table_name('register');
					$_REQUEST['mode'] ='edit';
					$_REQUEST['id_proof_approve'] = 'UNAPPROVED';
					$member_id = $this->common_front_model->get_user_id();
					$_REQUEST['id'] = $member_id;
					$response = $this->common_model->save_update_data(1,1);
					$data1 = json_decode($response, true);
					if($number=='id_proof')
					{
						if($this->common_model->path_id_proof.$row_data[''.$number.''])
							$delete_id_proof_photo_file = $this->common_model->path_id_proof.$row_data[''.$number.''];
					}
					
					if(isset($data1['status']) && $data1['status'] =='success')
					{
						if($number=='id_proof')
						{
							if(isset($delete_id_proof_photo_file) && $delete_id_proof_photo_file!='')
							{
								$this->common_front_model->delete_file($delete_id_proof_photo_file);
							}
							$data1['errmessage'] =  "Your id proof photo has been updated successfully.";
						}
					}
					else
					{
						$data1['errmessage'] = $data1['response'];
					}
					if(isset($data1['response']))
					{
						unset($data1['response']);
					}
			}
			}else{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] = "Your session has been time out, please login again.";
			}
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your session has been time out, please login again.";
		}
		$data1['errmessage'] = strip_tags($data1['errmessage']);
		$data['data'] = json_encode($data1);
		return $data;
	}
	
	public function delete_id_proof_photo()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		if(isset($_REQUEST['delete_id_proof_photo']) && $_REQUEST['delete_id_proof_photo'] =='delete')
		{
			$member_id = $this->common_front_model->get_user_id();
			if($member_id !='')
			{
				$number = 'id_proof';
				$where_arra = array('id'=>$member_id);
				$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id_proof');
				$delete_id_proof_photo_file = $this->common_model->path_id_proof.$row_data['id_proof'];
				$data_array = array($number=>'');
				$response = $this->common_front_model->update_insert_data_common("register",$data_array,$where_arra,1,1);
				if($response)
				{
					if(isset($delete_id_proof_photo_file) && $delete_id_proof_photo_file !='')
					{
						$this->common_front_model->delete_file($delete_id_proof_photo_file);
					}
					$data1['status'] = 'success';
					$data1['errmessage'] = "Your Id Proof Photo Deleted Successfully.";
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
}
?>