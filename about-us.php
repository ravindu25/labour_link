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
    <link href="./styles/about-us.css" rel="stylesheet"/>
    <title>LabourLink | Contact Us</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>
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
            <div class="nav-link-items"><a href="./index.php" class="nav-links">Home</a></div>
            <div class="nav-link-items"><a href="./about-us.php" class="nav-links">About</a></div>
            <div class="nav-link-items"><a href="./contact-us.php" class="nav-links">Contact Us</a></div>
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
                                echo '<a href="./admin/dashboard.php">';
                            }else if($_SESSION['user_type'] == 'Customer'){
                                echo '<a href="./customer/dashboard.php">';
                            }else{
                                echo '<a href="./worker/dashboard.php">';
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
<div class="developer-container">
    <h1>Meet our team</h1>
    <div class="developers">
        <div class="developer">
            <img src="./assets/about-us/Ravindu.jpg">
            <h2>Ravindu Wegiriya</h2>
        </div>
        <div class="developer">
            <img src="./assets/about-us/Izzath.jpeg">
            <h2>Mohamed Izzath</h2>
        </div>
        <div class="developer">
            <img src="./assets/about-us/Rushdha.jpg">
            <h2>Rushdha Rasheed</h2>
        </div>
        <div class="developer">
            <img src="./assets/about-us/Dhananga.jpg">
            <h2>Dhananga Deepanjana</h2>
        </div>
    </div>
</div>
<div class="details-container">
        <p>We are a group of Second Year Computer Science undergraduates from University of Colombo School of Computing
            aspiring to become professionals in the field of Software Development.
            As computer science undergraduates, we have gained a solid foundation in programming languages, data structures,
            algorithms, and computer systems. <br><br>

            We have also been exposed to various software development methodologies, such as agile and waterfall, and have
            worked on projects that involve software design, development, testing, and deployment. <br><br>

            Furthermore, we have participated in various hackathons, coding competitions, and workshops, which have helped us
            to enhance our problem-solving skills and creativity in software development.
            We are passionate about building innovative software solutions that solve real-world problems and make a positive
            impact on society. <br><br>

            As we continue our education and journey towards becoming professionals in the field of software development,
            we are eager to gain more experience, expand our knowledge and skills, and contribute to the development of cutting-edge
            software applications. We believe that our dedication, hard work, and passion for software development will enable us to
            achieve our goals and make a difference in the industry.<br><br>
        </p>
    </div>
    <div class="details-container">
        <p>
            LABOUR LINK is a software solution that addresses the difficulties people face
            in finding different types of labour.
            Whether you are looking for someone to do housekeeping, gardening, plumbing, or
            electrical work, LABOUR LINK makes it easy for you to find and book a skilled worker.<br><br>

            Gone are the days of having to go through countless directories, classified ads, or
            word-of-mouth recommendations to find someone to perform a specific task. With LABOUR LINK,
            you can browse a list of available labourers, view their profiles, ratings, and reviews,
            and select the one that best suits your needs.<br><br>

            Our software is user-friendly, secure, and reliable. We have implemented features
            'such as real-time tracking, online payments, and customer support to ensure that
            the entire process of booking a labourer is seamless and hassle-free. <br><br>

            By using LABOUR LINK, you can save time, effort, and money. You no longer have to waste
            your valuable time searching for labourers or negotiating prices. Our platform offers
            competitive rates, and you can rest assured that the labourers you book through LABOUR
            LINK are trustworthy, skilled, and professional. <br><br>

            We are proud of LABOUR LINK and believe that it has the potential to revolutionize
            the way people book labourers. Whether you are a homeowner, a business owner, or a
            contractor, LABOUR LINK is the ultimate solution to your labour needs. Try it today
            and experience the convenience of booking a labourer from the comfort of your own home.<br><br>
        </p>
    </div>
</div>
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
<script src="./scripts/about-us.js" type="text/javascript"></script>
<script src="./scripts/modals.js" type="text/javascript"></script>
<script src="./scripts/index.js" type="text/javascript"></script>
</body>
</html>



