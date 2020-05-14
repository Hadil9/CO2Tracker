<!DOCTYPE html>
@extends('layouts.app')

<body style="background-image: url('https://i.ytimg.com/vi/XBPjVzSoepo/maxresdefault.jpg');background-size:cover;">
    <script src="{{ asset('js/address.js') }}"></script>
    <script src="{{ asset('js/tripinfo.js') }}"></script>
    @section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Start New Trip') }}</div>
    
                    <div class="card-body">
                        <form method="POST" action="{{ url('tripInfo') }}" id="form">
                            @csrf
    <!--h3 Start position--><h3 class="col-md-4  text-md-right">{{ __('Start Point') }}</h3>
    
                            <div class="form-group row">
                                <label for="startPos" class="col-md-4 col-form-label text-md-right">{{ __('Choose Start Point') }}</label>
                                <div class="col-md-6">
                                    <select id="startPos" class="form-control @error('startPos') is-invalid @enderror" name="startPos" value="{{ old('startPos') }}" required autocomplete="startPos">
                                        <option value="-1">{{ __('Please select') }}</option>
                                        <option value="home">home</option>
                                        <option value="school">school</option>
                                    </select>
                                    @error('startPos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
    
    
    <!--h3 end position-->  <h3 class="col-md-4  text-md-right">{{ __('Destination') }}</h3>
    
                            <div class="form-group row">
                                <label for="endPos" class="col-md-4 col-form-label text-md-right">{{ __('Choose End Point') }}</label>
                                <div class="col-md-6">
                                    <select id="endPos" class="form-control @error('endPos') is-invalid @enderror" name="endPos" value="{{ old('endPos') }}" required autocomplete="endPos">
                                        <option value="-1">{{ __('Please select') }}</option>
                                        <option value="home">home</option>
                                        <option value="school">school</option>
                                        <option value="other">other</option>
                                    </select>
                                    @error('engine_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
          <!--<h3 class="col-md-5  text-md-right">{{ __('Address') }}</h3>-->
                            
                            <div id="otherAddress" class="form-group row" style="display:none">
        <!--str number-->       <label for="street_number" class="col-md-4 col-form-label text-md-right">{{ __('Street:') }}</label>
                                <div class="col-md-2">
                                    <input id="street_number" placeholder="number" type="text" class="form-control @error('street_number') is-invalid @enderror" name="street_number" value="{{ old('street_number') }}"  autocomplete="streetnumber">
                                    @error('home_street_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4">
        <!--str name-->         <input id="street_name" placeholder="name" type="text" class="form-control @error('street_name') is-invalid @enderror" name="street_name" value="{{ old('street_name') }}" autocomplete="streetname">
                                </div>
                            
                            
        <!--city-->             <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                                <div class="col-md-3">
                                    <input id="city" type="text" class="form-control @error('home_city') is-invalid @enderror" name="city" value="{{ old('city') }}"  autocomplete="city">
                                    @error('home_city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
        <!--province-->         <label for="province" class="col-md-1.5 text-md-left">{{ __('Province') }}</label>
                                <div class="col-md-2">
                                    <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}"  autocomplete="province">
                                    @error('home_province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
        <!--modes-->     <div class="form-group row">
                                <label for="mode_id" class="col-md-4 col-form-label text-md-right">{{ __('Mode of transportation') }}</label>
                                <div class="col-md-6">
                                    <select id="mode_id" class="form-control @error('mode_id') is-invalid @enderror" name="mode_id" value="{{ old('mode_id') }}" required autocomplete="mode_id">
                                        <option value="-1">{{ __('Please select') }}</option>
                                        @foreach ($modes as $mode)
                                            <option value="{{ $mode->id }}" data-action="{{ url('home') }}">{{ $mode->modeType }}</option>
                                        @endforeach
                                    </select>
                                    @error('mode_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" class="btn btn-primary" value ="Show Trip Info!">
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
