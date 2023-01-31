<?php

    $merchant_id="1221879";
    $order_id=$_POST['order_id'];
    $amount=$_POST['amount'];
    $currency="LKR";
    $merchant_secret="MzA1NjE2OTYwODEyOTI0MDk3ODkyOTUxODU2MjM1ODM1ODQ5MDE1";
    $hash = strtoupper(
        md5(
            $merchant_id . 
            $order_id . 
            number_format($amount, 2, '.', '') . 
            $currency .  
            strtoupper(md5($merchant_secret)) 
        ) 
    );
    echo $hash;
?>