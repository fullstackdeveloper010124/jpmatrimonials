<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Common_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		//$this->output->enable_profiler(TRUE);
		$success_array = array(
			'add' =>'Data inserted successfully.',
			'edit' =>'Data updated successfully.',
			'error' =>'Some error occured, please try again.',
			'delete'=>'Data deleted successfully.',
			'error_file' =>'Some error occured when file upload, please try again.'
		);
		$this->success_message = $success_array;
		$this->extra_css = array('vendor/checkbo/src/0.1.4/css/checkBo.min.css');
		$this->extra_js = array('vendor/jquery-validation/dist/jquery.validate.min.js','vendor/checkbo/src/0.1.4/js/checkBo.min.js');
		$this->mode = 'add';
		$this->js_validation_extra ='';
		$this->js_extra_code ='';
	// main tabel	
		$this->table_name ='';
		$this->table_name_dot='';
		$this->table_field ='';
		$this->status_field = 'status';
	// main tabel
	// for relation, Join tabel
		$this->join_tab_array = '';
		$this->join_tab_array_filed_disp = '';
		$this->filed_notdisp = array();
		
	// for relation, Join tabel
		$this->primary_key ='id';
		$this->data_tabel_filedIgnore = array('id','is_deleted');

		$this->data_tabel_filed = '';
		$this->data_tabel_data = '';
		$this->data_tabel_filtered_count = 0;
		$this->data_tabel_all_count = 0;
		$this->search_filed = '';
		$this->limit_per_page =1;
		$this->pagination_link ='';
		$this->page_number=1;
		$this->admin_path = $this->data['admin_path'] = $this->getconfingValue('admin_path');
		$this->class_name = $this->router->fetch_class();
		$this->method_name = $this->router->fetch_method();
		$this->success_url = $this->method_name;
		
		$this->action = $this->router->fetch_class().'/'.$this->method_name.'/save-data';
		
		$this->add_fun = $this->method_name.'/add-data';
		$this->base_url_admin_cm_status = $this->base_url_admin_cm = base_url().$this->admin_path.'/'.$this->class_name.'/'.$this->method_name.'/';
		$this->start = 0;
		$this->data_table_parameter = '';
		$this->status_mode ='';
		$this->status_arr = array('APPROVED'=>'APPROVED','UNAPPROVED'=>'UNAPPROVED');
		$this->status_column = 'status';
		$this->label_col = 2;
		$this->form_control_col = 7;
		
		// for view detail pagge
		$this->detail_label_col = 4;
		$this->detail_val_col = 8;
		$this->detail_class_width = 'col-lg-4 col-md-6 col-sm-12 col-xs-12';
		// for view detail pagge
		
		$this->addPopup = 0;
		$this->button_array = array();
		$this->last_insert_id = '';
		$this->labelArr = array('country_id'=>'Country Name','state_id'=>'State Name','city_id'=>'City Name','photo1_approve'=>'Status','photo2_approve'=>'Status','photo3_approve'=>'Status','photo4_approve'=>'Status','photo5_approve'=>'Status','photo6_approve'=>'Status','photo7_approve'=>'Status','photo8_approve'=>'Status','photo1_uploaded_on'=>'Uploaded On','photo2_uploaded_on'=>'Uploaded On','photo3_uploaded_on'=>'Uploaded On','photo4_uploaded_on'=>'Uploaded On','photo5_uploaded_on'=>'Uploaded On','photo6_uploaded_on'=>'Uploaded On','photo7_uploaded_on'=>'Uploaded On','photo8_uploaded_on'=>'Uploaded On','id_proof_approval'=>'Status','hor_check'=>'Status','hor_photo'=>'Horoscope','exp_date'=>'Plan Expired','p_currency'=>'Currency'); // here we can set common label change for coloumn name
		$this->data['base_url'] = $this->base_url = base_url();
		$this->data['base_url_admin'] = $this->base_url_admin = $this->base_url.$this->admin_path.'/';
		$this->data['config_data'] = $this->get_site_config();
		$this->label_page='';
		$this->permenent_delete = 'no';
		$this->is_delete_fild = 'is_deleted';
		$this->created_on_fild = 'created_on';
		$this->display_date_arr = array('created_on', 'register_date', 'last_login', 'birthdate', 'posted_on', 'photo1_uploaded_on', 'photo2_uploaded_on', 'photo3_uploaded_on', 'photo4_uploaded_on', 'photo5_uploaded_on', 'photo6_uploaded_on', 'photo7_uploaded_on', 'photo8_uploaded_on', 'pactive_dt', 'exp_date','event_date','marriagedate','plan_exp');
		$this->display_currency_arr = array('p_amount', 'tax_amount','discount_amount','grand_total','ticket','price');
		$this->field_duplicate = '';
		$this->other_config = '';
		$this->ele_array ='';
		$this->data_not_availabel ='N/A';
		$this->display_selected_field = '';
		$this->edit_row_data = '';
		$this->photo_avtar = 'assets/back_end/images/avatar-placeholder.png';
		$this->photo_upload_count = 6; // not more then 8
	}
	function getCurrentDate($dformat='Y-m-d H:i:s')
	{
		//date_default_timezone_set('UTC'); // already set in config
		return date($dformat);
	}
	function callCURL($url='')
	{
		$return_res ='';
		if($url !='')
		{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
			curl_setopt($ch, CURLOPT_TIMEOUT, 4);
			$return_res = curl_exec($ch);
			curl_close($ch);
		}
		return $return_res;
	}
	function displayDate($date = '',$dformat='F j, Y h:i A')// Y-m-d h:i:s
	{
		if($date =='0000-00-00' ||  $date =='0000-00-00 00:00:00')
		{
			return $this->data_not_availabel;
		}
		else if($date !='' && $dformat !='')
		{
			$time_zone ='';
			if(!$this->session->userdata('time_zone') || $this->session->userdata('time_zone') =="" )
			{
				// commented by mustakim for not using cookie
					/*
					$cookie_data = get_cookie("mega_matri_data");
					if(isset($cookie_data) && $cookie_data !='')
					{
						$cookie_data_arr = json_decode($cookie_data);
						if(isset($cookie_data_arr) && $cookie_data_arr !='' && count($cookie_data_arr) > 0)
						{
							if(isset($cookie_data_arr->time_zone) && $cookie_data_arr->time_zone !='')
							{
								$time_zone = $cookie_data_arr->time_zone;
							}
						}
					}
					*/
				// commented by mustakim for not using cookie
				if($time_zone =='')
				{
					$final_api = 'http://ip-api.com/json/';
					$response_data = $this->callCURL($final_api);
					if($response_data !='')
					{
						$response_data = json_decode($response_data);
						if(isset($response_data->status) && $response_data->status == 'fail')
						{
							$ip = $this->input->ip_address();
							if($ip !='')
							{
								$final_api_call= $final_api.$ip;
								$response_data = $this->callCURL($final_api_call);
								if($response_data !='')
								{
									$response_data = json_decode($response_data);
								}
							}
						}
					}
					if(isset($response_data->timezone) && $response_data->timezone != '')
					{
						$time_zone = $response_data->timezone;
					// commented by mustakim for not using cookie
						// for set cookie for time zone
						/*
							$data_arr = array("time_zone"=>$time_zone);
							$data_arr = json_encode($data_arr);
							$cookie = array(
								'name'   => 'mega_matri_data',
								'value'  => $data_arr,
								'expire' => '864000'
							);
							delete_cookie('mega_matri_data');
							$this->input->set_cookie($cookie);
						*/
						// for set cookie for time zone
					// commented by mustakim for not using cookie
					}
					//print_r($response_data);
				}
				if($time_zone !='')
				{
					$this->session->set_userdata('time_zone', $time_zone);
				}
			}
			else
			{
				$time_zone = $this->session->userdata('time_zone');
			}
			if($time_zone =='')
			{
				$time_zone = 'Asia/Kolkata';
			}
			if(strlen($date) == 10)
			{
				$dformat = str_replace('h:i A','',$dformat);
			}
			$strtime = strtotime($date);
			date_default_timezone_set($time_zone);
			$date_retuen = date($dformat,$strtime);
			date_default_timezone_set('UTC'); // already set in config
			return $date_retuen;
		}
		else
		{
			return $this->data_not_availabel;
		}
	}
	public function display_height($val='')
	{
		$date_retuen = $this->data_not_availabel;
		if($val !='')
		{
			$foot = (int) ($val/12);
			$inch = $val%12;
			$date_retuen = $foot.'ft';
			if($inch > 0)
			{
				$date_retuen = $date_retuen.' '.$inch.'in';
			}
		}
		return $date_retuen;
	}
	public function birthdate_disp($val='')
	{
		$date_retuen = $this->data_not_availabel;
		if($val !='' && $val !='0000-00-00')
		{
			$date_retuen = $this->displayDate($val);
			$date_retuen.= '('.floor((time() - strtotime($val))/31556926).' Years)';
		}
		return $date_retuen;
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
		$this->load->view('back_end/page_part/header',$this->data);
	}
	public function __load_footer($model_body='')
	{
		$this->data['model_body'] = $model_body;
		$this->data['model_title'] = 'Add '.$this->label_page;
		$this->load->view('back_end/page_part/footer',$this->data);
	}
	public function checkLogin()
	{
		if(!$this->session->userdata('matrimonial_user_data') || $this->session->userdata('matrimonial_user_data') =="" && count($this->session->userdata('matrimonial_user_data')) ==0 )
		{
			$base_url = base_url();
			$admin_path = $this->getconfingValue('admin_path');
			redirect($base_url.$admin_path.'/login');
		}
	}
	public function set_table_name($table_name='')
	{
		if($table_name !='')
		{
			$this->table_name = $this->table_name = $table_name;
			$this->table_name_dot = $table_name.'.';
			if($this->display_selected_field =='')
			{
				$this->table_field = $this->db->list_fields($this->table_name);
			}
			else
			{
				$this->table_field = $this->display_selected_field;
			}
			
		}
	}
	function password_hash($password='')
	{
		$this->load->library('phpass');
		$hashed_pass = $this->phpass->hash($password);
		return $hashed_pass;
	}
	function getjson_response()
	{
		$data_return = array();
		if($this->session->flashdata('success_message'))
		{
			$data_return['response'] = '<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('success_message').'</div>';
			$data_return['status']   = 'success';
			$this->session->unset_userdata('success_message');
		}
		else if($this->session->flashdata('error_message'))
		{
			$data_return['status']   = 'error';
			$data_return['response'] = '<div class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('error_message').'</div>';
			$this->session->unset_userdata('error_message');
		}
		$data_return['tocken'] = $this->security->get_csrf_hash();
		return json_encode($data_return);
	}
	public function update_status_var($status)
	{
		$this->status_mode = $status;
		$this->base_url_admin_cm_status = $this->base_url_admin_cm.$status.'/';
	}
	public function get_site_config()
	{
       	$this->db->limit(1);
		$query = $this->db->get_where('site_config', array('id' => 1));
       	return $query->row_array();
	}
	public function get_session_data()
	{
		return $this->session->userdata('matrimonial_user_data');
	}
	public function common_send_email($to_array,$subject,$message,$cc_array= '',$bcc_array ='',$attachment = '')
	{
		$config = array(
		  	'protocol' => 'mail',
		  	'smtp_host' => 'smtp host',	// need to set 
		  	'smtp_port' => 465,
		  	'smtp_user' => 'smtp user', // change it to yours
		  	'mailtype' => 'html',
		  	'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		/* 'smtp_pass' => 'smtp password', // change it to yours */
		
		$config = array(
			'smtp_host' =>'mail.trialme.in',
		  	'smtp_port' =>25,
		  	'smtp_user' =>'jobportal@trialme.in',
		  	'protocol' => 'mail',
		  	'mailtype' => 'html',
		  	'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);
		
        $this->load->library( 'email' ,$config);// , $config //for authenticate email

		$this->email->set_newline("\r\n");
		$config_arra = $this->get_site_config();
		$from_email = $config_arra['from_email'];
		
		$this->email->from($from_email);
		$this->email->to($to_array);
		
		if(isset($cc_array) && $cc_array !="")
		{
			$this->email->cc($cc_array);
		}
		if(isset($bcc_array) && $bcc_array !="")
		{
			$this->email->bcc($bcc_array);
		}
		if(isset($attachment) && $attachment !="")
		{
			$this->email->attach($attachment);
		}
		$this->email->subject($subject);
		$this->email->message($message);
		$msg = 'Email sent.';
		
		$base_url = base_url();
		if($base_url !='http://192.168.1.111/mega_matrimony/')
		{
			if($this->email->send())
			{
				$msg = 'Email sent.';
			}
			else
			{
				//$msg = $this->email->print_debugger();
				//show_error($this->email->print_debugger());
			}
		}
		return $msg;
	}
	public function common_sms_send($mobile,$sms)
	{
		if($mobile !='' && $sms !='')
		{
			$config_arra = $this->get_site_config();
			$sms_api = $config_arra['sms_api'];
			$sms_api_status = $config_arra['sms_api_status'];
			if($sms_api_status !='' && $sms_api_status =='APPROVED' && $sms_api !='')
			{
				$mobile_arr = explode('-',$mobile);
				$mobile_ext ='';
				$mno = '';
				if(isset($mobile_arr[0]) && $mobile_arr[0] !='')
				{
					$mobile_ext = $mobile_arr[0];
				}
				if(isset($mobile_arr[1]) && $mobile_arr[1] !='')
				{
					$mno = $mobile_arr[1];
				}
				//$mobile_ext = substr($mobile,0,3);
				if($mobile_ext == '+91')
				{
					$sms = str_replace(" ","%20",$sms);
					//$mno = substr($mobile,3,15);
					$sms_api = str_replace("##contacts##",$mno,$sms_api);
					$sms_api = str_replace("##sms_text##",$sms,$sms_api);
					$final_api=$sms_api;
					$base_url = base_url();
					if($base_url =='http://192.168.1.111/mega_matrimony/')
					{
						$ch = curl_init($final_api);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
						curl_setopt($ch, CURLOPT_TIMEOUT, 3);
						$curl_scraped_page = curl_exec($ch);
						curl_close($ch);
					}
				}
				else
				{
					// need to uncomment for send sms
					/*require(APPPATH.'twilio_library/Services/Twilio.php');
					$account_sid = "AC81b73d63963ea4405f760264d142e903"; // Your Twilio account sid
					$auth_token = "7dc9ba1f3aa830cb9c330ae75bf16d6a"; // Your Twilio auth token
					$client = new Services_Twilio($account_sid, $auth_token);
					$message = $client->account->messages->sendMessage(
					  '+12267801184', // From a Twilio number in your account
					  $mobile,//'+19054524548', // Text any number
					  $sms
					);*/
						// need to uncomment for send sms
				}
			}
		}
	}
	function last_query()
	{
		return $this->db->last_query();
	}
	function get_count_data_manual($table,$where_arra='',$flag_count_data = 0,$select_f ='',$order_by='',$page='',$limit='',$is_delet_field = 1,$disp_query = "")
	{
		if($table !='')
		{
			if(isset($is_delet_field) && $is_delet_field ==1 && $this->is_delete_fild !='')
			{
				$this->db->where($table.'.'.$this->is_delete_fild,'No');
			}
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
						$this->start = (($page - 1) * $limit);
						//$this->db->where(" id > ".$this->start);
						//$this->db->limit($limit);
						$this->db->limit($limit,$this->start);
					}
					//$this->db->limit(1);
				}
				
				if($disp_query ==1)
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
		$return = false;
		if($table !='' && $data_array !='')
		{
			if($flag_update == 1)
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
	function data_delete_common($table='',$where_arra='',$limit=0,$permenent_delete='')
	{
		$return = false;
		if($permenent_delete !='')
		{
			$this->permenent_delete = $permenent_delete;
		}

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
			if($limit == 1)
			{
				$this->db->limit(1);
			}
			if($this->is_delete_fild !='' && $this->permenent_delete =='no')
			{
				$data_array = array($this->is_delete_fild =>'Yes');
				$return = $this->db->update($table,$data_array);
			}
			else
			{
				$return = $this->db->delete($table);
			}
			// is_deleted
		}
		return $return;
	}
	function getconfingValue($item_name ='')
	{
		$return = '';
		if($item_name !='')
		{
			$return = $this->config->item($item_name);
		}
		return $return;
	}
	function generate_form_main($ele_array = '',$other_config='')
	{
		$table_name = $this->table_name;
		$ele_array_key = array_keys($ele_array);
		if(isset($other_config['mode']) && $other_config['mode'] =='edit' && $table_name !='')
		{
			$where_arr = '';
			$primary_key = $this->primary_key;
			if(isset($primary_key) && $primary_key !='' && isset($other_config['id']) && $other_config['id'] !='')
			{
				$where_arr = array($primary_key => $other_config['id']);
			}
			$select_field = '';
			if(isset($ele_array_key) && $ele_array_key !='' && count($ele_array_key) > 0)
			{
				$table_field = $this->table_field;
				$ele_array_key = array_intersect($ele_array_key,$table_field);
				$select_field = implode(',',$ele_array_key);
			}
			$row_data = $this->get_count_data_manual($table_name,$where_arr,1,$select_field);
			$this->edit_row_data = $row_data;
			if(!isset($row_data) || $row_data =='' || count($row_data) ==0 )
			{
				redirect($this->base_url_admin_cm);
			}
		}
		$element_array = array();
		foreach($ele_array as $key=>$val)
		{
			$temp_array = $val;
			if(isset($other_config['mode']) && $other_config['mode'] =='edit' && isset($row_data[$key]) && $row_data[$key] !='')
			{
				$temp_array['value'] = $row_data[$key];
			}
			if(isset($val['type']) && $val['type'] !='')
			{
				$temp_array['type'] = $val['type'];
			}
			else
			{
				$temp_array['type'] = 'textbox';
			}
			$element_array[$key] = $temp_array;
		}
		return $this->generate_form($element_array,$other_config);
	}
	function is_required($element_array_val)
	{
		$is_required = "";
		if(isset($element_array_val['is_required']) && $element_array_val['is_required'] !='' && $element_array_val['is_required'] =='required')
		{
			$is_required = " required ";
		}
		return $is_required;
	}
	function get_label($element_array_val='',$key='')
	{
		$labelArr = $this->common_model->labelArr;
		
		if(isset($element_array_val['label']) && $element_array_val['label'] !='')
		{
			$label = $element_array_val['label'];
		}
		else if(isset($labelArr[$key]) && $labelArr[$key] !='')
		{
			$label = $labelArr[$key];
		}
		else
		{
			$label = str_replace('_',' ',$key);
			$label = ucwords($label);
		}
		return $label;
	}
	function get_value($element_array_val,$key='value',$defult='')
	{
		$value_curr = $defult;
		if(isset($element_array_val[$key]) && $element_array_val[$key] !='')
		{
			$value_curr = $element_array_val[$key];
		}
		return $value_curr;
	}
	function getRelationDropdown($element_array_val)
	{
		$return_arr = '';
		$value_curr = $this->get_value($element_array_val,'value','');
		$relation_arr = $this->get_value($element_array_val,'relation','');
		$is_multiple = $this->get_value($element_array_val,'is_multiple');
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
				if(isset($relation_arr['rel_col_name']) && $relation_arr['rel_col_name'] !='')
				{
					if(!isset($relation_arr['rel_col_val']) || $relation_arr['rel_col_val'] =='')
					{
						$rel_col_name = $relation_arr['rel_col_name'];
						if(isset($this->edit_row_data[$rel_col_name]) && $this->edit_row_data[$rel_col_name] !='')
						{
							$relation_arr['rel_col_val'] = $this->edit_row_data[$rel_col_name];
						}
					}
					if(isset($relation_arr['rel_col_val']) && $relation_arr['rel_col_val'] !='')
					{
						if($is_multiple !='' && $is_multiple =='yes')
						{
							$rel_val_arr_in = explode(',',$relation_arr['rel_col_val']);
							$this->db->where_in($relation_arr['rel_col_name'],$rel_val_arr_in);
						}
						else
						{
							$this->db->where($relation_arr['rel_col_name'],$relation_arr['rel_col_val']);
						}
					}
				}
				$row_data = $this->get_count_data_manual($relation_arr['rel_table'],"",2,$select_field,$relation_arr['key_disp'].' ASC ',0);
				//print_r($row_data);
				$return_arr = array();
				if(isset($row_data) && $row_data !='' && count($row_data) > 0)
				{
					foreach($row_data as $row_data_val)
					{
						$return_arr[$row_data_val[$relation_arr['key_val']]] = $row_data_val[$relation_arr['key_disp']];
					}
				}
				//print_r($return_arr);
			}
		}
		// $this->get_value($element_array_val,'value','');
		return $return_arr;
	}
	function generate_dropdown($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val,'value','');
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$is_multiple = $this->get_value($element_array_val,'is_multiple');//
			
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
			
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$onChange = $this->get_value($element_array_val,'onchange','');
			$display_placeholder = $this->get_value($element_array_val,'display_placeholder','Yes');
			if($onChange !='')
			{
				$onChange = 'onChange="'.$onChange.'"';
			}
			
			$value_arr = $this->get_value($element_array_val,'value_arr','');
			if(!isset($value_arr) || $value_arr =='' || count($value_arr) ==0)
			{
				$value_arr = $this->getRelationDropdown($element_array_val);
			}
			$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'">
				  	<select '.$is_multi.' '.$onChange.' '.$is_required.' name="'.$key.$is_multi_par.'" id="'.$key.'" class="form-control '.$class.' ">';
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
			$return_content.='
					</select>
				  </div>
				</div>';
		}
		return $return_content;
	}
	function generate_radio($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val,'value','APPROVED');
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$value_arr = $this->get_value($element_array_val,'value_arr',$this->status_arr);
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$onclick = $this->get_value($element_array_val,'onclick');
			if($onclick !='')
			{
				$onclick =' onclick= "'.$onclick.'" ';
			}
			//$this->status_arr = $value_arr;
			$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'">
				  <div class=radio>';
			//print_r($value_arr);
			if(isset($value_arr) && $value_arr !='' && count($value_arr) > 0)
			{
				foreach($value_arr as $key_r=>$value_arr_val)
				{
					$selected_radio = '';
					if($value_curr == $key_r)
					{
						$selected_radio = 'checked';
					}
					$return_content.='<label><input '.$onclick.' '.$selected_radio.' class="'.$class.'" type="radio" name="'.$key.'" id="'.$key_r.'" value="'.$key_r.'">'.$value_arr_val.'</label>&nbsp;&nbsp;';
				}
			}
			$return_content.='
					</div>
				  </div>
				</div>';
		}
		return $return_content;
	}
	function generate_password($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = '';
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$other = $this->get_value($element_array_val,'other');
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			
			if($this->mode =='add')
			{
				$place_holder_pass = 'Password';
			}
			else
			{
				$place_holder_pass = 'Please leave password blank for not update';
				$is_required = '';
			}
			$return_content.='
			<div class="form-group '.$form_group_class.'">
			  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
			  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
				<input '.$other.' minlength="6" type="password" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$place_holder_pass.'" value ="" />
			  </div>
			</div>';
		}
		return $return_content;
	}
	function generate_textbox($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			if(isset($element_array_val['value_imp']) && $element_array_val['value_imp'] !='')
			{
				$value_curr = $element_array_val['value_imp'];
			}
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$input_type = $this->get_value($element_array_val,'input_type','text');
			$other = $this->get_value($element_array_val,'other');
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$placeholder = $this->get_value($element_array_val,'placeholder',$label);
			if($input_type == 'date')
			{
				$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
				  	<div class="input-prepend input-group input-group-lg"> <span class="add-on input-group-addon  common_height_padd"><i class="fa fa-calendar"></i></span>
						<input '.$other.' type="text" '.$is_required.' name="'.$key.'" id="'.$key.'" class="datepicker form-control '.$class.'  common_height_padd " placeholder="'.$label.'" value ="'.htmlentities(stripcslashes($value_curr)).'" data-provide="datepicker" />
					</div>
					
				  </div>
				</div>';
			}
			else
			{
				$check_duplicate = $this->get_value($element_array_val,'check_duplicate','No');
				$onchange_textbox = '';
				if($check_duplicate == 'Yes')
				{
					$table_name = $this->table_name;
					$onchange_textbox = "check_duplicate('$key','$table_name')";
					$onchange_textbox = 'onBlur="'.$onchange_textbox.'"';
				}
				$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.'" >
					<input '.$other.' type="'.$input_type.'" '.$is_required.' name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " '.$onchange_textbox.' placeholder="'.$placeholder.'" value ="'.htmlentities(stripcslashes($value_curr)).'" />
				  </div>
				</div>';
			}
		}
		return $return_content;
	}
	function generate_textarea($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$class = $this->get_value($element_array_val,'class');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			$placeholder = $this->get_value($element_array_val,'placeholder',$label);
			$return_content.='
				<div class="form-group '.$form_group_class.'">
				  <label class="col-sm-'.$this->label_col.' col-lg-'.$this->label_col.' control-label">'.$label.'</label>
				  <div class="col-sm-9 col-lg-'.$this->form_control_col.' '.$key.'_edit" >
				  	<textarea '.$is_required.' rows="4" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " placeholder="'.$placeholder.'">'.$value_curr.'</textarea>
				  </div>
				</div>';
		}
		return $return_content;
	}
	function check_is_img($file_url ='')
	{
		$return = 1;
		$size = getimagesize($file_url);
		if ($size === false)
		{
			$return = 0;
		}
		//if($file_url !='')
		//{
		//	$ext = end(explode(".", $file_url));
		//}
		return $return;
	}
	function generate_file_upload($element_array_val,$key)
	{
		$return_content='';
		if(count($element_array_val) > 0 && $key !='')
		{
			$value_curr = $this->get_value($element_array_val);
			$label = $this->get_label($element_array_val,$key);
			$is_required = $this->is_required($element_array_val);
			$extension = $this->get_value($element_array_val,'extension','jpg|png|jpeg|gif|bmp');
			$path_value = $this->get_value($element_array_val,'path_value','');
			$class = $this->get_value($element_array_val,'class');
			$display_img = $this->get_value($element_array_val,'display_img','Yes');
			$form_group_class = $this->get_value($element_array_val,'form_group_class');
			if($this->mode == 'edit')
			{
				$is_required = '';	
			}
			$img_display = '';
			
			///$is_img = $this->check_is_img($path_value.$value_curr);
			
			if($path_value !='' && $value_curr !='' && file_exists($path_value.$value_curr) && $display_img == 'Yes')
			{
				$img_display = '<img style="max-height:100px" class="img-responsive" src="'.$this->base_url.$path_value.$value_curr.'" />';
			}
			else if($path_value !='' && $value_curr !='' && file_exists($path_value.$value_curr))
			
			{
				$img_display = '<a target="_blank" href="'.$this->base_url.$path_value.$value_curr.'" >View File</a>';
			}
			$return_content.='
				<div class="form-group '.$form_group_class.'">
                  <label class="col-sm-'.$this->label_col.' control-label">'.$label.'</label>
                  <div class=col-sm-4>
                    <input filesize="10" extension="'.$extension.'" '.$is_required.' type="file" name="'.$key.'" id="'.$key.'" class="form-control '.$class.' " />
					<input type="hidden" name="'.$key.'_val" id="'.$key.'_val" value="'.$value_curr.'" />
					<input type="hidden" name="'.$key.'_path" id="'.$key.'_path" value="'.$path_value.'" />
					<input type="hidden" name="'.$key.'_ext" id="'.$key.'_ext" value="'.$extension.'" />
                    <p class=help-block>Allowed File type '.str_replace('|', ' | ',$extension).'.</p>
                  </div>
				  <div class="col-sm-4">
				  	'.$img_display.'
				  </div>
                </div>';
		}
		return $return_content;
	}
	function generate_form_element($element_array = '')
	{
		$return_content='';
		if(isset($element_array) && $element_array !='' && count($element_array) > 0)
		{
			foreach($element_array as $key=>$element_array_val)
			{
				if(isset($element_array_val['type']) && $element_array_val['type'] =='textbox')
				{
					$return_content.=$this->generate_textbox($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='password')
				{
					$return_content.=$this->generate_password($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='textarea')
				{
					$return_content.=$this->generate_textarea($element_array_val,$key);
				}
				else if(isset($element_array_val['type']) && $element_array_val['type'] =='file')
				{
					$return_content.=$this->generate_file_upload($element_array_val,$key);
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
			}
		}
		return $return_content;
	}
	function generate_form($element_array = '',$other_config='')
	{
		$return_content='';
		$action='';
		$onsubmit='';
		$enctype ='';
		$this->mode = $other_config['mode'];

		if(isset($other_config['success_url']) && $other_config['success_url'] !='')
		{
			$this->success_url = $other_config['success_url'];
		}
		if(isset($other_config['action']) && $other_config['action'] !='')
		{
			$action='action="'.$this->base_url_admin.$other_config['action'].'"';
		}
		else if(isset($this->action) && $this->action !='')
		{
			$action='action="'.$this->base_url_admin.$this->action.'"';
		}
		if(isset($other_config['onsubmit']) && $other_config['onsubmit'] !='')
		{
			$onsubmit=' onSubmit="'.$other_config['onsubmit'].'"';
		}
		if(isset($other_config['enctype']) && $other_config['enctype'] !='')
		{
			$enctype = $this->get_value($other_config,'enctype');
		}
		if(isset($other_config['form_id']) && $other_config['form_id'] !='')
		{
			$form_id = $this->get_value($other_config,'form_id');
		}
		else
		{
			$form_id = 'common_insert_update';
		}
		$temp_back = '';
		if(isset($other_config['onback_click']) && $other_config['onback_click'] !='')
		{
			$onback_click = $this->get_value($other_config,'onback_click');
		}
		else
		{
			$class_name = $this->class_name;
			$method_name = $this->method_name;
			$temp_back = $this->base_url_admin_cm_status;
			$onback_click = 'back_list()';
		}
		
		if(isset($element_array) && $element_array !='' && count($element_array) > 0)
		{
			$message_div = '<div id="reponse_message">';
			if($this->session->flashdata('error_message'))
			{
				$message_div.='<div class="alert alert-danger alert-dismissable"><div class="fa fa-warning"></div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('error_message').'</div>';
			}
			if($this->session->flashdata('success_message'))
			{
				$message_div.='<div class="alert alert-success  alert-dismissable"><div class="fa fa-check">&nbsp;</div><a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'.$this->session->flashdata('success_message').'</div>';
			}
			$message_div.='</div>';
			$return_content.='
					  <div class="panel mb25">        
						<div class=panel-body>
						  <div class="row no-margin">
							<div class=col-lg-12>
								<form method="post" id="'.$form_id.'" name="'.$form_id.'" class="form-horizontal bordered-group" role=form '.$action.$onsubmit.' '.$enctype.' >';
			$return_content.=$message_div;
			$return_content.=$this->generate_form_element($element_array);
			$return_content.='
							<div class=form-group>
							  <label class="col-sm-'.$this->label_col.'"></label>
							  <div class="col-sm-9">
							  	<button type="submit" class="btn btn-primary mr10">Submit</button>
							  ';
								if($this->addPopup == 0)
								{
									$return_content.='
										<a href="'.$temp_back.'" type="button" onClick="'.$onback_click.'" class="btn btn-default">Back</a>';
								}
								else
								{
									$return_content.='
										<button type="button" onClick="close_popup()" class="btn btn-default" data-dismiss="modal">Close</button>';
								}
							  $return_content.='</div>
							</div>
							<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" id="hash_tocken_id" class="hash_tocken_id" />
							<input type="hidden" name="mode" value="'.$other_config['mode'].'" id="mode" />
							<input type="hidden" name="id" value="'.$other_config['id'].'" id="id" />
							<input type="hidden" name="success_url" value="'.$this->success_url.'" id="success_url" />
						</form>
						</div>
					  </div>
					</div>
				  </div>';
		}
		return $return_content;
	}
	public function generate_url_comon($generate_url='')
	{
		$return_url='';
		if($generate_url !='')
		{
			$generate_url_arr = explode('-|-',$generate_url);
			if(isset($generate_url_arr) && $generate_url_arr !='' && count($generate_url_arr) >0)
			{
				$from_gen = '';
				$to_gen = '';
				if(isset($generate_url_arr[0]) && $generate_url_arr[0] !='')
				{
					$from_gen = $generate_url_arr[0];
				}
				if(isset($generate_url_arr[1]) && $generate_url_arr[1] !='')
				{
					$to_gen = $generate_url_arr[1];
				}
				if($from_gen !='' && $to_gen !='')
				{
					$from_gen_val='';
					if($this->input->post($from_gen))
					{
						$from_gen_val = $this->input->post($from_gen);
					}
					if($from_gen_val !='')
					{
						$_REQUEST[$to_gen] = $url_genrate = strtolower(url_title($from_gen_val));
					}
				}
			}
		}
		$return_url = strtolower($return_url);
		return $return_url;
	}
	public function save_update_data($retuen_json=1,$is_retur_stop='')
	{
		/*print_r($_REQUEST);
		print_r($_FILES);
		exit;*/
		$table_name = $this->table_name;
		$table_field = $this->table_field;
		$primary_key = $this->primary_key;
		if($this->input->post('success_url'))
		{
			$this->success_url = $this->input->post('success_url');
		}
		if($table_name !='' && $table_field !='' && count($table_field) > 0 )
		{
			$where_arra='';
			$where_arra_dup='';
			$flag_update = 0;
			$limit = '';
			$data_array = array();
			$data_file_old_array = array();
			$data_file_new_array = array();
			$mode = 'add';
			$id = '';
			$is_duplicate = 0;
			//error_reporting(E_ALL);
			//echo '<pre>';
			//print_r($_FILES);
			//echo '</pre>';
			//exit;
			// for check edit mode
			if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='' && $_REQUEST['mode'] =='edit')
			{
				$mode = 'edit';
				if($this->input->post('id'))
				{
					$id = trim($this->input->post('id'));
				}
				if($id !='')
				{
					$where_arra = array($primary_key =>$id);
					//$where_arra_dup = "'".$primary_key .' != '.$id."'";
					$where_arra_dup = $primary_key ." != '".$id."'";
					// $this->db->where($primary_key .' != '.$id); // for duplicate check with id
					$limit = 1;
				}
				$flag_update = 1;
			}
			if($this->field_duplicate !='')
			{
				$filed_dup_check = $this->field_duplicate;
				if(isset($filed_dup_check) && $filed_dup_check !='' && count($filed_dup_check) > 0)
				{
					$this->db->group_start();
					foreach($filed_dup_check as $filed_dup_check_val)
					{
						if($this->input->post($filed_dup_check_val))
						{
							$filed_dup_check_val_fill = $this->input->post($filed_dup_check_val);
							if($filed_dup_check_val_fill !='' && $filed_dup_check_val !='')
							{
								
								if(isset($this->dup_where_con) && $this->dup_where_con !='' && $this->dup_where_con =='and')
								{
									$this->db->where($filed_dup_check_val,$filed_dup_check_val_fill);
								}
								else
								{
									$this->db->or_where($filed_dup_check_val,$filed_dup_check_val_fill);
								}
							}
						}
					}
					$this->db->group_end();
					$cound_duplicate = $this->get_count_data_manual($this->table_name,$where_arra_dup,0,$this->table_name_dot.$this->primary_key);
					$this->db->last_query();
					if($cound_duplicate > 0)
					{
						$is_duplicate = 1;
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
				if(isset($_FILES) && $_FILES !='' && count($_FILES) > 0)
				{
					foreach($_FILES as $key=>$val)
					{
						if(in_array($key,$table_field) && isset($val['name']) && $val['name'] !='' && isset($val['size']) && $val['size'] > 0)
						{
							$path_upload = '';
							if($this->input->post($key.'_path'))
							{
								$path_upload = trim($this->input->post($key.'_path'));
							}
							$old_upload = '';
							if($this->input->post($key.'_val'))
							{
								$old_upload = trim($this->input->post($key.'_val'));
							}
							$allowed_types ='gif|jpg|png|jpeg|bmp';
							if(isset($_REQUEST[$key.'_ext']) && $_REQUEST[$key.'_ext'] !='')
							{
								$allowed_types = trim($_REQUEST[$key.'_ext']);
							}
							$temp_data_array = array('file_name'=>$key,'upload_path'=>$path_upload,'allowed_types'=>$allowed_types);
							$upload_data = $this->upload_file($temp_data_array);
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
								$this->session->set_flashdata('error_message',$upload_data['error_message']); /*$this->success_message['error_file']*/
								return;
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
							$val = trim($this->security->xss_clean($val));
							$data_array[$key] = $val;
						}
					}
				}
				if($mode =='add')
				{
					if(isset($this->created_on_fild) && $this->created_on_fild !='' && in_array($this->created_on_fild,$table_field))
					{
						$data_array[$this->created_on_fild] = $this->getCurrentDate();
					}
				}
				// for request field and add
				if($data_array !='' && count($data_array) > 0)
				{
					$response = $this->update_insert_data_common($table_name,$data_array,$where_arra,$flag_update,$limit);
					if($mode =='add')
					{
						$this->last_insert_id = $this->db->insert_id();
					}
					if($response)
					{
						$success_message = $this->success_message[$mode];
						$this->delete_file($data_file_old_array);
						$this->session->set_flashdata('success_message', $success_message);
					}
					else
					{
						$this->delete_file($data_file_new_array);
						$this->session->set_flashdata('error_message', $this->success_message['error']);
					}
				}
			}
			else
			{
				$this->session->set_flashdata('error_message', "Duplicate data found.");
			}
		}
		if(isset($is_retur_stop) && $is_retur_stop != '' && $is_retur_stop == 1 )
		{
			$data = $this->common_model->getjson_response();
			return $data;
		}
		$is_ajax = 0;
		if($this->input->post('is_ajax'))
		{
			$is_ajax = $this->input->post('is_ajax');
		}
		if($is_ajax == 0)
		{
			if(isset($this->success_url) && $this->success_url !='')
			{
				redirect($this->base_url_admin.$this->class_name.'/'.$this->success_url);
			}
		}
		else
		{
			$data['data'] = $this->common_model->getjson_response();
			if($retuen_json == 1)
			{
				$this->load->view('common_file_echo',$data);
			}
			else
			{
				return $data;
			}
		}
	}
	public function upload_file($upload_data = '')
	{
		$return_message = '';
		if(isset($upload_data) && $upload_data !='' && count($upload_data) > 0 && isset($upload_data['upload_path']) && $upload_data['upload_path'] !='' && isset($upload_data['file_name']) && $upload_data['file_name'] !='')
		{	

			$config	= array();
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
			}
			else
			{
				$return_message = array('status'=>'success','file_data'=>$this->upload->data());
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
	// for generate datatabel common
	
	public function rander_filed()
	{
		foreach($this->table_field as $temp_filed)
		{
			if(!in_array($temp_filed,$this->data_tabel_filedIgnore))
			{
				$this->data_tabel_filed[] = $temp_filed;
			}
		}
	}
	
	public function set_page_number()
	{
		if($this->input->post('page_number'))
		{
			$page_number = $this->input->post('page_number');
			$this->page_number = $page_number;
		}
	}
	public function set_limitper_page()
	{
		if($this->input->post('limit_per_page'))
		{
			$limit_per_page = $this->input->post('limit_per_page');
		}
		else
		{
			$config_pag = $this->getconfingValue('config_pag');
			if(isset($config_pag['per_page']) && $config_pag['per_page'] !='')
			{
				$limit_per_page = $config_pag['per_page'];
			}
			else
			{
				$limit_per_page = 10;
			}
		}
		$this->limit_per_page = $limit_per_page;
	}
	public function add_limit_per_page()
	{
		$this->set_limitper_page();
		$this->set_page_number();
		//if($this->page_number !='')
		//{
			//$this->start = (($this->page_number - 1) * $this->limit_per_page);
		//}
		//$this->db->limit($this->limit_per_page,$this->start);
	}
	public function search_session()
	{
		if($this->table_name =='jobseeker_view' && $this->session->userdata('js_save_search') && $this->session->userdata('js_save_search') !="" )
		{
			$js_save_search = $this->session->userdata('js_save_search');
			//print_r($js_save_search);
			if(isset($js_save_search['keyword']) && $js_save_search['keyword'] !='')
			{
				$keyword = $js_save_search['keyword'];
				$keyword_search = " ( fullname like '%$keyword%' or mobile like '%$keyword%' or email like '%$keyword%' or home_city like '%$keyword%' or profile_summary like '%$keyword%' or resume_headline like '%$keyword%'  or key_skill like '%$keyword%' ) ";
				$this->db->where($keyword_search);
			}
			if(isset($js_save_search['industry']) && $js_save_search['industry'] !='')
			{
				$industry = $js_save_search['industry'];
				if(is_array($industry) && count($industry) > 0)
				{
					$this->db->where_in('industry',$industry);
				}
			}
			if(isset($js_save_search['functional_area']) && $js_save_search['functional_area'] !='')
			{
				$functional_area = $js_save_search['functional_area'];
				if(is_array($functional_area) && count($functional_area) > 0)
				{
					$this->db->where_in('functional_area',$functional_area);
				}
			}
			if(isset($js_save_search['job_role']) && $js_save_search['job_role'] !='')
			{
				$job_role = $js_save_search['job_role'];
				if(is_array($job_role) && count($job_role) > 0)
				{
					$this->db->where_in('job_role',$job_role);
				}
			}
			if(isset($js_save_search['total_exp_from']) && $js_save_search['total_exp_from'] !='')
			{
				$total_exp_from = $js_save_search['total_exp_from'];
				$total_exp_from = " ( total_experience >='$total_exp_from') ";
				$this->db->where($total_exp_from);
			}
			if(isset($js_save_search['total_exp_to']) && $js_save_search['total_exp_to'] !='')
			{
				$total_exp_to = $js_save_search['total_exp_to'];
				$total_exp_to = " ( total_experience <='$total_exp_to') ";
				$this->db->where($total_exp_to);
			}
			
			if(isset($js_save_search['annual_salary_from']) && $js_save_search['annual_salary_from'] !='')
			{
				$annual_salary_from = $js_save_search['annual_salary_from'];
				$annual_salary_from = " ( annual_salary >='$annual_salary_from' ) ";
				$this->db->where($annual_salary_from);
			}
			if(isset($js_save_search['annual_salary_to']) && $js_save_search['annual_salary_to'] !='')
			{
				$annual_salary_to = $js_save_search['annual_salary_to'];
				$annual_salary_to = " ( annual_salary <='$annual_salary_to' ) ";
				$this->db->where($annual_salary_to);
			}
			if(isset($js_save_search['exp_annual_salary_from']) && $js_save_search['exp_annual_salary_from'] !='')
			{
				$exp_annual_salary_from = $js_save_search['exp_annual_salary_from'];
				$exp_annual_salary_from = " ( expected_annual_salary >='$exp_annual_salary_from' ) ";
				$this->db->where($exp_annual_salary_from);
			}
			if(isset($js_save_search['exp_annual_salary_to']) && $js_save_search['exp_annual_salary_to'] !='')
			{
				$exp_annual_salary_to = $js_save_search['exp_annual_salary_to'];
				$exp_annual_salary_to = " ( expected_annual_salary <='$exp_annual_salary_to' ) ";
				$this->db->where($exp_annual_salary_to);
			}
		}
		else if($this->table_name =='employer_master_view' && $this->session->userdata('emp_save_search') && $this->session->userdata('emp_save_search') !="" )
		{
			$js_save_search = $this->session->userdata('emp_save_search');
			//print_r($js_save_search);
			if(isset($js_save_search['keyword']) && $js_save_search['keyword'] !='')
			{
				$keyword = $js_save_search['keyword'];
				$keyword_search = " ( fullname like '%$keyword%' or mobile like '%$keyword%' or email like '%$keyword%' or personal_email like '%$keyword%' or job_profile like '%$keyword%' or company_name like '%$keyword%' ) ";
				$this->db->where($keyword_search);
			}
			if(isset($js_save_search['industry']) && $js_save_search['industry'] !='')
			{
				$industry = $js_save_search['industry'];
				if(is_array($industry) && count($industry) > 0)
				{
					$this->db->where_in('industry',$industry);
				}
			}
			if(isset($js_save_search['country']) && $js_save_search['country'] !='')
			{
				$country = $js_save_search['country'];
				$this->db->where_in('country',$country);
			}
			if(isset($js_save_search['city']) && $js_save_search['city'] !='')
			{
				$city = $js_save_search['city'];
				$this->db->where_in('city',$city);
			}
			if(isset($js_save_search['company_type']) && $js_save_search['company_type'] !='' && $js_save_search['company_type'] !='All')
			{
				$company_type = $js_save_search['company_type'];
				$this->db->where_in('company_type',$company_type);
			}
			
			if(isset($js_save_search['industry_hire']) && $js_save_search['industry_hire'] !='')
			{
				$industry_hire = $js_save_search['industry_hire'];
				if(is_array($industry_hire) && count($industry_hire) > 0)
				{
					$temp_arra = array();
					foreach($industry_hire as $fun_area)
					{
						$temp_arra[] = 'FIND_IN_SET("'.$fun_area.'",industry_hire)';
					}
					$temp_arra = "( ".implode(' OR ',$temp_arra) ." ) ";
					$this->db->where($temp_arra);
				}
			}
			if(isset($js_save_search['functional_area_hire']) && $js_save_search['functional_area_hire'] !='')
			{
				$functional_area_hire = $js_save_search['functional_area_hire'];
				if(is_array($functional_area_hire) && count($functional_area_hire) > 0)
				{
					$temp_arra = array();
					foreach($functional_area_hire as $fun_area)
					{
						$temp_arra[] = 'FIND_IN_SET("'.$fun_area.'",function_area_hire)';
					}
					$temp_arra = "( ".implode(' OR ',$temp_arra) ." ) ";
					$this->db->where($temp_arra);
				}
			}
			if(isset($js_save_search['designation']) && $js_save_search['designation'] !='')
			{
				$designation = $js_save_search['designation'];
				if(is_array($designation) && count($designation) > 0)
				{
					$temp_arra = array();
					foreach($designation as $fun_area)
					{
						$temp_arra[] = 'FIND_IN_SET("'.$fun_area.'",designation)';
					}
					$temp_arra = "( ".implode(' OR ',$temp_arra) ." ) ";
					$this->db->where($temp_arra);
				}
			}
		}
		else if($this->table_name =='job_posting_view' && $this->session->userdata('job_save_search') && $this->session->userdata('job_save_search') !="" )
		{
			$js_save_search = $this->session->userdata('job_save_search');
			//print_r($js_save_search);
			if(isset($js_save_search['keyword']) && $js_save_search['keyword'] !='')
			{
				$keyword = $js_save_search['keyword'];
				$keyword_search = " ( job_title like '%$keyword%' or job_description like '%$keyword%' or skill_keyword like '%$keyword%' or company_hiring like '%$keyword%' or posted_by_employee like '%$keyword%' or company_name like '%$keyword%' ) ";
				$this->db->where($keyword_search);
			}
			if(isset($js_save_search['industry_search']) && $js_save_search['industry_search'] !='')
			{
				$industry = $js_save_search['industry_search'];
				if(is_array($industry) && count($industry) > 0)
				{
					$this->db->where_in('job_industry',$industry);
				}
			}
			if(isset($js_save_search['functional_area_search']) && $js_save_search['functional_area_search'] !='')
			{
				$functional_area = $js_save_search['functional_area_search'];
				if(is_array($functional_area) && count($functional_area) > 0)
				{
					$this->db->where_in('functional_area',$functional_area);
				}
			}
			if(isset($js_save_search['job_role_search']) && $js_save_search['job_role_search'] !='')
			{
				$job_role = $js_save_search['job_role_search'];
				if(is_array($job_role) && count($job_role) > 0)
				{
					$this->db->where_in('job_post_role',$job_role);
				}
			}
			if(isset($js_save_search['total_exp_from']) && $js_save_search['total_exp_from'] !='')
			{
				$total_exp_from = $js_save_search['total_exp_from'];
				$total_exp_from = " ( work_experience_from >='$total_exp_from') ";
				$this->db->where($total_exp_from);
			}
			if(isset($js_save_search['total_exp_to']) && $js_save_search['total_exp_to'] !='')
			{
				$total_exp_to = $js_save_search['total_exp_to'];
				$total_exp_to = " ( work_experience_to <='$total_exp_to') ";
				$this->db->where($total_exp_to);
			}
			
			if(isset($js_save_search['annual_salary_from']) && $js_save_search['annual_salary_from'] !='')
			{
				$annual_salary_from = $js_save_search['annual_salary_from'];
				$annual_salary_from = " ( job_salary_from >='$annual_salary_from' ) ";
				$this->db->where($annual_salary_from);
			}
			if(isset($js_save_search['annual_salary_to']) && $js_save_search['annual_salary_to'] !='')
			{
				$annual_salary_to = $js_save_search['annual_salary_to'];
				$annual_salary_to = " ( job_salary_to <='$annual_salary_to' ) ";
				$this->db->where($annual_salary_to);
			}
			if(isset($js_save_search['job_shift_search']) && $js_save_search['job_shift_search'] !='')
			{
				$job_role = $js_save_search['job_shift_search'];
				if(is_array($job_role) && count($job_role) > 0)
				{
					$this->db->where_in('job_shift',$job_role);
				}
			}
			if(isset($js_save_search['job_type_search']) && $js_save_search['job_type_search'] !='')
			{
				$job_role = $js_save_search['job_type_search'];
				if(is_array($job_role) && count($job_role) > 0)
				{
					$this->db->where_in('job_type',$job_role);
				}
			}
			if(isset($js_save_search['job_location_search']) && $js_save_search['job_location_search'] !='')
			{
				$functional_area_hire = $js_save_search['job_location_search'];
				if(is_array($functional_area_hire) && count($functional_area_hire) > 0)
				{
					$temp_arra = array();
					foreach($functional_area_hire as $fun_area)
					{
						$temp_arra[] = 'FIND_IN_SET("'.$fun_area.'",location_hiring)';
					}
					$temp_arra = "( ".implode(' OR ',$temp_arra) ." ) ";
					$this->db->where($temp_arra);
				}
			}
		}
		
		
	}
	public function add_where_rander()
	{
		$this->search_session();
		if($this->input->post('search_filed'))
		{
			$search_filed = trim($this->input->post('search_filed'));
			$search_filed = $this->db->escape_str($search_filed);
			$this->search_filed = $search_filed;
			
			if($search_filed !='')
			{
				$temp_search = array();
				foreach($this->table_field as $temp_filed)
				{
					$temp_filed = $this->table_name_dot.$temp_filed;
					$temp_search[] = " $temp_filed like '%$search_filed%' ";
				}
				
				$join_tab_rel = $this->join_tab_array;
				if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
				{
					foreach($join_tab_rel as $join_tab_rel_val)
					{
						
						$temp_filed = $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'];
						$temp_search[] = " $temp_filed like '%$search_filed%' ";
						
						if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
						{
							foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
							{
								$temp_filed = $join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val;
								$temp_search[] = " $temp_filed like '%$search_filed%' ";
							}
						}
					}
				}
				
				if(isset($temp_search) && $temp_search !='' && count($temp_search)>0)
				{
					$temp_search_str = implode(" OR ",$temp_search);
					$this->db->where("( $temp_search_str )");
				}
			}
		}
		if($this->input->post('status_mode'))
		{
			$this->status_mode = trim($this->input->post('status_mode'));
		}
		if(isset($this->status_mode) && $this->status_mode !='' && $this->status_mode !='ALL' && $this->status_field !='')
		{
			$this->db->where($this->table_name_dot.$this->status_field,$this->status_mode);
		}
	}
	public function add_personal_where()
	{
		$other_config_data = $this->common_model->other_config;
		if(isset($other_config_data['personal_where']) && $other_config_data['personal_where'] !='')
		{
			$personal_where = $other_config_data['personal_where'];
			$this->db->where($personal_where);
		}
	}
	public function rander_data()
	{
		$this->add_personal_where();
		$this->add_where_rander();
		$this->add_limit_per_page();
		$this->setJoinTable();
		
		$select_field = $this->table_name_dot.'*';
		$temp_select_join_filed = array();
		$temp_select_join_filed[] = $select_field;
		$join_tab_rel = $this->join_tab_array;
		if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
		{
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				$temp_select_join_filed[] = $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'];
				if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
				{
					foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
					{
						$temp_select_join_filed[] = $join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val;
					}
				}
			}
		}
		if(isset($temp_select_join_filed) && $temp_select_join_filed !='' && count($temp_select_join_filed) > 0)
		{
			$select_field = implode(',',$temp_select_join_filed);
		}
		$row_data = $this->get_count_data_manual($this->table_name,'',2,$select_field,'',$this->page_number,$this->limit_per_page);
		//echo $this->last_query();
		
		if(isset($row_data) && $row_data !='' && count($row_data) > 0)
		{
			$this->data_tabel_data = $row_data;
		}
	}
	public function rander_data_all_count()
	{
		$this->add_personal_where();
		$this->setJoinTable();
		$data_tabel_all_count = $this->get_count_data_manual($this->table_name,'',0,$this->table_name_dot.$this->primary_key);
		//echo $this->last_query();
		if(isset($data_tabel_all_count) && $data_tabel_all_count !='' && $data_tabel_all_count > 0)
		{
			$this->data_tabel_all_count = $data_tabel_all_count;
		}
	}
	public function rander_data_filtered_count()
	{
		$this->add_personal_where();
		$this->add_where_rander();
		$this->setJoinTable();
		$row_data_count = $this->get_count_data_manual($this->table_name,'',0,$this->table_name_dot.$this->primary_key);
		//echo $this->last_query();
		if(isset($row_data_count) && $row_data_count !='' && $row_data_count > 0)
		{
			$this->data_tabel_filtered_count = $row_data_count;
		}
	}
	public function rander_pagination()
	{
		$this->load->library('pagination');
		$config = $this->getconfingValue('config_pag');
		$config['base_url'] = $this->base_url_admin_cm_status;
		$config['per_page'] = $this->limit_per_page;
		$config['total_rows'] = $this->data_tabel_filtered_count;
		$this->pagination->initialize($config);
		$this->pagination_link = $this->pagination->create_links();
	}
	public function rander_order_sort()
	{
		$order = 'ASC';
		$data_table_parameter = $this->data_table_parameter;
		
		if($this->input->post('default_sort'))
		{
			$default_sort = trim($this->input->post('default_sort'));
			if(isset($default_sort) && $default_sort !='')
			{
				$data_table_parameter['default_sort'] = $default_sort;
			}
		}		
		if($this->input->post('default_order'))
		{
			$default_order = trim($this->input->post('default_order'));
			if(isset($default_order) && $default_order !='')
			{
				$data_table_parameter['default_order'] = $default_order;
			}
		}
		if(isset($data_table_parameter['default_sort']) && $data_table_parameter['default_sort'] !='')
		{
			if(isset($data_table_parameter['default_order']) && $data_table_parameter ['default_order'] !='')
			{
				$order = $data_table_parameter['default_order'];
			}
			else
			{
				$data_table_parameter['default_order'] = $order;
			}
		}
		else
		{
			$data_table_parameter['default_sort'] = $this->primary_key;
		}
		$this->data_table_parameter = $data_table_parameter;
		if(isset($data_table_parameter['default_order']) && $data_table_parameter['default_order'] !='' && $order !='')
		{
			$join_tab_rel = $this->join_tab_array;
			$order_from_main_table = 1;
			if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
			{
				foreach($join_tab_rel as $join_tab_rel_val)
				{
					if(isset($join_tab_rel_val['rel_filed_disp']) && $join_tab_rel_val['rel_filed_disp'] !='' && $join_tab_rel_val['rel_filed_disp'] == $data_table_parameter['default_sort'])
					{
						$order_from_main_table = 0;
						$this->db->order_by($join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed_disp'], $order);
						break;
					}
					if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='' && count($join_tab_rel_val['rel_filed_search_disp']) > 0)
					{
						foreach($join_tab_rel_val['rel_filed_search_disp'] as $rel_filed_search_disp_val)
						{
							if(isset($rel_filed_search_disp_val) && $rel_filed_search_disp_val !='' && $rel_filed_search_disp_val == $data_table_parameter['default_sort'])
							{
								$order_from_main_table = 0;
								$this->db->order_by($join_tab_rel_val['rel_table'].'.'.$rel_filed_search_disp_val, $order);
								break;
							}
						}
						if($order_from_main_table == 0)
						{
							break;
						}
					}
				}
			}
			
			if($order_from_main_table == 1 )
			{
				$this->db->order_by($this->table_name_dot.$data_table_parameter['default_sort'], $order);
			}
		}
	}
	function setJoinTable()
	{
		$join_tab_rel = $this->join_tab_array;
		if(isset($join_tab_rel) && $join_tab_rel !='' && count($join_tab_rel) > 0)
		{
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				$default_join = 'left';
				if(isset($join_tab_rel_val['join_type']) && $join_tab_rel_val['join_type'] !='')
				{
					$default_join = $join_tab_rel_val['join_type'];
				}
				if(isset($join_tab_rel_val['join_manual']) && $join_tab_rel_val['join_manual'] !='' )
				{
					$this->db->join($join_tab_rel_val['rel_table'],$join_tab_rel_val['join_manual'], $default_join);
				}
				else if(isset($join_tab_rel_val['rel_table']) && $join_tab_rel_val['rel_table'] !='' && isset($join_tab_rel_val['rel_filed']) && $join_tab_rel_val['rel_filed'] !='' && isset($join_tab_rel_val['rel_filed_org']) && $join_tab_rel_val['rel_filed_org'] !='')
				{
					$this->db->join($join_tab_rel_val['rel_table'], $join_tab_rel_val['rel_table'].'.'.$join_tab_rel_val['rel_filed']." = ".$this->table_name_dot.$join_tab_rel_val['rel_filed_org'], $default_join);
				}
			}
		}
	}
	public function rander_dataTable($page='1',$parameter = '')
	{
		if($parameter !='')
		{
			$this->data_table_parameter = $parameter;
		}		
		$this->page_number = $page;
		$this->rander_filed();
		$this->rander_order_sort();
		$this->rander_data();
		
			// $this->last_query();
			
		$this->rander_data_filtered_count();
		
		$this->rander_pagination();
		$data[] = $this->data;
		$this->rander_data_all_count();
		$this->load->view('back_end/data_table',$data);
	}
	// for generate datatabel common
	public function update_status_check()
	{
		if($this->input->post('status_update'))
		{
			$status_update = $this->input->post('status_update');
			if($status_update !='')
			{
				$this->save_update_status();
			}
		}
	}
	public function save_update_status()
	{
		if($this->input->post('status_update') && $this->input->post('selected_val'))
		{
			$status_update = trim($this->input->post('status_update'));
			$selected_val = $this->input->post('selected_val');
			if($status_update !='' && $selected_val !='' && count($selected_val) > 0 )
			{
				$this->db->where_in($this->primary_key, $selected_val);
				if($status_update =='DELETE')
				{
					$response = $this->data_delete_common($this->table_name);
					$mode= 'delete';
				}
				else
				{
					if(in_array($status_update,$this->status_arr))
					{
						$data_array = array($this->status_column=>$status_update);
						$response = $this->update_insert_data_common($this->table_name,$data_array,'',1,0);
						$mode= 'edit';
					}
				}
				if($response)
				{
					$success_message = $this->success_message[$mode];
					$this->session->set_flashdata('success_message', $success_message);
				}
				else
				{
					$this->session->set_flashdata('error_message', $this->success_message['error']);
				}
				//else if()
			}
		}
		
	}
	
	public function add_data_common($ele_array='',$mode = 'add', $id='')
	{
		$other_config = array('mode'=>$mode,'id'=>$id); // define here some parameter form generate
		return $this->generate_form_main($ele_array,$other_config);
	}
	public function addJoin_tab_arr($join_tab_rel='')
	{
		if($join_tab_rel !='')
		{
			$this->join_tab_array = $join_tab_rel;
			foreach($join_tab_rel as $join_tab_rel_val)
			{
				if(isset($join_tab_rel_val['rel_filed_org']) && $join_tab_rel_val['rel_filed_org'] !='')
				{
					$this->filed_notdisp[] = $join_tab_rel_val['rel_filed_org'];
				}
				if(isset($join_tab_rel_val['rel_filed_disp']) && $join_tab_rel_val['rel_filed_disp'] !='')
				{
					$this->join_tab_array_filed_disp[] = $join_tab_rel_val['rel_filed_disp'];
				}
				if(isset($join_tab_rel_val['rel_filed_search_disp']) && $join_tab_rel_val['rel_filed_search_disp'] !='')
				{
					$rel_filed_search_disp = $join_tab_rel_val['rel_filed_search_disp'];
					foreach($rel_filed_search_disp as $rel_filed_search_disp_val)
					{
						$this->join_tab_array_filed_disp[] = $rel_filed_search_disp_val;
					}
				}
			}
		}
	}
	public function common_rander($table_name='',$status ='ALL', $page =1,$label_page='',$ele_array='',$sort_column='',$addPopup=0,$other_config='',$join_tab_rel = '')
	{
		$this->other_config = $other_config;
		$this->ele_array = $ele_array;
		// here common and imported setting
			$this->table_name = $table_name; 	// *need to set here tabel name //
			$this->set_table_name($this->table_name);
			$this->label_page = $label_page;
		// here common and imported setting
		if(isset($other_config['field_duplicate']) && $other_config['field_duplicate'] !='')
		{
			$this->field_duplicate = $other_config['field_duplicate'];
		}
		if(isset($status) && $status == 'save-data')
		{
			$this->save_update_data();
		}
		else if(isset($status) && ($status == 'add-data' || $status == 'edit-data'))
		{
			$id='';
			$mode ='add';
			if($status == 'edit-data')
			{
				$id = $page;
				$mode ='edit';
			}
			$other_config['mode'] = $mode;
			$other_config['id'] = $id;
			$this->data['data'] = $this->generate_form_main($ele_array,$other_config);
			$this->__load_header(ucfirst($mode).' '.$this->label_page);
			$this->load->view('common_file_echo',$this->data);
			$this->__load_footer();
		}
		else
		{
		// for setting join table
			if(isset($join_tab_rel) && $join_tab_rel !='')
			{
				$this->addJoin_tab_arr($join_tab_rel);
			}
		// for setting join table
			$is_ajax = 0;
			if($this->input->post('is_ajax'))
			{
				$is_ajax = $this->input->post('is_ajax');
			}

			$this->update_status_check();
			
			if($is_ajax == 0)
			{
				$this->__load_header('Manage '.$this->label_page,$status);
			}
			
			$this->update_status_var($status);
			
			if($addPopup == 1)
			{
				$this->addPopup = 1; // for display pop up
			}
			
			$default_order = 'ASC';
			if(isset($other_config['default_order']) && $other_config['default_order'] !='')
			{
				$default_order = $other_config['default_order'];
			}

			if(isset($other_config['filed_notdisp']) && $other_config['filed_notdisp'] !='')
			{
				foreach($other_config['filed_notdisp'] as $filed_notdisp)
				$this->filed_notdisp[] = $filed_notdisp;
			}
			
			$parameter = array('default_sort'=>$sort_column,'default_order'=>$default_order); // set default sort coloumn name
			
			$this->rander_dataTable($page,$parameter);
			
			if($is_ajax == 0)
			{
				$this->label_col = 3;	 // for pop up
				$model_body = '';
				if($addPopup == 1)
				{
					$other_config['mode'] = 'add';
					$other_config['id'] = '';
					$model_body = $this->generate_form_main($ele_array,$other_config);
					//$model_body = $this->add_data_common($ele_array); // for pop up
				}
				$this->__load_footer($model_body);
			}
			else
			{
				if($this->js_extra_code !='')
				{
					$data['data_javascript'] = $this->js_extra_code;
					$this->load->view('common_file_echo',$data);
				}
			}
		}
	}
	public function return_tocken_clear($clear_session='',$return='yes')
	{
		if($clear_session !='')
		{
			$this->session->unset_userdata($clear_session);
		}
		if($return =='yes')
		{
			$data_return = array();
			$data_return['status'] = 'success';
			$data_return['tocken'] = $this->security->get_csrf_hash();
			$data['data'] =  json_encode($data_return);
			$this->load->view('common_file_echo',$data);
		}
	}
	function xss_clean($val='')
	{
		if($val !='')
		{
			$val = trim($this->security->xss_clean($val));
		}
		return $val;
	}
	function update_plan_member($js_id='',$plan_id='')
	{
		$return_resp = 'fail';
		if($plan_id !='' && $js_id !='')
		{
			$plan_data = $this->common_model->get_count_data_manual('credit_plan_jobseeker',array('id'=>$plan_id),1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
			{
				// update old plan to current plan no
					$data_array = array('current_plan'=>'No');
					$where_arra = array('js_id'=>$js_id,'current_plan'=>'Yes');
					$this->update_insert_data_common('plan_jobseeker',$data_array,$where_arra,1,0);
				// update old plan to current plan no
				$config_data = $this->data['config_data'];
				// $this->get_site_config();
				$service_tax_per = 0;
				$service_tax=0;
				$plan_amount = 0;
				$final_amount = 0;
				$plan_duration = 0;
				$coupan_code = '';
				$discount_amount = 0;
				$activated_on = $this->getCurrentDate('Y-m-d');
				$expired_on = $activated_on;
				$transaction_id ='';
				$payment_method ='';
				$payment_note = '';
				if(isset($_REQUEST['coupan_code']) && $_REQUEST['coupan_code'] !='')
				{
					$coupan_code = $this->xss_clean($_REQUEST['coupan_code']);
				}
				if(isset($_REQUEST['discount_amount']) && $_REQUEST['discount_amount'] !='')
				{
					$discount_amount = $this->xss_clean($_REQUEST['discount_amount']);
				}
				if(isset($_REQUEST['transaction_id']) && $_REQUEST['transaction_id'] !='')
				{
					$transaction_id = $this->xss_clean($_REQUEST['transaction_id']);
				}
				if(isset($_REQUEST['payment_method']) && $_REQUEST['payment_method'] !='')
				{
					$payment_method = $this->xss_clean($_REQUEST['payment_method']);
				}
				if(isset($_REQUEST['payment_note']) && $_REQUEST['payment_note'] !='')
				{
					$payment_note = $this->xss_clean($_REQUEST['payment_note']);
				}
				if(isset($plan_data['plan_duration']) && $plan_data['plan_duration'] !='')
				{
					$plan_duration = $plan_data['plan_duration'];
				}
				if(isset($plan_duration) && $plan_duration !='' && $activated_on !='')
				{
					$date_exp = strtotime(date("Y-m-d", strtotime($activated_on)) . + $plan_duration." day");
					$expired_on = date('Y-m-d', $date_exp);
				}
				if(isset($plan_data['plan_amount']) && $plan_data['plan_amount'] !='')
				{
					$plan_amount = $plan_data['plan_amount'];
					$final_amount = $plan_amount;
				}
				if(isset($config_data['service_tax']) && $config_data['service_tax'] !='')
				{
					$service_tax_per = $config_data['service_tax'];
				}
				if($discount_amount !='' && $discount_amount > 0)
				{
					$plan_amount = $plan_amount - $discount_amount;
				}
				if(isset($plan_amount) && $plan_amount !='' && isset($service_tax_per) && $service_tax_per !='')
				{
					$service_tax = ($plan_amount * $service_tax_per)/100;
					$final_amount = $plan_amount + $service_tax;
				}
				$pland_data_arr = array(
					'js_id'=>$js_id,
					'plan_id'=>$plan_id,
					'current_plan'=>'Yes',
					'plan_type'=>'Paid',
					'plan_name'=>$plan_data['plan_name'],
					'plan_currency'=>$plan_data['plan_currency'],
					'plan_amount'=>$plan_data['plan_amount'],
					'plan_duration'=>$plan_data['plan_duration'],
					'message'=>$plan_data['message'],
					'message_used'=> 0,
					'contacts'=>$plan_data['contacts'],
					'contacts_used'=> 0,
					'highlight_application'=>$plan_data['highlight_application'],
					'relevant_jobs'=>$plan_data['relevant_jobs'],
					'performance_report'=>$plan_data['performance_report'],
					'job_post_notification'=>$plan_data['job_post_notification'],
					'plan_offers'=>$plan_data['plan_offers'],
					'coupan_code'=>$coupan_code,
					'discount_amount'=>$discount_amount,
					'final_amount'=>$final_amount,
					'service_tax'=>$service_tax,
					'activated_on'=>$activated_on,
					'expired_on'=>$expired_on,
					'payment_method'=>$payment_method,
					'transaction_id'=>$transaction_id,
					'payment_note'=>$payment_note
				);
				$this->update_insert_data_common('plan_jobseeker',$pland_data_arr,'',0,0);
				
				$data_array = array('plan_status'=>'Paid','plan_name'=>$plan_data['plan_name']);
				$where_arra = array('id'=>$js_id);
				$this->update_insert_data_common('jobseeker',$data_array,$where_arra,1,1);
				$return_resp = 'success';
			}
		}
		return $return_resp;
	}
	
	function update_plan_employer($emp_id='',$plan_id='')
	{
		$return_resp = 'fail';
		
		if($plan_id !='' && $emp_id !='')
		{
			$plan_data = $this->common_model->get_count_data_manual('credit_plan_employer',array('id'=>$plan_id),1,' * ','',0,'',0);
			if(isset($plan_data) && $plan_data !='' && count($plan_data) > 0)
			{
				// update old plan to current plan no
					$data_array = array('current_plan'=>'No');
					$where_arra = array('emp_id'=>$emp_id,'current_plan'=>'Yes');
					$this->update_insert_data_common('plan_employer',$data_array,$where_arra,1,0);
				// update old plan to current plan no
				$config_data = $this->data['config_data'];
				$service_tax_per = 0;
				$service_tax=0;
				$plan_amount = 0;
				$final_amount = 0;
				$plan_duration = 0;
				$coupan_code = '';
				$discount_amount = 0;
				$activated_on = $this->getCurrentDate('Y-m-d');
				$expired_on = $activated_on;
				$transaction_id ='';
				$payment_method ='';
				$payment_note = '';
				if(isset($_REQUEST['coupan_code']) && $_REQUEST['coupan_code'] !='')
				{
					$coupan_code = $this->xss_clean($_REQUEST['coupan_code']);
				}
				if(isset($_REQUEST['discount_amount']) && $_REQUEST['discount_amount'] !='')
				{
					$discount_amount = $this->xss_clean($_REQUEST['discount_amount']);
				}
				if(isset($_REQUEST['transaction_id']) && $_REQUEST['transaction_id'] !='')
				{
					$transaction_id = $this->xss_clean($_REQUEST['transaction_id']);
				}
				if(isset($_REQUEST['payment_method']) && $_REQUEST['payment_method'] !='')
				{
					$payment_method = $this->xss_clean($_REQUEST['payment_method']);
				}
				if(isset($_REQUEST['payment_note']) && $_REQUEST['payment_note'] !='')
				{
					$payment_note = $this->xss_clean($_REQUEST['payment_note']);
				}
				
				if(isset($plan_data['plan_duration']) && $plan_data['plan_duration'] !='')
				{
					$plan_duration = $plan_data['plan_duration'];
				}
				if(isset($plan_duration) && $plan_duration !='' && $activated_on !='')
				{
					$date_exp = strtotime(date("Y-m-d", strtotime($activated_on)) . + $plan_duration." day");
					$expired_on = date('Y-m-d', $date_exp);
				}
				if(isset($plan_data['plan_amount']) && $plan_data['plan_amount'] !='')
				{
					$plan_amount = $plan_data['plan_amount'];
					$final_amount = $plan_amount;
				}
				if(isset($config_data['service_tax']) && $config_data['service_tax'] !='')
				{
					$service_tax_per = $config_data['service_tax'];
				}
				if($discount_amount !='' && $discount_amount > 0)
				{
					$plan_amount = $plan_amount - $discount_amount;
				}
				if(isset($plan_amount) && $plan_amount !='' && isset($service_tax_per) && $service_tax_per !='')
				{
					$service_tax = ($plan_amount * $service_tax_per)/100;
					$final_amount = $plan_amount + $service_tax;
				}
				$pland_data_arr = array(
					'emp_id'=>$emp_id,
					'plan_id'=>$plan_id,
					'current_plan'=>'Yes',
					'plan_type'=>'Paid',
					'plan_name'=>$plan_data['plan_name'],
					'plan_currency'=>$plan_data['plan_currency'],
					'plan_amount'=>$plan_data['plan_amount'],
					'plan_duration'=>$plan_data['plan_duration'],
					'message'=>$plan_data['message'],
					'message_used'=> 0,
					'contacts'=>$plan_data['contacts'],
					'contacts_used'=> 0,
					'job_life'=>$plan_data['job_life'],
					'job_post_limit'=>$plan_data['job_post_limit'],
					'job_post_limit_used'=>0,
					'cv_access_limit'=>$plan_data['cv_access_limit'],
					'cv_access_limit_used'=>0,
					'highlight_job_limit'=>$plan_data['highlight_job_limit'],
					'highlight_job_limit_used'=>0,
					'plan_offers'=>$plan_data['plan_offers'],
					'coupan_code'=>$coupan_code,
					'discount_amount'=>$discount_amount,
					'final_amount'=>$final_amount,
					'service_tax'=>$service_tax,
					'activated_on'=>$activated_on,
					'expired_on'=>$expired_on,
					'payment_method'=>$payment_method,
					'transaction_id'=>$transaction_id,
					'payment_note'=>$payment_note
				);
				$this->update_insert_data_common('plan_employer',$pland_data_arr,'',0,0);
				
				$data_array = array('plan_status'=>'Paid','plan_name'=>$plan_data['plan_name']);
				$where_arra = array('id'=>$emp_id);
				$this->update_insert_data_common('employer_master',$data_array,$where_arra,1,1);
				$return_resp = 'success';
			}
		}
		return $return_resp;
	}
	
	function arraytojsontocken($getList='')
	{
		$temp_array = array();
		$key_array = array();
		if($getList !='')
		{
			$data_array = $this->common_front_model->get_list($getList,'','','array','',0);
			foreach($data_array as $val)
			{
				if($val['id'] !='' && $val['id'] != 0)
				{
					$temp_array[] = array('value'=>$val['id'],'lable'=>$val['val']);
					$key_array[] = $val['id'];
				}
			}
			//value
		}
		$temp_return = array('key_array'=>implode("','",$key_array),'tocken_array'=>json_encode($temp_array));
		return $temp_return;
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

	function update_plan_member_call()
	{
		$plan_id = '';
		$payment_note = '';
		$user_id = '';
		$user_type = '';
		if(isset($_REQUEST['plan_id']) && $_REQUEST['plan_id'] !='')
		{
			$plan_id = $this->xss_clean($_REQUEST['plan_id']);
		}
		if(isset($_REQUEST['payment_note']) && $_REQUEST['payment_note'] !='')
		{
			$payment_note = $this->xss_clean($_REQUEST['payment_note']);
		}
		if(isset($_REQUEST['user_id']) && $_REQUEST['user_id'] !='')
		{
			$user_id = $this->xss_clean($_REQUEST['user_id']);
		}
		if(isset($_REQUEST['user_type']) && $_REQUEST['user_type'] !='')
		{
			$user_type = $this->xss_clean($_REQUEST['user_type']);
		}
		$data_return = array();
		$data_return['tocken'] = $this->security->get_csrf_hash();
		
		$data_return['status'] = 'error';
		$data_return['message'] = 'Some error issue ocurred, Please try again.';
		
		if($plan_id !='' && $user_id !='')
		{
			if($user_type !='' && $user_type =='job_seeker')
			{
				$retuen_respo = $this->update_plan_member($user_id,$plan_id);
			}
			else if($user_type !='' && $user_type =='employer')
			{
				$retuen_respo = $this->update_plan_employer($user_id,$plan_id);
			}
			if(isset($retuen_respo) && $retuen_respo == 'success')
			{
				$data_return['status'] = 'success';
				$data_return['message'] = 'Plan Assigned successfully.';
			}
		}
		return $data_return;
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
	public function check_duplicate()
	{
		$id = '';
		$mode = '';
		$field_value = '';
		$field_name = '';
		$check_on = '';
		if(isset($_REQUEST['id']) && $_REQUEST['id'] !='')
		{
			$id = $this->xss_clean($_REQUEST['id']);
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode'] !='')
		{
			$mode = $this->xss_clean($_REQUEST['mode']);
		}
		if(isset($_REQUEST['field_value']) && $_REQUEST['field_value'] !='')
		{
			$field_value = $this->xss_clean($_REQUEST['field_value']);
		}
		if(isset($_REQUEST['field_name']) && $_REQUEST['field_name'] !='')
		{
			$field_name = $this->xss_clean($_REQUEST['field_name']);
		}
		if(isset($_REQUEST['check_on']) && $_REQUEST['check_on'] !='')
		{
			$check_on = $this->xss_clean($_REQUEST['check_on']);
		}
		if($check_on !='' && $field_name !='' && $field_value !='' && $mode !='')
		{
			$where_data = array();
			$array_table_field = $this->db->list_fields($check_on);
			if(in_array('is_deleted',$array_table_field))
			{
				$where_data = array('is_deleted'=>'No');
			}
			if($mode =='edit' && $id != '' )
			{
				$where_data[] = " id != '".$id."' ";
			}
			if($field_value !='')
			{
				$where_data[$field_name] = $field_value;
			}
			$count_duplicate = $this->common_model->get_count_data_manual($check_on,$where_data,0,'id');
			if(isset($count_duplicate) && $count_duplicate > 0)
			{
				return 'success';
			}
		}
		return 'error';
	}
	public function common_view_detail($title='',$data='')
	{
		$this->data = $this->common_model->data;
		if(isset($data) && $data !='' && count($data) > 0 )
		{
			foreach($data as $key=>$data_val)
			{
				$this->data[$key] = $data_val;
			}
		}
		$this->common_model->__load_header($title);
		$this->load->view('back_end/view_detail',$this->data);
		$this->common_model->__load_footer('');
	}
	function getstringreplaced($actula_content,$array=array())
	{
		$email_template = strtr($actula_content, $array);
		return $email_template;
	}
}