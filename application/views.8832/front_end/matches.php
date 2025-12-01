<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        	<div class="col-md-9 col-sm-12 col-xs-12">
            	<?php //include_once('my_dashboard_info.php');?>
            	<div class="dshbrd_overlay">
					<div class="dshbrd_color_overlay new-saved-search btn " id="collapse-tab" data-toggle="collapse" data-target="#matchForm" style="width:100%"> 
						<div class="row">
							<div class="col-md-6 col-xs-6">
								<span class="saved-search-i Poppins-Medium" style="float:left"> <i class="fas fa-heart"></i>  Match Criteria
								</span>
							</div>
							<div class="col-md-6 col-xs-6">
								<span class="saved-search-i Poppins-Medium" style="float:right">  <span class="hidden-xs hidden-sm">Click here to change your match criteria &nbsp;&nbsp;&nbsp;&nbsp;</span> <i data-toggle="tooltip" data-placement="top" title="Edit" class="fa fa-pencil"></i>
								</span>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-4 collapse" id="matchForm">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<div class="design-process-content das-content-2 padding-0">
							<div class="box-view-profile" style="padding: 7px 10px 20px 10px;">
                            <div id="reponse_match_making_form"></div>
                            <form method="post" name="match_making_form" id="match_making_form" action="<?php echo $base_url; ?>matches/save-matches" onClick="return validat_function('match_making_form');">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                                <input type="hidden" name="is_post" value="1" />
                                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>"/>

                        		<div id="reponse_ne_lft_pan_list"></div>
                                <?php $member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' ){
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
									$mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
									$religion_arr = $this->common_model->dropdown_array_table('religion');
									$education_name_arr = $this->common_model->dropdown_array_table('education_detail');
									$country_arr = $this->common_model->dropdown_array_table('country_master');
								}?>

									<?php $ele_array = array('looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width: 622px;')
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'matches'));?>
                                    <div class="row add-b-cstm mt-4">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <p class="Poppins-Medium f-16 color-31 ad-name">Age:</p>
                                        </div>
                                        <div class="col-md-3 col-sm-4 col-xs-12">
                                            <div class="add-input">
                                                <select class="form-control select-cust" name="part_frm_age" style="height:44px;">
                                                    <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),$row_data['part_frm_age']);?>
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
                                                <select name="part_to_age" class="form-control gen-m-top select-cust" style="height:44px;">
                                                    <?php echo $this->common_model->array_optionstr_search($this->common_model->age_rang(),$row_data['part_to_age']);?>
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
                                                <select name="part_height" class="form-control select-cust" style="height:44px;">
                                                    <?php echo $this->common_model->array_optionstr_search($this->common_model->height_list(),$row_data['part_height']);?>
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
                                                <select name="part_height_to" class="form-control gen-m-top select-cust" style="height:44px;">
                                                    <?php echo $this->common_model->array_optionstr_search($this->common_model->height_list(),$row_data['part_height_to']);?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
									<?php $ele_array = array('part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Complexion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:622px;'),
									'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue','class'=>'select2','extra_style'=>'width:622px;'),
									'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue','class'=>'select2','extra_style'=>'width:622px;'),
									'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange_mul('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:622px'),
									'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:622px'),
									'part_country_living'=>array('type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Country','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:622px'),
									'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Education','extra_style'=>'width:622px'),);
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'matches'));?>
								<hr class="matches_hr">
								<div class="row add-b-cstm mt-4">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<span class="pull-right left-match">
                                            <input type="submit" onClick="return validat_function('match_making_form');" class="mega-n-btn1 button-zero-s post-s-d Poppins-Regular color-f f-16" value="Save">
                                        </span>
									</div>
								</div>
                                </form>
							</div>
						</div>
					</div>
				</div>
                <div id="main_content_ajax">
                    <?php include('match_result_member_profile.php'); ?>
                </div>
            </div>            
		</div>
	</div>
</div>
<div class="margin-bottom-20"></div>
<?php
$this->common_model->js_extra_code_fr.="
load_choosen_code();

/*if($('#match_making_form').length > 0){
	$('#match_making_form').validate({
		rules: {
			part_religion: {
			  required: true,
			},
			looking_for: {
			  required: true,
			}
		}
	});
}*/
		
function validat_function(form_id){
	if($('#'+form_id).length > 0){
		$('#'+form_id).validate({
			submitHandler: function(form){
				common_ajax_request(form_id);
				$('#collapse-tab').click();
				get_data_ajax(1,'".$base_url.'matches/search-now/'."');
				return false;
			}
		});
	}
}
$('.add-input select').select2();
load_pagination_code_front_end();";
?>