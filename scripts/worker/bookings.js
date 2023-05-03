<<<<<<< Updated upstream
function openBookingDetailsModal(bookingId){
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
=======
// // Get the accept and reject buttons
// const acceptButton = document.getElementById('accept-button');
// const rejectButton = document.getElementById('reject-button');
>>>>>>> Stashed changes

// // Add click event listener to accept button
// acceptButton.addEventListener('click', function() {
//     updateBookingStatus('accepted');
// });

// // Add click event listener to reject button
// rejectButton.addEventListener('click', function() {
//     updateBookingStatus('rejected');
// });

// // Function to update booking status
// function updateBookingStatus(status) {
//     // Get booking ID from URL or HTML
//     const bookingId = document.getElementById('booking-id').value;

//     // Send a fetch request to update the booking status
//     fetch('updateBookingStatus.php', {
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             booking_id: bookingId,
//             status: status
//         })
//     })
//     .then(response => response.json())
//     .then(data => {
//         // Handle the response from the server
//         if (data.success) {
//             // Update the UI to reflect the new status
//             const statusButton = document.querySelector('.status-button');
//             statusButton.innerHTML = status;
//         } else {
//             // Handle the error
//             alert(data.error);
//         }
//     })
//     .catch(error => {
//         // Handle the fetch error
//         console.error(error);
//     });
// }
