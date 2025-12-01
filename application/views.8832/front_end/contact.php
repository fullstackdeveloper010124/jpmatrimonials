<!-- <div class="contact-tab"> -->
    <div class="container-fluid new-width">
        <div class="row">
            <div class="col-md-12">
                <div class="tab contact-tab-m" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs contact-tab-nav" role="tablist">
                        <li role="presentation" class="active contact-tab-margin f-17">
                            <a href="#conatct-section" aria-controls="conatct-section" role="tab" data-toggle="tab">
                            <i class="fas fa-phone"></i>
                            Contact Us
                            </a>
                        </li>
                        <li role="presentation" class="f-17">
                            <a href="#enquery-section" aria-controls="enquery-section" role="tab" data-toggle="tab">
                                <i class="fas fa-comment-dots icon-dot"></i>
                                 Enquiry / Feedback</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container new-width">
    <div class="mega-conatct-box-new mt-5 pb-5">
        <div class="tab-content tabs">
            <div role="tabpanel" class="tab-pane fade in active" id="conatct-section">
            <p class="calibri-Bold-font  f-22 color-31 c-tab-t2 hidden-sm hidden-xs">Address</p>
                <p class="Poppins-Regular f-12 color-65  c-tab-t1 hidden-sm hidden-xs">
                    At <?php if(isset($config_data['web_frienly_name']) && $config_data['web_frienly_name']!='') {echo $config_data['web_frienly_name'];}?>, we are always striving to better your experience.</p>
               
                <div class="address-map-box">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="c1-add">
                            <?php if(isset($contact_data['page_content']) && $contact_data['page_content'] !=''){
                                echo $contact_data['page_content'];
                            }
                            else{
                                echo 'No Data Available';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="n-map">
                            <iframe src="<?php echo $config_data['map_address']; ?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="enquery-section">
            <h1 class="calibri-Bold-font f-22 color-31  ab-t1">All fields are
                                    <span class="color-d">mandatory</span></h2>
                <p class="Poppins-Regular f-12 color-65  c-tab-t1 hidden-sm hidden-xs">
                    Please feel free to post your questions, comments and suggestions. We are eager to assist you and serve you better.</p>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="mega-box-new add-box-cstm b-shadow-none padding-0">
                            <div class="m-add-box">
                               
                                    <div class="add-box-2">
                                    <div class="alert alert-success" id="email_success_message"  style="display:none"></div>
                                    <div class="alert alert-danger" id="email_error_message" style="display:none"></div>
                                    <form action="<?php echo $base_url;?>contact/submit-contact" method="post" id="contact_form" name="contact_form">
                                        <div class="row add-b-cstm">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <p class="Poppins-Medium f-16 color-31 ad-name">Name <span class="f-16 select2-lbl-span">* </span>:</p>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="add-input">
                                                    <input type="text" class="form-control ni-input" placeholder="Enter Your Name" id="name" name="name" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-b-cstm mt-4">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <p class="Poppins-Medium f-16 color-31 ad-name">Email <span class="f-16 select2-lbl-span">* </span>:</p>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="add-input">
                                                    <input type="email" class="form-control ni-input" placeholder="Enter Your Email" name="email" id="email" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-b-cstm mt-4">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <p class="Poppins-Medium f-16 color-31 ad-name">Contact No <span class="f-16 select2-lbl-span">* </span>:</p>
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <select class="mdb-select md-form md-outline colorful-select dropdown-primary ni-input2 tst_box mn_12" name="country_code" id="country_code">
                                                    <?php echo $this->common_model->country_code_opt($val);?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="add-input">
                                                    <input type="text" class="form-control ni-input" placeholder="Enter Your Contact Number" id="phone" name="phone" required minlength="7" maxlength="13">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-b-cstm mt-4">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <p class="Poppins-Medium f-16 color-31 ad-name">Subject <span class="f-16 select2-lbl-span">* </span>:</p>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="add-input">
                                                    <input type="text" class="form-control ni-input" name="subject" id="subject" required placeholder="Enter Your Subject Related To">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row add-b-cstm mt-4">
                                            <div class="col-md-4 col-sm-4 col-xs-12">
                                                <p class="Poppins-Medium f-16 color-31 ad-name">Feedback <span class="f-16 select2-lbl-span">* </span>:</p>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="add-input">
                                                    <textarea class="form-control ni-input" placeholder="Post your questions, comments and suggestions" rows="8" name="description" id="description" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-b-cstm mt-4">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12 enquery_captcha" style="right: 10px;">
                                                <!--<div class="m-captcha-code wi-100"><p class="color-f Poppins-Medium f-18">675645</p></div>-->
                                                <img src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_contact']; ?>" alt="captcha code" />
                                                
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="add-input">
                                                    <input type="number" name="code_captcha" id="code_captcha" class="form-control ni-input" placeholder="Enter Captcha Code" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row add-b-cstm mt-5">
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                <div class="add-ad-btn"> <h2>
                                                    <div class="Poppins-Medium color-f f-18"><button type="submit" class="add-w-btn">Submit</button></div>
                                                     <h2>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="is_post" id="is_post" value="1"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$htpp_web = 'http';
if(strpos(base_url(),'https') === false){	
}
else{
    $htpp_web = 'https';
}
?>

<script src="<?php echo $htpp_web; ?>://maps.googleapis.com/maps/api/js?key=AIzaSyD6t-g9fBSGMizPRdrrycQ2K7XDIP2csz8"></script>
<?php
$this->common_model->js_extra_code_fr.="

    $(document).ready(function(){
        $('#googleMap').gMap({
            maptype: 'ROADMAP',
            scrollwheel: false,
            zoom: 13,
            markers: [
                {
                    address: '".trim($config_data['map_address'])."',
                    html: '".$config_data['map_tooltip']."',
                    popup: true,
                }
            ],
        });
    });


if($('#contact_form').length > 0)
{
    $('#contact_form').validate({
        rules: {
            name: {
              required: true,
              lettersonly: true
            },
            subject: {
              required: true,
              lettersonly: true
            },
            phone: {
              required: true,
              number: true
            }
         },	
        submitHandler: function(form)
        {
            //return true;
            submit_contact_us();
        }
    });
}
function submit_contact_us()
{
    var name = $('#name').val();
    var email = $('#email').val();
    var phone = $('#phone').val();
    var country_code = $('#country_code').val();
    var subject = $('#subject').val();
    var description = $('#description').val();
    var code_captcha = $('#code_captcha').val();
    show_comm_mask();
    var hash_tocken_id = $('#hash_tocken_id').val();
    var base_url = $('#base_url').val();
    var url = base_url+'contact/submit-contact';
    $('#email_success_message').hide();
    $('#email_error_message').hide();
    $.ajax({
       url: url,
       type: 'post',
       data: {'name':name,'email':email,'phone':phone,'subject':subject,'description':description,'".$this->security->get_csrf_token_name()."':hash_tocken_id,'is_post':0,'code_captcha':code_captcha,'country_code':country_code},
       dataType:'json',
       success:function(data)
       {
           $('#hash_tocken_id').val(data.token);
            if(data.status == 'success')
            {
                $('#email_success_message').html(data.errmessage);
                $('#email_success_message').slideDown();
                form_reset('contact_form');
            }
            else
            {
                $('#email_error_message').html(data.errmessage);
                $('#email_error_message').slideDown();
            }
            scroll_to_div('contact_form');
            hide_comm_mask();
       }
    });
    return false;
} ";
?>