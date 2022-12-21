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

function closeLoader(){
    const loaderContainer = document.getElementById("loader-container");
    const mainContent = document.getElementById("main-content-container");

    loaderContainer.style.display = 'none';
    mainContent.style.display = 'block';
    console.log('Function executed!');
}