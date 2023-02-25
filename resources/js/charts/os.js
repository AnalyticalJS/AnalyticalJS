import Chart from 'chart.js/auto';
new Chart(document.getElementById('osChart'),
    {
    type: 'doughnut',
    data: {
        labels: osData.map(row => row.label),
        datasets: [
        {
            label: 'Amount',
            data: osData.map(row => row.count),
            borderColor: '#22ddb7',
            backgroundColor: '#c2fff3'
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});