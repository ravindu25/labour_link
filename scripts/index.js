/*
    Javascript file for handling interaction on the index.html
 */

const registerButton = document.getElementById("register-button");
const registerModal = document.getElementById("register-modal");

registerButton.addEventListener('click',() => { openModal() });
registerModal.addEventListener('click', () => { closeModal() });

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