</div>
<div class="container container-fluid new-width" id="prt_pref_default">
        <div class="row mt-3">
            <div class="col-md-8 col-xs-12 col-sm-12">
                <div class="part-pref-box">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="part-pref1">
                                <div class="bg-Untitled_1">
                                </div>
                                <p class="Poppins-Regular f-18 color-40 prf_1 text-center">You are registered successfully!</p>
                                <p class="Poppins-Regular f-14 color-68 prf_3 text-center">Congratulation you are registered now. We have sent you a verification email. Please verify your account.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 text-center hidden-lg hidden-sm hidden-md">
                            <div class="Part_pref_btn_div">
                                <a href="<?php echo $base_url.'premium-member'; ?>" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1 part_prf_cstm">
								Select membership plan
							    </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
                            <div class="part-pref2">
                                <div class="bg-Untitled_2">
                                </div>
                                <p class="Poppins-Regular f-18 color-40 prf_2 text-center">Fill up your Partner Preference details</p>
                                <p class="Poppins-Regular f-14 color-68 prf_3 text-center">Add Partners Information for better Match, we will recommended you as better Partner as per your profile.</p>
                            </div>
                        </div>
                        <div class="parf_hr"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 text-center hidden-xs">
                            <div class="Part_pref_btn_div">
                                <a href="<?php echo $base_url.'premium-member'; ?>" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1 part_prf_cstm" id="add_partner_pref">
								Select membership plan
							    </a>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 hidden-lg hidden-sm hidden-md">
                            <div class="part-pref2">
                                <div class="bg-Untitled_2">
                                </div>
                                <p class="Poppins-Regular f-18 color-40 prf_2 text-center">Fill up your Partner Preference details</p>
                                <p class="Poppins-Regular f-14 color-68 prf_3 text-center">Add Partners Information for better Match, we will recommended you as better Partner as per your profile.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 text-center">
                            <div class="Part_pref_btn_div">
                                <a href="<?php echo $base_url; ?>register/partner-preference" class="btn btn-info sidebar-btn Poppins-Medium f-16 color-f next-step1 part_prf_cstm" id="add_partner_pref">
								Add Partner Preference
							    </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs">
                <?php 
                $data['limit']=4;
                $data['class']='p-12 pro-hidden ';
                $data['class1']='Prf_sidebar-new-mac';
                $this->load->view('front_end/featured_rightsidebar',$data);
                ?>
            </div>
        </div>
    </div>
   
    <?php
	$this->common_model->user_ip_block();
	if(base_url()!='http://192.168.1.111/mega_matrimony/original_script/'){
		$uri_segment_check_red = $this->uri->segment(1);
		if(isset($uri_segment_check_red) && $uri_segment_check_red!=''){
			$uri_segment_check_red = $this->uri->segment(1);
		}
		else{
			$uri_segment_check_red = basename($_SERVER['PHP_SELF']);
		}
		if(isset($uri_segment_check_red) && $uri_segment_check_red!='' && $uri_segment_check_red!="blocked"){
			$details = $this->common_model->add_user_analysis();
		}
	}
	?>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.min.js"></script>		
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/bootstrap.min.js"></script>
    <script src="<?php echo $base_url; ?>assets/front_end_new/js/jquery.sticky.js"></script>
    <?php include_once("page_part/log_reg_menu_script.php");?>
	</body>

</html>