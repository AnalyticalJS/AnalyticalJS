import Chart from 'chart.js/auto';
new Chart(document.getElementById('bots'),
    {
    type: 'doughnut',
    data: {
        labels: botData.map(row => row.bot),
        datasets: [
        {
            label: 'Amount',
            data: botData.map(row => row.count)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});