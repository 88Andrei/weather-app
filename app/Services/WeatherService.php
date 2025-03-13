<?php
namespace App\Services;

use App\Models\WeatherTrigger;
use App\Api\Weather;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeatherAlert;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected $weatherApi;

    public function __construct(Weather $weatherApi)
    {
        $this->weatherApi = $weatherApi;
    }

    public function checkTrigger($trigger)
    {
        $location = $trigger->getLocation();

        // Cache the daily weather data for 1 hour
        $dailyWeather = Cache::remember(
            'Weather_location_' . $trigger->location_id,  
            now()->addHours(1),
            fn() => $this->weatherApi->location($location)->getDaily()
        );

        // Get the relevant weather data for the trigger period
        $relevantWeatherData = array_slice($dailyWeather, 0, $trigger->period + 1);

        $this->checkTriggerConditions($relevantWeatherData, $trigger);        
    }

    public function checkAllTriggers()
    {
        $triggers = WeatherTrigger::where('status', 'active')->with('location')->get();

        foreach ($triggers as $trigger) {
            $this->checkTrigger($trigger);
        }
    }

    private function checkTriggerConditions($weatherData, $trigger)
    {
        $user = $trigger->user;

        foreach ($weatherData as $dayWeather) {
            $value = $trigger->parameter === 'temp'
            //if the parameter is temperature, get the max or min temperature based on the condition
            ? ($trigger->condition === 'above' ? $dayWeather->temp->max : $dayWeather->temp->min)
            //otherwise, get the value of the parameter
            : $dayWeather->{$trigger->parameter};

            if (($trigger->condition === 'above' && $value > $trigger->value) ||
                ($trigger->condition === 'below' && $value < $trigger->value)) {
                Notification::send($user, new WeatherAlert($trigger, $value, $dayWeather->dt));
            }
        }
    }
}
