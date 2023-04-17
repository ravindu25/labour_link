function showSucessModal(){
    const backdropModal = document.getElementById('message-backdrop');
    const successMessageContainer = document.getElementById('booking-create-success');

    backdropModal.style.visibility = 'visible';
    successMessageContainer.style.visibility = 'visible';

    setTimeout(() => {
        backdropModal.style.visibility = 'hidden';
        successMessageContainer.style.visibility = 'hidden';
    }, 5000);
};

function showErrorModal(){
    const backdropModal = document.getElementById('message-backdrop');
    const failMessageContainer = document.getElementById('booking-create-fail');

    backdropModal.style.visibility = 'visible';
    failMessageContainer.style.visibility = 'visible';

    setTimeout(() => {
        backdropModal.style.visibility = 'hidden';
        failMessageContainer.style.visibility = 'hidden';
    }, 5000);
}