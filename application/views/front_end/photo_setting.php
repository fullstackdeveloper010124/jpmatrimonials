<div class="col-md-12 col-sm-12 col-xs-12">
	<?php
	if($this->session->flashdata('success_message')){
		$success_message = $this->session->flashdata('success_message');
		if($success_message !=''){
			echo '<div id="mydivs" class="alert alert-success alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$success_message.'</div>';
		}
	}?>
    <p class="Poppins-Regular f-14 color-33 l-height-28 pro_id1">
    Limit your visibility to others by selecting from three options below.You can protect your photos so that only those to whom you accepted requests can view them.
    </p>
</div>           
<div class="col-md-12 col-sm-12 col-xs-12">
   <div class="col-md-4 col-sm-4 col-xs-12 padding-0">
   <div class="pricavy_s_radio">
        <div class="radio-item new-item-search Poppins-Medium f-16 ps_1" id="p_setting1">
            <input id="ritemb" type="radio" value="0" <?php if($user_data['photo_view_status']=='0'){echo "checked";}?> name="photo_visiblity" onclick="photovisbility('0');" required>
            <label for="ritemb" id="fml" class="fr-12">Hide For All</label>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
    <div class="pricavy_s_radio">
        <div class="radio-item new-item-search Poppins-Medium f-16 ps_1" id="p_setting2">
            <input type="radio" id="ritemb2" value="2" <?php if($user_data['photo_view_status']=='2'){echo "checked";}?> name="photo_visiblity" onclick="photovisbility('2');" required>
            <label for="ritemb2" id="fml2" class="fr-13">Visible only to Paid Member</label>
        </div>
    </div>
</div>

<div class="col-md-4 col-sm-4 col-xs-12 padding-0">
    <div class="pricavy_s_radio pull-right">
        <div class="radio-item new-item-search Poppins-Medium f-16 ps_1" id="p_setting3">
            <input type="radio" id="ritemb3" value="1" <?php if($user_data['photo_view_status']=='1'){echo "checked";}?> name="photo_visiblity"  onclick="photovisbility('1');" required>
            <label for="ritemb3" id="fml3" class="fr-14">Visible to All</label>
        </div>
    </div>
</div>

<?php if($user_data['photo_view_status']=='0'){
    $display = 'style="display:block;"';
}else{
    $display = 'style="display:none;"';
}?>
<div id="set_photo_password" <?php echo $display;?>></div>