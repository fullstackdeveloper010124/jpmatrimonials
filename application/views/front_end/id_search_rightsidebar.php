<?php if($this->common_model->method_name != 'id_search'){?>
<div class="mega-box-new">
    <p class="Poppins-Semi-Bold f-20 color-31 ab-t1">Profile Id  
    <span class="color-d">Search</span></p>
    <hr class="search-hr">
    <div class="row">
        <form action="<?php echo $base_url; ?>search/search_now" method="post">
            <div class="col-md-9 col-xs-12 col-sm-5 pr-0">
                <input type="text" class="form-control ni-input" name="txt_id_search" required placeholder="Enter Profile ID">
            </div>
            <div class="col-md-2 col-xs-12 col-sm-5 gen-m-top pr-0">
                <div class="add-ad-btn">
                    <button type="submit" class="add-w-btn new-id-s Poppins-Medium color-f f-18"><i class="fas fa-search"></i></button>
                </div>
                
            </div>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
        </form>
    </div>
</div>
<?php } if($this->common_model->method_name != 'keyword_search'){?>
<div class="mega-box-new">
    <p class="Poppins-Semi-Bold f-20 color-31 ab-t1">Keyword  
    <span class="color-d">Search</span></p>
    <hr class="search-hr">
    <div class="row">
        <form action="<?php echo $base_url; ?>search/search_now" method="post">
            <div class="col-md-9 col-xs-12 col-sm-5 pr-0">
                <input type="text" class="form-control ni-input" name="keyword" required placeholder="Hindu, Muslim, Rajput, Ahmedabad, India, Software Eng, etc...">
            </div>
            <div class="col-md-2 col-xs-12 col-sm-5 gen-m-top pr-0">
                <div class="add-ad-btn">
                    <button type="submit" class="add-w-btn new-id-s Poppins-Medium color-f f-18"><i class="fas fa-search"></i></button>
                </div>
                
            </div>
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" class="hash_tocken_id" />
        </form>
    </div>
</div>
<?php }?>