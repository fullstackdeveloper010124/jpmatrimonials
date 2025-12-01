<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Check_results extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->admin_path = $this->common_model->getconfingValue('admin_path');
		$this->data['admin_path'] = $this->admin_path;
		$this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->common_model->checkLogin(); // here check for login or not
		
	}
	public function index()
	{
		$this->data['check_results'] = 'Yes';
		$this->data['config_data'] = $this->common_model->get_site_config();
		$this->load->view('back_end/match_results_view',$this->data);
	}

	public function process_data(){
		$process = $this->input->post('sql');
		$this->load->database();
		$this->db->truncate($process);
		//$query = $this->db->query($process);
		//$results = $query->result();
		redirect($this->base_url_admin.'dashboard');
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