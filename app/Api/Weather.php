<?php
namespace App\Api;

use App\Exceptions\ApiException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;

class Weather
{
  private $baseURL = 'https://api.openweathermap.org/data/3.0/onecall';
  private $apiKey;

  private $coord = null;
  private $units = null;
  private $lang;
  private $defaultUnits = 'metric';
  private $defaultLang = 'en';

  public function __construct()
  {
    $this->apiKey = config('services.openweather.key');;
  }

  public function location(object $coord): self
  {
    $this->coord = $coord;
    return $this;
  }

  public function units(string $units): self
  {
    $this->units = $units;
    return $this;
  }

  public function language(string $lang): self
  {
    $this->lang = $lang;
    return $this;
  }

  public function getAll()
  {
    $url = $this->buildURL();
    try {
      $response = Http::retry(2, 100)->get($url);
      if ($response->successful()) {
          $data = json_decode($response);

          if (isset($data->hourly, $data->daily, $data->current)) {
            return $data;
        }
        throw new ApiException("Incorrect data from Weathre API. Try again later");
      }

    } catch (RequestException $e) {
      throw new ApiException("Request error: " . $e->getMessage());
    }
  }

  public function getHourly(): array
  {
    return $this->getAll()->hourly;
  }

  public function getCurrent(): object
  {
    return $this->getAll()->current;
  }

  public function getDaily(): array
  {
    return $this->getAll()->daily;
  }

  private function buildURL()
  {
    $baseURL = $this->baseURL;

    if(!$this->coord){
      throw new ApiException("No location was provided.");
    } 

    $params = [
      'appid' => $this->apiKey,
      'lat' => $this->coord->lat,
      'lon' => $this->coord->lng,
      'units' => $this->units ?? $this->defaultUnits,
      'lang' => $this->lang ?? $this->defaultLang,
    ];
     
    return $baseURL . '?' .  http_build_query($params);
  }
}
