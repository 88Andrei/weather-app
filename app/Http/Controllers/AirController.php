<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Air;
use App\Api\Location;
use App\Http\Controllers\ChartController;

class AirController extends Controller
{
  public function index()
  {
    $airAPI = new Air;
    $airData = $airAPI->location('Dortmund')->start('1606488670')->end('1606747870')->getAll();
    $chart = new ChartController;
    $chartAir = $chart->getAirChart($airData->list);

    return view('air' , [
      'airDatas' => $airData->list,
      'chart' => $chartAir,
    ]);
  }
  public function getHistAirData(Request $request)
  {
    $city = $request->city;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo);

    $airAPI = new Air;
    $airData = $airAPI->location($city)->start($start)->end($end)->getAll();
    $chart = new ChartController;
    $chartAir = $chart->getAirChart($airData->list);


    return view('air-in-city' , [
      'airDatas' => $airData->list,
      'cityTitle' => $airData->cityTitle,
      'chart' => $chartAir,
    ]);
  }

  public function getHistAirDataOfCities(Request $request)
  {
    $city1 = $request->city1;
    $city2 = $request->city2;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo);

    $airAPI = new Air;
    $airData = $airAPI->location($city1)->start($start)->end($end)->getAll();
    $airData1 = $airAPI->location($city2)->start($start)->end($end)->getAll();

    for ($i=0; $i < count($airData1->list); $i++) {
      $airData->list[$i]->components1 = $airData1->list[$i]->components;
      $airData->list[$i]->main1 = $airData1->list[$i]->main;
    }
    $airDatas = $airData->list;

    $chart = new ChartController;
    $chartAir = $chart->getAirChartFor2Cities($airDatas);

    return view('air-in-cities' , [
      'airDatas' => $airDatas,
      'cityTitle1' => $airData->cityTitle,
      'cityTitle2' => $airData1->cityTitle,
      'chart' => $chartAir,
    ]);
  }
}
