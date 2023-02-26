import Chart from 'chart.js/auto';
new Chart(document.getElementById('browser'),
    {
    type: 'doughnut',
    data: {
        labels: browserData.map(row => row.label),
        datasets: [
        {
            label: 'Amount',
            data: browserData.map(row => row.count)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});