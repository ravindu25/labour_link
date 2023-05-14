<?php
require_once('../db.php');
require('../models/feedback.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['action']) && $_GET['action'] == 'getAllFeedbacks') {
        if (isset($_GET['workerId'])) {  /*to pass worker id*/

            $workerId = $_GET['workerId'];

            $sql_get_feedback = "SELECT Written_Feedback AS Feedback, Feedback_Token AS Token from Feedback inner join Booking on Feedback.Booking_ID = Booking.Booking_ID WHERE Booking.Worker_ID = $workerId AND Feedback.Written_Feedback != ''";

            $result = $conn->query($sql_get_feedback);

            $feedbacks = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $feedback = $row['Feedback'];
                    $token = $row['Token'];

                    // Array types in php
                    // 1. Normal [1, 2, 3]        2. Associative array ["feedback": "heeeeee", "token": 1]

                    array_push($feedbacks, array("writtenFeedback" => $feedback, "token" => $token));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($feedbacks);
        }
    } else if(isset($_GET['action']) && $_GET['action'] == 'getSelectedFeedbacks') {
        if (isset($_GET['workerId'])) {

            $workerId = $_GET['workerId'];

            $sql_get_selected_feedbacks = "SELECT Written_Feedback AS Feedback, Profile_Feedback.Feedback_Token AS Token FROM Profile_Feedback INNER JOIN Feedback ON Profile_Feedback.Feedback_Token = Feedback.Feedback_Token WHERE Worker_ID = $workerId";

            $result = $conn->query($sql_get_selected_feedbacks);

            $feedbacks = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $feedback = $row['Feedback'];
                    $token = $row['Token'];

                    array_push($feedbacks, array("writtenFeedback" => $feedback, "token" => $token));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($feedbacks);
        }
    }
} else if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);

    $workerId = $data['workerId'];
    $feedbackTokens = $data['feedbackTokens'];

    $sql_delete_feedbacks = "DELETE FROM Profile_Feedback WHERE Worker_ID = $workerId";
    $result = $conn->query($sql_delete_feedbacks);

    $sql_insert_feedbacks = "";
    if(sizeof($feedbackTokens) == 3){
        $sql_insert_feedbacks = "INSERT INTO Profile_Feedback VALUES($workerId, $feedbackTokens[0]), ($workerId, $feedbackTokens[1]), ($workerId, $feedbackTokens[2])";
    } else if(sizeof($feedbackTokens) == 2){
        $sql_insert_feedbacks = "INSERT INTO Profile_Feedback VALUES($workerId, $feedbackTokens[0]), ($workerId, $feedbackTokens[1])";
    } else if(sizeof($feedbackTokens) == 1){
        $sql_insert_feedbacks = "INSERT INTO Profile_Feedback VALUES($workerId, $feedbackTokens[0])";
    }

    if($result = $conn->query($sql_insert_feedbacks)){
        http_response_code(200);
        echo json_encode(array("status"=>"success"));
    } else {
        http_response_code(500);
        echo json_encode(array("status"=>"failed"));
    }
} else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
    $data = json_decode(file_get_contents('php://input'), true);

    $workerId = $data['workerId'];
    $description = $data['description'];

    $sql_update_description = "UPDATE Worker SET Description = '$description' WHERE Worker_ID = $workerId";

    if($result = $conn->query($sql_update_description)){
        http_response_code(200);
        echo json_encode(array("status"=>"success"));
    } else {
        http_response_code(500);
        echo json_encode(array("status"=>"failed"));
    }
}

?>
