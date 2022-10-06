<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ClimbingRockArea extends Model
{
    use HasFactory;
    use HasTranslations;

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
        'url'
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
}
