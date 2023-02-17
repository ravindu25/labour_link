<?php
    include_once('../db.php');
    $workerType = $_GET['workertype'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS files -->
    <link href="../styles/index-page.css" rel="stylesheet"/>
    <link href="../styles/worker/worker-profile.css" rel="stylesheet"/>
    <title>Workers | LabourLink</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

    <!-- Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="../assets/svg/user-check-solid.svg" alt="house icon" class="register-select-icon" />
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/labour-type.svg" alt="worker" class="reg-type-image" />
            <button type="button" onclick="window.location.href='../worker-registration.php'" class="card-button">Worker</button>
        </div>
        <div class="reg-type-card">
            <img src="../assets/home-page/job-type/customer-type.svg" alt="customer" class="reg-type-image" />
            <button type="button" onclick="window.location.href='../customer-registration.php'" class="card-button">Customer</button>
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
            <?php }else{ ?>
                <div class="nav-link-items">
                    <div class="dropdown" id="dropdown">
                        <button type="button" id="user-dropdown-button" onClick="opendropdown()"
                                class="nav-link-items-button"
                                style="background-color: #FFF; color: #102699;">
                            <i class="fa-regular fa-circle-user"></i>&nbsp;
                            <?php echo "Hi, ".$_SESSION['first_name']; ?>
                            &nbsp;
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-items" id="dropdown-items">
                            <?php
                            if($_SESSION['user_type'] == 'Admin'){
                                echo '<a href="../admin/dashboard.php">';
                            }else if($_SESSION['user_type'] == 'Customer'){
                                echo '<a href="../customer/dashboard.php">';
                            }else{
                                echo '<a href="../worker/dashboard.php">';
                            }
                            ?>
                            <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                            </div>
                            </a>
                            <a href="#">
                                <a href="../logout.php">
                                    <div class="dropdown-item" id="dropdown-item">
                                        <i class="fa-solid fa-right-from-bracket"></i>
                                        &nbsp;&nbsp;Logout
                                    </div>
                                </a>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>

</body>
</html>