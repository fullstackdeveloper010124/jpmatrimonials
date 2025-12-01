<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Lead_generation_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->common_model->session_search_name = 'member_search_session';
	}
	public function staff_list()
	{
		$staff_str = '<select name="assign_staff" id="assign_staff" class="form-control">
		<option value="">Select Staff</option>';
		$where_staff = array("is_deleted = 'No' AND status='APPROVED' ");
		$satff_arr = $this->common_model->get_count_data_manual('staff',$where_staff,2,'id,username','','','',"");
		if(isset($satff_arr) && $satff_arr!='' && is_array($satff_arr) && count($satff_arr)>0){
			foreach($satff_arr as $satff_arr_val){
				$staff_str.= '<option value='.$satff_arr_val['id'].'>'.$satff_arr_val['username'].'</option>';
			}
		}
		$staff_str.= '</select>';
		return $staff_str;
	}
	public function franchise_list()
	{
		$franchise_str = '<select name="assign_franchise" id="assign_franchise" class="form-control">
		<option value="">Select Franchise</option>';
		$where_franchise = array("is_deleted = 'No' AND status='APPROVED' ");
		$franchise_arr = $this->common_model->get_count_data_manual('franchise',$where_franchise,2,'id,username','','','',"");
		if(isset($franchise_arr) && $franchise_arr!='' && is_array($franchise_arr) && count($franchise_arr)>0){
			foreach($franchise_arr as $franchise_arr_val){
				$franchise_str .= '<option value='.$franchise_arr_val['id'].'>'.$franchise_arr_val['username'].'</option>';
			}
		}
		$franchise_str.= '</select>';
		return $franchise_str;
	}
	function get_data($id)
	{
		$data = '';
		if($id !='')
		{
			$where_arra = array('id'=>$id);
			$data = $this->common_model->get_count_data_manual('register_view',$where_arra,1,'');
		}
		return $data;
	}
	function lead_gen_list($status ='ALL', $page=1, $personal_where='')
	{

		$this->common_model->labelArr = array('phone_no_1'=>'Phone No. 1','phone_no_2'=>'Phone No. 2','phone_no_3'=>'Phone No. 3','phone_no_4'=>'Phone No. 4');
		$ele_array = array(
			'username'=>array('is_required'=>'required','label'=>'Name'),
			'email'=>array('is_required'=>'required','input_type'=>'email'),
			'gender'=>array('type'=>'radio','value_arr'=>array('Male'=>'Male','Female'=>'Female'),'value'=>'Male'),
			'address'=>array('type'=>'textarea'),
			'phone_no_1'=>array(),
			'phone_no_2'=>array(),
			'phone_no_3'=>array(),
			'phone_no_4'=>array(),
			'country'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'country_master','key_val'=>'id','key_disp'=>'country_name')),
			'interest'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>array('New Register'=>'New Register','Green'=>'Green','Blue'=>'Blue','Orange'=>'Orange','Red'=>'Red','Final Client'=>'Final Client','Incoming Call'=>'Incoming Call')),

		);
		$u_id = $this->common_model->get_session_data('id');
		$user_type = $this->common_model->get_session_user_type();
		if($user_type=='staff')
		{
			$user_type = 'Staff';
			$ele_array['staff_assign_id'] = array('input_type'=>'hidden','value'=>$u_id);
		}


		
		$this->common_model->created_on_fild = 'reg_date';
		$this->common_model->created_on_fild = 'next_followup_date';
		$this->common_model->js_validation_extra .= '
			rules: {
				username: {
				  lettersonly: true
				},
				phone_no_1: {
					number: true
				},
				phone_no_2: {
					number: true
				},
				phone_no_3: {
					number: true
				},
				phone_no_4: {
					number: true
				},
			},
		';

		$data_table = array(
			'title_disp'=>'username',
			'disp_status'=>'no',
			'disp_column_array'=> array('gender','email','address','country_name','phone_no_1','phone_no_2','phone_no_3','phone_no_4','reg_date','interest','assign_to_staff','assign_to_franchise','next_followup_date')
		);
		

	

		
		$where1 = "";
		if($status == 'Call' || $status == 'Green' || $status == 'Blue' || $status == 'Orange' || $status == 'Red' || $status == 'New'){
			$where1 = " interest!='' and interest = '".$status."'";
		}
		if($status == 'Final'){
			$where1 = " interest!='' and interest = 'Final Client'";
		}
		if($status == 'New'){
			$where1 = " interest!='' and interest = 'New Register'";
		}
		if($status == 'Call'){
			$where1 = " interest!='' and interest = 'Incoming Call'";
		}


		/*if($status == 'Pink'){
			$where1 = " interest!='' and interest = 'Yes'";
		}*/
		
		$this->common_model->status_field = '';
		$this->common_model->status_column = '';
		
		$access_perm_main = 'admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{

				$access_perm_main = $personal_where['access_perm'];
			}
		}
		
		$access_perm_edit = $this->common_model->check_permission('edit_lead_generation');
		if($access_perm_edit !='No')
		{
			 $edit_btn_arr = array('url'=>'lead-generation/lead-generation-list/edit-data/#id#','class'=>'info','label'=>'Edit Lead','target'=>'_blank');
			 if($access_perm_edit == 'Own Members')
			 {
				 $edit_btn_arr['own_only'] = 'yes';
			 }
			 $this->common_model->button_array[] = $edit_btn_arr;
		}
		$access_perm_viewcomm = $this->common_model->check_permission('lead_generation_view_comment');
		if($access_perm_viewcomm !='No')
		{
			$view_comment_btn_arr = array('onClick'=>"return lead_generation_comment(#id#)",'class'=>'warning','label'=>'View  Comment');
			if($access_perm_viewcomm == 'Own Members')
			{
				$view_comment_btn_arr['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $view_comment_btn_arr;
		}
		$access_perm_addcomm = $this->common_model->check_permission('lead_generation_add_comment');
		if($access_perm_addcomm !='No')
		{
			$add_comment_btn = array('onClick'=>"return lead_generation_add_comment(#id#)",'class'=>'primary','label'=>'Add Comment');
			if($access_perm_addcomm == 'Own Members')
			{
				$add_comment_btn['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $add_comment_btn;
		}
		
		$other_config = array(
			'load_member'=>'yes',
			'data_table_mem'=>$data_table,
			'default_order'=>'desc',
			'action'=>'lead-generation/save_lead',
			'field_duplicate'=>array('email'),
			'sort_column'=>array('reg_date'=>'Latest','username'=>'Name'),
			'hide_display_image' => 'no',
			'display_filter'=>'Yes',
			'disp_status'=>'no',
			'AllAllow'=>'no',
			'add_url'=>'lead-generation/lead-generation-list/add-data',
			'personal_where'=>$where1
		);
		
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
			{
				
				if($where1 == '')
				{
					$other_config['personal_where'] = $personal_where['where_per'];
				}
				else
				{
					$other_config['personal_where'] = $where1.' AND '.$personal_where['where_per'];
				}
			}
		}
		$access_perm = $this->common_model->check_permission('add_lead_generation');
		if($access_perm =='No')
		{
			$other_config['addAllow'] = 'no';
		}
		
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		// this pemission need parent permission also
		$this->display_filter_form();
		
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col = 7;
		$this->common_model->addPopup = 0;
		// echo "<pre>";
		// print_r($other_config);exit;
		$this->common_model->common_rander('leads_generation_view', $status, $page, 'Lead Generation', $ele_array, 'id', 0, $other_config);
		// echo $this->db->last_query();exit;
	}
	function save_new_update()
	{
		if(isset($_REQUEST['email']) && $_REQUEST['email'] !='')
		{
			$this->common_model->field_duplicate = array('email');
		}
		$this->common_model->created_on_fild = 'reg_date';
		
		$this->common_model->set_table_name('leads_generation');
		$data = $this->common_model->save_update_data(0,1);
		$data = json_decode($data);
		if(isset($data->status) && $data->status != '' && $data->status == 'success')
		{
			$this->session->set_flashdata('success_message',$data->response);
			if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='add')
			{
				$user_type = $this->common_model->get_session_user_type();
				$u_id = $this->common_model->get_session_data('id');
			
				$data_update_arr = array();
				if($user_type =='staff')
				{
					$data_update_arr['adminrole_id'] = $u_id;
				}
				else if($user_type =='franchise')
				{
					$data_update_arr['franchised_by'] = $u_id;
				}
				$insert_id = $this->common_model->last_insert_id;
				$config_data = $this->common_model->data['config_data'];
				$this->common_model->update_insert_data_common('leads_generation',$data_update_arr,array('id'=>$insert_id));
				//$this->session->set_flashdata('success_message','Data inserted successfully');
			}
			else
			{
				$insert_id = $_REQUEST['id'];
				//$this->session->set_flashdata('success_message','Data updated successfully');
			}
			return $insert_id;
		}
		else
		{
			$this->session->set_flashdata('error_message',$data->response);
			return '';
		}
	}
	function display_filter_form()
	{	
		$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;
		
		$ele_array = $this->lead_generation_model->get_filter_form_array();
		$other_config = array('mode'=>'add','id'=>'','action'=>'lead_generation/search_model','form_id'=>'form_model_search');
		$this->common_model->set_table_name('register');
		$data = $this->common_model->generate_form_main($ele_array,$other_config);
		$this->common_model->data['model_title_fil'] = 'Filter Data';
		$this->common_model->data['model_body_fil'] = $data;
	}
	function save_session_search()
	{		
		$where_search = array();
		if($this->input->post('gender') && $this->input->post('gender') !='' && $this->input->post('gender') !='All')
		{
			$gender = $this->input->post('gender');
			$where_search[]= " ( gender = '$gender' ) ";
		}
		if($this->input->post('keyword') && $this->input->post('keyword') !='')
		{
			$keyword = trim($this->input->post('keyword'));
			$where_search[]= " ( username like ( _latin1 '%$keyword%' ) or email like ( _latin1 '%$keyword%' ) or country_name like ( _latin1 '%$keyword%' ) ) ";
		}
		if($this->input->post('register_on') && $this->input->post('register_on') !='')
		{
			$register_on = $this->input->post('register_on');
			$where_search[]= " ( DATE_FORMAT(reg_date, '%Y-%m-%d') = '$register_on') ";
		}
		
		if($this->input->post('importance') && $this->input->post('importance') !='')
		{
			$importance = $this->input->post('importance');
			$where_search[]= " ( interest ='$importance' ) ";
		}
		
		if($this->input->post('assign_staff') && $this->input->post('assign_staff') !='')
		{
			$assign_staff = $this->input->post('assign_staff');
			$where_search[] = " (staff_assign_id = '$assign_staff') ";
		}
		if($this->input->post('assign_franchise') && $this->input->post('assign_franchise') !='')
		{
			$assign_franchise = $this->input->post('assign_franchise');
			$where_search[] = " ( franchise_assign_id = '$assign_franchise') ";
		}
		
		if($this->input->post('country') && $this->input->post('country') !='')
		{
			$country = $this->input->post('country');
			$country = $this->common_model->trim_array_remove($country);
			if(isset($country) && count($country) > 0)
			{
				$country_str = implode("','",$country);
				$where_search[]= " ( country in ('$country_str') ) ";
			}
		}
		
		$where_search_str = '';
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
		}
		if($this->common_model->session_search_name !='')
		{
			$this->session->set_userdata($this->common_model->session_search_name,$where_search_str);
		}
		
		$this->common_model->return_tocken_clear();
	}
	
	public function save_comment()
	{
		$user_type = $this->common_model->get_session_user_type();
		$u_id = $this->common_model->get_session_data('id');
		$member_comment = '';
		$hidd_user_id = '';
		$next_followup_date = '';
		$lead_comment = '';
		if($this->input->post('lead_comment'))
		{
			$lead_comment = $this->input->post('lead_comment');
		}
		if($this->input->post('next_followup_date'))
		{
			$next_followup_date = $this->input->post('next_followup_date');
		}
		if($this->input->post('hidd_user_id'))
		{
			$hidd_user_id = $this->input->post('hidd_user_id');
		}
		if($lead_comment =='')
		{
			$this->session->set_flashdata('error_message',"Please enter Comment");
			return;
		}
		if($next_followup_date == '')
		{
			$this->session->set_flashdata('error_message',"Please select Next Followup Date");
			return;
		}
		if($hidd_user_id == '')
		{
			$this->session->set_flashdata('error_message',$this->common_model->success_message['error']);
			return;
		}
		$CurrentDate = $this->common_model->getCurrentDate();
		$data_array_new = array(
			'follow_up_status'=>'0',
		);
		$this->common_model->update_insert_data_common("comments_of_lead_generation",$data_array_new,array('index_id'=>$hidd_user_id),1,'0');
		if($user_type != 'admin'){
			$this->common_model->update_insert_data_common("leads_generation",array('commented'=>'1','followup_date'=>$next_followup_date),array('id'=>$hidd_user_id),1,'0');
			//echo $this->db->last_query();
		}
		$data_array = array(
			'index_id'=>$hidd_user_id,
			'posted_user_type'=>$user_type,
			'posted_by'=>$u_id,
			'comment'=>$lead_comment,
			'created_on'=>$CurrentDate,
			'next_followup_date'=>$next_followup_date,
			'follow_up_status'=>'1',
		);
		$response = $this->common_model->update_insert_data_common("comments_of_lead_generation",$data_array,'',0);
		if($response)
		{
			$this->session->set_flashdata('success_message',"Comment Added Successfully");
		}
		else
		{
			$this->session->set_flashdata('error_message', $this->common_model->success_message['error']);
		}
	}
	
	function filter_form_array()
	{
		$this->common_model->extra_css[] = 'vendor/chosen_v1.4.0/chosen.min.css';
		$this->common_model->extra_js[] = 'vendor/chosen_v1.4.0/chosen.jquery.min.js';
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->js_extra_code.= " var config = {
			'.chosen-select': {},
			'.chosen-select-deselect': { allow_single_deselect: true },
			'.chosen-select-no-single': { disable_search_threshold: 10 },
			'.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
			'.chosen-select-width': { width: '100%' }			
			};
			$('#country').chosen({placeholder_text_multiple:'Select Country'});
		";
		$reg_date_rang = '<div class="col-sm-12 col-lg-12 pl0 paddin-mobile">
			<input type="text" name="from_reg_date" id="from_reg_date" class="form-control datepicker">
			</div>';
			
		$this->common_model->js_extra_code.= " 
			$(function(){
				$('#register_on').datepicker({ 
              		todayHighlight: true
   				})
			})
			$(function(){
				$('#next_followup_date').datepicker({ 
              		todayHighlight: true
   				})
			})";
		$staff_arr = $this->staff_list();
		$franchise_arr = $this->franchise_list();
		$assign_from = '
			<div class="form-group">
				<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Select Staff</label>
				<div class="col-sm-9 col-lg-9">
					<div class="col-sm-12 col-lg-12 pl0 paddin-mobile">
						'.$staff_arr.'
					</div>			  
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Select Franchise</label>
				<div class="col-sm-9 col-lg-9">
					<div class="col-sm-12 col-lg-12 pl0 paddin-mobile">
						'.$franchise_arr.'
					</div>			  
				</div>
			</div>
			<input type="hidden" value="" name="assign_from_hidden">';
		$ele_array = array(
			'keyword'=>array('display_in'=>'2','placeholder'=>'Search with Name, Email, Country Name..'),			
			'gender'=>array('display_in'=>'2','type'=>'radio','value_arr'=>array('Male'=>'Male','Female'=>'Female')),
			'register_on'=>array('display_in'=>'2','class'=>'datepicker'),
			//'registered_with_in'=>array('display_in'=>'2','type'=>'dropdown','value_arr'=>array()),
			'importance'=>array('display_in'=>'2','type'=>'dropdown','value_arr'=>array('New Register'=>'New Register','Green'=>'Green','Blue'=>'Blue','Orange'=>'Orange','Red'=>'Red','Final Client'=>'Final Client','Incoming Call'=>'Incoming Call')),
			'assign_from'=>array('display_in'=>'2','type'=>'manual','code'=>$assign_from),
			'country'=>array('display_in'=>'2','type'=>'dropdown','relation'=>array('rel_table'=>'country_master','key_val'=>'id','key_disp'=>'country_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'next_followup_date'=>array('display_in'=>'2','class'=>'datepicker'),
		);
		return $ele_array;
	}
	
	function get_filter_form_array($type=0)
	{
		$return_value=array();
		$advanced_search_array = $this->lead_generation_model->filter_form_array();
		//print_r($advanced_search_array);
		foreach($advanced_search_array as $advanced_search_key=>$advanced_search_val)
		{
			$display_in= $advanced_search_val['display_in'];
			if($display_in==$type || $display_in=='2')
			{
				$return_value[$advanced_search_key] = $advanced_search_val;
			}
		}
		return $return_value;
	}
	/* for mega matrimony*/
}
?>