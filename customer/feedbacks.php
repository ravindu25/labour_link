<?php
    session_start();
    // Check whether customer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Customer') {
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
    <link href="../styles/dashboard.css" rel="stylesheet"/>
    <link href="../styles/customer/customer-feedbacks.css" rel="stylesheet"/>
    <title>Feedbacks | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal"></div>
<div class="error-message-container" id="error-message-container">
    <div class="error-message-heading">
        <h1>Sorry, an unexpected error has occurred. Please try again later or contact customer support for assistance</h1>
    </div>
    <div class="error-message-image">
        <img src="../assets/error-image.png" alt="error-image" />
    </div>
</div>
<div class="create-feedback-container" id="create-feedback-container">
    <div class="create-feedback-page" id="first-page">
        <div class="create-feedback-title">
            <h1>Provide feedback about workers!</h1>
            <h5 style="text-align: center"><b>Please select a booking to continue.</b> This will assist us in delivering enhanced services.</h5>
        </div>
        <div class="feedback-cards-container" id="create-feedback-bookings-container">
            <div class="pagination-card-disabled" id="create-feedback-bookings-previous">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            <div class="feedback-cards-container" id="create-feedback-bookings-cards-container" style="margin-top: 0">
            <?php
                /*
                 * Get the most recent 3 or fewer bookings to select to provide feedback
                 */
                require_once('../db.php');

                $customerId = $_SESSION['user_id'];

                $sql_get_most_recent_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Customer_ID = $customerId AND Booking.Status IN('Completed', 'Rejected') ORDER BY Booking.Created_Date DESC LIMIT 3";

                $result = $conn->query($sql_get_most_recent_bookings);
                $firstBooking = true;
                $firstBookingId = null;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $bookingId = $row['Booking_ID'];
                        $workerName = $row['Worker_First_Name'] . " " . $row['Worker_Last_Name'];
                        $createdDate = $row['Created_Date'];
                        $startDate = $row['Start_Date'];
                        $workerType = $row['Worker_Type'];
                        $status = $row['Status'];

                        $bookingStatusButton = null;
                        if($status === 'Pending'){
                            $bookingStatusButton = '<button class="pending-button">Pending</button>';
                        } else if($status === 'Accepted'){
                            $bookingStatusButton = '<button class="in-pogress-button">Accepted</button>';
                        } else if($status === 'Completed'){
                            $bookingStatusButton = '<button class="completed-button">Completed</button>';
                        } else {
                            $bookingStatusButton = '<button class="rejected-button">Rejected</button>';
                        }

                        if($firstBooking){
                            $divStyling = 'feedback-booking-card feedback-booking-card-selected';
                            $firstBookingId = $bookingId;
                        } else {
                            $divStyling = 'feedback-booking-card';
                        }

                        $firstBooking = false;

                        echo "
                        <div class='$divStyling' onclick='selectBooking($bookingId)' id='booking-card-$bookingId'>
                            <div class='card-text'>
                                <h3>$workerType</h3>
                                <p>Work by</p>
                                <h4>$workerName</h4>
                            </div>
                            <div class='booking-card-button-row'>
                                <div class='badge-container'>
                                    <div class='blue-badge'>$startDate</div>
                                </div>
                                $bookingStatusButton
                            </div>
                        </div>
                        ";
                    }
                }

                $sql_get_bookings = "SELECT COUNT(Booking.Booking_ID) as Booking_Count FROM Booking INNER JOIN User AS Customer on Booking.Customer_ID = Customer.User_ID WHERE Booking.Customer_ID = $customerId AND Booking.Status IN('Completed', 'Rejected')";

                $result = $conn->query($sql_get_bookings);
                $numOfBookings = null;

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $numOfBookings = $row['Booking_Count'];
                    }
                }

                if($numOfBookings > 3) {
                    echo '</div><div class="pagination-card" id="create-feedback-bookings-next" onclick="goToNextBookingPage()">
                            <i class="fa-solid fa-arrow-right"></i>
                    </div>';
                } else {
                    echo '</div><div class="pagination-card-disabled" id="create-feedback-bookings-next">
                            <i class="fa-solid fa-arrow-right"></i>
                    </div>';
                }
            ?>

        </div>
        <div class="create-feedback-button-container">
            <button class="secondary-button" onclick="hideFeedbackContainer()">Cancel</button>
            <button class="primary-button" id="first-page-next-button" onclick=" goToNextFeedbackPage()">Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div class="create-feedback-page-number">
            <h3>Page 1 of 3</h3>
        </div>
    </div>
    <div class="create-feedback-page" id="second-page">
        <div class="create-feedback-title">
            <h1 id="create-feedback-third-title">Feedback about workers!</h1>
            <h5 id="create-feedback-third-paragraph" style="text-align: center"><b>Please provide rating about worker.</b> This will assist us in delivering enhanced services.</h5>
        </div>
        <div class="rating-container">
            <div class="rating-container-row">
                <div class="rating-container-text">
                    <h5>Punctuality</h5>
                    <p>How good the worker is in communicating</p>
                </div>
                <div class="rating-container-rate">
                    <div class="feedback-star-container" id="star-punctuality-1" onclick="updateStarRating('punctuality', 1);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-punctuality-2" onclick="updateStarRating('punctuality', 2);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-punctuality-3" onclick="updateStarRating('punctuality', 3);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-punctuality-4" onclick="updateStarRating('punctuality', 4);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-punctuality-5"  onclick="updateStarRating('punctuality', 5);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="rating-container-row">
                <div class="rating-container-text">
                    <h5>Efficient</h5>
                    <p>How quickly and accurately does the worker complete tasks</p>
                </div>
                <div class="rating-container-rate">
                    <div class="feedback-star-container" id="star-efficient-1" onclick="updateStarRating('efficient', 1);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-efficient-2" onclick="updateStarRating('efficient', 2);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-efficient-3" onclick="updateStarRating('efficient', 3);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-efficient-4" onclick="updateStarRating('efficient', 4);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-efficient-5"  onclick="updateStarRating('efficient', 5);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
            <div class="rating-container-row">
                <div class="rating-container-text">
                    <h5>Professionalism</h5>
                    <p>How polite is the worker when doing the job done</p>
                </div>
                <div class="rating-container-rate">
                    <div class="feedback-star-container" id="star-professionalism-1" onclick="updateStarRating('professionalism', 1);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-professionalism-2" onclick="updateStarRating('professionalism', 2);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-professionalism-3" onclick="updateStarRating('professionalism', 3);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-professionalism-4" onclick="updateStarRating('professionalism', 4);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                    <div class="feedback-star-container" id="star-professionalism-5"  onclick="updateStarRating('professionalism', 5);">
                        <i class="fa-regular fa-star"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="question-container-row">
            <div class="question-container">
                <h5>Did you notice any of the following?</h5>
            </div>
            <div class="question-answer-container">
                <label>
                    <input type="checkbox" name="feedback-answers" value="suspect-drug-using" class="feedback-answer-input" />
                    <div class="feedback-answer-container">
                        <h5>Drug use during work</h5>
                    </div>
                </label>
                <label>
                    <input type="checkbox" name="feedback-answers" value="suspect-mobile-using" class="feedback-answer-input"/>
                    <div class="feedback-answer-container">
                        <h5>Excessive mobile phone usage</h5>
                    </div>
                </label>
                <label>
                    <input type="checkbox" name="feedback-answers" value="charged-more" class="feedback-answer-input"/>
                    <div class="feedback-answer-container">
                        <h5>Charge more than agreed</h5>
                    </div>
                </label>
            </div>
        </div>
        <div class="create-feedback-button-container">
            <button class="primary-button" id="second-page-next-button" onclick="goBackFeedbackFirstPage()"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</button>
            <button class="secondary-button" onclick="hideFeedbackContainer()">Cancel</button>
            <button class="primary-button" id="second-page-next-button" onclick="goNextFeedbackThirdPage()">Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
        </div>
        <div class="create-feedback-page-number">
            <h3>Page 2 of 3</h3>
        </div>
    </div>
    <div class="create-feedback-page" id="third-page">
        <div class="create-feedback-title">
            <h1 id="create-feedback-title">Feedback about workers!</h1>
            <h5 id="create-feedback-paragraph" style="text-align: center"><b>Please provide rating about worker.</b>This will assist us in delivering enhanced services.</h5>
        </div>
        <div class="written-feedback-row">
            <h1>Tell us more about the worker(Optional)</h1>
            <textarea rows="5" id="feedback-textarea" maxlength="1024"></textarea>
        </div>
        <div class="create-feedback-button-container">
            <button class="primary-button" id="second-page-next-button" onclick="goBackFeedbackSecondPage()"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</button>
            <button class="secondary-button" onclick="hideFeedbackContainer()">Cancel</button>
            <button class="primary-button" id="second-page-next-button" onclick="createFeedback()">Submit&nbsp;&nbsp;<i class="fa-solid fa-check"></i></button>
        </div>
        <div class="create-feedback-page-number">
            <h3>Page 3 of 3</h3>
        </div>
    </div>
</div>
</div>
<div class="success-message-container" id="feedback-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Thank you for providing feedback!</h1>
</div>
<div class="failed-message-container" id="feedback-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Error occured when processing the feedback!</h1>
        <h5>Your login session outdated. Please login again.</h5>
    </div>
</div>
<div class="feedback-details-container" id="feedback-details-container">
    <div class="feedback-details-header">
        <h1>All the details about the feedback</h1>
    </div>
    <div class="feedback-details-content">
        <div class="feedback-details-profile-details">
            <div class="feedback-details-profile-container">
                <img src='../assets/worker/profile-images/worker-1.jpg' id="feedback-details-worker-image" alt='worker-profile' />
                <a href="#" id="feedback-details-worker-details-link" style="cursor: pointer">
                    <h1 id="feedback-details-worker-name">Chaminda Gunathilaka&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i></h1>
                </a>
                <span class="blue-badge" id="feedback-details-booking-date">Feedback created date 2023-04-25</span>
            </div>
        </div>
        <div class="feedback-details-rating-observations">
            <div class="feedback-details-rating-container">
                <div class="feedback-details-rating-header">
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
                <h1>Extra observations</h1>
                <div class="feedback-details-extra-observations" id="feedback-details-extra-observations">
                </div>
            </div>
        </div>
    </div>
    <div class="feedback-details-comment-container" id="feedback-details-comment-container">
        <h1>Written feedback</h1>
        <p id="feedback-details-comment-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad cupiditate eos ipsa magnam maiores saepe, sequi tempore! At autem dolore fuga laboriosam molestias necessitatibus, nemo omnis qui suscipit temporibus, voluptas.</p>
    </div>
    <div class="feedback-details-extra-observations-container" id="feedback-details-extra-observations-container">

    </div>
    <div class="feedback-details-button-container">
        <button class="primary-button"><i class="fa-solid fa-pen-nib"></i>&nbsp;&nbsp;Edit feedback</button>
        <button class="primary-outline-button" onclick="hideFeedbackDetails()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        <button class="primary-button" id="feedback-details-booking-button"><i class="fa-solid fa-arrow-turn-up"></i>&nbsp;&nbsp;View booking</button>
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
                <button type="button" class="primary-button" onclick="closeBookingDetailsModal()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
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
            <a href="./feedbacks.php">
                <div class="sidebar-item sidebar-item-selected">
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
            <h1>All About Your <u>Feedbacks</u> In One Place!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <div class="new-feedback">
            <h1>Provide new Feedback?</h1>
            <?php
                /*
                 * Checking whether number of bookings which are completed or rejected
                 *  - If there are bookings which completed or rejected then customer allowed to provide
                 *  feedback using that bookings
                 *  - If not customer not allowed to provide feedback
                 */
                require_once('../db.php');

                if($numOfBookings > 0){
                    echo "<button class='primary-button' id='provide-feedback-button' onclick='showFeedbackContainer()'>Provide Feedback</button>";
                } else {
                    echo "
                        <div class='toolip'>
                            <div class='tooltiptext'>
                                Please add bookings to provide feedbacks!
                            </div>
                            <button class='primary-button disabled-button' id='provide-feedback-button' disabled>
                            Provide Feedback&nbsp;&nbsp;<i class='fa-solid fa-question'></i>
                            </button>
                        </div>";
                }
            ?>
        </div>
        <!-- Recent feedbacks section -->
        <div class="recent-feedback">
            <h1>Recent Feedbacks</h1>
        </div>
        <div class="recent-feedbacks-container" id="recent-feedbacks-container">
            <?php
                require_once('../db.php');

                $sql_get_most_recent_feedbacks = "SELECT Feedback.*, Booking.*, Worker.First_Name, Worker.Last_Name FROM Feedback INNER JOIN Booking ON Feedback.Booking_ID = Booking.Booking_ID INNER JOIN User AS Worker ON Booking.Worker_ID = Worker.User_ID WHERE Booking.Customer_ID = $customerId ORDER BY Feedback.Timestamp DESC LIMIT 4";

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

        <!--Feedbacks search container-->
        <div class="feedback-search" id="feedback-search-container">
            <div class="feedback-search-title">
                <h1>Search for Feedbacks</h1>
                <form action="" method="POST">
                    <div class="feedback-search-input-container">
                        <label for="feedback-search">Search (Worker name etc)</label>
                        <div class="feedback-search-input-field">
                            <input type="text" id="feedback-search" class="feedback-search-input" name="users-search"/>
                            <button type="button" class="search-icon-small" id="feedback-search-input-button"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="recent-payments-container" id="feedback-search-table-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th" style="width: 40%;">
                        <div class="table-heading-container">Comment&nbsp;<button class="sort-button" id="sort-writtenFeedback-button" onclick="sortFeedbacks('writtenFeedback')"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Worker Name&nbsp;<button class="sort-button" id="sort-workerName-button" onclick="sortFeedbacks('workerName')"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Commented Date&nbsp;<button class="sort-button" id="sort-createdTimestamp-button" onclick="sortFeedbacks('createdTimestamp')"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody id="feedback-details-body-table">

                <?php
                    for($i = 0; $i < 5; $i++){
                        echo "
                        <tr class='main-tr'>
                    <td class='main-td' style='text-align: left;'>
                        <div class='loading-div' style='width: 75%; height: 20px;'></div>
                        <br />
                        <div class='loading-div' style='width: 50%; height: 20px;'></div>
                    </td>
                    <td class='main-td'>
                        <div class='loading-div' style='width: 50%; height: 40px;'></div>
                    </td>
                    <td class='main-td'>
                        <div class='loading-div' style='width: 50%; height: 40px;'></div>
                    </td>
                    <td class='main-td'>
                        <div class='more-button-container'>
                            <div class='loading-div' style='width: 30%; height: 40px;'></div>
                            &nbsp;&nbsp;
                            <div class='loading-div' style='width: 30%; height: 40px;'></div>
                        </div>
                    </td>
                </tr>
                        ";
                    }
                ?>


                </tbody>
            </table>
            <div class="pagination-container" id="feedback-details-pagination-container">
                <button class="pagination-button" id="feedback-back-button" onclick="goToPreviousFeedbackTablePage()"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="pagination-button" id="feedback-back-number-button"><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button-current" id="feedback-current-number-button"><i class="fa-solid fa-2"></i></button>
                <button class="pagination-button" id="feedback-next-number-button"><i class="fa-solid fa-3"></i></button>
                <button class="pagination-button" id="feedback-next-button" onclick="goToNextFeedbackTablePage()"><i class="fa-solid fa-arrow-right"></i></button>
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
    $firstBookingId = $firstBookingId ? $firstBookingId : 0;
    echo "<script>
        let userId = $customerId;
        let currentBookingId = $firstBookingId;
    </script>"
?>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/feedbacks.js" type="text/javascript"></script>
</body>