<?php
    //get xml data from request
    $user_id = $_POST['user_id'];
    if($_POST['selectedJobTypes']!=""){
        $selectedJobTypes = explode(',', $_POST['selectedJobTypes']);
    }
    if($_POST['unselectedJobTypes']!=""){
        $unselectedJobTypes = explode(',', $_POST['unselectedJobTypes']);
    }


    require_once('../db.php');

    $allCorrect = true;
    //iterate for each job type
    
    //if not empty

    if(!empty($selectedJobTypes)){
        foreach($selectedJobTypes as $jobType){
            //insert into database

            if($jobType=="Carpenter"){
                $sql = "UPDATE Carpenter SET Active = 0 WHERE Carpenter_ID = '$user_id'";
            }else if($jobType=="Electrician"){
                $sql = "UPDATE Electrician SET Active = 0 WHERE Electrician_ID = '$user_id'";
            }else if($jobType=="Mason"){
                $sql = "UPDATE Mason SET Active = 0 WHERE Mason_ID = '$user_id'";
            }else if($jobType=="Painter"){
                $sql = "UPDATE Painter SET Active = 0 WHERE Painter_ID = '$user_id'";
            }else if($jobType=="Plumber"){
                $sql = "UPDATE Plumber SET Active = 0 WHERE Plumber_ID = '$user_id'";
            }else if($jobType=="Gardener"){
                $sql = "UPDATE Gardener SET Active = 0 WHERE Gardener_ID = '$user_id'";
            }else if($jobType=="Janitor"){
                $sql = "UPDATE Janitor SET Active = 0 WHERE Janitor_ID = '$user_id'";
            }else if($jobType=="Mechanic"){
                $sql = "UPDATE Mechanic SET Active = 0 WHERE Mechanic_ID = '$user_id'";
            }

        
            $result = mysqli_query($conn, $sql);
            if(!$result){
                $allCorrect = false;
            }

        }
    }

    if(!empty($unselectedJobTypes)){

        foreach($unselectedJobTypes as $jobType){
            //insert into database

            if($jobType=="Carpenter"){
                $sql = "UPDATE Carpenter SET Active = 1 WHERE Carpenter_ID = '$user_id'";
            }else if($jobType=="Electrician"){
                $sql = "UPDATE Electrician SET Active = 1 WHERE Electrician_ID = '$user_id'";
            }else if($jobType=="Mason"){
                $sql = "UPDATE Mason SET Active = 1 WHERE Mason_ID = '$user_id'";
            }else if($jobType=="Painter"){
                $sql = "UPDATE Painter SET Active = 1 WHERE Painter_ID = '$user_id'";
            }else if($jobType=="Plumber"){
                $sql = "UPDATE Plumber SET Active = 1 WHERE Plumber_ID = '$user_id'";
            }else if($jobType=="Gardener"){
                $sql = "UPDATE Gardener SET Active = 1 WHERE Gardener_ID = '$user_id'";
            }else if($jobType=="Janitor"){
                $sql = "UPDATE Janitor SET Active = 1 WHERE Janitor_ID = '$user_id'";
            }else if($jobType=="Mechanic"){
                $sql = "UPDATE Mechanic SET Active = 1 WHERE Mechanic_ID = '$user_id'";
            }

        
            $result = mysqli_query($conn, $sql);
            if(!$result){
                $allCorrect = false;
            }

        }
    }


    if($allCorrect){
        echo("success");
    }else{
        echo("fail");
    }





?>