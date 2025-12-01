<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Upcoming Events</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="box-main-s">
                    <p class="Poppins-Semi-Bold mega-n3 f-s">DETAIL OF <span class="mega-n4 f-s">EVENTS</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $images = array('image'=>$event_item['image'],
	'image_2'=>$event_item['image_2'],
	'image_3'=>$event_item['image_3'],
	'image_4'=>$event_item['image_4']);	
$path_events = $this->common_model->path_events;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12 pt-3">
            <div class="e-detail-box">
                <div class="event-box-m">
                    <div id="testimonial-slider12" class="owl-carousel">
                    <?php foreach($images as $image_val) 
					{	
						if(isset($image_val) && $image_val !='' && file_exists($path_events.$image_val))
						{?>
                            <div class="testimonial mp-zero" >
                                <img src="<?php echo $base_url.$path_events.$image_val;?>" alt="" class="img-responsive event-img">
                            </div>
						<?php }
                    }?>
                    </div>
                    <div class="events-inr-div">
                        <p class="Poppins-Bold f-21 color-22 events-a1"><?php if(isset($event_item['title'])) {echo $event_item['title'];}?></p>
						<?php if(isset($event_item['description']) && $event_item['description']!=''){ 
							$text = str_ireplace('<p>','<p class="Poppins-Regular l-height-28 f-14 clear-both color-5b">',$event_item['description']);
							echo $text;
						}?>
                        <div class="float-left-m Poppins-Medium f-14 mt-5">
                            <div class="color-46 Poppins-Regular f-14"><i class="fas fa-clock f-17 color-7c ev_d11"></i> &nbsp; <?php echo $this->common_model->displayDate($event_item['event_date'],' jS F - Y');?> (<?php if(isset($event_item['event_time'])) {echo $event_item['event_time'];}?>)</div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="float-left-m Poppins-Medium f-14 mt-4">
                            <div class="color-46 Poppins-Regular f-14"><i class="fas fa-map-marker-alt f-17 color-7c ev_d11"></i> &nbsp; &nbsp;<?php if(isset($event_item['venue'])) {echo $event_item['venue'];}?></div>
                        </div>
                        <div class="add-w-btn mt-5 width-197">
                            <a href="#event-book" data-toggle="modal" class="Poppins-Medium color-f f-18">Register Now</a>
                        </div>
                    </div>
                   
					<?php if(isset($event_item['map_address']) && $event_item['map_address']!=''){ ?>
                    
                    <div class="text-center col-sm-12 col-md-12 col-lg-12">
                    	<p class="Poppins-Semi-Bold mega-n3 f-s">FIND LOCATION FROM <span class="mega-n4 f-s">MAP</span></p>
                        <div class="n-map">
                            <div id="googleMap" class="map"></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="event-book" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="event-book" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-vendor">
    
    <form method="post" action="<?php echo $base_url; ?>event/checkout" name="check" id="check" enctype="multipart/form-data">
        <div class="modal-content">
            <div class="modal-header new-header-modal">
                <p class="Poppins-Bold mega-n3 new-event text-center">Book your <span class="mega-n4 f-s">Place</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="    margin-top: -37px !important;">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-6 col-xs-12">
                        <?php	
						if(isset($image_val) && $image_val !='' && file_exists($path_events.$image_val)){?>
                            <div class="testimonial mp-zero" >
                                <img src="<?php echo $base_url.$path_events.$image_val;?>" alt="" class="img-responsive img-brdg">
                            </div>
						<?php }?>
                    </div>
                    
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="color-46 Poppins-Regular f-14 mbm-20"><i class="fas fa-map-marked-alt f-17"></i> &nbsp; <span><strong> VENEUE : </strong></span> <span><?php if(isset($event_item['venue'])) {echo $event_item['venue'];}?></span></div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mbm-20">
                        <div class="color-46 Poppins-Regular f-14"><i class="fas fa-user f-17"></i> &nbsp; <span><strong> LIMITED : </strong></span> <span>UP TO <?php if(isset($event_item['limited'])) {echo $event_item['limited'];}?> PEOPLES  </span></div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-6 col-sm-6 col-xs-12 mbm-20">
                        <div class="color-46 Poppins-Regular f-14"><i class="fas fa-calendar-alt f-17"></i> &nbsp; <span><strong> DATE : </strong></span> <span><?php if(isset($event_item['event_date'])) {echo $event_item['event_date'];}?></span></div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mbm-20">
                        <div class="color-46 Poppins-Regular f-14"><i class="fas fa-clock f-17"></i> &nbsp; <span><strong> TIME : </strong></span> <span><?php if(isset($event_item['event_time'])) {echo $event_item['event_time'];}?></span></div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="color-46 Poppins-Regular f-14"><i class="fas fa-th-list f-17"></i> &nbsp; <span><strong> DESCRIPTION : </strong></span> </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <p class="event-p">
						<?php $descri= $event_item['description'];
							$description = substr(strip_tags($descri),0,150);
							echo $description;if(strlen($descri)>150){echo '...';}?>
                        </p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4 col-sm-6 col-xs-12 mbm-20">
                        <div class="color-46 Poppins-Regular f-14"><i class="fas  fa-ticket-alt f-17"></i> &nbsp; <span><strong> TICKET : </strong></span> <span class="color-d"><strong><?php if(isset($event_item['currency'])) {echo $event_item['currency'];}?> <?php if(isset($event_item['ticket'])) {echo $event_item['ticket'];}?></strong></span></div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12  mbm-20">
                        <div class="">
                            <select class="form-control select-cust" id="no_of_ticket" name="no_of_ticket" style="height:34px;">
                                <option value="" selected="" class="color-30">QTY</option>
                                <option value="1" class="color-65">1</option>
                                <option value="2" class="color-65">2</option>
                                <option value="3" class="color-65">3</option>
                                <option value="4" class="color-65">4</option>
                                <option value="5" class="color-65">5</option>
                                <option value="6" class="color-65">6</option>
                                <option value="7" class="color-65">7</option>
                                <option value="8" class="color-65">8</option>
                                <option value="9" class="color-65">9</option>
                                <option value="10" class="color-65">10</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="color-46 Poppins-Regular f-14"> <span><strong> TOTAL <?php if(isset($event_item['currency'])) {echo $event_item['currency'];}?> : </strong></span> <span style="color:#0dda0d;"><strong id="Total">0</strong></span></div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12 col-sm-3 col-xs-12">
                        <div class="left-zero" style="margin:10px auto;display:table;">
                            <input type="submit" class="add-w-btn Poppins-Medium color-f f-18" value="BOOKING NOW" onClick="return check_number()">
                        </div>
                    </div>
                </div>
                <?php
				$event_id = $event_item['id'];
				$event_title = $event_item['title'];
				$ticket_currency = $event_item['currency'];
				$ticket = $event_item['ticket'];
				$date = $this->common_model->displayDate($event_item['event_date'],' jS F - Y');
				$location = $event_item['venue'];			
            	$data_array = array('event_id'=>$event_id,'title'=>$event_title,'ticket_currency'=>$ticket_currency,'ticket'=>$ticket,'event_date'=>$date,'location'=>$location);
				$this->session->set_userdata('event_data_session',$data_array);
			?>
            </div>
        </div>
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id1" />
	</form>
    </div>
</div>
<?php
$map_address = $event_item['map_address'];
$map_address = str_replace("\n", "", $map_address);
$map_address = str_replace("\r", "", $map_address);
$map_tooltip = $event_item['map_tooltip'];
$map_tooltip = str_replace("\n", "", $map_tooltip);
$map_tooltip = str_replace("\r", "", $map_tooltip);
$event_item['map_address'] = $map_address;
$event_item['map_tooltip'] = $map_tooltip;
$htpp_web = 'http';
if(strpos(base_url(),'https') === false){}
else{
	$htpp_web = 'https';
}
?>
<script src="<?php echo $htpp_web; ?>://maps.googleapis.com/maps/api/js?key=AIzaSyArZ7otxoqUtWWNbIW9-vBst3uevYRan7g"></script>
<?php
	$this->common_model->js_extra_code_fr.="
	(function($){
		$(document).ready(function(){
			$('#googleMap').gMap({
				maptype: 'ROADMAP',
				scrollwheel: false,
				zoom: 13,
				markers: [
					{
						address: '".$event_item['map_address']."',
						html: '".$event_item['map_tooltip']."',
						popup: true,
					}
				],
			});
		   });
	})(this.jQuery);
	
	if($('#enquiry_form').length > 0)
	{
		$('#enquiry_form').validate({
			submitHandler: function(form)
			{
				return true;
			}
		});
	}
		
	$(document).ready(function(){		
		$('#no_of_ticket').change(function(){		
			var no_of_ticket = $('#no_of_ticket').val();
			var totalTotal2 = ((no_of_ticket * '".$event_item['ticket']."'));
			var totalTotal=totalTotal2;		
			$('#Total').text(totalTotal);
		});
	});
	function check_number(){
		if( document.check.no_of_ticket.value == '' ){
			alert('Please select how many tickets you would like to buy');
			document.check.no_of_ticket.focus() ;
			return false;
		}	
	}
";?>