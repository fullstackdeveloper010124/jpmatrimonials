<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Crone extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('back_end/Match_making_model','match_making_model');
		$this->config_array = $this->common_model->get_site_config();
	}
	/* create crone in server 
	 set minute :10
	 set crone jobs command : 
	"curl -silent https://www.mega-matrimony.narjisdemos.com/crone/send_bulk_email" */
	
	public function send_bulk_email(){
		$email_data =  $this->common_model->get_count_data_manual('send_bulk_email','',2,'*','',1,50);
		if(isset($email_data) && $email_data!='' && is_array($email_data) && count($email_data)>0){
			foreach($email_data as $email){
				$to_email = $email['email'];
				$email_subject = $email['email_subject'];
				$email_content = $email['email_content'];
				$this->common_model->common_send_email($to_email,$email_subject,$email_content);
				if(isset($email['id']) && $email['email_content']!=''){
					$this->db->where('id', $email['id']);
					$this->db->delete('send_bulk_email');
				}
			}
		}
	}
	public function send_bulk_sms(){
		$sms_data =  $this->common_model->get_count_data_manual('send_bulk_sms','',2,'*','',1,50);
		if(isset($sms_data) && $sms_data!='' && is_array($sms_data) && count($sms_data)>0){
			foreach($sms_data as $sms){
				$sms_mobile = $sms['sms_mobile'];
				$sms_content = $sms['sms_content'];
				$this->common_model->common_sms_send($sms_mobile,$sms_content);
				if(isset($sms['id']) && $sms['sms_content']!=''){
					$this->db->where('id', $sms['id']);
					$this->db->delete('send_bulk_sms');
				}
			}
		}
	}
	
	public function send_matches_sms()
	{
		//to check test cron job working or not
		$config_arra = $this->common_model->get_site_config();
		$send_total_match = $config_arra['send_total_match']; 
		$send_date = $config_arra['match_send_date'];
		
		$today = $this->common_model->getCurrentDate('Y-m-d');
		if($send_date == $today){
			//$this->common_model->common_send_email('almas@narjisenterprise.com','Crone Email','This is a test message sent via crone job');
			$this->insert_matchs_list();
			$sms_data = $this->common_model->get_count_data_manual('send_matches_sms',array('sent_status'=>'No','sms_mobile!='=>'',"email NOT IN(SELECT email FROM send_matches_sms where sent_date='".$today."')"),2,'*','id asc',1,50,'','','');
			if(isset($sms_data) && $sms_data!='' && is_array($sms_data) && count($sms_data)>0)
			{
				$this->sms_temp_data = $this->common_front_model->get_sms_template('Match Send SMS');
				$this->email_temp_data = $this->common_front_model->getemailtemplate('Auto Match Send');
				$temp_array_mobile = array();
				foreach($sms_data as $sms)
				{
					$temp_array_mobile[$sms['sms_mobile']][] = $sms;					
				}
				
				if(isset($temp_array_mobile) && $temp_array_mobile!='' && is_array($temp_array_mobile) && count($temp_array_mobile)>0)
				{
					foreach($temp_array_mobile as $key_mobile=>$sms_arr)
					{
						if(isset($sms_arr) && $sms_arr!='' && is_array($sms_arr) && count($sms_arr)>0)
						{
							$temp_flag = 0;
							$temp_arraya_dddd = array();
							foreach($sms_arr as $sms_arr_val)
							{
								$temp_flag++;
								$temp_arraya_dddd[] = $sms_arr_val;
								if($temp_flag % $send_total_match==0 )
								{
									$this->send_sms_match($key_mobile,$sms_arr_val['email'],$temp_arraya_dddd);
									$temp_arraya_dddd = array();
								}
							}
							if(isset($temp_arraya_dddd) && is_array($temp_arraya_dddd) && count($temp_arraya_dddd) > 0)
							{
								$this->send_sms_match($key_mobile,$sms_arr_val['email'],$temp_arraya_dddd);
							}
						}
					}
				}
			}
		}
	}
	public function send_sms_match($mobile='',$email='',$arr=array())
	{
		$today = $this->common_model->getCurrentDate('Y-m-d');
		//$sms_data_count = $this->common_model->get_count_data_manual('send_matches_sms',array('sent_status'=>'Yes','sent_date'=>$today,'sms_mobile'=>$mobile),0,'*','id asc','','','','');
		$sms_data_count = $this->common_model->get_count_data_manual('send_matches_sms',array('sent_status'=>'No','sms_mobile!='=>''),2,'*','id asc',1,50,'','','');
		if(isset($sms_data_count) && $sms_data_count==0){
			$user_data = $this->common_model->get_count_data_manual('register',array('mobile'=>$mobile,'status'=>'APPROVED'),1,'mobile','','','');
			if(isset($user_data['mobile']) && $user_data['mobile']!=''){
				$config_arra = $this->common_model->get_site_config();
				$web_name = $config_arra['web_name'];
				$webfriendlyname = $config_arra['web_frienly_name'];
				$android_app_link = $config_arra['android_app_link'];
				$sms_temp_data = $this->sms_temp_data;
				$email_temp_data = $this->email_temp_data;
				
				$user_details = array();
				$user_details_new = '';
				foreach($arr as $arr_val){
					$sms_content = $sms_temp_data['sms_content'];
					$template_id = $sms_temp_data['template_id'];
					$this->db->where_in('id', $arr_val['other_id']);
					$rec_detail = $this->common_model->get_count_data_manual('register_view','',1,'*');
					if(isset($rec_detail['city_name']) && $rec_detail['city_name']!=''){
						$location = $rec_detail['city_name'];
					}
					else if(isset($rec_detail['state_name']) && $rec_detail['state_name']!=''){
						$location = $rec_detail['state_name'];
					}
					else if(isset($rec_detail['country_name']) && $rec_detail['country_name']!=''){
						$location = $rec_detail['country_name'];
					}
					else{
						$location =	$this->common_model->display_data_na('');
					}
					if(isset($rec_detail['birthdate']) && $rec_detail['birthdate'] !=''){
						$birthdate = $rec_detail['birthdate'];
						$age = $this->common_model->birthdate_disp($birthdate,0);
					}
					else{
						$age = $this->common_model->display_data_na('');
					}
					$user_details[] = $rec_detail['username'].' ('.$age.', '.$location.') ';
					$user_id[] = array('other_id'=>$arr_val['other_id']);
				}
				$user_details_new = implode("\r",$user_details);
				
				$data_array = array('webfriendlyname'=>$webfriendlyname,"User_details"=>$user_details_new,"android_app_link"=>$android_app_link);
				$sms_content = $this->common_front_model->getstringreplaced($sms_content,$data_array);
				$sending_mode = $config_arra['match_sending_mode'];
				$to_email = $email;
				
				$subject = $email_temp_data['email_subject']; 
				$email_content = $email_temp_data['email_content'];
				
				$trans = array("webfriendlyname" =>$webfriendlyname);
				
				$email_subject = $this->common_front_model->getstringreplaced($subject, $trans);
				$email_template = $this->common_front_model->getstringreplaced($email_content, $data_array);
				
				if($sending_mode == 'sms'){
					$response = $this->common_model->common_sms_send($mobile,$sms_content,$template_id);
					//if($response == 'success')
					$status = 'success';
				}
				else if($sending_mode == 'email'){
					$response = $this->common_model->common_send_email($to_email,$email_subject,$email_template);
					//if($response == 'Email sent.')
						$status = 'success';
				}
				if($sending_mode == 'both'){
					$response1 = $this->common_model->common_sms_send($mobile,$sms_content,$template_id);
					$response2 = $this->common_model->common_send_email($to_email,$email_subject,$email_template);
					//if($response2 == 'Email sent.')
						$status = 'success';				
				}
				$web_device_id=$user_data['web_device_id'];
				$ios_device_id=$user_data['ios_device_id'];
				$android_device_id=$user_data['android_device_id'];
				$match_msg = "Profile Match Received";

				if(isset($web_device_id) && $web_device_id!= ''){
					$data_array = array(
						'device_id'=>$web_device_id,
						'sender_id' => 'Admin',
						'receiver_id' => $user_data['id'],
						'notification_type' => 'received_match',
						'title' => 'Received Match',
						'message' => $match_msg,
						'click_action'=>base_url().'matches/received-match-from-admin',
					);
					$this->common_model->new_send_notification_web($data_array);
				}
				if(isset($ios_device_id) && $ios_device_id!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$user_data['id'],'app_type'=>'IOS');
					$this->common_model->new_send_notification_android($ios_device_id,$match_msg,'Received Match','received_match',$rec_detail['id'],'','',$sender_receiver);
				}
				if(isset($android_device_id) && $android_device_id!=''){
					$sender_receiver = array('sender'=>'Admin','receiver'=>$user_data['id'],'app_type'=>'Android');
					$this->common_model->new_send_notification_android($android_device_id,$match_msg,'Received Match','received_match',$rec_detail['id'],'','',$sender_receiver);
				}
				
				if(isset($status) && $status=='success'){
					if(isset($user_id) && $user_id!='' && is_array($user_id) && count($user_id)>0){
						foreach($user_id as $user_id_val){
							if((isset($mobile) && $mobile!='') && (isset($email) && $email!='')){
								$this->common_model->update_insert_data_common('send_matches_sms',array('sent_status'=>'Yes','sent_date'=>$today),array('sms_mobile'=>$mobile,'email'=>$email,'other_id'=>$user_id_val['other_id']));
							}
						}
					}
				}
			}
		}
	}
	public function insert_matchs_list()
	{
		$config_arra = $this->common_model->get_site_config();
		$send_total_match = $config_arra['send_total_match']; 
		$sms_data_count = $this->common_model->get_count_data_manual('send_matches_sms',array('sent_status'=>'No','sms_mobile!='=>''),0,'*','id asc','','','','');
		if(isset($sms_data_count) && $sms_data_count<200){
			$auto_match_sms_id = $config_arra['auto_match_sms_id'];
			$my_id_new = "mobile!='' and status='APPROVED' and is_deleted='No' and id > $auto_match_sms_id and LENGTH(mobile) >= 10";
			$user_data = $this->common_model->get_count_data_manual('register',$my_id_new,2,'id,matri_id,mobile,email','id asc','1','200');
			//echo $this->db->last_query();
			if(isset($user_data) && $user_data!='' && is_array($user_data) && count($user_data)>0){
				foreach($user_data as $user_val){
					$matri_id = $user_val['matri_id'];
					$where_matri = $this->match_making_model->auto_match_where_from_matri($matri_id);
					
					// New Code For Get Partner data which is not sent already : Date : 24-08-2021

			    	$exist_wr = "my_id='".$user_val['id']."'";
					$where_matri .= " and id NOT IN(SELECT other_id FROM send_matches_sms WHERE ".$exist_wr.") ";
					// end new Code : 


					$part_user_data = $this->common_model->get_count_data_manual('register_view',$where_matri,2,'id,matri_id,mobile','','1',$send_total_match);
					
					$sms_mobile = $user_val['mobile'];
					$email = $user_val['email'];
					if(isset($part_user_data) && $part_user_data!='' && is_array($part_user_data) && count($part_user_data)>0){
						foreach($part_user_data as $part_user_data_val){
							$sms_id = $part_user_data_val['id'];
							$wr = "my_id='".$user_val['id']."' and other_id = '".$sms_id."'";
							$sql_match = $this->common_model->get_count_data_manual('send_matches_sms',$wr,1,'my_id,other_id','','','','','');
							if(isset($sql_match) && $sql_match!=''){
								$match_indexid = $sql_match['other_id'];
							}
							else{
								$match_indexid = '';
							}
							if(isset($match_indexid) && $match_indexid==''){
								$this->common_model->update_insert_data_common('send_matches_sms',array('sms_mobile'=>$sms_mobile,'email'=>$email,'my_id'=>$user_val['id'],'other_id'=>$sms_id),'',0);
							}
						}
					}
				}
				$latest_sms_id = $this->common_model->get_count_data_manual('send_matches_sms',array('my_id!='=>''),1,'my_id','id desc','','','');
				if(isset($latest_sms_id['my_id']) && $latest_sms_id['my_id']!=''){
					$latest_id_new = $latest_sms_id['my_id'];
					$this->common_model->update_insert_data_common('site_config',array('auto_match_sms_id'=>$latest_id_new),array('id'=>'1'));
				}
			}
			else{
				$latest_id_new = "0";
				$this->common_model->update_insert_data_common('site_config',array('auto_match_sms_id'=>$latest_id_new),array('id'=>'1'));
			}
		}
	}
}