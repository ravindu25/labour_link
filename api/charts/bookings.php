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
            $sql_get_monthly_booking_count_per_type = "SELECT COUNT(Booking_ID) AS BookingCount, MONTH(Start_Date) AS Month, Worker_Type FROM Booking WHERE YEAR(Start_Date) = $currentYear GROUP BY MONTH(Start_Date), Worker_Type ";

            $result = $conn->query($sql_get_monthly_booking_count_per_type);
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

            $sql_get_total_booking_count = "SELECT COUNT(Booking_ID) AS BookingCount, MONTH(Start_Date) AS Month FROM Booking WHERE YEAR(Start_Date) = $currentYear GROUP BY MONTH(Start_Date) ORDER BY MONTH(Start_Date) ASC";

            $result = $conn->query($sql_get_total_booking_count);
            $thirdResult = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingCount = $row['BookingCount'];
                    $monthNumber = $row['Month'];
                    array_push($thirdResult, array('month' => $monthNumber, 'bookingCount' => $bookingCount));
                }
            }

            $sql_get_ongoing_bookings_divided = "SELECT COUNT(Booking_ID) AS BookingCount, Status AS Status FROM Booking WHERE Status = 'Pending' || Status = 'Accepted' GROUP BY Status";

            $result = $conn->query($sql_get_ongoing_bookings_divided);
            $fourthResult = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingCount = $row['BookingCount'];
                    $status = $row['Status'];
                    array_push($fourthResult, array('bookingCount' => $bookingCount, 'status' => $status));
                }
            }

            header('Content-Type: application/json');
            echo json_encode(array('firstResult' => $firstResult, 'secondResult' => $secondResult, 'thirdResult' => $thirdResult, 'fourthResult' => $fourthResult));
        }else if(isset($_GET['term']) && $_GET['term'] == 'getAdminBookingData'){
            $currentMonth = date('m');
            $currentYear = date('Y');

            $sql_get_monthly_bookings = "SELECT COUNT(Booking_ID) AS BookingCount, DATE(Start_Date) AS Date FROM Booking WHERE MONTH(Start_Date) = $currentMonth GROUP BY DAY(Start_Date)";

            $result = $conn->query($sql_get_monthly_bookings);
            $monthlyBookingResults = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $date = $row['Date'];
                    $bookingCount = $row['BookingCount'];
                    array_push($monthlyBookingResults, array('date' => $date, 'bookingCount' => $bookingCount));
                }
            }

            $sql_get_online_bookings = "SELECT COUNT(Booking_ID) AS BookingCount, MONTH(Start_Date) AS Month FROM Booking WHERE YEAR(Start_Date) = $currentYear AND Payment_Method = 'Online' GROUP BY MONTH(Start_Date)";

            $result = $conn->query($sql_get_online_bookings);
            $onlineBookingResults = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $month = $row['Month'];
                    $bookingCount = $row['BookingCount'];
                    array_push($onlineBookingResults, array('month' => $month, 'bookingCount' => $bookingCount));
                }
            }

            header('Content-Type: application/json');
            echo json_encode(array('monthlyBookingResults' => $monthlyBookingResults, 'onlineBookingResults' => $onlineBookingResults));


        }
    }

?>