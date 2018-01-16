
const Highcharts = require('highcharts');
require('highcharts/modules/exporting')(Highcharts);
const moment = require('moment');
const data = require('../../sample/temperature.json');


data.sort((a, b) => {
  const res = moment(a.date).isBefore(b.date);
  return res && -1 || 1;
});
const temperature = data.map(item => [moment(item.date).toDate(), item.temp]);

Highcharts.chart('temp_chart', {
  chart: {
    zoomType: 'x',
  },
  title: {
    text: 'Temperature',
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
      text: 'Temperature',
    },
    min: 0,
    max: 50,
    plotLines: [{
      value: 18,
      color: 'green',
      dashStyle: 'shortdash',
      width: 2,
      label: {
        text: 'minimum',
      },
    }, {
      value: 24,
      color: 'red',
      dashStyle: 'shortdash',
      width: 2,
      label: {
        text: 'maximum',
      },
    }],
  },
  legend: {
    enabled: false,
  },
  plotOptions: {
    area: {
      fillColor: {
        linearGradient: {
          x1: 0,
          y1: 0,
          x2: 0,
          y2: 1,
        },
        stops: [
          [0, Highcharts.getOptions().colors[0]],
          [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')],
        ],
      },
      marker: {
        radius: 2,
      },
      lineWidth: 1,
      states: {
        hover: {
          lineWidth: 1,
        },
      },
    },
  },

  series: [{
    type: 'area',
    name: 'Temperature',
    data: temperature,
  }],
});
