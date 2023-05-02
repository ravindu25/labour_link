<?php
$bookingId = $_POST['booking_id'];
$status = $_POST['status'];

$connection = mysqli_connect('localhost', 'username', 'password', 'database');
$query = "UPDATE bookings SET status='$status' WHERE id=$bookingId";
$result = mysqli_query($connection, $query);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to update booking status']);
}
?>
