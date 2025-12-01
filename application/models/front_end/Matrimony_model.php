<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Matrimony_model extends CI_Model{
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		
	}
	
	function community_data_count($matrimony_name)
	{
		$matrimony_name1 = str_replace('-',' ',$matrimony_name);
		$where_arra = array("status"=>"APPROVED","slug"=>"$matrimony_name1");
		$data_cnt = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,0);
		return $data_cnt;
	}
	function community_data_list($matrimony_name,$page=1,$limit=1)
	{
		$matrimony_name1 = str_replace('-',' ',$matrimony_name);
		$where_arra = array("status"=>"APPROVED","slug"=>"$matrimony_name1");
		$data_row = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,2,'*','id DESC',$page,$limit);
		return $data_row;
	}
	function community_data_list_id($matrimony_name,$page=1,$limit=1)
	{
		$matrimony_name1 = str_replace('-',' ',$matrimony_name);
		$where_arra = array("status"=>"APPROVED","slug"=>"$matrimony_name1");
		$data_id = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,2,'id','id DESC',$page,$limit);
		return $data_id;
	}
	function member_data_count()
	{
		$where_arra = array("status"=>"APPROVED");
		$data_cnt = $this->common_model->get_count_data_manual("register_view",$where_arra,0);
		return $data_cnt;	
	}
	function member_data_list($gender,$page=1,$limit=5)
	{
		$where_arra = array("gender"=>$gender);
		$data_row = $this->common_model->get_count_data_manual("register_view",$where_arra,2,'*','matri_id DESC',$page,$limit);
		//echo $this->db->last_query();
		return $data_row;
	}
	
	function community_data_bride($data=array(),$page='')
	{
		$data_row_matri_bride = array();
		//echo $page;
		if(isset($data) && $data!='' && count($data)> 0)
		{
			foreach($data as $matrimony_data_last) 
			{	
				$matriidbride=explode(",",$matrimony_data_last['matri_id_bride']);
				$where_arra=array();
				$this->db->where_in("matri_id",$matriidbride);
				$data_row_matri_bride = $this->common_model->get_count_data_manual("register_view",$where_arra,2,'*','matri_id DESC',$page,5);
				//echo $this->common_model->last_query();
			}
		}
		return $data_row_matri_bride;
	}
	function community_data_bride_count($data=array())
	{
		$data_row_matri_bride_count = array();
		if(isset($data) && $data!='' && count($data)> 0)
		{
			foreach($data as $matrimony_data_last) 
			{	
				$matriidbride=explode(",",$matrimony_data_last['matri_id_bride']);
				$where_arra=array();
				$this->db->where_in("matri_id",$matriidbride);
				$data_row_matri_bride_count = $this->common_model->get_count_data_manual("register_view",$where_arra,0,'*','matri_id DESC');
			}
		}
		return $data_row_matri_bride_count;
	}

	function community_data_groom($data=array(),$page=1)
	{
		$data_row_matri_groom = array();
		if(isset($data) && $data!='' && count($data)> 0)
		{
			foreach($data as $matrimony_data_last) 
			{	
				$matriidgroom=explode(",",$matrimony_data_last['matri_id_groom']);
				$where_arra=array();
				$this->db->where_in("matri_id",$matriidgroom);
				$data_row_matri_groom = $this->common_model->get_count_data_manual("register_view",$where_arra,2,'*','matri_id DESC',$page,5);
			}
		}
		return $data_row_matri_groom;
	}
	function community_data_groom_count($data=array())
	{
		$data_row_matri_groom_count = array();
		if(isset($data) && $data!='' && count($data)> 0)
		{
			foreach($data as $matrimony_data_last) 
			{	
				$matriidgroom=explode(",",$matrimony_data_last['matri_id_groom']);
				$where_arra=array();
				$this->db->where_in("matri_id",$matriidgroom);
				$data_row_matri_groom_count = $this->common_model->get_count_data_manual("register_view",$where_arra,0,'*','matri_id DESC');
			}
		}
		return $data_row_matri_groom_count;
	}

	function community_name_list($search_type,$page=1,$limit=10)
	{
		$where_arra = array("status"=>"APPROVED","search_type"=>$search_type);
		//print_r($where_arra);exit;
		$matrimony_name_data = $this->common_model->get_count_data_manual("matrimony_data",$where_arra,2,'matrimony_name,pagename,slug','id DESC',$page,$limit);
		//echo $this->common_model->last_query();exit;
		// print_r($matrimony_name_data);exit;
		return $matrimony_name_data;
	}
	// function ratting_count($matrimony_name='')
	// {
	// 	$where_arra = array("status"=>"Y","c_page_name"=>$matrimony_name);
	// 	$ratting_cnt = $this->Common_model->get_count_data_manual("admin_rating",$where_arra,0);
	// 	return $ratting_cnt;
	// }
	// function ratting_list($matrimony_name,$page)
	// {
	// 	$limit=5;
	// 	$where_arra = array("status"=>"Y","c_page_name"=>$matrimony_name);
	// 	$ratting_list_data = $this->Common_model->get_count_data_manual("admin_rating",$where_arra,2,'*','date DESC',$page,$limit);
	// 	//echo $this->db->last_query();
	// 	return $ratting_list_data;
	// }
	
	// function ratting_avg($matrimony_name='')
	// {
	// 	$this->db->where("status","Y");
	// 	$this->db->where("c_page_name",$matrimony_name);
	// 	$this->db->select_avg('rating');
	// 	$result = $this->db->get('admin_rating')->row();  
	// 	return $result->rating;
	// }
	
	// function ratting_tot($matrimony_name,$page=1,$limit=1)
	// {
	// 	$where_arra = array("status"=>"Y","c_page_name"=>$matrimony_name);
	// 	$ratting_list_data = $this->Common_model->get_count_data_manual("rating_total",$where_arra,2,'*','',$page,$limit);
	// 	//echo $this->db->last_query();
	// 	return $ratting_list_data;
	// }
	// function ratting_sum($matrimony_name='')
	// {
	// 	$this->db->where("status","Y");
	// 	$this->db->where("c_page_name",$matrimony_name);
	// 	$this->db->select_sum('rating');
	// 	$result = $this->db->get('admin_rating')->row();  
	// 	return $result->rating;
	// }
	// function disp_review_str($rating_vendor=0)
	// {
	// 	$whole = floor($rating_vendor);
	// 	$fraction = $rating_vendor - $whole;
	// 	$rating_vendor = number_format($rating_vendor,2);
	// 	$str_review = '';
	// 	for($ir= 1;$ir<=$whole;$ir++)
	// 	{
	// 		$str_review = $str_review.'<i title="'.$rating_vendor.' Rating" class="fa fa-star" aria-hidden="true"></i>';
	// 	}
		
	// 	if($fraction > 0)
	// 	{
	// 		$str_review = $str_review.'<i title="'.$rating_vendor.' Rating" class="fa fa-star-half-o" aria-hidden="true"></i>';
	// 		$ir++;
	// 	}
	// 	for($ir1= $ir;$ir1<=5;$ir1++)
	// 	{
	// 		$str_review = $str_review.'<i title="'.$rating_vendor.' Rating" class="fa fa-star-o" aria-hidden="true"></i>';
	// 	}
	// 	return $str_review;
	// }
}
?>