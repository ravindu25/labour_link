<?php
session_start();
//if not logged in redirect to login page
 if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
      header("Location: admin-login.php"); 
 }
    require_once '../db.php';

    function password_generate($chars) {
        $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($data), 0, $chars);
    }


    //use the ajax fetch call to get the user id and do the query and return status
    $user_id = $_POST['user_id'];
    $new_password = password_generate(10);
    $sql = "UPDATE User SET Pswd = '$new_password' WHERE User_ID = '$user_id'";
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
    $mail->Body = "Dear $name, <br><br> Your password has been reset by the System Admin as per your request. <br> Your new password is $new_password. <br> Please change your password after logging in. <br><br> Thank you.";

    if ($result) {
        echo "Success";
        $mail->send();
    } else {
        echo "Fail";
    }


?>