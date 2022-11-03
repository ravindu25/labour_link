/*
    Javascript file for the frontend validation of customer-login.html
 */

const usernameField = document.getElementById("username");
const passwordField = document.getElementById("password");
const submitButton = document.getElementById("submit-button");
const loginForm = document.getElementById("login-form");

// Setting the initial values
usernameField.innerText = '';
passwordField.innerText = '';

function validateInputs(username, password){
    // Getting error text fields
    const usernameError = document.getElementById("input-username-error");
    const passwordError = document.getElementById("input-password-error");
    if(username === ''){
        usernameError.innerText = 'Please enter the username';
    }else if(password === ''){
        passwordError.innerText = 'Please enter the password';
    }

    if(username === '' || password === '') return false;
    else return true;
}

function removeErrorMessages(){
    // Getting error text fields
    const usernameError = document.getElementById("input-username-error");
    const passwordError = document.getElementById("input-password-error");

    usernameError.innerText = '';
    passwordError.innerText = '';
}

// Remove previous error messages
usernameField.addEventListener('change',() => {
    removeErrorMessages();
})

passwordField.addEventListener('change',() => {
    removeErrorMessages();
})

// Add event listener to the submit button
submitButton.addEventListener("click", (e) => {
    e.preventDefault();
    if(validateInputs(usernameField.value, passwordField.value)){
        loginForm.submit();
    }
})
