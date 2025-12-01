<style>

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border: none !important;
}

  ul {
    padding: 0;
    margin: 0;
  }

  .steps-box-advance {
    height: 80px;
    background: #fff;
    box-shadow: 0px 0px 7px 1px #f0f0f0;
    padding: 16px 30px;
    margin-top: 40px;
    border-radius: 10px;
  }

  .sell_prf_contens #progressbarContainer {
    display: grid;
    padding: 0px 25px;
  }

  #emptyProgressbar {
    height: 1px;
    width: 100%;
    margin: 22.5px 0;
    background: #DDE2EC;
  }

  #completedProgress {
    margin-top: -23.5px;
    width: 0;
    height: 1px;
    /* background: #f00; */
    background: #3c763d;
    transition: 0.5s;
  }

  #progressbarContainer .step-sell-top {
    width: 100%;
    display: flex;
    list-style: none;
    justify-content: space-between;
    position: relative;
    margin-top: -12px;
  }

  #progressbarContainer .step-sell-top li {
    width: 24px;
    height: 24px;
    line-height: 18px;
    padding: 2px;
    color: #f00;
    text-align: center;
    border: 1px solid #DDE2EC;
    border-radius: 100%;
    background: #fff;
    transition: 0.5s;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .activeStep {
    border-color: #DDE2EC !important;
    color: #f00 !important;
    padding: 5px !important;
  }

  .step-circle {
    height: 24px;
    width: 24px;
    /* background: var(--white); */
    border-radius: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
  }

  .activeStep .step-circle::after {
    content: '\f111';
    font-family: 'FontAwesome';
    font-size: 16px;
  }

  .step-label-tt {
    display: flex;
    justify-content: space-between;
  }

  .next-step-btn button,.next-step-btn a {
    width: 100%;
    height: 57px;
    border: none;
    outline: none;
    background: #f00;
    border-radius: 10px;
    color: #fff;
    font-size: 16px;
    font-family: 'Poppins-Medium', sans-serif !important;
    margin-bottom: 20px;
  }

  .back-step-btn button {
    width: 100%;
    height: 57px;
    border: none;
    outline: none;
    background: #fff;
    border-radius: 10px;
    color: #676767;
    font-size: 16px;
    margin-bottom: 20px;
    font-family: 'Poppins-Medium', sans-serif !important;
    border: 1px solid #8F8F8F;
    transition: all 0.7s ease-in-out;
  }

  .cstm-textarea {
    width: 100%;
  }

  /* register section code  */
  .adv-regist-side.reg-sidebar {
    float: unset;
    padding: 0px 4px;
    border-radius: 4px;
  }

  .register-steps-bn .stepPage {
    padding: 20px 30px;
    border-radius: 4px;
  }
  .ni-to{
    left: 200px !important;
  }
    @media only screen and (max-width: 600px) {
        .heightWeight {
            width: 111% !important;
        }
    }
    .new-partner{
        margin-top: 10px !important;
        margin-bottom: 0px !important;
    }
  
</style>

<body>
  <div class="container">
    <div class="col-12">
      <div class="steps-box-advance">
        <div id="progressbarContainer">
          <div id="emptyProgressbar"></div>
          <div id="completedProgress"></div>
          <ul class="step-sell-top">
            <li id="stepLable1">
              <div class="step-circle"></div>
            </li>
            <li id="stepLable2">
              <div class="step-circle"></div>
            </li>
            <li id="stepLable3">
              <div class="step-circle"></div>
            </li>
            <li id="stepLable4">
              <div class="step-circle"></div>
            </li>
          </ul>
          <ul class="step-label-tt hidden-xs hidden-sm">
            <li>Basic Information</li>
            <li style="position: relative; left: 14px;">Horoscope</li>
            <li style="position: relative; left: 63px;">Location Information</li>
            <li>Education Qualification</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="steps-sec-mains">
        <div class="new-partner reponse_message"></div>
        <div class="stepPage" id="stepPage1" style="display: none;">
            <div class="row ">
                <form method="post" id="register_step1" class="registerForm" name="register_step1" action="<?php echo $base_url; ?>register/save-profile/part-basic-detail">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Update Partner Preference Information</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
                                        $religion_arr = $this->common_model->dropdown_array_table('religion');
                                        $education_name_arr = $this->common_model->dropdown_array_table('education_detail');
                                        $occupation_arr = $this->common_model->dropdown_array_table('occupation');
                                        $income_arr = $this->common_model->dropdown_array_table('annual_income');
                                        $designation_arr = $this->common_model->dropdown_array_table('designation');
                                        $country_arr = $this->common_model->dropdown_array_table('country_master');
                                        $insert_id = $this->session->userdata('recent_reg_id');
                                        if(isset($insert_id) && $insert_id != '' )
                                        {
                                            $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id,'is_deleted'=>'No'),1);
                                            if(isset($row_data) && $row_data !='' && count($row_data) > 0)
                                            {
                                                $this->common_front_model->edit_row_data = $row_data;
                                                $this->common_model->edit_row_data = $row_data;
                                                $this->common_model->mode= 'edit';
                                                $this->common_front_model->mode= 'edit';
                                            }
                                            else{
                                                echo '<script>window.location="'.$base_url.'register";</script>';
                                            }
                                        }
                                        $ele_array = array(
                                            'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select form-control new-chosen-height','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        ?>
                                    </div>
                                    <div class="row mt-4 heightWeight" style="width: 104%;">
                                        <?php
                                            $mobile_ddr = '';  
                                            $row_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$insert_id,'is_deleted'=>'No'),1);
                                            $this->common_front_model->edit_row_data = $row_data;
                                            $this->common_model->edit_row_data = $row_data;
                                            $this->common_model->mode= 'edit';
                                            $this->common_front_model->mode= 'edit';
                                            
                                            $part_frm_age = $row_data['part_frm_age'];
                                            $part_to_age = $row_data['part_to_age'];
                                            $array_age  = $this->common_model->age_rang();
                                            
                                            $mobile_ddr= '
                                                <div class="col-md-6 col-sm-6 col-xs-12 mtm-20">
                                                    <label class="Poppins-Regular f-16 color-31">Partner’s Age</label>
                                                    <span class="color-d f-16 select2-lbl-span">*</span>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="select_box2">
                                                                <select name="part_frm_age" id="part_frm_age" class="form-control width-cstm" data-validetta="required">
                                                                    <option value="">Select from age</option>';
                                                                    foreach($array_age as $from_age=>$value)
                                                                    {	
                                                                        $select_ed_drp = '';
                                                                        if($from_age == $part_frm_age)
                                                                        {
                                                                            $select_ed_drp = 'selected';
                                                                        }
                                                                        $mobile_ddr.= '<option '.$select_ed_drp.' value='.$from_age.'>'.$value.'</option>';
                                                                    }
                                                                $mobile_ddr.='</select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="select_box2">
                                                                <select name="part_to_age" id="part_to_age" class="form-control width-cstm" data-validetta="required">
                                                                    <option value="">Select to age</option>';
                                                                    foreach($array_age as $to_age=>$to_value)
                                                                    {	
                                                                        $select_ed_drp = '';
                                                                        if($to_age == $part_to_age)
                                                                        {
                                                                            $select_ed_drp = 'selected';
                                                                        }
                                                                        $mobile_ddr.= '<option '.$select_ed_drp.' value='.$to_age.'>'.$to_value.'</option>';
                                                                    }
                                                                $mobile_ddr.='</select>
                                                            </div>
                                                        </div>
                                                        <p class="Poppins-Bold-font f-14 color-a8 ni-to">To</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12 mtm-20">
                                                    <label class="Poppins-Regular f-16 color-31">Partner’s Height</label>
                                                    <span class="color-d f-16 select2-lbl-span">*</span>
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="select_box2">
                                                                <select name="part_height" id="part_height" class="form-control width-cstm" data-validetta="required">';
                                                                    $height = $this->common_model->height_list();
                                                                    $part_height = $row_data['part_height'];
                                                                    $part_height_to = $row_data['part_height_to'];
                                                                    foreach($height as $part_form_height=>$part_height_value)
                                                                    {	
                                                                        $select_ed_drp = '';
                                                                        if($part_form_height == $part_height)
                                                                        {
                                                                            $select_ed_drp = 'selected';
                                                                        }
                                                                        $mobile_ddr.= '<option '.$select_ed_drp.' value='.$part_form_height.'>'.$part_height_value.'</option>';
                                                                    }
                                                                $mobile_ddr.='</select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                                            <div class="select_box2">
                                                                <select name="part_height_to" id="part_height_to" class="form-control width-cstm" data-validetta="required">';
                                                                    foreach($height as $part_to_height=>$height_value)
                                                                    {	
                                                                        $select_ed_drp = '';
                                                                        if($part_to_height == $part_height_to)
                                                                        {
                                                                            $select_ed_drp = 'selected';
                                                                        }
                                                                        $mobile_ddr.= '<option '.$select_ed_drp.' value='.$part_to_height.'>'.$height_value.'</option>';
                                                                    }
                                                                $mobile_ddr.=' </select>
                                                            </div>
                                                        </div>
                                                        <p class="Poppins-Bold-font f-14 color-a8 ni-to">To</p>
                                                    </div>
                                                </div>';
                                            echo  $mobile_ddr;
                                        ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php 
                                        $ele_array = array(	
                                            'part_bodytype'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Partner Body type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                             'part_diet'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Partner Eating Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),

                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php 
                                        $ele_array = array(	
                                            'part_smoke'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Partner Smoking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                             'part_drink'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Partner Drinking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),     
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
          
                                <div class="row mt-4 mtm-0">
                                    <?php 
                                        $ele_array = array(	
                                            'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Partner Mother Tongue','extra_style'=>'width:100%'),         
                                            'part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Partner Complexion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'part_expect'=>array('type'=>'textarea','label'=>'Expectations','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-6"> 
                            <div class="col-lg-8 col-md-12 col-sm-12">
                                </div>
                                <div class="col-lg-4 col-md-7 col-sm-12">
                                    <div class="next-step-btn cst-next-btn">
                                        <button class="submitRegisterbtn" data-formId='1' id="next" >Save and continue</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="info-main-box mt-3">
                            <div class="adv-regist-side reg-sidebar">
                                <div class="row mt-5">
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="next-step-btn cst-next-btn">
                                            <button class="submitRegisterbtn" data-formId='1' id="next" >Save and continue</i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view('front_end/register_next_sidebar');?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="stepPage" id="stepPage2" style="display: none;">
            <div class="row ">
                <form method="post" id="register_step2" name="register_step2" action="<?php echo $base_url; ?>register/save-profile/part-religious-detail">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Add Religious Preferences Information To Make Stronger Your Profile</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $ele_array = array(	
                                            'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Partner Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                             'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Partner Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php
                                        $ele_array = array(	
                                            'part_manglik'=>array('is_multiple'=>'yes','display_placeholder'=>'No','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('manglik'),'label'=>'Partner Manglik','extra_style'=>'width:100%'),
                                             'part_star'=>array('type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('star'),'label'=>'Partner Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                            
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-6">
                                <div class="col-lg-4 col-md-5 col-sm-12">
                                </div>
                                <div class="col-lg-4 col-md-5 col-sm-6">
                                    <div class="back-step-btn">
                                        <button type="button" id="prev"class="prevBtn"> Previous </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-7 col-sm-6">
                                    <div class="next-step-btn cst-next-btn">
                                        <button id="next" class="submitRegisterbtn" data-formId="2">Save and continue</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="info-main-box mt-3">
                            <div class="adv-regist-side reg-sidebar">
                                <div class="row mt-5">
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="back-step-btn">
                                            <button type="button" id="prev"class="prevBtn"> Previous</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="next-step-btn cst-next-btn">
                                            <button id="next" class="submitRegisterbtn" data-formId="2">Save and continue</i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view('front_end/register_next_sidebar');?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="stepPage" id="stepPage3" style="display: none;">
            <div class="row ">
                <form method="post" id="register_step3" name="register_step3" action="<?php echo $base_url; ?>register/save-profile/part-location-detail">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Add Location Preferences Information To Make Stronger Your Profile</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $state_load_special = 'yes';
                                        $city_load_special = 'yes';
                                        if(isset($row_data['part_country_living']) && $row_data['part_country_living'] !='')
                                        {
                                            $state_load_special = 'no';
                                        }
                                        if(isset($row_data['part_state']) && $row_data['part_state'] !='')
                                        {
                                            $city_load_special = 'no';
                                        }
                                        $ele_array = array(	
                                            'part_country_living'=>array('type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Partner Country','onchange'=>"dropdownChange_mul('part_country_living','part_state','state_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                            'part_state'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id','cus_rel_col_val'=>'part_country_living','not_load_add_special'=>$state_load_special),'label'=>'State','onchange'=>"dropdownChange_mul('part_state','part_city','city_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','label'=>'Partner State','extra_style'=>'width:100%'),
                                            
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
    
                                <div class="row mt-4 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'part_city'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id','cus_rel_col_val'=>'part_state','not_load_add_special'=>$city_load_special),'label'=>'Partner City','class'=>'select2 city_list_update','is_multiple'=>'yes','display_placeholder'=>'No','extra_style'=>'width:100%'),
                                           'part_resi_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'label'=>'Partner Residence Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-6">
                                <div class="col-lg-4 col-md-5 col-sm-12"></div>
                                <div class="col-lg-4 col-md-5 col-sm-6">
                                    <div class="back-step-btn">
                                        <button id="prev" type="button"class="prevBtn"> Previous </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-7 col-sm-6">
                                    <div class="next-step-btn cst-next-btn">
                                        <button id="next" class="submitRegisterbtn" data-formId="3">Save and continue</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="info-main-box mt-3">
                            <div class="adv-regist-side reg-sidebar">
                                <div class="row mt-5">
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="back-step-btn">
                                            <button type="button" id="prev"class="prevBtn"> Previous</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="next-step-btn cst-next-btn">
                                            <button id="next" class="submitRegisterbtn" data-formId="3">Save and continue</i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view('front_end/register_next_sidebar');?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="stepPage" id="stepPage4" style="display: none;">
            <div class="row ">
                <form method="post" id="register_step4" name="register_step4" action="<?php echo $base_url; ?>register/save-profile/part-education-detail">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Add Education Preferences Information To Make Stronger Your Profile</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $ele_array = array(
                                            'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Partner Education','extra_style'=>'width:100%'),
                                             'part_employee_in'=>array('is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'label'=>'Partner Employed In','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php
                                        $ele_array = array(
                                            'part_occupation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$occupation_arr,'label'=>'Partner Occupation','class'=>'select2','extra_style'=>'width:100%'),
                                             'part_designation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$designation_arr,'label'=>'Partner Designation','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-4 mtm-0">
                                    <?php
                                        $ele_array = array(
                                            'part_income'=>array('type'=>'dropdown','is_multiple'=>'no','display_placeholder'=>'no','class'=>'input-ctm-group select2','value_arr'=>$income_arr,'label'=>'Partner Annual Income','class'=>'select2','extra_style'=>'width:100%'),
                                            // 'part_income'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Partner Annual Income','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-6">
                                 <div class="col-lg-4 col-md-5 col-sm-12"></div>
                                <div class="col-lg-4 col-md-5 col-sm-6">
                                    <div class="back-step-btn">
                                        <button type="button" id="prev"class="prevBtn"> Previous </button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-7 col-sm-6">
                                    <div class="next-step-btn cst-next-btn">
                                        <button id="next" class="submitRegisterbtn" data-formId="4">Save and continue</i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <div class="info-main-box mt-3">
                            <div class="adv-regist-side reg-sidebar">
                                <div class="row mt-5">
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="back-step-btn">
                                            <button type="button" id="prev"class="prevBtn"> Previous</button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                        <div class="next-step-btn cst-next-btn">
                                            <button id="next" class="submitRegisterbtn" data-formId="4">Save and continue</i></button>
                                        </div>
                                    </div>
                                </div>
                                <?php $this->load->view('front_end/register_next_sidebar');?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="lightbox-panel-mask"></div>
    <div id="lightbox-panel-loader" style="text-align:center"><img alt="Please wait.." title="Please wait.." src='<?php echo $base_url; ?>assets/front_end/images/loading.gif' /></div>
    <?php
    $this->common_model->user_ip_block();
    if(base_url()!='http://192.168.1.111/mega_matrimony/original_script/'){
        $uri_segment_check_red = $this->uri->segment(1);
        if(isset($uri_segment_check_red) && $uri_segment_check_red!=''){
            $uri_segment_check_red = $this->uri->segment(1);
        }
        else{
            $uri_segment_check_red = basename($_SERVER['PHP_SELF']);
        }
        if(isset($uri_segment_check_red) && $uri_segment_check_red!='' && $uri_segment_check_red!="blocked"){
            $details = $this->common_model->add_user_analysis();
        }
    }
    ?>

    <script src="<?php echo $base_url;?>assets/home_2/js/jquery.js?v=<?php echo filemtime('assets/home_2/js/jquery.js') ?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/bootstrap.js?ver=<?php echo filemtime('assets/front_end_new/js/bootstrap.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/select2.js?ver=<?php echo filemtime('assets/front_end_new/js/select2.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/jquery.validate.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery.validate.min.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/additional-methods.min.js?ver=<?php echo filemtime('assets/front_end_new/js/additional-methods.min.js');?>"></script>
    <script>
        $(document).ready(function(){
            $('select').select2();
            select2('#education_detail','Select Education');
            select2('#languages_known','Select Languages Known');
            select2('#part_complexion','Select Complexion');
            select2('#looking_for','Select Looking For');
            select2('#part_mother_tongue','Select Mother Tongue');
            select2('#part_bodytype','Select Body type');
            select2('#part_diet','Select Eating Habit');
            select2('#part_smoke','Select Smoking Habit');
            select2('#part_drink','Select Drinking Habit');
            select2('#part_religion','Select Partner Religion');
            select2('#part_caste','Select Partner Caste');
            select2('#part_manglik','Select Partner Manglik');
            select2('#part_star','Select Partner Star');

            select2('#part_country_living','Select Partner Country');
            select2('#part_state','Select Partner State');
            select2('#part_city','Select Partner City');
            select2('#part_resi_status','Select Partner Residence Status');

            select2('#part_education','Select Partner Education');
            select2('#part_employee_in','Select Partner Employed In');
            select2('#part_occupation','Select Partner Occupation');
            select2('#part_designation','Select Partner Designation');
            select2('#part_income','Select Partner Income');

            // Click On Submit Button : 
            $('.submitRegisterbtn').click(function(e){
                var formId = $(this).attr('data-formId');
                validat_function(formId);
            });
            $('.prevBtn').click(function(e){
                prev();
            });
            
        });
        
        // sell step profile 
        var currentStep = 1;
        var stepsNum = $('.step-label-tt').find('li').length;
        // show default page
        document.getElementById("stepPage" + currentStep).style.display = "block";
        document.getElementById("stepLable" + currentStep).classList.add("activeStep");
        // change step from current active step to a new active (next or previous)
        function changeStep(active, newActive) {
            document.getElementById("stepPage" + active).style.display = "none";
            document.getElementById("stepPage" + newActive).style.display = "block";
            var activeStepL = document.getElementsByClassName("activeStep")[0];
            activeStepL.classList.remove("activeStep");
            var newActiveStepL = document.getElementById("stepLable" + newActive);
            newActiveStepL.classList.add("activeStep");
            var p = (100 / (stepsNum - 1)) * (newActive - 1);
            document.getElementById("completedProgress").style.width = p + "%";
            if (active < newActive) {
                activeStepL.classList.add("completedStep");
                activeStepL.innerHTML = "<i style='font-size:16px' class='fa fa-check text-success'></i>"
            }
            if (newActiveStepL.classList.contains("completedStep")) {
                newActiveStepL.classList.remove("completedStep");
                newActiveStepL.innerHTML = '<div class="step-circle"></div>';
            }
        }

        function next() {
            if (currentStep >= stepsNum) {
                // alert("complete :)");
            } else {
            changeStep(currentStep, currentStep + 1);
            currentStep++;
            document.getElementById("prev").style.visibility = "visible";
            }
        }
        function prev() {
            if (currentStep >= 2) {
                changeStep(currentStep, currentStep - 1);
                currentStep--;
                if (currentStep < 2) {
                    document.getElementById("prev").style.visibility = "hidden";
                }
            }
        }
        function validat_function(form_id) {
            if($("#register_step"+form_id).length > 0) {
                $("#register_step"+form_id).validate({
                    submitHandler: function(form) {
                        $(".reponse_message").removeClass('alert alert-success alert-danger');
                        $(".reponse_message").html("<i class='fa fa-spinner' aria-hidden='true'></i> Updating your profile, Please Don't close your browser.");
                        $(".reponse_message").addClass('alert alert-warning');
                        if(form_id == 1){
                            var fromage = $("#part_frm_age option:selected").val();
                            var toage = $("#part_to_age option:selected").val();
                            totage =  toage - fromage;
                            if(totage < 1) {
                                $(".reponse_message").addClass('alert alert-danger');
                                $(".reponse_message").html("<strong>Partner From Age</strong> is Always Less Than To <strong>Partner To Age</strong>.");
                                $(".reponse_message").show();
                                stoptimeout();
                                    starttimeout('.reponse_message');
                                return false;
                            }
                            var partheight = $("#part_height option:selected").val();
                            var partheightto = $("#part_height_to option:selected").val();
                            height =  partheightto - partheight;
                            if(height < 1) {
                                $(".reponse_message").addClass('alert alert-danger');
                                $(".reponse_message").html("<strong>Partner From Height</strong> is Always Less Than To <strong>Partner To Height</strong>.");
                                $(".reponse_message").show();
                                stoptimeout();
                                    starttimeout('.reponse_message');
                                return false;
                            }
                        }
                        var form_data = $('#register_step'+form_id).serialize();
                        form_data = form_data+ "&is_post=0";
                        var action = $('#register_step'+form_id).attr('action');
                        $.ajax({
                            url: action,
                            type: "post",
                            dataType:"json",
                            data: form_data,
                            success:function(data) {
                                update_tocken(data.tocken);
                                $(".reponse_message").removeClass('alert alert-success alert-danger alert-warning');
                                $(".reponse_message").html(data.errmessage);
                                $(".reponse_message").slideDown();
                                if(data.status == 'success') {
                                    if(form_id == 4){
                                        setTimeout(function () {
                                            window.location.href = "<?php  echo base_url('premium-member'); ?>";
                                        }, 2000);
                                    }
                                    $(".reponse_message").addClass('alert alert-success');
                                    stoptimeout();
                                    starttimeout('.reponse_message');
                                    next();
                                } else {
                                    $(".reponse_message").addClass('alert alert-danger');
                                }
                            }
                        });
                        return false;
                    }
                });
            }
        }
        function chkabouteme() {
            $('#myModal111').modal('hide'); 
            var aboutemedemo = $('#aboutemedemo').val();
            String.prototype.replaceArray = function(find, replace) {
                var replaceString = this;
                var regex; 
                for (var i = 0; i < find.length; i++) {
                    regex = new RegExp(find[i], "g");
                    replaceString = replaceString.replace(regex, replace[i]);
                }
                return replaceString;
            };
            var textarea = aboutemedemo;
            var find = ["_", "Type of Family", "Ex. religious believes, moral values & respect for elders", "<",">", "Ex. good", "Ex. trekking, going on trips with friends, listening to classical music & watching latest movies" ];
            var replace = ["", "", "", "", "","", "", "", "", "", ""];
            textarea = textarea.replaceArray(find, replace);
            $('#profile_text').val(textarea);
        }
    </script>
    <?php
    if(isset($this->common_model->extra_js_fr) && $this->common_model->extra_js_fr !='' && count($this->common_model->extra_js_fr) > 0){
    	$extra_js_fr = $this->common_model->extra_js_fr;
    	foreach($extra_js_fr as $extra_js_fr_val){?>
    	   <script src="<?php echo $base_url.'assets/front_end_new/'.$extra_js_fr_val;?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_js_fr_val);?>"></script>
    <?php }
    }?>
    <?php include_once("page_part/log_reg_menu_script.php");?>
</body>