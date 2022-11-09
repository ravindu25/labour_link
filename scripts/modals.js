/*
    Implementation of interactive items like dropdown, modals etc
 */

function opendropdown(){
    const dropDownItems = document.getElementById('dropdown-items');

    if(!dropDownItems.style.display){
        dropDownItems.style.display = 'none';
    }

    if(dropDownItems.style.display === 'none'){
        dropDownItems.style.display = 'block';
    }else{
        console.log('closing dropdown');
        dropDownItems.style.display = 'none';
    }
}