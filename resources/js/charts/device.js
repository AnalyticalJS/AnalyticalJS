import Chart from 'chart.js/auto';
new Chart(document.getElementById('device'),
    {
    type: 'doughnut',
    data: {
        labels: deviceData.map(row => row.label),
        datasets: [
        {
            label: 'Amount',
            data: deviceData.map(row => row.count)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});