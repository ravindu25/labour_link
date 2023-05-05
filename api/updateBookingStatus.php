<?php
    require_once('../db.php');
    $data = json_decode(file_get_contents('php://input'), true);

    $bookingId = $data['booking_id'];
    $status = $data['status'];

    // $connection = mysqli_connect('localhost', 'username', 'password', 'database');
    $query = "UPDATE Booking SET Status='$status' WHERE Booking_ID=$bookingId";
    $result = $conn->query($query);

    header('Content-Type: application/json');
    if ($result) {
        http_response_code(200);
        echo json_encode(array('success' => true));
    } else {
        http_response_code(500);
        echo json_encode(array('success' => false, 'error' => 'Failed to update booking status'));
    }
?>
