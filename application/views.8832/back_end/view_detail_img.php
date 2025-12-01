 <?php $defult_not_upload_src = 'assets/images/no_image.png';
  if(isset($img_list_arr) && $img_list_arr !='' && count($img_list_arr) > 0)
  {	
  	foreach($img_list_arr as $img_list)
  	{
		$gallary_title = $this->common_model->get_value($img_list,'title','No Title');
		$path_folder = $this->common_model->get_value($img_list,'path_value','');
		$filed_arr_img = $this->common_model->get_value($img_list,'filed_arr','');
		$class_width = $this->common_model->get_value($img_list,'class_width',' col-lg-3 col-md-4 col-sm-6  col-xs-12 ');
		$img_class = $this->common_model->get_value($img_list,'img_class',' img-responsive img-thumbnail');
		$inline_style = $this->common_model->get_value($img_list,'inline_style','');
		$display_status = $this->common_model->get_value($img_list,'display_status','');
		$display_name = $this->common_model->get_value($img_list,'display_name','');
		$status_fild_name = $this->common_model->get_value($img_list,'status_fild_name','');
		$not_upload_display = $this->common_model->get_value($img_list,'not_upload_display','');
?>
	<div class="panel panel-primary">
    	<div class="panel-heading">
        <div class="pull-left text-bold">
            <?php 
                if(isset($gallary_title) && $gallary_title !='')
                {
                    echo $gallary_title;
                }
                else
                {
                    echo $dna;
                } 
            ?>
        </div>
        <div class="panel-controls">
            <a href="#" class="panel-collapse" data-toggle="panel-collapse"> <i class="panel-icon-chevron"></i> </a>
         </div>
    </div>
    	<div class="panel-body form-horizontal ">
            <div class="row">
                <?php
                if(isset($filed_arr_img) && $filed_arr_img !='' && count($filed_arr_img) > 0)
                {
					$error_message = 1;
                    foreach($filed_arr_img as $filed_arr_img_val)
                    { 
						$file_name_img = '';
						if($filed_arr_img_val !='' && isset($data_array[$filed_arr_img_val]) && $data_array[$filed_arr_img_val] !='' && file_exists($path_folder.$data_array[$filed_arr_img_val]))
						{
							$file_name_img = $data_array[$filed_arr_img_val];
							$file_name_img = $path_folder.$file_name_img;
							$error_message = 0;
						}
						else if(isset($not_upload_display) && $not_upload_display =='yes')
						{
							$file_name_img = $defult_not_upload_src;
							$error_message = 0;
						}
						else
						{
							continue;
						}
                ?>
                <div class="<?php echo $class_width; ?> text-center mb20">
                	<?php 
					if(isset($display_name) && $display_name !='' && $display_name =='yes')
					{
						echo '<span class="text-bold">'.ucfirst($filed_arr_img_val).' &nbsp;&nbsp;&nbsp;<br/></span>';
					}
					?>
                    <img <?php echo $inline_style; ?> src="<?php echo $base_url.$file_name_img; ?>" class="magniflier <?php echo $img_class; ?>" alt="<?php echo $file_name_img;?>" />
                    <br/>
				<?php
                    if(isset($display_status) && $display_status !='' && $display_status =='yes' && $status_fild_name !='' && isset($data_array[$filed_arr_img_val.$status_fild_name]))
					{
						$photo_status_disp = $data_array[$filed_arr_img_val.$status_fild_name];
						
						if($photo_status_disp !='' && $photo_status_disp =='APPROVED')
						{
							echo '<span class="text-success text-bold"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;APPROVED</span>';
						}
						else
						{
							echo '<span class="text-danger text-bold"><i class="fa fa-thumbs-down"></i>&nbsp;&nbsp;UNAPPROVED</span>';
						}
					}
                ?>
                </div>
                <?php
                    }
					if(isset($error_message) && $error_message == 1)
					{
				?>
                <div class="alert alert-danger">Not uploaded yet.</div>
                <?php
					}
                }
                ?>
            </div>
        	</div>
	    </div>
<?php
	}
  }
 // $this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
?>	