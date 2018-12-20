<?php

require 'config.php';

// Set request datetime variable
$date = new DateTime('now');
$request_datetime = $date->format('Y-m-d H:i:s');

// Request data from FHP
$json_string = file_get_contents('https://gis.flhsmv.gov/arcgisfhptrafficsite/rest/services/Traffic_Feed/MapServer/0/query?where=DISPATCHCENTER+%3C%3E+%27%27&text=&objectIds=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&outFields=*&returnGeometry=true&returnTrueCurves=false&maxAllowableOffset=&geometryPrecision=&outSR=&returnIdsOnly=false&returnCountOnly=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&returnZ=true&returnM=true&gdbVersion=&returnDistinctValues=false&resultOffset=&resultRecordCount=&f=pjson');

// Parse JSON
$parsed_json = json_decode($json_string);

// Loop through objects to find items with "SKYWAY" in the location key
foreach ($parsed_json->{'features'} as $key ) {
    $location = $key->{'attributes'}->{'LOCATION'};
    if (preg_match('/(?=.*?\bSKYWAY\b).*/', $location)) {
        $incident_id = $key->{'attributes'}->{'INCIDENTID'};
        $object_id = $key->{'attributes'}->{'OBJECTID'};
        $dispatch_center = $key->{'attributes'}->{'DISPATCHCENTER'};
        // incident_id variable already set
        $incident_date = $key->{'attributes'}->{'DATE'};
        $incident_time = $key->{'attributes'}->{'TIME'};
        $urgency = $key->{'attributes'}->{'URGENCY'};
        $lat = $key->{'attributes'}->{'LAT'};
        $lon = $key->{'attributes'}->{'LON'};
        $event_type = $key->{'attributes'}->{'TYPEEVENT'};
        $county = $key->{'attributes'}->{'COUNTY'};
        // location variable already set
        $remarks = $key->{'attributes'}->{'REMARKS'};
        $dispatch_time = $key->{'attributes'}->{'DISPATCHTIME'};
        $arrival_time = $key->{'attributes'}->{'ARRIVETIME'};
        $geometry_x = $key->{'geometry'}->{'x'};
        $geometry_y = $key->{'geometry'}->{'y'};

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL and bind parameters
            $stmt = $conn->prepare("INSERT INTO flhsmv_log (incident_id, object_id, dispatch_center, incident_date, incident_time, urgency, lat, lon, event_type, county, location, remarks, dispatch_time, arrival_time, geometry_x, geometry_y, request_datetime)
            VALUES (:incident_id, :object_id, :dispatch_center, :incident_date, :incident_time, :urgency, :lat, :lon, :event_type, :location, :county, :remarks, :dispatch_time, :arrival_time, :geometry_x, :geometry_y, :request_datetime)");

            $stmt->bindParam(':incident_id', $incident_id);
            $stmt->bindParam(':object_id', $object_id);
            $stmt->bindParam(':dispatch_center', $dispatch_center);
            $stmt->bindParam(':incident_date', $incident_date);
            $stmt->bindParam(':incident_time', $incident_time);
            $stmt->bindParam(':urgency', $urgency);
            $stmt->bindParam(':lat', $lat);
            $stmt->bindParam(':lon', $lon);
            $stmt->bindParam(':event_type', $event_type);
            $stmt->bindParam(':county', $county);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->bindParam(':dispatch_time', $dispatch_time);
            $stmt->bindParam(':arrival_time', $arrival_time);
            $stmt->bindParam(':geometry_x', $geometry_x);
            $stmt->bindParam(':geometry_y', $geometry_y);
            $stmt->bindParam(':request_datetime', $request_datetime);

            // Statement variables have been defined; execute!
            $stmt->execute();

        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        // Close the connection
        $conn = null;

    }
};


?>


