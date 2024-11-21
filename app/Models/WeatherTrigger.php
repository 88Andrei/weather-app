<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherTrigger extends Model
{
    use HasFactory;

    public $fillable = [
        'id',
        'name',
        'city',
        'parameter',
        'condition',
        'value',
        'period',
        'status',
        'user_id',
    ];

    public function User() 
    {
        return $this->belongsTo(User::class);
    }
}
