/*
    Javascript file for the frontend validation of customer-registration.html
 */

const firstNameField = document.getElementById("firstname");
const lastNameField = document.getElementById("lastname");
const emailField = document.getElementById("email");
const dobField = document.getElementById("dob");
const phoneNumberField = document.getElementById("phone-number");
const nicField = document.getElementById("nic-number");
const addressField = document.getElementById("address");
const passwordField = document.getElementById("password");
const confirmPasswordField = document.getElementById("confirm-password");
const privacyCheck = document.getElementById("privacy-checkbox");

const registrationForm = document.getElementById("registration-form");
const registerButton = document.getElementById("register-button");

// Setting initial values
firstNameField.innerText = '';
lastNameField.innerText = '';
emailField.innerText = '';
phoneNumberField.innerText = '';
nicField.innerText = '';
dobField.value = getToday();
addressField.value = '';
passwordField.innerText = '';
confirmPasswordField.innerText = '';

firstNameField.addEventListener('change', () => {removeErrorMessages()});
lastNameField.addEventListener('change', () => {removeErrorMessages()});
emailField.addEventListener('change', () => {removeErrorMessages()});
phoneNumberField.addEventListener('change', () => {removeErrorMessages()});
nicField.addEventListener('change', () => {removeErrorMessages()});
dobField.addEventListener('change', () => {removeErrorMessages()});
addressField.addEventListener('change', () => {removeErrorMessages()});
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

function validateInputs(firstname, lastname, email, phone, nic, dob, address, password, confirmPassword){
    const firstnameError = document.getElementById("input-firstname-error");
    const lastnameError = document.getElementById("input-lastname-error");
    const emailError = document.getElementById("input-email-error");
    const phoneError = document.getElementById("input-phone-error");
    const nicError = document.getElementById("input-nic-error");
    const dobError = document.getElementById("input-dob-error");
    const addressError = document.getElementById("input-address-error");
    const passwordError = document.getElementById("input-password-error");
    const confirmPasswordError = document.getElementById("input-confirm-password-error");
    const privacyCheckError = document.getElementById("input-privacy-error");

    // Regular expressions for checking email and password
    const emailPattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
    const phonePattern = /[0-9]{10}/g;
    const oldNicPattern = /[0-9]{9}[XV]/g;
    const newNicPattern = /[0-9]{12}/g;

    if(firstname === ''){
        firstnameError.innerText = 'Please enter the firstname';
        return false;
    }else if(lastname === ''){
        lastnameError.innerText = 'Please enter the lastname';
        return false;
    }else if(!emailPattern.test(email)){
        emailError.innerText = 'Invalid email address';
        return false;
    }else if(!phonePattern.test(phone)){
        phoneError.innerText = 'Entered phone number not valid';
        return false;
    }else if(!oldNicPattern.test(nic) && !newNicPattern.test(nic)){
        nicError.innerText = 'Please enter valid NIC';
        return false;
    }else if(address === ''){
        addressError.innerText = 'Please enter the address';
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
    }else if(!privacyCheck.checked){
        privacyCheckError.innerText = 'You need to agree to the terms and conditions';
        return false;
    }

    return true;
}

function removeErrorMessages(){
    const firstnameError = document.getElementById("input-firstname-error");
    const lastnameError = document.getElementById("input-lastname-error");
    const emailError = document.getElementById("input-email-error");
    const phoneError = document.getElementById("input-phone-error");
    const nicError = document.getElementById("input-nic-error");
    const dobError = document.getElementById("input-dob-error");
    const addressError = document.getElementById("input-address-error");
    const passwordError = document.getElementById("input-password-error");
    const confirmPasswordError = document.getElementById("input-confirm-password-error");
    const privacyCheckError = document.getElementById("input-privacy-error");

    firstnameError.innerText = '';
    lastnameError.innerText = '';
    emailError.innerText = '';
    phoneError.innerText = '';
    nicError.innerText = '';
    dobError.innerText = '';
    addressError.innerText = '';
    passwordError.innerText = '';
    confirmPasswordError.innerText = '';
    privacyCheckError.innerText = '';
}

registerButton.addEventListener('click', (e) => {
    e.preventDefault();
    if(validateInputs(firstNameField.value, lastNameField.value, emailField.value, phoneNumberField.value, nicField.value, dobField.value, addressField.value,passwordField.value, confirmPasswordField.value, privacyCheck.checked)){
        registrationForm.submit();
    }
})
