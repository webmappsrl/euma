<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class TrailsController extends Controller
{
    public function trailsgeojsonexport() {
        Artisan::call('eumadb:trails-geojson-generator');
        $path = storage_path('exporter/geojson/trails/trails.geojson');
        return response()->download($path, 'trails.geojson', ['Content-type' => 'application/json']);
    }
    
    public function trailscsvexport() {
        Artisan::call('eumadb:trails-csv-generator');
        $path = storage_path('exporter/csv/trails/trails.csv');
        return response()->download($path, 'trails.csv', ['Content-type' => 'text/csv']);
    }
}
