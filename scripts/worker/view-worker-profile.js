const container = document.querySelector('.details-row');
const projects = container.querySelectorAll('.project-container');
const projectWidth = projects[0].offsetWidth;
const numProjects = projects.length;

let currentIndex = 0;

// Function to handle clicking the left arrow
function handleLeftArrowClick() {
    if (currentIndex > 0) {
        projects[currentIndex + 2].classList.remove('hidden');
        projects[currentIndex].classList.add('hidden');
        currentIndex -= 1;
    }
}

// Function to handle clicking the right arrow
function handleRightArrowClick() {
    if (currentIndex < numProjects - 3) {
        projects[currentIndex].classList.add('hidden');
        projects[currentIndex + 3].classList.remove('hidden');
        currentIndex += 1;
    }
}

// Add event listeners to the arrow buttons
const leftArrow = document.querySelector('.left-arrow');
const rightArrow = document.querySelector('.right-arrow');
leftArrow.addEventListener('click', handleLeftArrowClick);
rightArrow.addEventListener('click', handleRightArrowClick);

function displayFeedbacks(){
    fetch(`http://localhost/labour_link/api/worker-profile.php?workerId=${workerID}`,{
        method: 'GET',
        headers: {'Content-Type': 'application/json'}
    })
        .then(response => response.json())
        .then(data => {
            const backdrop = document.getElementById('backdrop-modal');
            const addFeedbackModal = document.getElementById('add-feedback-modal');
            const displayFeedback = document.getElementById('feedback-list-container');

            data.forEach(element => {
                displayFeedback.innerHTML += `
                    <div id='feedback-${element.token}'>
                        ${element.writtenFeedback}
                    </div>
                `;
            })

            backdrop.style.visibility = 'visible';
            addFeedbackModal.style.visibility = 'visible';
        })
        .catch(error => console.log(error));
}
