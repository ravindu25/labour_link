<?php
    require_once('../db.php');
    require('../models/booking.php');

    // Getting all the bookings
    $sql_get_all_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Customer_ID = 9 ORDER BY Booking.Created_Date";

    $result = $conn->query($sql_get_all_bookings);

    $all_bookings = array();

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
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

            $booking = new Booking($bookingId, $customerId, $customerName, $workerId, $workerName,
                                    $createdDate, $startDate, $endDate, $workerType, $status);

            array_push($all_bookings, $booking);
        }
    }

    header('Access-Control-Allow-Origin: http://localhost/labour_link');
    header('Content-Type: application/json');
    echo json_encode($all_bookings);
?>
