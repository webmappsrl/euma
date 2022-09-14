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
        'url',
        'geometry',
        'geobox_location',
    ];

    public function externalDatabases(){
        return $this->belongsToMany(ExternalDatabase::class);
    }

    public function member() {
        return $this->belongsTo(Member::class);
    }
}
