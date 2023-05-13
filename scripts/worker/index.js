let allWorkers = null;
let topWorkersCount = 0;
let topWorkersPageNumber = 1;
let nearbyWorkersPageNumber = 1;
let maxPageCount = null;
let currentTopWorkers = null;
let currentLocationWorkers = null;

let currentWorkerSection = 'top-workers';
let workerLocations = [];
let updatedLocations = [];

document.getElementById('top-worker-section').style.display = 'none';
document.getElementById('nearby-worker-section').style.display = 'none';

function switchWorkerSection(currentState){
    const workerSelectDropdown = document.getElementById('worker-select-dropdown-items');
    const workerSectionSelectButton = document.getElementById('worker-section-select-button');
    const initialWorkerSection = document.getElementById('initial-worker-section');
    const topWorkerSection = document.getElementById('top-worker-section');
    const nearbyWorkerSection = document.getElementById('nearby-worker-section');

    workerSelectDropdown.style.display = 'none';

    if(currentState === 'top-workers'){
        currentWorkerSection = 'top-workers';
        workerSectionSelectButton.innerHTML = 'Top workers&nbsp;&nbsp;<i class="fa-solid fa-arrow-down"></i>';

        initialWorkerSection.style.display = 'none';
        topWorkerSection.style.display = 'block';
        nearbyWorkerSection.style.display = 'none';
    } else {
        currentWorkerSection = 'nearby-workers';
        workerSectionSelectButton.innerHTML = 'Nearby workers&nbsp;&nbsp;<i class="fa-solid fa-arrow-down"></i>';

        initialWorkerSection.style.display = 'none';
        topWorkerSection.style.display = 'none';
        nearbyWorkerSection.style.display = 'block';
    }
}

function openLoginModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const loginModal = document.getElementById('login-container');

    backdrop.style.visibility = 'visible';
    loginModal.style.visibility = 'visible';
}

function closeLoginModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const loginModal = document.getElementById('login-container');

    backdrop.style.visibility = 'hidden';
    loginModal.style.visibility = 'hidden';
}

function initialLoad(workerType){
    const workerSectionSelectButton = document.getElementById('worker-section-select-button');
    workerSectionSelectButton.style.backgroundColor = 'var(--grey-color-shade)';
    workerSectionSelectButton.style.color = 'var(--grey-color)';

     fetch(`http://localhost/labour_link/api/workers.php?workerType=${workerType}`, {
         method: 'GET',
         headers: { 'Content-Type': 'application/json' }
     })
         .then(response => response.json())
         .then(async (data) => {
             allWorkers = data;

             let allWorksWithLocation = allWorkers.map(worker => {
                 return { "userId": worker.userId, "city": worker.city };
             });

             if (navigator.geolocation) {
                 navigator.geolocation.getCurrentPosition(function (position) {
                     const lat = position.coords.latitude;
                     const lng = position.coords.longitude;

                     const body = {
                         "latitude": lat,
                         "longitude": lng,
                         "data": allWorksWithLocation
                     }

                     fetch(`http://localhost/labour_link/api/locationservice.php`, {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json' },
                         body: JSON.stringify(body)
                     })
                         .then(response => response.json())
                         .then(data => {
                             allWorkers.sort((first, second) => {
                                 if(first.userId < second.userId) return -1;
                                 else return 1;
                             });
                             data.sort((first, second) => {
                                 if(first.userId < second.userId) return -1;
                                 else return 1;
                             });

                             for(let i = 0; i < allWorkers.length; i++){
                                 allWorkers[i] = {"distance": data[i].distance,...allWorkers[i]}
                             }

                             const pageCount = Math.ceil(allWorkers.length / 4);
                             maxPageCount = pageCount;

                             initialWorkerLoad(allWorkers);

                             const workerSectionSelectButton = document.getElementById('worker-section-select-button');
                             workerSectionSelectButton.addEventListener('click', () => {
                                 const workerSelectDropdown = document.getElementById('worker-select-dropdown-items');

                                 if(workerSelectDropdown.style.display === 'block'){
                                     workerSelectDropdown.style.display = 'none';
                                 } else {
                                     workerSelectDropdown.style.display = 'block';
                                 }
                             });

                             document.getElementById('worker-select-dropdown-top-workers').addEventListener('click', () => { switchWorkerSection('top-workers') });
                             document.getElementById('worker-select-dropdown-nearby-workers').addEventListener('click', () => { switchWorkerSection('nearby-workers') });

                             workerSectionSelectButton.style.backgroundColor = 'var(--primary-color)';
                             workerSectionSelectButton.style.color = 'white';
                             switchWorkerSection('top-workers');
                         })
                 });
             }
         })
         .catch(error => console.log(error));
}

function setDefaultImage(workerId){
    const image = document.getElementById(`worker-profile-image-${workerId}`);
    image.src = `../../labour_link/assets/worker/profile-images/worker-${workerId % 4 + 1}.jpg`;
}

function createCard(worker){
    const currentRating = parseFloat(worker.currentRating);
    const workerCategories = worker.workerCategories;
    const workerID = worker.userId;
    let tempRating = 0;
    let ratingHtml = '';
    let bookingButtonHtml = '';

    const profileId = Math.ceil(Math.random() * 10) % 4 + 1;

    while(tempRating < currentRating){
        if(tempRating + 1 <= currentRating){
            ratingHtml += "<i class='fa-solid fa-star'></i>";
            tempRating += 1;
        } else if (tempRating + 0.5 <= currentRating){
            ratingHtml += "<i class='fa-solid fa-star-half-stroke'></i>";
            tempRating += 0.5;
        } else {
            break;
        }
    }

    tempRating = Math.ceil(tempRating);

    while(tempRating < 5){
        ratingHtml += "<i class='fa-regular fa-star'></i>";
        tempRating += 1;
    }

    const workerCategoryArray = workerCategories.map(workerCategory => `
                <div class="worker-type-badge">
                        <h5>${workerCategory}</h5>
                  </div>
    `);

    let workerCategoryText = '';
    workerCategoryArray.forEach(element => {
        workerCategoryText += element;
    });

    if(logged === false){
        bookingButtonHtml = '<button type="button" class="booking-button" onclick="openLoginModal()"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Book now!</button>';
    } else {
        bookingButtonHtml = `<button type="button" class="booking-button" onclick="openBookingModal(${workerID})"><i class="fa-solid fa-check"></i>&nbsp;&nbsp;Book now!</button>`;
    }

    let html = `
        <div class="worker-card">
                <h1 class="worker-card-title">${worker.fullName}</h1>
                <div class="worker-card-star-container">
                    ${ratingHtml}
                    &nbsp;&nbsp; ${currentRating}
                </div>
                <div class="worker-image">
                    <img id="worker-profile-image-${workerID}" src="../assets/profile-image/${workerID}.jpg" onerror="setDefaultImage(${workerID})" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;${worker.city}</h3>
                </div>
                <div class="worker-card-types-row">
                    ${workerCategoryText}
                </div>
                <div class="worker-card-button-container">
                    <a href='../worker/view-worker-profile.php?workerId=${worker.userId}'<button type="button" class="view-profile-button">Profile</button></a>
                    ${bookingButtonHtml}
                </div>
            </div>
    `;

    return html;
}

function initialWorkerLoad(allWorkers){
    const topWorkersContainer = document.getElementById('top-worker-card-container');
    const nearbyWorkerContainer = document.getElementById('worker-nearby-card-container');
    const topWorkersButtonContainer = document.getElementById('top-worker-button-container');
    const nearbyWorkersButtonContainer = document.getElementById('nearby-worker-button-container');

    let topWorkersHtml = '';
    let nearbyWorkersHtml = '';
    // First sort by rating
    allWorkers.sort((first, second) => {
        if(first.currentRating > second.currentRating){
            return -1;
        } else {
            return 1;
        }
    });

    if(maxPageCount === 0){
        topWorkersHtml = `
            <div class="empty-worker-card-image-container">
                <img src="../../labour_link/assets/worker/undraw_Search_engines_ij7q.svg" alt="empty-workers" />
                <h1>Sorry, at the moment there are no workers for the given category! Please try again later</h1>
            </div>
        `;
        topWorkersContainer.innerHTML = topWorkersHtml;

        const topWorkersTitle = document.getElementById('top-worker-section-title');
        const buttonContainer = document.getElementById('top-workers-button-loading-container');
        const nearbyWorkerSection = document.getElementById('worker-section');

        topWorkersTitle.style.display = 'none';
        buttonContainer.style.display = 'none';
        nearbyWorkerSection.style.display = 'none';


        return;
    }
    const upperBound = (allWorkers.length < 4)? allWorkers.length: 4;
    for(let i = 0; i < upperBound; i++){
        const worker = allWorkers[i];
        topWorkersHtml += createCard(worker);
    }

    topWorkersContainer.innerHTML = topWorkersHtml;
    topWorkersPageNumber = 1;
    if(topWorkersPageNumber === maxPageCount){
        topWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="disabled-button" id="top-workers-button" onclick="loadTopWorkersRow()" disabled>Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    } else {
        topWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="booking-button" id="top-workers-button" onclick="loadTopWorkersRow()">Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    }

    // Second srt by distance
    allWorkers.sort((first, second) => {
        if(first.distance < second.distance){
            return -1;
        } else {
            return 1;
        }
    });

    for(let i = 0; i < upperBound; i++){
        const worker = allWorkers[i];
        nearbyWorkersHtml += createCard(worker);
    }

    nearbyWorkerContainer.innerHTML = nearbyWorkersHtml;
    nearbyWorkersPageNumber = 1;

    if(nearbyWorkersPageNumber === maxPageCount){
        nearbyWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="disabled-button" id="nearby-workers-button" onclick="loadNearbyWorkersRow()" disabled>Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    } else {
        nearbyWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="booking-button" id="nearby-workers-button" onclick="loadNearbyWorkersRow()">Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    }
}

function loadTopWorkersRow(){
    const topWorkersContainer = document.getElementById('top-worker-card-container');
    const topWorkersButtonContainer = document.getElementById('top-worker-button-container');
    const topUpperBound = (allWorkers.length < (topWorkersPageNumber + 1) * 4)? allWorkers.length: (topWorkersPageNumber + 1) * 4;
    let topWorkersHtml = '';

    allWorkers.sort((first, second) => {
        if(first.currentRating > second.currentRating){
            return -1;
        } else {
            return 1;
        }
    });

    for(let i = 0; i < topUpperBound; i++){
        const worker = allWorkers[i];
        topWorkersHtml += createCard(worker);
    }

    topWorkersContainer.innerHTML = topWorkersHtml;
    topWorkersPageNumber += 1;
    if(topWorkersPageNumber === maxPageCount){
        topWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="disabled-button" id="top-workers-button" onclick="loadTopWorkersRow()" disabled>Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    } else {
        topWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="booking-button" id="top-workers-button" onclick="loadTopWorkersRow()">Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    }
}

function loadNearbyWorkersRow(){
    const nearbyWorkerContainer = document.getElementById('worker-nearby-card-container');
    const nearbyWorkersButtonContainer = document.getElementById('nearby-worker-button-container');
    const nearbyUpperBound = (allWorkers.length < (nearbyWorkersPageNumber + 1) * 4)? allWorkers.length: (nearbyWorkersPageNumber + 1) * 4;
    let nearbyWorkersHtml = '';

    allWorkers.sort((first, second) => {
        if(first.distance < second.distance){
            return -1;
        } else {
            return 1;
        }
    });

    for(let i = 0; i < nearbyUpperBound; i++){
        const worker = allWorkers[i];
        nearbyWorkersHtml += createCard(worker);
    }

    nearbyWorkerContainer.innerHTML = nearbyWorkersHtml;
    nearbyWorkersPageNumber += 1;

    if(nearbyWorkersPageNumber === maxPageCount){
        nearbyWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="disabled-button" id="nearby-workers-button" onclick="loadNearbyWorkersRow()" disabled>Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    } else {
        nearbyWorkersButtonContainer.innerHTML = `
            <div class="button-container">
                <button type="button" class="booking-button" id="nearby-workers-button" onclick="loadNearbyWorkersRow()">Load more&nbsp;
                    <i class="fa-solid fa-spinner"></i>
                </button>
            </div>`;
    }
}

/*
 * Booking create process
 */

function openBookingModal(workerID){
    const backdrop = document.getElementById('backdrop-modal');
    const bookingModal = document.getElementById('create-booking-container');
    const workernameInput = document.getElementById('worker-id');
    const worker = allWorkers.find(worker => worker.userId == Number(workerID));

    workernameInput.innerHTML = `<option value="${workerID}">${worker.fullName}</option>`


    backdrop.style.visibility = 'visible';
    bookingModal.style.visibility = 'visible';
}

function closeBookingModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const bookingModal = document.getElementById('create-booking-container');

    backdrop.style.visibility = 'hidden';
    bookingModal.style.visibility = 'hidden';
}
