import Chart from 'chart.js/auto';
var deviceData = getUniqueListBy(sessionData,'device_type');
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
function getUniqueListBy(arr, key) {
    return [...new Map(arr.map(item => [item[key], item])).values()]
}