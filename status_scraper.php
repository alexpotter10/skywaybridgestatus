<?php

require 'config.php';

// Set the scrape request datetime
$date = new DateTime('now');
$request_datetime = $date->format('Y-m-d H:i:s');

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

$fl511 = file_get_contents('https://fl511.com/List/Alerts');
if (empty($fl511)) {
    $fl511_status = NULL; //unable to query source
} elseif (preg_match('/(?=.*?\bSunshine Skyway Bridge will be\b).*/', $fl511)) {
    $fl511_status = 10; //planned closure announcement - assume open
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed Northbound\b).*/', $fl511)) {
    $fl511_status = 1; //closed Northbound
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed Southbound\b).*/', $fl511)) {
    $fl511_status = 2; //closed Southbound
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bclosed\b).*/', $fl511)) {
    $fl511_status = 0; //closed
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\brain\b).*/', $fl511)) {
    $fl511_status = 3; //caution for rain
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bwinds\b).*/', $fl511)) {
    $fl511_status = 4; //caution for high winds
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bfog\b).*/', $fl511)) {
    $fl511_status = 5; //caution for fog
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b)(?=.*?\bpolice\b).*/', $fl511)) {
    $fl511_status = 8; //caution for police activity
} elseif (preg_match('/(?=.*?\bSunshine\b)(?=.*?\bSkyway\b)(?=.*?\bcaution\b).*/', $fl511)) {
    $fl511_status = 9; //general caution
} else {
    $fl511_status = 10; //open
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
    $stmt->bindParam(':fl511_status', $fl511_status);

    // Statement variables have been defined; execute!
    $stmt->execute();
    
}
catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}

// Close the connection
$conn = null;

?>