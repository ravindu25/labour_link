let autocomplete;
let address = '';
let jobSelections = [];
const locationInput = document.getElementById('place-autocomplete');
const nextButton = document.getElementById('first-page-next-button');
const housingCreateSecondPage = document.getElementById('housing-create-second-page');

housingCreateSecondPage.style.display = 'none';
nextButton.classList.remove('primary-button');
nextButton.classList.add('disabled-button');
nextButton.disabled = true;

locationInput.addEventListener('change', () => {
    const locationText = document.getElementById('place-autocomplete').value;
    const nextButton = document.getElementById('first-page-next-button');

    if(locationText !== ''){
        nextButton.classList.add('primary-button');
        nextButton.classList.remove('disabled-button');
        nextButton.disabled = false;
    } else {
        nextButton.classList.remove('primary-button');
        nextButton.classList.add('disabled-button');
        nextButton.disabled = true;
    }
});

function addClickEventsToJobCards(){
    let jobElements = document.getElementsByName('job-selection');

    for(let i = 0; i < jobElements.length; i++){
        const cardValue = jobElements[i].value;
        const jobCard = document.getElementById(`job-selection-card-${cardValue}`);

        jobCard.addEventListener('change', function(){
            const jobCardIndicator = document.getElementById(`job-selection-complete-indicator-${cardValue}`);
            if(this.checked){
                jobCardIndicator.style.color = 'var(--success-color)';
                jobCardIndicator.innerHTML ="<i class='fa-solid fa-check'></i>&nbsp;&nbsp;<h5>Added to project</h5>";
            } else {
                jobCardIndicator.style.color = 'var(--primary-color)';
                jobCardIndicator.innerHTML ="";
            }
        })
    }
}

addClickEventsToJobCards();

function onPlaceChanged(){
    let place = autocomplete.getPlace();

    address = place.name;
}

function initAutocomplete(){
    autocomplete = new google.maps.places.Autocomplete(
        document.getElementById('place-autocomplete'),
        {
            types: ['address'],
            componentRestrictions: {'country': ['LK']},
            fields: ['place_id', 'geometry', 'name']
        });

    autocomplete.addListener('place_changed', () => { onPlaceChanged() });
}

function openHousingCreateModal(){
    const housingCreateContainer = document.getElementById('housing-create-container');
    const backDrop = document.getElementById('backdrop-modal');

    housingCreateContainer.style.visibility = 'visible';
    backDrop.style.visibility = 'visible';
}

function closeHousingCreateModal(){
    const housingCreateContainer = document.getElementById('housing-create-container');
    const backDrop = document.getElementById('backdrop-modal');

    housingCreateContainer.style.visibility = 'hidden';
    backDrop.style.visibility = 'hidden';
}

function goToFirstHousingPage(){
    const firstPage = document.getElementById('housing-create-first-page');
    const secondPage = document.getElementById('housing-create-second-page');

    firstPage.style.display = 'block';
    secondPage.style.display = 'none';
}

function goToSecondHousingPage(){
    const firstPage = document.getElementById('housing-create-first-page');
    const secondPage = document.getElementById('housing-create-second-page');

    firstPage.style.display = 'none';
    secondPage.style.display = 'block';
}

function submitHousing(){
    let jobElements = document.getElementsByName('job-selection');

    for(let i = 0; i < jobElements.length; i++){
        if(jobElements[i].checked){
            jobSelections.push(parseInt(jobElements[i].value));
        }
    }

    fetch(`http://localhost/labour_link/api/housing.php`,{
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                "customerid": userId,
                "address": address,
                "verified": "false",
                "jobselection": jobSelections
            })
        }
    )
        .then(() => {
            const housingCreateContainer = document.getElementById('housing-create-container');
            const successContainer = document.getElementById('housing-create-success');

            housingCreateContainer.style.visibility = 'hidden';
            successContainer.style.visibility = 'visible';
        })
        .catch((error) => {
            const housingCreateContainer = document.getElementById('housing-create-container');
            const failedContainer = document.getElementById('housing-create-fail');
            const errorText = document.getElementById('housing-create-fail-text');

            housingCreateContainer.style.visibility = 'hidden';
            failedContainer.style.visibility = 'visible';
            errorText.innerText = error;
        });




    setTimeout(() => {
        const backDrop = document.getElementById('backdrop-modal');
        const successContainer = document.getElementById('housing-create-success');
        const failedContainer = document.getElementById('housing-create-fail');

        successContainer.style.visibility = 'hidden';
        failedContainer.style.visibility = 'hidden';
        backDrop.style.visibility = 'hidden';
    }, 5000);
}

function showJobs(houseID){
    const jobsContainer = document.getElementById(`project-items-jobs-container-${houseID}`);
    const loadMoreButton = document.getElementById(`jobs-load-more-button-${houseID}`);

    console.log(loadMoreButton.innerHTML);

    if(jobsContainer.style.display == 'none' || jobsContainer.style.display == ''){
        jobsContainer.style.display = 'block';
        loadMoreButton.innerHTML = "<i class='fa-solid fa-arrow-up'></i>&nbsp;&nbsp;Show less";
    } else {
        jobsContainer.style.display = 'none';
        loadMoreButton.innerHTML = "<i class='fa-solid fa-arrow-down'></i>&nbsp;&nbsp;Load jobs";
    }
}
