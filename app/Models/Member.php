<?php

namespace App\Models;

use App\Enums\MemberTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Query\Search\SearchableRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Member extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name_en',
        'name_orig',
        'acronym',
        'country',
        'web',
        'members',
        'since',
        'type'
    ];


    /**
     * Indicates whether Nova should check for modifications between viewing and updating a resource.
     *
     * @var bool
     */
    public static $trafficCop = false;


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'type' => MemberTypeEnum::class,
        'trail_network_location' => TrailNetworkLocation::class,
        'other_trails_users' => AsEnumCollection::class . ':' . TrailUserTypes::class,
        'trails_maintenance_done_by' => AsEnumCollection::class . ':' . MaintenanceOperatorTypes::class,
        'contact_completion_date' => 'datetime:Y-m-d'

    ];

    /**
     * Get the searchable columns for the resource.
     *
     * @return array
     */
    public static function searchableColumns()
    {
        return ['id', new SearchableRelation('member', 'acronym')];
    }

    public function huts()
    {
        return $this->hasMany(Hut::class);
    }

    public function trails()
    {
        return $this->hasMany(Trail::class);
    }

    public function climbingRockAreas()
    {
        return $this->hasMany(ClimbingRockArea::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function HutSurvey()
    {
        return $this->hasOne(HutSurvey::class);
    }

    public function TrailSurvey()
    {
        return $this->hasOne(TrailSurvey::class);
    }

    public function CragSurvey()
    {
        return $this->hasOne(CragSurvey::class);
    }

    /**
     * Return the json version of the hut, avoiding the geometry
     *
     * @return array
     */
    public function getJson(): array
    {
        $array = [];

        if ($this->id) {
            $array['id'] = $this->id;
        }

        if ($this->name_en) {
            $array['name_en'] = $this->name_en;
        }

        if ($this->name_orig) {
            $array['name_orig'] = $this->name_orig;
        }

        if ($this->acronym) {
            $array['acronym'] = $this->acronym;
        }

        if ($this->country) {
            $array['country'] = $this->country;
        }

        if ($this->web) {
            $array['web'] = $this->web;
        }

        if ($this->members) {
            $array['members'] = $this->members;
        }

        if ($this->since) {
            $array['since'] = $this->since;
        }

        if ($this->type) {
            $array['type'] = $this->type;
        }

        if ($this->operating_phone) {
            $array['operating_phone'] = $this->operating_phone;
        }

        if ($this->icon) {
            $array['icon'] = url(Storage::url($this->icon));
        }

        return $array;
    }
}
