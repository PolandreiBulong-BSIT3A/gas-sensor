<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::get('/', [SensorController::class, 'index'])->name('sensor.dashboard');
Route::get('/sensor/{sensor}/history/{page?}', [SensorController::class, 'showSensorData'])
    ->where('page', '[0-9]+')
    ->name('sensor.history');

