<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS files -->
    <link href="styles/index-page.css" rel="stylesheet"/>
    <link href="styles/worker-index.css" rel="stylesheet"/>
    <title>LabourLink</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

</head>
<body>
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="assets/svg/user-check-solid.svg" alt="house icon" class="register-select-icon" />
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="assets/home-page/job-type/labour-type.svg" alt="worker" class="reg-type-image" />
            <button type="button" onclick="window.location.href='worker-registration.php'" class="card-button">Worker</button>
        </div>
        <div class="reg-type-card">
            <img src="assets/home-page/job-type/customer-type.svg" alt="customer" class="reg-type-image" />
            <button type="button" onclick="window.location.href='customer-registration.php'" class="card-button">Customer</button>
        </div>
    </div>
</div>
<div class="loader-backdrop"></div>
<div class="loader"></div>
<nav class="nav-bar">
    <div class="nav-bar-items">
        <div class="logo-container">
            <img src="assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="search-container">
            <div class="search-icon-container">
                <img src="assets/svg/search.svg" alt="search" class="search-icon"/>
            </div>
            <input type="text" class="search-bar-input" placeholder="Search for a labourer or a service"/>
        </div>
        <div class="nav-link-container">
            <div class="nav-link-items"><a href="index.php" class="nav-links">Home</a></div>
            <div class="nav-link-items"><a href="./about-us.php" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="contact-us.php" class="nav-links">Contact Us</a></div>
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
                                echo '<a href="admin/dashboard.php">';
                            }else if($_SESSION['user_type'] == 'Customer'){
                                echo '<a href="customer/dashboard.php">';
                            }else{
                                echo '<a href="worker/dashboard.php">';
                            }
                            ?>
                            <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                            </div>
                            </a>
                            <a href="#">
                                <a href="logout.php">
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
<section class="worker-index-banner">
    <div class="banner-container">
        <p class="worker-index-banner-content"> <b>Electricians</b> </p>
    </div>
</section>
<section class="heading-container">
    <div class="heading">Top workers</div>
    <div class="worker-profile-card-container">
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Saman Gunawardana</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Negombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Electrician</p></div>
                <div class="worker-type"><p>Plumber</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Dinesh Attanayake</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Colombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Painter</p></div>
                <div class="worker-type"><p>Mason</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p>Pasan Hettiarachi</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Malabe </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Gardener</p></div>
                <div class="worker-type"><p>Carpenter</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Frederick Peterson</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Bambalapitiya </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Mechanic</p></div>
                <div class="worker-type"><p>Plumber</p></div>
                <div class="worker-type"><p>Painter</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
    </div>
    <div class="load-more-container">
        <div class="load-more-button">
            <p>Load More</p>
        </div>
    </div>
</section>
<section class="heading-container">
    <div class="heading"> Workers nearby </div>
    <div class="worker-profile-card-container">
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Saman Gunawardana</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Negombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Electrician</p></div>
                <div class="worker-type"><p>Plumber</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Saman Gunawardana</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Negombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Electrician</p></div>
                <div class="worker-type"><p>Plumber</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Saman Gunawardana</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Negombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Electrician</p></div>
                <div class="worker-type"><p>Plumber</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
        <div class="worker-profile-card">
            <div class="worker-profile-name-container">
                <div class="worker-profile-name">
                    <p> Saman Gunawardana</p>
                </div>
            </div>
            <div class="star-rating-container">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-half-stroke-solid.svg" class="star-vector">
                <img src="./assets/worker-index/star-regular.svg" class="star-vector">
                <div class="star-rating">3.5</div>
            </div>
            <img src="./assets/worker-index/worker-profile-image.jpg" class="worker-profile-image"/>
            <div class="worker-location-container">
                <img src="./assets/worker-index/location-dot-solid.svg" class="worker-location-vector">
                <div class="worker-location-text"> Negombo </div>
            </div>
            <div class="worker-type-container">
                <div class="worker-type"><p>Electrician</p></div>
                <div class="worker-type"><p>Plumber</p></div>
            </div>
            <div class="view-profile-button"><p>View Profile</p></div>
        </div>
    </div>
    <div class="load-more-container">
        <div class="load-more-button">
            <p>Load More</p>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="footer-row">
        <div class="footer-column">
            <img src="assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
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
                    <img src="assets/svg/socials/facebook-f.svg" alt="facebook" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="assets/svg/socials/instagram.svg" alt="instagram" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="assets/svg/socials/twitter.svg" alt="twitter" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="assets/svg/socials/youtube.svg" alt="youtube" class="social-icon" />
                </a>
            </div>
        </div>
    </div>
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
</body>
</html>