<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class HutsController extends Controller
{
    public function hutsgeojsonexport() {
        Artisan::call('eumadb:huts-geojson-generator');
        $path = storage_path('exporter/geojson/huts/huts.geojson');
        return response()->download($path, 'huts.geojson', ['Content-type' => 'application/json']);
    }
}
