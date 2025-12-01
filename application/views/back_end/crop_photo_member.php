<?php $ver_cont = '2.1245'.rand(1000,412452455); 
$display_error = 1;
$pop_window_flag = 0; // 1 = pop up, 0 - window
?>
<style type="text/css">
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
}
.btn {
    padding-right: 15px;
    padding-left: 15px;
    outline: 0;
    font-size: 13px;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    -webkit-transition: all 300ms linear;
    -moz-transition: all 300ms linear;
    -o-transition: all 300ms linear;
    transition: all 300ms linear;
    line-height: 20px;
    position: relative;
    z-index: 1;
    -webkit-backface-visibility: hidden;
}
.btn-group-sm>.btn, .btn-sm {
    padding: 5px 10px;
    font-size: 12px;
    line-height: 1.5;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
}
.btn-danger {
    color: #fff;
    background-color: #d96557;
    border-color: #d96557;
}
.btn-primary{
    color: #fff;
    background-color: #09c;
    border-color: #007399;
}
.tools span
{
    font-size: 16px !important;
}
</style>
<link rel="stylesheet" href="<?php echo $base_url.'assets/back_end/styles/canvasCrop.css?ver='.$ver_cont; ?>" />
<script src="<?php echo $base_url; ?>assets/back_end/scripts/app.min.4fc8dd6e.js?ver=<?php echo $ver_cont; ?>"></script>
<script src="<?php echo $base_url; ?>assets/back_end/scripts/common.js?ver=<?php echo $ver_cont; ?>"></script>
<script src="<?php echo $base_url; ?>assets/back_end/scripts/canvasCrop.js"></script>
<?php
if(isset($photo_number) && $photo_number !='' && isset($member_id) && $member_id !='' && ($photo_number >=1 || $photo_number <=8))
{
	$photo_path = '';
	$where_arra = array('id'=>$member_id);
	$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'photo1,photo2,photo3,photo4,photo5,photo6,photo7,photo8,cover_photo');
	if(isset($row_data) && $row_data !='' && isset($row_data['photo'.$photo_number]) && $row_data['photo'.$photo_number] !='')
	{
		$photo_name = $row_data['photo'.$photo_number];
		$photo_path = $this->common_model->path_photos_big.$photo_name;
		if(file_exists($photo_path))
		{
			$display_error = 0;
		}
	}
	if($photo_path != '' && $display_error == 0)
	{
?>
<input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id;?>" />
<input type="hidden" name="photo_number" id="photo_number" value="<?php echo $photo_number;?>" />
<input type="hidden" name="file_name_upload" id="file_name_upload" value="<?php echo $photo_name;?>" />
<input type="hidden" name="base_url_admin_only" id="base_url_admin_only" value="<?php echo $base_url.$this->common_model->admin_path; ?>/" />
<input type="hidden" id="croped_base64" name="croped_base64" value="" />
<input type="hidden" id="orig_base64" name="orig_base64" value="" />
</head>
<body>
<?php
if($pop_window_flag == 0)
{
	$photo_path = '../../../../'.$photo_path; // for window
}
else
{
	$photo_path = '../../'.$photo_path; // for pop up
}
$photo_path = str_replace($this->common_model->path_photos_big,$this->common_model->path_photos_big.'nowatermark',$photo_path);

?>
<!--<script src="<?php echo $base_url; ?>assets/back_end/scripts/app.min.4fc8dd6e.js"></script>-->
<!--<script src="<?php echo $base_url; ?>assets/front_end/js/jquery.min.js"></script>-->
<div id="response_message"></div>
<div class="container-fluide" id="main_crop_image_area">
  <div class="imageBox" >
    <!--<div id="img" ></div>-->
    <!--<img class="cropImg" id="img" style="display: none;" src="images/avatar.jpg" />-->
    <div class="mask"></div>
    <div class="thumbBox"></div>
    <div class="spinner" style="display: none">Loading...</div>
  </div>
  <div class="tools clearfix">
    <span id="rotateLeft" >rotateLeft</span>
    <span id="rotateRight" >rotateRight</span>
    <span id="zoomOut" >zoomIn</span>
    <span id="zoomIn" >zoomOut</span>
    <!-- <span id="crop" >Crop</span> -->
    <!--<span id="alertInfo" >alert</span>
    <div class="upload-wapper">
               Select An Image
        <input type="file" id="upload-file" value="Upload" />
    </div>-->
  </div>
<div class="row"  align="center">
    <div class="col-md-12" style="padding:10px;">
        <div id="croped_img"></div>
    </div>
</div>  
</div>
<script type="text/javascript">
    $(function(){
		setTimeout(function(){
	        load_canvas_scrop("<?php echo $photo_path; ?>");
		},200);
    })
</script>
<?php
	}
	else
	{
		$display_error = 1;
	}
}
if($display_error == 1)
{
?>	
	<div class="alert alert-danger" style=" padding: 10px 15px;background-color: #f5d7d4; border-color: #f2ccc7;color: #a53325;">Sorry, Image not found, Please reload the page or upload Image and try again.</div>
<?php
}
?>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
<div class="row">
    <div class="col-md-12" style="padding:10px;" align="center">
		<!-- <a onClick="update_photo()" style="display:none" id="upload_btn" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Upload</a> -->
		<a id="crop" id="upload_btn" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Crop & Upload</a>
		<a onClick="closeWinOnCrop()" class="btn btn-sm btn-danger" data-dismiss="modal"><i class="fa fa-close"></i> Close</a>
	</div>
</div>