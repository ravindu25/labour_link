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
    <link href="../styles/admin/feedbacks.css" rel="stylesheet"/>
    <title>Feedbacks | Admin Dashboard</title>
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
                <h1>Control panel for managing <u>Feedbacks</u></h1>
                <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
            </div>
        </div>

        <!-- Recent feedbacks section -->
        <div class="recent-feedback">
            <h1>Feedbacks trends</h1>
        </div>
        <div class="recent-feedback-charts-container">
            <div class="recent-feedback-chart-container">
                <h3>Number of feedbacks(current month)</h3>
                <canvas id="chart-all-feedbacks"></canvas>
            </div>
            <div class="recent-feedback-chart-container">
                <h3>Customers feedback skipping rate</h3>
                <canvas id="chart-feedback-skipping"></canvas>
            </div>
        </div>

        <!-- Feedbacks table section -->
        <div class="recent-feedbacks-container" id="recent-feedbacks-container"></div>
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
                        <div class="table-heading-container">Customer Name&nbsp;<button class="sort-button" id="sort-customerName-button" onclick="sortFeedbacks('customerName')"><i
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
<script src="../scripts/admin/feedbacks/feedbacks.js" type="text/javascript"></script>
<script src="../scripts/admin/feedbacks/feedbacks-charts.js" type="text/javascript"></script>
</body>
