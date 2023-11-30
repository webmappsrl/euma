<?php

namespace App\Models;

use App\Enums\TrailUserTypes;
use App\Enums\MaintenanceOperatorTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;

class TrailSurvey extends Model
{
    protected $casts = [
        'other_trails_users' => AsEnumCollection::class . ':' . TrailUserTypes::class,
        'trails_maintenance_done_by' => AsEnumCollection::class . ':' . MaintenanceOperatorTypes::class,
    ];
    use HasFactory;

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
