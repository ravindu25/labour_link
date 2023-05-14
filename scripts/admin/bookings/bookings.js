let fetchedBookings = [];
let currentBookings = [];
let currPage = 0;
let totalPages = null;

let customerNameAsc = true;
let workerNameAsc = true;
let startDateAsc = true;
let endDateAsc = true;

function loadbookingChartData(){
    fetch(`http://localhost/labour_link/api/charts/bookings.php?term=getAdminBookingData`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        // Load monthly booking chart
        loadMonthlyBookingChart(data.monthlyBookingResults);
        // Load online mode bookings chart
        loadOnlineModeBookings(data.onlineBookingResults);
    })
    .catch(error => {
        const backdropModal = document.getElementById("backdrop-modal");
        const errorMessageContainer = document.getElementById("error-message-container");

        console.log(error);

        backdropModal.style.visibility = 'visible';
        errorMessageContainer.style.visibility = 'visible';
    });
}

loadbookingChartData();

function showBookingDetails(bookingId) {
    fetch(`http://localhost/labour_link/api/bookings.php?bookingId=${bookingId}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            allBookings.push(data);
            openBookingDetailsModal(data.bookingId);
        })
        .catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

function openBookingDetailsModal(bookingId){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    const currentBooking = allBookings.find(booking => booking.bookingId == bookingId);
    currentViewingBooking = currentBooking;
    
    let bookingStatusButton = null;
    if(currentBooking.status === 'Pending'){
        bookingStatusButton = '<button class="pending-button">Pending</button>';
    } else if(currentBooking.status === 'Accepted-by-customer'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted by customer</button>';
    }  else if(currentBooking.status === 'Accepted-by-worker'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted by worker</button>';
    } else if(currentBooking.status === 'Completed'){
        bookingStatusButton = '<button class="completed-button">Completed</button>';
    } else if(currentBooking.status === 'Rejected-by-worker') {
        bookingStatusButton = '<button class="rejected-button">Rejected by worker</button>';
    } else if(currentBooking.status === 'Rejected-by-customer') {
        bookingStatusButton = '<button class="rejected-button">Rejected by customer</button>';
    }

    const bookingStatusContainer = document.getElementById('booking-details-status-container');
    bookingStatusContainer.innerHTML = bookingStatusButton;
    const workerLink = `<a href="http://localhost/labour_link/worker/view-worker-profile.php?workerId=${currentBooking.workerId}">${currentBooking.workerName}</a>`;

    document.getElementById('booking-details-customer-name').innerText = currentBooking.customerName;
    document.getElementById('booking-details-job-type').innerHTML = currentBooking.workerType;
    document.getElementById('booking-details-worker-name').innerHTML = workerLink;
    document.getElementById('booking-details-start-date').innerText = currentBooking.startDate;

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
            <h3>Waiting for worker to decided payment amount</h3>
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Not decided yet!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        `;
    } else if(currentBooking.status === 'Accepted-by-worker'){
        const buttonContainer = document.getElementById('back-button-container');
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

        buttonContainer.innerHTML = `
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        `;
    } else if(currentBooking.status === 'Rejected-by-worker'){
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by worker!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        `;
    } else if(currentBooking.status === 'Rejected-by-customer'){
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by customer!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
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
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
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
            <button type="button" class="primary-button" style="margin: 0 8px;" id="back-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Close</button>
        `;
    }
    const closeButton = document.getElementById('back-button');
    closeButton.addEventListener('click', () => closeBookingDetailsModal());

    backdropModal.style.visibility = 'visible';
    bookingDetails.style.visibility = 'visible';
}

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

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
        }else if(booking.status === 'Accepted-by-worker'){
            bookingStatus = "<span class='accepted-badge'>Accepted by worker</span>";
        }else if(booking.status === 'Accepted-by-customer' || booking.status === 'Accepted'){
            bookingStatus = "<span class='accepted-badge'>Accepted by customer</span>";
        }else if(booking.status === 'Completed'){
            bookingStatus = "<span class='completed-badge'>Completed</span>";
        }else if(booking.status === 'Rejected-by-worker'){
            bookingStatus = "<span class='rejected-badge'>Rejected by worker</span>";
        }else if(booking.status === 'Rejected-by-customer'){
            bookingStatus = "<span class='rejected-badge'>Rejected by customer</span>";
        }

        let moreAction = `<button class="update-button" onclick="openBookingDetailsModal(${booking.bookingId})"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;View</button>
                `;

        bookingsTableBody.innerHTML += `
            <tr class='main-tr'>
               <td class='main-td' style='text-align: left;'>
                    ${booking.customerName}
                    <br/>
                    ${bookingStatus}
               </td>
                    <td class='main-td'>
                        <a href='http://localhost/labour_link/worker/view-worker-profile.php?workerId=${booking.workerId}'>
                            ${booking.workerName}
                        </a>
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

function getBookings(dataSource){
    fetch(dataSource, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            fetchedBookings = data;
            allBookings = data;
            totalPages = Math.ceil(allBookings.length / 5);
            loadInitialPage();
        })
        .catch(error => console.log(error));
}

getBookings(`http://localhost/labour_link/api/bookings.php`);

function sortByColumn(fieldName, asc, currentBookings){
    if(asc === true) {
        currentBookings = currentBookings.sort((a, b) => {
            if(a[`${fieldName}`] < b[`${fieldName}`]) return 1;
            else return -1;
        });
    } else {
        currentBookings = currentBookings.sort((a, b) => {
            if(a[`${fieldName}`] >= b[`${fieldName}`]) return 1;
            else return -1;
        });
    }

    return currentBookings;
}

document.getElementById('customer-name-sort').addEventListener('click', () =>{
    rerenderBookings(sortByColumn('customerName', !customerNameAsc, currentBookings));
    customerNameAsc = !customerNameAsc;

    const customerNameSort = document.getElementById('customer-name-sort');

    if(customerNameAsc === true){
        customerNameSort.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`;
    } else {
        customerNameSort.innerHTML = `<i class="fa-solid fa-arrow-down"></i>`;
    }
});

document.getElementById('worker-name-sort').addEventListener('click', () =>{
    rerenderBookings(sortByColumn('workerName', !workerNameAsc, currentBookings));
    workerNameAsc = !workerNameAsc;

    const workerNameSort = document.getElementById('worker-name-sort');

    if(workerNameAsc === true){
        workerNameSort.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`;
    } else {
        workerNameSort.innerHTML = `<i class="fa-solid fa-arrow-down"></i>`;
    }
});

document.getElementById('start-date-sort').addEventListener('click', () =>{
    rerenderBookings(sortByColumn('startDate', !startDateAsc, currentBookings));
    startDateAsc = !startDateAsc;

    const startDateSort = document.getElementById('start-date-sort');

    if(startDateAsc === true){
        startDateSort.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`;
    } else {
        startDateSort.innerHTML = `<i class="fa-solid fa-arrow-down"></i>`;
    }
});

document.getElementById('end-date-sort').addEventListener('click', () =>{
    rerenderBookings(sortByColumn('endDate', !endDateAsc, currentBookings));
    endDateAsc = !endDateAsc;

    const endDateSort = document.getElementById('end-date-sort');

    if(endDateAsc === true){
        endDateSort.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`;
    } else {
        endDateSort.innerHTML = `<i class="fa-solid fa-arrow-down"></i>`;
    }
});

const bookingSearchButton = document.getElementById('booking-search-button');

function searchBookings(searchTerm, currentBookingsInput){

    let resultBookings = [];
    currentBookingsInput.forEach(booking => {
        if(searchParticularBooking(searchTerm, booking)){
            resultBookings.push(booking);
        }
    });

    allBookings = resultBookings;
    totalPages = Math.ceil(allBookings.length / 5);
    currPage = 0;
    loadInitialPage();

}

/*
    searchParticularBooking - delegating filter given booking according to the search term
 */

function searchParticularBooking(searchTerm, booking){
    if(booking.customerName.includes(searchTerm)) return true;
    if(booking.workerName.includes(searchTerm)) return true;
    if(booking.startDate.includes(searchTerm)) return true;
    if(booking.endDate.includes(searchTerm)) return true;

    return false;
}

bookingSearchButton.addEventListener('click', () => {
    const bookingSearchInput = document.getElementById('booking-search');

    allBookings = fetchedBookings;

    if(bookingSearchInput.value !== '') {
        searchBookings(bookingSearchInput.value, allBookings);
    } else {
        totalPages = Math.ceil(allBookings.length / 5);
        currPage = 0;
        loadInitialPage();
    }
});