<?php
namespace App\Services;

use App\Models\WeatherTrigger;
use App\Api\Weather;
use Illuminate\Support\Facades\Notification;
use App\Notifications\WeatherAlert;

class WeatherService
{
    protected $weatherApi;

    public function __construct(Weather $weatherApi)
    {
        $this->weatherApi = $weatherApi;
    }

    public function checkTriggers()
    {
        $triggers = WeatherTrigger::where('status', 'active')->get();

        foreach ($triggers as $trigger) {
            $location = $trigger->getLocation();
            $dailyWeather = $this->weatherApi->location($location)->getDaily();

            $period = $trigger->period;
            $parameter  = $trigger->parameter;

            if ($parameter == 'temp') {
                $this->checkParamTemp($dailyWeather, $trigger, $period);
            }else {
                for ($i=0; $i <= $period; $i++) { 
                    $dailyValue = $dailyWeather[$i]->$parameter;
                    $day = $dailyWeather[$i]->dt;
                    
                    if (($trigger->condition == 'above' && $dailyValue > $trigger->value) ||
                    ($trigger->condition == 'below' && $dailyValue < $trigger->value)) {
                    // Sending a notification to a user
                    $user = $trigger->user;
                    Notification::send($user, new WeatherAlert($trigger, $dailyValue, $day));
                    }
                }
            }
        }
    }

    public function checkParamTemp($dailyWeather, $trigger, $period)
    {
        for ($i=0; $i <= $period; $i++) { 
            $dailyTempMax = $dailyWeather[$i]->temp->max;
            $dailyTempMin = $dailyWeather[$i]->temp->max;
            $day = $dailyWeather[$i]->dt;
            
            if ($trigger->condition == 'above' && $dailyTempMax > $trigger->value){
                // Sending a notification to a user
                $user = $trigger->user;
                Notification::send($user, new WeatherAlert($trigger, $dailyTempMax, $day));
            }

            if ($trigger->condition == 'below' && $dailyTempMin < $trigger->value){
            // Sending a notification to a user
            $user = $trigger->user;
            Notification::send($user, new WeatherAlert($trigger, $dailyTempMin, $day));
            }
        }
    }
}
