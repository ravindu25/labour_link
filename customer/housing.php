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
    <link href="../styles/customer/customer-housing.css" rel="stylesheet" />
    <title>Housing | LabourLink</title>
</head>
<body>
<div class="backdrop-modal" id="backdrop-modal">
</div>
<div class="housing-create-container" id="housing-create-container">
    <div class="housing-create-page" id="housing-create-first-page">
        <div class="housing-create-banner-container">
            <h1>Start you're own housing project</h1>
            <img src="../assets/customer/housing/housing-project-create.png" alt="housing-banner" />
        </div>
        <div class="housing-create-page-container">
            <div class="housing-create-page-row">
                <h5>House address(Supported by google locations)&nbsp;&nbsp;<i class="fa-solid fa-location-dot"></i></h5>
                <input type="text" id="place-autocomplete" class="housing-create-page-text-input" />
            </div>
            <div class="button-container">
                <button class="secondary-button" onclick="closeHousingCreateModal()">Cancel</button>
                <button class="primary-button" id="first-page-next-button" onclick="goToSecondHousingPage()">Next&nbsp;&nbsp;<i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
    </div>
    <div class="housing-create-page" id="housing-create-second-page">
        <h1>Select jobs that you need to complete</h1>
        <div class="housing-create-tasks-container">
            <label>
                <input type="checkbox" name="job-selection" value="job-1" class="job-selection-input" />
                <div class="job-selection-container">
                    <i class="fa-solid fa-1"></i>
                    <h3>Build the foundation of the house</h3>
                </div>
            </label>
            <label>
                <input type="checkbox" name="job-selection" value="job-2" class="job-selection-input" />
                <div class="job-selection-container">
                    <i class="fa-solid fa-2"></i>
                    <h3>Constructing the frame of the house, which includes the walls, roof, and floors</h3>
                </div>
            </label>
            <label>
                <input type="checkbox" name="job-selection" value="job-3" class="job-selection-input" />
                <div class="job-selection-container">
                    <i class="fa-solid fa-3"></i>
                    <h3>Plumbing, electrical, and HVAC</h3>
                </div>
            </label>
            <label>
                <input type="checkbox" name="job-selection" value="job-4" class="job-selection-input" />
                <div class="job-selection-container">
                    <i class="fa-solid fa-4"></i>
                    <h3>Interior finishes(flooring, cabinets, countertops, and paint)</h3>
                </div>
            </label>
            <label>
                <input type="checkbox" name="job-selection" value="job-5" class="job-selection-input" />
                <div class="job-selection-container">
                    <i class="fa-solid fa-5"></i>
                    <h3>Exterior finishes(siding, roofing, and landscaping)</h3>
                </div>
            </label>
        </div>
        <div class="button-container">
            <button class="primary-button" onclick="goToFirstHousingPage()"><i class="fa-solid fa-arrow-left"></i>&nbsp;&nbsp;Back</button>
            <button class="secondary-button" onclick="closeHousingCreateModal()">Cancel</button>
            <button class="primary-button" onclick="submitHousing()"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Create</button>
        </div>
    </div>
</div>
<div class="success-message-container" id="housing-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Housing project placed successfully and we will verify it soon!</h1>
</div>
<div class="failed-message-container" id="housing-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Housing project creation failed!</h1>
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
            <h1>All About Your <u>Housing Projects</u> Here!</h1>
            <h5>Logged as <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?></h5>
        </div>
        <div class="new-housing">
            <h1>Do you want to start a new housing project?</h1>
            <button class="more-button" id="project-create-button" onclick="openHousingCreateModal()">Start Project</button>
        </div>
        <div class="current-projects">
            <h1>Ongoing housing projects</h1>
            <div class="empty-projects-container">
                <img src="../assets/customer/housing/undraw_house_searching_re_stk8.svg" alt="housing-projects" />
                <h5>You don't have any housing projects started</h5>
            </div>
            <div class="projects-container">

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
    echo "
        <script>
            let userId = $userId;
        </script>
    ";
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/customer/housing.js" type="text/javascript"></script>
<script async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLM5mz57abPBtltxNRDTnsovOtHYXZyCo&libraries=places&callback=initAutocomplete">
</script>
</body>
