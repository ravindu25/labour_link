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
    <title>Worker Dashboard | LabourLink</title>
</head>
<body>
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="../assets/svg/user-check-solid.svg" alt="house icon" class="register-select-icon"/>
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/labour-type.svg" alt="worker" class="reg-type-image"/>
            <button type="button" onclick="window.location.href='../worker-registration.php'" class="card-button">
                Worker
            </button>
        </div>
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/customer-type.svg" alt="customer" class="reg-type-image"/>
            <button type="button" onclick="window.location.href='../customer-registration.php'" class="card-button">
                Customer
            </button>
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
            <div class="nav-link-items"><a href="#" class="nav-links">Home</a></div>
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
            <?php }else{ ?>
            <div class="nav-link-items">
                <div class="dropdown" id="dropdown">
                    <button type="button" id="user-dropdown-button" onClick="opendropdown()"
                            class="nav-link-items-button"
                            style="background-color: #FFF; color: #102699;">
                        <i class="fa-regular fa-circle-user"></i>&nbsp;
                        Hi,&nbsp;<?php echo $_SESSION['first_name']; ?>
                        &nbsp;
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-items" id="dropdown-items">
                        <a href="#">
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
                <div class="sidebar-item sidebar-item-selected">
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
            <h1>Welcome back <u>Ravindu Wegiriya</u></h1>
            <h5>Last accessed 21st October 2022</h5>
        </div>
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recently made Bookings</h1>
                <button class="more-button">More Bookings</button>
            </div>
            <div class="recent-bookings-container">
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Mechanical</h3>
                        <p>Work by</p>
                        <h4>Dammika Kumara</h4>
                        <p>Customer</p>
                        <h4>Mohamed Izzath</h4>
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
                        <p>Customer</p>
                        <h4>Dhananga Deepanjana</h4>
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
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
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
                        <p>Customer</p>
                        <h4>Rushdha Rasheed</h4>
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
                        <p>Customer</p>
                        <h4>Dhananga Deepanjana</h4>
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
                        <th class="main-th">Commented date</th>
                        <th class="main-th">Made by</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Extremely satisfied with the work done
                            <br/>
                            <span class="blue-badge">Updated 15 days ago</span>
                        </td>
                        <td class="main-td">Saman Gunawardhana</td>
                        <td class="main-td">21 Oct 2022</td>
                        <td class="main-td">Mohamed Izzath</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Process was neatly done on time
                            <br/>
                            <span class="blue-badge">Updated 20 days ago</span>
                        </td>
                        <td class="main-td">Kapila Gunawardana</td>
                        <td class="main-td">16 Oct 2022</td>
                        <td class="main-td">Ravindu Wegiriya</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Work not completed on time. Slighlty dissappointing
                            <br/>
                            <span class="blue-badge">Updated 27 days ago</span>
                        </td>
                        <td class="main-td">Saman Gunathilaka</td>
                        <td class="main-td">09 Oct 2022</td>
                        <td class="main-td">Rushdha Rasheed</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">
                            Payment not going through
                            <br/>
                            <span class="blue-badge">Updated 1 month ago</span>
                        </td>
                        <td class="main-td">Kapila Dharmadhasa</td>
                        <td class="main-td">05 Oct 2022</td>
                        <td class="main-td">Dhananga Deepanjana</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="recent-payments">
            <div class="recent-payments-title">
                <h1>Recently made Feedbacks</h1>
                <button class="more-button">More Payments</button>
            </div>
            <div class="recent-payments-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Customer name/Date</th>
                        <th class="main-th">Worker name</th>
                        <th class="main-th">Amount</th>
                        <th class="main-th">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Dhananga Deepanjana<br/>
                            <span class="blue-badge">19 Nov 2022</span>
                        </td>
                        <td class="main-td">
                            Saman Gunawardhana
                        </td>
                        <td class="main-td">Rs. 27000.00</td>
                        <td class="main-td"><span class="payment-success-badge">Success</span></td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Ravindu Wegiriya<br/>
                            <span class="blue-badge">30 Nov 2022</span>
                        </td>
                        <td class="main-td">
                            Avinash Sudira
                        </td>
                        <td class="main-td">Rs. 12500.00</td>
                        <td class="main-td"><span class="payment-success-failed">Failed</span></td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Rushdha Rasheeda<br/>
                            <span class="blue-badge">1 Nov 2022</span>
                        </td>
                        <td class="main-td">
                            Dinesh Attanayaka
                        </td>
                        <td class="main-td">Rs. 1700.00</td>
                        <td class="main-td"><span class="payment-success-badge">Success</span></td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Mohamed Izzath<br/>
                            <span class="blue-badge">19 Nov 2022</span>
                        </td>
                        <td class="main-td">
                            Kapila Dharmadhasa
                        </td>
                        <td class="main-td">Rs. 12000.00</td>
                        <td class="main-td"><span class="payment-success-badge">Success</span></td>
                    </tr>
                    </tbody>
                </table>
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
</body>

