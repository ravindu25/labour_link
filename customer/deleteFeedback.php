<?php
    //fetch delete method call

    require_once '../db.php';

    $postData = json_decode(file_get_contents('php://input'), true);

    $feedbackToken = $postData['feedbackToken'];

    $sql_delete = "DELETE FROM Feedback WHERE Feedback_Token = '$feedbackToken'";

    $result = mysqli_query($conn, $sql_delete);

    if($result){
        echo json_encode(array("statusCode"=>200));
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }
?>