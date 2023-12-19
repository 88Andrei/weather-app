<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Air;
use App\Api\Location;
use App\Http\Controllers\ChartController;

class AirController extends Controller
{
  private $airAPI;
  private $chart;

  public function __construct()
  {
    $this->airAPI = new Air;
    $this->chart = new ChartController;
  }

  public function index()
  {
    $airData = $this->airAPI->location('Dortmund')->start('1606488670')->end('1606747870')->getAll();
    $airChart = $this->chart->getAirChart($airData->list);

    return view('air' , [
      'airDatas' => $airData->list,
      'chart' => $airChart,
    ]);
  }
  public function getHistAirData(Request $request)
  {
    $city = $request->city;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo);

    $airData = $this->airAPI->location($city)->start($start)->end($end)->getAll();
    $airChart = $this->chart->getAirChart($airData->list);

    return view('air-in-city' , [
      'airDatas' => $airData->list,
      'cityTitle' => $airData->cityTitle,
      'chart' => $airChart,
    ]);
  }

  public function getHistAirDataOfCities(Request $request)
  {
    $city1 = $request->city1;
    $city2 = $request->city2;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo);

    $airData = $this->airAPI->location($city1)->start($start)->end($end)->getAll();
    $airData1 = $this->airAPI->location($city2)->start($start)->end($end)->getAll();

    for ($i=0; $i < count($airData1->list); $i++) {
      $airData->list[$i]->components1 = $airData1->list[$i]->components;
      $airData->list[$i]->main1 = $airData1->list[$i]->main;
    }
    $airDatas = $airData->list;

    $airChart = $this->chart->getAirChartFor2Cities($airDatas);

    return view('air-in-cities' , [
      'airDatas' => $airDatas,
      'cityTitle1' => $airData->cityTitle,
      'cityTitle2' => $airData1->cityTitle,
      'chart' => $airChart,
    ]);
  }
}
