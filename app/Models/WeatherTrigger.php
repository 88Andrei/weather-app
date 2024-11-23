<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherTrigger extends Model
{
    use HasFactory;

    public $fillable = [
        'id', 'name', 'city', 'parameter', 'condition', 'value', 'period', 'status', 'user_id',
    ];

    public function User() 
    {
        return $this->belongsTo(User::class);
    }
    protected $parameterLabels = [
        'temp' => 'Temperature',
        'wind_speed' => 'Wind Speed',
        'Humidity' => 'Humidity',
    ];

    // Parameter map for displaying readable titles
    protected $conditionLabels = [
        'above' => 'rises above',
        'below' => 'falls below',
    ];

    // Map of units of measurement for parameters
    protected $parameterUnits = [
        'temp' => '°C',
        'wind_speed' => 'm/s',
        'Humidity' => '%',
    ];

    /**
     * Generates a trigger description
     *
     * @param float $currentValue Current value of the parameter
     * @return string
     */
    public function constructMessage($currentValue)
    {
        $parameterName = $this->parameterLabels[$this->parameter] ?? $this->parameter;
        $conditionText = $this->conditionLabels[$this->condition] ?? $this->condition;
        $unit = $this->parameterUnits[$this->parameter] ?? '';

        $title = "{$parameterName} {$conditionText} {$this->value}{$unit} at {$this->city}";

        $description = "For location {$this->city} trigger '{$this->name}' with condition {$parameterName} {$conditionText} {$this->value}{$unit} was activated with value {$currentValue}{$unit}";

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

}
