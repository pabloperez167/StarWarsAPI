<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('starship', 'App\Http\Controllers\StarshipController@showStarships');

Route::get('starship/{id}', 'App\Http\Controllers\StarshipController@getStarshipxid');

Route::put('deletePilot/{id}', 'App\Http\Controllers\StarshipController@deletePilot');

Route::post('addPilot/{id}', 'App\Http\Controllers\StarshipController@addPilotToStarship');

;
