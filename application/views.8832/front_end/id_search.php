<div class="col-md-8 col-sm-12 col-xs-12">
    <div class="mega-box-new">
        <div class="m-add-box">
            <p class="text-center">Find profiles faster with id search. e.g : <?php $config_arra = $this->common_model->get_site_config();echo $config_arra['matri_prefix'].'10';?>
            </p>
            <hr class="search-hr">
           <h1> <p class="calibri-Bold-font f-22 color-31 t-transform-ue text-center">Id 
            <span class="color-d">SEARCH</span></p></h1>
            <div class="add-box-2">
            <form action="<?php echo $base_url; ?>search/search_now" id="id_search_form" method="post">
                <div class="row add-b-cstm">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                       <h2>  <p class="Poppins-Medium f-16 color-31 ad-name">Id Search <span class="color-d f-16 select2-lbl-span">*</span> :</p> </h2>
                    </div>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                        <div class="add-input">
                        <input type="text" class="form-control ni-input" required name="txt_id_search" placeholder="Enter Matri Id">
                        <input type="hidden" name="search_page_nm" value="ID Search" />
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <div class="row add-b-cstm mt-5">
                    <div class="col-md-3 col-sm-3 col-xs-12">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="add-ad-btn">
                            <button type="submit" class="add-w-btn Poppins-Medium color-f f-18"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <?php if(isset($current_login_user) && $current_login_user!='' && $current_login_user > 0){?>
                            <a data-toggle="modal" data-target="#myModal_id" class="add-w-btn save-search-btn Poppins-Medium color-f f-18" type="submit" ><i class="fas fa-save"></i> Save and Search
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
                 <input type="hidden" name="save_search" id="id_save_search" value="" >
            </form>
            </div>
        </div>
    </div>
</div>

<div id="myModal_id" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModal_id" aria-hidden="true">
    <div class="modal-dialog modal-dialog-vendor">
        <div class="modal-content">
            <div class="modal-header new-header-modal" style="border-bottom: 1px solid #e5e5e5;">
                <p class="Poppins-Bold mega-n3 new-event text-center">Save <span class="mega-n4 f-s">Search</span></p>
                <button type="button" class="close close-vendor" data-dismiss="modal" aria-hidden="true" style="margin-top: -37px !important;">×</button>
            </div> 
            <form action="<?php echo $base_url; ?>search/search_now" name="id_search_form" id="id_search_form" method="post">
                <div class="modal-body">
                    <input type="text" name="search_name" id="id_search_name" required placeholder="Enter Save Search Name" class="form-control input-border-modal" style="padding:5px"/>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-3 col-xs-12">
                            <span class="pull-right float-none">
                                <button onClick="return save_search('id_search_form');" class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18">Save and Search</button>
                                <button class="add-w-btn new-msg-btn left-zero-msg Poppins-Medium color-f f-18" data-dismiss="modal">Cancel</button>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" id="hash_tocken_id" />
	            </div>
            </form>
        </div>
    </div>
</div>