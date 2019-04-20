<?php
/** Process to Injest Mailchimp Webhook Objects and Update `mailchimp_subscribers` Table
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
            addMailchimpSubscriber($event_array);
            updateEventStatus($event_id, 'processed');
            break;
        case "unsubscribe":
            removeMailchimpSubscriberById($event_array);
            updateEventStatus($event_id, 'processed');
            break;
        case "profile":
            evaluateForMatchingDataId($event_array);
            updateEventStatus($event_id, 'processed');
            break;
        case "upemail":
            removeMailchimpSubscriberByEmail($event_array);
            updateEventStatus($event_id, 'processed');
            break;
            
        // The "cleaned" cases have been left off, as it is uncertain if the "cleaned" case is necessary.
    }
}


function addMailchimpSubscriber($event_array) {
    require dirname(__DIR__, 2) . '/config.php';
    
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
        if (!is_null($subscriber_data_phone) && isset($subscriber_data_phone)) {
            
            try {
                $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                $phone_proto = $phoneUtil->parse($subscriber_data_phone, "US");
                if (!is_null($phone_proto)) {
                    $subscriber_e164_phone = $phoneUtil->format($phone_proto, \libphonenumber\PhoneNumberFormat::E164);
                } else {
                    $subscriber_e164_phone = NULL;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                // Send error to Sentry
                $sentryClient->captureException($e, array(
                    'extra' => array(
                        'php_version' => phpversion(),
                        'subscriber_id' => $subscriber_id,
                        'subscriber_data_phone' => $subscriber_data_phone,
                        'subscriber_e164_phone' => $subscriber_e164_phone
                    ),
                ));
            }    
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

        $inserted = $stmt->execute(); // Execute insert statement

        // If insert completed successfully, send welcome text
        if ($inserted) {
            sendWelcomeTextMessage($subscriber_e164_phone, $subscriber_data_fname, 'welcome');
        }

        $conn = null; // Close the connection

        

    } catch(PDOException $e) {
        if ($e->getCode() == 1062) {
            updateEventStatus($event_id, 'skipped_duplicate_event_id');
        }

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'event_data' => $event_array
            ),
        ));
    }

}

function removeMailchimpSubscriberById($event_array) {
    require dirname(__DIR__, 2) . '/config.php';
    
    try {
        // Set data variables
        $subscriber_id = $event_array->{"data"}->{"id"}; //"8a25ff1d98"
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "DELETE FROM mailchimp_subscribers WHERE subscriber_id = :subscriber_id;"
        );
        $stmt->bindParam(':subscriber_id', $subscriber_id);
        $stmt->execute();
        $conn = null; // Close the connection

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'event_data' => $event_array
            ),
        ));
    }
}

function removeMailchimpSubscriberByEmail($event_array) {
    require dirname(__DIR__, 2) . '/config.php';
    
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
        $stmt->execute();
        $conn = null; // Close the connection

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'event_data' => $event_array
            ),
        ));
    }
}

function updateMailchimpSubscriber($event_array) {
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
            
            try {
                $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
                $phone_proto = $phoneUtil->parse($subscriber_data_phone, "US");
                if (!is_null($phone_proto)) {
                    $subscriber_e164_phone = $phoneUtil->format($phone_proto, \libphonenumber\PhoneNumberFormat::E164);
                } else {
                    $subscriber_e164_phone = NULL;
                }
            } catch (\libphonenumber\NumberParseException $e) {
                echo $e;
                
                // Send error to Sentry
                $sentryClient->captureException($e, array(
                    'extra' => array(
                        'php_version' => phpversion(),
                        'subscriber_id' => $subscriber_id
                    ),
                ));
            }    
        } else {
            $subscriber_e164_phone = NULL;
        }
        
        // Connect to MySQL and update subscriber record
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "UPDATE mailchimp_subscribers SET subscriber_email = :subscriber_email, data_email = :data_email, data_fname = :data_fname, data_lname = :data_lname, data_phone = :data_phone, data_e164_phone = :data_e164_phone, data_zip = :data_zip, data_preference = :data_preference, modified = :modified WHERE subscriber_id = :subscriber_id;"
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
        $stmt->bindParam(':modified', $mailchimp_datetime);

        $stmt->execute(); // Execute insert statement

        $conn = null; // Close the connection

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'event_data' => $event_array
            ),
        ));
    }
}

function evaluateForMatchingDataId($event_array) {
    require dirname(__DIR__, 2) . '/config.php';

    try {
        // Query for matching data_id
        $subscriber_id = $event_array->{"data"}->{"id"}; //"8a25ff1d98"
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "SELECT COUNT(*) FROM mailchimp_subscribers WHERE subscriber_id = :subscriber_id;"
        );

        $stmt->bindParam(':subscriber_id', $subscriber_id);
        $stmt->execute(); // Execute select statement
        $matching_record_count = $stmt->fetchAll(PDO::FETCH_COLUMN); // return one dimensional array with count
        $conn = null; // Close the connection

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'event_data' => $event_array
            ),
        ));
    }

    // If data_id matches, update row
    if ($matching_record_count > 0) {
        updateMailchimpSubscriber($event_array);
    } elseif ($matching_record_count = 0) {
        addMailchimpSubscriber($event_array);
    }
    
}

function updateEventStatus($event_id, $status_string) {
    require dirname(__DIR__, 2) . '/config.php';
    
    try {
        // Connect to MySQL and remove subscriber
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set the PDO error mode to exception
        $stmt = $conn->prepare(
            "UPDATE mailchimp_webhook_log SET event_status = :status_string WHERE id = :event_id;"
        );
        $stmt->bindParam(':event_id', $event_id);
        $stmt->bindParam(':status_string', $status_string);
        $stmt->execute();
        $conn = null; // Close the connection

    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();

        // Send error to Sentry
        $sentryClient->captureException($e, array(
            'extra' => array(
                'php_version' => phpversion(),
                'mailchimp_webhook_log_id' => $event_id
            ),
        ));
    }
    

}

function sendWelcomeTextMessage($subscriber_e164_phone, $subscriber_data_fname, $sms_type) {
    require dirname(__DIR__, 2) . '/config.php';
    require dirname(__DIR__, 2) . '/vendor/autoload.php';

    // If phone number is available and function argument is set, send SMS message
    if (isset($subscriber_e164_phone) && !is_null($subscriber_e164_phone) && isset($sms_type)) {
        
        // Check for function argument type
        switch ($sms_type) {
            case 'welcome':
                $message_string = 'Welcome ' . $subscriber_data_fname . '! You are now subscribed to Skyway Bridge Status text alerts. This is a free service provided by IMN Services, LLC without guarantee or warranty. Reply HELP for help. Reply STOP to unsubscribe. Msg&Data Rates May Apply.';
                break;
            case 'profile_updated':
                $message_string = 'Your Skyway Bridge Status profile has been successfully updated to include this phone number. Reply HELP for help. Reply STOP to unsubscribe. Msg&Data Rates May Apply.';
                break;
        }
        
        // Set Twilio requried variables
        $account_sid = $twilio_account_id;
        $auth_token = $twilio_live_auth_token;
        $twilio_number = $twilio_sms_number;

        // DEFENSIVE CODE: Overwrite subscriber number in non-production environments
        if ($environment != "production") {
            $subscriber_e164_phone = $twilio_test_phone;
        }

        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $subscriber_e164_phone,
            array(
                'from' => $twilio_number,
                'body' => $message_string
            )
        );
    }
}

?>