<?php
echo "<script>console.log('PHP: " . json_encode($_POST) . "');</script>";

$merchant_id           = $_POST['merchant_id'];
$order_id              = $_POST['order_id'];
$payhere_amount        = $_POST['payhere_amount'];
$payhere_currency      = $_POST['payhere_currency'];
$status_code           = $_POST['status_code'];
$md5sig                = $_POST['md5sig'];
$status_message        = $_POST['status_message'];
$authorization_token   = $_POST['authorization_token'];
$payment_id            = $_POST['payment_id'];
$mode                  = $_POST['method'];

$merchant_secret = 'MzA1NjE2OTYwODEyOTI0MDk3ODkyOTUxODU2MjM1ODM1ODQ5MDE1'; // Replace with your Merchant Secret

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
       
if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
    require_once '../db.php';
    $sql = "UPDATE Payments_Due SET Payment_Date=NOW(), PayHere_Payment_ID=$payment_id, Authoriztion_Token=$authorization_token, Mode=$mode WHERE Booking_ID=$order_id OR Job_ID=$order_id";
    $result = $conn -> query($sql);

}


?>