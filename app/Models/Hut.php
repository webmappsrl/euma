<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'name',
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
    ];
}
