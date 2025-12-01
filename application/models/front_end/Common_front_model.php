<?php defined('BASEPATH') OR exit('No direct script access allowed');
#[\AllowDynamicProperties]
class Common_front_model extends CI_Model {
	public $data = array();
	public function load_message_model()
	{
		$this->load->model('front_end/message_model');
		return $this->message_model;
	}
	public function __construct()
	{
		parent::__construct();
		
		$this->data['base_url'] = $this->base_url = base_url();
		$this->data['config_data'] = $this->get_site_config();
		$this->data['custom_lable'] = $this->lang;
		$this->limit_per_page = 2;
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
	public function set_div_tag($page_type = 'register')
	{
		if($page_type =='register')
		{
			// $this->first_tag ='<div class="xxl-16 xl-16 xs-16 s-16 m-16 l-16 margin-top-20px"><div class="row"><div class="xxl-5 xl-5 xs-16 s-16 m-16 l-4 margin-top-5px"><label>';
			// $this->after_tag ='</label></div><div class="clearfix visible-xs"></div><div class="xxl-11 xl-11 xs-16 s-16 m-16 l-8">';
			// $this->last_tag ='</div></div></div>';
			$this->first_tag ='<div class="col-md-6 col-sm-6 col-xs-12"><label class="Poppins-Regular f-16 color-31">';
			$this->after_tag ='</label>';
			$this->last_tag ='</div>';
		}
		else if($page_type =='register_multiple')
		{
			// $this->first_tag ='<div class="xxl-16 xl-16 xs-16 s-16 m-16 l-16 margin-top-20px"><div class="row"><div class="xxl-5 xl-5 xs-16 s-16 m-16 l-4 margin-top-5px"><label>';
			// $this->after_tag ='</label></div><div class="clearfix visible-xs"></div><div class="xxl-11 xl-11 xs-16 s-16 m-16 l-8">';
			// $this->last_tag ='</div></div></div>';
			$this->first_tag ='<div class="col-md-6 col-sm-6 col-xs-12 select_box5 select_box5-top-69"><label class="Poppins-Regular f-16 color-31">';
			$this->after_tag ='</label>';
			$this->last_tag ='</div>';
		}
		elseif($page_type =='my_edit_profile')
		{
			$this->first_tag ='<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><label class="Poppins-Regular f-16 color-31">';
			$this->after_tag ='</label>';
			$this->last_tag ='</div>';
		}
		else if($page_type =='my_edit_profile_multiple')
		{
			$this->first_tag ='<div class="col-md-6 col-sm-6 col-xs-12 mt-3"><label class="Poppins-Regular f-16 color-31">';
			$this->after_tag ='</label>';
			$this->last_tag ='</div>';
		}
		else if($page_type =='edit_profile_multiple')
		{
			$this->first_tag ='<div class="col-md-4 col-sx-12 col-sm-4 select_box5 select_box5-top-69">
			<h5 class="color-profile Poppins-Regular">';
			$this->after_tag ='</h5>';
			$this->last_tag ='</div>';
		}
		else if($page_type =='edit_profile')
		{
			$this->first_tag ='<div class="col-md-4 col-sx-12 col-sm-4">
			<h5 class="color-profile Poppins-Regular">';
			$this->after_tag ='</h5>';
			$this->last_tag ='</div>';
		}
		else if($page_type =='search')
		{
			$this->first_tag ='<div class="form-group xxl-16 xl-16 l-16 m-16 s-16 xs-16  padding-lr-zero-320 padding-lr-zero-480 padding-bottom-10px padding-lr-zero-xs"><div class="xxl-4 xs-16 s-16 m-4 l-4 xl-4 margin-top-5px src-label">';
			$this->after_tag ='</div><div class="xxl-12 xl-12 xs-16 s-16 m-12 l-12 margin-top-5px-320 margin-top-5px-480">';
			$this->last_tag ='</div></div>';
		}
		else if($page_type =='matches')
		{
			$this->first_tag ='<div class="row add-b-cstm mt-4"><div class="col-md-4 col-sm-4 col-xs-12"><p class="Poppins-Medium f-16 color-31 ad-name">';
			$this->after_tag ='</p></div><div class="col-md-8 col-sm-8 col-xs-12"><div class="add-input">';
			$this->last_tag ='</div></div></div>';
		}
	}
	public function already_login_redirect($is_post=1)
	{
		$user_id = $this->get_user_id();
		if($user_id !='')
		{
			if(isset($is_post) && $is_post=='0')
			{
				$data['status'] = 'al_ready_login';
				return $data;
			}
			else
			{
				redirect($this->base_url.'my-dashboard');
			}
			
		}
	}
	public function last_member_activity()
	{
		$member_id = $this->common_front_model->get_user_id();
		if(isset($member_id) && $member_id!='')
		{
			$where_arrra = "index_id = '$member_id'" ;
			$check_login = $this->common_front_model->get_count_data_manual('member_activity',$where_arrra,0,'*','','',1);
			if(isset($check_login) && $check_login!='')
			{
				$login_dt = $this->common_model->getCurrentDate();
				$data_array2 = array('date_time'=>$login_dt);
				$row_data2 = $this->common_model->update_insert_data_common('member_activity', $data_array2,$where_arrra,1);
			}
			else
			{
				$login_status = '1';
				$where_arra = array('id'=>$member_id);
				$data_array = array('logged_in'=>$login_status);
				$row_data1 = $this->common_model->update_insert_data_common('register', $data_array, $where_arra);
				$login_dt = $this->common_model->getCurrentDate();
				$data_array2 = array('index_id'=>$member_id,'date_time'=>$login_dt);
				$row_data2 = $this->common_model->update_insert_data_common('member_activity', $data_array2,'',0);
			}
		}
	}
	// public function check_member_activity()
	// {
	// 	$member_id = $this->common_front_model->get_user_id();
	// 	$where_arrra = "index_id = '$member_id'" ;
	// 	$check_login = $this->common_front_model->get_count_data_manual('member_activity',$where_arrra,0,'*','','',1);
	// 	if(isset($check_login) && $check_login!='')
	// 	{
	// 		$data['logged_in_user_id'] = $check_login;		
	// 	}
	// 	else
	// 	{
	// 		$data['logged_in_user_id'] = 0;
	// 	}
	// 	return $data;
	// }
	public function checkLogin($type='redirect')
	{
		// need to work for ajax request and login issue
		if(isset($_REQUEST['user_agent']) && ($_REQUEST['user_agent'] =='NI-AAPP' || $_REQUEST['user_agent'] =='NI-IAPP'))
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
				
				$mega_user_data = $this->session->userdata('mega_user_data');
				if(isset($mega_user_data['id']) && $mega_user_data['id'] !='')
				{
					$where = array('id'=>$mega_user_data['id']);
					$login_data = $this->common_model->get_count_data_manual("register",$where,1,'','','',1);
	
					if(isset($login_data) && (isset($login_data['is_deleted']) && $login_data['is_deleted'] == 'Yes') || (isset($login_data['status']) && $login_data['status'] != 'APPROVED'))
					{
						$this->session->unset_userdata('mega_user_data');
						$base_url = base_url();
						redirect($base_url.'login');
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
		$email_template = $actula_content;
		if($array!='' && count($array) > 0)
		{
			$email_template = strtr($actula_content, $array);
		}
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
		
		if(isset($data['photo1']) && $data['photo1'] =='')
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
	function process_data_app_image_use($data='')
	{
		$data_arr = array();
		if(isset($data) && $data !='' && count($data)>0)
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
				if(isset($data_val['birthdate']) && $data_val['birthdate']!='')
				{
					$date = $data_val['birthdate'];
					$data_val['birthdate'] = date("d-m-Y", strtotime($date));
				}
				if((isset($data_val['age']) && $data_val['age']!='') || (isset($data_val['height']) && $data_val['height']!='') || (isset($data_val['caste_name']) && $data_val['caste_name']!='') || (isset($data_val['religion_name']) && $data_val['religion_name']!='') || (isset($data_val['city_name']) && $data_val['city_name']!='') || (isset($data_val['country_name']) && $data_val['country_name']!='') || (isset($data_val['education_name']) && $data_val['education_name']!='') || (isset($data_val['profileby']) && $data_val['profileby']!=''))
				{
					$data_val['profile_description'] = (isset($data_val['age']) && $data_val['age'] !='')?$data_val['age']:'';
					$data_val['profile_description'].= (isset($data_val['height']) && $data_val['height'] !='')?','.$data_val['height']:'';
					$data_val['profile_description'].= (isset($data_val['caste_name']) && $data_val['caste_name'] !='')?','.$data_val['caste_name']:'';
					$data_val['profile_description'].= ((isset($data_val['religion_name']) && $data_val['religion_name'] !='') || (isset($data_val['religion_name']) && $data_val['caste_name'] !=''))?'-':',';
					$data_val['profile_description'].= (isset($data_val['religion_name']) && $data_val['religion_name'] !='')?$data_val['religion_name'].',':'';
					$data_val['profile_description'].= (isset($data_val['city_name']) && $data_val['city_name'] !='')?','.$data_val['city_name']:'';
					$data_val['profile_description'].= (isset($data_val['country_name']) && $data_val['country_name'] !='')?','.$data_val['country_name']:'';
					$data_val['profile_description'].= (isset($data_val['education_name']) && $data_val['education_name'] !='')?','.$data_val['education_name']:'';
					$data_val['profile_description'].= (isset($data_val['profileby']) && $data_val['profileby'] !='')?',Profile Created By '.$data_val['profileby']:'';
				}
				
				if($this->input->post('matri_id'))
				{
					$matri_id = $this->input->post('matri_id');
				}
				else{
					$matri_id = $data_val['matri_id'];
				}
				
				//$member_id = $this->common_front_model->get_user_id();
				if(isset($matri_id) && $matri_id!='')
				{
					
					if(isset($matri_id) && $matri_id!='' && isset($data_val['matri_id']) && $data_val['matri_id']!='')
					{
						$check_permission_view=array('ph_requester_id'=>$matri_id,'ph_receiver_id '=>$data_val['matri_id'],'receiver_response'=>'Accepted','status'=>'1');
									$data_val['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					}
				}
				$data_val['photoUrl'] = $this->base_url.$this->common_model->path_photos; // use for url attach in api
				$data_val['badgeUrl'] = $this->base_url.$this->common_model->path_payment_logo; 
				$badges = $this->getbadges($data_val);
				if (!empty($badges)) {
					$data_val['badge'] = $badges['badge']!=''?$badges['badge']:'';
					$data_val['color'] = $badges['color']!=''?$badges['color']:'';
				}else{
					$data_val['badge'] = '';
					$data_val['color'] = $this->common_model->data['config_data']['profile_border_color'];
				}
				
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
		return $data;
	}
	function process_data_dashboard($data='')
	{
		$data_arr = array();
		if(isset($data) && $data !='' && count($data)>0)
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
				if(isset($data_val['birthdate']) && $data_val['birthdate']!='')
				{
					$date = $data_val['birthdate'];
					$data_val['birthdate'] = date("d-m-Y", strtotime($date));
				}
				$data_val['profile_description'] = '';
				if((isset($data_val['age']) && $data_val['age']!='') || (isset($data_val['height']) && $data_val['height']!='') || (isset($data_val['religion_name']) && $data_val['religion_name']!='') || (isset($data_val['city_name']) && $data_val['city_name']!='') || (isset($data_val['country_name']) && $data_val['country_name']!=''))
				{
					$data_val['profile_description'] = (isset($data_val['age']) && $data_val['age'] !='')?$data_val['age']:'';
					$data_val['profile_description'].= (isset($data_val['height']) && $data_val['height'] !='')?', '.$data_val['height']:'';
					$data_val['profile_description'].= (isset($data_val['religion_name']) && $data_val['religion_name'] !='')?', '.$data_val['religion_name']:'';
					$data_val['profile_description'].= (isset($data_val['city_name']) && $data_val['city_name'] !='')?', '.$data_val['city_name']:'';
					$data_val['profile_description'].= (isset($data_val['country_name']) && $data_val['country_name'] !='')?', '.$data_val['country_name']:'';
				}
				
				if($this->input->post('matri_id')){
					$matri_id = $this->input->post('matri_id');
				}else{
					//$matri_id = $data_val['matri_id'];
					$matri_id = $this->get_user_id('matri_id');
				}

				$data_val['photo_view_count'] = 0;
				if(isset($matri_id) && $matri_id!='')
				{
					if(isset($matri_id) && $matri_id!='' && isset($data_val['matri_id']) && $data_val['matri_id']!='')
					{
						$check_permission_view=array('ph_requester_id'=>$matri_id,'ph_receiver_id '=>$data_val['matri_id'],'receiver_response'=>'Accepted','status'=>'1');
						$data_val['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					}
				}
				$data_val['photoUrl'] = $this->base_url.$this->common_model->path_photos; // use for url attach in api
				$data_val['badgeUrl'] = $this->base_url.$this->common_model->path_payment_logo; 
				$badges = $this->getbadges($data_val,1);
				if (!empty($badges)) {
					$data_val['badge'] = $badges['badge']!=''?$badges['badge']:'';
					$data_val['color'] = $badges['color']!=''?$badges['color']:'';
				}else{
					$data_val['badge'] = '';
					$data_val['color'] = $this->common_model->data['config_data']['profile_border_color'];
				}
				
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
		return $data;
	}
	function process_data_search_slider_current_plan($data='')
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
				$weight = '';
				if(isset($data_val['weight']) && $data_val['weight'] !='')
				{
					$weight = $data_val['weight'].' kg';
				}
				$data_val['weight'] = $weight;
				$data_val['age'] = '';
				if(isset($data_val['birthdate']) && $data_val['birthdate'] !='')
				{
					$age = $this->common_model->birthdate_disp($data_val['birthdate'],0);
					$data_val['age'] = $age;
				}
				if(isset($data_val['birthdate']) && $data_val['birthdate']!='')
				{
					$date = $data_val['birthdate'];
					$data_val['birthdate'] = date("d-m-Y", strtotime($date));
				}
				$data_val['profile_description'] = '';
				if((isset($data_val['age']) && $data_val['age']!='') || (isset($data_val['weight']) && $data_val['weight']!='') || (isset($data_val['height']) && $data_val['height']!='') || (isset($data_val['caste_name']) && $data_val['caste_name']!='') || (isset($data_val['religion_name']) && $data_val['religion_name']!='') || (isset($data_val['city_name']) && $data_val['city_name']!='') || (isset($data_val['country_name']) && $data_val['country_name']!=''))
				{
					$data_val['profile_description'] = (isset($data_val['age']) && $data_val['age'] !='')?$data_val['age']:'';
					$data_val['profile_description'].= (isset($data_val['height']) && $data_val['height'] !='')?', '.$data_val['height']:'';
					$data_val['profile_description'].= (isset($data_val['weight']) && $data_val['weight'] !='')?', '.$data_val['weight']:'';
					$data_val['profile_description'].= (isset($data_val['religion_name']) && $data_val['religion_name'] !='')?', '.$data_val['religion_name']:'';
					$data_val['profile_description'].= (isset($data_val['caste_name']) && $data_val['caste_name'] !='')?', '.$data_val['caste_name']:'';
					$data_val['profile_description'].= (isset($data_val['city_name']) && $data_val['city_name'] !='')?', '.$data_val['city_name']:'';
					$data_val['profile_description'].= (isset($data_val['country_name']) && $data_val['country_name'] !='')?', '.$data_val['country_name']:'';
				}
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
		return $data;
	}
	function process_data_activity($data='')
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
				$weight = '';
				if(isset($data_val['weight']) && $data_val['weight'] !='')
				{
					$weight = $data_val['weight'].' kg';
				}
				$data_val['weight'] = $weight;
				$data_val['age'] = '';
				if(isset($data_val['birthdate']) && $data_val['birthdate'] !='')
				{
					$age = $this->common_model->birthdate_disp($data_val['birthdate'],0);
					$data_val['age'] = $age;
				}
				if(isset($data_val['birthdate']) && $data_val['birthdate']!='')
				{
					$date = $data_val['birthdate'];
					$data_val['birthdate'] = date("d-m-Y", strtotime($date));
				}
				$data_val['profile_description'] = '';
				if((isset($data_val['age']) && $data_val['age']!='') || (isset($data_val['height']) && $data_val['height']!='') || (isset($data_val['caste_name']) && $data_val['caste_name']!='') || (isset($data_val['religion_name']) && $data_val['religion_name']!='') || (isset($data_val['city_name']) && $data_val['city_name']!='') || (isset($data_val['country_name']) && $data_val['country_name']!='') || (isset($data_val['education_name']) && $data_val['education_name']!='') || (isset($data_val['profileby']) && $data_val['profileby']!=''))
				{
					$data_val['profile_description'] = (isset($data_val['age']) && $data_val['age'] !='')?$data_val['age']:'';
					$data_val['profile_description'].= (isset($data_val['height']) && $data_val['height'] !='')?', '.$data_val['height']:'';
					$data_val['profile_description'].= (isset($data_val['religion_name']) && $data_val['religion_name'] !='')?', '.$data_val['religion_name']:'';
					$data_val['profile_description'].= ((isset($data_val['religion_name']) && $data_val['religion_name'] !='') || (isset($data_val['religion_name']) && $data_val['caste_name'] !=''))?'-':', ';
					$data_val['profile_description'].= (isset($data_val['caste_name']) && $data_val['caste_name'] !='')?$data_val['caste_name']:'';
					$data_val['profile_description'].= (isset($data_val['city_name']) && $data_val['city_name'] !='')?', '.$data_val['city_name']:'';
					$data_val['profile_description'].= (isset($data_val['country_name']) && $data_val['country_name'] !='')?', '.$data_val['country_name']:'';
				}
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
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
				if(isset($data_val['birthdate']) && $data_val['birthdate']!='')
				{
					$date = $data_val['birthdate'];
					$data_val['birthdate'] = date("d-m-Y", strtotime($date));
				}
				if((isset($data_val['age']) && $data_val['age']!='') || (isset($data_val['height']) && $data_val['height']!='') || (isset($data_val['caste_name']) && $data_val['caste_name']!='') || (isset($data_val['religion_name']) && $data_val['religion_name']!='') || (isset($data_val['city_name']) && $data_val['city_name']!='') || (isset($data_val['country_name']) && $data_val['country_name']!='') || (isset($data_val['education_name']) && $data_val['education_name']!='') || (isset($data_val['profileby']) && $data_val['profileby']!=''))
				{
					$data_val['profile_description'] = (isset($data_val['age']) && $data_val['age'] !='')?$data_val['age']:'';
					$data_val['profile_description'].= (isset($data_val['height']) && $data_val['height'] !='')?','.$data_val['height']:'';
					$data_val['profile_description'].= (isset($data_val['caste_name']) && $data_val['caste_name'] !='')?','.$data_val['caste_name']:'';
					$data_val['profile_description'].= ((isset($data_val['religion_name']) && $data_val['religion_name'] !='') || (isset($data_val['religion_name']) && $data_val['caste_name'] !=''))?'-':',';
					$data_val['profile_description'].= (isset($data_val['religion_name']) && $data_val['religion_name'] !='')?$data_val['religion_name'].',':'';
					$data_val['profile_description'].= (isset($data_val['city_name']) && $data_val['city_name'] !='')?','.$data_val['city_name']:'';
					$data_val['profile_description'].= (isset($data_val['country_name']) && $data_val['country_name'] !='')?','.$data_val['country_name']:'';
					$data_val['profile_description'].= (isset($data_val['education_name']) && $data_val['education_name'] !='')?','.$data_val['education_name']:'';
					$data_val['profile_description'].= (isset($data_val['profileby']) && $data_val['profileby'] !='')?',Profile Created By '.$data_val['profileby']:'';
				}
				$matri_id = $data_val['matri_id'];
				
				$member_id = $this->common_front_model->get_user_id();
				if(isset($member_id) && $member_id!='')
				{
					$where_arrra = " id = '$member_id'" ;
					$user_id = $this->common_front_model->get_count_data_manual('register',$where_arrra,2,'matri_id','','',1);
					if(isset($matri_id) && $matri_id!='' && isset($user_id) && $user_id!='')
					{
						$check_permission_view=array('ph_requester_id'=>$user_id[0]['matri_id'],'ph_receiver_id '=>$matri_id,'receiver_response'=>'Accepted','status'=>'1');
									$data_val['photo_view_count'] = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					}
				}
				
				$data_val['action'] = $this->common_status_action($data_val);
				$data_val['photoUrl'] = $this->base_url.$this->common_model->path_photos;
				$data_val['badgeUrl'] = $this->base_url.$this->common_model->path_payment_logo;
				$badges = $this->getbadges($data_val);
				if (!empty($badges)) {
					$data_val['badge'] = $badges['badge']!=''?$badges['badge']:'';
					$data_val['color'] = $badges['color']!=''?$badges['color']:'';
				}else{
					$data_val['badge'] = '';
					$data_val['color'] = $this->common_model->data['config_data']['profile_border_color'];
				}
				$data_arr[] = $data_val;
			}
			$data = $data_arr;
		}
		return $data;
	}
	function common_status_action($data='',$appId='')
	{
		$data_arr = array(); 
		if(isset($data) && $data !='' && is_array($data) && count($data) > 0)
				{
					$other_id = $data['matri_id'];
				    $user_id = $data['id']; 
					if($appId!=''){
						$member_id = $this->common_front_model->get_user_id('id','logged_in_user_id');
					}else{
						$member_id = $this->common_front_model->get_user_id();
					}
					
					
					$where_arrra = " id = '$member_id'" ;
					$matri_id = $this->common_front_model->get_count_data_manual('register',$where_arrra,2,'matri_id','','',1);
					if(isset($matri_id) && $matri_id!='' && count($matri_id)>0)
					{
						$matri_id = $matri_id[0]['matri_id'];
					}
					

					//check user is short list or not
					$where_short = " from_id = '$matri_id' and to_id='$other_id' and is_deleted='No' " ;
					$shortlist = $this->common_front_model->get_count_data_manual('shortlist',$where_short,0,'*','','',1);
					if(isset($shortlist) && $shortlist !='')
					{
						$data_val['is_shortlist'] = $shortlist;	
					}	
					else
					{
						$data_val['is_shortlist'] = $shortlist;
					}

					//check user is interest sent pending,reject,accept or no
					$where_interest = " sender = '$matri_id' and receiver='$other_id' and is_deleted='No' " ;
					$interest = $this->common_front_model->get_count_data_manual('expressinterest',$where_interest,2,'receiver_response','','',1);
					
					if(isset($interest) && $interest !='')
					{
						$data_val['is_interest'] = $interest[0]['receiver_response'];
					}	
					else
					{
						$data_val['is_interest'] = "";
					}

					//check user like or dislike
					$where_like = "my_id = '$matri_id' and other_id='$other_id' and is_deleted='No'";
					$like = $this->common_front_model->get_count_data_manual('member_likes',$where_like,2,'like_status','','',1);
					
					if(isset($like) && $like !='')
					{
						$data_val['is_like'] = $like[0]['like_status'];	
					}
					else
					{
						$data_val['is_like'] = 'No';
					}

					//check user block or unblock
					$where_block[] = " block_by = '$matri_id' and block_to='$other_id' and is_deleted='No'" ;
					$block = $this->common_front_model->get_count_data_manual('block_profile',$where_block,0,'*','','',1);
					
					if(isset($block) && $block!='')
					{
						$data_val['is_block'] = $block;	
					}	
					else
					{
						$data_val['is_block'] = $block;
					}

					$where_login = "index_id = '$user_id'" ;
					$check_login = $this->common_front_model->get_count_data_manual('member_activity',$where_login,0,'*','','',1);
					
					if(isset($check_login) && $check_login!='')
					{
						$data_val['is_login'] = $check_login; 		
					}
					else
					{
						$data_val['is_login'] = $check_login;
					}

					//check user how many view
					$where_view = "viewed_member_id='$other_id'" ;
					$view = $this->common_front_model->get_count_data_manual('who_viewed_my_profile',$where_view,0,'*','','','');
					
					//echo $this->last_query();
					if(isset($view) && $view!='')
					{
						$data_val['is_view'] = $view;	
					}	
					else
					{
						$data_val['is_view'] = $view;
					}
					$data_arr[] = $data_val;
				}
				$data = $data_arr;
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
							//$data_val[$key] = $this->base_url.$val.$data_val[$key];
							$data_val[$key] = $data_val[$key];
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
			'mothertongue_lists'=>array('table_name'=>'mothertongue','pri_key'=>'mtongue_name','disp_clm'=>'mtongue_name','label'=>'Mother Tongue','rel_clm_name'=>''),
			'religion_list'=>array('table_name'=>'religion','pri_key'=>'id','disp_clm'=>'religion_name','label'=>'Religion','rel_clm_name'=>''),
			'religion_lists'=>array('table_name'=>'religion','pri_key'=>'religion_name','disp_clm'=>'religion_name','label'=>'Religion','rel_clm_name'=>''),
			'education_list'=>array('table_name'=>'education_detail','pri_key'=>'id','disp_clm'=>'education_name','label'=>'Education','rel_clm_name'=>''),
			'occupation_list'=>array('table_name'=>'occupation','pri_key'=>'id','disp_clm'=>'occupation_name','label'=>'Occupation','rel_clm_name'=>''),
			'designation_list'=>array('table_name'=>'designation','pri_key'=>'id','disp_clm'=>'designation_name','label'=>'Designation','rel_clm_name'=>''),
			'star_list'=>array('table_name'=>'star','pri_key'=>'id','disp_clm'=>'star_name','label'=>'Star','rel_clm_name'=>''),
			'moonsign_list'=>array('table_name'=>'moonsign','pri_key'=>'id','disp_clm'=>'moonsign_name','label'=>'Moonsign','rel_clm_name'=>''),
			'country_code'=>array('table_name'=>'country_master','pri_key'=>'country_code','disp_clm'=>'country_name','label'=>'Country Code','rel_clm_name'=>''),
			'country_list'=>array('table_name'=>'country_master','pri_key'=>'id','disp_clm'=>'country_name','label'=>'Country','rel_clm_name'=>''),
			'country_lists'=>array('table_name'=>'country_master','pri_key'=>'country_name','disp_clm'=>'country_name','label'=>'Country','rel_clm_name'=>''),

			'state_lists'=>array('table_name'=>'state_master','pri_key'=>'state_name','disp_clm'=>'state_name','label'=>'State','rel_clm_name'=>''),

			'state_list'=>array('table_name'=>'state_master','pri_key'=>'id','disp_clm'=>'state_name','rel_clm_name'=>'country_id','label'=>'State'),
			'city_list'=>array('table_name'=>'city_master','pri_key'=>'id','disp_clm'=>'city_name','label'=>'City','rel_clm_name'=>'state_id'),
			'caste_list'=>array('table_name'=>'caste','pri_key'=>'id','disp_clm'=>'caste_name','label'=>'Caste','rel_clm_name'=>'religion_id'),
			'caste_dropdown'=>array('table_name'=>'caste','pri_key'=>'caste_name','disp_clm'=>'caste_name','label'=>'Caste','rel_clm_name'=>''),
			'currency_master'=>array('table_name'=>'currency_master','val_clm'=>'currency_code','disp_clm'=>'currency_code','pri_key'=>'id','label'=>'Currency','rel_clm_name'=>''),
			'income'=>array('table_name'=>'annual_income','pri_key'=>'id','disp_clm'=>'annual_income_name','label'=>'Annual Income','rel_clm_name'=>''),
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
			//$opt_array[] = array('id'=>'','val'=>'Select Option');
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
						$key='';
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
					$this->db->where('is_deleted','No');
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
	
	function get_plan_detail($user_id='',$return_filed='',$return_val ='No')
	{
		$return_data = 'No';
		if($user_id !='')
		{
			$table_name = 'payments';
			$where_data = array('matri_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			$today_date = $this->common_model->getCurrentDate('Y-m-d');
			$where_data[] = " plan_expired >= '$today_date' ";
			$plan_data = $this->common_model->get_count_data_manual($table_name,$where_data,1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
			{
				if($return_filed !='' && isset($plan_data[$return_filed]) && $plan_data[$return_filed] !='')
				{
					$return_data = $plan_data[$return_filed];
					if($return_data !='Yes' && $return_data !='No')
					{
						if($return_val == 'Yes')
						{
							if(isset($plan_data[$return_filed.'_used']) && $plan_data[$return_filed] > $plan_data[$return_filed.'_used'])
							{
								$return_data = $plan_data[$return_filed] - $plan_data[$return_filed.'_used'];
							}
							else
							{
								$return_data = 0;
							}
						}
						else
						{
							if(isset($plan_data[$return_filed.'_used']) && $plan_data[$return_filed] > $plan_data[$return_filed.'_used'])
							{
								$return_data = 'Yes';
							}
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
	function update_plan_detail($user_id='',$return_filed='')
	{
		if($user_id !='' && $return_filed !='')
		{
			$table_name = 'payments';
			$where_data = array('matri_id'=>$user_id,'current_plan'=>'Yes','is_deleted'=>'No');
			$column_updated = $return_filed.'_used';
			$data_array = array('is_deleted'=>'No');
			$this->db->set($column_updated , " $column_updated + 1", FALSE);
			$this->update_insert_data_common($table_name,$data_array,$where_data,1,1);
		}
	}

	public function get_suggestion_list($search_get,$get_list_get='')
	{
		$search = $this->input->post('q');
		$list_id = $this->input->post('list_id');
		$status = "";
		if($this->input->post('status')!=''){
			$status = $this->input->post('status');
		}
		if($list_id !=''){
			$get_list_get = $list_id;				
		}
		
		if($get_list_get =='member_list_sms' || $get_list_get =='member_list_email'){
			$where = " (email like '%$search%' or username like '%$search%' or mobile like '%$search%' or matri_id like '%$search%' )";
			/*$other_arr = $this->common_model->add_own_where(array(),'','send_bulk_email_and_sms');
			if(isset($other_arr['personal_where']) && $other_arr['personal_where'] !=''){
				$where.= " and ".$other_arr['personal_where'];
			}*/
			if($get_list_get =='member_list_email'){
				$where.= " and email!='' ";
			}
			elseif($get_list_get =='member_list_sms'){
				$where.= " and mobile!='' ";
			}
			if($status=='Active'){
				$where .= " and status='APPROVED'";
			}
			else if($status=='Inactive'){
				$where .= " and status='UNAPPROVED'";	
			}
			else if($status=='Paid'){
				$where .= " and status='APPROVED' and plan_status='Paid'";
			}
			else{
				$where .= "";
			}
			
			$tbl_name = 'register';
			$select = 'id,email,mobile,username,matri_id';
			$display_field = 'username';
			$where_arra = array('is_deleted'=>'No',$where);
			$return = 'mobile';
			if($get_list_get =='member_list_email'){
				$return = 'email';
				$this->db->group_by('email');
			}
			else{
				$this->db->group_by('mobile');
			}
			$data_arr = $this->common_model->get_count_data_manual($tbl_name,$where_arra,2,$select,'','1',25,"");
			//echo $this->db->last_query();
			$opt_array['results'] = array();
			$tocken_array = array();
			$app_array = array();
			if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0){
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
			
			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('city')) && $value_curr !='')
			{
				$return_content.=$this->first_tag.$label.$this->after_tag.'
					<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>
				'.$this->last_tag;
			}
			else
			{  
				$value_arr = $this->common_model->get_value($element_array_val,'value_arr','');
				if(!isset($value_arr) || $value_arr =='' || count($value_arr) ==0)
				{
					$value_arr = $this->common_model->getRelationDropdown($element_array_val);
				}
				$req_star = ' :';
				if(trim($is_required) =='required')
				{
					$req_star = ' <span class="color-d f-16 select2-lbl-span">* </span>';
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
			$is_required = $this->common_model->is_required($element_array_val);
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
					$return_content.='<label class="font-13-normal"><input '.$is_required.' '.$extra.' '.$onclick.' '.$selected_radio.' class="'.$class_d.'" type="radio" name="'.$key.'" id="'.$key_r.'" value="'.$key_r.'">&nbsp;&nbsp;'.$value_arr_val.'</label>&nbsp;&nbsp;';
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
				$req_star = ' <span class="color-d f-16 select2-lbl-span">* </span>:';
			}
			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('email','phone','mobile','landline')) && $value_curr !='')
			{
				$return_content.=$this->first_tag.$label.$this->after_tag.'<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>'.$this->last_tag;
			}
			else
			{
				$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.'
					<input '.$other.' type="'.$input_type.'" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " '.$onchange_textbox.' placeholder="'.$placeholder.'" value ="'.htmlentities(stripcslashes($value_curr)).'" />'.$this->last_tag;
			}
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
			if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1 && in_array($key,array('email','phone','mobile','landline','address')) && $value_curr !='')
			{
				$return_content.=$this->first_tag.$label.$this->after_tag.'<span><strong>'.$this->common_model->disable_in_demo_text.'</strong></span>'.$this->last_tag;
			}
			else
			{
				$return_content.=$this->first_tag.$label.$req_star.$this->after_tag.'
				  	<textarea '.$is_required.' rows="4" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$placeholder.'">'.$value_curr.'</textarea>'.$this->last_tag;
			}
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
		$return_content = '';
		//$return_content = '<div class=""><div class="row margin-0">';
		if(isset($element_array) && $element_array !='' && count($element_array)>0 && $data_array !='')
		{
			foreach($element_array as $key => $field_array_val)
			{
				if($key=='total_children' && $data_array["marital_status"]=='Unmarried'){
					
				}elseif($key=='status_children' && $data_array["marital_status"]=='Unmarried'){
					
				}else{
					$is_single = $this->common_model->get_value($field_array_val,'is_single','');
					$label = $this->common_model->get_label($field_array_val,$key);
					$val_disp = '';
					if(isset($data_array[$key]) && $data_array[$key] !='')
					{
						if($key=='total_children'){
							if($data_array["marital_status"]!='Unmarried')
								$val_disp = $data_array[$key];
						}elseif($key=='status_children'){
							if($data_array["marital_status"]!='Unmarried' && $data_array["total_children"]!='0' && $data_array["total_children"]!='')
								$val_disp = $data_array[$key];
						}else{
							$val_disp = $data_array[$key];
						}
					}
					if($is_single == 'yes')
					{
						if($val_disp =='')
						{
							$val_disp = $dna;
						}
						$return_content.= '
						<div class="col-md-12 col-sx-12 col-sm-12">
							<h5 class="color-profile Poppins-Regular">'.$label.'</h5>
							<span class="Poppins-Semi-Bold f-15 breakword">
								'.$val_disp.'
							</span>
						</div>';
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
							else if($type =='time')
							{
								$final_var_disp = $this->common_model->displayDate($val_disp,'h:i A');
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
						$return_content.= '<div class="col-md-4 col-sx-12 col-sm-4">
						<h5 class="color-profile Poppins-Regular">
									'.$label.'
									</h5>
									<span class="Poppins-Semi-Bold f-15 breakword">'.$final_var_disp.'
									</span>
									</div>';
					}
				}				
			}
		}
		//$return_content.= '</ul>';
		return $return_content;
	}
	
	public function get_user_id($return_session ='id',$app_return='member_id')
	{
		$member_id='';
		if(isset($_REQUEST['user_agent']) && ($_REQUEST['user_agent'] =='NI-AAPP' || $_REQUEST['user_agent'] =='NI-IAPP'))
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
		//$data = array();
		$data1['token'] = $this->security->get_csrf_hash();
		$data1['tocken'] = $this->security->get_csrf_hash();
		if($message !='')
		{
			$data1[$message_name] =  $message;
			$data1['errmessage'] =  $message;

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
		//print_r($data1);exit;
		$data1['data'] = json_encode($data1);
		return $data1;
	}
	//this function for view other profile in app
	//do not change fileds array key value
	public function compare_to_other_user($data = array(),$my_data = array())
	{
		$reset_opt_arrya = array(
			'fileds'=>array(

				 'basic_info'=>array(
                    'Basic Details'=>array('Name'=>'username','Marital Status'=>'marital_status','Total Children'=>'total_children','Status Children'=>'status_children','Mother Tongue'=>'mtongue_name','Languages Known'=>(($data['languages_known']==null || $data['languages_known']==''))?'languages_known':'languages_known_str','Height'=>(($data['height']==null || $data['height']==''))?'height':'height_str','Weight'=>'weight','Birthdate'=>'birthdate','Age'=>'age')
                ),

				'religion_info'=>array(
					'Religious Information'=>array('Religion'=>'religion_name','Caste'=>'caste_name','Subcaste'=>'subcaste','Manglik'=>'manglik','Star'=>(($data['star']==null || $data['star']==''))?'star':'star_str','Horoscope'=>'horoscope','Gothra'=>'gothra','Moonsign'=>(($data['moonsign']==null || $data['moonsign']==''))?'moonsign':'moonsign_str')
				),

				'about_me_and_hobby'=>array(
					'About Me'=>array('About Us'=>'profile_text','Birth Place'=>'birthplace','Birth Time'=>'birthtime','Created By'=>'profileby','Referenced By'=>'reference')
				),

				'edu_Occup'=>array(
					'Education & Occupation'=>array('Education'=>'education_detail_str','Employee In'=>'employee_in','Annual Income'=>'income_name','Occupation'=>'occupation_name','Designation'=>'designation_name')
				),

				'life_style_info'=>array(
					'Life Style Details'=>array('Body Type'=>'bodytype','Eating Habit'=>'diet','Smoking Habit'=>'smoke','Drinking Habit'=>'drink','Skin Tone'=>'complexion','Blood Group'=>'blood_group')
				),

				'location_info'=>array(
					'Location Details'=>array('Country'=>'country_name','State'=>'state_name','City'=>'city_name','Residence'=>'residence')
				),

				'family_info'=>array(
					'Family Details'=>array('Family Type'=>'family_type','Father Name'=>'father_name','Father Occupation'=>'father_occupation','Mother Name'=>'mother_name','Mother Occupation'=>'mother_occupation','Family Status'=>'family_status','No Of Brothers'=>'no_of_brothers','No Of Married Brother'=>'no_of_married_brother','No Of Sisters'=>'no_of_sisters','No Of Married Sister'=>'no_of_married_sister','About My Family'=>'family_details')
				),  
				
				'contact_info'=>array(
					'Contact Details'=>array('Name'=>'username','City'=>'city_name','Address'=>'address','Mobile'=>'mobile','Phone'=>'phone','Time To Call'=>'time_to_call','Email Id'=>'email')
				),
				'photo_info'=>array(
					'Photo Details'=>array('Photo 1'=>'photo1','Photo1 status'=>'photo1_approve','Photo 2'=>'photo2','Photo2 status'=>'photo2_approve','Photo 3'=>'photo3','Photo3 status'=>'photo3_approve','Photo 4'=>'photo4','Photo4 status'=>'photo4_approve','Photo 5'=>'photo5','Photo5 status'=>'photo5_approve','Photo 6'=>'photo6','Photo6 status'=>'photo6_approve','Photo 7'=>'photo7','Photo7 status'=>'photo7_approve','Photo 8'=>'photo8','Photo8 status'=>'photo8_approve')
				), 
			),
			'partners_field'=>array(

				'match_partner_info'=>array(
					'Partner Preferences'=>array('Looking For'=>'looking_for','Age Preference'=>($data['part_frm_age']!='' && $data['part_to_age']!='')?$data['part_frm_age'].' to '.$data['part_to_age'].' Years':'','Height Preference'=>($data['part_height']!='' && $data['part_height_to']!='')?$data['part_height_str'].' to '.$data['part_height_to_str']:'','Mother Tongue'=>(($data['part_mother_tongue']==null || $data['part_mother_tongue']==''))?'part_mother_tongue':'part_mother_tongue_str','Religion'=>(($data['part_religion']==null || $data['part_religion']==''))?'part_religion':'part_religion_str','Country'=>(($data['part_country_living']==null || $data['part_country_living']==''))?'part_country_living':'part_country_living_str','Education'=>(($data['part_education']==null || $data['part_education']==''))?'part_education':'part_education_str','Occupation'=>(($data['part_occupation']==null || $data['part_occupation']==''))?'part_occupation':'part_occupation_str','Designation'=>(($data['part_designation']==null || $data['part_designation']==''))?'part_designation':'part_designation_str')
				),
				// 'basic_partner_info'=>array(
				// 'Basic Preferences'=>array('Looking For'=>'looking_for','Age Preference'=>($data['part_frm_age']!='' && $data['part_to_age']!='')?$data['part_frm_age'].' to '.$data['part_to_age'].' Years':'','Height Preference'=>($data['part_height']!='' && $data['part_height_to']!='')?$data['part_height'].' to '.$data['part_height_to']:'','Mother Tongue'=>'part_mother_tongue')
				// ),

				// 'religion_partner_info'=>array(
				// 	'Religious Preferences'=>array('Religion'=>'part_religion')
				// ),

				// 'location_partner_info'=>array(
				// 	'Location Preferences'=>array('Country'=>'part_country_living')
				// ),

				// 'edu_occup_partner_info'=>array(
				// 	'Education & Occupation Preferences'=>array('Education'=>'part_education','Occupation'=>'part_occupation','Designation'=>'part_designation')
				// ),   
			),
		);
		/*for show only in app */
		if($_POST['user_agent'] != "NI-AAPP")
		{
		    unset($reset_opt_arrya['fileds']['contact_info']);
		}
		/*for show only in app */
		foreach($reset_opt_arrya as $fileds_name=>$category_wise_val)
		{	
			$fileds = array();
			foreach($category_wise_val as $category_id_key=>$val)
			{
				foreach($val as $category_label_key=>$vals)
				{
					$label_value = array();
					$match_count = 0;
					foreach($vals as $keyss=>$valss)
					{
						if(isset($fileds_name) && $fileds_name == 'partners_field')
						{
							$status = "No";
							
							if($keyss == 'Age Preference')
							{
								$age = '';
								if(isset($data['part_frm_age']) && $data['part_frm_age']!='' && isset($data['part_to_age']) && $data['part_to_age']!='')
								{
									$age = $this->common_model->birthdate_disp($my_data['birthdate'],0);
									if(isset($data['part_frm_age']) && $data['part_frm_age']!='' && $data['part_frm_age']<=$age && isset($data['part_to_age']) && $data['part_to_age']!='' && $data['part_to_age']>=$age)
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($keyss == 'Height Preference')
							{
								if(isset($data['part_height']) && $data['part_height']!='' && isset($data['part_height_to']) && $data['part_height_to']!='')
								{
									if(isset($data['part_height']) && $data['part_height']!='' && $data['part_height']<=$my_data['height'] && isset($data['part_height_to']) && $data['part_height_to']!='' && $data['part_height_to']>=$my_data['height'])
									{
										$status = "Yes";
										$match_count++;
									}   
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'looking_for')
							{
								if(isset($data['looking_for']) && $data['looking_for'] !='')
								{
									$user_data_value = $data['looking_for'];
									$member_data_value = $my_data['marital_status'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_religion')
							{
								if(isset($data['part_religion']) && $data['part_religion'] !='')
								{ 
									$user_data_value = $data['part_religion'];
									$member_data_value = $my_data['religion'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_mother_tongue' || $valss == 'part_mother_tongue_str')
							{
								if(isset($data['part_mother_tongue']) && $data['part_mother_tongue'] !='')
								{ 
									$user_data_value = $data['part_mother_tongue'];
									$member_data_value = $my_data['mother_tongue'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_country_living' || $valss == 'part_country_living_str')
							{
								if(isset($data['part_country_living']) && $data['part_country_living'] !='')
								{ 
									$country = $data['part_country_living_str'];	
									$part_country = substr($country,0,140);
									$part_country = substr($country,140);
									
									$user_data_value = $data['part_country_living'];

									$member_data_value = $my_data['country_id'];
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_education' || $valss == 'part_education_str')
							{
								if(isset($data['part_education']) && $data['part_education'] !='')
								{ 
									$education = $data['part_education'];
									$part_education = substr($education,0,140);
									$part_education = substr($education,140);
									$user_data_value = $education;
									$member_data_value = $my_data['education_detail'];
									$user_data_value_arr =explode(',',$user_data_value);
									$member_data_value_arr =explode(',',$member_data_value);
									$result_arr = array_intersect($member_data_value_arr, $user_data_value_arr);		
									$result_arr_count = count($result_arr);
									if(isset($result_arr) && $result_arr!='' && $result_arr_count>0)
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_occupation' || $valss == 'part_occupation_str')
							{
								if(isset($data['part_occupation']) && $data['part_occupation'] !='')
								{ 
									$occupation = $data['part_occupation'];
									$part_occupation = substr($occupation,0,140);
									$part_occupation = substr($occupation,140);
									$user_data_value = $occupation;
									$member_data_value = $my_data['occupation'];	
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							else if($valss == 'part_designation' || $valss == 'part_designation_str')
							{
								if(isset($data['part_designation']) && $data['part_designation'] !='')
								{ 
									$designation = $data['part_designation_str'];	
									$part_designation = substr($designation,0,140);
									$part_designation = substr($designation,140);
									$user_data_value = $designation;
									$member_data_value = $this->common_model->valueFromId('designation',$my_data['designation'],'designation_name');
									$user_data_value_arr =explode(',',$user_data_value);
									if(in_array($member_data_value,$user_data_value_arr))
									{
										$status = "Yes";
										$match_count++;
									}
									else
									{
										$status = "No";
									}
								}
							}
							$label_value[] = array('title'=>$keyss,'value'=>($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss:(($data[$valss]==null)?'':$data[$valss]),'type'=>$status);
						}
						else
						{
							if($category_id_key == 'photo_info')
							{
								if(isset($valss) && ($valss=='photo1' || $valss=='photo2' || $valss=='photo3' || $valss=='photo4' || $valss=='photo5' || $valss=='photo6' || $valss=='photo7' || $valss=='photo8'))
								{
									if($data[$valss]=='' || $data[$valss]==null || $data[$valss.'_approve']=="UNAPPROVED")
									{
										continue;
									} 
								}
								else if(isset($valss) && ($valss=='photo1_approve' || $valss=='photo2_approve' || $valss=='photo3_approve' || $valss=='photo4_approve' || $valss=='photo5_approve' || $valss=='photo6_approve' || $valss=='photo7_approve' || $valss=='photo8_approve'))
								{
									$string = substr($valss,0,6);
									if($data[$string]=='' || $data[$string]==null || $data[$valss]=="UNAPPROVED" || $data[$valss]=="APPROVED")
									{
										continue;
									} 
								}
							}
							if($category_id_key == 'location_info'){
								if($data['contact_view_security'] == '0'){
									$where_expressinterest = array('sender'=>$my_data['matri_id'],'receiver'=>$data['matri_id'],'receiver_response'=>'Accepted');
									$expressinterest_count = $this->common_model->get_count_data_manual('expressinterest',$where_expressinterest,0,'');
									if($expressinterest_count == 0){
										continue;
									}
								}
							}
							
							$label_value[] = array('title'=>$keyss,'value'=>(($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss: (($data[$valss]==null)?'':((isset($valss) && $valss=='birthdate')?date("d-m-Y", strtotime($data[$valss])):((isset($valss) && $valss=='weight')?$data[$valss].' kg':$data[$valss])))));
							//}
						}
					
					}
					$data['totalMatch'] = $totalMatch = ($match_count * 100) / 9;
					if($category_label_key == 'Partner Preferences'){
						$category_label_key = 'Your match ('.number_format($totalMatch).'%) preferences';
					}
					$fileds[] = array('id'=>$category_id_key,'name'=>$category_label_key,'value'=>$label_value);
				}
				
			}
			$data[$fileds_name] = $fileds;
		}
		return $data;
	}
	//this function for edit view my profile in app
	//do not change fileds array key value
	// this function use for Website Edit Profile and Also use for App side edit profile
	public function set_member_profile_data_category_wise($data = array())
	{
		$reset_opt_arrya = array(
			'fileds'=>array(

				 'basic_info'=>array(
                    'Basic Details'=>array('Name'=>'username','Marital Status'=>'marital_status','Mother Tongue'=>'mtongue_name','Languages Known'=>(($data['languages_known']==null || $data['languages_known']==''))?'languages_known':'languages_known_str','Total Children'=>'total_children','Status Children'=>'status_children','Height'=>(($data['height']==null || $data['height']==''))?'height':'height_str','Weight'=>(($data['weight']==null || $data['weight']==''))?'weight':'weight_str','Birthdate'=>'birthdate')
                ),

				'religion_info'=>array(
					'Religious Information'=>array('Religion'=>'religion_name','Caste'=>'caste_name','Subcaste'=>'subcaste','Manglik'=>'manglik','Star'=>'star_str','Horoscope'=>'horoscope','Gothra'=>'gothra','Moonsign'=>'moonsign_str')
				),

				'about_me_and_hobby'=>array(
					'About Me'=>array('About Us'=>'profile_text','Birth Place'=>'birthplace','Birth Time'=>'birthtime','Created By'=>'profileby','Referenced By'=>'reference')
				),

				'edu_Occup'=>array(
					'Education & Occupation'=>array('Education'=>'education_detail_str','Employee In'=>'employee_in','Annual Income'=>'income_name','Occupation'=>'occupation_name','Designation'=>'designation_name')
				),

				'life_style_info'=>array(
					'Life Style Details'=>array('Body Type'=>'bodytype','Eating Habit'=>'diet','Smoking Habit'=>'smoke','Drinking Habit'=>'drink','Skin Tone'=>'complexion','Blood Group'=>'blood_group')
				),

				'location_info'=>array(
					'Location Details'=>array('Country'=>'country_name','State'=>'state_name','City'=>'city_name','Address'=>'address','Mobile'=>'mobile','Phone'=>'phone','Time To Call'=>'time_to_call','Residence'=>'residence')
				),

				'family_info'=>array(
					'Family Details'=>array('Family Type'=>'family_type','Father Name'=>'father_name','Father Occupation'=>'father_occupation','Mother Name'=>'mother_name','Mother Occupation'=>'mother_occupation','Family Status'=>'family_status','No Of Brothers'=>'no_of_brothers','No Of Married Brother'=>'no_of_married_brother','No Of Sisters'=>'no_of_sisters','No Of Married Sister'=>'no_of_married_sister','About My Family'=>'family_details')
				), 
				

				'photo_info'=>array(
					'Photo Details'=>array('Photo 1'=>'photo1','Photo1 status'=>'photo1_approve','Photo 2'=>'photo2','Photo2 status'=>'photo2_approve','Photo 3'=>'photo3','Photo3 status'=>'photo3_approve','Photo 4'=>'photo4','Photo4 status'=>'photo4_approve','Photo 5'=>'photo5','Photo5 status'=>'photo5_approve','Photo 6'=>'photo6','Photo6 status'=>'photo6_approve','Photo 7'=>'photo7','Photo7 status'=>'photo7_approve','Photo 8'=>'photo8','Photo8 status'=>'photo8_approve')
				), 
			),
			'partners_field'=>array(
				'basic_partner_info'=>array(
					'Basic Preferences'=>array('Looking For'=>'looking_for','Partner Complexion'=>'part_complexion','Age Preference'=>($data['part_frm_age']!='' && $data['part_to_age']!='')?$data['part_frm_age'].' to '.$data['part_to_age'].' Years':'','Height Preference'=>($data['part_height']!='' && $data['part_height_to']!='')?$data['part_height_str'].' to '.$data['part_height_to_str']:'','Body Type'=>'part_bodytype','Eating Habit'=>'part_diet','Smoking'=>'part_smoke','Drinking'=>'part_drink','Mother Tongue'=>'part_mother_tongue','Expectations'=>'part_expect')
				),

				'religion_partner_info'=>array(
					'Religious Preferences'=>array('Religion'=>'part_religion','Caste'=>'part_caste','Manglik'=>'part_manglik','Star'=>'part_star')
				),

				'location_partner_info'=>array(
					'Location Preferences'=>array('Country'=>'part_country_living','State'=>'part_state','City'=>'part_city','Residence'=>'part_resi_status')
				),

				'edu_occup_partner_info'=>array(
					'Education & Occupation Preferences'=>array('Education'=>'part_education','Employee In'=>'part_employee_in','Occupation'=>'part_occupation','Designation'=>'part_designation','Annual Income'=>'part_income_name')
				),   
			),
		);
		$string='';
		foreach($reset_opt_arrya as $fileds_name=>$category_wise_val)
		{	
			$fileds = array();
			foreach($category_wise_val as $category_id_key=>$val)
			{
				foreach($val as $category_label_key=>$vals)
				{
					$label_value = array();
					foreach($vals as $keyss=>$valss)
					{
						if($category_id_key == 'photo_info')
						{
							if(isset($valss) && ($valss=='photo1' || $valss=='photo2' || $valss=='photo3' || $valss=='photo4' || $valss=='photo5' || $valss=='photo6' || $valss=='photo7' || $valss=='photo8'))
							{
								if($data[$valss]=='' || $data[$valss]==null)
								{
									continue;
								} 
							}
							else if(isset($valss) && ($valss=='photo1_approve' || $valss=='photo2_approve' || $valss=='photo3_approve' || $valss=='photo4_approve' || $valss=='photo5_approve' || $valss=='photo6_approve' || $valss=='photo7_approve' || $valss=='photo8_approve'))
							{
								$string = substr($valss,0,6);
								if($data[$string]=='' || $data[$string]==null || $data[$valss]=="UNAPPROVED" || $data[$valss]=="APPROVED")
								{
									continue;
								} 
							}
							$label_value[] = array('title'=>$keyss,'value'=>($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss:(($data[$valss]==null)?'':$data[$valss])); 
						}
						else{
							$str_val ="";
							
							if($category_id_key=='location_partner_info' || $category_id_key=='edu_occup_partner_info' || $category_id_key=='religion_partner_info' || $category_id_key=='basic_partner_info'){
								
								$reset_opt_arrya = array();
								if($keyss=='Country'){
									$reset_opt_arrya = array(
										'part_country_living'=>array('table'=>'country_master','key_disp'=>'country_name'),
									);
								}
								else if($keyss=='State'){
									$reset_opt_arrya = array(
										'part_state'=>array('table'=>'state_master','key_disp'=>'state_name')
									);
								}
								else if($keyss=='City'){
									$reset_opt_arrya = array(
										'part_city'=>array('table'=>'city_master','key_disp'=>'city_name')
									);
								}
								else if($keyss=='Religion'){
									$reset_opt_arrya = array(
										'part_religion'=>array('table'=>'religion','key_disp'=>'religion_name')
									);
								}
								else if($keyss=='Caste'){
									$reset_opt_arrya = array(
										'part_caste'=>array('table'=>'caste','key_disp'=>'caste_name')
									);
								}
								else if($keyss=='Star'){
									$reset_opt_arrya = array(
										'part_star'=>array('table'=>'star','key_disp'=>'star_name')
									);
								}
								else if($keyss=='Education'){
									$reset_opt_arrya = array(
										'part_education'=>array('table'=>'education_detail','key_disp'=>'education_name')
									);
								}
								else if($keyss=='Occupation'){
									$reset_opt_arrya = array(
										'part_occupation'=>array('table'=>'occupation','key_disp'=>'occupation_name')
									);
								}
								else if($keyss=='Annual Income'){
									$reset_opt_arrya = array(
										'part_income_name'=>array('table'=>'annual_income','key_disp'=>'annual_income_name')
									);
								}
								else if($keyss=='Designation'){
									$reset_opt_arrya = array(
										'part_designation'=>array('table'=>'designation','key_disp'=>'designation_name')
									);
								}
								else if($keyss=='Mother Tongue'){
									$reset_opt_arrya = array(
										'part_mother_tongue'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name')
									);
								}
								
								if(isset($reset_opt_arrya) && $reset_opt_arrya !='' && is_array($reset_opt_arrya) && count($reset_opt_arrya) > 0){
									foreach($reset_opt_arrya as $key=>$val){
										$str_val = $this->common_model->valueFromId($val['table'],$data[$key],$val['key_disp']);
									}
								}
							}
							if($str_val==''){
								$str_val = ($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss:(($data[$valss]==null)?'':((isset($valss) && $valss=='birthdate')?date("d-m-Y", strtotime($data[$valss])):$data[$valss]));
							}
							//this condition remove _str and set original id for edit profile app in ios
							if(isset($valss) && $valss!='')
							{
								$valmainid = str_replace("_str","",$valss);
							}
							else
							{
								$valmainid = $valss;
							}
							$label_value[] = array('title'=>$keyss,'value'=>$str_val,'string_id'=>($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss:(($data[$valss]==null)?'':((isset($valss) && $valss=='birthdate')?date("d-m-Y", strtotime($data[$valss])):$data[$valss])),'id'=>($keyss == 'Age Preference')?'part_age':(($keyss == 'Height Preference')?'part_height':$valmainid));
						}
						/*else
						{
							$label_value[] = array('title'=>$keyss,'value'=>($keyss == 'Age Preference' || $keyss == 'Height Preference')? $valss:(($data[$valss]==null)?'':((isset($valss) && $valss=='birthdate')?date("d-m-Y", strtotime($data[$valss])):$data[$valss])),'id'=>($keyss == 'Age Preference')?'part_age':(($keyss == 'Height Preference')?'part_height':$valss)); 
						}*/
						//unset($data[$valss]);//code for unset array field 
					}
					$fileds[] = array('id'=>$category_id_key,'name'=>$category_label_key,'value'=>$label_value);
				}
				
			}
			$data[$fileds_name] = $fileds;
		}
		//code for unset array field 
		//$data[$keyy] = $ll;

		// $a=array('part_frm_age','part_to_age','part_height','part_height_to');
		// foreach($a as $key=>$val)
		// {
		// 	unset($data[$val]);//remaing array remove
		// }
		return $data;
	}
	public function set_member_profile_join_data($data = array())
	{
		if($data !='' && count($data) > 0)
		{
			$reset_opt_arrya = array(
				'part_occupation'=>array('table'=>'occupation','key_disp'=>'occupation_name'),
				'part_income_name'=>array('table'=>'annual_income','key_disp'=>'annual_income_name'),
				'part_designation'=>array('table'=>'designation','key_disp'=>'designation_name'),
				'part_star'=>array('table'=>'star','key_disp'=>'star_name'),
				'star'=>array('table'=>'star','key_disp'=>'star_name'),
				'moonsign'=>array('table'=>'moonsign','key_disp'=>'moonsign_name'),
				'part_mother_tongue'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name'),
				'languages_known'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name'),
				'part_religion'=>array('table'=>'religion','key_disp'=>'religion_name'),
				'part_caste'=>array('table'=>'caste','key_disp'=>'caste_name'),
				'part_education'=>array('table'=>'education_detail','key_disp'=>'education_name'),
				'education_detail'=>array('table'=>'education_detail','key_disp'=>'education_name'),
				'part_country_living'=>array('table'=>'country_master','key_disp'=>'country_name'),
				'part_state'=>array('table'=>'state_master','key_disp'=>'state_name'),
				'part_city'=>array('table'=>'city_master','key_disp'=>'city_name'),
				'part_city'=>array('table'=>'city_master','key_disp'=>'city_name'),
			);
			if($reset_opt_arrya !='' && count($reset_opt_arrya) > 0)
			{
				foreach($reset_opt_arrya as $key=>$val)
				{
					if($key !='' && isset($data[$key]))
					{
						$data[$key.'_str'] = $this->common_model->valueFromId($val['table'],$data[$key],$val['key_disp']);
					}
					else
					{
						$data[$key.'_str'] = '';
					}
				}
			}
			if(isset($data['height']) && $data['height']!='')
			{
				$height = $this->common_model->display_height($data['height']);
				$data['height_str'] = $height;
			}
			if(isset($data['weight']) && $data['weight']!='')
			{
				$weight = $data['weight'];
				$data['weight_str'] = $weight.' kg';
			}
			if(isset($data['birthdate']) && $data['birthdate']!='')
			{
				$age = $this->common_model->birthdate_disp($data['birthdate'],0);
				$data['age'] = $age;
			}
			if(isset($data['part_height']) && $data['part_height']!='')
			{
				$height = $this->common_model->display_height($data['part_height']);
				$data['part_height_str'] = $height;
			}
			if(isset($data['part_height_to']) && $data['part_height_to']!='')
			{
				$height = $this->common_model->display_height($data['part_height_to']);
				$data['part_height_to_str'] = $height;
			}

			//set this for get blank data when get data null 30-05-2019
			foreach ($data as $key => $value) {
				
				if(!isset($value) && $value==null)
				{
					$data[$key]='';
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
					$this->common_model->resize_image($path_photos_big,$val);
					$this->common_model->resize_image($path_photos,$val);
				}
			}
		}
	}
	public function dashboard_slide_fill_filed_array()
	{
		$field_and_per = 		
		array(
			'basic-detail'=>array(	
				'firstname'=>'1',
				'lastname'=>'1',
				'email'=>'2',
				'marital_status'=>'1',
				'mother_tongue'=>'1',
				'birthdate'=>'1',
				'languages_known'=>'1',
				'height'=>'1',
				'weight'=>'1',
			),
			'life-style-detail'=>array(
				'bodytype'=>'1',
				'diet'=>'1',
				'smoke'=>'1',
				'drink'=>'1',
				'complexion'=>'1',
				'blood_group'=>'1',
			),
			'about-me-detail'=>array(
				'profile_text'=>'2',
				'hobby'=>'1',
				'birthplace'=>'1',
				'birthtime'=>'1',
				'reference'=>'1',
				'profileby'=>'1',
			),
			'religious-detail'=>array(	
				'religion'=>'2',
				'caste'=>'2',
				'subcaste'=>'1',
				'manglik'=>'1',
				'star'=>'1',
				'horoscope'=>'1',
				'gothra'=>'1',
				'moonsign'=>'1',
			),
			'residence-detail'=>array(					
				'country_id'=>'2',
				'state_id'=>'2',
				'city'=>'2',
				'address'=>'2',
				'mobile'=>'2',
				'phone'=>'2',
				'time_to_call'=>'1',
				'residence'=>'1',
			),
			'education-detail'=>array(
				'education_detail'=>'2',
				'employee_in'=>'2',
				'income'=>'2',
				'occupation'=>'2',
				'designation'=>'2',
			),
			'family-detail'=>array(
				'family_type'=>'1',
				'father_name'=>'1',
				'father_occupation'=>'1',
				'mother_name'=>'1',				
				'mother_occupation'=>'1',
				'family_status'=>'1',
				'no_of_brothers'=>'1',
				'no_of_married_brother'=>'1',
				'no_of_sisters'=>'1',
				'no_of_married_sister'=>'1',
				'family_details'=>'2',
			),
			'part-basic-detail'=>array(
				 'looking_for'=>'1',
				 //'part_complexion'=>'1',
				 'part_frm_age'=>'1',
				 'part_to_age'=>'1',				 
				 'part_height'=>'1',
				 'part_height_to'=>'1',				 
				/* 'part_mother_tongue'=>'1',
				 'part_expect'=>'1',*/
			),
			/*'part-religious-detail'=>array(
				 'part_religion'=>'1',
				 'part_caste'=>'1',
			),
			'part-location-detail'=>array(
				 'part_country_living'=>'1',
				 'part_state'=>'1',
				 'part_city'=>'1',
				 'part_resi_status'=>'1',
			),
			'part-education-detail'=>array(	 
				 'part_education'=>'1',
			),*/
			'horoscope-photo'=>array(	 
				 'horoscope_photo'=>'2',
			),
			'cover-photo'=>array(	 
				 'cover_photo'=>'2',
			),	
			'id-proof'=>array(	 
				 'id_proof'=>'2',
			),
			'photo'=>array(
				'photo1'=>'5',
				'photo2'=>'1',
				'photo3'=>'1',
				'photo4'=>'1',
				'photo5'=>'1',
				'photo6'=>'1',
				)
			);
		return $field_and_per;
	}
	
	public function field_percentage_array()
	{
		$field_and_per = array(
		// Basic Details as 13% value
		'profileby'=>'1',
		'firstname'=>'1',
		'lastname'=>'1',
		'email'=>'2',
		'marital_status'=>'1',
		'mother_tongue'=>'1',
		'reference'=>'1',
		'birthdate'=>'1',
		'diet'=>'1',
		'smoke'=>'1',
		'drink'=>'1',
		'languages_known'=>'1',
		
		//verify mobile number and email id as 10%
		'cpass_status'=>'5',
		'mobile_verify_status'=>'5',
		
		//Social Religion Attributes as 10% value
		'religion'=>'2',
		'caste'=>'2',
		'subcaste'=>'1',
		'gothra'=>'1',
		'star'=>'1',
		'moonsign'=>'1',
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
		'address'=>'2',
		'country_id'=>'2',
		'state_id'=>'2',
		'city'=>'2',
		'mobile'=>'2',
		'phone'=>'2',
		'time_to_call'=>'1',
		'birthplace'=>'1',
		'birthtime'=>'1',
		'residence'=>'1',
		
		// horoscope_photo ,cover_photo, Photo 1 to 6 as 16%  value 
		'id_proof'=>'2',
		'horoscope_photo'=>'2',
		'cover_photo'=>'2',
		'photo1'=>'5',
		'photo2'=>'1',
		'photo3'=>'1',
		'photo4'=>'1',
		'photo5'=>'1',
		'photo6'=>'1',
		
		 // Hobby and Profile Text as 3% value
		'profile_text'=>'2',
		'hobby'=>'1',
		
		// Family Details as 12% value
		'family_details'=>'2',
		'family_type'=>'1',
		'family_status'=>'1',
		'father_name'=>'1',
		'mother_name'=>'1',
		'father_occupation'=>'1',
		'mother_occupation'=>'1',
		'no_of_brothers'=>'1',
		'no_of_sisters'=>'1',
		'no_of_married_brother'=>'1',
		'no_of_married_sister'=>'1',
		
		 //Partner Preference as 5% value
		 'looking_for'=>'1',
		 'part_frm_age'=>'1',
		 'part_to_age'=>'1',
		// 'part_expect'=>'1',
		 'part_height'=>'1',
		 'part_height_to'=>'1',
		 /*'part_complexion'=>'1',
		 'part_mother_tongue'=>'1',
		 'part_religion'=>'1',
		 'part_caste'=>'1',
		 'part_education'=>'1', */
		 'part_country_living'=>'1',
		 'part_state'=>'1',
		 'part_city'=>'1',
		//  'part_resi_status'=>'1',
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
			$where_arra = array('id'=>$id,'is_deleted'=>'No');
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
						if(isset($login_user_details[$single_field]) && $login_user_details[$single_field]!='' && !is_null($login_user_details[$single_field]))
						{
							if($login_user_details['cpass_status']=='Not-Verify'){
								$field_and_per['cpass_status'] = '0';
							}
							if($login_user_details['mobile_verify_status']=='No'){
								$field_and_per['mobile_verify_status'] = '0';
							}
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
	function file_upload_new($upload_data='')
	{
		$return_message = '';
		if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['upload_path']) && $upload_data['upload_path'] !='' && isset($upload_data['file_name']) && $upload_data['file_name'] !='')
		{	

			$config	= array();
			$config['upload_path']  = $upload_data['upload_path'];
			$allowed_types ='gif|jpg|png|jpeg|bmp';			
			$config['allowed_types']= $allowed_types;
			$config['max_size']= $this->common_model->max_size_file_upload;
			if(isset($upload_data['max_size']) && $upload_data['max_size'] !='')
			{
				$config['max_size']= $upload_data['max_size'];
			}
			if(isset($upload_data['overwrite']) && $upload_data['overwrite'] !='')
			{
				$config['overwrite']= $upload_data['overwrite'];
			}
			if(!isset($upload_data['file_name_upload']) || $upload_data['file_name_upload'] =='')
			{
				if(isset($upload_data['encrypt_name']) && $upload_data['encrypt_name'] !='')
				{
					$config['encrypt_name']= $upload_data['encrypt_name'];
				}
				else
				{
					$config['encrypt_name'] = TRUE;
				}
			}
			else if(isset($upload_data['file_name_upload']) && $upload_data['file_name_upload'] !='')
			{
				$config['file_name'] = $upload_data['file_name_upload'];				
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
			}
			else
			{
				$upload_data_file = $this->upload->data();
				$return_message = array('status'=>'success','file_data'=>$upload_data_file,'file_name'=>$upload_data_file['file_name']);
			}
		}
		return $return_message;
	}

	public function getbadges($data=array(),$single=0)
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if ($user_agent != 'NI-WEB' || $single == 1) {
			$planBadge = '';
			if(!empty($data)){
				$flag=1;
				$where = array('id'=>$data['plan_id']);
				$member_data = $this->common_front_model->get_count_data_manual('membership_plan',$where,$flag,'id,badge,color');
				if(!empty($member_data)){
					$planBadge = $member_data;
				}
			}
		}else{
			$planBadge = array();
			if(!empty($data)){
				$planId = implode("','", array_column($data, "plan_id"));
				$where = array(" id IN ('".$planId."')");
				$flag=2;
				$member_data = $this->common_front_model->get_count_data_manual('membership_plan',$where,$flag,'id,badge,color');
				if(!empty($member_data)){
					$id = array_column($member_data, "id");
					$badge = array_column($member_data, "badge");
					$color = array_column($member_data, "color");
					$planBadge['badge'] = array_combine($id, $badge);
					$planBadge['color'] = array_combine($id, $color);
				}
			}
		}
		return $planBadge;
	}

	public function photo_protect_count($matri_id='',$other_matri_id='')
	{
		$photo_view_count = 0;
		if(isset($matri_id) && $matri_id!='' && isset($other_matri_id) && $other_matri_id!='')
		{
			$check_permission_view = array('ph_requester_id'=>$matri_id,'ph_receiver_id '=>$other_matri_id,'receiver_response'=>'Accepted','status'=>'1');
			$photo_view_count = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
		}
		return $photo_view_count;
	}

	public function checkLoginVendor($type='redirect')
	{
		// need to work for ajax request and login issue
		if(isset($_REQUEST['user_agent']) && ($_REQUEST['user_agent'] =='NI-AAPP' || $_REQUEST['user_agent'] =='NI-IAPP'))
		{
			return true;
		}
		else
		{			
			if(!$this->session->userdata('vendor_user_data') || $this->session->userdata('vendor_user_data') =="" && count($this->session->userdata('vendor_user_data')) == 0 )
			{
				$base_url = base_url();
				if($type == 'redirect')
				{
					redirect($base_url.'vendor-login');
				}
				else if($type == 'return')
				{
					
					return false;
				}
			}
			else
			{				
				$vendor_user_data = $this->session->userdata('vendor_user_data');
				if(isset($vendor_user_data['id']) && $vendor_user_data['id'] !='')
				{
					$where = array('id'=>$vendor_user_data['id']);
					$login_data = $this->common_model->get_count_data_manual("wedding_planner",$where,1,'','','',1);
	
					if(isset($login_data) && (isset($login_data['is_deleted']) && $login_data['is_deleted'] == 'Yes') || (isset($login_data['status']) && $login_data['status'] != 'APPROVED'))
					{
						$this->session->unset_userdata('vendor_user_data');
						$base_url = base_url();
						redirect($base_url.'vendor-login');
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
		}
	}

	public function vendor_already_login_redirect($is_post=1)
	{
		$vendor_user_data = $this->session->userdata('vendor_user_data');
		$user_id = $vendor_user_data['id'];
		if($user_id !='')
		{
			if(isset($is_post) && $is_post=='0')
			{
				$data['status'] = 'al_ready_login';
				return $data;
			}
			else
			{
				redirect($this->base_url.'vendor-dashboard');
			}
			
		}
	}

	public function get_vendor_session_data($return_filed='')
	{
		$matrimonial_user_data = $this->session->userdata('vendor_user_data');
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
}