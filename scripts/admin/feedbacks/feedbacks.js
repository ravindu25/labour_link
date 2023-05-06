let allFeedbackCount = null;
let feedbackSkippingRate = null;
let feedbackPageNumber = 0;
let allFeedbacks = null;
let allTempFeedbacks = null;
let sortingDetails = { 'writtenFeedback': null, 'workerName': null, 'customerName': null,'createdTimestamp': null };
const feedbackSearchButton = document.getElementById('feedback-search-input-button');

function initialLoad(){
    const currentYear = new Date().getFullYear();
    const currentMonth = new Date().getMonth() + 1;
    // const currentMonth = 4;

    fetch(`http://localhost/labour_link/api/charts/feedbacks.php?term=getFeedbackCount&year=${currentYear}&month=${currentMonth}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
        .then(data => {
            allFeedbackCount = data;
            showFeedbackCount(allFeedbackCount, currentYear, currentMonth);

            fetch(`http://localhost/labour_link/api/charts/feedbacks.php?term=getSkippingFeedback`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            }).then(response => response.json())
                .then(data => {
                    feedbackSkippingRate = data;
                    showFeedbackSkippingRate(feedbackSkippingRate);
                })
                .catch(error => {
                    const backdropModal = document.getElementById('backdrop-modal');
                    const errorMessageContainer = document.getElementById('error-message-container');

                    backdropModal.style.visibility = 'visible';
                    errorMessageContainer.style.visibility = 'visible';
                })
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

initialLoad();

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
            } else if (feedback.customerName.toLowerCase().includes(searchTerm)) {
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

function getAllFeedbacks(){
    fetch(`http://localhost/labour_link/api/feedbacks.php`, {
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
                        <h3>There is no feedback at the moment!</h3>
                    </div>
                `

                recentFeedbacksContainar.style.display = 'block';
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
            <td class="main-td">${feedback.customerName}</td>
            <td class="main-td">${feedback.createdTimestamp.split(' ')[0]}</td>
            <td class="main-td">
                <div class="more-button-container">
                    <button class="update-button" onclick="showFeedbackDetails(${feedback.feedbackToken})"><i class="fa-solid fa-arrow-up-right-from-square"></i>&nbsp;&nbsp;View
                    </button>
                   
                </div>
            </td>
        </tr>
    `;

    return feedbackRow;
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

getAllFeedbacks();

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

            //If the feedback was set earlier than 14 days, dont allow the user to edit the feedback
            const feedbackDate = new Date(data.createdTimestamp.split(' ')[0]);
            const currentDate = new Date();
            const timeDifference = currentDate.getTime() - feedbackDate.getTime();
            const daysDifference = timeDifference / (1000 * 3600 * 24);
            if(daysDifference > 14){

                document.getElementById('feedback-details-rating-header').innerHTML="<h1>Worker rating</h1>";
            }else{
                document.getElementById('feedback-details-rating-header').innerHTML="  <h1>Worker rating</h1>";
            }

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

                feedbackCommentHeader.innerHTML = '<h1 id="feedback-details-comment-heading" style="color: var(--danger-color); text-align: center">No written feedbacks</h1>';
                feedbackCommentHeader.style.justifyContent = 'center';


                document.getElementById('feedback-details-comment-text').innerText = '';
            } else {
                document.getElementById('feedback-details-comment-container').style.display = 'block';
                const feedbackCommentHeader = document.getElementById('feedback-details-comment-header');

                feedbackCommentHeader.innerHTML = '<h1 id="feedback-details-comment-heading" style="color: var(--primary-color); text-align: left">Written feedback</h1>';
                feedbackCommentHeader.style.justifyContent = 'start';


                document.getElementById('feedback-details-comment-text').innerText = data.writtenFeedback;
            }

            let extraObservations = '';

            if(data.extraObservations.length === 0 || (data.extraObservations.length === 1 && data.extraObservations[0] === '')){
                const extraObservationHeading = document.getElementById('feedback-details-observations-header');
                const extraObservationContainer = document.getElementById('feedback-details-extra-observations');

                extraObservationHeading.innerText = 'No extra observations';
                extraObservationHeading.style.color = 'var(--danger-color)';
                extraObservationContainer.innerText = '';
            } else {
                const extraObservationHeading = document.getElementById('feedback-details-observations-header');

                extraObservationHeading.innerText = 'Extra observations';
                extraObservationHeading.style.color = 'var(--primary-color)';

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

function hideFeedbackDetails(feedback){
    const backdrop = document.getElementById('backdrop-modal');
    const feedbackDetailsContainer = document.getElementById('feedback-details-container');


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