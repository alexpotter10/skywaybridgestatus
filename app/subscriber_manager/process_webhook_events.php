<?php
/** Process tgo Injest Mailchimp Webhook Objects and Update `mailchimp_subscribers` Table
 * 
 * 
 */

require dirname(__DIR__, 2) . '/config.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

use Twilio\Rest\Client;

// Query new webhook objects
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, event_data FROM mailchimp_webhook_log WHERE event_status = 'new';");
    $stmt->execute();

    // Pull numbers into an array
    $webhook_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Close the connection
    $conn = null;

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();

    // Send error to Sentry
    $sentryClient->captureException($e, array(
        'extra' => array(
            'php_version' => phpversion()
        ),
    ));
}

// Convert each object to array, loop and process
foreach ($webhook_events as $webhook_event) {
    $event_id = $webhook_event["id"];
    $event_object = $webhook_event["event_data"];
    $event_array = json_decode($event_object);

    // Determine type of event and trigger appropriate actions
    $event_type = $event_array->{"type"};
    switch ($event_type) {
        case "subscribe":
            addMailchimpSubscriber($event_array, 'welcome');
            break;
        case "unsubscribe":
            removeMailchimpSubscriber($event_array);
            break;
        case "profile":
            addMailchimpSubscriber($event_array, 'profile_updated');
            break;
        case "upemail":
            try {
                // Set data variables
                $subscriber_data_email = $event_array->{"data"}->{"old_email"}; //"api@mailchimp.com"
                
                // Connect to MySQL and remove subscriber
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
                $stmt = $conn->prepare(
                    "DELETE FROM mailchimp_subscribers WHERE data_email = :data_email"
                );
        
                $stmt->bindParam(':data_email', $subscriber_data_email);
        
                // Execute delete statement
                $stmt->execute();
        
                $stmt = $conn->prepare(
                    "UPDATE mailchimp_webhook_log SET event_status = 'processed' WHERE id = :event_id;"
                );
        
                $stmt->bindParam(':event_id', $event_id);
        
                // Execute update statement
                $stmt->execute();
        
                // Close the connection
                $conn = null;
        
            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
        
                // Send error to Sentry
                $sentryClient->captureException($e, array(
                    'extra' => array(
                        'php_version' => phpversion()
                    ),
                ));
            }
            break;
            
        // The "cleaned" cases have been left off, as it is uncertain if the "cleaned" case is necessary.
    }
}


function addMailchimpSubscriber($event_array, $sms_type) {
    require dirname(__DIR__, 2) . '/config.php';
    require dirname(__DIR__, 2) . '/vendor/autoload.php';
    
    try {
        // Set data variables from Mailchimp webhook event
        $mailchimp_datetime = $event_array->{"fired_at"}; //"2009-03-26 21:35:57"
        $subscriber_id = $event_array->{"data"}->{"id"}; //"8a25ff1d98"
        $subscriber_email = $event_array->{"data"}->{"email"}; //"api@mailchimp.com"
        $subscriber_data_email = $event_array->{"data"}->{"merges"}->{"EMAIL"}; //"api@mailchimp.com"
        $subscriber_data_fname = $event_array->{"data"}->{"merges"}->{"FNAME"}; //"Mailchimp"
        $subscriber_data_lname = $event_array->{"data"}->{"merges"}->{"LNAME"}; //"API"
        $subscriber_data_phone = $event_array->{"data"}->{"merges"}->{"PHONE"}; // "6308773142"
        $subscriber_data_zip = $event_array->{"data"}->{"merges"}->{"MMERGE3"}; // 34219-0000
        $subscriber_data_preference = $event_array->{"data"}->{"merges"}->{"MMERGE5"}; 

        // Generate E164 formatted number, if phone number is available
        if (!is_null($subscriber_data_phone)) {
            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            try {
                $phone_proto = $phoneUtil->parse($subscriber_data_phone, "US");
            } catch (\libphonenumber\NumberParseException $e) {
                echo $e;
                // TODO: ADD SENTRY HERE
            }
            $subscriber_e164_phone = $phoneUtil->format($phone_proto, \libphonenumber\PhoneNumberFormat::E164);
        } else {
            $subscriber_e164_phone = NULL;
        }
        
        // Connect to MySQL and add subscriber
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "INSERT INTO mailchimp_subscribers (subscriber_id, subscriber_email, data_email, data_fname, data_lname, data_phone, data_e164_phone, data_zip, data_preference, created)
            VALUES (:subscriber_id, :subscriber_email, :data_email, :data_fname, :data_lname, :data_phone, :data_e164_phone, :data_zip, :data_preference, :created);"
        );

        $stmt->bindParam(':subscriber_id', $subscriber_id);
        $stmt->bindParam(':subscriber_email', $subscriber_email);
        $stmt->bindParam(':data_email', $subscriber_data_email);
        $stmt->bindParam(':data_fname', $subscriber_data_fname);
        $stmt->bindParam(':data_lname', $subscriber_data_lname);
        $stmt->bindParam(':data_phone', $subscriber_data_phone);
        $stmt->bindParam(':data_e164_phone', $subscriber_e164_phone);
        $stmt->bindParam(':data_zip', $subscriber_data_zip);
        $stmt->bindParam(':data_preference', $subscriber_data_preference);
        $stmt->bindParam(':created', $mailchimp_datetime);

        $stmt->execute(); // Execute insert statement

        $stmt = $conn->prepare(
            "UPDATE mailchimp_webhook_log SET event_status = 'processed' WHERE id = :event_id;"
        );

        $stmt->bindParam(':event_id', $event_id);

        $stmt->execute(); // Execute update statement

        $conn = null; // Close the connection

        // If phone number is available and function argument is set, send SMS message
        if (isset($subscriber_e164_phone) && !is_null($subscriber_e164_phone) && isset($sms_type)) {
            
            // Check for function argument type
            switch ($sms_type) {
                case 'welcome':
                    $message_string = 'Welcome ' . $subscriber_data_fname . '! You have successfully subscribed to Skyway Bridge Status text alerts. Reply HELP for help. Reply STOP to unsubscribe. Msg&Data Rates May Apply.';
                    break;
                case 'profile_updated':
                    $message_string = 'Your Skyway Bridge Status profile has been successfully updated to include this phone number. Reply HELP for help. Reply STOP to unsubscribe. Msg&Data Rates May Apply.';
                    break;
            }
            
            // Account SID and Auth Token from twilio.com/console
            $account_sid = $twilio_account_id;
            $auth_token = $twilio_live_auth_token;

            // Define Twilio number
            $twilio_number = "+17273000620";

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
                $subscriber_e164_phone,
                array(
                    'from' => $twilio_number,
                    'body' => $message_string
                )
            );
        }

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion()
            ),
        ));
    }
}

function removeMailchipSubscriber($event_array, $sms_type) {
    require dirname(__DIR__, 2) . '/config.php';
    require dirname(__DIR__, 2) . '/vendor/autoload.php';
    
    try {
        // Set data variables
        $subscriber_id = $event_array->{"data"}->{"id"}; //"8a25ff1d98"
        
        // Connect to MySQL and remove subscriber
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "DELETE FROM mailchimp_subscribers WHERE subscriber_id = :subscriber_id"
        );

        $stmt->bindParam(':subscriber_id', $subscriber_id);

        // Execute delete statement
        $stmt->execute();

        $stmt = $conn->prepare(
            "UPDATE mailchimp_webhook_log SET event_status = 'processed' WHERE id = :event_id;"
        );

        $stmt->bindParam(':event_id', $event_id);

        // Execute update statement
        $stmt->execute();

        // Close the connection
        $conn = null;

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion()
            ),
        ));
    }
}

?>