<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\WeatherByLocationController;
use App\Http\Controllers\AirController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\WeatherTriggerController;
use App\Services\WeatherService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [MainController::class , 'index'])->name('home');
//delet!
Route::get('/1', [WeatherService::class , 'checkTriggers'])->name('1');

Route::post('/location', [WeatherByLocationController::class , 'getWeatherByLocation'])->name('location');

Route::get('/air', [AirController::class , 'index'])->name('air');
Route::get('/air-in-city', [AirController::class , 'index'])->name('air-in-city');
Route::post('/air-in-city', [AirController::class , 'getHistAirData'])->name('air-in-city');
Route::post('/air-in-cities', [AirController::class , 'getHistAirDataOfCities'])->name('air-in-cities');

Route::middleware(['auth'])->group(function () {
    Route::prefix('/dashboard')->group(function(){
        Route::resource('triggers' , WeatherTriggerController::class)->except(['show']);
        Route::resource('locations' , LocationController::class)->except(['show', 'update', 'edit']);

        Route::get('/messages', [WeatherTriggerController::class , 'showMessages'])->name('triggers.messages');
    });

});


require __DIR__.'/auth.php';
