<?php
    require_once('../db.php');
    require('../models/feedback.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['feedbackToken'])) {
            /*
             * Getting an individual feedback
             */
            $feedbackToken = $_GET['feedbackToken'];

            $sql_get_feedback = "SELECT Feedback.*, Booking.*, Worker.First_Name AS WorkerFirstname, Worker.Last_Name AS WorkerLastname, Customer.First_Name AS CustomerFirstname, Customer.Last_Name AS CustomerLastname FROM Feedback INNER JOIN Booking ON Feedback.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID INNER JOIN User AS Customer ON Booking.Customer_ID = Customer.User_ID WHERE Feedback.Feedback_Token = $feedbackToken";

            $result = $conn->query($sql_get_feedback);

            $feedback = null;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $feedbackToken = $row['Feedback_Token'];
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['CustomerFirstname'] . " " . $row['CustomerLastname'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['WorkerFirstname'] . " " . $row['WorkerLastname'];
                    $createdTimestamp = $row['Timestamp'];
                    $ratingPunctuality = $row['Star_Punctuality'];
                    $ratingEfficiency = $row['Star_Efficiency'];
                    $ratingProfessionalism = $row['Star_Professionalism'];
                    $writtenFeedback = $row['Written_Feedback'];
                    $extraObservations = preg_split("/,/", $row['Extra_Observations']);

                    $feedback = new Feedback($feedbackToken, $bookingId, $customerId, $customerName, $workerId, $workerName,
                        $createdTimestamp, $ratingPunctuality, $ratingEfficiency, $ratingProfessionalism, $writtenFeedback, $extraObservations);
                }
            }

            header('Content-Type: application/json');

            echo json_encode($feedback);
        } else if(isset($_GET['customerId'])){
            /*
             * Getting all feedbacks for a customer
             */
            $customerId = $_GET['customerId'];

            $sql_get_feedbacks = "SELECT Feedback.*, Booking.*, Worker.First_Name AS WorkerFirstname, Worker.Last_Name AS WorkerLastname, Customer.First_Name AS CustomerFirstname, Customer.Last_Name AS CustomerLastname FROM Feedback INNER JOIN Booking ON Feedback.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID INNER JOIN User AS Customer ON Booking.Customer_ID = Customer.User_ID WHERE Booking.Customer_ID = $customerId";

            $result = $conn->query($sql_get_feedbacks);

            $feedbacks = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $feedbackToken = $row['Feedback_Token'];
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['CustomerFirstname'] . " " . $row['CustomerLastname'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['WorkerFirstname'] . " " . $row['WorkerLastname'];
                    $createdTimestamp = $row['Timestamp'];
                    $ratingPunctuality = $row['Star_Punctuality'];
                    $ratingEfficiency = $row['Star_Efficiency'];
                    $ratingProfessionalism = $row['Star_Professionalism'];
                    $writtenFeedback = $row['Written_Feedback'];
                    $extraObservations = preg_split("/,/", $row['Extra_Observations']);

                    $feedback = new Feedback($feedbackToken, $bookingId, $customerId, $customerName, $workerId, $workerName,
                        $createdTimestamp, $ratingPunctuality, $ratingEfficiency, $ratingProfessionalism, $writtenFeedback, $extraObservations);

                    array_push($feedbacks, $feedback);
                }
            }

            header('Content-Type: application/json');

            echo json_encode($feedbacks);
        } else {
            /*
             * Getting all feedbacks for a customer
             */

            $sql_get_feedbacks = "SELECT Feedback.*, Booking.*, Worker.First_Name AS WorkerFirstname, Worker.Last_Name AS WorkerLastname, Customer.First_Name AS CustomerFirstname, Customer.Last_Name AS CustomerLastname FROM Feedback INNER JOIN Booking ON Feedback.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID INNER JOIN User AS Customer ON Booking.Customer_ID = Customer.User_ID";

            $result = $conn->query($sql_get_feedbacks);

            $feedbacks = array();
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $feedbackToken = $row['Feedback_Token'];
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['CustomerFirstname'] . " " . $row['CustomerLastname'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['WorkerFirstname'] . " " . $row['WorkerLastname'];
                    $createdTimestamp = $row['Timestamp'];
                    $ratingPunctuality = $row['Star_Punctuality'];
                    $ratingEfficiency = $row['Star_Efficiency'];
                    $ratingProfessionalism = $row['Star_Professionalism'];
                    $writtenFeedback = $row['Written_Feedback'];
                    $extraObservations = preg_split("/,/", $row['Extra_Observations']);

                    $feedback = new Feedback($feedbackToken, $bookingId, $customerId, $customerName, $workerId, $workerName,
                        $createdTimestamp, $ratingPunctuality, $ratingEfficiency, $ratingProfessionalism, $writtenFeedback, $extraObservations);

                    array_push($feedbacks, $feedback);
                }
            }

            header('Content-Type: application/json');

            echo json_encode($feedbacks);
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'PUT'){
        /*
         * Creating a feedback
         */
        $data = json_decode(file_get_contents('php://input'), true);

        $feedbackToken = $data['feedbackToken'];
        $bookingId = $data['bookingId'];
        $customerId = $data['customerId'];
        $customerName = $data['customerName'];
        $workerId = $data['workerId'];
        $workerName = $data['workerName'];
        $createdTimestamp = $data['createdTimestamp'];
        $ratingPunctuality = $data['ratingPunctuality'];
        $ratingEfficiency = $data['ratingEfficiency'];
        $ratingProfessionalism = $data['ratingProfessionalism'];
        $writtenFeedback = $data['writtenFeedback'];
        $extraObservations = join(',',$data['extraObservations']);

        $feedback = new Feedback($feedbackToken, $bookingId, $customerId, $customerName, $workerId, $workerName,
            $createdTimestamp, $ratingPunctuality, $ratingEfficiency, $ratingProfessionalism, $writtenFeedback, $extraObservations);

        $sql_update_feedback = "UPDATE Feedback SET Star_Punctuality = $ratingPunctuality, Star_Efficiency = $ratingEfficiency, Star_Professionalism = $ratingProfessionalism, Written_Feedback = '$writtenFeedback', Extra_Observations = '$extraObservations' WHERE Feedback_Token = $feedbackToken";

        if($result = $conn->query($sql_update_feedback)){
            http_response_code(200);
            echo json_encode(array("status"=>"success", "feedbackToken"=> $bookingId));
        } else {
            http_response_code(500);
            echo json_encode(array("status"=>"failed"));
        }
    }
