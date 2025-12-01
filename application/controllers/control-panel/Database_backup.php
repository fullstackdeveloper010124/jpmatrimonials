<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Database_backup extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		
	}
	public function backup()
	{
		$hostname = $this->db->hostname;
		$username = $this->db->username;
		$password = $this->db->password;
		$database = $this->db->database;
		$char_set = $this->db->char_set;
		$dbcollat = $this->db->dbcollat;
		
		$this->db->close();
		
		$config['hostname'] = $hostname;
		$config['username'] = $username;
		$config['password'] = $password;
		$config['database'] = $database;
		$config['dbdriver'] = 'mysqli';
		$config['char_set'] = $char_set;
		$config['dbcollat'] = $dbcollat;
		
		$this->load->database($config);
		// Load the DB utility class
		$this->load->dbutil();
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		// Load the file helper and write the file to your server
	 	$db_name_fil = 'backup-on-'. date("Y-m-d-H-i-s") .'.gz';
		$this->load->helper('file');
		write_file("backup/$db_name_fil", $backup);
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($db_name_fil, $backup);
	}
	function download_csv_bk()
	{
		$this->load->dbutil(); // call db utility library
		$this->load->helper('download'); // call download helper
		$query = $this->db->query("SELECT * FROM register_view where is_deleted ='No' "); // whatever you want to export to CSV, just select in query
		$filename = 'registered_member_data.csv'; // name of csv file to download with data
		force_download($filename, $this->dbutil->csv_from_result($query)); // download file
	}
	function generate_backup() 
	{
		ini_set('max_execution_time', 600);
		ini_set('memory_limit','1024M');
		$source='./';
		$destination= date('ymdhis').'backup.zip';
		if (extension_loaded('zip')) {
			if (file_exists($source)) {
				$zip = new ZipArchive();
				if ($zip->open($destination, ZIPARCHIVE::CREATE)) {
					$source = realpath($source);
					if (is_dir($source)) {
						$iterator = new RecursiveDirectoryIterator($source);
						// skip dot files while iterating 
						$iterator->setFlags(RecursiveDirectoryIterator::SKIP_DOTS);
						$files = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);
						foreach ($files as $file) {
							$file = realpath($file);
							if (is_dir($file)) {
								$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
							} else if (is_file($file)) {
								$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
							}
						}
					} else if (is_file($source)) {
						$zip->addFromString(basename($source), file_get_contents($source));
					}
				}
				$zip->close();
			}
		}
		echo 'Back up created successfully on your root folder,';
		return false;
	}
	
	
	
	function download_csv(){
	    $cols_name = '`id`, `fb_id`, `matri_id`, `prefix`, `title`, `description`, `keyword`, `terms`, `email`, `password`, `cpassword`, `cpass_status`, `marital_status`, `profileby`, `time_to_call`, `reference`, `username`, `firstname`, `lastname`, `gender`, `birthdate`, `birthtime`, `birthplace`, `total_children`, `status_children`, `education_detail`, `income`, `occupation`, `employee_in`, `designation`, `latitude`, `longitude`, `religion`, `caste`, `subcaste`, `gothra`, `star`, `moonsign`, `horoscope`, `manglik`, `mother_tongue`, `height`, `weight`, `blood_group`, `complexion`, `bodytype`, `diet`, `smoke`, `drink`, `languages_known`, `address`, `country_id`, `state_id`, `city`, `phone`, `mobile`, `contact_view_security`, `residence`, `father_name`, `mother_name`, `father_living_status`, `mother_living_status`, `father_occupation`, `mother_occupation`, `profile_text`, `looking_for`, `family_details`, `family_type`, `family_status`, `no_of_brothers`, `no_of_sisters`, `no_of_married_brother`, `no_of_married_sister`, `part_frm_age`, `part_to_age`, `part_bodytype`, `part_diet`, `part_smoke`, `part_drink`, `part_income`, `part_employee_in`, `part_occupation`, `part_designation`, `part_expect`, `part_height`, `part_height_to`, `part_complexion`, `part_mother_tongue`, `android_device_id`, `ios_device_id`, `web_device_id`, `part_religion`, `part_caste`, `part_manglik`, `part_star`, `part_education`, `part_country_living`, `part_state`, `part_city`, `part_resi_status`, `hobby`, `horoscope_photo_approve`, `horoscope_photo`, `photo_protect`, `photo_password`, `video`, `video_approval`, `video_url`, `video_view_status`, `photo_view_status`, `photo1`, `photo1_approve`, `photo2`, `photo2_approve`, `photo3`, `photo3_approve`, `photo4`, `photo4_approve`, `photo5`, `photo5_approve`, `photo6`, `photo6_approve`, `photo7`, `photo7_approve`, `photo8`, `photo8_approve`, `photo1_uploaded_on`, `photo2_uploaded_on`, `photo3_uploaded_on`, `photo4_uploaded_on`, `photo5_uploaded_on`, `photo6_uploaded_on`, `photo7_uploaded_on`, `photo8_uploaded_on`, `registered_on`, `ip`, `agent`, `agent_approve`, `last_login`, `status`, `fstatus`, `logged_in`, `adminrole_id`, `franchised_by`, `staff_assign_id`, `franchise_assign_id`, `staff_assign_date`, `franchise_assign_date`, `commented`, `adminrole_view_status`, `mobile_verify_status`, `plan_id`, `plan_name`, `plan_status`, `plan_expired_on`, `is_deleted`, `id_proof`, `id_proof_approve`, `id_proof_uploaded_on`, `horoscope_photo_uploaded_on`, `registered_from`, `cover_photo`, `cover_photo_approve`, `cover_photo_uploaded_on`, `country_name`, `state_name`, `city_name`, `religion_name`, `caste_name`, `education_name`, `occupation_name`, `mtongue_name`, `designation_name`, `assign_to_staff`, `assign_to_franchise`';
	    $resultListArr =  $this->common_model->get_count_data_manual('register_view','',2,'*','','','');

		if(isset($resultListArr) && $resultListArr!='' && is_array($resultListArr) && count($resultListArr)>0){
		
		foreach ($resultListArr as $key => $value) {
			if(!empty($value['education_detail'])){
				$value['education_detail'] = $this->common_model->valueFromId('education_detail',$value['education_detail'],'education_name');
			}
			if(!empty($value['birthdate'])){
				$value['Age'] = $this->common_model->birthdate_disp($value['birthdate'],0);
			}
			if(!empty($value['height'])){
				$value['height'] = $this->common_model->display_height($value['height']);
			}
			if(!empty($value['weight'])){
				$value['weight'] = $value['weight']." kg";
			}
			if(!empty($value['plan_expired_on'])){
				$value['plan_expired_on'] = $this->common_model->displayDate($value['plan_expired_on']);
			}

			if(!empty($value['part_mother_tongue'])){
				$value['part_mother_tongue'] = $this->common_model->valueFromId('mothertongue',$value['part_mother_tongue'],'mtongue_name');
			}
			
			if(!empty($value['languages_known'])){
				$value['languages_known'] = $this->common_model->valueFromId('mothertongue',$value['languages_known'],'mtongue_name');
			}
			
			if(!empty($value['part_education'])){
				$value['part_education'] = $this->common_model->valueFromId('education_detail',$value['part_education'],'education_name');
			}
			
			if(!empty($value['part_occupation'])){
				$value['part_occupation'] = $this->common_model->valueFromId('occupation',$value['part_occupation'],'occupation_name');	
			}
			
			if(!empty($value['part_designation'])){
				$value['part_designation'] = $this->common_model->valueFromId('designation',$value['part_designation'],'designation_name');	
			}
			
			if(!empty($value['part_religion'])){
				$value['part_religion'] = $this->common_model->valueFromId('religion',$value['part_religion'],'religion_name');
			}
			
			if(!empty($value['part_caste'])){
				$value['part_caste'] = $this->common_model->valueFromId('caste',$value['part_caste'],'caste_name');
			}
			
			if(!empty($value['part_country_living'])){
				$value['part_country_living'] = $this->common_model->valueFromId('country_master',$value['part_country_living'],'country_name');
			}
			
			if(!empty($value['part_state'])){
				$value['part_state'] = $this->common_model->valueFromId('state_master',$value['part_state'],'state_name');
			}
			
			if(!empty($value['part_city'])){
				$value['part_city'] = $this->common_model->valueFromId('city_master',$value['part_city'],'city_name');
			}
			
			if(!empty($value['star'])){
				$value['star'] = $this->common_model->valueFromId('star',$value['star'],'star_name');
			}
			
			if(!empty($value['part_star'])){
				$value['part_star'] = $this->common_model->valueFromId('star',$value['part_star'],'star_name');
			}
			
			if(!empty($value['moonsign'])){
				$value['moonsign'] = $this->common_model->valueFromId('moonsign',$value['moonsign'],'moonsign_name');
			}
			
			// if(!empty($value['height'])){
			// 	$value['height'] = $this->common_model->display_height($value['height']);
			// }
			
			if(!empty($value['part_height'])){
				$value['part_height'] = $this->common_model->display_height($value['part_height']);
			}
			
			if(!empty($value['part_height_to'])){
				$value['part_height_to'] = $this->common_model->display_height($value['part_height_to']);
			}
			$resultDataCsv[] = $value;
		}
		}
		## Export Data TO CSV :
		$this->dataToCSV($resultDataCsv,$headers = TRUE, $filename= "Registered-Member-Data-csv-".date('Y-m-d H:i:s'));
	}
    function createLabel($key='') {
    	$label = '';
    	if(isset($key) && $key !='') {
    		$label = str_replace('_',' ',$key);
    		$label = ucfirst($label);
    	}
    	return $label;
    }
	function dataToCSV($data, $headers = TRUE, $filename= ""){
		$responseArr['status'] = 'error';
        $responseArr['msg'] = 'invalid Data provided';

		if ( ! is_array($data)){
			show_error($responseArr);
		}

		$array = array();
		if ($headers){
			$tempArray = array();
			$lableArr = array_keys($data[0]);
			foreach ($lableArr as $key => $label) {
				array_push($tempArray,$this->createLabel($label));
			}
			$array[] = $tempArray;
		}
		foreach ($data as $row){
			$line = array();
			foreach ($row as $item){
				$line[] = $item;
			}
			$array[] = $line;
		}
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename=\"$filename".".csv\"");
		header("Pragma: no-cache");
		header("Expires: 0");
		$handle = fopen('php://output', 'w');
		foreach ($array as $array) {
			fputcsv($handle, $array);
		}
		fclose($handle);
		exit;
	}
}