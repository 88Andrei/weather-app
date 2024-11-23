<?php
namespace App\Api;

  class Weather
{
  private $baseURL = 'https://api.openweathermap.org/data/3.0/onecall';
  private $apiKey;

  private $location;
  private $units;
  private $defaultUnits = 'metric';
  private $format;
  private $requestURL;


   function __construct($locationData = null, $unitsName = null, $formatName = null)
  {
    $this->apiKey = env('OPENWEATHER_API_KEY');
    $this->location = $locationData;
    $this->units = $unitsName;
    $this->format = $formatName;

    $this->requestURL = $this->baseURL . '?appid=' . $this->apiKey;
  }

  public function location($locationObj)
  {
    return new self($locationObj, $this->units, $this->format);
  }

  public function units($unitsName)
  {
    return new self($this->location, $unitsName, $this->format);
  }

  public function getHourly()
  {
    return $this->getAll()->hourly;
  }

  public function getCurrent()
  {
    return $this->getAll()->current;
  }

  public function getDaily()
  {
    return $this->getAll()->daily;
  }

  public function getAll()
  {
    $requestURL = $this->bildURL();
    $result = $this->sendRequest($requestURL);
    return json_decode($result);
  }

  private function bildURL()
  {
    $requestURL = $this->requestURL;

    if($this->location != null){
      $requestURL .= '&lat='. $this->location->lat .'&lon=' . $this->location->lng;
    } else {
      throw new \Exception("No location was passed", 1);
    }

    if($this->units != null){
      $requestURL .= '&units=' . $this->units;
    } else {
      $requestURL .= '&units=' . $this->defaultUnits;
    }

    return $requestURL;
  }

  private function sendRequest($requestURL)
  {
    return file_get_contents($requestURL);
  }
}
