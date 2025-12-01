<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Matches extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/matches_model');
		$this->load->model('front_end/search_model');
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
	}
	## New Code : Date : 11-10-2021
	public function recommended(){
		$this->index('recommended');
	}
	## New Code : Date : 11-10-2021
	public function premium_match(){
		$this->index('premium-match');
	}
	## New Code : Date : 11-10-2021
	public function near_by_me(){
		$this->index('near-by-me');
	}
	public function index($match_type = 'recommended')
	{	$this->data['page_name'] = 'matches';
		$this->common_model->display_top_menu_perm ='No';
		$this->common_model->extra_css_fr= array('css/select2.css','css/chosen.css','css/popup_user.css');
		$this->common_model->extra_js_fr= array('js/select2.min.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/photo_protect_js.js');
		$this->common_model->front_load_header();
		$this->data['match_type'] = $match_type;
		$this->load->view('front_end/matches',$this->data);
		$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function save_matches()
	{	
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$response = $this->matches_model->save_matches($is_post);
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$response);
		}
		else
		{		
			redirect($this->base_url.'matches');
		}
	}
	public function search_now($page=1)
	{	
		$this->data['page_name'] = 'matches';
		$member_id = $this->common_front_model->get_user_id();
		if(isset($member_id) && $member_id!='')
		{
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
			$this->data['member_total_count'] = $this->matches_model->get_search_count();
			$this->data['member_data'] = $this->matches_model->get_search_result($page);			
			$member_data = $this->data['member_data'];
			$member_total_count =$this->data['member_total_count'];
			
			if($user_agent !='NI-WEB')
			{
				$data1['continue_request'] = TRUE;
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				$data1['total_count'] = $member_total_count;
				if(isset($member_data) && $member_data!='' && $member_total_count>0)
				{
					$data1['errormessage'] = 'Total Result found('.$member_total_count.')';
					$data1['errmessage'] = 'Total Result found('.$member_total_count.')';
					$data1['data'] = $this->common_front_model->process_data_app($member_data);
					//$data1['data'] = $member_data;
				}
				else
				{
					$data1['data'] = array();
					$data1['continue_request'] = FALSE;
				}
				$data['data'] = json_encode($data1);
				$this->load->view('common_file_echo',$data);
			}
			else
			{
				$this->load->view('front_end/match_result_member_profile',$this->data);
			}
		}
		else
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errmessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
	}
	
	public function received_match_from_admin($page=1)
	{
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		$this->data['page_name'] = 'admin-matches';
		// for web API
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$member_data = $this->matches_model->received_match_from_admin($page);
			$member_data_count = $this->matches_model->received_match_from_admin_count();
			
			$data1['continue_request'] = TRUE;
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['total_count'] = $member_data_count;
			if(isset($member_data) && $member_data!='' && $member_data_count > 0)
			{
				$data1['errormessage'] = 'Total Result found('.$member_data_count.')';
				$data1['errmessage'] = 'Total Result found('.$member_data_count.')';
				$data1['data'] = $this->common_front_model->process_data_app($member_data);
				//$data1['data'] = $member_data;
			}
			else
			{
				$data1['errormessage'] = 'No data found';
				$data1['errmessage'] = 'No data found';
				$data1['data'] = '';
				$data1['continue_request'] = FALSE;
			}
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
			
		}else{
			
			$this->data['member_total_count'] = $this->matches_model->received_match_from_admin_count();
			$this->data['member_data'] = $this->matches_model->received_match_from_admin($page);
			if($is_ajax == 0)
			{
				$this->common_model->display_top_menu_perm ='No';
				$this->common_model->extra_css_fr= array('css/select2.css','css/popup_user.css');
				$this->common_model->extra_js_fr= array('js/photo_protect_js.js','js/select2.min.js');
				$this->common_model->front_load_header('Recommended Match');
				$this->load->view('front_end/received_match_from_admin',$this->data);
				$this->load->view('front_end/photo_protect',$this->data);
				$this->common_model->front_load_footer();
			}
			else
			{
				$this->load->view('front_end/received_match_result_from_admin',$this->data);
			}
		}
	}
}