<?php 
$login_member_id = $this->common_front_model->get_session_data('matri_id');
$where_arra=array('matri_id'=>$login_member_id);
$user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'photo_protect, photo_password, photo_view_status, contact_view_security');
$tab_active1= 'active';
$tab_active_chan = '';
if(isset($tab_active) && $tab_active == 'change_password'){
	$tab_active_chan = 'in active';
	$tab_active1= '';
}
?>
<div class="contact-tab">
    <div class="container-fluid new-width">
        <div class="row">
            <div class="col-md-12">
                <div class="tab contact-tab-m block-list-tab" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs contact-tab-nav2 privacy_set_tab" role="tablist">
                        <li role="presentation" class="<?php echo $tab_active1; ?> f-17">
                            <a href="#block-list-tab" aria-controls="block-list-tab" role="tab" data-toggle="tab"> <i class="fas fa-ban"></i> Block List</a>
                        </li>
                        <li role="presentation" class="f-17">
                            <a href="#photo-visibility-tab" aria-controls="photo-visibility-tab" role="tab" data-toggle="tab"><i class="fas fa-image"></i> Photo Visibility</a>
                        </li>
                        <li role="presentation" class="f-17">
                            <a href="#contact-setting-tab" aria-controls="contact-setting-tab" role="tab" data-toggle="tab"><i class="fas fa-id-card-alt"></i> Contact Settings</a>
                        </li>
                        <li role="presentation" class="f-17 li-last <?php echo $tab_active_chan; ?>">
                            <a href="#change-password-tab" aria-controls="change-password-tab" role="tab" data-toggle="tab"><i class="fas fa-unlock-alt"></i> Change Password</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container new-width" style="width:93%;">
    <div class="row margin-zero">
        <div class="tab-content tabs">
            <div role="tabpanel" class="tab-pane fade in <?php echo $tab_active1; ?>" id="block-list-tab">
                <div class="row margin-zero">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="privacy_s_b1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Block <span class="color-d">member</span></p>
                                </div>
                            </div>
                            <div class="p_b1_in">
                                <div class="row">
                                    <!------for block member error or success message display---->  
                                    <div class="col-sm-12 col-md-12 col-xs-12">
                                    	<div class="alert alert-danger" id="block_error" style="display:none"></div>
                                    	<div class="alert alert-success" id="block_success" style="display:none"></div>
                                    </div>  
                                    <!------for block member error or success message display----> 
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <p class="Poppins-Medium f-16 color-31 pro_id1">Profile ID</p>
                                    </div>
                                    
                                    <form id="blocklist_form" name="blocklist_form" method="post">
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                                <div class="pri_s_input">
                                                    <input type="text" class="form-control ni-input" name="blockuserid" id="blockuserid" required placeholder="Enter Member Profile ID">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <button type="submit" class="dshbrd_21 Poppins-Medium f-17 color-f upload_v_submit" name="block_sub" id="block_sub"><i class="fas fa-ban ban-ff"></i>Block</button>
                                            </div>
                                        </div>
                                    	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        <input type="hidden" name="is_post" id="is_post" value="1" />
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row margin-zero">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="privacy_s_b1">
                        	<div id="main_content_ajax">
	                            <?php include_once('short_listed_member_profile.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="photo-visibility-tab">
               <div class="row margin-zero">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="privacy_s_b1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Photo
                                    <span class="color-d">Visibility</span></p>
                                </div>
                            </div>
                            <div class="p_b1_in">
                                <div class="row">
                                    <div id="photo_setting_ajax">
                                    <?php include_once('photo_setting.php');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div role="tabpanel" class="tab-pane fade" id="contact-setting-tab">
                <div class="row margin-zero">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="privacy_s_b1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Contact <span class="color-d">settings</span></p>
                                </div>
                            </div>
                            <div id="contact_setting_ajax">
								<?php include_once('contact_privacy_setting.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade <?php echo $tab_active_chan; ?>" id="change-password-tab">
                <div class="row margin-zero">
                    <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                        <div class="privacy_s_b1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Change
                                        <span class="color-d">Password</span></p>
                                </div>
                            </div>
                            <div class="p_b1_in">
                            	<form method="post" name="change_pass" id="change_pass">
                                    <!------for change password member error or success message display---->  
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 col-xs-12">
                                            <div class="alert alert-danger" id="change_pass_error" style="display:none"></div>
                                            <div class="alert alert-success" id="change_pass_success" style="display:none"></div>
                                        </div>
                                    </div>
                                    <!------for change password member error or success message display----> 
                                    <div class="row">
                                        <div class="col-md-3 col-sm-5 col-xs-12">
                                            <p class="Poppins-Medium f-16 color-31 pro_id1">Old Password:</p>
                                        </div>
                                        <div class="col-md-9 col-sm-7 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                                <div class="pri_s_input">
                                                    <input type="password" class="form-control ni-input" placeholder="Enter Old Password" id="old_pass" name="old_pass" minlength="6" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3 col-sm-5 col-xs-12">
                                            <p class="Poppins-Medium f-16 color-31 pro_id1">New Password:</p>
                                        </div>
                                        <div class="col-md-9 col-sm-7 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                                <div class="pri_s_input">
                                                    <input type="password" class="form-control ni-input" placeholder="Enter New Password" id="new_pass" name="new_pass" minlength="6" required>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-md-3 col-sm-5 col-xs-12">
                                            <p class="Poppins-Medium f-16 color-31 pro_id1">Confirm Password:</p>
                                        </div>
                                        <div class="col-md-9 col-sm-7 col-xs-12">
                                            <div class="col-md-12 col-sm-12 col-xs-12 padding-zero">
                                                <div class="pri_s_input">
                                                    <input type="password" class="form-control ni-input" placeholder="Enter Confirm Password" id="cnfm_pass" name="cnfm_pass" minlength="6" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <button type="submit" class="dshbrd_21 Poppins-Medium f-17 color-f upload_v_savechange">Save Changes</button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="hash_tocken_id" class="hash_tocken_id" />                                    <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url;?>" />
                                    <input type="hidden" name="is_post" id="is_post" value="1" />	
                            	</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->common_model->js_extra_code_fr .="
load_pagination_code_front_end();

/*$(document).ready(function () {
	$('#test').BootSideMenu({
		side: 'left',
		pushBody:false,
		width: '250px'
	});
});*/

if($('#blocklist_form').length > 0){
	$('#blocklist_form').validate({
		submitHandler: function(form){
			check_validation();
		}
	});
}
function check_validation(){	
	if($('#blockuserid').val() && $('#blockuserid').val()!=''){
		var blockuserid = $('#blockuserid').val();
	}
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'privacy-setting/block-profile';
	$('#block_success').hide();
	$('#block_error').hide();
	
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'blockuserid':blockuserid},
		dataType:'json',
		success: function(data)
		{ 	
			if(data.status == 'success'){
				$('#block_success').html(data.errmessage);
				$('#block_success').slideDown();
				$('#blockuserid').val('');
				$('#main_content_ajax').html(data.block_profile_code);
				load_pagination_code_front_end();
				scroll_to_div('main_content_ajax');
				update_tocken($('#hash_tocken_id_temp').val());					
				$('#hash_tocken_id_temp').remove();
				setTimeout(function() {
					$('#block_success').fadeOut('fast');
				}, 10000);
			}
			else{
				$('#block_error').html(data.errmessage);
				$('#block_error').slideDown();
				setTimeout(function() {
					$('#block_error').fadeOut('fast');
				}, 10000);
			}
			$('#hash_tocken_id').val(data.token);
			hide_comm_mask();
		}
	});
	return false;
}

function unblock_particulare(id,matri_id)
{
	$('#unblock_id').val(id);
	$('#matri_id').val(matri_id);
	setTimeout(function() {
		$('#unblock_success').fadeOut('fast');
	}, 10000);
}

<!-------------------------start for photo visiblity------------------------->			
function check_validation_photo()
{				
	if($('#photo_password').val() && $('#photo_password').val()!='')
	{
		var photo_password = $('#photo_password').val();
	}			
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'privacy-setting/photo-visibility';
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'photo_password':photo_password},
		dataType:'json',
		success: function(data)
		{ 	
			if(data.status == 'success')
			{	
				$('#photo_setting_ajax').html(data.photo_setting_load);
				update_tocken($('#hash_tocken_id_temp').val());					
				$('#hash_tocken_id_temp').remove();
				setTimeout(function() {
					$('#mydivs').fadeOut('fast');
				}, 10000);
			}
			$('#hash_tocken_id').val(data.token);
			hide_comm_mask();	
		}
	});
	return false;
}
function removephotopass()
{
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'privacy-setting/remove-photo-visibility';
	$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id},
			dataType:'json',
			success: function(data)
			{ 	
				if(data.status == 'success')
				{	
					$('#photo_setting_ajax').html(data.photo_setting_load);
					update_tocken($('#hash_tocken_id_temp').val());					
					$('#hash_tocken_id_temp').remove();
					setTimeout(function() {
						$('#mydivs').fadeOut('fast');
					}, 10000);
				}
				$('#hash_tocken_id').val(data.token);
				hide_comm_mask();	
			}
	});
	return false;
}		
function photovisbility(pval)
{	
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'privacy-setting/photo-view-status';
	$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'photo_view_status':pval},
			dataType:'json',
			success: function(data)
			{ 	
				if(data.status == 'success')
				{
					$('#photo_setting_ajax').html(data.photo_setting_load);
					setTimeout(function() {
						$('#mydivs').fadeOut('fast');
					}, 10000);
					update_tocken($('#hash_tocken_id_temp').val());					
					$('#hash_tocken_id_temp').remove();
				}
				$('#hash_tocken_id').val(data.token);
				hide_comm_mask();	
			}
	});
	return false;
}
<!-----------------------stop for photo visiblity and start for contact setting----------------------->
function contactvisbility(cval)
{	
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'privacy-setting/contact-privacy-setting';
	$.ajax({
			url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'contact_view_security':cval},
			dataType:'json',
			success: function(data)
			{ 	
				if(data.status == 'success')
				{
					$('#contact_setting_ajax').html(data.contact_setting_load);
					setTimeout(function() {
						$('#mydivs').fadeOut('fast');
					}, 10000);
					update_tocken($('#hash_tocken_id_temp').val());					
					$('#hash_tocken_id_temp').remove();
				}
				$('#hash_tocken_id').val(data.token);
				hide_comm_mask();	
			}
	});
	return false;
}
<!------------------------------stop for contact setting and start for change password----------------------->
	
if($('#change_pass').length > 0)
{
	$('#change_pass').validate({
		rules: 
		{
			cnfm_pass:
			{
				equalTo:'#new_pass'
			},
		},
		submitHandler: function(form)
		{
			check_validation_password();
		}
	});
}
	
function check_validation_password()
{	
	var old_pass = $('#old_pass').val();
	var new_pass = $('#new_pass').val();
	var cnfm_pass = $('#cnfm_pass').val();
	show_comm_mask();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	$('#change_pass_success').hide();
	$('#change_pass_error').hide();
	
	var url = base_url+'privacy-setting/change-password';
	$.ajax({
		url: url,
		type: 'POST',
		data:{'csrf_new_matrimonial':hash_tocken_id,'old_pass':old_pass,'new_pass':new_pass,'cnfm_pass':cnfm_pass},
		dataType:'json',
		success: function(data)
		{ 	
			if(data.status == 'success')
			{
				$('#change_pass_success').html(data.errmessage);
				$('#change_pass_success').slideDown();
				update_tocken($('#hash_tocken_id_temp').val());					
				$('#hash_tocken_id_temp').remove();
				form_reset('change_pass');
				setTimeout(function() {
					$('#change_pass_success').fadeOut('fast');
				}, 10000);
			}
			else
			{
				$('#change_pass_error').html(data.errmessage);
				$('#change_pass_error').slideDown();
				setTimeout(function() {
					$('#change_pass_error').fadeOut('fast');
				}, 10000);
			}
			$('#hash_tocken_id').val(data.token);
			hide_comm_mask();	
		}
	});
	return false;
};";
?>