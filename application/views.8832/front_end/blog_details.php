<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><span><a href="<?php echo $base_url; ?>">Home</a></span><span class="color-68"> / </span><span class="color-68">Blog</span></p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container container-fluid new-width">
    <div class="row mt-3">
        <div class="col-md-8 col-xs-12 col-sm-12">
            <div class="mega-box-new">
                <?php
                $blog_img = '<img src="'.$base_url.$this->common_model->no_image_found.'" alt="" class="img-responsive brd-raduis" style="width: 400px;height: 400px;margin-right: auto;margin-left: auto;" />';
                if(isset($blog_data['blog_image']) && $blog_data['blog_image'] !='' && file_exists($this->common_model->path_blog.$blog_data['blog_image']))
                {
                    $blog_img = '<img src="'.$base_url.$this->common_model->path_blog.$blog_data['blog_image'].'" alt="" class="img-responsive brd-raduis" />';
                }
				echo $blog_img;
                ?>
                <p class="Poppins-Semi-Bold f-18 mt-3">
                    <?php if(isset($blog_data['title']) && $blog_data['title'] !=''){
                        echo $blog_data['title'];
                    }?>
                </p>
				<?php
                    if(isset($blog_data['content']) && $blog_data['content'] !=''){
                        $text_new = str_ireplace('<p>','<p class="Poppins-Regular l-height-28 f-14 mt-4 clear-both color-2d">',$blog_data['content']);
                        echo $text_new;
                    }
                ?>
                <span class="float-left-m Poppins-Medium f-14 mt-4">
                    <span class="color-d Poppins-Semi-Bold f-12"><i class="fas fa-calendar-week f-17"></i> &nbsp; <?php echo $this->common_model->displayDate($blog_data['created_on'],'jS F, Y');?></span>
                </span>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs padding-0">
            <?php echo $this->common_model->display_advertise('Level 2');
			$class1 = 'Prf_sidebar-new-mac';
			include_once('featured_rightsidebar.php');?>
        </div>
    </div>
</div>