<?php

namespace App\Services;

use App\Api\Location;
use Illuminate\Support\Facades\Cache;

class CityService
{
    protected $locationApi;
    protected $cacheTime;

    public function __construct(Location $locationApi)
    {
        $this->locationApi = $locationApi;
        $this->cacheTime = config('cache.cache_time_for_city');
    }

    public function getCityData(string $cityName): \Illuminate\Support\Collection
    {
        $cityData = Cache::remember(
            'city_data_' . $cityName,
            $this->cacheTime,
            fn() => $this->locationApi->getCityData($cityName)
        );
    
        return collect($cityData);
    }

    public function getCoordinates($cityData): object
    {
        return $cityData->first()->position;
    }

    public function handleMultipleCities(object $cityData, array $params): \Illuminate\Contracts\View\View
    {
        $data = [
            'cityTitles' => $cityData->pluck('title')->toArray(),
            'actionRoute' => $params['actionRoute'] ?? 'default_route',
            'type' => $params['type'] ?? 'default_type',
        ];

        if (isset($params['weatherType'])) {
            $data['weatherType'] = $params['weatherType'];
        }

        if (isset($params['dateFrom']) && isset($params['dateTo'])) {
            $data['dateFrom'] = $params['dateFrom'];
            $data['dateTo'] = $params['dateTo'];
        }

        return view('choose-city', $data);
    }
}
