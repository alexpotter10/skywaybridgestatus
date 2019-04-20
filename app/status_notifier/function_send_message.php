<?php
// require dirname(__DIR__, 2) . '/config.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Twilio\Rest\Client;

function sendStatusUpdateAllSubscribers($message_string) {
    
    echo $message_string;

    // Pull list of current SMS subscriber phone numbers
    require dirname(__DIR__, 2) . '/config.php';
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT DISTINCT data_e164_phone FROM mailchimp_subscribers WHERE data_preference != 'Email Only' AND data_e164_phone != '';"); 
    $stmt->execute();
    $subscribers = $stmt->fetchAll(PDO::FETCH_COLUMN); // return one dimensional array
    $conn = null;

    // Set Twilio requried variables
    $twilio_number = $twilio_sms_number;
    $account_sid = $twilio_account_id;
    $auth_token = $twilio_live_auth_token;
    
    // DEFENSIVE CODE: Overwrite subscribers array in non-production environments
    if ($environment != "production") {
        $subscribers = array($twilio_test_phone);
    }

    // Loop through subscriber numbers and send status update
    foreach ($subscribers as $subscriber) {
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $subscriber,
            array(
                'from' => $twilio_number,
                'body' => $message_string
            )
        );
        echo $subscriber;
    }

}

?>