<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Blog extends CI_Controller {
	function __construct()
    {
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
    }
	public function index($page=1)
	{
		$this->common_model->limit_per_page = 4;
		if($page == 'index'){ $page = 1 ;}
		$blog_data = '';
		$title = 'Blog Listing';
		$this->data = $this->common_model->data;
		$data_count = $this->common_model->get_count_data_manual('blog_master',array('status'=>'APPROVED'),0);
		if($page =='' || $page ==0 || is_nan($page))
		{
			$page = 1;
		}
		$blog_data = $this->common_model->get_count_data_manual('blog_master',array('status'=>'APPROVED'),2,'*','id desc',$page);
		$this->data['blog_data_count'] = $data_count;
		$this->data['blog_data'] = $blog_data;
		$is_ajax = 0;
		if(isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] !='' && $_REQUEST['is_ajax'] == 1)
		{
			$is_ajax = $_REQUEST['is_ajax'];	
		}
		$this->data['is_ajax'] = $is_ajax;
		if($is_ajax == 0)
		{
			$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Blog'),1,'*','','');
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
			$this->common_model->front_load_header('Blog Listing','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		}
		$this->load->view('front_end/blog_listing',$this->data);
		
		if($is_ajax == 0)
		{
			$this->common_model->front_load_footer();
		}
	}
	// changes for shakil 18-12-2020
	public function detail($alias='')
	{
		if($alias =='')
		{
			redirect(base_url().'blog/index/1');
		}
		$alias = str_replace('_','-',$alias);
		$alias = urldecode($alias);
		$title = 'Blog Detail';
		$blog_data = $this->common_model->get_count_data_manual('blog_master',array('status'=>'APPROVED','alias'=>$alias),1);
		if(isset($blog_data) && $blog_data !='' && count($blog_data) > 0)
		{
			if(isset($blog_data['title']) && $blog_data['title'] !='')
			{
				$title = $blog_data['title'];
			}
		}
		else
		{
			redirect(base_url().'blog/index/1');
		}
		$seo_data = $this->common_model->get_count_data_manual('blog_master',array('status'=>'APPROVED','title'=>$title),1,'*','','');
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
			//$this->common_model->front_load_header($title,'',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->data = $this->common_model->data;
			$this->common_model->front_load_header($title,'',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->data['blog_data'] = $blog_data;
		$this->load->view('front_end/blog_details',$this->data);
		$this->common_model->front_load_footer();
	}
	// public function detail($alias='')
	// {
	// 	if($alias =='')
	// 	{
	// 		redirect(base_url().'blog/index/1');
	// 	}
	// 	$alias = str_replace('_','-',$alias);
	// 	$alias = urldecode($alias);
	// 	$title = 'Blog Detail';
	// 	$blog_data = $this->common_model->get_count_data_manual('blog_master',array('status'=>'APPROVED','alias'=>$alias),1);
	// 	if(isset($blog_data) && $blog_data !='' && count($blog_data) > 0)
	// 	{
	// 		if(isset($blog_data['title']) && $blog_data['title'] !='')
	// 		{
	// 			$title = $blog_data['title'];
	// 		}
	// 	}
	// 	else
	// 	{
	// 		redirect(base_url().'blog/index/1');
	// 	}
	// 	$this->data = $this->common_model->data;
	// 	$this->common_model->front_load_header($title);
	// 	$this->data['blog_data'] = $blog_data;
	// 	$this->load->view('front_end/blog_details',$this->data);
	// 	$this->common_model->front_load_footer();
	// }
	function _remap($method, $params=array())
	{
		$funcs = get_class_methods($this);
	    if(in_array($method, $funcs))
		{
    	    return call_user_func_array(array($this, $method), $params);
	    }
		else
		{
			$this->detail($method);
		}
	}
}