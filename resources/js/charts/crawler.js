import Chart from 'chart.js/auto';
new Chart(document.getElementById('crawler'),
    {
    type: 'line',
    data: {
        labels: data.map(row => row.hour),
        datasets: [
        {
            label: 'Crawled Amount',
            data: data.map(row => row.bots),
            borderColor: '#6600ff',
            backgroundColor: '#bf9af7'
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});