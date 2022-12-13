<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalDatabase extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'mobile_app_os' => 'array',
    ];

    public function climbingRockAreas(){
        return $this->belongsToMany(ClimbingRockArea::class);
    }
    
    public function huts(){
        return $this->belongsToMany(Hut::class);
    }
    
    public function trails(){
        return $this->hasMany(Trail::class);
    }
}
