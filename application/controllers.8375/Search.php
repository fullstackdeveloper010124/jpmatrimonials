<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search extends CI_Controller {
	public $data = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/search_model');
		$this->load->model('front_end/my_profile_model');
		$this->common_front_model->last_member_activity();
		$this->extra_js_script = '';
	}
	public function index()
	{
		$this->quick();
	}
	public function quick_search()
	{
		$this->search();
	}
	public function advance_search()
	{
		$this->search();
	}
	public function keyword_search()
	{
		$this->search();
	}
	public function id_search()
	{
		$this->search();
	}
	public function search()
	{
		$this->session->unset_userdata('member_online_data');
		$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/chosen.css','css/select2.css');
		$this->common_model->extra_js_fr= array ('js/owl.carousel.min.js','js/select2.min.js','js/chosen.jquery.js','js/photo_protect_js.js','js/slider.js');
		$this->common_model->js_extra_code_fr .= "
		var config = {
			'.chosen-select'           : {},
			'.chosen-select-deselect'  : {allow_single_deselect:true},
			'.chosen-select-no-single' : {disable_search_threshold:10},
			'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
			'.chosen-select-width'     : {width:'100%'}
		}
		for (var selector in config) {
			$(selector).chosen(config[selector]);
		}
		$('.add-input select').select2();
		
		$(document).ready(function(){
			$('#testimonial-slider').owlCarousel({
				items:3,
				itemsDesktop:[1000,1],
				itemsDesktopSmall:[979,1],
				itemsTablet:[768,1],
				pagination:false,
				navigation:false,
				navigationText:['',''],
				autoPlay :3000,
				stopOnHover :true,
				dots:false
			});
		});
		";
		if($this->router->fetch_method()=='id_search')
		{
			$page_title = 'Id Search';
		}
		else if($this->router->fetch_method()=='keyword_search')
		{
			$page_title = 'Keyword Search';
		}
		else if($this->router->fetch_method()=='advance_search')
		{
			$page_title = 'Advance Search';
		}
		else
		{
			$page_title = 'Quick Search';
		}
		$seo_data = $this->common_model->get_count_data_manual('seo_page_data',array('status'=>'APPROVED','page_title'=>$page_title),1,'*','','');
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
		$this->common_model->front_load_header('','',$seo_title,$seo_description,$seo_keywords,$og_title,$og_description,$og_image);
		$this->load->view('front_end/search');
		$this->load->view('front_end/photo_protect');
		$this->common_model->front_load_footer();
	}
	
	public function home_search()
	{	
		$this->search_model->set_search();
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	
	public function add_saved_search()
	{	
		$this->search_model->save_search();
	}
	
	public function search_now()
	{	
		$this->search_model->set_search();
		redirect(base_url().'search/result');
	}
	public function search_exp()
	{	
		$this->search_model->set_search();
		$data1['status'] = 'success';
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function refine_search()
	{
		$this->search_model->set_search();
		$this->result();
	}
	public function result($page=1)
	{
		$this->common_front_model->set_orgin();
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		// for web API
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$member_data = $this->search_model->get_search_result($page);
			$member_data_count = $this->search_model->get_search_count();
			$data1['continue_request'] = TRUE;
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['total_count'] = $member_data_count;
			if(isset($member_data) && $member_data!='')
			{
				$data1['errormessage'] = 'Total Result found('.$member_data_count.')';
				$data1['errmessage'] = 'Total Result found('.$member_data_count.')';
				$data1['data'] = $this->common_front_model->process_data_app($member_data);
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
		}// for web API
		else
		{
			$this->data['member_total_count'] 	= $this->search_model->get_search_count();
			$this->data['member_data'] 			= $this->search_model->get_search_result($page);
			
			if($is_ajax == 0)
			{
				$this->common_model->extra_css_fr= array ('css/popup_user.css');
				$this->common_model->extra_js_fr= array ('js/photo_protect_js.js','js/range-slider.js');
				$this->common_model->front_load_header();
				$this->load->view('front_end/search_result',$this->data);
				$this->common_model->front_load_footer();
			}
			else
			{
				$this->load->view('front_end/search_result_member_profile',$this->data);
			}
		}
	}
	public function view_profile($matri_id = '')
	{	
		$matri_id = urldecode($matri_id);	
		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($matri_id) && $matri_id !='' && is_numeric($matri_id))
		{
			$where_arra=array('id'=>$matri_id,'is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'");
			$user_data_arr_mem = $this->common_model->get_count_data_manual('register',$where_arra,1,'matri_id','','','','');
			if(isset($user_data_arr_mem) && $user_data_arr_mem !='' && count($user_data_arr_mem)> 0)
			{
				$matri_id = $user_data_arr_mem['matri_id'];
			}
		}
		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0 && $matri_id !='')
		{
			$user_id = $current_login_user['matri_id'];
			$where_arra_payment=array('matri_id'=>$user_id,'is_deleted'=>'No','current_plan' =>'Yes');
			$payment_data = $this->common_model->get_count_data_manual('payments_view',$where_arra_payment,1,'*','','','','');
			$total_profile = 0;
			$profile_used = 0;
			if(isset($payment_data) && $payment_data != '' && is_array($payment_data) && count($payment_data) > 0)
			{
				$total_profile = $payment_data['profile'];
				$profile_used = $payment_data['profile_used'];
			}
			
			$where_array_checker = array('my_id'=>$user_id,'viewed_id'=>$matri_id);
			$profile_checker = $this->common_model->get_count_data_manual('profile_checker',$where_array_checker,0,'','','','','','');
			
			if($profile_checker > 0 || (isset($payment_data) && $payment_data != '' && is_array($payment_data) && count($payment_data) > 0 && isset($total_profile) && isset($profile_used) && $total_profile > $profile_used))
			{
				if(isset($matri_id) && $matri_id!='')
				{
					$check_membership_plab_exp_date = $this->search_model->view_profile_details($matri_id);
					if($check_membership_plab_exp_date==0)
					{
						redirect(base_url().'premium-member');
					}
					else
					{
						$this->common_model->display_top_menu_perm ='No';
						$this->common_model->extra_css_fr= array('css/owl.carousel.css','css/chosen.css','css/select2.css','css/popup_user.css','css/animate.css');
						$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/photo_protect_js.js','js/select2.min.js','js/wow.js');
						
						$gender_curr = $this->common_front_model->get_session_data('gender');
						$where_arra=array('matri_id'=>$matri_id,'is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended' and gender !='$gender_curr' ");
						$user_data_arr = $this->common_model->get_count_data_manual('register_view',$where_arra,1,'*','','','','');
						if(isset($user_data_arr) && $user_data_arr!='' && $user_data_arr > 0)
						{
							if($profile_checker == 0)
							{
								$created_on = $this->common_model->getCurrentDate();
								$insert_profile_checker = $this->common_model->update_insert_data_common('profile_checker',array('my_id' => $user_id,'viewed_id' => $matri_id,'date' => $created_on),'',0);
								$this->common_front_model->update_plan_detail($current_login_user['matri_id'],'profile');
								$insert_who_viewed = $this->common_model->update_insert_data_common('who_viewed_my_profile',array('my_id' => $user_id,'viewed_member_id' => $matri_id,'created_on' => $created_on),'',0);
							}
							$data['member_data'] = $this->my_profile_model->get_my_profile();
							$data['user_data']= $user_data_arr;
							$check_permission_view=array('ph_requester_id'=>$user_id,'ph_receiver_id'=>$matri_id,'receiver_response'=>'Accepted','status'=>'1');
							$data['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
							
							$names = array( 'viewed_profile','add_shortlist');
							$this->db->where_in('notification_type',$names);
							$this->common_model->update_insert_data_common('web_notification_history',array('status' => 'read'),array('receiver_id'=>$current_login_user['id']));
							$row_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$matri_id),1,'id,web_device_id,ios_device_id,android_device_id','id asc','','');
	if(isset($row_data) && $row_data!='' && count($row_data)>0){

		foreach($row_data as $key => $value){
			if(isset($value) && $value!='' && isset($key) && $key!=''){
				$M_message = $matri_id.': Your profile viewed from '.$current_login_user['matri_id'];
				if($key == 'web_device_id'){
					if(isset($row_data['web_device_id']) && $row_data['web_device_id']!=''){
						$data_array = array(
							'device_id'=>$value,
							'sender_id' => $current_login_user['id'],
							'receiver_id' => $row_data['id'],
							'notification_type' => 'viewed_profile',
							'title' => 'Viewed Profile',
							'message' => $M_message,
							'click_action'=>base_url().'search/view-profile/'.$current_login_user['matri_id'],
						);
						$this->common_model->new_send_notification_web($data_array);
					}
				}else if($key=='ios_device_id' || $key=='android_device_id'){
					if($key == 'ios_device_id'){
						$app_type = 'IOS';
					}else{
						$app_type = 'Android';
					}
					$sender_receiver = array('sender'=>$current_login_user['id'],'receiver'=>$row_data['id'],'app_type'=>$app_type);
					$this->common_model->new_send_notification_android($value,$M_message,'Viewed Profile','viewed_profile',$current_login_user['id'],'','',$sender_receiver);
				}
			}
		}
	}
							$user_data1 = $this->common_front_model->set_member_profile_join_data($data['user_data']);
							$user_data = $this->common_front_model->compare_to_other_user($user_data1,$data['member_data']);
							
							
							$user_data['badgeUrl'] = $this->base_url.$this->common_model->path_payment_logo; 
							$badges = $this->common_front_model->getbadges($user_data,1);
							if (!empty($badges)) {
								$user_data['badge'] = $badges['badge']!=''?$badges['badge']:'';
								$user_data['color'] = $badges['color']!=''?$badges['color']:'';
							}else{
								$user_data['badge'] = '';
								$user_data['color'] = '';
							}
							$user_data['action'] = $this->common_front_model->common_status_action($user_data);
							$data1['member_data'] = $user_data;
							$data1['photo_view_count'] = $data['photo_view_count'];
							// echo '<pre>';
							// print_r($user_data);
							$this->extra_js_script = '<script 
									integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" 
									crossorigin="anonymous">
							</script>';
							$this->common_model->front_load_header();
							$this->load->view('front_end/user_profile',$data1);
							$this->load->view('front_end/photo_protect',$data);
							$this->common_model->front_load_footer();
						}
						else
						{
							redirect(base_url().'search/quick-search');
						}
					}
				}
				else
				{
					redirect(base_url().'search/quick-search');
				}
			}
			else
			{
				redirect(base_url().'premium-member');
			}
		}
		else
		{
			redirect($this->common_model->base_url.'login');
		}
	}
	
	public function get_list()
	{
		$from = $this->input->post('listfrom');
		$to = $this->input->post('listto');
		$value = $this->input->post('value');
		$value_to = $this->input->post('value_to');
		$this->data['data'] = $this->search_model->get_list($from,$to,$value,$value_to);
		$this->load->view('common_file_echo',$this->data);
	}
	public function saved($page=1)
	{
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		
		// for web API
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$saved_data = $this->search_model->saved_searches(1,$page);
			$saved_data_count = $this->search_model->saved_searches(0);
			
			$data1['continue_request'] = TRUE;
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['total_count'] = $saved_data_count;
			if(isset($saved_data) && $saved_data!='')
			{
				$data1['errormessage'] = 'Total Result found('.$saved_data_count.')';
				$data1['errmessage'] = 'Total Result found('.$saved_data_count.')';
				$data1['data'] = $saved_data;
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
		
			$data['base_url']=$this->data['base_url'];		
			$this->data['page_name'] = 'Saved Searches';
			$this->data['shortlist_data_count'] = $this->search_model->saved_searches(0);
			$this->data['shortlist_data'] = $this->search_model->saved_searches(1,$page);
			if($is_ajax == 0)
			{	
				$this->common_model->display_top_menu_perm ='No';
				$this->common_model->extra_css_fr= array('css/popup_user.css','css/select2.css');
				$this->common_model->extra_js_fr= array('js/photo_protect_js.js','js/select2.min.js');
				$this->common_model->front_load_header('Saved Searches');
				$this->load->view('front_end/saved_searches',$this->data);
				$this->common_model->front_load_footer();
			}
			else
			{	
				$this->load->view('front_end/saved_searches_member_profile',$this->data);
			}
		}
	}
	public function saved_search_now($id='')
	{	
		if($id !='')
		{
			$_SERVER["REQUEST_METHOD"] = "POST";
			$return = $this->search_model->set_saved_search($id);
			if($return)
			{
				redirect(base_url().'search/result');
			}
			else
			{
				redirect(base_url().'search/quick');
			}
		}
		else
		{
			redirect(base_url().'search/quick');
		}
	}
	public function delete_saved_search()
    {
        $this->search_model->delete_saved_search();
    }
	
	public function add_remove_shortlist_app()
    {
		$shortlist_action = $this->input->post('shortlist_action');
		
		if($shortlist_action != 'add'){
			$response = $this->search_model->remove_shortlist();
			$this->load->view('common_file_echo',$response);
		}else{
			$response = $this->search_model->add_shortlist();
			$this->load->view('common_file_echo',$response);
		}
	}
	public function blocklist()
    {
		$blacklist_action = $this->input->post('blacklist_action');
		
		if(isset($blacklist_action) && $blacklist_action != 'add'){
			$response = $this->search_model->remove_blocklist();
			$this->load->view('common_file_echo',$response);
		}else{
			$response = $this->search_model->add_blocklist();
			$this->load->view('common_file_echo',$response);
		}
	}
	
	public function add_blocklist()
    {
		$response = $this->search_model->add_blocklist();
		$this->load->view('common_file_echo',$response);
    }
	public function remove_blocklist()
    {
		$response = $this->search_model->remove_blocklist();
		$this->load->view('common_file_echo',$response);
    }
	public function add_shortlist()
    {
		$response = $this->search_model->add_shortlist();
		$this->load->view('common_file_echo',$response);
    }
	public function remove_shortlist()
    {
		$response = $this->search_model->remove_shortlist();
		$this->load->view('common_file_echo',$response);
    }
	public function express_interest_sent()
    {
		$response = $this->search_model->express_interest_sent();
		$this->load->view('common_file_echo',$response);
    }
	
	public function send_email()
    {	
		$to_email='';
		$subject = '';
		$message = '';
		if($this->input->post('receiver_email') != ''){
			$to_email = $this->input->post('receiver_email');
		}
		if($this->input->post('email_subject') != ''){
			$subject = $this->input->post('email_subject');
		}
		if($this->input->post('email_message') != ''){
			$message = $this->input->post('email_message');
		}
		$data['result'] = $this->common_model->common_send_email($to_email,$subject,$message,'','','');
		
		
		if($data['result'] == 'Email sent.'){
			$data['response'] = 'Email Sent Successfully.';
			$data['status'] = 'success';
        }else{
			$data['response'] = 'Email Not Sent.';
			$data['status'] = 'fail';
		}
		$data['tocken'] = $this->security->get_csrf_hash();
		$data1 = json_encode($data);
		$data['data'] = $data1;
        $this->load->view('common_file_echo',$data);
    }
	
	function member_like()
	{
		$data = $this->search_model->member_like();
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
	
	function total_likes_unlikes()
	{
		$other_id = $this->input->post('other_id');
		$likes_array = array('like_status'=>'Yes','other_id'=>$other_id);
		$data['total_likes'] = $this->common_model->get_count_data_manual('member_likes',$likes_array,0,'');
		
		$unlikes_array = array('like_status'=>'No','other_id'=>$other_id);
		$data['total_unlikes'] = $this->common_model->get_count_data_manual('member_likes',$unlikes_array,0,'');
		$data['tocken'] = $this->security->get_csrf_hash();
		$data['status'] = 'success';
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
	
	function view_contact_details(){
		$this->search_model->view_contact_details();
	}
	
	function view_video(){
		$this->search_model->view_video();
	}
	
	function photo_password($member_id=''){
		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0)
		{
			if(isset($member_id) && $member_id != ''){
				$this->data['current_login_user'] = $this->common_front_model->get_session_data('matri_id');
				$this->data['member_id'] = $member_id;
			
				$this->load->view('front_end/send_photo_password',$this->data);
			}else{
				redirect(base_url().'my-dashboard');
			}
		}else{
			redirect($this->common_model->base_url.'login');
		}
	}
	
	function send_photo_password_request(){
		$response = $this->search_model->send_photo_password_request();
		$this->load->view('common_file_echo',$response);
	}

	function already_password($member_id=''){
		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0)
		{
			if(isset($member_id) && $member_id != ''){
				$this->data['current_login_user'] = $this->common_front_model->get_session_data('matri_id');
				$this->data['member_id'] = $member_id;
			
				$this->load->view('front_end/view_protect_photo_form',$this->data);
			}else{
				redirect(base_url().'search/photo-password/'.$member_id);
			}
		}else{
			redirect($this->common_model->base_url.'login');
		}
	}
	
	function check_photo_request(){
		
		$member_id = $this->input->post('member_id');
		$my_id = $this->input->post('my_id');

		$data['data'] = $this->search_model->check_photo_request();
		$data1 = json_decode($data['data'], true);
		
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if(isset($data1['errmessage']) && $data1['errmessage'] !='')
			{
				$this->session->set_flashdata('error_message_arr', $data1['errmessage']);
			}
			redirect($this->base_url.'search/already-password/'.$member_id);
		}
	}

	function check_photo_password(){
		
		$member_id = $this->input->post('member_id');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('photo_pswd', 'Photo Password', 'required');

		if ($this->form_validation->run() == FALSE)
        {
			$data1['token'] = $this->security->get_csrf_hash();
			$data1['errmessage'] =  validation_errors();
			$data1['status'] = 'error';
			$data['data'] = json_encode($data1);
		}
		else
		{
			$data['data'] = $this->search_model->check_photo_password();
			$data1 = json_decode($data['data'], true);
		
		}
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			if(isset($data1['errmessage']) && $data1['errmessage'] !='')
			{
				$this->session->set_flashdata('error_message_arr', $data1['errmessage']);
			}
			redirect($this->base_url.'search/already-password/'.$member_id);
		}
	}
	function view_photos()
	{
		$member_id = $this->input->post('member_id');
		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0)
		{
			if(isset($member_id) && $member_id != '')
			{
				$this->data['member_id'] = $member_id;
				$this->data['base_url'] = $this->base_url;
				$this->data['member_data'] = $this->common_model->get_count_data_manual('register_view',array(" matri_id = '$member_id' "),1,'*','id desc','','');
				$path_photos = $this->common_model->path_photos;
				$member_data=$this->data['member_data'];
				
				if(isset($member_data['photo1']) && $member_data['photo1'] !='' && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']))
				{
					$data1['content'] = '
					<div class="text-center">
    					<div class="row">
							<div class="col-sm-12 col-md-12">
								<a href="javascript:;" data-dismiss="modal" onClick="openModal();currentSlide(1)"><img src="'.$this->base_url.$path_photos.$member_data['photo1'].'" class="cursor img-thumbnail" alt="team-pic2" style="height: 159px;width: 157px;object-fit: contain;"></a>
							</div>
							<div class="col-sm-12 col-md-12">
								<a class="add-w-btn new-id-s-photo btn-file Poppins-Regular f-14 color-f" style="width: 25%;cursor:pointer;" onClick="openModal();currentSlide(1)" data-dismiss="modal">View Full Photo</a>
							</div>
						</div>
					</div>
        			';
				}
				else
				{
					$data1['content'] = '<center>
    		<a href="javascript:;"><img src="'.$this->common_model->member_photo_disp($member_data).'" class="cursor img-thumbnail text-center" alt="team-pic2"></a>
    	</center><br>';
				}
				//$this->load->view('front_end/view_photo',$this->data);
				
				$photos = array();
				$photo_upload_count = $this->common_model->photo_upload_count;
				if($photo_upload_count =='' || $photo_upload_count > 0  || $photo_upload_count < 6){
					$photo_upload_count = 6;
				}
				$i=0;
				for($i_photo = 1;$i_photo<=$photo_upload_count;$i_photo++){
					$photos[] = array('photo'=>$member_data['photo'.$i_photo],'status'=>$member_data['photo'.$i_photo.'_approve']);
				}
				$data1['slider']='';
				$j=0;
				foreach($photos as $photo_val_c) {
					if(isset($photo_val_c['photo']) && $photo_val_c['photo'] !='' && file_exists($path_photos.$photo_val_c['photo']) && $photo_val_c['status'] =='APPROVED'){
						$i++;
					}
				}
				foreach($photos as $photo_val) {
					if(isset($photo_val['photo']) && $photo_val['photo'] !='' && file_exists($path_photos.$photo_val['photo']) && $photo_val['status'] =='APPROVED'){
						$j++;
						$data1['slider'].='	
							<div class="mySlides">
							<div class="numbertext margin-bottom-15"><span class="numbertext-border">'.$j.'/'.$i.'</span></div>
							<img src="'.$this->base_url.$path_photos.$photo_val['photo'].'" class="slide-img img-responsive padding-top-10" alt="" style="padding: 0px;width: 600px !important;height: 500px !important;max-height:500px !important;object-fit:contain;" /></div>	';
					}
				}

				$data1['member_id']= $this->data['member_id'];
				$data1['token'] = $this->security->get_csrf_hash();
				$data['data'] = json_encode($data1);
				$this->load->view('common_file_echo',$data);
			}
		}
	}
	function member_photos($member_id='')
	{
		$current_login_user = $this->common_front_model->get_session_data();
		if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0)
		{
			if(isset($member_id) && $member_id != '')
			{
				$this->data['member_id'] = $member_id;
				$this->data['member_data'] = $this->common_model->get_count_data_manual('register_view',array(" matri_id = '$member_id' "),1,'*','id desc','','');
				
				$this->load->view('front_end/member_photos',$this->data);
			}
			else
			{
				redirect(base_url().'search/photo-password/'.$member_id);
			}
		}
		else
		{
			redirect($this->common_model->base_url.'login');
		}
	}
	
	function common_button_action(){
		$response = $this->search_model->common_button_action();
		$this->load->view('common_file_echo',$response);
	}
	
	function view_profile_app(){
		
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		
		$current_login_user_id = $this->input->post('user_id');
		$member_id = $this->input->post('member_id');
		
		if(isset($current_login_user_id) && $current_login_user_id != '' && isset($member_id) && $member_id != '' )
		{
			$login_where_arra=array('id'=>$current_login_user_id,'is_deleted'=>'No');
			$login_member_data = $this->common_model->get_count_data_manual('register',$login_where_arra,1,'matri_id','','','','');
			
			$member_where_arra=array('id'=>$member_id,'is_deleted'=>'No');
			$member_member_data = $this->common_model->get_count_data_manual('register',$member_where_arra,1,'matri_id','','','','');
			
			$user_id = $login_member_data['matri_id'];
			
			$matri_id = $member_member_data['matri_id'];
		
			if(isset($user_agent) && $user_agent!='NI-WEB' && isset($user_id) && $user_id!='' && isset($matri_id) && $matri_id!='')
			{
				$where_arra_payment=array('matri_id'=>$user_id,'is_deleted'=>'No','current_plan' =>'Yes');
				$payment_data = $this->common_model->get_count_data_manual('payments_view',$where_arra_payment,1,'*','','','','');
				
				$total_profile = $payment_data['profile'];
				$profile_used = $payment_data['profile_used'];
			
				$where_array_checker = array('my_id'=>$user_id,'viewed_id'=>$matri_id);
				$profile_checker = $this->common_model->get_count_data_manual('profile_checker',$where_array_checker,0,'','','','','','');

				if($profile_checker > 0 || (isset($payment_data) && $payment_data != '' && is_array($payment_data) && count($payment_data) > 0 && isset($total_profile) && isset($profile_used) && $total_profile > $profile_used))
				{
					if(isset($matri_id) && $matri_id!='')
					{
						$where_arra=array('matri_id'=>$matri_id,'is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'");
						$user_data_arr = $this->common_model->get_count_data_manual('register_view',$where_arra,1,'*','','','','');
						if(isset($user_data_arr) && $user_data_arr!='' && $user_data_arr > 0)
						{
							$where_array_checker = array('my_id'=>$user_id,'viewed_id'=>$matri_id);
							$profile_checker = $this->common_model->get_count_data_manual('profile_checker',$where_array_checker,0,'','','','','','');
							
							if($profile_checker == 0){
								$created_on = $this->common_model->getCurrentDate();
								
								$insert_profile_checker = $this->common_model->update_insert_data_common('profile_checker',array('my_id' => $user_id,'viewed_id' => $matri_id,'date' => $created_on),'',0);
								
								$this->common_front_model->update_plan_detail($user_id,'profile');
									
								$insert_who_viewed = $this->common_model->update_insert_data_common('who_viewed_my_profile',array('my_id' => $user_id,'viewed_member_id' => $matri_id,'created_on' => $created_on),'',0);
							}
						
							$where_arra=array('matri_id'=>$matri_id,'is_deleted'=>'No');
							$member_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id','','','','');
							$member_id = $member_data['id'];

							$where_arrays=array('matri_id'=>$user_id,'is_deleted'=>'No');
							$member_datass = $this->common_model->get_count_data_manual('register',$where_arrays,1,'id','','','','');
							$compare_from = $member_datass['id'];
							
							$user_data1 = $this->common_front_model->get_user_data('register_view',$member_id);
							$my_data = $this->common_front_model->get_user_data('register_view',$compare_from);
							
							$user_data = $this->common_front_model->set_member_profile_join_data($user_data1);
							$parampass = array('photo1' =>'assets/photos/','photo2' =>'assets/photos/','photo3' =>'assets/photos/','photo4' =>'assets/photos/','photo5' =>'assets/photos/','photo6' =>'assets/photos/','photo7' =>'assets/photos/','photo8' =>'assets/photos/','cover_photo'=>'assets/cover_photo/','horoscope_photo'=>'assets/horoscope-list/');
							$user_data = $this->common_front_model->dataimage_fullurl($user_data,$parampass,'single');
							
							$percentage_stored = $this->common_front_model->getprofile_completeness($member_id);
							$check_permission_view=array('ph_requester_id'=>$user_id,'ph_receiver_id '=>$matri_id,'receiver_response'=>'Accepted','status'=>'1');
							$user_data['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
							//$user_data = $this->common_front_model->set_member_profile_data_category_wise($user_data);
							
							$user_data = $this->common_front_model->compare_to_other_user($user_data,$my_data);
							
							$user_data['percentage'] = $percentage_stored;
							$user_data['action'] = $this->common_front_model->common_status_action($user_data1,1);//pass 2nd prameter for login user id get 
							//for contact view check in app
							$where_array_checker = array('my_id'=>$user_id,'viewed_id'=>$matri_id);
							$contact_checker = $this->common_model->get_count_data_manual('contact_checker',$where_array_checker,0,'','','','','','');
							if($contact_checker == 0)
							{
								$user_data['contact_viewed']='0';
							}
							else
							{
								$user_data['contact_viewed']='1';
							}
							$user_data['badgeUrl'] = $this->base_url.$this->common_model->path_payment_logo; 
							$user_data['badge'] = $this->common_front_model->getbadges($user_data);
							$data1['data'] = $user_data;

	$names = array( 'viewed_profile','add_shortlist');
	$this->db->where_in('notification_type',$names);
	$this->common_model->update_insert_data_common('web_notification_history',array('status' => 'read'),array('receiver_id'=>$user_data['id']));

	$row_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$matri_id),1,'id,web_device_id,ios_device_id,android_device_id','id asc','','');
	if(isset($row_data) && $row_data!='' && count($row_data)>0){
		foreach($row_data as $key => $value){
			if(isset($value) && $value!='' && isset($key) && $key!=''){
				$M_message = $matri_id.': Your profile viewed from '.$user_id;
				if($key == 'web_device_id'){
					if(isset($row_data['web_device_id']) && $row_data['web_device_id']!=''){
						$data_array = array(
							'device_id'=>$value,
							'sender_id' => $this->input->post('member_id'),
							'receiver_id' => $row_data['id'],
							'notification_type' => 'viewed_profile',
							'title' => 'Viewed Profile',
							'message' => $M_message,
							'click_action'=>base_url().'search/view-profile/'.$user_id,
						);
						$this->common_model->new_send_notification_web($data_array);
					}
				}else if($key=='ios_device_id' || $key=='android_device_id'){
					if($key == 'ios_device_id'){
						$app_type = 'IOS';
					}
					else{
						$app_type = 'Android';
					}
					$sender_receiver = array('sender'=>$current_login_user_id,'receiver'=>$row_data['id'],'app_type'=>$app_type);
					$this->common_model->new_send_notification_android($value,$M_message,'Viewed Profile','viewed_profile',$current_login_user_id,'','',$sender_receiver);
				}
			}
		}
	}
							$data1['status'] = 'success';
						}
						else
						{
							$data1['status'] = 'error';
							$data1['errormessage'] = 'Data not found.';
							$data1['errmessage'] = 'Data not found.';
							$data1['data'] = '';
						}
					}
					else
					{
						$data1['status'] = 'error';
						$data1['errormessage'] = 'Data not found.';
						$data1['errmessage'] = 'Data not found.';
						$data1['data'] = '';
					}
				}else{
					$data1['status'] = 'warning';
					$data1['errormessage'] = 'Your profile viewed count has been not available';
					$data1['errmessage'] = 'Your profile viewed count has been not available';
					$data1['data'] = '';
				}
			}else{
				$data1['status'] = 'error';
				$data1['errormessage'] = 'Data not found.';
				$data1['errmessage'] = 'Data not found.';
				$data1['data'] = '';
			}
		}else{
			$data1['status'] = 'error';
			$data1['errormessage'] = 'Sorry, Your session hase been time out, Please login Again.';
			$data1['errmessage'] = 'Sorry, Your session hase been time out, Please login Again.';
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function read_notification($user_id=''){
		if(isset($_POST['id']) && $_POST['id']!=''){
			$user_id = $_POST['id'];
		}
		$return_arr['status'] = 'error';
		$return_arr['tocken'] = $this->security->get_csrf_hash();
		$this->common_model->update_insert_data_common('web_notification_history',array('status' => 'read'),array('id'=>$user_id));
		$return_arr['status'] = 'success';
		echo json_encode($return_arr);
	}
}