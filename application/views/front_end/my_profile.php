<div class="main-new-profile-bg">
    <div class="container-fluid width-95 mt-60-pro">
        <?php include_once('my_profile_sidebar.php');?>
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php include_once('my_dashboard_info.php');?>
            <!-- -----------------------profile details section start--------------- -->
            <div class="my-profile-details" id="editProfile" style="display:none;"></div>
            <div class="my-profile-details" id="viewProfile">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Partner Preference</a>
                    </li>
                </ul><!-- Tab panes -->
                <?php /*
                    My view profile fields changes for api and web both are same in 
                    models/font_end/common_front_model method set_member_profile_data_category_wise
                    so you can and set fields there
                */?>
                <div class="tab-content">
                    <!-- --------my profile content------ -->
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <?php 
                        $iconArr = array('fas fa-user','fa fa-star','fas fa-info-circle','fas fa-school','fas fa-heartbeat','fa fa-map-marker','fas fa-home');
                        if (isset($member_data['fileds']) && !empty($member_data['fileds'])) {

                            // for remove photo array #start

                            // Php lower version issue start 25/11/2021
                            $minPHPVersion = '7.4.0';
                            if (phpversion() < $minPHPVersion)
                            {
                                if (isset($member_data['fileds'][key(end($member_data['fileds']))]) && !empty($member_data['fileds'][key(end($member_data['fileds']))])) {
                                    unset($member_data['fileds'][key(end($member_data['fileds']))]);
                                }
                            }
                            else
                            {
                                if (isset($member_data['fileds'][array_key_last($member_data['fileds'])]) && !empty($member_data['fileds'][array_key_last($member_data['fileds'])])) {
                                unset($member_data['fileds'][array_key_last($member_data['fileds'])]);
                                }
                            }
                            unset($minPHPVersion); 
                            // Php lower version issue end 25/11/2021
                           
                            // for remove photo array #end
                            $s = 0;
                            foreach ($member_data['fileds'] as $headingKey => $headingValue) { ?>
                            <div class="panel-group prforedit" id="accordion<?php echo $headingValue['id'];?>" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?php echo $headingValue['id'];?>">
                                        <h4 class="panel-title _ofh">
                                            <a role="button" class="short-text"title="<?php echo $headingValue['name'];?>" data-toggle="collapse" data-parent="#accordion<?php echo $headingValue['id'];?>" href="#collapse<?php echo $headingValue['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $headingValue['id'];?>">
                                                <i class="fas <?php if(isset($iconArr[$s])){ echo $iconArr[$s]; } else{ echo 'fas fa-user';}?>"></i> <?php echo $headingValue['name'];?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?php echo $headingValue['id'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $headingValue['id'];?>">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0"> <!-- set for first side -->
                                        <?php 
                                            if (isset($member_data['fileds'][$headingKey]['value']) && !empty($member_data['fileds'][$headingKey]['value'])) {
                                                $totalFields = count($member_data['fileds'][$headingKey]['value']); // total fileds in section 
                                                $showFieldsCount = (($totalFields - ($totalFields%2))/2) + ($totalFields%2); // how many fields show one side
                                                $i = $j = 0;
                                                foreach ($member_data['fileds'][$headingKey]['value'] as $filedsValue) {
                                                    $title = $value = '';
                                                    $title = (isset($filedsValue['title']) && $filedsValue['title']!='')?$filedsValue['title']:'N/A';
                                                    $value = (isset($filedsValue['value']) && $filedsValue['value']!='')?$filedsValue['value']:'N/A';

                                                    if ($i==$showFieldsCount) { // set for second side
                                                        echo '</div><div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">';
                                                        $j = 0;
                                                    }
                                                    if ($j == 0 || $j%2==0){ // for grey section show
                                                        echo '<div class="for-detail-gray-1">
                                                            <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1 _ofh">
                                                                <h4 class="short-text" title="'.$title.'">'.$title.'</h4>
                                                            </div>
                                                            <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 _ofh">
                                                                <h5 class="short-text" title="'.$value.'">'.$value.'</h5>
                                                            </div>
                                                        </div>';
                                                    }else{ // for white section show
                                                        echo '<div class="for-detail-white-1">
                                                            <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1 _ofh">
                                                                <h4 class="short-text" title="'.$title.'">'.$title.'</h4>
                                                            </div>
                                                            <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 _ofh">
                                                                <h5 class="short-text" title="'.$value.'">'.$value.'</h5>
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
                                        </div>
                                    </div>
                                    <div class="edit-pro-btn-g">
                                        <a href="<?php echo $base_url.'my-profile/edit-profile/'.$headingValue['id'];?>"><i class="fas fa-pen"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                    $s++;
                                }
                        }
                        ?>
                    </div>
                    <!-- -------------partner content-------------- -->
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                    <?php 
                        $iconArr = array('fas fa-user','fa fa-star','fa fa-map-marker','fas fa-school');
                        if (isset($member_data['partners_field']) && !empty($member_data['partners_field'])) {
                            $s = 0;
                            foreach ($member_data['partners_field'] as $headingKey => $headingValue) { ?>
                            <div class="panel-group prforedit" id="accordion<?php echo $headingValue['id'];?>" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?php echo $headingValue['id'];?>">
                                        <h4 class="panel-title">
                                            <a role="button" data-toggle="collapse" data-parent="#accordion<?php echo $headingValue['id'];?>" href="#collapse<?php echo $headingValue['id'];?>" aria-expanded="true" aria-controls="collapse<?php echo $headingValue['id'];?>">
                                                <i class="fas <?php if(isset($iconArr[$s])){ echo $iconArr[$s]; } else{ echo 'fas fa-user';}?>"></i> <?php echo $headingValue['name'];?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?php echo $headingValue['id'];?>" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading<?php echo $headingValue['id'];?>">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0"> <!-- set for first side -->
                                        <?php 
                                            if (isset($member_data['partners_field'][$headingKey]['value']) && !empty($member_data['partners_field'][$headingKey]['value'])) {
                                                $totalFields = count($member_data['partners_field'][$headingKey]['value']); // total fileds in section 
                                                $showFieldsCount = (($totalFields - ($totalFields%2))/2) + ($totalFields%2); // how many fields show one side
                                                $i = $j = 0;
                                                foreach ($member_data['partners_field'][$headingKey]['value'] as $filedsValue) {
                                                    $title = $value = '';
                                                    $title = (isset($filedsValue['title']) && $filedsValue['title']!='')?$filedsValue['title']:'N/A';
                                                    $value = (isset($filedsValue['value']) && $filedsValue['value']!='')?$filedsValue['value']:'N/A';

                                                    if ($i==$showFieldsCount) { // set for second side
                                                        echo '</div><div class="col-md-6 col-sm-12 col-xs-12 pl-0 pr-0">';
                                                        $j = 0;
                                                    }
                                                    if ($j == 0 || $j%2==0){ // for grey section show
                                                        echo '<div class="for-detail-gray-1">
                                                            <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1 _ofh">
                                                                <h4 class="short-text" title="'.$title.'">'.$title.'</h4>
                                                            </div>
                                                            <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 _ofh">
                                                                <h5 class="short-text" title="'.$value.'">'.$value.'</h5>
                                                            </div>
                                                        </div>';
                                                    }else{ // for white section show
                                                        echo '<div class="for-detail-white-1">
                                                            <div class="col-md-5 col-sm-12 col-xs-12 right-brd-1 _ofh">
                                                                <h4 class="short-text" title="'.$title.'">'.$title.'</h4>
                                                            </div>
                                                            <div class="col-md-7 col-sm-12 col-xs-12  right-brd-1 _ofh">
                                                                <h5 class="short-text" title="'.$value.'">'.$value.'</h5>
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
                                        </div>
                                    </div>
                                    <div class="edit-pro-btn-g">
                                        <a href="<?php echo $base_url.'my-profile/edit-profile/'.$headingValue['id'];?>"><i class="fas fa-pen"></i></a>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                    $s++;
                                }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-- -----------------------profile details section end--------------- -->
            
        </div>
    </div>
</div>
<?php $this->common_model->js_extra_code_fr .= "

    /*hide and show marri bro sis start*/
    function show_bro_details() {
        var brother = $('.no_of_brothers').val();	
        var opt = '';
        if(brother == '4 +') {
            brother = 5;
        }
        var base_url = $('#base_url').val();
        var hash_tocken_id = $('#hash_tocken_id').val();
        if(brother!='' && brother!='No') {
            $('#web_no_of_married_brother').show();
            $('#mob_no_of_married_brother').show();
            $.ajax({
                    url: base_url+'my_profile/married_brother_list',
                    type: 'post',
                    data: {
                        count_brother:brother,
                        csrf_new_matrimonial:hash_tocken_id
                    },
                    cache: false,
                    success: function(html) {
                        $('.no_of_married_brother').html('');
                        $('.mob_no_of_married_brother').html('');
                        $('.no_of_married_brother').show();
                        $('.mob_no_of_married_brother').show();
                        $('.no_of_married_brother').append(html);
                        $('.mob_no_of_married_brother').append(html);
                    }
                });
        } else{
            $('.no_of_married_brother').prop('selected', false);
            $('.mob_no_of_married_brother').prop('selected', false);
            $('#web_no_of_married_brother').hide();
            $('#mob_no_of_married_brother').hide();
        }
    }    
    function show_sis_details() {
        var sister = $('.no_of_sisters').val();	
        var opt = '';
        if(sister == '4 +'){
            sister = 5;
        }
        var base_url = $('#base_url').val();
        var hash_tocken_id = $('#hash_tocken_id').val();
        if(sister!='' && sister!='No') {
            $('#web_no_of_married_sister').show();
            $('#mob_no_of_married_sister').show();
            $.ajax({
				url: base_url+'my_profile/married_brother_list',
				type: 'post',
				data: {
					count_sister:sister,
					csrf_new_matrimonial:hash_tocken_id
				},
				cache: false,
				success: function(html){
					$('.no_of_married_sister').html('');
					$('.mob_no_of_married_sister').html('');
					$('.no_of_married_sister').show();
					$('.mob_no_of_married_sister').show();
					$('.no_of_married_sister').append(html);
					$('.mob_no_of_married_sister').append(html);
            	}
        	});
        } else{
            $('.no_of_married_sister').prop('selected', false);
            $('.mob_no_of_married_sister').prop('selected', false);
            $('#web_no_of_married_sister').hide();
            $('#mob_no_of_married_sister').hide();
        }
    }    
    /*hide and show marri bro sis End*/   

    $(document).ready(function(){
        
        $('#editProfile').on('click','#edit-back-btn',function(e){
            $('#editProfile').slideUp();
            $('#viewProfile').slideDown();
            var formStep = $('#formStep').val();
            scroll_to_div('collapse'+formStep);
            $('#editProfile').html('');
        });

        $('.edit-pro-btn-g').on('click',function(e){
            e.preventDefault();
            var url = $(this).find('a').attr('href');
            var hash_tocken_id = $('.hash_tocken_id').val();
            $.ajax({
                url: url,
                type: 'post',
                datatype: 'json',
                data: {
                    csrf_new_matrimonial:hash_tocken_id,
                    is_post:1
                },
                cache: false,
                success: function(data)
                {
                    var res = JSON.parse(data);
                    $('#editProfile').html(res.html);
                    $('#editProfile').slideDown();
                    $('#viewProfile').slideUp();
                    $('.select2').select2();    
                    $('.mega-select2').select2();    
                    scroll_to_div('editProfile');
                    
                    if(res.step == 'basic_info'){
                        $('#languages_known').select2({placeholder:'Select Language Known'});
                        display_total_childern();
                    } else if(res.step == 'edu_Occup'){
                        $('#education_detail').select2({placeholder:'Select Education'});
                    } else if(res.step == 'basic_partner_info'){
                        $('#looking_for').select2({placeholder:'Select Looking For'});
                        $('#part_complexion').select2({placeholder:'Select Skin Tone'});
                        $('#part_mother_tongue').select2({placeholder:'Select Mother Tongue'});
                        $('#part_bodytype').select2({placeholder:'Select Body type'});
                        $('#part_diet').select2({placeholder:'Select Eating Habit'});
                        $('#part_smoke').select2({placeholder:'Select Smoking Habit'});
                        $('#part_drink').select2({placeholder:'Select Drinking Habit'});
                    } else if(res.step == 'religion_partner_info'){
                        $('#part_religion').select2({placeholder:'Select Religion'});
                        $('#part_caste').select2({placeholder:'Select Caste'});
                        $('#part_star').select2({placeholder:'Select Star'});
                    } else if(res.step == 'location_partner_info'){
                        $('#part_country_living').select2({placeholder:'Select Country'});
                        $('#part_state').select2({placeholder:'Select State'});
                        $('#part_city').select2({placeholder:'Select City'});
                        $('#part_resi_status').select2({placeholder:'Select Residence'});
                    } else if(res.step == 'edu_occup_partner_info'){
                        $('#part_education').select2({placeholder:'Select Education'});
                        $('#part_employee_in').select2({placeholder:'Select Employed In'});
                        $('#part_occupation').select2({placeholder:'Select Occupation'});
                        $('#part_designation').select2({placeholder:'Select Designation'});
                    } else if(res.step == 'family_info'){
                        $('.no_of_married_brother').parent().attr('id','web_no_of_married_brother');
                        $('.mob_no_of_married_brother').parent().attr('id','mob_no_of_married_brother');
                        show_bro_details();
                        $('.no_of_married_sister').parent().attr('id','web_no_of_married_sister');
                        $('.mob_no_of_married_sister').parent().attr('id','mob_no_of_married_sister');
                        show_sis_details();
                    }

                    
                }
            });
        });
        $('#editProfile').on('click','#edit-save-btn',function(e){
            e.preventDefault();
            var url = $('#editFormId').attr('action');
            
            var hash_tocken_id = $('.hash_tocken_id').val();
            var formStep = $('#formStep').val();
            if(formStep == 'basic_partner_info'){
                var fromage = $('#part_frm_age option:selected').val();
                var toage = $('#part_to_age option:selected').val();
                totage =  toage - fromage;
                if(totage < 1)
                {
                    $('#reponse_editFormId').addClass('alert alert-danger');
                    $('#reponse_editFormId').html('<strong>Partner From Age</strong> is Always Less Than To <strong>Partner To Age</strong>.');
                    $('#reponse_editFormId').show();
                    stoptimeout();
                        starttimeout('#reponse_editFormId');
                    return false;
                }
                var partheight = $('#part_height option:selected').val();
                var partheightto = $('#part_height_to option:selected').val();
                height =  partheightto - partheight;
                if(height < 1)
                {
                    $('#reponse_editFormId').addClass('alert alert-danger');
                    $('#reponse_editFormId').html('<strong>Partner From Height</strong> is Always Less Than To <strong>Partner To Height</strong>.');
                    $('#reponse_editFormId').show();
                    stoptimeout();
                        starttimeout('#reponse_editFormId');
                    return false;
                }
            }

            //let res = /^[a-zA-Z]+$/.test('sfjd');
            if($('body').find('#editFormId').length > 0){
                if($('body').find('#editFormId').valid()){
                    var formData = new FormData($('#editFormId')[0]);
                    formData.append('csrf_new_matrimonial', hash_tocken_id);
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
                                $('#reponse_editFormId').removeClass('alert alert-danger');
                                $('#reponse_editFormId').addClass('alert alert-success');
                                $('#reponse_editFormId').html(res.errmessage);
                                $('#reponse_editFormId').show();
                                scroll_to_div('editProfile');
                                stoptimeout();
                                    starttimeout('#reponse_editFormId');
                                return false;
                            }else{
                                $('#reponse_editFormId').removeClass('alert alert-success');
                                $('#reponse_editFormId').addClass('alert alert-danger');
                                $('#reponse_editFormId').html(res.errmessage);
                                $('#reponse_editFormId').show();
                                scroll_to_div('editProfile');
                                stoptimeout();
                                    starttimeout('#reponse_editFormId');
                                return false;
                            }
                            
                        }
                    });
                }else{
                    return false;
                }
            }
        });
    });

    
    
        $(document).ready(function() {
            $('#datepicker-example22').Zebra_DatePicker();
        });
        $(document).ready(function() {
            $('#datepicker-example33').Zebra_DatePicker();
        });
        $(document).ready(function() {
            $('#datepicker-example44').Zebra_DatePicker();
        });
$('.tab-content select').select2();
$('.panel-group select').select2();
   // select2('#languages_known','Select Languages Known');
    
   "; ?>