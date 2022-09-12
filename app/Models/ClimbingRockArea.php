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
        'local_restrictions_desctription'
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
        'local_restrictions_desctription',
        'parking_position',
        'location_quality',
        'routes_number',
        'nearest_town',
        'geobox_location',
        'elevation',
        'geobox_elevation',

    ];
}
