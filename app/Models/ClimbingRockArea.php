<?php

namespace App\Models;

use App\Traits\GeometryFeatureTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Spatie\Translatable\HasTranslations;

class ClimbingRockArea extends Model
{
    use HasFactory;
    use HasTranslations;
    use GeometryFeatureTrait;
    use Searchable;

    public $translatable = [
        'description',
        'local_rules_description',
        'local_rules_document',
        'local_restrictions_description'
    ];

    protected $fillable = [
        'description',
        'geometry',
        'local_rules_url',
        'local_rules_description',
        'local_rules_document',
        'local_restricions',
        'local_restrictions_description',
        'parking_position',
        'location_quality',
        'routes_number',
        'nearest_town',
        'geobox_location',
        'elevation',
        'geobox_elevation',
        'url',
        'import_id',
        'member_id',
        'original_name',
        'english_name'
    ];

    protected $casts = [
        'location_quality' => 'int',
        'routes_number' => 'int',
        'elevation' => 'int',
        'geobox_elevation' => 'int'
    ];

    public function climbingStyles(){
        return $this->belongsToMany(ClimbingStyle::class,'climbing_rock_area_climbing_style');
    }
    
    public function climbingRockTypes(){
        return $this->belongsToMany(ClimbingRockType::class,'climbing_rock_area_climbing_rock_type');
    }
    
    public function member() {
        return $this->belongsTo(Member::class);
    }
    
    public function externalDatabases(){
        return $this->belongsToMany(ExternalDatabase::class)
            ->withPivot(['specific_url']);
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
     * Return the json version of the hut, avoiding the geometry
     *
     * @return array
     */
    public function getJson(): array
    {
        $array = [];
        
        $array['name'] = '';
        if (empty($array['name']) && $this->original_name) {
            $array['name'] = $this->original_name;
        }
        if (empty($array['name']) && $this->english_name) {
            $array['name'] = $this->english_name;
        }

        if ($this->description)
            $array['description'] = $this->getTranslations('description');

        if ($this->elevation)
            $array['elevation'] = $this->elevation;

        if ($this->url)
            $array['url'] = $this->url;

        if ($this->local_rules_url)
            $array['local_rules_url'] = $this->local_rules_url;

        if ($this->local_rules_description)
            $array['local_rules_description'] = $this->getTranslations('local_rules_description');

        if ($this->local_rules_document)
            $array['local_rules_document'] = $this->local_rules_document;

        if ($this->local_restrictions)
            $array['local_restrictions'] = $this->local_restrictions;

        if ($this->local_restrictions_description)
            $array['local_restrictions_description'] = $this->getTranslations('local_restrictions_description');

        if ($this->location_quality)
            $array['location_quality'] = $this->location_quality;
        
        if ($this->routes_number)
            $array['routes_number'] = $this->routes_number;

        if ($this->member_id) {
            $array['member_id'] = $this->member_id;
            $member = Member::find($this->member_id);
            $array['member_acronym'] = $member->acronym;
        }

        if (!empty($this->climbingStyles)) {
            foreach ($this->climbingStyles as $key => $style) {
                $array['styles'][$key]['name'] = $style->name; 
                $array['styles'][$key]['description'] = $style->description; 
            }
        }
        
        if (!empty($this->climbingRockTypes)) {
            foreach ($this->climbingRockTypes as $key => $type) {
                $array['types'][$key]['name'] = $type->name; 
                $array['types'][$key]['description'] = $type->description; 
            }
        }
        
        if (!empty($this->externalDatabases)) {
            foreach ($this->externalDatabases as $key => $database) {
                if (array_key_exists('pivot', $database->toArray())) {
                    unset($database['pivot']);
                }
                $database = array_filter($database->toArray(), fn($value) => !is_null($value) && $value !== '' && $value !== false);
                $array['external_databases'][$key] = $database; 
            }
        }
        
        if (!empty($this->parking_position)) {
            $geom = $this->parking_position;
            $geojson = DB::select("SELECT ST_AsGeojson('$geom')")[0]->st_asgeojson;
            if ($geojson) {
                $json = json_decode($geojson);
                $array['parking_position'] = $json->coordinates;
            }
        }

        return $array;
    }
}
