/*
    Javascript file for handling interaction on the index.html
 */

const registerButton = document.getElementById("register-button");
const registerModal = document.getElementById("register-modal");

const searchBackdrop = document.getElementById("search-backdrop");
const searchBar = document.getElementById("search-bar-input");

if(registerButton != null) registerButton.addEventListener('click',() => { openModal() });
registerModal.addEventListener('click', () => { closeModal() });
searchBar.addEventListener('click', () => { openSearchContainer() });
searchBackdrop.addEventListener('click', () => { closeSearchContainer() });

function openModal(){
    const registerModal = document.getElementById("register-modal");
    const registerModalContent = document.getElementById("register-modal-content");

    registerModal.style.visibility = 'visible';
    registerModalContent.style.visibility = 'visible';
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