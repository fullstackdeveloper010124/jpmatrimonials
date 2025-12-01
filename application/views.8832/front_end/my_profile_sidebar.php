<?php 
$current_login_user = $this->common_front_model->get_session_data(); 
$login_user_matri_id = $current_login_user['matri_id'];
$login_user_gender = $current_login_user['gender'];
$login_user_id = $current_login_user['id'];
$curre_id = $this->common_front_model->get_session_data('id');
if($login_user_gender == 'Male')
{
	$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
}
else
{
	$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
}
$member_data_mobile = '';
if(isset($curre_id) && $curre_id!='')
{
	$where_array = array('id'=>$curre_id, 'is_deleted'=>'No');
	$member_data_mobile = $this->common_model->get_count_data_manual('register_view',$where_array,1,'id,matri_id,birthdate,username,email,mobile,mobile_verify_status,email,occupation_name,cpass_status,id_proof,id_proof_approve,plan_name,plan_status,photo1,photo2,photo3,photo4,photo5,photo6,cover_photo,cover_photo_approve');
}
$mobile_num = '';
$mobile_num_status = '';
$email = '';
$email_status = '';
$id_proof = '';
$plan_name = '';
$plan_status = '';
$id_proof_approve = '';
if(isset($member_data_mobile) && $member_data_mobile != "")
{
	if(isset($member_data_mobile['mobile']) && $member_data_mobile['mobile']!='') 
	{
		$mobile_num = $member_data_mobile['mobile'];
	}
	if(isset($member_data_mobile['mobile_verify_status']) && $member_data_mobile['mobile_verify_status'] != '')
	{
		$mobile_num_status = $member_data_mobile['mobile_verify_status'];
	}
	if(isset($member_data_mobile['email']) && $member_data_mobile['email']!='') 
	{
		$email = $member_data_mobile['email'];
	}
	if(isset($member_data_mobile['cpass_status']) && $member_data_mobile['cpass_status'] != '')
	{
		$email_status = $member_data_mobile['cpass_status'];
	}
	if(isset($member_data_mobile['id_proof']) && $member_data_mobile['id_proof'] != '')
	{
		$id_proof = $member_data_mobile['id_proof'];
	}
	if(isset($member_data_mobile['id_proof_approve']) && $member_data_mobile['id_proof_approve']!='')
	{
		$id_proof_approve = $member_data_mobile['id_proof_approve'];
	}
	if(isset($member_data_mobile['plan_name']) && $member_data_mobile['plan_name'] != '')
	{
		$plan_name = $member_data_mobile['plan_name'];
	}
	if(isset($member_data_mobile['plan_status']) && $member_data_mobile['plan_status'] != '')
	{
		$plan_status = $member_data_mobile['plan_status'];
    }
    if(isset($member_data_mobile['matri_id']) && $member_data_mobile['matri_id'] != '')
	{
		$matri_id=$member_data_mobile['matri_id'];
	}
}
if(isset($matri_id) && $matri_id!='')
{
	$where_arr = array('matri_id'=>$matri_id, 'is_deleted'=>'No');
	$member_plan = $this->common_model->get_count_data_manual('payments',$where_arr,1,'id,matri_id,plan_expired','id desc');
}
if(isset($member_plan) && $member_plan != "")
{
	if(isset($member_plan['plan_expired']) && $member_plan['plan_expired']!='') 
	{
		$plan_expired = $member_plan['plan_expired'];
	}
}
$today=date('Y-m-d');
//$this->common_model->extra_js_fr= array('js/owl.carousel.min.js','js/slider.js');
?>
        <?php 
            $received_data = $this->common_model->get_count_data_manual('photoprotect_request',array('photoprotect_request.ph_receiver_id'=>$login_user_matri_id,'rec_delete' => 'No'),0,'','','','','','');
            $send_data = $this->common_model->get_count_data_manual('photoprotect_request',array('photoprotect_request.ph_requester_id'=>$login_user_matri_id,'sen_delete'=>'No'),0,'','','','','','');
            $Like_data = $this->common_model->get_count_data_manual('member_likes',array('my_id'=>$login_user_matri_id,'like_status'=>'Yes'),0,'','','','','','');
            //$Unlike_data = $this->common_model->get_count_data_manual('member_likes',array('my_id'=>$login_user_matri_id,'like_status'=>'No'),0,'','','','','','');
            $Short_List_data = $this->common_model->get_count_data_manual('shortlist',array('shortlist.is_deleted'=>'No','shortlist.from_id'=>$login_user_matri_id),0,'');
            $Block_data = $this->common_model->get_count_data_manual('block_profile',array('is_deleted'=>'No','block_by'=>$login_user_matri_id),0,'');
            $inbox = 0;
            $member_id = $this->common_front_model->get_user_id('matri_id','matri_id');
            $where_arra=array('message.receiver'=>$member_id,'message.trash_receiver'=>'No','message.status'=>'sent');
            $inbox = $this->common_model->get_count_data_manual('message',$where_arra,0,'');
            
            $this->common_model->is_delete_fild = '';
            $where_arra=array('who_viewed_my_profile.my_id'=>$login_user_matri_id,"register_view.is_deleted"=>'No',"register_view.status!="=>'Suspended');
            $this->common_model->set_table_name('who_viewed_my_profile');
            $this->db->join('register_view',' who_viewed_my_profile.viewed_member_id = register_view.matri_id ','left');
            $i_view_data = $this->common_model->get_count_data_manual('who_viewed_my_profile',$where_arra,0,'','',0);
            // $i_view_data = $this->common_model->get_count_data_manual('who_viewed_my_profile',array('my_id'=>$login_user_matri_id,"register_view.status!="=>'Suspended'),0,'','',0);
            $this->common_model->is_delete_fild = '';
            $view_my_data = $this->common_model->get_count_data_manual('who_viewed_my_profile',array('viewed_member_id'=>$login_user_matri_id),0,'','',0);
            $this->common_model->is_delete_fild = '';
            $i_view_contact = $this->common_model->get_count_data_manual('contact_checker',array('my_id'=>$login_user_matri_id),0,'','',0);
            
            $expinter_data = $this->common_model->get_count_data_manual('expressinterest',array("is_deleted"=>'No',"(sender = '".$login_user_matri_id."' OR receiver = '".$login_user_matri_id."')"),0,'','',0);
            $this->common_model->is_delete_fild = '';
            $view_my_contact = $this->common_model->get_count_data_manual('contact_checker',array('viewed_id'=>$login_user_matri_id),0,'','',0);
            
            // echo $this->db->last_query();exit;
        ?>
    <div class="col-md-3 col-sm-3 col-xs-12 pr-0 pad-left-mob-0">
        <div class="sidebar-list-profile hidden-sm hidden-xs">
            <div class="for-list-title-bg">
                <h3><i class="fas fa-list"></i> List of Profile</h3>
            </div>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>express-interest"><i><img src="<?php echo $base_url; ?>assets/images/m-e-i.png" alt=""></i> My Express Interest <span><?php echo sprintf("%02d", $expinter_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>message"><i class="fas fa-inbox f-20"></i> My Messages <span><?php echo sprintf("%02d", $inbox);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/i-viewed"><i><img src="<?php echo $base_url; ?>assets/images/i-v-p.png" alt=""></i> I Viewed Profile <span><?php echo sprintf("%02d", $i_view_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/who-viewed"><i><img src="<?php echo $base_url; ?>assets/images/v-m-p.png" alt=""></i> Viewed My Profile <span><?php echo sprintf("%02d", $view_my_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/i-contacted"><i><img src="<?php echo $base_url; ?>assets/images/i-v-c.png" alt=""></i> I Viewed Contact <span><?php echo sprintf("%02d", $i_view_contact);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/who-contacted"><i><img src="<?php echo $base_url; ?>assets/images/w-v-c.png" alt=""></i> Viewed My Contact <span><?php echo sprintf("%02d", $view_my_contact);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/short-listed"><i><img src="<?php echo $base_url; ?>assets/images/s-l-p.png" alt=""></i> Short Listed Profile <span><?php echo sprintf("%02d", $Short_List_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url;?>my-profile/block-listed"><i><img src="<?php echo $base_url; ?>assets/images/b-p.png" alt=""></i> Blocked Profile <span><?php echo sprintf("%02d", $Block_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/photo-pass-request-received'; ?>"><i><img src="<?php echo $base_url; ?>assets/images/p-r-r.png" alt=""></i> Photo Request Received <span><?php echo sprintf("%02d", $received_data); ?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/photo-pass-request-sent'; ?>"><i><img src="<?php echo $base_url; ?>assets/images/p-r-s.png" alt=""></i> Photo Request Sent<span><?php echo sprintf("%02d", $send_data);?></span></a>
            <hr>
            <a class="list-group-item visitor" href="<?php echo $base_url.'my-profile/like-profile'; ?>"><i><img src="<?php echo $base_url; ?>assets/images/l-p.png" alt=""></i> Like Profile <span><?php echo sprintf("%02d", $Like_data);?></span></a>
            <hr>
        </div>
        <?php
        $plan_data = $this->common_model->get_count_data_manual('payments',array('current_plan'=>'Yes','matri_id'=>$login_user_matri_id),1,'*','id desc');
        if (isset($plan_data) && !empty($plan_data)) {?>
        <div class="bg-plan-up hidden-sm hidden-xs margin-bottom-10">
            <div class="bg-plan-up-title">
                <h3><i class="fas fa-gem"></i> Package information</h3>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6  right-brd bottom-brd">
                <div class="plan-info-pro">
                    <h5>Plan Category</h5>
                    <p><?php echo ($plan_data['category_type']!='')?$plan_data['category_type']:'N/A';?></p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6  right-brd bottom-brd">
                <div class="plan-info-pro">
                    <h5>Current Package</h5>
                    <p><?php echo $plan_data['plan_name'];?></p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6  right-brd bottom-brd">
                <div class="plan-info-pro">
                    <h5>Price</h5>
                    <p><?php echo $plan_data['currency'].' '.$plan_data['grand_total'];?>/-</p>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6  right-brd bottom-brd">
                <div class="plan-info-pro">
                    <h5>Expired Date</h5>
                    <p><?php echo $this->common_model->displayDate($plan_data['plan_expired'],'F j, Y');?></p>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <div class="upgrade-plan-btn-pro">
                    <button onClick="location.href='<?php echo $base_url.'premium-member'?>'">Upgrade Plan</button>
                </div>
            </div>
        </div>
        <?php }?>
        <!-- <div class="mt-2"></div> -->
        <?php 
        // if($this->router->fetch_method()!='current_plan'){
        //     // $data = array();
        //     // $data['limit']=3;
        //     // $data['class']='p-8 pro-hidden';
        //     // $data['class1']='dashbrd_img-box';
        //     $this->load->view('front_end/featured_leftsidebar');
        // }
        ?>
    </div>
