<?php
        //Uses JSON with fetch to change password 

        require_once '../db.php';

        $postData = json_decode(file_get_contents('php://input'), true);

        $customerId = $postData['user_id'];
        $oldPassword = $postData['enteredCurrPassword'];
        $newPassword = $postData['newPassword'];

        $sql_get_curr_pwd = "SELECT * FROM User WHERE User_ID = '$customerId'";

        $test_sql = "INSERT INTO test (test) VALUES ('$oldPassword')";
        $test_result = mysqli_query($conn, $test_sql);

        $result = mysqli_query($conn, $sql_get_curr_pwd);
        $row = mysqli_fetch_assoc($result);
        $currPassword = $row['Pswd'];

        if($currPassword==$oldPassword){
                
                $sql_update_pwd = "UPDATE User SET Pswd = '$newPassword' WHERE User_ID = '$customerId'";
                $result = mysqli_query($conn, $sql_update_pwd);
                if($result){
                        echo json_encode(array("statusCode"=>200));
                }
                else{
                        echo json_encode(array("statusCode"=>201));
                }
        }else{
                echo json_encode(array("statusCode"=>202));
        }


?>