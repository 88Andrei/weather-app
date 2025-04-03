<?php

namespace App\Services;

use App\Api\Air;
use Illuminate\Support\Collection;


class AirDataService
{
  //maximum period in hours during which data is not averaged to a day
  private $maxHourlyPeriod  = 48;
 
  public function getAirData($coord, $start, $end)
  {
    $airData =  Air::history()
          ->location($coord)
          ->start($start)
          ->end($end
          )->getAll();

    if ($this->needsAveraging($airData->list)) {
      $airData->list = $this->averageDailyData($airData->list);
  }

    return $airData;
  }

  private function needsAveraging($airData)
  {
    return count($airData) > $this->maxHourlyPeriod;
  }

  private function averageDailyData(array $airData): array
  {
    return collect($airData)
        ->chunk(24) // Split data into days (24 hours)
        ->map(fn($hourlyData) => $this->aggregateDailyData($hourlyData))
        ->all();
  }

  private function aggregateDailyData(Collection $hourlyData): object
  {
    $averages = $this->computeAverages($hourlyData);
    
    return (object) [
        'main' => (object) ['aqi' => $averages['aqi']],
        'components' => (object) array_slice($averages, 1, -1),
        'dt' => $averages['dt'],
    ];
  }

  private function computeAverages(Collection $hourlyData): array
  {
    return [
        'aqi' => round($hourlyData->avg('main.aqi')),
        'co' => round($hourlyData->avg('components.co'), 2),
        'no' => round($hourlyData->avg('components.no'), 2),
        'no2' => round($hourlyData->avg('components.no2'), 2),
        'o3' => round($hourlyData->avg('components.o3'), 2),
        'so2' => round($hourlyData->avg('components.so2'), 2),
        'pm2_5' => round($hourlyData->avg('components.pm2_5'), 2),
        'pm10' => round($hourlyData->avg('components.pm10'), 2),
        'nh3' => round($hourlyData->avg('components.nh3'), 2),
        'dt' => $hourlyData->avg('dt'),
    ];
  }
}
