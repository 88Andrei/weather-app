<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherTrigger extends Model
{
    use HasFactory;

    public $fillable = [
        'id', 'name', 'parameter', 'condition', 'value', 'period', 'status', 'user_id', 'location_id',
    ];

    public function User() 
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function getLocation()
    {
        $location = (object)[
            'lat' => $this->location->lat,
            'lng' => $this->location->lng,
        ];

        return $location;
    }

    protected $parameterLabels = [
        'temp' => 'Temperature',
        'wind_speed' => 'Wind Speed',
        'humidity' => 'Humidity',
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
        'humidity' => '%',
    ];

    /**
     * Generates a trigger title and description
     *
     * @param float $currentValue Current value of the parameter
     * @return string
     */
    public function constructMessage($currentValue)
    {
        $parameterName = $this->parameterLabels[$this->parameter] ?? $this->parameter;
        $conditionText = $this->conditionLabels[$this->condition] ?? $this->condition;
        $unit = $this->parameterUnits[$this->parameter] ?? '';

        $title = "{$parameterName} {$conditionText} {$this->value}{$unit} at {$this->location->name}";

        $description = "For location {$this->location->name} trigger '{$this->name}' with condition {$parameterName} {$conditionText} {$this->value}{$unit} was activated with value {$currentValue}{$unit}";

        return [
            'title' => $title,
            'description' => $description,
        ];
    }

    /**
     * Generates a description of the condition
     *
     * @return string
     */
    public function descriptionOftCondition()
    {
        $parameterName = $this->parameterLabels[$this->parameter] ?? $this->parameter;
        $conditionText = $this->conditionLabels[$this->condition] ?? $this->condition;
        $unit = $this->parameterUnits[$this->parameter] ?? '';

        $description = "{$parameterName} {$conditionText} {$this->value}{$unit}";

        return  $description;
    }

}
