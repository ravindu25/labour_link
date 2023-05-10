<?php
    //get xml data from request
    $user_id = $_POST['user_id'];
    $jobTypes = explode(',', $_POST['selectedJobTypes']);


    require_once('../db.php');

    $allCorrect = true;
    //iterate for each job type
    foreach($jobTypes as $jobType){
        //insert into database

        if($jobType=="Carpenter"){
            $sql = "INSERT INTO Carpenter (Carpenter_ID) VALUES ('$user_id')";
        }else if($jobType=="Electrician"){
            $sql = "INSERT INTO Electrician (Electrician_ID) VALUES ('$user_id')";
        }else if($jobType=="Mason"){
            $sql = "INSERT INTO Mason (Mason_ID) VALUES ('$user_id')";
        }else if($jobType=="Painter"){
            $sql = "INSERT INTO Painter (Painter_ID) VALUES ('$user_id')";
        }else if($jobType=="Plumber"){
            $sql = "INSERT INTO Plumber (Plumber_ID) VALUES ('$user_id')";
        }else if($jobType=="Gardener"){
            $sql = "INSERT INTO Gardener (Gardener_ID) VALUES ('$user_id')";
        }else if($jobType=="Janitor"){
            $sql = "INSERT INTO Janitor (Janitor_ID) VALUES ('$user_id')";
        }else if($jobType=="Mechanic"){
            $sql = "INSERT INTO Mechanic (Mechanic_ID) VALUES ('$user_id')";
        }

      
        $result = mysqli_query($conn, $sql);
        if(!$result){
            $allCorrect = false;
        }


    }
    if($allCorrect){
        echo("success");
    }else{
        echo("fail");
    }

?>