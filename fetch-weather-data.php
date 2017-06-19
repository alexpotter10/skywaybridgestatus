<?php

require 'config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT weather_locations_id, city, observation_time, temp_f, wind_dir, wind_mph, wind_gust_mph, pressure_in, pressure_trend, visibility_mi, precip_today_in, icon FROM weather_log ORDER BY request_datetime DESC LIMIT 2"); 
    $stmt->execute();

    // set the resulting array to associative
    $weather_logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($weather_logs);
    
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;


?>

