const allFeedbacksChart = document.getElementById('chart-all-feedbacks')


function showFeedbackCount(allFeedbackCount) {
    const xAxisLabels = allFeedbackCount.map(feedback => feedback.date);
    const yAxisValues = allFeedbackCount.map(feedback => parseInt(feedback.feedbackCount));

    console.log(allFeedbackCount);

    new Chart(allFeedbacksChart, {
        type: 'bar',
        data: {
            labels: xAxisLabels,
            datasets: [{
                label: 'Number of Feedbacks',
                data: yAxisValues,
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