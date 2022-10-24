<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class ClimbingRockAreasController extends Controller
{
    public function climbingrockareasgeojsonexport() {
        Artisan::call('eumadb:climbing-rock-areas-geojson-generator');
        $path = storage_path('exporter/geojson/climbing_rock_areas/climbing_rock_areas.geojson');
        return response()->download($path, 'climbingrockareas.geojson', ['Content-type' => 'application/json']);
    }
}
