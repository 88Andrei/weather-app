<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $weatherAPI;
  
    public function __construct(Weather $weatherAPI)
    {
      $this->weatherAPI = $weatherAPI;
    }

    public function home()
    {
        $userLocations =  Auth::user()->locations;
        $hourlyWeather = $this->weatherAPI->location($userLocations->first())->getHourly();
        $sixHourlyWeather = array_slice($hourlyWeather, 0, 6);
    
        return view('dashboard.home', compact('userLocations', 'sixHourlyWeather'));
    }
}
