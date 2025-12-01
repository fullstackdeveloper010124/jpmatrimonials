<!-- new -->
<div class="container hidden-lg hidden-md">
	<div class="row margin-top-20 margin-bottom-20">
        <div class="col-md-12 col-sm-12 col-xs-12">
           	<div class="matrimony-member-main">
           		<h2><a href="<?php echo $base_url;?>/login" class="white-color">Safinaz Matrimony</a></h2>
           	</div>
		</div>
	</div>
	<div id="load_data"></div>
	<div class="container">
		<div id="cate_load_data_message"></div>
	</div>
</div>

<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function(){
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

    function load_data(limit, start){
    	var hash_tocken_id = $('#hash_tocken_id').val();
    	show_comm_mask();
	    $.ajax({
	        url:'".base_url()."wedding_vendor/fetch_cate',
	        method:'POST',
	        data:{'csrf_new_matrimonial':hash_tocken_id,limit:limit, start:start},
	        cache: false,
	        dataType:'json',
	        success:function(data){
				if(data == ''){
            		$('#cate_load_data_message').html('<div class=\'row\'><dv class=\'col-sm-12 col-md-12 col-lg-12\'><div class=\'alert alert-danger\'><p>No More Result Found</p></div></dv></div>');
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

    $(window).scroll(function(){
     	if($(window).scrollTop() + $(window).height() > $('#load_data').height() && action == 'inactive'){
        	lazzy_loader(limit);
        	action = 'active';
        	start = start + limit;
        	setTimeout(function(){
          		load_data(limit, start);
        	}, 1000);
      	}
    });
});
";?>