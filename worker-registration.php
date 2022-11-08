<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="./styles/labourer-registraion.css">
    <title>LabourLink | Labour registration</title>
</head>
<body>
<main class="main-container">
    <section class="left-panel"></section>
    <section class="right-panel">
        <div class="logo-container">
            <img src="./assets/logo-croped1.png" alt="labour-link-logo" class="labour-link-logo"/>
        </div>
        <div class="form-container">
            <h4>Welcome to Labour Link!</h4>
            <h2>Create account</h2>
            <form id="registration-form">
                <div class="form-grid">
                    <div class="form-grid-column">
                        <label for="firstname">First name</label><br>
                        <div class="input-container">
                            <input type="text" id="firstname" class="text-input" name="firstname"><br>
                            <span class="input-error-text" id="input-firstname-error"></span>
                        </div>
                        <label for="email">Email</label><br>
                        <div class="input-container">
                            <input type="text" id="email" class="text-input"><br>
                            <span class="input-error-text" id="input-email-error"></span>
                        </div>
                    </div>
                    <div class="form-grid-column">
                        <label for="lastname">Last name</label><br>
                        <div class="input-container">
                            <input type="text" id="lastname" class="text-input"><br>
                            <span class="input-error-text" id="input-lastname-error"></span>
                        </div>
                        <label for="phone number">Phone number</label><br>
                        <div class="input-container">
                            <input type="text" id="phone-number" class="text-input"><br>
                            <span class="input-error-text" id="input-phone-error"></span>
                        </div>
                    </div>
                </div>
                <div class="form-grid">
                    <div style="padding-left: 4px">
                        <label for="address">Address</label><br>
                        <div class="input-container">
                            <input type="text" id="address" class="text-input" style="min-width: 440px;"><br>
                            <span class="input-error-text" id="input-address-error"></span>
                        </div>
                    </div>
                </div>
                <div class="form-grid">
                    <div class="form-grid-column">
                        <label for="nic-number">NIC number</label>
                        <div class="input-container">
                            <input type="text" id="nic-number" class="text-input" style="height: 26px">
                            <span class="input-error-text" id="input-nic-error"></span>
                        </div>
                        <label for="password">Password</label><br>
                        <div class="input-container">
                            <input type="password" id="password" class="text-input"><br>
                            <span class="input-error-text" id="input-password-error"></span>
                        </div>
                        <label for="validate-identity">Upload front image of NIC</label><br>
                        <div class="input-container">
                            <input type="file" class="upload-box" id="validate-identity-front">
                        </div>
                        <label for="validate-identity">Letter from Garama sewaka</label><br>
                        <div class="input-container">
                            <input type="file" class="upload-box" id="validate-letter">
                        </div>
                    </div>
                    <div class="form-grid-column">
                        <label for="dob">Date of birth(MM/DD/YY)</label><br>
                        <div class="input-container">
                            <input type="date" id="dob" class="date-input">
                            <span class="input-error-text" id="input-dob-error"></span>
                        </div>
                        <label for="confirm-password">Confirm Password</label><br>
                        <div class="input-container">
                            <input type="password" id="confirm-password" class="text-input"><br>
                            <span class="input-error-text" id="input-cofirm-password-error"></span>
                        </div>

                        <label for="validate-identity">Upload back image of NIC</label><br>
                        <div class="input-container">
                            <input type="file" class="upload-box" id="validate-identity-back">
                        </div>
                        <label for="city">City</label><br>
                        <div class="input-container">
                            <input type="text" id="city" class="text-input"><br>
                            <span class="input-error-text" id="input-city-error"></span>
                        </div>
                    </div>
                </div>

                <div class="remember-me-container">
                    <input type="checkbox" class="login-checkbox">
                    <span>Remember me</span>
                </div>
                <div class="term-policy-container">
                    <input type="checkbox" class="policy-checkbox">
                    <span>I agree to all the <a href="#" class="terms-link">Terms</a> and <a href="#"
                                                                                             class="terms-link">Privacy Policy</a></span>
                </div>

                <div class="button-container">
                    <button type="button" class="back-button" id="back-button">
                        Back
                    </button>
                    <button type="button" class="reg-button" id="register-button">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>
</body>
</html