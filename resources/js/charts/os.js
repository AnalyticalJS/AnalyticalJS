import Chart from 'chart.js/auto';
new Chart(document.getElementById('osChart'),
    {
    type: 'doughnut',
    data: {
        labels: operatingData.map(row => row.label),
        datasets: [
        {
            label: 'Amount',
            data: operatingData.map(row => row.count)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});