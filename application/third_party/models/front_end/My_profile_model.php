<?php defined('BASEPATH') OR exit('No direct script access allowed');
class My_profile_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}
	
	public function save_profile($is_post = 0,$step='step1')
	{
		$member_id = $this->common_front_model->get_user_id();
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';
		if(!isset($member_id) || $member_id == '' )
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
			if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
			{
				$step = '';
			}
			else
			{
				if($step =='basic-detail')
				{
					$this->basic_detail();
				}
				else if($step =='residence-detail')
				{
					$this->residence_detail();
				}
			}
			$this->common_model->set_table_name('register');
			$_REQUEST['mode'] ='edit';
			$_REQUEST['id'] =$member_id;
			$response = $this->common_model->save_update_data(1,1);
			$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				$data1['errmessage'] =  "<i class='fa fa-check text-success'></i> Your profile has been updated successfully.";
				$data1['status'] = 'success';
			}
			else
			{
				$data1['errmessage'] = strip_tags($data1['response']);
				unset($data1['response']);
			}
			if($is_post == 0)
			{
				if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
				{
					if(isset($data1['response']))
					{
						unset($data1['response']);
					}
					$data1['errmessage'] = strip_tags($data1['errmessage']);
				}
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
	function basic_detail()
	{
		$username = '';
		if($this->input->post('firstname') && $this->input->post('firstname') !='')
		{
			$username = $this->input->post('firstname');
		}
		if($this->input->post('lastname') && $this->input->post('lastname') !='')
		{
			$username = $username.' '.$this->input->post('lastname');
		}
		if($username !='')
		{
			$_REQUEST['username'] = $username;
		}
		$birth_date = '';
		$birth_month = '';
		$birth_year = '';
		if($this->input->post('birth_date') && $this->input->post('birth_date') !='')
		{
			$birth_date = $this->input->post('birth_date');
		}
		if($this->input->post('birth_month') && $this->input->post('birth_month') !='')
		{
			$birth_month = $this->input->post('birth_month');
		}
		if($this->input->post('birth_year') && $this->input->post('birth_year') !='')
		{
			$birth_year = $this->input->post('birth_year');
		}
		if($birth_year !='' && $birth_date !='' && $birth_month !='')
		{
			$birthdate = $birth_year.'-'.$birth_month.'-'.$birth_date;
			$_REQUEST['birthdate'] = $birthdate;
		}
	}
	function residence_detail()
	{
		$mobile_num = '';
		$country_code = '';
		if(isset($_REQUEST['mobile_num']) && $_REQUEST['mobile_num'] !='')
		{
			$mobile_num = $_REQUEST['mobile_num'];
		}
		if(isset($_REQUEST['country_code']) && $_REQUEST['country_code'] !='')
		{
			$country_code = $_REQUEST['country_code'];
		}
		if($country_code !='' && $mobile_num !='')
		{
			$mobile = $country_code.'-'.$mobile_num;
			$_REQUEST['mobile'] = $mobile;
		}
	}
	function get_my_profile()
	{
		$data = '';
		$member_id = $this->common_front_model->get_session_data('id');
		if($member_id !='')
		{
			$data = $this->common_front_model->get_user_data('register_view',$member_id);
		}
		return $data;
	}
	function short_list_profile($post=0,$page='')
	{
		$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		$where_arra=array('shortlist.is_deleted'=>'No','shortlist.from_id'=>$login_user_matri_id);
		$this->common_model->set_table_name('shortlist');
		$this->db->join('register_view',' shortlist.to_id = register_view.matri_id ','left');
		
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('shortlist',$where_arra,0,'');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('shortlist',$where_arra,2,'register_view.matri_id,register_view.username,register_view.gender,register_view.birthdate,register_view.height,register_view.weight,register_view.religion_name,register_view.caste_name,register_view.country_name,register_view.city_name,register_view.photo1,register_view.photo1_approve,shortlist.created_on,shortlist.id','shortlist.id desc',$page);
		}
		return $data;
	}
	function block_list_profile($post=0,$page='')
	{
		$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		$where_arra=array('block_profile.is_deleted'=>'No','block_profile.block_by'=>$login_user_matri_id);
		$this->common_model->set_table_name('block_profile');
		$this->db->join('register_view',' block_profile.block_to = register_view.matri_id ','left');
		
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('block_profile',$where_arra,0,'');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('block_profile',$where_arra,2,'register_view.matri_id,register_view.username,register_view.gender,register_view.birthdate,register_view.height,register_view.weight,register_view.religion_name,register_view.caste_name,register_view.country_name,register_view.city_name,register_view.photo1,register_view.photo1_approve,block_profile.created_on,block_profile.id','block_profile.id desc',$page);
		}
		return $data;
	}
	function i_viewed_profile($post=0,$page='')
	{
		$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		$this->common_model->is_delete_fild = '';
		$where_arra=array('who_viewed_my_profile.my_id'=>$login_user_matri_id);
		$this->common_model->set_table_name('who_viewed_my_profile');
		$this->db->join('register_view',' who_viewed_my_profile.viewed_member_id = register_view.matri_id ','left');
		
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,2,'register_view.matri_id,register_view.username,register_view.gender,register_view.birthdate,register_view.height,register_view.weight,register_view.religion_name,register_view.caste_name,register_view.country_name,register_view.city_name,register_view.photo1,register_view.photo1_approve,who_viewed_my_profile.created_on,who_viewed_my_profile.id','who_viewed_my_profile.id desc',$page,'',0);
		}
		return $data;
	}
	function who_viewed_profile($post=0,$page='')
	{
		$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		$this->common_model->is_delete_fild = '';
		$where_arra=array('who_viewed_my_profile.viewed_member_id'=>$login_user_matri_id);
		$this->common_model->set_table_name('who_viewed_my_profile');
		$this->db->join('register_view',' who_viewed_my_profile.my_id = register_view.matri_id ','left');
		
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,2,'register_view.matri_id,register_view.username,register_view.gender,register_view.birthdate,register_view.height,register_view.weight,register_view.religion_name,register_view.caste_name,register_view.country_name,register_view.city_name,register_view.photo1,register_view.photo1_approve,who_viewed_my_profile.created_on,who_viewed_my_profile.id','who_viewed_my_profile.id desc',$page,'',0);
		}
		return $data;
	}
	public function check_unblock_status()
	{
		$status = '';
		$id = '';
		$block_by = $this->common_front_model->get_session_data('matri_id');
		if($this->input->post('status') !='')
		{
			$status = $this->input->post('status');
		}
		if($this->input->post('id') !='')
		{
			$id = $this->input->post('id');
		}
		if($this->input->post('block_to') !='')
		{
			$block_to = $this->input->post('block_to');
		}
		if($status !='' && $id !='' && $block_to !='')
		{
			 $where_arra = array('id'=>$id,'block_by'=>$block_by,'block_to'=>$block_to);
			 $this->common_model->data_delete_common('block_profile',$where_arra,0,'id');
			 $data1['status'] = 'unblock';
			 $data1['message'] = "Your request for member unblocking is successfully done.";
			 
			 $this->data['page_name'] = 'Block Listed Profile';
			 $this->data['base_url'] = base_url();
			 $this->data['shortlist_data_count'] = $this->my_profile_model->block_list_profile(0);
			 $this->data['shortlist_data'] = $this->my_profile_model->block_list_profile(1,1);
			 $data1['block_profile_code'] = $this->load->view('front_end/short_listed_member_profile',$this->data,true); 
			 $data['data'] = json_encode($data1);
			 $data1['token'] = $this->security->get_csrf_hash();
			 $this->load->view('common_file_echo',$data);
		}
	}
}
?>