<?php
if(!isset($shortlist_data_count) || $shortlist_data_count =='')
{
	$shortlist_data_count = 0;
}
$success_message = $this->common_model->get_session_data_comm('success_message');
if(isset($success_message) && $success_message !=''){?>
	<div id="flash_message_saved_search" class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close" style="color:#000 !important">×</a>
	<?php echo $success_message; ?>
    </div>
<?php }
if(isset($shortlist_data) && $shortlist_data !='' && is_array($shortlist_data) && count($shortlist_data) > 0)
{
	foreach($shortlist_data as $shortlist_profile)
	{
	?><div class="row mt-4">
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="design-process-content das-content-2 padding-0">
            <div class="box-view-profile">
            <!-- mega-n3 -->
                <p class="Poppins-Semi-Bold f-16 "><span class="mega-n4 f-22 "><?php echo $shortlist_profile['search_name'];?></span> <span class="pull-right pull-right-mobile Poppins-Regular f-14"><?php echo $this->common_model->displayDate($shortlist_profile['created_on'],'D jS F - Y');?> <span class="Poppins-Regular f-18"><a onclick="delete_saved_search_set_id('<?php echo $shortlist_profile['id'];?>')" data-toggle="modal" data-target="#myModal_delete" title="Delete"><i class="fas fa-trash-alt color-d m-left-s"></i></a></span></span></p>
            </div>
            <hr class="hr-view">
            <div class="box-view-profile" style="padding:0px 12px;">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h5 class="color-profile f-16 Poppins-Regular">Save From <?php echo $shortlist_profile['search_page_nm'];?></h5>
                    </div>
                </div>
            </div>
            <div class="box-view-profile" style="padding:0px 12px;">
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <span class="pull-right">
                            <a href="<?php echo $base_url;?>search/saved-search-now/<?php echo $shortlist_profile['id'];?>" class="mega-n-btn1 button-zero-s post-s-d Poppins-Regular color-f f-16">
                                Search Now
                            </a>
                            <button class="mega-n-btn1 button-zero-s post-s-d Poppins-Regular color-f f-16" data-toggle="collapse" data-target="#drop_<?php echo $shortlist_profile['id'];?>" style="width: 205px;">
                                Saved Search Details <i class="fas fa-caret-down f-12 pt-1 lk_1"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div id="drop_<?php echo $shortlist_profile['id'];?>" class="collapse">
                <div class="box-view-profile mt-2" style="padding:0px 12px;">
                    <?php if(isset($shortlist_profile['search_page_nm']) && $shortlist_profile['search_page_nm'] == "Quick Search"){?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        From Age: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['from_age']) && $shortlist_profile['from_age']!='') {echo $shortlist_profile['from_age'];}else{echo "N/A";}?> Years
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        To Age: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-4 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['to_age']) && $shortlist_profile['to_age']!='') {echo $shortlist_profile['to_age'];}else{echo "N/A";}?> Years
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        From Height: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['from_height']) && $shortlist_profile['from_height']!='') {$from_height = $shortlist_profile['from_height'];echo $this->common_model->display_height($from_height);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        To Height: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['to_height']) && $shortlist_profile['to_height']!='') {$to_height = $shortlist_profile['to_height'];echo $this->common_model->display_height($to_height);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Marital Status: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['marital_status']) && $shortlist_profile['marital_status']!='') {$marital_status = $shortlist_profile['marital_status'];echo $marital_status_exp = str_replace(',',', ',$marital_status);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Religion: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['religion']) && $shortlist_profile['religion']!='') {echo $this->common_model->valueFromId('religion',$shortlist_profile['religion'],'religion_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Caste: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['caste']) && $shortlist_profile['caste']!='') {echo $this->common_model->valueFromId('caste',$shortlist_profile['caste'],'caste_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Mother Tongue: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['mother_tongue']) && $shortlist_profile['mother_tongue']!='') {echo $this->common_model->valueFromId('mothertongue',$shortlist_profile['mother_tongue'],'mtongue_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Country: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['country']) && $shortlist_profile['country']!='') {echo $this->common_model->valueFromId('country_master',$shortlist_profile['country'],'country_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        State: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['state']) && $shortlist_profile['state']!='') {echo $this->common_model->valueFromId('state_master',$shortlist_profile['state'],'state_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        City: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['city']) && $shortlist_profile['city']!='') {echo $this->common_model->valueFromId('city_master',$shortlist_profile['city'],'city_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Education: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['education']) && $shortlist_profile['education']!='') {echo $this->common_model->valueFromId('education_detail',$shortlist_profile['education'],'education_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        With Photo: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['with_photo']) && $shortlist_profile['with_photo']!='') {echo "Yes";}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php }
					if(isset($shortlist_profile['search_page_nm']) && $shortlist_profile['search_page_nm'] == "Advance Search"){?>
                    	<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        From Age: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['from_age']) && $shortlist_profile['from_age']!='') {echo $shortlist_profile['from_age'];}else{echo "N/A";}?> Years
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        To Age: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-4 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['to_age']) && $shortlist_profile['to_age']!='') {echo $shortlist_profile['to_age'];}else{echo "N/A";}?> Years
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        From Height: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['from_height']) && $shortlist_profile['from_height']!='') {$from_height = $shortlist_profile['from_height'];echo $this->common_model->display_height($from_height);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        To Height: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['to_height']) && $shortlist_profile['to_height']!='') {$to_height = $shortlist_profile['to_height'];echo $this->common_model->display_height($to_height);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Marital Status: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['marital_status']) && $shortlist_profile['marital_status']!='') {$marital_status = $shortlist_profile['marital_status'];echo $marital_status_exp = str_replace(',',', ',$marital_status);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Religion: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['religion']) && $shortlist_profile['religion']!='') {echo $this->common_model->valueFromId('religion',$shortlist_profile['religion'],'religion_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Caste: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['caste']) && $shortlist_profile['caste']!='') {echo $this->common_model->valueFromId('caste',$shortlist_profile['caste'],'caste_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Mother Tongue: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['mother_tongue']) && $shortlist_profile['mother_tongue']!='') {echo $this->common_model->valueFromId('mothertongue',$shortlist_profile['mother_tongue'],'mtongue_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        With Photo: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['with_photo']) && $shortlist_profile['with_photo']!='') {echo "Yes";}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Country: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['country']) && $shortlist_profile['country']!='') {echo $this->common_model->valueFromId('country_master',$shortlist_profile['country'],'country_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        State: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['state']) && $shortlist_profile['state']!='') {echo $this->common_model->valueFromId('state_master',$shortlist_profile['state'],'state_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        City: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['city']) && $shortlist_profile['city']!='') {echo $this->common_model->valueFromId('city_master',$shortlist_profile['city'],'city_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Education: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['education']) && $shortlist_profile['education']!='') {echo $this->common_model->valueFromId('education_detail',$shortlist_profile['education'],'education_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Occupation: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['occupation']) && $shortlist_profile['occupation']!='') {echo $this->common_model->valueFromId('occupation',$shortlist_profile['occupation'],'occupation_name');}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Employee In: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['employee_in']) && $shortlist_profile['employee_in']!=''){$employee_in = $shortlist_profile['employee_in'];echo $employee_in_exp = str_replace(',',', ',$employee_in);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Income: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                    <?php if(isset($shortlist_profile['income_str']) && $shortlist_profile['income_str']!=''){$income = $shortlist_profile['income_str']; echo $income_exp = str_replace('-|-',', ',$income);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Eating Habits: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['diet']) && $shortlist_profile['diet']!='') {$diet = $shortlist_profile['diet'];echo $diet_exp = str_replace(',',', ',$diet);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Drinking: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['drink']) && $shortlist_profile['drink']!='') {$drink = $shortlist_profile['drink'];echo $drink_exp = str_replace(',',', ',$drink);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Smoking: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['smoking']) && $shortlist_profile['smoking']!='') {$smoking = $shortlist_profile['smoking'];echo $smoking_exp = str_replace(',',', ',$smoking);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Complexion: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['complexion']) && $shortlist_profile['complexion']!='') {$complexion = $shortlist_profile['complexion'];echo $complexion_exp = str_replace(',',', ',$complexion);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Body type: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['bodytype']) && $shortlist_profile['bodytype']!=''){$bodytype = $shortlist_profile['bodytype'];echo $bodytype_exp = str_replace(',',', ',$bodytype); }else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Manglik: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['manglik']) && $shortlist_profile['manglik']!='') {$manglik = $shortlist_profile['manglik'];echo $manglik_exp = str_replace(',',', ',$manglik);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Star: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['star']) && $shortlist_profile['star']!=''){$star = $shortlist_profile['star'];echo $star_exp = str_replace(',',', ',$star);}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
					<?php }if(isset($shortlist_profile['search_page_nm']) && $shortlist_profile['search_page_nm']=="Keyword Search"){?>
                    	<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Keyword: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['keyword']) && $shortlist_profile['keyword']!='') {echo $shortlist_profile['keyword'];}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        With Photo: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['with_photo']) && $shortlist_profile['with_photo']!='') {echo "Yes";}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php }if(isset($shortlist_profile['search_page_nm']) && $shortlist_profile['search_page_nm']=="ID Search"){?>
                    	<div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="col-md-4 col-sm-4 col-xs-6">
                                    <p class="sr1 Roboto-Bold">
                                        Matri ID: 
                                    </p>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-6">
                                    <p class="sr2 Roboto-Bold">
                                        <?php if(isset($shortlist_profile['id_search']) && $shortlist_profile['id_search']!='') {echo $shortlist_profile['id_search'];}else{echo "N/A";}?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>

<div id="myModal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Delete This Saved <span class="mega-n4 f-s">Search</span></p>
                <input type="hidden" name="saved_search_id" id="saved_search_id" value="" />
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
				<div id="delete_photo_alt" class="alert alert-danger" style="overflow:hidden;">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <img src="<?php echo $base_url; ?>assets/front_end/images/icon/user-detele.png" alt="" class="margin-right-10" />
                    </div>
                    <div class="col-md-10 col-sm-6 col-xs-12">
                        <strong>Are you sure you want to Remove this Saved Search?</strong><br />
						<span class="small">This Profile will be remove Permanently from your saved Records.</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <span class="pull-right float-none">
                                <button onClick="delete_saved_search()" class="add-w-btn new-msg-btn yes-no left-zero-msg Poppins-Medium color-f f-18">Yes</button>
                                <button class="add-w-btn left-zero-msg new-msg-btn yes-no Poppins-Medium color-f f-18" data-dismiss="modal">No</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}else{?>
	<div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="no-data-f">
            <lottie-player style="margin: auto; height:300px; width:300px;" src="https://assets7.lottiefiles.com/packages/lf20_rc6CDU.json"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay></lottie-player>
               <h1  class="color-no"><span style="font-size: 18px !important; font-family:poppins-medium;" class="Poppins-medium color-no">No Data Found</span></h1>
            </div>
        </div>
    </div>
<?php }?>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>