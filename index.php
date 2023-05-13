<?php
    session_start();
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
    <link href="./styles/index-page.css" rel="stylesheet"/>
    <title>LabourLink</title>

     <!--Fontawesome-->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

</head>
<body>
<div class="loader-backdrop"></div>
<div class="loader"></div>
<?php include_once './components/navbar.php' ?>
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
                <?php
                    require_once('./db.php');
                    $sql_get_plumber_count = "SELECT COUNT(Plumber_ID) AS Count FROM Plumber WHERE Active = 1";

                    $result = $conn->query($sql_get_plumber_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=plumber">
                    <button type="button" class="card-button">Plumbing</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/carpentry-image.jpg" alt="Carpentry" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_carpenter_count = "SELECT COUNT(Carpenter_ID) AS Count FROM Carpenter WHERE Active = 1";

                    $result = $conn->query($sql_get_carpenter_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=carpenter">
                    <button type="button" class="card-button">Carpentry</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/electrical-image.jpg" alt="Electrical" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_electrical_count = "SELECT COUNT(Electrician_ID) AS Count FROM Electrician WHERE Active = 1";

                    $result = $conn->query($sql_get_electrical_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=electrician">
                    <button type="button" class="card-button">Electrical</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/painting-image.jpg" alt="Painting" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_painter_count = "SELECT COUNT(Painter_ID) AS Count FROM Painter WHERE Active = 1";

                    $result = $conn->query($sql_get_painter_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=painter">
                    <button type="button" class="card-button">Painting</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/masonry-image.jpg" alt="Masonry" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_mason_count = "SELECT COUNT(Mason_ID) AS Count FROM Mason WHERE Active = 1";

                    $result = $conn->query($sql_get_painter_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=mason">
                    <button type="button" class="card-button">Masonry</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/janitor-image.jpg" alt="Janitorial" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_janitor_count = "SELECT COUNT(Janitor_ID) AS Count FROM Janitor WHERE Active = 1";

                    $result = $conn->query($sql_get_janitor_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=janitor">
                    <button type="button" class="card-button">Janitorial</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/mechanical-image.jpg" alt="Mechanical" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_mechanic_count = "SELECT COUNT(Mechanic_ID) AS Count FROM Mechanic WHERE Active = 1";

                    $result = $conn->query($sql_get_mechanic_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=mechanic">
                    <button type="button" class="card-button">Mechanical</button>
                </a>
            </div>
        </div>
        <div class="job-card">
            <img src="./assets/job-card-image/gardening-image.jpg" alt="Gardening" class="job-card-image"/>
            <div class="card-text">
                <?php
                    require_once('./db.php');
                    $sql_get_mechanic_count = "SELECT COUNT(Gardener_ID) AS Count FROM Gardener WHERE Active = 1";

                    $result = $conn->query($sql_get_mechanic_count);
                    if($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $count = ceil($row['Count'] / 5) * 5;
                            echo "<p>$count+ Workers Available</p>";
                        }
                    }
                ?>
                <a href="worker/index.php?workertype=gardener">
                    <button type="button" class="card-button">Gardening</button>
                </a>
            </div>
        </div>
    </div>
</section>
<section class="housing-section">
    <div class="left-panel"></div>
    <div class="right-panel">
        <div class="housing-content">
            <h1>Looking for appropriate labour to build your dream house?</h1>
            <h3>Labour Link provides housing construction packages to fulfill your needs</h3>
            <div class="housing-content-button-container">
                <a href="./customer/housing.php">
                    <button class="primary-button" type="button"><i class="fa-solid fa-house-user"></i>&nbsp;&nbsp;Learn More</button>
                </a>
            </div>
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
                    <img src="../assets/svg/socials/facebook-f.svg" alt="facebook" class="social-icon" />
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