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
    protected $date;

    public function __construct($trigger, $currentValue, $date)
    {
        $this->trigger = $trigger; 
        $this->currentValue = $currentValue;
        $this->date = date("Y-m-d H:i", $date);
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
            'date' => $this->date, 
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
