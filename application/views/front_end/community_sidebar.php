<?php if(isset($matrimony_name_list_religion) && $matrimony_name_list_religion!='' && is_array($matrimony_name_list_religion) && count($matrimony_name_list_religion) > 0){?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            Religion Matrimonials
        </p>
    </a>
    <?php 
    	foreach($matrimony_name_list_religion as $matrimony_name_list_religion_name){?>
            <a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_religion_name['slug']) && $matrimony_name_list_religion_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_religion_name['slug']);}?>">
                <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;" >
                    <?php if(isset($matrimony_name_list_religion_name['matrimony_name']) && $matrimony_name_list_religion_name['matrimony_name']!=''){ echo $matrimony_name_list_religion_name['pagename'];
						/*echo str_replace("-"," ",$matrimony_name_list_religion_name['matrimony_name']);*/
					}?><!--Matrimony-->
                </p>
                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
            </a>
        <?php }?>    
        <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/religion">
            <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
                View More  
            </p>
        </a>
	</div>
<?php }
if(isset($matrimony_name_list_caste) && $matrimony_name_list_caste!='' && is_array($matrimony_name_list_caste) && count($matrimony_name_list_caste) > 0){
	?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            Caste Matrimonials
        </p>
    </a>
    <?php 
		foreach($matrimony_name_list_caste as $matrimony_name_list_caste_name){ 
		?>
        <a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_caste_name['slug']) && $matrimony_name_list_caste_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_caste_name['slug']);}?>">
            <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;">
                <?php if(isset($matrimony_name_list_caste_name['matrimony_name']) && $matrimony_name_list_caste_name['matrimony_name']!=''){ echo $matrimony_name_list_caste_name['pagename'];
						/*echo str_replace("-"," ",$matrimony_name_list_caste_name['matrimony_name']);*/
					}?><!--Matrimony-->
            </p>
            <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
        </a>
    <?php }?> 
    <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/Caste">
        <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
            View More  
        </p>
    </a>
</div>
<?php }?> 
<?php 
	if(isset($matrimony_name_list_country) && $matrimony_name_list_country!='' && is_array($matrimony_name_list_country) && count($matrimony_name_list_country) > 0){?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            Country Matrimonials
        </p>
    </a>
    <?php
		foreach($matrimony_name_list_country as $matrimony_name_list_country_name){ 
		?>
        	<a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_country_name['slug']) && $matrimony_name_list_country_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_country_name['slug']); }?>">
                <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;">
                    <?php if(isset($matrimony_name_list_country_name['matrimony_name']) && $matrimony_name_list_country_name['matrimony_name']!=''){ echo $matrimony_name_list_country_name['pagename'];
						/*echo str_replace("-"," ",$matrimony_name_list_country_name['matrimony_name']);*/
					}?><!--Matrimony-->
                </p>
                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
            </a>
		<?php }?>
        <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/country">
            <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
                View More  
            </p>
        </a>
</div>
<?php }?>
   <!-- Start changes 27-10-2020 shakil --> 
   <?php 
    if(isset($matrimony_name_list_state) && $matrimony_name_list_state!='' && is_array($matrimony_name_list_state) && count($matrimony_name_list_state) > 0){?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            State Matrimonials
        </p>
    </a>
    <?php
        foreach($matrimony_name_list_state as $matrimony_name_list_state_name){ 
        ?>
            <a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_state_name['slug']) && $matrimony_name_list_state_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_state_name['slug']); }?>">
                <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;">
                    <?php if(isset($matrimony_name_list_state_name['matrimony_name']) && $matrimony_name_list_state_name['matrimony_name']!=''){ echo $matrimony_name_list_state_name['pagename'];
                        /*echo str_replace("-"," ",$matrimony_name_list_country_name['matrimony_name']);*/
                    }?><!--Matrimony-->
                </p>
                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
            </a>
        <?php }?>
        <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/state">
            <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
                View More  
            </p>
        </a>
</div>
<?php }?>
   <!-- End  -->
<?php if(isset($matrimony_name_list_city) && $matrimony_name_list_city!='' && is_array($matrimony_name_list_city) && count($matrimony_name_list_city) > 0){?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            City Matrimonials
        </p>
    </a>
    <?php 
		foreach($matrimony_name_list_city as $matrimony_name_list_city_name){ 
		?>
        	<a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_city_name['slug']) && $matrimony_name_list_city_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_city_name['slug']); }?>">
                <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;">
                    <?php if(isset($matrimony_name_list_city_name['matrimony_name']) && $matrimony_name_list_city_name['matrimony_name']!=''){ echo $matrimony_name_list_city_name['pagename'];
						/*echo str_replace("-"," ",$matrimony_name_list_city_name['matrimony_name']);*/
					}?><!--Matrimony-->
                </p>
                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
            </a>
		<?php }?>
        <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/city">
            <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
                View More  
            </p>
        </a>
</div>
<?php }?>
<?php
	if(isset($matrimony_name_list_mtong) && $matrimony_name_list_mtong!='' && is_array($matrimony_name_list_mtong) && count($matrimony_name_list_mtong) > 0){ ?>
<div class="list-group">
    <a class="list-group-item google-plus" href="JavaScript:Void(0);">
        <p class="Poppins-Semi-Bold f-16 color-d dashbrd_1">
            Mother Tongue Matrimonials
        </p>
    </a>
    <?php
		foreach($matrimony_name_list_mtong as $key=>$matrimony_name_list_mtong_name){ 
		?>
            <a class="list-group-item visitor" href="<?php echo base_url();?>matrimony/<?php if(isset($matrimony_name_list_mtong_name['slug']) && $matrimony_name_list_mtong_name['slug']!=''){ echo str_ireplace(" ","-",$matrimony_name_list_mtong_name['slug']);}?>">
                <p class="Poppins-Medium f-16 color-38" style="width: 92%;display: inline-block; margin: 0 0 0px;">
                    <?php if(isset($matrimony_name_list_mtong_name['pagename']) && $matrimony_name_list_mtong_name['pagename']!=''){ echo $matrimony_name_list_mtong_name['pagename'];
						/*echo str_replace("-"," ",$matrimony_name_list_mtong_name['matrimony_name']);*/
					}?><!--Matrimony-->
                </p>
                <span class="Poppins-Semi-Bold f-16 color-38 dashbrd_4 pull-right"><i class="fas fa-caret-right"></i></span>
            </a>
        <?php }?>
        <a class="list-group-item visitor" href="<?php echo base_url();?>more-details/Mother-Tongue">
            <p class="Poppins-Medium f-15 color-d text-right color-38 dashbrd_3 text-right">
                View More  
            </p>
        </a>
</div>
<?php }?>