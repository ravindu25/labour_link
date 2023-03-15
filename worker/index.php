<?php
    include_once('../db.php');

    session_start();

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
    <link href="../styles/customer/customer-bookings.css" rel="stylesheet"/>
    <title>Workers | LabourLink</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

    <!-- Material Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
<div class="register-select-modal" id="register-modal">
</div>
<div class="backdrop-modal" id="backdrop-modal">
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
<div class="create-booking-container" id="create-booking-container">
    <div class="create-booking-scroll-wrapper">
        <div class="create-booking-title">
            <h1>Create new <u>Booking</u></h1>
        </div>
        <form id="booking-create-form">
            <div class="form-input-row">
                <label for="job-type">Job type</label>
                <select id="job-type" name="job-type" disabled>
                    <option value="Electrician" selected>Electrician</option>
                    <option value="Plumber">Plumber</option>
                    <option value="Painter">Painter</option>
                    <option value="Carpenter">Carpenter</option>
                    <option value="Mason">Mason</option>
                    <option value="Janitor">Janitor</option>
                    <option value="Mechanical">Mechanical</option>
                    <option value="Gardner">Gardner</option>
                </select>
            </div>
            <div class="form-input-row">
                <label for="worker-id">Worker</label>
                <select id="worker-id" name="worker-name"></select>
            </div>
            <div class="form-input-row">
                <label for="start-date">Start date</label>
                <input type="date" id="start-date" name="start-date"/>
            </div>
            <div class="form-time-row" id="days-complete-container">
                <label>
                    Days needed to complete
                </label>
                <div class="time-row">
                    <label>
                        <input type="radio" name="time-input" value="1" class="time-card-input"/>
                        <div class="time-card">
                            <h3>1</h3>
                            <h4>Day</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="2" class="time-card-input"/>
                        <div class="time-card">
                            <h3>2</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="7" class="time-card-input" checked/>
                        <div class="time-card">
                            <h3>7</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="14" class="time-card-input"/>
                        <div class="time-card">
                            <h3>14</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="time-input" value="30" class="time-card-input"/>
                        <div class="time-card">
                            <h3>30</h3>
                            <h4>Days</h4>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-input-row" id="end-date-container">
                <label for="end-date">End date</label>
                <input type="date" id="end-date" name="send-date"/>
            </div>
            <div class="form-button-container">
                <button type="button" class="more-button submit-button" id="change-days-complete-button">Custom date</button>
            </div>
            <div class="form-payment-row">
                <label>Payment method</label>
                <div class="payment-methods-container">
                    <label>
                        <input type="radio" name="payment-method" class="payment-method-radio" value="Manual"/>
                        <div class="payment-method-card">
                            <img src="../assets/customer/dashboard/undraw_savings_re_eq4w.svg" alt="manual-payment"
                                 class="payment-method-image"/>
                            <h5>Manual payments</h5>
                        </div>
                    </label>
                    <label>
                        <input type="radio" name="payment-method" class="payment-method-radio" value="Online" checked/>
                        <div class="payment-method-card">
                            <img src="../assets/customer/dashboard/undraw_credit_card_re_blml.svg" alt="online-payment"
                                 class="payment-method-image"/>
                            <h5>Online payments</h5>
                        </div>
                    </label>
                </div>
            </div>
            <div class="form-button-container">
                <button type="button" class="more-button" id="booking-create-cancel-button">Cancel</button>
                <button type="submit" class="more-button submit-button" id="booking-create-submit-button">Create
                    Booking
                </button>
            </div>
        </form>
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
        <?php
        if($workerType === 'plumber'){
            echo '<i class="fa-solid fa-wrench"></i>';
        }
        if($workerType === 'carpenter'){
            echo '<span class="material-icons md-40">carpenter</span>';
        }
        if($workerType === 'electrician'){
            echo '<i class="fa-sharp fa-solid fa-screwdriver"></i>';
        }
        if($workerType === 'painter'){
            echo '<i class="fa-solid fa-paint-roller"></i>';
        }
        if($workerType === 'mason'){
            echo '<i class="fa-solid fa-hammer"></i>';
        }
        if($workerType === 'janitor'){
            echo '<i class="fa-solid fa-broom"></i>';
        }
        if($workerType === 'mechanic'){
            echo '<i class="fa-sharp fa-solid fa-gear"></i>';
        }
        if($workerType === 'gardener'){
            echo '<i class="fa-solid fa-trowel"></i>';
        }
        ?>
    </h1>
</section>
<section class="main-content">
    <div class="worker-section">
        <h1 class="worker-section-title">Top workers</h1>
        <div class="worker-card-container" id="top-worker-card-container">
            <?php
                $sql_get_workers = "select * from User inner join Worker on User.User_ID = Worker.Worker_ID";
                $sql_get_workers_on_location = "select * from User inner join Worker on User.User_ID = Worker.Worker_ID";

                if($workerType === 'plumber') {
                    $sql_get_workers = $sql_get_workers . " inner join Plumber ON Worker.Worker_ID = Plumber.Plumber_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Plumber ON Worker.Worker_ID = Plumber.Plumber_ID";
                } else if($workerType === 'carpenter'){
                    $sql_get_workers = $sql_get_workers . " inner join Carpenter ON Worker.Worker_ID = Carpenter.Carpenter_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Carpenter ON Worker.Worker_ID = Carpenter.Carpenter_ID";
                } else if($workerType === 'electrician'){
                    $sql_get_workers = $sql_get_workers . " inner join Electrician ON Worker.Worker_ID = Electrician.Electrician_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Electrician ON Worker.Worker_ID = Electrician.Electrician_ID";
                } else if($workerType === 'painter'){
                    $sql_get_workers = $sql_get_workers . " inner join Painter ON Worker.Worker_ID = Painter.Painter_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Painter ON Worker.Worker_ID = Painter.Painter_ID";
                } else if($workerType === 'mason'){
                    $sql_get_workers = $sql_get_workers . " inner join Mason ON Worker.Worker_ID = Mason.Mason_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Mason ON Worker.Worker_ID = Mason.Mason_ID";
                } else if($workerType === 'janitor'){
                    $sql_get_workers = $sql_get_workers . " inner join Janitor ON Worker.Worker_ID = Janitor.Janitor_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Janitor ON Worker.Worker_ID = Janitor.Janitor_ID";
                } else if($workerType === 'mechanic'){
                    $sql_get_workers = $sql_get_workers . " inner join Mechanic ON Worker.Worker_ID = Mechanic.Mechanic_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Mechanic ON Worker.Worker_ID = Mechanic.Mechanic_ID";
                } else if($workerType === 'gardener'){
                    $sql_get_workers = $sql_get_workers . " inner join Gardener ON Worker.Worker_ID = Gardener.Gardener_ID";
                    $sql_get_workers_on_location = $sql_get_workers_on_location . " inner join Gardener ON Worker.Worker_ID = Gardener.Gardener_ID";
                }

                $sql_get_workers = $sql_get_workers . " ORDER BY Worker.Current_Rating DESC LIMIT 4";
                $sql_get_workers_on_location = $sql_get_workers_on_location . " LIMIT 4";

                

                $result = $conn->query($sql_get_workers);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        /*
                         * Creating the worker entity
                         */

                        $userId = $row['User_ID'];
                        $fullName = $row['First_Name'] . " " . $row['Last_Name'];
                        $email = $row['Email'];
                        $contactNum = $row['Contact_No'];
                        $nic = $row['NIC'];
                        $dob = $row['DOB'];
                        $address = $row['User_Address'];
                        $city = $row['City'];
                        $currentRating = $row['Current_Rating'];

                        $imageNumber = rand(1, 4);
                        $imageUrl = "../assets/worker/profile-images/worker-$imageNumber.jpg";

                        $ratingHtml = null;
                        $tempRating = 0;

                        while($tempRating < $currentRating){
                            if($tempRating + 1 <= $currentRating){
                                $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star'></i>";
                                $tempRating += 1;
                            } else if ($tempRating + 0.5 <= $currentRating){
                                $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star-half-stroke'></i>";
                                $tempRating += 0.5;
                            } else {
                                break;
                            }
                        }

                        $tempRating = ceil($tempRating);

                        while($tempRating < 5){
                            $ratingHtml = $ratingHtml . "<i class='fa-regular fa-star'></i>";
                            $tempRating += 1;
                        }

                        echo "
                            <div class='worker-card'>
                                <h1 class='worker-card-title'>"
                                    . ucfirst($fullName) .
                                "</h1>
                                <div class='worker-card-star-container'>
                                    $ratingHtml
                                    &nbsp;&nbsp;<b>$currentRating </b> 
                                </div>
                                <div class='worker-image'>
                                    <img src='$imageUrl' alt='worker-profile'>
                                </div>
                                <div class='worker-card-location-row'>
                                    <h3><i class='fa-solid fa-location-dot' style='color: var(--primary-color)'></i>&nbsp;&nbsp;"
                                        . ucfirst($city) .
                                    "</h3>
                                </div>
                                <div class='worker-card-types-row'>
                                    <div class='worker-type-badge'>
                                        <h5>Electrician</h5>
                                    </div>
                                    <div class='worker-type-badge'>
                                        <h5>Plumber</h5>
                                    </div>
                                </div>
                                <div class='worker-card-button-container'>
                                    <a href='view-worker-profile.php?workerId=$userId'>
                                    <button type='button' class='view-profile-button'>View Profile</button>
                                    </a>
                                    <button type='button' class='booking-button' id='booking-create-button'>Book now!</button>
                                </div>
                            </div>
                        ";
                    }
                }
            ?>
        </div>
        <div class="button-container">
            <button type="button" class="more-button" id="top-workers-button">Load more&nbsp;
                <i class="fa-solid fa-spinner"></i></button>
        </div>
    </div>
    <div class="worker-section">
        <h1 class="worker-section-title">Workers nearby</h1>
        <div class="worker-card-container">
            <?php
                $result = $conn->query($sql_get_workers_on_location);

                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        /*
                         * Creating the worker entity
                         */

                        $userId = $row['User_ID'];
                        $fullName = $row['First_Name'] . " " . $row['Last_Name'];
                        $email = $row['Email'];
                        $contactNum = $row['Contact_No'];
                        $nic = $row['NIC'];
                        $dob = $row['DOB'];
                        $address = $row['User_Address'];
                        $city = $row['City'];
                        $currentRating = $row['Current_Rating'];

                        $imageNumber = rand(1, 4);
                        $imageUrl = "../assets/worker/profile-images/worker-$imageNumber.jpg";

                        $ratingHtml = null;
                        $tempRating = 0;

                        while($tempRating < $currentRating){
                            if($tempRating + 1 <= $currentRating){
                                $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star'></i>";
                                $tempRating += 1;
                            } else if ($tempRating + 0.5 <= $currentRating){
                                $ratingHtml = $ratingHtml . "<i class='fa-solid fa-star-half-stroke'></i>";
                                $tempRating += 0.5;
                            } else {
                                break;
                            }
                        }

                        $tempRating = ceil($tempRating);

                        while($tempRating < 5){
                            $ratingHtml = $ratingHtml . "<i class='fa-regular fa-star'></i>";
                            $tempRating += 1;
                        }
                     

                        echo "
                            <div class='worker-card'>
                                <h1 class='worker-card-title'>"
                                    . ucfirst($fullName) .
                                "</h1>
                                <div class='worker-card-star-container'>
                                    $ratingHtml
                                    &nbsp;&nbsp;<b>$currentRating </b> 
                                </div>
                                <div class='worker-image'>
                                    <img src='$imageUrl' alt='worker-profile'>
                                </div>
                                <div class='worker-card-location-row'>
                                    <h3><i class='fa-solid fa-location-dot' style='color: var(--primary-color)'></i>&nbsp;&nbsp;"
                                        . ucfirst($city) .
                                    "</h3>
                                </div> 
                                <div class='worker-card-types-row'>
                                    <div class='worker-type-badge'>
                                        <h5>Electrician</h5>
                                    </div>
                                    <div class='worker-type-badge'>
                                        <h5>Plumber</h5>
                                    </div>
                                </div>
                                <div class='worker-card-button-container'>
                                    <a href='view-worker-profile.php?workerId=$userId'>
                                    <button type='button' class='view-profile-button'>View Profile</button>
                                    </a>
                                    <button type='button' class='booking-button'>Book now!</button>
                                </div>
                                <span id='location-$userId'></span>
                                <script>
                                    addEventListener('load', function(){
                                        
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(function(position) {
                                              var lat = position.coords.latitude;
                                              var lng = position.coords.longitude;
                                
                                        
                                              // Send location data to PHP backend
                                              var xhttp = new XMLHttpRequest();
                                              xhttp.onreadystatechange = function() {
                                                if (this.readyState == 4 && this.status == 200) {
                                                  document.getElementById('location-$userId').innerHTML = this.responseText;
                                                }
                                              };
                                              xhttp.open('POST', 'http://localhost/labour_link/test_location.php', true);
                                              xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                              xhttp.send('lat=' + lat + '&lng=' + lng + '&to_location=' + '$city');
                                            });
                                          } else {
                                            console.log('Geolocation is not supported by this browser.');
                                          }
                                        


                                    });
                                </script>
                                


                            </div>
                        "; 
                        
                    }
                }
                $conn->close();

            ?>
         
        
        </div>
        <div class="button-container">
            <button type="button" class="more-button">Load more&nbsp;
                <i class="fa-solid fa-spinner"></i></button>
        </div>
    </div>
    <span id="test-location"></span>
    
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

<?php
    echo "<script>
        let workerType = '$workerType';
    </script>";
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/worker/index.js" type="text/javascript"></script>




</body>
</html>