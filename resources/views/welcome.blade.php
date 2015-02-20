<!DOCTYPE html>
<html>
<head>

<title>Message Statistics</title>

<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/statistics.css') }}">

<script type="text/javascript">
    var app = {};
    app.data = {!! $currencies->toJson() !!};
</script>
<script type="text/javascript" src="{{ asset('js/jquery-2.1.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

</head>
<body>

<div class="container">
    <h1 class="text-center">Countries Messages Number Statistics</h1>
    
    <div class="js-switcher currency-tab center-block"></div>
    
    <div class="js-chart currency-tab"></div>
</div>

</body>
</html>
