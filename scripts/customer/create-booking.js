const submitButton = document.getElementById('booking-create-submit-button');

/*
    Purpose - Represents the current status of the form row
    0 - Days to complete shown
    1 - End date shown
 */
let currentStatus = 0;

/*
    Fields of the Booking Form
 */
const jobTypeInput = document.getElementById('job-type');
const workerInput = document.getElementById('worker-id');
const startDateInput = document.getElementById('start-date');
const endDateInput = document.getElementById('end-date');
const switchButton = document.getElementById('change-days-complete-button');

/* Getting the Days Input */
let daysToComplete = null;
function gettingCheckedTime() {
    const daysRadioInputs = document.getElementsByName('time-input');

    for (let i = 0; i < daysRadioInputs.length; i++) {
        if (daysRadioInputs[i].checked) {
            return daysRadioInputs[i];
        }
    }
}

daysToComplete = gettingCheckedTime();

switchButton.addEventListener('click',() => { currentStatus = switchDaysRow(currentStatus); });

/*
    Purpose - Change the form days to complete row between days to complete and end date selection
 */
function switchDaysRow(currentStatus){
    const daysToCompletedContainer = document.getElementById('days-complete-container');
    const endDateContainer = document.getElementById('end-date-container');
    const switchButton = document.getElementById('change-days-complete-button');

    if(currentStatus === 0){
        /*
            Action - Need to change to showing end date selection
         */

        daysToCompletedContainer.style.display = 'none';
        endDateContainer.style.display = 'flex';
        switchButton.innerText = 'Predefined time';
    }else{
        /*
            Action - Need to change to showing the days to complete cards
         */

        daysToCompletedContainer.style.display = 'block';
        endDateContainer.style.display = 'none';
        switchButton.innerText = 'Custom date';

    }

    currentStatus = (currentStatus + 1) % 2;
    return currentStatus;
}

/* Getting the Payment Method */
let paymentMethod = null;
const paymentMethodInputs = document.getElementsByName('payment-method');
for(let i = 0; i < paymentMethodInputs.length; i++){
    if(paymentMethodInputs[i].checked){
        paymentMethod = paymentMethodInputs[i];
        break;
    }
}

/* Get the Current Date */
function updateDates(){
    const today = new Date();
    const date = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();

    const currentDateText =`${year}-${month}-${date}`;

    startDateInput.min = currentDateText;
    startDateInput.value = currentDateText;
    endDateInput.value = currentDateText;
    endDateInput.value = currentDateText;

    const maximumMonth = String(today.getMonth() + 3).padStart(2, '0');

    startDateInput.max = `${year}-${maximumMonth}-${date}`;
    endDateInput.max = `${year}-${maximumMonth}-${date}`;
}

updateDates();

if(window.XMLHttpRequest){
    XMLHttpRequestObject = new XMLHttpRequest();
}else if(window.ActiveXObject){
    XMLHttpRequestObject = new ActiveXObject('Microsoft.XMLHTTP');
}

function createBooking(dataSource, data){
    const params = `job-type=${data['job-type']}&worker-id=${data['worker-id']}&start-date=${data['start-date']}&time-input=${data['time-input']}&payment-method=${data['payment-method']}`;

    XMLHttpRequestObject.open('POST', dataSource);
    XMLHttpRequestObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    XMLHttpRequestObject.onreadystatechange = function (){

        if(XMLHttpRequestObject.readyState === 4 && XMLHttpRequestObject.status === 200){
            const successDiv = document.getElementById('booking-create-success');
            const bookingCreateForm = document.getElementById('create-booking-container');
            const bookingBackdrop = document.getElementById('backdrop-modal');
            const messageBackdrop = document.getElementById('message-backdrop');

            successDiv.style.visibility = 'visible';
            messageBackdrop.style.visibility = 'visible';
            bookingBackdrop.style.visibility = 'hidden';
            bookingCreateForm.style.visibility = 'hidden';

            setTimeout( () => {
                successDiv.style.visibility = 'hidden';
                messageBackdrop.style.visibility = 'hidden';
                window.location.href = "../customer/bookings.php";
            }, 5000);
        }else if(XMLHttpRequestObject.status === 400){
            const failDiv = document.getElementById('booking-create-fail');
            const bookingCreateForm = document.getElementById('create-booking-container');
            const bookingBackdrop = document.getElementById('backdrop-modal');
            const messageBackdrop = document.getElementById('message-backdrop');

            failDiv.style.visibility = 'visible';
            messageBackdrop.style.visibility = 'visible';
            bookingBackdrop.style.visibility = 'hidden';
            bookingCreateForm.style.visibility = 'hidden';

            setTimeout( () => {
                successDiv.style.visibility = 'hidden';
                messageBackdrop.style.visibility = 'hidden';
                window.location.href = "../customer/bookings.php";
            }, 5000);
        }
    }

    XMLHttpRequestObject.send(params);
}

startDateInput.addEventListener('change', () => {
    const currentStartDate = new Date(startDateInput.value);

    const date = String(currentStartDate.getDate()).padStart(2, '0');
    const month = String((currentStartDate.getMonth() + 2) % 12 + 1).padStart(2, '0');
    const year = currentStartDate.getFullYear();

    const endDateInput = document.getElementById('end-date');

    endDateInput.min = startDateInput.value;
    endDateInput.value = startDateInput.value;
    endDateInput.max = `${year}-${month}-${date}`;
})

submitButton.addEventListener('click', (e) => {
    e.preventDefault();

    // Calculating the time input
    let timeToComplete = null;
    if(currentStatus === 0){
        daysToComplete = gettingCheckedTime();
        timeToComplete = daysToComplete.value;
    }else{
        timeToComplete = (new Date(endDateInput.value) - new Date(startDateInput.value)) / (1000 * 60 * 60 * 24);
    }

    // Note: Debugging
    console.log(timeToComplete);

    const formData = {'job-type': jobTypeInput.value, 'worker-id': workerInput.value, 'start-date': startDateInput.value, 'time-input': timeToComplete, 'payment-method': paymentMethod.value};
    createBooking(`http://localhost/labour_link/customer/create-booking.php`, formData);
});
