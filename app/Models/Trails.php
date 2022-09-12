<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trails extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'geometry',
        'geobox_location',
    ];
}
