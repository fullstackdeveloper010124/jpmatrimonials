<style>
.select2-container--default .select2-selection--multiple {
    background-color: #f8f8f8;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: text;
    padding-bottom: 9px;
    padding-right: 5px;
    position: relative;
    padding: 7px;
    padding-bottom: 15px;
}
.select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100%!important;
}
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #ccc;
    outline: 0;
}
</style>
<div class="col-md-8 col-sm-12 col-xs-12">
    <div class="mega-box-new">
        <div class="m-add-box">
        
            <?php include('search_form_tab.php');?>
            
            <form action="<?php echo $base_url; ?>search/search_now" method="post" id="quick_search_form">
            <div class="add-box-2">
                <?php $curre_gender = $this->common_front_model->get_session_data('gender');
                if($curre_gender == ''){?>
                    <div class="row add-b-cstm">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <p class="Poppins-Medium f-16 color-31 ad-name">Gender:</p>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="add-input">
                                <div class="md-radio new-item-search f-16" onclick="add_gender_class('male')">
                                    <input id="1" type="radio" name="gender" checked value="Male">
                                    <label for="1" class="Poppins-Medium default-color color-d" id="male_id">Male</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="add-input">
                                <div class="md-radio new-item-search f-16" onclick="add_gender_class('female')">
                                    <input id="2" type="radio" name="gender" value="Female">
                                    <label for="2" class="default-color" id="female_id">Female</label>
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
                            <select class="form-control select-cust" name="from_age" id="from_age1" style="height:44px;">
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
                            <select class="form-control gen-m-top  select-cust" name="to_age" id="to_age1" style="height:44px;">
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
                            <select data-placeholder="Select Religion" class="select2 form-control" id="religion1" name="religion[]" multiple tabindex="4" onchange="dropdownChange_mul('religion1','caste1','caste_list')">
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
                        <div class="add-input" id="CasteDiv1">
                            <select data-placeholder="Select Caste" id="caste1" name="caste[]" class="select2 form-control" multiple tabindex="4">
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
                <div class="row add-b-cstm mt-4">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="Poppins-Medium f-16 color-31 ad-name">Country:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="add-input">
                            <select data-placeholder="Select Country" id="country1" name="country[]" class="select2 form-control" multiple tabindex="4" onchange="dropdownChange_mul('country1','state1','state_list')">
                                <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('country_master'));?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row add-b-cstm mt-4">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="Poppins-Medium f-16 color-31 ad-name">State:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="add-input" id="statediv">
                            <select data-placeholder="Select State" class="select2 form-control" tabindex="4" id="state1" name="state[]" multiple onchange="dropdownChange_mul('state1','city1','city_list')">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row add-b-cstm mt-4">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="Poppins-Medium f-16 color-31 ad-name">City:</p>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="add-input" id="citydiv">
                            <select data-placeholder="Select City" class="city_list_update select2 form-control" multiple tabindex="4" id="city1" name="city[]">
                            </select>
                        </div>
                    </div>
                </div>
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
                            <a data-toggle="modal" data-target="#myModal_quick" class="add-w-btn save-search-btn Poppins-Medium color-f f-18" type="submit" ><i class="fas fa-save"></i> Save and Search
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <input type="hidden" name="search_page_nm" value="Quick Search" />
            <input type="hidden" name="save_search" id="quick_save_search" value="" >
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
        </form>
        </div>
    </div>
</div>

<div id="myModal_quick" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_quick" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Save <span class="mega-n4 f-s">Search</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div> 
            <form action="<?php echo $base_url; ?>search/search_now" name="saved_search_form" id="saved_search_form" method="post">
                <div class="modal-body">
                    <input type="text" name="search_name" id="qu_search_name" required placeholder="Enter Save Search Name" class="form-control input-border-modal" style="padding:5px"/>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <button onClick="return save_search('quick_search_form');" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Save and Search</button>
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
function add_gender_class(id){
	if(id=="male"){
		$("#male_id").addClass("color-d");
		$("#male_id").addClass("Poppins-Medium");
		$("#female_id").removeClass("color-d");
		$("#female_id").removeClass("Poppins-Medium");
	}else{
		$("#male_id").removeClass("color-d");
		$("#male_id").removeClass("Poppins-Medium");
		$("#female_id").addClass("color-d");
		$("#female_id").addClass("Poppins-Medium");
	}
}';?>