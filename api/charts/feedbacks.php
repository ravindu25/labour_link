<?php

    require_once('../../db.php');
    require('../../models/feedback.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['term']) && $_GET['term'] == 'getFeedbackCount') {
            $sql_get_feedback_count = "SELECT COUNT(*) AS FeedbackCount, Date(Timestamp) FROM Feedback GROUP By Date(Timestamp)";

            $result = $conn->query($sql_get_feedback_count);
            $resultArray = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $feedbackCount = $row['FeedbackCount'];
                    $date = $row['Date(Timestamp)'];

                    array_push($resultArray, array('feedbackCount' => $feedbackCount, 'date' => $date));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($resultArray);
        }
    }
