<style>
  #line-progressbar {

    background: linear-gradient(#fcb045,#fd1d1d,#ed3237);
    border-radius: 15px;


}



</style>
<?php 
$badgepath = $badgeStyle = $color = '';
if (isset($member_data['badge']) && $member_data['badge']!='' && file_exists($this->common_model->path_payment_logo.$member_data['badge'])) {
    $badgeStyle = 'style="position:relative;background-color:none;"';
    $badgepath = '<img src="'.$member_data['badgeUrl'].$member_data['badge'].'" style="background-color: #ffffff00;position: absolute;right: -6px;top: -10px;z-index: 99;height: 90px;width: 90px;">';
    if (isset($member_data['color']) && $member_data['color']!='') {
      $color = $member_data['color'];
    }
}
if($color == ''){
    $color = $this->common_model->data['config_data']['profile_border_color'];
}
$badgebackStyle = "box-shadow: 0px 3px 6px ".$color."!important;border-top: 4px solid ".$color.";";
?>

<div class="mt-0"></div>
<div class="main-new-profile-bg">
  <div class="container-fluid width-95 mt-60-pro">
    <?php include_once('my_profile_sidebar.php'); ?>
    <div class="col-md-9 col-sm-12 col-xs-12 margin-bottom-40">
      <div id="reponseMsg" style="display:none;"></div>
      <div class="profile-main-bg-1" style="<?php echo $badgebackStyle;?>">
        <div class="col-md-3 col-sm-12 col-xs-12 pl-0 pr-0 ">
        <?php 
          
          $is_shortlist = $is_block = 0;
          $is_interest = '';
          $is_shortlist_text = 'Shortlist';
          $is_block_text = 'Block';
          $is_view = 0;
          $is_like = 'Yes';
          $is_like_icon = '<i class="fas fa-thumbs-up"></i>';

          $member_id = $this->common_front_model->get_session_data('matri_id');
          $plan_status = $this->common_front_model->get_session_data('plan_status');
          
          $gender = $this->common_front_model->get_session_data('gender');
          if(isset($gender) && $gender == 'Male'){
            $photopassword_image = $base_url.'assets/images/photopassword_female.png';
            }else{
            $photopassword_image = $base_url.'assets/images/photopassword_male.png';
          }
          
          if (isset($member_data['action'][0]) && !empty($member_data['action'][0])) {
              $action = $member_data['action'][0];
              if (isset($action['is_shortlist']) && $action['is_shortlist']!='' && $action['is_shortlist']==1) {
                $is_shortlist = 1;
                $is_shortlist_text = 'Shortlisted';
                $is_shortlist_icon = 'fas fa-star';
                $is_shortlisted = 'animate';
              }else{
                $is_shortlist = 0;
                $is_shortlist_text = 'Shortlist';
                $is_shortlist_icon = 'far fa-star';
                $is_shortlisted = '';
              }
              if (isset($action['is_block']) && $action['is_block']!='' && $action['is_block']==1) {
                $is_block = 1;
                $is_block_text = 'Blocked';
                $is_blocked = 'animate';
                echo '<input type="hidden" id="is_member_block_'.$member_data['matri_id'].'" name="is_member_block_'.$member_data['matri_id'].'" value="1" />';
              }else{
                $is_block = 0;
                $is_block_text = 'Block';
                $is_blocked = '';
                echo '<input type="hidden" id="is_member_block_'.$member_data['matri_id'].'" name="is_member_block_'.$member_data['matri_id'].'" value="" />';
              }
              if (isset($action['is_like']) && $action['is_like']!='' && $action['is_like']=='Yes') {
                $is_like = 'No';
                $is_like_text = 'Liked';
                $is_like_icon = 'fas fa-thumbs-down';
              }else{
                $is_like = 'Yes';
                $is_like_text = 'Like';
                $is_like_icon = 'fas fa-thumbs-up';
              }
              $active_interested= "";
              if (isset($action['is_interest']) && $action['is_interest']!='' && $action['is_interest']!='') {
                $is_interest_text = 'Interested';
                $is_interest_icon = 'fas fa-heart';
                $active_interested = "fa-heart-bg-white";
                // $is_interested = 'animate';
                $is_interested = '';
              }else{
                $is_interest_text = 'Interest';
                $is_interest_icon = 'far fa-heart';
                $is_interested = '';
              }
              
              $is_view = (isset($action['is_view']) && $action['is_view']!='')?$action['is_view']:0;
          }

          

          $userPhotoCount = 0;
          // Php lower version issue start 25/11/2021
          $minPHPVersion = '7.4.0';
          if (phpversion() < $minPHPVersion)
          {
              if(isset($member_data['fileds'][key(end($member_data['fileds']))]['value']) && !empty($member_data['fileds'][key(end($member_data['fileds']))]['value'])){
              $photoinfo = $member_data['fileds'][key(end($member_data['fileds']))]['value'];
              $userPhotoCount = count($photoinfo);
              }
          }
          else
          {
              if(isset($member_data['fileds'][array_key_last($member_data['fileds'])]['value']) && !empty($member_data['fileds'][array_key_last($member_data['fileds'])]['value'])){
                  $photoinfo = $member_data['fileds'][array_key_last($member_data['fileds'])]['value'];
                  $userPhotoCount = count($photoinfo);
              }
          }
          unset($minPHPVersion); 
          // Php lower version issue end 25/11/2021
          
          ?>
          <div class="profile-pic-main" <?php echo $badgeStyle;?>>
            <?php echo $badgepath;?>
            <?php
              $imgSlider = '';
              $path_photos = $this->common_model->path_photos;
							if(isset($member_data['photo1']) && $member_data['photo1'] !='' && isset($member_data['photo1_approve']) && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && isset($member_data['photo_view_status']) &&  $member_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count == 0){
							?><a data-toggle="modal" data-target="#myModal_photoprotect" title="Photo Protected" onClick="addstyle('<?php echo $member_id;?>','<?php echo $member_data['matri_id']; ?>')">
							<img src="<?php echo $photopassword_image; ?>">
						</a>
						<?php 
							}else{
							if(isset($member_data['gender']) && $member_data['gender'] == 'Male'){
								$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
								}else{
								$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
							}
							if(isset($member_data['photo1']) && $member_data['photo1'] !='' && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && ($member_data['photo_view_status'] == 1 || ($member_data['photo_view_status'] == 2 && $plan_status == 'Paid') || (isset($member_data['photo_view_status']) &&  $member_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count > 0)))
							{ ?>
							    <a href="javascript:;" data-toggle="modal" data-target="#myModal_new" onclick="currentSlide(1)"><img src="<?php echo $base_url; ?><?php echo $path_photos;?><?php echo $member_data['photo1'];?>"></a>
							<?php
                  $imgSlider = 'data-toggle="modal" data-target="#myModal_new" onclick="currentSlide(1)"';
              }
							else
							{ ?>
							<a href="javascript:;"><img src="<?php echo $defult_photo;?>"></a>
							<?php   } 
						}	?>
            
            <div class="view-pro-c">
              <i class="fas fa-eye"></i> <span> <?php echo $is_view;?></span>
            </div>
            <?php if ($userPhotoCount>1) {
              echo '<div class="photo-pro-c" '.$imgSlider.'>
                <i class="fas fa-plus"></i> <span>'.$userPhotoCount.'</span>
              </div>';
            } ?>
            
          </div>
        </div>
        <div class="col-md-7 col-sm-12 col-xs-12 pl-0 pr-0 ">
          <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12">
              <div class="profile-user-name">
                <h3><?php echo $member_data['username'];?></h3>
                <p><?php echo $member_data['occupation_name'];?></p>
              </div>
            </div>

            <div class="col-md-3 col-sm-9 col-xs-9">
              <!-- view-contact detail button here -->

              <div class="vie-c-btn-new">
                <button><a href="javascript:;" data-toggle="modal" data-target="#myModal_ViewContactDetails" onClick="get_ViewContactDetails('<?php echo $member_data['matri_id'];?>')"><i class="fas fa-phone-alt"></i> View Contact</a></button>
              </div>

              



            </div>

            <div class="col-md-3 col-sm-3 col-xs-3 pl-0">
              <!-- view-contact detail button here -->

              <div class="btn-msg-pro " style='display:flex;justify-content: space-around;'>
                <button type="button"  data-toggle="modal" data-target="#myModal_video" title="video" onclick="get_matri_id('<?php echo $member_data['matri_id'];?>')"><i class="fas fa-play-circle f-14"></i></button>
                <button type="button"  data-toggle="modal" data-target="#myModal_sms" title="Send Message"  onclick="get_member_matri_id('<?php echo $member_data['matri_id'];?>')"><i class="fas fa-comment-alt"></i></button>
                <button type="button" id="is_like" title='<?php echo $is_like_text; ?>' class="commonAction" data-action="is_like" data-curr="<?php echo $is_like;?>" data-oppId="<?php echo $member_data['matri_id'];?>"><i class="<?php echo $is_like_icon;?>"></i></button>
              </div>



            </div>


          </div>
          <div class="row margin-top-15 hidden-sm hidden-xs">
            <div class="for-detail-gray">
              <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                <h4>Matri ID</h4>
              </div>
              <div class="col-md-7 col-sm-12 col-xs-12 ">
                <h5><?php echo $member_data['matri_id'];?></h5>
              </div>
            </div>
            <div class="for-detail-white">
              <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                <h4>Date of birth</h4>
              </div>
              <div class="col-md-7 col-sm-12 col-xs-12 ">
                <h5><?php echo  date("d-m-Y", strtotime($member_data['birthdate']));?></h5>
              </div>
            </div>
            <div class="for-detail-gray">
              <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                <h4>Marital Status</h4>
              </div>
              <div class="col-md-7 col-sm-12 col-xs-12 ">
                <h5><?php echo $member_data['marital_status'];?></h5>
              </div>
            </div>
            <div class="for-detail-white">
              <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                <h4>Religion</h4>
              </div>
              <div class="col-md-7 col-sm-12 col-xs-12 ">
                <h5><?php echo $member_data['religion_name'];?></h5>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12 pl-0 pr-0 text-center">
          <div style="width:100%;" class="partner-pre-bg">

            <div class="icn-bg-for-action _action-shortlist <?php echo $is_shortlisted;?>">
              <button type="button" id="is_shortlist" class="commonAction" data-action="is_shortlist" data-curr="<?php echo $is_shortlist;?>" data-oppId="<?php echo $member_data['matri_id'];?>"><i class="<?php echo $is_shortlist_icon;?>"></i></button>
              <p><?php echo $is_shortlist_text;?></p>
            </div>
            <hr>
            
            <div class="icn-bg-for-action _action-interest <?php echo $active_interested;?>  <?php echo $is_interested;?>">
              <a href="javascript:void(0);" id="is_interest" data-toggle="modal" data-target="#myModal_sendinterest" onclick="express_interest('<?php echo $member_data['matri_id'];?>')" title="Send Interest" ><button><i class="<?php echo $is_interest_icon;?>"></i></button></a>
              <p><?php echo $is_interest_text;?></p>
            </div>

            <hr>
            
            <div class="icn-bg-for-action _action-block <?php echo $is_blocked;?>">
              <button type="button" id="is_block" class="commonAction" data-action="is_block" data-curr="<?php echo $is_block;?>" data-oppId="<?php echo $member_data['matri_id'];?>"><i class="fas fa-ban"></i></button>
              <p><?php echo $is_block_text;?></p>
            </div>

          </div>
        </div>
      </div>
      <!-- -----------------------profile details section start--------------- -->
      <div class="my-profile-details">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item active">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Partner Preference (<?php echo number_format($member_data['totalMatch']);?>% Match)</a>
          </li>
        </ul><!-- Tab panes -->
        <div class="tab-content">
          <!-- --------my profile content------ -->
          <div class="tab-pane active" id="tabs-1" role="tabpanel">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

              <div class="for-timelinr-user">
                <div class="wrapper">
                  <div  style="height: 102%;" class="center-line wow slideInRight ">
                    <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
                  </div>
                  <div id="line-progressbar" class="center-line wow slideInRight ">
                    
                  </div>
                  <?php 
                  
                  $iconArr = array('fas fa-address-card','fa fa-star','fas fa-info-circle','fas fa-school','fas fa-heartbeat','fa fa-map-marker','fas fa-home');
                  if (isset($member_data['fileds']) && !empty($member_data['fileds'])) {

                      // for remove photo array #start
                      // Php lower version issue start 25/11/2021
                      $minPHPVersion = '7.4.0';
                      if (version_compare(PHP_VERSION, $minPHPVersion, '<'))
                      {
                          if(isset($member_data['fileds'][key(end($member_data['fileds']))]['value']) && !empty($member_data['fileds'][key(end($member_data['fileds']))]['value'])){
                              $photoinfo = $member_data['fileds'][key(end($member_data['fileds']))]['value'];
                              $userPhotoCount = count($photoinfo);
                              }
                              // for remove photo array #start
                              if (isset($member_data['fileds'][key(end($member_data['fileds']))]) && !empty($member_data['fileds'][key(end($member_data['fileds']))])) {
                                  unset($member_data['fileds'][key(end($member_data['fileds']))]);
                              }
                              if (isset($member_data['fileds'][key(end($member_data['fileds']))]) && !empty($member_data['fileds'][key(end($member_data['fileds']))])) {
                                  unset($member_data['fileds'][key(end($member_data['fileds']))]);
                              }
                      }
                      else
                      {
                              // for remove photo array #start
                              if (isset($member_data['fileds'][array_key_last($member_data['fileds'])]) && !empty($member_data['fileds'][array_key_last($member_data['fileds'])])) {
                                  unset($member_data['fileds'][array_key_last($member_data['fileds'])]);
                              }
                              if (isset($member_data['fileds'][array_key_last($member_data['fileds'])]) && !empty($member_data['fileds'][array_key_last($member_data['fileds'])])) {
                                  unset($member_data['fileds'][array_key_last($member_data['fileds'])]);
                              }
                      }
                      unset($minPHPVersion); 
                      // Php lower version issue end 25/11/2021
                      // for remove photo array #end
                      $s=0;
                      foreach ($member_data['fileds'] as $headingKey => $headingValue) { ?>
                  <div class="row row-2">
                    <section class="wow bounceInUp" data-wow-duration="1.<?php echo $s;?>s" data-wow-delay="0.<?php echo $s+1;?>s">
                      <i class="icon <?php if(isset($iconArr[$s])){ echo $iconArr[$s]; } else{ echo 'fas fa-home';}?>"></i>
                      <div class="details">
                        <span class="title"><?php echo $headingValue['name'];?></span>

                      </div>

                      <div class="row margin-top-10">
                        <div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">
                         <?php 
                        
									$path_horoscope = $this->common_model->path_horoscope;
									$horoscope_approved = "false";
									if(isset($member_data['horoscope_photo']) && $member_data['horoscope_photo'] !='' && $member_data['horoscope_photo_approve'] == 'APPROVED' ){
										$horoscope = $base_url.$path_horoscope.$member_data['horoscope_photo'];
										$horoscope_approved = "true";
									}
							
						 ?>
                        <?php 
                          if (isset($member_data['fileds'][$headingKey]['value']) && !empty($member_data['fileds'][$headingKey]['value'])) {
                              $totalFields = count($member_data['fileds'][$headingKey]['value']); // total fileds in section 
                              $showFieldsCount = (($totalFields - ($totalFields%2))/2) + ($totalFields%2); // how many fields show one side
                              $i = $j = 0;
                              foreach ($member_data['fileds'][$headingKey]['value'] as $filedsValue) {
                                  $title = $value = '';
                                  $title = (isset($filedsValue['title']) && $filedsValue['title']!='')?$filedsValue['title']:'N/A';
                                  $value = (isset($filedsValue['value']) && $filedsValue['value']!='')?$filedsValue['value']:'N/A';
                                  $short_value = (isset($value) && $value!='' && strlen($value)>30)?substr($filedsValue['value'],0,30).'...':$value;
                                  

                                  if ($i==$showFieldsCount) { // set for second side
                                      echo '</div><div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">';
                                      $j = 0;
                                  }
                                  if ($j == 0 || $j%2==0){ // for grey section show
                                      echo '<div class="for-detail-gray-1">
                                          <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                                              <h4>'.$title.'</h4>
                                          </div>
                                          <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 ">
                                              <h5 title="'.$value.'">'.$short_value.'</h5>
                                          </div>
                                      </div>';
                                  }else{ // for white section show
                                 
                                        if(trim($title)=="Horoscope" && $horoscope_approved=="true")
                                        {
                                           $short_value = '<a data-toggle="modal" href="#myModal123" class=" ">Click & View</a>';
                                        }
                                        else
                                        {
                                            $short_value = ' <h5 title="'.$value.'">'.$short_value.'</h5>';
                                        }
                                      echo '<div class="for-detail-white-1">
                                          <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                                              <h4>'.$title.'</h4>
                                          </div>
                                          <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 ">
                                             '.$short_value.'
                                          </div>
                                      </div>';
                                  }
                                  $i++;
                                  $j++;
                              }
                          }
                          ?>
                        </div>
                      </div>
                    </section>
                  </div>
                  <?php 
                          $s++;
                        }
                    }
                    ?>
                </div>
              </div>
            </div>
          </div>
          <!-- -------------partner content-------------- -->
          <div class="tab-pane" id="tabs-2" role="tabpanel">
            <div class="panel-group" id="accordion2" role="tablist" aria-multiselectable="true">

              <div class="for-timelinr-user">
                <div class="wrapper">
                  <div class="center-line wow slideInRight ">
                    <a href="#" class="scroll-icon"><i class="fas fa-caret-up"></i></a>
                  </div>
          <?php 
          $iconArr = array('fas fa-heartbeat');
            if (isset($member_data['partners_field']) && !empty($member_data['partners_field'])) {

                foreach ($member_data['partners_field'] as $headingKey => $headingValue) { ?>
               <div class="row row-2">
                    <section class="wow bounceInUp" data-wow-duration="1s" data-wow-delay="0.1s">
                      <i class="icon <?php echo $iconArr[0];?>"></i>
                      <div class="details">
                        <span class="title"><?php echo $headingValue['name'];?></span>

                      </div>

                      <div class="row margin-top-10">
                        <div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">
                            <?php 
                                if (isset($member_data['partners_field'][$headingKey]['value']) && !empty($member_data['partners_field'][$headingKey]['value'])) {
                                    $totalFields = count($member_data['partners_field'][$headingKey]['value']); // total fileds in section 
                                    $showFieldsCount = (($totalFields - ($totalFields%2))/2) + ($totalFields%2); // how many fields show one side
                                    $i = $j = 0;
                                    foreach ($member_data['partners_field'][$headingKey]['value'] as $filedsValue) {
                                        $title = $value = '';
                                        $title = (isset($filedsValue['title']) && $filedsValue['title']!='')?$filedsValue['title']:'N/A';
                                        $value = (isset($filedsValue['value']) && $filedsValue['value']!='')?$filedsValue['value']:'N/A';
                                        // change length due to design issue start 25/11/2021
                                        $short_value = (isset($value) && $value!='' && strlen($value)>22)?substr($filedsValue['value'],0,18).'...':$value;
                                     // change length due to design issue end 25/11/2021
                                        $type = (isset($filedsValue['type']) && $filedsValue['type']!='')?$filedsValue['type']:'N/A';

                                        $style = $icon = '';
                                        if ($type == 'Yes') {
                                            $style="style='display: flex;justify-content: space-between;'";
                                            $icon = '<i class="fas fa-check-circle" style="color: #3db73f;"></i>';
                                        }

                                        if ($i==$showFieldsCount) { // set for second side
                                            echo '</div><div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">';
                                            $j = 0;
                                        }
                                        if ($j == 0 || $j%2==0){ // for grey section show
                                            echo '<div class="for-detail-gray-1">
                                                <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                                                    <h4>'.$title.'</h4>
                                                </div>
                                                <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 ">
                                                    <h5 '.$style.' title="'.$value.'">'.$short_value.$icon.'</h5>
                                                </div>
                                            </div>';
                                        }else{ // for white section show
                                           // change short value due to design issue start 25/11/2021
                                           echo '<div class="for-detail-white-1">
                                            <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1">
                                                <h4>'.$title.'</h4>
                                            </div>
                                            <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 ">
                                                <h5 '.$style.'>'.$short_value.$icon.'</h5>
                                            </div>
                                            </div>';
                                        // change short value due to design issue end 25/11/2021
                                        }
                                        $i++;
                                        $j++;
                                    }
                                }
                                ?>
                                    </div>
                      </div>
                    </section>
                  </div>
                <?php }
            }
            ?>
            </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- -----------------------profile details section end--------------- -->
    </div>
  </div>
</div>


<?php include_once('page_part/front_button_popup.php');
$this->common_model->js_extra_code_fr .= "
    new WOW().init();
    $(window).scroll(function() {
      var scroll = $(window).scrollTop(),
      dh = $(document).height(),
      wh = $(window).height();
      scrollPercent = (scroll / (dh - wh)) * 100;
      $('#line-progressbar').css('height', scrollPercent +'%');
    
    });
    profile_pic('".$member_data['matri_id']."');
    $(document).ready(function(){
      $('.commonAction').on('click',function(e){
        
          var action = $(this).attr('data-action');
          var oppid = $(this).attr('data-oppid');
          var curr = $(this).attr('data-curr');
          var arr = ['is_like','is_block','is_shortlist'];
          
          if(action!='' && action!=undefined && $.inArray(action,arr) !== -1 && oppid!='' && oppid!=undefined){
            
            var url;
            var formData = new FormData();
            var hash_tocken_id = $('#hash_tocken_id').val();
            var base_url = $('#base_url').val();
            formData.append('csrf_new_matrimonial', hash_tocken_id);
            if(action == 'is_like'){
                url = base_url+'search/member_like';
                formData.append('like_status', curr);
                formData.append('other_id', oppid);
                
            } else if(action == 'is_block'){
              if(curr == 0){
                url = base_url+'search/add_blocklist';
                formData.append('blockuserid', oppid);
              }else{
                url = base_url+'search/remove_blocklist';
                formData.append('unblockuserid', oppid);
              }
            } else if(action == 'is_shortlist'){
              if(curr == 0){
                url = base_url+'search/add_shortlist';
                formData.append('shortlistuserid', oppid);
              }else{
                url = base_url+'search/remove_shortlist';
                formData.append('shortlisteduserid', oppid);
              }
            }
            
            $.ajax({
                url: url,
                type: 'post',
                processData: false,
                contentType: false,
                data: formData,
                cache: false,
                success: function(data)
                {
                    var res = JSON.parse(data);
                    if(res.status == 'success'){

                        if(action == 'is_like'){
                          if(curr == 'Yes'){
                            $('#is_like i').attr('class','fas fa-thumbs-down');
                            $('#is_like').attr('data-curr', 'No');
                          }else{
                            $('#is_like i').attr('class','fas fa-thumbs-up');
                            $('#is_like').attr('data-curr', 'Yes');
                          }
                        } else if(action == 'is_block'){
                          if(curr == 0){
                            $('#is_block').next('p').text('Blocked');
                            $('#is_block').attr('data-curr', 1);
                            $('#is_member_block_'+oppid).val('1');
                            $('#is_block').parent().addClass('animate');
                          }else{
                            $('#is_block').next('p').text('Block');
                            $('#is_block').attr('data-curr', 0);
                            $('#is_member_block_'+oppid).val('');
                            $('#is_block').parent().removeClass('animate');
                          }
                        } else if(action == 'is_shortlist'){
                          if(curr == 0){
                            $('#is_shortlist').next('p').text('Shortlisted');
                            $('#is_shortlist').parent().addClass('animate');
                            $('#is_shortlist i').attr('class','fas fa-star');
                            $('#is_shortlist').attr('data-curr', 1);
                          }else{
                            $('#is_shortlist').next('p').text('Shortlist');
                            $('#is_shortlist').parent().removeClass('animate');
                            $('#is_shortlist i').attr('class','far fa-star');
                            $('#is_shortlist').attr('data-curr', 0);
                          }
                        }
                        $('#reponseMsg').removeClass('alert alert-danger');
                        $('#reponseMsg').addClass('alert alert-success');
                        $('#reponseMsg').html(res.errmessage);
                        $('#reponseMsg').show();
                        setTimeout(function(){ 
                          $('#reponseMsg').hide(); 
                        }, 3000);
                        return false;
                    }else{
                        $('#reponseMsg').removeClass('alert alert-success');
                        $('#reponseMsg').addClass('alert alert-danger');
                        $('#reponseMsg').html(res.errmessage);
                        $('#reponseMsg').show();
                        setTimeout(function(){ 
                          $('#reponseMsg').hide(); 
                        }, 3000);
                        return false;
                    }
                }
            });
          }
      });
    });
" ?>