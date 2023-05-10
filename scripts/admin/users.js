const backdropModal = document.getElementById("backdrop-modal");
const adminCreateButton = document.getElementById("create-admin-button");
const adminCreateCancelButton = document.getElementById("admin-create-cancel-button");
let currentPage = 0;

backdropModal.addEventListener('click', () => { closeResetModal() });
adminCreateButton.addEventListener('click', () => { openAdminForm() });
adminCreateCancelButton.addEventListener('click', () => { closeAdminForm(); })

function suspend_user(user_id) {
    // console.log(user_id);
    // console.log(curr_user_id);
    // if(user_id == curr_user_id){
    //     alert('You cannot suspend yourself');
    //     return;
    // }
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

function openSuspendModal(user_id, curr_user_id, isSuspend){
    const backdropModal = document.getElementById("backdrop-modal");
    const suspendModalContent = document.getElementById("suspend-user-content");
    document.getElementById("reset-user-id").value = user_id;

    backdropModal.style.visibility = 'visible';
    suspendModalContent.style.visibility = 'visible';
    if(isSuspend){
        const suspendHeading = document.getElementById('suspend-user-text');
        if(user_id == curr_user_id){
            suspendHeading.innerText = 'You cannot suspend yourself';
            
            document.getElementById('suspend-confirm-button').style.display = 'none';
            document.getElementById('suspend-cancel-button').innerHTML = 'Close';
        }else{
            suspendHeading.innerText = 'Do you want to suspend the selected user?';
            document.getElementById('suspend-confirm-button').style.display = 'block';
            document.getElementById('suspend-cancel-button').innerHTML = 'Cancel';

            const button = document.getElementById('suspend-confirm-button');
            button.addEventListener('click', () => {
                suspend_user(user_id);
            });
        }
        
        
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

function goToPreviousUsersPage(){
    let start = ((currentPage - 2) * 5) + 1;
    let end = (start + 4) <= rowCount ? (start + 4) : rowCount;

    for(let i = 1; i <= rowCount; i++){
        if(i >= start && i <= end){
            document.getElementById(`users-table-row-${i}`).style.display = 'table-row';
        } else {
            document.getElementById(`users-table-row-${i}`).style.display = 'none';
        }
    }

    currentPage = currentPage - 1;

    const currPageButton = document.getElementById('current-users-page-number');
    const prevPageButton = document.getElementById('previous-users-page-number');
    const nextPageButton = document.getElementById('next-users-page-number');

    const prevArrow = document.getElementById('previous-users-page');
    const nextArrow = document.getElementById('next-users-page');

    currPageButton.innerHTML = `<i class="fa-solid fa-${currentPage}"></i>`;

    nextPageButton.innerHTML = `<i class="fa-solid fa-${currentPage + 1}"></i>`;
    nextPageButton.style.display = 'block';
    nextArrow.disabled = false;
    nextArrow.style.color = 'var(--primary-color)';

    if(currentPage === 1){
        prevPageButton.style.display = 'none';
        prevArrow.disabled = true;
        prevArrow.style.color = 'var(--grey-color)';
    } else {
        prevPageButton.style.display = 'block';
        prevPageButton.innerHTML = `<i class="fa-solid fa-${currentPage - 1}"></i>`;
        prevArrow.disabled = false;
        prevArrow.style.color = 'var(--primary-color)';
    }

}

function goToNextUsersPage(){
    let start = (currentPage * 5) + 1;
    let end = (start + 4) <= rowCount ? (start + 4) : rowCount;

    for(let i = 1; i <= rowCount; i++){
        if(i >= start && i <= end){
            document.getElementById(`users-table-row-${i}`).style.display = 'table-row';
        } else {
            document.getElementById(`users-table-row-${i}`).style.display = 'none';
        }
    }

    currentPage = currentPage + 1;

    const currPageButton = document.getElementById('current-users-page-number');
    const prevPageButton = document.getElementById('previous-users-page-number');
    const nextPageButton = document.getElementById('next-users-page-number');

    const prevArrow = document.getElementById('previous-users-page');
    const nextArrow = document.getElementById('next-users-page');

    currPageButton.innerHTML = `<i class="fa-solid fa-${currentPage}"></i>`;

    if(currentPage < totalPages){
        nextPageButton.innerHTML = `<i class="fa-solid fa-${currentPage + 1}"></i>`;
    } else {
        nextPageButton.style.display = 'none';
        nextArrow.disabled = true;
        nextArrow.style.color = 'var(--grey-color)';
    }

    if(currentPage === 1){
        prevPageButton.style.display = 'none';
    } else {
        prevPageButton.style.display = 'block';
        prevPageButton.innerHTML = `<i class="fa-solid fa-${currentPage - 1}"></i>`;
    }


    prevArrow.disabled = false;
    prevArrow.style.color = 'var(--primary-color)';

}

goToNextUsersPage();

function searchUsersTable(){
    const searchInput = document.getElementById('search-users-input');
    const searchValue = searchInput.value.toLowerCase();

    if(searchValue === ''){
        for(let i = 1; i <= rowCount; i++){
            document.getElementById(`users-table-row-${i}`).style.display = 'table-row';
        }
        currentPage = 0;
        goToNextUsersPage();

        return;
    }

    for(let i = 1; i <= rowCount; i++){
        const username = document.getElementById(`users-table-username-${i}`).innerText.toLowerCase();
        const loginText = document.getElementById(`users-table-login-${i}`).innerText.toLowerCase();
        const roleText = document.getElementById(`users-table-login-${i}`).innerText.toLowerCase();

        if(username.includes(searchValue) || loginText.includes(searchValue) || roleText.includes(searchValue)){
            document.getElementById(`users-table-row-${i}`).style.display = 'table-row';
        } else {
            document.getElementById(`users-table-row-${i}`).style.display = 'none';
        }
    }
}

