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
    <link href="../styles/worker/worker-housing.css" rel="stylesheet"/>
    <title>Labourer Dashboard | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="housing-job-details-container" id="housing-job-details-container">
    <div class="housing-job-details-scroll-wrapper">
        <div class="housing-job-details-title">
            <h1>More Information about Housing Job in Moratuwa</h1>
        </div>
        <div class="details-container">
            <div class="details-row">
                <h4>Job type</h4>
                <h4 class="details-value">Plumber</h4>
            </div>
            <div class="details-row">
                <h4>Customer</h4>
                <h4 class="details-value">Ravindu Wegiriya</h4>
            </div>
            <div class="details-row">
                <h4>Address</h4>
                <h4 class="details-value">No. 26/2,Moratuwa.</h4>
            </div>
            <div class="details-row">
                <h4>Contact Number</h4>
                <h4 class="details-value">071 2637160</h4>
            </div>
            <div class="details-row">
                <h4>Start date</h4>
                <h4 class="details-value">21-Nov-2022</h4>
            </div>
            <div class="back-button-container">
                <button type="button" class="more-button" id="back-button">Back</button>
            </div>
        </div>
    </div>
</div>
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
            <a href="./housing.php">
                <div class="sidebar-item sidebar-item-selected">
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
        <div class="housing-job-card">
            <div class="housing-job-title">
                <h1>Available Housing Jobs For Paintings</h1>
            </div>
            <div class="job-cards-container">
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Mohomad Izzath</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Negambo</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="housing-job-title">
                <h1>Available Housing Jobs For Paintings</h1>
            </div>
            <div class="job-cards-container">
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="housing-job-card-container">
                <div class="housing-card">
                    <div class="card-text">
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
                    </div>
                    <div class="housing-job-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">Moratuwa</div> 
                        </div>
                    </div>
                </div>
            </div>
            <div>
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