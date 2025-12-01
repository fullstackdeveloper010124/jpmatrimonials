<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Cms extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
	}
	public function index($page_title='about-us')
	{
		$cms_pages_data = '';
		if($page_title !='')
		{
			$cms_pages_data = $this->common_model->get_count_data_manual('cms_pages',array('page_url'=>$page_title,'status'=>'APPROVED'),1);
		}
		$this->common_cms_page($cms_pages_data);
	}
	public function terms_condition()
	{
		$this->about_us('Terms and Condition');
	}
	public function faq()
	{
		//$this->common_model->extra_css_fr= array('css/fontello.css','css/bootstrap.min.css');
		//$this->common_model->extra_css_fr= array('css/fontello.css','css/bootstrap.min.css');
		$where_array = "(page_title ='FAQ page' and status='APPROVED' and is_deleted ='No')";
		$cms_pages_data = $this->common_model->get_count_data_manual('cms_pages',$where_array,1);
		$title = '';
		if(isset($cms_pages_data['page_title']) && $cms_pages_data['page_title'] !='')
		{
			$title = $cms_pages_data['page_title'];
		}

		$seo_title = $seo_description = $seo_keywords = '';
		if(isset($cms_pages_data['seo_title']) && $cms_pages_data['seo_title'] !='')
		{
			$seo_title = $cms_pages_data['seo_title'];
		}
		if(isset($cms_pages_data['seo_description']) && $cms_pages_data['seo_description'] !='')
		{
			$seo_description = $cms_pages_data['seo_description'];
		}
		if(isset($cms_pages_data['seo_keywords']) && $cms_pages_data['seo_keywords'] !='')
		{
			$seo_keywords = $cms_pages_data['seo_keywords'];
		}

		$this->common_model->extra_css_fr= array('css/fontello.css');
		$this->common_model->front_load_header($title,'',$seo_title,$seo_description,$seo_keywords);
		$this->load->view('front_end/faq',$this->data);
		$this->common_model->front_load_footer();
	}
	
	public function common_cms_page($cms_pages_data='')
	{
		if($cms_pages_data == '' || count($cms_pages_data) == 0 )
		{
			redirect($this->base_url);
		}
		$this->data['cms_pages']= $cms_pages_data;
		$title = 'Cms Page';
		if(isset($cms_pages_data['page_title']) && $cms_pages_data['page_title'] !='')
		{
			$title = $cms_pages_data['page_title'];
		}
		
		$seo_title = $seo_description = $seo_keywords = $og_title = $og_description = $og_image = '';
		if(isset($cms_pages_data['seo_title']) && $cms_pages_data['seo_title'] !='')
		{
			$seo_title = $cms_pages_data['seo_title'];
		}
		if(isset($cms_pages_data['seo_description']) && $cms_pages_data['seo_description'] !='')
		{
			$seo_description = $cms_pages_data['seo_description'];
		}
		if(isset($cms_pages_data['seo_keywords']) && $cms_pages_data['seo_keywords'] !='')
		{
			$seo_keywords = $cms_pages_data['seo_keywords'];
		}
		if(isset($cms_pages_data['og_title']) && $cms_pages_data['og_title'] !='')
		{
			$og_title = $cms_pages_data['og_title'];
		}
		if(isset($cms_pages_data['og_description']) && $cms_pages_data['og_description'] !='')
		{
			$og_description = $cms_pages_data['og_description'];
		}
		if(isset($cms_pages_data['og_image']) && $cms_pages_data['og_image'] !='')
		{
			$og_image = $cms_pages_data['og_image'];
		}
		
		//$this->common_model->extra_css_fr= array('css/fontello.css');
		$this->common_model->front_load_header($title,'',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/cms_page',$this->data);
		$this->common_model->front_load_footer();
	}
	
	public function about_us($page_title='About Us')
	{
		$cms_pages_data = $this->common_model->get_count_data_manual('cms_pages',array('page_title'=>$page_title,'status'=>'APPROVED'),1);		
		$this->common_cms_page($cms_pages_data);
	}
	public function privacy_policy()
	{		
		$this->about_us($page_title='Privacy Policy');
	}
	public function refund_policy()
	{	
		$this->about_us($page_title='Refund Policy');
	}
	public function report_misuse()
	{	
		$this->about_us($page_title='Report Misuse');
	}
	public function get_cms()
	{
		$this->common_front_model->set_orgin();
		if($this->input->post('cms_name'))
		{
			$cms_name = $this->input->post('cms_name');
		}
		if($cms_name !='')
		{
			$data1 = array();
			$data1['token'] = $this->security->get_csrf_hash();
			
			$cms_pages_data = $this->common_model->get_count_data_manual('cms_pages',array('page_title'=>$cms_name,'status'=>'APPROVED'),1);
			if($cms_pages_data !='' && count($cms_pages_data) > 0)
			{
				$data1['status'] = 'success';			
				$data1['data'] = $cms_pages_data;
			}
			else
			{
				$data1['status'] = 'error';
				$data1['data'] = "No data available";
			}
						
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
	}
}