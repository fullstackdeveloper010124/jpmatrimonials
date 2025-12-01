<?php defined('BASEPATH') OR exit('No direct script access allowed');
class My_profile extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->checkLogin();
		$this->load->model('front_end/my_profile_model');
		$this->common_front_model->last_member_activity();
		$this->load->model('front_end/matches_model');
		$this->load->model('front_end/search_model');
	}
	
	public function index()
	{
		$base_url = $this->data['base_url'];
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/date-picker.css','css/chosen.css','css/select2.css');
		$this->common_model->extra_js_fr= array('js/date-picker.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/select2.min.js');
		
		$this->common_model->front_load_header('My Profile');
		$user_data1 = $this->my_profile_model->get_my_profile();
		$user_data = $this->common_front_model->set_member_profile_join_data($user_data1);
			
		$parampass = array('photo1' =>'assets/photos/','photo2' =>'assets/photos/','photo3' =>'assets/photos/','photo4' =>'assets/photos/','photo5' =>'assets/photos/','photo6' =>'assets/photos/','photo7' =>'assets/photos/','photo8' =>'assets/photos/','cover_photo'=>'assets/cover_photo/','horoscope_photo'=>'assets/horoscope-list/','id_proof'=>'assets/id_proof/');
		$user_data = $this->common_front_model->dataimage_fullurl($user_data,$parampass,'single');
		$data['member_data'] = $this->common_front_model->set_member_profile_data_category_wise($user_data);		
		$this->load->view('front_end/my_profile',$data);
		$this->load->view('front_end/photo_protect',$data);
		$this->common_model->front_load_footer();
	}
	
	public function get_my_profile()
	{
		$this->common_front_model->set_orgin();
		$member_id = $this->common_front_model->get_user_id();
		if($member_id !='')
		{
			$user_data1 = $this->common_front_model->get_user_data("register_view",$member_id);
			$user_data = $this->common_front_model->set_member_profile_join_data($user_data1);
			
			$parampass = array('photo1' =>'assets/photos/','photo2' =>'assets/photos/','photo3' =>'assets/photos/','photo4' =>'assets/photos/','photo5' =>'assets/photos/','photo6' =>'assets/photos/','photo7' =>'assets/photos/','photo8' =>'assets/photos/','cover_photo'=>'assets/cover_photo/','horoscope_photo'=>'assets/horoscope-list/','id_proof'=>'assets/id_proof/');
			$user_data = $this->common_front_model->dataimage_fullurl($user_data,$parampass,'single');
			$user_data = $this->common_front_model->set_member_profile_data_category_wise($user_data);
			
			$user_agent = 'NI-WEB';
			if($this->input->post('user_agent'))
			{
				$user_agent = $this->input->post('user_agent');
			}
			if($user_agent != 'NI-WEB'){
				$percentage_stored = $this->common_front_model->getprofile_completeness($member_id);
				$user_data['percentage'] = $percentage_stored;
				//$user_data['unread_notification'] = $this->common_model->get_count_data_manual('app_notification_history',array('receiver_id'=>$matri,'read_status'=>'No'),0,'','');
			
				/*my_profile_view_by_other  */
				$where_array_checker = array('viewed_id'=>$user_data1["matri_id"]);
				$my_profile_view_by_other = $this->common_model->get_count_data_manual('profile_checker',$where_array_checker,0,'','','','','','');
				$user_data['my_profile_view_by_other'] = $my_profile_view_by_other;
				

				/*interest_sent_count  */
				$where_array_checker = array('sender'=>$user_data1["matri_id"]);
				$interest_sent_count = $this->common_model->get_count_data_manual('expressinterest',$where_array_checker,0,'','','','','','');
				$user_data['interest_sent_count'] = $interest_sent_count;
				

				/* matches count */
				$where_array_checker = array('other_id'=>$member_id);
				$matches_list_count = $this->common_model->get_count_data_manual('matches_list',$where_array_checker,0,'','','','','','');
				$user_data['my_matches_list_count'] = $matches_list_count;
				

				/* like count */ 
			
				$likes_array = array('like_status'=>'Yes','my_id'=>$user_data1["matri_id"]);
				$user_data['member_likes'] = $this->common_model->get_count_data_manual('member_likes',$likes_array,0,'');
			
				/* shortlist count */
			
				$where_short = " from_id = '".$user_data1["matri_id"]."'  and is_deleted='No' " ;
				$user_data['shortlist_count'] = $this->common_model->get_count_data_manual('shortlist',$where_short,0,'');

				## Get Unread Mesages count : Date : 08-10-2021
				$where_inbox=array('message.receiver'=>$user_data1['matri_id'],'message.trash_receiver'=>'No','message.status'=>'sent','message.read_status' => 'No');
				$user_data['unread_message_count'] = $this->common_model->get_count_data_manual('message',$where_inbox,0,'');

				## Get Recomanded Match count : Date : 08-10-2021
				$member_total_count = $this->matches_model->get_search_count();
				if(!isset($member_total_count) || $member_total_count ==''){
					$member_total_count = 0;
				}
				$user_data['member_match_count'] = $member_total_count;

				## Interest Receive Pending Count : Date : 08-10-2021
				$where_array_checker = array('receiver'=>$user_data1["matri_id"],'receiver_response' => 'Pending');
				$interest_sent_count = $this->common_model->get_count_data_manual('expressinterest',$where_array_checker,0,'','','','','','');
				$user_data['interest_received_count'] = $interest_sent_count;

				## Get Unread Notification count : Date : 08-10-2021
				$where_notification = array('app_notification_history.receiver_id'=>$user_data1['id'],'app_notification_history.read_status' => 'No');
				$user_data['notification_message_count'] = $this->common_model->get_count_data_manual('app_notification_history',$where_notification,0,'','','','','','');
			
			}
			
			$data = $this->common_front_model->return_jsone_response('success',$user_data);
			
			$this->load->view('common_file_echo',$data);
		}
	}
	public function married_brother_list()
	{
		$this->load->view('front_end/no_married_brother');
	}
	public function edit_profile($step ='basic_info')
	{
		$data1['status'] = 'error';
		$data1['tocken'] = $this->security->get_csrf_hash();
		$member_id = $this->common_front_model->get_session_data('id');
		if($this->input->post('is_post')!='' && isset($member_id) && $member_id != '' )
		{
			$data1['status'] = 'success';
			$this->data['row_data'] = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
			$data1['html'] = $this->load->view('front_end/edit_profile',$this->data,true);
			$data1['step'] = $step;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function save_profile($step ='basic-detail')
	{
		$is_post = 0;
		if($this->input->post('is_post'))
		{
			$is_post = trim($this->input->post('is_post'));
		}
		$response = $this->my_profile_model->save_profile($is_post,$step);
		
		if($is_post == 0)
		{
			$this->load->view('common_file_echo',$response);
		}
		else
		{		
			redirect($this->base_url.'my-profile');
		}
	}
	public function partner_preference()
	{
		$base_url = $this->data['base_url'];
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/hover-img.css','css/bootstrap-touch-slider.css','css/select2.min.css');
		$this->common_model->front_load_header();
		$this->load->view('front_end/register_partner_preferance',$this->data);
	}
	public function common_function_profile($file_name='')
	{
		$this->data['file_name'] = $file_name;
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		$data['base_url']=$this->data['base_url'];		
		$this->common_model->extra_css_fr= array('css/select2.css','css/chosen.css','css/popup_user.css');
		$this->common_model->extra_js_fr= array('js/select2.min.js','js/chosen.jquery.js','js/jquery.validate.min.js','js/additional-methods.min.js','js/photo_protect_js.js');
		if($is_ajax == 0)
		{	
			$this->common_model->display_top_menu_perm ='No';
			$this->common_model->front_load_header();
			$this->load->view('front_end/'.$file_name,$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			if($this->data['page_name'] == 'Photo Request Received'){
				$this->load->view('front_end/photo_pass_request_received_ajax',$this->data);
			}elseif($this->data['page_name'] == 'Photo Request Sent'){
				$this->load->view('front_end/photo_pass_request_sent_ajax',$this->data);
			}else{
				$this->load->view('front_end/short_listed_member_profile',$this->data);
			}
		}
	}
	public function short_listed($page=1)
	{	
		$this->data['page_name'] = 'Short Listed Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->short_list_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->short_list_profile(1,$page);
		$this->common_function_profile('shortlist_profiles');
	}
	public function block_listed($page=1)
	{	
		$this->data['page_name'] = 'Block Listed Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->block_list_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->block_list_profile(1,$page);
		$this->common_function_profile('blocklist_profile');
	}
	public function i_viewed($page=1)
	{	
		$this->data['page_name'] = 'I Viewed Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->i_viewed_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->i_viewed_profile(1,$page);
		$this->common_function_profile('i_viewed_profile');
	}
	public function who_viewed($page=1)
	{	
		$this->data['page_name'] = 'Who Viewed My Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->who_viewed_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->who_viewed_profile(1,$page);
		$this->common_function_profile('who_viewed_profile');
	}
	## New Code : Date : 08-10-2021
	public function who_contacted($page=1)
	{	
		$this->data['page_name'] = 'Viewed My Contact';
		$this->data['shortlist_data_count'] = $this->my_profile_model->who_viewed_contact(0);
		$this->data['shortlist_data'] = $this->my_profile_model->who_viewed_contact(1,$page);
		$this->common_function_profile('who_contacted_profile');
	}
	## New Code : Date : 08-10-2021
	public function i_contacted($page=1)
	{	
		$this->data['page_name'] = 'I Viewed Contact';
		$this->data['shortlist_data_count'] = $this->my_profile_model->i_viewed_contact(0);
		$this->data['shortlist_data'] = $this->my_profile_model->i_viewed_contact(1,$page);
		$this->common_function_profile('i_contacted_profile');
	}
	public function unblock_profile()
	{
		$this->my_profile_model->check_unblock_status();
	}
	public function photo_pass_request_received($page=1)
	{
		$this->data['page_name'] = 'Photo Request Received';
		$this->data['photo_pass_count'] = $this->my_profile_model->photo_pass_request_received();
		$this->data['photo_pass_data'] = $this->my_profile_model->photo_pass_request_received(1,$page);
		$this->common_function_profile('photo_pass_request_received');
	}
	public function photo_pass_request_sent($page=1)
	{
		$this->data['page_name'] = 'Photo Request Sent';
		$this->data['photo_pass_count'] = $this->my_profile_model->photo_pass_request_sent();
		$this->data['photo_pass_data'] = $this->my_profile_model->photo_pass_request_sent(1,$page);
		$this->common_function_profile('photo_pass_request_sent');
	}
	public function send_photo_pass()
	{
		$this->my_profile_model->send_photo_pass();
	}
	public function delete_request()
	{
		$this->my_profile_model->delete_request();
	}
	public function reject_request()
	{
		$this->my_profile_model->reject_request();
	}
	public function like_profile($page=1)
	{	
		$this->data['page_name'] = 'Like Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->like_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->like_profile(1,$page);
		$this->common_function_profile('like_profiles');
	}
	public function unlike_profile($page=1)
	{	
		$this->data['page_name'] = 'Unlike Profile';
		$this->data['shortlist_data_count'] = $this->my_profile_model->unlike_profile(0);
		$this->data['shortlist_data'] = $this->my_profile_model->unlike_profile(1,$page);
		$this->common_function_profile('unlike_profiles');
	}
	public function block_list($page=1)
	{	
		$block_profile_data_count = $this->my_profile_model->block_list_profile(0);
		$block_profile_data1 = $this->my_profile_model->block_list_profile(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		
		$block_profile_data = $this->common_front_model->dataimage_fullurl($block_profile_data1,$parampass,'multiple');
		$photo_pass_data1_temp = array();
		if(isset($block_profile_data) && $block_profile_data!='' && count($block_profile_data)>0){
		foreach ($block_profile_data as $key => $value) {
			$id = $value["user_id"];
			if(isset($id) && $id!='')
			{
				$where_arrra = " id = '$id'" ;
					$data13 = $this->common_front_model->get_count_data_manual('register',$where_arrra,2,'photo_view_status,photo1,photo1_approve','','',1);
					$parampass = array('photo1' =>'assets/photos/');
					$data = $this->common_front_model->dataimage_fullurl($data13,$parampass,'multiple');

					$check_permission_view=array('ph_requester_id'=>$this->input->post('matri_id'),'ph_receiver_id '=>$id,'receiver_response'=>'Accepted','status'=>'1');
					$value['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					
					if(isset($data[0]['photo1']))
					{
						$value['photo1'] = $data[0]['photo1'];
					}
					if(isset($data[0]['photo_view_status']))
					{
						$value['photo_view_status'] = $data[0]['photo_view_status'];
					}
					if(isset($data[0]['photo1_approve']))
					{
						$value['photo1_approve'] = $data[0]['photo1_approve'];
					}
					$value['birthdate'] = $this->common_model->displayDate($value['birthdate'],'d-m-Y');
			}
			$photo_pass_data1_temp[]=$value;
		}
				$block_profile_data = $photo_pass_data1_temp;
	}
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $block_profile_data_count;
		if(isset($block_profile_data) && $block_profile_data!=NULL && $block_profile_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$block_profile_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$block_profile_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app_image_use($block_profile_data);//$block_profile_data;
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
	}
	public function short_list_app($page=1)
	{	
		$short_list_data_count = $this->my_profile_model->short_list_profile(0);
		$short_list_profile_data1 = $this->my_profile_model->short_list_profile(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$short_list_profile_data = $this->common_front_model->dataimage_fullurl($short_list_profile_data1,$parampass,'multiple');
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $short_list_data_count;
		if(isset($short_list_profile_data) && $short_list_profile_data!=NULL && $short_list_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$short_list_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$short_list_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($short_list_profile_data);
			//$data1['data'] = $short_list_profile_data;
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
	}
	public function i_viewed_profile_app($page=1)
	{	
		$i_viewed_data_count = $this->my_profile_model->i_viewed_profile(0);
		$i_viewed_profile_data1 = $this->my_profile_model->i_viewed_profile(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$i_viewed_profile_data = $this->common_front_model->dataimage_fullurl($i_viewed_profile_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $i_viewed_data_count;
		if(isset($i_viewed_profile_data) && $i_viewed_profile_data!=NULL && $i_viewed_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$i_viewed_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$i_viewed_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($i_viewed_profile_data);
			//$data1['data'] = $i_viewed_profile_data;
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
	}
	public function who_viewed_profile_app($page=1)
	{	
		$who_viewed_data_count = $this->my_profile_model->who_viewed_profile(0);
		$who_viewed_profile_data1 = $this->my_profile_model->who_viewed_profile(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$who_viewed_profile_data = $this->common_front_model->dataimage_fullurl($who_viewed_profile_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $who_viewed_data_count;
		if(isset($who_viewed_profile_data) && $who_viewed_profile_data!=NULL && $who_viewed_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$who_viewed_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$who_viewed_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($who_viewed_profile_data);
			//$data1['data'] = $who_viewed_profile_data;
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
	}

	## New API : Date : 08-10-2021
	public function who_viewed_contact_app($page=1){	
		$who_contacted_data_count = $this->my_profile_model->who_viewed_contact(0);
		$who_contacted_profile_data1 = $this->my_profile_model->who_viewed_contact(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$who_contacted_profile_data = $this->common_front_model->dataimage_fullurl($who_contacted_profile_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $who_contacted_data_count;
		if(isset($who_contacted_profile_data) && $who_contacted_profile_data!=NULL && $who_contacted_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$who_contacted_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$who_contacted_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($who_contacted_profile_data);
			//$data1['data'] = $who_viewed_profile_data;
		}
		else
		{
			$data1['errormessage'] = 'No data found';
			$data1['errmessage'] = 'No data found';
			$data1['data'] = array();
			$data1['continue_request'] = FALSE;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}

	## New API : Date : 08-10-2021
	public function i_viewed_contact_app($page=1){	
		$i_contacted_data_count = $this->my_profile_model->i_viewed_contact(0);
		$i_contacted_profile_data1 = $this->my_profile_model->i_viewed_contact(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$i_contacted_profile_data = $this->common_front_model->dataimage_fullurl($i_contacted_profile_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $i_contacted_data_count;
		if(isset($i_contacted_profile_data) && $i_contacted_profile_data!=NULL && $i_contacted_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$i_contacted_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$i_contacted_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($i_contacted_profile_data);
			//$data1['data'] = $who_viewed_profile_data;
		}
		else
		{
			$data1['errormessage'] = 'No data found';
			$data1['errmessage'] = 'No data found';
			$data1['data'] = array();
			$data1['continue_request'] = FALSE;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function like_unlike_profile_app($page=1)
	{	
		$action = $this->input->post('action') ? $this->input->post('action') : 'like';
		
		if($action != 'like'){
			$profile_data_count = $this->my_profile_model->unlike_profile(0);
			$profile_data1 = $this->my_profile_model->unlike_profile(1,$page);
			$parampass = array('photo1' =>'assets/photos/');
			$profile_data = $this->common_front_model->dataimage_fullurl($profile_data1,$parampass,'multiple');
		}else{
			$profile_data_count = $this->my_profile_model->like_profile(0);
			$profile_data1 = $this->my_profile_model->like_profile(1,$page);
			$parampass = array('photo1' =>'assets/photos/');
			$profile_data = $this->common_front_model->dataimage_fullurl($profile_data1,$parampass,'multiple');
		}
		
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $profile_data_count;
		if(isset($profile_data) && $profile_data != NULL && $profile_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$profile_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$profile_data_count.')';
			$data1['data'] = $this->common_front_model->process_data_app($profile_data);
			//$data1['data'] = $profile_data;
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
	}
	/*public function unlike_profile_app($page=1)
	{	
		$unlike_profile_data_count = $this->my_profile_model->unlike_profile(0);
		$unlike_profile_data1 = $this->my_profile_model->unlike_profile(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$unlike_profile_data = $this->common_front_model->dataimage_fullurl($unlike_profile_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $unlike_profile_data_count;
		if(isset($unlike_profile_data) && $unlike_profile_data != NULL && $unlike_profile_data_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$unlike_profile_data_count.')';
			$data1['errmessage'] = 'Total Result found('.$unlike_profile_data_count.')';
			$data1['data'] = $unlike_profile_data;
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
	}*/
	public function common_delete_list_all_profile()
	{	
		$this->my_profile_model->common_delete_list_all_profile();
	}
	public function delete_request_to_admin()
	{
		$this->common_front_model->checkLogin();
		$base_url = $this->data['base_url'];
		//$this->common_model->extra_css_fr= array('css/bootstrap-touch-slider.css','css/mdb.min.css','css/hover-img.css','css/BootSideMenu.css','css/responsive.css');
		//$this->common_model->extra_js_fr= array('js/BootSideMenu.js');
		$this->common_model->extra_css_fr= array('css/select2.css');
		$this->common_model->extra_js_fr= array('js/select2.min.js');
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->front_load_header();
		$this->load->view('front_end/delete_request',$this->data);
		$this->common_model->front_load_footer();
	}
	public function send_delete_reason_admin()
	{
		$this->my_profile_model->send_delete_reason_admin();
	}
	public function photo_pass_request_sent_app($page=1)
	{	
		$photo_pass_count = $this->my_profile_model->photo_pass_request_sent(0);
		$photo_pass_data1 = $this->my_profile_model->photo_pass_request_sent(1,$page);
		
		$photo_pass_data1_temp = array();
		if(isset($photo_pass_data1) && $photo_pass_data1!='' && count($photo_pass_data1)>0){
		foreach ($photo_pass_data1 as $key => $value) {
			$id = $value["user_id"];
			if(isset($id) && $id!='')
			{
				$where_arrra = " id = '$id'" ;
					$data13 = $this->common_front_model->get_count_data_manual('register',$where_arrra,2,'photo_view_status,photo1,photo1_approve','','',1);
					$parampass = array('photo1' =>'assets/photos/');
					$data = $this->common_front_model->dataimage_fullurl($data13,$parampass,'multiple');

					$check_permission_view=array('ph_requester_id'=>$value['ph_requester_id'],'ph_receiver_id '=>$value['ph_receiver_id'],'receiver_response'=>'Accepted','status'=>'1');
					$value['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					
					if(isset($data[0]['photo1']))
					{
						$value['photo1'] = $data[0]['photo1'];
					}
					if(isset($data[0]['photo_view_status']))
					{
						$value['photo_view_status'] = $data[0]['photo_view_status'];
					}
					if(isset($data[0]['photo1_approve']))
					{
						$value['photo1_approve'] = $data[0]['photo1_approve'];
					}
			}
			$photo_pass_data1_temp[]=$value;
		}
	}
				$photo_pass_data = $photo_pass_data1_temp;
		//$photo_pass_data = $photo_pass_data1;
		// $parampass = array('photo1' =>'assets/photos/');
		// $photo_pass_data = $this->common_front_model->dataimage_fullurl($photo_pass_data1,$parampass,'multiple');
		
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $photo_pass_count;
		if(isset($photo_pass_data) && $photo_pass_data!='' && $photo_pass_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$photo_pass_count.')';
			$data1['errmessage'] = 'Total Result found('.$photo_pass_count.')';
			$data1['data'] = $this->common_front_model->process_data_app_image_use($photo_pass_data);
		}
		else
		{
			$data1['errormessage'] = 'No data found';
			$data1['errmessage'] = 'No data found';
			$data1['data'] = '';
			$data1['continue_request'] = FALSE;
		}
		$data11['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data11);
	}
	public function photo_pass_request_received_app($page=1)
	{		
		$photo_pass_count = $this->my_profile_model->photo_pass_request_received(0);
		$photo_pass_request_data1 = $this->my_profile_model->photo_pass_request_received(1,$page);
		$parampass = array('photo1' =>'assets/photos/');
		$photo_pass_request_data = $this->common_front_model->dataimage_fullurl($photo_pass_request_data1,$parampass,'multiple');
		
		
		$photo_pass_data1_temp = array();
		if(isset($photo_pass_request_data) && $photo_pass_request_data!='' && count($photo_pass_request_data)>0){
		foreach ($photo_pass_request_data as $key => $value) {
			$id = $value["user_id"];
			if(isset($id) && $id!='')
			{
					$where_arrra = " id = '$id'" ;
					$data13 = $this->common_front_model->get_count_data_manual('register',$where_arrra,2,'photo_view_status,photo1,photo1_approve','','',1);
					$parampass = array('photo1' =>'assets/photos/');
					$data = $this->common_front_model->dataimage_fullurl($data13,$parampass,'multiple');

					$check_permission_view=array('ph_requester_id'=>$value['ph_requester_id'],'ph_receiver_id '=>$value['ph_receiver_id'],'receiver_response'=>'Accepted','status'=>'1');
					$value['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					
					if(isset($data[0]['photo1']))
					{
						$value['photo1'] = $data[0]['photo1'];
					}
					if(isset($data[0]['photo_view_status']))
					{
						$value['photo_view_status'] = $data[0]['photo_view_status'];
					}
					if(isset($data[0]['photo1_approve']))
					{
						$value['photo1_approve'] = $data[0]['photo1_approve'];
					}
			}
			$photo_pass_data1_temp[]=$value;
		}
	}
				$photo_pass_request_data = $photo_pass_data1_temp;

		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $photo_pass_count;
		if(isset($photo_pass_request_data) && $photo_pass_request_data!=NULL && $photo_pass_count>0)
		{
			$data1['errormessage'] = 'Total Result found('.$photo_pass_count.')';
			$data1['errmessage'] = 'Total Result found('.$photo_pass_count.')';
			$data1['data'] = $this->common_front_model->process_data_app_image_use($photo_pass_request_data);
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
	}
}