<?php
    require_once '../db.php';
    require_once '../mailconfiguration.php';

    $postData = json_decode(file_get_contents('php://input'), true);

    $userId = $postData['user_id'];
    $feedback = $postData['feedback'];

    $sql_get_user_details = "SELECT * FROM User WHERE User_ID = '$userId'";
    $result = mysqli_query($conn, $sql_get_user_details);
    $row = mysqli_fetch_assoc($result);
    $firstName = $row['First_Name'];
    $lastName = $row['Last_Name'];

    //send email
    $mail->addAddress('labourlinklanka@gmail.com');
    $mail->Subject = 'System Feedback by User';

    $mail->isHTML(true);
    $mail->Body = '<h1>System Feedback by User</h1>
    <p>First Name: '.$firstName.'</p>
    <p>Last Name: '.$lastName.'</p>
    <p>User ID: '.$userId.'</p>
    <p>Feedback: '.$feedback.'</p>';


    if($mail->send()){
        echo json_encode(array("statusCode"=>200));
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }
?>