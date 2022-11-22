<?php

namespace App\Models;

use App\Traits\GeometryFeatureTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Translatable\HasTranslations;

class ClimbingRockArea extends Model
{
    use HasFactory;
    use HasTranslations;
    use GeometryFeatureTrait;

    public $translatable = [
        'name',
        'description',
        'alternative_name',
        'local_rules_description',
        'local_rules_document',
        'local_restrictions_description'
    ];

    protected $fillable = [
        'name',
        'description',
        'geometry',
        'alternative_name',
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
        'member_id'
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
     * Return the json version of the hut, avoiding the geometry
     *
     * @return array
     */
    public function getJson(): array
    {
        $array = [];
        
        if ($this->name)
            $array['name'] = $this->name;
        
        if ($this->alternative_name)
            $array['alternative_name'] = $this->alternative_name;

        if ($this->description)
            $array['description'] = $this->description;

        if ($this->elevation)
            $array['elevation'] = $this->elevation;

        if ($this->url)
            $array['url'] = $this->url;

        if ($this->local_rules_url)
            $array['local_rules_url'] = $this->local_rules_url;

        if ($this->local_rules_description)
            $array['local_rules_description'] = $this->local_rules_description;

        if ($this->local_rules_document)
            $array['local_rules_document'] = $this->local_rules_document;

        if ($this->local_restrictions)
            $array['local_restrictions'] = $this->local_restrictions;

        if ($this->local_restrictions_description)
            $array['local_restrictions_description'] = $this->local_restrictions_description;

        if ($this->location_quality)
            $array['location_quality'] = $this->location_quality;
        
        if ($this->routes_number)
            $array['routes_number'] = $this->routes_number;

        if ($this->member_id) {
            $array['member_id'] = $this->member_id;
            $member = Member::find($this->member_id);
            $array['member_acronym'] = $member->acronym;
        }

        return $array;
    }
}
