<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Database_query extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
	}
	public function index()
	{
		
	}
	public function backup()
	{
		
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup();
		
		// Load the file helper and write the file to your server
	 	$db_name_fil = 'backup-on-'. date("Y-m-d-H-i-s") .'.gz';
		$this->load->helper('file');
		write_file("backup/$db_name_fil", $backup);
		
		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($db_name_fil, $backup);
	}
}