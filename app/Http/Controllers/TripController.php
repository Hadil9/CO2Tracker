<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a list of all of the user's trips.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request  $request)
    {
        $homelatitude =  Auth::user()->home_latitude;
        $homelongitude =  Auth::user()->home_longitude;
        
        $schoollatitude =  Auth::user()->school_latitude;
        $schoollongitude =  Auth::user()->school_longitude;
        
        $modes=DB::table('modes')->get();
        return view('trips', ["homelatitude" => $homelatitude], ["homelongitude" => $homelongitude])->with(compact('modes'))->with(["schoollatitude" => $schoollatitude])->with(["schoollongitude" => $schoollongitude]);
    }

    
    /**
     * Create a new trip instance after choosing the mode
     *
     * @param  $response
     * @return \App\Trip
     */
    protected function create(array $response)
    {
        $startPoint = $response['startPos'];
        $fromlatitude;
        $fromlongitude;
        $tolatitude;
        $tolongitude;
        
        if($startPoint == "home"){
            $fromlatitude =  Auth::user()->home_latitude;
            $fromlongitude =  Auth::user()->home_longitude;
        }
        else if($startPoint == "school"){
            $fromlatitude =  Auth::user()->school_latitude;
            $fromlongitude =  Auth::user()->school_longitude;
        }
        
        $endPoint = $response['endtPos'];
        
        if($endPoint == "home"){
            $tolatitude =  Auth::user()->home_latitude;
            $tolongitude =  Auth::user()->home_longitude;
        }
        else if($endPoint == "school"){
            $tolatitude =  Auth::user()->school_latitude;
            $tolongitude =  Auth::user()->school_longitude;
        }
        else{
            $otherAddress = $response['street_number']." ". 
            $response['street_name'].",".
            $response['city'].",". 
            $response['province'];
            
            $otherLocation = $this->findGeoLocation($otherAddress);
            
            $tolatitude = $otherLocation->Latitude;
            $tolongitude = $otherLocation->Longitude;
        }

        return Trip::create([
            'user_id' => Auth::user()->id,
            'mode_id' => "empty",
            'co2emission' => "empty",//$response['co2emission'],
            'fromlatitude'=> $fromlatitude,
            'fromlongitude'=> $fromlongitude,
            'tolatitude'=> $tolatitude,
            'tolongitude'=> $tolongitude,
            'distance' => $response['engine_id'],
        ]);
        redirect("trip");
    }

}

