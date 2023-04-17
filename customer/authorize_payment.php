<?php

$merchant_id           = $_POST['merchant_id'];
$order_id              = $_POST['order_id'];
$payhere_amount        = $_POST['payhere_amount'];
$payhere_currency      = $_POST['payhere_currency'];
$status_code           = $_POST['status_code'];
$md5sig                = $_POST['md5sig'];
$status_message        = $_POST['status_message'];
$payment_id            = $_POST['payment_id'];
$mode                  = $_POST['method'];

$merchant_secret = "MzA1NjE2OTYwODEyOTI0MDk3ODkyOTUxODU2MjM1ODM1ODQ5MDE1"; // Replace with your Merchant Secret

$local_md5sig = strtoupper(
    md5(
        $merchant_id . 
        $order_id . 
        $payhere_amount . 
        $payhere_currency . 
        $status_code . 
        strtoupper(md5($merchant_secret)) 
    ) 
);
 // require_once '../db.php';
 $servername = "labourlink.cdkspo5cbfve.ap-southeast-1.rds.amazonaws.com";
 $username = "admin";
 $password = "LabourLink123*";
 $dbname = "labour_link";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
       
if ($local_md5sig === $md5sig){
    if($status_code == 2){
        $sql = "UPDATE Payments_Due SET Payment_Date=NOW(), PayHere_Payment_ID=$payment_id, Mode='$mode' WHERE Booking_ID=$order_id OR Job_ID=$order_id";
        $result = $conn -> query($sql);
    }

    $sql_to_log = "INSERT INTO Payments_Log (PayHere_Payment_ID, Booking_ID, Mode, Amount, Success_Flag, Status_Message) VALUES ($payment_id, $order_id, '$mode', $payhere_amount, $status_code, '$status_message')";
    $result = $conn -> query($sql_to_log);
}


?>