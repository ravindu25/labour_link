<?php
include_once('../db.php');
$workerID = null;
if(isset($_GET['workerId'])){
    $workerID=$_GET['workerId'];
}
$sql_get_workers_details = "Select User.*, Worker.* from User inner join Worker on User.User_ID = Worker.Worker_ID where Worker_ID=$workerID";

            $result = $conn->query($sql_get_workers_details);

            if($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $userId = $row['User_ID'];
                    $fullName = $row['First_Name'] . " " . $row['Last_Name'];
                    $city = $row['City'];
                    $currentRating = $row['Current_Rating'];

                    $imageNumber = rand(1, 4);
                    $imageUrl = "../assets/worker/profile-images/worker-$imageNumber.jpg";

                    $ratingHtml = null;
                    $tempRating = 0;
                    while ($tempRating < $currentRating) {
                        if ($tempRating + 1 <= $currentRating) {
                            $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star'></i>";
                            $tempRating += 1;
                        } else if ($tempRating + 0.5 <= $currentRating) {
                            $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star-half-stroke'></i>";
                            $tempRating += 0.5;
                        } else {
                            break;
                        }
                    }
                    $tempRating = ceil($tempRating);
                    while ($tempRating < 5) {
                        $ratingHtml = $ratingHtml . "<i class='fa-regular fa-star'></i>";
                        $tempRating += 1;
                    }
                }
            }
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
    <link href="../styles/worker/view-worker-profile.css" rel="stylesheet"/>
    <title>Workers | LabourLink</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

    <!-- Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
<div class="register-select-modal" id="register-modal"></div>
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
<div class="profile-container">
    <div class="profile-picture">
        <img src="../assets/worker/profile-images/worker-1.jpg">
    </div>
    <div class="profile-info">
        <h1><?=$fullName?></h1>
        <div class="subheading">WORKER BIO</div>
        <div class="details-row">
            Category :
            <div class="worker-type-badge">
                <h5>Electrician</h5>
            </div>
            <div class="worker-type-badge">
                <h5>Plumber</h5>
            </div>
            <div class='worker-card-location-row'>
                Location : <i class='fa-solid fa-location-dot' style='color: var(--primary-color)'></i> <b><?=$city?></b>
            </div>
            <?php
            echo
            "Rating :
            <div class='star-container'>
                   $ratingHtml
                   <b>$currentRating</b> 
            </div>"
            ?>
        </div>
        <div class="details-row">
            <div class = worker-description>
                Description :
                <p>Saman is an experienced electrician who has been working for more than 15 years in the field.
                    He is also a skilled and dedicated plumber who takes great pride in his work.
                    Saman has a reputation for being reliable, efficient, and always willing to go the extra mile to ensure that clients are satisfied with his plumbing services. </p>
            </div>
            <div class="button-container">
                <button type='button' class='booking-button'>Book now!</button>
            </div>
        </div>
    </div>
</div>
<div class="projects-container">
    <div class="subheading">PREVIOUSLY COMPLETED PROJECTS</div>
    <div class="details-row">
        <div class="project">
            <div class="project-img-container">
                <img class="project-img" src="../assets/job-card-image/carpentry-image.jpg"></img>
            </div>
            <div class="project-description">
                Project 1
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="star-container">
                    <p>
                        <?=$ratingHtml?>
                        2.7
                    </p>
                </div>
            </div>
        </div>
        <div class="project">
            <div class="project-img-container">
                <img class="project-img" src="../assets/job-card-image/carpentry-image.jpg"></img>
            </div>
            <div class="project-description">
                Project 2
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.                </p>
                <div class="star-container">
                    <p>
                        <?=$ratingHtml?>
                        2.5
                    </p>
                </div>
            </div>
        </div>
        <div class="project">
            <div class="project-img-container">
                <img class="project-img" src="../assets/job-card-image/carpentry-image.jpg"></img>
            </div>
            <div class="project-description">
                Project 3
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <div class="star-container">
                    <p>
                        <?=$ratingHtml?>
                        2.3
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="projects-container">
    <div class="subheading">CUSTOMER FEEDBACK</div>
    <div class="details-row">
        <div class="review">
            "John is a fantastic web developer. He is easy to work with and produces high-quality work. Highly recommend!"
            <p>- Jane Smith</p>
        </div>
        <div class="review">
            "John helped me build a beautiful and functional website for my business. He was able to take my vision and turn it into a reality. I couldn't be happier with the end result."
            <p>- Bob Johnson</p>
        </div>
    </div>
</div>

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
<?php
echo "<script>
        let workerID = '$workerID';
    </script>";
?>
</body>
</html>