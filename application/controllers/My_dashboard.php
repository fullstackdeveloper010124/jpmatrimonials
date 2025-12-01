<?php defined('BASEPATH') OR exit('No direct script access allowed');
class My_dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/matches_model');
		$this->load->model('front_end/dashboard_model');
		$this->load->model('front_end/message_model');
	    $this->load->model('front_end/my_profile_model');
		$this->load->model('front_end/express_interest_model');
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
	}
	public function index()
	{
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr = array('css/chosen.css','css/select2.css','css/popup_user.css','css/myDashboard.css','css/canvasCrop.css');
		$this->common_model->extra_js_fr = array('js/photo_protect_js.js','js/chosen.jquery.js','js/select2.min.js','js/jquery.canvasCrop.js');
		// $this->common_model->extra_js_fr = array('js/photo_protect_js.js','js/chosen.jquery.js','js/select2.min.js');
		
		
		$base_url = $this->data['base_url'];
		/*Recent Joinned Members #start*/
		$_POST['match_type'] = 'recommended';
		$recommendedMember = $this->matches_model->get_search_result(1);
		$this->data['recommendedMember'] = $this->common_front_model->process_data_dashboard($recommendedMember);
		/*Recent Joinned Members #end*/

		/*Recent Joinned Members #start*/
		$curre_gender = $this->common_front_model->get_session_data('gender');
		$whereArrRecent = array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'",'gender!=' => $curre_gender);
		$recentJoin = $this->common_model->get_count_data_manual('search_register_view', $whereArrRecent, 2, '*', 'id desc', 1, 4);
		$this->data['recentJoin'] = $this->common_front_model->process_data_dashboard($recentJoin);
		/*Recent Joinned Members #end*/

		/*Recent Logged in Members #start*/
		$whereArrLogin = array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'" ,'gender!=' => $curre_gender);
		$recentLogin = $this->common_model->get_count_data_manual('search_register_view', $whereArrLogin, 2, '*', 'last_login desc', 1, 4);
		$this->data['recentLogin'] = $this->common_front_model->process_data_dashboard($recentLogin);
		/*Recent Logged in Members #end*/
		$this->common_model->front_load_header();
		$this->load->view('front_end/my_dashboard',$this->data);
		$this->load->view('front_end/photo_protect',$this->data);
		$this->common_model->front_load_footer();
	}
	public function update_percentage_slider_field()
	{
		$this->dashboard_model->update_percentage_slider_field();
	}
	public function generate_otp()
	{
		$response = $this->dashboard_model->generate_otp();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($response));
		//$this->load->view('common_file_echo',$response);
	}
	function varify_mobile_check_otp()
	{
		$response = $this->dashboard_model->varify_mobile_otp();
		if($response == 'success')
		{
			$returnvar['status'] = 'success';
			$returnvar['error_meessage'] = 'Your mobile number verified successfully.';
			$returnvar['errmessage'] = 'Your mobile number verified successfully.';
		}
		else
		{
			$returnvar['status'] = 'error';
			$returnvar['error_meessage'] = $response;
			$returnvar['errmessage'] = $response;
		}
		$returnvar['tocken'] = $this->security->get_csrf_hash();
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($returnvar));
	}
	
	public function recent_profile()
    {
		$member_id = $this->common_front_model->get_user_id();
		if(isset($member_id) && $member_id!='')
		{
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
			
			$curre_gender = $this->common_front_model->get_session_data('gender');
			$where_arra=array("status !='UNAPPROVED' and status !='Suspended'");
			if(isset($curre_gender) && $curre_gender !='')
			{
				$where_arra[] = " gender != '$curre_gender' " ;
			}
			if($user_agent !='NI-WEB')
			{
				$id = $this->input->post('member_id');
				$where_arr = array('id'=>$id);
				$user_data = $this->common_model->get_count_data_manual('register',$where_arr,1,'gender','','','');
				$curre_gender = $user_data['gender'];
				$where_arra[] = " gender != '$curre_gender' " ;
				
			}
			$page = 1;
			$limit = 10;
			if ($this->input->post('page')!='') {
				$page = $this->input->post('page');
			}
            if ($this->input->post('limit')!='') {
				$limit = $this->input->post('limit');
			}
			
			$this->data['member_data'] = $member_data = $this->common_model->get_count_data_manual('search_register_view',$where_arra,2,'*','id desc',$page,$limit);
			$total_count = $this->common_model->get_count_data_manual('search_register_view',$where_arra,0,'','','','');
			
			if($user_agent !='NI-WEB')
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				if(isset($member_data) && $member_data!='')
				{
					$data1['errormessage'] = '';
					$data1['errmessage'] = '';
					$data1['total_count'] = $total_count;
					$data1['continue_request'] = TRUE;
					$data1['data'] = $this->common_front_model->process_data_app($member_data);

					
				}
				else
				{
					$data1['total_count'] = 0;
					$data1['continue_request'] = FALSE;
					$data1['data'] = array();
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
			$data1['errormessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data1['errmessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
    }
	
	public function recently_login()
    {
		$member_id = $this->common_front_model->get_user_id();
		if(isset($member_id) && $member_id!='')
		{
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
			$curre_gender = $this->common_front_model->get_session_data('gender');
			$date = $this->common_model->getCurrentDate();
			$last_month_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). " -1 months "));
			$where_arra=array("status !='UNAPPROVED' and status !='Suspended' and last_login > '$last_month_date' ");
			if(isset($curre_gender) && $curre_gender !='')
			{
				$where_arra[] = " gender != '$curre_gender' " ;
			}
			
			if($user_agent !='NI-WEB')
			{
				$id = $this->input->post('member_id');
				$where_arr = array('id'=>$id);
				$user_data = $this->common_model->get_count_data_manual('register',$where_arr,1,'gender','','','');
				$curre_gender = $user_data['gender'];
				
				$where_arra[] = " gender != '$curre_gender' " ;
			}
			$page = 1;
			$limit = 10;
			if ($this->input->post('page')!='') {
				$page = $this->input->post('page');
			}
            if ($this->input->post('limit')!='') {
				$limit = $this->input->post('limit');
			}
			
			
			
			$this->data['member_data'] = $member_data = $this->common_model->get_count_data_manual('register_view',$where_arra,2,'*','last_login desc',$page,$limit);
			$total_count = $this->common_model->get_count_data_manual('register_view',$where_arra,0,'','','','');
			
			
			
			if($user_agent !='NI-WEB')
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				if(isset($member_data) && $member_data!='')
				{
					$data1['errormessage'] = '';
					$data1['errmessage'] = '';
					$data1['total_count'] = $total_count;
					$data1['continue_request'] = TRUE;
					$data1['data'] = $this->common_front_model->process_data_app($member_data);
				}
				else
				{
					$data1['total_count'] = 0;
					$data1['continue_request'] = FALSE;
					$data1['data'] = array();
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
			$data1['errormessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data1['errmessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
    }
	
	public function resend_confirm_mail()
	{
		$this->dashboard_model->sent_confirm_mail_user();
	}

	## Add Latitude And Longitude : Date : 08-10-2021
	public function add_lat_long(){
		$member_id = $this->common_front_model->get_user_id();
		$status = 'error';
		$errormessage = 'Sorry, Your session has been time out, Please login Again.';
		$errmessage = 'Sorry, Your session has been time out, Please login Again.';
		if(isset($member_id) && $member_id!=''){
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			$latitude = $this->input->post('latitude');
			$longitude = $this->input->post('longitude');
			if($user_agent !='NI-WEB'){
				if($latitude != '' && $longitude != ''){
					$update_arr = array('latitude' => $latitude , 'longitude' => $longitude);
					$where_arr = array('id' => $member_id);
					$this->common_model->update_insert_data_common('register',$update_arr,$where_arr,1,1);
					$status = 'success';
					$errormessage = 'Latitude and Longitude updated successfully.';
					$errmessage = 'Latitude and Longitude updated successfully.';
				}else{
					$errormessage = 'Latitude and Longitude required.';
					$errmessage = 'Latitude and Longitude required.';
				}
			}
		}

		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = $status;
		$data1['errormessage'] =  $errormessage;
		$data1['errmessage'] =  $errmessage;
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}

	## New Code Mobile Verify : Date : 11-10-2021
	public function mobile_verify(){
		$member_id = $this->common_front_model->get_user_id();
		if(isset($member_id) && $member_id!=''){
			$status  = 'success';
			$update_arr = array('mobile_verify_status' => "Yes");
			$update_where = array('id' => $member_id);
			$row_data2 = $this->common_model->update_insert_data_common('register', $update_arr,$update_where,1,1);
			$row_data = $this->common_model->get_count_data_manual('register',$update_where,1);
			if(isset($row_data) && $row_data !='' && count($row_data) > 0){
				$status  = 'success';
				if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1'])){
					$row_data['photo1'] = base_url().$this->common_model->path_photos.$row_data['photo1'];
				}else{
					if(isset($row_data['gender']) && $row_data['gender'] =='Male'){
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-male.gif';
					}else{
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-female.gif';
					}
				}
				if(isset($row_data['plan_status']) && $row_data['plan_status'] =='Paid'){
					$row_data['plan_chat'] = $this->common_front_model->get_plan_detail($row_data['matri_id'],'chat','Yes');
				}
				$row_data['logged_in'] = 1;
				$data1['user_data'] = $row_data;
				$data1['plan_id'] = '';
			}else{
				$return_message = "Your username and password is wrong. Please try again...";
			}
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = $status;
			$data1['errormessage'] = $return_message;
			$data1['errmessage'] = $return_message;
		}else{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'error';
			$data1['errormessage'] =  "Sorry, Your session has been time out, Please login Again";
			$data1['errmessage'] =  "Sorry, Your session has been time out, Please login Again";
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function get_dashboard_data(){
		$responseArr['tocken'] = $this->security->get_csrf_hash();
		$responseArr['status'] = 'error';
		$responseArr['data'] = array();
		$responseArr['errormessage'] = "Something went wrong!";
		if($this->input->post()){
		  //  echo $this->input->post('member_id');exit;
		    if($this->input->post('user_agent') =='NI-AAPP' )
		    {
		        $member_id = $this->input->post('member_id');
		    }
		    else
		    {
			    $member_id = $this->common_front_model->get_user_id();
		    }
			
			if(isset($member_id) && $member_id!=''){
			
			    $user_data1 = $this->common_model->get_count_data_manual('register',array('id' => $member_id,'status' => 'APPROVED'),2,'id,gender,matri_id,username,photo1','id desc','','');
			    
				if(!empty($user_data1)){
					$parampass = array('photo1' =>'assets/photos/');
					$user_data = $this->common_front_model->dataimage_fullurl($user_data1,$parampass,'single');
				
					$_POST['match_type'] = 'recommended';
					
					
					
					
					## Get Premium Match Count : 
					$_POST['match_type'] = 'premium-match';
					## Get Recent Join Data : Date : 21-03-2023
					$curre_gender = $user_data1[0]['gender'];
				// 	$user_type_on_per = $user_data['user_type'];
					$where_arra = array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'",'gender!=' => $curre_gender);
					$recentJoinCount = $this->common_model->get_count_data_manual('search_register_view',$where_arra,0);
					$recentJoinList = $this->common_model->get_count_data_manual('search_register_view',$where_arra,2,'*','id desc',1,7);
					$recentJoinList = $this->common_front_model->process_data_app($recentJoinList);
					if($recentJoinCount == 0){
						$recentJoinList = array();
					}else{
						foreach($recentJoinList as $key => $value){
							$recentJoinList[$key] = $this->common_front_model->photo_process($value);
						}
					} 
                    $date = $this->common_model->getCurrentDate();
					$last_month_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). " -1 months "));
					$whereArrLogin =array("status !='UNAPPROVED' and status !='Suspended' and last_login > '$last_month_date' and gender != '$curre_gender'");
		            // $whereArrLogin = array('is_deleted'=>'No',"status !='UNAPPROVED' and status !='Suspended'" ,'gender!=' => $curre_gender);
		            $recentLoginCount = $this->common_model->get_count_data_manual('search_register_view', $whereArrLogin,0);
		            $recentLoginList = $this->common_model->get_count_data_manual('search_register_view', $whereArrLogin, 2, '*', 'last_login desc', 1, 4);
		            $recentLoginList = $this->common_front_model->process_data_dashboard($recentLoginList);
		            if($recentLoginCount == 0){
						$recentLoginList = array();
					}else{
						foreach($recentLoginList as $key => $value){
							$recentLoginList[$key] = $this->common_front_model->photo_process($value);
						}
					}
		       
		            
		            $short_list_data_count = $this->my_profile_model->short_list_profile(0);
		              	   //echo "asdf";exit;
            		$short_list_data  = $this->my_profile_model->short_list_profile(1,$page);
            		$short_list_data = $this->common_front_model->process_data_dashboard($short_list_data);
		            if($short_list_data_count == 0){
						$short_list_data = array();
					}else{
						foreach($short_list_data as $key => $value){
							$short_list_data[$key] = $this->common_front_model->photo_process($value);
						}
					}
            // 		$short_list_data  = !empty($short_list_data)?$short_list_data:array();
            		
            // 	print_r($short_list_data);exit;
            		
            		$all_interest_received_count = $this->express_interest_model->all_sent_interest(0);
	            	$all_interest_received_data = $this->express_interest_model->all_sent_interest(1,$page);
	            	$all_interest_received_data = $this->common_front_model->process_data_dashboard($all_interest_received_data);
		            if($all_interest_received_count == 0){
						$all_interest_received_data = array();
					}else{
						foreach($all_interest_received_data as $key => $value){
							$all_interest_received_data[$key] = $this->common_front_model->photo_process($value);
						}
					}
            		$all_interest_received_data = !empty($all_interest_received_data)?$all_interest_received_data:array();

		          
		            
					$siteConfig = $this->common_model->get_site_config();
					$returnData['member_data'] = $user_data;
				// 	$returnData['recommanded_count'] = $recommandedCount;
				// 	$returnData['recommanded_list'] = $recommandedList;
					$returnData['recently_joined_count'] = $recentJoinCount;
					$returnData['recently_joined_list'] = $recentJoinList;
					$returnData['recently_login_count'] = $recentLoginCount;
					$returnData['recently_login_list'] = $recentLoginList;
				// 	$returnData['featured_profile_count'] = $featuredProfileCount;
				// 	$returnData['featured_profile_list'] = $featuredProfileList;
					$returnData['short_list_data_count'] = $short_list_data_count;
					$returnData['short_list_data'] = $short_list_data;
					$returnData['all_interest_received_count'] = $all_interest_received_count;
					$returnData['all_interest_received_data'] = $all_interest_received_data;
					
				

					$responseArr['data'] = $returnData;
					$responseArr['status'] = 'success';
					$responseArr['errormessage'] =  "Data get successfully.";
				}else{
					$responseArr['status'] = 'error';
					$responseArr['errormessage'] =  "Member not found!";
				}
			}else{
				$responseArr['status'] = 'error';
				$responseArr['errormessage'] =  "Sorry, Your session has been time out, Please login Again";
			}
		}
		echo json_encode($responseArr);
	}
}