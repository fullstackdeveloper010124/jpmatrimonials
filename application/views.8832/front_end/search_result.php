<?php
$member_front_search = $this->session->userdata('member_front_search');
$mega_user_data = $this->session->userdata('mega_user_data');
$search_filed_data = array();
if(isset($member_front_search['search_filed_data']) && $member_front_search['search_filed_data'] !='')
{
	$search_filed_data = $member_front_search['search_filed_data'];
}
$comm_model = $this->common_model; // reffrence store for sort syntax

if(!isset($member_total_count) || $member_total_count =='')
{
	$member_total_count = 0;
}
$is_login = $this->common_front_model->checkLogin('return');
$login_li = '';
if($is_login){
	$login_li = 'after-login-li';
}
?>
<div class="container new-width" style="width:93%;" >
    <div class="row">
        <div class="pg1">
	        <!-- web start-->
            <div class="col-lg-3 col-md-4 col-sm-12">
				<div class="left_sidebar-jodi">
					<div class="refine-search-main-box">
						<h1>Member Filter</h1>
					</div>
					<select class="form-control" style="height:35px;margin-top: 20px;width:92%;margin-left: 10px;margin-right: 10px;" name="search_order" id="search_order" onChange="change_sort()">
						<?php $search_order = 'latest_first';
						if(isset($_REQUEST['search_order']) && $_REQUEST['search_order'] !=''){
							$search_order = $_REQUEST['search_order'];
						}?>
						<option <?php if(isset($search_order) && $search_order=='latest_first'){echo 'selected';}?> value="latest_first" class="color-30">Latest First</option>
						<option <?php if(isset($search_order) && $search_order=='latest_last'){echo 'selected';}?> value="latest_last" class="color-65">Oldest First</option>
						<option <?php if(isset($search_order) && $search_order=='last_login_first'){echo 'selected';}?> value="last_login_first" class="color-65">Latest Login First</option>
						<option <?php if(isset($search_order) && $search_order=='last_login_last'){echo 'selected';}?> value="last_login_last" class="color-65">Last Login First</option>
					</select>
					
					<div class="mt-5">
						<?php include_once('search_result_filter.php');?>
					</div>
				</div>
			</div>
            <!-- web end -->
            
       
            
            <!-- =========== Member Filter Only Mobile View  ============= -->
            
            <div id="main_content_ajax">
				<?php include_once('search_result_member_profile.php');?>
            </div>
        </div>
    </div>
</div>
<div class="margin-bottom-20"></div>
<?php include_once('photo_protect.php'); ?>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id">

<?php 
	/*$session_data = $this->session->userdata('member_front_search');
	$gender = $this->common_front_model->get_session_data('gender');
	if(isset($session_data['search_filed_data']['gender']) && $session_data['search_filed_data']['gender']==$gender){
		$this->common_model->js_extra_code_fr .="
			//window.onload = refine_search();
		";
	}*/
?>
<?php
$this->common_model->js_extra_code_fr .="
	var rangeSlider = function(){
		var slider = $('.range-slider'),
		range = $('.range-slider__range'),
		value = $('.range-slider__value');
		slider.each(function(){
			value.each(function(){
				var value = $(this).prev().attr('value');
				$(this).html(value);
			});
			range.on('input', function(){
				$(this).next(value).html(this.value);
			});
		});
	};
	rangeSlider();
	
// Trigger
$(function () {
	var custom_values = ['4-2','4-3','4-4','4-5','4-6','4-7','4-8','4-9','4-10','4-11','5-0','5-1','5-2','5-3','5-4','5-5','5-6','5-7','5-8','5-9','5-10','5-11','6-0','6-1','6-2','6-3','6-4','6-5','6-6','6-7','6-8','6-9','6-10','6-11','7-0','7-1','7-2'];
    var from_height = $('#from_height').val();
	var to_height = $('#to_height').val();
    // be careful! FROM and TO should be index of values array	
    var my_from = custom_values.indexOf(cal(from_height));
    var my_to = custom_values.indexOf(cal(to_height));
	var range = $('.js-range-slider'), inputFrom = $('.js-input-from'), inputTo = $('.js-input-to'), instance, min = 4.0, max = 7.1, from = my_from, to = my_to;
	
	range.ionRangeSlider({
		type: 'float',
		prefix: '',
		onStart: updateInputs,
		onChange: updateInputs,
		prettify_enabled: true,
		prettify_separator: ',',
		values_separator: ' to ',
		force_edges: true,
		hide_min_max: true,
		keyboard: true,
		from:my_from,
		to:my_to,
		type: 'double',
		step: 0.1,
		postfix:' ft',
		decorate_both: true,
		values:custom_values,
		onFinish : function (data) {
			var frm_val = calculate_cm(data.from_value);
			var to_val  = calculate_cm(data.to_value);
			$('#from_height').val(frm_val);
			$('#to_height').val(to_val);
			refine_search();
		}
	});
	
	instance = range.data('ionRangeSlider');
	
	function updateInputs (data) {
		from = data.from;
		to = data.to;
		inputFrom.prop('value', from);
		inputTo.prop('value', to); 
	}
	
	inputFrom.on('input', function () {
		var val = $(this).prop('value');
		// validate
		if (val < min) {
			val = min;
			} else if (val > to) {
			val = to;
		}
		instance.update({
			from: val
		});
	});
	
	inputTo.on('input', function () {
		var val = $(this).prop('value');
		if (val < from) {
			val = from;
			} else if (val > max) {
			val = max;
		}
		instance.update({
			to: val
		});
	});
});
function cal(inch){
	var obj = { 50:'4-2', 51:'4-3', 52:'4-4', 53:'4-5', 54:'4-6', 55:'4-7', 56:'4-8', 57:'4-9', 58:'4-10', 59:'4-11', 60:'5-0', 61:'5-1', 62:'5-2', 63:'5-3', 64:'5-4', 65:'5-5', 66:'5-6', 67:'5-7', 68:'5-8', 69:'5-9', 70:'5-10', 71:'5-11', 72:'6-0', 73:'6-1', 74:'6-2', 75:'6-3', 76:'6-4', 77:'6-5', 78:'6-6', 79:'6-7', 80:'6-8', 81:'6-9', 82:'6-10', 83:'6-11', 84:'7-0', 85:'7-1', 86:'7-2' };
	var getProperty = function (propertyName) {
		return obj[propertyName];
	};
	return getProperty(inch);	
}
function calculate_cm(inch){
	var value = 0, num = inch, str = num.toString(), numarray = str.split('-'), a=new Array();
	if (numarray.length > 1) {
		a = numarray;
		value = parseInt(a[0]*12) + parseInt(a[1]);
	}
	else{
		value = parseInt(inch*12);
	}
	return value;
}

$(function () {
	var range = $('.js-range-slider-2'), inputFrom = $('.js-input-from-2'), inputTo = $('.js-input-to-2'), instance, min = 18, max = 65, from = 0, to = 0;
	
	var from_age = $('#from_age').val();
	var to_age = $('#to_age').val();
	
	range.ionRangeSlider({
		type: 'double',
		min: min,
		max: max,
		from: from_age,
		to: to_age,
		postfix:'<span></span>',
		onStart: updateInputs,
		onChange: updateInputs,
		step:1,
		prettify_enabled: true,
		prettify_separator: '',
		values_separator: ' - ',
		force_edges: true,
		onFinish : function (data) {
			$('#from_age').val(data.from);
			$('#to_age').val(data.to);
			refine_search();
		}
	});
	
	instance = range.data('ionRangeSlider');
	
	function updateInputs (data) {
		from = data.from;
		to = data.to;
		
		inputFrom.prop('value', from);
		inputTo.prop('value', to); 
	}
	
	inputFrom.on('input', function () {
		var val = $(this).prop('value');
		// validate
		if (val < min) {
			val = min;
			} else if (val > to) {
			val = to;
		}
		instance.update({
			from: val
		});
	});
	
	inputTo.on('input', function () {
		var val = $(this).prop('value');
		if (val < from) {
			val = from;
			} else if (val > max) {
			val = max;
		}
		instance.update({
			to: val
		});
	});
});
$('.panel-collapse').on('show.bs.collapse', function () {
	$(this).siblings('.panel-heading').addClass('active');
});

$('.panel-collapse').on('hide.bs.collapse', function () {
	$(this).siblings('.panel-heading').removeClass('active');
});
";?>