import Chart from 'chart.js/auto';
new Chart(document.getElementById('device'),
    {
    type: 'doughnut',
    data: {
        labels: deviceData.map(row => row.device_type),
        datasets: [
        {
            label: 'Amount',
            data: deviceData.map(row => row.countDevice)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});