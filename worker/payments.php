<?php
    session_start();
    // Check whether customer is logged in
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
    <link href="../styles/worker/worker-payments.css" rel="stylesheet"/>
    <title>Payments | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
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
                <h4 class="details-value">Saman Gunawardhana</h4>
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
            <div class="back-button-container">
                <button type="button" class="more-button" id="back-button">Back</button>
            </div>
        </div>
    </div>
</div>
<nav class="nav-bar">
    <div class="nav-bar-items">
        <div class="logo-container">
            <img src="../assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="search-container">
            <div class="search-icon-container">
                <img src="../assets/svg/search.svg" alt="search" class="search-icon"/>
            </div>
            <input type="text" class="search-bar-input" placeholder="Search for a labourer or a service"/>
        </div>
        <div class="nav-link-container">
            <div class="nav-link-items"><a href="../index.php" class="nav-links">Home</a></div>
            <div class="nav-link-items"><a href="../about-us.php" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="../contact-us.php" class="nav-links">Contact Us</a></div>
            <?php
                if (!isset($_SESSION['username'])) {

                    ?>
                    <div class="nav-link-items">
                        <button type="button" id="register-button" class="nav-link-items-button"
                                style="background-color: #FFF; color: #102699;">
                            REGISTER
                        </button>
                    </div>
                    <div class="nav-link-items">
                        <button type="button" class="nav-link-items-button" onclick="window.location.href='login.php'">
                            LOGIN
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="nav-link-items">
                        <div class="dropdown" id="dropdown">
                            <button type="button" id="user-dropdown-button" onClick="opendropdown()"
                                    class="nav-link-items-button"
                                    style="background-color: #FFF; color: #102699;">
                                <i class="fa-regular fa-circle-user"></i>&nbsp;
                                <?php echo "Hi, " . $_SESSION['first_name']; ?>
                                &nbsp;
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-items" id="dropdown-items">
                                <?php
                                    if ($_SESSION['user_type'] == 'Admin') {
                                        echo '<a href="../admin/dashboard.php">';
                                    } else if ($_SESSION['user_type'] == 'Customer') {
                                        echo '<a href="../customer/dashboard.php">';
                                    } else {
                                        echo '<a href="../worker/dashboard.php">';
                                    }
                                ?>
                                <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                                </div>
                                </a>
                                <a href="#">
                                    <div class="dropdown-item" id="dropdown-item">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        &nbsp;&nbsp;<a href="../logout.php">Logout</a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
        </div>
    </div>
</nav>
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
                    <h4 class="sidebar-icon-heading">Booking</h4>
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
                <div class="sidebar-item sidebar-item-selected">
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
            <h1>Your <u>Payment</u> details here!
                <!-- <u>
                    <?php
                        echo $_SESSION['first_name'] . " " . $_SESSION['last_name']
                    ?>
                </u> -->
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
        <!-- <div class="overview-content">
            <h1>Payments</h1>
        </div> -->
        <!--Due payments section-->
        <div class="due-payments">
            <div class="due-payments-title">
                <h1>Payments Due</h1>
            </div>
            <div class="due-payments-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Customer Name</th>
                        <th class="main-th">Start Date</th>
                        <th class="main-th">Amount</th>
                        <th class="main-th">Payment Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Saman Gunawardhana
                            <br/>
                        </td>
                        <td class="main-td">19 Nov 2022</td>
                        <td class="main-td">Rs. 27000.00</td>
                        <td class="main-td">Success</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Avinash Sudira
                            <br/>
                        </td>
                        <td class="main-td">30 Nov 2022</td>
                        <td class="main-td">Rs. 12500.00</td>
                        <td class="main-td">Failed</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Dinesh Attanayaka
                            <br/>
                        </td>
                        <td class="main-td">01 Nov 2022</td>
                        <td class="main-td">Rs. 1700.00</td>
                        <td class="main-td">Success</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Kapila Dharmadhasa
                            <br/>
                        </td>
                        <td class="main-td">19 Nov 2022</td>
                        <td class="main-td">Rs. 12000.00</td>
                        <td class="main-td">Success</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Search for payments section -->
        <div class="booking-search">
            <div class="booking-search-title">
                <h1>Search for payments</h1>
                <form action="" method="POST">
                    <div class="booking-search-input-container">
                        <label for="booking-search">Search (Using customer name, date etc)</label>
                        <div class="booking-search-input-field">
                            <input type="text" id="booking-search" class="booking-search-input" name="users-search"/>
                            <button class="search-icon-small"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Search for payments table -->
        <div class="recent-payments-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                    <th class="main-th">
                        <div class="table-heading-container">Customer name&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Amount&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-up"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Status&nbsp;<button class="sort-button"><i
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
                        <span class="blue-badge">19 Nov 2022</span>
                    </td>
                    <td class="main-td">Rs. 27000.00</td>
                    <td class="main-td">Success</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Avinash Sudira
                        <br/>
                        <span class="blue-badge">15 Nov 2022</span>
                    </td>
                    <td class="main-td">Rs. 12500.00</td>
                    <td class="main-td">Failed</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Dinesh Attanayaka
                        <br/>
                        <span class="blue-badge">10 Nov 2022</span>
                    </td>
                    <td class="main-td">Rs. 1700.00</td>
                    <td class="main-td">Success</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Kapila Dharmadhasa
                        <br/>
                        <span class="blue-badge">8 Nov 2022</span>
                    </td>
                    <td class="main-td">Rs. 12000.00</td>
                    <td class="main-td">Success</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Saman Gunawardhana
                        <br/>
                        <span class="blue-badge">30 Oct 2022</span>
                    </td>
                    <td class="main-td">Rs. 18000.00</td>
                    <td class="main-td">Success</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Saman Gunawardhana
                        <br/>
                        <span class="blue-badge">30 Oct 2022</span>
                    </td>
                    <td class="main-td">Rs. 18000.00</td>
                    <td class="main-td">Failed</td>
                    <td class="main-td">
                        <div class="more-button-container">
                            <button class="view-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;View
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="pagination-container">
                <button class="pagination-button"><i class="fa-solid fa-arrow-left"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-1"></i></button>
                <button class="pagination-button-current"><i class="fa-solid fa-2"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-3"></i></button>
                <button class="pagination-button"><i class="fa-solid fa-arrow-right"></i></button>
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
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/bookings.js" type="text/javascript"></script>
</body>