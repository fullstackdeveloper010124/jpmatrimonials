<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Register_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}
	public function save_register($is_post=0)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('gender', 'Gender', 'required');
		$this->form_validation->set_rules('email', 'Email ID', 'required|valid_email');
		$this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		
		$this->form_validation->set_rules('religion', 'Religion', 'required');
		$this->form_validation->set_rules('caste', 'Caste', 'required');
		
		//$this->form_validation->set_rules('code_captcha', 'Captcha Code', 'callback_validate_captcha');
		if ($this->form_validation->run() == FALSE)
        {
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  strip_tags(validation_errors());
			$data1['status'] = 'error';
		}
		else
		{
			if($this->input->post('email'))
			{
				$email = trim($this->input->post('email'));
				$count_email = $this->common_model->get_count_data_manual('register',array('email'=>$email,'is_deleted'=>'No'),0,'id');
				if($count_email == 0)
				{
					
					$_REQUEST['terms'] = 'Yes';
					$_REQUEST['mobile'] = $_REQUEST['country_code'].'-'.$_REQUEST['mobile_number'];
					if(isset($_REQUEST['birth_year']) && $_REQUEST['birth_month'] && $_REQUEST['birth_date'])
					{					
						$_REQUEST['birthdate'] = $_REQUEST['birth_year'].'-'.$_REQUEST['birth_month'].'-'.$_REQUEST['birth_date'];
					}
					$_REQUEST['username'] = $_REQUEST['firstname'].' '.$_REQUEST['lastname'];
					$_REQUEST['password'] = md5($_REQUEST['password']);
					$this->common_model->created_on_fild = 'registered_on';
					$this->common_model->set_table_name('register');
					$response = $this->common_model->save_update_data(1,1);
					$insert_id = $this->common_model->last_insert_id;
					$this->session->set_userdata('recent_reg_id',$insert_id);
					$data1['id'] = $insert_id;
					$data1['tocken'] = $this->security->get_csrf_hash();
					$data = json_decode($response, true);
					if(isset($data['status']) && $data['status'] =='success')
					{
						$config_data = $this->common_model->data['config_data'];
						$matri_prefix = $config_data['matri_prefix'];
						$matri_id = $matri_prefix.$insert_id;
						$data_update_arr['matri_id'] = $matri_id;
						$this->common_model->update_insert_data_common('register',$data_update_arr,array('id'=>$insert_id));
						$data1['errmessage'] =  "Your profile has beem created, please complete next step to complete your profile, please wait while we are redirecting to next step";
						$data1['status'] = 'success';
					}
					else
					{
						$data1['errmessage'] =  $data['response'];
						$data1['status'] = 'error';
					}
				}
				else
				{
					$data1['tocken'] = $this->security->get_csrf_hash();
					$data1['errmessage'] =  "Duplicate Email address found, please enter another one";
					$data1['status'] = 'error';
				}
			}
		}
		if($is_post == 0)
		{
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			if(isset($data1['status']) && $data1['status'] == 'success')
			{
				$this->session->set_flashdata('success_message', "<div class='alert alert-success'>Your profile has been created, please complete next step to complete your profile, please wait while we are redirecting to next step</div>");
				return 'success';
			}
			else 
			{
				if(isset($data1['errmessage']) && $data1['errmessage'] !='')
				{
					$this->session->set_flashdata('error_message', "<div class='alert alert-danger'>".$data1['errmessage']."</div>");
				}
				return 'error';
			}
		}
	}
	public function save_register_step($is_post = 0,$step='step1')
	{
		$insert_id = '';
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP' && isset($_REQUEST['id']) && $_REQUEST['id'] != '')
		{
			$insert_id = $_REQUEST['id'];
		}
		else
		{	
			$insert_id = $this->session->userdata('recent_reg_id');
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';
		if(isset($_FILES['profil_photo']) && $_FILES['profil_photo'] !='')
		{
			$_FILES['photo1'] = $_FILES['profil_photo'];
			$_REQUEST['photo1_path'] = $this->common_model->path_photos;
			if(isset($_FILES['photo1']['name']) && $_FILES['photo1']['name'] !='')
			{
				$data_mem_array = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id,'is_deleted'=>'No'),1,'photo1');
				if(isset($data_mem_array['photo1']) && $data_mem_array['photo1'] !='')
				{
					$_REQUEST['photo1_val'] = $data_mem_array['photo1'];
				}
			}
			unset($_FILES['profil_photo']);
		}
		if(isset($_REQUEST['profile_photo_crop']) && $_REQUEST['profile_photo_crop'] !='')
		{
		    $upload_photo_name = time().'-'.$insert_id.'.jpg';
		    $this->common_model->base_64_photo('profile_photo_crop','path_photos',$upload_photo_name);
		    if(isset($_REQUEST['profile_photo_org']) && $_REQUEST['profile_photo_org'] !='') {
                $this->common_model->base_64_photo('profile_photo_org', 'path_photos_big', $upload_photo_name);
		    }
		    $_REQUEST['photo1'] = $upload_photo_name;
		    $_REQUEST['photo1_approve'] = 'UNAPPROVED';
		    $_REQUEST['photo1_uploaded_on'] = $this->common_model->getCurrentDate();
		}
		
		if(!isset($insert_id) || $insert_id == '' )
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{	
			$this->common_model->set_table_name('register');
			$_REQUEST['mode'] ='edit';
			$_REQUEST['id'] =$insert_id;
			$response = $this->common_model->save_update_data(1,1);
			$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
				{
					$data1['errmessage'] =  "Your profile has been updated successfully."; // for app return message 
				}
				else
				{
					$data1['errmessage'] =  "<i class='fa fa-check text-success'></i> Your profile has been updated successfully.";	 // for website return message 
				}
				$data1['status'] = 'success';
			}
			else
			{
				//$data1['old_photo_url'] = base_url().$this->common_model->path_photos.$_REQUEST['photo1_val'];
				$data1['errmessage'] = strip_tags($data1['response']);
			}
			unset($data1['response']);
			if($is_post == 0)
			{
				$data['data'] = json_encode($data1);
				return $data;
			}
			else
			{
				if(isset($data1['status']) && $data1['status'] == 'success')
				{
					$this->session->set_flashdata('success_message', "<div class='alert alert-success'><i class='fa fa-check text-success'></i> Your profile has been updated successfully.</div>");
					return 'success';
				}
				else 
				{
					if(isset($data1['errmessage']) && $data1['errmessage'] !='')
					{
						$this->session->set_flashdata('error_message', "<div class='alert alert-danger'>".$data1['errmessage']."</div>");
					}
					return 'error';
				}
			}
		}
	}
	public function set_login_register_user()
	{
		$insert_id = $this->session->userdata('recent_reg_id');
		if(isset($insert_id) && $insert_id !='')
		{
			$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id),1,'id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender ');
			if(isset($row_data) && $row_data !='' && count($row_data) > 0)
			{
				$login_dt = $this->common_model->getCurrentDate();
				$status  = 'success';
				$this->db->set('last_login', $login_dt);
				$where_arra = array(
					'id'=>$row_data['id']
				);
				$data_array = array('last_login'=>$login_dt);
				$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);
				if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1']))
				{
					$row_data['photo1'] = base_url().$this->common_model->path_photos.$row_data['photo1'];
				}
				else
				{
					if(isset($row_data['gender']) && $row_data['gender'] =='Male')
					{
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-male.gif';
					}
					else
					{
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-female.gif';
					}
				}
				$this->session->set_userdata('mega_user_data', $row_data);
			}
			$this->session->unset_userdata('recent_reg_id');
		}
	}
}
?>