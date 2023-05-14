const editItemContainers = ['edit-item-username', 'edit-item-contactnum', 'edit-item-dob', 'edit-item-address'];

const fileSelectInput = document.getElementById('picture-upload-input');

fileSelectInput.addEventListener('change', () => {
    checkFileInput();
})

editItemContainers.forEach((editItem) => {
    const editItemContainer = document.getElementById(editItem);

    editItemContainer.addEventListener('mouseover', () => {
        showEditButton(`button-${editItem}`);
    });

    editItemContainer.addEventListener('mouseout', () => {
        hideEditButton(`button-${editItem}`);
    });
});

document.getElementById('firstname-input').addEventListener('change', () => {
    const firstNameInput = document.getElementById('firstname-input');
    const secondNameInput = document.getElementById('lastname-input');
    const updateButton = document.getElementById('update-button-username');

    if(firstNameInput.value == '' && secondNameInput.value == ''){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

document.getElementById('lastname-input').addEventListener('change', () => {
    const firstNameInput = document.getElementById('firstname-input');
    const secondNameInput = document.getElementById('lastname-input');
    const updateButton = document.getElementById('update-button-username');

    if(firstNameInput.value == '' && secondNameInput.value == ''){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disabled-button');
    } else {
        updateButton.classList.remove('disabled-button');
        updateButton.classList.add('primary-button');
    }
});

document.getElementById('email-input').addEventListener('change', () => {
    const emailInput = document.getElementById('email-input');
    const updateButton = document.getElementById('update-button-email');

    const emailRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


    if(emailInput.value == '' || !emailRegex.test(emailInput.value)){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

document.getElementById('contactnum-input').addEventListener('change', () => {
    const contactInput = document.getElementById('contactnum-input');
    const updateButton = document.getElementById('update-button-contactnum');

    const phoneRegex = /0[0-9]{9}/;

    if(contactInput.value == '' || !phoneRegex.test(contactInput.value)){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

document.getElementById('nic-input').addEventListener('change', () => {
    const nicInput = document.getElementById('nic-input');
    const updateButton = document.getElementById('update-button-nic');

    const nicRegex = /^([0-9]{9}[x|X|v|V]|[0-9]{12})/;

    if(nicInput.value == '' || !nicRegex.test(nicInput.value)){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

const dobInput = document.getElementById('dob-input');
const today = new Date();
const date = String(today.getDate()).padStart(2, '0');
const month = String(today.getMonth() + 1).padStart(2, '0');
const year = today.getFullYear();
dobInput.max = `${year}-${month}-${date}`;

document.getElementById('dob-input').addEventListener('change', () => {
    const dobInput = document.getElementById('dob-input');
    const updateButton = document.getElementById('update-button-dob');

    const today = new Date();
    console.log(today.toDateString());

    if(dobInput.value == ''){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

document.getElementById('address-input').addEventListener('change', () => {
    const addressInput = document.getElementById('address-input');
    const updateButton = document.getElementById('update-button-address');

    if(addressInput.value == ''){
        updateButton.classList.remove('primary-button');
        updateButton.classList.add('disable-button');
    } else {
        updateButton.classList.remove('disable-button');
        updateButton.classList.add('primary-button');
    }
});

/* Change password checking */
document.getElementById('new-password-input').addEventListener('change', () => {
    checkPasswords();
});

document.getElementById('reenter-new-password-input').addEventListener('change', () => {
    checkPasswords();
});

function checkPasswords(){
    const newPassword = document.getElementById('new-password-input').value;
    const reEnterNewPassword = document.getElementById('reenter-new-password-input').value;
    const changePasswordButton = document.getElementById('change-password-button');

    if(newPassword != '' && newPassword == reEnterNewPassword){
        changePasswordButton.classList.remove('disable-button');
        changePasswordButton.classList.add('primary-button');
        changePasswordButton.disabled = false;
    } else {
        changePasswordButton.classList.remove('primary-button');
        changePasswordButton.classList.add('disable-button');
    }
}


function updatePassword(user_id){
    const enteredCurrPassword = document.getElementById('current-password-input').value;
    const newPassword = document.getElementById('new-password-input').value;
    const reEnterNewPassword = document.getElementById('reenter-new-password-input').value;


    fetch ('http://localhost/labour_link/customer/changePassword.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newPassword: newPassword,
            reEnterNewPassword: reEnterNewPassword,
            enteredCurrPassword: enteredCurrPassword
        })

    }).then(response => response.json())
        .then(data => {
            if(data.statusCode == 200){
                const changePasswordModal = document.getElementById('change-password-container');
                const successModal = document.getElementById('password-change-success');

                changePasswordModal.style.visibility = 'hidden';
                successModal.style.visibility = 'visible';
                //timeout 2 seconds then reload page
                setTimeout(function(){
                    location.reload();
                }, 2000);
            }else if(data.statusCode == 201){
                const changePasswordModal = document.getElementById('change-password-container');
                const failedModal = document.getElementById('password-change-fail');
                const failedText = document.getElementById('password-update-failed-text');
                failedText.innerHTML = "Server Error. Please try again later.";

                changePasswordModal.style.visibility = 'hidden';
                failedModal.style.visibility = 'visible';
                //timeout 2 seconds then reload page
                setTimeout(function(){
                    failedModal.style.visibility = 'hidden';
                    changePasswordModal.style.visibility = 'visible';
                }, 2000);
            }else if(data.statusCode == 202){
                const changePasswordModal = document.getElementById('change-password-container');
                const failedModal = document.getElementById('password-change-fail');
                const failedText = document.getElementById('password-update-failed-text');
                failedText.innerHTML = "Current Password is Incorrect";

                changePasswordModal.style.visibility = 'hidden';
                failedModal.style.visibility = 'visible';
                //timeout 2 seconds then reload page
                setTimeout(function(){
                    failedModal.style.visibility = 'hidden';
                    changePasswordModal.style.visibility = 'visible';
                }, 2000);

            }else{
                alert("error");
            }
        })


}

function showEditButton(buttonId){
    const editButton = document.getElementById(buttonId);

    editButton.style.visibility = 'visible';
}

function hideEditButton(buttonId){
    const editButton = document.getElementById(buttonId);

    editButton.style.visibility = 'hidden';
}

function openChangeProfileModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const changeProfileModal = document.getElementById('profile-change-modal-container');

    backdrop.style.visibility = 'visible';
    changeProfileModal.style.visibility = 'visible';
}

function closeChangeProfileModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const changeProfileModal = document.getElementById('profile-change-modal-container');

    const currentPictureContainer = document.getElementById('current-picture-container');
    const selectImageContainer = document.getElementById('select-image-container');
    const setDefaultButton = document.getElementById('set-default-button');
    const removePictureButton = document.getElementById('remove-picture-button');
    const saveButton = document.getElementById('save-button');

    backdrop.style.visibility = 'hidden';
    changeProfileModal.style.visibility = 'hidden';

    currentPictureContainer.style.display = 'block';
    selectImageContainer.style.display = 'none';
    setDefaultButton.style.display = 'none';
    removePictureButton.style.display = 'inline';
    saveButton.style.display = 'none';
}

function setDefaultProfile() {
    img.onerror = null;
    img.src = "../assets/profile-image/default.jpg";
}

function goNextProfileChangePage(){
    const currentPictureContainer = document.getElementById('current-picture-container');
    const selectImageContainer = document.getElementById('select-image-container');
    const setDefaultButton = document.getElementById('set-default-button');
    const removePictureButton = document.getElementById('remove-picture-button');
    const saveButton = document.getElementById('save-button');

    currentPictureContainer.style.display = 'none';
    selectImageContainer.style.display = 'flex';
    setDefaultButton.style.display = 'inline';
    removePictureButton.style.display = 'none';
    saveButton.style.display = 'inline';

}

function checkFileInput(){
    const fileSelectInput = document.getElementById('picture-upload-input');
    const saveButton = document.getElementById('save-button');

    if(fileSelectInput.files.length == 0){
        saveButton.classList.remove('primary-button');
        saveButton.classList.add('disable-button');
        saveButton.disabled = true;
    } else {
        saveButton.classList.remove('disable-button');
        saveButton.classList.add('primary-button');
        saveButton.disabled = false;
    }
}

function successProfileUpdate(){
    const changeProfileModal = document.getElementById('profile-change-modal-container');
    const successMessageContainer = document.getElementById('profile-update-success');

    changeProfileModal.style.visibility = 'hidden';
    successMessageContainer.style.visibility = 'visible';

    setTimeout(() => {
        const backdrop = document.getElementById('backdrop-modal');
        const successMessageContainer = document.getElementById('profile-update-success');

        backdrop.style.visibility = 'hidden';
        successMessageContainer.style.visibility = 'hidden';
    }, 5000);
}

function failedProfileUpdate(errorMessage){
    const changeProfileModal = document.getElementById('profile-change-modal-container');
    const failMessageContainer = document.getElementById('profile-update-fail');
    const failErrorText = document.getElementById('housing-create-fail-text');

    changeProfileModal.style.visibility = 'hidden';
    failMessageContainer.style.visibility = 'visible';
    failErrorText.innerText = errorMessage;

    setTimeout(() => {
        const backdrop = document.getElementById('backdrop-modal');
        const failMessageContainer = document.getElementById('profile-update-fail');

        backdrop.style.visibility = 'hidden';
        failMessageContainer.style.visibility = 'hidden';
    }, 5000);
}

function openEditModal(modalId){
    const backdrop = document.getElementById('backdrop-modal');
    const editModal = document.getElementById(modalId);

    backdrop.style.visibility = 'visible';
    editModal.style.visibility = 'visible';
}

function closeEditModal(modalId){
    const backdrop = document.getElementById('backdrop-modal');
    const editModal = document.getElementById(modalId);

    backdrop.style.visibility = 'hidden';
    editModal.style.visibility = 'hidden';
}

function showChangePasswordModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const changePasswordModal = document.getElementById('change-password-container');

    backdrop.style.visibility = 'visible';
    changePasswordModal.style.visibility = 'visible';
}

function closeChangePasswordModal(){
    const backdrop = document.getElementById('backdrop-modal');
    const changePasswordModal = document.getElementById('change-password-container');

    backdrop.style.visibility = 'hidden';
    changePasswordModal.style.visibility = 'hidden';

}



function updateContactNum(user_id){
    const contactNumInput = document.getElementById('contactnum-input');
    const contactNum = contactNumInput.value;

    //fetch request to update contact number
    
    fetch ('http://localhost/labour_link/customer/changeDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newValue: contactNum,
            field: 'Contact_No'
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const changeModal = document.getElementById('edit-modal-contactnum');
            const successModal = document.getElementById('account-details-update-success');

            changeModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const changeModal = document.getElementById('edit-modal-contactnum');
            const failedModal = document.getElementById('account-details-update-fail');

            changeModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

function updateNIC(user_id){
    const nicInput = document.getElementById('nic-input');
    const nic = nicInput.value;

    //fetch request to update contact number
    
    fetch ('http://localhost/labour_link/customer/changeDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newValue: nic,
            field: 'NIC'
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const changeModal = document.getElementById('edit-modal-nic');
            const successModal = document.getElementById('account-details-update-success');

            changeModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const changeModal = document.getElementById('edit-modal-nic');
            const failedModal = document.getElementById('account-details-update-fail');

            changeModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

function updateDOB(user_id){
    const dobInput = document.getElementById('dob-input');
    const dob = dobInput.value;

    //fetch request to update contact number
    
    fetch ('http://localhost/labour_link/customer/changeDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newValue: dob,
            field: 'DOB'
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const changeModal = document.getElementById('edit-modal-dob');
            const successModal = document.getElementById('account-details-update-success');

            changeModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const changeModal = document.getElementById('edit-modal-dob');
            const failedModal = document.getElementById('account-details-update-fail');

            changeModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

function updateAddress(user_id){
    const addressInput = document.getElementById('address-input');
    const address = addressInput.value;

    //fetch request to update contact number
    
    fetch ('http://localhost/labour_link/customer/changeDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newValue: address,
            field: 'User_Address'
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const changeModal = document.getElementById('edit-modal-address');
            const successModal = document.getElementById('account-details-update-success');

            changeModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const changeModal = document.getElementById('edit-modal-address');
            const failedModal = document.getElementById('account-details-update-fail');

            changeModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

function updateName(user_id){
    const firstNameInput = document.getElementById('firstname-input');
    const firstName = firstNameInput.value;

    const lastNameInput = document.getElementById('lastname-input');
    const lastName = lastNameInput.value;

    //fetch request to update contact number
    
    fetch ('http://localhost/labour_link/customer/changeDetails.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            newFirstName: firstName,
            newLastName: lastName,
            field: 'Name'
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const changeModal = document.getElementById('edit-modal-username');
            const successModal = document.getElementById('account-details-update-success');

            changeModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const changeModal = document.getElementById('edit-modal-username');
            const failedModal = document.getElementById('account-details-update-fail');

            changeModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

function sendFeedback(user_id){
    alert('feedback sent');
    const feedbackInput = document.getElementById('feedback-text-input');
    const feedback = feedbackInput.value;

    //fetch request to send feedback email to admin

    fetch ('http://localhost/labour_link/customer/sendSystemFeedback.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            user_id: user_id,
            feedback: feedback
        })

    }).then(response => response.json())
    .then(data => {
        if(data.statusCode == 200){
            const feedbackModal = document.getElementById('feedback-message-container');
            const successModal = document.getElementById('feedback-submit-success');

            feedbackModal.style.visibility = 'hidden';
            successModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                successModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }else if(data.statusCode == 201){
            const feedbackModal = document.getElementById('feedback-message-container');
            const failedModal = document.getElementById('feedback-submit-fail');

            feedbackModal.style.visibility = 'hidden';
            failedModal.style.visibility = 'visible';
            
            //timeout 2 seconds then reload page
            setTimeout(function(){
                failedModal.style.visibility = 'hidden';
                location.reload();
            }, 2000);
        }
    })

}

/*
    Applying for a job section
 */
const addJobTypeCards = document.getElementsByName('add-job-type-select');
for(let i = 0; i < addJobTypeCards.length; i++){
    addJobTypeCards[i].addEventListener('click', function(){
        checkJobCardTypes();
    })
}

function checkJobCardTypes(){
    let checked = false;
    const addJobTypeCards = document.getElementsByName('add-job-type-select');

    for(let i = 0; i < addJobTypeCards.length; i++){
        if(addJobTypeCards[i].checked){
            checked = true;
            break;
        }
    }

    const updateButton = document.getElementById('worker-type-add-button');
    if(checked){
        updateButton.addEventListener('click', () => {
            addWorkerJobType();
        });

        updateButton.disabled = false;
        updateButton.classList.add('primary-button');
        updateButton.classList.remove('disable-button');
    } else {
        updateButton.removeEventListener('click', () => {
            addWorkerJobType();
        });

        updateButton.disabled = true;
        updateButton.classList.add('disable-button');
        updateButton.classList.remove('primary-button');
    }
}

function showAddCategoryContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const addCategoryContainer = document.getElementById('add-worker-type-modal');

    backdrop.style.visibility = 'visible';
    addCategoryContainer.style.visibility = 'visible';
}

function hideAddCategoryContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const addCategoryContainer = document.getElementById('add-worker-type-modal');

    backdrop.style.visibility = 'hidden';
    addCategoryContainer.style.visibility = 'hidden';
}

function showActiveDeactivateContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const activeDeactivateContainer = document.getElementById('update-worker-type-modal');
    const typeBox = document.getElementsByName('active-deactive-job-type-select');

    for(let i = 0; i < typeBox.length; i++) {
        typeBox[i].addEventListener('change', checkActiveDeactiveValidity);
    }

    backdrop.style.visibility = 'visible';
    activeDeactivateContainer.style.visibility = 'visible';
}

function hideActiveDeactivateContainer(){
    const backdrop = document.getElementById('backdrop-modal');
    const activeDeactivateContainer = document.getElementById('update-worker-type-modal');
    const typeBox = document.getElementsByName('active-deactive-job-type-select');

    for(let i = 0; i < typeBox.length; i++) {
        typeBox[i].removeEventListener('change', checkActiveDeactiveValidity);
    }

    backdrop.style.visibility = 'hidden';
    activeDeactivateContainer.style.visibility = 'hidden';
}

function checkActiveDeactiveValidity(){
    let changed = false;
    const typeBox = document.getElementsByName('active-deactive-job-type-select');
    const updateButton = document.getElementById('worker-type-switch-button');

    for(let i = 0; i < typeBox.length; i++) {
        const element = categoryStates.find(categoryElement => categoryElement.category === typeBox[i].value);

        if((typeBox[i].checked && element.isActive === 1) || (!typeBox[i].checked && element.isActive === 0)){
            changed = true;
        }

    }

    if(changed === true){
        updateButton.addEventListener('click',() => {
            updateWorkerType(userId);
        });

        updateButton.classList.add('primary-button');
        updateButton.classList.remove('disable-button');
        updateButton.disabled = false;
    } else {
        updateButton.removeEventListener('click',() => {
            updateWorkerType(userId);
        });

        updateButton.classList.add('disable-button');
        updateButton.classList.remove('primary-button');
        updateButton.disabled = true;
    }
}

function addCategory(user_id){
    //get the selected job types
    var selectedJobTypes = document.getElementsByName("add-job-type-select");
    var selectedJobTypesArray = [];

    for(var i = 0; i < selectedJobTypes.length; i++){
        if(selectedJobTypes[i].checked){
            selectedJobTypesArray.push(selectedJobTypes[i].value);
        }
    }

    // send the selected job types to the server
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText.trim() == "success"){
                const successModal = document.getElementById('add-jobType-success');
                const addCategoryContainer = document.getElementById('add-worker-type-modal');
                const backDrop = document.getElementById('backdrop-modal');

                addCategoryContainer.style.visibility = 'hidden';
                successModal.style.visibility = 'visible';

                setTimeout(function(){
                    successModal.style.display = "none";
                    backDrop.style.display = "none";
                    location.reload();
                }, 3000);
            } else {
                const failedModal = document.getElementById('add-jobType-fail');
                const addCategoryContainer = document.getElementById('add-worker-type-modal');
                const backDrop = document.getElementById('backdrop-modal');

                addCategoryContainer.style.visibility = 'hidden';
                failedModal.style.visibility = 'visible';

                setTimeout(function(){
                    failedModal.style.display = "none";
                    backDrop.style.display = "none";
                    location.reload();
                }, 3000);
            }
        }
    };
    xhttp.open("POST", "http://localhost/labour_link/worker/addWorkerType.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("selectedJobTypes=" + selectedJobTypesArray + "&user_id=" + user_id);



}

function updateWorkerType(user_id){
    //get the selected job types
    var selectedJobTypes = document.getElementsByName("active-deactive-job-type-select");
    var selectedJobTypesArray = [];
    var unselectedJobTypesArray = [];

    for(var i = 0; i < selectedJobTypes.length; i++){
        if(selectedJobTypes[i].checked){
            selectedJobTypesArray.push(selectedJobTypes[i].value);
        }else{
            unselectedJobTypesArray.push(selectedJobTypes[i].value);
        }
    }

    // send the selected job types to the server
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText.trim() == "success"){
                const successModal = document.getElementById('update-jobType-success');
                const updateCategoryContainer = document.getElementById('update-worker-type-modal');
                const backDrop = document.getElementById('backdrop-modal');

                updateCategoryContainer.style.visibility = 'hidden';
                successModal.style.visibility = 'visible';

                setTimeout(function(){
                    successModal.style.display = "none";
                    backDrop.style.display = "none";
                    location.reload();
                }, 3000);
            } else {
                const failedModal = document.getElementById('update-jobType-fail');
                const updateCategoryContainer = document.getElementById('update-worker-type-modal');
                const backDrop = document.getElementById('backdrop-modal');

                updateCategoryContainer.style.visibility = 'hidden';
                failedModal.style.visibility = 'visible';

                setTimeout(function(){
                    failedModal.style.display = "none";
                    backDrop.style.display = "none";
                    location.reload();
                }, 3000);
            }
        }
    };
    xhttp.open("POST", "http://localhost/labour_link/worker/changeWorkerType.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("selectedJobTypes=" + selectedJobTypesArray + "&user_id=" + user_id + "&unselectedJobTypes=" + unselectedJobTypesArray);
}
