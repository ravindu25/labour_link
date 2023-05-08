let allBookings = null;

function openBookingDetailsModal(bookingId){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");
    const rejectButton = document.querySelector("#reject-button");
    const acceptButton = document.querySelector("#accept-button");

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

    const bookingStatusContainer = document.getElementById('booking-details-status-container');
    bookingStatusContainer.innerHTML = bookingStatusButton;

    document.getElementById('booking-details-job-type').innerText = currentBooking.workerType;
    document.getElementById('booking-details-customer-name').innerText = currentBooking.customerName;
    document.getElementById('booking-details-start-date').innerText = currentBooking.startDate;

    if(currentBooking.status === 'Pending' || currentBooking.status === 'Accepted') {
        const startDate = new Date();
        const endDate = new Date(currentBooking.endDate);

        let difference = endDate - startDate;
        const bookingCountDown = document.getElementById('booking-details-countdown');

        if(difference >= 0) {
            const days = Math.floor(difference / (1000 * 60 * 60 * 24));
            difference -= days * (1000 * 60 * 60 * 24);
            const hours = Math.floor(difference / (1000 * 60 * 60));
            const remainingText = `${days} days and ${hours} hours`;

            bookingCountDown.style.color = 'var(--primary-color)';
            bookingCountDown.innerText = remainingText;
        } else {
            bookingCountDown.style.color = 'var(--danger-color)';
            bookingCountDown.innerText = 'The booking has expired';
        }
    } else {
        document.getElementById('remaining-time-container').style.display = 'none';
    }

    const paymentImage = document.getElementById('payment-image');
    const paymentImageText = document.getElementById('payment-method-text');

    if(currentBooking.paymentMethod === 'Manual'){
        paymentImage.src = '../assets/customer/dashboard/undraw_savings_re_eq4w.svg';
        paymentImageText.innerText = 'Manual payments';
    } else {
        paymentImage.src = '../assets/customer/dashboard/undraw_credit_card_re_blml.svg';
        paymentImageText.innerText = 'Online payments';
    }

    if(currentBooking.status === 'Pending' && currentBooking.difference >=0){
        bookingStatusButton = '<button class="pending-button">Pending</button>';
        rejectButton.disabled = false;
        acceptButton.disabled = false;

        rejectButton.classList.remove("disable-button");
        acceptButton.classList.remove("disable-button");
    } 
    else if(currentBooking.status === 'Accepted'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted</button>';
        rejectButton.disabled = true;
        acceptButton.disabled = true;

        rejectButton.className = "disable-button";
        acceptButton.className = "disable-button";
    } 
    else if(currentBooking.status === 'Completed'){
        bookingStatusButton = '<button class="completed-button">Completed</button>';
        rejectButton.disabled = true;
        acceptButton.disabled = true;

        rejectButton.className = "disable-button";
        acceptButton.className = "disable-button";
    }
    else {
        bookingStatusButton = '<button class="rejected-button">Rejected</button>';
        rejectButton.disabled = true;
        acceptButton.disabled = true;

        rejectButton.className = "disable-button";
        acceptButton.className = "disable-button";
    }

    // Add click event listener to accept button
    acceptButton.addEventListener('click', function() {
        updateBookingStatus(bookingId, 'Accepted');
    });

    rejectButton.addEventListener('click', function() {
        updateBookingStatus(bookingId,'Rejected');
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

     // Add click event listener to accept button
    acceptButton.removeEventListener('click', function() {
        updateBookingStatus(bookingId, 'Accepted');
    });

    // Add click event listener to reject button
    rejectButton.addEventListener('click', function() {
        updateBookingStatus(bookingId,'Rejected');
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
            const statusContainer = document.getElementById(`booking-card-status-${bookingId}`);
            if(status=='Accepted') {
                statusContainer.innerHTML = '<button class="in-pogress-button">Accepted</button>';
            }
            else{
                statusContainer.innerHTML = '<button class="rejected-button">Rejected</button>';
            }

            location.reload();

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
