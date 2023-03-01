import Chart from 'chart.js/auto';
new Chart(document.getElementById('osChart'),
    {
    type: 'doughnut',
    data: {
        labels: operatingData.map(row => row.os_title),
        datasets: [
        {
            label: 'Amount',
            data: operatingData.map(row => row.countOs)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});