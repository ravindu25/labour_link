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
    <link href="../styles/admin/payments.css" rel="stylesheet"/>
    <title>Payments | Admin Dashboard</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="backdrop-modal" id="admin-backdrop-modal">
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
                <h1>Control panel for managing <u>Payments</u></h1>
                <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
            </div>
        </div>
        <div class="due-payments">
            <div class="due-payments-title">
                <h1>Payments Due</h1>
            </div>
            <div class="due-payments-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Customer Name</th>
                        <th class="main-th">Worker Name</th>
                        <th class="main-th">Due Date</th>
                        <th class="main-th">Due Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once "../db.php";
                        $sql = "SELECT * FROM Payments_Due INNER JOIN Booking ON Payments_Due.Booking_ID = Booking.Booking_ID INNER JOIN User ON Booking.Worker_ID = User.User_ID";
                        $result = $conn->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $sql_get_customer_name = "SELECT * FROM User WHERE User_ID = ".$row['Customer_ID'];
                                $result_get_customer_name = $conn->query($sql_get_customer_name);
                                $row_get_customer_name = $result_get_customer_name->fetch_assoc();
                                $customer_name = $row_get_customer_name['First_Name'].' '.$row_get_customer_name['Last_Name'];
                                $date = date_create($row['Due_Date']);
                                $dateInText = date_format($date, 'dS F Y');
                                echo(' <tr class="main-tr">
                                <td class="main-td" style="text-align: left;">'.$customer_name.'   
                                </td>
                                <td class="main-td">
                                '.$row['First_Name'].' '.$row['Last_Name'].'
                                </td>
                                <td class="main-td">'.$dateInText.'</td>
                                <td class="main-td">Rs. '.$row['Due_Amount'].'.00</td>
                                </tr>');
                            }
                        }
                    ?>
                   
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
                        <div class="table-heading-container">Worker name&nbsp;<button class="sort-button"><i
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
                <?php
                        require_once "../db.php";
                        $sql = "SELECT * FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_ID = Booking.Booking_ID INNER JOIN User ON Booking.Worker_ID = User.User_ID ORDER BY Timestamp";
                        $result = $conn->query($sql);
                        if($result->num_rows > 0){
                            while($row = $result->fetch_assoc()){
                                $sql_get_customer_name = "SELECT * FROM User WHERE User_ID = ".$row['Customer_ID'];
                                $result_get_customer_name = $conn->query($sql_get_customer_name);
                                $row_get_customer_name = $result_get_customer_name->fetch_assoc();
                                $customer_name = $row_get_customer_name['First_Name'].' '.$row_get_customer_name['Last_Name'];
                                $date = date_create($row['Timestamp']);
                                $dateInText = date_format($date, 'dS F Y');
                                echo(' <tr class="main-tr">
                                <td class="main-td" style="text-align: left;">'.$customer_name.'<br/>
                                    <span class="blue-badge">'.$dateInText.'</span>
                                </td>
                                <td class="main-td">
                                '.$row['First_Name'].' '.$row['Last_Name'].'
                                </td>
                                <td class="main-td">Rs. '.$row['Amount'].'.00</td>
                                ');
                                if($row['Success_Flag'] == 2){
                                    echo('<td class="main-td"><span class="payment-success-badge">Success</span></td>');
                                }else{
                                    echo('<td class="main-td"><span class="payment-success-failed">Failed</span></td>');
                                }
                            echo('<td class="main-td">
                            <div class="more-button-container">
                                <button class="view-button"><i class="fa-solid fa-up-right-from-square"></i>&nbsp;&nbsp;View
                                </button>
                            </div>
                        </td>
                    </tr>');
                            }
                        }
                    ?>
             
                
                
                <?php
                echo '<script src="../scripts/admin/loader.js" type="text/javascript"></script>';
                echo '<script>closeLoader()</script>';
                ?>
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
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/admin/payments.js" type="text/javascript"></script>
</body>
