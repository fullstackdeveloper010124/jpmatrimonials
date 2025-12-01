<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Match_making extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
		$this->load->model('back_end/Member_model','member_model');
		$this->load->model('back_end/Match_making_model','match_making_model');
	}
	public function index()
	{
		$this->match_making_list();
	}
	
	public function match_making_list($status ='ALL', $page =1,$clear_search='no')
	{
		$access_perm = $this->common_model->check_permission('match_making','redirect');
		$this->common_model->status_arr = array('APPROVED'=>'Approved','UNAPPROVED'=>'Unapproved','Paid'=>'Paid','Suspended'=>'Suspended');
		$this->common_model->status_arr_change = array();
		
		if($clear_search =='yes')
		{
			$this->clear_filter('no');
		}
		$this->common_model->button_array[] = array('class'=>'success','label'=>'Match','url'=>'match-making/match/#matri_id#','target'=>'_blank');
		$_REQUEST['manage_display']='no';
		$access_perm = $this->common_model->check_permission('match_making','redirect');
		$personal_where = array();
		$personal_where['where_per'] = "";
		$personal_where['label_disp'] = "Member Match";
		$personal_where['access_perm'] = $access_perm;
		$other_config = $this->common_model->add_own_where('',$access_perm);
		
		if(isset($status) && $status==='Paid'){
			$this->common_model->status_field='plan_status';
		}
		
		if(isset($other_config['personal_where']) && $other_config['personal_where'] !='')
		{
			$personal_where['where_per'] = $other_config['personal_where'];
		}
		$this->member_model->member_list_model($status,$page,$personal_where);
	}
	
	public function auto_matchs_list($status ='ALL', $page =1,$clear_search='no')
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
			$('#match_criteria').chosen({placeholder_text_multiple:'Select Match Criteria'});
		";
		$this->label_page = 'Update For Send Auto Profile Match';
		$this->common_model->set_table_name('site_config');
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data();
		}
		else
		{
			$ele_array = array(
				'match_send_date'=>array('is_required'=>'required','class'=>'datepicker'),
				'send_total_match'=>array('is_required'=>'required','label'=>'Send Total Match To User','type_num_alph'=>'num','other'=>'maxlength="2" min="1" max="99"'),
				'match_criteria'=>array('is_required'=>'required','is_multiple'=>'yes','display_placeholder'=>'No','type'=>'checkbox','value_arr'=>array('looking_for'=>'Marital Status','age'=>'Age','height'=>'Height','part_complexion'=>'Complexion','part_mother_tongue'=>'Mother Tongue','part_religion'=>'Religion','part_caste'=>'Caste','part_country_living'=>'Country','part_education'=>'Education')),
				'match_sending_mode'=>array('is_required'=>'required','type'=>'dropdown','value'=>'email','value_arr'=>array('email'=>'Email','sms'=>'SMS','both'=>'Both'))
			);
			$other_config = array('mode'=>'edit','id'=>'1','addAllow'=>'no','deleteAllow'=>'no');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);
			
			$this->common_model->js_extra_code .= " 
			document.getElementById('age').checked = true;
			$('#age').click(function () {
				return false;
			});
			$(function(){
				var currentDate = new Date();
				$('#match_send_date').datepicker('setStartDate', currentDate)
			})
			function isNumberKey(event)
			{
				var charCode = (event.which) ? event.which : event.keyCode;
				if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode != 46 || charCode != 45))
				return false;
			}";
			
			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	public function search_model()
	{
		$this->member_model->save_session_search();
	}
	public function clear_filter($return='yes')
	{
		$this->common_model->return_tocken_clear('member_search_session',$return);
	}
	public function match($matri_id='',$page=1)
	{
		$access_perm = $this->common_model->check_permission('match_making','redirect');
		
		if($matri_id !='' && strtolower($matri_id) != 'all')
		{
			$this->session->set_userdata('match_matri_id',$matri_id);
		}
		if($this->session->userdata('match_matri_id'))
		{
			$match_matri_id = $this->session->userdata('match_matri_id');
			if($match_matri_id !='')
			{
				$matri_id = $match_matri_id;
			}
		}
		if($matri_id =='')
		{
			$base_url_admin = $this->common_model->data['base_url_admin'];
			redirect($base_url_admin.'match-making/match-making-list');
		}
		else
		{
			$where_arr_reg = array('matri_id'=>$matri_id);
			$row_data_reg = $this->common_model->get_count_data_manual('register',$where_arr_reg,1,'franchised_by,adminrole_id');
			$allow_to_edit = 1;
			if($row_data_reg =='' || count($row_data_reg) ==0)
			{
				$allow_to_edit = 0;
			}
			
			if($access_perm =='Own Members' && $allow_to_edit == 1)
			{
				$user_logged_type = $this->common_model->get_session_data('user_type');
				$user_id_check_filed = 'franchised_by';
				if($user_logged_type =='staff')
				{
					$user_id_check_filed = 'adminrole_id';
				}
				$user_logged_id = $this->common_model->get_session_data('id');
				if(isset($row_data_reg[$user_id_check_filed]) && $row_data_reg[$user_id_check_filed] != $user_logged_id)
				{
					$allow_to_edit = 0;
				}
			}
			if($allow_to_edit == 0)
			{
				redirect($this->common_model->base_url_admin.'match-making/match-making-list');
				exit;
			}
			
			$status = $this->input->post('status_update');
			if(isset($status) && $status === 'match_email_send'){
				$this->match_making_model->send_email_match($matri_id);
			}
			
			$where_matri = $this->match_making_model->get_match_where_from_matri($matri_id);
			$this->common_model->status_arr = array();
			$this->common_model->status_arr_change = array('match_email_send'=>"Send Match To (".strtoupper($matri_id).")");
			$personal_where = array();
			if($where_matri !='')
			{
				$personal_where['where_per'] = " ($where_matri) ";
			}
			$personal_where['label_disp'] = "Match Found";
			$personal_where['access_perm'] = $access_perm;
			$this->member_model->member_list_model('ALL',$page,$personal_where);
			//echo $this->common_model->last_query();
		}
	}
	public function add_comment()
	{

		$data['base_url'] = $this->common_model->base_url;
		$this->load->view('back_end/add_comment',$data);
	}
}