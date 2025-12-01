<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Common_front_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		
		$this->data['base_url'] = $this->base_url = base_url();
		$this->data['config_data'] = $this->get_site_config();
		$this->data['custom_lable'] = $this->lang;
		$this->limit_per_page = 10;
		$this->field_duplicate='';
		
		$this->first_tag ='';
		$this->after_tag ='';
		$this->last_tag ='';
		$user_agent = '';
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] !='')
		{
			$user_agent = $_REQUEST['user_agent'];
		}
		if($user_agent!='' && $user_agent=='NI-AAPP')
		{
			$this->set_orgin();
		}
	}
	public function set_div_tag($page_type = 'register')
	{
		if($page_type =='register')
		{
			$this->first_tag ='<div class="xxl-16 xl-16 xs-16 s-16 m-16 l-16 margin-top-20px"><div class="row"><div class="xxl-5 xl-5 xs-16 s-16 m-16 l-4 margin-top-5px"><label>';
			$this->after_tag ='</label></div><div class="clearfix visible-xs"></div><div class="xxl-11 xl-11 xs-16 s-16 m-16 l-8">';
			$this->last_tag ='</div></div></div>';
		}
		else if($page_type =='edit_profile')
		{
			$this->first_tag ='<div class="form-group xxl-16 xl-16 s-16 m-16 xs-16 l-16 padding-lr-zero-320 padding-lr-zero-480 padding-0-xs"><label class="xxl-4 xl-6 m-16 l-6 s-16 xs-16 margin-top-5px profile-label">';
			$this->after_tag ='</label><div class="xxl-12 xl-10 s-16 xs-16 m-16 l-10">';
			$this->last_tag ='</div></div>';
		}
		else if($page_type =='search')
		{
			$this->first_tag ='<div class="form-group xxl-16 xl-16 l-16 m-16 s-16 xs-16  padding-lr-zero-320 padding-lr-zero-480 padding-bottom-10px padding-lr-zero-xs"><div class="xxl-4 xs-16 s-16 m-4 l-4 xl-4 margin-top-5px src-label">';
			$this->after_tag ='</div><div class="xxl-12 xl-12 xs-16 s-16 m-12 l-12 margin-top-5px-320 margin-top-5px-480">';
			$this->last_tag ='</div></div>';
		}
	}
	public function already_login_redirect()
	{
		$user_id = $this->get_user_id();
		if($user_id !='')
		{
			redirect($this->base_url.'my-profile');
		}
	}
	public function checkLogin($type='redirect')
	{
		// need to work for ajax request and login issue
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
		{
			return true;
		}
		else
		{
			if(!$this->session->userdata('mega_user_data') || $this->session->userdata('mega_user_data') =="" && count($this->session->userdata('mega_user_data')) ==0 )
			{
				$base_url = base_url();
				if($type == 'redirect')
				{
					redirect($base_url.'login');
				}
				else if($type == 'return')
				{
					return false;
				}
			}
			else
			{
				if($type == 'return')
				{
					return true;
				}
			}
		}
	}
	public function get_session_data($return_filed='')
	{
		$matrimonial_user_data = $this->session->userdata('mega_user_data');
		$return_val = '';
		if($return_filed =='')
		{
			$return_val = $matrimonial_user_data;
		}
		else
		{
			if(isset($matrimonial_user_data[$return_filed]) && $matrimonial_user_data[$return_filed] !='')
			{
				$return_val = $matrimonial_user_data[$return_filed];
			}
		}
		
		return $return_val;
	}
	public function get_login_user_data($js_id,$select='*')
	{
		$where = array('id'=>$js_id);
		$login_data = $this->common_model->get_count_data_manual("register",$where,1,$select,'','',1);
		return $login_data;						
	}
	public function get_user_data($table,$id,$select='*',$id_f ='id')
	{
		$user_data = '';
		if($table !='' && $id!='' && $id_f !='')
		{
			$where = array($id_f=>$id);
			$user_data = $this->common_model->get_count_data_manual($table,$where,1,$select,'','',1);
		}
		return $user_data;
	}
	
	public function __load_header($label_page='',$status='')
	{
		$this->label_page = $label_page;
		$page_title = $label_page;
		if($status !='')
		{
			$page_title = $page_title.' - '.$status;
		}
		$this->data['page_title'] = $page_title;
		$this->load->view('front_end/page_part/header',$this->data);
	}
	public function __load_footer($model_body='')
	{
		$this->data['model_body'] = $model_body;
		$this->data['model_title'] = 'Add '.$this->label_page;
		$this->load->view('front_end/page_part/footer',$this->data);
	}
	public function get_site_config()
	{
       	$this->db->limit(1);
		$query = $this->db->get_where('site_config', array('id' => 1));
       	return $query->row_array();
	}
	function last_query()
	{
		return $this->db->last_query();
	}
	function get_count_data_manual($table,$where_arra='',$flag_count_data = 0,$select_f ='',$order_by='',$page='',$limit='',$disp_query = "")
	{
		if($table !='')
		{
			if($where_arra !='' && is_array($where_arra) && count($where_arra) >0)
			{
				foreach($where_arra as $key=>$val)
				{
					
					if(is_numeric($key))
					{ 
						$this->db->where($val);
					}
					else
					{ 
						$this->db->where($key,$val);
					}
				}
			}
			else if($where_arra !='')
			{
				$this->db->where($where_arra);
			}
			if(isset($select_f) && $select_f !='')
			{
				$this->db->select($select_f);
			}

			if($flag_count_data == 0)
			{
				//$search_data = $this->db->get_compiled_select($table);
				return $this->db->count_all_results($table);
			}
			else 
			{
				if(isset($order_by) && $order_by !='')
				{
					$this->db->order_by($order_by);
				}
				if($flag_count_data==1)
				{
					$this->db->limit(1);
				}
				else
				{
					/*if($limit =="")
					{
						$limit = $this->limit_per_page;
					}*/
					if($page !='' && $limit !='')
					{
						$start = (($page - 1) * $limit);
						$this->db->limit($limit,$start);
					}
					//$this->db->limit(1);
				}
				
				if($disp_query == 1)
				{
					echo $this->db->get_compiled_select($table);
				}
				
				$query = $this->db->get($table);
				if($flag_count_data == 1)
				{
					if($query->num_rows() == 0)
					{
						return '';
					}
					else
					{
						return $query->row_array();
					}
				}
				else
				{
					if($query->num_rows() == 0)
					{
						return '';	
					}
					else
					{ 
						return $query->result_array();
					}
				}
			}
		}
		else
		{
			return '';
		}
		
	}
	function update_insert_data_common($table='',$data_array='',$where_arra='',$flag_update=1,$limit=1)
	{
		
		if($table !='' && $data_array !='')
		{
			if($flag_update == 1)
			{
				if($where_arra !='' && count($where_arra) >0)
				{
					foreach($where_arra as $key=>$val)
					{
						$this->db->where($key,$val);
					}
				}
				if($limit == 1)
				{
					$this->db->limit(1);
				}
				$return = $this->db->update($table,$data_array);
			}
			else
			{
				if($flag_update == 2)
				{
					$return = $this->db->insert_batch($table,$data_array);
				}
				else
				{
					$return = $this->db->insert($table,$data_array);
				}
			}
		}
		return $return;
	}
	function data_delete_common($table='',$where_arra='',$limit=0)
	{
		$return = false;
		if($table !='')
		{
			if($where_arra !='' && count($where_arra) >0)
			{
				foreach($where_arra as $key=>$val)
				{
					$this->db->where($key,$val);
				}
			}
			if($limit == 1)
			{
				$this->db->limit(1);
			}
			$return = $this->db->delete($table);
		}
		return $return;
	}
	
	public function save_update_data($table_name='', $data_array_custom='',$primary_key='id', $mode ='add', $id ='', $field_duplicate='',$limit=1, $is_delete_fild='is_deleted',$fileupload = 1)
	{
		//error_reporting(E_ALL);
		if($table_name == '' && $primary_key == '')
		{
			return false;
		}
		$response_data = '';
		//print_r($_REQUEST);
		//print_r($_FILES);
		//exit;
		$table_field = $this->db->list_fields($table_name);
		
		if($table_name !='' && $table_field !='' && count($table_field) > 0 )
		{
			$where_arra='';
			$flag_update = 0;
			$data_array = array();
			$data_file_old_array = array();
			$data_file_new_array = array();
			$where_arra_dup = '';
			//$mode = 'add';
			//$id = '';
			$is_duplicate = 0;
			if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='edit')
			{
				$mode = 'edit';
			}
			if($this->input->post('id'))
			{
				$id = trim($this->input->post('id'));
			}
			if($id !='' && $mode !='' && $mode =='edit' && $primary_key !='')
			{
				$where_arra = array($primary_key =>$id);
				//$this->db->where($primary_key .' != '.$id); // for duplicate check with id
				$where_arra_dup = "'".$primary_key .' != '.$id."'";
				$flag_update = 1;
			}
			if($field_duplicate !='')
			{
				$filed_dup_check = $field_duplicate;
				if(isset($filed_dup_check) && $filed_dup_check !='' && count($filed_dup_check) > 0)
				{
					foreach($filed_dup_check as $filed_dup_check_val)
					{
						if($this->input->post($filed_dup_check_val))
						{
							$filed_dup_check_val_fill = $this->input->post($filed_dup_check_val);
							if($filed_dup_check_val_fill !='' && $filed_dup_check_val !='')
							{
								$this->db->where($filed_dup_check_val,$filed_dup_check_val_fill);
							}
						}
					}
					if(in_array($is_delete_fild,$table_field))
					{
						$this->db->where($this->table_name.'.'.$is_delete_fild,'No');
					}
					
					$cound_duplicate = $this->get_count_data_manual($table_name,$where_arra_dup,0,$primary_key);
					if($cound_duplicate > 0)
					{
						$is_duplicate = 1;
						$response_data = 'exists';
						return $response_data;
					}
				}
			}
			if($is_duplicate == 0)
			{
				if($mode =='add')
				{
					$genrate_url='';
					if($this->input->post('genrate_url'))
					{
						$genrate_url = $this->input->post('genrate_url');
						if($genrate_url !='')
						{
							$this->generate_url_comon($genrate_url);
						}
					}
				}
				// for check edit mode
				// for check file upload 
				// set fileupload var to false if you doont want to upload a file
				if($fileupload==1)
				{
					
					if(isset($_FILES) && $_FILES !='' && count($_FILES) > 0)
					{
						
						foreach($_FILES as $key=>$val)
						{

							if(in_array($key,$table_field) && isset($val['name']) && $val['name'] !='' && isset($val['size']) && $val['size'] > 0)
							{
								
								$path_upload = '';
								if(isset($_REQUEST[$key.'_path']) && $_REQUEST[$key.'_path'] !='')
								{
									$path_upload = trim($_REQUEST[$key.'_path']);
								}
								
								$old_upload = '';
								if(isset($_REQUEST[$key.'_val']) && $_REQUEST[$key.'_val'] !='')
								{
									$old_upload = trim($_REQUEST[$key.'_val']);
								}
								
								$allowed_types ='gif|jpg|png|jpeg|bmp';
								if(isset($_REQUEST[$key.'_ext']) && $_REQUEST[$key.'_ext'] !='')
								{
									$allowed_types = trim($_REQUEST[$key.'_ext']);
								}
								
								$temp_data_array = array('file_name'=>$key,'upload_path'=>$path_upload,'allowed_types'=>$allowed_types);
								$upload_data = $this->upload_file($temp_data_array);
								//print_r($upload_data);
								//exit;
								if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['status']) && $upload_data['status'] =='success')
								{
									$file_data = $upload_data['file_data'];
									$data_array[$key] = $file_data['file_name'];
									$data_file_old_array[] = $path_upload.$old_upload;
									$data_file_new_array[] = $path_upload.$file_data['file_name'];
								}
								else
								{
									$this->delete_file($data_file_new_array);
									$response_data = 'file_upload_error';
									return $response_data;
								}
							}
						}
					}

				}
				// for check file upload
				// for request field and add
				if(isset($_REQUEST) && $_REQUEST !='' && count($_REQUEST) > 0)
				{
					foreach($_REQUEST as $key=>$val)
					{
						if(in_array($key,$table_field) && $key != $primary_key)
						{
							if(is_array($this->security->xss_clean($val)))
							{
							  $val = $this->security->xss_clean($val);
							}
							else
							{
								$val = trim($this->security->xss_clean($val));
							}
							$data_array[$key] = $val;
						}
					}
				}
				// for request field and add
				// for adding custom field in data array
				//print_r($data_array);
				//print_r($data_array_custom);
				if(isset($data_array_custom) && $data_array_custom !='' && count($data_array_custom) > 0)
				{
					foreach($data_array_custom as $key_d=>$val_d)
					{
						if(in_array($key_d,$table_field) && $key_d != $primary_key)
						{
							$data_array[$key_d] = $val_d;
						}
					}
				}
				//print_r($data_array);
				// for adding custom field in data array
				if($data_array !='' && count($data_array) > 0)
				{
					$response = $this->update_insert_data_common($table_name,$data_array,$where_arra,$flag_update,$limit);
					//echo $this->last_query();
					if($response)
					{
						$this->delete_file($data_file_old_array);
						$response_data = 'success';
					}
					else
					{
						$this->delete_file($data_file_new_array);
						$response_data = 'error';
					}
				}
			}
		}
		return $response_data;
	}
	public function upload_file($upload_data = '')
	{
		$return_message = '';
		if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['upload_path']) && $upload_data['upload_path'] !='' && isset($upload_data['file_name']) && $upload_data['file_name'] !='')
		{			
			$config['upload_path']  = $upload_data['upload_path'];
			if(isset($upload_data['allowed_types']) && $upload_data['allowed_types'] !='')
			{
				$config['allowed_types']= $upload_data['allowed_types'];
			}
			$config['max_size']= 2048;
			if(isset($upload_data['max_size']) && $upload_data['max_size'] !='')
			{
				$config['max_size']= $upload_data['max_size'];
			}
			if(isset($upload_data['encrypt_name']) && $upload_data['encrypt_name'] !='')
			{
				$config['encrypt_name']= $upload_data['encrypt_name'];
			}
			else
			{
				$config['encrypt_name'] = TRUE;
			}
			$this->load->library('upload'); //  , $config
			$this->upload->initialize($config);
			
			if(!$this->upload->do_upload($upload_data['file_name']))
			{
				$return_message = array('status'=>'error','error_message'=>$this->upload->display_errors());
				//print_r($return_message);
			}
			else
			{
				$return_message = array('status'=>'success','file_data'=>$this->upload->data());
				//print_r($return_message);
			}
		}
		return $return_message;
	}
	public function delete_file($file_name='')
	{
		if(isset($file_name) && $file_name !='' && is_array($file_name))
		{
			foreach($file_name as $file_name_val)
			{
				if(isset($file_name_val) && $file_name_val !='' && file_exists($file_name_val))
				{
					@unlink($file_name_val);
				}	
			}
		}
		else if(isset($file_name) && $file_name !='' && file_exists($file_name))
		{
			@unlink($file_name);
		}
	}
	public function rander_pagination($url='',$count=0,$set_limit = '')
	{   
		$return_page = '';
		if($set_limit=='')
		{
			$set_limitvar = $this->limit_per_page;
		}
		else
		{
			$set_limitvar = $set_limit;
		}
		if($url !='' && $count !='' && $count > 0)
		{
			$this->load->library('pagination');
			//$config = $this->commmon_model->getconfingValue('config_pag');
			$config['full_tag_open'] = '<ul id="ajax_pagin_ul" class="pagination">';
			$config['cur_tag_open'] = '<li class="active"><a href="#">';
			$config['first_tag_open'] = '<li>';
    		$config['first_tag_close'] = '</li>';
			$config['prev_tag_open'] = '<li >';
   			$config['prev_tag_close'] = '</li>';
			$config['next_tag_open'] = '<li >';
    		$config['next_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li >';
    		$config['last_tag_close'] = '</li>';
			$config['base_url'] = $this->base_url.$url;
			$config['per_page'] = $set_limitvar;
			$config['total_rows'] = $count;
			$this->pagination->initialize($config);
			$return_page = $this->pagination->create_links();
			$return_page ='
			<div class="tp-pagination">'.$return_page.'</div>';
			
		}
		return $return_page;
	}
	
	function getemailtemplate($tempname = '')
	{
		$tempdata = array();
		if($tempname != '')
		{
			$where_arra = array('template_name'=>$tempname,'status'=>'APPROVED','is_deleted'=>'No');
			$tempdata = $this->get_count_data_manual('email_templates',$where_arra,1,'','','','','');
		}
		return $tempdata;
	}
	function getadvertisement($adlevel='Level 1')
	{
		$where_arra = array('level'=>$adlevel,'status'=>'APPROVED','is_deleted'=>'No');
		$addata = $this->get_count_data_manual('advertisement_master',$where_arra,1,'','rand()','','','');
		return $addata;
	}
	function getstringreplaced($actula_content,$array=array())
	{
		$email_template = strtr($actula_content, $array);
		return $email_template;
	}
	
	function get_sms_template($tempname='')
	{
		$tempdata = '';
		if($tempname !='')
		{
			$where_arra = array('template_name'=>$tempname,'status'=>'APPROVED','is_deleted'=>'No');
			$tempdata = $this->get_count_data_manual('sms_templates',$where_arra,1,'','','','','');
		}
		return $tempdata;
	}
	function sms_string_replaced($actula_content,$array=array())
	{
		$sms_template = strtr($actula_content, $array);
		return $sms_template;
	}
	function photo_process($data='')
	{		
		$photo_path = $this->common_model->path_photos;
		$photo_upload_count = $this->common_model->photo_upload_count;
		$column_nam = array();
		for($ip = 1;$ip<=$photo_upload_count;$ip++)
		{
			$column_nam['photo'.$ip] = $photo_path;	
		}
		$profile_photo = $this->common_model->member_photo_disp($data);
		$data = $this->dataimage_fullurl($data,$column_nam,'single');
		
		if($data['photo1'] =='')
		{
			$data['photo1'] = $profile_photo;
		}
		$member_photo = array();
		for($ip = 1;$ip<=$photo_upload_count;$ip++)
		{
			if(isset($data['photo'.$ip]) && $data['photo'.$ip] !='')
			{
				$member_photo[]['photo'] = $data['photo'.$ip];
			}
		}
		$data['member_photo'] = $member_photo;
		return $data;
	}
	function process_data_app($data='')
	{
		$data_arr = array();
		if(isset($data) && $data !='' && count($data))
		{			
			foreach($data as $data_val)
			{
				if(isset($data_val['height']) && $data_val['height'] !='')
				{
					$height = $this->common_model->display_height($data_val['height']);
					$data_val['height'] = $height;
				}
				$data_val['age'] = '';
				if(isset($data_val['birthdate']) && $data_val['birthdate'] !='')
				{
					$age = $this->common_model->birthdate_disp($data_val['birthdate'],0);
					$data_val['age'] = $age;
				}
				$data_val = $this->photo_process($data_val);
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
		return $data;
	}
	function dataimage_fullurl($data='',$column_nam='',$datatype = 'multiple')
	{
		$tempdata = array();
		if($data !='' && $column_nam !='' && count($column_nam) > 0)
		{
			if($datatype!='single')
			{
				foreach($data as $data_val)
				{
					foreach($column_nam as $key=>$val)
					{
						if(isset($data_val[$key]) && $data_val[$key] !='')
						{
							$data_val[$key] = $this->base_url.$val.$data_val[$key];
						}
					}
					$tempdata[] = $data_val;
				}
			}
			else
			{
				foreach($column_nam as $key=>$val)
				{
					if(isset($data[$key]) && $data[$key] !='')
					{
						$data[$key] = $this->base_url.$val.$data[$key];
					}
				}
				$tempdata = $data;
			}
		}
		return $tempdata;
	}
	function checkfieldnotnull($filed='')
	{
		$returnvar = false;	
		if($filed!='' && !is_null($filed))
		{
			$returnvar = true;
		}
		return $returnvar;
	}
	public function get_list($get_list='',$return_opt='json',$currnet_val='',$retun_for = 'str',$selected_val ='',$tocken_val  =0)
	{
		$this->tabel_config = array(
			
			'mothertongue_list'=>array('table_name'=>'mothertongue','pri_key'=>'id','disp_clm'=>'mtongue_name','label'=>'Mother Tongue','rel_clm_name'=>''),
			'religion_list'=>array('table_name'=>'religion','pri_key'=>'id','disp_clm'=>'religion_name','label'=>'Religion','rel_clm_name'=>''),
			'education_list'=>array('table_name'=>'education_detail','pri_key'=>'id','disp_clm'=>'education_name','label'=>'Education','rel_clm_name'=>''),
			'occupation_list'=>array('table_name'=>'occupation','pri_key'=>'id','disp_clm'=>'occupation_name','label'=>'Occupation','rel_clm_name'=>''),
			'designation_list'=>array('table_name'=>'designation','pri_key'=>'id','disp_clm'=>'designation_name','label'=>'Designation','rel_clm_name'=>''),
			'star_list'=>array('table_name'=>'star','pri_key'=>'id','disp_clm'=>'star_name','label'=>'Star','rel_clm_name'=>''),
			'moonsign_list'=>array('table_name'=>'moonsign','pri_key'=>'id','disp_clm'=>'moonsign_name','label'=>'Moonsign','rel_clm_name'=>''),
			'country_code'=>array('table_name'=>'country_master','pri_key'=>'country_code','disp_clm'=>'country_name','label'=>'Country Code','rel_clm_name'=>''),
			'country_list'=>array('table_name'=>'country_master','pri_key'=>'id','disp_clm'=>'country_name','label'=>'Country','rel_clm_name'=>''),
			'state_list'=>array('table_name'=>'state_master','pri_key'=>'id','disp_clm'=>'state_name','rel_clm_name'=>'country_id','label'=>'State'),
			'city_list'=>array('table_name'=>'city_master','pri_key'=>'id','disp_clm'=>'city_name','label'=>'City','rel_clm_name'=>'state_id'),
			'caste_list'=>array('table_name'=>'caste','pri_key'=>'id','disp_clm'=>'caste_name','label'=>'Caste','rel_clm_name'=>'religion_id'),
			'currency_master'=>array('table_name'=>'currency_master','val_clm'=>'currency_code','disp_clm'=>'currency_code','pri_key'=>'id','label'=>'Currency','rel_clm_name'=>''),
		);
		
		$selected_arr = array();
		if($selected_val !='')
		{
			if(!is_array($selected_val))
			{
				$selected_arr[] = explode(',',$selected_val);
				$selected_arr = $selected_arr[0];
			}
			else
			{
				$selected_arr[] = $selected_val;
				$selected_arr = $selected_arr[0];
			}
		}
		
		$opt_array = array();
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] == 'NI-AAPP')
		{
			$opt_array[] = array('id'=>'','val'=>'Select Option');
		}
		else
		{
			$opt_array[] = array('id'=>'0','val'=>'Select Option');
		}
		if($this->input->post('get_list'))
		{
			$get_list = trim($this->input->post('get_list'));
		}
		if($this->input->post('currnet_val'))
		{
			$currnet_val = $this->input->post('currnet_val');
		}
		if($this->input->post('tocken_val'))
		{
			$tocken_val = trim($this->input->post('tocken_val'));
		}
		if($get_list  !='')
		{
			$str_ddr = '';
			if(isset($this->tabel_config[$get_list]) && $this->tabel_config[$get_list] !='' && count($this->tabel_config[$get_list]) > 0)
			{ 
				$tabel_config = $this->tabel_config[$get_list];
				$label_sele = 'Select Option';
				if(isset($tabel_config['label']) && $tabel_config['label'] !='')
				{
					$label_sele = 'Select '.$tabel_config['label'];
				}
				$str_ddr = '<option value="">'.$label_sele.'</option>';	
				
				$elemt_array = array('relation'=>array('rel_table'=>$tabel_config['table_name'],'key_val'=>$tabel_config['pri_key'],'key_disp'=>$tabel_config['disp_clm'],'rel_col_name'=>$tabel_config['rel_clm_name'],'rel_col_val'=>$currnet_val));

				$data_array = $this->common_model->getRelationDropdown($elemt_array);
				$str_ddr = '<option value="">Select '.$tabel_config['label'].'</option>';
			}
			else
			{	
				if($get_list == "height_list")
				{
					$data_array = $this->common_model->height_list();
				}
				else if($get_list == "weight_list")
				{
					$data_array = $this->common_model->weight_list();
				}
				else if($get_list == "age_rang")
				{
					$data_array = $this->common_model->age_rang();
				}
				else
				{
					$data_array = $this->common_model->get_list_ddr($get_list);
				}
			}
			
			
				if(isset($data_array) && $data_array !='' && count($data_array) > 0)
				{
					foreach($data_array as $key=>$val)
					{
						$selected_val_str = '';
						if(isset($selected_arr) &&  count($selected_arr) > 0 && in_array($key,$selected_arr))
						{
							$selected_val_str =' selected ';
						}
						$str_ddr.= '<option '.$selected_val_str.' value="'.$key.'">'.$val.'</option>';
						
						if($tocken_val  == 1)
						{
							$opt_array[] = array('value'=>$val,'lable'=>$val);
						}
						else
						{
							$opt_array[] = array('id'=>$key,'val'=>$val);
						}
					}
				}
		}
		if($retun_for == 'str')
		{
			return $str_ddr;
		}
		else
		{
		    if($tocken_val  == 1)
			{
				array_splice($opt_array, 0, 1);
			}
			return $opt_array;
		}
	}
	public function get_list_multiple($get_list='',$return_opt='json',$currnet_val='',$retun_for = 'str',$selected_val ='',$tocken_val  =0,$singmult  ='single')
	{
		$this->tabel_config= array(
			'caste_list'=>array('table_name'=>'caste','pri_key'=>'id','disp_clm'=>'caste_name','label'=>'Caste','rel_clm_name'=>'religion_id'),
			'state_list'=>array('table_name'=>'state_master','pri_key'=>'id','disp_clm'=>'state_name','label'=>'State','rel_clm_name'=>'country_id'),
			'city_list'=>array('table_name'=>'city_master','pri_key'=>'id','disp_clm'=>'city_name','label'=>'City','rel_clm_name'=>'state_id'),
		);
		$str_ddr = '';
		$opt_array = array();
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] == 'NI-AAPP')
		{
			$opt_array[] = array('id'=>'','val'=>'Select Option');
		}
		else
		{
			$opt_array[] = array('id'=>'0','val'=>'Select Option');
		}
		if($this->input->post('get_list'))
		{
			$get_list = trim($this->input->post('get_list'));
		}
		if($this->input->post('multivar'))
		{
			$singmult = trim($this->input->post('multivar'));
		}
		if($this->input->post('retun_for'))
		{
			$retun_for = trim($this->input->post('retun_for'));
		}		
		if($this->input->post('tocken_val'))
		{
			$tocken_val = trim($this->input->post('tocken_val'));
		}
		if($this->input->post('currnet_val'))
		{
			if($singmult=='multi')
			{
				if($retun_for=='json')
				{
					if($this->input->post('currnet_val') && $this->input->post('currnet_val')!='')
					{
						$currnet_val = explode(',',$this->input->post('currnet_val'));		
					}
					else
					{
						$currnet_val = '';
					}
				}
				else
				{
					$currnet_val = $this->input->post('currnet_val');
				}
				
			}
			else
			{
				$currnet_val = trim($this->input->post('currnet_val'));
			}
		}
		
		if($get_list!='')
		{
			if(isset($this->tabel_config[$get_list]) && $this->tabel_config[$get_list] !='' && count($this->tabel_config[$get_list]) > 0)
			{ 
				$tabel_config = $this->tabel_config[$get_list];
				$label_sele = 'Select Option';
				if(isset($tabel_config['label']) && $tabel_config['label'] !='')
				{
					$label_sele = 'Select '.$tabel_config['label'];
				}
				if($tocken_val==0)
				{
					$str_ddr = '<option value="">'.$label_sele.'</option>';
				}
				$elemt_array = array('relation'=>array('rel_table'=>$tabel_config['table_name'],'key_val'=>$tabel_config['pri_key'],'key_disp'=>$tabel_config['disp_clm'],'rel_col_name'=>$tabel_config['rel_clm_name'],'rel_col_val'=>$currnet_val));
					if($selected_val!='')
					{
						$selected_val_array = explode(",",$selected_val);
					}
					else
					{
						$selected_val_array = array();
					}
					if($singmult=='multi')
					{	
						$data_array = $this->getdropdown_multi_sing($elemt_array);
					}
					else
					{
						$data_array = $this->common_model->getRelationDropdown($elemt_array);
					}
					if($tocken_val==0)
					{
						$str_ddr = '<option value="">Select '.$tabel_config['label'].'</option>';
					}
					else
					{
						$str_ddr = '';
					}
					
					if(isset($data_array) && count($data_array) > 0)
					{
						foreach($data_array as $key=>$val)
						{
							$selected_val_str = '';
							if(isset($selected_val_array) && $selected_val_array!=''  && is_array($selected_val_array) && in_array($key,$selected_val_array))
							{
								$selected_val_str =' selected ';
							}
							
							$str_ddr.= '<option '.$selected_val_str.' value="'.$key.'">'.$val.'</option>';
							if($tocken_val  == 1)
							{
								$opt_array[] = array('value'=>$val,'lable'=>$val);
							}
							else
							{
								$opt_array[] = array('id'=>$key,'val'=>$val);
							}
						}
					}					
			}
		}
		if($retun_for == 'str')
		{
			return $str_ddr;
		}
		else
		{
		    if($tocken_val  == 1)
			{
				array_splice($opt_array, 0, 1);
			}
			return $opt_array;
		}
	}
	function getdropdown_multi_sing($element_array_val)
	{
		$return_arr = '';
		$value_curr = $this->get_value_mult($element_array_val,'value','');
		$relation_arr = $this->get_value_mult($element_array_val,'relation','');
		if(isset($relation_arr) && $relation_arr !='' && count($relation_arr) > 0)
		{
			if(isset($relation_arr['rel_table']) && $relation_arr['rel_table'] !='' && isset($relation_arr['key_val']) && $relation_arr['key_val'] !='' && isset($relation_arr['key_disp']) && $relation_arr['key_disp'] !='' )
			{
				$select_field = $relation_arr['key_disp'].', '.$relation_arr['key_val'];
				
				$where_close = array();
				if($value_curr !='')
				{
					$where_close[] = $relation_arr['key_val']." = '".$value_curr."' ";
				}
				$status_filed = 'status';
				$status_val = 'APPROVED';
				if(isset($relation_arr['status_filed']) && $relation_arr['status_filed'] !='')
				{
					$status_filed = $relation_arr['status_filed'];
				}
				if(isset($relation_arr['status_val']) && $relation_arr['status_val'] !='')
				{
					$status_val = $relation_arr['status_val'];
				}
				if($status_filed !='' && $status_val !='')
				{
					$where_close[] = $status_filed." = '".$status_val."' ";
				}
				if(isset($where_close) && $where_close !='' && count($where_close) > 0 )
				{
					$where_close_str = implode(" OR ",$where_close);
					$this->db->where(" ( $where_close_str ) ");
				}	
				if(isset($relation_arr['rel_col_name']) && $relation_arr['rel_col_name'] !='' && isset($relation_arr['rel_col_val']) && $relation_arr['rel_col_val'] !='' && count($relation_arr['rel_col_val']) > 0)
				{
					//$this->db->where($relation_arr['rel_col_name'],$relation_arr['rel_col_val']);
					$this->db->where_in($relation_arr['rel_col_name'], $relation_arr['rel_col_val']);
					$row_data = $this->get_count_data_manual($relation_arr['rel_table'],"",2,$select_field,$relation_arr['key_disp'].' ASC ',0,'','');
				}
				$return_arr = array();
				if(isset($row_data) && $row_data !='' && count($row_data) > 0)
				{
					foreach($row_data as $row_data_val)
					{
						$return_arr[$row_data_val[$relation_arr['key_val']]] = $row_data_val[$relation_arr['key_disp']];
					}
				}
			}
		}
		return $return_arr;
	}
	
	function get_value_mult($element_array_val,$key='value',$defult='')
	{
		$value_curr = $defult;
		if(isset($element_array_val[$key]) && $element_array_val[$key] !='')
		{
			$value_curr = $element_array_val[$key];
		}
		return $value_curr;
	}
	public function get_country_code($return = '')
	{
		$where_arra = array('status'=>'APPROVED','is_deleted'=>'No',"country_code!=''");		
		$data_arr = $this->get_count_data_manual('country_master',$where_arra,2,'country_code,country_name','','','',"");
		if($return == '')
		{
			return $data_arr;
		}
		else
		{
			$opt_array = array();
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] == 'NI-AAPP')
				{
					$opt_array[] = array('id'=>'','val'=>'Select Option');
				}
				else
				{
					$opt_array[] = array('id'=>'0','val'=>'Select Option');
				}
				foreach($data_arr as $data_arr_val)
				{
					$opt_array[] = array('id'=>$data_arr_val['country_code'],'val'=>$data_arr_val['country_code'].' ('.$data_arr_val['country_name'].')');
				}
			}
			return $opt_array;
		}
	}
	function valueFromId($table_name='',$arry_id='',$clm_value='',$id_clm='id',$return_type = 'str',$delimetor=',')
	{
		$return_arr ='';
		if($table_name !='' && $arry_id !='' && $clm_value !='' && $id_clm !='')
		{
			if(!is_array($arry_id))
			{
				$arry_id = explode($delimetor,$arry_id);
			}
			$this->db->where_in($id_clm,$arry_id);
			$data_arr = $this->get_count_data_manual($table_name,'',2,$clm_value);
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				$temp_arr = array();
				foreach($data_arr as $data_arr_val)
				{
					$temp_arr[] = $data_arr_val[$clm_value];
				}
				if($return_type =='str')
				{
					$return_arr = implode(', ',$temp_arr);
				}
				else
				{
					$return_arr = $temp_arr;
				}
			}
		}
		return $return_arr;
	}
	
	function get_plan_detail($user_id='',$user_type='',$return_filed='')
	{
		$return_data = 'No';
		if($user_id !='' && ($user_type =='job_seeker' || $user_type =='employer'))
		{
			$table_name = 'plan_jobseeker';
			$where_data = array('js_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			if($user_type =='employer')
			{
				$table_name = 'plan_employer';
				$where_data = array('emp_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			}
			$today_date = $this->getCurrentDate('Y-m-d');
			$where_data[] = " expired_on >= '$today_date' ";
			$plan_data = $this->common_model->get_count_data_manual($table_name,$where_data,1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
			{
				if($return_filed !='' && isset($plan_data[$return_filed]) && $plan_data[$return_filed] !='')
				{
					$return_data = $plan_data[$return_filed];
					if($return_data !='Yes' && $return_data !='No')
					{
						if($plan_data[$return_filed] > $plan_data[$return_filed.'_used'])
						{
							$return_data = 'Yes';
						}
					}
					$plan_data[$return_filed];
				}
				else
				{
					$return_data = $plan_data;
				}
			}
		}
		return $return_data;
	}
	function update_plan_detail($user_id='',$user_type='',$return_filed='')
	{
		if($user_id !='' && ($user_type =='job_seeker' || $user_type =='employer'))
		{
			$table_name = 'plan_jobseeker';
			$where_data = array('js_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			if($user_type =='employer')
			{
				$table_name = 'plan_employer';
				$where_data = array('emp_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			}
			$column_updated = $return_filed.'_used';
			$data_array = array('is_deleted'=>'No');
			$this->db->set($column_updated , " $column_updated + 1", FALSE);
			$this->update_insert_data_common($table_name,$data_array,$where_data,1,1);
		}
	}
	function check_for_plan_update($user_id='',$user_type='',$empid_jsid='',$resumetype='')
	{
		$update_on = $this->common_model->getCurrentDate();
		if($user_id !='' && ($user_type =='job_seeker' || $user_type =='employer') && $empid_jsid!='')
		{
			if($user_type =='job_seeker')
			{
				$where_arra_contact = array('js_id'=>$user_id,'employer_id'=>$empid_jsid);
				$get_count_contact = $this->common_model->get_count_data_manual('jobseeker_viewed_employer_contact',$where_arra_contact,0,'id','','','','');
				if($get_count_contact=='' || $get_count_contact=='0')
				{
					/* for updating plan details*/
					$this->common_front_model->update_plan_detail($user_id,'job_seeker','contacts');
					/* for updating plan details end */
					/* for inserting that this company details is viewed */
					$data_insert_contact = array('last_viewed_on'=>$update_on,'js_id'=>$user_id,'employer_id'=>$empid_jsid);
					$this->common_model->update_insert_data_common('jobseeker_viewed_employer_contact',$data_insert_contact,'',0);
					/* for inserting that this job is viewed end */
				}
				else
				{ 
					/* for updating that this company details is already viewed */
					$data_update_contact = array('last_viewed_on'=>$update_on);
					$this->common_model->update_insert_data_common('jobseeker_viewed_employer_contact',$data_update_contact,$where_arra_contact);
					/* for updating that this company details is already viewed end */
				}
			}
			elseif($user_type =='employer')
			{
				$where_arra_contact = array('emp_id'=>$user_id,'jobseeker_id'=>$empid_jsid);
				if($resumetype=='resume')
				{
					$get_count_contact = $this->common_model->get_count_data_manual('employer_down_js_resume',$where_arra_contact,0,'id','','','','');	
				}
				else
				{
					$get_count_contact = $this->common_model->get_count_data_manual('employer_viewed_js_contact',$where_arra_contact,0,'id','','','','');
				}
				
				if($get_count_contact=='' || $get_count_contact=='0')
				{ 
					/* for updating plan details*/
					if($resumetype=='resume')
					{
						$this->common_front_model->update_plan_detail($user_id,'employer','cv_access_limit');	
					}
					else
					{
						$this->common_front_model->update_plan_detail($user_id,'employer','contacts');
					}
					/* for updating plan details end */
					/* for inserting that this company details is viewed */
					if($resumetype=='resume')
					{
						$data_insert_contact = array('last_dwn_on'=>$update_on,'emp_id'=>$user_id,'jobseeker_id'=>$empid_jsid);
						$this->common_front_model->update_insert_data_common('employer_down_js_resume',$data_insert_contact,'',0);
					}
					else
					{
						$data_insert_contact = array('last_viewed_on'=>$update_on,'emp_id'=>$user_id,'jobseeker_id'=>$empid_jsid);
						$this->common_model->update_insert_data_common('employer_viewed_js_contact',$data_insert_contact,'',0);
					}
					
					/* for inserting that this job is viewed end */
				}
				else
				{ 
					/* for updating that this company details is already viewed */
					if($resumetype=='resume')
					{
						$data_update_contact = array('last_dwn_on'=>$update_on);
						$this->common_model->update_insert_data_common('employer_down_js_resume',$data_update_contact,$where_arra_contact);
					}
					else
					{
						$data_update_contact = array('last_viewed_on'=>$update_on);
						$this->common_model->update_insert_data_common('employer_viewed_js_contact',$data_update_contact,$where_arra_contact);
					}
					
					/* for updating that this company details is already viewed end */
				}
			}
		}
	}
	

	public function get_suggestion_list($search_get,$get_list_get='')
	{
		$search = $this->input->post('q');
		$list_id = $this->input->post('list_id');
		if($list_id !='')
		{
			$get_list_get = $list_id;				
		}
		if($get_list_get =='member_list_sms' || $get_list_get =='member_list_email')
		{
			$where = " (email like '%$search%' or username like '%$search%' or mobile like '%$search%' or matri_id like '%$search%' )";
			$other_arr = $this->common_model->add_own_where(array(),'','send_mail');
			if(isset($other_arr['personal_where']) && $other_arr['personal_where'] !='')
			{
				$where.= " and ".$other_arr['personal_where'];
			}
			$tbl_name = 'register';
			$select = 'id,email,mobile,username,matri_id';
			$display_field = 'username';
			$where_arra = array('is_deleted'=>'No',$where);
			$return = 'mobile';
			if($get_list_get =='member_list_email')
			{
				$return = 'email';
				$this->db->group_by('email');
			}
			else
			{
				$this->db->group_by('mobile');
			}
			$data_arr = $this->common_model->get_count_data_manual($tbl_name,$where_arra,2,$select,'','1',25,"");
			$opt_array['results'] = array();
			$tocken_array = array();
			$app_array = array();
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
			{
				foreach($data_arr as $data_arr_val)
				{
					$forpushingarray = array("id"=>$data_arr_val[$return],"text"=>$data_arr_val['username'].'  ('.$data_arr_val[$return].') ['.$data_arr_val['matri_id'].']');
					array_push($opt_array['results'],$forpushingarray);					
				}
			}
		}
		return $opt_array;
	}
	
	/* common form generate front end*/
	function generate_dropdown($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->common_model->get_value($element_array_val,'value','');
			$label = $this->common_model->get_label($element_array_val,$key);
			$is_required = $this->common_model->is_required($element_array_val);
			$class = $this->common_model->get_value($element_array_val,'class');
			$is_multiple = $this->common_model->get_value($element_array_val,'is_multiple');//
			
			$is_multi = '';
			$is_multi_par = '';
			$current_selected_arra = array();
			if($is_multiple !='' && $is_multiple == 'yes')
			{
				$is_multi ='multiple';
				$is_multi_par = '[]';
				if($value_curr !='')
				{
					$current_selected_arra = explode(',',$value_curr);
				}
			}
			else if($value_curr !='')
			{
				$current_selected_arra[] = $value_curr;
			}
			$current_selected_arra = array_map('trim', $current_selected_arra);
			
			$form_group_class = $this->common_model->get_value($element_array_val,'form_group_class');
			$onChange = $this->common_model->get_value($element_array_val,'onchange','');
			$display_placeholder = $this->common_model->get_value($element_array_val,'display_placeholder','Yes');
			$extra_style = $this->common_model->get_value($element_array_val,'extra_style','');
			$extra = $this->common_model->get_value($element_array_val,'extra','');
			if($onChange !='')
			{
				$onChange = 'onChange="'.$onChange.'"';
			}
			$value_arr = $this->common_model->get_value($element_array_val,'value_arr','');
			if(!isset($value_arr) || $value_arr =='' || count($value_arr) ==0)
			{
				$value_arr = $this->common_model->getRelationDropdown($element_array_val);
			}
			$req_star = ' :';
			if(trim($is_required) =='required')
			{
				$req_star = ' <span class="font-red">* </span>:';
			}
			$mul_hidden_fild = '';
			if($is_multi_par !='')
			{
				$mul_hidden_fild = '<input type="hidden" name="'.$key.'" value="" />';
			}
			$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.''.$mul_hidden_fild.'
				  	<select '.$is_multi.' '.$onChange.' '.$is_required.' name="'.$key.$is_multi_par.'" id="'.$key.'" class="form-control '.$class.' " style="'.$extra_style.'" '.$extra.' >';
						if($display_placeholder =='Yes')
						{
							$return_content.='<option selected value="" >Select '.$label.'</option>';
						}
				  		
					if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
					{
						foreach($value_arr as $key_r=>$value_arr_val)
						{
							$selected_drop = '';
							if(in_array($key_r,$current_selected_arra))
							{
								$selected_drop = 'selected';
							}
							$return_content.='<option '.$selected_drop.' value="'.$key_r.'">'.$value_arr_val.'</option>';
						}
					}
			$return_content.='</select>'.$this->last_tag;
		}
		return $return_content;
	}
	function generate_radio($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->common_model->get_value($element_array_val,'value','APPROVED');
			$label = $this->common_model->get_label($element_array_val,$key);
			$is_required = $this->common_model->is_required($element_array_val);
			$class = $this->common_model->get_value($element_array_val,'class');
			$class_con_val = $this->common_model->get_value($element_array_val,'class_con_val');
			$value_arr = $this->common_model->get_value($element_array_val,'value_arr');
			$form_group_class = $this->common_model->get_value($element_array_val,'form_group_class');
			$onclick = $this->common_model->get_value($element_array_val,'onclick');
			$extra = $this->common_model->get_value($element_array_val,'extra','');
			if($onclick !='')
			{
				$onclick =' onclick= "'.$onclick.'" ';
			}
			$req_star = ' :';
			if(trim($is_required) =='required')
			{
				$req_star = ' <span class="font-red">* </span>:';
			}
			$return_content.=$this->first_tag.$label.$req_star.$this->after_tag;
			if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
			{
				foreach($value_arr as $key_r=>$value_arr_val)
				{
					$selected_radio = '';
					$class_d = $class;
					if($class_con_val !='')
					{
						$class_d.= ' '.$class_con_val.'_'.$key_r;
					}
					if($value_curr == $key_r)
					{
						$selected_radio = 'checked';
					}
					$return_content.='<label class="font-13-normal"><input '.$extra.' '.$onclick.' '.$selected_radio.' class="'.$class_d.'" type="radio" name="'.$key.'" id="'.$key_r.'" value="'.$key_r.'">&nbsp;&nbsp;'.$value_arr_val.'</label>&nbsp;&nbsp;';
				}
			}
			$return_content.=$this->last_tag;
		}
		return $return_content;
	}
	function generate_password($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = '';
			$label = $this->common_model->get_label($element_array_val,$key);
			$is_required = $this->common_model->is_required($element_array_val);
			$other = $this->common_model->get_value($element_array_val,'other');
			$class = $this->common_model->get_value($element_array_val,'class');
			$form_group_class = $this->common_model->get_value($element_array_val,'form_group_class');
			$minlength = $this->common_model->get_value($element_array_val,'minlength',3);
			if($this->mode =='add')
			{
				$place_holder_pass = 'Password';
			}
			else
			{
				$place_holder_pass = 'Please leave password blank for not update';
				$is_required = '';
			}
			$req_star = ' :';
			if(trim($is_required) =='required')
			{
				$req_star = ' <span class="font-red">* </span>:';
			}
			$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.'
				<input '.$other.' minlength="'.$minlength.'" type="password" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$place_holder_pass.'" value ="" />'.$this->last_tag;
		}
		return $return_content;
	}
	function generate_textbox($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->common_model->get_value($element_array_val);
			if(isset($element_array_val['value_imp']) && $element_array_val['value_imp'] !='')
			{
				$value_curr = $element_array_val['value_imp'];
			}
			$label = $this->common_model->get_label($element_array_val,$key);
			$is_required = $this->common_model->is_required($element_array_val);
			$input_type = $this->common_model->get_value($element_array_val,'input_type','text');
			$other = $this->common_model->get_value($element_array_val,'other');
			$class = $this->common_model->get_value($element_array_val,'class');
			$form_group_class = $this->common_model->get_value($element_array_val,'form_group_class');
			$placeholder = $this->common_model->get_value($element_array_val,'placeholder',$label);
			$check_duplicate = $this->common_model->get_value($element_array_val,'check_duplicate','No');
			$onchange_textbox = '';
			if($check_duplicate == 'Yes')
			{
				$table_name = $this->common_model->table_name;
				$onchange_textbox = "check_duplicate('$key','$table_name')";
				$onchange_textbox = 'onBlur="'.$onchange_textbox.'"';
			}
			$req_star = ' :';
			if(trim($is_required) =='required')
			{
				$req_star = ' <span class="font-red">* </span>:';
			}
			$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.'
				<input '.$other.' type="'.$input_type.'" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " '.$onchange_textbox.' placeholder="'.$placeholder.'" value ="'.htmlentities(stripcslashes($value_curr)).'" />'.$this->last_tag;
			
		}
		return $return_content;
	}
	function generate_textarea($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->common_model->get_value($element_array_val);
			$label = $this->common_model->get_label($element_array_val,$key);
			$is_required = $this->common_model->is_required($element_array_val);
			$class = $this->common_model->get_value($element_array_val,'class');
			$form_group_class = $this->common_model->get_value($element_array_val,'form_group_class');
			$placeholder = $this->common_model->get_value($element_array_val,'placeholder',$label);
			$req_star = ' :';
			if(trim($is_required) =='required')
			{
				$req_star = ' <span class="font-red">* </span>:';
			}
			$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.'
				  	<textarea '.$is_required.' rows="4" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$placeholder.'">'.$value_curr.'</textarea>'.$this->last_tag;
		}
		return $return_content;
	}
	public function generate_common_front_form($element_array = '',$other_config='')
	{
		$this->set_div_tag($other_config['page_type']);
		$return_content='';
		if(isset($this->edit_row_data) && $this->edit_row_data !='')
		{
			$row_data = $this->edit_row_data;
		}
		if(isset($element_array) && $element_array !='' && count($element_array) > 0)
		{
			foreach($element_array as $key=>$element_array_val)
			{
				if(isset($row_data[$key]) && $row_data[$key] !='')
				{
					$element_array_val['value'] = $row_data[$key];
				}
				
				if(isset($element_array_val['type']) && $element_array_val['type'] =='password')
				{
					$return_content.=$this->generate_password($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='textarea')
				{
					$return_content.=$this->generate_textarea($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='radio')
				{
					$return_content.=$this->generate_radio($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='dropdown')
				{
					$return_content.=$this->generate_dropdown($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='manual')
				{
					$return_content.=$element_array_val['code'];
				}
				else
				{
					$return_content.=$this->generate_textbox($element_array_val,$key);
				}
			}
		}
		return $return_content;
	}
	/* common form generate front end*/
	/* for display detail veiw from array */
	public function view_detail_common($element_array='',$data_array ='')
	{
		$dna = $this->common_model->data_not_availabel;
		$return_content = '<ul class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero proDetailHover">';
		if(isset($element_array) && $element_array !='' && count($element_array)>0 && $data_array !='')
		{
			foreach($element_array as $key => $field_array_val)
			{

				$is_single = $this->common_model->get_value($field_array_val,'is_single','');
				$label = $this->common_model->get_label($field_array_val,$key);
				$val_disp = '';
				if(isset($data_array[$key]) && $data_array[$key] !='')
				{
					$val_disp = $data_array[$key];
				}
				if($is_single == 'yes')
				{
					if($val_disp =='')
					{
						$val_disp = $dna;
					}
					$return_content.= '<li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
						<div  class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 text-darkgrey">
							'.$val_disp.'
						</div>
					</li>';
				}
				else
				{
					$pre_filed = $this->common_model->get_value($field_array_val,'pre_filed','');
					$post_filed = $this->common_model->get_value($field_array_val,'post_filed','');
					$call_back_fun = $this->common_model->get_value($field_array_val,'call_back','');
					$type = $this->common_model->get_value($field_array_val,'type','');
					if($call_back_fun !='')
					{
						$val_disp = $this->common_model->$call_back_fun($val_disp);
					}
					$final_var_disp = '';
					if(isset($val_disp) && $val_disp !='')
					{
						if($type =='date')
						{
							$format = $this->common_model->get_value($field_array_val,'format','');
							$final_var_disp = $this->common_model->displayDate($val_disp,$format);
						}
						else if($type =='link')
						{
							$final_var_disp = '<a style="'.$inline_style.'" class="'.$class.'" target="_blank" href="'.$val_disp.'">'.$val_disp.'</a>';
						}
						else if($type =='relation')
						{
							$table_name_dis = $this->common_model->get_value($field_array_val,'table_name','');
							$prim_id = $this->common_model->get_value($field_array_val,'prim_id','id');
							$disp_column_name = $this->common_model->get_value($field_array_val,'disp_column_name','');
							if($table_name_dis !='')
							{
								$data_disp_temp = $this->common_model->valueFromId($table_name_dis,$val_disp,$disp_column_name,$prim_id);
								if($data_disp_temp !='')
								{
									$final_var_disp = $data_disp_temp;
								}
								else
								{
									$final_var_disp = $dna;
								}
							}
							else
							{
								$final_var_disp = $dna;
							}
						}
						else if($pre_filed !='')
						{
							$final_var_disp = $this->common_model->get_value($data_array,$pre_filed,'').' ';
							$final_var_disp.= $val_disp;
						}
						else if($post_filed !='')
						{
							$final_var_disp = $val_disp.' ';
							$post_filed_val = $this->common_model->get_value($field_array_val,'post_filed_val','');
							
							$post_filed_call_back = $this->common_model->get_value($field_array_val,'post_filed_call_back','');
							$final_var_disp.= $post_filed_concate = $this->common_model->get_value($field_array_val,'post_filed_concate','');
							if($post_filed_val !='')
							{
								$final_var_disp.= $post_filed_val;
							}
							else
							{
								$post_fild_val = $this->common_model->get_value($data_array,$post_filed,'');
								$post_filed_call_back = $this->common_model->get_value($field_array_val,'post_filed_call_back','');
								if($post_filed_call_back !='' && $post_fild_val !='')
								{
									$post_fild_val = $this->common_model->$post_filed_call_back($post_fild_val);
								}
								$final_var_disp.= $post_fild_val;
								$final_var_disp.= $this->common_model->get_value($field_array_val,'post_filed_val_after','');
							}
						}
						else									
						{
							$final_var_disp.= $val_disp;
						}
					}
					else
					{
						$final_var_disp.= $dna;
					}
					$return_content.= '<li class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
						<div  class="xxl-16 xl-16 l-16 m-16 s-16 xs-16 padding-lr-zero">
							<div class="xxl-6 xl-6 l-6 m-6 s-6 xs-6 label-title margin-top-5-xs">
								'.$label.'
							</div>
							<div class="xxl-10 xl-10 l-10 m-10 s-10 xs-10">
								<span class="dot-padding">:</span> '.$final_var_disp.'
							</div>
						</div>
					</li>';
				}
			}
		}
		$return_content.= '</ul>';
		return $return_content;
	}
	/* for display detail veiw from array */
	public function set_orgin()
	{
		 header('Access-Control-Allow-Origin: *');
	     header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		 if (isset($_SERVER['HTTP_ORIGIN']))
		 {
			//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
			header('Access-Control-Allow-Origin: *');
			header('Access-Control-Allow-Credentials: true');
			header('Access-Control-Max-Age: 86400');
		 }
     // Access-Control headers are received during OPTIONS requests
 	   	 if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
		 {
        	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");         
 
        	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        	exit(0);
	     }
		//$this->output->set_header('Access-Control-Allow-Origin: *');
	}
	public function get_user_id($return_session ='id',$app_return='member_id')
	{
		$member_id='';
		if(isset($_REQUEST['user_agent']) && $_REQUEST['user_agent'] =='NI-AAPP')
		{
			if(isset($_REQUEST[$app_return]) && $_REQUEST[$app_return] !='')
			{
				$member_id = $_REQUEST[$app_return];
			}
		}
		else
		{
			$member_id = $this->common_front_model->get_session_data($return_session);
		}
		return $member_id;
	}
	public function return_jsone_response($status='',$data='',$message='',$message_name='errmessage')
	{
		$data1 = array();
		$data1['token'] = $this->security->get_csrf_hash();
		$data1['tocken'] = $this->security->get_csrf_hash();
		if($message !='')
		{
			$data1[$message_name] =  $message;
		}
		if($status !='')
		{
			$data1['status'] = $status;
		}
		if($data !='')
		{
			$data1['data'] = $data;
		}
		else{
			$data1['data'] = "No data available";
		}
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function set_member_profile_join_data($data = array())
	{
		if($data !='' && count($data) > 0)
		{
			$reset_opt_arrya = array(
				'part_occupation'=>array('table'=>'occupation','key_disp'=>'occupation_name'),
				'part_designation'=>array('table'=>'designation','key_disp'=>'designation_name'),
				'part_star'=>array('table'=>'star','key_disp'=>'star_name'),
				'star'=>array('table'=>'star','key_disp'=>'star_name'),
				'moonsign'=>array('table'=>'moonsign','key_disp'=>'moonsign_name'),
				'part_mother_tongue'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name'),
				'languages_known'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name'),
				'part_religion'=>array('table'=>'religion','key_disp'=>'religion_name'),
				'part_caste'=>array('table'=>'caste','key_disp'=>'caste_name'),
				'part_education'=>array('table'=>'education_detail','key_disp'=>'education_name'),
				'part_country_living'=>array('table'=>'country_master','key_disp'=>'country_name'),
				'part_state'=>array('table'=>'state_master','key_disp'=>'state_name'),
				'part_city'=>array('table'=>'city_master','key_disp'=>'city_name'),
				'part_city'=>array('table'=>'city_master','key_disp'=>'city_name'),
			);
			if($reset_opt_arrya !='' && count($reset_opt_arrya) > 0)
			{
				foreach($reset_opt_arrya as $key=>$val)
				{
					if($key !='' && isset($data[$key]) && $data[$key] !='')
					{
						$data[$key.'_str'] = $this->common_model->valueFromId($val['table'],$data[$key],$val['key_disp']);
					}
				}
			}
		}
		return $data;
	}
	public function copy_photo_big($photo_array= array())
	{
		$path_photos = $this->common_model->path_photos;
		$path_photos_big = $this->common_model->path_photos_big;
		if(isset($photo_array) && $photo_array !='' && count($photo_array) > 0 )
		{
			foreach($photo_array as $key=>$val)
			{
				if($val !='' && file_exists($path_photos.$val))
				{
					copy($path_photos.$val,$path_photos_big.$val);
				}
			}
		}
	}
	public function field_percentage_array()
	{
		$field_and_per = array(
		 // Basic Details as 15% value
		'description'=>'1',
		'profileby'=>'1',
		'firstname'=>'1',
		'lastname'=>'1',
		'email'=>'4',
		'marital_status'=>'1',
		'mother_tongue'=>'1',
		'reference'=>'1',
		'birthdate'=>'1',
		'diet'=>'1',
		'smoke'=>'1',
		'drink'=>'1',
		
		 //Social Religion Attributes as 10% value
		'religion'=>'2',
		'caste'=>'2',
		'subcaste'=>'1',
		'gothra'=>'1',
		'star'=>'1',
		'moonsing'=>'1',
		'horoscope'=>'1',
		'manglik'=>'1',
		
		//Physical attributes as 5% value
		'height'=>'1',
		'weight'=>'1',
		'blood_group'=>'1',
		'complexion'=>'1',
		'bodytype'=>'1',
		
		//Education Details as 10% values
		'education_detail'=>'2',
		'income'=>'2',
		'occupation'=>'2',
		'employee_in'=>'2',
		'designation'=>'2',
		
		//Contact Details as 16% value
		'address'=>'4',
		'country_id'=>'2',
		'state_id'=>'2',
		'city_id'=>'2',
		'mobile'=>'2',
		'phone'=>'2',
		'time_to_call'=>'2',
		
		// horoscope_photo ,cover_photo, Photo 1 to 6 as 14%  value 
		'horoscope_photo'=>'2',
		'cover_photo'=>'2',
		'photo1'=>'5',
		'photo2'=>'1',
		'photo3'=>'1',
		'photo4'=>'1',
		'photo5'=>'1',
		'photo6'=>'1',
		
		 // Hobby and Profile Text as 5% value
		'profile_text'=>'3',
		'hobby'=>'2',
		
		// Family Details as 10% value
		'family_details'=>'2',
		'family_type'=>'1',
		'family_status'=>'1',
		'father_name'=>'1',
		'mother_name'=>'1',
		'no_of_brothers'=>'1',
		'no_of_sisters'=>'1',
		'no_of_married_brother'=>'1',
		'no_of_married_sister'=>'1',
		
		 //Partner Preference as 15% value
		 'looking_for'=>'1',
		 'part_frm_age'=>'1',
		 'part_to_age'=>'1',
		 'part_expect'=>'1',
		 'part_height'=>'1',
		 'part_height_to'=>'1',
		 'part_complexion'=>'1',
		 'part_mother_tongue'=>'1',
		 'part_religion'=>'1',
		 'part_caste'=>'1',
		 'part_education'=>'1',
		 'part_country_living'=>'1',
		 'part_state'=>'1',
		 'part_city'=>'1',
		 'part_resi_status'=>'1',
		); 
		return $field_and_per;
	}
	public function getprofile_completeness($id='')
	{
		$returnvar = 0;
		$tstvar = 0;
		$field_and_per = $this->common_front_model->field_percentage_array(); 
		
		if($id!='')
		{	
			$where_arra = array('id'=>$id);
			$login_user_count = $this->common_front_model->get_count_data_manual('register',$where_arra,0,'id');
			//return $login_user_count;
			//return $login_user_details;
			if($login_user_count > 0)
			{
				$login_user_details = $this->common_front_model->get_login_user_data($id);
				foreach($login_user_details as $single_field=>$single_value)
				{
					if (array_key_exists($single_field,$field_and_per))
					{
						if(isset($login_user_details[$single_field]) && $login_user_details[$single_field]!='' && !is_null($login_user_details[$single_field]) && $login_user_details[$single_field]!='0')
						{
							$returnvar = $returnvar + $field_and_per[$single_field];	
							unset($field_and_per[$single_field]);
						}
					}
				}
			}
		}
		if($returnvar > 100)
		{
			return 100;
		}
		else
		{
			return $returnvar;
		}
	}
}