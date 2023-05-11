<?php
    session_start();
    // Check whether worker is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
        header("Location: ../login.php");
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
    <link href="../styles/worker/worker-bookings.css" rel="stylesheet"/>
    <title>Bookings | LabourLink</title>
</head>
<body>
    <div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="message-backdrop" id="message-backdrop">
</div>
<div class="error-message-container" id="error-message-container">
    <div class="error-message-heading">
        <h1>Sorry, an unexpected error has occurred. Please try again later or contact customer support for assistance</h1>
    </div>
    <div class="error-message-image">
        <img src="../assets/error-image.png" alt="error-image" />
    </div>
</div>
<div class="success-message-container" id="booking-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Booking created successfully</h1>
</div>
<div class="failed-message-container" id="booking-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Booking created successfully</h1>
        <h5>Your login session outdated. Please login again.</h5>
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
                    <h4>Job type</h4>
                    <h4 class="details-value" id="booking-details-job-type"></h4>
                </div>
                <div class="details-row">
                    <h4>Customer</h4>
                    <h4 class="details-value" id="booking-details-customer-name"></h4>
                </div>
                <div class="details-row">
                    <h4>Contact Number</h4>
                    <h4 class="details-value" id="booking-details-contact-number"></h4>
                </div>
                <div class="details-row">
                    <h4>Address</h4>
                    <h4 class="details-value" id="booking-details-customer-address"></h4>
                </div>
                <div class="details-row">
                    <h4>Start date</h4>
                    <h4 class="details-value" id="booking-details-start-date"></h4>
                </div>
                <div class="remaining-time-container" id="remaining-time-container">
                    <h4>This booking will be closed in</h4>
                    <h1 class="countdown-text" id="booking-details-countdown"></h1>
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
                        <h2 id="payment-details-amount-text">Rs. 17500.00</h2>
                    </div>
                </div>
                <div class="back-button-container" id="back-button-container">
                    <button type="button" class="primary-outline-button" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="success-message-container" id="booking-reject-success">
        <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Booking rejected!</h1>
    </div>
    <div class="failed-message-container" id="booking-reject-fail">
        <div class="message-text">
            <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Booking rejection process failed!</h1>
            <h5>Your login session outdated. Please login again.</h5>
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
            <h1>All About Your <u>Bookings</u> Here!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <!--Recent bookings section-->
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recent Bookings</h1>
            </div>
            <div class="recent-bookings-container">
            <?php
                require_once '../db.php';

                // $sql = "SELECT First_Name,Last_Name ,Start_Date , Completion_Flag FROM user INNER JOIN booking ON user.User_ID = booking.Customer_ID INNER JOIN confirmed_booking ON booking.Booking_ID = confirmed_booking.Booking_ID";

                $sql_get_status = "SELECT Booking.*, First_Name,Last_Name ,Start_Date, Worker_Type, Created_Date ,Status FROM User INNER JOIN Booking ON User.User_ID = Booking.Customer_ID WHERE Booking.Worker_ID={$_SESSION['user_id']} ORDER BY Created_Date DESC LIMIT 5";


                $result = $conn->query($sql_get_status);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookingId = $row['Booking_ID'];
                    

                        $status = $row['Status'];

                            $button = '<button class="pending-button">Pending</button>';

                            if($status === 'Pending'){
                                $button = '<button class="pending-button">Pending</button>';
                            } else if($status === 'Accepted'){
                                $button = '<button class="in-pogress-button">Accepted</button>';
                            } else if($status === 'Completed'){
                                $button = '<button class="completed-button">Completed</button>';
                            } else {
                                $button = '<button class="rejected-button">Rejected</button>';
                            }
                        echo('
                        <div class="booking-card" onclick="openBookingDetailsModal('.$bookingId.')">
                            <div class="card-text">
                                <h3>'.$row['Worker_Type'].'</h3>
                                <p>Customer</p>
                                <h4>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</h4>
                            </div>
                            <div class="booking-card-button-row">
                                <div class="badge-container">
                                    <div class="blue-badge">' . date("d M Y", strtotime($row['Start_Date'])) . '</div> 
                                </div>
                                <div id="booking-card-status-'.$bookingId.'">
                                '. $button .'
                                </div>
                            </div>
                        </div>
                
                    ');
                    }
                }
                ?>
                </div>
            </div>
        </div>

        <!--Booking search container-->
        <div class="booking-search">
            <div class="booking-search-title">
                <h1>Search Pending for Request bookings</h1>
                <form action="" method="POST">
                    <div class="booking-search-input-container">
                        <label for="booking-search">Search (Customer name etc)</label>
                        <div class="booking-search-input-field">
                            <input type="text" id="booking-search" class="booking-search-input" name="users-search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
    </div>

        <!--Booking search container-->
        <div class="booking-search">
            <div class="booking-search-title">
                <h1>Search for All bookings</h1>
                <form action="" method="POST">
                    <div class="booking-search-input-container">
                        <label for="booking-search">Search (Customer name etc)</label>
                        <div class="booking-search-input-field">
                            <input type="text" id="booking-search" class="booking-search-input" name="users-search"/>
                            <button type="button" class="search-icon-small" id="booking-search-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
                <button class="pagination-button" id="previous_page" onclick="previousPage()"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="pagination-button" id="previous_page_number" disabled><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button-current" id="current_page_number"><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button" id="next_page_number" disabled><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button" id="next_page" onclick="nextPage()"><i class="fa-solid fa-arrow-right"></i></button>
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
<?php
echo "<script>
        let userId = $userId;
    </script>"
?>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/worker/bookings.js" type="text/javascript"></script>
</body>