const popularBookingTypes = document.getElementById('popular-booking-types');
const monthlyBookingTypes = document.getElementById('monthly-booking-types');
const totalBookings = document.getElementById('total-bookings');
const ongoingBookings = document.getElementById('ongoing-bookings');

function initialLoad(){
    const currentYear = new Date().getFullYear();

    fetch(`http://localhost/labour_link/api/charts/bookings.php?term=getBookingCount&year=${currentYear}`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            loadPopularBookings(popularBookingTypes, data.firstResult);
            loadMonthlyBookings(monthlyBookingTypes, data.secondResult);
            loadTotalBookings(totalBookings, data.thirdResult);
            loadOngoingBookings(ongoingBookings, data.fourthResult);
        })
        .catch(error => {
            console.log(error);
        });
}

initialLoad();

function loadPopularBookings(popularBookingTypes, data){
    console.log('Inside the loadPopularBookings ');
    const labels = data.map(element => element.workerType);
    const pieData = data.map(element => element.bookingCount);
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
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 18,
                        },
                        color: 'black'
                    }
                },
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
                }],
                x: {
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 20,
                        },
                        color: 'black'
                    }
                }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 17,
                        },
                        color: 'black'
                    }
                },
            }
        },
    });
}

function loadTotalBookings(totalBookings, data){
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    const chartData = data.map(element => element.bookingCount);
    const labels = data.map(element => monthNames[parseInt(element.month) - 1]);

    var myLineChart = new Chart(totalBookings,{
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of bookings',
                data: chartData,
                borderWidth: 1
            }
            ]
        },
        scales: {
            yAxes: [{
                ticks: {
                    min: 0,
                }
            }],
            x:{
                ticks: {
                    font: {
                        family: 'Inter',
                        size: 20,
                    },
                    color: 'black'
                }
            }
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 17,
                        },
                        color: 'black'
                    }
                },
            }
        },
    });
}

function loadOngoingBookings(ongoingBookings, data){
    const chartData = data.map(element => element.bookingCount);
    const labels = data.map(element => element.status);

    var myDoughnutChart = new Chart(ongoingBookings,{
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: chartData
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            family: 'Inter',
                            size: 17,
                        },
                        color: 'black'
                    }
                },
            },
            radius: [180, 450]
        },
    })
}