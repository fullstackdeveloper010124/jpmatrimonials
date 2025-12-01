<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Approval extends CI_Controller {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->common_model->checkLogin(); // here check for login or not
	}
	public function index()
	{
		$this->member_photo();
	}
	public function member_photo1($status ='ALL', $page =1)
	{
		$this->member_photo(1,$status, $page);
	}
	public function member_photo2($status ='ALL', $page =1)
	{
		$this->member_photo(2,$status, $page);
	}
	public function member_photo3($status ='ALL', $page =1)
	{
		$this->member_photo(3,$status, $page);
	}
	public function member_photo4($status ='ALL', $page =1)
	{
		$this->member_photo(4,$status, $page);
	}
	public function member_photo5($status ='ALL', $page =1)
	{
		$this->member_photo(5,$status, $page);
	}
	public function member_photo6($status ='ALL', $page =1)
	{
		$this->member_photo(6,$status, $page);
	}
	public function member_photo7($status ='ALL', $page =1)
	{
		$this->member_photo(7,$status, $page);
	}
	public function member_photo8($status ='ALL', $page =1)
	{
		$this->member_photo(8,$status, $page);
	}
	public function member_photo($photo_no = '',$status ='ALL', $page =1)
	{
		if($photo_no !='' && $photo_no > 0 && $photo_no < 9)
		{
			$access_perm = $this->common_model->check_permission('photo_approval','redirect');
			
			//$this->common_model->base_url_admin_cm = $this->common_model->base_url_admin_cm.$photo_no.'/';
			$column_photo = 'photo'.$photo_no;
			$column_photo_app = 'photo'.$photo_no.'_approve';
			$column_photo_date = 'photo'.$photo_no.'_uploaded_on';
			$ele_array = array(
				$column_photo=>array('path_value'=>$this->common_model->path_photos)
			);
			$this->delete_file_perment('photo'.$photo_no,$this->common_model->path_photos);
			$other_config = array(
				'addAllow'=>'no',
				'editAllow'=>'no',
				'display_image'=>array($column_photo),
				'personal_where'=>" $column_photo !='' ",
				'default_order'=>'desc',
			);
			$filter_profile_perm = $this->common_model->check_permission('photo_delete');
			if($filter_profile_perm =='No' || ($filter_profile_perm =='Own Members' && $access_perm !='Own Members'))
			{
				$other_config['deleteAllow']='no';
			}
			if($filter_profile_perm =='Own Members' && $access_perm =='All Members')
			{
				$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
			}
			$this->common_model->button_array[] = array('onClick'=>"return crop_photo(#id#,'".$photo_no."')",'class'=>'success','label'=>'Crop Photo' ,'extra_btn_prop1'=>'data-toggle="modal" data-target="#myModal_pic"');
			$other_config['data_tab_btn'] = $this->common_model->button_array;
			$other_config = $this->common_model->add_own_where($other_config,$access_perm); //add this line after initilie config and personal where, so current both personal where should remian in query
			
			//$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
			$this->common_model->status_column = $column_photo_app;
			$this->common_model->status_field = $column_photo_app;
			$this->common_model->display_selected_field = array('id',$column_photo_app,'matri_id','username','email',$column_photo_date,$column_photo);
			$_POST['member_approved_status']='photo';
			$this->common_model->common_rander('register', $status, $page , 'Member Photo - '.$photo_no.' Approval',$ele_array,$column_photo_date,1,$other_config);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'dashboard');
			exit;
		}
	}
	public function video($status ='ALL', $page =1)
	{
		$access_perm = $this->common_model->check_permission('video_approval','redirect');
		$ele_array = array(
		'video_url'=>array('path_value'=>$this->common_model->path_video)
		);
		
		$this->delete_file_perment('video_url',$this->common_model->path_video);
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'display_image'=>array('video_url'),
			'personal_where'=>" video_url!='' ",
			'default_order'=>'desc'
		);
		$filter_profile_perm = $this->common_model->check_permission('video_url_delete');
		if($filter_profile_perm =='No' || ($filter_profile_perm =='Own Members' && $access_perm !='Own Members'))
		{
			$other_config['deleteAllow']='no';
		}
		if($filter_profile_perm =='Own Members' && $access_perm =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
		}
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$other_config = $this->common_model->add_own_where($other_config,$access_perm);
		
		$this->common_model->status_column = 'video_approval';
		$this->common_model->status_field = 'video_approval';
		$this->common_model->display_selected_field = array('id','video_approval','matri_id','username','email','video_url');
		$this->common_model->common_rander('register', $status, $page , 'Member Video',$ele_array,'last_login',1,$other_config);
	}
	
	public function cover_photo($status ='ALL', $page =1)
	{
		$access_perm = $this->common_model->check_permission('cover_photo_approval','redirect');
		$ele_array = array(
		'cover_photo'=>array('path_value'=>$this->common_model->path_cover_photo)
		);
		$this->delete_file_perment('cover_photo',$this->common_model->path_cover_photo);
		$_REQUEST['status_update']='';
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'display_image'=>array('cover_photo'),
			'personal_where'=>"cover_photo!=''",
			'default_order'=>'desc'
		);
		$filter_profile_perm = $this->common_model->check_permission('cover_photo_delete');
		if($filter_profile_perm =='No' || ($filter_profile_perm =='Own Members' && $access_perm !='Own Members'))
		{
			$other_config['deleteAllow']='no';
		}
		if($filter_profile_perm =='Own Members' && $access_perm =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
		}
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$other_config = $this->common_model->add_own_where($other_config,$access_perm); //add this line after initilie config and personal where, so current both personal where should remian in query

		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$this->common_model->status_column = 'cover_photo_approve';
		$this->common_model->status_field = 'cover_photo_approve';
		$this->common_model->display_selected_field = array('id','cover_photo_approve','matri_id','username','email','cover_photo_uploaded_on','cover_photo');
		$this->common_model->common_rander('register', $status, $page , 'Member Cover Photo',$ele_array,'cover_photo_uploaded_on',1,$other_config);
	}
	
	public function id_proof($status ='ALL', $page =1)
	{
		$access_perm = $this->common_model->check_permission('id_proof_approval','redirect');
		//$photo_perm = $this->common_model->check_permission('photo'.$photo_no.'_approval','redirect');
		$ele_array = array(
		'id_proof'=>array('path_value'=>$this->common_model->path_id_proof)
		);
		$this->delete_file_perment('id_proof',$this->common_model->path_id_proof);
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'display_image'=>array('id_proof'),
			'personal_where'=>"id_proof!=''",
			'default_order'=>'desc'
		);
		$filter_profile_perm = $this->common_model->check_permission('id_proof_delete');
		if($filter_profile_perm =='No' || ($filter_profile_perm =='Own Members' && $access_perm !='Own Members'))
		{
			$other_config['deleteAllow']='no';
		}
		if($filter_profile_perm =='Own Members' && $access_perm =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
		}
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$other_config = $this->common_model->add_own_where($other_config,$access_perm); //add this line after initilie config and personal where, so current both personal where should remian in query
		
		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$this->common_model->status_column = 'id_proof_approve';
		$this->common_model->status_field = 'id_proof_approve';
		$this->common_model->display_selected_field = array('id','id_proof_approve','matri_id','username','email','id_proof_uploaded_on','id_proof'	);
		$this->common_model->common_rander('register', $status, $page , 'Member ID Proof',$ele_array,'id_proof_uploaded_on',1,$other_config);
	}
	
	public function horoscope($status ='ALL', $page =1)
	{
		$access_perm = $this->common_model->check_permission('horoscope_approval','redirect');
		$ele_array = array(
		'horoscope_photo'=>array('path_value'=>$this->common_model->path_horoscope)
		);
		$this->delete_file_perment('horoscope_photo',$this->common_model->path_horoscope);
		$_REQUEST['status_update']='';
		$other_config = array(
			'addAllow'=>'no',
			'editAllow'=>'no',
			'display_image'=>array('horoscope_photo'),
			'personal_where'=>"horoscope_photo!=''",
			'default_order'=>'desc'
		);
		$filter_profile_perm = $this->common_model->check_permission('horoscope_delete');
		if($filter_profile_perm =='No' || ($filter_profile_perm =='Own Members' && $access_perm !='Own Members'))
		{
			$other_config['deleteAllow']='no';
		}
		if($filter_profile_perm =='Own Members' && $access_perm =='All Members')
		{
			$this->common_model->button_array[] = array('onClick'=>"return update_status_single(#id#,'DELETE')",'class'=>'danger','label'=>'Delete','own_only' => 'yes');
		}
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		$other_config = $this->common_model->add_own_where($other_config,$access_perm); //add this line after initilie config and personal where, so current both personal where should remian in query

		$this->common_model->js_extra_code.= ' if($(".magniflier").length > 0){OnhoverMove();}';
		$this->common_model->status_column = 'horoscope_photo_approve';
		$this->common_model->status_field = 'horoscope_photo_approve';
		$this->common_model->display_selected_field = array('id','horoscope_photo_approve','matri_id','username','email','horoscope_photo_uploaded_on','horoscope_photo');
		$this->common_model->common_rander('register', $status, $page , 'Member Horoscope',$ele_array,'horoscope_photo_uploaded_on',1,$other_config);
	}
	// changes for shakil 18-12-2020
	public function success_story($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access();
		$ele_array = array(
			'weddingphoto'=>array('is_required'=>'required','type'=>'file','path_value'=>$this->common_model->path_success,'label'=>'Upload Your Wedding Photo','inline_style'=>'height:100px;width:150px;'),
			'bridename'=>array('is_required'=>'required','label'=>"Bride's Name"),
			'brideid'=>array('is_required'=>'required','label'=>"Bride's ID",'check_duplicate'=>'Yes','other'=>'onchange="return check_brideid_groomid(1);"'),
			'groomname'=>array('is_required'=>'required','label'=>"Groom's Name"),
			'groomid'=>array('is_required'=>'required','label'=>"Groom's Id",'check_duplicate'=>'Yes','other'=>'onchange="return check_brideid_groomid(2);"'),
			'marriagedate'=>array('input_type'=>'date','is_required'=>'required','label'=>'Your Marriage Date'),
			// SEO ADD Field 17-12-2020
			'seo_title'=>array('is_required'=>'required'),
			'seo_description'=>array('is_required'=>'required','type'=>'textarea'),
			'seo_keywords'=>array('is_required'=>'required','type'=>'textarea'),
			'og_title'=>array('is_required'=>'required'),
			'og_image'=>array('is_required'=>'required','type'=>'file','path_value'=>'assets/ogimg/'),
			'og_description'=>array('is_required'=>'required','type'=>'textarea'),

		
			'successmessage'=>array('type'=>'textarea','label'=>'Success Message'),
			'status'=>array('type'=>'radio')
		);
		$this->common_model->extra_js[] = 'vendor/ckeditor/ckeditor.js';
		$this->common_model->extra_js[] = 'vendor/jquery-validation/dist/additional-methods.min.js';
		$this->common_model->extra_css[] = 'vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css';
		$this->common_model->extra_js[] = 'vendor/bootstrap-datepicker/js/bootstrap-datepicker.js';
		
		$this->common_model->js_extra_code.= '
		var currentDate = new Date();
		$("#marriagedate").datepicker("setEndDate", currentDate);
		if($(".magniflier").length > 0){OnhoverMove();} ';
		
		$this->common_model->data_tabel_filedIgnore = array('id','is_deleted','weddingphoto_type', 'successmessage');
		$this->common_model->js_extra_code.= " if($('#successmessage').length > 0) {  $('.successmessage_edit').removeClass(' col-lg-7 ');
			$('.successmessage_edit').addClass(' col-lg-10 ');
			CKEDITOR.replace( 'successmessage' ); } ";
			
		$data_table = array(
			'title_disp'=>'Success Story',
			'post_title_disp'=>'',
			'disp_column_array'=> array('bridename','groomname','brideid','groomid','marriagedate','created_on')
		);
		
		$edit_btn_arr = array('url'=>'approval/success_story/edit-data/#id#','class'=>'info','label'=>'Edit');
		$this->common_model->button_array[] = $edit_btn_arr;
		
		$view_btn_arr = array('url'=>'approval/view-detail/#id#','class'=>'primary','label'=>'View');
		$this->common_model->button_array[] = $view_btn_arr;
		
		$other_config = array('load_member'=>'yes','data_table_mem'=>$data_table,'default_order'=>'desc','enctype'=>'enctype="multipart/form-data"','display_image'=>'weddingphoto','og_image','weddingphoto'=>$this->common_model->path_success,'field_duplicate'=>array('brideid','groomid')); 
		// load member for data table display member listing not table
		
		$label_disp = 'Success Story';
		
		$other_config['data_tab_btn'] = $this->common_model->button_array;
		
		$this->common_model->label_col = 2;
		$this->common_model->form_control_col =7;
		//print_r($other_config);
		//print_r($ele_array); exit;
		$this->common_model->common_rander('success_story',$status,$page,$label_disp,$ele_array,'created_on',0,$other_config);
	}
	public function view_detail($id='')
	{
		if($id !='')
		{
			$data = array();
			$data['id'] = $id; // current row id for view detail
			$data['back_detail_url'] = 'success-story';
			$image_arra = array(
			array(
				'filed_arr' => array('weddingphoto'),
				'path_value'=>$this->common_model->path_success,
				'title'=>'Wedding Photo',
				'class_width'=>' col-lg-3 col-md-4 col-sm-6  col-xs-12 ',
				'img_class'=>'img-responsive img-thumbnail',
				'inline_style'=>''
			));
			
			$field_main_array = array(				
				array(
					'title'=>'Success Story',
					'class_width'=>' col-lg-6 col-md-6 col-sm-12 col-xs-12 ',
					
					'field_array'=>array(
						'brideid'=>array('label'=>'Bride Id'),
						'groomid'=>array('label'=>'Groom Id'),
						'bridename'=>array('label'=>'Bride Name'),
						'groomname'=>array('label'=>'Groom Name'),
						'marriagedate'=>array('label'=>'Marriage Date','type'=>'date'),
						'created_on'=>array('type'=>'date'),
						'successmessage'=>array('label'=>'Success Message','is_single'=>'yes','class_width'=>' col-lg-12 col-md-12 col-sm-12 col-xs-12','disp_label'=>'yes','format'=>'')
					),
				),
			);
			$data['img_list_arr'] = $image_arra;
			$data['img_position'] = 'bottom';
			$data['field_list'] = $field_main_array;			
			$this->common_model->table_name = 'success_story'; // set table name for get data from wich table 
			$this->common_model->common_view_detail('Success Story Detail',$data);
		}
		else
		{
			redirect($this->common_model->base_url_admin.'approval/success-story');
		}
	}
	function delete_file_perment($filed_name='',$file_path='')
	{
		$photo_array_filed = array('photo1','photo2','photo3','photo4','photo5','photo6','photo7','photo8');
		if($filed_name !='' && $file_path !='')
		{
			if(isset($_REQUEST['status_update']) && $_REQUEST['status_update'] =='DELETE' && isset($_REQUEST['selected_val']) && $_REQUEST['selected_val'] != '' && count($_REQUEST['selected_val']) > 0)
			{
				$selected_val = $_REQUEST['selected_val'];
				$this->db->where_in('id', $selected_val);
				$data_row = $this->common_model->get_count_data_manual('register','',2,$filed_name);
				if(isset($data_row) && $data_row !='' && count($data_row) > 0)
				{
					$data_file_array = array();
					foreach($data_row as $data_row_val)
					{
						if(isset($data_row_val[$filed_name]) && $data_row_val[$filed_name] !='')
						{
							$file_name = $data_row_val[$filed_name];
						}
						if(file_exists($file_path.$file_name))
						{
							$data_file_array[] = $file_path.$file_name;
						}
						if(in_array($filed_name,$photo_array_filed))
						{
							$data_file_array[] = $this->common_model->path_photos_big.$file_name;
						}
					}
					if($filed_name=='video_url')
					{
						$data_array_update = array($filed_name=>'','video_approval'=>'UNAPPROVED');
					}
					else
					{
						$data_array_update = array($filed_name=>'',$filed_name.'_approve'=>'UNAPPROVED',$filed_name.'_uploaded_on'=>'0000-00-00 00:00:00');
					}
					$this->db->where_in('id', $selected_val);
					$response = $this->common_model->update_insert_data_common('register',$data_array_update,'',1,0);
					if(isset($response) && $response )
					{
						if(isset($data_file_array) && $data_file_array !='' && count($data_file_array) > 0)
						{
							$this->common_model->delete_file($data_file_array);
						}
						$success_message = $this->common_model->success_message['delete'];
						$this->session->set_flashdata('success_message', $success_message);
					}
					else
					{
						$this->session->set_flashdata('error_message', $this->common_model->success_message['error']);
					}
				}
				$_REQUEST['is_allow_update'] = 'No';
			}
		}
	}
	
	public function wedding_vendors_review($status ='ALL', $page =1)
	{
		$this->common_model->check_admin_only_access();
		
		$star_array= array( '1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
		
		$ele_array = array(
			'vendor_id'=>array('display_in'=>'2','type'=>'dropdown','relation'=>array('rel_table'=>'wedding_planner','key_val'=>'id','key_disp'=>'planner_name'),'label'=>'Vendor Name','is_required'=>'required',),
			'r_name'=>array('is_required'=>'required','label'=>'Name'),
			'r_email'=>array('is_required'=>'required','label'=>'E-mail'),
			'r_title'=>array('is_required'=>'required','label'=>'Review Title'),
			'r_message'=>array('type'=>'textarea','is_required'=>'required','label'=>'Review Message'),
			'r_star'=>array('display_in'=>'1','type'=>'dropdown','key_val'=>'id','label'=>'Write Review','value_arr'=>$star_array,'value'=>'All','is_required'=>'required',),
			'status'=>array('type'=>'radio')
		);
		
		$other_config = array('default_order'=>'DESC'); 
		
		$join_tab_array = array();
		$join_tab_array[] = array( 'rel_table'=>'wedding_planner', 'rel_filed'=>'id', 'rel_filed_disp'=>'planner_name','rel_filed_org'=>'vendor_id');
		
		$this->common_model->display_selected_field = array('id','status','vendor_id','r_name','r_email','r_title','r_message','r_star');
		
		$this->common_model->common_rander('vendor_reviews', $status, $page , 'Vendors Review',$ele_array,'id',0,$other_config,$join_tab_array);
	}
	
	public function check_brideid_groomid()
	{
		$gender = $this->input->post('gender');
		$brideid = $this->input->post('brideid');
		$groomid = $this->input->post('groomid');
		
		$data1['groomid'] = '';
		$data1['brideid'] = '';
		
		if(isset($gender) && $gender == 'Female' && isset($brideid) && $brideid != '')
		{
			$where_arra = array('gender'=>$gender,'matri_id'=>$brideid);
		}
		elseif(isset($gender) && $gender == 'Male' && isset($groomid) && $groomid != '')
		{
			$where_arra = array('gender'=>$gender,'matri_id'=>$groomid);
		}
		else
		{
			$where_arra = '';
		}
		
		if(isset($where_arra) && $where_arra != ''){
			$data_arr_count = $this->common_model->get_count_data_manual('register',$where_arra,0,'matri_id','','','','');
		
			if(isset($data_arr_count) && $data_arr_count > 0){
				$data1['status'] = 'success';
				$data1['error_message'] = 'User id is valid.';
			}else{
				if(isset($brideid) && $brideid != ''){
					$data1['brideid'] = 'brideid';
				}
				if(isset($groomid) && $groomid != ''){
					$data1['groomid'] = 'groomid';
				}
				$data1['status'] = 'error';
				$data1['error_message'] = 'User id is not valid.';
			}
		}else{
			$data1['status'] = 'error';
			$data1['error_message'] = 'Please try again...!!!';
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		$this->load->view('common_file_echo',$data);
	}
	
	public function crop_photo($user_id='',$photo_id='')
	{
		if($user_id !='' && $photo_id !='')
		{
			$data['base_url'] = $this->common_model->base_url;
			$data['member_id'] = $user_id;
			$data['photo_number'] = $photo_id;
			$this->load->view('back_end/crop_photo_member',$data);
		}
		else
		{
			echo '<div class="alert alert-danger" style=" padding: 10px 15px;background-color: #f5d7d4; border-color: #f2ccc7;color: #a53325;">Please try again.</div>';	
		}
	}
	public function upload_photo_new()
	{
		$member_id = $this->common_front_model->get_user_id();
		$status = 'error';
		$errmessage = "Please try again";
		if($member_id !='')
		{
			$number='';
			
			$photo_upload_count = $this->common_model->photo_upload_count;
			if($photo_upload_count ==0 || $photo_upload_count == '' || $photo_upload_count <0 || $photo_upload_count > 8)
			{
				$photo_upload_count = 8;
			}
			$file_list_array = array('photo1','photo2','photo3','photo4','photo5','photo6','photo7','photo8','cover_photo');
			$file_list_array_str = implode(', ',$file_list_array);
			
			$where_arra = array('id'=>$member_id);
			$path_photos = $this->common_model->path_photos;
			$path_cover_photo = $this->common_model->path_cover_photo;
			$path_photos_big = $this->common_model->path_photos_big;
			$row_data = $this->common_model->get_count_data_manual('register',$where_arra,1,$file_list_array_str);
			$file_number = '';
			$file_delete_array = array();
			$file_name_update = '';
			for($ij = 1; $ij<=$photo_upload_count; $ij++)
			{
				if(isset($_FILES['profile_photo'.$ij.'_crop']) && $_FILES['profile_photo'.$ij.'_crop']['name'] !='')
				{
					$file_number = $ij;
					$temp_data_array = array('file_name'=>'profile_photo'.$ij.'_crop','upload_path'=>$path_photos,'overwrite'=> TRUE);
					if(isset($_REQUEST['file_name_upload']) && $_REQUEST['file_name_upload'] !='')
					{
						$file_name_upload = $_REQUEST['file_name_upload'];
						$temp_data_array['file_name_upload'] = $file_name_upload;
					}
					$response = $this->common_front_model->file_upload_new($temp_data_array);
					if(isset($response['status']) && $response['status'] == 'success')
					{
						$file_name_update = $response['file_name'];
						$status = 'success';
						$errmessage = "Photo Cropped and updated Successfully";
					}
					else
					{
						if(isset($response['error_message']) && $response['error_message'] !='')
						{
							$errmessage = strip_tags($response['error_message']);
						}
						else
						{
							$errmessage = "File upload error";
						}
						$status = 'error';
					}
				}
			}
		}
		if($status =='error')
		{
			$errmessage ='<div class="alert alert-danger" style=" padding: 10px 15px;background-color: #f5d7d4; border-color: #f2ccc7;color: #a53325;">'.$errmessage.'</div>';
		}
		else
		{
			$errmessage ='<div class="alert alert-success" style=" padding: 10px 15px;background-color: #a8ebc4;border-color: #9be8bc; color: #1b7943;">'.$errmessage.'</div>';
		}
		$data1['status'] = $status;
		$data1['errmessage'] = $errmessage;
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);

		$this->load->view('common_file_echo',$data);
	}
}