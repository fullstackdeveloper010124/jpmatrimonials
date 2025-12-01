<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Wedding_vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/contact_model');
		$this->common_front_model->last_member_activity();
		// $this->common_front_model->checkLogin();
	}
	public function index($page=1)
	{	
		if($this->session->userdata('wed_category_id')!=''){
			$this->session->unset_userdata('wed_category_id');
		}
		if($this->session->userdata('wed_city_id')!=''){
			$this->session->unset_userdata('wed_city_id');
		}
		if($this->session->userdata('wed_keyword')!=''){
			$this->session->unset_userdata('wed_keyword');
		}
		$data['base_url']=$this->data['base_url'];
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
	
		$this->common_model->extra_css_fr= array('css/fontello.css','css/style-new.css','css/responsive-new.css','css/select2.css');
		$this->common_model->extra_js_fr= array('js/select2.js');
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Wedding Vendor'),1,'*','','');
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
		$this->common_model->css_extra_code_fr.='.wedding-img {
			height: 220px;
			margin-right: auto;
			margin-left: auto;
		}';
		$this->common_model->front_load_header('Wedding planner','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/vendor_categories',$this->data);
		$this->common_model->front_load_footer();
	}

	public function fetch($page=1){
		$lim = $this->input->post('limit');
		$start = $this->input->post('start');
		$where_arra=array('status'=>'APPROVED');
// 		$this->db->limit($lim, $start);
		$vendor_category = $this->common_model->get_count_data_manual('vendor_category',$where_arra,2,'*','category_position asc','','');
		$output = "";
		if(isset($vendor_category) && $vendor_category!='' && is_array($vendor_category) && count($vendor_category)>0){
			$i=0;
			foreach($vendor_category as $val){
				if($i==0){
					 $output .= '<div class="row">';
				}
				else if($i%4==0){
					 $output .= '</div><div class="row categories-main">';
				}
				$category_image = $this->common_model->no_image_found;
	            if(isset($val['category_image']) && $val['category_image'] !='' && file_exists($this->common_model->path_wedding.$val['category_image'])){
	                $category_image = $this->common_model->path_wedding.$val['category_image'];
	            }
	            $cate_name = $val['slug'];
				$output .= '
				<div class="col-md-3 col-sm-6 col-xs-6">
					<div class="categories-box">
						<a href="'.base_url().'vendor/'.$cate_name.'-providers"><img src="'.base_url().$category_image.'">
						<h3>'.$val['category_name'].'</h3>
					</div>
				</div>';
				if($i == count($vendor_category)-1){
					$output .= '</div>';
				}
				$i++;
			}
		}
		$data1['data'] = json_encode($output);
		$this->load->view('common_file_echo',$data1);
	}
	public function wed_vendor_list($page=1)
	{
		$data['base_url']=$this->data['base_url'];
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		
		$this->common_model->extra_css_fr= array('css/fontello.css','css/style-new.css','css/responsive-new.css','css/select2.css');
		$this->common_model->extra_js_fr= array('js/select2.js');
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>'Wedding Vendor'),1,'*','','');
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
		$this->common_model->css_extra_code_fr.='.wedding-img {
			height: 220px;
			margin-right: auto;
			margin-left: auto;
		}';
		$this->common_model->front_load_header('Wedding planner','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/wed_vendor_list',$this->data);
		$this->common_model->front_load_footer();
	}
	public function fetch_list($page=1){
		$cate_id = "";
		$where_arra = array('status'=>'APPROVED');
		if($this->input->post('cate_name')!=''){
			$category_name = str_replace('-',' ',$this->input->post('cate_name'));
			if(isset($category_name) && $category_name!=''){
				$data_row = $this->common_model->get_count_data_manual("vendor_category",array("status"=>"APPROVED","category_name"=>$category_name),1,'id','id DESC','','','');
				//echo $this->db->last_query();
			}
			if(isset($data_row['id']) && $data_row['id']!=''){
				$c_id = $data_row['id'];
				$where_arra[] = " category_id='".$c_id."' ";
				//print_r($where_arra);
			}
			
		}
		else{
			if($this->session->userdata('wed_category_id')!=''){
				$wed_cate_id = $this->session->userdata('wed_category_id');
				$where_arra[] = " category_id='".$wed_cate_id."' ";
			}
		}
		
		if($this->session->userdata('wed_country_id')!=''){
			$wed_country_id = $this->session->userdata('wed_country_id');
			$where_arra[] = " country_id='".$wed_country_id."' ";
		}
		if($this->session->userdata('wed_state_id')!=''){
			$wed_state_id = $this->session->userdata('wed_state_id');
			$where_arra[] = " state_id='".$wed_state_id."' ";
		}
		if($this->session->userdata('wed_city_id')!=''){
			$wed_city_id = $this->session->userdata('wed_city_id');
			$where_arra[] = " city_id='".$wed_city_id."' ";
		}
		if($this->session->userdata('wed_keyword')!=''){
			$wed_keyword = $this->session->userdata('wed_keyword');
			$where_arra[] = " (category_name LIKE '%".$wed_keyword."%' or  planner_name LIKE '%".$wed_keyword."%' or country_name LIKE '%".$wed_keyword."%' or state_name LIKE '%".$wed_keyword."%' or city_name LIKE '%".$wed_keyword."%' )";
		}
		$lim = $this->input->post('limit');
		$start = $this->input->post('start');
		
		$this->db->limit($lim, $start);
		$vendor_category = $this->common_model->get_count_data_manual('wedd_planner_view',$where_arra,2,'*',"FIELD(plan_status,'Paid') DESC,id desc",'','');
		//echo $this->db->last_query();
		$output = "";
		if(isset($vendor_category) && $vendor_category!='' && is_array($vendor_category) && count($vendor_category)>0){
			$i=0;
			foreach($vendor_category as $val){
				if($i==0 && $start==0){
					 $output .= '<div class="wedding-planner-right-box">';
				}
				else if($i!=0){
					 $output .= '</div><div class="wedding-planner-right-box margin-top-20">';
				}
				else if($start!=0){
					$output .= '</div><div class="wedding-planner-right-box margin-top-20">';
				}
				$wedimage = $this->common_model->no_image_found;
	            if(isset($val['image']) && $val['image'] !='' && file_exists($this->common_model->path_wedding.$val['image'])){
	                $wedimage = $this->common_model->path_wedding.$val['image'];
	            }
	            $vendor_id = $val['id'];
	            $where_arra_reviews=array('vendor_id'=>$vendor_id,'is_deleted'=>'No','status'=>'APPROVED');
	            $vendor_review_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,0,'*','id desc','');
	            if($vendor_review_count > 0){
	            	$vendor_review_data = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,1,'sum(r_star) as total_reviews_count','id desc','');
					$total = $vendor_review_count*5;
					$average = $vendor_review_data['total_reviews_count']/$total*5;
	            }
	            else{
					$average = 0;
				}
				if(isset($vendor_review_count) && $vendor_review_count>0){
					if($average > 0 && $average <= 1.5){
						$star = '<i class="fa fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>';
					}
					else if($average > 1.5 && $average <= 2.5){
						$star = '<i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>';
					}
					else if($average > 2.5 && $average <= 3.5){
						$star = '<i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>';
					}
					else if($average > 3.5 && $average <= 4.5){
						$star = '<i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="far fa-star"></i>';
					}
					else if($average > 4.5 && $average <= 5){
						$star = '<i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>';
					}else{
						$star = '<i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>';
					}
				}
				else{
					$star = '<i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>
                    <i class="far fa-star"></i>';
				}

				$web_desc = substr(strip_tags($val['description']),'0','120');
				if(strlen($web_desc)>=120){
					$web_desc = $web_desc.'...';
				}
				$mob_desc = substr(strip_tags($val['description']),'0','50');
				if(strlen($mob_desc)>=50){
					$mob_desc = $mob_desc.'...';
				}
				$output .= '<div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-5 col-xs-5 pad-l-0">
                        <div class="fd-img">
                            <a href="'.base_url().'wedding-vendor/details/'.$val['id'].'"><img src="'.base_url().$wedimage.'"></a>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-7 col-xs-7">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 d-margin-top-10 m-pad-right-0">
                                <div class="col-md-9 col-sm-8 col-xs-8 pad-0">
                                    <div class="fd-title">
                                        <h3>'.$val['planner_name'].'</h3>
                                        <h4><i class="fas fa-map-marker-alt"></i> &nbsp;'.$val['country_name'].'</h4>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-4 pad-0">
                                    <div class="fd-review">
                                        <h4>'.$vendor_review_count.' Review</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <span class="rating-wedding-1 fill-star">
                                    '.$star.'
                                </span>
                            </div>
                        </div>
                        <div class="row d-margin-top-10">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="fd-desc">
                                    <p class="hidden-sm hidden-xs">'.$web_desc.'</p>
                                    <p class="hidden-lg hidden-md">'.$mob_desc.'</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-sm-10 col-xs-10">
                                <button type="submit" class="price-request-btn"><a href="'.base_url().'wedding-vendor/details/'.$val['id'].'" class="white-color">View Details</a></button>
                            </div>
                            <div class="col-md-5"></div>
                            <div class="col-md-2 col-sm-1 col-xs-1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
				if($i == count($vendor_category)-1){
					$output .= '</div>';
				}
				$i++;
			}
		}
		$data1['data'] = json_encode($output);
		$this->load->view('common_file_echo',$data1);
	}
	function set_session(){
		if($this->input->post('category_id')!=''){
			$this->session->set_userdata('wed_category_id',$this->input->post('category_id'));
		}
		else{
		    $this->session->unset_userdata('wed_category_id');
		}
		if($this->input->post('city_id')!=''){
			$this->session->set_userdata('wed_city_id',$this->input->post('city_id'));
		}else{
		    $this->session->unset_userdata('wed_city_id');
		}
		if($this->input->post('keyword')!=''){
			$this->session->set_userdata('wed_keyword',$this->input->post('keyword'));
		}else{
		    $this->session->unset_userdata('wed_keyword');
		}
		if ($this->input->post('is_category') == 'Yes') {
			$output['status'] = 'success';
			$data1['data'] = json_encode($output);
			$this->load->view('common_file_echo',$data1);
		}
	}

	
	public function details($id='')
	{	
		if($id !='')
		{	
			$where_wedding_planner= " (id ='".$id."' and status = 'APPROVED' and is_deleted = 'No')";
			$wedding_planner_arr = $this->common_model->get_count_data_manual('wedd_planner_view',$where_wedding_planner,1,'*','','','',"");
			
			if(isset($wedding_planner_arr) && $wedding_planner_arr!= '')
			{
				$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/fontello.css','css/date-picker.css');	
				$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/slider.js','js/date-picker.js','js/jquery.validate.min.js','js/additional-methods.min.js');
				
				$where_arra_reviews=array('vendor_id'=>$id,'is_deleted'=>'No','status'=>'APPROVED');
				$wedding_planner_data['wedding_planner_reviews_count'] = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,0,'*','id desc','');
				
				$wedding_planner_data['wedding_planner_reviews'] = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,2,'*','id desc',''); 
				
				// generate captcha
				$code = rand(100000,999999);
				$this->session->set_userdata('captcha_vendor',$code);
				// generate captcha
				
				$wedding_planner_data['wedding_planner_item']= $wedding_planner_arr;
				$this->common_model->front_load_header('Wedding Planner Details');
				$this->load->view('front_end/vendor_details',$wedding_planner_data);
				$this->common_model->front_load_footer();
			}
			else
			{
				redirect($this->common_model->base_url.'wedding-vendor');
			}
		}
		else
		{
			redirect($this->common_model->base_url.'wedding-vendor');
		}
	}
	public function validate_captcha()
	{	
		if($this->input->post('code_captcha') != $this->session->userdata['captcha_vendor'])
		{
			$this->form_validation->set_message('validate_captcha', 'Wrong captcha code, Please enter valid captcha code');
			return false;
		}else{
			return true;
		}
	}
	public function send_enquiry_to_planner($id_details='')
	{
		if($id_details =='')
		{
			redirect(base_url().'wedding-vendor/index');
		}
		$this->load->model('front_end/contact_model');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$data = $this->contact_model->validate_form_vendor($id_details);
		if($is_post ==0)
		{
			$data1['data'] = json_encode($data);
			$this->load->view('common_file_echo',$data1);
		}
		else
		{
			if($data['status'] =='success')
			{
				$this->session->set_flashdata('email_success_message',$data['errmessage']);
			}
			else
			{
				$this->session->set_flashdata('email_error_message', $data['errmessage']);
			}
			redirect(base_url().'wedding-vendor/details/'.$id_details);
		}
	}
	
	
	public function send_review($id_details='')
	{
		if($id_details =='')
		{
			redirect(base_url().'wedding-vendor/index');
		}
		$this->load->model('front_end/contact_model');
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$data = $this->contact_model->send_review($id_details);
		if($is_post ==0)
		{
			$data1['data'] = json_encode($data);
			$this->load->view('common_file_echo',$data1);
		}
		else
		{
			redirect(base_url().'wedding-vendor/index');
			/*if($data['status'] =='success')
			{
				$this->session->set_flashdata('email_success_message',$data['errmessage']);
			}
			else
			{
				$this->session->set_flashdata('email_error_message', $data['errmessage']);
			}
			redirect(base_url().'wedding-vendor/details/'.$id_details);*/
		}
	}

	public function wedding_vendors_review($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access();
		
		$star_array= array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		
		$ele_array = array(
			'vendor_id'=>array('display_in'=>'2','type'=>'dropdown','relation'=>array('rel_table'=>'wedding_planner','key_val'=>'id','key_disp'=>'planner_name'),'label'=>'Vendor Name','is_required'=>'required',),
			'r_name'=>array('is_required'=>'required','label'=>'Name'),
			'r_email'=>array('is_required'=>'required','label'=>'E-mail'),
			'r_title'=>array('is_required'=>'required','label'=>'Review Title'),
			'r_message'=>array('type'=>'textarea','is_required'=>'required','label'=>'Review Message'),
			'r_star'=>array('display_in'=>'1','type'=>'dropdown','key_val'=>'id','label'=>'Write Review','value_arr'=>$star_array,'value'=>'All','is_required'=>'required',),
			'status'=>array('type'=>'radio')
		);
		
		$other_config = array('default_order'=>'DESC'); 
		
		$join_tab_array = array();
		$join_tab_array[] = array( 'rel_table'=>'wedding_planner', 'rel_filed'=>'id', 'rel_filed_disp'=>'planner_name','rel_filed_org'=>'vendor_id');
		
		$this->common_model->display_selected_field = array('id','status','vendor_id','r_name','r_email','r_title','r_message','r_star');
		
		$this->common_model->common_rander('vendor_reviews', $status, $page , 'Vendors Review',$ele_array,'id',0,$other_config,$join_tab_array);
	}
	public function get_ajax_city()
	{
		$this->load->view('front_end/get_ajax_city');
	}

	public function app_vendor_categories(){
		$data1 = array();
		$data1['token'] = $this->security->get_csrf_hash();
		$data1['category_imageUrl'] = $this->base_url.$this->common_model->path_wedding;
		$where_arra=array('status'=>'APPROVED');
		if($this->input->post('search_keyword')!=''){
			$search_keyword = $this->input->post('search_keyword');
			$where_arra[] = " (category_name LIKE '%".$search_keyword."%' )";
		}
		$vendor_category = $this->common_model->get_count_data_manual('vendor_category',$where_arra,2,'*','category_position asc','','');
		if(isset($vendor_category) && $vendor_category!='' && is_array($vendor_category) && count($vendor_category)>0){
			$data1['status'] = 'success';			
			$data1['data'] = $vendor_category;
		}
		else
		{
			$data1['status'] = 'error';
			$data1['data'] = "No data available";
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function app_vendor_list(){
		$data1 = array();
		$data1['data'] = array();
		$data1['token'] = $this->security->get_csrf_hash();
		$data1['imageUrl'] = $this->base_url.$this->common_model->path_wedding;
		$where_arra=array('status'=>'APPROVED');
		if($this->input->post('wed_category_id')!=''){
			$wed_cate_id = $this->input->post('wed_category_id');
			$where_arra[] = " category_id='".$wed_cate_id."' ";
		}
		$status = 'success';
		if($this->input->post('is_search')=='Yes'){
			$this->load->library('form_validation');
			$this->form_validation->set_rules('wed_category_id', 'Category', 'required');
			$this->form_validation->set_rules('wed_city_id', 'City', 'required');
			
			if ($this->form_validation->run() == FALSE)
	        {
				$errmessage = strip_tags(validation_errors());
				$status = 'error';

			}
			else{
				$status = 'success';
				if($this->input->post('wed_city_id')!=''){
					$wed_city_id = $this->input->post('wed_city_id');
					$where_arra[] = " city_id='".$wed_city_id."' ";
				}
				if($this->input->post('wed_keyword')!=''){
					$wed_keyword = $this->input->post('wed_keyword');
					$where_arra[] = " (category_name LIKE '%".$wed_keyword."%'  or planner_name LIKE '%".$wed_keyword."%' or country_name LIKE '%".$wed_keyword."%' or state_name LIKE '%".$wed_keyword."%' or city_name LIKE '%".$wed_keyword."%' )";
				}
			}
		}
		if($status == 'success'){
			$vendor_category = $this->common_model->get_count_data_manual('wedd_planner_view',$where_arra,2,'*','id desc','','');
			if(isset($vendor_category) && $vendor_category!='' && is_array($vendor_category) && count($vendor_category)>0){
				
				$vendor_category_new = array();
				foreach($vendor_category as $data_val){
					$where_arra_reviews = array('vendor_id'=>$data_val['id'],'is_deleted'=>'No','status'=>'APPROVED');
					$wedding_planner_reviews_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,0,'*','id desc','');

					$data_val['wedding_planner_reviews_count'] = $wedding_planner_reviews_count;

					if(isset($wedding_planner_reviews_count) && $wedding_planner_reviews_count > 0){
							$where_arra__count=array('vendor_id'=>$data_val['id'],'is_deleted'=>'No','status'=>'APPROVED');
							$reviews_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra__count,1,'sum(r_star) as reviews_count','id desc','');
							
							$total = $wedding_planner_reviews_count*5;
							$average = $reviews_count['reviews_count']/$total*5; 
						}else{
							$average = 0;
						}
					$data_val['wedding_planner_average'] = $average;
					$vendor_category_new[] = $data_val;					
				}

				$data1['status'] = 'success';			
				$data1['data'] = $vendor_category_new;
				$data1['errmessage'] = "Successfully get data";
			}
			else{
				$data1['status'] = 'error';
				$data1['errmessage'] = 'No data available';
			}
		}
		else{
			$data1['status'] = 'error';
			$data1['errmessage'] = $errmessage;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function app_details(){
		
		$data1['imageUrl'] = $this->base_url.$this->common_model->path_wedding;
		if($this->input->post('vendor_id')!=''){
			$id = $this->input->post('vendor_id');
			$where_wedding_planner= " (id ='".$id."' and status = 'APPROVED' and is_deleted = 'No')";
			$wedding_planner_arr = $this->common_model->get_count_data_manual('wedd_planner_view',$where_wedding_planner,1,'*','','','',"");
			
			if(isset($wedding_planner_arr) && $wedding_planner_arr!= '')
			{
				$where_arra_reviews=array('vendor_id'=>$id,'is_deleted'=>'No','status'=>'APPROVED');
				
				$wedding_planner_reviews_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,0,'*','id desc','');

				$data['wedding_planner_reviews_count'] = $wedding_planner_reviews_count;
				$data['wedding_planner_reviews'] = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,2,'*','id desc',''); 

				if(isset($wedding_planner_reviews_count) && $wedding_planner_reviews_count > 0){
					$where_arra__count=array('vendor_id'=>$id,'is_deleted'=>'No','status'=>'APPROVED');
					$reviews_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra__count,1,'sum(r_star) as reviews_count','id desc','');
					
					$total = $wedding_planner_reviews_count*5;
					$average = $reviews_count['reviews_count']/$total*5; 
				}else{
					$data['wedding_planner_reviews'] = array();
					$average = 0;
				}
				$data['wedding_planner_average'] = $average;

				$data['wedding_planner_item'] = $wedding_planner_arr;
				$errormsg = 'Successfully get data';
				$data['status'] = 'success';
			}
			else{
				$errormsg = 'No data available';
				$data['status'] = 'error';
			}
		}
		else{
			$errormsg = 'Some issue, Please try again';
			$data['status'] = 'error';
		}
		
		$data['errmessage'] = $errormsg;
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
	public function app_send_review($id_details='')
	{
		$this->load->model('front_end/contact_model');
		if($this->input->post('vendor_id')){
			$id_details = $this->input->post('vendor_id');
			$data = $this->contact_model->send_review($id_details);
		}
		else{
			$data['token'] = $this->security->get_csrf_hash();
			$data['status'] = 'error';
			$data['errmessage'] = 'Some issue, Please try again';
		}
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
	public function app_send_enquiry($id_details='')
	{
		$this->load->model('front_end/contact_model');
		if($this->input->post('vendor_id')){
			$id_details = $this->input->post('vendor_id');
			$data = $this->contact_model->validate_form_vendor($id_details);
		}
		else{
			$data['token'] = $this->security->get_csrf_hash();
			$data['status'] = 'error';
			$data['errmessage'] = 'Some issue, Please try again';
		}
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}	
}