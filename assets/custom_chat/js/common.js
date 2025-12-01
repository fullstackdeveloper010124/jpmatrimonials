var is_reload_page=0;
function scroll_to_div(div_id)
{
	$('html, body').animate({scrollTop: $('#'+div_id).offset().top -100 }, 'slow');
}

function remove_element(element,timout)
{
	timout = typeof timout !== 'undefined' ? timout : 10000;
	setTimeout(function(){ $(element).remove(); }, timout);
}
function check_all()
{
	$(".checkbox_val").prop("checked",$("#all").prop("checked"));
}
function check_all_exp(all_cls,cls_chk)
{
	$("."+cls_chk).prop("checked",$("."+all_cls).prop("checked"));
}
function check_uncheck_all()
{
	var total_checked = $('input[name="checkbox_val[]"]:checked').length;
	var total = $('input[name="checkbox_val[]"]').length;
	if(total ==total_checked){
		$("#all").prop("checked",true);
	}
	else{
		$("#all").prop("checked",false);
	}
}
function search_change_limit()
{
	get_ajax_search(1);
	return false;
}
function change_order(coloumn_name,order)
{
	$("#default_order").val(order);
	$("#default_sort").val(coloumn_name);
	get_ajax_search(1);
}
function change_sort_order(order_col)
{
	if(order_col !=''){
		var order_arr = order_col.split('-');
		if(order_arr[0] !='' && order_arr[1] !='')
		{
			change_order(order_arr[0],order_arr[1]);
		}
	}
}
function get_ajax_search(page_number)
{
	var base_url = $("#base_url_ajax").val();
	var page_url = base_url + page_number;
	if(page_number == "" || page_number == 0 ||  base_url =='')
	{
		alert("Some issue arise please refress page.");
		return false;
	}
	curr_page_number = page_number;
	var limit_per_page = $("#limit_per_page").val();
	var search_filed = $("#search_filed").val();
	var hash_tocken_id = $("#hash_tocken_id").val();
	var default_sort = $("#default_sort").val();
	var default_order = $("#default_order").val();
	var status_mode = $("#status_mode").val();
	
	show_comm_mask();
	$.ajax({
	   url: page_url,
	   type: "post",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'search_filed':search_filed,'limit_per_page':limit_per_page,'default_order':default_order,'default_sort':default_sort,'status_mode':status_mode},
	   success:function(data){
			$("#main_content_ajax").html(data);
			hide_comm_mask();
			load_pagination_code();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id_temp").val());
			$("#hash_tocken_id_temp").remove();
			/*$("#hash_tocken_id").val($("#hash_tocken_id_temp").val());*/
			is_reload_page = 0;
	   }
	});
	return false;
}

function update_status(status_update)
{
	if(status_update =='')
	{
		alert('Somthing wrong, Please refress page and try again.')
		return false;
	}
	var total_checked = $('input[name="checkbox_val[]"]:checked').length;
	if(total_checked == 0 || total_checked =='')
	{
		alert("Please select at least one record to process");
		return false;
	}
	if(status_update =='DELETE')
	{
		if(!confirm("Are you sure to delete the record?"))
		{
			return false;
		}
	}
	var selected_val = Array();
	var i=0;
	$('input[name="checkbox_val[]"]:checked').each(function() 
	{
		selected_val[i] = this.value;
		i++;
	});

	var page_number = 1;
	var base_url = $("#base_url_ajax").val();
	var page_url = base_url + page_number;
	if(page_number == "" || page_number == 0 ||  base_url =='')
	{
		alert("Some issue arise please refress page.");
		return false;
	}
	curr_page_number = page_number;
	var limit_per_page = $("#limit_per_page").val();
	var search_filed = $("#search_filed").val();
	var hash_tocken_id = $("#hash_tocken_id").val();
	var default_sort = $("#default_sort").val();
	var default_order = $("#default_order").val();
	var status_mode = $("#status_mode").val();
	
	show_comm_mask();
	$.ajax({
	   url: page_url,
	   type: "post",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'search_filed':search_filed,'limit_per_page':limit_per_page,'default_order':default_order,'default_sort':default_sort,'status_mode':status_mode,'selected_val':selected_val,'status_update':status_update},
	   success:function(data){
			$("#main_content_ajax").html(data);
			hide_comm_mask();
			load_pagination_code();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id_temp").val());
			$("#hash_tocken_id_temp").remove();
			/*$("#hash_tocken_id").val($("#hash_tocken_id_temp").val());*/
	   }
	});
	return false;
}
function update_tocken(tocken)
{
	$(".hash_tocken_id").each(function()
	{
	   $(this).val(tocken);
	})
}
function change_sort(){
	var search_order = $("#search_order").val();
	get_data_ajax(1,'',search_order);
}
function change_sort_mob(){
	var search_order = $("#search_order_mob").val();
	get_data_ajax(1,'',search_order);
}
function get_data_ajax(page_number,url_load,search_order){
	show_comm_mask();
	var hash_tocken_id = $("#hash_tocken_id").val();
	if(search_order==''){
		var search_order = $("#search_order").val();
	}
	if(url_load == ''){
		var base_url = $("#base_url").val();
		url_load = base_url+ 'search/result';
	}
	$.ajax({
	   url: url_load,
	   type: "post",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'page_number':page_number,'is_ajax':1,'search_order':search_order},
	   success:function(data)
	   {
			$("#main_content_ajax").html(data);
			hide_comm_mask();
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken(hash_tocken_id);					
			$("#hash_tocken_id_temp").remove();
	   }
	});
}
function load_pagination_code_front_end()
{	
   $("#ajax_pagin_ul li a").click(function()
   {
		var url_load = $(this).attr("href");
		url_load = typeof url_load !== 'undefined' ? url_load : '';
		var page_number = $(this).attr("data-ci-pagination-page");
		
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(url_load == '#' || url_load == '' && page_number)
		{
			return false;
		}
		if(page_number != undefined && page_number !='' && page_number != 0 && url_load !='')
		{
			if($("#exp_status").length > 0)
			{
				get_express_intrest_data(page_number);
			}
			else
			{
				get_data_ajax(page_number,url_load);
			}
		}
		return false;
   });
}
function load_pagination_code_community()
{	
	$("#ajax_pagin_ul li a").click(function()
	{
		var url_load = $(this).attr("href");
		url_load = typeof url_load !== 'undefined' ? url_load : '';
		var page_number = $(this).attr("data-ci-pagination-page");
		var gender = 'Female';
		
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(url_load == '#' || url_load == '' && page_number)
		{
			return false;
		}
		if(page_number != undefined && page_number !='' && page_number != 0 && url_load !='')
		{
			get_data_ajax_community(page_number,url_load,gender);
		}
		return false;
	});
	$("#ajax_pagin_ul_male li a").click(function()
	{
		var url_load = $(this).attr("href");
		url_load = typeof url_load !== 'undefined' ? url_load : '';
		var page_number = $(this).attr("data-ci-pagination-page");
		var gender = 'Male';
		
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(url_load == '#' || url_load == '' && page_number)
		{
			return false;
		}
		if(page_number != undefined && page_number !='' && page_number != 0 && url_load !='')
		{
			get_data_ajax_community(page_number,url_load,gender);
		}
		return false;
	});
}
function get_data_ajax_community(page_number,url_load,gender)
{
	show_comm_mask();
	var hash_tocken_id = $("#hash_tocken_id").val();
	var search_order = $("#search_order").val();
	if(url_load == '')
	{
		var base_url = $("#base_url").val();
		url_load = base_url+ 'search/result';
	}
	$.ajax({
	   url: url_load,
	   type: "post",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'page_number':page_number,'is_ajax':1,'data_divide':gender},
	   success:function(data)
	   {
			if(gender!='' && gender=='Female')
			{
				$("#Female-user").html(data);
				hide_comm_mask();
				load_pagination_code_community();
				scroll_to_div("Female-user");
			}
			else
			{
				$("#Male-user").html(data);
				hide_comm_mask();
				load_pagination_code_community();
				scroll_to_div("Male-user");
			}
			update_tocken($("#hash_tocken_id_temp").val());					
			$("#hash_tocken_id_temp").remove();
	   }
	});
}
function load_pagination_code()
{	
   $("#ajax_pagin_ul li a").click(function()
   {
		var page_number = $(this).attr("data-ci-pagination-page");
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(page_number == 0)
		{
			return false;
		}
		if(page_number != undefined && page_number !='' && page_number != 0)
		{
			get_ajax_search(page_number);
		}
		return false;
   });
   load_checkbo();
}
function form_reset(form_id)
{
	var elemet_not_resest = new Array();
	var i = 0;
	$('.not_reset').each(function() 
	{
		elemet_not_resest[i] = this.value;
		i++;
	});
	document.getElementById(form_id).reset();
	i = 0;
	$('.not_reset').each(function()
	{
		this.value = elemet_not_resest[i];
		i++;
	});
}
function dropdownChange_mul(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("#"+currnet_id).val();
	if(currnet_val !='' && currnet_val !=null)
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val,'multivar':'multi','tocken_val':1},
		   success:function(data)
		   {
				$("#"+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				$('#'+disp_on).trigger('chosen:updated');
				hide_comm_mask();
				if(get_list == 'state_list')
				{
					if($("#part_state").val()==null || $("#part_state").val()==''){
						$("#part_state").val([1316,1303,1302,1289,3932]);
		        		$("#part_state").select2().trigger("change");
		        	}
					if($(".city_list_update").length > 0)
					{
						$(".city_list_update").html('');
						$('.city_list_update').trigger('chosen:updated');
						$('#part_city').val('').trigger("change");
					}
				}
				if(get_list =='city_list')
				{
					if($(".city_list_update").val()==null || $("#part_city").val()==''){
						$(".city_list_update").val([997014,986108,980093,987151,991638,993690,996424,996404,991650,1014186,982658,1014187,998121,1014509,991578,994441,998010,979445,992187,1013946,980140,995287,987660]);
		        		$(".city_list_update").select2().trigger("change");
		        	}
				}
		   	}
		});
	}
	else
	{
		$("#"+disp_on).html('');
		$('#'+disp_on).trigger('chosen:updated');
		if(get_list =='state_list')
		{
			if($(".city_list_update").length > 0)
			{
				$(".city_list_update").html('');
				$('.city_list_update').trigger('chosen:updated');
				$('#part_city').val('').trigger("change");
			}
		}
	}
}
function othercity_change_reg(currnet_id){
	var currnet_val = $("#"+currnet_id).val();
	if(currnet_val=='Other'){
		$('.other_city_display').show();
		$('#other_city_display').show();
	}
	else{
		$('.other_city_display').hide();
		$('.other_city_name').val("");
		$('.other_city').val("");
		$('#other_city_display').hide();
		$('#other_city_name').val("");
		$('#other_city').val("");
	}
}
function other_edu_change_reg(display_name,currnet_id){
	var currnet_val = $("#"+currnet_id).val();
	if(currnet_val!=null){
		var n = currnet_val.includes("Other");
		if(n==true){
			$('#other_'+display_name+'_display').show();
		}
		else{
			$('#other_'+display_name+'_display').hide();
			$('#other_'+display_name+'_name').val("");
			$('#other_'+display_name).val("");
		}
	}
	else{
		$('#other_'+display_name+'_display').hide();
		$('#other_'+display_name+'_name').val("");
		$('#other_'+display_name).val("");
	}
}
function other_edu_change_pro_mob(display_name,currnet_id){
	var currnet_val = $("."+currnet_id+"_mob").val();
	if(currnet_val!=null){
		var n = currnet_val.includes("Other");
		if(n==true){
			$('.other_'+display_name+'_display_mob').show();
		}
		else{
			$('.other_'+display_name+'_display_mob').hide();
			$('.other_'+display_name+'_name_mob').val("");
			$('.other_'+display_name+'_mob').val("");
		}
	}else{
		$('.other_'+display_name+'_display_mob').hide();
		$('.other_'+display_name+'_name_mob').val("");
		$('.other_'+display_name+'_mob').val("");
	}
}
function other_change_reg(display_name,currnet_id){
	var currnet_val = $("#"+currnet_id).val();
	if(currnet_val=='Other'){
		$('#other_'+display_name+'_display').show();
	}
	else{
		$('#other_'+display_name+'_display').hide();
		$('#other_'+display_name+'_name').val("");
		$('#other_'+display_name).val("");
	}
}
function other_change_pro(display_name,currnet_id){
	var currnet_val = $("#"+currnet_id).val();
	if(currnet_val=='Other'){
		$('.other_'+display_name+'_display').show();
	}
	else{
		$('.other_'+display_name+'_display').hide();
		$('.other_'+display_name+'_name').val("");
		$('.other_'+display_name).val("");
	}
}

function other_change_pro_mob(display_name,currnet_id){
	var currnet_val = $("."+currnet_id+"_mob").val();
	if(currnet_val=='Other'){
		$('.other_'+display_name+'_display_mob').show();
	}
	else{
		$('.other_'+display_name+'_display_mob').hide();
		$('.other_'+display_name+'_name_mob').val("");
		$('.other_'+display_name+"_mob").val("");
	}
}
function dropdownChange_reg(currnet_id,disp_on,get_list,id_val,yes_no)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("#"+currnet_id).val();
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
			success:function(data)
			{
				$("#"+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(currnet_val=='Other'){
					if(get_list == 'caste_list')
					{
						if(id_val==''){
							$('#other_caste_display').hide();
							$('#other_caste_name').val("");
							$('#other_caste').val("");
						}
						var yes_no = $('#other_caste').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('#caste option:selected').removeAttr('selected');
							}
							$('#caste option[value=Other]').prop('selected', 'selected');
		    				$('#caste').val('Other').trigger('change');
		    			}
					}
					if(get_list == 'state_list')
					{
						if(id_val==''){
							$('#other_state_display').hide();
							$('#other_state_name').val("");
							$('#other_state').val("");
							$('#other_city_display').hide();
							$('#other_city_name').val("");
							$('#other_city').val("");
						}
						var yes_no = $('#other_state').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('#state_id option:selected').removeAttr('selected');
							}
							$('#state_id option[value=Other]').prop('selected', 'selected');
		    				$('#state_id').val('Other').trigger('change');
		    			}
					}
					if(get_list == 'city_list')
					{
						if(id_val==''){
							$('#other_city_display').hide();
							$('#other_city_name').val("");
							$('#other_city').val("");
						}
						var yes_no = $('#other_city').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('#city option:selected').removeAttr('selected');
							}
							$('#city option[value=Other]').prop('selected', 'selected');
		    				$('#city').val('Other').trigger('change');
		    			}
					}
				}
				if(currnet_val=='Other'){
					if(currnet_id=='country_id'){
						$('#other_country_display').show();
					}
					if(currnet_id=='state_id'){
						$('#other_state_display').show();
					}
					if(currnet_id=='religion'){
						$('#other_religion_display').show();
					}
				}else if(currnet_val!='Other'){
					if(currnet_id=='country_id'){
						$('#other_country_display').hide();
						$('#other_state_display').hide();
						$('#other_city_display').hide();
						$('#other_country_name').val("");
						$('#other_state_name').val("");
						$('#other_city_name').val("");
						$('#other_country').val("");
						$('#other_state').val("");
						$('#other_city').val("");
					}
					if(currnet_id=='state_id'){
						$('#other_state_display').hide();
						$('#other_city_display').hide();
						$('#other_state_name').val("");
						$('#other_city_name').val("");
						$('#other_state').val("");
						$('#other_city').val("");
					}
					if(currnet_id=='religion'){
						
						$('#other_religion_display').hide();
						$('#other_religion_name').val("");
						$('#other_religion').val("");
						$('#other_caste_display').hide();
						$('#other_caste_name').val("");
						$('#other_caste').val("");
					}
				}

				if(get_list == 'state_list')
				{
					if($("#city").length > 0)
					{
						$("#city").html('<option value="">Select City</option>');
					}
				}
		   	}
		});
	}
	else
	{
		$("#"+disp_on).html('<option value="">Select Option First</option>');
		if(get_list =='state_list')
		{
			if($("#city").length > 0)
			{
				$("#city").html('<option value="">Select City</option>');
			}
		}
	}
}
function dropdownChange_reg_mob(currnet_id,disp_on,get_list,id_val,yes_no)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id+"_mob").val();
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
			success:function(data)
			{
				$("."+disp_on+"_mob").html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(currnet_val=='Other'){
					if(get_list == 'caste_list')
					{
						if(id_val==''){
							$('.other_caste_display_mob').hide();
							$('.other_caste_name_mob').val("");
							$('.other_caste_mob').val("");
						}
						var yes_no = $('.other_caste_mob').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('.caste_mob option:selected').removeAttr('selected');
							}
							$('.caste_mob option[value=Other]').prop('selected', 'selected');
		    				$('.caste_mob').val('Other').trigger('change');
		    			}
					}
					if(get_list == 'state_list')
					{
						if(id_val==''){
							$('.other_state_display_mob').hide();
							$('.other_state_name_mob').val("");
							$('.other_state_mob').val("");
							$('.other_city_display_mob').hide();
							$('.other_city_name_mob').val("");
							$('.other_city_mob').val("");
						}
						var yes_no = $('.other_state_mob').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('.state_id_update option:selected').removeAttr('selected');
							}
							$('.state_id_update option[value=Other]').prop('selected', 'selected');
		    				$('.state_id_update').val('Other').trigger('change');
		    			}
					}
					if(get_list == 'city_list')
					{
		    			if(id_val==''){
							$('.other_city_display_mob').hide();
							$('.other_city_name_mob').val("");
							$('.other_city_mob').val("");
						}
						var yes_no = $('.other_city_mob').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('.city_update_mob option:selected').removeAttr('selected');
							}
							$('.city_update_mob option[value=Other]').prop('selected', 'selected');
		    				$('.city_update_mob').val('Other').trigger('change');
		    			}
					}
				}
				if(currnet_val=='Other'){
					if(currnet_id=='religion'){
						$('.other_religion_display_mob').show();
					}
					if(currnet_id=='country_id_update'){
						$('.other_country_display_mob').show();
					}
					if(currnet_id=='state_id_update'){
						$('.other_state_display_mob').show();
					}
				}else if(currnet_val!='Other'){

					if(currnet_id=='country_id_update'){
						$('.other_country_display_mob').hide();
						$('.other_state_display_mob').hide();
						$('.other_city_display_mob').hide();
						$('.other_country_name_mob').val("");
						$('.other_state_name_mob').val("");
						$('.other_city_name_mob').val("");
						$('.other_country_mob').val("");
						$('.other_state_mob').val("");
						$('.other_city_mob').val("");
					}
					if(currnet_id=='state_id_update'){
						$('.other_state_display_mob').hide();
						$('.other_city_display_mob').hide();
						$('.other_state_name_mob').val("");
						$('.other_city_name_mob').val("");
						$('.other_state_mob').val("");
						$('.other_city_mob').val("");
					}
					if(currnet_id=='religion'){
						$('.other_religion_display_mob').hide();
						$('.other_religion_name_mob').val("");
						$('.other_religion_mob').val("");
						$('.other_caste_display_mob').hide();
						$('.other_caste_name_mob').val("");
						$('.other_caste_mob').val("");
					}
				}
				if(get_list =='state_list')
				{
					if($(".city_update").length > 0)
					{
						$(".city_update").html('<option value="">Select City</option>');
					}
				}
		   	}
		});
	}
}
function dropdownChange(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("#"+currnet_id).val();
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
			success:function(data)
			{
				$("#"+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(get_list == 'caste_list'){
					if($("#part_caste").val()==null || $("#part_caste").val()==''){
						$("#part_caste").val($("#caste_id_temp").val());
		        		$("#part_caste").select2().trigger("change");
		        	}
				}
				if(get_list == 'state_list')
				{
					if($("#city").length > 0)
					{
						$("#city").html('<option value="">Select City</option>');
					}
				}
		   	}
		});
	}
	else
	{
		$("#"+disp_on).html('<option value="">Select Option First</option>');
		if(get_list =='state_list')
		{
			if($("#city").length > 0)
			{
				$("#city").html('<option value="">Select City</option>');
			}
		}
	}
}

function select2(list_id,label)
{
	$(list_id).select2({
 		placeholder: label
	});
}
function get_suggestion_list(list_id,label)
{
	var base_url = $("#base_url").val();
	var action = base_url+ 'common_request/get_list_select2';
	var hash_tocken_id = $("#hash_tocken_id").val();
	$('#'+list_id).select2({
	 placeholder: label,
	  ajax: {
		url: action,
		type: "POST",
		dataType:'json',
		data: function (params) {
		  return {
			q: params.term, // search term
			page: params.page,
			csrf_new_matrimonial: hash_tocken_id,
			list_id:list_id
		  };
		},
	  }
	});
}

var numDays = {
	'01': 31, '02': 28, '03': 31, '04': 30, '05': 31, '06': 30, 
    '07': 31, '08': 31, '09': 30, '10': 31, '11': 30, '12': 31
};

function setDays(oMonthSel, oDaysSel, oYearSel)
{ 
	var nDays, oDaysSelLgth, opt, i = 1;
	nDays = numDays[oMonthSel[oMonthSel.selectedIndex].value]; 
	if (nDays == 28 && oYearSel[oYearSel.selectedIndex].value % 4 == 0) 
		++nDays; 
	oDaysSelLgth = oDaysSel.length; 
	if (nDays != oDaysSelLgth)
	{ 
		if (nDays < oDaysSelLgth) 
			oDaysSel.length = nDays; 
		else for (i; i < nDays - oDaysSelLgth + 1; i++)
		{ 
			opt = new Option(oDaysSelLgth + i, oDaysSelLgth + i); 
                  	oDaysSel.options[oDaysSel.length] = opt;
		} 
	}
	var oForm = oMonthSel.form;
	var month = oMonthSel.options[oMonthSel.selectedIndex].value;
	var day = oDaysSel.options[oDaysSel.selectedIndex].value;
	var year = oYearSel.options[oYearSel.selectedIndex].value;	
	//oForm.datepicker.value = year + '-' + month + '-' + day;
}

function setDate_day(num_days)
	{
		var b_date = $("#birth_date").val();
		//alert(b_date);
		var html_days = '<option value="" selected="">Day</option>';
		if(num_days !='' && num_days > 0)
		{
			for(var ij = 1;ij<=num_days;ij++)
			{
				var sell_date = '';
				if(b_date !='' && b_date == ij)
				{
					sell_date = 'selected';
				}
				html_days+= '<option '+ sell_date +' value="'+ij+'">'+ij+'</option>';
			}
			$("#birth_date").html(html_days);
		}
	}
	function month_year_change()
	{
		var m_date = $("#birth_month").val();
		var y_date = $("#birth_year").val();
		//alert(m_date);
		//alert(y_date);
		var num_days = '';
		var update_date_ddr = 0;
		if(m_date !='')
		{
			num_days = numDays[m_date];
			if(num_days !='')
			{
				if(y_date !='' && y_date > 0 && y_date % 4 == 0 && num_days == 28)
				{
					num_days = 29;
				}
				setDate_day(num_days);
			}
		}
		//alert(num_days);
		return false;
	}

var temp_value_duplicate ='';
function check_duplicate(id_field,check_on)
{
	var id = $("#id").val();
	var mode = $("#mode").val();
	var field_value = $("#"+id_field).val();
	if(id_field === "mobile")
	{
		var country_code = $("#country_code").val();
		var mobile_number = $("#mobile_number").val();
		field_value = country_code+'-'+mobile_number;
	}
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var page_url = base_url+ 'common_request/check_duplicate';
	if(id_field !='' && check_on !=''&& field_value !='' && mode !='' && temp_value_duplicate != field_value)
	{
		$.ajax({
		   url: page_url,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'id':id,'mode':mode,'field_value':field_value,'field_name':id_field,'check_on':check_on},
		   success:function(data)
		   {
				if(data.status == 'success')
				{
					if(id_field === "mobile"){
						id_field = 'mobile_number';
					}
					if($("#" + id_field+'-error').length == 0) 
					{
						$( "#"+ id_field ).after( '<label id="'+id_field+'-error" class="error" for="'+id_field+'"></label>' );
					}
					
					$("#"+id_field+'-error').text('Duplicate value found, please enter another one');
					$("#"+id_field+'-error').show();
					$("#"+id_field).addClass('error');
					var varifired_filed_val = 0;
					return false;
				}
				else
				{
					if($("#" + id_field+'-error').length > 0) 
					{
						$("#"+id_field+'-error').hide();
					}
					$("#"+id_field).removeClass('error');
					var varifired_filed_val = 1;
				}
				if($("#" + id_field+'_varifired').length > 0) 
				{
					$("#"+id_field+'_varifired').val(varifired_filed_val);
				}
				update_tocken(data.tocken);
		   }
		});
	}
	return false;
}

var myVar;
function stoptimeout() {
    clearTimeout(myVar);
}
function starttimeout(selected_target) {
    myVar = setTimeout(function(){ $(selected_target).slideUp(); }, 6000);
}

function common_ajax_request(form_id)
{
	var form_data = $('#'+form_id).serialize();
	form_data = form_data+ '&is_post=0';
	var action = $('#'+form_id).attr('action');
	if(action !='')
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: 'post',
		   dataType:'json',
		   data: form_data,
		   success:function(data)
		   {
				update_tocken(data.tocken);
				$('#reponse_'+form_id).removeClass('alert alert-success alert-danger alert-warning');
				$('#reponse_'+form_id).html(data.errmessage);
				$('#reponse_'+form_id).slideDown();
				scroll_to_div('reponse_'+form_id);
				hide_comm_mask();
				if(data.status == 'success')
				{
					$('#reponse_'+form_id).addClass('alert alert-success');
					stoptimeout();
					starttimeout('#reponse_'+form_id);
					// for matchmaking get data after update match detail
					if( form_id !='' && form_id =='match_making_form')
					{
						var base_url = $("#base_url").val();
						var page_url = base_url+ 'matches/search-now/';
						get_data_ajax(1,page_url);
					}
					// for matchmaking get data after update match detail
				}
				else
				{
					$('#reponse_'+form_id).addClass('alert alert-danger');
					stoptimeout();
					starttimeout('#reponse_'+form_id);
				}
		   }
		});
	}
}
function select_all_checkbox(class_name) {
	$("."+class_name).prop("checked",true);1
	if(class_name=='country'){
		getlist_onchange('country','state');
	}
	if(class_name=='religion'){
		getlist_onchange('religion','caste');
	}
	refine_search();
}
function mob_select_all_checkbox(class_name) {
	$("."+class_name).prop("checked",true);
	if(class_name=='country'){
		getlist_onchange('country','state');
	}
	if(class_name=='religion'){
		getlist_onchange('religion','caste');
	}
	refine_search_mobile();
}
function clear_refine(class_reset)
{
	if(class_reset !='' && (class_reset =='age' || class_reset =='height'))
	{
		$('.'+class_reset).val('');
	}
	else 
	{
		$('.'+class_reset).prop("checked",false);
		if(class_reset =='religion')
		{
			$('.caste').prop("checked",false);
			$('#list_disp_caste').html('<div class="box"><p class="checkbox-m">First Select Religion</p></div>');
		}
		else if(class_reset =='country')
		{
			$('.state').prop("checked",false);
			$('.city').prop("checked",false);
			$('#list_disp_state').html('<div class="box"><p class="checkbox-m">First Select Country</p></div>');
			$('#list_disp_city').html('<div class="box"><p class="checkbox-m">First Select State</p></div>');
		}
		else if(class_reset =='state')
		{
			$('.city').prop("checked",false);
			$('#list_disp_city').html('<div class="box"><p class="checkbox-m">First Select State</p></div>');
		}
	}
	refine_search();
}
function refine_search()
{
	show_comm_mask();
	var form_data = $('#frm_filter').serialize();
	var search_order = $("#search_order").val();
	form_data = form_data+ '&is_ajax=1&search_order='+search_order;
	var base_url = $("#base_url").val();
	$("#main_content_ajax").html("");
	$.ajax({
	   url: base_url+'search/refine-search',
	   type: "post",
	   data: form_data,
	   success:function(data)
	   {
			$("#main_content_ajax").html(data);
			hide_comm_mask();
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id").val());					
			$("#hash_tocken_id_temp").remove();
	   }
	});
}

function refine_search_mobile()
{
	show_comm_mask();
	var form_data = $('#frm_filter_mobile').serialize();
	var search_order = $("#search_order").val();
	form_data = form_data+ '&is_ajax=1&search_order='+search_order;
	var base_url = $("#base_url").val();
	$.ajax({
	   url: base_url+'search/refine-search',
	   type: "post",
	   data: form_data,
	   success:function(data)
	   {
			$("#main_content_ajax").html(data);
			hide_comm_mask();
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id").val());					
			$("#hash_tocken_id_temp").remove();
	   }
	});
}

function getlist_onchange(from,to)
{
	if(from !='' && to !='')
	{
		var selected_val = Array();
		var i=0;
		$('input[name="'+from+'[]"]:checked').each(function()
		{
			selected_val[i] = this.value;
			i++;
		});
		var selected_val_to = Array();
		var j=0;
		$('input[name="'+to+'[]"]:checked').each(function()
		{
			selected_val_to[j] = this.value;
			j++;
		});
		if(i==0)
		{
			$("#list_disp_"+to).html('Please select above data');
		}
		else
		{
			var base_url = $("#base_url").val();
			var hash_tocken_id = $("#hash_tocken_id").val();
			$.ajax({
			   url: base_url+'search/get-list',
			   type: "post",
			   data: {'csrf_new_matrimonial':hash_tocken_id,'listfrom':from,'listto':to,'value':selected_val,'value_to':selected_val_to},
			   success:function(data)
			   {
					$("#list_disp_"+to).html(data);
					refine_search();
					hide_comm_mask();				
					update_tocken($("#hash_tocken_id_temp").val());
					$("#hash_tocken_id_temp").remove();
			   }
			});
		}
	}
}

function load_choosen_code()
{
	var config = {
		'.chosen-select'           : {},
		'.chosen-select-deselect'  : {allow_single_deselect:true},
		'.chosen-select-no-single' : {disable_search_threshold:10},
		'.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
		'.chosen-select-width'     : {width:'100%'}
	}
	for (var selector in config) {
		$(selector).chosen(config[selector]);
	};
}

function save_search(form_name)
{
	if(form_name == 'quick_search_form'){ var search_name = $("#qu_search_name").val();$("#quick_save_search").val(search_name);}
	else if(form_name == 'advance_search_form'){ var search_name = $("#adv_search_name").val();$("#adv_save_search").val(search_name);}
	else if(form_name == 'keyword_search_form'){ var search_name = $("#key_search_name").val();$("#key_save_search").val(search_name);}
	else if(form_name == 'id_search_form'){ var search_name = $("#id_search_name").val();$("#id_save_search").val(search_name);}
	if(search_name == ''){
		alert("Please enter Save search name");
		return false;
	}
	if(form_name !='' &&  $("#"+form_name).length > 0){
		$("#"+form_name).submit();
	}
	return false;
}

function common_delete_list_all_profile()
{
	var matri_id = $("#delete_matri_id").val();
	var page_name = $("#page_name").val();
	
	if(matri_id == '' && page_name == ''){
		alert('Please try again..!!!');
		return false;
	}
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'my-profile/common-delete-list-all-profile/';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'matri_id':matri_id,'page_name':page_name},
		dataType:'json',
		success: function(data)
		{
			$(".modal-backdrop").hide();
			$("#main_content_ajax").html(data.profile_code);
			hide_comm_mask();
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id_temp").val());					
			$("#hash_tocken_id_temp").remove();
			$('#delete_success').html(data.message);
			$('#delete_success').slideDown();
			close_model('myModal_delete');
			stoptimeout();
			starttimeout('#delete_success');
		}
	});
	return false;
}

function delete_saved_search_set_id(id)
{
	if(id !='')
	{
		$("#saved_search_id").val(id);
	}
}
function delete_saved_search()
{
	var id = $("#saved_search_id").val();
	if(id !='')
	{
		var base_url = $("#base_url").val();
		var hash_tocken_id = $("#hash_tocken_id").val();
		show_comm_mask();
		$.ajax({
		   url: base_url+'search/delete-saved-search',
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'saved_search_id':id},
		   success:function(data)
		   {
				update_tocken(data.tocken);
				hide_comm_mask();
				$("#saved_search_id").val('');
				close_model('myModal_delete');
				get_data_ajax(1,base_url+'search/saved');
				setTimeout(function(){
					$('#flash_message_saved_search').hide();
				}, 5000);
		   }
		});
	}
	else
	{
		alert("Please try agian");
	}
}
function get_express_intrest(status)
{
	$("#exp_status").val(status);
	active_exp(status);
	get_express_intrest_data(1);
}
function all_counts_express_intrest() {

	var base_url = $("#base_url").val();
	var hash_tocken_id = $("#hash_tocken_id").val();
  	$.ajax({
		  url: base_url+ 'express_interest/all_sent_receive_count',
		  type: 'POST',
		  dataType:"json",
		  data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1},
		  success: function(data) {
			  $('.all_sent').text(data.all);
			  $('.accept_sent').text(data.sent_accepted);
			  $('.reject_sent').text(data.sent_rejected);
			  $('.pending_sent').text(data.sent_pending);
			  $('.all_receive').text(data.all_rec);
			  $('.accept_receive').text(data.rec_accepted);
			  $('.reject_receive').text(data.rec_rejected);
			  $('.pending_receive').text(data.rec_pending);
			
			return true;
		  }
	});
}
function change_status(status,id)
{
	
	id = typeof id !== 'undefined' ? id : '';
	if(id =='' && status =='delete')
	{
		id = $("#delete_ex_id").val();
	}
	if(id == '')
	{
		var exp_status = $("#exp_status").val();
		var chk_class = '.'+exp_status;
		var total_checked = $(chk_class+':checked').length;
		if(total_checked == 0 || total_checked =='')
		{
			alert("Please select at least one record to process");
			return false;
		}
		var selected_val = Array();
		var i=0;
		$(chk_class+':checked').each(function() 
		{
			selected_val[i] = this.value;
			i++;
		});
		id = selected_val;
	}
	if(status !='' && id !='')
	{
		get_express_intrest_data(1,status,id);
	}
	else
	{
		alert("Please reload the page and try again");
		return false;
	}
}
function get_express_intrest_data(page_number,status,id)
{
	var exp_status = $("#exp_status").val();
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	
	status = typeof status !== 'undefined' ? status : '';
	id = typeof status !== 'undefined' ? id : '';
	
	if(page_number =='')
	{
		page_number = 1;
	}
	other_status = typeof other_status !== 'undefined' ? other_status : '';
	url_load = base_url+ 'express-interest/index/'+page_number;
	show_comm_mask();
	$("#express_ineterest_response").html("");
	$.ajax({
	   url: url_load,
	   type: "post",
	   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'exp_status':exp_status,'status':status,'id':id},
	   success:function(data)
	   {
			if(status == 'delete'){
				close_model('myModal_delete');
		   	}
			$("#express_ineterest_response").html(data);
			hide_comm_mask();
			load_pagination_code_front_end();
			scroll_to_div("scroll_to_main");
			update_tocken($("#hash_tocken_id_temp").val());					
			$("#hash_tocken_id_temp").remove();
			all_counts_express_intrest();
	   }
	});
}
function active_exp(exp_status){
	/*active sidebar*/
	$(".list-group-item p,.list-group-item span").removeClass("Poppins-Bold color-d");
	$(".list-group-item p,.list-group-item span").addClass("Poppins-Medium color-38");
	
	$("#"+exp_status+" p,#"+exp_status+" span").removeClass("Poppins-Medium color-38");
	$("#"+exp_status+" p,#"+exp_status+" span").addClass("Poppins-Bold color-d");
	
	$("#"+exp_status+" p,#"+exp_status+" span").removeClass("Poppins-Medium color-38");
	$("#"+exp_status+" p").addClass("Poppins-Bold color-d");
	$("#"+exp_status+" span").addClass("Poppins-Semi-Bold color-d");
	/*active sidebar*/
}
function send_message(status)
{
	status = status || "sent";
	$('#response_message').html('');
	$("#response_message").removeClass('alert alert-danger alert-success');
	$("#response_message").slideUp();
	var receiver_id = $('#message_id').val();
	var message = $('#message').val();
	var subject = $('#subject').val();
	if(message =='')
	{
		alert("Please enter message");
		$('#message').focus();
		return false;
	}
	if(message !='' && receiver_id !='')
	{
		var base_url = $("#base_url").val();
		var url_load = base_url+ 'message/send_message';
		var hash_tocken_id = $("#hash_tocken_id").val();
		show_comm_mask();
		$.ajax({
		   url: url_load,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'is_ajax':1,'message':message,'receiver_id':receiver_id,'msg_status':status,'subject':subject},
		   success:function(data)
		   {
			    $("#response_message").html(data.error_message);
				$("#response_message").slideDown();
				if(data.status =='success')
				{
					$('#message').val('');
					$("#response_message").addClass('alert alert-success');
				}
				else
				{
					$("#response_message").addClass('alert alert-danger');
				}
				setTimeout(function(){
					$('#response_message').hide();
				}, 5000);
				update_tocken(data.tocken);
				hide_comm_mask();
		   }
		});
	}
	else
	{
		alert("Please try again");
	}
	return false;
}
function unblock_profile(status,id,matri_id)
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var matri_id = $("#matri_id").val();
	var url  = base_url+ 'my-profile/unblock-profile';
	$('#unblock_success').hide();

	id = typeof id !== 'undefined' ? id : '';
	if(id =='' && status =='unblock')
	{
		id = $("#unblock_id").val();
	}
	show_comm_mask();
	$.ajax({
		   url: url,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'status':status,'id':id,'block_to':matri_id},
		   success:function(data)
		   {

				if(data.status == 'unblock')
				{
					$(".modal-backdrop").hide();
					$("#main_content_ajax").html(data.block_profile_code);
					hide_comm_mask();
					load_pagination_code_front_end();
					scroll_to_div("main_content_ajax");
					update_tocken($("#hash_tocken_id_temp").val());					
					$("#hash_tocken_id_temp").remove();
					$('#unblock_success').html(data.message);
					$('#unblock_success').slideDown();
				    close_model('myModal_unblock');
					stoptimeout();
					starttimeout('#unblock_success');
				}
		   }
		});
}
// function generate_otp_verify()
// {

// 	var hash_tocken_id = $("#hash_tocken_id").val();
// 	var base_url = $("#base_url").val();
// 	var url_req = base_url+'my_dashboard/generate_otp';
// 	show_comm_mask();
	
// 	var datastring = 'csrf_new_matrimonial='+hash_tocken_id;
// 	$.ajax({
// 		url : url_req,
// 		type: 'post',
// 		data: datastring,
// 		dataType:"json",
// 		success: function(data)
// 		{
// 			update_tocken(data.tocken);
// 			if(data.status == 'success')
// 			{
// 				$("#error_message_mv").hide();
// 				$("#success_message_mv").html(data.error_meessage);
// 				$("#success_message_mv").show();
// 				$("#resend_link").hide();
// 				setTimeout(function(){ $("#resend_link").show();},20000);
// 				$("#verify_mobile_cont").show();
// 				$("#displ_mobile_generate").hide();
// 			}
// 			else
// 			{
// 				$("#success_message_mv").hide();
// 				$("#error_message_mv").html(data.error_meessage);
// 				$("#error_message_mv").show();
// 			}
// 			hide_comm_mask();
// 		}
// 	});
// }
function generate_otp_verify()
{
	var country_code = $("#country_code").val();
	var mobile_number = $("#mobile_number").val();
	if(mobile_number !=''){
		var isnum = /^\d+$/.test(mobile_number);
		if(!isnum)
		{
			alert("Please enter valid number only");
			$("#mobile_number").val('');
			$("#mobile_number").focus();
			return false;
		}
	}
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url_req = base_url+'my_dashboard/generate_otp';
	show_comm_mask();
	$.ajax({
		url : url_req,
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id,'mobile_number':mobile_number,'country_code':country_code},
		dataType:"json",
		success: function(data)
		{
			update_tocken(data.tocken);
			if(data.status == 'success')
			{
				$("#error_message_mv").hide();
				$("#success_message_mv").html(data.error_meessage);
				$("#success_message_mv").show();
				$("#resend_link").hide();
				setTimeout(function(){ $("#resend_link").show();},20000);
				$("#verify_mobile_cont").show();
				$("#displ_mobile_generate").hide();
			}
			else
			{
				$("#success_message_mv").hide();
				$("#error_message_mv").html(data.error_meessage);
				$("#error_message_mv").show();
			}
			hide_comm_mask();
		}
	});
}
function varify_mobile_check()
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url_req = base_url+'my_dashboard/varify_mobile_check_otp';
	var otp_mobile = $("#otp_mobile").val();
	if(otp_mobile ==''){
		var codeBox1 = $("#codeBox1").val();
        var codeBox2 = $("#codeBox2").val();
        var codeBox3 = $("#codeBox3").val();
        var codeBox4 = $("#codeBox4").val();
        var codeBox5 = $("#codeBox5").val();
        var codeBox6 = $("#codeBox6").val();
        $("#otp_mobile").val(codeBox1+codeBox2+codeBox3+codeBox4+codeBox5+codeBox6);
        var otp_mobile = $("#otp_mobile").val();
	}
	if(otp_mobile =='')
	{
		$("#error_message_mv").html("Please enter OTP Sent on your mobile.");
		$("#error_message_mv").show();
		$("#success_message_mv").hide();
		return false;
	}
	show_comm_mask();
	$("#error_message_mv").hide();
	var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile;
	$.ajax({
		url : url_req,
		type: 'post',
		data: datastring,
		dataType:"json",
		success: function(data)
		{
			update_tocken(data.tocken);
			if(data.status== 'success')
			{
				$("#verify_mobile_cont").hide();
				$("#error_message_mv").hide();
				$("#success_message_mv").html(data.error_meessage);
				$("#success_message_mv").show();
				$("#close_buttonn_div").show();
 			}
			else
			{
				$("#success_message_mv").hide();
				$("#error_message_mv").html(data.error_meessage);
				$("#error_message_mv").show();
			}
			hide_comm_mask();
		}
	});
}

//For before login 

function generate_otp_verify_home()
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var country_code = $("#country_code").val();
	var mobile_number = $("#mobile_number").val();
	var base_url = $("#base_url").val();
	var url_req = base_url+'home/generate_otp_home';
	show_comm_mask();
	//var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&country_code='+country_code+'&mobile_number='+mobile_number ;
	$.ajax({
		url : url_req,
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id,'country_code':country_code,'mobile_number':mobile_number},
		dataType:"json",
		success: function(data)
		{
			update_tocken(data.tocken);
			if(data.status == 'success')
			{
				$("#error_message_mv").hide();
				$("#success_message_mv").html(data.error_meessage);
				$("#success_message_mv").show();
				$("#resend_link").hide();
				setTimeout(function(){ $("#resend_link").show();},20000);
				$("#verify_mobile_cont").show();
				$("#displ_mobile_generate").hide();
			}
			else
			{
				$("#success_message_mv").hide();
				$("#error_message_mv").html(data.error_meessage);
				$("#error_message_mv").show();
			}
			hide_comm_mask();
		}
	});
}
/*
function check_register(){
	var form_data = $("#register_step1").serialize();
	form_data = form_data+ "&is_post=0";

	var action = "<?php echo $base_url;?>/my_dashboard/check_register";
	show_comm_mask();
	$.ajax({
	   url: action,
	   type: "post",
	   dataType:"json",
	   data: form_data,
	   success:function(data)
	   {
	        $("#reponse_message_step1").removeClass("valid");
			$("#reponse_message_step1").html(data.errmessage);
			$("#reponse_message_step1").slideDown();
	        update_tocken(data.tocken);

	        $("#reponse_message").removeClass("valid");
	        $("#reponse_message").html(data.mob_errmessage);
	        $("#reponse_message").slideDown();
			update_tocken(data.tocken);

			hide_comm_mask();
			if(data.status == "success")
			{
				alert(data.status)
				$("#reponse_message_step1").html("");
				$( "#second_div" ).css("display","block");
		        $( "#first_div" ).hide();

	            $("#reponse_message").removeClass("error");
	            $("#reponse_message").addClass("valid");
	            $("#reponse_message").html("");
	            $( "#second_div" ).css("display","block");
	            $( "#first_div" ).hide();
			}
			else
			{
	            $("#reponse_message_step1").addClass("error");
				$("#reponse_message").addClass("error");
			}
	   }
	});
}
*/
function varify_mobile_check_home()
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url_req = base_url+'home/varify_mobile_check_otp_home';
	var otp_mobile = $("#otp_mobile").val();
	if(otp_mobile ==''){
		var codeBox1 = $("#codeBox1").val();
        var codeBox2 = $("#codeBox2").val();
        var codeBox3 = $("#codeBox3").val();
        var codeBox4 = $("#codeBox4").val();
        var codeBox5 = $("#codeBox5").val();
        var codeBox6 = $("#codeBox6").val();
        $("#otp_mobile").val(codeBox1+codeBox2+codeBox3+codeBox4+codeBox5+codeBox6);
        var otp_mobile = $("#otp_mobile").val();
	}
	if(otp_mobile =='')
	{
		$("#error_message_mv").html("Please enter OTP Sent on your mobile.");
		$("#error_message_mv").show();
		$("#success_message_mv").hide();
		return false;
	}
	$("#error_message_mv").hide();
	var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile;
	show_comm_mask();
	$.ajax({
		url : url_req,
		type: 'post',
		data: datastring,
		dataType:"json",
		success: function(data)
		{

			update_tocken(data.tocken);
			if(data.status== 'success')
			{
				$("#verify_mobile_cont").hide();
				$("#error_message_mv").hide();
				$("#success_message_mv").html(data.error_meessage);
				$("#success_message_mv").show();
				$("#close_buttonn_div").show();
				var base_url = $("#base_url").val();
				var page_url = base_url+ 'my-profile';
				top.location.href=page_url;

			}
			else if (data.error_meessage == 'register') {
					var base_url = $("#base_url").val();
					var page_url = base_url+ 'register';
					top.location.href=page_url;
				}
			else
			{
			    $("#codeBox1").val("");
                $("#codeBox2").val("");
                $("#codeBox3").val("");
                $("#codeBox4").val("");
                $("#codeBox5").val("");
                $("#codeBox6").val("");
                $("#otp_mobile").val("");
				$("#success_message_mv").hide();
				$("#error_message_mv").html(data.error_meessage);
				$("#error_message_mv").show();
			}
			hide_comm_mask();
		}
	});
}

function varify_mobile_check_login()
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	var url_req = base_url+'home/varify_mobile_check_otp_home';
	var otp_mobile = $("#otp_mobile").val();
	if(otp_mobile ==''){
		var codeBox1 = $("#codeBox1").val();
        var codeBox2 = $("#codeBox2").val();
        var codeBox3 = $("#codeBox3").val();
        var codeBox4 = $("#codeBox4").val();
        var codeBox5 = $("#codeBox5").val();
        var codeBox6 = $("#codeBox6").val();
        $("#otp_mobile").val(codeBox1+codeBox2+codeBox3+codeBox4+codeBox5+codeBox6);
        var otp_mobile = $("#otp_mobile").val();
	}
	if(otp_mobile =='')
	{
		$("#error_message_mv").html("Please enter OTP Sent on your mobile.");
		$("#error_message_mv").show();
		$("#success_message_mv").hide();
		return false;
	}
	show_comm_mask();
	$("#error_message_mv").hide();
	var datastring = 'csrf_new_matrimonial='+hash_tocken_id+'&otp_mobile='+otp_mobile;
	$.ajax({
		url : url_req,
		type: 'post',
		data: datastring,
		dataType:"json",
		success: function(data)
		{
			if(data.status== 'success')
			{
				$("#verify_mobile_cont").hide();
				$("#error_message_mv").hide();
				$("#success_message_mv").html(data.error_meessage);
				$("#success_message_mv").show();
				$("#close_buttonn_div").show();
				var base_url = $("#base_url").val();
				var page_url = base_url+ 'my-profile';
				top.location.href=page_url;
			}
			else if (data.error_meessage == 'register') {
				var base_url = $("#base_url").val();
				var page_url = base_url+ 'register';
				top.location.href=page_url;
			}
			else
			{
			    $("#codeBox1").val("");
                $("#codeBox2").val("");
                $("#codeBox3").val("");
                $("#codeBox4").val("");
                $("#codeBox5").val("");
                $("#codeBox6").val("");
                $("#otp_mobile").val("");
                $("#success_message_mv").hide();
				$("#error_message_mv").html(data.error_meessage);
				$("#error_message_mv").show();
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
}

//End

function message_system_st(mode)
{
	$("#message_search").val('');
	message_system(mode,1);
}
function message_system(mode,page_number)
{
	var page_type = $("#page_type").val();
	var base_url = $("#base_url").val();
	if(page_type == 'compose_message')
	{
		window.location = base_url + 'message/inbox/'+mode;
	}
	var hash_tocken_id = $("#hash_tocken_id").val();
	
	mode = typeof mode !== 'undefined' ? mode : '';
	page_number = typeof page_number !== 'undefined' ? page_number : 1;
	if(mode !='')
	{
		$("#mode").val(mode);
	}
	var mode = $("#mode").val();
	var message_search = $("#message_search").val();
	var url_req = base_url+'message/inbox/'+mode+'/'+page_number;
	show_comm_mask();
	$.ajax({
		url : url_req,
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id,'mode':mode,'page_number':page_number,'is_ajax':1,'message_search':message_search},
		success: function(data)
		{
			$("#main_id_display").html(data);
			update_tocken($("#hash_tocken_id_temp").val());
			$("#hash_tocken_id_temp").remove();
			hide_comm_mask();
			load_pagination_message();
			tooltip_fun();
			select2_int();
			text_editor();
			scroll_to_div('main_id_display');
		}
	});
	return false;
}
function select2_int(){
	var base_url = $("#base_url").val();
	$('#to_message').select2({
		placeholder: 'Select Member Matri ID',
		ajax: {
			url: base_url+'message/get_member_list',
			type: 'POST',
			dataType:'json',
			data: function (params){
				return {
					q: params.term,
					page: params.page,
				};
			},
		}
	});
}
function text_editor(){
	$('#txtEditor').Editor();
	var x = document.getElementsByClassName('row-fluid')[0];
	x.getElementsByClassName('Editor-editor')[0].style.height = '170px';
	$('div.Editor-editor').html($('#msg_content').val()); 
	$('div.Editor-editor').blur(function(){
		var cms_cont = $('div.Editor-editor').html();
		$('#msg_content').val(cms_cont);
	});
}
function load_pagination_message()
{
   $("#ajax_pagin_ul li a").click(function()
   {
		var url_load = $(this).attr("href");
		url_load = typeof url_load !== 'undefined' ? url_load : '';
		var page_number = $(this).attr("data-ci-pagination-page");
		page_number = typeof page_number !== 'undefined' ? page_number : 0;
		if(url_load == '#' || url_load == '' && page_number)
		{
			return false;
		}
		if(page_number != undefined && page_number !='' && page_number != 0)
		{
			message_system('',page_number);
		}
		return false;
   });
}
function replay_forward(mode)
{
	if(mode !='reply' && mode !='forward')
	{
		alert('Please try again');
		return false;
	}
	var total_checked = $('input[name="checkbox_val[]"]:checked').length;
	if(total_checked == 0 || total_checked =='' ||  total_checked != 1)
	{
		alert("Please select only one message for "+mode);
		return false;
	}
	if(total_checked == 1 && mode !='')
	{
		$('input[name="checkbox_val[]"]:checked').each(function() 
		{
			selected_val = this.value;
		});	
		var msg_enc_id = $("#msg_enc_id_"+selected_val).val();
		if(msg_enc_id !='')
		{
			var base_url = $("#base_url").val();
			var hash_tocken_id = $("#hash_tocken_id").val();
			$.ajax({
				url : base_url+'message/compose',
				type: 'post',
				data: {'csrf_new_matrimonial':hash_tocken_id,'msg_enc_id':msg_enc_id,'mode':mode},
				success: function(data){
					$("#compose-new-msg").html(data);
					$("#compose-new-msg").modal('show');
					select2_int();
					text_editor();
					tooltip_fun();
					update_tocken(hash_tocken_id);
				}
			});
		}
	}
}

function compose_new()
{
	var base_url = $("#base_url").val();
	var hash_tocken_id = $("#hash_tocken_id").val();
	$.ajax({
		url : base_url+'message/compose',
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id},
		success: function(data){
			$("#compose-new-msg").html(data);
			$("#compose-new-msg").modal('show');
			select2_int();
			text_editor();
			tooltip_fun();
			update_tocken(hash_tocken_id);
		}
	});
}
function compose(msg_enc_id,mode)
{
	if(mode !='reply' && mode !='forward' && mode !='draft'){
		alert('Please try again');
		return false;
	}
	if(mode !='' && msg_enc_id !=''){
		var base_url = $("#base_url").val();
		var hash_tocken_id = $("#hash_tocken_id").val();
		$.ajax({
			url : base_url+'message/compose',
			type: 'post',
			data: {'csrf_new_matrimonial':hash_tocken_id,'msg_enc_id':msg_enc_id,'mode':mode},
			success: function(data){
				$("#compose-new-msg").html(data);
				$("#compose-new-msg").modal('show');
				select2_int();
				text_editor();
				tooltip_fun();
				update_tocken(hash_tocken_id);
			}
		});
	}
}
function draft_delete(id){
	close_model('compose-new-msg');
	$("#draft_delete_id").html('<input style="display:none" type="checkbox" name="checkbox_val[]" value="'+id+'" checked />');
	return false;
}
function update_msg_status(status)
{
	var selected_val = Array();
	var i=0;
	var total_checked = $('input[name="checkbox_val[]"]:checked').length;
	if(total_checked == 0 || total_checked =='')
	{
		alert("Please select at least one record to process");
		return false;
	}
	$('input[name="checkbox_val[]"]:checked').each(function() 
	{
		selected_val[i] = this.value;
		i++;
	});	
	var hash_tocken_id = $("#hash_tocken_id").val();
	var base_url = $("#base_url").val();
	$("#response_update_status").removeClass('alert alert-danger alert-success');
	var mode = $("#mode").val();
	var message_search = $("#message_search").val();
	var url_req = base_url+'message/inbox/'+mode;
	show_comm_mask();
	$.ajax({
		url : url_req,
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id,'selected_val':selected_val,'status':status,'mode':mode,'page_number':1,'is_ajax':1,'message_search':message_search},
		success: function(data)
		{
			$("#main_id_display").html(data);
			update_tocken($("#hash_tocken_id_temp").val());
			$("#hash_tocken_id_temp").remove();
			hide_comm_mask();			
			close_model('myModal_delete');
			load_pagination_message();
			tooltip_fun();
			scroll_to_div('main_id_display');
		}
	});
	return false;
}
var in_process_imp = 0;
function importantfun(message_id)
{
	if(message_id ==='')
	{
		alert("Please reload page and try again");
		return false;
	}
	if(in_process_imp == 0)
	{
		var curr_class_status = $("#msg_imp_"+message_id).hasClass('unstar-icon');
		var new_class = 'unstar-icon';
		var current_status = 'unimported';
		var curr_class = 'star-icon';
		if(curr_class_status)
		{
			new_class = 'star-icon';
			curr_class = 'unstar-icon';
			current_status = 'imported';
		}
		
		in_process_imp = 1;
		var hash_tocken_id = $("#hash_tocken_id").val();
		var base_url = $("#base_url").val();
		var url_req = base_url+'message/update_status_imp';
		var mode = $("#mode").val();
		show_comm_mask();
		$.ajax({
			url : url_req,
			type: 'post',
			data: {'csrf_new_matrimonial':hash_tocken_id,'selected_val':message_id,'status':current_status,'mode':mode},
			dataType:"json",
			success: function(data)
			{
				update_tocken(data.tocken);
				$("#msg_imp_"+message_id).removeClass(curr_class);
				$("#msg_imp_"+message_id).addClass(new_class);
				hide_comm_mask();
				in_process_imp = 0;
			}
		});
		return false;
	}
}

function save_draft_send_message(status)
{
	var hash_tocken_id = $("#hash_tocken_id").val();
	var to_message = $("#to_message").val();
	var cms_cont= $('div.Editor-editor').html();
	$('#msg_content').val(cms_cont);
	var message = $("#msg_content").val();
	$("#response_update_status").html('');
	if(status ==''){
		alert("Please try again");
		return false;
	}
	if(to_message ==''){
		alert("Please select atleast one message receiver");
		$("#to_message").focus();
		return false;
	}	
	if(message ==''){
		alert("Please enter message to send");
		return false;
	}
	var base_url = $("#base_url").val();
	var message_id = $("#msg_id").val();
	
	var url_req = base_url+'message/send_message';
	show_comm_mask();
	$.ajax({
		url : url_req,
		type: 'post',
		data: {'csrf_new_matrimonial':hash_tocken_id,'msg_status':status,'message_id':message_id,'message':message,'receiver_id':to_message},
		dataType:"json",
		success: function(data){
			var resp_message = '';
			if(data.status =='success'){
				resp_message = '<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">Ã—</a>'+ data.error_message +'</div>';
				
				form_reset('mes_content_form');
				$('div.Editor-editor').html('');
				$("#subject").val('');
				$("#to_message").empty().trigger('change');
			}
			else{
				resp_message = '<div class="alert alert-danger alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">Ã—</a>'+ data.error_message +'</div>';
			}
			$("#response_update").html(resp_message);
			scroll_to_div('sc_div_message');
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}
function tooltip_fun()
{
	$("[data-toggle='tooltip']").tooltip();
	$('.tooltip1').tooltip();
}
function close_model(modal_id)
{
	if(modal_id !='')
	{
		$('#'+modal_id).modal('hide');
		$(".modal-backdrop").hide();
		$('body').removeClass('modal-open');
		$("body").css('padding-right','0px');
	}
}
function delete_message()
{
	var total_checked = $('input[name="checkbox_val[]"]:checked').length;
	if(total_checked == 0 || total_checked =='')
	{
		$(".delete_alt").show();
		$(".delete_conf").hide();
	}
	else
	{
		$(".delete_conf").show();
		$(".delete_alt").hide();
	}
}

function get_ViewContactDetails(receiver_matri_id)
{
	if(receiver_matri_id ==''){
		alert('Please try again..!!!');
		return false;
	}
		
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/view-contact-details';
	show_comm_mask();
		$.ajax({
		  	url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'receiver_matri_id':receiver_matri_id},
			dataType:'json',
			success: function(data)
			{ 	
				if(data.success = 'success'){
					$('#myModal_ViewContactDetails').html(data.contact_details);
				}else{
					alert(data.errmessage);
				}
				update_tocken(data.tocken);
				hide_comm_mask();
		  	}
		});
	return false;
}
	
function get_ViewVideo(member_id)
{
	if(member_id ==''){
		alert('Please try again..!!!');
		return false;
	}
		
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/view-video';
	show_comm_mask();
		$.ajax({
		  	url: url,
			type: 'POST',
			data: {'csrf_new_matrimonial':hash_tocken_id,'member_id':member_id},
			dataType:'json',
			success: function(data)
			{ 	
				if(data.success = 'success'){
					$('#myModal_ViewVideo').html(data.video_details);
				}else{
					alert(data.errmessage);
				}
				update_tocken(data.tocken);
				hide_comm_mask();
		  	}
		});
	return false;
}


function KeycheckOnlyCharacter(e)
{	
	//var charCode = e.keyCode;
	// || charCode == 32 ----- for space
	
	var charCode = (e.keyCode ? e.keyCode : e.which);
	if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || ( charCode == 37 && charCode == 38 && charCode == 39 && charCode == 40) || charCode == 46 || charCode == 13 || charCode == 9)
	{
		return true;
	}else{
		return false;
	}
}

function KeycheckOnlyPhonenumber(e)
{
	var _dom = 0;
	_dom = document.all ? 3 : (document.getElementById ? 1 : (document.layers ? 2 : 0));
	if (document.all)
		e = window.event; // for IE
	var ch = '';
	var KeyID = '';
	var charCode = (e.keyCode ? e.keyCode : e.which);
	if (_dom == 2)
	{ // for NN4
		if (e.which > 0)
			ch = '(' + String.fromCharCode(e.which) + ')';
		KeyID = e.which;
	}
	else
	{
		if (_dom == 3)
		{ // for IE
			
			KeyID = (window.event) ? event.keyCode : e.which;
		}
		else
		{ // for Mozilla
			if (e.charCode > 0)
				ch = '(' + String.fromCharCode(e.charCode) + ')';
			KeyID = e.charCode;
		}
	}
	
	if ((KeyID >= 65 && KeyID <= 90) || (KeyID >= 97 && KeyID <= 122) || (KeyID >= 33 && KeyID <= 40) || (KeyID >= 42 && KeyID <= 42) || (KeyID == 44) || (KeyID >= 46 && KeyID <= 47) || (KeyID >= 58 && KeyID <= 64) || (KeyID >= 91 && KeyID <= 96) || (KeyID >= 123 && KeyID <= 126) || charCode == 32)
	{
		return false;
	}
	return true;
}

function display_total_childern()
{
	//$('#marital_status').change(function(){
	var marital_status = $("#marital_status option:selected").val();
	//alert(marital_status);
	if(marital_status !='' && marital_status !='Unmarried')
	{
		$("#total_children").removeAttr('disabled');
		display_childern_status();
	}
	else
	{
		$("#total_children").val('');
		$('#total_children').val('').trigger("change");
		$("#total_children").prop('selected', false);
		$("#total_children").attr('disabled','disabled');
		$("[name='status_children']").val('');
		$('[name="status_children"]').val('').trigger("change");
		$("[name='status_children']").prop('selected', false);
		$("[name='status_children']").attr('disabled','disabled');
		$("#total_children").select2();
	}
}
function display_childern_status()
{
	var total_children = $("#total_children option:selected").val();
	if(total_children !='' && total_children !='0')
	{
		//$("input[name='status_children']").attr('disabled', true);
		 $("[name='status_children']").removeAttr('disabled');
	}
	else
	{
		//$("input[name='status_children']").attr('disabled', false);
		
		$("[name='status_children']").val('');
		$("[name='status_children']").attr('disabled','disabled');
		$('[name="status_children"]').val('').trigger("change");
		$("[name='status_children']").prop('selected', false);
	}
}
function already_liked(other_id){
	$('#snackbar4-'+other_id).addClass('show');
    setTimeout(function(){
        $('#snackbar4-'+other_id).removeClass('show');
    }, 3000);
}
function already_unliked(other_id){
	$('#snackbar6-'+other_id).addClass('show');
    setTimeout(function(){
        $('#snackbar6-'+other_id).removeClass('show');
    }, 3000);
}
function member_like(like_status,other_id)
{
	if(like_status == ''){
		alert('Please try again..!!!');
		return false;
	}
	if(other_id == ''){
		alert('Please try again..!!!');
		return false;
	}
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/member-like';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'like_status':like_status,'other_id':other_id},
		dataType:'json',
		success: function(data)
		{
			if(data.login == 'login'){
				window.location = base_url + 'login';
			}else{
				if(data.status == 'success'){
					if(like_status=='Yes'){
						$('#snackbar3-'+other_id).addClass('show');
					    setTimeout(function(){
					        $('#snackbar3-'+other_id).removeClass('show');
					        $("#like-"+other_id).hide();
					        $("#unlike-"+other_id).show();
					    }, 3000);
					}else{
						$('#snackbar5-'+other_id).addClass('show');
					    setTimeout(function(){
					        $('#snackbar5-'+other_id).removeClass('show');
					        $("#like-"+other_id).show();
					        $("#unlike-"+other_id).hide();
					    }, 3000);
					}

					var url2 = base_url+'search/total_likes_unlikes';
					$.ajax({
						url: url2,
						type: 'POST',
						data: {'csrf_new_matrimonial':hash_tocken_id,'other_id':other_id},
						dataType:'json',
						success: function(data1)
						{
						}
					});
					setTimeout(function(){
					if(data.image_name == 'Yes'){
						$('#like_unlike_'+other_id).html("");
						$('#like_unlike_'+other_id).html("Unlike");
						$('#Yes_id_'+other_id).hide();
						$('#No_id_'+other_id).show();
				
						$('#Image_Yes_'+other_id).show();
						$('#Image_No_'+other_id).hide();
						
						$('#like_'+other_id).html("");
						$('#like_'+other_id).html("Liked");
						$('#unlike_'+other_id).html("");
						$('#unlike_'+other_id).html("Unlike");
					}
					if(data.image_name == 'No'){
						$('#like_unlike_'+other_id).html("");
						$('#like_unlike_'+other_id).html("Like");
						$('#No_id_'+other_id).hide();
						$('#Yes_id_'+other_id).show();

						$('#Image_No_'+other_id).show();
						$('#Image_Yes_'+other_id).hide();
						$('#like_'+other_id).html("");
						$('#like_'+other_id).html("Like");
						$('#unlike_'+other_id).html("");
						$('#unlike_'+other_id).html("Unliked");
					}
					}, 3000);
				}else{
					alert(data.errmessage);
				}
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}

function mob_member_like(like_status,other_id)
{
	like_status = like_status || "";
	other_id = other_id || "";
	
	if(like_status == ''){
		alert('Please try again..!!!');
		return false;
	}
	if(other_id == ''){
		alert('Please try again..!!!');
		return false;
	}
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'search/member-like';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'like_status':like_status,'other_id':other_id},
		dataType:'json',
		success: function(data)
		{
			if(data.login == 'login'){
				window.location = base_url + 'login';
			}else{
				if(data.status == 'success'){
					if(like_status=='Yes'){
						$('#snackbarm3-'+other_id).addClass('show');
					    setTimeout(function(){
					        $('#snackbarm3-'+other_id).removeClass('show');
					        $("#mob-like-"+other_id).hide();
					        $("#mob-unlike-"+other_id).show();
					    }, 3000);
					}else{
						$('#snackbarm4-'+other_id).addClass('show');
					    setTimeout(function(){
					        $('#snackbarm4-'+other_id).removeClass('show');
					        $("#mob-like-"+other_id).show();
					        $("#mob-unlike-"+other_id).hide();
					    }, 3000);
					}
					var url2 = base_url+'search/total_likes_unlikes';
					$.ajax({
						url: url2,
						type: 'POST',
						data: {'csrf_new_matrimonial':hash_tocken_id,'other_id':other_id},
						dataType:'json',
						success: function(data1)
						{
						}
					});
					setTimeout(function(){
					if(data.image_name == 'Yes'){
						$('#mob_like_unlike_'+other_id).html("");
						$('#mob_like_unlike_'+other_id).html("Unlike");
						$('#mob_Yes_id_'+other_id).hide();
						$('#mob_No_id_'+other_id).show();
				
						$('#mob_Image_Yes_'+other_id).show();
						$('#mob_Image_No_'+other_id).hide();
						
						$('#mob_like_'+other_id).html("");
						$('#mob_like_'+other_id).html("Liked");
						$('#mob_unlike_'+other_id).html("");
						$('#mob_unlike_'+other_id).html("Unlike");
					}
					if(data.image_name == 'No'){
						$('#mob_like_unlike_'+other_id).html("");
						$('#mob_like_unlike_'+other_id).html("Like");
						$('#mob_No_id_'+other_id).hide();
						$('#mob_Yes_id_'+other_id).show();

						$('#mob_Image_No_'+other_id).show();
						$('#mob_Image_Yes_'+other_id).hide();
						$('#mob_like_'+other_id).html("");
						$('#mob_like_'+other_id).html("Like");
						$('#mob_unlike_'+other_id).html("");
						$('#mob_unlike_'+other_id).html("Unliked");
					}
					}, 3000);
				}else{
					alert(data.errmessage);
				}
			}
			update_tocken(data.tocken);
			hide_comm_mask();
		}
	});
	return false;
}

function reject_request()
{
	var requester_id = $('#requester_id').val();
	var status = $('#status_sent_recieve').val();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var photo_name = $('#photo_name').val();
	var base_url = $('#base_url').val();
	var url = base_url+'my_profile/reject_request';
	var sender = 1;
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'requester_id':requester_id,'status':status,'photo_name':photo_name },
		dataType:'json',
		success: function(data){
			$(".modal-backdrop").hide();
			$("#main_content_ajax").html(data.profile_code);
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id").val());					
			$('#delete_success').html(data.response);
			$('#delete_success').slideDown();
			close_model('myModal_delete12');
			stoptimeout();
			starttimeout('#delete_success');
			hide_comm_mask();
		}
	});
	return false;
}
function delete_request()
{
	var requester_id = $('#requester_id').val();
	var status = $('#status_sent_recieve').val();
	var photo_name = $('#photo_name').val();
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'my-profile/delete-request';
	var sender = 1;
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'requester_id':requester_id,'status':status,'photo_name':photo_name},
		dataType:'json',
		success: function(data){ 	
			$(".modal-backdrop").hide();
			$("#main_content_ajax").html(data.profile_code);
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken($("#hash_tocken_id").val());					
			$('#delete_success').html(data.errmessage);
			$('#delete_success').slideDown();
			close_model('myModal_delete12');
			stoptimeout();
			starttimeout('#delete_success');
			hide_comm_mask();
		}
	});
	return false;
}
function accept_request()
{
	var requester_id = $('#requester_id').val();
	var status = $('#status_sent_recieve').val();
	var photo_name = $('#photo_name').val();
	
	var hash_tocken_id = $('#hash_tocken_id').val();
	var base_url = $('#base_url').val();
	var url = base_url+'my-profile/send-photo-pass';
	show_comm_mask();
	$.ajax({
		url: url,
		type: 'POST',
		data: {'csrf_new_matrimonial':hash_tocken_id,'requester_id':requester_id,'photo_name':photo_name},
		dataType:'json',
		success: function(data){ 	
			$(".modal-backdrop").hide();
			$("#main_content_ajax").html(data.profile_code);
			load_pagination_code_front_end();
			scroll_to_div("main_content_ajax");
			update_tocken(hash_tocken_id);					
			$('#delete_success').html(data.response);
			$('#delete_success').slideDown();
			close_model('myModal_delete13');
			stoptimeout();
			starttimeout('#delete_success');
			hide_comm_mask();
		}
	});
	return false;
}
/*function send_photo_pass(requester_id,status)
{
	if(status != 'Accepted')
	{
		var hash_tocken_id = $('#hash_tocken_id').val();
		var base_url = $('#base_url').val();
		var url = base_url+'my-profile/send-photo-pass';
		show_comm_mask();
			$.ajax({
				url: url,
				type: 'POST',
				data: {'csrf_new_matrimonial':hash_tocken_id,'requester_id':requester_id},
				dataType:'json',
				success: function(data)
				{ 	
					alert(data.response);
					update_tocken(data.tocken);
					hide_comm_mask();
					window.location.reload(true);
				}
			});
	}else{
	}
	return false;
}
*/
// function accept_photo_reqeust(id,status)
// {
// 	$('#requester_id').val(id);
// 	$('#status_sent_recieve').val(status);
// }
function accept_photo_reqeust(id,status,photo_name)
{
	$('#requester_id').val(id);
	$('#status_sent_recieve').val(status);
	$('#photo_name').val(photo_name);
}
function delete_photo_reqeust(id,status,photo_name)
{
	$('#requester_id').val(id);
	$('#status_sent_recieve').val(status);
	$('#photo_name').val(photo_name);
}
function reject_photo_reqeust(id,status,photo_name)
{
	$('#requester_id').val(id);
	$('#status_sent_recieve').val(status);
	$('#photo_name').val(photo_name);
}
function show_comm_mask()
{
	var winW = $(window).width();
	var winH = $(window).height();
	var loaderLeft = (winW / 2) - (36 / 2);
	var loaderTop = (winH / 2) - (36 / 2);
	$('#lightbox-panel-mask').css('height', winH + "px");
	$('#lightbox-panel-mask').fadeTo('slow', 0.2);
	$('#lightbox-panel-mask').show();
	$('#lightbox-panel-loader').css({ 'left': loaderLeft + "px", 'top': loaderTop });
	$('#lightbox-panel-loader').show();
}
function hide_comm_mask()
{
	$('#lightbox-panel-mask').hide();
	$('#lightbox-panel-loader').hide();
}



/*================ search web popup start here ===================*/
function list_select(id,list){
	var len = $("#select_"+list+"_dt").children('div').length;
	if(len<=0)
	{
		$("#select_"+list+"_dt").html('');
	}
	if(len >=10 )
	{
		alert('You can select maximum 10 '+list+' at once');
		return false
	}
	var not_len = $("#no_select_"+list+"_dt").children('div').length;
	if(not_len<=0){
		$("#no_select_"+list+"_dt").html('');
	}
	$("#parent_"+list+"_checkbox_"+id+" i").show();
	$("#parent_"+list+"_checkbox_"+id+" input[type='checkbox']").attr("onclick","list_dselect("+id+",'"+list+"')");
	$("#parent_"+list+"_checkbox_"+id).prependTo("#select_"+list+"_dt");
	var len = $("#select_"+list+"_dt").children('div').length;
	$("#"+list+"_sel_count").text(len);

	if(len<=0){
		$("#select_"+list+"_dt").html('<p>Not Available</p>');
	}
	var not_len = $("#no_select_"+list+"_dt").children('div').length;
	if(not_len<=0){
		$("#no_select_"+list+"_dt").html('<p>Not Available</p>');
	}
}

function list_dselect(id,list){
	var len = $("#select_"+list+"_dt").children('div').length;
	if(len<=0){
		$("#select_"+list+"_dt").html('');
	}
	var not_len = $("#no_select_"+list+"_dt").children('div').length;
	if(not_len<=0){
		$("#no_select_"+list+"_dt").html('');
	}
	$("#parent_"+list+"_checkbox_"+id+" i").hide();
	$("#parent_"+list+"_checkbox_"+id+" input[type='checkbox']").attr("onclick","list_select("+id+",'"+list+"')");
	$("#parent_"+list+"_checkbox_"+id).prependTo("#no_select_"+list+"_dt");
	var len = $("#select_"+list+"_dt").children('div').length;
	$("#"+list+"_sel_count").text(len);
	if(len<=0){
		$("#select_"+list+"_dt").html('<p>Not Available</p>');
	}
	var not_len = $("#no_select_"+list+"_dt").children('div').length;
	if(not_len<=0){
		$("#no_select_"+list+"_dt").html('<p>Not Available</p>');
	}
}

function list_deselect_all_a(list){
	$("#select_"+list+"_dt input[type='checkbox']").each(function(){
		$(this).click();
	})
}
function fn_apply_list(list){
	$('input[id^="'+list+'_id_"]').each(function(){
		$(this).prop("checked",false);
	})
	
	$("#select_"+list+"_dt input[type='checkbox']").each(function(){
		var id = $(this).val();
		var id_new = id.replace(/[, ]+/g, "").trim();
		$("#mob_"+list+"_id_"+id_new).prop("checked",true);
		$("#"+list+"_id_"+id_new).prop("checked",true);
	})
	$("#more-"+list+"").modal('hide');
	$('body').removeClass('modal-open');
	$('.modal-backdrop').remove();
	setTimeout(function(){
		if(list=='country'){
			getlist_onchange('country','state');
		}
		if(list=='state'){
			getlist_onchange('state','city');
		}
		if(list=='religion'){
			getlist_onchange('religion','caste');
		}
		refine_search();
	}, 100);
}


/*================ search web popup end here ===================*/

// added for auto logout all tabs, if any one is logged out

window.addEventListener('storage', function(event){
	if($("#base_url").length > 0)
	{
		var base_url = $("#base_url").val();
		if (event.key == 'front-logout-event') {
		   setTimeout(function(){
				window.location.href = base_url+"/login/log-out";
		   }, 1000);
		}
	}
});

function updateLocalStorage()
{
	if($("#base_url").length > 0)
	{
		var base_url = $("#base_url").val();
		localStorage.setItem('front-logout-event', 'logout' + Math.random());
		window.location.href = base_url+"/login/log-out";
	}
}


// Set timeout variables.
var timoutWarning = 1200000; // Display warning in 20 Mins : 1200000
var timoutNow = 1260000; // Timeout in 21 mins : 1260000
// var timoutWarning = 60000; // Display warning in 2 Mins : 1200000
// var timoutNow = 120000; // Timeout in 4 mins : 1260000
var logoutUrl = $("#base_url").val()+"/login/log-out"; // URL to logout page.

var browser_title = document.getElementsByTagName("title")[0].innerHTML;
var warningTimer;
var timeoutTimer;

// Start timers.
function StartTimers() {
    warningTimer = setTimeout("IdleWarning()", timoutWarning);
    timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
}

// Reset timers.
function ResetTimers() {
	localStorage.setItem('login-event', 'login' + Math.random());
	network_call();
	resetAll();
}

function resetAll()
{
	document.title = browser_title;
    clearTimeout(warningTimer);
    clearTimeout(timeoutTimer);
    StartTimers();
    $("#timeout").modal('hide');
}
// Show idle timeout warning dialog.
function IdleWarning() {
	document.title = "Action needed...";
	$('#timeout').modal({
		backdrop: 'static',
		keyboard: false
	})
}

// Logout the user.
function IdleTimeout() {
	updateLocalStorage();
    window.location = logoutUrl;
}


window.addEventListener('storage', function(event){
    if (event.key == 'login-event') { 
      resetAll();
    }
});

function network_call()
{
	var base_url = $('#base_url').val();
	$.ajax({
		url: base_url+"common-request/revival"
	});
}


//23-11-2020

function dropdownChange_profile(currnet_id,disp_on,get_list,id_val,yes_no)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id).val();
	
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
			success:function(data)
			{
				$("."+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(currnet_val=='Other'){
					if(get_list == 'state_list')
					{
						if(id_val==''){
							$('.other_state_display').hide();
							$('.other_state_name').val("");
							$('.other_state').val("");
							$('.other_city_display').hide();
							$('.other_city_name').val("");
							$('.other_city').val("");
						}
						var yes_no = $('.other_state').val();
						if(yes_no=='Yes'){
							if(id_val!=''){
								$('.state_id_update option:selected').removeAttr('selected');
							}
							$('.state_id_update option[value=Other]').prop('selected', 'selected');
		    				$('.state_id_update').val('Other').trigger('change');
		    			}
					}
					if(get_list == 'city_list')
					{
						if(id_val==''){
							$('.other_city_display').hide();
							$('.other_city_name').val("");
							$('.other_city').val("");
						}
						var yes_no1 = $('.other_city').val();
						if(yes_no1=='Yes'){
							if(id_val!=''){
								$('.city_update option:selected').removeAttr('selected');
							}
							$('.city_update option[value=Other]').prop('selected', 'selected');
		    				$('.city_update').val('Other').trigger('change');
		    			}
					}
				}
				if(currnet_val=='Other'){
					if(currnet_id=='country_id_update'){
						$('#other_country_display').show();
					}
					if(currnet_id=='state_id_update'){
						$('#other_state_display').show();
					}
				}else if(currnet_val!='Other'){
					if(currnet_id=='country_id_update'){
						$('.other_country_display').hide();
						$('.other_state_display').hide();
						$('.other_city_display').hide();
						$('.other_country_name').val("");
						$('.other_state_name').val("");
						$('.other_city_name').val("");
						$('.other_country').val("");
						$('.other_state').val("");
						$('.other_city').val("");
					}
					if(currnet_id=='state_id_update'){
						$('.other_state_display').hide();
						$('.other_city_display').hide();
						$('.other_state_name').val("");
						$('.other_city_name').val("");
						$('.other_state').val("");
						$('.other_city').val("");
					}
				}

				if(get_list =='state_list')
				{
					if($(".city_update").length > 0)
					{
						$(".city_update").html('<option value="">Select City</option>');
					}
				}
			}
		});
	}
	else
	{
		$("."+disp_on).html('<option value="">Select Option First</option>');
		if(get_list =='state_list')
		{
			if($(".city_update").length > 0)
			{
				$(".city_update").html('<option value="">Select City</option>');
			}
		}
	}
}

//24-10-2019 for my_profile_view page
function dropdownChange_new(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id).val();
	
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
			url: action,
			type: "post",
			dataType:"json",
			data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
			success:function(data)
			{
				$("."+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(get_list =='state_list')
				{
					if($(".city_update").length > 0)
					{
						$(".city_update").html('<option value="">Select City</option>');
					}
				}
			}
		});
	}
	else
	{
		$("."+disp_on).html('<option value="">Select Option First</option>');
		if(get_list =='state_list')
		{
			if($(".city_update").length > 0)
			{
				$(".city_update").html('<option value="">Select City</option>');
			}
		}
	}
}
//30-10-2019 for my_profile_view page
function dropdownChange_new_2(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("#"+currnet_id).val();
	if(currnet_val !='' && currnet_val != null )
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val},
		   success:function(data)
		   {
			   
				$("#"+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				hide_comm_mask();
				if(get_list =='state_list')
				{
					if($("#city_2").length > 0)
					{
						$("#city_2").html('<option value="">Select City</option>');

					}
				}
		   }
		});
	}
	else
	{
		$("#"+disp_on).html('<option value="">Select Value</option>');
		if(get_list =='state_list')
		{
			if($("#city").length > 0)
			{
				$("#city").html('<option value="">Select City</option>');

			}
		}
	}
}

//for select2 dropdown in multiple
function dropdownChange_mul_new_mob(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id).val();

	if(currnet_val !='' && currnet_val !=null)
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val,'multivar':'multi','tocken_val':1},
		   success:function(data)
		   {
				$("."+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				$('.'+disp_on).select2().trigger('refresh');
				hide_comm_mask();
				if(get_list == 'state_list')
				{
					if($(".city_list_update_mob").length > 0)
					{
						$(".city_list_update_mob").html('');
						$('.city_list_update_mob').select2().trigger('refresh');
					}
				}
		   }
		});
	}
	else
	{
		$("."+disp_on).html('');
		$('.'+disp_on).select2().trigger('refresh');
		if(get_list =='state_list')
		{
			if($(".city_list_update_mob").length > 0)
			{
				$(".city_list_update_mob").html('');
				$('.city_list_update_mob').select2().trigger('refresh');
			}
		}
	}
}
function dropdownChange_mul_new(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id).val();

	if(currnet_val !='' && currnet_val !=null)
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val,'multivar':'multi','tocken_val':1},
		   success:function(data)
		   {
				$("."+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				$('.'+disp_on).select2().trigger('refresh');
				hide_comm_mask();
				if(get_list == 'state_list')
				{
					if($(".city_list_update").length > 0)
					{
						$(".city_list_update").html('');
						$('.city_list_update').select2().trigger('refresh');
					}
				}
		   }
		});
	}
	else
	{
		$("."+disp_on).html('');
		$('.'+disp_on).select2().trigger('refresh');
		if(get_list =='state_list')
		{
			if($(".city_list_update").length > 0)
			{
				$(".city_list_update").html('');
				$('.city_list_update').select2().trigger('refresh');
			}
		}
	}
}
function dropdownChange_mul_2(currnet_id,disp_on,get_list)
{
	var base_url = $("#base_url").val();
	action = base_url+ 'common_request/get_list';
	var hash_tocken_id = $("#hash_tocken_id").val();
	currnet_val = $("."+currnet_id).val();
	if(currnet_val !='' && currnet_val !=null)
	{
		show_comm_mask();
		$.ajax({
		   url: action,
		   type: "post",
		   dataType:"json",
		   data: {'csrf_new_matrimonial':hash_tocken_id,'get_list':get_list,'currnet_val':currnet_val,'multivar':'multi','tocken_val':1},
		   success:function(data)
		   {
				$("."+disp_on).html(data.dataStr);
				update_tocken(data.tocken);
				$('.'+disp_on).select2().trigger('refresh');
				hide_comm_mask();
				if(get_list == 'state_list')
				{
					if($(".city_list_update").length > 0)
					{
						$(".city_list_update").html('');
						$('.city_list_update').select2().trigger('refresh');
					}
				}
		   }
		});
	}
	else
	{
		$("."+disp_on).html('');
		$('.'+disp_on).select2().trigger('refresh');
		if(get_list =='state_list')
		{
			if($(".city_list_update").length > 0)
			{
				$(".city_list_update").html('');
				$('.city_list_update').select2().trigger('refresh');
			}
		}
	}
}
function share_count(matri_id,link){
   var hash_tocken_id = $("#hash_tocken_id").val();
   var base_url = $("#base_url").val();
   $.ajax({
		url: base_url+'search/share_whatsapp_count',
		type: "post",
		dataType:"json",
		data: {"csrf_new_matrimonial":hash_tocken_id,"matri_id":matri_id},
		success:function(data){
         window.open(link, "_blank");
      }
   });
}