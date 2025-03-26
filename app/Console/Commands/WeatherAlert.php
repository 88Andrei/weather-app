<?php

namespace App\Console\Commands;

use App\Services\WeatherTriggerService;
use Illuminate\Console\Command;

class WeatherAlert extends Command
{
    protected $signature = 'weathertrigger:check';

    protected $description = 'Check all weather triggers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        app(WeatherTriggerService::class)->checkAllTriggers();
        $this->info('Weather trigger check successfully!');
    }
}
