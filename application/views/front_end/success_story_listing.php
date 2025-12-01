<style type="text/css">
    h1{
        margin-top: 0px !important;
    }
    h2{
        margin-top: 0px !important;
    }
</style>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-4">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <h2 class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">Success Stories</span></h2>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 text-center">
                    <div class="box-main-s">
                        <!-- <h1 class="Poppins-Semi-Bold mega-n3 f-s">Featured Success <span class="mega-n4 f-s">Stories</span></h1> -->
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 ">
                    <div class="box-main-s">
                        <div class="mega-n-btn1 post-s pull-right">
                            <a href="<?php echo $base_url; ?>success-story/add-story" class="Poppins-Medium color-f f-16 ">Post Success Story</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12 col-xs-12 col-sm-12">
            <?php if(isset($config_data['success_story_text']) && $config_data['success_story_text']!='') {?>
                <div class="mega-box-new">
                    <p class="sucees-p"><?php echo $config_data['success_story_text'];?></p>
                </div>
            <?php }?>    
            </div>
        </div>
		<?php
		if(isset($success_story) && $success_story !='' && is_array($success_story) && count($success_story) > 0){
            $i = 0;
            foreach($success_story as $success_story_value){
                $path_wedding = $this->common_model->path_success;
                if(isset($success_story_value['weddingphoto']) && $success_story_value['weddingphoto'] !='' && file_exists($path_wedding.$success_story_value['weddingphoto'])){
                    $weddingphoto = $base_url.$path_wedding.$success_story_value['weddingphoto'];
                }
                else{
                    $weddingphoto = $base_url.$this->common_model->no_image_found;
                }
                if($i>=0 && $i<=1){$mt = '';}else{$mt = 'mt-3';}
                
                if($i == count($success_story)-2 || $i == count($success_story)-1){$border = '';}else{$border = 'pb-5';}
                if($i==0){
                    echo '<div class="row '.$mt.' '.$border.' ">';
                }
                else if($i%3==0){
                    echo '</div><div class="row '.$mt.' '.$border.' ">';
                }
                ?>
               <!--   Dynamic url changes for shakil 18-12-2020 -->
                <div class="col-md-4">
                    <div class="vendor-main">
                        <div class="vendor">
                            <?php $groomname = $success_story_value['groomname'];
                                    $bridename = $success_story_value['bridename'];
                                    $mid = $this->common_model->encrypt_id($success_story_value['id']);
                            $groomname = str_replace(' ','-',$groomname); 
                             $bridename = str_replace(' ','-',$bridename); 
                             $url = 'success-story'.'/'.$mid.'/'.$groomname.'-'.$bridename;
                             ?>
                            <a href="<?php echo $base_url.$url; ?>"><img src="<?php echo $weddingphoto;?>" alt="" class="img-responsive mega-c1"></a>
                            <div class="c1-name">
                                <p class="Poppins-Semi-Bold f-18 c1-n1"><?php echo $success_story_value['groomname'];?> &amp; <?php echo $success_story_value['bridename'];?></p>
                            </div>
                        </div>
                        <div class="c1-t1">
                            <p class="Poppins-Regular f-15 c1-t2">
                            <?php   
                                $descri = $success_story_value['successmessage'];
                                $description = substr(strip_tags($descri),0,270);
                                echo $description;if(strlen($descri)>270){echo '...<a href=" '.$base_url.$url.'" class="mega-rm Poppins-Medium">Read More</a>';}
                            ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php if($i == count($success_story)-1){
					echo '</div>';
				}
				$i++;
			}
        }else{?>
            <div class="row mt-3">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="no-data-f">
                        <img src="<?php echo $base_url;?>assets/front_end_new/images/no-data.png" class="img-responsive no-data" />
                        <h1 class="color-no"><span class="Poppins-Bold color-no">NO</span> DATA <span class="Poppins-Bold color-no"> FOUND </span></h1>
                    </div>
                </div>
            </div>
        <?php }?>
       
        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="pagination-wrap mt-0">
                <?php if(isset($success_story_data_count) && $success_story_data_count !='' && $success_story_data_count > 0){
                    echo $this->common_model->rander_pagination_front('success_story/index',$success_story_data_count,$this->common_model->limit_per_page);
                }?>
                </div>
            </div>
        </div>
    </div>