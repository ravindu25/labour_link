let allFeedbackCount = null;
let feedbackSkippingRate = null;

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