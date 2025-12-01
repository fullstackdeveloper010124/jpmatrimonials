<style type="text/css">
    h1{
        margin-top: 0px !important;
    }
   
</style>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Upcoming Events</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="box-main-s">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php if(isset($events) && $events !='' && is_array($events) && $events_data_count > 0){
	$datetime_bg_arr = array(
		'e-2','e-2_2','e-2_3','e-2_4'
	);
	$class_event_disp = 'five';
	if($events_data_count == 4 )
	{
		$class_event_disp = ' four ';
	}
	$event_sr = 0;
	?>
    <div class="container-fluid new-width">
        <div class="row margin-zero">
			<?php
			$i = 0;
            foreach($events as $events_value){
				$displ_class = '';
				if(isset($datetime_bg_arr[$event_sr]) && $datetime_bg_arr[$event_sr] !=''){
					$displ_class = $datetime_bg_arr[$event_sr];
				}
				$event_sr++;
				$event_image = $base_url.$this->common_model->no_image_found;
				if(isset($events_value['image']) && $events_value['image'] !='' && file_exists($this->common_model->path_events.$events_value['image'])){
                    $event_image = $base_url.$this->common_model->path_events.$events_value['image'];
                }
				if($i==0){
                    echo '<div class="row-cstm pt-3">';
                }
                else if($i%4==0){
                    echo '</div><div class="clearfix"></div><div class="row-cstm pt-6">';
                }
				
				if($i=='3' || $i=='6'){
					$event_sr = 0;
				}
				?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="events-box">
                        <div class="e-1">
                            <p class="Poppins-Bold f-25 color-f <?php if($displ_class !=''){ echo $displ_class;} ?>">
                                <span class="Poppins-Regular"><?php echo $this->common_model->displayDate($events_value['event_date'],'j');?></span> <?php echo $this->common_model->displayDate($events_value['event_date'],' F');?> <span class="Poppins-Regular"><?php echo $this->common_model->displayDate($events_value['event_date'],'Y');?></span>
                            </p>
                            <a href="<?php echo $base_url.'event/details/'.$events_value['id'];?>"><img src="<?php echo $event_image; ?>" alt="" class="img-responsive events-img1"></a>
                            <div class="e-t1">
                                <p class="Poppins-Semi-Bold f-18 color-22 e-t2"><?php if(isset($events_value['title'])) {echo $events_value['title'];}?></p>
                                <p class="Poppins-Regular f-14 color-5b l-height-24 e-t5"><?php 	
                                    $descri = $events_value['description'];
                                    $description = substr(strip_tags($descri),0,180);
									echo $description;if(strlen($descri)>180){echo '... <a href="'.$base_url.'event/details/'.$events_value['id'].'"><span class="Poppins-Semi-Bold color-d events-r-more">Read More</span></a>'; }
                                ?>
                                </p>
                            </div>
                            <hr class="events-hr">
                            <div class="e-t1-new">
                                <p class="Poppins-Regular f-14 color-46 e-t3"><i class="fas fa-clock ev-icon"></i> <?php echo $this->common_model->displayDate($events_value['event_date'],' jS-F-Y');?> (<?php if(isset($events_value['event_time'])) {echo $events_value['event_time'];}?>)</p>
                            </div>
                            <div class="e-t2">
                                <a href="<?php echo $base_url; ?>event/details/<?php echo $events_value['id'];?>"> <h2>
                                    <div class="Poppins-Medium f-17 color-f e-3">
                                        Register Now
                                    </div> </h2>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
				<?php if($i == count($events)-1){
					echo '</div>';
				}
				$i++;
			}?>
            <div class="clearfix"></div>
            <div class="row pt-5 padding-zero">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="pagination-wrap mt-0">
                    <?php if(isset($events_data_count) && $events_data_count !='' && $events_data_count > 0){
                        echo $this->common_model->rander_pagination_front('event/index',$events_data_count,$this->common_model->limit_per_page);
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php }else{?>
	<div class="container">
        <div class="row mt-3">
            <div class="col-md-12 col-sm-12 col-xs-12">
            	<div class="no-data-f">
	                <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
    	            <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                </div>
            </div>
    	</div>
	</div>
	<?php }?>