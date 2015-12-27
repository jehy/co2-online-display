  <html>
  <head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  
    <script type="text/javascript">
 // Load the Visualization API and the piechart package.
      google.load("visualization", "1", {packages:["gauge",'corechart']});
          </script>

    <script type="text/javascript">
      google.setOnLoadCallback(drawChart);
    var limit=60;//default to last hour
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
          minorTicks: 100, max: 1200,min:300
        };
	var d=document.getElementById('gauge_chart');
        var chart = new google.visualization.Gauge(d);
        chart.draw(data, options);

}

      function drawChart() {
        
      var jsonData = $.ajax({
          url: "json.php?limit="+limit,
          dataType: "json",
          async: false
          }).responseJSON;

drawGauge(jsonData[0].ppm);
//console.log(jsonData);
var data = new google.visualization.DataTable();
data.addColumn('date', 'Date');
data.addColumn('number', 'PPM');
data.addColumn({type: 'string', role: 'tooltip'});
$.each(jsonData, function(i,item)
{
var d1=item.date.split(' ');
var date=d1[0].split('-');
var time=d1[1].split(':');
var d=new Date(date[0], date[1], date[2], time[0], time[1]);
//console.log(d,item.ppm)
var tooltip=d1[1]+"\nPPM:"+item.ppm;
data.addRows([ [d, parseInt(item.ppm),tooltip]]);
});

        var options = {
          title: 'CO2 concentration',
          curveType: 'function',
          legend: { position: 'bottom' },
          hAxis: {
          gridlines: {
            count: -1,
            units: {
              days: {format: ['MMM dd']},
              hours: {format: ['HH:mm', 'ha']},
            }
          },
          minorGridlines: {
            units: {
              hours: {format: ['hh:mm:ss a', 'ha']},
              minutes: {format: ['HH:mm a Z', 'mm']}
            }
          }

          },

        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
function redraw(new_limit)
{
    limit=new_limit;
    drawChart();
}
 setInterval(function(){ drawChart() }, 3000);
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
    <div id="curve_chart" style="width: 100%; height: 800px"></div>
  </body>
</html>
