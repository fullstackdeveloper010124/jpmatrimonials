    
</div>
<style>
.info-tab ul .l1:after{
    width: 99px;
}
.info-tab .nav-tabs li:nth-child(2).active:before{
    top: 45px;
    left: -225px;
}
.info-tab .nav-tabs li:nth-child(3).active:before{
    width: 146%;
    top: 45px;
    left: -182px;
}
.info-tab .nav-tabs li:nth-child(4).active:before{
    top: 45px;
    left: -169px;
}
.info-tab .nav-tabs li:nth-child(5).active:before{
    width: 154%;
    top: 45px;
    left: -109px;
}
</style>
    <div class="container-fluid new-width width-95">
        <div class="row row-box">
            <div class="info-bg-main clearfix">
                <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                    <div class="tab info-tab hidden-sm hidden-xs" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs info-tab-nav" role="tablist" id="ss1">
                            <li role="presentation" class="active-dot l1 "><a href="#" id="l1" class="f-18 active-class-red li1 m-active-c" role="tab">
                     Basic Information</a></li>
                            <li role="presentation" class="l2"><a href="#" id="l2" class="active-class-grey f-18 li2" role="tab">
                     Education Qualification</a></li>
                            <li role="presentation" class="l3"><a href="#" id="l3" class="active-class-grey f-18 li3" role="tab">
                     Food / Lifestyle</a></li>
                            <li role="presentation" class="l4"><a href="#" id="l4" class="active-class-grey f-18 li4" role="tab">
                     Horoscope</a></li>
                            <li role="presentation" class="l5"><a href="#" id="l5" class="active-class-grey f-18 li5" role="tab">
                    Upload Photo</a></li>
                        </ul>
                    </div>
                </div>
                <div class="container w-sm-100">
                <div class="new-msg-success reponse_message"></div>
                    <div class="row">
                        <div id="basic-info-tab" class="tab-pane active" role="tabpanel">
                        <form method="post" id="register_step1" name="register_step1" action="<?php echo $base_url; ?>register/save-register-step/step1" onSubmit="return validat_function('1','next-to-education-detail')">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                           
                            <div class="col-md-9 col-sm-12 col-xs-12 padding-zero">
                                <label class="Poppins-Bold f-18 color-31 prf_l1">Some Basic Information</label>
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
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>

                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                    $ele_array = array(
									
                                        'total_children'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('total_children'),'value_curr'=>0,'extra'=>'disabled','onchange'=>'display_childern_status()'),
                                        'status_children'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('status_children'),'value_curr'=>0,'extra'=>'disabled'),
                                        
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                        
                                        <?php 
                                    $ele_array = array(
									
                                        'mother_tongue'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('mothertongue'),'label'=>'Mother Tongue'),
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <button onClick="return validat_function('1','next-to-education-detail')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                    <input type="button" class="next-step" style="display:none" id="next-to-education-detail" />
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            
                            <div class="col-md-9 col-sm-12 col-xs-12 padding-zero mt-5">
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
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>

                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                    $ele_array = array(
									
                                        'part_height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner From Height",'class'=>'select2'),
                                        'part_height_to'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner To Height",'class'=>'select2'),
                                        
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
                                    </div>
                                    
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('1','next-to-education-detail-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f" >Save and continue </button>
                                            <input type="button" class="next-step" style="display:none" id="next-to-education-detail-m" />
                                            <!-- <a href="#" id="next-to-education-detail-m" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f" role="button">Next</a> -->
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--Education tab start-->
                        <div style="display:none;" class="tab-pane" role="tabpanel" id="education-info-tab">
                        <form method="post" id="register_step2" name="register_step2" action="<?php echo $base_url; ?>register/save-register-step/step2"  onSubmit="return validat_function('2','next-to-food-lifestyle-tab')">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                       
                            <div class="col-md-9 col-sm-12 col-xs-12">
							 <label class="Poppins-Bold f-18 color-31 prf_l1">Education Qualification</label>
                                <div class="info-main-box">
                                    <div class="row">
                                    <?php 
                                    $ele_array = array(
									
                                        'education_detail'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('education_detail'),'label'=>'Education','extra_style'=>'width:100%'),
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register_multiple'));
                                    $ele_array = array(                                        
                                        'employee_in'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'extra_style'=>'width:100%'),
                                    );
								    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                    $ele_array = array(
									
									'income'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income','extra_style'=>'width:100%'),
                                    'occupation'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('occupation'),'label'=>'Occupation','class'=>'select2','extra_style'=>'width:100%'),
                                    
                                        
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
                                    </div>
                                    <div class="row mt-6 mtm-0">
                                    <?php 
                                    $ele_array = array(
									
									'designation'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->dropdown_array_table('designation'),'extra_style'=>'width:100%'),
                                        
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
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
                                            
                                            <a id="back-to-basic-info-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step"> Previous</a>
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
                            <form method="post" id="register_step3" name="register_step3" action="<?php echo $base_url; ?>register/save-register-step/step3" onSubmit="return validat_function('3','next-to-horoscope-tab')">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                           
                            <div class="col-md-9 col-sm-12 col-xs-12">
							 <label class="Poppins-Bold f-18 color-31 prf_l1">Food / Lifestyle</label>
                                <div class="info-main-box">
                                    <div class="row">
                                    <?php 
                                    $ele_array = array(
                                        'height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'extra_style'=>'width:100%'),
                                        'weight'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->weight_list(),'extra_style'=>'width:100%'),
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));?>
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
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <button onClick="return validat_function('3','next-to-horoscope-tab-m')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                            <input type="button" class="next-step" style="display:none" id="next-to-horoscope-tab-m" />
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-food-lifestyle-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step"> Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                <button onClick="return validat_function('3','next-to-horoscope-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                <input type="button" class="next-step" style="display:none" id="next-to-horoscope-tab" />

                                <a id="back-to-food-lifestyle-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step"> Previous</a>
                                
                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                            </form>
                        </div>
                        <!--food lifestyle tab End-->
                        <!--horoscope tab start-->
                        <div id="horoscope-info-tab" style="display:none;">
                        <form method="post" id="register_step4" name="register_step4" action="<?php echo $base_url; ?>register/save-register-step/step4" onSubmit="return validat_function(4)">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            <div class="col-md-9 col-sm-12 col-xs-12">
                            <label class="Poppins-Bold f-18 color-31 prf_l1">Religious Information</label>
                                <div class="info-main-box prf_top">
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
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                    <button onClick="return validat_function('4','next-to-uploadphoto-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" >Save and continue </button>
                                    <a id="back-to-horoscope-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step"> Previous</a>

                                    <input type="button" class="next-step" style="display:none" id="next-to-uploadphoto-tab" />

                                    <?php $this->load->view('front_end/register_next_sidebar');?>
                                </div>
                            </div>
                                <div class="col-md-9 col-sm-12 col-xs-12 mt-3">
                                    <label class="Poppins-Bold f-18 color-31 prf_l1">About me</label>
                                    <div class="info-main-box prf_top">
                                        <div class="row mt-6">
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
                                        <!--write something modal End-->
                                        <!--<div class="row mt-6">-->
                                        <!--    <div class="col-md-12 col-sm-12 col-xs-12">-->
                                        <!--        <label class="Poppins-Regular f-16 color-31">Hobby</label>-->
                                        <!--        <span class="color-d f-16 select2-lbl-span">*</span>-->
                                        <!--    </div>-->
                                        <!--    <div class="col-md-12 col-sm-12 col-xs-12">-->
                                        <!--        <textarea rows='5' id='hobby' name="hobby" required class='p-textarea cstm-textarea' placeholder='Write your hobby..'><?php if(isset($row_data['hobby']) && $row_data['hobby'] !=''){ echo $row_data['hobby'];} ?></textarea><br />-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        </form>
                                    </div>
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                        <button onClick="return validat_function('4','next-to-uploadphoto-tab')" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1" role="button">Save and continue </button>
                                            
                                            
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-food-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step" role="button"> Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                        </div>
                        <!--End horoscope Tab-->
                        <!--Upload photo tab start-->
                        <div id="upload-photo-info-tab" style="display:none;">
                        <form method="post" id="register_step5" name="register_step5" action="<?php echo $base_url; ?>register/save-register-step/step5" enctype="multipart/form-data" onSubmit="return validat_function(5)">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                           
                            <div class="col-md-9 col-sm-12 col-xs-12">
							<label class="Poppins-Bold f-18 color-31 prf_l1">Upload Photo</label>
                                <div class="info-main-box">
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
                                                                <!-- <span class="show_btn" id="crop" style="background-color: rgb(7, 90, 133); display: inline;"><i class="fas fa-crop"></i> Crop</span> -->
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
                                                                        <!-- <button type="button" onClick="update_photo1()" id="upload_btn" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Upload</button> -->
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
											if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1']))
											{?>
                                             <p class="Poppins-Medium f-16 color-40 up-t1 blah2"></p>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                            <?php $photo1_val = $this->common_model->path_photos.$row_data['photo1'];?>
                                                <img id="blah" src="<?php echo $base_url.$photo1_val; ?>" alt="" class="img-responisve placeholder-no-image" style="object-fit: contain;">
                                                </div>
                                                <?php
											}
											else
											{
                                                ?>
                                                <p class="Poppins-Medium f-16 color-40 up-t1 blah2">No Profile Picture available
                                                </p>
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                <img id="blah" src="<?php echo $base_url.$photo1_val; ?>" alt="" class="img-responisve placeholder-no-image" style="object-fit: contain;">
                                                </div>
											<?php }
										?>
                                               
                                        </div>
                                       
                                    </div>
                                    <!--Start Diferent Button In mobile and tablet device-->
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a href="<?php echo $base_url.'register/successful' ?>" id="xyz_1" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f " role="button">Save and Complete </a>
                                            
                                        </div>
                                    </div>
                                    <div class="row-cstm">
                                        <div class="hidden-lg hidden-md col-sm-12 col-xs-12">
                                            <a id="back-to-horoscop-tab-m" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 prev-step" role="button"> Previous</a>
                                        </div>
                                    </div>
                                    <!--End Diferent Button In mobile and tablet device-->
                                </div>
                            </div>
                            <div class="col-md-3 hidden-sm hidden-xs">
                                <div class="reg-sidebar">
                                
                                    <a href="<?php echo $base_url.'register/successful' ?>" id="xyz_2" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f ">Save and Complete </a>
                                    <a id="backk-to-horoscope-tab" class="btn btn-info sidebar-btn sidebar-back-btn Poppins-Medium f-16 mt-3 prev-step"> Previous</a>
                                   
                                   
                                    

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
                            </form>
                        </div>
                        <!--End upload photo tab-->
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
<!-- <script src="<?php //echo $base_url; ?>assets/front_end_new/js/jquery.sticky.js?ver=<?php //echo filemtime('assets/front_end_new/js/jquery.sticky.js');?>"></script> -->
<script src="<?php echo $base_url;?>assets/front_end_new/js/common.js?ver=<?php echo filemtime('assets/front_end_new/js/common.js');?>"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/jquery.validate.min.js?ver=<?php echo filemtime('assets/front_end_new/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo $base_url;?>assets/front_end_new/js/additional-methods.min.js?ver=<?php echo filemtime('assets/front_end_new/js/additional-methods.min.js');?>"></script>

<script>
function show_btn(){
	$('#upload_btn').hide();
}
$(document).ready(function(){
    //dropdownChange('country_id','state_id','state_list')
  $('[data-toggle="tooltip"]').tooltip(); 
});
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
    function hr_hide_show(id) 
	{
		alert(id);
		$("#l2").removeClass("active-class-grey");
		$("#l2").addClass("active-class-red");
		$(".l2").addClass("active");
	}
    $('.leftMenuCall').on('click', function(){
        document.getElementById("mySidenav").style.width = "100%";
        document.getElementById("rightSideNav").style.width = "0";
	});
    $('.closeLeftMenuBtn').on('click', function(){
        document.getElementById("mySidenav").style.width = "0";
	});
    $('.rightMenuCall').on('click', function(){
        document.getElementById("rightSideNav").style.width = "100%";
        document.getElementById("mySidenav").style.width = "0";
	});
    $('.closeRightMenuBtn').on('click', function(){
        document.getElementById("rightSideNav").style.width = "0";
	});
</script>
<script>
var base_url = '<?php echo $base_url; ?>';
$( document ).ready(function() {
   
   //dropdownChange('country_id','state_id','state_list');
    //dropdownChange('state_id','city','city_list');
	$('select').select2();
	$('select:not(.skip-me)').select2();
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
	select2('#mother_tongue','Select Mother Tongue');
	old_photo_url = '';
	
	display_total_childern();
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
    if(form_id == 4)
    {
       if($("#register_step"+form_id).length > 0)
        {
            $("#register_step"+form_id).validate({
                rules: {
                    subcaste: {
                        lettersonly: true
                    },
                    gothra: {
                        lettersonly: true
                    },
                },
                submitHandler: function(form)
                {
                    
                    $(".reponse_message").removeClass('alert alert-success alert-danger');
                    $(".reponse_message").html("<i class='fa fa-spinner' aria-hidden='true'></i> Updating your profile, Please Don't close your browser.");
                    $(".reponse_message").addClass('alert alert-warning');
                    //alert(form_id);
                    if(form_id !=5)
                    {
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
                                    $(".reponse_message").addClass('alert alert-success');
                                    stoptimeout();
                                    starttimeout('.reponse_message');
                                    //$(".info-main-box").css("top", "0");
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
	else if($("#register_step"+form_id).length > 0)
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
								$(".reponse_message").addClass('alert alert-success');
								stoptimeout();
								starttimeout('.reponse_message');
                                //$(".info-main-box").css("top", "0");
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
    <?php
    if(isset($this->common_model->extra_js_fr) && $this->common_model->extra_js_fr !='' && count($this->common_model->extra_js_fr) > 0){
    	$extra_js_fr = $this->common_model->extra_js_fr;
    	foreach($extra_js_fr as $extra_js_fr_val){?>
    	   <script src="<?php echo $base_url.'assets/front_end_new/'.$extra_js_fr_val;?>?ver=<?php echo filemtime('assets/front_end_new/'.$extra_js_fr_val);?>"></script>
    <?php }
    }?>
    <?php include_once("page_part/log_reg_menu_script.php");?>
</body>
</html>