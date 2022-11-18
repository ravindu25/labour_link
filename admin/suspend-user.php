<?php
session_start();
//if not logged in redirect to login page
 if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
      header("Location: admin-login.php"); 
 }
    require_once '../db.php';

    //use the ajax fetch call to get the user id and do the query and return status
    $user_id = $_POST['user_id'];
    $sql = "UPDATE User SET Activation_Flag = 0 WHERE User_ID = '$user_id'";
    $result = $conn->query($sql);
    if ($result) {
        echo "Success";
    } else {
        echo "Fail";
    }


?>