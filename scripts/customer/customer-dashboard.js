const backButton = document.getElementById("back-button");

backButton.addEventListener('click', () => { closeBookingDetailsModal() });

function openBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'visible';
    bookingDetails.style.visibility = 'visible';
}

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

// Get all the cards and add click event
let cards = document.getElementsByClassName('booking-card');
for(let card of cards) card.addEventListener('click', () => openBookingDetailsModal());