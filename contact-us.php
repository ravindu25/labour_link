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
    <link href="./styles/contact-us.css" rel="stylesheet"/>
    <title>LabourLink | Contact Us</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

</head>
<body>
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
            <div class="nav-link-items"><a href="index.php" class="nav-links">Home</a></div>
            <div class="nav-link-items"><a href="about.php" class="nav-links">About</a></div>
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
<section class="contact-banner">
    <div class="contact-banner-left-panel">
        <h1>Want to reach us?</h1>
        <div class="banner-content">
            <div class="banner-content-title">
                <i class="fa-solid fa-phone"></i>
                <h3>Call</h3>
            </div>
            <table>
                <tr>
                    <td>Mohamed Izzath:</td>
                    <td><span class="banner-table-contact-text">+94 76 450 4261</span></td>
                </tr>
                <tr>
                    <td>Ravindu Wegiriya:</td>
                    <td><span class="banner-table-contact-text">+94 71 999 9455</span></td>
                </tr>
                <tr>
                    <td>Dhananga Deepanjana:</td>
                    <td><span class="banner-table-contact-text">+94 70 530 4401</span></td>
                </tr>
            </table>
        </div>
        <div class="banner-content">
            <div class="banner-content-title">
                <i class="fa-solid fa-at"></i>
                <h3>Email</h3>
            </div>
            <table>
                <tr>
                    <td>Mohamed Izzath:</td>
                    <td><span class="banner-table-contact-text">mohamedizzath@gmail.com</span></td>
                </tr>
                <tr>
                    <td>Ravindu Wegiriya:</td>
                    <td><span class="banner-table-contact-text">ravinduwegiriya@gmail.com</span></td>
                </tr>
                <tr>
                    <td>Dhananga Deepanjana:</td>
                    <td><span class="banner-table-contact-text">dhanangadeep@gmail.com</span></td>
                </tr>
            </table>
        </div>
    </div>
</section>
<section class="contact-form-container">
    <div class="contact-form">
        <form action="" method="POST">
            <div class="form-title">
                <i class="fa-solid fa-envelope"></i>
                <h1>Send us a message!</h1>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label class="form-input-label" for="first-name">First Name</label>
                    <input type="text" class="form-input" id="first-name" name="first-name"/>
                </div>
                <div class="form-column">
                    <label class="form-input-label" for="last-name">Last Name</label>
                    <input type="text" class="form-input" id="last-name" name="last-name"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label class="form-input-label" for="contact-number">Contact Number</label>
                    <input type="text" class="form-input" id="contact-number" name="contact-number"/>
                </div>
                <div class="form-column">
                    <label class="form-input-label" for="email-address">Email Address</label>
                    <input type="text" class="form-input" id="email-address" name="email"/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-column">
                    <label class="form-input-label" for="message">Message</label>
                    <textarea class="form-text-area" id="message"  name="message"></textarea>
                </div>
            </div>
            <div class="button-container">
                <button type="submit" class="submit-button" name="submit-button">Submit</button>
            </div>
        </form>
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
<script src="./scripts/index.js" type="text/javascript"></script>
</body>
</html>

<?php
    if(isset($_POST['submit-button'])){
        require_once 'db.php';

        $first_name = $_POST['first-name'];
        $last_name = $_POST['last-name'];
        $contact_number = $_POST['contact-number'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $sql = "INSERT INTO Message (First_Name, Last_Name, Contact_Num, Email, Message) VALUES ('$first_name', '$last_name', '$contact_number', '$email', '$message')";
        $result = mysqli_query($conn, $sql);

        if($result){
            echo "Successfuly sent";
            require_once 'mailconfiguration.php';

            $mail->addAddress('labourlinklanka@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = "Message from $first_name";
            //add reply to
            $mail->addReplyTo($email);
            $mail->Body = "You have received a message from $first_name $last_name. <br> Contact Number: $contact_number <br> Email: $email <br> Message: $message";

            if ($mail->send()) {
                echo 'Email sent';
            } else {
                echo 'Email not sent';
            }


        }else{
            //echo the mysql error if the query fails
            echo mysqli_error($conn);

        
        }

        
    }

?>