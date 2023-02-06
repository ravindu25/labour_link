<?php
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
    <link href="../styles/worker/index.css" rel="stylesheet"/>
    <title>Workers | LabourLink</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

</head>
<body>
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
<section class="worker-banner" style="background-image: url(
            <?php echo '../assets/worker/worker-type-images/' . $workerType . ".jpg" ?>
        )">
</section>
<section class="main-title-container">
    <h1 class="main-title">
        <?php echo ucfirst($workerType). "s" ?>
        &nbsp;<i class="fa-solid fa-arrow-down"></i>
    </h1>
</section>
<section class="main-content">
    <div class="worker-section">
        <h1 class="worker-section-title">Top workers</h1>
        <div class="worker-card-container">
            <div class="worker-card">
                <h1 class="worker-card-title">Saman Gunawardhana</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Negombo</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                    <div class="worker-type-badge">
                        <h5>Plumber</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Sunil Perera</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Colombo</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Sunith Hettiarachchi</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Matara</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                    <div class="worker-type-badge">
                        <h5>Mason</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Dammika Kumara</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Kalutara</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
        </div>
        <div class="button-container">
            <button type="button" class="more-button">Load more&nbsp;
                <i class="fa-solid fa-arrow-down"></i></button>
        </div>
    </div>
    <div class="worker-section">
        <h1 class="worker-section-title">Workers nearby</h1>
        <div class="worker-card-container">
            <div class="worker-card">
                <h1 class="worker-card-title">Saman Gunawardhana</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Negombo</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                    <div class="worker-type-badge">
                        <h5>Plumber</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Sunil Perera</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Colombo</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Sunith Hettiarachchi</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Matara</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                    <div class="worker-type-badge">
                        <h5>Mason</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
            <div class="worker-card">
                <h1 class="worker-card-title">Dammika Kumara</h1>
                <div class="worker-card-star-container">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-stroke"></i>
                    <i class="fa-regular fa-star"></i>
                    <i class="fa-regular fa-star"></i>
                    &nbsp;&nbsp; 2.5
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-1.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;Kalutara</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <button type="button" class="view-profile-button">Profile</button>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>
        </div>
        <div class="button-container">
            <button type="button" class="more-button">Load more&nbsp;
                <i class="fa-solid fa-arrow-down"></i></button>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="footer-row">
        <div class="footer-column">
            <img src="../assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="footer-column">
            <h4>Learn More</h4>
            <ul>
                <li><a href="#" class="footer-more-link">About Labour Link</a></li>
                <li><a href="#" class="footer-more-link">Press Releases</a></li>
                <li><a href="#" class="footer-more-link">Environment</a></li>
                <li><a href="#" class="footer-more-link">Jobs</a></li>
                <li><a href="#" class="footer-more-link">Privacy Policy</a></li>
                <li><a href="#" class="footer-more-link">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h4>Contact Us</h4>
            <table>
                <tr>
                    <td>Mohamed Izzath:</td>
                    <td>+94 76 450 4261</td>
                </tr>
                <tr>
                    <td>Ravindu Wegiriya:</td>
                    <td>+94 71 999 9455</td>
                </tr>
                <tr>
                    <td>Dhananga Deepanjana:</td>
                    <td>+94 70 530 4401</td>
                </tr>
            </table>
        </div>
        <div class="footer-column">
            <h4>Social Media</h4>
            <p>@labourlink</p>
            <div class="social-container">
                <a href="#" class="social-link">
                    <img src="../assets/svg/socials/facebook-f.svg" alt="facebook" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="../assets/svg/socials/instagram.svg" alt="instagram" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="../assets/svg/socials/twitter.svg" alt="twitter" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="../assets/svg/socials/youtube.svg" alt="youtube" class="social-icon" />
                </a>
            </div>
        </div>
    </div>
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
</body>
</html>