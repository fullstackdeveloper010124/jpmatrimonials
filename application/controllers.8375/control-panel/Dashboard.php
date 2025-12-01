<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->admin_path = $this->common_model->getconfingValue('admin_path');
		$this->data['admin_path'] = $this->admin_path;
		if(!$this->session->userdata('matrimonial_user_data') || $this->session->userdata('matrimonial_user_data') =="" && count($this->session->userdata('matrimonial_user_data')) ==0 )
		{
			redirect($this->base_url.$this->admin_path.'/login');
		}
		$this->load->model('back_end/SiteSetting_model','SiteSetting_model');
		$this->table_name = 'site_config'; 	// *need to set here tabel name //
		$this->common_model->set_table_name($this->table_name);
	}
	public function index()
	{
		$this->data['page_title'] = 'Dashboard';
		$this->data['config_data'] = $this->common_model->get_site_config();
		$this->load->view('back_end/page_part/header',$this->data);
		$this->load->view('back_end/dashboard_view',$this->data);
		$this->load->view('back_end/page_part/footer',$this->data);
	}
	public function color_change($status ='')
	{
		$this->label_page = 'Update Site Color';
		if(isset($status) && $status == 'save-data')
		{
			$this->common_model->save_update_data(1,'','Yes');
		}
		else
		{
			$ele_array = array(
				'colour_name'=>array('is_required'=>'required','input_type'=>'color'),
				'font_color'=>array('is_required'=>'required','input_type'=>'color'),
				'profile_border_color'=>array('is_required'=>'required','input_type'=>'color'),
			);
			$other_config = array('mode'=>'edit','id'=>'1','action'=>'dashboard/update_color');
			$this->data['data'] = $this->common_model->generate_form_main($ele_array,$other_config);

			$this->common_model->__load_header($this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->common_model->__load_footer();
		}
	}
	
	public function update_color()
	{
		$this->SiteSetting_model->update_color();
		$this->common_model->save_update_data();
		redirect($this->common_model->base_url_admin.'site-setting/color_change');
	}
	
}