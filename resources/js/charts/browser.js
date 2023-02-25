import Chart from 'chart.js/auto';
new Chart(document.getElementById('browser'),
    {
    type: 'doughnut',
    data: {
        labels: browserData.map(row => row.label),
        datasets: [
        {
            label: 'Amount',
            data: browserData.map(row => row.count),
            borderColor: '#22ddb7',
            backgroundColor: '#c2fff3'
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});