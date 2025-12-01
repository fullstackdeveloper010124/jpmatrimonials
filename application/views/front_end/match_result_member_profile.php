<?php if(!isset($member_total_count) && !isset($member_data)){
    ## New Code For Match Type : New Parameter : premium-match,near-by-me,recommended : Date : 11-10-2021
    $_POST['match_type'] = $match_type;
	$member_total_count = $this->matches_model->get_search_count();
	$member_data = $this->matches_model->get_search_result(1);
}
if(!isset($member_total_count) || $member_total_count =='')
{
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
<div class="hidden-sm hidden-xs">
<div class="row">
	<div class="col-md-4 col-sm-4 col-xs-12">
        <div class="row">
            <span class="lable-cstm-search">Match Result Found: <?php echo $member_total_count; ?></span>
        </div>
    </div>
    <div class="col-md-8 col-sm-8 col-xs-12 hidden-sm hidden-xs">
        <div class="demo-search pull-right">
            <?php 
            if(isset($member_total_count) && $member_total_count !='' && $member_total_count > $this->common_model->limit_per_page){
				if(isset($page_name) && $page_name=='matches'){
					$page_link = 'matches/search-now/';
				}
				else if(isset($page_name) && $page_name=='admin-matches'){
					$page_link = 'matches/received-match-from-admin';
				}
                echo $this->common_model->rander_pagination_front_search($page_link,$member_total_count,$this->common_model->limit_per_page);
            }else{?>
                <div class="mt-8"></div>
            <?php }?> 
        </div>
    </div>

</div>

<div class="clearfix"></div>
<?php 
if(isset($member_data) && $member_data !='' && is_array($member_data) && count($member_data) > 0){
    /*Get Plan Badges*/
    $badge = $this->common_front_model->getbadges($member_data);

	$full_profile_url = $base_url.'search/view-profile/';
	$i=0;
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
			include('page_part/web_member_details.php');
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

<div class="hidden-lg hidden-md">
    <div class="pg1">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <span class="lable-cstm-search">Match Result Found: <?php echo $member_total_count; ?></span>
            </div>
        </div>
    </div>
	<div class="clearfix"></div>
    <div class="mt-7">
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
					if(isset($page_name) && $page_name=='matches'){
						$page_link = 'matches/search-now/';
					}
					else if(isset($page_name) && $page_name=='admin-matches'){
						$page_link = 'matches/received-match-from-admin';
					}
                    echo $this->common_model->rander_pagination_front_search($page_link,$member_total_count,$this->common_model->limit_per_page);
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
</div>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
<!-- ============================  Mobile View End  ============================ -->
<?php include('page_part/front_button_popup.php');
$this->common_model->js_extra_code_fr.='
function more_details(id){
	$("#more_details_btns_"+id).fadeToggle();
}
function mob_more_details(id){
	$("#mob_more_details_btns_"+id).fadeToggle();
};';
?>