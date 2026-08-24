<?php
require_once 'config.php';

function sendSMS($to, $msg){

    // Add +91 if number not added
    if(substr($to,0,1) != '+'){
        $to = "+91".$to;
    }

    $url = "https://api.twilio.com/2010-04-01/Accounts/".TWILIO_SID."/Messages.json";

    $data = [
        "From" => TWILIO_FROM,
        "To" => $to,
        "Body" => $msg
    ];

    $post = http_build_query($data);

    $x = curl_init($url);
    curl_setopt($x, CURLOPT_POST, true);
    curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($x, CURLOPT_USERPWD, TWILIO_SID . ":" . TWILIO_TOKEN);
    curl_setopt($x, CURLOPT_POSTFIELDS, $post);

    $result = curl_exec($x);
    curl_close($x);

    return $result;
}
?>