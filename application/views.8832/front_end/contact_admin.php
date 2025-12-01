<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
		<div class="col-md-9 col-sm-12 col-xs-12">
            <?php include_once('my_dashboard_info.php');?>
				<div class="row mt-4">
					<div class="col-md-12 col-xs-12 col-sm-12 padding-zero">
						<div class="design-process-content-photo das-content-2  padding-0">
							<div class="box-view-profile">
								<p class="Poppins-Semi-Bold mega-n3 f-20 text-center">CONTACT TO <span class="mega-n4 f-20">ADMIN </span></p>
							</div>
							<hr class="hr-view">
							
							<div class="box-view-profile">
								<div class="row mt-3">
									<div class="col-md-12 col-xs-12 col-sm-12">
										<p class="text-center">Ask if have any type of query on our site or any type of enquiry please feel free to contact admin.
											
										</p>
									</div>
								</div>
							</div>
                            <div class="clearfix"></div>
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
								<?php if($this->session->flashdata('success_message')){?>
                                    <div class="alert alert-success" id="admin_contact"><?php
                                        echo $this->session->flashdata('success_message'); ?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="col-sm-12 col-md-12 col-xs-12 text-center">
                                <?php if($this->session->flashdata('message_for_user')){ ?>
                                    <div class="alert alert-danger"><?php
                                        echo $this->session->flashdata('message_for_user'); ?>
                                    </div>
                                <?php }?>
                            </div>
							<div class="box-view-profile">
                                <form action="<?php echo $base_url; ?>contact/send_msg_admin" method="post" name="contact_admin" id="contact_admin" enctype="multipart/form-data">
                                    <div class="row" style="margin-bottom:10px;">
                                        <div class="col-md-12 col-xs-12 col-sm-4">
                                            <p class="Poppins-Medium f-16 text-center">Please Write Your Query : </p> 
                                        </div>
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="text-area-center">
                                                <textarea class="form-control ni-input" rows="8" placeholder="Enter Your Message Here" name="message" id="message" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom:10px;">
                                        <div class="col-md-12 col-xs-12 col-sm-12">
                                            <div class="add-ad-btn">
                                                <button type="submit" class="conatct-to-admin Poppins-Medium color-f f-18">
                                                    Send Message
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>