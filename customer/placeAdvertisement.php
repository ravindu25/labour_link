<?php
    $houseID = $_POST['houseID'];
    $jobID = $_POST['jobID'];

    require_once('../db.php');

    $sql = "UPDATE Job SET Advertisement_Status = 1 WHERE Job_Type_ID = $jobID AND House_ID = $houseID";
    $result = $conn -> query($sql);

    if($result){
        echo('success');
    } else {
        echo('fail');
    }
?>