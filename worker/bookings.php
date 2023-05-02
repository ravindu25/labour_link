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
        <div class="status-container">
            <button type="button" class="status-button">In-Progress</button>
        </div>
        <div class="details-container">
            <div class="details-row">
                <h4>Job type</h4>
                <h4 class="details-value">Plumber</h4>
            </div>
            <div class="details-row">
                <h4>Customer</h4>
                <h4 class="details-value">Rvindu Wegiriya</h4>
            </div>
            <div class="details-row">
                <h4>Start date</h4>
                <h4 class="details-value">21-Nov-2022</h4>
            </div>
            <div class="remaining-time-container">
                <h4>This booking will be closed in</h4>
                <h1 class="countdown-text">12 hrs 3 days</h1>
            </div>
            <div class="payment-method-container">
                <div class="payment-image-container">
                    <h4>Payment Method</h4>
                    <div class="payment-image-card">
                        <img class="payment-image" src="../assets/customer/dashboard/undraw_credit_card_re_blml.svg"
                             alt="payment method"/>
                        <h4>Online payments</h4>
                    </div>
                </div>
                <div class="payment-details-container">
                    <h3>Amount that needs to be paid</h3>
                    <h2>Rs. 17500.00</h2>
                </div>
            </div>
            <div class="status-button-container">
                <div class="reject-button-container">
                    <button type="button" class="worker-input-button" id="reject-button"><i class="fa fa-ban"></i> Reject</button>
                </div>
                <!-- <div class="pending-button-container">
                    <i class="fa fa-angle-double-left"></i>
                    <button type="button" class="worker-input-button" id="pending-button">Pending</button>
                    <i class="fa fa-angle-double-right"></i>
                </div> -->
                <div class="accept-button-container">
                    <button type="button" class="worker-input-button" id="accept-button"><i class="fa fa-check"></i> Accept</button>
                </div>
            </div>
            <div class="back-button-container">
                <button type="button" class="more-button" id="back-button">Back</button>
            </div>
        </div>
    </div>
</div>
<div class="create-booking-container" id="create-booking-container">
    <div class="create-booking-scroll-wrapper">
        <div class="create-booking-title">
            <h1>Create new <u>Booking</u></h1>
        </div>
        <form id="booking-create-form">
            <div class="form-input-row">
                <label for="job-type">Job type</label>
                <select id="job-type" name="job-type">
                    <option value="Electrician">Electrician</option>
                    <option value="Plumber">Plumber</option>
                    <option value="Painter">Painter</option>
                    <option value="Carpenter">Carpenter</option>
                    <option value="Mason">Mason</option>
                    <option value="Janitor">Janitor</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Gardner">Gardner</option>
                </select>
            </div>
            <div class="form-input-row">
                <label for="worker-id">Worker</label>
                <select id="worker-id" name="worker-name"></select>
            </div>
            <div class="form-input-row">
                <label for="start-date">Start date</label>
                <input type="date" id="start-date" name="start-date"/>
            </div>
            <div class="form-time-row">
                <label>
                    Days needed to complete
                </label>
                <div class="time-row">
                    <label>
                        <input type="radio" name="time-input" value="1" class="time-card-input"/>
                        <div class="time-card">
                            <h3>1</h3>
                            <h4>Day</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="2" class="time-card-input"/>
                        <div class="time-card">
                            <h3>2</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="7" class="time-card-input" checked/>
                        <div class="time-card">
                            <h3>7</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="14" class="time-card-input"/>
                        <div class="time-card">
                            <h3>14</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="30" class="time-card-input"/>
                        <div class="time-card">
                            <h3>30</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-payment-row">
                <label>Payment method</label>
                <div class="payment-methods-container">
                    <label>
                        <input type="radio" name="payment-method" class="payment-method-radio" value="manual"/>
                        <div class="payment-method-card">
                            <img src="../assets/customer/dashboard/undraw_savings_re_eq4w.svg" alt="manual-payment"
                                 class="payment-method-image"/>
                            <h5>Manual payments</h5>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="payment-method" class="payment-method-radio" value="online" checked/>
                        <div class="payment-method-card">
                            <img src="../assets/customer/dashboard/undraw_credit_card_re_blml.svg" alt="online-payment"
                                 class="payment-method-image"/>
                            <h5>Online payments</h5>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-button-container">
                <button type="button" class="more-button" id="booking-create-cancel-button">Cancel</button>
                <button type="submit" class="more-button submit-button" id="booking-create-submit-button">Create
                    Booking
                </button>
            </div>
        </form>
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

                $sql_get_status = "SELECT First_Name,Last_Name ,Start_Date, Worker_Type, Created_Date ,Status FROM User INNER JOIN Booking ON User.User_ID = Booking.Customer_ID WHERE Booking.Worker_ID={$_SESSION['user_id']} ORDER BY Created_Date DESC LIMIT 5";


                $result = $conn->query($sql_get_status);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

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
                        <div class="booking-card"
                            <div class="card-text">
                                <h3>'.$row['Worker_Type'].'</h3>
                                <p>Customer</p>
                                <h4>' . $row['First_Name'] . ' ' . $row['Last_Name'] . '</h4>
                            <div class="booking-card-button-row">
                                <div class="badge-container">
                                    <div class="blue-badge">' . date("d M Y", strtotime($row['Start_Date'])) . '</div> 
                                </div>
                                '. $button .'
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
                <h1>Search for bookings</h1>
                <form action="" method="POST">
                    <div class="booking-search-input-container">
                        <label for="booking-search">Search (Worker name etc)</label>
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
                        <div class="table-heading-container">Worker name&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Start date&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">End date&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Saman Gunawardhana
                        <br/>
                        <span class="pending-badge">Pending</span>
                    </td>
                    <td class="main-td">21 Oct 2022</td>
                    <td class="main-td">27 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Sunil Perera
                        <br/>
                        <span class="pending-badge">Pending</span>
                    </td>
                    <td class="main-td">12 Oct 2022</td>
                    <td class="main-td">20 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Sunith Hettiarachchi
                        <br/>
                        <span class="rejected-badge">Rejected</span>
                    </td>
                    <td class="main-td">1 Oct 2022</td>
                    <td class="main-td">5 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Dammika Kumara
                        <br/>
                        <span class="completed-badge">Completed</span>
                    </td>
                    <td class="main-td">23 Oct 2022</td>
                    <td class="main-td">28 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Dinesh Attanayaka
                        <br/>
                        <span class="completed-badge">Completed</span>
                    </td>
                    <td class="main-td">10 Oct 2022</td>
                    <td class="main-td">24 Oct 2022</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update
                            </button>
                            <button class="rejected-button"><i class="fas fa-times"></i>&nbsp;&nbsp;Reject
                            </button>
                        </div>
                    </td>
                </tr>
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