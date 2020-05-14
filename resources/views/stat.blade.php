@extends('layouts.app')
<!--style="background-image: url('https://i.ytimg.com/vi/XBPjVzSoepo/maxresdefault.jpg');background-size:cover;"-->
<body>
    @section('content')
    <div class="container">
        <h3>CO2 Emission Statistics</h3>
    </div>
    <div class="container">
        {!! $chart->container() !!}
    </div>
    <br><br>
    <div class="container">
        <h4>Your average CO2 Emission is: {{$avg}} (g/km)</h4> 
    </div>
    @endsection
</body>
