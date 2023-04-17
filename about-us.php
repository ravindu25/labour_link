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
<?php include_once './components/navbar.php' ?>
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
    <div class="left-column">
        <h3>About us</h3>
        <p>We are a group of Second Year Computer Science undergraduates from University of Colombo School of Computing
            aspiring to become professionals in the field of Software Development.
            We have gained a solid foundation in programming languages, data structures,
            algorithms, and computer systems. We have also been exposed to various software development methodologies,
            such as agile and waterfall, and have worked on projects that involve software design, development,
            testing, and deployment. </p>
    </div>
    <div class="right-column">
        <h3> </h3>
        <p>
            Furthermore, participation in various hackathons, coding competitions and workshops,
            have helped us to enhance our problem-solving skills and creativity in software development.
            We are passionate about building innovative software solutions that solve real-world problems and make a positive
            impact on society.
            As we continue our education and journey towards becoming professionals in the field of software development,
            we are eager to gain more experience, expand our knowledge and skills, and contribute to the development of cutting-edge
            software applications. We believe that our dedication, hard work, and passion for software development will enable us to
            achieve our goals and make a difference in the industry.
        </p>
    </div>
</div>
    <div class="details-container">
        <div class="left-column">
            <img src="./assets/about-us/software-image.jpg">
        </div>
        <div class="right-column">
            <h3>About Labour Link</h3>
            <p>
                LABOUR LINK is a software solution that addresses the difficulties people face
                in finding different types of labour.
                Whether you are looking for someone to do housekeeping, gardening, plumbing, or
                electrical work, LABOUR LINK makes it easy for you to find and book a skilled worker.<br>

                Gone are the days of having to go through countless directories, classified ads, or
                word-of-mouth recommendations to find someone to perform a specific task. With LABOUR LINK,
                you can browse a list of available labourers, view their profiles, ratings, and reviews,
                and select the one that best suits your needs.<br>

                Our software is user-friendly, secure, and reliable. We have implemented features
                'such as real-time tracking, online payments, and customer support to ensure that
                the entire process of booking a labourer is seamless and hassle-free. <br>

                By using LABOUR LINK, you can save time, effort, and money. You no longer have to waste
                your valuable time searching for labourers or negotiating prices. Our platform offers
                competitive rates, and you can rest assured that the labourers you book through LABOUR
                LINK are trustworthy, skilled, and professional. <br>

                We are proud of LABOUR LINK and believe that it has the potential to revolutionize
                the way people book labourers. Whether you are a homeowner, a business owner, or a
                contractor, LABOUR LINK is the ultimate solution to your labour needs. Try it today
                and experience the convenience of booking a labourer from the comfort of your own home.<br><br>
            </p>
        </div>
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



