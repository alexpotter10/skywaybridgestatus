<?php

require 'config.php';

// Query DB for desired locations
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT id, city, state FROM weather_locations"); 
    $stmt->execute();

    $weather_locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Loop through desired query locations
foreach ($weather_locations as $weather_location) {
    $weather_locations_id = $weather_location["id"];
    $city = $weather_location["city"];
    $state = $weather_location["state"];

    // Set the scrape request datetime
    $date = new DateTime('now');
    $request_datetime = $date->format('Y-m-d H:i:s');

    $json_string = file_get_contents("http://api.wunderground.com/api/" . $wukey . "/geolookup/conditions/q/" . $state . "/" . $city . ".json");
    $parsed_json = json_decode($json_string);

    $city = $parsed_json->{'location'}->{'city'};
    $station_id = $parsed_json->{'current_observation'}->{'station_id'};
    $observation_time = $parsed_json->{'current_observation'}->{'observation_time'};
    $observation_epoch = $parsed_json->{'current_observation'}->{'observation_epoch'};
    $local_epoch = $parsed_json->{'current_observation'}->{'local_epoch'};
    $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
    $temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
    $relative_humidity = $parsed_json->{'current_observation'}->{'relative_humidity'};
    $wind_dir = $parsed_json->{'current_observation'}->{'wind_dir'};
    $wind_degrees = $parsed_json->{'current_observation'}->{'wind_degrees'};
    $wind_mph = $parsed_json->{'current_observation'}->{'wind_mph'};
    $wind_gust_mph = $parsed_json->{'current_observation'}->{'wind_gust_mph'};
    $wind_kph = $parsed_json->{'current_observation'}->{'wind_kph'};
    $wind_gust_kph = $parsed_json->{'current_observation'}->{'wind_gust_kph'};
    $pressure_mb = $parsed_json->{'current_observation'}->{'pressure_mb'};
    $pressure_in = $parsed_json->{'current_observation'}->{'pressure_in'};
    $pressure_trend = $parsed_json->{'current_observation'}->{'pressure_trend'};
    $visibility_mi = $parsed_json->{'current_observation'}->{'visibility_mi'};
    $visibility_km = $parsed_json->{'current_observation'}->{'visibility_km'};
    $precip_1hr_in = $parsed_json->{'current_observation'}->{'precip_1hr_in'};
    $precip_1hr_metric = $parsed_json->{'current_observation'}->{'precip_1hr_metric'};
    $precip_today_in = $parsed_json->{'current_observation'}->{'precip_today_in'};
    $precip_today_metric = $parsed_json->{'current_observation'}->{'precip_today_metric'};
    $icon = $parsed_json->{'current_observation'}->{'icon'};

    // Write data to database
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL and bind parameters
        $stmt = $conn->prepare("INSERT INTO weather_log (request_datetime, weather_locations_id, city, station_id, observation_time, observation_epoch, local_epoch, temp_f, temp_c, relative_humidity, wind_dir, wind_degrees, wind_mph, wind_gust_mph, wind_kph, wind_gust_kph, pressure_mb, pressure_in, pressure_trend, visibility_mi, visibility_km, precip_1hr_in, precip_1hr_metric, precip_today_in, precip_today_metric, icon)
        VALUES (:request_datetime, :weather_locations_id, :city, :station_id, :observation_time, :observation_epoch, :local_epoch, :temp_f, :temp_c, :relative_humidity, :wind_dir, :wind_degrees, :wind_mph, :wind_gust_mph, :wind_kph, :wind_gust_kph, :pressure_mb, :pressure_in, :pressure_trend, :visibility_mi, :visibility_km, :precip_1hr_in, :precip_1hr_metric, :precip_today_in, :precip_today_metric, :icon)");

        $stmt->bindParam(':request_datetime', $request_datetime);
        $stmt->bindParam(':weather_locations_id', $weather_locations_id);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':station_id', $station_id);
        $stmt->bindParam(':observation_time', $observation_time);
        $stmt->bindParam(':observation_epoch', $observation_epoch);
        $stmt->bindParam(':local_epoch', $local_epoch);
        $stmt->bindParam(':temp_f', $temp_f);
        $stmt->bindParam(':temp_c', $temp_c);
        $stmt->bindParam(':relative_humidity', $relative_humidity);
        $stmt->bindParam(':wind_dir', $wind_dir);
        $stmt->bindParam(':wind_degrees', $wind_degrees);
        $stmt->bindParam(':wind_mph', $wind_mph);
        $stmt->bindParam(':wind_gust_mph', $wind_gust_mph);
        $stmt->bindParam(':wind_kph', $wind_kph);
        $stmt->bindParam(':wind_gust_kph', $wind_gust_kph);
        $stmt->bindParam(':pressure_mb', $pressure_mb);
        $stmt->bindParam(':pressure_in', $pressure_in);
        $stmt->bindParam(':pressure_trend', $pressure_trend);
        $stmt->bindParam(':visibility_mi', $visibility_mi);
        $stmt->bindParam(':visibility_km', $visibility_km);
        $stmt->bindParam(':precip_1hr_in', $precip_1hr_in);
        $stmt->bindParam(':precip_1hr_metric', $precip_1hr_metric);
        $stmt->bindParam(':precip_today_in', $precip_today_in);
        $stmt->bindParam(':precip_today_metric', $precip_today_metric);
        $stmt->bindParam(':icon', $icon);

        // Statement variables have been defined; execute!
        $stmt->execute();
        
        echo "New record created successfully\n";
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Close the connection
$conn = null;

?>