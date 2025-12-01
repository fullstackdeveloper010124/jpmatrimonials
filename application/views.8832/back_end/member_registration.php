<style type="text/css">
.box-tab .nav-tabs li.active a, .box-tab .nav-tabs li.active a:hover { color: #fff; font-weight: bold; background:#3b77b5!important; border-top-left-radius: 10px; border-top-right-radius: 10px;}
.select2{width:100% !important}
.select2-container--default .select2-selection--multiple {background-color: white;border: 1px solid #e4e4e4;border-radius: 4px;cursor: text;}
.select2-container--default.select2-container--focus .select2-selection--multiple {border: solid #0ac2ff 1px;outline: 0;}
.select2-container--default .select2-selection--single{background-color: #fff;border: 1px solid #e4e4e4;border-radius: 4px;}
.select2-container .select2-selection--single .select2-selection__rendered {display: block;padding-left: 12px;padding-right: 20px;overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 3px;}
.select2-container--default .select2-selection--multiple .select2-selection__rendered {box-sizing: border-box;list-style: none;margin: 0;padding: 0 12px;width: 100%;}
.select2-container .select2-selection--single{box-sizing: border-box;cursor: pointer;display: block;height: 34px;user-select: none;-webkit-user-select: none;}
.float-left{float:left!important;}
</style>
<?php
	
	$tab_act = "basic_detail";
	$current_count_code = '+91';
	$mobile_val = '';
	$birth_date = '';
	$first_fill_form = '<div class="alert alert-danger">Please fill Basic detail first.</div>';
	if($mode =='add-data' || $mode =='add')
	{
		$mode ='add';
	}
	else
	{
		$mode ='edit';
		$where_arr = array('id'=>$id);
		$row_data_reg = $this->common_model->get_count_data_manual('register',$where_arr,1);
		
		$access_perm_edit = $this->common_model->check_permission('edit_member','redirect');
		$allow_to_edit = 1;
		if($access_perm_edit =='No')
		{
			$allow_to_edit = 0;
		}
		else if($access_perm_edit =='Own Members')
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
			redirect($this->common_model->base_url_admin.'member/member-list');
			exit;
		}
		
		$this->common_model->edit_row_data = $row_data_reg;
		$mobile = $row_data_reg['mobile'];
		$birth_date = $row_data_reg['birthdate'];
		if($mobile !='')
		{
			$mobile_arr = explode('-',$mobile);
			if(isset($mobile_arr) && count($mobile_arr) == 2 )
			{
				$current_count_code = $mobile_arr[0];
				$mobile_val = $mobile_arr[1];
			}
			else
			{
				$mobile_val = $mobile_arr[0];
			}
		}
		
	}
	$this->common_model->mode = $mode;

	if($this->session->flashdata('page_type'))
	{
		$page_type = $this->session->flashdata('page_type');
		if(isset($page_type) && $page_type !='')
		{
			$tab_act = $page_type;
		}
	}
	$tab_act = 'tab_'.$tab_act;
	//$id = '';
	//$mode = 'add';
?>
<div>
<?php 
if($this->session->flashdata('success_message_mem'))
{
	echo $this->session->flashdata('success_message_mem');
}
else if($this->session->flashdata('error_message_mem'))
{
	echo $this->session->flashdata('error_message_mem');
}
?>
</div>
<div class="box-tab justified" id="rootwizard">
  <ul class="nav nav-tabs">
    <li <?php if($tab_act=='tab_basic_detail'){ echo 'class="active"';}?>"><a href="#tab1" data-toggle="tab"> Basic Details</a> </li>
    <li <?php if($tab_act=='tab_residence_detail'){ echo 'class="active"';}?>"><a href="#tab2" data-toggle="tab" > Residence</a> </li>
    <li <?php if($tab_act=='tab_physical_detail'){ echo 'class="active"';}?>><a href="#tab3" data-toggle="tab"> Physical Info</a> </li>
    <li <?php if($tab_act=='tab_other_info'){ echo 'class="active"';}?>><a href="#tab4" data-toggle="tab"> Other Info</a> </li>
    <li <?php if($tab_act=='tab_partner_info'){ echo 'class="active"';}?>><a href="#tab5" data-toggle="tab"> Partner Preference</a> </li>
    <li <?php if($tab_act=='tab_upload_info'){ echo 'class="active"';}?>><a href="#tab6" data-toggle="tab">Upload Photos</a> </li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane <?php if($tab_act=='tab_basic_detail'){ echo 'active';}?>" id="tab1">
    <?php  
        $mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
        $religion_arr = $this->common_model->dropdown_array_table('religion');
        $education_name_arr = $this->common_model->dropdown_array_table('education_detail');
        $occupation_arr = $this->common_model->dropdown_array_table('occupation');
        $income_arr = $this->common_model->dropdown_array_table('annual_income');
        $designation_arr = $this->common_model->dropdown_array_table('designation');
		$star_arr = $this->common_model->dropdown_array_table('star');
		$moonsign_arr = $this->common_model->dropdown_array_table('moonsign');
        $country_arr = $this->common_model->dropdown_array_table('country_master');
        // basic detail
		$birth_ddr_str = $this->common_model->birth_date_picker($birth_date);
		$birth_date_str = '<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Date of Birth</label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$birth_ddr_str.'
			  </div>
			</div>';
        $ele_array = array(
            'gender'=>array('type'=>'radio','is_required'=>'required','value_arr'=>array('Male'=>'Male','Female'=>'Female'),'value'=>'Male'),
            'firstname'=>array('is_required'=>'required','label'=>'Enter First Name'),
            'lastname'=>array('is_required'=>'required','label'=>'Enter Last Name'),
            'email'=>array('is_required'=>'required','input_type'=>'email','check_duplicate'=>'Yes','label'=>'Enter Your Email Id'),
            'password'=>array('is_required'=>'required','other'=>'minlength="6" ','type'=>'password','label'=>'Create a Password'),
            'marital_status'=>array('is_required'=>'required','type'=>'radio','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'value'=>'Unmarried','onclick'=>'display_total_childern()'),
			'total_children'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('total_children'),'value_curr'=>0,'extra'=>'disabled','onchange'=>'display_childern_status()'),
			'status_children'=>array('is_required'=>'required','type'=>'radio','value_arr'=>$this->common_model->get_list_ddr('status_children'),'extra'=>'disabled'),
            'mother_tongue'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue'),
            'languages_known'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Language Known'),
            /*'birthdate'=>array('is_required'=>'required','label'=>'Date of Birth','input_type'=>'date'),*/
			'birthdate'=>array('type'=>'manual','code'=>$birth_date_str),
            'relig_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem"> Religious Information</h3>'),
            'religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('religion','caste','caste_list')",'class'=>'select2','value_arr'=>$religion_arr),
            'caste'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','rel_col_name'=>'religion_id','not_load_add'=>'yes','not_load_add'=>'yes','cus_rel_col_val'=>'religion')),
            'subcaste'=>array('label'=>'Sub Caste'),
            'manglik'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('manglik')),
            'star'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$star_arr),
            'horoscope'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('horoscope')),
            'gothra'=>array('label'=>'Gothra'),
            'moonsign'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$moonsign_arr),
            'education_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem"> Education / Occupation Details</h3>'),
            'education_detail'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Education'),
            'employee_in'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('employee_in')),
            'income'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$income_arr,'label'=>'Annual Income','class'=>'select2'),
            // 'income'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income'),
            'occupation'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$occupation_arr,'label'=>'Occupation','class'=>'select2'),
            'designation'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$designation_arr),
			'page_type'=>array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="basic_detail" />')
            
        );
        $this->common_model->js_extra_code.= " select2('.select2','Please Select'); $(function(){display_total_childern(); });";
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'basic_detail','action'=>'member/save_member');
        $this->common_model->set_table_name('register');

        echo $this->common_model->generate_form_main($ele_array,$other_config);
    ?>
    </div>
    <div class="tab-pane <?php if($tab_act=='tab_residence_detail'){ echo 'active';}?>" id="tab2">
      <?php 
	  //residence
	  	if($mode =='edit' && $id !='')
		{
	  	$where_country_code= " ( is_deleted ='No' ) GROUP BY country_code,country_name";
		$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");
		
		$mobile_ddr= '<div class="col-sm-5 col-lg-5 pl0">
			<select name="country_code" id="country_code" required class="form-control select2" >
			<option value="">Select Country Code</option>';
			foreach($country_code_arr as $country_code_arr)
			{	
				$select_ed_drp = '';
				if($country_code_arr['country_code'] == $current_count_code)
				{
					$select_ed_drp = 'selected';
				}
				$mobile_ddr.= '<option '.$select_ed_drp.' value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].'</option>';
			}
		$mobile_ddr.='</select>
			</div>
			<div class="col-sm-7 col-lg-7 ">
				<input type="number" minlength="7" maxlength="13" required name="mobile_num" id="mobile_num" class="form-control" placeholder="Mobile Number" value ="'.$mobile_val.'" />
			</div>';
        $ele_array = array(
            'country_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Country','class'=>'select2','onchange'=>"dropdownChange('country_id','state_id','state_list')"),
            'state_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id'),'label'=>'State','class'=>'select2','onchange'=>"dropdownChange('state_id','city','city_list')"),
            'city'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id'),'label'=>'City','class'=>'select2'),
            'address'=>array('type'=>'textarea'),
            'mobile'=>array('type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Mobile <span class="sub_title_mem">*</span></label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  '.$mobile_ddr.'
			  <input type="hidden" name="mobile" id="mobile" value="" />
			  </div>
			</div>'),
            'phone'=>array(),
            'time_to_call'=>array(),
			'residence'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('residence')),
			'page_type'=>array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="residence_detail" />')
        );
		if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && isset($mobile_val) && $mobile_val !='')
		{
			$ele_array['mobile'] = array('type'=>'manual','code'=>'
			<div class="form-group">
			  <label class="col-sm-'.$this->common_model->label_col.' col-lg-'.$this->common_model->label_col.' control-label">Mobile <span class="sub_title_mem">*</span></label>
			  <div class="col-sm-9 col-lg-'.$this->common_model->form_control_col.'">
			  <span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>
			  </div>
			</div>');
		}
        $this->common_model->set_table_name('register');
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'residence_detail','action'=>'member/save_member');
        echo $this->common_model->generate_form_main($ele_array,$other_config);
		}
		else
		{
			echo $first_fill_form;
		}
    ?>
    </div>
    <div class="tab-pane <?php if($tab_act=='tab_physical_detail'){ echo 'active';}?>" id="tab3">
      <?php 
	  // physical
	    if($mode =='edit' && $id !='')
		{
        $ele_array = array(
            'height'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->height_list()),
            'weight'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->weight_list()),
            'diet'=>array('label'=>'Eating Habits','is_required'=>'required','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet')),
            'smoke'=>array('label'=>'Smoking','is_required'=>'required','type'=>'radio','value_arr'=>$this->common_model->get_list_ddr('smoke'),'value'=>'No'),
            'drink'=>array('label'=>'Drinking','is_required'=>'required','type'=>'radio','value_arr'=>$this->common_model->get_list_ddr('drink'),'value'=>'No'),
            'bodytype'=>array('label'=>'Body Type','is_required'=>'required','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype')),
            'complexion'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Skin Tone'),
            'blood_group'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('blood_group')),
			'page_type'=>array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="physical_detail" />')
        );
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'physical_detail','action'=>'member/save_member');
        echo $this->common_model->generate_form_main($ele_array,$other_config);
		}
		else
		{
			echo $first_fill_form;
		}
    ?>
    </div>
    <div class="tab-pane <?php if($tab_act=='tab_other_info'){ echo 'active';}?>" id="tab4">
      <?php 
	  // other info
	  	if($mode =='edit' && $id !='')
		{
        $ele_array = array(
            'about_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem"> About</h3>'),
			'profile_text'=>array('type'=>'textarea','label'=>'About Us'),
// 			'hobby'=>array('type'=>'textarea'),
			'birthplace'=>array('label'=>'Birth Place'),
            'birthtime'=>array('label'=>'Birth Time','input_type'=>'time'),
            'profileby'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('profileby'),'label'=>'Profile By'),
            'reference'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('reference')),
            'family_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem"> Family Details</h3>'),
            'family_type'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('family_type')),
            'father_name'=>array(),
            'father_occupation'=>array('lable'=>"Father's Occupation"),
            'mother_name'=>array(),
            'mother_occupation'=>array('lable'=>"Mother's Occupation"),
            'family_status'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('family_status')),
			'no_of_brothers'=>array('type'=>'dropdown','class'=>'select2 no_of_brothers','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'onchange'=>'show_bro_details_new()'),
            'no_of_married_brother'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('no_marri_brother')),
            'no_of_sisters'=>array('type'=>'dropdown','class'=>'select2 no_of_sisters','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'onchange'=>'show_sis_details_new()'),
            'no_of_married_sister'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('no_marri_sister')),
            'family_details'=>array('type'=>'textarea'),
			'page_type'=>array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="other_info" />')
            
        );
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'other_info','action'=>'member/save_member');
        echo $this->common_model->generate_form_main($ele_array,$other_config);
		}
		else
		{
			echo $first_fill_form;
		}
    ?>
    </div>
    <div class="tab-pane <?php if($tab_act=='tab_partner_info'){ echo 'active';}?>" id="tab5">
      <?php 
	  	if($mode =='edit' && $id !='')
		{
	  	if(isset($row_data_reg) && $row_data_reg !='' && count($row_data_reg) >0)
		{
			unset($row_data_reg['country_id']);
			unset($row_data_reg['state_id']);
			unset($row_data_reg['city_id']);
			$this->common_model->edit_row_data = $row_data_reg;
		}
	  	// partner preference
        $ele_array = array(
            'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Partner Complexion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_frm_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner From Age",'class'=>'select2'),
            'part_to_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner To Age",'class'=>'select2'),
            'part_height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner From Height",'class'=>'select2'),
            'part_height_to'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner To Height",'class'=>'select2'),
            'part_bodytype'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Partner Body type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_diet'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Partner Eating Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_smoke'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Partner Smoking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_drink'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Partner Drinking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Partner Mothertongue'),
            
            'part_expect'=>array('type'=>'textarea','label'=>'Expectations'),
            
            'religious_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem">Religious Preferences</h3>'),
            'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Partner Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Partner Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_manglik'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('manglik'),'label'=>'Partner Manglik'),
            'part_star'=>array('type'=>'dropdown','value_arr'=>$star_arr,'label'=>'Partner Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            
            'edu_part_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem">Education / Occupation Preferences</h3>'),
            'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Partner Education'),
            'part_employee_in'=>array('is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'label'=>'Partner Employed In'),
            
            'part_occupation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$occupation_arr,'label'=>'Partner Occupation','class'=>'select2'),
            'part_designation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$designation_arr,'label'=>'Partner Designation'),
            'part_income'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$income_arr,'label'=>'Annual Income','class'=>'select2'),
            // 'part_income'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Partner Annual Income'),
            
            'location_part_title'=>array('type'=>'manual','code'=>'<h3 class="sub_title_mem">Location Preferences</h3>'),
            'part_country_living'=>array('type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Partner Country','onchange'=>"dropdownChange_mul('part_country_living','part_state','state_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
            'part_state'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id','cus_rel_col_val'=>'part_country_living'),'label'=>'State','onchange'=>"dropdownChange_mul('part_state','part_city','city_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','label'=>'Partner State'),
            'part_city'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id','cus_rel_col_val'=>'part_state'),'label'=>'Partner City','class'=>'city_list_update select2','is_multiple'=>'yes','display_placeholder'=>'No'),
			
            'part_resi_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'label'=>'Partner Residence Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2'),
			'page_type'=>array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="partner_info" />')
        
        );
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'partner_info','action'=>'member/save_member');
        echo $this->common_model->generate_form_main($ele_array,$other_config);
		}
		else
		{
			echo $first_fill_form;
		}
    ?>
    </div>
    <div class="tab-pane <?php if($tab_act=='tab_upload_info'){ echo 'active';}?>" id="tab6">
        <?php 
		if($mode =='edit' && $id !='')
		{
        $status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED');
        $ele_array = array();
        $photo_count = 8;
        $path_photos = $this->common_model->path_photos;
        if(isset($this->common_model->photo_upload_count) && $this->common_model->photo_upload_count !='' && $this->common_model->photo_upload_count > 0 && $this->common_model->photo_upload_count < 8 )
        {
            $photo_count = $this->common_model->photo_upload_count;
        }
        
		//  $ele_array['cover_photo_approve'] = array('type'=>'radio','is_required'=>'required','value'=>'APPROVED','value_arr'=>$status_arr,'label'=>'Cover Photo Status');
		// $ele_array['cover_photo']= array('type'=>'file','path_value'=>$this->common_model->path_cover_photo,'inline_style'=>'height:100px;width:150px;');
		
        for($ip=1;$ip<=$photo_count;$ip++)
        {
            $ele_array['photo'.$ip.'_approve'] = array('type'=>'radio','is_required'=>'required','value'=>'APPROVED','value_arr'=>$status_arr,'label'=>'Photo '.$ip.' Status');
			$ele_array['photo'.$ip] = array('type'=>'file','path_value'=>$path_photos,'inline_style'=>'height:150px;width:125px;object-fit:contain;');
        }
        $ele_array['horoscope_photo_approve'] = array('type'=>'radio','is_required'=>'required','value'=>'APPROVED','value_arr'=>$status_arr,'label'=>'Horoscope Status');
		$ele_array['horoscope_photo']= array('type'=>'file','path_value'=>$this->common_model->path_horoscope,'inline_style'=>'height:100px;width:150px;');
        
		$ele_array['id_proof_approve'] = array('type'=>'radio','is_required'=>'required','value'=>'APPROVED','value_arr'=>$status_arr,'label'=>'ID Proof Status');
		$ele_array['id_proof']= array('type'=>'file','path_value'=>$this->common_model->path_id_proof,'inline_style'=>'height:100px;width:150px;');
        
		$ele_array['page_type']=array('type'=>'manual','code'=>'<input type="hidden" name="page_type" id="page_type" value="upload_info" />');
		
        $other_config = array('mode'=>$mode,'id'=>$id,'enctype'=>'enctype="multipart/form-data"','form_id'=>'upload_info','action'=>'member/save_member');
        echo $this->common_model->generate_form_main($ele_array,$other_config);
		}
		else
		{
			echo $first_fill_form;
		}
        
        $this->common_model->js_extra_code.='
            if($("#basic_detail").length > 0)
            {
                $("#basic_detail").validate({
					rules: {
						firstname: {
						  lettersonly: true
						},
						lastname: {
						  lettersonly: true
						},
					},	
                    submitHandler: function(form)
                    {
                        return true;
                    }
                });
            }
            if($("#residence_detail").length > 0)
            {
                $("#residence_detail").validate({
					rules: {
						mobile_num: {
						  required: true,
						  number: true
						},
						phone: {						
						  number: true
						}						
					 },	
                    submitHandler: function(form)
                    {
                        //return false;
                        return true;
                    }
                });
            }
            if($("#physical_detail").length > 0)
            {
                $("#physical_detail").validate({
                    submitHandler: function(form)
                    {
                        //return false;
                        return true;
                    }
                });
            }
            if($("#other_info").length > 0)
            {
                $("#other_info").validate({
					rules: {
						father_name: {
						  lettersonly: true
						},
						father_occupation: {
						  lettersonly: true
						},
						mother_name: {
						  lettersonly: true
						},
						mother_occupation: {
						  lettersonly: true
						},
						birthplace: {
						  lettersonly: true
						},
						
					 },	
                    submitHandler: function(form)
                    {
                        //return false;
                        return true;
                    }
                });
            }
            if($("#partner_info").length > 0)
            {
                $("#partner_info").validate({
                    submitHandler: function(form)
                    {
                        //return false;
                        return true;
                    }
                });
            }
            if($("#upload_info").length > 0)
            {
                $("#upload_info").validate({
                    submitHandler: function(form)
                    {
                        //return false;
                        return true;
                    }
                });
            }
        ';
    ?>
    </div>
  </div>
</div>
<script>
    // new added shakir ali 
function show_bro_details_new() {
    var brother = $('.no_of_brothers').val();	
    var opt = '';
    if(brother == '4 +') {
        brother = 5;
    }
    var base_url = $('#base_url_admin').val();
    var hash_tocken_id = $('#hash_tocken_id').val();
    if(brother!='' && brother!='No') {
        $('#web_no_of_married_brother').show();
        $('#mob_no_of_married_brother').show();
        $.ajax({
                url: base_url+'register/married_brother_list_new',
                type: 'post',
                data: {
                    count_brother:brother,
                    csrf_new_matrimonial:hash_tocken_id
                },
                cache: false,
                success: function(html) {
                    $('.no_of_married_brother').html('');
                    $('.mob_no_of_married_brother').html('');
                    $('.no_of_married_brother').show();
                    $('.mob_no_of_married_brother').show();
                    $('.no_of_married_brother').append(html);
                    $('.mob_no_of_married_brother').append(html);
                }
            });
    } else{
        $('.no_of_married_brother').prop('selected', false);
        $('.mob_no_of_married_brother').prop('selected', false);
        $('#web_no_of_married_brother').hide();
        $('#mob_no_of_married_brother').hide();
    }
} 
function show_sis_details_new() {
        var sister = $('.no_of_sisters').val();	
        var opt = '';
        if(sister == '4 +'){
            sister = 5;
        }
        var base_url = $('#base_url_admin').val();
        var hash_tocken_id = $('#hash_tocken_id').val();
        if(sister!='' && sister!='No') {
            $('#web_no_of_married_sister').show();
            $('#mob_no_of_married_sister').show();
            $.ajax({
				url: base_url+'register/married_brother_list_new',
				type: 'post',
				data: {
					count_sister:sister,
					csrf_new_matrimonial:hash_tocken_id
				},
				cache: false,
				success: function(html){
					$('.no_of_married_sister').html('');
					$('.mob_no_of_married_sister').html('');
					$('.no_of_married_sister').show();
					$('.mob_no_of_married_sister').show();
					$('.no_of_married_sister').append(html);
					$('.mob_no_of_married_sister').append(html);
            	}
        	});
        } else{
            $('.no_of_married_sister').prop('selected', false);
            $('.mob_no_of_married_sister').prop('selected', false);
            $('#web_no_of_married_sister').hide();
            $('#mob_no_of_married_sister').hide();
        }
    } 
</script>