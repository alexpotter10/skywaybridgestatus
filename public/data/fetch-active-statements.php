<?php

require 'config.php';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT * FROM active_statements"); 
    $stmt->execute();

    // set the resulting array to associative
    $active_statements = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

?>