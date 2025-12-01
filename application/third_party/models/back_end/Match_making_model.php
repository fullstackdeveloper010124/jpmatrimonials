<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Match_making_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_match_count_data($data_array='',$flage=0)
	{
		$count_data = 0;
		$where_search_str = '';
		$table_pre ='';
		if($flage ==1)
		{
			$table_pre ='register_view.';
		}
		if($data_array !='' && is_array($data_array) && count($data_array) > 0)
		{
			$where_search = array();
			if(isset($data_array['part_frm_age']) && $data_array['part_frm_age'] !='' )
			{
				$part_frm_age = $data_array['part_frm_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,".$table_pre."birthdate,CURDATE())  >=$part_frm_age )";
			}
			if(isset($data_array['part_to_age']) && $data_array['part_to_age'] !='')
			{
				$part_to_age = $data_array['part_to_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,".$table_pre."birthdate,CURDATE())  <=$part_to_age )";
			}
			if(isset($data_array['part_height']) && $data_array['part_height'] !='' )
			{
				$part_height = $data_array['part_height'];
				$where_search[]= " ( ".$table_pre."height >='$part_height') ";
			}
			if(isset($data_array['part_height_to']) && $data_array['part_height_to'] !='' )
			{
				$part_height_to = $data_array['part_height_to'];
				$where_search[] = " ( ".$table_pre."height <='$part_height_to') ";
			}
			if(isset($data_array['part_religion']) && $data_array['part_religion'] !='')
			{
				$religion = $data_array['part_religion'];
				if(isset($religion) && $religion !='')
				{
					$where_search[]= " ( ".$table_pre."religion in ($religion) ) ";
				}
			}
			if(isset($data_array['part_country_living']) && $data_array['part_country_living'] !='')
			{
				$part_country_living = $data_array['part_country_living'];
				if(isset($part_country_living) && $part_country_living !='')
				{
					$where_search[]= " ( ".$table_pre."country_id in ($part_country_living) ) ";
				}
			}
			if(isset($data_array['part_education']) && $data_array['part_education'] !='')
			{
				$part_education = $data_array['part_education'];
				if(isset($part_education) && $part_education !='')
				{
					$part_education_arr = explode(',',$part_education);
					$str_education_partner = array();
					foreach($part_education_arr as $part_education_arr_val)
					{
						$str_education_partner[] = "(find_in_set('$part_education_arr_val', ".$table_pre."education_detail) > 0 )";
					}
					if(isset($str_education_partner) && count($str_education_partner)> 0)
					{
						$str_education_partner_str = implode(" or ",$str_education_partner);
						$where_search[]= " ( $str_education_partner_str ) ";
					}
				}
			}
			if(isset($data_array['part_mother_tongue']) && $data_array['part_mother_tongue'] !='')
			{
				$part_mother_tongue = $data_array['part_mother_tongue'];
				if(isset($part_mother_tongue) && $part_mother_tongue !='')
				{
					$where_search[]= " ( ".$table_pre."mother_tongue in ($part_mother_tongue) ) ";
				}
			}
			if(isset($data_array['part_caste']) && $data_array['part_caste'] !='')
			{
				$part_caste = $data_array['part_caste'];
				if(isset($part_caste) && $part_caste !='')
				{
					$where_search[]= " ( ".$table_pre."caste in ($part_caste) ) ";
				}
			}
			if(isset($data_array['gender']) && $data_array['gender'] !='')
			{
				$gender = $data_array['gender'];
				$where_search[]= " ( ".$table_pre."gender != '$gender' ) ";
			}
			if(isset($where_search) && $where_search !='' && count($where_search) > 0)
			{
				$where_search_str = implode(" and ",$where_search);
			}
			if($flage == 0)
			{
				$count_data = $this->common_front_model->get_count_data_manual("register",$where_search_str,0,'id');
			}
		}
		if($flage == 0)
		{
			return $count_data;
		}
		else if($flage == 1)
		{
			return $where_search_str;
		}
	}
	function get_match_where_from_matri($matri_id = '')
	{
		$return_where = '';
		if($matri_id !='')
		{
			
			$data = $this->common_front_model->get_count_data_manual("register",array('matri_id'=>$matri_id),1,'part_frm_age, part_to_age, part_height, part_height_to, part_religion, part_country_living, part_education, part_mother_tongue, part_caste, gender, matri_id');
			if($data !='' && count($data) > 0)
			{
				$return_where = $this->get_match_count_data($data,1);
			}
		}
		return $return_where;
	}
	
}