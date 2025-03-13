<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    protected $weatherAPI;
    protected $cache;
    protected $weatherCacheTime = 24;

    public function __construct(Weather $weatherAPI)
    {
        $this->weatherAPI = $weatherAPI;
    }

    public function home()
    {
      $user = Auth::user();
      
      $location = $user->locations->first();

      $hourlyWeather = Cache::remember(
          'hourlyWeather_user_{$user->id}', 
          now()->addHours($this->weatherCacheTime), 
          fn() => $this->weatherAPI->location($location)->getHourly()
        );
        
      $sixHourlyWeather = collect($hourlyWeather)
        ->filter(fn ($forecast) => $forecast->dt >= time())
        ->take(8)
        ->toArray();
      
      return view('dashboard.home', compact('location', 'sixHourlyWeather'));
    }
}
