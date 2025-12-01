<?php

    require_once APPPATH.'third_party/payapi/vendor/autoload.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

?>
<?php
            ## Phonepe Payemnt Getway start 05/09/2023
        
            $trId = 'NV'.$get_user_data['id'].'_'.time();
            $merchant_id = $phonepe['email_merchant_id'];
            $merchantTransactionId = $trId;
            $amount = $plan_data['total_pay'];
            $merchantUserId = $get_user_data['matri_id'];
            $mobile = $get_user_data['mobile'];
	

        $p_plan = $plan_data['plan_id'];
        if(isset($user_agent) && $user_agent == 'NI-AAP'){
            $matri_id='';
            if(isset($user_id) && $user_id != ''){
              $matri_id = $user_id;
            }
             $redirect = $base_url.'premium-member/payment-success-phonepe-app/'.$matri_id.'/'.$p_plan;
          }else{
            $redirect = $base_url.'premium-member/payment-status/PhonePe';
          }

       $data = array(
          "merchantId" => $merchant_id,
          "merchantTransactionId" => $merchantTransactionId,
          "merchantUserId" => $merchantUserId,
          "amount" => $amount*100,
          "redirectUrl" => $redirect,
          "redirectMode" => "POST",
          "callbackUrl" => $redirect,
          "mobileNumber" =>  $mobile,
          "paymentInstrument" => array(
              "type" => "PAY_PAGE"
          )
      );

        $encode = base64_encode(json_encode($data));
        $saltKey = $phonepe['key']; 
        $saltIndex = 1;
        $string = $encode.'/pg/v1/pay'.$saltKey;
        $sha256 = hash('sha256',$string);
        $finalXHeader = $sha256.'###'.$saltIndex;
        $live_url = "https://api.phonepe.com/apis/hermes/pg/v1/pay";
        
        $curl = curl_init();
        curl_setopt_array($curl, [
          CURLOPT_URL => $live_url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => json_encode([
            'request' => $encode
          ]),
          CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-VERIFY: ".$finalXHeader,
            "accept: application/json"
          ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            header('Location: paymentfailed.php?cURLError='.$err);
        } else {
            $responseData = json_decode($response, true);
            $url = $responseData['data']['instrumentResponse']['redirectInfo']['url'];
            header('Location: '.$url);
        }

?>
