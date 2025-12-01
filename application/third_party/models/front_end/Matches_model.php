<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Matches_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->member_match_data = '';
	}
	
	public function save_matches($is_post = 0)
	{
		$member_id = $this->common_front_model->get_user_id();
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'error';
		if(!isset($member_id) || $member_id =='')
		{
			$data1['errmessage'] =  "Sorry, Your session hase been time out, Please login Again";
			$data['data'] = json_encode($data1);
			return $data;
		}
		else
		{
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
	public function set_search_where()
	{
		$where_search = array();
		if($this->member_match_data =='')
		{
			$member_id = $this->common_front_model->get_user_id();
			//$member_id = $this->common_front_model->get_session_data('id');
			if(isset($member_id) && $member_id != '' )
			{
				$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1,'id,matri_id,gender,looking_for,part_height,part_height_to,part_complexion,part_mother_tongue,part_religion,part_caste,part_country_living,part_education');
				$this->member_match_data = $row_data;
			}
			
		}
		if($this->member_match_data !='')
		{
			//$gender = $this->common_front_model->get_session_data('gender');
			$row_data = $this->member_match_data;
			$gender = $row_data['gender'];
			if($gender !='')
			{
				$where_search[]= " ( gender != '$gender' ) ";
			}
			if(isset($row_data['part_height']) && $row_data['part_height'] !='')
			{
				$part_height = $row_data['part_height'];
				$where_search[]= " ( height >='$part_height') ";
			}
			if(isset($row_data['part_height_to']) && $row_data['part_height_to'] !='')
			{
				$part_height_to = $row_data['part_height_to'];
				$where_search[]= " ( height <='$part_height_to') ";
			}
			if(isset($row_data['looking_for']) && $row_data['looking_for'] !='')
			{
				$looking_for = explode(',',$row_data['looking_for']);
				$looking_for = $this->common_model->trim_array_remove($looking_for);
				if(isset($looking_for) && count($looking_for) > 0)
				{
					$looking_for_str = implode("','",$looking_for);
					$where_search[]= " ( marital_status in ( '$looking_for_str') ) ";
				}
			}
			if(isset($row_data['part_complexion']) && $row_data['part_complexion'] !='')
			{
				$complexion = explode(',',$row_data['part_complexion']);
				$complexion = $this->common_model->trim_array_remove($complexion);
				if(isset($complexion) && count($complexion) > 0)
				{
					$complexion_str = implode("','",$complexion);
					$where_search[]= " ( complexion in ( '$complexion_str') ) ";
				}
			}
			if(isset($row_data['part_mother_tongue']) && $row_data['part_mother_tongue'] !='')
			{
				$mothertongue = explode(',',$row_data['part_mother_tongue']);
				$mothertongue = $this->common_model->trim_array_remove($mothertongue);
				if(isset($mothertongue) && count($mothertongue) > 0)
				{
					$mothertongue_str = implode("','",$mothertongue);
					$where_search[]= " ( mother_tongue in ( '$mothertongue_str') ) ";
				}
			}
			if(isset($row_data['part_religion']) && $row_data['part_religion'] !='')
			{
				$religion = explode(',',$row_data['part_religion']);
				$religion = $this->common_model->trim_array_remove($religion);
				if(isset($religion) && count($religion) > 0)
				{
					$religion_str = implode("','",$religion);
					$where_search[]= " ( religion in ('$religion_str') ) ";
				}
			}
			if(isset($row_data['part_caste']) && $row_data['part_caste'] !='')
			{
				$part_caste = explode(',',$row_data['part_caste']);
				$caste = $this->common_model->trim_array_remove($part_caste);
				if(isset($caste) && count($caste) > 0)
				{
					$caste_str = implode("','",$caste);
					$where_search[]= " ( caste in ('$caste_str') ) ";
				}
			}
			if(isset($row_data['part_country_living']) && $row_data['part_country_living'] !='')
			{
				$part_country_living = explode(',',$row_data['part_country_living']);
				$country = $this->common_model->trim_array_remove($part_country_living);
				if(isset($country) && count($country) > 0)
				{
					$country_str = implode("','",$country);
					$where_search[]= " ( country_id in ('$country_str') ) ";
				}
			}
			if(isset($row_data['part_education']) && $row_data['part_education'] !='')
			{
				$part_education = explode(',',$row_data['part_education']);
				$education = $this->common_model->trim_array_remove($part_education);
				if(isset($education) && $education !='')
				{
					$str_education_partner = array();
					$where_search_filed['education'] = $education;
					foreach($education as $part_education_arr_val)
					{
						$str_education_partner[] = "(find_in_set('$part_education_arr_val',education_detail) > 0 )";
					}
					if(isset($str_education_partner) && count($str_education_partner)> 0)
					{
						$str_education_partner_str = implode(" or ",$str_education_partner);
						$where_search[]= " ( $str_education_partner_str ) ";
					}
				}
			}
		}
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
			$this->db->where($where_search_str);
		}
		$this->db->where_not_in('status',array('UNAPPROVED','Suspended'));
	}
	public function get_search_count()
	{
		$this->set_search_where();
		$member_count = $this->common_model->get_count_data_manual('register','',0);
		return $member_count;
	}
	public function get_search_result($page='')
	{
		$this->set_search_where();
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='');
		return $member_data;
	}
	public function get_matching_result_dashboard($page='')
	{
		$this->set_search_where();
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='8');
		return $member_data;
	}
}
?>