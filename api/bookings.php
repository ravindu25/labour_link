<?php
    require_once('../db.php');
    require('../models/booking.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['bookingId'])) {
            /*
             * Getting an individual booking
             */
            $bookingId = $_GET['bookingId'];

            $sql_get_booking = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Worker.User_Address AS Worker_Address, Worker.Contact_No AS Worker_Contact_Num ,Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name, Customer.User_Address AS Customer_Address, Customer.Contact_No AS Customer_Contact_No from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Booking_ID = $bookingId ORDER BY Booking.Created_Date LIMIT 1";

            $result = $conn->query($sql_get_booking);

            $booking = null;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['Customer_First_Name'] . " " . $row['Customer_Last_Name'];
                    $customerContactNo = $row['Customer_Contact_No'];
                    $customerAddress = $row['Customer_Address'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $workerContactNo = $row['Worker_Contact_Num'];
                    $workerAddress = $row['Worker_Address'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];
                    $paymentAmount = $row['Payment_Amount'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $customerAddress, $customerContactNo, $workerAddress, $workerContactNo,$workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod, $paymentAmount);
                }
            }


            header('Content-Type: application/json');

            echo json_encode($booking);
        } else if (isset($_GET['customerId'])) {
            $customerId = $_GET['customerId'];
            // Getting all the bookings
            $sql_get_all_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Worker.User_Address AS Worker_Address, Worker.Contact_No AS Worker_Contact_Num ,Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name, Customer.User_Address AS Customer_Address, Customer.Contact_No AS Customer_Contact_No from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Customer_ID = $customerId ORDER BY Booking.Created_Date DESC";

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
                    $customerContactNo = $row['Customer_Contact_No'];
                    $customerAddress = $row['Customer_Address'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $workerContactNo = $row['Worker_Contact_Num'];
                    $workerAddress = $row['Worker_Address'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];
                    $paymentAmount = $row['Payment_Amount'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $customerAddress, $customerContactNo, $workerAddress, $workerContactNo,$workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod, $paymentAmount);

                    array_push($all_bookings, $booking);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($all_bookings);
        }
        else if (isset($_GET['workerId'])) {
            $workerId = $_GET['workerId'];
            // Getting all the bookings
            $sql_get_all_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Worker.User_Address AS Worker_Address, Worker.Contact_No AS Worker_Contact_Num ,Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name, Customer.User_Address AS Customer_Address, Customer.Contact_No AS Customer_Contact_No from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Worker_ID = $workerId ORDER BY Booking.Created_Date DESC";

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
                    $customerContactNo = $row['Customer_Contact_No'];
                    $customerAddress = $row['Customer_Address'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $workerContactNo = $row['Worker_Contact_Num'];
                    $workerAddress = $row['Worker_Address'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];
                    $paymentAmount = $row['Payment_Amount'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $customerAddress, $customerContactNo, $workerAddress, $workerContactNo,$workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod, $paymentAmount);

                    array_push($all_bookings, $booking);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($all_bookings);
        } else {
            // Getting all the bookings
            $sql_get_all_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Worker.User_Address AS Worker_Address, Worker.Contact_No AS Worker_Contact_Num ,Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name, Customer.User_Address AS Customer_Address, Customer.Contact_No AS Customer_Contact_No from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID ORDER BY Booking.Created_Date DESC";

            $result = $conn->query($sql_get_all_bookings);

            $all_bookings = array();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingId = $row['Booking_ID'];
                    $customerId = $row['Customer_ID'];
                    $customerName = $row['Customer_First_Name'] . " " . $row['Customer_Last_Name'];
                    $customerContactNo = $row['Customer_Contact_No'];
                    $customerAddress = $row['Customer_Address'];
                    $workerId = $row['Worker_ID'];
                    $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                    $workerContactNo = $row['Worker_Contact_Num'];
                    $workerAddress = $row['Worker_Address'];
                    $createdDate = $row['Created_Date'];
                    $startDate = $row['Start_Date'];
                    $endDate = $row['End_Date'];
                    $workerType = $row['Worker_Type'];
                    $status = $row['Status'];
                    $paymentMethod = $row['Payment_Method'];
                    $paymentAmount = $row['Payment_Amount'];

                    $booking = new Booking($bookingId, $customerId, $customerName, $customerAddress, $customerContactNo, $workerAddress, $workerContactNo,$workerId, $workerName,$createdDate, $startDate, $endDate, $workerType, $status, $paymentMethod, $paymentAmount);

                    array_push($all_bookings, $booking);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($all_bookings);
        }
    } else if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['action']) && $_GET['action'] === 'updateStatus'){
        $data = json_decode(file_get_contents('php://input'), true);

        $bookingId = $data['bookingId'];
        $status = $data['status'];

        // Valid status for booking ['Pending', 'Accepted-by-worker', 'Rejected-by-worker', 'Accepted-by-customer', 'Rejected-by-customer', 'Completed']

        $validStatus = array('Pending', 'Accepted-by-worker', 'Rejected-by-worker', 'Accepted-by-customer', 'Rejected-by-customer', 'Completed');

        if(in_array($status, $validStatus)){
            $sql_update_booking = "UPDATE Booking SET Status = '$status' WHERE Booking_ID = $bookingId";

            header('Content-Type: application/json');

            if($result = $conn->query($sql_update_booking)){
                if($status === 'Accepted-by-worker'){
                    // Getting the payment amount
                    if(is_numeric($data['paymentAmount'])){
                        $paymentAmount = (float)$data['paymentAmount'];

                        $sql_update_booking = "UPDATE Booking SET Payment_Amount = $paymentAmount WHERE Booking_ID = $bookingId";

                        if($result = $conn->query($sql_update_booking)){
                            http_response_code(200);
                            echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
                        } else {
                            $sql_update_booking = "UPDATE Booking SET Status = 'Pending' WHERE Booking_ID = $bookingId";

                            $result = $conn->query($sql_update_booking);

                            http_response_code(500);
                            echo json_encode(array("status"=>"failed", "message"=>"Payment updation failed"));
                        }
                    } else {
                        http_response_code(500);
                        echo json_encode(array("status"=>"failed", "message"=>"Invalid payment amount"));
                    }
                } else if($status === 'Accepted-by-customer'){
                    $sql_get_booking_details = "SELECT End_Date, Payment_Method, Payment_Amount FROM Booking WHERE Booking_ID = $bookingId";
                    $endDate = null;
                    $paymentMethod = null;
                    $paymentAmount = null;

                    $result = $conn->query($sql_get_booking_details);
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $endDate = $row['End_Date'];
                            $paymentMethod = $row['Payment_Method'];
                            $paymentAmount = $row['Payment_Amount'];
                        }
                    }

                    if($paymentMethod === 'Online'){
                        $sql_add_payment_details = "INSERT INTO Payments_Due(Booking_ID, Due_Amount, Due_Date) VALUES ($bookingId, $paymentAmount, '$endDate')";

                        if($result = $conn->query($sql_add_payment_details)){
                            http_response_code(200);
                            echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
                        } else {
                            $sql_update_booking = "UPDATE Booking SET Status = 'Accepted-by-customer' WHERE Booking_ID = $bookingId";

                            $result = $conn->query($sql_update_booking);

                            http_response_code(500);
                            echo json_encode(array("status"=>"failed", "message"=>"Payment updation failed"));
                        }
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
                }
            } else {
                http_response_code(500);
                echo json_encode(array("status"=>"failed"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("status"=>"failed", "message"=>"Invalid status"));
        }
        } else if($_SERVER['REQUEST_METHOD'] === 'PUT' && $_GET['bookingId'] && $_GET['paymentAmount']){

        $bookingId = $_GET['bookingId'];

        if(is_numeric($_GET['paymentAmount'])){
            $paymentAmount = (float)$_GET['paymentAmount'];

            $sql_update_booking = "UPDATE Booking SET Payment_Amount = $paymentAmount WHERE Booking_ID = $bookingId";

            header('Content-Type: application/json');

            if($result = $conn->query($sql_update_booking)){
                http_response_code(200);
                echo json_encode(array("status"=>"success", "bookingId"=> $bookingId));
            } else {
                http_response_code(500);
                echo json_encode(array("status"=>"failed"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("status"=>"failed", "message"=>"Invalid payment amount"));
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
