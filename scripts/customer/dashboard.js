const backButton = document.getElementById("back-button");

let allBookings = [];

function openBookingDetailsModal(bookingId){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    const currentBooking = allBookings.find(booking => booking.bookingId == bookingId);

    let bookingStatusButton = null;
    if(currentBooking.status === 'Pending'){
        bookingStatusButton = '<button class="pending-button">Pending</button>';
    } else if(currentBooking.status === 'Accepted-by-customer'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted by customer</button>';
    } else if(currentBooking.status === 'Accepted-by-worker'){
        bookingStatusButton = '<button class="in-pogress-button">Accepted by worker</button>';
    } else if(currentBooking.status === 'Completed'){
        bookingStatusButton = '<button class="completed-button">Completed</button>';
    } else if(currentBooking.status === 'Rejected-by-customer') {
        bookingStatusButton = '<button class="rejected-button">Rejected by customer</button>';
    } else if(currentBooking.status === 'Rejected-by-worker') {
        bookingStatusButton = '<button class="rejected-button">Rejected by worker</button>';
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

    if(currentBooking.status === 'Pending' || currentBooking.status === 'Accepted-by-worker' || currentBooking.status === 'Accepted-by-customer') {
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
            <h3>Waiting for worker to decided payment amount</h3>
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Not decided yet!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;

    } else if(currentBooking.status === 'Accepted-by-worker'){
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
            <button type="button" class="primary-button" id="reject-button"><i class="fa-solid fa-xmark"></i>&nbsp;&nbsp;Reject booking</button>
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
            <button type="button" class="primary-button" id="accept-button"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Accept booking</button>
        `;

        const acceptButton = document.getElementById('accept-button');
        acceptButton.addEventListener('click', acceptCurrentViewingBooking);

        const rejectButton = document.getElementById('reject-button');
        rejectButton.addEventListener('click', rejectCurrentViewingBooking);
    } else if(currentBooking.status === 'Rejected-by-worker') {
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by worker!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    } else if(currentBooking.status === 'Rejected-by-customer') {
        const buttonContainer = document.getElementById('back-button-container');
        const paymentContainer = document.getElementById('payment-details-container');

        paymentContainer.innerHTML = `
            <h2 id="payment-details-amount-text" style="font-size: 24px; color: var(--warning-color)">Booking has been canceled by customer!</h2>
        `;

        buttonContainer.innerHTML = `
            <button type="button" class="primary-outline-button" style="margin: 0 8px;" id="back-button">Close</button>
        `;
    }else if(currentBooking.status === 'Accepted-by-customer') {
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
            <button type="button" class="primary-button" id="complete-button"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Mark as complete</button>
        `;

        const acceptButton = document.getElementById('complete-button');
        acceptButton.addEventListener('click', completeCurrentViewingBooking);
    } else if(currentBooking.status === 'Completed') {
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

function closeBookingDetailsModal(){
    const backdropModal = document.getElementById("backdrop-modal");
    const bookingDetails = document.getElementById("booking-details-container");

    backdropModal.style.visibility = 'hidden';
    bookingDetails.style.visibility = 'hidden';
}

backButton.addEventListener('click', () => { closeBookingDetailsModal() });

function getBookings(dataSource){
    fetch(dataSource, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            allBookings = data;
        })
        .catch(error => console.log(error));
}

getBookings(`http://localhost/labour_link/api/bookings.php?customerId=${userId}&num=5`);

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

                fetch(`http://localhost/labour_link/api/bookings.php?bookingId=${data.bookingId}`, {
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