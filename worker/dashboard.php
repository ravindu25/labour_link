<?php
    session_start();
    // Check whether labourer is logged in
    // if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Worker') {
    //     header("Location: ../login.php");
    // }
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
            <div class="nav-link-items"><a href="#" class="nav-links">Home</a>
            </div>
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
            session_start();
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
            <?php } 
            else { ?>
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


                $sql = "SELECT * FROM Login_attempt WHERE User_ID = {$userId} ORDER BY Timestamp DESC LIMIT 1";
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
                <h1>Recent Bookings</h1>
                <button class="more-button">More Bookings</button>
            </div>
            <div class="recent-bookings-container">
                <div class="booking-card">
                    <div class="card-text">
                        <h3>Eletrical</h3>
                        <p>Customer</p>
                        <h4>Mohomed Izzath</h4>
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
                        <h3>Eletrical</h3>
                        <p>Customer</p>
                        <h4>Ravindu Wegiriya</h4>
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
                        <h3>Eletrical</h3>
                        <p>Customer</p>
                        <h4>Dhananga Deepanjana</h4>
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
                        <h3>Eletrical</h3>
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
                        <h3>Eletrical</h3>
                        <p>Customer</p>
                        <h4>Mohomed Izzath</h4>
                    </div>
                    <div class="booking-card-button-row">
                        <div class="badge-container">
                            <div class="blue-badge">30 Dec 2022</div>
                        </div>
                        <button class="pending-button">Pending</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Recent feedbacks section-->
        <div class="recent-feedbacks">
            <div class="recent-feedbacks-title">
                <h1>Recent Feedbacks</h1>
                <button class="more-button">More Feedbacks</button>
            </div>
            <div class="recent-feedbacks-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Comment</th>
                        <th class="main-th">Customer name</th>
                        <th class="main-th">Commented date</th>
                        <th class="main-th">Service</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Extremely satisfied with the work done
                            <br />
                            <span class="blue-badge">Updated 15 days ago</span>
                        </td>
                        <td class="main-td">Mohomed Izzath</td>
                        <td class="main-td">21 Oct 2022</td>
                        <td class="main-td">Electrical</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Process was neatly done on time
                            <br />
                            <span class="blue-badge">Updated 20 days ago</span>
                        </td>
                        <td class="main-td">Ravindu Wegiriya</td>
                        <td class="main-td">16 Oct 2022</td>
                        <td class="main-td">Electrical</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Work not completed on time. Slighlty dissappointing
                            <br />
                            <span class="blue-badge">Updated 27 days ago</span>
                        </td>
                        <td class="main-td">Dhananga Deepanjana</td>
                        <td class="main-td">09 Oct 2022</td>
                        <td class="main-td">Electrical</td>
                    </tr>
                    <tr class="main-tr">
                        <td class="main-td" style="text-align: left;">Payment not going through
                            <br />
                            <span class="blue-badge">Updated 1 month ago</span>
                        </td>
                        <td class="main-td">Rushdha Rasheed</td>
                        <td class="main-td">05 Oct 2022</td>
                        <td class="main-td">Electrical</td>
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
                    <div class="housing-job-item">
                            <div class="job-item-text">
                                <h3>Electrical</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="pending-button">Pending</button>
                            </div>
                        </div>
                </div>
                <div class="housing-card">
                    <h4>Housing package details</h4>
                    <h3>Kollupitiya Colombo</h3>
                    <span class="blue-badge">Started date - 10 Nov 2022</span>
                    <div class="housing-job-item">
                            <div class="job-item-text">
                                <h3>Electrical</h3>
                            </div>
                            <div class="jon-item-button">
                                <button type="button" class="completed-button">Completed</button>
                            </div>
                        </div>
                </div>
            </div>
            <div class="payments-dash-content">
                <h1>Payments</h1>
                <div class="payments-list">
                    <div class="payment-item">
                        <div class="payment-text">
                            <span class="blue-badge">21 Oct 2022</span>
                            <h3>Mohomed Izzath</h3>
                            <h4>Saman Gunawardhana</h4>
                        </div>
                        <div class="payment-button">
                            <button type="button" class="payment-amount-button">Rs. 27900.00</button>
                        </div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-text">
                            <span class="blue-badge">19 Oct 2022</span>
                            <h3>Ravindu Wegiriya</h3>
                            <h4>Saman Gunawardhana</h4>
                        </div>
                        <div class="payment-button">
                            <button type="button" class="payment-amount-button">Rs. 12000.00</button>
                        </div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-text">
                            <span class="blue-badge">21 Oct 2022</span>
                            <h3>Dhananga Deepanjana</h3>
                            <h4>Saman Gunawardhana</h4>
                        </div>
                        <div class="payment-button">
                            <button type="button" class="payment-amount-button">Rs. 17000.00</button>
                        </div>
                    </div>
                    <div class="payment-item">
                        <div class="payment-text">
                            <span class="blue-badge">19 Oct 2022</span>
                            <h3>Rushdha Rasheed</h3>
                            <h4>Saman Gunawardhana</h4>
                        </div>
                        <div class="payment-button">
                            <button type="button" class="payment-amount-button">Rs. 21000.00</button>
                        </div>
                    </div>
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