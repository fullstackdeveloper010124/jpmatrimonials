<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Sms_templates extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		$this->sms_templates();
	}

	public function sms_templates($status ='ALL', $page =1)
	{
		$ele_array = array(
			'template_name'=>array('is_required'=>'required'),
			'template_id'=>array('is_required'=>'required'),
			'sms_content'=>array('type'=>'textarea'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->common_rander('sms_templates', $status, $page , 'SMS Templates',$ele_array,'template_name',1);
	}
	
	public function sms_configuration($status ='')
	{
		$this->table_name = 'site_config'; 	// *need to set here tabel name //
		$this->common_model->set_table_name($this->table_name);
		
		$this->label_page = 'Update Sms Configuration';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'sms_api'=>array('is_required'=>'required','type'=>'textarea','placeholder'=>'Add ##contacts## for mobile number and ##sms_text## for message in your api url'),
				'sms_api_status'=>array('type'=>'radio')
			);
			$other_config = array('mode'=>'edit','id'=>'1');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	public function send_sms($status ='ALL', $page =1)
	{
		$ele_array = array(
			'member_list_sms'=>array('is_required'=>'required','label'=>'Select Member','placeholder'=>'Search Member by Matri Id, Name, Mobile Number','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'no'),
			'sms_content'=>array('type'=>'textarea','is_required'=>'required','label'=>'Message','placeholder'=>'Type your message here'),
		);				
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
		
		$this->common_model->js_extra_code.= "
			$(document).ready(function(){ get_suggestion_list('member_list_sms','Select Member') });
			
			";
		$other_conf = array('action'=>'sms-templates/send_sms_save');
		$this->common_model->common_rander('sms_templates', $status, $page , 'Send SMS To Member',$ele_array,'template_name',0,$other_conf);
	}
	public function send_sms_save()
	{
		$_REQUEST['is_ajax'] = 1;
		$this->common_model->set_table_name('sms_history');
		if(isset($_REQUEST['member_list_sms']) && $_REQUEST['member_list_sms'] !='')
		{
			$mobile_list = $_REQUEST['member_list_sms'];
			if(isset($mobile_list) && $mobile_list !='' && count($mobile_list) > 0)
			{
				foreach($mobile_list as $mobile_list_val)
				{
					if($mobile_list_val !='')
					{
						$_REQUEST['mobile'] = $mobile_list_val;
						$data = $this->common_model->save_update_data(0,1);
						$this->common_model->common_sms_send($_REQUEST['mobile'],$_REQUEST['sms_content']);			
					}
				}
				$this->session->set_userdata('success_message','Message Sent Successfully.');
			}
		}
		redirect($this->common_model->base_url_admin.'sms-templates/send_sms/add-data');
	}
}