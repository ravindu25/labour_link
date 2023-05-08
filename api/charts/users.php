<?php
require_once('../../db.php');

if($_SERVER['REQUEST_METHOD'] === 'GET') {
if (isset($_GET['term']) && $_GET['term'] == 'getUsersCount') {
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

    $sql_get_monthly_user_registration = "SELECT COUNT(User_ID) AS UserCount, MONTH(Registered_Date) AS Month, Type FROM User GROUP BY MONTH(Registered_Date), Type ";

    $result = $conn->query($sql_get_monthly_user_registration );
    $sixthResult = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userCount = $row['UserCount'];
            $monthNumber = $row['Month'];
            $type = $row['Type'];

            array_push($sixthResult, array('UserCount' => $userCount, 'Month' => $monthNumber, 'Type' => $type));
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array('fifthResult' => $fifthResult, 'sixthResult' => $sixthResult));
}
}
?>