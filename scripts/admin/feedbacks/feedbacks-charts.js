const allFeedbacksChart = document.getElementById('chart-all-feedbacks')


function showFeedbackCount(allFeedbackCount, year, month) {
    /*
     * Fill the array with number of days in the month
     */
    const numberOfDays = new Date(year, month, 0).getDate();
    let xAxisLabels = [];
    let yAxisValues = [];

    for(let i = 1; i <= numberOfDays; i++){
        const monthText = month < 10 ? `0${month}` : month;
        const dayText = i < 10 ? `0${i}` : i;
        xAxisLabels.push(`${year}-${monthText}-${dayText}`);

        const element = allFeedbackCount.find(element => element.date === `${year}-${monthText}-${dayText}`);
        if(element){
            yAxisValues.push(element.feedbackCount);
        } else {
            yAxisValues.push(0);
        }
    }

    new Chart(allFeedbacksChart, {
        type: 'line',
        data: {
            labels: xAxisLabels,
            datasets: [{
                label: 'Number of Feedbacks',
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
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

function showFeedbackSkippingRate(skippingRateData){
    const skippingRateChart = document.getElementById('chart-feedback-skipping');
    const xAxisLabels = skippingRateData.map(element => element.customerName);
    const yAxisValues = skippingRateData.map(element => element.feedbackCount);

    new Chart(skippingRateChart, {
        type: 'bar',
        data: {
            labels: xAxisLabels,
            datasets: [{
                label: 'Number of skipped Feedbacks',
                fill: true,
                backgroundColor: '#F2D49B',
                data: yAxisValues,
                borderColor: '#FF5B19',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}