import * as ChartGeo from "chartjs-chart-geo";
import { Chart } from 'chart.js';
import { ChoroplethController, BubbleMapController, GeoFeature, ColorScale, ProjectionScale, SizeScale } from 'chartjs-chart-geo';
Chart.register(ChoroplethController, BubbleMapController, GeoFeature, ColorScale, ProjectionScale, SizeScale);

fetch('https://unpkg.com/world-atlas/countries-50m.json').then((r) => r.json()).then((data) => {
      const countries = ChartGeo.topojson.feature(data, data.objects.countries).features;

      countries.forEach(function (value, i) {
        value.properties.value = 0
      });

      mapData.forEach(function (value, i) {
        var result = countries.findIndex(countries => countries.properties.name === value.name);
        if(countries[result] != undefined){
          countries[result].properties.value = countries[result].properties.value+1;
        }
      });

  const chart = new Chart(document.getElementById("world").getContext("2d"), {
    type: 'choropleth',
    data: {
      labels: countries.map((d) => d.properties.name),
      datasets: [{
        label: 'Countries',
        data: countries.map((d) => ({feature: d, value: d.properties.value})),
      }]
    },
    options: {
      showOutline: false,
      showGraticule: false,
      plugins: {
        legend: {
          display: false
        },
      },
      scales: {
        projection: {
          axis: 'x',
          projection: 'equirectangular'
        }
      }
    }
  });
});