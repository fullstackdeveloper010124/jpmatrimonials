<?php
if(isset($cms_pages['page_title']) && $cms_pages['page_title'] !=''){
	$start = strrpos ( $cms_pages['page_title'] , " ") + 1;
	$end = strlen($cms_pages['page_title']) - 1;
	$first_word = substr($cms_pages['page_title'], 0, $start);
	$last_word = substr($cms_pages['page_title'], $start, $end);
}
?><div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php if(isset($base_url) && $base_url !=''){echo $base_url;}?>">Home</a><span class="color-68"> / </span><span class="color-68"><?php if(isset($cms_pages['page_title']) && $cms_pages['page_title'] !=''){ echo $cms_pages['page_title'];}?></span></p>
                </div>
            </div>
           
        </div>
    </div>
</div>

<div class="container">
	<div class="row mt-3">
    	<div class="col-md-12 col-sm-12 col-xs-12">
			<?php if(isset($cms_pages['page_content']) && $cms_pages['page_content']!=''){?>
                <div class="mega-box-new">
                    <?php $text = str_ireplace('<p>','<p class=" Poppins-Regular f-15 color-2d l-height-28 mega-t1">',$cms_pages['page_content']);
					echo $text;?>
                </div>
			<?php }else{?>
                <div class="no-data-f">
	                <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
    	            <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                </div>
			<?php }?>
		</div>
    </div>
</div>