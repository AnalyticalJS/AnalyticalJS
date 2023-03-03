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
            borderColor: function(context) {
                const chart = context.chart;
                const {ctx, chartArea} = chart;
        
                if (!chartArea) {
                  // This case happens on initial chart load
                  return;
                }
                return getGradient(ctx, chartArea);
              },
            backgroundColor: '#c2fff3'
        }
        ]
    },
    options: {
        aspectRatio: 1,
    }
});

let width, height, gradient;
function getGradient(ctx, chartArea) {
  const chartWidth = chartArea.right - chartArea.left;
  const chartHeight = chartArea.bottom - chartArea.top;
  if (!gradient || width !== chartWidth || height !== chartHeight) {
    // Create the gradient because this is either the first render
    // or the size of the chart has changed
    width = chartWidth;
    height = chartHeight;
    gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
    gradient.addColorStop(0, '#6600ff');
    gradient.addColorStop(0.5, '#3fa0f0');
    gradient.addColorStop(1, '#22ddb7');
  }

  return gradient;
}