<?php
/** Reformat All Database Phone Numbers to E164 Format */

require dirname(__DIR__, 2) . '/config.php';
require dirname(__DIR__, 2) . '/vendor/autoload.php';

$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

// Query for all subscribers with a phone number
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, subscriber_id, data_phone FROM mailchimp_subscribers WHERE data_phone != '';");
    $stmt->execute();

    // Pull numbers into an array
    $unset_subscribers = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

$loop_count = 0;
$error_count = 0;
echo "Starting loop...\n";

foreach ($unset_subscribers as $subscriber) {
    $subscriber_id = $subscriber["subscriber_id"];
    $number_string = $subscriber["data_phone"];

    $loop_count++;

    try {
        $phone_proto = $phoneUtil->parse($number_string, "US");
        $data_e164_phone = $phoneUtil->format($phone_proto, \libphonenumber\PhoneNumberFormat::E164);

        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("UPDATE mailchimp_subscribers SET data_e164_phone = :data_e164_phone WHERE subscriber_id = :subscriber_id;");

        $stmt->bindParam(':data_e164_phone', $data_e164_phone);
        $stmt->bindParam(':subscriber_id', $subscriber_id);

        $stmt->execute();
        $conn = null; // Close the connection

    } catch (\libphonenumber\NumberParseException $e) {
        $error_count++;
        echo "Error " . $error_count . ": " . $e . "\n";

        // Send error to Sentry
        $sentryClient->captureException($e, array(
        'extra' => array(
            'php_version' => phpversion(),
            'subscriber_id' => $subscriber_id
        ),
    ));
    }

}

echo "Wrote " . $loop_count . " phone numbers to the database with " . $error_count . " error(s).\n"

?>