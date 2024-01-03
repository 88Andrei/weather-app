<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\HourlyWeatherController;
use App\Http\Controllers\WeatherByLocationController;
use App\Http\Controllers\ExController;
use App\Http\Controllers\AirController;

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
Route::post('/location', [WeatherByLocationController::class , 'getCityDataFromApi'])->name('location');

Route::post('/choose-city', [WeatherByLocationController::class , 'setCityData'])->name('choose-city');

Route::get('/air', [AirController::class , 'index'])->name('air');
Route::get('/air-in-city', [AirController::class , 'index'])->name('air-in-city');
Route::post('/air-in-city', [AirController::class , 'getHistAirData'])->name('air-in-city');
Route::post('/air-in-cities', [AirController::class , 'getHistAirDataOfCities'])->name('air-in-cities');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
