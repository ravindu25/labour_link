<?php
    session_start();
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
    <link href="../styles/worker/worker-profile.css" rel="stylesheet"/>
    <title>Worker Profile | LabourLink</title>
</head>
<body>
<?php include_once '../components/navbar.php' ?>
<main class="main-section">
    <section class="sidebar">
        <h1 class="sidebar-heading">Dashboard</h1>
        <div class="sidebar-items">
            <a href="./dashboard.php">
                <div class="sidebar-item">
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
            <a href="./feedbacks.php">
                <div class="sidebar-item">
                    <i class="fa-regular fa-message sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Feedbacks</h4>
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
                <div class="sidebar-item sidebar-item-selected">
                    <i class="fa-regular fa-circle-user sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Profile</h4>
                </div>
            </a>
        </div>
    </section>
    <section class="main-content">
        <div class="main-heading">
            <h1>All The settings Of Your <u>Profile</u></h1>
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
        <!-- profile details section -->
        <div class="profile-content">
            <div class="profile-details-title">
                <h1>Profile details</h1>
            </div>
            <div class="profile-details-container">
                <div class="profile-image">
                    <img class="profile-img" src="..\images/profile-image.png"></img>
                    <button class="upload-button"><i class="fa fa-upload"></i></button>
                </div>
                <div class="user-details">
                    <div class="user-name">
                        <h1>Saman Gunawardhana</h1>
                    </div>
                    <div>
                        <div class ="user-details-item"><h3>E-mail - samangunawardhana@gmail.com</h3></div>
                        <div class ="user-details-item"><h3>Mobile Number - 072 - 422 3123</h3></div>
                        <div class ="user-details-item"><h3>Address - No. 570 / A 54,Melder Place,Nugegoda.</h3></div>
                        <div class ="user-details-item"><h3>Date of birth - 05 September 1988</h3></div>
                        <div><button class= "more-button" id="update-details-button">Update Details</button></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- more action section -->
        <div>
            <div class="more-action-title"><h1>More actions</h1></div>
            <div class="more-action-box">
                <div class="change-password-text"><h3>Do you want to change password?</h3></div>
                <div><button class="more-button" id="change-password-button">Change Password</button></div>
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
</body>