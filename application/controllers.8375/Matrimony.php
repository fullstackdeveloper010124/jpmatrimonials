<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Matrimony extends CI_Controller {
    public $data = array();
	function __construct()
    {
        parent::__construct();
        $this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;		
		$this->common_model->limit_per_page=5;
		$this->common_front_model->last_member_activity();
		$this->load->model('front_end/Matrimony_model');
    }
	public function index()
	{
		$is_login = $this->common_front_model->checkLogin('return');
		$gender = $this->common_front_model->get_session_data('gender');

		$data["gender_check"] = $gender;
		$gender_check_male="Male";
		$gender_check_female="Female";
		$data["matrimony_data_grrom_home"]=$this->Matrimony_model->member_data_list($gender_check_male);
		$data["matrimony_data_bride_home"]=$this->Matrimony_model->member_data_list($gender_check_female);
		$data["matrimony_cnt12"]=$this->Matrimony_model->member_data_count();

		$data["matrimony_name_list_religion"]=$this->Matrimony_model->community_name_list('Religion');
		$data["matrimony_name_list_caste"]=$this->Matrimony_model->community_name_list('Caste');
		$data["matrimony_name_list_mtong"]=$this->Matrimony_model->community_name_list('Mother-Tongue');
		$data["matrimony_name_list_country"]=$this->Matrimony_model->community_name_list('Country');
		$data["matrimony_name_list_state"]=$this->Matrimony_model->community_name_list('State');
		$data["matrimony_name_list_city"]=$this->Matrimony_model->community_name_list('City');
		
		$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/chosen.css','css/popup_user.css');
		$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/photo_protect_js.js','js/chosen.jquery.js');
		$this->common_model->front_load_header_matrimony();
		$this->load->view('front_end/community',$data);
		$this->common_model->front_load_footer();
	}
	function community_data($matrimony_name="",$page=1)
	{
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		$data_divide = 'Female';
		if($this->input->post('data_divide') && $this->input->post('data_divide') !='')
		{
			$data_divide = $this->input->post('data_divide');
		}	
		
		if($this->input->post('page_number') && $this->input->post('page_number') !='')
		{
			$page = $this->input->post('page_number');
		}
		//$matrimony=explode("-matrimony",$matrimony_name);
		//$matrimony_name=$matrimony[0];
		$gender = $this->common_front_model->get_session_data('gender');
		
		$data["page"] = $page;
		$data["base_url"] = $this->base_url;
		$data["gender_check"] = $gender;
		$data["matrimony_data"]=$this->Matrimony_model->community_data_list($matrimony_name);
		

		$data["data_row_matri_bride"]=$this->Matrimony_model->community_data_bride($data["matrimony_data"],$page);
		$data["data_row_matri_bride_count"]=$this->Matrimony_model->community_data_bride_count($data["matrimony_data"]);

		$data["data_row_matri_groom"]=$this->Matrimony_model->community_data_groom($data["matrimony_data"],$page);
		$data["data_row_matri_groom_count"]=$this->Matrimony_model->community_data_groom_count($data["matrimony_data"]);

		$data["matrimony_cnt"]=$this->Matrimony_model->community_data_count($matrimony_name);
		$data["match_member_result"]=$this->Matrimony_model->community_data_count($matrimony_name);
		
		$data["matrimony_name_list_religion"]=$this->Matrimony_model->community_name_list('Religion');
		$data["matrimony_name_list_caste"]=$this->Matrimony_model->community_name_list('Caste');
		$data["matrimony_name_list_mtong"]=$this->Matrimony_model->community_name_list('Mother-Tongue');
		$data["matrimony_name_list_country"]=$this->Matrimony_model->community_name_list('Country');
		$data["matrimony_name_list_state"]=$this->Matrimony_model->community_name_list('State');
		$data["matrimony_name_list_city"]=$this->Matrimony_model->community_name_list('City');
		if($is_ajax == 0)
		{
			$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/chosen.css','css/popup_user.css');
			$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/common.js','js/slider.js','js/photo_protect_js.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js');
			$this->common_model->front_load_header_matrimony($data["matrimony_data"]);
			
			$this->load->view('front_end/community',$data);
			$this->common_model->front_load_footer();
		}
		else
		{
			if($data_divide == 'Female')
			{
				$this->load->view('front_end/community_data_view_female',$data);
			}
			else
			{
				$this->load->view('front_end/community_data_view_male',$data);	
			}
		}
	}
}
?>