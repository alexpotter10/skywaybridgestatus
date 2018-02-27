<?php

require 'config.php';

try {
    // Set current date for SQL query
    $date = new DateTime('now');

    // Prepare SQL query
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM planned_closures pc WHERE pc.start_datetime > CURDATE() ORDER BY pc.start_datetime DESC LIMIT 1;"); 
    
    $stmt->execute();

    // set the resulting array to associative
    $planned_closure = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
}

catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

?>