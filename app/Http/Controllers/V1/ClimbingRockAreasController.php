<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ClimbingRockArea;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class ClimbingRockAreasController extends Controller
{

    /**
     * Return an array of ClimbingRockAreas ID and updated_at key and values.
     *
     * @return array
     */
    public function climbingrockareaslistid()
    {
        $list = [];

        $ClimbingRockAreas = ClimbingRockArea::all();

        if (count($ClimbingRockAreas) > 0) {
            foreach ($ClimbingRockAreas as $crag) {
                $list[$crag['id']] = \Carbon\Carbon::parse($crag['updated_at'])->toDateTimeString();
            }
        } else {
            array_push($list, 'No ClimbingRockAreas found');
        }
        return $list;
    }

    /**
     * Return a downloadable geojson file of all climbing rock areas.
     *
     * @return JsonResponse
     */
    public function climbingrockareasgeojsonexport($member_id = null)
    {
        if ($member_id) {
            Artisan::call('eumadb:climbing-rock-areas-geojson-generator', ['member_id' => $member_id]);
            $path = storage_path('exporter/geojson/climbing_rock_areas/' . $member_id . '/climbing_rock_areas.geojson');
        } else {
            Artisan::call('eumadb:climbing-rock-areas-geojson-generator');
            $path = storage_path('exporter/geojson/climbing_rock_areas/climbing_rock_areas.geojson');
        }
        return response()->download($path, 'climbingrockareas.geojson', ['Content-type' => 'application/json']);
    }

    /**
     * Return an array of single climbing rock area geojson api based on the updated_at date as parameter.
     *
     * @param int $updated_at
     *
     * @return array
     */
    public function climbingrockareasslistlastupdate(int $updated_at = null)
    {
        $list = [];

        // \Carbon\Carbon::parse('2022-10-24 09:43:04')->timestamp;

        if ($updated_at) {
            $updated_at_string = \Carbon\Carbon::parse($updated_at)->toDateTimeString();
            $ClimbingRockAreas = ClimbingRockArea::where('updated_at', '>', $updated_at_string)->get();
        } else {
            $ClimbingRockAreas = ClimbingRockArea::all();
        }

        if (count($ClimbingRockAreas) > 0) {
            foreach ($ClimbingRockAreas as $crag) {
                array_push($list, url('/') . '/api/v1/climbingrockarea/geojson/' . $crag->id);
            }
        } else {
            array_push($list, 'No ClimbingRockAreas where updated after ' . $updated_at_string);
        }
        return $list;
    }


    /**
     * Return climbing rock areas GEOJSON.
     *
     * @param Request $request
     * @param int     $id
     * @param array   $headers
     *
     * @return JsonResponse
     */
    public function climbingrockareasgeojsonefeature(Request $request, int $id, array $headers = []): JsonResponse
    {
        $crag = ClimbingRockArea::find($id);
        if (is_null($crag))
            return response()->json(['code' => 404, 'error' => "Not Found"], 404);

        return response()->json($crag->getGeojson(), 200, $headers);
    }
}
