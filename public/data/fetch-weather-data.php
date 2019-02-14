<?php

require 'config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("/*" . MYSQLND_QC_ENABLE_SWITCH . "*/" . "SELECT log.*, loc.name FROM weather_log log INNER JOIN weather_locations loc ON log.weather_locations_id = loc.id WHERE log.id = (SELECT t2.id FROM weather_log t2 WHERE t2.weather_locations_id = log.weather_locations_id ORDER BY t2.id DESC LIMIT 1)"); 
    
    $stmt->execute();

    // set the resulting array to associative
    $weather_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

?>