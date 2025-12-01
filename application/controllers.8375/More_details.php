<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class More_details extends CI_Controller {
	public $data = array();
	function __construct(){
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/More_details_model');
		$this->load->model('front_end/Matrimony_model');
	}
	public function index(){	

	}
	function community_page_list($page_name=""){
		//print_r($page_name); exit;

		$is_login = $this->common_front_model->checkLogin('return');
		$gender = $this->common_front_model->get_session_data('gender');
		$data["gender_check"] = $gender;
		//if (isset($page_name) && $page_name !='') {
			# code...
		
		$data["page_list_community"]=$this->More_details_model->page_name_list($page_name);
		//print_r($data["page_list_community"]); exit;
		if (isset($data["page_list_community"]) && $data["page_list_community"] !='') {
		$data["matrimony_name_list_religion"]=$this->Matrimony_model->community_name_list('Religion');
		
		$data["matrimony_name_list_caste"]=$this->Matrimony_model->community_name_list('Caste');
		$data["matrimony_name_list_mtong"]=$this->Matrimony_model->community_name_list('Mother-Tongue');
		$data["matrimony_name_list_country"]=$this->Matrimony_model->community_name_list('Country');
		$data["matrimony_name_list_state"]=$this->Matrimony_model->community_name_list('State');
		$data["matrimony_name_list_city"]=$this->Matrimony_model->community_name_list('City');
		$data["page_name"] = $page_name;
		
		$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/chosen.css');
		$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/chosen.jquery.js');

		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>$page_name),1,'*','','');
		//$this->common_model->extra_css_fr= array('css/select2.min.css');
		//$this->common_model->css_extra_code_fr.='';
		$seo_title='';
		$seo_description ='';
		$seo_keywords='';
		$og_title = '';
		$og_description = '';
		$og_image = '';
		if(isset($seo_data['seo_title']) && $seo_data['seo_title'] !='')
		{
			$seo_title = $seo_data['seo_title'];
		}
		if(isset($seo_data['seo_description']) && $seo_data['seo_description'] !='')
		{
			$seo_description = $seo_data['seo_description'];
		}
		if(isset($seo_data['seo_keywords']) && $seo_data['seo_keywords'] !='')
		{
			$seo_keywords = $seo_data['seo_keywords'];
		}
		if(isset($seo_data['og_title']) && $seo_data['og_title'] !='')
		{
			$og_title = $seo_data['og_title'];
		}
		if(isset($seo_data['og_description']) && $seo_data['og_description'] !='')
		{
			$og_description = $seo_data['og_description'];
		}
		if(isset($seo_data['og_image']) && $seo_data['og_image'] !='')
		{
			$og_image = $seo_data['og_image'];
		}

	$this->common_model->front_load_header_matrimony('',$title,'',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		//$this->common_model->front_load_header();
		
		$this->load->view('front_end/more_details',$data);
		$this->common_model->front_load_footer();
	}
	else
	{
		redirect($this->base_url);
	}
	}
}
?>