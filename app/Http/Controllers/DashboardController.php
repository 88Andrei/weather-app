<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    protected $weatherAPI;
    protected $cacheTime;

    public function __construct(Weather $weatherAPI)
    {
        $this->weatherAPI = $weatherAPI;
        $this->cacheTime = config('cache.cache_time_for_weather');
    }

    public function home(): \Illuminate\Contracts\View\View
    {
      $user = Auth::user();
      
      $location = $user->locations->first();

      $hourlyWeather = $this->getHourlyWeather($location, $user->id);
        
      $sixHourlyWeather = collect($hourlyWeather)
        ->filter(fn ($forecast) => $forecast->dt >= time())
        ->take(8)
        ->toArray();
      
      return view('dashboard.home', compact('location', 'sixHourlyWeather'));
    }

    private function getHourlyWeather(object $location, $userId): array
    {
      return Cache::remember(
        "hourlyWeather_user_{$userId}", 
        $this->cacheTime, 
        fn() => $this->weatherAPI->location($location)->getHourly()
      );
    }
}
