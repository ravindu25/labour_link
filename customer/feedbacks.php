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
<div class="backdrop-modal"></div>
<div class="create-feedback-container">
    <div class="create-feedback-page" id="first-page">
        <div class="create-feedback-title">
            <h1>Provide feedback about workers!</h1>
            <h5 style="text-align: center"><b>Please select booking to continue.</b>This will assist us in delivering enhanced services.</h5>
        </div>
        <div class="feedback-cards-container" id="create-feedback-bookings-container">
            <div class="pagination-card-disabled" id="create-feedback-bookings-previous">
                <i class="fa-solid fa-arrow-left"></i>
            </div>
            <?php
                /*
                 * Get the most recent 3 or fewer bookings to select to provide feedback
                 */
                require_once('../db.php');

                $customerId = $_SESSION['user_id'];

                $sql_get_most_recent_bookings = "select Booking.*, Worker.First_Name AS Worker_First_Name, Worker.Last_Name AS Worker_Last_Name, Customer.First_Name AS Customer_First_Name, Customer.Last_Name AS Customer_Last_Name from Booking inner join User AS Worker ON Booking.Worker_ID = Worker.User_ID inner join User AS Customer ON Booking.Customer_ID = Customer.User_ID where Booking.Customer_ID = $customerId AND Booking.Status IN('Completed', 'Rejected') ORDER BY Booking.Created_Date DESC LIMIT 3";

                $result = $conn->query($sql_get_most_recent_bookings);
                $firstBooking = true;

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

                        $divStyling = $firstBooking ? 'feedback-booking-card feedback-booking-card-selected' : 'feedback-booking-card';
                        $firstBooking = false;

                        echo "
                        <div class='$divStyling'>
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
                    echo '<div class="pagination-card" id="create-feedback-bookings-next" onclick="goToNextBookingPage()">
                            <i class="fa-solid fa-arrow-right"></i>
                    </div>';
                } else {
                    echo '<div class="pagination-card-disabled" id="create-feedback-bookings-next">
                            <i class="fa-solid fa-arrow-right"></i>
                    </div>';
                }
            ?>
        </div>
        <div class="create-feedback-button-container">
            <button class="secondary-button">Cancel</button>
            <button class="primary-button">Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
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
                    echo "<button class='primary-button' id='provide-feedback-button'>Provide Feedback</button>";
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
        <div class="recent-feedback-container">
            <table class="main-table">
                <thead>
                <tr class="main-tr">
                <th class="main-th">
                        <div class="table-heading-container">Comment&nbsp;
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Worker name&nbsp;
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Commented Date&nbsp;
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Service&nbsp;
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Extremely satisfied with the work done.
                        <br/>
                        <span class="blue-badge">Updated 15 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunawardhana</td>
                    <td class="main-td">21 Oct 2022</td>
                    <td class="main-td">Plumbing</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Process was neatly done on time
                        <br/>
                        <span class="blue-badge">Updated 20 days ago</span>
                    </td>
                    <td class="main-td">Kapila Gunawardhana</td>
                    <td class="main-td">16 Oct 2022</td>
                    <td class="main-td">Gardening</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Work not completed on time.Slightly dissappointing.
                        <br/>
                        <span class="blue-badge">Updated 27 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunathilaka</td>
                    <td class="main-td">09 Oct 2022</td>
                    <td class="main-td">Electrical</td>
                </tr>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Payment not going through
                        <br/>
                        <span class="blue-badge">Updated a month ago</span>
                    </td>
                    <td class="main-td">Kapila Dharmadasa</td>
                    <td class="main-td">05 Oct 2022</td>
                    <td class="main-td">Mason</td>
                </tr>
                </tbody>
            </table>
        </div>
        </div>

        <!--Feedbacks search container-->
        <div class="feedback-search">
            <div class="feedback-search-title">
                <h1>Search for Feedbacks</h1>
                <form action="" method="POST">
                    <div class="feedback-search-input-container">
                        <label for="feedback-search">Search (Worker name etc)</label>
                        <div class="feedback-search-input-field">
                            <input type="text" id="feedback-search" class="feedback-search-input" name="users-search"/>
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
                        <div class="table-heading-container">Comment&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                        </div>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Worker Name&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">
                        <div class="table-heading-container">Commented Date&nbsp;<button class="sort-button"><i
                                        class="fa-solid fa-arrow-down"></i></button>
                    </th>
                    <th class="main-th">More actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="main-tr">
                    <td class="main-td" style="text-align: left;">
                        Extremely satisfied with the work done.
                        <br/>
                        <span class="blue-badge">Updated 15 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunawardhana</td>
                    <td class="main-td">21 Oct 2022</td>
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
                        Process was neatly done on time.
                        <br/>
                        <span class="blue-badge">Updated 20 days ago</span>
                    </td>
                    <td class="main-td">Kapila Gunawardana</td>
                    <td class="main-td">16 Oct 2022</td>
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
                        Work not completed on time.Slighlty dissappointing.
                        <br/>
                        <span class="blue-badge">Updated 27 days ago</span>
                    </td>
                    <td class="main-td">Saman Gunathilaka</td>
                    <td class="main-td">09 Oct 2022</td>
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
                        Payment not going through.
                        <br/>
                        <span class="blue-badge">Updated 1 month ago</span>
                    </td>
                    <td class="main-td">Kapila Dharmadhasa</td>
                    <td class="main-td">05 Oct 2022</td>
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
<?php
    echo "<script>
        let userId = $customerId;
    </script>"
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/feedbacks.js" type="text/javascript"></script>
</body>