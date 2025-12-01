<style type="text/css">
    h1{
        margin-top: 0px !important;
    }
    h2{
        margin-top: 0px !important;
    }
</style>
</div>
<div class="menu-bg-new">
    <div class="container-fluid new-width">
        <div class="row mt-5">
            <div class="col-md-4 col-sm-12 col-xs-12 hidden-xs hidden-sm">
                <div class="box-main-s">
                    <h2 class="bread-crumb Poppins-Medium"><a href="<?php echo $base_url;?>">Home</a><span class="color-68"> / </span><span class="color-68">VENDOR LIST</span></h2>
                </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12 text-center"> 
                <div class="box-main-s">
                    <h1 class="Poppins-Semi-Bold mega-n3 f-s">Wedding Planner <span class="mega-n4 f-s">Listing</span></h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div id ="main_content_ajax">
    <?php include_once('vendor_list_ajax.php');?>
</div>
<?php
$this->common_model->js_extra_code_fr.="
$(document).ready(function(){
	$(".'"'."[data-toggle='tooltip']".'"'.").tooltip();
});

load_pagination_code_front_end();";
?>