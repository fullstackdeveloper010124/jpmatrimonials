<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Match_making_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_match_count_data($data_array='',$flage=0)
	{
		$count_data = 0;
		$where_search_str = '';
		$table_pre ='';
		if($flage ==1)
		{
			$table_pre ='register_view.';
		}
		if($data_array !='' && is_array($data_array) && count($data_array) > 0)
		{
			$where_search = array();
			if(isset($data_array['gender']) && $data_array['gender'] !='')
			{
				$gender = $data_array['gender'];
				$where_search[]= " ( ".$table_pre."gender != '$gender' ) ";
			}
			if(isset($data_array['looking_for']) && $data_array['looking_for'] !='')
			{
				$looking_for = explode(',',$data_array['looking_for']);
				$looking_for = $this->common_model->trim_array_remove($looking_for);
				if(isset($looking_for) && count($looking_for) > 0)
				{
					$looking_for_str = implode("','",$looking_for);
					$where_search[]= " ( ".$table_pre."marital_status in ( '$looking_for_str') ) ";
				}
			}
			if(isset($data_array['part_frm_age']) && $data_array['part_frm_age'] !='' )
			{
				$part_frm_age = $data_array['part_frm_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,".$table_pre."birthdate,CURDATE())  >=$part_frm_age )";
			}
			if(isset($data_array['part_to_age']) && $data_array['part_to_age'] !='')
			{
				$part_to_age = $data_array['part_to_age'];
				$where_search[] = " ( TIMESTAMPDIFF(YEAR,".$table_pre."birthdate,CURDATE())  <=$part_to_age )";
			}			
			if(isset($data_array['part_height']) && $data_array['part_height'] !='' )
			{
				$part_height = $data_array['part_height'];
				$where_search[]= " ( ".$table_pre."height >='$part_height') ";
			}
			if(isset($data_array['part_height_to']) && $data_array['part_height_to'] !='' )
			{
				$part_height_to = $data_array['part_height_to'];
				$where_search[] = " ( ".$table_pre."height <='$part_height_to') ";
			}
			
			if(isset($data_array['part_complexion']) && $data_array['part_complexion'] !='')
			{
				$complexion = explode(',',$data_array['part_complexion']);
				$complexion = $this->common_model->trim_array_remove($complexion);
				if(isset($complexion) && count($complexion) > 0)
				{
					$complexion_str = implode("','",$complexion);
					$where_search[]= " ( ".$table_pre."complexion in ( '$complexion_str') ) ";
				}
			}
			if(isset($data_array['part_mother_tongue']) && $data_array['part_mother_tongue'] !='')
			{
				$part_mother_tongue = $data_array['part_mother_tongue'];
				$part_mother_tongue = $this->common_model->trim_strin_remove($part_mother_tongue);
				if(isset($part_mother_tongue) && $part_mother_tongue !='')
				{
					$where_search[]= " ( ".$table_pre."mother_tongue in ($part_mother_tongue) ) ";
				}
			}
			if(isset($data_array['part_religion']) && $data_array['part_religion'] !='')
			{
				$religion = $data_array['part_religion'];
				$religion = $this->common_model->trim_strin_remove($religion);
				if(isset($religion) && $religion !='')
				{
					$where_search[]= " ( ".$table_pre."religion in ($religion) ) ";
				}
			}
			if(isset($data_array['part_caste']) && $data_array['part_caste'] !='')
			{
				$part_caste = $data_array['part_caste'];
				$part_caste = $this->common_model->trim_strin_remove($part_caste);
				if(isset($part_caste) && $part_caste !='')
				{
					$where_search[]= " ( ".$table_pre."caste in ($part_caste) ) ";
				}
			}
			if(isset($data_array['part_country_living']) && $data_array['part_country_living'] !='')
			{
				$part_country_living = $data_array['part_country_living'];
				$part_country_living = $this->common_model->trim_strin_remove($part_country_living);
				if(isset($part_country_living) && $part_country_living !='')
				{
					$where_search[]= " ( ".$table_pre."country_id in ($part_country_living) ) ";
				}
			}
			if(isset($data_array['part_education']) && $data_array['part_education'] !='')
			{
				$part_education = $data_array['part_education'];
				if(isset($part_education) && $part_education !='')
				{
					$part_education_arr = explode(',',$part_education);
					$str_education_partner = array();
					foreach($part_education_arr as $part_education_arr_val)
					{
						if($part_education_arr_val !='')
						{
							$str_education_partner[] = "(find_in_set('$part_education_arr_val', ".$table_pre."education_detail) > 0 )";
						}
					}
					if(isset($str_education_partner) && count($str_education_partner)> 0)
					{
						$str_education_partner_str = implode(" or ",$str_education_partner);
						$where_search[]= " ( $str_education_partner_str ) ";
					}
				}
			}
			if(isset($where_search) && $where_search !='' && count($where_search) > 0)
			{
				$where_search[]= " ( is_deleted = 'No' ) ";
				$where_search[]= " ( status ='APPROVED' ) ";
				$where_search_str = implode(" and ",$where_search);
			}
			if($flage == 0)
			{
				$count_data = $this->common_front_model->get_count_data_manual("register",$where_search_str,0,'id');
			}
		}
		if($flage == 0)
		{
			return $count_data;
		}
		else if($flage == 1)
		{
			return $where_search_str;
		}
	}
	function get_match_where_from_matri($matri_id = '')
	{
		$return_where = '';
		if($matri_id !='')
		{			
			$data = $this->common_front_model->get_count_data_manual("register",array('matri_id'=>$matri_id),1,'id, matri_id, gender, looking_for, part_frm_age, part_to_age, part_height, part_height_to, part_complexion, part_mother_tongue, part_religion, part_caste, part_country_living, part_education ');
			if($data !='' && count($data) > 0)
			{
				$return_where = $this->get_match_count_data($data,1);
			}
		}
		return $return_where;
	}
	
	function auto_match_where_from_matri($matri_id = '')
	{
		$config_arra = $this->common_model->get_site_config();
		$match_criteria = $config_arra['match_criteria'];
		$match_criteria_new = explode(",",$match_criteria);
		foreach($match_criteria_new as $match_criteria_val){
			if($match_criteria_val == 'age'){ $match_criteria_val = ' birthdate, part_frm_age, part_to_age'; }
			if($match_criteria_val == 'height'){ $match_criteria_val = ' height, part_height, part_height_to'; }
			$new[] = $match_criteria_val;
		}
		$match_new = implode(",",$new);
		$return_where = '';
		if($matri_id != '')
		{
			$data = $this->common_front_model->get_count_data_manual("register",array('matri_id'=>$matri_id),1,'id, matri_id, gender,'.$match_new);
			if($data !='' && count($data) > 0)
			{
				$return_where = $this->get_match_count_data($data,1);
			}
		}
		return $return_where;
	}
	
	function send_email_match($login_matri_id)
	{
		$selected_val = '';
		if($this->input->post('selected_val'))
		{
			$selected_val = $this->input->post('selected_val');
		}
		if(isset($selected_val) && $selected_val !='')
		{
			$selected_val_arr = $selected_val;
			if(!is_array($selected_val))
			{
				$selected_val_arr = explode(",",$selected_val);
			}
			
			$config_arra = $this->common_model->get_site_config();
			$web_name = $config_arra['web_name'];
			$webfriendlyname = $config_arra['web_frienly_name'];
			$facebook_link = $config_arra['facebook_link'];
			$twitter_link = $config_arra['twitter_link'];
			$linkedin_link = $config_arra['linkedin_link'];
			$footer_text = $config_arra['footer_text'];
			$contact_no = $config_arra['contact_no'];
			$from_email = $config_arra['from_email'];
			$android_app_link = $config_arra['android_app_link'];
			$template_image_url = $web_name.'assets/email_template';;
			$contact_us = $web_name.'contact';
		
			
			$email_temp_data = $this->common_front_model->getemailtemplate('Match Send Mail');
			
			$selected_member_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$login_matri_id),1,'id,matri_id,email, username,mobile');
			$member_data_html='';
			foreach($selected_val_arr as $selected_val)
			{
				$rec_detail = $this->common_model->get_count_data_manual('register_view',array('id'=>$selected_val),1,'*');
								
				$matches_list_data_count = $this->common_model->get_count_data_manual('matches_list',array('other_id'=>$selected_val,'my_id'=>$selected_member_data['id']),0,'*','','','','','','');
				
				$sent_on = $this->common_model->getCurrentDate();
				if(isset($matches_list_data_count) && $matches_list_data_count == 0)
				{
					$this->common_model->update_insert_data_common('matches_list',array('my_id'=>$selected_member_data['id'],'other_id'=>$selected_val,'sent_on'=>$sent_on),'',0);
				}
				else
				{
					$this->common_model->update_insert_data_common('matches_list',array('sent_on'=>$sent_on),array('my_id'=>$selected_member_data['id'],'other_id'=>$selected_val));
				}
				
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
																	<p>'.$age.', '.$height.' | '.$religion_name.' : '.$caste_name.' | Location : '.$location.' | Education : '.$education_name.' | Occupation : '.$occupation_name.' </p>
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
			
			$username = $selected_member_data['username'];
			$matri_id = $selected_member_data['matri_id'];
				
			$data_array = array('sender'=>'Admin','username'=>$username,'webfriendlyname'=>$webfriendlyname,'matri_id'=>$matri_id,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"linkedin_link"=>$linkedin_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"contact_no"=>$contact_no,"from_email"=>$from_email,"contact_us"=>$contact_us,"member_data_html"=>$member_data_html,"android_app_link"=>$android_app_link);
			
			if(isset($selected_member_data['email']) && $selected_member_data['email'] !='' && $email_temp_data !='' && count($email_temp_data) > 0)
			{
				$rec_email = $selected_member_data['email'];
				$email_content = $email_temp_data['email_content'];
				$email_subject = $email_temp_data['email_subject'];
					
				$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);
				
				$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
					
				$this->common_model->common_send_email($rec_email,$email_subject,$email_content);
			}
			$web_device_id=$selected_member_data['web_device_id'];
			$ios_device_id=$selected_member_data['ios_device_id'];
			$android_device_id=$selected_member_data['android_device_id'];
			$match_msg = "New Profile Match Received From Admin";
			if(isset($web_device_id) && $web_device_id!= ''){
				$data_array = array(
					'device_id'=>$web_device_id,
					'sender_id' => 'Admin',
					'receiver_id' => $selected_member_data['id'],
					'notification_type' => 'match_from_admin',
					'title' => 'Match From Admin',
					'message' => $match_msg,
					'click_action'=>base_url().'matches/received-match-from-admin',
				);
				$this->common_model->new_send_notification_web($data_array);
			}
			if(isset($ios_device_id) && $ios_device_id!=''){
				$sender_receiver = array('sender'=>'Admin','receiver'=>$selected_member_data['id'],'app_type'=>'IOS');
				$this->common_model->new_send_notification_android($ios_device_id,$match_msg,'Match From Admin','match_from_admin',$rec_detail['id'],'','',$sender_receiver);
			}
			if(isset($android_device_id) && $android_device_id!=''){
				$sender_receiver = array('sender'=>'Admin','receiver'=>$selected_member_data['id'],'app_type'=>'Android');
				$this->common_model->new_send_notification_android($android_device_id,$match_msg,'Match From Admin','match_from_admin',$rec_detail['id'],'','',$sender_receiver);
			}
			$this->session->set_userdata('Match_Email', 'Match Email Send');
		}
	}
	
	
}