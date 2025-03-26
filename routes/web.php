<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\AirController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherTriggerController;


Route::get('/', [MainController::class , 'index'])->name('home');

Route::get('/weather', [WeatherController::class , 'index'])->name('weather');
Route::post('/location-weather', [WeatherController::class , 'getWeatherByLocation'])->name('weather_in_city');

Route::get('/air', [AirController::class , 'index'])->name('air');
Route::post('/air-in-city', [AirController::class , 'airDataByCity'])->name('air_in_city');
Route::post('/air-in-cities', [AirController::class , 'airDataByTwoCities'])->name('air_in_cities');

Route::middleware(['auth', 'has.location'])->group(function () {
    Route::prefix('/dashboard')->group(function(){
        Route::get('/home', [DashboardController::class, 'home'])->name('dashboard');
        Route::get('/tariff', function(){
            return view('dashboard.tariff');
        })->name('tariff');

        Route::resource('triggers' , WeatherTriggerController::class)->except(['show']);
        Route::resource('locations' , LocationController::class)->except(['show', 'update', 'edit']);

        Route::get('/messages', [WeatherTriggerController::class , 'showMessages'])->name('triggers.messages');
    });

});


require __DIR__.'/auth.php';
