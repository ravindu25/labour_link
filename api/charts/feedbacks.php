<?php

    require_once('../../db.php');
    require('../../models/feedback.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['term']) && $_GET['term'] == 'getFeedbackCount') {
            $sql_get_feedback_count = "SELECT COUNT(*) AS FeedbackCount, Date(Timestamp) FROM Feedback GROUP By Date(Timestamp)";

            if(isset($_GET['month']) && isset($_GET['year'])){
                $month = $_GET['month'];
                $year = $_GET['year'];

                $sql_get_feedback_count = "SELECT COUNT(*) AS FeedbackCount, Date(Timestamp) FROM Feedback WHERE MONTH(Timestamp) = $month AND YEAR(Timestamp) = $year GROUP By Date(Timestamp)";
            }

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
        } else if(isset($_GET['term']) && $_GET['term'] == 'getSkippingFeedback'){
            $sql_get_skipping_feedback = "SELECT SUM(CASE WHEN Feedback_Token IS null THEN 1 ELSE 0 END) AS FeedbackCount , User.First_Name AS CustomerFirstname, User.Last_Name AS CustomerLastname FROM Booking LEFT JOIN Feedback F on Booking.Booking_ID = F.Booking_ID INNER JOIN User ON Booking.Customer_ID = User.User_ID WHERE Booking.Status LIKE 'Completed' GROUP BY Booking.Customer_ID ORDER BY FeedbackCount DESC LIMIT 20";

            $result = $conn->query($sql_get_skipping_feedback);
            $resultArray = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $feedbackCount = $row['FeedbackCount'];
                    $customername = $row['CustomerFirstname'] . " " . $row['CustomerLastname'];

                    array_push($resultArray, array('customerName' => $customername, 'feedbackCount' => $feedbackCount));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($resultArray);
        }
    }
