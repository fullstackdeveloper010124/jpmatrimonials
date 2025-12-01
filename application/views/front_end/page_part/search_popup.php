<?php 
$member_front_search = $this->session->userdata('member_front_search');
$search_filed_data = array();
if(isset($member_front_search['search_filed_data']) && $member_front_search['search_filed_data'] !='')
{
	$search_filed_data = $member_front_search['search_filed_data'];
}
?>
<div id="more-religion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $religion_dt = $this->common_model->dropdown_array_table('religion');
		$religion = $this->common_model->get_data_fromArray($search_filed_data,'religion');
		?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Religion</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="religion_sel_count"><?php
						if(isset($religion) && $religion!='' && is_array($religion) && count($religion)>0){
							echo count($religion);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('religion')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Religion
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('religion')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_religion_dt">
                            <?php
							if(isset($religion) && $religion!='' && is_array($religion) && count($religion)>0){
								if(isset($religion_dt) && $religion_dt!='' && is_array($religion_dt) && count($religion_dt)>0){
									foreach($religion_dt as $key=>$val){
										if(isset($religion) && $religion!=''){
											if(in_array($key,$religion)){?>
												<div class="new-check-box-modal" id="parent_religion_checkbox_<?php echo $key;?>">
                                                	<input type="checkbox" id="new_religion_<?php echo $key;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $key;?>','religion')">
                                                	<label for="new_religion_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 religion at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_religion_dt">
                            <?php
							if(isset($religion_dt) && $religion_dt!='' && is_array($religion_dt) && count($religion_dt)>0){
								foreach($religion_dt as $key=>$val){
									$rel_check = 1;
									if(isset($religion) && $religion!=''){
										if(in_array($key,$religion)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_religion_checkbox_<?php echo $key;?>">
											<input type="checkbox" id="new_religion_<?php echo $key;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $key;?>','religion');" />
											<label for="new_religion_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
								}
								if(isset($religion) && $religion!='' && is_array($religion) && count($religion)==count($religion_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-caste" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <?php $caste_dt = $this->common_model->dropdown_array_table('caste');
				$caste = $comm_model->get_data_fromArray($search_filed_data,'caste');?>
				<div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">caste</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="caste_sel_count_s"><?php
						if(isset($caste) && $caste!='' && is_array($caste) && count($caste)>0){
							echo count($caste);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('caste')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important; color:#fff; position:relative; z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important; color:#fff; position:relative; z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected caste <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('caste')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_caste_dt">
						<?php
						if(isset($caste) && $caste!='' && is_array($caste) && count($caste)>0){
							if(isset($religion) && $religion!=''){
								$religion_str = implode("','",$religion);
								$where_search_c[]= " ( religion_id in ('$religion_str') ) ";
								if(isset($where_search_c) && $where_search_c !='' && count($where_search_c) > 0){
									$where_search_str_c = implode(" and ",$where_search_c);
									$this->db->where($where_search_str_c);
									$caste_dt = $this->common_model->get_count_data_manual("caste","",2,"*","caste_name ASC");
								}
							}
							if(isset($caste_dt) && $caste_dt!='' && is_array($caste_dt) && count($caste_dt)>0){
								foreach($caste_dt as $key=>$val){
									if(isset($caste) && $caste!=''){
										if(in_array($val['id'],$caste)){?>
                                            <div class="new-check-box-modal" id="parent_caste_checkbox_<?php echo $val['id'];?>">
                                                <input type="checkbox" id="new_caste_<?php echo $val['id'];?>" value="<?php echo $val['id'];?>" checked="checked" onclick="list_dselect('<?php echo $val['id'];?>','caste')">
                                                <label for="new_caste_<?php echo $val['id'];?>" class="sprinkles"><?php echo $val['caste_name'];?></label>
                                            </div>
										<?php
										}
									}
								}
							}
						}else{
							echo '<p>Not Available</p>';
						}
						?>
						</div>
					</div>
					<hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 castes at once</span>
                    <hr class="hr-modal-s">
					<div class="row">
                    <div id="no_select_caste_dt">
						<?php
						if(isset($religion) && $religion!='')
						{
							$religion_str = implode("','",$religion);
							$where_search_seac[]= " ( religion_id in ('$religion_str') ) ";
							
							if(isset($where_search_seac) && $where_search_seac !='' && is_array($where_search_seac) && count($where_search_seac) > 0)
							{
								$where_search_str_ser = implode(" and ",$where_search_seac);
								$this->db->where($where_search_str_ser);
								$caste_dt = $this->common_model->get_count_data_manual("caste","",2,"*","caste_name ASC");
							}
						}
						
						if(isset($caste_dt) && $caste_dt!='' && is_array($caste_dt) && count($caste_dt)>0)
						{
							
							foreach($caste_dt as $val)
							{
								$rel_check = 1;
								if(isset($caste) && $caste!='' && is_array($caste) && count($caste) > 0)
								{
									if(in_array($val['id'],$caste))
									{
										$rel_check = 0;
									}
								}
								if($rel_check==1)
								{
									?>
									<div class="new-check-box-modal" id="parent_caste_checkbox_<?php echo $val['id'];?>">
										<input type="checkbox" id="new_caste_<?php echo $val['id'];?>" value="<?php echo $val['id'];?>" onclick="list_select('<?php echo $val['id'];?>','caste');" />
										<label for="new_caste_<?php echo $val['id'];?>" class="sprinkles"><?php echo $val['caste_name'];?></label>
									</div>
									<?php
								}
							}
						}
						else
						{
							echo '<p>Not Available</p>';
						}
						?>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-country" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $country_dt = $this->common_model->dropdown_array_table('country_master');
		$country = $this->common_model->get_data_fromArray($search_filed_data,'country');
		?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Country</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="country_sel_count"><?php
						if(isset($country) && $country!='' && is_array($country) && count($country)>0){
							echo count($country);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('country')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Country
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('country')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_country_dt">
                            <?php
							if(isset($country) && $country!='' && is_array($country) && count($country)>0){
								if(isset($country_dt) && $country_dt!='' && is_array($country_dt) && count($country_dt)>0){
									foreach($country_dt as $key=>$val){
										if(isset($country) && $country!=''){
											if(in_array($key,$country)){?>
												<div class="new-check-box-modal" id="parent_country_checkbox_<?php echo $key;?>">
                                                	<input type="checkbox" id="new_country_<?php echo $key;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $key;?>','country')">
                                                	<label for="new_country_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 countries at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_country_dt">
                            <?php
							if(isset($country_dt) && $country_dt!='' && is_array($country_dt) && count($country_dt)>0){
								foreach($country_dt as $key=>$val){
									$rel_check = 1;
									if(isset($country) && $country!=''){
										if(in_array($key,$country)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_country_checkbox_<?php echo $key;?>">
											<input type="checkbox" id="new_country_<?php echo $key;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $key;?>','country');" />
											<label for="new_country_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
								}
								if(isset($country) && $country!='' && is_array($country) && count($country)==count($country_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-state" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <?php $state_dt = $this->common_model->dropdown_array_table('state_master');
				$state = $comm_model->get_data_fromArray($search_filed_data,'state');?>
				<div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">State</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="state_sel_count_s"><?php
						if(isset($state) && $state!='' && is_array($state) && count($state)>0){
							echo count($state);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('state')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected state <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('state')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_state_dt">
						<?php
						if(isset($state) && $state!='' && is_array($state) && count($state)>0){
							if(isset($country) && $country!=''){
								$country_str = implode("','",$country);
								$where_search_s[]= " ( country_id in ('$country_str') ) ";
								if(isset($where_search_s) && $where_search_s !='' && count($where_search_s) > 0){
									$where_search_str_s = implode(" and ",$where_search_s);
									$this->db->where($where_search_str_s);
									$state_dt = $this->common_model->get_count_data_manual("state_master","",2,"*","state_name ASC");
								}
							}
							if(isset($state_dt) && $state_dt!='' && is_array($state_dt) && count($state_dt)>0){
								foreach($state_dt as $key=>$val){
									if(isset($state) && $state!=''){
										if(in_array($val['id'],$state)){?>
                                            <div class="new-check-box-modal" id="parent_state_checkbox_<?php echo $val['id'];?>">
                                                <input type="checkbox" id="new_state_<?php echo $val['id'];?>" value="<?php echo $val['id'];?>" checked="checked" onclick="list_dselect('<?php echo $val['id'];?>','state')">
                                                <label for="new_state_<?php echo $val['id'];?>" class="sprinkles"><?php echo $val['state_name'];?></label>
                                            </div>
										<?php
										}
									}
								}
							}
						}else{
							echo '<p>Not Available</p>';
						}
						?>
						</div>
					</div>
					<hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 states at once</span>
                    <hr class="hr-modal-s">
					<div class="row">
                    <div id="no_select_state_dt">
						<?php
						if(isset($country) && $country!='')
						{
							$country_str = implode("','",$country);
							$where_search_seacrh[]= " ( country_id in ('$country_str') ) ";
							
							if(isset($where_search_seacrh) && $where_search_seacrh !='' && is_array($where_search_seacrh) && count($where_search_seacrh) > 0)
							{
								$where_search_str_serach = implode(" and ",$where_search_seacrh);
								$this->db->where($where_search_str_serach);
								$state_dt = $this->common_model->get_count_data_manual("state_master","",2,"*","state_name ASC");
							}
						}
						
						if(isset($state_dt) && $state_dt!='' && is_array($state_dt) && count($state_dt)>0)
						{
							
							foreach($state_dt as $val)
							{
								$rel_check = 1;
								if(isset($state) && $state!='' && is_array($state) && count($state) > 0)
								{
									if(in_array($val['id'],$state))
									{
										$rel_check = 0;
									}
								}
								if($rel_check==1)
								{
									?>
									<div class="new-check-box-modal" id="parent_state_checkbox_<?php echo $val['id'];?>">
										<input type="checkbox" id="new_state_<?php echo $val['id'];?>" value="<?php echo $val['id'];?>" onclick="list_select('<?php echo $val['id'];?>','state');" />
										<label for="new_state_<?php echo $val['id'];?>" class="sprinkles"><?php echo $val['state_name'];?></label>
									</div>
									<?php
								}
							}
						}
						else
						{
							echo '<p>Not Available</p>';
						}
						?>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-mothertongue" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $mothertongue_dt = $this->common_model->dropdown_array_table('mothertongue');
		$mothertongue = $comm_model->get_data_fromArray($search_filed_data,'mothertongue');?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Mother Tongue</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="mothertongue_sel_count"><?php
						if(isset($mothertongue) && $mothertongue!='' && is_array($mothertongue) && count($mothertongue)>0){
							echo count($mothertongue);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('mothertongue')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Mother Tongue
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('mothertongue')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_mothertongue_dt">
                            <?php
							if(isset($mothertongue) && $mothertongue!='' && is_array($mothertongue) && count($mothertongue)>0){
								if(isset($mothertongue_dt) && $mothertongue_dt!='' && is_array($mothertongue_dt) && count($mothertongue_dt)>0){
									foreach($mothertongue_dt as $key=>$val){
										if(isset($mothertongue) && $mothertongue!=''){
											if(in_array($key,$mothertongue)){?>
												<div class="new-check-box-modal" id="parent_mothertongue_checkbox_<?php echo $key;?>">
                                                	<input type="checkbox" id="new_mothertongue_<?php echo $key;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $key;?>','mothertongue')">
                                                	<label for="new_mothertongue_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 mother tongues at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_mothertongue_dt">
                            <?php
							if(isset($mothertongue_dt) && $mothertongue_dt!='' && is_array($mothertongue_dt) && count($mothertongue_dt)>0){
								foreach($mothertongue_dt as $key=>$val){
									$rel_check = 1;
									if(isset($mothertongue) && $mothertongue!=''){
										if(in_array($key,$mothertongue)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_mothertongue_checkbox_<?php echo $key;?>">
											<input type="checkbox" id="new_mothertongue_<?php echo $key;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $key;?>','mothertongue');" />
											<label for="new_mothertongue_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
								}
								if(isset($mothertongue) && $mothertongue!='' && is_array($mothertongue) && count($mothertongue)==count($mothertongue_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-education" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $education_dt = $this->common_model->dropdown_array_table('education_detail');
		$education = $comm_model->get_data_fromArray($search_filed_data,'education');?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Education</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="education_sel_count"><?php
						if(isset($education) && $education!='' && is_array($education) && count($education)>0){
							echo count($education);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('education')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Education
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('education')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_education_dt">
                            <?php
							if(isset($education) && $education!='' && is_array($education) && count($education)>0){
								if(isset($education_dt) && $education_dt!='' && is_array($education_dt) && count($education_dt)>0){
									foreach($education_dt as $key=>$val){
										if(isset($education) && $education!=''){
											if(in_array($key,$education)){?>
												<div class="new-check-box-modal" id="parent_education_checkbox_<?php echo $key;?>">
                                                	<input type="checkbox" id="new_education_<?php echo $key;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $key;?>','education')">
                                                	<label for="new_education_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 educations at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_education_dt">
                            <?php
							if(isset($education_dt) && $education_dt!='' && is_array($education_dt) && count($education_dt)>0){
								foreach($education_dt as $key=>$val){
									$rel_check = 1;
									if(isset($education) && $education!=''){
										if(in_array($key,$education)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_education_checkbox_<?php echo $key;?>">
											<input type="checkbox" id="new_education_<?php echo $key;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $key;?>','education');" />
											<label for="new_education_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
								}
								if(isset($education) && $education!='' && is_array($education) && count($education)==count($education_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-occupation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $occupation_dt = $this->common_model->dropdown_array_table('occupation');
		$occupation = $comm_model->get_data_fromArray($search_filed_data,'occupation');?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Occupation</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="occupation_sel_count"><?php
						if(isset($occupation) && $occupation!='' && is_array($occupation) && count($occupation)>0){
							echo count($occupation);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('occupation')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Occupation
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('occupation')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_occupation_dt">
                            <?php
							if(isset($occupation) && $occupation!='' && is_array($occupation) && count($occupation)>0){
								if(isset($occupation_dt) && $occupation_dt!='' && is_array($occupation_dt) && count($occupation_dt)>0){
									foreach($occupation_dt as $key=>$val){
										if(isset($occupation) && $occupation!=''){
											if(in_array($key,$occupation)){?>
												<div class="new-check-box-modal" id="parent_occupation_checkbox_<?php echo $key;?>">
                                                	<input type="checkbox" id="new_occupation_<?php echo $key;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $key;?>','occupation')">
                                                	<label for="new_occupation_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 occupations at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_occupation_dt">
                            <?php
							if(isset($occupation_dt) && $occupation_dt!='' && is_array($occupation_dt) && count($occupation_dt)>0){
								foreach($occupation_dt as $key=>$val){
									$rel_check = 1;
									if(isset($occupation) && $occupation!=''){
										if(in_array($key,$occupation)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_occupation_checkbox_<?php echo $key;?>">
											<input type="checkbox" id="new_occupation_<?php echo $key;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $key;?>','occupation');" />
											<label for="new_occupation_<?php echo $key;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
								}
								if(isset($occupation) && $occupation!='' && is_array($occupation) && count($occupation)==count($occupation_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="more-income" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $income_dt = $this->common_model->get_list_ddr('income');
		$income = $comm_model->get_data_fromArray($search_filed_data,'income');?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">income</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="income_sel_count"><?php
						if(isset($income) && $income!='' && is_array($income) && count($income)>0){
							echo count($income);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('income')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected income
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('income')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_income_dt">
                            <?php
							if(isset($income) && $income!='' && is_array($income) && count($income)>0){
								if(isset($income_dt) && $income_dt!='' && is_array($income_dt) && count($income_dt)>0){
									$i=1;
									foreach($income_dt as $key=>$val){
										if(isset($income) && $income!=''){
											if(in_array($key,$income)){?>
												<div class="new-check-box-modal" id="parent_income_checkbox_<?php echo $i;?>">
                                                	<input type="checkbox" id="new_income_<?php echo $i;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $i;?>','income')">
                                                	<label for="new_income_<?php echo $i;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									$i++;
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 incomes at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_income_dt">
                            <?php
							if(isset($income_dt) && $income_dt!='' && is_array($income_dt) && count($income_dt)>0){
								$i=1;
								foreach($income_dt as $key=>$val){
									$rel_check = 1;
									if(isset($income) && $income!=''){
										if(in_array($key,$income)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_income_checkbox_<?php echo $i;?>">
											<input type="checkbox" id="new_income_<?php echo $i;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $i;?>','income');" />
											<label for="new_income_<?php echo $i;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
									$i++;
								}
								if(isset($income) && $income!='' && is_array($income) && count($income)==count($income_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="more-employee_in" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
        <?php $employee_in_dt = $this->common_model->get_list_ddr('employee_in');
		$employee_in = $comm_model->get_data_fromArray($search_filed_data,'employee_in');?>
            <div class="modal-header new-header-modal color-modal">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-mega-t">Employee In</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <h4 class="modal-title new-selected">(<span id="employee_in_sel_count"><?php
						if(isset($employee_in) && $employee_in!='' && is_array($employee_in) && count($employee_in)>0){
							echo count($employee_in);
						}else{
							echo 0;
						}
						?></span>) Selected</h4>
                    </div>
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        <button type="button" class=" btn search-new-modal-b" onclick="fn_apply_list('employee_in')">Apply Selection</button>
                    </div>
                </div>
                
                <button type="button" class="close close-vendor hidden-sm hidden-xs" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
                <button type="button" class="close close-vendor hidden-lg hidden-md" data-dismiss="modal" aria-hidden="true" style="margin-top:-120px !important;color:#fff;position:relative;
                z-index: 1024;">×</button>
            </div>
            <div class="modal-body">
                <div id="scroll-bar-custom">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng">
                            <p>Selected Employee In
                            <span><a href="javascript:void(0)" class="select-ll" onclick="list_deselect_all_a('employee_in')">Deselect All</a></span></p> 
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-7 no-padng" id="select_employee_in_dt">
                            <?php
							if(isset($employee_in) && $employee_in!='' && is_array($employee_in) && count($employee_in)>0){
								if(isset($employee_in_dt) && $employee_in_dt!='' && is_array($employee_in_dt) && count($employee_in_dt)>0){
									$i=1;
									foreach($employee_in_dt as $key=>$val){
										if(isset($employee_in) && $employee_in!=''){
											if(in_array($key,$employee_in)){?>
												<div class="new-check-box-modal" id="parent_employee_in_checkbox_<?php echo $i;?>">
                                                	<input type="checkbox" id="new_employee_in_<?php echo $i;?>" value="<?php echo $key;?>" checked="checked" onclick="list_dselect('<?php echo $i;?>','employee_in')">
                                                	<label for="new_employee_in_<?php echo $i;?>" class="sprinkles"><?php echo $val;?></label>
                                                </div>
												<?php
											}
										}
									$i++;
									}
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                    <hr class="hr-modal-s">
                    <span class="col-md-12 col-xs-12 alert alert-info" style="padding: 8px;">You can select maximum 10 employee in at once</span>
                    <hr class="hr-modal-s">
                    <div class="row margin-top-20">
                        <div class="col-md-12 col-xs-12 no-padng" id="no_select_employee_in_dt">
                            <?php
							if(isset($employee_in_dt) && $employee_in_dt!='' && is_array($employee_in_dt) && count($employee_in_dt)>0){
								$i=1;
								foreach($employee_in_dt as $key=>$val){
									$rel_check = 1;
									if(isset($employee_in) && $employee_in!=''){
										if(in_array($key,$employee_in)){
											$rel_check = 0;
										}
									}
									if($rel_check==1){?>
										<div class="new-check-box-modal" id="parent_employee_in_checkbox_<?php echo $i;?>">
											<input type="checkbox" id="new_employee_in_<?php echo $i;?>" value="<?php echo $key;?>" onclick="list_select('<?php echo $i;?>','employee_in');" />
											<label for="new_employee_in_<?php echo $i;?>" class="sprinkles"><?php echo $val;?></label>
										</div>
										<?php
									}
									$i++;
								}
								if(isset($employee_in) && $employee_in!='' && is_array($employee_in) && count($employee_in)==count($employee_in_dt)){
									echo '<p>Not Available</p>';
								}
							}else{
								echo '<p>Not Available</p>';
							}?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>