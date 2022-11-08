<?php

use App\Http\Controllers\V1\ClimbingRockAreasController;
use App\Http\Controllers\V1\HutsController;
use App\Http\Controllers\V1\TrailsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::name('api.')->group(function () {
    Route::prefix('v1')->name('v1')->group(function () {
        Route::get('/huts/geojson', [HutsController::class, 'hutsgeojsonexport'])->name('hutsgeojsonexport');
        Route::get('/climbingrockareas/geojson', [ClimbingRockAreasController::class, 'climbingrockareasgeojsonexport'])->name('climbingrockareasgeojsonexport');
        Route::get('/trails/geojson', [TrailsController::class, 'trailsgeojsonexport'])->name('trailsgeojsonexport');
        Route::get('/trails/csv', [TrailsController::class, 'trailscsvexport'])->name('trailscsvexport');
    });
});