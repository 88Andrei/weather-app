<?php
namespace App\Api;
use App\Api\Location;

class Air
{
  private $baseURL = 'http://api.openweathermap.org/data/2.5/air_pollution/history';
  private $apiKey;

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
    // $locationData = $cityData->getLocation();
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
}
