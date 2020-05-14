<!DOCTYPE html>
@extends('layouts.app')


<body style="background-image: url('https://i.ytimg.com/vi/XBPjVzSoepo/maxresdefault.jpg');background-size:cover;">
    <script src="{{ asset('js/tripinfo.js') }}"></script>
    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Trip Info') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ url('startTrip') }}" id="form">
                            @csrf
    <!--h3 Start position--><h3 class="col-md-4  text-md-right">{{ __('Trip Summery') }}</h3>
    
                            <div class="form-group row">
                                <label for="startPos" class="col-md-4 col-form-label text-md-right">{{ __('Trip Info') }}</label>
                                <div>
                                    <br>
                                    Start point: {{ $startPos }}<br>
                                    End point: {{ $endPos }}<br><br>
                                    
                                    Distance (meters): {{ $summery->distance }}<br>
                                    Travel Time (seconds): {{ $summery->travelTime }}<br>
                                    CO2 Emission (g/km): {{ $summery->co2Emission }}<br>

                                </div>
                                <input type="hidden" name="startPos" value="{{ $startPos }}"/>
                                <input type="hidden" name="endPos" value="{{ $endPos }}"/>
                                <input type="hidden" name="mode_id" value="{{ $mode_id }}"/>
                                
                                <input type="hidden" name="street_number" value="{{ $street_number }}"/>
                                <input type="hidden" name="street_name" value="{{ $street_name }}"/>
                                <input type="hidden" name="city" value="{{ $city }}"/>
                                <input type="hidden" name="province" value="{{ $province }}"/>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input name="action" value="GO BACK" type="submit" class="btn btn-primary" style="color:white; background-color: rgba(201, 154, 22);">
                                    </input>
                                    <input name="action" value="GO!" type="submit" class="btn btn-primary" value="">
                                    </input>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</body>
