<?php
    require_once('../db.php');

    $workerType = $_GET['type'];
    $sql = '';

    switch($workerType){
        case 'Electrician':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Electrician on User.User_ID = Electrician.Electrician_ID WHERE Electrician.Active = 1";
            break;
        case 'Plumber':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Plumber on User.User_ID = Plumber.Plumber_ID WHERE Plumber.Active = 1";
            break;
        case 'Painter':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Painter on User.User_ID = Painter.Painter_ID WHERE Painter.Active = 1";
            break;
        case 'Carpenter':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Carpenter on User.User_ID = Carpenter.Carpenter_ID WHERE Carpenter.Active = 1";
            break;
        case 'Mason':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Mason on User.User_ID = Mason.Mason_ID WHERE Mason.Active = 1";
            break;
        case 'Janitor':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Janitor on User.User_ID = Janitor.Janitor_ID WHERE Janitor.Active = 1";
            break;
        case 'Mechanical':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Mechanic on User.User_ID = Mechanic.Mechanic_ID WHERE Mechanic.Active = 1";
            break;
        case 'Gardner':
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Gardener on User.User_ID = Gardener.Gardener_ID WHERE Gardener.Active = 1";
            break;
        default:
            $sql = "select User.User_ID, User.First_Name, User.Last_Name from User inner join Electrician on User.User_ID = Electrician.Electrician_ID WHERE Electrician.Active = 1";
            break;
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

