<?php
namespace App\Services;

use App\Api\Location;
use App\Models\WeatherTrigger;
use App\Api\Weather;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeatherAlert;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected $weatherApi;
    protected $locationApi;

    public function __construct(Weather $weatherApi, Location $locationApi)
    {
        $this->weatherApi = $weatherApi;
        $this->locationApi = $locationApi;
    }

    public function checkTriggers()
    {
        $triggers = WeatherTrigger::all();

        foreach ($triggers as $trigger) {
            $location = $this->locationApi->city($trigger->city)->getLocation();

            $currentWeather = $this->weatherApi->location($location)->getCurrent();
            $parameter  = $trigger->parameter;
            $currentValue = $currentWeather->$parameter;

            if (($trigger->condition == 'above' && $currentValue > $trigger->value) ||
                ($trigger->condition == 'below' && $currentValue < $trigger->value)) {
                // Sending a notification to a user
                $user = $trigger->user;
                Notification::send($user, new WeatherAlert($trigger, $currentValue));
            }
        }
    }
}
