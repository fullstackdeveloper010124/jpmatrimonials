<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-50">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><span><a href="<?php echo $base_url;?>">Home</a></span><span class="color-68"> / </span><span class="color-68">Success Story Details</span></p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                <div class="box-main-s">
                    
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12 ">
                <div class="box-main-s">
                    <div class="mega-n-btn1 post-s pull-right class-ne">
                        <a href="<?php echo $base_url; ?>success-story/add-story" class="Poppins-Medium color-f f-16 ">Post Success Story</a>
                    </div>
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
				$weddingphoto = '<img src="'.$base_url.$this->common_model->no_image_found.'" alt="" class="img-responsive brd-raduis" style="width: 400px;height: 400px;margin-right: auto;margin-left: auto;" />';
				$path_wedding = $this->common_model->path_success;
				if(isset($success_story_item['weddingphoto']) && $success_story_item['weddingphoto'] !='' && file_exists($path_wedding.$success_story_item['weddingphoto'])){
					$weddingphoto = '<img src="'.$base_url.$path_wedding.$success_story_item['weddingphoto'].'" alt="" class="img-responsive brd-raduis new-blog" />';
				}
				echo $weddingphoto;
				?>
                <p class="Poppins-Semi-Bold f-18 mt-3"><span><?php if(isset($success_story_item['groomname'])) {echo $success_story_item['groomname'];}?> &amp; <?php if(isset($success_story_item['bridename'])) {echo $success_story_item['bridename'];}?></span> <span class="pull-right float-left-m Poppins-Medium f-14"><span class="color-d">Wedding Date:</span> <?php if(isset($success_story_item['marriagedate'])) {echo $this->common_model->displayDate($success_story_item['marriagedate'],' jS F, Y');}?></span></p>
                
				<?php if(isset($success_story_item['successmessage'])){ 
                        $text_new = str_ireplace('<p>','<p class="Poppins-Regular l-height-28 f-15 mt-3 clear-both">',$success_story_item['successmessage']);
                        echo $text_new;
                }?>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 col-sm-12 hidden-sm hidden-xs">
            <?php echo $this->common_model->display_advertise('Level 2');
			$class1 = 'Prf_sidebar-new-mac';
			include_once('featured_rightsidebar.php');?>
        </div>
    </div>
</div>