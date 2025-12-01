<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	function update_percentage_slider_field()
	{
		$member_id = $this->common_front_model->get_user_id();
		$val = $_POST['val'];
		$field = $_POST['field'];
		 
		/*echo $member_id;
		echo $val;
		echo $field;
		exit();*/
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
			$where_arra=array('id'=>$member_id);
			$data_array = array($field =>$val);
			$response = $this->common_model->update_insert_data_common('register',$data_array,$where_arra);
			$return_message = "Your request for member blocking is successfully done.";
			$status = "success";
			$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
			return ($return_arr);
			/*$data1 = json_decode($response, true);
			if(isset($data1['status']) && $data1['status'] =='success')
			{
				$data1['errmessage'] =  "<i class='fa fa-check text-success'></i> Your profile has been updated successfully.";
				$data1['status'] = 'success';
			}*/
		}
		
	}
}