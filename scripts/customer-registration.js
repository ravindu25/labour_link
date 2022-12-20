// Displaying the success message
function showSuccessMessage(){
    const backdrop = document.getElementById('backdrop-modal');
    const successMessage = document.getElementById('register-success');

    backdrop.style.visibility = 'visible';
    successMessage.style.visibility = 'visible';

    // Redirect to the home page
    setTimeout(() => {
        window.location.href = "./index.php";
    }, 5000);
}

// Displaying the fail message
function showFailMessage(errorText){
    const backdrop = document.getElementById('backdrop-modal');
    const failMessage = document.getElementById('register-failed');
    const errorTextHeading = document.getElementById('error-text');

    backdrop.style.visibility = 'visible';
    failMessage.style.visibility = 'visible';
    errorTextHeading.innerText = errorText;

    // Redirect to the home page
    setTimeout(() => {
        window.location.href = "./customer-registration.php";
    }, 5000);
}


