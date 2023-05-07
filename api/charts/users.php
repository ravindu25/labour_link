<?php
require_once('../../db.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
if (isset($_GET['term']) && $_GET['term'] == 'getBookingCount') {
    $sql_get_user_count = "SELECT COUNT(User_ID) AS UserCount, Type FROM User GROUP BY Type";

    $result = $conn->query($sql_get_user_count);
    $fifthResult = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userCount = $row['UserCount'];
            $type = $row['Type'];

            array_push($fifthResult, array('UserCount' => $userCount, 'Type' => $type));
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array('fifthResult' => $fifthResult));
}
}
?>
