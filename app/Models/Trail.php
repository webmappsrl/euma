<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Trail extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'name'
    ];

    protected $fillable = [
        'name',
        'ref',
        'url',
        'source_geojson_url',
        'source_gpx_url',
        'geometry',
        'geobox_location',
        'member_id',
        'import_id'
    ];

    public function externalDatabases(){
        return $this->belongsToMany(ExternalDatabase::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
