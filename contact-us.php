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
    <link href="./styles/contact-us.css" rel="stylesheet"/>
    <title>LabourLink | Contact Us</title>

    <!--Fontawesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet"/>

</head>
<body>
<div class="message-backdrop" id="message-backdrop">
</div>
<div class="success-message-container" id="booking-create-success">
    <h1><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Message sent successfully</h1>
</div>
<div class="failed-message-container" id="booking-create-fail">
    <div class="message-text">
        <h1><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Error occurred in sending message!</h1>
        <h5>Please try again later</h5>
    </div>
</div>
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
                <h1>Drop a message!</h1>
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
<script src="./scripts/contact-us.js" type="text/javascript"></script>
<script src="./scripts/modals.js" type="text/javascript"></script>
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

        // Prepare the SQL statement using a prepared statement
        $stmt = $conn->prepare("INSERT INTO Message (First_Name, Last_Name, Contact_Num, Email, Message) VALUES (?, ?, ?, ?, ?)");

        // Bind the input parameters
        $stmt->bind_param("sssss", $first_name, $last_name, $contact_number, $email, $message);

        // Execute the statement
        $stmt->execute();

        $result = $stmt->get_result();

        // Close the statement
        $stmt->close();

        // Close the connection
        $conn->close();
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
                echo '<script>showSucessModal()</script>';
            } else {
                echo '<script>showErrorModal()</script>';
            }


        }else{
            //echo the mysql error if the query fails
            echo mysqli_error($conn);

        
        }

        
    }

?>