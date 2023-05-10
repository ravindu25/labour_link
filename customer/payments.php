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
    <!-- <link href="../styles/customer/customer-dashboard.css" rel="stylesheet"/> -->
    <link href="../styles/customer/customer-payments.css" rel="stylesheet"/>
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
        <div class="overview-content">
            <h1>Payments</h1>
        </div>
        <!--Due payments section-->
        <div class="due-payments">
            <div class="due-payments-title">
                <h1>Payments Due</h1>
            </div>
            <div class="due-payments-container">
                <table class="main-table">
                    <thead>
                    <tr class="main-tr">
                        <th class="main-th">Worker Name</th>
                        <th class="main-th">Due Date</th>
                        <th class="main-th">Amount</th>
                        <th class="main-th">More actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once('../db.php');
                    
                            $customer_id=$_SESSION['user_id'];
                            $sql = "SELECT * FROM Payments_Due INNER JOIN Booking ON Payments_Due.Booking_ID = Booking.Booking_ID INNER JOIN User ON Booking.Customer_ID=User.User_ID WHERE Booking.Customer_ID = $customer_id AND Payments_Due.PayHere_Payment_ID IS NULL;";
                            $result = $conn -> query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $workerId = $row['Worker_ID'];
                                    $bookingID = $row['Booking_ID'];
                                    $amount=$row['Due_Amount'];;
                                    $payment_due_id=$row['Payment_Due_ID'];
                                    $worker_sql = "SELECT * FROM User WHERE User_ID = {$workerId}";
                    
                                    $workerResult = $conn -> query($worker_sql);
                                    $workerRow = $workerResult->fetch_assoc();

                                    $workerName = $workerRow['First_Name'] . " " . $workerRow['Last_Name'];


                                    $dueDate = date_create($row['Due_Date']);
                                    $dueDateInText = date_format($dueDate, 'dS F Y');

                                    echo "<tr class='main-tr'>
                                            <td class='main-td' style='text-align: left;'>{$workerRow['First_Name']} {$workerRow['Last_Name']}
                                                <br/>
                                            </td>
                                            <td class='main-td'>{$dueDateInText}</td>
                                            <td class='main-td'>Rs. {$row['Due_Amount']}</td>
                                            <td class='main-td'>
                                                <button class='more-button' type='submit' onclick='payNow($payment_due_id, $bookingID, $amount, \"$workerName\")'>Pay</button>
                                            
                                            </td>
                                        </tr>";
                                }
                            }
                        ?>
                    
                    
                    </tbody>
                </table>
            </div>
        </div>
                                <br>
        <!-- Search for payments section -->
        <div class="booking-search">
            <div class="booking-search-title">
                <h1>Search for Payments</h1>
                <form action="" method="POST">
                    <div class="booking-search-input-container">
                        <label for="booking-search">Search (Using worker name, date etc)</label>
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
                require_once '../db.php';
                $customer_id=$_SESSION['user_id'];
                $sql = "SELECT * FROM Payments_Log INNER JOIN Booking ON Payments_Log.Booking_ID = Booking.Booking_ID WHERE Booking.Customer_ID = $customer_id;";
                $result = $conn -> query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $paymentDate = date_create($row['Timestamp']);
                        $paymentDateInText = date_format($paymentDate, 'dS F Y');
                        if($row['Success_Flag']==2){
                            $successMessage="Successful";
                        }else{
                            $successMessage="Failed";
                        }
                        $sqlGetWorkerName = "SELECT First_Name, Last_Name FROM User WHERE User_ID = ".$row['Worker_ID'];
                        $resultGetWorkerName = $conn -> query($sqlGetWorkerName);
                        $rowGetWorkerName = $resultGetWorkerName->fetch_assoc();
                        echo("<tr class=\"main-tr\">
                        <td class=\"main-td\" style=\"text-align: left;\">
                            ".$rowGetWorkerName['First_Name']." ".$rowGetWorkerName['Last_Name']."
                            <br/>
                            <span class=\"blue-badge\">".$paymentDateInText."</span>
                        </td>
                        <td class=\"main-td\">Rs. ".$row['Amount']."</td>
                        <td class=\"main-td\">".$successMessage."</td>
                        <td class=\"main-td\">
                            <div class=\"more-button-container\">
                                <button class=\"view-button\"><i class=\"fa-solid fa-up-right-from-square\"></i>&nbsp;&nbsp;View
                                </button>
                            </div>
                        </td>
                    </tr>");

                    }
                }

        


                ?>
                <!-- <tr class="main-tr">
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
         -->
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
    </section>
</main>
<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/bookings.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<script>

    function payNow(payment_due_id, booking_id, amount, worker_name){
        //Call AJAX function to get the hash value
        var xmlhttp = new XMLHttpRequest();
         xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var hash_val = this.responseText;
            // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": merchant_id,    // Replace your Merchant ID
                    "return_url": undefined,     // Important
                    "cancel_url": undefined,     // Important
                    "notify_url": "https://ravinduwegiriya.com/authorize_payment.php",
                    "order_id": booking_id,
                    "items": "Payment to "+worker_name,
                    "amount": amount,
                    "currency": "LKR",
                    "hash": hash_val, // *Replace with generated hash retrieved from backend
                    "first_name": "Saman",
                    "last_name": "Perera",
                    "email": "samanp@gmail.com",
                    "phone": "0771234567",
                    "address": "No.1, Galle Road",
                    "city": "Colombo",
                    "country": "Sri Lanka"
                };
                payhere.startPayment(payment);
                
         }
        
        }
        xmlhttp.open("POST", "http://localhost/labour_link/customer/gethash.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        //send order_id and amount
        xmlhttp.send("order_id="+booking_id+"&amount="+amount);
        
        

        
    }
    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        console.log("Payment completed. OrderID:" + orderId);
        //Reload Window
        window.location.reload();

    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        console.log("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
        console.log("Error:"  + error);
    };
    var merchant_id = "1221879";    



   
</script>



</body>