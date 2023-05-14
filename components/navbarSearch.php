<?php
    require_once "../db.php";
    $searchInput = $_POST['searchInput'];
    $sql = "SELECT User_ID, First_Name, Last_Name FROM User WHERE First_Name LIKE '%$searchInput%' OR Last_Name LIKE '%$searchInput%'";

    $searchTerm = strtolower($searchInput);

    if(strpos('plumbing', $searchTerm) !== false || strpos('plumbers', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=plumber'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Plumbers</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('carpentry', $searchTerm) !== false || strpos('carpenters', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=carpenter'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Carpenters</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('electrical', $searchTerm) !== false || strpos('electricians', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=electrician'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Electricians</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('painting', $searchTerm) !== false || strpos('painters', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=painter'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Painters</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('masonry', $searchTerm) !== false || strpos('masons', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=mason'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Masons</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('janitorial', $searchTerm) !== false || strpos('janitors', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=janitor'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Janitors</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('mechanical', $searchTerm) !== false || strpos('mechanics', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=mechanic'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Mechanics</h3>
                     </div>
                 </a>
                ";
    }else if(strpos('gardening', $searchTerm) !== false || strpos('gardeners', $searchTerm) !== false){
        echo "
                <a href='/labour_link/worker/index.php?workertype=gardener'>
                    <div class='search-item'>
                        <i class='fa-solid fa-share'></i><h3>Gardeners</h3>
                     </div>
                 </a>
                ";
    }else{

    $result = $conn->query($sql);
    $startCount = 1;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $fullName = $row['First_Name'] ." ". $row['Last_Name'];
            $userId = $row['User_ID'];

            echo "
                <a href='/labour_link/worker/view-worker-profile.php?workerId=$userId'>
                    <div class='search-item'>
                        <i class='fa-solid fa-wrench'></i><h3>$fullName</h3>
                     </div>
                 </a>
                ";
        }
    } else {
        echo "No results found";
    }
}
?>