const fileSelectInput = document.getElementById('picture-upload-input');

fileSelectInput.addEventListener('change', () => {
    checkFileInput();
})

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
    } else {
        saveButton.classList.remove('disable-button');
        saveButton.classList.add('primary-button');
    }
}

function updateProfilePicture(){
    const backdrop = document.getElementById('backdrop-modal');
    const changeProfileModal = document.getElementById('profile-change-modal-container');
    const successMessageContainer = document.getElementById('profile-update-success');

    changeProfileModal.style.visibility = 'hidden';
    successMessageContainer.style.visibility = 'visible';
    backdrop.addEventListener('click', () => {
        const backdrop = document.getElementById('backdrop-modal');
        const successMessageContainer = document.getElementById('profile-update-success');

        backdrop.style.visibility = 'hidden';
        successMessageContainer.style.visibility = 'hidden';
    });

    setTimeout(() => {
        const backdrop = document.getElementById('backdrop-modal');
        const successMessageContainer = document.getElementById('profile-update-success');

        backdrop.style.visibility = 'hidden';
        successMessageContainer.style.visibility = 'hidden';
    }, 5000);
}