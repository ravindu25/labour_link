<?php
    require_once '../db.php';

    $postData = json_decode(file_get_contents('php://input'), true);

    $userId = $postData['user_id'];
    $field = $postData['field'];
    if($field=='Name'){
        $firstName = $postData['newFirstName'];
        $lastName = $postData['newLastName'];
        $sql_update = "UPDATE User SET First_Name = '$firstName', Last_Name = '$lastName' WHERE User_ID = '$userId'";
    }else{
        $newValue = $postData['newValue'];
        $sql_update = "UPDATE User SET $field = '$newValue' WHERE User_ID = '$userId'";
    }
    
    $result = mysqli_query($conn, $sql_update);

    if($result){
        echo json_encode(array("statusCode"=>200));
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }


?>