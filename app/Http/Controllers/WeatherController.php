<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Weather;
use App\Services\ChartService;
use App\Services\CityService;
use Illuminate\Support\Facades\Cache;


class WeatherController extends Controller
{
  protected $weatherApi;
  protected $chartService;
  protected $cityService;

  protected $defaultLocation;
  protected $cacheTime;

  public function __construct(Weather $weatherApi, CityService $cityService, ChartService $chartService)
  {
    $this->weatherApi = $weatherApi;
    $this->cityService = $cityService;
    $this->chartService = $chartService;

    $this->defaultLocation = (object)[
      //Dortmund
      'lat' => 51.51661,
      'lng' => 7.45829,
    ];
    $this->cacheTime = config('cache.cache_time_for_weather');
  }

  public function index(): \Illuminate\Contracts\View\View
  {
    $weather = $this->getWeatherData($this->defaultLocation);
    $chart = $this->getChartData($weather, 'daily');

    return view('weather' , [
      'current' => $weather->current,
      'forecast' => $weather->daily,
      'chart' => $chart,
    ]);
  }

  public function getWeatherByLocation(Request $request): \Illuminate\Contracts\View\View
  {
    $validated = $request->validate([
      'city' => 'required|string',
      'weatherType' => 'required|in:daily,hourly',
    ]);

    $cityData = $this->cityService->getCityData($validated['city']);

    // If there are several cities, we return the view 'choose-city'
    if ($cityData->count() > 1) {
        return $this->cityService->handleMultipleCities($cityData, [
          'weatherType' => $validated['weatherType'],
          'actionRoute' => 'weather_in_city',
          'type' => 'weather',
      ]);
    }

    $coord = $this->cityService->getCoordinates($cityData);
    $weather = $this->getWeatherData($coord);
    $cityTitle = $cityData->first()->title;

    $weatherView = $this->getWeatherView($weather, $validated['weatherType'], $cityTitle);

    return $weatherView;
  }

  private function getWeatherData(object $coord): object
  { 
    $cacheKey = "location_weather_lat" . $coord->lat . "_lon" . $coord->lng;

    //get weather data from cache or API
    $weather = Cache::remember(
      $cacheKey, 
      $this->cacheTime, 
      fn() => $this->weatherApi->location($coord)->getAll() 
    );

    return $weather;
  }

  private function getChartData(object $weather, string $weatherType): array
  {
    $cacheKey = "location_weather_{$weatherType}_chart_{$weather->lon}{$weather->lat}";

    //get chart data from cache or generate new
    $chart = Cache::remember(
      $cacheKey, 
      $this->cacheTime, 
      function () use ($weather, $weatherType) {
        return $weatherType === 'daily'
            ? $this->chartService->getChartForDailyWeather($weather->daily)
            : $this->chartService->getChartForHourlyWeather($weather->hourly);
      });

    return $chart;
  }

  private function getWeatherView(object $weather, string $weatherType, string $cityTitle)
  {
    $viewName = "location-weather_{$weatherType}";

    return view($viewName, [
        'forecast' => $weather->$weatherType,
        'chart' => $this->getChartData($weather, $weatherType),
        'cityTitle' => $cityTitle,
    ]);
  }
}
