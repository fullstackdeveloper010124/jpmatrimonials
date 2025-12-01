<style>
    .pannel-new .panel-title>a, .panel-title>a:active{
        font-size: 14px;
    }
    .lbl1{
        font-size: 13px;
    }
    .refine-search-main-box h1{
        font-family: 'SF-Pro-Display-Semibold';
    }
    .fr-main{
        padding: 0px 16px;
    }
    input[type="checkbox"]+label:before{
        height: 13px;
        width: 13px;
    }
    .fr-height{
        font-size: 15px;
    }
    .h1-h{
        font-size: 14px;
    }
    .h2-h{
        font-size: 14px;
    }
    .irs-from, .irs-to, .irs-single{
        font-size: 14px;
        padding: 3px 0px;
    }
    .more{
        font-size: 14px;
    }
</style>


<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="fr-main">
            <form name="frm_filter" id="frm_filter" method="post">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
                <?php
				$curre_gender = $this->common_front_model->get_session_data('gender');
                if($curre_gender ==''){
					$gender = $comm_model->get_data_fromArray($search_filed_data,'gender')?>
                <div class="row">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="fr-height OpenSans-Bold">Gender</p>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="radio-custm">
                            <input type="radio" id="w-male" onClick="refine_search()" value="Male" name="gender" <?php if(isset($gender) && $gender !='' && $gender == 'Male'){ echo 'checked';} ?>>
                            <label for="w-male" class="lbl1">Male</label>
                        </p>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <p class="radio-custm">
                            <input type="radio" id="w-fmale" onClick="refine_search()" value="Female" name="gender" <?php if(isset($gender) && $gender !='' && $gender =='Female'){ echo 'checked';} ?>>
                            <label for="w-fmale" class="lbl1">Female</label>
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
                    <?php $from_height = $comm_model->get_data_fromArray($search_filed_data,'from_height');
					$to_height = $comm_model->get_data_fromArray($search_filed_data,'to_height');
                    ?>
                    <div class="t-h">
                        <span class="h1-h">
                            4 ft
                            <input type="hidden" name="from_height" id="from_height" value="<?php if(isset($from_height) && $from_height!=''){echo $from_height;}else{ echo '48';}?>">
                        </span>
                        <span class="h2-h pull-right">
                            7 Above ft
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
                <div class="row">
                    <div class="range-slider">
                        <input type="text" class="js-range-slider-2" value="" />
                    </div>
                    <?php $from_age = $comm_model->get_data_fromArray($search_filed_data,'from_age');
					$to_age = $comm_model->get_data_fromArray($search_filed_data,'to_age');?>
                    <div class="t-h">
                        <span class="h1-h">
                            18 Year
                            <input type="hidden" name="from_age" id="from_age" value="<?php if(isset($from_age) && $from_age!=''){echo $from_age;}else{ echo '18';}?>">
                        </span>
                        <span class="h2-h pull-right">
                            65 Year
                            <input type="hidden" name="to_age" id="to_age" value="<?php if(isset($to_age) && $to_age!=''){echo $to_age;}else{ echo '65';}?>">
                        </span>
                    </div>
                </div>
                <!--end range age slider-->
                
                <div class="row margin-top-20">
                    <div class="panel panel-default panel1-cstm pannel-new">
                        <div class="panel-heading panel-cstm" role="tablist" >
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Maritial Status
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('marital_status');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('marital_status');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseThree">
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
                                                    <input type="checkbox" id="<?php echo $matr_key.'web';?>" value="<?php echo $matr_key;?>" name="looking_for[]" <?php echo $cheked;?> onClick="refine_search()" class="marital_status">
                                                    <label for="<?php echo $matr_key.'web';?>" class="lbl1"><?php echo $mart_val;?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                                    Religion
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('religion');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('religion');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsefour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsefour">
                            <div class="panel-body no-padding bg-color">
                                <div class="content">
                                    <?php
                                    $religion_arr = $this->common_model->dropdown_array_table('religion');
                                    if(isset($religion_arr) && $religion_arr !='' && is_array($religion_arr) && count($religion_arr) > 0){
										$i=1;
                                        $religion_curr = $comm_model->get_data_fromArray($search_filed_data,'religion');
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
													<input type="checkbox" <?php echo $cheked;?> id="religion_id_<?php echo preg_replace('/[ ,]+/', '',$reli_key);?>" value="<?php echo $reli_key;?>" name="religion[]" onClick="getlist_onchange('religion','caste')" class="religion">
													<label for="religion_id_<?php echo preg_replace('/[ ,]+/', '',$reli_key);?>" class="lbl1 lbl-break"><?php echo $reli_val;?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsecaste" aria-expanded="false" aria-controls="collapsecaste">
                                    Caste
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('caste');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('caste');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsecaste" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsecaste">
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
                                    Country
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('country');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('country');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseseven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseseven">
                            <div class="panel-body no-padding bg-color">
                                <div class="content country_list">
                                    <?php
                                    $country_arr = $this->common_model->dropdown_array_table('country_master');
                                    if(isset($country_arr) && $country_arr !='' && is_array($country_arr) && count($country_arr) > 0){
										$i=1;
                                        $country_curr = $comm_model->get_data_fromArray($search_filed_data,'country');
                                        foreach($country_arr as $country_key=>$country_val){
                                            $cheked = "";
                                            if(isset($country_curr) && $country_curr !='' && is_array($country_curr) && count($country_curr) && in_array($country_key,$country_curr)){
                                                $cheked = "checked";
                                            }
											$style = 'none';
											if($i<=5){
												$style = 'block';
											}?>
                                            <div class="box" style="display:<?php echo $style;?>;">
                                                <p class="checkbox-m">
                                                    <input type="checkbox" id="country_id_<?php echo preg_replace('/[ ,]+/', '',$country_key);?>" value="<?php echo $country_key;?>" onClick="getlist_onchange('country','state')" name="country[]" <?php echo $cheked;?> class="country">
                                                    <label for="country_id_<?php echo preg_replace('/[ ,]+/', '',$country_key);?>" class="lbl1 lbl-break"><?php echo $country_val; ?></label>
                                                </p>
                                            </div>
                                        	<?php 
											$i++;
										}
                                        if(isset($country_arr) && $country_arr !='' && is_array($country_arr) && count($country_arr) > 5){?>
                                            <div class="box">
                                                <a data-toggle="modal" href="#more-country">
                                                    <span class="checkbox-m more OpenSans-Bold">
                                                        + <?php echo count($country_arr);?> more
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseeight" aria-expanded="false" aria-controls="collapseeight">
                                    State
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('state');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('state');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseeight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseeight">
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsenine" aria-expanded="false" aria-controls="collapsenine">
                                    City
                                </a>
                            </h4>
                        </div>
                        <a href="javascript:void(0)" onClick="select_all_checkbox('city');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('city');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a>
                        <div id="collapsenine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsenine">
                            <div class="panel-body no-padding bg-color">
                                <div class="content" id="list_disp_city">
                                <?php
                                /*if(isset($state_curr) && $state_curr !='' && is_array($state_curr) && count($state_curr))
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
                                }*/?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                <div class="row margin-top-minus">
                    <div class="panel panel-default panel1-cstm pannel-new">
                        <div class="panel-heading panel-cstm" role="tablist" >
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
                                    Mother Tongue
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('mothertongue');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('mothertongue');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsefive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsefive">
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
                                                    <input <?php echo $cheked;?> type="checkbox" id="mothertongue_id_<?php echo $mtou_key; ?>" value="<?php echo $mtou_key; ?>" name="mothertongue[]" onClick="refine_search()" class="mothertongue">
                                                    <label for="mothertongue_id_<?php echo preg_replace('/[ ,]+/', '',$mtou_key);?>" class="lbl1 lbl-break"><?php echo $mtou_val; ?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseeleven" aria-expanded="false" aria-controls="collapseeleven">
                                    Education
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('education');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('education');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseeleven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseeleven">
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
                                                    <input <?php echo $cheked;?> id="education_id_<?php echo preg_replace('/[ ,]+/', '',$educ_key);?>" type="checkbox" value="<?php echo $educ_key; ?>" name="education[]" onClick="refine_search()" class="education">
                                                <label for="education_id_<?php echo preg_replace('/[ ,]+/', '',$educ_key);?>" class="lbl1 lbl-break"><?php echo $educ_val; ?></label>
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
                <?php /*
                <div class="row margin-top-minus">
                    <div class="panel panel-default panel1-cstm pannel-new">
                        <div class="panel-heading panel-cstm" role="tablist" >
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseten" aria-expanded="false" aria-controls="collapseten">
                                    Occupation
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('occupation');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('occupation');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseten" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseten">
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
                                                    <input <?php echo $cheked;?> id="occupation_id_<?php echo preg_replace('/[ ,]+/', '', $ocup_key);?>" type="checkbox" value="<?php echo $ocup_key;?>" name="occupation[]" onClick="refine_search()" class="occupation">
                                                <label for="occupation_id_<?php echo preg_replace('/[ ,]+/', '', $ocup_key);?>" class="lbl1 lbl-break"><?php echo $ocup_val;?></label>
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
                */ ?>
                <div class="row margin-top-minus">
                    <div class="panel panel-default panel1-cstm pannel-new">
                        <div class="panel-heading panel-cstm" role="tablist" >
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve" aria-expanded="false" aria-controls="collapsetwelve">
                                    Annual Income
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('income');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('income');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsetwelve">
                            <div class="panel-body no-padding bg-color">
                                <div class="content">
                                <?php
                                $income_arr = $this->common_model->dropdown_array_table('annual_income');
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
                                                <input <?php echo $cheked;?> id="income_id_<?php echo preg_replace('/[ ,]+/', '', $income_key); ?>" type="checkbox" value="<?php echo $income_key; ?>" name="income[]" onClick="refine_search()" class="income">
                                            <label for="income_id_<?php echo preg_replace('/[ ,]+/', '', $income_key); ?>" class="lbl1 lbl-break"><?php echo $income_val; ?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve-a" aria-expanded="false" aria-controls="collapsetwelve-a">
                                    Working With
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('employee_in');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('employee_in');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve-a" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsetwelve-a">
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
                                                    <input <?php echo $cheked;?> id="employee_in_id_<?php echo preg_replace('/[ ,]+/', '', $emp_key); ?>" type="checkbox" value="<?php echo $emp_key; ?>" name="employee_in[]" onClick="refine_search()" class="employee_in">
                                                <label for="employee_in_id_<?php echo preg_replace('/[ ,]+/', '', $emp_key); ?>" class="lbl1 lbl-break"><?php echo $emp_val; ?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve-e" aria-expanded="false" aria-controls="collapsetwelve-e">
                                    Smoking Habits
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('smoking');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('smoking');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve-e" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwelve-e">
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
                                            <input <?php echo $cheked;?> id="smoke_<?php echo $smoke_key; ?>" type="checkbox" value="<?php echo $smoke_key; ?>" name="smoking[]" onClick="refine_search()" class="smoking">
                                            <label for="smoke_<?php echo $smoke_key; ?>" class="lbl1 lbl-break"><?php echo $smoke_val; ?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsedrinking" aria-expanded="false" aria-controls="collapsedrinking">
                                    Drinking Habits
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('drink');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('drink');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsedrinking" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headdrinking">
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
                                                    <input <?php echo $cheked;?> id="drink_<?php echo $drink_key; ?>" type="checkbox" value="<?php echo $drink_key; ?>" name="drink[]" onClick="refine_search()" class="drink">
                                                    <label for="drink_<?php echo $drink_key; ?>" class="lbl1 lbl-break"><?php echo $drink_val; ?></label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve-d" aria-expanded="false" aria-controls="collapsetwelve-d">
                                    Diet
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('diet');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('diet');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve-d" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwelve-d">
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
                                                    <input <?php echo $cheked;?> id="diet_<?php echo $d; ?>" type="checkbox" value="<?php echo $diet_key; ?>" name="diet[]" onClick="refine_search()" class="diet">
                                                    <label for="diet_<?php echo $d;?>" class="lbl1 lbl-break"><?php echo $diet_val; ?></label>
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
                        <div class="panel-heading panel-cstm" role="tablist" id="headingprof">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseprof" aria-expanded="false" aria-controls="collapseprof">
                                    Profile Picture
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('profile_picture');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('profile_picture');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapseprof" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingprof">
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
                                            <input <?php echo $photo_search_checked; ?> id="photo_search" type="checkbox" value="photo_search" name="photo_search" onClick="refine_search();" class="profile_picture">
                                            <label for="photo_search" class="lbl1 lbl-break">With Picture</label>
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
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve-b" aria-expanded="false" aria-controls="collapsetwelve-b">
                                    Complexion
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('complexion');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('complexion');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve-b" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapsetwelve-b">
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
                                                    <input <?php echo $cheked; ?> id="complexion_<?php echo $c; ?>" type="checkbox" value="<?php echo $complexion_key; ?>" name="complexion[]" onClick="refine_search()" class="complexion">
                                                    <label for="complexion_<?php echo $c;?>" class="lbl1 lbl-break"><?php echo $complexion_val;?></label>
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
                        <div class="panel-heading panel-cstm" role="tablist" id="headingtwelve-c">
                            <h4 class="panel-title">
                                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapsetwelve-c" aria-expanded="false" aria-controls="collapsetwelve-c">
                                    Body Type
                                </a>
                            </h4>
                        </div>
                        <!-- <a href="javascript:void(0)" onClick="select_all_checkbox('bodytype');">
                            <span class="s-all pull-right">
                                Select All | 
                            </span>
                        </a>
                        <a href="javascript:void(0)" onClick="clear_refine('bodytype');">
                            <span class="clear-all pull-right">
                                Clear All
                            </span>
                        </a> -->
                        <div id="collapsetwelve-c" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingtwelve-c">
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
                                                    <input <?php echo $cheked; ?> id="bodytype_<?php echo $bodytype_key; ?>" type="checkbox" value="<?php echo $bodytype_key; ?>" name="bodytype[]" onClick="refine_search()" class="bodytype">
                                                    <label for="bodytype_<?php echo $bodytype_key; ?>" class="lbl1 lbl-break"><?php echo $bodytype_val; ?></label>
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


