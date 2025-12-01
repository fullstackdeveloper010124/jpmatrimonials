<?php  $id_member = $this->common_front_model->get_session_data();
$id_member = $this->common_front_model->get_session_data('id'); 
$member_matri_id = $this->common_front_model->get_session_data('matri_id');
if(isset($id_member) && $id_member !='')
{
	// need to work for display saved search for user
	$where_arra=array('matri_id'=>$member_matri_id);
	$save_search_data = $this->common_model->get_count_data_manual('save_search',$where_arra,2,'*','id desc',1,3);
	/*echo "<pre>";
	print_r($data);
	echo "</pre>";*/	
	if(isset($save_search_data) && $save_search_data!='' && is_array($save_search_data) && count($save_search_data)>0)
	{	
?>
<div class="xxl-4 xl-4 m-16 l-4 xs-16 s-16 compltele-profile margin-top-10" style="padding-top:0px;padding-bottom:0px;">
    <div class="row" style="padding:4px;">
        <h3 class="upgrade-heading" style="margin:0px;">
            <i class="fa fa-save ne_mrg_ri8_10 ne_font_18"></i>
            <span class="ne_mrg_ri8_10">Recent Saved Searches</span>
            </h3>
        
        <div class="collapse in">
            <ul class="upgrade_benfits">
				<?php foreach($save_search_data as $data)
                {?>
                   <li class="no-arrow">
				   <a class="font padding-lr-zero text_slider"><?php if(isset($data['search_name'])){echo $data['search_name'];}else{echo "N/A";}?></a><br/>
                   <i class="fa fa-calendar"></i>&nbsp;&nbsp;&nbsp;<?php echo $data['created_on'];?><br/>
                        <a href="<?php echo $base_url; ?>search/saved_search_now/<?php echo $data['id'];?>" class="underline text_slider">Search Now</a> <img src="<?php echo $base_url; ?>assets/front_end/images/icon/right-gray-arrow.png" class="right-gray-arrow" alt="view-arrow" />
                	</li>
            	<?php }?>
            </ul>
        </div>										
    </div>
</div>
<?php
	}
}
if(!isset($this->common_model->id_search)){?>
<div class="xxl-4 xl-4 m-16 l-4 xs-16 s-16 compltele-profile margin-top-15" style="padding-top:0px;padding-bottom:0px;">
    <div class="row" style="padding:4px;">
        <h3 class="upgrade-heading" style="margin:0px;">
            <i class="fa fa-user ne_mrg_ri8_10 ne_font_18"></i>
            <span class="ne_mrg_ri8_10">Profile ID Search</span>
        </h3>
        <div class="collapse in">
            <form action="<?php echo $base_url; ?>search/search_now" method="post">
                <div class="sear_form form-group xxl-16 xl-16 m-16 l-16 xs-16 s-16">
                    <div class="row xxl-13 xl-13 m-14 l-14 xs-14 s-14 margin-top-5">
                        <input required type="text" name="txt_id_search" placeholder="Enter Profile ID" class="form-control input-border" />
                    </div>
                    <div class="xxl-3 xl-3 m-3 l-3 xs-16 s-3 margin-top-2">
                        <button class="btn btn-sm" type="submit"><span class="hidden-xs">Go</span> <span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-arrow-right"></i></span></button>
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
                    </div>
                </div>
        	</form>
        </div>										
    </div>
</div>
<?php }?>
<div class="xxl-4 xl-4 m-16 l-4 xs-16 s-16 compltele-profile hidden-xs margin-top-15 margin-bottom-15" style="padding:4px;">
    <?php $this->load->view('front_end/sidebar_advertisement'); ?>
    <?php $this->load->view('front_end/member_feature_slider_in_sidebar'); ?>
</div>