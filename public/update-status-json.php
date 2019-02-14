<?php
require 'data/fetch-status-data.php';

$myObj->status = $global_status_string;
$myObj->modifier = $global_status_modifier;
$myObj->color = $global_status_css_color;

$fp = fopen('status.json', 'w');
fwrite($fp, json_encode($myObj));
fclose($fp);

?>
