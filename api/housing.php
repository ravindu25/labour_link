<?php
    require_once('../db.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $postData = json_decode(file_get_contents('php://input'), true);

        $customerId = $postData['customerid'];
        $address = $postData['address'];
        $verified = $postData['verified'];
        $jobSelection = $postData['jobselection'];

        $sql_create_housing = "INSERT INTO House(Customer_ID, Address, Verified) VALUES($customerId, '$address', $verified)";

        $http_response_code = 0;

        if($conn->query($sql_create_housing)){
            $http_response_code = 201; // Resource created
        } else {
            $http_response_code = 500;
        }

        http_response_code($http_response_code);
    }
?>