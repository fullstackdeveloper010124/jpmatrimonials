<?php
if(!isset($member_total_count) || $member_total_count ==''){
	$member_total_count = 0;
}
$member_id = $this->common_front_model->get_session_data('matri_id');

$comm_model = $this->common_model;
$gender = $this->common_front_model->get_session_data('gender');
if(isset($gender) && $gender == 'Male'){
	$photopassword_image = $base_url.'assets/images/photopassword_female.png';
}else{
	$photopassword_image = $base_url.'assets/images/photopassword_male.png';
}
?>
<!-- ============================ Desktop View Start ============================ -->
<div class="col-md-9 col-sm-9 col-xs-12 hidden-sm hidden-xs">
<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12">
        <div class="row">
            <span class="lable-cstm-search"><?php echo $member_total_count; ?> Matches</span>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12 hidden-sm hidden-xs">
        <div class="demo-search mt-5 pull-right">
            <div id="btnContainer">
                <button class="btn btnlist" ><i class="fa fa-bars"></i> List</button> 
                <button class="btn btngrid" ><i class="fa fa-th-large"></i> Grid</button>
            </div>
            <?php 
            if(isset($member_total_count) && $member_total_count !='' && $member_total_count > $this->common_model->limit_per_page){
                echo $this->common_model->rander_pagination_front_search('search/result',$member_total_count,$this->common_model->limit_per_page);
            }else{?>
         
            <?php }?> 
        </div>

        
    </div>
</div>

<div class="clearfix"></div>
<?php 
if(isset($member_data) && $member_data !='' && is_array($member_data) && count($member_data) > 0){
	$full_profile_url = $base_url.'search/view-profile/';
	$i=0;
    
    /*Get Plan Badges*/
    $badge = $this->common_front_model->getbadges($member_data);
    
	foreach($member_data as $member_data_val){
		if($member_data_val =='' || count($member_data_val)==0){
			continue;
		}
		$full_profile_url_finale = $full_profile_url.$member_data_val['matri_id'];
		$result_member_matri_id = $member_data_val['matri_id'];
		$mt = '';
		if($i!=0){
			$mt = 'mt-5';
		}
        echo "<div class='divlistview mt-4' >";
		    include('page_part/web_member_details.php');
        echo "</div>";
        echo "<div class='divgridview mt-4' style='display:none;'>";
            include('page_part/web_member_details_grid_view.php');
        echo "</div>";
            
		$i++;}
	}else{?>
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="no-data-f">
                   <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                   <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                </div>
            </div>
        </div>
	<?php }?>
</div>
<!-- ============================  Desktop View End ============================ -->

<!-- ============================ Mobile View Start ============================  -->

<div class="col-md-9 col-sm-9 col-xs-12 hidden-lg hidden-md">
    <div class="pg1">
        <div class="col-md-4 col-sm-4 col-xs-6">
            <div class="row">
                <span class="lable-cstm-search"><?php echo $member_total_count; ?> Matches</span>
            </div>
        </div>
		<?php $search_order = 'latest_first';
        if(isset($_REQUEST['search_order']) && $_REQUEST['search_order'] !=''){
            $search_order = $_REQUEST['search_order'];
        }?>
        <div class="col-md-8 col-sm-8 col-xs-6 hidden-lg hidden-md">
            <select class="form-control select-cust" style="height:35px;margin-top: 20px;" name="search_order" id="search_order_mob" onChange="change_sort_mob()">
                <option <?php if(isset($search_order) && $search_order=='latest_first'){echo 'selected';}?> value="latest_first" class="color-30">Latest First</option>
                <option <?php if(isset($search_order) && $search_order=='latest_last'){echo 'selected';}?> value="latest_last" class="color-65">Oldest First</option>
                <option <?php if(isset($search_order) && $search_order=='last_login_first'){echo 'selected';}?> value="last_login_first" class="color-65">Latest Login First</option>
                <option <?php if(isset($search_order) && $search_order=='last_login_last'){echo 'selected';}?> value="last_login_last" class="color-65">Last Login First</option>
            </select>
        </div>
    </div>
	<div class="clearfix"></div>
<?php 
if(isset($member_data) && $member_data !='' && is_array($member_data) && count($member_data) > 0){
	$full_profile_url = $base_url.'search/view-profile/';
	foreach($member_data as $member_data_val){
		if($member_data_val =='' || count($member_data_val)==0){
			continue;
		}
		$full_profile_url_finale = $full_profile_url.$member_data_val['matri_id'];
		$result_member_matri_id = $member_data_val['matri_id'];
        include('page_part/mob_member_details.php');
    }
	?>
    <div class="demo-search">
        <?php 
        if(isset($member_total_count) && $member_total_count !='' && $member_total_count > $this->common_model->limit_per_page){
            echo $this->common_model->rander_pagination_front_search('search/result',$member_total_count,$this->common_model->limit_per_page);
        }else{?>
            <div class="mt-8"></div>
        <?php }?> 
    </div>
    <?php
}else{?>
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="no-data-f">
               <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
               <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
            </div>
        </div>
    </div>
<?php }?>
</div>
<!-- ============================  Mobile View End  ============================ -->
<?php include('page_part/front_button_popup.php');
include('page_part/search_popup.php');
$this->common_model->js_extra_code_fr.='
function more_details(id){
	$("#more_details_btns_"+id).fadeToggle();
}
function mob_more_details(id){
	$("#mob_more_details_btns_"+id).fadeToggle();
};
load_pagination_code_front_end();    
';
?>



