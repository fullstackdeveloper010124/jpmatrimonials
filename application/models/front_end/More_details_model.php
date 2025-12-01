<?php defined('BASEPATH') OR exit('No direct script access allowed');
class More_details_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function page_name_list($page_name,$page=1,$limit=0)
	{
		$where_arra = array("status"=>"APPROVED","search_type"=>$page_name);
		//print_r($where_arra);exit;
		$data_cnt = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,2,'id,matrimony_name,slug','id DESC');
		//echo $this->db->last_query();
		return $data_cnt;
	}
	function community_name_list($search_type,$page=1,$limit=10)
	{
		$where_arra = array("status"=>"APPROVED","search_type"=>$search_type);
		$matrimony_name_data = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,2,'matrimony_name,slug','id DESC',$page,$limit);
		return $matrimony_name_data;
	}
}
?>