<?php

require 'config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, fl511_status, datetime FROM status_log ORDER BY datetime DESC LIMIT 1"); 
    $stmt->execute();

    // set the resulting array to associative
    $skyway_status = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($skyway_status as $skyway_status) {
        $fl511_status = $skyway_status["fl511_status"];
        $fetch_datetime = $skyway_status["datetime"];
    }
    
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

if ($fl511_status == 0) {
    $fl511_status_string = "closed";
    $fl511_status_modifier = "closed";
} elseif ($fl511_status == 3) {
    $fl511_status_string = "under caution for rain";
    $fl511_status_modifier = "caution";
} elseif ($fl511_status == 4) {
    $fl511_status_string = "under caution for high winds";
    $fl511_status_modifier = "caution";
} elseif ($fl511_status == 5) {
    $fl511_status_string = "under caution for fog";
    $fl511_status_modifier = "caution";
} elseif ($fl511_status == 8) {
    $fl511_status_string = "under caution for police activity";
    $fl511_status_modifier = "caution";
} elseif ($fl511_status == 9) {
    $fl511_status_string = "under caution";
    $fl511_status_modifier = "caution";
} elseif ($fl511_status == 10) {
    $fl511_status_string = "open";
    $fl511_status_modifier = "open";
} else {
    $fl511_status_string = "unable to fetch status";
    $fl511_status_modifier = "error";
}




?>

