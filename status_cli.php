<?php

// Get the html returned from the following url
$fl511 = file_get_contents('https://fl511.com/List/Alerts'); 

/*
Perform REGEX query on fl511 to check for closure or caution, and echo status

Both Directions Closed = 0
Northbound Closed = 1
Southboud Closed = 2
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

echo $fl511_status . "\n";

?>