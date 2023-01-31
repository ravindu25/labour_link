function getWorkers(dataSource, selectId){
    if(XMLHttpRequestObject){
        let obj = document.getElementById(selectId);
        XMLHttpRequestObject.open('GET', dataSource);

        XMLHttpRequestObject.onreadystatechange = function(){
            if(XMLHttpRequestObject.readyState === 4 && XMLHttpRequestObject.status === 200){
                obj.innerHTML = XMLHttpRequestObject.responseText;
            }
        }

        XMLHttpRequestObject.send(null);
    }
}

const workerTypeSelect = document.getElementById('job-type');
const createButton = document.getElementById('booking-create-button');

workerTypeSelect.addEventListener('change',(e) => getWorkers(`http://localhost/labour_link/customer/get-workers.php?type=${e.target.value}`, 'worker-id'));

createButton.addEventListener('click',() => getWorkers(`http://localhost/labour_link/customer/get-workers.php?type=electrician`, 'worker-id'));
