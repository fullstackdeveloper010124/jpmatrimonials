<div class="container">
	<div class="row">
     <?php	
		if($this->session->flashdata('email_success_message')){?>
		<div class="alert alert-success"><?php
			echo $this->session->flashdata('email_success_message'); ?>
		</div>
		<?php }
		
		if($this->session->flashdata('email_error_message')){?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('email_error_message'); ?>
            </div>
		<?php }
		if(isset($wedding_planner) && $wedding_planner !='' && is_array($wedding_planner) && $wedding_planner_data_count > 0){
			foreach($wedding_planner as $wedding_planner_value){	?>
                <div class="col-md-4 col-xs-12 col-sm-6">
                    <div class="wedding-vendor">
						<div class="rating-wedding-2">
                            <span class="wedding-map poppins-medium"><?php echo substr_replace($wedding_planner_value['planner_name'],'...', 20);?></span>
                            <span class="dash-mega poppins-medium">|&nbsp;&nbsp;</span>
                            <span class="pull-right poppins-medium rupess-mega"><?php echo $wedding_planner_value['category_name'];?></span>
                            <br>

							<span class="wedding-map poppins-medium"> <i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp; <?php echo $wedding_planner_value['city_name'];?> </span> <span class="dash-mega poppins-medium">|</span> <span class="pull-right poppins-medium rupess-mega"><span class="color-rupess poppins-medium"><?php echo $wedding_planner_value['currency'];?> </span> <?php echo $wedding_planner_value['start_rate_range'];?> - <?php echo $wedding_planner_value['end_rate_range'];?></span>
							</div>
                            <?php
                            $wedding_vendor_image_url = $this->common_model->path_wedding.$wedding_planner_value['image'];
                            $no_image = $base_url.$this->common_model->no_image_found;
						?>
                        <a href="<?php echo $base_url; ?>wedding-vendor/details/<?php echo $wedding_planner_value['id'];?>">
							<?php if(file_exists(FCPATH."$wedding_vendor_image_url")){?>
                                <img src="<?php echo $base_url.$wedding_vendor_image_url;?>" class="wedding-img img-responsive" alt=""/>
                            <?php }else{ ?>
                                <img src="<?php echo $no_image;?>" class="wedding-img img-responsive" alt=""/>
                            <?php } ?>
                        </a>
                        <div class="rating-wedding">
                        <?php 
							$vendor_id = $wedding_planner_value['id'];
							$where_arra_reviews=array('vendor_id'=>$vendor_id,'is_deleted'=>'No','status'=>'APPROVED');
							$vendor_review_count = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,0,'*','id desc','');
							if($vendor_review_count > 0)
							{
								$vendor_review_data = $this->common_model->get_count_data_manual('vendor_reviews',$where_arra_reviews,1,'sum(r_star) as total_reviews_count','id desc','');
								$total = $vendor_review_count*5;
								$average = $vendor_review_data['total_reviews_count']/$total*5; 
							}else{
								$average = 0;
							}
							if(isset($vendor_review_count) && $vendor_review_count>0){?>
								<span> 
                                <?php if($average > 0 && $average <= 1.5){?>
                                    <i class="fa fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i> 
                                <?php }elseif($average > 1.5 && $average <= 2.5){ ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                <?php }elseif($average > 2.5 && $average <= 3.5){ ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                <?php }elseif($average > 3.5 && $average <= 4.5){ ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="far fa-star"></i>
                                <?php }elseif($average > 4.5 && $average <= 5){ ?>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                <?php }else{ ?>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                <?php } ?>
                                <span class="rating-count">
                                (<?php echo $vendor_review_count ;?>)
                                </span>
                                </span>
                                <?php } else{?>
                                <span>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </span> 
                                <?php } ?>
								<span class="pull-right span-country poppins-medium"><i class="fas fa-globe"></i> <?php echo $wedding_planner_value['country_name'];?></span>
							</div>
						</div>
					</div>
                    <?php 	}	?>
						<!-- for pagination-->
						<?php
                           if(isset($wedding_planner_data_count) && $wedding_planner_data_count !='' && $wedding_planner_data_count > 0){	
                                echo $this->common_model->rander_pagination_front('wedding-vendor/index',$wedding_planner_data_count);
                        }?>
				<!-- for pagination-->
				<?php } else { ?>	
					<div class="col-md-12 col-sm-12 col-xs-12">
                    	<div class="no-data-f">
                            <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                            <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                        </div>
                    </div>
				<?php
				}?>
                </div>
			</div>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id_temp" class="hash_tocken_id" />
            