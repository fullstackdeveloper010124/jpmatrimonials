<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Advertisement_management extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->common_model->checkLogin(); // here check for login or not
		$this->common_model->check_admin_only_access();
	}
	public function index()
	{
		$this->adv_pages();
	}
	public function adv_list($status ='ALL', $page =1)
	{
		$ele_array = array(
			'type'=>array('is_required'=>'required','type'=>'radio','value_arr'=>array('Image'=>'Image','Google'=>'Google'),'value'=>'Image','class'=>'adv_type','onclick'=>'chnageadvType()'),
			'link'=>array('is_required'=>'required','input_type'=>'url','form_group_class'=>'image_adv'),
			'image'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->path_advertise,'form_group_class'=>'image_adv'),
			'google_adsense'=>array('is_required'=>'required','type'=>'textarea','form_group_class'=>'google_adv'),
			'level'=>array('is_required'=>'required','type'=>'dropdown','value_arr'=>array('Level 1'=>'Level 1 size 357 x 192 for best result','Level 2'=>'Level 2')),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		
		$this->common_model->js_extra_code.= " chnageadvType(); ";
		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$other_config = array('enctype'=>'enctype="multipart/form-data"','display_image'=>array('image'),'image'=>$this->common_model->path_advertise,'default_order'=>'desc');
		$this->common_model->common_rander('advertisement_master', $status, $page , 'Advertisement',$ele_array,'created_on',0,$other_config);
	}
}