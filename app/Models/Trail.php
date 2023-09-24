<?php

namespace App\Models;

use App\Traits\GeometryFeatureTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Trail extends Model
{
    use HasFactory;
    use GeometryFeatureTrait;
    use Searchable;

    protected $fillable = [
        'ref',
        'url',
        'source_geojson_url',
        'source_gpx_url',
        'geometry',
        'geobox_location',
        'member_id',
        'import_id',
        'original_name',
        'english_name'
    ];

    public function externalDatabases()
    {
        return $this->belongsToMany(ExternalDatabase::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $member = Member::find($this->member_id);
        return [
            'id' => (int) $this->id,
            'name' => $this->original_name,
            'english_name' => $this->english_name,
            'url' => $this->url,
            'ref' => $this->ref,
            'member_name' => $member->name_en,
            'member_acronym' => $member->acronym,
        ];
    }

    /**
     * Create a geojson from the trail
     *
     * @return array
     */
    public function getGeojson(): ?array
    {
        $feature = $this->getEmptyGeojson();
        if (isset($feature["properties"])) {
            $feature["properties"] = $this->getJson();
            $slope = json_decode($this->slope, true);
            if (isset($slope) && count($slope) === count($feature['geometry']['coordinates'])) {
                foreach ($slope as $key => $value) {
                    $feature['geometry']['coordinates'][$key][3] = $value;
                }
            }

            return $feature;
        } else {
            return null;
        }
    }

    /**
     * Return the json version of the trail, avoiding the geometry
     *
     * @return array
     */
    public function getJson(): array
    {
        $array = [];
        $array['name'] = '';
        if (empty($array['name']) && $this->original_name) {
            $array['name'] = $this->original_name;
        }
        if (empty($array['name']) && $this->english_name) {
            $array['name'] = $this->english_name;
        }

        if ($this->ref) {
            $array['ref'] = $this->ref;
        }

        if ($this->url) {
            $array['url'] = $this->url;
        }

        if ($this->member_id) {
            $array['member_id'] = $this->member_id;
            $member = Member::find($this->member_id);
            $array['member_acronym'] = $member->acronym;
        }

        return $array;
    }
}
