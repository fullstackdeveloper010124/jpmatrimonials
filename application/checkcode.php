<?php 
$data_table_mem = '';
$disp_column_array ='';
if(isset($other_config_data['data_table_mem']) && $other_config_data['data_table_mem'] !='')
{
    $data_table_mem = $other_config_data['data_table_mem'];
}
if(isset($data_table_mem['disp_column_array']) && $data_table_mem['disp_column_array'] !='')
{
    $disp_column_array = $data_table_mem['disp_column_array'];
}
$display_image_clm = 'photo1';
$path_img = 'photos/';

$display_img = 'Yes';
if(isset($other_config_data['hide_display_image']) && $other_config_data['hide_display_image'] !='')
{
    $display_img = 'No';
}
if(isset($other_config_data['display_image']) && $other_config_data['display_image'] !='')
{
    $display_image_clm = $other_config_data['display_image'];
}
if(isset($display_img) && $display_img !='' && $display_img =='Yes')
{
    if(isset($other_config_data[$display_image_clm]) && $other_config_data[$display_image_clm] !='')
    {
        $path_img = $other_config_data[$display_image_clm];
    }
}
$contact_arr = array('address','city','phone','mobile','email','city_name');
?>
<!--<div class="panel mb25">
    <div class="panel-body">-->
        <div class="panel-inner-d">
        <!-- start panel -->
            <form method="post" action="<?php if(isset($this->common_model->base_url_admin_cm) && $this->common_model->base_url_admin_cm !=''){ echo $this->common_model->base_url_admin_cm;} ?>" onSubmit="return search_change_limit()">
                <div class="row">
                    <?php
                    $search_filed = '';
                    $class_clear = '';
                    if(isset($this->common_model->search_filed) && $this->common_model->search_filed !=''){
                        $search_filed = htmlentities(stripcslashes($this->common_model->search_filed));
                        $class_clear = 'x onX';
                    }?>
                    <?php if(!isset($other_config_data['searchAllow']) || $other_config_data['searchAllow'] !='no'){?>
                        <div class="col-md-6 col-sm-6 col-xs-12 input-group ms-input">
                            <input type="search" name="search_filed" id="search_filed" class="form-control clearable <?php echo $class_clear; ?>" value="<?php echo $search_filed; ?>" placeholder="Search here.." />
                            <span class="input-group-btn ms-input-btn">
                            <button type="submit" class="btn btn-primary m1-search"><i class="fa fa-search"></i> Search</button>
                            </span>
                        </div>
                    <?php }else{?>
                    <div class="col-md-6 col-sm-6 col-xs-12 input-group ms-input ms-input2">
                        <input type="hidden" name="search_filed" id="search_filed" class="form-control" />
                    </div>
                    <?php }?>
                    <div class="col-md-<?php if(!isset($other_config_data['searchAllow']) || $other_config_data['searchAllow'] !='no'){echo '6';}else{echo '12';}?> col-sm-12 col-xs-12">
                        <div class="d-btn-group" <?php if(!isset($other_config_data['searchAllow']) || $other_config_data['searchAllow'] !='no'){}else{?>style="margin-right: 30px;"<?php }?>>
                            <?php
                            $addPopup = 0;
                            if(isset($this->common_model->addPopup) && $this->common_model->addPopup == '1'){
                                $addPopup = 1;
                            }
                        
                            if(isset($other_config_data['display_filter']) && $other_config_data['display_filter'] !='' && $other_config_data['display_filter'] =='Yes'){
                                if($this->common_model->session_search_name !=''){
                                    $session_search_name = $this->common_model->session_search_name;
                                    if(isset($session_search_name) && $session_search_name !=''){
                                        $session_search_name_val = $this->session->userdata($session_search_name);
                                        if($session_search_name_val !=''){?>
                                            <a href="javascript:;" onClick="clear_model_filter()" class="btn btn-info btn-clear"><i class="fa fa-filter"></i>&nbsp;&nbsp;Clear filter&nbsp;</a>
                                        <?php }
                                    }
                                }?>
                                <a data-toggle="modal" data-target="#myModal_filter" class="btn btn-info btn-filter"><i class="fa fa-filter"></i>&nbsp;&nbsp;Filter&nbsp;</a>
                            <?php
                            }
                            if(!isset($other_config_data['addAllow']) || $other_config_data['addAllow'] !='no'){
                                if(isset($this->common_model->add_fun) && $this->common_model->add_fun !=''){
                                    $add_fun = $this->common_model->add_fun;
                                }
                                if(isset($addPopup) && $addPopup =='1'){?>
                                    <a id="new" onClick="add_data_popup()" data-toggle="modal" data-target="#myModal" class="btn btn-danger mb15 ml15 btn-add-new"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New&nbsp;</a>
                                <?php }else{
                                    $add_url_btn = $this->common_model->base_url_admin_cm.'add-data';
                                    if(isset($other_config_data['add_url']) && $other_config_data['add_url'] !=''){
                                        $add_url_btn = $this->common_model->data['base_url_admin'].$other_config_data['add_url'];
                                    }?>
                                        <a id="new" href="<?php echo $add_url_btn;?>" class="btn btn-danger ml15 btn-add-new"><i class="fa fa-plus"></i>&nbsp;&nbsp;Add New&nbsp;</a>
                                <?php }
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 mt15">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php 
                        if($this->session->flashdata('success_message'))
                        {
                           echo $message_div='<div id="sucss_msg"><div class="alert alert-success alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('success_message').'</div></div>';
                           $this->session->unset_userdata('success_message');
                        }
                        if($this->session->flashdata('error_message'))
                        {
                            echo $message_div='<div id="sucss_msg"><div class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('error_message').'</div></div>';
                            $this->session->unset_userdata('error_message');
                        }
                        if($this->session->flashdata('error_message_js'))
                        {
                            echo $message_div='<div id="sucss_msg">'.$this->session->flashdata('error_message_js').'</div>';
                            $this->session->unset_userdata('error_message_js');
                        }?>
                        </div>
                    </div>
                    <?php 
                    if(isset($this->common_model->data_tabel_filtered_count) && $this->common_model->data_tabel_filtered_count !='' && $this->common_model->data_tabel_filtered_count > 0){
                        $disp_select_all = 0;
                        if((!isset($other_config_data['deleteAllow']) || $other_config_data['deleteAllow'] !='no')|| (!isset($other_config_data['statusChangeAllow']) || $other_config_data['statusChangeAllow'] !='no')){
                            $disp_select_all = 1;
                        }?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-12 col-sm-3 col-xs-12">
                                <?php if($disp_select_all == 1){?>
                                    <div class="s-all">
                                        <label class="cb-checkbox mb0 pb1pt5" id="all_check">
                                            <input class="all_check " type="checkbox" id="all" /> Select All
                                        </label>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="col-md-12 col-sm-9 col-xs-12">
                                <div class="btn-group-m2">
                                <?php if(!isset($other_config_data['deleteAllow']) || $other_config_data['deleteAllow'] !='no'){?>
                                    <a onClick="return update_status('DELETE')" href="javascript:void(0);" class="btn btn-danger mb15 ml15 btn-delete"><i class="fa fa-trash fa-fw"></i>&nbsp;&nbsp;Delete&nbsp;</a>
                                <?php }$status_arr = $this->common_model->status_arr_change;
                                if(!isset($other_config_data['statusChangeAllow']) || $other_config_data['statusChangeAllow'] !='no'){
                                    if(isset($status_arr) && count($status_arr) > 0){
                                        foreach($status_arr as $key=>$val){
                                            $class_fa = '';
                                            if(isset($status_arr_faList[$key]) && $status_arr_faList[$key] !=''){
                                                $class_fa = $status_arr_faList[$key];
                                            }
                                            $class_colr = 'btn-primary';
                                            if(isset($status_arr_colorList[$key]) && $status_arr_colorList[$key] !=''){
                                                $class_colr = $status_arr_colorList[$key];
                                            }
                                            if($val == 'APPROVED' || $val == 'UNAPPROVED'){
                                                $key_d = ucwords(strtolower($val));
                                            }else{
                                                $key_d = ucfirst(($val));
                                            }?>
                                            <a onClick="return update_status('<?php echo $key;?>')" href="javascript:void(0);" class="btn mb15 ml15 <?php echo $class_colr;?>">&nbsp;&nbsp;<?php echo $key_d; ?>&nbsp;</a>
                                    <?php }
                                    }
                                }?>
                                </div>
                            </div>
                        </div>              
                    <?php }?>
                </div>
                <?php 
                $user_type = $this->common_model->get_session_user_type();
                if($user_type == 'admin'){?>
                <div class="row margin-top-26">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <?php
                    if($this->common_model->assing_to_member=='yes'){
                        $staff = $this->common_model->get_count_data_manual('staff',array('status'=>'APPROVED'),2,'*','','');
                        $assign_arr = $this->common_model->staffassign_arr_change;
                        if(isset($assign_arr) && count($assign_arr) > 0){?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-12 col-xs-12 padding-left0-for-small-device">
                                <select name="staff_id" id="staff_id" class="form-control select-satf-m2">
                                    <option value="">Select Staff</option>
                                    <?php if(isset($staff) && $staff!='' && is_array($staff) && count($staff)>0){
                                        foreach($staff as $staff_val){
                                            echo '<option value="'.$staff_val['id'].'">'.$staff_val['username'].'</option>';    
                                        }
                                    }?>
                                </select>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12 for-device assign-staff-main" style="width: 65%;padding-left: 22px;padding-right: 2px;">
                                <?php foreach($assign_arr as $key=>$val){
                                    $class_fa = '';
                                    if(isset($status_arr_faList[$key]) && $status_arr_faList[$key] !='')
                                    {
                                        $class_fa = $status_arr_faList[$key];
                                    }
                                    $class_colr = 'btn-primary';
                                    if(isset($status_arr_colorList[$key]) && $status_arr_colorList[$key] !='')
                                    {
                                        $class_colr = $status_arr_colorList[$key];
                                    }
                                    $key_d = ucfirst(($val));?>     
                                        <a onClick="return update_assign_status('<?php echo $key;?>','staff')" href="javascript:void(0);" class="btn btn-primary mb15 <?php echo $class_colr;?> ">&nbsp;&nbsp;<?php echo $key_d; ?>&nbsp;</a>
                                <?php }?>
                            </div>
                        </div>
                        <?php }
                        $assign_arr = $this->common_model->franchiseassign_arr_change;
                        if(isset($assign_arr) && count($assign_arr) > 0){
                            ?><div class="col-md-6 col-sm-12 col-xs-12"><strong></strong><?php
                            $franchise = $this->common_model->get_count_data_manual('franchise',array('status'=>'APPROVED'),2,'*','','','');?>
                            <div class="col-md-4 col-sm-12 col-xs-12 padding-left0-for-small-device">
                                <select name="franchise_id" id="franchise_id" class="form-control select-satf-m3">
                                    <option value="">Select Franchise</option>
                                    <?php if(isset($franchise) && $franchise!='' && is_array($franchise) && count($franchise)>0){
                                        foreach($franchise as $franchise_val){
                                            echo '<option value="'.$franchise_val['id'].'">'.$franchise_val['username'].'</option>';
                                        }
                                    }?>
                                </select>
                            </div>
                            <div class="col-md-8 col-sm-12 col-xs-12 padding-left0-for-small-device">
                                <?php foreach($assign_arr as $key=>$val){
                                    $class_fa = '';
                                    if(isset($status_arr_faList[$key]) && $status_arr_faList[$key] !=''){
                                        $class_fa = $status_arr_faList[$key];
                                    }
                                    $class_colr = 'btn-primary';
                                    if(isset($status_arr_colorList[$key]) && $status_arr_colorList[$key] !=''){
                                        $class_colr = $status_arr_colorList[$key];
                                    }
                                    $key_d = ucfirst(($val));?>
                                        <a onClick="return update_assign_status('<?php echo $key;?>','franchise')" href="#" class="btn btn-primary mb15 <?php echo $class_colr;?>">&nbsp;&nbsp;<?php echo $key_d; ?>&nbsp;</a>
                                <?php }?>
                                </div>
                            </div>
                        <?php }
                        }?>                    
                    </div>
                </div>
                <?php if($this->common_model->change_interest=='yes'){
                    $interest = array('New Register'=>'New Register','Green'=>'Green','Blue'=>'Blue','Orange'=>'Orange','Red'=>'Red','Final Client'=>'Final Client','Incoming Call'=>'Incoming Call')
                    ?>
                    <div class="row margin-top-10">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-12 col-xs-12 padding-left0-for-small-device">
                                <select name="interest" id="interest" class="form-control select-satf-m2">
                                    <option value="">Select Interest</option>
                                    <?php if(isset($interest) && $interest!='' && is_array($interest) && count($interest)>0){
                                        foreach($interest as $interest_key => $interest_val){
                                            echo '<option value="'.$interest_key.'">'.$interest_val.'</option>';    
                                        }
                                    }?>
                                </select>
                            </div>
                            <div class="col-md-8 col-sm-6 col-xs-12 for-device assign-staff-main" style="width: 65%;padding-left: 22px;padding-right: 2px;">
                                <a onClick="change_interest('interest')" href="javascript:void(0);" class="btn btn-warning mb15 other-btn">&nbsp;&nbsp;Change Interest&nbsp;</a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php }
                }?>
                <div class="row margin-top-26">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-6 col-sm-12 col-xs-12 padding-left0-for-small-device">
                            <div class="show-entry">
                                <label class="show-m2 color-black">
                                    Show
                                </label>
                                <label>
                                <?php $limit_per_page = $this->common_model->limit_per_page;?>
                                <select name="limit_per_page" id="limit_per_page" class="form-control option-cstm color-black font-size-14px" onchange="search_change_limit()">
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==1){ echo 'selected';} ?> value="1">1</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==2){ echo 'selected';} ?> value="2">2</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==3){ echo 'selected';} ?> value="3">3</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==5){ echo 'selected';} ?> value="5">5</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==10){ echo 'selected';} ?> value="10">10</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==25){ echo 'selected';} ?> value="25">25</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==50){ echo 'selected';} ?> value="50">50</option>
                                    <option <?php if(isset($limit_per_page) && $limit_per_page ==100){ echo 'selected';} ?> value="100">100</option>
                                </select>
                            </label>
                            <label class="font-size-14px color-black lable-entry">
                                Entries
                            </label>
                        </div>
                    </div>
                    <?php
                    $sort_column_dt = '';
                    $sort_order_dt = '';
                    if(isset($data_table_parameter['default_sort']) && $data_table_parameter['default_sort'] !='')
                    {
                        $sort_column_dt = $data_table_parameter['default_sort'];
                    }
                    if(isset($data_table_parameter['default_order']) && $data_table_parameter['default_order'] !='')
                    {
                        $sort_order_dt = $data_table_parameter['default_order'];
                    }
                    $sort_column_arr = '';
                    if(isset($other_config_data['sort_column']) && $other_config_data['sort_column'] !='' && count($other_config_data['sort_column'])> 0)
                    {
                        $sort_column_arr = $other_config_data['sort_column'];
                    }
                   
                    if($sort_column_arr !='')
                    {
                    ?>
                    <div class="col-md-6 col-sm-12 col-xs-12 padding-left0-for-small-device">
                        <div class="sr-m2">
                            <label class="sr-m3">
                                Sort
                            </label>
                            <label>
                                <select name="sort_order_js" id="sort_order_js" class="form-control sr-m4" onchange="change_sort_order(this.value)">
                                <?php foreach($sort_column_arr as $keysc=>$valsc){?>
                                    <option value="<?php echo $keysc; ?>-desc" <?php if($sort_column_dt ==$keysc && $sort_order_dt =='desc'){ echo 'selected';} ?>><?php echo $valsc; ?> Descending</option>
                        <option value="<?php echo $keysc; ?>-asc" <?php if($sort_column_dt ==$keysc && $sort_order_dt =='asc'){ echo 'selected';} ?>><?php echo $valsc; ?> Ascending</option>
                                <?php }?>
                                </select>
                            </label>
                        </div>
                    </div>
                    <?php }?>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="tab mega-admin-tab" role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                        <?php 
                        if(!isset($other_config_data['AllAllow']) || $other_config_data['AllAllow'] !='no'){?>
                            <li role="presentation" class="<?php if($this->uri->segment(4)=='ALL'){ echo 'active';}?>">
                                <a href="<?php echo $this->common_model->base_url_admin_cm;?>ALL/1/yes">All<p class="m-all"> (<?php echo $data_tabel_all_count; ?>)</p></a>
                            </li>
                        <?php }
                        if(!isset($other_config_data['display_status']) || $other_config_data['display_status'] !='no'){
                            $status_arr = array();
                            if(isset($this->common_model->status_arr) && $this->common_model->status_arr !=''){
                                $status_arr = $this->common_model->status_arr;
                                if(isset($status_arr) && count($status_arr) > 0){
                                    foreach($status_arr as $key=>$val){
                                        $class_fa = '';
                                        if(isset($status_arr_faList[$key]) && $status_arr_faList[$key] !=''){
                                            $class_fa = $status_arr_faList[$key];
                                        }
                                        $class_colr = 'btn-primary';
                                        if(isset($status_arr_colorList[$key]) && $status_arr_colorList[$key] !=''){
                                            $class_colr = $status_arr_colorList[$key];
                                        }
                                        $key_d = ucfirst(strtolower($val));
                                        $data_status_count = 0;
                                        if(in_array($this->common_model->status_column,$data_tabel_filed)){
                                            $where_arr = array();
                                            $table = $this->common_model->table_name;
                                            if($key == 'Paid'){
                                                $this->common_model->add_personal_where();
                                                $where_arr = array('plan_status'=>$key);
                                            }
                                            elseif($key == 'Featured' || $key == 'Unfeatured'){
                                                $this->common_model->add_personal_where();
                                                $where_arr = array('fstatus'=>$key);
                                            }
                                            else{
                                                $this->common_model->add_personal_where();
                                                $where_arr = array($this->common_model->status_column=>$key);
                                            }
                                            $data_status_count = $this->common_model->get_count_data_manual($table,$where_arr,0,$this->common_model->primary_key);
                                        }?>
                                        <li role="presentation" class="<?php if($this->uri->segment(4)==$key){ echo 'active';}?>">
                                            <a href="<?php echo $this->common_model->base_url_admin_cm.$key;?>"><?php echo $key_d; ?> List<br><p class="m-all">(<?php echo $data_status_count; ?>)</p></a>
                                        </li>
                                    <?php
                                    }
                                }
                            }
                            if($this->router->fetch_method() == 'follow_up_report' || $this->router->fetch_method() == 'lead_generation_follow_up_report'){
                                if($this->router->fetch_method() == 'follow_up_report'){
                                    $tnp_table = 'followup_system_view';
                                    $pen_table = 'register';
                                }
                                else{
                                    $tnp_table = 'lead_generation_followup_system_view';
                                    $pen_table = 'leads_generation';
                                }
                                $today_date = $this->common_model->getCurrentDate('Y-m-d');
                                
                                $access_perm = $this->common_model->check_permission('view_member','redirect');
                                $other = $this->common_model->add_own_where('',$access_perm);
                                $Today_where    = "next_followup_date = '".$today_date."' ";
                                $Next_where     = "next_followup_date > '".$today_date."' ";
                                $Prev_where     = "next_followup_date < '".$today_date."' ";
                                $Pending_where  = "( staff_assign_id!='' or franchise_assign_id!='') and commented='0' ";
                                if(isset($other['personal_where']) && $other['personal_where']!=''){
                                    $where          = "and ".$other['personal_where'];
                                    $Today_where .= $where;
                                    $Next_where .= $where;
                                    $Prev_where .= $where;
                                    $Pending_where .= $where;
                                }
                                $today_count = $this->common_model->get_count_data_manual($tnp_table,$Today_where,0,$this->common_model->primary_key);
                               
                                $next_count = $this->common_model->get_count_data_manual($tnp_table,$Next_where,0,$this->common_model->primary_key);
                                $prev_count = $this->common_model->get_count_data_manual($tnp_table,$Prev_where,0,$this->common_model->primary_key);
                                $pending_count = $this->common_model->get_count_data_manual($pen_table,$Pending_where,0,$this->common_model->primary_key);?>
                                <li role="presentation" class="<?php if($this->uri->segment(4)=='Today'){ echo 'active';}?>">
                                    <a href="<?php echo $this->common_model->base_url_admin_cm.'Today';?>">Today Followup<p class="m-all">(<?php echo $today_count; 

                                        ?>)</p></a>
                                </li>

                                <li role="presentation" class="<?php if($this->uri->segment(4)=='Previous'){ echo 'active';}?>">
                                    <a href="<?php echo $this->common_model->base_url_admin_cm.'Previous';?>">Previous Followup<p class="m-all">(<?php echo $prev_count; ?>)</p></a>
                                </li>
                                <li role="presentation" class="<?php if($this->uri->segment(4)=='Next'){ echo 'active';}?>">
                                    <a href="<?php echo $this->common_model->base_url_admin_cm.'Next';?>">Next Followup<p class="m-all">(<?php echo $next_count; ?>)</p></a>
                                </li>
                                <li role="presentation" class="<?php if($this->uri->segment(4)=='Pending'){ echo 'active';}?>">
                                    <a href="<?php echo $this->common_model->base_url_admin_cm.'Pending';?>">Pending Followup<p class="m-all">(<?php echo $pending_count; ?>)</p></a>
                                </li>
                                <?php }
                                if($this->router->fetch_method() == 'lead_generation_list'){
                                    $b_url = $this->common_model->base_url_admin_cm;
                                    $seg = $this->uri->segment(4);
                                    $pkey = $this->common_model->primary_key;
                                    $arr = array('ALL'=>'All','Call'=>'Incoming Call','Final'=>'Approved Final','Green'=>'Some Response','Blue'=>'Never Talked','Orange'=>'50-50','Red'=>'No Response','New'=>'New Register');
                                    if(isset($arr) && count($arr) > 0){
                                        foreach($arr as $key=>$val){
                                            $where_arr = array();
                                            $table = $this->common_model->table_name;
                                            if($key == 'Final'){
                                                $where_arr = array('interest!='=>'','interest'=>'Final Client');
                                            }
                                            else if($key == 'Call'){
                                                $where_arr = array('interest!='=>'','interest'=>'Incoming Call');
                                            }
                                            else if($key == 'New'){
                                                $where_arr = array('interest!='=>'','interest'=>'New Register');
                                            }
                                            else if($key == 'ALL'){
                                                $where_arr = array('interest!='=>'');
                                            }
                                            else{
                                                $where_arr = array('interest!='=>'','interest'=>$key);
                                            }
                                            $user_type = $this->common_model->get_session_user_type();
                                            $u_id = $this->common_model->get_session_data('id');
                                            $access_perm = $this->common_model->check_permission('view_lead_generation','redirect');
                                            if($user_type=='staff')
                                            {
                                                  $user_type = 'Staff';

                                                if($access_perm=='Own Members')    
                                                {
                                                    
                                                   
                                                   $where_arr[] = " staff_assign_id = '".$u_id."' ";
                                                    
                                                }
                                                
                                            }
                                            $key_d = ucfirst($val);
                                            $data_status_count = $this->common_model->get_count_data_manual('leads_generation_view',$where_arr,0,$pkey);?>
                                            <li role="presentation" class="<?php if($seg==$key){ echo 'active';}?>">
                                                <a href="<?php echo $b_url.$key.'/1/yes';?>"><?php echo $key_d; ?><p class="m-all">(<?php echo $data_status_count;?>)</p></a>
                                            </li>
                                            <?php
                                        }
                                    }
                                }
                            }?>
                        </ul>
                        <!-- Tab panes -->
                        
                        <div class="tab-content tabs mega-panel">
                            <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                            <?php
                            if(isset($this->common_model->data_tabel_data) && $this->common_model->data_tabel_data !='' && count($this->common_model->data_tabel_data) > 0)
                            {
                                foreach($this->common_model->data_tabel_data as $data_val)
                                {
                                $temp_id = $data_val[$this->common_model->primary_key];
                                $temp_edit_pop = '';
                                $temp_edit_pop.= 'data-'.$this->common_model->primary_key.'="'.$data_val[$this->common_model->primary_key].'" ';
                                ?>
                                <div class="col-lg-12 col-xs-12 col-md-12 neAdminResult">
                                    <div class="row mar_rowm15">
                                        <div class="col-lg-1 col-xs-2 col-md-1 neMrgAbottom10 neMrgATop10 checkbox-row">
                                            <?php if($disp_select_all == 1){?>
                                                <label class="cb-checkbox"><input type="checkbox" class="checkbox_val" name="checkbox_val[]" value="<?php echo $temp_id;?>" ></label>
                                            <?php }?>
                                        </div>
                                        <?php
                                            $today_date = $this->common_model->getCurrentDate('Y-m-d');
                                            if(isset($data_val['fstatus']) && $data_val['fstatus'] !='' && $data_val['fstatus'] =='Featured' && $data_val['plan_expired_on'] >= $today_date){
                                                $i="5";
                                            }else{
                                                $i="8";
                                            }
                                        ?>
                                <h3 class="col-lg-<?php echo $i;?> col-xs-10 col-md-5"><?php 
                                    $tool_tip_img = 'No Image';
                                    $personal_title = '';
                                    
                                    if(isset($data_table_mem['post_title_disp']) && isset($data_val[$data_table_mem['post_title_disp']]) && $data_val[$data_table_mem['post_title_disp']] !=''){
                                        $personal_title = '<small> ( '.$data_val[$data_table_mem['post_title_disp']].' )</small>';
                                    }
                                    
                                    if(isset($data_val[$data_table_mem['title_disp']]) && $data_val[$data_table_mem['title_disp']] !=''){
                                        echo $tool_tip_img = strip_tags($data_val[$data_table_mem['title_disp']].$personal_title);
                                    }else{
                                        if(isset($data_table_mem['title_disp']) && $data_table_mem['title_disp'] == "Success Story"){
                                            echo "";
                                        }else{
                                            echo '-';
                                        }
                                    }
                                    $status_filed ='status';
                                    if(isset($this->common_model->status_field) && $this->common_model->status_field !=''){
                                        $status_filed = $this->common_model->status_field;
                                    }
                                    $statuss_val ='';
                                    $thumb_vals = '';
                                    $thumb_val_colors = '';
                                    
                                    if(isset($data_val['fstatus']) && $data_val['fstatus'] !='' && $data_val['fstatus'] =='Featured'){
                                        $thumb_vals = 'fa fa-star';
                                        $thumb_val_colors = 'text-warning';
                                        $statuss_val = 'Featured';
                                    }
                                    $status_val = 'UNAPPROVED';
                                    if(isset($data_val[$status_filed]) && $data_val[$status_filed] !=''){
                                        $status_val = $data_val[$status_filed];
                                    }
                                    if($status_val=='APPROVED' && isset($data_val['plan_status']) && $data_val['plan_status'] !='' && $data_val['plan_status'] =='Paid' || ($status_val=='Featured' || $status_val=='Unfeatured')){
                                        $status_val = 'Paid';
                                    }
                                    
                                    if(isset($status_arr_faList[$status_val]) && $status_arr_faList[$status_val] !=''){
                                        $thumb_val = $status_arr_faList[$status_val];
                                    }
                                    if(isset($status_arr_color_dm[$status_val]) && $status_arr_color_dm[$status_val] !=''){
                                        $thumb_val_color = $status_arr_color_dm[$status_val];
                                    }?>
                                </h3>
                                <?php 
                                 if(isset($data_val['plan_expired_on']) && $data_val['plan_expired_on'] !='' && $data_val['plan_expired_on'] >= $today_date){
                                if(isset($data_val['fstatus']) && $data_val['fstatus'] !='' && $data_val['fstatus'] =='Featured'){?>
                                    <ul class="col-lg-3 col-lg-4 col-xs-12 col-md-6 topRightDetail">
                                        <li class="col-lg-3 col-xs-4 text-right imgPaddingRightZero">
                                            <i class="<?php echo $thumb_vals.' '.$thumb_val_colors; ?>"></i>
                                        </li>
                                        <li class="col-lg-8 col-xs-8 text-left ">
                                            <span class="<?php echo $thumb_val_colors;?> text-bold"><?php echo $statuss_val; ?> </span>
                                        </li>
                                    </ul>
                                <?php }
                                 }else{
                                     $this->member_model->update_feature_member($data_val['id']);
                                 }
                                ?>
                                <?php if(!isset($data_table_mem['disp_status']) || $data_table_mem['disp_status'] !='no'){?>
                                    <ul class="col-lg-3 col-lg-4 col-xs-12 col-md-6 topRightDetail">
                                        <li class="col-lg-3 col-xs-4 text-right imgPaddingRightZero">
                                            <i class="<?php echo $thumb_val.' '.$thumb_val_color; ?>"></i>
                                        </li>
                                        <li class="col-lg-8 col-xs-8 text-left ">
                                            <span class="<?php echo $thumb_val_color;?> text-bold"><?php echo $status_val; ?> </span>
                                        </li>
                                    </ul>
                                <?php }?>
                                <div class="clearfix"></div>
                                <?php if(isset($display_img) && $display_img !='' && $display_img =='Yes'){?>
                                    <div class="col-lg-2 col-xs-12 col-sm-6 col-md-3 imgPaddingRightZero">
                                        <?php $avatar = $this->common_model->photo_avtar;
                                        if(isset($data_val[$display_image_clm]) && $data_val[$display_image_clm] !=''){
                                            $temp_img = $data_val[$display_image_clm];
                                            if(file_exists($path_img.$temp_img)){
                                                $avatar = $path_img.$temp_img;
                                            }
                                        }?>
                                        <img data-src="<?php echo $base_url.$avatar; ?>" title="<?php echo $tool_tip_img; ?>" alt="<?php echo $tool_tip_img; ?>" class=" img-responsive lazyload" />
                                </div>
                                <?php
                                    $lg_cl = 10;
                                    $md_cl = 9;
                                }else{
                                    $lg_cl = 12;
                                    $md_cl = 12;
                                }?>
                                <div class="col-lg-<?php echo $lg_cl; ?> col-xs-12 col-md-<?php echo $md_cl; ?> neMarTop10-xs PaddingLftRigZero-xs ">
                                <?php
                                    if(isset($disp_column_array) && $disp_column_array !='' && count($disp_column_array) >0)
                                    {
                                        foreach($disp_column_array as $disp_column_array_val)
                                        {?>
                                            <div class="col-lg-6 col-xs-12 neAdminResultDetail">
                                                <div class="col-lg-4 col-xs-4">
                                                    <?php echo $this->common_model->get_label('',$disp_column_array_val); ?>
                                                </div>
                                                <div class="col-lg-8 col-xs-8" style="word-wrap:break-word;">:&nbsp;
                                                    <?php 
                                                    if(isset($data_val[$disp_column_array_val]) && $data_val[$disp_column_array_val] !='')
                                                    {
                                                        if(isset($display_date_arr) && in_array($disp_column_array_val,$display_date_arr))
                                                        {
                                                            echo $this->common_model->displayDate($data_val[$disp_column_array_val]);
                                                            if(isset($disp_column_array_val) && $disp_column_array_val =='birthdate' && $data_val[$disp_column_array_val] !='' && $data_val[$disp_column_array_val] !='0000-00-00')
                                                            {
                                                                echo '('.floor((time() - strtotime($data_val[$disp_column_array_val]))/31556926).' Years)';
                                                            }
                                                        }
                                                        else if(isset($display_currency_arr) && in_array($disp_column_array_val,$display_currency_arr))
                                                        {
                                                            $currency ='';
                                                            if(isset($data_val['currency']) && $data_val['currency'] !='')
                                                            {
                                                                $currency = $data_val['currency'];
                                                            }
                                                            echo $currency.' '.$data_val[$disp_column_array_val];
                                                        }
                                                        else if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && isset($contact_arr) && in_array($disp_column_array_val,$contact_arr))
                                                        {
                                                            echo $this->common_model->disable_in_demo_text;
                                                        }
                                                        else
                                                        {
                                                            if($disp_column_array_val == 'comment'){
                                                                echo strip_tags($data_val[$disp_column_array_val]);
                                                            }
                                                            else{
                                                                echo $data_val[$disp_column_array_val];
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                        }
                                    ?>
                                    <div class="clearfix"></div>
                                    <?php
                                    if(isset($data_tab_btn_arr) && $data_tab_btn_arr !='' && count($data_tab_btn_arr) > 0)
                                    {
                                        foreach($data_tab_btn_arr as $data_tab_btn_arr_val)
                                        {
                                            if(isset($data_tab_btn_arr_val['own_only']) && $data_tab_btn_arr_val['own_only'] =='yes')
                                            {
                                                if(isset($data_val[$user_id_check_filed]) && isset($user_logged_id) && $data_val[$user_id_check_filed] == $user_logged_id)
                                                {
                                                    
                                                }
                                                else
                                                {
                                                    continue;
                                                }
                                                if($status_val=='APPROVED')
                                                {
                                                    if(isset($data_tab_btn_arr_val['label']) && $data_tab_btn_arr_val['label'] =='APPROVE')
                                                    {
                                                        continue;
                                                    }
                                                }
                                                if($status_val=='UNAPPROVED')
                                                {
                                                    if(isset($data_tab_btn_arr_val['label']) && $data_tab_btn_arr_val['label'] =='UNAPPROVE')
                                                    {
                                                        continue;
                                                    }
                                                }
                                                if($status_val=='Suspended'){
                                                    if(isset($data_tab_btn_arr_val['label']) && $data_tab_btn_arr_val['label'] =='Suspend'){
                                                        continue;
                                                    }
                                                }
                                            }
                                            $class = 'info';
                                            if(isset($data_tab_btn_arr_val['class']) && $data_tab_btn_arr_val['class'] !=''){
                                                $class = $data_tab_btn_arr_val['class'];
                                            }
                                            $href = '';
                                            $onClick_btn = '';
                                            if($data_tab_btn_arr_val['label'] == 'Match'){
                                                if(isset($data_val['status']) && $data_val['status'] == 'APPROVED'){
                                                    $href = $data_tab_btn_arr_val['url'];
                                                    $href = str_replace('#matri_id#',$data_val['matri_id'],$href);
                                                    $href = $base_url.$admin_path.'/'.$href;
                                                    $count_match = $this->match_making_model->get_match_count_data($data_val);
                                                    $data_tab_btn_arr_val['label'] = $data_tab_btn_arr_val['label']." ($count_match)";
                                                }
                                                else{
                                                    $data_tab_btn_arr_val['label']='';
                                                }
                                            }
                                            else if(isset($data_tab_btn_arr_val['url']) && $data_tab_btn_arr_val['url'] !=''){
                                                $href = $data_tab_btn_arr_val['url'];
                                                $href = str_replace('#id#',$temp_id,$href);
                                                $href = $base_url.$admin_path.'/'.$href;
                                            }
                                            if(isset($data_tab_btn_arr_val['onClick']) && $data_tab_btn_arr_val['onClick'] !=''){
                                                $onClick = $data_tab_btn_arr_val['onClick'];
                                                $onClick_btn = str_replace('#id#',$temp_id,$onClick);
                                            }
                                            $target ='';
                                            if(isset($data_tab_btn_arr_val['target']) && $data_tab_btn_arr_val['target'] !=''){
                                                $target = $data_tab_btn_arr_val['target'];
                                            }
                                            
                                            if($data_tab_btn_arr_val['label'] == 'Confirm email'){
                                                if($temp_id!=''){
                                                    $row_data_count = $this->common_model->get_count_data_manual('register',array('id'=>$temp_id,'cpass_status'=>'Verify'),0,'status,cpass_status');
                                                    if($row_data_count > 0){
                                                        $data_tab_btn_arr_val['label']='';
                                                    }
                                                }
                                            }
                                            if($data_tab_btn_arr_val['label'] != ''){?>
                                            <div class="col-lg-2 col-xs-6 pull-right neMrgATop10">
                                                <a target="<?php echo $target; ?>" onClick="<?php echo $onClick_btn; ?>" class="btn btn-<?php echo $class; ?> btn-flat btn-block" href="<?php echo $href; ?>">
                                                    <?php echo $data_tab_btn_arr_val['label']; ?>
                                                </a>
                                            </div>
                                        <?php }
                                        }
                                    }?>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <div class="clearfix"></div>
                                <br/>
                                <div class="col-lg-12 col-xs-12 col-md-12">
                                    <div class="pull-left">
                                        <div id="show_record_message">
                                            <?php
                                            if(isset($this->common_model->data_tabel_filtered_count) && $this->common_model->data_tabel_filtered_count !=''){
                                                $data_tabel_filtered_count = $this->common_model->data_tabel_filtered_count;
                                                $limit_per_page = $this->common_model->limit_per_page;
                                                $start = 1;
                                                if(isset($this->common_model->start) && $this->common_model->start !=''){
                                                    $start = $this->common_model->start;
                                                    $start++;
                                                }
                                                $total_disp = $start + $limit_per_page -1;
                                                if($data_tabel_filtered_count < $total_disp){
                                                    $total_disp = $data_tabel_filtered_count;
                                                }
                                                echo 'Showing '.$start.' to '.$total_disp.' of '.$data_tabel_filtered_count.' entries';
                                                if($data_tabel_all_count > $data_tabel_filtered_count){
                                                    echo ' (filtered from '.$data_tabel_all_count.' total entries)';
                                                }
                                            }
                                            else if($data_tabel_all_count > 0){
                                                echo "Showing 0 to 0 of 0 entries (filtered from $data_tabel_all_count total entries)";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <?php if(isset($this->common_model->pagination_link) && $this->common_model->pagination_link !=''){
                                            echo $this->common_model->pagination_link;
                                        }?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <br/>
                                <?php }else{?>
                                    <div class="alert alert-danger">No Record found</div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end panel -->
        </div>
<script>
setTimeout(function(){ $("#sucss_msg").slideUp(); $("#sucss_msg").html("");}, 10000);
</script>