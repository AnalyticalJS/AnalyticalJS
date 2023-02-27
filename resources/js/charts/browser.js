import Chart from 'chart.js/auto';
new Chart(document.getElementById('browser'),
    {
    type: 'doughnut',
    data: {
        labels: browserData.map(row => row.browser),
        datasets: [
        {
            label: 'Amount',
            data: browserData.map(row => row.countBrowser)
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});

function getUniqueListBy(arr, key) {
    return [...new Map(arr.map(item => [item[key], item])).values()]
}