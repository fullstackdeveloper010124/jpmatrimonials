<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Express_interest extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model('front_end/express_interest_model');
		$this->load->model('front_end/search_model');
		$this->common_front_model->checkLogin();
		$this->common_front_model->last_member_activity();
	}
	public function index($page=1)
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		$this->express_interest_model->check_for_update_status();
		
		$member_id = $this->common_front_model->get_user_id();
		
		if(isset($member_id) && $member_id!='')
		{	
			$this->common_front_model->set_orgin();
			$this->data['all_interest_sent_count'] = $this->express_interest_model->all_sent_interest(0);
			$this->data['all_interest_sent'] = $this->express_interest_model->all_sent_interest(1,$page);
			$all_interest_sent = $this->data['all_interest_sent'];
			$all_interest_sent_count = $this->data['all_interest_sent_count'];
			
			if($user_agent!='NI-WEB')
			{
				$data1['continue_request'] = TRUE;
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'success';
				$data1['total_count'] = $all_interest_sent_count;
				
				if(isset($all_interest_sent) && $all_interest_sent!='')
				{
					$data1['errormessage'] = 'Total Result found('.$all_interest_sent_count.')';
					$data1['errmessage'] = 'Total Result found('.$all_interest_sent_count.')';
					$data1['data'] = $this->common_front_model->process_data_app($all_interest_sent);
					//$data1['data'] = $all_interest_sent;
				}
				else
				{
					$data1['data'] = '';
					$data1['continue_request'] = FALSE;
				}
				$data['data'] = json_encode($data1);
				$this->load->view('common_file_echo',$data);
			}
			else
			{
				$is_ajax = 0;
				if($this->input->post('is_ajax') && $this->input->post('is_ajax') !='')
				{
					$is_ajax = $this->input->post('is_ajax');
				}
				$data['base_url'] = $this->data['base_url'];		
				if($is_ajax == 0)
				{	
					$this->common_model->extra_css_fr= array('css/popup_user.css');
					$this->common_model->extra_js_fr= array('js/photo_protect_js.js');
					$this->common_model->display_top_menu_perm ='No';
					$this->common_model->front_load_header('Express Interest');
					$this->load->view('front_end/express_interest',$this->data);
					$this->load->view('front_end/photo_protect',$this->data);
					$this->common_model->front_load_footer();
				}
				else
				{	
					$this->load->view('front_end/express_interest_result_ajax',$this->data);
				}
			}
		}
		else
		{
			if($user_agent !='NI-WEB')
			{
				$data1['tocken'] = $this->security->get_csrf_hash();
				$data1['status'] = 'error';
				$data1['errmessage'] =  "Sorry, Your session has been time out, Please login Again";
				$data['data'] = json_encode($data1);
				$this->load->view('common_file_echo',$data);
			}
			else
			{
				redirect($this->base_url.'login');
			}
		}
	}
	public function all_sent_receive($page=1)
	{
		/*$this->data['all_interest_sent_count'] = $this->express_interest_model->all_sent_interest(0);
		$this->data['all_interest_sent'] = $this->express_interest_model->all_sent_interest(1,$page);*/
		$this->index();
	}
	public function all_sent_receive_count()
	{
		//$data = array();
		$this->common_model->display_top_menu_perm ='No';
		$current_login_user = $this->common_front_model->get_session_data(); 
		$login_id = $current_login_user['matri_id'];
		$all = $this->common_model->get_count_data_manual('expressinterest',array("sender"=>$login_id),0,'','',0);
		$sent_accepted = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Accepted","sender"=>$login_id),0,'','',0);
		$sent_rejected = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Rejected","sender"=>$login_id),0,'','',0);
		$sent_pending = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Pending","sender"=>$login_id),0,'','',0);
		
		$all_rec = $this->common_model->get_count_data_manual('expressinterest',array("receiver"=>$login_id),0,'','',0);
		$rec_accepted = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Accepted","receiver"=>$login_id),0,'','',0);
		$rec_rejected = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Rejected","receiver"=>$login_id),0,'','',0);
		$rec_pending = $this->common_model->get_count_data_manual('expressinterest',array("receiver_response"=>"Pending","receiver"=>$login_id),0,'','',0);
		$counts_array = array();
		$counts_array = array('all'=>$all,'sent_accepted'=>$sent_accepted,'sent_rejected'=>$sent_rejected,'sent_pending'=>$sent_pending,'all_rec'=>$all_rec,'rec_accepted'=>$rec_accepted,'rec_rejected'=>$rec_rejected,'rec_pending'=>$rec_pending);
		if(isset($counts_array) && $counts_array!='' && is_array($counts_array) && count($counts_array)>0)
		{
			foreach($counts_array as $key=>$value)
			{
				$counts_array[$key] = sprintf("%02d", $value);
			}
			
		}
		//$data['data']=$counts_array;
		echo json_encode($counts_array);
		
	}
	
	public function action_update_status()
	{
		$this->common_front_model->set_orgin();
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		
		if($user_agent !='NI-WEB')
		{
			$member_id = $this->input->post('user_id');
		}else{
			$member_id = $this->common_front_model->get_user_id();
		}
		
		if(isset($member_id) && $member_id != '')
		{	
			$this->express_interest_model->check_for_update_status();
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
}