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
    <title>Admin Dashboard | LabourLink</title>
</head>
<body>
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


                $sql = "SELECT * FROM Login_Attempt WHERE User_ID = {$userId} ORDER BY Timestamp DESC LIMIT 1";
                $result = $conn -> query($sql);

                $row = $result->fetch_assoc();
                $latestTime = date_create($row['Timestamp']);

                $dateInText = date_format($latestTime, 'dS F Y');

                echo "<h5>Last accessed $dateInText</h5>";
            ?>
        </div>
        <div class="recent-bookings">
            <div class="recent-bookings-title">
                <h1>Recently made Bookings</h1>
                <button class="more-button">More Bookings</button>
            </div>
            <div class="recent-bookings-container">
                <?php
                    require_once('../db.php');

                    // Getting customer id from the session
                    $customer_id = $customer_id = $_SESSION['user_id'];
                    $sql_get_bookings = "select Booking.*, User.First_Name, User.Last_Name from Booking inner join User on Booking.Worker_ID = User.User_ID ORDER BY Booking.Created_Date DESC LIMIT 5";

                    $status = array("Pending","Completed","Rejected","In-Progress");

                    $result = $conn->query($sql_get_bookings);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $worker_type = $row['Worker_Type'];
                            $worker_name = $row['First_Name'] . " " . $row['Last_Name'];
                            $start_date = date("d M Y", strtotime($row['Start_Date']));
                            $statusValue = array_rand($status);
                            $sql_get_customer_name = "SELECT * from User where User_ID = {$row['Customer_ID']}";
                            $result_customer_name = $conn->query($sql_get_customer_name);
                            $row_customer_name = $result_customer_name->fetch_assoc();
                            $customer_name = $row_customer_name['First_Name'] . " " . $row_customer_name['Last_Name'];


                            $button = '';
                            switch($statusValue){
                                case 0:
                                    $button = '<button class="pending-button">Pending</button>';
                                    break;
                                case 1:
                                    $button = '<button class="completed-button">Completed</button>';
                                    break;
                                case 2:
                                    $button = '<button class="rejected-button">Rejected</button>';
                                    break;
                                case 3:
                                    $button = '<button class="in-pogress-button">In-Progress</button>';
                                    break;
                                default:
                                    $button = '<button class="in-pogress-button">In-Progress</button>';
                                    break;
                            }

                            echo "
                                <div class='booking-card'>
                                    <div class='card-text'>
                                        <h3>$worker_type</h3>
                                        <p>Work by</p>
                                        <h4>$worker_name</h4>
                                        <p>Customer</p>
                                        <h4>$customer_name</h4>
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
                <h1>Recently made Payments</h1>
                <button class="more-button">More Payments</button>
            </div>
            <div class="recent-payments-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Customer Name/Date</th>
                        <th class="main-th">Worker name</th>
                        <th class="main-th">Amount</th>
                        <th class="main-th">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        require_once "../db.php";
                        $sql = "SELECT * FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_ID = Booking.Booking_ID INNER JOIN User ON Booking.Worker_ID = User.User_ID ORDER BY Timestamp DESC LIMIT 5";
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
                            echo('</tr>');
                            }
                        }
                    ?>
                   
                   
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

