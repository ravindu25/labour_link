<?php
    require_once('../db.php');
    session_start();

    /* Getting Data From the Form */
    $customer_id = $_SESSION['user_id'];
    $worker_type = $_POST['job-type'];
    $worker_id = $_POST['worker-name'];
    $starting_date = $_POST['start-date'];
    $days_to_complete = $_POST['time-input'];

    $ending_date = date('Y-m-d', strtotime($starting_date. ' +' . $days_to_complete . ' days'));

    $payment_method = $_POST['payment-method'];

    /* Creating the SQL Query Statement for Inserting Booking */
    $sql_create_booking = "INSERT INTO labour_link.booking(Customer_ID, Worker_ID, Start_Date, End_Date) values($customer_id, $worker_id, '$starting_date', '$ending_date')";

    echo $sql_create_booking;

    $result = $conn->query($sql_create_booking);

    header("Location: bookings.php");

?>
