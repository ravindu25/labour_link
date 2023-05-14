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
                <h1>Currently ongoing bookings</h1>
                <a href="./bookings.php">
                    <button class="primary-button">More Bookings</button>
                </a>
            </div>
            <div class="recent-bookings-container">
                <?php
                    require_once '../db.php';

                    $sql_get_status = "SELECT Booking.*, First_Name, Last_Name,Start_Date, Worker_Type, Created_Date ,Status FROM User INNER JOIN Booking ON User.User_ID = Booking.Customer_ID WHERE Booking.Worker_ID={$_SESSION['user_id']} AND Booking.Status IN ('Pending', 'Accepted-by-customer', 'Accepted-by-worker') ORDER BY Created_Date DESC";


                    $result = $conn->query($sql_get_status);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $bookingId = $row['Booking_ID'];


                            $status = $row['Status'];

                            $button = '<button class="pending-button">Pending</button>';

                            if($status === 'Pending'){
                                $button = '<button class="pending-button">Pending</button>';
                            } else if($status === 'Accepted-by-worker'){
                                $button = '<button class="in-pogress-button">Accepted by worker</button>';
                            }else if($status === 'Accepted-by-customer'){
                                $button = '<button class="in-pogress-button">Accepted by customer</button>';
                            }else if($status === 'Completed'){
                                $button = '<button class="completed-button">Completed</button>';
                            } else if($status === 'Rejected-by-worker') {
                                $button = '<button class="rejected-button">Rejected by worker</button>';
                            } else if($status === 'Rejected-by-customer'){
                                $button = '<button class="rejected-button">Rejected by customer</button>';
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
                    } else {
                        echo "
                    <div class='empty-ongoing-booking-container'>
                        <img src='../assets/worker/bookings/undraw_Booking_re_gw4j.png' alt='no ongoing bookings' />
                        <h3>There are no bookings currently ongoing!</h3>
                    </div>
                   ";
                    }
                ?>
            </div>
        </div>
        </div>
        <div class="recent-payments">
            <div class="recent-payments-title">
                <h1>Recently made Payments</h1>
                <a href="./payments.php">
                    <button class="primary-button">More Payments</button>
                </a>
            </div>
            <div class="recent-payments-container">
                <?php
                    require_once "../db.php";
                    $sql = "SELECT Payments_Log.*, Booking.Booking_ID, Customer.First_Name AS CustomerFirstname, Customer.Last_Name AS CustomerLastname, Worker.First_Name AS WorkerFirstname, Worker.Last_Name AS WorkerLastname FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID INNER JOIN User AS Customer ON Booking.Customer_ID = Customer.User_ID WHERE Booking.Worker_ID = {$_SESSION['user_id']} ORDER BY Timestamp DESC LIMIT 4";
                    $result = $conn->query($sql);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $customerName = $row['CustomerFirstname'] . ' ' . $row['CustomerLastname'];
                            $workerName = $row['WorkerFirstname'] . ' ' . $row['WorkerLastname'];

                            $successFlag = $row['Success_Flag'];
                            $paymentId = $row['Payment_Log_ID'];

                            $amount = number_format(floatval($row['Amount']), 2);
                            $paymentDate = explode(' ', $row['Timestamp'])[0];

                            $paymentContainerStyles = '';
                            $paymentAmountContainerStyles = '';

                            if($successFlag > 0) {
                                $paymentContainerStyles = 'success-payment-container';
                                $paymentAmountContainerStyles = 'success-payment-amount-container';
                            } else {
                                $paymentContainerStyles = 'failed-payment-container';
                                $paymentAmountContainerStyles = 'failed-payment-amount-container';
                            }

                            echo "
                                    <div class='$paymentContainerStyles'>
                                        <span class='blue-badge'>$paymentDate</span>
                                        <div class='payment-container-heading'>
                                            <div class='payment-heading-item'>
                                                <h5>Customer name</h5>
                                                <h3>$customerName</h3>
                                            </div>
                                            <div class='payment-heading-item'>
                                                <h5>Worker name</h5>
                                                <h3>$workerName</h3>
                                            </div>
                                        </div>
                                        <div class='$paymentAmountContainerStyles'>
                                            <h1>Rs. $amount</h1>
                                        </div>
                                    </div>
                                ";
                        }
                    }
                ?>
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
    echo "<script>let userId = {$_SESSION['user_id']};</script>";
?>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/worker/dashboard.js" type="text/javascript"></script>
</body>