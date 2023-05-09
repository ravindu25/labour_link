<?php
session_start();
//if not logged in redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
    header("Location: admin-login.php");
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
    <link href="../styles/admin/housing.css" rel="stylesheet"/>
    <title>Housing | Admin Dashboard</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="backdrop-modal" id="admin-backdrop-modal">
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
            <a href="./users.php">
                <div class="sidebar-item">
                    <i class="fa-solid fa-user-check sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Users</h4>
                </div>
            </a>
            <a href="./reports.php">
                <div class="sidebar-item">
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
                <h1>Control panel for managing <u>Housing Projects</u></h1>
                <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
            </div>
        </div>
        <?php
        echo '<script src="../scripts/admin/loader.js" type="text/javascript"></script>';
        echo '<script>closeLoader()</script>';
        ?>
        <div class="recent-housing">
            <div class="recent-housing-title">
                <h1>Recent Housing Jobs</h1>
            </div>
            <div class="recent-housing-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Address - Start Date</th>
                        <th class="main-th">Customer name</th>
                        <th class="main-th">Worker name</th>
                        <th class="main-th">Service</th>
                        <th class="main-th">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohamed</td>
                        <td class="main-td">Dhananga</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohamed</td>
                        <td class="main-td">Dhananga</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohamed</td>
                        <td class="main-td">Dhananga</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Bambalapitiya Colombo
                            <br />
                            <span class="blue-badge">20 Nov 2022</span>
                        </td>
                        <td class="main-td">Mohamed</td>
                        <td class="main-td">Dhananga</td>
                        <td class="main-td">Electrical</td>
                        <td class="main-td">Pending</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/admin/payments.js" type="text/javascript"></script>
</body>

