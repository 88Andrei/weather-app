<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use App\Http\Controllers\ChartController;

class MainController extends Controller
{
  protected $defaultLocation;
  protected $chart;
  protected $weatherAPI;

  public function __construct(ChartController $chart, Weather $weatherAPI)
  {
    $this->chart = $chart;
    $this->weatherAPI = $weatherAPI;
    $this->defaultLocation = (object)[
      //Dortmund
      'lat' => 51.51661,
      'lng' => 7.45829,
    ];
  }
  
  public function index()
    {
      $weather = $this->weatherAPI->location($this->defaultLocation)->getAll();
      $units = ['metric' , 'imperial'];

      $chart = $this->chart->getChartForDailyWeather($weather->daily);

      return view('home' , [
        'current' => $weather->current,
        'forecast' => $weather->daily,
        'units' => $units,
        'chart' => $chart,
        'cityTitels' => null,
      ]);
    }
}
