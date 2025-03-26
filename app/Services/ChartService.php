<?php

namespace App\Services;

class ChartService
{
  public function getChartForDailyWeather(array $dailyWeather): array
  {
    $dailyWeatherColl = collect($dailyWeather);
    $data = [
      'x' => $dailyWeatherColl->map(fn($day) => date('d.m.y', $day->dt))->toArray(),
      'Ys' => [
        [
          'label' => 'Day temperature',
          'type' => 'line',
          'data' => $dailyWeatherColl->pluck('temp.day')->toArray(),
        ],
        [
          'label' => 'Night temperature',
          'type' => 'line',
          'data' => $dailyWeatherColl->pluck('temp.night')->toArray(),
        ],
        [
          'label' => 'Humidity',
          'data' => $dailyWeatherColl->pluck('humidity')->toArray(),
        ],
      ],
    ];

    return $data;
  }

  public function getChartForHourlyWeather(array $hourlyWeather): array
  {
    $hourlyWeatherColl = collect($hourlyWeather);

    $data = [
      'x' => $hourlyWeatherColl->map(fn($hour) => date('H:i d.M', $hour->dt))->toArray(),
      'Ys' => [
        [
          'label' => 'Temperature',
          'type' => 'line',
          'data' => $hourlyWeatherColl->pluck('temp')->toArray(),
        ],
        [
          'label' => 'Feels temperature',
          'type' => 'line', 
          'data' => $hourlyWeatherColl->pluck('feels_like')->toArray(),
        ],
      ],
    ];

    return $data;
  }

  public function getAirChartFor2Cities(array $airDataCity1, array $airDataCity2): array
  {
    $dataCity1 = collect($airDataCity1);
    $dataCity2 = collect($airDataCity2);

    $data = [
      'x' => $dataCity1->map(fn($hour) => date('H:i d.M', $hour->dt))->toArray(),
      'Ys' => [
        [
          'label' => 'Air Quality Index #1',
          'data' => $dataCity1->pluck('main.aqi')->toArray(),
        ],
        [
          'label' => 'Air Quality Index #2',
          'data' => $dataCity2->pluck('main.aqi')->toArray(),
        ],
      ],
    ];
    
    return $data;
  }

  public function getAirChartForCity(array $airData): array
  {
    $airDataColl = collect($airData);

    $data = [
      'x' => $airDataColl->map(fn($hour) => date('H:i d.M', $hour->dt))->toArray(),
      'Ys' => [
        [
          'label' => 'Air Quality Index',
          'data' => $airDataColl->pluck('main.aqi')->toArray(),
          'backgroundColor' => $airDataColl->map(fn($hour) => $this->getColorAqi($hour->main->aqi))->toArray(),
        ],
      ],
    ];

    return $data;
  }

  public function getColorAqi(int $aqi)
  {
    switch ($aqi) {
    case 1:
        return 'green';
        break;
    case 2:
        return '#70d330';
        break;
    case 3:
        return 'yellow';
        break;
    case 4:
        return 'orange';
        break;
    case 5:
        return 'red';
        break;
      }
  }
}
