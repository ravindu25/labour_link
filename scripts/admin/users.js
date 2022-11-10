const backdropModal = document.getElementById("backdrop-modal");

backdropModal.addEventListener('click', () => { closeResetModal() });

function openResetModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const resetModalContent = document.getElementById("reset-login-content");

    backdropModal.style.visibility = 'visible';
    resetModalContent.style.visibility = 'visible';
}

function closeResetModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const resetModalContent = document.getElementById("reset-login-content");

    backdropModal.style.visibility = 'hidden';
    resetModalContent.style.visibility = 'hidden';
}