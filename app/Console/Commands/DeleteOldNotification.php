<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notification;

class DeleteOldNotification extends Command
{
    protected $signature = 'oldnotification:delete';

    protected $description = 'Delete all old weatherTrigger notification';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(Notification $notifications)
    {
        $notifications = DatabaseNotification::where('type', 'App\Notifications\WeatherAlert')->get();
        $notifications->markAsRead();

        $this->info('Old notifications delete successfully!');
    }
}
