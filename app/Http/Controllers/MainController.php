<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use App\Http\Controllers\ChartController;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
      $weatherAPI = new Weather;
      $weather = $weatherAPI->location('51.508', '7.473')->getAll();
      $units = ['metric' , 'imperial'];

      $chartCont = new ChartController;
      $chart = $chartCont->getChartForDailyWeather($weather->daily);

      return view('home' , [
        'current' => $weather->current,
        'forecast' => $weather->daily,
        'units' => $units,
        'chart' => $chart,
        'cityTitels' => null,
      ]);
    }
}
