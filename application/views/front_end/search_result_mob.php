<div class="#">
    <button class="btn btn-lg btn-primary-k b-m-mobile" data-toggle="collapse" data-target="#demo"> <i class="fas fa-sliders-h fr-slider-mobile pull-left"></i> Member Filter <i class="fas fa-chevron-down pull-right"></i></button>
    <div id="demo" class="collapse">
        <div class="">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12 hidden-lg hidden-md">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="fr-main">
                                <div class="fr1 hidden-sm hidden-xs">
                                    <p class="fr-cptn1 OpenSans-Regular"><i class="fas fa-sliders-h fr-slider"></i>Member Filter</p>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?php $keyword_curr = $comm_model->get_data_fromArray($search_filed_data,'keyword');?>
                                        <form class="light" action="<?php echo $base_url; ?>search/search_now" name="keyword_search_form" id="keyword_search_form" method="post">
                                            <input type="text" placeholder="Search by Keywords" required name="keyword" value="<?php if(isset($keyword_curr) && $keyword_curr!=''){echo $keyword_curr;}?>">
                                            <button type="submit" class="btn btn-primary filter-btn">Search <i class="fa fa-search fr-search"></i></button>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                            <input type="hidden" name="search_page_nm" value="Keyword Search" />
                                            <input type="hidden" name="save_search" id="save_search" value="" >
                                        </form>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-md-12 col-sm-12 col-xs-12 ffr">
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <hr class="fr hr1">
                                        </div>
                                        <div class="col-md-1 col-sm-2 col-xs-12">
                                            <p class="fr-b OpenSans-Regular">
                                                Or
                                            </p>
                                        </div>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <hr class="fr hr2">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-10">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?php $txt_id_search = $comm_model->get_data_fromArray($search_filed_data,'txt_id_search');?>
                                        <form class="light2" action="<?php echo $base_url; ?>search/search_now" id="id_search_form" method="post">
                                            <input type="text" placeholder="Search by ID" required name="txt_id_search" value="<?php if(isset($txt_id_search) && $txt_id_search!=''){echo $txt_id_search;}?>" >
                                            <input type="hidden" name="search_page_nm" />
                                            <button type="submit" class="btn btn-primary filter-btn">Search <i class="fa fa-search fr-search"></i></button>
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                                            <input type="hidden" name="save_search" id="save_search" value="" >
                                        </form>
                                    </div>
                                </div>
                                <div class="row margin-top-10">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr class="fr hr3">
                                    </div>
                                </div>
                                <form name="frm_filter_mobile" id="frm_filter_mobile" method="post">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
                                    <?php $curre_gender = $this->common_front_model->get_session_data('gender');
                                    if($curre_gender ==''){?>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <p class="fr-height OpenSans-Bold">Gender</p>
                                        </div>
                                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <p class="radio-custm">
                                                <input type="radio" id="m-male" onClick="refine_search_mobile()" value="Male" name="gender" <?php if(isset($gender) && $gender !='' && $gender =='Male'){ echo 'checked';} ?>>
                                                <label for="m-male" class="lbl1">Male</label>
                                            </p>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <p class="radio-custm">
                                                <input type="radio" id="m-fmale" onClick="refine_search_mobile()" value="Female" name="gender" <?php if(isset($gender) && $gender !='' && $gender =='Female'){ echo 'checked';} ?>>
                                                <label for="m-fmale" class="lbl1">Female</label>
                                            </p>
                                        </div>
                                        
                                    </div>
                                <hr class="fr hr3">
								<?php }?>
                               
                                <!--height slider range-->
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p class="fr-height OpenSans-Bold">Height</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="range-slider">
                                        <input type="text" class="js-range-slider" value="" />
                                    </div>
                                    <div class="t-h">
                                        <span class="h1-h">
                                             Below 4 ft
                                            <input type="hidden" name="from_height" id="from_height" value="<?php if(isset($from_height) && $from_height!=''){echo $from_height;}else{ echo '48';}?>">
                                        </span>
                                        <span class="h2-h pull-right">
                                           Above 7 ft
                                            <input type="hidden" name="to_height" id="to_height" value="<?php if(isset($to_height) && $to_height!=''){echo $to_height;}else{ echo '85';}?>">
                                        </span>
                                    </div>
                                </div>
                                <hr class="fr hr3">
                                <!--end range height slider-->
                                <!--age slier range-->
                                <div class="row margin-top-10">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <p class="fr-height OpenSans-Bold">Age</p>
                                    </div>
                                </div>
                                 <?php $from_age = $comm_model->get_data_fromArray($search_filed_data,'from_age');?>
                                <div class="row">
                                    <div class="range-slider">
                                        <input type="text" class="js-range-slider-2" value="" />
                                    </div>
                                    <div class="t-h">
                                        <span class="h1-h">
                                            18 Year
                                            <input type="hidden" name="from_age" id="from_age" value="18">
                                        </span>
                                        <span class="h2-h pull-right">
                                            65 Year
                                            <input type="hidden" name="to_age" id="to_age" value="65">
                                        </span>
                                    </div>
                                </div>
                                <!--end range age slider-->
                                
                                <div class="row margin-top-20">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#m-collapseThree" aria-expanded="false" aria-controls="m-collapseThree">
                                                    Maritial Status
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_marital_status');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_marital_status');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="m-collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="m-collapseThree">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                <?php
                                                $marital_status_arr = $this->common_model->get_list_ddr('marital_status');
                                                if(isset($marital_status_arr) && $marital_status_arr !='' && is_array($marital_status_arr) && count($marital_status_arr) > 0){
                                                    $marital_status_curr = $comm_model->get_data_fromArray($search_filed_data,'looking_for');
                                                    foreach($marital_status_arr as $matr_key=>$mart_val){
                                                        $cheked = "";
                                                        if(isset($marital_status_curr) && $marital_status_curr !='' && count($marital_status_curr) && in_array($matr_key,$marital_status_curr)){
                                                            $cheked = "checked";
                                                        }?>
                                                         <div class="box">
                                                            <p class="checkbox-m">
                                                                <input type="checkbox" id="<?php echo $matr_key.'mob';?>" value="<?php echo $matr_key;?>" name="looking_for[]" <?php echo $cheked;?> onClick="refine_search_mobile()" class="mob_marital_status">
                                                                <label for="<?php echo $matr_key.'mob';?>" class="lbl1"><?php echo $mart_val;?></label>
                                                            </p>
                                                        </div>
                                                    <?php }
                                                }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapserel" aria-expanded="false" aria-controls="collapserel">
                                                    Religion
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_religion');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_religion');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapserel" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapserel">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
                                                    $religion_arr = $this->common_model->dropdown_array_table('religion');
                                                    if(isset($religion_arr) && $religion_arr !='' && is_array($religion_arr) && count($religion_arr) > 0){
                                                        $religion_curr = $comm_model->get_data_fromArray($search_filed_data,'religion');
														$i = 1;
                                                        foreach($religion_arr as $reli_key=>$reli_val){
                                                            $cheked = "";
                                                            if(isset($religion_curr) && $religion_curr !='' && is_array($religion_curr) && count($religion_curr) && in_array($reli_key,$religion_curr)){
                                                                $cheked = "checked";
                                                            }
															$style = 'none';
															if($i<=5){
																$style = 'block';
															}?>
															<div class="box" style="display:<?php echo $style;?>;">
                                                                <p class="checkbox-m">
                                                                    <input type="checkbox" <?php echo $cheked;?> id="rel_<?php echo $reli_key.'mob';?>" value="<?php echo $reli_key;?>" name="religion[]" onClick="getlist_onchange('religion','caste')" class="mob_religion">
                                                                    <label for="rel_<?php echo $reli_key.'mob';?>" class="lbl1 lbl-break"><?php echo $reli_val;?></label>
                                                                </p>
                                                            </div>
														<?php 
														$i++;
													}
													
													if(isset($religion_arr) && $religion_arr !='' && is_array($religion_arr) && count($religion_arr) > 5){?>
                                                        <div class="box">
                                                            <a data-toggle="modal" href="#more-religion">
                                                                <span class="checkbox-m more OpenSans-Bold">
                                                                    + <?php echo count($religion_arr);?> more
                                                                </span>
                                                            </a>
                                                        </div>
                                                    <?php }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecastemobile" aria-expanded="false" aria-controls="collapsecastemobile">
                                                    Caste
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('caste');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('caste');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsecastemobile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsecastemobile">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content" id="list_disp_caste">
                                                    <?php
                                                    if(isset($religion_curr) && $religion_curr !='' && is_array($religion_curr) && count($religion_curr)){
                                                        $cast_curr = $comm_model->get_data_fromArray($search_filed_data,'caste');
                                                        echo $this->search_model->get_list('religion','caste',$religion_curr,$cast_curr,$app_csrf=0);
                                                    }else{?>
                                                        <div class="box">
                                                            <p class="checkbox-m">
                                                                First Select Religion
                                                            </p>
                                                        </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecountry" aria-expanded="false" aria-controls="collapsecountry">
                                                    Country
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_country');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_country');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsecountry" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsecountry">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content country_list">
                                                    <?php
                                                    $country_arr = $this->common_model->dropdown_array_table('country_master');
                                                    if(isset($country_arr) && $country_arr !='' && is_array($country_arr) && count($country_arr) > 0){
                                                        $country_curr = $comm_model->get_data_fromArray($search_filed_data,'country');
                                                        foreach($country_arr as $country_key=>$country_val){
                                                            $cheked = "";
                                                            if(isset($country_curr) && $country_curr !='' && is_array($country_curr) && count($country_curr) && in_array($country_key,$country_curr)){
                                                                $cheked = "checked";
                                                            }?>
                                                            <div class="box">
                                                                <p class="checkbox-m">
                                                                    <input type="checkbox" id="country_mob" value="<?php echo $country_key;?>" onClick="getlist_onchange('country','state')" name="country[]" <?php echo $cheked;?> class="mob_country">
                                                                    <label for="country_mob" class="lbl1 lbl-break"><?php echo $country_val; ?></label>
                                                                </p>
                                                            </div>
                                                        <?php }
                                                        if(isset($country_arr) && $country_arr !='' && is_array($country_arr) && count($country_arr) > 10){?>
                                                            <div class="box">
                                                                <a data-toggle="modal" href="#">
                                                                    <span class="checkbox-m more OpenSans-Bold" id="addmore">
                                                                        + 10 more
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsestate" aria-expanded="false" aria-controls="collapsestate">
                                                    State
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('state');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('state');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsestate" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsestate">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content" id="list_disp_state">
                                                <?php
                                                if(isset($country_curr) && $country_curr !='' && is_array($country_curr) && count($country_curr) ){
                                                    $state_curr = $comm_model->get_data_fromArray($search_filed_data,'state');
                                                    echo $this->search_model->get_list('country','state',$country_curr,$state_curr,$app_csrf=0);
                                                }else{?>
                                                    <div class="box">
                                                        <p class="checkbox-m">
                                                            First Select Country
                                                        </p>
                                                    </div>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist"> 
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecity" aria-expanded="false" aria-controls="collapsecity">
                                                    City
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('city');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('city');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsecity" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsecity">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content" id="list_disp_city">
                                                <?php
                                                if(isset($state_curr) && $state_curr !='' && is_array($state_curr) && count($state_curr))
                                                {
                                                    $city_curr = $comm_model->get_data_fromArray($search_filed_data,'city');
                                                    echo $this->search_model->get_list('state','city',$state_curr,$city_curr,$app_csrf=0);
                                                }else{?>
                                                    <div class="box">
                                                        <p class="checkbox-m">
                                                            First Select State
                                                        </p>
                                                    </div>
                                                    <?php
                                                }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemt" aria-expanded="false" aria-controls="collapsemt">
                                                    Mother Tongue
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_mothertongue');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_mothertongue');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsemt" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsemt">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
													$mothertoung_arr = $this->common_model->dropdown_array_table('mothertongue');
													if(isset($mothertoung_arr) && $mothertoung_arr !='' && is_array($mothertoung_arr) && count($mothertoung_arr) > 0){
														$mothertongue_curr = $comm_model->get_data_fromArray($search_filed_data,'mothertongue');
														$i=1;
														foreach($mothertoung_arr as $mtou_key=>$mtou_val){
															$cheked = "";
															if(isset($mothertongue_curr) && $mothertongue_curr !='' && is_array($mothertongue_curr) &&  count($mothertongue_curr) && in_array($mtou_key,$mothertongue_curr)){
																$cheked = "checked";
															}
															if($i<=5){
																$style = 'style="display:block;"';
															}else{
																$style = 'style="display:none;"';
															}?>
															<div class="box" <?php echo $style;?>>
																<p class="checkbox-m">
																	<input <?php echo $cheked;?> type="checkbox" id="mob_mothertongue_id_<?php echo $mtou_key; ?>" value="<?php echo $mtou_key; ?>" name="mothertongue[]" onClick="refine_search()" class="mob_mothertongue">
																	<label for="mob_mothertongue_id_<?php echo $mtou_key; ?>" class="lbl1 lbl-break"><?php echo $mtou_val; ?></label>
																</p>
															</div>
															<?php 
															$i++;
															}
															if(isset($mothertoung_arr) && $mothertoung_arr !='' && is_array($mothertoung_arr) && count($mothertoung_arr) > 5){?>
															<div class="box">
																<a data-toggle="modal" href="#more-mothertongue">
																	<span class="checkbox-m more OpenSans-Bold">
																		+ <?php echo count($mothertoung_arr);?> more
																	</span>
																</a>
															</div>
														<?php }
													}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseedu" aria-expanded="false" aria-controls="collapseedu">
                                                    Education
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_education');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_education');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseedu" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseedu">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
													$education_arr = $this->common_model->dropdown_array_table('education_detail');
													if(isset($education_arr) && $education_arr !='' && is_array($education_arr) && count($education_arr) > 0){
														$education_curr = $comm_model->get_data_fromArray($search_filed_data,'education');
														$i=1;
														foreach($education_arr as $educ_key=>$educ_val){
															$cheked = "";
															if(isset($education_curr) && $education_curr !='' && is_array($education_curr) && count($education_curr) && in_array($educ_key,$education_curr)){
																$cheked = "checked";
															}
															$style = 'none';
															if($i<=5){
																$style = 'block';
															}
															?>
															<div class="box" style="display:<?php echo $style;?>;">
																<p class="checkbox-m">
																	<input <?php echo $cheked;?> id="mob_education_id_<?php echo $educ_key; ?>" type="checkbox" value="<?php echo $educ_key; ?>" name="education[]" onClick="refine_search()" class="mob_education">
																<label for="mob_education_id_<?php echo $educ_key; ?>" class="lbl1 lbl-break"><?php echo $educ_val; ?></label>
																</p>
															</div>
														<?php 
														$i++;
														}
														if(isset($education_arr) && $education_arr !='' && is_array($education_arr) && count($education_arr) > 5){?>
															<div class="box">
																<a data-toggle="modal" href="#more-education">
																	<span class="checkbox-m more OpenSans-Bold">
																		+ <?php echo count($education_arr);?> more
																	</span>
																</a>
															</div>
														<?php }
													}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseoccu" aria-expanded="false" aria-controls="collapseoccu">
                                                    Occupation
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_occupation');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_occupation');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseoccu" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseoccu">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
													$occupation_arr = $this->common_model->dropdown_array_table('occupation');
													if(isset($occupation_arr) && $occupation_arr !='' && is_array($occupation_arr) && count($occupation_arr) > 0){
														$i=1;
														$occupation_curr = $comm_model->get_data_fromArray($search_filed_data,'occupation');
														foreach($occupation_arr as $ocup_key=>$ocup_val){
															$cheked = "";
															if(isset($occupation_curr) && $occupation_curr !='' && is_array($occupation_curr) && count($occupation_curr) && in_array($ocup_key,$occupation_curr)){
																$cheked = "checked";
															}
															$style = 'none';
															if($i<=5){
																$style = 'block';
															}?>
															<div class="box" style="display:<?php echo $style;?>;">
																<p class="checkbox-m">
																	<input <?php echo $cheked;?> id="mob_occupation_id_<?php echo $ocup_key; ?>" type="checkbox" value="<?php echo $ocup_key;?>" name="occupation[]" onClick="refine_search()" class="mob_occupation">
																<label for="mob_occupation_id_<?php echo $ocup_key; ?>" class="lbl1 lbl-break"><?php echo $ocup_val;?></label>
																</p>
															</div>
														<?php 
														$i++;
														}
														if(isset($occupation_arr) && $occupation_arr !='' && is_array($occupation_arr) && count($occupation_arr) > 5){?>
															<div class="box">
																<a data-toggle="modal" href="#more-occupation">
																	<span class="checkbox-m more OpenSans-Bold">
																		+ <?php echo count($occupation_arr);?> more
																	</span>
																</a>
															</div>
														<?php }
													}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseinc" aria-expanded="false" aria-controls="collapseinc">
                                                    Annual Income
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_income');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_income');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseinc" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseinc">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
													$income_arr = $this->common_model->get_list_ddr('income');
													if(isset($income_arr) && $income_arr !='' && is_array($income_arr) && count($income_arr) > 0){
														$income_curr = $comm_model->get_data_fromArray($search_filed_data,'income');
														$i=0;
														foreach($income_arr as $income_key=>$income_val){
															$cheked = "";
															if(isset($income_curr) && $income_curr !='' && is_array($income_curr) && count($income_curr) && in_array($income_key,$income_curr)){
																$cheked = "checked";
															}
															$style = 'none';
															if($i<=5){
																$style = 'block';
															}?>
															<div class="box" style="display:<?php echo $style;?>;">
																<p class="checkbox-m">
																	<input <?php echo $cheked;?> id="mob_income_id_<?php echo str_ireplace(" ","-",$income_key); ?>" type="checkbox" value="<?php echo $income_key; ?>" name="income[]" onClick="refine_search()" class="mob_income">
																<label for="mob_income_id_<?php echo str_ireplace(" ","-",$income_key); ?>" class="lbl1 lbl-break"><?php echo $income_val; ?></label>
																</p>
															</div>
															<?php 
															$i++;
															}
															if(isset($income_arr) && $income_arr !='' && is_array($income_arr) && count($income_arr) > 5){?>
																<div class="box">
																	<a data-toggle="modal" href="#more-income">
																		<span class="checkbox-m more OpenSans-Bold">
																			+ <?php echo count($income_arr);?> more
																		</span>
																	</a>
																</div>
															<?php }
														}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" >
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseemp" aria-expanded="false" aria-controls="collapseemp">
                                                    Employee In
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_employee_in');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_employee_in');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseemp" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseemp">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
													$employee_in_arr = $this->common_model->get_list_ddr('employee_in');
													if(isset($employee_in_arr) && $employee_in_arr !='' && is_array($employee_in_arr) && count($employee_in_arr) > 0){
														$employee_in_curr = $comm_model->get_data_fromArray($search_filed_data,'employee_in');
														$j=0;
														foreach($employee_in_arr as $emp_key=>$emp_val){
															$cheked = "";
															if(isset($employee_in_curr) && $employee_in_curr !='' && is_array($employee_in_curr) &&  count($employee_in_curr) && in_array($emp_key,$employee_in_curr)){
																$cheked = "checked";
															}?>
															<div class="box">
																<p class="checkbox-m">
                                                                    <input <?php echo $cheked;?> id="mob_employee_in_id_<?php echo str_ireplace(" ","-",$emp_key); ?>" type="checkbox" value="<?php echo $emp_key; ?>" name="employee_in[]" onClick="refine_search()" class="mob_employee_in">
																	<label for="mob_employee_in_id_<?php echo str_ireplace(" ","-",$emp_key); ?>" class="lbl1 lbl-break"><?php echo $emp_val; ?></label>
																</p>
															</div>
														<?php $j++;
														}
														if(isset($employee_in_arr) && $employee_in_arr !='' && is_array($employee_in_arr) && count($employee_in_arr) > 5){?>
															<div class="box">
																<a data-toggle="modal" href="#more-employee_in">
																	<span class="checkbox-m more OpenSans-Bold">
																		+ <?php echo count($employee_in_arr);?> more
																	</span>
																</a>
															</div>
														<?php }
													}?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new no-margin-bottom">
                                        <div class="panel-heading panel-cstm" role="tablist" id="headingtwelve-e">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsesmok" aria-expanded="false" aria-controls="collapsesmok">
                                                    Smoking Habits
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_smoking');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_smoking');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsesmok" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsesmok">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
                                                    $smoke_arr = $this->common_model->get_list_ddr('smoke');
                                                    if(isset($smoke_arr) && $smoke_arr !='' && is_array($smoke_arr) && count($smoke_arr) > 0){
                                                        $smoke_curr = $comm_model->get_data_fromArray($search_filed_data,'smoking');
                                                        foreach($smoke_arr as $smoke_key=>$smoke_val){
                                                            $cheked = "";
                                                            if(isset($smoke_curr) && $smoke_curr !='' && is_array($smoke_curr) && count($smoke_curr) && in_array($smoke_key,$smoke_curr)){
                                                                $cheked = "checked";
                                                            }?>
                                                    <div class="box">
                                                        <p class="checkbox-m">
                                                            <input <?php echo $cheked;?> id="smoke_mob" type="checkbox" value="<?php echo $smoke_key; ?>" name="smoking[]" onClick="refine_search_mobile()" class="mob_smoking">
                                                            <label for="smoke_mob" class="lbl1 lbl-break"><?php echo $smoke_val; ?></label>
                                                        </p>
                                                    </div>
                                                    <?php }
                                                }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new no-margin-bottom">
                                        <div class="panel-heading panel-cstm" role="tablist" id="headdrinking">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsemobdrinking" aria-expanded="false" aria-controls="collapsemobdrinking">
                                                    Drinking Habits
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('drink');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('drink');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsemobdrinking" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsemobdrinking">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php $drink_arr = $this->common_model->get_list_ddr('drink');
                                                    if(isset($drink_arr) && $drink_arr !='' && is_array($drink_arr) && count($drink_arr) > 0){
                                                        $drink_curr = $comm_model->get_data_fromArray($search_filed_data,'drink');
                                                        foreach($drink_arr as $drink_key=>$drink_val){
                                                            $cheked = "";
                                                            if(isset($drink_curr) && $drink_curr !='' && is_array($drink_curr) && count($drink_curr) && in_array($drink_key,$drink_curr)){
                                                                $cheked = "checked";
                                                            }?>
                                                            <div class="box">
                                                                <p class="checkbox-m">
                                                                    <input <?php echo $cheked;?> id="drink_mob" type="checkbox" value="<?php echo $drink_key; ?>" name="drink[]" onClick="refine_search_mobile()" class="drink">
                                                                    <label for="drink_mob" class="lbl1 lbl-break"><?php echo $drink_val; ?></label>
                                                                </p>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" id="headingtwelve-d">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseeat" aria-expanded="false" aria-controls="collapseeat">
                                                    Eating Habits
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_diet');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_diet');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseeat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseeat">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
                                                    $diet_arr = $this->common_model->get_list_ddr('diet');
                                                    if(isset($diet_arr) && $diet_arr !='' && is_array($diet_arr) && count($diet_arr) > 0){
                                                        $diet_curr = $comm_model->get_data_fromArray($search_filed_data,'diet');
                                                        $d=0;
                                                        foreach($diet_arr as $diet_key=>$diet_val){
                                                            $cheked = "";
                                                            if(isset($diet_curr) && $diet_curr !='' && is_array($diet_curr) && count($diet_curr) && in_array($diet_key,$diet_curr)){
                                                                $cheked = "checked";
                                                            }?>
                                                            <div class="box">
                                                                <p class="checkbox-m">
                                                                    <input <?php echo $cheked;?> id="diet_mob" type="checkbox" value="<?php echo $diet_key; ?>" name="diet[]" onClick="refine_search_mobile()" class="mob_diet">
                                                                    <label for="diet_mob" class="lbl1 lbl-break"><?php echo $diet_val; ?></label>
                                                                </p>
                                                            </div>
                                                        <?php $d++;}
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" id="headprofile">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseprofile" aria-expanded="false" aria-controls="collapseprofile">
                                                    Profile Picture
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_profile_picture');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_profile_picture');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapseprofile" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headprofile">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php 
                                                    $photo_search = $comm_model->get_data_fromArray($search_filed_data,'photo_search');
                                                    $photo_search_checked = '';
                                                    if(isset($photo_search) && $photo_search !='' && $photo_search =='photo_search'){
                                                        $photo_search_checked = 'checked';
                                                    }?>
                                                    <div class="box">
                                                        <p class="checkbox-m">
                                                            <input <?php echo $photo_search_checked; ?> id="mob_photo_search" type="checkbox" value="photo_search" name="photo_search" onClick="refine_search_mobile();" class="mob_profile_picture">
                                                            <label for="mob_photo_search" class="lbl1 lbl-break">With Picture</label>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetcom" aria-expanded="false" aria-controls="collapsetcom">
                                                    Complexion
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_omplexion');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_omplexion');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsetcom" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsetcom">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
                                                    $complexion_arr = $this->common_model->get_list_ddr('complexion');
                                                    if(isset($complexion_arr) && $complexion_arr !='' && is_array($complexion_arr) && count($complexion_arr) > 0){
                                                        $complexion_curr = $comm_model->get_data_fromArray($search_filed_data,'complexion');
                                                        $c=0;
                                                        foreach($complexion_arr as $complexion_key=>$complexion_val){
                                                            $cheked = "";
                                                            if(isset($complexion_curr) && $complexion_curr !='' && is_array($complexion_curr) && count($complexion_curr) && in_array($complexion_key,$complexion_curr)){
                                                                $cheked = "checked";
                                                            }?>
                                                            <div class="box">
                                                                <p class="checkbox-m">
                                                                    <input <?php echo $cheked; ?> id="complexion_mob" type="checkbox" value="<?php echo $complexion_key; ?>" name="complexion[]" onClick="refine_search_mobile()" class="mob_omplexion">
                                                                    <label for="complexion_mob" class="lbl1 lbl-break"><?php echo $complexion_val;?></label>
                                                                </p>
                                                            </div>
                                                        <?php $c++;
                                                        }
                                                        if(isset($complexion_arr) && $complexion_arr !='' && is_array($complexion_arr) && count($complexion_arr) > 10){?>
                                                            <div class="box">
                                                                <a data-toggle="modal" href="#">
                                                                    <span class="checkbox-m more OpenSans-Bold">
                                                                        + 10 more
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row margin-top-minus">
                                    <div class="panel panel-default panel1-cstm pannel-new">
                                        <div class="panel-heading panel-cstm" role="tablist" id="headbody">
                                            <h4 class="panel-title">
                                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsebody" aria-expanded="false" aria-controls="collapsebody">
                                                    Body Type
                                                </a>
                                            </h4>
                                        </div>
                                        <a href="javascript:void(0)" onClick="mob_select_all_checkbox('mob_bodytype');">
                                            <span class="s-all pull-right">
                                                Select All | 
                                            </span>
                                        </a>
                                        <a href="javascript:void(0)" onClick="clear_refine('mob_bodytype');">
                                            <span class="clear-all pull-right">
                                                Clear All
                                            </span>
                                        </a>
                                        <div id="collapsebody" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headbody">
                                            <div class="panel-body no-padding bg-color">
                                                <div class="content">
                                                    <?php
                                                    $bodytype_arr = $this->common_model->get_list_ddr('bodytype');
                                                    if(isset($bodytype_arr) && $bodytype_arr !='' && is_array($bodytype_arr) && count($bodytype_arr) > 0){
                                                        $bodytype_curr = $comm_model->get_data_fromArray($search_filed_data,'bodytype');
                                                        foreach($bodytype_arr as $bodytype_key=>$bodytype_val)
                                                        {
                                                            $cheked = "";
                                                            if(isset($bodytype_curr) && $bodytype_curr !='' && is_array($bodytype_curr) && count($bodytype_curr) && in_array($bodytype_key,$bodytype_curr))
                                                            {
                                                                $cheked = "checked";
                                                            }?>
                                                            <div class="box">
                                                                <p class="checkbox-m">
                                                                    <input <?php echo $cheked; ?> id="bodytype_mob" type="checkbox" value="<?php echo $bodytype_key; ?>" name="bodytype[]" onClick="refine_search_mobile()" class="mob_bodytype">
                                                                    <label for="bodytype_mob" class="lbl1 lbl-break"><?php echo $bodytype_val; ?></label>
                                                                </p>
                                                            </div>
                                                        <?php }
                                                        if(isset($bodytype_arr) && $bodytype_arr !='' && is_array($bodytype_arr) && count($bodytype_arr) > 10){?>
                                                            <div class="box">
                                                                <a data-toggle="modal" href="#">
                                                                    <span class="checkbox-m more OpenSans-Bold">
                                                                        + 10 more
                                                                    </span>
                                                                </a>
                                                            </div>
                                                        <?php }
                                                    }?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>