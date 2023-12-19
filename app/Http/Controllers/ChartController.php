<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
  public function getChartForDailyWeather($deilyWeather)
  {
    //generated data arrays for the chart
    foreach ($deilyWeather as $dayWeather) {
      $date = date('d.m.y', $dayWeather->dt);

      $daysErr[] =   $date;
      $dayTempErr[]= $dayWeather->temp->day;
      $nightTempErr[]= $dayWeather->temp->night;
    }
    //for coordinate line X
    $data['x'] = $daysErr;
    //for coordinates line Y
    $data['Ys'][0]['label'] = 'Day temperature';
    $data['Ys'][0]['data'] =  $dayTempErr;

    $data['Ys'][1]['label'] = 'Night temperature';
    $data['Ys'][1]['data'] =  $nightTempErr;

    return $data;
  }

  public function getChartForHourlyWeather($haurlyWeather)
  {
    //generated data arrays for the chart
    foreach ($haurlyWeather as $hourWeather) {
      $time = date('H:i d.M', $hourWeather->dt);

      $timeErr[] = $time;
      $tempsErr[] = $hourWeather->temp;
      $feelsTempsErr[] = $hourWeather->feels_like;
    }
    //for coordinate line X
    $data['x'] = $timeErr;
    //for coordinate line Y
    $data['Ys'][0]['label'] = 'Temperature';
    $data['Ys'][0]['type'] =  'line';
    $data['Ys'][0]['data'] =  $tempsErr;

    $data['Ys'][1]['label'] = 'Feels temperature';
    $data['Ys'][1]['type'] =  'line';
    $data['Ys'][1]['data'] =  $feelsTempsErr;

    return $data;
  }
  public function getAirChartFor2Cities($airDatas)
  {
    //generated data arrays for the chart
    foreach ($airDatas as $hourData) {
      $time = date('H:i d.M', $hourData->dt);

      $timeErr[] = $time;
      $aqiErr[] = $hourData->main->aqi;
      $aqi1Err[] = $hourData->main1->aqi;
      $aqiCollorErr [] = $this->getCollAqi($hourData->main->aqi);
      $aqiCollor1Err [] = $this->getCollAqi($hourData->main1->aqi);
    }
    //for coordinate line X
    $data['x'] = $timeErr;
    //for coordinate line Y
    $data['Ys'][0]['label'] = 'Air Quality Index in city #1';
    $data['Ys'][0]['type'] = 'line';
    $data['Ys'][0]['data'] = $aqiErr;
  //  $data['Ys'][0]['backgroundColor'] = $aqiCollorErr;

    $data['Ys'][1]['label'] = 'Air Quality Index  in city #2';
    $data['Ys'][1]['type'] = 'line';
    $data['Ys'][1]['data'] = $aqi1Err;
    //$data['Ys'][1]['backgroundColor'] = $aqiCollor1Err;
    return $data;
  }

  public function getAirChart($airData)
  {
    //generated data arrays for the chart
    foreach ($airData as $hourData) {
      $time = date('H:i d.M', $hourData->dt);

      $timeErr[] = $time;
      $aqiErr[] = $hourData->main->aqi;
      $aqiCollorErr [] = $this->getCollAqi($hourData->main->aqi);
    }
    //for coordinate line X
    $data['x'] = $timeErr;
    //for coordinate line Y
    $data['Ys'][0]['label'] = 'Air Quality Index';
    $data['Ys'][0]['data'] = $aqiErr;
    $data['Ys'][0]['backgroundColor'] = $aqiCollorErr;
    return $data;
  }

  public function getCollAqi($aqi)
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

//усреднение до дня
  // public function sliceData($err)
  // {
  //   for ($i=0; $i < count($err) ; $i += 24) {
  //     $er1[] = array_slice($err , $i , 24);
  //   }
  //
  //   return $er1;
  // }
  //
  // public function averageToDay($err)
  // {
  //   $aqiSum = 0;
  //   foreach ($err as  $day) {
  //     foreach ($day as $hours) {
  //       $aqiSum += $hours->main->aqi;
  //       // $coSum += $hours->components->co;
  //       // $noSum += $hours->components->no;
  //       // $no2Sum += $hours->components->no2;
  //       // $o3Sum += $hours->components->o3;
  //       // $so2Sum += $hours->components->so2;
  //       // $pm2_5Sum += $hours->components->pm2_5;
  //       // $pm10Sum += $hours->components->pm10;
  //       // $nh3Sum += $hours->components->nh3;
  //     }
  //     $aqiDay = $aqiSum;
  //   }
  //   $err2[] = $aqiDay;
  //   return $err2;
  // }

}
