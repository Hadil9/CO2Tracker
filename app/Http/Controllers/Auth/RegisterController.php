<?php

namespace App\Http\Controllers\Auth;

use DB;
use App\Http\Controllers\Controller;
use App\Rules\ValidAddressRule;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    private function findGeoLocation($addressString)
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
            //$address = $obj->Response->View[0]->Result[0]->Location->Address;
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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $homeAddress = $data['home_street_number']." ". 
            $data['home_street_name'].",".
            $data['home_city'].",". 
            $data['home_province'];
        $homeLocation = $this->findGeoLocation($homeAddress);

        $schoolAddress = $data['school_street_number']." ".
            $data['school_street_name'].",".
            $data['school_city'].",".
            $data['school_province'];
        $schoolLocation = $this->findGeoLocation($schoolAddress);

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'home_street_number' => new ValidAddressRule($homeLocation != null),
            'home_street_name' => new ValidAddressRule($homeLocation != null),
            'home_city' => new ValidAddressRule($homeLocation != null),
            'home_province' => new ValidAddressRule($homeLocation != null),
            'school_street_number' => new ValidAddressRule($schoolLocation != null),
            'school_street_name' => new ValidAddressRule($schoolLocation != null),
            'school_city' => new ValidAddressRule($schoolLocation != null),
            'school_province' => new ValidAddressRule($schoolLocation != null),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $homeAddress = $data['home_street_number']." ".
            $data['home_street_name'].",".
            $data['home_city'].",".
            $data['home_province'];
        $homeLocation = $this->findGeoLocation($homeAddress);

        $schoolAddress = $data['school_street_number']." ".
            $data['school_street_name'].",".
            $data['school_city'].",".
            $data['school_province'];
        $schoolLocation = $this->findGeoLocation($schoolAddress);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'home_latitude'=> $homeLocation->Latitude,
            'home_longitude'=> $homeLocation->Longitude,
            'school_latitude'=> $schoolLocation->Latitude,
            'school_longitude'=> $schoolLocation->Longitude,
            'engine_id' => $data['engine_id'],
            'program_id' => $data['program_id'],
            'fuel_consumption' => $data['fuel_consumption'],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $engines=DB::table('engines')->get();
        $programs=DB::table('programs')->get();
        return view('auth.register', compact('engines'), compact('programs'));
    }
}
