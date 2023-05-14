function loadMonthlyBookingChart(data){
    const monthlyBookingChart = document.getElementById('chart-all-bookings');
    /*
     * Fill the array with number of days in the month
     */
    const year = new Date().getFullYear();
    const month = new Date().getMonth() + 1;
    const currentDate = new Date().getDate();
    let xAxisLabels = [];
    let yAxisValues = [];

    for(let i = 1; i <= currentDate; i++){
        const monthText = month < 10 ? `0${month}` : month;
        const dayText = i < 10 ? `0${i}` : i;
        xAxisLabels.push(`${year}-${monthText}-${dayText}`);

        const element = data.find(element => element.date === `${year}-${monthText}-${dayText}`);
        if(element){
            yAxisValues.push(element.bookingCount);
        } else {
            yAxisValues.push(0);
        }
    }

    new Chart(monthlyBookingChart, {
        type: 'line',
        data: {
            labels: xAxisLabels,
            datasets: [{
                label: 'Number of Bookings',
                fill: true,
                backgroundColor: '#C4DDF2',
                data: yAxisValues,
                borderColor: '#102699',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function loadOnlineModeBookings(data){
    const onlineBookingsChart = document.getElementById('chart-online-bookings');
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];


    const currentMonth = new Date().getMonth() + 1;
    let xAxisLabels = [];
    let yAxisValues = [];

    for(let i = 1; i <= currentMonth; i++){
        const monthText = monthNames[i - 1];
        xAxisLabels.push(monthText);

        const element = data.find(element => parseInt(element.month) === i);
        if(element){
            yAxisValues.push(element.bookingCount);
        } else {
            yAxisValues.push(0);
        }
    }

    new Chart(onlineBookingsChart, {
        type: 'line',
        data: {
            labels: xAxisLabels,
            datasets: [{
                label: 'Number of Bookings',
                fill: true,
                backgroundColor: '#F2CD5C',
                data: yAxisValues,
                borderColor: '#F28705',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}