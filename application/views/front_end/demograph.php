<script src="https://www.google.com/jsapi"></script>

<div class="menu-bg-new">
	<div class="container-fluid new-width">
		<div class="row mt-5">
			<div class="col-md-4 col-sm-12 col-xs-12">
				<div class="box-main-s">
					<p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url; ?>">Home</a><span class="color-68"> / </span><span class="color-68">Member Demographic</span></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row mt-3">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="mega-box-new add-box-cstm new-member-demo">
				<div class="m-add-box">
					<h2 class="calibri-Bold-font f-22 color-31 t-transform-ue text-center ab-t1 new-member-demo-head">Select Gender</h2>
				</div>
				<div class="member-demo-box" id="member-demo-box">
					<div class="row">
                        <form method="post" id="myForm">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="member-radio">
                                    <input type="radio" name="radio" id="female" class="radio" value="Female">
                                    <label for="female">Female</label>
                                </div>
                                <sup class="sup-2"><span class="badge-member" id="count_female" ><?php echo $this->demograph_model->demograph_data('Female','All','All');?></span></sup>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="member-radio">
                                    <input type="radio" name="radio" id="male" class="radio" value="Male">
                                    <label for="male">Male</label>
                                </div>
                                <sup class="sup-2"><span class="badge-member" id="count_male"><?php echo $this->demograph_model->demograph_data('Male','All','All');?></span></sup>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="member-radio">
                                    <input type="radio" name="radio" id="Both" class="radio" value="Both" checked>
                                    <label for="Both">Both</label>
                                </div>
                                <sup class="sup-2"><span class="badge-member" id="count_both"><?php echo $this->demograph_model->demograph_data('All','All','All');?></span></sup>
                            </div>
                        </form>
					</div>
				</div>
				
				<div class="member-demo-box" style="margin: 0px 1%;width: 98%;">
					<div class="row">
						<div data-delay="500" class="col-md-6 col-sm-6 col-xs-12 animated" id="member_religion_chart">
							<div class="panel panel-primary panel-primary-2">
								<div class="panel-heading panel-member">
									<h3  class="panel-title">MEMBERS BY RELIGION</h3>
								</div>
								<div class="panel-body">
									<div id="chart_wrap-1">
										<div id="chart_div"></div>
									</div>
								</div>
							</div>
						</div>
						<div data-delay="500" class="col-md-6 col-sm-6 col-xs-12 animated" id="member_age_chart">
							<div class="panel panel-primary panel-primary-2">
								<div class="panel-heading panel-member">
									<h3  class="panel-title">MEMBERS BY AGE GROUP</h3>
								</div>
								<div class="panel-body">
									<div id="chart_wrap-2">
										<div id="chart_div-2"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- ======= <div class="container">   End======= -->
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
<?php
$this->common_model->js_extra_code_fr.="
	google.load('visualization', '1', {packages:['corechart']});
	google.setOnLoadCallback(drawChart1);
	
	function drawChart1(gender) {
		if(gender != 'Male' && gender != 'Female' && gender != 'Both'){
			gender = '';
		}
		var base_url = $('#base_url').val();
		var url = base_url+'demograph/relegion-chart';
		var hash_tocken_id = $('#hash_tocken_id').val();
		var jsonData = $.ajax({
			type:'POST',
			url: url,
			dataType: 'json',
			data : {'csrf_new_matrimonial':hash_tocken_id,'gender':gender},
			async: false
		}).responseText;
		var data = new google.visualization.DataTable(jsonData);			
		var options = {'title': '', 'chartArea': {'width': '100%', 'height': '80%'}, 'legend': {'position': 'right'}
		};
		var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
	$(window).on('throttledresize', function (event) {
		var options = {
			width: '100%',
			height: '100%'
		};
		var data = google.visualization.arrayToDataTable([]);
		drawChart(data, options);
	});

	google.load('visualization', '1', {packages:['corechart']});
	google.setOnLoadCallback(drawChart2);
	
	function drawChart2(gender) {
		if(gender != 'Male' && gender != 'Female' && gender != 'Both'){
			gender = '';
		}
		var base_url = $('#base_url').val();
		var url = base_url+'demograph/age-chart';
		var hash_tocken_id = $('#hash_tocken_id').val();
		var jsonData = $.ajax({
		type:'POST',
		url: url,
		dataType: 'json',
		data : {'csrf_new_matrimonial':hash_tocken_id,'gender':gender},
		async: false
		}).responseText;
		
		var data = new google.visualization.DataTable(jsonData);
		var options = {'title': '',
			'chartArea': {'width': '100%', 'height': '80%'},
			'legend': {'position': 'right'}
		};
		var chart = new google.visualization.PieChart(document.getElementById('chart_div-2'));
		chart.draw(data, options);
	}
	
	$(window).on('throttledresize', function (event) {
		var options = {
			width: '100%',
			height: '100%'
		};
		var data = google.visualization.arrayToDataTable([]);
		drawChart(data, options);
	});
	
	$('#member-demo-box').on('click','input[name=radio]', function(){
		var gender  = $('input[name=radio]:checked', '#myForm').val();
		if(gender != ''){
		var base_url = $('#base_url').val();
		var url = base_url+'demograph/gender-data';
		var hash_tocken_id = $('#hash_tocken_id').val();
		show_comm_mask();
		$.ajax({
			type:'POST',
			url: url,
			dataType: 'json',
			data : {'csrf_new_matrimonial':hash_tocken_id,'gender':gender},
			success: function(data)
			{
				if(gender == 'Male'){
					var male = (document.getElementById('count_male'));
					var result_count =male.textContent;
				}
				if(gender == 'Female'){
					var female = (document.getElementById('count_female'));
					var result_count =female.textContent;
				}
				if(gender == 'Both'){
					var both = (document.getElementById('count_both'));
					var result_count = both.textContent;
				}
				if(result_count != 0){
					$('#member_religion_chart').show();
					$('#member_age_chart').show();
					drawChart1(gender);
					drawChart2(gender);
				}else{
					$('#member_religion_chart').hide();
					$('#member_age_chart').hide();
				}
				update_tocken(data.tocken);
				hide_comm_mask();
			}
		});
		}else{
			alert('Please select gender..!!');
		}
	});
";?>