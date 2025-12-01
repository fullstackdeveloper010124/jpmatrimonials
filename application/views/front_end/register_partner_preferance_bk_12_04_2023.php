<style>

.select2-container--default .select2-selection--single .select2-selection__arrow b {
    border: none !important;
}
.ni-to {
    top: 34px !important;
}
.select_box2:after {
    right: 33px !important;
}
        .cstm-logo{
        	padding: 0px 0px !important;
        	position: relative!important;
        	top: -6px!important;
        }
.info-tab .nav-tabs > li {
    padding-left: 50px !important;
}
.info-tab ul .l1:after {
    left: -10px;
}
.info-tab .nav-tabs li:nth-child(2).active:before {
    width: 173% !important;
}
.info-tab .nav-tabs li:nth-child(3).active:before {
    left: -213px;
}
.info-tab ul .l4:after {
    width: 296px!important;
}
        .info-tab ul .l1:after {
            width: 156px !important;
        }
        .info-tab ul .l2:after {
            width: 533px !important;
            left: -158px !important;
        }
        .info-tab .nav-tabs li:nth-child(3).active:before {
            width: 127%;
        }
.info-tab .nav-tabs li:nth-child(4).active:before {
    width: 108%;
}
        .reg-sidebar {
            padding-top: 55px;
        }
        @media only screen and (min-device-width : 320px) and (max-device-width : 480px) {
        .info-tab .nav-tabs > li {
            padding-left: 0px !important;
        }
        .info-tab ul .l2:after {
            width: 0px !important;
            left: 0px !important;
            background: none !important;
        }
        }
        @media only screen and (min-device-width : 768px) and (max-device-width : 1023px) {
        .info-tab .nav-tabs > li {
            padding-left: 0px !important;
        }	
        }
        @media only screen and (min-device-width : 1024px) and (max-device-width : 1223px) {
        .info-tab .nav-tabs > li {
            padding-left: 0px !important;
        }
        .info-tab .nav-tabs li:nth-child(2).active:before {
            background: none !important;
        }
        .info-tab .nav-tabs li:nth-child(3).active:before {
            background: none !important;
        }
        .info-tab .nav-tabs li:nth-child(4).active:before {
            background: none !important;
        }
        .reg-sidebar {
            padding-top: 24px !important;
        }
        }
 </style>
</div>
    
    <!--Add partner Start-->
    <div class="container-fluid new-width width-95" id="prt_prf_main">
    
        <div class="row row-box">
            <div class="info-bg-main clearfix">
                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                    <div class="tab info-tab hidden-sm hidden-xs" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs info-tab-nav" role="tablist" id="ss1">
                        <li role="presentation" class="active-dot l1 "><a href="#" id="l1" class="f-18 active-class-red li1 m-active-c" role="tab">
                     Basic Information</a></li>
                            <li role="presentation" class="l2"><a href="#" id="l2" class="active-class-grey f-18 li2" role="tab">
                     Horoscope</a></li>
                            <li role="presentation" class="l3"><a href="#" id="l3" class="active-class-grey f-18 li3" role="tab">
                     Location Information</a></li>
                            <li role="presentation" class="l4"><a href="#" id="l4" class="active-class-grey f-18 li4" role="tab">
                     Education Qualification</a></li>
                        </ul>
                    </div>
                </div>
                <div class="container w-sm-100">
                    <div class="new-partner reponse_message"></div>
                    <div class="row">
                        <div id="basic-info-tab">
                            <form method="post" id="register_step1" name="register_step1" action="<?php echo $base_url; ?>register/save-profile/part-basic-detail" onSubmit="return validat_function(1)">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <div class="col-md-9 col-sm-12 col-xs-12 padding-zero">
                                <label class="Poppins-Bold f-18 color-31 prf_l1">Update Partner Preference Information</label>
                                <div class="info-main-box prf_top">
                                    <div class="row">
                                    <?php
								//$insert_id = $this->session->userdata('recent_reg_id');
								//$insert_id = $this->common_front_model->get_session_data('id');
								$mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
								$religion_arr = $this->common_model->dropdown_array_table('religion');
								$education_name_arr = $this->common_model->dropdown_array_table('education_detail');
								$occupation_arr = $this->common_model->dropdown_array_table('occupation');
								$designation_arr = $this->common_model->dropdown_array_table('designation');
								$country_arr = $this->common_model->dropdown_array_table('country_master');
									
								$insert_id = $this->session->userdata('recent_reg_id');
								if(isset($insert_id) && $insert_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$insert_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
								}
								
								
								 $ele_array = array(
                                    'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'chosen-select form-control new-chosen-height','extra_style'=>'width:100%'),
                                   
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                            
                                $mobile_ddr = '';
                                                
                                                
                                                $recent_reg_id = $this->session->userdata;
                                                $member_id = $recent_reg_id['recent_reg_id'];
                                                if(isset($member_id) && $member_id != '' )
                                                {
                                                    $row_data = $this->common_model->get_count_data_manual('register_view',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                                    $this->common_front_model->edit_row_data = $row_data;
                                                    $this->common_model->edit_row_data = $row_data;
                                                    $this->common_model->mode= 'edit';
                                                    $this->common_front_model->mode= 'edit';
                                                    
                                                    $part_frm_age = $row_data['part_frm_age'];
                                                    $part_to_age = $row_data['part_to_age'];
                                                    $array_age  = $this->common_model->age_rang();
                                                    
                                                    $mobile_ddr= '<div class="col-md-6 col-sm-6 col-xs-12 mtm-20">
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
                                        </div>
                                    <div class="row mt-6 mtm-0">
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
                                                }else{?>
                                        <div class="col-md-6 col-sm-6 col-xs-12 mtm-20">
                                            <label class="Poppins-Regular f-16 color-31">Partner’s Age</label>
                                            <span class="color-d f-16 select2-lbl-span">*</span>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="select_box2">
                                                        <select name="part_frm_age" id="part_frm_age" class="form-control width-cstm" data-validetta="required">
                                                            <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),18);?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="select_box2">
                                                        <select name="part_to_age" id="part_frm_age" class="form-control width-cstm" data-validetta="required">
                                                            <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),30);?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <p class="Poppins-Bold-font f-14 color-a8 ni-to">To</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                        <div class="col-md-6 col-sm-6 col-xs-12 mtm-20">
                                            <label class="Poppins-Regular f-16 color-31">Partner’s Height</label>
                                            <span class="color-d f-16 select2-lbl-span">*</span>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="select_box2">
                                                        <select name="part_height" id="part_height" class="form-control width-cstm" data-validetta="required">
                                                            <?php echo $this->common_model->array_optionstr_search($this->common_model->height_list(),48);?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-6">
                                                    <div class="select_box2">
                                                        <select name="part_height_to" id="part_height_to" class="form-control width-cstm" data-validetta="required">
                                                            <?php echo $this->common_model->array_optionstr_search($this->common_model->height_list(),60);?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <p class="Poppins-Bold-font f-14 color-a8 ni-to">To</p>
                                            </div>
                                        </div>
                                   <?php
                                                } 
                                    $ele_array = array(	
                                        'part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Partner Complexion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        
                                    );
								    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                    $ele_array = array(	
                                        'part_bodytype'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Partner Body type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_diet'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Partner Eating Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                    
                                    );
								    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                    </div>
                                    
                                    <div class="row mt-6 mtm-0">
                                        <?php 
                                        $ele_array = array(	
                                            'part_smoke'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Partner Smoking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                            'part_drink'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Partner Drinking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                            
                                            
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        ?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                         $ele_array = array(	
                                            'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Partner Mother Tongue','extra_style'=>'width:100%'),
                                            
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        $ele_array = array(	
                                           
                                            'part_expect'=>array('type'=>'textarea','label'=>'Expectations','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));
                                        ?>
                                    </div>
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('1','next-to-education-detail-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                            <input type="button" class="next-step" style="display:none" id="next-to-education-detail-m" />
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <button onClick="return validat_function('1','next-to-education-detail')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                    <input type="button" class="next-step" style="display:none" id="next-to-education-detail" />
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--Education tab start-->
                        <div id="education-info-tab" style="display:none;">
                            
                            <form method="post" id="register_step2" name="register_step2" action="<?php echo $base_url; ?>register/save-profile/part-religious-detail"  onSubmit="return validat_function(2)">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <label class="Poppins-Bold f-18 color-31 prf_l1">Add Religious Preferences Information To Make Stronger Your Profile</label>
                                <div class="info-main-box prf_top">
                                    <div class="row">
                                    <?php 
                                        $ele_array = array(	
                                            'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Partner Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
									        'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Partner Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        ?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(	
                                            'part_manglik'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('manglik'),'label'=>'Partner Manglik','extra_style'=>'width:100%'),
									        'part_star'=>array('type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('star'),'label'=>'Partner Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        ?>
                                    </div>
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('2','next-to-food-tab-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                            <input type="button" class="next-step" style="display:none" id="next-to-food-tab-m" />
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-basic-info-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step" role="button"> Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <button onClick="return validat_function('2','next-to-food-lifestyle-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                    
                                    <a id="return-to-basic-info-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step"> Previous</a>

                                    <input type="button" class="next-step" style="display:none" id="next-to-food-lifestyle-tab" />
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--Education tab End-->
                        <!--food lifestyle tab Start-->
                        <div id="food-lifestyle-info-tab" style="display:none;">
                        <form method="post" id="register_step3" name="register_step3" action="<?php echo $base_url; ?>register/save-profile/part-location-detail" onSubmit="return validat_function(3)">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <label class="Poppins-Bold f-18 color-31 prf_l1">Add Location Preferences Information To Make Stronger Your Profile</label>
                                <div class="info-main-box prf_top">
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
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                        $ele_array = array(	
                                            'part_city'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id','cus_rel_col_val'=>'part_state','not_load_add_special'=>$city_load_special),'label'=>'Partner City','class'=>'select2 city_list_update','is_multiple'=>'yes','display_placeholder'=>'No','extra_style'=>'width:100%'),
                                            'part_resi_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'label'=>'Partner Residence Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                        ?>
                                    </div>
                                    
                                   
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('3','next-to-horoscope-tab-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                            <input type="button" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16" id="next-to-horoscope-tab-m" style="display:none;" value="Skip"/>
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-education-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step" role="button">Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <input type="button" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16" id="next-to-horoscope-tab" value="Skip"/>
                                    <button onClick="return validat_function('3','next-to-horoscope-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1 mt-3" >Save and continue </button>
                                    <a id="back-to-food-lifestyle-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step" role="button">Previous</a>
                                    
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--food lifestyle tab End-->
                        <!--horoscope tab start-->
                        <div id="horoscope-info-tab" style="display:none;">
                        <form method="post" id="register_step4" name="register_step4" action="<?php echo $base_url; ?>register/save-profile/part-education-detail" onSubmit="return validat_function(4)">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <div class="col-md-9 col-sm-12 col-xs-12">
                                <label class="Poppins-Bold f-18 color-31 prf_l1">Add Education Preferences Information To Make Stronger Your Profile</label>
                                <div class="info-main-box prf_top">
                                    <div class="row">
                                    <?php
                                        $ele_array = array(
                                            'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Partner Education','extra_style'=>'width:100%'),
                                            'part_employee_in'=>array('is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'label'=>'Partner Employed In','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                    </div>
                                    <div class="row mt-6">
                                            <?php
                                        $ele_array = array(
                                            
                                            'part_occupation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$occupation_arr,'label'=>'Partner Occupation','class'=>'select2','extra_style'=>'width:100%'),
                                            'part_designation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$designation_arr,'label'=>'Partner Designation','extra_style'=>'width:100%'),

                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                    </div>
                                    <div class="row mt-6">
                                    <?php
                                        $ele_array = array(
                                            'part_income'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Partner Annual Income','extra_style'=>'width:100%'),
                                        );
                                        echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    ?>
                                        
                                    </div>
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('4','next-to-uploadphoto-tab-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and Payment </button>
                                            <input type="button" style="display:none;" id="next-to-uploadphoto-tab-m" name="next"/>
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-food-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16" role="button">Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <button onClick="return validat_function('4','next-to-uploadphoto-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and Payment </button>
                                    <a id="back-to-horoscope-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step">Previous</a>
                                    <input type="button" style="display:none;" id="next-to-uploadphoto-tab" name="next"/>

                                    
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--End horoscope Tab-->
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
<script src="<?php echo $base_url; ?>assets/front_end/js/jquery.min.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end/js/bootstrap.min.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end/js/select2.min.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end/js/jquery.sticky.js?ver=1.0"></script>
<script src="<?php echo $base_url; ?>assets/front_end/js/common.js?ver=1.1"></script>
<script>
$("#next-to-education-detail").click(function () {
	$("#education-info-tab").show();
  	$("#basic-info-tab").hide();
	$(".li2").addClass("active-class-red");
	$(".li2").removeClass("active-class-grey");
	$(".l2").addClass("active");
	$("#l1").addClass("ff-regular");
});
$("#next-to-food-lifestyle-tab").click(function () {
	$("#food-lifestyle-info-tab").show();
  	$("#education-info-tab").hide();
	$(".li3").addClass("active-class-red");
	$(".li3").removeClass("active-class-grey");
	$(".l3").addClass("active");
	$("#l2").addClass("ff-regular");
  
});
$("#next-to-horoscope-tab").click(function () {
	$("#horoscope-info-tab").show();
  	$("#food-lifestyle-info-tab").hide();
	$(".li4").addClass("active-class-red");
	$(".li4").removeClass("active-class-grey");
	$(".l4").addClass("active");
	$("#l3").addClass("ff-regular");
  
});
$("#next-to-uploadphoto-tab").click(function () {
	$("#upload-photo-info-tab").show();
  	$("#horoscope-info-tab").hide();
	$(".li5").addClass("active-class-red");
	$(".li5").removeClass("active-class-grey");
	$(".l5").addClass("active");
	$("#l4").addClass("ff-regular");
	
  
});
$("#backk-to-horoscope-tab").click(function () {
	$("#horoscope-info-tab").show();
	$("#upload-photo-info-tab").hide();
	$(".li5").addClass("active-class-grey");
	$(".li5").removeClass("active-class-red");
	$(".l5").removeClass("active");
	$("#l4").removeClass("ff-regular");
  
});
$("#back-to-horoscope-tab").click(function () {
	$("#food-lifestyle-info-tab").show();
	$("#horoscope-info-tab").hide();
	$(".li4").addClass("active-class-grey");
	$(".li4").removeClass("active-class-red");
	$(".l4").removeClass("active");
	$("#l3").removeClass("ff-regular");
	
});
$("#back-to-food-lifestyle-tab").click(function () {
	$("#education-info-tab").show();
  	$("#food-lifestyle-info-tab").hide();
  	$(".li3").addClass("active-class-grey");
	$(".li3").removeClass("active-class-red");
	$(".l3").removeClass("active");
	$("#l2").removeClass("ff-regular");
});
$("#return-to-basic-info-tab").click(function () {
	$("#education-info-tab").hide();
  	$("#basic-info-tab").show();
	$(".li2").addClass("active-class-grey");
	$(".li2").removeClass("active-class-red");
	$(".l2").removeClass("active");
	$("#l1").removeClass("ff-regular");
  
});

$("#back-to-horoscope-tab").click(function () {
	$("#food-lifestyle-info-tab").show();
	$("#horoscope-info-tab").hide();
	
});

/*for mobile Js*/
$("#next-to-education-detail-m").click(function () {
	$("#education-info-tab").show();
  	$("#basic-info-tab").hide();
	$("#l2").addClass("m-active-c");
	$("#l1").addClass("ff-regular");
  
});

$("#next-to-food-tab-m").click(function () {
	$("#food-lifestyle-info-tab").show();
  	$("#education-info-tab").hide();
	$("#l3").addClass("m-active-c");
	$("#l2").addClass("ff-regular");
	
  
});

$("#next-to-horoscope-tab-m").click(function () {
	$("#horoscope-info-tab").show();
	$("#food-lifestyle-info-tab").hide();
	$("#l4").addClass("m-active-c");
	$("#l3").addClass("ff-regular");
});

$("#next-to-uploadphoto-tab-m").click(function () {
	$("#upload-photo-info-tab").show();
	$("#horoscope-info-tab").hide();
	$("#l5").addClass("m-active-c");
	$("#l4").addClass("ff-regular");
  
});


$("#back-to-horoscop-tab-m").click(function () {
	$("#horoscope-info-tab").show();
	$("#upload-photo-info-tab").hide();
	$("#l5").removeClass("m-active-c");
	$("#l4").removeClass("ff-regular");
  
});

$("#back-to-food-tab-m").click(function () {
	$("#food-lifestyle-info-tab").show();
	$("#horoscope-info-tab").hide();
	$("#l4").removeClass("m-active-c");
	$("#l3").removeClass("ff-regular");
  
});

$("#back-to-education-tab-m").click(function () {
	$("#food-lifestyle-info-tab").hide();
	$("#education-info-tab").show();
	$("#l3").removeClass("m-active-c");
	$("#l2").removeClass("ff-regular");
  
});
$("#back-to-basic-info-tab-m").click(function () {
	$("#basic-info-tab").show();
	$("#education-info-tab").hide();
	$("#l2").removeClass("m-active-c");
	$("#l1").removeClass("ff-regular");
});

$("#return-to-basic-info-tab-m").click(function () {
	$("#education-info-tab").hide();
  	$("#basic-info-tab").show();
  
});
$("#next-to-food-tab-m").click(function () {
	$("#food-lifestyle-info-tab").show();
  	$("#education-info-tab").hide();
  
});

$("#back-to-food-lifestyle-tab-m").click(function () {
	$("#horoscope-info-tab").hide();
	$("#food-lifestyle-info-tab").show();
  
});

/*partner preference*/
$("#add_partner_pref").click(function () {
	$("#prt_pref_default").hide();
	$("#prt_prf_main").show();
  
});

/*partner preference*/


var base_url = '<?php echo $base_url; ?>';
$( document ).ready(function() {
	$('select').select2();
	$('.nav-tabs > li a[title]').tooltip();
	
	$('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
		var $target = $(e.target);
		if ($target.parent().hasClass('disabled')) {
			return false;
		}
	});
	$(".next-step").click(function (e) {
		var $active = $('.wizard .nav-tabs li.active');
		$active.next().removeClass('disabled');
		nextTab($active);
	});
	$(".prev-step").click(function (e) {
		var $active = $('.wizard .nav-tabs li.active');
		prevTab($active);
	});
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
    select2('#part_star','Select Partner Star');

    select2('#part_country_living','Select Partner Country');
    select2('#part_state','Select Partner State');
    select2('#part_city','Select Partner City');
    select2('#part_resi_status','Select Partner Residence Status');

    select2('#part_education','Select Partner Education');
    select2('#part_employee_in','Select Partner Employed In');
    select2('#part_occupation','Select Partner Occupation');
    select2('#part_designation','Select Partner Designation');
	old_photo_url = '';
	$('#profil_photo').bind('change', function()
	{
		var size = this.files[0].size;
		var mb_size = size/(1024*1024);
		if(mb_size > 2 )
		{
			$(".reponse_photo").removeClass('alert alert-success alert-danger');
			$(".reponse_photo").html("File uploaded Size is to large, Please upload another file.");
			$(".reponse_photo").addClass('alert alert-danger');
			//document.getElementById('blah').src = base_url+ 'assets/front_end/images/icon/no-image.jpg';
		}
		else
		{
			var ext = $('#profil_photo').val().split('.').pop().toLowerCase();
			if($.inArray(ext, ['gif','png','jpg','jpeg','bmp']) == -1)
			{
				$(".reponse_photo").removeClass('alert alert-success alert-danger');
				$(".reponse_photo").html("Please upload only Image file only.");
				$(".reponse_photo").addClass('alert alert-danger');
				//document.getElementById('blah').src = base_url+ 'assets/front_end/images/icon/no-image.jpg';
			}
			else
			{
				document.getElementById('blah').src = window.URL.createObjectURL(this.files[0]);
				$(".reponse_photo").html("<i class='fa fa-spinner' aria-hidden='true'></i> Please Wait while uploading your photo..");
				$(".reponse_photo").addClass('alert alert-warning');

				var form_data = new FormData(document.getElementById("register_step5"));
				hase_tocke_val = $("#hash_tocken_id").val();
				form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>', hase_tocke_val);
				form_data.append('is_post', 0);
				//alert(form_data);
				var action = $('#register_step5').attr('action');
				//alert(action);
				 $.ajax({
					url: action,
					type: 'POST',
					data: form_data,
					cache: false,
					dataType: 'json',
					processData: false,
					contentType: false,
					success: function(data)
					{
						update_tocken(data.tocken);
						$(".reponse_photo").removeClass('alert alert-success alert-danger alert-warning');
						$(".reponse_photo").html(data.errmessage);
						$(".reponse_photo").slideDown();
						if(data.status == 'success')
						{
							$(".reponse_photo").addClass('alert alert-success');
							stoptimeout();
							starttimeout('.reponse_message');
						}
						else
						{
							/*if(data.old_photo_url !='')
							{
								//alert(data.old_photo_url);
								//$("#blah").attr('src',old_photo_url);
								//document.getElementById('blah').src = old_photo_url;
							}*/
							//$('#profil_photo').val('');
							$(".reponse_photo").addClass('alert alert-danger');
						}
					}
				});
			}
		}
	});
	
});
function nextTab(elem) {
	$(elem).next().find('a[data-toggle="tab"]').click();
	scroll_to_div('step1_li');
}
function prevTab(elem) {
	$(elem).prev().find('a[data-toggle="tab"]').click();
	scroll_to_div('step1_li');
}
<!--About me-->
function chkabouteme()
{
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
function validat_function(form_id,button_id)
{
	if($("#register_step"+form_id).length > 0)
	{
		$("#register_step"+form_id).validate({
			submitHandler: function(form)
			{
				$(".reponse_message").removeClass('alert alert-success alert-danger');
				$(".reponse_message").html("<i class='fa fa-spinner' aria-hidden='true'></i> Updating your profile, Please Don't close your browser.");
				$(".reponse_message").addClass('alert alert-warning');
				//alert(form_id);
				if(form_id !=5)
				{
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
					//show_comm_mask();
					$.ajax({
					   url: action,
					   type: "post",
					   dataType:"json",
					   data: form_data,
					   success:function(data)
					   {
							update_tocken(data.tocken);
							$(".reponse_message").removeClass('alert alert-success alert-danger alert-warning');
							$(".reponse_message").html(data.errmessage);
							$(".reponse_message").slideDown();
							if(data.status == 'success')
							{
								if(form_id == 4){
									setTimeout(function () {
										window.location.href = "<?php  echo base_url('premium-member'); ?>";
									}, 2000);
								}
								$(".reponse_message").addClass('alert alert-success');
								stoptimeout();
								starttimeout('.reponse_message');
                                $("#"+button_id).trigger('click');
							}
							else
							{
								$(".reponse_message").addClass('alert alert-danger');
							}
					   }
					});
				}
				else
				{
						
					//alert('In file upload');
				}
				return false;
			}
		});
	}
}
</script>
<?php include_once("page_part/log_reg_menu_script.php");?>
</body>
</html>