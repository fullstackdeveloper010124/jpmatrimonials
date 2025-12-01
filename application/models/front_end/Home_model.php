<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Member_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

	function success_story_list_model($status ='APPROVED')
	{
		$where_success_story= " ( is_deleted ='No' )";
$success_story_arr = $this->common_model->get_count_data_manual('success_story',$where_success_story,6,'	weddingphoto,weddingphoto_type,bridename,brideid,groomname,groomid,marriagedate,successmessage,created_on,is_deleted','','','',"");

			foreach($success_story_arr as $success_story_arr)
			{				
				$mobile_ddr.= '<option value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].' ('.$country_code_arr['country_name'].')'.'</option>';
			}
	}
}