<?php
 
require('Services/Twilio.php');

$account_sid = ""; // Your Twilio account sid
$auth_token = ""; // Your Twilio auth token

$client = new Services_Twilio($account_sid, $auth_token);
$message = $client->account->messages->sendMessage(
  '', // From a Twilio number in your account
  '+19054524548', // Text any number
  "Hello bro sorry for the previous msg!"
);

print $message->sid;

?>