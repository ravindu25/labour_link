<?php
    require_once('../db.php');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $postData = json_decode(file_get_contents('php://input'), true);

        $customerId = $postData['customerid'];
        $address = $postData['address'];
        $paid = $postData['paid'];
        $jobSelection = $postData['jobselection'];

        $sql_create_housing = "INSERT INTO House(Customer_ID, Address, Paid) VALUES($customerId, '$address', $paid)";
        $result_create_housing = $conn->query($sql_create_housing);

        $sql_get_housing_id = "SELECT House_ID FROM House WHERE Customer_ID = $customerId AND Address = '$address'";
        $result_get_housing_id = $conn->query($sql_get_housing_id);
        $row = $result_get_housing_id->fetch_assoc();
        $housingId = $row['House_ID'];


        //Jobs are automatically created by Trigger. This is to update the selected set of jobs as completed.
        foreach ($jobSelection as $jobId) {
            $sql_update_jobs = "UPDATE Job SET Completion_Flag = 1 WHERE Job_Type_ID = $jobId AND House_ID = $housingId";
            $result_update_jobs = $conn->query($sql_update_jobs);

        }



        $http_response_code = 0;

        if($result_create_housing){
            $http_response_code = 201; // Resource created
        } else {
            $http_response_code = 500;
        }

        http_response_code($http_response_code);
    }
?>