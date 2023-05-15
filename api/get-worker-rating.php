<?php
require_once('../db.php');

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['workerId'])){
        $workerId = $_GET['workerId'];

        $sql_get_avg_rating = "SELECT Current_Rating FROM Worker WHERE Worker_ID = $workerId";

        $result = $conn->query($sql_get_avg_rating);
        $workerRating = 0;

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $workerRating = $row['Current_Rating'];
            }
        }

        header('Content-Type: application/json');
        echo json_encode(array('workerId' => $workerId, 'workerRating' => $workerRating));
    }
}