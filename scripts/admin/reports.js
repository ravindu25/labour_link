const mostPopularBookingType = document.getElementById('most-popular-booking-type');


function initialLoad(){
    fetch(`http://localhost/labour_link/api/charts/bookings.php?term=getBookingCount`, {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.json())
        .then(data => {
            const labels = data.map(element => element.workerType);
            const pieData = data.map(element => element.bookingCount);

            new Chart(mostPopularBookingType, {
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
        })
        .catch(error => {
            console.log(error);
        });
}

initialLoad();
