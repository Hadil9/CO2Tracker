<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Carbon Emission Tracker</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
                background-size:cover;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body style="background-image: url('https://s3-prod.autonews.com/MOBILITY01_308129997_AR_1_BQCLVNQBOGUH.jpg');">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links" style="background-color: rgba(255,255,255)">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content" style="background-color: rgba(255,255,255)">
                <div class="title m-b-md">
                    Carbon Emission Tracker
                </div>
                <div style="background-color: rgba(255,255,255);font-size: 28px;padding: 25px; ">
                    Did you know that Greenhouse gas (GHG) emissions from transportation account for 
                    about 29 percent of total North America greenhouse gas emissions, making it the largest 
                    contributor of GHG emissions. Between 1990 and 2017, GHG emissions in the 
                    transportation sector increased more in absolute terms than any other sector.
                    <br>
                    <a style="font-size:20px;" href="https://www.epa.gov/transportation-air-pollution-and-climate-change/carbon-pollution-transportation">(Enviromental Protection Agency)</a>
                </div>
                
                <h2>
                    Register now and help reduce GHG emitted by transportation!
                </h2>
            </div>

        </div>
    </body>
</html>
