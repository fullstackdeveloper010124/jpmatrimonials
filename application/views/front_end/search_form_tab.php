<div class="container-fluid new-width">
    <div class="row">
        <div class="tab contact-tab-m quick-search-tab hidden-sm hidden-xs" role="tabpanel">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs contact-tab-nav2" role="tablist">
                <li role="presentation" class="<?php if($this->uri->segment(2)=='quick-search'){echo ' active';}?> f-17">
                    <a href="<?php echo $base_url;?>search/quick-search">
                        <i class="fas fa-search"></i>
                        Quick Search
                    </a>
                </li>
                <li role="presentation" class="<?php if($this->uri->segment(2)=='advance-search'){echo ' active';}?> f-17">
                    <a href="<?php echo $base_url;?>search/advance-search"><i class="fas fa-search-plus"></i> Advance Search</a>
                </li>
                <?php if($is_login){?>
                    <li role="presentation" class="<?php if($this->uri->segment(2)=='saved'){echo ' active';}?> f-17">
                        <a href="<?php echo $base_url;?>search/saved"><i class="fas fa-list"></i> Saved Search</a>
                    </li>
                <?php }?>
            </ul>
            <!-- Tab panes -->
        </div>
    </div>
</div>
<hr class="search-hr">