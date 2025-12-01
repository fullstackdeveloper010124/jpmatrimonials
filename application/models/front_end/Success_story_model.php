<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Success_story_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
	}
	public function add_success_story()
	{	
		$this->load->library('form_validation');
		$this->form_validation->set_rules('bridename', 'Bride\'s Name', 'required');
		$this->form_validation->set_rules('groomname', 'Groom\'s Name', 'required');
		$this->form_validation->set_rules('marriagedate', 'Marriage Date', 'required');
		$this->form_validation->set_rules('successmessage', 'How You Meet', 'required');
		if (empty($_FILES['weddingphoto'])) {
			$this->form_validation->set_rules('weddingphoto', 'Wedding Photo', 'required');
		}
		
		$this->form_validation->set_rules('terms_condition', 'Terms and Condition', 'required');
		if($this->form_validation->run() == FALSE){
			$error = validation_errors();
			$data1['errmessage'] = $error;
			$data1['status'] = 'error';
		}
		else{
			$_REQUEST['weddingphoto_path'] = $this->common_model->path_success;
			$this->common_model->set_table_name('success_story');
			$response = $this->common_model->save_update_data(1,1);
			//status unapprove
			$data = json_decode($response, true);		
			if(isset($data['status']) && $data['status'] =='success')
			{
				$data1['errmessage'] = 'Your story posted successfully and under approval';
			}
			else
			{
				$data1['errmessage'] = strip_tags($data['response']);
			}
			$data1['status'] = $data['status'];
		}
		$data1['token'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
	   	$this->load->view('common_file_echo',$data);
	}
	public function check_bride_groom()
	{	
		if(isset($_POST['type']) && $_POST['type']!='' && isset($_POST['matri_id']) && $_POST['matri_id']!='')
		{
			$type = $this->common_model->xss_clean($_POST['type']);
			$matri_id = $this->common_model->xss_clean($_POST['matri_id']);
			$where_data = array('is_deleted'=>'No','matri_id'=>$matri_id,'gender'=>$type);
			$member_detail = $this->common_model->get_count_data_manual('register',$where_data,1,'username');
			
			if(isset($member_detail) && $member_detail !='' && count($member_detail) > 0)
			{
				$data1['username'] = $member_detail['username'];
				$data1['status'] = 'success';
			}
			else
			{
				$data1['username'] = 'Please enter valid matri id';
				$data1['status'] = 'error';
			}
			$data1['token'] = $this->security->get_csrf_hash();
			$data['data'] = json_encode($data1);
			$this->load->view('common_file_echo',$data);
		}
	}
}
?>