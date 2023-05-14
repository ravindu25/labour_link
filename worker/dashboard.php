<?php
    session_start();
    // Check whether labourer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
        header("Location: ../login.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;500;600&display=swap"
          rel="stylesheet">

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

    <!-- CSS files -->
    <link href="../styles/index-page.css" rel="stylesheet"/>
    <link href="../styles/worker-dashboard.css" rel="stylesheet"/>
    <link href="../styles/worker/worker-dashboard.css" rel="stylesheet"/>
    <title>Labourer Dashboard | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<?php include_once '../components/navbar.php' ?>
<main class="main-section">
    <section class="sidebar">
        <h1 class="sidebar-heading">Dashboard</h1>
        <div class="sidebar-items">
            <a href="./dashboard.php">
                <div class="sidebar-item sidebar-item-selected">
                    <i class="fa-solid fa-server sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Overview</h4>
                </div>
            </a>
            <a href="./bookings.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-b sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Bookings</h4>
                </div>
            </a>
            <a href="./housing.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-house sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Housing</h4>
                </div>
            </a>
            <a href="./payments.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-credit-card sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Payments</h4>
                </div>
            </a>
            <a href="./profile.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-circle-user sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Profile</h4>
                </div>
            </a>
        </div>
    </section>
    <section class="main-content">
        <div class="main-heading">
        <h1>Welcome Back
                <u>
                    <?php
                        echo $_SESSION['first_name'] . " " . $_SESSION['last_name']
                    ?>
                </u>
            </h1>
            <?php
                require_once('../db.php');
                // Getting the most recent logging attempt of the current user
                $sql = "SELECT * FROM User WHERE Email = '{$_SESSION['username']}'";
                $result = $conn -> query($sql);

                // Getting the current user id
                $row = $result->fetch_assoc();
                $userId = $row['User_ID'];


                $sql = "SELECT * FROM Login_Attempt WHERE User_ID = {$userId} ORDER BY Timestamp DESC LIMIT 1";
                $result = $conn -> query($sql);

                $row = $result->fetch_assoc();
                $latestTime = date_create($row['Timestamp']);

                $dateInText = date_format($latestTime, 'dS F Y');

                echo "<h5>Last accessed $dateInText</h5>";
            ?>            
        </div>
        <div class="overview-content">
            <h1>Overview</h1>
        </div>
        <!--Recent bookings section-->
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recent Bookings</h1>
                <button class="primary-button" onclick="window.location.href='bookings.php'">More Bookings</button>
            </div>
            <div class="recent-bookings-container">
            <?php
                require_once '../db.php';

                // $sql = "SELECT First_Name,Last_Name ,Start_Date , Completion_Flag FROM user INNER JOIN booking ON user.User_ID = booking.Customer_ID INNER JOIN confirmed_booking ON booking.Booking_ID = confirmed_booking.Booking_ID";

                $sql = "SELECT First_Name,Last_Name ,Start_Date, Worker_Type, Created_Date FROM User INNER JOIN Booking ON User.User_ID = Booking.Customer_ID WHERE Booking.Worker_ID={$_SESSION['user_id']} ORDER BY Created_Date DESC LIMIT 5";

                // $array1 = array("Plumbing","Carpentry","Electrical","Painting","Masonry","Janitorial","Mechanical","Gardening");
                $array2 = array("Pending","Completed","Rejected","In-Progress");

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $arrValue = array_rand($array2,1);
                        if($arrValue == 0){
                            $btn = "<button class='pending-button'>Pending</button>";  
                        }
                        else if($arrValue == 1){
                            $btn = "<button class='completed-button'>Completed</button>";
                        }
                        else if($arrValue == 2){
                            $btn = "<button class='rejected-button'>Rejected</button>";
                        }
                        else {
                            $btn = "<button class='in-pogress-button'>In-Progress</button>";  
                        }
                        echo('
                        <div class="booking-card"
                            <div class="card-text">
                                <h3>'.$row['Worker_Type'].'</h3>
                                <p>Customer</p>
                                <h4>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</h4>
                            <div class="booking-card-button-row">
                                <div class="badge-container">
                                    <div class="blue-badge">' . date("d M Y", strtotime($row['Start_Date'])) . '</div> 
                                </div>
                                '. $btn .'
                            </div>
                        </div>

                    ');
                    }
                }
                ?>
                </div>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/bookings.js" type="text/javascript"></script>
</body>