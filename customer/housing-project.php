<?php
    session_start();
    require_once('../db.php');
    // Check whether customer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Customer') {
        header("Location: ../login.php");
    }
    $userId = $_SESSION['user_id'];
    $houseId = null;

    if(isset($_GET['houseId'])){
        $houseId = $_GET['houseId'];

        // Check whether given house id is created by current logged in customer
        $sql_get_customer_id = "SELECT Customer_ID FROM House WHERE House_ID = $houseId";

        $result = $conn->query($sql_get_customer_id);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['Customer_ID'] != $userId) header("Location: ../login.php");
            }
        } else {
            header("Location: ./housing.php");
        }
    } else {
        header("Location: ./housing.php");
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
    <link href="../styles/customer/housing-project.css" rel="stylesheet" />
    <title>Housing Project | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="mark-done-confirm-container" id="mark-done-confirm-container">
    <h1>Do you want to mark the job as complete?</h1>
    <div class="mark-done-button-container">
        <button class="mark-done-secondary-button" onclick="hideMarkDoneContainer()">Cancel</button>
        <button class="mark-done-primary-button" id="mark-done-button"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Mark completed!</button>
    </div>
</div>
<div class="mark-done-complete-container" id="mark-done-complete-container">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;The selected job is marked as completed</h1>
</div>
<div class="mark-done-failed-container" id="mark-done-failed-container">
    <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Marking job as complete failed!</h1>
    <h5 id="mark-done-fail-text">Your login session outdated. Please login again.</h5>
</div>
<div class="create-advertise-container" id="create-advertise-container">
    <h1>Do you want to place advertisement on the selected job?</h1>
    <div class="advertisement-create-image-container">
        <img src="../assets/customer/housing/undraw_Social_sharing_re_pvmr.png" alt="create-advertisement" />
        <h5>Once advertisement is placed workers can apply for your job!</h5><br>
        
        <h5>How many workers do you need?</h5>
        <input type="text" class="worker-amount-input" id="worker-amount-input"/>
    </div>
    <div class="create-advertisement-button-container">
        <button class="create-advertisement-secondary-button" onclick="hideAdvertisementContainer()">Cancel</button>
        <button class="create-advertisement-primary-button" id="place-advertisement-button"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Place advertisement!</button>
    </div>
</div>
<div class="advertise-complete-container" id="advertise-complete-container">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Advertisement placed successfully!</h1>
</div>
<div class="advertise-failed-container" id="advertise-failed-container">
    <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Advertisement placing is failed!</h1>
    <h5 id=mark-done-fail-text">Your login session outdated. Please login again.</h5>
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
                <div class="sidebar-item sidebar-item-selected">
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
            <h1>All About Your <u>Housing Project</u> Here!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <?php
            // Getting the details about the housing project
            $sql_get_details = "SELECT * FROM House WHERE House_ID = $houseId";

            $result = $conn->query($sql_get_details);
            $address = null;
            $paid = null;

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $address = $row['Address'];
                    $paid = $row['Paid'];
                    $houseID = $row['House_ID'];
                    $payment_due_id = 001;
                }
            }
        ?>
        <div class="project-details-container">
            <h1>Project details</h1>
            <div class="project-details-row">
                <?php echo "<h5><i class='fa-solid fa-location-dot' style='color: var(--primary-bright-color)'></i>&nbsp;&nbsp;Address - $address</h5>" ?>
                <?php
                    if($paid == 0){
                        echo "<button type='button' class='primary-button' onclick='payNow($payment_due_id, $houseID, 500, \"$address\")'><i class='fa-solid fa-cart-shopping'></i>&nbsp;&nbsp;Add payment</button>";
                    }
                ?>
            </div>
        </div>
        <?php
        if($paid==1){
            echo(' <div class="project-progress-container">
            <h1>Current progress</h1>
            <div class="project-progress-row">' );
        }
        ?>
                <?php
                    if($paid == 1){
                       
                    $sql_get_completed_tasks = "SELECT COUNT(Job_Type_ID) AS Completed_Count FROM Job WHERE House_ID = $houseId AND Completion_Flag = 1";

                    $numCompleted = 0;

                    if($paid == 1) {
                        $result = $conn->query($sql_get_completed_tasks);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $numCompleted = $row['Completed_Count'];
                            }
                        }
                    } else {
                        $numCompleted = 0;
                    }

                    if($numCompleted < 10) {
                        $progressbarWidth = ceil(650 * ($numCompleted / 10)) . 'px';
                        $percentage = ceil(100 * ($numCompleted / 10));

                        echo "
                        <div class='progress-bar-container'>
                            <div class='progress-bar' style='width: $progressbarWidth'></div>
                        </div>
                        <h5>$percentage%</h5>
                        ";
                    } else {
                        echo "
                        <div class='progress-bar-container' style='border-color: var(--success-color)'>
                            <div class='progress-bar' style='width: 100%; background-color: var(--success-color)' ></div>
                        </div>
                        <h5>Completed</h5>
                        ";
                    };
                }
       
                ?>

            </div>
        </div>
    
        <div class="project-tasks-container">
            <?php
            if($paid==1){
                echo('<h1>Ongoing tasks</h1>');
            }
            
            ?>
            <div class="project-tasks-list">
            <?php if($paid == true){
                $sql_get_all_tasks = "SELECT Job.*, Job_Type.* FROM Job INNER JOIN Job_Type ON Job.Job_Type_ID = Job_Type.Job_Type_ID WHERE Job.House_ID = $houseId ORDER BY Completion_Flag";

                $result = $conn->query($sql_get_all_tasks);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $jobID = $row['Job_Type_ID'];
                        $description = $row['Description'];
                        $completionFlag = $row['Completion_Flag'];
                        $advertisementStatus = $row['Advertisement_Status'];
                        $bookingId = $row['Booking_ID'];

                        $completionButton = null;
                        $advertisementButton = null;
                        $bookingButton = null;
                        $buttonHtml = null;

                        $className = 'project-task-item';

                        if($completionFlag == true){
                            $className = $className . ' completed-tasks';
                        }

                        if($completionFlag == true){
                            $completionButton = "<button class='completed-button'><i class='fa-solid fa-check'></i>&nbsp;&nbsp;Completed</button>";

                            $buttonHtml = $completionButton;
                        } else {
                            if($advertisementStatus == true && $bookingId != null){
                                $completionButton = "<button class='mark-complete-button' onclick='showMarkDoneContainer($jobID, $houseId)'><i class='fa-solid fa-check'></i>&nbsp;&nbsp;Mark done</button>";

                                $bookingButton = "<button class='view-booking-button'><i class='fa-solid fa-arrow-up-right'></i>&nbsp;&nbsp;View Booking</button>";

                                $buttonHtml = $advertisementButton . $bookingButton;
                            } else if($advertisementStatus == true && $bookingId == null) {
                                $completionButton = "<button class='mark-complete-button' onclick='showMarkDoneContainer($jobID, $houseId)'><i class='fa-solid fa-check' ></i>&nbsp;&nbsp;Mark done</button>";

                                $advertisementButton = "<button class='advertised-button'><i class='fa-solid fa-chart-simple'></i>&nbsp;&nbsp;Advertised</button>";

                                $buttonHtml = $completionButton . $advertisementButton;
                            } else {
                                $completionButton = "<button class='mark-complete-button' onclick='showMarkDoneContainer($jobID, $houseId)'><i class='fa-solid fa-check'></i>&nbsp;&nbsp;Mark done</button>";

                                $advertisementButton = "<button class='advertise-button' onclick='showAdvertisementContainer($houseId, $jobID)'><i class='fa-solid fa-chart-simple'></i>&nbsp;&nbsp;Advertise</button>";

                                $buttonHtml = $completionButton . $advertisementButton;
                            }
                        }

                        echo "
                            <div class='$className'>
                                <div class='task-item-details'>
                                    <h5>$description</h5>
                                </div>
                                <div class='task-item-buttons'>
                                    $buttonHtml
                                </div>
                            </div>
                        ";
                    }
                } ?>
            </div>
            <div class="project-tasks-button-container">
                <button class="primary-button" onclick="switchTaskList()" id="task-show-button"><i class="fa-solid fa-arrow-down"></i>&nbsp;&nbsp;Show completed</button>
            </div>
            <?php } else { ?>
                <div class='empty-tasks-container'>
                    <img src='../assets/customer/housing/undraw_task_list_6x9d.svg' alt='project-jobs' />
                    <h5>You haven't paid for the current project. Please add your payment and activate the project.</h5>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<?php
    echo "
        <script>
            let userId = $userId;
        </script>
    ";
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/housing-project.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<script>

    function payNow(payment_due_id, house_id, amount, house_address){
        var merchant_id = "1221879";    
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
                    "notify_url": "https://ravinduwegiriya.com/authorize_payment_house.php",
                    "order_id": house_id,
                    "items": "Payment to Housing Project at "+house_address,
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
        xmlhttp.send("order_id="+house_id+"&amount="+amount);
        
        

        
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




   
</script>
</body>
