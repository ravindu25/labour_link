const bookingCreateCancelButton = document.getElementById("booking-create-cancel-button");

bookingCreateCancelButton.addEventListener('click', () => {
    closeCreateBookingModal();
});


function displayFeedbacks(){
    fetch(`http://localhost/labour_link/api/worker-profile.php?action=getAllFeedbacks&workerId=${workerID}`,{
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
        .then(response => response.json())
        .then(data => {
            const backdrop = document.getElementById('backdrop-modal');
            const addFeedbackModal = document.getElementById('add-feedback-modal');
            const displayFeedback = document.getElementById('feedback-list-container');

            displayFeedback.innerHTML = '';

            data.forEach(element => {
                displayFeedback.innerHTML += `
                    <label class="feedback-select-label" for='feedback-${element.token}'>
                        <input type='checkbox' name='feedback-select' value='${element.token}' class='feedback-select' id='feedback-${element.token}' />
                        <div class="written-feedback-card">
                            <h3>${element.writtenFeedback}</h3>
                        </div>
                    </label>
                `;
            });

            const checkboxes = document.getElementsByName('feedback-select');
            for(let i = 0; i < checkboxes.length; i++){
                checkboxes[i].addEventListener('change', checkValidity);
            }

            backdrop.style.visibility = 'visible';
            addFeedbackModal.style.visibility = 'visible';
        })
        .catch(error => console.log(error));
}

function hideUpdateFeedbackContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const addFeedbackModal = document.getElementById('add-feedback-modal');

    backdrop.style.visibility = 'hidden';
    addFeedbackModal.style.visibility = 'hidden';
}

function checkValidity(){
    const feedbackSelectCard = document.getElementsByName('feedback-select');
    const addFeedbackButton = document.getElementById('feedback-add-button');
    let selectedFeedbackArray = [];

    for(let i = 0; i < feedbackSelectCard.length; i++) {
        if (feedbackSelectCard[i].checked) {
            selectedFeedbackArray.push(feedbackSelectCard[i].value);
        }
    }

    if (selectedFeedbackArray.length <= 3){
        addFeedbackButton.addEventListener('click', saveFeedbackItem);

        addFeedbackButton.classList.add('primary-button');
        addFeedbackButton.classList.remove('disable-button');
    } else {
        addFeedbackButton.removeEventListener('click', saveFeedbackItem);

        addFeedbackButton.classList.add('disable-button');
        addFeedbackButton.classList.remove('primary-button');
    }
}

function saveFeedbackItem(){
    const feedbackSelectCard = document.getElementsByName('feedback-select');
    let selectedFeedbackArray = [];

    for(let i = 0; i < feedbackSelectCard.length; i++) {
        if (feedbackSelectCard[i].checked) {
            selectedFeedbackArray.push(feedbackSelectCard[i].value);
        }
    }

    const body = {
        workerId: workerID,
        feedbackTokens: selectedFeedbackArray
    };
    console.log(body);

    fetch ('http://localhost/labour_link/api/worker-profile.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(body)
    }).then(response => response.json())
        .then(data => {
            const backdropModal = document.getElementById('backdrop-modal');
            const successMessageContainer = document.getElementById('feedback-add-success');
            hideUpdateFeedbackContainer();

            backdropModal.style.visibility = 'visible';
            successMessageContainer.style.visibility = 'visible';
            setTimeout(() => {
                backdropModal.style.visibility = 'hidden';
                successMessageContainer.style.visibility = 'hidden';
                location.reload();
            }, 5000);
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            hideUpdateFeedbackContainer();
            console.log(error);

            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

function showUpdateDescriptionContainer(){
    const backdropModal = document.getElementById('backdrop-modal');
    const updateDescriptionContainer = document.getElementById('update-description-container');
    const descriptionTextArea = document.getElementById('update-description-textarea');

    descriptionTextArea.value = document.getElementById('worker-description-text').innerText;
    descriptionTextArea.addEventListener('change', checkDescriptionValidity);

    backdropModal.style.visibility = 'visible';
    updateDescriptionContainer.style.visibility = 'visible';
}

function hideUpdateDescriptionContainer(){
    const backdropModal = document.getElementById('backdrop-modal');
    const updateDescriptionContainer = document.getElementById('update-description-container');
    const descriptionTextArea = document.getElementById('update-description-textarea');

    descriptionTextArea.removeEventListener('change', checkDescriptionValidity);

    backdropModal.style.visibility = 'hidden';
    updateDescriptionContainer.style.visibility = 'hidden';
}

function checkDescriptionValidity(){
    const typingDescription = document.getElementById('update-description-textarea').value;
    const currentDescription = document.getElementById('worker-description-text').innerText;
    const saveButton = document.getElementById('save-description-button');

    if(typingDescription !== currentDescription){
        saveButton.addEventListener('click', saveDescription);
        saveButton.classList.add('primary-button');
        saveButton.classList.remove('disable-button');
        saveButton.disabled = false;
    } else {
        saveButton.removeEventListener('click', saveDescription);
        saveButton.classList.add('disable-button');
        saveButton.classList.remove('primary-button');
        saveButton.disabled = true;
    }
}

function saveDescription(){
    const typingDescription = document.getElementById('update-description-textarea').value;

    fetch(`http://localhost/labour_link/api/worker-profile.php`,{
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            workerId: workerID,
            description: typingDescription
        })
    })
        .then(response => response.json())
        .then(data => {
            const backdropModal = document.getElementById('backdrop-modal');
            const successMessageContainer = document.getElementById('description-update-success');

            hideUpdateDescriptionContainer();

            backdropModal.style.visibility = 'visible';
            successMessageContainer.style.visibility = 'visible';
            setTimeout(() => {
                backdropModal.style.visibility = 'hidden';
                successMessageContainer.style.visibility = 'hidden';
                location.reload();
            })
        })
        .catch(error => {
            const backdropModal = document.getElementById('backdrop-modal');
            const errorMessageContainer = document.getElementById('error-message-container');

            hideUpdateDescriptionContainer();
            console.log(error);

            backdropModal.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

/*
 * Booking create modal
 */

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