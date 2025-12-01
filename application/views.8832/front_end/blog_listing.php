<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><span><a href="<?php if(isset($base_url) && $base_url !=''){echo $base_url;}?>">Home</a></span><span class="color-68"> / </span><span class="color-68">Blog</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container container-fluid new-width">
    <div class="row mt-3">
        <div class="col-md-8 col-xs-12 col-sm-12">
			<?php if(isset($blog_data) && $blog_data !='' && is_array($blog_data) && count($blog_data) > 0){?>
            <div class="mega-box-new br_left_w">
				<?php
                $i = 0;
                foreach($blog_data as $blog_data_val)
                {
                    $blog_img = $this->common_model->no_image_found;
                    if(isset($blog_data_val['blog_image']) && $blog_data_val['blog_image'] !='' && file_exists($this->common_model->path_blog.$blog_data_val['blog_image'])){
                        $blog_img = $this->common_model->path_blog.$blog_data_val['blog_image'];
                    }
                    $content = strip_tags($blog_data_val['content']);
                    $content_new = substr($content,0,120);
					if($i>=0 && $i<=1){$mt = '';}else{$mt = 'mt-5';}
					
					if($i == count($blog_data)-2 || $i == count($blog_data)-1){$border = '';}else{$border = 'mega-border1';}
                    if($i==0){
                        echo '<div class="row '.$mt.' '.$border.' ">';
                    }
					else if($i%2==0){
                        echo '</div><div class="row '.$mt.' '.$border.' ">';
                    }?>
                    <div class="col-md-6 col-sm-6 col-xs-12 col-left-border">
                        <a href="<?php echo $base_url;?>blog/<?php echo $blog_data_val['alias'];?>"><img src="<?php echo $base_url.$blog_img; ?>" alt="" class="img-responsive blog-list-img1" /></a><h2>
                        <p class="Poppins-Semi-Bold f-18 mt-4"><?php echo $blog_data_val['title']; ?></p></h2>
                        <p class="Poppins-Regular l-height-24 f-14 mt-4 clear-both color-2d" style="min-height: 72px; word-break: break-all;">
                            <?php echo $content_new;if(strlen($content)>120){echo '...<a href="'.$base_url.'blog/'.$blog_data_val['alias'].'">Read More</a>';}?>
                        </p>
                        <div class="float-left-m Poppins-Medium f-14 mt-5">
                            <span class="color-d Poppins-Semi-Bold f-12"><i class="fas fa-calendar-week f-17"></i> &nbsp; <?php echo $this->common_model->displayDate($blog_data_val['created_on'],'jS F, Y');?></span>
                        </div>
                    </div>
                	<?php if($i == count($blog_data)-1){
							echo '</div>';
						}
						$i++;
					}
					?></div><?php
                }
                else{?>
					<div class="no-data-f">
                        <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                        <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                    </div>
				<?php }?>
            <div class="row">
				<div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="pagination-wrap mt-0">
					<?php 
					if(isset($blog_data_count) && $blog_data_count !='' && $blog_data_count > 0){
						echo $this->common_model->rander_pagination_front('blog/index',$blog_data_count,$this->common_model->limit_per_page);
					}
					?>
                    </div>
            	</div>
            </div>
        </div>
        <div class="m-vertical-border hidden-sm hidden-xs"></div>
        <div class="col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs padding-0">
            <?php echo $this->common_model->display_advertise('Level 2');
			$class1 = 'Prf_sidebar-new-mac';
			include_once('featured_rightsidebar.php');?>
        </div>
    </div>
</div>