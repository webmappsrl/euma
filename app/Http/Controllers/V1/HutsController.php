<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hut;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class HutsController extends Controller
{
    public function hutsgeojsonexport() {
        Artisan::call('eumadb:huts-geojson-generator');
        $path = storage_path('exporter/geojson/huts/huts.geojson');
        return response()->download($path, 'huts.geojson', ['Content-type' => 'application/json']);
    }
    
    public function hutslistlastupdate( int $updated_at) {
        $list = [];

        $updated_at_string = \Carbon\Carbon::parse($updated_at)->toDateTimeString();
        // \Carbon\Carbon::parse('2022-10-24 09:43:04')->timestamp;

        if ($updated_at_string) {
            $huts = Hut::where('updated_at', '>', $updated_at_string)->get();
        } else {
            $huts = Hut::all();
        }

        if (count($huts) > 0) {
            foreach ($huts as $hut) {
                array_push($list, url('/').'/api/v1/huts/geojson/'.$hut->id);
            }
        } else {
            array_push($list, 'No huts where updated after '.$updated_at_string);
        }
        return $list;
    }
    
    /**
     * Return Huts GEOJSON.
     *
     * @param Request $request
     * @param int     $id
     * @param array   $headers
     *
     * @return JsonResponse
     */
    public function hutgeojsonefeature(Request $request, int $id, array $headers = []): JsonResponse {
        $hut = Hut::find($id);
        if (is_null($hut))
            return response()->json(['code' => 404, 'error' => "Not Found"], 404);

        return response()->json($hut->getGeojson(), 200, $headers);
    }
}
