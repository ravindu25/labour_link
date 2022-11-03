<!-- Database Connection -->

<?php
$servername = "localhost";
$username = "root";
$password = "ruw2000925";
$dbname = "labour_link";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

