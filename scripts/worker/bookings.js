let allBookings = null;

function openBookingDetailsModal(bookingId){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    const currentBooking = allBookings.find(booking => booking.bookingId == bookingId);

    let bookingStatusButton = null;
    if(currentBooking.status === 'Pending'){
        bookingStatusButton = '<button class="pending-button">Pending</button>';
    } else if(currentBooking.status === 'Accepted'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted</button>';
    } else if(currentBooking.status === 'Completed'){
        bookingStatusButton = '<button class="completed-button">Completed</button>';
    } else {
        bookingStatusButton = '<button class="rejected-button">Rejected</button>';
    }

    // Add click event listener to accept button
    acceptButton.addEventListener('click', function() {
        updateBookingStatus(bookingId, 'accepted');
    });

    backdropModal.style.visibility = 'visible';
    bookingDetails.style.visibility = 'visible';
}

function getBookings(dataSource){
    fetch(dataSource, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            //fetchedBookings = data;
            allBookings = data;
           // totalPages = Math.ceil(allBookings.length / 5);
            //loadInitialPage();
        })
        .catch(error => console.log(error));
}

getBookings(`http://localhost/labour_link/api/bookings.php?workerId=${userId}`);

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    acceptButton.removeEventListener('click', function() {
        updateBookingStatus(bookingId, 'accepted');
    });

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

// Booking create form
function openCreateBookingModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetailsContainer = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'visible';
    bookingDetailsContainer.style.visibility = 'visible';
}

function closeCreateBookingModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetailsContainer = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetailsContainer.style.visibility = 'hidden';
}

// Get the accept and reject buttons
const acceptButton = document.getElementById('accept-button');
const rejectButton = document.getElementById('reject-button');

// // Get the accept and reject buttons
// const acceptButton = document.getElementById('accept-button');
// const rejectButton = document.getElementById('reject-button');




// Add click event listener to reject button
rejectButton.addEventListener('click', function() {
    updateBookingStatus('rejected');
    closeBookingDetailsModal();
});

// Function to update booking status
function updateBookingStatus(bookingId, status) {
    console.log(`${bookingId} - ${status}`);

    // Send a fetch request to update the booking status
    fetch('http://localhost/labour_link/api/updateBookingStatus.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            booking_id: bookingId,
            status: status
        })
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response from the server
        closeBookingDetailsModal();
        if (data.success) {
            // Update the UI to reflect the new status
            const statusButton = document.querySelector('.status-button');
            statusButton.innerHTML = status;
        } else {
            // Handle the error
            alert(data.error);
        }
    })
    .catch(error => {
        // Handle the fetch error
        console.error(error);
    });
}
