<?php

/** Mailchimp Webhook Endpoint
 * 
 * The purpose of this file is to process inbound data from the Mailchimp webhook and process the information accordingly.
 * 
 * This utilizes the mailchimp-api package: https://github.com/drewm/mailchimp-api
 * 
 */

require($_SERVER['DOCUMENT_ROOT'] . "/config.php");
require(ROOT . "vendor/autoload.php");

use \DrewM\MailChimp\Webhook;

// Check for security key
if($_GET["access_key"] !== $mailchimp_access_key) {
    echo "<h1>Access denied</h1>";
    echo "<p>Contact the adminstrator for more info.</p>";
} else {
    echo "You have access!";

    // Receive Mailchimp webhook event
    $event = Webhook::receive();

    // Ensure event is for the SBS list
    $list_id = $event->{"data"}->{"list_id"};
    if ($list_id = "b3f668b8e6") {

        // Log webhook event to database
        try {
            // Set metadata variables
            $event_data = json_encode($event); //
            $event_time = time();
            $event_status = "new";
            $agent = $_SERVER['HTTP_USER_AGENT'];

            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL and bind parameters
            $stmt = $conn->prepare(
            "INSERT INTO mailchimp_webhook_log (event_data, event_time, event_status, agent)
            VALUES (:event_data, :event_time, :event_status, :agent);");

            $stmt->bindParam(':event_data', $event_data);
            $stmt->bindParam(':event_time', $event_time);
            $stmt->bindParam(':event_status', $event_status);
            $stmt->bindParam(':agent', $agent);

            // Statement has been defined; execute!
            $stmt->execute();

            // Close the connection
            $conn = null;

        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();

            // Send error to Sentry
            $sentryClient->captureException($e, array(
                'extra' => array(
                    'php_version' => phpversion()
                ),
            ));
        }
    }
}

?>