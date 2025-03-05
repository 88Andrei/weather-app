<?php

namespace App\Listeners;

use App\Events\WeatherTriggerCreated;
use App\Services\WeatherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunWeatherService
{
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function handle(WeatherTriggerCreated $event)
    {
        $userTrigger = $event->weatherTrigger;

        //Start WeatherService when a new trigger is created
        $this->weatherService->checkTrigger($userTrigger);
    }
}
