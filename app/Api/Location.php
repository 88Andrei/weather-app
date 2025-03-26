<?php
namespace App\Api;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class Location
{
  private const BASE_URL = "https://geocode.search.hereapi.com/v1/geocode";
  private $apiKey;

  public function __construct()
  {
    $this->apiKey = config('services.hereapi.key');
  }

  public function getCityData($cityName): array
  {
    $city = urlencode($cityName);

    $url = $this->buildURL($city);
    $result = $this->sendRequest($url);

    return $result;
  }

  private function sendRequest($url)
  {
    $response = Http::retry(2, 100)->get($url);


    if (!$response->successful()) {
      throw new ApiException("API request failed with status: " . $response->status());
    }
    
    $cityData = json_decode($response)->items;

    if (empty($cityData)) {
      throw new ApiException("No data about the city. Check the city name or try again later");
    }

    return $cityData;

  }

  private function buildURL($city)
  {
    $requestURL = self::BASE_URL . '?apiKey=' . $this->apiKey .'&q=' . $city;

    return $requestURL;
  }
}
