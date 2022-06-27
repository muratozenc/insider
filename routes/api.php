<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\FixtureController;
use App\Http\Controllers\Api\StandingController;
use App\Http\Controllers\Api\NationController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\PredictionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->group(function () {
    Route::resource('teams', TeamController::class);
    Route::resource('fixtures', FixtureController::class);
    Route::resource('predictions', PredictionController::class);
    Route::get('play-next-week', [MatchController::class, 'playSelectedWeek']);
    Route::get('play-all-weeks', [MatchController::class, 'playAllWeeks']);
    Route::get('reset-data', [MatchController::class, 'resetData']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
