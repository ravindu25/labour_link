const popularBookingTypes = document.getElementById('popular-booking-types');
const monthlyBookingTypes = document.getElementById('monthly-booking-types');
const totalBookings = document.getElementById('total-bookings');
const ongoingBookings = document.getElementById('ongoing-bookings');
const userTypes = document.getElementById('classification-of-users');
const monthlyUserRegistration = document.getElementById('monthly-user-registration');

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

            fetch(`http://localhost/labour_link/api/charts/users.php?term=getUsersCount`, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            })
                .then(response => response.json())
                .then(data => {
                    loadUserTypes(userTypes, data.fifthResult);
                    loadMonthlyUserRegistration(monthlyUserRegistration, data.sixthResult);
                })
                .catch(error => {
                    const backdrop = document.getElementById('modal-backdrop');
                    const errorMessageContainer = document.getElementById('error-message-container');
                    console.log(error);

                    backdrop.style.visibility = 'visible';
                    errorMessageContainer.style.visibility = 'visible';
                });
        })
        .catch(error => {
            const backdrop = document.getElementById('modal-backdrop');
            const errorMessageContainer = document.getElementById('error-message-container');
            console.log(error);

            backdrop.style.visibility = 'visible';
            errorMessageContainer.style.visibility = 'visible';
        });
}

initialLoad();

function loadPopularBookings(popularBookingTypes, data){
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
                backgroundColor: "#A5D7E8",
                data: labels.map(label => updatedData[`${label}-${oneBeforeLastMonth}`])
            },
            {
                label: monthNames[previousMonth - 1],
                backgroundColor: "#576CBC",
                data: labels.map(label => updatedData[`${label}-${previousMonth}`])
            },
            {
                label: monthNames[currentMonth - 1],
                backgroundColor: "#19376D",
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
                y: {
                    ticks: {
                        min: 0,
                    }
                },
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
                borderWidth: 1,
                borderColor: 'green',
                fill: true
            }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        min: 0,
                    }
                },
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
                data: chartData,
                backgroundColor: ['#5C469C' , 'pink']
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
        },
    })
}

function loadUserTypes(userTypes, data){
    const labels = data.map(element => element.Type);
    const barData = data.map(element => parseInt(element.UserCount));

    new Chart(userTypes, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Number of users',
                data: barData,
                borderWidth: 1,
                backgroundColor: '#19A7CE'
            }
            ]
        },
        options: {
            indexAxis: 'y',
            // Elements options apply to all of the options unless overridden in a dataset
            // In this case, we are setting the border of each horizontal bar to be 2px wide
            elements: {
                bar: {
                    borderWidth: 2,
                }
            },
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
            scales: {
                y: {
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 20,
                        },
                        color: 'black'
                    }
                }
            }
        }
    });
}

function loadMonthlyUserRegistration(monthlyUserRegistration, data){
    // console.log(data);

    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"
    ];
    for(let i = 0; i < data.length; i++){
        data[i]['Month'] = monthNames[parseInt(data[i]['Month']) - 1];
    }

    console.log(data);
    let upperStack = []; // For admin
    let middleStack = []; // For worker
    let bottomStack = []; // For customer

    for(let i = 0; i < monthNames.length; i++){
        const adminData = data.find(element => (element.Month === monthNames[i] && element.Type === 'Admin'));
        if(adminData){
            upperStack.push(parseInt(adminData.UserCount));
        } else {
            upperStack.push(0);
        }

        const workerData = data.find(element => (element.Month === monthNames[i] && element.Type === 'Worker'));
        if(workerData){
            middleStack.push(parseInt(workerData.UserCount));
        } else {
            middleStack.push(0);
        }

        const customerData = data.find(element => (element.Month === monthNames[i] && element.Type === 'Customer'));
        if(customerData){
            bottomStack.push(parseInt(customerData.UserCount));
        } else {
            bottomStack.push(0);
        }
    }

    const labels = data.map(element => monthNames[parseInt(element.Month) - 1]);


    var chartData = {
        labels: monthNames,
        datasets: [
            {
                label: 'Admin',
                backgroundColor: "#F5C6EC",
                data: upperStack
            },
            {
                label: 'Worker',
                backgroundColor: "#7AA874",
                data: middleStack
            },
            {
                label: 'Customer',
                backgroundColor: "#9A208C",
                data: bottomStack
            }
        ]
    };

    var myBarChart = new Chart(monthlyUserRegistration, {
        type: 'bar',
        data: chartData,
        options: {
            // barValueSpacing: 20,
            scales: {
                y: {
                    stacked: true,
                    ticks: {
                        min: 0,
                    }
                },
                x: {
                    stacked: true,
                    ticks: {
                        font: {
                            family: 'Inter',
                            size: 20,
                        },
                        color: 'black'
                    }
                },
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