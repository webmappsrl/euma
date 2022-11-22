<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Symm\Gisconverter\Gisconverter;
use function PHPUnit\Framework\arrayHasKey;

trait GeometryFeatureTrait {
    /**
     * Calculate the geojson of a model with only the geometry
     *
     * @return array
     */
    public function getEmptyGeojson(): ?array {
        $model = get_class($this);
        $geom = $model::where('id', '=', $this->id)
            ->select(
                DB::raw("ST_AsGeoJSON(geometry) as geom")
            )
            ->first()
            ->geom;

        if (isset($geom)) {
            return [
                "type" => "Feature",
                "properties" => [],
                "geometry" => json_decode($geom, true)
            ];
        } else
            return null;
    }
}
