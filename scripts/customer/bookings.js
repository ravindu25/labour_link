const backButton = document.getElementById("back-button");
const createBookingButton = document.getElementById("booking-create-button");
const bookingCreateCancelButton = document.getElementById("booking-create-cancel-button");

const bookingSearchButton = document.getElementById('booking-search-button');

let fetchedBookings = [];
let allBookings = [];
let currentBookings = [];
let currPage = 0;
let totalPages = Math.ceil(allBookings.length / 5);
let workerNameAsc = true;
let startDateAsc = true;
let endDateAsc = true;

backButton.addEventListener('click', () => { closeBookingDetailsModal() });
createBookingButton.addEventListener('click', () => {
    closeBookingDetailsModal();
    openCreateBookingModal();
});

bookingCreateCancelButton.addEventListener('click', () => {
    closeCreateBookingModal();
});


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

    const bookingStatusContainer = document.getElementById('booking-details-status-container');
    bookingStatusContainer.innerHTML = bookingStatusButton;

    document.getElementById('booking-details-job-type').innerText = currentBooking.workerType;
    document.getElementById('booking-details-worker-name').innerText = currentBooking.workerName;
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

    backdropModal.style.visibility = 'visible';
    bookingDetails.style.visibility = 'visible';
}

function closeBookingDetailsModal(){8888
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

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

function openDeleteModal(bookingId){
    const backdropModal = document.getElementById('backdrop-modal');
    const deleteBookingContainer = document.getElementById('delete-booking-container');
    const deleteButton = document.getElementById('delete-confirm-button');
    const loadingSpinnerContainer = document.getElementById('loader-container');

    deleteButton.addEventListener('click', async () => {
        await deleteBooking(bookingId);
    });

    loadingSpinnerContainer.style.display = 'none';
    backdropModal.style.visibility = 'visible';
    deleteBookingContainer.style.visibility = 'visible';
}

function closeDeleteModal(){
    const backdropModal = document.getElementById('backdrop-modal');
    const deleteBookingContainer = document.getElementById('delete-booking-container');

    backdropModal.style.visibility = 'hidden';
    deleteBookingContainer.style.visibility = 'hidden';
}

let XMLHttpRequestObject = false;

if(window.XMLHttpRequest){
    XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXObject){
    XMLHttpRequestObject = new ActiveXObject('Microsoft.XMLHTTP');
}

/*
    Purpose - Getting the most recent bookings
 */

function loadRecentBookings(allBookings){
    let nonRejectedBookings = [];
    let rejectedBookings = [];

    for(let i = 0; i < allBookings.length; i++){
        allBookings[i].sortingDate = new Date(allBookings[i].startDate);

        if(allBookings[i].status === 'Rejected'){
            rejectedBookings.push(allBookings[i]);
        } else {
            nonRejectedBookings.push(allBookings[i]);
        }
    }

    rejectedBookings.sort((first, second) => second.sortingDate - first.sortingDate);
    nonRejectedBookings.sort((first, second) => second.sortingDate - first.sortingDate);

    let allSortedBookings = [...nonRejectedBookings, ...rejectedBookings];

    const recentBookingsContainer = document.getElementById('recent-booking-container');

    if(allSortedBookings.length >= 5){
        for(let i = 0; i < 5; i++){
            let button = null;
            let currentBooking = allSortedBookings[i];

            let workerType = currentBooking.workerType;
            let workerName = currentBooking.workerName;
            let startDate = currentBooking.startDate;

            if(currentBooking.status === 'Pending'){
                button = '<button class="pending-button">Pending</button>';
            } else if(currentBooking.status === 'Accepted'){
                button = '<button class="in-pogress-button">Accepted</button>';
            } else if(currentBooking.status === 'Completed'){
                button = '<button class="completed-button">Completed</button>';
            } else {
                button = '<button class="rejected-button">Rejected</button>';
            }

            let htmlSeg = `<div class='booking-card' onclick="openBookingDetailsModal(${currentBooking.bookingId})">
                                    <div class='card-text'>
                                        <h3>${workerType}</h3>
                                        <p>Work by</p>
                                        <h4>${workerName}</h4>
                                    </div>
                                    <div class='booking-card-button-row'>
                                        <div class='badge-container'>
                                            <div class='blue-badge'>${startDate}</div>
                                        </div>
                                        ${button}
                                    </div>
                                </div>`;

            recentBookingsContainer.innerHTML += htmlSeg;
        }
    }
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
        prevArrow.style.color = 'var(--primary-background-color)';
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
        nextArrow.style.color = 'var(--primary-background-color)';
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
    prevArrow.style.color = 'var(--primary-background-color)';

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
                    <br/>
                    ${bookingStatus}
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
            loadRecentBookings(allBookings);
            loadInitialPage();
        })
        .catch(error => console.log(error));
}

getBookings(`http://localhost/labour_link/api/bookings.php?customerId=${userId}`);

/*
    Purpose - Perform searching in booking tables
 */

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
    if(booking.workerName.includes(searchTerm)) return true;
    if(booking.workerType.includes(searchTerm)) return true;
    if(booking.status.includes(searchTerm)) return true;

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

/*
    Purpose - Delete selected booking
 */

async function deleteBooking(bookingId){
    const bookingDeleteContent = document.getElementById('delete-booking-content');
    const bookingDeleteButtons = document.getElementById('delete-booking-buttons');
    const loadingSpinnerContainer = document.getElementById('loader-container');

    bookingDeleteButtons.style.display = 'none';
    bookingDeleteContent.style.display = 'none';
    loadingSpinnerContainer.style.display = 'block';

    fetch(`http://localhost/labour_link/api/bookings.php?bookingId=${bookingId}`, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(() => {
            const bookingMessage = document.getElementById('delete-booking-text');

            loadingSpinnerContainer.style.display = 'none';
            bookingDeleteContent.style.display = 'block';
            bookingMessage.innerHTML = `<i class="fa-solid fa-check"></i>&nbsp;&nbsp;Booking deleted successfully`;

            setTimeout(() => {
                closeDeleteModal();
                window.location.href = "../customer/bookings.php";
            }, 5000);
        })
        .catch((error) => {
            const bookingMessage = document.getElementById('delete-booking-text');

            bookingDeleteContent.style.display = 'block';
            bookingMessage.innerHTML = `<i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Booking deletion failed`;

            setTimeout(() => {
                closeDeleteModal();
                window.location.href = "../customer/bookings.php";
            }, 5000);
        });
}

