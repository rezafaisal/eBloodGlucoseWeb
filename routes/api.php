<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BloodGlucoseController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\WeightReadingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'store']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/me', [ProfileController::class, 'show']);
    Route::patch('/me', [ProfileController::class, 'update']);

    Route::get('/me/settings', [SettingController::class, 'show']);
    Route::patch('/me/settings', [SettingController::class, 'update']);

    Route::get('/blood-glucose', [BloodGlucoseController::class, 'index']);
    Route::post('/blood-glucose', [BloodGlucoseController::class, 'store']);
    Route::get('/blood-glucose/list', [BloodGlucoseController::class, 'listReadings']);
    Route::get('/blood-glucose/history', [BloodGlucoseController::class, 'bloodGlucoseHistory']);

    Route::post('/weight-readings', [WeightReadingController::class, 'store']);
    Route::get('/weight-readings/history', [WeightReadingController::class, 'weightHistory']);
});
