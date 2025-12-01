<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Assignment_reports_model extends CI_Model {
	public $search_for_table_name;
	public $member_lead_generation;
	public function __construct()
	{
		parent::__construct();
		$this->common_model->session_search_name = 'member_search_session';
		$this->search_for_table_name = '';
		$this->member_lead_generation = '';
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
	function unassigned_member_list($status ='ALL', $page =1,$personal_where='',$table='')
	{
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->labelArr =  array('assign_by'=>'Unassign By','assign_to_name'=>'Assign From','assign_date'=>'Unassign Date','action'=>'Currently Assign');
		$this->common_model->created_on_fild = 'registered_on';
		$this->common_model->created_on_fild = 'assign_date';
		$data_table = array(
			'title_disp'=>'username',
			'disp_status'=>'no',
			'post_title_disp'=>'matri_id',
			'disp_column_array'=> array('assign_by','email','registered_on','assign_date','assign_to_name','action')
		);
		$access_perm_main ='admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{
				$access_perm_main = $personal_where['access_perm'];
			}
		}
		$other_config = array(
			'load_member'=>'yes',
			'data_table_mem'=>$data_table,
			'default_order'=>'desc',
			'action'=>'member/save_member',
			'field_duplicate'=>array('email','mobile'),
			'sort_column'=>array('assign_date'=>'Latest','last_login'=>'Last Login','username'=>'Name'),
			'display_filter'=>'Yes',
			'add_url'=>'member/member_list/add-data',
			'addAllow' => 'no',
			'deleteAllow' => 'no',
			'hide_display_image' => 'no',
		);
		if(isset($table) && $table=='staff'){
			$label_disp = 'Unassigned Members From Staff';
		}
		else if(isset($table) && $table=='franchise'){
			$label_disp = 'Unassigned Members From Franchise';
		}

		if(isset($personal_where['label_disp']) && $personal_where['label_disp'] == 'Franchise Member'){
			$other_config['addAllow'] = 'no';
		}
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
			{
				$other_config['personal_where'] = $personal_where['where_per'];
			}
			if(isset($personal_where['label_disp']) && $personal_where['label_disp'] !='')
			{
				$label_disp = $personal_where['label_disp'];
			}
		}
		$this->search_for_table_name = $table;
		$this->display_filter_form();
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col =7;
		$this->common_model->addPopup = 0;
		$this->common_model->common_rander('member_assign_history_view', $status, $page ,$label_disp ,'','assign_date',0,$other_config);
	}
	function unassigned_lead_generation_list($status ='ALL', $page =1,$personal_where='',$table='')
	{
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->labelArr =  array('assign_by'=>'Unassign By','assign_to_name'=>'Assign From','assign_date'=>'Unassign Date','action'=>'Currently Assign');
		$this->common_model->created_on_fild = 'registered_on';
		$this->common_model->created_on_fild = 'assign_date';
		$data_table = array(
			'title_disp'=>'username',
			'disp_status'=>'no',
			'post_title_disp'=>'matri_id',
			'disp_column_array'=> array('assign_by','email','registered_on','assign_date','assign_to_name','action','country_name')
		);
		$access_perm_main ='admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{
				$access_perm_main = $personal_where['access_perm'];
			}
		}
		$other_config = array(
			'load_member'=>'yes',
			'data_table_mem'=>$data_table,
			'default_order'=>'desc',
			'action'=>'member/save_member',
			'field_duplicate'=>array('email','mobile'),
			'sort_column'=>array('assign_date'=>'Latest','username'=>'Name'),
			'display_filter'=>'Yes',
			'add_url'=>'member/member_list/add-data',
			'addAllow' => 'no',
			'deleteAllow' => 'no',
			'hide_display_image' => 'no',
		);
		if(isset($table) && $table=='staff'){
			$label_disp = 'Unassigned Lead Generation From Staff';
		}
		else if(isset($table) && $table=='franchise'){
			$label_disp = 'Unassigned Lead Generation From Franchise';
		}

		if(isset($personal_where['label_disp']) && $personal_where['label_disp'] == 'Franchise Member'){
			$other_config['addAllow'] = 'no';
		}
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
			{
				$other_config['personal_where'] = $personal_where['where_per'];
			}
			if(isset($personal_where['label_disp']) && $personal_where['label_disp'] !='')
			{
				$label_disp = $personal_where['label_disp'];
			}
		}
		$this->member_lead_generation = 'lead_generation';
		$this->search_for_table_name = $table;
		$this->display_filter_form();
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col =7;
		$this->common_model->addPopup = 0;
		$this->common_model->common_rander('lead_generation_assign_history_view', $status, $page ,$label_disp ,'','assign_date',0,$other_config);
	}
	
	function follow_up_report($status = 'Next', $page = 1,$personal_where = '')
	{
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->labelArr =  array('created_on'=>'Commented On','next_followup_date'=>'Followup Date','assign_to_staff'=>'Assigned To Staff','assign_to_franchise'=>'Assigned To Franchise');
		$this->common_model->created_on_fild = 'registered_on';
		$this->common_model->created_on_fild = 'created_on';
		$user_type = $this->common_model->get_session_user_type();
		if($user_type=='admin'){
			$col_array = array('gender','email','mobile','country_name','registered_on','last_login','assign_to_staff','assign_to_franchise','next_followup_date','created_on','comment');
		}
		else{
			$col_array = array('gender','email','mobile','country_name','registered_on','last_login','next_followup_date','created_on','comment');
		}
		$data_table = array(
			'title_disp'=>'username',
			'post_title_disp'=>'matri_id',
			'disp_column_array'=> $col_array
		);
		
		$today = $this->common_model->getCurrentDate('Y-m-d');
		$table = 'followup_system_view';
		$order_by = 'created_on';
		$where1 = "";
		if($status == 'Today'){
			$where1 = " next_followup_date!='' and next_followup_date = '".$today."'";
		}
		if($status == 'Previous'){
			$where1 = " next_followup_date!='' and next_followup_date < '".$today."'";
		}
		if($status == 'Next'){
			$where1 = " next_followup_date!='' and next_followup_date > '".$today."'";
		}
		if($status == 'Pending'){
			$where1 = " commented='0' and ( staff_assign_id!='' or franchise_assign_id!='') ";
			$table = 'register';
			$order_by = 'registered_on';
		}
		$this->common_model->status_field = '';
		$this->common_model->status_column = '';
		$access_perm_main ='admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{
				$access_perm_main = $personal_where['access_perm'];
			}
		}
		$other_config = array('load_member'=>'yes',
			'data_table_mem'=>$data_table,
			'default_order'=>'desc',
			'action'=>'member/save_member',
			'field_duplicate'=>array('email','mobile'),
			'sort_column'=>array('registered_on'=>'Latest','last_login'=>'Last Login','username'=>'Name'),
			'display_image'=>'photo1',
			'photo1'=>$this->common_model->path_photos,
			'display_filter'=>'Yes',
			'add_url'=>'member/member_list/add-data',
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'deleteAllow'=>'no',
			'AllAllow'=>'no',
			'personal_where'=>$where1,
		);
		
		$label_disp = 'Followed Up Member Report';
		$access_perm_view = $this->common_model->check_permission('view_profile');
		if($access_perm_view !='No')
		{
			$view_btn_arr = array('url'=>'member/member_detail/#id#','class'=>'primary','label'=>'View Profile','target'=>'_blank');
			if($access_perm_view =='Own Members')
			{
				$view_btn_arr['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $view_btn_arr;
		}
		$access_perm_viewcomm = $this->common_model->check_permission('view_comment');
		if($access_perm_viewcomm !='No')
		{
			$view_comment_btn_arr = array('onClick'=>"return display_comment(#id#)",'class'=>'warning','label'=>'View  Comment');
			if($access_perm_viewcomm =='Own Members')
			{
				$view_comment_btn_arr['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $view_comment_btn_arr;
		}
		$access_perm_addcomm = $this->common_model->check_permission('add_comment');
		if($access_perm_addcomm !='No')
		{
			$add_comment_btn = array('onClick'=>"return display_add_comment(#id#)",'class'=>'primary','label'=>'Add Comment');
			if($access_perm_addcomm =='Own Members')
			{
				$add_comment_btn['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $add_comment_btn;
		}
		if(isset($personal_where['label_disp']) && $personal_where['label_disp'] == 'Franchise Member'){
			$other_config['addAllow'] = 'no';
		}
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
			{
				$other_config['personal_where'] = $personal_where['where_per'];
			}
			if(isset($personal_where['label_disp']) && $personal_where['label_disp'] !='')
			{
				$label_disp = $personal_where['label_disp'];
			}
		}
		$this->search_for_table_name = 'followup';
		$this->display_filter_form();
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col = 7;
		$this->common_model->is_delete_fild = '';
		$this->common_model->common_rander($table, $status, $page, $label_disp, '', $order_by, 0, $other_config);
	}
	
	function lead_follow_up_report($status = 'Next', $page = 1,$personal_where = '')
	{
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$this->common_model->labelArr =  array('created_on'=>'Commented On','next_followup_date'=>'Followup Date','assign_to_staff'=>'Assigned To Staff','assign_to_franchise'=>'Assigned To Franchise');
		$this->common_model->created_on_fild = 'registered_on';
		$this->common_model->created_on_fild = 'created_on';
		$user_type = $this->common_model->get_session_user_type();
		if($user_type=='admin'){
			$col_array = array('gender','email','country_name','registered_on','assign_to_staff','assign_to_franchise','next_followup_date','created_on','comment');
		}
		else{
			$col_array = array('gender','email','country_name','registered_on','next_followup_date','created_on','comment');
		}
		$data_table = array(
			'title_disp'=>'username',
			'disp_status'=>'no',
			'disp_column_array'=> $col_array
		);
		
		$today = $this->common_model->getCurrentDate('Y-m-d');
		$table = 'lead_generation_followup_system_view';
		$order_by = 'created_on';
		$where1 = "";
		if($status == 'Today'){
			$where1 = " next_followup_date!='' and next_followup_date = '".$today."'";
		}
		if($status == 'Previous'){
			$where1 = " next_followup_date!='' and next_followup_date < '".$today."'";
		}
		if($status == 'Next'){
			$where1 = " next_followup_date!='' and next_followup_date > '".$today."'";
		}
		if($status == 'Pending'){
			$where1 = " commented='0' and ( staff_assign_id!='' or franchise_assign_id!='') ";
			$table = 'leads_generation_view';
			$order_by = 'reg_date';
		}
		$this->common_model->status_field = '';
		$this->common_model->status_column = '';
		
		$access_perm_main ='admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{
				$access_perm_main = $personal_where['access_perm'];
			}
		}
		$other_config = array('load_member'=>'yes',
			'data_table_mem'=>$data_table,
			'default_order'=>'desc',
			'action'=>'member/save_member',
			'field_duplicate'=>array('email','mobile'),
			'sort_column'=>array('registered_on'=>'Latest','last_login'=>'Last Login','username'=>'Name'),
			'hide_display_image' => 'no',
			'display_filter'=>'Yes',
			'add_url'=>'member/member_list/add-data',
			'addAllow'=>'no',
			'editAllow'=>'no',
			'default_order'=>'desc',
			'deleteAllow'=>'no',
			'AllAllow'=>'no',
			'personal_where'=>$where1,
		);
		
		$label_disp = 'Followed Up Lead Generation Report';
		
		$access_perm_viewcomm = $this->common_model->check_permission('view_comment');
		if($access_perm_viewcomm !='No')
		{
			$view_comment_btn_arr = array('onClick'=>"return lead_generation_comment(#id#)",'class'=>'warning','label'=>'View  Comment');
			if($access_perm_viewcomm =='Own Members')
			{
				$view_comment_btn_arr['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $view_comment_btn_arr;
		}
		$access_perm_addcomm = $this->common_model->check_permission('add_comment');
		if($access_perm_addcomm !='No')
		{
			$add_comment_btn = array('onClick'=>"return lead_generation_add_comment(#id#)",'class'=>'primary','label'=>'Add Comment');
			if($access_perm_addcomm =='Own Members')
			{
				$add_comment_btn['own_only'] = 'yes';
			}
			$this->common_model->button_array[] = $add_comment_btn;
		}
		if(isset($personal_where['label_disp']) && $personal_where['label_disp'] == 'Franchise Member'){
			$other_config['addAllow'] = 'no';
		}
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['where_per']) && $personal_where['where_per'] !='')
			{
				$other_config['personal_where'] = $personal_where['where_per'];
			}
			if(isset($personal_where['label_disp']) && $personal_where['label_disp'] !='')
			{
				$label_disp = $personal_where['label_disp'];
			}
		}
		$this->search_for_table_name = 'followup';
		$this->member_lead_generation = 'lead_generation';
		$this->display_filter_form();
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col = 7;
		$this->common_model->is_delete_fild = '';
		$this->common_model->common_rander($table, $status, $page, $label_disp, '', $order_by, 0, $other_config);
	}
	function save_session_search()
	{		
		$where_search = array();
		if($this->input->post('assign_from_hidden') && $this->input->post('assign_from_hidden') == 'followup'){
			if(($this->input->post('from_reg_date') && $this->input->post('from_reg_date') !='') && ($this->input->post('to_reg_date') && $this->input->post('to_reg_date') !=''))
			{
				$from_reg_date = $this->input->post('from_reg_date');
				$to_reg_date = $this->input->post('to_reg_date');
				$where_search[] = " ( ( DATE_FORMAT(staff_assign_date, '%Y-%m-%d') >='$from_reg_date') and ( DATE_FORMAT(staff_assign_date, '%Y-%m-%d') <='$to_reg_date') or ( DATE_FORMAT(franchise_assign_date, '%Y-%m-%d') >='$from_reg_date') and ( DATE_FORMAT(franchise_assign_date, '%Y-%m-%d') <='$to_reg_date') )";
			}
		}else{
			if($this->input->post('assign_from_hidden') && $this->input->post('assign_from_hidden') == 'staff'){
				$feild = 'staff_assign_date';
			}
			else if($this->input->post('assign_from_hidden') && $this->input->post('assign_from_hidden') == 'franchise'){
				$feild = 'franchise_assign_date';
			}
			
			if($this->input->post('from_reg_date') && $this->input->post('from_reg_date') !='')
			{
				$from_reg_date = $this->input->post('from_reg_date');
				$where_search[] = " ( DATE_FORMAT(".$feild.", '%Y-%m-%d') >='$from_reg_date') ";
			}
			if($this->input->post('to_reg_date') && $this->input->post('to_reg_date') !='')
			{
				$to_reg_date = $this->input->post('to_reg_date');
				$where_search[]= " ( DATE_FORMAT(".$feild.", '%Y-%m-%d') <='$to_reg_date') ";
			}
		}
		if($this->input->post('assign_staff') && $this->input->post('assign_staff') !='')
		{
			$assign_staff = $this->input->post('assign_staff');
			if(isset($assign_staff) && $assign_staff!='')
			{
				if($this->input->post('assign_from_hidden') && $this->input->post('assign_from_hidden') == 'staff'){
					$where_search[] = " ( assign_to = '$assign_staff' and user_type = 'Staff') ";
				}
				else{
					$where_search[] = " (staff_assign_id = '$assign_staff') ";
				}
			}
		}
		if($this->input->post('assign_franchise') && $this->input->post('assign_franchise') !='')
		{
			$assign_franchise = $this->input->post('assign_franchise');
			if(isset($assign_franchise) && $assign_franchise!='')
			{
				if($this->input->post('assign_from_hidden') && $this->input->post('assign_from_hidden') == 'franchise'){
					$where_search[] = " ( assign_to = '$assign_franchise' and user_type = 'Franchise') ";
				}
				else{
					$where_search[] = " ( franchise_assign_id = '$assign_franchise') ";
				}
			}
		}
		
		if($this->input->post('keyword') && $this->input->post('keyword') !='')
		{
			$keyword = trim($this->input->post('keyword'));
			if($this->input->post('keyword_type') == 'lead_generation'){
				$where_search[]= " ( email like ( _latin1 '%$keyword%' ) or country_name like ( _latin1 '%$keyword%' ) ) ";
			}
			else{
				$where_search[]= " ( matri_id like ( _latin1 '%$keyword%' ) or email like ( _latin1 '%$keyword%' ) ) ";
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
	
	function filter_form_array()
	{
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
		";
		$reg_date_rang = '<div class="col-sm-5 col-lg-5 pl0 paddin-mobile">
			<input type="text" name="from_reg_date" id="from_reg_date" class="form-control datepicker">
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0 paddin-mobile">
			<input type="text" name="to_reg_date" id="to_reg_date" class="form-control datepicker">
			</div>';
			
		$staff_arr = $this->staff_list();
		$franchise_arr = $this->franchise_list();
		
		$this->common_model->js_extra_code.= "
		var date = new Date();
		date.setDate(date.getDate());
		$('#from_reg_date').datepicker({endDate: date}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
			$('#to_reg_date').datepicker('setStartDate', startDate);
		}).on('clearDate', function (selected) {
			$('#to_reg_date').datepicker('setStartDate', null);
		});
		$('#to_reg_date').datepicker({endDate: date}).on('changeDate', function (selected) {
			var endDate = new Date(selected.date.valueOf());
			$('#from_reg_date').datepicker('setEndDate', endDate);
			}).on('clearDate', function (selected) {
			$('#from_reg_date').datepicker('setEndDate', null);
		});
		";
		$assign_from ='';
		$user_type = $this->common_model->get_session_user_type();
		if($user_type == 'admin'){
			if($this->search_for_table_name == 'franchise'){
				$assign_from = '
				<div class="form-group">
					<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Select Franchise</label>
					<div class="col-sm-9 col-lg-9">
						<div class="col-sm-12 col-lg-12 pl0 paddin-mobile">
							'.$franchise_arr.'
							<input type="hidden" value="'.$this->search_for_table_name.'" name="assign_from_hidden">
						</div>			  
					</div>
				</div>';
			}
			else if($this->search_for_table_name == 'staff'){
				$assign_from = '
				<div class="form-group">
					<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Select Staff</label>
					<div class="col-sm-9 col-lg-9">
						<div class="col-sm-12 col-lg-12 pl0 paddin-mobile">
							'.$staff_arr.'
							<input type="hidden" value="'.$this->search_for_table_name.'" name="assign_from_hidden">
						</div>
					</div>
				</div>';
			}
			else{
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
				<input type="hidden" value="'.$this->search_for_table_name.'" name="assign_from_hidden">';
			}
		}
		if($this->search_for_table_name=='staff' || $this->search_for_table_name == 'franchise'){
			$lab = 'Unassigned Between';
		}
		else{
			$lab = 'Assigned Between';
		}
		if($this->member_lead_generation == 'lead_generation'){
			$keyword_placeholder = 'Search with Email Id, Country Name';
		}
		else{
			$keyword_placeholder = 'Search with Matri ID, Email Id';
		}
		$ele_array = array(
			'assign_from'=>array('display_in'=>'2','type'=>'manual','code'=>$assign_from),
			'keyword'=>array('display_in'=>'2','placeholder'=>$keyword_placeholder),
			'keyword_type'=>array('display_in'=>'2','input_type'=>'hidden','value'=>$this->member_lead_generation),
			'reg_range'=>array('display_in'=>'2','type'=>'manual','code'=>'
			<div class="form-group">
				<label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">'.$lab.'</label>
				<div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
					'.$reg_date_rang.'
				</div>
			</div>'),
		);
		return $ele_array;
	}
	function display_filter_form($tabel='')
	{	
		$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;
		
		$ele_array = $this->assignment_reports_model->get_filter_form_array();
		if(isset($this->is_franchise) && $this->is_franchise == 'yes' )
		{
			$this->common_model->js_extra_code.= " $('#list_franchise').chosen({placeholder_text_multiple:'Select Franchise'}); ";
			$ele_array['list_franchise'] = array('type'=>'dropdown','relation'=>array('rel_table'=>'franchise','key_val'=>'id','key_disp'=>'email'),'is_multiple'=>'yes','label'=>'Franchise','display_placeholder'=>'No','class'=>'chosen-select');
		}
		$other_config = array('mode'=>'add','id'=>'','action'=>''.$this->router->fetch_class().'/search_model','form_id'=>'form_model_search');
		$data = $this->common_model->generate_form_main($ele_array,$other_config);
		$this->common_model->data['model_title_fil'] = 'Filter Data';
		$this->common_model->data['model_body_fil'] = $data;
	}
	function get_filter_form_array($type=0)
	{	
		$return_value=array();
		$advanced_search_array = $this->assignment_reports_model->filter_form_array();
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
}?>