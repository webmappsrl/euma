<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class Hut extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'official_name',
        'second_official_name',
        'description',
        'geometry',
        'geobox_location',
        'elevation',
        'geobox_elevation',
        'url',
        'geobox_feature_image',
        'managed',
        'address',
        'operating_name',
        'operating_email',
        'operating_phone',
        'owner',
        'member_id',
        'import_id'
    ];

    public function member() {
        return $this->belongsTo(Member::class);
    }

    public function externalDatabases(){
        return $this->belongsToMany(ExternalDatabase::class);
    }

    /**
     * Create a geojson from the hut
     *
     * @return array
     */
    public function getGeojson(): ?array
    {
        $feature = $this->getEmptyGeojson();
        if (isset($feature["properties"])) {
            $feature["properties"] = $this->getJson();

            return $feature;
        } else return null;
    }

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

    /**
     * Return the json version of the hut, avoiding the geometry
     *
     * @return array
     */
    public function getJson(): array
    {
        $array = [];
        
        if ($this->official_name)
            $array['official_name'] = $this->official_name;
        
        if ($this->second_official_name)
            $array['second_official_name'] = $this->second_official_name;

        if ($this->description)
            $array['description'] = $this->description;

        if ($this->elevation)
            $array['elevation'] = $this->elevation;

        if ($this->url)
            $array['url'] = $this->url;

        if ($this->managed)
            $array['managed'] = $this->managed;

        if ($this->address)
            $array['address'] = $this->address;

        if ($this->operating_name)
            $array['operating_name'] = $this->operating_name;

        if ($this->operating_email)
            $array['operating_email'] = $this->operating_email;

        if ($this->operating_phone)
            $array['operating_phone'] = $this->operating_phone;

        if ($this->owner)
            $array['owner'] = $this->owner;

        if ($this->member_id) {
            $array['member_id'] = $this->member_id;
            $member = Member::find($this->member_id);
            $array['member_acronym'] = $member->acronym;
        }

        return $array;
    }
}
