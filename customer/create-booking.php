<?php
    require_once('../db.php');
    session_start();

    /* Getting Data From the Form */
    // $customer_id = $_SESSION['user_id'];
    $customer_id = 10;
    $worker_type = $_REQUEST['job-type'];
    $worker_id = $_REQUEST['worker-id'];
    $starting_date = $_REQUEST['start-date'];
    $days_to_complete = $_REQUEST['time-input'];

    $ending_date = date('Y-m-d', strtotime($starting_date. ' +' . $days_to_complete . ' days'));

    $payment_method = $_REQUEST['payment-method'];

    /* Creating the SQL Query Statement for Inserting Booking */
    $sql_create_booking = "INSERT INTO labour_link.booking(Customer_ID, Worker_ID, Start_Date, End_Date) values($customer_id, $worker_id, '$starting_date', '$ending_date')";

    $result = $conn->query($sql_create_booking);
?>
