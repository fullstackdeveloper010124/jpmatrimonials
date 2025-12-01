<div class="mt-0"></div>
<?php
 $mobile_val = '';
 $current_count_code = '+91';
if(isset($row_data) && !empty($row_data))
{
    $this->common_front_model->edit_row_data = $row_data;
    $this->common_front_model->mode= 'edit';
    $this->common_model->edit_row_data = $row_data;
    $this->common_model->mode= 'edit';
    

    $mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
    $religion_arr = $this->common_model->dropdown_array_table('religion');
    $education_name_arr = $this->common_model->dropdown_array_table('education_detail');
    $occupation_arr = $this->common_model->dropdown_array_table('occupation');
    $designation_arr = $this->common_model->dropdown_array_table('designation');
    $country_arr = $this->common_model->dropdown_array_table('country_master');
    $income_arr = $this->common_model->dropdown_array_table('annual_income');
    $height = $this->common_model->height_list();
    $weight = $this->common_model->weight_list();
    
    $birth_date = $row_data['birthdate'];

    $birth_ddr_str = $this->common_model->birth_date_picker($birth_date);
    $birth_date_str =  '<div class="col-md-6 col-sm-6 col-xs-12 mt-3">
        	<label class="Poppins-Regular f-16 color-31">Birth Date <span class="color-d f-16 select2-lbl-span">* </span>
        	</label><div style="clear:both;"></div>
        	'.$birth_ddr_str.'
        </div>';
                   
    // Basic Details Edit Section #strat                 
    if ($this->uri->segment(3) == 'basic_info') {
        $element_array = array(
            'firstname'=>array('is_required'=>'required','label'=>'First Name','class'=>'form-control h-44'),
            'lastname'=>array('is_required'=>'required','label'=>'Last Name','class'=>'form-control h-44'),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'marital_status'=>array('is_required'=>'required','class'=>'form-control select-cust w-75 select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'value'=>'Unmarried','onchange'=>'display_total_childern()'),
            'total_children'=>array('is_required'=>'required','class'=>'form-control select-cust w-75 select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('total_children'),'value_curr'=>0,'extra'=>'disabled','onchange'=>'display_childern_status()'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'status_children'=>array('is_required'=>'required','class'=>'form-control select-cust w-75 select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('status_children'),'extra'=>'disabled'),
            'mother_tongue'=>array('is_required'=>'required','type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue','extra_style'=>'width:100%'),
            'b3'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
        );
        $basic_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));

        $element_array = array(
            'languages_known' => array('type'=>'dropdown','id'=>'language','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'form-control dashbrd_cstm select2','value_arr'=>$mother_tongue_arr,'label'=>'Language Known')
        );
        $basic_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));

        $element_array = array(
            'height'=>array('is_required'=>'required','type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$height,'label'=>'Height','extra_style'=>'width:100%'),
            'b4'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'weight'=>array('is_required'=>'required','type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$weight,'label'=>'Weight','extra_style'=>'width:100%'),
            'birthdate'=>array('type'=>'manual','code'=>$birth_date_str),
        );
        $basic_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }       
    // Basic Details Edit Section #end

    // Religious Information Edit Section #start
    if ($this->uri->segment(3) == 'religion_info') {
        $element_array = array(
            'religion'=>array('is_required'=>'required','class'=>'form-control select-cust w-75 select2','type'=>'dropdown','onchange'=>"dropdownChange('religion','caste','caste_list')",'value_arr'=>$religion_arr),
            'caste'=>array('is_required'=>'required','class'=>'form-control select-cust w-75 select2','type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','rel_col_name'=>'religion_id','not_load_add'=>'yes','not_load_add'=>'yes','cus_rel_col_val'=>'religion')),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'subcaste'=>array('label'=>'Sub Caste','class'=>'form-control h-44'),
            'manglik'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('manglik'),'extra_style'=>'width:100%'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'star'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->dropdown_array_table('star'),'extra_style'=>'width:100%'),
            'horoscope'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('horoscope'),'extra_style'=>'width:100%'),
            'b3'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'gothra'=>array('label'=>'Gothra','class'=>'form-control h-44'),
            'moonsign'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->dropdown_array_table('moonsign'),'extra_style'=>'width:100%'),
        );
        $religion_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Religious Information Edit Section #end
    
    // About Me & Hobby Edit Section #start
    if ($this->uri->segment(3) == 'about_me_and_hobby') {
        $element_array = array(
            'profile_text'=>array('type'=>'textarea','label'=>'About Us'),
            // 'hobby'=>array('type'=>'textarea'),
            'birthplace'=>array('label'=>'Birth Place','class'=>'form-control h-44'),
            'birthtime'=>array('label'=>'Birth Time','other'=>'type="time"','class'=>'form-control h-44'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'profileby'=>array('is_required'=>'required','type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('profileby'),'label'=>'Created By'),
            'reference'=>array('is_required'=>'required','type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('reference')),
        );
        $about_me_and_hobby = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // About Me & Hobby Edit Section #end

    // Education & Occupation Information Edit Section #start
    if ($this->uri->segment(3) == 'edu_Occup') {
        $element_array = array(
            'education_detail'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Education','extra_style'=>'width:100%')
        );
        $edu_Occup = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
        ksort($income_arr); 
        $element_array = array(
            'employee_in'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'extra_style'=>'width:100%'),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'income'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$income_arr,'label'=>'Annual Income','class'=>'select2','extra_style'=>'width:100%'),
            // 'income'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income','extra_style'=>'width:100%'),
            'occupation'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$occupation_arr,'label'=>'Occupation','class'=>'select2','extra_style'=>'width:100%'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'designation'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$designation_arr,'extra_style'=>'width:100%')
        );
        $edu_Occup .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Education & Occupation Information Edit Section #end

    // Life Style Details Edit Section #strat 
    if ($this->uri->segment(3) == 'life_style_info') {
        $element_array = array(
            'bodytype'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Body Type'),
            'diet'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Eating Habit','extra_style'=>'width:100%'),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'smoke'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Smoking Habit'),
            'drink'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Drinking Habit'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'complexion'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Skin Tone'),
            'blood_group'=>array('type'=>'dropdown','display_placeholder'=>'Yes','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('blood_group')),
        );
        $life_style_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Life Style Details Edit Section #end

    // Location Details Edit Section #strat 
    if ($this->uri->segment(3) == 'location_info') {

        // for edit mobile number field #start
        $mobile = $row_data['mobile'];
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
        $where_country_code= array(" ( is_deleted ='No' ) GROUP BY country_code,country_name");
        $country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");
        $mobile_ddr= '<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 pl0"  style="padding-left:0px">
        <select name="country_code" id="country_code" required class="form-control select-cust w-75 select2" style="width:100%;">
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
        <div class="col-lg-8 col-md-8  col-sm-12 col-xs-12" style="padding:0px">
        <input type="text" minlength="7" maxlength="13" required name="mobile_num" id="mobile_num" class="form-control h-44" placeholder="Mobile Number" value ="'.$mobile_val.'"  />
        </div>';
        // for edit mobile number field #end


        $element_array = array(
            'country_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Country','class'=>'select2 country_id_update','onchange'=>"dropdownChange_new('country_id_update','state_id_update','state_list')",'extra_style'=>'width:100%'),
            'state_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id',),'label'=>'State','class'=>'select2 state_id_update','onchange'=>"dropdownChange_new('state_id_update','city_update','city_list')",'extra_style'=>'width:100%'),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'city'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id'),'label'=>'City','class'=>'select2 city_update','extra_style'=>'width:100%'),
            'mobile'=>array('type'=>'manual','code'=>'<div class="col-md-6 col-sm-6 col-xs-12">
                    <h5 class="color-profile Poppins-Regular">Mobile <span class="color-d f-16 select2-lbl-span">* </span></h5>
                    '.$mobile_ddr.'
                    <input type="hidden" name="mobile" id="mobile" value="" />
                </div>
                <div class="clearfix"></div>'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'phone'=>array('class'=>'form-control h-44'),
            'time_to_call'=>array('class'=>'form-control h-44'),
            'address'=>array('class'=>'form-control h-44'),
            'residence'=>array('type'=>'dropdown','class'=>'select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('residence')),
        );

        // demo mode for mobile number #start
        if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && $row_data['mobile']  !='')
        {
            $element_array['mobile'] = array('type'=>'manual','code'=>'
            <div class="col-md-4 col-sx-12 col-sm-4">
                <h5 class="color-profile Poppins-Regular">Mobile <span class="color-d f-16 select2-lbl-span">* </span></h5>
                <div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
                    <span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>
                </div>
            </div>');
        }
        // demo mode for mobile number #end

        $location_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Location Details Edit Section #end

    // Family Details Edit Section #strat 
    if ($this->uri->segment(3) == 'family_info') {
        $element_array = array(
            'family_type'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('family_type'),'extra_style'=>'width:100%'),
            'father_name'=>array('class'=>'form-control h-44'),
            'b1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'father_occupation'=>array('lable'=>"Father's Occupation",'class'=>'form-control h-44'),
            'mother_name'=>array('class'=>'form-control h-44'),
            'b2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'mother_occupation'=>array('lable'=>"Mother's Occupation",'class'=>'form-control h-44'),
            'family_status'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('family_status'),'extra_style'=>'width:100%'),    
            'b3'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'no_of_brothers'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2 no_of_brothers','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'extra_style'=>'width:100%','onchange'=>'show_bro_details()'),
            'no_of_married_brother'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2 no_of_married_brother','value_arr'=>$this->common_model->get_list_ddr('no_marri_brother'),'extra_style'=>'width:100%'),
            'b4'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'no_of_sisters'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2 no_of_sisters','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'extra_style'=>'width:100%','onchange'=>'show_sis_details()'),
            'no_of_married_sister'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2 no_of_married_sister','value_arr'=>$this->common_model->get_list_ddr('no_marri_sister'),'extra_style'=>'width:100%'),
			'b5'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'family_details'=>array('type'=>'textarea','extra_style'=>'width:100%','label'=>'About My Family')
        );
        $family_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Family Details Edit Section #end

    // Partner Basic Preferences Edit Section #strat 
    if ($this->uri->segment(3) == 'basic_partner_info') {
        $element_array = array(
            'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Skin Tone','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'p1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
        );
        $basic_partner_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
       
        $element_array = array(
            'part_frm_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"From Age",'class'=>'select2','extra_style'=>'width:100%'),
            'part_to_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"To Age",'class'=>'select2','extra_style'=>'width:100%'),
            'part_height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"From Height",'class'=>'select2','extra_style'=>'width:100%'),
            'part_height_to'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"To Height",'class'=>'select2','extra_style'=>'width:100%'),
            'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue','extra_style'=>'width:100%'),
            'part_expect'=>array('type'=>'textarea','label'=>'Expectations','extra_style'=>'width:100%'),
            'p2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
        );
        $basic_partner_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));

        $element_array = array(
            'part_bodytype'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Body type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'part_diet'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Eating Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'p3'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'part_smoke'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Smoking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'part_drink'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Drinking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
        );
        $basic_partner_info .= $this->common_front_model->generate_common_front_form($element_array,array('enctype'=>'enctype="multipart/form-data"','page_type'=>'my_edit_profile_multiple'));
    }
    // Partner Basic Preferences Edit Section #end

    // Partner Religious Preferences Edit Section #strat 
    if ($this->uri->segment(3) == 'religion_partner_info') {
        $element_array = array(
            'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
            'p1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
        );
        $religion_partner_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
       
        $element_array = array(
            'part_manglik'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('manglik'),'label'=>'Manglik','extra_style'=>'width:100%'),
        );
        $religion_partner_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));

        $element_array = array(
            'part_star'=>array('type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('star'),'label'=>'Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%')
        );
        $religion_partner_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
    }
    // Partner Religious Preferences Edit Section #end

    // Partner Location Preferences Edit Section #strat 
    if ($this->uri->segment(3) == 'location_partner_info') {

        $state_load_special = 'yes';
        $city_load_special = 'yes';
        if(isset($row_data['part_country_living']) && $row_data['part_country_living'] !=''){
            $state_load_special = 'no';
        }
        if(isset($row_data['part_state']) && $row_data['part_state'] !=''){
            $city_load_special = 'no';
        }
        $element_array = array(
            'part_country_living'=>array('type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Country','onchange'=>"dropdownChange_mul_new('country_list_update','state_list_update','state_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2 country_list_update','extra_style'=>'width:100%'),
            'part_state'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id','cus_rel_col_val'=>'part_country_living','not_load_add_special'=>$state_load_special),'label'=>'State','onchange'=>"dropdownChange_mul_new('state_list_update','city_list_update','city_list')",'is_multiple'=>'yes','display_placeholder'=>'No','label'=>'State','class'=>'select2 state_list_update'),
            'p1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'part_city'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id','cus_rel_col_val'=>'part_state','not_load_add_special'=>$city_load_special),'label'=>'City','class'=>'city_list_update select2','is_multiple'=>'yes','display_placeholder'=>'No'),
            'part_resi_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'label'=>'Residence','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%')
        );
        $location_partner_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
    }
    // Partner Location Preferences Edit Section #end

    // Partner Education & Occupation Preferences Edit Section #strat 
    if ($this->uri->segment(3) == 'edu_occup_partner_info') {
        $element_array = array(
            'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Education','extra_style'=>'width:100%'),
            'part_employee_in'=>array('is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'label'=>'Employed In','extra_style'=>'width:100%'),
            'p1'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
            'part_occupation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$occupation_arr,'label'=>'Occupation','class'=>'select2','extra_style'=>'width:100%'),
            'part_designation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$designation_arr,'label'=>'Designation','extra_style'=>'width:100%'),
            'p2'=>array('type'=>'manual','code'=>'<hr class="_hr-edit-profile">'),
        );
        $edu_occup_partner_info = $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile_multiple'));
       
        $element_array = array(
            'part_income'=>array('type'=>'dropdown','is_multiple'=>'no','display_placeholder'=>'no','class'=>'select2','value_arr'=>$income_arr,'label'=>'Annual Income','extra_style'=>'width:100%'),
            // 'part_income'=>array('type'=>'dropdown','class'=>'form-control select-cust w-75 select2','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income','extra_style'=>'width:100%')
        );
        $edu_occup_partner_info .= $this->common_front_model->generate_common_front_form($element_array,array('page_type'=>'my_edit_profile'));
    }
    // Partner Education & Occupation Preferences Edit Section #end
    
}

$formArr = array(
    'basic_info'=> array('title'=>'Basic Details','Url'=>'basic-detail'),
    'religion_info'=> array('title'=>'Religious Information','Url'=>'religious-detail'),
    'about_me_and_hobby'=> array('title'=>'About Me','Url'=>'about-me-detail'),
    'edu_Occup'=> array('title'=>'Education & Occupation ','Url'=>'education-detail'),
    'life_style_info'=> array('title'=>'Life Style Details','Url'=>'life-style-detail'),
    'location_info'=> array('title'=>'Location Details','Url'=>'residence-detail'),
    'family_info'=> array('title'=>'Family Details','Url'=>'family-detail'),
    'basic_partner_info'=> array('title'=>'Basic Preferences','Url'=>'part-basic-detail'),
    'religion_partner_info'=> array('title'=>'Religious Preferences','Url'=>'part-religious-detail'),
    'location_partner_info'=> array('title'=>'Location Preferences','Url'=>'part-location-detail'),
    'edu_occup_partner_info'=> array('title'=>'Education & Occupation Preferences','Url'=>'part-education-detail'),
);
if (in_array($this->uri->segment(3),array_keys($formArr))) { 
    $formKey = $this->uri->segment(3);
?>
<label class="Poppins-Bold f-18 color-31 prf_l1"><?php echo $formArr[$formKey]['title'];?></label>
<div class="info-main-box prf_top" >
<div id="reponse_editFormId"></div>
    <form name="editFormId" id="editFormId" action="<?php echo $base_url.'my-profile/save-profile/'.$formArr[$formKey]['Url'];?>" method="post">
        <div class="row">
        <?php echo $$formKey;?>
        </div>
        <div class="row mt-6 mtm-0">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="hidden" name="formStep" id="formStep" value="<?php echo $formKey;?>">
                <button id="edit-save-btn" class="btn btn-info edit-save-btn Poppins-Medium f-16 color-f" >Save </button>
                <button type="button" id="edit-back-btn" class="btn btn-info edit-back-btn Poppins-Medium f-16" >Back </button>    
            </div>
        </div>
    </form>
</div>

<script>
       $('#edit-back-btn').on('click', function() {
        location.reload();
    });
    $("#part_state").attr(
   "data-placeholder","Select State"
   );
    $("#part_city").attr(
   "data-placeholder","Select City"
   );
   $("#part_income").attr(
    "data-placeholder","Select Income"
   );


   if($("#editFormId").length > 0)
 {
        $("#editFormId").validate({
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
</script>
<?php
}
 ?>