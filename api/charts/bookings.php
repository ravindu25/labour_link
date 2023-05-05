<?php
    require_once('../../db.php');
    require('../../models/booking.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['term']) && $_GET['term'] == 'getBookingCount') {
            $sql_get_booking_count = "SELECT COUNT(Booking_ID) AS BookingCount, Worker_Type FROM Booking GROUP BY Worker_Type";

            $result = $conn->query($sql_get_booking_count);
            $firstResult = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingCount = $row['BookingCount'];
                    $workerType = $row['Worker_Type'];

                    array_push($firstResult, array('bookingCount' => $bookingCount, 'workerType' => $workerType));
                }
            }

            $currentYear = $_GET['year'];
            $sql_get_montly_booking_count = "SELECT COUNT(Booking_ID) AS BookingCount, MONTH(Start_Date) AS Month, Worker_Type FROM Booking WHERE YEAR(Start_Date) = $currentYear GROUP BY MONTH(Start_Date), Worker_Type ";

            $result = $conn->query($sql_get_montly_booking_count);
            $secondResult = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingCount = $row['BookingCount'];
                    $monthNumber = $row['Month'];
                    $workerType = $row['Worker_Type'];

//                    $dateObj = DateTime::createFromFormat('!m', $monthNumber);
//                    $monthText = $dateObj->format('F');

                    array_push($secondResult, array('workerType' => $workerType, 'month' => $monthNumber, 'bookingCount' => $bookingCount));
                }
            }

            header('Content-Type: application/json');
            // echo json_encode('Hello');
            echo json_encode(array('firstResult' => $firstResult, 'secondResult' => $secondResult));
        }
    }

