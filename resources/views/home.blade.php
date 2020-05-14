@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body style="background-image: url('https://i.ytimg.com/vi/XBPjVzSoepo/maxresdefault.jpg');background-size:cover;">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hello, {{ Auth::user()->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-text">Your registration date {{ Auth::user()->created_at->toDateString()}}</div>
                    <div class="card-text">Your total carbon emissions is: {{ $totalCarbonEmission }}</div>
                    <div class="card-text">Your total distance traveled is: {{ $totalDistance }}</div>
                </div>
            </div>
            
            
            
    <div class="panel-body card-footer">
        <!-- Display Validation Errors -->

        <!-- New Trip Form -->
        <form action="{{ url('trip') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <!-- Add Trip Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default" style="color:white; background-color: rgba(40, 117, 50);">
                        <i class="fa fa-plus"></i> Add New Trip
                    </button>
                </div>
            </div>
        </form>
    </div>
    <h2 style="background:white;opacity: 0.8;">Your Trips</h2>    
    <table class="w3-table w3-striped w3-bordered" style="background:white;opacity: 0.7;">
        <thead>
            <tr>
                <th style="text-align:center"> id</th>
                <th style="text-align:center"> travel time (s)</th>
                <th style="text-align:center"> distance (m)</th>
                <th style="text-align:center"> co2 (g/km)</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            @foreach($trips as $trip)
              <tr>
                  <td style="text-align:center"> {{$i}} </td>
                  <td style="text-align:center"> {{$trip->traveltime}} </td>
                  <td style="text-align:center"> {{$trip->distance}} </td>
                  <td style="text-align:center"> {{$trip->co2emission}} </td>
                   <?php $i++; ?>
              </tr>
              @endforeach
             
       </tbody>
    </table>

        </div>
    </div>
</div>
@endsection
</body>