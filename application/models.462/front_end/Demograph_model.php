<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Demograph_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function demograph_data($gender_data='',$religion_data='',$age_data='')
	{
		if($gender_data=='Male' || $gender_data=='Female'){
			$gender=" gender='".$gender_data."'";
		}else{
			$gender=" (gender='Male' or gender='Female' )";
		}

		$where_array_relegion = array('status'=>'APPROVED',"LOWER(TRIM(religion_name)) IN ('hindu','Jain - Digambar','Jain - Shwetambar','Jain - Others','other')");
		$relegion_data = $this->common_model->get_count_data_manual('religion',$where_array_relegion,2,'');
		$relegion_count_data = $this->common_model->get_count_data_manual('religion',$where_array_relegion,0,'');
		$where_array_not_relegion = array('status'=>'APPROVED',"LOWER(TRIM(religion_name)) NOT IN ('hindu','Jain - Digambar','Jain - Shwetambar','Jain - Others','other')");
		$other_relegion_data = $this->common_model->get_count_data_manual('religion',$where_array_not_relegion,2,'');
		$other_relegion_count_data = $this->common_model->get_count_data_manual('religion',$where_array_not_relegion,0,'');
		
		$selected_rel = array();
		foreach($relegion_data as $row_relegion){
			$selected_rel[strtolower(trim($row_relegion['religion_name']))] = array('religion_id'=>$row_relegion['id'],'religion_name'=>strtolower(trim($row_relegion['religion_name'])),'is_deleted'=>$row_relegion['is_deleted'],'status'=>$row_relegion['status']);
		}
		$other_relegion = array();
		if(isset($other_relegion_data) && $other_relegion_data!='' && is_array($other_relegion_data) && count($other_relegion_data)>0){
			foreach($other_relegion_data as $row_relegion){
				$other_relegion[] = $row_relegion['id'];
			}
		}
		
		if($religion_data == 'All'){
			$religion = "";
		}else if($religion_data == 'Other'){
			if($other_relegion_count_data > 0){
					$other_relegion_comma = implode("','",$other_relegion);
					$religion = " and religion IN ('".$other_relegion_comma."') "; 
			}else{
				$religion = "";
			}
		}else{
			$religion_data = strtolower(trim($religion_data));
			if($this->in_array_r($religion_data,$selected_rel))
			{	
				$religion = " and religion='".$selected_rel[$religion_data]['religion_id']."'";
			}else{
				$religion = "";
			}
		}
		
		if(isset($age_data) && $age_data != 'All')
		{
			$age = explode('-',$age_data);
			$age_query = " and  ((	(date_format( now( ) , '%Y' ) - date_format( birthdate, '%Y' )) - ( date_format( now( ) , '00-%m-%d' ) < date_format( birthdate, '00-%m-%d' ) )) BETWEEN '$age[0]' and '$age[1]') ";
		}else{
			$age_query='';
		}
		if($gender != '' || $religion != ''){
			if($religion!=''){
					
			}
			$where_array_all = $gender.$religion.$age_query." and status = 'APPROVED' and is_deleted='No' and (religion!='' and religion!='0')";
		}else{
			$where_array_all = $gender.$age_query." and status = 'APPROVED' and is_deleted='No'";
		}
		
		$count_result = $this->common_model->get_count_data_manual('register',$where_array_all,0,'','','','','');
// 		echo $this->db->last_query();
// 		print_r($count_result);exit;
		return $count_result;
	}
	
	
	public function country_data_gender_wise($gender)
	{	
		/*$Worldwide = $this->demograph_model->demograph_data($gender,'All','All','All');
		$Pakistan = $this->demograph_model->demograph_data($gender,'Pakistan','All','All');
		$India = $this->demograph_model->demograph_data($gender,'India','All','All');
		$Others = $this->demograph_model->demograph_data($gender,'Others','All','All');
		$Australia = $this->demograph_model->demograph_data($gender,'Australia','All','All');
		$UK = $this->demograph_model->demograph_data($gender,'United Kingdom','All','All');
		$USA = $this->demograph_model->demograph_data($gender,'United States','All','All');
		$middle_east = $this->demograph_model->demograph_data($gender,'Gulf','All','All');
		$Canada = $this->demograph_model->demograph_data($gender,'Canada','All','All');*/
		
		/*if($country == 'All'){
			$all_checked = 'checked';
		}else{
			$all_checked = '';
		}
		if($country == 'Pakistan'){
			$Pakistan_checked = 'checked';
		}else{
			$Pakistan_checked = '';
		}
		if($country == 'India'){
			$India_checked = 'checked';
		}else{
			$India_checked = '';
		}
		if($country == 'Others'){
			$Others_checked = 'checked';
		}else{
			$Others_checked = '';
		}
		if($country == 'Australia'){
			$Australia_checked = 'checked';
		}else{
			$Australia_checked = '';
		}
		if($country == 'United Kingdom'){
			$UK_checked = 'checked';
		}else{
			$UK_checked = '';
		}
		if($country == 'United States'){
			$USA_checked = 'checked';
		}else{
			$USA_checked = '';
		}
		if($country == 'Canada'){
			$Canada_checked = 'checked';
		}else{
			$Canada_checked = '';
		}
		if($country == 'Gulf'){
			$middle_east_checked = 'checked';
		}else{
			$middle_east_checked = '';
		}*/
		
		
		//$data['progress']= "<div data-delay='300' class='xs-16 xxl-10 xl-10 l-10 m-16 s-16  margin-top-5px  animated'><div class='panel panel-primary'><div class='panel-heading'><h3 id='panel-title' class='panel-title text-center'>SELECT COUNTRY</h3></div><div class='panel-body'> <div class='table-responsive'><table class='table table-striped'><thead><tr><th scope='row'><input type='radio'  id='member_demo-1' class='radio' name='country' class='country' value='All' $all_checked><label for='member_demo-1'> Worldwide</label> </th><th id='count_all' scope='row'>$Worldwide</th> <th scope='row' class='hidden-xs'><input id='member_demo-2' class='radio' type='radio' name='country' class='country' value='Pakistan' $Pakistan_checked> <label for='member_demo-2'>Pakistan</label> </th> <th scope='row' class='hidden-xs' id='count_pakistan'>$Pakistan</th></tr></thead><thead><tr><th scope='row'><input type='radio' id='member_demo-3' class='radio' name='country' class='country' value='India' $India_checked> <label for='member_demo-3'> India</label> </th><th id='count_india'>$India</th><th scope='row' class='hidden-xs'><input id='member_demo-4' class='radio' type='radio' name='country' class='country' value='Others' $Others_checked><label for='member_demo-4'> All Others</label> </th><th id='count_others' scope='row' class='hidden-xs'>$Others</th></tr></thead> <thead><tr><th scope='row'><input type='radio' id='member_demo-5' class='radio' name='country' class='country' value='Australia' $Australia_checked><label for='member_demo-5'> Australia</label></th> <th scope='row' id='count_australia'>$Australia</th><th scope='row' class='hidden-xs'><input id='member_demo-6' class='radio' type='radio' name='country' class='country' value='United Kingdom' $UK_checked><label for='member_demo-6'> UK </label></th><th id='count_uk' scope='row' class='hidden-xs'> $UK </th></tr></thead><thead> <tr><th scope='row'><input type='radio' id='member_demo-7' class='radio' name='country' class='country' value='United States' $USA_checked><label for='member_demo-7'> USA</label> </th> <th id='count_usa'>$USA</th><th scope='row' class='hidden-xs'><input type='radio' id='member_demo-8' class='radio' name='country'  class='country' value='Gulf' $middle_east_checked><label for='member_demo-8'> Middle East</label> </th> <th class='hidden-xs' id='count_gulf'> $middle_east</th></tr></thead><thead><tr><th scope='row'><input type='radio' id='member_demo-10' class='radio' name='country'  class='country' value='Canada' $Canada_checked><label for='member_demo-10'> Canada</label> </th> <th id='count_canada'>$Canada</th> </tr> </thead><tbody></tbody></table> </div></div></div></div>";
		$data['status'] = 'success';
		$data['tocken'] = $this->security->get_csrf_hash();
		return $data; 
	}
	
	public function gender_data_country_wise($gender)
	{	
		if($gender == 'Both'){
			$Both_checked = 'checked';
		}else{
			$Both_checked = '';
		}
		if($gender == 'Male'){
			$Male_checked = 'checked';
		}else{
			$Male_checked = '';
		}
		if($gender == 'Female'){
			$Female_checked = 'checked';
		}else{
			$Female_checked = '';
		}
		$male = $this->demograph_model->demograph_data('Male','All','All');
		$female = $this->demograph_model->demograph_data('Female','All','All');
		$both = $this->demograph_model->demograph_data('Both','All','All');
		
		$data['progress']= "<div data-delay='100' class='xs-16 xxl-6 xl-6 l-6 m-16 s-16 margin-top-5px text-center animated'> <div class='service-sec'>	<div class='panel panel-primary' style='height:254px;'> <div class='panel-heading'> <h3 id='panel-title' class='panel-title'> SELECT GENDER<a class='anchorjs-link' href='#panel-title'> </a> </h3></div> <div class='panel-body'> <div class='table-responsive'> <table class='table table-striped'> <tbody><tr> <th scope='row'><input type='radio' name='radio' id='radio1' class='radio' value='Male' $Male_checked/> <label for='radio1'>Male</label> </th> <td id='count_male'>$male</td></tr> <tr> <th scope='row'><input type='radio' name='radio' id='radio2' class='radio' value='Female' $Female_checked/> <label for='radio2'>Female</label></th> <td id='count_female'>$female</td></tr><tr> <th scope='row'><input type='radio' name='radio' id='radio4' class='radio' value='Both' $Both_checked/> <label for='radio4'>Both</label></th><td id='count_both'>$both</td></tr></tbody></table></div></div></div></div></div>";
			
		$data['status'] = 'success';
		$data['tocken'] = $this->security->get_csrf_hash();
		return $data; 
		
	}
	
	function in_array_r($needle, $haystack, $strict = false) 
	{
		foreach ($haystack as $item) 
		{
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
				return true;
			}
		}
		return false;
	}
}