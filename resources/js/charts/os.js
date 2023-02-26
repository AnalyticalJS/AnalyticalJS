import Chart from 'chart.js/auto';
var operatingData = getUniqueListBy(sessionData,'os_title');
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
function getUniqueListBy(arr, key) {
    return [...new Map(arr.map(item => [item[key], item])).values()]
}