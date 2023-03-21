let taskListShowAll = false;

function switchTaskList(){
    const completedTasks = document.getElementsByClassName('completed-tasks');
    const taskCompletedButton = document.getElementById('task-show-button');

    for(let i = 0; i < completedTasks.length; i++){
        if(taskListShowAll === false){
            completedTasks[i].style.display = 'flex';
        } else {
            completedTasks[i].style.display = 'none';
        }
    }
    taskListShowAll = !taskListShowAll;
    if(taskListShowAll === true){
        taskCompletedButton.innerHTML = '<i class="fa-solid fa-arrow-up"></i>&nbsp;&nbsp;Hide completed';
    } else {
        taskCompletedButton.innerHTML = '<i class="fa-solid fa-arrow-down"></i>&nbsp;&nbsp;Show completed';
    }
}