@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

    <!--name-->         <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
    <!--programs-->     <div class="form-group row">
                            <label for="program_id" class="col-md-4 col-form-label text-md-right">{{ __('Program of Study') }}</label>

                            <div class="col-md-6">
                                <select id="program_id" class="form-control @error('program_id') is-invalid @enderror" name="program_id" required autocomplete="program_id">
                                    <option value="-1">{{ __('Please select') }}</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->id }}"
                                        @if($program->id == old('program_id'))
                                        {
                                            selected
                                        }
                                        @endif
                                        >{{ $program->programType }}</option>
                                    @endforeach
                                </select>
                                @error('program_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                      
    <!--h3 Home-->       <h3 class="col-md-5  text-md-right">{{ __('Home Address') }}</h3>
                        
                        <div class="form-group row">
    <!--str number-->       <label for="home_street_number" class="col-md-4 col-form-label text-md-right">{{ __('Street:') }}</label>
                            <div class="col-md-2">
                                <input id="home_street_number" placeholder="number" type="text" class="form-control @error('home_street_number') is-invalid @enderror" name="home_street_number" value="{{ old('home_street_number') }}" required autocomplete="streetnumber">
                                @error('home_street_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
    <!--str name-->         <input id="home_street_name" placeholder="name" type="text" class="form-control @error('home_street_name') is-invalid @enderror" name="home_street_name" value="{{ old('home_street_name') }}" required autocomplete="streetname">
                                @error('home_street_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
    <!--city-->             <label for="home_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-md-3">
                                <input id="home_city" type="text" class="form-control @error('home_city') is-invalid @enderror" name="home_city" value="{{ old('home_city') }}" required autocomplete="city">
                                @error('home_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
    <!--province-->         <label for="home_province" class="col-md-1.5 text-md-left">{{ __('Province') }}</label>
                            <div class="col-md-2">
                                <input id="home_province" type="text" class="form-control @error('home_province') is-invalid @enderror" name="home_province" value="{{ old('home_province') }}" required autocomplete="province">
                                @error('home_province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
    <!--h3 School-->    <h3 class="col-md-5  text-md-right">{{ __('School Address') }}</h3>
                        
                        <div class="form-group row">
    <!--str number-->       <label for="school_street_number" class="col-md-4 col-form-label text-md-right">{{ __('Street:') }}</label>
                            <div class="col-md-2">
                                <input id="school_street_number" placeholder="number" type="text" class="form-control @error('school_street_number') is-invalid @enderror" name="school_street_number" value="{{ old('school_street_number') }}" required autocomplete="school_street_number">
                                @error('school_street_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
    <!--str name-->         <input id="school_street_name" placeholder="name" type="text" class="form-control @error('school_street_name') is-invalid @enderror" name="school_street_name" value="{{ old('school_street_name') }}" required autocomplete="school_street_name">
                                @error('school_street_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
    <!--city-->             <label for="school_city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
                            <div class="col-md-3">
                                <input id="school_city" type="text" class="form-control @error('school_city') is-invalid @enderror" name="school_city" value="{{ old('school_city') }}" required autocomplete="city">
                                @error('school_city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
    <!--province-->         <label for="school_province" class="col-md-1.5 text-md-left">{{ __('Province') }}</label>
                            <div class="col-md-2">
                                <input id="school_province" type="text" class="form-control @error('school_province') is-invalid @enderror" name="school_province" value="{{ old('school_province') }}" required autocomplete="province">
                                @error('school_province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
    <!--email-->            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
    <!--password-->         <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
    <!--pswd_conf-->        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="form-group row">
    <!--engine-->           <label for="engine_id" class="col-md-4 col-form-label text-md-right">{{ __('Engine Type') }}</label>

                            <div class="col-md-6">
                                <select id="engine_id" class="form-control @error('engine_id') is-invalid @enderror" name="engine_id" required autocomplete="engine_id">
                                    <option value="-1">{{ __('Please select') }}</option>
                                    @foreach ($engines as $engine)
                                        <option value="{{ $engine->id }}"
                                        @if($engine->id == old('engine_id'))
                                        {
                                            selected
                                        }
                                        @endif
                                        >{{ $engine->engineType }}</option>
                                    @endforeach
                                </select>
                                @error('engine_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
    <!--fuel-->             <label for="fuel_consumption" class="col-md-4 col-form-label text-md-right">{{ __('Fuel Consumption') }}</label>

                            <div class="col-md-6">
                                <input id="fuel_consumption" type="text" class="form-control @error('fuel_consumption') is-invalid @enderror" name="fuel_consumption" value="{{ old('fuel_consumption') }}" required autocomplete="fuel_consumption">

                                @error('fuel_consumption')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
