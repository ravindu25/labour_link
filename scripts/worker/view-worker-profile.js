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
