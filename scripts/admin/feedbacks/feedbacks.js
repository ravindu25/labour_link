let allFeedbackCount = null;

function initialLoad(){
    fetch(`http://localhost/labour_link/api/charts/feedbacks.php?term=getFeedbackCount`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    }).then(response => response.json())
        .then(data => {
            allFeedbackCount = data;
            showFeedbackCount(allFeedbackCount);
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

initialLoad();