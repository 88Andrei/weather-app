<?php

namespace App\Listeners;

use App\Events\WeatherTriggerCreated;
use App\Services\WeatherTriggerService;

class RunWeatherTriggerService
{
    private $WeatherTriggerService;

    public function __construct(WeatherTriggerService $WeatherTriggerService)
    {
        $this->WeatherTriggerService = $WeatherTriggerService;
    }

    public function handle(WeatherTriggerCreated $event)
    {
        $userTrigger = $event->weatherTrigger;

        //Start WeatherTriggerService when a new trigger is created
        $this->WeatherTriggerService->checkTrigger($userTrigger);
    }
}
