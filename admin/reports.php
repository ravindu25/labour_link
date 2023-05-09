<?php
    require_once('../db.php');
    session_start();
    //if not logged in redirect to login page
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
        header("Location: admin-login.php");
    }
    $sql_get_ongoing_bookings = "SELECT COUNT(Booking_ID) AS BookingCount, Status AS Status FROM Booking WHERE Status = 'Pending' || Status = 'Accepted'";
    $result = $conn->query($sql_get_ongoing_bookings);
    $resultBookingsCount = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $resultBookingsCount = $row['BookingCount'];
        }
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
    <link href="../styles/dashboard.css" rel="stylesheet"/>
    <link href="../styles/admin/reports.css" rel="stylesheet"/>
    <title>Reports | Admin Dashboard</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="error-message-container" id="error-message-container">
    <div class="error-message-heading">
        <h1>Sorry, an unexpected error has occurred. Please try again later or contact customer support for assistance</h1>
    </div>
    <div class="error-message-image">
        <img src="../assets/error-image.png" alt="error-image" />
    </div>
</div>
<div class="backdrop-modal" id="admin-backdrop-modal">
</div>
<div class="backdrop-modal" id="backdrop-modal"></div>
<div class="error-message-container" id="error-message-container">
    <div class="error-message-heading">
        <h1>Sorry, an unexpected error has occurred. Please try again later or contact customer support for assistance</h1>
    </div>
    <div class="error-message-image">
        <img src="../assets/error-image.png" alt="error-image" />
    </div>
</div>
<div class="pdf-generate-modal" id="pdf-generate-modal">
    <iframe id="pdf" style="width: 100%; height: 100%;"></iframe>
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
            <a href="./users.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-user-check sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Users</h4>
                </div>
            </a>
            <a href="./reports.php">
                <div class="sidebar-item  sidebar-item-selected">
                    <i class="fa-regular fa-newspaper sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Reports</h4>
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
        <div class="loader-container" id="loader-container">
            <svg id="spinner" class="spinner" width="50%" height="50%" viewBox="0 0 50 50">
                <circle class="path" cx="25" cy="25" r="20" fill="#ABC3EF" stroke-width="5"></circle>
            </svg>
        </div>
        <div class="main-content-container" id="main-content-container">
            <div class="main-heading">
                <h1>Control panel for generating <u>Reports</u></h1>
                <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
            </div>
            <div id="report-section">
                <div class="booking-reports">
                    <h1>Booking section</h1>
                    <div class="type-based-bookings" id="type-based-bookings">
                        <div class="popular-booking-types-graph">
                            <h1>Popularity of booking type</h1>
                            <canvas id="popular-booking-types"></canvas>
                        </div>
                        <div class="monthly-booking-types-graph">
                            <h1>Recent booking count based on worker types</h1>
                            <canvas id="monthly-booking-types"></canvas>
                        </div>
                    </div>
                    <div class="overall-bookings">
                        <div class="total-booking-details-graph">
                            <h1>Total bookings every month</h1>
                            <canvas id="total-bookings"></canvas>
                        </div>
                        <div class="ongoing-bookings-graph">
                            <h1>Ongoing bookings : <b><?php echo $resultBookingsCount ?></b></h1>
                            <canvas id ="ongoing-bookings"></canvas>
                        </div>
                    </div>
                </div>
                <div class="user-reports">
                    <h1>User section</h1>
                    <div class="user-reports-graphs">
                        <div class="classification-of-users-graph">
                            <h1>Classification of Users in the system</h1>
                            <canvas id = "classification-of-users"></canvas>
                        </div>
                        <div class="monthly-user-registration-graph">
                            <h1>Monthly registration of users</h1>
                            <canvas id = "monthly-user-registration"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pdf-generate-section">
                <div class="pdf-generate-content">
                    <img src="../assets/admin/undraw_printing_invoices_-5-r4r.svg" alt="printing-image" />
                </div>
                <div class="pdf-generate-header">
                    <h1>Obtain a pdf version of the report</h1>
                    <button type="button" class="primary-button" onclick="generatePDF()"><i class="fa-solid fa-print"></i>&nbsp;&nbsp;Generate PDF</button>
                </div>
            </div>
        </div>
        <?php
        echo '<script src="../scripts/admin/loader.js" type="text/javascript"></script>';
        echo '<script>closeLoader()</script>';
        ?>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/admin/reports.js" type="text/javascript"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="../scripts/admin/report-pdf.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>