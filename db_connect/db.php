<?php

    $host = 'localhost';
    $db = 'tc_inventory';  // Change to your database name
    $user = 'root';    // Database username
    $pass = '';        // Database password

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
?>