<?php 
if (!empty($_POST)) {
    $_POST = array();
}
$cate_id = "";
$city_id = "";
$keyword_id="";

if($this->uri->segment('1') == 'vendor'){
    $string = $this->uri->segment('2');
    if (stripos($string, '-providers-in-') != false) {
        $types = explode('-providers-in-',$string);
        if (isset($types[0]) && $types[0]!='') {
            $cate_id = $this->common_model->valueFromId('vendor_category',$types[0],'id','slug');
        }
        if (isset($types[1]) && $types[1]!='') {
            $city_id = $this->common_model->valueFromId('city_master',$types[1],'id','city_name');
        }
    }else if (stripos($string, '-providers') != false) {
        $types = explode('-providers',$string);
        if (isset($types[0]) && $types[0]!='') {
            $cate_id = $this->common_model->valueFromId('vendor_category',$types[0],'id','slug');
        }
    }else{
        if (isset($string) && $string!='') {
            $city_id = $this->common_model->valueFromId('city_master',$string,'id','city_name');
        }
    }
}

if($cate_id!=''){
    $this->session->set_userdata('wed_category_id',$cate_id);
}
if($city_id!=''){
    $this->session->set_userdata('wed_city_id',$city_id);
}


if($this->session->userdata('wed_category_id')!=''){
    $cate_id = $this->session->userdata('wed_category_id');
}
if($cate_id==''){
    $vendor_category = $this->common_model->get_count_data_manual('vendor_category',array('status'=>'APPROVED','category_name'=>$this->uri->segment('3')),1,'*','','','');
    if(isset($vendor_category) && $vendor_category!=''){
        $cate_id = $vendor_category['id'];
    }
}
if($this->session->userdata('wed_city_id')!=''){
    $city_id = $this->session->userdata('wed_city_id');
}
if($this->session->userdata('wed_keyword')!=''){
    $keyword_id = $this->session->userdata('wed_keyword');
}
?>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Vendor List</span></p>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12 text-center"> 
                <div class="box-main-s">
                    <!-- <p class="Poppins-Semi-Bold mega-n3 f-s">Wedding Planner <span class="mega-n4 f-s">Listing</span></p> -->
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- new -->
<div class="container">
    <div class="row margin-top-20 margin-bottom-20">
        <!-- left side menu -->
        <div class="col-md-4 col-sm-12 col-xs-12">
            <form method="post" action="" name="search_category_wise" id="search_category_wise">
                <div class="wedding-planner-left">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-top-vendor">
                            <input type="text" name="keyword" value="<?php if(isset($keyword_id) && $keyword_id!=''){ echo $keyword_id;}?>" id="keyword" class="form-control ni-input-1" placeholder="Keywords">
                        </div>
                     </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select name="category_id" id="category_id" class="form-control dashbrd_cstm-left-menu new-matry-select-left-menu" >
                                <option value="">Select Categories</option>
                                <?php 
                                $cate_data = $this->common_model->get_count_data_manual('vendor_category',array('status'=>'APPROVED'),2,'*','category_position desc','');
                                if(isset($cate_data) && $cate_data!='' && is_array($cate_data) && count($cate_data)>0){
                                    foreach ($cate_data as $cate_val) {
                                        $seleted="";
                                        if($cate_id==$cate_val['id']){
                                            $seleted="selected";
                                        }
                                        echo '<option '.$seleted.' value="'.$cate_val['id'].'">'.$cate_val['category_name'].'</option>';
                                    }
                                }?>
                            </select>
                        </div>
                    </div> 

                     <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-top-vendor">
                            <select name="city_id" id="city_id" class="form-control dashbrd_cstm-left-menu new-matry-select-left-menu">
                                <option value="">Select City</option>
                                <?php 
                                $orderBy = 'city_name ASC';
                                if ($city_id!='') {
                                    $orderBy = 'FIELD(id, "'.$city_id.'") DESC, city_name ASC';
                                }
                                $city_data = $this->common_model->get_count_data_manual('city_master',array('status'=>'APPROVED'),2,'*',$orderBy,1,20);
                                //echo $this->db->last_query();exit;
                                if(isset($city_data) && $city_data!='' && is_array($city_data) && count($city_data)>0){
                                    foreach ($city_data as $city_val) {
                                        $seleted="";
                                        if($city_id==$city_val['id']){
                                            $seleted="selected";
                                        }
                                        echo '<option '.$seleted.' value="'.$city_val['id'].'">'.$city_val['city_name'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20">
                            <button type="submit" class="left-menu-search-btn"><i class="fas fa-search"></i> &nbsp; Search</button>
                        </div>
                     </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
            </form>
            <div class="row margin-top-20 margin-bottom-20 hidden-sm hidden-xs">
                <div class="col-md-12 col-sm-12 col-xs-12 ad-img-2">
                    <?php echo $this->common_model->display_advertise('Level 1','cate_data_list');?>
                </div>
            </div>
        </div>
        <!-- left side menu -->
        <!-- right side -->
        <div class="col-md-8 col-sm-12 col-xs-12">
            <div id="load_data"></div>
            <div id="cate_load_data_message"></div>
            <input type="hidden" name="cate_name" id="cate_name" value="<?php echo $this->uri->segment('3');?>">
        </div>
    </div>
</div>
<!-- new -->

<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function(){
    
    $('#city_id').select2();
    $('#category_id').select2();
    $('#select2-city_id-container').on('click',function(){
        var base_url = $('#base_url').val();
        var hash_tocken_id = $('#hash_tocken_id').val();
        $('#city_id').select2({
            ajax: {
                url: base_url+'wedding_vendor/get_ajax_city',
                type: 'post',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    
                    return {
                        csrf_new_matrimonial:hash_tocken_id,
                        searchTerm: params.term // search term
                    };
                },
                processResults: function (response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    });
        
    var limit = 5;
    var start = 0;
    var action = 'inactive';

    $('#search_category_wise').submit(function(){
        show_comm_mask();
        var form_data = $('#search_category_wise').serialize();
        $.ajax({
            url:'".base_url()."wedding-vendor/set-session',
            method:'POST',
            data:form_data,
            success:function(data){
                $('#cate_name').val('');
                var action = 'active';
                window.location.href = '".base_url()."wedding-vendor/wed-vendor-list';
                //load_data(limit, start);
                return false;
            }
        });
    });
    function lazzy_loader(limit)
    {
        var output = '';
        for(var count=0; count<limit; count++)
        {
            output += '<div class=\'row categories-main\'><p><span class=\'content-placeholder\' style=\'width:100%; height: 30px;\'>&nbsp;</span></p><p><span class=\'content-placeholder\' style=\'width:100%; height: 100px;\'>&nbsp;</span></p></div>';
        }
        $('#cate_load_data_message').html(output);
    }

    lazzy_loader(limit);


    function load_data(limit, start){
        var hash_tocken_id = $('#hash_tocken_id').val();
        var cate_name = $('#cate_name').val();
        var form_data = 'csrf_new_matrimonial='+hash_tocken_id+'&limit='+limit+'&start='+start+'&cate_name='+cate_name;
        show_comm_mask();
        $.ajax({
            url:'".base_url()."wedding-vendor/fetch-list',
            method:'POST',
            data:form_data,
            cache: false,
            dataType:'json',
            success:function(data){
                if(data == ''){
                    $('#cate_load_data_message').html('<div class=\'row mt-5\'><div class=\'col-sm-12 col-md-12 col-lg-12\'><div class=\'alert alert-danger\'><p>No More Result Found</p></div></div></div>');
                    action = 'active';
                }
                else
                {
                    $('#load_data').append(data);
                    $('#cate_load_data_message').html('');
                    action = 'inactive';
                }
                hide_comm_mask();
            }
        });
    }

    if(action == 'inactive'){
        action = 'active';
        load_data(limit, start);
    }

    // $(window).scroll(function(){
    //     if($(window).scrollTop() + $(window).height() > $('#load_data').height() && action == 'inactive'){
    //         lazzy_loader(limit);
    //         action = 'active';
    //         start = start + limit;
    //         setTimeout(function(){
    //             load_data(limit, start);
    //         }, 1000);
    //     }
    // });
});
";?>