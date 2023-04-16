let allWorkers = null;
let topWorkersCount = 0;
let currentTopWorkers = null;
let currentLocationWorkers = null;

const topWorkersButton = document.getElementById('top-workers-button');
topWorkersButton.addEventListener('click', () => {
    if(allWorkers === null){
        loadWorkers(workerType);
    }

    updateTopWorkers(allWorkers);
    reRenderCards(allWorkers);
});

function loadWorkers(workerType){
    fetch(`http://localhost/labour_link/api/workers.php?workerType=${workerType}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            allWorkers = data;
            console.log(allWorkers);
        })
        .catch(error => console.log(error));
}

function reRenderCards(workersList){
    const cardContainer = document.getElementById('top-worker-card-container');
    cardContainer.innerHTML = '';

    let htmlContent = '';

    console.log(workersList);

    workersList.forEach(worker => {
        const currentRating = parseFloat(worker.currentRating);
        let tempRating = 0;
        let ratingHtml = '';

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

        htmlContent = `
            <div class="worker-card">
                <h1 class="worker-card-title">${worker.fullName}</h1>
                <div class="worker-card-star-container">
                    ${ratingHtml}
                    &nbsp;&nbsp; ${currentRating}
                </div>
                <div class="worker-image">
                    <img src="../assets/worker/profile-images/worker-${profileId}.jpg" alt="worker-profile">
                </div>
                <div class="worker-card-location-row">
                    <h3><i class="fa-solid fa-location-dot" style="color: var(--primary-color)"></i>&nbsp;&nbsp;${worker.city}</h3>
                </div>
                <div class="worker-card-types-row">
                    <div class="worker-type-badge">
                        <h5>Electrician</h5>
                    </div>
                    <div class="worker-type-badge">
                        <h5>Plumber</h5>
                    </div>
                </div>
                <div class="worker-card-button-container">
                    <a href='../worker/profile?workerId=${worker.userId}'<button type="button" class="view-profile-button">Profile</button></a>
                    <button type="button" class="booking-button">Book now!</button>
                </div>
            </div>`;

        cardContainer.innerHTML += htmlContent;
    });
}

function updateTopWorkers(allWorkers){
    // Sort workers by descending rating
    const sortedWorkers = workers.sort((a, b) => parseFloat(b.currentRating) - parseFloat(a.currentRating));

    // Get the top N workers based on topWorkersCount
    const topWorkers = sortedWorkers.slice(0, topWorkersCount);

    // Update the currentTopWorkers variable
    currentTopWorkers = topWorkers;
}

let workerPage = 1; // Keep track of the current worker page number

function loadMoreWorkers(workerType, perPage) {
    workerPage++; // Increment the page number

    // Fetch the next page of workers
    fetch(`http://localhost/labour_link/api/workers.php?workerType=${workerType}&page=${workerPage}&perPage=${perPage}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            // Append the new workers to the allWorkers array
            allWorkers = allWorkers.concat(data);

            // Re-render the worker cards with the updated list of workers
            reRenderCards(allWorkers);
        })
        .catch(error => console.log(error));
}

let workerLocations = [];
const locationTexts = Array.from(document.getElementsByClassName('location-text'));
let updatedLocations = [];


function initialLoad(workerType){
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
                         })
                 });
             }

         })
         .catch(error => console.log(error));
}

