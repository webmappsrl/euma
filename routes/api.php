<?php

use App\Http\Controllers\V1\ClimbingRockAreasController;
use App\Http\Controllers\V1\HutsController;
use App\Http\Controllers\V1\MemberController;
use App\Http\Controllers\V1\StatisticController;
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
            Route::get('list', [HutsController::class, 'hutslistid'])->name('hutslistid');
            Route::get('geojson/member/{member_id?}', [HutsController::class, 'hutsgeojsonexport'])->name('hutsgeojsonexport');
            Route::get('geojson/{id}', [HutsController::class, 'hutgeojsonefeature'])->name('hutgeojsonefeature');
            Route::get('updated_at/{updated_at?}', [HutsController::class, 'hutslistlastupdate'])->name('hutslistlastupdate');
        });
        Route::prefix('climbingrockarea')->name('climbingrockarea.')->group(function () {
            Route::get('list', [ClimbingRockAreasController::class, 'climbingrockareaslistid'])->name('climbingrockareaslistid');
            Route::get('geojson/member/{member_id?}', [ClimbingRockAreasController::class, 'climbingrockareasgeojsonexport'])->name('climbingrockareasgeojsonexport');
            Route::get('geojson/{id}', [ClimbingRockAreasController::class, 'climbingrockareasgeojsonefeature'])->name('climbingrockareasgeojsonefeature');
            Route::get('updated_at/{updated_at?}', [ClimbingRockAreasController::class, 'climbingrockareasslistlastupdate'])->name('climbingrockareasslistlastupdate');
        });
        Route::prefix('trail')->name('trail.')->group(function () {
            Route::get('list', [TrailsController::class, 'trailslistid'])->name('trailslistid');
            Route::get('geojson', [TrailsController::class, 'trailsgeojsonexport'])->name('trailsgeojsonexport');
            Route::get('csv/member/{member_id?}', [TrailsController::class, 'trailscsvexport'])->name('trailscsvexport');
            Route::get('geojson/{id}', [TrailsController::class, 'trailgeojsonefeature'])->name('trailgeojsonefeature');
            Route::get('updated_at/{updated_at?}', [TrailsController::class, 'trailslistlastupdate'])->name('trailslistlastupdate');
        });
        Route::prefix('statistic')->name('statistic.')->group(function () {
            Route::get('eumadb', [StatisticController::class, 'eumadbstatistics'])->name('eumadbstatistics');
        });
        Route::prefix('member')->name('member.')->group(function () {
            Route::get('collection/{type?}', [MemberController::class, 'membercollection'])->name('membercollection');
        });
    });
});
