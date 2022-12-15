<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS files -->
    <link href="../styles/admin-login.css" rel="stylesheet"/>
    <title>LabourLink | Admin login</title>
</head>
<body>
<main class="main-container">
    <section class="left-panel"></section>
    <section class="right-panel">
        <div class="logo-container">
            <img src="../assets/logo-croped1.png" alt="labour-link-logo" class="labour-link-logo"/>
        </div>
        <div class="form-container">
            <h4>Welcome back!</h4>
            <h2>Admin login</h2>
            <form id="login-form" action="" method="POST">
                <label for="email">Email</label>
                <br/>
                <div class="input-container">
                    <input type="email" id="email" name="email" class="text-input"/>
                    <br/>
                    <span class="input-error-text" id="input-email-error"></span>
                </div>
                <br/>
                <label for="password">Password</label>
                <br/>
                <div class="input-container">
                    <input type="password" id="password" name="password" class="text-input"/>
                    <br/>
                    <span class="input-error-text" id="input-password-error"></span>
                </div>
                <div class="forget-password-container">
                    <a href="#" class="login-link">Forgot password?</a>
                </div>
                <!-- <div class="remember-me-container">
                    <input type="checkbox" class="login-checkbox"/>
                    <span>Remember me</span>
                </div> -->
                <div class="button-container">
                    <button type="button" id="back-button" class="back-button">
                        Back
                    </button>
                    <button type="submit" id="submit-button" class="submit-button">
                        Login
                    </button>
                </div>
                <!-- <div class="register-container">
                    <span>Don't have an account? </span><a href="#" class="login-link">Register</a>
                </div> -->
            </form>
        </div>
    </section>
</main>
<script src="./scripts/login-input-validation.js" type="text/javascript"></script>
</body>
</html>

<?php
   //use the db.php file connection
   require_once '../db.php';

   //check if the form is submitted
   if (isset($_POST['email']) && isset($_POST['password'])) {
       //get the username and password from the form
       $email = $_POST['email'];
       $password = $_POST['password'];
  

       //check if the username and password is correct
       $sql = "SELECT * FROM User WHERE Email = '$email' AND Type='Admin'";
       $result = $conn->query($sql);
       
       //if the username and password is correct, redirect to the customer homepage
       if ($result->num_rows > 0) {
           $row = $result->fetch_assoc();
           $user_id=$row['User_ID'];
           if ($row['Pswd'] == $password) {
               //start the session
               session_start();
               //set the session variable
               //set the session variable
               $_SESSION['username'] = $email;
               //get user type from db

               $_SESSION['user_type'] = $row['Type'];
               $_SESSION['user_id'] = $row['User_ID'];
               $_SESSION['first_name'] = $row['First_Name'];
               $_SESSION['last_name'] = $row['Last_Name'];

               //insert the login to login log table
               $log_sql = "INSERT INTO Login_Attempt (User_ID, Success_Flag) VALUES ('$user_id', 1)";
               $conn->query($log_sql);

                //redirect to the Admin Homepage
                header("Location: dashboard.php");


           } else {
               //insert the login to login log table
               $log_sql = "INSERT INTO Login_Attempt (User_ID, Success_Flag) VALUES ('$user_id', 0)";
               $conn->query($log_sql);

               //if the password is incorrect, display the error message
               echo "<script>document.getElementById('input-password-error').innerHTML = 'Username or password does not match';</script>";
           }
           
       } else {    
           //display the error message
           echo "<script>document.getElementById('input-password-error').innerHTML = 'Username or Password does not match';</script>";
       }
   }
?>


