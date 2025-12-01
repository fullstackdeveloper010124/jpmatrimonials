<?php
$gender = $this->common_front_model->get_session_data('gender');
$path_horoscope = $this->common_model->path_horoscope;
if(isset($register_data['horoscope_photo']) && $register_data['horoscope_photo'] !='')
{
    $horoscope_photo = $register_data['horoscope_photo'];
}
$horo_defult_photo = $base_url.$this->common_model->no_image_found;
?>
<div class="container-fluid width-95 mt-40-pro mt-4">
    <div class="row-cstm">
        <!--for Desktop start--> 
        <?php include_once('my_profile_sidebar.php');?>
        <!--for Desktop end--> 
        <div class="col-md-9 col-sm-12 col-xs-12">
            <?php include_once('my_dashboard_info.php');?>
			<div class="m-b mt-4 upload_v_box">
            		<div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <p class="Poppins-Regular f-14 color-65 text-center">Upload With Youtube Link</p>	
                        </div>
                    </div>
                    <hr class="Upload_v_hr">
                    
                    <div class="row">
                    	<div class="col-md-12 col-sm-12 col-xs-12">
                    		<p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center upload_v_caption">Upload 
							<span class="color-d">Video</span></p>
                    	</div>
                    </div>
                    <?php 
					
					if(isset($video_data['video_url']) && $video_data['video_url']!='')
					{
						preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $video_data['video_url'], $match);
						$youtube_id = $match[1];
						
					?>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="setvideo">
                            <object  class="video-object" data="https://www.youtube.com/v/<?php echo $youtube_id;?>"></object>
                        </div>
					</div>
                    <?php }else{?>
                        <div id="novideo" style="display:none">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="xxl-16 xl-16 video-effect embed-responsive embed-responsive-16by9" id="setvideo">
                                    <iframe id="ytiframe" class="" width="740" height="400"  style="box-shadow:3px 3px 0 0 #ccc;" src=""  allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <form method="post" action="" id="upload_video" name="upload_video">
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id"  class="hash_tocken_id" />
        	            <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 col-xs-12">
	                            <div id="respond_message"></div> 
                            </div>
                        </div>
                        <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="upload_v_link">
                                    <input type="text" class="form-control ni-input w-100 fontAwesome h50-px" name="youtube" placeholder="&#xf16a; Enter Your Youtube Link Here" name="videoUrl" id="videoUrl">    
                                </div>
                            </div> 
                        </div>
                        
                        <div class="row margin-0">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="button" class="dshbrd_21 Poppins-Medium f-17 color-f upload_v_submit" onclick="add_video()">Submit</button>
                                <button type="button" class="dshbrd_21 Poppins-Medium f-17 color-f upload_v_submit" onclick="cancle_video()">Cancel</button>
								<button type="button" class="dshbrd_21 Poppins-Medium f-17 color-f upload_v_submit" onclick="del_video()">Delete</button>
							</div>
                        </div>
                    </form>
            	</div>
            </div>
        </div>
        <!--for mobile Start-->
    </div>
</div>

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
<?php
$this->common_model->js_extra_code_fr.="
function youtube_link_validation(url) {
	var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:watch\?v=))((\w|-){11})(?:\S+)?$/;
	return (url.match(p)) ? true : false;
}

function cancle_video(){
	document.getElementById('videoUrl').value = '';
}
function add_video(){
	var videoUrl = $('#videoUrl').val();
	
	if(videoUrl != ''){
		var matches = youtube_link_validation(videoUrl);
	}
	else{
		alert('Please enter youtube link..!!!')
		return false;
	}
	if(matches){
		var hash_tocken_id = $('#hash_tocken_id').val();
		var base_url = $('#base_url').val();
		var url = base_url+'upload/add-video';
		
		show_comm_mask();
		$.ajax({
			type: 'POST',
			url: url,
			data: {'videoUrl':videoUrl,'csrf_new_matrimonial':hash_tocken_id},
			dataType:'json',
			success: function(data){
				$('#respond_message').html(data.errmessage);
				$('#respond_message').slideDown();
				if(data.status == 'success'){
					$('#respond_message').addClass('alert alert-success');
					$('#videoUrl').val('');
					$('#novideo').show();
					window.setTimeout(function(){
						$('#respond_message').hide();
						$('#respond_message').html('');
						location.reload();
					}, 2000);
				}
				else{
					$('#respond_message').addClass('alert alert-danger');
				}
				update_tocken(data.tocken);
				hide_comm_mask();
			},
			error: function (jqXHR, exception) {
				var msg = '';
				if (jqXHR.status == 404) {
					msg = 'Requested page not found. [404]';
				} else if (jqXHR.status == 500) {
					msg = 'Internal Server Error [500].';
				} else if (exception === 'parsererror') {
					msg = 'Requested JSON parse failed.';
				} else if (exception === 'timeout') {
					msg = 'A time out error occured. Please try again';
				} else if (exception === 'abort') {
					msg = 'Ajax request aborted.';
				} else {
					msg = 'Uncaught Error.';
				}
				hide_comm_mask();
				alert(msg);
			},
			timeout: 8000
		});
		return false;
	}
	else{
		alert('Please enter youtube link only..!!!');
	}
}

function del_video(){

	var result = confirm('Are you sure delete this video?');
	if (result) {
		
			var hash_tocken_id = $('#hash_tocken_id').val();
			var base_url = $('#base_url').val();
			var url = base_url+'upload/delete-video';
			
			show_comm_mask();
			$.ajax({
				type: 'POST',
				url: url,
				data: {'csrf_new_matrimonial':hash_tocken_id},
				dataType:'json',
				success: function(data){
			
					$('#respond_message').html(data.errmessage);
					$('#respond_message').slideDown();
					if(data.status == 'success'){
						$('#respond_message').addClass('alert alert-success');
						$('#videoUrl').val('');
						$('#novideo').show();
						window.setTimeout(function(){
							$('#respond_message').hide();
							$('#respond_message').html('');
							location.reload();
						}, 2000);
					}
					else{
						$('#respond_message').addClass('alert alert-danger');
					}
					update_tocken(data.tocken);
					hide_comm_mask();
				},
				error: function (jqXHR, exception) {
					var msg = '';
					if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'A time out error occured. Please try again';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.';
					}
					hide_comm_mask();
					alert(msg);
				},
				timeout: 8000
			});
		}
		
	}

";
?>