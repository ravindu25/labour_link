let allWorkers = null;
let topWorkersCount = 0;
let currentTopWorkers = null;

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

}