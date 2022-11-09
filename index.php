<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS files -->
    <link href="./styles/index-page.css" rel="stylesheet"/>
    <title>LabourLink</title>
</head>
<body>
<div class="register-select-modal" id="register-modal">
</div>
<div class="register-select-content" id="register-modal-content">
    <div class="register-select-heading">
        <img src="./assets/svg/user-check-solid.svg" alt="house icon" class="register-select-icon" />
        <h1>Select registration type</h1>
    </div>
    <div class="reg-type-container">
        <div class="reg-type-card">
            <img src="./assets/home-page/job-type/labour-type.svg" alt="worker" class="reg-type-image" />
            <button type="button" onclick="window.location.href='worker-registration.php'" class="card-button">Worker</button>
        </div>
        <div class="reg-type-card">
            <img src="./assets/home-page/job-type/customer-type.svg" alt="customer" class="reg-type-image" />
            <button type="button" onclick="window.location.href='customer-registration.php'" class="card-button">Customer</button>
        </div>
    </div>
</div>
<nav class="nav-bar">
    <div class="nav-bar-items">
        <div class="logo-container">
            <img src="./assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
        </div>
        <div class="search-container">
            <div class="search-icon-container">
                <img src="./assets/svg/search.svg" alt="search" class="search-icon"/>
            </div>
            <input type="text" class="search-bar-input" placeholder="Search for a labourer or a service"/>
        </div>
        <div class="nav-link-container">
            <div class="nav-link-items"><a href="#" class="nav-links">Home</a></div>
            <div class="nav-link-items">
                <select name="jobs" class="nav-select">
                    <option value="jobs" selected>Jobs</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="carpentry">Carpentry</option>
                    <option value="electrical">Electrical</option>
                    <option value="painting">Painting</option>
                    <option value="masonry">Masonry</option>
                    <option value="janitorial">Janitorial</option>
                    <option value="mechanical">Mechanical</option>
                    <option value="gardening">Gardening</option>
                </select>
            </div>
            <div class="nav-link-items"><a href="#" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="#" class="nav-links">Contact Us</a></div>
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
                            <?php echo $_SESSION['username']; ?>
                            &nbsp;
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-items" id="dropdown-items">
                            <a href="#">
                                <div class="dropdown-item" id="dropdown-item"><i class="fa-solid fa-gauge-high"></i>&nbsp;&nbsp;Dashboard
                                </div>
                            </a>
                            <a href="#">
                                <div class="dropdown-item" id="dropdown-item">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    &nbsp;&nbsp;Logout
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</nav>
<section class="banner">
    <div class="banner-container">
        <p class="banner-content">Providing the <b>best service</b>, the <b>best way</b></p>
    </div>
</section>
<section class="job-section">
    <div class="job-section-heading">
        <h1>A collection of services we provide</h1>
        <img src="./assets/svg/arrow-down-solid.svg" alt="down array" class="job-arrow-down"/>
    </div>
    <div class="card-container">
        <div class="job-card">
            <img src="./assets/job-card-image/plumbing-image.jpg" alt="Plumbing" class="job-card-image"/>
            <div class="card-text">
                <p>20+ Labour Available</p>
                <button type="button" class="card-button">Plumbing</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/carpentry-image.jpg" alt="Carpentry" class="job-card-image"/>
            <div class="card-text">
                <p>35+ Labour Available</p>
                <button type="button" class="card-button">Carpentry</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/electrical-image.jpg" alt="Electrical" class="job-card-image"/>
            <div class="card-text">
                <p>15+ Labour Available</p>
                <button type="button" class="card-button">Electrical</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/painting-image.jpg" alt="Painting" class="job-card-image"/>
            <div class="card-text">
                <p>55+ Labour Available</p>
                <button type="button" class="card-button">Painting</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/masonry-image.jpg" alt="Masonry" class="job-card-image"/>
            <div class="card-text">
                <p>40+ Labour Available</p>
                <button type="button" class="card-button">Masonry</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/janitor-image.jpg" alt="Janitorial" class="job-card-image"/>
            <div class="card-text">
                <p>60+ Labour Available</p>
                <button type="button" class="card-button">Janitorial</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/mechanical-image.jpg" alt="Mechanical" class="job-card-image"/>
            <div class="card-text">
                <p>40+ Labour Available</p>
                <button type="button" class="card-button">Mechanical</button>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/gardening-image.jpg" alt="Gardening" class="job-card-image"/>
            <div class="card-text">
                <p>20+ Labour Available</p>
                <button type="button" class="card-button">Gardening</button>
            </div>
        </div>
    </div>
</section>
<section class="housing-section">
    <div class="left-panel"></div>
    <div class="right-panel">
        <div class="housing-heading">
            <h1>Housing packages</h1>
        </div>
        <div class="housing-content">
            <div class="housing-content-first">
                <p>Looking for appropriate labour to build your dream house?</p>
                <p>In need of efficient technicians for successful completion a house built halfway through?</p>
            </div>
            <div class="housing-content-second">
                <p><b>Labour Link</b> provides housing construction packages to fulfill your needs.</p>
            </div>
            <button type="button" class="housing-content-button">Learn more&nbsp;&nbsp;<img src="./assets/svg/house-user-solid.svg" alt="housing" class="housing-content-button-image"/></button>
        </div>
    </div>
</section>
<section class="feedback-section">
    <div class="feedback-heading-container">
        <img src="./assets/svg/thumbs-up-regular.svg" alt="like" class="feedback-thumbsup-icon"/>
        <h1>Happy customer feedback</h1>
    </div>
    <div class="feedback-container">
        <div class="feedback-card">
            <p class="feedback-text">
                Thanks to Labour Link, I got to complete the construction of my house with lesser hassle than expected.
            </p>
            <div class="feedback-author-container">
                <img src="./assets/svg/face-smile-regular.svg" alt="simile" class="feedback-smile-icon"/>
                <p class="feedback-author">
                    Mark Andrew
                </p>
            </div>
        </div>
        <div class="feedback-card">
            <p class="feedback-text">
                Labour Link is one of the fastest and cheapest ways of finding quality labour. I would recommend it to anyone who’s looking for quality services within a short span of time.
            </p>
            <div class="feedback-author-container">
                <img src="./assets/svg/face-smile-regular.svg" alt="simile" class="feedback-smile-icon"/>
                <p class="feedback-author">
                    Anderson Thomas
                </p>
            </div>
        </div>
        <div class="feedback-card">
            <p class="feedback-text">
                With the introduction of Labour Link, looking for appropriate labour for various services is no longer a tedious task.
            </p>
            <div class="feedback-author-container">
                <img src="./assets/svg/face-smile-regular.svg" alt="simile" class="feedback-smile-icon"/>
                <p class="feedback-author">
                    Harry James
                </p>
            </div>
        </div>
    </div>
</section>
<footer class="footer">
    <div class="footer-row">
        <div class="footer-column">
            <img src="./assets/logo-croped.png" alt="labourlink logo" class="labour-link-logo"/>
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
                    <img src="./assets/svg/socials/facebook-f.svg" alt="facebook" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="./assets/svg/socials/instagram.svg" alt="instagram" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="./assets/svg/socials/twitter.svg" alt="twitter" class="social-icon" />
                </a>
                <a href="#" class="social-link">
                    <img src="./assets/svg/socials/youtube.svg" alt="youtube" class="social-icon" />
                </a>
            </div>
        </div>
    </div>
    <div class="footer-row" style="border-top: 1px solid #FFF; padding-top: 16px;">
        <p>© 2022 Labour Link | All Rights Reserved</p>
    </div>
</footer>
<script src="./scripts/modals.js" type="text/javascript"></script>
<script src="./scripts/index.js" type="text/javascript"></script>
</body>
</html>