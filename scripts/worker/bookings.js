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
    document.getElementById('booking-details-contact-number').innerText = currentBooking.customerContactNo;
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
            }else if(booking.status === 'Accepted'){
                bookingStatus = "<span class='accepted-badge'>Accepted</span>";
            }else if(booking.status === 'Completed'){
                bookingStatus = "<span class='completed-badge'>Completed</span>";
            }else if(booking.status === 'Rejected'){
                bookingStatus = "<span class='rejected-badge'>Rejected</span>";
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

function gotoNextPendingPage(currentPendingPage,pendingBookings){
    let 
}

