<?php
    include_once('../db.php');

    session_start();

    $validWorkers = array('plumber', 'carpenter', 'electrician', 'painter', 'mason', 'janitor', 'mechanic', 'gardener');
    if(!isset($_GET['workertype']) || !in_array($_GET['workertype'], $validWorkers)){
        header("Location: ../index.php");
    }

    $logged = 'false';
    if(isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] == 'Customer') {
            $logged = 'true';
        }
    }

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
<div class="backdrop-modal" id="message-backdrop">
</div>
<div class="login-container" id="login-container">
    <div class="login-container-header">
        <h1>Please login to create a new booking!</h1>
    </div>
    <div class="login-container-image">
        <img src="../assets/worker/undraw_upload_image_re_svxx.svg" alt="Login to the system" />
    </div>
    <div class="login-button-container">
        <button class="primary-outline-button" onclick="closeLoginModal()"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Cancel</button>
        <a href="../login.php">
            <button class="primary-button"><i class="fa-solid fa-user"></i>&nbsp;&nbsp;Login</button>
        </a>
    </div>
    <div class="login-link-container">
        <p>New to the labourlink. <a href="../customer-registration.php">Register</a></p>
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
                    <?php
                        if($workerType == 'electrician'){
                            echo '<option value="Electrician" selected>Electrician</option>';
                        } else {
                            echo '<option value="Electrician">Electrician</option>';
                        }

                        if($workerType == 'plumber'){
                            echo '<option value="Plumber" selected>Plumber</option>';
                        } else {
                            echo '<option value="Plumber">Plumber</option>';
                        }

                        if($workerType == 'painter'){
                            echo '<option value="Painter" selected>Painter</option>';
                        } else {
                            echo '<option value="Painter">Painter</option>';
                        }

                        if($workerType == 'carpenter'){
                            echo '<option value="Carpenter" selected>Carpenter</option>';
                        } else {
                            echo '<option value="Carpenter">Carpenter</option>';
                        }

                        if($workerType == 'mason'){
                            echo '<option value="Mason" selected>Mason</option>';
                        } else {
                            echo '<option value="Mason">Mason</option>';
                        }

                        if($workerType == 'janitor'){
                            echo '<option value="Janitor" selected>Janitor</option>';
                        } else {
                            echo '<option value="Janitor">Janitor</option>';
                        }

                        if($workerType == 'mechanic'){
                            echo '<option value="Mechanical" selected>Mechanical</option>';
                        } else {
                            echo '<option value="Mechanical">Mechanical</option>';
                        }

                        if($workerType == 'gardener'){
                            echo '<option value="Gardner" selected>Gardner</option>';
                        } else {
                            echo '<option value="Gardner">Gardner</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="form-input-row">
                <label for="worker-id">Worker</label>
                <select id="worker-id" name="worker-name" disabled></select>
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
                <button type="button" class="more-button" id="booking-create-cancel-button" onclick="closeBookingModal()">Cancel</button>
                <button type="submit" class="more-button submit-button" id="booking-create-submit-button">Create
                    Booking
                </button>
            </div>
        </form>
    </div>
</div>
<div class="success-message-container" id="booking-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Booking created successfully</h1>
</div>
<div class="failed-message-container" id="booking-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Booking creation failed</h1>
        <h5>Your login session outdated. Please login again.</h5>
    </div>
</div>
<?php include_once '../components/navbar.php' ?>
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
        <div class="worker-section-header">
<!--            <h1 class="worker-section-title" id="worker-section-title"></h1>-->
            <div class="dropdown" id="dropdown">
                <button type="button" class="worker-section-select-button" id="worker-section-select-button">Top workers&nbsp;&nbsp;<i class="fa-solid fa-arrow-down"></i></button>
                <div class="dropdown-items" id="worker-select-dropdown-items">
                    <div class="dropdown-item" id="worker-select-dropdown-top-workers"><i class="fa-solid fa-star"></i>&nbsp;&nbsp;Top workers
                    </div>
                    <div class="dropdown-item" id="worker-select-dropdown-nearby-workers"><i class="fa-solid fa-location-dot"></i>&nbsp;&nbsp;Nearby workers
                    </div>
                </div>
            </div>
        </div>

        <div class="worker-section" id="initial-worker-section">
            <div class="worker-card-container" id="initial-worker-card-container">
                <?php
                    require_once('../db.php');
                    $sql_get_workers = "select * from User inner join Worker on User.User_ID = Worker.Worker_ID";

                    if($workerType === 'plumber') {
                        $sql_get_workers = $sql_get_workers . " inner join Plumber ON Worker.Worker_ID = Plumber.Plumber_ID";
                    } else if($workerType === 'carpenter'){
                        $sql_get_workers = $sql_get_workers . " inner join Carpenter ON Worker.Worker_ID = Carpenter.Carpenter_ID";
                    } else if($workerType === 'electrician'){
                        $sql_get_workers = $sql_get_workers . " inner join Electrician ON Worker.Worker_ID = Electrician.Electrician_ID";
                    } else if($workerType === 'painter'){
                        $sql_get_workers = $sql_get_workers . " inner join Painter ON Worker.Worker_ID = Painter.Painter_ID";
                    } else if($workerType === 'mason'){
                        $sql_get_workers = $sql_get_workers . " inner join Mason ON Worker.Worker_ID = Mason.Mason_ID";
                    } else if($workerType === 'janitor'){
                        $sql_get_workers = $sql_get_workers . " inner join Janitor ON Worker.Worker_ID = Janitor.Janitor_ID";
                    } else if($workerType === 'mechanic'){
                        $sql_get_workers = $sql_get_workers . " inner join Mechanic ON Worker.Worker_ID = Mechanic.Mechanic_ID";
                    } else if($workerType === 'gardener'){
                        $sql_get_workers = $sql_get_workers . " inner join Gardener ON Worker.Worker_ID = Gardener.Gardener_ID";
                    }

                    $sql_get_workers = $sql_get_workers . " order by Worker.Current_Rating desc limit 4";

                    $result = $conn->query($sql_get_workers);
                    $resultCount = $result->num_rows;

                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){
                            $workerId = $row['User_ID'];
                            $fullName = $row['First_Name'] . " " . $row['Last_Name'];
                            $email = $row['Email'];
                            $contactNum = $row['Contact_No'];
                            $nic = $row['NIC'];
                            $dob = $row['DOB'];
                            $address = $row['User_Address'];
                            $city = $row['City'];
                            $currentRating = $row['Current_Rating'];

                            $workerCategories = getAllCategories($conn, $workerId);
                            $workerCatergoriesHtml = "";

                            for($i = 0; $i < count($workerCategories); $i++){
                                $workerCatergoriesHtml .= "
                                <div class='worker-type-badge'>
                                    <h5>$workerCategories[$i]</h5>
                                </div>";
                            }


                            $profileId = rand(1, 3) + 1;

                            $tempRating = 0;
                            $ratingHtml = "";

                            while($tempRating < $currentRating){
                                if($tempRating + 1 <= $currentRating){
                                    $ratingHtml .= "<i class='fa-solid fa-star'></i>";
                                    $tempRating += 1;
                                } else if ($tempRating + 0.5 <= $currentRating){
                                    $ratingHtml .= "<i class='fa-solid fa-star-half-stroke'></i>";
                                    $tempRating += 0.5;
                                } else {
                                    break;
                                }
                            }

                            $tempRating = ceil($tempRating);

                            while($tempRating < 5){
                                $ratingHtml .= "<i class='fa-regular fa-star'></i>";
                                $tempRating += 1;
                            }

                            $bookingButtonHtml = "";
                            if($logged){
                                $bookingButtonHtml = "<button type='button' class='booking-button' onclick='openLoginModal()'><i class='fa-solid fa-check'></i>&nbsp;&nbsp;Book now!</button>";
                            } else {
                                $bookingButtonHtml = "<button type='button' class='booking-button' onclick='openBookingModal($workerId})'><i class='fa-solid fa-check'></i>&nbsp;&nbsp;Book now!</button>";
                            }

                            echo "
                            <div class='worker-card'>
                                <h1 class='worker-card-title'>$fullName</h1>
                                <div class='worker-card-star-container'>
                                    $ratingHtml
                                    &nbsp;&nbsp; $currentRating
                                </div>
                                <div class='worker-image'>
                                    <img src='../assets/worker/profile-images/worker-$profileId.jpg' alt='worker-profile'>
                                </div>
                                <div class='worker-card-location-row'>
                                    <h3><i class='fa-solid fa-location-dot' style='color: var(--primary-color)'></i>&nbsp;&nbsp;$city</h3>
                                </div>
                                <div class='worker-card-types-row'>
                                   $workerCatergoriesHtml
                                </div>
                                <div class='worker-card-button-container'>
                                    <a href='../worker/view-worker-profile.php?workerId=$workerId'<button type='button' class='view-profile-button'>Profile</button></a>
                                    $bookingButtonHtml
                                </div>
                            </div>
                            ";
                        }
                    }

                ?>
            </div>
            <div class="button-container">
                <?php
                    echo "
                    <button type='button' class='disabled-button' id='top-workers-button' disabled>Load more&nbsp;
                        <i class='fa-solid fa-spinner'></i>
                    </button>";
                ?>
            </div>
        </div>
        <div class="worker-section" id="top-worker-section">
            <div class="worker-card-container" id="top-worker-card-container">
                <?php
                    for($i = 0; $i < 4; $i++) {
                        echo "
                    <div class='worker-loading-card'>
                        <div class='worker-loading-card-title'></div>
                        <div class='worker-loading-card-star-container'></div>
                        <div class='worker-loading-image'></div>
                        <div class='worker-loading-card-location-row'></div>
                        <div class='worker-loading-card-types-row'></div>
                        <div class='worker-loading-card-button-container'></div>
                            
                    </div>";
                    }
                ?>
            </div>
            <div class="button-loading-container" id="top-worker-button-container">
                <div class="button-loading-state"></div>
            </div>
        </div>
        <div class="worker-section" id="nearby-worker-section">
            <div class="worker-card-container" id="worker-nearby-card-container">
                <?php
                    for($i = 0; $i < 4; $i++) {
                        echo "
                    <div class='worker-loading-card'>
                        <div class='worker-loading-card-title'></div>
                        <div class='worker-loading-card-star-container'></div>
                        <div class='worker-loading-image'></div>
                        <div class='worker-loading-card-location-row'></div>
                        <div class='worker-loading-card-types-row'></div>
                        <div class='worker-loading-card-button-container'></div>
                            
                    </div>";
                    }
                ?>


            </div>
            <div class="button-loading-container" id="nearby-worker-button-container">
                <div class="button-loading-state"></div>
            </div>
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

<?php
    echo "<script>
        let workerType = '$workerType';
        let logged = $logged;
    </script>";
?>
<script src="../scripts/modals.js" type="text/javascript"></script>
<script src="../scripts/index.js" type="text/javascript"></script>
<script src="../scripts/worker/index.js" type="text/javascript"></script>
<script src="../scripts/customer/create-booking.js" type="text/javascript"></script>
<?php
    echo "<script>initialLoad('$workerType')</script>";

    function getAllCategories($conn, $workerId){
        $sql_statement = "SELECT Worker.Worker_ID, P.Plumber_ID, C.Carpenter_ID, E.Electrician_ID, P2.Painter_ID,
        M.Mason_ID, J.Janitor_ID, M2.Mechanic_ID, Gardener_ID
                    FROM Worker LEFT JOIN Plumber P on Worker.Worker_ID = P.Plumber_ID
                    LEFT JOIN Carpenter C on Worker.Worker_ID = C.Carpenter_ID
                    LEFT JOIN Electrician E on Worker.Worker_ID = E.Electrician_ID
                    LEFT JOIN Painter P2 on Worker.Worker_ID = P2.Painter_ID
                    LEFT JOIN Mason M on Worker.Worker_ID = M.Mason_ID
                    LEFT JOIN Janitor J on Worker.Worker_ID = J.Janitor_ID
                    LEFT JOIN Mechanic M2 on Worker.Worker_ID = M2.Mechanic_ID
                    LEFT JOIN Gardener G on Worker.Worker_ID = G.Gardener_ID WHERE Worker_ID = $workerId";

        $result = $conn->query($sql_statement);

        $workerCategories = array();

        if($result->num_rows){
            while($row = $result->fetch_assoc()){
                if($row['Plumber_ID'] != null){
                    array_push($workerCategories, "Plumber");
                }

                if($row['Carpenter_ID'] != null){
                    array_push($workerCategories, "Carpenter");
                }

                if($row['Electrician_ID'] != null){
                    array_push($workerCategories, "Electrician");
                }

                if($row['Painter_ID'] != null){
                    array_push($workerCategories, "Painter");
                }

                if($row['Mason_ID'] != null){
                    array_push($workerCategories, "Mason");
                }

                if($row['Janitor_ID'] != null){
                    array_push($workerCategories, "Janitor");
                }

                if($row['Mechanic_ID'] != null){
                    array_push($workerCategories, "Mechanic");
                }

                if($row['Gardener_ID'] != null){
                    array_push($workerCategories, "Gardener");
                }
            }
        }

        return $workerCategories;
    }
?>
</body>
</html>