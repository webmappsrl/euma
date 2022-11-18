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
        Route::prefix('hut')->name('hut.')->group(function () {
            Route::get('geojson', [HutsController::class, 'hutsgeojsonexport'])->name('hutsgeojsonexport');
            Route::get('geojson/{id}', [HutsController::class, 'hutgeojsonefeature'])->name('hutgeojsonefeature');
            Route::get('updated_at/{updated_at}', [HutsController::class, 'hutslistlastupdate'])->name('hutslistlastupdate');
        });
        Route::prefix('climbingrockarea')->name('climbingrockarea.')->group(function () {
            Route::get('geojson', [ClimbingRockAreasController::class, 'climbingrockareasgeojsonexport'])->name('climbingrockareasgeojsonexport');
        });
        Route::prefix('trail')->name('trail.')->group(function () {
            Route::get('geojson', [TrailsController::class, 'trailsgeojsonexport'])->name('trailsgeojsonexport');
            Route::get('csv', [TrailsController::class, 'trailscsvexport'])->name('trailscsvexport');
        });
    });
});