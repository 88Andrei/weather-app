<?php
namespace App\Api;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Http;

class Air
{
  private const BASE_URL = 'http://api.openweathermap.org/data/2.5/air_pollution';
  private string $apiKey;
  private ?object $coord;
  private ?int $start = null;
  private ?int $end = null;
  private ?string $endPoint = null;

  protected function __construct($endPoint)
  {
    $this->apiKey = config('services.openweather.key');
    $this->endPoint = $endPoint;
  }

  public static function history()
  {
    return new self('/history'); 
  }

  public static function forecast()
  {
    return new self('/forecast'); 
  }

  public function location(object $coord): self
  {
    $this->coord = $coord;

    return $this;
  }

  public function start(int $timeStart): self
  {
    $this->start = $timeStart;
    return $this;
  }

  public function end(int $timeEnd): self
  {
    $this->end = $timeEnd ;
    return $this;
  }

  public function getAll(): object
  {
    $url = $this->buildUrl();

    $airData = $this->sendRequest($url);
    return $airData;
  }

  private function buildUrl(): string
  {
    $baseUrl = self::BASE_URL . $this->endPoint;
    $params = [
      'appid' => $this->apiKey,
      'lat' => $this->coord->lat ?? null,
      'lon' => $this->coord->lng ?? null,
    ];

    if ($this->endPoint === '/history') {
      $params['start'] = $this->start;
      $params['end'] = $this->end;
    }
     
     if (in_array(null, $params, true)) {
        throw new ApiException("Required parameters are missing.");
    }

    return $baseUrl . '?' . http_build_query($params);
  }

  private function sendRequest($url)
  {
    $response = Http::retry(2, 100)->get($url);
    if (!$response->successful()) {
      throw new ApiException("API request failed with status: " . $response->status());
    }

    $airData = json_decode($response);

    if (empty($airData->list)) {
      throw new ApiException("No air pollution data available.");
    }

    return $airData;
  }
}
