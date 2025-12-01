<div class="col-md-8 col-sm-12 col-xs-12">
    <div class="mega-box-new">
        <div class="m-add-box">
            <?php include('search_form_tab.php');?>
            <div class="add-box-2" id="add_i_cstm2">
                <form action="<?php echo $base_url; ?>search/search_now" method="post" enctype="multipart/form-data" id="advance_search_form">
                    <?php $curre_gender = $this->common_front_model->get_session_data('gender');
                    if($curre_gender == ''){?>
                        <div class="row add-b-cstm">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <p class="Poppins-Medium f-16 color-31 ad-name">Gender:</p>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="add-input">
                                    <div class="md-radio new-item-search f-16" onclick="add_gender_class_2('male')">
                                        <input id="3" type="radio" name="gender" value="Male" checked>
                                        <label for="3" class="Poppins-Medium default-color color-d" id="male_id6">Male</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4">
                                <div class="add-input">
                                    <div class="md-radio new-item-search f-16" onclick="add_gender_class_2('female')">
                                        <input id="4" type="radio" name="gender" value="Female">
                                        <label for="4" class="default-color" id="female_id6">Female</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Age:</p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="add-input">
                                <select class="form-control select-cust" name="from_age" id="from_age" style="height:44px;">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),18);?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm hidden-xs">
                            <div class="add-input to-n">
                                <label class="text-center font-w-n">To</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="add-input">
                                <select class="form-control gen-m-top  select-cust" name="to_age" id="to_age" style="height:44px;">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),30);?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Height:</p>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="add-input">
                                <select class="form-control select-cust" style="height:44px;" name="from_height">
                                    <option value="">From</option>
                                    <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 col-xs-12 hidden-sm hidden-xs">
                            <div class="add-input to-n">
                                <label class="text-center font-w-n">To</label>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <div class="add-input">
                                <select class="form-control gen-m-top select-cust" style="height:44px;" name="to_height">
                                <option value="">To</option>
                                    <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Marital status:</p>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="add-input">
                                <select data-placeholder="Select Marital Status" class="select2 form-control new-chosen-height" multiple tabindex="4" name="looking_for[]">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('marital_status'));?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Religion:</p>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="add-input">
                                <select data-placeholder="Select Religion" class="select2 form-control" id="religion" name="religion[]" multiple tabindex="4" onchange="dropdownChange_mul('religion','caste','caste_list')">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('religion'));?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Caste:</p>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="add-input">
                                <select data-placeholder="Select Caste" id="caste" name="caste[]" class="select2 form-control" multiple tabindex="4">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-4">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Mother Tongue:</p>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="add-input">
                                <select data-placeholder="Select Mother Tongue" name="mothertongue[]" class="select2 form-control" multiple tabindex="4">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('mothertongue'));?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-3">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Photo Setting:</p>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div class="add-input checkbox_search">
                                <div class="checkboxes" style="margin-top:13px;">
                                    <label class="checkbox">
                                        <input type="checkbox" value="photo_search" name="photo_search">
                                        <span class="indicator"></span>
                                        With Photo
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-xs-12">
                            <div class="add-input new-accordion">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 data-toggle="collapse" data-parent="#accordion" data-target="#location" class="panel-title ">                          
                                                <i class="fa fa-plus pull-right"></i>
                                                <span class="hover-l"> Location Details</span>
                                            </h4>
                                        </div>
                                       
                                        <div id="location" class="panel-collapse collapse">
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Country:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Country" id="country" name="country[]" class="select2 form-control" multiple tabindex="4" onchange="dropdownChange_mul('country','state','state_list')">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('country_master'));?>
                                                        </select>
                                                        <div id="stateDivloader_adv"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">State:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select State" class="select2 form-control" id="state" name="state[]" multiple onchange="dropdownChange_mul('state','city','city_list')">
                                                        </select>
                                                        <div id="cityDivloader_adv"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">City:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select City" class="city_list_update select2 form-control" id="city" name="city[]" multiple>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="panel panel-default mt-4">
                                        <div class="panel-heading">
                                            <h4 data-toggle="collapse" data-parent="#accordion" data-target="#education" class="panel-title ">
                                                <i class="fa fa-plus pull-right"></i>
                                                <span class="hover-l">Education / Occupation / Annual Income Details</span>
                                            </h4>
                                            
                                          
                                           
                                        </div>
                                        
                                        <div id="education" class="panel-collapse collapse">
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Education:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Education" name="education[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('education_detail'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Occupation:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Occupation"  name="occupation[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('occupation'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Employee In:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Employee In"  name="employee_in[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('employee_in'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Annual Income:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Annual Income" name="income[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('annual_income'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                       <div class="panel panel-default mt-4">
                                        <div class="panel-heading">
                                            <h4 data-toggle="collapse" data-parent="#accordion" data-target="#eating" class="panel-title ">
                                                <i class="fa fa-plus pull-right"></i>
                                                <span class="hover-l">Eating Habits / Drinking Habits/ Smoking Habits Details</span>
                                            </h4>
                                        </div>
                                        <div id="eating" class="panel-collapse collapse">
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Eating Habits:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Eating Habits" class="select2 form-control" multiple tabindex="4" name="diet[]">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('diet'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Drinking Habits:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Drinking Habits" name="drink[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('drink'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name">Smoking Habits:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Smoking Habits" name="smoking[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('smoke'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="panel panel-default mt-4">
                                        <div class="panel-heading">
                                            <h4 data-toggle="collapse" data-parent="#accordion" data-target="#appearance" class="panel-title ">
                                                <i class="fa fa-plus pull-right"></i>
                                                <span class="hover-l">Appearance</span>
                                            </h4>
                                        </div>
                                        <div id="appearance" class="panel-collapse collapse">
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name"> Complexion:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Complexion" class="select2 form-control" multiple tabindex="4" name="complexion[]">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('complexion'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name"> Body type :</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Body type"  name="bodytype[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('bodytype'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="panel panel-default mt-4">
                                        <div class="panel-heading">
                                            <h4 data-toggle="collapse" data-parent="#accordion" data-target="#horoscope" class="panel-title ">
                                                <i class="fa fa-plus pull-right"></i>
                                                <span class="hover-l">Horoscope Details</span>
                                            </h4>
                                        </div>
                                        <div id="horoscope" class="panel-collapse collapse">
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name"> Star:</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Star" class="select2 form-control" multiple tabindex="4" name="star[]">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('star'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row add-b-cstm mt-4">
                                                <div class="col-md-4 col-sm-4 col-xs-12">
                                                    <p class="Poppins-Medium f-16 color-31 ad-name"> Manglik :</p>
                                                </div>
                                                <div class="col-md-8 col-sm-8 col-xs-12">
                                                    <div class="add-input">
                                                        <select data-placeholder="Select Manglik" name="manglik[]" class="select2 form-control" multiple tabindex="4">
                                                            <?php echo $this->common_model->array_optionstr($this->common_model->get_list_ddr('manglik'));?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row add-b-cstm mt-5">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="add-ad-btn">
                                <button type="submit" class="add-w-btn Poppins-Medium color-f f-18"><i class="fas fa-search"></i> Search</button>
                            </div>                        
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <?php if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0){?>
                                <a data-toggle="modal" data-target="#myModal_advance" class="add-w-btn save-search-btn Poppins-Medium color-f f-18" type="submit" ><i class="fas fa-save"></i> Save and Search
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                    <input type="hidden" name="search_page_nm" value="Advance Search" />
                    <input type="hidden" name="save_search" id="adv_save_search" value="" >
                </form>
            </div>
        </div>
    </div>
</div>

<div id="myModal_advance" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_advance" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Save <span class="mega-n4 f-s">Search</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div> 
            <form action="<?php echo $base_url; ?>search/search_now" name="advance_search_form" id="advance_search_form" method="post">
                <div class="modal-body">
                    <input type="text" name="search_name" id="adv_search_name" required placeholder="Enter Save Search Name" class="form-control input-border-modal" style="padding:5px"/>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <button onClick="return save_search('advance_search_form');" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Save and Search</button>
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
	            </div>
            </form>
        </div>
    </div>
</div>

<?php
$this->common_model->js_extra_code_fr.= '
function add_gender_class_2(id){
	if(id=="male"){
		$("#male_id6").addClass("color-d");
		$("#male_id6").addClass("Poppins-Medium");
		$("#female_id6").removeClass("color-d");
		$("#female_id6").removeClass("Poppins-Medium");
	}else{
		$("#male_id6").removeClass("color-d");
		$("#male_id6").removeClass("Poppins-Medium");
		$("#female_id6").addClass("color-d");
		$("#female_id6").addClass("Poppins-Medium");
	}
}
var selectIds = $("#location,#education,#eating,#appearance,#horoscope");
$(function ($) {
	selectIds.on("show.bs.collapse hidden.bs.collapse", function () {
		$(this).prev().find(".fa").toggleClass("fa-plus fa-minus");
	})
});';