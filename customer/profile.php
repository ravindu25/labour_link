<?php
    session_start();
    // Check whether customer is logged in
    if (!isset($_SESSION['username']) || $_SESSION['user_type'] != 'Customer') {
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
    <link href="../styles/customer/customer-profile.css" rel="stylesheet"/>
    <title>Customer Profile | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="profile-change-modal-container" id="profile-change-modal-container">
    <div class="change-profile-page">
        <div class="change-profile-banner">
            <h1>Change your  profile picture now!</h1>
        </div>
        <div class="current-picture-container" id="current-picture-container">
            <?php
                echo "<img src='../assets/profile-image/customer-$userId.png' alt='profile-image' />";
            ?>
        </div>
        <div class="select-image-container" id="select-image-container">
            <input type="file" class="upload-box" id="picture-upload-input" />
        </div>
        <div class="profile-change-button-container">
            <button type="button" class="primary-button" id="set-default-button">
                <i class="fa-solid fa-arrow-up-from-bracket"></i>&nbsp;&nbsp;Set default
            </button>
            <button type="button" class="primary-outline-button" onclick="closeChangeProfileModal()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
            <button type="button" class="primary-button" id="remove-picture-button" onclick="goNextProfileChangePage()">
                <i class="fa-solid fa-trash-can"></i>&nbsp;&nbsp;Remove picture
            </button>
            <button type="button" class="disable-button" id="save-button" onclick="updateProfilePicture()">
                <i class="fa-solid fa-arrow-up"></i>&nbsp;&nbsp;Save picture
            </button>
        </div>
    </div>
</div>
<div class="success-message-container" id="profile-update-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Profile picture updated!</h1>
</div>
<div class="failed-message-container" id="profile-update-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Profile picture update failed!</h1>
        <h5 id="housing-create-fail-text">Your login session outdated. Please login again.</h5>
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
                <div class="sidebar-item">
                    <i class="fa-regular fa-credit-card sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Payments</h4>
                </div>
            </a>
            <a href="./profile.php">
                <div class="sidebar-item sidebar-item-selected">
                    <i class="fa-regular fa-circle-user sidebar-item-icon"></i>
                    <h4 class="sidebar-icon-heading">Profile</h4>
                </div>
            </a>
        </div>
    </section>
    <section class="main-content">
        <div class="main-heading">
            <h1>All Your <u>Account</u> Settings!</h1>
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
        <div class="profile-details-container">
            <div class="profile-image-container">
                <div class="profile-image">
                    <?php
                        echo "
                            <img src='../assets/profile-image/customer-$userId.png' alt='profile-image' />
                        ";
                    ?>
                    <div class="profile-change-container">
                        <button type="button" id="profile-change-button" class="primary-button" onclick="openChangeProfileModal()">
                            <i class="fa-solid fa-shuffle"></i>&nbsp;Change profile
                        </button>
                    </div>
                </div>
            </div>
            <div class="profile-details-panel">
                <?php
                    require_once('../db.php');

                    $sql_get_details = "SELECT * FROM User WHERE User_ID = $userId";
                    $result = $conn->query($sql_get_details);

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            $username = $row['First_Name'] . ' ' . $row['Last_Name'];
                            $email = $row['Email'];
                            $contactNum = $row['Contact_No'];
                            $nic = $row['NIC'];
                            $address = $row['User_Address'];
                            $activationFlag = $row['Activation_Flag'];
                        }
                    }
                ?>
                <h1><?php echo $username ?></h1>
                <h3><?php echo $email ?></h3>
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
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/customer-profile.js" type="text/javascript"></script>
</body>