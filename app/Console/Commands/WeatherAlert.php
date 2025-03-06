<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
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
        app(WeatherService::class)->checkAllTriggers();
        $this->info('Weather trigger check successfully!');
    }
}
