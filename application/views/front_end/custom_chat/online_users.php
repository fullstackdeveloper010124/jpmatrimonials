
<?php
## Get Notification List 
$member_id = $this->common_front_model->get_user_id();
$notification_list = $this->common_front_model->get_count_data_manual('web_notification_history',array('receiver_id' => $member_id),2,'*','id DESC','');
$notification_unread_count = $this->common_front_model->get_count_data_manual('web_notification_history',array('receiver_id' => $member_id,'status !=' => 'read'),0,'*','id DESC','');
?>	
<style>
    #exTab2 .nav-tabs > li > a:hover{
        border-color: none;
        border: none;
        border-bottom: none !important;
    }
    #exTab2 .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
        border: none;
    }
    #exTab2 .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        border: none;
        background: #0076a3;
        color: white !important;
    }

    .chat-sidebar .nav-tabs {
        border-bottom: 1px solid #ddd;
        background: #f8f8f8;
        display: inline-table;
        width: 100%;
        border-radius: 6px;
    }
</style>
<div class="chat-sidebar chat-sidebar-min hidden-xs hidden-sm">
    <div class="chat-header">
        <div class="chat-main-t">
            <h4>Chat / Alerts</h4>
            <!-- <h6>You Have 2 unread message</h6> -->
        </div>
        <div id="boxopen" class="toggler-minmz rot"><i class="far fa-chevron-double-down" aria-hidden="true"></i></div>
    </div>
    
        <div id="exTab2" class="">	
            <ul class="nav nav-tabs">
                <li class="active" style="width: 50%;text-align: center;"><a href="#1" data-toggle="tab">Chat</a></li>
                <li style="width: 50%; text-align: center;"><a href="#2" data-toggle="tab">Alert <span class="badge " style="background: #e64c4c;position: absolute;top: 3px;"><?php echo ($notification_unread_count < 100) ? $notification_unread_count : '99+'; ?></span></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="1">
                <div id="member-chat-list">
                    <div class="main-chat-list">
                        <hr>
                        <div class="chat-search">
                            <input type="text" id="custom_chat_search" placeholder="Search Member">
                        </div>
                    </div>
                    <!-- <div class="group-user" id="custom_chat_match_user">
                        No any match.
                    </div> -->
                    <div class="online-member-lst">
                        <h4>Online Members</h4>
                        <h5 id="onlineCount"><span><i class="fas fa-circle"></i></span>0</h5>
                    </div>
                    <div class="group-user" id="custom_chat_online_user">
                        No any user online.
                    </div>
                </div>
                </div>
                <div class="tab-pane" id="2" style="overflow: auto;overscroll-behavior: contain;height: 588px;">
                    <?php
                        
                        if(!empty($notification_list) && $notification_list !=''){
                            foreach ($notification_list as $key => $notification) {
                                $user_data = $this->common_front_model->get_count_data_manual('register',array('id' => $notification['sender_id']),1,'matri_id,photo1,photo1_approve,photo_view_status,gender','id DESC','');
                                
                                if($notification['sender_id']=='Admin'){
                                    $matri_label = "Admin";
                                }else if($notification['sender_id']=='User'){
                                    $matri_label = "You";
                                }
                                else{
                                    $matri_label = $user_data['matri_id'];
                                }
                                $read_class = '';
                                if($notification['status'] == 'read'){
                                    $read_class = 'read-notifi';
                                }else{
                                    $read_class = 'unread-notifi';
                                }
                                if(isset($user_data['gender']) && $user_data['gender']=='Female'){
                                    $photopassword_image = $base_url.'assets/images/photopassword_female.png';
                                }elseif(isset($user_data['gender']) && $user_data['gender']=='Male'){
                                    $photopassword_image = $base_url.'assets/images/photopassword_male.png';
                                }else{
                                    $photopassword_image = $photopassword_image;
                                }
                                $path_photos = $this->common_model->path_photos;
                                if(isset($user_data['photo1']) && $user_data['photo1'] !='' && isset($user_data['photo1_approve']) && $user_data['photo1_approve'] == 'APPROVED' && file_exists($path_photos.$user_data['photo1']) && isset($user_data['photo_view_status']) && $user_data['photo_view_status'] == 0){
                                    $image = $photopassword_image;
                                }else{
                                    $image = $this->common_model->member_photo_disp($user_data);
                                }
                                if($matri_label=='Admin'){
                                    $config_data = $this->common_model->get_site_config();
                                    if(isset($config_data['upload_favicon']) && $config_data['upload_favicon'] !=''){
                                        $image = base_url().'assets/logo/'.$config_data['upload_favicon'];
                                    } 
                                }?>
                                    <div class="notifi-chat <?php echo $read_class; ?>" onclick="readNotification(<?php echo $notification['id'] ?>,this,'<?php echo $notification['click_action'];?>')">
                                        <div class="chat-first-left">
                                            <img src="<?php echo $image;?>" class="img-responsive">
                                        </div>
                                        <div class="chat-left">
                                            <?php if($matri_label=='Admin' || $matri_label=='You'){
                                                ?><h4><?php echo $matri_label;?></h4>
                                        <?php }else{
                                            ?><a target="_blank" href="<?php echo base_url('search/view-profile/'.$user_data['matri_id']); ?>"><h4><?php echo $matri_label;?></h4></a><?php
                                        }?>
                                        </div>	
                                        <div class="chat-right">			
                                            <h6><?php echo $this->common_model->some_time_ago($notification['created_on']); ?></h6>
                                        </div>
                                        <div class="chat-left-right">
                                            <h5><?php echo $notification['title'] ?></h5>
                                        </div>
                                        <div class="chat-bottom">
                                            <p><?php echo $notification['message'] ?></p>
                                        </div>
                                    </div>
                                    <hr class="notifi-hr">
                            <?php
                            }
                        }else{
                            echo "No Notification.";
                        }
                    ?>
                </div>
            </div>
        </div>
</div>

<!-- Chat Box -->
<div class="chatbox-holder" id="conversation_chat_box">
    
</div>
<!-- Chat Box -->