<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TripResource;
use App\Http\Resources\TripsResource;
use App\Http\Requests\TripInfoRequest;
use App\User;
use App\Trip;
use App\Engine;
use App\Mode;
use DB;

class ApiController extends Controller
{
    /**
     * Provides all trips.
     *
     * @return \Illuminate\Http\Response
     */
    public function alltrips()
    {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	{
            return response()->json(['error' => 'invalid_token'], 401);
    	}

        TripsResource::withoutWrapping();
        $trips = Trip::where('user_id', '=', $user->id)->orderBy('created_at', 'desc')->get();
        return response()->json(new TripsResource($trips), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addtrip(Request $request)
    {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	{
            return response()->json(['error' => 'invalid_token'], 401);
    	}
    	
    	if (is_null($request->fromlatitude) || is_null($request->fromlongitude) || is_null($request->tolatitude) || is_null($request->tolongitude) || is_null($request->mode ))
    	{
            return response()->json(['error' => 'invalid or missing parameter'], 400);
    	}
    	
    	$modeTemp = $request->mode;
    	
    	
    	if ($modeTemp == "car"){
    	    $mode = "car";
    	}
    	if($modeTemp == "carpool"){
            $mode = "carpool";
        }
        else if ($modeTemp == "pedestrian" || $modeTemp == "walk"){
            $mode = "walk";
        }
        else if ($modeTemp == "publicTransport"){
            $mode = "public_transport";
        }
        else if ($modeTemp == "bicycle" || $modeTemp == "bike"){
            $mode = "bike";
        }
        
        $mode = Mode::where('modeType', '=', $mode)->first();
        
        $tripSummery = $this->getTripSummery($user, $request->fromlatitude, $request->fromlongitude, $request->tolatitude, $request->tolongitude, $request->mode);
        
        $trip = new Trip;
        $trip->user_id = $user->id;
        $trip->mode_id = $mode->id;
        $trip->fromlatitude = $request->fromlatitude;
        $trip->fromlongitude = $request->fromlongitude;
        $trip->tolatitude = $request->tolatitude;
        $trip->tolongitude = $request->tolongitude;
        $trip->distance = $tripSummery->distance;
        $trip->traveltime = $tripSummery->travelTime;
        $trip->co2emission = round($tripSummery->co2Emission,4);
        $trip ->save();
        
        $result = [ 'id' => $trip->id,
                    'from' => array
                        ( 
                        'latitude' => $trip->fromlatitude,
                        'longitude' => $trip->fromlatitude
                        ),
                    'to' => array
                        ( 
                        'latitude' => $trip->fromlatitude,
                        'longitude' => $trip->fromlatitude
                        ),
                    'mode' => $mode->id,
                    'distance' => $trip->distance,
                    'traveltime' => $trip->traveltime,
                    'co2emissions' => $trip->co2emission,
                    'created_at' => $trip->created_at
                    ]; 
        return response()->json($result, 200);
    }


    /**
     * Provides trip info.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function tripinfo(TripInfoRequest $request)
    {
        $user = auth('api')->user(); //returns null if not valid
    	if (!$user)
    	{
            return response()->json(['error' => 'invalid_token'], 401);
    	}

        $consumption = $user->fuel_consumption; 
        $engineObj = Engine::where('id', '=', $user->engine_id)->get();
        $engine = $engineObj[0]->engineType;

        $tripInfoParams = request(['fromlatitude', 'fromlongitude', 'tolatitude', 'tolongitude', 'mode']);

        $app_id = config("here.app_id"); 
        $app_code = config("here.app_code");
        
        //in HERE: pedestrian, bycicle, publicTransport, carHOV (high-occupancy vehicle), car 
        //in HERE: diesel, gasoline, electric
        
        $url = "https://route.api.here.com/routing/7.2/calculateroute.json?app_id=${app_id}&app_code=${app_code}";
        $url .= "&waypoint0=" . urlencode($tripInfoParams['fromlatitude'].",".$tripInfoParams['fromlongitude']);
        $url .= "&waypoint1=" . urlencode($tripInfoParams['tolatitude'].",".$tripInfoParams['tolongitude']);
        
        
        if($tripInfoParams['mode'] == 'car' || $tripInfoParams['mode'] == 'carpool')
        {
            $url .= "&mode=" . urlencode("fastest;car;traffic:disabled");
            $url .= "&vehicletype=" . urlencode($engine.",".$consumption);
        }
        if(strpos($tripInfoParams['mode'], "public") !== false)
        {
            $url .= "&mode=" . urlencode("fastest;publicTransport;traffic:enabled");
        }
        if($tripInfoParams['mode'] == 'bike' || $tripInfoParams['mode'] == 'bicycle')
        {
            $url .= "&mode=" . urlencode("fastest;bicycle;traffic:disabled");
            $co2emission = 0;
        }
        if($tripInfoParams['mode'] == 'walk')
        {
            $url .= "&mode=" . urlencode("fastest;pedestrian;traffic:disabled");
            $co2emission = 0;
        }
        
        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);
        if ($res->getStatusCode() != 200) {
            return response()->json(['error' => 'invalid or missing parameter'], 400);
        }
        $j = $res->getBody();
        $obj = json_decode($j);
        $resp = $obj->response;
        $route = $resp->route[0];
        $summary = $route->summary;
        
        //var_dump($summary);
        if($tripInfoParams['mode'] == 'carpool')
        {
            $co2emission = ($summary->co2Emission)/2;
        }
        if($tripInfoParams['mode'] == 'car')
        {
            $co2emission = $summary->co2Emission;
        }
        if(strpos($tripInfoParams['mode'], "public") !== false)
        {
            $co2emission = $summary->distance * 0.0462/1000;     //46.2 g/km (from the project)
        }
        
        $result = [ 'distance' => $summary->distance,
                    'traveltime' => $summary->travelTime,
                    'co2emissions' => $co2emission]; 
        return response()->json($result, 200);
    }
    
    
    /**
    *
    * @param $fromlatitude
    * @param $fromlongitude
    * @param $tolatitude
    * @param $tolongitude
    * 
    * @return
    */
    private function getTripSummery($user,$fromlatitude, $fromlongitude, $tolatitude, $tolongitude, $mode)
    {
        $app_id = config("here.app_id"); 
        $app_code = config("here.app_code");
        $engine = DB::table('engines')->where('id', $user->engine_id)->first()->engineType;
        $consumption = $user->fuel_consumption;
        $url = "https://route.api.here.com/routing/7.2/calculateroute.json?app_id=${app_id}&app_code=${app_code}&waypoint0=geo!${fromlatitude},${fromlongitude}&waypoint1=geo!${tolatitude},${tolongitude}&mode=fastest;${mode};traffic:enabled&vehicletype=${engine},${consumption}";
        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);
        if ($res->getStatusCode() == 200) {
            $j = $res->getBody();
            $obj = json_decode($j);
            $response = $obj->response;
            if(!$response)
            {
                return null;
            }
            $view0 = $response->route != null && sizeof($response->route) != 0 ? $response->route[0] : null;
            if(!$view0)
                return null;
                
            $location = $obj->response->route[0]->summary;
            return $location;
        }
        return null;
    }
    
}
