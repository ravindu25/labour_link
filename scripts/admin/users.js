const backdropModal = document.getElementById("backdrop-modal");
const adminCreateButton = document.getElementById("create-admin-button");
const adminCreateCancelButton = document.getElementById("admin-create-cancel-button");

backdropModal.addEventListener('click', () => { closeResetModal() });
adminCreateButton.addEventListener('click', () => { openAdminForm() });
adminCreateCancelButton.addEventListener('click', () => { closeAdminForm(); })

function openResetModal(user_id){
    const backdropModal = document.getElementById("backdrop-modal");
    const resetModalContent = document.getElementById("reset-login-content");
    document.getElementById("reset-user-id").value = user_id;

    backdropModal.style.visibility = 'visible';
    resetModalContent.style.visibility = 'visible';
}

function closeResetModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const resetModalContent = document.getElementById("reset-login-content");

    backdropModal.style.visibility = 'hidden';
    resetModalContent.style.visibility = 'hidden';
}

function openAdminForm(){
    const backdropModal = document.getElementById("admin-backdrop-modal");
    const adminForm = document.getElementById("create-admin-form");

    backdropModal.style.visibility = 'visible';
    adminForm.style.visibility = 'visible';
}

function closeAdminForm(){
    const backdropModal = document.getElementById("admin-backdrop-modal");
    const adminForm = document.getElementById("create-admin-form");

    backdropModal.style.visibility = 'hidden';
    adminForm.style.visibility = 'hidden';
}

// Displaying the success message
function showSuccessMessage(){
    const backdrop = document.getElementById('backdrop-modal');
    const successMessage = document.getElementById('register-success');

    backdrop.style.visibility = 'visible';
    successMessage.style.visibility = 'visible';

    // Redirect to the home page
    setTimeout(() => {
        backdrop.style.visibility = 'hidden';
        successMessage.style.visibility = 'hidden';
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
        backdrop.style.visibility = 'hidden';
        failMessage.style.visibility = 'hidden';
    }, 5000);
}
