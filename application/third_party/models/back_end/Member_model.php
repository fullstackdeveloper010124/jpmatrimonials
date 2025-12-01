<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		$this->common_model->session_search_name = 'member_search_session';
	}
	public function height_list()
	{
		return $this->common_model->height_list();
	}
	public function birth_date_picker($birth_date ='')
	{
		return $this->common_model->birth_date_picker($birth_date);
	}
	public function weight_list()
	{
		return $this->common_model->weight_list();
	}
	public function age_rang()
	{
		return $this->common_model->age_rang();
	}
	public function get_list_ddr($type='')
	{
		return $this->common_model->get_list_ddr($type);
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
	function member_list_model($status ='ALL', $page =1,$personal_where='')
	{
		$where_country_code= " ( is_deleted ='No' )";
		$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");
		
		$mobile_ddr= '<div class="col-sm-6 col-lg-6 pl0">
			<select name="country_code" id="country_code" required class="form-control" >
			<option value="">Select Country Code</option>';
			foreach($country_code_arr as $country_code_arr)
			{				
				$mobile_ddr.= '<option value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].' ('.$country_code_arr['country_name'].')'.'</option>';
			}
		$mobile_ddr.='</select>
			</div>
			<div class="col-sm-6 col-lg-6 ">
				<input type="text" required name="mobile_num" id="mobile_num" class="form-control" placeholder="Mobile Number" value ="" />
			</div>';
				
		$ele_array = array(
			'title'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'personal_titles_master','key_val'=>'id','key_disp'=>'personal_titles'),'value'=>1),
			'fullname'=>array('is_required'=>'required'),
			'mobile'=>array('type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Mobile</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$mobile_ddr.'
			  <input type="hidden" name="mobile" id="mobile" value="" />
			  <input type="hidden" name="is_ajax" id="is_ajax" value="1" />
			  </div>
			</div>'),
			'email'=>array('is_required'=>'required','input_type'=>'email'),
			'password'=>array('type'=>'password','is_required'=>'required'),
			'landline'=>array(),
			'status'=>array('type'=>'radio'),
			'gender'=>array('is_required'=>'required','type'=>'radio','value_arr'=>array('Male'=>'Male','Female'=>'Female','Other'=>'Other'),'value'=>'Male'),
			'birthdate'=>array('is_required'=>'required'),
			'marital_status'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'marital_status_master','key_val'=>'id','key_disp'=>'marital_status')),						
			'birthdate'=>array('is_required'=>'required','input_type'=>'date'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		$data_table = array(
			'title_disp'=>'username',
			'post_title_disp'=>'matri_id',
			'disp_column_array'=> array('gender','email','mobile','country_name','religion_name','state_name','caste_name','city_name','mtongue_name','birthdate','marital_status','registered_on','plan_name','last_login','plan_expired_on')
		);
		
		// pass #id# it will replace with table primary key value in url
		
		
		/*$btn_arr = array(
			array('url'=>'job-member/member_detail/#id#/edit','class'=>'info','label'=>'Edit Profile','target'=>'_blank'),
			array('url'=>'job-member/member_detail/#id#','class'=>'primary','label'=>'View Profile','target'=>'_blank')
		);*/
		$access_perm_main ='admin';
		if(isset($personal_where) && $personal_where !='' && count($personal_where))
		{
			if(isset($personal_where['access_perm']) && $personal_where['access_perm'] !='')
			{
				$access_perm_main = $personal_where['access_perm'];
			}
		}
		
		$access_perm_edit = $this->common_model->check_permission('edit_member');
		if($access_perm_edit !='No')
		{
			 $edit_btn_arr = array('url'=>'member/member_list/edit-data/#id#','class'=>'info','label'=>'Edit Profile','target'=>'_blank');
			 if($access_perm_edit =='Own Members')
			 {
				 $edit_btn_arr['own_only'] = 'yes';
			 }
			 $this->common_model->button_array[] = $edit_btn_arr;
		}
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
		
		$other_config = array('load_member'=>'yes','data_table_mem'=>$data_table,'default_order'=>'desc','action'=>'member/save_member','field_duplicate'=>array('email','mobile'),'sort_column'=>array('registered_on'=>'Latest','last_login'=>'Last Login','username'=>'Name'),'display_image'=>'photo1','photo1'=>$this->common_model->path_photos,'display_filter'=>'Yes','add_url'=>'member/member_list/add-data'); // load member for data table display member listing not table
		
		$label_disp = 'Member';
		
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
		$access_perm = $this->common_model->check_permission('add_member');
		if($access_perm =='No')
		{
			$other_config['addAllow'] = 'no';
		}
		// this pemission need parent permission also	
		$access_perm = $this->common_model->check_permission('delete_member');
		if($access_perm =='No' || ($access_perm =='Own Members' && $access_perm_main !='Own Members'))
		{
			$other_config['deleteAllow'] = 'no';
		}
		if($access_perm =='Own Members' && $access_perm_main =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
		}
		$approve_member_perm = $this->common_model->check_permission('approve_member');
		if($approve_member_perm =='No' || ($approve_member_perm =='Own Members' && $access_perm_main !='Own Members'))
		{
			unset($this->common_model->status_arr_change['APPROVED']);
		}
		if($approve_member_perm =='Own Members' && $access_perm_main =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'APPROVED')",'class'=>'success','label'=>'APPROVE','own_only' => 'yes');
		}
		$approve_member_perm = $this->common_model->check_permission('unapprove_member');
		if($approve_member_perm =='No' || ($approve_member_perm =='Own Members' && $access_perm_main !='Own Members'))
		{
			unset($this->common_model->status_arr_change['UNAPPROVED']);
		}
		if($approve_member_perm =='Own Members' && $access_perm_main =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'UNAPPROVED')",'class'=>'warning','label'=>'UNAPPROVE','own_only' => 'yes');
		}
		$approve_member_perm = $this->common_model->check_permission('suspend_member');
		if($approve_member_perm =='No' || ($approve_member_perm =='Own Members' && $access_perm_main !='Own Members'))
		{
			unset($this->common_model->status_arr_change['Suspended']);
		}
		if($approve_member_perm =='Own Members' && $access_perm_main =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'Suspended')",'class'=>'danger','label'=>'Suspend','own_only' => 'yes');
		}
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		//print_r($other_config['data_tab_btn']);
		// this pemission need parent permission also
		$this->display_filter_form();
		
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col =7;
		$this->common_model->addPopup = 0;
		$this->common_model->common_rander('register_view', $status, $page ,$label_disp ,$ele_array,'registered_on',0,$other_config);
	}
	function display_filter_form()
	{	
		$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;
		
		$ele_array = $this->member_model->get_filter_form_array();
		if(isset($this->is_franchise) && $this->is_franchise =='yes' )
		{
			$this->common_model->js_extra_code.= " $('#list_franchise').chosen({placeholder_text_multiple:'Select Franchise'}); ";
			$ele_array['list_franchise'] = array('type'=>'dropdown','relation'=>array('rel_table'=>'franchise','key_val'=>'id','key_disp'=>'email'),'is_multiple'=>'yes','label'=>'Franchise','display_placeholder'=>'No','class'=>'chosen-select');
		}
		$other_config = array('mode'=>'add','id'=>'','action'=>'member/search_model','form_id'=>'form_model_search');
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
			$where_search[]= " ( username like '%$keyword%' or mobile like '%$keyword%' or email like '%$keyword%' or matri_id like '%$keyword%' or country_name like '%$keyword%' or state_name like '%$keyword%'  or city_name like '%$keyword%' ) ";
		}
		
		if($this->input->post('from_reg_date') && $this->input->post('from_reg_date') !='')
		{
			$from_reg_date = $this->input->post('from_reg_date');
			$where_search[]= " ( DATE_FORMAT(registered_on, '%Y-%m-%d') >='$from_reg_date') ";
		}
		if($this->input->post('to_reg_date') && $this->input->post('to_reg_date') !='')
		{
			$to_reg_date = $this->input->post('to_reg_date');
			$where_search[]= " ( DATE_FORMAT(registered_on, '%Y-%m-%d') <='$to_reg_date') ";
		}
		
		if($this->input->post('from_age') && $this->input->post('from_age') !='')
		{
			$from_age = $this->input->post('from_age');
			$where_search[]= " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  >=$from_age ) ";
		}
		if($this->input->post('to_age') && $this->input->post('to_age') !='')
		{
			$to_age = $this->input->post('to_age');
			$where_search[]= " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  <=$to_age ) ";
		}
		
		if($this->input->post('from_height') && $this->input->post('from_height') !='')
		{
			$from_height = $this->input->post('from_height');
			$where_search[]= " ( height >='$from_height') ";
		}
		if($this->input->post('to_height') && $this->input->post('to_height') !='')
		{
			$to_height = $this->input->post('to_height');
			$where_search[] = " ( height <='$to_height') ";
		}
		
		if($this->input->post('mothertongue') && $this->input->post('mothertongue') !='')
		{
			$mothertongue = $this->input->post('mothertongue');
			$mothertongue = $this->common_model->trim_array_remove($mothertongue);
			if(isset($mothertongue) && count($mothertongue) > 0)
			{
				$mothertongue_str = implode("','",$mothertongue);
				$where_search[]= " ( mother_tongue in ( '$mothertongue_str') ) ";
			}
		}
		if($this->input->post('looking_for') && $this->input->post('looking_for') !='')
		{
			$looking_for = $this->input->post('looking_for');
			$looking_for = $this->common_model->trim_array_remove($looking_for);
			if(isset($looking_for) && count($looking_for) > 0)
			{
				$looking_for_str = implode("','",$looking_for);
				$where_search[]= " ( marital_status in ( '$looking_for_str') ) ";
			}
		}
		if($this->input->post('religion') && $this->input->post('religion') !='')
		{
			$religion = $this->input->post('religion');
			$religion = $this->common_model->trim_array_remove($religion);
			if(isset($religion) && count($religion) > 0)
			{
				$religion_str = implode("','",$religion);
				$where_search[]= " ( religion in ('$religion_str') ) ";
			}
		}
		if($this->input->post('caste') && $this->input->post('caste') !='')
		{
			$caste = $this->input->post('caste');
			$caste = $this->common_model->trim_array_remove($caste);
			if(isset($caste) && count($caste) > 0)
			{
				$caste_str = implode("','",$caste);
				$where_search[]= " ( caste in ('$caste_str') ) ";
			}
		}
		if($this->input->post('country') && $this->input->post('country') !='')
		{
			$country = $this->input->post('country');
			$country = $this->common_model->trim_array_remove($country);
			if(isset($country) && count($country) > 0)
			{
				$country_str = implode("','",$country);
				$where_search[]= " ( country_id in ('$country_str') ) ";
			}
		}
		if($this->input->post('state') && $this->input->post('state') !='')
		{
			$state = $this->input->post('state');
			$state = $this->common_model->trim_array_remove($state);
			if(isset($state) && count($state) > 0)
			{
				$state_str = implode("','",$state);
				$where_search[]= " ( state_id in ('$state_str') ) ";
			}
		}
		if($this->input->post('city') && $this->input->post('city') !='')
		{
			$city = $this->input->post('city');
			$city = $this->common_model->trim_array_remove($city);
			if(isset($city) && count($city) > 0)
			{
				$city_str = implode("','",$city);
				$where_search[]= " ( city in ('$city_str') ) ";
			}
		}
		if($this->input->post('manglik') && $this->input->post('manglik') !='')
		{
			$manglik = $this->input->post('manglik');
			$manglik = $this->common_model->trim_array_remove($manglik);
			if(isset($manglik) && count($manglik) > 0)
			{
				$manglik_str = implode("','",$manglik);
				$where_search[]= " ( manglik in ( '$manglik_str') ) ";
			}
		}
		if($this->input->post('star') && $this->input->post('star') !='')
		{
			$star = $this->input->post('star');
			$star = $this->common_model->trim_array_remove($star);
			if(isset($star) && count($star) > 0)
			{
				$star_str = implode("','",$star);
				$where_search[]= " ( star in ( '$star_str') ) ";
			}
		}
		if($this->input->post('horoscope') && $this->input->post('horoscope') !='' && $this->input->post('horoscope') !='All')
		{
			$horoscope = $this->input->post('horoscope');
			$where_search[]= " ( horoscope = '$horoscope' ) ";
		}
		if($this->input->post('moonsign') && $this->input->post('moonsign') !='')
		{
			$moonsign = $this->input->post('moonsign');
			$moonsign = $this->common_model->trim_array_remove($moonsign);
			if(isset($moonsign) && count($moonsign) > 0)
			{
				$moonsign_str = implode("','",$moonsign);
				$where_search[]= " ( moonsign in ( '$moonsign_str') ) ";
			}
		}
		if($this->input->post('education') && $this->input->post('education') !='')
		{
			$education = $this->input->post('education');
			$education = $this->common_model->trim_array_remove($education);
			if(isset($education) && $education !='')
			{
				//$part_education_arr = explode(',',$education);
				$str_education_partner = array();
				foreach($education as $part_education_arr_val)
				{
					$str_education_partner[] = "(find_in_set('$part_education_arr_val',education_detail) > 0 )";
				}
				if(isset($str_education_partner) && count($str_education_partner)> 0)
				{
					$str_education_partner_str = implode(" or ",$str_education_partner);
					echo $where_search[]= " ( $str_education_partner_str ) ";
				}
			}
		}
		if($this->input->post('employee_in') && $this->input->post('employee_in') !='')
		{
			$employee_in = $this->input->post('employee_in');
			$employee_in = $this->common_model->trim_array_remove($employee_in);
			if(isset($employee_in) && count($employee_in) > 0)
			{
				$employee_in_str = implode("','",$employee_in);
				$where_search[]= " ( employee_in in ( '$employee_in_str') ) ";
			}
		}
		if($this->input->post('income') && $this->input->post('income') !='')
		{
			$income = $this->input->post('income');
			$income = $this->common_model->trim_array_remove($income);
			if(isset($income) && count($income) > 0)
			{
				$income_str = implode("','",$income);
				$where_search[]= " ( income in ( '$income_str') ) ";
			}
		}
		if($this->input->post('occupation') && $this->input->post('occupation') !='')
		{
			$occupation = $this->input->post('occupation');
			$occupation = $this->common_model->trim_array_remove($occupation);
			if(isset($occupation) && count($occupation) > 0)
			{
				$occupation_str = implode("','",$occupation);
				$where_search[]= " ( occupation in ( '$occupation_str') ) ";
			}
		}
		if($this->input->post('designation') && $this->input->post('designation') !='')
		{
			$designation = $this->input->post('designation');
			$designation = $this->common_model->trim_array_remove($designation);
			if(isset($designation) && count($designation) > 0)
			{
				$designation_str = implode("','",$designation);
				$where_search[]= " ( designation in ( '$designation_str') ) ";
			}
		}
		if($this->input->post('residence') && $this->input->post('residence') !='')
		{
			$residence = $this->input->post('residence');
			$residence = $this->common_model->trim_array_remove($residence);
			if(isset($residence) && count($residence) > 0)
			{
				$residence_str = implode("','",$residence);
				$where_search[]= " ( residence in ( '$residence_str') ) ";
			}
		}
		if($this->input->post('from_weight') && $this->input->post('from_weight') !='')
		{
			$from_weight = $this->input->post('from_weight');
			$where_search[]= " ( weight >='$from_weight') ";
		}
		if($this->input->post('to_weight') && $this->input->post('to_weight') !='')
		{
			$to_weight = $this->input->post('to_weight');
			$where_search[] = " ( weight <='$to_weight') ";
		}
		if($this->input->post('diet') && $this->input->post('diet') !='')
		{
			$diet = $this->input->post('diet');
			$diet = $this->common_model->trim_array_remove($diet);
			if(isset($diet) && count($diet) > 0)
			{
				$diet_str = implode("','",$diet);
				$where_search[]= " ( diet in ( '$diet_str') ) ";
			}
		}
		if($this->input->post('smoke') && $this->input->post('smoke') !='' && $this->input->post('smoke') !='All')
		{
			$smoke = $this->input->post('smoke');
			$where_search[]= " ( smoke = '$smoke' ) ";
		}
		if($this->input->post('drink') && $this->input->post('drink') !='' && $this->input->post('drink') !='All')
		{
			$drink = $this->input->post('drink');
			$where_search[]= " ( drink = '$drink' ) ";
		}
		if($this->input->post('bodytype') && $this->input->post('bodytype') !='')
		{
			$bodytype = $this->input->post('bodytype');
			$bodytype = $this->common_model->trim_array_remove($bodytype);
			if(isset($bodytype) && count($bodytype) > 0)
			{
				$bodytype_str = implode("','",$bodytype);
				$where_search[]= " ( bodytype in ( '$bodytype_str') ) ";
			}
		}
		if($this->input->post('complexion') && $this->input->post('complexion') !='')
		{
			$complexion = $this->input->post('complexion');
			$complexion = $this->common_model->trim_array_remove($complexion);
			if(isset($complexion) && count($complexion) > 0)
			{
				$complexion_str = implode("','",$complexion);
				$where_search[]= " ( complexion in ( '$complexion_str') ) ";
			}
		}
		if($this->input->post('blood_group') && $this->input->post('blood_group') !='')
		{
			$blood_group = $this->input->post('blood_group');
			$blood_group = $this->common_model->trim_array_remove($blood_group);
			if(isset($blood_group) && count($blood_group) > 0)
			{
				$blood_group_str = implode("','",$blood_group);
				$where_search[]= " ( blood_group in ( '$blood_group_str') ) ";
			}
		}
		if($this->input->post('profileby') && $this->input->post('profileby') !='')
		{
			$profileby = $this->input->post('profileby');
			$profileby = $this->common_model->trim_array_remove($profileby);
			if(isset($profileby) && count($profileby) > 0)
			{
				$profileby_str = implode("','",$profileby);
				$where_search[]= " ( profileby in ( '$profileby_str') ) ";
			}
		}
		if($this->input->post('reference') && $this->input->post('reference') !='')
		{
			$reference = $this->input->post('reference');
			$reference = $this->common_model->trim_array_remove($reference);
			if(isset($reference) && count($reference) > 0)
			{
				$reference_str = implode("','",$reference);
				$where_search[]= " ( reference in ( '$reference_str') ) ";
			}
		}
		/*if($this->input->post('family_type') && $this->input->post('family_type') !='')
		{
			$family_type = $this->input->post('family_type');
			$family_type = $this->common_model->trim_array_remove($family_type);
			if(isset($family_type) && count($family_type) > 0)
			{
				$family_type_str = implode("','",$family_type);
				$where_search[]= " ( family_type in ( '$family_type_str') ) ";
			}
		}*/
		if($this->input->post('family_type') && $this->input->post('family_type') !='' && $this->input->post('family_type') !='All')
		{
			$family_type = $this->input->post('family_type');
			$where_search[]= " ( family_type = '$family_type' ) ";
		}
		if($this->input->post('family_status') && $this->input->post('family_status') !='')
		{
			$family_status = $this->input->post('family_status');
			$family_status = $this->common_model->trim_array_remove($family_status);
			if(isset($family_status) && count($family_status) > 0)
			{
				$family_status_str = implode("','",$family_status);
				$where_search[]= " ( family_status in ( '$family_status_str') ) ";
			}
		}
		if($this->input->post('no_of_brothers') && $this->input->post('no_of_brothers') !='')
		{
			$no_of_brothers = $this->input->post('no_of_brothers');
			$no_of_brothers = $this->common_model->trim_array_remove($no_of_brothers);
			if(isset($no_of_brothers) && count($no_of_brothers) > 0)
			{
				$no_of_brothers_str = implode("','",$no_of_brothers);
				$where_search[]= " ( no_of_brothers in ( '$no_of_brothers_str') ) ";
			}
		}
		if($this->input->post('no_marri_brother') && $this->input->post('no_marri_brother') !='')
		{
			$no_marri_brother = $this->input->post('no_marri_brother');
			$no_marri_brother = $this->common_model->trim_array_remove($no_marri_brother);
			if(isset($no_marri_brother) && count($no_marri_brother) > 0)
			{
				$no_marri_brother_str = implode("','",$no_marri_brother);
				$where_search[]= " ( no_marri_brother in ( '$no_marri_brother_str') ) ";
			}
		}
		if($this->input->post('no_of_sisters') && $this->input->post('no_of_sisters') !='')
		{
			$no_of_sisters = $this->input->post('no_of_sisters');
			$no_of_sisters = $this->common_model->trim_array_remove($no_of_sisters);
			if(isset($no_of_sisters) && count($no_of_sisters) > 0)
			{
				$no_of_sisters_str = implode("','",$no_of_sisters);
				$where_search[]= " ( no_of_sisters in ( '$no_of_sisters_str') ) ";
			}
		}
		if($this->input->post('no_marri_sister') && $this->input->post('no_marri_sister') !='')
		{
			$no_marri_sister = $this->input->post('no_marri_sister');
			$no_marri_sister = $this->common_model->trim_array_remove($no_marri_sister);
			if(isset($no_marri_sister) && count($no_marri_sister) > 0)
			{
				$no_marri_sister_str = implode("','",$no_marri_sister);
				$where_search[]= " ( no_marri_sister in ( '$no_marri_sister_str') ) ";
			}
		}
		if($this->input->post('list_franchise') && $this->input->post('list_franchise') !='')
		{
			$list_franchise = $this->input->post('list_franchise');
			$list_franchise = $this->common_model->trim_array_remove($list_franchise);
			if(isset($list_franchise) && count($list_franchise) > 0)
			{
				$list_franchise_str = implode("','",$list_franchise);
				$where_search[]= " ( franchised_by in ( '$list_franchise_str') ) ";
			}
		}
		if($this->input->post('mobile_verify_status') && $this->input->post('mobile_verify_status') !='' && $this->input->post('mobile_verify_status') !='All')
		{
			$mobile_verify_status = $this->input->post('mobile_verify_status');
			$where_search[]= " ( mobile_verify_status = '$mobile_verify_status' ) ";
		}
		if($this->input->post('plan_name') && $this->input->post('plan_name') !='')
		{
			$plan_name = $this->input->post('plan_name');
			$plan_name = $this->common_model->trim_array_remove($plan_name);
			if(isset($plan_name) && count($plan_name) > 0)
			{
				$plan_name_str = implode("','",$plan_name);
				$where_search[]= " ( plan_name in ( '$plan_name_str') ) ";
			}
		}
		if($this->input->post('plan_status') && $this->input->post('plan_status') !='' && $this->input->post('plan_status') !='All')
		{
			$plan_status = $this->input->post('plan_status');
			$where_search[]= " ( plan_status = '$plan_status' ) ";
		}
		if($this->input->post('plan_expired_on') && $this->input->post('plan_expired_on') !='')
		{
			$plan_expired_on = $this->input->post('plan_expired_on');			
			$plan_expired_on = $this->common_model->trim_array_remove($plan_expired_on);
			
			$now_date = $this->common_model->getCurrentDate('Y-m-d');
			$week_expire = strtotime ( '+7 day' , strtotime ( $now_date ) ) ;
			$month_expire = strtotime ( '+30 day' , strtotime ( $now_date ) ) ;
			
			$today_expire_date = $now_date;
			$in_week_expire_date = date('Y-m-d',$week_expire);
			$in_month_expire_date = date('Y-m-d',$month_expire);
			
			//$plan_expired_on = " ( today_expire = '$today_expire_date',in_week_expire ='$in_week_expire_date', in_month_expire = '$in_month_expire_date' ) ";
			
			if(isset($plan_expired_on) && $plan_expired_on !='' && count($plan_expired_on) > 0)
			{
				$plan_where_cond_arr = array();
				foreach($plan_expired_on as $plan_expired_on_val)
				{
					if($plan_expired_on_val=='today_expire')
					{
						$plan_where_cond_arr[] = " ( plan_expired_on = '$today_expire_date' ) ";
					}
					else if($plan_expired_on_val=='in_week_expire')
					{
						$plan_where_cond_arr[] = " ( plan_expired_on between '$today_expire_date' and '$in_week_expire_date' ) ";
					}
					else if($plan_expired_on_val=='in_month_expire')
					{
						$plan_where_cond_arr[] = " ( plan_expired_on between '$today_expire_date' and '$in_month_expire_date' ) ";
					}
				}
				if(isset($plan_where_cond_arr) && count($plan_where_cond_arr) > 0)
				{
					$plan_expired_on_str = implode(" or ",$plan_where_cond_arr);
					$where_search[] = $plan_expired_on_str;
				}
			}
		}
		if($this->input->post('registered_from') && $this->input->post('registered_from') !='')
		{	
		
			$registered_from = $this->input->post('registered_from');
			$registered_from = $this->common_model->trim_array_remove($registered_from);
			if(isset($registered_from) && count($registered_from) > 0)
			{
				$registered_from_str = implode("','",$registered_from);
				$where_search[]= " ( registered_from in ( '$registered_from_str') ) ";
			}
		}
		if($this->input->post('photo_setting') && $this->input->post('photo_setting') !='' && $this->input->post('photo_setting') !='All')
		{
			$photo_setting = $this->input->post('photo_setting');
			if($photo_setting =='With Photo')
			{
				$where_search[]= " ( photo1 != '' ) ";
			}
			else
			{
				$where_search[]= " ( photo1 = '' or photo1 IS NULL ) ";
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
	
	function basic_detail()
	{
		$username = '';
		if($this->input->post('firstname') && $this->input->post('firstname') !='')
		{
			$username = $this->input->post('firstname');
		}
		if($this->input->post('lastname') && $this->input->post('lastname') !='')
		{
			$username = $username.' '.$this->input->post('lastname');
		}
		$_REQUEST['username'] = $username;
		if($this->input->post('password') && $this->input->post('password') !='')
		{
			$password = $this->input->post('password');
			$hashed_pass = $this->common_model->password_hash($password);
			$_REQUEST['password'] = $hashed_pass;
		}
		else if(isset($_REQUEST['password']))
		{
			unset($_REQUEST['password']);
		}
		$birth_date = '';
		$birth_month = '';
		$birth_year = '';
		if($this->input->post('birth_date') && $this->input->post('birth_date') !='')
		{
			$birth_date = $this->input->post('birth_date');
		}
		if($this->input->post('birth_month') && $this->input->post('birth_month') !='')
		{
			$birth_month = $this->input->post('birth_month');
		}
		if($this->input->post('birth_year') && $this->input->post('birth_year') !='')
		{
			$birth_year = $this->input->post('birth_year');
		}
		if($birth_year !='' && $birth_date !='' && $birth_month !='')
		{
			$birthdate = $birth_year.'-'.$birth_month.'-'.$birth_date;
			$_REQUEST['birthdate'] = $birthdate;
		}
	}
	function residence_detail()
	{
		$mobile_num = '';
		$country_code = '';
		if(isset($_REQUEST['mobile_num']) && $_REQUEST['mobile_num'] !='')
		{
			$mobile_num = $_REQUEST['mobile_num'];
		}
		if(isset($_REQUEST['country_code']) && $_REQUEST['country_code'] !='')
		{
			$country_code = $_REQUEST['country_code'];
		}
		if($country_code !='' && $mobile_num !='')
		{
			$mobile = $country_code.'-'.$mobile_num;
			$_REQUEST['mobile'] = $mobile;
		}
	}
	function physical_detail()
	{
		
	}
	function other_info()
	{
		
	}
	function partner_info()
	{
	}
	function upload_info()
	{
		
	}
	function save_new_update()
	{
		$page_type = '';
		if(isset($_REQUEST['page_type']) && $_REQUEST['page_type'] !='')
		{
			$page_type = $_REQUEST['page_type'];
		}
		if(isset($page_type) && $page_type !='')
		{
			if($page_type =='basic_detail')
			{
				$this->common_model->field_duplicate = array('email');
				$this->basic_detail();
			}
			else if($page_type =='residence_detail')
			{
				$this->residence_detail();
			}
			else if($page_type =='physical_detail')
			{
				$this->physical_detail();
			}
			else if($page_type =='other_info')
			{
				$this->other_info();
			}
			else if($page_type =='partner_info')
			{
				$this->partner_info();
			}
			else if($page_type =='upload_info')
			{
				$this->upload_info();
			}
			$this->session->set_flashdata('page_type',$page_type);
		}		
		$this->common_model->created_on_fild = 'registered_on';
		
		$this->common_model->set_table_name('register');
		$data = $this->common_model->save_update_data(0,1);
		$data = json_decode($data);
		//print_r($data);
		//exit;
		if(isset($data->status) && $data->status !='' && $data->status =='success')
		{
			$this->session->set_flashdata('success_message_mem',$data->response);
			// $insert_id = $this->db->insert_id();
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
				$data_update_arr['registered_from'] = 'Back End';
				$insert_id = $this->common_model->last_insert_id;
				$config_data = $this->common_model->data['config_data'];
				$matri_prefix = $config_data['matri_prefix'];
				$matri_id = $matri_prefix.$insert_id;
				$data_update_arr['matri_id'] = $matri_id;
				$this->common_model->update_insert_data_common('register',$data_update_arr,array('id'=>$insert_id));
			}
			else			
			{
				$insert_id = $_REQUEST['id'];
			}
			// $this->common_model->update_plan_employer($insert_id,1);
			return $insert_id;
		}
		else
		{
			$this->session->set_flashdata('error_message_mem',$data->response);
			return '';
		}
	}
	
	public function save_comment()
	{
		$user_type = $this->common_model->get_session_user_type();
		$u_id = $this->common_model->get_session_data('id');
		$member_comment = '';
		$hidd_user_id = '';
		if($this->input->post('member_comment'))
		{
			$member_comment = $this->input->post('member_comment');
		}
		if($this->input->post('hidd_user_id'))
		{
			$hidd_user_id = $this->input->post('hidd_user_id');
		}
		if($member_comment =='')
		{
			$this->session->set_flashdata('error_message',"Please enter comment");
			return;
		}
		if($hidd_user_id == '')
		{
			$this->session->set_flashdata('error_message',$this->common_model->success_message['error']);
			return;
		}
		$CurrentDate = $this->common_model->getCurrentDate();
		$data_array = array(
			'index_id'=>$hidd_user_id,
			'posted_user_type'=>$user_type,
			'posted_by'=>$u_id,
			'comment'=>$member_comment,
			'created_on'=>$CurrentDate,
		);
		$response = $this->common_model->update_insert_data_common("comment_master",$data_array,'',0);
		if($response)
		{
			$this->session->set_flashdata('success_message',"Comment Added Successfully");
		}
		else
		{
			$this->session->set_flashdata('error_message', $this->common_model->success_message['error']);
		}
	}
	/* for mega matrimony*/
	public function display_column_arr($id='',$label_head = 'Members Full Profile')
	{
		
		$data = array();
		$data['id'] = $id; // current row id for view detail
		$data['data_array'] = $this->common_model->get_count_data_manual('register_view',array('id'=>$id),1,' * ','',0,'',0); 		$access_perm_view = $this->common_model->check_permission('view_profile');
		$allow_to_view = 1;
		if($data['data_array'] =='' || count($data['data_array']) ==0)
		{
			$allow_to_view = 0;
		}
		if($allow_to_view == 1)
		{
			if($access_perm_view =='No')
			{
			$allow_to_view = 0;
		}
			else if($access_perm_view =='Own Members')
			{
			$user_logged_type = $this->common_model->get_session_data('user_type');
			$user_id_check_filed = 'franchised_by';
			if($user_logged_type =='staff')
			{
				$user_id_check_filed = 'adminrole_id';
			}
			$user_logged_id = $this->common_model->get_session_data('id');
			if(isset($data['data_array'][$user_id_check_filed]) && $data['data_array'][$user_id_check_filed] != $user_logged_id)
			{
				$allow_to_view = 0;
			}
		}
		}
		if($allow_to_view == 0)
		{
			redirect($this->common_model->base_url_admin.'member/member-list');
		}
		//$matri_id = $data['data_array']['matri_id'];
		$plan_detail_view = $this->load->view('back_end/member_plan_detail',$data,true);
		
		$image_arra = array(
			array(
				'filed_arr' => array('cover_photo'),
				'path_value'=>$this->common_model->path_cover_photo,
				'title'=>'Member Cover Photo',
				'display_status'=>'yes',
				'status_fild_name'=>'_approve',
				'not_upload_display'=>'yes',
				'img_class'=>'img-responsive img-thumbnail',
				'class_width' =>' col-lg-4 col-md-4 col-sm-6  col-xs-6',
				'inline_style'=>''
			),
			array(
				'filed_arr' => array('photo1','photo2','photo3','photo4','photo5','photo6'),
				'path_value'=>$this->common_model->path_photos,
				'title'=>'Member Photos',
				'display_status'=>'yes',
				'display_name'=>'yes',
				'status_fild_name'=>'_approve',
				'img_class'=>'img-responsive img-thumbnail',
				'class_width' =>' col-lg-4 col-md-4 col-sm-6  col-xs-6',
				'not_upload_display'=>'yes',
				'inline_style'=>'style="height:240px;width:180px"',
			),
			array(
				'filed_arr' => array('horoscope_photo'),
				'path_value'=>$this->common_model->path_horoscope,
				'title'=>'Member Horoscope',
				'display_status'=>'yes',
				'status_fild_name'=>'_approve',
				'not_upload_display'=>'yes',
				'img_class'=>'img-responsive img-thumbnail',
				'class_width' =>' col-lg-4 col-md-4 col-sm-6  col-xs-6',
				'inline_style'=>''
			),
			array(
				'filed_arr' => array('id_proof'),
				'path_value'=>$this->common_model->path_id_proof,
				'title'=>'Member ID Proof',
				'display_status'=>'yes',
				'status_fild_name'=>'_approve',
				'not_upload_display'=>'yes',
				'img_class'=>'img-responsive img-thumbnail',
				'class_width' =>' col-lg-4 col-md-4 col-sm-6  col-xs-6',
				'inline_style'=>''
			),
		);
		$field_main_array = array(				
			array(
				'title_from_arr'=>'username',
				'sub_title_from_arr'=>'matri_id',
				'field_array'=>array(
					'status'=>array('class'=>'text-bold'),
					'plan_name'=>array('class'=>'text-bold'),
					'plan_expired_on'=>array('type'=>'date','class'=>'text-bold text-danger'),
					'registered_on'=>array('type'=>'date'),
					'username'=>array('label'=>'Full Name'),
					'marital_status'=>array(),
					'gender'=>array(),
					'mtongue_name'=>array('label'=>'Mother Tongue'),
					'username'=>array('label'=>'Full Name'),
					'birthdate'=>array('call_back'=>'birthdate_disp'),
					'height'=>array('call_back'=>'display_height'),
					'weight'=>array('post_filed'=>'KG','post_filed_val'=>'Kg'),
					'complexion'=>array('label'=>'Skin Tone'),
					'diet'=>array('label'=>'Eating Habit'),
					'drink'=>array('label'=>'Drinking'),
					'bodytype'=>array('label'=>'Body type'),
					'blood_group'=>array(),
					'smoke'=>array('label'=>'Smoking'),
					'profileby'=>array('label'=>'Created By'),
					'reference'=>array('label'=>'Referenced By'),
					'birthplace'=>array('label'=>'Birth Place'),
					'birthtime'=>array('label'=>'Birth Time'),
					'hobby'=>array('label'=>'Hobby'),
					'languages_known'=>array('label'=>'Other Known<br/> Languages','type'=>'relation','table_name'=>'mothertongue','disp_column_name'=>'mtongue_name')
				),
			),
			array(
				'title'=>'About Us',
				'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12 ',
				'is_single'=>'yes',
				'field_array'=>array(
					'profile_text'=>''
				),
			),
			array(
				'title'=>'Religious Information',
				'field_array'=>array(
					'religion_name'=>array('label'=>'Religion'),
					'caste_name'=>array('label'=>'Caste'),
					'subcaste'=>array('label'=>'Subcaste'),
					'manglik'=>array('label'=>'Manglik'),
					'gothra'=>array('label'=>'Gothra'),
					'horoscope'=>array('label'=>'Horoscope'),
					'moonsign'=>array('label'=>'Moonsign','type'=>'relation','table_name'=>'moonsign','disp_column_name'=>'moonsign_name'),
					'star'=>array('label'=>'Star','type'=>'relation','table_name'=>'star','disp_column_name'=>'star_name'),
					),
			),
			array(
				'title'=>'Location Information',
				'field_array'=>array(
					'country_name'=>array('label'=>'Country'),
					'state_name'=>array('label'=>'State'),
					'city_name'=>array('label'=>'City'),
					'residence'=>array('label'=>'Residence Status'),
					'address'=>array('label'=>'Address'),
					),
			),
			array(
				'title'=>'Contact Information',
				'fa_icone'=>'fa fa-phone',
				'class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-6 ',
				'field_array'=>array(
					'email'=>array('label'=>'Email','fa_icone'=>'fa fa-envelope'),
					'mobile'=>array('label'=>'Mobile','fa_icone'=>'fa fa-phone'),
					'time_to_call'=>array('label'=>'Time To Call'),
					'phone'=>array('label'=>'Phone','fa_icone'=>'fa fa-phone'),
					
				),
			),
			array(
				'title'=>'Education / Profession Information',
				'field_array'=>array(
					'education_detail'=>array('label'=>'Education','type'=>'relation','table_name'=>'education_detail','disp_column_name'=>'education_name'),
					'occupation_name'=>array('label'=>'Occupation'),
					'income'=>array('label'=>'Annual Income'),
					'employee_in'=>array(),
					'designation'=>array('label'=>'Designation','type'=>'relation','table_name'=>'designation','disp_column_name'=>'designation_name')
				),
			),
			array(
				'title'=>'Family Details',
				'label_width'=>5,
				'val_width'=>7,
				'field_array'=>array(
					'family_type'=>array('label'=>'Family Type'),
					'father_name'=>array('label'=>'Father Name'),
					'father_occupation'=>array('label'=>"Father's Occupation"),
					'family_status'=>array('label'=>'Family Status'),
					'no_of_married_brother'=>array('label'=>'Married Brother'),
					'mother_name'=>array('label'=>"Mother's Name"),
					'mother_occupation'=>array('label'=>"Mother's Occupation"),
					'no_of_sisters'=>array('label'=>'No Of Sisters'),
					'no_of_brothers'=>array('label'=>'No of Brothers'),
					'no_of_married_sister'=>array('label'=>'Married Sister'),
					'family_details'=>array('label'=>'About Family','is_single'=>'yes','class_width'=>'col-lg-12 col-md-12 col-sm-12 col-xs-12','disp_label'=>'yes'),
				),
			),
			array(
				'custome_code'=>'<div><h3 class="sub_title_mem">Partner Preference</h3></div>',
			),
			array(
				'title'=>'Basic Preference',
				'field_array'=>array(
					'part_frm_age'=>array('label'=>"Age",'post_filed_concate'=>' to ','post_filed'=>'part_to_age','post_filed_val_after'=>' Years'),
					'part_height'=>array('label'=>"Height",'call_back'=>'display_height','post_filed_concate'=>' to ','post_filed'=>'part_height_to','post_filed_call_back'=>'display_height'),
					'part_smoke'=>array('label'=>'Smoking'),
					'part_drink'=>array('label'=>'Drinking','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'part_diet'=>array('label'=>'Eating Habit','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'part_complexion'=>array('label'=>'Skin Tone','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'part_bodytype'=>array('label'=>'Body Type','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'looking_for'=>array('label'=>'Looking For','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'part_expect'=>array('label'=>'Expectations','class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12','label_width'=>'3','val_width'=>9),
					'part_mother_tongue'=>array('label'=>'Mother Tongue','type'=>'relation','table_name'=>'mothertongue','disp_column_name'=>'mtongue_name','class_width'=>' col-lg-10 col-md-10 col-sm-12 col-xs-12','label_width'=>'2','val_width'=>10,'disp_label'=>'yes'),
				),
			),
			array(
				'title'=>'Religious Preferences',
				'class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12',
				'label_width'=>'3',
				'val_width'=>9,
				'field_array'=>array(
					'part_manglik'=>array('label'=>'Manglik'),
					'part_star'=>array('label'=>'Star','type'=>'relation','table_name'=>'star','disp_column_name'=>'star_name'),
					'part_religion'=>array('label'=>'Religion','type'=>'relation','table_name'=>'religion','disp_column_name'=>'religion_name'),
					'part_caste'=>array('label'=>'Caste','type'=>'relation','table_name'=>'caste','disp_column_name'=>'caste_name'),
				),
			),
			array(
				'title'=>'Education / Occupation Preferences',
				'class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12',
				'label_width'=>'3',
				'val_width'=>9,
				'field_array'=>array(
					'part_income'=>array('label'=>'Annual Income'),
					'part_employee_in'=>array('label'=>'Employed in'),
					'part_designation'=>array('label'=>'Designation','type'=>'relation','table_name'=>'designation','disp_column_name'=>'designation_name'),
					'part_occupation'=>array('label'=>'Occupation','type'=>'relation','table_name'=>'occupation','disp_column_name'=>'occupation_name'),
					'part_education'=>array('label'=>'Education','type'=>'relation','table_name'=>'education_detail','disp_column_name'=>'education_name','label_width'=>'1','val_width'=>11,'class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12',),
				),
			),
			array(
				'title'=>'Location Preferences',
				'class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12',
				'label_width'=>'3',
				'val_width'=>9,
				'field_array'=>array(
					'part_resi_status'=>array('label'=>'Residency Status'),
					'part_country_living'=>array('label'=>'Residency Country','type'=>'relation','table_name'=>'country_master','disp_column_name'=>'country_name'),
					'part_state'=>array('label'=>'Residency State','type'=>'relation','table_name'=>'state_master','disp_column_name'=>'state_name'),
					'part_city'=>array('label'=>'Residency City','type'=>'relation','table_name'=>'city_master','disp_column_name'=>'city_name'),
				),
			),
			array(
				'custome_code'=>$plan_detail_view,
			),
		);
		
		$data['img_list_arr'] = $image_arra;
		$data['img_position'] = 'bottom';
		$data['field_list'] = $field_main_array;			
		
		$this->common_model->common_view_detail($label_head,$data);
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
			$('#mother_tongue').chosen({placeholder_text_multiple:'Select Mother Tongue'});
			$('#religion').chosen({placeholder_text_multiple:'Select Religion'});
			$('#caste').chosen({placeholder_text_multiple:'Select Caste'});
			$('#country').chosen({placeholder_text_multiple:'Select Country'});
			$('#state').chosen({placeholder_text_multiple:'Select State'});
			$('#city').chosen({placeholder_text_multiple:'Select City'});
			$('#looking_for').chosen({placeholder_text_multiple:'Select Marital Status'});
			$('#mothertongue').chosen({placeholder_text_multiple:'Select Mothertongue'});
			$('#manglik').chosen({placeholder_text_multiple:'Select Manglik'});
			//$('#star').chosen({placeholder_text_multiple:'Select Star'});
			$('#moonsign').chosen({placeholder_text_multiple:'Select Moonsign'});
			$('#education').chosen({placeholder_text_multiple:'Select Education'});
			$('#employee_in').chosen({placeholder_text_multiple:'Select Employee In'});
			$('#income').chosen({placeholder_text_multiple:'Select Annual Income'});
			$('#occupation').chosen({placeholder_text_multiple:'Select Occupation'});
			$('#designation').chosen({placeholder_text_multiple:'Select Designation'});
			$('#residence').chosen({placeholder_text_multiple:'Select Residence'});
			$('#diet').chosen({placeholder_text_multiple:'Select Diet'});
			$('#bodytype').chosen({placeholder_text_multiple:'Select Body Type'});
			$('#complexion').chosen({placeholder_text_multiple:'Select Skin Tone'});
			$('#blood_group').chosen({placeholder_text_multiple:'Select Blood Group'});
			$('#profileby').chosen({placeholder_text_multiple:'Select Profile By'});
			$('#reference').chosen({placeholder_text_multiple:'Select Reference'});
			//$('#family_type').chosen({placeholder_text_multiple:'Select Family Type'});
			$('#family_status').chosen({placeholder_text_multiple:'Select Family Status'});
			$('#no_of_brothers').chosen({placeholder_text_multiple:'Select No Of Brothers'});
			$('#no_marri_brother').chosen({placeholder_text_multiple:'Select No Of Married Brother'});
			$('#no_of_sisters').chosen({placeholder_text_multiple:'Select No Of Sisters'});
			$('#no_marri_sister').chosen({placeholder_text_multiple:'Select No Of Married Sister'});
			$('#plan_name').chosen({placeholder_text_multiple:'Select Plan Name'});
			$('#plan_expired_on').chosen({placeholder_text_multiple:'Select Plan Expired On'});
			$('#registered_from').chosen({placeholder_text_multiple:'Select Registered From'});
			
		";
		$reg_date_rang = '<div class="col-sm-5 col-lg-5 pl0">
			<input type="text" name="from_reg_date" id="from_reg_date" class="form-control datepicker">
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0">
			<input type="text" name="to_reg_date" id="to_reg_date" class="form-control datepicker">
			</div>';
			
		$this->common_model->js_extra_code.= " $('#from_reg_date').datepicker({}).on('changeDate', function (selected) {
				var startDate = new Date(selected.date.valueOf());
				$('#to_reg_date').datepicker('setStartDate', startDate);
			}).on('clearDate', function (selected) {
				$('#to_reg_date').datepicker('setStartDate', null);
			});
			$('#to_reg_date').datepicker({
			}).on('changeDate', function (selected) {
			var endDate = new Date(selected.date.valueOf());
			$('#from_reg_date').datepicker('setEndDate', endDate);
			}).on('clearDate', function (selected) {
			$('#from_reg_date').datepicker('setEndDate', null);
			}); ";	
		$age_range_arr = $this->member_model->age_rang();
		$age_range_str= '<div class="col-sm-5 col-lg-5 pl0">
			<select name="from_age" id="from_age" class="form-control">
				<option selected value="" >From</option>';
				foreach($age_range_arr as $age_key=>$age_val)
				{
					$age_range_str.= '<option value="'.$age_key.'" >'.$age_val.'</option>';
				}
		$age_range_str.='</select>
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0">
			<select name="to_age" id="to_age" class="form-control">
				<option selected value="" >To</option>';
				foreach($age_range_arr as $age_key=>$age_val)
				{
					$age_range_str.= '<option value="'.$age_key.'" >'.$age_val.'</option>';
				}
		$age_range_str.='
		</select></div>';
		
		$height_range_arr = $this->member_model->height_list();
		$height_range_str= '<div class="col-sm-5 col-lg-5 pl0">
			<select name="from_height" id="from_height" class="form-control">
				<option selected value="" >From</option>';
				foreach($height_range_arr as $age_key=>$age_val)
				{
					$height_range_str.= '<option value="'.$age_key.'" >'.$age_val.'</option>';
				}
		$height_range_str.='</select>
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0">
			<select name="to_height" id="to_height" class="form-control">
				<option selected value="" >To</option>';
				foreach($height_range_arr as $age_key=>$age_val)
				{
					$height_range_str.= '<option value="'.$age_key.'" >'.$age_val.'</option>';
				}
		$height_range_str.='
		</select></div>';
		
		$weight_range_arr = $this->member_model->weight_list();
		$weight_range_str= '<div class="col-sm-5 col-lg-5 pl0">
			<select name="from_weight" id="from_weight" class="form-control">
				<option selected value="" >From</option>';
				foreach($weight_range_arr as $weight_key=>$weight_val)
				{
					$weight_range_str.= '<option value="'.$weight_key.'" >'.$weight_val.'</option>';
				}
		$weight_range_str.='</select>
			</div>
			<div class="col-sm-1 col-lg-1">To</div>
			<div class="col-sm-5 col-lg-5 pr0">
			<select name="to_weight" id="to_weight" class="form-control">
				<option selected value="" >To</option>';
				foreach($weight_range_arr as $weight_key=>$weight_val)
				{
					$weight_range_str.= '<option value="'.$weight_key.'" >'.$weight_val.'</option>';
				}
		$weight_range_str.='
		</select></div>';
		
		/*$this->common_model->label_col = 3;
		$this->common_model->form_control_col =9;
		$this->common_model->addPopup = 1;*/
		// 'display_in'=>'2', //posible value, display filed in pop up = 0, in advance search = 1, for display in both = 2
		$gender_arr = $this->common_model->merge_array_all_ddr('gender');
		$horoscope_arr = $this->common_model->merge_array_all_ddr('horoscope');
		$smoke_arr = $this->common_model->merge_array_all_ddr('smoke');
		$drink_arr = $this->common_model->merge_array_all_ddr('drink');
		$family_type_arr = $this->common_model->merge_array_all_ddr('family_type');
		$mobile_verify_status_arr = $this->common_model->merge_array_all_ddr('mobile_verify_status');
		$plan_status_arr = $this->common_model->merge_array_all_ddr('plan_status');
		$photo_setting_arr = $this->common_model->merge_array_all_ddr('photo_setting');
		
		//$plan_expired_on_arr = $this->common_model->merge_array_all_ddr('plan_expired_on');
		
		
		
		$ele_array = array(
			'gender'=>array('display_in'=>'2','type'=>'radio','is_required'=>'required','value_arr'=>$gender_arr,'value'=>'All'),
			'keyword'=>array('display_in'=>'2','placeholder'=>'Search with Name, Matri ID, Email, Mobile, Country Name, State Name, City Name..'),			
			'reg_range'=>array('display_in'=>'2','type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Registered Between</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$reg_date_rang.'
			  </div>
			</div>'),
			'age_range'=>array('display_in'=>'2','type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Age Range</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$age_range_str.'			  
			  </div>
			</div>'),
			'height_range'=>array('display_in'=>'2','type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Height Range</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$height_range_str.'			  
			  </div>
			</div>'),
			'mothertongue'=>array('display_in'=>'2','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select','value_arr'=>$this->common_model->dropdown_array_table('mothertongue')),
			'looking_for'=>array('display_in'=>'2','is_required'=>'required','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('marital_status'),'label'=>'Marital Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'religion'=>array('display_in'=>'2','type'=>'dropdown','relation'=>array('rel_table'=>'religion','key_val'=>'id','key_disp'=>'religion_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select','onchange'=>"dropdownChange_mul('religion','caste','caste_list')"),
			'caste'=>array('display_in'=>'2','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select chosen_select_remove'),
			'country'=>array('display_in'=>'2','type'=>'dropdown','relation'=>array('rel_table'=>'country_master','key_val'=>'id','key_disp'=>'country_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select','onchange'=>"dropdownChange_mul('country','state','state_list')"),
			'state'=>array('display_in'=>'2','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select chosen_select_remove','onchange'=>"dropdownChange_mul('state','city','city_list')"),
			'city'=>array('display_in'=>'2','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select city_list_update chosen_select_remove'),
			'manglik'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('manglik'),'label'=>'Manglik','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			/*'star'=>array('display_in'=>'2','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('star'),'label'=>'Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),*/
			'horoscope'=>array('display_in'=>'1','type'=>'radio','value_arr'=>$horoscope_arr,'value'=>'All'),
			'moonsign'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('moonsign'),'label'=>'Moonsign','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'education'=>array('display_in'=>'1','type'=>'dropdown','relation'=>array('rel_table'=>'education_detail','key_val'=>'id','key_disp'=>'education_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'employee_in'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('employee_in'),'label'=>'Employee In','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'income'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('income'),'label'=>'Annual Income','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'occupation'=>array('display_in'=>'1','type'=>'dropdown','relation'=>array('rel_table'=>'occupation','key_val'=>'id','key_disp'=>'occupation_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'designation'=>array('display_in'=>'1','type'=>'dropdown','relation'=>array('rel_table'=>'designation','key_val'=>'id','key_disp'=>'designation_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'residence'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('residence'),'label'=>'Residence','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'weight_range'=>array('display_in'=>'1','type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Weight Range</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$weight_range_str.'			  
			  </div>
			</div>'),
			'diet'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('diet'),'label'=>'Diet','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'smoke'=>array('display_in'=>'1','type'=>'radio','value_arr'=>$smoke_arr,'value'=>'All'),
			'drink'=>array('display_in'=>'1','type'=>'radio','value_arr'=>$drink_arr,'value'=>'All'),
			'bodytype'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('bodytype'),'label'=>'Body Type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'complexion'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('complexion'),'label'=>'Skin Tone','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'blood_group'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('blood_group'),'label'=>'Blood Group','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'profileby'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('profileby'),'label'=>'Profile By','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'reference'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('reference'),'label'=>'Reference','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'family_type'=>array('display_in'=>'1','type'=>'radio','value_arr'=>$family_type_arr,'value'=>'All'),
			'family_status'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('family_status'),'label'=>'Family Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'no_of_brothers'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('no_of_brothers'),'label'=>'No Of Brothers','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'no_marri_brother'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('no_marri_brother'),'label'=>'No Of Married Brother','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'no_of_sisters'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('no_of_brothers'),'label'=>'No Of Sisters','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'no_marri_sister'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('no_marri_sister'),'label'=>'No Of Married Sister','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),		
			'mobile_verify_status'=>array('display_in'=>'1','type'=>'radio','is_required'=>'required','value_arr'=>$mobile_verify_status_arr,'value'=>'All'),
			'plan_name'=>array('display_in'=>'1','type'=>'dropdown','relation'=>array('rel_table'=>'membership_plan','key_val'=>'plan_name','key_disp'=>'plan_name'),'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'plan_status'=>array('display_in'=>'1','type'=>'radio','is_required'=>'required','value_arr'=>$plan_status_arr,'value'=>'All'),
			'plan_expired_on'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('plan_expired_on'),'label'=>'Plan Expired On','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'registered_from'=>array('display_in'=>'1','type'=>'dropdown','value_arr'=>$this->member_model->get_list_ddr('registered_from'),'label'=>'Registered From','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select'),
			'photo_setting'=>array('display_in'=>'1','type'=>'radio','is_required'=>'required','value_arr'=>$photo_setting_arr,'value'=>'All'),
					
		);
		
		return $ele_array;
	}
	
	function get_filter_form_array($type=0)
	{	
		$return_value=array();
		$advanced_search_array = $this->member_model->filter_form_array();
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