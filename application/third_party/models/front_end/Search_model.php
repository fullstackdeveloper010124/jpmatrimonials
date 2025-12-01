<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function add_where_search()
	{
		$member_front_search = $this->session->userdata('member_front_search');
		if(isset($member_front_search['search_where']) && $member_front_search['search_where'] !='')
		{
			$this->db->where($member_front_search['search_where']);
		}
		// set search for approvedd user only
		$this->db->where_not_in('status',array('UNAPPROVED','Suspended'));
	}
	public function get_search_count()
	{
		$this->add_where_search();
		$member_count = $this->common_model->get_count_data_manual('register_view','',0);
		return $member_count;
	}
	public function set_search_order()
	{
		$search_order = 'latest_first';
		if(isset($_REQUEST['search_order']) && $_REQUEST['search_order'] !='')
		{
			$search_order = $_REQUEST['search_order'];
		}
		if($search_order =='latest_first')
		{
			$this->db->order_by( ' registered_on desc ');
		}
		else if($search_order =='latest_last')
		{
			$this->db->order_by(' registered_on asc ');
		}
		else if($search_order =='last_login_first')
		{
			$this->db->order_by( ' last_login desc ');
		}
		else if($search_order =='last_login_last')
		{
			$this->db->order_by(' last_login asc ');
		}
	}
	public function get_search_result($page='')
	{
		$this->add_where_search();
		$this->set_search_order();
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='');
		return $member_data;
	}
	public function save_search()
	{
		if($this->input->post('save_search') && $this->input->post('save_search') !='')
		{
			$_SERVER["REQUEST_METHOD"] = "POST";
			$save_search = $this->input->post('save_search');
			$matri_id = $this->common_front_model->get_session_data('matri_id');
			if($save_search !='' && $matri_id !='')
			{
				$_REQUEST['search_name'] = $save_search;
				$_REQUEST['matri_id'] = $matri_id;
				if($this->input->post('txt_id_search') && $this->input->post('txt_id_search') !='')
				{
					$_REQUEST['id_search'] = $this->input->post('txt_id_search');
				}
				if($this->input->post('mothertongue') && $this->input->post('mothertongue') !='')
				{
					$_REQUEST['mother_tongue'] = $this->input->post('mothertongue');
				}
				if($this->input->post('photo_search') && $this->input->post('photo_search') !='')
				{
					$_REQUEST['with_photo'] = $this->input->post('photo_search');
				}
				if($this->input->post('looking_for') && $this->input->post('looking_for') !='')
				{
					$_REQUEST['marital_status'] = $this->input->post('looking_for');
				}
				$income = '';
				if($this->input->post('income') && $this->input->post('income') !='')
				{
					$income = $this->input->post('income');
					$_REQUEST['income'] = implode("-|-",$income); // b'c income contain , already in value so change delimator
				}
				
				$this->common_model->created_on_fild = 'created_on';
				$this->common_model->set_table_name('save_search');
				$response = $this->common_model->save_update_data(1,1);
				if(isset($income) && $income !='')
				{
					$_REQUEST['income']  = $income;
				}
			}
		}
	}
	public function set_search()
	{	
		$this->save_search();
		$where_search = array();
		$where_search_filed = array();
		$gender = $this->common_front_model->get_session_data('gender');
		if($gender == '')
		{
			if($this->input->post('gender') && $this->input->post('gender') !='' && $this->input->post('gender') !='All')
			{
				$gender = $this->input->post('gender');	
			}
		}
		else
		{
			if($gender =='Male')
			{
				$gender = 'Female';
			}
			else
			{
				$gender = 'Male';
			}
		}
		if($gender !='')
		{
			$where_search[]= " ( gender = '$gender' ) ";
			$where_search_filed['gender'] = $gender;
		}
		if($this->input->post('from_age') && $this->input->post('from_age') !='')
		{
			$from_age = $this->input->post('from_age');
			$where_search[]= " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  >=$from_age ) ";
			$where_search_filed['from_age'] = $from_age;
		}
		if($this->input->post('to_age') && $this->input->post('to_age') !='')
		{
			$to_age = $this->input->post('to_age');
			$where_search[]= " ( TIMESTAMPDIFF(YEAR,birthdate,CURDATE())  <=$to_age ) ";
			$where_search_filed['to_age'] = $to_age;
		}
		if($this->input->post('from_height') && $this->input->post('from_height') !='')
		{
			$from_height = $this->input->post('from_height');
			$where_search[]= " ( height >='$from_height') ";
			$where_search_filed['from_height'] = $from_height;
		}
		if($this->input->post('to_height') && $this->input->post('to_height') !='')
		{
			$to_height = $this->input->post('to_height');
			$where_search[] = " ( height <='$to_height') ";
			$where_search_filed['to_height'] = $to_height;
		}
		
		if($this->input->post('looking_for') && $this->input->post('looking_for') !='')
		{
			$looking_for = $this->input->post('looking_for');
			$looking_for = $this->common_model->trim_array_remove($looking_for);
			if(isset($looking_for) && count($looking_for) > 0)
			{
				$looking_for_str = implode("','",$looking_for);
				$where_search[]= " ( marital_status in ( '$looking_for_str') ) ";
				$where_search_filed['looking_for'] = $looking_for;
			}
		}
		if($this->input->post('religion') && $this->input->post('religion') !='')
		{
			$religion = $this->input->post('religion');
			$religion = $this->common_model->trim_array_remove($religion);
			if(isset($religion) && count($religion) > 0)
			{
				$religion_str = implode("','",$religion);
				$where_search[]= " ( religion in ('$religion_str') ) ";
				$where_search_filed['religion'] = $religion;
			}
		}
		if($this->input->post('caste') && $this->input->post('caste') !='')
		{
			$caste = $this->input->post('caste');
			$caste = $this->common_model->trim_array_remove($caste);
			if(isset($caste) && count($caste) > 0)
			{
				$caste_str = implode("','",$caste);
				$where_search[]= " ( caste in ('$caste_str') ) ";
				$where_search_filed['caste'] = $caste;
			}
		}
		if($this->input->post('mothertongue') && $this->input->post('mothertongue') !='')
		{
			$mothertongue = $this->input->post('mothertongue');
			$mothertongue = $this->common_model->trim_array_remove($mothertongue);
			if(isset($mothertongue) && count($mothertongue) > 0)
			{
				$mothertongue_str = implode("','",$mothertongue);
				$where_search[]= " ( mother_tongue in ( '$mothertongue_str') ) ";
				$where_search_filed['mothertongue'] = $mothertongue;
			}
		}
		if($this->input->post('country') && $this->input->post('country') !='')
		{
			$country = $this->input->post('country');
			$country = $this->common_model->trim_array_remove($country);
			if(isset($country) && count($country) > 0)
			{
				$country_str = implode("','",$country);
				$where_search[]= " ( country_id in ('$country_str') ) ";
				$where_search_filed['country'] = $country;
			}
		}
		if($this->input->post('state') && $this->input->post('state') !='')
		{
			$state = $this->input->post('state');
			$state = $this->common_model->trim_array_remove($state);
			if(isset($state) && count($state) > 0)
			{
				$state_str = implode("','",$state);
				$where_search[]= " ( state_id in ('$state_str') ) ";
				$where_search_filed['state'] = $state;
			}
		}
		if($this->input->post('city') && $this->input->post('city') !='')
		{
			$city = $this->input->post('city');
			$city = $this->common_model->trim_array_remove($city);
			if(isset($city) && count($city) > 0)
			{
				$city_str = implode("','",$city);
				$where_search[]= " ( city in ('$city_str') ) ";
				$where_search_filed['city'] = $city;
			}
		}
		if($this->input->post('education') && $this->input->post('education') !='')
		{
			$education = $this->input->post('education');
			$education = $this->common_model->trim_array_remove($education);
			if(isset($education) && $education !='')
			{
				//$part_education_arr = explode(',',$education);
				$str_education_partner = array();
				$where_search_filed['education'] = $education;
				foreach($education as $part_education_arr_val)
				{
					$str_education_partner[] = "(find_in_set('$part_education_arr_val',education_detail) > 0 )";
				}
				if(isset($str_education_partner) && count($str_education_partner)> 0)
				{
					$str_education_partner_str = implode(" or ",$str_education_partner);
					$where_search[]= " ( $str_education_partner_str ) ";
				}
			}
		}
		if($this->input->post('occupation') && $this->input->post('occupation') !='')
		{
			$occupation = $this->input->post('occupation');
			$occupation = $this->common_model->trim_array_remove($occupation);
			if(isset($occupation) && count($occupation) > 0)
			{
				$occupation_str = implode("','",$occupation);
				$where_search[]= " ( occupation in ( '$occupation_str') ) ";
				$where_search_filed['occupation'] = $occupation;
			}
		}
		if($this->input->post('employee_in') && $this->input->post('employee_in') !='')
		{
			$employee_in = $this->input->post('employee_in');
			$employee_in = $this->common_model->trim_array_remove($employee_in);
			if(isset($employee_in) && count($employee_in) > 0)
			{
				$employee_in_str = implode("','",$employee_in);
				$where_search[]= " ( employee_in in ( '$employee_in_str') ) ";
				$where_search_filed['employee_in'] = $employee_in;
			}
		}
		if($this->input->post('income') && $this->input->post('income') !='')
		{
			$income = $this->input->post('income');
			$income = $this->common_model->trim_array_remove($income);
			if(isset($income) && count($income) > 0)
			{
				$income_str = implode("','",$income);
				$where_search[]= " ( income in ( '$income_str') ) ";
				$where_search_filed['income'] = $income;
			}
		}
		if($this->input->post('diet') && $this->input->post('diet') !='')
		{
			$diet = $this->input->post('diet');
			$diet = $this->common_model->trim_array_remove($diet);
			if(isset($diet) && count($diet) > 0)
			{
				$diet_str = implode("','",$diet);
				$where_search[]= " ( diet in ( '$diet_str') ) ";
				$where_search_filed['diet'] = $diet;
			}
		}
		if($this->input->post('drink') && $this->input->post('drink') !='' && $this->input->post('drink') !='All')
		{
			$drink = $this->input->post('drink');
			$drink = $this->common_model->trim_array_remove($drink);
			if(isset($drink) && count($drink) > 0)
			{
				$drink_str = implode("','",$drink);
				$where_search[]= " ( drink in ( '$drink_str') ) ";
				$where_search_filed['drink'] = $drink;
			}
		}
		if($this->input->post('smoking') && $this->input->post('smoking') !='' && $this->input->post('smoking') !='All')
		{
			$smoke = $this->input->post('smoking');
			
			$smoke = $this->common_model->trim_array_remove($smoke);
			if(isset($smoke) && count($smoke) > 0)
			{
				$smoke_str = implode("','",$smoke);
				$where_search[]= " ( smoke in ( '$smoke_str') ) ";
				$where_search_filed['smoking'] = $smoke;
			}
		}
		if($this->input->post('complexion') && $this->input->post('complexion') !='')
		{
			$complexion = $this->input->post('complexion');
			$complexion = $this->common_model->trim_array_remove($complexion);
			if(isset($complexion) && count($complexion) > 0)
			{
				$complexion_str = implode("','",$complexion);
				$where_search[]= " ( complexion in ( '$complexion_str') ) ";
				$where_search_filed['complexion'] = $complexion;
			}
		}
		if($this->input->post('bodytype') && $this->input->post('bodytype') !='')
		{
			$bodytype = $this->input->post('bodytype');
			$bodytype = $this->common_model->trim_array_remove($bodytype);
			if(isset($bodytype) && count($bodytype) > 0)
			{
				$bodytype_str = implode("','",$bodytype);
				$where_search[]= " ( bodytype in ( '$bodytype_str') ) ";
				$where_search_filed['bodytype'] = $bodytype;
			}
		}
		if($this->input->post('star') && $this->input->post('star') !='')
		{
			$star = $this->input->post('star');
			$star = $this->common_model->trim_array_remove($star);
			if(isset($star) && count($star) > 0)
			{
				$star_str = implode("','",$star);
				$where_search[]= " ( star in ( '$star_str') ) ";
				$where_search_filed['star'] = $star;
			}
		}
		if($this->input->post('manglik') && $this->input->post('manglik') !='')
		{
			$manglik = $this->input->post('manglik');
			$manglik = $this->common_model->trim_array_remove($manglik);
			if(isset($manglik) && count($manglik) > 0)
			{
				$manglik_str = implode("','",$manglik);
				$where_search[]= " ( manglik in ( '$manglik_str') ) ";
				$where_search_filed['manglik'] = $manglik;
			}
		}
		if($this->input->post('photo_search') && $this->input->post('photo_search') !='')
		{
			$photo_search = $this->input->post('photo_search');
			if(isset($photo_search) && $photo_search =='photo_search')
			{
				$where_search[]= " ( photo1 != '' and photo1_approve ='APPROVED' ) ";
				$where_search_filed['photo_search'] = $photo_search;
			}
		}
		if($this->input->post('keyword') && $this->input->post('keyword') !='')
		{
			$keyword = trim($this->input->post('keyword'));
			$where_search[]= " ( username like '%$keyword%' or mobile like '%$keyword%' or email like '%$keyword%' or matri_id like '%$keyword%' or country_name like '%$keyword%' or state_name like '%$keyword%'  or city_name like '%$keyword%'  or mtongue_name like '%$keyword%' or occupation_name like '%$keyword%' or caste_name like '%$keyword%' or religion_name like '%$keyword%') ";
			$where_search_filed['keyword'] = $keyword;
		}
		if($this->input->post('txt_id_search') && $this->input->post('txt_id_search') !='')
		{	
			$txt_id_search = trim($this->input->post('txt_id_search'));
			$where_search[]= " ( matri_id = '$txt_id_search' ) ";
			$where_search_filed['txt_id_search'] = $txt_id_search;
		}
		$where_search_str = '';
		$this->session->unset_userdata('member_front_search');
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
			$data_arr = array('search_where'=>$where_search_str,'search_filed_data'=>$where_search_filed);
			$this->session->set_userdata('member_front_search',$data_arr);
		}
	}
	function search_sub_menu($select_search='quick')
	{
		$base_url_search = base_url().'search/';
		$quick_act = '';
		$adv_act = '';
		$key_act = '';
		$id_act = '';
		$online_act = '';
		$saved_act = '';
		if($select_search =='quick')
		{
			$quick_act ='active';	
		}	
		else 
		if($select_search =='advance')
		{
			$adv_act ='active';	
		}	
		else if($select_search =='keyword')
		{
			$key_act ='active';	
		}
		else if($select_search =='id')
		{
			$id_act ='active';	
		}
		else if($select_search =='online')
		{
			$online_act ='active';	
		}
		else if($select_search =='saved')
		{
			$saved_act ='active';	
		}
		$is_login = $this->common_front_model->checkLogin('return');
		$on_saved_link = '';
		if($is_login)
		{
			$on_saved_link = '<li class="'.$saved_act.'"><a href="'.$base_url_search.'saved"><i class="fa fa-list db-icon"></i>Saved Search</a></li>';
		}
		$return_val =  '<div class="tp-dashboard-nav">
			<div class="container">
				<div class="row">
					<div class="col-md-12 dashboard-nav">
						<ul class="nav nav-pills nav-justified">
							<li class="'.$quick_act.'"><a href="'.$base_url_search.'quick"><i class="fa fa-search db-icon"></i>Quick Search</a></li>
							<li class="'.$adv_act.'"><a href="'.$base_url_search.'advance"><i class="fa fa-search-plus db-icon"></i>Advance Search</a></li>
							<li class="'.$key_act.'"><a href="'.$base_url_search.'keyword"><i class="fa fa-calculator db-icon"></i>Keyword Search</a></li>
							<li class="'.$id_act.'"><a href="'.$base_url_search.'id"><i class="fa fa-user db-icon"></i>Id Search</a></li>
							'.$on_saved_link.'
						</ul>
					</div>
				</div>
			</div>
		</div>';
		return $return_val;
	}
	public function get_list($from='',$to_main='',$value=array(),$value_to=array(),$app_csrf=1)
	{
		$return = '';
		$to = $to_main;
		if($from !='' && $to_main !='' && $value !='' && count($value) > 0)
		{
			if(!is_array($value_to))
			{
				$value_to = array();
			}
			$arr_list_config = array(
				'religion'=>array('table'=>'religion','id'=>'id','rel_column'=>'','disp_val'=>'religion_name'),
				'caste'=>array('table'=>'caste','id'=>'id','rel_column'=>'religion_id','disp_val'=>'caste_name'),
				'country'=>array('table'=>'country_master','id'=>'id','rel_column'=>'','disp_val'=>'country_name'),
				'state'=>array('table'=>'state_master','id'=>'id','rel_column'=>'country_id','disp_val'=>'state_name'),
				'city'=>array('table'=>'city_master','id'=>'id','rel_column'=>'state_id','disp_val'=>'city_name'),
			);
			$tabel_name = $arr_list_config[$from]['table'];
			$disp_val_filed_main = $arr_list_config[$from]['disp_val'];
			$id_filed = $arr_list_config[$from]['id'];
			$onclick = '';
			if($from == 'country')
			{
				$onclick = 'onClick="getlist_onchange('."'state','city'".')"';
			}
			 
			$this->db->where_in($id_filed,$value);
			$data_arr_main = $this->common_model->get_count_data_manual($tabel_name,array('status'=>'APPROVED'),2,' * ',$disp_val_filed_main.' asc ');
			if(isset($data_arr_main) && $data_arr_main !='' && count($data_arr_main) > 0)
			{
				foreach($data_arr_main as $data_arr_main_val)
				{
					$id_relation_tab = $data_arr_main_val[$id_filed];
					$rel_column = $arr_list_config[$to]['rel_column'];
					$tabel_name = $arr_list_config[$to]['table'];
					$disp_val_filed = $arr_list_config[$to]['disp_val'];
					$id_filed = $arr_list_config[$to]['id'];
					//$this->db->where_in($rel_column,$value);
					$data_arr = $this->common_model->get_count_data_manual($tabel_name,array('status'=>'APPROVED',$rel_column=>$id_relation_tab),2,' * ',$disp_val_filed.' asc');
					if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
					{
						$return.= '<li class="xxl-16 xl-16 xs-16 s-16 m-16 l-16 padding-lr-zero text-center text-bold"><h3 class="success-story-heading">'.$data_arr_main_val[$disp_val_filed_main].'</h3></li>';
						foreach($data_arr as $data_arr_val)
						{
							$key = $data_arr_val[$id_filed];
							$val = $data_arr_val[$disp_val_filed];
							$cheked = "";
							if(in_array($key,$value_to))
							{
								$cheked = "checked";
							}
							$to = $to_main;
							$return.= '<li class="xxl-16 xl-16 xs-16 s-16 m-16 l-16 padding-lr-zero">
								<span class="">
									<input '.$onclick.' '.$cheked.' id="'.$to.'_'.$key.'" type="checkbox" value="'.$key.'" name="'.$to.'[]" class="'.$to.' row xxl-4 xl-4 xs-4 s-4 m-4 l-4">
									<label for="'.$to.'_'.$key.'" class="xxl-12 xl-12 xs-12 s-12 m-12 l-12 label-search">'.$val.'</label>
								</span>
							</li>';
						}
					}
				}
			}
			
		}
		if($return == '')
		{
			$return = '<li>Please select above value first</li>';
		}
		if($app_csrf == 1)
		{
			$return.='<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" id="hash_tocken_id_temp" class="hash_tocken_id" />';
		}
		return $return;
	}
	
	function saved_searches($post=0,$page='')
	{
		$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		$where_arra=array('matri_id'=>$login_user_matri_id);
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('save_search',$where_arra,0,'','');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('save_search',$where_arra,2,'*','id desc',$page);
		}
		return $data;
	}
	public function set_saved_search($id='')
	{	
		if($id !='')
		{
			$where_arra=array('id'=>$id);
			$data = $this->common_model->get_count_data_manual('save_search',$where_arra,1,'*');
			if(isset($data) && $data && $data>0)
			{
				if($data['from_age'] && $data['from_age']!='')
				{
					$_POST['from_age'] = $data['from_age'];
				}
				if($data['to_age'] && $data['to_age']!='')
				{
					$_POST['to_age'] = $data['to_age'];
				}
				if($data['from_height'] && $data['from_height']!='')
				{
					$_POST['from_height'] = $data['from_height'];
				}
				if($data['to_height'] && $data['to_height']!='')
				{
					$_POST['to_height'] = $data['to_height'];
				}
				if($data['marital_status'] && $data['marital_status']!='')
				{
					$marital_status_arr = explode(',',$data['marital_status']);
					$_POST['looking_for'] = $marital_status_arr;
				}
				if($data['religion'] && $data['religion']!='')
				{
					$religion_arr = explode(',',$data['religion']);
					$_POST['religion'] = $religion_arr;
				}
				if($data['caste'] && $data['caste']!='')
				{
					$caste_arr = explode(',',$data['caste']);
					$_POST['caste'] = $caste_arr;
				}
				if($data['country'] && $data['country']!='')
				{
					$country_arr = explode(',',$data['country']);
					$_POST['country'] = $country_arr;
				}
				if($data['state'] && $data['state']!='')
				{
					$state_arr = explode(',',$data['state']);
					$_POST['state'] = $state_arr;
				}
				if($data['city'] && $data['city']!='')
				{
					$city_arr = explode(',',$data['city']);
					$_POST['city'] = $city_arr;
				}
				if($data['education'] && $data['education']!='')
				{
					$education_arr = explode(',',$data['education']);
					$_POST['education'] = $education_arr;
				}
				if($data['with_photo'] && $data['with_photo']!='')
				{
					$_POST['photo_search'] = $data['with_photo'];
				}
				if($data['tot_children'] && $data['tot_children']!='')
				{
					$tot_children_arr = explode(',',$data['tot_children']);
					$_POST['tot_children'] = $tot_children_arr;
				}
				if($data['occupation'] && $data['occupation']!='')
				{
					$occupation_arr = explode(',',$data['occupation']);
					$_POST['occupation'] = $occupation_arr;
				}
				if($data['income'] && $data['income']!='')
				{
					$annual_income_arr = explode('-|-',$data['income']);
					$_POST['income'] = $annual_income_arr;
				}
				if($data['diet'] && $data['diet']!='')
				{
					$annual_income_arr = explode(',',$data['diet']);
					$_POST['diet'] = $annual_income_arr;
				}
				if($data['drink'] && $data['drink']!='')
				{
					$drink_arr = explode(',',$data['drink']);
					$_POST['drink'] = $drink_arr;
				}
				if($data['smoking'] && $data['smoking']!='')
				{
					$smoking_arr = explode(',',$data['smoking']);
					$_POST['smoking'] = $smoking_arr;
				}
				if($data['complexion'] && $data['complexion']!='')
				{
					$complexion_arr = explode(',',$data['complexion']);
					$_POST['complexion'] = $complexion_arr;
				}
				if($data['bodytype'] && $data['bodytype']!='')
				{
					$bodytype_arr = explode(',',$data['bodytype']);
					$_POST['bodytype'] = $bodytype_arr;
				}
				if($data['star'] && $data['star']!='')
				{
					$star_arr = explode(',',$data['star']);
					$_POST['star'] = $star_arr;
				}
				if($data['manglik'] && $data['manglik']!='')
				{
					$manglik_arr = explode(',',$data['manglik']);
					$_POST['manglik'] = $manglik_arr;
				}
				$this->set_search();
				return true;
			}
			return false;
		}
	}
	public function delete_saved_search()
    {
        if($this->input->post('saved_search_id') && $this->input->post('saved_search_id') !='') {
            $saved_search_id = $this->input->post('saved_search_id');
            $matri_id = $this->common_front_model->get_session_data('matri_id');
            if($matri_id  !='' && $saved_search_id !='')
            {
                $where_arra = array('id'=>$saved_search_id,'matri_id'=>$matri_id);
                $this->common_model->data_delete_common('save_search',$where_arra,1);
                $this->session->set_flashdata('success_message', "Your saved search deleted successfully");
            }
        }
    }
}