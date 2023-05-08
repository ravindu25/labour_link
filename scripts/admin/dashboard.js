/*
 * Javascript for bookings section
 */
function showBookingDetails(bookingId) {
    fetch(`http://localhost/labour_link/api/bookings.php?bookingId=${bookingId}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            openBookingDetailsModal(data);
        })
        .catch(error => {
            const backdrop = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

function openBookingDetailsModal(currentBooking){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

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
    const workerLink = `<a href="http://localhost/labour_link/worker/view-worker-profile.php?workerId=${currentBooking.workerId}">${currentBooking.workerName}</a>`;

    document.getElementById('booking-details-customer-name').innerText = currentBooking.customerName;
    document.getElementById('booking-details-job-type').innerHTML = currentBooking.workerType;
    document.getElementById('booking-details-worker-name').innerHTML = workerLink;
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

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

/*
 * Javascript for feedback section
 */

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
            document.getElementById('feedback-details-booking-date').innerHTML = `Feedback created date ${data.createdTimestamp.split(' ')[0]} by <u>${data.customerName}</u>`;
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