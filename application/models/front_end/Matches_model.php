<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Matches_model extends CI_Model {
	public $data = array();
	public $member_match_data;
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
				$where = array('id'=>$member_id,'is_deleted'=>'No');
				$row_data = $this->common_model->get_count_data_manual('register',$where,1,'id, matri_id, gender, looking_for, part_frm_age, part_to_age, part_height, part_height_to, part_complexion, part_mother_tongue, part_religion, part_caste, part_country_living, part_education,is_deleted');
				$this->member_match_data = $row_data;
			}
			
		}
		if($this->member_match_data !='')
		{
			//$gender = $this->common_front_model->get_session_data('gender');
			$row_data = $this->member_match_data;
			$gender = $row_data['gender'];
			$del = $row_data['is_deleted'];
			if($gender !='')
			{
				$where_search[]= " ( gender != '$gender' ) ";
			}
			if(isset($del) && $del !='')
			{
				$where_search[]= " ( is_deleted != 'Yes' ) ";
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
			if(isset($row_data['part_frm_age']) && $row_data['part_frm_age'] !='' )
			{
				$part_frm_age = $row_data['part_frm_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  >=$part_frm_age )";
			}
			if(isset($row_data['part_to_age']) && $row_data['part_to_age'] !='')
			{
				$part_to_age = $row_data['part_to_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  <=$part_to_age )";
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
		## New Condition For Match Type : Date : 08-10-2021
		$selectNearMe = '';
		$whereMatchArr = array();
		if($this->input->post('match_type')){
			$member_id = $this->common_front_model->get_user_id();
			$member_data = $this->common_front_model->get_login_user_data($member_id,'latitude,longitude');
			$config_array = $this->common_model->get_site_config();
			$near_by_me_km = $config_array['near_by_me_km'];
			$match_type = $this->input->post('match_type');
			if($match_type == 'premium-match'){
				$whereMatchArr[] = "register.plan_status = 'Paid'";
			}elseif ($match_type == 'near-by-me') {
				$currenMemberLat = $member_data['latitude'];
				$currenMemberLong = $member_data['longitude'];
				if($currenMemberLat !='' && $currenMemberLong != ''){
					$selectNearMe = ", ( ( ( acos( sin(( '".$currenMemberLat."' * pi() / 180)) * sin(( `latitude` * pi() / 180)) + cos(( '".$currenMemberLat."' * pi() /180 )) * cos(( `latitude` * pi() / 180)) * cos((( '".$currenMemberLong."' - `longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance";
					// $whereMatchArr[] = " register.id!='".$member_id."' having distance <= ".$near_by_me_km;
					## For Distance From and To : Date : 11-10-2021
					$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
					if($this->input->post('distance_from') && $this->input->post('distance_to')){
						$distance_from = $this->input->post('distance_from');
						$distance_to = $this->input->post('distance_to');
						$whereMatchArr[] = " register_view.id!='".$member_id."' AND distance BETWEEN $distance_from AND $distance_to";
					}else{
						$whereMatchArr[] = " register.id!='".$member_id."' having distance <= ".$near_by_me_km;
					}
				}
			}
		}
		$this->set_search_where();
		// $member_count = $this->common_model->get_count_data_manual('register','',0);
		$member_list = $this->common_model->get_count_data_manual('register',$whereMatchArr,2,'register.id'.$selectNearMe);
		
		if($member_list == ''){
			$member_count = 0;
		}else{
			$member_count = count($member_list);
		}
		
		return $member_count;
	}
	public function get_search_result($page='')
	{
		## New Condition For Match Type : Date : 08-10-2021
		$selectNearMe = '';
		$orderByMatch = '';
		$whereMatchArr = array();
		if($this->input->post('match_type')){
			$member_id = $this->common_front_model->get_user_id();
			$member_data = $this->common_front_model->get_login_user_data($member_id,'latitude,longitude');
			
			$config_array = $this->common_model->get_site_config();
			$near_by_me_km = $config_array['near_by_me_km'];
			$match_type = $this->input->post('match_type');
			if($match_type == 'premium-match'){
				$whereMatchArr[] = "register_view.plan_status = 'Paid'";
			}elseif ($match_type == 'near-by-me') {
				$currenMemberLat = $member_data['latitude'];
				$currenMemberLong = $member_data['longitude'];
				if($currenMemberLat !='' && $currenMemberLong != ''){
					//$selectNearMe = ", ( ( ( acos( sin(( '".$currenMemberLat."'  pi() / 180))  sin(( `latitude`  pi() / 180)) + cos(( '".$currenMemberLat."'  pi() /180 ))  cos(( `latitude`  pi() / 180))  cos((( '".$currenMemberLong."' - `longitude`)  pi()/180))) )  180/pi() )  60  1.1515  1.609344 ) as distance";
					/* For issue start 30/11/2021  */
					$selectNearMe = ", ( ( ( acos( sin(( '".$currenMemberLat."' * pi() / 180)) * sin(( `latitude` * pi() / 180)) + cos(( '".$currenMemberLat."' * pi() /180 )) * cos(( `latitude` * pi() / 180)) * cos((( '".$currenMemberLong."' - `longitude`) * pi()/180))) ) * 180/pi() ) * 60 * 1.1515 * 1.609344 ) as distance";
					/* For issue end 30/11/2021  */
					//$whereMatchArr[] = " register_view.id!='".$member_id."' having distance <= ".$near_by_me_km;
					## For Distance From and To : Date : 11-10-2021
					$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
					if($this->input->post('distance_from') && $this->input->post('distance_to')){
						$distance_from = $this->input->post('distance_from');
						$distance_to = $this->input->post('distance_to');
						$whereMatchArr[] = " register_view.id!='".$member_id."' AND distance BETWEEN $distance_from AND $distance_to";
					}else{
						$whereMatchArr[] = " register_view.id!='".$member_id."' having distance <= ".$near_by_me_km;
					}
					// $whereMatchArr[] = " register_view.id!='".$member_id."' having distance <= ".$near_by_me_km;
					$orderByMatch .= ' distance,';
				}
			}
		}
		$this->set_search_where();
		// $member_data = $this->common_model->get_count_data_manual('register_view',$whereMatchArr,2,'','id desc',$page,$limit='10');
		$member_data = $this->common_model->get_count_data_manual('register_view',$whereMatchArr,2,'*'.$selectNearMe,$orderByMatch.'register_view.id desc',$page,10);
		// echo $this->db->last_query();exit;
		return $member_data;
	}
	public function get_matching_result_dashboard($page='')
	{
		$this->set_search_where();
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='8');
		return $member_data;
	}
	
	public function received_match_from_admin_count()
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB'){
			$user_id = $this->input->post('user_id');
		}else{
			$user_id = $this->common_front_model->get_user_id();
		}
		
		$member_count = '';
		if(isset($user_id) && $user_id!= ''){
			$where_arr = array('my_id'=>$user_id,'register.status'=>'APPROVED','register.is_deleted'=>'No');
			
			$this->db->join('register','matches_list.other_id = register.id','left');
			$member_count = $this->common_model->get_count_data_manual('matches_list',$where_arr,0,'','matches_list.sent_on desc','','','');
			
			//$member_count = $this->common_model->get_count_data_manual('matches_list',$where_arr,2,'','','','','','');
		}		
		return $member_count;
	}
	
	public function received_match_from_admin($page='')
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$user_id = $this->input->post('user_id');
		}
		else
		{
			$user_id = $this->common_front_model->get_user_id();
		}
		
		$member_data = array();
		if(isset($user_id) && $user_id!= '')
		{
			$where_arr = array('my_id'=>$user_id,'register.status'=>'APPROVED','register.is_deleted'=>'No');
			$this->db->join('register','matches_list.other_id = register.id','left');
			$matches_list_data = $this->common_model->get_count_data_manual('matches_list',$where_arr,2,'other_id','matches_list.sent_on desc',$page,$limit='','','','');
			
			if(isset($matches_list_data) && $matches_list_data!= '' && $matches_list_data > 0)
			{
				$id_arr = array();
				foreach($matches_list_data as $row_data)
				{
					$id_arr[] = $row_data['other_id'];
					//$this->db->where_not_in('status',array('UNAPPROVED','Suspended'));
					
				}
				$id_arr_str = implode(',',$id_arr);
				$where_arr = array('my_id'=>$user_id,'status'=>'APPROVED','is_deleted'=>'No'); ///'id'=>$row_data['other_id'],
				$where_arr[]= " id in ( $id_arr_str )";
				$this->db->join('matches_list','search_register_view.id = matches_list.other_id','left');
				$member_data = $this->common_model->get_count_data_manual('search_register_view',$where_arr,2,'search_register_view.*,matches_list.sent_on','matches_list.sent_on desc','','');
				//echo $this->db->last_query();
			}
		}
		
		return $member_data;
	}
	
	
}
?>