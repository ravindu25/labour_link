<?php
    require_once('../../db.php');
    require('../../models/booking.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['term']) && $_GET['term'] == 'getBookingCount') {
            $sql_get_booking_count = "SELECT COUNT(Booking_ID) AS BookingCount, Worker_Type FROM Booking GROUP BY Worker_Type";

            $result = $conn->query($sql_get_booking_count);
            $resultArray = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $bookingCount = $row['BookingCount'];
                    $workerType = $row['Worker_Type'];

                    array_push($resultArray, array('bookingCount' => $bookingCount, 'workerType' => $workerType));
                }
            }

            header('Content-Type: application/json');
            echo json_encode($resultArray);
        }
    }
