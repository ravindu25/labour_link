const submitButton = document.getElementById('booking-create-submit-button');

/*
    Fields of the Booking Form
 */
const jobTypeInput = document.getElementById('job-type');
const workerInput = document.getElementById('worker-id');
const startDateInput = document.getElementById('start-date');

/* Getting the Days Input */
let daysToComplete = null;
const daysRadioInputs = document.getElementsByName('time-input');
for(let i = 0; i < daysRadioInputs.length; i++){
    if(daysRadioInputs[i].checked){
        daysToComplete = daysRadioInputs[i];
        break;
    }
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
function getToday(){
    const today = new Date();
    const date = String(today.getDate()).padStart(2, '0');
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const year = today.getFullYear();

    return `${year}-${month}-${date}`;
}

startDateInput.value = getToday();

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
            const bookingCreateForm = document.getElementById('booking-details-container');

            successDiv.style.visibility = 'visible';
            bookingCreateForm.style.visibility = 'hidden';
        }else{
            const failDiv = document.getElementById('booking-create-fail');
            const bookingCreateForm = document.getElementById('booking-details-container');

            failDiv.style.visibility = 'visible';
            bookingCreateForm.style.visibility = 'hidden';
        }
    }

    XMLHttpRequestObject.send(params);
}

submitButton.addEventListener('click', (e) => {
    e.preventDefault();
    const formData = {'job-type': jobTypeInput.value, 'worker-id': workerInput.value, 'start-date': startDateInput.value, 'time-input': daysToComplete.value, 'payment-method': paymentMethod.value};
    createBooking(`http://localhost/labour_link/customer/create-booking.php`, formData);
});
