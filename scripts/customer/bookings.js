const backButton = document.getElementById("back-button");
const createBookingButton = document.getElementById("booking-create-button");

backButton.addEventListener('click', () => { closeBookingDetailsModal() });
createBookingButton.addEventListener('click', () => {
    closeBookingDetailsModal();
    openCreateBookingModal();
})

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

// Booking create form
function openCreateBookingModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const createBookingContainer = document.getElementById("create-booking-container");

    backdropModal.style.visibility = 'visible';
    createBookingContainer.style.visibility = 'visible';
}

function closeCreateBookingModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const createBookingContainer = document.getElementById("create-booking-container");

    backdropModal.style.visibility = 'hidden';
    createBookingContainer.style.visibility = 'hidden';
}