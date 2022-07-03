<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
      $weatherAPI = new Weather;
      $weather = $weatherAPI->location('50.27' , '30.31')->getAll();
      $units = ['metric' , 'imperial'];
      return view('home' , [
        'current' => $weather->current,
        'forecast' => $weather->daily,
        'units' => $units,
      ]);
    }

    public function getWeatherByLocation(Request $request)
    {
      $weatherAPI = new Weather;
      $weather = $weatherAPI->location($request->lat , $request->lon)->units($request->units)->getAll();
      //dd($weather);
      $loc = $request;
      return view('location-weather' , [
        'current' => $weather->current,
        'forecast' => $weather->daily,
        'loc' => $loc
      ]);
    }

}
