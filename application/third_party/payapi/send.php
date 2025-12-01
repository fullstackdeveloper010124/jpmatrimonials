<?php
require_once('vendor/autoload.php');

error_reporting(E_ALL);
ini_set('display_errors', '1');

// $client = new \GuzzleHttp\Client();

// $response = $client->request('POST', 'https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay', [
//   'headers' => [
//     'Content-Type' => 'application/json',
//     'accept' => 'application/json',
//   ],
//   'headers' => [
//     'Content-Type' => 'application/json',
//     'accept' => 'application/json',
//   ],
// ]);

// echo $response->getBody();




?>
With CURL

<?php

if (isset($_POST['submit_form'])) {

  $amount = $_POST['amountEnterByUsers'];
/*
  $merchantKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
  $data = array(
      "merchantId" => "M1G2RC2NRBBO",
      "merchantTransactionId" => "MT785058104",
      "merchantUserId" => "MUID123",
      "amount" => $amount*100,
      "redirectUrl" => "paymentsuccess.php",
      "redirectMode" => "POST",
      "callbackUrl" => "paymentsuccess.php",
      "mobileNumber" => "8200459360",
      "paymentInstrument" => array(
          "type" => "PAY_PAGE"
      )
  );
  // Convert the Payload to JSON and encode as Base64
  $payloadMain = base64_encode(json_encode($data));

  $payload = $payloadMain."/pg/v1/pay".$merchantKey;
  $Checksum = hash('sha256', $payload);
  $Checksum = $Checksum.'6ee02a27-8410-41f6-a7b2-117f1f5eb17f'; */

//X-VERIFY  -	SHA256(base64 encoded payload + "/pg/v1/pay" + salt key) + ### + salt index


  $data = array(
      "merchantId" => "",
      "merchantTransactionId" => "",
      "merchantUserId" => "",
      "amount" => $amount*100,
      "redirectUrl" => "paymentsuccess.php",
      "redirectMode" => "POST",
      "callbackUrl" => "paymentsuccess.php",
      "mobileNumber" => "8200459360",
      "paymentInstrument" => array(
          "type" => "PAY_PAGE"
      )
  );

        $encode = base64_encode(json_encode($data));

        $saltKey = ''; //6ee02a27-8410-41f6-a7b2-
        $saltIndex = 1;

        $string = $encode.'/pg/v1/pay'.$saltKey;
        $sha256 = hash('sha256',$string);

        $finalXHeader = $sha256.'###'.$saltIndex;

  $curl = curl_init();
  curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
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
print_r( $response);
  curl_close($curl);

  if ($err) {
      //   echo "cURL Error #:" . $err;
      header('Location: paymentfailed.php?cURLError='.$err);
  } else {
      $responseData = json_decode($response, true);
      $url = $responseData['data']['instrumentResponse']['redirectInfo']['url'];
    //   echo $url;exit;
      header('Location: '.$url);
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Integration</title>
</head>
<body>
  <br>
  <center><h1>Phone Pay Integration </h1>
  <br>
  <hr>
  <form action="#" method="post">
    <label for="amountEnterByUsers">Enter Amount</label>
    <input type="number" name="amountEnterByUsers" id="amountEnterByUsers">
    <br><hr>
    <button type="submit" name="submit_form">Pay Now</button>
  </form>
</center>

</body>
</html>