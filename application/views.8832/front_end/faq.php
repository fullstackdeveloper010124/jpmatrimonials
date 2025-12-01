<?php $faq_arr = $this->common_model->get_count_data_manual('faq_master',array('status'=>'APPROVED'),2,'*','id asc'); ?>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="box-main-s">
                    <p class="bread-crumb Poppins-Medium"><a href="<?php if(isset($base_url) && $base_url !=''){echo $base_url; }?>">Home</a><span class="color-68"> / </span><span class="color-68">Faq</span></p>
                </div>
            </div>
           
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-3">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?php if(isset($faq_arr) && $faq_arr !='' && is_array($faq_arr) && count($faq_arr) > 0){?>
                <div class="mega-box-new new-p-cms">
                    <?php foreach($faq_arr as $faq_arr_val){?>
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 faq-1">
                                <h2 class="mytextwithicon"><?php echo $faq_arr_val['question']; ?></h2>
                                <p class="text-justify">
                                <?php $answer = $faq_arr_val['answer'];
                                    $answer = str_ireplace('<p>','',$answer);
                                    $answer = str_ireplace('</p>','',$answer);
                                    echo $answer;?>
                                </p>
                            </div>
                        </div>
                    <?php }?>
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