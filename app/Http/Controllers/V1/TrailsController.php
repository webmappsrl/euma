<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Trail;
use App\Traits\ControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;


class TrailsController extends Controller
{
    use ControllerTrait;

    /**
     * Return an array of trails ID and updated_at key and values.
     *
     * @return array
     */
    public function trailslistid(Request $request) {
        $list = [];

        $per_page = 1000;

        if ($request->per_page) {
            $per_page = $request->per_page;
        }

        $trails = Trail::all();

        $list = $trails->pluck('id')->toArray();

        // if (count($trails) > 0) {
        //     foreach ($trails as $trail) {
        //         $list[$trail['id']] = \Carbon\Carbon::parse($trail['updated_at'])->toDateTimeString();
        //     }
        // } else {
        //     array_push($list, 'No trails found');
        // }
        

        return $this->paginate($list,$per_page);
    }

    /**
     * Return a downloadable geojson file of all trails.
     *
     * @return JsonResponse
     */
    public function trailsgeojsonexport() {
        Artisan::call('eumadb:trails-geojson-generator');
        $path = storage_path('exporter/geojson/trails/trails.geojson');
        return response()->download($path, 'trails.geojson', ['Content-type' => 'application/json']);
    }

    /**
     * Return a downloadable csv file of all trails without geometry.
     *
     * @return JsonResponse
     */
    public function trailscsvexport() {
        Artisan::call('eumadb:trails-csv-generator');
        $path = storage_path('exporter/csv/trails/trails.csv');
        return response()->download($path, 'trails.csv', ['Content-type' => 'text/csv']);
    }

    /**
     * Return an array of single trails geojson api based on the updated_at date as parameter.
     *
     * @param int $updated_at
     *
     * @return array
     */
    public function trailslistlastupdate( int $updated_at = null ) {
        $list = [];

        // \Carbon\Carbon::parse('2022-10-24 09:43:04')->timestamp;
        
        if ($updated_at) {
            $updated_at_string = \Carbon\Carbon::parse($updated_at)->toDateTimeString();
            $trails = Trail::where('updated_at', '>', $updated_at_string)->get();
        } else {
            $trails = Trail::all();
        }

        if (count($trails) > 0) {
            foreach ($trails as $trail) {
                array_push($list, url('/').'/api/v1/trail/geojson/'.$trail->id);
            }
        } else {
            array_push($list, 'No trails where updated after '.$updated_at_string);
        }
        return $list;
    }

    
    /**
     * Return Trails GEOJSON.
     *
     * @param Request $request
     * @param int     $id
     * @param array   $headers
     *
     * @return JsonResponse
     */
    public function trailgeojsonefeature(Request $request, int $id, array $headers = []): JsonResponse {
        $trail = Trail::find($id);
        if (is_null($trail))
            return response()->json(['code' => 404, 'error' => "Not Found"], 404);

        return response()->json($trail->getGeojson(), 200, $headers);
    }
}
