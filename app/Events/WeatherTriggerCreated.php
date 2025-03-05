<?php

namespace App\Events;

use App\Models\WeatherTrigger;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WeatherTriggerCreated
{
    use Dispatchable, SerializesModels;

    public $weatherTrigger;

    public function __construct(WeatherTrigger $weatherTrigger)
    {
        $this->weatherTrigger = $weatherTrigger;
    }
}
