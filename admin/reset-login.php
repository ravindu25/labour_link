<?php
    require_once '../db.php';

    //use the ajax fetch call to get the user id and do the query and return status
    $user_id = $_POST['user_id'];
    $sql = "UPDATE User SET Pswd = 'abc123' WHERE User_ID = '$user_id'";
    $result = $conn->query($sql);
    if ($result) {
        echo "Success";
    } else {
        echo "Fail";
    }


?>