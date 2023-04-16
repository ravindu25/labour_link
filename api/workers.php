<?php
    require_once('../db.php');
    require('../models/worker.php');

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        if(isset($_GET['workerType'])){
            $workerType = $_GET['workerType'];

            $sql_get_workers = "select * from User inner join Worker on User.User_ID = Worker.Worker_ID";

            if($workerType === 'plumber') {
                $sql_get_workers = $sql_get_workers . " inner join Plumber ON Worker.Worker_ID = Plumber.Plumber_ID";
            } else if($workerType === 'carpenter'){
                $sql_get_workers = $sql_get_workers . " inner join Carpenter ON Worker.Worker_ID = Carpenter.Carpenter_ID";
            } else if($workerType === 'electrician'){
                $sql_get_workers = $sql_get_workers . " inner join Electrician ON Worker.Worker_ID = Electrician.Electrician_ID";
            } else if($workerType === 'painter'){
                $sql_get_workers = $sql_get_workers . " inner join Painter ON Worker.Worker_ID = Painter.Painter_ID";
            } else if($workerType === 'mason'){
                $sql_get_workers = $sql_get_workers . " inner join Mason ON Worker.Worker_ID = Mason.Mason_ID";
            } else if($workerType === 'janitor'){
                $sql_get_workers = $sql_get_workers . " inner join Janitor ON Worker.Worker_ID = Janitor.Janitor_ID";
            } else if($workerType === 'mechanic'){
                $sql_get_workers = $sql_get_workers . " inner join Mechanic ON Worker.Worker_ID = Mechanic.Mechanic_ID";
            } else if($workerType === 'gardener'){
                $sql_get_workers = $sql_get_workers . " inner join Gardener ON Worker.Worker_ID = Gardener.Gardener_ID";
            }

            $sql_get_workers = $sql_get_workers . " order by Worker.Current_Rating desc";

            $result = $conn->query($sql_get_workers);

            $workers = array();

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    /*
                     * Creating the worker entity
                     */

                    $userId = $row['User_ID'];
                    $fullName = $row['First_Name'] . " " . $row['Last_Name'];
                    $email = $row['Email'];
                    $contactNum = $row['Contact_No'];
                    $nic = $row['NIC'];
                    $dob = $row['DOB'];
                    $address = $row['User_Address'];
                    $city = $row['City'];
                    $currentRating = $row['Current_Rating'];

                    $worker = new Worker($userId, $fullName, $email, $contactNum, $nic, $dob, $address, $city, $currentRating);

                    array_push($workers, $worker);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($workers);
        }
    }
