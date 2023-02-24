import Chart from 'chart.js/auto';
new Chart(document.getElementById('daily'),
    {
    type: 'line',
    data: {
        labels: data.map(row => row.hour),
        datasets: [
        {
            label: 'Pages',
            data: data2.map(row => row.pages),
            borderColor: '#22ddb7',
            backgroundColor: '#c2fff3'
        },
        {
            label: 'Sessions',
            data: data.map(row => row.sessions),
            borderColor: '#3fa0f0',
            backgroundColor: '#9ed1fb'
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});