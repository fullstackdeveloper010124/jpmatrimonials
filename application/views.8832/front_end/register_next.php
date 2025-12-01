<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
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

  .next-step-btn a {
    padding-top: 17px;
  }
  .next-step-btn a:hover {
    color: #FFF !important;
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
  .new-msg-success{
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
            <li id="stepLable5">
              <div class="step-circle"></div>
            </li>
          </ul>
          <ul class="step-label-tt hidden-xs hidden-sm">
            <li>Basic Information</li>
            <li style="position: relative; right: 50px;">Education Qualification</li>
            <li style="position: relative; right: 50px;">Food / Lifestyle</li>
            <li style="position: relative; right: 10px;">Horoscope</li>
            <li>Upload Photo</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="steps-sec-mains">
        <div class="new-msg-success reponse_message"></div>
        <div class="stepPage" id="stepPage1" style="display: none;">
            <div class="row ">
                <form method="post" id="register_step1" class="registerForm" name="register_step1" action="<?php echo $base_url; ?>register/save-register-step/step1">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Some Basic Information</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
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
                                            'country_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('country_master'),'label'=>'Country','class'=>'js-example-basic-single mega-select2','onchange'=>"dropdownChange('country_id','state_id','state_list')"),
                                            'state_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id'),'label'=>'State','class'=>'select2','onchange'=>"dropdownChange('state_id','city','city_list')"),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'city'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id'),'label'=>'City','class'=>'select2'),
                                            'marital_status'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'value_curr'=>'','onchange'=>'display_total_childern()'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'total_children'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('total_children'),'value_curr'=>0,'extra'=>'disabled','onchange'=>'display_childern_status()'),
                                            'status_children'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('status_children'),'value_curr'=>0,'extra'=>'disabled'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'mother_tongue'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('mothertongue'),'label'=>'Mother Tongue'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                            </div>
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Some Basic Partner Preferences</label>
                            <div class="info-main-box prf_top">
                                <div class="row">
                                    <?php
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
                                        }
                                        $ele_array = array(
                                            'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select form-control new-chosen-height skip-me'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'part_frm_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner From Age",'class'=>'select2'),
                                            'part_to_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner To Age",'class'=>'select2'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'part_height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner From Height",'class'=>'select2'),
                                            'part_height_to'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner To Height",'class'=>'select2'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                            </div>
                            <div class="row mt-6">
                                <div class="col-lg-8 col-md-7 col-sm-6"></div>
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
                <form method="post" id="register_step2" name="register_step2" action="<?php echo $base_url; ?>register/save-register-step/step2">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Education Qualification</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $ele_array = array(
                                            'education_detail'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('education_detail'),'label'=>'Education','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'employee_in'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'extra_style'=>'width:100%'),
                                            'income'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'no','display_placeholder'=>'Yes','class'=>'input-groupedu select2','value_arr'=>$this->common_model->dropdown_array_table('annual_income'),'label'=>'Annual Income','extra_style'=>'width:100%'),
                                            // 'income'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'occupation'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('occupation'),'label'=>'Occupation','class'=>'select2','extra_style'=>'width:100%'),
                                            'designation'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('designation'),'extra_style'=>'width:100%'),
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
                <form method="post" id="register_step3" name="register_step3" action="<?php echo $base_url; ?>register/save-register-step/step3">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Food / Lifestyle</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $ele_array = array(
                                            'height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'extra_style'=>'width:100%'),
                                            'weight'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->weight_list(),'extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'diet'=>array('label'=>'Eating Habit','is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'extra_style'=>'width:100%'),
                                            'smoke'=>array('label'=>'Smoking Habit','is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'value'=>'No','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'drink'=>array('label'=>'Drinking Habit','is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'value'=>'No','extra_style'=>'width:100%'),
                                            'bodytype'=>array('label'=>'Body Type','is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'complexion'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Skin Tone','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
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
                <form method="post" id="register_step4" name="register_step4" action="<?php echo $base_url; ?>register/save-register-step/step4">
                    <div class="col-md-9 register-steps-bn">
                        <div class="agree-prof-main">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Horoscope</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <?php
                                        $ele_array = array(
                                            'subcaste'=>array('label'=>'Sub Caste','class'=>'form-control reg_input'),
                                            'manglik'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('manglik'),'extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'star'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('star'),'extra_style'=>'width:100%'),
                                            'horoscope'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('horoscope'),'extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                                <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(
                                            'gothra'=>array('label'=>'Gothra','class'=>'form-control reg_input'),
                                            'moonsign'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('moonsign'),'extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                    ?>
                                </div>
                            </div>
                            <label class="Poppins-Bold f-18 color-31 prf_l1">About me</label>
                            <div class="info-main-box prf_top" style="min-height: 0px;">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <label class="Poppins-Regular f-16 color-31">Write something about yourself</label>
                                        <span class="color-d f-16 select2-lbl-span">*</span>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <textarea id="profile_text" class="p-textarea cstm-textarea" cols="46" rows="6" placeholder="Write something.." name="profile_text" required aria-required="true" aria-invalid="false"><?php if(isset($row_data['profile_text']) && $row_data['profile_text'] !=''){ echo $row_data['profile_text'];} ?></textarea>
                                    </div>
                                </div>
                                <div class="row mt-3 mtm-0">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <span class="Poppins-Regular f-14 textarea-class">Help me write About Yourself </span><a href="#myModal111" data-toggle="modal"><span class="color-d">Click Here</span></a>
                                        <a href="#" data-toggle="tooltip" class="tootltip-cstm" title="" data-original-title="If you don't want to write whole sentences than you can direct by suggestions"><i class="fa fa-question-circle que-mark"></i></a>
                                    </div>
                                </div>
                                <!--write something modal start-->
                                <div id="myModal111" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-vendor">
                                        <div class="modal-content">
                                            <div class="modal-header new-header-modal">
                                                <p class="Poppins-Bold mega-n3 new-event text-center">Write Aboute <span class="mega-n4 f-s">Me</span></p>
                                                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <textarea name="aboutemedemo" cols="46" rows="6" class="p-textarea cstm-textarea" id="aboutemedemo">I come from a/an &lt;Type of Family&gt; family. The most important thing in my life is &lt;Ex. religious believes, moral values &amp; respect for elders&gt;.  I am modern thinker but also believe in &lt;Ex. good&gt; values given by our ancestors. I love __&lt;Ex. trekking, going on trips with friends, listening to classical music &amp; watching latest movies&gt;.
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-md-12 col-sm-3 col-xs-12">
                                                        <div class="left-zero" style="margin:10px auto;display:table;">
                                                            <a class="add-w-btn Poppins-Medium color-f f-18" onclick="chkabouteme()" style="cursor: pointer;"> Submit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        <div class="stepPage" id="stepPage5" style="display: none;">
            <div class="row ">
                <div class="col-md-9 register-steps-bn">
                    <div class="agree-prof-main">
                        <form method="post" id="register_step5" name="register_step5" action="<?php echo $base_url; ?>register/save-register-step/step5" onSubmit="return validat_function('1','next-to-education-detail')">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Upload Photo</label>
                            <div class="info-main-box prf_top">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                <div class="row">
                                    <div class="col-md-7 col-sm-12 col-xs-12 border-right">
                                        <p class="Poppins-Medium f-16 color-40 up-t1">
                                            Add your photo and get much better responses!
                                        </p>
                                        <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                            <div class="a-94 mt-10">
                                            <div class="reponse_photo"></div>
                                            <label class="fileUploadbtn btn btn-default btn-file a-95 Poppins-Regular f-14 color-f" data-toggle="modal" data-target="#myModal_pic" onClick="set_photo_number(1)">
                                                Upload From Computer
                                            </label>
                                        </div>
                                    </div>
                                    <div id="myModal_pic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_pic" aria-hidden="true" style="z-index: 9999;">
                                        <div class="modal-dialog modal-dialog-photo-crop">
                                            <div class="modal-content">
                                                <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                                                    <p class="Poppins-Bold mega-n3 new-event text-center">Upload <span class="mega-n4 f-s">Image</span></p>
                                                    <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container_photo">
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding:10px;">
                                                                <div id="response_message"></div>
                                                            </div>
                                                        </div>
                                                        <div class="imageBox" style="display:none">
                                                            <div class="mask"></div>
                                                            <div class="thumbBox"></div>
                                                            <div class="spinner" style="display: none">Loading...</div>
                                                        </div>
                                                        <div class="tools clearfix">
                                                            <div class="upload-wapper color-f f-16 ">
                                                                <i class="fas fa-images"></i> Browse 
                                                                <input type="file" id="upload_file" value="Upload" />
                                                            </div>
                                                            <span class="show_btn color-f f-16" id="rotateLeft"><i class="fa fa-undo" aria-hidden="true"></i> Rotate Left</span>
                                                            <span class="show_btn color-f f-16" id="rotateRight"><i class="fa fa-repeat" aria-hidden="true"></i> Rotate Right</span>
                                                            <span class="show_btn color-f f-16" id="zoomOut"><i class="fas fa-search-plus"></i> zoom In</span>
                                                            <span class="show_btn color-f f-16" id="zoomIn"><i class="fas fa-search-minus"></i> zoom Out</span>
                                                            <input type="hidden" id="croped_base64" name="croped_base64" value="" />
                                                            <input type="hidden" id="orig_base64" name="orig_base64" value="" />
                                                            <input type="hidden" id="photo_number" name="photo_number" value="" />
                                                        </div>
                                                        <span class="show_btn">Drag image and select proper image</span>
                                                        <div class="tools clearfix"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 padding-zero text-center crop_img_11" style="padding: 0px 36.4%">
                                                            <div id="croped_img" style="display: flex;justify-content: center;"></div>
                                                        </div>
                                                    </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-12 col-sm-3 col-xs-12">
                                                                <span class="pull-right float-none">
                                                                    <button type="button" id="crop_register" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18" style="width: 140px;">Crop & Upload</button>
                                                                    <button type="button" class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-sm-12 col-xs-12 col-5-main">
                                        <?php
                                            $photo1_val = $this->common_model->no_image_found;
                                            if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1'])) { ?>
                                                <p class="Poppins-Medium f-16 color-40 up-t1 blah2"></p>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php $photo1_val = $this->common_model->path_photos.$row_data['photo1'];?>
                                                <img id="blah" src="<?php echo $base_url.$photo1_val; ?>" alt="" class="img-responisve placeholder-no-image" style="object-fit: contain;">
                                                </div>
                                            <?php } else { ?>
                                                <p class="Poppins-Medium f-16 color-40 up-t1 blah2">No Profile Picture available
                                                </p>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                <img id="blah" src="<?php echo $base_url.$photo1_val; ?>" alt="" class="img-responisve placeholder-no-image" style="object-fit: contain;">
                                                </div>
                                        <?php } ?>  
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-6">
                              <div class="col-lg-4 col-md-5 col-sm-12"></div>
                            <div class="col-lg-4 col-md-5 col-sm-6">
                                <div class="back-step-btn">
                                    <button id="prev"class="prevBtn"> Previous </button>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-sm-6">
                                <div class="next-step-btn cst-next-btn">
                                    <a class="btn" href="<?php echo $base_url.'register/successful' ?>" id="next" onclick="next()">Save and continue</i></a>
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
                                        <button id="prev"class="prevBtn"> Previous</button>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-6 pl-0 pr-0">
                                    <div class="next-step-btn cst-next-btn">
                                        <a class="btn" href="<?php echo $base_url.'register/successful' ?>" id="next" onclick="next()">Save and continue</i></a>
                                    </div>
                                </div>
                            </div>
                            <p class="Poppins-Regular f-14 color-40 reg-caption-1 pt-4">Important Notes</p>
                            <div class="reg-img-box mt-5">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="Poppins-Regular f-12 color-40 img-t1 content-dot">
                                            The maximum file size for uploads in this demo is <span class="Poppins-Bold f-12 color-40">2000 KB</span> (default file size is unlimited).
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-img-box mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="Poppins-Regular f-12 color-40 img-t1 content-dot">
                                            image files <span class="Poppins-Bold f-12 color-40">(JPG, GIF, PNG)</span> are Not allowed in this demo (by default there is no file type restriction).
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="reg-img-box mt-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="Poppins-Regular f-12 color-40 img-t1 content-dot">Only PDF or Word files are allowed in this demo (by default there is no file type restriction).
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

    <script src="<?php echo $base_url;?>assets/front_end_new/js/jquery-3.2.1.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery-3.2.1.min.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/bootstrap.js?ver=<?php echo filemtime('assets/front_end_new/js/bootstrap.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/select2.js?ver=<?php echo filemtime('assets/front_end_new/js/select2.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/jquery.validate.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery.validate.min.js');?>"></script>
    <script src="<?php echo $base_url;?>assets/front_end_new/js/additional-methods.min.js?ver=<?php echo filemtime('assets/front_end_new/js/additional-methods.min.js');?>"></script>
    <script>
        $(document).ready(function(){
            $('select').select2();
	        $('select:not(.skip-me)').select2();
            select2('#education_detail','Select Education');
            select2('#languages_known','Select Languages Known');
            select2('#part_complexion','Select Complexion');
            select2('#looking_for','Select Looking For');
            select2('#mother_tongue','Select Mother Tongue');

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
                            if(totage < 1)
                            {
                                
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
                            if(height < 1)
                            {
                                
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