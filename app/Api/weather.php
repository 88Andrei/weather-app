<?php
namespace App\Api;

  class Weather
{
  private $baseURL = 'https://api.openweathermap.org/data/2.5/onecall';
  private $apiKey;

  private $location;
  private $units;
  private $defaultUnits = 'metric';
  private $format;
  private $defaultFormat = 'json';


   function __construct($locationData = null, $unitsName = null, $formatName = null)
  {
    $this->apiKey = env('OPENWEATHER_API_KEY');
    $this->location = $locationData;
    $this->units = $unitsName;
    $this->format = $formatName;

    $this->requestURL = $this->baseURL . '?appid=' . $this->apiKey;
  }

  public function location($lat , $lon)
  {
    $locationData = [];
    $locationData[] = $lat;
    $locationData[] = $lon;
    return new self($locationData, $this->units, $this->format);
  }

  public function units($unitsName)
  {
    return new self($this->location, $unitsName, $this->format);
  }

  public function getCurrent()
  {
    return $this->getAll()->current;
  }

  public function getDaily()
  {
    return $this->getAll()->daily;
  }

  public function parseResult($result)
  {
    if (($this->format == 'xml') || ($this->defaultFormat == 'xml') && (!$this->format)) {
      return $this->parsXML($result);
    }

    return json_decode($result);
  }

  private function getAll()
  {
    $requestURL = $this->bildURL();
    $result = $this->sendRequest($requestURL);
    return $this->parseResult($result);
  }

  private function bildURL()
  {
    $requestURL = $this->requestURL;

    if($this->location != null){
      $requestURL .= '&lat='. $this->location[0] .'&lon=' . $this->location[1];
    } else {
      throw new \Exception("No location was passed", 1);
    }

    if($this->units != null){
      $requestURL .= '&units=' . $this->units;
    } else {
      $requestURL .= '&units=' . $this->defaultUnits;
    }

    if ($this->format == 'xml' || $this->defaultFormat == 'xml' && (!$this->format)) {
      $requestURL .= '&mode=xml';
    }

    return $requestURL;
  }

  private function sendRequest($requestURL)
  {
    return file_get_contents($requestURL);
  }
}
