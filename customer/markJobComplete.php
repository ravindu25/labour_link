<?php
    require_once '../db.php';

    $postData = json_decode(file_get_contents('php://input'), true);

    $taskID = $postData['taskID'];
    $houseID = $postData['houseID'];

    $sql = "UPDATE Job SET Completion_Flag = 1 WHERE Job_Type_ID = $taskID AND House_ID = $houseID";
    $result = $conn->query($sql);

    if($result){
        $http_response_code = 201; // Resource created
    } else {
        $http_response_code = 500;
    }

    http_response_code($http_response_code);
?>