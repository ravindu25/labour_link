<?php
    require_once "../db.php";
    $searchInput = $_POST['searchInput'];
    $sql = "SELECT First_Name, Last_Name FROM User WHERE First_Name LIKE '%$searchInput%' OR Last_Name LIKE '%$searchInput%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<div class=\"search-item\"><i class=\"fa-solid fa-wrench\"></i><h3>".$row['First_Name']." ".$row['Last_Name']."</h3></div>";
        }
    } else {
        echo "No results found";
    }
?>