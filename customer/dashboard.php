<?php
    session_start();
    // Check whether customer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Customer') {
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
    <link href="../styles/customer/customer-dashboard.css" rel="stylesheet"/>
    <title>Customer Dashboard | LabourLink</title>
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
                <h4>Worker</h4>
                <h4 class="details-value" id="booking-details-worker-name"></h4>
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
                <div class="payment-details-container">
                    <h3>Amount that needs to be paid</h3>
                    <h2>Rs. 17500.00</h2>
                </div>
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
            <h1>Welcome
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
                <h1>Recently made Bookings</h1>
                <button class="more-button" onclick="window.location.href='bookings.php'">More Bookings</button>
            </div>
            <div class="recent-bookings-container">
                <?php
                    require_once('../db.php');

                    // Getting customer id from the session
                    $customer_id = $customer_id = $_SESSION['user_id'];
                    $sql_get_bookings = "select Booking.*, User.First_Name, User.Last_Name from Booking inner join User on Booking.Worker_ID = User.User_ID where Booking.Customer_ID = $customer_id ORDER BY Booking.Created_Date DESC LIMIT 5";


                    $result = $conn->query($sql_get_bookings);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $bookingId = $row['Booking_ID'];
                            $worker_type = $row['Worker_Type'];
                            $worker_name = $row['First_Name'] . " " . $row['Last_Name'];
                            $start_date = date("d M Y", strtotime($row['Start_Date']));
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


                            echo "
                                <div class='booking-card' onclick='openBookingDetailsModal($bookingId)'>
                                    <div class='card-text'>
                                        <h3>$worker_type</h3>
                                        <p>Work by</p>
                                        <h4>$worker_name</h4>
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
                ?>
            </div>
        </div>
        <!--Upgrade to premum banner-->
        <div class="upgrade-banner">
            <div class="upgrade-icon">
                <i class="fa-solid fa-angles-up"></i>
            </div>
            <div class="upgrade-caption">
                <h3>Upgrade to Premium for exclusive benefits</h3>
                <p>From housing packages to discounted services and much more!</p>
            </div>
            <button class="upgrade-button">Upgrade Now</button>
        </div>
        <!--Recent feedbacks section-->
        <div class="recent-feedbacks">
            <div class="recent-feedbacks-title">
                <h1>Recently made Feedbacks</h1>
                <button class="more-button">More Feedbacks</button>
            </div>
            <div class="recent-feedbacks-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Comment</th>
                        <th class="main-th">Worker name</th>
                        <th class="main-th">Date</th>
                        <th class="main-th">Service</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Extremely satisfied with the work done
                            <br/>
                            <span class="blue-badge">Updated 15 days ago</span>
                        </td>
                        <td class="main-td">Saman Gunawardhana</td>
                        <td class="main-td">21 Oct 2022</td>
                        <td class="main-td">Plumbing</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Process was neatly done on time
                            <br/>
                            <span class="blue-badge">Updated 20 days ago</span>
                        </td>
                        <td class="main-td">Kapila Gunawardana</td>
                        <td class="main-td">16 Oct 2022</td>
                        <td class="main-td">Gardening</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Work not completed on time. Slighlty
                            dissappointing
                            <br/>
                            <span class="blue-badge">Updated 27 days ago</span>
                        </td>
                        <td class="main-td">Saman Gunathilaka</td>
                        <td class="main-td">09 Oct 2022</td>
                        <td class="main-td">Electrical</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Payment not going through
                            <br/>
                            <span class="blue-badge">Updated 1 month ago</span>
                        </td>
                        <td class="main-td">Kapila Dharmadhasa</td>
                        <td class="main-td">05 Oct 2022</td>
                        <td class="main-td">Mason</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Housings and payments section-->
        <div class="housing-payments">
            <div class="housing-dash-content">
                <h1>Housing</h1>
                <div class="housing-card">
                    <h4>Housing package details</h4>
                    <h3>Bambalapitiya Colombo</h3>
                    <span class="blue-badge">Started date - 21 Nov 2022</span>
                    <div class="housing-job-list">
                        <div class="housing-job-item">
                            <div class="job-item-text">
                                <h4>Plumbing</h4>
                                <h3>Saman Gunawardhana</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="in-pogress-button">In-progress</button>
                            </div>
                        </div>
                        <div class="housing-job-item">
                            <div class="job-item-text">
                                <h4>Electrician</h4>
                                <h3>Sunil Perera</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="in-pogress-button">In-progress</button>
                            </div>
                        </div>
                        <div class="housing-job-item">
                            <div class="job-item-text">
                                <h4>Painting</h4>
                                <h3>Sunith Hettiarachchi</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="pending-button">Pending</button>
                            </div>
                        </div>
                        <div class="housing-job-item">
                            <div class="job-item-text">
                                <h4>Mechanical</h4>
                                <h3>Dammika Kumara</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="completed-button">Completed</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="payments-dash-content">
                <h1>Payments</h1>
                <div class="payments-list">
                    <?php

                        require_once "../db.php";
                        $sql = "SELECT * FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_id = Booking.Booking_id INNER JOIN User ON Booking.Worker_ID = User.User_ID WHERE Booking.Customer_ID = '$userId'";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)){
                            if($row['Success_Flag'] == 2){
                                echo(' <div class="payment-item">
                            <div class="payment-text">
                                <span class="blue-badge">21 Oct 2022</span>
                                <h3>'.$row['First_Name']." ".$row['Last_Name'].'</h3>
                            </div>
                            <div class="payment-button">
                                <button type="button" class="payment-amount-button">'."Rs. ".$row['Amount'].".00".'</button>
                            </div>
                        </div>
                       ');
                            }else{
                                echo(' <div class="payment-item-failed">
                            <div class="payment-text">
                                <span class="blue-badge">21 Oct 2022</span>
                                <h3>'.$row['First_Name']." ".$row['Last_Name'].'</h3>
                            </div>
                            <div class="payment-button">
                                <button type="button" class="payment-amount-button-failed">'."Rs. ".$row['Amount'].".00".'</button>
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
<?php
    echo "<script>
        let userId = $userId;
    </script>"
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/dashboard.js" type="text/javascript"></script>
</body>