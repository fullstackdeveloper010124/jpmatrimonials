<?php $login_user_matri_id = $this->common_front_model->get_session_data('matri_id');;?>
		
        <div class="col-sm-12 col-xs-12 hidden-lg hidden-md padding-0 mt-4">
            <div class="#">
                <button class="btn btn-lg btn-primary-k b-m-mobile" data-toggle="collapse" data-target="#dshbrd_mobile_list"> <i class="fas fa-user  f-20 pt-1 pull-left"></i> List of profile <i class="fas fa-chevron-down pt-1 pull-right"></i></button>
            </div>
  		</div>
        
        <div id="dshbrd_mobile_list" class="collapse">
            <div class="">
                <div class="row margin-0">
                    <div class="col-md-3 col-sm-12 col-xs-12 hidden-lg hidden-md">
                        <div class="row">
                            <div class="list-group">
                            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/photo-pass-request-received'; ?>">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Photo Request Received
                                </p>
                                
                                <?php
                                    $where_arra=array('photoprotect_request.ph_receiver_id'=>$login_user_matri_id,'rec_delete' => 'No');
                                    $received_data = $this->common_model->get_count_data_manual('photoprotect_request',$where_arra,0,'','','','','','');
                                ?>
                               
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $received_data); ?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/photo-pass-request-sent'; ?>">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Photo Request Sent
                                </p>
                                
                                <?php 
                                    $where_arra=array('photoprotect_request.ph_requester_id'=>$login_user_matri_id,'sen_delete'=>'No');
                                    $send_data = $this->common_model->get_count_data_manual('photoprotect_request',$where_arra,0,'','','','','','');
                                ?>
                               
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $send_data); ?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/like-profile'; ?>">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Like Profile
                                </p>
                                
                                <?php 
                                    $where_arra=array('my_id'=>$login_user_matri_id,'like_status'=>'Yes');
                                    $Like_data = $this->common_model->get_count_data_manual('member_likes',$where_arra,0,'','','','','','');
                                ?>
                               
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $Like_data); ?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/unlike-profile'; ?>">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                Unlike Profile
                                </p>
                                
                                <?php 
                                    $where_arra=array('my_id'=>$login_user_matri_id,'like_status'=>'No');
                                    $Unlike_data = $this->common_model->get_count_data_manual('member_likes',$where_arra,0,'','','','','','');
                                ?>
                               
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $Unlike_data); ?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/short-listed">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                    Short Listed Profile
                                </p>
                                
                                <?php 
                                    $where_arra=array('shortlist.is_deleted'=>'No','shortlist.from_id'=>$login_user_matri_id);
                                    $data = $this->common_model->get_count_data_manual('shortlist',$where_arra,0,'');
                                ?>
                           
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $data);?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/block-listed">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                    Blocked Profile
                                </p>
                                
                                    <?php 
                                        $where_arra=array('block_profile.is_deleted'=>'No','block_profile.block_by'=>$login_user_matri_id);
                                        $data = $this->common_model->get_count_data_manual('block_profile',$where_arra,0,'');
                                    ?>
                               
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $data);?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/i-viewed">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                    I Viewed Profile
                                </p>
                    
                            <?php 
                            $this->common_model->is_delete_fild = '';
                            $where_arra=array('who_viewed_my_profile.my_id'=>$login_user_matri_id);
                            $data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
                            ?>
                       
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $data);?></span>
                            </a>
                            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/who-viewed">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                    Viewed My Profile
                                </p>
                                
                    
                    <?php 
                            $this->common_model->is_delete_fild = '';
                            $where_arra=array('who_viewed_my_profile.viewed_member_id'=>$login_user_matri_id);
                            $data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
                            ?>
                       
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $data);?></span>
                            </a>
                            
                            <a class="list-group-item visitor" href="<?php echo $base_url;?>express-interest">
                                <p class="Poppins-Medium f-16 color-38 dashbrd_3">
                                    My Express Interest
                                </p>
                                
                        <?php $data1 = $this->common_model->get_count_data_manual('expressinterest',array("is_deleted"=>'No',"(sender = '".$login_user_matri_id."' OR receiver = '".$login_user_matri_id."')"),0,'','',0);?>
                       
                                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4"><?php echo sprintf("%02d", $data1);?></span>
                            </a>
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-xs-12 hidden-lg hidden-md padding-0">
            <div class="#">
                <button class="btn btn-lg btn-primary-k b-m-mobile" data-toggle="collapse" data-target="#dshbrd_mobile_search"><i class="fas fa-search f-20 pt-1 pull-left"></i>  Quick Search<i class="fas fa-chevron-down pt-1 pull-right"></i></button>
            </div>
  		</div>
        
        <div id="dshbrd_mobile_search" class="collapse">
            <div class="">
                <div class="row margin-0">
                    <div class="col-md-3 col-sm-12 col-xs-12 hidden-lg hidden-md">
                        <div class="row">
                        <div class="list-group pt-2 pb-4 clearfix">
                    <form class="xxl-16 xl-16 m-16 xs-16 l-16 s-16 ne_font_14" method="post" action="<?php echo $base_url; ?>search/search_now">
                        <a class="list-group-item google-plus" href="#">
                            <p class="Poppins-Semi-Bold f-17 color-d dashbrd_1">
                                <i class="fas fa-search dashbrd_user_icon"></i> Quick Search
                            </p>
                        </a>
                        <div class="age_dshbrd">
                            <div class="row-cstm">
                                <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Age:</label>
                            </div>
                            <div class="row-cstm">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="select_box5">
                                        <select class="form-control dashbrd_cstm" name="from_age" style="width:100%">
                                            <option value="">From</option>
                                            <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),18);?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row-cstm">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="select_box5">
                                    <select class="form-control dashbrd_cstm" name="to_age" style="width:100%">
                                        <option value="">To</option>
                                        <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),30);?>
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                        <div class="height_dshbrd">
                            <div class="row-cstm">
                                <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Height:</label>
                            </div>
                            <div class="row-cstm">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="select_box5">
                                        <select class="form-control dashbrd_cstm" name="from_height" style="width:100%">
                                            <option value="">From</option>
                                            <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row-cstm">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <div class="select_box5">
                                        <select class="form-control dashbrd_cstm" name="to_height" style="width:100%">
                                            <option value="">To</option>
                                            <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="religion_dshbrd">
                            <div class="row-cstm">
                                <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Religion:</label>
                            </div>
                            <div class="row-cstm">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="select_box5 ">
                                        <select data-placeholder="Select Religion" id="search_religion" name="religion[]" class="form-control dashbrd_cstm"  style="width:100%">
                                            <option value="">Select Religion</option>
                                            <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('religion'));?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="dshbrd_checkbox">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="custom-control custom-checkbox mtm-0 w-102">
                                    <input class="custom-control-input" id="360" type="checkbox" value="photo_search" name="photo_search">
                                    <label for="360" class="dshbrd_cstm-control mt-3 Poppins-Regular">
                                    <span class="t1 Poppins-Regular f-13 color-65">With Photo</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                <button type="submit" class="dshbrd_21 Poppins-Medium f-17 color-f"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </form>
                    </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>