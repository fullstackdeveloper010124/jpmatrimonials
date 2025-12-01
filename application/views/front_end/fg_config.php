<?php
require_once __DIR__ . '/Facebook/autoload.php'; // change path as needed
$client_key = "";
$client_secret = "";
if(isset($fb_detail['client_key']) && $fb_detail['client_key']!=''){
	$client_key = $fb_detail['client_key']; 
}
if(isset($fb_detail['client_secret']) && $fb_detail['client_secret']!=''){
	$client_secret = $fb_detail['client_secret'];
}

$fb = new \Facebook\Facebook([
  'app_id' => $client_key,
  'app_secret' => $client_secret,
  'default_graph_version' => 'v2.10',
]);
$helper = $fb->getJavaScriptHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
if (! isset($accessToken)) {
  echo 'No cookie set or no OAuth data could be obtained from cookie.';
  exit;
}
// see if we have a session
if ( isset( $accessToken ) ) {
	$response = $fb->get('/me?fields=id,email,first_name,last_name,gender,birthday', $accessToken);
	$user = $response->getGraphUser();

	$fbid = $user['id'];
	$first_name = $user['first_name'];
	$last_name = $user['last_name'];
	$femail = $user['email'];
	$gender = $user['gender'];
	$fb_birthday = $user['birthday'];
	$bio =  '';
	$month='';
	$day='';
	$year='';
	if($fb_birthday!=''){
		$org=explode('/',$fb_birthday);
		if(isset($org[0])){
			$month = $org[0];
		}
		if(isset($org[1])){
			$day = $org[1];
		}
		if(isset($org[2])){
			$year = $org[2];
		}
	}
	$where = "(fb_id='".$fbid."' or email='".$femail."' ) AND is_deleted!='Yes'";
	$this->db->where($where);
	$this->db->limit(1);
	$query = $this->db->get('register');
	if($query->num_rows() > 0){
		if($femail!=''){
			$chkemail=" or email='".$femail."'";
		}
		else{
			$chkemail= "";   
		}
		$where = "(fb_id='".$fbid."' $chkemail) AND is_deleted!='Yes'";
		$this->db->where($where);
		$this->db->select('id, matri_id, status, email, username, firstname, lastname, photo1, plan_name, plan_status, gender,  password, mobile, mobile_verify_status');
		$query = $this->db->get('register');
		$reg_data = $query->row_array();
		if($query->num_rows() > 0 && count($reg_data) > 0){
			if($reg_data['status']!='UNAPPROVED'){
				$row_data = $reg_data;
				$this->db->set('last_login', $login_dt);
				$where_arra = array(
					'id'=>$row_data['id']
				);
				$this->table_name = 'register';
				$data_array = array('last_login'=>$login_dt);
				$row_data1 = $this->common_model->update_insert_data_common($this->table_name, $data_array, $where_arra);
				
				$ip_address = $_SERVER['REMOTE_ADDR'];
				$data_array123 = array(
					'matri_id'=>$row_data['matri_id'],
					'email'=>$row_data['email'],
					'login_at'=>$login_dt,
					'ip_address'=>$ip_address
				);
				$response1 = $this->common_front_model->save_update_data('user_login_history',$data_array123);
				$where_online_users = array('index_id'=>$row_data['id']);
				$row_data_online_users = $this->common_model->get_count_data_manual('online_users',$where_online_users,0,'','','','',0);
				if($row_data_online_users == 0 && $row_data_online_users == ''){
					$ip = $_SERVER['REMOTE_ADDR'];
					$dt = $this->common_model->getCurrentDate();
					$data_array1 = array('ip'=>$ip,'username'=>$row_data['username'],'gender'=>$row_data['gender'],'index_id'=>$row_data['id'],'dt'=>$dt);
					$row_data1 = $this->common_model->update_insert_data_common('online_users', $data_array1, '',0);
				}
				if(isset($row_data['photo1']) && $row_data['photo1'] !='' && file_exists($this->common_model->path_photos.$row_data['photo1'])){
					$row_data['photo1'] = base_url().$this->common_model->path_photos.$row_data['photo1'];
				}
				else{
					if(isset($row_data['gender']) && $row_data['gender'] =='Male'){
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-male.gif';
					}
					else{
						$row_data['photo1'] = base_url().'assets/front_end/images/icon/border-female.gif';
					}
				}
				$this->session->set_userdata('mega_user_data', $row_data);
				redirect($this->base_url.'my-profile');
				exit();				
			}
			else{
				$this->session->set_flashdata('user_log_err', "Your account is under review, please contact to admin.");
				redirect($base_url.'login');
			}
		}
	}
	$url = 'http://graph.facebook.com/'.$fbid.'/picture?type=large';
	$data = file_get_contents($url);
	$fileName = time().'.jpg';
	$file = fopen('/home/narjireu/public_html/www.trialme.in/megamatrimony/assets/photos_big/'.$fileName, 'w+');
	$fl=fputs($file, $data);	
	fclose($file);
	
	$file = fopen('/home/narjireu/public_html/www.trialme.in/megamatrimony/assets/photos/'.$fileName, 'w+');
	$fl=fputs($file, $data);	
	fclose($file);
	
	$user_fb_array = array(
		'FBID'	=> $fbid,
		'fb_first_name'	=> $first_name,
		'fb_last_name'	=>$last_name,
		'fb_email'	=> $femail,
		'fb_gender'	=> $gender,
		'fb_image_name'	=> $fileName,
		'fb_image'	=> $url,
		'month' =>  $month,
		'day' => $day,
		'year' => $year
	);
	$this->session->set_userdata('member_fb_data', $user_fb_array);
	if($this->session->userdata('member_gplus_data')){
		$this->session->unset_userdata('member_gplus_data');
	}
	redirect($base_url.'register');
} 
else{
	$loginUrl = $helper->getLoginUrl(array('scope' => 'email'));
	header("Location: ".$loginUrl);
}
?>