<?php
if(!isset($back_detail_url))
{
	$back_detail_url = '';
}
$contact_arr = array('address','city','phone','mobile','email','city_name');
?>
<div align="left no-print">
    <!--<a class="btn btn-info" href="<?php //echo $base_url.$this->common_model->admin_path.'/'.$this->common_model->class_name.'/'.$back_detail_url; ?>"><i class="fa fa-arrow-left"></i> Back to list</a>-->
    <div class="row">
    <div class="col-xs-12">
       	<div align="left">
        <a class="btn btn-info" href="<?php echo $base_url.$this->common_model->admin_path.'/'.$this->common_model->class_name.'/'.$back_detail_url; ?>"><i class="fa fa-arrow-left"></i> Back to list</a>
        <?php
		if(isset($this->common_model->class_name) && $this->common_model->class_name =='member')
		{
		?>
        <label onClick="window.print()" style=" text-align:center; cursor:pointer;">
		&nbsp;&nbsp;&nbsp;<img src="<?php echo $base_url; ?>assets/back_end/images/print.png" >
			<span><strong>Print Profile</strong></span>
         </label>   
        <?php
		}
		?>    
        </div>
    </div>
    <br/><br/>
</div>
<?php $dna = $this->common_model->data_not_availabel;
$base_url = base_url();
if((!isset($data_array) || count($data_array) ==0 ) && $id !='' && $this->common_model->table_name !='')
{
	$table_name = $this->common_model->table_name;
	$primary_key = $this->common_model->primary_key;
	$data_array = $this->common_model->get_count_data_manual($table_name,array($primary_key=>$id),1,' * ','',0,'',0);
}
if(isset($data_array) && $data_array !='' && count($data_array) > 0)
{
	if(!isset($img_position) || $img_position !='top')
	{
		$img_position = 'bottom';
	}
	$temp_img = array();
	if(isset($img_list_arr) && $img_list_arr !='')
	{
		$temp_img['img_list_arr'] = $img_list_arr;
		$temp_img['data_array'] = $data_array;
		$img_content = $this->load->view('back_end/view_detail_img',$temp_img,true);
	}
	// for display image on top
	if(isset($img_position) && $img_position =='top' && isset($img_content) && $img_content !='')
	{
		echo $img_content;
	}
	// for display image on top
	if(isset($field_list) && $field_list !='' && count($field_list) > 0)
	{
		$detail_label_col_comm = $this->common_model->detail_label_col;
		$detail_val_col_comm = $this->common_model->detail_val_col;
		$detail_class_width_comm = $this->common_model->detail_class_width;
		foreach($field_list as $field_list_val)
		{
			$title = $this->common_model->get_value($field_list_val,'title','');
			$class_width = $this->common_model->get_value($field_list_val,'class_width',$detail_class_width_comm);
			$is_single = $this->common_model->get_value($field_list_val,'is_single','');
			$title_from_arr = $this->common_model->get_value($field_list_val,'title_from_arr','');
			$sub_title_from_arr = $this->common_model->get_value($field_list_val,'sub_title_from_arr','');
			$custome_code = $this->common_model->get_value($field_list_val,'custome_code','');
			
			$font_aw_ico_lab = $this->common_model->get_value($field_list_val,'fa_icone','');
			$fa_icone_code_lab = '';
			if($font_aw_ico_lab !='')
			{
				$fa_icone_code_lab = "<i class='$font_aw_ico_lab'>&nbsp;</i>";
			}
			if($custome_code !='')
			{
				echo $custome_code;
			}
			$detail_label_col_com = $this->common_model->get_value($field_list_val,'label_width',$detail_label_col_comm);
			$detail_val_col_com = $this->common_model->get_value($field_list_val,'val_width',$detail_val_col_comm);
			
			if(isset($title_from_arr) && $title_from_arr !='' && isset($data_array[$title_from_arr]) && $data_array[$title_from_arr] !='')
			{
				$title = $data_array[$title_from_arr];
			}
			if(isset($sub_title_from_arr) && $sub_title_from_arr !='' && isset($data_array[$sub_title_from_arr]) && $data_array[$sub_title_from_arr] !='')
			{
				$sub_title_from_arr = $data_array[$sub_title_from_arr];
			}
			
			$field_array = $this->common_model->get_value($field_list_val,'field_array','');
			if(isset($field_array) && $field_array !='' && count($field_array) > 0)
			{
				
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="pull-left text-bold">
                <?php 
					if($fa_icone_code_lab !='')
					{
						echo $fa_icone_code_lab;
					}
					if(isset($title) && $title !='')
					{
						echo $title;
						if(isset($sub_title_from_arr) && $sub_title_from_arr !='')
						{
							echo ' ('.$sub_title_from_arr.')';
						}
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
        <div class="panel-body form-horizontal">
            <div class="row">
            	<?php
				foreach($field_array as  $key => $field_array_val)
				{
					$class_width_temp = $this->common_model->get_value($field_array_val,'class_width',$class_width);
					$is_single_temp = $this->common_model->get_value($field_array_val,'is_single',$is_single);
				?>
	                <div class="<?php echo $class_width_temp; ?>">
                <?php
					if(isset($is_single_temp) && $is_single_temp !='' && $is_single_temp =='yes')
					{
						$disp_label = $this->common_model->get_value($field_array_val,'disp_label','');
						if($disp_label !='' && $disp_label =='yes')
						{
							$label = $this->common_model->get_label($field_array_val,$key);
							echo '<label class="control-label flpt0">'.$label.' :</label>';
						}
						$value_disp = '';
						if(isset($data_array[$key]) && $data_array[$key] !='')
						{
							$value_disp = $data_array[$key];
						}
						else
						{
							$value_disp = $dna;
						}
				?>                	
                		<p>
                        	<?php echo $value_disp; ?>
                		</p>
                <?php
					}
					else
					{
						$label = $this->common_model->get_label($field_array_val,$key);
						$class = $this->common_model->get_value($field_array_val,'class','');
						if($key=='total_children'){
							if($data_array["marital_status"]=='Unmarried'){
								$val_disp = 'N/A';
							}else{
								$val_disp = $this->common_model->get_value($data_array,$key,'');
							}
						}
						elseif($key=='status_children')
						{
							if($data_array["marital_status"]=='Unmarried'){
								$val_disp = 'N/A';
							}else{
								$val_disp = $this->common_model->get_value($data_array,$key,'');
							}
						}
						else if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && isset($contact_arr) && in_array($key,$contact_arr))
						{
							$val_disp = $this->common_model->disable_in_demo_text;
						}
						else
						{
							$val_disp = $this->common_model->get_value($data_array,$key,'');
						}
						$inline_style = $this->common_model->get_value($field_array_val,'inline_style','');
						$type = $this->common_model->get_value($field_array_val,'type','');
						$pre_filed = $this->common_model->get_value($field_array_val,'pre_filed','');
						$post_filed = $this->common_model->get_value($field_array_val,'post_filed','');
						$call_back_fun = $this->common_model->get_value($field_array_val,'call_back','');

						$label_width = $this->common_model->get_value($field_array_val,'label_width',$detail_label_col_com);
						$val_width = $this->common_model->get_value($field_array_val,'val_width',$detail_val_col_com);
						$font_aw_ico = $this->common_model->get_value($field_array_val,'fa_icone','');
						$fa_icone_code = '';
						if($font_aw_ico !='')
						{
							$fa_icone_code = "<i class='$font_aw_ico'>&nbsp;</i>";
						}
						if($call_back_fun !='')
						{
							$val_disp = $this->common_model->$call_back_fun($val_disp);
						}
				?>
                        <div class="form-group mb0">
                            <label class="col-sm-<?php echo $label_width;?> col-xs-<?php echo $label_width;?> control-label"><?php echo $fa_icone_code.$label; ?></label>
                            <label class="col-sm-<?php echo $val_width;?> col-xs-<?php echo $val_width;?> control-label-val">
                                <strong>:</strong>&nbsp;
                                <span style="<?php echo $inline_style; ?>" class="<?php echo $class; ?>">
                                <?php 
									if($val_disp !='')
									{
										if($type == 'date')
										{
											$format = $this->common_model->get_value($field_array_val,'format','');
											if($format !='')
											{
												echo $this->common_model->displayDate($val_disp,$format);
											}
											else
											{
												echo $this->common_model->displayDate($val_disp);
											}
										}
										else if($type == 'time')
										{
											echo $this->common_model->displayDate($val_disp,'h:i A');
										}
										else if($type =='link')
										{
									?>
										<a style="<?php echo $inline_style; ?>" class="<?php echo $class; ?>" target="_blank" href="<?php echo $val_disp; ?>"><?php echo $val_disp; ?></a>
									<?php
										}
										else if($type =='link_attachment')
										{
									?>
										<a style="<?php echo $inline_style; ?>" class="<?php echo $class; ?>" target="_blank" href="<?php echo $base_url.'ticket_attachment/'.$val_disp; ?>">View Attachment </a>
									<?php
										}
										else if($type =='relation')
										{
											$table_name_dis = $this->common_model->get_value($field_array_val,'table_name','');
											$prim_id = $this->common_model->get_value($field_array_val,'prim_id','id');
											$disp_column_name = $this->common_model->get_value($field_array_val,'disp_column_name','');
											if($table_name_dis !='')
											{
												$data_disp_temp = $this->common_model->valueFromId($table_name_dis,$val_disp,$disp_column_name,$prim_id);
												if($data_disp_temp !='')
												{
													echo $data_disp_temp;
												}
												else
												{
													$dna;
												}
												//($table_name='',$arry_id='',$clm_value='',$id_clm='id',$return_type = 'str',$delimetor=',');
											}
											else
											{
												echo $dna;
											}
										}
										else if($pre_filed !='')
										{
											echo $this->common_model->get_value($data_array,$pre_filed,'').' ';
											echo $val_disp;
										}
										else if($post_filed !='')
										{
											echo $val_disp.' ';
											$post_filed_val = $this->common_model->get_value($field_array_val,'post_filed_val','');
											
											$post_filed_call_back = $this->common_model->get_value($field_array_val,'post_filed_call_back','');
											echo $post_filed_concate = $this->common_model->get_value($field_array_val,'post_filed_concate','');
											if($post_filed_val !='')
											{
												echo $post_filed_val;
											}
											else
											{
												$post_fild_val = $this->common_model->get_value($data_array,$post_filed,'');
												$post_filed_call_back = $this->common_model->get_value($field_array_val,'post_filed_call_back','');
												if($post_filed_call_back !='' && $post_fild_val !='')
												{
													$post_fild_val = $this->common_model->$post_filed_call_back($post_fild_val);
												}
												echo $post_fild_val;
												echo $this->common_model->get_value($field_array_val,'post_filed_val_after','');
											}
										}
										else									
										{
											echo $val_disp;
										}
									}
									else
									{
										echo $dna;
									}
                                ?>
                                </span>
                            </label>
                        </div>
                <?php
					}
				?>        
                    </div>
                <?php
				}
				?>
            </div>
        </div>
    </div>
<?php
			}
		}
	}
	// for display image on bottom
	if(isset($img_position) && $img_position =='bottom' && isset($img_content) && $img_content !='')
	{
		echo $img_content;
	}
	// for display image on bottom
}
else
{
?>
<div class="alert alert-danger">No Data available</div>
<?php
}
?>
</div>