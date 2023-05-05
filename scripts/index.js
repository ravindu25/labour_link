/*
    Javascript file for handling interaction on the index.html
 */

const registerButton = document.getElementById("register-button");
const registerModal = document.getElementById("register-modal");

const searchBackdrop = document.getElementById("search-backdrop");
const searchBar = document.getElementById("search-bar-input");

const workerRegisterButton = document.getElementById("worker-register-button");
const workerTypeSelectButton = document.getElementById("worker-type-select-button");

if(registerButton != null) registerButton.addEventListener('click',() => { openModal() });
registerModal.addEventListener('click', () => { closeModal() });
searchBar.addEventListener('click', () => { openSearchContainer() });
searchBackdrop.addEventListener('click', () => { closeSearchContainer() });
workerRegisterButton.addEventListener('click', () => {
    closeModal();
    openWorkerTypeModal()
});

workerTypeSelectButton.addEventListener('click', () => {
   const radioButtons = document.getElementsByName("job-type-select");
   for(let i = 0; i < radioButtons.length; i++){
       if(radioButtons[i].checked){
           window.location.href = "/labour_link/worker-registration.php?workertype=" + radioButtons[i].value;
           break;
       }
   }
});

function openModal(){
    const registerModal = document.getElementById("register-modal");
    const registerModalContent = document.getElementById("register-modal-content");

    registerModal.style.visibility = 'visible';
    registerModalContent.style.visibility = 'visible';
}

function openWorkerTypeModal(){
    const registerModal = document.getElementById("register-modal");
    const registerModalContent = document.getElementById("register-modal-content");
    const workerTypeModal = document.getElementById("worker-type-modal");

    registerModal.style.visibility = 'visible';
    registerModalContent.style.visibility = 'hidden';
    workerTypeModal.style.visibility = 'visible';
}

function closeModal(){
    const registerModal = document.getElementById("register-modal");
    const registerModalContent = document.getElementById("register-modal-content");

    registerModal.style.visibility = 'hidden';
    registerModalContent.style.visibility = 'hidden';
}

function openSearchContainer(){
    const searchBackdrop = document.getElementById("search-backdrop");
    const searchContainer = document.getElementById("search-component-container");
    const mainSearch = document.getElementById("search-main-input");

    searchBackdrop.style.visibility = 'visible';
    searchContainer.style.visibility = 'visible';
    mainSearch.focus();
}

function closeSearchContainer(){
    const searchBackdrop = document.getElementById("search-backdrop");
    const searchContainer = document.getElementById("search-component-container");

    searchBackdrop.style.visibility = 'hidden';
    searchContainer.style.visibility = 'hidden';
}