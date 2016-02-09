<html>
<head>
    <title>CO2 Data</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="stl.css">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="graphs.js"></script>
</head>
<body>
<div align="center" id="gauge_chart"></div>

<div class="btn-group btn-group-justified btn-group-lg" role="group" aria-label="">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" id="btn-hour">Last hour</button>
    </div>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" id="btn-day">Last day</button>
    </div>
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-default" id="btn-week">Last week</button>
    </div>
</div>
<div id="ppm_chart"></div>
<div id="ram_chart"></div>
</body>
</html>
