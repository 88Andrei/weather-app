<?php
namespace App\Api;
use App\Api\Location;

class Air
{
  private $baseURL = 'http://api.openweathermap.org/data/2.5/air_pollution/history';
  private $apiKey;

  //maximum period in hours during which data is not averaged to a day
  private $period = 48;
  private $location;
  private $start;
  private $end;
  private $cityTitle;

   function __construct($locationData = null,  $startDate = null , $endDate = null, $cityTitle = null)
  {
    $this->apiKey = env('OPENWEATHER_API_KEY');
    $this->location = $locationData;
    $this->start = $startDate;
    $this->end = $endDate;
    $this->cityTitle = $cityTitle;

    $this->requestURL = $this->baseURL . '?appid=' . $this->apiKey;
  }

  public function location($city)
  {
    $locationApi = new Location;
    $cityData = $locationApi->city($city)->getAll();
    $cityTitle = $cityData[0]->title;
    $location = $cityData[0]->position;

    $locationData = [];
    $locationData[] = $location->lat;
    $locationData[] = $location->lng;
    return new self($locationData, $this->start, $this->end , $cityTitle);
  }

  public function start($timeStart)
  {
    return new self($this->location, $timeStart, $this->end , $this->cityTitle);
  }

  public function end($timeEnd)
  {
    return new self($this->location, $this->start, $timeEnd , $this->cityTitle);
  }

  public function parseResult($result)
  {
    return json_decode($result);
  }

  public function getAll()
  {
    $requestURL = $this->bildURL();
    $result = $this->sendRequest($requestURL);
    $airData = $this->parseResult($result);
    if (count($airData->list) > $this->period) {
      $airData->list =  $this->getArrDailyAverages($airData->list);
    }
    $airData->cityTitle = $this->cityTitle;
    return $airData;
  }

  private function bildURL()
  {
    $requestURL = $this->requestURL;

    if($this->location != null){
      $requestURL .= '&lat='. $this->location[0] .'&lon=' . $this->location[1];
    } else {
      throw new \Exception("No location was passed", 1);
    }

    if($this->start != null){
      $requestURL .= '&start=' . $this->start;
    } else {
      throw new \Exception("No time start was passed", 1);
    }

    if ($this->end != null) {
      $requestURL .= '&end=' . $this->end;
    } else {
      throw new \Exception("No time end was passed", 1);
    }

    return $requestURL;
  }

  private function sendRequest($requestURL)
  {
    return file_get_contents($requestURL);
  }

  public function getArrDailyAverages($err)
  {
    for ($i=0; $i < count($err) ; $i += 24) {
      $dayErr = array_slice($err , $i , 24);
      $daysData[] = $this->getDailyAverage($dayErr);
    }
    return $daysData;
  }

  public function getDailyAverage($err)
  {
    $aqiSum = 0;
    $aqiSum = 0;
    $coSum = 0;
    $noSum = 0;
    $no2Sum = 0;
    $o3Sum = 0;
    $so2Sum = 0;
    $pm2_5Sum = 0;
    $pm10Sum = 0;
    $nh3Sum = 0;

    foreach ($err as $hours) {
      $aqiSum += $hours->main->aqi;
      $coSum += $hours->components->co;
      $noSum += $hours->components->no;
      $no2Sum += $hours->components->no2;
      $o3Sum += $hours->components->o3;
      $so2Sum += $hours->components->so2;
      $pm2_5Sum += $hours->components->pm2_5;
      $pm10Sum += $hours->components->pm10;
      $nh3Sum += $hours->components->nh3;
      $data = $hours;
    }

    $data->main->aqi = round($aqiSum/24);
    $data->components->co = round($coSum/24 , 2);
    $data->components->no = round($noSum/24 , 2);
    $data->components->no2 = round($no2Sum/24 , 2);
    $data->components->o3 = round($o3Sum/24 , 2);
    $data->components->so2 = round($so2Sum/24 , 2);
    $data->components->pm2_5 = round($pm2_5Sum/24 , 2);
    $data->components->pm10 = round($pm10Sum/24 , 2);
    $data->components->nh3 = round($nh3Sum/24 , 2);

    return $data;
  }
}
