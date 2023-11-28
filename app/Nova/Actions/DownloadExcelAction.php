<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Nova\Http\Requests\NovaRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class DownloadExcelAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $export = new class($models) implements FromCollection
        {
            protected $models;

            public function __construct($models)
            {
                $this->models = $models;
            }

            public function collection()
            {
                // Get the first model's attributes to use as headers
                $headers = array_keys($this->models->first()->getAttributes());

                // Map the models to their attributes
                $rows = $this->models->map(function ($model) {
                    // Get the model's attributes
                    $attributes = $model->getAttributes();

                    // If the model has a 'geometry' attribute, convert it to WKT format
                    if (isset($attributes['geometry'])) {
                        $attributes['geometry'] = DB::select("SELECT ST_AsText(?) AS geometry", [$attributes['geometry']])[0]->geometry;
                    }

                    // Convert boolean values to strings
                    foreach ($attributes as $key => $value) {
                        if (is_bool($value)) {
                            $attributes[$key] = $value ? 'true' : 'false';
                        }
                    }

                    return $attributes;
                });

                // Prepend the headers to the rows
                return $rows->prepend($headers);
            }
        };
        $filename = '';
        if ($models->first() instanceof \App\Models\Hut) {
            $filename = 'huts_' . now()->format('d_m_Y') . '.xlsx';
        } elseif ($models->first() instanceof \App\Models\ClimbingRockArea) {
            $filename = 'crags_' . now()->format('d_m_Y') . '.xlsx';
        }

        Excel::store($export, $filename, 'public');

        return Action::download(url('storage/' . $filename), $filename);
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [];
    }
}
