let comAndRejBookings = null;
let currentBookings = [];
let totalPages = 0;
let currentPage = 1;
let choices = [];
let bookingRating = {'punctuality': 0, 'efficient': 0, 'professionalism': 0};
let feedbackPageNumber = 0;
let maxFeedbackPages = null;
let allFeedbacks = null;
let allTempFeedbacks = null;
let currentViewingFeedbacks = [];
let sortingDetails = { 'writtenFeedback': null, 'workerName': null, 'createdTimestamp': null };
let currentUpdatingFeedback = null;
let tempUpdatingFeedback = null;
const feedbackSearchButton = document.getElementById('feedback-search-input-button');

const extraObservationButton = document.getElementById('feedback-observation-update');
extraObservationButton.addEventListener('click', () => {
    hideFeedbackDetails();
    showObservationUpdateModal();
});


feedbackSearchButton.addEventListener('click', () => {
    allFeedbacks = allTempFeedbacks;
    const paginationContainer = document.getElementById('feedback-details-pagination-container');
    const searchTerm = document.getElementById('feedback-search').value.toLowerCase();

    if(searchTerm == '') {
        allFeedbacks = allTempFeedbacks;
        maxFeedbackPages = Math.ceil(allFeedbacks.length / 5);

        feedbackPageNumber = 1;
        updateFeedbackTable(allFeedbacks, feedbackPageNumber);
        updateFeedbackTablePagination(feedbackPageNumber, maxFeedbackPages);
        paginationContainer.style.display = 'flex' ;
    } else {
        let tempSearchFeedbacks = [];

        allFeedbacks.forEach(feedback => {
            if (feedback.writtenFeedback.toLowerCase().includes(searchTerm)) {
                tempSearchFeedbacks.push(feedback);
            } else if (feedback.workerName.toLowerCase().includes(searchTerm)) {
                tempSearchFeedbacks.push(feedback);
            }
        });

        if(tempSearchFeedbacks.length == 0) {
            const tableBody = document.getElementById('feedback-details-body-table');

            tableBody.innerHTML = `
            <tr class='empty-table-body-tr'>
                <td colspan='5' class='empty-table-body-td'>
                    <img src="../../labour_link/assets/empty-search.svg" alt="empty search" class="empty-table-body-image">
                    <h3>No results found!</h3>
                </td>
            </tr>
            `;

            paginationContainer.style.display = 'none' ;
        } else {
            allFeedbacks = tempSearchFeedbacks;
            maxFeedbackPages = Math.ceil(allFeedbacks.length / 5);

            feedbackPageNumber = 1;
            updateFeedbackTable(allFeedbacks, feedbackPageNumber);
            updateFeedbackTablePagination(feedbackPageNumber, maxFeedbackPages);
            paginationContainer.style.display = 'flex' ;
        }
    }
});

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
    const parentContainer = document.getElementById('create-feedback-bookings-cards-container'); // For getting the parent of booking cards
    const nextButton = document.getElementById('first-page-next-button');
    const bookingsCards = Array.from(parentContainer.children); // [booking-card-1, booking-card-2, ...	]

    currentBookingId = bookingId;

    bookingsCards.forEach(bookingCard => { // Setting the styling of all booking cards to default
        if(bookingCard.classList.contains('feedback-booking-card-selected')){
            bookingCard.classList.remove('feedback-booking-card-selected');
            bookingCard.classList.add('feedback-booking-card');
        }
    });

    const bookingCard = document.getElementById(`booking-card-${bookingId}`);

    if(!bookingCard.classList.contains('feedback-booking-card-selected')){ // Setting the activated styling of the selected booking card
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

function goToNextFeedbackPage(){  //go to first page from scend page
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

function getAllFeedbacks(customerId){
    fetch(`http://localhost/labour_link/api/feedbacks.php?customerId=${customerId}`, {
        method: 'GET',
        contentType: 'application/json'
    })
    .then(response => response.json())
        .then(data => {
            allFeedbacks = data;
            allTempFeedbacks = allFeedbacks;

            if(allFeedbacks.length == 0){
                const recentFeedbacksContainar = document.getElementById('recent-feedbacks-container');
                const feedbackSearchInput = document.getElementById('feedback-search-container');
                const feedbackTableContainer = document.getElementById('feedback-search-table-container');

                recentFeedbacksContainar.innerHTML = `
                    <div class='empty-feedback-container'>
                        <img src="../../labour_link/assets/customer/feedbacks/empty-feedbacks.svg" alt="Empty Feedbacks" class="empty-feedback-image">
                        <h3>You haven't provided any feedback yet</h3>
                    </div>
                `

                feedbackSearchInput.style.display = 'none';
                feedbackTableContainer.style.display = 'none';
            } else {

                maxFeedbackPages = Math.ceil(allFeedbacks.length / 5);

                feedbackPageNumber += 1;
                updateFeedbackTable(allFeedbacks, feedbackPageNumber);
                updateFeedbackTablePagination(feedbackPageNumber, maxFeedbackPages);
            }
        }).catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
    });
}

function updateFeedbackTable(feedbacks, currentPage){
    const startIndex = (currentPage - 1) * 5;
    const endIndex = ((currentPage ) * 5) <= feedbacks.length ? (currentPage) * 5 : feedbacks.length;
    let currentFeedbacks = [];
    const feedbackTableBody = document.getElementById('feedback-details-body-table');
    let feedbackTableInnerHtml = '';

    for(let i = startIndex; i < endIndex; i++){
        currentFeedbacks.push(feedbacks[i]);
        feedbackTableInnerHtml += getFeedbackRow(feedbacks[i]);
    }

    feedbackTableBody.innerHTML = feedbackTableInnerHtml;
    currentViewingFeedbacks = currentFeedbacks;
}

function getFeedbackRow(feedback){
    let feedbackComment = feedback.writtenFeedback === null || feedback.writtenFeedback === '' ? '<span style="color: #A6A6A6">No written Comment</span>' : feedback.writtenFeedback;

    if(feedbackComment.length > 80){
        feedbackComment = feedbackComment.substring(0, 80) + '...';
    }

    let observationsArray = feedback.extraObservations.map(observation => {
        if(observation === "suspect-mobile-using"){
          observation = "Excess Mobile Phone Usage";
        } else if(observation === "charged-more"){
          observation = "Charge More than Agreed";
        } else if(observation === "suspect-drug-using"){
          observation = "Drug Usage during Work";
        }
        
        if(observation === ''){
            return `<span class='green-badge'>No observations</span>`;
        } else {
            return `<span class='red-badge'>${observation}</span>`
        }
    });
    const observationText = observationsArray.join(' ');
    let ratingData = 0;

    fetch(`http://localhost/labour_link/api/get-worker-rating.php?workerId=${feedback.workerId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
    }).then(reponse => reponse.json())
        .then(data => {
            ratingData = data.workerRating;
            document.getElementById(`worker-rating-${feedback.workerId}`).innerText = ratingData;
        })
        .catch(error => {
            console.log(error);
        })

    const feedbackRow = `
        <tr class="main-tr">
            <td class="main-td" style="text-align: left;">
                ${feedbackComment}
                <br/>
                ${observationText}
            </td>
            <td class="main-td">
                <a href="http://localhost/labour_link/worker/view-worker-profile.php?workerId=${feedback.workerId}">
                ${feedback.workerName}
            </td>
            <td id="worker-rating-${feedback.workerId}">${feedback.workerId}</td>
            <td class="main-td">${feedback.createdTimestamp.split(' ')[0]}</td>
            <td class="main-td">
                <div class="more-button-container">
                    <button class="update-button" onclick="showFeedbackDetails(${feedback.feedbackToken})"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;View
                    </button>
                    <button class="delete-button" onclick="openDeleteModal()"><i class="fa-solid fa-trash"></i>&nbsp;&nbsp;Delete
                    </button>
                </div>
            </td>
        </tr>
    `;

    return feedbackRow;
}

function openDeleteModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const deleteModal = document.getElementById('delete-feedback-container');

    backdrop.style.visibility = 'visible';
    deleteModal.style.visibility = 'visible';

    //Add event listener to the delete button
    const deleteButton = document.getElementById('delete-confirm-button');
    deleteButton.addEventListener('click', deleteFeedback);


}

function deleteFeedback(){
    const successMessageContainer = document.getElementById('feedback-delete-success');

    
    fetch ('http://localhost/labour_link/customer/deleteFeedback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            feedbackToken : currentViewingFeedbacks[0].feedbackToken
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const deleteModal = document.getElementById('delete-feedback-container');
            const successModal = document.getElementById('feedback-delete-success');

            deleteModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const deleteModal = document.getElementById('delete-feedback-container');
            const failedModal = document.getElementById('feedback-delete-fail');

            deleteModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })





}

function closeDeleteModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const deleteModal = document.getElementById('delete-feedback-container');

    backdrop.style.visibility = 'hidden';
    deleteModal.style.visibility = 'hidden';
}

function updateFeedbackTablePagination(currentPage, maximumPages){
    const backButton = document.getElementById('feedback-back-button');
    const backNumberButton = document.getElementById('feedback-back-number-button');
    const currentNumberButton = document.getElementById('feedback-current-number-button');
    const nextNumberButton = document.getElementById('feedback-next-number-button');
    const nextButton = document.getElementById('feedback-next-button');

    if(currentPage === 1){
        backButton.disabled = true;
        backButton.style.color = 'var(--primary-shade-color)';
        backButton.style.transition = 'none';

        backNumberButton.style.display = 'none';
    } else {
        backButton.disabled = false;
        backButton.style.color = 'var(--primary-color)';
        backButton.style.transition = 'box-shadow .2s, -ms-transform .1s, -webkit-transform .1s, transform .1s';

        backNumberButton.style.display = 'block';
        backNumberButton.innerHTML = `<i class="fa-solid fa-${currentPage - 1}"></i>`;
    }

    currentNumberButton.innerHTML = `<i class="fa-solid fa-${currentPage}"></i>`;

    if(currentPage === maximumPages){
        nextButton.disabled = true;
        nextButton.style.color = 'var(--primary-shade-color)';
        nextButton.style.transition = 'none';

        nextNumberButton.style.display = 'none';
    } else {
        nextButton.disabled = false;
        nextButton.style.color = 'var(--primary-color)';
        nextButton.style.transition = 'box-shadow .2s, -ms-transform .1s, -webkit-transform .1s, transform .1s';

        nextNumberButton.style.display = 'block';
        nextNumberButton.innerHTML = `<i class="fa-solid fa-${currentPage + 1}"></i>`;
    }

}

function reRenderFeedbackTable(feedbacks){
    let currentFeedbacks = [];
    const feedbackTableBody = document.getElementById('feedback-details-body-table');
    let feedbackTableInnerHtml = '';

    for(let i = 0; i < feedbacks.length; i++){
        currentFeedbacks.push(feedbacks[i]);
        feedbackTableInnerHtml += getFeedbackRow(feedbacks[i]);
    }

    feedbackTableBody.innerHTML = feedbackTableInnerHtml;
    currentViewingFeedbacks = currentFeedbacks;
}

getAllFeedbacks(userId);

function goToPreviousFeedbackTablePage(){
    feedbackPageNumber -= 1;
    updateFeedbackTable(allFeedbacks, feedbackPageNumber);
    updateFeedbackTablePagination(feedbackPageNumber, maxFeedbackPages);
}

function goToNextFeedbackTablePage(){
    feedbackPageNumber += 1;
    updateFeedbackTable(allFeedbacks, feedbackPageNumber);
    updateFeedbackTablePagination(feedbackPageNumber, maxFeedbackPages);
}

function sortFeedbacks(field){

    const sortingButton = document.getElementById(`sort-${field}-button`);
    if(sortingDetails[field] === 'DSC' || sortingDetails[field] === null) {
        console.log(field);
        // Perform ascending sort
        currentViewingFeedbacks = currentViewingFeedbacks.sort((a, b) => {
            if(a[`${field}`] < b[`${field}`]) return 1;
            else return -1;
        });

        reRenderFeedbackTable(currentViewingFeedbacks);
        sortingDetails[field] = 'ASC';
        sortingButton.innerHTML = `<i class="fa-solid fa-arrow-down"></i>`;
    } else if(sortingDetails[field] === 'ASC'){
        // Perform decending sort
        currentViewingFeedbacks = currentViewingFeedbacks.sort((a, b) => {
            if(a[`${field}`] > b[`${field}`]) return 1;
            else return -1;
        });

        reRenderFeedbackTable(currentViewingFeedbacks);
        sortingDetails[field] = 'DSC';
        sortingButton.innerHTML = `<i class="fa-solid fa-arrow-up"></i>`;
    }
}

function showFeedbackDetails(feedbackToken){
    const backdrop = document.getElementById('backdrop-modal');
    const feedbackDetailsContainer = document.getElementById('feedback-details-container');

    //Get the date of creation of the feedback from DB


    fetch(`http://localhost/labour_link/api/feedbacks.php?feedbackToken=${feedbackToken}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
        .then(data => {
            /*
             * Setting up the worker details
             */
            
            
            document.getElementById('feedback-details-rating-header').innerHTML="  <h1>Worker rating</h1>&nbsp;&nbsp;<button class=\"icon-button\" id=\"feedback-rating-update\"><i class=\"fa-solid fa-pen-nib\"></i></button>";
            const feedbackRatingUpdateButton = document.getElementById('feedback-rating-update');
            feedbackRatingUpdateButton.addEventListener('click', () => {
                currentUpdatingFeedback = data;
                tempUpdatingFeedback = {...currentUpdatingFeedback};
                hideFeedbackDetails(data);
                showRatingUpdateModal(data.feedbackToken);
            });

            currentUpdatingFeedback = data;

            document.getElementById('feedback-details-worker-image').src = `../assets/worker/profile-images/worker-3.jpg`;
            document.getElementById('feedback-details-worker-name').innerHTML = `${data.workerName}&nbsp;&nbsp;<i class="fa-solid fa-arrow-up-right-from-square"></i>`;
            document.getElementById('feedback-details-booking-date').innerText = `Feedback created date ${data.createdTimestamp.split(' ')[0]}`;
            document.getElementById('feedback-details-worker-details-link').href = `http://localhost/labour_link/worker/view-worker-profile.php?workerId=${data.workerId}`;

            const punWidth = parseInt(data.ratingProfessionalism) * 20;
            document.getElementById('feedback-details-progress-bar-punctuality').style.width = `${punWidth}%`;
            document.getElementById('feedback-details-progress-bar-punctuality-text').innerText = `${data.ratingProfessionalism} out of 5`;

            const effeWidth = parseInt(data.ratingEfficiency) * 20;
            document.getElementById('feedback-details-progress-bar-efficiency').style.width = `${effeWidth}%`;
            document.getElementById('feedback-details-progress-bar-efficiency-text').innerText = `${data.ratingEfficiency} out of 5`;

            const proffWidth = parseInt(data.ratingProfessionalism) * 20;
            document.getElementById('feedback-details-progress-bar-professionalism').style.width = `${proffWidth}%`;
            document.getElementById('feedback-details-progress-bar-professionalism-text').innerText = `${data.ratingProfessionalism} out of 5`;



            if(data.writtenFeedback === '' || data.writtenFeedback === null){
                const feedbackCommentHeader = document.getElementById('feedback-details-comment-header');

                feedbackCommentHeader.innerHTML = '<h1 id="feedback-details-comment-heading" style="color: var(--danger-color); text-align: center">No written feedbacks</h1>&nbsp;&nbsp;<button class="icon-button" id="feedback-comment-update" style="color: var(--danger-color)"><i class="fa-solid fa-pen-nib"></i></button>';
                feedbackCommentHeader.style.justifyContent = 'center';

                const commentUpdateButton = document.getElementById('feedback-comment-update');
                commentUpdateButton.addEventListener('click', () => {
                    hideFeedbackDetails();
                    showCommentUpdateModal();
                });

                document.getElementById('feedback-details-comment-text').innerText = '';
            } else {
                document.getElementById('feedback-details-comment-container').style.display = 'block';
                const feedbackCommentHeader = document.getElementById('feedback-details-comment-header');

                feedbackCommentHeader.innerHTML = '<h1 id="feedback-details-comment-heading" style="color: var(--primary-color); text-align: left">Written feedback</h1>&nbsp;&nbsp;<button class="icon-button" id="feedback-comment-update" style="color: var(--primary-color)"><i class="fa-solid fa-pen-nib"></i></button>';
                feedbackCommentHeader.style.justifyContent = 'start';

                const commentUpdateButton = document.getElementById('feedback-comment-update');
                commentUpdateButton.addEventListener('click', () => {
                    hideFeedbackDetails();
                    showCommentUpdateModal();
                });

                document.getElementById('feedback-details-comment-text').innerText = data.writtenFeedback;
            }

            let extraObservations = '';

            if(data.extraObservations.length === 0 || (data.extraObservations.length === 1 && data.extraObservations[0] === '')){
                const extraObservationHeading = document.getElementById('feedback-details-observations-header');
                const extraObservationContainer = document.getElementById('feedback-details-extra-observations');
                const extraObservationButton = document.getElementById('feedback-observation-update');

                extraObservationHeading.innerText = 'No extra observations';
                extraObservationHeading.style.color = 'var(--danger-color)';
                extraObservationContainer.innerText = '';
                extraObservationButton.style.color = 'var(--danger-color)';
            } else {
                const extraObservationHeading = document.getElementById('feedback-details-observations-header');
                const extraObservationButton = document.getElementById('feedback-observation-update');

                extraObservationHeading.innerText = 'Extra observations';
                extraObservationHeading.style.color = 'var(--primary-color)';
                extraObservationButton.style.color = 'var(--primary-color)';

                for(let i = 0; i < data.extraObservations.length; i++){
                    if(data.extraObservations[i] == 'suspect-drug-using'){
                        extraObservations += `<span class="red-badge">Drug Usage during Work</span>`;
                    }else if(data.extraObservations[i] == 'charged-more'){
                        extraObservations += `<span class="red-badge">Charged More than Agreed</span>`;
                    }else if(data.extraObservations[i] == 'suspect-mobile-using'){
                        extraObservations += `<span class="red-badge">Excess Mobile Phone Usage</span>`;
                    }else{
                        extraObservations += `<span class="red-badge">${data.extraObservations[i]}</span>`;
                    }
                }
                document.getElementById('feedback-details-extra-observations').innerHTML = extraObservations;
            }

            document.getElementById('feedback-details-booking-button').addEventListener('click', () => {
                hideFeedbackDetails(data);
                openBookingDetailsModal(data.bookingId);
            });

            backdrop.style.visibility = 'visible';
            feedbackDetailsContainer.style.visibility = 'visible';
        })
        .catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });


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

function hideFeedbackDetails(feedback){
    const backdrop = document.getElementById('backdrop-modal');
    const feedbackDetailsContainer = document.getElementById('feedback-details-container');
    const feedbackRatingUpdateButton = document.getElementById('feedback-rating-update');

    document.getElementById('feedback-details-booking-button').removeEventListener('click', () => { showBookingDetails(data.bookingId) });
    feedbackRatingUpdateButton.removeEventListener('click', () => { showRatingUpdateModal(feedback.feedbackToken) });


    backdrop.style.visibility = 'hidden';
    feedbackDetailsContainer.style.visibility = 'hidden';
}

function openBookingDetailsModal(bookingId){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    fetch(`http://localhost/labour_link/api/bookings.php?bookingId=${bookingId}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
        .then(data => {
            const currentBooking = data;

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
        })
        .catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });


}

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

function showRatingUpdateModal(feedbackToken){
    const backdropModal = document.getElementById("backdrop-modal");
    const ratingUpdateModal = document.getElementById("feedback-rating-update-container");
    const feedback = allFeedbacks.find(feedback => feedback.feedbackToken === feedbackToken);

    if(feedback === null){
        const backdrop = document.getElementById('backdrop-modal');
        const errorMessageContainer = document.getElementById('error-message-container');

        console.log(error);

        backdrop.style.visibility = 'visible';
        errorMessageContainer.style.visibility = 'visible';
    } else {
        editStarRating('ratingPunctuality', parseInt(feedback.ratingPunctuality));
        editStarRating('ratingEfficiency', parseInt(feedback.ratingEfficiency));
        editStarRating('ratingProfessionalism', parseInt(feedback.ratingProfessionalism));

        backdropModal.style.visibility = 'visible';
        ratingUpdateModal.style.visibility = 'visible';
    }
}

function hideRatingUpdateModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const ratingUpdateModal = document.getElementById("feedback-rating-update-container");

    backdropModal.style.visibility = 'hidden';
    ratingUpdateModal.style.visibility = 'hidden';
}

function editStarRating(text, ratingAmount){
    currentUpdatingFeedback[text] = ratingAmount;
    const ratingmeasures = ['ratingPunctuality', 'ratingEfficiency', 'ratingProfessionalism'];
    let ratingChanged = false;

    ratingmeasures.forEach(measure => {
        console.log(`${measure} ${parseInt(currentUpdatingFeedback[measure])} ${parseInt(tempUpdatingFeedback[measure])}`);
        if(parseInt(currentUpdatingFeedback[measure]) !== parseInt(tempUpdatingFeedback[measure])){
            ratingChanged = true;
        }
    });

    const updateButton = document.getElementById('feedback-rating-update-button');
    const ratingUpdateButton = document.getElementById('feedback-rating-update-button');
    if(ratingChanged){
        updateButton.addEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        ratingUpdateButton.disabled = false;
        ratingUpdateButton.classList.remove('disabled-button');
        ratingUpdateButton.classList.add('primary-button');
    } else {
        updateButton.removeEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        ratingUpdateButton.disabled = true;
        ratingUpdateButton.classList.remove('primary-button');
        ratingUpdateButton.classList.add('disabled-button');
    }

    for(let i = 1; i <= 5; i++){
        const starContainer = document.getElementById(`star-edit-${text}-${i}`);

        if(i <= ratingAmount) {
            starContainer.innerHTML = `<i class="fa-solid fa-star"></i>`;
        } else {
            starContainer.innerHTML = `<i class="fa-regular fa-star"></i>`;
        }
    }
}

function showObservationUpdateModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const observationUpdateModal = document.getElementById('feedback-observation-update-container');
    const observationElements = document.getElementsByName('feedback-update-answers');
    const currentExtraObservations = currentUpdatingFeedback.extraObservations;
    tempUpdatingFeedback = {...currentUpdatingFeedback};

    for(let i = 0; i < observationElements.length; i++){
        if(currentExtraObservations.includes(observationElements[i].value)){
            observationElements[i].checked = true;
        } else {
            observationElements[i].checked = false;
        }

        observationElements[i].addEventListener('change', () => {
            checkExtraObservationValidity();
        })
    }

    backdrop.style.visibility = 'visible';
    observationUpdateModal.style.visibility = 'visible';
}

function hideObservationUpdateModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const observationUpdateModal = document.getElementById('feedback-observation-update-container');
    const observationElements = document.getElementsByName('feedback-update-answers');

    for(let i = 0; i < observationElements.length; i++){
        observationElements[i].removeEventListener('change', () =>{
            checkExtraObservationValidity();
        })
    }

    backdrop.style.visibility = 'hidden';
    observationUpdateModal.style.visibility = 'hidden';
}

function checkExtraObservationValidity(){
    const observationElements = document.getElementsByName('feedback-update-answers');
    let currentCheckedObservations = [];
    let observationsUpdated = false;
    const updateButton = document.getElementById('feedback-observation-update-button');

    for(let i = 0; i < observationElements.length; i++){
        if(observationElements[i].checked){
            currentCheckedObservations.push(observationElements[i].value);
        }
    }

    if(tempUpdatingFeedback.extraObservations.length !== currentCheckedObservations.length){
        observationsUpdated = true;
    } else {
        tempUpdatingFeedback.extraObservations.forEach(observation => {
            if(!currentCheckedObservations.includes(observation)){
                observationsUpdated = true;
            }
        })
    }

    if(observationsUpdated){
        currentUpdatingFeedback.extraObservations = currentCheckedObservations;
        updateButton.addEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        updateButton.disabled = false;
        updateButton.classList.add('primary-button');
        updateButton.classList.remove('disabled-button');
    } else {
        updateButton.removeEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        updateButton.disabled = true;
        updateButton.classList.add('disabled-button');
        updateButton.classList.remove('primary-button');
    }
}

function showCommentUpdateModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const commentUpdateModal = document.getElementById('feedback-comment-update-container');
    const commentTextArea = document.getElementById('feedback-comment-textarea');
    tempUpdatingFeedback = {...currentUpdatingFeedback};

    commentTextArea.value = currentUpdatingFeedback.writtenFeedback;
    commentTextArea.addEventListener('change', checkCommentTextValidity);

    backdrop.style.visibility = 'visible';
    commentUpdateModal.style.visibility = 'visible';
}

function hideCommentUpdateModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const commentUpdateModal = document.getElementById('feedback-comment-update-container');

    backdrop.style.visibility = 'hidden';
    commentUpdateModal.style.visibility = 'hidden';
}

function checkCommentTextValidity(){
    const commentTextArea = document.getElementById('feedback-comment-textarea');
    const updateButton = document.getElementById('feedback-comment-update-button');

    if(commentTextArea.value !== tempUpdatingFeedback.writtenFeedback){
        currentUpdatingFeedback.writtenFeedback = commentTextArea.value;

        updateButton.addEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        updateButton.classList.add('primary-button');
        updateButton.classList.remove('disabled-button');
        updateButton.disabled = false;
    } else {
        updateButton.removeEventListener('click', () => {
            updateFeedbackDetails(currentUpdatingFeedback);
        });

        updateButton.classList.add('disabled-button');
        updateButton.classList.remove('primary-button');
        updateButton.disabled = true;
    }
}

function updateFeedbackDetails(newFeedback){
    fetch(`http://localhost/labour_link/api/feedbacks.php`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(newFeedback)
    }).then(response => response.json())
        .then(data => {
           const backdropModal = document.getElementById("backdrop-modal");
           const successMessageContainer = document.getElementById('feedback-update-success');

           hideObservationUpdateModal();
            hideRatingUpdateModal();
            hideCommentUpdateModal();
           backdropModal.style.visibility = 'visible';
            successMessageContainer.style.visibility = 'visible';
          setTimeout(() => {
              backdropModal.style.visibility = 'hidden';
              successMessageContainer.style.visibility = 'hidden';
              location.reload();
          }, 5000);
        })
        .catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('feedback-update-fail');

            hideObservationUpdateModal();
            hideRatingUpdateModal();
            hideCommentUpdateModal();
            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
            location.reload();
        });
}