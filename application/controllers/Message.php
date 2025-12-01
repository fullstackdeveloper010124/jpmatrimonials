<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Message extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/message_model');
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
	}
	public function index($mode='inbox')
	{
		$this->inbox($mode);
	}
	public function inbox($mode='inbox',$page_number=1)
	{	
		$is_ajax = 0;
		if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		$this->data['message_type'] = $mode;
		$this->data['page_number'] = $page_number;
		$this->common_model->extra_css_fr= array('css/editor.css','css/select2.css');
		$this->common_model->extra_js_fr= array ('js/select2.min.js','js/editor.js');
		
		$this->common_model->js_extra_code_fr.="	
		$(document).ready(function() {			
			select2_int();
			text_editor();
			tooltip_fun();
		});";
		if($is_ajax == 0)
		{	
			$this->common_model->display_top_menu_perm = 'No';
			$base_url = $this->data['base_url'];
			$this->common_model->js_extra_code_fr.= ' load_pagination_message(); ';
			$this->common_model->front_load_header();
			$this->data['first_load'] = true;
			$this->load->view('front_end/inbox',$this->data);
			$this->common_model->front_load_footer();
		}
		else
		{
			$this->update_status();
			$this->load->view('front_end/inbox',$this->data);
		}
	}
	public function inbox_sub()
	{
		$this->load->view('front_end/inbox',$this->data);
	}
	public function update_status_imp()
	{
		$data1 = $this->message_model->update_message_read();
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function update_status()
	{
		if($this->input->post('status') !='')
		{
			$this->data['update_status'] = $this->message_model->update_message_read();
		}
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] != 'NI-WEB')
		{
			$data['data'] = json_encode($this->data['update_status']);
			$this->load->view('common_file_echo',$data);
		}
	}
	public function get_message_list($page=1)
	{
		$message_list_count = $this->message_model->get_message_list(0);
		$message_list = $this->message_model->get_message_list(1,$page);
		$data1['continue_request'] = TRUE;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data1['status'] = 'success';
		$data1['total_count'] = $message_list_count;
		if(isset($message_list_count) && $message_list_count!='' && $message_list_count > 0 && isset($message_list) && $message_list!='')
		{
			$data1['errormessage'] = 'Total Result found('.$message_list_count.')';
			$data1['errmessage'] = 'Total Result found('.$message_list_count.')';	
			$data1['data'] = $message_list;
		}
		else
		{
			$data1['data'] = '';
			$data1['errormessage'] = 'No data available';
			$data1['errmessage'] = 'No data available';
			$data1['continue_request'] = FALSE;
		}
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	public function compose($msg_id = '',$mode='')
	{
		if($msg_id==''){
			$msg_id = $this->input->post('msg_enc_id');
		}
		if($mode==''){
			$mode = $this->input->post('mode');
		}
		echo $data = $this->message_model->compose_msg($msg_id,$mode);
	}
	public function view_message($msg_id = '',$mode='inbox')
	{	
		if($msg_id =='')
		{
			redirect(base_url().'message/index');
		}
		$this->common_model->display_top_menu_perm = 'No';
		$this->common_model->extra_css_fr= array('css/editor.css','css/select2.css');
		$this->common_model->extra_js_fr= array ('js/select2.min.js','js/editor.js');
		$this->common_model->js_extra_code_fr.="	
		$(document).ready(function() {			
			select2_int();
			text_editor();
			tooltip_fun();
		});";
		$this->common_model->front_load_header();
		$this->data['msg_id'] = $msg_id;
		$this->data['mode'] = $mode;
		$this->load->view('front_end/inbox_mail',$this->data);
		$this->common_model->front_load_footer();
	}
	public function send_message()
	{
		$data = $this->message_model->send_message();
		$this->load->view("common_file_echo",$data);
	}
	public function get_member_list()
	{
		$str_ddr = array();
		$str_ddr = $this->message_model->get_member_list();
		
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='NI-WEB')
		{
			$data1['tocken'] = $this->security->get_csrf_hash();
			$data1['status'] = 'success';
			$data1['dataStr'] = $str_ddr;
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}else{
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($str_ddr));
		}
	}
	
	function massages_list_api($page = 1)
	{
		$this->load->library('form_validation');
		$response["status"] = "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		$response["total_count"] = 0;
		$response["continue_request"] = false;
		$response["data"] = array();
		$this->form_validation->set_rules('matri_id','Matri id','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('matri_id');			
			$limit = 10;
			if(isset($_REQUEST["page_number"]) && $_REQUEST["page_number"]!='')
			{
				$page = $_REQUEST["page_number"];
			}
			$where_arr = " ((receiver='".$matri_id."' and trash_receiver = 'No' and receiver_delete='No') or ( sender='".$matri_id."' and trash_sender = 'No' and  sender_delete='No')) and receiver != 'admin' and sender != 'admin' and receiver != '' and sender != '' and status = 'sent' ";
			
			$this->db->group_by('otherID');
			$message_cnt 	= $this->common_model->get_count_data_manual("message",$where_arr,0,"id, IF(receiver='".$matri_id."', sender,receiver) AS otherID,  sent_on ",'id DESC');
			
			$this->db->group_by('otherID');
			$data = $this->common_model->get_count_data_manual("message",$where_arr,2,"id, IF(receiver='".$matri_id."', sender,receiver) AS otherID, content, sent_on ",'id DESC',$page,$limit);
			//echo $this->db->last_query();
			
			if(isset($message_cnt) && $message_cnt!='')
			{
				$response["total_count"] = $message_cnt;
			}
			$j=$i=0;
			
			if(isset($data) && $data!='' && is_array($data) && count($data)>0)
			{
				
				$data_current = array();
				$parampass = array('photo1' =>'assets/photos/');
				
				foreach($data as $data_list)
				{
					$where_user_is_valid = array('matri_id'=>$data[$i]['otherID']);
					$data_is_deleted = $this->common_model->get_count_data_manual("register",$where_user_is_valid,0);
					$i++;
					$j++;
					if($data_is_deleted<=0) 
					{
						$j--;
						continue;
					}

					$otherID = $data_list['otherID'];
					$data_list['unread_count'] = 0;
					if($otherID !='')
					{
						// for unread count
						$where_arr_temp = " (( sender='".$otherID."' and receiver='".$matri_id."' and trash_receiver = 'No' and receiver_delete='No') or (receiver='".$otherID."' and sender='".$matri_id."' and trash_sender = 'No' and  sender_delete='No')) and status = 'sent' ";
						$last_message_content = $this->common_model->get_count_data_manual("message",$where_arr_temp,1,'content,sent_on,id','id DESC');
						if(isset($last_message_content['content']) && $last_message_content['content'] !='')
						{
							$data_list['content'] = $last_message_content['content'];
						}
						
						//ADD THIS 14-03-2019 (START)
						if(isset($last_message_content['sent_on']) && $last_message_content['sent_on'] !='')
						{
							$data_list['sent_on'] = $last_message_content['sent_on'];
						}
						if(isset($last_message_content['id']) && $last_message_content['id'] !='')
						{
							$data_list['id'] = $last_message_content['id'];
						}
						//END

						$where_arr_msg_count = " ( receiver='".$matri_id."' and sender='".$otherID."' and trash_receiver = 'No' and receiver_delete='No' and read_status = 'No' ) and status = 'sent' ";
						$data_list['unread_count'] = $this->common_model->get_count_data_manual("message",$where_arr_msg_count,0);
						$data_list['photo_url'] = '';
						$data_list['birthdate'] = '';
						$data_list['height'] = '';
						// for photo and user detail
						$where_photoarr_1 = array('matri_id'=>$otherID);
						$opposite_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender , birthdate, height ");
						if(isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0)
						{
							//$opposite_user_photo = $this->common_model->member_photo_disp_opp($opposite_user_data);
							$data_list['photo_url'] = $this->common_model->member_photo_disp($opposite_user_data);
						}
					}
					
				
					$data_current[] = $data_list;
				}
				
				$response["total_count"]=$j;
				$data = $data_current;

				//for sorting array by id
				//add on 14-03-2019 start 
				foreach ($data as $key => $row)
				{
					$vc_array_name[$key] = $row['id'];
				}
				array_multisort($vc_array_name, SORT_DESC, $data);
				//end

				$response["data"] = $data;
				
				
				$response["statuscode"] = 200;
				$response["status"] = "success";
				$response["message"] = 'All conversation list';
				$response["errmessage"] = 'All conversation list';

				$response["continue_request"] = true;
			}
			else
			{
				$response["message"] = 'No conversation list availabel';
				$response["errmessage"] = 'No conversation list availabel';
			}			
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));

	}
	
	function conversation_list_api($page = 1)
	{
		$this->load->library('form_validation');
		$response["status"] 	= "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		$response["total_count"] = 0;

		//$response["continue_request"] = false;
		$response["current_user_data"] = array();
		$response["opposite_user_data"] = array();
		
		$response["data"] 		= $data = array();
		$this->form_validation->set_rules('matri_id','Matri ID','required');
		$this->form_validation->set_rules('other_id','Other User Matri ID','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('matri_id');
			$other_id=$this->input->post('other_id');
			$where_arr=(" ((receiver='".$matri_id."' and sender='".$other_id."' and trash_receiver = 'No' and receiver_delete='No') or ( receiver='".$other_id."' and sender='".$matri_id."' and trash_sender = 'No' and  sender_delete='No')) and status = 'sent' ");
			
			$message_cnt = $this->common_model->get_count_data_manual("message",$where_arr,0);
			$data = $this->common_model->get_count_data_manual("message",$where_arr,2,"*","id asc");
			
			if(isset($message_cnt) && $message_cnt > 0)
			{
				$response["total_count"] = $message_cnt;
			}
			
			//current user data
			$current_user_photo = '';
			$opposite_user_photo = '';
			
			$where_photoarr_1 = array('matri_id'=>$matri_id);
			$current_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender, logged_in  ");
			if(isset($current_user_data) && $current_user_data !='' && is_array($current_user_data) && count($current_user_data) > 0)
			{				
				if(isset($current_user_data['photo1']) && $current_user_data['photo1'] !='' && file_exists($this->common_model->path_photos.$current_user_data['photo1']))
				{
					$current_user_photo = base_url().$this->common_model->path_photos.$current_user_data['photo1'];
				}
				else
				{
					if(isset($current_user_data['gender']) && $current_user_data['gender'] =='Male')
					{
						$current_user_photo = base_url().'assets/front_end/images/icon/border-male.gif';
					}
					else
					{
						$current_user_photo = base_url().'assets/front_end/images/icon/border-female.gif';
					}
				}
				$current_user_data['photo_url'] = $current_user_photo;
				$response["current_user_data"] = $current_user_data;
			}
			
			$where_photoarr_1 = array('matri_id'=>$other_id);
			$opposite_user_data = $this->common_model->get_count_data_manual("register",$where_photoarr_1,1,"id, matri_id, photo1, photo1_approve, photo_view_status, photo_protect, photo_password, gender, logged_in ");
			if(isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0)
			{
				$opposite_user_photo = $this->common_model->member_photo_disp($opposite_user_data);
				$opposite_user_data['photo_url'] = $opposite_user_photo;
				$response["opposite_user_data"] = $opposite_user_data;
			}
			else
			{
				$response["opposite_user_data"] =(object)[];
			}
			if((isset($opposite_user_data) && $opposite_user_data !='' && is_array($opposite_user_data) && count($opposite_user_data) > 0) && (isset($current_user_data) && $current_user_data !='' && is_array($current_user_data) && count($current_user_data) > 0))
			{
				$response["status"] = "success";
				$response["statuscode"] = 200;
			}
			if(isset($data) && $data!='' && is_array($data) && count($data) > 0 )
			{
				$data_current = array();
				foreach($data as $data_val)
				{
					if($matri_id == $data_val['sender'])
					{
						$data_val['is_sent_receive'] = 'sent';
						$data_val['photo_url'] = $current_user_photo;
					}
					else
					{							
						$data_val['is_sent_receive'] = 'receive';
						$data_val['photo_url'] = $opposite_user_photo;
					}
					$data_current[] = $data_val;
				}
				$data = $data_current;
				$response["data"] = $data;
				$response["statuscode"] = 200;
				$response["status"] = "success";
				$response["message"] = 'All conversation list';
				$response["errmessage"] = 'All conversation list';
				//$response['continue_request'] = true;
				
				$where_arr_msg_count = " ( receiver='".$matri_id."' and sender='".$other_id."' and trash_receiver = 'No' and receiver_delete='No' and read_status = 'No' ) and status = 'sent' ";
				$data_array2 = array('read_status' => 'Yes');
				$this->common_model->update_insert_data_common('message', $data_array2,$where_arr_msg_count,1);
			}			
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));
	}
	
	function delete_user_message_list_api()
	{
		$this->load->library('form_validation');
		$response["status"] 	= "error";
		$response["statuscode"] = 300;
		$response["message"] 	= "Please try again";
		$response["errmessage"] 	= "Please try again";
		
		$this->form_validation->set_rules('matri_id','Matri ID','required');
		$this->form_validation->set_rules('other_id','Other User Matri ID','required');
		if($this->form_validation->run()==FALSE)
		{
			$response["message"] = strip_tags(validation_errors());
			$response["errmessage"] = strip_tags(validation_errors());
		}
		else
		{
			$matri_id=$this->input->post('matri_id');
			$other_id=$this->input->post('other_id');
			
			// for set status for receive message
			
			$where_arr_msg_count = " ( receiver='".$matri_id."' and sender='".$other_id."' and trash_receiver ='No' ) and status = 'sent' ";
			$data_array2 = array('trash_receiver' => 'Yes');
			$this->common_model->update_insert_data_common('message', $data_array2,$where_arr_msg_count,1);
			
			$where_arr_msg_count = " ( sender='".$matri_id."' and receiver='".$other_id."' and trash_sender ='No' ) and status = 'sent' ";
			$data_array2 = array('trash_sender' => 'Yes');
			$this->common_model->update_insert_data_common('message', $data_array2,$where_arr_msg_count,1);
				
			
			$response["status"] = "success";
			$response["statuscode"] = 200;
			$response["message"] = 'Message deleted successfully.';
			$response["errmessage"] = 'Message deleted successfully.';
		}
		$response["tocken"] = $this->security->get_csrf_hash();
		$this->output->set_output(json_encode($response));
	}
}