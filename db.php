<?php
    $servername = "labour-link.c4wgecowfejr.ap-northeast-1.rds.amazonaws.com";
    $username = "admin";
    $password = "LabourLink123*";
    $dbname = "labour_link";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>

