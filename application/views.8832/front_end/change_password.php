<div  id="change-password-tab" class="ne_tab_sub_tab_content ne_interest_sent_tab xxl-16 xl-16 m-16 l-16 s-16 xs-16 tab-content" style="border:0px;">
								     <?php
						if($this->session->flashdata('success_message_change_password'))
						{
							$success_message = $this->session->flashdata('success_message_change_password');
							if($success_message !='')
							{
								echo '<div id="mydivs" class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$success_message.'</div>';
							}
						}
						if($this->session->flashdata('error_message_change_password'))
						{
							$error_message = $this->session->flashdata('error_message_change_password');
							if($error_message !='')
							{
								echo '<div id="mydivs" class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$error_message.'</div>';
							}
						}
						$this->session->unset_userdata('success_message_change_password');?>
												<div class="xxl-16 xl-16 xs-16 l-16 m-16 s-16 padding-0-5-xs">
													<div class="">
														<h3 class="xxl-16 xl-16 xs-16 l-16 m-16 s-16 margin-bottom-0px padding-bottom-10px ne-bdr-btm-lgt-grey text-darkgrey padding-lr-zero">
															<i class="fa fa-key ne_mrg_ri8_10"></i>Change Password
														</h3>
														<p class="xxl-16 xl-16 xs-16 l-16 m-16 s-16 text-darkgrey margin-top-10px padding-lr-zero padding-bottom-10px ne-bdr-btm-lgt-grey">
															Your opted settings for receiving alerts through emails are mentioned here. You may choose to edit the existing settings.
														</p>
														
														<div class="xxl-16 xl-16 l-16 s-16 m-16 xs-16 padding-lr-zero ne_pad_btm_10px ne_pad_tp_10px margin-top-20">
															<form method="post" name="change_pass" id="change_pass"> 	
																<div class="xxl-16 xl-16 l-16 s-16 m-16 xs-16 form-group padding-lr-zero-320 padding-lr-zero-480 padding-lr-zero-768 padding-lr-zero-999 padding-0-5-xs">
																	<div class="xxl-5 xl-5 xs-16 s-16 m-5 l-8 ne_pad_tp_5px font-13">
																		Enter Old Password:
																	</div>
																	<div class="xxl-8 xl-8 l-8 m-8 xs-16 s-16">
																		<input type="password" class="form-control" id="old_pass" name="old_pass" required>
																	</div>
																</div>
																<div class="xxl-16 xl-16 l-16 s-16 m-16 xs-16 form-group padding-lr-zero-320 padding-lr-zero-480  padding-lr-zero-768 padding-lr-zero-999 padding-0-5-xs">
																	<div class="xxl-5 xl-5 xs-16 s-16 m-5 l-8 ne_pad_tp_5px font-13">
																		Enter New Password:
																	</div>
																	<div class="xxl-8 xl-8 l-8 m-8 xs-16 s-16">
																		<input type="password" class="form-control" id="new_pass" name="new_pass" required>
																	</div>
																</div>
																<div class="xxl-16 xl-16 l-16 s-16 m-16 xs-16 form-group padding-lr-zero-320 padding-lr-zero-480  padding-lr-zero-768 padding-lr-zero-999 padding-0-5-xs">
																	<div class="xxl-5 xl-5 xs-16 s-16 m-5 l-8 ne_pad_tp_5px font-13">
																		Enter Confirm Password:
																	</div>
																	<div class="xxl-8 xl-8 l-8 m-8 xs-16 s-16">
																		<input type="password" class="form-control" id="cnfm_pass" name="cnfm_pass" required>
																	</div>
																</div>
																<div class="xxl-16 xl-16 l-16 m-16 xs-16 s-16 margin-top-15px padding-0-5-xs">
																	<div class="xxl-4 xxl-margin-left-6 xl-4 xl-margin-left-6 xs-16 s-16 m-4 m-margin-left-6 l-6 l-margin-left-5">
																	<!--	<a href="#" class="btn btn-success font-15"><i class="fa fa-check"></i> Save Change</a>-->
                                                                   <input type="submit" class="btn btn-block text-white btn-deep-purple font-15" value="Save Changes" >
       																	</div>
																</div>
                                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" class="hash_tocken_id" />                                        <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
                                        						   <input type="hidden" name="is_post" id="is_post" value="1"/>                       
                                                                
															</form>
														</div>
													</div>
												</div>
											</div>