<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Search_model extends CI_Model {
	public $email_templ_data;
	public $sms_templ_data;
	public function __construct()
	{
		parent::__construct();
		$this->email_templ_data = '';
		$this->sms_templ_data = '';
	}
	public function add_where_search()
	{
		$this->common_front_model->set_orgin();
		// for web API
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$member_front_search = $this->search_model->set_search();
		}// for web API
		else
		{
			$member_front_search = $this->session->userdata('member_front_search');
			$gender = $this->common_front_model->get_session_data('gender');
			if(isset($member_front_search['search_filed_data']['gender']) && $member_front_search['search_filed_data']['gender']==$gender){
				if($gender == 'Male'){
					$opposite_gender = "( gender = 'Female' )";
					$original_gender = "( gender = 'Male' )";
				}elseif($gender == 'Female'){
					$opposite_gender = "( gender = 'Male' )";
					$original_gender = "( gender = 'Female' )";
				}
				$member_front_search['search_where'] = str_ireplace($original_gender,$opposite_gender,$member_front_search['search_where']);
			}
			elseif(!isset($member_front_search) && $member_front_search==''){
				if($gender == 'Male'){
					$gender = 'Female';
				}
				elseif($gender == 'Female'){
					$gender = 'Male';
				}
				if($gender != ''){
					$where_search[] = " ( gender = '$gender' ) ";
					$where_search_filed['gender'] = $gender;
				}
				if(isset($where_search) && $where_search !='' && count($where_search) > 0){
					$where_search_str = implode(" and ",$where_search);
					$member_front_search['search_where'] = $where_search_str;
					$member_front_search['search_filed_data'] = $where_search_filed;
				}
			}
		}
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
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit=10);
		return $member_data;
	}
	public function save_search()
	{
		if($this->input->post('save_search') && $this->input->post('save_search') !='')
		{
			$_SERVER["REQUEST_METHOD"] = "POST";
			$save_search = $this->input->post('save_search');
			
			$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			if($user_agent != 'NI-WEB'){
				$matri_id = $this->input->post('matri_id');
			}else{
				$matri_id = $this->common_front_model->get_session_data('matri_id');
			}
			
			//$matri_id = $this->common_front_model->get_user_id('matri_id','matri_id');
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
					$_REQUEST['income'] = implode("','",$income);  // b'c income contain , already in value so change delimator
				}
				
				$this->common_model->created_on_fild = 'created_on';
				$this->common_model->set_table_name('save_search');
				$response = $this->common_model->save_update_data(1,1);
				
				if($user_agent != 'NI-WEB'){
					if($response){
						$data1['tocken'] = $this->security->get_csrf_hash();
						$data1['status'] = 'success';
						$data1['errormessage'] = 'Data insert successfully.';
						$data1['errmessage'] = 'Data insert successfully.';
						$data['data'] = json_encode($data1);
						$this->load->view('common_file_echo',$data);
					}else{
						$data1['tocken'] = $this->security->get_csrf_hash();
						$data1['status'] = 'error';
						$data1['errormessage'] = 'Data not insert successfully.';
						$data1['errmessage'] = 'Data not insert successfully.';
						$data['data'] = json_encode($data1);
						$this->load->view('common_file_echo',$data);
					}
				}
				
				// if(isset($income) && $income !='')
				// {
				// 	$_REQUEST['income']  = $income;
				// }
			}else{
				if($user_agent != 'NI-WEB'){
					$data1['tocken'] = $this->security->get_csrf_hash();
					$data1['status'] = 'error';
					$data1['errormessage'] = 'Data not insert successfully.';
					$data1['errmessage'] = 'Data not insert successfully.';
					$data['data'] = json_encode($data1);
					$this->load->view('common_file_echo',$data);
				}
			}
		}
	}
	public function set_search()
	{	
		$this->common_front_model->set_orgin();
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		$this->save_search();
		$where_search = array();
		$where_search_filed = array();
		$gender = $this->common_front_model->get_session_data('gender');
		$member_online_data =  $this->session->userdata('member_online_data');
		$NoOnline =  $this->session->userdata('NoOnline');
		
		if($member_online_data != ''){
			foreach($member_online_data as $key => $val){	
				$array[] = $val['index_id'];
			}			
			$where_in = implode(',', $array);
			$where_search[]= " ( id in ( $where_in) ) ";
			$where_search_filed['id'] = $where_in;
		}elseif($NoOnline == 'No-Online'){
			$where_in = '';
			$where_search[]= " ( id = '' ) ";
			$where_search_filed['id'] = $where_in;
		}
		
		if($gender == ''){
			if($this->input->post('gender') && $this->input->post('gender') !='' && $this->input->post('gender') !='All'){
				$gender = $this->input->post('gender');	
			}
		}
		else{
			if($gender =='Male'){
				$gender = 'Female';
			}
			else{
				$gender = 'Male';
			}
		}
		if($gender !=''){
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
		
			if($from_height==='50'){
			    $where_search[]= " ( height >='45') ";
			    $where_search_filed['from_height'] = $from_height;
			}else
			{
			    $where_search[]= " ( height >='$from_height') ";
			    $where_search_filed['from_height'] = $from_height;
			}
			
		}
		if($this->input->post('to_height') && $this->input->post('to_height') !='')
		{
		    $to_height = $this->input->post('to_height');
		   // echo $to_height;
		    if($from_height==='50'){
			    $where_search[]= " ( height <='86') ";
			    $where_search_filed['from_height'] = $from_height;
			}else
			{
			    	$where_search[] = " ( height <='$to_height') ";
			$where_search_filed['to_height'] = $to_height;
			}
		
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
			if($user_agent!='NI-WEB')
			{
				if(isset($income) && $income!='')
				{
					$income = explode('-|-',$income);
				}
			}
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
				$plna_status = '';
				$plna_status_where = '';
				if($user_agent == 'NI-WEB')
				{
					//get serch
					$new_curre_datas = $this->common_front_model->get_session_data();					
					if($new_curre_datas["plan_status"]=='Paid'){
						$plna_status_where = " or photo_view_status = '2' ";
					}
				}
				else
				{
					$id = $this->common_front_model->get_user_id();
					$new_curre_datas = $this->common_front_model->get_user_data('register',$id,'plan_status','id');
					if(isset($new_curre_datas["plan_status"]) && $new_curre_datas["plan_status"]=='Paid')
					{
						$plna_status_where = " or photo_view_status = '2' ";
					}
				}				
				$where_search[]= " ( photo1 != '' and photo1_approve ='APPROVED' and ( photo_view_status = '1' $plna_status_where ) ) ";
								
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
		$this->session->unset_userdata('member_online_data');
		$this->session->unset_userdata('NoOnline');
		if(isset($where_search) && $where_search !='' && count($where_search) > 0)
		{
			$where_search_str = implode(" and ",$where_search);
			$data_arr = array('search_where'=>$where_search_str,'search_filed_data'=>$where_search_filed);
			
			// for web API
			if($user_agent!='NI-WEB')
			{
				return $data_arr;
			}// for web API
			else
			{
				$this->session->set_userdata('member_front_search',$data_arr);
			}
			
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
			/*$on_saved_link = '<li class="'.$saved_act.'"><a href="'.$base_url_search.'saved"><i class="fa fa-list db-icon"></i>Saved Search</a></li>';*/
			$on_saved_link = '<li role="presentation" class="'.$saved_act.' f-17 li-last">
				<a href="'.$base_url_search.'saved" aria-controls="saved-search-tab" role="tab" data-toggle="tab"><i class="fas fa-user"></i> Saved Search</a>
			</li>';
		}
		$return_val = '<div class="contact-tab">
			<div class="container-fluid new-width">
				<div class="row">
					<div class="col-md-12">
						<div class="tab contact-tab-m quick-search-tab" role="tabpanel">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs contact-tab-nav2" role="tablist">
								<li role="presentation" class="'.$quick_act.' f-17">
									<a href="'.$base_url_search.'quick" aria-controls="quick-search-tab" role="tab" data-toggle="tab">
										<i class="fas fa-search"></i>
									Quick Search</a>
								</li>
								<li role="presentation" class="'.$adv_act.' f-17">
									<a href='.$base_url_search.'advance" aria-controls="advance-search-tab" role="tab" data-toggle="tab"><i class="fas fa-search-plus"></i> Advance Search</a>
								</li>
								<li role="presentation" class="'.$key_act.' f-17">
									<a href="'.$base_url_search.'keyword" aria-controls="keyword-search-tab" role="tab" data-toggle="tab"><i class="fas fa-keyboard"></i> Keyword Search</a>
								</li>
								<li role="presentation" class="'.$id_act.' f-17 li-last">
									<a href="'.$base_url_search.'id" aria-controls="id-search-tab" role="tab" data-toggle="tab"><i class="fas fa-user"></i> ID Search</a>
								</li>
								'.$on_saved_link.'
							</ul>
							<!-- Tab panes -->
						</div>
					</div>
				</div>
			</div>
		</div>';
		/*$return_val =  '<div class="tp-dashboard-nav">
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
		</div>';*/
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
			if($from == 'religion' || $from == 'state')
			{
				$onclick = 'onClick="refine_search()"';
			}
			$this->db->where_in($id_filed,$value);
			$data_arr_main = $this->common_model->get_count_data_manual($tabel_name,array('status'=>'APPROVED'),2,' * ',$disp_val_filed_main.' asc ');
			if(isset($data_arr_main) && $data_arr_main !='' && count($data_arr_main) > 0)
			{
				$rel_column = $arr_list_config[$to]['rel_column'];
				$tabel_name = $arr_list_config[$to]['table'];
				$disp_val_filed = $arr_list_config[$to]['disp_val'];
				$id_filed = $arr_list_config[$to]['id'];
				$id_relation_tab_new = array();
				foreach($data_arr_main as $data_arr_main_val)
				{
					$id_relation_tab_new[] = $data_arr_main_val[$id_filed];
				}
				$this->db->where_in($rel_column,$id_relation_tab_new);
				$data_arr = $this->common_model->get_count_data_manual($tabel_name,array('status'=>'APPROVED','is_deleted'=>'No'),2,' * ',$disp_val_filed.' asc');
				//echo $this->db->last_query();
				if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
				{
					//$return.= '<p class="h-c1 OpenSans-Bold">'.$data_arr_main_val[$disp_val_filed_main].'</p>';
					$i=1;
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
						$style = 'none';
						if($i<=5){
							$style = 'block';
						}
						$return.= '<div class="box" style="display:'.$style.';">
							<p class="checkbox-m">
								<input type="checkbox" '.$onclick.' '.$cheked.' id="'.$to.'_id_'.$key.'" type="checkbox" value="'.$key.'" name="'.$to.'[]" class="'.$to.'">
								<label for="'.$to.'_id_'.$key.'" class="lbl1 lbl-break">'.$val.'</label>
							</p>
						</div>';
					$i++;
					}
					if(isset($data_arr) && $data_arr !='' && is_array($data_arr) && count($data_arr) > 5){
						$c = count($data_arr);
						$return.= '<div class="box">
							<a data-toggle="modal" href="#more-'.$to.'">
								<span class="checkbox-m more OpenSans-Bold">
									+ '.$c.' more
								</span>
							</a>
						</div>';
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
	public function get_list_old($from='',$to_main='',$value=array(),$value_to=array(),$app_csrf=1)
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
			if($from == 'religion' || $from == 'state')
			{
				$onclick = 'onClick="refine_search()"';
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
					$data_arr = $this->common_model->get_count_data_manual($tabel_name,array('status'=>'APPROVED',$rel_column=>$id_relation_tab),2,' * ',$disp_val_filed.' asc');
					if(isset($data_arr) && $data_arr !='' && count($data_arr) > 0)
					{
						//$return.= '<p class="h-c1 OpenSans-Bold">'.$data_arr_main_val[$disp_val_filed_main].'</p>';
						$i=1;
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
							$style = 'none';
							if($i<=5){
								$style = 'block';
							}
							$return.= '<div class="box" style="display:'.$style.';">
								<p class="checkbox-m">
									<input type="checkbox" '.$onclick.' '.$cheked.' id="'.$to.'_id_'.$key.'" type="checkbox" value="'.$key.'" name="'.$to.'[]" class="'.$to.'">
									<label for="'.$to.'_id_'.$key.'" class="lbl1 lbl-break">'.$val.'</label>
								</p>
							</div>';
						$i++;
						}
						if(isset($data_arr) && $data_arr !='' && is_array($data_arr) && count($data_arr) > 5){
							$c = count($data_arr);
                            $return.= '<div class="box">
                                <a data-toggle="modal" href="#more-'.$to.'">
                                    <span class="checkbox-m more OpenSans-Bold">
                                        + '.$c.' more
                                    </span>
                                </a>
                            </div>';
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
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		
		if($user_agent!='NI-WEB')
		{
			$login_user_matri_id = $this->input->post('matri_id');
		}else{
			$login_user_matri_id = $this->common_front_model->get_session_data('matri_id');
		}
		
		$where_arra=array('matri_id'=>$login_user_matri_id,'is_deleted'=>'No');
		if($post == 0)
		{	
			$data = $this->common_model->get_count_data_manual('save_search',$where_arra,0,'','');
		}
		else
		{
			$data = $this->common_model->get_count_data_manual('save_search',$where_arra,2,'*','id desc',$page,'','');
			$reset_opt_arrya = array(
				'religion'=>array('table'=>'religion','key_disp'=>'religion_name'),
				'caste'=>array('table'=>'caste','key_disp'=>'caste_name'),
				'income'=>array('table'=>'	annual_income','key_disp'=>'annual_income_name'),
				'mother_tongue'=>array('table'=>'mothertongue','key_disp'=>'mtongue_name'),
				'country'=>array('table'=>'country_master','key_disp'=>'country_name'),
				'state'=>array('table'=>'state_master','key_disp'=>'state_name'),
				'city'=>array('table'=>'city_master','key_disp'=>'city_name'),
				'education'=>array('table'=>'education_detail','key_disp'=>'education_name'),
				'occupation'=>array('table'=>'occupation','key_disp'=>'occupation_name'),
				'star'=>array('table'=>'star','key_disp'=>'star_name'),
			);
			if($reset_opt_arrya !='' && count($reset_opt_arrya) > 0 && $data !='' && count($data) > 0)
			{
				foreach($data as $key1=>$row)
				{
					foreach($reset_opt_arrya as $key=>$val)
					{
						$data[$key1][$key.'_str'] = $this->common_model->valueFromId($val['table'],$row[$key],$val['key_disp']);
					}
				}
			}
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
				if($data['employee_in'] && $data['employee_in']!='')
				{
					$employee_in_arr = explode(',',$data['employee_in']);
					$_POST['employee_in'] = $employee_in_arr;
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
				if($data['keyword'] && $data['keyword']!='')
				{
					$_POST['keyword'] = $data['keyword'];
				}
				if($data['id_search'] && $data['id_search']!='')
				{
					$_POST['txt_id_search'] = $data['id_search'];
				}
				$this->set_search();
				return true;
			}
			return false;
		}
	}
	public function delete_saved_search()
    {
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$matri_id = $this->input->post('matri_id');
		}else{
			$matri_id = $this->common_front_model->get_session_data('matri_id');
		}
		
		$saved_search_id = $this->input->post('saved_search_id');
		if($matri_id  !='' && $saved_search_id !='')
        {
			$where_arra = array('id'=>$saved_search_id,'matri_id'=>$matri_id);
			$this->common_model->data_delete_common('save_search',$where_arra,1);
			$this->session->set_flashdata('success_message', "Your saved search deleted successfully.");
			
			$data1['status'] = 'success';
			$data1['errormessage'] = 'Your saved search deleted successfully.';
			$data1['errmessage'] = 'Your saved search deleted successfully.';
        }else{
			$data1['status'] = 'error';
			$data1['errormessage'] = 'Sorry, Your session hase been time out, Please login Again.';
			$data1['errmessage'] = 'Sorry, Your session hase been time out, Please login Again.';
		}
        
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data11 = json_encode($data1);
		$data['data'] = $data11;
		$this->load->view('common_file_echo',$data);
    }
	
	
	public function add_blocklist()
    {
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
       
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
			$sender_id = $this->input->post('logged_in_user_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
			$sender_id = $this->common_front_model->get_session_data('id');
		}
       
		$block_by= $member_id;
		$block_date = $this->common_model->getCurrentDate();
		$return_message = "";
		$status = 'error';
		$base_url = base_url();
		
		$blockuserid = $this->input->post('blockuserid');
		if(isset($blockuserid) && $blockuserid!='' && $member_id!='')
		{
				$data = $this->common_front_model->get_user_data('register',$block_by,'gender','matri_id');
				$gender = $data['gender'];
				$block_to = strtoupper($this->input->post('blockuserid'));
				$where_arra=array('status'=>'APPROVED','matri_id'=>$block_to,"gender !='$gender'");
				$data123 =$this->common_model->get_count_data_manual('register',$where_arra,0);
				$data12344 =$this->common_model->get_count_data_manual('register',$where_arra,1,'id');
				if($data123==0)
				{
					$data1['status'] = 'error';
					$data1['errmessage'] = "Please Enter Valid Matri Id.";
				}
				else
				{
					$where_array_allready_block = array(
						'block_by'=>$block_by,
						'block_to'=>$block_to);
					$count_allready_block = $this->common_model->get_count_data_manual('block_profile',$where_array_allready_block,0);
					if($count_allready_block==0)
					{
						$data_array = array(
							'block_by'=>$block_by,
							'block_to'=>$block_to,
							'created_on'=>$block_date);
						$response = $this->common_front_model->save_update_data('block_profile',$data_array);

						if($response)
						{
							$data1['status'] = 'success';
							$data1['errmessage'] = "Your request for member blocking is successfully done.";

							//app push notification
							// $block_data = $this->common_front_model->get_user_data('register',$block_to,'id,ios_device_id,android_device_id,web_device_id','matri_id');
							// if(isset($block_data) && $block_data!='' && count($block_data)>0)
							// {
							// 	$block_message = 'Your profile was blocked by '.$block_by;
							// 	foreach ($block_data as $key => $value) {
							// 		if(isset($value) && $value!='' && isset($key) && $key!='')
							// 		{
							// 			if($key == 'web_device_id'){
							// 			if(isset($block_data['web_device_id']) && $block_data['web_device_id']!=''){
							// 				## For Web Notification
							// 				$data_array = array(
							// 					'device_id'=>$block_data['web_device_id'],
							// 					'sender_id' => $sender_id,
							// 					'receiver_id' => $data12344['id'],
							// 					'notification_type' => 'add_blocklist',
							// 					'title' => 'Add to Block',
							// 					'message' => $block_message,
							// 					'click_action'=>base_url(),
							// 				);
							// 				$this->common_model->new_send_notification_web($data_array);
							// 			}
							// 		}
							// 		else if($key=='ios_device_id' || $key=='android_device_id'){
							// 		    if($key == 'ios_device_id'){
       //          						    $app_type = 'IOS';
       //          						}
       //          						else{
       //          							$app_type = 'Android';
       //          						}
                						
       //          				    	$sender_receiver = array('sender'=>$sender_id,'receiver'=>$data12344['id'],'app_type'=>$app_type);
										
							// 			$this->common_model->new_send_notification_android($value,$block_message,'Block','add_blocklist',$sender_id,'','',$sender_receiver);
							// 		}
							// 	}
							// 	}	
							// }
							
						}else{
							$data1['status'] = 'error';
							$data1['errmessage'] = "Please try again.";
						}
					}
					else{
						$data1['status'] = 'error';
						$data1['errmessage'] = "Your request for member blocking is allready block.";
					}
				}
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please try again.";
		}
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		//$data11 = json_encode($data1);
		$data1['data'] = json_encode($data1);
		return $data1;
		
    }
	public function remove_blocklist()
    {
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
			$sender_id = $this->input->post('logged_in_user_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
			$sender_id = $this->common_front_model->get_session_data('id');
		}
		
		$block_by= $member_id;
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		$return_message = "";
		$status = 'error';
		$base_url = base_url();
		
		$unblockuserid = $this->input->post('unblockuserid');
		if(isset($unblockuserid) && $unblockuserid!='' && $member_id!='')
		{
			$block_to = strtoupper($this->input->post('unblockuserid'));
			$where_arra = array('block_by'=>$block_by,'block_to'=>$block_to);
			$response = $this->common_model->data_delete_common('block_profile',$where_arra,0,'id');
			$data12344 =$this->common_model->get_count_data_manual('register',array('matri_id'=>$block_to),1,'id');
			if($response)
			{
				$data1['status'] = 'success';
				$data1['errmessage'] = "Your request for member unblocking is successfully done.";
				// $unblock_data = $this->common_front_model->get_user_data('register',$block_to,'id,web_device_id,ios_device_id,android_device_id','matri_id');
				// if(isset($unblock_data) && $unblock_data!='' && count($unblock_data)>0)
				// {
				// 	$unblock_message = 'Your profile was Unblocked by '.$block_by;
				// 	foreach ($unblock_data as $key => $value) {
				// 		if(isset($value) && $value!='' && isset($key) && $key!='')
				// 		{
				// 			if($key == 'web_device_id'){
				// 				if(isset($unblock_data['web_device_id']) && $unblock_data['web_device_id']!=''){
				// 					$data_array = array(
				// 						'device_id'=>$unblock_data['web_device_id'],
				// 						'sender_id' => $sender_id,
				// 						'receiver_id' => $data12344['id'],
				// 						'notification_type' => 'remove_blocklist',
				// 						'title' => 'Unblocked',
				// 						'message' => $unblock_message,
				// 						'click_action'=>base_url(),
				// 					);
				// 					$this->common_model->new_send_notification_web($data_array);
				// 				}
				// 			}
				// 			else if($key=='ios_device_id' || $key=='android_device_id'){
				// 				if($key == 'ios_device_id'){
				// 					$app_type = 'IOS';
				// 				}
				// 				else{
				// 					$app_type = 'Android';
				// 				}
				// 				$sender_receiver = array('sender'=>$sender_id,'receiver'=>$data12344['id'],'app_type'=>$app_type);
				// 				$this->common_model->new_send_notification_android($value,$unblock_message,'Unblocked','remove_blocklist',$sender_id,'','',$sender_receiver);
				// 			}
				// 		}
				// 	}	
				//}
			}
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please try again.";
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data2['data'] = json_encode($data1);
		return $data2;
    }
	public function add_shortlist()
	{
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
			$sender_id = $this->input->post('logged_in_user_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
			$sender_id = $this->common_front_model->get_session_data('id');
		}
        
		$from_id = $member_id;
		$created_on = $this->common_model->getCurrentDate();
		$shortlistuserid = $this->input->post('shortlistuserid');
		
		$return_message = "";
		$status = 'error';
		$base_url = base_url();
		$from_data = $this->common_front_model->get_user_data('register',$from_id,'id','matri_id');
		
		if(isset($shortlistuserid) && $shortlistuserid != '' && $member_id!='')
		{
			$to_id = strtoupper($this->input->post('shortlistuserid'));
			$block_count = $this->common_model->get_count_data_manual('block_profile',array('block_to'=>$member_id,'block_by'=>$to_id,'is_deleted'=>'No'),0,'id');
				if($block_count == 1)
				{
					$data1['status'] = 'error';
					$data1['errmessage'] = " Do not shortlist to Matri ID $to_id because of this member has blocked you.";
				}else{
					$data_array = array(
								'from_id'=>$from_id,
								'to_id'=>$to_id,
								'created_on'=>$created_on);
					$response = $this->common_front_model->save_update_data('shortlist',$data_array);
					if($response)
					{
						$data1['status'] = 'success';
						$data1['errmessage'] = "Your request for member shortlisted is successfully done.";
						$short_data = $this->common_front_model->get_user_data('register',$to_id,'id,ios_device_id,android_device_id,web_device_id','matri_id');
						$short_data1 = $this->common_front_model->get_user_data('register',$to_id,'id','matri_id');
						if(isset($short_data) && $short_data!='' && count($short_data)>0){
	foreach ($short_data as $key => $value) {
		if(isset($value) && $value!='' && isset($key) && $key!='')
		{
			$short_message = 'Your profile was ShortListed by '.$from_id;
			if($key == 'web_device_id'){
				if(isset($short_data['web_device_id']) && $short_data['web_device_id']!=''){
					## For Web Notification
					$data_array = array(
						'device_id'=>$short_data['web_device_id'],
						'sender_id' => $from_data['id'],
						'receiver_id'=>$short_data1['id'],
						'notification_type' => 'add_shortlist',
						'title' => 'Add to Shortlist',
						'message' => $short_message,
						'click_action'=>base_url().'search/view-profile/'.$from_id,
					);
					$this->common_model->new_send_notification_web($data_array);
				}
			}
			else if($key=='ios_device_id' || $key=='android_device_id'){
				if($key == 'ios_device_id'){
					$app_type = 'IOS';
				}
				else{
					$app_type = 'Android';
				}
				$sender_receiver = array('sender'=>$from_data['id'],'receiver'=>$short_data1['id'],'app_type'=>$app_type);
				$this->common_model->new_send_notification_android($value,$short_message,'ShortList','add_shortlist',$from_data['id'],'','',$sender_receiver);
			}
		}
	}	
}
					}
				}
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please try again.";
		}
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
	}
	public function remove_shortlist()
    {
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
		$return_message = "";
		$status = 'error';
		$base_url = base_url();
		
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
			//$sender_id = $this->input->post('logged_in_user_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
			//$sender_id = $this->common_front_model->get_session_data('id');
		}
		
		$from_id= $member_id;
		$shortlisteduserid = $this->input->post('shortlisteduserid');
		
		if(isset($shortlisteduserid) && $shortlisteduserid != '' && $member_id!='')
		{
			$to_id = strtoupper($this->input->post('shortlisteduserid'));
			$where_arra = array('from_id'=>$from_id,'to_id'=>$to_id);
			$response = $this->common_model->data_delete_common('shortlist',$where_arra,0,'id');
			if($response)
			{
				$data1['status'] = 'success';
				$data1['errmessage'] = "Your request for member unshortlist is successfully done.";
				// $unshort_data = $this->common_front_model->get_user_data('register',$to_id,'ios_device_id,android_device_id','matri_id');
				// if(isset($unshort_data) && $unshort_data!='' && count($unshort_data)>0)
				// {
				// 	foreach ($unshort_data as $key => $value) {
				// 		if(isset($value) && $value!='' && isset($key) && $key!='')
				// 		{
				// 			$unshort_array=array('body'=> 'Your id was ShortListed by '.$from_id,'message' => 'Your id was UnShortListed by '.$from_id,'title'=>'ShortList','noti_type' =>'shortlist','other_id'=>$sender_id);
				// 			$this->common_model->new_send_notification_android($value,'Your id was UnShortListed by '.$from_id,'ShortList','shortlist','phone',$unshort_array);
				// 		}
				// 	}	
				// }
			}
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please try again.";
		}
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
    }
	public function express_interest_sent()
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
		}
		
		if(isset($member_id) && $member_id != '')
		{
			$sender = $member_id;
			$receiver = $this->input->post('receiver');
			$message = $this->input->post('message');
			$sent_date = $this->common_model->getCurrentDate();
			
			$mem_plan = $this->common_model->get_count_data_manual('register_view',array('matri_id'=>$sender,'is_deleted'=>'No'),1,'plan_status');
			$expressinterest_count = $this->common_model->get_count_data_manual('expressinterest',array('sender'=>$sender,'receiver'=>$receiver,'is_deleted'=>'No'),0,'id');
			
			if($expressinterest_count == 0){
				if($sender!='' && $receiver!='' && $message != ''){
					$block_count = $this->common_model->get_count_data_manual('block_profile',array('block_to'=>$member_id,'block_by'=>$receiver,'is_deleted'=>'No'),0,'id');
					if($block_count == 1)
					{
						$data1['status'] = 'error';
						$data1['errmessage'] = " Express interest not Sent to Matri ID $receiver because of this member has blocked you.";
					}else{
						$payments_data_count = $this->common_model->get_count_data_manual('payments_view',array('matri_id'=>$member_id,'current_plan'=>'Yes','is_deleted'=>'No'),0,'id');
						
						if($payments_data_count > 0 && (isset($mem_plan['plan_status']) && $mem_plan['plan_status']=='Paid')){
							$data_array = array(
										'sender'=>$sender,
										'receiver'=>$receiver,
										'message'=>$message,
										'receiver_response'=>'Pending',
										'status'=>'APPROVED',
										'sent_date'=>$sent_date);
							$response = $this->common_front_model->save_update_data('expressinterest',$data_array);
							
							$config_arra = $this->common_model->get_site_config();
							$web_name = $config_arra['web_name'];
							$webfriendlyname = $config_arra['web_frienly_name'];
							$facebook_link = $config_arra['facebook_link'];
							$twitter_link = $config_arra['twitter_link'];
							$google_link = $config_arra['google_link'];
							$linkedin_link = $config_arra['linkedin_link'];
							$footer_text = $config_arra['footer_text'];
							$contact_no = $config_arra['contact_no'];
							$from_email = $config_arra['from_email'];
							$android_app_link = $config_arra['android_app_link'];
							$template_image_url = $web_name.'assets/email_template';
							$login = $web_name.'login';
							$contact_us = $web_name.'contact';
							$part_basic_detail = $web_name.'my-profile/edit-profile/part-basic-detail';
				
							$user_data = $this->common_model->get_count_data_manual('register_view',array('matri_id'=>$receiver),1,'matri_id,username,email,mobile','');
							
							$username = $user_data['username'];
							$matri_id = $user_data['matri_id'];
							$email = $user_data['email'];
								
							$email_temp_data = $this->common_front_model->getemailtemplate('Express Interest');
				
							$message = $email_temp_data['email_content'];
							$subject = $email_temp_data['email_subject'];
							
							$sender_data = $this->common_model->get_count_data_manual('register_view',array('matri_id'=>$sender),1,'*','');
							$member_data_html='';
							if(isset($sender_data) && $sender_data!= ''){
								
								$path_photos = $this->common_model->path_photos;
								if(isset($sender_data['photo1']) && $sender_data['photo1']!='' && $sender_data['photo1_approve']=='APPROVED' && file_exists($path_photos.$sender_data['photo1']))
								{
									$defult_photo = $web_name.$path_photos.$sender_data['photo1'];
								}else{ 
									if(isset($sender_data['gender']) && $sender_data['gender'] == 'Male'){
										$defult_photo = $web_name.'assets/front_end/img/default-photo/male.png';
									}else{
										$defult_photo = $web_name.'assets/front_end/img/default-photo/female.png';
									}
								}
								
								$username111 = $sender_data['username'];
								$matri_id111 = $sender_data['matri_id'];
								$religion_name = $sender_data['religion_name'];
								$caste_name = $sender_data['caste_name'];
								$location = $sender_data['state_name'].', '.$sender_data['country_name'];
								$education_name = $sender_data['education_name'];
								$occupation_name = $sender_data['occupation_name'];
								$profile_link = $web_name.'search/view-profile/'.$sender_data['matri_id'];
								if(isset($sender_data['birthdate']) && $sender_data['birthdate'] !='')
								{
									$birthdate = $sender_data['birthdate'];
									$age = $this->common_model->birthdate_disp($birthdate,0);
								}
								else
								{
									$age = $this->common_model->display_data_na('');
								}
								if(isset($sender_data['height']) && $sender_data['height'] !='')
								{
									$height123 = $sender_data['height'];
									$height = $this->common_model->display_height($height123);
								}
								else
								{
									$height = $this->common_model->display_data_na('');
								}
				
	$member_data_html .='<div class="movableContent" style="border: 0px; padding-top: 0px; position: relative;">
    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
        <tbody>
            <tr>
                <td colspan="5">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="contentEditableContainer contentTextEditable">
                                        <div class="contentEditable" style="font-size:20px;color:#333333;">
                                            <div style="text-align:center;"><img style="width:150px; height:180px;" src="'.$defult_photo.'" /></div>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>&nbsp;</td>
                <td>
                    <table border="0" cellpadding="0" cellspacing="0" style="width:100%">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="contentEditableContainer contentTextEditable">
                                        <div class="contentEditable" style="font-size:20px;color:#333333;">
                                            <div style="text-align:center;margin-top:-10px;">
                                                <p>'.$username111.' ('.$matri_id111.')</p>
                                            </div>

                                            <div class="contentEditable" style="font-size:14px;color:#333333;line-height:22px;text-align:center;">
                                                <p>'.$age.', '.$height.' | '.$religion_name.' : '.$caste_name.' | Location : '.$location.' | Education : '.$education_name.' | Occupation : '.$occupation_name.'</p>
                                                <a href="'.$profile_link.'" style="background: #01bcd5; border-radius: 8px; border: none; padding: 10px 25px; width: 80%; color: #fff;text-decoration:none;">View Profile</a>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr></tr>
                        </tbody>
                    </table>
                </td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>

<div style="border-top: 1px solid #01bcd5;margin-top:20px;">

</div>';
}						
							$array_repla = array('sender'=>$sender,'username'=>$username,'webfriendlyname'=>$webfriendlyname,'matri_id'=>$matri_id,"site_domain_name"=>$web_name,"facebook_link"=>$facebook_link,"twitter_link"=>$twitter_link,"linkedin_link"=>$linkedin_link,"footer_text"=>$footer_text,"template_image_url"=>$template_image_url,"contact_no"=>$contact_no,"from_email"=>$from_email,"contact_us"=>$contact_us,"android_app_link"=>$android_app_link,"part_basic_detail"=>$part_basic_detail,"member_data_html"=>$member_data_html);
							
							$message_email = $this->common_model->getstringreplaced($message,$array_repla);
							
							$subject = $this->common_model->getstringreplaced($subject,$array_repla);
							
							$to_email = $email;
							
							if($to_email !="" && $message !="")
							{
								$msg = $this->common_model->common_send_email($to_email,$subject,$message_email);
							}
							
							if(isset($user_data['mobile']) && $user_data['mobile'] != '')
							{
								$mobile = $user_data['mobile'];
								$get_sms_temp = $this->common_front_model->get_sms_template('Interest Received');
								$template_id =$get_sms_temp['template_id'];
								if(isset($get_sms_temp) && $get_sms_temp!='')
								{
									$sms_template_update = htmlspecialchars_decode($get_sms_temp['sms_content'],ENT_QUOTES);
									$trans = array("XXXnameXXX"=>$sender,"web_frienly_name"=>$webfriendlyname);
							
									$sms_template = $this->common_front_model->sms_string_replaced($sms_template_update, $trans);
									
									$this->common_model->common_sms_send($mobile,$sms_template,$template_id);
								}
							}
							$data1['status'] = 'success';
							$data1['errmessage'] = "You have successfully send expressed interest to Matri ID $receiver.";
							$interest_data = $this->common_front_model->get_user_data('register',$receiver,'id,web_device_id,ios_device_id,android_device_id','matri_id');
							if(isset($interest_data) && $interest_data!='' && count($interest_data)>0)
							{
			$interest_message = 'You receive interest from '.$sender;
			$receiver_id = $interest_data['id'];
			foreach ($interest_data as $key => $value) {
				if(isset($value) && $value!='' && isset($key) && $key!='')
				{
					if($key=='web_device_id'){
						if(isset($interest_data['web_device_id']) && $interest_data['web_device_id']!=''){
							$data_array = array(
								'device_id'=>$interest_data['web_device_id'],
								'sender_id' => $sender_data['id'],
								'receiver_id' => $receiver_id,
								'notification_type' => 'interest_receive',
								'title' => 'Interest Receive',
								'message' => $interest_message,
								'click_action'=>base_url().'express-interest',
							);
							$this->common_model->new_send_notification_web($data_array);
						}
					}
					else if($key=='ios_device_id' || $key=='android_device_id'){
						if($key == 'ios_device_id'){
							$app_type = 'IOS';
						}
						else{
							$app_type = 'Android';
						}
						$sender_receiver = array('sender'=> $sender_data['id'],'receiver'=>$receiver_id,'app_type'=>$app_type);
						$this->common_model->new_send_notification_android($value,$interest_message,'Interest Receive','interest_receive',$sender_data['id'],'','',$sender_receiver);
					}
				}
			}	
		}
						}else{
							$data1['status'] = 'error';
							if(isset($mem_plan['plan_status']) && $mem_plan['plan_status']=='Not Paid'){
								$data1['errmessage'] = "You are not a paid member, Please upgrade your membership to express the interest.";	
							}
							else if(isset($mem_plan['plan_status']) && $mem_plan['plan_status']=='Expired'){
								$data1['errmessage'] = "You can't send express interest because your plan has been expired.";
							}
							else{
								$data1['errmessage'] = "You are not a paid member, Please upgrade your membership to express the interest.";
							}
						}
					}
				}else{
					$data1['status'] = 'error';
					$data1['errmessage'] = "Something are wrong, Please try Again.";
				}
			}else{
				$data1['status'] = 'error';
				$data1['errmessage'] = "You have already send express interest.";
			}
		}else{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Sorry, Your session hase been time out, Please login Again.";
		}
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
	}
	
	
	/*public function send_message()
	{
	
		$status = 'error';
		$error_message = "";
		$user_id = $this->common_front_model->get_user_id('matri_id','matri_id');
		if($user_id !=''){
		
			$message = '';
			$receiver_id = '';
			$msg_status ='';
			$subject ='';
			$message_id = '';
		
			if($this->input->post('message')){
				$message = $this->input->post('message');
			}
			if($this->input->post('subject')){
				$subject = $this->input->post('subject');
			}
			if($this->input->post('msg_status')){
				$msg_status = $this->input->post('msg_status');
			}
			if($this->input->post('receiver_id')){
				$receiver_id = $this->input->post('receiver_id');
			}
			if($this->input->post('message_id')){
				$message_id = $this->input->post('message_id');
			}
			
			if($message !='' && $receiver_id !=''){
				
				$sent_on = $this->common_model->getCurrentDate();
				$count_rec = count($receiver_id);
				
				if($msg_status == 'sent'){
					$count_msg = $this->common_front_model->get_plan_detail($user_id,'message','Yes');
					$message_used = $this->common_front_model->get_plan_detail($user_id,'message_used','Yes');
					$remaining = $count_msg - $message_used;
					
					if($count_rec > $remaining || $message_used > $count_msg){
						$msg_status = 'draft';
						$error_message = "Message not sent successfully,you have not enough message credit limit, Please upgrade your plan, your message saved in draft.";
					}
				}
				
				$retuen_resp_succ = true;
				$msg_succ_sent_arr = array();
				$msg_block_sent_arr = array();
				
				
				$block_count = $this->common_model->get_count_data_manual('block_profile',array('block_to'=>$user_id,'block_by'=>$receiver_id,'is_deleted'=>'No'),0,'id');
					if($block_count == 1)
					{
						$msg_block_sent_arr[] = $receiver_id;
					}
					else
					{
						$msg_succ_sent_arr[] = $receiver_id;
					}
					$data_array_custom = array(
						'sender'=>$user_id,
						'receiver'=>$receiver_id,
						'subject'=>$subject,
						'content'=>$message,
						'status'=>$msg_status,
						'sent_on'=>$sent_on
					);
					
					$retuen_resp = $this->common_front_model->save_update_data("message",$data_array_custom);
					
					if($retuen_resp && $msg_status == 'sent')
					{
						$this->send_message_mail($data_array_custom);
					}
				
				if($retuen_resp_succ && $error_message =='')
				{
					if($msg_status == 'sent')
					{
						$imp_succ_mat = '';
						$imp_block_mat = '';
						if(isset($msg_succ_sent_arr) && count($msg_succ_sent_arr) > 0)
						{
							$imp_succ_mat = implode(', ',$msg_succ_sent_arr);
							$error_message = "Message Sent Successfully to Matri ID $imp_succ_mat.";
						}
						if(isset($msg_block_sent_arr) && count($msg_block_sent_arr) > 0)
						{
							$imp_block_mat = implode(', ',$msg_block_sent_arr);
							$error_message = $error_message." Message not Sent to Matri ID $imp_block_mat because of this member has blocked you.";
						}
					}
					else
					{
						$error_message = "Message Saved Successfully in draft";
					}
					if(isset($msg_succ_sent_arr) && count($msg_succ_sent_arr) > 0)
					{
						$status ='success';
					}
					else
					{
						$status ='error';
					}
				}
				else
				{
					if($error_message =='')
					{
						$error_message = "Message Not Sent, Please try again";
					}
				}
			}
			else
			{
				$error_message = "Please enter message and provide Receiver ID";
			}
		}
		else
		{
			$error_message = "Your session time out, Please Login First";
		}
		$data = $this->common_front_model->return_jsone_response($status,'',$error_message,'error_message');
		return $data;
	
	}
	
	public function send_message_mail($data_array_custom='')
	{ 
		if($data_array_custom !='' && count($data_array_custom) > 0)
		{
			if(isset($data_array_custom['sender']) && $data_array_custom['sender'] !='')
			{
				$sender = $data_array_custom['sender'];
				$receiver = $data_array_custom['receiver'];
				$this->common_front_model->update_plan_detail($sender,'message');
				if($this->email_templ_data == '')
				{
					$this->email_templ_data = $this->common_front_model->getemailtemplate('New Message');
				}
				if($this->sms_templ_data == '')
				{
					$this->sms_templ_data = $this->common_front_model->get_sms_template('Message Received');
				}
				$email_temp_data = $this->email_templ_data;
				$sms_templ_data = $this->sms_templ_data;
				if($receiver !='')
				{
					$rec_detail = $this->common_model->get_count_data_manual('register',array('matri_id'=>$receiver),1,'email, username,mobile');
					$username = $rec_detail['username'];
					$data_array = array('sender'=>$sender,'username'=>$username,'member'=>$username);
					if(isset($rec_detail['email']) && $rec_detail['email'] !='' && $email_temp_data !='' && count($email_temp_data) > 0)
					{
						$rec_eamil = $rec_detail['email'];
						$email_content = $email_temp_data['email_content'];
						$email_subject = $email_temp_data['email_subject'];
						$email_content = $this->common_front_model->getstringreplaced($email_content,$data_array);
						$email_subject = $this->common_front_model->getstringreplaced($email_subject,$data_array);
						$this->common_model->common_send_email($rec_eamil,$email_subject,$email_content);
					}
					if(isset($rec_detail['mobile']) && $rec_detail['mobile'] !='' && $sms_templ_data !='' && count($sms_templ_data) > 0)
					{
						$mobile = $rec_detail['mobile'];
						$sms_content = $sms_templ_data['sms_content'];
						$sms_content = $this->common_front_model->getstringreplaced($sms_content,$data_array);
						$this->common_model->common_sms_send($mobile,$sms_content);
					}
				}
			}
			
		}
	}
	*/
	public function get_online_member_result()
	{
		$this->common_front_model->set_orgin();
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		$gender = $this->common_front_model->get_session_data('gender');
		
		if($gender =='Male'){
			$gender = 'Female';
		}else{
			$gender = 'Male';
		}
		
		$where_search11= "gender = '$gender'";
		$member_data = $this->common_model->get_count_data_manual('online_users',$where_search11,2,'index_id',$order_by='','',$limit='',0);
		
		return $member_data;
	}
	
	public function get_online_count($data_array='')
	{
		$this->add_online_data($data_array);
		$member_count = $this->common_model->get_count_data_manual('register_view','',0);
		return $member_count;
	}
	public function get_online_result($page='',$data_array='')
	{
		$this->add_online_data($data_array);
		$member_data = $this->common_model->get_count_data_manual('register_view','',2,'',$order_by='',$page,$limit='');
		return $member_data;
	}
	
	public function add_online_data($data_array)
	{
		$this->common_front_model->set_orgin();
		// for web API
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		if($user_agent!='NI-WEB')
		{
			$member_front_search = $this->search_model->set_search();
		}// for web API
		else
		{
			$member_front_search = $this->session->userdata('member_front_search');
		}
		if(isset($member_front_search['search_where']) && $member_front_search['search_where'] !='')
		{
			$this->db->where($member_front_search['search_where']);
		}

		//print_r($data_array);
		foreach($data_array as $key => $val){
			$array[] = $val['index_id'];
		}
		// set search for approvedd user only
		$this->db->where_in('id',$array);
	}
	
	public function member_like()
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$member_id = $this->input->post('matri_id');
			$sender_id = $this->input->post('logged_in_user_id');
		}else{
			$member_id = $this->common_front_model->get_session_data('matri_id');
			$sender_id = $this->common_front_model->get_session_data('id');
		}
		
		$my_id = $member_id;
		$other_id = $this->input->post('other_id');
		$like_status = $this->input->post('like_status');
		$created_on = $this->common_model->getCurrentDate();
		$other_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$other_id),1,'gender','','');
		$own_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$member_id),1,'gender','','');
		
		$my_gender = '';
		if(isset($own_data['gender']) && $own_data['gender']!=''){
			$my_gender = $own_data['gender'];
		}
		$other_gender = '';
		if(isset($other_data['gender']) && $other_data['gender']!=''){
			$other_gender = $other_data['gender'];
		}
		
		if($member_id != ''){
			if($my_gender!='' && ($my_gender != $other_gender)){
				if($my_id != '' && $other_id != '' && $like_status != ''){
					$where_array = array('my_id'=>$my_id,'other_id'=>$other_id);
					$member_likes_count = $this->common_model->get_count_data_manual('member_likes',$where_array,0,'');
					$member_likes_data = $this->common_model->get_count_data_manual('member_likes',$where_array,1,'');
					
					if($member_likes_count > 0 ){
						if($member_likes_data['like_status'] != $like_status){
							$data_array = array('like_status'=>$like_status,'created_on' => $created_on);
							$update = $this->common_model->update_insert_data_common('member_likes',$data_array,array('my_id'=>$my_id,'other_id'=>$other_id));
							if($update){
								if($like_status == 'Yes'){
									$data['errmessage'] =  "You like $other_id";
									$data['image_name'] =  "Yes";
									$data['status'] = 'success';
									
									//app push notification
			$other_data = $this->common_front_model->get_user_data('register',$my_id,'id','matri_id');
			$like_data = $this->common_front_model->get_user_data('register',$other_id,'ios_device_id,android_device_id,web_device_id,id','matri_id');
			if(isset($like_data) && $like_data!='' && count($like_data)>0)
			{
				$like_message = 'Your id was LIKE by '.$my_id;
				foreach ($like_data as $key => $value) {
					if($key=='web_device_id'){
						if(isset($like_data['web_device_id']) && $like_data['web_device_id']!=''){
							$data_array = array(
								'device_id'=>$value,
								'sender_id' => $other_data['id'],
								'receiver_id' => $like_data['id'],
								'notification_type' => 'like_member',
								'title' => 'Like Member',
								'message' => $like_message,
								'click_action'=>base_url().'search/view-profile/'.$my_id,
							);
							$this->common_model->new_send_notification_web($data_array);
							}
						}else if($key=='ios_device_id' || $key=='android_device_id'){
							if($key == 'ios_device_id'){
								$app_type = 'IOS';
							}
							else{
								$app_type = 'Android';
							}
							$sender_receiver = array('sender'=>$other_data['id'],'receiver'=>$like_data['id'],'app_type'=>$app_type);
							$this->common_model->new_send_notification_android($value,$like_message,'LIKE','like_member',$sender_id,'','',$sender_receiver);
						}
										}	
									}
								}elseif($like_status == 'No'){
									$data['errmessage'] = "You didn't like $other_id";
									$data['image_name'] = "No";
									$data['status'] = 'success';
								}else{
									$data['errmessage'] = "You are not sure you like or dislike $other_id";
									$data['image_name'] = "May be";
									$data['status'] = 'error';
								}
							}else{
								$data['errmessage'] = "Please try again..!!!";
								$data['status'] = 'error';
							}
						}else{
							if($like_status == 'Yes'){
								$data['errmessage'] = "You have already sent like this $other_id";
								$data['image_name'] = "Yes";
							}elseif($like_status == 'No'){
								$data['errmessage'] = "You have already dislike this $other_id";
								$data['image_name'] = "No";
							}else{
								$data['errmessage'] = "You have already not sure you like or dislike this $other_id";
								$data['image_name'] = "May be";
							}
							$data['status'] = 'success';
						}				
					}else{
						$insert = $this->common_model->update_insert_data_common('member_likes',array('my_id' => $my_id,'other_id' => $other_id,'like_status' => $like_status,'created_on' => $created_on),'',0);
						if($insert){
							if($like_status == 'Yes'){
								$data['errmessage'] =  "You like $other_id";
								$data['image_name'] =  "Yes";
							}elseif($like_status == 'No'){
								$data['errmessage'] =  "You didn't like $other_id";
								$data['image_name'] =  "No";
							}elseif($like_status == 'May be'){
								$data['errmessage'] =  "You are not sure you like or dislike $other_id";
								$data['image_name'] =  "May be";
							}
							$data['status'] = 'success';
						}else{
							$data['errmessage'] =  "Please try again..!!!";
							$data['status'] = 'error';
						}
					}
				}else{
					$data['errmessage'] =  "Please try again..!!!";
					$data['status'] = 'error';
				}
			}else{
				$data['errmessage'] =  "Please Login First.";
				$data['status'] = 'error';
			}
		}else{
			$data['errmessage'] =  "Please Login First.";
			$data['status'] = 'error';
		} 
		
		$data['tocken'] = $this->security->get_csrf_hash();
		return $data;
	}
	/*===============mahejbin (05-06-2018) start here===========*/
	function view_profile_details($matri_id){
		$mytri_id = $this->common_front_model->get_session_data('matri_id');
		$today_date = date('Y-m-d');//date('Y-m-d H:i:s');
		$created_on = $this->common_model->getCurrentDate();
		$where_array = array('current_plan'=>'Yes','matri_id'=>$mytri_id);
		$payments_data = $this->common_model->get_count_data_manual('payments_view',$where_array,1,'');
		$payments_data_count = $this->common_model->get_count_data_manual('payments_view',$where_array,0,'');
		
		if($payments_data_count>0){
			$total_profiles = $payments_data['profile'];
			$profile_used =$payments_data['profile_used'];
			$plan_expired =$payments_data['plan_expired'];
			$today_date = date('Y-m-d');//date('Y-m-d H:i:s');
		
			if($plan_expired >= $today_date){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 1;
		}		
	}
	/*===============mahejbin (05-06-2018) end here===========*/
	function view_contact_details()
	{
		$view_contact = 'No';
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
			
		if($user_agent == 'NI-AAPP'){
			$my_id = $this->input->post('matri_id');
		}else{
			$my_id = $this->common_front_model->get_session_data('matri_id');
		}
		$from_id = $this->input->post('receiver_matri_id');
		$created_on = $this->common_model->getCurrentDate();
		
		$block_count = $this->common_model->get_count_data_manual('block_profile',array('block_to'=>$my_id,'block_by'=>$from_id,'is_deleted'=>'No'),0,'');
		
		if($my_id != '' && $from_id != ''){
			$where_array = array('current_plan'=>'Yes','matri_id'=>$my_id);
			$payments_data = $this->common_model->get_count_data_manual('payments_view',$where_array,1,'');
			$payments_data_count = $this->common_model->get_count_data_manual('payments_view',$where_array,0,'');
		
			$total_contacts =$payments_data['contacts'];
			$contacts_used =$payments_data['contacts_used'];
			$plan_expired =$payments_data['plan_expired'];
			$today_date = date('Y-m-d');//date('Y-m-d H:i:s');
			$remaining_contact = $total_contacts-$contacts_used;
		
			$where_array_checker = array('my_id'=>$my_id,'viewed_id'=>$from_id);
			$contact_checker = $this->common_model->get_count_data_manual('contact_checker',$where_array_checker,0,'','','','','','');
			if($user_agent == 'NI-AAPP'){
				if($remaining_contact > 0 && $plan_expired >= $today_date)
				{
					if($contact_checker == 0){
						$insert_contact_checker = $this->common_model->update_insert_data_common('contact_checker',array('my_id' => $my_id,'viewed_id' => $from_id,'date' => $created_on),'',0);
						
						$contacts_used = $contacts_used + 1;
						$update_payments = $this->common_model->update_insert_data_common('payments',array('contacts_used' => $contacts_used),array('current_plan'=>'Yes','matri_id'=>$my_id));
						$data['errmessage'] = 'First time seen.';
					}else{
						$data['errmessage'] = 'Contact details have been already seen.';
					}
					$where_array_member = array('matri_id'=>$from_id);
					$member_data = $this->common_model->get_count_data_manual('register_view',$where_array_member,1,'');
					
					$image = $this->common_model->member_photo_disp($member_data);
					$matri_id = $member_data['matri_id'];
					$username = $member_data['username'];
					$mobile = $member_data['mobile'];
					$email = $member_data['email'];
					$time_to_call = $member_data['time_to_call'];					
					if($member_data['contact_view_security'] == 1){
						if($block_count == 1)
						{
							$data['success'] = 'error';
							$data["errmessage"] = "This member has blocked you. You can't see his contact details.";
						}else{
							$data["contact_details"] = array("matri_id"=>$matri_id,"username"=>$username,"mobile"=>$mobile,"email"=>$email,"time_to_call"=>$time_to_call,"image"=>$image);
							$view_contact = 'Yes';
							$data['success'] = 'success';
						}
					}else{
						$where_array_expressinterest = array('sender'=>$my_id,'receiver'=>$from_id,'receiver_response'=>'Accepted');
							$expressinterest_count = $this->common_model->get_count_data_manual('expressinterest',$where_array_expressinterest,0,'');							
							if($expressinterest_count > 0){
							if($block_count == 1)
							{
								$data['success'] = 'error';
								$data["errmessage"] = "This member has blocked you. You can't see his contact details.";
							}else{
								$data["contact_details"] = array("matri_id"=>$matri_id,"username"=>$username,"mobile"=>$mobile,"email"=>$email,"time_to_call"=>$time_to_call,"image"=>$image);
								$view_contact = 'Yes';
								$data['success'] = 'success';
							}
						}
						else{
							$data['success'] = 'error';
							$data["errmessage"] = "This member only shows his/her contact details if you have already sent him/her express interest, and he/she has accepted it.";
						}
					}
					$data['tocken'] = $this->security->get_csrf_hash();
					$data1['data'] = json_encode($data);
					$this->load->view('common_file_echo',$data1);
				}else{
					$data['errmessage'] = 'Please upgrade your contact plan.';
					$data['success'] = 'error';
					$data['tocken'] = $this->security->get_csrf_hash();
					$data1['data'] = json_encode($data);
					$this->load->view('common_file_echo',$data1);
				}
			}else{
				if($remaining_contact > 0 && $plan_expired >= $today_date){
					$where_array_member = array('matri_id'=>$from_id);
					$member_data = $this->common_model->get_count_data_manual('register_view',$where_array_member,1,'');
					$path_photos = $this->common_model->path_photos;
					$gender = $this->common_front_model->get_session_data('gender');
					if(isset($gender) && $gender == 'Male'){
						$photopassword_image = base_url().'assets/images/photopassword_female.png';
					}else{
						$photopassword_image = base_url().'assets/images/photopassword_male.png';
					}
					$check_permission_view=array('ph_requester_id'=>$my_id,'ph_receiver_id'=>$from_id,'receiver_response'=>'Accepted','status'=>'1');
					$photo_view_count = $this->common_model->get_count_data_manual('photoprotect_request',$check_permission_view,0,'*','','','','');
					if(isset($member_data['photo1']) && $member_data['photo1'] !='' && isset($member_data['photo1_approve']) && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && isset($member_data['photo_view_status']) &&  $member_data['photo_view_status'] == 0 && isset($photo_view_count) && $photo_view_count == 0){
						$image = $photopassword_image;
					}else{
						if(isset($member_data['gender']) && $member_data['gender'] == 'Male'){
							$defult_photo = base_url().'assets/front_end/img/default-photo/male.png';
						}else{
							$defult_photo = base_url().'assets/front_end/img/default-photo/female.png';
						}
						if(isset($member_data['photo1']) && $member_data['photo1'] !='' && $member_data['photo1_approve'] =='APPROVED' && file_exists($path_photos.$member_data['photo1']) && ($member_data['photo_view_status'] == 1 || ($member_data['photo_view_status'] == 2 && $plan_status == 'Paid') || (isset($member_data['photo_view_status']) &&  $member_data['photo_view_status'] ==0 && isset($photo_view_count) && $photo_view_count > 0))){
							$image = base_url().$path_photos.$member_data['photo1'];
						}else{
							$image = $defult_photo;
						}
					}
					//$image = $this->common_model->member_photo_disp($member_data);
					$matri_id = $member_data['matri_id'];
					$username = $member_data['username'];
					$mobile = $member_data['mobile'];
					$email = $member_data['email'];
					if(isset($member_data['address']) && $member_data['address']!=''){
						$address = $member_data['address'];
					}else{
						$address = $this->common_model->display_data_na($member_data['address']);
					}
					
					$time_to_call = $member_data['time_to_call'];	
					if($member_data['city_name']!='' && $member_data['state_name']!='' && $member_data['country_name']!=''){
						$lives_in = $member_data['city_name'].', '.$member_data['state_name'].', '.$member_data['country_name'];
					}else{
						$lives_in = $member_data['address'];
					}
					
					if($contact_checker > 0 ){
						$note = 'Contact details have been already seen.';
					}
					else{
						$contact_desplay = $remaining_contact-1;
						$note = 'Remaining Contacts ('.$contact_desplay.')';
					}
					if($time_to_call==''){ $time_to_call='N/A';}
					if($member_data['contact_view_security'] == 1){
						if($block_count == 1){
							$data['contact_details']="
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
										<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
										<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>×</button>
									</div>											
									<div class='modal-body'>
										<div class='alert alert-info'>
											<strong>This member has blocked you. You can't see his contact details.</strong>
										</div>
									</div>
								</div>
							</div>";
						}
						else
						{
							if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
							{
								$address = $this->common_model->disable_in_demo_text;
								$lives_in = $this->common_model->disable_in_demo_text;
								$mobile  = $this->common_model->disable_in_demo_text;
								$email  = $this->common_model->disable_in_demo_text;
							}
							$view_contact = 'Yes';
							$data['contact_details']="
								<div class='modal-dialog modal-dialog-vendor'>
									<div class='modal-content'>
										<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
										<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
											<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>&times;</button>
										</div>											
										<div class='modal-body' style='word-break: break-word;'>
											<div class='alert alert-info'>
												<strong>$note</strong>
											</div>
											<div class='row'>
												<div class='col-md-4 col-sm-4 col-xs-12'>
													<img src='$image' title='$from_id' alt='$from_id' class='img-responsive'>
												</div>
												<div class='col-md-8 col-sm-8 col-xs-12 pull-right'>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-user'></i> Matri Id :
														<span class='Poppins-Semi-Bold f-15'>$from_id</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-user'></i> Name  : 
														<span class='Poppins-Semi-Bold f-15'>$username</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-home'></i> Address : 
														<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$address</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-map-marker' style='font-size: 17px;'></i>  Lives In : 
														<span class='Poppins-Semi-Bold f-15'>$lives_in</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-phone'></i> Mobile : 
														<span class='Poppins-Semi-Bold f-15'>$mobile</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-envelope' style='font-size: 11px;'></i> Email Id : 
														<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$email</span></span>
													</div>
													<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
														<span> <i class='fa fa-clock-o'></i> Time To Call :
														<span class='Poppins-Semi-Bold f-15'>$time_to_call</span></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>";
							}
							
							if($contact_checker == 0){
								$insert_contact_checker = $this->common_model->update_insert_data_common('contact_checker',array('my_id' => $my_id,'viewed_id' => $from_id,'date' => $created_on),'',0);
								
								$contacts_used = $contacts_used + 1;
								$update_payments = $this->common_model->update_insert_data_common('payments',array('contacts_used' => $contacts_used),array('current_plan'=>'Yes','matri_id'=>$my_id));
							}
							
							$data['success'] = 'success';
							$data['tocken'] = $this->security->get_csrf_hash();

							$data1['data'] = json_encode($data);
							$this->load->view('common_file_echo',$data1);
							
						}else{
						
							$where_array_expressinterest = array('sender'=>$my_id,'receiver'=>$from_id,'receiver_response'=>'Accepted');
							$expressinterest_count = $this->common_model->get_count_data_manual('expressinterest',$where_array_expressinterest,0,'');							
							if($expressinterest_count > 0){
								
								$where_array_block_profile = array('block_to'=>$my_id,'block_by'=>$from_id);
								$block_count = $this->common_model->get_count_data_manual('block_profile',$where_array_block_profile,0,'');
								
								if($block_count > 0){
									$data['contact_details']="
									<div class='modal-dialog'>
										<div class='modal-content'>
											<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
												<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
												<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>×</button>
											</div>											
											<div class='modal-body'>
												<div class='alert alert-info'>
													<strong>This member has blocked you. You can't see his contact details.</strong>
												</div>
											</div>
										</div>
									</div>";
								}
								else{
									if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1)
									{
										$address = $this->common_model->disable_in_demo_text;
										$lives_in = $this->common_model->disable_in_demo_text;
										$mobile  = $this->common_model->disable_in_demo_text;
										$email  = $this->common_model->disable_in_demo_text;
									}
									$view_contact = 'Yes';
									$data['contact_details']="
									<div class='modal-dialog modal-dialog-vendor'>
										<div class='modal-content'>
											<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
											<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
												<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>&times;</button>
											</div>											
											<div class='modal-body'>
												<div class='alert alert-info'>
													<strong>$note</strong>
												</div>
												<div class='row'>
													<div class='col-md-4 col-sm-4 col-xs-12'>
														<img src='$image' title='$from_id' alt='$from_id' class='img-responsive'>
													</div>
													<div class='col-md-8 col-sm-8 col-xs-12 pull-right'>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-user'></i> Matri Id :
															<span class='Poppins-Semi-Bold f-15'>$from_id</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-user'></i> Name  : 
															<span class='Poppins-Semi-Bold f-15'>$username</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-home'></i> Address : 
															<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$address</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-map-marker' style='font-size: 17px;'></i>  Lives In : 
															<span class='Poppins-Semi-Bold f-15'>$lives_in</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-phone'></i> Mobile : 
															<span class='Poppins-Semi-Bold f-15'>$mobile</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-envelope' style='font-size: 11px;'></i> Email Id : 
															<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$email</span></span>
														</div>
														<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
															<span> <i class='fa fa-clock-o'></i> Time To Call :
															<span class='Poppins-Semi-Bold f-15'>$time_to_call</span></span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>";
								if($contact_checker == 0){
									$insert_contact_checker = $this->common_model->update_insert_data_common('contact_checker',array('my_id' => $my_id,'viewed_id' => $from_id,'date' => $created_on),'',0);
									
									$contacts_used = $contacts_used + 1;
									$update_payments = $this->common_model->update_insert_data_common('payments',array('contacts_used' => $contacts_used),array('current_plan'=>'Yes','matri_id'=>$my_id));
								}
							}
						}else{
							$data['contact_details']="
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
										<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
										<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>×</button>
									</div>											
									<div class='modal-body'>
										<div class='alert alert-info'>
											<strong>This member only shows his/her contact details if you have already sent him/her express interest, and he/she has accepted it.</strong>
										</div>
									</div>
								</div>
							</div>";
						}
						$data['success'] = 'success';
						$data['tocken'] = $this->security->get_csrf_hash();
						$data1['data'] = json_encode($data);
						$this->load->view('common_file_echo',$data1);
					}
				}else{
					if($contact_checker > 0 && $payments_data_count > 0 && $plan_expired >= $today_date){
						$where_array_member = array('matri_id'=>$from_id);
						$member_data = $this->common_model->get_count_data_manual('register_view',$where_array_member,1,'');
					
						if($member_data['contact_view_security'] == 1){
							$image = $this->common_model->member_photo_disp($member_data);
							$matri_id = $member_data['matri_id'];
							$username = $member_data['username'];
							$mobile = $member_data['mobile'];
							$email = $member_data['email'];
							if(isset($member_data['address']) && $member_data['address']!=''){
								$address = $member_data['address'];
							}else{
								$address = $this->common_model->display_data_na($member_data['address']);
							}
							if($member_data['city_name'] != '' && $member_data['state_name'] != '' && $member_data['country_name'] != ''){
								$lives_in = $member_data['city_name'].','.$member_data['state_name'].','.$member_data['country_name'];
							}else{
								$lives_in = $member_data['address'];
							}
							if(isset($this->common_model->is_demo_mode) && $this->common_model->is_demo_mode == 1){
								$address = $this->common_model->disable_in_demo_text;
								$lives_in = $this->common_model->disable_in_demo_text;
								$mobile  = $this->common_model->disable_in_demo_text;
								$email  = $this->common_model->disable_in_demo_text;
							}
							$view_contact = 'Yes';
							$data['contact_details']="
							<div class='modal-dialog modal-dialog-vendor'>
								<div class='modal-content'>
									<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
									<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
										<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>&times;</button>
									</div>											
									<div class='modal-body'>
										<div class='alert alert-info'>
											<strong>Contact details have been already seen.</strong>
										</div>
										<div id='respond_contact_details'></div>
										<div class='row'>
											<div class='col-md-4 col-sm-4 col-xs-12'>
												<img src='$image' title='$from_id' alt='$from_id' class='img-responsive'>
											</div>
											<div class='col-md-8 col-sm-8 col-xs-12 pull-right'>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-user'></i> Matri Id :
													<span class='Poppins-Semi-Bold f-15'>$from_id</span></span>
												</div>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-user'></i> Name  : 
													<span class='Poppins-Semi-Bold f-15'>$username</span></span>
												</div>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-home'></i> Address : 
													<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$address</span></span>
												</div>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-map-marker' style='font-size: 17px;'></i>  Lives In : 
													<span class='Poppins-Semi-Bold f-15'>$lives_in</span></span>
												</div>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-phone'></i> Mobile : 
													<span class='Poppins-Semi-Bold f-15'>$mobile</span></span>
												</div>
												<div class='col-md-12 col-sx-12 col-sm-12 mt-3'>
													<span> <i class='fa fa-envelope' style='font-size: 11px;'></i> Email Id : 
													<span class='Poppins-Semi-Bold f-15' style='word-break: break-all;'>$email</span></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>";
						}else{
							$data['contact_details']="
							<div class='modal-dialog'>
								<div class='modal-content'>
									<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
										<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
										<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>×</button>
									</div>											
									<div class='modal-body'>
										<div class='alert alert-info'>
											<strong>Member not share his contact details.</strong>
										</div>
									</div>
								</div>
							</div>";
						}
					}else{
						$data['contact_details']="
						<div class='modal-dialog'>
							<div class='modal-content'>
								<div class='modal-header new-header-modal' style='border-bottom: 1px solid #e5e5e5;'>
									<p class='Poppins-Bold mega-n3 new-event text-center'><i class='fa fa-phone'></i> Contact Details of <span class='mega-n4 f-s'>$from_id</span></p>
									<button type='button' class='close close-vendor' data-dismiss='modal' style='margin-top: -37px !important;'>×</button>
								</div>											
								<div class='modal-body'>
									<div class='alert alert-info'>
										<strong>You have not enough contact remain, Please upgrade your plan.</strong>
									</div>
								</div>
							</div>
						</div>";
					}
					$data['errmessage'] = 'You have not enough contact remain, Please upgrade your plan.';
					$data['success'] = 'success';
					$data['tocken'] = $this->security->get_csrf_hash();

					$data1['data'] = json_encode($data);
					$this->load->view('common_file_echo',$data1);
				}
			}
			if($view_contact == 'Yes'){
	$row_data = $this->common_model->get_count_data_manual('register',array('matri_id'=>$from_id),1,'id,web_device_id,ios_device_id,android_device_id','id asc','','');
	if(isset($row_data) && $row_data!='' && count($row_data)>0){
		foreach($row_data as $key => $value){
			if(isset($value) && $value!='' && isset($key) && $key!=''){
				$M_message = $from_id.': Your contact details viewed from '.$my_id;
				$ss_data = $this->common_front_model->get_user_data('register',$my_id,'id','matri_id');
				$from_data = $this->common_front_model->get_user_data('register',$from_id,'id','matri_id');
				$sender_user_id = $ss_data['id'];
				$receiver_user_id = $from_data['id'];
				if($key == 'web_device_id'){
					if(isset($row_data['web_device_id']) && $row_data['web_device_id']!=''){
						$data_array = array(
							'device_id'=>$value,
							'sender_id' => $sender_user_id,
							'receiver_id' => $receiver_user_id,
							'notification_type' => 'viewed_contact_details',
							'title' => 'Viewed Contact Details',
							'message' => $M_message,
							'click_action'=>base_url().'search/view-profile/'.$my_id,
						);
						$this->common_model->new_send_notification_web($data_array);
					}
				}else if($key=='ios_device_id' || $key=='android_device_id'){
					if($key == 'ios_device_id'){
						$app_type = 'IOS';
					}
					else{
						$app_type = 'Android';
					}
					$sender_receiver = array('sender'=>$sender_user_id,'receiver'=>$receiver_user_id,'app_type'=>$app_type);
					$this->common_model->new_send_notification_android($value,$M_message,'Viewed Contact Details','viewed_contact_details',$sender_user_id,'','',$sender_receiver);
				}
			}
		}
	}
			}
		}else{
			$data['errmessage'] = 'Your session time out, Please Login Again.';
			$data['error'] = 'error';
			$data['tocken'] = $this->security->get_csrf_hash();

			$data1['data'] = json_encode($data);
			$this->load->view('common_file_echo',$data1);
		}
	}
	
	public function send_photo_password_request()
    {
		$data1['status'] = 'error';
		$data1['errmessage'] = "Please try again";
       
		$ph_requester_id = $this->input->post('requester_id');
		$ph_receiver_id = $this->input->post('receiver_id');
		$ph_msg = $this->input->post('interest_message');
		$ph_reqdate = $this->common_model->getCurrentDate();
		$receiver_response = 'Pending';
		
		$where_arra = array('ph_requester_id'=>$ph_requester_id,'ph_receiver_id'=>$ph_receiver_id,'rec_delete'=>'No',"'receiver_response' != 'Rejected'");
		$del_req_count = $this->common_front_model->get_count_data_manual('photoprotect_request',$where_arra,0,'id','id desc','','','');
		
		if($del_req_count > 0)
		{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Your request for photo is already under consideration. Please have patience while it is being processed.";
		}
		else if(isset($ph_requester_id) && $ph_requester_id!='' && isset($ph_receiver_id) && $ph_receiver_id!='' && isset($ph_msg) && $ph_msg!='')
		{
			$data_array = array(
				'ph_requester_id'=>$ph_requester_id,
				'ph_receiver_id'=>$ph_receiver_id,
				'ph_msg'=>$ph_msg,
				'ph_reqdate'=>$ph_reqdate,
				'receiver_response'=>$receiver_response,
				'status'=>'1',
				'rec_delete'=>'No',
				'sen_delete'=>'No');
								
			$response = $this->common_front_model->save_update_data('photoprotect_request',$data_array);
			
			if($response)
			{
				$data1['status'] = 'success';
				$data1['errmessage'] = "Your request for photo is successfully sent. Please wait for response.";
				//app push notification
				$data_sql = $this->common_front_model->get_user_data('register',$ph_requester_id,'id','matri_id');
				$send_data = $this->common_front_model->get_user_data('register',$ph_receiver_id,'id, ios_device_id, android_device_id, web_device_id','matri_id');
				if(isset($send_data) && $send_data!='' && count($send_data)>0)
				{
					foreach ($send_data as $key => $value) {
						if(isset($value) && $value!='' && isset($key) && $key!='')
						{
							$receiver_id = $send_data['id'];
							$send_message = 'Photo request send by '.$ph_requester_id;
							if($key == 'web_device_id'){
								if(isset($send_data['web_device_id']) && $send_data['web_device_id']!=''){
									## For Web Notification : Date : 20-03-2021
									$data_array = array(
										'device_id'=>$value,
										'sender_id' => $data_sql['id'],
										'receiver_id' => $receiver_id,
										'notification_type' => 'photo_request',
										'title' => 'Photo Request',
										'message' => $send_message,
										'click_action'=>base_url().'my-profile/photo-pass-request-received',
									);
									$this->common_model->new_send_notification_web($data_array);
								}
							}else if($key =='ios_device_id' || $key == 'android_device_id'){
								if($key == 'ios_device_id'){
									$app_type = 'IOS';
								}
								else{
									$app_type = 'Android';
								}
								$sender_receiver = array('sender'=>$data_sql['id'],'receiver'=>$receiver_id,'app_type'=>$app_type);
								$this->common_model->new_send_notification_android($value,$send_message,'Photo Request','photo_request','receive','','',$sender_receiver);
							}
						}
					}	
				}
			}
			else
			{
				$data1['status'] = 'error';
				$data1['errmessage'] = "Please try again.";
			}
		}
		else
		{
			$data1['status'] = 'error';
			$data1['errmessage'] = "Please try again.";
		}
		
		$data1['tocken'] = $this->security->get_csrf_hash();
		$data['data'] = json_encode($data1);
		return $data;
    }
	
	public function check_photo_request()
    {
		$member_id = trim($this->input->post('member_id'));
		$my_id = $this->input->post('my_id');
		if(isset($member_id) && $member_id != '' && isset($my_id) && $my_id != '')
		{
			//$photo_pswd = trim($this->input->post('photo_pswd'));
			$photo_pswd_where = " ( ph_requester_id ='$my_id') and ( ph_receiver_id ='$member_id') and (status != '0') and ( receiver_response ='Accepted') ";
			$this->db->select('*');
			$this->db->where($photo_pswd_where);
			//$this->db->where('is_deleted','No');
			$this->db->limit(1);
			$query = $this->db->get('photoprotect_request');
			$return_message = "";
			$status = 'error';
			if($query->num_rows() == 1)
			{
				$status = 'success';
				$return_message = "Your Request is accepted.";
			}
			else{
				$rej_count = $this->common_model->get_count_data_manual('photoprotect_request',array("( ph_requester_id ='$my_id') and ( ph_receiver_id ='$member_id') and (status != '0') and ( receiver_response ='Rejected')"),0,'*','','','','');
				$pen_count = $this->common_model->get_count_data_manual('photoprotect_request',array("( ph_requester_id ='$my_id') and ( ph_receiver_id ='$member_id') and (status != '0') and ( receiver_response ='Pending')"),0,'*','','','','');
				if($rej_count == 1){
					$return_message = "Your Request is rejected.";
				}
				elseif($pen_count == 1){
					$return_message = "Your Request is pending.";
				}
				else{
					$return_message = "Request is not sent yet.";
				}
			}
		}else{
			$status = 'error';
			$return_message = "Please try again.";
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return json_encode($return_arr);
    }

	public function check_photo_password()
    {
		$member_id = trim($this->input->post('member_id'));
		if(isset($member_id) && $member_id != '')
		{
			$photo_pswd = trim($this->input->post('photo_pswd'));
			$photo_pswd_where = " ( photo_password ='$photo_pswd') and (status != 'UNAPPROVED' and status != 'Suspended' ) and ( matri_id ='$member_id') ";
			$this->db->select('*');
			$this->db->where($photo_pswd_where);
			$this->db->where('is_deleted','No');
			$this->db->limit(1);
			$query = $this->db->get('register');
			$return_message = "";
			$status = 'error';
			if($query->num_rows() == 1)
			{
				$status = 'success';
				$return_message = "Your password right.";
			}else{
				$return_message = "You have enter incorrect password.";
			}
		}else{
			$status = 'error';
			$return_message = "Please try again.";
		}
		$return_arr = array('status'=>$status,'errmessage'=>$return_message,'token'=>$this->security->get_csrf_hash());
		return json_encode($return_arr);
    }
	
	public function common_button_action()
	{
		$user_agent = $this->input->post('user_agent') ? $this->input->post('user_agent') : 'NI-WEB';
		
		if($user_agent!='NI-WEB')
		{
			$user_id = $this->input->post('user_id');
			$member_id = $this->input->post('member_id');
			
			$data['is_short_list'] = false;
			$data['is_block_list'] = false;
			$data['is_like'] = false;
			$data['is_dislike'] = false;
			$data['total_likes'] = 0;
			$data['total_unlikes'] = 0;
			
			if(isset($user_id) && $user_id != '' && isset($member_id) && $member_id != ''){
				$shortlist_where_arra=array('to_id'=>$member_id,'from_id'=>$user_id);
				$shortlist_data = $this->common_model->get_count_data_manual('shortlist',$shortlist_where_arra,1,'id');
				
				if($shortlist_data > 0)
				{
					$data['is_short_list'] = true;
				}
				
				$block_profile_where_arra=array('block_to'=>$member_id,'block_by'=>$user_id);
				$block_profile_data = $this->common_model->get_count_data_manual('block_profile',$block_profile_where_arra,1,'id');
				if($block_profile_data > 0)
				{
					$data['is_block_list'] = true;
				}
				
				$like_dislike_where_array = array('my_id'=>$user_id,'other_id'=>$member_id);
				$like_dislike_data = $this->common_model->get_count_data_manual('member_likes',$like_dislike_where_array,1,'');
				if($like_dislike_data > 0)
				{
					if(isset($like_dislike_data['like_status']) && $like_dislike_data['like_status'] == 'Yes'){
						$data['is_like'] = true;
					}elseif(isset($like_dislike_data['like_status']) && $like_dislike_data['like_status'] == 'No'){
						$data['is_dislike'] = true;
					}
				}
				
				$likes_array = array('like_status'=>'Yes','other_id'=>$member_id);
				$total_likes = $this->common_model->get_count_data_manual('member_likes',$likes_array,0,'');
				if($total_likes > 0)
				{
					$data['total_likes'] = $total_likes;
				}
				
				$unlikes_array = array('like_status'=>'No','other_id'=>$member_id);
				$total_unlikes = $this->common_model->get_count_data_manual('member_likes',$unlikes_array,0,'');
				if($total_unlikes > 0)
				{
					$data['total_unlikes'] = $total_unlikes;
				}
			}
			$data['status'] = 'success';
			$data['errmessage'] = '';
		}
		else
		{
			$data['status'] = 'error';
			$data['errmessage'] = 'Please try again.';
		}
		$data['tocken'] = $this->security->get_csrf_hash();
		$data1['data'] = json_encode($data);
		return $data1;
	}
	
	function view_video()
	{
		$user_login_id = $this->common_front_model->get_session_data('matri_id');
		if(isset($user_login_id) && $user_login_id != '')
		{
			$member_id = $this->input->post('member_id');
			if(isset($member_id) && $member_id != '')
			{
				$where_arra = array('matri_id'=>$member_id);
				$member_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'');
				
				$video_url = $member_data['video_url'];
				$video_approval = $member_data['video_approval'];
				
				if(isset($video_url) && $video_url!='' && isset($video_approval) && $video_approval == 'APPROVED')
				{
					$data['video_details']="
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<button type='button' class='close' data-dismiss='modal'>&times;</button>
													<h4 class='modal-title'><i class='fa fa-video'></i> Video of $member_id</h4>
												</div>
												<div class='modal-body'>
													<div class='xxl-7 xl-7 l-7 m-16 xs-16 s-16 text-center'>
														<iframe id='ytiframe' width='540' height='400'  style='box-shadow:3px 3px 0 0 #ccc;' src='$video_url'  allowfullscreen></iframe>
													</div>
												</div>
											</div>
										</div>";
				}else{
					$data['video_details']="
										<div class='modal-dialog'>
											<div class='modal-content'>
												<div class='modal-header'>
													<button type='button' class='close' data-dismiss='modal'>&times;</button>
													<h4 class='modal-title'><i class='fa fa-phone'></i> Video of $member_id</h4>
												</div>
												<div class='modal-body'>
													<div class='xxl-16 xl-16 l-16 m-16 xs-16 s-16 text-center'>
														<div class='alert alert-info'>
															<h4>
																Member can not share video to others.
															</h4>
														</div>
													</div>
												</div>
											</div>
										</div>";
				}
				$data['success'] = 'success';
				
			}else{
				$data['status'] = 'error';
				$data['errmessage'] = 'Please try again some time.';
			}
		}else{
			$data['errmessage'] = 'Your session time out, Please Login Again.';
			$data['status'] = 'error';
		}
		$data['tocken'] = $this->security->get_csrf_hash();
		$data1['data'] = json_encode($data);
		$this->load->view('common_file_echo',$data1);
	}
	
}