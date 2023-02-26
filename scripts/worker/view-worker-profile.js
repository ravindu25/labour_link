const projectContainers = document.querySelectorAll('.project-container');
const leftButton = document.querySelector('.left-button');
const rightButton = document.querySelector('.right-button');
const containerWidth = projectContainers[0].offsetWidth + 20; // 20 is the margin-right for project-container
const containerMax = projectContainers.length - 1;
let containerIndex = 0;

function moveContainer(direction) {
    // hide the leftmost project-container if moving right
    if (direction === 'right' && containerIndex > 0) {
        projectContainers[containerIndex - 1].style.display = 'none';
    }
    // unhide the leftmost project-container if moving left
    if (direction === 'left' && containerIndex >= 3) {
        projectContainers[containerIndex - 3].style.display = 'flex';
    }
    // move the project-containers in the desired direction
    if (direction === 'left' && containerIndex > 0) {
        containerIndex--;
        document.querySelector('.details-row').style.transform = `translateX(-${containerIndex * containerWidth}px)`;
    } else if (direction === 'right' && containerIndex < containerMax) {
        containerIndex++;
        document.querySelector('.details-row').style.transform = `translateX(-${containerIndex * containerWidth}px)`;
    }
}

leftButton.addEventListener('click', () => moveContainer('left'));
rightButton.addEventListener('click', () => moveContainer('right'));
