<?php defined('BASEPATH') OR exit('No direct script access allowed');
class My_plan_model extends CI_Model {
	public $data = array();
	public function __construct()
	{
		parent::__construct();
		$this->discount_amount_temp =0;
	}

	public function check_copan($plan_id='',$couponcode ='')
	{	
		$return = 'Some issue, Please try again';
		if($plan_id !='' && $couponcode !='')
		{		
			//$user_agent = 'NI-WEB';
				$today_date = $this->common_model->getCurrentDate('Y-m-d');
				$plan_data = $this->common_model->get_count_data_manual('membership_plan',array('status'=>'APPROVED','id'=>$plan_id),1,' * ','',0,'',0);
				$plan_amount = 0;
				$total_pay = 0;
				if(isset($plan_data['plan_amount']) && $plan_data['plan_amount'] !='')
				{
					$plan_amount = $plan_data['plan_amount'];
				}
				$discount_amount = 0;
				$coupan_data = $this->common_model->get_count_data_manual('coupan_code',array('coupan_code'=>$couponcode,'status'=>'APPROVED'," active_from <= '$today_date' and expired_on >= '$today_date' "),1,' * ','',0,'',0);
				
				if(isset($coupan_data) && $coupan_data !='' && count($coupan_data) > 0)
				{
					$discount_amount = $coupan_data['discount_amount'];
					if($discount_amount > $plan_amount)
					{
						$return = 'Coupon Code cant redeem for this plan';
					}
					else
					{
						$this->discount_amount_temp = $discount_amount;
						$data_array = array('discount_amount'=>$discount_amount,'coupan_code'=>$couponcode,'plan_id'=>$plan_id,);
						$this->session->set_userdata('coupan_data_reddem',$data_array);
						$return = 'success';
					}
				}
				else
				{	
					$return = 'Invalid Coupon Code';
				}
		}
		else
		{
			$return = 'Please enter Coupon Code';
		}
		return $return;
	}
	public  function current_plan_detail()
	{
		$matri_id = $this->common_front_model->get_user_id('matri_id','matri_id');
		//$matri_id = $this->common_front_model->get_session_data('matri_id');
		$where_arr = array('current_plan'=>'Yes','matri_id'=>$matri_id,'is_deleted'=>'No');
		$plan_data = $this->common_front_model->get_count_data_manual('payments',$where_arr,1,'*');
		return $plan_data;
	}
}
?>