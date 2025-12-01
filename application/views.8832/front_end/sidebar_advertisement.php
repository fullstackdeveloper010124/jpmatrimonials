<?php $where_arra=array('is_deleted'=>'No','status'=>'APPROVED');
	$advertisement_data = $this->common_model->get_count_data_manual('advertisement_master',$where_arra,1,'*','rand()');
	if(isset($advertisement_data) && $advertisement_data !='' && is_array($advertisement_data) && count($advertisement_data) > 0 )
	{
		//print_r($advertisement_data);
?>
	<div class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero-999" style="box-shadow: none;">
        <div class="row" style="padding:0px;">
        	<?php
				if(isset($advertisement_data['type']) && $advertisement_data['type'] =='Image' && isset($advertisement_data['link']) && $advertisement_data['link'] !='' && isset($advertisement_data['image']) && $advertisement_data['image'] !='')
				{
			?>
            <a href="<?php echo $advertisement_data['link']; ?>" target="_blank">
                <img data-src="<?php echo $base_url.$this->common_model->path_advertise.$advertisement_data['image']; ?>" class="text-center img-responsive lazyload" src="<?php echo $base_url.$this->common_model->path_advertise.$advertisement_data['image']; ?>" alt="<?php echo $advertisement_data['link']; ?>"/>
            </a>
            <?php
				}
				else
				{
					if(isset($advertisement_data['google_adsense']) && $advertisement_data['google_adsense'] !='')
					{
						echo $advertisement_data['google_adsense'];
					}
				}
			?>
        </div>
    </div>
<?php
	}
?>