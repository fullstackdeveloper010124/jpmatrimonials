<!------------------<div class="container">----Start------------------------------>	
    <div class="container padding-0-5-xs">
    <div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-320 padding-lr-zero-480 padding-lr-zero-768 margin-top-20 padding-0-5-xs" style="padding-right:0px;">
        <div class="xxl-4 xl-4 xs-16 m-4 s-16 l-4">
            <?php $this->load->view('front_end/my_profile_sidebar'); ?>
        </div>
        <div class="xs-16 s-16 xl-12 xxl-12 m-12 l-12 padding-lr-zero-320 padding-lr-zero-480">
				<div class="ne_pad_btm_10px padding-lr-zero-320 padding-lr-zero-480" style="margin-top: -20px;">
					<div class="xxl-16 xl-16 s-16 m-16 l-16 xs-16 ne-bdr-btm-lgt-grey ne_pad_btm_10px bg-border margin-top-20">
						<div class="">
							<a href="javascript:;" onClick="scroll_to_div('basic-detail')" class="xxl-5 xl-5 l-5 xs-16 s-16 m-16 btn font-weight-bold pull-left text-white margin-right-10 margin-bottom-0px margin-top-0px">
								<span class="sticker_edit"></span> Edit Personal Profile
							</a>
							<a href="javascript:;" onClick="scroll_to_div('partner_prefrence')" class="xxl-6 xl-6 l-6 xs-16 s-16 m-16 btn btn-success font-weight-bold pull-left text-white margin-right-10 margin-top-0px margin-top-10" style="background:#DD4C3F !important;">
								<span class="sticker_edit hidden-xs"></span> Edit Partner Preferences
							</a>
							<a href="<?php echo $base_url.'my-profile'; ?>" class="pull-right text-decoration-none xxl-4 xl-4 s-16 m-16 l-4 xs-16 right-text margin-top-10">
								<span class="ne_mrg_ri8_10">View Profile</span><i class="fa fa-caret-right"></i>
							</a>
						</div>
					</div>
					<div class="clearfix"></div>
					<div id="basic-detail" class="bg-border margin-top-20" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list1" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('1_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-file ne_mrg_ri8_10"></i>Edit Basic Detail
									<span class="collapse-minus-nomargin" id="img_1_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
						
                        <form method="post" id="ne_lft_pan_list1" class="collapse in basic-detail" name="ne_lft_pan_list1" action="<?php echo $base_url; ?>my-profile/save-profile/basic-detail" onSubmit="return validat_function('ne_lft_pan_list1')">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
						<div class="margin-top-10px"></div>
                        <div id="reponse_ne_lft_pan_list1"></div>
                        <div class="margin-top-10px"></div>
							<?php
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
									$mother_tongue_arr = $this->common_model->dropdown_array_table('mothertongue');
									$religion_arr = $this->common_model->dropdown_array_table('religion');
									$education_name_arr = $this->common_model->dropdown_array_table('education_detail');
									$occupation_arr = $this->common_model->dropdown_array_table('occupation');
									$designation_arr = $this->common_model->dropdown_array_table('designation');
									$country_arr = $this->common_model->dropdown_array_table('country_master');
									
									$mobile = $row_data['mobile'];
									$birth_date = $row_data['birthdate'];
									if($mobile !='')
									{
										$mobile_arr = explode('-',$mobile);
										if(isset($mobile_arr) && count($mobile_arr) == 2 )
										{
											$current_count_code = $mobile_arr[0];
											$mobile_val = $mobile_arr[1];
										}
										else
										{
											$mobile_val = $mobile_arr[0];
										}
									}
									
									$birth_ddr_str = $this->common_model->birth_date_picker($birth_date);
									$birth_date_str = '<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs"><label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px profile-label">Date of Birth</label><div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
										  '.$birth_ddr_str.'
										  </div></div>';
								}
								 $ele_array = array(
									'firstname'=>array('is_required'=>'required','label'=>'First Name'),
									'lastname'=>array('is_required'=>'required','label'=>'Last Name'),
									'marital_status'=>array('is_required'=>'required','type'=>'radio','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'value'=>'Unmarried'),
									'mother_tongue'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Mother Tongue'),
									'languages_known'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Language Known'),
									/*'birthdate'=>array('is_required'=>'required','label'=>'Date of Birth','input_type'=>'date'),*/
									'birthdate'=>array('type'=>'manual','code'=>$birth_date_str),
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
									<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                        <button onClick="return validat_function('ne_lft_pan_list1')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					</div>
					<div class="clearfix"></div>
					
					<!-----------------------Life style and appearance------------->
				
					<div id="life-style-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
                        <div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list15" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('15_profile')" style="padding:4px 0px;">
                            <h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
                                <a href="javascript:;" class="text-white">
                                    <i class="fa fa-university ne_mrg_ri8_10"></i>Edit Life Style Information
                                    <span class="collapse-plus-nomargin" id="img_15_profile" </span>
                                </a>
                            </h3>
                        </div>
                        <div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
                        <div class="clearfix"></div>
                         <div id="reponse_ne_lft_pan_list15"></div>	
                         <form id="ne_lft_pan_list15" name="ne_lft_pan_list15" action="<?php echo $base_url; ?>my-profile/save-profile/life-style-detail" onSubmit="return validat_function('ne_lft_pan_list15')" class="collapse margin-top-10 life-style-detail">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            
                            <?php
                                    $member_id = $this->common_front_model->get_session_data('id');
                                    if(isset($member_id) && $member_id != '' )
                                    {
                                        $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                        $this->common_front_model->edit_row_data = $row_data;
                                        $this->common_model->edit_row_data = $row_data;
                                        $this->common_model->mode= 'edit';
                                        $this->common_front_model->mode= 'edit';
                                    }
                                    $ele_array = array(
                                        'bodytype'=>array('type'=>'dropdown','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Body Type','extra_style'=>'width:100%'),
										
										'diet'=>array('type'=>'dropdown','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Eating Habbit','extra_style'=>'width:100%'),
										 
										'smoke'=>array('type'=>'dropdown','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Smoke Habbit','extra_style'=>'width:100%'),
										
										'drink'=>array('type'=>'dropdown','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Drink Habbit','extra_style'=>'width:100%'),
										
										'complexion'=>array('type'=>'dropdown','display_placeholder'=>'No','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Skin Tone','extra_style'=>'width:100%'),
										
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
                            <div class="clearfix"></div>
                                <hr>
                                <div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
                                    <div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                        <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                            <button onClick="return validat_function('ne_lft_pan_list15')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
                                        </div>								</div>
                                </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
				
				
				<!-----------------------Life style and appearance------------->
					
					<div id="about-me-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list2" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('2_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-user ne_mrg_ri8_10"></i>Edit About Me & Hobby
									<span class="collapse-plus-nomargin" id="img_2_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
                         <div id="reponse_ne_lft_pan_list2"></div>
                        
                        <form id="ne_lft_pan_list2" name="ne_lft_pan_list2" action="<?php echo $base_url; ?>my-profile/save-profile/about-me-detail" onSubmit="return validat_function('ne_lft_pan_list2')" class="collapse margin-top-10 about-me-detail">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                        
                        <?php
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
								}
								$ele_array = array(
               					'profile_text'=>array('type'=>'textarea','label'=>'About Me'),
								'hobby'=>array('type'=>'textarea'),
								'birthplace'=>array('label'=>'Birth Place'),
            					'birthtime'=>array('label'=>'Birth Time'),
           						'profileby'=>array('is_required'=>'required','type'=>'dropdown','class'=>'select2','value_arr'=>$this->common_model->get_list_ddr('profileby'),'label'=>'Profile By','extra_style'=>'width:100%'),
          						 'reference'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('reference'),'extra_style'=>'width:100%'),
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
						?>
							
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                        <button onClick="return validat_function('ne_lft_pan_list2')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								
									<!--<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center margin-top-10-xs">
										<a class="btn btn-danger ne-cursor"><i class="fa fa-close font-16"></i> Cancel</a>
									</div>-->
								</div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="clearfix"></div>
					
					<div id="religious-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list3" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('3_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-book ne_mrg_ri8_10"></i>Edit Religious Information
									<span class="collapse-plus-nomargin" id="img_3_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
						<div id="reponse_ne_lft_pan_list3"></div>
                        <form id="ne_lft_pan_list3" name="ne_lft_pan_list3" action="<?php echo $base_url; ?>my-profile/save-profile/religious-detail" onSubmit="return validat_function('ne_lft_pan_list3')" class="collapse margin-top-10 religious-detail">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                        
                        <?php
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
								}
								$ele_array = array(
               						'religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('religion','caste','caste_list')",'value_arr'=>$religion_arr,'extra_style'=>'width:100%'),
           							'caste'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','rel_col_name'=>'religion_id','not_load_add'=>'yes','not_load_add'=>'yes','cus_rel_col_val'=>'religion'),'extra_style'=>'width:100%'),
            						'subcaste'=>array('label'=>'Sub Caste'),
           							'manglik'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('manglik'),'extra_style'=>'width:100%'),
            						'star'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('star'),'extra_style'=>'width:100%'),
            						'horoscope'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('horoscope'),'extra_style'=>'width:100%'),
           							'gothra'=>array('label'=>'Gothra'),
            						'moonsign'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('moonsign'),'extra_style'=>'width:100%'),
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
						?>
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
									<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
										  <button onClick="return validat_function('ne_lft_pan_list3')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="clearfix"></div>
					
					<div id="residence-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list4" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('4_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-map-marker ne_mrg_ri8_10"></i>Edit Location Information
									<span class="collapse-plus-nomargin" id="img_4_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
						<div id="reponse_ne_lft_pan_list4"></div>
                        <form id="ne_lft_pan_list4" name="ne_lft_pan_list4" action="<?php echo $base_url; ?>my-profile/save-profile/residence-detail" onSubmit="return validat_function('ne_lft_pan_list4')" class="collapse margin-top-10 residence-detail">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                        
                        <?php		
								$mobile_val = '';
								$current_count_code = '+91';
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
									
									$mobile = $row_data['mobile'];
									if($mobile !='')
									{
										$mobile_arr = explode('-',$mobile);
										if(isset($mobile_arr) && count($mobile_arr) == 2 )
										{
											$current_count_code = $mobile_arr[0];
											$mobile_val = $mobile_arr[1];
										}
										else
										{
											$mobile_val = $mobile_arr[0];
										}
									}
									$where_country_code= " ( is_deleted ='No' )";
									$country_code_arr = $this->common_model->get_count_data_manual('country_master',$where_country_code,2,'country_code,country_name','','','',"");
									$mobile_ddr= '<div class="col-sm-5 col-lg-5 pl0">
									<select name="country_code" id="country_code" required class="form-control select2" style="width:100%;">
									<option value="">Select Country Code</option>';
										foreach($country_code_arr as $country_code_arr)
										{	
											$select_ed_drp = '';
											if($country_code_arr['country_code'] == $current_count_code)
											{
												$select_ed_drp = 'selected';
											}
											$mobile_ddr.= '<option '.$select_ed_drp.' value='.$country_code_arr['country_code'].'>'.$country_code_arr['country_code'].' ('.$country_code_arr['country_name'].')'.'</option>';
										}
										$mobile_ddr.='</select>
										</div>
										<div class="col-sm-7 col-lg-7">
											<input type="number"  minlength="8"  maxlength="12" required name="mobile_num" id="mobile_num" class="form-control" placeholder="Mobile Number" value ="'.$mobile_val.'" />
										</div>';
										
								}	
									
								$ele_array = array(
									'country_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Country','class'=>'select2','onchange'=>"dropdownChange('country_id','state_id','state_list')",'extra_style'=>'width:100%'),
									'state_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id',),'label'=>'State','class'=>'select2','onchange'=>"dropdownChange('state_id','city','city_list')",'extra_style'=>'width:100%'),
									'city'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id'),'label'=>'City','class'=>'select2','extra_style'=>'width:100%'),
									'address'=>array('type'=>'textarea'),
									'mobile'=>array('type'=>'manual','code'=>'
									<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs"">
									  <label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px profile-label">Mobile</label>
									  <div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">
									  '.$mobile_ddr.'
									  <input type="hidden" name="mobile" id="mobile" value="" />
									  </div>
									</div>'),
									'phone'=>array('extra_style'=>'width:100%'),
									'time_to_call'=>array('extra_style'=>'width:100%'),
									'residence'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'extra_style'=>'width:100%')
								);

								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
						?>
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
									<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
										  <button onClick="return validat_function('ne_lft_pan_list4')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="clearfix"></div>
					
					<div id="education-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list5" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('5_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-university ne_mrg_ri8_10"></i>Edit Education / Profession Info<span class="hidden-xs">rmation</span>
									<span class="collapse-plus-nomargin" id="img_5_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
					
                        <div id="reponse_ne_lft_pan_list5"></div>
                        <form id="ne_lft_pan_list5" name="ne_lft_pan_list5" action="<?php echo $base_url; ?>my-profile/save-profile/education-detail" onSubmit="return validat_function('ne_lft_pan_list5')" class="collapse margin-top-10 education-detail">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                        
                        <?php
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
								}
								$ele_array = array(
               						 'education_detail'=>array('is_required'=>'required','type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Education','extra_style'=>'width:100%'),
									'employee_in'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'extra_style'=>'width:100%'),
									'income'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Annual Income','extra_style'=>'width:100%'),
									'occupation'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$occupation_arr,'label'=>'Occupation','class'=>'select2','extra_style'=>'width:100%'),
									'designation'=>array('type'=>'dropdown','class'=>'select2','value_arr'=>$designation_arr,'extra_style'=>'width:100%')
								);
								echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
						?>
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
									<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
										  <button onClick="return validat_function('ne_lft_pan_list5')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
						</form>
					</div>
					<div class="clearfix"></div>
					
					<div id="family-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
						<div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list6" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('6_profile')" style="padding:4px 0px;">
							<h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
								<a href="#" class="text-white">
									<i class="fa fa-users ne_mrg_ri8_10"></i>Edit Family Details
									<span class="collapse-plus-nomargin" id="img_6_profile" </span>
								</a>
							</h3>
						</div>
						<div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
						<div class="clearfix"></div>
						<div id="reponse_ne_lft_pan_list6"></div>
                        <form id="ne_lft_pan_list6" name="ne_lft_pan_list6" action="<?php echo $base_url; ?>my-profile/save-profile/family-detail" onSubmit="return validat_function('ne_lft_pan_list6')" class="collapse margin-top-10 family-detail">
                         <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                        <input type="hidden" name="is_post" value="1" />
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                        
                        <?php
								$member_id = $this->common_front_model->get_session_data('id');
								if(isset($member_id) && $member_id != '' )
								{
									$row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
									$this->common_front_model->edit_row_data = $row_data;
									$this->common_model->edit_row_data = $row_data;
									$this->common_model->mode= 'edit';
									$this->common_front_model->mode= 'edit';
								}
								$ele_array = array(
               						'family_type'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('family_type'),'extra_style'=>'width:100%'),
									'father_name'=>array('extra_style'=>'width:100%'),
									'father_occupation'=>array('lable'=>"Father's Occupation",'extra_style'=>'width:100%'),
									'mother_name'=>array('extra_style'=>'width:100%'),
									'mother_occupation'=>array('lable'=>"Mother's Occupation",'extra_style'=>'width:100%'),
									'family_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('family_status'),'extra_style'=>'width:100%'),            
									'no_of_brothers'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'extra_style'=>'width:100%'),
									'no_of_married_brother'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('no_marri_brother'),'extra_style'=>'width:100%'),
									'no_of_sisters'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('no_of_brothers'),'extra_style'=>'width:100%'),
									'no_of_married_sister'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('no_marri_sister'),'extra_style'=>'width:100%'),
									'family_details'=>array('type'=>'textarea','extra_style'=>'width:100%','label'=>'About My Family')
								);
									echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
						?>
							<div class="clearfix"></div>
							<hr>
							<div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
								<div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
									<div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
										  <button onClick="return validat_function('ne_lft_pan_list6')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
									</div>
								</div>
							</div>
						<div class="clearfix"></div>
						</form>
					</div>
                    <div class="clearfix"><br/></div>
                    <div class="clearfix"><br/></div>
                    
				
					<div class="row" id="partner_prefrence">
						<h3 class="font-weight-normal margin-bottom-0px margin-top-0px xxl-12 xl-12 s-16 m-16 l-12 xs-16">
							Edit Partners Preferences
						</h3>
						<a href="<?php echo $base_url.'my-profile'; ?>" class="text-decoration-none xxl-4 xl-4 s-16 m-16 l-4 xs-16 right-text">
							<span class="ne_mrg_ri8_10">View Profile</span><i class="fa fa-caret-right"></i>
						</a>
					</div>				
                    <div class="clearfix"></div>
                    <div class="ne_pad_btm_10px padding-lr-zero-320 padding-lr-zero-480">
                        <div id="part-basic-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
                            <div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list7" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('7_profile')" style="padding:4px 0px;">
                                <h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
                                    <a href="#" class="text-white">
                                        <i class="fa fa-file ne_mrg_ri8_10"></i>Edit Basic Preferences
                                        <span class="collapse-plus-nomargin" id="img_7_profile" </span>
                                    </a>
                                </h3>
                            </div>
                            <div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
                            <div class="clearfix"></div>
                             <div id="reponse_ne_lft_pan_list7"></div>
                             <form id="ne_lft_pan_list7" name="ne_lft_pan_list7" action="<?php echo $base_url; ?>my-profile/save-profile/part-basic-detail" onSubmit="return validat_function('ne_lft_pan_list7')" class="collapse margin-top-10 part-basic-detail">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            
                            <?php
                                    $member_id = $this->common_front_model->get_session_data('id');
                                    if(isset($member_id) && $member_id != '' )
                                    {
                                        $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                        $this->common_front_model->edit_row_data = $row_data;
                                        $this->common_model->edit_row_data = $row_data;
                                        $this->common_model->mode= 'edit';
                                        $this->common_front_model->mode= 'edit';
                                    }
                                    $ele_array = array(
                                        'looking_for'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('marital_status'),'label'=>'Looking For','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_complexion'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('complexion'),'label'=>'Partner Complexion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_frm_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner From Age",'class'=>'select2','extra_style'=>'width:100%'),
                                        'part_to_age'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->age_rang(),'label'=>"Partner To Age",'class'=>'select2','extra_style'=>'width:100%'),
                                        'part_height'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner From Height",'class'=>'select2','extra_style'=>'width:100%'),
                                        'part_height_to'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->height_list(),'label'=>"Partner To Height",'class'=>'select2','extra_style'=>'width:100%'),
                                        'part_bodytype'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('bodytype'),'label'=>'Partner Body type','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_diet'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('diet'),'label'=>'Partner Eating Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_smoke'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('smoke'),'label'=>'Partner Smoking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_drink'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('drink'),'label'=>'Partner Drinking Habit','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_mother_tongue'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$mother_tongue_arr,'label'=>'Partner Mothertongue','extra_style'=>'width:100%'),
                                        
                                        'part_expect'=>array('type'=>'textarea','label'=>'Expectations','extra_style'=>'width:100%')
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
                            
                            <div class="clearfix"></div>
                            <hr>
                            <div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
                                <div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                    <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                              <button onClick="return validat_function('ne_lft_pan_list7')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
                                        </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div id="part-religious-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
                        <div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list8" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('8_profile')" style="padding:4px 0px;">
                            <h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
                                <a href="#" class="text-white">
                                    <i class="fa fa-book ne_mrg_ri8_10"></i>Edit Religious Preferences
                                    <span class="collapse-plus-nomargin" id="img_8_profile" </span>
                                </a>
                            </h3>
                        </div>
                        <div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
                        <div class="clearfix"></div>
                        <div id="reponse_ne_lft_pan_list8"></div>
                             <form id="ne_lft_pan_list8" name="ne_lft_pan_list8" action="<?php echo $base_url; ?>my-profile/save-profile/part-religious-detail" onSubmit="return validat_function('ne_lft_pan_list8')" class="collapse margin-top-10 part-religious-detail">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            
                            <?php
                                    $member_id = $this->common_front_model->get_session_data('id');
                                    if(isset($member_id) && $member_id != '' )
                                    {
                                        $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                        $this->common_front_model->edit_row_data = $row_data;
                                        $this->common_model->edit_row_data = $row_data;
                                        $this->common_model->mode= 'edit';
                                        $this->common_front_model->mode= 'edit';
                                    }
                                    $ele_array = array(
                                        'part_religion'=>array('is_required'=>'required','type'=>'dropdown','onchange'=>"dropdownChange('part_religion','part_caste','caste_list')",'value_arr'=>$religion_arr,'label'=>'Partner Religion','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_caste'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'caste','key_val'=>'id','key_disp'=>'caste_name','not_load_add'=>'yes','rel_col_name'=>'religion_id','cus_rel_col_val'=>'part_religion'),'label'=>'Partner Caste','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_manglik'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('manglik'),'label'=>'Partner Manglik','extra_style'=>'width:100%'),
                                        'part_star'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('star'),'label'=>'Partner Star','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%')
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
                            <div class="clearfix"></div>
                                <hr>
                                <div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
                                    <div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                        <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                              <button onClick="return validat_function('ne_lft_pan_list8')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    
                    <div id="part-location-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
                        <div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list9" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('9_profile')" style="padding:4px 0px;">
                            <h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
                                <a href="#" class="text-white">
                                    <i class="fa fa-map-marker ne_mrg_ri8_10"></i>Edit Location Preferences
                                    <span class="collapse-plus-nomargin" id="img_9_profile" </span>
                                </a>
                            </h3>
                        </div>
                        <div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
                        <div class="clearfix"></div>
                          <div id="reponse_ne_lft_pan_list9"></div>	
                         <form id="ne_lft_pan_list9" name="ne_lft_pan_list9" action="<?php echo $base_url; ?>my-profile/save-profile/part-location-detail" onSubmit="return validat_function('ne_lft_pan_list9')" class="collapse margin-top-10 part-location-detail">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            
                            <?php
                                    $member_id = $this->common_front_model->get_session_data('id');
                                    if(isset($member_id) && $member_id != '' )
                                    {
                                        $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                        $this->common_front_model->edit_row_data = $row_data;
                                        $this->common_model->edit_row_data = $row_data;
                                        $this->common_model->mode= 'edit';
                                        $this->common_front_model->mode= 'edit';
                                    }
                                    $ele_array = array(
                                         'part_country_living'=>array('type'=>'dropdown','value_arr'=>$country_arr,'label'=>'Partner Country','onchange'=>"dropdownChange('part_country_living','part_state','state_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_state'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id','cus_rel_col_val'=>'part_country_living'),'label'=>'State','onchange'=>"dropdownChange('part_state','part_city','city_list')",'is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','label'=>'Partner State','extra_style'=>'width:100%'),
                                        'part_city'=>array('type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id','cus_rel_col_val'=>'part_state'),'label'=>'Partner City','class'=>'select2','is_multiple'=>'yes','display_placeholder'=>'No','extra_style'=>'width:100%'),
                                        
                                        'part_resi_status'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('residence'),'label'=>'Partner Residence Status','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','extra_style'=>'width:100%')
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
                    
                            <div class="clearfix"></div>
                                <hr>
                                <div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
                                    <div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                        <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                              <button onClick="return validat_function('ne_lft_pan_list9')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                
                    <div id="part-education-detail" class="margin-top-20 bg-border" style="padding-top:0px;">
                        <div class="row padding-0-xs" data-toggle="collapse" href="#ne_lft_pan_list10" role="" aria-expanded="false" aria-controls="ne_lft_pan_list1" onclick="change_img('10_profile')" style="padding:4px 0px;">
                            <h3 class="font-16-bold-arial title-bg-noradius margin-top-5-xs" style="margin-top:0px;">
                                <a href="#" class="text-white">
                                    <i class="fa fa-university ne_mrg_ri8_10"></i>Edit Education / Occupation Preferences
                                    <span class="collapse-plus-nomargin" id="img_10_profile" </span>
                                </a>
                            </h3>
                        </div>
                        <div class="font-12 text-red pull-right"><span class="font-red">* </span> Mandatory fields</div>
                        <div class="clearfix"></div>
                         <div id="reponse_ne_lft_pan_list10"></div>	
                         <form id="ne_lft_pan_list10" name="ne_lft_pan_list10" action="<?php echo $base_url; ?>my-profile/save-profile/part-education-detail" onSubmit="return validat_function('ne_lft_pan_list10')" class="collapse margin-top-10 part-education-detail">
                             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
                            <input type="hidden" name="is_post" value="1" />
                            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                            
                            <?php
                                    $member_id = $this->common_front_model->get_session_data('id');
                                    if(isset($member_id) && $member_id != '' )
                                    {
                                        $row_data = $this->common_model->get_count_data_manual('register',array('id'=>$member_id,'is_deleted'=>'No'),1);
                                        $this->common_front_model->edit_row_data = $row_data;
                                        $this->common_model->edit_row_data = $row_data;
                                        $this->common_model->mode= 'edit';
                                        $this->common_front_model->mode= 'edit';
                                    }
                                    $ele_array = array(
                                         'part_education'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$education_name_arr,'label'=>'Partner Education','extra_style'=>'width:100%'),
                                        'part_employee_in'=>array('is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('employee_in'),'label'=>'Partner Employed In','extra_style'=>'width:100%'),
                                        'part_occupation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$occupation_arr,'label'=>'Partner Occupation','class'=>'select2','extra_style'=>'width:100%'),
                                        'part_designation'=>array('type'=>'dropdown','is_multiple'=>'yes','display_placeholder'=>'No','class'=>'select2','value_arr'=>$designation_arr,'label'=>'Partner Designation','extra_style'=>'width:100%'),
                                        'part_income'=>array('type'=>'dropdown','value_arr'=>$this->common_model->get_list_ddr('income'),'label'=>'Partner Annual Income','extra_style'=>'width:100%')
                                    );
                                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'edit_profile'));
                            ?>
                            <div class="clearfix"></div>
                                <hr>
                                <div class="row form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs">
                                    <div class="xxl-8 xxl-margin-left-4 xl-12 xl-margin-left-2 xs-16 s-16 m-16 l-16 padding-lr-zero-320 padding-lr-zero-480">
                                        <div class="xxl-8 xl-8 s-16 xs-16 m-8 l-8 text-center">
                                            <button onClick="return validat_function('ne_lft_pan_list10')" class="btn btn-info ne-cursor" ><i class="fa fa-check font-16"></i> Save Changes</button>
                                        </div>								</div>
                                </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    </div>

                    
				</div>

   	</div>
    	
	</div>
	<div class="clearfix"></div>
<!------------------<div class="container">----End------------------------------>	
<div class="clearfix"></div>
<div class="margin-top-30"></div>
<?php 
	if(isset($step_part) && $step_part !='')
	{
		$this->common_model->js_extra_code_fr.=" scroll_to_div('".$step_part."')
			$('.".$step_part."').addClass(' in ');
			
			var image_div = document.getElementById('".$step_part."');
			var img_id = image_div.getElementsByClassName('collapse-plus-nomargin')[0].id;
			if(img_id != ''){
				$('#'+img_id).attr('class','collapse-minus-nomargin');
			}else{
				$('#'+img_id).attr('class','collapse-plus-nomargin');	
			}
		";
	}
	$this->common_model->js_extra_code_fr.="
		$('select').select2();
		select2('#languages_known','Select Languages Known');
		
		
		function validat_function(form_id)
		{
			if($('#'+form_id).length > 0)
			{
				$('#'+form_id).validate({
				submitHandler: function(form)
				{
					common_ajax_request(form_id);
					return false;
				}
				});
			}
		}
		$('.button-wrap').on('click', function(){
			$(this).toggleClass('button-active');
		});
	
		function change_img(id)
		{	
			var className = $('#img_'+id).attr('class');		
			if(className =='collapse-plus-nomargin')
			{
				$('#img_'+id).attr('class','collapse-minus-nomargin');
			}
			else
			{
				$('#img_'+id).attr('class','collapse-plus-nomargin');				
			}
		} 
	";
?>