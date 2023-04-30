let comAndRejBookings = null;
let currentBookings = [];
let totalPages = 0;
let currentPage = 1;
let choices = [];
let bookingRating = {'punctuality': 0, 'efficient': 0, 'professionalism': 0};

function showFeedbackContainer(){
    const createFeedbackContainer = document.getElementById('create-feedback-container');
    const firstPage = document.getElementById('first-page');
    const secondPage = document.getElementById('second-page');
    const thirdPage = document.getElementById('third-page');
    const backdropModal = document.getElementById('backdrop-modal');

    createFeedbackContainer.style.visibility = 'visible';
    firstPage.style.display = 'block';
    secondPage.style.display = 'none';
    thirdPage.style.display = 'none';
    backdropModal.style.visibility = 'visible';
}

function hideFeedbackContainer(){
    const createFeedbackContainer = document.getElementById('create-feedback-container');
    const backdropModal = document.getElementById('backdrop-modal');

    createFeedbackContainer.style.visibility = 'hidden';
    backdropModal.style.visibility = 'hidden';
}


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

function updateStarRating(text, ratingAmount){
    bookingRating[text] = ratingAmount;
    for(let i = 1; i <= 5; i++){
        const starContainer = document.getElementById(`star-${text}-${i}`);

        if(i <= ratingAmount) {
            starContainer.innerHTML = `<i class="fa-solid fa-star"></i>`;
        } else {
            starContainer.innerHTML = `<i class="fa-regular fa-star"></i>`;
        }
    }
}

function goToNextFeedbackPage(){
    const firstPage = document.getElementById('first-page');
    const secondPage = document.getElementById('second-page');
    const ratingTitle = document.getElementById('create-feedback-third-title');
    const ratingPara = document.getElementById('create-feedback-third-paragraph');

    const [selectedBooking] = comAndRejBookings.filter(booking => booking.bookingId == currentBookingId);

    ratingTitle.innerText = `Feedback about ${selectedBooking.workerName.toLowerCase()}!`;
    ratingPara.innerHTML = `<b>Please provide more details about ${selectedBooking.workerName.toLowerCase()}.</b>This will assist us in delivering enhanced services.`;


    firstPage.style.display = 'none';
    secondPage.style.display = 'block';
}

function goBackFeedbackFirstPage(){
    const firstPage = document.getElementById('first-page');
    const secondPage = document.getElementById('second-page');

    firstPage.style.display = 'block';
    secondPage.style.display = 'none';
}

function goNextFeedbackThirdPage(){
    const secondPage = document.getElementById('second-page');
    const thirdPage = document.getElementById('third-page');
    const ratingTitle = document.getElementById('create-feedback-title');
    const ratingPara = document.getElementById('create-feedback-paragraph');

    const [selectedBooking] = comAndRejBookings.filter(booking => booking.bookingId == currentBookingId);

    ratingTitle.innerText = `Feedback about ${selectedBooking.workerName.toLowerCase()}!`;
    ratingPara.innerHTML = `<b>Please provide rating about ${selectedBooking.workerName.toLowerCase()}.</b>This will assist us in delivering enhanced services.`;

    let answers = document.getElementsByName('feedback-answers');

    for(let i = 0; i < answers.length; i++){
        if(answers[i].checked){
            choices.push(answers[i].value);
        }
    }

    secondPage.style.display = 'none';
    thirdPage.style.display = 'block';
}

function goBackFeedbackSecondPage(){
    const secondPage = document.getElementById('second-page');
    const thirdPage = document.getElementById('third-page');

    secondPage.style.display = 'block';
    thirdPage.style.display = 'none';
}

function createFeedback(){
    const feedbackTextArea = document.getElementById('feedback-textarea');
    const customerFeedback = feedbackTextArea.value;

    const feedbackResult = {'bookingId': currentBookingId, 'starRating': bookingRating, 'choices': choices, 'written-feedback': customerFeedback};

    console.log(feedbackResult);
    //Send AJAX call to insert feedback into DB

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
   if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         if(this.responseText.trim() == "Success"){
                alert('Feedback successfully submitted');
                
        }else{
                alert('Feedback submission failed');
        }
    }
   
   }
   xmlhttp.open("POST", "http://localhost/labour_link/customer/insertfeedback.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xmlhttp.send("bookingId="+currentBookingId+"&starRatingPunctuality="+bookingRating.punctuality+"&starRatingEfficiency="+bookingRating.efficient+"&starRatingProfessionalism="+bookingRating.professionalism+"&choices="+choices+"&writtenFeedback="+customerFeedback);
    
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

function showFeedbackDetails(feedbackToken){
    const backdrop = document.getElementById('backdrop-modal');
    const feedbackDetailsContainer = document.getElementById('feedback-details-container');

    fetch(`http://localhost/labour_link/api/feedbacks.php?feedbackToken=${feedbackToken}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
        .then(data => {
            /*
             * Setting up the worker details
             */
            document.getElementById('feedback-details-worker-image').src = `../assets/profile-image/${data.workerId}.jpg`;
            document.getElementById('feedback-details-worker-name').innerText = data.workerName;
            document.getElementById('feedback-details-booking-date').innerText = data.createdTimestamp.split(' ')[0];
            document.getElementById('feedback-details-worker-details-link').href = `http://localhost/labour_link/worker/view-worker-profile.php?workerId=${data.workerId}`;

            updateStarContainer('update-star-punctuality', 1, 5, parseInt(data.ratingPunctuality));
            updateStarContainer('update-star-efficient', 1, 5, parseInt(data.ratingEfficiency));
            updateStarContainer('update-star-professionalism', 1, 5, parseInt(data.ratingProfessionalism));

            if(data.writtenFeedback === '' || data.writtenFeedback === null){
                document.getElementById('feedback-details-comment-container').style.display = 'none';
            } else {
                document.getElementById('feedback-details-comment-container').style.display = 'block';
                document.getElementById('feedback-details-comment-text').innerText = data.writtenFeedback;
            }

            let extraObservations = '';

            if(data.extraObservations.length == 0){
                document.getElementById('feedback-details-extra-observations-container').style.display = 'none';
            } else {
                document.getElementById('feedback-details-extra-observations-container').style.display = 'block';
            }

            for(let i = 0; i < data.extraObservations.length; i++){
                extraObservations += `<span class="red-badge">${data.extraObservations[i]}</span>`;
            }
            document.getElementById('feedback-details-extra-observations').innerHTML = extraObservations;

            backdrop.style.visibility = 'visible';
            feedbackDetailsContainer.style.visibility = 'visible';
        })
        .catch(error => console.log(error));


}

function updateStarContainer(starId, startIndex, endIndex, fillEndIndex){
    // First paint the filled stars
    for(let i = startIndex; i <= fillEndIndex; i++){
        document.getElementById(`${starId}-${i}`).innerHTML = '<i class="fa-solid fa-star"></i>';
    }
    // Second paint the not filled starts
    for(let i = fillEndIndex + 1; i <= endIndex; i++) {
        document.getElementById(`${starId}-${i}`).innerHTML = '<i class="fa-regular fa-star"></i>';
    }
}

function hideFeedbackDetails(){
    const backdrop = document.getElementById('backdrop-modal');
    const feedbackDetailsContainer = document.getElementById('feedback-details-container');

    backdrop.style.visibility = 'hidden';
    feedbackDetailsContainer.style.visibility = 'hidden';
}
