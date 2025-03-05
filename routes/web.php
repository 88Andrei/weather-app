<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WeatherByLocationController;
use App\Http\Controllers\AirController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherTriggerController;


Route::get('/', [MainController::class , 'index'])->name('home');

Route::get('/weather', [MainController::class , 'weather'])->name('weather');

Route::post('/location', [WeatherByLocationController::class , 'getWeatherByLocation'])->name('location');

Route::get('/air', [AirController::class , 'index'])->name('air');
Route::get('/air-in-city', [AirController::class , 'index'])->name('air-in-city');
Route::post('/air-in-city', [AirController::class , 'getHistAirData'])->name('air-in-city');
Route::post('/air-in-cities', [AirController::class , 'getHistAirDataOfCities'])->name('air-in-cities');

Route::middleware(['auth'])->group(function () {
    Route::prefix('/dashboard')->group(function(){
        Route::get('/home', [DashboardController::class, 'home'])->name('dashboard');

        Route::resource('triggers' , WeatherTriggerController::class)->except(['show']);
        Route::resource('locations' , LocationController::class)->except(['show', 'update', 'edit']);

        Route::get('/messages', [WeatherTriggerController::class , 'showMessages'])->name('triggers.messages');
    });

});


require __DIR__.'/auth.php';
