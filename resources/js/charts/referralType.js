import Chart from 'chart.js/auto';
new Chart(document.getElementById('referralType'),
    {
    type: 'doughnut',
    data: {
        labels: referralTypeData.map(row => row.type),
        datasets: [
        {
            label: 'Amount',
            data: referralTypeData.map(row => row.typeCount)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});