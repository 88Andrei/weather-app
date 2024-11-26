<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lat', 'lng', 'user_id'];

    public function User()
    {
        return $this->belongsTo(User::class);;
    }

    public function weatherTriggers()
    {
        return $this->hasMany(WeatherTrigger::class);
    }
}
