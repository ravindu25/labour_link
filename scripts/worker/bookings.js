let allBookings = null;
let currentViewingBooking = null;

function openBookingDetailsModal(bookingId) {
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");
    const rejectButton = document.querySelector("#reject-button");
    const acceptButton = document.querySelector("#accept-button");

    const currentBooking = allBookings.find(booking => booking.bookingId == bookingId);
    currentViewingBooking = currentBooking;

    let bookingStatusButton = null;
    if (currentBooking.status === 'Pending') {
        bookingStatusButton = '<button class="pending-button">Pending</button>';
    } else if (currentBooking.status === 'Accepted-by-worker') {
        bookingStatusButton = '<button class="in-pogress-button">Accepted by worker</button>';
    } else if(currentBooking.status === 'Accepted-by-customer'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted</button>';
    } else if(currentBooking.status === 'Completed'){
        bookingStatusButton = '<button class="completed-button">Completed</button>';
    } else if(currentBooking.status === 'Rejected-by-worker') {
        bookingStatusButton = '<button class="rejected-button">Rejected by worker</button>';
    } else if(currentBooking.status === 'Rejected-by-customer') {
        bookingStatusButton = '<button class="rejected-button">Rejected by customer</button>';
    }

    const bookingStatusContainer = document.getElementById('booking-details-status-container');
    bookingStatusContainer.innerHTML = bookingStatusButton;

    console.log(currentBooking);

    document.getElementById('booking-details-job-type').innerText = currentBooking.workerType;
    document.getElementById('booking-details-customer-name').innerText = currentBooking.customerName;
    document.getElementById('booking-details-contact-number').innerText = currentBooking.customerPhoneNumber;
    document.getElementById('booking-details-customer-address').innerText = currentBooking.customerAddress;
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

    if(currentBooking.status === 'Pending'){
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h3>Please add the amount needs to be paid</h3>
            <div class="payment-amount-input-container">
                <label class="payment-amount-label" for="payment-amount-input">Rs.</label>
                &nbsp;&nbsp;
                <input type="text" class="payment-amount-input" id="payment-amount-input"/>
            </div>
        `;

        const paymentAmountInput = document.getElementById('payment-amount-input');
        paymentAmountInput.addEventListener('change', () => {
            paymentAmountValidity(currentBooking.bookingId);
        });

        buttonContainer.innerHTML = `
            <button type="button" class="primary-button" id="reject-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Reject booking</button>
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
            <button type="button" class="disable-button" id="accept-button" disabled><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Accept booking</button>
        `;
        
        const rejectButton = document.getElementById('reject-button');
        rejectButton.addEventListener('click', rejectCurrentViewingBooking);
    } else if(currentBooking.status === 'Accepted-by-worker'){
        const paymentContainer = document.getElementById('payment-details-container');
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'LKR',
        });

        const currencyAmount = formatter.format(currentBooking.paymentAmount);

        paymentContainer.innerHTML = `
                        <h3>Amount that needs to be paid</h3>
                        <h2 id="payment-details-amount-text">${currencyAmount}</h2>
                        `;
    } else if(currentBooking.status === 'Rejected-by-worker'){
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by worker!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    } else if(currentBooking.status === 'Rejected-by-customer'){
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by customer!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    } else if(currentBooking.status === 'Accepted-by-customer'){
        const paymentContainer = document.getElementById('payment-details-container');
        const buttonContainer = document.getElementById('back-button-container');
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'LKR',
        });

        const currencyAmount = formatter.format(currentBooking.paymentAmount);

        paymentContainer.innerHTML = `
                        <h3>Amount that needs to be paid</h3>
                        <h2 id="payment-details-amount-text">${currencyAmount}</h2>
                        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    } else if(currentBooking.status === 'Completed'){
        const paymentContainer = document.getElementById('payment-details-container');
        const buttonContainer = document.getElementById('back-button-container');
        const formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'LKR',
        });

        const currencyAmount = formatter.format(currentBooking.paymentAmount);

        paymentContainer.innerHTML = `
                        <h3>Amount that needs to be paid</h3>
                        <h2 id="payment-details-amount-text">${currencyAmount}</h2>
                        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    }
    const closeButton = document.getElementById('back-button');
    closeButton.addEventListener('click', () => closeBookingDetailsModal());

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
            fetchedBookings = data;
            allBookings = data;
            pendingBookings = fetchedBookings.filter(booking => booking.status === 'Pending');
            totalPendingPages = Math.ceil(pendingBookings.length / 5);
            totalPages = Math.ceil(allBookings.length / 5);
            loadInitialPage();
        })
        .catch(error => console.log(error));
}

getBookings(`http://localhost/labour_link/api/bookings.php?workerId=${userId}`);



function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

// Get the accept and reject buttons
const acceptButton = document.getElementById('accept-button');
const rejectButton = document.getElementById('reject-button');

/*
    Purpose - Perform and apply pagination to the booking table
*/
const previousPageButton = document.getElementById('previous-page');
previousPageButton.disabled = true;
    
function previousPage(){
    [currPage, currentBookings] = goToPreviousPage(currPage, allBookings);
    
    const currPageButton = document.getElementById('current-page-number');
    const prevPageButton = document.getElementById('previous-page-number');
    const nextPageButton = document.getElementById('next-page-number');
    
    const prevArrow = document.getElementById('previous-page');
    const nextArrow = document.getElementById('next-page');
    
    currPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;
    
    if(currPage > 1) {
         prevPageButton.innerHTML = `<i class="fa-solid fa-${currPage - 1}"></i>`;
    } else {
        prevPageButton.style.display = 'none';
        prevArrow.disabled = true;
        prevArrow.style.color = 'var(--primary-background-shade-color)';
    }
    
        nextArrow.disabled = false;
        nextArrow.style.color = 'var(--primary-color)';
        nextPageButton.style.display = 'block';
        nextPageButton.innerHTML = `<i class="fa-solid fa-${currPage + 1}"></i>`;
}
    
function goToPreviousPage(currPage, allBookings){
    let selectedBookings = [];

    currPage -= 1;
    let start = (currPage - 1) * 5;

    for(let i = start; i < start + 5; i++){
        selectedBookings.push(allBookings[i]);
    }

    const bookingsTableBody = document.getElementById('bookings-table-body');

    rerenderBookings(selectedBookings);

    if(currPage === 1){
        const previousPageButton = document.getElementById('previous-page');
        previousPageButton.disabled = true;
    }

    const nextPageButton = document.getElementById('next-page');
    nextPageButton.disabled = false;

    return [currPage, selectedBookings];
}
    
function nextPage(){
    [currPage, currentBookings] = goToNextPage(currPage, allBookings);

    const currPageButton = document.getElementById('current-page-number');
    const prevPageButton = document.getElementById('previous-page-number');
    const nextPageButton = document.getElementById('next-page-number');

    const prevArrow = document.getElementById('previous-page');
    const nextArrow = document.getElementById('next-page');

    currPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;

    if(currPage < totalPages){
        nextPageButton.innerHTML = `<i class="fa-solid fa-${currPage + 1}"></i>`;
    } else {
        nextPageButton.style.display = 'none';
        nextArrow.disabled = true;
        nextArrow.style.color = 'var(--primary-background-shade-color)';
    }

    prevArrow.disabled = false;
    prevArrow.style.color = 'var(--primary-color)';
    prevPageButton.style.display = 'block';
    prevPageButton.innerHTML = `<i class="fa-solid fa-${currPage - 1}"></i>`;
}
    
function goToNextPage(currPage, allBookings){
    let selectedBookings = [];

    let start = (currPage) * 5;
    currPage += 1;

    for(let i = start; i < start + 5; i++){
        if(i < allBookings.length){
            selectedBookings.push(allBookings[i]);
        } else{
            const nextPageButton = document.getElementById('next-page');
            nextPageButton.disabled = true;
            break;
        }
    }

    rerenderBookings(selectedBookings);

    const previousPageButton = document.getElementById('previous-page');
    previousPageButton.disabled = false;


    return [currPage, selectedBookings];
}
    
function loadInitialPage(){
    nextPage();

    const prevPageButton = document.getElementById('previous-page-number');
    const nextPageButton = document.getElementById('next-page-number');
    const prevArrow = document.getElementById('previous-page');
    const nextArrow = document.getElementById('next-page');


    prevPageButton.style.display = 'none';
    prevArrow.disabled = true;
    prevArrow.style.color = 'var(--primary-background-shade-color)';

    if(currPage < totalPages) {
        nextArrow.disabled = false;
        nextArrow.style.color = 'var(--primary-color)';
        nextPageButton.style.display = 'block';
        nextPageButton.innerHTML = `<i class="fa-solid fa-${currPage + 1}"></i>`;
    }
}
    
function rerenderBookings(currentBookings){
    const bookingsTableBody = document.getElementById('bookings-table-body');

    bookingsTableBody.innerHTML = '';
    currentBookings.forEach(booking => {
        let bookingStatus = '';
        if(booking.status === 'Pending'){
            bookingStatus = "<span class='pending-badge'>Pending</span>";
        }else if(booking.status === 'Accepted-by-worker' || booking.status === 'Accepted-by-customer'){
            bookingStatus = `<span class='accepted-badge'>${booking.status}</span>`;
        }else if(booking.status === 'Completed'){
            bookingStatus = "<span class='completed-badge'>Completed</span>";
        }else if(booking.status === 'Rejected-by-worker' || booking.status === 'Rejected-by-customer'){
            bookingStatus = `<span class='rejected-badge'>${booking.status}</span>`;
        }

        let moreAction = '';
        if(booking.status === 'Completed' || booking.status === 'Rejected'){
            moreAction = `<button class="update-button" onclick="openBookingDetailsModal(${booking.bookingId})"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;View</button>
                <button class="disable-button" onclick="openDeleteModal(${booking.bookingId})"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                </button>`;
        } else {
            moreAction = `<button class="update-button" onclick="openBookingDetailsModal(${booking.bookingId})"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;View</button>
                                    <button class="delete-button" onclick="openDeleteModal(${booking.bookingId})"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                                    </button>`
        }

        bookingsTableBody.innerHTML += `
            <tr class='main-tr'>
               <td class='main-td' style='text-align: left;'>
                    ${booking.workerName}
               </td>
                    <td class='main-td'>${booking.startDate}</td>
                    <td class='main-td'>${booking.endDate}</td>
                    <td class='main-td'>
                        <div class='more-button-container'>
                            ${moreAction}
                        </div>
                    </td>
            </tr>
                            
        `;
    })
}

// Fetch data to pending for request table
const pendingPreviousPageButton = document.getElementById('previous_page');
pendingPreviousPageButton.disabled = true;

function previous_page(){
    [currentPage, currentPendingBookings] = goToPendingTablePreviousPage(currentPage,pendingBookings);

    const currentPendingPageButton = document.getElementById('current_page_number');
    const previousPendingPageButton = document.getElementById('previous_page_number');
    const nextPendingPageButton = document.getElementById('next_page_number');

    const previousPendingArrow = document.getElementById('previuos_page');
    const nextPendingArrow = document.getElementById('next_page');

    currentPendingPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;
    
    if(currentPage>1){
        previousPendingPageButton.innerHTML = `<i class="fa-solid fa-${currPage - 1}"></i>`;
    }
    else{
        previousPendingPageButton.style.display = 'none';
        previousPendingArrow.disabled = true;
        previousPendingArrow.style.color = 'var(--primary-background-shade-color)';
    }

    nextPendingArrow.disabled = false;
    nextPendingArrow.style.color = 'var(--primary-color)';
    nextPendingPageButton.style.display = 'block';
    nextPendingPageButton.innerHTML = `<i class="fa-solid fa-${currPage + 1}"></i>`;

}

function goToPendingTablePreviousPage(currentPage,pendingBookings){
    let selectedPendingBookings = [];

    c
}

// function nextPendingPage(){
//     [currPage, currentBookings] = goToNextPage(currentPage, allBookings);

//     const currPageButton = document.getElementById('current-page-number');
//     const prevPageButton = document.getElementById('previous-page-number');
//     const nextPageButton = document.getElementById('next-page-number');

//     const prevArrow = document.getElementById('previous-page');
//     const nextArrow = document.getElementById('next-page');

//     currPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;

//     if(currPage < totalPages){
//         nextPageButton.innerHTML = `<i class="fa-solid fa-${currPage + 1}"></i>`;
//     } else {
//         nextPageButton.style.display = 'none';
//         nextArrow.disabled = true;
//         nextArrow.style.color = 'var(--primary-background-shade-color)';
//     }

//     prevArrow.disabled = false;
//     prevArrow.style.color = 'var(--primary-color)';
//     prevPageButton.style.display = 'block';
//     prevPageButton.innerHTML = `<i class="fa-solid fa-${currPage - 1}"></i>`;
// }

function goToPendingTablePreviousPage(currnetPendingPage,pendingBookings){
    let selectedPendingBookings = [];

    currnetPendingPage -= 1;

}


function loadInitialPendingPage(){
    nextPendingpage();

    const prevPendingPageButton = document.getElementById('previous_page_number');
    const nextPendingPageButton = document.getElementById('next_Page_number');
    const prevPendingArrow = document.getElementById('previous_page');
    const nextPendingArrow = document.getElementById('next_page');

    prevPendingPageButton.style.display = 'none';
    prevPendingArrow.disabled = truue;
    prevPendingArrow.style.color = 'var(--primary-background-shade-color)';

    if(currentPendingPage < totalPendingPages){
        nextPendingArrow.disabled = false;
        nextPendingArrow.style.color = 'var(--primary-color)';
        nextPendingPageButton.style.display = 'block';
        nextPendingPageButton.innerHTML = `<i class="fa-solid fa-${currentPendingPage + 1}"></i>`;

    }
}

function nextPendingpage(){
    [currentPendingPage,currentPendingBookings] = gotoNextPendingPage(currPendingPage,pendingBookings);

    const currentPendingPageButton = document.getElementById('current_page_number');
    const previousPendingPageButton = document.getElementById('previous_page_number');
    const nextPendingPageButton = document.getElementById('next_page_number');

    const previousPendingArrow = document.getElementById('previuos_page');
    const nextPendingArrow = document.getElementById('next_page');

    currentPendingPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;

    if(currentPendingPage<totalPendingPages){
        nextPendingPageButton.innerHTML = `<i class="fa-solid fa-${currentPendingPage}"></i>`;
    }
    else{
        nextPendingPageButton.style.display = 'none';
        nextPendingArrow.disabled = true;
        nextPendingArrow = 'var(--primary-background-shade-color)';
    }

    previousPendingArrow.disabled = false;
    previousPendingArrow.style.color = 'var(--primary-color)';
    previousPendingPageButton.style.display = 'block';
    previousPendingPageButton.innerHTML = `<i class="fa-solid fa-${currentPendingPage - 1}"></i>`;
}

/*
 * Checking the payment amount validity
 */

function paymentAmountValidity(){
    const paymentAmountInput = document.getElementById('payment-amount-input');
    const acceptButton = document.getElementById('accept-button');
    const inputValue = parseFloat(paymentAmountInput.value);

    if(!isNaN(inputValue) && isFinite(inputValue) && inputValue > 0){
        const bookingAcceptButton = document.getElementById('accept-button');
        bookingAcceptButton.addEventListener('click', AcceptCurrentViewingBooking);

        acceptButton.disabled = false;
        acceptButton.classList.add('primary-button');
        acceptButton.classList.remove('disable-button');
    } else {
        const bookingAcceptButton = document.getElementById('accept-button');
        bookingAcceptButton.removeEventListener('click', AcceptCurrentViewingBooking);

        acceptButton.disabled = true;
        acceptButton.classList.remove('primary-button');
        acceptButton.classList.add('disable-button');
    }
}

function rejectCurrentViewingBooking(){
    const bookingId = currentViewingBooking.bookingId;
    const status = 'Rejected-by-worker';

    fetch(`http://localhost/labour_link/api/bookings.php?action=updateStatus`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ bookingId, status })
    })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success'){
                const backdropModal = document.getElementById('backdrop-modal');
                const rejectSuccessContainer = document.getElementById('booking-reject-success');
                const bookingDetails = document.getElementById("booking-details-container");

                bookingDetails.style.visibility = 'hidden';
                backdropModal.style.visibliity = 'visible';
                rejectSuccessContainer.style.visibility = 'visible';

                setTimeout(() => {
                    backdropModal.style.visibliity = 'hidden';
                    rejectSuccessContainer.style.visibility = 'hidden';
                    window.location.reload();
                }, 5000);
            } else {
                const backdropModal = document.getElementById('backdrop-modal');
                const rejectFailedContainer = document.getElementById('booking-reject-fail');
                const bookingDetails = document.getElementById("booking-details-container");

                bookingDetails.style.visibility = 'hidden';
                backdropModal.style.visibliity = 'visible';
                rejectFailedContainer.style.visibility = 'visible';

                setTimeout(() => {
                    backdropModal.style.visibliity = 'hidden';
                    rejectFailedContainer.style.visibility = 'hidden';
                    window.location.reload();
                }, 5000);
            }
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');
            const bookingDetails = document.getElementById("booking-details-container");

            bookingDetails.style.visibility = 'hidden';
            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });


}

function AcceptCurrentViewingBooking(){
    const bookingId = currentViewingBooking.bookingId;
    const status = 'Accepted-by-worker';
    const paymentAmount = document.getElementById('payment-amount-input').value;

    fetch(`http://localhost/labour_link/api/bookings.php?action=updateStatus`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ bookingId, status, paymentAmount })
    })
        .then(response => response.json())
        .then(data => {
            if(data.status === 'success'){
                const backdropModal = document.getElementById('backdrop-modal');
                const acceptSuccessContainer = document.getElementById('booking-accepted-success');
                const bookingDetails = document.getElementById("booking-details-container");

                bookingDetails.style.visibility = 'hidden';
                backdropModal.style.visibliity = 'visible';
                acceptSuccessContainer.style.visibility = 'visible';

                setTimeout(() => {
                    backdropModal.style.visibliity = 'hidden';
                    acceptSuccessContainer.style.visibility = 'hidden';
                    window.location.reload();
                }, 5000);
            } else {
                const backdropModal = document.getElementById('backdrop-modal');
                const acceptFailedContainer = document.getElementById('booking-accept-fail');
                const bookingDetails = document.getElementById("booking-details-container");
                const errorMessageText = document.getElementById('booking-accept-fail-text');
                const errorMessage = data.message;

                if(errorMessage !== undefined || errorMessage !== ''){
                    errorMessageText.innerText = errorMessage;
                }

                bookingDetails.style.visibility = 'hidden';
                backdropModal.style.visibliity = 'visible';
                acceptFailedContainer.style.visibility = 'visible';

                setTimeout(() => {
                    backdropModal.style.visibliity = 'hidden';
                    acceptFailedContainer.style.visibility = 'hidden';
                    window.location.reload();
                }, 5000);
            }
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');
            const bookingDetails = document.getElementById("booking-details-container");

            bookingDetails.style.visibility = 'hidden';
            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

