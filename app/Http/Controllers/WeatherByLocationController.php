<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ChartController;
use App\Api\Weather;
use App\Api\Location;

class WeatherByLocationController extends Controller
{
  public function getCityDataFromApi(Request $request)
  {
    $city = $request->city;
    $weatherType = $request->weatherType;
    $units = $request->units;

    //walidation


    $locationApi = new Location;
    $cityData = $locationApi->city($city)->getAll();

    if (count($cityData) > 1) {
      return $this->chooseCity($cityData, $weatherType , $units);
    } else {
      return $this->getWeatherByLocation($cityData , $weatherType , $units);
    }
  }

  public function chooseCity($cityDataErr , $weatherType , $units)
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

  public function getWeatherByLocation($cityData , $weatherType , $units)
  {
    $position = $cityData[0]->position;
    $weatherAPI = new Weather;
    $weather = $weatherAPI->location($position->lat , $position->lng)
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
}
