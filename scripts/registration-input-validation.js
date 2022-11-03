/*
    Javascript file for the frontend validation of customer-registration.html
 */

const firstNameField = document.getElementById("firstname");
const lastNameField = document.getElementById("lastname");
const emailOrPhoneField = document.getElementById("email-or-phone");
const dobField = document.getElementById("dob");
const passwordField = document.getElementById("password");
const confirmPasswordField = document.getElementById("confirm-password");

const registrationForm = document.getElementById("registration-form");
const registerButton = document.getElementById("register-button");

// Setting initial values
firstNameField.innerText = '';
lastNameField.innerText = '';
emailOrPhoneField.innerText = '';
dobField.value = getToday();
passwordField.innerText = '';
confirmPasswordField.innerText = '';

firstNameField.addEventListener('change', () => {removeErrorMessages()});
lastNameField.addEventListener('change', () => {removeErrorMessages()});
emailOrPhoneField.addEventListener('change', () => {removeErrorMessages()});
dobField.addEventListener('change', () => {removeErrorMessages()});
passwordField.addEventListener('change', () => {removeErrorMessages()});
confirmPasswordField.addEventListener('change', () => {removeErrorMessages()});

// Get the current date
function getToday(){
    const today = new Date();
    const date = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();

    return `${year}-${month}-${date}`;
}

function validateInputs(firstname, lastname, emailOrPhone, dob, password, confirmPassword){
    const firstnameError = document.getElementById("input-firstname-error");
    const lastnameError = document.getElementById("input-lastname-error");
    const emailOrPhoneError = document.getElementById("input-email-or-phone-error");
    const dobError = document.getElementById("input-dob-error");
    const passwordError = document.getElementById("input-password-error");
    const confirmPasswordError = document.getElementById("input-confirm-password-error");

    // Regular expressions for checking email and password
    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
    const phonePattern = /[0-9]{10}/g;

    if(firstname === ''){
        firstnameError.innerText = 'Please enter the firstname';
        return false;
    }else if(lastname === ''){
        lastnameError.innerText = 'Please enter the lastname';
        return false;
    }else if(!emailPattern.test(emailOrPhone) && !phonePattern.test(emailOrPhone)){
        emailOrPhoneError.innerText = 'Invalid email or phone number';
        return false;
    }else if(dob === null){
        dobError.innerText = 'Please enter date of birth';
        return false;
    }else if(password === ''){
        passwordError.innerText = 'Please enter the password';
        return false;
    }else if(confirmPassword === ''){
        confirmPasswordError.innerText = 'Please enter the confirm password';
        return false;
    }else if(password !== confirmPassword){
        passwordError.innerText = 'Password and confirm password don\'t match';
        return false;
    }

    return true;
}

function removeErrorMessages(){
    const firstnameError = document.getElementById("input-firstname-error");
    const lastnameError = document.getElementById("input-lastname-error");
    const emailOrPhoneError = document.getElementById("input-email-or-phone-error");
    const dobError = document.getElementById("input-dob-error");
    const passwordError = document.getElementById("input-password-error");
    const confirmPasswordError = document.getElementById("input-confirm-password-error");

    firstnameError.innerText = '';
    lastnameError.innerText = '';
    emailOrPhoneError.innerText = '';
    dobError.innerText = '';
    passwordError.innerText = '';
    confirmPasswordError.innerText = '';
}

registerButton.addEventListener('click', (e) => {
    e.preventDefault();
    if(validateInputs(firstNameField.value, lastNameField.value, emailOrPhoneField.value, dobField.value, passwordField.value, confirmPasswordField.value)){
        registrationForm.submit();
    }
})
