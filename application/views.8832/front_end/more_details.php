<?php
	$matrimony=explode("-matrimony",$this->uri->segment(2));
	$matrimony_name=$matrimony[0];
	$comm_model = $this->common_model;
	$is_login = $this->common_front_model->checkLogin("return");
	$matri_id = $this->common_model->get_user_id("matri_id");
	$email_id = $this->common_model->get_user_id("email");
	$user_id = $this->common_model->get_user_id("id");
	$get_user_data = $this->common_model->get_count_data_manual("register_view",array("id"=>$user_id),1);
?>
<div class="container-fluid new-width width-95">
	<?php include('register_search_sidebar.php');?>
	<!-- ===================== Desk top View End ======================== -->
	<!-- ===================== Desk top View Start ======================== -->
		
		<div class="col-md-9 col-sm-9 col-xs-12 padding-zero">
			<div class="dshbrd_overlay mt-2 imp-matri">
                <div class="dshbrd_color_overlay new-saved-search">
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <span class="saved-search-i Poppins-Medium"> <a href="<?php echo base_url();?>" class="saved-search-i"> <i class="fas fa-home text-white"></i></a>  
                                <span><a href="<?php echo base_url();?>more-details/<?php echo $page_name;?>" class="saved-search-i Poppins-Medium"> <?php $page_name1 = str_replace('-',' ',$page_name);echo ucfirst($page_name1).' Matrimonials';?></a></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
            	<?php
				if(isset($page_list_community) && is_array($page_list_community) && count($page_list_community) > 0){
					$i=1;
					foreach($page_list_community as $matrimony_name_lists){?>
						<div class="col-md-3 col-xs-6 col-sm-3">
                            <a href="<?php echo base_url();?>matrimony/<?php echo str_ireplace(" ","-",$matrimony_name_lists['slug']);?>" class="btn dshbrd_21 Poppins-Medium f-16 color-f w-100" style="padding: 11px 12px;">
                                <?php echo str_replace("-"," ",$matrimony_name_lists['matrimony_name']);?>
                            </a>
						</div>
					<?php 
					$i++;
					}
				}?>
            </div>
            <div class="hidden-lg hidden-md mt-4">
                <?php include('community_sidebar.php');?>
            </div>
    	</div>
    <!-- ===================== Desk top View End ======================== -->
</div>