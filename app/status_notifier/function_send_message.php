<?php
require dirname(__DIR__, 2) . '/config.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Twilio\Rest\Client;

function sendTextMessage($e164_phone_number, $message_string) {
    // Your Account SID and Auth Token from twilio.com/console
    $account_sid = $twilio_key;
    // $auth_token = $twilio_live_auth_token;
    // In production, these should be environment variables. E.g.:
    // $auth_token = $_ENV["TWILIO_ACCOUNT_SID"]

    // A Twilio number you own with SMS capabilities
    $twilio_number = "+17273000620";

    $client = new Client($account_sid, $auth_token);
    $client->messages->create(
        // Where to send a text message (your cell phone?)
        $e164_phone_number,
        array(
            'from' => $twilio_number,
            'body' => $message_string
        )
    );
}

?>