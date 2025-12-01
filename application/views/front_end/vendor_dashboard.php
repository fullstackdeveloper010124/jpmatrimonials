
<?php 
  $vendorId = $this->common_front_model->get_vendor_session_data('id');
  if(isset($vendorId) && $vendorId != '' )
  {
      $row_data = $this->common_model->get_count_data_manual('wedding_planner',['id'=>$vendorId,'is_deleted'=>'No'],1);
      if(isset($row_data) && $row_data !='' && count($row_data) > 0)
      {
          $this->common_front_model->edit_row_data = $row_data;
          $this->common_model->edit_row_data = $row_data;
          $this->common_model->mode= 'edit';
          $this->common_front_model->mode= 'edit';

         $plan_status = $row_data['plan_status'];   
      }
      $paymentData = $this->common_model->get_count_data_manual('vendor_payments',['vendor_id'=>$vendorId,'is_deleted'=>'No','current_plan' =>'Yes'],1);
      if(!empty($paymentData)){
        $planExpired = $paymentData['plan_expired'];
      }
    }  
    $today_date = $this->common_model->getCurrentDate('Y-m-d');
    
    $photoArr = [
      'image'=>$row_data['image'],
      'image_2'=>$row_data['image_2'],
      'image_3'=>$row_data['image_3'],
      'image_4'=>$row_data['image_4'],
    ];

?>
<input type="hidden" name="vendor_id" id="vendor_id" value="<?= $vendorId ?>">
<section class="business-info-section">
    <div class="container">
      <div class="info-common-title">
        <h2>Business information</h2>
        <p>Provide accurate details about your wedding business. This information will appear on your public profile to help engaged couples learn more about your services and contact you easily</p>
      </div>
      <div class="reponse_message" style="margin-top: 10px;"></div>
      <div class="information-details-main">
        <div class="single-information-details">
          <a class="btn-information-title" data-toggle="collapse" data-parent="#accordion" href="#business-info-1">
            <span><i class="fas fa-info-circle"></i>Basic Details</span>
          </a>
          <div id="business-info-1" class="panel-collapse collapse">

          <form method="post" id="register_step1" name="register_step1" action="<?php echo $base_url; ?>vendor/save-register-step/step1">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
              <input type="hidden" name="is_post" value="1" />
              <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
            <div class="profile-information-body">            
              <div class="row">
                <?php 
                  $ele_array = array(
                      'category_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('vendor_category'),'label'=>'Services provided','class'=>'js-example-basic-single mega-select2'),  
                      'title'=>array('is_required'=>'required','label'=>'Name of the business','class'=>'form-control reg_input'),                  
                  );
                  echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                
                ?>
                </div>
              <div class="row mt-4">
                <?php 
                  $ele_array = array(
                      'planner_name'=>array('is_required'=>'required','label'=>'Name of the business','class'=>'form-control reg_input'),                  
                  );
                  echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                
                ?>
                </div>  
                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="btn-group-info">
                      <button class="btn-save-publish fts-14 submitRegisterbtn" data-formId='1'>Save and Publish</button>
                      <button class="btn-canceled-btn" data-toggle="collapse" data-target="#business-info-1" aria-expanded="true" aria-controls="business-info-1">Cancel</button>
                    </div>
                  </div>
              </div>   
            </div>
          </form>

          </div>
        </div>
        <div class="single-information-details">
          <a class="btn-information-title" data-toggle="collapse" data-parent="#accordion" href="#business-info-2">
            <span><i class="fas fa-map-marker-alt"></i>Address</span>
          </a>
          <div id="business-info-2" class="panel-collapse collapse">
          <form method="post" id="register_step2" name="register_step2" action="<?php echo $base_url; ?>vendor/save-register-step/step2">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
            <input type="hidden" name="is_post" value="1" />
            <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
            <div class="profile-information-body">             
              <div class="row">
                  <?php 
                    $ele_array = array(
                        'country_id'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>$this->common_model->dropdown_array_table('country_master'),'label'=>'Country','class'=>'js-example-basic-single mega-select2','onchange'=>"dropdownChange('country_id','state_id','state_list')"),
                        'state_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'state_master','key_val'=>'id','key_disp'=>'state_name','not_load_add'=>'yes','cus_rel_col_name'=>'country_id'),'label'=>'State','class'=>'select2','onchange'=>"dropdownChange('state_id','city_id','city_list')"),
                    );
                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                  
                  ?>
              </div>
              <div class="row mt-4">
                  <?php 
                    $ele_array = array(
                        'city_id'=>array('is_required'=>'required','type'=>'dropdown','relation'=>array('rel_table'=>'city_master','key_val'=>'id','key_disp'=>'city_name','not_load_add'=>'yes','cus_rel_col_name'=>'state_id'),'label'=>'City','class'=>'select2'),
                        'address'=>array('is_required'=>'required','type'=>'textarea','label'=>'Address','class'=>'form-control reg_input'),  
                    );
                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                  
                  ?>
              </div>
              <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="btn-group-info">
                      <button class="btn-save-publish fts-14 submitRegisterbtn" data-formId='2'>Save and Publish</button>
                      <button class="btn-canceled-btn" data-toggle="collapse" data-target="#business-info-2" aria-expanded="true" aria-controls="business-info-2">Cancel</button>
                    </div>
                  </div>
              </div>                     
            </div>
          </form>
          </div>
        </div>
        <div class="single-information-details">
          <a class="btn-information-title" data-toggle="collapse" data-parent="#accordion" href="#business-info-3">
            <span><i class="fas fa-hashtag"></i>Social Media Link</span>
          </a>
          <div id="business-info-3" class="panel-collapse collapse">
            <form method="post" id="register_step3" name="register_step3" action="<?php echo $base_url; ?>vendor/save-register-step/step3">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
              <input type="hidden" name="is_post" value="1" />
              <input type="hidden" name="base_url" id="base_url" value="<?php echo $base_url; ?>" />
            <div class="profile-information-body">             
              <div class="row">
                  <?php 
                    $ele_array = array(
                        'website'=>array('input_type'=>'search','label'=>'Website','class'=>'form-control reg_input'),  
                        'facebook_link'=>array('input_type'=>'search','label'=>'Facebook Link','class'=>'form-control reg_input'),  
                    );
                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                  
                  ?>
              </div>
              <div class="row mt-4">
                  <?php 
                    $ele_array = array(
                        'twitter_link'=>array('input_type'=>'search','label'=>'Twitter Link','class'=>'form-control reg_input'),  
                        'linkedin_link'=>array('input_type'=>'search','label'=>'Linkedin Link','class'=>'form-control reg_input'),  
                    );
                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                  
                  ?>
              </div>
              <div class="row mt-4">
                  <?php 
                    $ele_array = array(
                        'google_link'=>array('input_type'=>'search','label'=>'Google Link','class'=>'form-control reg_input'),                          
                    );
                    echo $this->common_front_model->generate_common_front_form($ele_array,array('page_type'=>'register'));                  
                  ?>
              </div>
              <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="btn-group-info">
                      <button class="btn-save-publish fts-14 submitRegisterbtn" data-formId='3'>Save and Publish</button>
                      <button class="btn-canceled-btn" data-toggle="collapse" data-target="#business-info-3" aria-expanded="true" aria-controls="business-info-3">Cancel</button>
                    </div>
                  </div>
              </div>   
            </div>
              </form>
          </div>
        </div>
      </div>

      <?php 
      if ($plan_status !== 'Paid' || (isset($planExpired) && $planExpired < $today_date)) {
      ?>
        <div class="discover-bar-mainbox mt-5">
          <div class="upgrade-discover-box mt-3">
            <h4>You need to upgrade your membership to upload photos to your business profile.</h4>
            <p class="mt-2">This feature is available with an active Plus Plan. Renew or upgrade your plan to continue.</p>
            <a href="<?php echo base_url()?>vendor-payment-option" class="btn-upgrade-access mt-3">Upgrade Now</a>
          </div>
        </div>
      <?php 
      }else{
      ?>
      <div class="single-information-details">
        <div class="inner-photoupload-box">
          <h4 class="photo-titles">Upload Photo</h4>
          <div class="wedding-photos-upload" data-url="<?php echo base_url() ?>vendor-upload-photos">
            <div class="upload__box mt-3">
                <div class="upload__btn-box">
                  <label class="upload__btn">
                    <p class="upload-select-btn"><i class="fas fa-images"></i>Upload photos</p>                    
                    <input type="file" class="upload__inputfile" data-max_length="4" name="vendor_photos[]" multiple>
                  </label>
                </div>
                <div class="upload__img-wrap d-flex flex-wrap">
                  <?php 
                    if(!empty($photoArr)){
                      $photoPath = $this->common_model->path_wedding; 
                      $photoUrl  = base_url().$photoPath;  
                        foreach($photoArr as $key => $photo){
                          if (!empty($photo) && file_exists($photoPath . $photo)) {
                                $fullUrl = $photoUrl . $photo;
                        ?>
                          <div class="upload__img-box">
                              <div class="upload__img-close" 
                                data-filename="<?= htmlspecialchars($photo) ?>" 
                                data-id="<?= htmlspecialchars($photo) ?>" 
                                data-url="<?= base_url().'vendor-delete-photos' ?>"
                                data-key="<?= htmlspecialchars($key) ?>" 
                                ></div>
                              <div class="img-bg" style="background-image: url('<?= $fullUrl ?>')"></div>
                          </div>
                      <?php 
                          }
                          }
                        }
                      ?>
                </div>
            </div>
            <!-- <div class="row mt-4">
                <div class="col-md-12">
                  <div class="btn-group-info">
                    <button class="btn-save-publish fts-14 upload-photo-btn">Save and Publish</button>                  
                  </div>
                </div>
            </div>  -->
          </div>

        </div>
      </div>
       <?php 
          }
        ?>
    </div>
  </section>

