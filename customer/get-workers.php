<?php
    require_once('../db.php');

    $workerType = $_GET['type'];
    $sql = '';

    switch($workerType){
        case 'Electrician':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Electrician on User.User_ID = Electrician.Electrician_ID";
            break;
        case 'Painter':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Painter on User.User_ID = Painter.Painter_ID";
            break;
        case 'Mason':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Mason on User.User_ID = Mason.Mason_ID";
            break;
        default:
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Electrician on User.User_ID = Electrician.Electrician_ID";
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

