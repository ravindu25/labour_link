let taskListShowAll = false;



function showMarkDoneContainer(taskId, houseID){
    const backdrop = document.getElementById('backdrop-modal');
    const markDoneContainer = document.getElementById('mark-done-confirm-container');

    //add event listener to mark done button

    const markDoneButton = document.getElementById('mark-done-button');
    markDoneButton.addEventListener('click', () => {
        fetch("http://localhost/labour_link/customer/markJobComplete.php", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                "taskID": taskId,
                "houseID": houseID
            })
        })
            .then(() => {
                const confirmModal = document.getElementById('mark-done-confirm-container');
                const successModal = document.getElementById('mark-done-complete-container');

                confirmModal.style.visibility = 'hidden';
                successModal.style.visibility = 'visible';
                //set 2 seconds timeout and then hide the success modal
                setTimeout(() => {
                    successModal.style.visibility = 'hidden';
                    backdrop.style.visibility = 'hidden';
                    window.location.reload();
                }
                , 2000);
            })
            .catch(error => {
                const confirmModal = document.getElementById('mark-done-confirm-container');
                const failedModal = document.getElementById('mark-done-failed-container');

                confirmModal.style.visibility = 'hidden';
                failedModal.style.visibility = 'visible';
                //set 2 seconds timeout and then hide the success modal
                setTimeout(() => {
                    failedModal.style.visibility = 'hidden';
                    backdrop.style.visibility = 'hidden';
                    window.location.reload();
                }
                , 2000);
            });
    
    });
   
        

    backdrop.addEventListener('click', () => {
        hideMarkDoneContainer();
    });

    backdrop.style.visibility = 'visible';
    markDoneContainer.style.visibility = 'visible';
}

function hideMarkDoneContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const markDoneContainer = document.getElementById('mark-done-confirm-container');

    backdrop.removeEventListener('click', () => {
        hideMarkDoneContainer();
    });

    backdrop.style.visibility = 'hidden';
    markDoneContainer.style.visibility = 'hidden';

}

function showAdvertisementContainer(houseId, jobId){
    const backdrop = document.getElementById('backdrop-modal');
    const advertisementContainer = document.getElementById('create-advertise-container');


    backdrop.addEventListener('click', () => {
        hideAdvertisementContainer();
    });

    console.log(`House id = ${houseId}, Job id = ${jobId}`);

    backdrop.style.visibility = 'visible';
    advertisementContainer.style.visibility = 'visible';

    //add event listener to create advertisement button
    const createAdvertisementButton = document.getElementById('place-advertisement-button');
    createAdvertisementButton.addEventListener('click', () => {
        const worker_amount = document.getElementById('worker-amount-input').value;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                if(this.responseText.trim()=="success"){
                    const successmodal = document.getElementById('advertise-complete-container');
                    advertisementContainer.style.visibility="hidden";
                    successmodal.style.visibility="visible";
                    setTimeout(() => {
                        successmodal.style.visibility = 'hidden';
                        backdrop.style.visibility = 'hidden';
                        window.location.reload();   
                    }
                    , 3000);

                    
                }else if(this.responseText.trim()=="fail"){
                    const failedmodal = document.getElementById('advertise-failed-container');
                    advertisementContainer.style.visibility="hidden";
                    successmodal.style.visibility="visible";
                    setTimeout(() => {
                        failedmodal.style.visibility = 'hidden';
                        backdrop.style.visibility = 'hidden';
                        window.location.reload();
                    }
                    , 3000);
                }
            }
        };
        xhttp.open("POST", "http://localhost/labour_link/customer/placeAdvertisement.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("houseID=" + houseId + "&jobID=" + jobId + "&worker_amount=" + worker_amount);
        

    }
    );
}

function hideAdvertisementContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const advertisementContainer = document.getElementById('create-advertise-container');

    backdrop.removeEventListener('click', () => {
        hideAdvertisementContainer();
    });

    backdrop.style.visibility = 'hidden';
    advertisementContainer.style.visibility = 'hidden';
}

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