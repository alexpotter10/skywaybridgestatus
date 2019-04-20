<?php

require dirname(__DIR__, 3) . '/config.php';

// Set the scrape request datetime
$date = new DateTime('now');
$request_datetime = $date->format('Y-m-d H:i:s');

// Get contents of current status
$fl511 = file_get_contents('https://fl511.com/List/Alerts');

// Query current status and store as variable for comparison
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, fl511_status FROM status_log WHERE fl511_status IS NOT NULL ORDER BY datetime DESC LIMIT 1;");
    $stmt->execute();

    $skyway_status = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($skyway_status as $skyway_status) {
        $previous_not_null_status = $skyway_status["fl511_status"];
    }

    // Close the connection
    $conn = null;

}
catch(PDOException $e) {
    // Send error to Sentry
    $sentryClient->captureException($e, array(
        'extra' => array(
            'php_version' => phpversion()
        ),
    ));
}

/*
Perform REGEX query on fl511 to check for closure or caution, and store status in variable

Both Directions Closed = 0
Northbound Closed = 1
Southbound Closed = 2
Under Caution for Rain = 3
Under Caution for High Winds = 4
Under Caution for Fog = 5
Northbound Under Caution for Police Activity = 6
Southbound Under Caution for Police Activity = 7
Under Caution for Police Activity = 8
Under General Caution = 9
Open = 10

Unable to query source = NULL

*/

if (empty($fl511)) {
    $new_status = NULL; //unable to query source
} elseif (preg_match('/(?=.*?\bSunshine Skyway Bridge will be\b).*/', $fl511)) {
    $new_status = 10; //planned closure announcement - assume open
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed Northbound\b).*/', $fl511)) {
    $new_status = 1; //closed Northbound
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed Southbound\b).*/', $fl511)) {
    $new_status = 2; //closed Southbound
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed\b).*/', $fl511)) {
    $new_status = 0; //closed
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\brain\b).*/', $fl511)) {
    $new_status = 3; //caution for rain
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bwinds\b).*/', $fl511)) {
    $new_status = 4; //caution for high winds
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bfog\b).*/', $fl511)) {
    $new_status = 5; //caution for fog
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bpolice\b).*/', $fl511)) {
    $new_status = 8; //caution for police activity
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b).*/', $fl511)) {
    $new_status = 9; //general caution
} else {
    $new_status = 10; //open
}

// Write data to database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO status_log (datetime, fl511_status)
    VALUES (:datetime, :fl511_status)");

    $stmt->bindParam(':datetime', $request_datetime);
    $stmt->bindParam(':fl511_status', $new_status);

    // Statement variables have been defined; execute!
    $stmt->execute();

    // Close the connection
    $conn = null;
    
}
catch(PDOException $e) {
    // Send error to Sentry
    $sentryClient->captureException($e, array(
        'extra' => array(
            'php_version' => phpversion()
        ),
    ));
}

// Determine if notification is needed, if so send

// Overwrite previous status -- uncomment for testing
// $previous_not_null_status = 0;

include_once dirname(__DIR__, 2) . '/status_notifier/function_send_message.php';

if ($previous_not_null_status == 0 && $new_status == 10) {
    // Notify that the Skyway is open
    $message_string = "The Skyway Bridge is now open! Please drive safe! Reply HELP for help. Reply STOP to unsubscribe.";
    sendStatusUpdateAllSubscribers($message_string);
} elseif ($previous_not_null_status == 0 && $new_status != 10 && $new_status != 0) {
    // Notify that the Skyway is no longer closed, but showing an alternate status
    $message_string = "The Skyway Bridge is no longer closed, but is showing an different status. Please check skywaystatus.com for more info. Reply HELP for help. Reply STOP to unsubscribe.";
    sendStatusUpdateAllSubscribers($message_string);
} elseif ($previous_not_null_status != 0 && $new_status == 0) {
    // Notify that the Skyway is currently closed
    $message_string = "The Skyway Bridge is now closed. Please check skywaystatus.com for updates. Reply HELP for help. Reply STOP to unsubscribe.";
    sendStatusUpdateAllSubscribers($message_string);
}


?>