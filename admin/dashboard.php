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
    <link href="../styles/admin/admin-dashboard.css" rel="stylesheet"/>
    <title>Admin Dashboard | LabourLink</title>
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
<div class="feedback-details-container" id="feedback-details-container">
    <div class="feedback-details-header">
        <h1>All the details about the feedback</h1>
    </div>
    <div class="feedback-details-content">
        <div class="feedback-details-profile-details">
            <div class="feedback-details-profile-container">
                <h3 class="worker-details-heading">Worker details</h3>
                <img src='../assets/worker/profile-images/worker-1.jpg' id="feedback-details-worker-image" alt='worker-profile' />
                <a href="#" id="feedback-details-worker-details-link" style="cursor: pointer">
                    <h1 id="feedback-details-worker-name">Chaminda Gunathilaka&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i></h1>
                </a>
                <span class="blue-badge" id="feedback-details-booking-date">Feedback created date 2023-04-25</span>
            </div>
        </div>
        <div class="feedback-details-rating-observations">
            <div class="feedback-details-rating-container">
                <div id="feedback-details-rating-header" class="feedback-details-rating-header">
                    <h1>Worker rating</h1>
                </div>
                <div class="feedback-details-rating-content">
                    <div class="feedback-details-rating-item">
                        <div class="feedback-details-rating-item-header">
                            <h3>Punctuality</h3>
                            <h3 id="feedback-details-progress-bar-punctuality-text" style="color: #A6A6A6">3 out of 5</h3>
                        </div>
                        <div class="recent-feedback-rating-bar">
                            <div class='recent-feedback-rating-bar-progress' id="feedback-details-progress-bar-punctuality" style='width: calc(50%)'></div>
                        </div>
                    </div>
                    <div class="feedback-details-rating-item">
                        <div class="feedback-details-rating-item-header">
                            <h3>Efficiency</h3>
                            <h3 id="feedback-details-progress-bar-efficiency-text" style="color: #A6A6A6">3 out of 5</h3>
                        </div>
                        <div class="recent-feedback-rating-bar">
                            <div class='recent-feedback-rating-bar-progress' id="feedback-details-progress-bar-efficiency" style='width: calc(50%)'></div>
                        </div>
                    </div>
                    <div class="feedback-details-rating-item">
                        <div class="feedback-details-rating-item-header">
                            <h3>Professionalism</h3>
                            <h3 id="feedback-details-progress-bar-professionalism-text" style="color: #A6A6A6">3 out of 5</h3>
                        </div>
                        <div class="recent-feedback-rating-bar">
                            <div class='recent-feedback-rating-bar-progress' id="feedback-details-progress-bar-professionalism" style='width: calc(50%)'></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="feedback-details-observations-container">
                <div class="feedback-details-observations-header">
                    <h1 id="feedback-details-observations-header">Extra observations</h1>
                </div>
                <div class="feedback-details-extra-observations" id="feedback-details-extra-observations">
                </div>
            </div>
        </div>
    </div>
    <div class="feedback-details-comment-container" id="feedback-details-comment-container">
        <div class="feedback-details-comment-header" id="feedback-details-comment-header">
            <h1 id="feedback-details-comment-heading">Written feedback</h1>
        </div>
        <p id="feedback-details-comment-text"></p>
    </div>
    <div class="feedback-details-button-container">
        <button class="primary-outline-button" onclick="hideFeedbackDetails()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        <button class="primary-button" id="feedback-details-booking-button"><i class="fa-solid fa-arrow-turn-up"></i>&nbsp;&nbsp;View booking</button>
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
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recently made Bookings</h1>
                <a href="./bookings.php"><button class="primary-button">More Bookings</button></a>
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
        <div class="recent-feedbacks">
            <div class="recent-feedbacks-title">
                <h1>Recently made Feedbacks</h1>
                <a href="./feedbacks.php"><button class="primary-button">More Feedbacks</button></a>
            </div>
            <div class="recent-feedbacks-container">
                <?php
                    require_once('../db.php');

                    $sql_get_most_recent_feedbacks = "SELECT Feedback.*, Booking.*, Worker.First_Name, Worker.Last_Name FROM Feedback INNER JOIN Booking ON Feedback.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID ORDER BY Feedback.Timestamp DESC LIMIT 4";

                    $result = $conn->query($sql_get_most_recent_feedbacks);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $feedbackId = $row['Feedback_Token'];
                            $bookingId = $row['Booking_ID'];
                            $workerName = $row['First_Name'] . ' ' . $row['Last_Name'];
                            $workerId = $row['Worker_ID'];
                            $timestamp = strtotime($row['Timestamp']);
                            $date = date('Y-m-d', $timestamp);

                            $ratingPun = $row['Star_Punctuality'];
                            $ratingPunProgress = $ratingPun * 20;
                            $ratingEfficiency = $row['Star_Efficiency'];
                            $ratingEfficiencyProgress = $ratingEfficiency * 20;
                            $ratingProf = $row['Star_Professionalism'];
                            $ratingProfProgress = $ratingProf * 20;

                            $writtenFeedback = '';
                            if($row['Written_Feedback'] != ''){
                                $writtenFeedback = "<p><i>\"$writtenFeedback\"</i></p>";
                            }


                            /*
                             * Generating random worker image
                             */
                            $imageId = rand(1, 4) % 5;

                            echo "
                            <div class='recent-feedback-item' onclick='showFeedbackDetails($feedbackId)'>
                                <div class='recent-feedback-item-heading'>
                                    <div class='recent-feedback-image-container'>
                                        <img src='../assets/worker/profile-images/worker-$imageId.jpg' alt='worker-profile' />
                                    </div>
                                    <div class='recent-feedback-profile-details'>                    
                                        <h3>$workerName</h3>
                                        <span class='blue-badge'>$date</span>
                                    </div>
                                </div>
                                <div class='recent-feedback-ratings'>
                                    <div class='recent-feedback-rating-item'>
                                        <div class='recent-feedback-rating-header'>
                                            <h3>Punctuality</h3>
                                            <h3>$ratingPun out of 5</h3>
                                        </div>
                                        <div class='recent-feedback-rating-bar'>
                                            <div class='recent-feedback-rating-bar-progress' style='width: calc($ratingPunProgress%)'></div>
                                        </div>
                                    </div>
                                    <div class='recent-feedback-rating-item'>
                                        <div class='recent-feedback-rating-header'>
                                            <h3>Efficiency</h3>
                                            <h3>$ratingEfficiency out of 5</h3>
                                        </div>
                                        <div class='recent-feedback-rating-bar'>
                                            <div class='recent-feedback-rating-bar-progress' style='width: calc($ratingEfficiencyProgress%)'></div>
                                        </div>
                                    </div>
                                    <div class='recent-feedback-rating-item'>
                                        <div class='recent-feedback-rating-header'>
                                            <h3>Professionalism</h3>
                                            <h3>$ratingProf out of 5</h3>
                                        </div>
                                        <div class='recent-feedback-rating-bar'>
                                            <div class='recent-feedback-rating-bar-progress' style='width: calc($ratingProfProgress%)'></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ";
                        }
                    }
                ?>
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
                        $sql = "SELECT Payments_Log.*, Booking.Booking_ID, Customer.First_Name AS CustomerFirstname, Customer.Last_Name AS CustomerLastname, Worker.First_Name AS WorkerFirstname, Worker.Last_Name AS WorkerLastname FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID INNER JOIN User AS Customer ON Booking.Customer_ID = Customer.User_ID ORDER BY Timestamp DESC LIMIT 4";
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
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/admin/dashboard.js" type="text/javascript"></script>
</body>

