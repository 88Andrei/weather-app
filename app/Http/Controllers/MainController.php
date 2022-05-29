<?php

namespace App\Http\Controllers;

use App\Api\Weather;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
      $weatherAPI = new Weather;
      $weather = $weatherAPI->location('12' , '11')->getCurrent();
      //dd($weather);
      return view('home' , [
        'weather' => $weather,
      ]);
    }
}
