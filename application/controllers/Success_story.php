<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Success_story extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/success_story_model');
		$this->common_front_model->last_member_activity();
	}	
	public function index($page=1)
	{	
		$data['base_url']=$this->data['base_url'];
	
		$this->common_model->limit_per_page = '3';
		if ($this->input->post('page') != '') {
			$page=$this->input->post('page');
		}
		$where_arra = array('is_deleted'=>'No','status'=>'APPROVED');
		$this->data['success_story'] = $this->common_model->get_count_data_manual('success_story',$where_arra,2,'*','id desc',$page,'','','');
		$this->data['success_story_data_count'] = $this->common_model->get_count_data_manual('success_story',$where_arra,0,'id');

		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent !='NI-WEB'){
			$data1['continue_request'] = TRUE;
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['total_count'] = $this->data['success_story_data_count'];
			if(isset($this->data['success_story']) && $this->data['success_story']!='' && $this->data['success_story_data_count']>0)
			{
				$data1['errormessage'] = 'Total Result found('.$this->data['success_story_data_count'].')';
				$data1['errmessage'] = 'Total Result found('.$this->data['success_story_data_count'].')';
				$data1['data'] = $this->data['success_story'];
				$data1['weddingphotoUrl'] = $this->common_model->base_url.$this->common_model->path_success;
			}
			else
			{
				$data1['data'] = array();
				$data1['continue_request'] = FALSE;
			}
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}else{
			$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Success Story'),1,'*','','');
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
			$this->common_model->front_load_header('Success Stories','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
			$this->load->view('front_end/success_story_listing',$this->data);
			$this->common_model->front_load_footer();
		}
	}
	public function details($id='',$groomname='',$bridename='')
	{	
		if ($this->input->post('id')!='') {
			$id = $this->common_model->descrypt_id($this->input->post('id'));
		}else{
			$id = $this->common_model->descrypt_id($id);
		}
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent !='NI-WEB'){
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['data'] = array();
			$data1['errormessage'] = 'Result Not found';
			$data1['errmessage'] = 'Result Not found';
			if($id!='')
			{	
				$where_success_story=array(" (id ='".$id."')",'status'=>'APPROVED');
				$success_story_arr = $this->common_model->get_count_data_manual('success_story',$where_success_story,1,'id,weddingphoto,weddingphoto_type,bridename,groomname,marriagedate,successmessage,created_on','','','',"");
				if(isset($success_story_arr) && $success_story_arr !='' && is_array($success_story_arr) && count($success_story_arr) > 0)
				{
					$data1['status'] = 'success';
					$data1['errormessage'] = 'Success Story Result found';
					$data1['errmessage'] = 'Success Story Result found';
					$data1['data'] = $success_story_arr;
				}
			}
			$data1['weddingphotoUrl'] = $this->common_model->base_url.$this->common_model->path_success;
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}else{
			if($id!='')
			{	
				$where_success_story=array(" (id ='".$id."')",'status'=>'APPROVED');
				$success_story_arr = $this->common_model->get_count_data_manual('success_story',$where_success_story,1,'id,weddingphoto,weddingphoto_type,bridename,groomname,marriagedate,successmessage,created_on','','','',"");
				
				if(isset($success_story_arr) && $success_story_arr !='' && is_array($success_story_arr) && count($success_story_arr) > 0)
				{
					$seo_data = $this->common_model->get_count_data_manual('success_story',array('status'=>'APPROVED','id'=>$id),1,'*','','');
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
				
					$success_story_data['success_story_item']= $success_story_arr;
					//$this->common_model->front_load_header('Success Story Details');
					$this->common_model->front_load_header($title,'',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
					$this->load->view('front_end/success_story_details',$success_story_data);
					$this->common_model->front_load_footer();
				}
				else
				{
					redirect($this->common_model->base_url.'success_story');
				}
			}
			else
			{
				
				redirect($this->common_model->base_url.'success_story');
			}
		}
	}

	public function add_story()
	{	
		$this->common_model->extra_css_fr= array('css/date-picker.css');
		$this->common_model->extra_js_fr= array('js/date-picker.js','js/jquery.validate.min.js','js/additional-methods.min.js');

		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Add Story'),1,'*','','');
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
		$this->common_model->front_load_header('Submit Success Story','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/add_success_story',$this->data);
		$this->common_model->front_load_footer();
	}
	public function check_bride_groom()
	{	
		$this->success_story_model->check_bride_groom();
	}
	public function save_story()
	{
	   $this->success_story_model->add_success_story();
	}
}