<div class="p_b1_in">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
			<?php if($this->session->flashdata('success_message_contact')){
                $success_message = $this->session->flashdata('success_message_contact');
                if($success_message !=''){
                    echo '<div id="mydivs" class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$success_message.'</div>';
                } 
            }?>
            <p class="Poppins-Regular f-14 color-33 l-height-28 pro_id1">
                Your opted settings for receiving alerts through emails are mentioned here. You may choose to edit the existing settings.
            </p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
        	<form  method="post" name="contact_setting" id="contact_setting">
                <div class="col-md-6 col-sm-6 col-xs-12 padding-0">
                   <div class="pricavy_s_radio">
                        <div class="radio-item new-item-search Poppins-Medium f-16 ps_1" id="p_setting1">
                            <input type="radio" id="ritemb_7" value="1" <?php if($user_data['contact_view_security']=='1'){echo "checked";}?> name="contact_view_security"  onclick="contactvisbility('1');" required>
                            <label for="ritemb_7" id="fml7" class="fr-17">Show to all paid members</label>
                        </div>
                    </div>
                </div>
                   
                <div class="col-md-6 col-sm-6 col-xs-12 padding-0">
                    <div class="pricavy_s_radio">
                        <div class="radio-item new-item-search Poppins-Medium f-16 ps_1" id="p_setting2">
                            <input type="radio" id="ritemb_8" value="0" <?php if($user_data['contact_view_security']=='0'){echo "checked";}?> name="contact_view_security" onclick="contactvisbility('0');" required>
                            <label for="ritemb_8" id="fml8" class="fr-18">Show to express interest  accepted & paid members.</label>
                           
                        </div>
                        
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />
                <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                <input type="hidden" name="is_post" id="is_post" value="1" />
			</form>
        </div>
    </div>
</div>