<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeatherAlert extends Notification implements ShouldQueue
{
    use Queueable;

    protected $trigger; 
    protected $currentValue;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trigger, $currentValue)
    {
        $this->trigger = $trigger; 
        $this->currentValue = $currentValue;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Weather Alert Notification') 
        ->greeting('Hello!') 
        ->line('There is a new weather alert for your location.') 
        ->line('City: ' . $this->trigger->city) 
        ->line('Parameter: ' . $this->trigger->parameter) 
        ->line('Current Value: ' . $this->currentValue) 
        ->line('Condition: ' . $this->trigger->condition) 
        ->line('Threshold Value: ' . $this->trigger->value) 
        ->action('View Details', url('/')) 
        ->line('Thank you for using Weather-App!');
    }

    public function toDatabase($notifiable) 
    { 
        $messages = $this->trigger->constructMessage($this->currentValue);
        return [ 
            'trigger_id' => $this->trigger->id, 
            'current_value' => $this->currentValue, 
            'messages' => $messages,
        ]; 
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'trigger_id' => $this->trigger->id, 
            'current_value' => $this->currentValue,
        ];
    }
}
