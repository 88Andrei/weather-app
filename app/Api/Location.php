<?php
namespace App\Api;

  class Location
{
  private $baseURL = "https://geocode.search.hereapi.com/v1/geocode";
  private $apiKey;
  private $city;
  private $requestURL;

  function __construct($city = null)
    {
      $this->apiKey = env('HERE_API_KEY');
      $this->city = urlencode($city);
      $this->requestURL = $this->baseURL . '?apiKey=' . $this->apiKey;
    }

    public function city($city)
    {
      return new self($city);
    }

    public function parseResult($result)
    {
      return json_decode($result)->items;
    }

    public function getAll()
    {
      $requestURL = $this->bildURL();
      $result = $this->sendRequest($requestURL);
      return $this->parseResult($result);
    }

    public function getLocation()
    {
      $CityData = $this->getAll();
      $location = $CityData[0]->position;

      return $location;
    }

    private function bildURL()
    {
      $requestURL = $this->requestURL;

      if($this->city != null){
        $requestURL .= '&q=' . $this->city;
      } else {
        throw new \Exception("No location was passed", 1);
      }
      return $requestURL;
    }

    private function sendRequest($requestURL)
    {
      return file_get_contents($requestURL);
    }

}
