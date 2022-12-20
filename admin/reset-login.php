<?php
session_start();
//if not logged in redirect to login page
 if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
      header("Location: admin-login.php"); 
 }
    require_once '../db.php';

    //use the ajax fetch call to get the user id and do the query and return status
    $user_id = $_POST['user_id'];
    $sql = "UPDATE User SET Pswd = 'abc123' WHERE User_ID = '$user_id'";
    $result = $conn->query($sql);

    $sql_foremail = "SELECT * FROM User WHERE User_ID = '$user_id'";
    $result_foremail = $conn->query($sql_foremail);
    $row_foremail = $result_foremail->fetch_assoc();
    $email = $row_foremail['Email'];
    $name = $row_foremail['First_Name'];

    require_once '../mailconfiguration.php';
    
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Labour Link Password Reset';
    $mail->Body = "Dear $name, <br><br> Your password has been reset by the System Admin as per your request. <br> Your new password is 'abc123'. <br> Please change your password after logging in. <br><br> Thank you.";

    if ($result) {
        echo "Success";
        $mail->send();
    } else {
        echo "Fail";
    }


?>