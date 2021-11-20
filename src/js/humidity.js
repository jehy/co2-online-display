const Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);
const moment = require('moment');
const data = require('../../sample/humidity.json');


data.sort((a, b) => {
  const res = moment(a.date).isBefore(b.date);
  return res && -1 || 1;
});
const humidity = data.map(item => [moment(item.date).toDate(), item.humidity]);

Highcharts.chart('hum_chart', {
  chart: {
    zoomType: 'x',
  },
  title: {
    text: 'Humidity',
  },
  subtitle: {
    text: document.ontouchstart === undefined ?
      'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in',
  },
  xAxis: {
    type: 'datetime',
  },
  yAxis: {
    title: {
      text: 'Humidity',
    },
    min: 0,
    max: 100,
  },
  legend: {
    enabled: false,
  },
  plotOptions: {
    area: {
      fillColor: {
        stops: [
          [0, Highcharts.getOptions().colors[0]],
          [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')],
        ],
      },
      marker: {
        radius: 2,
      },
      lineWidth: 2,
      states: {
        hover: {
          lineWidth: 2,
        },
      },
    },
  },

  series: [{
    type: 'area',
    name: 'Humidity',
    data: humidity,
    zoneAxis: 'y',
    zones: [{
      value: 20,
      color: '#ff0000'
    }, {
      value: 60,
      color: '#90ed7d'
    }, {
      color: '#ff0000'
    }]
  }],
});
