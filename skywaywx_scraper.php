<?php

require 'config.php';

// Set request datetime variable
$date = new DateTime('now');
$request_datetime = $date->format('Y-m-d H:i:s');

// Request data from skywaywx.com
$json_string = file_get_contents('http://skywaywx.com/upld/skyWXdata.txt');
$parsed_json = json_decode($json_string);

// Assign variables from parsed data
$wx_date = $parsed_json->{'wxDate'};
$wx_time = $parsed_json->{'wxTime'};
$wx_wind_speed = $parsed_json->{'wndSpd'};
$wx_wind_direction = $parsed_json->{'wndDir'};
$wx_wind_gust = $parsed_json->{'wndGst'};
$wx_air_temperature = $parsed_json->{'airTmp'};
$wx_relative_humidity = $parsed_json->{'relHum'};
$wx_pressure_mb = $parsed_json->{'barPsh'};
$wx_precip_1h = $parsed_json->{'ran1hr'};
$wx_precip_today = $parsed_json->{'ranDay'};

// Combine date and time from parsed data into Unix timestamp
$wx_datetime = date('Y-m-d H:i:s', strtotime("$wx_date $wx_time"));

// Write data to database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO skywaywx_log (wind_speed, wind_direction, wind_gust, air_temperature, relative_humidity, pressure_mb, precip_1h, precip_today, request_datetime, observation_datetime)
    VALUES (:wind_speed, :wind_direction, :wind_gust, :air_temperature, :relative_humidity, :pressure_mb, :precip_1h, :precip_today, :request_datetime, :observation_datetime)");

    $stmt->bindParam(':wind_speed', $wx_wind_speed);
    $stmt->bindParam(':wind_direction', $wx_wind_direction);
    $stmt->bindParam(':wind_gust', $wx_wind_gust);
    $stmt->bindParam(':air_temperature', $wx_air_temperature);
    $stmt->bindParam(':relative_humidity', $wx_relative_humidity);
    $stmt->bindParam(':pressure_mb', $wx_pressure_mb);
    $stmt->bindParam(':precip_1h', $wx_precip_1h);
    $stmt->bindParam(':precip_today', $wx_precip_today);
    $stmt->bindParam(':request_datetime', $request_datetime);
    $stmt->bindParam(':observation_datetime', $wx_datetime);

    // Statement variables have been defined; execute!
    $stmt->execute();
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

// Close the connection
$conn = null;

?>