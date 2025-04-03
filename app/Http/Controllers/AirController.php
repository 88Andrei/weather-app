<?php

namespace App\Http\Controllers;

use App\Api\Air;
use App\Http\Requests\AirDataByTwoCitiesRequest;
use App\Http\Requests\AirDataRequest;
use App\Services\AirDataService;
use App\Services\ChartService;
use App\Services\CityService;
use Illuminate\Support\Facades\Cache;

class AirController extends Controller
{
  protected $chartService;
  protected $cityService;
  protected $airDataService;
  protected $defaultLocation;
  protected $defaultStart;
  protected $defaultEnd;
  protected $cacheTime;

  public function __construct(ChartService $chartService, CityService $cityService, AirDataService $airDataService)
  {
    $this->chartService = $chartService;
    $this->cityService = $cityService;
    $this->airDataService = $airDataService;

    $this->defaultLocation = (object)[
      //Dortmund
      'lat' => 51.51661,
      'lng' => 7.45829,
    ];
    $this->defaultStart = strtotime('today');
    $this->defaultEnd = strtotime('tomorrow') - 1;
    $this->cacheTime = config('cache.cache_time_for_air');
  }

  public function index(): \Illuminate\Contracts\View\View
  {
    $airData = $this->getAirData($this->defaultLocation, $this->defaultStart, $this->defaultEnd);
    $chart = $this->getChartData($airData, $this->defaultStart, $this->defaultEnd);

    return view('air' , [
      'airData' => $airData->list,
      'chart' => $chart,
    ]);
  }

  public function airDataByCity(AirDataRequest $request): \Illuminate\Contracts\View\View
  {
    $city = $request->city;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo . ' 23:59:59');

    $cityData = $this->cityService->getCityData($city);

    // If there are several cities, return the view
    if ($cityData->count() > 1) {
      return $this->cityService->handleMultipleCities($cityData, [
        'dateFrom' => $request->dateFrom,
        'dateTo' => $request->dateTo,
        'actionRoute' => 'air_in_city',
        'type' => 'air',
      ]);
    }

    $coord = $this->cityService->getCoordinates($cityData);

    $airData = $this->getAirData($coord, $start, $end);
    $airChart = $this->getChartData($airData, $start, $end);

    return view('air-in-city' , [
      'airDatas' => $airData->list,
      'cityTitle' => $cityData->first()->title,
      'chart' => $airChart,
    ]);
  }

  public function airDataByTwoCities(AirDataByTwoCitiesRequest $request): \Illuminate\Contracts\View\View
  {
    $city1 = $request->city1;
    $city2 = $request->city2;
    $start = strtotime($request->dateFrom);
    $end = strtotime($request->dateTo . ' 23:59:59');

    $cityData1 = $this->cityService->getCityData($city1);
    $cityData2 = $this->cityService->getCityData($city2);

    $coord1 = $this->cityService->getCoordinates($cityData1);
    $coord2 = $this->cityService->getCoordinates($cityData2);

    $cityTitle1 = $cityData1->first()->title;
    $cityTitle2 = $cityData2->first()->title;
    
    $airDataCity1 = $this->getAirData($coord1, $start,  $end);
    $airDataCity2 = $this->getAirData($coord2, $start,  $end);
    $airDatas = array_map(null, $airDataCity1->list, $airDataCity2->list);

    $chart = $this->chartService->getAirChartFor2Cities($airDataCity1->list, $airDataCity2->list);

    return view('air-in-cities' , compact('cityTitle1', 'cityTitle2', 'chart', 'airDatas'));
  }

  private function getAirData($coord, int $start, int $end): object
  {
    $cacheKey = "air_data_lat" . $coord->lat . "_lon" . $coord->lng . '_start_' . $start . '_end_' . $end;

    $airData = Cache::remember(
      $cacheKey, 
      $this->cacheTime,  
      // fn() => Air::history()->location($coord)->start($start)->end($end)->getAll()
      fn() => $this->airDataService->getAirData($coord, $start, $end)
    );

    return $airData;
  }

  private function getChartData(object $airData, int $start, int $end): array
  {
    $cacheKey = "air_location_chart_lat_{$airData->coord->lat}_lon_{$airData->coord->lat}_start{$start}_end{$end}";
    $chart = Cache::remember(
      $cacheKey, 
      $this->cacheTime, 
      fn() => $this->chartService->getAirChartForCity($airData->list)
    );

    return $chart;
  }
}
