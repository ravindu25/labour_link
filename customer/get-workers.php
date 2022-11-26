<?php
    require_once('../db.php');
    /* Workers and their type */
    /*
    $workers['plumber'] = ['Sampath Fernando', 'Sunil Hettiarachchi', 'Shantha Wijewardene', 'Kalindu Perera'];
    $workers['carpenter'] = ['Janaka Hettiarachchi', 'Roshan Ranasinghe', 'Sampath Attanayaka', 'Ruwan Perera'];
    $workers['janitor'] = ['Lahiru Fernando', 'Manjula Hettiarachchi', 'Isuru Wijewardene', 'Rasika Perera'];
    $workers['mechanical'] = ['Chandana Perera', 'Mahesh Kumara', 'Aruna Hettiarachchi', 'Asanka Gunawardhana'];
    $workers['gardner'] = ['Sameera Gunathilaka', 'Ajith Fernando', 'Pradeep Hettiarachchi', 'Tharindu Gunawardhana'];
    */

    $workerType = $_GET['type'];
    $sql = '';

    switch($workerType){
        case 'electrician':
            $sql = "select user.User_ID, user.First_Name, user.Last_Name from user inner join electrician on user.User_ID = electrician.Electrician_ID";
            break;
        case 'painter':
            $sql = "select user.User_ID, user.First_Name, user.Last_Name from user inner join painter on user.User_ID = painter.Painter_ID";
            break;
        case 'mason':
            $sql = "select user.User_ID, user.First_Name, user.Last_Name from user inner join mason on user.User_ID = mason.Mason_ID";
            break;
        default:
            $sql = "select user.User_ID, user.First_Name, user.Last_Name from user inner join electrician on user.User_ID = electrician.Electrician_ID";
    }

    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $userId = $row['User_ID'];
            $firstname = $row['First_Name'];
            $lastname = $row['Last_Name'];
            echo "<option value='$userId'>$firstname $lastname</option>";
        }
    }
?>

