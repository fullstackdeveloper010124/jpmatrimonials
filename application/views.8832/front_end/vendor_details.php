<?php $id_details = $wedding_planner_item['id'];?>
		<style>
			
			.cstm-logo{
			padding: 0px 0px !important;
			position: relative!important;
			top: -6px!important;
			}
			#slider-2 .item img {
			display: block;
			max-width: 100%;
			height: 503px;
			border-radius: 7px;
			}
			#slider-2 .item:before{
			
			}
			.thumbnail > img, .thumbnail a > img {
			margin-right: auto;
			margin-left: auto;
			height: 101px;
			width: 100%;
			}
			.carousel-control {
			position: absolute;
			bottom: 10px;
			left: 0;
			width: 18%;
			font-size: 30px;
			color: #fff;
			text-align: center;
			text-shadow: none;
			background-color: rgba(0, 0, 0, 0);
			filter: alpha(opacity=50);
			opacity: 1;
			top: auto;
			}
		/* rating css start */
						@charset "UTF-8";
.star-cb-group {
  /* remove inline-block whitespace */
  font-size: 0;
  /* flip the order so we can use the + and ~ combinators */
  unicode-bidi: bidi-override;
  direction: rtl;
  /* the hidden clearer */
}
.star-cb-group * {
  font-size: 1rem;
}
.star-cb-group > input {
  display: none;
}
.star-cb-group > input + label {
  /* only enough room for the star */
  display: inline-block;
  overflow: hidden;
  text-indent: 9999px;
  width: 2em;
  white-space: nowrap;
  cursor: pointer;
}
.star-cb-group > input + label:before {
  display: inline-block;
  text-indent: -9999px;
  content: "☆";
  color: #d12220;
  font-size: 25px;
}
.star-cb-group > input:checked ~ label:before, .star-cb-group > input + label:hover ~ label:before, .star-cb-group > input + label:hover:before {
  content: "★";
  color: #d12220;
  text-shadow: 0 0 1px #333;
  font-size: 25px;
}
.star-cb-group > .star-cb-clear + label {
  text-indent: -9999px;
  width: .5em;
  margin-left: -.5em;
  font-size: 18px;
}
.star-cb-group > .star-cb-clear + label:before {
  width: .5em;
  font-size: 25px;
}
.star-cb-group:hover > input + label:before {
  content: "☆";
  color: #d12220;
  text-shadow: none;
  font-size: 25px;
}
.star-cb-group:hover > input + label:hover ~ label:before, .star-cb-group:hover > input + label:hover:before {
  content: "★";
  color: #d12220;
  text-shadow: 0 0 1px #333;
  font-size: 25px;
}
/* rating css end */
.arrow_color{color: #ececec;}

@media only screen and (max-device-width: 777px) {
	.pllner.mega-n4{
		font-size: 22px!important;
		text-align: center;
	}
}
		</style>
	
		<div class="menu-bg-new">
			<div class="container-fluid new-width">
				<div class="row mt-50">
					<div class="col-md-4 col-sm-12 col-xs-12 ">
						<div class="box-main-s">
							<p class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Vendor List</span></p>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 text-center">
						<div class="box-main-s">
							<!-- <p class="Poppins-Semi-Bold mega-n3 f-s">Wedding<span class="mega-n4 f-s"> Planner</span></p> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="contact-tab" style="margin-top:-8px;">
			<div class="container-fluid new-width">
				<div class="row">
					<div class="col-md-12">
						<div class="tab contact-tab-m contact-tab-vendor" role="tabpanel">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs contact-tab-nav" role="tablist">
								<li role="presentation" class="active f-17">
									<a href="#photo-section" aria-controls="photo-section" role="tab" data-toggle="tab">
										<i class="far fa-image"></i>
									Photos</a>
								</li>
								<li role="presentation" class="f-17">
									<a href="#about-section" aria-controls="about-section" role="tab" data-toggle="tab">
										<i class="fas fa-address-card"></i>
									About</a>
								</li>
								<li role="presentation" class="f-17">
									<a href="#reviews-section" aria-controls="reviews-section" role="tab" data-toggle="tab"> <i class="far fa-comment-dots"></i> Reviews</a>
								</li>
							</ul>
							<!-- Tab panes -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container new-width">
			<div class="row mt-3">
				<div class="col-md-8 col-sm-12 col-xs-12">
					<div class="tab-content tabs">
						<div role="tabpanel" class="tab-pane fade in active" id="photo-section">
							<div class="mega-box-new">
								<div id="main_area">
									<!-- Slider -->
									<div class="row">
										
										<div class="col-md-7 col-xs-12 col-sm-7 pr-0">
											<div class="col-xs-12" id="slider-2">
												<!-- Top part of the slider -->
												<div class="row">
													<div class="col-sm-12 pr-0" id="carousel-bounding-box">
														<div class="carousel slide" id="myCarousel">
															<!-- Carousel items -->
															<div class="carousel-inner">
				<?php 
				$no_images = $this->common_model->no_image_found;
				$images = array('image'=>$wedding_planner_item['image'],
									'image_2'=>$wedding_planner_item['image_2'],
									'image_3'=>$wedding_planner_item['image_3'],
									'image_4'=>$wedding_planner_item['image_4'],
									'image_5'=>$wedding_planner_item['image_5']);			
				  $path_wedding = $this->common_model->path_wedding;
				  $wedding_cont=0;
				foreach($images as $image_val) 
				{	
				 	if(isset($image_val) && $image_val !='' && file_exists($path_wedding.$image_val))
					{ ?>
												<div class="<?php if(isset($wedding_cont) && $wedding_cont==0){ echo 'active';}?> item" data-slide-number="<?php echo $wedding_cont;?>">
																<img src="<?php echo $base_url; ?><?php echo $path_wedding;?><?php echo $image_val;?>"></div>
												
												<?php 
											$wedding_cont++;	
											}
												
				} 
				if(isset($wedding_cont) && $wedding_cont==0)
				{?>
					<div class="active item" data-slide-number="0">
					<img src="<?php echo $base_url.$no_images;?>"></div>
					
			<?php	}
				?>
															
															</div>
															<!-- Carousel nav -->
															<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
																<span class="fa fa-arrow-left arrow_color"></span>
															</a>
															<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
																<span class="fa fa-arrow-right arrow_color"></span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="col-md-5 col-xs-12 col-sm-5" id="slider-thumbs" style="padding-left: 0px;">
											<!-- Bottom switcher of slider -->
											<ul class="hide-bullets">
											<?php $images = array('image'=>$wedding_planner_item['image'],
									'image_2'=>$wedding_planner_item['image_2'],
									'image_3'=>$wedding_planner_item['image_3'],
									'image_4'=>$wedding_planner_item['image_4'],
									'image_5'=>$wedding_planner_item['image_5']);			
				  $path_wedding = $this->common_model->path_wedding;
				  
				  $wedding_con=0;
				foreach($images as $image_val) 
				{	
				 	if(isset($image_val) && $image_val !='' && file_exists($path_wedding.$image_val))
					{ ?>
												<li class="col-sm-6 col-xs-6 col-md-6">
													<a class="thumbnail" id="carousel-selector-<?php echo $wedding_con;?>">
														<img src="<?php echo $base_url; ?><?php echo $path_wedding;?><?php echo $image_val;?>">
													</a>
												</li>
												<?php 
											$wedding_con++;	
											}
												
				} 
				if(isset($wedding_con) && $wedding_con==0)
				{?>
				<li class="col-sm-6 col-xs-6 col-md-6">
													<a class="thumbnail" id="carousel-selector-0">
														<img src="<?php echo $base_url.$no_images;?>">
													</a>
												</li>
					
			<?php	}
				?>			
												
											</ul>
										</div>
										<!--/Slider-->
									</div>
									
								</div>
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="about-section">
							<div class="mega-box-new">
								<p class="Poppins-Regular f-15 color-2d l-height-28 mega-t1">
								<?php 
									if(isset($wedding_planner_item['description']))
									{
										echo $wedding_planner_item['description'];
									}
									?>
								</p>
								
								
							</div>
						</div>
						<div role="tabpanel" class="tab-pane fade" id="reviews-section">
							<div class="mega-box-new">
								<div class="row m-t-0 new-row">
									<div class="col-md-12 col-xs-12 col-sm-12 prld-zero" style="border: 1px solid #a6a6a6;border-radius:6px;">
										<div class="min-height-scroll">
											<button class="add-w-btn new-write Poppins-Medium color-f f-18" data-toggle="modal" data-target="#write-review">
												<i class="fas fa-pencil-alt"></i> Write Review 
											</button>
											<div class="row">
												<div class="col-md-12 col-sm-12 col-xs-12">
												<?php if($wedding_planner_reviews_count > 0){ ?>
													<div class="chat_area">
														<ul class="list-unstyled">
														<?php 
														$i=0;
												foreach($wedding_planner_reviews as $rows_reviews) 
												{		
											?>
															<li class="left clearfix <?php if(isset($i) && $i==0){echo 'm-t-20';}?>">
																<!-- <span class="chat-img pull-left">
																	<img src="images/2.jpg" alt="User Avatar" class="img-circle chat-img1">
																</span> -->
																<div class="	 ">
																	<p class="user-p Poppins-Medium font-s m-b-0"><?php echo $rows_reviews['r_name'];?></p>
																	<p class="last-m">Last Comment <?php echo $this->common_model->some_time_ago($rows_reviews['r_date']);?> ago</p>
																	<div class="chat_time last-m"><?php echo $rows_reviews['r_message'];?></div>
																</div>
															</li>
															
															<?php
														$i++; 
														} ?> 
														</ul>
														</div>
														<?php }else{ ?>
												<div class="row-center">
													<h2 style="padding: 15px 0;color: #3121f8 !important;">
														There is no any review..!!!
													</h2>
												</div>

											<?php } ?> 
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mega-box-new" id="venue">
						<div class="m-add-box">
							<p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center ab-t1">Send Enquiry To
							<span class="color-d">Vendor</span></p>
							<?php	
							
								if($this->session->flashdata('email_success_message'))
								{
								?>
								<div class="alert alert-success"><?php
									echo $this->session->flashdata('email_success_message'); ?>
								</div>
								<?php
									}
								?>
								<?php
									if($this->session->flashdata('email_error_message'))
									{
								?>
								<div class="alert alert-danger">
									<?php echo $this->session->flashdata('email_error_message'); ?>
								</div>
								<?php
									}
								?>
                            <div class="alert alert-success" id="email_success_message"  style="display:none"></div>
                            <div class="alert alert-danger" id="email_error_message" style="display:none"></div>    
                            <div class="clearfix"><br/></div>
							<div class="add-box-2">
							<form class="margin-top-20" action="<?php echo $base_url; ?>wedding_vendor/send_enquiry_to_planner/<?php echo $id_details ;?>" method="post" name="enquiry_form" id="enquiry_form" enctype="multipart/form-data">
								<div class="row add-b-cstm">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Name<span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="add-input">
											
											<input type="text" id="name" name="name" placeholder="Enter Your Name" class="form-control ni-input" required value=""/>
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-4">
									<div class="col-md-3 col-sm-3 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Phone <span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<select name="country_code" id="country_code" class="mdb-select md-form md-outline colorful-select dropdown-primary ni-input2 lk_211" style="right:0px;">
											<?php echo $this->common_model->country_code_opt('+91');?>
										</select>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="add-input">
											<input id="phone" name="phone" type="text" placeholder="Enter Your Contact Number" class="form-control ni-input" minlength="8" maxlength="13" required="required" />
                                            <span class="help-block">
										</div>
									</div>
								</div>
								
								<div class="row add-b-cstm mt-4">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Email <span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="add-input">
											<input id="email" name="email" type="email" placeholder="E-Mail" class="form-control ni-input" required/>
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-4">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Wedding Date <span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="add-input">
											<input type="text" id="datepicker-example1" name="weddingdate" class="form-control ni-input"  placeholder="Wedding Date">
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-4">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Guest <span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="add-input">
										<select id="guest" name="guest" class="form-control select-cust" style="height:44px;background: url(images/down-gray-arrow.png)no-repeat 97% !important;" required>
												<option value="" selected="" class="color-30">Select Number Of Guest</option>
												<option value="50 to 100">50 to 100</option>
												<option value="101  to 150">101  to 150</option>
												<option value="151 to 200">151 to 200</option>
												<option value="200 and above">200 and above</option>
											</select>
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-4">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Description <span class="f-16 select2-lbl-span">*</span>:</p>
									</div>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<div class="add-input">
											<textarea class="form-control" name="description" id="description" placeholder="Description" rows="5" required ></textarea>
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-4">
									<div class="col-md-3 col-sm-3 col-xs-12">
									</div>
									<div class="col-md-3 col-sm-3 col-xs-12">
										<div class="mbm-10 cptc_img" style="right:0px;">
										<p class="color-f Poppins-Medium f-18"><img class="margin-zero" style="float:left;margin: -10px 0px 0px -5px;" alt="captch-code" src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_vendor']; ?>" /></p>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="add-input">
											<input  type="number" name="code_captcha" id="code_captcha" class="form-control ni-input" placeholder="Enter Captcha Code" value="" required />
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-3">
									<div class="col-md-4 col-sm-4 col-xs-12">
										<p class="Poppins-Medium f-16 color-31 ad-name">Send Me Info Via</p>
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<div class="add-input">
											<!-- <label class="checkbox-2 blue blue-report">
												<input type="checkbox">
												<span class="indicator"></span>
												I accept licence <a href="#" class="color-d"> Terms And Conditions</a>
											</label> -->
											<div class="checkboxes email_checkbox" style="margin-top:1rem;">
												<label class="checkbox">
													<input type="checkbox" name="send_inq_info[]" id="checkbox-0" value="E-Mail">
													<span class="indicator"></span>
													Email
												</label>
											</div>
										</div>
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<div class="add-input">
											<!--<label class="checkbox-2 blue blue-report">
												<input type="checkbox">
												<span class="indicator"></span>
												I accept licence <a href="#" class="color-d"> Terms And Conditions</a>
											</label>-->
											<div class="checkboxes email_checkbox lk_222 ff_21" style="margin-top:1rem;">
												<label class="checkbox">
													<input type="checkbox" name="send_inq_info[]" id="checkbox-1" value="Need Call back">
													<span class="indicator"></span>
													Need Call Back
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="row add-b-cstm mt-5">
									<div class="col-md-3 col-sm-3 col-xs-12">
									</div>
									<div class="col-md-4 col-sm-3 col-xs-12">
										<div class="add-ad-btn">
											<div class="" >
												<!-- <a href="#" class="Poppins-Medium color-f f-18">Book My Venue Now</a> -->
												<button type="submit" class="add-w-btn Poppins-Medium color-f f-18" style="width:100%;"> Book My Venue Now</button>
											</div>
										</div>
									</div>
									<!--<div class="col-md-4 col-sm-4 col-xs-12 padding-0 padding-lr cstm-ptn">
										<div class="add-w-btn2">
										<a href="#" class="Poppins-Medium color-f f-18">Reset</a>
										</div>
									</div>-->
								</div>
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
							</form>
							</div>
						</div>
					</div>
					
				</div>
				<div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
					<div class="mega-box-new prld-zero hidden-sm hidden-xs">
						<p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center ab-t1 mt-1"><?php echo $this->common_model->display_data_na($wedding_planner_item['category_name']);?>  
						</p>
						<hr class="search-hr" style="margin-top:-8px;"/>
						<p class="blossom-p location"><strong>Location :</strong> <?php echo $this->common_model->display_data_na($wedding_planner_item['address']);?></p>
						<p class="blossom-p users mt-3"><strong>Capacity :</strong> <?php echo $this->common_model->display_data_na($wedding_planner_item['capacity']);?></p>
						<p class="blossom-p  mt-3 avg"><strong>Avg Price :</strong> <?php echo $wedding_planner_item['currency'];?><?php echo $wedding_planner_item['start_rate_range'];?> - <?php echo $wedding_planner_item['currency'];?><?php echo $wedding_planner_item['end_rate_range'];?>
						</p>
						<?php 
						if(isset($wedding_planner_reviews_count) && $wedding_planner_reviews_count > 0){
							$where_arra__count=array('vendor_id'=>$id_details,'is_deleted'=>'No','status'=>'APPROVED');
							$reviews_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra__count,1,'sum(r_star) as reviews_count','id desc','');
							
							$total = $wedding_planner_reviews_count*5;
							$average = $reviews_count['reviews_count']/$total*5; 
						}else{
							$average = 0;
						}
						?>
						<p class="rating blossom-p">
						<?php if($average > 0 && $average <= 1.5){?>
							<i class="fa fa-star"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i> 
						<?php }elseif($average > 1.5 && $average <= 2.5){ ?>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
						<?php }elseif($average > 2.5 && $average <= 3.5){ ?>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
						<?php }elseif($average > 3.5 && $average <= 4.5){ ?>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star star-grey"></i>
						<?php }elseif($average > 4.5 && $average <= 5){ ?>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
							<i class="fa fa-star"></i>
						<?php }else{ ?>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
							<i class="fa fa-star star-grey"></i>
						<?php } ?>
						</p>
						<p class="blossom-p">
							<a href="#venue" class="add-w-btn Poppins-Medium color-f f-18" style="width:100%;">
								Book  Venue
							</a>
						</p>
						
					</div>
					<div class="mega-box-new hidden-sm hidden-xs">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3">
							<?php $images = array('image'=>$wedding_planner_item['image'],
									'image_2'=>$wedding_planner_item['image_2'],
									'image_3'=>$wedding_planner_item['image_3'],
									'image_4'=>$wedding_planner_item['image_4'],
									'image_5'=>$wedding_planner_item['image_5']);			
				  $path_wedding = $this->common_model->path_wedding;
				  $no_img = $this->common_model->no_image_found;
				  $wedding_count=0;
				foreach($images as $image_val) 
				{	
				 	if(isset($image_val) && $image_val !='' && file_exists($path_wedding.$image_val))
					{ ?>
								<img src="<?php echo $base_url.$path_wedding.$image_val;?>" alt="" class="profile-s brd-raduis">
					<?php 
					$wedding_count++;
					break;
					}
				}
				if(isset($wedding_count) && $wedding_count==0)
				{?>
					<img src="<?php echo $base_url.$no_img;?>" alt="" class="profile-s brd-raduis">
			<?php	}
				?>

							</div>
							<div class="col-md-9 col-sm-9 col-xs-9">
								<p class="Poppins-Semi-Bold f-17 mb-0"><?php echo $this->common_model->display_data_na($wedding_planner_item['planner_name']);?></p>
								<hr class="success-hr new-hr-w hr_kd">
								<p class="Poppins-Regular f-15 mb-0 lk_200"><i class="fas fa-envelope lk_201"></i> <?php echo $this->common_model->display_data_na($wedding_planner_item['email']);?></p>
								<p class="Poppins-Regular f-15 mb-0 mt-1 lk_200"><i class="fas fa-phone lk_201"></i> <?php echo $this->common_model->display_data_na($wedding_planner_item['mobile']);?></p>
							</div>
						</div>
					</div>
					<?php echo $this->common_model->display_advertise('Level 2');?>
				</div>
			</div>
		</div>
		<div id="write-review" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog  modal-dialog-vendor">
				<div class="modal-content">
					<div class="modal-header new-header-modal">
						<button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body">
					<div class="alert alert-success" id="review_success_message"  style="display:none"></div>
					<form class="margin-top-20" action="<?php echo $base_url; ?>wedding_vendor/send_review/<?php echo $id_details ;?>" method="post" name="review_form" id="review_form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="">
									<p class="Poppins-Medium f-16 color-31 ad-name">Name</p>
									<input id="r_name" name="r_name" type="text" placeholder="Enter Your Name" class="form-control input-md" required/>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="">
									<p class="Poppins-Medium f-16 color-31 ad-name">Email</p>
									<input type="email" id="r_email" name="r_email" placeholder="Enter Your E-Mail" class="form-control ni-input" required/>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="">
									<p class="Poppins-Medium f-16 color-31 ad-name">Rating</p>
									<p class="rating rating-2">
										<span class="star-cb-group">
											<input type="radio" id="rating-5" name="r_star" value="5" /><label for="rating-5">5</label>
											<input type="radio" id="rating-4" name="r_star" value="4" /><label for="rating-4">4</label>
											<input type="radio" id="rating-3" name="r_star" value="3" /><label for="rating-3">3</label>
											<input type="radio" id="rating-2" name="r_star" value="2" /><label for="rating-2">2</label>
											<input type="radio" id="rating-1" name="r_star" value="1" /><label for="rating-1">1</label>
											<input type="radio" id="rating-0" name="r_star" value="0" class="star-cb-clear" /><label for="rating-0">0</label>
										</span>
									</p>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="">
									<p class="Poppins-Medium f-16 color-31 ad-name">Title Of Review</p>
									<input id="r_title" name="r_title" type="text" placeholder="Give your review a Title" class="form-control ni-input" required/>
								</div>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="">
									<p class="Poppins-Medium f-16 color-31 ad-name">How was your overall experience?</p>
									<textarea class="form-control" name="r_message" id="r_message" rows="8" placeholder="Write your Review" required></textarea>
									
								</div>
							</div>
							
						</div>
						<div class="row mt-3">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="m-captcha-code-2" style="width:100%;">
								<img style="float:left;margin: -10px 10px 0px 10px;" alt="captch-code" src="<?php echo $base_url; ?>captcha.php?captch_code_front=yes&captch_code=<?php echo $this->session->userdata['captcha_vendor']; ?>"/>
								</div>
							</div>
							<div class="col-md-9 col-sm-6 col-xs-12">
								<div class="add-input-mobile">
									
									<input  type="number" name="code_captcha" id="code_captcha" class="font-weight-normal text-grey form-control" placeholder="Enter Captcha Code" value="" required /> 
								</div>
							</div>
						</div>
						<div class="row mt-3">
							<div class="col-md-12 col-sm-3 col-xs-12">
								<div class="">
									
									<button type="submit" class="add-w-btn left-zero Poppins-Medium color-f f-18">Submit Review</button>
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
								</div>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
		
		<?php 
	$this->common_model->js_extra_code_fr.="
	$(document).ready(function() {
				
		// assuming the controls you want to attach the plugin to 
		// have the 'datepicker' class set
		$('#datepicker-example2').Zebra_DatePicker();
		
	});
	jQuery(document).ready(function($) {
		
		$('#myCarousel').carousel({
			autoPlay :false,
			
		});
		
		//Handles the carousel thumbnails
		$('[id^=carousel-selector-]').click(function () {
			var id_selector = $(this).attr('id');
			try {
				var id = /-(\d+)$/.exec(id_selector)[1];
				console.log(id_selector, id);
				jQuery('#myCarousel').carousel(parseInt(id));
				} catch (e) {
				console.log('Regex failed!', e);
			}
		});
		// When the carousel slides, auto update the text
		$('#myCarousel').on('slid.bs.carousel', function (e) {
			var id = $('.item.active').data('slide-number');
			$('#carousel-text').html($('#slide-content-'+id).html());
		});
	});

	if($('#enquiry_form').length > 0)
	{
		$('#enquiry_form').validate({
			rules: {
				name: {
					required: true,
					lettersonly: true
				},
				phone: {
					digits: true,
					required: true,
					minlength: 7,
					maxlength: 13
				}
			},
			submitHandler: function(form)
			{
				submit_vendor_form();
				return false;
			}
		});
	}
	if($('#enquiry_form').length > 0)
	{
		$('#enquiry_form').validate({
			submitHandler: function(form)
			{
				submit_vendor_form();
				return false;
			}
		});
	}
	function submit_vendor_form()
	{
		show_comm_mask();
			
		var form_data = $('#enquiry_form').serialize();
		form_data = form_data+ '&is_post=0';
		var action = $('#enquiry_form').attr('action');
		
		$('#email_success_message').hide();
		$('#email_error_message').hide();
		
		$.ajax({
		   url: action,
		   type:'post',
		   data: form_data,
		   dataType:'json',
		   success:function(data)
		   {
				if(data.status == 'success')
				{
					$('#email_success_message').html(data.errmessage);
					$('#email_success_message').slideDown();
					form_reset('enquiry_form');
					setTimeout(function()
					{
						$('#email_success_message').fadeOut('fast');
					}, 10000);
				}
				else
				{
					$('#email_error_message').html(data.errmessage);
					$('#email_error_message').slideDown();
				}
				scroll_to_div('venue');
				$('#hash_tocken_id').val(data.token);
			   hide_comm_mask();
		   }
		});
		return false;
	}

	/* $('#weddingdate').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true,
		 minDate: 0,
	}); */
	$('#weddingdate').Zebra_DatePicker({
		default_position:'below',
		direction: 1
	});
	

	if($('#review_form').length > 0)
	{
		$('#review_form').validate({
			rules: {
				r_name: {
					lettersonly: true
				},
			},
			submitHandler: function(form)
			{
				submit_review_form();
				return false;
			}
		});
	}
	function submit_review_form()
	{
		var star = '';
		if($('#rating-1').prop('checked') == true){
			var star = $('input[name=r_star]:checked', '#review_form').val();
		}
		if($('#rating-2').prop('checked') == true){
			var star = $('input[name=r_star]:checked', '#review_form').val();
		}
		if($('#rating-3').prop('checked') == true){
			var star = $('input[name=r_star]:checked', '#review_form').val();
		}
		if($('#rating-4').prop('checked') == true){
			var star = $('input[name=r_star]:checked', '#review_form').val();
		}
		if($('#rating-5').prop('checked') == true){
			var star = $('input[name=r_star]:checked', '#review_form').val();
		}
		
		if(star == ''){
			alert('Please select star rating..!!!');
			$('input[name=r_star]').focus();
			return false;
		}
		
		show_comm_mask();
		
		var form_data = $('#review_form').serialize();
		form_data = form_data+ '&is_post=0';
		var url = $('#review_form').attr('action');
		
		$('#review_success_message').hide();
		
		$.ajax({
		   url: url,
		   type:'post',
		   data: form_data,
		   dataType:'json',
		   success:function(data)
		   {
				if(data.status == 'success')
				{
					$('#review_success_message').html(data.errmessage);
					$('#review_success_message').slideDown();
					$('#review_success_message').focus();
					form_reset('review_form');
					setTimeout(function()
					{
						$('#review_success_message').fadeOut('fast');
					}, 10000);
				}
				else
				{
					$('#review_success_message').html(data.errmessage);
					$('#review_success_message').slideDown();
				}
				$('#hash_tocken_id').val(data.token);
				hide_comm_mask();
		   }
		});
		return false;
	}
	";
?>
	