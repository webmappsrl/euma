<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ExternalDatabase extends Model
{
    use HasFactory;
    use HasTranslations;

    public $translatable = [
        'name'
    ];

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
}
