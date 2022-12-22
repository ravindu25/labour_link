const backdropModal = document.getElementById("backdrop-modal");
const adminCreateButton = document.getElementById("create-admin-button");
const adminCreateCancelButton = document.getElementById("admin-create-cancel-button");

backdropModal.addEventListener('click', () => { closeResetModal() });
adminCreateButton.addEventListener('click', () => { openAdminForm() });
adminCreateCancelButton.addEventListener('click', () => { closeAdminForm(); })

function suspend_user(user_id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if (this.responseText === 'Success') {
                // alert('User suspended successfully');
                location.reload();
            } else {
                // alert('Error occurred');
                location.reload();
            }
        }
    }
    xmlhttp.open("POST", "http://localhost/labour_link/admin/suspend-user.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("user_id=" + user_id);

}

function activate_user(user_id) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;

            if (response == "Success") {
                // alert('User activated successfully');
                //print data type of response
                location.reload();
            } else {
                // alert('Error occurred');
                location.reload();
            }
        }
    }
    xmlhttp.open("POST", "http://localhost/labour_link/admin/activate-user.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("user_id=" + user_id);

}

function resetLogin() {
    user_id = document.getElementById("reset-user-id").value;
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            var response = this.responseText;
            if (response == "Success") {
                // alert('User activated successfully');
                //print data type of response
                location.reload();
            } else {
                // alert('Error occurred');
                location.reload();
            }

        }
    }
    xmlhttp.open("POST", "http://localhost/labour_link/admin/reset-login.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("user_id=" + user_id);

}

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

function openSuspendModal(user_id, isSuspend){
    const backdropModal = document.getElementById("backdrop-modal");
    const suspendModalContent = document.getElementById("suspend-user-content");
    document.getElementById("reset-user-id").value = user_id;

    backdropModal.style.visibility = 'visible';
    suspendModalContent.style.visibility = 'visible';
    if(isSuspend){
        const suspendHeading = document.getElementById('suspend-user-text');
        suspendHeading.innerText = 'Do you want to suspend the selected user?';

        const button = document.getElementById('suspend-confirm-button');
        button.addEventListener('click', () => {
            suspend_user(user_id);
        });
    } else {
        const activateHeading = document.getElementById('suspend-user-text');
        activateHeading.innerText = 'Do you want to activate the selected user?';

        const button = document.getElementById('suspend-confirm-button');
        button.addEventListener('click', () => {
            activate_user(user_id);
        });
    }
}

function closeSuspendModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const resetModalContent = document.getElementById("suspend-user-content");

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
