<div class="list-group pt-2 pb-4 mt-3 clearfix hidden-lg hidden-md">
    <div class="tab contact-tab-m contact-tab-vendor" role="tabpanel">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs new-matrimony-tab contact-tab-nav" role="tablist">
            <?php if(isset($is_login) && $is_login!=1){?>
                <li role="presentation" class="f-16 active">
                    <a href="#register-section-m" aria-controls="register-section-m" role="tab" data-toggle="tab" aria-expanded="true" style="margin-right: 30px !important;">
                    Register Free</a>
                </li>
                <li role="presentation" class="f-16">
                    <a href="#search-section-m" aria-controls="search-section-m" role="tab" data-toggle="tab" aria-expanded="false" style="margin-right: 30px !important;">
                    Search</a>
                </li>
            <?php }else{?>
				<li role="presentation" class="active f-16">
                    <a href="#search-section-m" aria-controls="search-section-m" role="tab" data-toggle="tab" aria-expanded="false" style="margin-right: 30px !important;">
                    Search</a>
                </li>
			<?php }?>
        </ul>
        <!-- Tab panes -->
    </div>
    <hr class="hr-marimony">
    
    <div class="tab-content tabs">
        <div role="tabpanel" class="tab-pane fade <?php if(isset($is_login) && $is_login!=1){?>in active<?php }?>" id="register-section-m">
            <form method="post" id="home_register_form1" name="home_register_form1" action="<?php echo $base_url;?>register">
				<?php if($this->session->flashdata('error_message')){?>
                    <div class="alert alert-danger"><?php
                        echo $this->session->flashdata('error_message'); ?>
                    </div>
                <?php }?>
                <div class="age_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">First Name:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" class="form-control ni-input" name="firstname" id="firstname" required placeholder="First Name">
                        </div>
                    </div>
                </div>
                <div class="height_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Last Name:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="text" class="form-control ni-input" name="lastname" id="lastname" required placeholder="Last Name">
                        </div>
                    </div>
                </div>
                <div class="email_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Email Address:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="email" required id="email" name="email" class="form-control ni-input" placeholder="Email Address">
                            <input type="hidden" name="email_varifired" id="email_varifired" value="0" />
                        </div>
                    </div>
                </div>
                <div class="religion_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Password:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <input type="password" name="password" id="password" required class="form-control ni-input" placeholder="Password">
                        </div>
                    </div>
                </div>
            
                <div class="Mobile_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Mobile Number:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-4 col-sm-4 col-xs-4">
                            <div class="select_box3">
                                <select name="country_code" id="country_code" class="form-control dashbrd_cstm new-matry-select new-matry-select-w" required>
                                    <!--<option value="">Select Country Code</option>-->
                                    <?php echo $this->common_model->country_code_opt($val);?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <input type="text" required name="mobile_number" id="mobile_number" minlength="7" maxlength="13"  class="form-control ni-input" placeholder="Mobile Number">
                        </div>
                    </div>
                </div>
                <div class="gender_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Gender:</label>
                    </div>
                    <div class="row-cstm">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="select_box5">
                                <select name="gender" id="gender" class="form-control dashbrd_cstm dshbrd_100 new-matry-select" required>
                                    <option value=""> Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                        <input type="hidden" name="id" id="id" value="" />
                        <input type="hidden" name="mode" id="mode" value="add" />
                        <input type="hidden" name="status_front_page" id="status_front_page" value="Yes" />
                        <button type="submit" class="dshbrd_21 Poppins-Medium f-16 color-f w-100"> <i class="fas fa-user-edit"></i> Register</button>
                    </div>
                </div>
	        </form>
        </div>        
        <div role="tabpanel" class="tab-pane fade <?php if(isset($is_login) && $is_login!=1){}else{echo 'in active';}?>" id="search-section-m">            
            <form action="<?php echo base_url();?>search/search_now" method="post">
                <?php if(isset($is_login) && $is_login!=1){?>
                     <div class="age_dshbrd">
                        <div class="row-cstm">
                            <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Gender:</label>
                        </div>
                        <div class="row-cstm">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="add-input">
                                    <div class="md-radio" onclick="add_gender_class('male')">
                                        <input id="1" type="radio" name="gender" value="Male" checked>
                                        <label for="1" class="Poppins-Medium default-color color-d" id="male_id">Male</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <div class="add-input">
                                    <div class="md-radio" onclick="add_gender_class('female')">
                                        <input id="2" type="radio" name="gender" value="Female">
                                        <label for="2" class="default-color" id="female_id">Female</label>
                                    </div>
                                </div>
                            </div>
                		</div>
            		</div>
                <?php }?>
                <div class="age_dshbrd">
                    <div class="row-cstm">
                        <label class="list-group-item dshbrd_100 f-normal Poppins-Medium f-16 color-38 dashbrd_3">Age:</label>
                    </div>
                    
                    <div class="row-cstm">
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="select_box3">
                                <select name="from_age" class="form-control dashbrd_cstm" data-validetta="required">
                                    <option value="">From</option>
                                    <?php echo $this->common_model->array_optionstr($this->common_model->age_rang(),18);?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <p class="Poppins-Regular f-16 color-3c dshbrd_to">To</p>
                        </div>
                        
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="select_box4 dshbrd_pr">
                                <select class="form-control dashbrd_cstm" name="to_age" data-validetta="required">
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
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="select_box3">
                                <select name="from_height" class="form-control dashbrd_cstm" data-validetta="required">
                                    <option value="">From</option>
                                    <?php echo $this->common_model->array_optionstr($this->common_model->height_list());?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <p class="Poppins-Regular f-16 color-3c dshbrd_to">To</p>
                        </div>
                        
                        <div class="col-md-5 col-sm-5 col-xs-5">
                            <div class="select_box4 dshbrd_pr">
                                <select name="to_height" class="form-control dashbrd_cstm" data-validetta="required">
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
                            <div class="select_box5">
                                <select class="form-control dashbrd_cstm dshbrd_100" data-validetta="required" id="search_religions" name="religion[]">
                                    <?php echo $this->common_model->array_optionstr($this->common_model->dropdown_array_table('religion'));?>
                                </select>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="custom-control custom-checkbox mtm-0 w-102">
                            <input type="checkbox" class="custom-control-input" id="customCheck1_63" value="photo_search" name="photo_search">
                            <label class="dshbrd_cstm-control mt-3 Poppins-Regular" for="customCheck1_63">
                                <span class="t1 Poppins-Regular f-13 color-65">With Photo</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                        <button type="submit" class="dshbrd_21 Poppins-Medium f-16 color-f"> <i class="fas fa-search"></i> Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->common_model->js_extra_code_fr.='
if($("#home_register_form1").length > 0){
    $("#home_register_form1").validate({
        rules: {
            firstname: {
				required: true,
				lettersonly: true
			},
			lastname: {
				required: true,
				lettersonly: true
			},
			mobile_number: {
            	required: true,
            	number: true
            },
        },
        submitHandler: function(form){
            var mobile_number = $("#mobile_number").val();
            if(mobile_number !=""){
                var isnum = /^\d+$/.test(mobile_number);
                if(!isnum){
                    alert("Please enter valid number only");
                    $("#mobile_number").val("");
                    $("#mobile_number").focus();
                    return false;
                }
            }
            var form_data = $("#home_register_form1").serialize();
            form_data = form_data+ "&is_post=0";
            var base_url = $("#base_url").val();
            var action = base_url+"register/check_duplicate";
            
            show_comm_mask();
            $.ajax({
				url: action,
				type: "post",
				dataType:"json",
				data: form_data,
				success:function(data){
                    $("#reponse_message_step1").removeClass("alert alert-danger");
                    $("#reponse_message_step1").html(data.errmessage);
                    $("#reponse_message_step1").slideDown();
                    update_tocken(data.tocken);
                    hide_comm_mask();
                    
                    if(data.status == "success"){
                        
                        $("#reponse_message_step1").html("");
                        form.submit(); 
                    }
                    else{
                        $("#reponse_message_step1").addClass("alert alert-danger");
                    }
            	}
            });
            return false;
        }
    });
}
$("#search_religions").chosen();';
?>