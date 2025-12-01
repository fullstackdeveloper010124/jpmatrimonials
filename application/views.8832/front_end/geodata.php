<?php 

	function get_tag($tag,$xml)
	{
		preg_match_all('/<'.$tag.'>(.*)<\/'.$tag.'>$/imU',$xml,$match);
		return $match[1];
	}

	function is_bot()
	{
		/* This function will check whether the visitor is a search engine robot */
		
		$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
		"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
		"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
		"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
		"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
		"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
		"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
		"Butterfly","Twitturls","Me.dium","Twiceler");

		foreach($botlist as $bot)
		{
			if(strpos($_SERVER['HTTP_USER_AGENT'],$bot)!==false)
			return true;	// Is a bot
		}

		return false;	// Not a bot
	}

	// We don't want web bots accessing this page:
	if(is_bot()) die();
	$result_list='';
	
	$current_login_user = $this->common_front_model->get_session_data();
	$cure_date = $this->common_model->getCurrentDate('Y-m-d');

	if(isset($result_count) && $result_count > 0){
		$result_list = array();
		
		foreach($result as $status){
			$result_list[] = $status;
		}
		
		foreach ($result_list as $sts)
		{
			if($sts['status'] == 'APPROVED' && isset($sts['plan_status']) && ($sts['plan_status'] == 'Not Paid' || $sts['plan_status'] == 'Expired'))
			{
				$where_arra=array('register.status'=>'APPROVED');
				$this->db->join('register',' register.id = online_users.index_id ','left');
				$where_arra[]= " online_users.gender != '".$current_login_user['gender']."'";
				$online_users_data = $this->common_model->get_count_data_manual('online_users',$where_arra,2,'register.photo1,register.status,register.fstatus,register.gender,register.matri_id,online_users.username,online_users.index_id','online_users.id asc','','','','','','');
				
				$online_users_data_count='';
				$online_users_data_count=count($online_users_data);
				if($online_users_data_count > 0)
				{
			?>
					<span style="text-decoration:underline;color:#F4F4F4;"> <?php echo  $sts['status']  .  "  Member(s)  ";?></span>
			<?php }
				foreach($online_users_data as $row)
				{	
			?>
					<div class="geoRow" >
						<a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $row['index_id'];?>')" style="color:black; text-decoration:none;">
							<div>
								<?php 
									$path_photos = $this->common_model->path_photos;
									if(isset($current_login_user['gender']) && $current_login_user['gender'] == 'Male'){
										$defult_photo = $base_url.'assets/front_end/img/default-photo/female.png';
									}else{
										$defult_photo = $base_url.'assets/front_end/img/default-photo/male.png';
									}
										
									if(isset($row['photo1']) && $row['photo1'] !='' && file_exists($path_photos.$row['photo1']))
									{
								?>
									<img src="<?php echo $base_url.$path_photos.$row['photo1'];?>" width="20" height="20"> <?php echo $row['matri_id'];?>
								<?php }else{ ?>
									<img src="<?php echo $defult_photo;?>" width="20" height="20"> <?php echo $row['matri_id'];?>
								<?php } ?>
							</div>
						</a>
					</div>
			<?php 
				}
			}
		}
	}
	?>


	<?php 
	/*	
	elseif(($sts['status'] == 'APPROVED' || $sts['fstatus']=='Featured') && (isset($sts['plan_status']) && $sts['plan_status'] == 'Paid' && isset($sts['plan_expired_on']) && $sts['plan_expired_on'] < $cure_date) )
			{
				$where_arra=array('online_users.gender'=>$current_login_user['gender'],'register.status'=>'APPROVED','register.plan_status'=>'Paid');
				$this->db->join('register'," register.id = online_users.index_id and register.plan_expired_on < '$cure_date'",'left');
		
				$online_users_data = $this->common_model->get_count_data_manual('online_users',$where_arra,2,'register.photo1,register.status,register.fstatus,register.gender,register.matri_id,online_users.username,online_users.index_id','online_users.id asc','','','','','','');
				
				$online_users_data_count='';
				$online_users_data_count=count($online_users_data);
				
				if($online_users_data_count > 0)
				{
			?>
					<span style="text-decoration:underline;color:#F4F4F4;"> <?php echo  $sts['status']  .  "  Member(s)  ";?></span>
			<?php }
				foreach($online_users_data as $row)
				{	
			?>
					<div class="geoRow" >
						<a href="javascript:void(0)" onclick="javascript:chatWith('<?php echo $row['index_id'];?>')" style="color:black; text-decoration:none;">
							<div>
								<?php 
									$path_photos = $this->common_model->path_photos;
									if(isset($current_login_user['gender']) && $current_login_user['gender'] == 'Male'){
										$defult_photo = $base_url.'assets/front_end/img/default-photo/female.gif';
									}else{
										$defult_photo = $base_url.'assets/front_end/img/default-photo/male.gif';
									}
										
									if(isset($row['photo1']) && $row['photo1'] !='' && file_exists($path_photos.$row['photo1']))
									{
								?>
									<img src="<?php echo $base_url.$path_photos.$row['photo1'];?>" width="20" height="20"> <?php echo $row['matri_id'];?>
								<?php }else{ ?>
									<img src="<?php echo $defult_photo;?>" width="20" height="20"> <?php echo $row['matri_id'];if($row['fstatus']=='Featured'){echo "(".$row['fstatus'].")";}else{;}?>
								<?php } ?>
							</div>
						</a>
					</div>
			<?php 
				}
			}*/	
	?>

