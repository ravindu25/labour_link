<?php
    require_once('../db.php');
    require('../models/booking.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['bookingId'])) {
            /*
             * Getting an individual booking
             */
            $bookingId = $_GET['bookingId'];

            $sql_get_booking = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Booking_ID = $bookingId ORDER BY Booking.Created_Date LIMIT 1";

            $result = $conn->query($sql_get_booking);

            $booking = null;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['Customer_First_Name'] . " " . $row['Customer_Last_Name'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $workerId, $workerName,
                        $createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod);
                }
            }

            header('Content-Type: application/json');

            echo json_encode($booking);
        } else if (isset($_GET['customerId'])) {
            $customerId = $_GET['customerId'];
            // Getting all the bookings
            $sql_get_all_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Customer_ID = $customerId ORDER BY Booking.Created_Date DESC";

            // Check whether bookings amount is defined
            if(isset($_GET['num'])){
                $numOfBookings = $_GET['num'];

                $sql_get_all_bookings = $sql_get_all_bookings . " LIMIT $numOfBookings";
            }

            $result = $conn->query($sql_get_all_bookings);

            $all_bookings = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['Customer_First_Name'] . " " . $row['Customer_Last_Name'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $workerId, $workerName,
                        $createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod);

                    array_push($all_bookings, $booking);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($all_bookings);
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'DELETE' && $_GET['bookingId']){
        $bookingId = $_GET['bookingId'];

        $sql_delete_booking = "DELETE FROM Booking WHERE Booking_ID = $bookingId";

        header('Content-Type: application/json');

        if($result = $conn->query($sql_delete_booking)){
            http_response_code(200);
            echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
        } else {
            http_response_code(500);
            echo json_encode(array("status"=>"failed"));
        }
    }
?>
