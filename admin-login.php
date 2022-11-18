<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Google fonts imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS files -->
    <link href="./styles/admin-login.css" rel="stylesheet"/>
    <title>LabourLink | Admin login</title>
</head>
<body>
<main class="main-container">
    <section class="left-panel"></section>
    <section class="right-panel">
        <div class="logo-container">
            <img src="./assets/logo-croped1.png" alt="labour-link-logo" class="labour-link-logo"/>
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
                <div class="remember-me-container">
                    <input type="checkbox" class="login-checkbox"/>
                    <span>Remember me</span>
                </div>
                <div class="button-container">
                    <button type="button" id="back-button" class="back-button">
                        Back
                    </button>
                    <button type="submit" id="submit-button" class="submit-button">
                        Login
                    </button>
                </div>
                <div class="register-container">
                    <span>Don't have an account? </span><a href="#" class="login-link">Register</a>
                </div>
            </form>
        </div>
    </section>
</main>
<script src="./scripts/login-input-validation.js" type="text/javascript"></script>
</body>
</html>


