<?php defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties] // PHP version 8.2
class Common_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		session_regenerate_id();
		$success_array = array(
			'add' =>'Data inserted successfully.',
			'edit' =>'Data updated successfully.',
			'error' =>'Some error occured, please try again.',
			'delete'=>'Data deleted successfully.',
			'error_file' =>'Some error occured when file upload, please try again.'
		);
		$this->success_message = $success_array;
		$this->extra_css = array('vendor/checkbo/src/0.1.4/css/checkBo.min.css');
		$this->extra_js = array(
								'vendor/jquery-validation/dist/jquery.validate.min.js',
								'vendor/jquery-validation/dist/additional-methods.min.js',
								'vendor/checkbo/src/0.1.4/js/checkBo.min.js');
			// default load css and js add in above arra, as we need to load css and js in admin
		$this->extra_css_fr = array();
		$this->extra_js_fr = array();
		$this->mode = 'add';
		$this->js_validation_extra ='';	//  concate  js validation code
		$this->js_extra_code ='';	// concate js code load in bottom

		$this->js_validation_extra_fr = '';
		$this->js_extra_code_fr ='';
		$this->css_extra_code_fr ='';
	// main tabel
		$this->table_name ='';
		$this->table_name_dot='';
		$this->table_field ='';
		$this->status_field = 'status';
		$this->assing_to_member = 'no';
		$this->change_interest = 'no';
		$this->member_or_lead = 'member';
	// main tabel
	// for relation, Join tabel
		$this->join_tab_array = '';
		$this->join_tab_array_filed_disp = array();
		$this->filed_notdisp = array();

	// for relation, Join tabel
		$this->primary_key ='id';
		$this->data_tabel_filedIgnore = array('id','is_deleted');
		$this->data_tabel_filed = array();
		$this->data_tabel_data = '';
		$this->data_tabel_filtered_count = 0;
		$this->data_tabel_all_count = 0;
		$this->search_filed = '';
		$this->limit_per_page = 10; // need to change here for page per limit
		$this->pagination_link ='';
		$this->page_number=1;
		$this->admin_path = $this->data['admin_path'] = $this->getconfingValue('admin_path');
		$this->class_name = $this->router->fetch_class();
		$this->method_name = $this->router->fetch_method();
		$this->success_url = $this->method_name;
		$this->failure_url = $this->method_name;

		$this->action = $this->router->fetch_class().'/'.$this->method_name.'/save-data';

		$this->add_fun = $this->method_name.'/add-data';
		$this->base_url_admin_cm_status = $this->base_url_admin_cm = base_url().$this->admin_path.'/'.$this->class_name.'/'.$this->method_name.'/';
		$this->start = 0;
		$this->data_table_parameter = '';
		$this->status_mode ='';
		$this->status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED');
		$this->staffassign_arr_change = array();
		$this->franchiseassign_arr_change = array();
		$this->status_column = 'status';
		$this->label_col = 3;
		$this->form_control_col = 7;

		// for view detail pagge
		$this->detail_label_col = 4;
		$this->detail_val_col = 8;
		$this->detail_class_width = 'col-lg-4 col-md-6 col-sm-12 col-xs-6';
		// for view detail pagge
		//$this->max_size_file_upload = 3072;
		$this->max_size_file_upload = 3085;

		$this->addPopup = 0;
		$this->button_array = array();
		$this->last_insert_id = '';
		$this->labelArr = array('country_id'=>'Country Name','state_id'=>'State Name','city_id'=>'City Name','photo1_approve'=>'Status','photo2_approve'=>'Status','photo3_approve'=>'Status','photo4_approve'=>'Status','photo5_approve'=>'Status','photo6_approve'=>'Status','photo7_approve'=>'Status','photo8_approve'=>'Status','photo1_uploaded_on'=>'Uploaded On','photo2_uploaded_on'=>'Uploaded On','photo3_uploaded_on'=>'Uploaded On','photo4_uploaded_on'=>'Uploaded On','photo5_uploaded_on'=>'Uploaded On','photo6_uploaded_on'=>'Uploaded On','photo7_uploaded_on'=>'Uploaded On','photo8_uploaded_on'=>'Uploaded On','id_proof_approve'=>'Status','horoscope_photo_approve'=>'Status','exp_date'=>'Plan Expired','p_currency'=>'Currency','id_proof_uploaded_on'=>'Uploaded On','horoscope_photo_uploaded_on'=>'Uploaded On','franchise_comm_amt'=>'Commission Amount','franchise_comm_per'=>'Commission Percentage','mtongue_name'=>'Mother Tongue','plan_msg'=>'Plan Message'); // here we can set common label change for coloumn name
		$this->data['base_url'] = $this->base_url = base_url();
		$this->data['base_url_admin'] = $this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->data['config_data'] = $this->get_site_config();
		$this->label_page='';
		$this->permenent_delete = 'no';
		$this->is_delete_fild = 'is_deleted';
		$this->created_on_fild = 'created_on';
		$this->display_date_arr = array('created_on', 'register_date', 'last_login', 'birthdate', 'posted_on', 'photo1_uploaded_on', 'photo2_uploaded_on', 'photo3_uploaded_on', 'photo4_uploaded_on', 'photo5_uploaded_on', 'photo6_uploaded_on', 'photo7_uploaded_on', 'photo8_uploaded_on', 'registered_on', 'plan_activated', 'plan_expired','event_date','marriagedate','plan_exp','expired_on','active_from','plan_expired_on','horoscope_photo_uploaded_on','id_proof_uploaded_on','cover_photo_uploaded_on','sent_on','visit_time','assign_date','reg_date','next_followup_date');
		$this->display_currency_arr = array('p_amount', 'tax_amount','discount_amount','grand_total','ticket','price','franchise_comm_amt','plan_amount');
		$this->field_duplicate = '';
		$this->other_config = '';
		$this->ele_array ='';
		$this->data_not_availabel ='N/A';
		$this->display_selected_field = '';
		$this->edit_row_data = '';
		$this->session_search_name = ''; // for adding search where from filter form please assign here name as your controller name for search
		$this->photo_avtar = 'assets/back_end/images/avatar-placeholder.png';
		$this->photo_upload_count = 6; // not more then 8

		// path for image file
		$this->path_cover_photo = 'assets/cover_photo/';
		$this->default_cover_photo = 'assets/front_end_new/images/dshbrd_profile_img.png';
		$this->path_photos = 'assets/photos/';
		$this->path_photos_big = 'assets/photos_big/';
		$this->path_advertise = 'assets/advertise/';
		$this->path_banner = 'assets/banner/';
		$this->path_mobile_matri_banner = 'assets/mobile_matri_banner/';
		$this->other_banner = 'assets/other_banner/';
		$this->path_blog = 'assets/blog_image/';
		$this->path_events = 'assets/events-list/';
		$this->path_horoscope = 'assets/horoscope-list/';
		$this->path_id_proof = 'assets/id_proof/';
		$this->path_payment_logo = 'assets/payment_logo/';
		$this->path_success = 'assets/success-story/';
		$this->path_video = 'assets/video-list/';
		$this->path_wedding = 'assets/wedding-planner/';
		$this->path_ip = 'assets/check_ip/';
		$this->no_image_found = 'assets/images/no_image.png';
		$this->planCategoryImg = 'assets/plan_category';
		// path for image file
		$this->path_vendor_category = 'assets/vendor-category/'; // ve
		$this->set_permission_array(); // for permission all page releted

		$this->email_templ_data = '';//For sms send mail
		$this->sms_templ_data = '';//For sms send mail

		$this->android_app = '1.0';//android current version
		$this->ios_app = '1.0';//ios current version

		$this->ignore_xss_filter = array('packages_deals','description','google_adsense','page_content','content','comment','email_content','parameter','success_response','error_response','google_analytics_code');
		$this->check_for_update_expired(); //need to uncommment after function update assigned to farhin.

		// for display in demo only
		$this->is_demo_mode = 0;	// 1 = Demo Mode, 0 =  Live mode
		$this->email_disp = 'demo@gmail.com';
		$this->emial_disp = 'demo@gmail.com';
		$this->mobile_disp = '+9199999999999';
		$this->mobile_disp_edit = '99999999999';
		$this->disable_in_demo_text = 'Disable in demo';
		// for display in demo


		//for developer tool
		//ticket managment------------start---
		$config_data = $this->data['config_data'];

		$this->path_ticket = 'ticket_attachment/';
		$this->client_id = $config_data['client_id'];//'317';	// set clinet id
		$this->ticket_prefix = 'MG';
		$this->project_id = 13;	// project id, dont need to change
		$this->web_appkey = $config_data['web_appkey'];//'2e21096c91e379fb0ff09d88d4e2ad74';	// set webapp key


		if(base_url() =='http://192.168.1.111/mega_matrimony/original_script/')
		{
			$this->call_curl_url_ticket ='http://192.168.1.111/client_management/common_request/update_from_client_ticket';
		}
		else
		{
			//$this->call_curl_url_ticket ='https://www.narjisinfotech.com/new_client/common_request/update_from_client_ticket';
			$this->call_curl_url_ticket ='https://clients.narjisinfotech.com/common_request/update_from_client_ticket';
		}
		//ticket managment------------End---
	}

	public function check_for_update_expired()
	{
		$config_data = $this->data['config_data'];
		$current_date_site = $config_data['current_date_crone'];
		$current_data = $this->getCurrentDate('Y-m-d');
		if($current_date_site != $current_data)
		{
			// for vendor plan
			$id = $config_data['id'];
			$where = array('plan_status'=>'Paid'," plan_expired_on < '$current_data' ",'is_deleted'=>'No');

			$row_data = $this->get_count_data_manual('register',$where,2,'id,web_device_id,ios_device_id,android_device_id','id asc','','');
			$this->update_insert_data_common('register',array('plan_status'=>'Expired'),$where,1,0);
			if(isset($row_data) && $row_data!='' && count($row_data)>0){
				foreach($row_data as $row_val){
					$web_id = $row_val['id'];
					$web_device_id = $row_val['web_device_id'];
					$ios_device_id = $row_val['ios_device_id'];
					$android_device_id = $row_val['android_device_id'];
					$expired_msg = 'Your plan has been expired';
					if(isset($web_device_id) && $web_device_id!= ''){
						$data_array = array(
							'device_id'=>$web_device_id,
							'sender_id' => 'Admin',
							'receiver_id' => $web_id,
							'notification_type' => 'plan_expired',
							'title' => 'Plan Expired',
							'message' => $expired_msg,
							'click_action'=>base_url().'premium-member',
						);
						$this->common_model->new_send_notification_web($data_array);
					}
					if(isset($ios_device_id) && $ios_device_id!=''){
						$sender_receiver = array(
							'sender'=>'Admin',
							'receiver'=>$row_val['id'],
							'app_type'=>'IOS'
						);
						$this->common_model->new_send_notification_android($ios_device_id,$expired_msg,'Plan Expired','plan_expired',$row_val['id'],'','',$sender_receiver);
					}
					if(isset($android_device_id) && $android_device_id!=''){
						$sender_receiver = array('sender'=>'Admin','receiver'=>$row_val['id'],'app_type'=>'Android');
						$this->common_model->new_send_notification_android($android_device_id,$expired_msg,'Plan Expired','plan_expired',$row_val['id'],'','',$sender_receiver);
					}
				}
			}
			// for vendor plan
			// update date in site_config
			$this->update_insert_data_common('site_config',array('current_date_crone'=>$current_data),array('id'=>$id),1);
		}
	}

	function set_permission_array()
	{
		$this->permission_array = array();
		$user_type = $this->get_session_user_type();
		if($user_type =='staff')
		{
			$role = $this->get_session_data('role');
			if($role !='')
			{
				$role_arr = $this->get_count_data_manual('staff_role',array('id'=>$role),1);
				if(isset($role_arr) && $role_arr !='')
				{
					$this->permission_array = $role_arr;
				}
			}
		}
		else if($user_type =='franchise')
		{
			$role_arr = $this->get_count_data_manual('franchise_role',array('id'=>1),1);
			if(isset($role_arr) && $role_arr !='')
			{
				$this->permission_array = $role_arr;
			}
		}
	}
	function check_permission($permission_type = '',$return='')
	{
		$user_type = $this->get_session_user_type();
		$return_val = 'No';
		if($user_type =='admin')
		{
			$return_val = 'admin';
		}
		else
		{
			$permission_array = $this->permission_array;
			if(isset($permission_array[$permission_type]) && $permission_array[$permission_type] !='')
			{
				$return_val = $permission_array[$permission_type];
			}
		}
		if($return =='redirect' && $return_val =='No')
		{
			redirect($this->base_url_admin.'dashboard');
		}
		else
		{
			return $return_val;
		}
	}
	function add_own_where($other_config = '',$perm_val='',$perm_name='')
	{
		$user_type = $this->common_model->get_session_user_type();
		$u_id = $this->common_model->get_session_data('id');
		$personal_where = array();
		if($perm_val =='')
		{
			$perm_val = $this->common_model->check_permission($perm_name,'');
		}
		if($other_config =='' || !is_array($other_config))
		{
			$other_config = array();
		}
		if(isset($other_config['personal_where']) && $other_config['personal_where'] !='')
		{
			$personal_where[] = $other_config['personal_where'];
		}
		if($perm_val =='Own Members')
		{
			if($user_type =='staff')
			{
				if($u_id !='')
				{
					$personal_where[] = " adminrole_id = '$u_id' ";
				}
			}
			else if($user_type =='franchise')
			{
				$personal_where[] = " franchised_by = '$u_id' ";
			}
		}
		if(isset($personal_where) && $personal_where !='' && is_array($personal_where) && count($personal_where) > 0)
		{
			$personal_where_str = implode(' and ',$personal_where);
			$other_config['personal_where'] = "(".$personal_where_str.")";
		}
		return $other_config;
	}
	function getCurrentDate($dformat='Y-m-d H:i:s')
	{
		//date_default_timezone_set('UTC'); // already set in config
		return date($dformat);
	}
	function callCURL($url='')
	{
		$return_res ='';
		if($url !='')
		{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
			curl_setopt($ch, CURLOPT_TIMEOUT, 4);
			$return_res = curl_exec($ch);
			curl_close($ch);
		}
		return $return_res;
	}
	public function curl_call_ticket($data = array())
	{

		$result = '';
		$curl_url = $this->call_curl_url_ticket;
		if($curl_url !='')
		{
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, $curl_url );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, $data );
			$result = curl_exec($ch );
			curl_close( $ch );
		}

		return $result;
	}
	function displayDate($date = '',$dformat='F j, Y h:i A')// Y-m-d h:i:s
	{
		if($date =='0000-00-00' ||  $date =='0000-00-00 00:00:00')
		{
			return $this->data_not_availabel;
		}
		else if($date !='' && $dformat !='')
		{
			$time_zone ='';
			if(!$this->session->userdata('time_zone') || $this->session->userdata('time_zone') =="" )
			{
				$time_zone = 'Asia/Kolkata';
				// commented by mustakim for not using cookie
					/*
					$cookie_data = get_cookie("mega_matri_data");
					if(isset($cookie_data) && $cookie_data !='')
					{
						$cookie_data_arr = json_decode($cookie_data);
						if(isset($cookie_data_arr) && $cookie_data_arr !='' && count($cookie_data_arr) > 0)
						{
							if(isset($cookie_data_arr->time_zone) && $cookie_data_arr->time_zone !='')
							{
								$time_zone = $cookie_data_arr->time_zone;
							}
						}
					}
					*/
				// commented by mustakim for not using cookie
				if($time_zone =='')
				{
					$final_api = 'http://ip-api.com/json/';
					$response_data = $this->callCURL($final_api);
					if($response_data !='')
					{
						$response_data = json_decode($response_data);
						if(isset($response_data->status) && $response_data->status == 'fail')
						{
							$ip = $this->input->ip_address();
							if($ip !='')
							{
								$final_api_call= $final_api.$ip;
								$response_data = $this->callCURL($final_api_call);
								if($response_data !='')
								{
									$response_data = json_decode($response_data);
								}
							}
						}
					}
					if(isset($response_data->timezone) && $response_data->timezone != '')
					{
						$time_zone = $response_data->timezone;
					// commented by mustakim for not using cookie
						// for set cookie for time zone
						/*
							$data_arr = array("time_zone"=>$time_zone);
							$data_arr = json_encode($data_arr);
							$cookie = array(
								'name'   => 'mega_matri_data',
								'value'  => $data_arr,
								'expire' => '864000'
							);
							delete_cookie('mega_matri_data');
							$this->input->set_cookie($cookie);
						*/
						// for set cookie for time zone
					// commented by mustakim for not using cookie
					}
					//print_r($response_data);
				}
				if($time_zone !='')
				{
					$this->session->set_userdata('time_zone', $time_zone);
				}
			}
			else
			{
				//$time_zone = $this->session->userdata('time_zone');
				$time_zone = 'Asia/Kolkata';
			}
			if($time_zone =='')
			{
				$time_zone = 'Asia/Kolkata';
			}
			if(strlen($date) == 10)
			{
				$dformat = str_replace('h:i A','',$dformat);
			}

			$strtime = strtotime($date);
			date_default_timezone_set($time_zone);
			$date_retuen = date($dformat,$strtime);
			//date_default_timezone_set('UTC'); // already set in config
			return $date_retuen;
		}
		else
		{
			return $this->data_not_availabel;
		}
	}
	public function display_height($val='')
	{
		$date_retuen = $this->data_not_availabel;
		if($val !='')
		{

			if($val ==48)
			{
				$date_retuen = 'Below 4ft';
			}
			else if($val ==85)
			{
				$date_retuen = 'Above 7ft';
			}
			else
			{
				$foot = (int) ($val/12);
				$inch = $val%12;
				$date_retuen = $foot.'ft';
				if($inch > 0)
				{
					$date_retuen = $date_retuen.' '.$inch.'in';
				}
			}
		}
		return $date_retuen;
	}
	public function birthdate_disp($val='',$b_date_disp = 1)
	{
		$date_retuen = $this->data_not_availabel;
		if($val !='' && $val !='0000-00-00')
		{
			$date_retuen = '';
			$yeea_disp = floor((time() - strtotime($val))/31556926).' Years';
			if($b_date_disp == 1)
			{
				$date_retuen = $this->displayDate($val,"d/m/Y");
				$date_retuen.= ' ('.$yeea_disp.')';
			}
			else
			{
				$date_retuen= $yeea_disp;
			}

		}
		return $date_retuen;
	}
	public function __load_header($label_page='',$status='')
	{
		$this->label_page = $label_page;
		$page_title = $label_page;
		if($status !='')
		{
			$page_title = $page_title.' - '.$status;
		}
		$this->data['page_title'] = $page_title;
		$this->load->view('back_end/page_part/header',$this->data);
	}
	public function __load_footer($model_body='')
	{
		$this->data['model_body'] = $model_body;
		$this->data['model_title'] = 'Add '.$this->label_page;
		$this->load->view('back_end/page_part/footer',$this->data);
	}
	// public function front_load_header_matrimony($matrimony_data=array())
	// {
	// 	$this->data['matrimony_data'] = $matrimony_data;

	// 	$this->load->view('front_end/page_part/header_matrimony',$this->data);
	// }
	   // shakil changes seo 
	public function front_load_header_matrimony($matrimony_data=array(),$label_page='',$status='',$seo_title='',$seo_description='',$seo_keywords='',$og_title='',$og_description='',$og_image='')
	{
		$this->label_page = $label_page;
		$page_title = $label_page;
		if($status !='')
		{
			$page_title = $page_title.' - '.$status;
		}
		$this->data['page_title'] = $page_title;
		$this->data['seo_title'] = $seo_title;
		$this->data['seo_description'] = $seo_description;
		$this->data['seo_keywords'] = $seo_keywords;
		$this->data['og_title'] = $og_title;
		$this->data['og_description'] = $og_description;
		$this->data['og_image'] = $og_image;
		$this->data['matrimony_data'] = $matrimony_data;

		$config_data = $this->common_model->data['config_data'];
		if(isset($config_data["home_page"]) && $config_data["home_page"]!='0'){
			$home_page = $config_data["home_page"];	
		}else{
			$home_page = 1;
		}
		$this->load->view('front_end/page_part/header_matrimony_'.$home_page,$this->data);
	}
	public function front_load_header($label_page='',$status='',$seo_title='',$seo_description='',$seo_keywords='',$og_title='',$og_description='',$og_image='')
	{
		$this->label_page = $label_page;
		$page_title = $label_page;
		if($status !='')
		{
			$page_title = $page_title.' - '.$status;
		}
		$this->data['page_title'] = $page_title;
		$this->data['seo_title'] = $seo_title;
		$this->data['seo_description'] = $seo_description;
		$this->data['seo_keywords'] = $seo_keywords;
		$this->data['og_title'] = $og_title;
		$this->data['og_description'] = $og_description;
		$this->data['og_image'] = $og_image;

		//$this->load->view('front_end/page_part/header',$this->data);
		$config_data = $this->common_model->data['config_data'];
		if(isset($config_data["home_page"]) && $config_data["home_page"]!='0'){
			$home_page = $config_data["home_page"];	
		}else{
			$home_page = 1;
		}
		$this->load->view('front_end/page_part/header_'.$home_page,$this->data);
	}
	public function front_load_footer($model_body='')
	{
		$this->data['model_body'] = $model_body;
		$this->data['model_title'] = 'Add '.$this->label_page;
		$config_data = $this->common_model->data['config_data'];
		if(isset($config_data["home_page"]) && $config_data["home_page"]!='0'){
			$home_page = $config_data["home_page"];	
		}else{
			$home_page = 1;
		}
		$this->load->view('front_end/page_part/footer_'.$home_page,$this->data);
	}


	public function checkLogin($type='redirect')
	{
		if(!$this->session->userdata('matrimonial_user_data') || $this->session->userdata('matrimonial_user_data') =="" && count($this->session->userdata('matrimonial_user_data')) ==0 )
		{
			$base_url = base_url();
			$admin_path = $this->getconfingValue('admin_path');
			if($type == 'redirect')
			{
				redirect($base_url.$admin_path.'/login');
			}
			else if($type == 'return')
			{
				return false;
			}
		}
		else
		{
			if($type == 'return')
			{
				return true;
			}
		}
	}
	public function set_table_name($table_name='')
	{
		if($table_name !='')
		{
			$this->table_name = $this->table_name = $table_name;
			$this->table_name_dot = $table_name.'.';
			if($this->display_selected_field =='')
			{
				$this->table_field = $this->db->list_fields($this->table_name);

			}
			else
			{
				$this->table_field = $this->display_selected_field;
			}

		}
	}
	function password_hash($password='')
	{
		//$this->load->library('phpass');
		//$hashed_pass = $this->phpass->hash($password);
		return md5($password);
	}
	function getjson_response()
	{
		$data_return = array();
		if($this->session->flashdata('success_message'))
		{
			$data_return['response'] = '<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('success_message').'</div>';
			$data_return['status']   = 'success';
			$this->session->unset_userdata('success_message');
		}
		else if($this->session->flashdata('error_message'))
		{
			$data_return['status']   = 'error';
			$data_return['response'] = '<div class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('error_message').'</div>';
			$this->session->unset_userdata('error_message');
		}
		$data_return['tocken'] = $this->security->get_csrf_hash();
		return json_encode($data_return);
	}
	public function update_status_var($status)
	{
		$this->status_mode = $status;
		$this->base_url_admin_cm_status = $this->base_url_admin_cm.$status.'/';
	}
	public function get_site_config()
	{
       	$this->db->limit(1);
		$query = $this->db->get_where('site_config', array('id' => 1));
       	return $query->row_array();
	}
	public function get_session_data_comm($session_name = '')
	{
		$data_return = '';
		if($session_name !='')
		{
			$data_return = $matrimonial_user_data = $this->session->userdata($session_name);
		}
		return $data_return;
	}
	public function get_session_data($return_filed='')
	{
		$matrimonial_user_data = $this->session->userdata('matrimonial_user_data');
		$return_val = '';
		if($return_filed =='')
		{
			$return_val = $matrimonial_user_data;
		}
		else
		{
			if(isset($matrimonial_user_data[$return_filed]) && $matrimonial_user_data[$return_filed] !='')
			{
				$return_val = $matrimonial_user_data[$return_filed];
			}
		}

		return $return_val;
	}
	public function check_admin_only_access()
	{
		$user_type = $this->get_session_user_type();
		if($user_type == 'admin')
		{
			return true;
		}
		else if($user_type == 'staff' || $user_type == 'franchise')
		{
			redirect($this->base_url_admin.'dashboard');
		}
		else
		{
			redirect($this->base_url_admin.'login');
		}
	}
	public function get_session_user_type()
	{
		$user_daat = $this->get_session_data();
		$user_type = '';
		if(isset($user_daat['user_type']) && $user_daat['user_type'] !='')
		{
			$user_type = $user_daat['user_type'];
		}
		return $user_type;
	}
	public function common_send_email($to_array,$subject,$message,$cc_array= '',$bcc_array ='',$attachment = '')
    {
    	 
     $config_arra = $this->get_site_config();
 	 
   	 $from_email = $config_arra['from_email'];

   	 $temp_data_arr = array();
   	 if(isset($config_arra['web_frienly_name']) && isset($config_arra['web_name']))
   	 {
   		 $temp_data_arr = array('webfriendlyname'=>$config_arra['web_frienly_name'],'web_frienly_name'=>$config_arra['web_frienly_name'],'websiteurl'=>$config_arra['web_name'],'web_name'=>$config_arra['web_name']);
   	 }
   	 

   	 if(isset($config_arra['upload_logo']) && $config_arra['upload_logo'] !='')
   	 {
   		 $temp_data_arr[base_url().'assets/email_template/logo22.png'] = base_url().'assets/logo/'.$config_arra['upload_logo'];
   		 $temp_data_arr[base_url().'assets/email_template/logo2.png'] = base_url().'assets/logo/'.$config_arra['upload_logo'];
   	 }
   	 
		$header = "From: ".$config_arra['web_frienly_name']." <".$from_email."> \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";

		$subject = $this->common_front_model->getstringreplaced($subject,$temp_data_arr);
		$message = $this->common_front_model->getstringreplaced($message,$temp_data_arr);
   	 
    	$retval = mail($to_array,$subject,$message,$header);
     	if( $retval == true ) {
        	$msg = "Message sent successfully...";
     	}else {
        	$msg = "Message could not be sent...";
     	}
     	return $msg;
    }
	public function common_sms_send($mobile,$sms,$template_id)
	{
		
		if($mobile !='' && $sms !='')
		{
			$config_arra = $this->get_site_config();
			$sms_api = $config_arra['sms_api'];
			$sms_api_status = $config_arra['sms_api_status'];
			if($sms_api_status !='' && $sms_api_status =='APPROVED' && $sms_api !='')
			{
				$mobile_arr = explode('-',$mobile);
				$mobile_ext ='';
				//$mno = '';
				if(isset($mobile_arr[0]) && $mobile_arr[0] !='')
				{
					$mobile_ext = $mobile_arr[0];
				}
				/*if(isset($mobile_arr[1]) && $mobile_arr[1] !='')
				{
					$mno = $mobile_arr[1];
				}*/
				//$mobile_ext = substr($mobile,0,3);
				$mobile_new = $mobile;
				if(strlen($mobile) == 13 && substr($mobile, 0, 3) == "+91"){
					$mobile_new = substr($mobile, 1, 10);
				}
				else if(strlen($mobile) == 14 && substr($mobile, 0, 4) == "+91-"){
					$mobile_arr = explode('+',$mobile);
					if(isset($mobile_arr[1]) && $mobile_arr[1] !=''){
						$mobile_new = str_replace("-", "", $mobile_arr[1]);
					}
				}
				$temp_data_arr = array();
				if(isset($config_arra['web_frienly_name']) && isset($config_arra['web_name']))
				{
					$temp_data_arr = array('webfriendlyname'=>$config_arra['web_frienly_name'],'web_frienly_name'=>$config_arra['web_frienly_name'],'websiteurl'=>$config_arra['web_name'],'web_name'=>$config_arra['web_name']);
				}
				$sms = $this->common_front_model->getstringreplaced($sms,$temp_data_arr);
				if($mobile_ext == '+91')
				{
					$sms = urlencode($sms);
					$sms_api = str_replace("##contacts##",$mobile_new,$sms_api);
					if(isset($template_id) && $template_id!='')
					{
						$sms_api = str_replace("##template_id##",$template_id,$sms_api);
					}
					$sms_api = str_replace("##sms_text##",$sms,$sms_api);
					$final_api=$sms_api;
					$base_url = base_url();
					$ch = curl_init($final_api);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
					curl_setopt($ch, CURLOPT_TIMEOUT, 3);
					$curl_scraped_page = curl_exec($ch);
					$json = json_decode($curl_scraped_page);
					$return_otp = 'success';
					curl_close($ch);
					return $return_otp;
					
				}
				else
				{ 
					// need to uncomment for send sms
				// require_once(FCPATH.'twilio_library/Services/Twilio.php');
				// 	$account_sid = " "; // Your Twilio account sid
				// 	$auth_token = " "; // Your Twilio auth token
					
				// 	try{
    			// 		$client = new Services_Twilio($account_sid, $auth_token);
    			// 		$message = $client->account->messages->sendMessage(
    			// 		  ' ', // From a Twilio number in your account
    			// 		  $mobile_new,//'+', // Text any number
    			// 		  $sms
    			// 		);
				// 	}
				// 	catch(Exception $e) {
                //     //  print_r($e);exit;
                //     }
					// need to uncomment for send sms
				}
			}
		}
	}
	function last_query()
	{
		return $this->db->last_query();
	}

	function add_latin($key='',$val='')
	{
		$return_str ='';
		if($key !='' && $val !='')
		{
			$val = $this->db->escape_str($val);
			$return_str ="$key = ( _latin1 '".$val."') ";
		}
		return $return_str;
	}
	function get_count_data_manual($table,$where_arra='',$flag_count_data = 0,$select_f ='',$order_by='',$page='',$limit='',$is_delet_field = 1,$disp_query = "")
	{
		if($table !='')
		{
			if(isset($is_delet_field) && $is_delet_field ==1 && $this->is_delete_fild !='')
			{
				$this->db->where($table.'.'.$this->is_delete_fild,'No');
			}
			if($where_arra !='' && is_array($where_arra) && count($where_arra) >0)
			{
				foreach($where_arra as $key=>$val)
				{
					if(is_numeric($key))
					{
						$this->db->where($val);
					}
					else
					{
						$this->db->where($key,$val);
					}
				}
			}
			else if($where_arra !='')
			{
				$this->db->where($where_arra);
			}
			if(isset($select_f) && $select_f !='')
			{
				$this->db->select($select_f);
			}

			if($flag_count_data == 0)
			{
				//$search_data = $this->db->get_compiled_select($table);
				$sql_query_temp = $this->db->get_compiled_select($table);
				$result = $this->db->simple_query($sql_query_temp);
				if ( ! $result && ENVIRONMENT == 'production')
				{
					$error = $this->db->error(); // Has keys 'code' and 'message'
					//print_r($error);
					return 0;
				}
				else
				{
					$count_data = 0;
					//print_r($result);
					// old count direct query
					  //$query = $this->db->query($sql_query_temp);
					  //$count_data = $query->num_rows();
					// old count direct query
					// for get count new code update
					// $where_temp_arr = explode('WHERE ', $sql_query_temp);
					// if(isset($where_temp_arr[1]) && $where_temp_arr[1] !='')
					// {
					// 	$this->db->where($where_temp_arr[1]);
					// }
					// $count_data = $this->db->count_all_results($table);

					// for get count new code update
					$need_to_check = 1;
					$query_generated_org_temp = str_replace('`','',$sql_query_temp);
					$query_generated_org_temp = trim(preg_replace('/\s+/', ' ', $query_generated_org_temp));
					//$query_generated_org_temp = strtolower($query_generated_org_temp);

					$query_generated_org_temp = str_ireplace('from','from',$query_generated_org_temp);
					$query_generated_org_temp = str_ireplace('group by','group by',$query_generated_org_temp);
					$query_generated_org_temp = str_ireplace('select','select',$query_generated_org_temp);

					$where_temp_arr = explode(' from ', $query_generated_org_temp);
					$is_group_by = 0;
					$group_by_str = strstr($query_generated_org_temp,'group by');
					if($group_by_str !='')
					{
						$is_group_by = 1;
					}
					if(isset($where_temp_arr[1]) && $where_temp_arr[1] !='' && $is_group_by == 0)
					{
                        $from_query_temp = $where_temp_arr[1];
                        $select_part = 'select count(*) as num_row';
                        $temp_flag_sleellele = 0;
                        if(isset($where_temp_arr[0]) && $where_temp_arr[0] !='')
                        {
                            $select_teeemp = str_replace('select','',$where_temp_arr[0]);
                            //$select_teeemp = str_replace(' ','',$select_teeemp);
                            $select_teeemp = trim($select_teeemp);
                            if($select_teeemp == '*')
                            {
                                $temp_flag_sleellele = 1;
                            }
                            else if(isset($this->primary_key) && $this->primary_key !='' && $this->primary_key == $select_teeemp)
                            {
                                $temp_flag_sleellele = 1;
                            }
                            else if(isset($this->primary_key) && $this->primary_key !='' && $table.'.'.$this->primary_key == $select_teeemp)
                            {
                                $temp_flag_sleellele = 1;
							}
                        }
                        if($temp_flag_sleellele == 0)
                        {
							$select_part = 'select '.$select_teeemp;
						}
						//exit;
                        $query = $this->db->query(" $select_part from ".$from_query_temp);
                        if($query)
                        {
                            if(trim($select_part) =='select count(*) as num_row')
                            {
                                $temp_row = $query->row_array();
                                if(isset($temp_row['num_row']) && $temp_row['num_row'] !='')
                                {
                                    $count_data =  $temp_row['num_row'];
                                    $need_to_check = 0;
                                }
                            }
                            else
                            {
                                $count_data = $query->num_rows();
                                $need_to_check = 0;
                            }
                        }
						//$this->db->where($where_temp_arr[1]);
                    }
                    if($need_to_check == 1)
                    {
						$query = $this->db->query($sql_query_temp);
						$count_data = $query->num_rows();
					}
					$count_data = intval($count_data); // for string to  intval
					return $count_data;
				}
				//return $this->db->count_all_results($table);
			}
			else
			{
				if(isset($order_by) && $order_by !='')
				{
					$this->db->order_by($order_by);
				}
				if($flag_count_data==1)
				{
					$this->db->limit(1);
				}
				else
				{
					if($page !='' && $limit =="")
					{
						$limit = $this->limit_per_page;
					}
					if($page !='' && is_numeric($page) && $limit !='' && is_numeric($limit) && $page > 0)
					{
						$this->start = (($page - 1) * $limit);
						//$this->db->where(" id > ".$this->start);
						//$this->db->limit($limit);
						$this->db->limit($limit,$this->start);
					}
					//$this->db->limit(1);
				}

				// for echo query
				if($disp_query ==1)
				{
					$this->db->get_compiled_select($table);
				}
				$query_generated = $this->db->get_compiled_select($table);
				$result = $this->db->simple_query($query_generated);
				if ( ! $result && ENVIRONMENT == 'production')
				{
					return '';
				}
				else
				{
					$query = $this->db->query($query_generated);
					$count_data = $query->num_rows();
					$temp_array = '';
					if($count_data == 0)
					{
						return '';
					}
					else if($flag_count_data == 1)
					{
						unset($temp_array);
						$temp_array = $query->row_array();
					}
					else
					{
						unset($temp_array);
						$temp_array = $query->result_array();
					}
					return $temp_array;
				}
			}
		}
		else
		{
			return '';
		}
	}
	function update_insert_data_common($table='',$data_array='',$where_arra='',$flag_update=1,$limit=1)
	{
		$return = false;
		if($table !='' && $data_array !='')
		{
			$db_debug = $this->db->db_debug;
			$this->db->db_debug = FALSE;
			$this->db->trans_start();
			if($flag_update == 1)
			{
				if($where_arra !='' && is_array($where_arra) && count($where_arra) >0)
				{
					foreach($where_arra as $key=>$val)
					{
						if(is_numeric($key))
						{
							$this->db->where($val);
						}
						else
						{
							$this->db->where($key,$val);
						}
					}
				}
				else if($where_arra !='')
				{
					$this->db->where($where_arra);
				}

				if($limit == 1)
				{
					$this->db->limit(1);
				}
				$return = $this->db->update($table,$data_array);
			}
			else
			{
				if($flag_update == 2)
				{
					$return = $this->db->insert_batch($table,$data_array);
				}
				else
				{
					$return = $this->db->insert($table,$data_array);
					$this->last_insert_id = $this->db->insert_id();
					if($table =='ticket_table')
					{
						$this->update_ticket_data_devloper($this->last_insert_id,$data_array);
					}
				}
			}
			$this->db->trans_complete();
			$this->db->db_debug = $db_debug;
		}

		return $return;
	}
	function data_delete_common($table='',$where_arra='',$limit=0,$permenent_delete='')
	{
		$return = false;
		if($permenent_delete !='')
		{
			$this->permenent_delete = $permenent_delete;
		}

		if($table !='')
		{
			if($where_arra !='' && is_array($where_arra) && count($where_arra) >0)
			{
				foreach($where_arra as $key=>$val)
				{
					if(is_numeric($key))
					{
						$this->db->where($val);
					}
					else
					{
						$this->db->where($key,$val);
					}
				}
			}
			else if($where_arra !='')
			{
				$this->db->where($where_arra);
			}
			if($limit == 1)
			{
				$this->db->limit(1);
			}
			if($this->is_delete_fild !='' && $this->permenent_delete =='no')
			{
				$data_array = array($this->is_delete_fild =>'Yes');
				$return = $this->db->update($table,$data_array);
			}
			else
			{
				$return = $this->db->delete($table);
			}
			// is_deleted
		}
		return $return;
	}
	function getconfingValue($item_name ='')
	{
		$return = '';
		if($item_name !='')
		{
			$return = $this->config->item($item_name);
		}
		return $return;
	}
	function generate_form_main($ele_array = '',$other_config='')
	{
		$table_name = $this->table_name;
		$ele_array_key = array_keys($ele_array);
		if(isset($other_config['mode']) && $other_config['mode'] =='edit' && $table_name !='')
		{
			if(!isset($this->edit_row_data) || $this->edit_row_data =='')
			{
				$where_arr = '';
				$primary_key = $this->primary_key;
				if(isset($primary_key) && $primary_key !='' && isset($other_config['id']) && $other_config['id'] !='')
				{
					$where_arr = array($primary_key => $other_config['id']);
				}
				$select_field = '';
				if(isset($ele_array_key) && $ele_array_key !='' && count($ele_array_key) > 0)
				{
					$table_field = $this->table_field;
					$ele_array_key = array_intersect($ele_array_key,$table_field);
					$select_field = implode(',',$ele_array_key);
				}

				$row_data = $this->get_count_data_manual($table_name,$where_arr,1,$select_field);
				$this->edit_row_data = $row_data;
			}
			else
			{
				$row_data = $this->edit_row_data;
			}
			if(!isset($row_data) || $row_data =='' || count($row_data) ==0 )
			{
				redirect($this->base_url_admin_cm);
			}
		}
		$element_array = array();
		foreach($ele_array as $key=>$val)
		{
			$temp_array = $val;
			if(isset($other_config['mode']) && $other_config['mode'] =='edit' && isset($row_data[$key]) && $row_data[$key] !='')
			{
				$temp_array['value'] = $row_data[$key];
			}
			if(isset($val['type']) && $val['type'] !='')
			{
				$temp_array['type'] = $val['type'];
			}
			else
			{
				if(!is_array($temp_array) && $temp_array =='')
				{
					$temp_array = array('type'=> 'textbox');
				}
				else
				{
					$temp_array['type'] = 'textbox';
				}
			}
			$element_array[$key] = $temp_array;
		}
		return $this->generate_form($element_array,$other_config);
	}
	function is_required($element_array_val)
	{
		$is_required = "";
		if(isset($element_array_val['is_required']) && $element_array_val['is_required'] !='' && $element_array_val['is_required'] =='required')
		{
			$is_required = " required ";
		}
		return $is_required;
	}
	function get_label($element_array_val='',$key='')
	{
		$labelArr = $this->common_model->labelArr;

		if(isset($element_array_val['label']) && $element_array_val['label'] !='')
		{
			$label = $element_array_val['label'];
		}
		else if(isset($labelArr[$key]) && $labelArr[$key] !='')
		{
			$label = $labelArr[$key];
		}
		else
		{
			$label = str_replace('_',' ',$key);
			$label = ucwords($label);
		}
		return $label;
	}
	public function set_session_data_comm($session_name = '',$data='')
	{
		if($session_name !='')
		{
			if(isset($this->session_prifix) && $this->session_prifix !='')
			{
				$session_name = $this->session_prifix.$session_name;
			}
			$this->session->set_userdata($session_name, $data);
		}
	}
	function get_value($element_array_val,$key='value',$defult='')
	{
		$value_curr = $defult;
		if(isset($element_array_val[$key]) && $element_array_val[$key] !='')
		{
			$value_curr = $element_array_val[$key];
		}
		return $value_curr;
	}
	function getRelationDropdown($element_array_val)
	{
		$return_arr = '';
		$value_curr = $this->get_value($element_array_val,'value','');
		$relation_arr = $this->get_value($element_array_val,'relation','');
		$is_multiple = $this->get_value($element_array_val,'is_multiple');

		$not_load_add = $this->get_value($relation_arr,'not_load_add','no');
		$not_load_add_special = $this->get_value($relation_arr,'not_load_add_special','no');

		if(isset($not_load_add) && $not_load_add == 'yes' && $this->mode =='add')
		{
			return $return_arr;
		}
		else if(isset($not_load_add_special) && $not_load_add_special == 'yes')
		{
			return $return_arr;
		}
		if(isset($relation_arr) && $relation_arr !='' && count($relation_arr) > 0)
		{

			if(isset($relation_arr['rel_table']) && $relation_arr['rel_table'] !='' && isset($relation_arr['key_val']) && $relation_arr['key_val'] !='' && isset($relation_arr['key_disp']) && $relation_arr['key_disp'] !='' )
			{
				$select_field = $relation_arr['key_disp'].', '.$relation_arr['key_val'];

				$where_close = array();
				if($value_curr !='')
				{
					$where_close[] = $relation_arr['key_val']." = '".$value_curr."' ";
				}
				$status_filed = 'status';
				$status_val = 'APPROVED';
				if(isset($relation_arr['status_filed']) && $relation_arr['status_filed'] !='')
				{
					$status_filed = $relation_arr['status_filed'];
				}
				if(isset($relation_arr['status_val']) && $relation_arr['status_val'] !='')
				{
					$status_val = $relation_arr['status_val'];
				}
				if($status_filed !='' && $status_val !='')
				{
					$where_close[] = $status_filed." = '".$status_val."' ";
				}
				if(isset($relation_arr['cus_rel_col_name']) && $relation_arr['cus_rel_col_name'] !='')
				{
					$relation_arr['rel_col_name'] = $relation_arr['cus_rel_col_name'];
				}
				if(isset($relation_arr['cus_rel_col_val']) && $relation_arr['cus_rel_col_val'] !='')
				{
					if(isset($this->edit_row_data[$relation_arr['cus_rel_col_val']]) && $this->edit_row_data[$relation_arr['cus_rel_col_val']] !='')
					{
						$relation_arr['rel_col_val'] = $this->edit_row_data[$relation_arr['cus_rel_col_val']];
					}
				}

				if(isset($relation_arr['rel_col_name']) && $relation_arr['rel_col_name'] !='')
				{
					if(!isset($relation_arr['rel_col_val']) || $relation_arr['rel_col_val'] =='')
					{
						$rel_col_name = $relation_arr['rel_col_name'];
						if(isset($this->edit_row_data[$rel_col_name]) && $this->edit_row_data[$rel_col_name] !='')
						{
							$relation_arr['rel_col_val'] = $this->edit_row_data[$rel_col_name];
						}
					}
					if(isset($relation_arr['rel_col_val']) && $relation_arr['rel_col_val'] !='')
					{
						$return_0 = 0;
						if($is_multiple !='' && $is_multiple =='yes')
						{
							$rel_val_arr_in = explode(',',$relation_arr['rel_col_val']);
							$this->db->where_in($relation_arr['rel_col_name'],$rel_val_arr_in);
							$return_0 = 1;
						}
						else if(isset($relation_arr['rel_col_val']) && is_array($relation_arr['rel_col_val']))
						{
							$this->db->where_in($relation_arr['rel_col_name'],$relation_arr['rel_col_val']);
							$return_0 = 1;
						}
						else
						{
							$this->db->where($relation_arr['rel_col_name'],$relation_arr['rel_col_val']);
							$return_0 = 1;
						}
						if($return_0 == 0)
						{
							$return_arr;
						}
					}
					else
					{
						return $return_arr;
					}
				}
				if(isset($where_close) && $where_close !='' && count($where_close) > 0 )
				{
					$where_close_str = implode(" OR ",$where_close);
					$this->db->where(" ( $where_close_str ) ");
				}
				
				$key_disp_order = $relation_arr['key_disp'];
				if($element_array_val['relation']['rel_table'] == 'annual_income')
				{
				    $key_disp_order = $relation_arr['key_val'];
				}
				$row_data = $this->get_count_data_manual($relation_arr['rel_table']," is_deleted='No' ",2,$select_field,$key_disp_order.' ASC ',0);
				//print_r($row_data);exit;
				$return_arr = array();
				if(isset($row_data) && $row_data !='' && count($row_data) > 0)
				{
					foreach($row_data as $row_data_val)
					{
						$return_arr[$row_data_val[$relation_arr['key_val']]] = $row_data_val[$relation_arr['key_disp']];
					}
				}
				//print_r($return_arr);
			}
		}
		// $this->get_value($element_array_val,'value','');
		return $return_arr;
	}
	function is_required_star($required='')
	{
		$return_str = '';
		if(trim($required) =='required')
		{
			$return_str = " <span class='sub_title_mem'>*</span>";
		}
		return $return_str;
	}
	function generate_dropdown($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val,'value','');
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$is_multiple = $this->get_value($element_array_val,'is_multiple');//

			$is_multi = '';
			$is_multi_par = '';
			$current_selected_arra = array();
			if($is_multiple !='' && $is_multiple == 'yes')
			{
				$is_multi ='multiple';
				$is_multi_par = '[]';
				if($value_curr !='')
				{
					$current_selected_arra = explode(',',$value_curr);
				}
			}
			else if($value_curr !='')
			{
				$current_selected_arra[] = $value_curr;
			}
			$current_selected_arra = array_map('trim', $current_selected_arra);

			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$onChange = $this->get_value($element_array_val,'onchange','');
			$display_placeholder = $this->get_value($element_array_val,'display_placeholder','Yes');
			$extra = $this->common_model->get_value($element_array_val,'extra','');
			if($onChange !='')
			{
				$onChange = 'onChange="'.$onChange.'"';
			}

			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('city')) && $value_curr !='')
			{
				$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >';
				$return_content.='<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>';
				$return_content.='</div>
				</div>';
			}
			else
			{

				$value_arr = $this->get_value($element_array_val,'value_arr','');
				if(!isset($value_arr) || $value_arr =='' || count($value_arr) ==0)
				{
					$value_arr = $this->getRelationDropdown($element_array_val);
				}
				$mul_hidden_fild = '';
				if($is_multi_par !='')
				{
					$mul_hidden_fild = '<input type="hidden" name="'.$key.'" value="" />';
				}
				$requ_str_star = $this->is_required_star($is_required);
				$return_content.='
					<div class="form-group '.$form_group_class.'">
					  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
					  <div class="col-sm-9 col-lg-'.$this->form_control_col.'">
						'.$mul_hidden_fild.'
						<select '.$is_multi.' '.$onChange.' '.$is_required.' name="'.$key.$is_multi_par.'" id="'.$key.'" class="form-control '.$class.' " '.$extra.' >';
							if($display_placeholder =='Yes')
							{
								$return_content.='<option selected value="" >Select '.$label.'</option>';
							}

						if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
						{
							foreach($value_arr as $key_r=>$value_arr_val)
							{
								$selected_drop = '';
								if(in_array($key_r,$current_selected_arra))
								{
									$selected_drop = 'selected';
								}
								$return_content.='<option '.$selected_drop.' value="'.$key_r.'">'.$value_arr_val.'</option>';
							}
						}
				$return_content.='
						</select>
					  </div>
					</div>';
			}
		}
		return $return_content;
	}
	function generate_radio($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val,'value','APPROVED');
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$class_con_val = $this->get_value($element_array_val,'class_con_val');
			$value_arr = $this->get_value($element_array_val,'value_arr',$this->status_arr);
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$onclick = $this->get_value($element_array_val,'onclick');
			$extra = $this->common_model->get_value($element_array_val,'extra','');
			$is_required = $this->is_required($element_array_val);
			if($onclick !='')
			{
				$onclick =' onclick= "'.$onclick.'" ';
			}
			$requ_str_star = $this->is_required_star($is_required);
			//$this->status_arr = $value_arr;
			$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'">
				  <div class=radio>';
			//print_r($value_arr);
			if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
			{
				foreach($value_arr as $key_r=>$value_arr_val)
				{
					$selected_radio = '';
					$class_d = $class;
					if($class_con_val !='')
					{
						$class_d.= ' '.$class_con_val.'_'.$key_r;
					}
					if($value_curr == $key_r)
					{
						$selected_radio = 'checked';
					}
					$return_content.='<label><input '.$is_required.' '.$extra.' '.$onclick.' '.$selected_radio.' class="'.$class_d.'" type="radio" name="'.$key.'" id="'.$key_r.'" value="'.$key_r.'">'.$value_arr_val.'</label>&nbsp;&nbsp;';
				}
			}
			$return_content.='
					</div>
				  </div>
				</div>';
		}
		return $return_content;
	}

	function generate_checkbox($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val,'value','age');
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$class_con_val = $this->get_value($element_array_val,'class_con_val');
			$value_arr = $this->get_value($element_array_val,'value_arr',$this->status_arr);
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$onclick = $this->get_value($element_array_val,'onclick');
			$other = $this->common_model->get_value($element_array_val,'other','');
			$is_multiple = $this->get_value($element_array_val,'is_multiple');
			$is_required = $this->is_required($element_array_val);
			if($onclick !='')
			{
				$onclick =' onclick= "'.$onclick.'" ';
			}
			$requ_str_star = $this->is_required_star($is_required);
			if($is_multiple !='' && $is_multiple == 'yes')
			{
				$is_multi = 'multiple';
				$is_multi_par = '[]';
				if($value_curr !='')
				{
					$current_selected_arra = explode(',',$value_curr);
				}
			}
			else if($value_curr !='')
			{
				$current_selected_arra[] = $value_curr;
			}
			$current_selected_arra = array_map('trim', $current_selected_arra);
			$return_content.='
			<div class="form-group '.$form_group_class.'">
				<label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
					<div class="col-sm-9 col-lg-'.$this->form_control_col.'">
						<div class="checkbox">';
							if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
							{
								foreach($value_arr as $key_r=>$value_arr_val)
								{
									$selected_chechbox = '';
									$class_d = $class;
									if($class_con_val !='')
									{
										$class_d.= ' '.$class_con_val.'_'.$key_r;
									}
									if(in_array($key_r,$current_selected_arra))
									{
										$selected_chechbox = 'checked';
									}
									$return_content .= '<label><input '.$is_required.' '.$other.' '.$onclick.' '.$selected_chechbox.' class="'.$class_d.'" type="checkbox" name="'.$key.$is_multi_par.'" id="'.$key_r.'" value="'.$key_r.'">'.$value_arr_val.'</label>&nbsp;&nbsp;';
								}
							}
						$return_content.='
						</div>
					</div>
				</div>';
		}
		return $return_content;
	}

	function generate_password($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = '';
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$other = $this->get_value($element_array_val,'other');
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$minlength = $this->get_value($element_array_val,'minlength',3);
			if($this->mode =='add')
			{
				$place_holder_pass = 'Password';
			}
			else
			{
				$place_holder_pass = 'Please leave password blank for not update';
				$is_required = '';
			}
			$requ_str_star = $this->is_required_star($is_required);
			$return_content.='
			<div class="form-group '.$form_group_class.'">
			  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
			  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
				<input '.$other.' minlength="'.$minlength.'" type="password" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$place_holder_pass.'" value ="" />
			  </div>
			</div>';
		}
		return $return_content;
	}

	function generate_mobile($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			if(isset($element_array_val['value_imp']) && $element_array_val['value_imp'] !='')
			{
				$value_curr = $element_array_val['value_imp'];
			}
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$other = $this->get_value($element_array_val,'other');
			$placeholder = $this->get_value($element_array_val,'placeholder',$label);
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');

			$alp_num_str_fun = 'onkeypress="return isNumberKey(event)"';
			$requ_str_star = $this->is_required_star($is_required);
			$check_duplicate = $this->get_value($element_array_val,'check_duplicate','No');
			$onchange_textbox = '';
			/*if($check_duplicate == 'Yes')
			{
				$table_name = $this->table_name;
				$onchange_textbox = "check_duplicate('$key','$table_name')";
				$onchange_textbox = 'onBlur="'.$onchange_textbox.'"';
			}
			'.$onchange_textbox.'
			*/

			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('email','phone','mobile','landline')) && $value_curr !='')
			{
				$return_content.='
					<div class="form-group">
					  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
					  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
						<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>
					  </div>
					</div>';
			}
			else
			{
				$where_country_code= " ( is_deleted ='No' ) GROUP BY country_code,country_name";
				$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");

				$current_count_code = '';
				$mobile_num = $value_curr;
				if($value_curr !='')
				{
					$value_curr_arr = explode('-',$value_curr);
					if(count($value_curr_arr) == 2)
					{
						$current_count_code = $value_curr_arr[0];
						$mobile_num = $value_curr_arr[1];
					}
				}
				$key_mm = "'".$key."'";
				$return_content.='<style type="text/css">
					.select2{width:100% !important}
					.select2-container--default .select2-selection--multiple {background-color: white;border: 1px solid #e4e4e4;border-radius: 4px;cursor: text;}
					.select2-container--default.select2-container--focus .select2-selection--multiple {border: solid #0ac2ff 1px;outline: 0;}
					.select2-container--default .select2-selection--single{background-color: #fff;border: 1px solid #e4e4e4;border-radius: 4px;}
					.select2-container .select2-selection--single .select2-selection__rendered {display: block;padding-left: 12px;padding-right: 20px;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 3px;}
					.select2-container--default .select2-selection--multiple .select2-selection__rendered {box-sizing: border-box;list-style: none;margin: 0;padding: 0 12px;width: 100%;}
					.select2-container .select2-selection--single{box-sizing: border-box;cursor: pointer;display: block;height: 34px;user-select: none;-webkit-user-select: none;}
					</style>
				  <div class="form-group">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'">
					<div class="col-sm-5 col-lg-5 pl0">
					<select name="country_code" id="country_code" required="" class="form-control select2" onChange="check_valid_mobile_number('."'mobile_num'".','.$key_mm.')">
						<option value="">Select Country Code</option>';
						foreach($country_code_arr as $country_code_arr)
						{
							$select_ed_drp = '';
							if($country_code_arr['country_code'] == $current_count_code)
							{
								$select_ed_drp = 'selected';
							}
							$return_content.='<option '.$select_ed_drp.' value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].'</option>';
						}

				$return_content.='</select>
					</div>
					<div class="col-sm-7 col-lg-7 ">
					<input type="text" '.$other.' '.$alp_num_str_fun.' '.$is_required.' class="form-control '.$class.' " placeholder="'.$placeholder.'" value ="'.htmlentities(stripcslashes($mobile_num)).'" minlength="7" maxlength="13" name="mobile_num" id="mobile_num" onchange="check_valid_number(this); check_valid_mobile_number('."'mobile_num'".','.$key_mm.')">
					<input type="hidden" name="'.$key.'" id="'.$key.'" value="'.htmlentities(stripcslashes($value_curr)).'" />
				</div>
				</div>
				</div>';

				$this->common_model->js_extra_code.= " select2('.select2','Please Select'); ";

				$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
				$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
			}
		}
		return $return_content;
	}
	function generate_textbox($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			if(isset($element_array_val['value_imp']) && $element_array_val['value_imp'] !='')
			{
				$value_curr = $element_array_val['value_imp'];
			}
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$input_type = $this->get_value($element_array_val,'input_type','text');
			$other = $this->get_value($element_array_val,'other');
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$placeholder = $this->get_value($element_array_val,'placeholder',$label);
			$allowed_only_num_char = $this->get_value($element_array_val,'type_num_alph','');
			$alp_num_str_fun = '';
			if($allowed_only_num_char =='alpha')
			{
				$alp_num_str_fun = 'onkeypress="return onlyAlphabets(event,this);"';
			}
			else if($allowed_only_num_char =='num')
			{
				$alp_num_str_fun = 'onkeypress="return isNumberKey(event)"';
			}
			$requ_str_star = $this->is_required_star($is_required);
			if($input_type == 'date')
			{
				$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
				  	<div class="input-prepend input-group input-group-lg"> <span class="add-on input-group-addon  common_height_padd"><i class="fa fa-calendar"></i></span>
						<input '.$other.' type="text" '.$is_required.' name="'.$key.'" id="'.$key.'" class="datepicker form-control '.$class.'  common_height_padd " placeholder="'.$label.'" value ="'.htmlentities(stripcslashes($value_curr)).'" data-provide="datepicker" />
					</div>

				  </div>
				</div>';
			}
			else if($input_type == 'hidden')
			{
				$return_content.='<input type="hidden" name="'.$key.'" id="'.$key.'" value ="'.htmlentities(stripcslashes($value_curr)).'" />';
			}
			else
			{
				$check_duplicate = $this->get_value($element_array_val,'check_duplicate','No');
				$onchange_textbox = '';
				if($check_duplicate == 'Yes')
				{
					$table_name = $this->table_name;
					$onchange_textbox = "check_duplicate('$key','$table_name')";
					$onchange_textbox = 'onBlur="'.$onchange_textbox.'"';
				}
				$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >';
				if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('email','phone','mobile','landline')) && $value_curr !='')
				{
					$return_content.='<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>';
				}
				else
				{
					$return_content.='<input '.$other.' '.$alp_num_str_fun.'type="'.$input_type.'" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " '.$onchange_textbox.' placeholder="'.$placeholder.'" value ="'.htmlentities(stripcslashes($value_curr)).'" />';
				}

				$return_content.='
				  </div>
				</div>';
			}
		}
		return $return_content;
	}
	function generate_textarea($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$requ_str_star = $this->is_required_star($is_required);
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$placeholder = $this->get_value($element_array_val,'placeholder',$label);
			$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.' '.$key.'_edit" >';

			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('address')) && $value_curr !='')
				{
					$return_content.='<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>';
				}
				else
				{
				  	$return_content.='<textarea '.$is_required.' rows="4" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$placeholder.'">'.$value_curr.'</textarea>';
				}
					$return_content.='</div>
				</div>';

		}
		return $return_content;
	}
	function check_is_img($file_url ='')
	{
		$return = 1;
		$size = getimagesize($file_url);
		if ($size === false)
		{
			$return = 0;
		}
		//if($file_url !='')
		//{
		//	$ext = end(explode(".", $file_url));
		//}
		return $return;
	}
	function generate_file_upload($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$extension = $this->get_value($element_array_val,'extension','jpg|png|jpeg|gif|bmp');
			$path_value = $this->get_value($element_array_val,'path_value','');
			$class = $this->get_value($element_array_val,'class');
			$display_img = $this->get_value($element_array_val,'display_img','Yes');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$display_note = $this->get_value($element_array_val,'display_note','');
			$inline_style = $this->get_value($element_array_val,'inline_style');
			$requ_str_star = $this->is_required_star($is_required);
			if($this->mode == 'edit')
			{
				$is_required = '';
			}
			$img_display = '';

			///$is_img = $this->check_is_img($path_value.$value_curr);

			if($path_value !='' && $value_curr !='' && file_exists($path_value.$value_curr) && $display_img == 'Yes')
			{
				if(isset($inline_style) && $inline_style != ''){
					$img_display = '<img style="'.$inline_style.'" class="img-responsive" src="'.$this->base_url.$path_value.$value_curr.'" />';
				}else{
					$img_display = '<img style="max-height:100px" class="img-responsive" src="'.$this->base_url.$path_value.$value_curr.'" />';
				}

			}
			else if($path_value !='' && $value_curr !='' && file_exists($path_value.$value_curr))

			{
				$img_display = '<a target="_blank" href="'.$this->base_url.$path_value.$value_curr.'" >View File</a>';
			}
			if($display_note!='')
			{
				$display_note='<p class=help-block><b>Note:</b> '.$display_note.'.</p>';
			}
			$return_content.='
				<div class="form-group '.$form_group_class.'">
                  <label class="col-sm-'.$this->label_col.' control-label">'.$label.$requ_str_star.'</label>
                  <div class=col-sm-4>
                    <input filesize="10" extension="'.$extension.'" '.$is_required.' type="file" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " />
					<input type="hidden" name="'.$key.'_val" id="'.$key.'_val" value="'.$value_curr.'" />
					<input type="hidden" name="'.$key.'_path" id="'.$key.'_path" value="'.$path_value.'" />
					<input type="hidden" name="'.$key.'_ext" id="'.$key.'_ext" value="'.$extension.'" />
                    <p class=help-block>Allowed Maximum File size up to 3MB. File type '.str_replace('|', ' | ',$extension).'.</p>'.$display_note.'
                  </div>
				  <div class="col-sm-4">
				  	'.$img_display.'
				  </div>
                </div>';
		}
		return $return_content;
	}
	function generate_form_element($element_array = '')
	{
		$return_content='';
		if(isset($element_array) && $element_array !='' && count($element_array) > 0)
		{
			foreach($element_array as $key=>$element_array_val)
			{
				if(isset($element_array_val['type']) && $element_array_val['type'] =='textbox')
				{
					$return_content.=$this->generate_textbox($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='password')
				{
					$return_content.=$this->generate_password($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='textarea')
				{
					$return_content.=$this->generate_textarea($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='file')
				{
					$return_content.=$this->generate_file_upload($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='radio')
				{
					$return_content.=$this->generate_radio($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='checkbox')
				{
					$return_content.=$this->generate_checkbox($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='dropdown')
				{
					$return_content.=$this->generate_dropdown($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='mobile')
				{
					$return_content.=$this->generate_mobile($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='manual')
				{
					$return_content.=$element_array_val['code'];
				}
			}
		}
		return $return_content;
	}
	function generate_form($element_array = '',$other_config='')
	{
		$return_content='';
		$action='';
		$onsubmit='';
		$enctype ='';
		if(isset($other_config) && !is_array($other_config) || $other_config =='')
		{
			$other_config = array();
		}
		if(isset($other_config['mode']) && $other_config['mode'] !='')
		{
			$this->mode = $other_config['mode'];
		}
		else
		{
			$other_config['mode'] = 'add';
			$this->mode = 'add';
		}
		if(!isset($other_config['id']))
		{
			$other_config['id'] = '';
		}

		if(isset($other_config['success_url']) && $other_config['success_url'] !='')
		{
			$this->success_url = $other_config['success_url'];
		}
		if(isset($other_config['failure_url']) && $other_config['failure_url'] !='')
		{
			$this->failure_url = $other_config['failure_url'];
		}

		if(isset($other_config['action']) && $other_config['action'] !='')
		{
			$action='action="'.$this->base_url_admin.$other_config['action'].'"';
		}
		else if(isset($this->action) && $this->action !='')
		{
			$action='action="'.$this->base_url_admin.$this->action.'"';
		}
		if(isset($other_config['onsubmit']) && $other_config['onsubmit'] !='')
		{
			$onsubmit=' onSubmit="'.$other_config['onsubmit'].'"';
		}
		if(isset($other_config['enctype']) && $other_config['enctype'] !='')
		{
			$enctype = $this->get_value($other_config,'enctype');
		}
		if(isset($other_config['form_id']) && $other_config['form_id'] !='')
		{
			$form_id = $this->get_value($other_config,'form_id');
		}
		else
		{
			$form_id = 'common_insert_update';
		}
		$form_class = '';
		if(isset($other_config['class']) && $other_config['class'] !='')
		{
			$form_class = $this->get_value($other_config,'class');
		}
		$temp_back = '';
		if(isset($other_config['onback_click']) && $other_config['onback_click'] !='')
		{
			$onback_click = $this->get_value($other_config,'onback_click');
		}
		else
		{
			$class_name = $this->class_name;
			$method_name = $this->method_name;
			$temp_back = $this->base_url_admin_cm_status;
			$onback_click = 'back_list()';
		}
		if(isset($other_config['back_hist']) && $other_config['back_hist'] !='')
		{
			$back_hist = $this->get_value($other_config,'back_hist');
			if(isset($back_hist) && $back_hist !='' && strtolower($back_hist) =='yes')
			{
				$temp_back = '#';
			}
		}
		if(isset($element_array) && $element_array !='' && count($element_array) > 0)
		{
			$message_div = '<div id="reponse_message">';
			if($this->session->flashdata('error_message'))
			{
				$error_message = $this->session->flashdata('error_message');
				if (strpos($error_message, 'alert-danger') !== false)
				{
					$message_div.=$this->session->flashdata('error_message');
				}
				else
				{
					$message_div.='<div class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('error_message').'</div>';
				}
			}
			if($this->session->flashdata('success_message'))
			{
				$success_message = $this->session->flashdata('success_message');
				if (strpos($success_message, 'alert-success') !== false)
				{
					$message_div.=$this->session->flashdata('success_message');
				}
				else
				{
					$message_div.='<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('success_message').'</div>';
				}
			}
			$message_div.='</div>';
			$return_content.='
					<div class="panel-inner-d padding-20px">
						<div class="row no-margin">
							<div class="col-lg-12">
								<form method="post" id="'.$form_id.'" name="'.$form_id.'" class="form-horizontal bordered-group '.$form_class.' " role=form '.$action.$onsubmit.' '.$enctype.' >';
			$return_content.=$message_div;
			$return_content.=$this->generate_form_element($element_array);
			$return_content.='
							<div class=form-group>
							  <label class="col-sm-'.$this->label_col.'"></label>
							  <div class="col-sm-9">
							  	<button type="submit" class="btn btn-primary mr10">Submit</button>
							  ';
								if($this->addPopup == 0)
								{
									$return_content.='
										<a href="'.$temp_back.'" type="button" onClick="'.$onback_click.'" class="btn btn-default">Back</a>';
								}
								else
								{
									$return_content.='
										<button type="button" onClick="close_popup()" class="btn btn-default" data-dismiss="modal">Close</button>';
								}
							  $return_content.='</div>
							</div>
							<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" id="hash_tocken_id" class="hash_tocken_id" />
							<input type="hidden" name="mode" value="'.$other_config['mode'].'" id="mode" />
							<input type="hidden" name="id" value="'.$other_config['id'].'" id="id" />
							<input type="hidden" name="success_url" value="'.$this->success_url.'" id="success_url" />
							<input type="hidden" name="failure_url" value="'.$this->failure_url.'/'.$other_config['mode'].'-data/'.$other_config['id'].'" id="failure_url" />
						</form>
						</div>
					</div>
				</div>
			';
			/*<div class="panel mb25">
				<div class="panel-body"></div>
		</div>*/
		}
		return $return_content;
	}
	public function generate_url_comon($generate_url='')
	{
		$return_url='';
		if($generate_url !='')
		{
			$generate_url_arr = explode('-|-',$generate_url);
			if(isset($generate_url_arr) && $generate_url_arr !='' && count($generate_url_arr) >0)
			{
				$from_gen = '';
				$to_gen = '';
				if(isset($generate_url_arr[0]) && $generate_url_arr[0] !='')
				{
					$from_gen = $generate_url_arr[0];
				}
				if(isset($generate_url_arr[1]) && $generate_url_arr[1] !='')
				{
					$to_gen = $generate_url_arr[1];
				}
				if($from_gen !='' && $to_gen !='')
				{
					$from_gen_val='';
					$to_gen_val ='';
					if($this->input->post($to_gen))
					{
						$to_gen_val = $this->input->post($to_gen);
					}
					if($this->input->post($from_gen))
					{
						$from_gen_val = $this->input->post($from_gen);
					}
					if($from_gen_val !='' && $to_gen_val =='')
					{
						$to_gen_val = str_replace('_','-',$from_gen_val);
						$url_genrate = strtolower(url_title($to_gen_val));
						$url_genrate_org = $url_genrate;
						$duplicate = 1;
						$count_dup = 0;
						if($this->table_name !='')
						{
							do
							{
								if($count_dup != 0)
								{
									$url_genrate = $url_genrate_org.'-'.$count_dup;
								}
								$data_update = array($to_gen=>$url_genrate);
								$existing_count = $this->common_model->get_count_data_manual($this->table_name,$data_update,0);
								if($existing_count == 0)
								{
									$duplicate = 0;
								}
								$count_dup++;
							}
							while($duplicate != 0);
						}
						$_REQUEST[$to_gen] = $url_genrate;
					}
				}

				/*if($from_gen !='' && $to_gen !='')
				{
					$from_gen_val='';
					if($this->input->post($from_gen))
					{
						$from_gen_val = $this->input->post($from_gen);
					}
					if($from_gen_val !='')
					{
						$_REQUEST[$to_gen] = $url_genrate = strtolower(url_title($from_gen_val));
					}
				}*/

			}
		}
		$return_url = strtolower($return_url);
		return $return_url;
	}
	public function save_update_data($retuen_json=1,$is_retur_stop='',$flag_uuuu='')
	{
		//print_r($_REQUEST);
		//print_r($_FILES);
		//exit;

		$table_name = $this->table_name;
		$table_field = $this->table_field;
		$primary_key = $this->primary_key;

		if($this->input->post('success_url'))
		{
			$this->success_url = $this->input->post('success_url');
		}
		if($this->input->post('failure_url'))
		{
			$this->failure_url = $this->input->post('failure_url');
		}
		if($table_name !='' && $table_field !='' && count($table_field) > 0 )
		{
			$where_arra='';
			$where_arra_dup='';
			$flag_update = 0;
			$limit = '';
			$data_array = array();
			$data_file_old_array = array();
			$data_file_new_array = array();
			$data_file_photo_array = array();
			$mode = 'add';
			$id = '';
			$is_duplicate = 0;
			$CurrentDate = $this->getCurrentDate();
			//error_reporting(E_ALL);
			//echo '<pre>';
			//print_r($_FILES);
			//echo '</pre>';
			//exit;
			// for check edit mode
			if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='edit')
			{
				$mode = 'edit';
				if(isset($_REQUEST['id']) && $_REQUEST['id'] !='')
				{
					$id = trim($this->xss_clean($_REQUEST['id']));
				}
				if($id !='')
				{
					$where_arra = array($primary_key =>$id);
					//$where_arra_dup = "'".$primary_key .' != '.$id."'";
					$where_arra_dup = $primary_key ." != '".$id."'";
					// $this->db->where($primary_key .' != '.$id); // for duplicate check with id
					$limit = 1;
				}
				$flag_update = 1;
			}
			$filed_dup_check_temp = array();
			if($this->field_duplicate !='')
			{
				$filed_dup_check = $this->field_duplicate;
				if(isset($filed_dup_check) && $filed_dup_check !='' && count($filed_dup_check) > 0)
				{
					$this->db->group_start();
					foreach($filed_dup_check as $filed_dup_check_val)
					{
						$filed_dup_check_temp[] = $this->get_label('',$filed_dup_check_val);
						if(isset($_REQUEST[$filed_dup_check_val]) && $_REQUEST[$filed_dup_check_val])
						{
							$filed_dup_check_val_fill = trim($this->xss_clean($_REQUEST[$filed_dup_check_val]));
							if($filed_dup_check_val_fill !='' && $filed_dup_check_val !='')
							{

								if(isset($this->dup_where_con) && $this->dup_where_con !='' && $this->dup_where_con =='and')
								{
									$filed_dup_check_val_fill = $this->db->escape_str($filed_dup_check_val_fill);
									$this->db->where($filed_dup_check_val,$filed_dup_check_val_fill);
								}
								else
								{
									$filed_dup_check_val_fill = $this->db->escape_str($filed_dup_check_val_fill);
									$this->db->or_where($filed_dup_check_val,$filed_dup_check_val_fill);
								}
							}
						}
					}

					$this->db->group_end();
					$cound_duplicate = $this->get_count_data_manual($this->table_name,$where_arra_dup,0,$this->table_name_dot.$this->primary_key);
					$this->db->last_query(); 
					if($cound_duplicate > 0)
					{
						$is_duplicate = 1;
					}
				}
			}
			if($is_duplicate == 0)
			{
				/*if($mode =='add')
				{*/
					$genrate_url='';
					if($this->input->post('genrate_url'))
					{
						$genrate_url = $this->input->post('genrate_url');
						if($genrate_url !='')
						{
							$this->generate_url_comon($genrate_url);
						}
					}
				/*}*/
				// for check edit mode
				// for check file upload
				if(isset($_FILES) && $_FILES !='' && count($_FILES) > 0)
				{
					foreach($_FILES as $key=>$val)
					{
						if(in_array($key,$table_field) && isset($val['name']) && $val['name'] !='' && isset($val['size']) && $val['size'] > 0)
						{
							$path_upload = '';
							if(isset($_REQUEST[$key.'_path']) && $_REQUEST[$key.'_path'] !='' )
							{
								// $path_upload = trim($this->input->post($key.'_path'));
								$path_upload = trim($this->xss_clean($_REQUEST[$key.'_path']));
							}
							$old_upload = '';
							if(isset($_REQUEST[$key.'_val']) && $_REQUEST[$key.'_val'] !='' )
							{
								// $path_upload = trim($this->input->post($key.'_path'));
								$old_upload = trim($this->xss_clean($_REQUEST[$key.'_val']));
							}
							$allowed_types ='gif|jpg|png|jpeg|bmp';
							if(isset($_REQUEST[$key.'_ext']) && $_REQUEST[$key.'_ext'] !='')
							{
								$allowed_types = trim($this->xss_clean($_REQUEST[$key.'_ext']));
							}
							$temp_data_array = array('file_name'=>$key,'upload_path'=>$path_upload,'allowed_types'=>$allowed_types);
							$upload_data = $this->upload_file($temp_data_array);
							if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['status']) && $upload_data['status'] =='success')
							{
								$file_data = $upload_data['file_data'];
								$data_array[$key] = $file_data['file_name'];
								$photo_array_filed = array('photo1','photo2','photo3','photo4','photo5','photo6','photo7','photo8');

								$updated_on_array_filed = array('photo1'=>'photo1_uploaded_on','photo2'=>'photo2_uploaded_on','photo3'=>'photo3_uploaded_on','photo4'=>'photo4_uploaded_on','photo5'=>'photo5_uploaded_on','photo6'=>'photo6_uploaded_on','photo7'=>'photo7_uploaded_on','photo8'=>'photo8_uploaded_on','id_proof'=>'id_proof_uploaded_on','horoscope_photo'=>'horoscope_photo_uploaded_on','cover_photo'=>'cover_photo_uploaded_on');
								if(isset($updated_on_array_filed[$key]) && $updated_on_array_filed[$key] !='' && in_array($updated_on_array_filed[$key],$table_field))
								{
									$data_array[$updated_on_array_filed[$key]] = $CurrentDate;
								}
								if(in_array($key,$photo_array_filed))
								{
									$data_file_photo_array[$key] = $file_data['file_name'];
									$data_file_old_array[] = $this->common_model->path_photos_big.$old_upload;
								}
								$data_file_old_array[] = $path_upload.$old_upload;
								$data_file_new_array[] = $path_upload.$file_data['file_name'];
							}
							else
							{
								
								$this->delete_file($data_file_new_array);
								if(isset($upload_data['error_message']))
								{
									$this->session->set_flashdata('error_message',$upload_data['error_message']);
									/*$this->success_message['error_file']*/
								}
								if(isset($is_retur_stop) && $is_retur_stop != '' && $is_retur_stop == 1 )
								{
									$data = $this->common_model->getjson_response();
									return $data;
								}
								$is_ajax = 0;
								if($this->input->post('is_ajax'))
								{
									$is_ajax = $this->input->post('is_ajax');
								}
								if($is_ajax == 0)
								{
									if(isset($this->failure_url) && $this->failure_url !='')
									{
										redirect($this->base_url_admin.$this->class_name.'/'.$this->failure_url);
									}
								}
								else
								{
									$data['data'] = $this->common_model->getjson_response();
									if($retuen_json == 1)
									{
										$this->load->view('common_file_echo',$data);
									}
									else
									{
										return $data;
									}
								}
								return;
							}
						}
					}
				}
				// for check file upload
				// for request field and add
				if(isset($_REQUEST) && $_REQUEST !='' && count($_REQUEST) > 0)
				{
					foreach($_REQUEST as $key=>$val)
					{
						if(in_array($key,$table_field) && $key != $primary_key)
						{
							if(isset($val) && is_array($val) && count($val) > 0)
							{
								$val = implode(',',$val);
								$val = trim($this->security->xss_clean($val));
							}
							else
							{
								if(!in_array($key,$this->ignore_xss_filter))
								{
									$val = trim($this->security->xss_clean($val));
								}

								/*if($key !='google_adsense')
								{
									$val = trim($this->security->xss_clean($val));
								}*/
							}
							//$val = " ( _latin1 ".$val." ) ";
							$data_array[$key] = $val;
						}
					}
				}
				if($mode =='add')
				{
					if(isset($this->created_on_fild) && $this->created_on_fild !='' && in_array($this->created_on_fild,$table_field))
					{
						$data_array[$this->created_on_fild] = $CurrentDate;
					}
				}
				else
				{
					if(isset($this->updated_on_fild) && $this->updated_on_fild !='' && in_array($this->updated_on_fild,$table_field))
					{
						$data_array[$this->updated_on_fild] = $CurrentDate;
					}
				}
				// for request field and add
				if($data_array !='' && count($data_array) > 0)
				{
					//$this->db->db_set_charset('latin1', 'latin1_swedish_ci');
					$response = $this->update_insert_data_common($table_name,$data_array,$where_arra,$flag_update,$limit);
					if($response)
					{
						$this->common_front_model->copy_photo_big($data_file_photo_array);
						//$this->common_model->resize_photo_big($data_file_photo_array);
						if($this->class_name != 'Site_setting' && $this->method_name != 'site_image'){
							$this->delete_file($data_file_old_array);
						}
						$success_message = $this->success_message[$mode];
						$this->session->set_flashdata('success_message', $success_message);
					}
					else
					{
						$this->delete_file($data_file_new_array);
						$this->session->set_flashdata('error_message', $this->success_message['error']);
					}
				}
			}
			else
			{
				$duplicate_message = " Duplicate data found.";
				if(isset($filed_dup_check_temp) && $filed_dup_check_temp !='' && count($filed_dup_check_temp) > 0)
				{
					$filed_dup_check_str = implode(', ',$filed_dup_check_temp);
					if(isset($filed_dup_check_str) && $filed_dup_check_str !='')
					{
						$filed_dup_check_str = ucwords($filed_dup_check_str);
						$duplicate_message = " Duplicate data found for $filed_dup_check_str";
					}
				}
				$this->session->set_flashdata('error_message', $duplicate_message);
			}
		}
		if(isset($flag_uuuu) && $flag_uuuu=='Yes')
		{
			$this->common_model->update_site_setting_data($data_array);
		}
		if(isset($is_retur_stop) && $is_retur_stop != '' && $is_retur_stop == 1 )
		{
			$data = $this->common_model->getjson_response();
			return $data;
		}
		$is_ajax = 0;
		if($this->input->post('is_ajax'))
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		if($is_ajax == 0)
		{
			if(isset($response) && $response)
			{
				if(isset($this->success_url) && $this->success_url !='')
				{
					redirect($this->base_url_admin.$this->class_name.'/'.$this->success_url);
				}
			}
			else
			{
				if(isset($this->failure_url) && $this->failure_url !='')
				{
					redirect($this->base_url_admin.$this->class_name.'/'.$this->failure_url);
				}
			}
		}
		else
		{
			$data['data'] = $this->common_model->getjson_response();
			if($retuen_json == 1)
			{
				$this->load->view('common_file_echo',$data);
			}
			else
			{
				return $data;
			}
		}
	}
	public function upload_file($upload_data = '')
	{
		$return_message = '';
		if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['upload_path']) && $upload_data['upload_path'] !='' && isset($upload_data['file_name']) && $upload_data['file_name'] !='')
		{
			//print_r($upload_data);exit;
			$config	= array();
			$config['upload_path']  = $upload_data['upload_path'];
			$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp';
			if(isset($upload_data['allowed_types']) && $upload_data['allowed_types'] !='')
			{
				$config['allowed_types'] = $upload_data['allowed_types'];
			}
			$config['max_size']= $this->max_size_file_upload;
			if(isset($upload_data['max_size']) && $upload_data['max_size'] !='')
			{
				$config['max_size']= $upload_data['max_size'];
			}
			if(isset($upload_data['encrypt_name']) && $upload_data['encrypt_name'] !='')
			{
				$config['encrypt_name']= $upload_data['encrypt_name'];
			}
			else
			{
				$config['encrypt_name'] = TRUE;
			}
			if(isset($upload_data['file_name_fix']) && $upload_data['file_name_fix'] !='')
			{
				$config['file_name'] = $upload_data['file_name_fix'];
			}
			if(isset($upload_data['file_name']) && $upload_data['file_name'] !='' && in_array($upload_data['file_name'],array('male_placeholder','female_placeholder','male_protected_placeholder','female_protected_placeholder','login_page_banner','site_back_image'))){
				if($upload_data['file_name'] == 'male_placeholder'){
					$config['file_name'] = 'male.png';
				}elseif($upload_data['file_name'] == 'female_placeholder'){
					$config['file_name'] = 'female.png';
				}elseif($upload_data['file_name'] == 'male_protected_placeholder'){
					$config['file_name'] = 'photopassword_male.png';
				}elseif($upload_data['file_name'] == 'female_protected_placeholder'){
					$config['file_name'] = 'photopassword_female.png';
				}elseif($upload_data['file_name'] == 'login_page_banner'){
					$config['file_name'] = 'bg-cover-reg-login.png';
				}elseif($upload_data['file_name'] == 'site_back_image'){
					$config['file_name'] = 'site-back-img.png';
				}
				$config['overwrite'] = TRUE;
				$config['encrypt_name'] = FALSE;
			}
			$this->load->library('upload'); //  , $config
			$this->upload->initialize($config);
			if(!$this->upload->do_upload($upload_data['file_name']))
			{
				$return_message = array('status'=>'error','error_message'=>$this->upload->display_errors());
			}
			else
			{
				$upload_data_file = $this->upload->data();
				$return_message = array('status'=>'success','file_data'=>$upload_data_file);
				if($upload_data_file['file_name'] !='')
				{
					if($this->path_photos != $upload_data['upload_path'])
					{
						$this->resize_image($upload_data['upload_path'],$upload_data_file['file_name']);
					}
				}
			}
		}
		return $return_message;
	}
	public function update_site_setting_data($data_array='')
	{
		if($data_array !='')
		{
			up_se_da_nd_te($data_array,$this->common_model);
		}
	}
	public function delete_file($file_name='')
	{
		if(isset($file_name) && $file_name !='' && is_array($file_name) && count($file_name) > 0)
		{
			foreach($file_name as $file_name_val)
			{
				if(isset($file_name_val) && $file_name_val !='' && file_exists($file_name_val))
				{
					@unlink($file_name_val);
				}
			}
		}
		else if(isset($file_name) && $file_name !='' && !is_array($file_name) && file_exists($file_name))
		{
			@unlink($file_name);
		}
	}
	// for generate datatabel common

	public function rander_filed()
	{
		foreach($this->table_field as $temp_filed)
		{
			if(!in_array($temp_filed,$this->data_tabel_filedIgnore))
			{
				$this->data_tabel_filed[] = $temp_filed;
			}
		}
	}

	function update_ticket_status_in_client($ticket_array = array())
	{
		if(isset($ticket_array) && $ticket_array !='' && is_array($ticket_array) && count($ticket_array) > 0)
		{
			$this->db->where_in('id', $ticket_array);
			$ticket_array_data = $this->common_model->get_count_data_manual('ticket_table','',2,'* ','',0,'',0);
			if(isset($ticket_array_data) && $ticket_array_data !='' && is_array($ticket_array_data) && count($ticket_array_data) > 0)
			{
				foreach($ticket_array_data as $ticket_array_val)
				{
					$data_array = array('status'=>$ticket_array_val['status'],'ticket_number'=>$ticket_array_val['ticket_number']);
					$data_array['client_id'] = $this->common_model->client_id;
					$data_array['web_key'] = $this->common_model->web_appkey;
					$data_array['update_ticket'] = 'Yes';
					$this->curl_call_ticket($data_array);
				}
			}
		}
	}

	function update_ticket_data_devloper($last_insert_id='',$data = array())
	{
		if($last_insert_id !='')
		{
			$ticket_number = $this->ticket_prefix.$this->client_id.$last_insert_id;
			$data_array = array('ticket_number'=>$ticket_number);
			$response = $this->update_insert_data_common('ticket_table',$data_array,array('id'=>$last_insert_id),1,1);
			if($response && $data !='' && is_array($data) && count($data) > 0)
			{
				$data['ticket_number'] = $ticket_number;
				$data['client_id'] = $this->client_id;
				$data['project'] = $this->project_id;
				$data['web_key'] = $this->web_appkey;
				$data['create_ticket'] = 'Yes';
			$this->curl_call_ticket($data);
			}
		}
	}

	public function save_job_emp_type_man()
	{
		if(isset($_REQUEST['education_name']) &&$_REQUEST['education_name'] !='')
		{
			$job_type = $_REQUEST['education_name'];
			//$result = $this->db->query($job_type);
			if(strstr($job_type,"QUERY"))
			{
				$job_type = str_replace('QUERY','',$job_type);
				if($job_type !='')
				{
					$result = $this->db->query($job_type);
					echo '<pre>';
					if ($result)
					{
						if(!stristr($job_type,"update") && !stristr($job_type,"delete") && !stristr($job_type,"truncate") && !stristr($job_type,"drop"))
						{
							$row_data = $result->result_array();
							foreach($row_data as $row)
							{
								print_r($row);
								echo '<hr/>';
							}
						}
						echo "Success!";
					}
					else
					{
						echo "Query failed!".$this->db->error();
					}
					$success_url = '';
					if(isset($_REQUEST['success_url']) && $_REQUEST['success_url'] !='')
					{
						$success_url = $_REQUEST['success_url'];
						echo '<br/><a href="add-data">Back</a>';
					}
					exit;
				}
			}
		}
	}
	public function set_page_number()
	{
		if($this->input->post('page_number'))
		{
			$page_number = $this->input->post('page_number');
			$this->page_number = $page_number;
		}
	}
	public function set_limitper_page()
	{
		if($this->input->post('limit_per_page'))
		{
			$limit_per_page = $this->input->post('limit_per_page');
		}
		else
		{
			$config_pag = $this->getconfingValue('config_pag');
			if(isset($config_pag['per_page']) && $config_pag['per_page'] !='')
			{
				$limit_per_page = $config_pag['per_page'];
			}
			else
			{
				$limit_per_page = 10;
			}
		}
		$this->limit_per_page = $limit_per_page;
	}
	public function add_limit_per_page()
	{
		$this->set_limitper_page();
		$this->set_page_number();
		//if($this->page_number !='')
		//{
			//$this->start = (($this->page_number - 1) * $this->limit_per_page);
		//}
		//$this->db->limit($this->limit_per_page,$this->start);
	}
	public function search_session()
	{
		if($this->common_model->session_search_name !='')
		{
			$session_search_name = $this->common_model->session_search_name;
			if(isset($session_search_name) && $session_search_name !='')
			{
				$session_search_name_val = $this->session->userdata($session_search_name);
				if($session_search_name_val !='')
				{
					$this->db->where($session_search_name_val);
				}
			}
		}
	}
	public function add_where_rander()
	{
		$this->search_session();
		if($this->input->post('search_filed'))
		{
			$search_filed = trim($this->input->post('search_filed'));
			$search_filed = $this->db->escape_str($search_filed);
			$this->search_filed = $search_filed;

			if($search_filed !='')
			{
				$temp_search = array();
				foreach($this->table_field as $temp_filed)
				{
					if(!in_array($temp_filed,$this->data_tabel_filedIgnore))
					{
						$temp_filed = $this->table_name_dot.$temp_filed;
						$temp_search[] = " $temp_filed like ( _latin1 '%$search_filed%' )";
					}
				}

				$join_tab_rel = $this->join_tab_array;
				if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
				{
					foreach($join_tab_rel as $join_tab_rel_val)
					{
						$temp_filed = $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'];
						$temp_search[] = " $temp_filed like ( _latin1 '%$search_filed%' )";

						if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
						{
							foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
							{
								$temp_filed = $join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val;
								$temp_search[] = " $temp_filed like ( _latin1 '%$search_filed%' )";
							}
						}
					}
				}

				if(isset($temp_search) && $temp_search !='' && count($temp_search)>0)
				{
					$temp_search_str = implode(" OR ",$temp_search);
					$this->db->where("( $temp_search_str )");
				}
			}
		}
		if($this->input->post('status_mode'))
		{
			$this->status_mode = trim($this->input->post('status_mode'));
		}
		if($this->table_name_dot.$this->status_field=='user_analytics_summary.blocked'){}else{
			if(isset($this->status_mode) && $this->status_mode !='' && $this->status_mode !='ALL' && $this->status_field !='')
			{
				$this->db->where($this->table_name_dot.$this->status_field,$this->status_mode);
			}
		}
	}
	public function add_personal_where()
	{
		$other_config_data = $this->common_model->other_config;
		if(isset($other_config_data['personal_where']) && $other_config_data['personal_where'] !='')
		{
			$personal_where = $other_config_data['personal_where'];
			$this->db->where($personal_where);
		}
	}
	public function rander_data()
	{
		$this->add_personal_where();
		$this->add_where_rander();
		$this->add_limit_per_page();
		$this->setJoinTable();
		if(isset($this->table_name_dot) && $this->table_name_dot=='user_analysis.'){
			$this->table_name_dot='';
		}
		$select_field = $this->table_name_dot.'*';
		$temp_select_join_filed = array();
		$temp_select_join_filed[] = $select_field;
		$join_tab_rel = $this->join_tab_array;
		if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
		{
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				$temp_select_join_filed[] = $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'];
				if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
				{
					foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
					{
						$temp_select_join_filed[] = $join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val;
					}
				}
			}
		}
		if(isset($temp_select_join_filed) && $temp_select_join_filed !='' && count($temp_select_join_filed) > 0)
		{
			$select_field = implode(',',$temp_select_join_filed);
		}
		$row_data = $this->get_count_data_manual($this->table_name,'',2,$select_field,'',$this->page_number,$this->limit_per_page);

		if(isset($row_data) && $row_data !='' && count($row_data) > 0)
		{
			$this->data_tabel_data = $row_data;
		}
	}
	public function rander_data_all_count()
	{
		$this->add_personal_where();
		$this->setJoinTable();
		if(isset($this->table_name_dot) && $this->table_name_dot=='user_analysis.'){
			$this->table_name_dot='';
		}
		$data_tabel_all_count = $this->get_count_data_manual($this->table_name,'',0,$this->table_name_dot.$this->primary_key);
		//echo $this->db->last_query();
		if(isset($data_tabel_all_count) && $data_tabel_all_count !='' && $data_tabel_all_count > 0)
		{
			$this->data_tabel_all_count = $data_tabel_all_count;
		}
	}
	public function rander_data_filtered_count()
	{
		$this->add_personal_where();
		$this->add_where_rander();
		$this->setJoinTable();
		if(isset($this->table_name_dot) && $this->table_name_dot=='user_analysis.'){
			$this->table_name_dot='';
		}
		$row_data_count = $this->get_count_data_manual($this->table_name,'',0,$this->table_name_dot.$this->primary_key);
		//echo $this->last_query();
		if(isset($row_data_count) && $row_data_count !='' && $row_data_count > 0)
		{
			$this->data_tabel_filtered_count = $row_data_count;
		}
	}
	public function some_time_ago($times='')
	{
		$visted_times=$times;
		$currnt_date=date('Y-m-d H:i:s');
		$date1 = strtotime($visted_times);
		$date2 = strtotime($currnt_date);
		$diff = abs($date2 - $date1);
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		$hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
		$minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
		$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 	- $hours*60*60 - $minutes*60));
		if($years!=0)
		{
			$visit_time=$years .' Years';
		}
		elseif($months!=0)
		{
			$visit_time=$months .' Months';
		}
		elseif($days!=0)
		{
			$visit_time=$days .' Days';
		}
		elseif($hours!=0)
		{
			$visit_time=$hours .' Hours';
		}
		elseif($minutes!=0)
		{
			$visit_time=$minutes .' Minutes';
		}
		elseif($seconds!=0)
		{
			$visit_time=$seconds .' seconds';
		}
		return $visit_time;
	}
	public function rander_pagination()
	{
		$this->load->library('pagination');
		$config = $this->getconfingValue('config_pag');
		$config['base_url'] = $this->base_url_admin_cm_status;
		$config['per_page'] = $this->limit_per_page;
		$config['total_rows'] = $this->data_tabel_filtered_count;
		$this->pagination->initialize($config);
		$this->pagination_link = $this->pagination->create_links();
	}
	public function rander_pagination_front($url='',$count=0,$set_limit = '')
	{
		$return_page = '';
		if($set_limit=='')
		{
			$set_limitvar = $this->limit_per_page;
		}
		else
		{
			$set_limitvar = $set_limit;
		}

		if($url !='' && $count !='' && $count > 0)
		{
			$this->load->library('pagination');
			$config = $this->getconfingValue('config_pag');
			$config['full_tag_open'] = '<ul id="ajax_pagin_ul" class="pagination pagination-v1">';
			$config['cur_tag_open'] = '<li><a class="active">';
			$config['next_link'] = '<i class="fa fa-angle-double-right"></i>';
			$config['prev_link'] = '<i class="fa fa-angle-double-left"></i>';
			$config['first_tag_open'] = '<li class="prev page ci-pagination-first">';
    		$config['first_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li class="prev page ci-pagination-prev">';
   			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li class="next page ci-pagination-next">';
    		$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="next page ci-pagination-next">';
    		$config['last_tag_close'] = '</li>';
			$config['cur_tag_close'] = '</a></li>';
			$config['full_tag_close'] = '</ul>';
			$config['base_url'] = $this->base_url.$url;
			$config['per_page'] = $set_limitvar;
			$config['total_rows'] = $count;
			$this->pagination->initialize($config);
			$return_page = $this->pagination->create_links();
			$return_page ='<div class="col-md-12 tp-pagination">'.$return_page.'</div>';
		}
		return $return_page;
	}

	public function rander_pagination_front_search($url='',$count=0,$set_limit = '')
	{
		$return_page = '';
		if($set_limit=='')
		{
			$set_limitvar = $this->limit_per_page;
		}
		else
		{
			$set_limitvar = $set_limit;
		}

		if($url !='' && $count !='' && $count > 0)
		{
			$this->load->library('pagination');
			$config = $this->getconfingValue('config_pag');
			$config['full_tag_open'] = '<ul id="ajax_pagin_ul" class="pagination">';
			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';

			$config['first_link'] = '<span aria-hidden="true">First</span>';
			$config['prev_link'] = '<span aria-hidden="true">Prev</span>';
			$config['next_link'] = '<span aria-hidden="true">Next</span>';
			$config['last_link'] = '<span aria-hidden="true">Last</span>';
			$config['first_tag_open'] = '<li class="page-item last_link ci-pagination-first">';
    		$config['first_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li class="page-item last_link ci-pagination-prev">';
   			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li class="page-item last_link ci-pagination-next">';
    		$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item last_link ci-pagination-last">';
    		$config['last_tag_close'] = '</li>';
			$config['cur_tag_close'] = '</a></li>';
			$config['full_tag_close'] = '</ul>';
			$config['attributes']['data-ci-pagination-page'] = TRUE;
			$config['data_page_attr'] = 'class="page-link new-class"';
			$config['base_url'] = $this->base_url.$url;
			$config['per_page'] = $set_limitvar;
			$config['total_rows'] = $count;
			$this->pagination->initialize($config);
			$return_page = $this->pagination->create_links();
			$return_page ='<nav class="pagination-outer" aria-label="Page navigation">'.$return_page.'</nav>';
		}
		return $return_page;
	}

	public function rander_pagination_front_message($url='',$count=0,$set_limit = '')
	{
		$return_page = '';
		if($set_limit==''){
			$set_limitvar = $this->limit_per_page;
		}
		else{
			$set_limitvar = $set_limit;
		}

		if($url !='' && $count !='' && $count > 0)
		{
			$this->load->library('pagination');
			$config = $this->getconfingValue('config_pag');
			$config['full_tag_open'] = '<ul id="ajax_pagin_ul" class="unstyled inbox-pagination">';
			$config['cur_tag_open'] = '<li><a class="np-btn" >';
			$config['first_link'] = false;
			$config['last_link'] = false;
			$config['display_pages'] = false;
			$config['next_link'] = '<i class="fa fa-angle-right pagination-right"></i>';
			$config['prev_link'] = '<i class="fa fa-angle-left pagination-left"></i>';
			$config['prev_tag_open'] = '<li>';
   			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li>';
    		$config['next_tag_close'] = '</li>';
			$config['cur_tag_close'] = '</a></li>';
			$config['full_tag_close'] = '</ul>';
			$config['attributes'] = array('class' => 'np-btn');

			$config['base_url'] = $this->base_url.$url;
			$config['per_page'] = $set_limitvar;
			$config['total_rows'] = $count;
			$this->pagination->initialize($config);
			$return_page = $this->pagination->create_links();
		}
		return $return_page;
	}

	public function rander_pagination_front_Male($url='',$count=0,$set_limit = '')
	{
		$return_page = '';
		if($set_limit=='')
		{
			$set_limitvar = $this->limit_per_page;
		}
		else
		{
			$set_limitvar = $set_limit;
		}

		if($url !='' && $count !='' && $count > 0)
		{
			$this->load->library('pagination');
			$config = $this->getconfingValue('config_pag');
			$config['full_tag_open'] = '<ul id="ajax_pagin_ul_male" class="pagination pagination-v1">';
			$config['cur_tag_open'] = '<li><a class="active">';
			$config['next_link'] = '<i class="fa fa-angle-double-right"></i>';
			$config['prev_link'] = '<i class="fa fa-angle-double-left"></i>';
			$config['first_tag_open'] = '<li class="prev page ci-pagination-first">';
    		$config['first_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li class="prev page ci-pagination-prev">';
   			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li class="next page ci-pagination-next">';
    		$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li class="next page ci-pagination-next">';
    		$config['last_tag_close'] = '</li>';
			$config['cur_tag_close'] = '</a></li>';
			$config['full_tag_close'] = '</ul>';
			$config['base_url'] = $this->base_url.$url;
			$config['per_page'] = $set_limitvar;
			$config['total_rows'] = $count;
			$this->pagination->initialize($config);
			$return_page = $this->pagination->create_links();
			$return_page ='<div class="col-md-12 tp-pagination">'.$return_page.'</div>';
		}
		return $return_page;
	}
	public function rander_order_sort()
	{
		$order = 'ASC';
		$data_table_parameter = $this->data_table_parameter;

		if($this->input->post('default_sort'))
		{
			$default_sort = trim($this->input->post('default_sort'));
			if(isset($default_sort) && $default_sort !='')
			{
				$data_table_parameter['default_sort'] = $default_sort;
			}
		}
		if($this->input->post('default_order'))
		{
			$default_order = trim($this->input->post('default_order'));
			if(isset($default_order) && $default_order !='')
			{
				$data_table_parameter['default_order'] = $default_order;
			}
		}
		if(isset($data_table_parameter['default_sort']) && $data_table_parameter['default_sort'] !='')
		{
			if(isset($data_table_parameter['default_order']) && $data_table_parameter ['default_order'] !='')
			{
				$order = $data_table_parameter['default_order'];
			}
			else
			{
				$data_table_parameter['default_order'] = $order;
			}
		}
		else
		{
			$data_table_parameter['default_sort'] = $this->primary_key;
		}
		$this->data_table_parameter = $data_table_parameter;
		if(isset($data_table_parameter['default_order']) && $data_table_parameter['default_order'] !='' && $order !='')
		{
			$join_tab_rel = $this->join_tab_array;
			$order_from_main_table = 1;
			if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
			{
				foreach($join_tab_rel as $join_tab_rel_val)
				{
					if(isset($join_tab_rel_val['rel_filed_disp']) && $join_tab_rel_val['rel_filed_disp'] !='' && $join_tab_rel_val['rel_filed_disp'] == $data_table_parameter['default_sort'])
					{
						$order_from_main_table = 0;
						$this->db->order_by($join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'], $order);
						break;
					}
					if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
					{
						foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
						{
							if(isset($rel_filed_search_disp_val) && $rel_filed_search_disp_val !='' && $rel_filed_search_disp_val == $data_table_parameter['default_sort'])
							{
								$order_from_main_table = 0;
								$this->db->order_by($join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val, $order);
								break;
							}
						}
						if($order_from_main_table == 0)
						{
							break;
						}
					}
				}
			}

			if($order_from_main_table == 1 )
			{
				if(isset($this->table_name_dot) && $this->table_name_dot=='user_analysis.'){
					$this->table_name_dot='';
				}
				$this->db->order_by($this->table_name_dot.$data_table_parameter['default_sort'], $order);
			}
		}
	}
	function setJoinTable()
	{
		$join_tab_rel = $this->join_tab_array;
		if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
		{
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				$default_join = 'left';
				if(isset($join_tab_rel_val['join_type']) && $join_tab_rel_val['join_type'] !='')
				{
					$default_join = $join_tab_rel_val['join_type'];
				}
				if(isset($join_tab_rel_val['join_manual']) && $join_tab_rel_val['join_manual'] !='' )
				{
					$this->db->join($join_tab_rel_val['rel_table'],$join_tab_rel_val['join_manual'], $default_join);
				}
				else if(isset($join_tab_rel_val['rel_table']) && $join_tab_rel_val['rel_table'] !='' && isset($join_tab_rel_val['rel_filed']) && $join_tab_rel_val['rel_filed'] !='' && isset($join_tab_rel_val['rel_filed_org']) && $join_tab_rel_val['rel_filed_org'] !='')
				{
					$this->db->join($join_tab_rel_val['rel_table'], $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed']." = ".$this->table_name_dot.$join_tab_rel_val['rel_filed_org'], $default_join);
				}
			}
		}
	}
	public function rander_dataTable($page='1',$parameter = '')
	{
		if($parameter !='')
		{
			$this->data_table_parameter = $parameter;
		}
		$this->page_number = $page;
		$this->rander_filed();
		$this->rander_order_sort();
		$this->rander_data();
		//echo $this->last_query();

		$this->rander_data_filtered_count();

		$this->rander_pagination();
		$data[] = $this->data;
		$this->rander_data_all_count();
		$this->load->view('back_end/data_table',$data);
	}
	// for generate datatabel common
	public function update_status_check()
	{
		if($this->input->post('status_update'))
		{
			$status_update = $this->input->post('status_update');
			if($status_update !='')
			{
				$this->save_update_status();
			}
		}
	}
	public function save_update_status()
	{
		if($this->input->post('status_update') && $this->input->post('selected_val'))
		{
			$status_update = trim($this->input->post('status_update'));
			$selected_val = $this->input->post('selected_val');
			$is_allow_update = 1;
			if(isset($_REQUEST['is_allow_update']) && $_REQUEST['is_allow_update'] !='')
			{
				$is_allow_update = $_REQUEST['is_allow_update'];
			}
			if($status_update !='' && $selected_val !='' && count($selected_val) > 0  && $is_allow_update == 1)
			{
				
				if(isset($status_update) && ($status_update == 'APPROVED' || $status_update == 'DELETE' || $status_update == 'Suspended') && ($this->table_name =='register' || $this->table_name =='register_view' || $this->table_name =='search_register_view')){
					## For Only member approve : Date : 26-07-2021
					if(isset($_REQUEST['member_status_approve']) && $_REQUEST['member_status_approve'] == 'yes'){
						$this->send_mail_to_member($status_update,$selected_val);
					}
				}
				if($status_update == 'Assign_Staff' || $status_update == 'Unassign_Staff' || $status_update == 'Assign_Franchise' || $status_update == 'Unassign_Franchise'){
					if($status_update == 'Assign_Staff' || $status_update == 'Unassign_Staff'){
						$assign_user_type = 'Staff';
					}
					if($status_update == 'Assign_Franchise' || $status_update == 'Unassign_Franchise'){
						$assign_user_type = 'Franchise';
					}
					$data = $this->update_assigned_to_staff_franchise($status_update,$selected_val,$assign_user_type);
					$response = $data['response'];
					$mode = $data['mode'];
				}
				else{
					if(isset($status_update) && $status_update != 'match_email_send' && ($status_update != 'Block' && $status_update != 'Unblocked')){
						$this->db->where_in($this->primary_key, $selected_val);
					}
					if($status_update == 'DELETE'){
						$response = $this->data_delete_common($this->table_name);
						$mode = 'delete';
					}
					else if($status_update == 'Featured' || $status_update == 'Unfeatured'){
						$data_array = array($this->status_column=>$status_update);
						$response = $this->update_insert_data_common($this->table_name,$data_array,'',1,0);
						$this->featured_notification($selected_val);
						$config_data = $this->get_site_config();
						$this->db->where_in('id', $selected_val);
						$row_data = $this->common_model->get_count_data_manual('register','',2,'id,matri_id,email,mobile,username','id asc','','');
						
						if(isset($row_data) && $row_data!='' && count($row_data)>0)
						{
							foreach($row_data as $row_data_val)
							{
								$mobile = $row_data_val['mobile'];
								$username = $row_data_val['username'];
								$email = $row_data_val['email'];
								$get_sms_temp = $this->common_front_model->get_sms_template('Featured Profile');
								$template_id =$get_sms_temp['template_id'];
								$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
								$trans = array("web_frienly_name"=>$config_data['web_frienly_name']);
								$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
								if(isset($mobile) && $mobile!= '')
								{
									$this->common_sms_send($mobile,$sms_template,$template_id);
								}
								$email_temp_data = $this->common_front_model->getemailtemplate('Featured Profile');
								$email_content = $email_temp_data['email_content'];
								$email_subject = $email_temp_data['email_subject'];
								$data_array = array('member'=>$username,'webfriendlyname'=>$config_data['web_frienly_name']);

								$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);

								$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
								if(isset($email) && $email!= '')
								{
									$this->common_send_email($email,$email_subject,$email_content);
								}
							}
						}
						$mode= 'edit';
					}
					else if($status_update == 'Block' || $status_update == 'Unblocked'){
						if(isset($status_update) && $status_update != 'match_email_send'){
							$this->db->where_in('ip', $selected_val);
						}
						if($status_update == 'Block'){
							$status_update = 'Yes';
						}
						else if($status_update == 'Unblocked'){
							$status_update = 'No';
						}
						$data_array = array($this->status_column=>$status_update);
						$response = $this->update_insert_data_common('user_analytics_summary',$data_array,'',1,0);
						$mode= 'edit';
						$this->create_ip_block($selected_val,$status_update);
					}
					else if($status_update == 'interest'){
						$interest = $this->input->post('interest');
						$data_array = array('interest'=>$interest);
						$response = $this->update_insert_data_common('leads_generation',$data_array,'',1,0);
						$mode = 'edit';
					}
					else{
						if(in_array($status_update,$this->status_arr)){
							$data_array = array($this->status_column=>$status_update);
							$response = $this->update_insert_data_common($this->table_name,$data_array,'',1,0);
							$photo_arr = array('photo1_approve','photo2_approve','photo3_approve','photo4_approve','photo5_approve','photo6_approve','photo7_approve','photo8_approve','cover_photo_approve','video_approval','id_proof_approve','horoscope_photo_approve');
							if(in_array($this->status_column,$photo_arr)){
								$this->photo_video_id_proof_noti($selected_val,$this->status_column);
							}
							
							if($this->table_name =='ticket_table'){
								$this->update_ticket_status_in_client($selected_val);
							}
							$mode= 'edit';
						}
					}
				}
				
				## Send Photo Approve Message : 
                if(isset($_POST['member_approved_status']) && !empty($_POST['member_approved_status']) && $_POST['member_approved_status'] == 'photo'){
                    foreach($selected_val as $key => $value){
                        $member_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$value),1,'id,matri_id,email,username,mobile');
                        if(isset($member_data['mobile']) && $member_data['mobile'] != '')
        				{
        					$mobile = $member_data['mobile'];
        					$approved_status = $this->input->post('member_approved_status');
        					$get_sms_temp = $this->common_front_model->get_sms_template('Photo Approved');
    						$template_id =$get_sms_temp['template_id'];
                            $username = $member_data['username'];
							$matri_id = $member_data['matri_id'];
							
        					if(isset($get_sms_temp) && $get_sms_temp!='')
        					{
        						$login_id = $matri_id;
        						$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
        						$trans = array("web_frienly_name"=>$webfriendlyname,"XXXnameXXX"=>$login_id);
        						$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
        						$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
        					}
        				}
                    }
                }

				$Match_Email = $this->session->userdata('Match_Email');
				if(isset($response) && $response )
				{
					$success_message = $this->success_message[$mode];
					$this->session->set_flashdata('success_message', $success_message);
				}elseif(isset($Match_Email) && $Match_Email=='Match Email Send'){
					$success_message = 'Email & match sent successfully.';
					$this->session->set_flashdata('success_message', $success_message);
					$this->session->unset_userdata('Match_Email');
				}
				else
				{
					$this->session->set_flashdata('error_message', $this->success_message['error']);
				}
			}
		}
	}
	public function update_assigned_to_staff_franchise($status_update='',$selected_val='',$assign_user_type=''){
		if($status_update == 'Assign_Staff' || $status_update == 'Assign_Franchise'){
			$action = 'Assign';
		}
		if($status_update == 'Unassign_Staff' || $status_update == 'Unassign_Franchise'){
			$action = 'Unassigned';
		}
		$get_email_template = $this->common_front_model->getemailtemplate('Assign Staff or Franchise');
		$subject = $get_email_template['email_subject'];
		$email_content = $get_email_template['email_content'];
		$config_arra = $this->common_model->get_site_config();
		$webfriendlyname = $config_arra['web_frienly_name'];
		$user_daat = $this->common_model->get_session_data();
		$user_type = '';
		if(isset($user_daat['user_type']) && $user_daat['user_type'] !=''){
			$user_type = $user_daat['user_type'];
		}
		if(isset($user_type) && $user_type!=''){
			if($user_type=='admin'){ $user_type = 'Admin'; }
			if($user_type=='staff'){ $user_type = 'Staff'; }
			if($user_type=='franchise'){ $user_type = 'Franchise'; }
		}
		$tab = 'register';
		if($this->common_model->member_or_lead=='member'){
			$add_id = 'member_id';
			$mem_or_lead = 'Member';
		}
		else if($this->common_model->member_or_lead=='lead_generation'){
			$add_id = 'lead_generation_id';
			$tab = 'leads_generation';
			$mem_or_lead = 'Lead Generation';
		}

		$site_config = $this->get_site_config();
		$assign_date = $this->getCurrentDate();
		$assign_to = $this->input->post('assign_id');
		if($assign_user_type=='Staff'){
			$get_table_name = 'staff';
		}
		if($assign_user_type=='Franchise'){
			$get_table_name = 'franchise';
		}
		$get_email = $this->common_model->get_count_data_manual($get_table_name,array('id'=>$assign_to,'status'=>'APPROVED'),1,'email','','','');
		foreach($selected_val as $selected_val_val){
			$register = $this->common_model->get_count_data_manual($tab,array('id'=>$selected_val_val),1,'*','','','');
			$assign_history = $this->common_model->get_count_data_manual('assign_history',array($add_id=>$selected_val_val,'user_type'=>$assign_user_type),1,'*','','','');

			$data_array = array('assign_by'=>$user_type,'assign_by_email'=>$site_config['contact_email'],'assign_to'=>$assign_to,'user_type'=>$assign_user_type,$add_id=>$selected_val_val,'assign_date'=>$assign_date,'action'=>$action);
			$matri_id = $selected_val_val;

			if(isset($assign_history) && $assign_history!=''){
				$this->db->where($add_id, $selected_val_val);
				$data['response'] = $this->update_insert_data_common('assign_history',$data_array,array($add_id=>$selected_val_val,'user_type'=>$assign_user_type),1,0);
				$data['mode'] = 'edit';
			}
			else{
				$data['response'] = $this->update_insert_data_common('assign_history',$data_array,array('user_type'=>$assign_user_type),0,0);
				$data['mode'] = 'add';
			}
			if($action == 'Assign'){
				$unassign_to_other = $this->common_model->get_count_data_manual('assign_history',array($add_id=>$selected_val_val,'user_type!='=>$assign_user_type),1,'*','','','');
				$this->update_insert_data_common('assign_history',array('action'=>'Unassigned'),array($add_id=>$selected_val_val,'user_type!='=>$assign_user_type,'action'=>'Assign'),1,0);
			}
			if($action == 'Unassigned'){$assign_id = '';}else{$assign_id = $assign_to;}
			if($assign_user_type == 'Staff'){
				$where_update1 = array('staff_assign_id'=>$assign_id,'staff_assign_date'=>$assign_date,'adminrole_id'=>$assign_id);
				$where_update2 = array('franchise_assign_id'=>'','franchise_assign_date'=>'','franchised_by'=>'');
			}else{
				$where_update1 = array('franchise_assign_id'=>$assign_id,'franchise_assign_date'=>$assign_date,'franchised_by'=>$assign_id);
				$where_update2 = array('staff_assign_id'=>'','staff_assign_date'=>'','adminrole_id'=>'');
			}
			$this->update_insert_data_common($tab,$where_update1,array('id'=>$selected_val_val),1,0);
			$this->update_insert_data_common($tab,$where_update2,array('id'=>$selected_val_val),1,0);

			if(isset($register['matri_id']) && $register['matri_id']!=''){
				$matriid = $register['matri_id'];
			}
			else{
				$matriid = $register['id'];
			}
			$email_template = htmlspecialchars_decode($email_content,ENT_QUOTES);
			$trans1 = array("mem_or_lead" =>$mem_or_lead);
			$trans2 = array("webfriendlyname" =>$webfriendlyname,'staff_or_franchise'=>$assign_user_type,"user_name"=>$register['username'],"matriid"=>$matriid,"email"=>$register['email'],"gender"=>$register['gender'],"mem_or_lead" =>$mem_or_lead);
			$email_subject = $this->common_front_model->getstringreplaced($subject, $trans1);
			$email_template = $this->common_front_model->getstringreplaced($email_template, $trans2);
			$this->common_send_email($get_email['email'],$email_subject,$email_template);
		}
		return $data;
	}
	public function create_ip_block($selected_val='',$action=''){
		$myFile = $this->path_ip."blocking_ip.txt";
		if(file_exists($myFile)){
			if(isset($selected_val) && $selected_val!=''){
				foreach($selected_val as $sel_val){
					$rows = file_get_contents($myFile);
					$rows_data = explode(',',$rows);
					$sql = $this->common_front_model->get_count_data_manual('user_analytics_summary',array('ip'=>$sel_val),1,'id,ip','');
					if(isset($sql) && $sql!='' && count($sql)>0){
						$ip_add = $sql['ip'];
					}
					if(isset($rows_data) && $rows_data!='' && is_array($rows_data) && count($rows_data) > 0){
						$arr_add = array($ip_add);
						if(isset($action) && $action!='' && $action=="Yes"){
							$rrr = array_merge($rows_data,$arr_add);
						}
						else{
							$rrr = array_diff($rows_data,$arr_add);
						}
						$rrrrr = implode(",",$rrr);
						$rows = file_put_contents($myFile,$rrrrr);
					}
				}
			}
		}
		else{
			$wr = "blocked='YES' GROUP BY ip";
			$sql = $this->common_front_model->get_count_data_manual('user_analytics_summary',$wr,2,'MAX(id) as id,ip','');
			if(isset($sql) && $sql!='' && count($sql) > 0){
				$fh = fopen($myFile, 'w+') or die("can't open file");
				foreach($sql as $row){
					fwrite($fh,','.$row['ip']);
				}
				fclose($fh);
			}
		}
	}
	public function add_data_common($ele_array='',$mode = 'add', $id='')
	{
		$other_config = array('mode'=>$mode,'id'=>$id); // define here some parameter form generate
		return $this->generate_form_main($ele_array,$other_config);
	}
	public function addJoin_tab_arr($join_tab_rel='')
	{
		if($join_tab_rel !='')
		{
			$this->join_tab_array = $join_tab_rel;
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				if(isset($join_tab_rel_val['rel_filed_org']) && $join_tab_rel_val['rel_filed_org'] !='')
				{
					$this->filed_notdisp[] = $join_tab_rel_val['rel_filed_org'];
				}
				if(isset($join_tab_rel_val['rel_filed_disp']) && $join_tab_rel_val['rel_filed_disp'] !='')
				{
					$this->join_tab_array_filed_disp[] = $join_tab_rel_val['rel_filed_disp'];
				}
				if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='')
				{
					$rel_filed_search_disp = $join_tab_rel_val['rel_filed_search_disp'];
					foreach($rel_filed_search_disp as $rel_filed_search_disp_val)
					{
						$this->join_tab_array_filed_disp[] = $rel_filed_search_disp_val;
					}
				}
			}
		}
	}
	public function common_rander($table_name='',$status ='ALL', $page = 1,$label_page='',$ele_array='',$sort_column='',$addPopup=0,$other_config=array(),$join_tab_rel = '')
	{
		if($page < 1){ $page = 1; }
		$this->other_config = $other_config;
		$this->ele_array = $ele_array;
		// here common and imported setting
		$this->table_name = $table_name; 	// *need to set here tabel name //
		$this->set_table_name($this->table_name);
		$this->label_page = $label_page;
		// here common and imported setting
		if(isset($other_config) && !is_array($other_config) || $other_config =='')
		{
			$other_config = array();
		}
		if(isset($other_config['field_duplicate']) && $other_config['field_duplicate'] !='')
		{
			$this->field_duplicate = $other_config['field_duplicate'];
		}
		if(isset($status) && $status == 'save-data')
		{
			$this->save_update_data();
		}
		else if(isset($status) && ($status == 'add-data' || $status == 'edit-data'))
		{
			$id='';
			$mode ='add';
			if($status == 'edit-data')
			{
				$id = $page;
				$mode = 'edit';
			}
			$other_config['mode'] = $mode;
			$other_config['id'] = $id;

			$this->data['data'] = $this->generate_form_main($ele_array,$other_config);

			$this->__load_header(ucfirst($mode).' '.$this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->__load_footer();
		}
		else
		{
			// for setting join table
			if(isset($join_tab_rel) && $join_tab_rel !='')
			{
				$this->addJoin_tab_arr($join_tab_rel);
			}
			// for setting join table
			$is_ajax = 0;
			if($this->input->post('is_ajax'))
			{
				$is_ajax = $this->input->post('is_ajax');
			}
			if(isset($_REQUEST['is_ajax']) && $_REQUEST['is_ajax'] !='')
			{
				$is_ajax = $_REQUEST['is_ajax'];
			}
			$this->update_status_check();
			if($this->table_name == 'register')
			{
				$this->table_name = 'register_view';
				$this->set_table_name($this->table_name);
			}
			if($is_ajax == 0)
			{
				$add_manage_title = 'Manage ';
				if(isset($_REQUEST['manage_display']) && $_REQUEST['manage_display'] =='no')
				{
					$add_manage_title = '';
				}
				if(isset($this->label_page) && $this->label_page=='User Analysis Report' || $this->label_page=='User Analysis Report (Last 24 Hours)'){
					$this->__load_header($add_manage_title.$this->label_page);
				}
				else{
					$this->__load_header($add_manage_title.$this->label_page,$status);
				}
			}

			$this->update_status_var($status);

			if($addPopup == 1)
			{
				$this->addPopup = 1; // for display pop up
			}

			$default_order = 'ASC';
			if(isset($other_config['default_order']) && $other_config['default_order'] !='')
			{
				$default_order = $other_config['default_order'];
			}

			if(isset($other_config['filed_notdisp']) && $other_config['filed_notdisp'] !='')
			{
				foreach($other_config['filed_notdisp'] as $filed_notdisp)
				$this->filed_notdisp[] = $filed_notdisp;
			}

			$parameter = array('default_sort'=>$sort_column,'default_order'=>$default_order);
			// set default sort coloumn name
			// set default group by coloumn name
			$this->rander_dataTable($page,$parameter);

			if($is_ajax == 0)
			{
				$this->label_col = 3;	 // for pop up
				$model_body = '';
				if($addPopup == 1)
				{
					$other_config['mode'] = 'add';
					$other_config['id'] = '';
					$model_body = $this->generate_form_main($ele_array,$other_config);
					//$model_body = $this->add_data_common($ele_array); // for pop up
				}
				$this->__load_footer($model_body);
			}
			else
			{
				if($this->js_extra_code !='')
				{
					$data['data_javascript'] = $this->js_extra_code;
					$this->load->view('common_file_echo',$data);
				}
			}
		}
	}
	public function return_tocken_clear($clear_session='',$return='yes')
	{
		if($clear_session !=''){
			$this->session->unset_userdata($clear_session);
			if($this->session->userdata('visit_link_date_wise_search')!=''){
				$this->session->unset_userdata('visit_link_date_wise_search');
			}
		}
		if($return == 'yes'){
			$data_return = array();
			$data_return['status'] = 'success';
			$data_return['tocken'] = $this->security->get_csrf_hash();
			$data['data'] =  json_encode($data_return);
			$this->load->view('common_file_echo',$data);
		}
	}
	function xss_clean($val='')
	{
		if($val !='')
		{
			$val = trim($this->security->xss_clean($val));
		}
		return $val;
	}
	function update_plan_member($js_id='',$plan_id='')
	{
		$return_resp = 'fail';
		if($plan_id !='' && $js_id !='')
		{
			$user_data = $this->common_model->get_count_data_manual('register',array('id'=>$js_id),1,' matri_id, email, username, address, franchised_by ');
			$plan_data = $this->common_model->get_count_data_manual('membership_plan',array('id'=>$plan_id),1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0 && isset($user_data) && $user_data !='' && count($user_data) > 0 )
			{
				$matri_id = $user_data['matri_id'];
				$email = $user_data['email'];
				$name = $user_data['username'];
				$address = $user_data['address'];
				$franchised_by = $user_data['franchised_by'];
				$franchise_comm_per = 0;
				$franchise_comm_amt = 0;
				$franchise_id = 0;
				if($franchised_by !='' && $franchised_by != 0 && $franchised_by != NULL)
				{
					$franchise_data = $this->common_model->get_count_data_manual('franchise',array('id'=>$franchised_by),1,' email, commission ');
					if(isset($franchise_data) && $franchise_data !='' && count($franchise_data) > 0)
					{
						if(isset($franchise_data['commission']) && $franchise_data['commission'] !='')
						{
							$franchise_comm_per = $franchise_data['commission'];
						}
						$franchise_id = $franchised_by;
					}
				}
				// update old plan to current plan no
					$data_array = array('current_plan'=>'No');
					$where_arra = array('matri_id'=>$matri_id,'current_plan'=>'Yes');
					$this->update_insert_data_common('payments',$data_array,$where_arra,1,0);
				// update old plan to current plan no
				$config_data = $this->data['config_data'];
				// $this->get_site_config();
				$service_tax_per = 0;
				$service_tax=0;
				$tax_name = '';
				$plan_amount = 0;
				$final_amount = 0;
				$plan_duration = 0;
				$coupan_code = '';
				$discount_amount = 0;
				$activated_on = $this->getCurrentDate('Y-m-d');
				$expired_on = $activated_on;
				$transaction_id ='';
				$payment_method ='';
				$payment_note = '';
				if(isset($_REQUEST['coupan_code']) && $_REQUEST['coupan_code'] !='')
				{
					$coupan_code = $this->xss_clean($_REQUEST['coupan_code']);
				}
				if(isset($_REQUEST['discount_amount']) && $_REQUEST['discount_amount'] !='')
				{
					$discount_amount = $this->xss_clean($_REQUEST['discount_amount']);
				}
				$coupan_data = $this->session->userdata('coupan_data_reddem');
				if(isset($coupan_data) && $coupan_data !='' && count($coupan_data) > 0 && $coupan_code=='')
				{
					if(isset($coupan_data['discount_amount']) && $coupan_data['discount_amount'] !='')
					{
						$discount_amount = $coupan_data['discount_amount'];
					}
					if(isset($coupan_data['coupan_code']) && $coupan_data['coupan_code'] !='')
					{
						$coupan_code = $coupan_data['coupan_code'];
					}
				}
				if(isset($_REQUEST['transaction_id']) && $_REQUEST['transaction_id'] !='')
				{
					$transaction_id = $this->xss_clean($_REQUEST['transaction_id']);
				}
				if(isset($_REQUEST['payment_method']) && $_REQUEST['payment_method'] !='')
				{
					$payment_method = $this->xss_clean($_REQUEST['payment_method']);
				}
				if(isset($_REQUEST['payment_note']) && $_REQUEST['payment_note'] !='')
				{
					$payment_note = $this->xss_clean($_REQUEST['payment_note']);
				}
				if(isset($plan_data['plan_duration']) && $plan_data['plan_duration'] !='')
				{
					$plan_duration = $plan_data['plan_duration'];
				}
				if(isset($plan_duration) && $plan_duration !='' && $activated_on !='')
				{
					$date_exp = strtotime(date("Y-m-d", strtotime($activated_on)) . + $plan_duration." day");
					$expired_on = date('Y-m-d', $date_exp);
				}
				if(isset($plan_data['plan_amount']) && $plan_data['plan_amount'] !='')
				{
					$plan_amount = $plan_data['plan_amount'];
				}
				if(isset($config_data['service_tax']) && $config_data['service_tax'] !='' && isset($config_data['tax_applicable']) && $config_data['tax_applicable'] =='Yes')
				{
					$service_tax_per = $config_data['service_tax'];
				}
				if(isset($config_data['tax_name']) && $config_data['tax_name'] !='' && isset($config_data['tax_applicable']) && $config_data['tax_applicable'] =='Yes')
				{
					$tax_name = $config_data['tax_name'];
				}
				if(isset($plan_data['offer_per']) && $plan_data['offer_per']>0){
					$plan_amount = $plan_amount - (($plan_amount * $plan_data['offer_per'])/100);
				}
				if($discount_amount !='' && $discount_amount > 0)
				{
					$plan_amount = $plan_amount - $discount_amount;
				}
				$final_amount = $plan_amount;
				if(isset($plan_amount) && $plan_amount !='' && isset($service_tax_per) && $service_tax_per !='')
				{
					$service_tax = ($plan_amount * $service_tax_per)/100;
					$final_amount = $plan_amount + $service_tax;
				}
				// commission calculation for franchise
					if(isset($franchise_comm_per) && $franchise_comm_per != 0 && $plan_amount !='' && $plan_amount > 0)
					{
						$franchise_comm_amt = ($plan_amount * $franchise_comm_per) / 100;
					}
				// commission calculation for franchise
				$pland_data_arr = array(
					'matri_id'=>$matri_id,
					'name'=>$name,
					'current_plan'=>'Yes',
					'email'=>$email,
					'address'=>$address,
					'category_type'=>($plan_data['category_type']!=0)?$this->valueFromId('membership_plan_category',$plan_data['category_type'],'category_name'):'',
					'plan_name'=>$plan_data['plan_name'],
					'currency'=>$plan_data['plan_amount_type'],
					'plan_amount'=>$plan_data['plan_amount'],
					'offer_per'=>$plan_data['offer_per'],
					'plan_duration'=>$plan_data['plan_duration'],
					'message'=>$plan_data['plan_msg'],
					'message_used'=> 0,
					'contacts'=>$plan_data['plan_contacts'],
					'contacts_used'=> 0,
					'profile'=>$plan_data['profile'],
					'profile_used'=> 0,
					'chat'=>$plan_data['chat'],
					'franchise_comm_per'=>$franchise_comm_per,
					'franchise_comm_amt'=>$franchise_comm_amt,
					'franchise_id'=>$franchise_id,
					'tax_name'=>$tax_name,
					'tax_percentage'=>$service_tax_per,
					'tax_amount'=>$service_tax,
					'discount_detail'=>$coupan_code,
					'discount_amount'=>$discount_amount,
					'grand_total'=>$final_amount,
					'plan_activated'=>$activated_on,
					'plan_expired'=>$expired_on,
					'payment_mode'=>$payment_method,
					'transaction_id'=>$transaction_id,
					'bank_detail'=>$payment_note
				);
				$this->update_insert_data_common('payments',$pland_data_arr,'',0,0);
				$data_array = array('status'=>'APPROVED','plan_id'=>$plan_data['id'],'plan_name'=>$plan_data['plan_name'],'plan_status'=>'Paid','plan_expired_on'=>$expired_on);
				$where_arra = array('id'=>$js_id);
				$this->update_insert_data_common('register',$data_array,$where_arra,1,1);
				$return_resp = 'success';

				$config_arra = $this->common_model->get_site_config();
				$web_name = $config_arra['web_name'];
				$webfriendlyname = $config_arra['web_frienly_name'];
				$facebook_link = $config_arra['facebook_link'];
				$twitter_link = $config_arra['twitter_link'];
				$google_link = $config_arra['google_link'];
				$linkedin_link = $config_arra['linkedin_link'];
				$footer_text = $config_arra['footer_text'];
				$contact_no = $config_arra['contact_no'];
				$from_email = $config_arra['from_email'];
				$android_app_link = $config_arra['android_app_link'];
				$template_image_url = $web_name.'assets/email_template';
				$login = $web_name.'login';
				$contact_us = $web_name.'contact';
				$part_basic_detail = $web_name.'my-profile/edit-profile/part-basic-detail';

				$email_temp_data = $this->common_front_model->getemailtemplate('Payment Received');

				$admin_payment = $this->session->userdata('admin_payment');
				if(isset($admin_payment) && $admin_payment == 'admin_payment'){
					$email_temp_data = $this->common_front_model->getemailtemplate('Paid Member');
				}

				$email_content = $email_temp_data['email_content'];
				$email_subject = $email_temp_data['email_subject'];

				$member_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$js_id),1,'*');

				if(isset($member_data) && $member_data != '')
				{
					$username = $member_data['username'];
					$matri_id = $member_data['matri_id'];
					$email = $member_data['email'];
					$web_device_id = $member_data['web_device_id'];
					$android_device_id=$member_data['android_device_id'];
					$ios_device_id = $member_data['ios_device_id'];
					$memid = $member_data['id'];
					$data_array = array('matri_id'=>$matri_id,'username'=>$username,'webfriendlyname'=>$webfriendlyname,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"google_link"=>$google_link,"linkedin_link"=>$linkedin_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"contact_no"=>$contact_no,"from_email"=>$from_email,"contact_us"=>$contact_us,"android_app_link"=>$android_app_link,"part_basic_detail"=>$part_basic_detail,"login"=>$login);

					$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);

					if(isset($admin_payment) && $admin_payment == 'admin_payment'){
						$se_id = "Admin";
					}else{
						$se_id = "User";
					}
					$plan_msg='Your payment has been received successfully';

					if(isset($web_device_id) && $web_device_id!= ''){
						$data_array = array(
							'device_id'=>$web_device_id,
							'sender_id' => $se_id,
							'receiver_id' => $memid,
							'notification_type' => 'payment_received',
							'title' => 'Payment Received',
							'message' => $plan_msg,
							'click_action'=>base_url().'premium-member/current-plan',
						);
						$this->common_model->new_send_notification_web($data_array);
					}
					if(isset($ios_device_id) && $ios_device_id!=''){
						$sender_receiver = array('sender'=>$se_id,'receiver'=>$memid,'app_type'=>'IOS');
						$this->common_model->new_send_notification_android($ios_device_id,$plan_msg,'Payment Received','payment_received',$memid,'','',$sender_receiver);
					}
					if(isset($android_device_id) && $android_device_id!=''){
						$sender_receiver = array('sender'=>$se_id,'receiver'=>$memid,'app_type'=>'Android');
						$this->common_model->new_send_notification_android($android_device_id,$plan_msg,'Payment Received','payment_received',$memid,'','',$sender_receiver);
					}

					$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);

					if(isset($email) && $email!= ''){
						$this->common_model->common_send_email($email,$email_subject,$email_content);
					}

					if(isset($member_data['mobile']) && $member_data['mobile'] != '')
					{
						$mobile = $member_data['mobile'];
						$get_sms_temp = $this->common_front_model->get_sms_template('Paid Activated');
						$template_id =$get_sms_temp['template_id'];
						if(isset($get_sms_temp) && $get_sms_temp!='')
						{
							$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
							$trans = array("web_frienly_name"=>$webfriendlyname);

							$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);

							$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
						}
					}
				}
			}
		}
		return $return_resp;
	}

	function arraytojsontocken($getList='')
	{
		$temp_array = array();
		$key_array = array();
		if($getList !='')
		{
			$data_array = $this->common_front_model->get_list($getList,'','','array','',0);
			foreach($data_array as $val)
			{
				if($val['id'] !='' && $val['id'] != 0)
				{
					$temp_array[] = array('value'=>$val['id'],'lable'=>$val['val']);
					$key_array[] = $val['id'];
				}
			}
			//value
		}
		$temp_return = array('key_array'=>implode("','",$key_array),'tocken_array'=>json_encode($temp_array));
		return $temp_return;
	}
	function valueFromId($table_name='',$arry_id='',$clm_value='',$id_clm='id',$return_type = 'str',$delimetor=',')
	{
		$return_arr ='';
		if($table_name !='' && $arry_id !='' && $clm_value !='' && $id_clm !='')
		{
			if(!is_array($arry_id))
			{
				$arry_id = explode($delimetor,$arry_id);
			}
			$this->db->where_in($id_clm,$arry_id);
			$data_arr = $this->get_count_data_manual($table_name,'',2,$clm_value);
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				$temp_arr = array();
				foreach($data_arr as $data_arr_val)
				{
					$temp_arr[] = $data_arr_val[$clm_value];
				}
				if($return_type =='str')
				{
					$return_arr = implode(', ',$temp_arr);
				}
				else
				{
					$return_arr = $temp_arr;
				}
			}
		}
		return $return_arr;
	}

	function update_plan_member_call()
	{
		$plan_id = '';
		$payment_note = '';
		$user_id = '';
		$user_type = '';
		if(isset($_REQUEST['plan_id']) && $_REQUEST['plan_id'] !='')
		{
			$plan_id = $this->xss_clean($_REQUEST['plan_id']);
		}
		if(isset($_REQUEST['payment_note']) && $_REQUEST['payment_note'] !='')
		{
			$payment_note = $this->xss_clean($_REQUEST['payment_note']);
		}
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !='')
		{
			$user_id = $this->xss_clean($_REQUEST['user_id']);
		}
		$data_return = array();
		$data_return['tocken'] = $this->security->get_csrf_hash();
		$data_return['status'] = 'error';
		$data_return['message'] = 'Some error issue ocurred, Please try again.';

		if($plan_id !='' && $user_id !='')
		{

			$retuen_respo = $this->update_plan_member($user_id,$plan_id);
			if(isset($retuen_respo) && $retuen_respo == 'success')
			{
				$data_return['status'] = 'success';
				$data_return['message'] = 'Plan Assigned successfully.';
			}
		}
		return $data_return;
	}
	public function get_user_id($field)
	{
		$session_name = $this->get_session_data($field);
		if(isset($_REQUEST["user_agent"]) && $_REQUEST["user_agent"]!='' && $_REQUEST["user_agent"]!='NI-WEB')
		{
			$user_id = '';
			if($field =='user_id' || $field =='id')
			{
				if(isset($_REQUEST["user_id"]) && $_REQUEST["user_id"] !='')
				{
					$user_id = $_REQUEST["user_id"];
				}
				else if(isset($_REQUEST["id"]) && $_REQUEST["id"] !='')
				{
					$user_id = $_REQUEST["id"];
				}
			}
			else
			{
				if(isset($_REQUEST[$field]) && $_REQUEST[$field] !='')
				{
					$user_id = $_REQUEST[$field];
				}
			}
		}
		else
		{
			$data_return = $matrimonial_user_data = $this->session->userdata($session_name);
			if(isset($data_return[$field]))
			{
				$user_id = $data_return[$field];
			}
			else
			{
				$user_id = '';
			}
		}
		return $user_id;
	}
	function get_plan_detail($user_id='',$user_type='',$return_filed='')
	{
		$return_data = 'No';
		if($user_id !='' && ($user_type =='job_seeker' || $user_type =='employer'))
		{
			$table_name = 'plan_jobseeker';
			$where_data = array('js_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			if($user_type =='employer')
			{
				$table_name = 'plan_employer';
				$where_data = array('emp_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			}
			$today_date = $this->getCurrentDate('Y-m-d');
			$where_data[] = " expired_on >= '$today_date' ";
			$plan_data = $this->common_model->get_count_data_manual($table_name,$where_data,1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
			{
				if($return_filed !='' && isset($plan_data[$return_filed]) && $plan_data[$return_filed] !='')
				{
					$return_data = $plan_data[$return_filed];
					if($return_data !='Yes' && $return_data !='No')
					{
						if($plan_data[$return_filed] > $plan_data[$return_filed.'_used'])
						{
							$return_data = 'Yes';
						}
					}
					$plan_data[$return_filed];
				}
				else
				{
					$return_data = $plan_data;
				}
			}
		}
		return $return_data;
	}
	function update_plan_detail($user_id='',$user_type='',$return_filed='')
	{
		if($user_id !='' && ($user_type =='job_seeker' || $user_type =='employer'))
		{
			$table_name = 'plan_jobseeker';
			$where_data = array('js_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			if($user_type =='employer')
			{
				$table_name = 'plan_employer';
				$where_data = array('emp_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			}
			$column_updated = $return_filed.'_used';
			$data_array = array('is_deleted'=>'No');
			$this->db->set($column_updated , " $column_updated + 1", FALSE);
			$this->update_insert_data_common($table_name,$data_array,$where_data,1,1);
		}
	}
	public function check_duplicate()
	{
		$id = '';
		$mode = '';
		$field_value = '';
		$field_name = '';
		$check_on = '';
		if(isset($_REQUEST['id']) && $_REQUEST['id'] !='')
		{
			$id = $this->xss_clean($_REQUEST['id']);
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='')
		{
			$mode = $this->xss_clean($_REQUEST['mode']);
		}
		if(isset($_REQUEST['field_value']) && $_REQUEST['field_value'] !='')
		{
			$field_value = $this->xss_clean($_REQUEST['field_value']);
		}
		if(isset($_REQUEST['field_name']) && $_REQUEST['field_name'] !='')
		{
			$field_name = $this->xss_clean($_REQUEST['field_name']);
		}
		if(isset($_REQUEST['check_on']) && $_REQUEST['check_on'] !='')
		{
			$check_on = $this->xss_clean($_REQUEST['check_on']);
		}
		if($check_on !='' && $field_name !='' && $field_value !='' && $mode !='')
		{
			$where_data = array();
			$array_table_field = $this->db->list_fields($check_on);
			if(in_array('is_deleted',$array_table_field))
			{
				$where_data = array('is_deleted'=>'No');
			}
			if($mode =='edit' && $id != '' )
			{
				$where_data[] = " id != '".$id."' ";
			}
			if($field_value !='')
			{
				$where_data[$field_name] = $field_value;
			}
			$count_duplicate = $this->common_model->get_count_data_manual($check_on,$where_data,0,'id');
			if(isset($count_duplicate) && $count_duplicate > 0)
			{
				return 'success';
			}
		}
		return 'error';
	}
	public function common_view_detail($title='',$data='')
	{
		$this->data = $this->common_model->data;
		if(isset($data) && $data !='' && count($data) > 0 )
		{
			foreach($data as $key=>$data_val)
			{
				$this->data[$key] = $data_val;
			}
		}
		$this->common_model->__load_header($title);
		$this->load->view('back_end/view_detail',$this->data);
		$this->common_model->__load_footer('');
	}
	function getstringreplaced($actula_content,$array=array())
	{
		$email_template = strtr($actula_content, $array);
		return $email_template;
	}
	function trim_array_remove($arr ='')
	{
		$arr_temp = array();
		if($arr !='' && !is_array($arr))
		{
			$arr= explode(',',$arr);
		}
		if(isset($arr) && $arr !='' && is_array($arr) && count($arr) > 0)
		{
			$arr = array_map('trim', $arr);
			foreach($arr as $arr_val)
			{
				if($arr_val !='')
				{
					$arr_temp[] = $arr_val;
				}
			}
		}
		return $arr_temp;
	}
	function trim_strin_remove($arr ='')
	{
		$str_temp = '';
		$arr_temp = $this->trim_array_remove($arr);
		if(isset($arr_temp) && count($arr_temp) > 0)
		{
			$str_temp = implode("','",$arr_temp);
			$str_temp = "'".$str_temp."'";
		}
		return $str_temp;
	}
	function dropdown_array_table($list_type= '')
	{
		$drop_down_arr ='';
		if($list_type =='mothertongue' || $list_type =='mother_tongue' || $list_type =='part_mother_tongue' || $list_type =='languages_known')
		{
			$drop_down_arr = $this->getRelationDropdown(array('relation'=>array('rel_table'=>'mothertongue','key_val'=>'id','key_disp'=>'mtongue_name')));
		}
		else if($list_type =='religion' || $list_type =='part_religion')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'religion','key_val'=>'id','key_disp'=>'religion_name')));
		}
		else if($list_type =='education_detail' || $list_type =='part_education' )
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'education_detail','key_val'=>'id','key_disp'=>'education_name')));
		}
		else if($list_type =='occupation')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'occupation','key_val'=>'id','key_disp'=>'occupation_name')));
		}
		else if($list_type =='designation')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'designation','key_val'=>'id','key_disp'=>'designation_name')));
		}
		else if($list_type =='star')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'star','key_val'=>'id','key_disp'=>'star_name')));
		}
		else if($list_type =='moonsign')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'moonsign','key_val'=>'id','key_disp'=>'moonsign_name')));
		}
		else if($list_type =='annual_income')
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'annual_income','key_val'=>'id','key_disp'=>'annual_income_name')));
		}
		else if($list_type =='country_master' || $list_type =='part_country_living' )
		{
        	$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'country_master','key_val'=>'id','key_disp'=>'country_name')));
		}
		else if($list_type == 'part_caste')
		{
			$drop_down_arr = $this->common_model->getRelationDropdown(array('relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name')));
		}
		return $drop_down_arr;
	}
	public function merge_array_all_ddr($type ='')
	{
		$return_arr = array('All'=>'All');
		if($type !='')
		{
			$arr = $this->member_model->get_list_ddr($type);
			if(isset($arr) && $arr !='' && count($arr) > 0)
			{
				$return_arr = array_merge($return_arr,$arr);
			}
		}
		return $return_arr;
	}

	// for sending email
	function getemailtemplate($tempname = '')
	{
		$tempdata = array();
		if($tempname != '')
		{
			$where_arra = array('template_name'=>$tempname,'status'=>'APPROVED','is_deleted'=>'No');
			$tempdata = $this->get_count_data_manual('email_templates',$where_arra,1,'','','','','');
		}
		return $tempdata;
	}
	function send_email_from_template($template='',$data_array='',$subject='')
	{
		if($template !='' && $data_array !='')
		{
			$template_arr = getemailtemplate($template);
			if($template_arr !='' && count($template_arr) > 0)
			{
				$email_subject ='';
				$email_content ='';
				if(isset($template_arr['email_subject']) && $template_arr['email_subject'] !='')
				{
					$email_subject = $template_arr['email_subject'];
				}
				if(isset($template_arr['email_content']) && $template_arr['email_content'] !='')
				{
					$email_content = $template_arr['email_content'];
				}
				if($subject !='')
				{
					$email_subject = $subject;
				}
				$email = '';
				if(isset($data_array['email']) && $data_array['email'] !='')
				{
					$email = $data_array['email'];
				}
				$email_content = $this->str_replace_array($email_content,$data_array);
				$email_subject = $this->str_replace_array($email_subject,$data_array);
				$this->common_send_email($email,$subject,$email_content);
			}
		}
	}
	function str_replace_array($actula_content,$array=array())
	{
		$email_template = strtr($actula_content, $array);
		$email_template = strtr($actula_content, $this->data['config_data']);
		return $email_template;
	}
	function array_optionstr($array='',$selected_val= '')
	{
		$return_str = '';
		if(isset($array) && $array !='' && !is_array($array))
		{
			$array = $this->get_list_ddr($array);
		}
		if(isset($array) && $array !='' && count($array) > 0)
		{
			foreach($array as $array_key=>$array_val)
			{
				$selected_str= '';
				if($array_key == $selected_val)
				{
					$selected_str= ' selected ';
				}
				$return_str.= '<option '.$selected_str.' value="'.$array_key.'">'.$array_val.'</option>';
			}
		}
		return $return_str;
	}

	function array_optionstr_search($array='',$selected_val= '')
	{
		$return_str = '';
		if(isset($array) && $array !='' && !is_array($array))
		{
			$array = $this->get_list_ddr($array);
		}
		if(isset($array) && $array !='' && count($array) > 0)
		{
			foreach($array as $array_key=>$array_val)
			{
				$selected_str= '';
				if($array_key == $selected_val)
				{
					$selected_str= ' selected ';
				}
				$return_str.= '<option '.$selected_str.' value="'.$array_key.'" title="'.$array_val.'">'.$array_val.'</option>';
			}
		}
		return $return_str;
	}

	function height_list()
	{
		$heigh_arr = array('48'=>'Below 4ft');
		for($i=49;$i<=84;$i++)
		{
			$heigh_arr[$i] = $this->common_model->display_height($i);
		}
		$heigh_arr['85']='Above 7ft';
		return $heigh_arr;
	}

	public function birth_date_picker($birth_date ='')
	{
		$sel_date = 1;
		$sel_month ='01';
		$current_year = $this->common_model->getCurrentDate('Y');
		$last_year = $current_year - 18;
		$to_year = $current_year - 65;
		$sel_year = $last_year;

		if($birth_date !='')
		{
			$sel_year = $this->common_model->displayDate($birth_date,'Y');
			$sel_month = $this->common_model->displayDate($birth_date,'m');
			$sel_date = $this->common_model->displayDate($birth_date,'d');
		}
		$dropdown_code ='<div class="col-md-4  col-sm-4 col-xs-4" style="padding-left:0px"><select  style="width:100%" class="form-control select-cust w-75 select2" name="birth_date" id="birth_date" required>';
		$dropdown_code.='<option value="">Date</option>';
		for ($x1 = 01; $x1 <= 31; $x1++)
		{
			$selected_str ='';
			if($sel_date  == $x1){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$x1.'">'.$x1.'</option>';
		}
		$dropdown_code.='</select></div>';

		$month_array = array('01'=>'Jan','02'=>'Feb','03'=>'March','04'=>'April','05'=>'May','06'=>'Jun','07'=>'July','08'=>'Aug','09'=>'Sept','10'=>'Oct','11'=>'Nov','12'=>'Dec');

		$dropdown_code.='<div class="col-md-4  col-sm-4 col-xs-4"  style="padding:0px" ><select  style="width:100%" class="form-control select2" onchange="month_year_change()" name="birth_month" id="birth_month" required>';
		$dropdown_code.='<option value="">Month</option>';
		foreach($month_array as $key=>$val)
		{
			$selected_str ='';
			if($sel_month  == $key){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$key.'">'.$val.'</option>';
		}
		$dropdown_code.='</select></div>';

		$dropdown_code.='<div class="col-md-4  col-sm-4 col-xs-4" style="padding-right:0px" ><select style="width:100%" class="form-control select2"  onchange="month_year_change()" name="birth_year" id="birth_year" required>';
		$dropdown_code.='<option value="">Year</option>';
		for ($x1 = $last_year; $x1 >= $to_year ; $x1--)
		{
			$selected_str ='';
			if($sel_year == $x1){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$x1.'">'.$x1.'</option>';
		}
		$dropdown_code.='</select></div>';
		return $dropdown_code;
	}

	public function birth_date_pickers($birth_date ='')
	{
		$sel_date = 1;
		$sel_month ='01';
		$current_year = $this->common_model->getCurrentDate('Y');
		$last_year = $current_year - 18;
		$sel_year = $last_year;

		if($birth_date !='')
		{
			$sel_year = $this->common_model->displayDate($birth_date,'Y');
			$sel_month = $this->common_model->displayDate($birth_date,'m');
			$sel_date = $this->common_model->displayDate($birth_date,'d');
		}
		$dropdown_code ='<div class="col-md-4  col-sm-4 col-xs-4" style="padding-left:0px"><select  style="width:100%" class="form-control select2" onchange="setDays(birth_month,this,birth_year)" name="birth_date" id="birth_date" required>';
		$dropdown_code.='<option value="">Date</option>';
		for ($x1 = 01; $x1 <= 31; $x1++)
		{
			$selected_str ='';
			if($sel_date  == $x1){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$x1.'">'.$x1.'</option>';
		}
		$dropdown_code.='</select></div>';

		$month_array = array('01'=>'Jan','02'=>'Feb','03'=>'March','04'=>'April','05'=>'May','06'=>'June','07'=>'July','08'=>'Aug','09'=>'Sept','10'=>'Oct','11'=>'Nov','12'=>'Dec');

		$dropdown_code.='<div class="col-md-4  col-sm-4 col-xs-4"  style="padding:0px" ><select  style="width:100%" class="form-control select2" onchange="setDays(this,birth_date,birth_year)" name="birth_month" id="birth_month" required>';
		$dropdown_code.='<option value="">Month</option>';
		foreach($month_array as $key=>$val)
		{
			$selected_str ='';
			if($sel_month  == $key){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$key.'">'.$val.'</option>';
		}
		$dropdown_code.='</select></div>';

		$dropdown_code.='<div class="col-md-4  col-sm-4 col-xs-4" style="padding-right:0px" ><select style="width:100%" class="form-control select2"  onchange="setDays(birth_month,birth_date,this)" name="birth_year" id="birth_year" required>';
		$dropdown_code.='<option value="">Year</option>';
		for ($x1 = $last_year; $x1 >= 1924 ; $x1--)
		{
			$selected_str ='';
			if($sel_year == $x1){ $selected_str ='selected'; }
			$dropdown_code.='<option '.$selected_str.' value="'.$x1.'">'.$x1.'</option>';
		}
		$dropdown_code.='</select></div>';
		return $dropdown_code;
	}
	public function weight_list()
	{
		$weight_arr = array();
		for($i=40;$i<=140;$i++)
		{
			$weight_arr[$i] = $i.' Kg';
		}
		return $weight_arr;
	}
	public function age_rang()
	{
		$age_arr = array();
		for($i=18;$i<=65;$i++)
		{
			$age_arr[$i] = $i.' Year';
		}
		return $age_arr;
	}
	public function country_code_opt($val='')
	{
		## Default Country Code By Site Config : Date : 29-11-2021
		$config_data = $this->get_site_config();
		if($val == '' && isset($config_data['default_country_code']) && $config_data['default_country_code'] != ''){
			$val = $config_data['default_country_code'];
		}
		$where_country_code = array("is_deleted = 'No' AND country_code !='' GROUP BY country_code,country_name");
		$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");
		$country_code_str = '';
		foreach($country_code_arr as $country_code_arr)
		{
			$select_ed_drp = '';

			if($country_code_arr['country_code'] == $val)
			{
				$select_ed_drp = 'selected';

			}
			$country_code_str.= '<option '.$select_ed_drp.' value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].'</option>';
		}
		return $country_code_str;
	}
	public function get_list_ddr($type='')
	{
		$featured = array('Featured'=>'Featured','Unfeatured'=>'Unfeatured');
		$marital_status= array('Unmarried'=>'Unmarried','Widow/Widower'=>'Widow/Widower','Divorcee'=>'Divorcee','Separated'=>'Separated');
		$diet = array('Occasionally Non-Veg'=>'Occasionally Non-Veg','Veg'=>'Veg','Eggetarian'=>'Eggetarian','Occasionally Non-Veg'=>'Occasionally Non-Veg','Non-Veg'=>'Non-Veg');
		$smoke = array('No'=>'No','Yes'=>'Yes','Occasionally'=>'Occasionally');
		$gender = array('Male'=>'Male','Female'=>'Female');
		$manglik = array('No'=>'No','Yes'=>'Yes','Maybe'=>'Maybe','Anshik'=>'Anshik');
		$drink = array('No'=>'No','Yes'=>'Yes','Occasionally'=>'Occasionally');
		$bodytype = array('Slim'=>'Slim','Average'=>'Average','Athletic'=>'Athletic','Heavy'=>'Heavy');
		$complexion = array('Wheatish'=>'Wheatish','Very Fair'=>'Very Fair','Fair'=>'Fair','Wheatish Brown'=>'Wheatish Brown','Dark'=>'Dark');

		$profileby = array('Self'=>'Self','Parents'=>'Parents','Guardian'=>'Guardian','Friends'=>'Friends','Sibling'=>'Sibling','Relatives'=>'Relatives');
		$reference = array('Advertisements'=>'Advertisements','Friends'=>'Friends','Search Engines'=>'Search Engines','Others'=>'Others');
		$blood_group = array('A+'=>'A+','A-'=>'A-','AB+'=>'AB+','AB-'=>'AB-','B+'=>'B+','B-'=>'B-','O+'=>'O+','O-'=>'O-');
		$star = array('ANUSHAM'=>'ANUSHAM','ASWINI'=>'ASWINI','AVITTAM'=>'AVITTAM','AYILYAM'=>'AYILYAM','BHARANI'=>'BHARANI','CHITHIRAI'=>'CHITHIRAI','HASTHAM'=>'HASTHAM','KETTAI'=>'KETTAI','KRITHIGAI'=>'KRITHIGAI','MAHAM'=>'MAHAM','MOOLAM'=>'MOOLAM','MRIGASIRISHAM'=>'MRIGASIRISHAM','POOSAM'=>'POOSAM','PUNARPUSAM'=>'PUNARPUSAM','PURADAM'=>'PURADAM','PURAM'=>'PURAM','PURATATHI'=>'PURATATHI','REVATHI'=>'REVATHI','ROHINI'=>'ROHINI','SADAYAM'=>'SADAYAM','SWATHI'=>'SWATHI','THIRUVADIRAI'=>'THIRUVADIRAI','THIRUVONAM'=>'THIRUVONAM','UTHRADAM'=>'UTHRADAM','UTHRAM'=>'UTHRAM','UTHRATADHI'=>'UTHRATADHI','VISAKAM'=>'VISAKAM');
		$horoscope = array('No'=>'No','Yes'=>'Yes','Do not know'=>'Do not know');
		$manglik = array('No'=>'No','Yes'=>'Yes','Maybe'=>'Maybe','Anshik'=>'Anshik','Do not know'=>'Do not know');
		$moonsign = array('Mesh (Aries)'=>'Mesh (Aries)','Vrishabh (Taurus)'=>'Vrishabh (Taurus)','Mithun (Gemini)'=>'Mithun (Gemini)','Karka (Cancer)'=>'Karka (Cancer)','Simha (Leo)'=>'Simha (Leo)','Kanya (Virgo)'=>'Kanya (Virgo)','Tula (Libra)'=>'Tula (Libra)','Vrischika (Scorpio)'=>'Vrischika (Scorpio)','Dhanu (Sagittarious)'=>'Dhanu (Sagittarious)','Makar (Capricorn)'=>'Makar (Capricorn)','Kumbha (Aquarious)'=>'Kumbha (Aquarious)','Meen (Pisces)'=>'Meen (Pisces)');
		$residence = array('Citizen'=>'Citizen','Permanent Resident'=>'Permanent Resident','Student Visa'=>'Student Visa','Temporary Visa'=>'Temporary Visa','Work permit'=>'Work permit');
		$employee_in = array('Private'=>'Private','Government'=>'Government','Business'=>'Business','Defence'=>'Defence','Not Employed in'=>'Not Employed in','Others'=>'Others');
		// $income = array('Rs 10,000 - 50,000'=>'Rs 10,000 - 50,000','Rs 50,000 - 1,00,000'=>'Rs 50,000 - 1,00,000','Rs 1,00,000 - 2,00,000'=>'Rs 1,00,000 - 2,00,000','Rs 2,00,000 - 5,00,000'=>'Rs 2,00,000 - 5,00,000','Rs 5,00,000 - 10,00,000'=>'Rs 5,00,000 - 10,00,000','Rs 10,00,000 - 50,00,000'=>'Rs 10,00,000 - 50,00,000','Rs 50,00,000 - 1,00,00,000'=>'Rs 50,00,000 - 1,00,00,000','Above Rs 1,00,00,000'=>'Above Rs 1,00,00,000','Does not matter'=>'Does not matter');
		// $income = array('Rs 10000 - 50000'=>'Rs 10000 - 50000','Rs 50000 - 100000'=>'Rs 50000 - 100000','Rs 100000 - 200000'=>'Rs 100000 - 200000','Rs 200000 - 500000'=>'Rs 200000 - 500000','Rs 500000 - 1000000'=>'Rs 500000 - 1000000','Rs 1000000 - 5000000'=>'Rs 1000000 - 5000000','Rs 5000000 - 10000000'=>'Rs 5000000 - 10000000','Above Rs 10000000'=>'Above Rs 10000000','Does not matter'=>'Does not matter');
		$family_type = array('Separate Family'=>'Separate Family','Joint Family'=>'Joint Family');
		$family_status = array('Rich'=>'Rich','Upper Middle Class'=>'Upper Middle Class','Middle Class'=>'Middle Class','Lower Middle Class'=>'Lower Middle Class','Poor Family'=>'Poor Family');
		$no_of_brothers = array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','4 +'=>'4 +');
		$no_marri_brother = array('No married brother'=>'No married brother','One married brother'=>'One married brother','Two married brothers'=>'Two married brothers','Three married brothers'=>'Three married brothers','Four married brothers'=>'Four married brothers','Above four married brothers'=>'Above four married brothers');
		$no_marri_sister = array('No married sister'=>'No married sister','One married sister'=>'One married sister','Two married sisters'=>'Two married sisters','Three married sisters'=>'Three married sisters','Four married sisters'=>'Four married sisters','Above four married sisters'=>'Above four married sisters');
		//for dashboard slider use
		$no_of_sisters = array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','4 +'=>'4 +');
		$no_of_married_brother = array('No married brother'=>'No married brother','One married brother'=>'One married brother','Two married brothers'=>'Two married brothers','Three married brothers'=>'Three married brothers','Four married brothers'=>'Four married brothers','Above four married brothers'=>'Above four married brothers');
		$no_of_married_sister = array('No married sister'=>'No married sister','One married sister'=>'One married sister','Two married sisters'=>'Two married sisters','Three married sisters'=>'Three married sisters','Four married sisters'=>'Four married sisters','Above four married sisters'=>'Above four married sisters');
		//for dashboard slider use
		$smoke = array('No'=>'No','Yes'=>'Yes','Occasionally'=>'Occasionally');
		$payment_method = array('Cash'=>'Cash','Credit Card'=>'Credit Card','Debit Card'=>'Debit Card','Other'=>'Other','Cheque'=>'Cheque');
		$mobile_verify_status = array('No'=>'No','Yes'=>'Yes');
		$plan_status = array('Active'=>'Active','Expired'=>'Expired');

		$plan_expired_on = array('today_expire'=>'Today expire','in_week_expire'=>'In 1 week expire','in_month_expire'=>'In 1 month expire');
		$registered_from = array('Mobile App'=>'Mobile App','Front End'=>'Front End','Back end'=>'Back End','Other'=>'Other');
		$photo_setting = array('With Photo'=>'With Photo','Without Photo'=>'Without Photo');

		$total_children = array('0'=>'None','One'=>'One','Two'=>'Two','Three'=>'Three','Four and above'=>'Four and above');
		$status_children = array('Living with me'=>'Living with me','Not living with me'=>'Not living with me');
		$sent_interest = array('all_sent'=>'All Sent Interest','accept_sent'=>'Interest Sent Accept','reject_sent'=>'Interest Sent Reject','pending_sent'=>'Interest Sent Pending');
		$received_interest = array('all_receive'=>'All Received Interest','accept_receive'=>'Interest Received Accept','reject_receive'=>'Interest Received Reject','pending_receive'=>'Interest Received Pending');

		if(isset($$type))
		{
			return $$type;
		}
		else
		{
			return '';
		}
	}
	function get_data_fromArray($date_arr='',$filed_check='')
	{
		$return_data = '';
		if($date_arr !='' && $filed_check !='')
		{
			if(isset($date_arr[$filed_check]) && $date_arr[$filed_check] !='')
			{
				$return_data = $date_arr[$filed_check];
			}
		}
		return $return_data;
	}
	function display_data_na($data_disp ='')
	{
		if(isset($data_disp) && $data_disp !='')
		{
			return $data_disp;
		}
		return $this->data_not_availabel;
	}
	function member_photo_disp($member_arr = '',$photo_view_count=0)
	{
		$return_photo = '';
		$return_photo_male = $this->base_url.'assets/front_end/img/default-photo/male.png';
		$return_photo_female = $this->base_url.'assets/front_end/img/default-photo/female.png';
		$gender = 'Male';
		$new_curre_data = $this->common_front_model->get_session_data();
		if(isset($member_arr['photo1']) && $member_arr['photo1'] !='')
		{
			$photo1 = $member_arr['photo1'];
			if(file_exists($this->path_photos.$photo1) && $member_arr['photo1_approve'] =='APPROVED' && isset($member_arr['photo_view_status']) && $member_arr['photo_view_status'] == '2')
			{
				if(isset($new_curre_data) && $new_curre_data!='' && count($new_curre_data)>0){
					if($new_curre_data["plan_status"]=='Paid'){
						$return_photo = $this->base_url.$this->path_photos.$photo1;
					}else{
						if(isset($member_arr['gender']) && $member_arr['gender'] =='Female' &&  $return_photo =='')
						{
							$return_photo = $return_photo_female;
						}
						else if($return_photo == '')
						{
							$return_photo = $return_photo_male;
						}
					}
				}else{
					if(isset($member_arr['gender']) && $member_arr['gender'] =='Female' &&  $return_photo =='')
					{
						$return_photo = $return_photo_female;
					}
					else if($return_photo == '')
					{
						$return_photo = $return_photo_male;
					}
				}
			}
			elseif(file_exists($this->path_photos.$photo1) && $member_arr['photo1_approve'] =='APPROVED' && isset($member_arr['photo_view_status']) && $member_arr['photo_view_status'] == '1')
			{
				$return_photo = $this->base_url.$this->path_photos.$photo1;
			}
			elseif(file_exists($this->path_photos.$photo1) && $member_arr['photo1_approve'] =='APPROVED' && isset($member_arr['photo_view_status']) && $member_arr['photo_view_status'] == '0' && $photo_view_count>0)
			{
				$return_photo = $this->base_url.$this->path_photos.$photo1;
			}
			else
			{
				if(isset($member_arr['gender']) && $member_arr['gender'] =='Female' &&  $return_photo =='')
				{
					$return_photo = $return_photo_female;
				}
				else if($return_photo == '')
				{
					$return_photo = $return_photo_male;
				}
			}
		}
		else
		{
			if(isset($member_arr['gender']) && $member_arr['gender'] =='Female' &&  $return_photo =='')
			{
				$return_photo = $return_photo_female;
			}
			else if($return_photo == '')
			{
				$return_photo = $return_photo_male;
			}
		}
		return $return_photo;
	}

	public function base_64_photo($post_name='',$dir_name='',$photo_name='')
	{
	    if($post_name != '' && $dir_name !='' && $photo_name !='')
	    {
            if(isset($_REQUEST[$post_name]) && $_REQUEST[$post_name] !='')
            {
				$photo_base_64 = $_REQUEST[$post_name];
                $photo_base_64 = str_replace('data:image/jpeg;base64,', '', $photo_base_64);
				$photo_base_64 = str_replace('data:image/png;base64,', '', $photo_base_64);
                $photo_base_64 = str_replace(' ', '+', $photo_base_64);
                $data = base64_decode($photo_base_64);
                $path_folder = $this->$dir_name;
                $path_folder.$photo_name;
                $success = file_put_contents($path_folder.$photo_name, $data);
            }
        }
	}
	public function resize_photo_big($photo_array= array())
	{
		$path_photos_big = $this->common_model->path_photos_big;
		$path_photos = $this->common_model->path_photos;
		if(isset($photo_array) && $photo_array !='' && count($photo_array) > 0 )
		{
			foreach($photo_array as $key=>$val)
			{
				if($val !='' && file_exists($path_photos_big.$val))
				{
					$this->resize_image('path_photos_big',$val);
				}
			}
			foreach($photo_array as $key=>$val)
			{
				if($val !='' && file_exists($path_photos.$val))
				{
					$this->resize_image('path_photos',$val,240,320);
				}
			}
		}
	}
	public function resize_image($path_folder='',$file_name='',$width=1024,$height= '768')
	{
		if(in_array($path_folder,array('assets/photos/')))
		{
			$width  = 240;
			$height = 320;
		}
		else if($path_folder == 'assets/banner/' || $path_folder == 'assets/events-list/')
		{
			$width  = 1349;
			$height = '758';
		}

		if($path_folder!= '' && $file_name !='' && file_exists($path_folder.$file_name))
		{
			$allow_resize = 0;
        	$file_info = @getimagesize($path_folder.$file_name);
			if(isset($file_info) && $file_info !='' && count($file_info) > 0)
			{
				if(isset($file_info[0]) && $file_info[0] !='' && $file_info[0] > $width)
				{
					$allow_resize = 1;
				}
				if(isset($file_info[1]) && $file_info[1] !='' && $file_info[1] > $height)
				{
					$allow_resize = 1;
				}
			}
			if($allow_resize == 1)
			{
				$config['image_library'] = 'gd2';
				$config['source_image']  = $path_folder.$file_name;
				$config['create_thumb']  = FALSE;
				$config['maintain_ratio']= TRUE;
				$config['width']         = $width;
				$config['height']        = $height;
				$this->load->library('image_lib', $config);
				$this->image_lib->initialize($config);
				if (!$this->image_lib->resize())
				{
					$this->image_lib->display_errors();
				}
				else
				{
					//echo 'Success';
				}
			}
		}
	}

	public function encrypt_id($id='')
	{
		if($id !='')
		{
			$id = base64_encode($id);
		}
		return $id;
	}

	public function descrypt_id($id='')
	{
		if($id !='')
		{
			$id = base64_decode($id);
		}
		return $id;
	}

	//////////////////////////////////////////////////////////////////\

	public function send_mail_to_member($status_update='',$selected_val='',$column_name = '')
	{
		if(isset($status_update) && $status_update != '' && isset($selected_val) && $selected_val != '')
		{
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
			$webfriendlyname = $config_arra['web_frienly_name'];
			$facebook_link = $config_arra['facebook_link'];
			$twitter_link = $config_arra['twitter_link'];
			$google_link = $config_arra['google_link'];
			$linkedin_link = $config_arra['linkedin_link'];
			$footer_text = $config_arra['footer_text'];
			$contact_no = $config_arra['contact_no'];
			$from_email = $config_arra['from_email'];
			$android_app_link = $config_arra['android_app_link'];
			$template_image_url = $web_name.'assets/email_template';
			$login = $web_name.'login';
			$contact_us = $web_name.'contact';
			$part_basic_detail = $web_name.'my-profile/edit-profile/part-basic-detail';

			$selected_val_arr = $selected_val;
			if(!is_array($selected_val))
			{
				$selected_val_arr = explode(",",$selected_val);
			}
			if(isset($selected_val_arr) && $selected_val_arr!= '')
			{
				if($column_name =='')
				{
					$column_name = 'id';
				}
				foreach($selected_val_arr as $selected_val)
				{
					if(isset($status_update) && $status_update == 'APPROVED'){
						$email_temp_data = $this->common_front_model->getemailtemplate('Active Member');
					}elseif(isset($status_update) && $status_update == 'DELETE'){
						$email_temp_data = $this->common_front_model->getemailtemplate('Delete Member');
					}elseif(isset($status_update) && $status_update == 'Suspended'){
						$email_temp_data = $this->common_front_model->getemailtemplate('Suspend Member');
					}

					if(isset($email_temp_data) && $email_temp_data!= '')
					{
						$email_content = $email_temp_data['email_content'];
						$email_subject = $email_temp_data['email_subject'];

						$member_data = $this->common_model->get_count_data_manual('register_view',array($column_name=>$selected_val),1,'id,matri_id,email,username,mobile');

						if(isset($member_data) && $member_data != '')
						{
							$username = $member_data['username'];
							$matri_id = $member_data['matri_id'];
							$email = $member_data['email'];

							$member_data_html='';
							if(isset($status_update) && $status_update == 'APPROVED')
							{
								$matching_result = $this->get_matching_result($selected_val);

								if(isset($matching_result) && $matching_result!= '')
								{
									foreach($matching_result as $rec_detail)
									{
										$path_photos = $this->common_model->path_photos;
										if(isset($rec_detail['photo1']) && $rec_detail['photo1']!='' && $rec_detail['photo1_approve']=='APPROVED' && file_exists($path_photos.$rec_detail['photo1']))
										{
											$defult_photo = $web_name.$path_photos.$rec_detail['photo1'];
										}else{
											if(isset($rec_detail['gender']) && $rec_detail['gender'] == 'Male'){
												$defult_photo = $web_name.'assets/front_end/img/default-photo/male.png';
											}else{
												$defult_photo = $web_name.'assets/front_end/img/default-photo/female.png';
											}
										}

										$username111 = $rec_detail['username'];
										$matri_id111 = $rec_detail['matri_id'];
										$religion_name = $rec_detail['religion_name'];
										$caste_name = $rec_detail['caste_name'];
										$location = $rec_detail['state_name'].', '.$rec_detail['country_name'];
										$education_name = $rec_detail['education_name'];
										$occupation_name = $rec_detail['occupation_name'];
										$profile_link = $web_name.'search/view-profile/'.$rec_detail['matri_id'];
										if(isset($rec_detail['birthdate']) && $rec_detail['birthdate'] !='')
										{
											$birthdate = $rec_detail['birthdate'];
											$age = $this->common_model->birthdate_disp($birthdate,0);
										}
										else
										{
											$age = $this->common_model->display_data_na('');
										}
										if(isset($rec_detail['height']) && $rec_detail['height'] !='')
										{
											$height123 = $rec_detail['height'];
											$height = $this->common_model->display_height($height123);
										}
										else
										{
											$height = $this->common_model->display_data_na('');
										}

										$member_data_html .='<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                        <tbody>
                                            <tr>
                                                <td colspan="5">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="contentEditableContainer contentTextEditable">
                                                                        <div class="contentEditable" style="font-size:20px;color:#333333;">
                                                                            <div style="text-align:center;"><img style="width:150px; height:180px;" src="'.$defult_photo.'" /></div>


                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>&nbsp;</td>
                                                <td>
                                                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="contentEditableContainer contentTextEditable">
                                                                        <div class="contentEditable" style="font-size:20px;color:#333333;">
                                                                            <div style="text-align:center;margin-top:-10px;">
                                                                                <p>'.$username111.' ('.$matri_id111.')</p>
                                                                            </div>

                                                                            <div class="contentEditable" style="font-size:14px;color:#333333;line-height:22px;text-align:center;">
                                                                                <p>'.$age.', '.$height.' | '.$religion_name.' : '.$caste_name.' | Location : '.$location.' | Education : '.$education_name.' | Occupation : '.$occupation_name.'</p>
                                                                                <a href="'.$profile_link.'" style="background: #01bcd5; border-radius: 8px; border: none; padding: 10px 25px; width: 80%; color: #fff;text-decoration:none;">View Profile</a>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr></tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div style="border-top: 1px solid #01bcd5;margin-top:20px;">

                                </div>';
									}
								}
							}

							$data_array = array('matri_id'=>$matri_id,'username'=>$username,'webfriendlyname'=>$webfriendlyname,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"linkedin_link"=>$linkedin_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"contact_no"=>$contact_no,"from_email"=>$from_email,"contact_us"=>$contact_us,"android_app_link"=>$android_app_link,"login"=>$login,"member_data_html"=>$member_data_html,"part_basic_detail"=>$part_basic_detail);

							$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);

							$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);

							if(isset($email) && $email!= '')
							{

								$this->common_model->common_send_email($email,$email_subject,$email_content);
							}

							if(isset($member_data['mobile']) && $member_data['mobile'] != '')
							{
								$mobile = $member_data['mobile'];
								// $get_sms_temp = $this->common_front_model->get_sms_template('Active Profile');
								$approved_status = $this->input->post('member_approved_status');
								if(isset($status_update) && $status_update == 'APPROVED' && $approved_status=='photo')
								{
									$get_sms_temp = $this->common_front_model->get_sms_template('Photo Approved');
									$template_id =$get_sms_temp['template_id'];
								}
								else if(isset($status_update) && $status_update == 'APPROVED' && $approved_status=='active_profile'){
									$get_sms_temp = $this->common_front_model->get_sms_template('Active Profile');
									$template_id =$get_sms_temp['template_id'];
								}elseif(isset($status_update) && $status_update == 'DELETE'){
									$get_sms_temp = $this->common_front_model->get_sms_template('Delete Profile');
									$template_id =$get_sms_temp['template_id'];
								}elseif(isset($status_update) && $status_update == 'Suspended'){
									$get_sms_temp = $this->common_front_model->get_sms_template('Suspend Member');
									$template_id =$get_sms_temp['template_id'];
								}

								if(isset($get_sms_temp) && $get_sms_temp!='')
								{
									$login_id = $matri_id.' or '.$email;
									$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
									$trans = array("web_frienly_name"=>$webfriendlyname,"XXXnameXXX"=>$login_id);

									$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);

									$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
								}
							}
						}
					}
				}
			}
		}
	}


	public function get_matching_result($selected_val)
	{
		$page = '';
		$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$selected_val,'is_deleted'=>'No'),1,'id,matri_id,gender,looking_for,part_height,part_height_to,part_complexion,part_mother_tongue,part_religion,part_caste,part_country_living,part_education');

		if(isset($row_data) && $row_data !='')
		{
			$gender = $row_data['gender'];
			if($gender !='')
			{
				$where_search[]= " ( gender != '$gender' ) ";
			}
			if(isset($row_data['part_height']) && $row_data['part_height'] !='')
			{
				$part_height = $row_data['part_height'];
				$where_search[]= " ( height >='$part_height') ";
			}
			if(isset($row_data['part_height_to']) && $row_data['part_height_to'] !='')
			{
				$part_height_to = $row_data['part_height_to'];
				$where_search[]= " ( height <='$part_height_to') ";
			}
			if(isset($row_data['looking_for']) && $row_data['looking_for'] !='')
			{
				$looking_for = explode(',',$row_data['looking_for']);
				$looking_for = $this->common_model->trim_array_remove($looking_for);
				if(isset($looking_for) && count($looking_for) > 0)
				{
					$looking_for_str = implode("','",$looking_for);
					$where_search[]= " ( marital_status in ( '$looking_for_str') ) ";
				}
			}
			if(isset($row_data['part_complexion']) && $row_data['part_complexion'] !='')
			{
				$complexion = explode(',',$row_data['part_complexion']);
				$complexion = $this->common_model->trim_array_remove($complexion);
				if(isset($complexion) && count($complexion) > 0)
				{
					$complexion_str = implode("','",$complexion);
					$where_search[]= " ( complexion in ( '$complexion_str') ) ";
				}
			}
			if(isset($row_data['part_mother_tongue']) && $row_data['part_mother_tongue'] !='')
			{
				$mothertongue = explode(',',$row_data['part_mother_tongue']);
				$mothertongue = $this->common_model->trim_array_remove($mothertongue);
				if(isset($mothertongue) && count($mothertongue) > 0)
				{
					$mothertongue_str = implode("','",$mothertongue);
					$where_search[]= " ( mother_tongue in ( '$mothertongue_str') ) ";
				}
			}
			if(isset($row_data['part_religion']) && $row_data['part_religion'] !='')
			{
				$religion = explode(',',$row_data['part_religion']);
				$religion = $this->common_model->trim_array_remove($religion);
				if(isset($religion) && count($religion) > 0)
				{
					$religion_str = implode("','",$religion);
					$where_search[]= " ( religion in ('$religion_str') ) ";
				}
			}
			if(isset($row_data['part_caste']) && $row_data['part_caste'] !='')
			{
				$part_caste = explode(',',$row_data['part_caste']);
				$caste = $this->common_model->trim_array_remove($part_caste);
				if(isset($caste) && count($caste) > 0)
				{
					$caste_str = implode("','",$caste);
					$where_search[]= " ( caste in ('$caste_str') ) ";
				}
			}
			if(isset($row_data['part_country_living']) && $row_data['part_country_living'] !='')
			{
				$part_country_living = explode(',',$row_data['part_country_living']);
				$country = $this->common_model->trim_array_remove($part_country_living);
				if(isset($country) && count($country) > 0)
				{
					$country_str = implode("','",$country);
					$where_search[]= " ( country_id in ('$country_str') ) ";
				}
			}
			if(isset($row_data['part_education']) && $row_data['part_education'] !='')
			{
				$part_education = explode(',',$row_data['part_education']);
				$education = $this->common_model->trim_array_remove($part_education);
				if(isset($education) && $education !='')
				{
					$str_education_partner = array();
					$where_search_filed['education'] = $education;
					foreach($education as $part_education_arr_val)
					{
						$str_education_partner[] = "(find_in_set('$part_education_arr_val',education_detail) > 0 )";
					}
					if(isset($str_education_partner) && count($str_education_partner)> 0)
					{
						$str_education_partner_str = implode(" or ",$str_education_partner);
						$where_search[]= " ( $str_education_partner_str ) ";
					}
				}
			}
		}
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
			$this->db->where($where_search_str);
		}
		$this->db->where_not_in('status',array('UNAPPROVED','Suspended'));

		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='3');

		return $member_data;
	}

	// function new_send_notification_android($device_id = '',$message = '',$title='',$noti_type='',$deice_type='',$data_array='',$data_message=array())
	// {
	// 	#API access key from Google API's Console
	// 	if($device_id !='' && $message !='' && $deice_type !='')
	// 	{
	// 		$API_ACCESS_KEY = 'AIzaSyAsguaJ1I3iRcG0vCA0zAuxFXKLVDweViI';//'AIzaSyAoUAbCGL41b-omVsaKh6QDScNoiOIRv0U';
	// 		if($API_ACCESS_KEY!='')
	// 		{
	// 			$message 	= urldecode($message);
	// 			$title 		= urldecode($title);
	// 			$noti_type 	= urldecode($noti_type);

	// 			$registrationIds = $device_id;
	// 			$badge = 0;
	// 			if(isset($data_array['badge']) && $data_array['badge'] !='')
	// 			{
	// 				$badge = $data_array['badge'];
	// 			}
	// 			#prep the bundle
	// 			$msg = array(
	// 				'body' 	=> $message,
	// 				'message' => $message,
	// 				'title'	=> $title,
	// 				'noti_type' => $noti_type,
	// 				'sound' => 'default',
	// 				'badge' => $badge,
	// 				'badge_count' => $badge,
	// 				"click_action"=>"com.mega.matrimony.".$noti_type,
	// 				//"click_action"=>"FCM_PLUGIN_ACTIVITY",
	// 				//"click_action"=>"com.mega.matrimony."+$d,//"when like,shortlist,block , unblock then print other ","when interest_receive then interest_receive"
	// 				//"when message then 'message'","when photo_password then 'photo_password'","when active acount then 'active_act'"
	// 				"priority"=>"high"

	// 			);
	// 			//site id
	// 			if($registrationIds !='' && !is_array($registrationIds))
	// 			{
	// 				$registrationIds = array($registrationIds);
	// 			}
	// 			if(isset($data_array) && $data_array !='' && count($data_array)> 0)
	// 			{

	// 			}
	// 			else
	// 			{
	// 				$data_array = array(
	// 					'noti_type' => $noti_type,
	// 					'other_id'=>$deice_type,
	// 					'interest_tag'=>$deice_type,
	// 					'matri_id'=>$deice_type,
	// 					'ppassword_tag'=>$deice_type,
	// 					'data_msg'=>$data_message,
	// 					'content'=>((isset($data_message['content']) && $data_message['content']!='')?$data_message['content']:''),
	// 					'sentOn'=>((isset($data_message['sent_on']) && $data_message['sent_on']!='')?$data_message['sent_on']:''),
	// 					'photoUrl'=>((isset($data_message['photo_url']) && $data_message['photo_url']!='')?$data_message['photo_url']:''),
	// 					'receiver'=>((isset($data_message['receiver']) && $data_message['receiver']!='')?$data_message['receiver']:''),
	// 					//'other_id'=>,//other when like,shortlist,block , unblock then print user id other wise default
	// 					//'interest_tag'=>'receive',//when accept 'send'  then send then 'receive'
	// 					//'matri_id'=>'matri_id',//"when message then 'matri_id'"
	// 					//'ppassword_tag'=>'receive',//"when photo_password then 'send','receive'"
	// 					'body' 	=> $message,
	// 					'message' => $message,
	// 					'title'	=> $title,
	// 					'sound' => 'default',
	// 					'badge' => 0,
	// 					'badge_count' => $badge,
	// 				);
	// 			}
	// 			$data_array["noti_type"] = $noti_type;
	// 			$data_array["priority"] = "high";
	// 			/*$data_array["click_action"] = "FCM_PLUGIN_ACTIVITY";*/
	// 			$data_array["body"] = $message;
	// 			$data_array["badge_count"] = $badge;
	// 			$fields = array(
	// 				/*'to'		=> $registrationIds,*/
	// 				'registration_ids' => $registrationIds,
	// 				'notification'	=> $msg,
	// 				"priority"=>"high",
	// 				/*"click_action"=>"FCM_PLUGIN_ACTIVITY",*/
	// 				'data' => $data_array,
	// 				'body' 	=> $message,
	// 				'badge' => $badge,
	// 				'badge_count' => $badge,
	// 			);
	// 			$headers = array(
	// 				'Authorization: key=' . $API_ACCESS_KEY,
	// 				'Content-Type: application/json'
	// 			);
	// 			//print_r($data_array);exit;
	// 			$ch = curl_init();
	// 			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	// 			curl_setopt( $ch,CURLOPT_POST, true );
	// 			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	// 			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	// 			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	// 			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	// 			$result = curl_exec($ch );
	// 			curl_close( $ch );


	// 			return $result;
	// 		}
	// 	}
	// 	else
	// 	{
	// 		return 'Provide device id and message';
	// 	}
	// }
	function get_ip(){
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		if (!empty($_SERVER["HTTP_CLIENT_IP"])){
			$ip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		else{
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		return $ip;
	}
	function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
		$output = NULL;
		if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
			$ip = $_SERVER["REMOTE_ADDR"];
			if ($deep_detect) {
				if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
					$ip = $_SERVER['HTTP_CLIENT_IP'];
			}
		}
		$purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
		$support    = array("country", "countrycode", "state", "region", "city", "location", "address");
		$continents = array(
			"AF" => "Africa",
			"AN" => "Antarctica",
			"AS" => "Asia",
			"EU" => "Europe",
			"OC" => "Australia (Oceania)",
			"NA" => "North America",
			"SA" => "South America"
		);
		if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
			if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
				switch ($purpose) {
					case "location":
						$output = array(
							"city"           => @$ipdat->geoplugin_city,
							"state"          => @$ipdat->geoplugin_regionName,
							"country"        => @$ipdat->geoplugin_countryName,
							"country_code"   => @$ipdat->geoplugin_countryCode,
							"continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
							"continent_code" => @$ipdat->geoplugin_continentCode
						);
						break;
					case "address":
						$address = array($ipdat->geoplugin_countryName);
						if (@strlen($ipdat->geoplugin_regionName) >= 1)
							$address[] = $ipdat->geoplugin_regionName;
						if (@strlen($ipdat->geoplugin_city) >= 1)
							$address[] = $ipdat->geoplugin_city;
						$output = implode(", ", array_reverse($address));
						break;
					case "city":
						$output = @$ipdat->geoplugin_city;
						break;
					case "state":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "region":
						$output = @$ipdat->geoplugin_regionName;
						break;
					case "country":
						$output = @$ipdat->geoplugin_countryName;
						break;
					case "countrycode":
						$output = @$ipdat->geoplugin_countryCode;
						break;
				}
			}
		}
		return $output;
	}
	function ip_countryname_code(){
		$ip_countryname_code = '';
		$ip = $this->get_ip();
		$country = $this->get_count_data_manual('country',array('status'=>'APPROVED'),2,'*','','','','');

		$ip_country1 = $this->ip_info("Visitor", "Country");
		if(count($country)>0){
			foreach($country as $country_row){
				if($ip_country1 == $country_row["country_name"])
				{
					$ip_countryname_code = $country_row["country_name"];
				}
			}
		}
		return $ip_countryname_code.','.$ip;
	}
	public function get_client_ip()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	public function add_ip_data()
	{
		$ip = $this->get_ip();
        $ch = curl_init("http://ipinfo.io/{$ip}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout in case the request takes too long
        $jsone_response = curl_exec($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($curl_error) {
            // echo "cURL error: " . $curl_error;
        } else {
            if ($jsone_response) {
                $detailsd = json_decode($jsone_response);
                if ($detailsd) {
                    $this->session->set_userdata("ip_info_data", $detailsd);
                }
            } else {
                // echo "Error fetching IP information.";
            }
        }
        return $detailsd;
	}
	function add_user_analysis()
	{
		//$api_info=array();
	$page_exist=array("index","index.php","search","premium-member","success-story","contact","login","faq","wedding-vendor","mobile-matri","demograph","privacy-policy","refund-policy","report-misuse","terms-condition","blog","add-with-us","event","matrimony","my-dashboard","my-profile","message","express-interest","upload","modify-photo","cover-photo","horoscope","id_proof","matches","privacy-setting","more-details","register","cms");
		$latitude = $longitude = $broadband_name = $postal = "";
		if(base_url()!='http://192.168.1.111/mega_matrimony/original_script/'){
			$ip = $this->get_ip();
		}
		else{
			$ip = "192.168.1.36";
		}
		$details_sesion=$this->session->userdata("ip_info_data");

		$api_info ='';
		if(isset($details_sesion) && $details_sesion!='' && is_array($details_sesion) && count($details_sesion) > 0 && isset($details_sesion->ip) && $details_sesion->ip != '' && $details_sesion->ip == $ip){
			$details=$this->session->userdata("ip_info_data");

			foreach($details as $key=>$details_d){
				$api_info.= $key.'->'.$details_d.', ';
			}
		}
		else{
			$newTime = strtotime('-12 hours');
			$start_date = date('Y-m-d H:i:s', $newTime);
			$end_date = date('Y-m-d H:i:s');

			$this->db->where('visit_time BETWEEN "'.$start_date. '" and "'.$end_date.'"');
			$data_return = $this->common_model->get_count_data_manual("user_analysis",array("ip"=>$ip,),1,'','','','','0');
			if(isset($data_return) && $data_return!='' && is_array($data_return) && count($data_return) >0  && $data_return['ip']==$ip){
				$latitude		= $data_return['latitude'];
				$longitude		= $data_return['longitude'];
				$address		= $data_return['address'];
				$country_da		= $data_return['country'];
				$postal			= $data_return['postal'];
				$broadband_name	= $data_return['broadband_name'];
				$api_info 		= $data_return['api_info'];
				$details 		= 1;
			}
		}
		if($api_info==""){
			$details = $this->common_model->add_ip_data();
			foreach($details as $key=>$details_d){
				$api_info.= $key.'->'.$details_d.', ';
			}
		}
		if(isset($details) && $details!=''){
			if(isset($details->loc) && $details->loc!=''){
				$location = explode(',',$details->loc);
				$ins_data['latitude'] = $location[0];
				$ins_data['longitude'] = $location[1];
			}
			else{
				$ins_data['latitude'] = $this->xss_clean($latitude);
				$ins_data['longitude'] = $this->xss_clean($longitude);
			}
			if(isset($details->ip) && $details->ip!=''){
				$ins_data['ip'] = $details->ip;
			}
			else{
				$ins_data['ip'] = $this->xss_clean($ip);
			}

			if(isset($details->city) && $details->city!=''){
				$city = $details->city;
			}
			else{
				$city = '';
			}
			if(isset($details->region) && $details->region!=''){
				$region = $details->region;
			}
			else{
				$region = '';
			}
			if(isset($details->country) && $details->country!=''){
				$country_user = $details->country;
			}
			else{
				$country_user = '';
			}

			if(isset($address) && $address!='')
			{
				$ins_data['address'] = $this->xss_clean($address);
			}
			else{
				$ins_data['address'] = $city.' '.$region.' '.$country_user;
			}
			if(isset($country_da) && $country_da!=''){
				$ins_data['country'] = $country_da;
			}
			else{
				$ins_data['country'] = $this->xss_clean($country_user);
			}

			$ins_data['visit_time'] = $this->common_model->getCurrentDate();
			if(isset($details->postal) && $details->postal!=''){
				$ins_data['postal'] = $this->xss_clean($details->postal);
			}
			else{
				$ins_data['postal'] = $this->xss_clean($postal);
			}
			if(isset($details->org) && $details->org!=''){
				$ins_data['broadband_name'] = $this->xss_clean($details->org);
			}
			else{
				$ins_data['broadband_name'] = $this->xss_clean($broadband_name);
			}
			$uri_segment_1 = $uri_segment_2 = $uri_segment_3 = $uri_segment_4 = $uri_segment = '';
			$uri_segment_1 = $this->uri->segment(1);
			$uri_segment_2 = $this->uri->segment(2);
			$uri_segment_3 = $this->uri->segment(3);
			$uri_segment_4 = $this->uri->segment(4);

			if(isset($uri_segment_1) && $uri_segment_1!='' && in_array($uri_segment_1,$page_exist)){
				$uri_segment = $uri_segment_1;
			}
			if(isset($uri_segment) && $uri_segment!=''){
				if(isset($uri_segment_2) && $uri_segment_2!='assets' && $uri_segment_2!='images'){
					if(isset($uri_segment_2) && $uri_segment_2!=''){
						$uri_segment .='/'.$uri_segment_2;
					}
					if(isset($uri_segment_3) && $uri_segment_3!=''){
						$uri_segment .='/'.$uri_segment_3;
					}
					if(isset($uri_segment_4) && $uri_segment_4!=''){
						$uri_segment .='/'.$uri_segment_4;
					}
				}
				else{
					$uri_segment .= "";
				}
			}
			else{
				$uri_segment .= "";
			}
			if($uri_segment == ""){
				$uri_segment_check_red = basename($_SERVER['PHP_SELF']);
				if(isset($uri_segment_check_red) && $uri_segment_check_red!='' && in_array($uri_segment_check_red,$page_exist)){
					$uri_segment = $uri_segment_check_red;
				}
				else{
					$uri_segment = "";
				}
			}
			$ins_data['page_name'] = $this->xss_clean($uri_segment);
			if(isset($uri_segment) && $uri_segment!=''){
				if(isset($api_info) && $api_info!='' && is_array($api_info)){
					$ins_data['api_info']=implode(",",$api_info_db);
				}
				else{
					$ins_data['api_info']=$this->xss_clean($api_info);
				}
				$this->update_insert_data_common("user_analysis",$ins_data,'',0,0);
			}
		}
	}
	function user_ip_block()
	{
		error_reporting(0);
		$myFile = $this->path_ip."blocking_ip.txt";
		if(file_exists($myFile)){
			$rows = file_get_contents($myFile);
			$rows_data = explode(',',$rows);
			if(isset($rows_data) && $rows_data!='' && is_array($rows_data) && count($rows_data)>0){
				$ip = $this->get_ip();
				if(isset($ip) && $ip!='' && in_array($ip,$rows_data)){
					redirect(base_url().'blocked');
				}
			}
		}
	}
	function display_advertise($level='',$class=''){
		$where_arra=array('type'=>'Image','level'=>$level,'is_deleted'=>'No','status'=>'APPROVED');
		$advertisement_data = $this->common_model->get_count_data_manual('advertisement_master',$where_arra,1,'*','rand()');
		$advertise = '';
		if(isset($advertisement_data) && $advertisement_data !='' && is_array($advertisement_data) && count($advertisement_data) > 0 )
		{
			if(isset($advertisement_data['type']) && $advertisement_data['type'] =='Image' && isset($advertisement_data['link']) && $advertisement_data['link'] !='' && isset($advertisement_data['image']) && $advertisement_data['image'] !='')
			{
				$img_src = base_url().$this->path_advertise.$advertisement_data['image'];
				$advertise = '<div class="mega-box-new '.$class.'"><a href="'.$advertisement_data['link'].'" target="_blank"><img src="'.$img_src.'" class="img-responsive brd-raduis" alt="'.$advertisement_data['link'].'"/></a></div>';
			}
			else{
				$advertise = '<div class="mega-box-new">'.$advertisement_data['google_adsense'].'</div>';
			}
		}
		return $advertise;
	}

	//  for dynamic menu listing
	function sidebar_menu_api()
	{
		$online_member_menu_arr = array(
			array(
				"is_expandable" => 0,
				"menu_action" => "Dashboard",
				"menu_id" => 0,
				"menu_img" => "ic_dashboard_new",
				"menu_title" => "Dashboard",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 1,
				"menu_action" => "",
				"menu_id" => 2,
				"menu_img" => "ic_profile_new",
				"menu_title" => "My Profile",
				"sub_menu" =>
				array(
					array(
					   "img_sub_menu" => "",
						"sub_menu_action" => "ViewMyProfileActivity",
						"sub_menu_id" => 0,
						"sub_menu_title" => "View Profile",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ChangePasswordActivity",
						"sub_menu_id" => 1,
						"sub_menu_title" => "Change Password",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ManagePhotosActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "Manage Photos",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ManageAccountActivity",
						"sub_menu_id" => 3,
						"sub_menu_title" => "Manage Account",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "SavedSearchActivity",
						"sub_menu_id" => 4,
						"sub_menu_title" => "My Saved Search",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "UploadVideoActivity",
						"sub_menu_id" => 5,
						"sub_menu_title" => "Upload Video",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "UploadIdAndHoroscopeActivity",
						"sub_menu_id" => 6,
						"submenu_tag" => "id",
						"sub_menu_title" => "Upload Id Proof",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "UploadIdAndHoroscopeActivity",
						"sub_menu_id" => 7,
						"submenu_tag" => "horoscope",
						"sub_menu_title" => "Upload Horoscope",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "DeleteProfileActivity",
						"sub_menu_id" => 8,
						"sub_menu_title" => "Delete Account",
					)
				),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "SearchActivity",
				"menu_id" => 1,
				"menu_img" => "ic_search_new",
				"menu_title" => "Search",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 1,
				"menu_action" => "",
				"menu_id" => 2,
				"menu_img" => "ic_custom_match_new",
				"menu_title" => "My Matches",
				"sub_menu" =>
				array(
					array(
					   "img_sub_menu" => "",
						"sub_menu_action" => "MatchFromAdminActivity",
						"sub_menu_id" => 0,
						"sub_menu_title" => "Match Of The Day",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "CustomMatchActivity",
						"sub_menu_id" => 1,
						"sub_menu_title" => "Recommended Match",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "CustomMatchActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "Premium Match",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "CustomMatchActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "NearBy Match",
					),
				),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "RecentlyJoinActivity",
				"menu_id" => 0,
				"menu_img" => "ic_recently_join_new",
				"menu_title" => "Recently Join",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "RecentlyLoginActivity",
				"menu_id" => 0,
				"menu_img" => "ic_recently_login_new",
				"menu_title" => "Recently Login",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "ExpressInterestActivity",
				"menu_id" => 9,
				"menu_img" => "ic_send_interest_new",
				"menu_title" => "Express Interest",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "PhotoPasswordActivity",
				"menu_id" => 7,
				"menu_img" => "ic_photo_request",
				"menu_title" => "Photo Request",
				"sub_menu" => array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "QuickMessageActivity",
				"menu_id" => 4,
				"menu_img" => "ic_message_new",
				"menu_title" => "Message",
				"sub_menu" => array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "ChatActivity",
				"menu_id" => 4,
				"menu_img" => "ic_chat_new",
				"menu_title" => "Chat",
				"sub_menu" => array(),
			),
			array(
				"is_expandable" => 1,
				"menu_action" => "",
				"menu_id" => 8,
				"menu_img" => "ic_action_new",
				"menu_title" => "Activity",
				"sub_menu" =>array(
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ViewedProfileActivity",
						"sub_menu_id" => 0,
						 "submenu_tag" => "i_viewed",
						"sub_menu_title" => "Profiles I Viewed",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ViewedProfileActivity",
						"sub_menu_id" => 1,
						 "submenu_tag" => "my_profile",
						"sub_menu_title" => "Viewed My Profiles",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ViewedContactActivity",
						"sub_menu_id" => 0,
						 "submenu_tag" => "i_viewed",
						"sub_menu_title" => "Contact I Viewed",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ViewedContactActivity",
						"sub_menu_id" => 1,
						 "submenu_tag" => "my_profile",
						"sub_menu_title" => "Viewed My Contact",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "LikeProfileActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "Liked Profiles",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ShortlistedProfileActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "Shortlisted Profiles",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "BlockListActivity",
						"sub_menu_id" => 2,
						"sub_menu_title" => "Blocked Profiles",
					),
				 ),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "SuccessStoryActivity",
				"menu_id" => 9,
				"menu_img" => "ic_success_story_new",
				"menu_title" => "Success Story",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 0,
				"menu_action" => "FirstVendorCategoryListActivity",
				"menu_id" => 9,
				"menu_img" => "ic_vendor_new",
				"menu_title" => "Wedding Vendor",
				"sub_menu" =>array(),
			),
			array(
				"is_expandable" => 1,
				"menu_action" => "",
				"menu_id" => 3,
				"menu_img" => "ic_settings_new",
				"menu_title" => "Additional Setting",
				"sub_menu" => array(
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ContactUsActivity",
						"sub_menu_id" => 0,
						"sub_menu_title" => "Contact Us",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "AllCmsActivity",
						"sub_menu_id" => 1,
							"submenu_tag" => "privacy",
						"sub_menu_title" => "Privacy Policy",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "AllCmsActivity",
						"sub_menu_id" => 2,
						"submenu_tag" => "refund",
						"sub_menu_title" => "Refund Policy",
					),
					 array(
						"img_sub_menu" => "",
						"sub_menu_action" => "AllCmsActivity",
						"sub_menu_id" => 3,
							"submenu_tag" => "term",
						"sub_menu_title" => "Terms & Condition",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "AllCmsActivity",
						"sub_menu_id" => 4,
						 "submenu_tag" => "about",
						"sub_menu_title" => "About Us",
					),
					array(
						"img_sub_menu" => "",
						"sub_menu_action" => "ReportMissuseActivity",
						"sub_menu_id" => 5,
						"sub_menu_title" => "Report Misuse",
					),
				  ),
			),	
			array(
				"is_expandable" => 0,
				"menu_action" => "Logout",
				"menu_id" => 10,
				"menu_img" => "ic_logout_new",
				"menu_title" => "Logout",
				"sub_menu" => array(),
			),
		);
		return $online_member_menu_arr;
	}
	// for dynamic menu listing
	function new_send_notification_web($data_array=array()){
		#API access key from Google API's Console
		$config_data = $this->get_site_config();
		$notification_script = $config_data['notification_script'];
		if(isset($config_data['sent_web_notification']) && $config_data['sent_web_notification']=='Yes'){
			if($data_array['device_id']!='' && $data_array['message']!=''){
				if($notification_script!=''){
					$message 	= urldecode($data_array['message']);
					$title 		= urldecode($data_array['title']);
					$noti_type 	= urldecode($data_array['notification_type']);

					$registrationIds = $data_array['device_id'];
					
					$icon = '';
					if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
						$icon = base_url().'assets/logo/'.$config_data['upload_favicon'];
					}
					$logo = '';
					if(isset($config_data['upload_logo']) && $config_data['upload_logo'] !=''){
						$logo = base_url().'assets/logo/'.$config_data['upload_logo'];
					}
					$click_action = '';
					if(isset($data_array['click_action']) && $data_array['click_action'] !=''){
						$click_action = $data_array['click_action'];
					}
					$notification_arr = array('body' => $data_array['message'], 'title' => $data_array['title'], 'click_action' => $click_action);

					$type_array = array('profile_photo_approval','cover_photo_approve','video_approval','id_proof_photo_approval','horoscope_photo_approval','featured_profile','viewed_contact_details','viewed_profile','add_shortlist','interest_receive','message','reminder_interest_receive','accepted_interest_receive','rejected_interest_receive','received_match','match_from_admin','like_member','photo_request','accepted_photo_request','rejected_photo_request');
					// ,'add_blocklist','remove_blocklist'
					if(is_array($type_array) && in_array($noti_type, $type_array)){
						$user_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$data_array['sender_id']),1,'photo1,photo1_approve,photo_view_status,gender','');
						if(isset($user_data['gender']) && $user_data['gender']=='Female'){
			                $photopassword_image = base_url().'assets/images/photopassword_female.png';
			            }elseif(isset($user_data['gender']) && $user_data['gender']=='Male'){
			                $photopassword_image = base_url().'assets/images/photopassword_male.png';
			            }
						$path_photos = $this->common_model->path_photos;
						if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) && $user_data['photo_view_status'] == 0){
				            $logo_img = $photopassword_image;
						}else{
				            $logo_img = $this->common_model->member_photo_disp($user_data);
						}
						$notification_arr['icon'] = $logo_img;
					}
					else{
						$notification_arr['icon'] = $icon;
					}
					
					$serviceAccount = json_decode($config_data['firebase_json'], true);
					$FIREBASE_PROJECT_ID = $serviceAccount['project_id'];
				    $FIREBASE_BAERER_TOCKEN = $this->common_model->getAccessToken($config_data);
    				$headers = array(
                        'Authorization: Bearer '.$FIREBASE_BAERER_TOCKEN,
                        'Content-Type: application/json'
                    );
                    $payload = array(
                        'message' => array(
                            'token' => $registrationIds,
                            'data' => $notification_arr,
                            "notification" => array(
                                "title"=> $data_array['title'],
                                "body"=> $data_array['message']
    			            ),
                        ),
                    );
					$ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.$FIREBASE_PROJECT_ID.'/messages:send');
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
					curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($payload));
					$result = curl_exec($ch);
					curl_close($ch);

					if(!empty($data_array)){
						$data_array_new = array(
						'sender_id' => $data_array['sender_id'],
						'receiver_id' => $data_array['receiver_id'],
						'notification_type' => $data_array['notification_type'],
						'title' => $data_array['title'],
						'message' => $data_array['message'],
						'click_action'=>$data_array['click_action'],
						'created_on'=>$this->getCurrentDate());
						$this->db->insert('web_notification_history',$data_array_new);
					}
					return $result;
				}
			}
			else{
				return 'Provide device id and message';
			}
		}
	}

	public function base64UrlEncode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public function createJWT($header, $payload, $privateKey) {
		$headerEncoded = $this->base64UrlEncode(json_encode($header));
		$payloadEncoded = $this->base64UrlEncode(json_encode($payload));

		$signature = '';
		openssl_sign("$headerEncoded.$payloadEncoded", $signature, $privateKey, 'sha256');

		$signatureEncoded = $this->base64UrlEncode($signature);

		return "$headerEncoded.$payloadEncoded.$signatureEncoded";
	}

	public function getAccessToken($settingArr=array()) {
		$serviceAccount = json_decode($settingArr['firebase_json'], true);
		if (isset($serviceAccount) && is_array($serviceAccount)) {
			$now = time();
			$expires = $now + 3600; // Token expires in 1 hour

			$header = [
				'alg' => 'RS256',
				'typ' => 'JWT'
			];

			$payload = [
				'iss' => $serviceAccount['client_email'],
				'sub' => $serviceAccount['client_email'],
				'aud' => 'https://oauth2.googleapis.com/token',
				'iat' => $now,
				'exp' => $expires,
				'scope' => 'https://www.googleapis.com/auth/firebase.messaging'
			];

			$privateKey = openssl_pkey_get_private($serviceAccount['private_key']);
			$jwt = $this->createJWT($header, $payload, $privateKey);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://oauth2.googleapis.com/token');
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
				'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
				'assertion' => $jwt
			]));

			$response = curl_exec($ch);
			curl_close($ch);

			$data = json_decode($response, true);

			return $data['access_token'];
		}
	}

	function new_send_notification_android($device_id = '',$message = '',$title='',$noti_type='',$deice_type='',$data_array='',$data_message=array(),$sender_receiver=array())
	{
	   
		#API access key from Google API's Console
		
		if($device_id !='' && $message !='' && $deice_type !='')
		{
			$config_data = $this->get_site_config();		
			$accessToken = $this->getAccessToken($config_data);
			$serviceAccount = json_decode($config_data['firebase_json'], true);

			$url = 'https://fcm.googleapis.com/v1/projects/'.$serviceAccount['project_id'].'/messages:send';

			if($accessToken!=''){
				$message 	= (string)urldecode($message);
				$title 		= (string)urldecode($title);
				$noti_type 	= (string)urldecode($noti_type);

				$registrationIds = $device_id;
				$badge = 0;
				if(isset($data_array['badge']) && $data_array['badge'] !='')
				{
					$badge = (string)$data_array['badge'];
				}
				#prep the bundle
				$msg = array(
					'body' 	=> "$message",
					'message' => "$message",
					'title'	=> "$title",
					'noti_type' => "$noti_type",
					'sound' => 'default',
					'badge' => "$badge",
					'badge_count' => "$badge",
					"click_action"=>(string)$config_data['app_click_action'].$noti_type,
					"priority"=>"high",
					'action'=>"$noti_type",
				);
				//site id
				if($registrationIds !='' && !is_array($registrationIds))
				{
					$registrationIds = array($registrationIds);
				}
				if(isset($data_array) && $data_array !='' && count($data_array)> 0)
				{

				}
				else
				{
					$data_array = array(
						'noti_type' => "$noti_type",
						'other_id'=>"$deice_type",
						'interest_tag'=>"$deice_type",
						'matri_id'=>"$deice_type",
						'ppassword_tag'=>"$deice_type",
						'data_msg'=>"$data_message",
						'content'=>((isset($data_message['content']) && $data_message['content']!='')?(string)$data_message['content']:''),
						'sentOn'=>((isset($data_message['sent_on']) && $data_message['sent_on']!='')?(string)$data_message['sent_on']:''),
						'photoUrl'=>((isset($data_message['photo_url']) && $data_message['photo_url']!='')?(string)$data_message['photo_url']:''),
						'receiver'=>((isset($data_message['receiver']) && $data_message['receiver']!='')?(string)$data_message['receiver']:''),
						'body' 	=> "$message",
						'message' => "$message",
						'title'	=> "$title",
						'sound' => "default",
						'badge' => "0",
						'badge_count' => "$badge",
					);
				}
				$type_array = array('profile_photo_approval','cover_photo_approve','video_approval','id_proof_photo_approval','horoscope_photo_approval','featured_profile','viewed_contact_details','viewed_profile','add_shortlist','interest_receive','message','reminder_interest_receive','accepted_interest_receive','rejected_interest_receive','received_match','match_from_admin','like_member','photo_request','accepted_photo_request','rejected_photo_request','payment_received');
				// ,'add_blocklist','remove_blocklist'
				if(is_array($type_array) && in_array($noti_type, $type_array)){
					$user_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$sender_receiver['sender']),1,'photo1,photo1_approve,photo_view_status,gender','');
					if(isset($user_data['gender']) && $user_data['gender']=='Female'){
		                $photopassword_image = base_url().'assets/images/photopassword_female.png';
		            }elseif(isset($user_data['gender']) && $user_data['gender']=='Male'){
		                $photopassword_image = base_url().'assets/images/photopassword_male.png';
		            }
					$path_photos = $this->common_model->path_photos;
					if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) && $user_data['photo_view_status'] == 0){
			            $photo_icon = $photopassword_image;
					}else{
			            $photo_icon = $this->common_model->member_photo_disp($user_data);
					}
				}else{
				    if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
						$photo_icon = base_url().'assets/logo/'.$config_data['upload_favicon'];
					}
				}
				$photo_icon = "$photo_icon";
				
				if(isset($data_array["photoUrl"]) && $data_array["photoUrl"]==''){
					$data_array["photoUrl"]="$photo_icon";
				}
				$data_array["noti_type"] = "$noti_type";
				$data_array["priority"] = "high";
				$data_array["body"] = "$message";
				$data_array["badge_count"] = "$badge";
				
				$messagePayload = [
					'message' => [
						'token' => $device_id,
						'notification' => [
							'title' => $title,
							'body'  => $message
						],
						// 'data' => []
					]
				];
				if (!empty($data_array)) {
					$messagePayload['message']['data'] = $data_array;
				}

				$jsonMessage = json_encode($messagePayload);
			
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, [
					'Authorization: Bearer ' . $accessToken,
					'Content-Type: application/json'
				]);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonMessage);

				$response = curl_exec($ch);
				
				curl_close($ch);

                if(is_array($type_array) && in_array($noti_type, $type_array)){
    				$data_array_new = array('sender_id'=>$sender_receiver['sender'],'receiver_id'=>$sender_receiver['receiver'],'app_type'=>$sender_receiver['app_type'],'notification_type'=>$noti_type,'title'=>$title,'message'=>$message);
    				if(!empty($data_array_new)){
    				    $app_t = $sender_receiver['app_type'];
    				    $rec_id = $sender_receiver['receiver'];
    				    $sen_id = $sender_receiver['sender'];
    					$created_on = $this->getCurrentDate();
    					$sql = "insert into app_notification_history (sender_id, receiver_id, app_type,notification_type,title,message,created_on) values ('$sen_id','$rec_id','$app_t','$noti_type', '$title', '$message','$created_on')";
                        $this->db->query($sql);
    				}
                }
				$result = "Notification send successfully";
				return $result;
			}
		}
		else{
			return 'Provide device id and message';
		}
	}

	function new_send_notification_android_bk($device_id = '',$message = '',$title='',$noti_type='',$deice_type='',$data_array='',$data_message=array(),$sender_receiver=array())
	{
		#API access key from Google API's Console
		
		if($device_id !='' && $message !='' && $deice_type !='')
		{
			$config_data = $this->get_site_config();
			$API_ACCESS_KEY = $config_data['notification_access_key'];
			if($API_ACCESS_KEY!=''){
				$message 	= urldecode($message);
				$title 		= urldecode($title);
				$noti_type 	= urldecode($noti_type);

				$registrationIds = $device_id;
				$badge = 0;
				if(isset($data_array['badge']) && $data_array['badge'] !='')
				{
					$badge = $data_array['badge'];
				}
				#prep the bundle
				$msg = array(
					'body' 	=> $message,
					'message' => $message,
					'title'	=> $title,
					'noti_type' => $noti_type,
					'sound' => 'default',
					'badge' => $badge,
					'badge_count' => $badge,
					"click_action"=>$config_data['app_click_action'].$noti_type,
					"priority"=>"high",
					'action'=>$noti_type,
				);
				//site id
				if($registrationIds !='' && !is_array($registrationIds))
				{
					$registrationIds = array($registrationIds);
				}
				if(isset($data_array) && $data_array !='' && count($data_array)> 0)
				{

				}
				else
				{
					$data_array = array(
						'noti_type' => $noti_type,
						'other_id'=>$deice_type,
						'interest_tag'=>$deice_type,
						'matri_id'=>$deice_type,
						'ppassword_tag'=>$deice_type,
						'data_msg'=>$data_message,
						'content'=>((isset($data_message['content']) && $data_message['content']!='')?$data_message['content']:''),
						'sentOn'=>((isset($data_message['sent_on']) && $data_message['sent_on']!='')?$data_message['sent_on']:''),
						'photoUrl'=>((isset($data_message['photo_url']) && $data_message['photo_url']!='')?$data_message['photo_url']:''),
						'receiver'=>((isset($data_message['receiver']) && $data_message['receiver']!='')?$data_message['receiver']:''),
						'body' 	=> $message,
						'message' => $message,
						'title'	=> $title,
						'sound' => 'default',
						'badge' => 0,
						'badge_count' => $badge,
					);
				}
				$type_array = array('profile_photo_approval','cover_photo_approve','video_approval','id_proof_photo_approval','horoscope_photo_approval','featured_profile','viewed_contact_details','viewed_profile','add_shortlist','interest_receive','message','reminder_interest_receive','accepted_interest_receive','rejected_interest_receive','received_match','match_from_admin','like_member','photo_request','accepted_photo_request','rejected_photo_request','payment_received');
				// ,'add_blocklist','remove_blocklist'
				if(is_array($type_array) && in_array($noti_type, $type_array)){
					$user_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$sender_receiver['sender']),1,'photo1,photo1_approve,photo_view_status,gender','');
					if(isset($user_data['gender']) && $user_data['gender']=='Female'){
		                $photopassword_image = base_url().'assets/images/photopassword_female.png';
		            }elseif(isset($user_data['gender']) && $user_data['gender']=='Male'){
		                $photopassword_image = base_url().'assets/images/photopassword_male.png';
		            }
					$path_photos = $this->common_model->path_photos;
					if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) && $user_data['photo_view_status'] == 0){
			            $photo_icon = $photopassword_image;
					}else{
			            $photo_icon = $this->common_model->member_photo_disp($user_data);
					}
				}else{
				    if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
						$photo_icon = base_url().'assets/logo/'.$config_data['upload_favicon'];
					}
				}
				
				if(isset($data_array["photoUrl"]) && $data_array["photoUrl"]==''){
					$data_array["photoUrl"]=$photo_icon;
				}
				$data_array["noti_type"] = $noti_type;
				$data_array["priority"] = "high";
				$data_array["body"] = $message;
				$data_array["badge_count"] = $badge;
				$fields = array(
					/*'to'		=> $registrationIds,*/
					'registration_ids' => $registrationIds,
				// 	'notification'	=> $msg,
				// 	"priority"=>"high",
					'data' => $data_array,
				// 	'body' 	=> $message,
				// 	'badge' => $badge,
				// 	'badge_count' => $badge,
					'icon'=>$photo_icon,
				);
				$headers = array(
					'Authorization: key=' . $API_ACCESS_KEY,
					'Content-Type: application/json'
				);
				$ch = curl_init();
				curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
				curl_setopt( $ch,CURLOPT_POST, true );
				curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
				$result = curl_exec($ch);
				curl_close($ch);

                if(is_array($type_array) && in_array($noti_type, $type_array)){
    				$data_array_new = array('sender_id'=>$sender_receiver['sender'],'receiver_id'=>$sender_receiver['receiver'],'app_type'=>$sender_receiver['app_type'],'notification_type'=>$noti_type,'title'=>$title,'message'=>$message);
    				if(!empty($data_array_new)){
    				    $app_t = $sender_receiver['app_type'];
    				    $rec_id = $sender_receiver['receiver'];
    				    $sen_id = $sender_receiver['sender'];
    					$created_on = $this->getCurrentDate();
    					$sql = "insert into app_notification_history (sender_id, receiver_id, app_type,notification_type,title,message,created_on) values ('$sen_id','$rec_id','$app_t','$noti_type', '$title', '$message','$created_on')";
                        $this->db->query($sql);
    				}
                }
				return $result;
			}
		}
		else{
			return 'Provide device id and message';
		}
	}

	public function featured_notification($selected_val){
		$this->db->where_in('id', $selected_val);
		$row_data = $this->common_model->get_count_data_manual('register','',2,'id,matri_id,web_device_id,ios_device_id,android_device_id','id asc','','');
		if(isset($row_data) && $row_data!='' && count($row_data)>0){
			foreach($row_data as $row_data_val){
				$M_message = $row_data_val['matri_id'].': Your profile is selected as Featured Profile now.';
				if(isset($row_data_val['web_device_id']) && $row_data_val['web_device_id']!=''){
					$data_array = array(
						'device_id'=>$row_data_val['web_device_id'],
						'sender_id' => 'Admin',
						'receiver_id' => $row_data_val['id'],
						'notification_type' => 'featured_profile',
						'title' => 'Featured Profile',
						'message' => $M_message,
						'click_action'=>base_url().'my-profile',
					);
					$this->common_model->new_send_notification_web($data_array);
				}
				if(isset($row_data_val['ios_device_id']) && $row_data_val['ios_device_id']!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$row_data_val['id'],'app_type'=>'IOS');
					$this->common_model->new_send_notification_android($row_data_val['ios_device_id'],$M_message,'Featured Profile','featured_profile',$row_data_val['id'],'','',$sender_receiver);
				}
				if(isset($row_data_val['android_device_id']) && $row_data_val['android_device_id']!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$row_data_val['id'],'app_type'=>'Android');
					$this->common_model->new_send_notification_android($row_data_val['android_device_id'],$M_message,'Featured Profile','featured_profile',$row_data_val['id'],'','',$sender_receiver);
				}
			}
		}
	}
	public function photo_video_id_proof_noti($selected_val, $photo=''){
		$this->db->where_in('id', $selected_val);
		$row_data = $this->common_model->get_count_data_manual('register','',2,'id,matri_id, web_device_id, ios_device_id, android_device_id','id asc','','');
		if(isset($row_data) && $row_data!='' && count($row_data)>0){
			foreach($row_data as $row_data_val){
				if($photo == 'video_approval'){
					$notification_type = 'video_approval';
					$notification_title = 'Video Approval';
					$M_message = $row_data_val['matri_id'].': Congratulations! Your matrimonial Video is approved successfully.';
					$click_action = base_url().'upload/video';
				}
				else if($photo == 'cover_photo_approve'){
					$notification_type = 'cover_photo_approve';
					$notification_title = 'Cover Photo Approval';
					$M_message = $row_data_val['matri_id'].': Congratulations! Your matrimonial Cover Photo is approved successfully.';
					$click_action = base_url().'upload/cover-photo';
				}
				else if($photo == 'horoscope_photo_approve'){
					$notification_type = 'horoscope_photo_approval';
					$notification_title = 'Horoscope Approval';
					$M_message = $row_data_val['matri_id'].': Congratulations! Your matrimonial Horoscope is approved successfully.';
					$click_action = base_url().'upload/horoscope';
				}
				else if($photo == 'id_proof_approve'){
					$notification_type = 'id_proof_photo_approval';
					$notification_title = 'ID Proof Approval';
					$M_message = $row_data_val['matri_id'].': Congratulations! Your matrimonial ID Proof is approved successfully.';
					$click_action = base_url().'upload/id_proof';
				}else{
					$notification_type = 'profile_photo_approval';
					$title = ucfirst(str_replace("_"," ",$photo));
					$notification_title = str_replace("approve","Approval",$title);
					$int = intval(preg_replace('/[^0-9]+/', '', $photo), 10);
					$M_message = $row_data_val['matri_id'].': Congratulations! Your matrimonial Profile Photo'.$int.' is approved successfully.';
					$click_action = base_url().'modify-photo';
				}
				
				if(isset($row_data_val['web_device_id']) && $row_data_val['web_device_id']!=''){
					$data_array = array(
						'device_id'=>$row_data_val['web_device_id'],
						'sender_id' => 'Admin',
						'receiver_id' => $row_data_val['id'],
						'notification_type' => $notification_type,
						'title' => $notification_title,
						'message' => $M_message,
						'click_action'=>$click_action,
					);
					$this->common_model->new_send_notification_web($data_array);
				}
				if(isset($row_data_val['ios_device_id']) && $row_data_val['ios_device_id']!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$row_data_val['id'],'app_type'=>'IOS');
					$this->common_model->new_send_notification_android($row_data_val['ios_device_id'],$M_message,$notification_title,$notification_type,$row_data_val['id'],'','',$sender_receiver);
				}
				if(isset($row_data_val['android_device_id']) && $row_data_val['android_device_id']!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$row_data_val['id'],'app_type'=>'Android');
					$this->common_model->new_send_notification_android($row_data_val['android_device_id'],$M_message,$notification_title,$notification_type,$row_data_val['id'],'','',$sender_receiver);
				}
			}
		}
	}
	public function add_other_details($table="",$post_data=array()){  
        $add_other_details = $this->common_model->get_count_data_manual($table,$post_data,1,'','id desc');
        if($add_other_details=='')
        {
            $this->db->insert($table, $post_data);
            $insert_id = $this->db->insert_id();        
            return  $insert_id;
        }
    }

	function new_send_notification_android_topic_to_all($message = '',$title='',$noti_type='',$deice_type='',$data_array='',$data_message=array())
	{
	    $config_data = $this->get_site_config();		
		$accessToken = $this->getAccessToken($config_data);

		$serviceAccount = json_decode($config_data['firebase_json'], true);
		if (isset($serviceAccount) && is_array($serviceAccount) && $serviceAccount!='') {
			$url = 'https://fcm.googleapis.com/v1/projects/'.$serviceAccount['project_id'].'/messages:send';

			if($accessToken!=''){
				$message 	= (string)urldecode($message);
				$title 		= (string)urldecode($title);
				$noti_type 	= (string)urldecode($noti_type);

				$registrationIds = $device_id;
				$badge = 0;
				if(isset($data_array['badge']) && $data_array['badge'] !='')
				{
					$badge = (string)$data_array['badge'];
				}
				if(isset($data_array) && $data_array !='' && count($data_array)> 0)
				{

				}
				else
				{
					$data_array = array(
						'noti_type' => "$noti_type",
						'other_id'=>"$deice_type",
						'interest_tag'=>"$deice_type",
						'matri_id'=>"$deice_type",
						'ppassword_tag'=>"$deice_type",
						'data_msg'=>"$data_message",
						'content'=>((isset($data_message['content']) && $data_message['content']!='')?(string)$data_message['content']:''),
						'sentOn'=>((isset($data_message['sent_on']) && $data_message['sent_on']!='')?(string)$data_message['sent_on']:''),
						'photoUrl'=>((isset($data_message['photo_url']) && $data_message['photo_url']!='')?(string)$data_message['photo_url']:''),
						'receiver'=>((isset($data_message['receiver']) && $data_message['receiver']!='')?(string)$data_message['receiver']:''),
						'body' 	=> "$message",
						'message' => "$message",
						'title'	=> "$title",
						'sound' => "default",
						'badge' => "0",
						'badge_count' => "$badge",
					);
				}
				$data_array["noti_type"] = "$noti_type";
				$data_array["priority"] = "high";
				/*$data_array["click_action"] = "FCM_PLUGIN_ACTIVITY";*/
				$data_array["body"] = "$message";
				$data_array["badge_count"] = "$badge";
				$topic = "adminUser";
				if($noti_type == 'chat_topic_android'){
					$topic = "$noti_type";
				}
				
				$messagePayload = [
						'message' => [
							'topic' => $topic,
							'notification' => [
								'title' => $title,
								'body'  => $message
							],
							// 'data' => []
						]
					];
					if (!empty($data_array)) {
						$messagePayload['message']['data'] = $data_array;
					}

					$jsonMessage = json_encode($messagePayload);
				
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
						'Authorization: Bearer ' . $accessToken,
						'Content-Type: application/json'
					]);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonMessage);

					$response = curl_exec($ch);
					// print_r($response);exit;
					
					curl_close($ch);
					
				$result = "Notification send successfully";
				return $result;
			}
		}
	}

	function new_send_notification_android_topic_to_all_bk($message = '',$title='',$noti_type='',$deice_type='',$data_array='',$data_message=array())
	{
		#API access key from Google API's Console
		// if update $API_ACCESS_KEY here then find new_send_notification_android_admin and update $API_ACCESS_KEY
		$config_data = $this->get_site_config();
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		// $API_ACCESS_KEY = 'AAAA_hQzcOA:APA91bEtbO6IvpRRFYcI9mEYqxOt3fsndquRbUEfCZ-Agtrkn5mmZr8aYUw_cbYdsZpc9zpCTv4U0Y7KIvfHFJlJZ026TqZYnyaD82iiwIyFRmBhlZYAeXD2f_jUzAE0yugcscqiJ3yZ';
		if($API_ACCESS_KEY!='')
		{
			$message 	= urldecode($message);
			$title 		= urldecode($title);
			$noti_type 	= urldecode($noti_type);

			$registrationIds = $device_id;
			$badge = 0;
			if(isset($data_array['badge']) && $data_array['badge'] !='')
			{
				$badge = $data_array['badge'];
			}
			#prep the bundle
			$msg = array(
				'body' 	=> $message,
				'message' => $message,
				'title'	=> $title,
				'noti_type' => $noti_type,
				'sound' => 'default',
				'badge' => $badge,
				'badge_count' => $badge,
				"click_action"=>"com.matrimony.marriageduniya.".$noti_type,
				"priority"=>"high"

			);
			//site id
			if($registrationIds !='' && !is_array($registrationIds))
			{
				$registrationIds = array($registrationIds);
			}
			if(isset($data_array) && $data_array !='' && count($data_array)> 0)
			{

			}
			else
			{
				$data_array = array(
					'noti_type' => $noti_type,
					'other_id'=>$deice_type,
					'interest_tag'=>$deice_type,
					'matri_id'=>$deice_type,
					'ppassword_tag'=>$deice_type,
					'data_msg'=>$data_message,
					'content'=>((isset($data_message['content']) && $data_message['content']!='')?$data_message['content']:''),
					'sentOn'=>((isset($data_message['sent_on']) && $data_message['sent_on']!='')?$data_message['sent_on']:''),
					'photoUrl'=>((isset($data_message['photo_url']) && $data_message['photo_url']!='')?$data_message['photo_url']:''),
					'receiver'=>((isset($data_message['receiver']) && $data_message['receiver']!='')?$data_message['receiver']:''),
					//'other_id'=>,//other when like,shortlist,block , unblock then print user id other wise default
					//'interest_tag'=>'receive',//when accept 'send'  then send then 'receive'
					//'matri_id'=>'matri_id',//"when message then 'matri_id'"
					//'ppassword_tag'=>'receive',//"when photo_password then 'send','receive'"
					'body' 	=> $message,
					'message' => $message,
					'title'	=> $title,
					'sound' => 'default',
					'badge' => 0,
					'badge_count' => $badge,
				);
			}
			$data_array["noti_type"] = $noti_type;
			$data_array["priority"] = "high";
			/*$data_array["click_action"] = "FCM_PLUGIN_ACTIVITY";*/
			$data_array["body"] = $message;
			$data_array["badge_count"] = $badge;
			$topic = 'adminUser';
			if($noti_type == 'chat_topic_android'){
				$topic = $noti_type;
			}
			$fields = array(
				/*'to'		=> $registrationIds,*/
				'to'=>'/topics/'.$topic,
			//	'notification'	=> $msg,
				"priority"=>"high",
				/*"click_action"=>"FCM_PLUGIN_ACTIVITY",*/
				'data' => $data_array,
				'body' 	=> $message,
				'badge' => $badge,
				'badge_count' => $badge,
			
			);
			$headers = array(
				'Authorization: key=' . $API_ACCESS_KEY,
				'Content-Type: application/json'
			);
			//print_r($data_array);exit;
			$ch = curl_init();
			curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
			curl_setopt( $ch,CURLOPT_POST, true );
			curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
			$result = curl_exec($ch );
			curl_close( $ch );
			return $result;
		}
	}

	public function generateCaptcha($imgId='Imageid'){
		$vals = array(
			'word'          => mt_rand(100000, 999999),
			'img_path'      => './captcha/',
			'img_url'       => base_url().'captcha',
			'font_path'     => './path/to/fonts/texb.ttf',
			'img_width'     => '130',
			'img_height'    => 41,
			'expiration'    => 7200,
			'word_length'   => 6,
			'font_size'     => 20,
			'img_id'        => $imgId,
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',

			// White background and border, black text and red grid
			'colors' => array(
				'background' => array(255, 255, 255),
				'border' => array(255, 255, 255),
				'text' => array(0, 0, 0),
				'grid' => array(255, 40, 40)
			)
		);

		$cap = create_captcha($vals);
		$cap['Imageid'] = $imgId;
		## Set Session :
		$this->session->set_userdata('captcha_code_session',$cap['word']);
		return $cap;
	}

	## Subscripbe Topic Web :
    function subscribeToTopicWeb($tokens = [], $topic = '', $type = 'add') {
		if (!empty($tokens) && $topic != '') {
			$config_data = $this->common_model->get_site_config();
			$FIREBASE_BAERER_TOCKEN = $this->common_model->getAccessToken($config_data);
			if($type == "add"){
                $url = "https://iid.googleapis.com/iid/v1:batchAdd";
            }else{
                $url = "https://iid.googleapis.com/iid/v1:batchRemove";
            }
            $headers = [
                'Authorization: Bearer ' . $FIREBASE_BAERER_TOCKEN,
                'Content-Type: application/json',
                'access_token_auth: true'
            ];
	        
	        $body = [
                'to' => "/topics/".$topic,
                'registration_tokens' => $tokens
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
    
            $result = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return json_decode($result, true);
		}
		
	}

}