var limit = 60;//default to last hour
var ppm_chart = null;
var gauge_chart = null;
var ram_chart = null;
var temp_chart = null;
var hum_chart = null;

$(function () {
  redraw();

  $("#btn-hour").click(function () {
    setLimit(60)
  });
  $("#btn-week").click(function () {
    setLimit(60 * 24 * 7)
  });
  $("#btn-day").click(function () {
    setLimit(60 * 24)
  });
});

function drawGauge(ppm) {
  ppm = parseInt(ppm);
  var data = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['PPM', ppm]
  ]);

  var options = {
    width: 200, height: 200,
    redFrom: 1000, redTo: 2000,
    yellowFrom: 700, yellowTo: 1000,
    minorTicks: 10, max: 1200, min: 300, majorTicks: ["300", "500", "700", "1000", "1200"]
  };
  var d = document.getElementById('gauge_chart');

  if (gauge_chart)
    gauge_chart.clearChart();
  gauge_chart = new google.visualization.Gauge(d);
  gauge_chart.draw(data, options);

}

function drawChartPPM(jsonData) {

  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date');
  data.addColumn('number', 'PPM');
  data.addColumn({type: 'string', role: 'tooltip'});
  data.addColumn('number', 'Warning');
  data.addColumn('number', 'Danger');
  $.each(jsonData, function (i, item) {
    var d1 = item.date.split(' ');
    var date = d1[0].split('-');
    var time = d1[1].split(':');
    var d = new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ppm)
    var tooltip = d1[1] + "\nPPM:" + item.ppm;
    data.addRows([[d, parseInt(item.ppm), tooltip, 700, 1000]]);
  });

  var options = {
    series: {
      0: {color: '#43459d'},
      1: {color: '#ffc870'},
      2: {color: '#e2431e'}
    },
    'chartArea': {'width': '80%', 'height': '80%'},
    title: 'CO2 concentration',
    curveType: 'function',
    legend: {position: 'bottom'},
    hAxis: {
      format: 'HH:mm',
      gridlines: {
        count: -1,
        units: {
          days: {format: ['MMM dd']},
          hours: {format: ['HH:mm']},
          minutes: {format: ['HH:mm']}
        }
      },
      minorGridlines: {
        units: {
          hours: {format: ['HH:mm:ss']},
          minutes: {format: ['HH:mm', 'mm']}
        }
      }

    }

  };

  if (ppm_chart)
    ppm_chart.clearChart();
  ppm_chart = new google.visualization.LineChart(document.getElementById('ppm_chart'));

  ppm_chart.draw(data, options);
}


function drawChartRAM(jsonData) {

  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date');
  data.addColumn('number', 'RAM');
  data.addColumn({type: 'string', role: 'tooltip'});
  $.each(jsonData, function (i, item) {
    var d1 = item.date.split(' ');
    var date = d1[0].split('-');
    var time = d1[1].split(':');
    var d = new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ram)
    var tooltip = d1[1] + "\nRAM:" + item.ram;
    data.addRows([[d, parseInt(item.ram), tooltip]]);
  });

  var options = {
    series: {
      0: {color: '#43459d'},
      1: {color: '#ffc870'},
      2: {color: '#e2431e'}
    },
    'chartArea': {'width': '80%', 'height': '80%'},
    title: 'Free RAM, bytes',
    curveType: 'function',
    legend: {position: 'bottom'},
    hAxis: {
      format: 'HH:mm',
      gridlines: {
        count: -1,
        units: {
          days: {format: ['MMM dd']},
          hours: {format: ['HH:mm']},
          minutes: {format: ['HH:mm']}
        }
      },
      minorGridlines: {
        units: {
          hours: {format: ['HH:mm:ss']},
          minutes: {format: ['HH:mm', 'mm']}
        }
      }
    }

  };

  if (ram_chart)
    ram_chart.clearChart();
  ram_chart = new google.visualization.LineChart(document.getElementById('ram_chart'));

  ram_chart.draw(data, options);
}


function drawChartHum(jsonData) {

  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date');
  data.addColumn('number', 'Humidity');
  data.addColumn({type: 'string', role: 'tooltip'});
  $.each(jsonData, function (i, item) {
    var d1 = item.date.split(' ');
    var date = d1[0].split('-');
    var time = d1[1].split(':');
    var d = new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ram)
    var tooltip = d1[1] + "\nHumidity:" + item.humidity;
    data.addRows([[d, parseInt(item.humidity), tooltip]]);
  });

  var options = {
    series: {
      0: {color: '#43459d'},
      1: {color: '#ffc870'},
      2: {color: '#e2431e'}
    },
    'chartArea': {'width': '80%', 'height': '80%'},
    title: 'Humidity, %',
    curveType: 'function',
    legend: {position: 'bottom'},
    hAxis: {
      format: 'HH:mm',
      gridlines: {
        count: -1,
        units: {
          days: {format: ['MMM dd']},
          hours: {format: ['HH:mm']},
          minutes: {format: ['HH:mm']}
        }
      },
      minorGridlines: {
        units: {
          hours: {format: ['HH:mm:ss']},
          minutes: {format: ['HH:mm', 'mm']}
        }
      }
    }

  };

  if (hum_chart)
    hum_chart.clearChart();
  hum_chart = new google.visualization.LineChart(document.getElementById('hum_chart'));

  hum_chart.draw(data, options);
}


function drawChartTemp(jsonData) {

  var data = new google.visualization.DataTable();
  data.addColumn('date', 'Date');
  data.addColumn('number', 'Temperature');
  data.addColumn({type: 'string', role: 'tooltip'});
  $.each(jsonData, function (i, item) {
    var d1 = item.date.split(' ');
    var date = d1[0].split('-');
    var time = d1[1].split(':');
    var d = new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ram)
    var tooltip = d1[1] + "\nTemperature:" + item.temp;
    data.addRows([[d, parseInt(item.temp), tooltip]]);
  });

  var options = {
    series: {
      0: {color: '#43459d'},
      1: {color: '#ffc870'},
      2: {color: '#e2431e'}
    },
    'chartArea': {'width': '80%', 'height': '80%'},
    title: 'Temperature, C',
    curveType: 'function',
    legend: {position: 'bottom'},
    hAxis: {
      format: 'HH:mm',
      gridlines: {
        count: -1,
        units: {
          days: {format: ['MMM dd']},
          hours: {format: ['HH:mm']},
          minutes: {format: ['HH:mm']}
        }
      },
      minorGridlines: {
        units: {
          hours: {format: ['HH:mm:ss']},
          minutes: {format: ['HH:mm', 'mm']}
        }
      }
    }

  };

  if (temp_chart)
    temp_chart.clearChart();
  temp_chart = new google.visualization.LineChart(document.getElementById('temp_chart'));

  temp_chart.draw(data, options);
}

function setLimit(new_limit) {

  if (typeof new_limit === 'undefined')
    new_limit = 60;
  if (limit !== new_limit) {
    var loader = '<div class="progress">' +
      '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">'
      + '<span class="sr-only">45% Complete</span>'
      + '</div>' +
      '</div>';
    $("#ppm_chart").html(loader);
    $("#ram_chart").html(loader);
    $("#temp_chart").html(loader);
    $("#hum_chart").html(loader);
    limit = new_limit;
  }
}

function format_error(txt) {
  return '<div class="alert alert-danger">' + txt + '</div>';
}

var err_nodata = format_error('No data');

function redrawPPM() {
  $.ajax({
    url: "json.php?stat=ppm&limit=" + limit,
    dataType: "json"
  }).done(function (data) {
    if (data.length) {
      drawGauge(data[0].ppm);
      drawChartPPM(data);
    }
    else {
      if (ppm_chart)
        ppm_chart.clearChart();
      if (gauge_chart)
        gauge_chart.clearChart();
      $("#gauge_chart").html(err_nodata);
      $("#ppm_chart").html(err_nodata);
    }
  }).fail(function (error) {
    $("#ppm_chart").html(format_error(error));
    $("#gauge_chart").html(format_error(error));
  });

}

function redrawRAM() {
  $.ajax({
    url: "json.php?stat=ram&limit=" + limit,
    dataType: "json"
  }).done(function (data) {
    if (data.length)
      drawChartRAM(data);
    else {
      if (ram_chart)
        ram_chart.clearChart();
      $("#ram_chart").html(err_nodata);
    }
  }).fail(function (error) {
    $("#ram_chart").html(format_error(error));
  });
}

function redrawTemp() {
  $.ajax({
    url: "json.php?stat=temp&limit=" + limit,
    dataType: "json"
  }).done(function (data) {
    if (data.length)
      drawChartTemp(data);
    else {
      if (temp_chart)
        temp_chart.clearChart();
      $("#temp_chart").html(err_nodata);
    }
  }).fail(function (error) {
    $("#temp_chart").html(format_error(error));
  });
}

function redrawHumidity() {
  $.ajax({
    url: "json.php?stat=humidity&limit=" + limit,
    dataType: "json"
  }).done(function (data) {
    if (data.length)
      drawChartHum(data);
    else {
      if (hum_chart)
        hum_chart.clearChart();
      $("#hum_chart").html(err_nodata);
    }
  }).fail(function (error) {
    $("#hum_chart").html(format_error(error));
  });
}

function redraw() {
  redrawPPM();
  redrawRAM();
  redrawTemp();
  redrawHumidity();

  setTimeout(function () {
    redraw(limit)
  }, 5000);
}