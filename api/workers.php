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
                    $workerCategories = getAllCategories($conn, $userId);

                    $worker = new Worker($userId, $fullName, $email, $contactNum, $nic, $dob, $address, $city, $currentRating, $workerCategories);

                    array_push($workers, $worker);
                }
            }

            header('Content-Type: application/json');
            echo json_encode($workers);
        }
        // else if(isset($_GET['workerId']))
    }

    function getAllCategories($conn, $workerId){
        $sql_statement = "SELECT Worker.Worker_ID, P.Plumber_ID, C.Carpenter_ID, E.Electrician_ID, P2.Painter_ID,
        M.Mason_ID, J.Janitor_ID, M2.Mechanic_ID, G.Gardener_ID
                    FROM Worker LEFT JOIN Plumber P on Worker.Worker_ID = P.Plumber_ID
                    LEFT JOIN Carpenter C on Worker.Worker_ID = C.Carpenter_ID
                    LEFT JOIN Electrician E on Worker.Worker_ID = E.Electrician_ID
                    LEFT JOIN Painter P2 on Worker.Worker_ID = P2.Painter_ID
                    LEFT JOIN Mason M on Worker.Worker_ID = M.Mason_ID
                    LEFT JOIN Janitor J on Worker.Worker_ID = J.Janitor_ID
                    LEFT JOIN Mechanic M2 on Worker.Worker_ID = M2.Mechanic_ID
                    LEFT JOIN Gardener G on Worker.Worker_ID = G.Gardener_ID WHERE Worker_ID = $workerId";

        $result = $conn->query($sql_statement);

        $workerCategories = array();

        if($result->num_rows){
            while($row = $result->fetch_assoc()){
                if($row['Plumber_ID'] != null){
                    array_push($workerCategories, "Plumber");
                }

                if($row['Carpenter_ID'] != null){
                    array_push($workerCategories, "Carpenter");
                }

                if($row['Electrician_ID'] != null){
                    array_push($workerCategories, "Electrician");
                }

                if($row['Painter_ID'] != null){
                    array_push($workerCategories, "Painter");
                }

                if($row['Mason_ID'] != null){
                    array_push($workerCategories, "Mason");
                }

                if($row['Janitor_ID'] != null){
                    array_push($workerCategories, "Janitor");
                }

                if($row['Mechanic_ID'] != null){
                    array_push($workerCategories, "Mechanic");
                }

                if($row['Gardener_ID'] != null){
                    array_push($workerCategories, "Gardener");
                }
            }
        }

        return $workerCategories;
    }
