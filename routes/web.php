<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\SimulationController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [IndexController::class, 'init']);
Route::get('/reset', [IndexController::class, 'reset']);
Route::get('/standings', [IndexController::class, 'standings']);
Route::get('/fixtures', [IndexController::class, 'fixtures']);

Route::get('/prediction', [PredictionController::class, 'get']);

Route::put('/play', [SimulationController::class, 'playAll']);
Route::put('/play/{weekId}', [SimulationController::class, 'play']);
