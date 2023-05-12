<?php
require_once('../db.php');
require('../models/feedback.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
if (isset($_GET['workerId'])) {  /*to pass worker id*/

    $workerId = $_GET['workerId'];

    $sql_get_feedback = "SELECT Written_Feedback AS Feedback, Feedback_Token AS Token from Feedback inner join Booking on Feedback.Booking_ID = Booking.Booking_ID WHERE Booking.Worker_ID = $workerId";

    $result = $conn->query($sql_get_feedback);

    $feedbacks = array();

    if($result->num_rows > 0){
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
}
?>
