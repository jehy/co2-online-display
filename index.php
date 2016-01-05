  <html>
  <head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
    <script type="text/javascript">
 // Load the Visualization API and the piechart package.
      google.load("visualization", "1", {packages:["gauge",'corechart']});
          </script>

    <script type="text/javascript">

    var limit=60;//default to last hour
var ppm_chart=null;
var gauge_chart=null;
var ram_chart=null;
       $(function() {
 redraw(limit)
  });
function drawGauge(ppm)
{
	ppm=parseInt(ppm);
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['PPM', ppm],
        ]);

        var options = {
          width: 200, height: 200,
          redFrom: 1000, redTo: 2000,
          yellowFrom:700, yellowTo: 1000,
          minorTicks: 10, max: 1200,min:300,majorTicks: ["300","500","700","1000","1200"]
        };
	var d=document.getElementById('gauge_chart');

          if(gauge_chart != null)
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
$.each(jsonData, function(i,item)
{
var d1=item.date.split(' ');
var date=d1[0].split('-');
var time=d1[1].split(':');
var d=new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ppm)
var tooltip=d1[1]+"\nPPM:"+item.ppm;
data.addRows([ [d, parseInt(item.ppm), tooltip, 700, 1000]]);
});

        var options = {
          series: {
            0: { color: '#43459d' },
            1: { color: '#ffc870' },
            2: { color: '#e2431e' },
          },
         'chartArea': {'width': '80%', 'height': '80%'},
          title: 'CO2 concentration',
          curveType: 'function',
          legend: { position: 'bottom' },
          hAxis: {
          format: 'HH:mm',
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm']},
              minutes: {format: ['HH:mm']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['HH:mm:ss']},
              minutes: {format: ['HH:mm', 'mm']}
            }
          }

          },

        };

          if(ppm_chart != null)
              ppm_chart.clearChart();
        ppm_chart = new google.visualization.LineChart(document.getElementById('ppm_chart'));

        ppm_chart.draw(data, options);
      }



      function drawChartRAM(jsonData) {
        
var data = new google.visualization.DataTable();
data.addColumn('date', 'Date');
data.addColumn('number', 'RAM');
data.addColumn({type: 'string', role: 'tooltip'});
$.each(jsonData, function(i,item)
{
var d1=item.date.split(' ');
var date=d1[0].split('-');
var time=d1[1].split(':');
var d=new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ram)
var tooltip=d1[1]+"\nRAM:"+item.ram;
data.addRows([ [d, parseInt(item.ram), tooltip]]);
});

        var options = {
          series: {
            0: { color: '#43459d' },
            1: { color: '#ffc870' },
            2: { color: '#e2431e' },
          },
         'chartArea': {'width': '80%', 'height': '80%'},
          title: 'RAM state',
          curveType: 'function',
          legend: { position: 'bottom' },
          hAxis: {
          format: 'HH:mm',
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm']},
              minutes: {format: ['HH:mm']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['HH:mm:ss']},
              minutes: {format: ['HH:mm', 'mm']}
            }
          }

          },

        };

          if(ram_chart != null)
              ram_chart.clearChart();
        ram_chart = new google.visualization.LineChart(document.getElementById('ram_chart'));

        ram_chart.draw(data, options);
}      
function redraw(new_limit)
{
    if(typeof new_limit === 'undefined')
	new_limit=60;
if(limit!=new_limit)
{
 var loader='<div class="progress">'+
  '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%">'
    +'<span class="sr-only">45% Complete</span>'
  +'</div>'+
'</div>';
$("#curve_chart").html(loader);
}
    limit=new_limit;
      var jsonData = $.ajax({
          url: "json.php?stat=ppm&limit="+limit,
          dataType: "json",
          async: false
          }).responseJSON;

drawGauge(jsonData[0].ppm);
//console.log(jsonData);
    drawChartPPM(jsonData);

      var jsonData2 = $.ajax({
          url: "json.php?stat=ram&limit="+limit,
          dataType: "json",
          async: false
          }).responseJSON;

    drawChartRAM(jsonData2);

setTimeout(function(){redraw(limit)}, 3000);
}


setTimeout(function(){redraw(limit)}, 3000);
// setInterval(function(){ redraw(limit) }, 3000);
    </script>
  </head>
  <body>
    <div align="center" id="gauge_chart"></div>

<div class="btn-group btn-group-justified btn-group-lg" role="group" aria-label="">
<div class="btn-group" role="group">  
<button type="button" class="btn btn-default" onclick="redraw(60)">Last hour</button>
</div>
<div class="btn-group" role="group">
  <button type="button" class="btn btn-default" onclick="redraw(60*24)">Last day</button>
</div>
<div class="btn-group" role="group">
  <button type="button" class="btn btn-default" onclick="redraw(60*24*7)">Last week</button>
</div>
</div>
    <div id="ppm_chart" style="width: 100%; height: 800px"></div>
    <div id="ram_chart" style="width: 100%; height: 800px"></div>
  </body>
</html>
