<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ChartController;
use App\Api\Weather;
use App\Api\Location;

class WeatherByLocationController extends Controller
{
  protected $weatherApi;

  public function __construct(Weather $weatherApi)
  {
    return $this->weatherApi = $weatherApi;
  }

  public function getWeatherByLocation(Request $request)
  {
    //walidation
    $city = $request->city;
    $weatherType = $request->weatherType;
    $units = $request->units; 

    $cityData = $this->getCityDataFromApi($city);

    //Check for cities with the same name
    if (count($cityData) > 1) {
      //If there are several cities with a given name
      return $this->chooseCity($cityData, $weatherType , $units);
      exit(0);
    } 

    $locationObj = $cityData[0]->position;

    $weather = $this->weatherApi->location($locationObj)
                            ->units($units)->getAll();
    $chart = new ChartController;
    $cityTitle = $cityData[0]->title;

    if ($weatherType == 'daily') {
       return view('location-weather' , [
         'forecast' => $weather->daily,
         'chart' => $chart->getChartForDailyWeather($weather->daily),
         'cityTitle' => $cityTitle,
       ]);
    }else {
      return view('hourly' , [
        'hourly' => $weather->hourly,
        'chart' => $chart->getChartForHourlyWeather($weather->hourly),
        'cityTitle' => $cityTitle,
      ]);
    }
  }

  public function getCityDataFromApi($city)
  {
    $locationApi = new Location;
    $cityData = $locationApi->city($city)->getAll();
    
    return $cityData;
  }

  public function chooseCity($cityDataErr, $weatherType, $units)
  {
    foreach ($cityDataErr as $city) {
      $cityTitels[] = $city->title;
    }

    return view('choose-city' , [
      'cityTitels' => $cityTitels,
      'weatherType' => $weatherType,
      'units' => $units,
    ]);
  }
}
