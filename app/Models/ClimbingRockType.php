<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ClimbingRockType extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'name',
        'description'
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    public function climbingRockAreas(){
        return $this->belongsToMany(ClimbingRockArea::class,'climbing_rock_area_climbing_rock_type');
    }
}
