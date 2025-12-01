<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Custom_chat_model extends CI_Model {
	public $data = array();
	public $member_match_data;
	public function __construct()
	{
		parent::__construct();
		$this->member_match_data = '';
	}
	## get Conversation List : 
	public function get_conversation($get_flag = 1,$where_arr = array(),$select="*"){	
		return $this->common_model->get_count_data_manual('custom_chat_conversation',$where_arr,$get_flag,$select,'id DESC');
	}
	## get Conversation List : 
	public function get_conversation_message($get_flag = 1,$where_arr = array(),$select="*",$page="",$limit="",$order_by = "id DESC"){	
		return $this->common_model->get_count_data_manual('custom_chat_conversation_message',$where_arr,$get_flag,$select,$order_by,$page,$limit);
	}

	## Get Match List : Date : 18-11-2021
	public function get_match_member($select="*",$page=1){
		$postData = $this->input->post();
		$this->set_search_where_chat();
		$select = 'register_view.id as member_id,register_view.matri_id as matri_id,register_view.username as username,register_view.gender as gender,custom_chat_online_member.id as custom_chat_id';
		$this->db->join('custom_chat_online_member','custom_chat_online_member.member_id = register_view.id','LEFT');
		if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
			$this->db->like('register_view.matri_id',$postData['searchKeyword']);
			$this->db->or_like('register_view.username',$postData['searchKeyword']);
		}
		if(isset($postData['user_agent']) && $postData['user_agent'] == 'NI-AAPP'){
			$member_data = $this->common_model->get_count_data_manual('register_view','',2,$select,'custom_chat_online_member.id DESC',$page,20);
		}else{
			$member_data = $this->common_model->get_count_data_manual('register_view','',2,$select,'custom_chat_online_member.id DESC');
		}
		return $member_data;
	}

	public function get_match_member_count()
	{
		$this->set_search_where_chat();
		if(isset($postData['searchKeyword']) && $postData['searchKeyword'] != ''){
			$this->db->like('register_view.matri_id',$postData['searchKeyword']);
			$this->db->or_like('register_view.username',$postData['searchKeyword']);
		}
		$member_count = $this->common_model->get_count_data_manual('register_view','',0);
		return $member_count;
	}

	
	## Set Where For Custom Chat : Date : 18-11-2021
	public function set_search_where_chat()
	{
		$where_search = array();
		if($this->member_match_data =='')
		{
			$member_id = $this->common_front_model->get_user_id();
			//$member_id = $this->common_front_model->get_session_data('id');
			if(isset($member_id) && $member_id != '' )
			{
				$where = array('id'=>$member_id,'is_deleted'=>'No');
				$row_data = $this->common_model->get_count_data_manual('register',$where,1,'id, matri_id, gender, looking_for, part_frm_age, part_to_age, part_height, part_height_to, part_complexion, part_mother_tongue, part_religion, part_caste, part_country_living, part_education,is_deleted');
				$this->member_match_data = $row_data;
			}
			
		}
		if($this->member_match_data !='')
		{
			//$gender = $this->common_front_model->get_session_data('gender');
			$row_data = $this->member_match_data;
			$gender = $row_data['gender'];
			$del = $row_data['is_deleted'];
			if($gender !='')
			{
				$where_search[]= " ( register_view.gender != '$gender' ) ";
			}
			if(isset($del) && $del !='')
			{
				$where_search[]= " ( register_view.is_deleted != 'Yes' ) ";
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
			if(isset($row_data['part_frm_age']) && $row_data['part_frm_age'] !='' )
			{
				$part_frm_age = $row_data['part_frm_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  >=$part_frm_age )";
			}
			if(isset($row_data['part_to_age']) && $row_data['part_to_age'] !='')
			{
				$part_to_age = $row_data['part_to_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  <=$part_to_age )";
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
	}

	
	function new_send_notification_web($data_array=array()){
		#API access key from Google API's Console
		$config_data = $this->common_model->get_site_config();
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		if($data_array['device_id']!='' && $data_array['message']!=''){
			if($API_ACCESS_KEY!=''){
				$registrationIds = $data_array['device_id'];
				$logo_img = '';
				if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
					$logo_img = base_url().'assets/logo/'.$config_data['upload_favicon'];
				}
				if(isset($data_array['sender_member_photo_url']) && $data_array['sender_member_photo_url'] !=''){
					$logo_img = $data_array['sender_member_photo_url'];
				}
				$click_action = '';
				if(isset($data_array['click_action']) && $data_array['click_action'] !=''){
					$click_action = $data_array['click_action'];
				}
				$notification_arr = array('body' => $data_array['message'], 'title' => $data_array['title'], 'click_action' => $click_action);
				$notification_arr['icon'] = $logo_img;
				$notification_data = $_POST;
				$notification_data['notification_type'] = $data_array['notification_type'];
                $notification_data['title'] = $data_array['title'];
				$notification_data['body'] = $data_array['message'];
				$notification_data['click_action'] = $click_action;
				$notification_data['icon'] = $data_array['$logo_img'];
				
				$FIREBASE_BAERER_TOCKEN = $this->common_model->getAccessToken($config_data);
				$serviceAccount = json_decode($config_data['firebase_json'], true);
				$FIREBASE_PROJECT_ID = $serviceAccount['project_id'];
				$payload = array(
                    'message' => array(
                        'token' => $registrationIds,
                        'data' => $notification_data,
                        "notification" => array(
                            "title"=> $data_array['title'],
                            "body"=> $data_array['message']
			            ),
                    ),
                );
				$headers = array(
                    'Authorization: Bearer '.$FIREBASE_BAERER_TOCKEN,
                    'Content-Type: application/json'
                );
				$ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.$FIREBASE_PROJECT_ID.'/messages:send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
				$result = curl_exec($ch);
				curl_close($ch);
				if(!empty($data_array)){
				}
				return $result;
			}
		}
		else{
			return 'Provide device id and message';
		}
	}
	
	function topic_send_notification_web(){
		$config_data = $this->common_model->get_site_config();
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		if($API_ACCESS_KEY!=''){
			$notificationTopic = "chat_topic_web";
		    
			$FIREBASE_BAERER_TOCKEN = $this->common_model->getAccessToken($config_data);
			$serviceAccount = json_decode($config_data['firebase_json'], true);
			$FIREBASE_PROJECT_ID = $serviceAccount['project_id'];
			$notification_data = array();
			$notification_data['notification_type'] = "topic_notification";
			$notification_data['title'] = $title = 'Chat Refresh';
            $notification_data['body'] = $message = 'Chat User Refresh';
            $notification_data['icon'] = '';
            $notification_data['image'] = '';
            $messagePayload = [
					'message' => [
					    'topic' => $notificationTopic,
					'data' => [
						'title' => $title,
						'body'  => $message
					],
				]
			];
			if (!empty($notification_data)) {
				$messagePayload['message']['data'] = $notification_data;
			}
			$headers = array(
                'Authorization: Bearer '.$FIREBASE_BAERER_TOCKEN,
                'Content-Type: application/json'
            );
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/v1/projects/'.$FIREBASE_PROJECT_ID.'/messages:send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messagePayload));
			$result = curl_exec($ch);
			// print_r($result);exit;
			curl_close($ch);
			return $result;
		}else{
			return 'Provide device id and message';
		}
	}
	// for Send Android Push Notification Topic : 
	function topic_send_notification_android(){
		$config_data = $this->common_model->get_site_config();
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		// $API_ACCESS_KEY = 'AAAA_hQzcOA:APA91bEtbO6IvpRRFYcI9mEYqxOt3fsndquRbUEfCZ-Agtrkn5mmZr8aYUw_cbYdsZpc9zpCTv4U0Y7KIvfHFJlJZ026TqZYnyaD82iiwIyFRmBhlZYAeXD2f_jUzAE0yugcscqiJ3yZ';
		if($API_ACCESS_KEY!=''){
			$notificationTopic = "chat_topic_android";
		
			$url = "https://fcm.googleapis.com/fcm/send";
			$notification_data['noti_type'] = "topic_notification";
			$fields = array(
				'to' => '/topics/'.$notificationTopic,
				'data' => $notification_data
			);
			$headers = array(
				'Authorization: key=' . $API_ACCESS_KEY,
				'Content-Type:application/json'
			);

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
			curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
			$result = curl_exec($ch);
			// print_r($result);exit;
			curl_close($ch);

			return $result;
		}else{
			return 'Provide device id and message';
		}
	}


	// for Send Web Push Notification Topic : 
		function topic_send_notification_web_bk(){
			$config_data = $this->common_model->get_site_config();
			$API_ACCESS_KEY = $config_data['notification_access_key'];
			// $API_ACCESS_KEY = 'AAAA_hQzcOA:APA91bEtbO6IvpRRFYcI9mEYqxOt3fsndquRbUEfCZ-Agtrkn5mmZr8aYUw_cbYdsZpc9zpCTv4U0Y7KIvfHFJlJZ026TqZYnyaD82iiwIyFRmBhlZYAeXD2f_jUzAE0yugcscqiJ3yZ';
			if($API_ACCESS_KEY!=''){
				$notificationTopic = "chat_topic_web";
			
				$url = "https://fcm.googleapis.com/fcm/send";
				$notification_data['notification_type'] = "topic_notification";
				$fields = array(
					'to' => '/topics/'.$notificationTopic,
					'data' => $notification_data
				);
				$headers = array(
					'Authorization: key=' . $API_ACCESS_KEY,
					'Content-Type:application/json'
				);
	
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
				$result = curl_exec($ch);
				// print_r($result);exit;
				curl_close($ch);
	
				// $this->topic_send_notification_android();
				return $result;
			}else{
				return 'Provide device id and message';
			}
		}


		// for Send Web Push Notification : 
	function new_send_notification_web_bk($data_array=array()){
		#API access key from Google API's Console
		$config_data = $this->common_model->get_site_config();
		$API_ACCESS_KEY = $config_data['notification_access_key'];
		// $API_ACCESS_KEY = 'AAAA_hQzcOA:APA91bEtbO6IvpRRFYcI9mEYqxOt3fsndquRbUEfCZ-Agtrkn5mmZr8aYUw_cbYdsZpc9zpCTv4U0Y7KIvfHFJlJZ026TqZYnyaD82iiwIyFRmBhlZYAeXD2f_jUzAE0yugcscqiJ3yZ';
		if($data_array['device_id']!='' && $data_array['message']!=''){
			if($API_ACCESS_KEY!=''){
				$registrationIds = $data_array['device_id'];
				$logo_img = '';
				if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
					$logo_img = base_url().'assets/logo/'.$config_data['upload_favicon'];
				}
				if(isset($data_array['sender_member_photo_url']) && $data_array['sender_member_photo_url'] !=''){
					$logo_img = $data_array['sender_member_photo_url'];
				}
				$click_action = '';
				if(isset($data_array['click_action']) && $data_array['click_action'] !=''){
					$click_action = $data_array['click_action'];
				}
				$notification_arr = array('body' => $data_array['message'], 'title' => $data_array['title'], 'click_action' => $click_action);
				$notification_arr['icon'] = $logo_img;
				$url = "https://fcm.googleapis.com/fcm/send";
				$notification_data = $_POST;
				$notification_data['notification_type'] = $data_array['notification_type'];
				$fields = array(
					'to' => $registrationIds,
					'notification' => $notification_arr,
					'data' => $notification_data
				);
				$headers = array(
					'Authorization: key=' . $API_ACCESS_KEY,
					'Content-Type:application/json'
				);
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL,$url);
				curl_setopt($ch,CURLOPT_POST,true);
				curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
				curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false );
				curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($fields));
				$result = curl_exec($ch);
				curl_close($ch);
				if(!empty($data_array)){

				}
				return $result;
			}
		}
		else{
			return 'Provide device id and message';
		}
	}
}