<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Bulk_email_sms extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		//$access_perm = $this->common_model->check_permission('send_mail','redirect');
	}
	/*public function index()
	{
		$this->send_email('add-data');
	}*/
	public function send_email($status ='ALL', $page =1)
	{		
		$status = 'add-data';
		$ele_array = array(
			'status'=>array('is_required'=>'required','placeholder'=>'','type'=>'dropdown','value_arr'=>array('All'=>'All','Active'=>'Active','Inactive'=>'Inactive','Paid'=>'Paid'),'onchange'=>'change_after_staus()'),
			'all_single'=>array('is_required'=>'required','label'=>'All or single','placeholder'=>'','type'=>'dropdown','value_arr'=>array('All'=>'All','Single'=>'Single'),'onchange'=>'get_email_list()',),
			'member_list_email'=>array('is_required'=>'required','label'=>'Select Multiple Email','placeholder'=>'Search Member by Email','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'no','form_group_class'=>'member_list_email'),
			'email_subject'=>array('is_required'=>'required'),
			'email_content'=>array('is_required'=>'required','type'=>'textarea'),
		);
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->js_extra_code.= "
			if($('#email_content').length > 0){
				$('.email_content_edit').removeClass(' col-lg-7 ');
				$('.email_content_edit').addClass('col-lg-10 ');
				CKEDITOR.replace( 'email_content' );
			} 
			var all_single = $('#all_single').val();
			if(all_single == 'Single'){
				$('.member_list_email').show();
			}
			else{
				$('.member_list_email').hide();
				$('#member_list_email').val('');
			}
			function get_email_list(){	
			    var status = $('#status').val();
				if(status==''){
					alert('Please Select Status');
					$('#all_single').val('');
				}else{	
			        get_suggestion_list('member_list_email','Select Member',status);
				}
				var all_single = $('#all_single').val();
				if(all_single == 'Single'){
					$('.member_list_email').show();
				}
				else{
					$('.member_list_email').hide();
					$('#member_list_email').val('');
				}
			} 
			function change_after_staus(){
				$('#all_single').val('');
				$('.member_list_email').hide();
				$('#member_list_email').val('');
			}";
		$other_conf = array('action'=>'bulk-email-sms/send-email-save');
		$this->common_model->common_rander('sms_templates', $status, $page, 'Send Bulk Email To Members', $ele_array, 'template_name',0, $other_conf);
	}
	public function send_email_save()
	{
		if(isset($_REQUEST) && $_REQUEST!=''){
			if(isset($_REQUEST['status']) && $_REQUEST['status']!=''){
				$status = $_REQUEST['status'];
			}
			if(isset($_REQUEST['email_subject']) && $_REQUEST['email_subject']!=''){
				$email_subject = $_REQUEST['email_subject'];
			}
			if(isset($_REQUEST['email_content']) && $_REQUEST['email_content']!=''){
				$email_content = $_REQUEST['email_content'];
			}
	    }
		if(isset($status) && $status!='' && $status=='All'){
			$where = array("is_deleted"=>"No");
		}
		else if(isset($status) && $status!='' && $status=='Active'){
			$where = array("is_deleted"=>"No","status"=>"APPROVED");
		}
		else if(isset($status) && $status!='' && $status=='Inactive'){
			$where = array("is_deleted"=>"No","status"=>"UNAPPROVED");
		}
		else if(isset($status) && $status!='' && $status=='Paid'){
			$where = array("is_deleted"=>"No","plan_status"=>"Paid");
		}
		$email_list_data = $this->common_front_model->get_count_data_manual('register',$where,'2','email');
		$email_list = array_map('current',$email_list_data);
		
		if($_REQUEST['all_single']=='All'){
			if(isset($email_list) && $email_list !=''){
				if(isset($email_list) && $email_list !='' && is_array($email_list) && count($email_list) > 0){
					foreach($email_list as $email){
						$data_array_custom = array('email'=>$email,'email_subject'=>$email_subject,'email_content'=>$email_content);
						$this->common_front_model->save_update_data('send_bulk_email',$data_array_custom,'id','add','','','1','1');
					}
					$this->session->set_flashdata('success_message','Email Sent Successfully.');
				}
			}
		}
		
		if($_REQUEST['all_single']=='Single'){
			if(isset($_REQUEST['member_list_email']) && $_REQUEST['member_list_email']!=''){
				$member_list_email = $_REQUEST['member_list_email'];
				if(isset($member_list_email) && $member_list_email !='' && is_array($member_list_email) && count($member_list_email) > 0){
					foreach($member_list_email as $email1){						
						$data_array_custom = array('email'=>$email1,'email_subject'=>$email_subject,'email_content'=>$email_content);
						$this->common_front_model->save_update_data('send_bulk_email',$data_array_custom,'id','add','','','1','1');
					}
				}
				$this->session->set_flashdata('success_message','Email Sent Successfully.');
			}
		}
		redirect($this->common_model->base_url_admin.'bulk-email-sms/send-email');
	}
	
	public function send_sms($status ='ALL', $page =1)
	{		
		$status = 'add-data';
		$ele_array = array(
			'status'=>array('is_required'=>'required','placeholder'=>'','type'=>'dropdown','value_arr'=>array('All'=>'All','Active'=>'Active','Inactive'=>'Inactive','Paid'=>'Paid'),'onchange'=>'change_after_staus()'),
			'all_single'=>array('is_required'=>'required','label'=>'All or single','placeholder'=>'','type'=>'dropdown','value_arr'=>array('All'=>'All','Single'=>'Single'),'onchange'=>'get_sms_list()',),
			'member_list_sms'=>array('is_required'=>'required','label'=>'Select Multiple SMS','placeholder'=>'Search Member by Matri Id','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'no','form_group_class'=>'member_list_sms'),
			'sms_content'=>array('is_required'=>'required','type'=>'textarea'),
		);
		$this->common_model->extra_css[] = 'vendor/select2/select2.min.css';
		$this->common_model->extra_js[] = 'vendor/select2/select2.min.js';
		$this->common_model->js_extra_code.= "
			var all_single = $('#all_single').val();
			if(all_single == 'Single'){
				$('.member_list_sms').show();
			}
			else{
				$('.member_list_sms').hide();
				$('#member_list_sms').val('');
			}
			function get_sms_list(){	
			    var status = $('#status').val();
				if(status==''){
					alert('Please Select Status');
					$('#all_single').val('');
				}else{	
			        get_suggestion_list('member_list_sms','Select Member',status);
				}
				var all_single = $('#all_single').val();
				if(all_single == 'Single'){
					$('.member_list_sms').show();
				}
				else{
					$('.member_list_sms').hide();
					$('#member_list_sms').val('');
				}
			} 
			function change_after_staus(){
				$('#all_single').val('');
				$('.member_list_sms').hide();
				$('#member_list_sms').val('');
			}";
		$other_conf = array('action'=>'bulk-email-sms/send-sms-save');
		$this->common_model->common_rander('sms_templates', $status, $page, 'Send Bulk SMS To Members', $ele_array, 'template_name',0, $other_conf);
	}
	
	public function send_sms_save()
	{
		if(isset($_REQUEST) && $_REQUEST!=''){
			if(isset($_REQUEST['status']) && $_REQUEST['status']!=''){
				$status = $_REQUEST['status'];
			}
			if(isset($_REQUEST['sms_content']) && $_REQUEST['sms_content']!=''){
				$sms_content = $_REQUEST['sms_content'];
			}		
	    }
		if(isset($status) && $status!='' && $status=='All'){
			$where = array("is_deleted"=>"No");
		}
		else if(isset($status) && $status!='' && $status=='Active'){
			$where = array("is_deleted"=>"No","status"=>"APPROVED");
		}
		else if(isset($status) && $status!='' && $status=='Inactive'){
			$where = array("is_deleted"=>"No","status"=>"UNAPPROVED");
		}
		else if(isset($status) && $status!='' && $status=='Paid'){
			$where = array("is_deleted"=>"No","plan_status"=>"Paid");
		}
		$sms_list_data = $this->common_front_model->get_count_data_manual('register',$where,'2','mobile');
		$sms_list = array_map('current',$sms_list_data);
		
		if($_REQUEST['all_single']=='All'){
			if(isset($sms_list) && $sms_list !=''){
				$config_arra = $this->common_model->get_site_config();
				$to_email = $config_arra['contact_email'];	
				if(isset($sms_list) && $sms_list !='' && is_array($sms_list) && count($sms_list) > 0){
					foreach($sms_list as $sms){
						$data_array_custom = array('sms_mobile'=>$sms,'sms_content'=>$sms_content);
						$this->common_front_model->save_update_data('send_bulk_sms',$data_array_custom,'id','add','','','1','1');
					}
					$this->session->set_flashdata('success_message','SMS Sent Successfully.');
				}
			}
		}
		
		if($_REQUEST['all_single']=='Single'){
			if(isset($_REQUEST['member_list_sms']) && $_REQUEST['member_list_sms']!=''){
				$member_list_sms = $_REQUEST['member_list_sms'];
				if($member_list_sms !='' && is_array($member_list_sms) && count($member_list_sms) > 0){
					foreach($member_list_sms as $sms){
						$data_array_custom = array('sms_mobile'=>$sms,'sms_content'=>$sms_content);
						$this->common_front_model->save_update_data('send_bulk_sms',$data_array_custom,'id','add','','','1','1');
					}
				}
				$this->session->set_flashdata('success_message','SMS Sent Successfully.');
			}
		}
		redirect($this->common_model->base_url_admin.'bulk-email-sms/send-sms');
	}
}
?>