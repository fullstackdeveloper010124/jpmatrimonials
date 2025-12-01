<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Common_request extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->common_front_model->last_member_activity();
	}
	
	public function revival()
	{
		echo "Network call received...";
	}
	
	public function get_list($get_list='',$return_opt='json',$currnet_val='')
	{
		$str_ddr = '<option value="">Select Option</option>';
		if($this->input->post('multivar') && $this->input->post('multivar')=='multi')
		{
			$str_ddr = $this->common_front_model->get_list_multiple($get_list);	
		}
		else
		{
			$str_ddr = $this->common_front_model->get_list($get_list);
		}
		
		if($return_opt =='json')
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['dataStr'] = $str_ddr;
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
		else
		{
			echo $str_ddr;
		}
	}
	public function get_mobile_code()
	{
		$str_ddr = array();
		$str_ddr = $this->common_front_model->get_country_code('array');
		$this->output->set_content_type('application/json');
		$data['tocken'] = $this->security->get_csrf_hash();
		$data['status'] = 'success';
		$data['data'] = $str_ddr;
		$this->output->set_output(json_encode($data));
	}
	
	function get_counter()
	{
		$counter_id = $this->input->post('counter_id');
		if($counter_id!='' )
		{
			$str_ddr = $this->common_front_model->get_counter($counter_name='',$counter_id);
			$res['status'] = 'success';
		    $res['counter'] = $str_ddr;
		}
		else
		{
			$res['status'] = 'error';
		}
		$res['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = $res ;
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($data));
	}

	public function get_common_list_ddr()
    {
        $return_data_arr = array();
        $list_ddr_arr = array('marital_status','diet','smoke','gender','manglik','drink','bodytype','complexion','profileby','reference','blood_group','star_list','horoscope','manglik','moonsign_list','residence','employee_in','income','family_type','family_status','no_of_brothers','no_marri_sister','smoke','payment_method','mobile_verify_status','plan_status','plan_expired_on','registered_from','photo_setting','country_code','weight_list','height_list','age_rang','total_children','status_children','mothertongue_list','religion_list','education_list','occupation_list','designation_list','country_list','currency_master','no_marri_brother','sent_interest','received_interest','city_list');
        foreach($list_ddr_arr as $val)
        {
            $return_data_arr[$val] = $this->common_front_model->get_list($val,'json','','array');
        }
        $this->output->set_content_type('application/json');
        $data['tocken'] = $this->security->get_csrf_hash();
        $data['status'] = 'success';
        $data['data'] = $return_data_arr;
        $this->output->set_output(json_encode($data));
    }

	public function get_list_json($get_list='',$currnet_val='')
	{
		$str_ddr = array();
		if($this->input->post('multivar') && $this->input->post('multivar')=='multi')
		{
			$str_ddr = $this->common_front_model->get_list_multiple($get_list,'json','','array');	
		}
		else
		{
			$str_ddr = $this->common_front_model->get_list($get_list,'json','','array');
		}
		$this->output->set_content_type('application/json');
		$data['tocken'] = $this->security->get_csrf_hash();
		$data['status'] = 'success';
		$data['data'] = $str_ddr;
		$this->output->set_output(json_encode($data));
	}
	public function get_tocken()
	{
		$this->common_front_model->set_orgin();
		$data1['tocken'] = $this->security->get_csrf_hash();
		$android_app = $this->common_model->android_app;//set app_version in common model
		$ios_app = $this->common_model->ios_app;//set app_version in common model
		$force_status = false;
		$data1['status'] = 'success';
		$data1['android_version'] = $android_app;// android version
		$data1['app_version'] = $ios_app;//ios appp version 
		if(isset($_REQUEST['appversion']) && $_REQUEST['appversion'] !='')
		{
			$appversion = $_REQUEST['appversion'];
			if(isset($_REQUEST['device_type']) && $_REQUEST['device_type']=='android')
			{
				if($appversion !=$android_app && $appversion < $android_app)
				{
					$force_status = true;	
				}
			}
			else if(isset($_REQUEST['device_type']) && $_REQUEST['device_type']=='ios')
			{
				if($appversion !=$ios_app && $appversion < $ios_app)
				{
					$force_status = true;
				}
			}
		}
		$data1['is_force_update'] = $force_status;
		
		// for get menu sidebar for app dynamic
		$data1['menu_arr'] = $this->common_model->sidebar_menu_api();
		// for get menu sidebar for app dynamic

		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function get_site_data()
	{
		$sitedata = $this->common_front_model->data['config_data'];
		$parampass = array('upload_logo'=>'assets/logo/');
		$data1['tocken'] = $this->security->get_csrf_hash();
		$site_data = $this->common_front_model->dataimage_fullurl($sitedata,$parampass,'single');
		$data1['config_data'] = $site_data;
		/*$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);*/
		$this->output->set_content_type('application/json');
		$data['data'] = $this->output->set_output(json_encode($data1));
	}
	public function get_label_lang()
	{
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['custom_lable'] = $this->common_front_model->data['custom_lable'];
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}

	public function get_list_select2($get_list='',$search='')
	{
	    $str_ddr = array();
		$str_ddr = $this->common_front_model->get_suggestion_list($search,$get_list);
		$data['data'] = json_encode($str_ddr);
		$this->load->view('common_file_echo',$data);
	}

	public function give_plan_access_auth()
	{
		$return_var['data'] = array();
		$return_var['access'] = "No";
		$return_var['tocken'] = $this->security->get_csrf_hash();
		if($this->common_front_model->get_userid() && $this->common_front_model->get_userid()!='')
		{
			$user_id = $this->common_front_model->get_userid();
			$user_type = "job_seeker";
		}
		elseif($this->common_front_model->get_empid() && $this->common_front_model->get_empid()!='')
		{
			$user_id = $this->common_front_model->get_userid();
			$user_type = "job_seeker";
		}
		else
		{
			$user_id = "";
			$user_type = "";
		}
		$access_field = ($this->input->post('access_field')) ? $this->input->post('access_field') : 'contacts';
		$empid_jsid = ($this->input->post('empid_jsid')) ? $this->input->post('empid_jsid') : '';
		if($this->common_front_model->get_userid() && $this->common_front_model->get_userid()!='')
		if($user_id !='' && $user_type!='' && $access_field!='' && $empid_jsid!='')
		{
			$return_var['access'] = $this->common_front_model->get_plan_detail($user_id,$user_type,$access_field);
			if($return_var['access']=='Yes')
			{
				$this->common_front_model->check_for_plan_update($user_id,$user_type,$empid_jsid);
			}
		}
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($return_var));
	}
	public function check_duplicate()
	{
		$return_var['data'] = array();		
		$return_var['tocken'] = $this->security->get_csrf_hash();
		$return_var['status'] = $this->common_model->check_duplicate();
		
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($return_var));
	}
	public function resize_image()
	{
		$this->common_model->resize_image('path_photos_big','1499861784.jpg');
	}
	
	public function send_email_test($id ='',$email='')
	{
		if($id !='' && $email !='')
		{
			$where_arra = array('id'=>$id);
			$data_temp = $this->common_model->get_count_data_manual('email_templates',$where_arra,1,'','','','','');
			print_r($data_temp);
			$this->common_model->common_send_email($email,$data_temp['email_subject'],$data_temp['email_content']);
			echo $data_temp['email_content'];
			echo 'done';
		}
		echo '---';
	}
	public function update_ticket_from_developer()
	{
		if(isset($_REQUEST['web_key']) && $_REQUEST['web_key'] = $this->common_model->web_appkey && isset($_REQUEST['client_id']) && $_REQUEST['client_id'] = $this->common_model->client_id && isset($_REQUEST['ticket_number']) && $_REQUEST['ticket_number'] !='')
		{
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'ticket_reply' && isset($_REQUEST['comment']) && $_REQUEST['comment'] !='')
			{
				$ticket_number = $_REQUEST['ticket_number'];
				$user_type = $_REQUEST['user_type'];
				$user_id = $_REQUEST['user_id'];
				$comment = $_REQUEST['comment'];
				$created_on = $_REQUEST['created_on'];

				$data_array = array(
					'ticket_number'=>$ticket_number,
					'user_type'=>$user_type,
					'user_id'=>$user_id,
					'comment'=>$comment,
					'created_on'=>$created_on,
				);
				$response = $this->common_model->update_insert_data_common("ticket_history_reply",$data_array,'',0);
				$this->common_model->common_send_email($this->common_model->data['config_data']['contact_email'],'Ticket get new replied - '.$ticket_number,'Your ticket '.$ticket_number.' get new replied, please login and check in admin.');
			}
			else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'status_update_ticket' && isset($_REQUEST['status']) && $_REQUEST['status'] !='')
			{
				$ticket_number = $_REQUEST['ticket_number'];
			    $status = $_REQUEST['status'];
				
				$data_array = array(
					'status'=>$status,
				);
				$response = $this->common_model->update_insert_data_common("ticket_table",$data_array,array('ticket_number'=>$ticket_number),1);
				$this->common_model->common_send_email($this->common_model->data['config_data']['contact_email'],'Ticket Status updated - '.$ticket_number,'Your ticket '.$ticket_number.' status changed, please login and check in admin.');
			}
		}
	}
	
	public function get_list_depend()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('get_list','Get list','required');
		$this->form_validation->set_rules('currnet_val','Current val','required');
		
		if($this->form_validation->run() == FALSE)
		{
			$response["status"] 	= "error";
			$response["statuscode"] = 300;
			$response["message"] 	= strip_tags(validation_errors());
			$response["data"] 		= array();
			$response['tocken'] 	= $this->security->get_csrf_hash();
		}
		else
		{
			$get_list 				= $this->input->post('get_list');
			$currnet_val 			= $this->input->post('currnet_val');
			if($currnet_val !='' && is_array($currnet_val))
			{
				$currnet_val = implode(",",$currnet_val);
			}
			//$currnet_val = str_replace("'","','",$currnet_val);
			$currnet_val = $currnet_val;
			$disp_field = array();
			if(isset($get_list) && $get_list!='' && $get_list=='caste')
			{
				$where_arr = array("religion_id IN (".$currnet_val.") AND status = 'APPROVED'");
				$data = $this->common_model->get_count_data_manual("caste",$where_arr,2,"id,caste_name","caste_name ASC");
				$disp_field = array("id","caste_name");
			}
			elseif(isset($get_list) && $get_list!='' && $get_list=='state')
			{
				$where_arr = array("country_id IN (".$currnet_val.") AND status = 'APPROVED'");
				$data = $this->common_model->get_count_data_manual("state_master",$where_arr,2,"id,state_name","state_name ASC");
				$disp_field = array("id","state_name");
			}
			elseif(isset($get_list) && $get_list!='' && $get_list=='city')
			{
				$city_where_arra = array("id IN (".$currnet_val.")");
				$currnet_vals = $this->common_model->get_count_data_manual("state_master",$city_where_arra,1,"country_id,id","","","",0);
				$where_arr = array("country_id = '".$currnet_vals["country_id"]."' AND state_id = '".$currnet_vals["id"]."' AND state_id IN(".$currnet_val.")");
				$data = $this->common_model->get_count_data_manual("city_master",$where_arr,2,"id,city_name","city_name ASC");
				$disp_field = array("id","city_name");
				//echo $this->db->last_query();
			}
			$dataStr = array();
			if(isset($data) && $data !='' && is_array($data) && count($data)>0)
			{
				$i = 0;
				foreach($data as $row)
				{
					$dataStr[$i]["id"] = $row[$disp_field[0]];
					$dataStr[$i]["val"] = $row[$disp_field[1]];
					$i++;
				}
				$response["status"] 	= 'success';
				$response["statuscode"] = 200;
				$response['tocken'] 	= $this->security->get_csrf_hash();
				$response["message"] 	= '';
				$response['data'] 		= $dataStr;
			}
			else
			{
				$response["status"] 	= 'error';
				$response["statuscode"] = 300;
				$response['tocken'] 	= $this->security->get_csrf_hash();
				$response['message'] 	= "No data available";
				$response["data"] 		= array();
			}
		}
		$this->output->set_output(json_encode($response));
	}
	public function change_captcha()
	{
		if(isset($_REQUEST['captcha_session']) && $_REQUEST['captcha_session'] !='')
		{	
			$captcha_session = $_REQUEST['captcha_session'];
			$code = rand(100000,999999);
			$this->session->set_userdata($captcha_session,$code);
			$data['captcha_session'] = $captcha_session;
			$data['base_url'] = base_url();
			$this->load->view('captcha_reload_view',$data);
		}
	}
	public function get_notification_list($page=1)
	{
	    if($this->input->post('page_number') && $this->input->post('page_number') !='')
		{
			$page = $this->input->post('page_number');
		}
		$matri_id = $this->input->post('member_id');
		$app_type = $this->input->post('app_type');
		$where_arra = array('receiver_id'=>$matri_id,'app_type'=>$app_type);
		$noti_list_count = $this->common_model->get_count_data_manual('app_notification_history',$where_arra,0,'id','','','','');
		$noti_list_new = $this->common_model->get_count_data_manual('app_notification_history',$where_arra,2,'*','id desc',$page,10,'');
		$noti_list=array();
		if(isset($noti_list_new) && $noti_list_new!='' && is_array($noti_list_new) && count($noti_list_new)>0){
			$path_photos = $this->common_model->path_photos;
			foreach($noti_list_new as $noti_list_val){
				$datt = $this->common_front_model->get_count_data_manual('register',array('id'=>$noti_list_val['sender_id']),1,'matri_id, gender,photo1, photo1_approve, photo_view_status, photo_protect, photo_password,','',$page,'','','','','');
				
				if(isset($datt['photo1']) && $datt['photo1'] !='' && $datt['photo1_approve'] =='APPROVED' && file_exists($path_photos.$datt['photo1']) && $datt['photo_view_status']==0){
					if(isset($datt['gender']) && $datt['gender'] == 'Male'){
						$noti_list_val['photo_url'] = $base_url.'assets/images/photopassword_female.png';
					}else{
						$noti_list_val['photo_url'] = $base_url.'assets/images/photopassword_male.png';
					}
				}else{
					$noti_list_val['photo_url'] = $this->common_model->member_photo_disp($datt);
				}
				$noti_list[] = $noti_list_val;
			}
		}
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $noti_list_count;
		
		$data_array = array('read_status'=>'Yes');
		$where_array = array('receiver_id'=>$matri_id);
		$this->common_model->update_insert_data_common('app_notification_history',$data_array,$where_array,1,0);
		
		if(isset($noti_list_count) && $noti_list_count!='' && $noti_list_count > 0 && isset($noti_list) && $noti_list!='')
		{
			$data1['errormessage'] = 'Total Result found('.$noti_list_count.')';
			$data1['errmessage'] = 'Total Result found('.$noti_list_count.')';	
			$data1['data'] = $noti_list;
		}
		else
		{
			$data1['data'] = array();
			$data1['errormessage'] = 'No data available';
			$data1['errmessage'] = 'No data available';
			$data1['continue_request'] = FALSE;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
}