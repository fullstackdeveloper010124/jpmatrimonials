<?php 
$cate_id = "";
$city_id = "";
$keyword_id="";
if($this->session->userdata('wed_category_id')!=''){
    echo $cate_id = $this->session->userdata('wed_category_id').' ';
}
if($this->session->userdata('wed_city_id')!=''){
    echo $city_id = $this->session->userdata('wed_city_id');
}
if($this->session->userdata('wed_keyword')!=''){
    $keyword_id = $this->session->userdata('wed_keyword');
}
?>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-3 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Vendor List</span></p>
                </div>
            </div>
            <div class="col-md-8 col-sm-12 col-xs-12 text-center"> 
                <!-- <div class="box-main-s">
                    <p class="Poppins-Semi-Bold mega-n3 f-s">Wedding Planner <span class="mega-n4 f-s">Listing</span></p>
                </div> -->
				<div class="row">
					<form name="vendor_search" id="vendor_search" method="post">
						<div class="col-md-3 col-sm-12 col-xs-12 margin-top-vendor">
							<input type="text" name="keyword" value="<?php if(isset($keyword_id) && $keyword_id!=''){ echo $keyword_id; }?>" id="keyword" class="form-control ni-input-1" placeholder="Keywords">
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12 ">
							<select name="category_id" id="category_id" class="form-control dashbrd_cstm-left-menu new-matry-select-left-menu">
								<option value="">Select Categories</option>
								<?php 
								echo $cate_id;
								$cate_data = $this->common_model->get_count_data_manual('vendor_category',array('status'=>'APPROVED'),2,'*','category_name DESC','');
								if(isset($cate_data) && $cate_data!='' && is_array($cate_data) && count($cate_data)>0){
									foreach ($cate_data as $cate_val) {
										$seleted="";
										if($cate_id==$cate_val['id']){
											$seleted="selected";
										}
										echo '<option data-slug="'.$cate_val['slug'].'" '.$seleted.' value="'.$cate_val['id'].'">'.$cate_val['category_name'].'</option>';
									}
								}?>
							</select>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12  margin-top-vendor">
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
						<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
						<input type="hidden" name="is_category" value="Yes"/>
						<div class="col-md-3 col-sm-12 col-xs-12 margin-top-vendor">
							<button type="button" id="vendor-search-btn" class="left-menu-search-btn"><i class="fas fa-search"></i> &nbsp; Search</button>
						</div>
					</form>
				</div>
            </div>
        </div>
		
    </div>
</div>
<!-- new -->
<div class="container">
	<div id="load_data"></div>
	<div id="cate_load_data_message"></div>
</div>
<!-- new -->
<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function(){
	$('#city_id').select2({
		placeholder: 'Select City'
	});
	$('#category_id').select2({
		placeholder: 'Select Categories'
	});
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
	
    

    var limit = 8;
    var start = 0;
    var action = 'inactive';

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

	// function show_comm_mask_vendor()
    // {
	// 	$('#load_data').append('<div id=\'vendorloader\'><img alt=\'Please wait..\' title=\'Please wait..\' src=\'".base_url()."assets/front_end/images/loading.gif\' style=\'height:40px\'></div>');
    // }
	// function hide_comm_mask_vendor()
    // {
	// 	$('#vendorloader').remove();
    // }

    function load_data(limit, start){
    	var hash_tocken_id = $('#hash_tocken_id').val();
    	show_comm_mask();
	    $.ajax({
	        url:'".base_url()."wedding_vendor/fetch',
	        method:'POST',
	        data:{'csrf_new_matrimonial':hash_tocken_id,limit:limit, start:start},
	        cache: false,
	        dataType:'json',
	        success:function(data){
				if(data == ''){
            		$('#cate_load_data_message').html('<div class=\'row mt-5\'><div class=\"col-sm-12 col-md-12 col-lg-12\"></div></div>');
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
    //  	if($(window).scrollTop() + $(window).height() > $('#load_data').height() && action == 'inactive'){
    //     	lazzy_loader(limit);
    //     	action = 'active';
    //     	start = start + limit;
    //     	setTimeout(function(){
    //       		load_data(limit, start);
    //     	}, 1000);
    //   	}
    // });

	$('#vendor-search-btn').click(function(){
		var city_id,city_name,category_name,category_id;
		city_id = $('#city_id').val();
		if(city_id!='' && city_id!=undefined){
			city_name = $('#city_id option:selected').text();
		}
		category_id = $('#category_id').val();
		if(category_id!='' && category_id!=undefined){
			category_name = $('#category_id option:selected').data('slug');
		}
		
		formdata = $('#vendor_search').serialize();
		show_comm_mask();
		$.ajax({
			url:'".base_url()."wedding_vendor/set_session',
			method:'POST',
			data:formdata,
			cache: false,
			dataType:'json',
			success:function(data){
				hide_comm_mask();
				if(category_name!='' && category_name!=undefined && city_name!='' && city_name!=undefined){
					window.location.href='".base_url()."vendor/'+category_name+'-providers-in-'+city_name.toLowerCase();
				}else if(category_name!='' && category_name!=undefined){
					window.location.href='".base_url()."vendor/'+category_name+'-providers';
				}else if(city_name!='' && city_name!=undefined){
					window.location.href='".base_url()."vendor/'+city_name.toLowerCase();
				}else{
					window.location.href='".base_url()."wedding_vendor/wed_vendor_list/';
				}
			}
		});
	});
});
";?>