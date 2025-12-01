<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Products extends CI_Controller { 
     
    function __construct() { 
        parent::__construct(); 
         
        // Load Stripe library 
        $this->load->library('stripe_lib'); 
        $this->base_url = base_url();
		$this->data['base_url'] = $this->base_url;
		$this->load->model("front_end/my_plan_model");
		$this->common_front_model->last_member_activity();
    } 
     
    public function purchase(){  
        $data = array(); 
        $postData = $this->input->post();    

        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){ 
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post(); 
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            
            $postData['product'] = $product; 
            
            // Make payment 
            $paymentID = $this->payment($postData); 
             
            // If payment successful 
            redirect($this->base_url.'premium-member/payment_status/Stripe');
            exit;

            // if($paymentID){ 
            //     redirect('products/payment_status/'.$paymentID); 
            // }else{ 
            //     $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
            //     $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            // } 
        } 
        $insert_id = $this->session->userdata('recent_reg_id');
        $current_login_user = $this->common_front_model->get_session_data();
        $get_user_data='';
        if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
        {
            $where_arra=array('id'=>$insert_id);
            $get_user_data = $this->common_model->get_count_data_manual('register',$where_arra,1,'id,matri_id,username,address,mobile,email');
        }
        if(isset($current_login_user) && $current_login_user != '' && $current_login_user > 0)
        {
            $get_user_data = $current_login_user;
        }
        $plan_data = $this->session->userdata('plan_data_session');
        $stripe = $this->common_model->get_count_data_manual('payment_method'," name = 'Stripe' ",1,'*','','','',"");       
        if(isset($stripe) && $stripe!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){

            $this->data['get_user_data']=$get_user_data;
            $this->data['stripe']=$stripe;
            $this->data['plan_data']=$plan_data;
            // Pass product data to the details view 
            $this->load->view('front_end/stripe_checkout', $this->data); 

        }else{
            redirect($this->base_url.'premium-member');
            exit;
        }
    } 

    ## Purchase Vendor : Date : 30-08-2022
    public function purchaseVendor(){  

        $data = array(); 
        if($this->input->post('stripeToken')){             
            $postData = $this->input->post(); 
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            $postData['product'] = $product;
            // Make payment 
            $paymentID = $this->payment($postData); 
            // If payment successful 
            redirect($this->base_url.'wedding-vendor/payment_status/Stripe');
            exit;
        }         
        $insert_id = $this->session->userdata('wedding_planner');
        $get_user_data='';
        if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
        {
            $where_arra=array('id'=>$insert_id);
            $get_user_data = $this->common_model->get_count_data_manual('wedding_planner',$where_arra,1,'id,planner_name,mobile,address,email');
        }
        $plan_data = $this->session->userdata('plan_data_session');
        $stripe = $this->common_model->get_count_data_manual('payment_method'," name = 'Stripe' ",1,'*','','','',"");
        if(isset($stripe) && $stripe!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){
            $this->data['get_user_data']=$get_user_data;
            $this->data['stripe']=$stripe;
            $this->data['plan_data']=$plan_data;
            // Pass product data to the details view 
            $this->load->view('front_end/stripe_checkout_vendor', $this->data); 

        }else{
            redirect($this->base_url.'vendor-dashboard');
            exit;
        }
    }

    ## Purchase Advertise : Date : 30-08-2022
    public function purchaseAdvertise(){  
        $data = array(); 
        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){ 
            
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post();
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            $postData['product'] = $product;
            // Make payment 
            $paymentID = $this->payment($postData); 
            // If payment successful 
            redirect($this->base_url.'advertisement_plan/payment_status/Stripe');
            exit;
        } 
        $insert_id = $this->session->userdata('recent_advertise_id');
        $get_user_data='';
        if(isset($insert_id) && $insert_id != '' && $insert_id > 0)
        {
            $where_arra=array('id'=>$insert_id);
            $get_user_data = $this->common_model->get_count_data_manual('advertisement_master',$where_arra,1,'id,addname,phone,contact_person,link');
        }
        $plan_data = $this->session->userdata('plan_data_session');
        $stripe = $this->common_model->get_count_data_manual('payment_method'," name = 'Stripe' ",1,'*','','','',"");
        if(isset($stripe) && $stripe!='' && isset($plan_data) && $plan_data!= '' && isset($get_user_data) && $get_user_data!= '' ){
            $this->data['get_user_data']=$get_user_data;
            $this->data['stripe']=$stripe;
            $this->data['plan_data']=$plan_data;
            // Pass product data to the details view 
            $this->load->view('front_end/stripe_checkout_advertise', $this->data); 

        }else{
            redirect($this->base_url.'add-with-us');
            exit;
        }
    } 

    public function purchaseApp(){   
        $data = array(); 
         
        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){  
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post(); 
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            
            $postData['product'] = $product;  
            // Make payment 
            $paymentID = $this->payment($postData); 
             
            // If payment successful 
                
                $user_id= $postData['user_id'];
                $plan_id	= $postData['plan_id'];
                
                redirect($this->base_url.'premium-member/payment-success-stripe-mobile-app/'.$user_id.'/'.$plan_id);
            // redirect($this->base_url.'premium-member/payment_status/Stripe');
            // exit;

            // if($paymentID){ 
            //     redirect('products/payment_status/'.$paymentID); 
            // }else{ 
            //     $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
            //     $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            // } 
        } 
    } 

    ## Advertise App Plan : 
    public function purchaseAppAdvertise(){   
        $data = array(); 
         
        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){  
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post();
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            
            $postData['product'] = $product;  
            // Make payment 
            $paymentID = $this->payment($postData); 
             
            // If payment successful 
                
                $user_id= $postData['user_id'];
                $plan_id	= $postData['plan_id'];
                
                redirect($this->base_url.'advertisement-plan/payment-success-stripe-mobile-app/'.$user_id.'/'.$plan_id);
            // redirect($this->base_url.'premium-member/payment_status/Stripe');
            // exit;

            // if($paymentID){ 
            //     redirect('products/payment_status/'.$paymentID); 
            // }else{ 
            //     $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
            //     $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            // } 
        } 
    } 

    ## Vendor App Plan : 
    public function purchaseAppVendor(){   
        $data = array(); 
        // If payment form is submitted with token 
        if($this->input->post('stripeToken')){  
            // Retrieve stripe token and user info from the posted form data 
            $postData = $this->input->post();
            $product = array(
                'name' => $postData['name'],
                'price' => $postData['price'],
                'currency' => $postData['currency']
            );
            
            $postData['product'] = $product;  
            // Make payment 
            $paymentID = $this->payment($postData); 
            // If payment successful 
            $user_id= $postData['user_id'];
            $plan_id	= $postData['plan_id'];
            redirect($this->base_url.'wedding-vendor/payment-success-stripe-mobile-app/'.$user_id.'/'.$plan_id);
        } 
    } 
     
    function payment($postData){ 
         
        // If post data is not empty 
        if(!empty($postData)){ 
            
            
            // Retrieve stripe token and user info from the submitted form data 
            $token  = $postData['stripeToken']; 
            // $name = $postData['name']; 
            $email = ''; 
            
            // Add customer to stripe 
            $customer = $this->stripe_lib->addCustomer($email, $token); 
            
            if($customer){ 
                // Charge a credit or a debit card 
                $charge = $this->stripe_lib->createCharge($customer->id, $postData['product']['name'], $postData['product']['price'],$postData['product']['currency']); 
                if($charge){ 
                    // Check whether the charge is successful 
                    if($charge['amount_refunded'] == 0 && empty($charge['failure_code']) && $charge['paid'] == 1 && $charge['captured'] == 1){ 
                        $this->session->set_userdata('stripe_response','stripe_success');
                    } else{
                        $this->session->set_userdata('stripe_response','stripe_fail');
                    }
                } else{
                    $this->session->set_userdata('stripe_response',$charge);
                }
            } 
        } 
        return false; 
    } 
     
    function payment_status($id){ 
        $data = array(); 
         
        // Get order data from the database 
        $order = $this->product->getOrder($id); 
         
        // Pass order data to the view 
        $data['order'] = $order; 
        $this->load->view('products/payment-status', $data); 
    } 
}