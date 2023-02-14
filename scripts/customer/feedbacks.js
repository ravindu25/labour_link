let comAndRejBookings = null;
let currentBookings = [];
let totalPages = 0;
let currentPage = 1;

function nextBookingPage(currentPage, allBookings){
    currentBookings = [];
    let upperBound = ((currentPage * 3 + 2) < allBookings.length) ? (currentPage * 3 + 2) : allBookings.length - 1;

    for(let i = currentPage * 3; i <= upperBound; i++) currentBookings.push(allBookings[i]);

    currentPage += 1;
    rerenderCreateFeedbackBookings(currentPage, currentBookings);

    return currentBookings;
}

function goToNextBookingPage(){
    currentBookings = nextBookingPage(currentPage, comAndRejBookings);
}

function previousBookingPage(currentPage, allBookings){
    currentBookings = [];
    let upperBound = (((currentPage - 1) * 3 + 2) < allBookings.length) ? ((currentPage - 1) * 3 + 2) : allBookings.length;

    for(let i = (currentPage - 1) * 3; i <= upperBound; i++) currentBookings.push(allBookings[i]);

    currentPage -= 1;
    rerenderCreateFeedbackBookings(currentPage, currentBookings);

    return currentBookings;
}

function goToPreviousBookingPage(){
    currentBookings = previousBookingPage(currentPage, comAndRejBookings);
}

function rerenderCreateFeedbackBookings(currentPage, currentBookings){
    const bookingCardContainer = document.getElementById('create-feedback-bookings-container');
    let firstBooking = true;

    if(currentPage > 1){
        bookingCardContainer.innerHTML = `
            <div class="pagination-card" id="create-feedback-bookings-previous" onclick="goToPreviousBookingPage()">
                <i class="fa-solid fa-arrow-left"></i>
            </div>`;
    } else {
        bookingCardContainer.innerHTML = `
            <div class="pagination-card-disabled" id="create-feedback-bookings-previous">
                <i class="fa-solid fa-arrow-left"></i>
            </div>`;
    }

    bookingCardContainer.innerHTML += '<div class="feedback-cards-container" id="create-feedback-bookings-cards-container" style="margin-top: 0"></div>';

    const bookingsContainer = document.getElementById('create-feedback-bookings-cards-container');

    currentBookings.forEach(booking => {
        let bookingStatusButton = null;
        if(booking.status === 'Pending'){
            bookingStatusButton = '<button class="pending-button">Pending</button>';
        } else if(booking.status === 'Accepted'){
            bookingStatusButton = '<button class="in-pogress-button">Accepted</button>';
        } else if(booking.status === 'Completed'){
            bookingStatusButton = '<button class="completed-button">Completed</button>';
        } else {
            bookingStatusButton = '<button class="rejected-button">Rejected</button>';
        }

        let divStyling = firstBooking ? 'feedback-booking-card feedback-booking-card-selected' : 'feedback-booking-card';

        currentBookingId = firstBooking ? booking.bookingId : currentBookingId;

        firstBooking = false;

        bookingsContainer.innerHTML += `
            <div class='${divStyling}' onclick='selectBooking(${booking.bookingId})' id='booking-card-${booking.bookingId}'>
                <div class='card-text'>
                    <h3>${booking.workerType}</h3>
                    <p>Work by</p>
                    <h4>${booking.workerName}</h4>
                </div>
                <div class='booking-card-button-row'>
                    <div class='badge-container'>
                        <div class='blue-badge'>${booking.startDate}</div>
                    </div>
                    ${bookingStatusButton}
                </div>
             </div>`;
    });

    if(currentPage < totalPages){
        bookingCardContainer.innerHTML += `
             <div class="pagination-card" id="create-feedback-bookings-next" onclick="goToNextBookingPage()">
                 <i class="fa-solid fa-arrow-right"></i>
            </div>`;
    } else {
        bookingCardContainer.innerHTML += `
             <div class="pagination-card-disabled" id="create-feedback-bookings-next">
                 <i class="fa-solid fa-arrow-right"></i>
            </div>`;
    }
}

function selectBooking(bookingId){
    const parentContainer = document.getElementById('create-feedback-bookings-cards-container');
    const nextButton = document.getElementById('first-page-next-button');
    const bookingsCards = Array.from(parentContainer.children);

    currentBookingId = bookingId;

    bookingsCards.forEach(bookingCard => {
        if(bookingCard.classList.contains('feedback-booking-card-selected')){
            bookingCard.classList.remove('feedback-booking-card-selected');
            bookingCard.classList.add('feedback-booking-card');
        }
    });

    const bookingCard = document.getElementById(`booking-card-${bookingId}`);

    if(!bookingCard.classList.contains('feedback-booking-card-selected')){
        bookingCard.classList.add('feedback-booking-card-selected');
    }
}

function goToNextFeedbackPage(){
    console.log(currentBookingId);
}

function loadAllBookings(dataSource){
    fetch(dataSource, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            comAndRejBookings = data.filter(booking => booking.status === 'Completed' || booking.status === 'Rejected');
            totalPages = Math.ceil(comAndRejBookings.length / 3);
        })
        .catch(error => console.log(error));
}

loadAllBookings(`http://localhost/labour_link/api/bookings.php?customerId=${userId}`);