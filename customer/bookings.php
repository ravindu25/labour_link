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
    <link href="../styles/customer/customer-bookings.css" rel="stylesheet"/>
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
                <h4>Worker</h4>
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
            <div class="nav-link-items"><a href="#" class="nav-links">Home</a></div>
            <div class="nav-link-items">
                <select name="jobs" class="nav-select">
                    <option value="jobs" selected>Jobs</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="carpentry">Carpentry</option>
                    <option value="electrical">Electrical</option>
                    <option value="painting">Painting</option>
                    <option value="masonry">Masonry</option>
                    <option value="janitorial">Janitorial</option>
                    <option value="mechanical">Mechanical</option>
                    <option value="gardening">Gardening</option>
                </select>
            </div>
            <div class="nav-link-items"><a href="#" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="#" class="nav-links">Contact Us</a></div>
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
                <div class="sidebar-item sidebar-item-selected">
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
        <div class="new-booking">
            <h1>Do you want to create a new booking?</h1>
            <button class="more-button" id="booking-create-button">Create Booking</button>
        </div>
        <!--Recent bookings section-->
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recently made Bookings</h1>
            </div>
            <div class="recent-bookings-container">
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Mechanical</h3>
                        <p>Work by</p>
                        <h4>Dammika Kumara</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">21 Oct 2022</div>
                        </div>
                        <button class="completed-button">Completed</button>
                    </div>
                </div>
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Plumbing</h3>
                        <p>Work by</p>
                        <h4>Saman Gunawardhana</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">12 Nov 2022</div>
                        </div>
                        <button class="in-pogress-button">In-Progress</button>
                    </div>
                </div>
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Painting</h3>
                        <p>Work by</p>
                        <h4>Avinash Sudira</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">30 Nov 2022</div>
                        </div>
                        <button class="in-pogress-button">In-Progress</button>
                    </div>
                </div>
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Plumbing</h3>
                        <p>Work by</p>
                        <h4>Dinesh Attanayaka</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">1 Nov 2022</div>
                        </div>
                        <button class="rejected-button">Rejected</button>
                    </div>
                </div>
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Painting</h3>
                        <p>Work by</p>
                        <h4>Avinash Sudira</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">30 Nov 2022</div>
                        </div>
                        <button class="pending-button">Pending</button>
                    </div>
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
                            <button class="delete-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
                            <button class="delete-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
                            <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
                            <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
                            <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
<script src="../scripts/customer/create-booking-fetch-workers.js" type="text/javascript"></script>
<script src="../scripts/customer/create-booking.js" type="text/javascript"></script>
</body>