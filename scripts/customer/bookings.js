const backButton = document.getElementById("back-button");
const createBookingButton = document.getElementById("booking-create-button");
const bookingCreateCancelButton = document.getElementById("booking-create-cancel-button");

let allBookings = [];
let currentBookings = [];
let currPage = 1;
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

let XMLHttpRequestObject = false;

if(window.XMLHttpRequest){
    XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXObject){
    XMLHttpRequestObject = new ActiveXObject('Microsoft.XMLHTTP');
}

const previousPageButton = document.getElementById('previous-page');
previousPageButton.disabled = true;

function previousPage(){
    [currPage, currentBookings] = goToPreviousPage(currPage, allBookings);

    const currPageButton = document.getElementById('current-page');
    currPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;
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

    const currPageButton = document.getElementById('current-page');
    currPageButton.innerHTML = `<i class="fa-solid fa-${currPage}"></i>`;
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

    const bookingsTableBody = document.getElementById('bookings-table-body');

    rerenderBookings(selectedBookings);

    const previousPageButton = document.getElementById('previous-page');
    previousPageButton.disabled = false;

    return [currPage, selectedBookings];
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
            moreAction = `<button class="disable-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update</button>
                <button class="disable-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                </button>`;
        } else {
            moreAction = `<button class="update-button"><i class="fa-solid fa-pen"></i>&nbsp;&nbsp;Update</button>
                                    <button class="delete-button" onclick="openResetModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
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
    console.log(currentBookings);
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

    console.log(currentBookings);
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
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            allBookings = data;
            [currPage, currentBookings] = goToNextPage(0, allBookings);
        })
        .catch(error => console.log(error));
}

getBookings('http://localhost/labour_link/api/bookings.php');
