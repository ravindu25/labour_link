const editItemContainers = ['edit-item-username', 'edit-item-email', 'edit-item-contactnum', 'edit-item-nic', 'edit-item-dob', 'edit-item-address'];

const fileSelectInput = document.getElementById('picture-upload-input');

fileSelectInput.addEventListener('change', () => {
    checkFileInput();
})

editItemContainers.forEach(editItem => {
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