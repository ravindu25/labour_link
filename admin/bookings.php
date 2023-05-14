<?php
session_start();
//if not logged in redirect to login page
if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Admin') {
    header("Location: admin-login.php");
}
$userId = $_SESSION['user_id'];
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
    <link href="../styles/admin/bookings.css" rel="stylesheet"/>
    <title>Bookings | Admin Dashboard</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="backdrop-modal" id="admin-backdrop-modal">
</div>
<div class="error-message-container" id="error-message-container">
    <div class="error-message-heading">
        <h1>Sorry, an unexpected error has occurred. Please try again later or contact customer support for assistance</h1>
    </div>
    <div class="error-message-image">
        <img src="../assets/error-image.png" alt="error-image" />
    </div>
</div>
<div class="booking-details-container" id="booking-details-container">
    <div class="booking-details-scroll-wrapper">
        <div class="booking-details-title">
            <h1>Current Status of Your <u>Booking</u></h1>
        </div>
        <div class="status-container" id="booking-details-status-container"></div>
        <div class="details-container">
            <div class="details-row">
                <h4>Customer name</h4>
                <h4 class="details-value" id="booking-details-customer-name"></h4>
            </div>
            <div class="details-row">
                <h4>Job type</h4>
                <h4 class="details-value" id="booking-details-job-type"></h4>
            </div>
            <div class="details-row">
                <h4>Worker name</h4>
                <h4 class="details-value" id="booking-details-worker-name"></h4>
            </div>
            <div class="details-row">
                <h4>Start date</h4>
                <h4 class="details-value" id="booking-details-start-date"></h4>
            </div>
            <div class="payment-method-container">
                <div class="payment-image-container">
                    <h4>Payment Method</h4>
                    <div class="payment-image-card">
                        <img class="payment-image" id="payment-image" src="../assets/customer/dashboard/undraw_credit_card_re_blml.svg"
                             alt="payment method"/>
                        <h4 id="payment-method-text">Online payments</h4>
                    </div>
                </div>
                <div class="payment-details-container" id="payment-details-container">
                    <h3>Amount that needs to be paid</h3>
                    <h2>Rs. 17500.00</h2>
                </div>
            </div>
            <div class="back-button-container" id="back-button-container">
                <button type="button" class="primary-button" onclick="closeBookingDetailsModal()" id="back-button">Back</button>
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
                <div class="sidebar-item sidebar-item-selected">
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
                <h1>Control panel for managing <u>Bookings</u></h1>
                <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
            </div>
            <div class="recent-bookings">
                <h1>Bookings trends</h1>
            </div>
            <div class="recent-bookings-charts-container">
                <div class="recent-booking-chart-container">
                    <h3>Number of bookings(current month)</h3>
                    <canvas id="chart-all-bookings"></canvas>
                </div>
                <div class="recent-booking-chart-container">
                    <h3>Number of online mode bookings</h3>
                    <canvas id="chart-online-bookings"></canvas>
                </div>
            </div>
            <div class="recent-bookings">
                <div class="recent-bookings-title">
                    <h1>Recently made Bookings</h1>
                </div>
                <div class="recent-bookings-container">
                    <?php
                        require_once('../db.php');

                        // Getting customer id from the session
                        $customer_id = $customer_id = $_SESSION['user_id'];
                        $sql_get_bookings = "select Booking.*, User.First_Name, User.Last_Name from Booking inner join User on Booking.Worker_ID = User.User_ID ORDER BY Booking.Created_Date DESC LIMIT 5";


                        $result = $conn->query($sql_get_bookings);

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $booking_id = $row['Booking_ID'];
                                $worker_type = $row['Worker_Type'];
                                $worker_name = $row['First_Name'] . " " . $row['Last_Name'];
                                $start_date = date("d M Y", strtotime($row['Start_Date']));
                                $statusValue = $row['Status'];
                                $sql_get_customer_name = "SELECT * from User where User_ID = {$row['Customer_ID']}";
                                $result_customer_name = $conn->query($sql_get_customer_name);
                                $row_customer_name = $result_customer_name->fetch_assoc();
                                $customer_name = $row_customer_name['First_Name'] . " " . $row_customer_name['Last_Name'];


                                $button = '';
                                switch($statusValue){
                                    case 'Pending':
                                        $button = '<button class="pending-button">Pending</button>';
                                        break;
                                    case 'Completed':
                                        $button = '<button class="completed-button">Completed</button>';
                                        break;
                                    case 'Rejected-by-worker':
                                        $button = '<button class="rejected-button">Rejected by worker</button>';
                                        break;
                                    case 'Rejected-by-customer':
                                        $button = '<button class="rejected-button">Rejected by customer</button>';
                                        break;
                                    case 'Accepted-by-worker':
                                        $button = '<button class="in-pogress-button">Accepted by worker</button>';
                                        break;
                                    case 'Accepted-by-customer':
                                        $button = '<button class="in-pogress-button">Accepted by customer</button>';
                                        break;
                                }

                                echo "
                                <div class='booking-card' onclick='showBookingDetails($booking_id)'>
                                    <div class='card-text'>
                                        <h3>$worker_type</h3>
                                        <p>Work by</p>
                                        <h4>$worker_name</h4>
                                        <p>Customer</p>
                                        <h4>$customer_name</h4>
                                    </div>
                                    <div class='booking-card-button-row'>
                                        <div class='badge-container'>
                                            <div class='blue-badge'>$start_date</div>
                                        </div>
                                        $button
                                    </div>
                                </div>";
                            }
                        }
                        else {
                            echo "<h3 class='empty-bookings-heading'>No bookings made yet!</h3>";
                        }
                    ?>

                </div>
            </div>
            <!--Booking search container-->
            <div class="booking-search">
                <div class="booking-search-title">
                    <h1>Search for All bookings</h1>
                    <?php
                        $sql_get_booking_count = "SELECT COUNT(Booking_ID) AS Booking_Count FROM Booking";

                        $bookingCount = 0;
                        $result = $conn->query($sql_get_booking_count);

                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $bookingCount = $row['Booking_Count'];
                            }
                        }

                        if($bookingCount > 0){
                            ?>
                            <form action="" method="POST">
                                <div class="booking-search-input-container">
                                    <label for="booking-search">Search (Customer name etc)</label>
                                    <div class="booking-search-input-field">
                                        <input type="text" id="booking-search" class="booking-search-input" name="users-search"/>
                                        <button type="button" class="search-icon-small" id="booking-search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                </div>
            </div>
            <?php if($bookingCount > 0) { ?>
                <div class="recent-payments-container">
                    <table class="main-table">
                        <thead>
                        <tr class="main-tr">
                            <th class="main-th">
                                <div class="table-heading-container">Customer name&nbsp;<button class="sort-button" id="customer-name-sort"><i
                                                class="fa-solid fa-arrow-up"></i></button>
                                </div>
                            </th>
                            <th class="main-th">
                                <div class="table-heading-container">Worker name&nbsp;<button class="sort-button" id="worker-name-sort"><i
                                                class="fa-solid fa-arrow-up"></i></button>
                                </div>
                            </th>
                            <th class="main-th">
                                <div class="table-heading-container">Start date&nbsp;<button class="sort-button" id="start-date-sort"><i
                                                class="fa-solid fa-arrow-up"></i></button>
                            </th>
                            <th class="main-th">
                                <div class="table-heading-container">End date&nbsp;<button class="sort-button" id="end-date-sort"><i
                                                class="fa-solid fa-arrow-up"></i></button>
                            </th>
                            <th class="main-th">More actions</th>
                        </tr>
                        </thead>
                        <tbody id="bookings-table-body">
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        <button class="pagination-button" id="previous-page" onclick="previousPage()"><i class="fa-solid fa-arrow-left"></i></button>
                        <button class="pagination-button" id="previous-page-number" disabled><i class="fa-solid fa-1"></i></button>
                        <button class="pagination-button-current" id="current-page-number"><i class="fa-solid fa-1"></i></button>
                        <button class="pagination-button" id="next-page-number" disabled><i class="fa-solid fa-1"></i></button>
                        <button class="pagination-button" id="next-page" onclick="nextPage()"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            <?php } else { ?>
                <div class="empty-all-bookings-container">
                    <img src="../assets/worker/bookings/undraw_Domain_names_re_0uun.png" alt="no bookings" />
                    <h3>There are no bookings at the moment!</h3>
                </div>
            <?php } ?>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/admin/bookings/bookings.js" type="text/javascript"></script>
<script src="../scripts/admin/bookings/bookings-charts.js" type="text/javascript"></script>
</body>