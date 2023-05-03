const popularBookingTypes = document.getElementById('popular-booking-types');
const monthlyBookingTypes = document.getElementById('monthly-booking-types');

function initialLoad(){
    const currentYear = new Date().getFullYear();

    fetch(`http://localhost/labour_link/api/charts/bookings.php?term=getBookingCount&year=${currentYear}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const labels = data.firstResult.map(element => element.workerType);
            const pieData = data.firstResult.map(element => element.bookingCount);

            loadPopularBookings(popularBookingTypes, labels, pieData);
            loadMonthlyBookings(monthlyBookingTypes, data.secondResult)
        })
        .catch(error => {
            console.log(error);
        });
}

initialLoad();

function loadPopularBookings(popularBookingTypes, labels, pieData){
    console.log('Inside the loadPopularBookings ');
    new Chart(popularBookingTypes, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of bookings',
                data: pieData,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function loadMonthlyBookings(monthlyBookingTypes, data){
    let labels = [];
    data.forEach(element => {
        if(!labels.includes(element.workerType)) {
            labels.push(element.workerType);
        }
    });

    let updatedData = {};
    data.forEach(element => {
        updatedData[`${element.workerType}-${element.month}`] = parseInt(element.bookingCount);
    });
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    const currentMonth = new Date().getMonth() + 1;
    const previousMonth = currentMonth - 1;
    const oneBeforeLastMonth = currentMonth - 2;

    var data = {
        labels: labels,
        datasets: [
            {
                label: monthNames[oneBeforeLastMonth - 1],
                backgroundColor: "red",
                data: labels.map(label => updatedData[`${label}-${oneBeforeLastMonth}`])
            },
            {
                label: monthNames[previousMonth - 1],
                backgroundColor: "blue",
                data: labels.map(label => updatedData[`${label}-${previousMonth}`])
            },
            {
                label: monthNames[currentMonth - 1],
                backgroundColor: "green",
                data: labels.map(label => updatedData[`${label}-${currentMonth}`])
            }
        ]
    };

    var myBarChart = new Chart(monthlyBookingTypes, {
        type: 'bar',
        data: data,
        options: {
            barValueSpacing: 20,
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                    }
                }]
            }
        }
    });
}
