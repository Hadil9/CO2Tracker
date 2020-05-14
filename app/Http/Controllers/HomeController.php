<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Charts\COChart;
//team06password.
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request  $request)
    {
        $trips=DB::table('trips')->where('user_id', auth()->user()->id)->get();
        $totalDistance = DB::table('trips')->where('user_id', auth()->user()->id)->sum("distance") . " meter";
        $totalCarbonEmission = DB::table('trips')->where('user_id', auth()->user()->id)->sum("co2emission") . " g/km ";
        
        return view('home', ["totalDistance" => $totalDistance], ["totalCarbonEmission" => $totalCarbonEmission])->with( compact('trips'));
        
    }
    
    /**
     * Show the application stats.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showStat(Request $request)
    {
        $trips=DB::table('trips')->where('user_id', auth()->user()->id)->get("created_at");
       
        $rows = json_decode($trips, true);
        $dates = array();
        foreach ($rows as $key => $value) {
            $dates[] = substr($value["created_at"],0,10);
        }
        
        $tripsCO2=DB::table('trips')->where('user_id', auth()->user()->id)->get("co2emission");
        $co2rows = json_decode($tripsCO2, true);
        $emissions = array();
        foreach ($co2rows as $key => $value) {
             $emissions[] = $value["co2emission"];
        }
        
        $tripsMode=DB::table('trips')->where('user_id', auth()->user()->id)->get("mode_id");
        $modeRows = json_decode($tripsMode, true);
        $modearray = array();
        $modes = array();
        foreach ($modeRows as $key => $value) {
            $modes[] = DB::table('modes')->where('id',$value)->first()->modeType;
        }
        
        $chart = new COChart();
        $chart->labels($dates);
        $chart->dataset('Carbon Emission (g/km)', 'bar', $emissions)->color("rgb(255, 99, 102)")->backgroundcolor("rgb(255, 99, 102)");
        
        $avg = DB::table('trips')->where('user_id', auth()->user()->id)->avg("co2emission");
        
        return view('stat', ["avg"=> round($avg,4)])->with(compact('chart'));
    }
    
    
    /**
     * Create a new trip.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $response)
    {
        if ($_POST['action'] == 'GO!') {
            $startPoint = $response['startPos'];
            $fromlatitude = 0;
            $fromlongitude = 0;
            $tolatitude = 0;
            $tolongitude = 0;

            if($startPoint == "home"){
                $fromlatitude =  auth()->user()->home_latitude;
                $fromlongitude = auth()->user()->home_longitude;
            }
            else if($startPoint == "school"){
                $fromlatitude =  auth()->user()->school_latitude;
                $fromlongitude =  auth()->user()->school_longitude;
            }
            
            $endPoint = $response['endPos'];

            if($endPoint == "home"){
                $tolatitude =  auth()->user()->home_latitude;
                $tolongitude =  auth()->user()->home_longitude;
            }
            else if($endPoint == "school"){
                $tolatitude =  auth()->user()->school_latitude;
                $tolongitude =  auth()->user()->school_longitude;
            }
            else{
                $otherAddress = $response['street_number']." ". 
                $response['street_name'].",".
                $response['city'].",". 
                $response['province'];
                //var_dump($otherAddress);
                $otherLocation = $this->findGeoLocation($otherAddress);
                //var_dump($otherLocation);
                $tolatitude = $otherLocation->Latitude;
                $tolongitude = $otherLocation->Longitude;
            }
            $modeTemp = DB::table('modes')->where('id',$response["mode_id"])->first()->modeType;
            $mode = $modeTemp;
            
            if($modeTemp == "carpool"){
                $mode = "car";
            }
            else if ($modeTemp == "walk"){
                $mode = "pedestrian";
            }
            else if ($modeTemp == "public_transport"){
                $mode = "publicTransport";
            }
            else if ($modeTemp == "bike"){
                $mode = "bicycle";
            }
            
            $tripSummery = $this->getTripSummery($fromlatitude, $fromlongitude, $tolatitude, $tolongitude, $mode);
            $co2Emission = $tripSummery->co2Emission;
            
            if($modeTemp == "carpool"){
                 $co2Emission = $co2Emission/2;
            }
            else if ($modeTemp == "walk"){
                $co2Emission = 0;
            }
            else if ($modeTemp == "public_transport"){
                $co2Emission = (42/($tripSummery->distance/1000));
            }
            else if ($modeTemp == "bike"){
                $co2Emission = 0;
            }

            $response->user()->trips()->create([
                'mode_id' => $response["mode_id"],
                'co2emission' => round($co2Emission,4),
                'fromlatitude' => $fromlatitude,
                'fromlongitude' => $fromlongitude,
                'tolatitude' => $tolatitude,
                'tolongitude' => $tolongitude,
                'distance' => $tripSummery->distance,
                'traveltime' => $tripSummery->travelTime,
            ]);
        }
        return redirect('/home');
        
    }
    
    /**
     * Create a new trip.
     *
     * @param  Request  $request
     * @return Response
     */
    public function tripInfo(Request $response)
    {
        $startPoint = $response['startPos'];
        $fromlatitude = 0;
        $fromlongitude = 0;
        $tolatitude = 0;
        $tolongitude = 0;
        if($startPoint == "home"){
            $fromlatitude =  auth()->user()->home_latitude;
            $fromlongitude = auth()->user()->home_longitude;
        }
        else if($startPoint == "school"){
            $fromlatitude =  auth()->user()->school_latitude;
            $fromlongitude =  auth()->user()->school_longitude;
        }
        
        $endPoint = $response['endPos'];
        //var_dump( $endPoint);
        if($endPoint == "home"){
            $tolatitude =  auth()->user()->home_latitude;
            $tolongitude =  auth()->user()->home_longitude;
        }
        else if($endPoint == "school"){
            $tolatitude =  auth()->user()->school_latitude;
            $tolongitude =  auth()->user()->school_longitude;
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
        
        $modeTemp = DB::table('modes')->where('id',$response["mode_id"])->first()->modeType;
        $mode = $modeTemp;
        if($modeTemp == "carpool"){
            $mode = "car";
        }
        else if ($modeTemp == "walk"){
            $mode = "pedestrian";
        }
        else if ($modeTemp == "public_transport"){
            $mode = "publicTransport";
        }
        else if ($modeTemp == "bike"){
            $mode = "bicycle";
        }

        $tripSummery = $this->getTripSummery($fromlatitude, $fromlongitude, $tolatitude, $tolongitude, $mode);
        
        $co2Emission = $tripSummery->co2Emission;
            
        if($modeTemp == "carpool"){
             $co2Emission = $co2Emission/2;
        }
        else if ($modeTemp == "walk"){
            $co2Emission = 0;
        }
        else if ($modeTemp == "public_transport"){
            $co2Emission = (42/($tripSummery->distance/1000));
        }
        else if ($modeTemp == "bike"){
            $co2Emission = 0;
        }
        $tripSummery->co2Emission=$co2Emission;
        
       return view('tripinfo', ["startPos" => $startPoint], ["endPos" => $endPoint])->with(["summery" => $tripSummery])->with(["mode_id" => $response["mode_id"]])
       ->with(["street_number" => $response['street_number']])->with(["street_name" => $response['street_name']])->with(["city" => $response['city']])->with(["province" => $response['province']]);
    }
    
    
    /**
    *
    * @param addressString 
    * @return
    */
    public function findGeoLocation($addressString)
    {
        $app_id = config("here.app_id"); 
        $app_code = config("here.app_code");
        $addressEncoded = urlencode($addressString);
        $url = "https://geocoder.api.here.com/6.2/geocode.json?searchtext=${addressEncoded}&app_id=${app_id}&app_code=${app_code}&gen=8";
        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);
        if ($res->getStatusCode() == 200) {
            $j = $res->getBody();
            $obj = json_decode($j);
            $response = $obj->Response;
            if(!$response)
            {
                return null;
            }
            $view0 = $response->View != null && sizeof($response->View) != 0 ? $response->View[0] : null;
            if(!$view0)
                return null;
                
            $location = $obj->Response->View[0]->Result[0]->Location->NavigationPosition[0];
            return $location;
        }
        return null;
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
    private function getTripSummery($fromlatitude, $fromlongitude, $tolatitude, $tolongitude, $mode)
    {
        $app_id = config("here.app_id"); 
        $app_code = config("here.app_code");
        $engine = DB::table('engines')->where('id', auth()->user()->engine_id)->first()->engineType;
        $consumption = auth()->user()->fuel_consumption;
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
